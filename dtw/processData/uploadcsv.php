<?php
date_default_timezone_set("Africa/Nairobi");
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");

if ($_FILES[csv][size] > 0) {

    //get the csv file
    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file, "r");
    $firstRow=true;
    //loop through the csv file and insert into database
    do {
        if ($data[0]) {
            

            $sql = "INSERT INTO `attnt_bysch`(`id`, `survey_id`, `school_no`, `attnt_district_id`, `attnt_district_name`, `attnt_division_id`, `attnt_division_name`, `training_venue`, `training_date_dd`, `training_date_mm`, `training_date_yy`, `training_date`, `trainer_name`, `trainer_position`, `trainer_phone_num`, `any_notes`, `notes`, `attnt_school_name`, `prog_id1`, `prog_id2`, `prog_id3`, `school_id`, `attnt_sch_treatment`, `t1_name`, `t2_name`, `t1_mobile`, `t2_mobile`, `t1_received_transport`, `t1_received_ttpack`, `t1_receipt_sign`, `t2_received_transport`, `t2_received_ttpack`, `t2_receipt_sign`, `received_form_e`, `packs_received_form_e`, `received_form_n`, `packs_received_form_n`, `received_form_s`, `packs_received_form_s`, `received_form_ep`, `packs_received_form_ep`, `received_form_np`, `packs_received_form_np`, `received_form_sp`, `packs_received_form_sp`, `received_airtime`, `packs_received_airtime`, `received_alb`, `number_received_alb`, `received_pzq`, `number_received_pzq`, `received_poles`, `number_received_poles`, `initial_`, `t1_rec_signature_e`, `forms_k`, `attnt_prog_id1`, `attnt_prog_id2`, `attnt_prog_id3`, `attnt_id`, `attnt_no`, `schisto_total`, `attnt_sth`, `attnt_schisto`, `countyid`, `county`, `school_name`, `attnt_sch`, `attnt_alb_sch`, `attnt_total_alb_sch`, `attnt_alb_tt`, `attnt_pzq_sch`, `attnt_total_pzq_sch`, `attnt_pzq_tt`, `attnt_total_drugs`, `drugs_present`, `drugs_missing`, `attnt_total_poles`, `attnt_total_forms_en`, `attnt_total_form_s`, `attnt_total_forms_epnp`, `attnt_total_form_sp`, `attnt_total_forms`, `attnt`)";

            $sql.=" VALUES
                (
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[0])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[1])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[2])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[3])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[4])) . "',"
                . " '" . mysql_real_escape_string(str_replace(chr(34),'',$data[5])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[6])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[7])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[8])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[9])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[10])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[11])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[12])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[13])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[14])) . "',"
                . " '" . mysql_real_escape_string(str_replace(chr(34),'',$data[15])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[16])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[17])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[18])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[19])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[20])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[21])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[22])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[23])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[24])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[25])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[26])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[27])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[28])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[29])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[30])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[31])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[32])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[33])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[34])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[35])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[36])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[37])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[38])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[39])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[40])) . "', "
                 . "'" . mysql_real_escape_string(str_replace(chr(34),'',$data[41])) . "', "
                 . "'" . mysql_real_escape_string(str_replace(chr(34),'',$data[42])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[43])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[44])) . "',"
                . " '" . mysql_real_escape_string(str_replace(chr(34),'',$data[45])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[46])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[47])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[48])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[49])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[50])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[51])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[52])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[53])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[54])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[55])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[56])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[57])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[58])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[59])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[60])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[61])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[62])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[63])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[64])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[65])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[66])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[67])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[68])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[69])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[70])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[71])) . "', "
                 . "'" . mysql_real_escape_string(str_replace(chr(34),'',$data[72])) . "', "
                 . "'" . mysql_real_escape_string(str_replace(chr(34),'',$data[73])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[74])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[75])) . "',"
                . " '" . mysql_real_escape_string(str_replace(chr(34),'',$data[76])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[77])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[78])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[79])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[80])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[81])) . "'
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[82])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[83])) . "',
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[84])) . "'
                 )";
               echo $sql."<br/>";
                mysql_query($sql)or die(mysql_error());
        }
    } while ($data = fgetcsv($handle, 1000, ",", "'"));
    //
    //redirect
    header('Location: uploadcsv.php?success=1');
    die;
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
    <head>
        <title>Evidence Action</title>
        <link href="../css/tabs_css.css" rel="stylesheet" type="text/css"/>
<?php require_once ("includes/meta-link-script.php"); ?>
        <script src="../js/tabs.js"></script>
    </head>


    <body>
        <!---------------- header start ------------------------>
        <div class="header">
            <div style="float: left">  <img src="../images/logo.png" />  </div>
            <div class="menuLinks">
<?php require_once ("includes/menuNav.php"); ?>
            </div>
        </div>
        <div class="clearFix"></div>
        <!---------------- content body ------------------------>
        <div class="contentMain">
            <div class="contentLeft">
<?php
require_once ("includes/menuLeftBar-Materials.php");
?>
            </div>
           
                    <div class="contentBody" >


<?php if (!empty($_GET[success])) {
    echo "<b>Your file has been imported.</b><br><br>";
} //generic success notice  ?>

                        <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                            Choose your file: <br />
                            <input name="csv" type="file" id="csv" />
                            <input type="submit" name="Submit" value="Submit" />
                        </form>
                    </div>
                    </body>
                    </html>
