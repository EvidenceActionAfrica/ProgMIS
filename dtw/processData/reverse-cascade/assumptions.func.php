<?php 

// Referrals
# result
# $result=mysql_query($sql)or die("<h1></h1>".mysql_error());


require_once ('../includes/config.php');

#######################
#     SCHOOL LIST     #
################################

# ##################################################################                                                                   
#               .__                        .__       .__           #
# _____    _____|__|____    ____      ____ |__|______|  |   ______ #
# \__  \  /  ___/  \__  \  /    \    / ___\|  \_  __ \  |  /  ___/ #
#  / __ \_\___ \|  |/ __ \|   |  \  / /_/  >  ||  | \/  |__\___ \  #
# (____  /____  >__(____  /___|  /  \___  /|__||__|  |____/____  > #
#      \/     \/        \/     \/  /_____/                     \/  #
# ##################################################################
/**
* description: gets the school ID and returns 1 if is a bilharzia school and 0 if not.
*/
function isBilharzia($school_id)
{
	$sql="SELECT ap_attached FROM a_bysch  WHERE school_id = '$school_id' ";
	$result=mysql_query($sql)or die("<h1>function name: isBilharzia <br>Cannot get ap_attached</h1>".mysql_error());

	$ap_attached=0;
	while ($row=mysql_fetch_array($result)) {
		$ap_attached=$row['ap_attached'];
	}

	if ($ap_attached=='Yes') {
		return 1;
	}else{
		return 0;
	}

}

// Checks if form S was returned
function returnedS($school_id)
{
	$sql="SELECT s_received_form_s from s_bysch WHERE s_prog_sch_id = '$school_id'";
	$result=mysql_query($sql)or die("<h1>function name : returnedS<br/>Cannot get returned form s </h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		$returnedS=$row['s_received_form_s'];
	}

	if (empty($returnedS)) {
		return 0;
	}else{
		return 1;
	}

}

// checks if school was in form P
function onP($school_id){
	$sql="SELECT p_sch_id FROM p_bysch WHERE p_sch_id = '$school_id'";
	$result=mysql_query($sql)or die("<h1>get infor from form p_bysch</h1>".mysql_error());

	$num = mysql_num_rows($result);
	
	// if num id greater than one
	if ($num>0) {
		// school exists
		return 1;
	}else{
		// schoold doesnt exist
		return 0;
	}

}


/**
* treatment : none
* table : p_bysch
* no. of paremeter : one
* description : get total enrolled on p_bysch from school
*/

function pEnroll($school_id){
	$sql="SELECT p_pri_enroll + p_ecd_enroll + p_ecd_sa_enroll AS pEnroll FROM p_bysch WHERE p_sch_id = '$school_id'";
	$result=mysql_query($sql)or die("<h1>function name: pEnroll <br/>Cannot get sum of enrolled on P</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		$pEnroll=$row['pEnroll'];
	}

	if (empty($pEnroll)) {
		// if empty
		return 0;
	}else{
		// if has data
		return (int)$pEnroll;
	}


}


/**
* treatment : none
* table : s_bysch
* no. of paremeter : none
* description : get registered enrolled on s_bysch
*/

function registeredS($school_id){
	$sql="SELECT s_enroll_m1 + s_enroll_m2 + s_enroll_m3 +
				 s_enroll_m4 + s_enroll_m5 + s_enroll_m6 +
				 s_enroll_m7 + s_enroll_m8 + s_enroll_m9 +
				 s_enroll_f1 + s_enroll_f2 + s_enroll_f3 +
				 s_enroll_f4 + s_enroll_f5 + s_enroll_f6 +
				 s_enroll_f7 + s_enroll_f8 + s_enroll_f9 
		  AS registered
		  FROM s_bysch WHERE s_prog_sch_id = '$school_id'";

	$result=mysql_query($sql)or die("<h1>function name: registeredS <br/>Cannot get regsitered on S</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		$registeredS=$row['registered'];
	}

	if (empty($registeredS)) {
		return 0;
	}else{
		return (int)$registeredS;
	}
}

