<?php 
// Inialize session
session_start();
// Include database connection settings
require_once('includes/config.php');
$email = $_POST['email'];
$password= $_POST['password'];
//Create query
	$qry="SELECT * FROM staff WHERE staff_email='$email' AND staff_password='$password'";
	$result=mysql_query($qry);
	
	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result) == 1) {
			//Login Successful
			session_regenerate_id();
			$member = mysql_fetch_assoc($result); 
			$_SESSION['staff_id'] = $member['staff_id'];
			$_SESSION['staff_name'] = $member['staff_name'];
			$_SESSION['staff_email'] = $member['staff_email'];
			$_SESSION['staff_mobile'] = $member['staff_mobile'];
			$_SESSION['staff_level'] = $member['staff_level'];
			$_SESSION['staff_role'] = $member['staff_role'];
			$_SESSION['staff_title'] = $member['staff_title'];
			$_SESSION['signatureurl'] = $member['signatureurl'];

			session_write_close();
			header("location:home.php");
			exit();
		}
		else 
		{
			//echo "Login failed";
			header("location: index.php");
			exit();
		}
	}
?>
