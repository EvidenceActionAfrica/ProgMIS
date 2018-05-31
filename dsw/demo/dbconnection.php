<?php
	$host="localhost";
	$user="root";
	$password="";
	$database="eric";
	$con = mysql_connect($host,$user,$password) or die("Not connection established"); 
	mysql_select_db($database,$con)or die("could not establish the connection to the database");
?>