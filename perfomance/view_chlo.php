<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");

$image = new image;
$insertFile = new UploadFIle;

if (isset($_POST['uploadCSV'])) {

    $table = "dsw_per_chlorine";
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
    $csvMessage = $insertFile->insertFile($filename, $table);
    //Connect as normal above
}
if (isset($_POST['clearbtn'])) {

    $table = "dsw_per_chlorine";
    $query = "DELETE FROM $table WHERE country = '$country_val'  OR YEAR ='0'";
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

            <?php require_once ('includes/left_bar.php');
            ?>
        </div>

    </div>

    <div class="col-md-10">
	<div style="text-align:center">Last updated on: <b>24th April 2018</b></div>
        <div class="clearfix" style='float: left'> 
            <a class="btn btn-primary" href="#importCSV"><span class="glyphicon glyphicon-download-alt" ></span> IMPORT CSV</a>
        </div>
  	<div class="btn-group pull-right">
            <form method="POST" action="export/exp_chlo.php">            
                    <!--<input type="hidden" name="rec_year" value="<?php //echo $year;    ?>" />-->
                <input type="hidden" name="rec_country" value="<?php echo $country_val; ?>" />
                <input class="btn btn-primary" type="submit" name="" value="Export CSV">
            </form>
        </div>
        <br>
        <br>

        <div class="table-responsive">

            <h3>Chlorine rates</h3>
            <?php
            $query_chlo_header = "SELECT MIN(year), MAX(year) FROM dsw_per_chlorine  WHERE country='$country_val'";
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
            if ($min_chlo_month == '')
                $disp_min_chlo_month = 'No Month';
            if ($min_chlo_month == '0')
                $disp_min_chlo_month = '0 Month';
            if ($min_chlo_month == '1')
                $disp_min_chlo_month = 'Jan';
            if ($min_chlo_month == '2')
                $disp_min_chlo_month = 'Feb';
            if ($min_chlo_month == '3')
                $disp_min_chlo_month = 'Mar';
            if ($min_chlo_month == '4')
                $disp_min_chlo_month = 'Apr';
            if ($min_chlo_month == '5')
                $disp_min_chlo_month = 'May';
            if ($min_chlo_month == '6')
                $disp_min_chlo_month = 'Jun';
            if ($min_chlo_month == '7')
                $disp_min_chlo_month = 'Jul';
            if ($min_chlo_month == '8')
                $disp_min_chlo_month = 'Aug';
            if ($min_chlo_month == '9')
                $disp_min_chlo_month = 'Sep';
            if ($min_chlo_month == '10')
                $disp_min_chlo_month = 'Oct';
            if ($min_chlo_month == '11')
                $disp_min_chlo_month = 'Nov';
            if ($min_chlo_month == '12')
                $disp_min_chlo_month = 'Dec';
            if ($min_chlo_month > '12')
                $disp_min_chlo_month = 'No Month';

            if ($max_chlo_month == '')
                $disp_max_chlo_month = 'No Month';
            if ($max_chlo_month == '0')
                $disp_max_chlo_month = '0 Month';
            if ($max_chlo_month == '1')
                $disp_max_chlo_month = 'Jan';
            if ($max_chlo_month == '2')
                $disp_max_chlo_month = 'Feb';
            if ($max_chlo_month == '3')
                $disp_max_chlo_month = 'Mar';
            if ($max_chlo_month == '4')
                $disp_max_chlo_month = 'Apr';
            if ($max_chlo_month == '5')
                $disp_max_chlo_month = 'May';
            if ($max_chlo_month == '6')
                $disp_max_chlo_month = 'Jun';
            if ($max_chlo_month == '7')
                $disp_max_chlo_month = 'Jul';
            if ($max_chlo_month == '8')
                $disp_max_chlo_month = 'Aug';
            if ($max_chlo_month == '9')
                $disp_max_chlo_month = 'Sep';
            if ($max_chlo_month == '10')
                $disp_max_chlo_month = 'Oct';
            if ($max_chlo_month == '11')
                $disp_max_chlo_month = 'Nov';
            if ($max_chlo_month == '12')
                $disp_max_chlo_month = 'Dec';
            if ($max_chlo_month > '12')
                $disp_max_chlo_month = 'No Month';
            ?>
            <p class="text_title">The Chlorine Usage Table provides a summary of total liters of chlorine delivered, number of deliveries and average
                chlorine consumption per waterpoint for chlorine deliveries made between  <?php echo $disp_min_chlo_month . ' ' . $min_chlo_year; ?> and
                <?php echo $disp_max_chlo_month . ' ' . $max_chlo_year; ?>.</p>

            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th style="width:25%">Installation Round</th>
                    <th style="width:25%">Total Delivered (Litres)</th>
                    <th style="width:25%">Total Number of deliveries</th>
                    <th style="width:25%">Average 30days Chlorine Usage (Litres)</th>                    
                </tr>

                <?php
                $field = 'program';
                $res = mysqli_query($mysqli, "SELECT distinct $field FROM `dsw_per_chlorine`  WHERE country='$country_val'  ORDER BY program");
                while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                    <tr> <?php $prog = $row["program"]; ?>
                        <th><?php echo $prog; ?></th> 
                        <td><?php
                            $query_sum_num = "SELECT SUM(Jerrican_delivered)
                                AS _sum_num FROM dsw_per_chlorine WHERE program = '$prog'";
                            $result_sum_num = mysqli_query($mysqli, $query_sum_num) or die(mysqli_query($mysqli));
                            $row_sum_num = mysqli_fetch_assoc($result_sum_num);
                            $_sum_num = $row_sum_num['_sum_num'];
                            echo number_format($_sum_num * 5);
                            ?></td>
                        <td><?php
                            $query_sum = "SELECT SUM(num_of_Deliveries)
                                AS _sum FROM dsw_per_chlorine WHERE program = '$prog'";
                            $result_sum = mysqli_query($mysqli, $query_sum) or die(mysqli_query($mysqli));
                            $row_sum = mysqli_fetch_assoc($result_sum);
                            $_sum = $row_sum['_sum'];
                            echo number_format($_sum);
                            ?></td>

                        <td>
                            <?php
                            $query_aver = "SELECT AVG(avrg_30day_usage_litres)
                                AS _aver FROM dsw_per_chlorine WHERE program = '$prog' AND avrg_30day_usage_litres!=''";
                            $result_aver = mysqli_query($mysqli, $query_aver) or die(mysqli_query($mysqli));
                            $row_aver = mysqli_fetch_assoc($result_aver);
                            $_aver = $row_aver['_aver'];
                            echo round($_aver);
                            ?>
                        </td>                         
                    </tr> 
                <?php }
                ?>                 
                <tr> 
                    <th>Total</th>                         
                    <th><?php
                        $query_sum_num = "SELECT SUM(Jerrican_delivered)
                                AS _sum_num FROM dsw_per_chlorine WHERE country='$country_val'";
                        $result_sum_num = mysqli_query($mysqli, $query_sum_num) or die(mysqli_query($mysqli));
                        $row_sum_num = mysqli_fetch_assoc($result_sum_num);
                        $_sum_num = $row_sum_num['_sum_num'];
                        echo number_format($_sum_num * 5);
                        ?></th>
                    <th><?php
                        $query_sum = "SELECT SUM(num_of_Deliveries)
                                AS _sum FROM dsw_per_chlorine WHERE country='$country_val'";
                        $result_sum = mysqli_query($mysqli, $query_sum) or die(mysqli_query($mysqli));
                        $row_sum = mysqli_fetch_assoc($result_sum);
                        $_sum = $row_sum['_sum'];
                        echo number_format($_sum);
                        ?></th>
                    <th>
                        <?php
                        $query_aver = "SELECT AVG(avrg_30day_usage_litres)
                                AS _aver FROM dsw_per_chlorine WHERE country='$country_val' AND avrg_30day_usage_litres!=''";
                        $result_aver = mysqli_query($mysqli, $query_aver) or die(mysqli_query($mysqli));
                        $row_aver = mysqli_fetch_assoc($result_aver);
                        $_aver = $row_aver['_aver'];
                        echo round($_aver);
                        ?>
                    </th>                         
                </tr>
            </table>
            <!--<p class="text_foot">*Absence of chlorine data for a program means that no chlorine usage data for 2014 - present year exists for that program.</p>-->            
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
                                <input type="hidden" name="table_name" value="chlorine table">
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
<?php
mysqli_close($mysqli);
?>