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
$sqlMax = "Select * from form_mt";
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
    $table = "form_mt";
    if ($_FILES["file"]["error"] > 0) {
       // echo "Error: " . $_FILES["file"]["error"] . "<br>";
        $description="A Csv Sheet called ".$_FILES["file"]['name'].' Failed to upload';
      
    } else {
        //print_r($_FILES);
        $temp = $_FILES["file"]["tmp_name"];
        $description="A Csv Sheet called ".$_FILES["file"]['name'].' Was Uploaded Successully';
        $filename = $image->upload_image($temp);
        $description = $insertFile->insertFile($filename, $table);

    }

 
$action=" Uploading a Form in formMt Called ".$_FILES["file"]["name"];
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
            </div> <div class="contentBody" >
                <div class="tabbable" >
                    <ul class="nav nav-tabs">

                        <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Upload Data</a></li>
                        <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">View Data</a></li>

                    </ul>
                    <div class="tab-content" >

                        <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">


                            <?php
                            if (isset($_POST['SUBMIT']) && $_FILES["file"]["error"]==0) {
                                echo "<h2 style='background:#bada66;text-align:center;'>Upload done Successfully.</h2><br/><br/>";
                            }else if(isset($_POST['SUBMIT']) && $_FILES["file"]["error"]>0){
                                 echo "<h2 style='background:#bada66;text-align:center;'>Upload Failed.</h2><br/><br/>";
                            }
                            ?>
                            <div class="revrese-upload-panel">
                                <center class="padding-10">
                                    <span class="h3">Form MT</span>
                                     <?php if ($priv_login_forms_reverse >= 1) { ?>
                                            <a href="../../PHPExcel/csv_export.php?file_name=FormMT&table_name=form_mt" class="btn-custom-small">Export To Excel</a>
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
                                    <input type="file" name="file" id="file"/><br/>
                                        <?php if ($priv_login_forms_reverse >= 2) { ?>
                                            <input type="submit" id='btnSubmit' name="SUBMIT" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>
                                        <?php 
                                            }
                                             ?>

                                </form>
                            </div>  
                        </div>


                        <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2" style="max-height:450px; overflow:scroll;">
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
                                <b>of</b>  <?php echo $pages; ?> <b>Form MT Pages</b>
                                <input  type="submit" value="submitPage" name='btnSubmitPage' id='btnSubmitPage' style="visibility: hidden"/>
                            </form>
                            <table  class="table table-bordered table-condensed table-striped table-hover" >
                                <tr>
                                    <th>mt_survey_id</th> <th>district_name</th> <th>division_id</th> <th>division_name</th> <th>mt1_num_divisions</th> <th>reg_trainday</th> <th>mt1_aeo_name</th> <th>mt1_aeo_phone</th> <th>mt1_div_pho_name</th> <th>mt1_div_pho_phone</th> <th>mt21_dday</th> <th>mt22_form_s</th> <th>mt23_forms_sa</th> <th>mt24_forms_sad</th> <th>mt_ttday_start</th> <th>mt_ttday_end</th> <th>mt_ttdd_gap</th> <th>mt_num_pri</th> <th>mt_pri_enroll</th> <th>mt_ecd_enroll</th> <th>mt_num_ecd_sa</th> <th>mt_ecd_sa_enroll</th> <th>mt_alb</th> <th>mt3_num_bilhz_sch</th> <th>mt_pzq</th> <th>mt_sessions</th> <th>mt3_total_pri</th> <th>mt3_total_pri_enroll</th> <th>mt3_total_ecd_enroll</th> <th>mt3_total_ecd_sa</th> <th>mt3_total_ecd_sa_enroll</th> <th>mt3_total_alb</th> <th>mt3_total_bilhz_sch</th> <th>mt3_total_pzq</th> <th>mt3_total_sessions</th> <th>mt4_form_p_completed</th> <th>mt4_form_p_mtrainer</th> <th>mt4_form_mt_completed</th> <th>mt4_form_mt_p_prepared</th> <th>mt4_form_p_copied</th> <th>mt4_form_a_ap_filled</th> <th>mt4_national_team_informed</th> <th>mt4_mtrainer_name</th> <th>mt4_mtrainer_signature</th> <th>mt4_mtrainers_others_1</th> <th>mt4_mtrainers_others_2</th> <th>mt4_mtrainers_others_3</th> <th>mt4_mtrainers_others_4</th> <th>mt4_mtrainers_others_5</th> <th>mt_ind2</th> <th>mt</th>           </tr>
                                <?php
                                $sql = "SELECT * from form_mt";
                                $sql.=" LIMIT 50";
                                if (isset($_POST["page"])) {
                                    $pageOffset = isset($_POST["page"]) ? $_POST["page"] : 1;

                                    $offset = ($pageOffset - 1) * 50;
                                    $sql.=" OFFSET " . $offset;
                                }


                                $resultA = mysql_query($sql);
//    echo $sql;
                                while ($row = mysql_fetch_array($resultA)) {
                                    echo "<tr><td>" . $row["mt_survey_id"] . "</td>";
                                    echo "<td>" . $row["district_name"] . "</td>";
                                    echo "<td>" . $row["division_id"] . "</td>";
                                    echo "<td>" . $row["division_name"] . "</td>";
                                    echo "<td>" . $row["mt1_num_divisions"] . "</td>";
                                    echo "<td>" . $row["reg_trainday"] . "</td>";
                                    echo "<td>" . $row["mt1_aeo_name"] . "</td>";
                                    echo "<td>" . $row["mt1_aeo_phone"] . "</td>";
                                    echo "<td>" . $row["mt1_div_pho_name"] . "</td>";
                                    echo "<td>" . $row["mt1_div_pho_phone"] . "</td>";
                                    echo "<td>" . $row["mt21_dday"] . "</td>";
                                    echo "<td>" . $row["mt22_form_s"] . "</td>";
                                    echo "<td>" . $row["mt23_forms_sa"] . "</td>";
                                    echo "<td>" . $row["mt24_forms_sad"] . "</td>";
                                    echo "<td>" . $row["mt_ttday_start"] . "</td>";
                                    echo "<td>" . $row["mt_ttday_end"] . "</td>";
                                    echo "<td>" . $row["mt_ttdd_gap"] . "</td>";
                                    echo "<td>" . $row["mt_num_pri"] . "</td>";
                                    echo "<td>" . $row["mt_pri_enroll"] . "</td>";
                                    echo "<td>" . $row["mt_ecd_enroll"] . "</td>";
                                    echo "<td>" . $row["mt_num_ecd_sa"] . "</td>";
                                    echo "<td>" . $row["mt_ecd_sa_enroll"] . "</td>";
                                    echo "<td>" . $row["mt_alb"] . "</td>";
                                    echo "<td>" . $row["mt3_num_bilhz_sch"] . "</td>";
                                    echo "<td>" . $row["mt_pzq"] . "</td>";
                                    echo "<td>" . $row["mt_sessions"] . "</td>";
                                    echo "<td>" . $row["mt3_total_pri"] . "</td>";
                                    echo "<td>" . $row["mt3_total_pri_enroll"] . "</td>";
                                    echo "<td>" . $row["mt3_total_ecd_enroll"] . "</td>";
                                    echo "<td>" . $row["mt3_total_ecd_sa"] . "</td>";
                                    echo "<td>" . $row["mt3_total_ecd_sa_enroll"] . "</td>";
                                    echo "<td>" . $row["mt3_total_alb"] . "</td>";
                                    echo "<td>" . $row["mt3_total_bilhz_sch"] . "</td>";
                                    echo "<td>" . $row["mt3_total_pzq"] . "</td>";
                                    echo "<td>" . $row["mt3_total_sessions"] . "</td>";
                                    echo "<td>" . $row["mt4_form_p_completed"] . "</td>";
                                    echo "<td>" . $row["mt4_form_p_mtrainer"] . "</td>";
                                    echo "<td>" . $row["mt4_form_mt_completed"] . "</td>";
                                    echo "<td>" . $row["mt4_form_mt_p_prepared"] . "</td>";
                                    echo "<td>" . $row["mt4_form_p_copied"] . "</td>";
                                    echo "<td>" . $row["mt4_form_a_ap_filled"] . "</td>";
                                    echo "<td>" . $row["mt4_national_team_informed"] . "</td>";
                                    echo "<td>" . $row["mt4_mtrainer_name"] . "</td>";
                                    echo "<td>" . $row["mt4_mtrainer_signature"] . "</td>";
                                    echo "<td>" . $row["mt4_mtrainers_others_1"] . "</td>";
                                    echo "<td>" . $row["mt4_mtrainers_others_2"] . "</td>";
                                    echo "<td>" . $row["mt4_mtrainers_others_3"] . "</td>";
                                    echo "<td>" . $row["mt4_mtrainers_others_4"] . "</td>";
                                    echo "<td>" . $row["mt4_mtrainers_others_5"] . "</td>";
                                    echo "<td>" . $row["mt_ind2"] . "</td>";
                                    echo "<td>" . $row["mt"] . "</td></tr>";
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