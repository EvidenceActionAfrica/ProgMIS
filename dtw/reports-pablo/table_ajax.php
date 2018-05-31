<?php
require_once ("includes/config.php");
// require_once ("includes/auth.php");
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");

$level = $_SESSION['level'];

function get_schools($district_name, $where) {
	$schools = array();
	$query = sprintf("SELECT p.school_name, p.prog_id, schools.district_name 
				  FROM schools, form_p_school_list AS p 
				  WHERE prog_id = school_id AND district_name = '%s' %s", $district_name, $where) or die(mysql_error());

	$result = mysql_query($query);

	if (mysql_num_rows($result) == 0) {
		return $schools;
	} else {
		while (($row = mysql_fetch_array($result)) != 0) {
			$schools[] = $row;
		}
		return $schools;
	}
}

if (isset($_POST['tag_get_data'])) {

	$district = 0;
	if (isset($_POST['district'])) {
		$district = $_POST['district'];
	} else {
		return;
		exit();
	}

	$district_name = $_POST['district_name'];

	$treatment_type = $_POST['treatment'];
	$table = $treatment_type == "albe" ? "form_a" : "form_ap";

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

	$result = mysql_query("SELECT * FROM $table WHERE district = '$district'") or die(mysql_error());

	while (($row = mysql_fetch_array($result)) != 0) {
		$enrolled_children_dewormed += $row['ecd_treated_children_total'] + $row['enrolled_treated_total'];
		$non_enrolled_children_dewormed += $row['non_enrolled_total'];
		$under_5 += $row['years_2_5_male'] + $row['years_2_5_female'];
		$over_5 += $row['years_6_10_male'] + $row['years_6_10_female'] + $row['years_11_14_male'] + $row['years_11_14_female'] + $row['years_15_18_male'] + $row['years_15_18_female'];
		$male_children_dewormed += $row['ecd_treated_male'] + $row['years_2_5_male'] + $row["years_6_10_male"] + $row['years_11_14_male'] + $row['years_15_18_male'];
		$female_children_dewormed += $row['ecd_treated_female'] + $row['years_2_5_female'] + $row["years_6_10_female"] + $row['years_11_14_female'] + $row['years_15_18_female'];
	}

	$result = mysql_query("SELECT COUNT(DISTINCT school_programme_id) AS school_count FROM $table WHERE district = '$district'") or die(mysql_error());

	$row = mysql_fetch_array($result);

	$school_participated = $row["school_count"];

	$where = $treatment_type == "albe" ? " AND is_bilharzia_school = 'N'" : " AND is_bilharzia_school = 'Y'";

	// get a list of all the schools in the current district
	$rows = get_schools($district_name, $where);

	$school_targeted = count($rows);

	$result = mysql_query("SELECT * FROM form_p_school_list") or die(mysql_error());

	while (($row = mysql_fetch_array($result)) != 0) {
		$children_targeted += $row["ecd_pri_school_enrollment"] + $row["ecd_attached_enrollment"] + $row["estimated_enrollmet"];
	}

	$children_dewormed = $enrolled_children_dewormed + $non_enrolled_children_dewormed;

	if ($treatment_type == "albe") {
		echo '<table border="1" cellpadding="1" cellspacing="1" width="50%" align="center">
			 <tr><td width="80%">Schools targeted</td><td width="20%">' . $school_targeted . '</td></tr>
			 <tr><td>Schools participated</td><td>' . $school_participated . '</td></tr>
			 <tr><td>Children targeted</td><td>' . $children_targeted . '</td></tr>
			 <tr><td>Children dewormed</td><td>' . $children_dewormed . '</td></tr>
			 <tr><td>Enrolled children dewormed</td><td>' . $enrolled_children_dewormed . '</td></tr>
			 <tr><td>Non-enrolled children dewormed</td><td>' . $non_enrolled_children_dewormed . '</td></tr>
	 	</table>
		<table border="1" cellpadding="1" cellspacing="1" width="50%" align="center">
			<tr><td width="80%">Children 5 and under dewormed</td><td width="20%">' . $under_5 . '</td></tr>
			<tr><td>Children over 5 dewormed</td><td>' . $over_5 . '</td></tr>
			<tr><td>Male children dewormed</td><td>' . $male_children_dewormed . '</td></tr>
			<tr><td>Female children dewormed</td><td>' . $female_children_dewormed . '</td></tr>
			<tr><td>Est. Dist/Div MoE personnel trained</td><td>' . $moe_trained . '</td></tr>
			<tr><td>Est. Dist/Div MoPHS personnel trained</td><td>' . $mophs_trained . '</td></tr>
		</table>';
		return;
	}

	echo '<table border="1" cellpadding="1" cellspacing="1" width="50%" align="center">
		 <tr><td width="80%">Schools targeted</td><td width="20%">' . $school_targeted . '</td></tr>
		 <tr><td>Schools participated</td><td>' . $school_participated . '</td></tr>
		 <tr><td>Children targeted</td><td>' . $children_targeted . '</td></tr>
		 <tr><td>Children dewormed</td><td>' . $children_dewormed . '</td></tr>
 	</table>
	<table border="1" cellpadding="1" cellspacing="1" width="50%" align="center">
		 <tr><td>Enrolled children dewormed</td><td>' . $enrolled_children_dewormed . '</td></tr>
		 <tr><td>Non-enrolled children dewormed</td><td>' . $non_enrolled_children_dewormed . '</td></tr>
		<tr><td>Male children dewormed</td><td>' . $male_children_dewormed . '</td></tr>
		<tr><td>Female children dewormed</td><td>' . $female_children_dewormed . '</td></tr>
	</table>';
	return;
}

// handle the data that goes into the bars
if (isset($_POST['national_bar_data'])) {
	$info_type = $_POST['info_type'];

	// get the schools participated data (first bar)
	if ($info_type == 'schools_participated') {
		// get a list of all the schools in form_a, by counting the unique school_programme_id
		$result = mysql_query("SELECT COUNT(school_name) AS school_count FROM form_a") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$school_count = $row["school_count"];

		// get a lsit of all the schools in the form_p_school_list table
		$result = mysql_query("SELECT COUNT(school_name) AS school_count FROM form_p_school_list") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$total_school_count = $row["school_count"];

		echo $school_count . "," . $total_school_count;
		return;
	}

	// get dewormed data (second bar)
	if ($info_type == 'children_dewormed') {
		// get a list of dewormed children enrolled from table form_a
		$result = mysql_query("SELECT ecd_treated_children_total, total_enrolled_in_register FROM form_a") or die(mysql_error());
		$form_a_total = 0;
		$form_p_total = 0;

		if (mysql_num_rows($result) != 0) {
			while ($row = mysql_fetch_array($result)) {
				$form_a_total += $row["ecd_treated_children_total"] + $row["total_enrolled_in_register"];
			}
		}

		// get a list of children in form_p_school_list
		$result = mysql_query("SELECT ecd_pri_school_enrollment, ecd_attached_enrollment FROM form_p_school_list") or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			while ($row = mysql_fetch_array($result)) {
				$form_p_total += $row["ecd_pri_school_enrollment"] + $row["ecd_attached_enrollment"];
			}
		}
		
		echo $form_a_total . "," . $form_p_total;
		return;	
	}
	
	// get the district data (third bar and currently broken)
	if ($info_type == 'districts_completed') {
		// get the amount of districts from form_a
		$result = mysql_query("SELECT COUNT(DISTINCT district) as district_count FROM form_a") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$district_count = $row["district_count"];
		
		// get the number of districts from form_p_school_list
		$result = mysql_query("SELECT COUNT(DISTINCT schools.district_name) AS district_count FROM form_p_school_list INNER JOIN schools ON form_p_school_list.prog_id = schools.school_id") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$p_district_count = $row["district_count"];
		echo $district_count . "," . $p_district_count;
		return;
	}
	
	// get the schi dewormed data (fourth bar)
	if ($info_type == 'children_dewormed_schi') {
			
		// get a list of all the targeted children (form_p_school_list)
		$targeted_children = 0;
		$result = mysql_query("SELECT ecd_pri_school_enrollment, ecd_attached_enrollment FROM form_p_school_list") or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			while ($row = mysql_fetch_array($result)) {
				$targeted_children += $row["ecd_pri_school_enrollment"] + $row["ecd_attached_enrollment"];
			}
		}
		
		// get a list of all the children dewormed (form_ap)
		// no column ecd_attached_enrollment found in any of the tables. Are you sure this was correct Vic?
		$children_dewormed = 0;
		$result = mysql_query("SELECT ecd_treated_children_total, enrolled_treated_total FROM form_ap") or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			while ($row = mysql_fetch_array($result)) {
				$children_dewormed += $row["ecd_attached_enrollment"] + $row["enrolled_treated_total"];
			}
		}
		
		echo $children_dewormed . "," . $targeted_children;
		return;
	}
}

