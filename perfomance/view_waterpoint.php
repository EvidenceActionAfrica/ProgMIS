<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");
$sql = "SELECT DISTINCT year FROM dsw_per_waterpoint  WHERE country='$country_val' ORDER BY year DESC";
$result = mysqli_query($mysqli, $sql);

if (isset($_GET["year_edited"])) {
    $year = $_GET['year_edited'];
} else if (isset($_GET["submit_year"])) {
    $year = $_GET["year_select"];
} else {
    $result_1 = mysqli_query($mysqli, $sql);
    $initial = mysqli_fetch_assoc($result_1);
    $year = $initial['year'];
}
$image = new image;
$insertFile = new UploadFIle;

if (isset($_POST['uploadCSV'])) {

    $table = "dsw_per_waterpoint";
    if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
        $csvMessage = "Upload Failed";
    } else {

        $temp = $_FILES["file"]["tmp_name"];
        $csvMessage = "Upload Successful";
    }

    $filename = $image->upload_image($temp);
    $insertFile->insertFile($filename, $table);
//Connect as normal above
}
if (isset($_POST['add_waterpoint'])) {
    if ($_POST['year'] == '' || $_POST['program'] == '') {
        $csvMessage = 'No data saved make sure: year and program textboxes are  filled';
    } else {
        for ($i = 1; $i < 13; $i++) {

            if ($_POST[$i] == '') {
                $total_number_add = 0;
            } else {
                $total_number_add = $_POST[$i];
            }
            $country_add = $_SESSION['country'];
            $program_add = $_POST['program'];
            $month_add = $i;
            $year_add = $_POST['year'];
            $sql_add = "INSERT INTO dsw_per_waterpoint (country, program, month, year, total_number) VALUES ( '$country_add', '$program_add', '$month_add', '$year_add', '$total_number_add')";
            mysqli_query($mysqli, $sql_add) or die(mysqli_query($mysqli));
            $csvMessage = 'Data Added Successifuly';
        }
        $program_add = $_POST['program'];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = 'record deleted from Waterpoint table';
        $description = $program_add . ' program deleted';
        $sql_add = "INSERT INTO performance_log_record (country, user_name, email, action, description) 
                        VALUES ( '$country_val', '$user_name', '$email', '$action', '$description')";
        mysqli_query($mysqli, $sql_add) or die(mysqli_query($mysqli));
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
        </div></br>        
        <form id="logform1"  method="$_GET" style='float: left'>  

            <select style="width:140px; height: 34px" name="year_select" id="year_select">                
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
            <a class="btn btn-primary" href="#ADDwaterpoint">ADD Waterpoint</a>
        </div><br><br>
        <div class="table-responsive">


            <h3>Waterpoints table</h3>
            <?php
            ?>
            <p class="text_title"> The table below provides the total number of waterpoints per different programs and month as well.</p>
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
                    <th></th>
                </tr>
                <?php
                $res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_waterpoint`  WHERE country='$country_val' AND year = '$year' ORDER BY program");
                while ($row = mysqli_fetch_assoc($res)) {
                    $prog = $row["program"];
                    ?>

                    <tr class="heading">
                        <th><?php echo $prog; ?> </th> 
                        <?php
                        for ($value = 1; $value < 13; ++$value) {
                            $id_value = $value + 100;
                            ?>

                            <td> <?php
                    $query = "SELECT total_number, ID FROM dsw_per_waterpoint WHERE month = '$value' AND program = '$prog' AND year = '$year' ";
                    $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                    $row_num = mysqli_fetch_assoc($result);
                    if ($row_num["total_number"] == '0') {
                        echo '';
                    } else {
                        echo $row_num["total_number"];
                    }
                            ?>
                            </td>
                        <form action="edit_waterpoint.php" method="post">
                            <input type="hidden" name="<?php echo $id_value; ?>" value="<?php echo $row_num["ID"] ?>">
                            <input type="hidden" name="<?php echo $value; ?>" value="<?php
                        if ($row_num["total_number"] == '0') {
                            echo '';
                        } else {
                            echo $row_num["total_number"];
                        }
                            ?>">
                               <?php } ?>
                        <td>

                            <input type="hidden" name="program" value="<?php echo $prog; ?>">
                            <input type="hidden" name="year" value="<?php echo $year; ?>">
                            <input type="submit" name='edit_water_point' value="Edit" class="btn btn-default btn-xs" style="max-width: 32px"/>
                            <input type="submit" name='delete_water_point' value="Delete" class="btn btn-default btn-xs" style="max-width: 46px"/>

                        </td>    
                    </form>
                    </tr>                    
                <?php } ?>
            </table>

        </div>   

        <!--#####################################################################-->

        <div id="ADDwaterpoint" class="modalDialog ">
            <div class="">
                <div class="modal-header">
                    <a href="#close" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a>
                    <?php
                    if (isset($csvMessage)) {
                        if ($csvMessage != 'Data Added Successifuly') {
                            echo '<h4 style="color:#050000;background-color:#FC514E;text-align:center;">' . $csvMessage . '</h4>';
                        } else {
                            echo '<h4 style="color:#050000;background-color:#A2FF7E;text-align:center;">' . $csvMessage . '</h4>';
                        }
                    }
                    ?>
                    <h4 class="">Add Waterpoint</h4>                        
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div id="message"></div>
                        <div class="row">
                            <table style='width: 90%; float:left;'>
                                <tr style='height: 50px'>
                                    <td  style='padding-left: 5%; width: 10%; font-weight: bold;'>Program</td><td colspan='2'><input type="text" name="program" class="form-control" required/></td><td></td>
                                    <td  style='padding-left: 5%; width: 10%; font-weight: bold;'>Year</td><td colspan='1'><input type="text" name="year" class="form-control" required/></td>
                                </tr>
                                <tr style='height: 50px'>
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Jan</td><td ><input type="text" name="1" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>May</td><td ><input type="text" name="5" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Sep</td><td ><input type="text" name="9" class="form-control"/></td>                                                                  
                                </tr>
                                <tr style='height: 50px'>
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Feb</td><td ><input type="text" name="2" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Jun</td><td ><input type="text" name="6" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Oct</td><td ><input type="text" name="10" class="form-control"/></td>                                                                  
                                </tr>
                                <tr style='height: 50px'>
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Mar</td><td ><input type="text" name="3" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Jul</td><td ><input type="text" name="7" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Nov</td><td ><input type="text" name="11" class="form-control"/></td>                                                                  
                                </tr>
                                <tr style='height: 50px'>
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Avr</td><td ><input type="text" name="4" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Aug</td><td ><input type="text" name="8" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Dec</td><td ><input type="text" name="12" class="form-control"/></td>                                                                  
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <a href="#close" class="btn btn-default" >Cancel</a>
                        <input type="submit" name="add_waterpoint" value="Save" class="btn btn-primary" onclick='submitForm();'/>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</body>
<script type="text/javascript">
                            $('form').validate();
</script>

</html> 
<?php
mysqli_close($mysqli);
?>