<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");

$sql_m_y = "(SELECT DISTINCT year FROM dsw_per_cem_attendees WHERE country='$country_val') 
                    UNION (SELECT DISTINCT year FROM `dsw_per_vcs_attendees` WHERE country='$country_val')
                    UNION (SELECT DISTINCT year FROM `dsw_per_lsm` WHERE country='$country_val')
                    UNION (SELECT DISTINCT year FROM `dsw_per_chlorine` WHERE country='$country_val')
                    UNION (SELECT DISTINCT year FROM `dispenser_database` WHERE country='$country_val')
                    UNION (SELECT DISTINCT year FROM `dsw_per_verification` WHERE country='$country_val') ORDER BY year DESC";
$result_m_y = mysqli_query($mysqli, $sql_m_y);
//        ############################################################ Assigning value to both month and year ####################################################
$query_lsm_header = "SELECT MIN(year), MAX(year) FROM dsw_per_lsm WHERE country='$country_val'";
$result_lsm_header = mysqli_query($mysqli, $query_lsm_header) or die(mysqli_query($mysqli));
$row_lsm_header = mysqli_fetch_assoc($result_lsm_header);
//        $min_lsm_year = $row_lsm_header['MIN(year)'];
$min_lsm_year = '';
$max_lsm_year = $row_lsm_header['MAX(year)'];
$query_lsm_header1 = "SELECT MIN(month) FROM dsw_per_lsm WHERE year ='$min_lsm_year'";
$result_lsm_header1 = mysqli_query($mysqli, $query_lsm_header1) or die(mysqli_query($mysqli));
$row_lsm_header1 = mysqli_fetch_assoc($result_lsm_header1);
$min_lsm_month = $row_lsm_header1['MIN(month)'];
$query_lsm_header2 = "SELECT MAX(month) FROM dsw_per_lsm WHERE year ='$max_lsm_year'";
$result_lsm_header2 = mysqli_query($mysqli, $query_lsm_header2) or die(mysqli_query($mysqli));
$row_lsm_header2 = mysqli_fetch_assoc($result_lsm_header2);
$max_lsm_month = $row_lsm_header2['MAX(month)'];


$query_ver_header = "SELECT MIN(year), MAX(year) FROM dsw_per_verification WHERE country='$country_val'";
$result_ver_header = mysqli_query($mysqli, $query_ver_header) or die(mysqli_query($mysqli));
$row_ver_header = mysqli_fetch_assoc($result_ver_header);
$min_ver_year = $row_ver_header['MIN(year)'];
$max_ver_year = $row_ver_header['MAX(year)'];
$query_ver_header1 = "SELECT MIN(month) FROM dsw_per_verification WHERE year ='$min_ver_year'";
$result_ver_header1 = mysqli_query($mysqli, $query_ver_header1) or die(mysqli_query($mysqli));
$row_ver_header1 = mysqli_fetch_assoc($result_ver_header1);
$min_ver_month = $row_ver_header1['MIN(month)'];
$query_ver_header2 = "SELECT MAX(month) FROM dsw_per_verification WHERE year ='$max_ver_year'";
$result_ver_header2 = mysqli_query($mysqli, $query_ver_header2) or die(mysqli_query($mysqli));
$row_ver_header2 = mysqli_fetch_assoc($result_ver_header2);
$max_ver_month = $row_ver_header2['MAX(month)'];

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

$query_instal_header = "SELECT MIN(year), MAX(year) FROM dispenser_database WHERE country='$country_val'";
$result_instal_header = mysqli_query($mysqli, $query_instal_header) or die(mysqli_query($mysqli));
$row_instal_header = mysqli_fetch_assoc($result_instal_header);
$min_instal_year = $row_instal_header['MIN(year)'];
$max_instal_year = $row_instal_header['MAX(year)'];
$query_instal_header1 = "SELECT MIN(month) FROM dispenser_database WHERE year ='$min_instal_year'";
$result_instal_header1 = mysqli_query($mysqli, $query_instal_header1) or die(mysqli_query($mysqli));
$row_instal_header1 = mysqli_fetch_assoc($result_instal_header1);
$min_instal_month = $row_instal_header1['MIN(month)'];
$query_instal_header2 = "SELECT MAX(month) FROM dispenser_database WHERE year ='$max_instal_year'";
$result_instal_header2 = mysqli_query($mysqli, $query_instal_header2) or die(mysqli_query($mysqli));
$row_instal_header2 = mysqli_fetch_assoc($result_instal_header2);
$max_instal_month = $row_instal_header2['MAX(month)'];

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