if (isset($_POST['national_table_data'])) {
	
	// Districts completed
	$sth_districts_completed = $schi_districts_completed = 0;
	$result = mysql_query("SELECT COUNT(DISTINCT district) AS district_count FROM form_a") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$sth_districts_completed = $row["district_count"];
	$result = mysql_query("SELECT COUNT(DISTINCT district) AS district_count FROM form_ap") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$schi_districts_completed = $row["district_count"] - 1;
	
	// Schools participated
	$sth_schools_participated = $schi_schools_participated = 0;
	$result = mysql_query("SELECT COUNT(DISTINCT school_programme_id) AS school_count FROM form_a") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$sth_schools_participated = $row["school_count"];
	$result = mysql_query("SELECT COUNT(DISTINCT school_programme_id) AS school_count FROM form_ap") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$schi_schools_participated = $row["school_count"] - 1;
	
	/* Children dewormed, 
	 * male children dewormed, 
	 * female children dewormed, 
	 * Enrolled children dewormed, 
	 * Children 5 and under dewormed,
	 * children over 5 dewormed
	 */ 
	$sth_children_dewormed = $schi_children_dewormed = 0;
	$sth_male_children_dewormed = $schi_male_children_dewormed = 0;
	$sth_female_children_dewormed = $schi_female_children_dewormed = 0;
	$sth_enrolled_children_dewormed = $schi_enrolled_children_dewormed = 0;
	$sth_non_enrolled_children_dewormed = $schi_non_enrolled_children_dewormed = 0;
	$sth_children_5_and_under_dewormed = $schi_children_5_and_under_dewormed = 0;
	$sth_children_over_5_dewormed = $schi_children_over_5_dewormed = 0;
	
	// STH
	$result = mysql_query("SELECT * FROM form_a") or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {
		$sth_children_dewormed += $row["ecd_treated_children_total"] + $row["non_enrolled_total"];
		$sth_male_children_dewormed += $row['ecd_treated_male'] + $row['years_2_5_male'] + 
									   $row["years_6_10_male"] + $row['years_11_14_male'] + 
									   $row['years_15_18_male'] + $row["enrolled_male"];
		$sth_female_children_dewormed += $row['ecd_treated_female'] + $row['years_2_5_female'] + 
									   $row["years_6_10_female"] + $row['years_11_14_female'] + 
									   $row['years_15_18_female'] + $row["enrolled_female"];
	   $sth_enrolled_children_dewormed += $row["ecd_treated_chidren_total"] + $row["enrolled_treated_total"];
	   $sth_non_enrolled_children_dewormed += $row["non_enrolled_total"];
	   $sth_children_5_and_under_dewormed += $row["years_2_5_male"] + $row["years_2_5_male"];
	   $sth_children_over_5_dewormed += $row['years_6_10_male'] + $row['years_6_10_female'] + 
	   									$row['years_11_14_male'] + $row['years_11_14_female'] + 
	   									$row['years_15_18_male'] + $row['years_15_18_female'];
   	}
	
	// Schisto
	$result = mysql_query("SELECT * FROM form_ap") or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {
		$schi_children_dewormed += $row["ecd_treated_children_total"] + $row["non_enrolled_total"];
		$schi_male_children_dewormed += $row["ap_total_male"];
		$schi_female_children_dewormed += $row["ap_total_female"];
		$schi_enrolled_children_dewormed += $row["enrolled_treated_total"];
		$schi_non_enrolled_children_dewormed += $row["non_enrolled_total"];
		$schi_children_5_and_under_dewormed += $row["years_2_5_male"] + $row["years_2_5_male"];
		$schi_children_over_5_dewormed += $row['years_6_10_male'] + $row['years_6_10_female'] + 
										  $row['years_11_14_male'] + $row['years_11_14_female'] + 
										  $row['years_15_18_male'] + $row['years_15_18_female'];
   	}
	
	// Masters trained
	$sth_master_trainers_trained = $schi_master_trainers_trained = 0;
	$sth_district_division_moe = $schi_district_division_moe = 0;
	$sth_district_division_mophs = $schi_district_division_mophs = 0;
	// STH
	$result = mysql_query("SELECT * FROM master_trainers") or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {
		$sth_master_trainers_trained++;
		$ministry = $row["ministry"];
		if ($ministry == "MoE")
			$sth_district_division_moe++;			
		if ($ministry == "MoPHS")
			$sth_district_division_mophs++;
	}
	
	// Schisto: NEED TO FIND OUT
	
	// Completed teacher training sessions	
	$sth_completed_teacher_sessions = $schi_completed_teacher_sessions = 0;
	$sth_est_number_teachers_trained = $schi_est_number_teachers_trained = 0;
	
	echo '<!-- --------------------------- First Table --------------------------- -->
			<table border="1" cellpadding="1" cellspacing="1" width="50%" align="center">
			<tr><th>Statistics</th><th>STH</th><th>Schisto</th></tr>
			<tr><td>Districts completed</td><td>' . $sth_districts_completed . '</td><td>' . $schi_districts_completed . '</td></tr>
			<tr><td>Schools participated</td><td>' . $sth_schools_participated . '</td><td>' . $schi_schools_participated . '</td></tr>
			<tr><td>Children dewormed</td><td>' . $sth_children_dewormed . '</td><td>' . $schi_children_dewormed . '</td></tr>
			<tr><td>Male children dewormed</td><td>' . $sth_male_children_dewormed . '</td><td>' . $schi_male_children_dewormed . '</td></tr>
			<tr><td>Female children dewormed</td><td>' . $sth_female_children_dewormed . '</td><td>' . $schi_female_children_dewormed . '</td></tr>
			<tr><td>Enrolled children dewormed</td><td>' . $sth_enrolled_children_dewormed . '</td><td>' . $schi_enrolled_children_dewormed . '</td></tr>
			<tr><td>Non-enrolled children dewormed</td><td>' . $sth_non_enrolled_children_dewormed . '</td><td>' . $schi_non_enrolled_children_dewormed. '</td></tr>
	 	</table>
	 	<!-- --------------------------- Second Table --------------------------- -->
	 	<table border="1" cellpadding="1" cellspacing="1" width="50%" align="center">
			<tr><th>Statistics</th><th>STH</th><th>Schisto</th></tr>
			<tr><td>Children 5 and under dewormed</td><td>' . $sth_children_5_and_under_dewormed . '</td><td>' . $schi_children_5_and_under_dewormed . '</td></tr>
			<tr><td>Children over 5 dewormed</td><td>' . $sth_children_over_5_dewormed . '</td><td>' . $schi_children_over_5_dewormed . '</td></tr>
			<tr><td>Master Trainers trained</td><td>' . $sth_master_trainers_trained . '</td><td>' . $schi_master_trainers_trained . '</td></tr>
			<tr><td>Est.district/division MoE personnel trained</td><td>' . $sth_district_division_moe . '</td><td>' . $schi_district_division_moe . '</td></tr>
			<tr><td>Est.district/division MoPHS personnel trained</td><td>' . $sth_district_division_mophs . '</td><td>' . $schi_district_division_mophs . '</td></tr>
			<tr><td>Completed teacher training sessions</td><td>' . $sth_completed_teacher_sessions . '</td><td>' . $schi_completed_teacher_sessions . '</td></tr>
			<tr><td>Est. number of teachers trained</td><td>' . $sth_est_number_teachers_trained . '</td><td>' . $schi_est_number_teachers_trained . '</td></tr>
	 	</table>';
}

