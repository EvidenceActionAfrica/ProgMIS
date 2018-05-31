<?php

require_once ('includes/include.php');
$evidenceaction = new EvidenceAction();

require_once ('includes/config.php');
require_once ('includes/auth.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
$level = $_SESSION['level'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
	<head>
		<title>Evidence Action</title>
		<?php
		require_once ("includes/meta-link-script.php");
		?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="css/style-n.css" type="text/css" />
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
	</head>
	<body>
		<!---------------- header start ------------------------>
		<div class="header">
			<div style="float: left">
				<img src="images/logo.png" />
			</div>
			<div class="menuLinks">
				<?php
				require_once ("includes/menuNav.php");
				require_once ("includes/loginInfo.php");
				?>
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
				<div class="wrapperNwp">
					<?php ?>
					<div class="rstBdy">
						<div class="inside">
							<div class="selSec">
								<label>Choose a District</label>
								<?php
									$tablename = 'districts';
									$fields = 'id, district_name, district_id';
									$where = '1=1 AND id!=1 ORDER BY district_name ASC';
									$insertformdata = $evidenceaction -> mysql_fetch_all($tablename, $fields, $where);
								?>
								<select id="selectdistrict" name="selectdistrict">
								<?php
									foreach ($insertformdata as $insertformdatacab) {
										echo "<option value=\"$insertformdatacab[district_id]\">$insertformdatacab[district_name]</option>";
									}
								?>
								</select>
							</div>
						<input name="generate_repor" type="button" value="Generate Report" class="genBtn" onclick="selectcounty();" />
						<div id="report_container">
							<div class="section_header">
								Programme Coverage Summary for Albendazole Treatment
							</div>	
							<div class="section_row_container">
								<div class="column">
									<div id="dewormed_percentage_container">
										<div id="dewormed_percentage_value"></div>
									</div>
								</div>
								<div class="column">
									<div class="info_container">
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
								<div class="info_container">
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
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<div class="section_header">
							Albendazole Treatment Analysis
						</div>
						<div id="containerenrolled" class="chartdraw"></div>
						<div id="containerage"  class="chartdraw"></div>
						<div id="containersex" class="chartdraw"></div>
						
						<div id="reportschart"></div>
						<div id="reportschartage"></div>
						<div id="reportschartsex"></div>
						<div class="section_header">
							District Deworming Facts at a Glance
						</div>
						<div id="reportschartstats" class="chartdraw"></div>
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						</div>
					</div>	
				</div>
			</div>
		</div><!--end of content Main -->
	</div>
	<div class="clearFix"></div>
	<!---------------- Footer ------------------------>
	<!--<div class="footer">  </div>-->
	</body>
</html>
<script>
	//GET district
	function selectcounty() {
		$('#reportschart').html('');
		$('#reportschartage').html('');
		$('.column').css('visibility', 'hidden');
		$('#dewormed_percentage_container').css('visibility', 'hidden');
		$('#treated_percentage_container').css('visibility', 'hidden');
		$('#dewormed_percentage_value').css('visibility', 'hidden');
		$('#treated_percentage_value').css('visibility', 'hidden');

		
		$('#report_container').css('visibility', 'visible');
		//var urlmn = '?checkval=form_s_pdf';
		//alert($("#selectdistrict").val());
		if ($("#selectdistrict").val() != '') {
			var selectdistrict = $("#selectdistrict").val();
			//urlmn += '&selectdistrict=selectdistrict';
		} else {
			return;
		}
		
		$.post('reports/table_ajax.php', {
			progress_data : 'dewormed',
			district: selectdistrict
		}).done(function(data) {
			setDewormed(data);
		});
		
		$.post('reports/table_ajax.php', {
			progress_data : 'treated',
			district: selectdistrict
		}).done(function(data) {
			setTreated(data);
			$('.column').css('visibility', 'visible');
		});
		
		$.post('reports/report_ajax.php', {
			checkval : 'standardized_report_enrolled',
			selectdistrict : selectdistrict
		}).done(function(data) {
			$('#reportschart').html(data);
			// alert(data);
			// $('#downid').attr('href','generate_report_pdf.php'+urlmn);
		});
		
		$.post('reports/report_ajax.php', {
			checkval : 'standardized_report_age',
			selectdistrict : selectdistrict
		}).done(function(data) {
			$('#reportschartage').html(data);
			// alert(data);
			//$('#downid').attr('href','generate_report_pdf.php'+urlmn);
		});
		
		$.post('reports/report_ajax.php', {
			checkval : 'standardized_report_sex',
			selectdistrict : selectdistrict
		}).done(function(data) {
			$('#reportschartsex').html(data);
			// alert(data);
			// $('#downid').attr('href','generate_report_pdf.php'+urlmn);
		});
		
		var selectdistrict = 'no district';
		if ($("#selectdistrict").val() != '') {
			selectdistrict = $("#selectdistrict").val();
		}
		
		$.post('reports/table_ajax.php', {
			tag_get_data: 'get_data',
			district : selectdistrict
		}).done(function(data) {
			// alert(data);
			$('#reportschartstats').html(data);
		});
	}
	
	function setDewormed(value) {
		var contents = value.split(",");
		var percentage = (parseInt(contents[0]) / parseInt(contents[1]) * 100).toFixed(0);
		var newWidth = parseInt($('#dewormed_percentage_container').width() * percentage / 100.0);
		$('#dewormed_percentage_value').animate({
			width : newWidth + 'px'
		}, 500);
		var dewormed = parseInt(contents[0]);
		$('#dewormed_info_title').html(dewormed + ' children were dewormed');
		$('#dewormed_percentage_value').html(percentage + '%');
		$('#dewormed_info_title_sub').html('out of ' + contents[1] + ' targeted');
		
		$('#dewormed_info_subtitle').html( parseInt(contents[2]).toFixed(0) + '% of enrolled primary children were treated');
		
		$('#dewormed_percentage_value').css('visibility', 'visible');
		$('#dewormed_percentage_container').css('visibility', 'visible');
	}
	
	function setTreated(value) {
		var contents = value.split(",");
		
		var participated = parseInt(contents[0]);
		var targeted = parseInt(contents[1]);
		
		var percentage = participated / targeted * 100;
		
		var newWidth = parseInt($('#treated_percentage_container').width() * percentage / 100.0);
		$('#treated_percentage_value').animate({
			width : newWidth + 'px'
		}, 500);
		
		$('#treated_percentage_value').html(percentage.toFixed(0) + '%');
		
		$('#treated_info_title').html(participated + ' primary schools were treated');
		$('#treated_info_title_sub').html('out of ' + targeted + ' targeted.');
		
		$('#treated_percentage_value').css('visibility', 'visible');
		$('#treated_percentage_container').css('visibility', 'visible');
	}
</script>
<script src="js/highcharts.js"></script>
<!-- <script src="js/modules/exporting.js"></script> -->
<script src="js/modules/data.js"></script>
<script src="js/modules/drilldown.js"></script>

