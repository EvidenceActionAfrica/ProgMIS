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
	$field = 'c803_tcr_reading';
	$field2 = 'c806_fcr_reading';
	
	if($_POST['info_type'] == 'tcr') {
		
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
                $res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' $year_sub ORDER BY program");
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
                            $query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '0' AND $field != '' $year_sub";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $nume = mysqli_affected_rows($mysqli);

                            $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                            $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                            $deno = mysqli_affected_rows($mysqli);

                            if ($deno == null) {
                                $query_res = "SELECT reason FROM `dsw_reason_table`  WHERE country='$country_val' AND table_name = 'dsw_per_adoption_rates' 
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
								if ($year == 2017 && ($value == 2 || $value == 4)) {
									$ans = round(($nume / $deno), 2);
									$percent = $ans * 100;
									?><i style="color:red"><?php
									echo $percent . "%";
									?></i>
								<?php
								} else {
									$ans = round(($nume / $deno), 2);
									$percent = $ans * 100;
									echo $percent . "%";
								}
                                ?>

                            </td> 

                            <?php
                        }
                    }
                    ?>
                    <th><?php
                        $query = "SELECT $field FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field != '0' AND $field != '' $year_sub";
                        $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                        $nume = mysqli_affected_rows($mysqli);

                        $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE program = '$prog' $year_sub";
                        $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                        $deno = mysqli_affected_rows($mysqli);
                        if ($deno == null) {
                            echo "";
                        } else {
                            $ans = round(($nume / $deno), 2);
                            $percent = $ans * 100;
                            echo $percent . "%";
                        }
                        ?></th>        
                    </tr>
                    <tr class="content">
                        <td>
                            Waterpoint No<br>
                            Household No                        
                        </td>
                        <?php
                        for ($value = 1; $value < 13; ++$value) {
                            ?>

                            <td> <?php
                                $query_w = "SELECT DISTINCT c102_wpt_id  FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                                $result_w = mysqli_query($mysqli, $query_w) or die(mysqli_query($mysqli));
                                $wpoint = mysqli_affected_rows($mysqli);

                                $query_h = "SELECT  c102_wpt_id  FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                                $result_h = mysqli_query($mysqli, $query_h) or die(mysqli_query($mysqli));
                                $hhold = mysqli_affected_rows($mysqli);
                                if ($hhold == 0) {
									echo "";
                                } else {
									if ($year == 2017 && ($value == 2 || $value == 4)) {
										?><i style="color:red"><?php
										echo $wpoint . "</br>";
										echo $hhold;
										?></i>
										<?php
									} else {
										echo $wpoint . "</br>";
										echo $hhold;
									}
                                }
                                ?>
                            </td> 

                            <?php
                        }
                        ?> 
                        <td> 
                        </td>
                    </tr>
                    <tr></tr>

                    <?php
                    $i++;
                }
                ?>

