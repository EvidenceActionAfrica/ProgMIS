<html>
<head>
	<title>Form A Edit</title>
	<?php
   		 include "includes/meta-link-script.php";
   		 include "includes/config.php";
    ?>

	<?php 

		$id=$_GET['id'];

		// $data=$getFormD->getFormDById($id);

		$query="SELECT * FROM form_d WHERE id='$id'";

		$result=mysql_query($query) or die("<h1>COuld nit get Form D</h1><br/>".mysql_error());
		$data=array();
	    while ($row=mysql_fetch_assoc($result)) {
	    	$data[]=array(
	    			'id'=>$row['id'],
    				'survey_id'=>$row['survey_id'],
					'date_form_a_recieved'=>$row['date_form_a_recieved'],
					'ecd_treated_male'=>$row['ecd_treated_male'],
					'ecd_treated_female'=>$row['ecd_treated_female'],
					'ecd_treated_children_total'=>$row['ecd_treated_children_total'],
					'years_2_5_male'=>$row['years_2_5_male'],
					'years_2_5_female'=>$row['years_2_5_female'],
					'years_6_10_male'=>$row['years_6_10_male'],
					'years_6_10_female'=>$row['years_6_10_female'],
					'years_11_14_male'=>$row['years_11_14_male'],
					'years_11_14_female'=>$row['years_11_14_female'],
					'years_15_18_male'=>$row['years_15_18_male'],
					'years_15_18_female'=>$row['years_15_18_female'],
					'non_enrolled_total'=>$row['non_enrolled_total'],
					'total_enrolled_in_register'=>$row['total_enrolled_in_register'],
					'enrolled_male'=>$row['enrolled_male'],
					'enrolled_female'=>$row['enrolled_female'],
					'enrolled_treated_total'=>$row['enrolled_treated_total']
	    		);
	    }
	

		if (isset($_POST['formd_update'])) {
			
			  // $sheet_number = $_POST['sheet_number'];
			 $survey_id = $_POST['survey_id'];
			  // $district = $_POST['district'];
			  // $deo_name = $_POST['deo_name'];
			  // $deo_phone_number = $_POST['deo_phone_number'];
			  // $division = $_POST['division'];
			  $date_form_a_recieved = $_POST['date_form_a_recieved'];
			  $ecd_treated_male = $_POST['ecd_treated_male'];
			  $ecd_treated_female = $_POST['ecd_treated_female'];
			  $ecd_treated_children_total = $_POST['ecd_treated_children_total'];
			  $years_2_5_male = $_POST['years_2_5_male'];
			  $years_2_5_female = $_POST['years_2_5_female'];
			  $years_6_10_male = $_POST['years_6_10_male'];
			  $years_6_10_female = $_POST['years_6_10_female'];
			  $years_11_14_male = $_POST['years_11_14_male'];
			  $years_11_14_female = $_POST['years_11_14_female'];
			  $years_15_18_male = $_POST['years_15_18_male'];
			  $years_15_18_female = $_POST['years_15_18_female'];
			  $non_enrolled_total = $_POST['non_enrolled_total'];
			  $total_enrolled_in_register = $_POST['total_enrolled_in_register'];
			  $enrolled_male = $_POST['enrolled_male'];
			  $enrolled_female = $_POST['enrolled_female'];
			  $enrolled_treated_total = $_POST['enrolled_treated_total'];


			  // $formD->update($id,
					// 	$survey_id,
					// 	$date_form_a_recieved,
					// 	$ecd_treated_male,
					// 	$ecd_treated_female,
					// 	$ecd_treated_children_total,
					// 	$years_2_5_male,
					// 	$years_2_5_female,
					// 	$years_6_10_male,
					// 	$years_6_10_female,
					// 	$years_11_14_male,
					// 	$years_11_14_female,
					// 	$years_15_18_male,
					// 	$years_15_18_female,
					// 	$non_enrolled_total,
					// 	$total_enrolled_in_register,
					// 	$enrolled_male,
					// 	$enrolled_female,
					// 	$enrolled_treated_total
			  // 	);

			 		$id 							= addslashes(trim($id));
					$survey_id 						= addslashes(trim($survey_id));
					$date_form_a_recieved 			= addslashes(trim($date_form_a_recieved));
					$ecd_treated_male 				= addslashes(trim($ecd_treated_male));
					$ecd_treated_female 			= addslashes(trim($ecd_treated_female));
					$ecd_treated_children_total 	= addslashes(trim($ecd_treated_children_total));
					$years_2_5_male 				= addslashes(trim($years_2_5_male));
					$years_2_5_female 				= addslashes(trim($years_2_5_female));
					$years_6_10_male 				= addslashes(trim($years_6_10_male));
					$years_6_10_female 				= addslashes(trim($years_6_10_female));
					$years_11_14_male 				= addslashes(trim($years_11_14_male));
					$years_11_14_female 			= addslashes(trim($years_11_14_female));
					$years_15_18_male 				= addslashes(trim($years_15_18_male));
					$years_15_18_female 			= addslashes(trim($years_15_18_female));
					$non_enrolled_total 			= addslashes(trim($non_enrolled_total));
					$total_enrolled_in_register 	= addslashes(trim($total_enrolled_in_register));
					$enrolled_male 					= addslashes(trim($enrolled_male));
					$enrolled_female 				= addslashes(trim($enrolled_female));
					$enrolled_treated_total 		= addslashes(trim($enrolled_treated_total));
			
					



					$query="UPDATE form_d SET 
					     	survey_id 					= '$survey_id',
							date_form_a_recieved 		= '$date_form_a_recieved',
							ecd_treated_male 			= '$ecd_treated_male',
							ecd_treated_female 			= '$ecd_treated_female',
							ecd_treated_children_total	= '$ecd_treated_children_total',
							years_2_5_male 				= '$years_2_5_male',
							years_2_5_female 			= '$years_2_5_female',
							years_6_10_male 			= '$years_6_10_male',
							years_6_10_female 			= '$years_6_10_female',
							years_11_14_male 			= '$years_11_14_male',
							years_11_14_female 			= '$years_11_14_female',
							years_15_18_male 			= '$years_15_18_male',
							years_15_18_female 			= '$years_15_18_female',
							non_enrolled_total 			= '$non_enrolled_total',
							total_enrolled_in_register 	= '$total_enrolled_in_register',
							enrolled_male 				= '$enrolled_male',
							enrolled_female 			= '$enrolled_female',
							enrolled_treated_total 		= '$enrolled_treated_total'
							WHERE id ='$id'   	";

					 $result=mysql_query($query) or die("<h1>Did not update</h1><br/>".mysql_error());
					     // return $result = $sth->fetch(PDO::FETCH_ASSOC);

					     header("Location:formD_edit.php?id=".$id."&status=updated");

					
			  // header("location:formD_view.php");
	}


	 ?>
