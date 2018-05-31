<?php
$email = $_SESSION['email'];
$level = $_SESSION['level'];
$staffid = $_SESSION['staffid'];
?>

<h3>Drugs</h3>
<ul>
 <?php  $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  ?>
 <a href="assumptions.php"><li <?php if (strpos($url,'assumptions.php') !== false) { echo 'class="linkActive"';} ?> >Assumptions</li></a>
 <a href="districtList.php"><li <?php if (strpos($url,'districtList.php') !== false) { echo 'class="linkActive"';} ?> >District Requisition</li></a>
 <a href="assumptions_summary_sheet.php"><li <?php if (strpos($url,'assumptions_summary_sheet.php') !== false) { echo 'class="linkActive"';} ?> >National Requisition Summary</li></a>

<br/>
<h3>Materials</h3>
<ul>
 <a href="materials_printlist.php"><li <?php if (strpos($url,'materials_printlist.php') !== false) { echo 'class="linkActive"';} ?>  >Print List</li></a>
 <a href="material_packet_calculation.php"><li <?php if (strpos($url,'material_packet_calculation.php') !== false) { echo 'class="linkActive"';} ?>  >Pkt Calculations</li></a>
<a href="materials_quote.php"><li <?php if (strpos($url,'materials_quote.php') !== false) { echo 'class="linkActive"';} ?>  >Vendor Quote</li></a>

<a href="materials_collecting.php"><li <?php if (strpos($url,'collect_training_materials.php') !== false) { echo 'class="linkActive"';} ?>  >Inventory Management</li></a>

</ul>
<br/>
<h3>Finance</h3>
<ul>
 <a href="../finance/?view=budget&cat=district"><li <?php if (strpos($url,'../finance/?view=budget&cat=district') !== false) { echo 'class="linkActive"';} ?> >District Training</li></a>
 <a href="../finance/?view=budget&cat=teacher"><li <?php if (strpos($url,'../finance/?view=budget&cat=teacher') !== false) { echo 'class="linkActive"';} ?> >Teacher Training</li></a>
 <a href="../finance/?view=budget&cat=dday"><li <?php if (strpos($url,'../finance/?view=budget&cat=dday') !== false) { echo 'class="linkActive"';} ?> >Deworming Day</li></a>

</ul>
<br/>
<h3>MT Roll-Out</h3>
<ul>
 <a href="../rolloutSchedule/"><li <?php if (strpos($url,'../rolloutSchedule/') !== false) { echo 'class="linkActive"';} ?> >Roll out Activity Waves</li></a>
</ul>
<br/>

<h3>Reverse Cascade</h3>
<ul>
	<a href="reverse-cascade/return-status.php"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?> >Form Returns</li></a>
	<a href="form_d.php#selectDistrictFormD"><li <?php if (strpos($url,'form_d') !== false) { echo 'class="linkActive"';} ?> >Form D</li></a>

 <!-- <a href="form_attnt.php"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?> >Form ATTNT</li></a>
 <a href="view_form_attnt.php"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?> >View Form ATTNT</li></a>
 <a href="reve rse2.php"><li <?php if (strpos($url,'4444') !== false) { echo 'class="linkActive"';} ?> >Reverse 2</li></a> -->
</ul>
<br/>