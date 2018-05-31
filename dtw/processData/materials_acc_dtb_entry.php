	<form method="post" >
                            	<div style="margin-left:25%;">

                            		<h2>District Training Box</h2>
			                                <img style="width:10%;" src="../images/gklogo.png"/>
												<b>Kenya National School-Based Deworming Programme</b>
			                                <img style="width:10%;" src="../images/kwaAfya.png"/>
			                              <hr style="font-weight:bolder;color:#EEEE;"/>
			               			</div>
							





<?php
$sql="SELECT * from materials_acc_dtb";
$resultX=mysql_query($sql)or die(mysql_error());
$nums=mysql_affected_rows();
if($nums>=1){
$count=0;
while($key=mysql_fetch_array($resultX)){
    if($count==0){
     $boxKey=$key["box_id"];   
    }else{
    $boxKey.=" OR box_id=".$key["box_id"];
    }
    ++$count;
}
//echo "This is ".$boxKey."For a count of ".$count;
$sql="select * from materials_packaging_history_data WHERE collected=1 AND box_id=".$boxKey;

$resultA=mysql_query($sql)or die(mysql_error());
//echo $sql;
$sql="Select count(package_id) as Number from materials_packaging_history_data WHERE collected=1 ";

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
                <th>Quantity Input</th>
            </tr>
            <?php
            while ($row = mysql_fetch_array($resultA)) {

                $county = $row["county_name"];
                $district = $row["district_name"];
                $boxId = $row["box_id"];
                $mtp = $row["mtp"];
                $dc_packet= $row["dc_packet"];
                $dpho_packet = $row["dpho_packet"];
                $dtb = $row["dtb"];
                $ttb = $row["ttb"];
                $hfd = $row["hfd"];
                $gdlm = $row["gdlm"];
                $ttk = $row["ttk"];
                $formA = $row["form_a"];
                $formAp = $row["form_ap"];
                $poster1 = $row["poster_1"];
                $poster2 = $row["poster_2"];

          $link="materials_tts.php?tab=tab6&county_name=$county&district_name=".$district."&boxId=".$boxId;
       ?>
                <tr>
                    <td><?php echo $county; ?> </td>

                    <td><?php echo $district; ?> </td>
                    <td><?php echo $boxId; ?></td>
                    <td><?php echo $mtp; ?></td>
                    <td><?php echo $dc_packet; ?></td>
                    <td><?php echo $dpho_packet; ?></td>
                    <td><?php echo $dtb; ?></td>
                    <td><?php echo $ttb; ?></td>
                    <td><?php echo $hfd; ?></td>
                    <td><?php echo $gdlm; ?></td>
                    <td><?php echo $ttk; ?></td>
                    <td><?php echo $formA; ?></td>
                    <td><?php echo $formAp; ?></td>
                    <td><?php echo $poster1; ?></td>
                    <td><?php echo $poster2; ?></td>

		
	 <?php if($priv_materials_edit>=2){ ?>
                <td><a class="btn btn-info" style="text-decoration:none;margin-top:5%;" href="<?php echo $link; ?>">View Quantities</a></td>
	 <?php } ?>				 

		</tr>
<?php
	}
	?>
				</table>
<?php
}else{
	echo "<h3><i>No Boxes have Been Sent.</i></h3>";
}

}else{
	echo "<h3><i>No Boxes Entries have Been Entered.</i></h3>";
    
}
?>	
               </form>

