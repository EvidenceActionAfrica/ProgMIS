<?php
	require_once('includes/config.php');
	//3. Now you can access your data based on the passed parameters to retrieve your data.
	if($_POST['getData'] == 'national') {
		if($_POST['info_type'] == 'adop_rate') {
			$country_val = $_POST['country'];
			//start
			$sumprod_a_n = 0;
			$nume_weit_sum = 0;
			$res = mysqli_query($mysqli, "SELECT DISTINCT program FROM dsw_per_adoption_rates WHERE country = '$country_val' AND year = " . $_POST['year'] . "  ORDER BY program");
			while($row = mysqli_fetch_assoc($res)) {
				$prog = $row["program"];
			
				$query = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = " . $_POST['month'] . " AND program = '$prog' AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND year = " . $_POST['year'];
				$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
				$nume = mysqli_affected_rows($mysqli);
			
				$query1 = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = " . $_POST['month'] . " AND program = '$prog' AND c803_tcr_reading != '' AND year = " . $_POST['year'];
				$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
				$deno = mysqli_affected_rows($mysqli);
			
				$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = " . $_POST['month'] . " AND program = '$prog' AND year = " . $_POST['year'];
				$result_weit = mysqli_query($mysqli, $query_weit) or die(mysqli_query($mysqli));
				$row_weit = mysqli_fetch_assoc($result_weit);
				$nume_weit = $row_weit["sum_total"];
				$nume_weit_sum += $nume_weit;
				if($deno == null) {
					$adpAvMth = "0";
				} else {
					$ans = $nume * 100 / $deno;
					$sumprod_a_n += $ans * $nume_weit;
				}
			}
			if($nume_weit_sum == null) {
				$adpAvMth = "0";
			} else {
				$adpAvMth = round(($sumprod_a_n / $nume_weit_sum), 0);
			}
			//stop
			echo $adpAvMth;
			return;
		} elseif($_POST['info_type'] == 'install'){
			$country_val = $_POST['country'];
			//start
			$query = "SELECT * FROM dispenser_database WHERE country='$country_val' and installation_date like '" . $_POST['year'] . "/%'";
			$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
			$total = mysqli_num_rows($result);
			//stop
			$ins = $total;
			echo $ins;
			return;
		} elseif($_POST['info_type'] == 'pple_srvd'){
			$country_val = $_POST['country'];
			//start
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
	
			if($deno_tot_ken == 0) {
				$pplsvd = "0";
			} elseif($deno2_tot_ken == 0) {
				$pplsvd = "0";
			} else {
				$pplsvd = round(($nume_tot_ken / $deno_tot_ken) * ($nume2_tot_ken / $deno2_tot_ken)*$deno_tot_ken);
			}
			//stop
			echo $pplsvd;
			return;
		} elseif($_POST['info_type'] == 'promoters'){
			$country_val = $_POST['country'];
			//Please note the use of AS followed by an alias on the SQL statements. In order to have SQL return data that php can read, you must write the SQL statements this way.
			//Also, note that the aliases are used as a reference when assigning them to php variables.
			
			//Total gender promoters count
			$sqlPromSexTtl = "SELECT COUNT(`promoter_gender`) AS TTL FROM `promoter_details` WHERE country = '$country_val'";
			$qryPromSexTtl = mysqli_query($mysqli, $sqlPromSexTtl) or die(mysqli_query($mysqli));
			$assocPromSexTtl = mysqli_fetch_assoc($qryPromSexTtl);
			$promSexTtl = $assocPromSexTtl['TTL'];
			
			//Female promoters count
			$sqlPromSexFml = "SELECT COUNT(`promoter_gender`) AS FML FROM `promoter_details` WHERE `promoter_gender` = 'Female' AND country = '$country_val'";
			$qryPromSexFml = mysqli_query($mysqli, $sqlPromSexFml) or die(mysqli_query($mysqli));
			$assocPromSexFml = mysqli_fetch_assoc($qryPromSexFml);
			$promSexFml = $assocPromSexFml['FML'];
			
			//Female promoters count
			$sqlPromSexMle = "SELECT COUNT(`promoter_gender`) AS MLE FROM `promoter_details` WHERE `promoter_gender` = 'Male' AND country = '$country_val'";
			$qryPromSexMle = mysqli_query($mysqli, $sqlPromSexMle) or die(mysqli_query($mysqli));
			$assocPromSexMle = mysqli_fetch_assoc($qryPromSexMle);
			$promSexMle = $assocPromSexMle['MLE'];
			
			//Unspecified gender count
			$promSexUnspe = $promSexTtl - ($promSexFml + $promSexMle);
			
			echo $promSexTtl . "," . $promSexFml . "," . $promSexMle . "," . $promSexUnspe;
			return;
		} elseif($_POST['info_type'] == 'adp_trnd') {
			$country_val = $_POST['country'];
			$yrSelected = $_POST['year'];
			$yrOthrYr = $yrSelected - 1;
		
			//Start by getting the distinct year entries available in the database.
			$sqlAdpTrndYr = "SELECT DISTINCT year AS YR FROM dsw_per_adoption_rates WHERE country = '$country_val' ORDER BY year DESC";
			$qryAdpTrndYr = mysqli_query($mysqli, $sqlAdpTrndYr) or die(mysqli_query($mysqli));
			
			$i = 0;
			while($assocAdpTrndYr = mysqli_fetch_assoc($qryAdpTrndYr)) {
				$arrayAdpTrnd[$i] = $assocAdpTrndYr['YR'];
				//start
				if($arrayAdpTrnd[$i] == $yrOthrYr) {
					for($value = 1; $value < 13; ++$value) {
						$sumprod_a_n = 0;
						$nume_weit_sum = 0;
						$res = mysqli_query($mysqli, "SELECT DISTINCT program FROM `dsw_per_adoption_rates` WHERE country='$country_val' AND YEAR = '$yrOthrYr' ORDER BY program");
						while ($row = mysqli_fetch_assoc($res)) {
							$prog = $row["program"];

							$query = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND YEAR = '$yrOthrYr'";
							$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
							$nume = mysqli_affected_rows($mysqli);

							$query1 = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND c803_tcr_reading != '' AND YEAR = '$yrOthrYr'";
							$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
							$deno = mysqli_affected_rows($mysqli);

							$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '$prog' AND YEAR = '$yrOthrYr'";
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
						if ($nume_weit_sum == null) {
							$sumprod_a_n = "";
						} else {
							$arrayYrOthrYr[$value] = round(($sumprod_a_n / $nume_weit_sum), 0);
						}
						if($arrayYrOthrYr[$value] == "") {
							$arrayYrOthrYr[$value] = "NULL"; //Pass a string (you can use any string) where arrayYrOthrYr[$value] is null so that zero is not mapped on the line graph.
						}
					}
				} elseif($arrayAdpTrnd[$i] == $yrSelected) {
					for($value = 1; $value < 13; ++$value) {
						$sumprod_a_n = 0;
						$nume_weit_sum = 0;
						$res = mysqli_query($mysqli, "SELECT DISTINCT program FROM `dsw_per_adoption_rates` WHERE country='$country_val' AND YEAR = '$yrSelected' ORDER BY program");
						while ($row = mysqli_fetch_assoc($res)) {
							$prog = $row["program"];

							$query = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND YEAR = '$yrSelected'";
							$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
							$nume = mysqli_affected_rows($mysqli);

							$query1 = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND c803_tcr_reading != '' AND YEAR = '$yrSelected'";
							$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
							$deno = mysqli_affected_rows($mysqli);

							$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '$prog' AND YEAR = '$yrSelected'";
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
						if ($nume_weit_sum == null) {
							$sumprod_a_n = "";
						} else {
							$arrayYrSelected[$value] = round(($sumprod_a_n / $nume_weit_sum), 0);
						}
						if($arrayYrSelected[$value] == "") {
							$arrayYrSelected[$value] = "NULL"; //Pass a string (you can use any string) where arrayYrOthrYr[$value] is null so that zero is not mapped on the line graph.
						}
					}
				}
				$i++;
			}
			echo $arrayYrOthrYr[1] . "," . $arrayYrOthrYr[2] . "," . $arrayYrOthrYr[3] . "," . $arrayYrOthrYr[4] . "," . $arrayYrOthrYr[5] . "," . $arrayYrOthrYr[6] . "," . $arrayYrOthrYr[7] . "," . $arrayYrOthrYr[8] . "," . $arrayYrOthrYr[9] . "," . $arrayYrOthrYr[10] . "," . $arrayYrOthrYr[11] . "," . $arrayYrOthrYr[12] . "," . $arrayYrSelected[1] . "," . $arrayYrSelected[2] . "," . $arrayYrSelected[3] . "," . $arrayYrSelected[4] . "," . $arrayYrSelected[5] . "," . $arrayYrSelected[6] . "," . $arrayYrSelected[7] . "," . $arrayYrSelected[8] . "," . $arrayYrSelected[9] . "," . $arrayYrSelected[10] . "," . $arrayYrSelected[11] . "," . $arrayYrSelected[12] . "," . $yrOthrYr;
			return;
		}
	} else { //Since this file is shared between +reportNational.php" and "+reportProgram.php", then this part of the construct will automatically execute when "+reportProgram.php" calls it as the condition is now $_POST['getData'] == 'program'
		if($_POST['info_type'] == 'adop_rate') {
		
			if ((int)$_POST['month'] <= 3) {
				$q = 1;
				$l = 3;
			} elseif (((int)$_POST['month'] > 3) && ((int)$_POST['month'] <= 6)) {
				$q = 4;
				$l = 6;
			} elseif (((int)$_POST['month'] > 6) && ((int)$_POST['month'] <= 9)) {
				$q = 7;
				$l = 9;
			} else {
				$q = 10;
				$l = 12;
			}
			$m = 0;
			for ($i = $q; $i <= $l; ++$i) {
				$qryAdpNumMth = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$i' AND program = '" . $_POST['prog'] . "' AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND year = " . $_POST['year'];
				$rsltAdpNumMth = mysqli_query($mysqli, $qryAdpNumMth) or die(mysqli_query($mysqli));
				$mthAdpNume = mysqli_affected_rows($mysqli);
											
				$qryAdpDenMth = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$i' AND program = '" . $_POST['prog'] . "' AND c803_tcr_reading != '' AND year = " . $_POST['year'];
				$rsltAdpDenMth = mysqli_query($mysqli, $qryAdpDenMth) or die(mysqli_query($mysqli));
				$mthAdpDeno = mysqli_affected_rows($mysqli);
										
				$rndAdpMth = round(($mthAdpNume / $mthAdpDeno), 2);
				$mthAdpPrcnt[$m] = $rndAdpMth * 100;
				$m++;
			}
			echo $mthAdpPrcnt[0] . "," . $mthAdpPrcnt[1] . "," . $mthAdpPrcnt[2];
			return;
		} elseif($_POST['info_type'] == 'promoters') {
			$country_val = $_POST['country'];
			
			//Please note the use of AS followed by an alias on the SQL statements. In order to have SQL return data that php can read, you must write the SQL statements this way.
			//Also, note that the aliases are used as a reference when assigning them to php variables.
			
			//Abreviated program names on `program` column in the `promoter_details` table don't match with the fully named program names used in +reportProgram.php
			//Therefore, use the `dispenser_database` table's `program` and `program_name` columns to resolve this.
			$sqlGetProg = "SELECT DISTINCT `program` AS PROGNME FROM `dispenser_database` WHERE `program_name` = '" . $_POST['prog'] . "'";
			$qryGetProg = mysqli_query($mysqli, $sqlGetProg) or die(mysqli_query($mysqli));
			$assocGetProg = mysqli_fetch_assoc($qryGetProg);
			$getProg = $assocGetProg['PROGNME'];
			//ATTENTION!!! The reason why some programs are returning the "No data returned!" message is because their program names are completely absent on the `promoter_details` table.
						
			//Total gender promoters count
			$sqlPromSexTtl = "SELECT COUNT(`promoter_gender`) AS TTL FROM `promoter_details` WHERE country = '$country_val' AND program = '$getProg'";
			$qryPromSexTtl = mysqli_query($mysqli, $sqlPromSexTtl) or die(mysqli_query($mysqli));
			$assocPromSexTtl = mysqli_fetch_assoc($qryPromSexTtl);
			$promSexTtl = $assocPromSexTtl['TTL'];
			
			//Female promoters count
			$sqlPromSexFml = "SELECT COUNT(`promoter_gender`) AS FML FROM `promoter_details` WHERE `promoter_gender` = 'Female' AND country = '$country_val' AND program = '$getProg'";
			$qryPromSexFml = mysqli_query($mysqli, $sqlPromSexFml) or die(mysqli_query($mysqli));
			$assocPromSexFml = mysqli_fetch_assoc($qryPromSexFml);
			$promSexFml = $assocPromSexFml['FML'];
			
			//Female promoters count
			$sqlPromSexMle = "SELECT COUNT(`promoter_gender`) AS MLE FROM `promoter_details` WHERE `promoter_gender` = 'Male' AND country = '$country_val' AND program = '$getProg'";
			$qryPromSexMle = mysqli_query($mysqli, $sqlPromSexMle) or die(mysqli_query($mysqli));
			$assocPromSexMle = mysqli_fetch_assoc($qryPromSexMle);
			$promSexMle = $assocPromSexMle['MLE'];
			
			//Unspecified gender count
			$promSexUnspe = $promSexTtl - ($promSexFml + $promSexMle);
			
			echo $promSexTtl . "," . $promSexFml . "," . $promSexMle . "," . $promSexUnspe;
			return;
		} elseif($_POST['info_type'] == 'chlo_use') {
			//ATTENTION!!! The reason why some programs are returning zeros and having 0% on the pie chart while DSW has 100% is because their program names are completely absent on the `dsw_per_chlorine` table.
			$country_val = $_POST['country'];
			
			$sqlTtlChloUsed = "SELECT SUM(Jerrican_delivered) AS _sum_num FROM dsw_per_chlorine WHERE country='$country_val'";
			$qryTtlChloUsed = mysqli_query($mysqli, $sqlTtlChloUsed) or die(mysqli_query($mysqli));
			$assocTtlChloUsed = mysqli_fetch_assoc($qryTtlChloUsed);
			$ttlChloUsed = $assocTtlChloUsed['_sum_num'];
						
			$sqlProgChloUsed = "SELECT SUM(Jerrican_delivered) AS _sum_num FROM dsw_per_chlorine WHERE country='$country_val' AND program = '" . $_POST['prog'] . "'";
			$qryProgChloUsed = mysqli_query($mysqli, $sqlProgChloUsed) or die(mysqli_query($mysqli));
			$assocProgChloUsed = mysqli_fetch_assoc($qryProgChloUsed);
			$progChloUsed = $assocProgChloUsed['_sum_num'];
	
			echo $ttlChloUsed . "," . $progChloUsed;
			return;
		} elseif($_POST['info_type'] == 'adp_trnd') {
			$country_val = $_POST['country'];
			$yrSelected = $_POST['year'];
			$yrOthrYr = $yrSelected - 1;
			
			
			//Start by getting the distinct year entries available in the database.
			$sqlAdpTrndYr = "SELECT DISTINCT year AS YR FROM dsw_per_adoption_rates WHERE country = '$country_val' ORDER BY year DESC";
			$qryAdpTrndYr = mysqli_query($mysqli, $sqlAdpTrndYr) or die(mysqli_query($mysqli));
			
			$i = 0;
			while($assocAdpTrndYr = mysqli_fetch_assoc($qryAdpTrndYr)) {
				$arrayAdpTrnd[$i] = $assocAdpTrndYr['YR'];
				//start
				if($arrayAdpTrnd[$i] == $yrOthrYr) {
					for($value = 1; $value < 13; ++$value) {
						$sumprod_a_n = 0;
						$nume_weit_sum = 0;
						$res = mysqli_query($mysqli, "SELECT DISTINCT program FROM `dsw_per_adoption_rates` WHERE country='$country_val' AND YEAR = '$yrOthrYr' ORDER BY program");
						
						$query = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '" . $_POST['prog'] . "' AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND YEAR = '$yrOthrYr'";
						$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
						$nume = mysqli_affected_rows($mysqli);

						$query1 = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '" . $_POST['prog'] . "' AND c803_tcr_reading != '' AND YEAR = '$yrOthrYr'";
						$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
						$deno = mysqli_affected_rows($mysqli);

						$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '" . $_POST['prog'] . "' AND YEAR = '$yrOthrYr'";
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
							$sumprod_a_n = "";
						} else {
							$arrayYrOthrYr[$value] = round(($sumprod_a_n / $nume_weit_sum), 0);
						}
						if($arrayYrOthrYr[$value] == "") {
							$arrayYrOthrYr[$value] = "NULL"; //Pass a string (you can use any string) where arrayYrOthrYr[$value] is null so that zero is not mapped on the line graph.
						}
					}
				} elseif($arrayAdpTrnd[$i] == $yrSelected) {
					for($value = 1; $value < 13; ++$value) {
						$sumprod_a_n = 0;
						$nume_weit_sum = 0;
						$res = mysqli_query($mysqli, "SELECT DISTINCT program FROM `dsw_per_adoption_rates` WHERE country='$country_val' AND YEAR = '$yrSelected' ORDER BY program");
						
						$query = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '" . $_POST['prog'] . "' AND c803_tcr_reading != '0' AND c803_tcr_reading != '' AND YEAR = '$yrSelected'";
						$result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
						$nume = mysqli_affected_rows($mysqli);

						$query1 = "SELECT c803_tcr_reading FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '" . $_POST['prog'] . "' AND c803_tcr_reading != '' AND YEAR = '$yrSelected'";
						$result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
						$deno = mysqli_affected_rows($mysqli);

						$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '" . $_POST['prog'] . "' AND YEAR = '$yrSelected'";
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
							$sumprod_a_n = "";
						} else {
							$arrayYrSelected[$value] = round(($sumprod_a_n / $nume_weit_sum), 0);
						}
						if($arrayYrSelected[$value] == "") {
							$arrayYrSelected[$value] = "NULL"; //Pass a string (you can use any string) where arrayYrOthrYr[$value] is null so that zero is not mapped on the line graph.
						}
					}
				}
				$i++;
			}
			echo $arrayYrOthrYr[1] . "," . $arrayYrOthrYr[2] . "," . $arrayYrOthrYr[3] . "," . $arrayYrOthrYr[4] . "," . $arrayYrOthrYr[5] . "," . $arrayYrOthrYr[6] . "," . $arrayYrOthrYr[7] . "," . $arrayYrOthrYr[8] . "," . $arrayYrOthrYr[9] . "," . $arrayYrOthrYr[10] . "," . $arrayYrOthrYr[11] . "," . $arrayYrOthrYr[12] . "," . $arrayYrSelected[1] . "," . $arrayYrSelected[2] . "," . $arrayYrSelected[3] . "," . $arrayYrSelected[4] . "," . $arrayYrSelected[5] . "," . $arrayYrSelected[6] . "," . $arrayYrSelected[7] . "," . $arrayYrSelected[8] . "," . $arrayYrSelected[9] . "," . $arrayYrSelected[10] . "," . $arrayYrSelected[11] . "," . $arrayYrSelected[12] . "," . $yrOthrYr;
			return;
		} elseif($_POST['info_type'] == 'rec_issue') {
			$country_val = $_POST['country'];
			//Start by getting the total tally for recorded issues for the current country
			//TTL
			$sqlTtlRecIss = "SELECT COUNT(`issues`.`country`) AS TTL FROM `issues` WHERE `issues`.`country` = '$country_val'";
			$qryTtlRecIss = mysqli_query($mysqli, $sqlTtlRecIss) or die(mysqli_query($mysqli));
			$assocTtlRecIss = mysqli_fetch_assoc($qryTtlRecIss);
			$ttlRecIss = $assocTtlRecIss['TTL'];
	
			//PRG
			$sqlGetProg = "SELECT DISTINCT `program` AS PROGNME FROM `dispenser_database` WHERE `program_name` = '" . $_POST['prog'] . "'";
			$qryGetProg = mysqli_query($mysqli, $sqlGetProg) or die(mysqli_query($mysqli));
			$assocGetProg = mysqli_fetch_assoc($qryGetProg);
			$getProg = $assocGetProg['PROGNME'];

			$sqlProgRecIss = "SELECT COUNT(`waterpoint_details`.`program`) AS PRG FROM `waterpoint_details` JOIN `issues` ON `waterpoint_details`.`waterpoint_id` = `issues`.`waterpoint_id` WHERE `waterpoint_details`.`program` = '$getProg'";
			$qryProgRecIss = mysqli_query($mysqli, $sqlProgRecIss) or die(mysqli_query($mysqli));
			$assocProgRecIss = mysqli_fetch_assoc($qryProgRecIss);
			$progRecIss = $assocProgRecIss['PRG'];
			
			echo $ttlRecIss . "," . $progRecIss;
			return;
		}
	}

?>