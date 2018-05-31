<?php
ob_start();
session_start();
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'evidence_action');

//server
/*define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'sausuman_nabnita');
define('DB_PASSWORD', 'option123@');
define('DB_DATABASE', 'sausuman_evidence_action_reports');*/
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
?>

