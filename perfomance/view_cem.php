<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");

$image = new image;
$insertFile = new UploadFIle;
$sql = "(SELECT DISTINCT year FROM dsw_per_cem_attendees WHERE country='$country_val' ) UNION (SELECT DISTINCT year FROM dsw_per_vcs_attendees WHERE country='$country_val' ) ORDER BY year DESC";
$result = mysqli_query($mysqli, $sql);
if (isset($_GET["submit_year"])) {
    $year = $_GET["year_select"];
    $quarter = 'All quarters';
} else if (isset($_GET["submit_quarter"])) {
    $year = $_GET["rec_year"];
    $quarter = $_GET["quarter_select"];
} else {
    $year = 'All years';
    $quarter = 'All quarters';
}
if (isset($_POST['uploadCSV'])) {

    $table = "dsw_per_cem_attendees";
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
   $csvMessage = $insertFile->insertFile($filename, $table, 'view_cem.php');

    //Connect as normal above
}

if (isset($_POST['2uploadCSV2'])) {

    $table = "dsw_per_vcs_attendees";
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
    $insertFile->insertFile($filename, $table, 'view_cem.php');

    //Connect as normal above
}
if (isset($_POST['clearbtn1'])) {

    $table = "dsw_per_cem_attendees";
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
if (isset($_POST['clearbtn2'])) {

    $table = "dsw_per_vcs_attendees";
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

        <ul class="list-unstyled list-inline" >
            <a class="btn btn-primary" href="#importCSV"><span class="glyphicon glyphicon-download-alt" ></span> IMPORT CEM Att. Table</a>
            <a class="btn btn-primary" href="#importCSV2"><span class="glyphicon glyphicon-download-alt" ></span> IMPORT VCS Att. Table</a>
        Last Updated 19/12/2016
        </ul></br>
        <?php
        if ($year == 'All years') {
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
            </form>
            <div class="btn-group pull-right">            
                <form method="POST" action="export/exp_cem.php">            
                    <input type="hidden" name="rec_year" value="<?php echo $year; ?>" />
                    <input type="hidden" name="rec_quarter" value="<?php echo $quarter; ?>" />
                    <input type="hidden" name="rec_country" value="<?php echo $country_val; ?>" />
                    <input class="btn btn-primary" type="submit" name="" value="Export CSV">
                </form>                     
            </div>
            <br>
            <br>        

            <div class="table-responsive">
                <h4>Attendees Table</h4>

                <?php
                $query_vcs_header = "SELECT  MIN(year), MAX(year) FROM dsw_per_vcs_attendees WHERE country='$country_val'";
                $result_vcs_header = mysqli_query($mysqli, $query_vcs_header) or die(mysqli_query($mysqli));
                $row_vcs_header = mysqli_fetch_assoc($result_vcs_header);
                $min_vcs_year = $row_vcs_header['MIN(year)'];
                $max_vcs_year = $row_vcs_header['MAX(year)'];
                $query_vcs_header1 = "SELECT MIN(month) FROM dsw_per_vcs_attendees WHERE year ='$min_vcs_year'";
                $result_vcs_header1 = mysqli_query($mysqli, $query_vcs_header1) or die(mysqli_query($mysqli));
                $row_vcs_header1 = mysqli_fetch_assoc($result_vcs_header1);
                $min_vcs_month = $row_vcs_header1['MIN(month)'];
                $query_vcs_header2 = "SELECT MAX(month) FROM dsw_per_vcs_attendees WHERE year ='$max_vcs_year'";
                $result_vcs_header2 = mysqli_query($mysqli, $query_vcs_header2) or die(mysqli_query($mysqli));
                $row_vcs_header2 = mysqli_fetch_assoc($result_vcs_header2);
                $max_vcs_month = $row_vcs_header2['MAX(month)'];


                $query_cem_header = "SELECT MIN(year), MAX(year) FROM dsw_per_cem_attendees WHERE country='$country_val'";
                $result_cem_header = mysqli_query($mysqli, $query_cem_header) or die(mysqli_query($mysqli));
                $row_cem_header = mysqli_fetch_assoc($result_cem_header);
                $min_cem_year = $row_cem_header['MIN(year)'];
                $max_cem_year = $row_cem_header['MAX(year)'];
                $query_cem_header1 = "SELECT MIN(month) FROM dsw_per_cem_attendees WHERE year ='$min_cem_year'";
                $result_cem_header1 = mysqli_query($mysqli, $query_cem_header1) or die(mysqli_query($mysqli));
                $row_cem_header1 = mysqli_fetch_assoc($result_cem_header1);
                $min_cem_month = $row_cem_header1['MIN(month)'];
                $query_cem_header2 = "SELECT MAX(month) FROM dsw_per_cem_attendees WHERE year ='$max_cem_year'";
                $result_cem_header2 = mysqli_query($mysqli, $query_cem_header2) or die(mysqli_query($mysqli));
                $row_cem_header2 = mysqli_fetch_assoc($result_cem_header2);
                $max_cem_month = $row_cem_header2['MAX(month)'];

                $min_par_year = MIN($min_vcs_year, $min_cem_year);
                $max_par_year = MAX($max_vcs_year, $max_cem_year);

                if ($min_par_year == $min_vcs_year)
                    $min_par_month = $min_vcs_month;
                if ($min_par_year == $min_cem_year)
                    $min_par_month = $min_cem_month;
                if (0 < $min_par_month && $min_par_month < 13) {
                    $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                    $disp_min_par_month = $month_names[$min_par_month];
                } else {
                    $disp_min_par_month = 'no month';
                }


                if ($max_par_year == $max_vcs_year)
                    $max_par_month = $max_vcs_month;
                if ($max_par_year == $max_cem_year)
                    $max_par_month = $max_cem_month;

                if (0 < $max_par_month && $max_par_month < 13) {
                    $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                    $disp_max_par_month = $month_names[$max_par_month];
                } else {
                    $disp_max_par_month = 'no month';
                }
                ?>

                <p class="text_title"> This table provides the average attendance at Village Community Sensitization (VCS) meetings and Community Education Meetings (CEM). 
                    Field Officers at these meetings record the total number of attendees present. The figures below show the average for each installation round within the country.
                    The data below reflect the data collected during the period from <?php echo $disp_min_par_month . ' ' . $min_par_year; ?> to
                <?php echo $disp_max_par_month . ' ' . $max_par_year; ?><p>

                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th> YEAR SELECTED : <?php echo $year; ?></th>
                    </tr>
                </table>

                <table class="table table-bordered table-striped table-hover" style="width: 50%; float: left;">  
                    <tr>
                        <th>Installation Round</th>
                        <th>Average CEM Attendees</th>
                    </tr>

                    <?php
                    $prog_sum = 0;
                    $av_div_prog = 0;
                    $res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_cem_attendees` WHERE country='$country_val' ORDER BY program");
                    while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr> <?php $prog = $row["program"]; ?>
                            <th><?php echo $prog; ?></th>                        
                            <td> <?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT $field FROM dsw_per_cem_attendees WHERE program = '$prog'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $deno = mysqli_affected_rows($mysqli);
                                $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE program = '$prog'";
                                $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                $row2 = mysqli_fetch_assoc($result1);
                                $nume = $row2['denominator'];
                                if ($deno == 0) {
                                    echo "";
                                } else {
                                    $ans = round(($nume / $deno), 0);
                                    echo $ans;
                                }
                                ?>
                            </td>
                        </tr> 
                    <?php }
                    ?>
                    <tr>
                        <th>Average</th>
                        <th><?php
                            $field = 'cem301_attendees_total';
                            $query = "SELECT $field FROM dsw_per_cem_attendees WHERE country='$country_val'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $deno = mysqli_affected_rows($mysqli);
                            $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE country='$country_val'";
                            $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                            $row2 = mysqli_fetch_assoc($result1);
                            $nume = $row2['denominator'];
                            if ($deno == 0) {
                                echo "";
                            } else {
                                $ans = round(($nume / $deno), 0);
                                echo $ans;
                            }
                            ?></th> 
                    </tr>
                </table>
                <table class="table table-bordered table-striped table-hover" style="width: 50%">  
                    <tr>
                        <th>Program</th>
                        <th>Average VCS Attendees</th>                    
                    </tr>

                    <?php
                    $prog_sum2 = 0;
                    $av_div_prog2 = 0;
                    $res1 = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_vcs_attendees` WHERE country='$country_val' ORDER BY program");
                    while ($row = mysqli_fetch_assoc($res1)) {
                        ?>
                        <tr> <?php $prog = $row["program"]; ?>
                            <th><?php echo $prog; ?></th>
                            <td> <?php
                                $field = 'vcs201_attendees_total';
                                $query = "SELECT $field FROM dsw_per_vcs_attendees WHERE program = '$prog'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $deno = mysqli_affected_rows($mysqli);
                                $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_vcs_attendees WHERE program = '$prog'";
                                $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                $row2 = mysqli_fetch_assoc($result1);
                                $nume = $row2['denominator'];
                                if ($deno == 0) {
                                    echo "";
                                } else {
                                    $ans = round(($nume / $deno), 0);
                                    echo $ans;
                                    $prog_sum2 += $ans;
                                    $av_div_prog2++;
                                }
                                ?>
                            </td> 
                        </tr> 

                    <?php }
                    ?>

                    <tr>
                        <th>Average</th>
                        <th><?php
                            $field2 = 'vcs201_attendees_total';
                            $query2 = "SELECT $field2 FROM dsw_per_vcs_attendees WHERE country='$country_val'";
                            $result2 = mysqli_query($mysqli, $query2) or die(mysqli_query($mysqli));
                            $deno2 = mysqli_affected_rows($mysqli);
                            $query3 = "SELECT SUM($field2) AS denominator FROM dsw_per_vcs_attendees WHERE country='$country_val'";
                            $result3 = mysqli_query($mysqli, $query3) or die(mysqli_query($mysqli));
                            $row3 = mysqli_fetch_assoc($result3);
                            $nume3 = $row3['denominator'];
                            if ($deno2 == 0) {
                                echo "";
                            } else {
                                $ans2 = round(($nume3 / $deno2), 0);
                                echo $ans2;
                            }
                            ?></th> 
                    </tr>

                </table>
<!--                <p style="clear: both" class="text_foot">
                    *Absence of a program in the CEM and/or VCS tables means that no CEM attendees and/or VCS attendees data for the program exists between 2012
                    - present year.
                </p>-->
                <?php
            }


####################### Option for year ##################################
            else {
                ?>
                <form   method="$_GET" style='float: left; '>  

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
                <form  method="$_GET" style='float: left; padding-left: 3%'>  

                    <select style="width:160px; height: 34px" name="quarter_select" id="year_select">
                        <option value='All quarters'<?php if ($quarter == 'All quarters') echo 'selected'; ?> >All quarters</option>                        
                        <option value="1st_quarter"<?php if ($quarter == '1st_quarter') echo 'selected'; ?>>1st_quarter</option>
                        <option value="2nd_quarter"<?php if ($quarter == '2nd_quarter') echo 'selected'; ?>>2nd_quarter</option>
                        <option value="3rd_quarter"<?php if ($quarter == '3rd_quarter') echo 'selected'; ?>>3rd_quarter</option>
                        <option value="4th_quarter"<?php if ($quarter == '4th_quarter') echo 'selected'; ?>>4th_quarter</option>

                    </select>
                    <input type="hidden" name="rec_year" value="<?php echo $year; ?>" />
                    <input class="btn btn-primary" type="submit" name="submit_quarter" id="submit_quater" value="CHOOSE QUATER">
                </form>
                <div class="btn-group pull-right">           
                    <form method="POST" action="export/exp_cem.php">            
                        <input type="hidden" name="rec_year" value="<?php echo $year; ?>" />
                        <input type="hidden" name="rec_quarter" value="<?php echo $quarter; ?>" />
                        <input type="hidden" name="rec_country" value="<?php echo $country_val; ?>" />
                        <input class="btn btn-primary" type="submit" name="" value="Export CSV">
                    </form> 
                </div>
                <br>
                <br>        

                <div class="table-responsive">
                    <h4>Attendees Table</h4>
                    <?php
                    if ($quarter == 'All quarters') {
                        ####################### Option for all quarters ################################## 

                        $query_vcs_header1 = "SELECT MIN(month) FROM dsw_per_vcs_attendees WHERE year ='$year' AND country='$country_val'";
                        $result_vcs_header1 = mysqli_query($mysqli, $query_vcs_header1) or die(mysqli_query($mysqli));
                        $row_vcs_header1 = mysqli_fetch_assoc($result_vcs_header1);
                        $min_vcs_month = $row_vcs_header1['MIN(month)'];
                        $query_vcs_header2 = "SELECT MAX(month) FROM dsw_per_vcs_attendees WHERE year ='$year' AND country='$country_val'";
                        $result_vcs_header2 = mysqli_query($mysqli, $query_vcs_header2) or die(mysqli_query($mysqli));
                        $row_vcs_header2 = mysqli_fetch_assoc($result_vcs_header2);
                        $max_vcs_month = $row_vcs_header2['MAX(month)'];

                        $query_cem_header1 = "SELECT MIN(month) FROM dsw_per_cem_attendees WHERE year ='$year' AND country='$country_val'";
                        $result_cem_header1 = mysqli_query($mysqli, $query_cem_header1) or die(mysqli_query($mysqli));
                        $row_cem_header1 = mysqli_fetch_assoc($result_cem_header1);
                        $min_cem_month = $row_cem_header1['MIN(month)'];
                        $query_cem_header2 = "SELECT MAX(month) FROM dsw_per_cem_attendees WHERE year ='$year' AND country='$country_val'";
                        $result_cem_header2 = mysqli_query($mysqli, $query_cem_header2) or die(mysqli_query($mysqli));
                        $row_cem_header2 = mysqli_fetch_assoc($result_cem_header2);
                        $max_cem_month = $row_cem_header2['MAX(month)'];
                        if ($min_cem_month != '' && $min_vcs_month == '') {
                            $min_par_month = $min_cem_month;
                        } else if ($min_cem_month == '' && $min_vcs_month != '') {
                            $min_par_month = $min_vcs_month;
                        } else {
                            $min_par_month = MIN($min_cem_month, $min_vcs_month);
                        }

                        if (0 < $min_par_month && $min_par_month < 13) {
                            $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                            $disp_min_par_month = $month_names[$min_par_month];
                        } else {
                            $disp_min_par_month = 'no month';
                        }

                        if ($max_cem_month != '' && $max_vcs_month == '') {
                            $max_par_month = $max_cem_month;
                        } else if ($max_cem_month == '' && $max_vcs_month != '') {
                            $max_par_month = $max_vcs_month;
                        } else {
                            $max_par_month = MAX($max_cem_month, $max_vcs_month);
                        }
                        if (0 < $max_par_month && $max_par_month < 13) {
                            $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                            $disp_max_par_month = $month_names[$max_par_month];
                        } else {
                            $disp_max_par_month = 'no month';
                        }
                        ?>

                        <p class="text_title"> This table provides the average attendance at Village Community Sensitization (VCS) meetings and Community Education Meetings (CEM). 
                            Field Officers at these meetings record the total number of attendees present. The figures below show the average for each office within the country.
                            The data below reflect the data collected during the period from <?php echo $disp_min_par_month . ' ' . $year; ?> to
                        <?php echo $disp_max_par_month . ' ' . $year; ?><p>

                        <table class="table table-bordered table-striped table-hover">
                            <tr>
                                <th style=""> YEAR SELECTED : <?php echo $year; ?></th>
                            </tr>
                            <tr>
                                <th> QUARTER SELECTED : <?php echo $quarter; ?></th>
                            </tr>
                        </table>

                        <table class="table table-bordered table-striped table-hover" style="width: 50%; float: left;">  
                            <tr>
                                <th>Program</th>
                                <th>Average CEM Attendees</th>
                            </tr>

                            <?php
                            $prog_sum = 0;
                            $av_div_prog = 0;
                            $res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_cem_attendees` WHERE country='$country_val' ORDER BY program");
                            while ($row = mysqli_fetch_assoc($res)) {
                                ?>
                                <tr> <?php $prog = $row["program"]; ?>
                                    <th><?php echo $prog; ?></th>                        
                                    <td> <?php
                                        $field = 'cem301_attendees_total';
                                        $query = "SELECT $field FROM dsw_per_cem_attendees WHERE program = '$prog' AND year = '$year'";
                                        $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                        $deno = mysqli_affected_rows($mysqli);
                                        $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE program = '$prog' AND year = '$year'";
                                        $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                        $row2 = mysqli_fetch_assoc($result1);
                                        $nume = $row2['denominator'];
                                        if ($deno == 0) {
                                            echo "";
                                        } else {
                                            $ans = round(($nume / $deno), 0);
                                            echo $ans;
                                        }
                                        ?>
                                    </td>
                                </tr> 
                            <?php }
                            ?>
                            <tr>
                                <th>Average</th>
                                <th><?php
                                    $field = 'cem301_attendees_total';
                                    $query = "SELECT $field FROM dsw_per_cem_attendees WHERE country='$country_val' AND year = '$year'";
                                    $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                    $deno = mysqli_affected_rows($mysqli);
                                    $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE country='$country_val' AND year = '$year'";
                                    $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                    $row2 = mysqli_fetch_assoc($result1);
                                    $nume = $row2['denominator'];
                                    if ($deno == 0) {
                                        echo "";
                                    } else {
                                        $ans = round(($nume / $deno), 0);
                                        echo $ans;
                                    }
                                    ?></th> 
                            </tr>
                        </table>

                        <table class="table table-bordered table-striped table-hover" style="width: 50%">  
                            <tr>
                                <th>Program</th>
                                <th>Average VCS Attendees</th>                    
                            </tr>

                            <?php
                            $prog_sum2 = 0;
                            $av_div_prog2 = 0;
                            $res1 = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_vcs_attendees` WHERE country='$country_val' ORDER BY program");
                            while ($row = mysqli_fetch_assoc($res1)) {
                                ?>
                                <tr> <?php $prog = $row["program"]; ?>
                                    <th><?php echo $prog; ?></th>
                                    <td> <?php
                                        $field = 'vcs201_attendees_total';
                                        $query = "SELECT $field FROM dsw_per_vcs_attendees WHERE program = '$prog' AND year = '$year'";
                                        $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                        $deno = mysqli_affected_rows($mysqli);
                                        $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_vcs_attendees WHERE program = '$prog' AND year = '$year'";
                                        $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                        $row2 = mysqli_fetch_assoc($result1);
                                        $nume = $row2['denominator'];
                                        if ($deno == 0) {
                                            echo "";
                                        } else {
                                            $ans = round(($nume / $deno), 0);
                                            echo $ans;
                                            $prog_sum2 += $ans;
                                            $av_div_prog2++;
                                        }
                                        ?>
                                    </td> 
                                </tr> 

                            <?php }
                            ?>

                            <tr>
                                <th>Average</th>
                                <th><?php
                                    $field2 = 'vcs201_attendees_total';
                                    $query2 = "SELECT $field2 FROM dsw_per_vcs_attendees WHERE country='$country_val' AND year = '$year'";
                                    $result2 = mysqli_query($mysqli, $query2) or die(mysqli_query($mysqli));
                                    $deno2 = mysqli_affected_rows($mysqli);
                                    $query3 = "SELECT SUM($field2) AS denominator FROM dsw_per_vcs_attendees WHERE country='$country_val' AND year = '$year'";
                                    $result3 = mysqli_query($mysqli, $query3) or die(mysqli_query($mysqli));
                                    $row3 = mysqli_fetch_assoc($result3);
                                    $nume3 = $row3['denominator'];
                                    if ($deno2 == 0) {
                                        echo "";
                                    } else {
                                        $ans2 = round(($nume3 / $deno2), 0);
                                        echo $ans2;
                                    }
                                    ?></th> 
                            </tr>

                        </table>
<!--                        <p style="clear: both" class="text_foot">
                            *Absence of a program in the CEM and/or VCS tables means that no CEM attendees and/or VCS attendees data for the program exists between 2012
                            - present year.
                        </p>-->
                        <?php
                    } else { ####################### Option for quarter ##################################                         
                        if ($quarter == '1st_quarter') {
                            $quarter_val = array(1, 2, 3);

                            $first_month = 'Jan';
                            $last_month = 'Mar';
                        } elseif ($quarter == '2nd_quarter') {
                            $quarter_val = array(4, 5, 6);
                            $first_month = 'Apr';
                            $last_month = 'Jun';
                        } elseif ($quarter == '3rd_quarter') {
                            $quarter_val = array(7, 8, 9);
                            $first_month = 'Jul';
                            $last_month = 'Sep';
                        } elseif ($quarter == '4th_quarter') {
                            $quarter_val = array(10, 11, 12);
                            $first_month = 'Oct';
                            $last_month = 'Dec';
                        }
                        ?>

                        <p class="text_title"> This table provides the average attendance at Village Community Sensitization (VCS) meetings and Community Education Meetings (CEM). 
                            Field Officers at these meetings record the total number of attendees present. The figures below show the average for each office within the country.
                            The data below reflect the data collected during the period from <?php echo $first_month; ?> <?php echo $year; ?> to <?php echo $last_month; ?> <?php echo $year; ?><p>

                        <table class="table table-bordered table-striped table-hover">
                            <tr>
                                <th style=""> YEAR SELECTED : <?php echo $year; ?></th>
                            </tr>
                            <tr>
                                <th> QUARTER SELECTED : <?php echo $quarter; ?></th>
                            </tr>
                        </table>

                        <table class="table table-bordered table-striped table-hover" style="width: 50%; float: left;">  
                            <tr>
                                <th>Program</th>
                                <th>Average CEM Attendees</th>
                            </tr>

                            <?php
                            $prog_sum = 0;
                            $av_div_prog = 0;
                            $res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_cem_attendees` WHERE country='$country_val' ORDER BY program");
                            while ($row = mysqli_fetch_assoc($res)) {
                                ?>
                                <tr> <?php $prog = $row["program"]; ?>
                                    <th><?php echo $prog; ?></th>                        
                                    <td> <?php
                                        $sum_nume = 0;
                                        $sum_deno = 0;
                                        for ($x = 0; $x < 3; $x++) {

                                            $field = 'cem301_attendees_total';
                                            $query = "SELECT $field FROM dsw_per_cem_attendees WHERE program = '$prog' AND year = '$year' AND month = '$quarter_val[$x]'";
                                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                            $deno = mysqli_affected_rows($mysqli);
                                            $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE program = '$prog' AND year = '$year' AND month = '$quarter_val[$x]'";
                                            $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                            $row2 = mysqli_fetch_assoc($result1);
                                            $nume = $row2['denominator'];
                                            $sum_nume += $nume;
                                            $sum_deno += $deno;
                                        }
                                        if ($sum_deno == 0) {
                                            echo "";
                                        } else {
                                            $ans = round(($sum_nume / $sum_deno), 0);
                                            echo $ans;
                                        }
                                        ?>
                                    </td>
                                </tr> 
                            <?php }
                            ?>
                            <tr>
                                <th>Average</th>
                                <th><?php
                                    $sum_nume = 0;
                                    $sum_deno = 0;
                                    for ($x = 0; $x < 3; $x++) {
                                        $field = 'cem301_attendees_total';
                                        $query = "SELECT $field FROM dsw_per_cem_attendees WHERE country='$country_val' AND year = '$year' AND month = '$quarter_val[$x]'";
                                        $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                        $deno = mysqli_affected_rows($mysqli);
                                        $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE country='$country_val' AND year = '$year' AND month = '$quarter_val[$x]'";
                                        $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                        $row2 = mysqli_fetch_assoc($result1);
                                        $nume = $row2['denominator'];
                                        $sum_nume += $nume;
                                        $sum_deno += $deno;
                                    }
                                    if ($sum_deno == 0) {
                                        echo "";
                                    } else {
                                        $ans = round(($sum_nume / $sum_deno), 0);
                                        echo $ans;
                                    }
                                    ?></th> 
                            </tr>
                        </table>

                        <table class="table table-bordered table-striped table-hover" style="width: 50%">  
                            <tr>
                                <th>Program</th>
                                <th>Average VCS Attendees</th>                    
                            </tr>

                            <?php
                            $prog_sum2 = 0;
                            $av_div_prog2 = 0;
                            $res1 = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_vcs_attendees` WHERE country='$country_val' ORDER BY program");
                            while ($row = mysqli_fetch_assoc($res1)) {
                                ?>
                                <tr> <?php $prog = $row["program"]; ?>
                                    <th><?php echo $prog; ?></th>
                                    <td> <?php
                                        $sum_nume = 0;
                                        $sum_deno = 0;
                                        for ($x = 0; $x < 3; $x++) {
                                            $field = 'vcs201_attendees_total';
                                            $query = "SELECT $field FROM dsw_per_vcs_attendees WHERE program = '$prog' AND year = '$year' AND month = '$quarter_val[$x]'";
                                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                            $deno = mysqli_affected_rows($mysqli);
                                            $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_vcs_attendees WHERE program = '$prog' AND year = '$year' AND month = '$quarter_val[$x]'";
                                            $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
                                            $row2 = mysqli_fetch_assoc($result1);
                                            $nume = $row2['denominator'];
                                            $sum_nume += $nume;
                                            $sum_deno += $deno;
                                        }
                                        if ($sum_deno == 0) {
                                            echo "";
                                        } else {
                                            $ans = round(($sum_nume / $sum_deno), 0);
                                            echo $ans;
                                        }
                                        ?>
                                    </td> 
                                </tr> 

                            <?php }
                            ?>

                            <tr>
                                <th>Average</th>
                                <th><?php
                                    $sum_nume2 = 0;
                                    $sum_deno2 = 0;
                                    for ($x = 0; $x < 3; $x++) {
                                        $field2 = 'vcs201_attendees_total';
                                        $query2 = "SELECT $field2 FROM dsw_per_vcs_attendees WHERE country='$country_val' AND year = '$year' AND month = '$quarter_val[$x]'";
                                        $result2 = mysqli_query($mysqli, $query2) or die(mysqli_query($mysqli));
                                        $deno2 = mysqli_affected_rows($mysqli);
                                        $query3 = "SELECT SUM($field2) AS denominator FROM dsw_per_vcs_attendees WHERE country='$country_val' AND year = '$year' AND month = '$quarter_val[$x]'";
                                        $result3 = mysqli_query($mysqli, $query3) or die(mysqli_query($mysqli));
                                        $row3 = mysqli_fetch_assoc($result3);
                                        $nume3 = $row3['denominator'];
                                        $sum_nume2 += $nume3;
                                        $sum_deno2 += $deno2;
                                    }
                                    if ($sum_deno2 == 0) {
                                        echo "";
                                    } else {
                                        $ans = round(($sum_nume2 / $sum_deno2), 0);
                                        echo $ans;
                                    }
                                    ?></th> 
                            </tr>

                        </table>
<!--                        <p style="clear: both" class="text_foot">
                            *Absence of a program in the CEM and/or VCS tables means that no CEM attendees and/or VCS attendees data for the program exists between 2012
                            - present year.
                        </p>-->
                        <?php
                    }
                }
                ?>
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

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="file">Filename:</label>
                                <input type="file" name="file" id="file" class="form-control"/>   
                            </div>                                        
                            <div class="form-group">
                                <input type="hidden" name="table_name" value="CEM attendees table">
                                <input type="submit" id='btnEmpty' name="clearbtn1" value="Empty Table" class="btn-custom-small-normal"/>
                                <input type="submit" id='btnSubmit' name="uploadCSV" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>
                            </div>
                            <div class="form-group">
                                <p><u>Note</u>: Before Upload, Empty the table by clicking on the above button</p>                                                           
                            </div>
                        </form>
                    </center>
                    <br/>
                    <center>
                        <div>
                            <a href="#close" class="" > Close</a>
                        </div>
                    </center>
                </div>
            </div>

            <div id="importCSV2" class="modalDialog">
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
                                    <input type="hidden" name="table_name" value="VCS attendees table">
                                    <input type="submit" id='btnEmpty' name="clearbtn2" value="Empty Table" class="btn-custom-small-normal"/>
                                    <input type="submit" id='btnSubmit' name="2uploadCSV2" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>
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
<?php
mysqli_close($mysqli);
?>