<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("../includes/meta-link-script.php"); ?>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php  require_once ("includes/menuNav.php"); ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-ProcessData.php");
        ?>
      </div>
      <div class="contentBody">

        <h1 style="text-align: center; margin-top: 0px">Process Data</h1>

        <center>
          <div class="dashboardMenu1">
            <!-- Drugs -->
            <a href="assumptions.php"><div class="menuTile" style="background-color: #202640; width: 25%" onMouseOut="this.style.backgroundColor = '#202640'" onMouseOver="this.style.backgroundColor = '#1A213F'">
                Drugs Planning & Tracking <br/>
                <img align="middle" src="../images/drugs2.png" height="100px"/>
              </div> </a>
            <!-- Finance -->
            <a href="../finance"><div class="menuTile" style="background-color: #C4546A; width: 25%" onMouseOut="this.style.backgroundColor = '#C4546A'" onMouseOver="this.style.backgroundColor = '#D85D75'">
                Finance & Budgeting <br/><br/>
                <img align="middle" src="../images/finance.png" height="100px"/>
              </div> </a>
            <!-- Materials -->
            <a href="materials_printlist.php"><div class="menuTile" style="background-color: #2E6889; width: 35%" onMouseOut="this.style.backgroundColor = '#2E6889'" onMouseOver="this.style.backgroundColor = '#24526B'">
                Materials Printing and Dispatch <br/><br/>
                <img align="middle" src="../images/files2.png" height="100px"/>
              </div> </a>
          </div>
          <div class="dashboardMenu2">
            <!-- Rollout schedule & MT Planning   -->
            <a href="../rolloutSchedule"><div class="menuTile" style="background-color: #2A4E5C; width: 30%" onMouseOut="this.style.backgroundColor = '#2A4E5C'" onMouseOver="this.style.backgroundColor = '#305968'">
                Rollout schedule & MT Planning  <br/><br/>
                <img align="middle" src="../images/Master_trainers.png" height="100px"/>
              </div> </a>
            <!-- Materials Printing and Dispatch    -->
            <a href="javascript:void(0)"><div class="menuTile" style="background-color: #8E6105; width: 30%" onMouseOut="this.style.backgroundColor = '#8E6105'" onMouseOver="this.style.backgroundColor = '#9E6B06'">
                Materials Printing and Dispatch   <br/><br/>
                <img align="middle" src="../images/files.png" height="100px"/>
              </div> </a>
            <!-- 	Reverse Cascade  -->
            <a href="javascript:void(0)"><div class="menuTile" style="background-color: #005608; width: 25%" onMouseOut="this.style.backgroundColor = '#005608'" onMouseOver="this.style.backgroundColor = '#003F05'">
               	Reverse Cascade<br/><br/>
                <img align="middle" src="../images/tracking.png" height="100px"/>
              </div> </a>
          </div>
        </center>

        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->

  </body>
</html>












