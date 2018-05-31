<?php

// Inialize session
session_start();
// Check, if email session is NOT set then this page will jump to login page
if (!isset($_SESSION['staff_email'])) {
  header('Location: ../index.php');
}
?>
