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
    <div class="header">
      <div style="float: left">  <img src="../../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-PerformanceData.php"); ?>
      </div>
        <center>
      <div class="contentBody">

        <h1 style="text-align: center; margin-top: 0px" class="padding-bottom-10  ">Performance Data</h1>
       
       
        <div class="dashboardMenu1" style="width: 86%;">
          <!-- Counties-->
          <a href="../reports/national_reports.php"><div class="menuTile menu-tile-25" style="background-color: #005608;width: 30%;" onMouseOut="this.style.backgroundColor = '#005608'" onMouseOver="this.style.backgroundColor = '#005608'">
              National<br/><br/>
              <img align="middle" src="../../images/counties.png" height="100px"/>
            </div> </a>
          <!-- Districts -->
          <!-- Counties-->
          <a href="../reports/county_reports.php"><div class="menuTile menu-tile-25" style="background-color: #202640;width: 28%" onMouseOut="this.style.backgroundColor = '#202640'" onMouseOver="this.style.backgroundColor = '#1A213F'">
              County<br/><br/>
              <img align="middle" src="../../images/county.png" height="100px"/>
            </div> </a>
             <!-- Districts -->
          <a href="../reports/district_reports.php"><div class="menuTile menu-tile-35" style="background-color: #C4546A;width: 28%;" onMouseOut="this.style.backgroundColor = '#C4546A'" onMouseOver="this.style.backgroundColor = '#D85D75'">
              Sub-County<br/><br/>
              <img align="middle" src="../../images/districts.png"/>
            </div> </a>
        
         
        </div>
           
            <div class="dashboardMenu2" style="width: 86%;">
         
          <!-- MoH Contacts  -->
          

             <a href="../dashboards/comprehensiveAll.php"><div class="menuTile menu-tile-longest" style="background-color: #202640; width: 200px" onMouseOut="this.style.backgroundColor = '#202640'" onMouseOver="this.style.backgroundColor = '#202640'">
             KPIs<br/><br/>
              <img align="middle" src="../../images/files2.png" height="100px"/>
            </div> </a>
          <a href="../dashboards/dashboard_attnt.php"><div class="menuTile menu-tile-longest" style="background-color: #C4546A; width: 200px" onMouseOut="this.style.backgroundColor = '#C4546A'" onMouseOver="this.style.backgroundColor = '#C4546A'">
              Forms<br/><br/>
              <img align="middle" src="../../images/files2.png" height="100px"/>
            </div> </a>
          <a href="../reports/on_demande.php"><div class="menuTile menu-tile-longer" style="background-color: #2A4E5C; width: 200px;" onMouseOut="this.style.backgroundColor = '#2A4E5C'" onMouseOver="this.style.backgroundColor = '#305968'">
              On Demand <br/><br/>
              <img align="middle" src="../../images/planning.png" height="100px"/>
            </div> </a>
          <a href="#"><div class="menuTile menu-tile-longest" style="background-color: #606060; width: 200px" onMouseOut="this.style.backgroundColor = '#606060'" onMouseOver="this.style.backgroundColor = '#606060'">
              Diagnostic<br/><br/>
              <img align="middle" src="../../images/files2.png" height="100px"/>
            </div> </a>
        </div>
      

        <!--================================================-->
      </div> </center><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->

  </body>
</html>












