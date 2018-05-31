<?php
$hostname = 'localhost';      
$dbname   = 'xemplar1_DSW';
$username = 'xemplar1_ea';          
$password = 'xt19920';

mysql_connect($hostname, $username, $password) or DIE('Connection to host is failed, perhaps the service is down!');
// Select the database
mysql_select_db($dbname) or DIE(mysql_error().'Database name is not available!');
?>