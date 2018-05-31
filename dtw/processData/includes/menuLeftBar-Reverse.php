<?php
$email = $_SESSION['email'];
$level = $_SESSION['level'];
$staffid = $_SESSION['staffid'];
?>

<h3>Requisition List</h3>
<ul>
 <?php  $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  ?>
 <a href="reverse1.php"><li <?php if (strpos($url,'assumptions.php') !== false) { echo 'class="linkActive"';} ?> >Form A</li></a>
 <a href="reverse2.php"><li <?php if (strpos($url,'schoolList.php') !== false) { echo 'class="linkActive"';} ?>  >Form S</li></a>
 <a href="reverse3.php"><li <?php if (strpos($url,'districtList.php') !== false) { echo 'class="linkActive"';} ?> >Form Attnt</li></a>
 <a href="reverse4.php"><li <?php if (strpos($url,'countyAlbList.php') !== false) { echo 'class="linkActive"';} ?> >Form D</li></a>
 <a href="reverse5.php"><li <?php if (strpos($url,'countyPzqList.php') !== false) { echo 'class="linkActive"';} ?> >Form MT-P</li></a>
 
 
</ul>
<br/>


<br/>
<!--<h3>Finance</h3>
<ul>
 <a href="#"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?> >link</li></a>
 <a href="#"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?>  >link</li></a>
</ul>
<br/>
<h3>Materials</h3>
<ul>
 <a href="#"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?> >DT training materials</li></a>
 <a href="#"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?> >TTS trng mtrls</li></a>
 <a href="#"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?>  >Print List</li></a>
 <a href="#"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?>  >Poles</li></a>
</ul>
<br/>
<h3>Monitoring</h3>
<ul>
 <a href="#"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?> >link 1</li></a>
 <a href="#"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?> >link 2</li></a>
</ul>
<br/>
<h3>MT Roll-Out</h3>
<ul>
 <a href="#"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?> >link 1</li></a>
 <a href="#"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?> >link 2</li></a>
</ul>-->
<br/>