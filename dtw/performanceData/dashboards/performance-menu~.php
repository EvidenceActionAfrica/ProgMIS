<?php 
//require_once ("../../includes/auth.php"); 
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); // use root

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
    <div class="header" style="height: 100px" >
      <div style="float: left">  <img src="../../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); 
        require_once ("includes/loginInfo.php");
        ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-PerformanceData.php"); ?>
      </div>
      <div class="contentBody">

        <h2 style="text-align: center; margin-top: 0px">Performance Data</h2>

        <center>
        <div class="dashboardMenu1">
          <!-- Counties-->
          <a href="../reports/national_reports.php"><div class="menuTile menu-tile-margin" style="background-color: #202640; width: 40%" onMouseOut="this.style.backgroundColor = '#202640'" onMouseOver="this.style.backgroundColor = '#1A213F'">
              National<br/><br/>
              <img align="middle" src="../../images/counties.png" height="100px"/>
            </div> </a>
          <!-- Districts -->
          <!-- Counties-->
          <a href="../reports/county_reports.php"><div class="menuTile" style="background-color: #202640; width: 20%" onMouseOut="this.style.backgroundColor = '#202640'" onMouseOver="this.style.backgroundColor = '#1A213F'">
              County<br/><br/>
              <img align="middle" src="../../images/county.png" height="100px"/>
            </div> </a>


          <!-- Schools -->
          <a href="reporting.php"><div class="menuTile menu-tile-long" style="background-color: #2A4E5C; width: 20%" onMouseOut="this.style.backgroundColor = '#2A4E5C'" onMouseOver="this.style.backgroundColor = '#305968'">
              Comprehensive<br/><br/>
              <img align="middle" src="../../images/files2.png" height="100px"/>
            </div> </a>
        </div>
        <div class="dashboardMenu2">
          <!-- Districts -->
          <a href="../reports/standardized_reports_districts.php"><div class="menuTile .menu-tile menu-tile-margin" style="background-color: #C4546A; width: 20%" onMouseOut="this.style.backgroundColor = '#C4546A'" onMouseOver="this.style.backgroundColor = '#D85D75'">
              District<br/><br/>
              <img align="middle" src="../../images/districts.png" height="100px"/>
            </div> </a>
          <!-- MoH Contacts  -->
          <a href="../reports/performance_data.php"><div class="menuTile menu-tile-long" style="background-color: #2A4E5C; width: 20%" onMouseOut="this.style.backgroundColor = '#2A4E5C'" onMouseOver="this.style.backgroundColor = '#305968'">
              On Demand <br/><br/>
              <img align="middle" src="../../images/planning.png" height="100px"/>
            </div> </a>
          <!-- MoEST Contacts -->
          <a href="dashboard_forms.php"><div class="menuTile menu-tile" style="background-color: #005608;width: 40%" onMouseOut="this.style.backgroundColor = '#005608'" onMouseOver="this.style.backgroundColor = '#003F05'">
              Dash Boards<br/><br/>
              <img align="middle" src="../../images/files2.png" height="100px"/>
            </div> </a>
           <!-- Master Trainers  -->
           <!-- <a href="masterTrainers.php"><div class="menuTile" style="background-color: #8E6105; width: 220px" onMouseOut="this.style.backgroundColor = '#8E6105'" onMouseOver="this.style.backgroundColor = '#9E6B06'">
              Master Trainers <br/>
              <img align="middle" src="../../images/master_trainers.png" height="100px"/>
            </div> </a> -->
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












