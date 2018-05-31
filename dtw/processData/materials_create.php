<style>
	*{
		margin:0;
		padding:0;
	}
	textarea{
		width:200px;
	}
	label{
		font-weight:bold;
		margin:0px;
		padding:0px;
	}
	.materialCreate select{
		width:90%;
		margin:0;
		padding:0;
	}
</style>
<div class="materialCreate">
<?php
		$materials=isset($_POST['materials'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['materials']):'';
		$materials_abbv=isset($_POST['materials_abbv'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['materials_abbv']):'';
		$formula=isset($_POST['formula'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['formula']):'';
		$formula_desc=isset($_POST['formula_desc'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['formula_desc']):'';
		$material_description=isset($_POST['material_description'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['material_description']):'';
		$materials_category=isset($_POST['materials_category'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['materials_category']):'';
		$packet=isset($_POST['packet'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['packet']):'';
		$packet_desc=isset($_POST['packet_desc'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['packet_desc']):'';
		$training_box=isset($_POST['training_box'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['training_box']):'';
		$training_box_desc=isset($_POST['training_box_desc'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['training_box_desc']):'';
		$var1=isset($_POST['var1'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['var1'])):0;
		$var2=isset($_POST['var2'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['var2'])):0;
		$var3=isset($_POST['var3'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['var3'])):0;
		$var4=isset($_POST['var4'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['var4'])):0;
		$var5=isset($_POST['var5'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['var5'])):0;
		$perform_mround=isset($_POST['perform_mround'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['perform_mround'])):0;
		$packaged=isset($_POST['packaged'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['packaged'])):0;
		
		if(isset($_POST['createMaterial']) ){
		//The Material Has Passed the Formula Test And the record can be saved into the system
		$materials=isset($_POST['materials'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['materials']):'undefined-error';
		$materials_abbv=isset($_POST['materials_abbv'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['materials_abbv']):'undefined-error';
		$formula=isset($_POST['formula'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['formula']):'undefined-error';
		$formula_desc=isset($_POST['formula_desc'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['formula_desc']):'undefined-error';
		$material_description=isset($_POST['material_description'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['material_description']):'undefined-error';
		$materials_category=isset($_POST['materials_category'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['materials_category']):'';
		
		$packet=isset($_POST['packet'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['packet']):'undefined-error';
		$packet_desc=isset($_POST['packet_desc'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['packet_desc']):'undefined-error';
		$training_box=isset($_POST['training_box'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['training_box']):'undefined-error';
		$extra=isset($_POST['extra'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['extra']):0;
		$training_box_desc=isset($_POST['training_box_desc'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['training_box_desc']):'undefined-error';
		$extra_materials=isset($_POST['extra_materials'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['extra_materials'])):0;
		$var1=isset($_POST['var1'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['var1'])):0;
		$var2=isset($_POST['var2'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['var2'])):0;
		$var3=isset($_POST['var3'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['var3'])):0;
		$var4=isset($_POST['var4'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['var4'])):0;
		$var5=isset($_POST['var5'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['var5'])):0;
		$perform_mround=isset($_POST['perform_mround'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['perform_mround'])):0;
		$packaged=isset($_POST['packaged'])?floatval(mysqli_real_escape_string($db_mysqli_connection,$_POST['packaged'])):0;
		//Get The Preset Descriptions of the packet and training boxes

		$sql='SELECT * from packet_category WHERE packet="'.$packet.'"';
		$packetResult=mysqli_query($db_mysqli_connection,$sql);
		while($packetRow=mysqli_fetch_assoc($packetResult)){
			$packet_desc=$packetRow['packet_desc'];
		}
		 mysqli_free_result($packetResult);
		//Get The Preset Descriptions of the packet and training boxes

		$sql='SELECT * from training_box_categories WHERE acronymn="'.$training_box.'"';
		$tbResult=mysqli_query($db_mysqli_connection,$sql);
		while($tbRow=mysqli_fetch_assoc($tbResult)){
			$training_box_desc=$tbRow['name'];
		}
		 mysqli_free_result($tbResult);

		
		$formula=isset($_POST['formula'])?mysqli_real_escape_string($db_mysqli_connection,$_POST['formula']):null;
		//DEFAULT VARIABLES TO BE USED THROUGHTOUT
		//Lets test with 5 random districts
		$sql='SELECT * from districts';
		$result=mysqli_query($db_mysqli_connection,$sql);
		$numDistricts=mysqli_affected_rows($db_mysqli_connection);
		 mysqli_free_result($result);
		$i=5;
		$districtArray=array('Bungoma');
		while($i>0){
		$sql='SELECT * from districts WHERE id='.rand(1,$numDistricts);
		$result=mysqli_query($db_mysqli_connection,$sql);
		while($dbRow=mysqli_fetch_assoc($result)){
			array_push($districtArray,$dbRow['district_name']);
		}
		mysqli_free_result($result);
			--$i;
		}
		

		foreach ($districtArray as $key => $value) {

		 $district_name=$value;

			$sql = "SELECT * from divisions where district_name='" . $district_name . "'";
			$resultX = mysqli_query($db_mysqli_connection,$sql);
			$no_of_divisions = mysqli_affected_rows($db_mysqli_connection);
			mysqli_free_result($resultX);
			

			  $result1 = mysqli_query($db_mysqli_connection,"SELECT COUNT(school_name) FROM schools WHERE district_name='$district_name' AND (closed='No' OR closed='NO' OR closed='no') AND treatment_type='STH' ");
              while ($row1 = mysqli_fetch_assoc($result1)) {
                  $sth_schools = $row1['COUNT(school_name)'];
              }
              mysqli_free_result($result1);
              $result2 = mysqli_query($db_mysqli_connection,"SELECT COUNT(school_name) FROM schools WHERE district_name='$district_name' AND (closed='No' OR closed='NO' OR closed='no') AND treatment_type!='STH'");
              while ($row2 = mysqli_fetch_assoc($result2)) {
                  $schisto_schools = $row2['COUNT(school_name)'];
              }
              mysqli_free_result($result2);
              $result3 = mysqli_query($db_mysqli_connection,"SELECT COUNT(school_id) FROM schools WHERE district_name='$district_name' AND (closed='No' OR closed='NO' OR closed='no')");
              while ($row3 = mysqli_fetch_assoc($result3)) {
                  $total_schools = $row3['COUNT(school_id)'];
              }

			mysqli_free_result($result3);
			$tts_sessions =ceil($total_schools/20);

			$sql = "SELECT * FROM materials_officials_assumptions WHERE district_name='$district_name'";
			$result4 = mysqli_query($db_mysqli_connection,$sql) or die(mysqli_error($db_mysqli_connection));

			while ($row4 = mysqli_fetch_assoc($result4)) {
			  $dist_moe_officials = $row4['district_education_contacts'];
			  $div_moe_officials = $row4['division_education_contacts'];
			 
			}
			mysqli_free_result($result4);
			$result5 = mysqli_query($db_mysqli_connection,"SELECT * FROM materials_officials_assumptions WHERE district_name='$district_name'");
			while ($row5 = mysqli_fetch_assoc($result5)) {
			  $dist_moh_officials = $row5['district_health_contacts'];
			  $div_moh_officials = $row5['division_health_contacts'];
			}
			mysqli_free_result($result5);
			$result6 = mysqli_query($db_mysqli_connection,"SELECT * FROM materials_officials_assumptions WHERE district_name='$district_name'") or die(mysqli_error($db_mysqli_connection));
			while ($row6 = mysqli_fetch_assoc($result6)) {
			  $mts = $row6["master_trainers"];
			}
			mysqli_free_result($result6);
			$result7 = mysqli_query($db_mysqli_connection,"SELECT COUNT(district_name) FROM a_bysch WHERE district_name='$district_name' AND ap_attached='Yes'");
			while ($row7 = mysqli_fetch_assoc($result7)) {
			  $schisto_district = $row7['COUNT(district_name)'];
			}
			mysqli_free_result($result7);
          //Make the variable numbers actual numbers
			//echo $formula."<br/>";
			//Assign XE# to represent closing bracket for the value turned variable below(This is a countermeasure i found neccessary later on)
			//A string replace will happen for all variables since the are known

			//The Vars extend from var1 to var5
			$formula1=str_replace('$var1','$var1XE#',$formula);
			$formula1=str_replace('$var2','$var2XE#',$formula1);
			$formula1=str_replace('$var3','$var3XE#',$formula1);
			$formula1=str_replace('$var4','$var4XE#',$formula1);
			$formula1=str_replace('$var5','$var5XE#',$formula1);

			// Default Variables
			$formula1=str_replace('$no_of_divisions','$no_of_divisionsXE#',$formula1);
			$formula1=str_replace('$total_schools','$total_schoolsXE#',$formula1);
			$formula1=str_replace('$sth_schools','$sth_schoolsXE#',$formula1);
			$formula1=str_replace('$schisto_schools','$schisto_schoolsXE#',$formula1);
			$formula1=str_replace('$mts','$mtsXE#',$formula1);
			$formula1=str_replace('$tts_sessions','$tts_sessionsXE#',$formula1);
			$formula1=str_replace('$schisto_district','$schisto_districtXE#',$formula1);
			// Officials
			$formula1=str_replace('$dist_moe_officials','$dist_moe_officialsXE#',$formula1);
			$formula1=str_replace('$div_moe_officials','$div_moe_officialsXE#',$formula1);
			$formula1=str_replace('$dist_moh_officials','$dist_moh_officialsXE#',$formula1);
			$formula1=str_replace('$div_moh_officials','$div_moh_officialsXE#',$formula1);
   
            //Replace all the $ with ${
			  
			$var=str_replace('$','${',$formula1);
            $var=str_replace('XE#','}',$var);

           // echo $var;
            // exit(); 
              //End of extraction




              //Turning the data into php code for processing

             $var = @eval("return ${var};");
            	
            // echo $var.'<br/>';
            // exit();
              //End of extracting php code from the db for processing


               //If It Has Decimal Place
              if (strpos( $var, '.' ) === false ) {
                $var=$var;
              }else{
              	$var=ceil($var);
              } 

		

		}
	if(is_numeric($var)){
				
		
			  //We Must Ensure that the abbreviation is unique
			  
			 $sql='SELECT * from materials_desc WHERE materials_abbv="'.$materials_abbv.'"';
			 $resultAbbv=mysqli_query($db_mysqli_connection,$sql);
			 $numRows=mysqli_affected_rows($db_mysqli_connection);
			 	if($numRows==0){
					$sql='INSERT INTO `materials_desc`(`packaged`,`materials`, `materials_abbv`, `formula`, `formula_desc`, `material_description`, `packet`, `packet_desc`, `material_category`, `training_box`, `training_box_desc`, `var1`, `var2`, `var3`, `var4`, `var5`,`perform_mround`)';
					$sql.=" VALUES ('$packaged','$materials','$materials_abbv','$formula1','$formula_desc','$material_description','$packet','$packet_desc','$materials_category','$training_box','$training_box_desc','$var1','$var2','$var3','$var4','$var5','$perform_mround')";
					mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
					$formulaScore='The Formula Passed.The material has been Added';
					$action="Creating a material";
					$description="A Material Called ".$materials." was added";
				}else{
					$formulaScore='The material\'s abreviation is not unique.';
					$action="Creating a material Failed";
					$description="A Material Called ".$materials." could not be added";
				}
			}else{
				$formulaScore='Formula Failed or the material\'s abreviation is not unique.Check both then try Again';
				$action="Creating a material Failed";
				$description="A Material Called ".$materials." could not be added";
			}
			    $ArrayData = array($M_module, $action, $description);
    			quickFuncLog($ArrayData);

		}
?>

<div>

	<h2 style='margin-left:30%;'>Create A Material </h2><br/>
		<form method='POST' role='form'>
		<h4 style='background-color:#bada66;'><?php echo $formulaScore; ?></h4>
			<h2 style='margin-left:20%;'>--------------------- SECTION 1:Basic Information ---------------------</h2>
				<div style='margin-left:25%;text-align:center;max-width:50%;font-weight:bold;margin-bottom:5%;'>
					<h4>RULES TO FOLLOW</h4>
					
					1.You can only create a material after the formula <br/>has been passed successfully by the system.<br/>
					2.The Abbreviation of the material must be unique.<br/>
					3. All Fields Must be Entered To Create A material.
				</div>
				<div style='float:left;margin-left:10%;'>
					<label for='materials'>Material</label><br/>
					<input type='text' name='materials' value='<?php echo $materials; ?>' required/>
			
					<label for='materials_abbv' class="showTooltip " data-toggle="tooltip" data-placement="left" title="This Will be used when displaying the individual Contents when scrolling through the printlist">Material Abbreviation/Alias</label><br/>
					<input type='text' name='materials_abbv' value='<?php echo $materials_abbv; ?>' required/>
				</div>
				<div style='float:left;margin-left:10%;'>
					<label for='packet'>Packet</label><br/>
					<select name='packet' required>
						<?php
							$sql='SELECT * from packet_category';
							$resultPacket=mysqli_query($db_mysqli_connection,$sql);
							while($row=mysqli_fetch_assoc($resultPacket)){

								if($row['packet']==$packet){
								echo '<option value="'.$row["packet"].'" selected>'.$row["packet"].'</option>';
								
								}else{
								echo '<option value="'.$row["packet"].'">'.$row["packet"].'</option>';
								}
							}
							mysqli_free_result($resultPacket);

						?>
					</select>
				
					
				</div>
					
				<div style='float:left;margin-left:10%;'>
					<label for='material_description'>Material Description</label><br/>
					<textarea name='material_description' required><?php echo $material_description; ?></textarea>
				
					<label for='material_category'>Material Category</label><br/>
						<select name='materials_category' required>
						<?php
							$sql='SELECT * from packet_category';
							$resultPacket=mysqli_query($db_mysqli_connection,$sql);
							while($row=mysqli_fetch_assoc($resultPacket)){
								if($row['packet']==$materials_category){
								echo '<option value="'.$row["packet"].'" selected>'.$row["packet"].'</option>';
								
								}else{
								echo '<option value="'.$row["packet"].'">'.$row["packet"].'</option>';
								}
								
							}
							mysqli_free_result($resultPacket);
							$sql='SELECT * from training_box_categories';
							$resultPacket=mysqli_query($db_mysqli_connection,$sql);
							while($row=mysqli_fetch_assoc($resultPacket)){
								if($row['acronymn']==$training_box){
									echo '<option value="'.$row["acronymn"].'" selected>'.$row["name"].'</option>';
								
								}else{
								echo '<option value="'.$row["acronymn"].'">'.$row["name"].'</option>';
								}
							}
							mysqli_free_result($resultPacket);

						?>
					</select>
				</div>
						
				<div style='float:left;margin-left:10%;'>
					<label for='material_description'>Packaged In Groups of</label><br/>
					<input type='text' name='packaged' class='num-only' value='<?php echo $packaged;?>'/>
				
				</div>
				
				<div style='float:left;margin-left:10%;'>
					<label for='training_box'>Training Box</label><br/>
							<select name='training_box' required>

						<?php
							
							$sql='SELECT * from training_box_categories';
							$resultPacket=mysqli_query($db_mysqli_connection,$sql);
							while($row=mysqli_fetch_assoc($resultPacket)){
								if($row['acronymn']==$training_box){
									echo '<option value="'.$row["acronymn"].'" selected>'.$row["name"].'</option>';
								
								}else{
								echo '<option value="'.$row["acronymn"].'">'.$row["name"].'</option>';
								}
							}
							mysqli_free_result($resultPacket);

						?>
					</select>
				</div>
				
				<p style='clear:both;'></p>
				<h2 style='margin-left:25%;'>---------------------SECTION 2:Formula Creation---------------------</h2>
				<div style='margin-left:10%;margin-bottom:2%;width:60%;'>
					<div style='margin-left:25%;text-align:center;max-width:50%;font-weight:bold;'>
					<h4>RULES TO FOLLOW</h4>
					1.You Can only use the Built in variables allowed by the system to create the formula.<br/>
					2.You can only create a material after the formula has been passed successfully by the system.<br/>

					</div>
					<label for='formula'>Formula Bar</label>
					<textarea  style='width:70%;max-width:70%;max-height:40px;' name='formula' required><?php echo $formula; ?></textarea>
				</div>
					<div style='float:left;width:25%;'>
						<label for='var1'>Var1</label><br/>
						<input type='text' style='width:25%;' placeholder name='var1' class='num-only' value='<?php echo $var1; ?>'/>
					</div>
					<div style='float:left;width:25%;'>
						<label for='var2'>Var2</label><br/>
						<input type='text' name='var2' class='num-only' style='width:25%;' value='<?php echo $var2; ?>'/>
					</div>
					<div style='float:left;width:25%;'>
						<label for='var3'>Var3</label><br/>
						<input type='text' name='var3' class='num-only' style='width:25%;' value='<?php echo $var3; ?>'/>
					</div>
					<div style='float:left;width:25%;'>
						<label for='var4'>Var4</label><br/>
						<input type='text' name='var4' class='num-only' style='width:25%;' value='<?php echo $var4; ?>'/>
					</div>
					<div style='float:left;width:25%;'>
						<label for='var5'>Var5</label><br/>
						<input type='text' name='var5' class='num-only' style='width:25%;' value='<?php echo $var5; ?>'/>
					</div>
					<div style='float:left;width:25%;'>
						<label for='var5'>perform m_round by</label><br/>
						<input type='text' name='perform_mround' class='num-only' style='width:25%;' value='<?php echo $perform_mround; ?>'/>
					</div>
					<p style='clear:both;'></p>
						<div >
					<div style='float:left;width:50%;'>
					<h3>REFERENCE</h3>
							<h3> Default Variables</h3>
							<div>
							<p>
								<li>Divisions->$no_of_divisions</li>
								<li>Total Schools->$total_schools</li>
								<li>STH Schools->$sth_schools</li>
								<li>Schisto Schools->$schisto_schools</li>
								<li>Master Trainers->$mts</li>
								<li>Teacher Training Sessions->$tts_sessions</li>
								<li>Numbers->(Place the numbers under the variable fields and identify them like variable 1 is $var1, variable 2 as $var2 respectively)</li>
								<li>Schisto District->$schisto_district</li>
								</p>
							</div>
						
							<h3>Officials</h3>
								<div>
								<p>
								<li>Education Sub-County Officials->$dist_moe_officials</li>
								<li>Education Division Officials->$div_moe_officials</li>
								<li>Health Sub-County Officials->$dist_moh_officials</li>
								<li>Health Division Officials->$div_moh_officials</li>
								</p>
							</div>
						
							
					</div>
					<div style='float:left;width:50%;'>
						<h3>Functions</h3>
							<div>
								<p>
								<li>MROUND->MROUND('calculations','A Var Field')</li>
								</p>
							</div>
						<h3>Conditionals</h3>
						<div>
							<p><i>Instead of using:</i> if(condition){true}else{false}) <i>use</i> (condition)?true:false
								<br/>e.g $schisto_schools=0?$schisto_schools*$var1:0
							</p>
						</div>
					</div>
				</div>	

				<p style='clear:both;'></p>
				<div>
					<label for='formula_desc'>Formula Description</label>
					<textarea name='formula_desc' required><?php echo $formula_desc; ?></textarea>
				</div>
				<?php if($priv_materials_assumptions>=2){ ?>
				<div style='margin-left:50%;'>
					<input type='submit' class='btn-custom' name='createMaterial' Value='Create Material'/>
				
				<?php } ?>
			</div>
			
		</form>
</div>
</div>