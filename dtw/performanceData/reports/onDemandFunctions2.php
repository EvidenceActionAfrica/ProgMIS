<?php 

echo '<option value="male">Male</option> <option value="female">Female</option>';
	$drop2=$_GET['drop2'];

	if ($drop2=='gender') {
		echo '<option value="male">Male</option> <option value="female">Female</option>';
	}else if($drop2=='age'){
		echo '<option>2-5</option> <option>6-10</option> <option>11-14</option> <option>15-18</option>';
	}else if($drop2=='enrollment'){
		echo '<option>Enrolled</option> <option>Non Enrolled</option>';
	}
	else if($drop2=='school_type'){
		echo '<option>Public</option> <option>Private</option> <option>Other</option>';
	}
	else if($drop2=='treatment_type'){
		echo ='<option>STH</option> <option>STH And SCHISTO</option>';
	}





 ?>
