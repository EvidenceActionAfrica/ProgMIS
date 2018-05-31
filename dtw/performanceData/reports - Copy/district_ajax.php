<?php
require_once ('../../includes/auth.php');
require_once ('../../includes/config.php');
// require_once ("../includes/functions.php");
// require_once ("../includes/form_functions.php");
include "func.DistrictReport.php";

// get the district id
$district_id = $_POST['district_id'];

// instanstiate the variables
$under_5 = 0;
$over_5 = 0;
$male_children_dewormed = 0;
$female_children_dewormed = 0;
$moe_trained = 0;
$mophs_trained = 0;
$school_targeted = 0;
$school_participated = 0;
$children_targeted = 0;
$children_dewormed = 0;
$enrolled_children_dewormed = 0;
$non_enrolled_children_dewormed = 0;


// calulate moe_trained
// [3]+[4*(# divisions)]
$num_divisions=CountDistinctFlexible('division_id','a_bysch','district_id',$district_id);
$moe_trained = 3+($num_divisions*4);
$mophs_trained = 3+($num_divisions*4);


// create the queries and store them in the variables
// Children dewormed for STH
$male_children_dewormed = sumArgsByDistrict('a_bysch',$district_id,'a_ecd_m','a_2_m','a_6_m','a_11_m','a_15_m','a_trt_m');
$female_children_dewormed = sumArgsByDistrict('a_bysch',$district_id, 'a_ecd_f','a_2_f','a_6_f','a_11_f','a_15_f','a_trt_f');
$enrolled_children_dewormed = sumArgsByDistrict('a_bysch',$district_id,'a_ecd_total','a_trt_total');
$non_enrolled_children_dewormed = sumArgsByDistrict('a_bysch',$district_id,'a_2_18_total');
$under_5 = sumArgsByDistrict('a_bysch',$district_id,'a_ecd_f','a_ecd_m','a_2_f','a_2_m');
$over_5 = sumArgsByDistrict('a_bysch',$district_id,'a_6_f','a_11_f','a_15_f','a_6_m','a_11_m','a_15_m','a_trt_total');
$children_dewormed = sumArgsByDistrict('a_bysch',$district_id,'a_u5_total','a_trt_total','a_6_18_total');

// get children targeted STH
//$children_targeted_plain = sumArgsByDistrict           ('p_bysch',$district_id,'p_ecd_enroll','p_ecd_sa_enroll','p_pri_enroll');
$children_targeted_plain = sumArgsByDistrictOpenSchools('p_bysch',$district_id,'p_ecd_enroll','p_ecd_sa_enroll','p_pri_enroll');

// we have to divide by 0.83 to rectify that fact that 
// form p_bysc does not have non-enrolled children
$children_targeted=round($children_targeted_plain * 1.12);

$children_dewormed = $enrolled_children_dewormed + $non_enrolled_children_dewormed;

// number of schools dewormed STH a_bysch STH
$school_participated = CountFlexible('school_id','a_bysch','district_id',$district_id);

// get schools planned sth p_bysch STH
// $school_targeted = CountFlexible('p_sch_id','p_bysch','district_id',$district_id);
$school_targeted = getPlannedSchools($district_id);

//get the teachers trained
$est_number_teachers_trained= getAttntTeachers_sth($district_id);
$pzq_est_number_teachers_trained = getAttntTeachers('attnt_schisto',$district_id);

// Children dewormed for PZQ
$pzq_male_children_dewormed = sumArgsByDistrict('a_bysch',$district_id,'ap_ecd_m','ap_6_m','ap_11_m','ap_15_m','ap_trt_m');
$pzq_female_children_dewormed = sumArgsByDistrict('a_bysch',$district_id,'ap_ecd_f','ap_6_f','ap_11_f','ap_15_f','ap_trt_f');
$pzq_enrolled_children_dewormed = sumArgsByDistrict('a_bysch',$district_id,'ap_ecd_total','ap_trt_total');
$pzq_non_enrolled_children_dewormed = sumArgsByDistrict('a_bysch',$district_id,'ap_6_18_total');
// $pzq_over_5 = sumArgsByDistrict('a_bysch',$district_id,'ap_6_f','ap_11_f','ap_15_f','ap_6_m','ap_11_m','ap_15_m','ap_trt_total');
$pzq_over_5 = sumArgsByDistrict('a_bysch',$district_id,'ap_6_f','ap_11_f','ap_15_f','ap_6_m','ap_11_m','ap_15_m','ap_trt_total','ap_ecd_total');
$pzq_children_dewormed = sumArgsByDistrict('a_bysch',$district_id,'ap_ecd_total','ap_trt_total','ap_6_18_total');

