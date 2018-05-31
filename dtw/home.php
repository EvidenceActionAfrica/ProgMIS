<?php
require_once('includes/auth.php');
require_once('includes/config.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("includes/functions.php");
require_once("includes/form_functions.php");

$staff_name = $_SESSION['staff_name'];
$staff_email = $_SESSION['staff_email'];
$staff_level = $_SESSION['staff_level'];
$staff_id = $_SESSION['staff_id'];
// echo  $_SESSION['database'];

/* <This section sets the default year to be displayed after login> */
if (!isset($_REQUEST['change_years'])) {
	$_SESSION['database'] = 'evidence_action_year6';
	}
/* </This section sets the default year to be displayed after login> */

require_once("includes/loginInfo-home.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once("includes/meta-link-script.php"); ?>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="images/logo.png" />  </div>
      <div class="menuLinks">

        <div style="width: 200px; float: left; margin-left: 100px">
          <!--Notifications dashboard-->
          <?php
          $sql = "SELECT handledby from issues WHERE handledby='" . $staff_name . "' AND status !='Resolved'";
          //echo $sql;
          $resultA = mysql_query($sql);
          $numIssues = mysql_affected_rows();
          if ($numIssues == -1) {
            $numIssues = 0;
          }
          ?>
          <table>
            <tr onclick="relocate();">
              <td><b class="notificationTitle">Pending Issues </b></td>
              <td><b class="notificationTitle"> : </b></td>
              <td><b class="notificationContent"> <?php echo $numIssues; ?> </b></td>

            </tr>
            <!-- 
                          <tr>
                          <td><b class="notificationTitle">New Emails </b></td>
                          <td><b class="notificationTitle"> : </b></td>
                          <td><b class="notificationContent"> 1 </b></td>
                        </tr>
                        <tr>
                          <td><b class="notificationTitle">Pending tasks </b></td>
                          <td><b class="notificationTitle"> : </b></td>
                          <td><b class="notificationContent"> 3 </b></td>
                        </tr>-->
          </table>


        </div>
        <?php
        ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain" style="margin: 0px auto">
      <!--<div class="contentBody" style="margin: 0px auto">-->
      <center>
        <div class="dashboardMenu1">
          <!-- Administrative data-->
          <a href="adminData.php"><div class="dashboardTile" style="background-color: #202640; width: 30%; border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#202640'" onMouseOver="this.style.backgroundColor = '#1A213F'">
              <font style="text-align: left">Administrative Data</font><br/><br/>
              <img align="middle" src="images/adminData.png" height="100px"/>
            </div></a>
          <!-- Process Data -->
          <a href="processData"><div class="dashboardTile" style="background-color: #005608; width: 30%;  border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#005608'" onMouseOver="this.style.backgroundColor = '#003F05'">
              Process Data<br/><br/>
              <img align="middle" src="images/process_data.png" height="100px"/>
            </div> </a>
          <!-- Reports-->
          <a href="performanceData/reports/performance-menu.php"><div class="dashboardTile" style="background-color: #2E6889; width: 30%;  border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#2E6889'" onMouseOver="this.style.backgroundColor = '#24526B'">
              Performance & <br/>Reporting Data<br/>
              <img align="middle" src="images/reports.png" height="100px"/>
            </div> </a>



        </div>
        <div class="dashboardMenu2">
          <!-- System Settings-->
          <a href="settings/"><div class="dashboardTile" style="background-color: #2A4E5C; width: 23%;  border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#2A4E5C'" onMouseOver="this.style.backgroundColor = '#305968'">
              System Settings<br/><br/>
              <img align="middle" src="images/settings.png" height="100px"/>
            </div> </a>
          <!-- Issue Tracking-->
          <a href="issueTracker/issuesAll.php"><div class="dashboardTile" style="background-color: #C4546A; width: 20.5%;  border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#C4546A'" onMouseOver="this.style.backgroundColor = '#D85D75'">
              Issue<br/>Tracking <br/>
              <img align="middle" src="images/tracking.png" height="100px"/>
            </div> </a>
          <!-- Planning & Schedule -->
          <!---
          <a href="#"><div class="dashboardTile" style="background-color: #8E6105; width: 18%" onMouseOut="this.style.backgroundColor = '#8E6105'" onMouseOver="this.style.backgroundColor = '#9E6B06'">
              Planning & <br/>Schedule <br/>
              <img align="middle" src="images/planning.png" height="100px"/>
            </div> </a>
          -->
          <!-- Communication -->
          <a href="communication"><div class="dashboardTile" style="background-color: #2E6889; width: 20.5%;  border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#24526B'" onMouseOver="this.style.backgroundColor = '#24526B'">
              Communication<br/><br/> <img align="middle" src="images/communication.png" height="100px"/>
            </div> </a>

          <!-- User Management-->
          <?php if ($priv_staff >= 4) { ?>
            <a href="staff.php"><div class="dashboardTile" style="background-color: #102640; width: 23%; border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#202640'" onMouseOver="this.style.backgroundColor = '#1A213F'">
                Users & User Management<br/><br/>
                <img align="middle" src="images/users.png" width="150px"/>
              </div> </a>
          <?php } else { ?>
            <a href="staffAccount.php"><div class="dashboardTile" style="background-color: #102640; width: 23%; border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#202640'" onMouseOver="this.style.backgroundColor = '#1A213F'">
                Account Management<br/><br/>
                <img align="middle" src="images/users.png" width="150px"/>
              </div> </a>
          <?php } ?>
        </div>
      </center>
      <!--</div>-->
      <!--<iframe width="100%" height="500px" src="http://maestros-ites.com/testserver1/evidence_action/standardized_reports.php"></iframe>>-->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->
  </body>
</html>

