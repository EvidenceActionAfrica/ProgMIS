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
function districtsDewormed($treatment) {

  if ($treatment == 'STH') {

    $query = "SELECT COUNT(DISTINCT district_id) AS district_count FROM a_bysch";
    $result = mysql_query($query) OR die("CANNOT GET STH districts dewormed a_bysch<br>" . mysql_error());

    while ($row = mysql_fetch_assoc($result)) {
      return $sth_districts_completed = $row['district_count'];
    }
  } else {

    $query = "SELECT COUNT(DISTINCT district_id) AS district_count FROM a_bysch WHERE ap_attached='Yes'";
    $result = mysql_query($query) OR die("CANNOT GET PZQ districts dewormed by a_bysch<br>" . mysql_error());

    while ($row = mysql_fetch_assoc($result)) {
      return $schi_districts_completed = $row['district_count'];
    }
  }
}

function districtsPlanned($treatment) {

  if ($treatment == 'STH') {
    $query = "SELECT COUNT(DISTINCT district_id) AS district_count FROM p_bysch";
    $result = mysql_query($query) OR die("CANNOT GET district p_bysch<br>" . mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
      return $row['district_count'];
    }
  } else {
    $query = "SELECT COUNT(DISTINCT district_id) AS district_count FROM p_bysch WHERE p_sch_bilharzia='Y'";
    $result = mysql_query($query) OR die("CANNOT GET district COUNT p_bysch<br>" . mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
      return $row['district_count'];
    }
  }
}

function schoolsDewormed($treatment) {

  if ($treatment == 'STH') {

    $query = "SELECT COUNT(DISTINCT school_id) AS school_count FROM a_bysch";
    $result = mysql_query($query) OR die("CANNOT GET STH school count dewormed a_bysch<br>" . mysql_error());

    while ($row = mysql_fetch_assoc($result)) {
      return $sth_schools_participated = $row['school_count'];
    }
  } else {

    // Schools participated for PZQ
    $query = "SELECT COUNT(DISTINCT school_id) AS school_count FROM a_bysch WHERE ap_attached='Yes' ";
    $result = mysql_query($query) OR die("CANNOT GET school count dewormed by a_bysch<br>" . mysql_error());

    while ($row = mysql_fetch_assoc($result)) {
      return $schi_schools_participated = $row['school_count'];
    }
  }
}

/**
 * treatment : none
 * table : any table
 * no. of parameters : many
 * parameter values : get the values and add them. 
 *                    first parameter is the table, 
 *           Second paremeter is the donor. 
 */
function sumArgs() {

  $args = func_get_args(); // get the args

  $table = array_shift($args); // get and remove the table

  $size = sizeof($args); // get number of items in array
  $total = 0;
  for ($i = 0; $i < $size; $i++) {
    $total+=sumPlain($args[$i], $table);
  }

  return $total;
}

/**
 * treatment : sth and shisto
 * table : any tanle
 * no. of parameters : 2
 * parameter values : e.g a_6_m , a_bysch
 */
function sumPlain($field, $table) {
  $query = "SELECT SUM($field) AS dewormed FROM $table ";
  $result = mysql_query($query) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['dewormed'];
  }
}

/**
 * treatment : none
 * table : p_bysch
 * no. of parameters : 1
 * description: get the planned schools to be dewormed 
 */
function getPlannedSchools() {
  // count schools in p_bysch  where donor is the one selected

  $query = "SELECT COUNT( p_sch_id ) AS school_count FROM p_bysch";
  $result = mysql_query($query) OR die("CANNOT GET SCHOOL COUNT p_bysch<br>" . mysql_error());
  ;

  // $row = mysql_fetch_array($result);
  while ($row = mysql_fetch_assoc($result)) {
    return $total_school_count = $row["school_count"];
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

function CountPlain($field, $table) {
  $query = "SELECT COUNT($field) AS number FROM $table";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['number'];
  }
}

function CountDistinctPlain($field, $table) {
  $query = "SELECT distinct($field) AS number FROM $table";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

/**
 * treatment : PZQ
 * table : p_bysch
 * no. of parameters : 2
 * parameter values : e.g a_6_m , a_bysch
 */
function sumMoreFexible($field, $table, $where, $value) {
  $query = "SELECT SUM($field) AS dewormed FROM $table WHERE $where = '$value'";
  $result = mysql_query($query) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
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
function numDistinctPlain($field, $table) {
  $query = "SELECT DISTINCT($field) FROM $table";
  $result = mysql_query($query) or die("<h1>Cannot get distinct" . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numDistinctFlexible($field, $table, $where, $value) {
  $query = "SELECT DISTINCT($field) FROM $table WHERE $where = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

/**
 * Description : get the number of attnt teachers.
 *
 * @param string  $where
 * @return int $num+$num2;
 */
function getAttntTeachersSTH() {
  $query = "SELECT * FROM attnt_bysch WHERE t1_name !='' ";
  $result = mysql_query($query) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num = mysql_num_rows($result);

  $query2 = "SELECT * FROM attnt_bysch WHERE t2_name !='' ";
  $result2 = mysql_query($query2) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num2 = mysql_num_rows($result2);

  $total = $num + $num2;
  return $total;
}

function getAttntTeachers($treatmenttype) {
  $query = "SELECT * FROM attnt_bysch WHERE t1_name !='' AND $treatmenttype='1' ";
  $result = mysql_query($query) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num = mysql_num_rows($result);
  number_format($num);

  $query2 = "SELECT * FROM attnt_bysch WHERE t2_name !='' AND $treatmenttype='1' ";
  $result2 = mysql_query($query2) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num2 = mysql_num_rows($result2);
  number_format($num2);

  $total = $num + $num2;
  return $total;
}

/**
 * Description : get the number of teacher trainings.
 *
 * @param string  $where
 * @return int $num
 */
function getTeacherTrainingSession($where) {
  $query = "SELECT * FROM attnt_bysch WHERE $where ='1' GROUP BY attnt_id";
  $result = mysql_query($query) or die("<h1>Cannot get num of traininf sessions</h1>" . mysql_error());
  $num = mysql_num_rows($result);

  return $num;
}

function getTeacherTrainingSession2($where) {
  $query = "SELECT * FROM attnt_bysch WHERE $where ='1' or $where='0' GROUP BY attnt_id";
  $result = mysql_query($query) or die("<h1>Cannot get num of traininf sessions</h1>" . mysql_error());
  $num = mysql_num_rows($result);

  return $num;
}

// county reports
?>