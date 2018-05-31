<?php
//-------------------------------------------------------------------------
// MySQL database details
//-------------------------------------------------------------------------

/**
* 
*/
class db_conf 
{
	
	function __construct()
	{
		$this->dbHost = "127.0.0.1";    // MySQL host name
		$this->dbName = "evidence_action";       // MySQL database name


		//-------------------------------------------------------------------------
		// MySQL account details
		//-------------------------------------------------------------------------

		$this->dbUser = "root";       // MySQL username
		$this->dbPass = "root";   // MySQL password
	}
}


?>