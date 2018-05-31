<?php
if(isset($_GET["deletePackageId"])){
	$updateResult="A Box has been Deleted";
}
$priv_materials_edit=4;
?>
	<!-- Modal includes -->
	<link rel="stylesheet" type="text/css" href="css/modal.css"/>
      <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">

    <?php echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>".$updateResult."</h3>"; ?>
				<form action="materials_packing_strict.php" method="post" >
                            	<div style="margin-left:20%;">
                            		<h2>Box Type:District Training Box</h2>
			                      <br/><br/>
								<div class="span4">
		<label>County<?php echo ": ".$county; ?></label>   &nbsp;		<label>District<?php echo ": ".$district; ?></label>
									
								</div>

			                  
							</div>

							<?php
							$sql="select * from materials_packaging_history WHERE districtName='$district'";
							$sql.=" AND countyName='$county' AND printlist_id=$printlistId";

							$resultDTB=mysql_query($sql);
							while($row=mysql_fetch_array($resultDTB)){
								$dtbQ=unserialize($row["dtb_quantites"]);
								if(empty($dtbQ) || $dtbQ==NULL){
										$dtbNo=$row["dtb"];
									
								}else{
											$dtbNo=0;
										
						
								}




							}




							if(isset($county) && isset($district)){
				        
                                        
				$sql="SELECT * from materials_packaging_history_data where printlist_id='$printlistId' AND";
				$sql.=" county_name='$county' AND district_name='$district'";
				//echo $sql;
				$resultA=mysql_query($sql);
				if(mysql_affected_rows()>=1){
					?>

				<h3 style="margin-left:30%;">
				INDIVIDUAL BOX CONTENT
				</h3>

				<table class="table table-bordered table-condensed table-striped table-hover">
					<tr>
					<th>Box Id</th>
					<th>Master Trainers Packet</th>
					<th>DC Packet</th>
					<th>DPHO Packet</th>
					<th>District Training Booklet</th>
					<th>Teacher Training Booklet </th>

					<th>Handout on Financial Disbursements</th>

					<th>Guide for District Level Managers (old)</th>

					<th>Teacher Training Kit (old)</th>

					<th>Form A</th>

					<th>Form AP</th>

					<th>Poster 1 - Deworming Date</th>

					<th>Poster 2 – Behavior change</th>
					 <?php if($priv_materials_edit>=1){ ?>
					<th>Print Preview</th>
				 <?php }if($priv_materials_edit>=3){ ?>	
					<th>Edit <br/>Details</th>
				 <?php }if($priv_materials_edit>=4){ ?>	
					<th>Delete <br/> Details</th>
					 <?php } ?>
				</tr>
			<?php

				while($row=mysql_fetch_array($resultA)){

					$boxId=$row["box_id"];
					$masterTrainers=$row["mtp"];
					$dcPacket=$row["dc_packet"];
					$dphoPackets=$row["dpho_packet"];
					$dtb=$row["dtb"];
					$ttb=$row["ttb"];
					$hfd=$row["hfd"];
					$gdlm=$row["gdlm"];
					$ttk=$row["ttk"];
					$formA=$row["form_a"];
					$formAp=$row["form_ap"];
					$posterA=$row["poster_1"];
					$posterB=$row["poster_2"];
					$packageId=$row["package_id"];
                                        
    $link="materials_packing_strict.php?printlistId=".$printlistId." &countyName=".$county." &districtName=".$district;
 

				?>
				<tr>
				<td><?php echo $boxId; ?></td>
				<td><?php echo $masterTrainers; ?></td>
				<td><?php echo $dcPacket; ?></td>
				<td><?php echo $dphoPackets; ?></td>
				<td><?php echo $dtb; ?></td>
				<td><?php echo $ttb; ?></td>
				<td><?php echo $hfd; ?></td>
				<td><?php echo $gdlm; ?></td>
				<td><?php echo $ttk; ?></td>
				<td><?php echo $formA; ?></td>
				<td><?php echo $formAp; ?></td>
				<td><?php echo $posterA; ?></td>
				<td><?php echo $posterB; ?></td>
 <?php if($priv_materials_edit>=1){ ?>
				<td><a  class="btn btn-info" style="text-decoration:none;margin-top:5%;" target="blank" href="materials_packing_strict.php?boxId=<?php echo $boxId; ?>&pdfDTB=<?php echo $district; ?>&county=<?php echo $county; ?>">View Pdf</a>
	 <?php }if($priv_materials_edit>=2){ ?>
		   <td><a href="<?php echo $link; ?>&packageId=<?php echo $packageId; ?>&tab=3#editBoxContent"><img src="../images/icons/edit.png" height="20px"/></a></td>
	 <?php }if($priv_materials_edit>=4){ ?>
			   <td><a href="<?php echo $link; ?>&deletePackageId=<?php echo $packageId; ?>&tab=2" onclick="show_confirm(<?php echo $packageId; ?>)"><img src="../images/icons/delete.png" height="20px"/></a></td>
	  <?php } ?>
				</tr>
				<?php
			
			}
			?>

				</table>
			<?php
			}else{
				echo "<i>Quantites Not Set</i><br/><br/>";
               			
			}
				?>
			            

					<input type="hidden" name="boxes1" class="input-mini" value="<?php echo $boxes1; ?>" />
					<input type="hidden" name="county1" class="input-mini" value="<?php echo $county; ?>"/>
					<input type="hidden" name="district1" class="input-mini" value="<?php echo $district; ?>"/>
					 <?php if($priv_materials_edit>=2){ ?>
					<a class="btn-custom" style="text-decoration:none;"  href="#addBox">New Box</a>
				    <?php } ?>
				     	<br/><br/>
					         
             
               				

				<?php 
               }
               ?>
               </form>

               
             </div> 




