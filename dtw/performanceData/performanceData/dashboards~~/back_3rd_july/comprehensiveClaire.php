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

						<a class="btn-custom-small" href="exportExcelClaireKpi.php">Export To Excel</a>

						<a class="btn-custom-small" href="exportPdfClaireKpi.php" target="_blank">Export To PDF</a>

					</div>
					<div class="vclear"></div>
					<div class="dashboard_title">

						<h2>CLAIRE REPORT</h2>	

					</div>

					

				</div>

				<table id="hor-minimalist-b">

					<th scope="col">Indicator</th>

					<th scope="col">Total</th>
					


					<tr>
						<td>
							No. of districts covered for STH
						</td>
							<td class="td-left"><?php echo $row1=number_format(numDistinctPlain('district_id','a_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							No. of schools treated for STH
						</td>
							<td class="td-left"><?php echo $row2=number_format(num('school_id','a_bysch')) ?></td>
					</tr>	
					<tr>
						<td>
							No. of schools targeted for STH
						</td>
							<td class="td-left"><?php echo $row3=number_format(num('p_sch_id','p_bysch')) ?></td>
					</tr>	
					<tr>
						<td>
							No. of public schools for STH
						</td>
						<td class="td-left"><?php echo $row4=number_format(numFlexible('s_prog_sch_id','s_bysch','s1_school_type','Public')); ?></td>
					</tr>	
					<tr>
						<td>
							No. of private schools for STH
						</td>
						<td class="td-left"><?php echo $row5=number_format(numFlexible('s_prog_sch_id','s_bysch','s1_school_type','Private')); ?></td>
					</tr>	
					<tr>
						<td>
							No. of 'other' schools for STH
						</td>
						<td class="td-left"><?php echo $row6=number_format(numFlexible('s_prog_sch_id','s_bysch','s1_school_type','Other')); ?></td>

					</tr>	
					<tr>
						<td>
							No. of 'no school type' schools for STH
						</td>
						<td class="td-left"><?php echo $row7=number_format(numFlexible('s_prog_sch_id','s_bysch','s1_school_type','None')); ?></td>
					</tr>	
					<tr>
						<td>
							No. of schools  reporting to deworming on designated county deworming day
						</td>
						<td class="td-left"><?php echo $row8=$data ?></td>

					</tr>
					<tr>
						<td>
							Estimated target population of STH
						</td>
						<td class="td-left"><?php echo $row9=number_format(EstimatedTotalSTH()) ?></td>
					</tr>	
					<tr>
						<td>
							Estimated No. of 'Enrolled Primary School' children for STH
						</td>
						<td class="td-left"><?php echo  $row10=number_format(sumPlain('p_pri_enroll','p_bysch')) ?></td>
					</tr>	
					<tr>
						<td>
							Estimated No. of 'Enrolled ECD' children for STH
						</td>
						<td class="td-left"><?php echo  $row11=number_format(sumPlain('p_ecd_enroll','p_bysch')) ?></td>
					</tr>		
					<tr>
						<td>
							Estimated No. of 'Stand-alone ECD' children for STH
						</td>
						<td class="td-left"><?php echo  $row12=number_format(sumPlain('p_ecd_sa_enroll','p_bysch')) ?></td>

					</tr>	
					<tr>
						<td>
							No. of ALB estimated for STH
						</td>
						<td class="td-left"><?php echo  $row13=number_format(sumPlain('p_alb','p_bysch')) ?></td>

					</tr>	
					<tr>
						<td>
							No. of  children dewormed for STH once
						</td>
						<td class="td-left"><?php echo $row14=number_format(sumSTH()); ?></td>

					</tr>	

					<tr>
						<td>
							No. of children dewormed for STH (male)
						</td>
						<td class="td-left"><?php echo $row15=number_format(sumMaleFormA()) ?></td>
					</tr>	
					<tr>
						<td>
							No. of children dewormed for STH (female)
						</td>
						<td class="td-left"><?php echo $row16=number_format(sumFemaleFormA()) ?></td>

					</tr>	
					<tr>
						<td>
							No. of children 6 and over receiving STH treatment
						</td>
						<td class="td-left"><?php echo $row17=number_format(sum6andOverFormA()); ?></td>

					</tr>	
					<tr>
						<td>
							No. of U5 children dewormed for STH
						</td>
						<td class="td-left"><?php echo $row18=number_format(sumUnder5()); ?></td>

					</tr>	
					<tr>
						<td>
							No. of Enrolled Primary School Aged children dewormed for STH
						</td>
							<td class="td-left"><?php echo $row19=number_format(sumPlain('a_treated_b','a_bysch')); ?></td>
					</tr>
					<tr>
						<td>
							No. of Non-enrolled (age 6-18) children dewormed for STH
						</td>
							<td class="td-left"><?php echo $row20=number_format(sumNonEnrolled6andover('STH'));?></td>
					</tr>
					<tr>
						<td>
							No. of Non-enrolled (age 6-10) children dewormed for STH
						</td>
							<td class="td-left"><?php echo $row21=number_format(sumNonEnrolledGender('a_6','a_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							No. of Non-enrolled (age 11-14) children dewormed for STH
						</td>
							<td class="td-left"><?php echo $row22=number_format(sumNonEnrolledGender('a_11','a_bysch'))  ?></td>
					</tr>
					<tr>
						<td>
							No. of Non-enrolled (age 15-18) children dewormed for STH
						</td>
							<td class="td-left"><?php echo $row23=number_format(sumNonEnrolledGender('a_15','a_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							No. of Non Enrolled (age 2-5) children dewormed for STH
						</td>
							<td class="td-left"><?php echo $row24=number_format(sumNonEnrolledGender('a_2','a_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							No. of ECD children dewormed for STH
						</td>
							<td class="td-left"><?php echo $row25=number_format(sumArgs('a_bysch','a_ecd_m','a_ecd_f')); ?></td>
					</tr>
					<tr>
						<td>
							No. of districts covered for Schisto
						</td>
							<td class="td-left"><?php echo $row26=number_format(numDistinct('district_id','a_bysch','Yes')); ?></td>
					</tr>
					<tr>
						<td>
							No. of schools covered for Schisto
						</td>
							<td class="td-left"><?php echo $row27=number_format(numDistinct('school_id','a_bysch','Yes')); ?></td>

					</tr>	
					<tr>
						<td>
							No. of public schools for SCHISTO
						</td>
							<td class="td-left"><?php echo $row28=number_format(numSchoolTypeS('Public','Yes')) ?></td>

					</tr>	
					<tr>
						<td>
							No. of private schools for SCHISTO
						</td>
							<td class="td-left"><?php echo $row29=number_format(numSchoolTypeS('Private','Yes')) ?></td>

					</tr>	
					<tr>
						<td>
							No. of 'other' schools for SCHISTO
						</td>
							<td class="td-left"><?php echo $row30=number_format(numSchoolTypeS('Other','Yes')) ?></td>
					</tr>
					<tr>
						<td>
							No. of 'no school type' schools for SCHISTO
						</td>
							<td class="td-left"><?php echo $row31=number_format(numSchoolTypeS('Not specified','Yes')) ?></td>
					</tr>
					<tr>
						<td>
							No. of districts planned for SCHISTO
						</td>
							<td class="td-left"><?php echo $row32=number_format(numDistinctP('district_id','Y')) ?></td>
					</tr>
					<tr>
						<td>
							No. of schools planned (baseline) for SCHISTO
						</td>
							<td class="td-left"><?php echo $row33=number_format(numDistinctP('p_sch_id','Y')); ?></td>
					</tr>
					<tr>
						<td>
							Estimated target population of Schisto
						</td>
						<td class="td-left"><?php echo $row34=number_format(EstimatedTotalSHISTO()); ?></td>

					</tr>	
					<tr>
						<td>
							Estimated No. of 'Enrolled Primary School' children for SCHISTO
						</td>
						<td class="td-left"><?php echo $row35=number_format(sumEstimated('p_pri_enroll','Y')) ?></td>

					</tr>	
					<tr>
						<td>
							Estimated No. of 'Enrolled ECD' children for SCHISTO
						</td>
						<td class="td-left"><?php echo $row36=number_format(sumEstimated('p_ecd_enroll','Y')) ?></td>

					</tr>	
					<tr>
						<td>
							Estimated No. of 'Stand-alone ECD' children for SCHISTO
						</td>
						<td class="td-left"><?php echo $row37=number_format(sumEstimated('p_ecd_sa_enroll','Y')) ?></td>

					</tr>	
					<tr>
						<td>
							Estimated No. of PZQ tablets needed
						</td>
						<td class="td-left"><?php echo $row38=number_format(sumPlain('p_pzq','p_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							No. of children dewormed for Schisto once
						</td>
						<td class="td-left"><?php echo $row39=number_format(number_format(sumSHISTO())) ?></td>

					</tr>	
					<tr>
						<td>
							No. of children dewormed for Schisto (Male)
						</td>
						<td class="td-left"><?php echo $row40=number_format(sumMaleFormAP()); ?></td>

					</tr>	
					<tr>
						<td>
							No. of children dewormed for Schisto (Female)
						</td>
						<td class="td-left"><?php echo $row41=number_format(sumFemaleFormAP()); ?></td>

					</tr>	
					<tr>
						<td>
							No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto
						</td>
						<td class="td-left"><?php echo $row42=number_format(sumArgs('a_bysch','ap_trt_m','ap_trt_f','ap_ecd_f','ap_ecd_m')) ;?></td>

					</tr>
					<tr>
						<td>
							No. of Non Enrolled (age 6-18) children dewormed for Schisto
						</td>
							<td class="td-left"><?php echo $row43=number_format(sumNonEnrolled6andover('SHISTO')); ?></td>
					</tr>
					<tr>
						<td>
							No. of Non Enrolled (age 6-10) children dewormed for Schisto
						</td>
							<td class="td-left"><?php echo $row44=number_format(sumNonEnrolledGender('ap_6','a_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							No. of Non Enrolled (age 11-14) children dewormed for Schisto
						</td>
							<td class="td-left"><?php echo $row45=number_format(sumNonEnrolledGender('ap_11','a_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							No. of Non Enrolled (age 15-18) children dewormed for Schisto
						</td>
							<td class="td-left"><?php echo $row46=number_format(sumNonEnrolledGender('ap_15','a_bysch')) ?></td>
					</tr>
					<tr>
						<td>
							No. of Adult Treated for STH
						</td>
						<td class="td-left">
							<?php echo $row47=number_format(sumArgs('s_bysch','s_adult_treated1','s_adult_treated2','s_adult_treated3','s_adult_treated4','s_adult_treated5','s_adult_treated6','s_adult_treated7','s_adult_treated8','s_adult_treated9')); ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of Adult Treated for Schisto
						</td>
						<td class="td-left">
							<?php echo $row48=number_format(sumArgs('s_bysch','sp_adult_treated1','sp_adult_treated2','sp_adult_treated3','sp_adult_treated4','sp_adult_treated5','sp_adult_treated6','sp_adult_treated7','sp_adult_treated8','sp_adult_treated9')); ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of districts attending teacher training
						</td>
						<td class="td-left">
							<?php echo $row49=number_format(numDistinctPlain('attnt_district_id','attnt_bysch')) ?>
						</td>
					</tr>
					<tr>
						<td>
							No. target schools attending teacher training sessions
						</td>
						<td>
							<?php echo $row50=$data ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of schools attending teacher training
						</td>
						<td class="td-left">
							<?php echo $row51=number_format(num('school_id','attnt_bysch')) ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of schools with critical materials present
						</td>
						<td class="td-left">
							<?php echo $row52=number_format(attntWithCriticalMaterials()) ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of schools with no critical materials present
						</td>
						<td class="td-left">
							<?php echo $row53=number_format(attntNoCriticalMaterials()) ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of schools with poles
						</td>
						<td class="td-left">
							<?php echo $row54=number_format(numFlexible('school_id','attnt_bysch','attnt_total_poles','1')) ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of TTs with requiered drugs
						</td>
						<td class="td-left">
							<?php echo $row55=number_format(attntWithCriticalMaterials('attnt_id')) ?>
						</td>
					</tr>
					<tr>
						<td>
							No. TTs where funds are available
						</td>
						<td>
							<?php echo $row56=$data ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of Gok district personnel at regional training
						</td>
						<td>
							<?php echo $row57=$data ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of Gok divisional personnel at regional training
						</td>
						<td>
							<?php echo $row58=$data ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of district returning form ATTNR
						</td>
						<td>
							<?php echo $row59=$data ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of district returning form ATTNT
						</td>
						<td>
							<?php echo $row60=$data ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of district returning form S
						</td>
						<td class="td-left">
							<?php echo $row60=number_format(NotEmpty('s_received_form_s','s_bysch')) ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of district returning form A
						</td>
						<td class="td-left">
							<?php echo $row61=number_format(numTerm('Yes','a_bysch','a_form_s_returned')) ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of district returning form D
						</td>
						<td>
							<?php echo $row62=$data ?>
						</td>
					</tr>
					<tr>
						<td>
							No. of district returning form Tabs
						</td>
						<td>
							<?php echo $row63=$data ?>
						</td>
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



