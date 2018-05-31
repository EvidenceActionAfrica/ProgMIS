<?php
date_default_timezone_set("Africa/Nairobi");
require_once ('includes/auth.php');
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
            if($firstRow){
                $firstRow=false;
                continue;
            }

            $sql = "INSERT INTO `form_mt`(`mt_survey_id`, `district_name`, `division_id`, `division_name`, `mt1_num_divisions`,"
                    . " `reg_trainday`, `mt1_aeo_name`, `mt1_aeo_phone`, `mt1_div_pho_name`, `mt1_div_pho_phone`, "
                    . "`mt21_dday`, `mt22_form_s`, `mt23_forms_sa`, `mt24_forms_sad`, `mt_ttday_start`, `mt_ttday_end`,"
                    . " `mt_ttdd_gap`, `mt_num_pri`, `mt_pri_enroll`, `mt_ecd_enroll`, `mt_num_ecd_sa`, `mt_ecd_sa_enroll`,"
                    . " `mt_alb`, `mt3_num_bilhz_sch`, `mt_pzq`, `mt_sessions`, `mt3_total_pri`, `mt3_total_pri_enroll`,"
                    . " `mt3_total_ecd_enroll`, `mt3_total_ecd_sa`, `mt3_total_ecd_sa_enroll`, `mt3_total_alb`,"
                    . " `mt3_total_bilhz_sch`, `mt3_total_pzq`, `mt3_total_sessions`, `mt4_form_p_completed`, "
                    . "`mt4_form_p_mtrainer`, `mt4_form_mt_completed`, `mt4_form_mt_p_prepared`, `mt4_form_p_copied`,"
                    . " `mt4_form_a_ap_filled`, `mt4_national_team_informed`, `mt4_mtrainer_name`, `mt4_mtrainer_signature`,"
                    . " `mt4_mtrainers_others_1`, `mt4_mtrainers_others_2`, `mt4_mtrainers_others_3`, "
                    . "`mt4_mtrainers_others_4`, `mt4_mtrainers_others_5`, `mt_ind2`, `mt`)";

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
                    '" . mysql_real_escape_string(str_replace(chr(34),'',$data[50])) . "'
                  
                )";
            //   echo $sql."<br/>";
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