<div id="addBox" class="modalDialog" style="width:120%;margin-left:-5%; ">
  <div >
    <form method="POST">
    <a href="materials_packing_strict.php" title="Close" class="close">X</a>
    <!-- ================= -->
<?php

					$boxId=isset($_POST["boxId"])?mysql_real_escape_string($_POST["boxId"]):0;
					$masterTrainer=isset($_POST["mtp"])?mysql_real_escape_string($_POST["mtp"]):0;
					$dcPacket=isset($_POST["dc_packet"])?mysql_real_escape_string($_POST["dc_packet"]):0;
					$dphoPackets=isset($_POST["dpho_packet"])?mysql_real_escape_string($_POST["dpho_packet"]):0;
					$dtb=isset($_POST["dtb"])?mysql_real_escape_string($_POST["dtb"]):0;
					$ttb=isset($_POST["ttb"])?mysql_real_escape_string($_POST["ttb"]):0;
					$hfd=isset($_POST["hfd"])?mysql_real_escape_string($_POST["hfd"]):0;
					$gdlm=isset($_POST["gdlm"])?mysql_real_escape_string($_POST["gdlm"]):0;
					$ttk=isset($_POST["ttk"])?mysql_real_escape_string($_POST["ttk"]):0;
					$formA=isset($_POST["form_a"])?mysql_real_escape_string($_POST["form_a"]):0;
					$formAp=isset($_POST["form_ap"])?mysql_real_escape_string($_POST["form_ap"]):0;
					$posterA=isset($_POST["poster_1"])?mysql_real_escape_string($_POST["poster_1"]):0;
					$posterB=isset($_POST["poster_2"])?mysql_real_escape_string($_POST["poster_2"]):0;
					

