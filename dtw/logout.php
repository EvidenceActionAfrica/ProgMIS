<?php
require_once('includes/auth.php');
require_once('includes/config.php');
require_once("includes/logTracker.php");
$M_module =7;
// Inialize session
session_start();
//Logging the action of logging out
$action="Logout";
$description="The User ".$_SESSION['staff_name']." with the email account ".$_SESSION['staff_email']." has logged out";
$ArrayData = array($M_module, $action, $description);
quickFuncLog($ArrayData);
// Delete certain session
unset($_SESSION['staff_email']);
unset($_SESSION['staff_level']);
unset($_SESSION['staff_staffid']);
unset($_SESSION['database']);
// Delete all session variables
// session_destroy();
// Jump to login page
header('Location: index.php');
?>
