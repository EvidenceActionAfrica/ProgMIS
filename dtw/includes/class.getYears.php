<?php 

# code...
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/PROGMIS/includes/write.xml')) {
	// if(file_exists('write.xml')) {
		// echo $_SERVER['DOCUMENT_ROOT'];

		if( ! $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/PROGMIS/includes/write.xml') ) { 
			echo 'unable to load XML file. Please contact the development team'; 
		} 
		else { 
			foreach( $xml as $user ){ 
				// $chosendb=$user->year; 
				 $dbname=$user->year; 
			} 
		} 


	}else{
		echo "file does not exist. Please contact the development team";
		echo "</br>";
		echo $_SERVER['DOCUMENT_ROOT'];

	}

		//remove last letter to see if the data will be created
		$last_string=substr($dbname, -1); // returns "s"
		if (is_numeric($last_string) ) {
			$display_db_year="Year ".$last_string;
		}else{
			$display_db_year="Year 2";
		}
		

 ?>