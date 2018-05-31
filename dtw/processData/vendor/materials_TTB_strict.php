<?php
$priv_materials_edit=4;
?>

	<form method="post" >
                            	<div style="margin-left:25%;">

                            		<h2>Teacher Training Box</h2>
			                                <img style="width:10%;" src="../images/gklogo.png"/>
												<b>Kenya National School-Based Deworming Programme</b>
			                                <img style="width:10%;" src="../images/kwaAfya.png"/>
			                              <hr style="font-weight:bolder;color:#EEEE;"/>
			               			</div>
							<div class="row">
									<div style="margin-left:40%;">
		<label>County<?php echo ": ".$county; ?></label>   &nbsp;		<label>District<?php echo ": ".$district; ?></label>
									
								</div>
							</div>





			                  					<input type="submit" style="display:none;" id="teacherSave" name="teacherSave" value="save" />
			                  					<br/>
			             
					         
               <?php
							if(isset($county) && isset($district)){
								/*
					?>
			                  
			                  	<h3>Full Content</h3>

 							</div> 

				<table class="table table-bordered table-condensed table-striped table-hover">
					
					<?php
					$count=1;
					//$sql="select * from materials_desc where packet='Master Trainers Packet' or packet='DC Packet'";
					//$sql.=" or packet='DMOH Packet' or packet='District Training Booklet'";
					//$sql.=" or materials= 'Teacher Training Booklet' or packet=''";

					//This logic will only filter out everything but the teacher training variables

					//Teacher Training


					//find out the number of schools in the districts selected
					$sql="select * from a_bysch where county_name='$county' AND district_name='$district'";

					$resultE=mysql_query($sql);
					$noSch=mysql_affected_rows();

				//	echo $noSch."<h1>Help</h1>";
					//Find out no of schisto schools
					//ap_attached column logic:if Yes it is a schisto school else sth

					$sql="select * from a_bysch where county_name='$county' AND district_name='$district' AND (ap_attached='YES' or ap_attached='Yes')";
					
					$resultE=mysql_query($sql);
					$noSchisto=mysql_affected_rows();
					//echo $noSchisto." schisto schools<br/>";
					//finding out the no of sth schools
					//ap_attached column logic:if Yes it is a schisto school else sth
					
					
					$sql="select * from a_bysch where county_name='$county' and district_name='$district' AND (ap_attached='NO' or ap_attached='No')";
					//echo $sql;
					$resultE=mysql_query($sql);
					$noSth=mysql_affected_rows();


					//echo $noSth." sth schools";


/*
						$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other' AND materials='Teacher Training Booklet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$ttb=((($row["var1"]*$noSch)+($row["var2"]))+($row["var3"]+$row["var4"]))*$percent;
						$ttb=ceil($ttb+$row["extra"]);

					}

					*/


	//This Logic is  quite simple. We are extracting the serialized array from the db from the column assumptions
	//now the array is an array within an array.The arrangements of the elements are as follows
	//0.Materials 1.Packet 2.var1  3.var2  4.var3  5.var4 6.var5 7.extra
	//These assumptions ALWAYS  belong to the active printlist

            $sql="select assumptions from materials_printlist_history where status=1";
            $resultA=mysql_query($sql);
            $materialDesc=array();
            while($key=mysql_fetch_array($resultA)){
             $materialDesc=unserialize($key["assumptions"]);

            }
          
            foreach ($materialDesc as $key => $value) {
		           

			//	echo $key." ".$value[0].$value[1].$value[3].$value[4]."<br/>";	


            	switch($value[0]){



            		case "Teacher Training Booklet":

				$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$ttb=((($value[2]*$noSch)+($value[3]))+($value[4]+$value[5]))*$percent;
						$ttb=ceil($ttb+$value[7]);

            		break;


            		case "Form E Packet (20 forms each)":

            			$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formE=((($value[3]*$noSch))+($value[4]+$value[5]))*$percent;
						$formE=ceil($formE+$value[7]);
						$formE=ceil($value[2]*$formE);


            		break;
            		

            		case "Form N Packet (15 forms each)":

            		$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formN=((($value[3]*$noSch))+($value[4]+$value[5]))*$percent;
						$formN=ceil($formN+$value[7]);
						$formN=ceil($value[2]*$formN);

            		break;

          		case "Form S Packet (5 forms each)":


						$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formS=((($value[3]*$noSth))+($value[4]+$value[5]))*$percent;
						$formS=ceil($formS+$value[7]);
						$formS=ceil($value[2]*$formS);


            		break;


            		case "Form E-P Packet (20 forms each)":


						$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formEp=((($value[3]*$noSchisto))+($value[4]+$value[5]))*$percent;
						$formEp=ceil($formEp+$value[7]);
						$formEp=ceil($value[2]*$formEp);



            		break;


            		case "Form N-P Packet (15 forms each)":
					$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formNp=((($value[3]*$noSchisto))+($value[4]+$value[5]))*$percent;
						$formNp=ceil($formNp+$value[7]);
						$formNp=ceil($value[2]*$formNp);


            		break;

            		case "Form S-P Packet (5 forms each)":


						$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formSp=((($value[3]*$noSchisto))+($value[4]+$value[5]))*$percent;
						$formSp=ceil($formSp+$value[7]);
						$formSp=ceil($value[2]*$formSp);




            		break;

            		case "ATTNT Packet (20 forms each)":

					$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$attnt=((($value[3]))+($value[4]+$value[5]))*$percent;
						$attnt=ceil($attnt+$value[7]);
						$attnt=ceil($value[2]*$attnt);

            		break;


            		case "Poster 1- Date":

						$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$poster1=((($value[2]*$noSch)+($value[3]))+($value[4]+$value[5]))*$percent;
						$poster1=ceil($poster1);


            		break;
            		case "Poster 2- Behavior Change":

					$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$poster2=((($value[2]*$noSch)+($value[3]))+($value[4]+$value[5]))*$percent;
						$poster2=ceil($poster2);

            		break;


            	}


            }


	?><!--
						<tr>
							<th>BOX Id</th>
							<th>Teacher Training Booklet </th>
							<th>Form E Packet (20 forms each)</th>
							<th>Form N Packet (15 forms each)</th>
							<th>Form S Packet (5 forms each) </th>
							<th>Form E-P Packet (20 forms each)</th>
							<th>Form N-P Packet (5 forms each)</th>
							<th>Form S-P Packet (5 forms each)</th>
							<th>ATTNT Packet (20 forms each)</th>
							<th>Poster 1- Date</th>
							<th>Poster 2- Behavior Change</th>
							<th>Print Preview</th>
						</tr>





						<tr style="background-color:#bada66;">
					<td><i>REFERENCE</i></td>
					<td><?php echo $ttb; ?></td>
					<td><?php echo $formE; ?></td>
					<td><?php echo $formN; ?></td>
					<td><?php echo $formS; ?></td>
					<td><?php echo $formEp; ?></td>
					<td><?php echo $formNp; ?></td>
					<td><?php echo $formSp; ?></td>
					<td><?php echo $attnt; ?></td>
					<td><?php echo $poster1; ?></td>
					<td><?php echo $poster2; ?></td>
					<td><a  class="btn btn-info" style="text-decoration:none;margin-top:5%;" target="blank" href="materials_packing_strict.php?pdfTTB=<?php echo $district; ?>&county=<?php echo $county; ?>">View Pdf</a>
		
	</td>
					</tr>
				</table>
-->
<?php

$sql="select * from materials_packaging_history_ttb WHERE county_name='$county' AND district_name='$district'";
$resultA=mysql_query($sql)or die(mysql_error());
$sql="Select count(printlist_id) as Number from materials_packaging_history_ttb where county_name='$county' AND district_name='$district' AND printlist_id='$printlistId'";
//echo $sql;
$result=mysql_query($sql)or die(mysql_error());
while($row=mysql_fetch_array($result)){
	$numRows=$row["Number"];
}
if($numRows>=1){
?>
				<h3>INDIVIDUAL BOX CONTENT</h3>

				<table class="table table-bordered table-condensed table-striped table-hover">
					
						<tr>
							<th>Box Id</th>
							<th>Teacher Training Booklet </th>
							<th>Form E Packet (20 forms each)</th>
							<th>Form N Packet (15 forms each)</th>
							<th>Form S Packet (5 forms each) </th>
							<th>Form E-P Packet (20 forms each)</th>
							<th>Form N-P Packet (5 forms each)</th>
							<th>Form S-P Packet (5 forms each)</th>
							<th>ATTNT Packet (20 forms each)</th>
							<th>Poster 1- Date</th>
							<th>Poster 2- Behavior Change</th>
				 <?php if($priv_materials_edit>=1){ ?>			
							<th>Print Preview</th>
				 <?php }if($priv_materials_edit>=3){ ?>			
							<th>Edit</th>
				 <?php }if($priv_materials_edit>=4){ ?>			
							<th>Delete</th>
				 <?php } ?>			
						</tr>
		<?php
		$sql="SELECT * from materials_packaging_history_ttb where county_name='$county' AND district_name='$district' AND printlist_id='$printlistId'";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)){


			$boxId=$row["box_id"];
			$ttb=$row["ttb"];
			$formE=$row["form_e"];
			$formN=$row["form_n"];
			$formS=$row["form_s"];
			$formEp=$row["form_ep"];
			$formNp=$row["form_np"];
			$formSp=$row["form_sp"];
			$attntPacket=$row["attnt_packet"];
			$poster1=$row["poster_1"];
			$poster2=$row["poster_2"];
			$packageId=$row["package_id"];
	$link="materials_packing_strict.php?printlistId=".$printlistId." &countyName=".$county." &districtName=".$district;
 

		?>
		<tr>
			<td><?php echo $boxId; ?></td>
			<td><?php echo $ttb; ?></td>
			<td><?php echo $formE; ?></td>
			<td><?php echo $formN; ?></td>
			<td><?php echo $formS; ?></td>
			<td><?php echo $formEp; ?></td>
			<td><?php echo $formNp; ?></td>
			<td><?php echo $formSp; ?></td>
			<td><?php echo $attntPacket; ?></td>
			<td><?php echo $poster1; ?></td>
			<td><?php echo $poster2; ?></td>
			 <?php if($priv_materials_edit>=1){ ?>
		<td><a  class="btn btn-info" style="text-decoration:none;margin-top:5%;" target="blank" href="<?php echo $link; ?>&pdfTTBIndividual=<?php echo $packageId; ?>">View Pdf</a>
	 <?php } if($priv_materials_edit>=3){ ?>
		   <td><a href="<?php echo $link; ?>&packageId=<?php echo $packageId; ?>&tab=4#editTTBox"><img src="../images/icons/edit.png" height="20px"/></a></td>
	 <?php } if($priv_materials_edit>=4){ ?>
			   <td><a href="<?php echo $link; ?>&deleteTTPackageId=<?php echo $packageId; ?>&tab=2" onclick="show_confirm(<?php echo $packageId; ?>)"><img src="../images/icons/delete.png" height="20px"/></a></td>
 		<?php } ?>
		</tr>
<?php
	}
	?>
				</table>
