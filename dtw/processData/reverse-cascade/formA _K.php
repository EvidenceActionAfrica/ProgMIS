<html>
<head>
	<title>FormA</title>
	<?php include"header_links.php"; 

		include 'db_classes/global.php';?>

	<?php 
	

		// set the loop for number of schools
		$number_of_schools=11;

		// check if the sheet number is there
		// if not st it to one
		if (isset($_GET['formA_sheet_number'])) {
			$sheet=$_GET['formA_sheet_number'];
			$formA_sheet_number=$sheet+1;
		}else{
			$formA_sheet_number="1";
		}

		// check if the survey ID is there 
		// if not dont set it
		if (isset($_GET['formA_survey_id'])) {
			$formA_survey_id=$_GET['formA_survey_id'];
		}else{
			$formA_survey_id='';
		}

		if (isset($_GET['formA_aeo_name'])) {
			$formA_aeo_name=$_GET['formA_aeo_name'];
		}else{
			$formA_aeo_name="";
		}

		if (isset($_GET['formA_district'])) {
			$formA_district=$_GET['formA_district'];
		}else{
			$formA_district="";
		}

		if (isset($_GET['formA_division'])) {
			$formA_division=$_GET['formA_division'];

		}else{
			$formA_division="";
		}

		if (isset($_GET['formA_aeo_phone_number'])) {
			$formA_aeo_phone_number=$_GET['formA_aeo_phone_number'];
		}else{
			$formA_aeo_phone_number="";
		}

		function readonly($get){
			// if (isset($_GET['formA_survey_id'])  || 
			// 	isset($_GET['formA_aeo_name']) || 
			// 	isset($_GET['formA_district']) || 
			// 	isset($_GET['formA_division']) || 
			// 	isset($_GET['formA_aeo_phone_number'])) {
			// 	echo "readonly";
			// }
			if (isset($get)) {
				echo "readonly";
			}

			
		}


		if (isset($_POST['submit'])) {

			// first itterate and save the main table
			for ($i=0; $i <$number_of_schools ; $i++) { 
				# code...
			
			  $sheet_number = $_POST['sheet_number'][$i];
			  $survey_id = $_POST['survey_id'][$i];
			  $school_name = $_POST['school_name'][$i];
			  $district = $_POST['district'][$i];
			  $division = $_POST['division'][$i];
			  $form_s_returned = $_POST['form_s_returned'][$i];
			  $ecd_treated_male = $_POST['ecd_treated_male'][$i];
			  $ecd_treated_female = $_POST['ecd_treated_female'][$i];
			  $ecd_treated_children_total = $_POST['ecd_treated_children_total'][$i];
			  // $ecd_treated_male_total = $_POST['ecd_treated_male_total'][$i];
			  // $ecd_treated_female_total = $_POST['ecd_treated_female_total'][$i];
			  // $ecd_treated_children_total_total = $_POST['ecd_treated_children_total_total'][$i];
			  $years_2_5_male = $_POST['years_2_5_male'][$i];
			  $years_2_5_female = $_POST['years_2_5_female'][$i];
			  $years_6_10_male = $_POST['years_6_10_male'][$i];
			  $years_6_10_female = $_POST['years_6_10_female'][$i];
			  $years_11_14_male = $_POST['years_11_14_male'][$i];
			  $years_11_14_female = $_POST['years_11_14_female'][$i];
			  $years_15_18_male = $_POST['years_15_18_male'][$i];
			  $years_15_18_female = $_POST['years_15_18_female'][$i];
			  // $years_2_5_male_total = $_POST['years_2_5_male_total'][$i];
			  // $years_2_5_female_total = $_POST['years_2_5_female_total'][$i];
			  // $years_6_10_male_total = $_POST['years_6_10_male_total'][$i];
			  // $years_6_10_fermale_total = $_POST['years_6_10_fermale_total'][$i];
			  // $years_11_14_male_total = $_POST['years_11_14_male_total'][$i];
			  // $years_11_14_female_total = $_POST['years_11_14_female_total'][$i];
			  // $years_15_18_male_total = $_POST['years_15_18_male_total'][$i];
			  // $years_15_18_female_total = $_POST['years_15_18_female_total'][$i];
			  $non_enrolled_total = $_POST['non_enrolled_total'][$i];
			  // $non_enrolled_total_total = $_POST['non_enrolled_total_total'][$i];
			  $total_enrolled_in_register = $_POST['total_enrolled_in_register'][$i];
			  $enrolled_male = $_POST['enrolled_male'][$i];
			  $enrolled_female = $_POST['enrolled_female'][$i];
			  $enrolled_treated_total = $_POST['enrolled_treated_total'][$i];
			  // $total_enrolled_in_register_total = $_POST['total_enrolled_in_register_total'][$i];
			  // $enrolled_male_total = $_POST['enrolled_male_total'][$i];
			  // $enrolled_female_total = $_POST['enrolled_female_total'][$i];
			  // $enrolled_treated_total_total = $_POST['enrolled_treated_total_total'][$i];
			  $aeo_name = $_POST['aeo_name'][$i];
			  $aeo_phone_number = $_POST['aeo_phone_number'][$i];
			  $school_programme_id = $_POST['school_programme_id'][$i];

			  $form->create(
			  		$sheet_number,
					$survey_id,
					$school_name,
					$district,
					$division,
					$form_s_returned,
					$ecd_treated_male,
					$ecd_treated_female,
					$ecd_treated_children_total,
					// $ecd_treated_male_total,
					// $ecd_treated_female_total,
					// $ecd_treated_children_total_total,
					$years_2_5_male,
					$years_2_5_female,
					$years_6_10_male,
					$years_6_10_female,
					$years_11_14_male,
					$years_11_14_female,
					$years_15_18_male,
					$years_15_18_female,
					// $years_2_5_male_total,
					// $years_2_5_female_total,
					// $years_6_10_male_total,
					// $years_6_10_fermale_total,
					// $years_11_14_male_total,
					// $years_11_14_female_total,
					// $years_15_18_male_total,
					// $years_15_18_female_total,
					$non_enrolled_total,
					// $non_enrolled_total_total,
					$total_enrolled_in_register,
					$enrolled_male,
					$enrolled_female,
					$enrolled_treated_total,
					// $total_enrolled_in_register_total,
					// $enrolled_male_total,
					// $enrolled_female_total,
					// $enrolled_treated_total_total,
					$aeo_name,
					$aeo_phone_number,
					$school_programme_id
			  	);

			}	// end for loop

			// second save the totals


			// just to totals
			  $ecd_treated_male_total = $_POST['ecd_treated_male_total'];
			  $ecd_treated_female_total = $_POST['ecd_treated_female_total'];
			  $ecd_treated_children_total_total = $_POST['ecd_treated_children_total_total'];
			 
			  $years_2_5_male_total = $_POST['years_2_5_male_total'];
			  $years_2_5_female_total = $_POST['years_2_5_female_total'];
			  $years_6_10_male_total = $_POST['years_6_10_male_total'];
			  $years_6_10_female_total = $_POST['years_6_10_female_total'];
			  $years_11_14_male_total = $_POST['years_11_14_male_total'];
			  $years_11_14_female_total = $_POST['years_11_14_female_total'];
			  $years_15_18_male_total = $_POST['years_15_18_male_total'];
			  $years_15_18_female_total = $_POST['years_15_18_female_total'];
			  $non_enrolled_total_total = $_POST['non_enrolled_total_total'];
			
			  $total_enrolled_in_register_total = $_POST['total_enrolled_in_register_total'];
			  $enrolled_male_total = $_POST['enrolled_male_total'];
			  $enrolled_female_total = $_POST['enrolled_female_total'];
			  $enrolled_treated_total_total = $_POST['enrolled_treated_total_total'];


			  // the sheet number and survey Id have been added
			  $form->create_formA_totals(
			  	  $sheet_number,
				  $survey_id,
			  	  $ecd_treated_male_total,
				  $ecd_treated_female_total,
				  $ecd_treated_children_total_total,
				  $years_2_5_male_total,
				  $years_2_5_female_total,
				  $years_6_10_male_total,
				  $years_6_10_female_total,
				  $years_11_14_male_total,
				  $years_11_14_female_total,
				  $years_15_18_male_total,
				  $years_15_18_female_total,
				  $non_enrolled_total_total,
				  $total_enrolled_in_register_total,
				  $enrolled_male_total,
				  $enrolled_female_total,
				  $enrolled_treated_total_total
					
			  	);

			  if (!empty($_POST['ecd_treated_male_grand_total']) &&
					 !empty($_POST['ecd_treated_female_grand_total']) &&
					 !empty($_POST['ecd_treated_children_total_grand_total']) &&
					 !empty($_POST['years_2_5_male_grand_total']) &&
					 !empty($_POST['years_2_5_female_grand_total']) &&
					 !empty($_POST['years_6_10_male_grand_total']) &&
					 !empty($_POST['years_6_10_female_grand_total']) &&
					 !empty($_POST['years_11_14_male_grand_total']) &&
					 !empty($_POST['years_11_14_female_grand_total']) &&
					 !empty($_POST['years_15_18_male_grand_total']) &&
					 !empty($_POST['years_15_18_female_grand_total']) &&
					 !empty($_POST['non_enrolled_total_grand_total']) &&
					 !empty($_POST['total_enrolled_in_register_grand_total']) &&
					 !empty($_POST['enrolled_male_grand_total']) &&
					 !empty($_POST['enrolled_female_grand_total']) &&
					 !empty($_POST['enrolled_treated_total_grand_total'])


			  	) {
			  	// die();
			  	
			 	 // grand totals
			  	 $ecd_treated_male_grand_total = $_POST['ecd_treated_male_grand_total'];
				 $ecd_treated_female_grand_total = $_POST['ecd_treated_female_grand_total'];
				 $ecd_treated_children_total_grand_total = $_POST['ecd_treated_children_total_grand_total'];
				 $years_2_5_male_grand_total = $_POST['years_2_5_male_grand_total'];
				 $years_2_5_female_grand_total = $_POST['years_2_5_female_grand_total'];
				 $years_6_10_male_grand_total = $_POST['years_6_10_male_grand_total'];
				 $years_6_10_female_grand_total = $_POST['years_6_10_female_grand_total'];
				 $years_11_14_male_grand_total = $_POST['years_11_14_male_grand_total'];
				 $years_11_14_female_grand_total = $_POST['years_11_14_female_grand_total'];
				 $years_15_18_male_grand_total = $_POST['years_15_18_male_grand_total'];
				 $years_15_18_female_grand_total = $_POST['years_15_18_female_grand_total'];
				 $non_enrolled_total_grand_total = $_POST['non_enrolled_total_grand_total'];
				 $total_enrolled_in_register_grand_total = $_POST['total_enrolled_in_register_grand_total'];
				 $enrolled_male_grand_total = $_POST['enrolled_male_grand_total'];
				 $enrolled_female_grand_total = $_POST['enrolled_female_grand_total'];
				 $enrolled_treated_total_grand_total = $_POST['enrolled_treated_total_grand_total'];
			 	
			 	// i OVERIDE THE SHEET NUMBER HERE CUZ GRAND TOTAL DO NOT HAVE ONE
				 // ALSO TO DEFRINCIATE BETWEEN NORMAL TOTALS AND GRAND TOTALS

				  $grand_total_sheet_number="NONE GRAND TOTAL";
			 	$form->create_formA_totals(
			 		 $grand_total_sheet_number,
					 $survey_id,
			  		 $ecd_treated_male_grand_total,
					 $ecd_treated_female_grand_total,
					 $ecd_treated_children_total_grand_total,
					 $years_2_5_male_grand_total,
					 $years_2_5_female_grand_total,
					 $years_6_10_male_grand_total,
					 $years_6_10_female_grand_total,
					 $years_11_14_male_grand_total,
					 $years_11_14_female_grand_total,
					 $years_15_18_male_grand_total,
					 $years_15_18_female_grand_total,
					 $non_enrolled_total_grand_total,
					 $total_enrolled_in_register_grand_total,
					 $enrolled_male_grand_total,
					 $enrolled_female_grand_total,
					 $enrolled_treated_total_grand_total
										
			  	);

			  	# refresh the page and return to sheet 1
			  	header('Location:formA_update.php');

			  }else{

			  	// reload the page with sheet number and survey ID
			  	$newURL="formA.php?formA_sheet_number=".$sheet_number
			  			."&formA_survey_id=".$survey_id
			  			."&formA_aeo_name=".$aeo_name
			  			."&formA_district=".$district
			  			."&formA_division=".$division
			  			."&formA_aeo_phone_number=".$aeo_phone_number
			  			;

			  	header('Location: '.$newURL);
			  }


			  	

		}



	 ?>