// gets the district extra pzq
function ifElseMultiply($value1,$value2,$value3){

	$args=func_get_args(); // get the args

	$value1=array_shift($args); // get and remove the table

	$size=sizeof($args); // get number of items in array
	
	if ($value1==0) {
		return 0;
	}else{
		// get the asumption values and add them into an array
		$data=array();
		for ($i=0; $i < $size; $i++) { 
			$data[]=getAssumptionVal($args[$i]);
		}
		// multiply the values in the array
		$product=array_product($args);
		
		return $product;
	}
}

// gets the higest of the two given parameters
function highestEnrollment($pEnroll,$registeredS){

	// check if both are strings
	if (is_string($pEnroll) && is_string($registeredS)) {
		return 0;
		exit();
	}

	// if both are numbers then find largest
	if (is_numeric($pEnroll) && is_numeric($registeredS)) {
		
		if ($pEnroll > $registeredS) {
			return $pEnroll;
		}else{
			return $registeredS;
		}
	}

	// if one is number return  the number
	if (is_string($pEnroll) && !is_string($registeredS)){
		return $registeredS;
	}

	// if one is number return  the number
	if (is_string($registeredS) && !is_string($pEnroll)) {
		return $pEnroll;
	}
	
}


/**
* treatment : none
* table : assumptions
* no. of paremeter : assumption
* description : get the requested assumption value
*/

function getAssumptionVal($assumption){
	$sql="SELECT $assumption AS assumption FROM assumptions ORDER BY id DESC LIMIT 0,1";
	$result=mysql_query($sql)or die("<h1>Cannot get assumption</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $assumption=$row['assumption'];
	}
}

/**
* treatment : none
* table : assumptions
* no. of paremeter : assumeption and valu
* description : get the requested assumption value and multiply it by the given value
*/

function assumptionProduct($value,$assumption)
{
	$assumption_value=getAssumptionVal($assumption);

	$product = $assumption_value * $value;

	return $product;

}

/**
* treatment : none
* table : assumptions
* no. of paremeter : assumeption and value
* description : get the requested assumption value and divide it by the given value
*/

function assumptionDivision($value,$assumption){
	$assumption_value=getAssumptionVal($assumption);

	$division =  $value / $assumption_value;

	if (empty($division)) {
		return "No data";
	}else{
		return $division;
	}
}

/**
* treatment : none
* table : assumptions
* no. of paremeter : assumeption and value
* description : subtract 2 values
*/
function plainSubtract($value_1,$value_2){
	// echo "herererer ".$value_1;
	// echo "herererer <br>".$value_2;
	// die();
	$result=$value_1 - $value_2;

	
	if (empty($result)) {
		return 0;
	}else{
		return $result;
	}
}


/**
* treatment : none
* table : none
* no. of paremeter : many
* description : add up the arguments given
*/

function addValues(){
	// get the args into an array
	$arg_list = func_get_args();

	// find number of values in array
    $numargs = func_num_args();
  	
  	// add all the values together in the array
    $total=0;
    for ($i = 0; $i < $numargs; $i++) {
        $total+=$arg_list[$i] ;
    }

    return $total;
}


/**
* treatment : none
* table : none
* no. of paremeter : many
* description : Checks if value A is greater than B
*/

function ifGreater($A,$B)
{
	$B=getAssumptionVal($B);

	if ($A > $B) {
		return getAssumptionVal('aTinSize');
	}else{
		return 0;
	}
}

/**
* treatment : none
* table : none
* no. of paremeter : many
* description : Checks if value A is greater than B
*/

function ifGreater2($A,$B,$C)
{
	$B=getAssumptionVal($B);

	if ($A > $B) {
		return getAssumptionVal($C);
	}else{
		return 0;
	}
}

/**
* treatment : none
* table : none
* no. of paremeter : many
* description : Checks if value A is equal to 1
*/

