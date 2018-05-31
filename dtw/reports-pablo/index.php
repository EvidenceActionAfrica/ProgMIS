<?php 
	// Inialize session
session_start();
// Check, if user is already login, then jump to secured page
if (isset($_SESSION['email'])) {
  header('Location: performance_data.php');
} else {
	header('Location: ../index.php');
	exit;
}
?>