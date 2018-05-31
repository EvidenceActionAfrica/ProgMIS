<?php
// require_once ('../includes/config.php');
// require_once ('../includes/auth.php');
// require_once ("../includes/functions.php");
// require_once ('../includes/form_functions.php');
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); //use root
// require_once ("../includes/functions.php");
// require_once ("../includes/form_functions.php");

require_once('assumptions.func.php');
include "reverseCascade.func.php";

include "class.image.php"; //image class to upload the excel to file
include "class.insert.php"; // insert class to insert the csv to db
$tabActive = "tab1";

$image = new image;
$insertFile = new UploadFIle;

$divisions = $Cascade->getDivisions();
$districts = $Cascade->getDistricts();
$counties = $Cascade->getCounties();
// require_once ('../includes/db_functions.php');
//$evidenceaction = new EvidenceAction();

if (isset($_POST['csv_upload'])) {

  if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
  } else {
    // echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    // echo "Type: " . $_FILES["file"]["type"] . "<br>";
    // echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    // echo "Stored in: " . $temp=$_FILES["file"]["tmp_name"];
    $temp = $_FILES["file"]["tmp_name"];
  }

  // save the file to folder
  echo "<br>";
  echo $filename = $image->upload_image($temp);
  // $filename = str_replace('/', '\\', $filename);
  echo "<br>";
  echo "done";

  $insertFile->insertFile($filename, 'a_bysch');
  //Connect as normal above
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php");    ?>
  </head>
  <body onload="document.getElementById('imgLoading').style.visibility = 'hidden';">
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
        <!--================================================-->

        <!--tab skeleton-->
        <div class="tabbable" >
          <ul class="nav nav-tabs">
            <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Add Return Form</a></li>
            <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">View Return Form</a></li>

          </ul>
          <div class="tab-content">
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
              <form method="post" action="" name="csv_upload_form" id="csv_upload" enctype="multipart/form-data">
                <div class="vspan1 vfloatleft">
                  <label>County</label>
                  <select onchange="get_district(this.value);">
                    <?php
                    foreach ($counties as $key => $value) {
                      echo "<option value=" . $value['county_id'] . ">" . $value['county_name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="vspan1 vfloatleft">
                  <label>District</label>
                  <select onchange="get_division(this.value);" id="selectdistrict" name="selectdistrict">
                    <option value="">Choose District</option></select>



                <!-- <select>
                  <?php
                  foreach ($districts as $key => $value) {
                    echo "<option>" . $value['dis'] . "</option>";
                  }
                  ?>
                </select> -->
                </div>

                <div class="vspan1 vfloatleft">
                  <label>Division</label>
                  <select id="selectdivision" name="selectdivision" onchange="get_school(this.value);">
                    <option value="">Choose Division</option>
                  </select>

                </div>

                <!-- <div class="vclear"></div> -->
                <label for="file">Filename:</label>
                <input type="file" name="file" id="file" required/><br/>
                <div class="vspan1 v-top-margin10 vfloatleft">
                  <input class="btn-custom-tiny" type="submit" name="csv_upload" value="Upload" >
                </div>
              </form>
            </div>
            <!--end tab 1-->

            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
              <?php include "form_s.php"; ?>
            </div>

          </div>
        </div>



        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->


    <!--filter includes-->
    <script type="text/javascript" src="css/filter-as-you-type/jquery.min.js"></script>
    <script type="text/javascript" src="css/filter-as-you-type/jquery.quicksearch.js"></script>
    <script type="text/javascript">
        $(function() {
          $('input#id_search').quicksearch('table tbody tr');
        });

        function submitForm() {
          document.getElementById('imgLoading').style.visibility = "visible";
          var selectButton = document.getElementById('btnSearchSubmit');
          selectButton.click();
        }
    </script>
    <!--Delete dialog-->
    <script>
      function show_confirm(deleteid) {
        if (confirm("Are You Sure you want to delete?")) {
          location.replace('?deleteid=' + deleteid);
        } else {
          return false;
        }
      }
    </script>
  </body>
</html>


<script>
  //GET district
  function get_district(txt) {
    $.post('reverseCascade.func.php', {checkval: 'district', county: txt}).done(function(data) {
      console.log(data);
      $('#selectdistrict').html(data);//alert(data);
      console.log("hmmmm2");
    });
  }
  //GET divisions
  function get_division(txt) {
    $.post('reverseCascade.func.php', {checkval: 'division', district: txt}).done(function(data) {
      console.log(data);
      $('#selectdivision').html(data);//alert(data);
    });
  }
  //GET Schools
  function get_school(txt) {
    $.post('ajax_dropdown.php', {checkval: 'school', division: txt}).done(function(data) {
      $('#selectschool').html(data);//alert(data);
    });
  }

</script>







