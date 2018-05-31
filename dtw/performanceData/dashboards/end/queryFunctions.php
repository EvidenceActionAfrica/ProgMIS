<?php

//require_once ('../../includes/config.php');

/**
 * Gets the distinct count of
 * given field
 * with specified treatment
 */
function numDistinct($field, $table, $treatment) {
  $query = "SELECT DISTINCT($field) FROM $table WHERE ap_attached = '$treatment'";
  $result = mysql_query($query) or die("<h1>Cannot get distinct</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numDistinctS($field, $table, $treatment) {
  $query = "SELECT DISTINCT($field) FROM $table WHERE sp_attached = '$treatment'";
  $result = mysql_query($query) or die("<h1>Cannot get distinct</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numDistinctDonor1($field, $table, $treatment, $where, $value) {
  $query = "SELECT DISTINCT($field) FROM $table WHERE ap_attached = '$treatment' AND $where = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot get distinct</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

/**
 * More flexible num distinct
 */
function numFlexible($field, $table, $where, $value) {
  $query = "SELECT $field FROM $table WHERE $where = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numFlexible1($field, $table, $where, $value, $where1) {
  $query = "SELECT $field FROM $table WHERE $where = '$value' AND $where1 = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numFlexible2($field, $table, $where, $value, $where1) {
  $query = "SELECT $field FROM $table WHERE $where = '$value' OR $where1 = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numFlexibleDonor2($field, $table, $where, $value, $where1, $value1) {
  $query = "SELECT $field FROM $table WHERE ($where = '$value' OR $where1 = '$value') AND donor ='$value1'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numFlexible3($field, $table, $where, $value, $where1, $value1) {
  $query = "SELECT DISTINCT($field)  FROM $table WHERE $where = '$value' AND $where1 > '$value1'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numFlexibleDonor1($field, $table, $where, $value, $where1, $value1) {
  $query = "SELECT $field FROM $table WHERE $where = '$value' AND $where1 = '$value1'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numFlexibleDonor12($field, $table, $where, $value, $where1, $value1, $where2, $value2) {
  $query = "SELECT $field FROM $table WHERE $where = '$value' AND $where1 = '$value1' AND $where2 = '$value2'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numFlexibleDonor($field, $table, $where, $where2, $value, $where1, $value1) {
  $query = "SELECT $field FROM $table WHERE $where = '$value' AND $where2 = '$value' AND $where1 = '$value1'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numJoin($where, $value, $where1, $value1) {

  $query = "SELECT a_bysch.school_id FROM a_bysch INNER JOIN p_bysch ON a_bysch.school_id=p_bysch.p_sch_id
        WHERE $where = '$value' AND $where1 = '$value1'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . school_id . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numJoinDonor($where, $value, $where1, $value1, $value2) {

  $query = "SELECT a_bysch.school_id FROM a_bysch_with_donor INNER JOIN p_bysch ON a_bysch.school_id=p_bysch.p_sch_id
        WHERE $where = '$value' AND $where1 = '$value1' AND donor = '$value2'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . school_id . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

//performed Deworming
function numJoin1() {
  $query = "SELECT s_prog_sch_id FROM s_bysch INNER JOIN p_bysch WHERE s_bysch.s_deworming_day = p_bysch.p_deworming_day";
  $result = mysql_query($query) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num = mysql_num_rows($result);

  return $num;
}

// made TO OOP
function numDistinctFlexibleDonor($field, $table, $where, $value, $where1, $value1) {
  $query = "SELECT DISTINCT($field) FROM $table WHERE $where = '$value'AND $where1= '$value1'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numDistinctFlexible($field, $table, $where, $value) {
  $query = "SELECT DISTINCT($field) FROM $table WHERE $where = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

// #attnt functions

function numAttntFlex($by, $field1, $value1, $field2, $value2, $field3, $value3) {
  $query = "SELECT DISTINCT($by) FROM attnt_bysch WHERE $field1 = $value1 AND $field2 = $value2 AND $field3 = $value3";

  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field1 . " and " . $field2 . " and " . $field3 . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numAttntFlexDonor($by, $field1, $value1, $field2, $value2, $field3, $value3, $field4, $value4) {
  $query = "SELECT DISTINCT($by) FROM attnt_bysch_with_donor WHERE $field1 = $value1 AND $field2 = $value2 AND $field3 = $value3 AND $field4 = '$value4'";

  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field1 . " and " . $field2 . " and " . $field3 . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numAttntFlex2($by, $field1, $value1, $field2, $value2) {
  $query = "SELECT DISTINCT($by) FROM attnt_bysch WHERE $field1 = $value1 AND $field2 = $value2";

  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field1 . " and " . $field2 . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numAttntFlex4($by, $field1, $value1, $field2, $value2, $field3, $value3, $field4, $value4) {
  $query = "SELECT school_id	 FROM attnt_bysch WHERE $field1 = $value1 AND $field2 = $value2 AND $field3 = $value3 AND $field4 = '$value4' GROUP BY $by";

  //
  // die();

  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field1 . " and " . $field2 . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numAttntFlex3($by, $field1, $value1, $field2, $value2, $field3, $value3) {
  $query = "SELECT school_id	 FROM attnt_bysch WHERE $field1 = $value1 AND $field2 = $value2 AND $field3 = $value3 GROUP BY $by";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field1 . " and " . $field2 . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numAttntFlex4Donor($by, $field1, $value1, $field2, $value2, $field3, $value3, $field4, $value4, $field5, $value5) {
  $query = "SELECT school_id	 FROM attnt_bysch_with_donor WHERE $field1 = $value1 AND $field2 = $value2 AND $field3 = $value3 AND $field4 = '$value4' AND $field5 = '$value5' GROUP BY $by";

  //
  // die();

  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field1 . " and " . $field2 . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numAttntFlex3Donor($by, $field1, $value1, $field2, $value2, $field3, $value3, $field4, $value4) {
  $query = "SELECT school_id	 FROM attnt_bysch_with_donor WHERE $field1 = $value1 AND $field2 = $value2 AND $field3 = $value3 AND $field4 = '$value4' GROUP BY $by";

  //
  // die();

  $result = mysql_query($query) or die("<h1>Cannot get num of " . $field1 . " and " . $field2 . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

/**
 * treatment : none
 * table : attnt_bysch
 * no. of parameters : none
 * parameter values : none
 */
function attntWithCriticalMaterials($school = false) {

  if ($school = !false) {
    $school = 'attnt_id';
  } else {
    $school = 'school_id';
  }
  $row37 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '0'));
  $row44 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', 'Treating for Bilharzia'));

  $withCriticalMaterials = remove_comma($row37) + remove_comma($row44);

  return $withCriticalMaterials;
}

// current
/**
 * treatment : none
 * table : attnt_bysch
 * no. of parameters : none
 * parameter values : none
 */
function attntNoCriticalMaterials() {

  $row24 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '0'));
  $row27 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '1'));
  $row30 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '1', 'attnt_total_forms', '0'));
  $row33 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '1', 'attnt_total_forms', '1'));
  $row36 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '0'));
  $row38 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', 'Treating for Bilharzia'));
  $row42 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '0'));

  $noCriticalMaterials = remove_comma($row24) + remove_comma($row27) + remove_comma($row30) + remove_comma($row33) + remove_comma($row36) + remove_comma($row38) + remove_comma($row42);

  return $noCriticalMaterials;
}

/**
 * treatment : shisto
 * table : s_bysch
 * no. of parameters : 2
 * description : count school types for shisto schools
 * note : we have sp_attached because its looking in s_bysch table
 */
