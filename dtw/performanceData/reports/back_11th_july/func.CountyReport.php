<?php 
/**
* treatment : none
* table : any table
* no. of parameters : many
* parameter values : get the values and add them. 
*                    first parameter is the table, 
*					 Second paremeter is the donor. 
*/
function sumArgsByCounty(){
	
	$args=func_get_args(); // get the args

	$table=array_shift($args); // get and remove the table

	$county=array_shift($args); // get and remove the donor
	
	$size=sizeof($args); // get number of items in array
	$total=0;
	for ($i=0; $i < $size; $i++) { 
		$total+=sumPlainByCounty($args[$i],$table,$county);
	}

	return $total;
}

/**
* treatment : sth and shisto
* table : any tanle
* no. of parameters : 2
* parameter values : e.g a_6_m , a_bysch
*/
function sumPlainByCounty($field,$table,$county){
	$query="SELECT SUM($field) AS dewormed 
			FROM $table
			WHERE county_name = '$county'";
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
function sumMoreFexibleByCounty($field,$table,$where,$value,$and,$value2){
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



 ?>