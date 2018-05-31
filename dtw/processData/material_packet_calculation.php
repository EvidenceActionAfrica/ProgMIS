<?php
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
    <link rel="stylesheet" type="text/css" href="css/modal.css"/>

    <link href="../css/tabs_css.css" rel="stylesheet" type="text/css">
      <?php
      require_once ("../includes/meta-link-script.php");
      ?>
      <script src="../js/tabs.js"></script>

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
      <div class="contentBody" >
        <div id="tabContainer">
          <div id="tabs">
            <ul>
              <li id="tabHeader_1">Packet Assumptions</li>
              <li id="tabHeader_2">Packet Calculations</li>
            </ul>
          </div>
          <div id="tabscontent" style="max-height:650px; overflow:scroll;">
            <div class="tabpage" id="tabpage_1">
              <p><?php require_once("packet_assumptions.php"); ?></p>
            </div>

            <div class="tabpage" id="tabpage_2">
              <p><?php require_once("packet_calculation.php"); ?></p>
            </div>
           
          </div>
        </div>

        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->

  </body>
</html>