function isEqualTo1($A,$B)
{
	// $B=getAssumptionVal($B);

	if ($A == 1) {
		return $B;
	}else{
		return 0;
	}
}


/**
* treatment : none
* table : none
* no. of paremeter : many
* description : Checks if value A is equal to 0
*/

function isEqualTo0($A,$B)
{
	$B=getAssumptionVal($B);

	if ($A == 0) {
		return 0;
	}else{
		return $B;
	}
}


/**
* treatment : none
* table : assumptions_school_list
* no. of paremeter : many
* description : inserts into the table
*/
function create_school_list(){

	// get the args into an array
	$arg_list = func_get_args();

	// find number of values in array
    $numargs = func_num_args();
  	
  	// add all the values together in the array
    $arg_list = func_get_args();
    $id="";

	$sql="INSERT INTO assumptions_school_list VALUES(
					'$id',
					'$arg_list[0]',
					'$arg_list[1]',
					'$arg_list[2]',
					'$arg_list[3]',
					'$arg_list[4]',
					'$arg_list[5]',
					'$arg_list[6]',
					'$arg_list[7]',
					'$arg_list[8]',
					'$arg_list[9]',
					'$arg_list[10]',
					'$arg_list[11]',
					'$arg_list[12]',
					'$arg_list[13]',
					'$arg_list[14]',
					'$arg_list[15]',
					'$arg_list[16]',
					'$arg_list[17]',
					'$arg_list[18]',
					'$arg_list[19]',
					'$arg_list[20]',
					'$arg_list[21]',
					'$arg_list[22]',
					'$arg_list[23]',
					'$arg_list[24]',
					'$arg_list[25]',
					'$arg_list[26]',
					'$arg_list[27]',
					'$arg_list[28]',
					'$arg_list[29]',
					'$arg_list[30]',
					'$arg_list[31]',
					'$arg_list[32]',
					'$arg_list[33]',
					'$arg_list[34]',
					'$arg_list[35]',
					'$arg_list[36]',
					'$arg_list[37]',
					'$arg_list[38]',
					'$arg_list[39]',
					'$arg_list[40]',
					'$arg_list[41]',
					'$arg_list[42]',
					'$arg_list[43]',
					'$arg_list[44]',
					'$arg_list[45]',
					'$arg_list[46]',
					'$arg_list[47]',
					'$arg_list[48]',
					'$arg_list[49]',
					'$arg_list[50]',
					'$arg_list[51]'
					)";
$result=mysql_query($sql)or die("<h1>Cannot insert</h1>".mysql_error());
// echo "sucess";
}


// DISTRICT LIST FUNCTIONS

/**
* treatment : none
* table : schools
* no. of paremeter : 2 - county_id or district_id and its value
* description : finds number of schools in district or county
*/


function create_district_list(){

	// get the args into an array
	$arg_list = func_get_args();

	// find number of values in array
    $numargs = func_num_args();
  	
  	// add all the values together in the array
    $arg_list = func_get_args();
    $id="";

	$sql="INSERT INTO assumptions_district_list VALUES(
					'$id',
					'$arg_list[0]',
					'$arg_list[1]',
					'$arg_list[2]',
					'$arg_list[3]',
					'$arg_list[4]',
					'$arg_list[5]',
					'$arg_list[6]',
					'$arg_list[7]',
					'$arg_list[8]',
					'$arg_list[9]',
					'$arg_list[10]',
					'$arg_list[11]',
					'$arg_list[12]',
					'$arg_list[13]'
					)";
$result=mysql_query($sql)or die("<h1>function : create_district_list <br/>Cannot insert</h1>".mysql_error());
// echo "sucess";
}


function numberOfSChools($district_id)
{
	$sql="SELECT COUNT(school_id) as num_of_schools FROM a_bysch  WHERE district_id = '$district_id'";
	$result=mysql_query($sql)or die("<h1>CANNOT GET SCHOOLS</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $num_of_schools=$row['num_of_schools'];
	}

	
}

