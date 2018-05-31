<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_counties = $row['priv_counties'];
  
  
  
  
  
}


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
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-ProcessData.php");
         // require_once ("includes/loginInfo.php");
        ?>
      </div>
      <div class="contentBody">
        <h1 style="text-align: center; margin-top: 0px">Process Data</h1>
        <center>
          <div class="dashboardMenu1">
            
            <!-- Rollout schedule & MT Planning -->
            <a href="../rolloutSchedule"><div class="menuTile" style="background-color: #2E6889; width: 43.6%;border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#2E6889'" onMouseOver="this.style.backgroundColor = '#24526B'">
                Rollout schedule <br/>& MT Planning <br/><br/>
                <img align="middle" src="../images/files.png" height="100px"/>
              </div> </a> 
	   <!-- Materials -->
            <a href="materials_printlist.php"><div class="menuTile" style="background-color: #2A4E5C; width: 43.6%;border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#2A4E5C'" onMouseOver="this.style.backgroundColor = '#305968'">
                Materials Printing <br/> & Dispatch  <br/><br/>
                <img align="middle" src="../images/files2.png" height="100px"/>
              </div> </a>
          </div>

          <div class="dashboardMenu2">
            
            <!-- Reverse Cascade  -->
            <a href="reverse-cascade/return-sad.php"><div class="menuTile" style="background-color: #005608; width: 43.6%;border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#005608'" onMouseOver="this.style.backgroundColor = '#003F05'">
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












