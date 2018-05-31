<?php
$email = $_SESSION['email'];
$level = $_SESSION['level'];
$staffid = $_SESSION['staffid'];
?>

</ul>
<h3>Rollout</h3>
<ul>
  <a href="../rolloutSchedule"><li <?php if (strpos($url,'rolloutSchedule/index.php') !== false) { echo 'class="linkActive"';} ?> >Roll out Schedule</li></a>
</ul>
<br/>
<h3>Materials</h3>
<ul>
  <a href="materials_general_assumptions.php"><li <?php if (strpos($url,'materials_general_assumptions.php') !== false) { echo 'class="linkActive"';} ?> >Materials Planning</li></a>
  <a href="materials_collecting.php"><li <?php if (strpos($url,'materials_collecting.php.php') !== false) { echo 'class="linkActive"';} ?> >Picking & Dispatch</li></a>
  <a href="materials_tts.php"><li <?php if (strpos($url,'materials_tts.php') !== false) { echo 'class="linkActive"';} ?>  >Tracking</li></a>
  <a href="pole_movement.php"><li <?php if (strpos($url,'pole_movement.php') !== false) { echo 'class="linkActive"';} ?>  >Tablet Poles</li></a>
</ul>
<br/>

<h3>Reverse Cascade</h3>
<ul>
	<a href="reverse-cascade/return-status.php"><li <?php if (strpos($url,'return-status.php') !== false) { echo 'class="linkActive"';} ?> >Financial returns</li></a>
	<a href="reverse-cascade/log-export.php?log=P"><li <?php if (strpos($url,'reverse-cascade/log-export.php?log=P') !== false) { echo 'class="linkActive"';} ?> >Forms</li></a>
        <a href="reverse-cascade/batch-export.php?batch=P"><li <?php if (strpos($url,'reverse-cascade/batch-export.php?batch=P') !== false) { echo 'class="linkActive"';} ?> >Batch Forms</li></a>
        <a href="reverse-cascade/batch-export.php?batch=P"><li <?php if (strpos($url,'href="reverse-cascade/batch-export.php?batch=P"') !== false) { echo 'class="linkActive"';} ?> >Upload Forms</li></a>
        <a href="reverse-cascade/form_d.php#selectDistrictFormD"><li <?php if (strpos($url,'reverse-cascade/form_d.php#selectDistrictFormD') !== false) { echo 'class="linkActive"';} ?> >Input Forms</li></a>
	<!--<a href="form_d.php#selectDistrictFormD"><li <?php if (strpos($url,'form_d') !== false) { echo 'class="linkActive"';} ?> >Form D</li></a>-->
</ul>
<br/>
<br/>
<h3>Reverse Cascade:Upload Forms</h3>
<ul>
 <a href="reverse-cascade/form_dUpload.php"><li <?php if (strpos($url,'form_dUpload') !== false) { echo 'class="linkActive"';} ?> ><!--Form D-->Form E</li></a>
 <a href="reverse-cascade/form_mtUpload.php"><li <?php if (strpos($url,'form_mtUpload') !== false) { echo 'class="linkActive"';} ?> >Form MT</li></a>
 <a href="reverse-cascade/form_sUpload.php"><li <?php if (strpos($url,'form_s_Upload') !== false) { echo 'class="linkActive"';} ?> ><!--Form S-->Form C</li></a>
 <a href="reverse-cascade/form_aUpload.php"><li <?php if (strpos($url,'form_aUpload') !== false) { echo 'class="linkActive"';} ?> ><!--Form A-->Form D</li></a>
<a href="reverse-cascade/form_atttntUpload.php"><li <?php if (strpos($url,'form_atttntUpload') !== false) { echo 'class="linkActive"';} ?> >Form ATTNT</li></a>
<a href="reverse-cascade/import-p.php"><li <?php if (strpos($url,'import-p') !== false) { echo 'class="linkActive"';} ?> >Form P</li></a>

</ul>
<br/>