$query_chlo_header = "SELECT MIN(year), MAX(year) FROM dsw_per_chlorine WHERE country='$country_val'";
$result_chlo_header = mysqli_query($mysqli, $query_chlo_header) or die(mysqli_query($mysqli));
$row_chlo_header = mysqli_fetch_assoc($result_chlo_header);
$min_chlo_year = $row_chlo_header['MIN(year)'];
$max_chlo_year = $row_chlo_header['MAX(year)'];
$query_chlo_header1 = "SELECT MIN(month) FROM dsw_per_chlorine WHERE year ='$min_chlo_year'";
$result_chlo_header1 = mysqli_query($mysqli, $query_chlo_header1) or die(mysqli_query($mysqli));
$row_chlo_header1 = mysqli_fetch_assoc($result_chlo_header1);
$min_chlo_month = $row_chlo_header1['MIN(month)'];
$query_chlo_header2 = "SELECT MAX(month) FROM dsw_per_chlorine WHERE year ='$max_chlo_year'";
$result_chlo_header2 = mysqli_query($mysqli, $query_chlo_header2) or die(mysqli_query($mysqli));
$row_chlo_header2 = mysqli_fetch_assoc($result_chlo_header2);
$max_chlo_month = $row_chlo_header2['MAX(month)'];
if ($min_lsm_year == '') {
    $min_lsm_year = 3000;
}
if ($min_vcs_year == '') {
    $min_vcs_year = 3000;
}
if ($min_ver_year == '') {
    $min_ver_year = 3000;
}
if ($min_instal_year == '') {
    $min_instal_year = 3000;
}
if ($min_cem_year == '') {
    $min_cem_year = 3000;
}
if ($min_chlo_year == '') {
    $min_chlo_year = 3000;
}
$min_par_year = MIN($min_lsm_year, $min_vcs_year, $min_ver_year, $min_instal_year, $min_cem_year, $min_chlo_year);
$max_par_year = MAX($max_lsm_year, $max_vcs_year, $max_ver_year, $max_instal_year, $max_cem_year, $max_chlo_year);

if ($min_par_year == $min_lsm_year) {
    $min_par_month = $min_lsm_month;
} else if ($min_par_year == $min_vcs_year) {
    $min_par_month = $min_vcs_month;
} else if ($min_par_year == $min_ver_year) {
    $min_par_month = $min_ver_month;
} else if ($min_par_year == $min_instal_year) {
    $min_par_month = $min_instal_month;
} else if ($min_par_year == $min_cem_year) {
    $min_par_month = $min_cem_month;
} else if ($min_par_year == $min_chlo_year) {
    $min_par_month = $min_chlo_month;
} else {
    $min_par_month = 0;
}
if (0 < $min_par_month && $min_par_month < 13) {
    $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    $disp_min_par_month = $month_names[$min_par_month];
} else {
    $disp_min_par_month = 'no month';
}

if ($max_par_year == $max_lsm_year) {
    $max_par_month = $max_lsm_month;
} else if ($max_par_year == $max_vcs_year) {
    $max_par_month = $max_vcs_month;
} else if ($max_par_year == $max_ver_year) {
    $max_par_month = $max_ver_month;
} else if ($max_par_year == $max_instal_year) {
    $max_par_month = $max_instal_month;
} else if ($max_par_year == $max_cem_year) {
    $max_par_month = $max_cem_month;
} else if ($max_par_year == $max_chlo_year) {
    $max_par_month = $max_chlo_month;
} else {
    $max_par_month = 0;
}

if (isset($_GET["submit_month"])) {
    $month = $_GET["month_select"];
    $year_m = $_GET["year_select_m"];
    $month_q = $month;
    $year_q = $year_m;
    $year_q_ = $year_q - 1;
    $year_m_ = $year_m - 1;
    $year = $year_m;
} else {
    $month = $max_par_month;
    $result_m_y1 = mysqli_query($mysqli, $sql_m_y);
    $initial = mysqli_fetch_assoc($result_m_y1);
    $year_m = $year_q = $year = $initial['year'];
    $month_q = $max_par_month;
    $year_m_ = $year_m - 1;
    $year_q_ = $year_q - 1;
}

if (0 < $month && $month < 13) {
    $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    if ($month == 1) {
        $disp_month = 'Jan';
        $disp_month_range = 'Nov ' . $year_m_ . ' - Jan ' . $year_m;
    } elseif ($month == 2) {
        $disp_month = 'Feb';
        $disp_month_range = 'Dec ' . $year_m_ . ' - Feb ' . $year_m;
    } else {
        $disp_month = $month_names[$month];
        $disp_month_start = $month_names[$month - 2];
        $disp_month_range = $disp_month_start . ' ' . $year_m . ' - ' . $disp_month . ' ' . $year_m;
    }
} else {
    $disp_month = 'No Month';
    $disp_month_range = 'No Month, No Year';
}

$image = new image;
$insertFile = new UploadFIle;

if (isset($_POST['uploadCSV'])) {

    $table = "dsw_per_lsm";
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
}

if (isset($_POST['2uploadCSV2'])) {

    $table = "dsw_per_instalation";
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
}

