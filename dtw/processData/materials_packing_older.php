<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
$testdata = 'testdata';
$tabActive = 'tab1';
$updateResult="";



if(isset($_POST["teacherSave"])){
	$county=isset($_POST["county2"])?mysql_real_escape_string($_POST["county2"]):"";
	$district=isset($_POST["district2"])?mysql_real_escape_string($_POST["district2"]):"";
	$tabActive = 'tab4';
}


if(isset($_POST["districtSave"])){
	$county=isset($_POST["county1"])?urlencode($_POST["county1"]):"";
	$district=isset($_POST["district1"])?urlencode($_POST["district1"]):"";
	$tabActive = 'tab3';
}
      ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link href="../css/tabs_css.css" rel="stylesheet" type="text/css"/>
    <?php require_once ("includes/meta-link-script.php"); ?>
    <script src="../js/tabs.js"></script>
  </head>


  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php   require_once ("includes/menuNav.php");  ?>
      </div>
    </div>
 <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-Materials.php");
        ?>
      </div>
      <div class="contentBody" >


      
        <div class="tabbable" >
          <ul class="nav nav-tabs">

            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Number Of Boxes</a></li>
            <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Packaging History</a></li>
            <li <?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">District Training Boxes</a></li>
             <li <?php if ($tabActive == 'tab4') echo "class='active'" ?>><a href="#tab4" data-toggle="tab">Teacher Training Boxes</a></li>
          </ul>
          <div class="tab-content">
            
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                   
                            <form style="margin-left:2%;">
                            	<div style="margin-left:10%;">
                                <img style="width:10%;" src="../images/gklogo.png"/>
									<b>Kenya National School-Based Deworming Programme</b>
                                <img style="width:10%;" src="../images/kwaAfya.png"/>
                              <hr style="font-weight:bolder;color:#EEEE;"/>
                                </div>   
				<h4 style="margin-left:20%;">Number of boxes and their unique ID per District in each county</h4>
				<table class="table table-bordered table-condensed table-striped table-hover">
					<tr>
						<th>Id</th>
						<th>County</th>
						<th>District</th>
						<th>Number Of Boxes</th>
						<th>Box Id Number</th>
						<th>Total Boxes Per County</th>
						<th>Box 1</th>
						<th>Box 2</th>
						<th>Box 3</th>
						<th>Box 4</th>
						<th>Status</th>
						
					</tr>
					<?php

					$sql="SELECT county_name,district_name FROM a_bysch GROUP BY district_name ORDER BY county_name,district_name ASC";
			 			$result= mysql_query($sql);
  				$resultB=mysql_query($sql);
  				$id=1;
					while($row=mysql_fetch_array($resultB)){
					$countyName=$row["county_name"];
					$districtName=$row["district_name"];
					$link="materials_packing.php?id='$id'";
					?>
					<tr rowspan="3" >
					<td><input  class="input-mini uneditable-input" type="text" name="<?php echo $id; ?>" value="<?php echo $id; ?>" /></td>
					<td><input  class="input-mini uneditable-input" type="text" name="<?php echo $countyName; ?>" value="<?php echo $countyName; ?>" /></td>
					<td><input  class="input-mini uneditable-input" type="text" name="<?php echo $districtName; ?>" value="<?php echo $districtName; ?>" /></td>
					<td><input  class="input-mini" type="text" name="<?php echo $boxNo; ?>" value="<?php echo $boxNo; ?>" /></td>
					<td><input  class="input-mini" type="text" name="<?php echo $boxIds; ?>" value="<?php echo $boxIds; ?>" /></td>
					<td><textarea name="<?php echo $totalBoxes; ?>"><?php echo $totalBoxes; ?></textarea></td>
					<td><input  class="input-mini" type="text" name="<?php echo $box1; ?>" value="<?php echo $box1; ?>" /></td>
					<td><input  class="input-mini" type="text" name="<?php echo $box2; ?>" value="<?php echo $box2; ?>" /></td>
					<td><input  class="input-mini" type="text" name="<?php echo $box3; ?>" value="<?php echo $box3; ?>" /></td>
					<td><input  class="input-mini"  type="text" name="<?php echo $box4; ?>" value="<?php echo $box4; ?>" /></td>
					<td><i class="icon-search"></i></td>
					
				</tr>
				<?php 
				++$id;
				}
					?>
				</table>
               </form> 

            </div>
    <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
	



	</div>
            <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">

				<form method="post" style="margin-left:10%;">
                            	<div style="margin-left:10%;">
			                                <img style="width:10%;" src="../images/gklogo.png"/>
												<b>Kenya National School-Based Deworming Programme</b>
			                                <img style="width:10%;" src="../images/kwaAfya.png"/>
			                              <hr style="font-weight:bolder;color:#EEEE;"/>
			                                 
			                  County : &nbsp; <select id="county1" name="county1" onchange='submitDistrict();'>
			                  			<option selected='selected' value="<?php echo $county; ?>"><?php echo $county; ?></option>
			                  	<?php
			                  		$sql="select county from counties";
			                  		$resultCounty=mysql_query($sql);
			                  		while($key=mysql_fetch_array($resultCounty)){

			                  			echo "<option value=".$key['county'].">".$key['county']."</option>";
			                  		}
			                  	?>

			                  					</select>
			                  					<br/>
			                  District : &nbsp; <select id="district1" name="district1" onchange='submitDistrict();'>
										<option selected='selected' value="<?php echo $district; ?>"><?php echo $district; ?></option>
			                  	<?php
			                  		$sql="select district_name from districts where county='$county'";
			                  		$resultDistrict=mysql_query($sql);
			                  		while($key=mysql_fetch_array($resultDistrict)){

			                  			echo "<option value=".$key['district_name'].">".$key['district_name']."</option>";
			                  		}
			                  	?>


			                  					</select>

			                  					<input type="submit" style="display:none;" id="districtSave" name="districtSave" value="save" />
			                  					<br/>
			                  	Box Type:<h3>District Training</h3><br/>

			                  	<h3>Contents</h3>

 							</div> 

				<table class="table table-bordered table-condensed table-striped table-hover">
					<tr>
						<th>Document Title</th>
						<th>Quantity</th>
						
					</tr>
					<?php
					$count=1;
					//$sql="select * from materials_desc where packet='Master Trainers Packet' or packet='DC Packet'";
					//$sql.=" or packet='DMOH Packet' or packet='District Training Booklet'";
					//$sql.=" or materials= 'Teacher Training Booklet' or packet=''";

					//This logic will only filter out the teacher training variables

