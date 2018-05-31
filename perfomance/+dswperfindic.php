<?php
	ob_start();
	include ('header.php');
	$sqlAdp = "SELECT DISTINCT year FROM dsw_per_adoption_rates  WHERE country = '$country_val' ORDER BY year DESC";
	$AdpYrRslt = mysqli_query($mysqli, $sqlAdp);
	$sqlADF = "SELECT DISTINCT year FROM dsw_per_adoption_rates  WHERE country = '$country_val' ORDER BY year DESC";
	$ADFRslt = mysqli_query($mysqli, $sqlADF);
	
	//adp
	if (isset($_GET["inAdp"])) {
		$varAdpYr = $_GET["selAdpYr"];
		$AdpPgmSEL = mysqli_query($mysqli, "SELECT DISTINCT program FROM dsw_per_adoption_rates  WHERE country = '$country_val' AND year = '$varAdpYr' ORDER BY program");
		
		//<generally shared variables accross>
		$genYr = $varAdpYr;
		$genMth = $_GET["selAdpMth"];
		//</generally shared variables accross>
		
		//start
		$sumprod_a_n = 0;
		$nume_weit_sum = 0;
		$res = mysqli_query($mysqli, "SELECT DISTINCT program FROM dsw_per_adoption_rates  WHERE country='$country_val' AND year = '$varAdpYr' ORDER BY program");
		while ($row = mysqli_fetch_assoc($res)) {
			$prog = $row["program"];
			
			$query = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = " . $_GET["selAdpMth"] . " AND program = '$prog' AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND year = '$varAdpYr'";
			$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
			$nume = mysqli_affected_rows($mysqli);
			
			$query1 = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = " . $_GET["selAdpMth"] . " AND program = '$prog' AND c803_tcr_reading != '' AND year = '$varAdpYr'";
			$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
			$deno = mysqli_affected_rows($mysqli);
			
			$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = " . $_GET["selAdpMth"] . " AND program = '$prog' AND year = '$varAdpYr'";
			$result_weit = mysqli_query($mysqli, $query_weit) or die(mysqli_query($mysqli));
			$row_weit = mysqli_fetch_assoc($result_weit);
			$nume_weit = $row_weit["sum_total"];
			$nume_weit_sum += $nume_weit;
			if ($deno == null) {
				$adpAvMth = "0";
			} else {
				$ans = $nume * 100 / $deno;
				$sumprod_a_n += $ans * $nume_weit;
			}
		}
		if ($nume_weit_sum == null) {
			$adpAvMth = "0";
		} else {
			$adpAvMth = round(($sumprod_a_n / $nume_weit_sum), 0);
		}
		//stop
	} else {
		$sqlAdpYr = "SELECT DISTINCT year FROM dsw_per_adoption_rates WHERE country = '$country_val' ORDER BY year DESC";
		$qryAdpYr = mysqli_query($mysqli, $sqlAdpYr);
		$assAdpYr = mysqli_fetch_assoc($qryAdpYr);
		$varAdpYr = $assAdpYr['year'];
		$sqlAdpMth = "SELECT DISTINCT month FROM dsw_per_adoption_rates WHERE country = '$country_val' AND year = '$varAdpYr' ORDER BY month DESC"; //this statement will load the latest month and year
		$qryAdpMth = mysqli_query($mysqli, $sqlAdpMth);
		$assAdpMth = mysqli_fetch_assoc($qryAdpMth);
		$varAdpMth = $assAdpMth['month'];
		$AdpPgmSEL = mysqli_query($mysqli, "SELECT DISTINCT program FROM dsw_per_adoption_rates WHERE country = '$country_val' AND year = '$varAdpYr' ORDER BY program");
		
		//<generally shared variables accross>
		$genYr = $assAdpYr['year'];
		$genMth = $assAdpMth['month'];
		//</generally shared variables accross>
				
		//start
		$sumprod_a_n = 0;
		$nume_weit_sum = 0;
		$res = mysqli_query($mysqli, "SELECT DISTINCT program FROM dsw_per_adoption_rates WHERE country = '$country_val' AND year = '$varAdpYr' ORDER BY program");
		while ($row = mysqli_fetch_assoc($res)) {
			$prog = $row["program"];
			
			$query = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$varAdpMth' AND program = '$prog' AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND year = '$varAdpYr'";
			$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
			$nume = mysqli_affected_rows($mysqli);
			
			$query1 = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$varAdpMth' AND program = '$prog' AND c803_tcr_reading != '' AND year = '$varAdpYr'";
			$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
			$deno = mysqli_affected_rows($mysqli);
			
			$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$varAdpMth' AND program = '$prog' AND year = '$varAdpYr'";
			$result_weit = mysqli_query($mysqli, $query_weit) or die(mysqli_query($mysqli));
			$row_weit = mysqli_fetch_assoc($result_weit);
			$nume_weit = $row_weit["sum_total"];
			$nume_weit_sum += $nume_weit;
			if ($deno == null) {
				$adpAvMth = "0";
			} else {
				$ans = $nume * 100 / $deno;
				$sumprod_a_n += $ans * $nume_weit;
			}
		}
		if ($nume_weit_sum == null) {
			$adpAvMth = "0";
		} else {
			$adpAvMth = round(($sumprod_a_n / $nume_weit_sum), 0);
		}
		//stop
	}
	
	//pplsvd
	$query_tot_ken = "SELECT avg_users FROM dsw_per_verification WHERE avg_users !='' AND country = '$country_val'";
	$result_tot_ken = mysqli_query($mysqli, $query_tot_ken) or die(mysqli_query($mysqli));
	$deno_tot_ken = mysqli_affected_rows($mysqli);
	
	$query1_tot_ken = "SELECT SUM(avg_users) AS num FROM dsw_per_verification WHERE country = '$country_val'";
	$result1_tot_ken = mysqli_query($mysqli, $query1_tot_ken) or die(mysqli_query($mysqli));
	$row_num_tot_ken = mysqli_fetch_assoc($result1_tot_ken);
	$nume_tot_ken = $row_num_tot_ken['num'];
	
	$query2_tot_ken = "SELECT c302b_hhold_ppl FROM dsw_per_adoption_rates WHERE c302b_hhold_ppl !='' AND country = '$country_val'";
	$result2_tot_ken = mysqli_query($mysqli, $query2_tot_ken) or die(mysqli_query($mysqli));
	$deno2_tot_ken = mysqli_affected_rows($mysqli);
	$query12_tot_ken = "SELECT SUM(c302b_hhold_ppl) AS num FROM dsw_per_adoption_rates  WHERE country = '$country_val'";
	$result12_tot_ken = mysqli_query($mysqli, $query12_tot_ken) or die(mysqli_query($mysqli));
	$row_num2_tot_ken = mysqli_fetch_assoc($result12_tot_ken);
	$nume2_tot_ken = $row_num2_tot_ken['num'];
	
	if ($deno_tot_ken == 0) {
		$pplsvd = "0";
	} else if ($deno2_tot_ken == 0) {
		$pplsvd = "0";
	} else {
		$pplsvd = round(($nume_tot_ken / $deno_tot_ken) * ($nume2_tot_ken / $deno2_tot_ken)*$deno_tot_ken);
	}
	
	//instll
	$inQry = "SELECT * FROM dispenser_database WHERE country = '$country_val'";
    $inRslt = mysqli_query($mysqli, $inQry) or die(mysqli_query($mysqli));
    $inTtl = mysqli_num_rows($inRslt);
	
	//Official Statistics: ttl deliv
	$query_sum = "SELECT SUM(num_of_Deliveries) AS _sum FROM dsw_per_chlorine WHERE country = '$country_val'";
    $result_sum = mysqli_query($mysqli, $query_sum) or die(mysqli_query($mysqli));
    $row_sum = mysqli_fetch_assoc($result_sum);
    $_sum = $row_sum['_sum'];
	//Official Statistics: avg chlo usage
	$query_aver = "SELECT AVG(avrg_30day_usage_litres) AS _aver FROM dsw_per_chlorine WHERE country = '$country_val' AND avrg_30day_usage_litres!=''";
    $result_aver = mysqli_query($mysqli, $query_aver) or die(mysqli_query($mysqli));
    $row_aver = mysqli_fetch_assoc($result_aver);
    $_aver = $row_aver['_aver'];
