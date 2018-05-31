<?php
include ('header.php');
if (isset($_POST['edit_table_reason'])) {
    if ($_POST['year'] == '' || $_POST['program'] == '') {
        $csvMessage = 'No data saved make sure: year and program textboxes are  filled';
    } else {
        for ($i = 1; $i < 13; $i++) {

            if ($_POST[$i] == '') {
                $reason_edit = 0;
            } else {
                $reason_edit = $_POST[$i];
            }
                $country_edit = $_SESSION['country'];
                $program_edit = $_POST['program'];
                $table_edit = $_POST['table_select'];
                $edit_id = $i + 100;
                $id_edit = $_POST[$edit_id];
                $month_edit = $i;
                $year_edit = $_POST['year'];
                $sql_edit = "UPDATE dsw_reason_table SET country = '$country_edit', table_name = '$table_edit', row_value = '$program_edit', column_value = '$month_edit', year = '$year_edit', reason = '$reason_edit'
                        WHERE ID = '$id_edit'";
                mysqli_query($mysqli, $sql_edit) or die(mysqli_query($mysqli));
        }
        $program_edit = $_POST['program'];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = 'record edited from Other table';
        $description = $program_edit . ' program edited';
        $sql_add = "INSERT INTO performance_log_record (country, user_name, email, action, description) 
                        VALUES ( '$country_val', '$user_name', '$email', '$action', '$description')";
        mysqli_query($mysqli, $sql_add) or die(mysqli_query($mysqli));
    }
    header("Location: other_table.php?year_edited=$year_edit&&table_edited=$table_edit");
}
if (isset($_POST['delete_table_reason'])) {
    for ($i = 1; $i < 13; $i++) {

        $edit_id = $i + 100;
        $id_edit = $_POST[$edit_id];
        $query_delete = "DELETE FROM dsw_reason_table WHERE ID = '$id_edit'";
        mysqli_query($mysqli, $query_delete) or die(mysqli_query($mysqli));
    }
    $program_delet = $_POST['program'];
    $user_name = $_SESSION["full_name"];
    $email = $_SESSION["email"];
    $action = 'record deleted from Other table';
    $description = $program_delet . ' program deleted';
    $sql_add = "INSERT INTO performance_log_record (country, user_name, email, action, description) 
                        VALUES ( '$country_val', '$user_name', '$email', '$action', '$description')";
    mysqli_query($mysqli, $sql_add) or die(mysqli_query($mysqli));
    header("Location: other_table.php");
}
?>
<div class="row">
    <div class="col-md-2">
        <div class="sidebar">
            <?php require_once ('includes/left_bar.php'); ?>
        </div>
    </div>
    <div class="col-md-10">
        <br>
        <div class="">
            <div class="modal-header">
                <?php
                if (isset($csvMessage)) {
                    if ($csvMessage != 'Data Edited Successifuly') {
                        echo '<h4 style="color:#050000;background-color:#FC514E;text-align:center;">' . $csvMessage . '</h4>';
                    } else {
                        echo '<h4 style="color:#050000;background-color:#A2FF7E;text-align:center;">' . $csvMessage . '</h4>';
                    }
                }
                if (isset($_POST['edit_reason'])) {
                    ?>
                    <h4 class="">Edit Reason</h4> 
                </div>
                <hr>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div id="message"></div>
                        <div class="row">
                            <?php                                                
                            for ($id_value = 101; $id_value < 113; $id_value++) {
                                $prog_val = $_POST["$id_value"]
                                ?>

                                <input type="hidden" name="<?php echo $id_value; ?>" value="<?php echo $prog_val; ?>" class="form-control"/>  
                            <?php } 
                            $table_select = $_POST["table_selected"];
                            ?>
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
                                    <td  style='padding-left: 5%; width: 10%; font-weight: bold;'>Program</td><td colspan='2'><input type="text" name="program" value="<?php echo $_POST["program"]; ?>" class="form-control"/></td><td></td>
                                    <td  style='padding-left: 5%; width: 10%; font-weight: bold;'>Year</td><td colspan='1'><input type="text" name="year" value="<?php echo $_POST["year"]; ?>" class="form-control"/></td>
                                </tr>
                                <tr style='height: 50px'>
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Jan</td><td ><input type="text" name="1" value="<?php echo $_POST["1"]; ?>" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>May</td><td ><input type="text" name="5" value="<?php echo $_POST["5"]; ?>" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Sep</td><td ><input type="text" name="9" value="<?php echo $_POST["9"]; ?>" class="form-control"/></td>                                                                  
                                </tr>
                                <tr style='height: 50px'>
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Feb</td><td ><input type="text" name="2" value="<?php echo $_POST["2"]; ?>" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Jun</td><td ><input type="text" name="6" value="<?php echo $_POST["6"]; ?>" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Oct</td><td ><input type="text" name="10" value="<?php echo $_POST["10"]; ?>" class="form-control"/></td>                                                                  
                                </tr>
                                <tr style='height: 50px'>
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Mar</td><td ><input type="text" name="3" value="<?php echo $_POST["3"]; ?>" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Jul</td><td ><input type="text" name="7" value="<?php echo $_POST["7"]; ?>" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Nov</td><td ><input type="text" name="11" value="<?php echo $_POST["11"]; ?>" class="form-control"/></td>                                                                  
                                </tr>
                                <tr style='height: 50px'>
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Avr</td><td ><input type="text" name="4" value="<?php echo $_POST["4"]; ?>" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Aug</td><td ><input type="text" name="8" value="<?php echo $_POST["8"]; ?>" class="form-control"/></td>                                                                  
                                    <td style='padding-left: 10%; width: 15%; font-weight: bold;'>Dec</td><td ><input type="text" name="12" value="<?php echo $_POST["12"]; ?>" class="form-control"/></td>                                                                  
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="modal-footer"> 
                        <?php
                        $year_return = $_POST["year"];
                        echo"<a class=\"btn btn-default\" href = \"other_table.php?year_edited=$year_return&&table_edited=$table_select\">Cancel</a>"
                        ?>
                        <input type="submit" name="edit_table_reason" value="Edit" class="btn btn-primary" />
                    </div>
                </form>
            <?php } else { ?>
                <h4 class="">Delete Reason</h4> 
            </div>
            <hr>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <?php
                        for ($id_value = 101; $id_value < 113; $id_value++) {
                            $prog_val = $_POST["$id_value"]
                            ?>

                            <input type="hidden" name="<?php echo $id_value; ?>" value="<?php echo $prog_val; ?>" class="form-control"/>  
                        <?php } ?>
                        Are sure you want to delete the program name "<?php echo $_POST["program"]; ?>" for year "<?php echo $_POST["year"]; ?>"?

                    </div>
                </div>
                <div > 
                    <?php
                    $year_return = $_POST["year"];
                    $table_select = $_POST["table_selected"];
                    echo"<a class=\"btn btn-default\" href = \"other_table.php?year_edited=$year_return&&table_edited=$table_select\">Cancel</a>"
                    ?>
                    <input type="submit" name="delete_table_reason" value="Delete" class="btn btn-primary" />
                </div>
            </form>



        <?php } ?>
    </div> 
</div>
</div>
</body>
<script type="text/javascript">
    $('form').validate();
</script>
</html>       