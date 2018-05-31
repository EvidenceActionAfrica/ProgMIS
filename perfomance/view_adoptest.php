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
if (isset($_POST['clearbtn'])) {

    $table = "dsw_per_adoption_rates";
    $query = "truncate table $table";
    if (mysql_query($query)) {
        $csvMessage = "Table Emptied, Browse File then Upload";
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
            <a class="btn btn-primary" href="#importCSV"><span class="glyphicon glyphicon-download-alt" ></span> IMPORT CSV Adop&Diar</a>
        </div></br>
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
            <form method="POST" action="export/exp_adop.php">            
                <input type="hidden" name="rec_year" value="<?php echo $year; ?>" />
                <input type="hidden" name="rec_country" value="<?php echo $country_val; ?>" />
                <input class="btn btn-primary" type="submit" name="" value="Export CSV">
            </form>
        </div>
        <br>
        <br>

        <div class="table-responsive">
            <?php
            $field = 'c803_tcr_reading';
            $field2 = 'c806_fcr_reading';
            if ($year == 'All years') {
                ?>

                <h3>TCR Adoption (Total Chlorine Adoption)</h3>
                <?php
                $query_ob = "SELECT * FROM dsw_per_adoption_rates  WHERE country='$country_val'";
                $result_ob = mysql_query($query_ob) or die(mysql_error());
                $obser = mysql_num_rows($result_ob);

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
                if ($min_adop_month == '')
                    $disp_min_adop_month = 'No Month';
                if ($min_adop_month == '0')
                    $disp_min_adop_month = '0 Month';
                if ($min_adop_month == '1')
                    $disp_min_adop_month = 'Jan';
                if ($min_adop_month == '2')
                    $disp_min_adop_month = 'Feb';
                if ($min_adop_month == '3')
                    $disp_min_adop_month = 'Mar';
                if ($min_adop_month == '4')
                    $disp_min_adop_month = 'Apr';
                if ($min_adop_month == '5')
                    $disp_min_adop_month = 'May';
                if ($min_adop_month == '6')
                    $disp_min_adop_month = 'Jun';
                if ($min_adop_month == '7')
                    $disp_min_adop_month = 'Jul';
                if ($min_adop_month == '8')
                    $disp_min_adop_month = 'Aug';
                if ($min_adop_month == '9')
                    $disp_min_adop_month = 'Sep';
                if ($min_adop_month == '10')
                    $disp_min_adop_month = 'Oct';
                if ($min_adop_month == '11')
                    $disp_min_adop_month = 'Nov';
                if ($min_adop_month == '12')
                    $disp_min_adop_month = 'Dec';
                if ($min_adop_month > '12')
                    $disp_min_adop_month = 'No Month';

                if ($max_adop_month == '')
                    $disp_max_adop_month = 'No Month';
                if ($max_adop_month == '0')
                    $disp_max_adop_month = '0 Month';
                if ($max_adop_month == '1')
                    $disp_max_adop_month = 'Jan';
                if ($max_adop_month == '2')
                    $disp_max_adop_month = 'Feb';
                if ($max_adop_month == '3')
                    $disp_max_adop_month = 'Mar';
                if ($max_adop_month == '4')
                    $disp_max_adop_month = 'Apr';
                if ($max_adop_month == '5')
                    $disp_max_adop_month = 'May';
                if ($max_adop_month == '6')
                    $disp_max_adop_month = 'Jun';
                if ($max_adop_month == '7')
                    $disp_max_adop_month = 'Jul';
                if ($max_adop_month == '8')
                    $disp_max_adop_month = 'Aug';
                if ($max_adop_month == '9')
                    $disp_max_adop_month = 'Sep';
                if ($max_adop_month == '10')
                    $disp_max_adop_month = 'Oct';
                if ($max_adop_month == '11')
                    $disp_max_adop_month = 'Nov';
                if ($max_adop_month == '12')
                    $disp_max_adop_month = 'Dec';
                if ($max_adop_month > '12')
                    $disp_max_adop_month = 'No Month';
                ?>
                <p class="text_title"> The table below provides an overview of the percentage of randomly sampled households that tested positive for Total Chlorine
                    Residual in their drinking water during an unannounced visit.One out of every one hundred dispensers are randomly selected 
                    for interviews each month. A random selection of 8 households are interviewed at each dispenser. The table below includes
                    a total of <?php echo $obser; ?> observations for the period from <?php echo $disp_min_adop_month . ' ' . $min_adop_year; ?>
                    to <?php echo $disp_max_adop_month . ' ' . $max_adop_year; ?></p>
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
                        $res = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' ORDER BY program");
                        while ($row = mysql_fetch_array($res)) {
                            ?>
                        <tr> <?php $prog = $row["program"]; ?>
                            <th><?php echo $prog; ?></th> 
                                <?php
                                $prog_sum = 0;
                                $av_div_prog = 0;
                                for ($value = 1; $value < 13; ++$value) {
                                    ?>
                                <td> <?php
                $query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '0' AND $field != ''";
                $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
                $nume = mysql_num_rows($result);

                $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != ''";
                $result1 = mysql_query($query1) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
                $deno = mysql_num_rows($result1);

                if ($deno == null) {
                    echo "";
                } else {
                    $ans = round(($nume / $deno), 2);
                    $percent = $ans * 100;
                    echo $nume . "%";
                    echo $deno . "%";
                    $prog_sum += $percent;
                    $av_div_prog++;
                                        ?>
                                    </td> 
                                        <?php
                                    }
                                }
                                ?>
                            <th><?php
                                if ($av_div_prog != null) {
                                    echo round($prog_sum / $av_div_prog, 0) . "%";
                                }
                                ?></th>      
                        </tr>

                    <?php }
                    ?>

                    <tr>
                        <th>Av./Month</th>
    <?php for ($value = 1; $value < 13; ++$value) { ?>
                            <td style="font-weight: bold;"><?php
        $query = "SELECT $field FROM dsw_per_adoption_rates  WHERE country='$country_val' AND month = '$value' AND $field != '0' AND $field != ''";
        $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
        $nume = mysql_num_rows($result);

        $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE country='$country_val' AND month = '$value'AND $field != ''";
        $result1 = mysql_query($query1) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
        $deno = mysql_num_rows($result1);
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

                </table></br>

                <h3>FCR Adoption (Free Chlorine Adoption)</h3>
                <p class="text_title"> This table provides an overview of the percentage of randomly sampled households that tested positive for 
                    Free Chlorine Residual in their drinking water during an unannounced visit. One out of every one hundred dispensers are 
                    randomly selected for interviews each month. A random selection of 8 households are interviewed at each dispenser. 
                    The table below includes a total of <?php echo $obser; ?> observations for the period from 
                        <?php echo $disp_min_adop_month . ' ' . $min_adop_year; ?> to <?php echo $disp_max_adop_month . ' ' . $max_adop_year; ?></p>
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
                                $prog_sum2 = 0;
                                $av_div_prog2 = 0;
                                for ($value = 1; $value < 13; ++$value) {
                                    ?>
                                <td> <?php
                            $query = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field2 != '0' AND $field2 != ''";
                            $result = mysql_query($query) or die(mysql_error());
                            $nume = mysql_num_rows($result);

                            $query1 = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field2 != ''";
                            $result1 = mysql_query($query1) or die(mysql_error());
                            $deno = mysql_num_rows($result1);

                            if ($deno == null) {
                                echo "";
                            } else {
                                $ans = round(($nume / $deno), 2);
                                $percent = $ans * 100;
                                echo $nume . "%";
                    echo $deno . "%";
                                $prog_sum2 += $percent;
                                $av_div_prog2++;
                                ?>
                                    </td> 
                                        <?php
                                    }
                                }
                                ?>
                            <th><?php
                        if ($av_div_prog2 != null) {
                            echo round($prog_sum2 / $av_div_prog2, 0) . "%";
                        }
                                ?></th>
                        </tr>

        <?php
    }
    ?>                   
                    <tr>
                        <th>Av./Month</th>
                <?php for ($value = 1; $value < 13; ++$value) { ?>
                            <td style="font-weight: bold;"><?php
                    $res = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' ORDER BY program");

                    $query = "SELECT $field2 FROM dsw_per_adoption_rates WHERE country='$country_val' AND month = '$value' AND $field2 != '0' AND $field2 != ''";
                    $result = mysql_query($query) or die("<h1>Cannot get num of " . $field2 . "</h1>" . mysql_error());
                    $nume = mysql_num_rows($result);

                    $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE country='$country_val' AND month = '$value'AND $field != ''";
                    $result1 = mysql_query($query1) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
                    $deno = mysql_num_rows($result1);
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

                <?php
            } else {
                ?>  
                </table>

                <h3>TCR Adoption (Total Chlorine Adoption)</h3>
                <?php
                $query_ob = "SELECT * FROM dsw_per_adoption_rates  WHERE year='$year' AND country='$country_val'";
                $result_ob = mysql_query($query_ob) or die(mysql_error());
                $obser = mysql_num_rows($result_ob);
                $query_adop_header1 = "SELECT MIN(month) FROM dsw_per_adoption_rates WHERE year ='$year' AND country='$country_val'";
                $result_adop_header1 = mysql_query($query_adop_header1) or die(mysql_error());
                $row_adop_header1 = mysql_fetch_array($result_adop_header1);
                $min_adop_month = $row_adop_header1['MIN(month)'];
                $query_adop_header2 = "SELECT MAX(month) FROM dsw_per_adoption_rates WHERE year ='$year' AND country='$country_val'";
                $result_adop_header2 = mysql_query($query_adop_header2) or die(mysql_error());
                $row_adop_header2 = mysql_fetch_array($result_adop_header2);
                $max_adop_month = $row_adop_header2['MAX(month)'];
                if ($min_adop_month == '')
                    $disp_min_adop_month = 'No Month';
                if ($min_adop_month == '0')
                    $disp_min_adop_month = '0 Month';
                if ($min_adop_month == '1')
                    $disp_min_adop_month = 'Jan';
                if ($min_adop_month == '2')
                    $disp_min_adop_month = 'Feb';
                if ($min_adop_month == '3')
                    $disp_min_adop_month = 'Mar';
                if ($min_adop_month == '4')
                    $disp_min_adop_month = 'Apr';
                if ($min_adop_month == '5')
                    $disp_min_adop_month = 'May';
                if ($min_adop_month == '6')
                    $disp_min_adop_month = 'Jun';
                if ($min_adop_month == '7')
                    $disp_min_adop_month = 'Jul';
                if ($min_adop_month == '8')
                    $disp_min_adop_month = 'Aug';
                if ($min_adop_month == '9')
                    $disp_min_adop_month = 'Sep';
                if ($min_adop_month == '10')
                    $disp_min_adop_month = 'Oct';
                if ($min_adop_month == '11')
                    $disp_min_adop_month = 'Nov';
                if ($min_adop_month == '12')
                    $disp_min_adop_month = 'Dec';
                if ($min_adop_month > '12')
                    $disp_min_adop_month = 'No Month';

                if ($max_adop_month == '')
                    $disp_max_adop_month = 'No Month';
                if ($max_adop_month == '0')
                    $disp_max_adop_month = '0 Month';
                if ($max_adop_month == '1')
                    $disp_max_adop_month = 'Jan';
                if ($max_adop_month == '2')
                    $disp_max_adop_month = 'Feb';
                if ($max_adop_month == '3')
                    $disp_max_adop_month = 'Mar';
                if ($max_adop_month == '4')
                    $disp_max_adop_month = 'Apr';
                if ($max_adop_month == '5')
                    $disp_max_adop_month = 'May';
                if ($max_adop_month == '6')
                    $disp_max_adop_month = 'Jun';
                if ($max_adop_month == '7')
                    $disp_max_adop_month = 'Jul';
                if ($max_adop_month == '8')
                    $disp_max_adop_month = 'Aug';
                if ($max_adop_month == '9')
                    $disp_max_adop_month = 'Sep';
                if ($max_adop_month == '10')
                    $disp_max_adop_month = 'Oct';
                if ($max_adop_month == '11')
                    $disp_max_adop_month = 'Nov';
                if ($max_adop_month == '12')
                    $disp_max_adop_month = 'Dec';
                if ($max_adop_month > '12')
                    $disp_max_adop_month = 'No Month';
                ?>
                <p class="text_title"> The table below provides an overview of the percentage of randomly sampled households that tested positive for Total Chlorine
                    Residual in their drinking water during an unannounced visit.One out of every one hundred dispensers are randomly selected 
                    for interviews each month. A random selection of 8 households are interviewed at each dispenser. The table below includes
                    a total of <?php echo $obser; ?> observations for the period from <?php echo $disp_min_adop_month . ' ' . $year; ?> to 
                    <?php echo $disp_max_adop_month . ' ' . $year; ?></p>
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
                            $res = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' ORDER BY program");
                            while ($row = mysql_fetch_array($res)) {
                                ?>
                        <tr> <?php $prog = $row["program"]; ?>
                            <th><?php echo $prog; ?></th> 
        <?php
        $prog_sum = 0;
        $av_div_prog = 0;
        for ($value = 1; $value < 13; ++$value) {
            ?>
                                <td> <?php
            $query = "SELECT $field FROM dsw_per_adoption_rates WHERE year = '$year' AND month = '$value' AND program = '$prog' AND $field != '0' AND $field != ''";
            $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
            $nume = mysql_num_rows($result);

            $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE year = '$year' AND month = '$value' AND program = '$prog' AND $field != ''";
            $result1 = mysql_query($query1) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
            $deno = mysql_num_rows($result1);
            if ($deno == null) {
                echo "";
            } else {
                $ans = round(($nume / $deno), 2);
                $percent = $ans * 100;
                echo $percent . "%";
                $prog_sum += $percent;
                $av_div_prog++;
                ?>
                                    </td> 
                                <?php
                            }
                        }
                        ?>
                            <th><?php
                if ($av_div_prog != null) {
                    echo round($prog_sum / $av_div_prog, 0) . "%";
                }
                        ?></th>        
                        </tr>

                        <?php }
                        ?>

                    <tr>
                        <th>Av./Month</th>
                            <?php for ($value = 1; $value < 13; ++$value) { ?>
                            <td style="font-weight: bold;"><?php
                                $query = "SELECT $field FROM dsw_per_adoption_rates WHERE country='$country_val' AND year = '$year' AND month = '$value' AND $field != '0' AND $field != ''";
                                $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
                                $nume = mysql_num_rows($result);

                                $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE country='$country_val' AND year = '$year' AND month = '$value'AND $field != ''";
                                $result1 = mysql_query($query1) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
                                $deno = mysql_num_rows($result1);
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
                </table></br>

                <h3>FCR Adoption (Free Chlorine Adoption)</h3>
                <p class="text_title"> This table provides an overview of the percentage of randomly sampled households that tested positive for 
                    Free Chlorine Residual in their drinking water during an unannounced visit. One out of every one hundred dispensers are 
                    randomly selected for interviews each month. A random selection of 8 households are interviewed at each dispenser. 
                    The table below includes a total of <?php echo $obser; ?> observations for the period from 
                    <?php echo $disp_min_adop_month . ' ' . $year; ?> to <?php echo $disp_max_adop_month . ' ' . $year; ?></p>
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
        $prog_sum2 = 0;
        $av_div_prog2 = 0;
        for ($value = 1; $value < 13; ++$value) {
            ?>
                                <td> <?php
                            $query = "SELECT $field2 FROM dsw_per_adoption_rates WHERE year = '$year' AND month = '$value' AND program = '$prog' AND $field2 != '0' AND $field2 != ''";
                            $result = mysql_query($query) or die("<h1>Cannot get num of " . $field2 . "</h1>" . mysql_error());
                            $nume = mysql_num_rows($result);

                            $query1 = "SELECT $field2 FROM dsw_per_adoption_rates WHERE year = '$year' AND month = '$value' AND program = '$prog' AND $field != ''";
                            $result1 = mysql_query($query1) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
                            $deno = mysql_num_rows($result1);
                            if ($deno == null) {
                                echo "";
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
                            <th><?php
        if ($av_div_prog2 != null) {
            echo round($prog_sum2 / $av_div_prog2, 0) . "%";
        }
        ?></th>
                        </tr>

        <?php
    }
    ?>                     
                    <tr>
                        <th>Av./Month</th>
    <?php for ($value = 1; $value < 13; ++$value) { ?>
                            <td style="font-weight: bold;"><?php
        $query = "SELECT $field2 FROM dsw_per_adoption_rates WHERE country='$country_val' AND year = '$year' AND month = '$value' AND $field2 != '0' AND $field2 != ''";
        $result = mysql_query($query) or die("<h1>Cannot get num of " . $field2 . "</h1>" . mysql_error());
        $nume = mysql_num_rows($result);

        $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE country='$country_val' AND year = '$year' AND month = '$value'AND $field != ''";
        $result1 = mysql_query($query1) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
        $deno = mysql_num_rows($result1);
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
    <?php
}
?> 
            </table>
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

</div>

</body>

</html>       