<?php
}else{
	echo "<h3><i>Quantities Not Set</i></h3>";
}
?>	
	 <?php if($priv_materials_edit>=2){ ?>
<a class="btn-custom" style="text-decoration:none;"  href="#addTTBox">New Box</a>
	 <?php } ?>				 

               </form>


               <?php 
               }
               ?>


<div id="addTTBox" class="modalDialog" style="width:120%;margin-left:-5%; ">
  <div >
    <form method="POST">
    <a href="materials_packing_strict.php?tab=2" title="Close" class="close">X</a>
    <!-- ================= -->
<?php
	$boxId=isset($_POST["boxId"])?mysql_real_escape_string($_POST["boxId"]):0;
			$ttb=isset($_POST["ttb"])?mysql_real_escape_string($_POST["ttb"]):0;
			$formE=isset($_POST["formE"])?mysql_real_escape_string($_POST["formE"]):0;
			$formN=isset($_POST["formN"])?mysql_real_escape_string($_POST["formN"]):0;
			$formS=isset($_POST["formS"])?mysql_real_escape_string($_POST["formS"]):0;
			$formEp=isset($_POST["formEp"])?mysql_real_escape_string($_POST["formEp"]):0;
			$formNp=isset($_POST["formNp"])?mysql_real_escape_string($_POST["formNp"]):0;
			$formSp=isset($_POST["formSp"])?mysql_real_escape_string($_POST["formSp"]):0;
			$attntPacket=isset($_POST["attntPacket"])?mysql_real_escape_string($_POST["attntPacket"]):0;
			$poster1=isset($_POST["poster1"])?mysql_real_escape_string($_POST["poster1"]):0;
			$poster2=isset($_POST["poster2"])?mysql_real_escape_string($_POST["poster2"]):0;

