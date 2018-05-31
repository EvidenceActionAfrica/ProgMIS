<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");
$sql = "SELECT DISTINCT year FROM dsw_per_dispensed_rates  WHERE country='$country_val' ORDER BY year DESC";
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

    $table = "dsw_per_dispensed_rates";
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
    $insertFile->insertFile($filename, $table);
    //Connect as normal above
}
if (isset($_POST['clearbtn'])) {

    $table = "dsw_per_dispensed_rates";
    $query = "DELETE FROM $table WHERE country = '$country_val' AND YEAR = '$year' ";
    if (mysqli_query($mysqli, $query)) {
        $csvMessage = "Table Emptied, Browse File then Upload";
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

            <?php require_once ('includes/left_bar.php'); ?>
        </div>

    </div>

    <div class="col-md-10">

        <div class="clearfix"> 
            <a class="btn btn-primary" href="#importCSV"><span class="glyphicon glyphicon-download-alt" ></span> IMPORT CSV</a>
        Last Updated 23 August 2017</div></br>
        <form id="logform1"  method="$_GET" style='float: left'>  

            <select style="width:140px; height: 34px" name="year_select" id="year_select">
                <option value='All years'<?php if ($year == 'All years') echo 'selected'; ?> >All Year</option>
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
            <form method="POST" action="export/exp_disp.php">            
                <input type="hidden" name="rec_year" value="<?php echo $year; ?>" />
                <input type="hidden" name="rec_country" value="<?php echo $country_val; ?>" />
                <input class="btn btn-primary" type="submit" name="" value="Export CSV">
            </form>       
        </div>
        <br>
        <br>

        <div class="table-responsive">
            <?php
            isset($_GET["submit_year"]);

            $field = 's206_cl_dispensed';

            if ($year == 'All years') {
                $query_disp_header = "SELECT MIN(year), MAX(year) FROM dsw_per_dispensed_rates  WHERE country='$country_val'";
                $result_disp_header = mysqli_query($mysqli, $query_disp_header) or die(mysqli_query($mysqli));
                $row_disp_header = mysqli_fetch_assoc($result_disp_header);
                $min_disp_year = $row_disp_header['MIN(year)'];
                $max_disp_year = $row_disp_header['MAX(year)'];
                $year_sub_min = "AND year ='$min_disp_year'";
                $year_sub_max = "AND year ='$max_disp_year'";
                $year_sub = "";
            } else {
                $year_sub_min = $year_sub_max = $year_sub = "AND year ='$year'";
                $max_disp_year = $min_disp_year = $year;
            }
            ?>  

            <h3>Dispenser Functionality Rate</h3>
            <?php
            $query_disp_header1 = "SELECT MIN(month) FROM dsw_per_dispensed_rates WHERE country='$country_val' $year_sub_min";
            $result_disp_header1 = mysqli_query($mysqli, $query_disp_header1) or die(mysqli_query($mysqli));
            $row_disp_header1 = mysqli_fetch_assoc($result_disp_header1);
            $min_disp_month = $row_disp_header1['MIN(month)'];
            $query_disp_header2 = "SELECT MAX(month) FROM dsw_per_dispensed_rates WHERE country='$country_val' $year_sub_max";
            $result_disp_header2 = mysqli_query($mysqli, $query_disp_header2) or die(mysqli_query($mysqli));
            $row_disp_header2 = mysqli_fetch_assoc($result_disp_header2);
            $max_disp_month = $row_disp_header2['MAX(month)'];

            if (0 < $min_disp_month && $min_disp_month < 13) {
                $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                $disp_min_disp_month = $month_names[$min_disp_month];
            } else {
                $disp_min_disp_month = 'no month';
            }

            if (0 < $max_disp_month && $max_disp_month < 13) {
                $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                $disp_max_disp_month = $month_names[$max_disp_month];
            } else {
                $disp_max_disp_month = 'no month';
            }
            ?>
            <p class="text_title">Functionality is defined as a dispenser that will release a proper dose of chlorine (3ml) if the dispenser has chlorine in it. 
                Non-functional dispensers may experience valve problems, a missing or cracked tank, or a missing or vandalized dispensers.
                Dispensers that do not have chlorine but that do release chlorine after chlorine is added are considered “Functional”. 
                The table below provides the percentage of dispensers that were considered functional. Statistics are gathered from 
                regular Spot Check Forms that are completed by circuit riders on each trip that chlorine is delivered to the dispenser.
                The data below reflect the data collected during the period from <?php echo $disp_min_disp_month . ' ' . $min_disp_year; ?>
                to <?php echo $disp_max_disp_month . ' ' . $max_disp_year; ?></p>
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
            <!--<p class="text_foot">*Absence of data means that no functionality or hardware problem data exists for a program from 2014 - present year.</p>-->
            </br> 

            <!--########################################### Second Table ###############################################################--> 

            <h3>Hardware Problem</h3>
            <p class="text_title">Hardware problems include casing, tank, lid, and valve issues. 
                The table below provides the percentage of dispensers that were considered to have hardware problems. 
                The statistics do not include problems related to stickers and barcodes. Statistics are gathered from 
                regular Spot Check Forms that are completed by circuit riders on each trip that chlorine is delivered to the dispenser. 
                The data below reflect the data collected during the period from <?php echo $disp_min_disp_month . ' ' . $min_disp_year; ?>
                to <?php echo $disp_max_disp_month . ' ' . $max_disp_year; ?></p>
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
                $field2 = 's208_dispprob';
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
            <!--<p class="text_foot">*Absence of data means that no functionality or hardware problem data exists for a program from 2014 - present year.</p>-->

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
                                <input type="hidden" name="table_name" value="dispenser table">
                                <input type="submit" id='btnEmpty' name="clearbtn" value="Empty Table" class="btn-custom-small-normal"/>
                                <input type="submit" id='btnSubmit' name="uploadCSV" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>                                            
                            </div>
                            <div class="form-group">
                                <p><u>Note</u>: Before Upload, Empty the table by clicking on the above button</p>                                                           
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