<!--                <tr>
                    <th>Av./Month</th>
                <?php
                if ($country_val == 1 && $year == 2014) {
                    ?>
                                                                                <th>56%</th><th>40%</th><th>44%</th><th>45%</th><th>38%</th><th>39%</th><th>42%</th><th>36%</th><th>33%</th><th>34%</th><th>47%</th><th>51%</th>
                    <?php
                } else if ($country_val == 2 && $year == 2014) {
                    ?>
                                                                                <th></th><th>52%</th><th></th><th></th><th>49%</th><th>33%</th><th>45%</th><th>33%</th><th></th><th>22%</th><th>	32%</th><th>27%</th>

                    <?php
                } else if ($country_val == 3 && $year == 2015) {
                    ?>
                                                                                <th>49%</th><th>90%</th>
                    <?php
                } else if ($country_val == 1 && $year == 2015) {
                    ?>
                                                                                <th>40%</th><th>40%</th>

                    <?php
                } else if ($country_val == 2 && $year == 2015) {
                    ?>
                                                                                <th>12%</th><th>22%</th>

                    <?php
                }
                ?>
                </tr>-->

                <tr class="heading"> 
                    <th>Av./Month <b style="color:#3276B1; cursor:pointer; float: right;"> + </b></th>
                    <?php
                    for ($value = 1; $value < 13; ++$value) {
                        ?>
                        <th>                             
                            <?php
                            $sumprod_a_n = 0;
                            $nume_weit_sum = 0;
                            $res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' $year_sub ORDER BY program");
                            while ($row = mysqli_fetch_assoc($res)) {
                                $prog = $row["program"];

                                $query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '0' AND $field != '' $year_sub";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $nume = mysqli_affected_rows($mysqli);

                                $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                                $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                $deno = mysqli_affected_rows($mysqli);

                                
                                if ($deno == null) {
                                    echo "";
                                } else {
									$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '$prog' $year_sub ";
									$result_weit = mysqli_query($mysqli, $query_weit) or die(mysqli_query($mysqli));
									$row_weit = mysqli_fetch_assoc($result_weit);
									$nume_weit = $row_weit["sum_total"];
									$nume_weit_sum += $nume_weit;

                                    $ans = $nume * 100 / $deno;
                                    $sumprod_a_n += $ans * $nume_weit;
                                }
                            }
                            if ($nume_weit_sum == null) {
                                echo "";
                            } else {
								if ($year == 2017 && ($value == 2 || $value == 4)) {
									?><i style="color:red"><?php
									echo round(($sumprod_a_n / $nume_weit_sum), 0) . "%";
									?></i>
									<?php
								} else {
									echo round(($sumprod_a_n / $nume_weit_sum), 0) . "%";
								}
                            }
                            ?>

                        </th>                         
                        <?php
                    }
                    ?>

                </tr>
                <tr class="content">
                    <td>
                        Waterpoint No<br>
                        Household No                        
                    </td>
                    <?php
                    for ($value = 1; $value < 13; ++$value) {
                        ?>
                        <td> <?php
                            $query_w = "SELECT DISTINCT c102_wpt_id  FROM dsw_per_adoption_rates WHERE country='$country_val' AND month = '$value' $year_sub";
                            $result_w = mysqli_query($mysqli, $query_w) or die(mysqli_query($mysqli));
                            $wpoint = mysqli_affected_rows($mysqli);

                            $query_h = "SELECT  c102_wpt_id  FROM dsw_per_adoption_rates WHERE country='$country_val' AND month = '$value' $year_sub";
                            $result_h = mysqli_query($mysqli, $query_h) or die(mysqli_query($mysqli));
                            $hhold = mysqli_affected_rows($mysqli);
                            if ($hhold == 0) {
                                echo "";
                            } else {
                                if ($year == 2017 && ($value == 2 || $value == 4)) {
										?><i style="color:red"><?php
										echo $wpoint . "</br>";
										echo $hhold;
										?></i>
										<?php
									} else {
										echo $wpoint . "</br>";
										echo $hhold;
								}
                            }
                            ?>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
			</table>
			<p class="text_foot">
				<?php if ($year == 2017) {
				?>
					<i style="color:red">
					<?php
						echo "Discrepancies in some of the highlighted figures (in red) can be attributed to a distinct variant in methodology applied by other reporting sources to render adoption numbers in the given period.";
					?>
					</i>
				<?php
					}
				?>
			</p>
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
		
	} else {
		
?>
		    <table class="table table-bordered table-striped table-hover">
                <tr >
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
                $res2 = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' $year_sub ORDER BY program");
                while ($row = mysqli_fetch_assoc($res2)) {
                    ?>
                    <tr class="heading"> <?php $prog = $row["program"]; ?>
                        <th><?php echo $prog; ?><b style="color:#3276B1; cursor:pointer; float: right;"> + </b></th> 
                        <?php
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
                            $query = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field2 != '0' AND $field2 != '' $year_sub";
                            $result = mysqli_query($mysqli, $query) or die("<h1>Cannot get num of " . $field2 . "</h1>" . mysqli_query($mysqli));
                            $nume = mysqli_affected_rows($mysqli);

                            $query1 = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                            $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                            $deno = mysqli_affected_rows($mysqli);
                            if ($deno == null) {
                                $query_res = "SELECT reason FROM `dsw_reason_table`  WHERE country='$country_val' AND table_name = 'dsw_per_adoption_rates' 
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
                                if ($year == 2017 && ($value == 2 || $value == 4)) {
									$ans = round(($nume / $deno), 2);
									$percent = $ans * 100;
									?><i style="color:red"><?php
									echo $percent . "%";
									?></i>
								<?php
								} else {
									$ans = round(($nume / $deno), 2);
									$percent = $ans * 100;
									echo $percent . "%";
								}
                                ?>
                            </td> 
                            <?php
                        }
                    }
                    ?>
                    <th><?php
                        $query = "SELECT $field2 FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field2 != '0' AND $field2 != '' $year_sub";
                        $result = mysqli_query($mysqli, $query) or die("<h1>Cannot get num of " . $field2 . "</h1>" . mysqli_query($mysqli));
                        $nume = mysqli_affected_rows($mysqli);

                        $query1 = "SELECT $field2 FROM dsw_per_adoption_rates WHERE program = '$prog' $year_sub";
                        $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                        $deno = mysqli_affected_rows($mysqli);
                        if ($deno == null) {
                            echo "";
                        } else {
                            $ans = round(($nume / $deno), 2);
                            $percent = $ans * 100;
                            echo $percent . "%";
                        }
                        ?></th>
                    </tr>
                    <tr class="content">
                        <td>
                            Waterpoint No<br>
                            Household No                       
                        </td>
                        <?php
                        for ($value = 1; $value < 13; ++$value) {
                            ?>

                            <td> <?php
                                $query_w = "SELECT DISTINCT c102_wpt_id  FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                                $result_w = mysqli_query($mysqli, $query_w) or die(mysqli_query($mysqli));
                                $wpoint = mysqli_affected_rows($mysqli);

                                $query_h = "SELECT  c102_wpt_id  FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                                $result_h = mysqli_query($mysqli, $query_h) or die(mysqli_query($mysqli));
                                $hhold = mysqli_affected_rows($mysqli);
                                if ($hhold == 0) {
                                    echo "";
                                } else {
                                    if ($year == 2017 && ($value == 2 || $value == 4)) {
										?><i style="color:red"><?php
										echo $wpoint . "</br>";
										echo $hhold;
										?></i>
										<?php
									} else {
										echo $wpoint . "</br>";
										echo $hhold;
									}
                                }
                                ?>
                            </td> 

                            <?php
                        }
                        ?> 
                        <td>
                        </td>
                    </tr>
                    <tr></tr>

                    <?php
                    $j--;
                }
                ?>                     