if(isset($_POST["addTTBox"])){

$sql="INSERT INTO `materials_packaging_history_ttb`(`box_id`, `printlist_id`, `ttb`, `form_e`, `form_n`, `form_s`, `form_ep`, `form_np`, `form_sp`, `attnt_packet`, ";
$sql.="`poster_1`, `poster_2`, `county_name`, `district_name`, `collected`)";
$sql.=" VALUES ('$boxId','$printlistId','$ttb','$formE','$formN','$formS','$formEp','$formNp','$formSp','$attntPacket','$poster1','$poster2','$county','$district',0)";
mysql_query($sql);
$updateResult="A New Box Has Been Added";



$sql="Select count(printlist_id) as Number from materials_packaging_history_ttb where county_name='$county' AND district_name='$district' AND printlist_id='$printlistId'";
//echo $sql;
$result=mysql_query($sql)or die(mysql_error());
while($row=mysql_fetch_array($result)){
	$numRows=$row["Number"];
}
$sql="UPDATE materials_packaging_history set ttb='$numRows' WHERE countyName='$county' AND districtName='$district' AND printlist_id='$printlistId'";
mysql_query($sql);
}

?>

  <h3 style="margin-left:30%;">
        INDIVIDUAL BOX CONTENT
        </h3>

    <?php echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>".$updateResult."</h3>"; ?>
  			<table class="table table-bordered table-condensed table-striped table-hover">
					
						<tr>
							<th>Box Id</th>
							<th>Teacher Training Booklet </th>
							<th>Form E Packet (20 forms each)</th>
							<th>Form N Packet (15 forms each)</th>
							<th>Form S Packet (5 forms each) </th>
							<th>Form E-P Packet (20 forms each)</th>
							<th>Form N-P Packet (5 forms each)</th>
							<th>Form S-P Packet (5 forms each)</th>
							<th>ATTNT Packet (20 forms each)</th>
							<th>Poster 1- Date</th>
							<th>Poster 2- Behavior Change</th>
							
							
						</tr>
	
		<tr>
			<td><input type="text" class="num-only input-mini" name="boxId" value='<?php echo $boxId; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="ttb" value='<?php echo $ttb; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="formE" value='<?php echo $formE; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="formN" value='<?php echo $formN; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="formS" value='<?php echo $formS; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="formEp" value='<?php echo $formEp; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="formNp" value='<?php echo $formNp; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="formSp" value='<?php echo $formSp; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="attntPacket" value='<?php echo $attntPacket; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="poster1" value='<?php echo $poster1; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="poster2" value='<?php echo $poster2; ?>' /></td>
	
                <tr><td></td></tr>
                <tr><td colspan="5" ><input type="submit" style="margin-left:30%;" class="btn-custom" name="addTTBox" value="Add" /></td></tr>
      
		</tr>
	</table>

