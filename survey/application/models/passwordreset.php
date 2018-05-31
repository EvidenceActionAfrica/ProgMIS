<?php
	/* <ramadhan's added code> */
	class passwordReset extends Database {

		function __construct($db) {
			try {
				$this->db = $db;
			} catch (PDOException $e) {
				exit('Database connection could not be established.');
			}
		}
		
		public function getByEmail($email) {
			$rows = $this->selectDB(
			$table = "staff_list", $filds = null, $params = array('email' => $email));
			return $rows;
		}
		
		public function updateField($table,$data,$id) {
			$dd=$this->updateDB($table,$data,$id);
		}
	}
	/* </ramadhan's added code> */
?>		