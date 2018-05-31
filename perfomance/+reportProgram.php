<?php
	ob_start();
	include('header-.php');
	//1. Data Preload: Access the "dsw_per_adoption_rates" table and get all the available years so as to populate the drop-down menu "selAdpYr" of "frmYrMth" when page loads.
	//Note: This statemement only returns the available years from the database and is used to populate the dropdown list with these years. It does NOT set a specific year. Since the ORDER is set to DESC, then the largest AVAILABLE year value will be the default on the list.
	$sqlAdpYr = "SELECT DISTINCT year FROM dsw_per_adoption_rates WHERE country = '$country_val' ORDER BY year DESC";
	$qryAdpYr = mysqli_query($mysqli, $sqlAdpYr);
	//Note: SQL queries like these and their results cannot be shared by multiple variables/statements. Hence, it is common to see redundant statements like these repeated throughout this script.
	
	
	
	//2. Global Variables: "glbYr" and "glbMth" are global variables within the scope of this file and all other included files such as: "+mainPageHeading.php".
	//They have to be set in order for the current year and month values be made accessible throught this script. This is done by handling the On-Click event for the command button "inAdpYrMthProg.
	if(isset($_GET["inAdpYrMthProg"])) {
		//Global Variables "glbYr" and "glbMth" are assigned values here.
		//The user has chosen a Year and a Month and hit the "Select" button ("inAdpYrMthProg"). Therefore, the year and month have now been EXPLICITLY set by the user.
		$glbYr = $_GET["selAdpYr"];
		$glbMth = $_GET["selAdpMth"];
		$glbAdpProg = $_GET["selAdpProg"];
	} else {
		$qryInAdpYr = mysqli_query($mysqli, "SELECT DISTINCT year FROM dsw_per_adoption_rates WHERE country = '$country_val' ORDER BY year DESC");
		$assocAdpYr = mysqli_fetch_assoc($qryInAdpYr);
		$glbYr = $assocAdpYr['year'];
		$sqlAdpMth = "SELECT DISTINCT month FROM dsw_per_adoption_rates WHERE country = '$country_val' AND year = '$glbYr' ORDER BY month DESC";
		//Note: This statement will return the latest month value that holds data in the database (Since the ORDER is set to DESC, then the largest AVAILABLE month value will be picked.)
		//Combined with "glbYr" which holds the largest year value ("$qryAdpYr" that had the SQL statement defined in 1. Data Preload), then we can expect this statement to return the latest year and month.
		//Use this statement when you want to load the latest month and year vaules.
		$qryAdpMth = mysqli_query($mysqli, $sqlAdpMth);
		$assocAdpMth = mysqli_fetch_assoc($qryAdpMth);
		$glbMth = $assocAdpMth['month'];
		//Now get the program.
		$qryInAdpProg = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates` WHERE country='$country_val' AND year = '$glbYr' ORDER BY program");
		$assocAdpProg = mysqli_fetch_assoc($qryInAdpProg);
		$glbAdpProg = $assocAdpProg['program'];
	}
	
	//This statement must be placed here as $glbYr now has a value. If we didn't then $glbYr would be empty and the SQL statement would not return anything, hence the dropdown list selAdpProg would not be populated.
	$sqlAdpProg = "SELECT distinct program FROM `dsw_per_adoption_rates` WHERE country='$country_val' AND year = '$glbYr' ORDER BY program";
	$qryAdpProg = mysqli_query($mysqli, $sqlAdpProg);
	
?>
<html>
	<head>
		<?php require_once("includes/+report.php"); ?>
	</head>
	<style>
		@font-face { font-family: TSTAR Mono Round; src: url('+font/TSTARMonoRoundReg.otf'); }
	</style>
	<body>
		<div class="clearFix"></div>
			<div class="divMain">
				<div class="col-md-2">
					<div class="sidebar">
						<?php require_once('includes/left_bar.php'); ?>
					</div>
				</div>
				<div class="divBody">
					<div id="divYrMth">
						<form id="frmYrMth" method="get">
							<select class="drpGen" id="selAdpYr" name="selAdpYr">
								<?php while($AdpYr = mysqli_fetch_assoc($qryAdpYr)) { ?>
								<option value="<?php echo $AdpYr['year']; ?>"<?php if ($glbYr == $AdpYr['year']) echo 'selected'; ?>><?php echo $AdpYr['year']; ?></option>
								<?php } ?>
							</select>
							<select class="drpGen" id="selAdpMth" name="selAdpMth">
								<option value='1'<?php if ($glbMth == 1) echo 'selected'; ?>>January</option>
								<option value='2'<?php if ($glbMth == 2) echo 'selected'; ?>>February</option>
								<option value='3'<?php if ($glbMth == 3) echo 'selected'; ?>>March</option>
								<option value='4'<?php if ($glbMth == 4) echo 'selected'; ?>>April</option>
								<option value='5'<?php if ($glbMth == 5) echo 'selected'; ?>>May</option>
								<option value='6'<?php if ($glbMth == 6) echo 'selected'; ?>>June</option>
								<option value='7'<?php if ($glbMth == 7) echo 'selected'; ?>>July</option>
								<option value='8'<?php if ($glbMth == 8) echo 'selected'; ?>>August</option>
								<option value='9'<?php if ($glbMth == 9) echo 'selected'; ?>>September</option>
								<option value='10'<?php if ($glbMth == 10) echo 'selected'; ?>>October</option>
								<option value='11'<?php if ($glbMth == 11) echo 'selected'; ?>>November</option>
								<option value='12'<?php if ($glbMth == 12) echo 'selected'; ?>>December</option>
							</select>
							<select class="drpGen" id="selAdpProg" name="selAdpProg">
								<?php while($AdpProg = mysqli_fetch_assoc($qryAdpProg)) { ?>
								<option value="<?php echo $AdpProg['program']; ?>"<?php if ($glbAdpProg == $AdpProg['program']) echo 'selected'; ?>><?php echo $AdpProg['program']; ?></option>
								<?php } ?>
							</select>
							<input class="btnGen btnAdpYrMthProg" id="inAdpYrMthProg" name="inAdpYrMthProg" type="submit" value="Select">
						</form>
					</div>
					<div id="divGenPDF">
						<input class="btnGen btnGenPDF" id="inGenPDF" name="inGenPDF" type="submit" style="margin-left: 110px;" value="PDF" hidden>
					</div>
					<div class="clrBth"></div>
					<div id="divPrntPage">
						<?php include("+mainPageHeading.php"); ?>
						<p class="sectionHeader">OPERATIONAL DATA</p>
						
						<div id="divAdptRate">
							Adoption Rate
							<div id="divVertBars">
								<div class="grpBarGrph">
									<div class="verM1">
										<div id="barM1">
											<div id="mtrM1"></div>
										</div>
										<?php if ((int)$glbMth <= 3) { ?>
											<b style="vertical-align: text-top;">Jan</b>
										<?php } elseif (((int)$glbMth > 3) && ((int)$glbMth <= 6)) { ?>
											<b style="vertical-align: text-top;">Apr</b>
										<?php } elseif (((int)$glbMth > 6) && ((int)$glbMth <= 9)) { ?>
											<b style="vertical-align: text-top;">Jul</b>
										<?php } else { ?>
											<b>Oct</b>
										<?php } ?>
									</div>
									<div class="verM2">
										<div id="barM2">
											<div id="mtrM2"></div>
										</div>
										<?php if ((int)$glbMth <= 3) { ?>
											<b style="vertical-align: text-top;">Feb</b>
										<?php } elseif (((int)$glbMth > 3) && ((int)$glbMth <= 6)) { ?>
											<b style="vertical-align: text-top;">May</b>
										<?php } elseif (((int)$glbMth > 6) && ((int)$glbMth <= 9)) { ?>
											<b style="vertical-align: text-top;">Aug</b>
										<?php } else { ?>
											<b style="vertical-align: text-top;">Nov</b>
										<?php } ?>
									</div>
									<div class="verM3">
										<div id="barM3">
											<div id="mtrM3"></div>
										</div>
										<?php if ((int)$glbMth <= 3) { ?>
											<b style="vertical-align: text-top;">Mar</b>
										<?php } elseif (((int)$glbMth > 3) && ((int)$glbMth <= 6)) { ?>
											<b style="vertical-align: text-top;">Jun</b>
										<?php } elseif (((int)$glbMth > 6) && ((int)$glbMth <= 9)) { ?>
											<b style="vertical-align: text-top;">Sep</b>
										<?php } else { ?>
											<b style="vertical-align: text-top;">Dec</b>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<div class="divAdoptionTrend">
							Adoption Trend
							<div id="divLineGraph" style="width:638px; height:317px"></div>
						</div>
						<br>
						<div id="divPromoters">
							Promoters
							<div id="divPiePromoters"></div>
						</div>
						<div id="divChlorineUsage">
							Chlorine Usage
							<div id="divPieChloUse"></div>
						</div>
						<div id="divRecordedIssues">
							Recorded Issues
							<div id="divPieRecIssue"></div>
						</div>
						<br/><br/>
						<p class="sectionHeader">NUMBERS AT A GLANCE</p>
						<table border="1" style="width:100%; font-family: TSTAR Mono Round; font-size: 1.1em; font-weight: bold;">
							<colgroup>
								<col style="width:40%">
								<col style="width:10%">
								<col style="width:40%">
								<col style="width:10%">
							</colgroup>  
							<tr>
								<td>Number of Chlorine dispensers installed</td>
								<td>
									<?php
										$sqlTblChloInst = "SELECT * FROM dispenser_database WHERE country='$country_val' and installation_date like '$glbYr/%' AND program_name = '" . $glbAdpProg . "'";
										$qryTblChloInst = mysqli_query($mysqli, $sqlTblChloInst) or die(mysqli_query($mysqli));
										$tblChloInst = mysqli_num_rows($qryTblChloInst);
										echo number_format("$tblChloInst");
									?>
								</td>
								<td>Total number of Chlorine deliveries made</td>
								<td>
									<?php
										$sqlTblChloDeliv = "SELECT SUM(`num_of_Deliveries`) AS TTLDELIV FROM `dsw_per_chlorine` WHERE country = '$country_val' AND program = '" . $glbAdpProg . "'";
										$qryTblChloDeliv = mysqli_query($mysqli, $sqlTblChloDeliv) or die(mysqli_query($mysqli));
										$assocTblChloDeliv = mysqli_fetch_assoc($qryTblChloDeliv);
										$tblChloDeliv = $assocTblChloDeliv['TTLDELIV'];
										echo number_format($tblChloDeliv);
									?>
								</td>
							</tr>
							<tr>
								<td>Number of people with access to chlorine dispensers</td>
								<td>
									<?php
										$qryPplSvd = "SELECT SUM(pple_served) AS PPLE FROM dispenser_database WHERE country='$country_val' AND program_name = '" . $glbAdpProg . "'";
										$rsltPplSvd = mysqli_query($mysqli, $qryPplSvd) or die(mysqli_query($mysqli));
										$assocPplSvd = mysqli_fetch_assoc($rsltPplSvd);
										$pplSvd = $assocPplSvd['PPLE'];
										
										echo number_format($assocPplSvd['PPLE']);
									?>
								</td>
								<td>Total liters of Chlorine used</td>
								<td>
									<?php
										$sqlTblChloUsed = "SELECT SUM(Jerrican_delivered) AS _sum_num FROM dsw_per_chlorine WHERE country='$country_val' AND program = '" . $glbAdpProg . "'";
										$qryTblChloUsed = mysqli_query($mysqli, $sqlTblChloUsed) or die(mysqli_query($mysqli));
										$assocTblChloUsed = mysqli_fetch_assoc($qryTblChloUsed);
										$tblChloUsed = $assocTblChloUsed['_sum_num'];
										echo number_format($tblChloUsed * 5);
									?>
								l
								</td>
							</tr>
							<tr>
								<td>Percentage of dispensers that are operational during unannounced visits</td>
								<td>
								<?php
									$query_hardwareProb = "SELECT program FROM dsw_per_dispensed_rates WHERE country='$country_val' AND month = '$glbMth' AND s208_dispprob = '1' AND year = '$glbYr' AND program = '" . $glbAdpProg . "'";
									$result_hardwareProb = mysqli_query($mysqli, $query_hardwareProb) or die(mysqli_query($mysqli));
									$hardwareProb = mysqli_affected_rows($mysqli);
									$funcChloDisp = $tblChloInst - $hardwareProb;
									echo round(($funcChloDisp / $tblChloInst) * 100) . "%";
								?>
								</td>
								<td>Average 30 day Chlorine usage</td>
								<td>
									<?php
										$sqlTblAvgUse = "SELECT AVG(`avrg_30day_usage_litres`) AS AVGUSE FROM `dsw_per_chlorine` WHERE country = '$country_val' AND avrg_30day_usage_litres!='' AND program = '" . $glbAdpProg . "'";
										$qryTblAvgUse = mysqli_query($mysqli, $sqlTblAvgUse) or die(mysqli_query($mysqli));
										$assocTblAvgUse = mysqli_fetch_assoc($qryTblAvgUse);
										$tblAvgUse = $assocTblAvgUse['AVGUSE'];
										echo round($tblAvgUse);
									?>
								l
								</td>
							</tr>
							<tr>
								<td>Number of days between when an issue is reported and when it is resolved</td>
								<td>
									<?php
										
									?>
								</td>
								<td>Average verification pass rate</td>
								<td>
									<?php
										$sqlTblVerifRte = "SELECT COUNT(`t311_wpt_pass`) AS VERIFRTE FROM `dsw_per_verification` WHERE country = '$country_val'";
										$qryTblVerifRte = mysqli_query($mysqli, $sqlTblVerifRte) or die(mysqli_query($mysqli));
										$assocTblVerifRte = mysqli_fetch_assoc($qryTblVerifRte);
										$tblVerifRte = $assocTblVerifRte['VERIFRTE'];
																			
										$sqlTblVerifPassRte = "SELECT SUM(`t311_wpt_pass`) AS VERIFPASSRTE FROM `dsw_per_verification` WHERE country = '$country_val'";
										$qryTblVerifPassRte = mysqli_query($mysqli, $sqlTblVerifPassRte) or die(mysqli_query($mysqli));
										$assocTblVerifPassRte = mysqli_fetch_assoc($qryTblVerifPassRte);
										$tblVerifPassRte = $assocTblVerifPassRte['VERIFPASSRTE'];
										
										echo round(($tblVerifPassRte / $tblVerifRte) * 100) . "%";
									?>
								</td>
							</tr>
							<tr>
								<td>Percentage Total Chlorine residue (TCR)</td>
								<td>
									<?php
										$sumprod_a_n = 0;
										$nume_weit_sum = 0;
									
										$query = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$glbMth' AND program = '$glbAdpProg' AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND year = '$glbYr'";
										$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
										$nume = mysqli_affected_rows($mysqli);

										$query1 = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$glbMth' AND program = '$glbAdpProg' AND c803_tcr_reading != '' AND year = '$glbYr'";
										$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
										$deno = mysqli_affected_rows($mysqli);

										$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$glbMth' AND program = '$glbAdpProg' AND year = '$glbYr'";
										$result_weit = mysqli_query($mysqli, $query_weit) or die(mysqli_query($mysqli));
										$row_weit = mysqli_fetch_assoc($result_weit);
										$nume_weit = $row_weit["sum_total"];
										$nume_weit_sum += $nume_weit;
										if ($deno == null) {
											echo "";
										} else {
											$ans = $nume * 100 / $deno;
											$sumprod_a_n += $ans * $nume_weit;
										}
								
										if ($nume_weit_sum == null) {
											echo "0%";
										} else {
											echo round(($sumprod_a_n / $nume_weit_sum), 0) . "%";
										}
									?>
								</td>
								<td>Average diarrhea rate in the past 2 weeks</td>
								<td>
									<?php
										$sumprod_a_n = 0;
										$nume_weit_sum = 0;
										$res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates` WHERE country='$country_val' AND year = '$glbYr' ORDER BY program");

										$field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
										'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
										$sum = 0;
										foreach ($field_ar as $field) {
											$query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$glbMth' AND program = '" . $glbAdpProg . "' AND $field = '1' AND year = '$glbYr'";
											$result = mysqli_query($mysqli, $query) or die(mysql_error());
											$sum_row = mysqli_affected_rows($mysqli);

											$sum += $sum_row;
										}
										$query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE month = '$glbMth' AND program = '" . $glbAdpProg . "' AND year = '$glbYr'";
										$result_deno = mysqli_query($mysqli, $query_deno) or die(mysql_error());
										$row_deno = mysqli_fetch_assoc($result_deno);
										$deno = $row_deno['denominator'];

										$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$glbMth' AND program = '" . $glbAdpProg . "' AND year = '$glbYr'";
										$result_weit = mysqli_query($mysqli, $query_weit) or die(mysql_error());
										$row_weit = mysqli_fetch_assoc($result_weit);
										$nume_weit = $row_weit["sum_total"];
										$nume_weit_sum += $nume_weit;

										if ($deno == null) {
											echo "";
										} else {
											$ans = $sum * 100 / $deno;
											$sumprod_a_n += $ans * $nume_weit;
										}
										
										if ($nume_weit_sum == null) {
											echo "0%";
										} else {
											echo round(($sumprod_a_n / $nume_weit_sum), 0) . "%";
										}
									?>
								</td>
							</tr>
							<tr>
								<td>Percentage Free Chlorine Residue (FCR)</td>
								<td>
									<?php
										$sumprod_a_n = 0;
										$nume_weit_sum = 0;
                            
										$query = "SELECT c806_fcr_reading FROM dsw_per_adoption_rates WHERE month = '$glbMth' AND program = '$glbAdpProg' AND c806_fcr_reading != '0' AND c806_fcr_reading != '' AND year = '$glbYr'";
										$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
										$nume = mysqli_affected_rows($mysqli);

										$query1 = "SELECT c806_fcr_reading FROM dsw_per_adoption_rates WHERE month = '$glbMth' AND program = '$glbAdpProg' AND c803_tcr_reading != '' AND year = '$glbYr'";
										$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
										$deno = mysqli_affected_rows($mysqli);

										$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$glbMth' AND program = '$glbAdpProg' AND year = '$glbYr'";
										$result_weit = mysqli_query($mysqli, $query_weit) or die(mysqli_query($mysqli));
										$row_weit = mysqli_fetch_assoc($result_weit);
										$nume_weit = $row_weit["sum_total"];
										$nume_weit_sum += $nume_weit;

										if ($deno == null) {
											echo "";
										} else {
											$ans = $nume * 100 / $deno;
											$sumprod_a_n += $ans * $nume_weit;
										}
                            
										if ($nume_weit_sum == null) {
											echo "0%";
										} else {
											echo round(($sumprod_a_n / $nume_weit_sum), 0) . "%";
										}
									?>
								</td>
								<td>Average diarrhea rate in past 2 days</td>
								<td>
									<?php
										$field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
										'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
										$sum = 0;
										foreach ($field_ar as $field) {
											$query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$glbMth' AND program = '$glbAdpProg' AND $field = '1' AND year = '$glbYr'";
											$result = mysqli_query($mysqli, $query) or die(mysql_error());
											$sum_row = mysqli_affected_rows($mysqli);

											$sum += $sum_row;
										}

										$query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE month = '$glbMth' AND program = '$glbAdpProg' AND year = '$glbYr'";
										$result_deno = mysqli_query($mysqli, $query_deno) or die(mysql_error());
										$row_deno = mysqli_fetch_assoc($result_deno);
										$deno = $row_deno['denominator'];

										if ($deno == null) {
											echo "0%";
										} else {
											$ans = round(($sum / $deno), 2);
											$percent = $ans * 100;
											echo $percent . "%";
										}
									?>
								</td>
							</tr>
							<tr>
								<td>Average CEM attendance</td>
								<td>
									<?php
										$field = 'cem301_attendees_total';
										$query = "SELECT cem301_attendees_total FROM dsw_per_cem_attendees WHERE program = '$glbAdpProg'";
										$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
										$deno = mysqli_affected_rows($mysqli);
										$query1 = "SELECT SUM(cem301_attendees_total) AS denominator FROM dsw_per_cem_attendees WHERE program = '$glbAdpProg'";
										$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
										$row2 = mysqli_fetch_assoc($result1);
										$nume = $row2['denominator'];
										if ($deno == 0) {
											echo "0";
										} else {
											$ans = round(($nume / $deno), 0);
											echo $ans;
										}
									?>
								</td>
								<td>Average VCS attendance</td>
								<td>
									<?php
										$query = "SELECT vcs201_attendees_total FROM dsw_per_vcs_attendees WHERE program = '$glbAdpProg'";
										$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
										$deno = mysqli_affected_rows($mysqli);
										$query1 = "SELECT SUM(vcs201_attendees_total) AS denominator FROM dsw_per_vcs_attendees WHERE program = '$glbAdpProg'";
										$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
										$row2 = mysqli_fetch_assoc($result1);
										$nume = $row2['denominator'];
										if ($deno == 0) {
											echo "";
										} else {
											$ans = round(($nume / $deno), 0);
											echo $ans;
										}
									?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		<div class="clearFix"></div>
	</body>
</html>
<script>
	//A function to add commas on numerical values purely for display to the user similar to php's "number_format()" method.
	function commaSeparateNumber(val) {
		while (/(\d+)(\d{3})/.test(val.toString())) {
			val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
		}
		return val;
	}
	
	//Vertical bar-graphs
	function vertBars() {
		$.post("+reportData.php", {
			getData: 'program',
			info_type: 'adop_rate',
			prog: <?php echo "'" . $glbAdpProg . "'"; ?>, //Note that text strings must be enclosed between single quotes for them to be resolved as such when passed.
			year: <?php echo $glbYr; ?>,
			month: <?php echo $glbMth; ?>
		}).done(function(data) {
			var spltAdopRteData = data.split(",");
			var mth1 = +spltAdopRteData[0];
			var mth2 = +spltAdopRteData[1];
			var mth3 = +spltAdopRteData[2];
		
			//m1
			$('#mtrM1').animate({height: mth1 + '%'}, 500, 'swing');
			$('#mtrM1').html(commaSeparateNumber(mth1 + '%'));
			//m2
			$('#mtrM2').animate({height: mth2 + '%'}, 500, 'swing');
			$('#mtrM2').html(commaSeparateNumber(mth2 + '%'));
			//m3
			$('#mtrM3').animate({height: mth3 + '%'}, 500, 'swing');
			$('#mtrM3').html(commaSeparateNumber(mth3 + '%'));
		});
	}

	//Pie-charts
	function pieProm() {
		$.post("+reportData.php", {
			getData: 'program',
			info_type: 'promoters',
			country: <?php echo $country_val; ?>,
			prog: <?php echo "'" . $glbAdpProg . "'"; ?> //Note that text strings must be enclosed between single quotes for them to be resolved as such when passed.
		}).done(function(data) {
			var spltPromData = data.split(",");
		
			var lblSeries1 = 'Female';
			var lblSeries2 = 'Male';
			var lblSeries3 = 'Unspeci.';
			var divContainer = '#divPiePromoters';
			var txtTitle = '';
		
			var chartWidth = 300;
			var chartHeight = 300;
			var intTotal = +spltPromData[0];
			var intSeries1 = +spltPromData[1];
			var intSeries2 = +spltPromData[2];
			var intSeries3 = +spltPromData[3];
					
			var pcntSeries1 = (intSeries1 / intTotal * 100.0).toFixed(0);
			var pcntSeries2 = (intSeries2 / intTotal * 100.0).toFixed(0);
			var pcntSeries3 = (intSeries3 / intTotal * 100.0).toFixed(0);
		
			if (intTotal == 0) {
				$(divContainer).html('<h3 id="divDataError">No data returned!</h3>');
				return;
			}
				
			$(divContainer).highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					width: chartWidth,
					height: chartHeight
				},
				title: {
					text: txtTitle
				},
				credits: {
					enabled: false
				},
				colors: ["#EF637D", "#A8A8A8", "yellow"],
				tooltip: {
					formatter: function() {
						var value = (this.percentage / 100 * intTotal).toFixed(0);
						return '<b style="font-family: "TSTAR Mono Round"; font-size: 1.2em; font-weight: bold;">' + this.point.name + '</b><br /><br />Number: <b>' + value + '</b><br />Total: <b>' + intTotal + '</b>';
					},
					backgroundColor: '#FFF',
					borderColor: '#000',
					hideDelay: 0
				},
				exporting: {
					enabled: false
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						slicedOffset: 20,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							distance: -65,
							format: '{point.name}<br/>{point.y:.0f}%',
							borderRadius: 5,
							padding: 5,
							defer: true,
							/*backgroundColor: 'rgba(252, 255, 197, 0.7)',
							borderWidth: 1,
							borderColor: '#AAA',*/
							style: {
								fontWeight: 'bold',
								color: 'black',
								fontFamily: 'TSTAR Mono Round',
								fontSize: '15.4px',
								//textShadow: '0px 1px 2px black'
							}
						},
						showInLegend: false
					}
				},
				series: [{
					type: 'pie',
					name: txtTitle,
					data: [
						[lblSeries1, +pcntSeries1],
						[lblSeries2, +pcntSeries2],
						[lblSeries3, +pcntSeries3]
					]
				}]
			});
		});
    }
	function pieChloUse() {
		$.post("+reportData.php", {
			getData: 'program',
			info_type: 'chlo_use',
			country: <?php echo $country_val; ?>,
			prog: <?php echo "'" . $glbAdpProg . "'"; ?> //Note that text strings must be enclosed between single quotes for them to be resolved as such when passed.
		}).done(function(data) {
			var spltChloUseData = data.split(",");
		
			var lblSeries1 = <?php echo "'" . $glbAdpProg . "'"; ?>;
			var lblSeries2 = 'DSW';
			var divContainer = '#divPieChloUse';
			var txtTitle = '';
		
			var chartWidth = 300;
			var chartHeight = 300;
			var intTotal = +spltChloUseData[0];
			var intSeries1 = +spltChloUseData[1];
			var intSeries2 = intTotal - intSeries1;
											
			var pcntSeries1 = (intSeries1 / intTotal * 100.0).toFixed(0);
			var pcntSeries2 = (intSeries2 / intTotal * 100.0).toFixed(0);

			if (intTotal == 0) {
				$(divContainer).html('<h3 id="divDataError">No data returned!</h3>');
				return;
			}
				
			$(divContainer).highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					width: chartWidth,
					height: chartHeight
				},
				title: {
					text: txtTitle
				},
				credits: {
					enabled: false
				},
				colors: ["#EF637D", "#A8A8A8"],
				tooltip: {
					formatter: function() {
						var value = (this.percentage / 100 * intTotal).toFixed(0);
						return '<b style="font-family: "TSTAR Mono Round"; font-size: 1.2em; font-weight: bold;">' + this.point.name + '</b><br /><br />Number: <b>' + value + '</b><br />Total: <b>' + intTotal + '</b>';
					},
					backgroundColor: '#FFF',
					borderColor: '#000',
					hideDelay: 0
				},
				exporting: {
					enabled: false
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						slicedOffset: 20,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							distance: -65,
							format: '{point.name}<br/>{point.y:.0f}%',
							borderRadius: 5,
							padding: 5,
							defer: true,
							/*backgroundColor: 'rgba(252, 255, 197, 0.7)',
							borderWidth: 1,
							borderColor: '#AAA',*/
							style: {
								fontWeight: 'bold',
								color: 'black',
								fontFamily: 'TSTAR Mono Round',
								fontSize: '15.4px',
								//textShadow: '0px 1px 2px black'
							}
						},
						showInLegend: false
					}
				},
				series: [{
					type: 'pie',
					name: txtTitle,
					data: [
						[lblSeries1, +pcntSeries1],
						[lblSeries2, +pcntSeries2]
					]
				}]
			});
		});
    }
	function pieRecIssue() {
		$.post("+reportData.php", {
			getData: 'program',
			info_type: 'rec_issue',
			country: <?php echo $country_val; ?>,
			prog: <?php echo "'" . $glbAdpProg . "'"; ?> //Note that text strings must be enclosed between single quotes for them to be resolved as such when passed.
		}).done(function(data) {
			var spltPieRecIssue = data.split(",");
		
			var lblSeries1 = <?php echo "'" . $glbAdpProg . "'"; ?>;
			var lblSeries2 = 'DSW';
			var divContainer = '#divPieRecIssue';
			var txtTitle = '';
		
			var chartWidth = 300;
			var chartHeight = 300;
			var intTotal = +spltPieRecIssue[0];
			var intSeries1 = +spltPieRecIssue[1];
			var intSeries2 = intTotal - intSeries1;
											
			var pcntSeries1 = (intSeries1 / intTotal * 100.0).toFixed(0);
			var pcntSeries2 = (intSeries2 / intTotal * 100.0).toFixed(0);

			if (intTotal == 0) {
				$(divContainer).html('<h3 id="divDataError">No data returned!</h3>');
				return;
			}
				
			$(divContainer).highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					width: chartWidth,
					height: chartHeight
				},
				title: {
					text: txtTitle
				},
				credits: {
					enabled: false
				},
				colors: ["#EF637D", "#A8A8A8"],
				tooltip: {
					formatter: function() {
						var value = (this.percentage / 100 * intTotal).toFixed(0);
						return '<b style="font-family: "TSTAR Mono Round"; font-size: 1.2em; font-weight: bold;">' + this.point.name + '</b><br /><br />Number: <b>' + value + '</b><br />Total: <b>' + intTotal + '</b>';
					},
					backgroundColor: '#FFF',
					borderColor: '#000',
					hideDelay: 0
				},
				exporting: {
					enabled: false
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						slicedOffset: 20,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							distance: -65,
							format: '{point.name}<br/>{point.y:.0f}%',
							borderRadius: 5,
							padding: 5,
							defer: true,
							/*backgroundColor: 'rgba(252, 255, 197, 0.7)',
							borderWidth: 1,
							borderColor: '#AAA',*/
							style: {
								fontWeight: 'bold',
								color: 'black',
								fontFamily: 'TSTAR Mono Round',
								fontSize: '15.4px',
								//textShadow: '0px 1px 2px black'
							}
						},
						showInLegend: false
					}
				},
				series: [{
					type: 'pie',
					name: txtTitle,
					data: [
						[lblSeries1, +pcntSeries1],
						[lblSeries2, +pcntSeries2]
					]
				}]
			});
		});
    }
	
	//line-graph
	function lineAdopTrnd(){
		//Since the line graph will take some time to load and map the data, inform the user with this message.
		$(divLineGraph).html('<h id="divDataError">Loading data. Please wait.</h>');
		
		$.post("+reportData.php", {
			getData: 'program',
			info_type: 'adp_trnd',
			year: <?php echo $glbYr; ?>,
			country: <?php echo $country_val; ?>,
			prog: <?php echo "'" . $glbAdpProg . "'"; ?> //Note that text strings must be enclosed between single quotes for them to be resolved as such when passed.
		}).done(function(data) {
			var spltAdpTrndData = data.split(",");
			
			var s1 = [['2014-01-30', spltAdpTrndData[0]], ['2014-02-28', spltAdpTrndData[1]], ['2014-03-30', spltAdpTrndData[2]], ['2014-04-30', spltAdpTrndData[3]], ['2014-05-30', spltAdpTrndData[4]], 
			['2014-06-30', spltAdpTrndData[5]], ['2014-07-30', spltAdpTrndData[6]], ['2014-08-30', spltAdpTrndData[7]], ['2014-09-30', spltAdpTrndData[8]], ['2014-10-30', spltAdpTrndData[9]], ['2014-11-30', spltAdpTrndData[10]], ['2014-12-30', spltAdpTrndData[11]]];
			var s2 = [['2014-01-30', spltAdpTrndData[12]], ['2014-02-28', spltAdpTrndData[13]], ['2014-03-30', spltAdpTrndData[14]], ['2014-04-30', spltAdpTrndData[15]], ['2014-05-30', spltAdpTrndData[16]], 
			['2014-06-30', spltAdpTrndData[17]], ['2014-07-30', spltAdpTrndData[18]], ['2014-08-30', spltAdpTrndData[19]], ['2014-09-30', spltAdpTrndData[20]], ['2014-10-30', spltAdpTrndData[21]], ['2014-11-30', spltAdpTrndData[22]], ['2014-12-30', spltAdpTrndData[23]]];
			
			//Now that the data is available and is ready for mapping on the graph, clear the loading message. Failure to do so affects the middle right horizontal bar graph above's (Installations) text by adding another break to the line of text.
			$(divLineGraph).html('');
			
			plot1 = $.jqplot("divLineGraph", [s1, s2], {
				title: {
					text: '',
					show: true,
					textAlign: 'left',
					fontFamily: 'Courier'
				},
				// Turns on animation for all series in this plot.
				animate: true,
				// Will animate plot on calls to plot1.replot({resetAxes:true})
				animateReplot: true,
				cursor: {
					show: true,
					zoom: true,
					looseZoom: true,
					showTooltip: false
				},
				series: [
					{
						color: '#A8A8A8',
						label: spltAdpTrndData[24],
						pointLabels: {
							/*setting this to TRUE will display the point values of the line graphs*/
							show: false
						},
					//    renderer: $.jqplot.BarRenderer,
						rendererOptions: {
							// Speed up the animation a little bit.
							// This is a number of milliseconds.  
							// Default for bar series is 3000.  
							animation: {
								speed: 2500
							},
						}
					}, 
					{
						color: '#EF637D',
						label: <?php echo $glbYr; ?>,
						rendererOptions: {
							// speed up the animation a little bit.
							// This is a number of milliseconds.
							// Default for a line series is 3000.
							animation: {
								speed: 2000
							}
						}
					}
				],
				legend: {
					show: true,
					placement: 'outsideGrid',
					location: 's',
					showLabels: true
					},
				axesDefaults: {
					pad: 0
				},
				axes: {
					// These options will set up the x axis like a category axis.
					xaxis: {
						renderer: $.jqplot.DateAxisRenderer,
						tickOptions: {formatString: '%b'},
						min: 'January 30, 2014',
						tickInterval: '1 month',
						drawMajorGridlines: false,
						drawMinorGridlines: false,
						drawMajorTickMarks: false,
					},
					yaxis: {
						tickInterval: 20,
						min: 0,
						max: 100,
						tickOptions: {
							formatString: "%'d%"
						},
						rendererOptions: {
							forceTickAt0: true
						}
					},
				},
				highlighter: {
					show: true, 
					showLabel: true, 
					tooltipAxes: 'y',
					sizeAdjust: 7.5 , tooltipLocation : 'ne'
				}
			});
		});
	}
	
	$(document).ready(function() {
	//A page can't be manipulated safely until the document is "ready."
	//jQuery detects this state of readiness for you.
	//Code included inside $( document ).ready() will only run once the page Document Object Model (DOM) is ready for JavaScript code to execute.
	//-jquery.com
		vertBars();
		pieProm();
		pieChloUse();
		pieRecIssue();
		lineAdopTrnd();
	})
</script>
<?php ob_flush(); ?>