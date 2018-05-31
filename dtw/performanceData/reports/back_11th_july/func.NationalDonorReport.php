<?php 

/**
* 
*/

/**
* treatment : none
* table : a_bysch
* nu. of parameters : 2
* discription : find the districts dewormed for sth dpending on the donor
*/

function districtsDewormedByDonor($donor_selected,$treatment){
	
	if ($treatment=='STH') {

		$result=mysql_query("SELECT COUNT(DISTINCT a_bysch.district_id) AS district_count
		FROM a_bysch 
		LEFT JOIN districts 
		ON a_bysch.district_id = districts.district_id 
		WHERE districts.donor = '$donor_selected'") 
		OR die("CANNOT GET STH districts dewormed by ".$donor_selected." a_bysch<br>".mysql_error());

		while ($row=mysql_fetch_assoc($result)) {
			return $sth_districts_completed=$row['district_count'];
		}
	}else{

		$result=mysql_query("SELECT COUNT(DISTINCT a_bysch.district_id) AS district_count
		FROM a_bysch 
		LEFT JOIN districts 
		ON a_bysch.district_id = districts.district_id 
		WHERE districts.donor = '$donor_selected' AND ap_attached='Yes'") 
		OR die("CANNOT GET PZQ districts dewormed by ".$donor_selected." a_bysch<br>".mysql_error());

		while ($row=mysql_fetch_assoc($result)) {
			return $schi_districts_completed=$row['district_count'];
		}
	}
}

function districtsPlannedByDonor($donor_selected,$treatment){

	if ($treatment=='STH') {
		$result=mysql_query("SELECT COUNT(DISTINCT p_bysch.district_id) AS district_count
							FROM p_bysch 
							LEFT JOIN districts 
							ON p_bysch.district_id = districts.district_id 
							WHERE districts.donor = '$donor_selected'") OR die("CANNOT GET district COUNT".$donor_selected." p_bysch<br>".mysql_error());
		while ($row=mysql_fetch_assoc($result)) {
			return $row['district_count'];
		}
		

	}else{
		$result=mysql_query("SELECT COUNT(DISTINCT p_bysch.district_id) AS district_count
							FROM p_bysch 
							LEFT JOIN districts 
							ON p_bysch.district_id = districts.district_id 
							WHERE districts.donor = '$donor_selected' AND p_sch_bilharzia='Y'") OR die("CANNOT GET district COUNT".$donor_selected." p_bysch<br>".mysql_error());
		while ($row=mysql_fetch_assoc($result)) {
			return $row['district_count'];
		}
		
	}
	
}

function schoolsDewormedByDonor($donor_selected,$treatment){

	if ($treatment=='STH') {
		
		$result=mysql_query("SELECT COUNT(DISTINCT school_id) AS school_count
			FROM a_bysch 
			LEFT JOIN districts 
			ON a_bysch.district_id = districts.district_id 
			WHERE districts.donor = '$donor_selected'") 
			OR die("CANNOT GET STH school count dewormed by ".$donor_selected." a_bysch<br>".mysql_error());

		while ($row=mysql_fetch_assoc($result)) {
			return $sth_schools_participated=$row['school_count'];
		}

	}else{

		// Schools participated for PZQ
		$result = mysql_query("SELECT COUNT(DISTINCT school_id) AS school_count FROM a_bysch WHERE ap_attached='Yes'") or die(mysql_error());

		$result=mysql_query("SELECT COUNT(DISTINCT school_id) AS school_count
			FROM a_bysch 
			LEFT JOIN districts 
			ON a_bysch.district_id = districts.district_id 
			WHERE districts.donor = '$donor_selected' AND ap_attached='Yes'") 
			OR die("CANNOT GET school count dewormed by ".$donor_selected." a_bysch<br>".mysql_error());

		while ($row=mysql_fetch_assoc($result)) {
			return $schi_schools_participated=$row['school_count'];
		}
	}
}


/**
* treatment : none
* table : any table
* no. of parameters : many
* parameter values : get the values and add them. 
*                    first parameter is the table, 
*					 Second paremeter is the donor. 
*/
function sumArgsByDonor(){
	
	$args=func_get_args(); // get the args

	$table=array_shift($args); // get and remove the table

	$donor_selected=array_shift($args); // get and remove the donor
	
	$size=sizeof($args); // get number of items in array
	$total=0;
	for ($i=0; $i < $size; $i++) { 
		$total+=sumPlainByDonor($args[$i],$table,$donor_selected);
	}

	return $total;
}


/**
* treatment : sth and shisto
* table : any tanle
* no. of parameters : 2
* parameter values : e.g a_6_m , a_bysch
*/
function sumPlainByDonor($field,$table,$donor_selected){
	$query="SELECT SUM($field) AS dewormed 
			FROM $table
			LEFT JOIN districts 
			ON $table.district_id = districts.district_id 
			WHERE districts.donor = '$donor_selected'";
	$result=mysql_query($query) or die("<h1>cannot get count of".$field."</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['dewormed'];
	}
}


/**
* treatment : none
* table : p_bysch
* no. of parameters : 1
* description: get the planned schools to be dewormed according to the donot districts
*/
function getPlannedSchoolsByDonor($donor_selected){
	// count schools in p_bysch left join districts where donor is the one selected

	$result=mysql_query("SELECT COUNT( p_sch_id ) AS school_count 
		FROM p_bysch 
		LEFT JOIN districts 
		ON p_bysch.district_id = districts.district_id 
		WHERE districts.donor = '$donor_selected'") OR die("CANNOT GET SCHOOL COUNT".$donor_selected." p_bysch<br>".mysql_error());;

		// $row = mysql_fetch_array($result);
		while ($row=mysql_fetch_assoc($result)) {
			return $total_school_count = $row["school_count"];
		}
}

/**
* treatment : PZQ
* table : p_bysch
* no. of parameters : 2
* parameter values : e.g a_6_m , a_bysch
*/
function sumMoreFexibleByDonor($field,$table,$where,$value,$donor_selected){
	$query="SELECT SUM($field) AS dewormed 
			FROM $table
			LEFT JOIN districts 
			ON p_bysch.district_id = districts.district_id 
			WHERE districts.donor = '$donor_selected'
			AND $where = '$value'";
	$result=mysql_query($query) or die("<h1>cannot get count of".$field."</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['dewormed'];
	}
}
// get the teacher trainings

	/**
		* treatment : all
		* table : any
		* no. of parameters : 2
		* parameter values : field and table
		*/
	function numDistinctPlain($field,$table){
		$query="SELECT DISTINCT($field) FROM $table";
		$result=mysql_query($query) or die("<h1>Cannot get distinct".$field."</h1>".mysql_error());

		$num= mysql_num_rows($result);

		return $num;
	}

		function numDistinctFlexible($field,$table,$where,$value){
		$query="SELECT DISTINCT($field) FROM $table WHERE $where = '$value'";
		$result=mysql_query($query) or die("<h1>Cannot get num of ".$field."</h1>".mysql_error());

		$num= mysql_num_rows($result);

		return $num;

	}

	function getAttntTeachers($where){
		$query="SELECT * FROM attnt_bysch WHERE t2_name !='' AND $where='1' ";
		$result=mysql_query($query) or die("<h1>Cannot get num of teachers</h1>".mysql_error());
		$num= mysql_num_rows($result);

		$query2="SELECT * FROM attnt_bysch WHERE t1_name !='' AND $where='1' ";
		$result2=mysql_query($query2) or die("<h1>Cannot get num of teachers</h1>".mysql_error());
		$num2= mysql_num_rows($result2);

		return $num+$num2;
	}








	// county reports
	


 ?>