<html>
<head>
	<title>FormD</title>
	<?php include"header_links.php"; ?>

	<?php 
	

		// set the loop for number of schools
		$number_of_schools=11;

		// check if the sheet number is there
		// if not st it to one
		if (isset($_GET['formD_sheet_number'])) {
			$sheet=$_GET['formD_sheet_number'];
			$formD_sheet_number=$sheet+1;
		}else{
			$formD_sheet_number="1";
		}

		// check if the survey ID is there 
		// if not dont set it
		if (isset($_GET['formD_survey_id'])) {
			$formD_survey_id=$_GET['formD_survey_id'];
		}else{
			$formD_survey_id='formD_survey_id';
		}

		if (isset($_GET['formD_deo_name'])) {
			$formD_deo_name=$_GET['formD_deo_name'];
		}else{
			$formD_deo_name="formD_deo_name";
		}

		if (isset($_GET['formD_district'])) {
			$formD_district=$_GET['formD_district'];
		}else{
			$formD_district="formD_district";
		}

		
		if (isset($_GET['formD_deo_phone_number'])) {
			$formD_deo_phone_number=$_GET['formD_deo_phone_number'];
		}else{
			$formD_deo_phone_number="formD_deo_phone_number";
		}

		function readonly($get){
			// if (isset($_GET['formD_survey_id'])  || 
			// 	isset($_GET['formD_deo_name']) || 
			// 	isset($_GET['formD_district']) || 
			// 	isset($_GET['formD_division']) || 
			// 	isset($_GET['formD_deo_phone_number'])) {
			// 	echo "readonly";
			// }
			if (isset($get)) {
				echo "readonly";
			}

			
		}


		if (isset($_POST['submit'])) {
			echo "<br>";
			echo count(!empty($_POST['ecd_treated_male']));
			echo "<br/>";
			echo"<pre>";var_dump($_POST['ecd_treated_male']);echo "</pre>";
			die();

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
			  $form->create_formD_totals(
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
			 	$form->create_formD_totals(
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
			  	header('Location: formD.php');

			  }else{

			  	// reload the page with sheet number and survey ID
			  	$newURL="formD.php?formD_sheet_number=".$sheet_number
			  			."&formD_survey_id=".$survey_id
			  			."&formD_deo_name=".$aeo_phone_number
			  			."&formD_district=".$district
			  			."&formD_division=".$division
			  			."&formD_deo_phone_number=".$aeo_phone_number
			  			;

			  	header('Location: '.$newURL);
			  }


			  	

		}



	 ?>
</head>
<body>

<div class="container">

	<?php include "navigation.php"; ?>
	<div class="conatiner four columns vfloatleft">
		<label>Survey ID</label><br>
		<input type="text" id="text_survey_id" name="survey_id[]" placeholder="survey_id" value="<?php echo $formD_survey_id ?> " <?php isset($_GET['formD_survey_id']) ? readonly($_GET['formD_survey_id']) : null; ?>>
	</div>
	<div class="conatiner four columns vfloatleft">

		<!-- check top code for more info -->
		<label>Sheet Number</label><br>
		<input type="text" id="text_sheet_number"name="sheet_number[]" placeholder="sheet_number" value="<?php echo $formD_sheet_number ?>" readonly>
	</div>

	<div class="vclear"></div>


	<div class="conatiner four columns vfloatleft">
		<label>DEO name</label><br>
		<input type="text" name="deo_name[]" id="text_aeo_name" placeholder="deo_name" value="<?php echo $formD_deo_name ?>" <?php isset($_GET['formD_deo_name']) ? readonly($_GET['formD_deo_name']) : null; ?>>
	</div>
	<div class="conatiner four columns vfloatleft">
		<label>district</label><br>
		<input type="text" name="district[]" id="text_district" placeholder="district" value="<?php echo $formD_district ?>" <?php isset($_GET['formD_district']) ? readonly($_GET['formD_district']) : null; ?> >
	</div>
	<div class="vclear"></div>

	<div class="conatiner four columns vfloatleft">
		<label>deo_phone_number</label><br>
		<input type="text" name="deo_phone_number[]" id="text_deo_phone_number" placeholder="deo_phone_number" value="<?php echo $formD_deo_phone_number ?>" <?php isset($_GET['formD_deo_phone_number']) ? readonly($_GET['formD_deo_phone_number']) : null; ?> >
	</div>
	
	<div class="vclear"></div>

	<img src="css/images/formA.png">
	<form action="" method="post">
		<table id="hor-minimalist-b" summary="Employee Pay Sheet">
    <thead>
    	<tr>
    		<!-- <th scope="col">ID</th>
        	<th scope="col">School Name in Full</th>
            <th scope="col">Programme Assigned ID</th>
            <th scope="col">Bonus</th>
            <th scope="col">M</th>
            <th scope="col">F</th>
            <th scope="col">Total<br/>(A)</th>
            <th scope="col">Total<br/>(S)</th>
            <th scope="col">M</th>
            <th scope="col">F</th>
            <th scope="col">Total<br/>(B)</th>
            <th scope="col">M</th>
            <th scope="col">F</th>
            <th scope="col">M</th>
            <th scope="col">F</th>
            <th scope="col">M</th>
            <th scope="col">F</th>
            <th scope="col">M</th>
            <th scope="col">F</th>
            <th scope="col">Total<br/>(C)</th> -->
            
        </tr>
    </thead>
    <tbody>
    	<tr id="field1">
<?php 
	//for ($i=0; $i <$number_of_schools ; $i++) { 
	
 ?> <span id="formD_rows">
					<div class="conatiner four columns vfloatleft">
						<!-- <label>Survey ID</label><br> -->
						<input type="hidden" name="survey_id[]" class="survey_id" placeholder="survey_id" value="<?php echo $formD_survey_id?>">
					</div>
					<div class="conatiner four columns vfloatleft">
						<!-- <label>Sheet Number</label><br> -->
						<input type="hidden" name="sheet_number[]" class="sheet_number" placeholder="sheet_number" value="<?php echo $formD_sheet_number?>">
					</div>

					<div class="vclear"></div>


					<div class="conatiner four columns vfloatleft">
						<!-- <label>Aeo_name</label><br> -->
						<input type="hidden" name="deo_name[]" class="deo_name" placeholder="deo_name" value="">
					</div>
					<div class="conatiner four columns vfloatleft">
						<!-- <label>district</label><br> -->
						<input type="hidden" name="district[]" class="district" placeholder="district" value="">
					</div>
					<div class="vclear"></div>

					<div class="conatiner four columns vfloatleft">
						<!-- <label>aeo_phone_number</label><br> -->
						<input type="hidden" name="deo_phone_number[]" class="deo_phone_number" placeholder="deo_phone_number" value="">
					</div>
					
					<div class="vclear"></div>

    		<td><?php echo $i=1; ?></td>
        	<td>
        		<div class="rowdz">
					<input type="text" name="division[]" placeholder="division" value="division">
				</div>
        	</td>
            <td>
            	<div class="rowdz">
					<input type="text" name="date_form_a_recieved[]" placeholder="date_form_a_recieved" value="date_form_a_recieved">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="name" placeholder="name" value="name">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_male[]" placeholder="ecd_treated_male" value="ecd_treated_male">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_female[]" placeholder="ecd_treated_female" value="ecd_treated_female">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_children_total[]" placeholder="ecd_treated_children_total" value="ecd_treated_children_total">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="total_enrolled_in_register[]" placeholder="total_enrolled_in_register" value="total_enrolled_in_register">
				</div>

            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_male[]" placeholder="enrolled_male" value="enrolled_male">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_female[]" placeholder="enrolled_female" value="enrolled_female">
				</div>

            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_treated_total[]" placeholder="enrolled_treated_total" value="enrolled_treated_total">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="years_2_5_male[]" placeholder="years_2_5_male" value="years_2_5_male">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="years_2_5_female[]" placeholder="years_2_5_female" value="years_2_5_female">
				</div>
            </td>
            <td>
	            <div class="rowd">
					<input type="text" name="years_6_10_male[]" placeholder="years_6_10_male" value="years_6_10_male">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_6_10_female[]" placeholder="years_6_10_female" value="years_6_10_female">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_11_14_male[]" placeholder="years_11_14_male" value="years_11_14_male">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_11_14_female[]" placeholder="years_11_14_female" value="years_11_14_female">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_15_18_male[]" placeholder="years_15_18_male" value="years_15_18_male">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_15_18_female[]" placeholder="years_15_18_female" value="years_15_18_female">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="non_enrolled_total[]" placeholder="non_enrolled_total" value="non_enrolled_total">
				</div>
			</td>
			<!-- <td>
				<div class="row buttons">
					<input type="submit" name="submit"  value="submit">
				</div>
			</td> -->
			<!-- <td>
				 <input onclick="addRow();" type="button" value="Add row" /> 
				<button id="b1" class="btn btn-info add-more" type="button">+</button>
			</td>
 -->
           
        </tr>
        <td>
				<!-- <input onclick="addRow();" type="button" value="Add row" /> -->
				<button id="b1" class="btn btn-info add-more" type="button">+</button>
			</td>
        </span>
<?php 

	//}
 ?>
        <tr>
    		<td colspan="4">TOATL (sum/count each column on this sheet)</td>
        	
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_male_total" placeholder="ecd_treated_male_total" value="ecd_treated_male_total">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_female_total" placeholder="ecd_treated_female_total" value="ecd_treated_female_total">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_children_total_total" placeholder="ecd_treated_children_total_total" value="ecd_treated_children_total_total">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="total_enrolled_in_register_total" placeholder="total_enrolled_in_register_total" value="total_enrolled_in_register_total">
				</div>

            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_male_total" placeholder="enrolled_male_total" value="enrolled_male_total">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_female_total" placeholder="enrolled_female_total" value="enrolled_female_total">
				</div>

            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="enrolled_treated_total_total" placeholder="enrolled_treated_total_total" value="enrolled_treated_total_total">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="years_2_5_male_total" placeholder="years_2_5_male_total" value="years_2_5_male_total">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="years_2_5_female_total" placeholder="years_2_5_female_total" value="years_2_5_female_total">
				</div>
            </td>
            <td>
	            <div class="rowd">
					<input type="text" name="years_6_10_male_total" placeholder="years_6_10_male_total" value="years_6_10_male_total">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_6_10_female_total" placeholder="years_6_10_female_total" value="years_6_10_female_total">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_11_14_male_total" placeholder="years_11_14_male_total" value="years_11_14_male_total">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_11_14_female_total" placeholder="years_11_14_female_total" value="years_11_14_female_total">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_15_18_male_total" placeholder="years_15_18_male_total" value="years_15_18_male_total">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="years_15_18_female_total" placeholder="years_15_18_female_total" value="years_15_18_female_total">
				</div>
			</td>
			<td>
				<div class="rowd">
					<input type="text" name="non_enrolled_total_total" placeholder="non_enrolled_total_total" value="non_enrolled_total_total">
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
		
        </span>
        <TR>
        	

        	<td colspan="3">
				<div class="row buttons rowd">
					<input type="submit" name="submit" value="SAVE">
				</div>
			</td>

			<td colspan="3">
				<div class="row buttons rowd">
					<A HREF="formD.php">Rest</A>
				</div>
			</td>
		</TR>

	</form>
</div>
</body>
</html>