function numberOfShistoSchools($district_id)
{
	$sql="SELECT COUNT(school_id) as num_of_shisto_schools FROM a_bysch WHERE district_id = '$district_id' AND ap_attached='Yes'";
	$result=mysql_query($sql)or die("<h1>CANNOT GET shisto schools</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $num_of_shisto_schools= $row['num_of_shisto_schools'];
	}
}

function albAmount($district_id){
	$sql="SELECT SUM(alb_requisition) AS alb_requisition FROM assumptions_school_list WHERE district_id='$district_id'";
	$result=mysql_query($sql)or die("<h1>CANNOT GET ALB AMOUNT</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		if ($row['alb_requisition']==0) {
			return 0;
		}else{
			return $row['alb_requisition'];
		}
	}
}

function pzqAmount($district_id){
	$sql="SELECT SUM(pzq_requsition) AS pzq_requsition FROM assumptions_school_list WHERE district_id='$district_id'";
	$result=mysql_query($sql)or die("<h1>CANNOT GET ALB AMOUNT</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		if ($row['pzq_requsition']==0) {
			return 0;
		}else{
			return $row['pzq_requsition'];
		}
	}
}

function districtExtraPzq(){

}

function districtAssumptionProduct($a,$b,$c)
{
	$a=getAssumptionVal($a);
	$b=getAssumptionVal($b);
	$c=getAssumptionVal($c);

	$product=$a*$b*$c;

	return $product;
}

function shistoDistrict($district_id){
	$sql="SELECT ap_attached FROM a_bysch WHERE district_id='$district_id'";
	$result=mysql_query($sql)or die("<h1>CANNOT GET shisto district</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		$ap_attached=$row['ap_attached'];
	}

	if ($ap_attached=='Yes') {
		# code...
		return 1;
	}else{
		return 0;
	}

}



#######################
#   COUNTY ALB LIST   #
#######################

// create 


function create_county_alb_list(){

	// get the args into an array
	$arg_list = func_get_args();

	// find number of values in array
    $numargs = func_num_args();
  	
    $id="";

	$sql="INSERT INTO assumptions_county_alb_list VALUES(
					'$id',
					'$arg_list[0]',
					'$arg_list[1]',
					'$arg_list[2]',
					'$arg_list[3]',
					'$arg_list[4]',
					'$arg_list[5]',
					'$arg_list[6]',
					'$arg_list[7]',
					'$arg_list[8]',
					'$arg_list[9]',
					'$arg_list[9]'
					)";
$result=mysql_query($sql)or die("<h1>function : create_county_alb_list <br/>Cannot insert</h1>".mysql_error());
// echo "sucess";
}

/**
* description : counts the districts in a county form schools table.
* This is because we used the schools table to do the planning.
*/
function numberOfDistricts($county_id){
	$sql="SELECT COUNT(district_id) as district_id FROM schools WHERE county_id='$county_id'";
	$result=mysql_query($sql)or die("<h1>CANNOT GET Districts</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['district_id'];
	}
}

/**
* description : counts the schools in a county form schools table.
* This is because we used the schools table to do the planning.
*/
function numberOfSChoolsCounty($county_id){
	$sql="SELECT COUNT(school_id) AS num_of_schools FROM schools WHERE county_id='$county_id'";
	$result=mysql_query($sql)or die("<h1>CANNOT GET schools in county</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['num_of_schools'];
	}
}

function total_children_to_treat($county_id){
	$sql="SELECT SUM(total_children_treated) AS children FROM assumptions_school_list WHERE county_id='$county_id'";
	$result=mysql_query($sql)or die("<h1>CANNOT GET children to treat</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		if ($row['children']==0) {
			return 0;
		}else{
			return $row['children'];
		}
	}
}


function total_adults_to_treat($county_id){
	$sql = "SELECT SUM(total_adults) AS adults FROM assumptions_school_list WHERE county_id = '$county_id'";
	$result = mysql_query($sql) or die("<h1>function name : total_adults_to_treat <br/>CANNOT GET ADULTS TO TREAT </h1>");

	while ($row=mysql_fetch_assoc($result)) {
		if ($row['adults']==0) {
			return 0;
		}else{
			return $row['adults'];
		}
	}
}

