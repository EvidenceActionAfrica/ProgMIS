<?php
$hostname = 'mysql-db.cnltbg2tkrfl.eu-central-1.rds.amazonaws.com';        // Your MySQL hostname. Usualy named as 'localhost', so you're NOT necessary to change this even this script has already online on the internet.
$dbname   = 'evidence_action'; // Your database name.
$username = 'mastermy';             // Your database username.
$password = '1620klofty';                 // Your database password. If your database has no password, leave it empty.

// Let's connect to host
mysql_connect($hostname, $username, $password) or DIE('Connection to host is failed, perhaps the service is down!');
// Select the database
mysql_select_db($dbname) or DIE('Database name is not available!');
?>