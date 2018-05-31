<?php $filename = basename($_SERVER['PHP_SELF']); ?>
<!--<div class="header">
      <div class="hdmnCnt">
<?php
if (isset($_SESSION['admin_name']) && !empty($_SESSION['admin_name'])) {
  $purl = 'dashboard.php';
} else {
  $purl = 'index.php';
}
?>
      <div class="logo"><a href="<?php echo $purl; ?>"><img src="images/logo.jpg" alt="Evidence Action" border="0" /></a></div>
<?php if (isset($_SESSION['admin_name']) && !empty($_SESSION['admin_name'])) { ?>
            <div class="hdrMnun">
              <ul class="mainmenu">
                    <li><a href="<?php echo $purl; ?>"  <?php if ($filename == 'dashboard.php') { ?> class="active" <?php } ?>>HOME</a></li>
                  <li><a href="administrative_data.php" <?php if ($filename == 'administrative_data.php') { ?> class="active" <?php } ?>>ADMINISTRATIVE DATA</a></li>
                    <li><a href="javascript:void(0)">PROCESS DATA</a></li>
                    <li><a href="performance_data_and_reporting.php" <?php if ($filename == 'performance_data_and_reporting.php') { ?> class="active" <?php } ?>>PERFORMANCE DATA</a>
              <ul class="submenu">
                  <li><a href="standardized_reports.php">Standardized Reports</a></li>
                <li><a href="performance_data.php">On demand reports</a></li>
                <li class="noBor"><a href="#">Export data</a></li>
                </ul>
            </li>
            </ul>
                </div>
                <div class="usrNmSec"><?php echo $_SESSION['admin_name']; ?> | <a href="logout.php">Logout</a></div>
            <div class="log"></div>
<?php } ?>
        <div class="clearFix"></div>
      </div>
    </div>-->
<!--==================================================================-->

<?php
require_once ('../includes/config.php');
//require_once ('../includes/auth.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
//require_once ("../includes/meta-link-script.php");
?>


<head>
  <title>Evidence Action</title>
  <link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../css/vstyle.css">
</head>

<div class="header">
  <div style="float: left">  <img src="images/logo.png" />  </div>
  <div class="menuLinks">

    <nav>
      <ul>
        <li><a href="home.php">HOME</a></li>
        <li><a href="schools.php">ADMIN DATA</a></li>
        <!--    <li>
              <a href="counties.php">ADMINISTRATIVE DATA</a>
              <ul>
                <li><a href=""><img src="images/menu-line.png"></a></li>
                <li><a href="schoolsView.php">ID data</a></li>
                <li><a href="educationView.php">Educational &amp; Health Data</a></li>
                <li><a href="masterTrainerView.php">Master Trainer Data</a></li>
                <li><a href="form_s.php">Treatment Forms</a></li>
              </ul>
            </li>-->
        <li><a href="form_s.php">PROCESS DATA</a></li>
        <li> <a href="performanceData.php">PERFORMANCE DATA</a>  </li>
        <!--      <ul>
                <li><a href=""><img src="images/menu-line.png"></a></li>
                <li><a href="reports/standardized_reports.php">Standardized Reports</a></li>
                <li><a href="reports/performance_data.php">On Demand Reports</a></li>
                <li><a href="#">Export Data</a></li>
              </ul>-->

      </ul>
      <div style="float: right; width: 25%">
        <div align="center" style="margin: 0px auto; /*border: 1px solid grey;*/ padding: 10px; margin-top: -10px">
          <!--<a href="logout.php"><h4>Log-in Info (log-out)</h4></a>-->
          <?php
          $query = mysql_query("SELECT * FROM staff WHERE email='$email' LIMIT 1");
          if ($query) {
            while ($row = mysql_fetch_array($query)) {
              echo '
					<TABLE style="font-family: TStar-Reg; color: #EF637D">
					<thead>
						<!--<th ROWSPAN=2><img height="60px" width="60px" src="images/staff/' . $row['image'] . '"></th>--> 
              <th></th>
						<th align="left" style="padding-left:10px">
              ' . $row['name'] . '<br/>
              ' . $row['role'] . '<br/>
              <a href="logout.php" align="left" style="font-size: 14px">Log Out</a>
            </th>
					</thead>
					</TABLE>';
            }
          }
          ?>
        </div>
      </div>

    </nav>
  </div>
</div>