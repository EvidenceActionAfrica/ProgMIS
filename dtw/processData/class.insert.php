<?php 

/**
* 
*/
class UploadFIle
{
	
	function __construct()
	{
	

	}

	public function insertFile($filename,$table){
		$mysqli  =  new mysqli('localhost','root','','upload');
		/* check connection */
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}
		
		//Connect as normal above
		//$sql = "LOAD DATA INFILE '../../$PLACE' INTO TABLE a_bysch"
		$sql = "LOAD DATA INFILE '$filename' INTO TABLE $table"
			. " FIELDS TERMINATED BY ','"
			. " LINES TERMINATED BY '\r\n'"
			. " IGNORE 1 LINES";

			//$sql="DELETE FROM dbase";
			// $stmt = $mysqli->query($sql);
			// Integrate other posters good recc to catch errors:

			//Try to execute query (not stmt) and catch mysqli error from engine and php error
			if (!($stmt = $mysqli->query($sql))) {
			    echo "\nQuery execute failed: ERRNO: (" . $mysqli->errno . ") " . $mysqli->error;
			}

			var_dump($mysqli);
	}
}

 ?>