<!--                <tr>
                    <th>Av./Month</th>
                <?php
                if ($country_val == 1 && $year == 2014) {
                    ?>
                                                                                <th>42%</th><th>35%</th><th>32%</th><th>38%</th><th>33%</th><th>34%</th><th>28%</th><th>27%</th><th>22%</th><th>28%</th><th>39%</th><th>44%</th>
                    <?php
                } else if ($country_val == 2 && $year == 2014) {
                    ?>
                                                                                <th></th><th>38%</th><th></th><th></th><th>40%</th><th>22%</th><th>26%</th><th>25%</th><th></th><th>15%</th><th>24%</th><th>17%</th>
                    <?php
                } else if ($country_val == 3 && $year == 2015) {
                    ?>
                                                                                <th>32%</th><th>86%</th>

                    <?php
                } else if ($country_val == 1 && $year == 2015) {
                    ?>
                                                                                <th>35%</th><th>33%</th>

                    <?php
                } else if ($country_val == 2 && $year == 2015) {
                    ?>
                                                                                <th>2%</th><th>15%</th>

                    <?php
                }
                ?>                        
                </tr>-->

                <tr class ="heading"> 
                    <th>Av./Month <b style="color:#3276B1; cursor:pointer; float: right;"> + </b></th>
                    <?php
                    for ($value = 1; $value < 13; ++$value) {
                        ?>
                        <th>                             
                            <?php
                            $sumprod_a_n = 0;
                            $nume_weit_sum = 0;
                            $res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' $year_sub ORDER BY program");
                            while ($row = mysqli_fetch_assoc($res)) {
                                $prog = $row["program"];

                                $query = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field2 != '0' AND $field2 != '' $year_sub";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $nume = mysqli_affected_rows($mysqli);

                                $query1 = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                                $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                $deno = mysqli_affected_rows($mysqli);

                                
                                if ($deno == null) {
                                    echo "";
                                } else {
									$query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '$prog' $year_sub ";
									$result_weit = mysqli_query($mysqli, $query_weit) or die(mysqli_query($mysqli));
									$row_weit = mysqli_fetch_assoc($result_weit);
									$nume_weit = $row_weit["sum_total"];
									$nume_weit_sum += $nume_weit;

                                    $ans = $nume * 100 / $deno;
                                    $sumprod_a_n += $ans * $nume_weit;
                                }
                            }
                            if ($nume_weit_sum == null) {
                                echo "";
                            } else {
                                if ($year == 2017 && ($value == 2 || $value == 4)) {
									?><i style="color:red"><?php
									echo round(($sumprod_a_n / $nume_weit_sum), 0) . "%";
									?></i>
									<?php
								} else {
									echo round(($sumprod_a_n / $nume_weit_sum), 0) . "%";
								}
                            }
                            ?>

                        </th>                         
                        <?php
                    }
                    ?>
                </tr>
                <tr class="content">
                    <td>
                        Waterpoint No<br>
                        Household No                       
                    </td>
                    <?php
                    for ($value = 1; $value < 13; ++$value) {
                        ?>

                        <td> <?php
                            $query_w = "SELECT DISTINCT c102_wpt_id  FROM dsw_per_adoption_rates WHERE country='$country_val' AND month = '$value' $year_sub";
                            $result_w = mysqli_query($mysqli, $query_w) or die(mysqli_query($mysqli));
                            $wpoint = mysqli_affected_rows($mysqli);

                            $query_h = "SELECT  c102_wpt_id  FROM dsw_per_adoption_rates WHERE country='$country_val' AND month = '$value' $year_sub";
                            $result_h = mysqli_query($mysqli, $query_h) or die(mysqli_query($mysqli));
                            $hhold = mysqli_affected_rows($mysqli);
                            if ($hhold == 0) {
                                echo "";
                            } else {
                                if ($year == 2017 && ($value == 2 || $value == 4)) {
										?><i style="color:red"><?php
										echo $wpoint . "</br>";
										echo $hhold;
										?></i>
										<?php
									} else {
										echo $wpoint . "</br>";
										echo $hhold;
								}
                            }
                            ?>
                        </td> 

                        <?php
                    }
                    ?> 

                </tr>
            </table>
			<p class="text_foot">
				<?php if ($year == 2017) {
				?>
					<i style="color:red">
					<?php
						echo "Discrepancies in some of the highlighted figures (in red) can be attributed to a distinct variant in methodology applied by other reporting sources to render adoption numbers in the given period.";
					?>
					</i>
				<?php
					}
				?>
			</p>
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