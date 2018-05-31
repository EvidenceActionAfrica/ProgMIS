<?php 

require_once ("../../includes/auth.php"); 
require_once ('../../includes/config.php'); 

 // privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_standard_reports= $row['priv_standard_reports'];
}

if($priv_standard_reports>=1){
 ?>

<!DOCTYPE html>

	<head>
		<title>Evidence Action</title>
		<?php require_once ("includes/meta-link-script.php"); ?>
	</head>
	<body>
		<!---------------- header start ------------------------>
		<div class="header">
			<div style="float: left">
				<img src="../../images/logo.png" />
			</div>
			<div class="menuLinks">
				<?php require_once ("includes/menuNav.php");  ?>
			</div>
		</div>
		<div class="clearFix"></div>
		<!---------------- content body ------------------------>
		<div class="contentMain">
			<div class="contentLeft">
				<?php
					require_once ("includes/menuLeftBar-PerformanceData.php");
				?>
			</div>
			<div class="contentBody">
				<!--================================================-->
				<div class="contentMain">
					<div class="contentBody">
						<!--================================================-->
						<div class="wrapperNwp">
							<?php ?>
							<div id="vzoom">
								<!-- <button class="vzoom-level btn-custom-small" onclick="vzoom('0.3','1516px');">40% zoom</button> -->
								<!-- <button class="vzoom-level btn btn-primary" id="set">Hello</button> -->
								<!-- <button class="vzoom-level btn btn-primary" onclick="zoom_county_report('0.4','50%');">40% zoom</button>
								<button class="vzoom-level btn btn-primary" onclick="zoom_county_report('0.6','70%');">50% Zoom</button>
								<button class="vzoom-level btn btn-primary" onclick="zoom_county_report('0.7','80%');">70% Zoom</button> -->
								<script type="text/javascript">

								function zoom_county_report(z,w){
									document.getElementById("report_container").style.zoom=z;
									// document.getElementById("national_report_container").style['MozTransform']="scale("+z+")";
									document.getElementById("report_container").style.width=w;
									document.getElementById("report_container").style.margin="0 auto";
								}

								</script>
							</div>
							<div class="vclear"></div>
							<div class="rstBdy">

								<div class="inside">
									<div class="alert alert-danger" >
										Reload the page <a href="" class="bold-undeline">HERE</a> before generating a new report.
									</div>
									<div class="selSec">
										<label>Choose a County</label>
										<?php
										$result = mysql_query("SELECT * FROM counties") or die(mysql_error());
										?>
										<select id="select_county" name="select_county">
											<option value="">---------------------</option>
											<?php
											while (($row = mysql_fetch_array($result)) != 0) {
												echo "<option value=\"$row[county_id]\">$row[county]</option>";
											}
											?>
										</select>

										<label id="treatment_container">Select treatment</label>
										<select id="treatment_type" name="treatment_type">
											<option value="albe">Albendazole </option>
											<option value="schisto">Praziquantel</option>
										</select>
										<input id="generate_button" name="generate_repor" type="button" value="Generate Report" class="btn btn-primary" onclick="generateReport();" />


									</div>
									<!-- when there is no data gotten show warning message -->
									<div id="warning_no_data">
											<div class="alert info"><span class="icon"></span><span class="hide">x</span><strong>Information</strong> No treatment data available currently. Please check with MLIS team.</div>
										<p></p>
									</div>

									<div id="report_container">
										<?php include("report_county_header.php")
										?>
										<div class="section_header" id="programme_title"></div>
										<div class="section_row_container">
											<div class="column">
												<div id="dewormed_percentage_container">
													<div id="dewormed_percentage_value"></div>
												</div>
											</div>
											<div class="column">
												<div class="info_container" style="height: 70px">
													<ul>
														<li id="dewormed_info_title">
															25,588 children were dewormed
														</li>
														<li id="dewormed_info_title_sub">
															out of 33,340 targeted.
														</li>
														<li id="dewormed_info_subtitle">
															70% of enrolled primary children were treated
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="section_row_container">
											<div class="column">
												<div id="treated_percentage_container">
													<div id="treated_percentage_value"></div>
												</div>
											</div>
											<div class="column">
												<div class="info_container" style="height: 70px">
													<ul>
														<li id="treated_info_title">
															65 primary schools were treated
														</li>
														<li id="treated_info_title_sub">
															out of 65 targeted.
														</li>
													</ul>
												</div>
											</div>
										</div>
										<br />
										<div id="bypassme"></div>
										<div class="section_header" id="analysis_title"></div>
										<br>
										<div id="containerenrolled" class="chartdraw"></div>
										<div id="containerage"  class="chartdraw"></div>
										<div id="containersex" class="chartdraw"></div>
										<div id="pi_container">
											<div id="reportschart_enrolled" class="report_style" ></div>
											<canvas id="reportschart_enrolled_canvas" class="report_canvas_style" width="250" height="500" style="padding-left: 13px; display: none;"></canvas>
											<div id="reportschart_age" class="report_style"></div>
											<canvas id="reportschart_age_canvas" class="report_canvas_style" width="250" height="400" style="padding-left: 13px; display: none;"></canvas>
											<div id="reportschart_sex" class="report_style"></div>
											<canvas id="reportschart_sex_canvas"  class="report_canvas_style" width="250" height="400" style="padding-left: 13px; display: none;"></canvas>
										</div>
										<div class="section_header">
											District Deworming Facts at a Glance
										</div>
										<div id="reportschartstats" class="chartdraw"></div>
										<br />
										<div id="output"></div>
										<button name="export" class="genBtn" value="export" id="export_button" onclick="exportOutput();">
											Preview PDF Report
										</button>
									</div>
								</div>
							</div>
						</div>
					</div><!--end of content Main -->
				</div>
				<!--================================================-->
			</div><!--end of content Main -->
		</div>
		<div class="clearFix"></div>
		<!---------------- Footer ------------------------>
		<!--<div class="footer">  </div>-->
	</body>
</html>

<!-------------------------------------- js codez -------------------------------->
<script>

	function svgToCanvas(container) {
		// get the highcharts svg content
		var svg = $('#' + container + ' .highcharts-container').html();
		// get the canvas
		var canvas = document.getElementById(container + '_canvas').getContext('2d');
		// draw the svg to the screen
		canvas.drawSvg(svg);
		// show the canvas and hide the svg
		$('#' + container + '_canvas').css('display', 'block');
		$('#' + container + '_canvas').css('float', 'left');
		$('#' + container).css('display', 'none');
	}
	
	function exportOutput() {

		// victor
		// return to original zoom
		document.getElementById("report_container").style.zoom="1";
		document.getElementById("report_container").style.width="100%";
		// document.getElementById("report_container").style.width="828px";
		
		// convert each chart to canvas
		$('#export_button').css('display', 'none');

		svgToCanvas('reportschart_enrolled');
		// hide the age when rendering the pdf
		var treatment_type = $('#treatment_type').val();
		if (treatment_type == 'albe') {
			svgToCanvas('reportschart_age');
		};

		svgToCanvas('reportschart_sex');
		
		html2canvas($('#report_container'), {
			onrendered : function(canvas) {
				var canvasImg = canvas.toDataURL("image/jpeg");
				var doc = new jsPDF('portrait', 'mm', 'a4');
				doc.addImage(canvasImg, 'JPEG', 3, 5, 204, 260);
				doc.output('dataurlnewwindow');
			}
		});
	}

	//GET district
	function generateReport() {
		var treatment_type = $('#treatment_type').val();
		var countyname = $('#select_county option:selected').text().trim();
		if (treatment_type == 'albe') {
			/*
			 * Egide
			 */
			// get the date variables
			var year = new Date().getFullYear();
			var output = year - 1 + " - " + year + " ";
			$('#report_subtitle').html(output + countyname + ' County Albendazole Treatment Results');
		} else {
			var year = new Date().getFullYear();
			var output = year - 1 + " - " + year + " ";	
			$('#report_subtitle').html(output + countyname + ' County Schistosomiasis Treatment Results');
		}
		var treatment = $('#treatment_type option:selected').text();
		var county_id = $("#select_county").val();

		//check if what has been gotten is in the database
		// if not display the warning info
		$.post("func.DistrictReport.php", {
			check_county : 'check_county',
			countyname : countyname,
			treatment : treatment_type
		}).done(function(data) {
			console.log(data);
			console.log("Happy Cow");
		
		if (data==0) {
			console.log("hidden");
			//if no data hide the chart div and show the warning div
			$('#report_container').hide();
			$('#warning_no_data').show();

		}else{


		$('#report_container').fadeIn(400);

		if (county_id != '') {
			// hide the warning data if shown
			$('#warning_no_data').hide();

			$('#reportschart_enrolled').html('');
			$('#reportschart_age').html('');
			$('#reportschart_sex').html('');
			$('.column').css('visibility', 'hidden');

			// set the programme and analysis titles text
			$('#programme_title').html('Programme Coverage Summary for ' + treatment + ' Treatment');
			$('#analysis_title').html(treatment + ' Treatment Analysis');

			$('#dewormed_percentage_container').css('visibility', 'hidden');
			$('#treated_percentage_container').css('visibility', 'hidden');
			$('#dewormed_percentage_value').css('visibility', 'hidden');
			$('#treated_percentage_value').css('visibility', 'hidden');

			$('#report_container').css('visibility', 'visible');
			$('#report_container').hide().fadeIn(400);
			
			$.post("county_ajax.php", {
				progress_data : 'dewormed',
				county : countyname,
				treatment : treatment_type
			}).done(function(data) {
				// console.log(data);
				// alert(data);
				setDewormed(data);
			});
			
			$.post("county_ajax.php", {
				progress_data : 'treated',
				county : countyname,
				treatment : treatment_type
			}).done(function(data) {
				// alert(data);
				setTreated(data);
				$('.column').css('visibility', 'visible');
			});

			// request enrolled information
			$.post("county_ajax.php", {
				request_data : 'request',
				data_type : 'enrolled',
				county : countyname,
				treatment : treatment_type
			}).done(function(data) {
				console.log(data);
				// alert(data);
				createChart(data, 'enrolled', '#reportschart_enrolled', treatment_type);
			});

			// only display for alb. No data for PZQ
			if (treatment_type == 'albe') {
				$.post("county_ajax.php", {
					request_data : 'request',
					data_type : 'age',
					county : countyname,
					treatment : treatment_type
				}).done(function(data) {
					// console.log(data);
					createChart(data, 'age', '#reportschart_age', treatment_type);
				});
			}

			$.post("county_ajax.php", {
				request_data : 'request',
				data_type : 'sex',
				county : countyname,
				treatment : treatment_type
			}).done(function(data) {
				createChart(data, 'sex', '#reportschart_sex', treatment_type);
				// alert(data);
			});

			$.post("county_ajax.php", {
				tag_get_data : 'get_data',
				county : countyname,
				treatment : treatment_type
			}).done(function(data) {
				// alert(data);
				$('#reportschartstats').html(data);
				$('#export_button').css('visibility', 'visible');
			});
		}
	} // end if
		}); //end ajacx to check district

	}

	function createChart(data, chart_type, container, treatment_type) {
		// in the format
		// title, label1, label2, data1, data2, total
		var contents = data.split(",");

		var title = contents[0];
		var label1 = contents[1];
		var label2 = contents[2];
		var data1 = parseInt(contents[3]).toFixed(1);
		var data2 = parseInt(contents[4]).toFixed(1);
		var total = parseInt(contents[5]);

		if (contents.length != 6) {
			$(container).html('<h3 id="data_error">No data found</h3>');
			$(container).css('width', '30%');
			return;
		}

		// create the chart
		$(container).hide().fadeIn(1000);

		if (treatment_type == 'schisto') {
			$(container).css('width', '20%');
			$(container).css('padding-left', '8%');
		} else {
			$(container).css('width', '30%');
		}

		$(container).highcharts({
			chart : {
				plotBackgroundColor : null,
				plotBorderWidth : null,
				plotShadow : false,
				// width: 320,
				// height: 400,
				width: 240,
				height: 400,
				spacing: [0, 0, 20, 0]
			},
			legend : {
				y: 0
			},

			title : {
				text : title
			},
			colors : ["#F58427", "#FABF8F"],
			tooltip : {
				formatter : function() {
					var value = (this.percentage / 100 * total).toFixed(0);
					return '<b style="font-size: 1.2em; font-weight: bold;">' + this.point.name + '</b><br /><br />Number: <b>' + value + '</b><br />Total: <b>' + total + '</b>';
					// return this.series.name + '<b>' + (names.toFixed(1)) + '</b> ';
				},
				// pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
				backgroundColor : '#FFF',
				borderColor : '#000',
				hideDelay : 0
			},
			xAxis : {
				categories : [label1, label2]
			},
			plotOptions : {
				pie : {
					allowPointSelect : true,
					cursor : 'pointer',
					dataLabels : {
						enabled : true,
						distance : -60,
						color : 'black',
						format : '{point.y:.0f}%'
					},
					showInLegend : true
				}
			},
			series : [{
				type : 'pie',
				name : chart_type,
				data : [[label1, +data1], [label2, +data2]]
			}]
		});
	}

	function setDewormed(value) {
		var contents = value.split(",");
		// if (contents.length != 2) {
		// 	contents[0] = 0;
		// 	contents[1] = 1;
		// }
		
		var percentage = (parseInt(contents[0]) / parseInt(contents[1]) * 100).toFixed(0);

		var newWidth = parseInt($('#dewormed_percentage_container').width() * percentage / 100.0);
		$('#dewormed_percentage_value').animate({
			width : percentage + '%'
		}, 500);
		var dewormed = parseInt(contents[0]);
		$('#dewormed_info_title').html(dewormed + ' children were dewormed');
		$('#dewormed_percentage_value').html(percentage + '%');
		$('#dewormed_info_title_sub').html('out of ' + contents[1] + ' targeted');
		
		$('#dewormed_info_subtitle').html(parseInt(contents[2]).toFixed(0) + '% of enrolled primary children were treated');

		$('#dewormed_percentage_value').css('visibility', 'visible');
		$('#dewormed_percentage_container').css('visibility', 'visible');
	}

	function setTreated(value) {
		var contents = value.split(",");
		
		if (contents.length != 2) {
			contents[0] = 0;
			contents[1] = 1;
		}

		var participated = parseInt(contents[0]);
		var targeted = contents[1];
		
		if (contents.length == 2) {
			var targeted = parseInt(contents[1]);
		}

		if (targeted == 0) {
			var percentage = 0;
		}else{
			var percentage = participated / targeted * 100;
		}
		

		// var newWidth = parseInt($('#treated_percentage_container').width() * percentage / 100.0);
		$('#treated_percentage_value').animate({
			width : percentage + '%'
		}, 500);

		$('#treated_percentage_value').html(percentage.toFixed(0) + '%');

		$('#treated_info_title').html(participated + ' primary schools were treated');
		$('#treated_info_title_sub').html('out of ' + targeted + ' targeted.');
		$('#treated_percentage_value').css('visibility', 'visible');
		$('#treated_percentage_container').css('visibility', 'visible');
	}
</script>
<?php
}else{
	header("Location:../../home.php");
}
ob_flush();
?>