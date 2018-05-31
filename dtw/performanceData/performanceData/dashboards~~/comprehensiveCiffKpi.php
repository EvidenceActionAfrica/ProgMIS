<?php
// require_once ('includes/config.php');
// require_once ('includes/auth.php');
// require_once ("includes/functions.php");
// require_once ("includes/form_functions.php");

require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); // use root
$placeholder="N/A";
// include "kpiFunctionsCiff.php";
include "queryFunctions.php";
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

					

				</div>

				<table id="hor-minimalist-b">

					<th scope="col">Indicator</th>

					<th scope="col">Total</th>
					<tr class="kpi-not-done">
						<td>
							No. of schools  reporting to deworming on designated county deworming day
						</td>
						<td><?php echo $row1=$placeholder ?></td>
					</tr>
					<tr>
						<td>
							Estimated No. of 'Enrolled Primary School' children for STH
						</td>
						<td class="td-left"><?php echo  $row2=number_format(sumPlain('p_pri_enroll','p_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							No. of  children dewormed for STH once
						</td>
						<td class="td-left"><?php echo $row3=number_format(sumSTH()); ?></td>
					</tr>
					<tr>
						<td>
							No. of U5 children dewormed for STH
						</td>
						<td class="td-left"><?php echo $row4=number_format(sumUnder5()); ?></td>
					</tr>
					<tr>
						<td>

							No. of Enrolled Primary School Aged children dewormed for STH
						</td>
						<td class="td-left"><?php echo $row5=number_format(sumArgs('a_bysch','a_trt_m','a_trt_f')); ?></td>
					</tr>
					<tr>
						<td>
							No. of Non-enrolled (age 6-18) children dewormed for STH
						</td>
						<td class="td-left"><?php echo $row6=number_format(sumNonEnrolled6andover('STH'));?></td>
					</tr>
					<tr>
						<td>
							Estimated No. of 'Enrolled Primary School' children for SCHISTO
						</td>
						<td class="td-left"><?php echo $row7=number_format(sumEstimated('p_pri_enroll','Y')) ?></td>
					</tr>
					<tr>
						<td>
							No. of children dewormed for Schisto once
						</td>
						<td class="td-left"><?php echo $row8=number_format(sumSHISTO()) ?></td>
					</tr>
					<tr class="kpi-not-done">
						<td>
							No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto
						</td>

						<td><?php echo $row9=number_format(sumArgs('a_bysch','ap_trt_m','ap_trt_f','ap_ecd_f','ap_ecd_m')) ?></td>
					</tr>
					<tr>
						<td>
							No. of Non Enrolled (age 6-18) children dewormed for Schisto
						</td>
						<td class="td-left"><?php echo $row10=number_format(sumNonEnrolled6andover('SHISTO')); ?></td>
					</tr>
					<tr class="kpi-not-done">
						<td>
							No. target schools attending teacher training sessions
						</td>
						<td><?php echo $row11=$placeholder ?></td>
					</tr>
					<tr>
						<td>
							No. of schools attending teacher training
						</td>
						<td class="td-left">
							<?php echo $row12=number_format(num('school_id','attnt_bysch')) ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of schools with critical materials present
						</td>
						<td class="td-left"><?php echo $row13=number_format(attntWithCriticalMaterials()) ?></td>
					</tr>
					<tr>
						<td>
							No. of TTs with requiered drugs
						</td>
						<td class="td-left"><?php echo $row14=number_format(numFlexible('attnt_id','attnt_bysch','attnt_total_drugs','1')) ?></td>
					</tr>
					<tr class="kpi-not-done">
						<td>
							% Districts submitting forms S,A,and D to National level within three months of deworming day
						</td>
						<td><?php echo $row15=$placeholder ?></td>
					</tr>
					<tr>
						<td>
							% divisions correctly (+/- 10%) reporting on school level coverage of total children dewormed.
						</td>
						<td><?php echo $row16=$placeholder ?></td>
					</tr>
					<tr class="kpi-not-done">
						<td>
							% districts correctly (+/- 10%) reporting on school-level coverage of total children dewormed.
						</td>
						<td ><?php echo $row17=$placeholder ?></td>
					</tr>

						

				</table>

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