?>
<html>
	<head>
		<?php require_once ("includes/+render.php"); ?>
	</head>
	<body>
		<div class="clearFix"></div>
		<div class="prtReport">
			<div class="contentMain">
				<div class="col-md-2">
					<div class="sidebar">
						<?php require_once ('includes/left_bar.php'); ?>
					</div>
				</div>
				<div class="contentBody">
					<b style="color: red;">DISCLAIMER: This is an earlier build of the DSW performance reporting page. The updated page is currently under development and will be uploaded as soon as it's complete. Thank you.</b>
					<p class="hdrHorizBar">
						Program Average Adoption
					</p>
					<form id="frmAdpYr" method="get">
						<select name="selAdpYr" id="selAdpYr" style="width: 140px; height: 34px;">
							<?php while ($AdpYr = mysqli_fetch_assoc($AdpYrRslt)) { ?>
								<option value="<?php echo $AdpYr['year']; ?>"<?php if ($genYr == $AdpYr['year']) echo 'selected'; ?>><?php echo $AdpYr['year']; ?></option>
							<?php } ?>
						</select>
						<select name="selAdpMth" id="selAdpMth" style="width:140px; height: 34px;">
							<option value='1'<?php if ($genMth == 1) echo 'selected'; ?>>January</option>
							<option value='2'<?php if ($genMth == 2) echo 'selected'; ?>>February</option>
							<option value='3'<?php if ($genMth == 3) echo 'selected'; ?>>March</option>
							<option value='4'<?php if ($genMth == 4) echo 'selected'; ?>>April</option>
							<option value='5'<?php if ($genMth == 5) echo 'selected'; ?>>May</option>
							<option value='6'<?php if ($genMth == 6) echo 'selected'; ?>>June</option>
							<option value='7'<?php if ($genMth == 7) echo 'selected'; ?>>July</option>
							<option value='8'<?php if ($genMth == 8) echo 'selected'; ?>>August</option>
							<option value='9'<?php if ($genMth == 9) echo 'selected'; ?>>September</option>
							<option value='10'<?php if ($genMth == 10) echo 'selected'; ?>>October</option>
							<option value='11'<?php if ($genMth == 11) echo 'selected'; ?>>November</option>
							<option value='12'<?php if ($genMth == 12) echo 'selected'; ?>>December</option>
						</select>
						<select name="selAdpPrg" id="selAdpPrg" style="width:140px; height: 34px;" hidden>
							<option value='optPrgDflt'>Select Program</option>
							<?php while ($row = mysqli_fetch_assoc($AdpPgmSEL)) { ?>
								<option value="<?php echo $row["program"]; ?>"><?php echo $row["program"]; ?></option>
							<?php } ?>
						</select>
						<input class="btn btn-primary" type="submit" name="inAdp" id="inAdp" value="Select">
					</form>
					<div id="top_line_container">
						<p class="line_text">
							45%
						</p>
						<div id="top_line_mark" style="display: block"></div>
					</div>
					<div class="grpBarGrph">
						<div class="hrzLeft">
							<div id="barAdpt">
								<div id="mtrAdpt"></div>
							</div>	
						</div>
					</div>
					<b>DSW
						<?php
							if (isset($_GET["inAdp"])) {
								if ($_GET["selAdpMth"] == '1'){
									echo " January ";
								} elseif ($_GET["selAdpMth"] == '2'){
									echo " February ";
								} elseif ($_GET["selAdpMth"] == '3'){
									echo " March ";
								} elseif ($_GET["selAdpMth"] == '4'){
									echo " April ";
								} elseif ($_GET["selAdpMth"] == '5'){
									echo " May ";
								} elseif ($_GET["selAdpMth"] == '6'){
									echo " June ";
								} elseif ($_GET["selAdpMth"] == '7'){
									echo " July ";
								} elseif ($_GET["selAdpMth"] == '8'){
									echo " August ";
								} elseif ($_GET["selAdpMth"] == '9'){
									echo " September ";
								} elseif ($_GET["selAdpMth"] == '10'){
									echo " October ";
								} elseif ($_GET["selAdpMth"] == '11'){
									echo " November ";
								} elseif ($_GET["selAdpMth"] == '12'){
									echo " December ";
								}
							} else {
								if ($varAdpMth == '1'){
									echo " January ";
								} elseif ($varAdpMth == '2'){
									echo " February ";
								} elseif ($varAdpMth == '3'){
									echo " March ";
								} elseif ($varAdpMth == '4'){
									echo " April ";
								} elseif ($varAdpMth == '5'){
									echo " May ";
								} elseif ($varAdpMth == '6'){
									echo " June ";
								} elseif ($varAdpMth == '7'){
									echo " July ";
								} elseif ($varAdpMth == '8'){
									echo " August ";
								} elseif ($varAdpMth == '9'){
									echo " September ";
								} elseif ($varAdpMth == '10'){
									echo " October ";
								} elseif ($varAdpMth == '11'){
									echo " November ";
								} elseif ($varAdpMth == '12'){
									echo " December ";
								}
							}
						?>Report:
						<?php 
							if ($country_val == "1") {
								echo " Kenya ";
							} elseif ($country_val == "2") {
								echo " Uganda ";
							} else {
								echo " Malawi ";
							}
						?>
						<?php
							if (isset($_GET["inAdp"])) {
								echo $_GET["selAdpYr"];
							} else {
								echo $varAdpYr;
							}
						?>
					</b>
					<br>
					<br>
					<p class="hdrHorizBar">
						Installations
					</p>
					<div class="grpBarGrph">
						<div class="hrzLeft">
							<div id="barInstll">
								<div id="mtrInstll"></div>
							</div>
						</div>
						<div class="hrzRight">
							<div class="hldrInstll">
								<b style="font-size: 1.25em; margin-left: -20px "></b>
								<span id="ttlInstll"></span>
								<span id="tgtInstll"></span>
							</div>
						</div>
					</div>
					<br>
					<p class="hdrHorizBar">
						People Served
					</p>	
					<div class="grpBarGrph">
						<div class="hrzLeft">
							<div id="barPplSvd">
								<div id="mtrPplSvd"></div>
							</div>
						</div>
						<div class="hrzRight">
							<div class="hldrPplSvd">
								<b style="font-size: 1.25em; margin-left: -20px "></b>
								<span id="ttlPplSvd"></span>
								<span id="tgtPplSvd"></span>
							</div>
						</div>
					</div>
					<br>
					<p class="hdrHorizBar">
						Adoption and Dispenser Functionality
					</p>
					<!-- Attention!: <form> has beed disabled by the hidden property. An earlier requirement that is now obsolete - but still functional -->
					<form id="frmYear" method="get" type="hidden" hidden>
						<select name="selYear" id="selYear" style="width:140px; height: 34px" >
							<option value='optDflt'>Select Year</option>
							<?php while ($rows = mysqli_fetch_assoc($ADFRslt)) { ?>
								<option value="<?php echo $rows['year']; ?>"><?php echo $rows['year']; ?></option>
							<?php } ?>
						</select>
						<select name="selQtr" id="selQtr" style="width:140px; height: 34px">
							<option value='optDflt'>Select Quarter</option>
							<option value='optFstQtr'>First Quarter</option>
							<option value='optSndQtr'>Second Quarter</option>
							<option value='optThrQtr'>Third Quarter</option>
							<option value='optFthQtr'>Fourth Quarter</option>
						</select>
						<input class="btn btn-primary" type="submit" name="inAdop" id="inAdop" value="Select">
					</form>
					<!-- /Attention!: form has beed disabled by the hidden property. An earlier requirement that is now obsolete - but still functional -->
				<!--<br>-->
					<b>Selected Adoption and Dispenser Functionality for the
						<?php
						/*	if ($_GET["selQtr"] == 'optFstQtr') {
								echo " First Quarter ";
							} elseif ($_GET["selQtr"] == 'optSndQtr') {
								echo " Second Quarter ";
							} elseif ($_GET["selQtr"] == 'optThrQtr') {
								echo " Third Quarter ";
							} else {
								echo " Fourth Quarter ";			
							}
						*/	if ((int)$genMth <= 3) {
								echo " First Quarter ";
							} elseif (((int)$genMth > 3) && ((int)$genMth <= 6)) {
								echo " Second Quarter ";
							} elseif (((int)$genMth > 6) && ((int)$genMth <= 9)) {
								echo " Third Quarter ";
							} else {
								echo " Fourth Quarter ";
							}
						?>
						of the year <?php echo $genYr; ?>
					</b>
					<br>
					<br>
					<table style="background-color: white; width: 50%; border-style: solid; border-width: 1px; width: 90%;">
						<tr width="100%">
							<th style="background-color: #F58427; border-style: solid; border-width: 1px;" width="20%"></th>
							<th style="background-color: #F58427; border-style: solid; border-width: 1px; text-align: center;" width="40%" colspan="4">Adoption</th>
							<th style="background-color: #F58427; border-style: solid; border-width: 1px; text-align: center;" width="40%" colspan="4">Dispenser Functionality</th>
						</tr>
						<tr>
							<th style="background-color: #F58427; border-style: solid; border-width: 1px; text-align: center;">Program</th>
							<?php
							//	if ($_GET["selQtr"] == 'optFstQtr') {
								if ((int)$genMth <= 3) {
							?>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Jan</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Feb</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Mar</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000; border-right: 1px solid #000000;" width="10%">Average</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Jan</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Feb</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Mar</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Average</th>
							<?php 
							//	} elseif ($_GET["selQtr"] == 'optSndQtr') {
								} elseif (((int)$genMth > 3) && ((int)$genMth <= 6)) {
							?>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Apr</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">May</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Jun</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000; border-right: 1px solid #000000;" width="10%">Average</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Apr</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">May</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Jun</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Average</th>
							<?php
							//	} elseif ($_GET["selQtr"] == 'optThrQtr') {
								} elseif (((int)$genMth > 6) && ((int)$genMth <= 9)) {
							?>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Jul</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Aug</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Sep</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000; border-right: 1px solid #000000;" width="10%">Average</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Jul</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Aug</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Sep</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Average</th>
							<?php
								} else {
							?>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Oct</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Nov</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Dec</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000; border-right: 1px solid #000000;" width="10%">Average</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Oct</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Nov</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Dec</th>
							<th style="background-color: #F58427; text-align: center; border-bottom: 1px solid #000000;" width="10%">Average</th>
							<?php
								}
							?>
						</tr>
						<?php
							/*start row population*/
						//	$res = mysqli_query($mysqli, "SELECT distinct program FROM dsw_per_adoption_rates  WHERE country='$country_val' AND year = " . $_GET['selYear'] . " ORDER BY program");
							$adpTblRslt = mysqli_query($mysqli, "SELECT distinct program FROM dsw_per_adoption_rates WHERE country = '$country_val' AND year = '$genYr' ORDER BY program");
							$dspfncTblRslt = mysqli_query($mysqli, "SELECT distinct program FROM dsw_per_dispensed_rates WHERE country = '$country_val' AND year = '$genYr' ORDER BY program");
							while ($row = mysqli_fetch_assoc($adpTblRslt)) {
						?>
						<tr>
							<?php $prgAdpDsp = $row["program"]; ?>
							<th style="border-right: 1px solid #000000; text-align: center;"><?php echo $prgAdpDsp; ?></th>
							<?php
							/*	if($_GET["selQtr"] == 'optFstQtr') {
									$q = 1;
									$l = 3;
								} elseif ($_GET["selQtr"] == 'optSndQtr') {
									$q = 4;
									$l = 6;
								} elseif ($_GET["selQtr"] == 'optThrQtr') {
									$q = 7;
									$l = 9;
								} else {
									$q = 10;
									$l = 12;
								}
							*/	if ((int)$genMth <= 3) {
									$q = 1;
									$l = 3;
								} elseif (((int)$genMth > 3) && ((int)$genMth <= 6)) {
									$q = 4;
									$l = 6;
								} elseif (((int)$genMth > 6) && ((int)$genMth <= 9)) {
									$q = 7;
									$l = 9;
								} else {
									$q = 10;
									$l = 12;
								}
								for ($i = $q; $i <= $l; ++$i) {
							?>
							<td style="text-align: center;">
								<?php
								//	$query = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = $i AND program = '$prgAdpDsp' AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND year = " . $_GET['selYear'];
									$qryAdpNumMth = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$i' AND program = '$prgAdpDsp' AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND year = '$genYr'";
									$rsltAdpNumMth = mysqli_query($mysqli, $qryAdpNumMth) or die(mysqli_query($mysqli));
									$mthAdpNume = mysqli_affected_rows($mysqli);
											
								//	$query1 = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = $i AND program = '$prgAdpDsp' AND c803_tcr_reading != '' AND year = " . $_GET['selYear'];
									$qryAdpDenMth = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$i' AND program = '$prgAdpDsp' AND c803_tcr_reading != '' AND year = '$genYr'";
									$rsltAdpDenMth = mysqli_query($mysqli, $qryAdpDenMth) or die(mysqli_query($mysqli));
									$mthAdpDeno = mysqli_affected_rows($mysqli);
										
									$rndAdpMth = round(($mthAdpNume / $mthAdpDeno), 2);
									$mthAdpPrcnt = $rndAdpMth * 100;
									echo $mthAdpPrcnt . "%";
								?>
							</td>
							<?php
								}
							?>
							<th style="border-right: 1px solid #000000; text-align: center;">
								<?php
									if ((int)$genMth <= 3) {
										$qryAdpNumAvg = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE program = '$prgAdpDsp' AND month <= 3 AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND year = '$genYr'";
										$rsltAdpNumAvg = mysqli_query($mysqli, $qryAdpNumAvg) or die(mysqli_query($mysqli));
										$avgAdpNume = mysqli_affected_rows($mysqli);
											
										$qryAdpDenAvg = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE program = '$prgAdpDsp' AND month <= 3 AND c803_tcr_reading != '' AND year = '$genYr'";
										$rsltAdpDenAvg = mysqli_query($mysqli, $qryAdpDenAvg) or die(mysqli_query($mysqli));
										$avgAdpDeno = mysqli_affected_rows($mysqli);
										if ($avgAdpDeno == null) {
											$avgAdpPrcnt = "0";
											echo $avgAdpPrcnt . "%";
										} else {
											$rndAdpAvg = round(($avgAdpNume / $avgAdpDeno), 2);
											$avgAdpPrcnt = $rndAdpAvg * 100;
											echo $avgAdpPrcnt . "%";
										}
									} elseif (((int)$genMth > 3) && ((int)$genMth <= 6)) {
										$qryAdpNumAvg = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE program = '$prgAdpDsp' AND month > 3 AND month <= 6 AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND year = '$genYr'";
										$rsltAdpNumAvg = mysqli_query($mysqli, $qryAdpNumAvg) or die(mysqli_query($mysqli));
										$avgAdpNume = mysqli_affected_rows($mysqli);
											
										$qryAdpDenAvg = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE program = '$prgAdpDsp' AND month > 3 AND month <= 6 AND c803_tcr_reading != '' AND year = '$genYr'";
										$rsltAdpDenAvg = mysqli_query($mysqli, $qryAdpDenAvg) or die(mysqli_query($mysqli));
										$avgAdpDeno = mysqli_affected_rows($mysqli);
										if ($avgAdpDeno == null) {
											$avgAdpPrcnt = "0";
											echo $avgAdpPrcnt . "%";
										} else {
											$rndAdpAvg = round(($avgAdpNume / $avgAdpDeno), 2);
											$avgAdpPrcnt = $rndAdpAvg * 100;
											echo $avgAdpPrcnt . "%";
										}
									} elseif (((int)$genMth > 6) && ((int)$genMth <= 9)) {
										$qryAdpNumAvg = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE program = '$prgAdpDsp' AND month > 6 AND month <= 9 AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND year = '$genYr'";
										$rsltAdpNumAvg = mysqli_query($mysqli, $qryAdpNumAvg) or die(mysqli_query($mysqli));
										$avgAdpNume = mysqli_affected_rows($mysqli);
											
										$qryAdpDenAvg = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE program = '$prgAdpDsp' AND month > 6 AND month <= 9 AND c803_tcr_reading != '' AND year = '$genYr'";
										$rsltAdpDenAvg = mysqli_query($mysqli, $qryAdpDenAvg) or die(mysqli_query($mysqli));
										$avgAdpDeno = mysqli_affected_rows($mysqli);
										if ($avgAdpDeno == null) {
											$avgAdpPrcnt = "0";
											echo $avgAdpPrcnt . "%";
										} else {
											$rndAdpAvg = round(($avgAdpNume / $avgAdpDeno), 2);
											$avgAdpPrcnt = $rndAdpAvg * 100;
											echo $avgAdpPrcnt . "%";
										}
									} else {
										$qryAdpNumAvg = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE program = '$prgAdpDsp' AND month > 9 AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND year = '$genYr'";
										$rsltAdpNumAvg = mysqli_query($mysqli, $qryAdpNumAvg) or die(mysqli_query($mysqli));
										$avgAdpNume = mysqli_affected_rows($mysqli);
											
										$qryAdpDenAvg = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE program = '$prgAdpDsp' AND month > 9 AND c803_tcr_reading != '' AND year = '$genYr'";
										$rsltAdpDenAvg = mysqli_query($mysqli, $qryAdpDenAvg) or die(mysqli_query($mysqli));
										$avgAdpDeno = mysqli_affected_rows($mysqli);
										if ($avgAdpDeno == null) {
											$avgAdpPrcnt = "0";
											echo $avgAdpPrcnt . "%";
										} else {
											$rndAdpAvg = round(($avgAdpNume / $avgAdpDeno), 2);
											$avgAdpPrcnt = $rndAdpAvg * 100;
											echo $avgAdpPrcnt . "%";
										}
									}
								?>
							</th>
							<?php
								if ((int)$genMth <= 3) {
									$q = 1;
									$l = 3;
								} elseif (((int)$genMth > 3) && ((int)$genMth <= 6)) {
									$q = 4;
									$l = 6;
								} elseif (((int)$genMth > 6) && ((int)$genMth <= 9)) {
									$q = 7;
									$l = 9;
								} else {
									$q = 10;
									$l = 12;
								}
								for ($i = $q; $i <= $l; ++$i) {
							?>
							<td style="text-align: center;">
								<?php
								//	$query = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE month = $i AND program = '$prgAdpDsp' AND s206_cl_dispensed = '1' AND year = " . $_GET['selYear'];
									$qryDspFncNumMth = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE month = '$i' AND program = '$prgAdpDsp' AND s206_cl_dispensed = '1' AND year = '$genYr'";
									$rsltDspFncNumMth = mysqli_query($mysqli, $qryDspFncNumMth) or die(mysqli_query($mysqli));
									$mthDspFncNume = mysqli_affected_rows($mysqli);
									
								//	$query1 = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE month = $i AND program = '$prgAdpDsp' AND s206_cl_dispensed != '' AND year = " . $_GET['selYear'];
									$qryDspFncDenMth = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE month = '$i' AND program = '$prgAdpDsp' AND s206_cl_dispensed != '' AND year = '$genYr'";
									$rsltDspFncDenMth = mysqli_query($mysqli, $qryDspFncDenMth) or die(mysqli_query($mysqli));
									$mthDspFncDeno = mysqli_affected_rows($mysqli);
									
									$rndDspFncMth = round(($mthDspFncNume / $mthDspFncDeno), 2);
									$mthDspFncPrcnt = $rndDspFncMth * 100;
									echo $mthDspFncPrcnt . "%";
								?>
							</td>
							<?php
								}
							?>
							<th style="text-align: center;">
								<?php
									if ((int)$genMth <= 3) {
										$qryDspFncNumAvg = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE program = '$prgAdpDsp' AND month <= 3 AND s206_cl_dispensed = '1' AND year = '$genYr'";
										$rsltDspFncNumAvg = mysqli_query($mysqli, $qryDspFncNumAvg) or die(mysqli_query($mysqli));
										$mthDspFncNume = mysqli_affected_rows($mysqli);
									
										$qryDspFncDenAvg = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE program = '$prgAdpDsp' AND month <= 3 AND s206_cl_dispensed != '' AND year = '$genYr'";
										$rsltDspFncDenAvg = mysqli_query($mysqli, $qryDspFncDenAvg) or die(mysqli_query($mysqli));
										$avgDspFncDeno = mysqli_affected_rows($mysqli);
										if ($avgDspFncDeno == null) {
											$avgDspFncPrcnt = "0";
											echo $avgDspFncPrcnt . "%";
										} else {
											$rndDspFncAvg = round(($mthDspFncNume / $avgDspFncDeno), 2);
											$avgDspFncPrcnt = $rndDspFncAvg * 100;
											echo $avgDspFncPrcnt . "%";
										}
									} elseif (((int)$genMth > 3) && ((int)$genMth <= 6)) {
										$qryDspFncNumAvg = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE program = '$prgAdpDsp' AND month > 3 AND month <= 6 AND s206_cl_dispensed = '1' AND year = '$genYr'";
										$rsltDspFncNumAvg = mysqli_query($mysqli, $qryDspFncNumAvg) or die(mysqli_query($mysqli));
										$mthDspFncNume = mysqli_affected_rows($mysqli);
									
										$qryDspFncDenAvg = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE program = '$prgAdpDsp' AND month > 3 AND month <= 6 AND s206_cl_dispensed != '' AND year = '$genYr'";
										$rsltDspFncDenAvg = mysqli_query($mysqli, $qryDspFncDenAvg) or die(mysqli_query($mysqli));
										$avgDspFncDeno = mysqli_affected_rows($mysqli);
										if ($avgDspFncDeno == null) {
											$avgDspFncPrcnt = "0";
											echo $avgDspFncPrcnt . "%";
										} else {
											$rndDspFncAvg = round(($mthDspFncNume / $avgDspFncDeno), 2);
											$avgDspFncPrcnt = $rndDspFncAvg * 100;
											echo $avgDspFncPrcnt . "%";
										}
									} elseif (((int)$genMth > 6) && ((int)$genMth <= 9)) {
										$qryDspFncNumAvg = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE program = '$prgAdpDsp' AND month > 6 AND month <= 9 AND s206_cl_dispensed = '1' AND year = '$genYr'";
										$rsltDspFncNumAvg = mysqli_query($mysqli, $qryDspFncNumAvg) or die(mysqli_query($mysqli));
										$mthDspFncNume = mysqli_affected_rows($mysqli);
									
										$qryDspFncDenAvg = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE program = '$prgAdpDsp' AND month > 6 AND month <= 9 AND s206_cl_dispensed != '' AND year = '$genYr'";
										$rsltDspFncDenAvg = mysqli_query($mysqli, $qryDspFncDenAvg) or die(mysqli_query($mysqli));
										$avgDspFncDeno = mysqli_affected_rows($mysqli);
										if ($avgDspFncDeno == null) {
											$avgDspFncPrcnt = "0";
											echo $avgDspFncPrcnt . "%";
										} else {
											$rndDspFncAvg = round(($mthDspFncNume / $avgDspFncDeno), 2);
											$avgDspFncPrcnt = $rndDspFncAvg * 100;
											echo $avgDspFncPrcnt . "%";
										}
									} else {
										$qryDspFncNumAvg = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE program = '$prgAdpDsp' AND month > 9 AND s206_cl_dispensed = '1' AND year = '$genYr'";
										$rsltDspFncNumAvg = mysqli_query($mysqli, $qryDspFncNumAvg) or die(mysqli_query($mysqli));
										$mthDspFncNume = mysqli_affected_rows($mysqli);
									
										$qryDspFncDenAvg = "SELECT s206_cl_dispensed FROM dsw_per_dispensed_rates WHERE program = '$prgAdpDsp' AND month > 9 AND s206_cl_dispensed != '' AND year = '$genYr'";
										$rsltDspFncDenAvg = mysqli_query($mysqli, $qryDspFncDenAvg) or die(mysqli_query($mysqli));
										$avgDspFncDeno = mysqli_affected_rows($mysqli);
										if ($avgDspFncDeno == null) {
											$avgDspFncPrcnt = "0";
											echo $avgDspFncPrcnt . "%";
										} else {
											$rndDspFncAvg = round(($mthDspFncNume / $avgDspFncDeno), 2);
											$avgDspFncPrcnt = $rndDspFncAvg * 100;
											echo $avgDspFncPrcnt . "%";
										}
									}
								?>
							</th>
						</tr>
						<?php
						}
						/*end row population*/
						?>
					</table>
					<br>
					<!-- start: vertical bars -->
					<div class="grpBarGrph">
						<div class="verM1">
							<div id="barM1">
								<div id="mtrM1"></div>
							</div>
							<?php if ((int)$genMth <= 3) { ?>
							<b>January</b>
							<?php } elseif (((int)$genMth > 3) && ((int)$genMth <= 6)) { ?>
							<b>April</b>
							<?php } elseif (((int)$genMth > 6) && ((int)$genMth <= 9)) { ?>
							<b>July</b>
							<?php } else { ?>
							<b>October</b>
							<?php } ?>
						</div>
						<div class="verM2">
							<div id="barM2">
								<div id="mtrM2"></div>
							</div>
							<?php if ((int)$genMth <= 3) { ?>
							<b>February</b>
							<?php } elseif (((int)$genMth > 3) && ((int)$genMth <= 6)) { ?>
							<b>May</b>
							<?php } elseif (((int)$genMth > 6) && ((int)$genMth <= 9)) { ?>
							<b>August</b>
							<?php } else { ?>
							<b>November</b>
							<?php } ?>
						</div>
						<div class="verM3">
							<div id="barM3">
								<div id="mtrM3"></div>
							</div>
							<?php if ((int)$genMth <= 3) { ?>
							<b>March</b>
							<?php } elseif (((int)$genMth > 3) && ((int)$genMth <= 6)) { ?>
							<b>June</b>
							<?php } elseif (((int)$genMth > 6) && ((int)$genMth <= 9)) { ?>
							<b>September</b>
							<?php } else { ?>
							<b>December</b>
							<?php } ?>
						</div>
					</div>
					<b>Average Adoption per month</b>
					<!-- stop: vertical bars -->
					<?php
					/*start: data generation of vertical bars (note: this is just a php section of code that's been placed near the html code that depends on it. Attempts to merge this php code with the Adoption and Dispenser table php code was found to be inefficient particularly in the loops that would generate the data redundantly and hence delay the page in loading)*/
						if ((int)$genMth <= 3) {
							$q = 1;
							$l = 3;
						} elseif (((int)$genMth > 3) && ((int)$genMth <= 6)) {
							$q = 4;
							$l = 6;
						} elseif (((int)$genMth > 6) && ((int)$genMth <= 9)) {
							$q = 7;
							$l = 9;
						} else {
							$q = 10;
							$l = 12;
						}
						for ($i = $q; $i <= $l; ++$i) {
							$sumprod_a_n = 0;
							$nume_weit_sum = 0;
							$res = mysqli_query($mysqli, "SELECT distinct program FROM dsw_per_adoption_rates WHERE country = '$country_val' AND year = '$genYr' ORDER BY program");
							while ($row = mysqli_fetch_assoc($res)) {
								$prog = $row["program"];

								$query = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = $i AND program = '$prog' AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND year = '$genYr'";
								$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
								$nume = mysqli_affected_rows($mysqli);

								$query1 = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = $i AND program = '$prog' AND c803_tcr_reading != '' AND year = '$genYr'";
								$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
								$deno = mysqli_affected_rows($mysqli);

								$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = $i AND program = '$prog' AND year = '$genYr'";
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
							}
							$m++;
							if ((int)$m == 1) {
								if ($nume_weit_sum == null) {
									$m1 = "0";
								} else {
									$m1 = round(($sumprod_a_n / $nume_weit_sum), 0);
								}
							} elseif ((int)$m == 2) {
								if ($nume_weit_sum == null) {
									$m2 = "0";
								} else {
									$m2 = round(($sumprod_a_n / $nume_weit_sum), 0);
								}
							} else {
								if ($nume_weit_sum == null) {
									$m3 = "0";
								} else {
									$m3 = round(($sumprod_a_n / $nume_weit_sum), 0);
								}
							}
						}
					/*stop: data generation of vertical bars*/
					?>
					<br>
					<p class="hdrHorizBar">
						Official Statistics
					</p>
					<div>
					<b>Total Chlorine Deliveries:<?php echo " " . number_format($_sum);?></b>
					<br>
					<b>Average
					<?php 
						if ($country_val == "1") {
							echo " (Kenya) ";
						} elseif ($country_val == "2") {
							echo " (Uganda) ";
						} else {
							echo " (Malawi) ";
						}
					?>
					Chlorine Usage:<?php echo " " . round($_aver) . "L";?></b>
					<br>
					<b>Average Hardware Problems:
					<?php
						$ahpQry = "SELECT s208_dispprob FROM dsw_per_dispensed_rates WHERE country = '$country_val' AND  month = '$genMth' AND s208_dispprob = '1' AND year = '$genYr'";
						$ahpRslt = mysqli_query($mysqli, $ahpQry) or die(mysqli_query($mysqli));
						$ahpNume = mysqli_affected_rows($mysqli);

						$ahpQry1 = "SELECT s208_dispprob FROM dsw_per_dispensed_rates WHERE country = '$country_val' AND month = '$genMth' AND s208_dispprob != '' AND year = '$genYr'";
						$ahpRslt1 = mysqli_query($mysqli, $ahpQry1) or die(mysqli_query($mysqli));
						$ahpDeno = mysqli_affected_rows($mysqli);
						if ($ahpDeno == null) {
							echo "N/A";
						} else {
							$ahpAns = round(($ahpNume / $ahpDeno), 2);
							$ahpPcnt = $ahpAns * 100;
							echo $ahpPcnt . "%";
						}
					?></b>
					<br>
					<b>Total Number of Households Visited:
					<?php
						$HHQry = "SELECT  c102_wpt_id  FROM dsw_per_adoption_rates WHERE country='$country_val' AND month = '$genMth' AND year = '$genYr'";
						$result_h = mysqli_query($mysqli, $HHQry) or die(mysqli_query($mysqli));
						$hhld = mysqli_affected_rows($mysqli);
						if ($hhld == 0) {
							echo "N/A";
						} else {
							echo $hhld;
						}
					?></b>
				</div></div>
			</div>
		</div>
	</body>
