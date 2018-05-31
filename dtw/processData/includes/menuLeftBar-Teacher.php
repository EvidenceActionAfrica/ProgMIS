<?php
$email = $_SESSION['email'];
$level = $_SESSION['level'];
$staffid = $_SESSION['staffid'];
?>

   
 <?php  $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  ?>

<h3>Tracking</h3>
<ul>
 <a href="materials_tts.php"><li <?php if (strpos($url,'materials_tts.php') !== false) { echo 'class="linkActive"';} ?> >Teacher Training Boxes Usage</li></a>

</ul>