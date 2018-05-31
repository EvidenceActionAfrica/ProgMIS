<?php

// Inialize session
session_start();
// Check, if email session is NOT set then this page will jump to login page


if (!isset($_SESSION['staff_email'])) {
	//get the url of current page
	$getUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	// if its the dashboard page
	// use the following header
	if (strpos($getUrl,'dashboard') !== false) {
	  header('Location: ../../index.php');

	}else{
	  header('Location: index.php');

	}
}
	
?>
