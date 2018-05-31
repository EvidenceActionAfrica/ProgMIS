<?php if(basename($_SERVER['PHP_SELF']) == '+reportNational.php') {
	//basename($_SERVER['PHP_SELF']) will return the file name of the current file, in this case, either "+reportNational.php" or "+reportProgram.php".
?>
	<div class="divHeader">
		<div class="divTitle">
			DSW 
			<?php 
				if($country_val == 1) {
					echo "KENYA";
				} elseif($country_val == 2) {
					echo "UGANDA";
				} else {
					echo "MALAWI";
				}
			?>
			NATIONAL<br>
			REPORT FOR
			<?php
				if($glbMth == 1) {
					echo "JANUARY";
				} elseif ($glbMth == 2) {
					echo "FEBRUARY";
				} elseif ($glbMth == 3) {
					echo "MARCH";
				} elseif ($glbMth == 4) {
					echo "APRIL";
				} elseif ($glbMth == 5) {
					echo "MAY";
				} elseif ($glbMth == 6) {
					echo "JUNE";
				} elseif ($glbMth == 7) {
					echo "JULY";
				} elseif ($glbMth == 8) {
					echo "AUGUST";
				} elseif ($glbMth == 9) {
					echo "SEPTEMBER";
				} elseif ($glbMth == 10) {
					echo "OCTOBER";
				} elseif ($glbMth == 11) {
					echo "NOVEMBER";
				} else {
					echo "DECEMBER";
				}
			?>
			<?php echo $glbYr?>
		</div>
		<div class="divImage">
			<img src="+img/+ReportDSW.png"/>
		</div>
	</div>
<?php } else {
//Since this file is shared between +reportNational.php" and "+reportProgram.php", then this part of the construct will automatically execute when "+reportProgram.php" calls it.
?>
	<div class="divHeader">
		<div class="divTitle">
			DSW 
			<?php 
				if($country_val == 1) {
					echo "KENYA";
				} elseif($country_val == 2) {
					echo "UGANDA";
				} else {
					echo "MALAWI";
				}
			?>
			<?php 
				echo strtoupper($glbAdpProg);
			?>
			<br>
			REPORT FOR
			<?php
				if($glbMth == 1) {
					echo "JANUARY";
				} elseif ($glbMth == 2) {
					echo "FEBRUARY";
				} elseif ($glbMth == 3) {
					echo "MARCH";
				} elseif ($glbMth == 4) {
					echo "APRIL";
				} elseif ($glbMth == 5) {
					echo "MAY";
				} elseif ($glbMth == 6) {
					echo "JUNE";
				} elseif ($glbMth == 7) {
					echo "JULY";
				} elseif ($glbMth == 8) {
					echo "AUGUST";
				} elseif ($glbMth == 9) {
					echo "SEPTEMBER";
				} elseif ($glbMth == 10) {
					echo "OCTOBER";
				} elseif ($glbMth == 11) {
					echo "NOVEMBER";
				} else {
					echo "DECEMBER";
				}
			?>
			<?php echo $glbYr?>
		</div>
		<div class="divImage">
			<img src="+img/+ReportDSW.png"/>
		</div>
	</div>
<?php } ?>