<?php
require_once ('includes/config.php');
require_once ('includes/auth.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
$value="N/A";
// include "kpiFunctionsCiff.php";
include "queryFunctions.php";
$level = $_SESSION['level'];
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
					<?php include "includes/kpiDropdown.php" ?>
					<div class="dashboard_export">

						<a class="btn-custom-small" href="exportExcelDistrictKpi.php">Export To Excel</a>

						<a class="btn-custom-small" href="exportPdfDistrictKpi.php" target="_blank">Export To PDF</a>

					</div>
					<div class="vclear"></div>
					<div class="dashboard_title">

						<h2>DISTRICT REPORT</h2>	

					</div>

					

				</div>

				<table id="hor-minimalist-b">

					<th scope="col">Indicator</th>

					<th scope="col">Total</th>
					


					<tr>
						<td>
							No. of districts covered for STH
						</td>
						<td class="td-left"><?php echo number_format(numDistinctPlain('district_id','a_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							No. of schools treated for STH
						</td>
						<td class="td-left"><?php echo number_format(num('school_id','a_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							No. of schools targeted for STH
						</td>
						<td class="td-left"><?php echo number_format(num('p_sch_id','p_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							Estimated target population of STH
						</td>
						<td class="td-left"><?php echo number_format(EstimatedTotalSTH()) ?></td>
					</tr>
					<tr>
						<td>
							No. of  children dewormed for STH once
						</td>
						<td class="td-left"><?php echo number_format(sumSTH()); ?></td>
					</tr>
					<tr>
						<td>
							No. of children dewormed for STH (male)
						</td>
						<td class="td-left"><?php echo number_format(sumMaleFormA()) ?></td>
					</tr>
					<tr>
						<td>
							No. of children dewormed for STH (female)
						</td>
						<td class="td-left"><?php echo number_format(sumFemaleFormA()) ?></td>
					</tr>
					<tr>
						<td>
							No. of children 6 and over receiving STH treatment
						</td>
						<td class="td-left"><?php echo number_format(sum6andOverFormA()); ?></td>
					</tr>
					<tr>
						<td>
							No. of U5 children dewormed for STH
						</td>
						<td class="td-left"><?php echo number_format(sumUnder5()); ?></td>
					</tr>
					<tr>
						<td>
							No. of Enrolled Primary School Aged children dewormed for STH
						</td>
						<td class="td-left"><?php echo number_format(sumArgs('a_bysch','a_trt_m','a_trt_f')); ?></td>
					</tr>
					<tr>
						<td>
							No. of Non-enrolled (age 6-18) children dewormed for STH
						</td>
						<td class="td-left"><?php echo number_format(sumNonEnrolled6andover('STH'));?></td>
					</tr>
					<tr>
						<td>
							No. of Non Enrolled (age 2-5) children dewormed for STH
						</td>
						<td class="td-left"><?php echo number_format(sumNonEnrolledGender('a_2','a_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							No. of ECD children dewormed for STH
						</td>
						<td class="td-left"><?php echo number_format(sumArgs('a_bysch','a_ecd_m','a_ecd_f')); ?></td>
					</tr>
					<tr>
						<td>
							Estimated target population of Schisto
						</td>
						<td class="td-left"><?php echo number_format(EstimatedTotalSHISTO()); ?></td>
					</tr>
					<tr>
						<td>
							No. of children dewormed for Schisto once
						</td>
						<td class="td-left"><?php echo number_format(number_format(sumSHISTO())) ?></td>
					</tr>
					<tr>
						<td>
							No. of children dewormed for Schisto (Male)
						</td>
						<td class="td-left"><?php echo number_format(sumMaleFormAP()); ?></td>
					</tr>
					<tr>
						<td>
							No. of children dewormed for Schisto (Female)
						</td>
						<td class="td-left"><?php echo number_format(sumFemaleFormAP()); ?></td>
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



