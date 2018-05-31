<?php

/**
 * treatment : none
 * table : any table
 * no. of parameters : many
 * parameter values : get the values and add them. 
 *                    first parameter is the table, 
 * 					 Second paremeter is the donor. 
 */
function sumArgsByCounty() {

  $args = func_get_args(); // get the args

  $table = array_shift($args); // get and remove the table

  $county = array_shift($args); // get and remove the donor

  $size = sizeof($args); // get number of items in array
  $total = 0;
  for ($i = 0; $i < $size; $i++) {
    $total+=sumPlainByCounty($args[$i], $table, $county);
  }

  return $total;
}


function sumArgsByCountyOpenSchools() {

  $args = func_get_args(); // get the args

  $table = array_shift($args); // get and remove the table

  $county = array_shift($args); // get and remove the donor

  $size = sizeof($args); // get number of items in array
  $total = 0;
  for ($i = 0; $i < $size; $i++) {
    $total+=sumPlainByCountyOpenSchools($args[$i], $table, $county);
  }

  return $total;
}

/**
 * treatment : sth and shisto
 * table : any tanle
 * no. of parameters : 2
 * parameter values : e.g a_6_m , a_bysch
 */
function sumPlainByCounty($field, $table, $county) {
  $query = "SELECT SUM($field) AS dewormed 
			FROM $table
			WHERE county_name = '$county'";
  $result = mysql_query($query) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['dewormed'];
  }
}

function sumPlainByCountyOpenSchools($field, $table, $county) {
  $query = "SELECT SUM($field) AS dewormed 
			FROM $table
			WHERE county_name = '$county' AND p_sch_closed= 'No' ";
  $result = mysql_query($query) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['dewormed'];
  }
}
/**
 * treatment : PZQ
 * table : p_bysch
 * no. of parameters : 2
 * parameter values : e.g a_6_m , a_bysch
 */
function sumMoreFexibleByCounty($field, $table, $where, $value, $and, $value2) {
  $query = "SELECT SUM($field) AS dewormed 
			FROM $table
			WHERE $where = '$value'
			AND $and = '$value2'";
  $result = mysql_query($query) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['dewormed'];
  }
}

function sumMoreFexibleByCounty2($field, $table, $where, $value, $and, $value2, $and2, $value3) {
  $query = "SELECT SUM($field) AS dewormed 
			FROM $table
			WHERE $where = '$value'
			AND $and = '$value2' 
			AND $and2 = '$value3' ";
  $result = mysql_query($query) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['dewormed'];
  }
}

function CountFlexible($field, $table, $where, $value) {
  $query = "SELECT COUNT($field) AS number FROM $table WHERE $where = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['number'];
  }
}

function CountDistinctFlexible($field, $table, $where, $value) {
  $query = "SELECT distinct($field) AS number FROM $table WHERE $where = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function CountMoreFlexible($field, $table, $where, $value, $and, $value2) {
  $query = "SELECT COUNT($field) AS number FROM $table WHERE $where = '$value' AND $and = '$value2'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['number'];
  }
}

function CountMoreFlexible2($field, $table, $where, $value, $and, $value2, $and2, $value3) {
  $query = "SELECT COUNT($field) AS number FROM $table WHERE $where = '$value' AND $and = '$value2' AND $and2 = '$value3'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['number'];
  }
}

function CountDistinctMoreFlexible($field, $table, $where, $value, $and, $value2) {
  $query = "SELECT distinct($field) AS number FROM $table WHERE $where = '$value' AND $and = '$value2'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

/**
 * treatment : none
 * table : p_bysch
 * no. of parameters : 1
 * description: get the planned schools to be dewormed 
 */
function getPlannedSchools($county) {
  // count schools in p_bysch  where donor is the one selected

  $query = "SELECT COUNT( p_sch_id ) AS school_count FROM p_bysch where p_sch_closed='No' AND county_name ='$county'";
  $result = mysql_query($query) OR die("CANNOT GET SCHOOL COUNT p_bysch<br>" . mysql_error());
  ;

  // $row = mysql_fetch_array($result);
  while ($row = mysql_fetch_assoc($result)) {
    return $total_school_count = $row["school_count"];
  }
}

function getAttntTeachersSTH($county_name) {
  $query = "SELECT * FROM attnt_bysch WHERE t2_name !='' AND county = '$county_name' ";
  $result = mysql_query($query) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num = mysql_num_rows($result);

  $query2 = "SELECT * FROM attnt_bysch WHERE t1_name !='' AND county = '$county_name'";
  $result2 = mysql_query($query2) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num2 = mysql_num_rows($result2);

  return $num + $num2;
}

function getAttntTeachers($county_name,$where) {
  $query = "SELECT * FROM attnt_bysch WHERE t2_name !='' AND $where='1' AND county = '$county_name' ";
  $result = mysql_query($query) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num = mysql_num_rows($result);

  $query2 = "SELECT * FROM attnt_bysch WHERE t1_name !='' AND $where='1' AND county = '$county_name' ";
  $result2 = mysql_query($query2) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num2 = mysql_num_rows($result2);

  return $num + $num2;
}

?>