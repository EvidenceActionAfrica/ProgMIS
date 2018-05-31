<link rel="stylesheet" type="text/css" href="css/vstyle.css">
<?php
require_once('includes/auth.php');
require_once("includes/functions.php");
require_once("includes/form_functions.php");
?>

<?php
$email = $_SESSION['email'];
$level = $_SESSION['level'];
$staffid = $_SESSION['staffid'];
?>
<div class="header">
  <div style="float: left">  <img src="images/logo.png">  </div>
  <div class="menuLinks">
    <nav>
      <ul>
        <li><a href="home.php">HOME</a></li>
        <li>
          <a href="countyView.php">ADMINISTRATIVE DATA</a>
          <!--          <ul>
                      <li><a href=""><img src="images/menu-line.png"></a></li>
                      <li><a href="schoolsView.php">ID data</a></li>
                      <li><a href="educationView.php">Educational &amp; Health Data</a></li>
                      <li><a href="masterTrainerView.php">Master Trainer Data</a></li>
                      <li><a href="form_s.php">Treatment Forms</a></li>
                    </ul>-->
        </li>
        <li><a href="logout.php">PROCESS DATA </a></li>
        <li>
          <a href="#">PERFORMANCE DATA</a>
          <ul>
            <li><a href=""><img src="images/menu-line.png"></a></li>
            <li><a href="reports/standardized_reports.php">Standardized Reports</a></li>
            <li><a href="#">On Demand Reports</a></li>
            <li><a href="#">Export Data</a></li>
          </ul>
        </li>
        <li><a href="logout.php">LogOut </a></li>
      </ul>
      <?php require_once("includes/loginInfo.php"); ?>

    </nav>
  </div>
</div>

<div class="contentMain">

  <div class="contentLeft">
   
<h3>ID DATA</h3>
<ul>
  <a href="schools.php"><li>Schools</li></a>
  <!--<a href="counties.php"><li>Counties</li></a>-->
  <a href="divisions.php"><li>Divisions</li></a>
  <a href="districts.php"><li>Districts</li></a>
</ul>
<h3>Contact Details</h3>
<ul>
  <a href="health_contacts.php"><li>MoH</li></a>
  <a href="education_contacts.php"><li>MoEST</li></a>
</ul>
<h3>Master trainers</h3>
<ul>
  <a href="masterTrainers.php"><li>Master Trainers</li></a>
</ul>
<!--    <h3>Treatment Forms</h3>
    <ul>
      <a href="form_s.php"><li>Form_S</li></a>
      <a href="formA.php"><li>Form_A</li></a>
      <a href="formD.php"><li>Form_D</li></a>
      <a href="form_attnt.php"><li>ATTNT</li></a>
      <a href="form_mtp.php"><li>MTP</li></a>
    </ul> -->
  </div>