</head>
<body>

	<?php include 'sideMenu.php'; ?>
	<div class="contentBody">
			<div class="form-title">
			<h1>Edit Form D</h1>
		</div>
		<form action="" method="post">
		<table id="hor-minimalist-b" summary="Employee Pay Sheet">
   
    <tbody>
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
    	<tr>
			<div class="conatiner four columns vfloatleft">
					<!-- <label>Survey ID</label><br> -->
					<input type="hidden" name="survey_id[]" class="survey_" placeholder="survey_id" value="<?php echo $data['formA_survey_id']?>">
				</div>
				<div class="conatiner four columns vfloatleft">
					<!-- <label>Sheet Number</label><br> -->
					<input type="hidden" name="sheet_number[]" class="sheet_numb" placeholder="sheet_number" value="<?php echo $data['formA_sheet_number']?>">
				</div>

				<div class="vclear"></div>


				<div class="conatiner four columns vfloatleft">
					<!-- <label>Aeo_name</label><br> -->
					<input type="hidden" name="aeo_name[]" class="aeo_na" placeholder="aeo_name" value="">
				</div>
				<div class="conatiner four columns vfloatleft">
					<!-- <label>district</label><br> -->
					<input type="hidden" name="district[]" class="distri" placeholder="district" value="">
				</div>
				<div class="vclear"></div>

				<div class="conatiner four columns vfloatleft">
					<!-- <label>aeo_phone_number</label><br> -->
					<input type="hidden" name="aeo_phone_number[]" class="aeo_phone_numb" placeholder="aeo_phone_number" value="">
				</div>
				<div class="conatiner four columns vfloatleft">
					<!-- <label>division</label><br> -->
					<input type="hidden" name="division[]" class="divisi" placeholder="division" value="">
				</div>
				<div class="vclear"></div>

		<!-- <td><?php echo $data['id'] ?></td> -->
    	<td>
    		<div class="rowdz">
				<!-- <input type="text" name="school_name" placeholder="school_name" value="school_name"> -->
				
				<input type="text" name="division" placeholder="division" value="<?php echo $data[0]['division']?>">
			</div>
    	</td>
        <td>
        	<div class="rowdz">
				<!-- <input type="text" name="school_programme_id" placeholder="school_programme_id" value="school_programme_id"> -->
				
				<input type="text" name="date_form_a_recieved" placeholder="date_form_a_recieved" value="<?php echo $data['date_form_a_recieved']?>">
			</div>
        </td>
       
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="ecd_treated_male" placeholder="ecd_treated_male" value="ecd_treated_male"> -->
				
				<input type="text" name="ecd_treated_male" placeholder="ecd_treated_male" value="<?php echo $data['ecd_treated_male']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="ecd_treated_female" placeholder="ecd_treated_female" value="ecd_treated_female"> -->
				
				<input type="text" name="ecd_treated_female" placeholder="ecd_treated_female" value="<?php echo $data['ecd_treated_female']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="ecd_treated_children_total" placeholder="ecd_treated_children_total" value="ecd_treated_children_total"> -->
				
				<input type="text" name="ecd_treated_children_total" placeholder="ecd_treated_children_total" value="<?php echo $data['ecd_treated_children_total']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="total_enrolled_in_register" placeholder="total_enrolled_in_register" value="total_enrolled_in_register"> -->
				
				<input type="text" name="total_enrolled_in_register" placeholder="total_enrolled_in_register" value="<?php echo $data['total_enrolled_in_register']?>">
			</div>

        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="enrolled_male" placeholder="enrolled_male" value="enrolled_male"> -->
				
				<input type="text" name="enrolled_male" placeholder="enrolled_male" value="<?php echo $data['enrolled_male']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="enrolled_female" placeholder="enrolled_female" value="enrolled_female"> -->
				
				<input type="text" name="enrolled_female" placeholder="enrolled_female" value="<?php echo $data['enrolled_female']?>">
			</div>

        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="enrolled_treated_total" placeholder="enrolled_treated_total" value="enrolled_treated_total"> -->
				
				<input type="text" name="enrolled_treated_total" placeholder="enrolled_treated_total" value="<?php echo $data['enrolled_treated_total']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="years_2_5_male" placeholder="years_2_5_male" value="years_2_5_male"> -->
				
				<input type="text" name="years_2_5_male" placeholder="years_2_5_male" value="<?php echo $data['years_2_5_male']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="years_2_5_female" placeholder="years_2_5_female" value="years_2_5_female"> -->
				
				<input type="text" name="years_2_5_female" placeholder="years_2_5_female" value="<?php echo $data['years_2_5_female']?>">
			</div>
        </td>
        <td>
            <div class="rowd">
				<!-- <input type="text" name="years_6_10_male" placeholder="years_6_10_male" value="years_6_10_male"> -->
				
				<input type="text" name="years_6_10_male" placeholder="years_6_10_male" value="<?php echo $data['years_6_10_male']?>">
			</div>
		</td>
		<td>
			<div class="rowd">
				<!-- <input type="text" name="years_6_10_female" placeholder="years_6_10_female" value="years_6_10_female"> -->
				
				<input type="text" name="years_6_10_female" placeholder="years_6_10_female" value="<?php echo $data['years_6_10_female']?>">
			</div>
		</td>
		<td>
			<div class="rowd">
				<!-- <input type="text" name="years_11_14_male" placeholder="years_11_14_male" value="years_11_14_male"> -->
				
				<input type="text" name="years_11_14_male" placeholder="years_11_14_male" value="<?php echo $data['years_11_14_male']?>">
			</div>
		</td>
		<td>
			<div class="rowd">
				<!-- <input type="text" name="years_11_14_female" placeholder="years_11_14_female" value="years_11_14_female"> -->
				
				<input type="text" name="years_11_14_female" placeholder="years_11_14_female" value="<?php echo $data['years_11_14_female']?>">
			</div>
		</td>
		<td>
			<div class="rowd">
				<!-- <input type="text" name="years_15_18_male" placeholder="years_15_18_male" value="years_15_18_male"> -->
				
				<input type="text" name="years_15_18_male" placeholder="years_15_18_male" value="<?php echo $data['years_15_18_male']?>">
			</div>
		</td>
		<td>
			<div class="rowd">
				<!-- <input type="text" name="years_15_18_female" placeholder="years_15_18_female" value="years_15_18_female"> -->
				
				<input type="text" name="years_15_18_female" placeholder="years_15_18_female" value="<?php echo $data['years_15_18_female']?>">
			</div>
		</td>
		<td>
			<div class="rowd">
				<!-- <input type="text" name="non_enrolled_total" placeholder="non_enrolled_total" value="non_enrolled_total"> -->
				
				<input type="text" name="non_enrolled_total" placeholder="non_enrolled_total" value="<?php echo $data['non_enrolled_total']?>">
			</div>
		</td>
		
		<!-- <td>
			<div class="row buttons">
				<input type="submit" name="submit"  value="submit">
			</div>
		</td> -->

	<!-- </div> -->
	</tr>
		<tr>
			<td>
			<div class="row buttons rowd">
					<input type="submit" name="formd_update" class="btn-custom"value="SAVE">
			</div>
			</td>
		</tr>

</form>

	</div>

</body>
</html>