// pzq moe trained
$pzq_num_divisions=CountDistinctMoreFlexible('division_id','a_bysch','district_id',$district_id,'ap_attached','Yes');
$pzq_moe_trained = 3+($pzq_num_divisions*4);
$pzq_mophs_trained = 3+($pzq_num_divisions*4);

// no under 5 for shisto
$pzq_under_5="N/A";

// get children targeted for PZQ
$pzq_children_targeted=sumMoreFexibleByDistrict2('p_pri_enroll','p_bysch','district_id',$district_id,'p_sch_bilharzia','Y','p_sch_closed', 'No');

// we have to divide PZQ planned by 0.961 to rectify that fact that 
// form p_bysc does not have non-enrolled children
$pzq_children_targeted=round($pzq_children_targeted * 1.04);

$pzq_children_dewormed = $pzq_enrolled_children_dewormed + $pzq_non_enrolled_children_dewormed;

// number of schools dewormed PZQ a_bysch
$pzq_school_participated=CountMoreFlexible('school_id','a_bysch','district_id',$district_id,'ap_attached','Yes');

// get schools planned PZQ p_bysch
$pzq_school_targeted=CountMoreFlexible2('p_sch_id','p_bysch','district_id',$district_id,'p_sch_bilharzia','Y','p_sch_closed', 'No');


// for the two tables at the bottom
if (isset($_POST['tag_get_data'])) {

	$treatment_type = $_POST['treatment'];

	if ($treatment_type =='albe') {

		# $male_children_dewormed
		# $female_children_dewormed
		# $enrolled_children_dewormed
		# $non_enrolled_children_dewormed
		# $under_5
		# $over_5
		# $children_dewormed

		# $children_targeted_plain
		# $children_targeted
		# $school_participated
		# $school_targeted
		# $children_dewormed

			echo '<table border="1" cellpadding="1" cellspacing="1" width="45%" align="center" class="district_report_table">
				 <tr><td width="80%">Schools Planned</td><td width="20%" class="left-align">' . number_format($school_targeted) . '</td></tr>
				 <tr><td>Schools Participated</td><td class="left-align">' . number_format($school_participated) . '</td></tr>
				 <tr><td>All Children Planned</td><td class="left-align">' . number_format($children_targeted) . '</td></tr>
				 <tr><td>All Children Dewormed</td><td class="left-align">' . number_format($children_dewormed) . '</td></tr>
				 <tr><td>Enrolled children Planned</td><td class="left-align">' . number_format($children_targeted_plain) . '</td></tr>
				 <tr><td>Enrolled children Dewormed</td><td class="left-align">' . number_format($enrolled_children_dewormed) . '</td></tr>
				 <tr><td>Non-enrolled children Dewormed</td><td class="left-align">' . number_format($non_enrolled_children_dewormed) . '</td></tr>
		 	</table>
			<table border="1" cellpadding="1" cellspacing="1" width="55%" align="center" class="district_report_table">
				<tr><td width="80%">Children 5 and under dewormed</td><td width="20%" class="left-align">' . number_format($under_5) . '</td></tr>
				<tr><td>Children over 5 dewormed</td><td class="left-align">' . number_format($over_5) . '</td></tr>
				<tr><td>Male children dewormed</td><td class="left-align">' . number_format($male_children_dewormed) . '</td></tr>
				<tr><td>Female children dewormed</td><td class="left-align">' . number_format($female_children_dewormed) . '</td></tr>
				<tr><td>Est. Sub-County/ward MoE personnel trained</td><td class="left-align">' . number_format($moe_trained) . '</td></tr>
				<tr><td>Est. Sub-County/ward MoH personnel trained</td><td class="left-align">' . number_format($mophs_trained) . '</td></tr>
				<tr><td>Est. number of Teachers trained </td><td class="left-align">' . number_format($est_number_teachers_trained) . '</td></tr>
			</table>';
		
		return;
	}else{

		# $pzq_male_children_dewormed
		# $pzq_female_children_dewormed
		# $pzq_enrolled_children_dewormed
		# $pzq_non_enrolled_children_dewormed
		# $pzq_over_5
		# $pzq_children_dewormed
		# $pzq_under_5

		# $pzq_children_targeted
		# $pzq_children_targeted
		# $pzq_children_dewormed
		# $pzq_school_participated
		# $pzq_school_targeted


			echo '<table border="1" cellpadding="1" cellspacing="1" width="50%" align="center" class="district_report_table">
				 <tr><td width="80%">Schools Planned</td><td width="20%" class="left-align">' . number_format($pzq_school_targeted) . '</td></tr>
				 <tr><td>Schools participated</td><td class="left-align">' . number_format($pzq_school_participated) . '</td></tr>
				 <tr><td>All Children Planned</td><td class="left-align">' . number_format($pzq_children_targeted) . '</td></tr>
				 <tr><td>All Children dewormed</td><td class="left-align">' . number_format($pzq_children_dewormed) . '</td></tr>
				 <tr><td>Enrolled children Planned</td><td class="left-align">' . number_format($pzq_children_targeted * 0.961) . '</td></tr>
				 <tr><td>Enrolled children dewormed</td><td class="left-align">' . number_format($pzq_enrolled_children_dewormed) . '</td></tr>
				 <tr><td>Non-enrolled children dewormed</td><td class="left-align">' . number_format($pzq_non_enrolled_children_dewormed) . '</td></tr>
		 	</table>
			<table border="1" cellpadding="1" cellspacing="1" width="50%" align="center" class="district_report_table">
				<tr><td width="80%">Children 5 and under dewormed</td><td width="20%" class="left-align">' . $pzq_under_5 . '</td></tr>
				<tr><td>Children over 5 dewormed</td><td class="left-align">' . number_format($pzq_over_5) . '</td></tr>
				<tr><td>Male children dewormed</td><td class="left-align">' . number_format($pzq_male_children_dewormed) . '</td></tr>
				<tr><td>Female children dewormed</td><td class="left-align">' . number_format($pzq_female_children_dewormed) . '</td></tr>
				<tr><td>Est. Sub-County/Div MoE personnel trained</td><td class="left-align">' . number_format($pzq_moe_trained) . '</td></tr>
				<tr><td>Est. Sub-County/Div MoH personnel trained</td><td class="left-align">' . number_format($pzq_mophs_trained) . '</td></tr>
				<tr><td>Est. number of teachers trained</td><td class="left-align">' . number_format($pzq_est_number_teachers_trained) . '</td></tr>
			</table>';
	}
	

}


