<?php
$email = $_SESSION['email'];
$level = $_SESSION['level'];
$staffid = $_SESSION['staffid'];
?>

<h3>Materials</h3>
<ul>
 <a href="materials_printlist.php"><li <?php if (strpos($url,'materials_printlist.php') !== false) { echo 'class="linkActive"';} ?>  >Print List</li></a>
 <a href="materials_extra.php"><li <?php if (strpos($url,'materials_extra.php') !== false) { echo 'class="linkActive"';} ?>  >Extra Materials</li></a>
 <a href="collect_training_materials.php"><li <?php if (strpos($url,'collect_training_materials.php') !== false) { echo 'class="linkActive"';} ?> >Training Materials</li></a>
 <a href="document_intake_log.php"><li <?php if (strpos($url,'document_intake_log.php') !== false) { echo 'class="linkActive"';} ?> >Doc. Intake Log</li></a>
 <a href="packet_calculation.php"><li <?php if (strpos($url,'packet_calculation.php') !== false) { echo 'class="linkActive"';} ?> >Pckt Calculations</li></a>
 <a href="pole_movement.php"><li <?php if (strpos($url,'pole_movement.php') !== false) { echo 'class="linkActive"';} ?> >Pole Movement</li></a>
</ul>
<br/>
<h3>Constants</h3>
<ul>
 <a href="rate_per_km.php" onclick="javascript:void window.open('rate_per_km.php', '1397210634467', 'width=1050,height=500,status=1,scrollbars=1,resizable=1,left=150,top=0'); return false;"><li>Edit Rate per KM</li></a>
 <a href="packet_assumptions.php"><li <?php if (strpos($url,'packet_assumptions.php') !== false) { echo 'class="linkActive"';} ?>  >Packet Assumptions</li></a>
</ul>
<br/>