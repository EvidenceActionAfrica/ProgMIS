<?php
require_once ('../includes/config.php');
$id = $_GET[id];
// sending query
mysql_query("DELETE FROM document_intake_log WHERE id = '$id'")
or die(mysql_error());  	
header("Location: document_intake_log.php");

?>