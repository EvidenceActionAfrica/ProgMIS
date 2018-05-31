<?php
$email = $_SESSION['email'];
$level = $_SESSION['level'];
$staffid = $_SESSION['staffid'];
?>

<h3>Materials Planning</h3>
<ul>
   
 <?php  $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  ?>
 <a href="materials_general_assumptions.php"><li <?php if (strpos($url,'materials_general_assumptions.php') !== false) { echo 'class="linkActive"';} ?>  >General Assumptions</li></a>
    
 <a href="materials_printlist.php"><li <?php if (strpos($url,'materials_printlist.php') !== false) { echo 'class="linkActive"';} ?>  >Print List</li></a>
 <?php /* ?>
 <a href="materials_extra.php"><li <?php if (strpos($url,'materials_extra.php') !== false) { echo 'class="linkActive"';} ?>  >Extra Materials</li></a>
 <?php */?>
  <a href="materials_print_order.php"><li <?php if (strpos($url,'materials_print_order.php') !== false) { echo 'class="linkActive"';} ?> >Print Order</li></a>
</ul>
<br/>
<h3>Packing & Dispatch</h3>
<ul>
  <hr/>
  <a href="materials_form_p_schoollist.php#selectDivisionFormP"><li <?php if (strpos($url,'materials_form_p_schoollist') !== false) { echo 'class="linkActive"';} ?> >Form P SchlList</li></a>

  <a href="materials_packing.php"><li <?php if (strpos($url,'materials_packing.php') !== false) { echo 'class="linkActive"';} ?> >Vendor Packing</li></a>
  <a href="materials_collecting.php"><li <?php if (strpos($url,'materials_collecting.php') !== false) { echo 'class="linkActive"';} ?> >Materials Dispatch</li></a>

    
</ul>
<br/>
