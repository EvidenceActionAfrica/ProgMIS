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
$sqlMax = "Select * from attnt_bysch";
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
  $table = "attnt_bysch";
  if ($_FILES["file"]["error"] > 0) {
   // echo "Error: " . $_FILES["file"]["error"] . "<br>";
    $description="A Csv Sheet called ".$_FILES["file"]['name'].' failed to upload'; 
  }else{

    $temp = $_FILES["file"]["tmp_name"];
    $filename = $image->upload_image($temp);
    $description="A Csv Sheet called ".$_FILES["file"]['name'].' Was uploaded successully'; 
    $description=$insertFile->insertFile($filename, $table);

    //convert "Treating for bilharzia" to 1
    $query = "SELECT id,attnt_sch_treatment 
      FROM attnt_bysch WHERE attnt_sch_treatment = 'Treating for bilharzia' ";
    $result = mysql_query($query) or die(mysql_error());

    while ($row = mysql_fetch_assoc($result)) {
      $id = $row['id'];
      $query2 = "UPDATE attnt_bysch SET  attnt_sch_treatment ='1' WHERE id='$id'  ";
      mysql_query($query2);
    }


    //end
  }
    $action=" Uploading a Csv Sheet in attnt_bysch Called ".$_FILES["file"]["name"];
    $M_module=6;
    $ArrayData = array($M_module, $action, $description);

    quickFuncLog($ArrayData);

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
    <link href="../../css/tabs_css.css" rel="stylesheet" type="text/css"/>
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


              <?php
                  if (isset($_POST['SUBMIT']) && $_FILES["file"]["error"]==0) {
                      echo "<h2 style='background:#bada66;text-align:center;'>Upload done Successfully.</h2><br/><br/>";
                  }else if(isset($_POST['SUBMIT']) && $_FILES["file"]["error"]>0){
                       echo "<h2 style='background:#bada66;text-align:center;'>Upload Failed.</h2><br/><br/>";
                  }
                  ?>
              <div class="revrese-upload-panel">
                <center class="padding-10"> 
                  <span class="h3">Form ATTNT</span>
                  <?php if ($priv_login_forms_reverse >= 1) { ?>

                    <a href="../../PHPExcel/csv_export.php?file_name=FormATTNT&table_name=attnt_bysch" class="btn-custom-small">Export To Excel</a>
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
                          <img src="../../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 0px; visibility: visible"/>
                          <form action="" method="post"
                                enctype="multipart/form-data">
                            <label for="file">Filename:</label>
                            <input type="file" name="file" id="file"/>
                            <?php if ($priv_login_forms_reverse >= 2) { ?>

                              <input type="submit" id='btnSubmit' name="SUBMIT" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>
                            <?php }
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
                              <b>of</b>  <?php echo $pages; ?> <b>Form ATTNT Pages</b>
                              <input  type="submit" value="submitPage" name='btnSubmitPage' id='btnSubmitPage' style="visibility: hidden"/>
                            </form>


                            <table  class="table table-bordered table-condensed table-striped table-hover">
                              <tr>
                                <th>id</th> <th>survey_id</th> <th>school_no</th> <th>attnt_district_id</th> <th>attnt_district_name</th> <th>attnt_division_id</th> <th>attnt_division_name</th> <th>training_venue</th> <th>training_date_dd</th> <th>training_date_mm</th> <th>training_date_yy</th> <th>training_date</th> <th>trainer_name</th> <th>trainer_position</th> <th>trainer_phone_num</th> <th>any_notes</th> <th>notes</th> <th>attnt_school_name</th> <th>prog_id1</th> <th>prog_id2</th> <th>prog_id3</th> <th>school_id</th> <th>attnt_sch_treatment</th> <th>t1_name</th> <th>t2_name</th> <th>t1_mobile</th> <th>t2_mobile</th> <th>t1_received_transport</th> <th>t1_received_ttpack</th> <th>t1_receipt_sign</th> <th>t2_received_transport</th> <th>t2_received_ttpack</th> <th>t2_receipt_sign</th> <th>received_form_e</th> <th>packs_received_form_e</th> <th>received_form_n</th> <th>packs_received_form_n</th> <th>received_form_s</th> <th>packs_received_form_s</th> <th>received_form_ep</th> <th>packs_received_form_ep</th> <th>received_form_np</th> <th>packs_received_form_np</th> <th>received_form_sp</th> <th>packs_received_form_sp</th> <th>received_airtime</th> <th>packs_received_airtime</th> <th>received_alb</th> <th>number_received_alb</th> <th>received_pzq</th> <th>number_received_pzq</th> <th>received_poles</th> <th>number_received_poles</th> <th>initial_</th> <th>t1_rec_signature_e</th> <th>forms_k</th> <th>attnt_prog_id1</th> <th>attnt_prog_id2</th> <th>attnt_prog_id3</th> <th>attnt_id</th> <th>attnt_no</th> <th>schisto_total</th> <th>attnt_sth</th> <th>attnt_schisto</th> <th>countyid</th> <th>county</th> <th>school_name</th> <th>attnt_sch</th> <th>attnt_alb_sch</th> <th>attnt_total_alb_sch</th> <th>attnt_alb_tt</th> <th>attnt_pzq_sch</th> <th>attnt_total_pzq_sch</th> <th>attnt_pzq_tt</th> <th>attnt_total_drugs</th> <th>drugs_present</th> <th>drugs_missing</th> <th>attnt_total_poles</th> <th>attnt_total_forms_en</th> <th>attnt_total_form_s</th> <th>attnt_total_forms_epnp</th> <th>attnt_total_form_sp</th> <th>attnt_total_forms</th> <th>attnt</th>
                              </tr>

                              <?php
                              $sql = "SELECT * from attnt_bysch";
                              $sql.=" LIMIT 50";
                              if (isset($_POST["page"])) {
                                $pageOffset = isset($_POST["page"]) ? $_POST["page"] : 1;

                                $offset = ($pageOffset - 1) * 50;
                                $sql.=" OFFSET " . $offset;
                              }

// echo $sql;    
                              $resultA = mysql_query($sql);
                              while ($row = mysql_fetch_array($resultA)) {

                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["survey_id"] . "</td>";
                                echo "<td>" . $row["school_no"] . "</td>";
                                echo "<td>" . $row["attnt_district_id"] . "</td>";
                                echo "<td>" . $row["attnt_district_name"] . "</td>";
                                echo "<td>" . $row["attnt_division_id"] . "</td>";
                                echo "<td>" . $row["attnt_division_name"] . "</td>";
                                echo "<td>" . $row["training_venue"] . "</td>";
                                echo "<td>" . $row["training_date_dd"] . "</td>";
                                echo "<td>" . $row["training_date_mm"] . "</td>";
                                echo "<td>" . $row["training_date_yy"] . "</td>";
                                echo "<td>" . $row["training_date"] . "</td>";
                                echo "<td>" . $row["trainer_name"] . "</td>";
                                echo "<td>" . $row["trainer_position"] . "</td>";
                                echo "<td>" . $row["trainer_phone_num"] . "</td>";
                                echo "<td>" . $row["any_notes"] . "</td>";
                                echo "<td>" . $row["notes"] . "</td>";
                                echo "<td>" . $row["attnt_school_name"] . "</td>";
                                echo "<td>" . $row["prog_id1"] . "</td>";
                                echo "<td>" . $row["prog_id2"] . "</td>";
                                echo "<td>" . $row["prog_id3"] . "</td>";
                                echo "<td>" . $row["school_id"] . "</td>";
                                echo "<td>" . $row["attnt_sch_treatment"] . "</td>";
                                echo "<td>" . $row["t1_name"] . "</td>";
                                echo "<td>" . $row["t2_name"] . "</td>";
                                echo "<td>" . $row["t1_mobile"] . "</td>";
                                echo "<td>" . $row["t2_mobile"] . "</td>";
                                echo "<td>" . $row["t1_received_transport"] . "</td>";
                                echo "<td>" . $row["t1_received_ttpack"] . "</td>";
                                echo "<td>" . $row["t1_receipt_sign"] . "</td>";
                                echo "<td>" . $row["t2_received_transport"] . "</td>";
                                echo "<td>" . $row["t2_received_ttpack"] . "</td>";
                                echo "<td>" . $row["t2_receipt_sign"] . "</td>";
                                echo "<td>" . $row["received_form_e"] . "</td>";
                                echo "<td>" . $row["packs_received_form_e"] . "</td>";
                                echo "<td>" . $row["received_form_n"] . "</td>";
                                echo "<td>" . $row["packs_received_form_n"] . "</td>";
                                echo "<td>" . $row["received_form_s"] . "</td>";
                                echo "<td>" . $row["packs_received_form_s"] . "</td>";
                                echo "<td>" . $row["received_form_ep"] . "</td>";
                                echo "<td>" . $row["packs_received_form_ep"] . "</td>";
                                echo "<td>" . $row["received_form_np"] . "</td>";
                                echo "<td>" . $row["packs_received_form_np"] . "</td>";
                                echo "<td>" . $row["received_form_sp"] . "</td>";
                                echo "<td>" . $row["packs_received_form_sp"] . "</td>";
                                echo "<td>" . $row["received_airtime"] . "</td>";
                                echo "<td>" . $row["packs_received_airtime"] . "</td>";
                                echo "<td>" . $row["received_alb"] . "</td>";
                                echo "<td>" . $row["number_received_alb"] . "</td>";
                                echo "<td>" . $row["received_pzq"] . "</td>";
                                echo "<td>" . $row["number_received_pzq"] . "</td>";
                                echo "<td>" . $row["received_poles"] . "</td>";
                                echo "<td>" . $row["number_received_poles"] . "</td>";
                                echo "<td>" . $row["initial_"] . "</td>";
                                echo "<td>" . $row["t1_rec_signature_e"] . "</td>";
                                echo "<td>" . $row["forms_k"] . "</td>";
                                echo "<td>" . $row["attnt_prog_id1"] . "</td>";
                                echo "<td>" . $row["attnt_prog_id2"] . "</td>";
                                echo "<td>" . $row["attnt_prog_id3"] . "</td>";
                                echo "<td>" . $row["attnt_id"] . "</td>";
                                echo "<td>" . $row["attnt_no"] . "</td>";
                                echo "<td>" . $row["schisto_total"] . "</td>";
                                echo "<td>" . $row["attnt_sth"] . "</td>";
                                echo "<td>" . $row["attnt_schisto"] . "</td>";
                                echo "<td>" . $row["countyid"] . "</td>";
                                echo "<td>" . $row["county"] . "</td>";
                                echo "<td>" . $row["school_name"] . "</td>";
                                echo "<td>" . $row["attnt_sch"] . "</td>";
                                echo "<td>" . $row["attnt_alb_sch"] . "</td>";
                                echo "<td>" . $row["attnt_total_alb_sch"] . "</td>";
                                echo "<td>" . $row["attnt_alb_tt"] . "</td>";
                                echo "<td>" . $row["attnt_pzq_sch"] . "</td>";
                                echo "<td>" . $row["attnt_total_pzq_sch"] . "</td>";
                                echo "<td>" . $row["attnt_pzq_tt"] . "</td>";
                                echo "<td>" . $row["attnt_total_drugs"] . "</td>";
                                echo "<td>" . $row["drugs_present"] . "</td>";
                                echo "<td>" . $row["drugs_missing"] . "</td>";
                                echo "<td>" . $row["attnt_total_poles"] . "</td>";
                                echo "<td>" . $row["attnt_total_forms_en"] . "</td>";
                                echo "<td>" . $row["attnt_total_form_s"] . "</td>";
                                echo "<td>" . $row["attnt_total_forms_epnp"] . "</td>";
                                echo "<td>" . $row["attnt_total_form_sp"] . "</td>";
                                echo "<td>" . $row["attnt_total_forms"] . "</td>";
                                echo "<td>" . $row["attnt"] . "</td>";

                                echo "</tr>";
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