//Masters Package
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND packet='Master Trainers Packet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$masterTrainers+=$row["var1"];

					}

$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND packet='DC Packet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						if($row["var2"]==0){
							$row["var2"]=1;
						}

						$dcPacket+=$row["var1"]*$row["var2"];

					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND packet='DPHO Packet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$dmohPackets+=$row["var1"];

					}
						$sql="select * from materials_desc where materials ='District Training Booklet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$dtb+=$row["var1"];

					}

				$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Teacher Training Booklet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$ttb+=$row["var1"];

					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Handout on Financial Disbursements'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$hfd+=$row["var1"];

					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Guide for District Level Managers (old)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$gdlm+=$row["var1"];

					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Teacher Training Kit (old)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$ttk+=$row["var1"];

					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Form A'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$formA+=$row["var1"];

					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Form AP'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$formAp+=$row["var1"];

					}
						$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Poster 1'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$poster1+=$row["var1"];

					}
						$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Poster 2'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$poster2+=$row["var1"];

					}
						// echo $row["materials"]; 
						//Master Trainers Packet
					/*					//long method 
					if($key["materials"]=="ATTNR-MoESTST Day 1"){
					      $attnr_moed1_perdist = $key["var1"];
					    }

					if($key["materials"]=="ATTNR-MoEST Day 2"){
					      $attnr_moed2_perdist = $key["var1"];
					    }

					if($key["materials"]=="ATTNR- Moh Day 1"){
					      $attnr_mohd1_perdist = $key["var1"];
					    }
					     
					     
					if($key["materials"]=="ATTNR- MoH Day 2"){
					      $attnr_mohd2_perdist = $key["var1"];
					    }

					if($key["materials"]=="Form MT"){
					      $formMT_perdist = $key["var1"];
					    }

					if($key["materials"]=="Form P (school list)"){
					      $formP_slist_perdist = $key["var1"];
					    }

					if($key["materials"]=="Form P (programme activities)"){
					      $formP_pactivities_perdist = $key["var1"];
					    }
				
					//
									*/
				
				//$masterTrainers=$attnr_moed1_perdist+$attnr_moed2_perdist+$attnr_mohd1_perdist+ $attnr_mohd2_perdist+ $formMT_perdist
				//+$formP_slist_perdist+$formP_pactivities_perdist;
					?>
					<tr rowspan="3" >
					<td>1
					&nbsp; Master Trainers Packet: &nbsp; </td>
					<td><?php echo $masterTrainers; ?></td>
					
				</tr>
				<tr rowspan="3" >
					<td>2
					&nbsp; DC Packet: &nbsp; </td>
					<td><?php echo $dcPacket; ?></td>
					
				</tr>
				<tr rowspan="3" >
					<td>3
					&nbsp; DPHO Packet: &nbsp; </td>
					<td><?php echo $dmohPacket; ?></td>
					
				</tr>
				<tr rowspan="3" >
					<td>4
					&nbsp;District Training Booklet: &nbsp; </td>
					<td><?php echo $dtb; ?></td>
					
				</tr>
				<tr rowspan="3" >
					<td>5
					&nbsp;Teacher Training Booklet: &nbsp; </td>
					<td><?php echo $ttb; ?></td>
					
				</tr>
				<tr rowspan="3" >
					<td>6
					&nbsp;
				Handout on Financial Disbursements: &nbsp; </td>
					<td><?php echo $hfd; ?></td>
					
				</tr>
				<tr rowspan="3" >
					<td>7
					&nbsp;
				Guide for District Level Managers (old): &nbsp; </td>
					<td><?php echo $hfd; ?></td>
					
				</tr>
				<tr rowspan="3" >
					<td>8
					&nbsp;
				 Teacher Training Kit (old): &nbsp; </td>
					<td><?php echo $ttk; ?></td>
					
				</tr>

					<tr rowspan="3" >
					<td>9
					&nbsp;
				 Form A: &nbsp; </td>
					<td><?php echo $formA; ?></td>
					
				</tr>

	<tr rowspan="3" >
					<td>10
					&nbsp;
				  Form AP: &nbsp; </td>
					<td><?php echo $formAP; ?></td>
					
				</tr>

	<tr rowspan="3" >
					<td>11
					&nbsp;
				  Poster 1 - Deworming Date: &nbsp; </td>
					<td><?php echo $poster1; ?></td>
					
				</tr>

	<tr rowspan="3" >
					<td>12
					&nbsp;
				  Poster 2 – Behavior change &nbsp; </td>
					<td><?php echo $poster2; ?></td>
					
				</tr>

				</table>
               </form>
             </div> 


            <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">


	<form method="post" style="margin-left:10%;">
                            	<div style="margin-left:10%;">
			                                <img style="width:10%;" src="../images/gklogo.png"/>
												<b>Kenya National School-Based Deworming Programme</b>
			                                <img style="width:10%;" src="../images/kwaAfya.png"/>
			                              <hr style="font-weight:bolder;color:#EEEE;"/>
			                                 
			                  County : &nbsp; <select id="county2" name="county2" onchange='submitCounty();'>
			                  			<option selected='selected' value="<?php echo $county; ?>"><?php echo $county; ?></option>
			                  	<?php
			                  		$sql="select county from counties";
			                  		$resultCounty=mysql_query($sql);
			                  		while($key=mysql_fetch_array($resultCounty)){

			                  			echo "<option value=".$key['county'].">".$key['county']."</option>";
			                  		}
			                  	?>

			                  					</select>
			                  					<br/>
			                  District : &nbsp; <select id="district2" name="district2" onchange='submitCounty();'>
										<option selected='selected' value="<?php echo $district; ?>"><?php echo $district; ?></option>
			                  	<?php
			                  		$sql="select district_name from districts where county='$county'";
			                  		$resultDistrict=mysql_query($sql);
			                  		while($key=mysql_fetch_array($resultDistrict)){

			                  			echo "<option value=".$key['district_name'].">".$key['district_name']."</option>";
			                  		}
			                  	?>


			                  					</select>

			                  					<input type="submit" style="display:none;" id="teacherSave" name="teacherSave" value="save" />
			                  					<br/>
			                  	Box Type:<h3>Teacher Training</h3><br/>

			                  	<h3>Contents</h3>

 							</div> 

				<table class="table table-bordered table-condensed table-striped table-hover">
					<tr>
						<th>Document Title</th>
						<th>Quantity</th>
						
					</tr>
					<?php
					$count=1;
					//$sql="select * from materials_desc where packet='Master Trainers Packet' or packet='DC Packet'";
					//$sql.=" or packet='DMOH Packet' or packet='District Training Booklet'";
					//$sql.=" or materials= 'Teacher Training Booklet' or packet=''";

					//This logic will only filter out the teacher training variables

//Masters Package
					$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other'";
					$resultB=mysql_query($sql);
					

					while($row=mysql_fetch_array($resultB)){
						echo "<tr>";
						echo "<td>".$row['materials']."</td>";
						echo "<td>".$row['var1']."</td>";
						echo "</tr>";


					
					}

					?>
				

				</table>
               </form>





            </div>

            </div>
          </div>
        </div>
			<script>
	            function submitCounty() {
	              var selectButton = document.getElementById('teacherSave');
	              selectButton.click();
		        
	            }
   	            function submitDistrict() {
	              var selectButton = document.getElementById('districtSave');
	              selectButton.click();
		        
	            }

            </script>