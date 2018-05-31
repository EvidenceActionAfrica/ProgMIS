<?php
session_start();
//server
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'xemplar1_ea');
// define('DB_PASSWORD', 'xt19920');
// define('DB_DATABASE', 'xemplar1_evidence_action');

//local
 define('DB_SERVER', 'localhost');
 define('DB_USERNAME', 'root');
 define('DB_PASSWORD', 'njeru');
 define('DB_DATABASE', 'evidence_action');

$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
?>
