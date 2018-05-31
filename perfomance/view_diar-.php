<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");
?>
<div class="row">

    <div class="col-md-2">

        <div class="sidebar">

            <?php require_once ('includes/left_bar.php'); ?>
        </div>
    </div>
    <div class="col-md-10">
        <?php
        $sql = "SELECT DISTINCT year FROM dsw_per_adoption_rates  WHERE country='$country_val' ORDER BY year DESC";
        $result = mysqli_query($mysqli, $sql);
        if (isset($_GET["submit_year"])) {
            $year = $_GET["year_select"];
        } else {

            $result_1 = mysqli_query($mysqli, $sql);
            $initial = mysqli_fetch_assoc($result_1);
            $year = $initial['year'];
        }
        ?>
        <form id="logform1"  method="$_GET" style='float: left'>  

            <select style="width:140px; height: 34px" name="year_select" id="year_select">
                <option value='All years'<?php if ($year == 'All years') echo 'selected'; ?> >All years</option>
                <?php
                while ($rows = mysqli_fetch_assoc($result)) { //loop table rows
                    ?>
                    <option value="<?php echo $rows['year']; ?>"<?php if ($year == $rows['year']) echo 'selected'; ?>>
                        <?php echo $rows['year']; ?></option>
                <?php } ?>
            </select>
            <input class="btn btn-primary" type="submit" name="submit_year" id="submit_year" value="CHOOSE YEAR">
            Last Updated 17 November 2017
        </form>
        <div class="btn-group pull-right">               
            <form method="POST" action="export/exp_diar.php">            
                <input type="hidden" name="rec_year" value="<?php echo $year; ?>" />
                <input type="hidden" name="rec_country" value="<?php echo $country_val; ?>" />
                <input class="btn btn-primary" type="submit" name="" value="Export CSV">
            </form>        
        </div>
        <br>
        <br>
        <br>
        <div class="table-responsive">
            <?php
            if ($year == 'All years') {
                $query_adop_header = "SELECT MIN(year), MAX(year) FROM dsw_per_adoption_rates  WHERE country='$country_val'";
                $result_adop_header = mysqli_query($mysqli, $query_adop_header) or die(mysql_error());
                $row_adop_header = mysqli_fetch_assoc($result_adop_header);
                $min_adop_year = $row_adop_header['MIN(year)'];
                $max_adop_year = $row_adop_header['MAX(year)'];
                $year_sub_min = "AND year ='$min_adop_year'";
                $year_sub_max = "AND year ='$max_adop_year'";
                $year_sub = "";
            } else {
                $year_sub_min = $year_sub_max = $year_sub = "AND year ='$year'";
                $max_adop_year = $min_adop_year = $year;
            }
            #################################################### first table  ###################################################       

            $query_adop_header1 = "SELECT MIN(month) FROM dsw_per_adoption_rates WHERE country='$country_val' $year_sub_min";
            $result_adop_header1 = mysqli_query($mysqli, $query_adop_header1) or die(mysql_error());
            $row_adop_header1 = mysqli_fetch_assoc($result_adop_header1);
            $min_adop_month = $row_adop_header1['MIN(month)'];
            $query_adop_header2 = "SELECT MAX(month) FROM dsw_per_adoption_rates WHERE country='$country_val' $year_sub_max";
            $result_adop_header2 = mysqli_query($mysqli, $query_adop_header2) or die(mysql_error());
            $row_adop_header2 = mysqli_fetch_assoc($result_adop_header2);
            $max_adop_month = $row_adop_header2['MAX(month)'];
            if (0 < $min_adop_month && $min_adop_month < 13) {
                $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                $disp_min_adop_month = $month_names[$min_adop_month];
            } else {
                $disp_min_adop_month = 'no month';
            }

            if (0 < $max_adop_month && $max_adop_month < 13) {
                $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                $disp_max_adop_month = $month_names[$max_adop_month];
            } else {
                $disp_max_adop_month = 'no month';
            }
            ?>

            <p class="text_title">The tables below provide self-reported data from the parents of children under the age of 5 indicating what 
                percentage of children experienced a case of diarrhea in the last 48 hours and the last 2 weeks respectively.
                Data is collected as a part of the community survey which is done at 8 random households from a random 
                selection of 1.5 out of every 100 waterpoints over 2 months. The data below reflect the data collected during 
                the period from <?php echo $disp_min_adop_month . ' ' . $min_adop_year; ?> to <?php echo $disp_max_adop_month . ' ' . $max_adop_year; ?></p>
            <h3>Diarrhea Rates last 48hours</h3>
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
                $res2 = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' $year_sub ORDER BY program");
                while ($row = mysqli_fetch_assoc($res2)) {
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
                            $field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
                                'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
                            $sum = 0;
                            foreach ($field_ar as $field) {
                                $query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field = '1' $year_sub";
                                $result = mysqli_query($mysqli, $query) or die(mysql_error());
                                $sum_row = mysqli_affected_rows($mysqli);

                                $sum += $sum_row;
                            }

                            $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                            $result_deno = mysqli_query($mysqli, $query_deno) or die(mysql_error());
                            $row_deno = mysqli_fetch_assoc($result_deno);
                            $deno = $row_deno['denominator'];

                            if ($deno == null) {
                                $query_res = "SELECT reason FROM `dsw_reason_table`  WHERE country='$country_val' AND table_name = 'dsw_per_adoption_rates' 
                                        AND column_value = '$value' AND row_value = '$prog' $year_sub";
                                $res_pop_up = mysqli_query($mysqli, $query_res) or die(mysqli_query($mysqli));
                                $row_ = mysqli_fetch_assoc($res_pop_up);
                                if (mysqli_affected_rows($mysqli) > 0 && $row_['reason'] != '0') {
                                    ?><div class="pop-up" id="pop-up<?php echo $i . $value; ?>"><?php
                                    echo $row_['reason'];
                                    ?></div><?php
                                } else {
                                    echo '';
                                }
                            } else {
                                $ans = round(($sum / $deno), 2);
                                $percent = $ans * 100;
                                echo $percent . "%";
                                ?>
                            </td> 
                            <?php
                        }
                    }
                    ?>
                    <th><?php
                        $field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
                            'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
                        $sum = 0;
                        foreach ($field_ar as $field) {
                            $query = "SELECT $field FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field = '1' $year_sub";
                            $result = mysqli_query($mysqli, $query) or die(mysql_error());
                            $sum_row = mysqli_affected_rows($mysqli);

                            $sum += $sum_row;
                        }
                        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE program = '$prog' $year_sub";
                        $result_deno = mysqli_query($mysqli, $query_deno) or die(mysql_error());
                        $row_deno = mysqli_fetch_assoc($result_deno);
                        $deno = $row_deno['denominator'];

                        if ($deno == null) {
                            echo "";
                        } else {
                            $ans = round(($sum / $deno), 2);
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
                                $result_w = mysqli_query($mysqli, $query_w) or die(mysql_error());
                                $wpoint = mysqli_affected_rows($mysqli);

                                $query_h = "SELECT  c102_wpt_id  FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub ";
                                $result_h = mysqli_query($mysqli, $query_h) or die(mysql_error());
                                $hhold = mysqli_affected_rows($mysqli);
                                if ($hhold == 0) {
                                    echo "";
                                } else {
                                    echo $wpoint . "</br>";
                                    echo $hhold;
                                }
                                ?>
                            </td> 

                            <?php
                        }
                        ?> 
                        <td> <?php
