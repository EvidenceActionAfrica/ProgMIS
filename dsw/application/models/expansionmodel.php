<?php

class expansionmodel extends Database {

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
    public function getRequiredCau() {
            
        $query = 'SELECT id
            FROM admin_territory
            WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
        ';
        $admin_territory_id = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id,
            territory_name, 
            territory_level
            FROM admin_territory
            WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level ASC
        ';
         $data = $this->selectDBraw($query);

        return $data;
    }
   
    public function loadAllTerritories() {

        $query = 'SELECT cau_to_inspect
          FROM lsm_default_check
          WHERE country = ' . $_SESSION['country'];

        $data = $this->selectDBraw($query);
        $caucheck = isset($data[0]['cau_to_inspect']) ? $data[0]['cau_to_inspect'] : null;

        if ($caucheck == null) {
            return $caucheck;
        }


        $query = 'SELECT 
      admin_territory_details.id,
      admin_territory_details.admin_territory_name,
      admin_territory.territory_name as territory 
      from admin_territory_details';
        $query.=' JOIN admin_territory ON admin_territory_details.admin_territory_id=admin_territory.id 
      WHERE admin_territory.country_id = ' . $_SESSION['country'] . ' AND admin_territory_details.admin_territory_id=' . $caucheck . '
      ORDER by admin_territory_details.admin_territory_name';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function checkSelectedCau($stage) {
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

    public function TerritoriesSelected() {

        $query = 'SELECT territory_name
          FROM admin_territory JOIN lsm_default_check ON lsm_default_check.cau_to_inspect = admin_territory.id  
          WHERE country = ' . $_SESSION['country'];
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function readAllVerifications() {
        $query = 'SELECT territories
          FROM site_verification
          WHERE  country = ' . $_SESSION['country'];

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getLsmTerritories() {
        $query = 'SELECT distinct territory_id
          FROM lsm_details
          WHERE country = ' . $_SESSION['country'];

        $TerritoryId = $this->selectDBraw($query);
        $removeCounter = 0;
        $normalCounter = 0;
        if ($TerritoryId != null) {
            //Get Territory Name & Admin Territory Id that will be used to know the C.A.U level of the territory
            foreach ($TerritoryId as $key => $value) {

                if ($removeCounter != 0) {
                    unset($TerritoryId[$normalCounter - 1]);
                    $removeCounter = 0;
                }
                $query = 'SELECT admin_territory_id,admin_territory_name
            FROM admin_territory_details
            WHERE id = ' . $value['territory_id'];
                $territoryName = $this->selectDBraw($query);

                if ($territoryName != null) {
                    $TerritoryId[$key]["admin_territory_id"] = $territoryName[0]['admin_territory_id'];

                    $TerritoryId[$key]["territory_name"] = $territoryName[0]['admin_territory_name'];
                    //echo '<br/>';
                } else {
                    $removeCounter+=1;
                }
                ++$normalCounter;
            }
            if ($removeCounter != 0) {
                unset($TerritoryId[$normalCounter - 1]);
                $removeCounter = 0;
            }

            //Get The C.A.U Level of the territory and unset admin_territory_id 
            foreach ($TerritoryId as $key => $value) {

                $query = 'SELECT territory_name
          FROM admin_territory
          WHERE id = ' . $value['admin_territory_id'];

                $territoryName = $this->selectDBraw($query);
                $TerritoryId[$key]["territory_level"] = $territoryName[0]['territory_name'];
                unset($TerritoryId[$key]['admin_territory_id']);
                $territoryName = $TerritoryId[$key]["territory_name"];
                unset($TerritoryId[$key]["territory_name"]);
                $TerritoryId[$key]["territory_name"] = $territoryName;
            }
            $CauPrograms = $this->runAllCauProgram();

            $remove = 0;
            $TerritoryCounter = 0;


            return $TerritoryId;
        } else {
            return null;
        }
    }

    private function runAllCauProgram() {


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

        $query = 'SELECT  dsw_programs.program as program, ';

        $i = sizeof($ancestors);
        $ancestors = array_reverse($ancestors);
        foreach ($ancestors as $key => $ancestor) {
            $query .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ',';
            $query .= 't' . $i . '.id AS ' . $ancestor['territory_name'] . '_id,';

            $i--;
        }


        $query .= 'admin_countries.country AS country,
          t1.admin_territory_name as village
        ';
        $query .= ' FROM cau_programs
          JOIN admin_countries ON cau_programs.country = admin_countries.id 
          LEFT JOIN dsw_programs  ON cau_programs.program=dsw_programs.id
          LEFT JOIN admin_territory_details AS t1 ON cau_programs.territory_id = t1.id ';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 'LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query .= 'WHERE cau_programs.country = ' . $_SESSION['country']
                . '  ORDER BY ';
        $i = 1;
        foreach ($ancestors as $key => $ancestor) {
            $query .= $ancestor['territory_name'] . ',';
            $i++;
        }
        $query = rtrim($query, ",");
        $data = $this->selectDBraw($query);
        return $data;
    }

    private function getCau($territoryId) {
        $query = 'SELECT territory_name
          FROM admin_territory
          WHERE id = ' . $territoryId . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
      ';

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getGeneralData($table, $fieldsArray = null) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country
              FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id';
        } else {
            $query = 'SELECT * from ' . $table;
        }

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getWHEREData($table = 'lsm_details', $column = 'id', $WHERE = 1) {

        $query = 'SELECT * from ' . $table . ' WHERE ' . $column . ' like "%' . $WHERE . '%" AND ' . $column . '!=""';

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getWHEREStrictData($table = 'lsm_details', $column = 'id', $WHERE = 1) {

        $query = 'SELECT * from ' . $table . ' WHERE ' . $column . ' = "' . $WHERE . '" AND ' . $column . '!=""';

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getOdkData($table, $program) {
        $query = 'SELECT * from ' . $table . ' WHERE program = "' . $program . '"';

        $data = $this->selectDBraw($query);

        return $data;
    }

     public function getOdkDataRetrieve($table, $program) {
        $query = 'SELECT * from ' . $table . ' WHERE country = "' . $_SESSION['country'] . '" AND program = "' . $program . '"';

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getVillageId($villageName,$cauAbove=null) {

        $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
          ';

        $admin_territory_id = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id from admin_territory_details WHERE admin_territory_name="' . $villageName
                . '" AND admin_territory_id=' . $admin_territory_id ;
        //echo $query;
         $data = $this->selectDBraw($query);
        if(sizeof($data)>=2){
             $query = 'SELECT
                territory_name, 
                territory_level
                FROM admin_territory
                WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country']. ' ORDER BY territory_level DESC
            ';
        $ancestors = $this->selectDBraw($query);

        $query = 'SELECT ';

        $i = 1;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ', ';
            $i++;
        }

        $query .= 't1.id, 
                t1.admin_territory_id, 
                t1.territory_parent AS territory_parent_id ';

        $query .= 'FROM admin_territory_details as t1 ';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 'LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query .= 'WHERE t1.admin_territory_name = "' . $villageName . '"';


        // // $query.=' WHERE admin_territory_details.village="'.$villageName.'"';
        $k = 2;
        $cauAbove=unserialize($cauAbove);
         $cauAbove = array_reverse($cauAbove);
        foreach ($cauAbove as $key => $value) {
          $query.=' AND t'.$k.'.admin_territory_name ="'.$value.'"'; 
          $k++;
        }
    

         $data = $this->selectDBraw($query);

        }
       
        return $data;
      
    }
 
    public function getVillageInfo($villageId) {
        $query = ' SELECT * from village_details WHERE village_name=' . $villageId;

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getVerificationWHEREData($table, $fieldsArray = null, $column = 'id', $WHERE = 1) {

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

        $query .= 'admin_countries.country AS country';
        $query.='
                      FROM ' . $table
                . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                . ' LEFT JOIN admin_territory_details as t1 ON ' . $table . '.village_name=t1.id';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= ' LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query.=' WHERE ' . $table . '.' . $column . '="' . $WHERE . '"';



        $query .= ' ORDER BY ';
        $descendants = array_reverse($ancestors);
        foreach ($descendants as $key => $ancestor) {
            $query .=$ancestor['territory_name'] . ',';
        }

        $query = rtrim($query, ",");
//echo $query;
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getVcsWHEREData($table, $fieldsArray = null, $column = 'id', $WHERE = 1) {


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

        $query = rtrim($query, ",");

        $query .= ' FROM ' . $table
                . ' JOIN admin_territory_details as t1 ON ' . $table . '.village_name=t1.id';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= ' LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query.=' WHERE ' . $table . '.' . $column . '="' . $WHERE . '" ';
        $query .= ' ORDER BY ';
        $descendants = array_reverse($ancestors);
        foreach ($descendants as $key => $ancestor) {
            $query .=$ancestor['territory_name'] . ',';
        }

        $query = rtrim($query, ",");

        // echo $query;       
        $data = $this->selectDBraw($query);

        foreach ($data as $key => $value) {

            if ($value["people_present"] >= $value['prize_quorum']) {
                $data[$key]["won_present"] = "YES";
            } else {
                $data[$key]["won_present"] = "NO";
            }
        }



        return $data;
    }

    public function getDUTIESWHEREData($table = 'lsm_duties_details', $column = 'lsm_id', $WHERE = 1, $fieldsArray) {



        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }
            $query.=' staff_list.full_name as full_name';
            $query.=' from ' . $table;
            $query.=' JOIN staff_list on ' . $table . '.full_name=staff_list.id';

            $query.=' WHERE ' . $table . '.' . $column . '=' . $WHERE;


            $data = $this->selectDBraw($query);

            return $data;
        }
    }

    public function getpdfInfo($table, $program) {

        $query = 'SELECT * from ' . $table . ' WHERE program="' . $program . '"';



        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getpdfInfoCau($table, $fieldsArray, $program) {

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



        foreach ($fieldsArray as $key => $value) {
            $query .= $table . "." . $value . ',';
        }
        $query.='';

        $i = 1;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ',';
            $i++;
        }

        $query = rtrim($query, ",");

        $query.=" from " . $table
                . ' LEFT JOIN admin_territory_details as t1 ON ' . $table . '.village_name=t1.id';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= ' LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query.=" WHERE program='" . $program . "'";


        $query .= ' ORDER BY ';
        $descendants = array_reverse($ancestors);
        foreach ($descendants as $key => $ancestor) {
            $query .=$ancestor['territory_name'] . ',';
        }

        $query = rtrim($query, ",");
        // echo $query;
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getData($table, $fieldsArray = null) {

        $query = 'SELECT  ';
        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }
            $len = strlen($query);
            $lim = $len - 1;
            $query = substr($query, 0, $lim);
        } else {
            $query.=' * ';
        }



        $query.=' from ' . $table;
        $query.=' WHERE ' . $table . '.country=' . $_SESSION["country"] . ' ORDER by id ASC';
        // echo $query;
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function verifyVcsStatus($program) {

        $query = 'SELECT program from vcs_meetings_tracker WHERE program="' . $program . '"';
        $data = $this->selectDBraw($query);
        return sizeof($data);
    }

    public function getMeetingTerritories() {

        $query = 'SELECT territory_name from admin_territory WHERE country_id=' . $_SESSION['country'] . ' And territory_level<=6 ORDER BY territory_name';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getTerritoryInfo() {
        $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
          ';

        $admin_territory_id = $this->selectDBraw($query)[0]['id'];
        if ($admin_territory_id == null) {
            return null;
        }

        $query = 'SELECT territory_id from cau_programs ';
        $territoryIds = $this->selectDBraw($query);
        if ($territoryIds == null) {
            return null;
        }


        $query = 'SELECT  admin_territory_name, id from admin_territory_details WHERE admin_territory_id=' . $admin_territory_id;

        foreach ($territoryIds as $key => $value) {

            $query.=' AND id !=' . $value['territory_id'];
        }


        $query.=' GROUP BY admin_territory_name ORDER BY admin_territory_name ASC';
        //echo $query;

        $data = $this->selectDBraw($query);
        return $data;
    }
    public function getCauList($specificCau){
        $query='SELECT id,admin_territory_name from admin_territory_details WHERE admin_territory_id='.$specificCau
               .' ORDER BY admin_territory_name ASC';

        $data=$this->selectDBraw($query);
        return $data;
    }
    public function getTerritories() {

        $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_name ASC
          ';

        $admin_territory_id = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id,
          territory_name, 
          territory_level
          FROM admin_territory
          WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_name ASC
      ';


        $data = $this->selectDBraw($query);

        return $data;
    }

    public function confirmDisplayAdd($table, $stage, $territoryId = "null") {

        if ($table == 'field_officer_assignment') {
            $query = 'SELECT * from ' . $table . ' WHERE stage="' . $stage . '" AND country=' . $_SESSION['country'];
        } else {
            $query = 'SELECT * from ' . $table . ' WHERE stage="' . $stage . '" AND territory_name=' . $territoryId;
        }
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getCEMData($fieldsArray, $table = "community_education") {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {
            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }
            if (empty($fieldsArray)) {
                $query.=' * ';
            } else {
                $len = strlen($query);
                $lim = $len - 1;
                $query = substr($query, 0, $lim);
            }
            $query.=' from ' . $table;

            $query.=' WHERE ' . $table . '.country=' . $_SESSION['country'];
            $data = $this->selectDBraw($query);

            return $data;
        }
    }

    public function getDispenserInstallData($table, $fieldsArray = null) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {
            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }
            if (empty($fieldsArray)) {
                $query.=' * ';
            } else {
                $len = strlen($query);
                $lim = $len - 1;
                $query = substr($query, 0, $lim);
            }
            $query.=' from ' . $table;

            $query.=' WHERE ' . $table . '.country=' . $_SESSION['country'];
            $data = $this->selectDBraw($query);

            return $data;
        }
    }

    public function getOfficialsWHEREData($table, $fieldsArray, $WHERE) {


        $query = 'SELECT ';



        foreach ($fieldsArray as $key => $value) {
            $query .= $table . "." . $value . ',';
        }




        $query .= 'admin_countries.country AS country,t1.admin_territory_name

                    FROM ' . $table
                . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                . ' LEFT JOIN admin_territory_details as t1 ON ' . $table . '.territory_id=t1.id';

        $query.=' WHERE territory_id=' . $WHERE
                . ' AND admin_countries.id=' . $_SESSION["country"];

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getNonCountryData($table) {
        $query = 'SELECT * from ' . $table;

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getVcsData($table, $fieldsArray) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }
            $query .= 'admin_countries.country AS country

                    FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                    . ' AND admin_countries.id=' . $_SESSION["country"];
        }
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getDispenserData($table, $fieldsArray) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country,program_setup.program as program

                    FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                    . ' JOIN program_setup ON ' . $table . '.program = program_setup.id '
                    . ' AND admin_countries.id=' . $_SESSION["country"];
        }
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getdMaterialData($table, $fieldsArray, $program) {

        $query = 'SELECT ';



        foreach ($fieldsArray as $key => $value) {

            $query .= $table . "." . $value . ',';
        }
        if (empty($fieldsArray)) {
            $query.=' * ';
        } else {
            $len = strlen($query);
            $lim = $len - 1;
            $query = substr($query, 0, $lim);
        }
        $query .= '
           FROM '
                . $table
                . ' WHERE ' . $table . '.program="' . $program . '"';

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getDispenserOfficerData($table, $fieldsArray, $verificationId) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }

            if (empty($fieldsArray)) {
                $query.=' * ';
            } else {
                $len = strlen($query);
                $lim = $len - 1;
                $query = substr($query, 0, $lim);
            }
            $query .= '
           FROM '
                    . $table
                    . ' WHERE ' . $table . '.program="' . $verificationId . '"';
        }

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getTrackingDispenserData($table, $fieldsArray, $program) {
        $query = 'SELECT ';

        if (!empty($fieldsArray)) {
            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }
            $query.=' program_setup.program as program,staff_list.full_name as full_name';
            $query.=' from ' . $table;
            $query.=' JOIN program_setup on ' . $table . '.program=program_setup.id';
            $query.=' JOIN staff_list on ' . $table . '.full_name=staff_list.id';
            $query.=' WHERE ' . $table . '.program=' . $program;
            $data = $this->selectDBraw($query);

            return $data;
        }
    }
    public function getAllTerrritories(){


        $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
      ';
        $admin_territory_id = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id,territory_name,territory_level
          FROM admin_territory
          WHERE id <= ' . $admin_territory_id .' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level ASC
      ';
        $data = $this->selectDBraw($query);
        return $data;
    }
    public function getChildrenCau($childCAU,$parentClassCAU,$parentCau){

          $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "'.$childCAU.'" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
      ';
        $admin_territory_id = $this->selectDBraw($query)[0]['id'];

           $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "'.$parentClassCAU.'" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
      ';
        $parentClassId = $this->selectDBraw($query)[0]['id'];

         $query='SELECT id from admin_territory_details WHERE admin_territory_name="'
                .$parentCau.'" AND admin_territory_id='.$parentClassId;
        
        $parentId=$this->selectDBraw($query)[0]["id"];


        $query='SELECT admin_territory_name from admin_territory_details WHERE admin_territory_id='.$admin_territory_id
        .' AND territory_parent='.$parentId;

        $data=$this->selectDBraw($query);
        return $data;

    }
    public function getAllTerrritoriesForVerification(){


        $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
      ';
        $admin_territory_id = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id,territory_name,territory_level
          FROM admin_territory
          WHERE id < ' . $admin_territory_id .' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level ASC
      ';
        $data = $this->selectDBraw($query);
        return $data;
    }
    public function getAllTrackableData($table, $fieldsArray, $table2, $fieldsArray2, $program) {

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
        $ancestors = array_reverse($ancestors);
        foreach ($ancestors as $key => $ancestor) {
            $query .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ',';
            $i--;
        }

        foreach ($fieldsArray as $key => $value) {
            if ($value == 'village') {
                $query .= $table . "." . $value . ' as village_name,';
            } else {
                $query .= $table . "." . $value . ',';
            }
        }


        foreach ($fieldsArray2 as $key => $value) {

            $query .= $table2 . "." . $value . ',';
        }

        $query = rtrim($query, ",");

        $query .= ' from ' . $table
                . ' LEFT JOIN ' . $table2 . ' ON ' . $table . '.waterpoint_id=' . $table2 . '.waterpoint_id'
                . ' LEFT JOIN admin_territory_details as t1 ON ' . $table . '.village=t1.id';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= ' LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }



        $query.=' WHERE ' . $table . '.program=' . $table2 . '.program';
        $query.=' AND ' . $table . '.program="' . $program . '"';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getTitle($title) {

        $query = 'SELECT id from contact_category WHERE title="' . $title . '"';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getTerritoryId($territory, $territoryName) {
        $query = 'SELECT id
          FROM admin_territory
          WHERE territory_name = "' . $territory . '" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
        ';


        $admin_territory_id = isset($this->selectDBraw($query)[0]['id']) ? $this->selectDBraw($query)[0]['id'] : null;

        if ($admin_territory_id != null) {
            $query = 'SELECT id,
            territory_name, 
            territory_level
            FROM admin_territory
            WHERE id = ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
          ';
            $ancestors = $this->selectDBraw($query);
            if ($ancestors != null) {
                $query = 'SELECT id from admin_territory_details WHERE admin_territory_id=' . $ancestors[0]["id"] . ' AND admin_territory_name="' . $territoryName . '"';
                $data = $this->selectDBraw($query);
            } else {
                $data = null;
            }
        } else {
            $data = null;
        }
        return $data;
    }

    //Extract Data from vcs_meeting_tracker
    public function getQuorum($program, $village) {


        $query = 'SELECT quorum,prize_quorum,people_present from vcs_meetings_tracker WHERE program="' . $program . '"';
        $query.=' AND village_name="' . $village . '" LIMIT 1';
        $data1 = $this->selectDBraw($query);
        return $data1;
    }

    public function getInstallTrackData($program) {

        $query = 'SELECT * from tracking_installed_dispensers WHERE program="' . $program . '"';
        $data = $this->selectDBraw($query);
        return $data;
    }

    //Extract Data from tracking_installed_dispensers
    public function getTrackingData($program, $fieldsArray, $waterpointId, $verificationId) {

        $table = 'tracking_installed_dispensers';
        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }
        }
        if (empty($fieldsArray)) {
            $query.=' * ';
        } else {
            $len = strlen($query);
            $lim = $len - 1;
            $query = substr($query, 0, $lim);
        }
        $query.=' from tracking_installed_dispensers';

        $query.='  WHERE program="' . $program . '"';
        $query.=' AND waterpoint_id="' . $waterpointId . '"';
        $query.=' AND verification_id=' . $verificationId;
        // echo $query;
        $data1 = $this->selectDBraw($query);
        return $data1;
    }

    public function getCemTrackingData($program, $fieldsArray, $waterpointId) {

        $table = 'cem_tracker';
        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }
        }
        if (empty($fieldsArray)) {
            $query.=' * ';
        } else {
            $len = strlen($query);
            $lim = $len - 1;
            $query = substr($query, 0, $lim);
        }

