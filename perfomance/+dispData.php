<?php
	require_once('includes/config.php');

	if($_POST['year'] == '0') {
		$year_sub = "";
		$year = 'All years';
	} else {
		$year_sub = "AND year ='" . $_POST['year'] . "'";
		$year = $_POST['year'];
	}
	$country_val = $_POST['country'];
	$field = 's206_cl_dispensed';
	$field2 = 's208_dispprob';
	
	if($_POST['info_type'] == 'dfr') {
?>

            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th  colspan="14"> YEAR SELECTED : <?php echo $year; ?></th>
                </tr>
                <tr>
                    <th></th>
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>May</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Aug</th>
                    <th>Sep</th>
                    <th>Oct</th>
                    <th>Nov</th>
                    <th>Dec</th>
                    <th>Av./Off.</th>
                </tr>
                <?php
                $i = 0;
                $res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_dispensed_rates` WHERE country='$country_val' $year_sub ORDER BY program");
                while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                    <tr class="heading"> <?php $prog = $row["program"]; ?>
                        <th><?php echo $prog; ?> <b style="color:#3276B1; cursor:pointer; float: right;"> + </b></th> 
                        <?php
                        for ($value = 1; $value < 13; ++$value) {
                            ?>
                        <script type="text/javascript">

                            $(function() {
                                $('div#pop-up<?php echo $i . $value; ?>').hide();
                                $('td#trigger<?php echo $i . $value; ?>').hover(function(e) {
                                    $('div#pop-up<?php echo $i . $value; ?>').show();
                                }, function() {
                                    $('div#pop-up<?php echo $i . $value; ?>').hide();
                                });
                            });
                        </script>
                        <td id="trigger<?php echo $i . $value; ?>"> <?php
                            $query = "SELECT $field FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND $field = '1' $year_sub";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $nume = mysqli_affected_rows($mysqli);

                            $query1 = "SELECT $field FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND $field != '' $year_sub";
                            $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                            $deno = mysqli_affected_rows($mysqli);
                            if ($deno == null) {
                                $query_res = "SELECT reason FROM `dsw_reason_table`  WHERE country='$country_val' AND table_name = 'dsw_per_dispensed_rates' 
                                        AND column_value = '$value' AND row_value = '$prog' $year_sub";
                                $res_pop_up = mysqli_query($mysqli, $query_res) or die(mysqli_query($mysqli));
                                $row_ = mysqli_fetch_assoc($res_pop_up);
                                if (mysqli_affected_rows($mysqli) > 0 && $row_['reason'] != '0') {
                                    ?><div class="pop-up" id="pop-up<?php echo $i . $value; ?>">
                                        <div class="pop-up-img"></div><?php
                                    echo $row_['reason'];
                                    ?></div><?php
                                } else {
                                    echo '';
                                }
                            } else {
                                $ans = round(($nume / $deno), 2);
                                $percent = $ans * 100;
                                echo $percent . "%";
                                ?>
                            </td> 
                            <?php
                        }
                    }
                    ?>
                    <th>
                        <?php
                        $query = "SELECT $field FROM dsw_per_dispensed_rates WHERE program = '$prog' AND $field = '1' $year_sub";
                        $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                        $nume = mysqli_affected_rows($mysqli);

                        $query1 = "SELECT $field FROM dsw_per_dispensed_rates WHERE program = '$prog' AND $field != '' $year_sub";
                        $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                        $deno = mysqli_affected_rows($mysqli);
                        if ($deno == null) {
                            echo "";
                        } else {
                            $ans = round(($nume / $deno), 2);
                            $percent = $ans * 100;
                            echo $percent . "%";
                        }
                        ?>   
                    </th> 
                    </tr>
                    <tr class="content">
                        <td>
                            Spotcheck No            
                        </td>
                        <?php
                        for ($value = 1; $value < 13; ++$value) {
                            ?>

                            <td> <?php
                                $query_spot = "SELECT program FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                                $result_spot = mysqli_query($mysqli, $query_spot) or die(mysqli_query($mysqli));
                                $spot = mysqli_affected_rows($mysqli);
                                if ($spot == 0) {
                                    echo "";
                                } else {
                                    echo $spot;
                                }
                                ?>
                            </td> 

                            <?php
                        }
                        ?> 
                        <td><?php
                            $query_spot = "SELECT program FROM dsw_per_dispensed_rates WHERE program = '$prog' $year_sub";
                            $result_spot = mysqli_query($mysqli, $query_spot) or die(mysqli_query($mysqli));
                            $spot = mysqli_affected_rows($mysqli);
                            if ($spot == 0) {
                                echo "";
                            } else {
                                echo $spot;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr></tr> <?php
                    $i++;
                }
                ?>
                <tr>
                    <th>Av./Month</th>
                    <?php
                    for ($value = 1; $value < 13; ++$value) {
                        ?>
                        <td style="font-weight: bold;"><?php
                            $query = "SELECT $field FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$value' AND $field = '1' $year_sub";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $nume = mysqli_affected_rows($mysqli);

                            $query1 = "SELECT $field FROM dsw_per_dispensed_rates WHERE country='$country_val' AND month = '$value' AND $field != '' $year_sub";
                            $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                            $deno = mysqli_affected_rows($mysqli);
                            if ($deno == null) {
                                echo "";
                            } else {
                                $ans = round(($nume / $deno), 2);
                                $percent = $ans * 100;
                                echo $percent . "%";
                            }
                        }
                        ?></td>
                </tr>
            </table>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery(".content").hide();
					//toggle the componenet with class msg_body
					jQuery(".heading").click(function()
					{
						jQuery(this).next(".content").slideToggle(400);
					});
				});
			</script>
<?php
		
	} else {
?>

            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th  colspan="14"> YEAR SELECTED : <?php echo $year; ?></th>
                </tr>
                <tr>
                    <th></th>
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>May</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Aug</th>
                    <th>Sep</th>
                    <th>Oct</th>
                    <th>Nov</th>
                    <th>Dec</th>
                    <th>Av./Off.</th>
                </tr>
                <?php
                $j = -1;
                $res2 = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_dispensed_rates` WHERE country='$country_val' $year_sub ORDER BY program");
                while ($row = mysqli_fetch_assoc($res2)) {
                    ?>
                    <tr class="heading"> <?php $prog = $row["program"]; ?>
                        <th><?php echo $prog; ?> <b style="color:#3276B1; cursor:pointer; float: right;"> + </b></th>
                        <?php
                        $prog_sum2 = 0;
                        $av_div_prog2 = 0;
                        for ($value = 1; $value < 13; ++$value) {
                            ?>
                        <script type="text/javascript">

                            $(function() {
                                $('div#pop-up<?php echo $j . $value; ?>').hide();
                                $('td#trigger<?php echo $j . $value; ?>').hover(function(e) {
                                    $('div#pop-up<?php echo $j . $value; ?>').show();
                                }, function() {
                                    $('div#pop-up<?php echo $j . $value; ?>').hide();
                                });
                            });
                        </script>
                        <td id="trigger<?php echo $j . $value; ?>"> <?php
                            $query = "SELECT $field2 FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND $field2 = '1'  $year_sub";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $nume = mysqli_affected_rows($mysqli);

                            $query1 = "SELECT $field2 FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND $field2 !='' $year_sub";
                            $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                            $deno = mysqli_affected_rows($mysqli);
                            if ($deno == null) {
                                $query_res = "SELECT reason FROM `dsw_reason_table`  WHERE country='$country_val' AND table_name = 'dsw_per_dispensed_rates' 
                                        AND column_value = '$value' AND row_value = '$prog' $year_sub";
                                $res_pop_up = mysqli_query($mysqli, $query_res) or die(mysqli_query($mysqli));
                                $row_ = mysqli_fetch_assoc($res_pop_up);
                                if (mysqli_affected_rows($mysqli) > 0 && $row_['reason'] != '0') {
                                    ?><div class="pop-up" id="pop-up<?php echo $j . $value; ?>">
                                        <div class="pop-up-img"></div><?php
                                    echo $row_['reason'];
                                    ?></div><?php
                                } else {
                                    echo '';
                                }
                            } else {
                                $ans = round(($nume / $deno), 2);

                                $percent = $ans * 100;
                                echo $percent . "%";
                                $prog_sum2 += $percent;
                                $av_div_prog2++;
                                ?>
                            </td> 
                            <?php
                        }
                    }
                    ?>
                    <th>
                        <?php
                        $query = "SELECT $field2 FROM dsw_per_dispensed_rates WHERE program = '$prog' AND $field2 = '1' $year_sub";
                        $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                        $nume = mysqli_affected_rows($mysqli);

                        $query1 = "SELECT $field2 FROM dsw_per_dispensed_rates WHERE program = '$prog' AND $field2 != '' $year_sub";
                        $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                        $deno = mysqli_affected_rows($mysqli);
                        if ($deno == null) {
                            echo "";
                        } else {
                            $ans = round(($nume / $deno), 2);
                            $percent = $ans * 100;
                            echo $percent . "%";
                        }
                        ?>   
                    </th> 
                    </tr>
                    <tr class="content">
                        <td>
                            HardwareProb_No<br>Spotcheck_No<br>Dispensers_No<br>--<br>Casing_padlock<br>Tank_valve<br>Stickers_barcode<br>Base_PVC_bolts_nuts                    
                        </td>
                        <?php
                        for ($value = 1; $value < 13; ++$value) {
                            ?>

                            <td> <?php
                                $query_hardwareProb = "SELECT program FROM dsw_per_dispensed_rates WHERE program = '$prog' AND month = '$value' AND s208_dispprob = '1' $year_sub";
                                $result_hardwareProb = mysqli_query($mysqli, $query_hardwareProb) or die(mysqli_query($mysqli));
                                $hardwareProb = mysqli_affected_rows($mysqli);

                                $query_spot = "SELECT program FROM dsw_per_dispensed_rates WHERE program = '$prog' AND month = '$value' $year_sub";
                                $result_spot = mysqli_query($mysqli, $query_spot) or die(mysqli_query($mysqli));
                                $spot = mysqli_affected_rows($mysqli);

                                $query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '$prog' $year_sub ";
                                $result_weit = mysqli_query($mysqli, $query_weit) or die(mysqli_query($mysqli));
                                $row_weit = mysqli_fetch_assoc($result_weit);
                                $nume_weit = $row_weit["sum_total"];

                                $query = "SELECT $field2 FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND $field2 = '1' $year_sub";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $value_ = mysqli_affected_rows($mysqli);
                                $query1 = "SELECT $field2 FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND $field2 != '' $year_sub";
                                $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                $value1 = mysqli_affected_rows($mysqli);
                                if ($value1 != 0) {
                                    $nume_deno = $value_ / $value1;
                                }
                                $query_num_Casing = "SELECT s209_dispprob_cas_padlk FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND s209_dispprob_cas_padlk = '1' $year_sub";
                                $result_num_Casing = mysqli_query($mysqli, $query_num_Casing) or die(mysqli_query($mysqli));
                                $value_num_Casing = mysqli_affected_rows($mysqli);
                                $query_deno_Casing = "SELECT s209_dispprob_cas_padlk FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND s209_dispprob_cas_padlk != '' $year_sub";
                                $result_deno_Casing = mysqli_query($mysqli, $query_deno_Casing) or die(mysqli_query($mysqli));
                                $value_deno_Casing = mysqli_affected_rows($mysqli);
                                if ($value_deno_Casing != 0) {
                                    $Casing = $value_num_Casing / $value_deno_Casing;
                                    $dispCasing = round($Casing * $nume_deno * $nume_weit);
                                }


                                $query_num_Tank = "SELECT s210_dispprob_tnk_vlv FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND s210_dispprob_tnk_vlv = '1' $year_sub";
                                $result_num_Tank = mysqli_query($mysqli, $query_num_Tank) or die(mysqli_query($mysqli));
                                $value_num_Tank = mysqli_affected_rows($mysqli);
                                $query_deno_Tank = "SELECT s210_dispprob_tnk_vlv FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND s210_dispprob_tnk_vlv != '' $year_sub";
                                $result_deno_Tank = mysqli_query($mysqli, $query_deno_Tank) or die(mysqli_query($mysqli));
                                $value_deno_Tank = mysqli_affected_rows($mysqli);
                                if ($value_deno_Tank != 0) {
                                    $Tank = $value_num_Tank / $value_deno_Tank;
                                    $dispTank = round($Tank * $nume_deno * $nume_weit);
                                }


                                $query_num_Stickers = "SELECT s211_dispprob_stker_tag_paint FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND s211_dispprob_stker_tag_paint = '1' $year_sub";
                                $result_num_Stickers = mysqli_query($mysqli, $query_num_Stickers) or die(mysqli_query($mysqli));
                                $value_num_Stickers = mysqli_affected_rows($mysqli);
                                $query_deno_Stickers = "SELECT s211_dispprob_stker_tag_paint FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND s211_dispprob_stker_tag_paint != '' $year_sub";
                                $result_deno_Stickers = mysqli_query($mysqli, $query_deno_Stickers) or die(mysqli_query($mysqli));
                                $value_deno_Stickers = mysqli_affected_rows($mysqli);
                                if ($value_deno_Stickers != 0) {
                                    $Stickers = $value_num_Stickers / $value_deno_Stickers;
                                    $dispStickers = round($Stickers * $nume_deno * $nume_weit);
                                }


                                $query_num_Base_PVC = "SELECT s212_nut FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND s212_nut = '1' $year_sub";
                                $result_num_Base_PVC = mysqli_query($mysqli, $query_num_Base_PVC) or die(mysqli_query($mysqli));
                                $value_num_Base_PVC = mysqli_affected_rows($mysqli);
                                $query_deno_Base_PVC = "SELECT s212_nut FROM dsw_per_dispensed_rates WHERE month = '$value' AND program = '$prog' AND s212_nut != '' $year_sub";
                                $result_deno_Base_PVC = mysqli_query($mysqli, $query_deno_Base_PVC) or die(mysqli_query($mysqli));
                                $value_deno_Base_PVC = mysqli_affected_rows($mysqli);
                                if ($value_deno_Base_PVC != 0) {
                                    $Base_PVC = $value_num_Base_PVC / $value_deno_Base_PVC;
                                    $dispBase_PVC = round($Base_PVC * $nume_deno * $nume_weit);
                                }



                                if ($hardwareProb == 0 && $spot == 0) {
                                    echo "";
                                } else {
                                    echo $hardwareProb . "<br>" . $spot . "<br>" . $nume_weit . "<br>--<br>" . $dispCasing . "<br>" . $dispTank . "<br>" . $dispStickers . "<br>" . $dispBase_PVC;
                                }
                                ?>
                            </td> 

                            <?php
                        }
                        ?> 
                        <td>
                        </td>
                    </tr>
                    <tr></tr> <?php
                    $j--;
                }
                ?>
                <tr class="heading">
                    <th >Av./Month <b style="color:#3276B1; cursor:pointer; float: right;"> + </b></th>
                    <?php
                    for ($value = 1; $value < 13; ++$value) {
                        ?>
                        <td style="font-weight: bold;"><?php
                            $query = "SELECT $field2 FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$value' AND $field2 = '1' $year_sub";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $nume = mysqli_affected_rows($mysqli);

                            $query1 = "SELECT $field2 FROM dsw_per_dispensed_rates WHERE country='$country_val' AND month = '$value' AND $field2 != '' $year_sub";
                            $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                            $deno = mysqli_affected_rows($mysqli);
                            if ($deno == null) {
                                echo "";
                            } else {
                                $ans = round(($nume / $deno), 2);
                                $percent = $ans * 100;
                                echo $percent . "%";
                            }
                        }
                        ?></td>
                </tr> 
                <tr class="content">
                    <td>
                        HardwareProb_No<br>Spotcheck_No<br>Dispensers_No<br>--<br>Casing_padlock<br>Tank_valve<br>Stickers_barcode<br>Base_PVC_bolts_nuts                    
                    </td>
                    <?php
                    for ($value = 1; $value < 13; ++$value) {
                        ?>

                        <td> <?php
                            $query_hardwareProb = "SELECT program FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$value' AND s208_dispprob = '1' $year_sub";
                            $result_hardwareProb = mysqli_query($mysqli, $query_hardwareProb) or die(mysqli_query($mysqli));
                            $hardwareProb = mysqli_affected_rows($mysqli);

                            $query_spot = "SELECT program FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$value' $year_sub";
                            $result_spot = mysqli_query($mysqli, $query_spot) or die(mysqli_query($mysqli));
                            $spot = mysqli_affected_rows($mysqli);

                            $query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND country='$country_val' $year_sub ";
                            $result_weit = mysqli_query($mysqli, $query_weit) or die(mysqli_query($mysqli));
                            $row_weit = mysqli_fetch_assoc($result_weit);
                            $nume_weit_total = $row_weit["sum_total"];

                            $query = "SELECT $field2 FROM dsw_per_dispensed_rates WHERE month = '$value' AND country='$country_val' AND $field2 = '1' $year_sub";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $value_ = mysqli_affected_rows($mysqli);
                            $query1 = "SELECT $field2 FROM dsw_per_dispensed_rates WHERE month = '$value' AND country='$country_val' AND $field2 != '' $year_sub";
                            $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                            $value1 = mysqli_affected_rows($mysqli);
                            if ($value1 != 0) {
                                $nume_deno = $value_ / $value1;
                            }

                            $query_num_Casing = "SELECT s209_dispprob_cas_padlk FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$value' AND s209_dispprob_cas_padlk = '1' $year_sub";
                            $result_num_Casing = mysqli_query($mysqli, $query_num_Casing) or die(mysqli_query($mysqli));
                            $value_num_Casing = mysqli_affected_rows($mysqli);
                            $query_deno_Casing = "SELECT s209_dispprob_cas_padlk FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$value' AND s209_dispprob_cas_padlk != '' $year_sub";
                            $result_deno_Casing = mysqli_query($mysqli, $query_deno_Casing) or die(mysqli_query($mysqli));
                            $value_deno_Casing = mysqli_affected_rows($mysqli);
                            if ($value_deno_Casing != 0) {
                                $Casing = $value_num_Casing / $value_deno_Casing;
                                $dispCasing = round($Casing * $nume_deno * $nume_weit_total);
                            }

                            $query_num_Tank = "SELECT s210_dispprob_tnk_vlv FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$value' AND s210_dispprob_tnk_vlv = '1' $year_sub";
                            $result_num_Tank = mysqli_query($mysqli, $query_num_Tank) or die(mysqli_query($mysqli));
                            $value_num_Tank = mysqli_affected_rows($mysqli);
                            $query_deno_Tank = "SELECT s210_dispprob_tnk_vlv FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$value' AND s210_dispprob_tnk_vlv != '' $year_sub";
                            $result_deno_Tank = mysqli_query($mysqli, $query_deno_Tank) or die(mysqli_query($mysqli));
                            $value_deno_Tank = mysqli_affected_rows($mysqli);
                            if ($value_deno_Tank != 0) {
                                $Tank = $value_num_Tank / $value_deno_Tank;
                                $dispTank = round($Tank * $nume_deno * $nume_weit_total);
                            }

                            $query_num_Stickers = "SELECT s211_dispprob_stker_tag_paint FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$value' AND s211_dispprob_stker_tag_paint = '1' $year_sub";
                            $result_num_Stickers = mysqli_query($mysqli, $query_num_Stickers) or die(mysqli_query($mysqli));
                            $value_num_Stickers = mysqli_affected_rows($mysqli);
                            $query_deno_Stickers = "SELECT s211_dispprob_stker_tag_paint FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$value' AND s211_dispprob_stker_tag_paint != '' $year_sub";
                            $result_deno_Stickers = mysqli_query($mysqli, $query_deno_Stickers) or die(mysqli_query($mysqli));
                            $value_deno_Stickers = mysqli_affected_rows($mysqli);
                            if ($value_deno_Stickers != 0) {
                                $Stickers = $value_num_Stickers / $value_deno_Stickers;
                                $dispStickers = round($Stickers * $nume_deno * $nume_weit_total);
                            }

                            $query_num_Base_PVC = "SELECT s212_nut FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$value' AND s212_nut = '1' $year_sub";
                            $result_num_Base_PVC = mysqli_query($mysqli, $query_num_Base_PVC) or die(mysqli_query($mysqli));
                            $value_num_Base_PVC = mysqli_affected_rows($mysqli);
                            $query_deno_Base_PVC = "SELECT s212_nut FROM dsw_per_dispensed_rates WHERE country='$country_val' AND  month = '$value' AND s212_nut != '' $year_sub";
                            $result_deno_Base_PVC = mysqli_query($mysqli, $query_deno_Base_PVC) or die(mysqli_query($mysqli));
                            $value_deno_Base_PVC = mysqli_affected_rows($mysqli);
                            if ($value_deno_Base_PVC != 0) {
                                $Base_PVC = $value_num_Base_PVC / $value_deno_Base_PVC;
                                $dispBase_PVC = round($Base_PVC * $nume_deno * $nume_weit_total);
                            }


                            if ($spot == 0) {
                                echo "";
                            } else {
                                echo $hardwareProb . "<br>" . $spot . "<br>" . $nume_weit_total . "<br>--<br>" . $dispCasing . "<br>" . $dispTank . "<br>" . $dispStickers . "<br>" . $dispBase_PVC;
                            }
                            ?>
                        </td> 

                        <?php
                    }
                    ?> 
                    <td>
                    </td>
                </tr>
            </table>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery(".content").hide();
					//toggle the componenet with class msg_body
					jQuery(".heading").click(function()
					{
						jQuery(this).next(".content").slideToggle(400);
					});
				});
			</script>
<?php
		return;
	}
?>

			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery(".content").hide();
					//toggle the componenet with class msg_body
					jQuery(".heading").click(function() {
						jQuery(this).next(".content").slideToggle(400);
					});
				});
			</script>

<?php
		return;
?>