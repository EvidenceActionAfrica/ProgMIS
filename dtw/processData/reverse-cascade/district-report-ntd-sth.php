<?php
// require_once ('includes/config.php');
// require_once ('includes/auth.php');
// require_once ("includes/functions.php");
// require_once ("includes/form_functions.php");

require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); // use root
$placeholder="N/A";
// include "kpiFunctionsCiff.php";
include "includes/class.ntd.php";
$ntd=new ntd;


$ntd->numDistinctFlexible('school_id','a_bysch','district_id','2012029')



// $level = $_SESSION['level'];
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
      <div class="contentBody">
        <!--================================================-->
        	<div id="dashboard">

			<div id="indicator">

				<div class="dashboard_menu">
					<?php include "includes/kpiDropdown.php" ?>
					<div class="dashboard_export">

						<a href="exportExcelCiffKpi.php" class="btn-custom-small">Export To Excel</a>

            			<a href="exportPdfCiffKpi.php" class="btn-custom-small" target="_blank">Export To PDF</a>

					</div>
					<div class="vclear"></div>
					<div class="dashboard_title">

						<h2>CIFF KPI</h2>	

					</div>

					<!-- start table -->

						<table id="data-table" class="display">
							<thead>
								<th>County</th>
								<th>District Name</th>
								<th>Rounds</th>
								<th>Year</th>
								<th>Month</th>
								<th>Total No. of Schools Treated</th>
								<th>Total No. U5 Treated</th>
								<th>Total No. SAC Treated</th>
								<th>Total No. of 15+ Treated</th>
								<th>Total No. U5 Male Treated</th>
								<th>Total No. U5 Female Treated</th>
								<th>Total No. SAC Male Treated</th>
								<th>Total No. SAC Female Treated</th>
								<th>Total No. of 15+ Male Treated</th>
								<th>Total No. of 15+ Female Treated</th>
								<th>Total Adults Treated</th>
								<th>Target U5</th>
								<th>Target SAC</th>
								<th>Target Adult</th>
							</thead>
							<tbody>
								<tr>
									<td>Bungoma</td>
									<td>Cheptais</td>
									<td>2</td>
									<td>2013</td>
									<td>June</td>
									<td>139</td>
									<td>14479</td>
									<td>34995</td>
									<td>537</td>
									<td>7501</td>
									<td>6978</td>
									<td>18021</td>
									<td>16974</td>
									<td>209</td>
									<td>328</td>
									<td>7659</td>
									<td>10059</td>
									<td>45699</td>
									<td>0</td>
								</tr><tr>
									<td>Bungoma</td>
									<td>Cheptais</td>
									<td>2</td>
									<td>2013</td>
									<td>June</td>
									<td>139</td>
									<td>14479</td>
									<td>34995</td>
									<td>537</td>
									<td>7501</td>
									<td>6978</td>
									<td>18021</td>
									<td>16974</td>
									<td>209</td>
									<td>328</td>
									<td>7659</td>
									<td>10059</td>
									<td>45699</td>
									<td>0</td>
								</tr><tr>
									<td>Bungoma</td>
									<td>Cheptais</td>
									<td>2</td>
									<td>2013</td>
									<td>June</td>
									<td>139</td>
									<td>14479</td>
									<td>34995</td>
									<td>537</td>
									<td>7501</td>
									<td>6978</td>
									<td>18021</td>
									<td>16974</td>
									<td>209</td>
									<td>328</td>
									<td>7659</td>
									<td>10059</td>
									<td>45699</td>
									<td>0</td>
								</tr><tr>
									<td>Bungoma</td>
									<td>Cheptais</td>
									<td>2</td>
									<td>2013</td>
									<td>June</td>
									<td>139</td>
									<td>14479</td>
									<td>34995</td>
									<td>537</td>
									<td>7501</td>
									<td>6978</td>
									<td>18021</td>
									<td>16974</td>
									<td>209</td>
									<td>328</td>
									<td>7659</td>
									<td>10059</td>
									<td>45699</td>
									<td>0</td>
								</tr><tr>
									<td>Bungoma</td>
									<td>Cheptais</td>
									<td>2</td>
									<td>2013</td>
									<td>June</td>
									<td>139</td>
									<td>14479</td>
									<td>34995</td>
									<td>537</td>
									<td>7501</td>
									<td>6978</td>
									<td>18021</td>
									<td>16974</td>
									<td>209</td>
									<td>328</td>
									<td>7659</td>
									<td>10059</td>
									<td>45699</td>
									<td>0</td>
								</tr><tr>
									<td>Bungoma</td>
									<td>Cheptais</td>
									<td>2</td>
									<td>2013</td>
									<td>June</td>
									<td>139</td>
									<td>14479</td>
									<td>34995</td>
									<td>537</td>
									<td>7501</td>
									<td>6978</td>
									<td>18021</td>
									<td>16974</td>
									<td>209</td>
									<td>328</td>
									<td>7659</td>
									<td>10059</td>
									<td>45699</td>
									<td>0</td>
								</tr>
							</tbody>

						</table>


					<!-- end table -->

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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">

<script type="text/javascript">
  $(document).ready(function() {
      $('#data-table').dataTable();
  } );
</script>




