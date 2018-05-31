<?php 




//if (isset($_GET['drop'])) {
	# code...
	$drop=$_GET['drop'];

	if ($drop=='age') {
		echo '<option value="gender">Gender</option> <option value="enrollment">Enrollment</option> <option value="school_type">School Type</option> <option value="treatment_type">Treatement Type</option> ';
	}else if($drop=='gender'){
		echo '<option value="enrollment">Enrollment</option> <option value="school_type">School Type</option> <option value="treatment_type">Treatement Type</option> ';
	}else if($drop=='enrollment'){
		echo '<option value="gender">Gender</option>  <option value="school_type">School Type</option> <option value="treatment_type">Treatement Type</option> ';
	}else if($drop=='school_type'){
		echo '<option value="gender">Gender</option> <option value="enrollment">Enrollment</option>  <option value="treatment_type">Treatement Type</option> ';
	}else if($drop=='treatment_type'){
		echo '<option value="gender">Gender</option> <option value="enrollment">Enrollment</option> <option value="school_type">School Type</option>  ';
	}
//}





// echo '<option value="gender">Gender</option> <option value="age">Age</option> <option value="enrollment">Enrollment</option> <option value="school_type">School Type</option> <option value="treatment_type">Treatement Type</option> ';
 ?>
