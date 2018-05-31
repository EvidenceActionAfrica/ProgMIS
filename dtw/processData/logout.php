<?php
// Inialize session
session_start();
// Delete certain session
unset($_SESSION['staff_email']);
unset($_SESSION['staff_level']);
unset($_SESSION['staff_staffid']);
// Delete all session variables
// session_destroy();
// Jump to login page
header('Location: ../index.php');
?>
