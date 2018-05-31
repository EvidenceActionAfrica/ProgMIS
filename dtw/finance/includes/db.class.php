<?php
	/*
	Name:          CRUD Database Class
	Author:        FireDart
	License:       Creative Commons Attribution-ShareAlike 3.0 Unported License
	                - http://creativecommons.org/licenses/by-sa/3.0/
	*/
	/* Database Class */
	class Database 
	{
		/* Set Properties */
		/* Set Private Database info so only this class can connect to it */
		private $hostname;
		private $database;
		private $username;
		private $password;
		/* Other Variables */
		private $pdo;
		/* Auto Load Database */
		function __construct($hostname, $database, $username, $password) {
			/* Set Private Database values */
			$this->hostname = $hostname;
			$this->port     = 3306;
			$this->database = $database;
			$this->username = $username;
			$this->password = $password;
			
			/* Try to connect else catch the failure */
			try {
				$this->pdo = new PDO("mysql:host={$this->hostname};port={$this->port};dbname={$this->database}", $this->username, $this->password, array(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING));
			} catch(PDOException $e) {
				print "<b>Error - Connection Failed: </b>" . $e->getMessage() . "<br/>";
				die();
			}
		}
		
		/* Build Query based on $query variable */
		/* Example of Bind array(":id" => "1", ":soemthing" => "The value") */
		public function query($query, $bind = null) {
		   
			global $pdo;
	        
	        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
			/* Prepare Statment */
			$this->statement = $this->pdo->prepare($query);
			/* Execute Query */
			$this->statement->execute($bind);
		}
		
		/* Return row Count */
		public function count() {
			/* Return Count */
			$result = $this->statement->rowCount();
			return $result;
		}

	}

	$database = new Database($hostname, $dbname, $username, $password);

?>
