<?php

class stafflistmodel extends Database {

  public   $table_name="general_contacts";

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

    public function getData($table, $fieldsArray = null,$tableCategory='contact_category',$WHERE=NULL) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country,staff_category.position AS Position
						FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                    . ' JOIN staff_category ON ' . $table . '.position = staff_category.id'
                    
                    . ' AND admin_countries.id=' . $_SESSION["country"];
                    
                    if($WHERE==NULL){
                    $query.=' AND '.$table.'.position like"%'.$WHERE.'%"';
                    }else{
                     $query.=' AND '.$table.'.position='.$WHERE;
                    }
//             echo $query;
            // exit();
        } else {
            $query = "SELECT * from " . $table."WHERE title='$WHERE'";
        }

   
        // echo "<pre>";var_dump($query);echo "</pre>";
        $data = $this->selectDBraw($query);

        return $data;
    }

    /*
     * 
     */

    public function getSidebarData($tableCategory) {


        $query = "SELECT * from ".$tableCategory;
        
        $data = $this->selectDBraw($query);

        return $data;
    }

}

// end class
?>