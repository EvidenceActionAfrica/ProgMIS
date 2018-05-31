<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");

$image = new image;
$insertFile = new UploadFIle;

if (isset($_POST['uploadCSV'])) {

    $table = " 	dsw_per_verification";
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

    $table = "dsw_per_verification";
    $query = "DELETE FROM $table WHERE country = '$country_val'";
    if (mysqli_query($mysqli, $query)) {
        $csvMessage = "Table Emptied, Browse File then Upload";
        $table_name = $_POST['table_name'];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = $table_name . ' emptied';
        $description = 'Some records deleted';
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
        <div class="clearfix" style='float: left'> 
            <a class="btn btn-primary" href="#importCSV"><span class="glyphicon glyphicon-download-alt" ></span> IMPORT CSV</a>
        Last Updated 18 October 2016</div>
        <div class="btn-group pull-right">
            <form method="POST" action="export/exp_ver.php">            
                 <input type="hidden" name="rec_country" value="<?php echo $country_val; ?>" />
              <input class="btn btn-primary" type="submit" name="" value="Export CSV"> 
              <span class="clearfix"></span>
            </form>
        </div>
        <br>
        <br>

        <div class="table-responsive">

            <h3>Verification Pass Rate</h3>
            <?php
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
            if ($min_ver_month == '')
                $disp_min_ver_month = 'No Month';
            if ($min_ver_month == '0')
                $disp_min_ver_month = '0 Month';
            if ($min_ver_month == '1')
                $disp_min_ver_month = 'Jan';
            if ($min_ver_month == '2')
                $disp_min_ver_month = 'Feb';
            if ($min_ver_month == '3')
                $disp_min_ver_month = 'Mar';
            if ($min_ver_month == '4')
                $disp_min_ver_month = 'Apr';
            if ($min_ver_month == '5')
                $disp_min_ver_month = 'May';
            if ($min_ver_month == '6')
                $disp_min_ver_month = 'Jun';
            if ($min_ver_month == '7')
                $disp_min_ver_month = 'Jul';
            if ($min_ver_month == '8')
                $disp_min_ver_month = 'Aug';
            if ($min_ver_month == '9')
                $disp_min_ver_month = 'Sep';
            if ($min_ver_month == '10')
                $disp_min_ver_month = 'Oct';
            if ($min_ver_month == '11')
                $disp_min_ver_month = 'Nov';
            if ($min_ver_month == '12')
                $disp_min_ver_month = 'Dec';
            if ($min_ver_month > '12')
                $disp_min_ver_month = 'No Month';

            if ($max_ver_month == '')
                $disp_max_ver_month = 'No Month';
            if ($max_ver_month == '0')
                $disp_max_ver_month = '0 Month';
            if ($max_ver_month == '1')
                $disp_max_ver_month = 'Jan';
            if ($max_ver_month == '2')
                $disp_max_ver_month = 'Feb';
            if ($max_ver_month == '3')
                $disp_max_ver_month = 'Mar';
            if ($max_ver_month == '4')
                $disp_max_ver_month = 'Apr';
            if ($max_ver_month == '5')
                $disp_max_ver_month = 'May';
            if ($max_ver_month == '6')
                $disp_max_ver_month = 'Jun';
            if ($max_ver_month == '7')
                $disp_max_ver_month = 'Jul';
            if ($max_ver_month == '8')
                $disp_max_ver_month = 'Aug';
            if ($max_ver_month == '9')
                $disp_max_ver_month = 'Sep';
            if ($max_ver_month == '10')
                $disp_max_ver_month = 'Oct';
            if ($max_ver_month == '11')
                $disp_max_ver_month = 'Nov';
            if ($max_ver_month == '12')
                $disp_max_ver_month = 'Dec';
            if ($max_ver_month > '12')
                $disp_max_ver_month = 'No Month';
            ?>
            <p class="text_title">The Verification Table gives a breakdown of waterpoints that were verified for dispenser installation across listed geographies/offices.
                Also provided are the number/percentage of waterpoints that did NOT qualify for dispenser installation and the reason for disqualification. 
                A total of <?php
                $query_title = "SELECT program FROM dsw_per_verification WHERE country='$country_val'";
                $result_title = mysqli_query($mysqli, $query_title) or die(mysqli_query($mysqli));
                $num_title = mysqli_affected_rows($mysqli);
                echo $num_title;
                ?>
                waterpoints have been verified across the listed installation rounds for the period starting <?php echo $disp_min_ver_month . ' ' . $min_ver_year; ?> to <?php echo $disp_max_ver_month . ' ' . $max_ver_year; ?>.</p>

            <table class="table table-bordered table-striped table-hover " >
                <tr>
                    <th class="heading " style=" width: 25%"><span class="plus">Expand</span></th>
                    <th class="heading " style=" width: 25%">Waterpoints visited</th>
                    <th class="heading " style=" width: 25%">Waterpoints failed/<br>%age</th>
                    <th class="heading " style=" width: 25%">Waterpoints passed/<br>%age</th>
                    <th class="content ">Fail flow rate/<br>%age</th>
                    <th class="content ">Fail lando. support/<br>%age</th>
                    <th class="content ">Fail not drink water/<br>%age</th>
                    <th class="content ">Fail turbidity/<br>%age</th>
                    <th class="content ">Fail No months/<br>%age</th>
                    <th class="content ">Fail No Households/<br>%age</th>
                    <th class="content ">Fail other/<br>%age</th>
                </tr>

                <?php
                $field = 'program';
                $res = mysqli_query($mysqli, "SELECT distinct $field FROM `dsw_per_verification`  WHERE country='$country_val' ORDER BY program");
                while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                    <tr> <?php $prog = $row["program"]; ?>
                        <th class="heading " style=" width: 25%"><?php echo $prog; ?></th> 

                        <td class="heading " style=" width: 25%"><?php
                            $query = "SELECT $field FROM dsw_per_verification WHERE program = '$prog'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $num = mysqli_affected_rows($mysqli);
                            echo $num;
                            ?></td>
                        <td class="heading " style=" width: 25%"><?php
                            $query_fail = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND pass_fail = '0'";
                            $result_fail = mysqli_query($mysqli, $query_fail) or die(mysqli_query($mysqli));
                            $num_fail = mysqli_affected_rows($mysqli);
                            echo $num_fail;
                            echo '<br>';
                            echo round(($num_fail / $num * 100), 0) . "%";
                            ?></td>
                        <td class="heading " style=" width: 25%"><?php
                            $query_pass = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND pass_fail = '1' ";
                            $result_pass = mysqli_query($mysqli, $query_pass) or die(mysqli_query($mysqli));
                            $num_pass = mysqli_affected_rows($mysqli);
                            echo $num_pass;
                            echo '<br>';
                            echo round(($num_pass / $num * 100), 0) . "%";
                            ?></td>
                        <td class="content "><?php
                            $query_flow_rate = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND t301b_wpt_flow_rate_slow= '0'";
                            $result_flow_rate = mysqli_query($mysqli, $query_flow_rate) or die(mysqli_query($mysqli));
                            $num_flow_rate = mysqli_affected_rows($mysqli);
                            echo $num_flow_rate;
                            echo '<br>';
                            echo round(($num_flow_rate / $num * 100), 0) . "%";
                            ?></td> 
                        <td class="content "><?php
                            $query_land_sup = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND (t302_landowner_personality= '0' OR 
                                (t302a_rep_WSB_talkedto='1' AND t302b_rep_WSB_accepted_disp='0'))AND t301b_wpt_flow_rate_slow!= '0'";
                            $result_land_sup = mysqli_query($mysqli, $query_land_sup) or die(mysqli_query($mysqli));
                            $num_land_sup = mysqli_affected_rows($mysqli);
                            echo $num_land_sup;
                            echo '<br>';
                            echo round(($num_land_sup / $num * 100), 0) . "%";
                            ?></td>                        
                        <td class="content "><?php
                            $query_drink_W = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND t310_wpt_drinking_water = '0' AND t302_landowner_personality!= '0'  AND t301b_wpt_flow_rate_slow!= '0'";
                            $result_drink_W = mysqli_query($mysqli, $query_drink_W) or die(mysqli_query($mysqli));
                            $num_drink_W = mysqli_affected_rows($mysqli);
                            echo $num_drink_W;
                            echo '<br>';
                            echo round(($num_drink_W / $num * 100), 0) . "%";
                            ?></td>                            
                        <td class="content "><?php
                            $query_turb = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND (t303b_turbitube_100ntu='0' OR t303_turbidity_wet='1' OR t304_turbidity_dry='1')
                                    AND t310_wpt_drinking_water != '0' AND t302_landowner_personality!= '0'  AND t301b_wpt_flow_rate_slow!= '0'";
                            $result_turb = mysqli_query($mysqli, $query_turb) or die(mysqli_query($mysqli));
                            $num_turb = mysqli_affected_rows($mysqli);
                            echo $num_turb;
                            echo '<br>';
                            echo round(($num_turb / $num * 100), 0) . "%";
                            ?></td>
                        <td class="content "><?php
                            $query_no_month = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND t305b_flow_how_many_months < 9 AND t305b_flow_how_many_months != ''
                                    AND t310_wpt_drinking_water != '0' AND t302_landowner_personality!= '0'  AND t301b_wpt_flow_rate_slow!= '0'
                                     AND (t303b_turbitube_100ntu!='0' AND t303_turbidity_wet!='1' AND t304_turbidity_dry!='1')";
                            $result_no_month = mysqli_query($mysqli, $query_no_month) or die(mysqli_query($mysqli));
                            $num_no_month = mysqli_affected_rows($mysqli);
                            echo $num_no_month;
                            echo '<br>';
                            echo round(($num_no_month / $num * 100), 0) . "%";
                            ?></td>
                        <td class="content "><?php
                            $query_avg_user = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND avg_users < 10 AND avg_users !=''
                                    AND t310_wpt_drinking_water != '0' AND t302_landowner_personality!= '0'  AND t301b_wpt_flow_rate_slow!= '0'
                                    AND (t303b_turbitube_100ntu!='0' AND t303_turbidity_wet!='1' AND t304_turbidity_dry!='1')
                                     AND (t305b_flow_how_many_months >= 9  OR t305b_flow_how_many_months = '')";
                            $result_avg_user = mysqli_query($mysqli, $query_avg_user) or die(mysqli_query($mysqli));
                            $num_avg_user = mysqli_affected_rows($mysqli);
                            echo $num_avg_user;
                            echo '<br>';
                            echo round(($num_avg_user / $num * 100), 0) . "%";
                            ?></td>
                        <td class="content "><?php
                            $query_wpt_pass = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND (t311_wpt_pass='0' OR t311_wpt_pass='-999' OR t311_wpt_pass='999')
                                AND t310_wpt_drinking_water != '0' AND t302_landowner_personality!= '0'  AND t301b_wpt_flow_rate_slow!= '0'
                                AND (t303b_turbitube_100ntu!='0' AND t303_turbidity_wet!='1' AND t304_turbidity_dry!='1')
                                AND (t305b_flow_how_many_months >= 9  OR t305b_flow_how_many_months = '')";
                            $result_wpt_pass = mysqli_query($mysqli, $query_wpt_pass) or die(mysqli_query($mysqli));
                            $num_wpt_pass = mysqli_affected_rows($mysqli);
                            echo $num_wpt_pass;
                            echo '<br>';
                            echo round(($num_wpt_pass / $num * 100), 0) . "%";
                            ?></td>
                    </tr> 
                <?php } ?>
            </table>
<!--            <p class="text_foot">
                *Absence of a program in the verification table means no verification data exists for that program from 2014-present. 
                A 0% means evaluation of the results produced a zero value.               
            </p>-->

        </div>


        <!--###################### Import Code ##########################-->

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
                                <input type="hidden" name="table_name" value="verification table">
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
<script type="text/javascript">
                                    expansion = 'none';
                                    jQuery(document).ready(function() {
                                        jQuery(".content").hide();
                                        //toggle the componenet with class msg_body
                                        jQuery(".heading").click(function()
                                        {
                                            if (expansion === 'none') {
                                                expansion = 'thereis';
                                                $(".heading").animate({
                                                    width: '7%'
                                                });
                                                $(".content").animate({
                                                    width: '10.3%'
                                                }).show();
                                                $(this).find('span').html('Collapse');
                                            } else {
                                                expansion = 'none';
                                                $(".heading").animate({
                                                    width: '25%'
                                                });
                                                $(".content").animate({
                                                    width: '0%'
                                                }).hide();
                                                $(this).find('span').html('Expand');
                                            }
                                        });
                                    });
</script>

</html>       