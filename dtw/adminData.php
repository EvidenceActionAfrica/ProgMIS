<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_counties = $row['priv_counties'];
  $priv_districts = $row['priv_districts'];
  $priv_divisions = $row['priv_divisions'];
  $priv_schools = $row['priv_schools'];
  $priv_moh = $row['priv_moh'];
  $priv_moest = $row['priv_moest'];
  $priv_master_trainers = $row['priv_master_trainers'];
  
  
  
}
if($priv_master_trainers<=0 && $priv_moest<=0 && $priv_moh<=0 && $priv_schools<=0 && $priv_divisions<=0 && $priv_districts<=0 && $priv_counties<=0){
    header("Location:home.php");
}
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
      <div style="float: left">  <img src="images/logo.png" />  </div>
      <div class="menuLinks">
        <?php
        require_once ("includes/menuNav.php");
        require_once ("includes/loginInfo.php");
        ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-AdminData.php");
        ?>
      </div>
      <div class="contentBody">

        <h1 style="text-align: center; margin-top: 0px">Administrative Data</h1>

        <center>
        <div class="dashboardMenu1">
          <!-- Counties-->
          <a href="counties.php"><div class="menuTile" style="background-color: #202640; width: 21%;border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#202640'" onMouseOver="this.style.backgroundColor = '#1A213F'">
              Counties<br/><br/> 
              <img align="middle" src="images/counties.png" height="100px"/>
            </div> </a>
          <!-- Districts -->
          <a href="districts.php"><div class="menuTile" style="background-color: #C4546A; width:20.8%;border-radius: 10px; " onMouseOut="this.style.backgroundColor = '#C4546A'" onMouseOver="this.style.backgroundColor = '#D85D75'">
              Sub Counties<br/><br/>
              <img align="middle" src="images/districts.png" height="100px"/>
            </div> </a>
          <!-- Divisions-->
          <a href="divisions.php"><div class="menuTile" style="background-color: #2E6889; width: 20.8%;border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#2E6889'" onMouseOver="this.style.backgroundColor = '#24526B'">
              Divisions<br/> <br/>
              <img align="middle" src="images/divisions.png" height="100px"/>
            </div> </a>
          <!-- Schools -->
          <a href="schools.php"><div class="menuTile" style="background-color: #2A4E5C; width: 21%;border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#2A4E5C'" onMouseOver="this.style.backgroundColor = '#305968'">
              Schools<br/> <br/>
              <img align="middle" src="images/schools.png" height="100px"/>
            </div> </a>
        </div>
        <div class="dashboardMenu2">
          <!-- MoH Contacts  -->
          <a href="health_contacts.php"><div class="menuTile" style="background-color: #2A4E5C; width: 29%;border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#2A4E5C'" onMouseOver="this.style.backgroundColor = '#305968'">
              MoH Contacts <br/><br/>
              <img align="middle" src="images/users2.png" height="100px"/>
            </div> </a>
          <!-- MoEST Contacts -->
          <a href="education_contacts.php"><div class="menuTile" style="background-color: #005608; width: 29%;border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#005608'" onMouseOver="this.style.backgroundColor = '#003F05'">
              MoEST Contacts<br/> <br/>
              <img align="middle" src="images/adminData.png" height="100px"/>
            </div> </a>
           <!-- Master Trainers  -->
           <a href="masterTrainers.php"><div class="menuTile" style="background-color: #8E6105; width: 29%;border-radius: 10px;" onMouseOut="this.style.backgroundColor = '#8E6105'" onMouseOver="this.style.backgroundColor = '#9E6B06'">
              Master Trainers <br/><br/>
              <img align="middle" src="images/master_trainers.png" height="100px"/>
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





 
  
  
  
  
  
  
  