function county_alb_tabs_for_spoilage($county_id){
	$sql = "SELECT SUM(add_for_spoilage) AS spoilage FROM assumptions_school_list WHERE county_id = '$county_id'";
	$result = mysql_query($sql) or die("<h1>function name : county_alb_tabs_for_spoilage <br/>CANNOT GET add for spoilage </h1>");

	while ($row=mysql_fetch_assoc($result)) {
		if ($row['spoilage']==0) {
			return 0;
		}else{
			return $row['spoilage'];
		}
	}
}

function county_alb_tabs_round_up(){
	$sql = "SELECT SUM(tabs_round_up) AS tabs_round_up FROM assumptions_school_list WHERE county_id = '$county_id'";
	$result = mysql_query($sql) or die("<h1>function name : county_alb_tabs_round_up <br/>CANNOT GET add for rabs rouund up </h1>");

	while ($row=mysql_fetch_assoc($result)) {
		if ($row['tabs_round_up']==0) {
			return 0;
		}else{
			return $row['tabs_round_up'];
		}
	}
}

function county_district_extra_alb($county_id){
	$sql = "SELECT SUM(district_extra_alb) AS district_extra_alb FROM assumptions_district_list WHERE county_id = '$county_id'";
	$result = mysql_query($sql) or die("<h1>function name : county_district_extra_alb <br/>CANNOT GET add for district extra alb </h1>");

	while ($row=mysql_fetch_assoc($result)) {
		return $row['district_extra_alb'];
	}
}

function truncateTable($table_name){
	$sql = "TRUNCATE TABLE $table_name";
	$result = mysql_query($sql) or die("<h1>Cannot truncate table</h1>".mysql_error());

}


#######################
#   county pzq list   #
#######################

function create_county_pzq_list(){

	// get the args into an array
	$arg_list = func_get_args();

	// find number of values in array
    $numargs = func_num_args();
  	
    $id="";

	$sql="INSERT INTO assumptions_county_pzq_list VALUES(
					'$id',
					'$arg_list[0]',
					'$arg_list[1]',
					'$arg_list[2]',
					'$arg_list[3]',
					'$arg_list[4]',
					'$arg_list[5]',
					'$arg_list[6]',
					'$arg_list[7]',
					'$arg_list[8]',
					'$arg_list[9]',
					'$arg_list[10]',
					'$arg_list[11]'
					)";
$result=mysql_query($sql)or die("<h1>function : create_county_alb_list <br/>Cannot insert</h1>".mysql_error());
// echo "sucess";
}

function county_pzq_shisto_districts($county_id){
	$sql="SELECT SUM(shistoDistrict) AS shistoDistrict FROM assumptions_district_list WHERE county_id ='$county_id'";
	$result = mysql_query($sql) OR die("<h1>function name: county_pzq_shisto_districts<br/>Cannot get shisto districts</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['shistoDistrict'];
	}
}

// get shisto schools
function county_pzq_shisto_schools($county_id){
	$sql="SELECT SUM(numberOfShistoSchools) AS numberOfShistoSchools FROM assumptions_district_list WHERE county_id ='$county_id'";
	$result = mysql_query($sql) OR die("<h1>function name: county_pzq_shisto_schools<br/>Cannot get shisto schools</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['numberOfShistoSchools'];
	}
}

// get shisto targeted children
function county_pzq_shisto_targeted_children($county_id){
	$sql="SELECT SUM(total_children_treated_shisto) AS total_children_treated_shisto FROM assumptions_school_list WHERE county_id ='$county_id'";
	$result = mysql_query($sql) OR die("<h1>function name: county_pzq_shisto_targeted_children<br/>Cannot get shisto targeted childred</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		if ($row['total_children_treated_shisto']==0) {
			return 0;
		}else{
			return $row['total_children_treated_shisto'];
		}
	}
}


