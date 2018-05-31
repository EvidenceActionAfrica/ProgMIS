<?php 


class UploadFIle
{
	function __construct()
	{

	}

	public function insertFile($filename,$tableName){
		global $db_mysqli_connection;
		//-----old connection here--------------
		//$mysqli  =  new mysqli('localhost','root','',$_SESSION['database']);
  		//  if (mysqli_connect_errno()) {
		//     printf("Connect failed: %s\n", mysqli_connect_error());
		//     exit();
		// }
		//-----------------------------------------




		$handle = fopen($filename, "r");
		$query='INSERT INTO '.$tableName.' VALUES ';

		 while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		 	$limit=sizeof($data);
		 	$query.='(';
		 	$counter=0;
		 	while($limit>0){
		 		$query.="\"".$data[$counter]."\"".',';
		 		++$counter;
		 		--$limit;
		 	}
		 	
		 	$query=rtrim($query,',');

		 	$query.='),';




		 }
		 $query=rtrim($query,',');
	 	 mysqli_query($db_mysqli_connection,$query);



		//// LOAD DATA INFILE CODE ---------------------------------------------------
		//// $sql = "LOAD DATA INFILE '../../$PLACE' INTO TABLE a_bysch"
		////$sql = "LOAD DATA LOCAL INFILE '../../$PLACE' INTO TABLE a_bysch"
		
		// $sql = "LOAD DATA INFILE '$filename' REPLACE INTO TABLE $tableName" 
		// 	. " FIELDS TERMINATED BY ','"
        //  . "OPTIONALLY ENCLOSED BY '\"'"
		// 	. " LINES TERMINATED BY '\r\n'"
		// 	. " IGNORE 1 LINES";
		
		// 	//$sql="DELETE FROM dbase";
		// 	// $stmt = $mysqli->query($sql);
		// 	// Integrate other posters good recc to catch errors:
		//echo mysqli_affected_rows($mysqli);
		//// LOAD DATA INFILE CODE ---------------------------------------------------



			if (mysqli_affected_rows($db_mysqli_connection)<=0) {
			   // echo "\nQuery execute failed: ERRNO: (" . $mysqli->errno . ") " . $mysqli->error;
			    $csvMessage = "Upload Failed <br/>" . $db_mysqli_connection->error ;
			}else{
				$csvMessage = "Upload Successful";
			}
			return $csvMessage;
			//var_dump($mysqli);
	}
}

 ?>