//get the countyname from district name
if (isset($_post['get_county_name'])) {
	echo "sdcsd";
	// return $getCountyName($_post['district_id']);
}

if (isset($_POST['progress_data'])) {

	$data = $_POST['progress_data'];

	$treatment_type = $_POST['treatment'];


	if ($data == "dewormed") {

		if ($treatment_type =='albe') {

			# $enrolled_children_dewormed
			# $non_enrolled_children_dewormed
			
			# $children_dewormed
			# $children_targeted_plain
			# $children_targeted

//			$primary_percentage = $enrolled_children_dewormed / $children_targeted * 100;
                        $primary_percentage = $enrolled_children_dewormed / $children_targeted_plain * 100;
			echo $children_dewormed . "," . $children_targeted . "," . $primary_percentage;
		}else{

			# $pzq_enrolled_children_dewormed
			# $pzq_non_enrolled_children_dewormed
			
			# $pzq_children_dewormed
			# $pzq_children_targeted
			# $pzq_children_targeted

			$primary_percentage = $pzq_enrolled_children_dewormed / ($pzq_children_targeted  * 0.961) * 100;
			echo $pzq_children_dewormed . "," . $pzq_children_targeted . "," . $primary_percentage;
		}

		


	} else if ($data == "treated") {


		if ($treatment_type =='albe') {

			# $school_participated
			# $school_targeted

			echo $school_participated . "," . $school_targeted;
		}else{

			# $pzq_school_participated
			# $pzq_school_targeted
			echo $pzq_school_participated . "," . $pzq_school_targeted;
		}

	} else {

		echo 0;

	}

	return;

}

// pie charts

