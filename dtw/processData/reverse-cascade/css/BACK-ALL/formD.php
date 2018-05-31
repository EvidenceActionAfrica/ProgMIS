<html>
<head>
	<title>FormD</title>
	<?php
   		 include "includes/meta-link-script.php";
   		 include "../includes/config.php";
    ?>
	<?php 
		// $records=$_GET['records'];
	$records=3;
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
			$formD_survey_id='';
		}

		if (isset($_GET['formD_deo_name'])) {
			$formD_deo_name=$_GET['formD_deo_name'];
		}else{
			$formD_deo_name="";
		}

		if (isset($_GET['formD_district'])) {
			$formD_district=$_GET['formD_district'];
		}else{
			$formD_district="";
		}

		
		if (isset($_GET['formD_deo_phone_number'])) {
			$formD_deo_phone_number=$_GET['formD_deo_phone_number'];
		}else{
			$formD_deo_phone_number="";
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
 

		// get the form $_POST
		if (isset($_POST['submit'])) {


			// this counts the number of times the have entered this post variable
			// this then becomes the for loop counter
			 $count = count($_POST['ecd_treated_male']);

			// first itterate and save the main table
			for ($i=0; $i <$count ; $i++) { 
			
			  $sheet_number = $_POST['sheet_number'][$i];
			  $survey_id = $_POST['survey_id'][$i];
			  $district = $_POST['district'][$i];
			  $deo_name = $_POST['deo_name'][$i];
			  $deo_phone_number = $_POST['deo_phone_number'][$i];
			  $division = $_POST['division'][$i];
			  $date_form_a_recieved = $_POST['date_form_a_recieved'][$i];
			  $ecd_treated_male = $_POST['ecd_treated_male'][$i];
			  $ecd_treated_female = $_POST['ecd_treated_female'][$i];
			  $ecd_treated_children_total = $_POST['ecd_treated_children_total'][$i];
			  $years_2_5_male = $_POST['years_2_5_male'][$i];
			  $years_2_5_female = $_POST['years_2_5_female'][$i];
			  $years_6_10_male = $_POST['years_6_10_male'][$i];
			  $years_6_10_female = $_POST['years_6_10_female'][$i];
			  $years_11_14_male = $_POST['years_11_14_male'][$i];
			  $years_11_14_female = $_POST['years_11_14_female'][$i];
			  $years_15_18_male = $_POST['years_15_18_male'][$i];
			  $years_15_18_female = $_POST['years_15_18_female'][$i];
			  $non_enrolled_total = $_POST['non_enrolled_total'][$i];
			  $total_enrolled_in_register = $_POST['total_enrolled_in_register'][$i];
			  $enrolled_male = $_POST['enrolled_male'][$i];
			  $enrolled_female = $_POST['enrolled_female'][$i];
			  $enrolled_treated_total = $_POST['enrolled_treated_total'][$i];
			  echo "<hr/>";
			 	
			  // $formD->create(
			  // 		  $sheet_number,
					//   $survey_id,
					//   $district,
					//   $deo_name,
					//   $deo_phone_number,
					//   $division,
					//   $date_form_a_recieved,
					//   $ecd_treated_male,
					//   $ecd_treated_female,
					//   $ecd_treated_children_total,
					//   $years_2_5_male,
					//   $years_2_5_female,
					//   $years_6_10_male,
					//   $years_6_10_female,
					//   $years_11_14_male,
					//   $years_11_14_female,
					//   $years_15_18_male,
					//   $years_15_18_female,
					//   $non_enrolled_total,
					//   $total_enrolled_in_register,
					//   $enrolled_male,
					//   $enrolled_female,
					//   $enrolled_treated_total
			  // 	);




						$query="INSERT INTO form_d VALUES (
							'$id',
							'$sheet_number',
							'$deo_name',
							'$survey_id',
							'$deo_phone_number',
							'$district',
							'$division',
							'$date_form_a_recieved',
							'$ecd_treated_male',
							'$ecd_treated_female',
							'$ecd_treated_children_total',
							'$years_2_5_male',
							'$years_2_5_female',
							'$years_6_10_male',
							'$years_6_10_female',
							'$years_11_14_male',
							'$years_11_14_female',
							'$years_15_18_male',
							'$years_15_18_female',
							'$non_enrolled_total',
							'$total_enrolled_in_register',
							'$enrolled_male',
							'$enrolled_female',
							'$enrolled_treated_total'
							)";

							
						$result=mysql_query($query) or die("<h1>Did not insert</h1><br/>".mysql_error());


					

					
					

			}	// end for loop


			// second save the totals


			// just to totals
			   $sheet_number = $_POST['sheet_number'][0];
			   $survey_id = $_POST['survey_id'][0];
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
			  // die();

			  // the sheet number and survey Id have been added
			  // $formD->haha();
			  // $formD->create_formD_totals(
			  // 	  $sheet_number,
				 //  $survey_id,
			  // 	  $ecd_treated_male_total,
				 //  $ecd_treated_female_total,
				 //  $ecd_treated_children_total_total,
				 //  $years_2_5_male_total,
				 //  $years_2_5_female_total,
				 //  $years_6_10_male_total,
				 //  $years_6_10_female_total,
				 //  $years_11_14_male_total,
				 //  $years_11_14_female_total,
				 //  $years_15_18_male_total,
				 //  $years_15_18_female_total,
				 //  $non_enrolled_total_total,
				 //  $total_enrolled_in_register_total,
				 //  $enrolled_male_total,
				 //  $enrolled_female_total,
				 //  $enrolled_treated_total_total
			  // 	);

			  $sheet_number = trim($sheet_number);
				$survey_id = trim($survey_id);
				$ecd_treated_male_grand_total = trim($ecd_treated_male_grand_total);
				$ecd_treated_female_grand_total = trim($ecd_treated_female_grand_total);
				$ecd_treated_children_total_grand_total = trim($ecd_treated_children_total_grand_total);
				$years_2_5_male_grand_total = trim($years_2_5_male_grand_total);
				$years_2_5_female_grand_total = trim($years_2_5_female_grand_total);
				$years_6_10_male_grand_total = trim($years_6_10_male_grand_total);
				$years_6_10_female_grand_total = trim($years_6_10_female_grand_total);
				$years_11_14_male_grand_total = trim($years_11_14_male_grand_total);
				$years_11_14_female_grand_total = trim($years_11_14_female_grand_total);
				$years_15_18_male_grand_total = trim($years_15_18_male_grand_total);
				$years_15_18_female_grand_total = trim($years_15_18_female_grand_total);
				$non_enrolled_total_grand_total = trim($non_enrolled_total_grand_total);
				$total_enrolled_in_register_grand_total = trim($total_enrolled_in_register_grand_total);
				$enrolled_male_grand_total = trim($enrolled_male_grand_total);
				$enrolled_female_grand_total = trim($enrolled_female_grand_total);
				$enrolled_treated_total_grand_total = trim($enrolled_treated_total_grand_total);
				$id="";
				
				
					$query=	"INSERT INTO form_d_grand_totals VALUES (
						'$id',
						'$sheet_number',
						'$survey_id',
						'$ecd_treated_male_grand_total',
						'$ecd_treated_female_grand_total',
						'$ecd_treated_children_total_grand_total',
						'$years_2_5_male_grand_total',
						'$years_2_5_female_grand_total',
						'$years_6_10_male_grand_total',
						'$years_6_10_female_grand_total',
						'$years_11_14_male_grand_total',
						'$years_11_14_female_grand_total',
						'$years_15_18_male_grand_total',
						'$years_15_18_female_grand_total',
						'$non_enrolled_total_grand_total',
						'$total_enrolled_in_register_grand_total',
						'$enrolled_male_grand_total',
						'$enrolled_female_grand_total',
						'$enrolled_treated_total_grand_total')";
					
					$result=mysql_query($query) or die("<h1>Did not insert to grand totals</h1><br/>".mysql_error());


					 echo "Success grand totals";


			  	# refresh the page and return to sheet 1
			  	header('Location: formD_view_all.php');

			  }



	 ?>
