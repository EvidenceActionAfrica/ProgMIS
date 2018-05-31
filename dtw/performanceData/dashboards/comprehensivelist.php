<?php
require_once ('includes/config.php');
require_once ('includes/auth.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
$data="N/A";
include "kpiFunctionsCiff.php";
$level = $_SESSION['level'];

include "includes/kpiRedirect.php";

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
        require_once ("includes/menuLeftBar-PerformanceData.php");
        ?>
      </div>
      <div class="contentBody">
        <!--================================================-->
        	<div id="dashboard">

			<div id="indicator">

				<div class="dashboard_menu">

					<div class="dashboard_title">

						<h2>CIFF KPI</h2>	

					</div>

					<div class="dashboard_export">

						<!-- <a href="">Export To Excel</a>

						<a href="" target="_blank">Export To PDF</a> -->

					</div>
					<?php include "includes/kpiDropdown.php" ?>

				</div>

			

				</div>

			</div>

		</div>





        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->
  </body>
</html>



