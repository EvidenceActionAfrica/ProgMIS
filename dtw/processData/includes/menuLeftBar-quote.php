<?php
$email = $_SESSION['email'];
$level = $_SESSION['level'];
$staffid = $_SESSION['staffid'];
?>

   
 <?php  $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  ?>

<ul>
  <a href="materials_packing_strict.php"><li <?php if (strpos($url,'materials_packing_strict.php') !== false) { echo 'class="linkActive"';} ?> >Vendor Packing</li></a>

</ul>