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
$sqlMax = "Select * from d_bysch";
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
    $table = "d_bysch";
    if ($_FILES["file"]["error"] > 0) {
     //   echo "Error: " . $_FILES["file"]["error"] . "<br>";
        $description="A Csv Sheet called ".$_FILES["file"]['name'].' failed to Upload'; 
    } else {
        $description="A Csv Sheet called ".$_FILES["file"]['name'].' Was Uploaded Successully'; 
        $temp = $_FILES["file"]["tmp_name"];
        $filename = $image->upload_image($temp);
        $description = $insertFile->insertFile($filename, $table);

        $action=" Uploading a Csv Sheet in d_bysch Called ".$_FILES["file"]["name"];
        $M_module=6;
        $ArrayData = array($M_module, $action, $description);

        quickFuncLog($ArrayData);
    }


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
                                    <span class="h3">Form D</span>
                                     <?php if ($priv_login_forms_reverse >= 1) { ?>
                                            <a href="../../PHPExcel/csv_export.php?file_name=FormD1&table_name=d_bysch" class="btn-custom-small">Export To Excel</a>
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
                                <b>of</b>  <?php echo $pages; ?> <b>Form D Pages</b>
                                <input  type="submit" value="submitPage" name='btnSubmitPage' id='btnSubmitPage' style="visibility: hidden"/>
                            </form>
                            <table  class="table table-bordered table-condensed table-striped table-hover" >
                                <tr>
                                    <th>county_name</th> <th>district_id</th> <th>district_name</th> <th>division_id</th> <th>division_name</th> 
                                    <th>deo_name</th> <th>d_num_division</th> <th>sign</th> <th>phone_no</th> <th>d_forma_received_dd</th> 
                                    <th>d_forma_received_mm</th> <th>d_forma_received_yy</th> <th>d_form_a_received</th> <th>d_ecd_m</th> 
                                    <th>d_ecd_f</th> <th>d_ecd_t</th> <th>d_rbook_t</th> <th>d_treated_m</th> <th>d_treated_f</th> 
                                    <th>d_treated_t</th> <th>d_2_5_yrs_m</th> <th>d_2_5_yrs_f</th> <th>d_6_10_yrs_m</th> <th>d_6_10_yrs_f</th>
                                    <th>d_11_14_yrs_m</th> <th>d_11_14_yrs_f</th> <th>d_15_18_yrs_m</th> <th>d_15_18_yrs_f</th> <th>d_total_ne</th>
                                    <th>dp_prompt</th> <th>dp_forma_received_dd</th> <th>dp_forma_received_mm</th> <th>dp_forma_received_yy</th>
                                    <th>dp_form_a_received</th> <th>dp_ecd_m</th> <th>dp_ecd_f</th> <th>dp_ecd_t</th> <th>dp_rbook_t</th> 
                                    <th>dp_treated_m</th> <th>dp_treated_f</th> <th>dp_treated_t</th> <th>dp_6_10_yrs_m</th> <th>dp_6_10_yrs_f</th> 
                                    <th>dp_11_14_yrs_m</th> <th>dp_11_14_yrs_f</th> <th>dp_15_18_yrs_m</th> <th>dp_15_18_yrs_f</th> <th>dp_total_ne</th>
                                    <th>d_total_child</th> <th>dp_total_child</th> <th>province</th></tr>

                                <?php
                                $sql = "SELECT * from d_bysch";
                                $sql.=" LIMIT 50";
                                if (isset($_POST["page"])) {
                                    $pageOffset = isset($_POST["page"]) ? $_POST["page"] : 1;

                                    $offset = ($pageOffset - 1) * 50;
                                    $sql.=" OFFSET " . $offset;
                                }


                                $resultA = mysql_query($sql);
//    echo $sql;
                                while ($row = mysql_fetch_array($resultA)) {
                                    echo "<tr><td>" . $row["county_name"] . "</td>";
                                    echo "<td>" . $row["district_id"] . "</td>";
                                    echo "<td>" . $row["district_name"] . "</td>";
                                    echo "<td>" . $row["division_id"] . "</td>";
                                    echo "<td>" . $row["division_name"] . "</td>";
                                    echo "<td>" . $row["deo_name"] . "</td>";
                                    echo "<td>" . $row["d_num_division"] . "</td>";
                                    echo "<td>" . $row["sign"] . "</td>";
                                    echo "<td>" . $row["phone_no"] . "</td>";
                                    echo "<td>" . $row["d_forma_received_dd"] . "</td>";
                                    echo "<td>" . $row["d_forma_received_mm"] . "</td>";
                                    echo "<td>" . $row["d_forma_received_yy"] . "</td>";
                                    echo "<td>" . $row["d_form_a_received"] . "</td>";
                                    echo "<td>" . $row["d_ecd_m"] . "</td>";
                                    echo "<td>" . $row["d_ecd_f"] . "</td>";
                                    echo "<td>" . $row["d_ecd_t"] . "</td>";
                                    echo "<td>" . $row["d_rbook_t"] . "</td>";
                                    echo "<td>" . $row["d_treated_m"] . "</td>";
                                    echo "<td>" . $row["d_treated_f"] . "</td>";
                                    echo "<td>" . $row["d_treated_t"] . "</td>";
                                    echo "<td>" . $row["d_2_5_yrs_m"] . "</td>";
                                    echo "<td>" . $row["d_2_5_yrs_f"] . "</td>";
                                    echo "<td>" . $row["d_6_10_yrs_m"] . "</td>";
                                    echo "<td>" . $row["d_6_10_yrs_f"] . "</td>";
                                    echo "<td>" . $row["d_11_14_yrs_m"] . "</td>";
                                    echo "<td>" . $row["d_11_14_yrs_f"] . "</td>";
                                    echo "<td>" . $row["d_15_18_yrs_m"] . "</td>";
                                    echo "<td>" . $row["d_15_18_yrs_f"] . "</td>";
                                    echo "<td>" . $row["d_total_ne"] . "</td>";
                                    echo "<td>" . $row["dp_prompt"] . "</td>";
                                    echo "<td>" . $row["dp_forma_received_dd"] . "</td>";
                                    echo "<td>" . $row["dp_forma_received_mm"] . "</td>";
                                    echo "<td>" . $row["dp_forma_received_yy"] . "</td>";
                                    echo "<td>" . $row["dp_form_a_received"] . "</td>";
                                    echo "<td>" . $row["dp_ecd_m"] . "</td>";
                                    echo "<td>" . $row["dp_ecd_f"] . "</td>";
                                    echo "<td>" . $row["dp_ecd_t"] . "</td>";
                                    echo "<td>" . $row["dp_rbook_t"] . "</td>";
                                    echo "<td>" . $row["dp_treated_m"] . "</td>";
                                    echo "<td>" . $row["dp_treated_f"] . "</td>";
                                    echo "<td>" . $row["dp_treated_t"] . "</td>";
                                    echo "<td>" . $row["dp_6_10_yrs_m"] . "</td>";
                                    echo "<td>" . $row["dp_6_10_yrs_f"] . "</td>";
                                    echo "<td>" . $row["dp_11_14_yrs_m"] . "</td>";
                                    echo "<td>" . $row["dp_11_14_yrs_f"] . "</td>";
                                    echo "<td>" . $row["dp_15_18_yrs_m"] . "</td>";
                                    echo "<td>" . $row["dp_15_18_yrs_f"] . "</td>";
                                    echo "<td>" . $row["dp_total_ne"] . "</td>";
                                    echo "<td>" . $row["d_total_child"] . "</td>";
                                    echo "<td>" . $row["dp_total_child"] . "</td>";
                                    echo "<td>" . $row["province"] . "</td>";
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