</head>
<body>

<?php include 'sideMenu.php'; ?>
	<div class="contentBody">

	<?php// include "evidence_action_header.php" ?>
	<h1>Form A</h1>
	<?php //include "navigation.php"; ?>
	<div class="conatiner four columns vfloatleft big_input">
		<label class="big_label">Survey ID</label><br>
		<input type="text" id="text_survey_id" name="survey_id[]" placeholder="" value="<?php echo $formA_survey_id ?> " <?php isset($_GET['formA_survey_id']) ? readonly($_GET['formA_survey_id']) : null; ?>>
	</div>
	<div class="conatiner four columns vfloatleft big_input">

		<!-- check top code for more info -->
		<label class="big_label">Sheet Number</label><br>
		<input type="text" id="text_sheet_number"name="sheet_number[]" placeholder="" value="<?php echo $formA_sheet_number ?>" readonly>
	</div>

	<div class="vclear"></div>


	<div class="conatiner four columns vfloatleft big_input">
		<label class="big_label">Aeo_name</label><br>
		<input type="text" name="aeo_name[]" id="text_aeo_name" placeholder="" value="<?php echo $formA_aeo_name ?>" <?php isset($_GET['formA_aeo_name']) ? readonly($_GET['formA_aeo_name']) : null; ?>>
	</div>
	<div class="conatiner four columns vfloatleft big_input">
		<label class="big_label">district</label><br>
		<input type="text" name="district[]" id="text_district" placeholder="" value="<?php echo $formA_district ?>" <?php isset($_GET['formA_district']) ? readonly($_GET['formA_district']) : null; ?> >
	</div>
		<div class="vclear"></div>

	<div class="conatiner four columns vfloatleft big_input">
		<label class="big_label">aeo_phone_number</label><br>
		<input type="text" name="aeo_phone_number[]" id="text_aeo_phone_number" placeholder="" value="<?php echo $formA_aeo_phone_number ?>" <?php isset($_GET['formA_aeo_phone_number']) ? readonly($_GET['formA_aeo_phone_number']) : null; ?> >
	</div>
	<div class="conatiner four columns vfloatleft big_input">
		<label class="big_label">division</label><br>
		<input type="text" name="division[]" id="text_division" placeholder="" value="<?php echo $formA_division ?>" <?php isset($_GET['formA_division']) ? readonly($_GET['formA_division']) : null; ?>>
	</div>
	<div class="vclear"></div>

	<!-- <img src="css/images/formA.png"> -->
	<form action="" method="post">
		<table  id="hor-minimalist-b">
	<tr>
		<td colspan="4" rowspan="3"></td>
		<td colspan="16">3. Fill the information below for each for each school isong the correct sections of Form S</td>
	</tr>
	<tr>
		<td colspan="3">
			Enrolled ECD <br> Children <br><span class="table-small">(Section 2 on S)</span>
		</td>
		<td colspan="4">
			Enrolled Primary SChool <br>Children <br> <span class="table-small">(Section 3 on S)</span>
		</td>
		<td colspan="9">
			Non Enrolled Children <br> <span class="table-small">(Section 4 on S)</span>
		</td>
	</tr>

	<tr>
		<td colspan="3">
			Totale number of <br> children treated
		</td>

		<td>
			Children <br>in register <br> book
		</td>
		<td colspan="3">
			Total Number of <br>children treated
		</td>
		<td colspan="2">2-5 yrs</td>
		<td colspan="2">6-10 yrs</td>
		<td colspan="2">11-14yrs</td>
		<td colspan="2">15-18yrs</td>
		<td></td>
	</tr>
	<tr>
		<td>ID</td>
		<td>School name in full</td>
		<td>Programme Assigned ID</td>
		<td>S returned</td>

		<td>M</td>
		<td>F</td>
		<td>Total <br> (A)</td>
		<td>Total <br> (S)</td>
		<td>M</td>
		<td>F</td>
		<td>Total <br> (B)</td>
		<td>M</td>
		<td>F</td>
		<td>M</td>
		<td>F</td>
		<td>M</td>
		<td>F</td>
		<td>M</td>
		<td>F</td>
		<td>Total <br> (c)</td>

	</tr>
	<br>
    	<tr>
