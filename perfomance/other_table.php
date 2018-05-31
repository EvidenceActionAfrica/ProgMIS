<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");
$sql = "SELECT DISTINCT year FROM dsw_reason_table  WHERE country='$country_val' ORDER BY year DESC";
$result = mysqli_query($mysqli, $sql);

if (isset($_GET["year_edited"])) {
    $year = $_GET['year_edited'];
    $table_select = $_GET['table_edited'];
} else if (isset($_GET["submit_year"])) {
    $year = $_GET["year_select"];
    $table_select = $_GET['table_select'];
} else {
    $result_1 = mysqli_query($mysqli, $sql);
    $initial = mysqli_fetch_assoc($result_1);
    $year = $initial['year'];
    $table_select = 'dsw_per_adoption_rates';
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
    $csvMessage = $insertFile->insertFile($filename, $table);
//Connect as normal above
}
if (isset($_POST['add_reason'])) {
    if ($_POST['year'] == '' || $_POST['program'] == '') {
        $csvMessage = 'No data saved make sure: year and program textboxes are  filled';
    } else {
        for ($i = 1; $i < 13; $i++) {

            if ($_POST[$i] == '') {
                $reason_add = 0;
            } else {
                $reason_add = $_POST[$i];
            }
            $country_add = $_SESSION['country'];
            $table_add = $_POST['table_select'];
            $program_add = $_POST['program'];
            $month_add = $i;
            $year_add = $_POST['year'];
            $sql_add = "INSERT INTO dsw_reason_table (country, table_name, column_value, row_value, reason, year) 
                VALUES ( '$country_add', '$table_add', '$month_add', '$program_add', '$reason_add', '$year_add')";
            mysqli_query($mysqli, $sql_add) or die(mysqli_query($mysqli));
            $csvMessage = 'Data Added Successifuly';
        }
        $program_add = $_POST['program'];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = 'record added to Other table';
        $description = $program_add . ' program added';
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
            <select style="width:200px; height: 34px" name="table_select" id="table_select"> 
                <option value="dsw_per_adoption_rates"<?php if ($table_select == 'dsw_per_adoption_rates') echo 'selected'; ?>> Adoption rate table </option>                       
                <option value="dsw_per_cem_attendees"<?php if ($table_select == 'dsw_per_cem_attendees') echo 'selected'; ?>> CEM Attendees table </option>                       
                <option value="dsw_per_chlorine"<?php if ($table_select == 'dsw_per_chlorine') echo 'selected'; ?>> Chlorine Usage table </option>                       
                <option value="dsw_per_dispensed_rates"<?php if ($table_select == 'dsw_per_dispensed_rates') echo 'selected'; ?>> Dispenser Functionality table </option>                       
                <option value="dsw_per_instalation"<?php if ($table_select == 'dsw_per_instalation') echo 'selected'; ?>> Instalation table </option>                       
                <option value="dsw_per_lsm"<?php if ($table_select == 'dsw_per_lsm') echo 'selected'; ?>> LSM table </option>                       
                <option value="dsw_per_vcs_attendees"<?php if ($table_select == 'dsw_per_vcs_attendees') echo 'selected'; ?>> VCS Attendees table </option>                       
                <option value="dsw_per_verification"<?php if ($table_select == 'dsw_per_verification') echo 'selected'; ?>> Verification table </option>                       
            </select>
            <select style="width:140px; height: 34px" name="year_select" id="year_select">                
                <?php
                while ($rows = mysqli_fetch_assoc($result)) { //loop table rows
                    ?>
                    <option value="<?php echo $rows['year']; ?>"<?php if ($year == $rows['year']) echo 'selected'; ?>>
                        <?php echo $rows['year']; ?></option>
                <?php } ?>
            </select>
            <input class="btn btn-primary" type="submit" name="submit_year" id="submit_year" value="CHOOSE TABLE &amp; YEAR">
        </form>

        <div class="btn-group pull-right">
            <a class="btn btn-primary" href="#ADDwaterpoint">ADD Reason</a>
        </div><br><br>
        <?php
        $query_res = "SELECT DISTINCT row_value FROM `dsw_reason_table`  WHERE country='$country_val' AND year = '$year' 
                    AND table_name = '$table_select' ORDER BY row_value";
        $res = mysqli_query($mysqli, $query_res) or die(mysqli_query($mysqli));
        $check = mysqli_affected_rows($mysqli);
        if ($check > 0) {
            ?>
            <div class="table-responsive">


                <h3>Reason for blanks table</h3>
                <p class="text_title"> The table below displays the blanks appearing in other tables of the performance module.</p>
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
                    while ($row = mysqli_fetch_assoc($res)) {
                        $prog = $row["row_value"];
                        ?>

                        <tr class="heading">
                            <th><?php echo $prog; ?> </th> 
                            <?php
                            for ($value = 1; $value < 13; ++$value) {
                                $id_value = $value + 100;
                                ?>

                                <td> <?php
                                    $query = "SELECT reason, ID FROM dsw_reason_table WHERE column_value = '$value' AND row_value = '$prog' AND year = '$year' 
                                    AND table_name = '$table_select' ";
                                    $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                    $row_re = mysqli_fetch_assoc($result);
                                    if ($row_re["reason"] == '0') {
                                        echo $reason_value = '';
                                    } else {
                                        echo $reason_value = $row_re["reason"];
                                    }
                                    ?>
                                </td>
                            <form action="edit_reason.php" method="post">
                                <input type="hidden" name="<?php echo $id_value; ?>" value="<?php echo $row_re["ID"] ?>">
                                <input type="hidden" name="<?php echo $value; ?>" value="<?php echo $reason_value; ?>">
                            <?php } ?>
                            <td>

                                <input type="hidden" name="table_selected" value="<?php echo $table_select; ?>">
                                <input type="hidden" name="program" value="<?php echo $prog; ?>">
                                <input type="hidden" name="year" value="<?php echo $year; ?>">
                                <input type="submit" name='edit_reason' value="Edit" class="btn btn-default btn-xs" style="max-width: 32px"/>
                                <input type="submit" name='delete_reason' value="Delete" class="btn btn-default btn-xs" style="max-width: 46px"/>

                            </td>    
                        </form>
                        </tr>                    
                    <?php } ?>
                </table>

            </div>  
            <?php
        } else {
            echo '<h4 style="padding-top:30px">Not Data found for this above Selection</h4>';
        }
        ?>


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
                    <h4 class="">Add Reason</h4>                        
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div id="message"></div>
                        <div class="row">
                            <table style='width: 90%; float:left;'>
                                <tr style='height: 50px'>                                        
                                    <td  style='padding-left: 5%; width: 10%; font-weight: bold;'>Table</td><td colspan='2'><select class="form-control" required name="table_select" id="table_select"> 
                                            <option value="dsw_per_adoption_rates"<?php if ($table_select == 'dsw_per_adoption_rates') echo 'selected'; ?>> Adoption rate table </option>                       
                                            <option value="dsw_per_cem_attendees"<?php if ($table_select == 'dsw_per_cem_attendees') echo 'selected'; ?>> CEM Attendees table </option>                       
                                            <option value="dsw_per_chlorine"<?php if ($table_select == 'dsw_per_chlorine') echo 'selected'; ?>> Chlorine Usage table </option>                       
                                            <option value="dsw_per_dispensed_rates"<?php if ($table_select == 'dsw_per_dispensed_rates') echo 'selected'; ?>> Dispenser Functionality table </option>                       
                                            <option value="dsw_per_instalation"<?php if ($table_select == 'dsw_per_instalation') echo 'selected'; ?>> Instalation table </option>                       
                                            <option value="dsw_per_lsm"<?php if ($table_select == 'dsw_per_lsm') echo 'selected'; ?>> LSM table </option>                       
                                            <option value="dsw_per_vcs_attendees"<?php if ($table_select == 'dsw_per_vcs_attendees') echo 'selected'; ?>> VCS Attendees table </option>                       
                                            <option value="dsw_per_verification"<?php if ($table_select == 'dsw_per_verification') echo 'selected'; ?>> Verification table </option>                       
                                        </select></td><td></td>
                                </tr>
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
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Apr</td><td ><input type="text" name="4" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Aug</td><td ><input type="text" name="8" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Dec</td><td ><input type="text" name="12" class="form-control"/></td>                                                                  
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <a href="#close" class="btn btn-default" >Cancel</a>
                        <input type="submit" name="add_reason" value="Save" class="btn btn-primary" onclick='submitForm();'/>
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