
	  <h2 align="center">Packet Calculations</h2>
	  <?php
		$result_set=mysql_query("SELECT * FROM packet_assumptions ORDER BY form_name ASC");
	while($row=mysql_fetch_array($result_set))
	{
	$form_name=$row['form_name'];
	$per_pack=$row['per_pack'];
	$children_per_sheet=$row['children_per_sheet'];
?>
<?php
if ($children_per_sheet!='0'){
?>
<table align="center" border="1" width="50%">
  <tr><th colspan="8" align="center"><?php echo $form_name; ?></th></tr>
  <tr><th>School Enrollment</th><th>1 Pack</th><th>2 Pack</th><th>3 Pack</th><th>4 Pack</th><th>5 Pack</th><th>6 Pack</th><th>7 Pack</th></tr>
  <tr><td>1-100</td><td><?php echo $per_pack*$children_per_sheet; ?></td><td><?php echo 2*$per_pack*$children_per_sheet; ?></td><td><?php echo 3*$per_pack*$children_per_sheet; ?></td><td><?php echo 4*$per_pack*$children_per_sheet; ?></td><td><?php echo 5*$per_pack*$children_per_sheet; ?></td><td><?php echo 6*$per_pack*$children_per_sheet; ?></td><td><?php echo 7*$per_pack*$children_per_sheet; ?></td></tr>
  <tr><td>101-500</td><td><?php echo $per_pack*$children_per_sheet; ?></td><td><?php echo 2*$per_pack*$children_per_sheet; ?></td><td><?php echo 3*$per_pack*$children_per_sheet; ?></td><td><?php echo 4*$per_pack*$children_per_sheet; ?></td><td><?php echo 5*$per_pack*$children_per_sheet; ?></td><td><?php echo 6*$per_pack*$children_per_sheet; ?></td><td><?php echo 7*$per_pack*$children_per_sheet; ?></td></tr>
  <tr><td>501-750</td><td><?php echo $per_pack*$children_per_sheet; ?></td><td><?php echo 2*$per_pack*$children_per_sheet; ?></td><td><?php echo 3*$per_pack*$children_per_sheet; ?></td><td><?php echo 4*$per_pack*$children_per_sheet; ?></td><td><?php echo 5*$per_pack*$children_per_sheet; ?></td><td><?php echo 6*$per_pack*$children_per_sheet; ?></td><td><?php echo 7*$per_pack*$children_per_sheet; ?></td></tr>
  <tr><td>751-1000</td><td><?php echo $per_pack*$children_per_sheet; ?></td><td><?php echo 2*$per_pack*$children_per_sheet; ?></td><td><?php echo 3*$per_pack*$children_per_sheet; ?></td><td><?php echo 4*$per_pack*$children_per_sheet; ?></td><td><?php echo 5*$per_pack*$children_per_sheet; ?></td><td><?php echo 6*$per_pack*$children_per_sheet; ?></td><td><?php echo 7*$per_pack*$children_per_sheet; ?></td></tr>
  <tr><td>1001-1500</td><td><?php echo $per_pack*$children_per_sheet; ?></td><td><?php echo 2*$per_pack*$children_per_sheet; ?></td><td><?php echo 3*$per_pack*$children_per_sheet; ?></td><td><?php echo 4*$per_pack*$children_per_sheet; ?></td><td><?php echo 5*$per_pack*$children_per_sheet; ?></td><td><?php echo 6*$per_pack*$children_per_sheet; ?></td><td><?php echo 7*$per_pack*$children_per_sheet; ?></td></tr>
  <tr><td>1501-2000</td><td><?php echo $per_pack*$children_per_sheet; ?></td><td><?php echo 2*$per_pack*$children_per_sheet; ?></td><td><?php echo 3*$per_pack*$children_per_sheet; ?></td><td><?php echo 4*$per_pack*$children_per_sheet; ?></td><td><?php echo 5*$per_pack*$children_per_sheet; ?></td><td><?php echo 6*$per_pack*$children_per_sheet; ?></td><td><?php echo 7*$per_pack*$children_per_sheet; ?></td></tr>
  <tr><td>2000+</td><td><?php echo $per_pack*$children_per_sheet; ?></td><td><?php echo 2*$per_pack*$children_per_sheet; ?></td><td><?php echo 3*$per_pack*$children_per_sheet; ?></td><td><?php echo 4*$per_pack*$children_per_sheet; ?></td><td><?php echo 5*$per_pack*$children_per_sheet; ?></td><td><?php echo 6*$per_pack*$children_per_sheet; ?></td><td><?php echo 7*$per_pack*$children_per_sheet; ?></td></tr>
</table><hr>
<?php
	}
	else if ($children_per_sheet=='0'){
?>
<table align="center" border="1" width="50%">
  <tr><th colspan="8" align="center"><?php echo $form_name; ?></th></tr>
  <tr><th colspan="8" align="center">1 PER SCHOOL NEEDED. PACK OF 6 SUFFICIENT TO EACH SCHOOL.</th></tr>
</table><hr>
<?php
	}
?>
<?php
	}
?>