// get shisto adults
function county_pzq_shisto_adults($county_id){
	$sql="SELECT SUM(total_adults_to_treat_shisto) AS total_adults_to_treat_shisto FROM assumptions_school_list WHERE county_id ='$county_id'";
	$result = mysql_query($sql) OR die("<h1>function name: county_pzq_shisto_targeted_children<br/>Cannot get shisto targeted childred</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		if ($row['total_adults_to_treat_shisto']==0) {
			return 0;
		}else{
			return $row['total_adults_to_treat_shisto'];
		}
	}
}

// get shisto tabs for children
function county_pzq_shisto_tabs_for_children($county_id){
	$sql="SELECT SUM(total_tabs_for_children_shisto) AS total_tabs_for_children_shisto FROM assumptions_school_list WHERE county_id ='$county_id'";
	$result = mysql_query($sql) OR die("<h1>function name: county_pzq_shisto_tabs_for_children<br/>Cannot get shisto tabs for children</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['total_tabs_for_children_shisto'];
	}
}

// get shisto tabs for children
function county_pzq_shisto_tabs_for_adults($county_id){
	$sql="SELECT SUM(total_tabs_for_adults_shisto) AS total_tabs_for_adults_shisto FROM assumptions_school_list WHERE county_id ='$county_id'";
	$result = mysql_query($sql) OR die("<h1>function name: county_pzq_shisto_tabs_for_adults<br/>Cannot get shisto tabs for adults</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		if ($row['total_tabs_for_adults_shisto']==0) {
			return 0;
		}else{
			return $row['total_tabs_for_adults_shisto'];
		}
	}
}



// get shisto spoilage
function county_pzq_shisto_spoilage($county_id){
	$sql="SELECT SUM(to_add_spoilage_gap_shisto) AS to_add_spoilage_gap_shisto FROM assumptions_school_list WHERE county_id ='$county_id'";
	$result = mysql_query($sql) OR die("<h1>function name: county_pzq_shisto_spoilage<br/>Cannot get shisto spoilage</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		if ($row['to_add_spoilage_gap_shisto']==0) {
			return 0;
		}else{
			return $row['to_add_spoilage_gap_shisto'];
		}
	}
}


// get shisto tabs in tin
function county_pzq_shisto_tabs_in_tin($county_id){
	$sql="SELECT SUM(tabs_in_tin_shisto) AS tabs_in_tin_shisto FROM assumptions_school_list WHERE county_id ='$county_id'";
	$result = mysql_query($sql) OR die("<h1>function name: county_pzq_shisto_tabs_in_tin<br/>Cannot get shisto tabs in tin</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		if ($row['tabs_in_tin_shisto']==0) {
			return 0;
		}else{
			return $row['tabs_in_tin_shisto'];
		}
	}
}



// get shisto tabs in tin
function county_pzq_extra_for_districts($county_id){
	$sql="SELECT SUM(extra_pzq) AS extra_pzq FROM assumptions_district_list WHERE county_id ='$county_id'";
	$result = mysql_query($sql) OR die("<h1>function name: county_pzq_extra_for_districts<br/>Cannot get shisto extra for districts</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['extra_pzq'];
	}
}


##################
#  assumptions   #
##################

function summary_sheet_alb_treatment(){
	$sql="SELECT SUM(county_alb_total_children_to_treat)+SUM(county_alb_total_adults_to_treat) AS treatment FROM assumptions_county_alb_list";
	$result = mysql_query($sql) or die("<h1>Function name: summary_sheet_alb_treatment<br/> Cannot add up treaments</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['treatment'];
	}
}

function summary_sheet_pzq_treatment(){
	$sql="SELECT SUM(county_pzq_shisto_targeted_children)+SUM(county_pzq_shisto_adults) AS treatment FROM assumptions_county_pzq_list";
	$result = mysql_query($sql) or die("<h1>Function name: summary_sheet_pzq_treatment<br/> Cannot add up treaments</h1>".mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['treatment'];
	}
}



