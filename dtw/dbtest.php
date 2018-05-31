

<?php
$mysqli = new mysqli("localhost", "root", "njeru", "evidence_action");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}else{
	echo $mysqli->host_info . "\n";
	echo "Yes";
}
// echo $mysqli->host_info . "\n";

// $mysqli = new mysqli("127.0.0.1", "user", "password", "database", 3306);
// if ($mysqli->connect_errno) {
//     echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
// }


?>
 