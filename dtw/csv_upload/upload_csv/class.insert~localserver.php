<?php 

/**
* 
*/
error_reporting(E_ALL);
ini_set("display_errors","1");
require "../../includes/db_class.php";
class UploadFIle extends connDB
{
	
	function __construct()
	{
		$this->connDB(); //make db connection
	}

	public function insertFile($filename,$tableName){

		$sql = "LOAD DATA INFILE '$filename' REPLACE INTO TABLE $tableName" 
			. " FIELDS TERMINATED BY ','"
                        ."OPTIONALLY ENCLOSED BY '\"'"
			. " LINES TERMINATED BY '\r\n'"
			. " IGNORE 1 LINES";
		

		$this->exec($sql);

	}
}

 ?>