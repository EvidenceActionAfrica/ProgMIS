<?php 


include "includes/config.php";



	function getDistrict(){

		$query="SELECT DISTINCT district from form_attnt";

		$result=mysql_query($query) or die("<h1>Cannot get District dashAttntFunctions</h1>".mysql_error());



		$num=mysql_num_rows($result);



		return $num;

	}



	function numAttnt($q){

		$query="SELECT DISTINCT $q FROM form_attnt";

		$result=mysql_query($query) or die("<h1>Could not gte school</h1>".mysql_error());



		$num=mysql_num_rows($result);



		return $num;

	}



	function numAttntSth($q){

		$query="SELECT $q FROM form_attnt WHERE is_treating_bilharzia=0 ";

		$result=mysql_query($query) or die("<h1>Cannot get School for shisto</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



	/**

	* Selects only for bilharzia

	* But also if the school treated for bilharzia it also treated for sth

	*/

	function numAttntShistoAndSth($q){

		$query="SELECT $q FROM form_attnt WHERE is_treating_bilharzia !='0' ";

		$result=mysql_query($query) or die("<h1>Cannot get School for shisto</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



	function numAttntNothingDistributedSth(){

		$query="SELECT school FROM form_attnt WHERE

				is_treating_bilharzia !='0' AND

				form_e ='No' AND 

				form_n ='No' AND 

				form_s ='No' AND 

				form_ep ='No' AND 

				form_np ='No' AND 

				form_sp ='No' AND 

				albendazole = 'No' AND 

				praziquantel = 'No' AND 

				tablet_poles = 'No'	";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



	function numAttntNothingDistributedSthAndSshisto(){

		$query="SELECT school FROM form_attnt WHERE

				form_e ='No' AND 

				form_n ='No' AND 

				form_s ='No' AND 

				form_ep ='No' AND 

				form_np ='No' AND 

				form_sp ='No' AND 

				albendazole = 'No' AND 

				praziquantel = 'No' AND 

				tablet_poles = 'No'	";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



		function numAttntOnylFormsDistributedSth(){

		$query="SELECT school FROM form_attnt WHERE

				is_treating_bilharzia ='0' AND

				form_e ='Yes' AND 

				form_n ='Yes' AND 

				form_s ='Yes' AND 

				form_ep ='Yes' AND 

				form_np ='Yes' AND 

				form_sp ='Yes' AND 

				albendazole = 'No' AND 

				praziquantel = 'No' AND 

				tablet_poles = 'No'	";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



	function numAttntOnylFormsDistributedSthAndShisto(){

		$query="SELECT school FROM form_attnt WHERE

				form_e ='Yes' AND 

				form_n ='Yes' AND 

				form_s ='Yes' AND 

				form_ep ='Yes' AND 

				form_np ='Yes' AND 

				form_sp ='Yes' AND 

				albendazole = 'No' AND 

				praziquantel = 'No' AND 

				tablet_poles = 'No'	";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



	function numAttntOnyPolesSth(){

		$query="SELECT school FROM form_attnt WHERE

				is_treating_bilharzia ='0' AND

				form_e ='No' AND 

				form_n ='No' AND 

				form_s ='No' AND 

				form_ep ='No' AND 

				form_np ='No' AND 

				form_sp ='No' AND 

				albendazole = 'No' AND 

				praziquantel = 'No' AND 

				tablet_poles = 'Yes'";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



	function numAttntOnyPolesSthAndShisto(){

		$query="SELECT school FROM form_attnt WHERE

				is_treating_bilharzia !='0' AND

				form_e ='No' AND 

				form_n ='No' AND 

				form_s ='No' AND 

				form_ep ='No' AND 

				form_np ='No' AND 

				form_sp ='No' AND 

				albendazole = 'No' AND 

				praziquantel = 'No' AND 

				tablet_poles = 'Yes'";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



	function numAttntOnlyPolesSAndFormsSth(){

		$query="SELECT school FROM form_attnt WHERE

				is_treating_bilharzia !='0' AND

				form_e ='Yes' AND 

				form_n ='Yes' AND 

				form_s ='Yes' AND 

				form_ep ='Yes' AND 

				form_np ='Yes' AND 

				form_sp ='Yes' AND 

				albendazole = 'No' AND 

				praziquantel = 'No' AND 

				tablet_poles = 'Yes'";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



		function numAttntOnlyPolesSAndFormsSthAndShisto(){

		$query="SELECT school FROM form_attnt WHERE

				form_e ='Yes' AND 

				form_n ='Yes' AND 

				form_s ='Yes' AND 

				form_ep ='Yes' AND 

				form_np ='Yes' AND 

				form_sp ='Yes' AND 

				albendazole = 'No' AND 

				praziquantel = 'No' AND 

				tablet_poles = 'Yes'";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}





	function numAttntOnlyDrugsSth(){

		$query="SELECT school FROM form_attnt WHERE

				is_treating_bilharzia !='0' AND

				form_e ='No' AND 

				form_n ='No' AND 

				form_s ='No' AND 

				form_ep ='No' AND 

				form_np ='No' AND 

				form_sp ='No' AND 

				albendazole = 'Yes' AND 

				praziquantel = 'Yes' AND 

				tablet_poles = 'No'";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



	function numAttntOnlyDrugsSthAndShisto(){

		$query="SELECT school FROM form_attnt WHERE

				form_e ='No' AND 

				form_n ='No' AND 

				form_s ='No' AND 

				form_ep ='No' AND 

				form_np ='No' AND 

				form_sp ='No' AND 

				albendazole = 'Yes' AND 

				praziquantel = 'Yes' AND 

				tablet_poles = 'No'";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



	function OnlyDrugsAndFormsSth(){

		$query="SELECT school FROM form_attnt WHERE

				is_treating_bilharzia !='0' AND

				form_e ='Yes' AND 

				form_n ='Yes' AND 

				form_s ='Yes' AND 

				form_ep ='Yes' AND 

				form_np ='Yes' AND 

				form_sp ='Yes' AND 

				albendazole = 'Yes' AND 

				praziquantel = 'Yes' AND 

				tablet_poles = 'No'";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



		function OnlyDrugsAndFormsSthAndShisto(){

		$query="SELECT school FROM form_attnt WHERE

				form_e ='Yes' AND 

				form_n ='Yes' AND 

				form_s ='Yes' AND 

				form_ep ='Yes' AND 

				form_np ='Yes' AND 

				form_sp ='Yes' AND 

				albendazole = 'Yes' AND 

				praziquantel = 'Yes' AND 

				tablet_poles = 'No'";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



	function OnlyDrugsAndPolesSth(){

		$query="SELECT school FROM form_attnt WHERE

				is_treating_bilharzia !='0' AND

				form_e ='No' AND 

				form_n ='No' AND 

				form_s ='No' AND 

				form_ep ='No' AND 

				form_np ='No' AND 

				form_sp ='No' AND 

				albendazole = 'Yes' AND 

				praziquantel = 'Yes' AND 

				tablet_poles = 'Yes'";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



		function OnlyDrugsAndPolesSthAndShisto(){

		$query="SELECT school FROM form_attnt WHERE

				form_e ='No' AND 

				form_n ='No' AND 

				form_s ='No' AND 

				form_ep ='No' AND 

				form_np ='No' AND 

				form_sp ='No' AND 

				albendazole = 'Yes' AND 

				praziquantel = 'Yes' AND 

				tablet_poles = 'Yes'";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



	function OnlyDrugsAndPolesAndFormsSth(){

		$query="SELECT school FROM form_attnt WHERE

				is_treating_bilharzia !='0' AND

				form_e ='Yes' AND 

				form_n ='Yes' AND 

				form_s ='Yes' AND 

				form_ep ='Yes' AND 

				form_np ='Yes' AND 

				form_sp ='Yes' AND 

				albendazole = 'Yes' AND 

				praziquantel = 'Yes' AND 

				tablet_poles = 'Yes'";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}



	function OnlyDrugsAndPolesAndFormsSthAndShisto(){

		$query="SELECT school FROM form_attnt WHERE

				form_e ='Yes' AND 

				form_n ='Yes' AND 

				form_s ='Yes' AND 

				form_ep ='Yes' AND 

				form_np ='Yes' AND 

				form_sp ='Yes' AND 

				albendazole = 'Yes' AND 

				praziquantel = 'Yes' AND 

				tablet_poles = 'Yes'";

		$result=mysql_query($query) or die("<h1>Cannot get School</h1>".mysql_error());



		$num= mysql_num_rows($result);



		return $num;

	}







 ?>