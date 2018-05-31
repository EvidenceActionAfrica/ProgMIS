<?php

// require_once ('../../includes/config.php');
require_once ('../../includes/config.php');
// require_once ("../includes/functions.php");
// require_once ("../includes/form_functions.php");
include "func.CountyReport.php";


// get the county name
$county = $_POST['county'];

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
$estNumberOfTeachers = 0;
$estNumberOfTeachersSchisto = 0;


//calulate moe_trained
// [3*(# districts)]+[4*(# divisions)]
// moe_trained is the same as mophs_trained
$district_num = CountDistinctFlexible('district_id', 'a_bysch', 'county_name', $county);
$division_num = CountDistinctFlexible('division_id', 'a_bysch', 'county_name', $county);
$moe_trained = (3 * $district_num) + (4 * $division_num);
$mophs_trained = $moe_trained;
$estNumberOfTeachers = getAttntTeachersSTH($county);
$pzq_est_number_teachers_trained = getAttntTeachers($county,'attnt_schisto');


//calculate mophs_trained
// [3*(# districts)]+[4*(# divisions)]
// create the queries and store them in the variables
// Children dewormed for STH
$male_children_dewormed = sumArgsByCounty('a_bysch', $county, 'a_ecd_m', 'a_2_m', 'a_6_m', 'a_11_m', 'a_15_m', 'a_trt_m');
$female_children_dewormed = sumArgsByCounty('a_bysch', $county, 'a_ecd_f', 'a_2_f', 'a_6_f', 'a_11_f', 'a_15_f', 'a_trt_f');
$enrolled_children_dewormed = sumArgsByCounty('a_bysch', $county, 'a_ecd_total', 'a_trt_total');
$non_enrolled_children_dewormed = sumArgsByCounty('a_bysch', $county, 'a_2_18_total');
$under_5 = sumArgsByCounty('a_bysch', $county, 'a_ecd_f', 'a_ecd_m', 'a_2_f', 'a_2_m');
$over_5 = sumArgsByCounty('a_bysch', $county, 'a_6_f', 'a_11_f', 'a_15_f', 'a_6_m', 'a_11_m', 'a_15_m', 'a_trt_total');
$children_dewormed = sumArgsByCounty('a_bysch', $county, 'a_u5_total', 'a_trt_total', 'a_6_18_total');

// get children targeted STH
$children_targeted_plain   = sumArgsByCounty           ('p_bysch', $county, 'p_ecd_enroll', 'p_ecd_sa_enroll', 'p_pri_enroll');
$enrolled_children_planned = sumArgsByCountyOpenSchools('p_bysch', $county, 'p_ecd_enroll', 'p_ecd_sa_enroll', 'p_pri_enroll');


// we have to divide by 0.83 to rectify that fact that 
// form p_bysc does not have non-enrolled children
$children_targeted = round($enrolled_children_planned / 0.83);

$children_dewormed = $enrolled_children_dewormed + $non_enrolled_children_dewormed;

// number of schools dewormed STH a_bysch STH
$school_participated = CountFlexible('school_id', 'a_bysch', 'county_name', $county);

// get schools planned sth p_bysch STH
// $school_targeted = CountFlexible('p_sch_id','p_bysch','county_name',$county);
$school_targeted = getPlannedSchools($county);



// Children dewormed for PZQ
$pzq_male_children_dewormed = sumArgsByCounty('a_bysch', $county, 'ap_ecd_m', 'ap_6_m', 'ap_11_m', 'ap_15_m', 'ap_trt_m');
$pzq_female_children_dewormed = sumArgsByCounty('a_bysch', $county, 'ap_ecd_f', 'ap_6_f', 'ap_11_f', 'ap_15_f', 'ap_trt_f');
$pzq_enrolled_children_dewormed = sumArgsByCounty('a_bysch', $county, 'ap_ecd_total', 'ap_trt_total');
$pzq_non_enrolled_children_dewormed = sumArgsByCounty('a_bysch', $county, 'ap_6_18_total');
// $pzq_over_5 = sumArgsByCounty('a_bysch',$county,'ap_6_f','ap_11_f','ap_15_f','ap_6_m','ap_11_m','ap_15_m','ap_trt_total');
$pzq_over_5 = sumArgsByCounty('a_bysch', $county, 'ap_6_f', 'ap_11_f', 'ap_15_f', 'ap_6_m', 'ap_11_m', 'ap_15_m', 'ap_trt_total', 'ap_ecd_total');
$pzq_children_dewormed = sumArgsByCounty('a_bysch', $county, 'ap_ecd_total', 'ap_trt_total', 'ap_6_18_total');
// no under 5 for shisto
$pzq_under_5 = "N/A";

