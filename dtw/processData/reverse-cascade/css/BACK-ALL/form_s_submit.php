<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
	require_once ("includes/functions.php");
	require_once ("includes/form_functions.php");
	$level = $_SESSION['level'];
	
	if (isset($_POST['submit'])) {
		// get the form contents
		
		$survey_id = $_POST['survey_id'];

		// Section 1 data
		$school_name = $_POST['school'];
		$school_type = $_POST['school_type'];
		$deworming_date = $_POST['deworming_date'];
		$district = $_POST['school_district'];
		$division = $_POST['school_division'];
		$zone = $_POST['zone'];
		
		// section 2 data
		// TOTAL NUMBER OF ECS CHILDREN TREATED
		$ecd_treated_male = $_POST['ecd_treated_male'];
		$ecd_treated_female = $_POST['ecd_treated_male'];
		$ecd_treated_children_total = $_POST['ecd_treated_children_total'];	
		$ecd_adults_treated = $_POST['ecd_adults_treated'];
		$ecd_tablets_spoilt = $_POST['ecd_tablets_spoilt'];
		
		// section 4
		// 2-5 years
		$years_2_5_male = $_POST['years_2_5_male'];
		$years_2_5_female = $_POST['years_2_5_female'];
		// 6-10 years 
		$years_6_10_male = $_POST['years_6_10_male'];
		$years_6_10_female = $_POST['years_6_10_female'];
		// 11-14 years
		$years_11_14_male = $_POST['years_11_14_male'];
		$years_11_14_female = $_POST['years_11_14_female'];
		// 15-18 years
		$years_15_18_male = $_POST['years_15_18_male'];
		$years_15_18_female = $_POST['years_15_18_female'];
		
		$non_enrolled_total = $_POST['non_enrolled_total'];
		$non_enrolled_adults_treated = $_POST['non_enrolled_adults_treated'];
		$non_enrolled_tablets_spoilt = $_POST['non_enrolled_tablets_spoilt'];
		
		// section 5
		$albendazole_returned = $_POST['albendazole_returned'];
		$albendazole_received = $_POST['albendazole_received'];
		
		$total_a_b_c = $_POST['total_a_b_c'];
		$total_d_e_f = $_POST['total_d_e_f'];
		$total_g_h_i = $_POST['total_g_h_i'];
		
		$head_teacher = $_POST['head_teacher'];
		$phone_number = $_POST['phone_number'];
		
		// AEO section
		$aeo_name = $_POST['aeo_name'];
		$aeo_phone_number = $_POST['aeo_phone_number'];
		$date_s_received = $_POST['date_s_received'];
		$school_programme_id = $_POST['school_programme_id'];
		
		/*
		echo "<br />Survey id: " . $survey_id;
		echo "<br />School name: " . $school_name;
		echo "<br />School type: " . $school_type;
		echo "<br />Deworming date: " . $deworming_date;
		echo "<br />District: " . $district;
		echo "<br />Division: " . $division;
		echo "<br />Zone: " . $zone;
		
		echo "<br />Male total: " . $ecd_treated_male;
		echo "<br />Female total: " . $ecd_treated_female;
		echo "<br />Total: " . $ecd_treated_children_total;
		echo "<br />Adults: " . $ecd_adults_treated;
		echo "<br />Tablets spoiled: " . $ecd_tablets_spoiled;
		
		echo "<br />Section 4 (2-5 years) male: " . $years_2_5_male;
		echo "<br />Section 4 (2-5 years) female: " . $years_2_5_female;
						
		echo "<br />Section 4 (6-10 years) male: " . $years_6_10_male;
		echo "<br />Section 4 (6-10 years) female: " . $years_6_10_female;
		
		echo "<br />Section 4 (11-14 years) male: " . $years_11_14_male;
		echo "<br />Section 4 (11-14 years) female: " . $years_11_14_female;
		
		echo "<br />Section 4 (15-18 years) male: " . $years_15_18_male;
		echo "<br />Section 4 (15-18 years) female: " . $years_15_18_female;
		
		echo "<br />Section 4 total: " . $non_enrolled_total;
		echo "<br />Section 4 adults: " . $non_enrolled_adults_treated;
		echo "<br />Section 4 spoiled: " . $non_enrolled_tablets_spoilt;
		
		echo "<br />Section 5 Received by: " . $albendazole_received;
		echo "<br />Section 5 Returned by: " . $albendazole_returned;
		
		echo "<br />Section 5 Children: " . $total_a_b_c;
		echo "<br />Section 5 Adults: " . $total_d_e_f;
		echo "<br />Section 5 Spoiled: " . $total_g_h_i;
		
		echo "<br />Head teacher name: " . $head_teacher;
		echo "<br />Head teacher phone: " . $phone;

		echo "<br />AEO name: " . $aeo_name;
		echo "<br />AEO phone: " . $aeo_phone;
		echo "<br />AEO date received: " . $aeo_date_received;
		echo "<br />AEO programme: " . $school_programme_id;
		*/
		
		// insertion into the database sections 1, 2, 4, and 5
		$query = 
		"INSERT INTO form_s 
		(
				survey_id, school_name, school_type, deworming_date, district, 
				division, zone, ecd_treated_male, ecd_treated_female,
				ecd_treated_children_total, ecd_adults_treated, ecd_tablets_spoilt,
				years_2_5_male, years_2_5_female,
				years_6_10_male, years_6_10_female,
				years_11_14_male, years_11_14_female,
				years_15_18_male, years_15_18_female,
				non_enrolled_total, non_enrolled_adults_treated, non_enrolled_tablets_spoilt, albendazole_recieved,
				albendazole_returned, total_a_b_c, total_d_e_f, total_g_h_i, head_teacher, phone_number,
				aeo_name, school_programme_id, date_s_received, aeo_phone_number
		)
		VALUES 
		(
				'$survey_id', '$school_name', '$school_type', '$deworming_date', '$district',
				'$division', '$zone', '$ecd_treated_male', '$ecd_treated_female',
				'$ecd_treated_children_total', '$ecd_adults_treated', '$ecd_tablets_spoilt', 
				'$years_2_5_male', '$years_2_5_female',
				'$years_6_10_male', '$years_6_10_female',
				'$years_11_14_male', '$years_11_14_female',
				'$years_15_18_male', '$years_15_18_female',
				
				'$non_enrolled_total', '$non_enrolled_adults_treated', '$non_enrolled_tablets_spoilt', '$albendazole_received',
				'$albendazole_returned', '$total_a_b_c', '$total_d_e_f', '$total_g_h_i', '$head_teacher', '$phone_number', 
				'$aeo_name', '$school_programme_id', '$date_s_received', '$aeo_phone_number'
		)";
		
		$resutl = mysql_query($query) or die(mysql_error());
		
		// insert section 3 data into the database
		// section 3
		$register_male = $_POST['register_male'];
		$register_female = $_POST['register_female'];
		$register_total = $_POST['register_total'];
		$treated_male = $_POST['treated_male'];
		$treated_female = $_POST['treated_female'];
		$treated_total = $_POST['treated_total'];
		$adults_treated = $_POST['adults_treated'];
		$tablets_spoilt = $_POST['tablets_spoilt'];
		
		$section3_query = "INSERT INTO form_s_class 
		(
			form_s_survey_id, class, number_in_register_male, number_in_register_female,
			number_in_register_class_total, number_treated_male, number_treated_female,
			number_treated_total, adults_treated, tablets_spoilt
		) VALUES ";
		
		for ($i = 0; $i < sizeof($register_male); $i++) {
			$s = sprintf("('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') %s",
			$survey_id, ($i + 1), $register_male[$i], $register_female[$i], $register_total[$i], 
			$treated_male[$i], $treated_female[$i], $treated_total[$i], $adults_treated[$i], $tablets_spoilt[$i],
			($i == sizeof($register_male) - 1 ? "" : ", "));
			
			$section3_query .= $s; 
		}
		
		// run the query
		$result = mysql_query($section3_query) or die(mysql_error());
		
		// grab the totals from the section 3 bottom table row
		$number_in_register_male_total = $_POST['number_in_register_male_total'];
		$number_in_register_female_total = $_POST['number_in_register_female_total'];
		$number_in_register_class_total_total = $_POST['number_in_register_class_total_total'];
		$number_treated_male_total = $_POST['number_treated_male_total'];
		$number_treated_female_total = $_POST['number_treated_female_total'];
		$number_treated_total_total = $_POST['number_treated_total_total'];
		$adults_treated_total = $_POST['adults_treated_total'];
		$tablets_spoilt_total = $_POST['tablets_spoilt_total'];
		
		// insertion into the form_s_class_total
		$result = mysql_query("INSERT INTO form_s_class_totals
		(
			form_s_survey_id, number_in_register_male_total, number_in_register_female_total,
			number_in_register_class_total_total, number_treated_male_total, number_treated_female_total,
			number_treated_total_total, adults_treated_total, tablets_spoilt_total
		)
		VALUES
		(
			'$survey_id', '$number_in_register_male_total', '$number_in_register_female_total', 
			'$number_in_register_class_total_total', '$number_treated_male_total', '$number_treated_female_total',
			 '$number_treated_total_total', '$adults_treated_total', '$tablets_spoilt_total'
		)") or die(mysql_error());
		
	} else {
		header("Location: form_s.php");
		exit();
	}
?>



<br /><br />



















