//                            $query_w_a = "SELECT DISTINCT c102_wpt_id  FROM dsw_per_adoption_rates WHERE program = '$prog' $year_sub";
//                            $result_w_a = mysqli_query($mysqli, $query_w_a) or die(mysql_error());
//                            $wpoint_a = mysqli_affected_rows($mysqli);
//
//                            $query_h_a = "SELECT  c102_wpt_id  FROM dsw_per_adoption_rates WHERE program = '$prog' $year_sub";
//                            $result_h_a = mysqli_query($mysqli, $query_h_a) or die(mysql_error());
//                            $hhold_a = mysqli_affected_rows($mysqli);
//                            if ($hhold_a == 0) {
//                                echo "";
//                            } else {
//                                echo $wpoint_a . "</br>";
//                                echo $hhold_a;
//                            }
                            ?>
                        </td>
                    </tr>
                    <tr></tr> <?php
                    $i++;
                }
                ?>


<!--                <tr>
                    <th>Av./Month</th>
                <?php
                if ($country_val == 1 && $year == 2014) {
                    ?>
                                            <th>6%</th><th>7%</th><th>4%</th><th>9%</th><th>4%</th><th>9%</th><th>8%</th><th>5%</th><th>7%</th><th>4%</th><th>7%</th><th>8%</th>
                    <?php
                } else if ($country_val == 2 && $year == 2014) {
                    ?>
                                            <th></th><th>5%</th><th></th><th></th><th>5%</th><th>6%</th><th>10%</th><th>5%</th><th></th><th>7%</th><th>9%</th><th>4%</th>

                    <?php
                } else if ($country_val == 3 && $year == 2015) {
                    ?>
                                            <th>3%</th><th>10%</th>
                    <?php
                } else if ($country_val == 1 && $year == 2015) {
                    ?>
                                            <th>8%</th><th>8%</th>

                    <?php
                } else if ($country_val == 2 && $year == 2015) {
                    ?>
                                            <th>8%</th><th>6%</th>

                    <?php
                }
                ?>
                </tr>-->


                <tr> 
                    <th>Av./Month</th>
                    <?php
                    for ($value = 1; $value < 13; ++$value) {
                        ?>
                        <th>                             
                            <?php
                            $sumprod_a_n = 0;
                            $nume_weit_sum = 0;
                            $res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' ORDER BY program");
                            while ($row = mysqli_fetch_assoc($res)) {
                                $prog = $row["program"];

                                $field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
                                    'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
                                $sum = 0;
                                foreach ($field_ar as $field) {
                                    $query = "SELECT $field FROM dsw_per_adoption_rates WHERE year = '$year' AND  month = '$value' AND program = '$prog' AND $field = '1'";
                                    $result = mysqli_query($mysqli, $query) or die(mysql_error());
                                    $sum_row = mysqli_affected_rows($mysqli);

                                    $sum += $sum_row;
                                }

                                $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE year = '$year' AND month = '$value' AND program = '$prog'";
                                $result_deno = mysqli_query($mysqli, $query_deno) or die(mysql_error());
                                $row_deno = mysqli_fetch_assoc($result_deno);
                                $deno = $row_deno['denominator'];

                                $query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '$prog' $year_sub ";
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
                                echo "";
                            } else {
                                echo round(($sumprod_a_n / $nume_weit_sum), 0) . "%";
                            }
                            ?>
                        </th>                         
                        <?php
                    }
                    ?>
                </tr>
            </table>