// get children targeted for PZQ
$pzq_children_targeted = sumMoreFexibleByCounty('p_pri_enroll', 'p_bysch', 'county_name', $county, 'p_sch_bilharzia', 'Y');

// we have to divide PZQ planned by 0.961 to rectify that fact that 
// form p_bysc does not have non-enrolled children
$pzq_children_targeted = round($pzq_children_targeted / 0.961);

$pzq_children_dewormed = $pzq_enrolled_children_dewormed + $pzq_non_enrolled_children_dewormed;

// number of schools dewormed PZQ a_bysch
$pzq_school_participated = CountMoreFlexible('school_id', 'a_bysch', 'county_name', $county, 'ap_attached', 'Yes');

// get schools planned PZQ p_bysch
$pzq_school_targeted = CountMoreFlexible('p_sch_id', 'p_bysch', 'county_name', $county, 'p_sch_bilharzia', 'Y');

// count pzq moe trained
// [3*(# districts)]+[4*(# divisions)]
// pzq_moe_trained is the same as pzq_mophs_trained
$pzq_district_num = CountDistinctMoreFlexible('district_id', 'a_bysch', 'county_name', $county, 'ap_attached', 'Yes');
$pzq_division_num = CountDistinctMoreFlexible('division_id', 'a_bysch', 'county_name', $county, 'ap_attached', 'Yes');
$pzq_moe_trained = (3 * $pzq_district_num) + (4 * $pzq_division_num);
$pzq_mophs_trained = $pzq_moe_trained;

/**
 * start the work
 */
