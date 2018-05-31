<?php
$hostname = 'mysql-db.cnltbg2tkrfl.eu-central-1.rds.amazonaws.com';      
$dbname   = 'evidence_action_dsw';
$username = 'mastermy';          
$password = '1620klofty'; 

$mysqli = new mysqli($hostname, $username, $password, $dbname);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}





// Let's connect to host
mysql_connect($hostname, $username, $password) or DIE('Connection to host is failed, perhaps the service is down!');
// Select the database
mysql_select_db($dbname) or DIE(mysql_error().'Database name is not available!');
$db_mysqli_connection=mysqli_connect($hostname, $username, $password,$dbname);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  
?>