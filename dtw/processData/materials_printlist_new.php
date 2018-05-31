<?php
$tabActive = "tab1";
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
   
      <?php
      require_once ("includes/meta-link-script.php");
      ?>
    
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
      <?php   require_once ("includes/menuNav.php");  ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-Materials.php");
        ?>
      </div>
<!-- <script type="text/javascript" src="css/bootstrap/bootstrap.css"></script> -->
<link rel="stylesheet" href="css/bootstrap/bootstrap.css"  type="text/css" media="screen" />
<script type="text/javascript" src="css/bootstrap/bootstrap-tab.js"></script>
<div style="">

<!--tab skeleton-->
<div class="tabbable" >
  <ul class="nav nav-tabs">
    <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">PrintList Assumptions</a></li>
    <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">Master Trainers Packet</a></li>
    <li class="<?php if ($tabActive == 'tab3') echo 'active'; ?>"><a href="#tab3" data-toggle="tab">Regional Training Boxes</a></li>
        <li class="<?php if ($tabActive == 'tab4') echo 'active'; ?>"><a href="#tab4" data-toggle="tab">Teacher Training Boxes</a></li>
       <li class="<?php if ($tabActive == 'tab5') echo 'active'; ?>"><a href="#tab5" data-toggle="tab">Extra Materials</a></li>
       <li class="<?php if ($tabActive == 'tab6') echo 'active'; ?>"><a href="#tab6" data-toggle="tab">Print Order</a></li>
    
  </ul>
  <div class="tab-content">
    <!--tab 1-->
    <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
      <p><?php require_once("printlistAssumptionsList.php"); ?></p>
    </div>
    <!--tab 2-->
    <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
       <p><?php //require_once("materials_mt_packet.php"); ?></p>
    </div>
    <!--tab 3-->
    <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
       <p><?php require_once("materials_rtraining_boxes.php"); ?></p>
    </div>
      <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">
      <p><?php require_once("materials_ttraining_boxes.php"); ?></p>
    </div>
      <div class="tab-pane <?php if ($tabActive == 'tab5') echo 'active'; ?>" id="tab5">
    <p><?php require_once("materials_extra.php"); ?></p>
    </div>
      <div class="tab-pane <?php if ($tabActive == 'tab6') echo 'active'; ?>" id="tab6">
            <h2>Print Order</h2>
              <p><?php require_once("materials_printlist_order.php"); ?></p>
    </div>
  </div>
</div>

</div>