<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
require_once('includes/db_functions.php');
require("includes/logTracker.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$evidenceaction = new EvidenceAction();
$level = $_SESSION['level'];

require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");

$image = new image;
$insertFile = new UploadFIle;


if (isset($_POST['uploadCSV'])) {
  $table = "districts";
  if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
  } else {
    //  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    //  echo "Type: " . $_FILES["file"]["type"] . "<br>";
    // echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    //  echo "Stored in: " . $temp=$_FILES["file"]["tmp_name"];
    $temp = $_FILES["file"]["tmp_name"];
    $csvMessage = "Upload Successful";
  }


  $filename = $image->upload_image($temp);

  $csvMessage = $insertFile->insertFile($filename, $table);
  //Connect as normal above
}

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_districts = $row['priv_districts'];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("includes/meta-link-script.php");
    ?>

    <link rel="stylesheet" type="text/css" href="css/textext.core.css">
      <link rel="stylesheet" type="text/css" href="css/textext.plugin.tags.css">
        <link rel="stylesheet" type="text/css" href="css/textext.plugin.autocomplete.css">

          <script src="js/jquery.min.js"></script>
          </head>
          <body onload="document.getElementById('imgLoading').style.visibility = 'hidden';">
            <!---------------- header start ------------------------>
            <div class="header">
              <div style="float: left">  <img src="images/logo.png" />  </div>
              <div class="menuLinks">
                <?php
                require_once ("includes/menuNav.php");
                require_once ("includes/loginInfo.php");
                ?>
              </div>
            </div>
            <div class="clearFix"></div>
            <!---------------- content body ------------------------>
            <div class="contentMain">
              <div class="contentLeft">
                <?php
                require_once ("includes/menuLeftBar-AdminData.php");
                ?>
              </div>
              <div class="contentBody">
                <!--================================================-->
                <?php
                //Delete
                if (isset($_GET['deleteid'])) {
                  $deleteid = $_GET['deleteid'];
                  $query = "DELETE FROM districts WHERE id='$deleteid'";
                  $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
                  //header("Location:masterTrainerView.php?status=deleted&mstatus=mt");
                  //log entry
                  $staff_id = $_SESSION['staff_id'];
                  $staff_email = $_SESSION['staff_email'];
                  $staff_name = $_SESSION['staff_name'];
                  $action = "Delete \"district\"";
                  $description = "Record ID: " . $deleteid . " deleted";
                  $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
                  funclogAdminData($arrLogAdminData);
                }

                // number of divisions in district
                function numberOfDivisions($district_name) {
                  $query = "SELECT * FROM divisions WHERE district_name='$district_name'";
                  $result = mysql_query($query) or die("<h1>Cant get divisions</h1>" . mysql_error());
                  $num = mysql_num_rows($result);
                  return $num;
                }

                // number of schools in district
                function numberOfSchools($district_name) {
                  $query = "SELECT * FROM schools WHERE district_name='$district_name'";
                  $result = mysql_query($query) or die("<h1>Cant get divisions</h1>" . mysql_error());
                  $num = mysql_num_rows($result);
                  return $num;
                }

                //count all the row of the table
                function row_total() {
                  $query_row = "SELECT * FROM districts";
                  $result_row = mysql_query($query_row) or die(mysql_error());
                  $num_row = mysql_num_rows($result_row);
                  return $num_row;
                }

                if (isset($_POST['search_table'])) {
                  $county = $_POST['county'];
                  $district_name = $_POST['district_name'];
                  $district_id = $_POST['district_id'];
                  $donor = $_POST['donor'];
                  $treatment_type = $_POST['treatment_type'];
                  $searchQuery = "SELECT * FROM districts WHERE county LIKE '%$county%'
                    AND district_name LIKE '%$district_name%'
                    AND donor LIKE '%$donor%'
                    AND treatment_type LIKE '%$treatment_type%'
                    AND district_id LIKE '%$district_id%'  ORDER BY county,district_name ASC";
                  $result_set = mysql_query($searchQuery);
                } else if (isset($_POST['advanced_search_table'])) {
                  $countyArray = $_POST;
                  $countyArray = join("', '", $countyArray);
                  $searchQuery = "SELECT * FROM districts WHERE county IN ('$countyArray')";
                  $result_set = mysql_query($searchQuery);
                } else {
                  $result_set = mysql_query("SELECT * FROM districts ORDER BY county,district_name ASC");
                }

                $query_suggestions = mysql_query("SELECT DISTINCT district_name FROM districts");

                $sqlMax = "Select * from districts";
                $resultMax = mysql_query($sqlMax);
                $max = mysql_num_rows($resultMax);

                $suggestions = array();

                while ($var = mysql_fetch_assoc($query_suggestions)) {
                  array_push($suggestions, $var['district_name']);
                }

                $suggestions = join("', '", $suggestions);

                if (isset($_POST['btnSubmitPage'])) {
                  $resultSQL = "SELECT * FROM districts ORDER BY county,district_name LIMIT 50";

                  if ($_POST["selectPageNumber"]) {
                    $pageOffset = isset($_POST["selectPageNumber"]) ? $_POST["selectPageNumber"] : 1;

                    $offset = ($pageOffset - 1) * 50;
                    $resultSQL.=" OFFSET " . $offset;
                  }
                  $result_set = mysql_query($resultSQL);
                }
                ?>
                <form action="#">
                  <!---
                <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
                  -->
                  <img src="images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
                  <?php if ($priv_districts >= 4) { ?>
                    <a class="btn-custom-small" href="#importCSV">Import</a>
                  <?php } ?>
                  <b style="margin-left:20%;width: 100px; font-size:1.5em;">Sub Counties List</b>
                  <a class="btn-custom-small" href="PHPExcel/AdminData/districts.php?county=<?php echo $county; ?>&district_name=<?php echo $district_name; ?>&district_id=<?php echo $district_id; ?>">Export to Excel</a>
                  <!--<a id="export-button" class="btn-custom-small" href="#">Export to Excel</a>-->

                  <?php if ($priv_districts >= 2) { ?>
                    <a class="btn-custom-small" href="#addDistrict">Add Sub Counties</a>
                  <?php } ?>
                </form>


                <?php
                $pages = ceil($max / 50);

                $count = isset($_GET["Page"]) ? $_GET["Page"] : 1;
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

                if ($pageOffset <= 1) {
                  $pageOffset = 1;
                }
                ?>
                <!--                                <form method="post" >
                                                    <b> Page </b>
                                                    <select name='selectPageNumber' onchange='submitPage();' style='width:70px'>
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
                                                    <b>of</b>  <?php echo $pages; ?> <b>Districts List Pages</b>
                                                    <input  type="submit" value="submitPage" name='btnSubmitPage' id='btnSubmitPage' style="visibility: hidden"/>
                                                </form>-->
                <div style="display:inline-block;width:100%;">
                  <p id="advanced_open" class="pull-right btn btn-small" style="color:#333;cursor:pointer;margin-right: 20px;">Advanced Search</p>
                </div>
                <div style="margin-right: 20px" id="search_div">
                  <form action="districts.php" method="post">
                    <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                      <thead>
                        <tr style="border-bottom: 0px;">
                          <th align="center" width="15%">
                            <select name="county"  style="width: 98%;" onchange="submitForm();">
                              <option value=''<?php if ($county == '') echo 'selected'; ?> >Select County</option>
                              <?php
                              $sql = "SELECT * FROM counties ORDER BY county ASC";
                              $result = mysql_query($sql);
                              while ($rows = mysql_fetch_array($result)) { //loop table rows
                                ?>
                                <option value="<?php echo $rows['county']; ?>"<?php
                                if ($county == $rows['county']) {
                                  echo 'selected';
                                }
                                ?>><?php echo $rows['county']; ?></option>
                                      <?php } ?>
                            </select>
                          </th>
                          <th align="center" width="15%">
                            <select name="district_name"  style="width: 98%;" onchange="submitForm();">
                              <option value=''<?php if ($district_name == '') echo 'selected'; ?> ></option>
                              <?php
                              $sql = "SELECT * FROM districts WHERE county='$county' ORDER BY district_name ASC";
                              $result = mysql_query($sql);
                              while ($rows = mysql_fetch_array($result)) { //loop table rows
                                ?>
                                <option value="<?php echo $rows['district_name']; ?>"<?php
                                if ($district_name == $rows['district_name']) {
                                  echo 'selected';
                                }
                                ?>
                                        ><?php echo $rows['district_name']; ?></option>
                                      <?php } ?>
                            </select>
                          </th>
                          <th align="center" width="15%"><input type="text" style="width: 98%" name="district_id" value="<?php echo $district_id ?>"placeholder="District ID"/></th>

                          <th align="center" width="15%">
                            <select name="donor"  style="width: 98%;" onchange="submitForm();">
                              <option value=""></option>

                              <?php
                              $sql = "SELECT DISTINCT donor FROM districts";
                              $result = mysql_query($sql);
                              while ($rows = mysql_fetch_array($result)) { //loop table rows
                                ?>
                                <option value="<?php echo $rows['donor']; ?>"<?php
                                if ($donor == $rows['donor']) {
                                  echo 'selected';
                                }
                                ?>><?php echo $rows['donor']; ?></option>
                                      <?php } ?>
                            </select>
                          </th>
                          <th align="center" width="15%">
                            <select name="treatment_type"  style="width: 98%;" onchange="submitForm();">
                              <option value=""></option>

                              <?php
                              $sql = "SELECT DISTINCT treatment_type FROM districts";
                              $result = mysql_query($sql);
                              while ($rows = mysql_fetch_array($result)) { //loop table rows
                                ?>
                                <option value="<?php echo $rows['treatment_type']; ?>"<?php
                                if ($treatment_type == $rows['treatment_type']) {
                                  echo 'selected';
                                }
                                ?>><?php echo $rows['treatment_type']; ?></option>
                                      <?php } ?>
                            </select>
                          </th>
                          <th align="center" width="7%"><input type="text" style="width: 98%" readonly/></th>
                          <th align="center" width="7%"><input type="text" style="width: 98%" readonly/></th>
                          <th align="center" width="12%" colspan="3" ><input type="submit" class='btn-filter' style="width: 98%" id="btnSearchSubmit"value="Search" name="search_table"  /></th>
                        </tr>
                      </thead>
                    </table>
                  </form>
                </div>

                <!--Advanced Search Container-->
                <div id="advanced_search_div"  style="display:none;margin:0 auto 20px;opacity:0;margin-left:45%;">
                  <p id="advanced_close" class="pull-right btn-small btn-warning"style="margin:-25px 20px 0 0;cursor:pointer;float:right;">X Close</p>
                  <style type="text/css">
                    .text-wrap {
                      height:50px!important;
                    }
                  </style>

                  <form action="districts.php" method="post">
                    <label for="textarea">Enter multiple Sub County names in the text-area below:</label>
                    <textarea id="textarea" class="example" rows="1" style="width:400px;height:50px;" name="filters"></textarea>
                    <input type="submit" class="btn-filter btn-info" value="Search" name="advanced_search_table"/>
                  </form>

                  <script type="text/javascript" src="js/textext.core.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.autocomplete.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.tags.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.suggestions.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.filter.js"></script>
                  <script type="text/javascript">
            var suggestion = ['<?php echo $suggestions ?>'];
            $('#textarea')
                    .textext({
              plugins: 'autocomplete suggestions tags filter',
              suggestions: suggestion
            });
                  </script>

                </div>
                <style>
                  table tbody tr td a{
                    text-decoration:none;
                    color:#000000;
                  }
                </style>

                <div style="margin-right: 20px">
                  <table  id="data-table" class="table table-responsive table-hover table-stripped">
                    <thead>
                      <tr style="border-bottom: 1px solid #B4B5B0;">
                        <th align="Left" >County</th>
                        <th align="Left" >Sub County</th>
                        <th align="Left" >Sub County ID</th>
                        <th align="Left" >Donor</th>
                        <th align="Left">T.Type</th>
                        <th align="Left">No of Divisions</th>
                        <th align="Left">No of Schools</th></br>

                        <?php if ($priv_districts >= 4) { ?>
                          <th align="center" width="4%">Del</th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      while ($row = mysql_fetch_array($result_set)) {
                        $id = $row['id'];
                        $county = $row['county'];
                        $district_name = $row['district_name'];
                        $district_id = $row['district_id'];
                        $donor = $row['donor'];
                        $treatment_type = $row['treatment_type'];
                        if ($priv_districts >= 3) {
                          $link = "districts.php?id=$id&editDetails=1#editDistrict";
                        } else {
                          $link = "districts.php?id=$id&viewDetails=1#viewDistrict";
                        }
                        ?>
                        <tr style="border-bottom: 1px solid #B4B5B0;">

                          <td align="left" width="15%"><?php echo"<a href=$link>" . $county . "</a>"; ?></td>
                          <td align="left" width="15%"> <?php echo"<a href=$link>" . $district_name . "</a>"; ?></td>
                          <td align="left" width="15%"> <?php echo"<a href=$link>" . $district_id . "</a>"; ?></td>
                          <td align="left" width="12%"> <?php echo"<a href=$link>" . $donor . "</a>"; ?></td>
                          <td align="left" width="12%"> <?php echo"<a href=$link>" . $treatment_type . "</a>"; ?></td>
                          <td align="left" width="12%"><?php echo"<a href=$link>" . $numberOfDivisions = numberOfDivisions($district_name) . "</a>"; ?> </td>
                          <td align="left" width="12%"> <?php echo"<a href=$link>" . $numberOfSchools = numberOfSchools($district_name) . "</a>"; ?> </td>
                          <?php if ($priv_districts >= 4) { ?>
                            <td align="center" width="7%"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="images/icons/delete.png" height="20px"></a></td>
                          <?php } ?>
                        </tr>

                      <?php } ?>
                    </tbody>
                  </table>                                    
                  <b style="padding-bottom: 2%; padding-left: 1%" > Total Number of records: <?php echo number_format(row_total()); ?> rows.</b> 
                </div>
<p></p>
<?php
$sql = "SELECT timestamp from `districts` order by timestamp desc limit 1";
$time = mysql_query($sql);
while($timestamp = mysql_fetch_array($time)){
echo " Data last updated: " .$timestamp['timestamp'];}
?>
                <!--================================================-->
              </div><!--end of content Main -->

            </div>
            <div class="clearFix"></div>
            <!---------------- Footer ------------------------>
            <!--<div class="footer">  </div>-->

            <script>
            function submitForm() {
              document.getElementById('imgLoading').style.visibility = "visible";
              var selectButton = document.getElementById('btnSearchSubmit');
              selectButton.click();
            }
            function submitPage() {
              var selectButton = document.getElementById('btnSubmitPage');
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
            <!--Toggle Advanced Search-->
            <script type="text/javascript">
              var searchHeight = $('#search_div').innerHeight() + $('#advanced_open').outerHeight();
              $("#advanced_open").click(function() {
                $('#search_div').animate({
                  'height': 0, 'opacity': 0
                }, 100, function() {
                  $(this).css('display', 'none');
                  $('#advanced_search_div').css({
                    'display': 'inline-block', 'height': 'auto', }).animate({
                    'opacity': 1
                  }, 200);
                });
              });
              $('#advanced_close').click(function() {
                $('#advanced_search_div').animate({
                  'height': 0, 'opacity': 0
                }, 200, function() {
                  $(this).css('display', 'none');
                  $('#search_div').css({'display': 'block'}).animate({
                    'height': '26px', 'opacity': '1'
                  }, 100);
                });
              });
            </script>
            <script type="text/javascript" src="js/tableExport.js"></script>
            <script type="text/javascript" src="js/jquery.base64.js"></script>
            <script type="text/javascript">
              $('#export-button').click(function() {
                $('#data-table').tableExport({
                  type: 'excel',
                  escape: 'false',
                  consoleLog: 'true',
                  ignoreColumn: [6, 7, 8],
                  htmlContent: 'true'
                });
              });
            </script>

          </body>
          </html>


          <!--==== Modal ADD ======-->
          <div id="addDistrict" class="modalDialog">
            <div style="width:380px">
              <a href="#close" title="Close" class="close">X</a>
              <?php
              if (isset($_POST['submitAddDistrict'])) {
                //Get County ID
                $result = mysql_query("SELECT county_id,RIGHT(county_id,2)  FROM counties WHERE county='{$_POST['county']}'");
                while ($row = mysql_fetch_array($result)) {
                  $county_id = $row['county_id'];
                  $last2_digits = $row['RIGHT(county_id,2)'];
                }
                //Generate District ID
                $r1 = mysql_query("SELECT id FROM districts ORDER BY id DESC LIMIT 1");
                while ($row = mysql_fetch_array($r1)) {
                  $last_district_id = $row['id'];
                  $next_district_id = $last_district_id + 1;
                }
                $new_district_id = 'DIS-' . '' . sprintf("%02d", $next_district_id);

                //Post Values to DB
                $county = $_POST['county'];
                $district_name = $_POST['district_name'];
                $donor = $_POST['donor'];
                $treatment_type = $_POST['treatment_type'];

                $county = addslashes(trim($county));
                $district_name = addslashes(trim($district_name));
                $district_id = addslashes(trim($district_id));
                $donor = addslashes(trim($donor));
                $treatment_type = addslashes(trim($treatment_type));

                //Check if district_name Exists
                $query1 = "SELECT * FROM districts WHERE district_name = '{$_POST['district_name']}' LIMIT 1";
                $check_district = mysql_query($query1);
                $avail_district = mysql_num_rows($check_district);
                if ($avail_district == 0) {

                  $query = ( "INSERT INTO districts (county,district_name,district_id,donor,treatment_type,county_id)
        VALUES (
            '$county',
            '$district_name',
            '$new_district_id',
            '$donor',
            '$treatment_type',
            '$county_id')" );
                  mysql_query($query) or die(mysql_error("Could not enter"));
                  $messageToUser = "$district_name Added Successfully!";
                  $action = "Added a district";
                  $description = "Record ID: " . $new_district_id . " for " . $district_name . " district Added";
                } else if ($avail_district >= 1) {
                  $error_message.="Similar District name (" . $district_name . ") exists in the System.";
                  $action = "Added a district Failed";
                  $description = "Record ID: " . $new_district_id . " for " . $district_name . " district failed to Add";
                }


                $staff_id = $_SESSION['staff_id'];
                $staff_email = $_SESSION['staff_email'];
                $staff_name = $_SESSION['staff_name'];

                $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
                funclogAdminData($arrLogAdminData);
              }
              ?>

              <form action="" method="post">
                <?php include("includes/messageBox.php"); ?>
                <div >
                  <h1 class="form-title">Add Sub-County</h1><br/>
                </div>
                <center>
                  <div style="padding: 5px; margin: 0px auto">
                    <table border="0">
                      <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                      <tr>
                        <td>County </td>
                        <td>
                          <select name="county"  class="input_select" required>
                            <option value=''></option>
                            <?php
                            $sql = "SELECT * FROM counties ORDER BY county ASC";
                            $result = mysql_query($sql);
                            while ($rows = mysql_fetch_array($result)) { //loop table rows
                              ?>
                              <option value="<?php echo $rows['county']; ?>" ><?php echo $rows['county']; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Sub-Counties Name </td><td><input type="text" name="district_name" class="input_textbox" required/></td>
                      </tr>
                      <tr>
                        <td>Donor </td>
                        <td>
                          <select name="donor"  class="input_select" required>
                            <?php
                            $sql = "SELECT DISTINCT donor FROM districts ORDER BY donor ASC";
                            $result = mysql_query($sql);
                            while ($rows = mysql_fetch_array($result)) { //loop table rows
                              ?>
                              <option value="<?php echo $rows['donor']; ?>" ><?php echo $rows['donor']; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Treatment Type </td>
                        <td>
                          <select name="treatment_type"  class="input_select" required >
                            <?php
                            $sql = "SELECT DISTINCT treatment_type FROM districts ORDER BY treatment_type ASC";
                            $result = mysql_query($sql);
                            while ($rows = mysql_fetch_array($result)) { //loop table rows
                              ?>
                              <option value="<?php echo $rows['treatment_type']; ?>" ><?php echo $rows['treatment_type']; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="vclear"></div>
                </center>
                <br/><br/>
                <center>
                  <div>
                    <input type="submit" class="btn-custom" name="submitAddDistrict"  value="Add Sub County"/>
                    <a href="districts.php" class="btn-custom">Refresh  List</a>
                  </div>
                </center>
              </form>

            </div>
          </div>


          <?php
          if (isset($_GET['editDetails'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM districts WHERE id='$id'";
            $result_st = mysql_query($sql);
            ?>
            <!--==== Modal EDIT ======-->
            <div id="editDistrict" class="modalDialog">
              <div style="width:450px">
                <a href="#close" title="Close" class="close">X</a>
                <?php
                while ($row = mysql_fetch_array($result_st)) {
                  $id = $row['id'];
                  $county = $row['county'];
                  $district_name = $row['district_name'];
                  $district_id = $row['district_id'];
                  $donor = $row['donor'];
                  $treatment_type = $row['treatment_type'];
                  //$wave = $_POST['wave'];
                }
                if (isset($_POST['submitEditDistrict'])) {
                  $id = $_POST['id'];
                  $county = $_POST['county'];
                  $district_name = $_POST['district_name'];
                  $district_id = $_POST['district_id'];
                  $donor = $_POST['donor'];
                  $treatment_type = $_POST['treatment_type'];

                  $county = addslashes(trim($county));
                  $district_name = addslashes(trim($district_name));
                  $district_id = addslashes(trim($district_id));
                  $donor = addslashes(trim($donor));
                  $treatment_type = addslashes(trim($treatment_type));

                  //Check if district_name Exists
                  $query1 = "SELECT * FROM districts WHERE district_name = '{$_POST['district_name']}' AND county = '{$_POST['county']}' LIMIT 1";
                  $check_district = mysql_query($query1);
                  $avail_district = mysql_num_rows($check_district);
                  /*
                    if ($avail_district == 0) {

                    $query = ( "UPDATE districts SET
                    county ='Bomet',
                    district_name = '$district_name',
                    district_id = '$district_id',
                    donor = '$donor',
                    treatment_type = '$treatment_type'
                    WHERE id='$id' " );

                    mysql_query($query) or die(mysql_error("Could not enter"));
                    $messageToUser = "$district_name Updated Successfully!";
                    $action = "Edited a district";
                    $description = "Record ID: " . $new_district_id . " for " . $district_name . " district Edited";
                    } else if ($avail_district >= 1) {
                    $error_message.="Similar District name (" . $district_name . ") exists in the System.";
                    $action = "Failed to Edit the district";
                    $description = "Record ID: " . $district_id . " for " . $district_name . " district failed to edit";
                    }
                   */
                  $query = ( "UPDATE districts SET
            county ='$county',
            district_name = '$district_name',
            district_id = '$district_id',
            donor = '$donor',
            treatment_type = '$treatment_type',
			timestamp = CURRENT_TIMESTAMP
              WHERE id='$id' " );

                  mysql_query($query) or die(mysql_error("Could not enter"));
                  $messageToUser = "$district_name Updated Successfully!";
                  $action = "Edited a district";
                  $description = "Record ID: " . $new_district_id . " for " . $district_name . " district Edited";

                  $staff_id = $_SESSION['staff_id'];
                  $staff_email = $_SESSION['staff_email'];
                  $staff_name = $_SESSION['staff_name'];

                  $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
                  funclogAdminData($arrLogAdminData);
                }
                ?>
                <form action="" method="post">
                  <?php include("includes/messageBox.php"); ?>
                  <div >
                    <h1 class="form-title">Edit Sub-County</h1><br/>
                  </div>
                  <center>
                    <div style="padding: 5px; margin: 0px auto">
                      <table border="0">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <tr>
                          <td>County </td>
                          <td>
                            <select name="county"  class="input_select">
                              <option <?php echo "value='$county' 'selected';" ?> ><?php echo $county; ?></option>
                              <?php
                              $sql = "SELECT * FROM counties ORDER BY county DESC";
                              $result = mysql_query($sql);
                              while ($rows = mysql_fetch_array($result)) { //loop table rows
                                ?>
                                <option value="<?php echo $rows['county']; ?>"<?php ?>><?php echo $rows['county']; ?></option>
                              <?php } ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Sub-counties Name</td><td><input type="text" name="district_name" class="input_textbox" value="<?php echo $district_name; ?>" required/></td>
                        </tr>
                        <tr>
                          <td>Sub-counties ID</td><td><input type="text" name="district_id" class="input_textbox" value="<?php echo $district_id; ?>" readonly/></td>
                        </tr>
                        <tr>
                          <td>Donor </td>
                          <td>
                            <select name="donor"  class="input_select">
                              <option value=''<?php if ($donor == '') echo 'selected'; ?> ></option>
                              <?php
                              $sql = "SELECT DISTINCT donor FROM districts ORDER BY donor ASC";
                              $result = mysql_query($sql);
                              while ($rows = mysql_fetch_array($result)) { //loop table rows
                                ?>
                                <option value="<?php echo $rows['donor']; ?>"<?php
                                if ($donor == $rows['donor']) {
                                  echo 'selected';
                                }
                                ?>><?php echo $rows['donor']; ?></option>
                                      <?php } ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Treatment Type </td>
                          <td>
                            <select name="treatment_type"  class="input_select" required>
                              <?php
                              $sql = "SELECT DISTINCT treatment_type FROM districts ORDER BY treatment_type ASC";
                              $result = mysql_query($sql);
                              while ($rows = mysql_fetch_array($result)) { //loop table rows
                                ?>
                                <option value="<?php echo $rows['treatment_type']; ?>"<?php
                                if ($treatment_type == $rows['treatment_type']) {
                                  echo 'selected';
                                }
                                ?>><?php echo $rows['treatment_type']; ?></option>
                                      <?php } ?>
                            </select>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </center>
                  <br/><br/>
                  <center>
                    <div>
                      <input type="submit" class="btn-custom" name="submitEditDistrict"  value="Edit Details"/>
                      <a href="districts.php" class="btn-custom">Refresh Sub-County List</a>
                    </div>
                  </center>
                </form>
              </div>
            </div>
            <?php
          }
          ?>

          <!--===== Modal Import ===========================-->
          <div id="importCSV" class="modalDialog">
            <div style="width:380px">
              <a href="#close" title="Close" class="close">X</a>
              <div >
                <h1 class="form-title">Upload Sub counties </h1><br/>
              </div>
              <?php
              if (isset($csvMessage)) {
                echo '<h4 style="color:#050000;background-color:#A2FF7E;text-align:center;">' . $csvMessage . '</h4>';
              }
              ?>
              <center>
                <div style="padding: 5px; margin: 0px auto">

                  <form action="" method="post"
                        enctype="multipart/form-data">
                    <label for="file">Filename:</label>
                    <input type="file" name="file" id="file"/>
                    <?php if ($priv_districts >= 4) { ?>
                      <input type="submit" id='btnSubmit' name="uploadCSV" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>
                      <?php
                    }
                    ?>

                  </form>
                </div>
              </center>
              <br/>
              <center>
                <div>
                  <a href="#close" class="btn-custom" > Close</a>
                </div>
              </center>
            </div>
          </div>
          <!--===== Modal View ===========================-->
          <div id="viewDistrict" class="modalDialog">
            <div style="width:400px">
              <a href="#close" title="Close" class="close">X</a>
              <div >
                <h1 class="form-title">View Sub Counties</h1><br/>
              </div>
              <?php
              if (isset($_GET['viewDetails'])) {
                $county = $_GET['county'];
                $district_name = $_GET['district_name'];
                $district_id = $_POST['district_id'];
                $donor = $_GET['donor'];
                $treatment_type = $_GET['treatment_type'];
                $numberOfSchools = $_GET['numberOfSchools'];
                $numberOfDivisions = $_GET['numberOfDivisions'];
              }
              ?>
              <center>
                <div style="padding: 5px; margin: 0px auto">
                  <table border="0">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <tr>
                      <td>County </td><td><input type="text" class="input_textbox" value="<?php echo $county; ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td>Sub-Counties Name</td><td><input type="text" class="input_textbox" value="<?php echo $district_name; ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td>Sub-Counties ID</td><td><input type="text" name="district_id" class="input_textbox" value="<?php echo $district_id; ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td>Donor</td><td><input type="text" name="district_id" class="input_textbox" value="<?php echo $donor; ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td>Treatment Type</td><td><input type="text" name="district_id" class="input_textbox" value="<?php echo $treatment_type; ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td>Number Of Divisions</td><td><input type="text" class="input_textbox" value="<?php echo $numberOfDivisions; ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td>Number Of Schools</td><td><input type="text" class="input_textbox" value="<?php echo $numberOfSchools; ?>" readonly/></td>
                    </tr>
                  </table>
                </div>
              </center>
              <br/><br/>
              <center>
                <div>
                  <a href="#close" class="btn-custom" > Close</a>
                </div>
              </center>
            </div>
          </div>


          <script>
              //ADD function ========================================================================
              //GET district
              function get_district(txt) {
                $.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
                  $('#selectdistrict').html(data);//alert(data);
                });
              }
              //GET divisions
              function get_division(txt) {
                $.post('ajax_dropdown.php', {checkval: 'division', district: txt}).done(function(data) {
                  $('#selectdivision').html(data);//alert(data);
                });
              }

              //EDIT =================================================================================
              //GET district
              function get_district2(txt) {
                $.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
                  $('#selectdistrict2').html(data);//alert(data);
                });
              }
              //GET divisions
              function get_division2(txt) {
                $.post('ajax_dropdown.php', {checkval: 'division', district: txt}).done(function(data) {
                  $('#selectdivision2').html(data);//alert(data);
                });
              }
          </script>
          <!-- datatables -->
          <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
          <link rel="stylesheet" type="text/css" href="css/dataTables.css">

            <script type="text/javascript">
              $(document).ready(function() {
                $('#data-table').dataTable();
              });
            </script>