</html>
<script>
/*	$(document).ready(function() {
		$('.left').css('visibility', 'visible');
		$.post("+ajax_dswperfindic.php", {
			report_bar: 'bar_data',
			info_type: 'adpt'
			}).done(function(data) {
				var contents = data.split(",");
				createAdopBar('#barAdpt', '#mtrAdpt', contents[0], contents[1]);
			});
		});
*/	
	$(document).ready(function() {
		$('.left').css('visibility', 'visible');
		var prcnt = <?php echo $adpAvMth; ?>;
		setAdopBar('#barAdpt', '#mtrAdpt', prcnt);
	});	
/*	$(document).ready(function() {
		$.post("+ajax_dswperfindic.php", {
			report_bar: 'bar_data',
			info_type: 'instll'
			}).done(function(data) {
			var contents = data.split(",");
			createInstllBar('#barInstll', '#mtrInstll', contents[0], '2015 Target: ', '#ttlInstll', contents[1], '#tgtInstll');
		});
	});
*/	
	$(document).ready(function() {
		jsInstll = <?php echo $inTtl; ?>;
		jsInstllTgt = <?php if ($country_val == "1") {
								echo "6300";
							} elseif ($country_val == "2") {
								echo "5000";
							} else {
								echo "3100";
							}
						?>;
		createInstllBar('#barInstll', '#mtrInstll', jsInstll, '2015 Target: ', '#ttlInstll', jsInstllTgt, '#tgtInstll');
	});