<!--            <p class="text_foot">* A 0% means that out of the evaluations done during a particular month a total percentage zero was observed, 
                a blank means that no evaluations were done for a program during a particular month.</p>-->
            <!--############################################ second table ####################################################-->
        </div><br>

        <div class="table-responsive">

            <h3>Diarrhea Rates Past 2 Weeks</h3>

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
                $res1 = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' $year_sub ORDER BY program");
                while ($row = mysqli_fetch_assoc($res1)) {
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
                            $field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
                                'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
                            $sum = 0;
                            foreach ($field_ar as $field) {
                                $query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field = '1' $year_sub";
                                $result = mysqli_query($mysqli, $query) or die(mysql_error());
                                $sum_row = mysqli_affected_rows($mysqli);

                                $sum += $sum_row;
                            }
                            $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                            $result_deno = mysqli_query($mysqli, $query_deno) or die(mysql_error());
                            $row_deno = mysqli_fetch_assoc($result_deno);
                            $deno = $row_deno['denominator'];

                            if ($deno == null) {
                                $query_res = "SELECT reason FROM `dsw_reason_table`  WHERE country='$country_val' AND table_name = 'dsw_per_adoption_rates' 
                                        AND column_value = '$value' AND row_value = '$prog' $year_sub";
                                $res_pop_up = mysqli_query($mysqli, $query_res) or die(mysqli_query($mysqli));
                                $row_ = mysqli_fetch_assoc($res_pop_up);
                                if (mysqli_affected_rows($mysqli) > 0 && $row_['reason'] != '0') {
                                    ?><div class="pop-up" id="pop-up<?php echo $j . $value; ?>"><?php
                                    echo $row_['reason'];
                                    ?></div><?php
                                } else {
                                    echo '';
                                }
                            } else {
                                $ans = round(($sum / $deno), 2);
                                $percent = $ans * 100;
                                echo $percent . "%";
                                ?>
                            </td> 
                            <?php
                        }
                    }
                    ?>
                    <th><?php
                        $field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
                            'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
                        $sum = 0;
                        foreach ($field_ar as $field) {
                            $query = "SELECT $field FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field = '1' $year_sub";
                            $result = mysqli_query($mysqli, $query) or die(mysql_error());
                            $sum_row = mysqli_affected_rows($mysqli);

                            $sum += $sum_row;
                        }
                        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE program = '$prog' $year_sub";
                        $result_deno = mysqli_query($mysqli, $query_deno) or die(mysql_error());
                        $row_deno = mysqli_fetch_assoc($result_deno);
                        $deno = $row_deno['denominator'];

                        if ($deno == null) {
                            echo "";
                        } else {
                            $ans = round(($sum / $deno), 2);
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
                                $result_w = mysqli_query($mysqli, $query_w) or die(mysql_error());
                                $wpoint = mysqli_affected_rows($mysqli);

                                $query_h = "SELECT  c102_wpt_id  FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                                $result_h = mysqli_query($mysqli, $query_h) or die(mysql_error());
                                $hhold = mysqli_affected_rows($mysqli);
                                if ($hhold == 0) {
                                    echo "";
                                } else {
                                    echo $wpoint . "</br>";
                                    echo $hhold;
                                }
                                ?>
                            </td> 

                            <?php
                        }
                        ?> 
                        <td> <?php