if(isset($_POST["addNewBox"])){



$sql="INSERT INTO `materials_packaging_history_data`(`box_id`, `printlist_id`, `mtp`, `dc_packet`, `dpho_packet`,";
$sql.=" `dtb`, `ttb`, `hfd`, `gdlm`, `ttk`, `form_a`,`form_ap`, `poster_1`, `poster_2`, `county_name`, `district_name`, `collected`)";
$sql.=" VALUES ('$boxId','$printlistId','$masterTrainer','$dcPacket','$dphoPackets','$dtb','$ttb','$hfd','$gdlm','$ttk','$formA','$formAp','$posterA','$posterB',";
$sql.="'$county','$district',0)";
//echo $sql;
mysql_query($sql);
$updateResult="A New Box Was Added";

$sql="Select count(printlist_id) as Number from materials_packaging_history_data where county_name='$county' AND district_name='$district' AND printlist_id='$printlistId'";
//echo $sql;
$result=mysql_query($sql)or die(mysql_error());
while($row=mysql_fetch_array($result)){
	$numRows=$row["Number"];
}
$sql="UPDATE materials_packaging_history set dtb='$numRows' WHERE countyName='$county' AND districtName='$district' AND printlist_id='$printlistId'";
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
          <th>Master Trainers Packet</th>
          <th>DC Packet</th>
          <th>DPHO Packet</th>
          <th>District Training Booklet</th>
          <th>Teacher Training Booklet </th>

          <th>Handout on Financial Disbursements</th>

          <th>Guide for District Level Managers (old)</th>

          <th>Teacher Training Kit (old)</th>

          <th>Form A</th>

          <th>Form AP</th>

          <th>Poster 1 - Deworming Date</th>

          <th>Poster 2 – Behavior change</th>
          
        </tr>
        <tr>
        <td><input type='text' class='input-mini num-only' name='boxId' value='<?php echo $boxId; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='mtp' value='<?php echo $masterTrainer; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='dc_packet' value='<?php echo $dcPacket; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='dpho_packet' value='<?php echo $dphoPackets; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='dtb' value='<?php echo $dtb; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='ttb' value='<?php echo $ttb; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='hfd' value='<?php echo $hfd; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='gdlm' value='<?php echo $gdlm; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='ttk' value='<?php echo $ttk; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='form_a' value='<?php echo $formA; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='form_ap' value='<?php echo $formAp; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='poster_1' value='<?php echo $posterA; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='poster_2' value='<?php echo $posterB; ?>'/></td>
        </tr>
        <tr><td colspan="5" ><input type="submit" style="margin-left:30%;" class="btn btn-info" name="addNewBox" value="Add" /></td></tr>
        </table>

					<input type="hidden" name="county"  value="<?php echo $county; ?>"/>
					<input type="hidden" name="district"  value="<?php echo $district; ?>"/>
    </form>
  </div>
</div>






<div id="editBoxContent" class="modalDialog" style="width:120%;margin-left:-5%; ">
  <div >
    <form method="POST">
    <a href="materials_packing_strict.php?tab=2" title="Close" class="close">X</a>
    <!-- ================= -->
<?php
$packageId=$_GET["packageId"];
$sql="SELECT * from materials_packaging_history_data WHERE county_name='$county' AND district_name='$district' AND printlist_id='$printlistId' AND package_id='$packageId'";
$result=mysql_query($sql) or die(mysql_error());
//echo $sql;
while($row=mysql_fetch_array($result)){
					$boxId=isset($row["box_id"])?$row["box_id"]:0;
					$masterTrainer=isset($row["mtp"])?$row["mtp"]:0;
					$dcPacket=isset($row["dc_packet"])?$row["dc_packet"]:0;
					$dphoPackets=isset($row["dpho_packet"])?$row["dpho_packet"]:0;
					$dtb=isset($row["dtb"])?$row["dtb"]:0;
					$ttb=isset($row["ttb"])?$row["ttb"]:0;
					$hfd=isset($row["hfd"])?$row["hfd"]:0;
					$gdlm=isset($row["gdlm"])?$row["gdlm"]:0;
					$ttk=isset($row["ttk"])?$row["ttk"]:0;
					$formA=isset($row["form_a"])?$row["form_a"]:0;
					$formAp=isset($row["form_ap"])?$row["form_ap"]:0;
					$posterA=isset($row["poster_1"])?$row["poster_1"]:0;
					$posterB=isset($row["poster_2"])?$row["poster_2"]:0;
					

}
	
if(isset($_POST["editBox"])){
					$boxId=isset($_POST["boxId"])?mysql_real_escape_string($_POST["boxId"]):0;
					$masterTrainer=isset($_POST["mtp"])?mysql_real_escape_string($_POST["mtp"]):0;
					$dcPacket=isset($_POST["dc_packet"])?mysql_real_escape_string($_POST["dc_packet"]):0;
					$dphoPackets=isset($_POST["dpho_packet"])?mysql_real_escape_string($_POST["dpho_packet"]):0;
					$dtb=isset($_POST["dtb"])?mysql_real_escape_string($_POST["dtb"]):0;
					$ttb=isset($_POST["ttb"])?mysql_real_escape_string($_POST["ttb"]):0;
					$hfd=isset($_POST["hfd"])?mysql_real_escape_string($_POST["hfd"]):0;
					$gdlm=isset($_POST["gdlm"])?mysql_real_escape_string($_POST["gdlm"]):0;
					$ttk=isset($_POST["ttk"])?mysql_real_escape_string($_POST["ttk"]):0;
					$formA=isset($_POST["form_a"])?mysql_real_escape_string($_POST["form_a"]):0;
					$formAp=isset($_POST["form_ap"])?mysql_real_escape_string($_POST["form_ap"]):0;
					$posterA=isset($_POST["poster_1"])?mysql_real_escape_string($_POST["poster_1"]):0;
					$posterB=isset($_POST["poster_2"])?mysql_real_escape_string($_POST["poster_2"]):0;
					

$sql="UPDATE `materials_packaging_history_data` SET `box_id`='$boxId',`mtp`='$masterTrainer',`dc_packet`='$dcPacket',";
$sql.="`dpho_packet`='$dphoPackets',`dtb`='$dtb',`ttb`='$ttb',`hfd`='$hfd',`gdlm`='$gdlm',`ttk`='$ttk',";
$sql.="`form_a`='$formA',`form_ap`='$formAp',`poster_1`='$posterA',`poster_2`='$posterB'";
$sql.="WHERE package_id='$packageId'";
//echo $sql;
mysql_query($sql);
$updateResult="Box Contents Updated";
}

?>

  <h3 style="margin-left:30%;">
       EDIT INDIVIDUAL BOX CONTENT
        </h3>

    <?php echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>".$updateResult."</h3>"; ?>
        <table class="table table-bordered table-condensed table-striped table-hover">
          <tr>
          <th>Box Id</th>
          <th>Master Trainers Packet</th>
          <th>DC Packet</th>
          <th>DPHO Packet</th>
          <th>District Training Booklet</th>
          <th>Teacher Training Booklet </th>

          <th>Handout on Financial Disbursements</th>

          <th>Guide for District Level Managers (old)</th>

          <th>Teacher Training Kit (old)</th>

          <th>Form A</th>

          <th>Form AP</th>

          <th>Poster 1 - Deworming Date</th>

          <th>Poster 2 – Behavior change</th>
          
        </tr>
        <tr>
        <td><input type='text' class='input-mini num-only' name='boxId' value='<?php echo $boxId; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='mtp' value='<?php echo $masterTrainer; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='dc_packet' value='<?php echo $dcPacket; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='dpho_packet' value='<?php echo $dphoPackets; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='dtb' value='<?php echo $dtb; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='ttb' value='<?php echo $ttb; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='hfd' value='<?php echo $hfd; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='gdlm' value='<?php echo $gdlm; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='ttk' value='<?php echo $ttk; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='form_a' value='<?php echo $formA; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='form_ap' value='<?php echo $formAp; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='poster_1' value='<?php echo $posterA; ?>'/></td>
        <td><input type='text' class='input-mini num-only' name='poster_2' value='<?php echo $posterB; ?>'/></td>
        </tr>
        <tr><td colspan="5" ><input type="submit" style="margin-left:30%;" class="btn btn-info" name="editBox" value="Update Box Content" /></td></tr>
        </table>

					<input type="hidden" name="county"  value="<?php echo $county; ?>"/>
					<input type="hidden" name="district"  value="<?php echo $district; ?>"/>
    </form>
  </div>
</div>
<?php
if(isset($_GET["pdfView"])){
  $pdfView=$_GET["pdfView"];
	
	$sql="select * from materials_printlist_history where status=1";

		$resultA=mysql_query($sql);
		while($row=mysql_fetch_array($resultA)){

			$printlistId=$row["id"];
		}

				
		$sql="SELECT * from materials_packaging_history WHERE printlist_id=".$printlistId;
		$result= mysql_query($sql);
  				$resultB=mysql_query($sql);
  				$id=1;

  				  $data="<div style=\"margin-left:10%;\">
                               
                                </div>   
				<table class=\"table table-bordered table-condensed table-striped table-hover\">
					<tr>
						<th>Id</th> 
						<th>County</th>
						<th>District</th>
						<th>Total Number Of Boxes</th>
						<th>Total District Boxes </th>
                                                <th>Total Teacher Training<br/> Boxes </th>
						<th>Box Id Numbers</th>
						
						<th>Status</th>
						
					</tr>";
					while($row=mysql_fetch_array($resultB)){
					$countyName=$row["countyName"];
					$districtName=$row["districtName"];
					$noBox=$row["noBox"];
					$boxId=$row["boxId"];
					$printlistId=$row["printlist_id"];
                                        $dtb=$row["dtb"];
                                        $ttb=$row["ttb"];
         $sql="SELECT box_id from materials_packaging_history_data where county_name='$countyName' AND district_name='$districtName' AND printlist_id='$printlistId' ";
         $resultXtr=mysql_query($sql);
         $counter=1;
		while($key=mysql_fetch_array($resultXtr)){
                    
                    if($counter==1){
                         $boxId.=$key["box_id"];
                    }else{
                    $boxId.=",".$key["box_id"];
                    }
                    
                   ++$counter; 
                }	//$data.=$sql;		
      			$data.="<tr><td>";
      			$data.=$id;
      			$data.="</td><td>";
      			$data.=$countyName;
				$data.="</td><td>";
				$data.=$districtName;
				$data.="</td><td>";
				$data.=$noBox;      			
				$data.="</td><td>";
				$data.=$dtb;
				$data.="</td><td>";
				$data.=$ttb;
				$data.="</td><td>";
                                $data.=$boxId;
				$data.="</td><td>";
							

				$boxes=($noBox-($dtb+$ttb));
						if($boxes<0){
						$data.="Extra Boxes Found";
						}
						if($boxes>0){
						$data.= "Boxes Missing";
						}
						if($boxes==0){
						$data.= "OK";
						}



      			$data.="</td></tr>";





	++$id;
				}


$data.="</table>";


//$_SESSION["tableData"]=$sql;
 $_SESSION["tableData"]=$data;
 //$_SESSION["tableData"].="Hello";
  header("Location:../tcpdf/examples/materials_packing_pdf.php?pdf=material_packing.pdf");
  exit();









}

if(isset($_GET["pdfDTB"])){
  $district=$_GET["pdfDTB"];
$county=$_GET["county"];
$boxId=$_GET["boxId"];					        	
			        
						
							$tablename = 'counties';
							$fields = 'id, county';
							$where = '1=1';
							$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
						




			               $data="<br/><br/>Box Type:<h3>District Training</h3><br/>";

					         $data.="County: ".$county." District Name: ".$district;
           			        $data.=" 	<h3>Contents</h3>
	

				<table class=\"table table-bordered table-condensed table-striped table-hover\">
					<tr>
						<th>Document Title</th>
						<th>Quantity</th>
						
					</tr>
				";
				

					//Finding out no of division fr this district

					$sql="select * from divisions where district_name=".$district."";
					//$data.=$sql;
					$resultA=mysql_query($sql);
					$noDiv=mysql_affected_rows();

				//	echo $noDiv;
				//	echo $sql;
					$count=1;
					//$sql="select * from materials_desc where packet='Master Trainers Packet' or packet='DC Packet'";
					//$sql.=" or packet='DMOH Packet' or packet='District Training Booklet'";
					//$sql.=" or materials= 'Teacher Training Booklet' or packet=''";

					//This logic will only filter out the teacher training variables

//Masters Package
                
					$sql="SELECT * from materials_packaging_history_data where box_id='$boxId'";
				
                                $resultB=mysql_query($sql);
					while($row=mysql_fetch_array($resultB)){
					
				
					$boxId=$row["box_id"];
					$masterTrainers=$row["mtp"];
					$dcPacket=$row["dc_packet"];
					$dphoPackets=$row["dpho_packet"];
					$dtb=$row["dtb"];
					$ttb=$row["ttb"];
					$hfd=$row["hfd"];
					$gdlm=$row["gdlm"];
					$ttk=$row["ttk"];
					$formA=$row["form_a"];
					$formAp=$row["form_ap"];
					$posterA=$row["poster_1"];
					$posterB=$row["poster_2"];
					$packageId=$row["package_id"];
                                        }

					$data.="<tr rowspan=\"3\" >";
					$data.="<td>1
					&nbsp; Master Trainers Packet: &nbsp; </td>";
					$data.="<td>".$masterTrainers."</td>";
					$data.="</tr>";


					$data.="<tr rowspan=\"3\" >";
					$data.="<td>2
					&nbsp; DC Packet: &nbsp;</td>";
					$data.="<td>".$dcPacket."</td>";
					$data.="</tr>";


					$data.="<tr rowspan=\"3\" >";
					$data.="<td>3
					&nbsp; DPHO Packet: &nbsp; </td>";
					$data.="<td>".$dphoPackets."</td>";
					$data.="</tr>";



					$data.="<tr rowspan=\"3\" >";
					$data.="<td>4
					&nbsp;District Training Booklet: &nbsp; </td>";
					$data.="<td>".$dtb."</td>";
					$data.="</tr>";



					$data.="<tr rowspan=\"3\" >";
					$data.="<td>5
					&nbsp;Teacher Training Booklet: &nbsp;  </td>";
					$data.="<td>".$ttb."</td>";
					$data.="</tr>";



					$data.="<tr rowspan=\"3\" >";
					$data.="<td>6
					&nbsp;
				Handout on Financial Disbursements: &nbsp;  </td>";
					$data.="<td>".$hfd."</td>";
					$data.="</tr>";


					$data.="<tr rowspan=\"3\" >";
					$data.="<td>7
					&nbsp;
				Guide for District Level Managers (old): &nbsp;  </td>";
					$data.="<td>".$gdlm."</td>";
					$data.="</tr>";

					$data.="<tr rowspan=\"3\" >";
					$data.="<td>8
					&nbsp;
				 Teacher Training Kit (old): &nbsp;  </td>";
					$data.="<td>".$ttk."</td>";
					$data.="</tr>";

				$data.="<tr rowspan=\"3\" >";
					$data.="<td>9
					&nbsp;
				 Form A: &nbsp;  </td>";
					$data.="<td>".$formA."</td>";
					$data.="</tr>";


				$data.="<tr rowspan=\"3\" >";
					$data.="<td>10
					&nbsp;
				  Form AP: &nbsp;  </td>";
					$data.="<td>".$formAp."</td>";
					$data.="</tr>";

				$data.="<tr rowspan=\"3\" >";
					$data.="<td>11
					&nbsp;
				  Poster 1 - Deworming Date: &nbsp; </td>";
					$data.="<td>".$posterA."</td>";
					$data.="</tr>";


				$data.="<tr rowspan=\"3\" >";
					$data.="<td>12
					&nbsp;
				  Poster 2 – Behavior change &nbsp;</td>";
					$data.="<td>".$posterB."</td>";
					$data.="</tr>";



//$_SESSION["tableData"]=$sql;
 $_SESSION["tableData"]=$data;
 //$_SESSION["tableData"].="Hello";
  header("Location:../tcpdf/examples/materials_packing_pdf.php?pdf=material_packingDTB.pdf");
  exit();

echo "<pre>";
echo $data;

echo "<pre>";








}
?>