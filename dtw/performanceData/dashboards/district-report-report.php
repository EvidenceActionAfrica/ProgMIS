<?php 


	require_once ("../../includes/auth.php"); //use root
	require_once ('../../includes/config.php'); // use root
	include "includes/class.ntd.php";
	$ntd = new ntd;
	$data = $ntd->runQuery();


 ?>