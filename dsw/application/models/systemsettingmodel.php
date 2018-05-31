<?php

class systemsettingmodel extends Database {

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
        
        $query = 'SELECT * from ' . $table . ' WHERE country ='.$_SESSION["country"].' ORDER BY date DESC LIMIT 4000';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getFields($table, $fieldsArray = null) {
        $fields = $this->getColMeta($table, $fieldsArray);

        return $fields;
    }

}

?>