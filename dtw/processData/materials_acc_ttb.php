	<form method="post" >
                            	<div style="margin-left:25%;">

                            		<h2>Teacher Training Box</h2>
			                                <img style="width:10%;" src="../images/gklogo.png"/>
												<b>Kenya National School-Based Deworming Programme</b>
			                                <img style="width:10%;" src="../images/kwaAfya.png"/>
			                              <hr style="font-weight:bolder;color:#EEEE;"/>
			               			</div>
							





<?php

$sql="select * from materials_packaging_history_ttb  WHERE collected=1";
$resultA=mysql_query($sql)or die(mysql_error());
$sql="Select count(package_id) as Number from materials_packaging_history_ttb WHERE collected=1 ";
//echo $sql;
$result=mysql_query($sql)or die(mysql_error());
while($row=mysql_fetch_array($result)){
	$numRows=$row["Number"];
}
if($numRows>=1){
?>

				<table class="table table-bordered table-condensed table-striped table-hover">
					
						<tr>
							<th>County</th>
							<th>District</th>
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
				            <th>Quantity Input</th>
						</tr>
		<?php
		while($row=mysql_fetch_array($resultA)){

                        $county=$row["county_name"];
                        $district=$row["district_name"];       
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

 $link="materials_tts.php?county_name=$county&district_name=".$district."&boxId=".$boxId;
 

		?>
		<tr>
			<td><?php echo $county; ?> </td>

			<td><?php echo $district; ?> </td>
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
		
	 <?php if($priv_materials_edit>=2){ ?>
                <td><a class="btn btn-info" style="text-decoration:none;margin-top:5%;" href="<?php echo $link; ?>#addQuantity">Add Quantities</a></td>
	 <?php } ?>				 

		</tr>
<?php
	}
	?>
				</table>
<?php
}else{
	echo "<h3 style='margin-left:25%;'><i>No Boxes have Been Sent.</i></h3>";
}
?>	
               </form>