//                        $query_w_a = "SELECT DISTINCT c102_wpt_id  FROM dsw_per_adoption_rates WHERE program = '$prog' $year_sub";
//                        $result_w_a = mysqli_query($mysqli, $query_w_a) or die(mysql_error());
//                        $wpoint_a = mysqli_affected_rows($mysqli);
//
//                        $query_h_a = "SELECT  c102_wpt_id  FROM dsw_per_adoption_rates WHERE program = '$prog' $year_sub";
//                        $result_h_a = mysqli_query($mysqli, $query_h_a) or die(mysql_error());
//                        $hhold_a = mysqli_affected_rows($mysqli);
//                        if ($hhold_a == 0) {
//                        echo "";
//                        } else {
//                        echo $wpoint_a . "</br>";
//                        echo $hhold_a;
//                        }
                            ?>
                        </td>
                    </tr>
                    <tr></tr> <?php
                    $j--;
                }
                ?>

<!--                <tr>
                    <th>Av./Month</th>
                <?php
                if ($country_val == 1 && $year == 2014) {
                    ?>
                                            <th>9%</th><th>12%</th><th>8%</th><th>13%</th><th>10%</th><th>14%</th><th>15%</th><th>14%</th><th>11%</th><th>8%</th><th>11%</th><th>13%</th>
                    <?php
                } else if ($country_val == 2 && $year == 2014) {
                    ?>
                                            <th></th><th>7%</th><th></th><th></th><th>13%</th><th>10%</th><th>13%</th><th>9%</th><th></th><th>12%</th><th>15%</th><th>8%</th>

                    <?php
                } else if ($country_val == 3 && $year == 2015) {
                    ?>
                                            <th>1%</th><th>2%</th>
                    <?php
                } else if ($country_val == 1 && $year == 2015) {
                    ?>
                                            <th>11%</th><th>12%</th>

                    <?php
                } else if ($country_val == 2 && $year == 2015) {
                    ?>
                                            <th>12%</th><th>10%</th>

                    <?php
                }
                ?>
                </tr>-->


                <tr> 
                    <th>Av./Month</th>
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

                                $field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
                                    'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
                                $sum = 0;
                                foreach ($field_ar as $field) {
                                    $query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field = '1' $year_sub";
                                    $result = mysqli_query($mysqli, $query) or die(mysql_error());
                                    $sum_row = mysqli_affected_rows($mysqli);

                                    $sum += $sum_row;
                                }
                                $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' $year_sub";
                                $result_deno = mysqli_query($mysqli, $query_deno) or die(mysql_error());
                                $row_deno = mysqli_fetch_assoc($result_deno);
                                $deno = $row_deno['denominator'];

                                $query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '$prog' $year_sub ";
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
                                echo "";
                            } else {
                                echo round(($sumprod_a_n / $nume_weit_sum), 0) . "%";
                            }
                            ?>

                        </th>                         
                        <?php
                    }
                    ?>
                </tr>

            </table>            
<!--            <p class="text_foot">* A 0% means that out of the evaluations done during a particular month a total percentage zero was observed, 
                a blank means that no evaluations were done for a program during a particular month.</p>-->
        </div>

    </div>

</body>
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
</html>
<?php
mysqli_close($mysqli);
?>
