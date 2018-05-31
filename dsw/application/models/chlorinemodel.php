<?php

class chlorinemodel extends Database {

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

    public function getData($table, $fieldsArray = null, $WHERE = NULL, $inventory_type_table ) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country,'.$inventory_type_table.'.inventory_type AS inventory_type FROM '.$table.''
                   .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'
	               .' JOIN '.$inventory_type_table.' ON '.$table.'.inventory_type = '.$inventory_type_table.'.id'                    
                   .' WHERE admin_countries.id='.$_SESSION["country"];                   
                   if($WHERE!=NULL){
                        $query.=' AND '.$table.'.inventory_type ='.$WHERE;
                   }
                     
            $data = $this->selectDBraw($query);
            return $data;
        
        }
    
    }

    public function updateChlorineData($data,$id,$table){ 
        $this->updateDB($table,$data,$id);
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' edited';
        $description = ' Batch Number is ' . $data['batch_no'];
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


    public function getNormalData($table, $fieldsArray = null) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }

               $query .= 'admin_countries.country AS country FROM '.$table
                    .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'		    
                    .' WHERE admin_countries.id='.$_SESSION["country"];
               
        $data = $this->selectDBraw($query);
        return $data;
        
        }
    }

    public function getLogData($table, $fieldsArray = null, $WHERE = NULL) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }

            $query .= 'chlorine_list.reg_no as reg_no
					   FROM ' . $table
                    . ' JOIN chlorine_list ON ' . $table . '.reg_no = chlorine_list.id';
        }

        $data = $this->selectDBraw($query);
        return $data;

    }

    public function runRaw($query){
        $data = $this->selectDBraw($query);
        return $data;
    }    

    public function getSidebarData($tableCategory) {

        $query = "SELECT * from " . $tableCategory;
        $data = $this->selectDBraw($query);
        return $data;

    }

    public function addData($table, $data) {
        array_pop($data);
        $dd = $this->insertdDB($table, $data);
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' added';
        $description = ' Batch Number is ' . $data['batch_no'];
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

    public function deleteData($table, $id, $deletDetail) {
        $dd = $this->deleteDB($table, $id);
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' deleted';
        $description = ' Batch Number is ' . $deletDetail;
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

    public function getLastURL($url) {
        $tokens = explode('/', $url);
        return $tokens[sizeof($tokens) - 1];
    }


 


}

?>