</form>
  </div>
</div>


<div id="editTTBox" class="modalDialog" style="width:120%;margin-left:-5%; ">
  <div >
    <form method="POST">
    <a href="materials_packing_strict.php?tab=2" title="Close" class="close">X</a>
    <!-- ================= -->
<?php

$packageId=$_GET["packageId"];
	$boxId=isset($_POST["boxId"])?mysql_real_escape_string($_POST["boxId"]):0;
			$ttb=isset($_POST["ttb"])?mysql_real_escape_string($_POST["ttb"]):0;
			$formE=isset($_POST["formE"])?mysql_real_escape_string($_POST["formE"]):0;
			$formN=isset($_POST["formN"])?mysql_real_escape_string($_POST["formN"]):0;
			$formS=isset($_POST["formS"])?mysql_real_escape_string($_POST["formS"]):0;
			$formEp=isset($_POST["formEp"])?mysql_real_escape_string($_POST["formEp"]):0;
			$formNp=isset($_POST["formNp"])?mysql_real_escape_string($_POST["formNp"]):0;
			$formSp=isset($_POST["formSp"])?mysql_real_escape_string($_POST["formSp"]):0;
			$attntPacket=isset($_POST["attntPacket"])?mysql_real_escape_string($_POST["attntPacket"]):0;
			$poster1=isset($_POST["poster1"])?mysql_real_escape_string($_POST["poster1"]):0;
			$poster2=isset($_POST["poster2"])?mysql_real_escape_string($_POST["poster2"]):0;

