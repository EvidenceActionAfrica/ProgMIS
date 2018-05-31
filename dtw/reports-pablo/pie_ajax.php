<?php

/**
 * I had to rewrite all the code because Nabanita is one of the
 * worst programmers I've ever seen.
 */
include ("config/dbconfig_reportengine.php");
include ("config/functions.php");

$evidenceaction = new EvidenceAction();
/**
 * Used for the "standardized_reports_districts.php" data
 */
if (isset($_POST['request_data'])) {
	if (isset($_POST['data_type'])) {

		$data_type = $_POST['data_type'];
		$district = $_POST['district'];
		$where = " district = '$district'";
		$treatment_type = $_POST['treatment'];

		$table = $treatment_type == "albe" ? "form_a" : "form_ap";

		if ($data_type == "enrolled") {

			$fields = 'ecd_treated_children_total, total_enrolled_in_register, non_enrolled_total';
			$result_set = $evidenceaction -> mysql_fetch_all($table, $fields, $where);

			$enrolled_total = 0;
			$non_enrolled_total = 0;

			if (sizeof($result_set) != 0) {
				foreach ($result_set as $data) {
					$enrolled_total += $data['ecd_treated_children_total'] + $data['total_enrolled_in_register'];
					$non_enrolled_total += $data['non_enrolled_total'];
				}

				$total = $non_enrolled_total + $enrolled_total;
				if ($total != 0) {
					$non_enrolled_total = $non_enrolled_total / $total * 100.0;
					$enrolled_total = $enrolled_total / $total * 100.0;
					// Data format:
					// title, label1, label2, data1, data2
					$result = sprintf("%s,%s,%s,%d,%d,%d", "Enrollment Status", "Enrolled", "Not enrolled", $enrolled_total, $non_enrolled_total, $total);
					echo $result;
				} else {
					echo "";
				}
				return;
			}
		}

		if ($data_type == "age") {
			$fields = 'years_2_5_male,years_2_5_female,years_6_10_male,years_6_10_female,years_11_14_male,years_11_14_female,years_15_18_male,years_15_18_female';
			$result_set = $evidenceaction -> mysql_fetch_all($table, $fields, $where);

			$under_5 = 0;
			$over_5 = 0;

			if (sizeof($result_set) != 0) {
				foreach ($result_set as $data) {
					$under_5 += $data['years_2_5_male'] + $data['years_2_5_female'];
					$over_5 += $data['years_6_10_male'] + $data['years_6_10_female'] + $data['years_11_14_male'] + $data['years_11_14_female'] + $data['years_15_18_male'] + $data['years_15_18_female'];
				}
				$total = $under_5 + $over_5;
				$under_5 = $under_5 / $total * 100.0;
				$over_5 = $over_5 / $total * 100.0;
				$result = sprintf("%s,%s,%s,%d,%d,%d", "Age Bracket", "Children 5 and under", "Children over 5", $under_5, $over_5, $total);
				echo $result;
				return;
			}
		}

		if ($data_type == "sex") {

			$fields = 'ecd_treated_male,ecd_treated_female,years_2_5_male,years_2_5_female,years_6_10_male,years_6_10_female,years_11_14_male,years_11_14_female,years_15_18_male,years_15_18_female,enrolled_male,enrolled_female';
			$result_set = $evidenceaction -> mysql_fetch_all($table, $fields, $where);

			$male = 0;
			$female = 0;
			if (sizeof($result_set) != 0) {
				foreach ($result_set as $data) {
					$male += $data['ecd_treated_male'] + $data['years_2_5_male'] + $data['years_6_10_male'] + $data['years_11_14_male'] + $data['years_15_18_male'] + $data['enrolled_male'];

					$female += $data['ecd_treated_female'] + $data['years_2_5_female'] + $data['years_6_10_female'] + $data['years_11_14_female'] + $data['years_15_18_male'] + $data['enrolled_female'];
				}

				$total = $male + $female;
				if ($total != 0) {
					$male = $male / $total * 100.0;
					$female = $female / $total * 100.0;
					$result = sprintf("%s,%s,%s,%d,%d,%d", "Sex", "Male", "Female", $male, $female, $total);
					echo $result;
				} else {
					echo "";
				}
			}
		}
	}
}

/**
 * Used for the "national_reports.php" file
 */
if (isset($_POST['national_data'])) {
	$data_type = $_POST['data_type'];
	
	if ($data_type == 'sth_enrollment') {
		// get all the enrolled data in all schools in form_a
		$enrolled = 0;
		$result = mysql_query("SELECT ecd_treated_children_total, total_enrolled_in_register FROM form_a") or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			while ($row = mysql_fetch_array($result)) {
				$enrolled += $row["ecd_treated_children_total"] + $row["total_enrolled_in_register"];
			}
		}
		
		// get all the non-enrolled data
		$non_enrolled = 0;
		$result = mysql_query("SELECT non_enrolled_total FROM form_a") or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			while ($row = mysql_fetch_array($result)) {
				$non_enrolled += $row["non_enrolled_total"];
			}
		}
		echo $enrolled . "," . $non_enrolled;
		return;
	}
	
	if ($data_type == 'sth_age') {
		// all children under 5;		
		$children_under_5 = 0;
		$children_over_5 = 0;
		
		$result = mysql_query("SELECT * FROM form_a") or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			while ($row = mysql_fetch_array($result)) {
				$children_under_5 += $row['years_2_5_male'] + $row['years_2_5_female'];
				$children_over_5 += $row['years_6_10_male'] + $row['years_6_10_female'] + $row['years_11_14_male'] + $row['years_11_14_female'] + $row['years_15_18_male'] + $row['years_15_18_female'];
			}
		}
		echo $children_under_5 . "," . $children_over_5;
		return;
	}
	
	if ($data_type == 'sth_sex') {
		$male = 0;
		$female = 0;
		
		$result = mysql_query("SELECT * FROM form_a") or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			while ($row = mysql_fetch_array($result)) {
				$male += $row['ecd_treated_male'] + $row['years_2_5_male'] + 
						 $row['years_6_10_male'] + $row['years_11_14_male'] + 
						 $row['years_15_18_male'] + $row['enrolled_male'];
				$female += $row['ecd_treated_female'] + $row['years_2_5_female'] + 
						 $row['years_6_10_female'] + $row['years_11_14_female'] + 
						 $row['years_15_18_female'] + $row['enrolled_female'];
			}
		}
		echo $male . "," . $female;
		return;
	}
	
	if ($data_type == 'schi_enrollment') {
		$enrolled = 0;
		$non_enrolled = 0;
		$result = mysql_query("SELECT enrolled_treated_total, non_enrolled_total FROM form_ap") or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			mysql_fetch_array($result);	// skip firt row (table headings row)
			while ($row = mysql_fetch_array($result)) {
				$enrolled += $row["enrolled_treated_total"];
				$non_enrolled += $row["non_enrolled_total"];
			}
		}
		echo $enrolled . "," . $non_enrolled;
		return;
	}
	
	if ($data_type == 'schi_sex') {
		$male = 0;
		$female = 0;
		$result = mysql_query("SELECT ap_total_male, ap_total_female FROM form_ap")	or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			mysql_fetch_array($result);	// skip first row (table headings row)
			while ($row = mysql_fetch_array($result)) {
				$male += $row["ap_total_male"];
				$female += $row["ap_total_female"];
			}
		}
		echo $male . "," . $female;
		return;
	}
}































?>