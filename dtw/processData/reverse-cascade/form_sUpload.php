<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');
require_once("../../csv_upload/upload_csv/class.image.php");
require_once("../../csv_upload/upload_csv/class.insert.php");
require_once("../../includes/logTracker.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$image = new image;
$insertFile = new UploadFIle;
$tabActive = "tab2";

//GET THE MAXIMUM NUMBER OF RECORDS ON THE TABLE
$sqlMax = "Select * from s_bysch";
$resultMax = mysql_query($sqlMax);
$max = mysql_affected_rows();
//echo "Max Records are ".$max;
//CHECKING IF A PAGE NUMBER WAS SET 

if (isset($_POST["btnSubmitPage"])) {

    $pageOffset = isset($_POST["page"]) ? $_POST["page"] : 1;
    $offset = ($pageOffset - 1) * 50;
    $tabActive = "tab2";
} else {
    $pageOffset = 1;
    $offset = 0;
}



if (isset($_POST['SUBMIT'])) {
    $table = "s_bysch";
    if ($_FILES["file"]["error"] > 0) {
       // echo "Error: " . $_FILES["file"]["error"] . "<br>";
        $description="A Csv Sheet called ".$_FILES["file"]['name'].' Failed To Upload';
    } else {

        $temp = $_FILES["file"]["tmp_name"];
       echo $description="A Csv Sheet called ".$_FILES["file"]['name'].' Was Uploaded Successully';   
        $filename = $image->upload_image($temp);
        $description = $insertFile->insertFile($filename, $table);
        echo $description;
    }

$action=" Uploading a Form in s_bysch Called ".$_FILES["file"]["name"];
$M_module=6;
$ArrayData = array($M_module, $action, $description);

quickFuncLog($ArrayData);

    //Connect as normal above
}
$pages = ceil($max / 50);
//echo "There are ".$pages." Available";
$count = isset($_POST["Page"]) ? $_POST["Page"] : 1;
if ($count > $pages) {
    $count = 1;
}
if ($count > 1) {
    $countMin = $count - 1;
} else {
    $countMin = 1;
}$countPlus = $count + 1;
$countMax = $count + 5;
while ($countMax > $pages) {
    --$countMax;
}

//newMax
$newMax = 1;




// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
    $priv_login_forms_reverse = $row['priv_login_forms_reverse'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
    <head>
        <title>Evidence Action</title>
        <link href="../css/tabs_css.css" rel="stylesheet" type="text/css"/>
        <?php require_once ("includes/meta-link-script-pablo.php"); ?>

    </head>


    <body  onload="document.getElementById('imgLoading').style.visibility = 'hidden';">
        <!---------------- header start ------------------------>
        <div class="header">
            <div style="float: left">  <img src="../../images/logo.png" />  </div>
            <div class="menuLinks">
                <?php require_once ("includes/menuNav.php"); ?>
            </div>
        </div>
        <div class="clearFix"></div>
        <!---------------- content body ------------------------>
        <div class="contentMain">
            <div class="contentLeft">
                <?php
                require_once ("includes/menuLeftBar-Reverse.php");
                ?>
            </div>    
            <div class="contentBody" >
                <div class="tabbable" >
                    <ul class="nav nav-tabs">

                        <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Upload Data</a></li>
                        <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">View Data</a></li>

                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">

                        <div class="revrese-upload-panel">
                            <?php
                            if (isset($_POST['SUBMIT']) && $_FILES["file"]["error"]==0) {
                                echo "<h2 style='background:#bada66;text-align:center;'>Upload done Successfully.</h2><br/><br/>";
                            }else if(isset($_POST['SUBMIT']) && $_FILES["file"]["error"]>0){
                                 echo "<h2 style='background:#bada66;text-align:center;'>Upload Failed.</h2><br/><br/>";
                            }
                            ?>
                            <center class="padding-10">
                                 <span class="h3">Upload Form S CSV </span> 
                                   <?php if ($priv_login_forms_reverse >= 1) { ?>
                                        <a href="../../PHPExcel/csv_export.php?file_name=FormS&table_name=s_bysch" class="btn-custom-small" >Export To Excel</a>
                                    <?php } ?>
                            </center>
                            <div class="vclear"></div>
                            <div class='alert alert-block'>
                               <p>
                                  Please note. <br>Once data is uploaded, the online data will be overwriten.
                                  <br>
                                  Use the button to right to export the current data in the system, and update it.
                                  <br>Only upload updated content
                              </p>
                            </div>

                            <img src="../../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
                            <form action="" method="post"
                                  enctype="multipart/form-data">
                                <label for="file">Filename:</label>
                                <input class="vfloat-left" type="file" name="file" id="file" />
                                <?php if ($priv_login_forms_reverse >= 2) { ?>
                                    <input type="submit" id='btnSubmit' name="SUBMIT" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>
                                <?php }?>
                                   

                            </form>
                        </div>
                        </div>


                        <div class="padding-10 tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2"  style="max-height:450px; overflow:scroll;">
                            <form method="post" >
                                <b> Page </b>
                                <select name='page' onchange='submitPage();' style='width:70px'>
                                    <?php
                                    if ($newMax == $pageOffset) {
                                        $newMax = 2;
                                    }
                                    ?>
                                    <option value="<?php echo $pageOffset ?>"><?php echo $pageOffset ?></option>
                                    <?php
                                    while ($newMax <= $pages) {
                                        echo "<option value=$newMax> $newMax</option>";
                                        ++$newMax;
                                    }
                                    ?>
                                </select> 
                                <b>of</b>  <?php echo $pages; ?> <b>Form S Pages</b>
                                <input  type="submit" value="submitPage" name='btnSubmitPage' id='btnSubmitPage' style="visibility: hidden"/>
                            </form>

                            <table  class="table table-bordered table-condensed table-striped table-hover">
                                <tr>
                                    <th>ID</th> <th>s_district_id</th> <th>s_district_name</th> <th>s_division_id</th> <th>s_division_name</th> <th>s_prog_sch_id</th> <th>s1_school_name</th> <th>s1_school_type</th> <th>s_prog_sch_id1</th> <th>s_prog_sch_id2</th> <th>s_prog_sch_id3</th> <th>s_deworming_day</th> <th>s_ecd_treated_male</th> <th>s_ecd_treated_female</th> <th>s_ecd_treated_adult</th> <th>s_ecd_spoilt_tabs</th> <th>s_nonenroll_2_5yrs_m</th> <th>s_nonenroll_2_5yrs_f</th> <th>s_nonenroll_6_10yrs_m</th> <th>s_nonenroll_6_10yrs_f</th> <th>s_nonenroll_11_14yrs_m</th> <th>s_nonenroll_11_14yrs_f</th> <th>s_nonenroll_15_18yrs_m</th> <th>s_nonenroll_15_18yrs_f</th> <th>s_nonenroll_treated_adult</th> <th>s_nonenroll_spoilt_tabs</th> <th>s_alb_received</th> <th>s_alb_returned</th> <th>s_enroll_m1</th> <th>s_enroll_m2</th> <th>s_enroll_m3</th> <th>s_enroll_m4</th> <th>s_enroll_m5</th> <th>s_enroll_m6</th> <th>s_enroll_m7</th> <th>s_enroll_m8</th> <th>s_enroll_m9</th> <th>s_enroll_f1</th> <th>s_enroll_f2</th> <th>s_enroll_f3</th> <th>s_enroll_f4</th> <th>s_enroll_f5</th> <th>s_enroll_f6</th> <th>s_enroll_f7</th> <th>s_enroll_f8</th> <th>s_enroll_f9</th> <th>s_enroll_treated_m1</th> <th>s_enroll_treated_m2</th> <th>s_enroll_treated_m3</th> <th>s_enroll_treated_m4</th> <th>s_enroll_treated_m5</th> <th>s_enroll_treated_m6</th> <th>s_enroll_treated_m7</th> <th>s_enroll_treated_m8</th> <th>s_enroll_treated_m9</th> <th>s_enroll_treated_f1</th> <th>s_enroll_treated_f2</th> <th>s_enroll_treated_f3</th> <th>s_enroll_treated_f4</th> <th>s_enroll_treated_f5</th> <th>s_enroll_treated_f6</th> <th>s_enroll_treated_f7</th> <th>s_enroll_treated_f8</th> <th>s_enroll_treated_f9</th> <th>s_adult_treated1</th> <th>s_adult_treated2</th> <th>s_adult_treated3</th> <th>s_adult_treated4</th> <th>s_adult_treated5</th> <th>s_adult_treated6</th> <th>s_adult_treated7</th> <th>s_adult_treated8</th> <th>s_adult_treated9</th> <th>s_spoilt_tabs1</th> <th>s_spoilt_tabs2</th> <th>s_spoilt_tabs3</th> <th>s_spoilt_tabs4</th> <th>s_spoilt_tabs5</th> <th>s_spoilt_tabs6</th> <th>s_spoilt_tabs7</th> <th>s_spoilt_tabs8</th> <th>s_spoilt_tabs9</th> <th>s_form_s_received_dd</th> <th>s_form_s_received_mm</th> <th>s_form_s_received_yy</th> <th>s_received_form_s</th> <th>s_orig_schname</th> <th>s_ecd_total</th> <th>s_total_registered1</th> <th>s_total_treated1</th> <th>s_total_registered2</th> <th>s_total_treated2</th> <th>s_total_registered3</th> <th>s_total_treated3</th> <th>s_total_registered4</th> <th>s_total_treated4</th> <th>s_total_registered5</th> <th>s_total_treated5</th> <th>s_total_registered6</th> <th>s_total_treated6</th> <th>s_total_registered7</th> <th>s_total_treated7</th> <th>s_total_registered8</th> <th>s_total_treated8</th> <th>s_total_registered9</th> <th>s_total_treated9</th> <th>s_registered_m</th> <th>s_treated_m</th> <th>s_registered_f</th> <th>s_treated_f</th> <th>s_total_registered</th> <th>s_total_treated</th> <th>s_2_5yrs_total</th> <th>s_6_10yrs_total</th> <th>s_11_14yrs_total</th> <th>s_15_18yrs_total</th> <th>s_6_18_m</th> <th>s_6_18_f</th> <th>s_6_18_total</th> <th>s_6_14_m</th> <th>s_6_14_f</th> <th>s_6_14_total</th> <th>s_2_14_m</th> <th>s_2_14_f</th> <th>s_2_14_total</th> <th>s_2_18_m</th> <th>s_2_18_f</th> <th>s_2_18_total</th> <th>s_adult_total</th> <th>s_spoilt_total</th> <th>s_alb_use</th> <th>s_u5_m</th> <th>s_u5_f</th> <th>s_u5_total</th> <th>s_sac_m</th> <th>s_sac_f</th> <th>s_sac_total</th> <th>s_total_child</th> <th>s_total_m</th> <th>s_total_f</th> <th>s_total_all</th> <th>sp_attached</th> <th>sp_ecd_m</th> <th>sp_ecd_f</th> <th>sp_pzq_ecd</th> <th>sp_adult_ecd</th> <th>sp_spoilt_ecd</th> <th>sp_nonenroll_6_10yrs_m</th> <th>sp_nonenroll_6_10yrs_f</th> <th>sp_nonenroll_11_14yrs_m</th> <th>sp_nonenroll_11_14yrs_f</th> <th>sp_nonenroll_15_18yrs_m</th> <th>sp_nonenroll_15_18yrs_f</th> <th>sp_nonenroll_adult</th> <th>sp_nonenroll_spoilt_tabs</th> <th>sp_pzq_received</th> <th>sp_pzq_returned</th> <th>sp_enroll_m1</th> <th>sp_enroll_m2</th> <th>sp_enroll_m3</th> <th>sp_enroll_m4</th> <th>sp_enroll_m5</th> <th>sp_enroll_m6</th> <th>sp_enroll_m7</th> <th>sp_enroll_m8</th> <th>sp_enroll_m9</th> <th>sp_enroll_f1</th> <th>sp_enroll_f2</th> <th>sp_enroll_f3</th> <th>sp_enroll_f4</th> <th>sp_enroll_f5</th> <th>sp_enroll_f6</th> <th>sp_enroll_f7</th> <th>sp_enroll_f8</th> <th>sp_enroll_f9</th> <th>sp_enroll_treated_m1</th> <th>sp_enroll_treated_m2</th> <th>sp_enroll_treated_m3</th> <th>sp_enroll_treated_m4</th> <th>sp_enroll_treated_m5</th> <th>sp_enroll_treated_m6</th> <th>sp_enroll_treated_m7</th> <th>sp_enroll_treated_m8</th> <th>sp_enroll_treated_m9</th> <th>sp_enroll_treated_f1</th> <th>sp_enroll_treated_f2</th> <th>sp_enroll_treated_f3</th> <th>sp_enroll_treated_f4</th> <th>sp_enroll_treated_f5</th> <th>sp_enroll_treated_f6</th> <th>sp_enroll_treated_f7</th> <th>sp_enroll_treated_f8</th> <th>sp_enroll_treated_f9</th> <th>sp_adult_treated1</th> <th>sp_adult_treated2</th> <th>sp_adult_treated3</th> <th>sp_adult_treated4</th> <th>sp_adult_treated5</th> <th>sp_adult_treated6</th> <th>sp_adult_treated7</th> <th>sp_adult_treated8</th> <th>sp_adult_treated9</th> <th>sp_spoilt_tablets1</th> <th>sp_spoilt_tablets2</th> <th>sp_spoilt_tablets3</th> <th>sp_spoilt_tablets4</th> <th>sp_spoilt_tablets5</th> <th>sp_spoilt_tablets6</th> <th>sp_spoilt_tablets7</th> <th>sp_spoilt_tablets8</th> <th>sp_spoilt_tablets9</th> <th>sp_ecd_total</th> <th>sp_total_registered1</th> <th>sp_total_treated1</th> <th>sp_total_registered2</th> <th>sp_total_treated2</th> <th>sp_total_registered3</th> <th>sp_total_treated3</th> <th>sp_total_registered4</th> <th>sp_total_treated4</th> <th>sp_total_registered5</th> <th>sp_total_treated5</th> <th>sp_total_registered6</th> <th>sp_total_treated6</th> <th>sp_total_registered7</th> <th>sp_total_treated7</th> <th>sp_total_registered8</th> <th>sp_total_treated8</th> <th>sp_total_registered9</th> <th>sp_total_treated9</th> <th>sp_registered_m</th> <th>sp_treated_m</th> <th>sp_registered_f</th> <th>sp_treated_f</th> <th>sp_total_registered</th> <th>sp_total_treated</th> <th>sp_6_10_total</th> <th>sp_11_14_total</th> <th>sp_15_18_total</th> <th>sp_6_18_m</th> <th>sp_6_18_f</th> <th>sp_6_18_total</th> <th>sp_6_14_m</th> <th>sp_6_14_f</th> <th>sp_6_14_total</th> <th>sp_adult_total</th> <th>sp_spoilt_total</th> <th>sp_pzq_use</th> <th>sp_sac_m</th> <th>sp_sac_f</th> <th>sp_sac_total</th> <th>sp_total_child</th> <th>sp_total_m</th> <th>sp_total_f</th> <th>sp_total_all</th> <th>survey_id</th> <th>s1_deworming_dd</th> <th>s1_deworming_mm</th> <th>s1_deworming_yy</th> <th>s1_zone</th> <th>s2_ecd_total_trt</th> <th>s2_classes_listed</th> <th>s3_m_register_total</th> <th>s3_f_register_total</th> <th>s3_t_register_total</th> <th>s3_m_treat_total</th> <th>s3_f_treat_total</th> <th>s3_t_treat_total</th> <th>s3_adults_trt_total</th> <th>s3_tabs_spoil_total</th> <th>s4_ne_total</th> <th>s5_tt_children</th> <th>s5_tt_adults</th> <th>s5_tt_tabs_spoil</th> <th>s3_total_register_1</th> <th>s3_total_register_2</th> <th>s3_total_register_3</th> <th>s3_total_register_4</th> <th>s3_total_register_5</th> <th>s3_total_register_6</th> <th>s3_total_register_7</th> <th>s3_total_register_8</th> <th>s3_total_register_9</th> <th>s3_total_treat_1</th> <th>s3_total_treat_2</th> <th>s3_total_treat_3</th> <th>s3_total_treat_4</th> <th>s3_total_treat_5</th> <th>s3_total_treat_6</th> <th>s3_total_treat_7</th> <th>s3_total_treat_8</th> <th>s3_total_treat_9</th> <th>s6_ecd_total_treat</th> <th>s6_ecd_adults_total_tabs</th> <th>s6_classes_listed</th> <th>s7_m_register_total</th> <th>s7_f_register_total</th> <th>s7_register_total</th> <th>s7_m_treat_total</th> <th>s7_f_treat_total</th> <th>s7_treat_total</th> <th>s7_tabs_taken_total</th> <th>s7_adult_treat_total</th> <th>s7_adult_tabs_total</th> <th>s7_tabs_spoil_total</th> <th>s8_ne_total</th> <th>s8_ne_tabs_total</th> <th>s8_ne_adults_tabs_total</th> <th>s9_tt_children</th> <th>s9_tt_adults</th> <th>s9_tt_tabs_taken</th> <th>s9_tt_tabs_spoiled</th> <th>s7_total_register_1</th> <th>s7_total_register_2</th> <th>s7_total_register_3</th> <th>s7_total_register_4</th> <th>s7_total_register_5</th> <th>s7_total_register_6</th> <th>s7_total_register_7</th> <th>s7_total_register_8</th> <th>s7_total_register_9</th> <th>s7_total_treat_1</th> <th>s7_total_treat_2</th> <th>s7_total_treat_3</th> <th>s7_total_treat_4</th> <th>s7_total_treat_5</th> <th>s7_total_treat_6</th> <th>s7_total_treat_7</th> <th>s7_total_treat_8</th> <th>s7_total_treat_9</th> <th>s7_tabs_taken_1</th> <th>s7_tabs_taken_2</th> <th>s7_tabs_taken_3</th> <th>s7_tabs_taken_4</th> <th>s7_tabs_taken_5</th> <th>s7_tabs_taken_6</th> <th>s7_tabs_taken_7</th> <th>s7_tabs_taken_8</th> <th>s7_tabs_taken_9</th> <th>s7_adults_tabs_taken_1</th> <th>s7_adults_tabs_taken_2</th> <th>s7_adults_tabs_taken_3</th> <th>s7_adults_tabs_taken_4</th> <th>s7_adults_tabs_taken_5</th> <th>s7_adults_tabs_taken_6</th> <th>s7_adults_tabs_taken_7</th> <th>s7_adults_tabs_taken_8</th> <th>s7_adults_tabs_taken_9</th> <th>countyid</th> <th>county</th> <th>s</th><th>Actual Deworming date</th>
                                </tr>
                                <?php
                                $sql = "SELECT * from s_bysch";
                                $sql.=" LIMIT 50";
                                if (isset($_POST["page"])) {
                                    $pageOffset = isset($_POST["page"]) ? $_POST["page"] : 1;

                                    $offset = ($pageOffset - 1) * 50;
                                    $sql.=" OFFSET " . $offset;
                                }


                                $resultA = mysql_query($sql);
//    echo $sql;
                                while ($row = mysql_fetch_array($resultA)) {
                                    echo "<td>" . $row["ID"] . "</td>";
                                    echo "<td>" . $row["s_district_id"] . "</td>";
                                    echo "<td>" . $row["s_district_name"] . "</td>";
                                    echo "<td>" . $row["s_division_id"] . "</td>";
                                    echo "<td>" . $row["s_division_name"] . "</td>";
                                    echo "<td>" . $row["s_prog_sch_id"] . "</td>";
                                    echo "<td>" . $row["s1_school_name"] . "</td>";
                                    echo "<td>" . $row["s1_school_type"] . "</td>";
                                    echo "<td>" . $row["s_prog_sch_id1"] . "</td>";
                                    echo "<td>" . $row["s_prog_sch_id2"] . "</td>";
                                    echo "<td>" . $row["s_prog_sch_id3"] . "</td>";
                                    echo "<td>" . $row["s_deworming_day"] . "</td>";
                                    echo "<td>" . $row["s_ecd_treated_male"] . "</td>";
                                    echo "<td>" . $row["s_ecd_treated_female"] . "</td>";
                                    echo "<td>" . $row["s_ecd_treated_adult"] . "</td>";
                                    echo "<td>" . $row["s_ecd_spoilt_tabs"] . "</td>";
                                    echo "<td>" . $row["s_nonenroll_2_5yrs_m"] . "</td>";
                                    echo "<td>" . $row["s_nonenroll_2_5yrs_f"] . "</td>";
                                    echo "<td>" . $row["s_nonenroll_6_10yrs_m"] . "</td>";
                                    echo "<td>" . $row["s_nonenroll_6_10yrs_f"] . "</td>";
                                    echo "<td>" . $row["s_nonenroll_11_14yrs_m"] . "</td>";
                                    echo "<td>" . $row["s_nonenroll_11_14yrs_f"] . "</td>";
                                    echo "<td>" . $row["s_nonenroll_15_18yrs_m"] . "</td>";
                                    echo "<td>" . $row["s_nonenroll_15_18yrs_f"] . "</td>";
                                    echo "<td>" . $row["s_nonenroll_treated_adult"] . "</td>";
                                    echo "<td>" . $row["s_nonenroll_spoilt_tabs"] . "</td>";
                                    echo "<td>" . $row["s_alb_received"] . "</td>";
                                    echo "<td>" . $row["s_alb_returned"] . "</td>";
                                    echo "<td>" . $row["s_enroll_m1"] . "</td>";
                                    echo "<td>" . $row["s_enroll_m2"] . "</td>";
                                    echo "<td>" . $row["s_enroll_m3"] . "</td>";
                                    echo "<td>" . $row["s_enroll_m4"] . "</td>";
                                    echo "<td>" . $row["s_enroll_m5"] . "</td>";
                                    echo "<td>" . $row["s_enroll_m6"] . "</td>";
                                    echo "<td>" . $row["s_enroll_m7"] . "</td>";
                                    echo "<td>" . $row["s_enroll_m8"] . "</td>";
                                    echo "<td>" . $row["s_enroll_m9"] . "</td>";
                                    echo "<td>" . $row["s_enroll_f1"] . "</td>";
                                    echo "<td>" . $row["s_enroll_f2"] . "</td>";
                                    echo "<td>" . $row["s_enroll_f3"] . "</td>";
                                    echo "<td>" . $row["s_enroll_f4"] . "</td>";
                                    echo "<td>" . $row["s_enroll_f5"] . "</td>";
                                    echo "<td>" . $row["s_enroll_f6"] . "</td>";
                                    echo "<td>" . $row["s_enroll_f7"] . "</td>";
                                    echo "<td>" . $row["s_enroll_f8"] . "</td>";
                                    echo "<td>" . $row["s_enroll_f9"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_m1"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_m2"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_m3"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_m4"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_m5"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_m6"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_m7"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_m8"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_m9"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_f1"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_f2"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_f3"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_f4"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_f5"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_f6"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_f7"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_f8"] . "</td>";
                                    echo "<td>" . $row["s_enroll_treated_f9"] . "</td>";
                                    echo "<td>" . $row["s_adult_treated1"] . "</td>";
                                    echo "<td>" . $row["s_adult_treated2"] . "</td>";
                                    echo "<td>" . $row["s_adult_treated3"] . "</td>";
                                    echo "<td>" . $row["s_adult_treated4"] . "</td>";
                                    echo "<td>" . $row["s_adult_treated5"] . "</td>";
                                    echo "<td>" . $row["s_adult_treated6"] . "</td>";
                                    echo "<td>" . $row["s_adult_treated7"] . "</td>";
                                    echo "<td>" . $row["s_adult_treated8"] . "</td>";
                                    echo "<td>" . $row["s_adult_treated9"] . "</td>";
                                    echo "<td>" . $row["s_spoilt_tabs1"] . "</td>";
                                    echo "<td>" . $row["s_spoilt_tabs2"] . "</td>";
                                    echo "<td>" . $row["s_spoilt_tabs3"] . "</td>";
                                    echo "<td>" . $row["s_spoilt_tabs4"] . "</td>";
                                    echo "<td>" . $row["s_spoilt_tabs5"] . "</td>";
                                    echo "<td>" . $row["s_spoilt_tabs6"] . "</td>";
                                    echo "<td>" . $row["s_spoilt_tabs7"] . "</td>";
                                    echo "<td>" . $row["s_spoilt_tabs8"] . "</td>";
                                    echo "<td>" . $row["s_spoilt_tabs9"] . "</td>";
                                    echo "<td>" . $row["s_form_s_received_dd"] . "</td>";
                                    echo "<td>" . $row["s_form_s_received_mm"] . "</td>";
                                    echo "<td>" . $row["s_form_s_received_yy"] . "</td>";
                                    echo "<td>" . $row["s_received_form_s"] . "</td>";
                                    echo "<td>" . $row["s_orig_schname"] . "</td>";
                                    echo "<td>" . $row["s_ecd_total"] . "</td>";
                                    echo "<td>" . $row["s_total_registered1"] . "</td>";
                                    echo "<td>" . $row["s_total_treated1"] . "</td>";
                                    echo "<td>" . $row["s_total_registered2"] . "</td>";
                                    echo "<td>" . $row["s_total_treated2"] . "</td>";
                                    echo "<td>" . $row["s_total_registered3"] . "</td>";
                                    echo "<td>" . $row["s_total_treated3"] . "</td>";
                                    echo "<td>" . $row["s_total_registered4"] . "</td>";
                                    echo "<td>" . $row["s_total_treated4"] . "</td>";
                                    echo "<td>" . $row["s_total_registered5"] . "</td>";
                                    echo "<td>" . $row["s_total_treated5"] . "</td>";
                                    echo "<td>" . $row["s_total_registered6"] . "</td>";
                                    echo "<td>" . $row["s_total_treated6"] . "</td>";
                                    echo "<td>" . $row["s_total_registered7"] . "</td>";
                                    echo "<td>" . $row["s_total_treated7"] . "</td>";
                                    echo "<td>" . $row["s_total_registered8"] . "</td>";
                                    echo "<td>" . $row["s_total_treated8"] . "</td>";
                                    echo "<td>" . $row["s_total_registered9"] . "</td>";
                                    echo "<td>" . $row["s_total_treated9"] . "</td>";
                                    echo "<td>" . $row["s_registered_m"] . "</td>";
                                    echo "<td>" . $row["s_treated_m"] . "</td>";
                                    echo "<td>" . $row["s_registered_f"] . "</td>";
                                    echo "<td>" . $row["s_treated_f"] . "</td>";
                                    echo "<td>" . $row["s_total_registered"] . "</td>";
                                    echo "<td>" . $row["s_total_treated"] . "</td>";
                                    echo "<td>" . $row["s_2_5yrs_total"] . "</td>";
                                    echo "<td>" . $row["s_6_10yrs_total"] . "</td>";
                                    echo "<td>" . $row["s_11_14yrs_total"] . "</td>";
                                    echo "<td>" . $row["s_15_18yrs_total"] . "</td>";
                                    echo "<td>" . $row["s_6_18_m"] . "</td>";
                                    echo "<td>" . $row["s_6_18_f"] . "</td>";
                                    echo "<td>" . $row["s_6_18_total"] . "</td>";
                                    echo "<td>" . $row["s_6_14_m"] . "</td>";
                                    echo "<td>" . $row["s_6_14_f"] . "</td>";
                                    echo "<td>" . $row["s_6_14_total"] . "</td>";
                                    echo "<td>" . $row["s_2_14_m"] . "</td>";
                                    echo "<td>" . $row["s_2_14_f"] . "</td>";
                                    echo "<td>" . $row["s_2_14_total"] . "</td>";
                                    echo "<td>" . $row["s_2_18_m"] . "</td>";
                                    echo "<td>" . $row["s_2_18_f"] . "</td>";
                                    echo "<td>" . $row["s_2_18_total"] . "</td>";
                                    echo "<td>" . $row["s_adult_total"] . "</td>";
                                    echo "<td>" . $row["s_spoilt_total"] . "</td>";
                                    echo "<td>" . $row["s_alb_use"] . "</td>";
                                    echo "<td>" . $row["s_u5_m"] . "</td>";
                                    echo "<td>" . $row["s_u5_f"] . "</td>";
                                    echo "<td>" . $row["s_u5_total"] . "</td>";
                                    echo "<td>" . $row["s_sac_m"] . "</td>";
                                    echo "<td>" . $row["s_sac_f"] . "</td>";
                                    echo "<td>" . $row["s_sac_total"] . "</td>";
                                    echo "<td>" . $row["s_total_child"] . "</td>";
                                    echo "<td>" . $row["s_total_m"] . "</td>";
                                    echo "<td>" . $row["s_total_f"] . "</td>";
                                    echo "<td>" . $row["s_total_all"] . "</td>";
                                    echo "<td>" . $row["sp_attached"] . "</td>";
                                    echo "<td>" . $row["sp_ecd_m"] . "</td>";
                                    echo "<td>" . $row["sp_ecd_f"] . "</td>";
                                    echo "<td>" . $row["sp_pzq_ecd"] . "</td>";
                                    echo "<td>" . $row["sp_adult_ecd"] . "</td>";
                                    echo "<td>" . $row["sp_spoilt_ecd"] . "</td>";
                                    echo "<td>" . $row["sp_nonenroll_6_10yrs_m"] . "</td>";
                                    echo "<td>" . $row["sp_nonenroll_6_10yrs_f"] . "</td>";
                                    echo "<td>" . $row["sp_nonenroll_11_14yrs_m"] . "</td>";
                                    echo "<td>" . $row["sp_nonenroll_11_14yrs_f"] . "</td>";
                                    echo "<td>" . $row["sp_nonenroll_15_18yrs_m"] . "</td>";
                                    echo "<td>" . $row["sp_nonenroll_15_18yrs_f"] . "</td>";
                                    echo "<td>" . $row["sp_nonenroll_adult"] . "</td>";
                                    echo "<td>" . $row["sp_nonenroll_spoilt_tabs"] . "</td>";
                                    echo "<td>" . $row["sp_pzq_received"] . "</td>";
                                    echo "<td>" . $row["sp_pzq_returned"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_m1"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_m2"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_m3"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_m4"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_m5"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_m6"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_m7"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_m8"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_m9"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_f1"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_f2"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_f3"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_f4"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_f5"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_f6"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_f7"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_f8"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_f9"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_m1"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_m2"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_m3"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_m4"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_m5"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_m6"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_m7"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_m8"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_m9"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_f1"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_f2"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_f3"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_f4"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_f5"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_f6"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_f7"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_f8"] . "</td>";
                                    echo "<td>" . $row["sp_enroll_treated_f9"] . "</td>";
                                    echo "<td>" . $row["sp_adult_treated1"] . "</td>";
                                    echo "<td>" . $row["sp_adult_treated2"] . "</td>";
                                    echo "<td>" . $row["sp_adult_treated3"] . "</td>";
                                    echo "<td>" . $row["sp_adult_treated4"] . "</td>";
                                    echo "<td>" . $row["sp_adult_treated5"] . "</td>";
                                    echo "<td>" . $row["sp_adult_treated6"] . "</td>";
                                    echo "<td>" . $row["sp_adult_treated7"] . "</td>";
                                    echo "<td>" . $row["sp_adult_treated8"] . "</td>";
                                    echo "<td>" . $row["sp_adult_treated9"] . "</td>";
                                    echo "<td>" . $row["sp_spoilt_tablets1"] . "</td>";
                                    echo "<td>" . $row["sp_spoilt_tablets2"] . "</td>";
                                    echo "<td>" . $row["sp_spoilt_tablets3"] . "</td>";
                                    echo "<td>" . $row["sp_spoilt_tablets4"] . "</td>";
                                    echo "<td>" . $row["sp_spoilt_tablets5"] . "</td>";
                                    echo "<td>" . $row["sp_spoilt_tablets6"] . "</td>";
                                    echo "<td>" . $row["sp_spoilt_tablets7"] . "</td>";
                                    echo "<td>" . $row["sp_spoilt_tablets8"] . "</td>";
                                    echo "<td>" . $row["sp_spoilt_tablets9"] . "</td>";
                                    echo "<td>" . $row["sp_ecd_total"] . "</td>";
                                    echo "<td>" . $row["sp_total_registered1"] . "</td>";
                                    echo "<td>" . $row["sp_total_treated1"] . "</td>";
                                    echo "<td>" . $row["sp_total_registered2"] . "</td>";
                                    echo "<td>" . $row["sp_total_treated2"] . "</td>";
                                    echo "<td>" . $row["sp_total_registered3"] . "</td>";
                                    echo "<td>" . $row["sp_total_treated3"] . "</td>";
                                    echo "<td>" . $row["sp_total_registered4"] . "</td>";
                                    echo "<td>" . $row["sp_total_treated4"] . "</td>";
                                    echo "<td>" . $row["sp_total_registered5"] . "</td>";
                                    echo "<td>" . $row["sp_total_treated5"] . "</td>";
                                    echo "<td>" . $row["sp_total_registered6"] . "</td>";
                                    echo "<td>" . $row["sp_total_treated6"] . "</td>";
                                    echo "<td>" . $row["sp_total_registered7"] . "</td>";
                                    echo "<td>" . $row["sp_total_treated7"] . "</td>";
                                    echo "<td>" . $row["sp_total_registered8"] . "</td>";
                                    echo "<td>" . $row["sp_total_treated8"] . "</td>";
                                    echo "<td>" . $row["sp_total_registered9"] . "</td>";
                                    echo "<td>" . $row["sp_total_treated9"] . "</td>";
                                    echo "<td>" . $row["sp_registered_m"] . "</td>";
                                    echo "<td>" . $row["sp_treated_m"] . "</td>";
                                    echo "<td>" . $row["sp_registered_f"] . "</td>";
                                    echo "<td>" . $row["sp_treated_f"] . "</td>";
                                    echo "<td>" . $row["sp_total_registered"] . "</td>";
                                    echo "<td>" . $row["sp_total_treated"] . "</td>";
                                    echo "<td>" . $row["sp_6_10_total"] . "</td>";
                                    echo "<td>" . $row["sp_11_14_total"] . "</td>";
                                    echo "<td>" . $row["sp_15_18_total"] . "</td>";
                                    echo "<td>" . $row["sp_6_18_m"] . "</td>";
                                    echo "<td>" . $row["sp_6_18_f"] . "</td>";
                                    echo "<td>" . $row["sp_6_18_total"] . "</td>";
                                    echo "<td>" . $row["sp_6_14_m"] . "</td>";
                                    echo "<td>" . $row["sp_6_14_f"] . "</td>";
                                    echo "<td>" . $row["sp_6_14_total"] . "</td>";
                                    echo "<td>" . $row["sp_adult_total"] . "</td>";
                                    echo "<td>" . $row["sp_spoilt_total"] . "</td>";
                                    echo "<td>" . $row["sp_pzq_use"] . "</td>";
                                    echo "<td>" . $row["sp_sac_m"] . "</td>";
                                    echo "<td>" . $row["sp_sac_f"] . "</td>";
                                    echo "<td>" . $row["sp_sac_total"] . "</td>";
                                    echo "<td>" . $row["sp_total_child"] . "</td>";
                                    echo "<td>" . $row["sp_total_m"] . "</td>";
                                    echo "<td>" . $row["sp_total_f"] . "</td>";
                                    echo "<td>" . $row["sp_total_all"] . "</td>";
                                    echo "<td>" . $row["survey_id"] . "</td>";
                                    echo "<td>" . $row["s1_deworming_dd"] . "</td>";
                                    echo "<td>" . $row["s1_deworming_mm"] . "</td>";
                                    echo "<td>" . $row["s1_deworming_yy"] . "</td>";
                                    echo "<td>" . $row["s1_zone"] . "</td>";
                                    echo "<td>" . $row["s2_ecd_total_trt"] . "</td>";
                                    echo "<td>" . $row["s2_classes_listed"] . "</td>";
                                    echo "<td>" . $row["s3_m_register_total"] . "</td>";
                                    echo "<td>" . $row["s3_f_register_total"] . "</td>";
                                    echo "<td>" . $row["s3_t_register_total"] . "</td>";
                                    echo "<td>" . $row["s3_m_treat_total"] . "</td>";
                                    echo "<td>" . $row["s3_f_treat_total"] . "</td>";
                                    echo "<td>" . $row["s3_t_treat_total"] . "</td>";
                                    echo "<td>" . $row["s3_adults_trt_total"] . "</td>";
                                    echo "<td>" . $row["s3_tabs_spoil_total"] . "</td>";
                                    echo "<td>" . $row["s4_ne_total"] . "</td>";
                                    echo "<td>" . $row["s5_tt_children"] . "</td>";
                                    echo "<td>" . $row["s5_tt_adults"] . "</td>";
                                    echo "<td>" . $row["s5_tt_tabs_spoil"] . "</td>";
                                    echo "<td>" . $row["s3_total_register_1"] . "</td>";
                                    echo "<td>" . $row["s3_total_register_2"] . "</td>";
                                    echo "<td>" . $row["s3_total_register_3"] . "</td>";
                                    echo "<td>" . $row["s3_total_register_4"] . "</td>";
                                    echo "<td>" . $row["s3_total_register_5"] . "</td>";
                                    echo "<td>" . $row["s3_total_register_6"] . "</td>";
                                    echo "<td>" . $row["s3_total_register_7"] . "</td>";
                                    echo "<td>" . $row["s3_total_register_8"] . "</td>";
                                    echo "<td>" . $row["s3_total_register_9"] . "</td>";
                                    echo "<td>" . $row["s3_total_treat_1"] . "</td>";
                                    echo "<td>" . $row["s3_total_treat_2"] . "</td>";
                                    echo "<td>" . $row["s3_total_treat_3"] . "</td>";
                                    echo "<td>" . $row["s3_total_treat_4"] . "</td>";
                                    echo "<td>" . $row["s3_total_treat_5"] . "</td>";
                                    echo "<td>" . $row["s3_total_treat_6"] . "</td>";
                                    echo "<td>" . $row["s3_total_treat_7"] . "</td>";
                                    echo "<td>" . $row["s3_total_treat_8"] . "</td>";
                                    echo "<td>" . $row["s3_total_treat_9"] . "</td>";
                                    echo "<td>" . $row["s6_ecd_total_treat"] . "</td>";
                                    echo "<td>" . $row["s6_ecd_adults_total_tabs"] . "</td>";
                                    echo "<td>" . $row["s6_classes_listed"] . "</td>";
                                    echo "<td>" . $row["s7_m_register_total"] . "</td>";
                                    echo "<td>" . $row["s7_f_register_total"] . "</td>";
                                    echo "<td>" . $row["s7_register_total"] . "</td>";
                                    echo "<td>" . $row["s7_m_treat_total"] . "</td>";
                                    echo "<td>" . $row["s7_f_treat_total"] . "</td>";
                                    echo "<td>" . $row["s7_treat_total"] . "</td>";
                                    echo "<td>" . $row["s7_tabs_taken_total"] . "</td>";
                                    echo "<td>" . $row["s7_adult_treat_total"] . "</td>";
                                    echo "<td>" . $row["s7_adult_tabs_total"] . "</td>";
                                    echo "<td>" . $row["s7_tabs_spoil_total"] . "</td>";
                                    echo "<td>" . $row["s8_ne_total"] . "</td>";
                                    echo "<td>" . $row["s8_ne_tabs_total"] . "</td>";
                                    echo "<td>" . $row["s8_ne_adults_tabs_total"] . "</td>";
                                    echo "<td>" . $row["s9_tt_children"] . "</td>";
                                    echo "<td>" . $row["s9_tt_adults"] . "</td>";
                                    echo "<td>" . $row["s9_tt_tabs_taken"] . "</td>";
                                    echo "<td>" . $row["s9_tt_tabs_spoiled"] . "</td>";
                                    echo "<td>" . $row["s7_total_register_1"] . "</td>";
                                    echo "<td>" . $row["s7_total_register_2"] . "</td>";
                                    echo "<td>" . $row["s7_total_register_3"] . "</td>";
                                    echo "<td>" . $row["s7_total_register_4"] . "</td>";
                                    echo "<td>" . $row["s7_total_register_5"] . "</td>";
                                    echo "<td>" . $row["s7_total_register_6"] . "</td>";
                                    echo "<td>" . $row["s7_total_register_7"] . "</td>";
                                    echo "<td>" . $row["s7_total_register_8"] . "</td>";
                                    echo "<td>" . $row["s7_total_register_9"] . "</td>";
                                    echo "<td>" . $row["s7_total_treat_1"] . "</td>";
                                    echo "<td>" . $row["s7_total_treat_2"] . "</td>";
                                    echo "<td>" . $row["s7_total_treat_3"] . "</td>";
                                    echo "<td>" . $row["s7_total_treat_4"] . "</td>";
                                    echo "<td>" . $row["s7_total_treat_5"] . "</td>";
                                    echo "<td>" . $row["s7_total_treat_6"] . "</td>";
                                    echo "<td>" . $row["s7_total_treat_7"] . "</td>";
                                    echo "<td>" . $row["s7_total_treat_8"] . "</td>";
                                    echo "<td>" . $row["s7_total_treat_9"] . "</td>";
                                    echo "<td>" . $row["s7_tabs_taken_1"] . "</td>";
                                    echo "<td>" . $row["s7_tabs_taken_2"] . "</td>";
                                    echo "<td>" . $row["s7_tabs_taken_3"] . "</td>";
                                    echo "<td>" . $row["s7_tabs_taken_4"] . "</td>";
                                    echo "<td>" . $row["s7_tabs_taken_5"] . "</td>";
                                    echo "<td>" . $row["s7_tabs_taken_6"] . "</td>";
                                    echo "<td>" . $row["s7_tabs_taken_7"] . "</td>";
                                    echo "<td>" . $row["s7_tabs_taken_8"] . "</td>";
                                    echo "<td>" . $row["s7_tabs_taken_9"] . "</td>";
                                    echo "<td>" . $row["s7_adults_tabs_taken_1"] . "</td>";
                                    echo "<td>" . $row["s7_adults_tabs_taken_2"] . "</td>";
                                    echo "<td>" . $row["s7_adults_tabs_taken_3"] . "</td>";
                                    echo "<td>" . $row["s7_adults_tabs_taken_4"] . "</td>";
                                    echo "<td>" . $row["s7_adults_tabs_taken_5"] . "</td>";
                                    echo "<td>" . $row["s7_adults_tabs_taken_6"] . "</td>";
                                    echo "<td>" . $row["s7_adults_tabs_taken_7"] . "</td>";
                                    echo "<td>" . $row["s7_adults_tabs_taken_8"] . "</td>";
                                    echo "<td>" . $row["s7_adults_tabs_taken_9"] . "</td>";
                                    echo "<td>" . $row["countyid"] . "</td>";
                                    echo "<td>" . $row["county"] . "</td>";
                                    echo "<td>" . $row["s"] . "</td>";
                                    echo "<td>" . $row["actual_deworming_date"] . "</td></tr>";
                                
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function submitForm() {
                document.getElementById('imgLoading').style.visibility = "visible";
                //var selectButton = document.getElementById('btnSubmit');
                //selectButton.click();
            }
            function submitPage() {
                var selectButton = document.getElementById('btnSubmitPage');
                selectButton.click();
            }
        </script>

    </body>
</html>