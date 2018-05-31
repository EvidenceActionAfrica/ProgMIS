<?php 

// $hostname = 'localhost';



// $username = 'root';



// $password = '';



// $database="evidence_action";



// mysql_connect($hostname,$username,$password);



// mysql_select_db($database);



include "includes/config.php";



function numOfDistrictsCovered(){

	$query="SELECT DISTINCT district_id FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get districts</h1><br/>".mysql_error());



	$num=mysql_num_rows($result);

	



	return $num;

}



function numOfSchoolsCovered(){

	$query = "SELECT DISTINCT school_name FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get Schools</h1><br/>".mysql_error());



	$num=mysql_num_rows($result);



	return $num;

}



/**

 * Both children and aAdults

 * form form_s and form_s_class

 */

function numOfDewormed(){

	$query="SELECT SUM(ecd_treated_children_total) +

			SUM(ecd_adults_treated) +

			SUM(non_enrolled_total) +

			SUM(non_enrolled_adults_treated) as sum FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get Sum form form S</h1><br/>".mysql_error());



	while ($row=mysql_fetch_assoc($result)) {

	

		 $form_s=$row['sum'];

	}

	 // "<br/>";

	$query2="SELECT SUM(number_treated_total) +	 SUM(adults_treated) as sum FROM form_s_class";

	$result2=mysql_query($query2) or die("<h1>Cannot get Sum for Form_s_class</h1><br/>".mysql_error());



	while ($row2=mysql_fetch_assoc($result2)) {

	

		 $form_s_class=$row2['sum'];

	}



	$total=$form_s+$form_s_class;



	return  $total;



}



/**

 * Both children only

 * form form_s and form_s_class

 */

function numOfDewormedChildren(){

	$query="SELECT SUM(ecd_treated_children_total) +

			SUM(non_enrolled_total) 

			as sum FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get Sum form form S children dewormed</h1><br/>".mysql_error());



	while ($row=mysql_fetch_assoc($result)) {

	

		 $form_s=$row['sum'];

	}

	 // "<br/>";

	$query2="SELECT SUM(number_treated_total) as sum FROM form_s_class";

	$result2=mysql_query($query2) or die("<h1>Cannot get Sum for Form_s_class children dewormed</h1><br/>".mysql_error());



	while ($row2=mysql_fetch_assoc($result2)) {

	

		 $form_s_class=$row2['sum'];

	}



	$total=$form_s+$form_s_class;



	return  $total;



}



/**

 * Divide two functions

 * numOfDistrictsCovered()and numOfDewormedChildren() to get the average children dewrormed

 * per district

 */

function  averageChildrenDewormedPerDistrict(){

	$districts=numOfDistrictsCovered();

	$children=numOfDewormedChildren();



	$result= $children / $districts;



	return $result;



}



function numPrimaryAndEcdChildrenDewormed(){

	$query="SELECT SUM(ecd_treated_children_total) 

			as sum FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get Sum form form S children dewormed</h1><br/>".mysql_error());



	while ($row=mysql_fetch_assoc($result)) {

	

		 $form_s=$row['sum'];

	}

	 // "<br/>";

	$query2="SELECT SUM(number_treated_total) as sum FROM form_s_class";

	$result2=mysql_query($query2) or die("<h1>Cannot get Sum for Form_s_class children dewormed</h1><br/>".mysql_error());



	while ($row2=mysql_fetch_assoc($result2)) {

	

		 $form_s_class=$row2['sum'];

	}



	$total=$form_s+$form_s_class;



	return  $total;

}



// function ecdChildrenDewormed(){

// 	$query="SELECT SUM(ecd_treated_children_total) 

// 			as sum FROM form_s";

// 	$result=mysql_query($query) or die("<h1>Cannot get Sum form form S children dewormed</h1><br/>".mysql_error());



// 	while ($row=mysql_fetch_assoc($result)) {

	

// 		 return $form_s=$row['sum'];

// 	}

// }



/**

 * Take a column and add that column

 * form form_s i.e ecd 

 */

function ecdChildrenDewormed($q){

	$query="SELECT SUM($q) 

			as sum FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get Sum form form S children dewormed</h1><br/>".mysql_error());



	while ($row=mysql_fetch_assoc($result)) {

	

		 return $row['sum'];

	}

}

/**

 * Take a column and add that column

 * form form_s i.e non enrolled

 */

function nonEnrolledChildrenDewormed($q){

	$query="SELECT SUM($q) 

			as sum FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get Sum form form S children dewormed</h1><br/>".mysql_error());



	while ($row=mysql_fetch_assoc($result)) {

	

		 return $row['sum'];

	}

}