</head>
<body>

<?php include 'sideMenu.php'; ?>
	<div class="contentBody">

	<h1>Form D</h1>
	<?php //include "navigation.php"; ?>
	<div class="conatiner four columns vfloatleft big_input">
		<label class="big_label">Survey ID</label><br>
		<input type="text" id="text_survey_id" name="survey_id[]" placeholder="" value="<?php echo $formD_survey_id ?> " <?php isset($_GET['formD_survey_id']) ? readonly($_GET['formD_survey_id']) : null; ?>>
	</div>
	<div class="conatiner four columns vfloatleft big_input">

		<!-- check top code for more info -->
		<label class="big_label">Sheet Number</label><br>
		<input type="text" id="text_sheet_number"name="sheet_number[]" placeholder="" value="<?php echo $formD_sheet_number ?>" readonly>
	</div>

	<div class="vclear"></div>


	<div class="conatiner four columns vfloatleft big_input">
		<label class="big_label">DEO name</label><br>
		<input type="text" name="deo_name[]" id="text_deo_name" placeholder="" value="<?php echo $formD_deo_name ?>" <?php isset($_GET['formD_deo_name']) ? readonly($_GET['formD_deo_name']) : null; ?>>
	</div>
	<div class="conatiner four columns vfloatleft big_input">
		<label class="big_label">district</label><br>
		<input type="text" name="district[]" id="text_district" placeholder="" value="<?php echo $formD_district ?>" <?php isset($_GET['formD_district']) ? readonly($_GET['formD_district']) : null; ?> >
	</div>
	<div class="vclear"></div>

	<div class="conatiner four columns vfloatleft big_input">
		<label class="big_label">DEO phone number</label><br>
		<input type="text" name="deo_phone_number[]" id="text_deo_phone_number" placeholder="" value="<?php echo $formD_deo_phone_number ?>" <?php isset($_GET['formD_deo_phone_number']) ? readonly($_GET['formD_deo_phone_number']) : null; ?> >
	</div>
	
	<div class="vclear"></div>
	<br>
	<!-- <img src="css/images/formA.png"> -->
	<form action="" method="post">
		<table id="hor-minimalist-b" summary="Employee Pay Sheet">
    	<tr>
		<!-- <td colspan="4" rowspan="3"></td> -->
		<td colspan="18">1. Complete for each division using section 5 (Division Total) on Form A to fill the information</td>
	</tr>
	<tr>
		<td rowspan="3">
			Division Name <br> (PLease include all divisions in your <br>district)
		</td>
		<td rowspan="3">
			Date <br> Form A <br> Recieved By DEO
		</td>
		<td colspan="3">
			Enrolled ECD Children
		</td>
		<td colspan="4">
			Enrolled Primary School age children Children
		</td>
		<td colspan="9">
			Non Enrolled Children 
		</td>
	</tr>

	<tr>
		<td colspan="3">
			Totale number of children<br>  treated
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
		<td rowspan="2">Total</td>
	</tr>
	<tr>
		
		<td>M</td>
		<td>F</td>
		<td>Total</td>
		<td>Total</td>
		<td>M</td>
		<td>F</td>
		<td>Total</td>
		<td>M</td>
		<td>F</td>
		<td>M</td>
		<td>F</td>
		<td>M</td>
		<td>F</td>
		<td>M</td>
		<td>F</td>
		<!-- <td>Total <br> (c)</td> -->

	</tr>
    	<?php 
    	
    		for ($x=0; $x<$records ; $x++) { 
    			# code...
    			

    	 ?>
  
					<div class="conatiner four columns vfloatleft">
						<input type="hidden" name="survey_id[]" class="survey_id" placeholder="" value="<?php echo $formD_survey_id?>">
					</div>
					<div class="conatiner four columns vfloatleft">
						<input type="hidden" name="sheet_number[]" class="sheet_number" placeholder="" value="<?php echo $formD_sheet_number?>">
					</div>

					<div class="vclear"></div>


					<div class="conatiner four columns vfloatleft">
						<input type="hidden" name="deo_name[]" class="deo_name" placeholder="" value="">
					</div>
					<div class="conatiner four columns vfloatleft">
						<input type="hidden" name="district[]" class="district" placeholder="" value="">
					</div>
					<div class="vclear"></div>

					<div class="conatiner four columns vfloatleft">
						<input type="hidden" name="deo_phone_number[]" class="deo_phone_number" placeholder="" value="">
					</div>
					
					<div class="vclear"></div>

    		
        	<td>
        		<div class="rowdz">
					<input type="text" name="division[]" placeholder="	" value="	">
				</div>
        	</td>
            <td>
            	<div class="rowdz">
					<input type="text" name="date_form_a_recieved[]" placeholder="	" value="">
				</div>
            </td>
           
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_male[]" placeholder="	" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_female[]" placeholder="	" value="">
				</div>
            </td>
            <td>
            	<div class="rowd">
					<input type="text" name="ecd_treated_children_total[]" placeholder="	" value="">
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
		
           
        </tr>

       
<?php 

	}
 ?>
        <tr>
    		<td colspan="2">TOATL (sum/count each column on this sheet)</td>
        	
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
		
        </span>
        <TR>
        	

        	<td colspan="3">
				<div class="row buttons rowd">
					<input type="submit" name="submit" value="SAVE" class="btn-custom">
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