// for the two tables 
if (isset($_POST['tag_get_data'])) {

  // get the treatment
  $treatment_type = $_POST['treatment'];

  if ($treatment_type == 'albe') {

    # Children dewormed for STH
    # number of schools dewormed STH a_bysch
    # get schools planned sth p_bysch
    # get children targeted
    # $children_targeted
    # $children_dewormed

    echo '<table border="1" cellpadding="1" cellspacing="1" width="45%" align="center" class="county_report_table">
			 <tr><td width="80%">Schools Planned</td><td  class="left-align" width="20%">' . number_format($school_targeted) . '</td></tr>
			 <tr><td>Schools participated</td><td class="left-align" >' . number_format($school_participated) . '</td></tr>
			 <tr><td>All children planned</td><td class="left-align" >' . number_format($children_targeted) . '</td></tr>
			 <tr><td>All children dewormed</td><td class="left-align" >' . number_format($children_dewormed) . '</td></tr>
			 <tr><td>Enrolled children planned</td><td class="left-align" >' . number_format($enrolled_children_planned) . '</td></tr>
			 <tr><td>Enrolled children dewormed</td><td class="left-align" >' . number_format($enrolled_children_dewormed) . '</td></tr>
			 <tr><td>Non-enrolled children dewormed</td><td class="left-align" >' . number_format($non_enrolled_children_dewormed) . '</td></tr>
	 	</table>
		<table border="1" cellpadding="1" cellspacing="1" width="55%" align="center" class="county_report_table">
			<tr><td width="80%">Children 5 and under dewormed</td><td  class="left-align" width="20%">' . number_format($under_5) . '</td></tr>
			<tr><td>Children over 5 dewormed</td><td class="left-align">' . number_format($over_5) . '</td></tr>
			<tr><td>Male children dewormed</td><td class="left-align">' . number_format($male_children_dewormed) . '</td></tr>
			<tr><td>Female children dewormed</td><td class="left-align">' . number_format($female_children_dewormed) . '</td></tr>
			<tr><td>Est. Sub-county/ward MoEST personnel trained</td><td class="left-align">' . number_format($moe_trained) . '</td></tr>
			<tr><td>Est. Sub-county/ward MoH personnel trained</td><td class="left-align">' . number_format($mophs_trained) . '</td></tr>
			<tr><td>Est. Number of teachers trained </td><td class="left-align">' . number_format($estNumberOfTeachers) . '</td></tr>
		</table>';

    return;
  } else {

    # Children dewormed for PZQ
    # no under 5 for shisto
    # number of schools dewormed PZQ a_bysch
    # get schools planned SHISTO p_bysch
    # get children targeted for PZQ
    # get children targeted
    # get children dewormed

    echo '<table border="1" cellpadding="1" cellspacing="1" width="45%" align="center" class="county_report_table">
				 <tr><td width="80%">Schools planned</td><td width="20%" class="left-align" >' . number_format($pzq_school_targeted) . '</td></tr>
				 <tr><td>Schools participated</td><td class="left-align" >' . number_format($pzq_school_participated) . '</td></tr>
				 <tr><td>All children planned</td><td class="left-align" >' . number_format($pzq_children_targeted) . '</td></tr>
				 <tr><td>All children dewormed</td><td class="left-align" >' . number_format($pzq_children_dewormed) . '</td></tr>
				 <tr><td>Enrolled children planned</td><td class="left-align" >' . number_format($pzq_enrolled_children_dewormed) . '</td></tr>
				 <tr><td>Non-enrolled children dewormed</td><td class="left-align" >' . number_format($pzq_non_enrolled_children_dewormed) . '</td></tr>
		 	</table>
			<table border="1" cellpadding="1" cellspacing="1" width="55%" align="center" class="county_report_table">
				<tr><td width="80%">Children 5 and under dewormed</td><td width="20%" class="left-align" >' . $pzq_under_5 . '</td></tr>
				<tr><td>Children over 5 dewormed</td><td class="left-align" >' . number_format($pzq_over_5) . '</td></tr>
				<tr><td>Female children dewormed</td><td class="left-align" >' . number_format($pzq_female_children_dewormed) . '</td></tr>
				<tr><td>Male children dewormed</td><td class="left-align" >' . number_format($pzq_male_children_dewormed) . '</td></tr>
				<tr><td>Est. sub-county/ward MoEST personnel trained</td><td class="left-align" >' . number_format($pzq_moe_trained) . '</td></tr>
				<tr><td>Est. sub-county/ward MoH Personnel trained</td><td class="left-align" >' . number_format($pzq_est_number_teachers_trained) . '</td></tr>
			</table>';

    return;
  }
} // end tag data
//  county bar data
if (isset($_POST['progress_data'])) {

  $data = $_POST['progress_data'];

  $treatment_type = $_POST['treatment'];

  if ($data == "dewormed") {

    if ($treatment_type == 'albe') {

      # Children dewormed for STH
      # $male_children_dewormed
      # $female_children_dewormed
      # $enrolled_children_dewormed
      # $non_enrolled_children_dewormed
      # $under_5
      # $over_5
      # children dewormed 
      # get children targeted

      $primary_percentage = $enrolled_children_dewormed / $children_targeted * 100;
      echo $children_dewormed . "," . $children_targeted . "," . $primary_percentage;
    } else {

      # pzq_children_dewormed
      #pzq_children_targeted
      // if there was no planned biharzia. dont divide
      if ($pzq_children_targeted == 0) {
        $primary_percentage = $pq_enrolled_children_dewormed * 100;
      } else {
        $pzq_primary_percentage = $pzq_enrolled_children_dewormed / $pzq_children_targeted * 100;
      }
      echo $pzq_children_dewormed . "," . $pzq_children_targeted . "," . $pzq_primary_percentage;
    }


    return;
  } else if ($data == "treated") {

    if ($treatment_type == "albe") {

      # get schools planned sth p_bysch
      # schools participated

      echo $school_participated . "," . $school_targeted;
    } else {
      # get schools planned SHISTO p_bysch
      # get schools dewormed  SHISTO a_bysch

      echo $pzq_school_participated . "," . $pzq_school_targeted;
    }

    return;
  } else {
    echo 0;
  }
  return;
}

