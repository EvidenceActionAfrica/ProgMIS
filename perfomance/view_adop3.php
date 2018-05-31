<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");
$sql = "SELECT DISTINCT year FROM dsw_per_adoption_rates  WHERE country='$country_val' ORDER BY year DESC";
$result = mysqli_query($mysqli, $sql);
if (isset($_GET["submit_year"])) {
    $year = $_GET["year_select"];
} else {
    $result_1 = mysqli_query($mysqli, $sql);
    $initial = mysqli_fetch_assoc($result_1);
    $year = $initial['year'];
}
$image = new image;
$insertFile = new UploadFIle;

if (isset($_POST['uploadCSV'])) {

    $table = "dsw_per_adoption_rates";
    if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
        $csvMessage = "Upload Failed";
    } else {

        $temp = $_FILES["file"]["tmp_name"];
        $csvMessage = "Upload Successful";
        $table_name = $_POST['table_name'];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = $table_name . ' imported';
        $description = 'No description';
        $sql_add = "INSERT INTO performance_log_record (country, user_name, email, action, description) 
                        VALUES ( '$country_val', '$user_name', '$email', '$action', '$description')";
        mysqli_query($mysqli, $sql_add) or die(mysqli_query($mysqli));
    }

    $filename = $image->upload_image($temp);
    $csvMessage = $insertFile->insertFile($filename, $table, 'view_adop.php');

//Connect as normal above
}
if (isset($_POST['clearbtn'])) {

    $table = "dsw_per_adoption_rates";
    $query = "DELETE FROM $table WHERE country = '$country_val' AND YEAR = '$year' ";
    if (mysqli_query($mysqli, $query)) {
        $csvMessage = "Data for year " . $year . ", Deleted Browse File then Upload";
        $table_name = $_POST['table_name'];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = $table_name . ' emptied';
        $description = 'year ' . $year . ' records deleted';
        $sql_add = "INSERT INTO performance_log_record (country, user_name, email, action, description) 
                        VALUES ( '$country_val', '$user_name', '$email', '$action', '$description')";
        mysqli_query($mysqli, $sql_add) or die(mysqli_query($mysqli));
    } else {
        $csvMessage = "fail";
    }
}
?>

<div class="row">
    <div class="col-md-2">

        <div class="sidebar">

            <?php require_once ('includes/left_bar--.php'); ?>
        </div>

    </div>
    <div class="col-md-10">

        <div class="clearfix"> 
            <a class="btn btn-primary" href="#importCSV"><span class="glyphicon glyphicon-download-alt" ></span> IMPORT CSV Adop&Diar</a>
        Last Updated 30 August 2017</div></br>        
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
        </form>
        <div class="btn-group pull-right">
            <form method="POST" action="export/exp_adop.php">            
                <input type="hidden" name="rec_year" value="<?php echo $year; ?>" />
                <input type="hidden" name="rec_country" value="<?php echo $country_val; ?>" />
                <input class="btn btn-primary" type="submit" name="" value="Export CSV">
            </form>
        </div>
        <br>
        <br>
        <!--################################################## First Table ######################################################################-->
        <div class="table-responsive">
            <?php
            $field = 'c803_tcr_reading';
            $field2 = 'c806_fcr_reading';
            if ($year == 'All years') {
                $query_adop_header = "SELECT MIN(year), MAX(year) FROM dsw_per_adoption_rates  WHERE country='$country_val'";
                $result_adop_header = mysqli_query($mysqli, $query_adop_header) or die(mysqli_query($mysqli));
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
            ?>

            <h3>TCR Adoption (Total Chlorine Adoption)</h3>
            <?php
            $query_ob = "SELECT * FROM dsw_per_adoption_rates  WHERE country='$country_val' $year_sub";
            $result_ob = mysqli_query($mysqli, $query_ob) or die(mysqli_query($mysqli));
            $obser = mysqli_affected_rows($mysqli);
            $query_adop_header1 = "SELECT MIN(month) FROM dsw_per_adoption_rates WHERE country='$country_val' $year_sub_min";
            $result_adop_header1 = mysqli_query($mysqli, $query_adop_header1) or die(mysqli_query($mysqli));
            $row_adop_header1 = mysqli_fetch_assoc($result_adop_header1);
            $min_adop_month = $row_adop_header1['MIN(month)'];
            $query_adop_header2 = "SELECT MAX(month) FROM dsw_per_adoption_rates WHERE country='$country_val' $year_sub_max";
            $result_adop_header2 = mysqli_query($mysqli, $query_adop_header2) or die(mysqli_query($mysqli));
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
            <p class="text_title"> The table below provides an overview of the percentage of randomly sampled households that tested positive for Total Chlorine
                Residual in their drinking water during an unannounced visit. 1.5% of all dispensers are evaluated bi-monthly. 
                For the first three months of evaluation in a new region, 2% of all dispensers are monitored. 
                A random selection of 8 households are interviewed at each dispenser. The table below includes
                a total of <?php echo $obser; ?> observations for the period from <?php echo $disp_min_adop_month . ' ' . $min_adop_year; ?> to 
                <?php echo $disp_max_adop_month . ' ' . $max_adop_year; ?></p>
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

                            $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '' $year_sub";
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

                                $ans = round(($nume / $deno), 2);
                                $percent = $ans * 100;
                                echo $percent . "%";
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

                        $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field != '' $year_sub";
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
                                    echo $wpoint . "</br>";
                                    echo $hhold;
                                }
                                ?>
                            </td> 

                            <?php
                        }
                        ?> 
                        <td> <?php