function numSchoolTypeS($type, $treatment) {
  $query = "SELECT s_prog_sch_id from s_bysch WHERE s1_school_type ='$type' AND sp_attached='$treatment'";
  $result = mysql_query($query) or die("<h1>Cannot get num of schools </h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

//'p_sch_id', 'p_bysch', 'p_sch_bilharzia', 'Y', 'p_sch_closed', 'No','p_sch_type','Public'
function numSchoolType($value) {
  $query = "SELECT p_sch_id FROM p_bysch WHERE p_sch_bilharzia = 'Y' AND p_sch_closed = 'No' AND p_sch_type = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot get num of p_sch_id</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numSchoolTypeDonor($value, $value2) {
  $query = "SELECT p_sch_id FROM p_bysch_with_donor WHERE p_sch_bilharzia = 'Y' AND p_sch_closed = 'No' AND p_sch_type = '$value' AND donor='$value2'";
  $result = mysql_query($query) or die("<h1>Cannot get num of p_sch_id</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numSchoolTypeSDonor($type, $treatment, $value) {
  $query = "SELECT s_prog_sch_id from s_bysch_with_donor WHERE s1_school_type ='$type' AND sp_attached='$treatment' AND donor='$value'";
  $result = mysql_query($query) or die("<h1>Cannot get num of schools </h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

/**
 * treatment : shisto
 * table : p_bysch
 * no. of parameters : 2
 * description : count shisto $field
 */
function numDistinctP($field, $treatment) {
  $query = "SELECT DISTINCT($field) FROM p_bysch WHERE p_sch_bilharzia = '$treatment'";
  $result = mysql_query($query) or die("<h1>Cannot get distinct" . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function numDistinctPDonor($field, $treatment, $value) {
  $query = "SELECT DISTINCT($field) FROM p_bysch_with_donor WHERE p_sch_bilharzia = '$treatment' AND donor = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot get distinct" . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

/**
 * treatment : all
 * table : any
 * no. of parameters : 2
 * description : counts the distinct given field
 */
function numDistinctPlain($field, $table) {
  $query = "SELECT DISTINCT($field) FROM $table";
  $result = mysql_query($query) or die("<h1>Cannot get distinct" . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

//sum the given field for the given table where given where equal to given value

function numDistinctDonor($field, $table, $where, $value) {
  $query = "SELECT DISTINCT($field) FROM $table WHERE $where = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot get distinct" . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

/**
 * Count the number of any field
 * Takes in a field and table
 */
function num($field, $table) {
  $query = "SELECT $field FROM $table";
  $result = mysql_query($query) or die("<h1>Cannot get " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

// function num for donor
function numDonor($field, $table, $where, $value) {
  $query = "SELECT $field FROM $table WHERE $where = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot get " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

/**
 * find number by using a search term
 */
function numTerm($term, $table, $field) {
  $query = "SELECT $field FROM $table WHERE $field='$term'";
  $result = mysql_query($query) or die("<h1>Cannot get" . $term . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function EstimatedTotalSTH() {
  $query = "SELECT
				SUM(p_pri_enroll)+
				SUM(p_ecd_enroll)+
				SUM(p_ecd_sa_enroll) as EstimatedTotalSTH FROM p_bysch WHERE p_sch_bilharzia='N' ";
  $result = mysql_query($query) or die("<h1>Cannot get estimated population from form_p_school_list</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['EstimatedTotalSTH'];
  }
}

/**
 * Only for primary, not for ECD
 */
function EstimatedTotalSHISTO() {
  $query = "SELECT
				SUM(p_pri_enroll)+
				SUM(p_ecd_enroll)+
				SUM(p_ecd_sa_enroll)
				as EstimatedTotalSTH FROM p_bysch WHERE p_sch_bilharzia='Y' ";
  $result = mysql_query($query) or die("<h1>Cannot get estimated population from form_p_school_list</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['EstimatedTotalSTH'];
  }
}

//
function EstimatedTotalSHISTOdonor($value) {
  $query = "SELECT
				SUM(p_pri_enroll)+
				SUM(p_ecd_enroll)+
				SUM(p_ecd_sa_enroll)
				as EstimatedTotalSTH FROM p_bysch_with_donor WHERE p_sch_bilharzia='Y' AND donor='$value' ";
  $result = mysql_query($query) or die("<h1>Cannot get estimated population from form_p_school_list</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['EstimatedTotalSTH'];
  }
}

/**
 * treatment : shisto or sth
 * table : a_bysch or s_bysch
 * no. of parameters : 3
 * description: sum field in given table depending on the ap_attached. Mostly its shisto
 */
function sum($field, $table, $treatement) {
  $query = "SELECT SUM($field) AS dewormed FROM $table WHERE ap_attached = '$treatement'";
  $result = mysql_query($query) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['dewormed'];
  }
}

/**
 * treatment : sth and shisto
 * table : any table
 * no. of parameters : 2
 * description: sum the given field for the given table
 */
function sumPlain($field, $table) {
  $query = "SELECT SUM($field) AS dewormed FROM $table";
  $result = mysql_query($query) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['dewormed'];
  }
}

//sum the given field for the given table where(given $where) for given value
function sumDonor($field, $table, $where, $value) {
  $query = "SELECT SUM($field) AS donor_value FROM $table WHERE $where = '$value'";
  $result = mysql_query($query) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['donor_value'];
  }
}

function sumDonorJoin($field) {
  $query = "SELECT SUM($field) AS donor_value FROM form_mt INNER JOIN districts ON form_mt.division_id=districts.division_id ";
  $result = mysql_query($query) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['donor_value'];
  }
}

/**
 * treatment : sth or shisto
 * table : any table
 * no. of parameters : 2
 * description: sum the given field for the given table
 */
function sumFlexible($field, $table, $where, $value) {
  $query = "SELECT SUM($field) FROM $table WHERE $where = '$value'";
  $result = mysql_query($query) or die("<h1>Function name : sumFlexible. <br/>Cannot get sum of " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function sumMaleFormA() {
  $query = "SELECT SUM(a_ecd_m)+
					   SUM(a_2_m)+
					   SUM(a_6_m)+
					   SUM(a_11_m)+
					   SUM(a_15_m)+
					   SUM(a_trt_m) AS sumMaleFormA FROM a_bysch";
  $result = mysql_query($query) or die("<h1>Cannt get count of males</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumMaleFormA'];
  }
}

function sumFemaleFormA() {
  $query = "SELECT SUM(a_ecd_f)+
					   SUM(a_2_f)+
					   SUM(a_6_f)+
					   SUM(a_11_f)+
					   SUM(a_15_f)+
					   SUM(a_trt_f) AS sumMaleFormA FROM a_bysch";
  $result = mysql_query($query) or die("<h1>Cannt get count of males</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumMaleFormA'];
  }
}

/**
 * treatment : shisto
 * table : a_bysch
 * no. of parameters : none
 * descriptoin : sum up the male shisto
 */
function sumMaleFormAP() {
  $query = "SELECT SUM(ap_ecd_m)+
					   SUM(ap_trt_m)+
					   SUM(ap_6_m)+
					   SUM(ap_11_m)+
					   SUM(ap_15_m)
					   AS sumMaleFormAP FROM a_bysch WHERE ap_attached='Yes'";
  $result = mysql_query($query) or die("<h1>Cannt get count of males</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumMaleFormAP'];
  }
}

/**
 * treatment : shisto
 * table : a_bysch
 * no. of parameters : none
 * descriptoin : sum up the female shisto
 */
function sumFemaleFormAP() {
  $query = "SELECT SUM(ap_ecd_f)+
					   SUM(ap_trt_f)+
					   SUM(ap_6_f)+
					   SUM(ap_11_f)+
					   SUM(ap_15_f) AS sumFemaleFormAP FROM a_bysch WHERE ap_attached='Yes'";
  $result = mysql_query($query) or die("<h1>Cannt get count of female shisto </h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumFemaleFormAP'];
  }
}

/**
 * This is the addition of all the children
 * ecept thoes under 6
 * i.e non enrolld over 6 and enrolled primary school kids
 */
function sum6andOverFormA() {
  $query = "SELECT
			   SUM(a_6_f)+
			   SUM(a_11_f)+
			   SUM(a_15_f)+
			   SUM(a_6_m)+
			   SUM(a_11_m)+
			   SUM(a_15_m)+
			   SUM(a_trt_m)+
			   SUM(a_trt_f) AS sum6andOverFormA FROM a_bysch";
  $result = mysql_query($query) or die("<h1>Cannot get Sum of childer oer 6</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sum6andOverFormA'];
  }
}

/**
 * This sums the cildren under 5
 * i.e ecd and 2-5 un-enrolled
 */
function sumUnder5() {
  $query = "SELECT
				SUM(a_ecd_f)+
				SUM(a_ecd_m)+
				SUM(a_2_f)+
				SUM(a_2_m) AS sumUnder5 FROM a_bysch";
  $result = mysql_query($query) or die("<h1>Cannot get sumUnder5</h1>" . mysql_error());
  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumUnder5'];
  }
}

function sumUnder5Male() {
  $query = "SELECT
				SUM(a_ecd_m)+
				SUM(a_2_m) AS sumUnder5Male FROM a_bysch";
  $result = mysql_query($query) or die("<h1>Cannot get sumUnder5Male</h1>" . mysql_error());
  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumUnder5Male'];
  }
}

function sumUnder5MaleFormS() {
  $query = "SELECT sum(s_nonenroll_2_5yrs_m) + sum(s_ecd_treated_male) AS sumUnder5MaleFormS FROM s_bysch";

  $result = mysql_query($query) or die("<h1>Cannot get sum</h1>" . mysql_error());
  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumUnder5MaleFormS'];
  }
}

function sumUnder5FemaleFormS() {
  $query = "SELECT sum(s_nonenroll_2_5yrs_f) + sum(s_ecd_treated_female) AS sumUnder5FemaleFormS FROM s_bysch";

  $result = mysql_query($query) or die("<h1>Cannot get sum</h1>" . mysql_error());
  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumUnder5FemaleFormS'];
  }
}

function sumUnder5Female() {
  $query = "SELECT
				SUM(a_ecd_f)+
				SUM(a_2_f) AS sumUnder5Female FROM a_bysch";
  $result = mysql_query($query) or die("<h1>cannit get sumUnder5Female</h1>" . mysql_error());
  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumUnder5Female'];
  }
}

/**
 * treatment : shisto and STH
 * table : a_bysch
 * nu. of parameters : 1
 * description : non enrolles above 6 years
 */
function sumNonEnrolled6andover($treatment) {

  // change column names based on treatment
  if ($treatment == "STH") {
    $a_6_f = "a_6_f";
    $a_11_f = "a_11_f";
    $a_15_f = "a_15_f";
    $a_6_m = "a_6_m";
    $a_11_m = "a_11_m";
    $a_15_m = "a_15_m";
  } else {
    $a_6_f = "ap_6_f";
    $a_11_f = "ap_11_f";
    $a_15_f = "ap_15_f";
    $a_6_m = "ap_6_m";
    $a_11_m = "ap_11_m";
    $a_15_m = "ap_15_m";
  }

  $query = "SELECT
			   SUM($a_6_f)+
			   SUM($a_11_f)+
			   SUM($a_15_f)+
			   SUM($a_6_m)+
			   SUM($a_11_m)+
			   SUM($a_15_m)
			   AS sumNonEnrolled6andover FROM a_bysch";
  $result = mysql_query($query) or die("<h1>Cannot get Sum of childer oer 6</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumNonEnrolled6andover'];
  }
}

/**
 * treatment : shisto and STH
 * table : a_bysch
 * nu. of parameters : 1
 * description : non enrolles above 6 years in shisto schools
 */
function sumNonEnrolled6andoverByTreatment($treatment) {

  // change column names based on treatment
  if ($treatment == "STH") {
    $a_6_f = "a_6_f";
    $a_11_f = "a_11_f";
    $a_15_f = "a_15_f";
    $a_6_m = "a_6_m";
    $a_11_m = "a_11_m";
    $a_15_m = "a_15_m";
  } else {
    $a_6_f = "ap_6_f";
    $a_11_f = "ap_11_f";
    $a_15_f = "ap_15_f";
    $a_6_m = "ap_6_m";
    $a_11_m = "ap_11_m";
    $a_15_m = "ap_15_m";
  }

  $query = "SELECT
			   SUM($a_6_f)+
			   SUM($a_11_f)+
			   SUM($a_15_f)+
			   SUM($a_6_m)+
			   SUM($a_11_m)+
			   SUM($a_15_m)
			   AS sumNonEnrolled6andover FROM a_bysch WHERE ap_attached='Yes'";
  $result = mysql_query($query) or die("<h1>Cannot get Sum of childer oer 6</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumNonEnrolled6andover'];
  }
}

/**
 * treatment : STH AND SHISTO
 * table : a_bysch
 * nu. of parameters : 1
 * parameter values : STH or SHISTO
 */
function sumNonEnrolled6andoverMale($treatment) {

  // change column names based on treatment
  if ($treatment = "STH") {
    $a_6_m = "a_6_m";
    $a_11_m = "a_11_m";
    $a_15_m = "a_15_m";
  } else {
    $a_6_m = "ap_6_m";
    $a_11_m = "ap_11_m";
    $a_15_m = "ap_15_m";
  }

  $query = "SELECT
			   SUM($a_6_m)+
			   SUM($a_11_m)+
			   SUM($a_15_m)
			   AS sumNonEnrolled6andoverMale FROM a_bysch";
  $result = mysql_query($query) or die("<h1>Cannot get Sum of childer oer 6</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumNonEnrolled6andoverMale'];
  }
}

/**
 * treatment : STH AND SHISTO
 * table : a_bysch
 * nu. of parameters : 1
 * parameter values : STH or SHISTO
 */
function sumNonEnrolled6andoverMaleByTreatment($treatment) {

  // change column names based on treatment
  if ($treatment = "STH") {
    $a_6_m = "a_6_m";
    $a_11_m = "a_11_m";
    $a_15_m = "a_15_m";
  } else {
    $a_6_m = "ap_6_m";
    $a_11_m = "ap_11_m";
    $a_15_m = "ap_15_m";
  }

  $query = "SELECT
			   SUM($a_6_m)+
			   SUM($a_11_m)+
			   SUM($a_15_m)
			   AS sumNonEnrolled6andoverMale FROM a_bysch WHERE ap_attached='Yes'";
  $result = mysql_query($query) or die("<h1>Cannot get Sum of childer oer 6</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumNonEnrolled6andoverMale'];
  }
}

/**
 * treatment : STH AND SHISTO
 * table : a_bysch
 * nu. of parameters : 2
 * parameter values : STH or SHISTO , Yes or No
 */
function sumNonEnrolled6andoverMaleShistoSchool($treatment, $ap_attached) {

  // change column names based on treatment
  if ($treatment = "STH") {
    $a_6_m = "a_6_m";
    $a_11_m = "a_11_m";
    $a_15_m = "a_15_m";
  } else {
    $a_6_m = "ap_6_m";
    $a_11_m = "ap_11_m";
    $a_15_m = "ap_15_m";
  }

  $query = "SELECT
			   SUM($a_6_m)+
			   SUM($a_11_m)+
			   SUM($a_15_m)
			   AS sumNonEnrolled6andoverMale FROM a_bysch WHERE ap_attached='$ap_attached'";
  $result = mysql_query($query) or die("<h1>Cannot get Sum of childer oer 6</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumNonEnrolled6andoverMale'];
  }
}

/**
 * treatment : STH AND SHISTO
 * table : a_bysch
 * nu. of parameters : 2
 * parameter values : STH or SHISTO , Yes or No
 */
function sumNonEnrolled6andoverFemaleShistoSchool($treatment, $ap_attached) {

  // change column names based on treatment
  if ($treatment = "STH") {
    $a_6_m = "a_6_f";
    $a_11_m = "a_11_f";
    $a_15_m = "a_15_f";
  } else {
    $a_6_m = "ap_6_f";
    $a_11_m = "ap_11_f";
    $a_15_m = "ap_15_f";
  }

  $query = "SELECT
			   SUM($a_6_m)+
			   SUM($a_11_m)+
			   SUM($a_15_m)
			   AS sumNonEnrolled6andoverMale FROM a_bysch WHERE ap_attached='$ap_attached'";
  $result = mysql_query($query) or die("<h1>Cannot get Sum of childer oer 6</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumNonEnrolled6andoverMale'];
  }
}

/**
 * treatment : STH AND SHISTO
 * table : a_bysch
 * nu. of parameters : 1
 * parameter values : STH or SHISTO
 */
function sumNonEnrolled6andoverFemale($treatment) {

  if ($treatment == "STH") {
    $a_6_f = 'a_6_f';
    $a_11_f = 'a_11_f';
    $a_15_f = 'a_15_f';
  } else {
    $a_6_f = 'ap_6_f';
    $a_11_f = 'ap_11_f';
    $a_15_f = 'ap_15_f';
  }

  $query = "SELECT
			   SUM($a_6_f)+
			   SUM($a_11_f)+
			   SUM($a_15_f)
			   AS sumNonEnrolled6andoverFemale FROM a_bysch";
  $result = mysql_query($query) or die("<h1>Cannot get Sum of girls over 6</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumNonEnrolled6andoverFemale'];
  }
}

/**
 * treatment : sth and shistp
 * table : a_bysch
 * no. of parameters : 2
 * parameter values : non enrolled year, a_bysch or s_bysch e.g a_6 and a_bysch
 */
function sumNonEnrolledGender($year, $table) {
  $male = $year . "_m";
  $female = $year . "_f";
  $query = "SELECT SUM($male)+
		        SUM($female) AS sumNonEnrolledGender FROM $table";
  $result = mysql_query($query) or die("<h1>Cannot get " . $year . " children</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumNonEnrolledGender'];
  }
}

/**
 * This searches form p
 * takest the field name and the treatment i.e Y of N for is bilharzia
 */
function sumEstimated($field, $treatment) {
  $query = "SELECT SUM($field)
		         AS sumEstimated FROM
		         p_bysch WHERE
		         p_sch_bilharzia='$treatment'";
  $result = mysql_query($query) or die("<h1>cannot get Sum setimated</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumEstimated'];
  }
}

//
function sumEstimatedDonor($field, $treatment, $value) {
  $query = "SELECT SUM($field)
		         AS sumEstimated FROM
		         p_bysch_with_donor WHERE
		         p_sch_bilharzia='$treatment'AND
                            donor='$value'";
  $result = mysql_query($query) or die("<h1>cannot get Sum setimated</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumEstimated'];
  }
}

/**
 * This searches form p
 * takest the field name and the treatment i.e Y of N for is bilharzia
 */
function numEstimated($field, $treatment) {
  $query = "SELECT $field FROM
		         form_p_school_list WHERE
		         is_bilharzia_school='$treatment'";
  $result = mysql_query($query) or die("<h1>cannot get Sum setimated</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

/**
 * This searches form p
 * takest the field name and the treatment i.e Y of N for is bilharzia
 */
function numDistinctEstimated($field, $treatment) {
  $query = "SELECT DISTINCT($field) FROM
		         form_p_school_list WHERE
		         is_bilharzia_school='$treatment'";
  $result = mysql_query($query) or die("<h1>cannot get Sum setimated</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

/**
 * Sum of the enrolled from table a or ap
 * and mabye form s
 */
function sumEnrolled($table) {
  $query = "SELECT SUM(ecd_treated_children_total)+
		        SUM(enrolled_treated_total) AS sum FROM $table";
  $result = mysql_query($query) or die("<h1>cANOT GET </h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sum'];
  }
}

function sumEnrolledGenderSHISTO($gender) {
  $gender = $gender;
  $pri = 'enrolled_' . $gender;
  $ecd = 'ecd_treated_' . $gender;

  $query = "SELECT SUM($pri)+
		        SUM($ecd) AS sum FROM form_ap";
  $result = mysql_query($query) or die("<h1>Cannot get sumEnrolledGenderSHISTO</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sum'];
  }
}

function sumUnder5Gender($gender, $table) {
  $gender = $gender;
}

function sumChildrenShisto($table, $treatment) {
  $all = sum('s_ecd_total', $table, $treatment) +
          sum('s_total_treated', $table, $treatment) +
          sum('s_6_18_total', $table, $treatment);

  return $all;
}

/**
 * Sums upp all the shisto
 * I dont add up the ECD cuz they are too small to be given shisto meds
 */
function sumSHISTO() {
  $query = "SELECT SUM(ap_treated_b)+
				SUM(ap_6_18_total)+
				SUM(ap_trt_total)+
				SUM(ap_ecd_total)
				AS sumSHISTO FROM a_bysch WHERE ap_attached='Yes'";
  $result = mysql_query($query) or die("<h1>Cannot get sHISTO</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['sumSHISTO'];
  }
}

function sumSTH() {
//  $STH = sumPlain('a_6_18_total', 'a_bysch') +
//          sumPlain('a_u5_total', 'a_bysch') +
//          sumPlain('a_trt_total', 'a_bysch');
  $STH = sumPlain('a_total_child', 'a_bysch');
  return $STH;
}

function numPoles() {
  $query = "SELECT COUNT('school') AS poles FROM form_attnt WHERE tablet_poles = 'Yes'";
  $result = mysql_query($query) or die("<h1>Cannot get poles</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['poles'];
  }
}

function allSTH($table, $treatment) {
  $all = sum('s_ecd_total', $table, $treatment) +
          sum('s_total_treated', $table, $treatment) +
          sum('s_2_18_total', $table, $treatment) +
          sum('s_adult_total', $table, $treatment);

  return number_format($all);
}

function allShisto($table, $treatment) {
  $all = sum('sp_ecd_total', $table, $treatment) +
          sum('sp_total_treated', $table, $treatment) +
          sum('sp_6_18_total', $table, $treatment) +
          sum('sp_adult_total', $table, $treatment);

  return number_format($all);
}

/**
 * Description : this is the child average for s_bysch.
 *
 * @param  string  $denominator. This is the column to divide by
 * @return int     $average
 */
// function childAverage($table,$denominator){
function childAverageFormS($denominator) {
  // $field,$table,$where,$value
  $denominator = numDistinctFlexible($denominator, 's_bysch', 'sp_attached', 'No');

  // this if calculated for STH only
  $totalChild = sumChildrenSbysch('STH');
  //this is to remove the commas
  $totalChild = str_replace(',', '', $totalChild);

  $average = $totalChild / $denominator;

  return $average;
}

/**
 * Thisis for the generic avarage
 * provide a numerator and denomiator and it will besummedup
 * and divided
 */
function averagePlain($numerator, $table1, $denominator, $table2) {
  // $field,$table)
  $numerator = sumPlain($numerator, $table1);
  $denominator = sumPlain($denominator, $table2);

  $average = $numerator / $denominator;

  return $average;
}

function averageSumCount($numerator, $table1, $denominator, $table2) {
  $numerator = sumPlain($numerator, $table1);
  $denominator = num($denominator, $table2);

  $average = $numerator / $denominator;

  return $average;
}

function minimum($field, $table) {
  $query = "SELECT MIN($field) AS min_value FROM $table";
  $result = mysql_query($query) or die("<h1>Cannot min value of " . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['min_value'];
  }
}

function minimumDonor($field, $table, $where, $value) {
  $query = "SELECT MIN($field) AS min_value FROM $table WHERE $where = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot min value of " . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['min_value'];
  }
}

//


function maximum($field, $table) {
  $query = "SELECT MAX($field) AS max_value FROM $table";
  $result = mysql_query($query) or die("<h1>Cannot max value of " . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['max_value'];
  }
}

function maximumDonor($field, $table, $where, $value) {
  $query = "SELECT MAX($field) AS max_value FROM $table WHERE $where = '$value'";
  $result = mysql_query($query) or die("<h1>Cannot max value of " . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['max_value'];
  }
}

function primaryMale($table, $treatment) {
  // sum
}

function estimatedAvTablets() {
  $av = averagePlain('p_alb', 'p_bysch', 'p_sch_id', 'p_bysch') +
          averagePlain('p_pzq', 'p_bysch', 'p_sch_id', 'p_bysch');

  return $av;
}

function remove_comma($string) {
  $clean_string = str_replace(',', '', $string);
  return $clean_string;
}

// truncates the temp table for kpi reports
function truncateTemp() {
  mysql_query("TRUNCATE temp_kpi_reports") or die("<h1> Cannot truncate temp_kpi_reports</h1>" . mysql_error());
}

// form S
// #form s
function NotEmpty($field, $table) {
  $query = "SELECT $field FROM $table WHERE $field != ''";
  $result = mysql_query($query) or die("<h1>Cannot get  " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function NotEmptyDonor($field, $table, $value) {
  $query = "SELECT $field FROM $table WHERE $field != '' AND donor='$value'";
  $result = mysql_query($query) or die("<h1>Cannot get  " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function returnedForms($field) {
  $query = "SELECT DISTINCT($field) FROM s_bysch WHERE s_received_form_s != ''";
  $result = mysql_query($query) or die("<h1>Cannot get  " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

function returnedFormA($field) {
  $query = "SELECT DISTINCT($field) FROM a_bysch WHERE a_form_s_returned = 'Yes'";
  $result = mysql_query($query) or die("<h1>Cannot get  " . $field . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);

  return $num;
}

/**
 * treatment : none
 * table : any table
 * no. of parameters : many
 * description : get the values and add them.
 *               first parameter is the table.
 *
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
 * treatment : none
 * table : any table
 * no. of parameters : many
 * discription : sums the field in for shisto of non-shisto
 *
 */
function sumArgsByTreatment() {

  $args = func_get_args(); // get the args

  $table = array_shift($args); // get and remove the table

  $treatement = array_shift($args); // get and remove the treatment

  $size = sizeof($args); // get number of items in array
  $total = 0;
  for ($i = 0; $i < $size; $i++) {
    $total+=sum($args[$i], $table, $treatement);
  }

  return $total;
}

/**
 * treatment : none
 * table : none
 * no. of paremeter : many
 * description : add up the arguments given
 */
function addValues() {
  // get the args into an array
  $arg_list = func_get_args();

  // find number of values in array
  $numargs = func_num_args();

  // add all the values together in the array
  $arg_list = func_get_args();
  $total = 0;
  for ($i = 0; $i < $numargs; $i++) {
    $total+=$arg_list[$i];
  }

  return $total;
}

##########################################################################################
################################## S_BYSCH ONLY FUNCTIONS*********************************
##########################################################################################

/**
 * treatment : sth
 * table : s_bysch
 * no. of parameters : none
 * description : sums all the children in s_bysch only. For STH no shisto
 * Note : can modify this to add Shisto too.
 */
function sumChildrenSbysch($treatment) {
  if ($treatment == 'STH') {
    $ecd = sumArgs('s_bysch', 's_ecd_treated_male', 's_ecd_treated_male');
    $non_enrolled = sumArgs('s_bysch', 's_nonenroll_2_5yrs_m', 's_nonenroll_2_5yrs_f', 's_nonenroll_6_10yrs_m', 's_nonenroll_6_10yrs_f', 's_nonenroll_11_14yrs_m', 's_nonenroll_11_14yrs_f', 's_nonenroll_15_18yrs_m', 's_nonenroll_15_18yrs_f');
    $enrolled = sumArgs('s_bysch', 's_enroll_treated_m1', 's_enroll_treated_m2', 's_enroll_treated_m3', 's_enroll_treated_m4', 's_enroll_treated_m5', 's_enroll_treated_m6', 's_enroll_treated_m7', 's_enroll_treated_m8', 's_enroll_treated_m9', 's_enroll_treated_f1', 's_enroll_treated_f2', 's_enroll_treated_f3', 's_enroll_treated_f4', 's_enroll_treated_f5', 's_enroll_treated_f6', 's_enroll_treated_f7', 's_enroll_treated_f8', 's_enroll_treated_f9');


    $total = $ecd + $non_enrolled + $enrolled;

    return number_format($total);
  } else {
    $ecd_shisto = sumArgs('s_bysch', 'sp_ecd_m', 'sp_ecd_f');
    $non_enrolled = sumArgs('s_bysch', 'sp_nonenroll_6_10yrs_m', 'sp_nonenroll_6_10yrs_f', 'sp_nonenroll_11_14yrs_m', 'sp_nonenroll_11_14yrs_f', 'sp_nonenroll_15_18yrs_m', 'sp_nonenroll_15_18yrs_f');
    $enrolled_shisto = sumArgs('s_bysch', 'sp_enroll_treated_m1', 'sp_enroll_treated_m2', 'sp_enroll_treated_m3', 'sp_enroll_treated_m4', 'sp_enroll_treated_m5', 'sp_enroll_treated_m6', 'sp_enroll_treated_m7', 'sp_enroll_treated_m8', 'sp_enroll_treated_m9', 'sp_enroll_treated_f1', 'sp_enroll_treated_f2', 'sp_enroll_treated_f3', 'sp_enroll_treated_f4', 'sp_enroll_treated_f5', 'sp_enroll_treated_f6', 'sp_enroll_treated_f7', 'sp_enroll_treated_f8', 'sp_enroll_treated_f9');

    $total_shisto = $ecd_shisto + $non_enrolled + $enrolled_shisto;

    return $total_shisto;

    exit();
  }
}

/**
 * treatment : none
 * table : any table
 * no. of parameters : many
 * description : sum up all the deowrmed and adults in s_bysch table
 *
 */
function sumDewormedPlusAudultsSbysch($treatment) {
  if ($treatment == 'STH') {
    $ecd = sumArgs('s_bysch', 's_ecd_treated_male', 's_ecd_treated_female');
    $ecd_adult = sumArgs('s_bysch', 's_ecd_treated_adult');
    $non_enrolled = sumArgs('s_bysch', 's_nonenroll_2_5yrs_m', 's_nonenroll_2_5yrs_f', 's_nonenroll_6_10yrs_m', 's_nonenroll_6_10yrs_f', 's_nonenroll_11_14yrs_m', 's_nonenroll_11_14yrs_f', 's_nonenroll_15_18yrs_m', 's_nonenroll_15_18yrs_f');
    $non_enrolled_adults = sumArgs('s_bysch', 's_nonenroll_treated_adult');
    $enrolled = sumArgs('s_bysch', 's_enroll_treated_m1', 's_enroll_treated_m2', 's_enroll_treated_m3', 's_enroll_treated_m4', 's_enroll_treated_m5', 's_enroll_treated_m6', 's_enroll_treated_m7', 's_enroll_treated_m8', 's_enroll_treated_m9', 's_enroll_treated_f1', 's_enroll_treated_f2', 's_enroll_treated_f3', 's_enroll_treated_f4', 's_enroll_treated_f5', 's_enroll_treated_f6', 's_enroll_treated_f7', 's_enroll_treated_f8', 's_enroll_treated_f9');
    $enrolled_adults = sumArgs('s_bysch', 's_adult_treated1', 's_adult_treated2', 's_adult_treated3', 's_adult_treated4', 's_adult_treated5', 's_adult_treated6', 's_adult_treated7', 's_adult_treated8', 's_adult_treated9');

    $total = $ecd + $ecd_adult + $non_enrolled + $non_enrolled_adults + $enrolled + $enrolled_adults;

    return $total;

    exit();
  } else {

    $ecd_shisto = sumArgs('s_bysch', 'sp_ecd_m', 'sp_ecd_f');
    $ecd_adult_shisto = sumArgs('s_bysch', 'sp_adult_ecd');
    $non_enrolled = sumArgs(
            's_bysch', 'sp_nonenroll_6_10yrs_m', 'sp_nonenroll_6_10yrs_f', 'sp_nonenroll_11_14yrs_m', 'sp_nonenroll_11_14yrs_f', 'sp_nonenroll_15_18yrs_m', 'sp_nonenroll_15_18yrs_f'
    );
    $non_enrolled_adults_shisto = sumArgs('s_bysch', 's_nonenroll_treated_adult');

    $enrolled_shisto = sumArgs(
            's_bysch', 'sp_enroll_treated_m1', 'sp_enroll_treated_m2', 'sp_enroll_treated_m3', 'sp_enroll_treated_m4', 'sp_enroll_treated_m5', 'sp_enroll_treated_m6', 'sp_enroll_treated_m7', 'sp_enroll_treated_m8', 'sp_enroll_treated_m9', 'sp_enroll_treated_f1', 'sp_enroll_treated_f2', 'sp_enroll_treated_f3', 'sp_enroll_treated_f4', 'sp_enroll_treated_f5', 'sp_enroll_treated_f6', 'sp_enroll_treated_f7', 'sp_enroll_treated_f8', 'sp_enroll_treated_f9'
    );
    $enrolled_adults_shsito = sumArgs('s_bysch', 'sp_adult_treated1', 'sp_adult_treated2', 'sp_adult_treated3', 'sp_adult_treated4', 'sp_adult_treated5', 'sp_adult_treated6', 'sp_adult_treated7', 'sp_adult_treated8', 'sp_adult_treated9');

    $total_shisto = $ecd_shisto + $ecd_adult_shisto + $non_enrolled + $non_enrolled_adults_shisto + $enrolled_shisto + $enrolled_adults_shsito;

    return $total_shisto;

    exit();
  }
}

/**
 * treatment : STH*
 * table : s_bysch
 * no. of parameters : many
 * discription : sums the pri enrolled s_bysch
 * note : this can be modified to add the shisto too.
 */
function sumPriEnrolledSbysch($treatment) {
  if ($treatment == 'STH') {
    $enrolled = sumArgs(
            's_bysch', 's_enroll_treated_m1', 's_enroll_treated_m2', 's_enroll_treated_m3', 's_enroll_treated_m4', 's_enroll_treated_m5', 's_enroll_treated_m6', 's_enroll_treated_m7', 's_enroll_treated_m8', 's_enroll_treated_m9', 's_enroll_treated_f1', 's_enroll_treated_f2', 's_enroll_treated_f3', 's_enroll_treated_f4', 's_enroll_treated_f5', 's_enroll_treated_f6', 's_enroll_treated_f7', 's_enroll_treated_f8', 's_enroll_treated_f9'
    );
    return $enrolled;
    exit();
  } else {
    $enrolled = sumArgs(
            's_bysch', 'sp_enroll_treated_m1', 'sp_enroll_treated_m2', 'sp_enroll_treated_m3', 'sp_enroll_treated_m4', 'sp_enroll_treated_m5', 'sp_enroll_treated_m6', 'sp_enroll_treated_m7', 'sp_enroll_treated_m8', 'sp_enroll_treated_m9', 'sp_enroll_treated_f1', 'sp_enroll_treated_f2', 'sp_enroll_treated_f3', 'sp_enroll_treated_f4', 'sp_enroll_treated_f5', 'sp_enroll_treated_f6', 'sp_enroll_treated_f7', 'sp_enroll_treated_f8', 'sp_enroll_treated_f9'
    );
    return $enrolled;
    // exit();
  }
}

/**
 * treatment : STH*
 * table : s_bysch
 * no. of parameters : none"
 * discription : sums the children above 6 years s_bysch
 */
function sumPriChildrenSbysch($treatment) {
  if ($treatment == 'STH') {
    // sum all the primary enroled kids
    $enrolled = sumArgs(
            's_bysch', 's_enroll_treated_m1', 's_enroll_treated_m2', 's_enroll_treated_m3', 's_enroll_treated_m4', 's_enroll_treated_m5', 's_enroll_treated_m6', 's_enroll_treated_m7', 's_enroll_treated_m8', 's_enroll_treated_m9', 's_enroll_treated_f1', 's_enroll_treated_f2', 's_enroll_treated_f3', 's_enroll_treated_f4', 's_enroll_treated_f5', 's_enroll_treated_f6', 's_enroll_treated_f7', 's_enroll_treated_f8', 's_enroll_treated_f9'
    );

    // sum all the non emrolled kid above 6 years
    $non_enrolled_above_6 = sumArgs(
            's_bysch', 's_nonenroll_6_10yrs_m', 's_nonenroll_6_10yrs_f', 's_nonenroll_11_14yrs_m', 's_nonenroll_11_14yrs_f', 's_nonenroll_15_18yrs_m', 's_nonenroll_15_18yrs_f'
    );

    return $total = $enrolled + $non_enrolled_above_6;
  } else {
    // sum all the primary enroled kids
    $enrolled_shisto = sumArgs(
            's_bysch', 'sp_enroll_treated_m1', 'sp_enroll_treated_m2', 'sp_enroll_treated_m3', 'sp_enroll_treated_m4', 'sp_enroll_treated_m5', 'sp_enroll_treated_m6', 'sp_enroll_treated_m7', 'sp_enroll_treated_m8', 'sp_enroll_treated_m9', 'sp_enroll_treated_f1', 'sp_enroll_treated_f2', 'sp_enroll_treated_f3', 'sp_enroll_treated_f4', 'sp_enroll_treated_f5', 'sp_enroll_treated_f6', 'sp_enroll_treated_f7', 'sp_enroll_treated_f8', 'sp_enroll_treated_f9'
    );

    // sum all the non emrolled kid above 6 years
    $non_enrolled_above_6_shisto = sumArgs(
            's_bysch', 'sp_nonenroll_6_10yrs_m', ' sp_nonenroll_6_10yrs_f', 'sp_nonenroll_11_14yrs_m', 'sp_nonenroll_11_14yrs_f', 'sp_nonenroll_15_18yrs_m', 'sp_nonenroll_15_18yrs_f'
    );

    return $total_shisto = $enrolled_shisto + $non_enrolled_above_6_shisto;
  }
}

/**
 * treatment : STH*
 * table : s_bysch
 * no. of parameters : none"
 * discription : sums the male children above 6 years s_bysch
 */
function sumFemaleAbove6Sbysch($treatment) {
  if ($treatment == 'STH') {
    // sum all the primary enroled kids
    $enrolled = sumArgs(
            's_bysch', 's_enroll_treated_f1', 's_enroll_treated_f2', 's_enroll_treated_f3', 's_enroll_treated_f4', 's_enroll_treated_f5', 's_enroll_treated_f6', 's_enroll_treated_f7', 's_enroll_treated_f8', 's_enroll_treated_f9'
    );

    // sum all the non emrolled kid above 6 years
    $non_enrolled_above_6 = sumArgs(
            's_bysch', 's_nonenroll_6_10yrs_f', 's_nonenroll_11_14yrs_f', 's_nonenroll_15_18yrs_f'
    );
    return $total = $enrolled + $non_enrolled_above_6;
  } else {
    // sum all the primary enroled kids
    $enrolled_shisto = sumArgs(
            's_bysch', 'sp_enroll_treated_f1', 'sp_enroll_treated_f2', 'sp_enroll_treated_f3', 'sp_enroll_treated_f4', 'sp_enroll_treated_f5', 'sp_enroll_treated_f6', 'sp_enroll_treated_f7', 'sp_enroll_treated_f8', 'sp_enroll_treated_f9'
    );

    // sum all the non emrolled kid above 6 years
    $non_enrolled_above_6_shisto = sumArgs(
            's_bysch', 'sp_nonenroll_6_10yrs_f', 'sp_nonenroll_11_14yrs_f', 'sp_nonenroll_15_18yrs_f'
    );
    return $total_shisto = $enrolled_shisto + $non_enrolled_above_6_shisto;
  }
}

/**
 * treatment : STH*
 * table : s_bysch
 * no. of parameters : none"
 * discription : sums the female children above 6 years s_bysch
 * note : this can be modified to add the shisto too.
 */
function sumMaleAbove6Sbysch($treatment) {
  if ($treatment == 'STH') {
    // sum all the primary enroled kids
    $enrolled = sumArgs(
            's_bysch', 's_enroll_treated_m1', 's_enroll_treated_m2', 's_enroll_treated_m3', 's_enroll_treated_m4', 's_enroll_treated_m5', 's_enroll_treated_m6', 's_enroll_treated_m7', 's_enroll_treated_m8', 's_enroll_treated_m9'
    );

    // sum all the non emrolled kid above 6 years
    $non_enrolled_above_6 = sumArgs(
            's_bysch', 's_nonenroll_6_10yrs_m', 's_nonenroll_11_14yrs_m', 's_nonenroll_15_18yrs_m'
    );
    return $total = $enrolled + $non_enrolled_above_6;
  } else {
    // sum all the primary enroled kids
    $enrolled_shisto = sumArgs(
            's_bysch', 'sp_enroll_treated_m1', 'sp_enroll_treated_m2', 'sp_enroll_treated_m3', 'sp_enroll_treated_m4', 'sp_enroll_treated_m5', 'sp_enroll_treated_m6', 'sp_enroll_treated_m7', 'sp_enroll_treated_m8', 'sp_enroll_treated_m9'
    );

    // sum all the non emrolled kid above 6 years
    $non_enrolled_above_6_shisto = sumArgs(
            's_bysch', 'sp_nonenroll_6_10yrs_m', 'sp_nonenroll_11_14yrs_m', 'sp_nonenroll_15_18yrs_m'
    );
    return $total_shisto = $enrolled_shisto + $non_enrolled_above_6_shisto;
  }
}

/**
 * treatment : STH*
 * table : s_bysch
 * no. of parameters : none"
 * discription : sums the registered primary children from s_bysch
 * note : this can be modified to add the shisto too.
 */
function sumPriRegisteredSbysch($treatment) {
  if ($treatment == 'STH') {
    $registered = sumArgs(
            's_bysch', 's_enroll_m1', 's_enroll_m2', 's_enroll_m3', 's_enroll_m4', 's_enroll_m5', 's_enroll_m6', 's_enroll_m7', 's_enroll_m8', 's_enroll_m9', 's_enroll_f1', 's_enroll_f2', 's_enroll_f3', 's_enroll_f4', 's_enroll_f5', 's_enroll_f6', 's_enroll_f7', 's_enroll_f8', 's_enroll_f9'
    );
    return $registered;
  } else {
    $registered_shisto = sumArgs(
            's_bysch', 'sp_enroll_m1', 'sp_enroll_m2', 'sp_enroll_m3', 'sp_enroll_m4', 'sp_enroll_m5', 'sp_enroll_m6', 'sp_enroll_m7', 'sp_enroll_m8', 'sp_enroll_m9', 'sp_enroll_f1', 'sp_enroll_f2', 'sp_enroll_f3', 'sp_enroll_f4', 'sp_enroll_f5', 'sp_enroll_f6', 'sp_enroll_f7', 'sp_enroll_f8', 'sp_enroll_f9'
    );
    return $registered_shisto;
  }
}

function sumPriRegistered($field, $table, $where, $value, $where1, $value1) {
  $query = "SELECT SUM($field) AS total FROM $table WHERE $where = '$value' AND $where1 = '$value1'";
  $result = mysql_query($query) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['total'];
  }
}

function sumPriRegisteredDonor($field, $table, $where, $value, $where1, $value1, $value2) {
  $query = "SELECT SUM($field) AS total FROM $table WHERE $where = '$value' AND $where1 = '$value1' AND donor ='$value2'";
  $result = mysql_query($query) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['total'];
  }
}

/**
 * treatment : STH*
 * table : s_bysch
 * no. of parameters : one
 * discription : sums the male or female registered primary children from s_bysch
 * note : this can be modified to add the shisto too.
 */
function sumPriGenderRegisteredSbysch($sex) {

  if ($sex == 'male') {
    $registeredMale = sumArgs(
            's_bysch', 's_enroll_m1', 's_enroll_m2', 's_enroll_m3', 's_enroll_m4', 's_enroll_m5', 's_enroll_m6', 's_enroll_m7', 's_enroll_m8', 's_enroll_m9'
    );
    return $registeredMale;

    exit();
  } else {
    $registeredFemale = sumArgs(
            's_bysch', 's_enroll_f1', 's_enroll_f2', 's_enroll_f3', 's_enroll_f4', 's_enroll_f5', 's_enroll_f6', 's_enroll_f7', 's_enroll_f8', 's_enroll_f9'
    );
    return $registeredFemale;
  }
}

/**
 * treatment : none*
 * table : any table
 * no. of parameters : many
 * description : sum up all the non enrolled in s_bysch table
 *
 */
function sumNonEnrolledSbysch($treatment) {
  if ($treatment == 'STH') {
    $non_enrolled = sumArgs(
            's_bysch', 's_nonenroll_2_5yrs_m', 's_nonenroll_2_5yrs_f', 's_nonenroll_6_10yrs_m', 's_nonenroll_6_10yrs_f', 's_nonenroll_11_14yrs_m', 's_nonenroll_11_14yrs_f', 's_nonenroll_15_18yrs_m', 's_nonenroll_15_18yrs_f');

    return $non_enrolled;
  } else {
    $non_enrolled_shisto = sumArgs(
            's_bysch', 'sp_nonenroll_6_10yrs_m', 'sp_nonenroll_6_10yrs_f', 'sp_nonenroll_11_14yrs_m', 'sp_nonenroll_11_14yrs_f', 'sp_nonenroll_15_18yrs_m', 'sp_nonenroll_15_18yrs_f');

    return $non_enrolled_shisto;
  }
}

/**
 * treatment : none*
 * table : any s_bysch
 * no. of parameters : many
 * description : sum up all the adults in s_bysch
 * Note : could modify this to look for Shisto too
 *
 */
function sumAdultsFormS($treatment) {

  if ($treatment == 'STH') {
    $ecd_adult = sumArgs('s_bysch', 's_ecd_treated_adult');
    $non_enrolled_adults = sumArgs('s_bysch', 's_nonenroll_treated_adult');
    $enrolled_adults = sumArgs(
            's_bysch', 's_adult_treated1', 's_adult_treated2', 's_adult_treated3', 's_adult_treated4', 's_adult_treated5', 's_adult_treated6', 's_adult_treated7', 's_adult_treated8', 's_adult_treated9'
    );

    $total = $ecd_adult + $non_enrolled_adults + $enrolled_adults;
    return $total;
  } else {
    $ecd_adult_shisto = sumArgs('s_bysch', 'sp_adult_ecd');
    $non_enrolled_adults_shisto = sumArgs('s_bysch', 'sp_nonenroll_adult');
    $enrolled_adults_shisto = sumArgs(
            's_bysch', 'sp_adult_treated1', 'sp_adult_treated2', ' sp_adult_treated3', 'sp_adult_treated4', 'sp_adult_treated5', 'sp_adult_treated6', 'sp_adult_treated7', 'sp_adult_treated8', 'sp_adult_treated9'
    );

    $total_shisto = $ecd_adult_shisto + $non_enrolled_adults_shisto + $enrolled_adults_shisto;
    return $total_shisto;
  }
}

function sumTabletsSpoilt($treatment) {
  if ($treatment == 'STH') {
    $ecd_tablets_spoilt = sumArgs('s_bysch', 's_ecd_spoilt_tabs');
    $non_enrolled_spoilt_tabs = sumArgs('s_bysch', 's_nonenroll_spoilt_tabs');
    $enrolled_spoilt_tabs = sumArgs(
            's_bysch', 's_spoilt_tabs1', 's_spoilt_tabs2', 's_spoilt_tabs3', 's_spoilt_tabs4', 's_spoilt_tabs5', 's_spoilt_tabs6', 's_spoilt_tabs7', 's_spoilt_tabs8', 's_spoilt_tabs9'
    );

    $total = $ecd_tablets_spoilt + $non_enrolled_spoilt_tabs + $enrolled_spoilt_tabs;

    return $total;
  } else {
    $ecd_tablets_spoilt_shisto = sumArgs('s_bysch', 'sp_spoilt_ecd');
    $non_enrolled_spoilt_tabs_shisto = sumArgs('s_bysch', 'sp_nonenroll_spoilt_tabs');
    $enrolled_spoilt_tabs_shisto = sumArgs(
            's_bysch', 'sp_spoilt_tablets1', 'sp_spoilt_tablets2', 'sp_spoilt_tablets3', 'sp_spoilt_tablets4', 'sp_spoilt_tablets5', 'sp_spoilt_tablets6', 'sp_spoilt_tablets7', 'sp_spoilt_tablets8', 'sp_spoilt_tablets9'
    );

    $total_shisto = $ecd_tablets_spoilt_shisto + $non_enrolled_spoilt_tabs_shisto + $enrolled_spoilt_tabs_shisto;

    return $total_shisto;
  }
}

function divisionValues($numerator, $denominator) {

  if ((int) $denominator == 0) {
    return 0;
  } else {

    $division = $numerator / $denominator;

    return $division;
  }
}

/**
 * Description : find max number by adding total of s_total_child  bysch
 *
 * @param string  string to display
 * @param mixed  variable to display with var_dump()
 * @param mixed ,... unlimited OPTIONAL number of additional variables to display with var_dump()
 * @return mixed ,int,string
 */
function districtMaxAverage($field, $table, $group) {

  // sum all the s_total_child by district

  $query = "SELECT sum($field) AS sum_child FROM $table GROUP BY $group ";
  $result = mysql_query($query) or die("<h1></h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    $data[] = $row['sum_child']; // add items to array
  }

  return max($data); // find max in the array
}

function districtMinAverage($field, $table, $group) {

  // get all the distirtcs
  // $districts=getDistID();
  // sum all the s_total_child by district
  // $query="SELECT sum(s_total_child) AS sum_child FROM s_bysch GROUP BY s_district_id";
  $query = "SELECT sum($field) AS sum_child FROM $table GROUP BY $group";
  $result = mysql_query($query) or die("<h1></h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    $data[] = $row['sum_child']; // add items to array
  }

  return min($data); // find smallest value in the array
}

function percentage($numerator, $denominator) {

  if ((int) $denominator == 0) {
    return "0%";
  } else {
    $percentage1 = $numerator / $denominator;
    $percentage = $percentage1 * 100;
    return number_format($percentage, 2, '.', '') . "%";
  }
}

// find a way to string all these in one function
function hunderdPercentProportion() {
  $query = "SELECT SUM(IF(s_total_treated/s_total_registered =0,1,0) ) AS _sum FROM s_bysch";

  $result = mysql_query($query) or die("<h1>cannot COUNT</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['_sum'];
  }
}

function ninetyfivePercentProportion() {
  $query = "SELECT SUM(IF(s_total_treated/s_total_registered >= 0.95,1,0) ) AS _sum FROM s_bysch";

  $result = mysql_query($query) or die("<h1>cannot COUNT</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['_sum'];
  }
}

function seventyfivePercentProportion() {
  $query = "SELECT SUM(IF(s_total_treated/s_total_registered >= 0.75,1,0) ) AS _sum FROM s_bysch";

  $result = mysql_query($query) or die("<h1>cannot COUNT</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['_sum'];
  }
}

function fiftyPercentProportion() {
  $query = "SELECT SUM(IF(s_total_treated/s_total_registered >= 0.5,1,0) ) AS _sum FROM s_bysch";

  $result = mysql_query($query) or die("<h1>cannot COUNT</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['_sum'];
  }
}

function proportionAdultsFormS() {
  $proportion = sumPlain('s_adult_total', 's_bysch') + sumPlain('s_total_all', 's_bysch');

  return $proportion;
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

function dewormingDayFormS($percent = false) {

  $query = "SELECT COUNT(s_prog_sch_id) AS _count FROM s_bysch WHERE actual_deworming_date = s_deworming_day";
  $result = mysql_query($query) or die("<h1>Cannot get COUNT</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    $schools_on_dd = $row['_count'];
  }


  if ($percent == false) {
    return $schools_on_dd;
  } else {
    // num($field,$table);
    $schools = num('s_prog_sch_id', 's_bysch');
    $schools_on_dd = $schools_on_dd;

    return (($schools_on_dd / $schools) * 100) . "%";
  }
}

function dewormingDayFormSDonor($percent = false) {

  $query = "SELECT COUNT(s_prog_sch_id) AS _count FROM s_bysch_with_donor WHERE actual_deworming_date = s_deworming_day AND donor='CIFF'";
  $result = mysql_query($query) or die("<h1>Cannot get COUNT</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    $schools_on_dd = $row['_count'];
  }


  if ($percent == false) {
    return $schools_on_dd;
  } else {
    // num($field,$table);
    $schools = num('s_prog_sch_id', 's_bysch');
    $schools_on_dd = $schools_on_dd;

    return (($schools_on_dd / $schools) * 100) . "%";
  }
}

function dewormingDayFormSDonor1($percent = false) {

  $query = "SELECT COUNT(s_prog_sch_id) AS _count FROM s_bysch_with_donor WHERE actual_deworming_date = s_deworming_day AND donor='END'";
  $result = mysql_query($query) or die("<h1>Cannot get COUNT</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    $schools_on_dd = $row['_count'];
  }


  if ($percent == false) {
    return $schools_on_dd;
  } else {
    // num($field,$table);
    $schools = num('s_prog_sch_id', 's_bysch');
    $schools_on_dd = $schools_on_dd;

    return (($schools_on_dd / $schools) * 100) . "%";
  }
}

/**
 * Description : get the number of attnt teachers.
 *
 * @param string  $where
 * @return int $num+$num2;
 */
function getAttntTeachers($where) {
  $query = "SELECT * FROM attnt_bysch WHERE  attnt_sth='1' ";
  $result = mysql_query($query) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num = mysql_num_rows($result);
  echo number_format($num);
  echo '<br/>';

  $query2 = "SELECT * FROM attnt_bysch WHERE AND attnt_sth='1' ";
  $result2 = mysql_query($query2) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num2 = mysql_num_rows($result2);
  echo number_format($num2);
  echo '<br/>';

  $rr = $num + $num2;
  // echo number_format($rr);
}

function attntDDOntime() {
  $query = "SELECT count(at.school_id) AS _count FROM attnt_bysch as at INNER JOIN a_bysch as a ON at.school_no = a.school_id  WHERE at.deworming_date = a.deworming_date GROUP BY at.attnt_id";
  $result = mysql_query($query) or die("<h1>Cannot get num</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['_count'];
  }
}

function attntDDOntimeDonor($value) {
  $query = "SELECT count(at.school_id) AS _count FROM attnt_bysch_with_donor as at INNER JOIN a_bysch_with_donor as a ON at.school_no = a.school_id  WHERE at.deworming_date = a.deworming_date AND donor='$value' GROUP BY at.attnt_id";
  $result = mysql_query($query) or die("<h1>Cannot get num</h1>" . mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    return $row['_count'];
  }
}

/**
 * Description : get the number of attnt teachers.
 *
 * @param string  $where
 * @return int $num+$num2;
 */
function getAttntTeachersAll() {
  $query = "SELECT * FROM attnt_bysch WHERE  attnt_sth='1' ";
  $result = mysql_query($query) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num = mysql_num_rows($result);

  $query2 = "SELECT * FROM attnt_bysch WHERE attnt_schisto='1' ";
  $result2 = mysql_query($query2) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num2 = mysql_num_rows($result2);

  $teachers = $num + $num2;
  return $teachers;
}

function getAttntTeachersAllDonor($value) {
  $query = "SELECT * FROM attnt_bysch_with_donor WHERE  attnt_sth='1' AND donor='$value'";
  $result = mysql_query($query) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num = mysql_num_rows($result);

  $query2 = "SELECT * FROM attnt_bysch_with_donor WHERE attnt_schisto='1' ";
  $result2 = mysql_query($query2) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num2 = mysql_num_rows($result2);

  $teachers = $num + $num2;
  return $teachers;
}

/**
 * Description : find the number of schools that attended the teacher training.
 *
 */
function ttSchoolsOnP() {
  $query = "SELECT p_sch_id
					FROM p_bysch AS p
					INNER JOIN attnt_bysch AS at
					WHERE p.p_sch_id = at.school_no";
  $result = mysql_query($query) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num = mysql_num_rows($result);

  return $num;
}

function ttSchoolsOnPDonor($value) {
  $query = "SELECT p_sch_id
					FROM p_bysch_with_donor AS p WHERE  donor ='$value' AND
					INNER JOIN attnt_bysch_with_donor AS at
					WHERE p.p_sch_id = at.school_no";
  $result = mysql_query($query) or die("<h1>Cannot get num of teachers</h1>" . mysql_error());
  $num = mysql_num_rows($result);

  return $num;
}

function reporting_on_school_division() {
  $query1 = "SELECT * FROM a_bysch_inner_s_bysch_division  WHERE rangecheck=1";
  $result1 = mysql_query($query1) or die(mysql_error());
  $divisionsInRange = mysql_num_rows($result1);

  $query2 = "SELECT * FROM a_bysch_inner_s_bysch_division  ";
  $result2 = mysql_query($query2) or die(mysql_error());
  $totalDivisions = mysql_num_rows($result2);

  $ans = round($divisionsInRange / $totalDivisions * 100, 2);
  return $ans . '%';
}

function reporting_on_school_district() {
  $query1 = "SELECT * FROM a_bysch_inner_s_bysch_district  WHERE rangecheck=1";
  $result1 = mysql_query($query1) or die(mysql_error());
  $divisionsInRange = mysql_num_rows($result1);

  $query2 = "SELECT * FROM a_bysch_inner_s_bysch_district  ";
  $result2 = mysql_query($query2) or die(mysql_error());
  $totalDivisions = mysql_num_rows($result2);

  $ans = round($divisionsInRange / $totalDivisions * 100, 2);
  return $ans . '%';
}

function reporting_on_schoolDonor($field, $field2, $value) {
  $query = "SELECT $field, $field2 FROM a_bysch_with_donor INNER JOIN s_bysch_with_donor ON a_bysch_with_donor.$field=s_bysch_with_donor.$field2
      WHERE a_bysch_with_donor.donor='$value' AND  -10 <= ((a_bysch_with_donor.a_total_child- s_bysch_with_donor.s_total_child)/s_bysch_with_donor.s_total_child)*100 <= 10";
  $result = mysql_query($query) or die("<h1>Cannot get num of " . school_id . "</h1>" . mysql_error());

  $num = mysql_num_rows($result);
  $query1 = "SELECT $field, $field2 FROM a_bysch_with_donor INNER JOIN s_bysch_with_donor ON a_bysch_with_donor.$field=s_bysch_with_donor.$field2
    WHERE a_bysch_with_donor.donor='$value'";
  $result1 = mysql_query($query1) or die("<h1>Cannot get num of " . school_id . "</h1>" . mysql_error());

  $num1 = mysql_num_rows($result1);
  if ((int) $num1 == 0) {
    return "0%";
  } else {
    $percentage1 = $num / $num1;
    $percentage = $percentage1 * 100;
    return number_format($percentage, 2, '.', '') . "%";
  }
}

// public function getDistID(){
// 	$query="SELECT DISTINCT(s_district_id) AS district_id FROM s_bysch";
// 	$result=mysql_query($query) or die("<h1></h1>".mysql_error());
// 	while ($row=mysql_fetch_assoc($result)) {
// 		$data[] = array(
// 			'district_id' => $row['district_id']
// 		);
// 	}
// }
?>