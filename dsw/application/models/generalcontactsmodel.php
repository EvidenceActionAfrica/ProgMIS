<?php

class generalcontactsmodel extends Database {

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

    public function getData($table, $fieldsArray = null,$tableCategory='contact_category',$criteria='title',$WHERE='3') {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country,contact_category.title AS title
						FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                    . ' JOIN contact_category ON ' . $table . '.title = contact_category.id'
                    
                    . ' AND admin_countries.id=' . $_SESSION["country"];
                     if($WHERE!=NULL){
                        $query.=' AND '.$table.'.'.$criteria.' like "%'.$WHERE.'%"';
                      }
         
          /*
                 $query .= 'admin_countries.country AS country,'.$tableCategory.'.'.$criteria.' AS '. $criteria.
						' FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                    . ' JOIN '.$tableCategory.' ON ' . $table .'.'.$criteria. ' ='.$tableCategory.'.id'
                  ;
        */
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