# ############################################################################################################### #
#                                     _   _                    __                 _                _              #
#                                    | | (_)                  / _|               | |              (_)             #
#  __ _ ___ ___ _   _ _ __ ___  _ __ | |_ _  ___  _ __  ___  | |_ ___  _ __   ___| |__   __ _ _ __ _ _ __   __ _  #
# / _` / __/ __| | | | '_ ` _ \| '_ \| __| |/ _ \| '_ \/ __| |  _/ _ \| '__| / __| '_ \ / _` | '__| | '_ \ / _` | #
#  (_| \__ \__ \ |_| | | | | | | |_) | |_| | (_) | | | \__ \ | || (_) | |    \__ \ | | | (_| | |  | | | | | (_| | #
# \__,_|___/___/\__,_|_| |_| |_| .__/ \__|_|\___/|_| |_|___/ |_| \___/|_|    |___/_| |_|\__,_|_|  |_|_| |_|\__, | #
#                              | |                                                                          __/ | #
#                              |_|                                                                         |___/  #
# ############################################################################################################### #

function create_assumption(){
	// get the args into an array
	$arg_list = func_get_args();

	// find number of values in array
    $numargs = func_num_args();
  	
    $id="";

	$sql="INSERT INTO assumption_sharing VALUES(
					'$id',
					'$arg_list[0]',
					'$arg_list[1]',
					'$arg_list[2]'
					)";
	$result=mysql_query($sql)or die("<h1>function : create_assumption <br/>Cannot insert</h1>".mysql_error());
}

function get_assumptions(){
	$sql="SELECT * FROM assumption_sharing";

	$result=mysql_query($sql) or die("<h1>function name: get_assumptions <br/>Cannot get Assumptions</h1>");

	$data=array();
	while ($row=mysql_fetch_assoc($result)) {
		$data[] = array('refrence' => $row['refrence'],
						'column' => $row['column_head'],
						'assumption' => $row['assumption'],
						'id' => $row['id']
						);
	}

	return $data;
}

function get_assumption_by_id($id){
	$sql="SELECT * FROM assumption_sharing WHERE id='$id'";

	$result=mysql_query($sql) or die("<h1>function name: get_assumption_by_id<br/>Cannot get assumption id number </h1>".$id.mysql_error());

	$data=array();
	while ($row=mysql_fetch_assoc($result)) {
		$data[] = array('refrence' => $row['refrence'],
						'column' => $row['column_head'],
						'assumption' => $row['assumption'],
						'id' => $row['id']
						);
	}

	return $data;

}

function update_assumptions(){
	// get the args into an array
	$arg_list = func_get_args();

	$id=array_shift($arg_list); // get and remove the table

	$sql="UPDATE assumption_sharing SET
					refrence = '$arg_list[0]',
					column_head = '$arg_list[1]',
					assumption = '$arg_list[2]'
					WHERE id ='$id'";
					
	$result=mysql_query($sql)or die("<h1>function : update_assumptions <br/>Cannot pdate</h1>".mysql_error());
	echo "sucess";
}

function deleteRow($table,$deleteid){
	$sql = "DELETE FROM $table WHERE id='$deleteid'";

	$result=mysql_query($sql) or die("<h1>Cannot delete the row for table </h1>".$table.mysql_error());
	

}

function distinctCount($field,$table){
	$query="SELECT DISTINCT($field) FROM $table";

	$result=mysql_query($query) OR die(mysql_error());

	$rows=mysql_num_rows($result);

	return $rows;
}

function plainCount($field,$table){
	$query="SELECT COUNT($field) AS counted FROM $table";

	$result=mysql_query($query);

	while ($row=mysql_fetch_assoc($result)) {
		return $row['counted'];
	}

}

function plainSum($field,$table){
	$query="SELECT SUM($field) AS sum_up FROM $table";

	$result=mysql_query($query)or die("<h1>Cannot sum up </h1>".$field.mysql_error());

	while ($row=mysql_fetch_assoc($result)) {
		return $row['sum_up'];
	}
}
 ?>