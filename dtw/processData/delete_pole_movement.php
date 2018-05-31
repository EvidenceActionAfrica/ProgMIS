<?php
require_once ('../includes/config.php');
$pole_id = $_GET[pole_id];
// sending query
mysql_query("DELETE FROM pole_movement WHERE pole_id = '$pole_id'")
or die(mysql_error());  	
header("Location: pole_movement.php");

?>