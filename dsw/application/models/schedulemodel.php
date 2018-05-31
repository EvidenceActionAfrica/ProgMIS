<?php

class schedulemodel extends Database {

    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db) {

        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function getSchedule($table, $fieldsArray, $program) {

        $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
      ';
        $admin_territory_id = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id,
          territory_name, 
          territory_level
          FROM admin_territory
          WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
      ';
        $ancestors = $this->selectDBraw($query);


        $query = 'SELECT ';


        $i = sizeof($ancestors);
        $ancestorZ = array_reverse($ancestors);
        foreach ($ancestorZ as $key => $ancestor) {
            $query .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ',';

            $i--;
        }

        foreach ($fieldsArray as $key => $value) {
            $query .= $table . "." . $value . ',';
        }
        $query.='';


        $query = rtrim($query, ",");




        $query.=" from " . $table
                . ' LEFT JOIN admin_territory_details as t1 ON ' . $table . '.village_name=t1.id';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {

            $query .= ' LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';

            $j++;
        }

        $query.=" WHERE program='" . $program . "'";


        $query .= ' ORDER BY  field_officer_assigned,';
        $descendants = array_reverse($ancestors);
        $i = sizeof($descendants);
        foreach ($descendants as $key => $ancestor) {

            $query .=$ancestor['territory_name'] . ',';

            --$i;
        }

        $query = rtrim($query, ",");

        // echo $query;
        $data = $this->selectDBraw($query);

        return $data;
    }
    public function getProgramDropDown(){
            $query = 'SELECT dsw_programs.id,dsw_programs.program from dsw_programs JOIN site_verification
            ON site_verification.program=dsw_programs.program    
            WHERE dsw_programs.program !="" AND country='.$_SESSION['country'].' ORDER BY program ASC ';

        $data = $this->selectDBraw($query);

        return $data;  
    }
    public function checkSelectedCau($stage) {
        if ($stage == 'cem_gen_schedule') {
            $stage = 'dispenser_gen_schedule';
        }
        $query = 'SELECT * FROM  expansion_display_manager WHERE stage="' . $stage . '" AND country = ' . $_SESSION['country'];
        $data = $this->selectDBraw($query);

        $territory = array();
        if ($data != null) {
            foreach ($data as $key => $value) {
                $territoryName = $this->getCau($value["territory_name"]);
                array_push($territory, $territoryName[0]["territory_name"]);
            }
        }

        return $territory;
    }

    private function getCau($territoryId) {
        $query = 'SELECT territory_name
          FROM admin_territory
          WHERE id = ' . $territoryId . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
      ';

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getAssignedCau($table) {

        $query = 'SELECT * from field_officer_assignment WHERE stage="' . $table . '" AND country=' . $_SESSION['country'];
        // echo $query;
        $data = $this->selectDBraw($query);
        if (isset($data[0]['assign_field_officers_per'])) {
            $query = 'SELECT territory_name
          FROM admin_territory
          WHERE id = "' . $data[0]['assign_field_officers_per'] . '" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
        ';
            $specificCau = $this->selectDBraw($query);
        }
        $specificCau = isset($specificCau[0]['territory_name']) ? $specificCau[0]['territory_name'] : "village";
        //echo $specificCau;
        return $specificCau;
    }

    public function getSiteVerificationOfficers($table, $program) {

        $query = 'SELECT field_officer FROM ' . $table . ' WHERE ' . $table . '.program ="' . $program . '"';
        //echo $query;
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function deleteProgram($table) {
        $siteverificationId = explode('/', $_GET['url']);
        $program = $siteverificationId[3];
        //$query='DELETE from '.$table.' WHERE program="'.$program.'"';
        $data = array(
            "program" => $program
        );
        $data = $this->deleteDB($table, $data);

        return $data;
    }

    public function getData($table, $fieldsArray = null) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }
        }

        if (empty($fieldsArray) || $fieldsArray == null) {
            $query.=' * ';
        } else {
            $len = strlen($query);
            $lim = $len - 1;
            $query = substr($query, 0, $lim);
        }

        $query .= ' FROM ' . $table;

        //echo $query;
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getvillageDetails($table, $program, $fieldsArray) {


        $query = 'SELECT id
        FROM admin_territory
        WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
       ';

        $admin_territory_id = $this->selectDBraw($query)[0]['id'];


        $query = 'SELECT id
        FROM dsw_programs
        WHERE program ="' . $program . '"';
        //echo $query;
        $programId = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id,
          territory_name, 
          territory_level
          FROM admin_territory
          WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
        ';

        $ancestors = $this->selectDBraw($query);



        $query = 'SELECT  dsw_programs.program as programs,  ';



        $i = sizeof($ancestors);
        $ancestorZ = array_reverse($ancestors);
        foreach ($ancestorZ as $key => $ancestor) {
            $query .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ',';
            $i--;
        }

        foreach ($fieldsArray as $key => $value) {
            $query .= $table . "." . $value . ',';
        }
        $query = rtrim($query, ",");
        $query.='  from '
                . $table
                . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                . ' LEFT JOIN dsw_programs  ON ' . $table . '.program=dsw_programs.id'
                . ' LEFT JOIN admin_territory_details as t1 ON ' . $table . '.territory_id=t1.id';
        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= ' LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }
        $query.=' WHERE ' . $table . '.program=' . $programId . '';
//        $query .= ' ORDER BY '.$desiredCau.' ASC';
        //echo $query; 
        $data = $this->selectDBraw($query);
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit();
        return $data;
    }

    public function getvillageIdDetails($table, $program, $fieldsArray, $desiredCau) {


        $query = 'SELECT id
        FROM admin_territory
        WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
       ';

        $admin_territory_id = $this->selectDBraw($query)[0]['id'];


        $query = 'SELECT id
        FROM dsw_programs
        WHERE program ="' . $program . '"';
        //echo $query;
        $programId = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id,
          territory_name, 
          territory_level
          FROM admin_territory
          WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
        ';

        $ancestors = $this->selectDBraw($query);



        $query = 'SELECT  ';



        $i = sizeof($ancestors);
        $ancestorZ = array_reverse($ancestors);
        foreach ($ancestorZ as $key => $ancestor) {
            $query .= 't' . $i . '.id AS ' . $ancestor['territory_name'] . ',';
            $i--;
        }

        foreach ($fieldsArray as $key => $value) {

            $query .= $table . "." . $value . ',';
        }
        $query = rtrim($query, ",");
        $query.='  from '
                . $table
                . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                . ' LEFT JOIN admin_territory_details as t1 ON ' . $table . '.territory_id=t1.id';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= ' LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        //$query.=' WHERE program="'.$program.'"' ;                 
        $query.=' WHERE ' . $table . '.program=' . $programId . '';



        $query .= ' ORDER BY ' . $desiredCau . ' ASC';

        //echo $query; 
        $data = $this->selectDBraw($query);
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit();
        return $data;
    }

    //VCS
    public function getWaterpointvillageIdDetails($table2 = 'waterpoint_details', $program, $desiredCau) {


        $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
          ';

        $admin_territory_id = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id,
          territory_name, 
          territory_level
          FROM admin_territory
          WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
        ';

        $ancestors = $this->selectDBraw($query);



        // Lake victoria
        $latitude = '-0.607572';
        $longitude = '33.440312';

        $query = 'SELECT  ';




        $i = sizeof($ancestors);
        $ancestorZ = array_reverse($ancestors);
        foreach ($ancestorZ as $key => $ancestor) {
            $query .= 't' . $i . '.id AS ' . $ancestor['territory_name'] . ',';
            $i--;
        }


        $query.= $table2 . '.village as village_name ,' . $table2 . '.waterpoint_id,' . $table2 . '.waterpoint_name,

                (((acos(sin((' . $latitude . '*pi()/180))*sin((waterpoint_details.latitude*pi()/180))+cos((' . $latitude . '*pi()/180))*cos((waterpoint_details.latitude*pi()/180))*cos(((' . $longitude . '-waterpoint_details.longitude)*pi()/180))))*180/pi())*60*1.1515) as distance
                FROM '
                . $table2
                . ' LEFT JOIN admin_territory_details as t1 ON ' . $table2 . '.village=t1.id';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= ' LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }
        $query.=' WHERE ' . $table2 . '.program="' . $program . '"'
                . ' AND ' . $table2 . '.waterpoint_id !=""'
                . ' AND ' . $table2 . '.village !="" '
                . ' AND ' . $table2 . '.country=' . $_SESSION['country'] . ' GROUP BY ' . $table2 . '.village '
                . ' ORDER BY ' . $desiredCau . ' DESC';

        //   echo $query;
        //exit();
        $data = $this->selectDBraw($query);

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

        return $data;
    }

    public function getWaterpointvillageDetails2($table2 = 'waterpoint_details', $program) {

        // Lake victoria
        $latitude = '-0.607572';
        $longitude = '33.440312';

        $query = 'SELECT  ';
        $query.= $table2 . '.village,' . $table2 . '.waterpoint_id,

                (((acos(sin((' . $latitude . '*pi()/180))*sin((waterpoint_details.latitude*pi()/180))+cos((' . $latitude . '*pi()/180))*cos((waterpoint_details.latitude*pi()/180))*cos(((' . $longitude . '-waterpoint_details.longitude)*pi()/180))))*180/pi())*60*1.1515) as distance
                FROM '
                . $table2
                . ' WHERE ' . $table2 . '.program="' . $program . '"'
                . ' AND ' . $table2 . '.waterpoint_id !=""'
                . ' AND ' . $table2 . '.village !="" '
                . ' AND ' . $table2 . '.country=' . $_SESSION['country'] . ' GROUP BY ' . $table2 . '.village ' . ' ORDER BY distance DESC';

        // echo $query;
        //exit();
        $data = $this->selectDBraw($query);

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

        return $data;
    }

    public function getWaterpointvillageDetails($table2 = 'waterpoint_details', $program, $desiredCau) {


        $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
          ';

        $admin_territory_id = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id,
          territory_name, 
          territory_level
          FROM admin_territory
          WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
        ';

        $ancestors = $this->selectDBraw($query);



        // Lake victoria
        $latitude = '-0.607572';
        $longitude = '33.440312';

        $query = 'SELECT  ';




        $i = sizeof($ancestors);
        $ancestorZ = array_reverse($ancestors);
        foreach ($ancestorZ as $key => $ancestor) {
            $query .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ',';
            $i--;
        }


        $query.= $table2 . '.village as village_name ,' . $table2 . '.waterpoint_id,' . $table2 . '.waterpoint_name,

                (((acos(sin((' . $latitude . '*pi()/180))*sin((waterpoint_details.latitude*pi()/180))+cos((' . $latitude . '*pi()/180))*cos((waterpoint_details.latitude*pi()/180))*cos(((' . $longitude . '-waterpoint_details.longitude)*pi()/180))))*180/pi())*60*1.1515) as distance
                FROM '
                . $table2
                . ' LEFT JOIN admin_territory_details as t1 ON ' . $table2 . '.village=t1.id';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= ' LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }
        $query.=' WHERE ' . $table2 . '.program="' . $program . '"'
                . ' AND ' . $table2 . '.waterpoint_id !=""'
                . ' AND ' . $table2 . '.village !="" '
                . ' AND ' . $table2 . '.country=' . $_SESSION['country'] . ' GROUP BY ' . $table2 . '.village '
                . ' ORDER BY ' . $desiredCau . ' DESC';

        //   echo $query;
        //exit();
        $data = $this->selectDBraw($query);

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

        return $data;
    }

    public function getSurveyData($program) {

        $query = 'SELECT * from surveyor_temp WHERE program="' . $program . '"';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function addData($table, $data) {
        //array_pop($data);
        $dd = $this->insertdDB($table, $data);
    }

    public function getFields($table, $fieldsArray = null) {

        $fields = $this->getColMeta($table, $fieldsArray);
        //echo "<pre>";print_r($fields);echo "</pre>";
        return $fields;
    }

    public function getByPK($table, $id, $fieldsArray) {
        $dd = $this->selectDB(
                $table, $filds = $fieldsArray, $params = array('id' => $id)
        );
        return $dd;
    }

    public function getTruncated($table) {
        $sql = 'TRUNCATE TABLE ' . $table;
        $data = $this->selectDBraw($sql);
        return $data;
    }

    // public function getProgramDropDown(){
    //   $query='SELECT distinct program from village_details WHERE country='.$_SESSION['country'];
    //   $query.=' AND program!=""';
    //    $data = $this->selectDBraw($query);
    //     return $data;
    // }
    public function getProgramId($program) {

        $sql = 'SELECT id from dsw_programs WHERE program="' . $program . '"';
        $data = $this->selectDBraw($sql);
        return $data;
    }

    public function getStaffDropDown() {

        $query = 'SELECT distinct full_name from staff_list WHERE country=' . $_SESSION['country'];

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getCauName($desiredCauId) {
        $query = 'SELECT territory_name
          FROM admin_territory
          WHERE id = "' . $desiredCauId . '" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
      ';
        $data = $this->selectDBraw($query)[0]['territory_name'];
        return $data;
    }

    public function getVillageDropDown() {
        $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
      ';
        $admin_territory_id = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id,admin_territory_name from admin_territory_details WHERE admin_territory_id=' . $admin_territory_id;
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getcauDropDown($desiredCau) {

        $query = 'SELECT id,admin_territory_name from admin_territory_details WHERE admin_territory_id=' . $desiredCau;
        $query.=' ORDER BY admin_territory_name ASC';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getdefaultCauCode() {
        $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
      ';
        $data = $this->selectDBraw($query)[0]['id'];
        return $data;
    }

    public function getFieldOfficerAssignement($table) {

        $query = 'SELECT assign_field_officers_per from field_officer_assignment WHERE stage="' . $table . '" AND country=' . $_SESSION['country'];
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function runRawQuery($query) {
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function deleteData($table, $id) {

        // echo $id;
        // $query="DELETE FROM admin_assets WHERE id ='$id'";
        // $this->deleteDB($query,$id,'admin_assets');
        $dd = $this->deleteDB($table, $id);
        // echo "<pre>";var_dump($dd);echo "</pre>";
        // exit();
    }

    public function getLastURL($url) {
        $tokens = explode('/', $url);
        return $tokens[sizeof($tokens) - 1];
    }

}

?>