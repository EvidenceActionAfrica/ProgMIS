<?php
require_once ('../includes/config.php');
$id = $_GET[id];
// sending query
mysql_query("DELETE FROM packet_assumptions WHERE id = '$id'")
or die(mysql_error());  	
header("Location: packet_assumptions.php");

?>