if (isset($_POST['progress_data'])) {

	$data = $_POST['progress_data'];
	$district = $_POST['district'];

	$treatment_type = $_POST['treatment'];

	$table = $treatment_type == "albe" ? "form_a" : "form_ap";

	if ($data == "dewormed") {
		$children_dewormed = 0;
		$enrolled_children_dewormed = 0;
		$non_enrolled_children_dewormed = 0;
		$children_targeted = 0;

		$result = mysql_query("SELECT * FROM $table WHERE district = '$district'") or die(mysql_error());

		while (($row = mysql_fetch_array($result)) != 0) {
			$enrolled_children_dewormed += $row['ecd_treated_children_total'] + $row['enrolled_treated_total'];
			$non_enrolled_children_dewormed += $row['non_enrolled_total'];
			$under_5 += $row['years_2_5_male'] + $row['years_2_5_female'];
			$over_5 += $row['years_6_10_male'] + $row['years_6_10_female'] + $row['years_11_14_male'] + $row['years_11_14_female'] + $row['years_15_18_male'] + $row['years_15_18_female'];
			$male_children_dewormed += $row['ecd_treated_male'] + $row['years_2_5_male'] + $row["years_6_10_male"] + $row['years_11_14_male'] + $row['years_15_18_male'];
			$female_children_dewormed += $row['ecd_treated_female'] + $row['years_2_5_female'] + $row["years_6_10_female"] + $row['years_11_14_female'] + $row['years_15_18_female'];
		}

		$children_dewormed = $enrolled_children_dewormed + $non_enrolled_children_dewormed;
		$result = mysql_query("SELECT * FROM form_p_school_list") or die(mysql_error());

		while (($row = mysql_fetch_array($result)) != 0) {
			$children_targeted += $row["ecd_pri_school_enrollment"] + $row["ecd_attached_enrollment"] + $row["estimated_enrollmet"];
		}

		$primary_percentage = $enrolled_children_dewormed / $children_targeted * 100;
		echo $children_dewormed . "," . $children_targeted . "," . $primary_percentage;

	} else if ($data == "treated") {

		$result = mysql_query("SELECT COUNT(prog_id) AS school_count FROM form_p_school_list") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$school_targeted = $row["school_count"];

		$result = mysql_query("SELECT COUNT(DISTINCT school_programme_id) AS school_count FROM form_a ") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$school_participated = $row["school_count"];

		echo $school_participated . "," . $school_targeted;
	} else {
		echo 0;
	}
	return;
}
?>

