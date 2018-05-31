<?php
require_once('../includes/auth.php');
require_once('../includes/config.php');

require_once("../includes/functions.php");
require_once("../includes/form_functions.php");

    $staff_name = $_SESSION['staff_name'];
        $staff_email = $_SESSION['staff_email'];
        $staff_level = $_SESSION['staff_level'];
        $staff_id = $_SESSION['staff_id'];
        // echo  $_SESSION['database'];
        require_once("../includes/loginInfo.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>
    
  </head>


  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
    
        <div class="dashboardMenu1" style="margin: 10% 0% 0% 35%">
      
          <!-- Issue Tracking-->
          <a href="issuesAll.php"><div class="dashboardTile" style="background-color: #C4546A; width: 20%" onMouseOut="this.style.backgroundColor = '#C4546A'" onMouseOver="this.style.backgroundColor = '#D85D75'">
              Issues <br/>
              <img align="middle" src="../images/tracking.png" height="100px"/>
            </div> </a>

          <!-- Communication -->
          <a href="../communication/"><div class="dashboardTile" style="background-color: #2E6889; width: 15%" onMouseOut="this.style.backgroundColor = '#24526B'" onMouseOver="this.style.backgroundColor = '#24526B'">
              Communication<br/><img align="middle" src="../images/sms.png" height="100px"/>
            </div> </a>

        
        </div>
      
   </div>
    <div class="clearFix"></div>
  
  </body>
</html>