//                                $query_w_a = "SELECT DISTINCT c102_wpt_id  FROM dsw_per_adoption_rates WHERE program = '$prog' $year_sub";
//                                $result_w_a = mysqli_query($mysqli, $query_w_a) or die(mysqli_query($mysqli));
//                                $wpoint_a = mysqli_affected_rows($mysqli);
//
//                                $query_h_a = "SELECT  c102_wpt_id  FROM dsw_per_adoption_rates WHERE program = '$prog' $year_sub";
//                                $result_h_a = mysqli_query($mysqli, $query_h_a) or die(mysqli_query($mysqli));
//                                $hhold_a = mysqli_affected_rows($mysqli);
//                                if ($hhold_a == 0) {
//                                    echo "";
//                                } else {
//                                    echo $wpoint_a . "</br>";
//                                    echo $hhold_a;
//                                }
                            ?>
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

                                $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '' $year_sub";
                                $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                $deno = mysqli_affected_rows($mysqli);

                                $query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '$prog' $year_sub ";
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
                                echo $wpoint . "</br>";
                                echo $hhold;
                            }
                            ?>
                        </td>
                        <?php
                    }
                    ?>
                </tr>



            </table>
            <p class="text_foot">* Hover your mouse over blank cells for more information on missing numbers</p>
            <p class="text_foot">**The table reflects main offices and their respective adoption rates and not installation rounds</p>
 	    <p class="text_foot">***No evaluations were done in October 2016</p>
      <!--            <p class="text_foot">* A 0% means that out of the evaluations done during a particular month a total percentage zero was observed, 
                 a blank means that no evaluations were done for a program during a particular month.</p>-->
            </br>
            <!--################################################## Second Table ######################################################################-->
            <h3>FCR Adoption (Free Chlorine Adoption)</h3>
            <p class="text_title"> This table provides an overview of the percentage of randomly sampled households that tested positive for 
                Free Chlorine Residual in their drinking water during an unannounced visit. 1.5% of all dispensers are evaluated every month.
                For the first three months of evaluation in a new region, 2% of all dispensers are monitored. 
                A random selection of 8 households are interviewed at each dispenser. 
                The table below includes a total of <?php echo $obser; ?> observations for the period from 
                <?php echo $disp_min_adop_month . ' ' . $year; ?> to <?php echo $disp_max_adop_month . ' ' . $year; ?></p>
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

                            $query1 = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '' $year_sub";
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
                                $ans = round(($nume / $deno), 2);
                                $percent = $ans * 100;
                                echo $percent . "%";
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

                        $query1 = "SELECT $field2 FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field != '' $year_sub";
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
                                    echo $wpoint . "</br>";
                                    echo $hhold;
                                }
                                ?>
                            </td> 

                            <?php
                        }
                        ?> 
                        <td> <?php
//                                $query_w_a = "SELECT DISTINCT c102_wpt_id  FROM dsw_per_adoption_rates WHERE year = '$year' AND program = '$prog' ";
//                                $result_w_a = mysqli_query($mysqli, $query_w_a) or die(mysqli_query($mysqli));
//                                $wpoint_a = mysqli_affected_rows($mysqli);
//
//                                $query_h_a = "SELECT  c102_wpt_id  FROM dsw_per_adoption_rates WHERE year = '$year' AND program = '$prog' ";
//                                $result_h_a = mysqli_query($mysqli, $query_h_a) or die(mysqli_query($mysqli));
//                                $hhold_a = mysqli_affected_rows($mysqli);
//                                if ($hhold_a == 0) {
//                                    echo "";
//                                } else {
//                                    echo $wpoint_a . "</br>";
//                                    echo $hhold_a;
//                                }
                            ?>
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

                                $query1 = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '' $year_sub";
                                $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                $deno = mysqli_affected_rows($mysqli);

                                $query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '$prog' $year_sub ";
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
                                echo $wpoint . "</br>";
                                echo $hhold;
                            }
                            ?>
                        </td> 

                        <?php
                    }
                    ?> 

                </tr>
            </table>
            <p class="text_foot">* Hover your mouse over blank cells for more information on missing numbers</p>
            <p class="text_foot">**The table reflects main offices and their respective adoption rates and not installation rounds</p>
          <!--            <p class="text_foot">* A 0% means that out of the evaluations done during a particular month a total percentage zero was observed, 
                a blank means that no evaluations were done for a program during a particular month.</p>-->
        </div>   

        <!--#####################################################################-->

        <div id="importCSV" class="modalDialog">
            <div style="width:380px">
                <?php
                if (isset($csvMessage)) {
                    echo '<h4 style="color:#050000;background-color:#A2FF7E;text-align:center;">' . $csvMessage . '</h4>';
                }
                ?>
                <center>
                    <h4 class="">Upload Document</h4>
                    <div style="padding: 5px; margin: 0px auto">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="file">Filename:</label>
                                <input type="file" name="file" id="file" class="form-control"/>                                     
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="table_name" value="adoption table">
                                <input type="submit" id='btnEmpty' name="clearbtn" value="Empty Table" class="btn-custom-small-normal"/>                                
                                <input type="submit" id='btnSubmit' name="uploadCSV" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>                                            
                            </div>
                            <div class="form-group">
                                <u>Note</u>: 
                                <li style="text-align: left;">Before Upload, Empty the table by clicking on the (Empty Table) button.
                                <li style="text-align: left;">The document to upload should be  a CSV only.
                                <li style="text-align: left;">The structure of the CSV should be followed as suggested.
                            </div>
                        </form>
                    </div>
                </center>
                <br/>
                <center>
                    <div>
                        <a href="#close" class="" > Close</a>
                    </div>
                </center>
            </div>
        </div>       
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