/*	$(document).ready(function() {
		$.post("+ajax_dswperfindic.php", {
			report_bar: 'bar_data',
			info_type: 'PplSvd'
			}).done(function(data) {
			var contents = data.split(",");
			createPplSvdBar('#barPplSvd', '#mtrPplSvd', contents[0], '2015 Target: ', '#ttlPplSvd', contents[1], '#tgtPplSvd');
		});
	});
*/	
	$(document).ready(function() {
		var jsPplSvd = <?php echo $pplsvd; ?>;
		var jsPplSvdTgt = <?php if ($country_val == "1") {
									echo "3008200";
								} elseif ($country_val == "2") {
									echo "2624000";
								} else {
									echo "1553200";
								}
							?>;
		createPplSvdBar('#barPplSvd', '#mtrPplSvd', jsPplSvd, '2015 Target: ', '#ttlPplSvd', jsPplSvdTgt, '#tgtPplSvd');
	});
	function commaSeparateNumber(val) {
		while (/(\d+)(\d{3})/.test(val.toString())) {
			val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
		}
		return val;
	}
/*	function createAdopBar(percentageContainer, percentageValue, data1, data2) {
		var barPercentage = (data1 / data2 * 100.0).toFixed(2);
		setAdopBar(percentageContainer, percentageValue, barPercentage);
	}
*/	
	function createInstllBar(percentageContainer, percentageValue, data, lblTgt, holder1, tgt, holder2) {
		setInstllBar(percentageContainer, percentageValue, data);
		$(holder1).html(lblTgt);
		$(holder2).html(commaSeparateNumber(tgt));
	}
	function createPplSvdBar(percentageContainer, percentageValue, data, lblTgt, holder1, tgt, holder2) {
		setPplSvdBar(percentageContainer, percentageValue, data);
		$(holder1).html(lblTgt);
		$(holder2).html(commaSeparateNumber(tgt));
	}	
