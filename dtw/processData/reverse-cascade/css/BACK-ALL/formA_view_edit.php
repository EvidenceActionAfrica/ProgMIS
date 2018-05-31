<html>
<head>
	<title>Form A Edit</title>
	<?php include"header_links.php"; 
			include "dbcon.php";
				 ?>

	<?php 

		$id=$_GET['id'];

		//$data=$GetFormData->getFormAById($id);

		$sql="SELECT * FROM form_a WHERE id='$id'";
		$query=mysql_query($sql)or die(mysql_error());

		$data=array();
		while ($row=mysql_fetch_array($query)) {
			$data[]=array(
					'id'=>$row['id'],
					'sheet_number' =>$row['sheet_number'],
					'survey_id' =>$row['survey_id'],
					'school_name' =>$row['school_name'],
					'district' =>$row['district'],
					'division' =>$row['division'],
					'form_s_returned' =>$row['form_s_returned'],
					'ecd_treated_male' =>$row['ecd_treated_male'],
					'ecd_treated_female' =>$row['ecd_treated_female'],
					'ecd_treated_children_total' =>$row['ecd_treated_children_total'],
					'years_2_5_male' =>$row['years_2_5_male'],
					'years_2_5_female' =>$row['years_2_5_female'],
					'years_6_10_male' =>$row['years_6_10_male'],
					'years_6_10_female' =>$row['years_6_10_female'],
					'years_11_14_male' =>$row['years_11_14_male'],
					'years_11_14_female' =>$row['years_11_14_female'],
					'years_15_18_male' =>$row['years_15_18_male'],
					'years_15_18_female' =>$row['years_15_18_female'],
					'non_enrolled_total' =>$row['non_enrolled_total'],
					'total_enrolled_in_register' =>$row['total_enrolled_in_register'],
					'enrolled_male' =>$row['enrolled_male'],
					'enrolled_female' =>$row['enrolled_female'],
					'enrolled_treated_total' =>$row['enrolled_treated_total'],
					'aeo_name' =>$row['aeo_name'],
					'aeo_phone_number' =>$row['aeo_phone_number'],
					'school_programme_id' =>$row['school_programme_id']
				);
		}

		if (isset($_POST['forma_update'])) {
			
			// $sheet_number = $_POST['sheet_number'];
			//   $survey_id = $_POST['survey_id'];
			  $school_name = $_POST['school_name'];
			  $district = $_POST['district'];
			  $division = $_POST['division'];
			  $form_s_returned = $_POST['form_s_returned'];
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
			  $aeo_name = $_POST['aeo_name'];
			  $aeo_phone_number = $_POST['aeo_phone_number'];
			  $school_programme_id = $_POST['school_programme_id'];


			  // $form->update($id,
			 
					// $school_name,
					
					// $form_s_returned,
					// $ecd_treated_male,
					// $ecd_treated_female,
					// $ecd_treated_children_total,
					// $years_2_5_male,
					// $years_2_5_female,
					// $years_6_10_male,
					// $years_6_10_female,
					// $years_11_14_male,
					// $years_11_14_female,
					// $years_15_18_male,
					// $years_15_18_female,
					// $non_enrolled_total,
					// $total_enrolled_in_register,
					// $enrolled_male,
					// $enrolled_female,
					// $enrolled_treated_total,
					
					// $school_programme_id
			  // 	);

			  $id;
					$school_name=mysql_real_escape_string(htmlentities($school_name));
					$form_s_returned=mysql_real_escape_string(htmlentities($form_s_returned));
					$ecd_treated_male=mysql_real_escape_string(htmlentities($ecd_treated_male));
					$ecd_treated_female=mysql_real_escape_string(htmlentities($ecd_treated_female));
					$ecd_treated_children_total=mysql_real_escape_string(htmlentities($ecd_treated_children_total));
					$years_2_5_male=mysql_real_escape_string(htmlentities($years_2_5_male));
					$years_2_5_female=mysql_real_escape_string(htmlentities($years_2_5_female));
					$years_6_10_male=mysql_real_escape_string(htmlentities($years_6_10_male));
					$years_6_10_female=mysql_real_escape_string(htmlentities($years_6_10_female));
					$years_11_14_male=mysql_real_escape_string(htmlentities($years_11_14_male));
					$years_11_14_female=mysql_real_escape_string(htmlentities($years_11_14_female));
					$years_15_18_male=mysql_real_escape_string(htmlentities($years_15_18_male));
					$years_15_18_female=mysql_real_escape_string(htmlentities($years_15_18_female));
					$non_enrolled_total=mysql_real_escape_string(htmlentities($non_enrolled_total));
					$total_enrolled_in_register=mysql_real_escape_string(htmlentities($total_enrolled_in_register));
					$enrolled_male=mysql_real_escape_string(htmlentities($enrolled_male));
					$enrolled_female=mysql_real_escape_string(htmlentities($enrolled_female));
					$enrolled_treated_total=mysql_real_escape_string(htmlentities($enrolled_treated_total));
					$school_programme_id=mysql_real_escape_string(htmlentities($school_programme_id));
			
				
					
					if(!mysql_query("UPDATE form_a SET
						id	 					 ='$id',
						school_name	 			 ='$school_name',
						form_s_returned			 ='$form_s_returned',
						ecd_treated_male	     ='$ecd_treated_male',
						ecd_treated_female		     ='$ecd_treated_female',
						ecd_treated_children_total	 ='$ecd_treated_children_total',
						years_2_5_male	 			 ='$years_2_5_male',
						years_2_5_female			 ='$years_2_5_female',
						years_6_10_male			 ='$years_6_10_male',
						years_6_10_female			 ='$years_6_10_female',
						years_11_14_male			 ='$years_11_14_male',
						years_11_14_female			 ='$years_11_14_female',
						years_15_18_male			 ='$years_15_18_male',
						years_15_18_female			 ='$years_15_18_female',
						non_enrolled_total			 ='$non_enrolled_total',
						total_enrolled_in_register	 ='$total_enrolled_in_register',
						enrolled_male				 ='$enrolled_male',
						enrolled_female			 ='$enrolled_female',
						enrolled_treated_total		 ='$enrolled_treated_total',
						school_programme_id	     ='$school_programme_id'

						WHERE id='$id'"))
					{
						echo 'Did not insert <br/>'.die(mysql_error());
					}

			  header("Location:formA_update.php");
	}


	 ?>
</head>
<body>

	<?php include 'sideMenu.php'; ?>
	<!--<?php include 'includes/menuLeftBar.php'; ?>-->
	<div class="contentBody">
		<div class="form-title">
			<h1>Edit Form A</h1>
		</div>
		<form action="" method="post">
		<table id="hor-minimalist-b" summary="Employee Pay Sheet">
    
    <tbody>
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

		<td><?php echo $data[0]['id'] ?></td>
    	<td>
    		<div class="rowdz">
				<!-- <input type="text" name="school_name" placeholder="school_name" value="school_name"> -->
				
				<input type="text" name="school_name" placeholder="school_name" value="<?php echo $data[0]['school_name']?>">
			</div>
    	</td>
        <td>
        	<div class="rowdz">
				<!-- <input type="text" name="school_programme_id" placeholder="school_programme_id" value="school_programme_id"> -->
				
				<input type="text" name="school_programme_id" placeholder="school_programme_id" value="<?php echo $data[0]['school_programme_id']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="form_s_returned" placeholder="form_s_returned" value="form_s_returned"> -->
				
				<input type="text" name="form_s_returned" placeholder="form_s_returned" value="<?php echo $data[0]['form_s_returned']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="ecd_treated_male" placeholder="ecd_treated_male" value="ecd_treated_male"> -->
				
				<input type="text" name="ecd_treated_male" placeholder="ecd_treated_male" value="<?php echo $data[0]['ecd_treated_male']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="ecd_treated_female" placeholder="ecd_treated_female" value="ecd_treated_female"> -->
				
				<input type="text" name="ecd_treated_female" placeholder="ecd_treated_female" value="<?php echo $data[0]['ecd_treated_female']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="ecd_treated_children_total" placeholder="ecd_treated_children_total" value="ecd_treated_children_total"> -->
				
				<input type="text" name="ecd_treated_children_total" placeholder="ecd_treated_children_total" value="<?php echo $data[0]['ecd_treated_children_total']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="total_enrolled_in_register" placeholder="total_enrolled_in_register" value="total_enrolled_in_register"> -->
				
				<input type="text" name="total_enrolled_in_register" placeholder="total_enrolled_in_register" value="<?php echo $data[0]['total_enrolled_in_register']?>">
			</div>

        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="enrolled_male" placeholder="enrolled_male" value="enrolled_male"> -->
				
				<input type="text" name="enrolled_male" placeholder="enrolled_male" value="<?php echo $data[0]['enrolled_male']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="enrolled_female" placeholder="enrolled_female" value="enrolled_female"> -->
				
				<input type="text" name="enrolled_female" placeholder="enrolled_female" value="<?php echo $data[0]['enrolled_female']?>">
			</div>

        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="enrolled_treated_total" placeholder="enrolled_treated_total" value="enrolled_treated_total"> -->
				
				<input type="text" name="enrolled_treated_total" placeholder="enrolled_treated_total" value="<?php echo $data[0]['enrolled_treated_total']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="years_2_5_male" placeholder="years_2_5_male" value="years_2_5_male"> -->
				
				<input type="text" name="years_2_5_male" placeholder="years_2_5_male" value="<?php echo $data[0]['years_2_5_male']?>">
			</div>
        </td>
        <td>
        	<div class="rowd">
				<!-- <input type="text" name="years_2_5_female" placeholder="years_2_5_female" value="years_2_5_female"> -->
				
				<input type="text" name="years_2_5_female" placeholder="years_2_5_female" value="<?php echo $data[0]['years_2_5_female']?>">
			</div>
        </td>
        <td>
            <div class="rowd">
				<!-- <input type="text" name="years_6_10_male" placeholder="years_6_10_male" value="years_6_10_male"> -->
				
				<input type="text" name="years_6_10_male" placeholder="years_6_10_male" value="<?php echo $data[0]['years_6_10_male']?>">
			</div>
		</td>
		<td>
			<div class="rowd">
				<!-- <input type="text" name="years_6_10_female" placeholder="years_6_10_female" value="years_6_10_female"> -->
				
				<input type="text" name="years_6_10_female" placeholder="years_6_10_female" value="<?php echo $data[0]['years_6_10_female']?>">
			</div>
		</td>
		<td>
			<div class="rowd">
				<!-- <input type="text" name="years_11_14_male" placeholder="years_11_14_male" value="years_11_14_male"> -->
				
				<input type="text" name="years_11_14_male" placeholder="years_11_14_male" value="<?php echo $data[0]['years_11_14_male']?>">
			</div>
		</td>
		<td>
			<div class="rowd">
				<!-- <input type="text" name="years_11_14_female" placeholder="years_11_14_female" value="years_11_14_female"> -->
				
				<input type="text" name="years_11_14_female" placeholder="years_11_14_female" value="<?php echo $data[0]['years_11_14_female']?>">
			</div>
		</td>
		<td>
			<div class="rowd">
				<!-- <input type="text" name="years_15_18_male" placeholder="years_15_18_male" value="years_15_18_male"> -->
				
				<input type="text" name="years_15_18_male" placeholder="years_15_18_male" value="<?php echo $data[0]['years_15_18_male']?>">
			</div>
		</td>
		<td>
			<div class="rowd">
				<!-- <input type="text" name="years_15_18_female" placeholder="years_15_18_female" value="years_15_18_female"> -->
				
				<input type="text" name="years_15_18_female" placeholder="years_15_18_female" value="<?php echo $data[0]['years_15_18_female']?>">
			</div>
		</td>
		<td>
			<div class="rowd">
				<!-- <input type="text" name="non_enrolled_total" placeholder="non_enrolled_total" value="non_enrolled_total"> -->
				
				<input type="text" name="non_enrolled_total" placeholder="non_enrolled_total" value="<?php echo $data[0]['non_enrolled_total']?>">
			</div>
		</td>
		<td>
			<div class="row buttons rowd">
					<input type="submit" name="forma_update" value="SAVE">
			</div>
		</td>
		<!-- <td>
			<div class="row buttons">
				<input type="submit" name="submit"  value="submit">
			</div>
		</td> -->

	<!-- </div> -->
</tr>

</form>

	</div>

</body>
</html>