<?php

class generalmodel extends Database {

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

    public function getData($table, $fieldsArray = null) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {

                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country
					FROM ' . $table . '
					JOIN admin_countries ON ' . $table . '.country = admin_countries.id' . ' AND admin_countries.id=' . $_SESSION["country"];
            //$query.=' LIMIT 1';
        } else {
            $query = 'SELECT * from ' . $table;
        }

        // echo $query;
        // exit();   
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getProgramCau($table = 'cau_programs', $fieldsArray) {
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
            $i--;
        }

        foreach ($fieldsArray as $key => $value) {
            if ($value == 'program') {
                continue;
            }

            $query .= $table . "." . $value . ',';
        }

        $query .= 'admin_countries.country AS country,
          t1.admin_territory_name as village
        ';

        $query .= ' FROM cau_programs
          JOIN admin_countries ON ' . $table . '.country = admin_countries.id 
          LEFT JOIN dsw_programs  ON ' . $table . '.program=dsw_programs.id
          LEFT JOIN admin_territory_details AS t1 ON ' . $table . '.territory_id = t1.id ';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 'LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query .= 'WHERE ' . $table . '.country = ' . $_SESSION['country'] . ' ORDER BY ';
        $i = 1;
        //$ancestors=array_reverse($ancestors);
        foreach ($ancestors as $key => $ancestor) {
            $query .= $ancestor['territory_name'] . ',';
            $i++;
        }
        $query = rtrim($query, ",");
        // echo $query;
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function checkProgramExist($program) {

        $program = trim($program);
        $program = str_replace(' ', '', $program);
        //Make sure it has no spaces
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

    public function getAdminModuleManagerData() {

        $query = 'SELECT * from admin_module_manager WHERE country=' . $_SESSION['country'];
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getFieldOffice() {


        $query = 'SELECT * from field_office WHERE country=' . $_SESSION['country'];
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function checkAdminModuleDuplicate($tableName, $territoryId) {
        $query = 'SELECT * from admin_module_manager WHERE country=' . $_SESSION['country'] . ' AND table_name="' . $tableName . '" AND territory_id=' . $territoryId;

        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getVillageData($table, $fieldsArray) {
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
            $query .= $table . "." . $value . ',';
        }

        $query .= 'admin_countries.country AS country,
        	t1.admin_territory_name as village
        ';

        $query .= ' FROM ' . $table . ' 
	        JOIN admin_countries ON ' . $table . '.country = admin_countries.id 
	        LEFT JOIN admin_territory_details AS t1 ON ' . $table . '.village_name = t1.id ';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 'LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query .= 'WHERE ' . $table . '.country = ' . $_SESSION['country'] . ' ORDER BY ';
        $i = 1;
        foreach ($ancestors as $key => $ancestor) {
            $query .= $ancestor['territory_name'] . ',';
            $i++;
        }
        $query = rtrim($query, ",");
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getNoncountryData($table) {
        $query = 'SELECT * from ' . $table;
        $data = $this->selectDBraw($query);

        return $data;
    }
     public function getProgramDropDown() {
        $query = 'SELECT DISTINCT program from waterpoint_details WHERE country='.$_SESSION['country'].' ORDER BY program ASC';
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

    public function checkSelectedCau($table) {

        $query = 'SELECT * FROM  admin_module_manager WHERE table_name="' . $table . '" AND country = ' . $_SESSION['country'];
        $data = $this->selectDBraw($query);
        $territory = array();
        if ($data != null) {
            foreach ($data as $key => $value) {
                $territoryName = $this->getCau($value["territory_id"]);
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

    public function getAllCau() {

        $query = 'SELECT id,territory_name
          FROM admin_territory
          WHERE  country_id = ' . $_SESSION['country'] . ' ORDER BY territory_name ASC
      ';

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getWaterpointDetails($table = 'waterpoint_details', $fieldsArray,$program=null) {

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
        $ancestors = array_reverse($ancestors);

        $cauManage = $this->checkSelectedCau($table);
        $query = 'SELECT ';
        $allCaus='';
         $i = sizeof($ancestors);
        foreach ($ancestors as $key => $ancestor) {
            $allCaus .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ',';
            $i--;
        }

        foreach ($fieldsArray as $key => $value) {
            $query .= $table . "." . $value . ',';
            if($value=='village'){
                $query.=$allCaus;
            }
        }

       

        $query .= 'admin_countries.country AS country,
        	waterpoint_details.waterpoint_name
        ';

        $query .= ' FROM ' . $table . ' 
	        JOIN admin_countries ON ' . $table . '.country = admin_countries.id 
	        LEFT JOIN admin_territory_details AS t1 ON waterpoint_details.village = t1.id ';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 'LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query .= 'WHERE ' . $table . '.country = ' . $_SESSION['country'] ;
        if($program !=null && $program !='All'){
            $query.=' AND '.$table.'.program="'.$program.'"';
        }
        $query.=' ORDER BY ' . $table . '.id desc';
        $data = $this->selectDBraw($query);

        return $data;
    }
    public function getEditableWaterpointDetails($table = 'waterpoint_details', $fieldsArray,$program=null) {

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
        $ancestors = array_reverse($ancestors);

        $cauManage = $this->checkSelectedCau($table);
        $query = 'SELECT ';
        $allCaus='';
         $i = sizeof($ancestors);
        foreach ($ancestors as $key => $ancestor) {
            $allCaus .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ',';
            $i--;
        }

        foreach ($fieldsArray as $key => $value) {
            if($value=='village'){
                $query.=$allCaus;
            }
            $query .= $table . "." . $value . ',';
            
        }

       

        $query .= 'admin_countries.country AS country,
            waterpoint_details.waterpoint_name
        ';

        $query .= ' FROM ' . $table . ' 
            JOIN admin_countries ON ' . $table . '.country = admin_countries.id 
            LEFT JOIN admin_territory_details AS t1 ON waterpoint_details.village = t1.id ';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 'LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query .= 'WHERE ' . $table . '.country = ' . $_SESSION['country'] ;
        if($program !=null && $program !='All'){
            $query.=' AND '.$table.'.program="'.$program.'"';
        }
        $query.=' ORDER BY ' . $table . '.id desc';
        $data = $this->selectDBraw($query);

        return $data;
    }
    public function getPromoterData($table='promoter_details',$fieldsArray = null,$program = null) {
        
        
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
        $cauManage = $this->checkSelectedCau($table);
        $query = 'SELECT ';
        
        foreach ($fieldsArray as $key => $value) {

            if ($value == 'waterpoint_id') {
                $query .= 'waterpoint_details.waterpoint_name,';
                $query .= $table . "." . $value . ',';
                $i = sizeof($ancestors);
                $ancestorz = array_reverse($ancestors);
                foreach ($ancestorz as $key => $ancestor) {
                    if (in_array($ancestor['territory_name'], $cauManage)) {
                        $query .= 't' . $i . '.admin_territory_name AS ' . $ancestor['territory_name'] . ',';
                    }
                    $i--;
                }
            } else {
                $query .= $table . "." . $value . ',';
            }
        }

        $query .= 'admin_countries.country AS country
        	
        ';

        $query .= ' FROM ' . $table . ' 
	        JOIN admin_countries ON ' . $table . '.country = admin_countries.id 
	        LEFT JOIN waterpoint_details ON ' . $table . '.waterpoint_id = waterpoint_details.waterpoint_id 
	        LEFT JOIN admin_territory_details AS t1 ON waterpoint_details.village = t1.id ';

        $j = 2;
        foreach ($ancestors as $key => $ancestor) {
            $query .= 'LEFT JOIN admin_territory_details AS t' . $j . ' ON t' . $j . '.id = t' . ($j - 1) . '.territory_parent ';
            $j++;
        }

        $query .= 'WHERE ' . $table . '.country = ' . $_SESSION['country'] ;
        if($program !=null){

            $query.=' AND '.$table.'.program="'.$program.'"';
        }else{
            return null;
        }

        $query.=' ORDER BY ' . $table . '.id desc
		';
        
        $data = $this->selectDBraw($query);
        return $data;
    }


    public function getWaterpointCau($waterpointId) {

        $query = 'SELECT village from waterpoint_details WHERE waterpoint_id=' . $waterpointId;
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getTerritories() {
        $query = 'SELECT * from admin_territory WHERE country_id=' . $_SESSION['country'];
        $data = $this->selectDBraw($query);

        return $data;
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
     public function getChildrenCau($childCAU,$parentClassCAU,$parentId){

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

         // $query='SELECT id from admin_territory_details WHERE admin_territory_name="'
         //        .$parentCau.'" AND admin_territory_id='.$parentClassId;
        
        //$parentId=$this->selectDBraw($query)[0]["id"];


        $query='SELECT id,admin_territory_name from admin_territory_details WHERE admin_territory_id='.$admin_territory_id
        .' AND territory_parent='.$parentId;

        $data=$this->selectDBraw($query);
        return $data;

    }
    public function getCauList($specificCau){
        $query='SELECT id,admin_territory_name from admin_territory_details WHERE admin_territory_id='.$specificCau
                .' ORDER BY admin_territory_name ASC';
        $data=$this->selectDBraw($query);
        return $data;
    }
    public function getAllTerritories($contact) {

        $query = 'SELECT territory_id from officials_contacts WHERE id=' . $contact;
        $data = $this->selectDBraw($query);

        $territoryId = $data[0]["territory_id"];
        $query = 'SELECT  admin_territory_id from admin_territory_details WHERE id=' . $territoryId;

        $data = $this->selectDBraw($query);

        $territoryId = $data[0]["admin_territory_id"];

        $query = 'SELECT  admin_territory_name, id from admin_territory_details WHERE admin_territory_id=' . $territoryId . ' GROUP BY admin_territory_name ORDER BY admin_territory_name ASC';
        $data = $this->selectDBraw($query);


        return $data;
    }

    public function getTerritoryInfo($territoryId) {
        
        $query = 'SELECT  admin_territory_name, id from admin_territory_details WHERE admin_territory_id=' . $territoryId . ' GROUP BY admin_territory_name ORDER BY admin_territory_name ASC';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getOfficials($table = "officials_contacts", $fieldsArray) {

        $query = 'SELECT ';
        foreach ($fieldsArray as $key => $value) {
            $query .=$table . "." . $value . ',';
        }

        $query .= 'contact_category.title AS title,admin_territory.territory_name as territory,admin_territory_details.admin_territory_name as territory_name'
                . '  FROM ' . $table
                . ' JOIN contact_category ON ' . $table . '.title=contact_category.id'
                . ' JOIN admin_territory_details ON ' . $table . '.territory_id=admin_territory_details.id'
                . ' JOIN admin_territory ON admin_territory_details.admin_territory_id=admin_territory.id'
                . ' WHERE country=' . $_SESSION['country']
                . ' ORDER BY admin_territory.territory_level';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getSpecificData($table, $fieldsArray = null, $dataId) {

        $query = 'SELECT ';
        if (!empty($fieldsArray)) {
            foreach ($fieldsArray as $key => $value) {
                $query .=$table . "." . $value . ',';
            }
            $query .= 'admin_countries.country AS country
        FROM ' . $table . '
        JOIN admin_countries ON ' . $table . '.country = admin_countries.id  WHERE ' . $table . '.issueid=' . $dataId . ' AND admin_countries.id=' . $_SESSION["country"];
        } else {
            $query = "SELECT * from " . $table . " WHERE issueid=" . $dataId . ' AND country=' . $_SESSION["country"];
        }
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function addData($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' added';
        if ($table == 'officials_contacts') {
            $description = ' name is ' . $data['name'];
        } else if ($table == 'village_details') {
            $description = ' name is ' . $data['village_elder'];
        } else if ($table == 'promoter_details') {
            $description = ' name is ' . $data['promoter_name']; 
        } else if ($table == 'contact_category') {
            $description = ' name is ' . $data['title'];
        } else if ($table == 'admin_module_manager') {
            $description = ' name is ' . str_replace("_", " ", $data['table_name']);
        } else if ($table == 'field_office') {
            $description = ' name is ' . $data['office_location'];
        } else if ($table == 'staff_category') {
            $description = ' name is ' . $data['position'];
        } else if ($table == 'fleet_category') {
            $description = ' name is ' . $data['type'];
        } else if ($table == 'issues_category') {
            $description = ' name is ' . $data['sub_category'];
        } else {
            $description = ' name unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );

        array_pop($data);
        $dd = $this->insertdDB($table, $data);
        $this->insertdDB('admin_log_record', $insertData);
    }

    public function getFields($table, $fieldsArray = null) {
        $fields = $this->getColMeta($table, $fieldsArray);
        return $fields;
    }

    public function getSidebarData($tableCategory) {

        $query = "SELECT * from " . $tableCategory;
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getByPK($table, $id, $fieldsArray) {
        $dd = $this->selectDB(
                $table, $filds = $fieldsArray, $params = array('id' => $id)
        );
        return $dd;
    }

    public function deleteData($table, $id) {
       
        $dd = $this->deleteDB($table, $id);
    }

    public function getLastURL($url) {
        $tokens = explode('/', $url);
        return $tokens[sizeof($tokens) - 1];
    }

    public function getVillages($country) {
        $query = 'SELECT id FROM admin_territory WHERE country_id=' . $_SESSION['country'] . ' AND territory_name = "village"';
        $admin_territory_id = $this->selectDBraw($query)[0]['id'];
        $query = 'SELECT id,admin_territory_name as village FROM admin_territory_details WHERE admin_territory_id = ' . $admin_territory_id . '';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getWaterpoints($country) {
        $query = 'SELECT waterpoint_id as id,waterpoint_name FROM waterpoint_details WHERE country = ' . $country . '';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function insertLogContact($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' edited';
        if ($table == 'officials_contacts') {
            $description = ' name is ' . $data['name'];
        } else if ($table == 'village_details') {
            $description = ' name is ' . $data['village_elder'];
        } else if ($table == 'promoter_details') {
            $description = ' name is ' . $data['promoter_name'];
        } else if ($table == 'waterpoint_details') {
            $description = ' name is ' . $data['waterpoint_name'];
        } else if ($table == 'contact_category') {
            $description = ' name is ' . $data['title'];
        } else if ($table == 'staff_category') {
            $description = ' name is ' . $data['position'];
        } else if ($table == 'field_office') {
            $description = ' name is ' . $data['office_location'];
        } else if ($table == 'fleet_category') {
            $description = ' name is ' . $data['type'];
        } else if ($table == 'issues_category') {
            $description = ' name is ' . $data['sub_category'];
        } else {
            $description = ' name unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('admin_log_record', $insertData);
    }

    public function insertLogContactonDelete($table, $id) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' deleted';

        if ($table == 'officials_contacts') {
            $query = 'SELECT name FROM officials_contacts WHERE id = ' . $id . '';
            $descrip = $this->selectDBraw($query)[0]['name'];
        } else if ($table == 'village_details') {
            $query = 'SELECT village_elder FROM village_details WHERE id = ' . $id . '';
            $descrip = $this->selectDBraw($query)[0]['village_elder'];
        } else if ($table == 'promoter_details') {
            $query = 'SELECT promoter_name FROM promoter_details WHERE id = ' . $id . '';
            $descrip = $this->selectDBraw($query)[0]['promoter_name'];
        } else if ($table == 'waterpoint_details') {
            $query = 'SELECT waterpoint_name FROM waterpoint_details WHERE id = ' . $id . '';
            $descrip = $this->selectDBraw($query)[0]['waterpoint_name'];
        } else if ($table == 'contact_category') {
            $query = 'SELECT title FROM contact_category WHERE id = ' . $id . '';
            $descrip = $this->selectDBraw($query)[0]['title'];
        } else if ($table == 'admin_module_manager') {
            $query = 'SELECT table_name FROM admin_module_manager WHERE id = ' . $id . '';
            $descrip = $this->selectDBraw($query)[0]['table_name'];
            $descrip = str_replace("_", " ", $descrip);
        } else if ($table == 'field_office') {
            $query = 'SELECT office_location FROM field_office WHERE id = ' . $id . '';
            $descrip = $this->selectDBraw($query)[0]['office_location'];
        } else if ($table == 'staff_category') {
            $query = 'SELECT position FROM staff_category WHERE id = ' . $id . '';
            $descrip = $this->selectDBraw($query)[0]['position'];
        } else if ($table == 'fleet_category') {
            $query = 'SELECT type FROM fleet_category WHERE id = ' . $id . '';
            $descrip = $this->selectDBraw($query)[0]['type'];
        } else if ($table == 'issues_category') {
            $query = 'SELECT sub_category FROM issues_category WHERE id = ' . $id . '';
            $descrip = $this->selectDBraw($query)[0]['sub_category'];
        } else {
            $descrip = ' name unknown ';
        }
        $description = ' name is ' . $descrip;
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('admin_log_record', $insertData);
    }

    public function insertLogContactonImport($table) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' data imported';
        $description = 'no description';

        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );

        $this->insertdDB('admin_log_record', $insertData);
    }

    // public function insertStaff($table) {  
       
    //     $full_name = $_SESSION["full_name"]; 
    //     $filename = 'full_name';
    //     $file     = 'type';
        
    //     $insertData = array(
    //         'id' => '',          
    //         'full_name' => $full_name,
    //         'filename' => $filename,
    //         'file' => $file,
            
    //     );

    //     $this->insertdDB('staff', $insertData);
    // }
    
    public function insertLogContactonWPactive($table, $params, $data2) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' edited';

        
        $description = ' W P name ' . $data2. ' set to '.$params;
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('admin_log_record', $insertData);
    }

}

?>