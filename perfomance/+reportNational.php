<?php
	ob_start();
	include('header-.php');
	//1. Data Preload: Access the "dsw_per_adoption_rates" table and get all the available years so as to populate the drop-down menu "selAdpYr" of "frmYrMth" when page loads.
	//Note: This statemement only returns the available years from the database and is used to populate the dropdown list with these years. It does NOT set a specific year. Since the ORDER is set to DESC, then the largest AVAILABLE year value will be the default on the list.
	$sqlAdpYr = "SELECT DISTINCT year FROM dsw_per_adoption_rates WHERE country = '$country_val' ORDER BY year DESC";
	$qryAdpYr = mysqli_query($mysqli, $sqlAdpYr);
	//Note: SQL queries like these and their results cannot be shared by multiple variables/statements. Hence, it is common to see redundant statements like these repeated throughout this script.
	
	//2. Global Variables: "glbYr" and "glbMth" are global variables within the scope of this file and all other included files such as: "+mainPageHeading.php".
	//They have to be set in order for the current year and month values be made accessible throught this script. This is done by handling the On-Click event for the command button "inAdpYrMth".
	if(isset($_GET["inAdpYrMth"])) {
		//Global Variables "glbYr" and "glbMth" are assigned values here.
		//The user has chosen a Year and a Month and hit the "Select" button ("inAdpYrMth"). Therefore, the year and month have now been EXPLICITLY set by the user.
		$glbYr = $_GET["selAdpYr"];
		$glbMth = $_GET["selAdpMth"];
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
	}
