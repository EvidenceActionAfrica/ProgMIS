<?php 
	// get the year number
	// get the present year and stip the last number
	function getYearEnd(){
		if (isset($_SESSION['database'])) {

			$str=$_SESSION['database'];
			$last = $str[strlen($str)-1]; 
			// if last letter is a letter make it one
			if (!is_numeric($last)) {
				$last = 2;
			}
			return $last;
		}else{
			return '2';
		}

	} 

	// get the year from the end of the database name
	// i.e 2 or 3
	$year_end=getYearEnd();

	//if the year is 3 and above 
	// the current date is the current year minus 1, then  plus 2, minus the year chosen
	// otherwise if its year 2 its the current year minus 1
	if ($year_end>2) {
		$this_year=date("Y")-1; 
		$this_year=$this_year+($year_end-2);
	}else{
		$this_year=date("Y")-1; 
	}


	$previous_year=$this_year-1;

	// echo $previous_year."-".$this_year;

	// for now just harcode it
	echo "2014-2015‏";

 ?>