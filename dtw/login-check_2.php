<?php 

// Inialize session
session_start();
// Include database connection settings
require_once('includes/config.php');
require_once("includes/logTracker.php");
$M_module =7;
$email = $_POST['email'];
$password= $_POST['password'];
//Create query
	 $qry="SELECT * FROM other_users WHERE staff_email='$email' AND staff_password='$password'";
	
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
			$_SESSION['database'] = 'evidence_action';
			
			session_write_close();
			//Logging the action of logging in
			$action="Logged In";
			
			if(strpos($_SESSION['staff_role'],'Vendor') !==false ){
				$description="A Guest Vendor ".$_SESSION['staff_name']." with the email account ".$_SESSION['staff_email']." has logged in";
				$ArrayData = array($M_module, $action, $description);
				quickFuncLog($ArrayData);
				header("location:processData/materials_packing.php");

			}else if(stripos($_SESSION['staff_role'],'teacher') !==false || stripos($_SESSION['staff_role'],'master') !==false ){
				$description="A Guest Teacher or Master Trainer ".$_SESSION['staff_name']." with the email account ".$_SESSION['staff_email']." has logged in";
				$ArrayData = array($M_module, $action, $description);
				quickFuncLog($ArrayData);
				header("location:processData/materials_tts.php");

			}else{
			header("location: otherIndex.php");	
			}

			
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