?>
<html>
	<head>
		<?php require_once("includes/+report.php"); ?>
	</head>
	<style>
	
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
							<input class="btnGen btnAdpYrMth" id="inAdpYrMth" name="inAdpYrMth" type="submit" value="Select">
						</form>
					</div>
					<div id="divGenPDF">
						<input class="btnGen btnGenPDF" id="inGenPDF" name="inGenPDF" type="submit" style="margin-left: 110px;" value="PDF" hidden>
					</div>
					<div class="clrBth"></div>
					<div id="divPrntPage">
						<?php include("+mainPageHeading.php"); ?>
						<p class="sectionHeader">OPERATIONAL DATA</p>
						<div id="divHundred">100%</div>
						<div id="divLine"></div>
						<div class="divHrzRow">
							<div class="divHrzLeft">
								Adoption Rate
								<div id="divAdptMeter">
									<div id="divAdptBar"></div>
								</div>
							</div>
							<div class="divHrzRight">
								<div id="divAdptInfo"></div>
							</div>
						</div>
						<div class="divHrzRow" style="margin-top: 10px;">
							<div class="divHrzLeft">
								Installations
								<div id="divInstMeter">
									<div id="divInstBar"></div>
								</div>
							</div>
							<div class="divHrzRight">
								<div id="divInstInfo"></div>
							</div>
						</div>
						<div class="divHrzRow" style="margin-top: 10px;">
							<div class="divHrzLeft">
								People Served
								<div id="divPpleMeter">
									<div id="divPpleBar"></div>
								</div>
							</div>
							<div class="divHrzRight">
								<div id="divPpleInfo"></div>
							</div>
						</div>
						<br>
						<div id="divPromoters">
							Promoters
							<div id="divPiePromoters"></div>
						</div>
						<div class="divAdoptionTrend">
							Adoption Trend
							<div id="divLineGraph" style="width:638px; height:317px"></div>
						</div>
						<br>
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
										$sqlTblChloInst = "SELECT * FROM dispenser_database WHERE country='$country_val' and installation_date like '$glbYr/%'";
										$qryTblChloInst = mysqli_query($mysqli, $sqlTblChloInst) or die(mysqli_query($mysqli));
										$tblChloInst = mysqli_num_rows($qryTblChloInst);
										echo number_format($tblChloInst);
									?>
								</td>
								<td>Total number of Chlorine deliveries made</td>
								<td>
									<?php
										$sqlTblChloDeliv = "SELECT SUM(`num_of_Deliveries`) AS TTLDELIV FROM `dsw_per_chlorine` WHERE country = '$country_val'";
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
										$qryPplSvd = "SELECT SUM(pple_served) AS PPLE FROM dispenser_database WHERE country='$country_val'";
										$rsltPplSvd = mysqli_query($mysqli, $qryPplSvd) or die(mysqli_query($mysqli));
										$assocPplSvd = mysqli_fetch_assoc($rsltPplSvd);
										$pplSvd = $assocPplSvd['PPLE'];
										
										echo number_format($assocPplSvd['PPLE']);
									?>
								</td>
								<td>Total liters of Chlorine used</td>
								<td>
									<?php
										$sqlTblChloUsed = "SELECT SUM(Jerrican_delivered) AS _sum_num FROM dsw_per_chlorine WHERE country='$country_val'";
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
									$query_hardwareProb = "SELECT program FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$glbMth' AND s208_dispprob = '1' AND year = '$glbYr'";
									$result_hardwareProb = mysqli_query($mysqli, $query_hardwareProb) or die(mysqli_query($mysqli));
									$hardwareProb = mysqli_affected_rows($mysqli);
									$funcChloDisp = $tblChloInst - $hardwareProb;
									echo round(($funcChloDisp / $tblChloInst) * 100) . "%";
								?>
								</td>
								<td>Average 30 day Chlorine usage</td>
								<td>
									<?php
										$sqlTblAvgUse = "SELECT AVG(`avrg_30day_usage_litres`) AS AVGUSE FROM `dsw_per_chlorine` WHERE country = '$country_val' AND avrg_30day_usage_litres!=''";
										$qryTblAvgUse = mysqli_query($mysqli, $sqlTblAvgUse) or die(mysqli_query($mysqli));
										$assocTblAvgUse = mysqli_fetch_assoc($qryTblAvgUse);
										$tblAvgUse = $assocTblAvgUse['AVGUSE'];
										echo round($tblAvgUse);
									?>
								l
								</td>
							</tr>
							<tr>
								<td>Percentage of dispensers that have chlorine in them at unannounced visits</td>
								<td>
									<?php
										$query = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$glbMth' AND s206_cl_dispensed = '1' AND year = '$glbYr'";
										$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
										$nume = mysqli_affected_rows($mysqli);

										$query1 = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE country='$country_val' AND month = '$glbMth' AND s206_cl_dispensed != '' AND year = '$glbYr'";
										$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
										$deno = mysqli_affected_rows($mysqli);
										if ($deno == null) {
											echo "0%";
										} else {
											$ans = round(($nume / $deno), 2);
											$percent = $ans * 100;
											echo $percent . "%";
										}
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
								<td>Number of days between when an issue is reported and when it is resolved</td>
								<td></td>
								<td>Average diarrhea rate in the past 2 weeks</td>
								<td>
									<?php
										$sumprod_a_n = 0;
										$nume_weit_sum = 0;
										$res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates` WHERE country='$country_val' AND year = '$glbYr' ORDER BY program");
										while ($row = mysqli_fetch_assoc($res)) {
											$prog = $row["program"];

											$field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
											'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
											$sum = 0;
											foreach ($field_ar as $field) {
												$query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$glbMth' AND program = '$prog' AND $field = '1' AND year = '$glbYr'";
												$result = mysqli_query($mysqli, $query) or die(mysql_error());
												$sum_row = mysqli_affected_rows($mysqli);

												$sum += $sum_row;
											}
											$query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE month = '$glbMth' AND program = '$prog' AND year = '$glbYr'";
											$result_deno = mysqli_query($mysqli, $query_deno) or die(mysql_error());
											$row_deno = mysqli_fetch_assoc($result_deno);
											$deno = $row_deno['denominator'];

											$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$glbMth' AND program = '$prog' AND year = '$glbYr'";
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
								<td>Drink percentage</td>
								<td>%</td>
								<td>Refill percentage</td>
								<td>%</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		<div class="clearFix"></div>
	</body>
</html>
<script>
	//A function to add commas on numerical values purely for display to the user
	function commaSeparateNumber(val) {
		while (/(\d+)(\d{3})/.test(val.toString())) {
			val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
		}
		return val;
	}
	
	//Horizontal bar-graphs
	function hrzAdpt() {
		$.post("+reportData.php", {
			getData: 'national',
			info_type: 'adop_rate',
			year: <?php echo $glbYr; ?>,
			month: <?php echo $glbMth; ?>,
			country: <?php echo $country_val; ?>
		}).done(function(data) {
			var jsAdptRte = data;
			var jsAdptTgt = <?php 
							if ($country_val == "1") {
								echo "45";
							} elseif ($country_val == "2") {
								echo "45";
							} else {
								echo "45";
							}
							?>;
			var jsAdptInfo = "An adoption rate of " + jsAdptRte + "% was achieved against a targeted adoption of " + jsAdptTgt + "%.";
			$('#divAdptBar').animate({ 
			width: jsAdptRte + '%'
			}, 500);
			$('#divAdptBar').html(jsAdptRte + '%');
			$('#divAdptInfo').html(jsAdptInfo);
		});
	}
	function hrzInst() {
		$.post("+reportData.php", {
			getData: 'national',
			info_type: 'install',
			year: <?php echo $glbYr; ?>,
			country: <?php echo $country_val; ?>
		}).done(function(data) {
			var jsInstTtl = data;
			var jsInstTgt = <?php 
							if ($country_val == "1") {
								echo "6300";
							} elseif ($country_val == "2") {
								echo "5000";
							} else {
								echo "3100";
							}
							?>;
			var jsInstInfo = "A total of " + commaSeparateNumber(jsInstTtl) + " installations have been completed against a country wide target of " + commaSeparateNumber(jsInstTgt) + " installations." ;
			var jsInstPercnt;
			jsInstPercnt = (jsInstTtl * 100) / jsInstTgt;
			jsInstPercnt = +jsInstPercnt.toFixed(2);//This statement rounds off to two decimal places. The "+" is used to drop any extra zeros at the end i.e trailing zeros that are the second decimal number.
			$('#divInstBar').animate({ 
				width: jsInstPercnt + '%'
			}, 500);
			$('#divInstBar').html(jsInstPercnt + '%');
			$('#divInstInfo').html(jsInstInfo);
		});
	}
	function hrzPple() {
		$.post("+reportData.php", {
			getData: 'national',
			info_type: 'pple_srvd',
			country: <?php echo $country_val; ?>
		}).done(function(data) {
			var jsPpleTtl = data;
			var jsPpleTgt = <?php
							if ($country_val == "1") {
								echo "3008200";
							} elseif ($country_val == "2") {
								echo "2624000";
							} else {
								echo "1553200";
							}
							?>;
			var jsPpleInfo = "A total of " + commaSeparateNumber(jsPpleTtl) + " people were served against a target of " + commaSeparateNumber(jsPpleTgt) + " people." ;
			var jsPplePercnt;
			jsPplePercnt = (jsPpleTtl * 100) / jsPpleTgt;
			jsPplePercnt = +jsPplePercnt.toFixed(2);//This statement rounds off to two decimal places. The "+" is used to drop any extra zeros at the end i.e trailing zeros that are the second decimal number.
			$('#divPpleBar').animate({ 
				width: jsPplePercnt + '%'
			}, 500);
			$('#divPpleBar').html(jsPplePercnt + '%');
			$('#divPpleInfo').html(jsPpleInfo);
		});
	}
	
	//Pie-chart
	function pieProm() {
		$.post("+reportData.php", {
			getData: 'national',
			info_type: 'promoters',
			country: <?php echo $country_val; ?>			
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
	
	//line-graph
	function lineAdopTrnd(){
		//Since the line graph will take some time to load and map the data, inform the user with this message.
		$(divLineGraph).html('<h id="divDataError">Loading data. Please wait.</h>');
		
		$.post("+reportData.php", {
			getData: 'national',
			info_type: 'adp_trnd',
			year: <?php echo $glbYr; ?>,
			country: <?php echo $country_val; ?>			
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
		hrzAdpt();
		hrzInst();
		hrzPple();
		pieProm();
		lineAdopTrnd();
	})
</script>
<?php ob_flush(); ?>