if (isset($_POST['clearbtn1'])) {

    $table = "dsw_per_lsm";
    $query = "DELETE FROM $table WHERE country = '$country_val' AND YEAR = '$year_m' ";
    if (mysqli_query($mysqli, $query)) {
        $csvMessage = "Table Emptied, Browse File then Upload";
        $table_name = $_POST['table_name'];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = $table_name . ' emptied';
        $description = 'year ' . $year_m . ' records deleted';
        $sql_add = "INSERT INTO performance_log_record (country, user_name, email, action, description) 
                        VALUES ( '$country_val', '$user_name', '$email', '$action', '$description')";
        mysqli_query($mysqli, $sql_add) or die(mysqli_query($mysqli));
    } else {
        $csvMessage = "fail";
    }
}
if (isset($_POST['clearbtn2'])) {

    $table = "dsw_per_instalation";
    $query = "DELETE FROM $table WHERE country = '$country_val' AND YEAR = '$year_m' ";
    if (mysqli_query($mysqli, $query)) {
        $csvMessage = "Table Emptied, Browse File then Upload";
        $table_name = $_POST['table_name'];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = $table_name . ' emptied';
        $description = 'year ' . $year_m . ' records deleted';
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

        <ul class="list-unstyled list-inline" style='float: left'>
            <a class="btn btn-primary" href="#importCSV"><span class="glyphicon glyphicon-download-alt" ></span> IMPORT LSM Table</a>
            <a class="btn btn-primary" href="#importCSV2"><span class="glyphicon glyphicon-download-alt" ></span> IMPORT Instalation Table</a> Laast Updated 18/07/2016
        </ul>       

        <div class="btn-group pull-right">            
            <form method="POST" action="export/exp_mee.php">            
                <input type="hidden" name="rec_year" value="<?php echo $year; ?>" />
                <input type="hidden" name="rec_year_m" value="<?php echo $year_m; ?>" />
                <input type="hidden" name="rec_month_q" value="<?php echo $month_q; ?>" />
                <input type="hidden" name="rec_year_q" value="<?php echo $year_q; ?>" />
                <input type="hidden" name="rec_year_q_" value="<?php echo $year_q_; ?>" />
                <input type="hidden" name="rec_month" value="<?php echo $month; ?>" />
                <input type="hidden" name="rec_country" value="<?php echo $country_val; ?>" />
                <input class="btn btn-primary" type="submit" name="" value="Export CSV">
            </form>    
        </div>
        <div style='clear:both'>
            <form method="$_GET" > 
                <select style="width:100px; height: 34px" name="month_select" id="month_select">
                    <option value='1' <?php if ($month == '1') echo 'selected'; ?>>January</option>
                    <option value='2' <?php if ($month == '2') echo 'selected'; ?>>February</option>
                    <option value='3' <?php if ($month == '3') echo 'selected'; ?>>March</option>
                    <option value='4' <?php if ($month == '4') echo 'selected'; ?>>April</option>
                    <option value='5' <?php if ($month == '5') echo 'selected'; ?>>May</option>
                    <option value='6' <?php if ($month == '6') echo 'selected'; ?>>June</option>
                    <option value='7' <?php if ($month == '7') echo 'selected'; ?>>July</option>
                    <option value='8' <?php if ($month == '8') echo 'selected'; ?>>August</option>
                    <option value='9' <?php if ($month == '9') echo 'selected'; ?>>September</option>
                    <option value='10' <?php if ($month == '10') echo 'selected'; ?>>October</option>
                    <option value='11' <?php if ($month == '11') echo 'selected'; ?>>November</option>
                    <option value='12' <?php if ($month == '12') echo 'selected'; ?>>December</option>                                
                </select>
                <select style="width:70px; height: 34px" name="year_select_m" id="year_select">
                    <?php
                    while ($rows_m_y = mysqli_fetch_assoc($result_m_y)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows_m_y['year']; ?>"<?php if ($year_m == $rows_m_y['year']) echo 'selected'; ?>>
                            <?php echo $rows_m_y['year']; ?></option>
                    <?php } ?>
                </select>
                <input class="btn btn-primary" type="submit" name="submit_month" id="submit_month" value="CHOOSE MONTH">
            </form>
        </div> 
        <div class="table-responsive">
            <h3>Operation's Meetings Table</h3>
            <p class="text_title">The Meeting Table describes the number of operational meetings and chlorine deliveries made across DSW
                offices for the period between <?php echo $disp_min_par_month . ' ' . $min_par_year . ' and ' . $disp_month . ' ' . $year_m; ?>. 
                Figures cover the most recent month, the last 3 months, the year to date and cumulative data for each office.<p>  
            <div class="fakeContainer">
                <table id="demoTable" class="demoTable table table-bordered table-striped table-hover">
                    <tr>
                        <th style="min-width: 110px; text-align: center" rowspan="2">DSW MIS report</th>
                        <th  colspan="6">Monthly reporting period: <?php echo $disp_month . ' ' . $year_m; ?>                        
                        </th>
                        <th  colspan="6">Quarterly reporting period:
                            <?php echo $disp_month_range; ?> 
                        </th>
                        <th  colspan="6">Yearly reporting period: 
                            <?php echo 'Jan ' . $year_m . ' - ' . $disp_month . ' ' . $year_m; ?> </th>
                        <th  colspan="6">Cumulative reporting period <?php echo $disp_min_par_month . ' ' . $min_par_year . ' - ' . $disp_month . ' ' . $year_m; ?></th>
                    </tr>
                    <tr>
                        <td style="text-align: center">LSMs held(#)</td>
                        <td style="text-align: center">WPs verified (#)</td>
                        <td style="text-align: center">VCSs held (#)</td>
                        <td style="text-align: center">CDSs installed (#)</td>
                        <td style="text-align: center">CEMs held (#)</td>
                        <td style="text-align: center">Deliveries (# visits)</td>

                        <td style="text-align: center">LSMs held(#)</td>
                        <td style="text-align: center">WPs verified (#)</td>
                        <td style="text-align: center">VCSs held (#)</td>
                        <td style="text-align: center">CDSs installed (#)</td>
                        <td style="text-align: center">CEMs held (#)</td>
                        <td style="text-align: center">Deliveries (# visits)</td>

                        <td style="text-align: center">LSMs held(#)</td>
                        <td style="text-align: center">WPs verified (#)</td>
                        <td style="text-align: center">VCSs held (#)</td>
                        <td style="text-align: center">CDSs installed (#)</td>
                        <td style="text-align: center">CEMs held (#)</td>
                        <td style="text-align: center">Deliveries (# visits)</td>

                        <td style="text-align: center">LSMs held(#)</td>
                        <td style="text-align: center">WPs verified (#)</td>
                        <td style="text-align: center">VCSs held (#)</td>
                        <td style="text-align: center">CDSs installed (#)</td>
                        <td style="text-align: center">CEMs held (#)</td>
                        <td style="text-align: center">Deliveries (# visits)</td>
                    </tr>                    
                    <?php
                    $res = mysqli_query($mysqli, "(SELECT distinct program FROM `dsw_per_cem_attendees` WHERE country='$country_val')
                    UNION (SELECT distinct program FROM `dsw_per_vcs_attendees` WHERE country='$country_val')
                    UNION (SELECT distinct program FROM `dsw_per_lsm` WHERE country='$country_val')
                    UNION (SELECT distinct program_name FROM `dispenser_database` WHERE country='$country_val')
                    UNION (SELECT distinct program FROM `dsw_per_verification` WHERE country='$country_val')
                    UNION (SELECT distinct program FROM `dsw_per_chlorine` WHERE country='$country_val') ORDER BY program");

                    $value_m_lsm_total = 0;
                    $value_m_ver_total = 0;
                    $value_m_vcs_total = 0;
                    $value_m_instaslation_total = 0;
                    $value_m_cem_total = 0;
                    $value_m_chlorine_total = 0;
                    $value_q_lsm_total = 0;
                    $value_q_ver_total = 0;
                    $value_q_vcs_total = 0;
                    $value_q_instaslation_total = 0;
                    $value_q_cem_total = 0;
                    $value_q_chlorine_total = 0;
                    $value_y_lsm_total = 0;
                    $value_y_ver_total = 0;
                    $value_y_vcs_total = 0;
                    $value_y_instaslation_total = 0;
                    $value_y_cem_total = 0;
                    $value_y_chlorine_total = 0;
                    $value_lsm_total = 0;
                    $value_ver_total = 0;
                    $value_vcs_total = 0;
                    $value_instaslation_total = 0;
                    $value_cem_total = 0;
                    $value_chlorine_total = 0;
                    while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <!--======================================================monthly reporting===============================================-->
                        <tr> <?php $prog = $row["program"]; ?>
                            <th><?php echo $prog; ?></th> 
                            <td>
                                <?php
                                $query_m_lsm = "SELECT month FROM dsw_per_lsm WHERE program = '$prog' AND month = '$month' AND year = '$year_m'";
                                $result_m_lsm = mysqli_query($mysqli, $query_m_lsm) or die(mysqli_query($mysqli));
                                $value_m_lsm = mysqli_affected_rows($mysqli);
                                if ($value_m_lsm == 0) {
                                    echo "";
                                } else {
                                    echo $value_m_lsm;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_m_ver = "SELECT month FROM dsw_per_verification WHERE program = '$prog' AND month = '$month' AND year = '$year_m'";
                                $result_m_ver = mysqli_query($mysqli, $query_m_ver) or die(mysqli_query($mysqli));
                                $value_m_ver = mysqli_affected_rows($mysqli);
                                if ($value_m_ver == 0) {
                                    echo "";
                                } else {
                                    echo $value_m_ver;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_m_vcs = "SELECT month FROM dsw_per_vcs_attendees WHERE program = '$prog' AND month = '$month' AND year = '$year_m'";
                                $result_m_vcs = mysqli_query($mysqli, $query_m_vcs) or die(mysqli_query($mysqli));
                                $value_m_vcs = mysqli_affected_rows($mysqli);
                                if ($value_m_vcs == 0) {
                                    echo "";
                                } else {
                                    echo $value_m_vcs;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_m_instaslation = "SELECT month FROM dispenser_database WHERE program_name = '$prog' AND month = '$month' AND year = '$year_m'";
                                $result_m_instaslation = mysqli_query($mysqli, $query_m_instaslation) or die(mysqli_query($mysqli));
                                $value_m_instaslation = mysqli_affected_rows($mysqli);
                                if ($value_m_instaslation == 0) {
                                    echo "";
                                } else {
                                    echo $value_m_instaslation;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_m_cem = "SELECT month FROM dsw_per_cem_attendees WHERE program = '$prog' AND month = '$month' AND year = '$year_m'";
                                $result_m_cem = mysqli_query($mysqli, $query_m_cem) or die(mysqli_query($mysqli));
                                $value_m_cem = mysqli_affected_rows($mysqli);
                                if ($value_m_cem == 0) {
                                    echo "";
                                } else {
                                    echo $value_m_cem;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_m_chlorine1 = "SELECT month FROM dsw_per_chlorine WHERE program = '$prog' AND month = '$month' AND year = '$year_m'";
                                $result_m_chlorine1 = mysqli_query($mysqli, $query_m_chlorine1) or die(mysqli_query($mysqli));
                                $value_m_chlorine = mysqli_affected_rows($mysqli);
                                if ($value_m_chlorine == 0) {
                                    echo "";
                                } else {
                                    echo $value_m_chlorine;
                                }
                                ?>
                            </td>
                            <!--===============================================quarter reporting=======================================-->
                            <?php
                            if ($month_q == '1') {
                                $month_q1 = '11';
                                $month_q2 = '12';
                                $month_q3 = $month_q;
                                $year_q1 = $year_q2 = $year_q_;
                                $year_q3 = $year_q;
                            } else if ($month_q == '2') {
                                $month_q1 = '12';
                                $month_q2 = $month_q - 1;
                                $month_q3 = $month_q;
                                $year_q1 = $year_q_;
                                $year_q2 = $year_q3 = $year_q;
                            } else {
                                $month_q1 = $month_q - 2;
                                $month_q2 = $month_q - 1;
                                $month_q3 = $month_q;
                                $year_q1 = $year_q2 = $year_q3 = $year_q;
                            }
                            ?>
                            <td>
                                <?php
                                $query_q_lsm1 = "SELECT month FROM dsw_per_lsm WHERE program = '$prog' AND month = '$month_q1'  AND year = '$year_q1'";
                                $result_q_lsm1 = mysqli_query($mysqli, $query_q_lsm1) or die(mysqli_query($mysqli));
                                $value_q_lsm1 = mysqli_affected_rows($mysqli);
                                $query_q_lsm2 = "SELECT month FROM dsw_per_lsm WHERE program = '$prog' AND month = '$month_q2'  AND year = '$year_q2'";
                                $result_q_lsm2 = mysqli_query($mysqli, $query_q_lsm2) or die(mysqli_query($mysqli));
                                $value_q_lsm2 = mysqli_affected_rows($mysqli);
                                $query_q_lsm3 = "SELECT month FROM dsw_per_lsm WHERE program = '$prog' AND month = '$month_q3'  AND year = '$year_q3'";
                                $result_q_lsm3 = mysqli_query($mysqli, $query_q_lsm3) or die(mysqli_query($mysqli));
                                $value_q_lsm3 = mysqli_affected_rows($mysqli);
                                $value_q_lsm = $value_q_lsm1 + $value_q_lsm2 + $value_q_lsm3;
                                if ($value_q_lsm == 0) {
                                    echo "";
                                } else {
                                    echo $value_q_lsm;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_q_ver1 = "SELECT month FROM dsw_per_verification WHERE program = '$prog' AND month = '$month_q1'  AND year = '$year_q1'";
                                $result_q_ver1 = mysqli_query($mysqli, $query_q_ver1) or die(mysqli_query($mysqli));
                                $value_q_ver1 = mysqli_affected_rows($mysqli);
                                $query_q_ver2 = "SELECT month FROM dsw_per_verification WHERE program = '$prog' AND month = '$month_q2'  AND year = '$year_q2'";
                                $result_q_ver2 = mysqli_query($mysqli, $query_q_ver2) or die(mysqli_query($mysqli));
                                $value_q_ver2 = mysqli_affected_rows($mysqli);
                                $query_q_ver3 = "SELECT month FROM dsw_per_verification WHERE program = '$prog' AND month = '$month_q3'  AND year = '$year_q3'";
                                $result_q_ver3 = mysqli_query($mysqli, $query_q_ver3) or die(mysqli_query($mysqli));
                                $value_q_ver3 = mysqli_affected_rows($mysqli);
                                $value_q_ver = $value_q_ver1 + $value_q_ver2 + $value_q_ver3;
                                if ($value_q_ver == 0) {
                                    echo "";
                                } else {
                                    echo $value_q_ver;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_q_vcs1 = "SELECT month FROM dsw_per_vcs_attendees WHERE program = '$prog' AND month = '$month_q1'  AND year = '$year_q1'";
                                $result_q_vcs1 = mysqli_query($mysqli, $query_q_vcs1) or die(mysqli_query($mysqli));
                                $value_q_vcs1 = mysqli_affected_rows($mysqli);
                                $query_q_vcs2 = "SELECT month FROM dsw_per_vcs_attendees WHERE program = '$prog' AND month = '$month_q2'  AND year = '$year_q2'";
                                $result_q_vcs2 = mysqli_query($mysqli, $query_q_vcs2) or die(mysqli_query($mysqli));
                                $value_q_vcs2 = mysqli_affected_rows($mysqli);
                                $query_q_vcs3 = "SELECT month FROM dsw_per_vcs_attendees WHERE program = '$prog' AND month = '$month_q3'  AND year = '$year_q3'";
                                $result_q_vcs3 = mysqli_query($mysqli, $query_q_vcs3) or die(mysqli_query($mysqli));
                                $value_q_vcs3 = mysqli_affected_rows($mysqli);
                                $value_q_vcs = $value_q_vcs1 + $value_q_vcs2 + $value_q_vcs3;
                                if ($value_q_vcs == 0) {
                                    echo "";
                                } else {
                                    echo $value_q_vcs;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_q_instal1 = "SELECT month FROM dispenser_database WHERE program_name = '$prog' AND month = '$month_q1'  AND year = '$year_q1'";
                                $result_q_instal1 = mysqli_query($mysqli, $query_q_instal1) or die(mysqli_query($mysqli));
                                $value_q_instal1 = mysqli_affected_rows($mysqli);
                                $query_q_instal2 = "SELECT month FROM dispenser_database WHERE program_name = '$prog' AND month = '$month_q2'  AND year = '$year_q2'";
                                $result_q_instal2 = mysqli_query($mysqli, $query_q_instal2) or die(mysqli_query($mysqli));
                                $value_q_instal2 = mysqli_affected_rows($mysqli);
                                $query_q_instal3 = "SELECT month FROM dispenser_database WHERE program_name = '$prog' AND month = '$month_q3'  AND year = '$year_q3'";
                                $result_q_instal3 = mysqli_query($mysqli, $query_q_instal3) or die(mysqli_query($mysqli));
                                $value_q_instal3 = mysqli_affected_rows($mysqli);
                                $value_q_instal = $value_q_instal1 + $value_q_instal2 + $value_q_instal3;
                                if ($value_q_instal == 0) {
                                    echo "";
                                } else {
                                    echo $value_q_instal;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_q_cem1 = "SELECT month FROM dsw_per_cem_attendees WHERE program = '$prog' AND month = '$month_q1'  AND year = '$year_q1'";
                                $result_q_cem1 = mysqli_query($mysqli, $query_q_cem1) or die(mysqli_query($mysqli));
                                $value_q_cem1 = mysqli_affected_rows($mysqli);
                                $query_q_cem2 = "SELECT month FROM dsw_per_cem_attendees WHERE program = '$prog' AND month = '$month_q2'  AND year = '$year_q2'";
                                $result_q_cem2 = mysqli_query($mysqli, $query_q_cem2) or die(mysqli_query($mysqli));
                                $value_q_cem2 = mysqli_affected_rows($mysqli);
                                $query_q_cem3 = "SELECT month FROM dsw_per_cem_attendees WHERE program = '$prog' AND month = '$month_q3'  AND year = '$year_q3'";
                                $result_q_cem3 = mysqli_query($mysqli, $query_q_cem3) or die(mysqli_query($mysqli));
                                $value_q_cem3 = mysqli_affected_rows($mysqli);
                                $value_q_cem = $value_q_cem1 + $value_q_cem2 + $value_q_cem3;
                                if ($value_q_cem == 0) {
                                    echo "";
                                } else {
                                    echo $value_q_cem;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_q_chlorine11 = "SELECT month FROM dsw_per_chlorine WHERE program = '$prog' AND month = '$month_q1'  AND year = '$year_q1'";
                                $result_q_chlorine11 = mysqli_query($mysqli, $query_q_chlorine11) or die(mysqli_query($mysqli));
                                $value_q_chlorine11 = mysqli_affected_rows($mysqli);
                                $query_q_chlorine12 = "SELECT month FROM dsw_per_chlorine WHERE program = '$prog' AND month = '$month_q2'  AND year = '$year_q2'";
                                $result_q_chlorine12 = mysqli_query($mysqli, $query_q_chlorine12) or die(mysqli_query($mysqli));
                                $value_q_chlorine12 = mysqli_affected_rows($mysqli);
                                $query_q_chlorine13 = "SELECT month FROM dsw_per_chlorine WHERE program = '$prog' AND month = '$month_q3'  AND year = '$year_q3'";
                                $result_q_chlorine13 = mysqli_query($mysqli, $query_q_chlorine13) or die(mysqli_query($mysqli));
                                $value_q_chlorine13 = mysqli_affected_rows($mysqli);
                                $value_q_chlorine = $value_q_chlorine11 + $value_q_chlorine12 + $value_q_chlorine13;
                                if ($value_q_chlorine == 0) {
                                    echo "";
                                } else {
                                    echo $value_q_chlorine;
                                }
                                ?>
                            </td>
                            <!--================================ year reporting ==========================================-->
                            <td>
                                <?php
                                $query_y_lsm = "SELECT month FROM dsw_per_lsm WHERE program = '$prog' AND year = '$year' AND month <= '$month'";
                                $result_y_lsm = mysqli_query($mysqli, $query_y_lsm) or die(mysqli_query($mysqli));
                                $value_y_lsm = mysqli_affected_rows($mysqli);
                                if ($value_y_lsm == 0) {
                                    echo "";
                                } else {
                                    echo $value_y_lsm;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_y_ver = "SELECT month FROM dsw_per_verification WHERE program = '$prog' AND year = '$year' AND month <= '$month'";
                                $result_y_ver = mysqli_query($mysqli, $query_y_ver) or die(mysqli_query($mysqli));
                                $value_y_ver = mysqli_affected_rows($mysqli);
                                if ($value_y_ver == 0) {
                                    echo "";
                                } else {
                                    echo $value_y_ver;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_y_vcs = "SELECT month FROM dsw_per_vcs_attendees WHERE program = '$prog' AND year = '$year' AND month <= '$month'";
                                $result_y_vcs = mysqli_query($mysqli, $query_y_vcs) or die(mysqli_query($mysqli));
                                $value_y_vcs = mysqli_affected_rows($mysqli);
                                if ($value_y_vcs == 0) {
                                    echo "";
                                } else {
                                    echo $value_y_vcs;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_y_instaslation = "SELECT month FROM dispenser_database WHERE program_name = '$prog' AND year = '$year' AND month <= '$month'";
                                $result_y_instaslation = mysqli_query($mysqli, $query_y_instaslation) or die(mysqli_query($mysqli));
                                $value_y_instaslation = mysqli_affected_rows($mysqli);
                                if ($value_y_instaslation == 0) {
                                    echo "";
                                } else {
                                    echo $value_y_instaslation;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_y_cem = "SELECT month FROM dsw_per_cem_attendees WHERE program = '$prog' AND year = '$year' AND month <= '$month'";
                                $result_y_cem = mysqli_query($mysqli, $query_y_cem) or die(mysqli_query($mysqli));
                                $value_y_cem = mysqli_affected_rows($mysqli);
                                if ($value_y_cem == 0) {
                                    echo "";
                                } else {
                                    echo $value_y_cem;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_y_chlorine1 = "SELECT month FROM dsw_per_chlorine WHERE program = '$prog' AND year = '$year' AND month <= '$month'";
                                $result_y_chlorine1 = mysqli_query($mysqli, $query_y_chlorine1) or die(mysqli_query($mysqli));
                                $value_y_chlorine = mysqli_affected_rows($mysqli);
                                if ($value_y_chlorine == 0) {
                                    echo "";
                                } else {
                                    echo $value_y_chlorine;
                                }
                                ?>
                            </td>
                            <!--=====================================Cumulative========================================================-->
                            <td>
                                <?php
                                $query_lsm = "SELECT month FROM dsw_per_lsm WHERE program = '$prog' AND year < '$year'";
                                $result_lsm = mysqli_query($mysqli, $query_lsm) or die(mysqli_query($mysqli));
                                $value_lsm = mysqli_affected_rows($mysqli) + $value_y_lsm;
                                if ($value_lsm == 0) {
                                    echo "";
                                } else {
                                    echo $value_lsm;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_ver = "SELECT month FROM dsw_per_verification WHERE program = '$prog'  AND year < '$year'";
                                $result_ver = mysqli_query($mysqli, $query_ver) or die(mysqli_query($mysqli));
                                $value_ver = mysqli_affected_rows($mysqli) + $value_y_ver;
                                if ($value_ver == 0) {
                                    echo "";
                                } else {
                                    echo $value_ver;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_vcs = "SELECT month FROM dsw_per_vcs_attendees WHERE program = '$prog' AND year < '$year'";
                                $result_vcs = mysqli_query($mysqli, $query_vcs) or die(mysqli_query($mysqli));
                                $value_vcs = mysqli_affected_rows($mysqli) + $value_y_vcs;
                                if ($value_vcs == 0) {
                                    echo "";
                                } else {
                                    echo $value_vcs;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_instaslation = "SELECT month FROM dispenser_database WHERE program_name = '$prog' AND year < '$year'";
                                $result_instaslation = mysqli_query($mysqli, $query_instaslation) or die(mysqli_query($mysqli));
                                $value_instaslation = mysqli_affected_rows($mysqli) + $value_y_instaslation;
                                if ($value_instaslation == 0) {
                                    echo "";
                                } else {
                                    echo $value_instaslation;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_cem = "SELECT month FROM dsw_per_cem_attendees WHERE program = '$prog' AND year < '$year'";
                                $result_cem = mysqli_query($mysqli, $query_cem) or die(mysqli_query($mysqli));
                                $value_cem = mysqli_affected_rows($mysqli) + $value_y_cem;
                                if ($value_cem == 0) {
                                    echo "";
                                } else {
                                    echo $value_cem;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query_chlorine1 = "SELECT month FROM dsw_per_chlorine WHERE program = '$prog' AND year < '$year'";
                                $result_chlorine1 = mysqli_query($mysqli, $query_chlorine1) or die(mysqli_query($mysqli));
                                $value_chlorine = mysqli_affected_rows($mysqli) + $value_y_chlorine;
                                if ($value_chlorine == 0) {
                                    echo "";
                                } else {
                                    echo $value_chlorine;
                                }
                                ?>
                            </td></tr>

                        <?php
                        $value_m_lsm_total += $value_m_lsm;
                        $value_m_ver_total += $value_m_ver;
                        $value_m_vcs_total += $value_m_vcs;
                        $value_m_instaslation_total += $value_m_instaslation;
                        $value_m_cem_total += $value_m_cem;
                        $value_m_chlorine_total += $value_m_chlorine;
                        $value_q_lsm_total += $value_q_lsm;
                        $value_q_ver_total += $value_q_ver;
                        $value_q_vcs_total += $value_q_vcs;
                        $value_q_instaslation_total += $value_q_instal;
                        $value_q_cem_total += $value_q_cem;
                        $value_q_chlorine_total += $value_q_chlorine;
                        $value_y_lsm_total += $value_y_lsm;
                        $value_y_ver_total += $value_y_ver;
                        $value_y_vcs_total += $value_y_vcs;
                        $value_y_instaslation_total += $value_y_instaslation;
                        $value_y_cem_total += $value_y_cem;
                        $value_y_chlorine_total += $value_y_chlorine;
                        $value_lsm_total += $value_lsm;
                        $value_ver_total += $value_ver;
                        $value_vcs_total += $value_vcs;
                        $value_instaslation_total += $value_instaslation;
                        $value_cem_total += $value_cem;
                        $value_chlorine_total += $value_chlorine;
                    }
                    ?>
                    <tr>
                        <th>Total</th>
                        <th><?php echo $value_m_lsm_total ?></th>
                        <th><?php echo $value_m_ver_total ?></th>
                        <th><?php echo $value_m_vcs_total ?></th>
                        <th><?php echo $value_m_instaslation_total ?></th>
                        <th><?php echo $value_m_cem_total ?></th>
                        <th><?php echo $value_m_chlorine_total ?></th>
                        <th><?php echo $value_q_lsm_total ?></th>
                        <th><?php echo $value_q_ver_total ?></th>
                        <th><?php echo $value_q_vcs_total ?></th>
                        <th><?php echo $value_q_instaslation_total ?></th>
                        <th><?php echo $value_q_cem_total ?></th>
                        <th><?php echo $value_q_chlorine_total ?></th>
                        <th><?php echo $value_y_lsm_total ?></th>
                        <th><?php echo $value_y_ver_total ?></th>
                        <th><?php echo $value_y_vcs_total ?></th>
                        <th><?php echo $value_y_instaslation_total ?></th>
                        <th><?php echo $value_y_cem_total ?></th>
                        <th><?php echo $value_y_chlorine_total ?></th>
                        <th><?php echo $value_lsm_total ?></th>
                        <th><?php echo $value_ver_total ?></th>
                        <th><?php echo $value_vcs_total ?></th>
                        <th><?php echo $value_instaslation_total ?></th>
                        <th><?php echo $value_cem_total ?></th>
                        <th><?php echo $value_chlorine_total ?></th>
                    </tr>  
                </table>                  
            </div>
            <!--<p class="text_foot" style="margin-top: 15px;">*A blank indicates that no operation activity data exists for a particular program in that particular year.</p>-->
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
                                <input type="hidden" name="table_name" value="LSM table">
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
                                    <input type="hidden" name="table_name" value="Instalation table">
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
<script src="js/superTables.js" 
type=text/javascript></script>

<script type=text/javascript>

                                    (function() {
                                        var mySt = new superTable("demoTable", {
                                            cssSkin: "sSky",
                                            fixedCols: 1,
                                            headerRows: 2,
                                            onStart: function() {
                                                this.start = new Date();
                                            },
                                            onFinish: function() {
                                                document.getElementById("testDiv").innerHTML += "Finished...<br>" + ((new Date()) - this.start) + "ms.<br>";
                                            }
                                        });
                                    })();
</script>
</body>

</html>   
<?php
mysqli_close($mysqli);
?>