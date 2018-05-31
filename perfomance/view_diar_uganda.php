<?php
include ('header.php');

// require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");

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
    }

    $filename = $image->upload_image($temp);
    $csvMessage = $insertFile->insertFile($filename, $table);
    //Connect as normal above
}
?>

<div class="row">

    <div class="col-md-2">

        <div class="sidebar">

            <?php require_once ('includes/left_bar.php'); ?>
        </div>

    </div>

    <div class="col-md-10">

<!--        <div class="clearfix"> 
            <a class="btn btn-primary" href="#importCSV"><span class="glyphicon glyphicon-download-alt" ></span> IMPORT CSV</a>
        </div></br>-->
        <?php
        $country_session = $_SESSION['countryName'];
        if ($country_session == 'Kenya') {
            $country_val = 1;
        } elseif ($country_session == 'Uganda') {
            $country_val = 2;
        } elseif ($country_session == 'Malawi') {
            $country_val = 3;
        }
        $sql = "SELECT DISTINCT year FROM dsw_per_adoption_rates  WHERE country='$country_val' ORDER BY year DESC";
        $result = mysql_query($sql);
        if (isset($_GET["submit_year"])) {
            $year = $_GET["year_select"];
        } else {
           
            $result_1 = mysql_query($sql);
            $initial = mysql_fetch_array($result_1);
            $year = $initial['year'];
        }
        ?>
        <form id="logform1"  method="$_GET" style='float: left'>  

            <select style="width:140px; height: 34px" name="year_select" id="year_select">
                <option value='All years'<?php if ($year == 'All years') echo 'selected'; ?> >All years</option>
                <?php
                while ($rows = mysql_fetch_array($result)) { //loop table rows
                    ?>
                    <option value="<?php echo $rows['year']; ?>"<?php if ($year == $rows['year']) echo 'selected'; ?>>
                        <?php echo $rows['year']; ?></option>
                <?php } ?>
            </select>
            <input class="btn btn-primary" type="submit" name="submit_year" id="submit_year" value="CHOOSE YEAR">
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
            isset($_GET["submit_year"]);
            if ($year == 'All years') {               
                
                $query_adop_header = "SELECT MIN(year), MAX(year) FROM dsw_per_adoption_rates  WHERE country='$country_val'";
                            $result_adop_header = mysql_query($query_adop_header) or die(mysql_error());
                            $row_adop_header = mysql_fetch_array($result_adop_header);
                            $min_adop_year = $row_adop_header['MIN(year)'];
                            $max_adop_year = $row_adop_header['MAX(year)'];
                            $query_adop_header1 = "SELECT MIN(month) FROM dsw_per_adoption_rates WHERE year ='$min_adop_year'";
                            $result_adop_header1 = mysql_query($query_adop_header1) or die(mysql_error());
                            $row_adop_header1 = mysql_fetch_array($result_adop_header1);
                            $min_adop_month = $row_adop_header1['MIN(month)'];
                            $query_adop_header2 = "SELECT MAX(month) FROM dsw_per_adoption_rates WHERE year ='$max_adop_year'";
                            $result_adop_header2 = mysql_query($query_adop_header2) or die(mysql_error());
                            $row_adop_header2 = mysql_fetch_array($result_adop_header2);
                            $max_adop_month = $row_adop_header2['MAX(month)'];
                            if ($min_adop_month == '')  $disp_min_adop_month='No Month';
                            if ($min_adop_month == '0')  $disp_min_adop_month='0 Month';
                            if ($min_adop_month == '1')  $disp_min_adop_month='Jan';
                            if ($min_adop_month == '2')  $disp_min_adop_month='Feb';
                            if ($min_adop_month == '3')  $disp_min_adop_month='Mar';
                            if ($min_adop_month == '4')  $disp_min_adop_month='Apr';
                            if ($min_adop_month == '5')  $disp_min_adop_month='May';
                            if ($min_adop_month == '6')  $disp_min_adop_month='Jun';
                            if ($min_adop_month == '7')  $disp_min_adop_month='Jul';
                            if ($min_adop_month == '8')  $disp_min_adop_month='Aug';
                            if ($min_adop_month == '9')  $disp_min_adop_month='Sep';
                            if ($min_adop_month == '10')  $disp_min_adop_month='Oct';
                            if ($min_adop_month == '11')  $disp_min_adop_month='Nov';
                            if ($min_adop_month == '12')  $disp_min_adop_month='Dec';
                            if ($min_adop_month > '12')  $disp_min_adop_month='No Month';

                            if ($max_adop_month == '')  $disp_max_adop_month='No Month';
                            if ($max_adop_month == '0')  $disp_max_adop_month='0 Month';
                            if ($max_adop_month == '1')  $disp_max_adop_month='Jan';
                            if ($max_adop_month == '2')  $disp_max_adop_month='Feb';
                            if ($max_adop_month == '3')  $disp_max_adop_month='Mar';
                            if ($max_adop_month == '4')  $disp_max_adop_month='Apr';
                            if ($max_adop_month == '5')  $disp_max_adop_month='May';
                            if ($max_adop_month == '6')  $disp_max_adop_month='Jun';
                            if ($max_adop_month == '7')  $disp_max_adop_month='Jul';
                            if ($max_adop_month == '8')  $disp_max_adop_month='Aug';
                            if ($max_adop_month == '9')  $disp_max_adop_month='Sep';
                            if ($max_adop_month == '10')  $disp_max_adop_month='Oct';
                            if ($max_adop_month == '11')  $disp_max_adop_month='Nov';
                            if ($max_adop_month == '12')  $disp_max_adop_month='Dec';
                            if ($max_adop_month > '12')  $disp_max_adop_month='No Month';?>
               
                <p class="text_title">The tables below provide self-reported data from the parents of children under the age of 5 indicating what 
                    percentage of children experienced a case of diarrhea in the last 24 hours and the last 2 weeks respectively.
                    Data is collected as a part of the community survey which is done at 8 random households from a random 
                    selection of 1 out of every 100 dispensers per month. The data below reflect the data collected during 
                    the period from <?php echo $disp_min_adop_month.' '.$min_adop_year;?> to <?php echo $disp_max_adop_month.' '.$max_adop_year;?></p>
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
                    $res2 = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' ORDER BY program");
                    while ($row = mysql_fetch_array($res2)) {
                        ?>
                        <tr> <?php $prog = $row["program"]; ?>
                            <th><?php echo $prog; ?></th> 
                            <?php                            
                            for ($value = 1; $value < 13; ++$value) {
                                ?>
                                <td> <?php
                                    $field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
                                        'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
                                    $sum = 0;
                                    foreach ($field_ar as $field) {
                                        $query = "SELECT $field FROM dsw_per_adoption_rates WHERE  month = '$value' AND program = '$prog' AND $field = '1'";
                                        $result = mysql_query($query) or die(mysql_error());
                                        $sum_row = mysql_num_rows($result);

                                        $sum += $sum_row;
                                    }

                                    $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog'";
                                    $result_deno = mysql_query($query_deno) or die(mysql_error());
                                    $row_deno = mysql_fetch_assoc($result_deno);
                                    $deno = $row_deno['denominator'];

                                    if ($deno == null) {
                                        echo "";
                                    } else {
                                        $ans = round(($sum / $deno), 6);
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
                                        $query = "SELECT $field FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field = '1'";
                                        $result = mysql_query($query) or die(mysql_error());
                                        $sum_row = mysql_num_rows($result);

                                        $sum += $sum_row;
                                    }

                                    $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE program = '$prog'";
                                    $result_deno = mysql_query($query_deno) or die(mysql_error());
                                    $row_deno = mysql_fetch_assoc($result_deno);
                                    $deno = $row_deno['denominator'];

                                    if ($deno == null) {
                                        echo "";
                                    } else {
                                        $ans = round(($sum / $deno), 6);
                                        $percent = $ans * 100;
                                        echo $percent . "%";
                                    }
                                ?></th>
                        </tr> <?php } ?>

                </table>

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
                    $res1 = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' ORDER BY program");
                    while ($row = mysql_fetch_array($res1)) {
                        ?>
                        <tr> <?php $prog = $row["program"]; ?>
                            <th><?php echo $prog; ?></th> 
                            <?php                            
                            for ($value = 1; $value < 13; ++$value) {
                                ?>
                                <td> <?php
                                    $field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
                                        'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
                                    $sum = 0;
                                    foreach ($field_ar as $field) {
                                        $query = "SELECT $field FROM dsw_per_adoption_rates WHERE  month = '$value' AND program = '$prog' AND $field = '1'";
                                        $result = mysql_query($query) or die(mysql_error());
                                        $sum_row = mysql_num_rows($result);

                                        $sum += $sum_row;
                                    }
                                    $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog'";
                                    $result_deno = mysql_query($query_deno) or die(mysql_error());
                                    $row_deno = mysql_fetch_assoc($result_deno);
                                    $deno = $row_deno['denominator'];

                                    if ($deno == null) {
                                        echo "";
                                    } else {
                                        $ans = round(($sum / $deno), 6);
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
                                        $query = "SELECT $field FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field = '1'";
                                        $result = mysql_query($query) or die(mysql_error());
                                        $sum_row = mysql_num_rows($result);

                                        $sum += $sum_row;
                                    }
                                    $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE  program = '$prog'";
                                    $result_deno = mysql_query($query_deno) or die(mysql_error());
                                    $row_deno = mysql_fetch_assoc($result_deno);
                                    $deno = $row_deno['denominator'];

                                    if ($deno == null) {
                                        echo "";
                                    } else {
                                        $ans = round(($sum / $deno), 6);
                                        $percent = $ans * 100;
                                        echo $percent . "%";
                                    }
                                ?></th>
                        </tr>
                        </tr> <?php } ?>

                </table>

            </div>
        <?php } 
        
        
        else {
                
                            $query_adop_header1 = "SELECT MIN(month) FROM dsw_per_adoption_rates WHERE year ='$year' AND country='$country_val'";
                            $result_adop_header1 = mysql_query($query_adop_header1) or die(mysql_error());
                            $row_adop_header1 = mysql_fetch_array($result_adop_header1);
                            $min_adop_month = $row_adop_header1['MIN(month)'];
                            $query_adop_header2 = "SELECT MAX(month) FROM dsw_per_adoption_rates WHERE year ='$year' AND country='$country_val'";
                            $result_adop_header2 = mysql_query($query_adop_header2) or die(mysql_error());
                            $row_adop_header2 = mysql_fetch_array($result_adop_header2);
                            $max_adop_month = $row_adop_header2['MAX(month)'];
                            if ($min_adop_month == '')  $disp_min_adop_month='No Month';
                            if ($min_adop_month == '0')  $disp_min_adop_month='0 Month';
                            if ($min_adop_month == '1')  $disp_min_adop_month='Jan';
                            if ($min_adop_month == '2')  $disp_min_adop_month='Feb';
                            if ($min_adop_month == '3')  $disp_min_adop_month='Mar';
                            if ($min_adop_month == '4')  $disp_min_adop_month='Apr';
                            if ($min_adop_month == '5')  $disp_min_adop_month='May';
                            if ($min_adop_month == '6')  $disp_min_adop_month='Jun';
                            if ($min_adop_month == '7')  $disp_min_adop_month='Jul';
                            if ($min_adop_month == '8')  $disp_min_adop_month='Aug';
                            if ($min_adop_month == '9')  $disp_min_adop_month='Sep';
                            if ($min_adop_month == '10')  $disp_min_adop_month='Oct';
                            if ($min_adop_month == '11')  $disp_min_adop_month='Nov';
                            if ($min_adop_month == '12')  $disp_min_adop_month='Dec';
                            if ($min_adop_month > '12')  $disp_min_adop_month='No Month';

                            if ($max_adop_month == '')  $disp_max_adop_month='No Month';
                            if ($max_adop_month == '0')  $disp_max_adop_month='0 Month';
                            if ($max_adop_month == '1')  $disp_max_adop_month='Jan';
                            if ($max_adop_month == '2')  $disp_max_adop_month='Feb';
                            if ($max_adop_month == '3')  $disp_max_adop_month='Mar';
                            if ($max_adop_month == '4')  $disp_max_adop_month='Apr';
                            if ($max_adop_month == '5')  $disp_max_adop_month='May';
                            if ($max_adop_month == '6')  $disp_max_adop_month='Jun';
                            if ($max_adop_month == '7')  $disp_max_adop_month='Jul';
                            if ($max_adop_month == '8')  $disp_max_adop_month='Aug';
                            if ($max_adop_month == '9')  $disp_max_adop_month='Sep';
                            if ($max_adop_month == '10')  $disp_max_adop_month='Oct';
                            if ($max_adop_month == '11')  $disp_max_adop_month='Nov';
                            if ($max_adop_month == '12')  $disp_max_adop_month='Dec';
                            if ($max_adop_month > '12')  $disp_max_adop_month='No Month';?>
               
                <p class="text_title">The tables below provide self-reported data from the parents of children under the age of 5 indicating what 
                    percentage of children experienced a case of diarrhea in the last 24 hours and the last 2 weeks respectively.
                    Data is collected as a part of the community survey which is done at 8 random households from a random 
                    selection of 1 out of every 100 dispensers per month. The data below reflect the data collected during 
                    the period from <?php echo $disp_min_adop_month.' '.$year;?> to <?php echo $disp_max_adop_month.' '.$year;?></p>
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
                    $res2 = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' ORDER BY program");
                    while ($row = mysql_fetch_array($res2)) {
                        ?>
                        <tr> <?php $prog = $row["program"]; ?>
                            <th><?php echo $prog; ?></th> 
                            <?php                            
                            for ($value = 1; $value < 13; ++$value) {
                                ?>
                                <td> <?php
                                    $field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
                                        'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
                                    $sum = 0;
                                    foreach ($field_ar as $field) {
                                        $query = "SELECT $field FROM dsw_per_adoption_rates WHERE year = '$year' AND  month = '$value' AND program = '$prog' AND $field = '1'";
                                        $result = mysql_query($query) or die(mysql_error());
                                        $sum_row = mysql_num_rows($result);

                                        $sum += $sum_row;
                                    }

                                    $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE year = '$year' AND month = '$value' AND program = '$prog'";
                                    $result_deno = mysql_query($query_deno) or die(mysql_error());
                                    $row_deno = mysql_fetch_assoc($result_deno);
                                    $deno = $row_deno['denominator'];

                                    if ($deno == null) {
                                        echo "";
                                    } else {
                                        $ans = round(($sum / $deno), 6);
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
                                        $query = "SELECT $field FROM dsw_per_adoption_rates WHERE year = '$year' AND program = '$prog' AND $field = '1'";
                                        $result = mysql_query($query) or die(mysql_error());
                                        $sum_row = mysql_num_rows($result);

                                        $sum += $sum_row;
                                    }

                                    $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE year = '$year' AND program = '$prog'";
                                    $result_deno = mysql_query($query_deno) or die(mysql_error());
                                    $row_deno = mysql_fetch_assoc($result_deno);
                                    $deno = $row_deno['denominator'];

                                    if ($deno == null) {
                                        echo "";
                                    } else {
                                        $ans = round(($sum / $deno), 6);
                                        $percent = $ans * 100;
                                        echo $percent . "%";
                                    }
                                ?></th>
                        </tr> <?php } ?>

                </table>

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
                    $res1 = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' ORDER BY program");
                    while ($row = mysql_fetch_array($res1)) {
                        ?>
                        <tr> <?php $prog = $row["program"]; ?>
                            <th><?php echo $prog; ?></th> 
                            <?php                           
                            for ($value = 1; $value < 13; ++$value) {
                                ?>
                                <td> <?php
                                    $field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
                                        'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
                                    $sum = 0;
                                    foreach ($field_ar as $field) {
                                        $query = "SELECT $field FROM dsw_per_adoption_rates WHERE year = '$year' AND  month = '$value' AND program = '$prog' AND $field = '1'";
                                        $result = mysql_query($query) or die(mysql_error());
                                        $sum_row = mysql_num_rows($result);

                                        $sum += $sum_row;
                                    }
                                    $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE year = '$year' AND month = '$value' AND program = '$prog'";
                                    $result_deno = mysql_query($query_deno) or die(mysql_error());
                                    $row_deno = mysql_fetch_assoc($result_deno);
                                    $deno = $row_deno['denominator'];

                                    if ($deno == null) {
                                        echo "";
                                    } else {
                                        $ans = round(($sum / $deno), 6);
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
                                        $query = "SELECT $field FROM dsw_per_adoption_rates WHERE year = '$year' AND program = '$prog' AND $field = '1'";
                                        $result = mysql_query($query) or die(mysql_error());
                                        $sum_row = mysql_num_rows($result);

                                        $sum += $sum_row;
                                    }
                                    $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE year = '$year' AND program = '$prog'";
                                    $result_deno = mysql_query($query_deno) or die(mysql_error());
                                    $row_deno = mysql_fetch_assoc($result_deno);
                                    $deno = $row_deno['denominator'];

                                    if ($deno == null) {
                                        echo "";
                                    } else {
                                        $ans = round(($sum / $deno), 6);
                                        $percent = $ans * 100;
                                        echo $percent . "%";
                                    }
                                ?></th>
                        </tr>
                        </tr> <?php } ?>

                </table>

            </div>
            
             <?php
                }
                ?> 
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
                                <input type="submit" id='btnSubmit' name="uploadCSV" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>                                            
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

</div>

</body>

</html>       