if(isset($_POST["updateTTBox"])){

$sql="UPDATE `materials_packaging_history_ttb` SET `box_id`='$boxId',";
$sql.="`ttb`='$ttb',`form_e`='$formE',`form_n`='$formN',`form_s`='$formS',`form_ep`='$formEp',";
$sql.="`form_np`='$formNp',`form_sp`='$formSp',`attnt_packet`='$attntPacket',`poster_1`='$poster1',";
$sql.="`poster_2`='$poster2',`county_name`='$county',`district_name`='$district',`collected`=0 WHERE `package_id`='$packageId'";

$resultA=mysql_query($sql) or die(mysql_error());
$updateResult="Box Contents Have Been Updated";
}

?>

  <h3 style="margin-left:30%;">
        INDIVIDUAL BOX CONTENT
        </h3>

    <?php echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>".$updateResult."</h3>"; ?>
  			<table class="table table-bordered table-condensed table-striped table-hover">
					
						<tr>
							<th>Box Id</th>
							<th>Teacher Training Booklet </th>
							<th>Form E Packet (20 forms each)</th>
							<th>Form N Packet (15 forms each)</th>
							<th>Form S Packet (5 forms each) </th>
							<th>Form E-P Packet (20 forms each)</th>
							<th>Form N-P Packet (5 forms each)</th>
							<th>Form S-P Packet (5 forms each)</th>
							<th>ATTNT Packet (20 forms each)</th>
							<th>Poster 1- Date</th>
							<th>Poster 2- Behavior Change</th>
							
						</tr>

				<?php
			
		$sql="SELECT * from materials_packaging_history_ttb where county_name='$county' AND district_name='$district' AND printlist_id='$printlistId' AND package_id='$packageId'";
	//	echo $sql;
		$result=mysql_query($sql);	
		while($row=mysql_fetch_array($result)){


			$boxId=$row["box_id"];
			$ttb=$row["ttb"];
			$formE=$row["form_e"];
			$formN=$row["form_n"];
			$formS=$row["form_s"];
			$formEp=$row["form_ep"];
			$formNp=$row["form_np"];
			$formSp=$row["form_sp"];
			$attntPacket=$row["attnt_packet"];
			$poster1=$row["poster_1"];
			$poster2=$row["poster_2"];
			$packageId=$row["package_id"];
	}
		?>
		<tr>
	
		<tr>
			<td><input type="text" class="num-only input-mini" name="boxId" value='<?php echo $boxId; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="ttb" value='<?php echo $ttb; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="formE" value='<?php echo $formE; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="formN" value='<?php echo $formN; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="formS" value='<?php echo $formS; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="formEp" value='<?php echo $formEp; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="formNp" value='<?php echo $formNp; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="formSp" value='<?php echo $formSp; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="attntPacket" value='<?php echo $attntPacket; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="poster1" value='<?php echo $poster1; ?>' /></td>
			<td><input type="text" class="num-only input-mini" name="poster2" value='<?php echo $poster2; ?>' /></td>
	 <tr><td colspan="5" ><input type="submit" style="margin-left:30%;" class="btn-custom" name="updateTTBox" value="Update" /></td></tr>
      
		</tr>
	</table>

</form>
  </div>
</div>



