<?php 

include "includes/config.php";


function districtsPlanned(){

	$query="SELECT DISTINCT district FROM form_mt";

	$result=mysql_query($query) or die("<h1>Cannot get districts Here</h1>".mysql_error());



	$num=mysql_num_rows($result);



	return $num;

}



/**
*
* This function takes the field andtable
*
* This sums the field and returns it
*
*/

function sum($field,$table){

	$query="SELECT SUM($field) AS field FROM $table";

	$result=mysql_query($query) or die("<h1>Cannot get ".$field."</h1>".mysql_error());



	while ($row=mysql_fetch_assoc($result)) {

		return $row['field'];

	}

	

}



/**

* Gets number of rows

* takes the field name and table

*/

function num($field,$table){

	$query = "SELECT $field FROM $table";

	$result=mysql_query($query) or die("<h1>Cannot get".$field."</h1>".mysql_error());



	$num= mysql_num_rows($result);



	return $num;

}



function averageSchoolsPerTT(){

	// get the sum of teacher Trainigs

	$tt=sum('training_sessions','form_mt_district_summary');



	// get the num ofschools

	$schools=num('school_name','form_p_school_list');



	// find average

	$average=$tt/$schools;



	return $average;



}



function averageBtwnTTAndDewormingDay(){



}



function schoolType($type){

	$query="SELECT school_type FROM form_p_school_list WHERE school_type='$type'";

	$result=mysql_query($query) or die("<h1>Cant find School type</h1>".mysql_error());



	$num= mysql_num_rows($result);



	return $num;

}



function averageEnrolledPerSchool(){

	// number of all enrolled

	$primary=sum('ecd_pri_school_enrollment','form_p_school_list');

	$ecd=sum('ecd_attached_enrollment','form_p_school_list');

	$sum=$primary+$ecd;



	// get the num ofschools

	$schools=num('school_name','form_p_school_list');



	$av=$sum/$schools;



	return $av;

}



function averagePerSchool($field,$table){

	$sum=sum($field,$table);



	// get the num ofschools

	$schools=num('school_name','form_p_school_list');



	$av=$sum/$schools;



	return $av;



}



function markup20($value){

	$value=$value*0.2;



	$finalValue=$value+$value;



	return $finalValue;

}











 ?>