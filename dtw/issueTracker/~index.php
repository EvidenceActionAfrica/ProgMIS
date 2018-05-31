<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
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
        <?php
        require_once ("includes/menuNav.php");
        ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-IssueTracker.php"); ?>
      </div>
      <div class="contentBody">

        <h1 style="text-align: center; margin-top: 0px">Issues Tracker</h1>

         <center>
          <div class="dashboardMenu1">
            <!-- SMS -->
            <a href="comm_sms.php"><div class="menuTile" style="background-color: #8E6105; width: 40%" onMouseOut="this.style.backgroundColor = '#9E6B06'" onMouseOver="this.style.backgroundColor = '#9E6B06'">
                <br/> SMS Communication <br/>  
                <img align="middle" src="../images/sms.png" height="100px"/>
              </div> </a>
            <!-- Email -->
            <a href="comm_emails.php"><div class="menuTile" style="background-color: #2E6889; width: 43%" onMouseOut="this.style.backgroundColor = '#2E6889'" onMouseOver="this.style.backgroundColor = '#24526B'">
                <br/> Email Communication <br/>  
                <img align="middle" src="../images/email.png" height="100px"/>
              </div> </a> 
          </div>

<!--          <div class="dashboardMenu2">
             Materials 
            <a href="materials_printlist.php"><div class="menuTile" style="background-color: #2A4E5C; width: 30%" onMouseOut="this.style.backgroundColor = '#2A4E5C'" onMouseOver="this.style.backgroundColor = '#305968'">
                Materials Printing <br/> & Dispatch  <br/><br/>
                <img align="middle" src="../images/files2.png" height="100px"/>
              </div> </a>
             Finance 
            <a href="../finance"><div class="menuTile" style="background-color: #C4546A; width: 25%" onMouseOut="this.style.backgroundColor = '#C4546A'" onMouseOver="this.style.backgroundColor = '#D85D75'">
                Finance &<br/> Budgeting <br/><br/>
                <img align="middle" src="../images/finance.png" height="100px"/>
              </div> </a>
             Reverse Cascade  
            <a href="reverse-cascade/return-status.php"><div class="menuTile" style="background-color: #005608; width: 25%" onMouseOut="this.style.backgroundColor = '#005608'" onMouseOver="this.style.backgroundColor = '#003F05'">
               	Reverse Cascade<br/><br/>
                <img align="middle" src="../images/tracking.png" height="100px"/>
              </div> </a>
          </div>-->
        </center> 

        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->

  </body>
</html>












