<div class="report_header_container">
	<div class="header_image_container">
		<div id="header_image_left">
			<img src="images/report_header_left.png" class="header_image"/>
		</div>
		<div id="header_image_center">
			<img src="images/report_header_left.png" class="header_image"/>
		</div>
		<div id="header_image_right">
			<img src="images/report_header_left.png" class="header_image"/>
		</div>
	</div>
	<div id="report_heading">
		<h1 class="report_heading_style">
			REPUBLIC OF KENYA
			<br />
			NATIONAL SCHOOL-BASED DEWORMING PROGRAMME
			<br />
			<?php 


				// get the year number
				// get the present year and stip the last number
				function getYearEnd(){
					// echo "<br/>";
					if (isset($_SESSION['database'])) {
						$str=$_SESSION['database'];
						$last = $str[strlen($str)-1]; 
						// echo "<br/>";
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
					
				echo $previous_year."-".$this_year;
				?>
			National Treatment Results
		</h1>
	</div>
</div>