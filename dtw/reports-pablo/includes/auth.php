<?php

// Inialize session
// Check, if email session is NOT set then this page will jump to login page
if (!isset($_SESSION['email'])) {
  header('Location: index.php');
}
?>