/**

 * Take a column and add that column

 * form form_s_class i.e primary

 */

function primaryChildrenDewormed($q){

	$query="SELECT SUM($q) 

			as sum FROM form_s_class";

	$result=mysql_query($query) or die("<h1>Cannot get Sum form form S children dewormed</h1><br/>".mysql_error());



	while ($row=mysql_fetch_assoc($result)) {

	

		 return $row['sum'];

	}

}



function allNonEnrolled2_5ChildrenDewormed(){

	$query="SELECT SUM(years_2_5_male)+

			SUM(years_2_5_female) as sum FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get 2-5 children dewormed</h1><br/>".mysql_error());



	while ($row=mysql_fetch_assoc($result)) {

		 return $row['sum'];		    	

	}

}



function nonEnrolledOver6(){

	$query="SELECT SUM(years_6_10_male)+

			SUM(years_6_10_female) +

			SUM(years_11_14_male) +

			SUM(years_11_14_female) +

			SUM(years_15_18_male) +

			SUM(years_15_18_female) AS sum FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get over 6 dewormed</h1><br/>".mysql_error());	

	

	while ($row=mysql_fetch_assoc($result)) {

		return $row['sum'];				    	

	}		

}



function nonEnrolledOver6Male(){

	$query="SELECT SUM(years_6_10_male)+

			SUM(years_11_14_male) +

			SUM(years_15_18_male) 

			AS sum FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get over 6 dewormed</h1><br/>".mysql_error());	

	

	while ($row=mysql_fetch_assoc($result)) {

		return $row['sum'];				    	

	}		

}



function nonEnrolledOver6Female(){

	$query="SELECT SUM(years_6_10_female)+

			SUM(years_11_14_female) +

			SUM(years_15_18_female) 

			AS sum FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get over 6 dewormed</h1><br/>".mysql_error());	

	

	while ($row=mysql_fetch_assoc($result)) {

		return $row['sum'];				    	

	}		

}



function adultsDewormed(){

	$query="SELECT SUM(ecd_adults_treated) +

			SUM(non_enrolled_adults_treated) as sum FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get Sum form form S</h1><br/>".mysql_error());



	while ($row=mysql_fetch_assoc($result)) {

	

		 $form_s_adults=$row['sum'];

	}

	 // "<br/>";

	$query2="SELECT SUM(adults_treated) as sum FROM form_s_class";

	$result2=mysql_query($query2) or die("<h1>Cannot get Sum for Form_s_class</h1><br/>".mysql_error());



	while ($row2=mysql_fetch_assoc($result2)) {

	

		 $form_s_class_adults=$row2['sum'];

	}



	$total=$form_s_adults+$form_s_class_adults;



	return  $total;

}



/**

 * Tablets spoilt form both form_s and form_s_class

 */

function numSpoiltTablets(){

	$query="SELECT SUM(ecd_tablets_spoilt) +

			SUM(non_enrolled_tablets_spoilt) as sum FROM form_s";

	$result=mysql_query($query) or die("<h1>Cannot get Sum form form S</h1><br/>".mysql_error());



	while ($row=mysql_fetch_assoc($result)) {

	

		 $form_s_tablets_spoilt=$row['sum'];

	}

	 // "<br/>";

	$query2="SELECT SUM(tablets_spoilt) as sum FROM form_s_class";

	$result2=mysql_query($query2) or die("<h1>Cannot get Sum for Form_s_class</h1><br/>".mysql_error());



	while ($row2=mysql_fetch_assoc($result2)) {

	

		 $form_s_class_tablets_spoilt=$row2['sum'];

	}



	$total=$form_s_tablets_spoilt+$form_s_class_tablets_spoilt;



	return  $total;

}



/**

 * Addition of the functions total dewormed and spoilt tablets

 */

function tabletsUsed(){

	$total = numOfDewormed()+numSpoiltTablets();



	return $total;

}



function ratioSpoiltToSuppliedTablets(){

	$result= numSpoiltTablets()/ecdChildrenDewormed('albendazole_recieved');



	return $result;

}



function ratioSuippliedToSpoiltTablets(){

	$result= ecdChildrenDewormed('albendazole_recieved')/numSpoiltTablets();



	return $result;

}



##########################SHISTO#######################################



function num($field,$table){

	$query = "SELECT DISTINCT $field FROM $table WHERE form_s_returned = 'Yes' ";

	$result=mysql_query($query) or die("<h1>Could not get ".$field."</h1>".mysql_error());



	$num= mysql_num_rows($result);



	return $num;

}











 ?>