if (isset($_POST['request_data'])) 
{

	if (isset($_POST['data_type'])) 
	{

		$data_type = $_POST['data_type'];

		$treatment_type = $_POST['treatment'];

		if ($data_type == "enrolled") {
			
			
			if ($treatment_type=="albe") {

					$total = $non_enrolled_children_dewormed + $enrolled_children_dewormed;
					
					if ($total != 0) {

						$non_enrolled_children_dewormed = round($non_enrolled_children_dewormed / $total * 100.0);
						$enrolled_children_dewormed = round($enrolled_children_dewormed / $total * 100.0);

						// Data format:
						// title, label1, label2, data1, data2
						$result = sprintf("%s,%s,%s,%d,%d,%d", "Enrollment", "Enrolled Status", "Not enrolled Status", $enrolled_children_dewormed, $non_enrolled_children_dewormed, $total);
						echo $result;
					} else {
						echo "";
					}
					return;
			}else{
					$total = $pzq_enrolled_children_dewormed + $pzq_non_enrolled_children_dewormed;
						
					if ($total != 0) {
						$pzq_non_enrolled_children_dewormed = round($pzq_non_enrolled_children_dewormed / $total * 100.0);
						$pzq_enrolled_children_dewormed = round($pzq_enrolled_children_dewormed / $total * 100.0);
						// Data format:
						// title, label1, label2, data1, data2
						$result = sprintf("%s,%s,%s,%d,%d,%d", "Enrollment", "Enrolled Status", "Not enrolled Status", $pzq_enrolled_children_dewormed, $pzq_non_enrolled_children_dewormed, $total);
						echo $result;
					} else {
						$total=0;
						$result = sprintf("%s,%s,%s,%d,%d,%d", "Enrollment", "Enrolled Status", "Not enrolled Status", $enrolled_total, $non_enrolled_total, $total);
						echo $result;
					}
					return;
				

			}
			
		}



		if ($data_type == "age") {

			if ($treatment_type=="albe") {

				$total = $under_5 + $over_5; // get the total
				$under_5 = round($under_5 / $total * 100.0); //get the percentage
				$over_5 = round($over_5 / $total * 100.0); //get the percentage
				$result = sprintf("%s,%s,%s,%d,%d,%d", "Age Bracket", "Children 5 and under", "Children over 5", $under_5, $over_5, $total);
				echo $result;
				return;
				
			}else{

				$total = $pzq_over_5;
				if ($total != 0) {
					
					// cannot divide under_5 because its 0.There are no under 5 for PZQ
					$pzq_over_5 = round($pzq_over_5 / $total * 100.0);
					$result = sprintf("%s,%s,%s,%d,%d,%d", "Age Bracket", "Children 5 and under", "Children over 5", $under_5, $pzq_over_5, $total);
					echo $result;
					return;
				}else{
					$total=0;
					$result = sprintf("%s,%s,%s,%d,%d,%d", "Age Bracket", "Children 5 and under", "Children over 5", $under_5, $pzq_over_5, $total);
					echo $result;
				}
				
			}

		}



		if ($data_type == "sex") {

			if ($treatment_type=="albe") {
				
					$total = $male_children_dewormed + $female_children_dewormed;
					if ($total != 0) {
						$male_children_dewormed = round($male_children_dewormed / $total * 100.0);
						$female_children_dewormed = round($female_children_dewormed / $total * 100.0);
						$result = sprintf("%s,%s,%s,%d,%d,%d", "Sex", "Male ", "Female ", $male_children_dewormed, $female_children_dewormed, $total);
						echo $result;
					} else {
						$total=0;
						$result = sprintf("%s,%s,%s,%d,%d,%d", "Sex", "Male ", "Female ", $male_children_dewormed, $female_children_dewormed, $total);
						echo $result;
					}
			
			}else{
			
					$total = $pzq_male_children_dewormed + $pzq_female_children_dewormed;
					if ($total != 0) {
						$pzq_male_children_dewormed = round($pzq_male_children_dewormed / $total * 100.0);
						$pzq_female_children_dewormed = round($pzq_female_children_dewormed / $total * 100.0);
						$result = sprintf("%s,%s,%s,%d,%d,%d", "Sex", "Male ", "Female ", $pzq_male_children_dewormed, $pzq_female_children_dewormed, $total);
						echo $result;
					} else {
						$total=0;
						$result = sprintf("%s,%s,%s,%d,%d,%d", "Sex", "Male ", "Female ", $pzq_male_children_dewormed, $pzq_female_children_dewormed, $total);
						echo $result;
					}
				
			}

		} // end sex

	}

}

?>



