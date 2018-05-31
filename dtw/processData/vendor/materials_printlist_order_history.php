<?php

date_default_timezone_set("Africa/Nairobi");
if(isset($_GET["activeId"])){

$id=$_GET["activeId"];
//This will turn the active printlist to inactive
//It will also undo all records except the selected one to inactive incase of an error
$sql="select * from materials_printlist_history where id !='$id'";
$resultU=mysql_query($sql);

		while($row=mysql_fetch_array($resultU)){
			$sql="Update materials_printlist_history set status=2 where id=".$row["id"];
			mysql_query($sql);
		}
//After Setting the Records to inactive

$sql="Update materials_printlist_history set status=1 where id=".$id;
mysql_query($sql);
$updateResult="Printlist Order Set";

//Replacing the current Active vendor qoute we need to reference the history data and update vendor quote

$sql="select * from materials_printlist_history_data where printlist_id=".$id;
$resultH=mysql_query($sql);
$append=0;
while($row=mysql_fetch_array($resultH)){

$quantityArray[$append]=$row["print_order_quantity"];
++$append;
}


$count=sizeof($quantityArray);
$append=0;
while($append<=$count){
  $quantity=$quantityArray[$append];
  $materials=$count;
++$append;
$sql="UPDATE `materials_vendor_quote` SET `print_order_quantity`='$quantity',";
$sql.="`print_order_unit_price`=0,`print_order_price`=0,updated_print_order_unit_price=0,updated_print_order_quantity=0,";
$sql.="updated_print_order_price=0,printlist_id='$id' WHERE `id`='$append'";
//echo $sql."<br/>";
mysql_query($sql);

}
$updateResult.="<br/> Vendor Qoute Updated";

header("Location:../processData/materials_packing_strict.php");

}

if(isset($_GET["deleteId"])){

$id=$_GET["deleteId"];
$sql="DELETE from materials_printlist_history where id ='$id' AND status=2";
$resultD=mysql_query($sql) or die(mysql_error());
$result=mysql_affected_rows();

	if($result ==null){
	$updateResult="This Printlist Order is set as Active. It Cannot Be Deleted";
	}else{
	$updateResult="Printlist Order Deleted";

$sql="DELETE from materials_printlist_history_data where printlist_id ='$id'";

mysql_query($sql);
	}


}
// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_materials_edit= $row['priv_materials_edit'];
}

?>
<form method="post">
  <h2 id="h2info"style="background:#bada66;"><?php echo $updateResult;  ?></h2>
	<table align="center" class="table table-bordered table-condensed  table-hover">
	   <tr>
	   	<th>Printlist Id</th>
	   	 <th>Vendor Id</th>
	   	 <th>Vendor Name</th>
	   	 <th>Prepared By</th>
	   	 <th>Created On</th>
	   	 <th>Active</th>
	   	   <?php if($priv_materials_edit>=3){ ?>
	   	 <th>Set As Active</th>
	   	   <?php }?>
	   	</tr>
	   	<?php
	   	$sql="select * from materials_printlist_history ORDER BY id DESC";
	   	$result=mysql_query($sql);
	   	while($row=mysql_fetch_array($result)){
	   	
			   if($row["status"]==1){
			   	$active="YES";
			   	  echo "<tr style='background:#bada66;'>";
			   }else{
			   	$active="NO";
			   	echo " <tr>";
			   }
			   $unixDate=$row["time_set"];
			   $year=date('Y',$unixDate);
			   $month=date('M',$unixDate);
               $day=date('d',$unixDate);
               $suffix=date('S',$unixDate);
			   $hour=date('g',$unixDate);
			//   $min=date('i',$unixDate);
			   $setTime=date('A',$unixDate);
			   $dayWeek=date('l',$unixDate);


               $date=$day."<sup>".$suffix."</sup> ".$month." ".$year." -".$hour." ".$setTime." ".$dayWeek;
			  // $date=$row["date"];

	   		?>
	 
	   		   <td><?php echo $row["id"]; ?></td>
	   		   <td><?php echo $row["vendor_id"]; ?></td>
			   <td><?php echo $row["vendor_name"]; ?></td>
			   <td><?php echo $row["prepared_by"]; ?></td>
			   <td><?php echo $date; ?></td>
			   <td><?php echo $active; ?></td>
			      <?php if($priv_materials_edit>=3){ ?>
			   <td><a href="javascript:void(0)" onclick="setActive(<?php echo $row['id']; ?>)"><img src="../images/icons/view2.png" height="20px"/></a></td>
			    <?php }?>
	   </tr>
	   <?php
			}
		?>

	   </table>
</form>
<script>
 function setActive(id) {
      if (confirm("Are you sure you want to Set This Vendor's Printlist As Active?")) {
        location.replace('?activeId=' + id);
      } else {
        return false;
      }
    }
 function show_confirm(deleteid) {
      if (confirm("Are you sure you want to delete?")) {
        location.replace('?deleteId=' + deleteid);
      } else {
        return false;
      }
    }
</script>