        $query.=' from cem_tracker';

        $query.='  WHERE program="' . $program . '"';
        $query.=' AND waterpoint_id="' . $waterpointId . '"';


        $data1 = $this->selectDBraw($query);
        return $data1;
    }
    
    public function getOdkCemInstallationTrackingData($table, $program, $waterpointId) {

        $query = 'SELECT waterpoint_id from '.$table;
        $query.='  WHERE program="' . $program . '"';
        $query.=' AND waterpoint_id="' . $waterpointId . '"';
        $data1 = $this->selectDBraw($query);
        return $data1;
    }

    public function getCEMOfficerData($table, $fieldsArray, $verificationId) {
        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }
        }
        if (empty($fieldsArray)) {
            $query.=' * ';
        } else {
            $len = strlen($query);
            $lim = $len - 1;
            $query = substr($query, 0, $lim);
        }

        $query .= '
             FROM '
                . $table
                . ' WHERE ' . $table . '.program="' . $verificationId . '"';

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getVcsMeetingData($table, $fieldsArray, $program = 'empty', $order = null) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country
                    FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id';

            if ($program != 'empty') {
                $query .=' WHERE ' . $table . '.program="' . $program . '"';
            }
            $query .=' AND admin_countries.id=' . $_SESSION["country"];
            if ($order != null) {
                $query .=' ORDER BY ' . $table . '.' . $order . ' ASC';
            }
        }
        //echo $query;
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getSiteVerificationData($table, $fieldsArray) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country,site_verification.program_id as program_id,
                            village_details.village_name as village,staff_list.full_name as full_name

                    FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                    . ' JOIN village_details ON ' . $table . '.village = village_details.id'
                    . ' JOIN site_verification ON ' . $table . '.program_id = site_verification.id '
                    . ' JOIN staff_list ON ' . $table . '.full_name = staff_list.id '
                    . ' AND admin_countries.id=' . $_SESSION["country"];
        }
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getSpecificSiteVerificationData($table, $fieldsArray, $verificationId) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country,site_verification.program_id_id as program_id,
                            village_details.village_name as village,staff_list.full_name as full_name

                    FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                    . ' JOIN village_details ON ' . $table . '.village = village_details.id'
                    . ' JOIN site_verification ON ' . $table . '.program_id = site_verification.id '
                    . ' JOIN staff_list ON ' . $table . '.full_name = staff_list.id '
                    . ' WHERE ' . $table . '.site_verification_id="' . $verificationId . '" '
                    . ' AND admin_countries.id=' . $_SESSION["country"]
                    . ' ORDER by ' . $table . '.full_name';
        }



        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getVillageVerificationData($table, $fieldsArray, $verificationId) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country,site_verification.program_id as program_id,
                            village_details.village_name as village,staff_list.full_name as full_name

                    FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                    . ' JOIN village_details ON ' . $table . '.village = village_details.id'
                    . ' JOIN site_verification ON ' . $table . '.program_id = site_verification.id '
                    . ' JOIN staff_list ON ' . $table . '.full_name = staff_list.id '
                    . ' WHERE ' . $table . '.program_id="' . $verificationId . '" '
                    . ' AND admin_countries.id=' . $_SESSION["country"]
                    . ' ORDER by ' . $table . '.date,' . $table . '.village ';
        }
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getVcsWaterpointDetails($program, $fieldsArray = null) {
        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= "waterpoint_details." . $value . ',';
            }
        }


        if (empty($fieldsArray)) {
            $query.=' * ';
        } else {
            $len = strlen($query);
            $lim = $len - 1;
            $query = substr($query, 0, $lim);
        }
        $query = ' from waterpoint_details WHERE program="' . $program . '" AND country="' . $_SESSION['country'] . ' AND waterpoint_id !=""';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getExpansionData($table, $fieldsArray = null, $criteria = null, $value = null) {

        if ($criteria != null) {
            $query = 'SELECT * from ' . $table . ' WHERE ' . $criteria . '=' . $value;
        } else {
            $query = 'SELECT * from ' . $table;
        }
        // echo $query;
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getTrackedData($table, $fieldsArray, $program) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }
            if (empty($fieldsArray)) {
                $query.=' * ';
            } else {
                $len = strlen($query);
                $lim = $len - 1;
                $query = substr($query, 0, $lim);
            }

            $query .= ' FROM ' . $table . ' WHERE ' . $table . '.program="' . $program . '"';
        }



        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getDutiesExpansionData($table, $fieldsArray = null, $criteria = null, $activeLsm = null) {
        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }

            $query .= 'staff_list.full_name as full_name

                    FROM ' . $table
                    . ' JOIN staff_list ON ' . $table . '.full_name = staff_list.id ';
            if ($value != null) {
                $query .=' WHERE ' . $criteria . '=' . $activeLsm;
            }

            $data = $this->selectDBraw($query);
        } else {
            $data = null;
        }
        return $data;
    }

    public function getExpansionAJaxData($table, $column = null, $value = null) {

        if ($column != null) {
            $query = 'SELECT ' . $column . ' from ' . $table . ' WHERE id=' . $value;
        } else {
            $query = 'SELECT * from ' . $table;
        }
        // echo $query;

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getLsmTransitData2() {
        //get selected Cau level id from lsm_default_check
        $query = 'SELECT territory_id,lsm_title from lsm_details WHERE country=' . $_SESSION['country'];
        $data = $this->selectDBraw($query);
        if ($data == null) {
            return $data;
        } else {
            $cauSelected = $data;
            $cauSelected['Programs'] = array();
        }
        foreach ($cauSelected as $key => $value) {
            $query = 'SELECT admin_territory_id from admin_territory_details WHERE id=' . $value['territory_id'];
            $TerritoryData = $this->selectDBraw($query);
            if ($TerritoryData == null) {
                $cauSelected['Programs'] = null;
            } else {
                //Get All cau levels below the one selected  
                $query = 'SELECT * from admin_territory WHERE country_id=' . $_SESSION['country'] . ' AND id>=' . $TerritoryData[0]["admin_territory_id"];
                $currentLevel = $this->selectDBraw($query)[0]['territory_level'];

                $query = 'SELECT * from admin_territory WHERE country_id=' . $_SESSION['country'] . ' AND territory_level>=' . $currentLevel;
                $data = $this->selectDBraw($query);
            }
        }

        return $cauSelected;
    }

    public function getLsmTransitData3() {

        //get selected Cau level id from lsm_default_check
        $query = 'SELECT territory_id,lsm_title from lsm_details WHERE country=' . $_SESSION['country'];
        $data = $this->selectDBraw($query);

        $cauSelected = $data;
        //$cauSelected['Programs']=array();

        foreach ($cauSelected as $key => $value) {
            $query = 'SELECT admin_territory_id from admin_territory_details WHERE id=' . $value['territory_id'];
            $TerritoryData = $this->selectDBraw($query);

            //Get All cau levels below the one selected  
            $query = 'SELECT territory_level from admin_territory WHERE country_id=' . $_SESSION['country'] . ' AND id=' . $TerritoryData[0]["admin_territory_id"];
            $currentLevel = $this->selectDBraw($query)[0]['territory_level'];

            $query = 'SELECT id,territory_level from admin_territory WHERE country_id=' . $_SESSION['country'] . ' AND territory_name="village"';
            $villageLevel = $this->selectDBraw($query)[0]['territory_level'];
            $villageId = $this->selectDBraw($query)[0]['id'];
             $query = 'SELECT id from admin_territory WHERE country_id=' . $_SESSION['country'] . ' AND territory_level >= ' . $currentLevel . ' AND territory_level<' . $villageLevel;
            $range = $this->selectDBraw($query);
            foreach ($range as $key2 => $value2) {

                $query = 'SELECT id from admin_territory_details WHERE admin_territory_id=' . $value2['id'];
                $units = $this->selectDBraw($query);

                foreach ($units as $key3 => $value3) {

                    echo $query = 'SELECT admin_territory_name,id from admin_territory_details WHERE territory_parent=' . $value3['id']
                    . ' AND admin_territory_id=' . $villageId . '';
                    $children = $this->selectDBraw($query);
                    echo '<pre>';
                    print_r($children);
                    echo '</pre>';
                }
            }
        }

        return $cauSelected;
    }

    public function getLsmTransitData() {

        //get selected Cau level id from lsm_default_check
        $query = 'SELECT territory_id,lsm_title from lsm_details WHERE country=' . $_SESSION['country'];
        $data = $this->selectDBraw($query);

        $cauSelected = $data;
        $cauSelected['Programs'] = array();

        foreach ($cauSelected as $key => $value) {
            //We Find the Name of The Territory and its position in the cau
            $query = 'SELECT admin_territory_id,admin_territory_name from admin_territory_details WHERE id=' . $value['territory_id'];
            $TerritoryData = $this->selectDBraw($query);
            //We Find the Classification of the C.aU using rhe position we got from previous query.i.e is it a county or subcounty etc
            $query = 'SELECT territory_name from admin_territory WHERE id=' . $TerritoryData[0]['admin_territory_id'];
            $TerritoryPosition = $this->selectDBraw($query)[0]['territory_name'];

            //With the territory position and name we can browse through village contacts where such a territory exists to get the 
            //programs
            $programArray = $this->getVillagePrograms($TerritoryPosition, $TerritoryData[0]['admin_territory_name']);
            echo '<pre>';
            print_r($programArray);
            echo '</pre>';
            exit();
            foreach ($programArray as $key => $value) {
                array_push($cauSelected['Programs'], $value);
            }
        }
    }

    private function getVillagePrograms($TerritoryPosition, $territoryName) {

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

        $query .= 'village_details.program';

        // $query = rtrim($query,",");
        $query.='  from village_details'
                . ' JOIN admin_countries ON village_details.country = admin_countries.id'
                . ' LEFT JOIN admin_territory_details as t1 ON village_details.village_name=t1.id';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= ' LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query.=' WHERE  t1.' . $TerritoryPosition . '="' . $territoryName . '"';

        echo $query;

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getActivePrograms($table) {

        $query = 'SELECT program from ' . $table . ' WHERE country=' . $_SESSION['country'];
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getDistinctActivePrograms($table) {

        $query = 'SELECT distinct program from ' . $table . ' WHERE country=' . $_SESSION['country'];
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getSiteVerification($table, $fieldsArray) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country
                    FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                    . ' WHERE admin_countries.id=' . $_SESSION["country"];
        }
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getSiteVerificationOfficers($table, $siteId) {

        $query = 'SELECT field_officer FROM ' . $table . ' WHERE ' . $table . '.program = "' . $siteId . '"';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getVerificationOfficers($table = 'staff_list', $positions = null, $exceptions = null) {


        $query = 'SELECT id,full_name from ' . $table;

        if ($positions != null) {
            $count = 1;

            foreach ($positions as $key => $value) {
                if ($count == 1) {
                    $query.=' WHERE position=' . $value;
                    ++$count;
                } else {
                    $query.=' OR position=' . $value;
                }
            }
        }

        if ($exceptions != null && $positions != null) {

            foreach ($exceptions as $key => $value) {

                $query.=' AND full_name!="' . $value['field_officer'] . '"';
            }
        } else if ($exceptions != null && $positions == null) {
            $count = 1;

            foreach ($exceptions as $key => $value) {
                if ($count == 1) {
                    $query.=' WHERE full_name !="' . $value['field_officer'] . '"';
                    ++$count;
                } else {
                    $query.=' AND full_name !="' . $value['field_officer'] . '"';
                }
            }
        }

        if ($exceptions == null && $positions == null) {
            $query.=' WHERE country =' . $_SESSION['country'] . '';
        } else {
            $query.=' AND country =' . $_SESSION['country'] . '';
        }
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function addOfficialExpansion($table, $program, $Identity) {
        $data = array(
            'program' => $program,
            'field_officer' => $Identity
        );

        $result = $this->insertdDB($table, $data);

        return $result;
    }

    public function removeOfficialExpansion($table, $program, $Identity) {

        $data = array(
            'program' => $program,
            'field_officer' => $Identity
        );

        $result = $this->deleteDB($table, $data);

        return $result;
    }

    public function removeVillageExpansion($table, $program, $identity) {

        $data = array(
            'country' => $_SESSION['country'],
            'program' => $program,
            'territory_id' => $identity
        );
        $result = $this->deleteDB($table, $data);
        return $result;
    }

    public function getFoVerification($table, $fieldsArray, $verificationId) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }
            $query .= 'program_setup.program as program,village_details.village_name as village_name,staff_list.full_name as full_name
           FROM '
                    . $table
                    . ' JOIN program_setup  ON ' . $table . '.program = program_setup.id'
                    . ' JOIN village_details  ON ' . $table . '.village_name = village_details.id'
                    . ' JOIN staff_list  ON ' . $table . '.full_name = staff_list.id'
                    . ' WHERE program_setup.program="' . $verificationId . '"';
        }

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getPdfFoVerification($table, $fieldsArray, $verificationId) {

        $query = 'SELECT field_officer from '
                . $table
                . ' WHERE program="' . $verificationId . '"';


        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getvillageDetails($table, $program) {

        $query = 'SELECT * from '
                . $table
                . ' WHERE program="' . $program . '"'
                . ' ORDER by id ASC';


        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getvillageWaterpointDetails($table = 'village_details', $table2 = 'waterpoint_details', $program) {

        // Lake victoria
        $latitude = '-0.607572';
        $longitude = '33.440312';

        $query = 'SELECT ';
        $query.= $table . '.village_name,' . $table . '.village_elder,' . $table . '.elder_contact,' . $table . '.chw_name,' . $table . '.chw_contact,';
        $query.= $table2 . '.village, ' . $table2 . '.waterpoint_name, ' . $table2 . '.village, ' . $table2 . '.waterpoint_id,

                (((acos(sin((' . $latitude . '*pi()/180))*sin((waterpoint_details.latitude*pi()/180))+cos((' . $latitude . '*pi()/180))*cos((waterpoint_details.latitude*pi()/180))*cos(((' . $longitude . '-waterpoint_details.longitude)*pi()/180))))*180/pi())*60*1.1515) as distance
                FROM '
                . $table . ',' . $table2
                . ' WHERE ' . $table . '.program="' . $program . '"'
                . ' AND ' . $table . '.village_name=' . $table2 . '.village'
                . ' AND ' . $table2 . '.waterpoint_id !=""'
                . ' AND ' . $table . '.village_name !="" ORDER BY distance DESC';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getSchedule($table, $program) {

        $query = "SELECT * from " . $table . " WHERE program='" . $program . "'";

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getWaterpointvillageDetails($table2 = 'waterpoint_details', $program) {

        // Lake victoria
        $latitude = '-0.607572';
        $longitude = '33.440312';

        $query = 'SELECT ';
        $query.= $table2 . '.village, ' . $table2 . '.waterpoint_name, ' . $table2 . '.village, ' . $table2 . '.waterpoint_id,

                (((acos(sin((' . $latitude . '*pi()/180))*sin((waterpoint_details.latitude*pi()/180))+cos((' . $latitude . '*pi()/180))*cos((waterpoint_details.latitude*pi()/180))*cos(((' . $longitude . '-waterpoint_details.longitude)*pi()/180))))*180/pi())*60*1.1515) as distance
                FROM '
                . $table2
                . ' WHERE ' . $table2 . '.program="' . $program . '"'
                . ' AND ' . $table2 . '.waterpoint_id !=""'
                . ' AND ' . $table2 . '.active =1'
                . ' AND ' . $table2 . '.village !="" '
                . ' AND ' . $table2 . '.country=' . $_SESSION['country'] . ' ORDER BY distance DESC';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function confirmWaterpointId($table, $waterpointId, $program = null) {

        $query = 'SELECT * from ' . $table . ' WHERE waterpoint_id="' . $waterpointId . '"';

        if ($program != null) {
           $query.=' AND program="' . $program . '"';
        }
        $data = $this->selectDBraw($query);
        return sizeof($data);
    }

    public function addData($table, $data) {
        $dd = $this->insertdDB($table, $data);
    }

    public function getFields($table, $fieldsArray = null) {

        $fields = $this->getColMeta($table, $fieldsArray);
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

    public function getRowNo($table, $field, $value) {

        $sql = 'SELECT * from ' . $table . ' WHERE ' . $field . ' ="' . $value . '"';
        $data = $this->selectDBraw($sql);
        return sizeof($data);
    }

    public function checkProgram($table, $program) {

        $sql = 'SELECT program from ' . $table . ' WHERE program="' . $program . '"';
        $data = $this->selectDBraw($sql);
        return $data;
    }

    public function getProgramName($table, $program) {

        $sql = 'SELECT program from ' . $table . ' WHERE id=' . $program;
        $data = $this->selectDBraw($sql);
        return $data;
    }

    public function getProgramId($program) {

        $sql = 'SELECT id from dsw_programs WHERE program="' . $program . '"';
        $data = $this->selectDBraw($sql);
        return $data;
    }

    public function getVillageswithProgram($programId) {

        $query = 'SELECT * from cau_programs WHERE program=' . $programId;
        $villages = $this->selectDBraw($query);
        if ($villages == null) {
            return null;
        }
        $counter = 0;
        $query = 'SELECT id
            FROM admin_territory
            WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC';

        $admin_territory_id = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id,
            territory_name, 
            territory_level
            FROM admin_territory
            WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
        ';

        $ancestors = $this->selectDBraw($query);

        $query = 'SELECT ';

        $i = 1;
        foreach ($ancestors as $key => $ancestor) {

            $query .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ', ';
            $i++;
        }

        $query .= 't1.id ';

        $query .= 'FROM admin_territory_details as t1 ';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 'LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query .= 'WHERE t1.admin_territory_id = ' . $admin_territory_id . '';

        foreach ($villages as $key => $value) {

            if ($counter == 0) {
                $query.=' AND t1.id=' . $value['territory_id'];
            } else {
                $query.=' OR t1.id=' . $value['territory_id'];
            }
            ++$counter;
        }
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getProgramDropDown() {

        $query = 'SELECT distinct program from cau_programs WHERE country=' . $_SESSION['country'];
        $query.=' AND program!=""';
        $programs = $this->selectDBraw($query);
        if (isset($programs[0]['program']) == false) {
            return null;
        }
        $query = 'SELECT program from dsw_programs  ';
        $counter = 0;
        foreach ($programs as $key => $value) {

            if ($counter == 0) {
                $query.=' WHERE id=' . $value["program"];
            } else {
                $query.=' OR id=' . $value["program"];
            }
            ++$counter;
        }
        $data = $this->selectDBraw($query);



        return $data;
    }
    public function getChlorineInventory($inventory){

        $query='SELECT * from chlorine_inventory_type WHERE inventory_type="'.$inventory.'"';
        $data = $this->selectDBraw($query);

        return $data['id'];

    }
    public function getAllVillages($territoryArray) {

        $territories = json_decode($territoryArray);
        if ($territories == null) {
            return null;
        }
        $query = 'SELECT id
            FROM admin_territory
            WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC';

        $admin_territory_id = $this->selectDBraw($query)[0]['id'];

        $query = 'SELECT id,
            territory_name, 
            territory_level
            FROM admin_territory
            WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
        ';

        $ancestors = $this->selectDBraw($query);

        $territoryArr = array();
        $territoryCounter = 0;
        $k = 1;
        //Get their respective Cau Name and level Name
        foreach ($territories as $key => $value) {

            $query = 'SELECT * from admin_territory_details WHERE id=' . $value;
            $admin_territory = $this->selectDBraw($query);

            if (!empty($admin_territory)) {
                $territoryArr[$territoryCounter]["territory_name"] = $admin_territory[0]["admin_territory_name"];
                $territoryArr[$territoryCounter]["id"] = $value;
                $territoryArr[$territoryCounter]["admin_territory_id"] = $admin_territory[0]["admin_territory_id"];

                $query = 'SELECT territory_name from admin_territory WHERE id=' . $admin_territory[0]["admin_territory_id"];
                $admin_territoryName = $this->selectDBraw($query)[0]['territory_name'];
                $territoryArr[$territoryCounter]["territoryLevel"] = $admin_territoryName;

                foreach ($ancestors as $key => $ancestor) {

                    if ($ancestor['territory_name'] == $admin_territoryName) {
                        $territoryArr[$territoryCounter]['tcount'] = 't' . $k . '.admin_territory_name';
                    }
                    $k++;
                }
                $k = 1;
            }
            ++$territoryCounter;
        }

        $maxAncestor = sizeof($ancestors);
        $counter = 0;

        $query = 'SELECT ';

        $i = 1;
        foreach ($ancestors as $key => $ancestor) {

            $query .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ', ';
            $i++;
        }

        $query .= 't1.id, 
                t1.admin_territory_id, 
                t1.territory_parent AS territory_parent_id ';

        $query .= 'FROM admin_territory_details as t1 ';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 'LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query .= 'WHERE t1.admin_territory_id = ' . $admin_territory_id . '';

        foreach ($territoryArr as $key => $value) {
            if ($counter == 0) {
                $query.=' AND ' . $value['tcount'] . '="' . $value['territory_name'] . '"';
            } else {
                $query.=' OR ' . $value['tcount'] . '="' . $value['territory_name'] . '"';
            }
            ++$counter;
        }

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function checkVillage($villageId) {

        $query = 'SELECT * from cau_programs WHERE territory_id=' . $villageId;
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getAllVillagesWithProgram($programId) {
        $query = 'SELECT id from cau_programs WHERE program=' . $programId;

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getStaffDropDown() {

        $query = 'SELECT distinct full_name from staff_list WHERE country=' . $_SESSION['country'];

        $data = $this->selectDBraw($query);

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

    public function deleteData($table, $id) {
        $dd = $this->deleteDB($table, $id);
    }

    public function deleteProg($table, $program) {
        $params = array('program' => $program, 'country' => $_SESSION['country']);
        $this->deleteDB($table, $params);
    }

    public function getByID($promoterId) {
        $rows = $this->selectDB(
                $table = "promoter_details", $filds = null, $params = array('id' => $promoterId)
        );


        $data = array(); //create the array
        foreach ($rows as $key => $row) {
            $data[] = array(
                'id' => $row['id'],
                'promoter_name' => $row['promoter_name'],
                'promoter_contact' => $row['promoter_contact'],
                'waterpoint_id' => $row['waterpoint_id']
            );
        }

        return $data;
    }

    public function getOfficeName($officeName) {

        $query = ' SELECT id from field_office WHERE office_location="' . $officeName . '" AND country=' . $_SESSION['country'];

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function checkProgramExist($program) {

        $query = ' SELECT id from dsw_programs WHERE program="' . $program . '"';

        $programId = $this->selectDBraw($query);
        if (isset($programId[0]['id']) && $program != strtolower('program')) {
            return $programId[0]['id'];
        } else if ($program == strtolower('program')) {

            return 0;
        } else {

            $data = array(
                "id" => '',
                "program" => $program
            );

            $result = $this->insertdDB('dsw_programs', $data);
            $query = ' SELECT id from dsw_programs WHERE program="' . $program . '"';

            return $programId = $this->selectDBraw($query)[0]['id'];
        }
    }

    public function checkTerritoryExist($territoryId) {

        $query = ' SELECT * from cau_programs WHERE territory_id=' . $territoryId;

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getInventoryId($inventoryName) {
        $query = ' SELECT id from admin_inventory_type WHERE inventory_type="' . $inventoryName . '" ';

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function runRawQuery($query) {
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function updateVerification($data3) {
        $result = $this->insertdDB('waterpoint_details', $data3);
        return $result;
    }

    public function getLastURL($url) {
        $tokens = explode('/', $url);
        return $tokens[sizeof($tokens) - 1];
    }

}

?>