<?php 
	for ($i=0; $i <$number_of_schools ; $i++) { 
	
 ?>
					<div class="conatiner four columns vfloatleft">
						<!-- <label>Survey ID</label><br> -->
						<input type="hidden" name="survey_id[]" class="survey_id" placeholder="survey_id" value="<?php echo $formA_survey_id?>">
					</div>
					<div class="conatiner four columns vfloatleft">
						<!-- <label>Sheet Number</label><br> -->
						<input type="hidden" name="sheet_number[]" class="sheet_number" placeholder="sheet_number" value="<?php echo $formA_sheet_number?>">
					</div>

					<div class="vclear"></div>


					<div class="conatiner four columns vfloatleft">
						<!-- <label>Aeo_name</label><br> -->
						<input type="hidden" name="aeo_name[]" class="aeo_name" placeholder="aeo_name" value="">
					</div>
					<div class="conatiner four columns vfloatleft">
						<!-- <label>district</label><br> -->
						<input type="hidden" name="district[]" class="district" placeholder="district" value="">
					</div>
					<div class="vclear"></div>

					<div class="conatiner four columns vfloatleft">
						<!-- <label>aeo_phone_number</label><br> -->
						<input type="hidden" name="aeo_phone_number[]" class="aeo_phone_number" placeholder="aeo_phone_number" value="">
					</div>
					<div class="conatiner four columns vfloatleft">
						<!-- <label>division</label><br> -->
						<input type="hidden" name="division[]" class="division" placeholder="division" value="">
					</div>
					<div class="vclear"></div>

    		<td><?php echo $i ?></td>
        	<td>
        		<div class="rowdz">
					<input type="text" name="school_name[]" placeholder="" value="">
				</div>
        	</td>
            <td>
            	<div class="rowdz">
					<input type="text" name="school_programme_id[]" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="form_s_returned[]" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_male[]" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_female[]" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_children_total[]" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="total_enrolled_in_register[]" placeholder="" value="">
				</div>

            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_male[]" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_female[]" placeholder="" value="">
				</div>

            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_treated_total[]" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="years_2_5_male[]" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="years_2_5_female[]" placeholder="" value="">
				</div>
            </td>
            <td>
	            <div class="rowd">
					<input type="text" name="years_6_10_male[]" placeholder="" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_6_10_female[]" placeholder="" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_11_14_male[]" placeholder="" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_11_14_female[]" placeholder="" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_15_18_male[]" placeholder="" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_15_18_female[]" placeholder="" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="non_enrolled_total[]" placeholder="" value="">
				</div>
			</td>
			<!-- <td>
				<div class="row buttons">
					<input type="submit" name="submit"  value="submit">
				</div>
			</td> -->

           
        </tr>
<?php 

	}
 ?>
        <tr>
    		<td colspan="4">TOATL (sum/count each column on this sheet)</td>
        	
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_male_total" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_female_total" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_children_total_total" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="total_enrolled_in_register_total" placeholder="" value="">
				</div>

            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_male_total" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_female_total" placeholder="" value="">
				</div>

            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_treated_total_total" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="years_2_5_male_total" placeholder="" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="years_2_5_female_total" placeholder="" value="">
				</div>
            </td>
            <td>
	            <div class="rowd">
					<input type="text" name="years_6_10_male_total" placeholder="" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_6_10_female_total" placeholder="" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_11_14_male_total" placeholder="" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_11_14_female_total" placeholder="" value="">
				</div>
							</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_15_18_male_total" placeholder="" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_15_18_female_total" placeholder="" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="non_enrolled_total_total" placeholder="" value="">
				</div>
			</td>
			

			
        </tr>
        
 <tr>
 	<td>
				<!-- <input type="submit" name="submit"  value="submit"> -->
			</td>
 </tr>
	<!-- </form> -->

	<!-- <form> -->
		<span class="">
		<tr class="grand_totals">
			<!-- GRAND TOTALS -->
    		<td colspan="4">DIVISION TOTAL: Complete On Last Sheet Only</td>
        	
            <td>
            	<div class="rowd">
					
					<input type="text" name="ecd_treated_male_grand_total" placeholder="ecd_treated_male_grand_total" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_female_grand_total" placeholder="ecd_treated_female_grand_total" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_children_total_grand_total" placeholder="ecd_treated_children_total_grand_total" value="">
            </td>
            <td>
            	<div class="rowd">
				<input type="text" name="total_enrolled_in_register_grand_total" placeholder="total_enrolled_in_register_grand_total" value="">
				</div>

            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_male_grand_total" placeholder="enrolled_male_grand_total" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_female_grand_total" placeholder="enrolled_female_grand_total" value="">
				</div>

            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_treated_total_grand_total" placeholder="enrolled_treated_total_grand_total" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="years_2_5_male_grand_total" placeholder="years_2_5_male_grand_total" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="years_2_5_female_grand_total" placeholder="years_2_5_female_grand_total" value="">
				</div>
            </td>
            <td>
	            <div class="rowd">
					<input type="text" name="years_6_10_male_grand_total" placeholder="years_6_10_male_grand_total" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_6_10_female_grand_total" placeholder="years_6_10_female_grand_total" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_11_14_male_grand_total" placeholder="years_11_14_male_grand_total" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_11_14_female_grand_total" placeholder="years_11_14_female_grand_total" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_15_18_male_grand_total" placeholder="years_15_18_male_grand_total" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_15_18_female_grand_total" placeholder="years_15_18_female_grand_total" value="">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="non_enrolled_total_grand_total" placeholder="non_enrolled_total_grand_total" value="">
				</div>
			</td>
			<!-- <td>
				<div class="row buttons rowd">
					<input type="submit" name="submit" value="SAVE">
				</div>
			</td> -->

           <!--  <td>$50</td>
            <td>Bob</td>
            <td>Bob</td>
            <td>Stephen C. Cox</td>
            <td>$300</td>
            <td>$50</td>
            <td>Bob</td> -->
           
        </tr>
        </span>
        <TR>
        	<td colspan="3">
				<div class="row buttons  show_grand_totals btn-custom-small">
					Show Grand Totals
				</div>
			</td>

        	<td colspan="3">
				<div class="row buttons rowd">
					<input type="submit" name="submit" value="SAVE" class="btn-custom">
				</div>
			</td>

			<td colspan="3">
				<div class="row buttons rowd">
					<A HREF="formA.php">Rest</A>
				</div>
			</td>
		</TR>

	</form>
</div>
</body>
</html>