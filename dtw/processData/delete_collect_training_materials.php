<?php
require_once ('../includes/config.php');
$id = $_GET[id];
// sending query
mysql_query("DELETE FROM collect_training_materials WHERE id = '$id'")
or die(mysql_error());  	
header("Location: collect_training_materials.php");

?>