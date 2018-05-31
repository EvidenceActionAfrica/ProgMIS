<?php 
/**
* treatment : none
* table : any table
* no. of parameters : many
* parameter values : get the values and add them. 
*                    first parameter is the table, 
*					 Second paremeter is the district. 
*/
function sumArgsByDistrict(){
	
	$args=func_get_args(); // get the args

	$table=array_shift($args); // get and remove the table

	$district=array_shift($args); // get and remove the district
	
	$size=sizeof($args); // get number of items in array
	$total=0;
	// loop through the args array and run each field through the function
	// then add and store the amount gotten in the variable total
	for ($i=0; $i < $size; $i++) { 
		$total+=sumPlainByDistrict($args[$i],$table,$district);
	}

	return $total;
}

function getCountyName($district_id){
	$query="SELECT county FROM districts WHERE district_id ='$district_id'";
	$result=mysql_query($query) or die(mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		// return $row['county'];
	}
	return "sdcsdc";
}

/**
* treatment : sth and shisto
* table : any table
* no. of parameters : 2
* parameter values : e.g a_6_m , a_bysch
*/
function sumPlainByDistrict($field,$table,$district){
	$query="SELECT SUM($field) AS dewormed 
			FROM $table
			WHERE district_id = '$district'";
	$result=mysql_query($query) or die("<h1>cannot get count of".$field."</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['dewormed'];
	}
}

/**
* treatment : PZQ
* table : p_bysch
* no. of parameters : 2
* parameter values : e.g a_6_m , a_bysch
*/
function sumMoreFexibleByDistrict($field,$table,$where,$value,$and,$value2){
	$query="SELECT SUM($field) AS dewormed 
			FROM $table
			WHERE $where = '$value'
			AND $and = '$value2'";
	$result=mysql_query($query) or die("<h1>cannot get count of".$field."</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['dewormed'];
	}
}

function CountFlexible($field,$table,$where,$value){
	$query="SELECT COUNT($field) AS number FROM $table WHERE $where = '$value'";
	$result=mysql_query($query) or die("<h1>Cannot get num of ".$field."</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['number'];
	}

}

function CountDistinctFlexible($field,$table,$where,$value){
	$query="SELECT distinct($field) AS number FROM $table WHERE $where = '$value'";
	$result=mysql_query($query) or die("<h1>Cannot get num of ".$field."</h1>".mysql_error());
	
	$num= mysql_num_rows($result);

	return $num;

}

function CountMoreFlexible($field,$table,$where,$value,$and,$value2){
	$query="SELECT COUNT($field) AS number FROM $table WHERE $where = '$value' AND $and = '$value2'";
	$result=mysql_query($query) or die("<h1>Cannot get num of ".$field."</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['number'];
	}

}

function CountDistinctMoreFlexible($field,$table,$where,$value,$and,$value2){
	$query="SELECT distinct($field) AS number FROM $table WHERE $where = '$value' AND $and = '$value2'";
	$result=mysql_query($query) or die("<h1>Cannot get num of ".$field."</h1>".mysql_error());

	$num= mysql_num_rows($result);

	return $num;

}


/**
* Count the number of any field
* Takes in a field and table
*/
	function countDistricts($field,$table){
		$query="SELECT $field FROM $table";
		$result=mysql_query($query) or die("<h1>Cannot get ".$field."</h1>".mysql_error());

		$num= mysql_num_rows($result);

		return $num;
	}


// checks is there is data for sth or pzq
if (isset($_POST['check_district'])) {
	include "../../includes/config.php";
	$district=$_POST['district_id'];
	$treatment=$_POST['treatment'];

	if ($treatment=='albe') {
		$sum=(int)CountFlexible('district_id','a_bysch','district_id',$district);
	
		if ($sum>0) {
			echo 1;
		}else{
			echo 0;
		}
	}else{
		$value='Yes';

		$sum=(int)CountMoreFlexible('district_id','a_bysch','ap_attached',$value,'district_id',$district);
	
		if ($sum>0) {
			echo 1;
		}else{
			echo 0;
		}
	}

	
	
}

// checks is there is data for sth or pzq
if (isset($_POST['check_county'])) {
	include "../../includes/config.php";
	$countyname=$_POST['countyname'];
	$treatment=$_POST['treatment'];

	if ($treatment=='albe') {
		$sum=(int)CountFlexible('county_name','a_bysch','county_name',$countyname);
	
		if ($sum>0) {
			echo 1;
		}else{
			echo 0;
		}
	}else{
		$value='Yes';

		$sum=(int)CountMoreFlexible('county_name','a_bysch','ap_attached',$value,'county_name',$countyname);
	
		if ($sum>0) {
			echo 1;
		}else{
			echo 0;
		}
	}

	
	
}



 ?>