/*	function setAdopBar(mainContainer, percentageContainer, percentage) {
		$(mainContainer).css('visibility', 'visible');
		var divWidth = percentage;
		if (divWidth > 100) {
		divWidthExcess = divWidth - 100;
		divWidthExcessDivided = divWidthExcess / 10;
		divWidth = 100 + divWidthExcessDivided;
		}
		
		$(percentageContainer).animate({
		width: divWidth + '%'
		}, 500);
		$(percentageContainer).html(percentage + '%');
		}
*/	
	function setAdopBar(mainContainer, percentageContainer, percentage) {
		$(mainContainer).css('visibility', 'visible');
		var divWidth = percentage;
		if (divWidth > 100) {
			divWidthExcess = divWidth - 100;
			divWidthExcessDivided = divWidthExcess / 10;
			divWidth = 100 + divWidthExcessDivided;
		}
		
		$(percentageContainer).animate({
			width: divWidth + '%'
		}, 500);
		$(percentageContainer).html(percentage + '%');
	}
	function setInstllBar(mainContainer, percentageContainer, percentage) {
		$(mainContainer).css('visibility', 'visible');
		var divWidth = percentage;
		if (divWidth > 100) {
			divWidthExcess = divWidth - 100;
			divWidthExcessDivided = divWidthExcess / 10;
			divWidth = 100 + divWidthExcessDivided;
		}
		
		$(percentageContainer).animate({
			width: '100' + '%'
		}, 500);
		$(percentageContainer).html(commaSeparateNumber(percentage) + ' Installations');
	}
	function setPplSvdBar(mainContainer, percentageContainer, percentage) {
		$(mainContainer).css('visibility', 'visible');
		var divWidth = percentage;
		if (divWidth > 100) {
			divWidthExcess = divWidth - 100;
			divWidthExcessDivided = divWidthExcess / 10;
			divWidth = 100 + divWidthExcessDivided;
		}
		
		$(percentageContainer).animate({
			width: '100' + '%'
		}, 500);
		$(percentageContainer).html(commaSeparateNumber(percentage) + ' People');
	}
	$(document).ready(function(){
		var mth1 = <?php echo $m1; ?>;
		$('#mtrM1').animate({height: mth1 + '%'}, 500, 'swing');
		$('#mtrM1').html(commaSeparateNumber(mth1 + '%'));
	});
	$(document).ready(function(){
		var mth2 = <?php echo $m2; ?>;
		$('#mtrM2').animate({height: mth2 + '%'}, 500, 'swing');
		$('#mtrM2').html(commaSeparateNumber(mth2 + '%'));
	});
	$(document).ready(function(){
		var mth3 = <?php echo $m3; ?>;
		$('#mtrM3').animate({height: mth3 + '%'}, 500, 'swing');
		$('#mtrM3').html(commaSeparateNumber(mth3 + '%'));
	});
	
</script>
<?php ob_flush(); ?>