// pie charts 
# start pie charts
if (isset($_POST['request_data'])) {
  if (isset($_POST['data_type'])) {

    $data_type = $_POST['data_type'];
    $county = $_POST['county'];
    $treatment_type = $_POST['treatment'];

    $table = $treatment_type == "albe" ? "form_a" : "form_ap";

    if ($data_type == "enrolled") {

      if ($treatment_type == "albe") {

        $total = $children_dewormed;

        if ($total != 0) {
          $non_enrolled_children_dewormed = round($non_enrolled_children_dewormed / $total * 100.0);
          $enrolled_children_dewormed = round($enrolled_children_dewormed / $total * 100.0);
          // Data format:
          // title, label1, label2, data1, data2
          $result = sprintf("%s,%s,%s,%d,%d,%d", "Enrollment Status", "Enrolled Status", "Not enrolled Status", $enrolled_children_dewormed, $non_enrolled_children_dewormed, $total);
          echo $result;
        } else {
          echo "";
        }
        return;
      } else {

        $total = $pzq_children_dewormed;

        if ($total != 0) {
          $pzq_non_enrolled_children_dewormed = round($pzq_non_enrolled_children_dewormed / $total * 100.0);
          $pzq_enrolled_children_dewormed = round($pzq_enrolled_children_dewormed / $total * 100.0);
          // Data format:
          // title, label1, label2, data1, data2
          $result = sprintf("%s,%s,%s,%d,%d,%d", "Enrollment Status", "Enrolled", "Not enrolled", $pzq_enrolled_children_dewormed, $pzq_non_enrolled_children_dewormed, $total);
          echo $result;
        } else {
          // echo "";
          $total = 0;
          $result = sprintf("%s,%s,%s,%d,%d,%d", "Enrollment Status", "Enrolled", "Not enrolled", $pzq_enrolled_children_dewormed, $pzq_non_enrolled_children_dewormed, $total);
          echo $result;
        }
        return;
      }
    } // end enrolled

    if ($data_type == "age") {

      if ($treatment_type == "albe") {

        $total = $under_5 + $over_5; // get the total
        $under_5 = round($under_5 / $total * 100.0); //get the percentage
        $over_5 = round($over_5 / $total * 100.0); //get the percentage
        $result = sprintf("%s,%s,%s,%d,%d,%d", "Age Bracket", "Children 5 and under", "Children over 5", $under_5, $over_5, $total);
        echo $result;
        return;
      } else {

        $total = $pzq_over_5;
        // cannot divide under_5 because its 0.There are no under 5 for PZQ
        $pzq_over_5 = round($pzq_over_5 / $total * 100.0);
        $result = sprintf("%s,%s,%s,%d,%d,%d", "Age Bracket", "Children 5 and under", "Children over 5", $under_5, $pzq_over_5, $total);
        echo $result;
        return;
      }
    } //end age

    if ($data_type == "sex") {

      if ($treatment_type == "albe") {

        $total = $male_children_dewormed + $female_children_dewormed;
        if ($total != 0) {
          $male_children_dewormed = round($male_children_dewormed / $total * 100.0);
          $female_children_dewormed = round($female_children_dewormed / $total * 100.0);
          $result = sprintf("%s,%s,%s,%d,%d,%d", "Sex", "Male Gender", "Female Gender", $male_children_dewormed, $female_children_dewormed, $total);
          echo $result;
        } else {
          $total = 0;
          $result = sprintf("%s,%s,%s,%d,%d,%d", "Sex", "Male Gender", "Female Gender", $male_children_dewormed, $female_children_dewormed, $total);
          echo $result;
        }
      } else {

        $total = $pzq_male_children_dewormed + $pzq_female_children_dewormed;
        if ($total != 0) {
          $pzq_male_children_dewormed = round($pzq_male_children_dewormed / $total * 100.0);
          $pzq_female_children_dewormed = round($pzq_female_children_dewormed / $total * 100.0);
          $result = sprintf("%s,%s,%s,%d,%d,%d", "Sex", "Male Gender", "Female Gender", $pzq_male_children_dewormed, $pzq_female_children_dewormed, $total);
          echo $result;
        } else {
          $total = 0;
          $result = sprintf("%s,%s,%s,%d,%d,%d", "Sex", "Male Gender", "Female Gender", $pzq_male_children_dewormed, $pzq_female_children_dewormed, $total);
          echo $result;
        }
      }
    } // end sex
  }
}
?>