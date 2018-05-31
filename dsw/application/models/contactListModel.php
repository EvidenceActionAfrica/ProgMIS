<?php 

class contactListModel extends Database
{
	
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

	public function getData($fieldsArray = null,$table) {
		$data = $this->selectDB(
			$table, 
			$fields = $fieldsArray
		);
		return $data;
	}

	public function addData($data,$table) {
		array_pop($data);
		$this->insertdDB($table,$data);
	}

	public function getFields($table) {
		$fields = $this->getColMeta($table);
		return $fields;
	}

}


?>