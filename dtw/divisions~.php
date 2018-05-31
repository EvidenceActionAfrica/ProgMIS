<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
require_once('includes/db_functions.php');
require("includes/logTracker.php");
$evidenceaction = new EvidenceAction();
$level = $_SESSION['level'];

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_divisions = $row['priv_divisions'];
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
                  //log entry

                  $staff_id = $_SESSION['staff_id'];
                  $staff_email = $_SESSION['staff_email'];
                  $staff_name = $_SESSION['staff_name'];
                  $action = "Delete \"divisions\" ";
                  $description = "Record ID: " . $deleteid . " deleted";
                  $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
                  funclogAdminData($arrLogAdminData);

                  // echo $description;
                  $query = "DELETE FROM divisions WHERE id='$deleteid'";
                  $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
                  //header("Location:masterTrainerView.php?status=deleted&mstatus=mt");
                }

                // number of shcools in division
                function numberOfSchools($division_name) {
                  $query = "SELECT * FROM schools WHERE division_name='$division_name'";
                  $result = mysql_query($query) or die("<h1>Cant get schools</h1>" . mysql_error());
                  $num = mysql_num_rows($result);
                  return $num;
                }

                if (isset($_POST['search_table'])) {
                  $county = $_POST['county'];
                  $district_name = $_POST['district_name'];
                  $division_name = $_POST['division_name'];
                  $division_id = $_POST['division_id'];
                  //$wave = $_POST['wave'];
                  $searchQuery = "SELECT * FROM divisions WHERE county LIKE '%$county%'
                          AND district_name LIKE '%$district_name%'
                          AND division_name LIKE '%$division_name%'
                          AND division_id LIKE '%$division_id%'  ORDER BY county,district_name,division_name ASC ";
                  $result_set = mysql_query($searchQuery);
                } else if (isset($_POST['advanced_search_table'])) {

                  $myArray = json_decode($_POST['filters']);

                  $myArray = join("', '", $myArray);

                  $searchQuery = "SELECT * FROM divisions WHERE district_name IN ('$myArray')";
                  $result_set = mysql_query($searchQuery);
                } else {
                  $result_set = mysql_query("SELECT * FROM divisions ORDER BY county,district_name,division_name ASC LIMIT 50");
                }

                $query_suggestions = mysql_query("SELECT DISTINCT district_name FROM divisions");

                $sqlMax = "Select * from divisions";
                $resultMax = mysql_query($sqlMax);
                $max = mysql_num_rows($resultMax);

                $suggestions = array();

                while ($var = mysql_fetch_assoc($query_suggestions)) {
                  array_push($suggestions, $var['district_name']);
                }

                $suggestions = join("', '", $suggestions);

                if (isset($_POST['btnSubmitPage'])) {
                  $resultSQL = "SELECT * FROM divisions ORDER BY county,district_name,division_name LIMIT 50";

                  if ($_POST["selectPageNumber"]) {
                    $pageOffset = isset($_POST["selectPageNumber"]) ? $_POST["selectPageNumber"] : 1;

                    $offset = ($pageOffset - 1) * 50;
                    $resultSQL.=" OFFSET " . $offset;
                  }
                  $result_set = mysql_query($resultSQL);
                }
                ?>
                <!--<h1><u>Divisions List</u></h1>-->
                <form action="#">
                    <!---
                  <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
                  -->
                    <img src="images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
                  <b style="margin-left:20%;width: 100px; font-size:1.5em;">Wards List</b>
                         <!--<a class="btn-custom-small" href="PHPExcel/AdminData/divisions.php?county=<?php echo $county; ?>&district_name=<?php echo $district_name; ?>&division_name=<?php echo $division_name; ?>&division_id=<?php echo $division_id; ?>">Export to Excel</a>-->
                  <a id="export-button" class="btn-custom-small" href="#">Export to Excel</a>
                  <a class="btn-custom-small" href="#addDivision">Add Ward</a>
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
                <form method="post" >
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
                  <b>of</b>  <?php echo $pages; ?> <b>Divisions List Pages</b>
                  <input  type="submit" value="submitPage" name='btnSubmitPage' id='btnSubmitPage' style="visibility: hidden"/>
                </form>
                <div style="display:inline-block;width:100%;">
                  <p id="advanced_open" class="pull-right btn btn-small" style="color:#333;cursor:pointer;margin-right: 20px;">Advanced Search</p>

                </div>

                <div style=" margin-right: 20px" id="search_div">
                  <form method="post">
                    <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                      <thead>
                        <tr style="">
                          <th align="center" width="10%">
                            <select name="county"  style="width: 98%;" onchange="submitForm();">
                              <option value=''<?php if ($county == '') echo 'selected'; ?> ></option>
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
                          <th align="center" width="10%">
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
                                ?>><?php echo $rows['district_name']; ?></option>
                                      <?php } ?>
                            </select>
                          </th>
                          <th align="center" width="10%">
                            <select name="division_name"  style="width: 98%;" onchange="submitForm();">
                              <option value=''<?php if ($district_name == '') echo 'selected'; ?> ></option>
                              <?php
                              $sql = "SELECT * FROM divisions WHERE county='$county' AND district_name='$district_name' ORDER BY division_name ASC";
                              $result = mysql_query($sql);
                              while ($rows = mysql_fetch_array($result)) { //loop table rows
                                ?>
                                <option value="<?php echo $rows['division_name']; ?>"<?php
                                if ($division_name == $rows['division_name']) {
                                  echo 'selected';
                                }
                                ?>><?php echo $rows['division_name']; ?></option>
                                      <?php } ?>
                            </select>
                          </th>
                          <th align="center" width="10%"><input type="text" style="width: 98%" name="division_id"  value="<?php echo $division_id ?>"/></th>
                          <th align="center" width="7%"><input type="text" style="width: 98%" name=""  value="" readonly/></th>
                          <th align="center" width="10%" colspan="3"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
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

                  <form action="divisions.php" method="post">
                    <label for="textarea">Enter multiple District names in the text-area below:</label>
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

                <div style="margin-right: 20px">
                  <table  id="data-table" class="table table-responsive table-hover table-stripped">
                    <thead>
                      <tr style="border-bottom: 1px solid #B4B5B0;">
                        <th align="Left" width="15%">County</th>
                        <th align="Left" width="15%">Sub-County</th>
                        <th align="Left" width="15%">Wards</th>
                        <th align="Left" width="15%">Ward ID</th>
                        <th align="Left" width="10%">Number of Schools</th>
                            <?php if ($priv_divisions >= 1) { ?>
                        <th align="center" width="4%">View</th>
                         <?php } ?>
                          <?php if ($priv_divisions >= 3) { ?>
                        <th align="center" width="4%">Edit</th>
                          <?php } ?>
                         <?php if ($priv_divisions >= 4) { ?>
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
                        $division_name = $row['division_name'];
                        $division_id = $row['division_id'];
                        //$wave = $row['wave'];
                        ?>
                        <tr style="border-bottom: 1px solid #B4B5B0;">

                          <td align="left" width="15%"> <?php echo $county; ?>  </td>
                          <td align="left" width="15%"> <?php echo $district_name; ?> </td>
                          <td align="left" width="15%"> <?php echo $division_name; ?> </td>
                          <td align="left" width="15%"> <?php echo $division_id; ?> </td>
                          <td align="left" width="10%"> <?php echo numberOfSchools($division_name); ?>  </td>

                    <?php if ($priv_divisions >= 1) { ?>
                          <!--view button-->
                          <form method="POST" action="#viewDivision">
                            <input type="hidden" name="county" value="<?php echo $county; ?>"/>
                            <input type="hidden" name="district_name" value="<?php echo $district_name; ?>"/>
                            <input type="hidden" name="division_name" value="<?php echo $division_name; ?>"/>
                            <input type="hidden" name="division_id" value="<?php echo $division_id; ?>"/>
                            <input type="hidden" name="wave" value="<?php echo $wave; ?>"/>

                            <td align="center" width="4%"><input type="submit" name="viewDetails" value="" style="background: url(images/icons/view2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                            <!--<td align="center" width="4%"><a href="#viewDivision"><img src="images/icons/view.png" height="20px"></a></td>-->
                          </form>
                     <?php } ?>
                           <?php if ($priv_divisions >= 3) { ?>
                          <!--edit button-->
                          <form method="POST" action="#editDivision">
                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <input type="hidden" name="county" value="<?php echo $county; ?>"/>
                            <input type="hidden" name="district_name" value="<?php echo $district_name; ?>"/>
                            <input type="hidden" name="division_name" value="<?php echo $division_name; ?>"/>
                            <input type="hidden" name="division_id" value="<?php echo $division_id; ?>"/>
                            <input type="hidden" name="wave" value="<?php echo $wave; ?>"/>
                            <td align="center" width="4%"><input type="submit" name="editDetails" value="" style="background: url(images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                            <!--<td align="center" width="4%"><a href="schoolsEdit.php?id=<?php echo $data['id']; ?>"><img src="images/icons/edit.png" height="20px"></a></td>-->
                          </form>
                         <?php } ?>
                           <?php if ($priv_divisions >= 4) { ?>
                          <td align="center" width="4%"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="images/icons/delete.png" height="20px"></a></td>
                          <?php } ?>
                        </tr>
                      
                    <?php } ?>
                          </tbody>
                  </table>
                </div>

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
          <div id="addDivision" class="modalDialog">
            <div>
              <a href="#close" title="Close" class="close">X</a>
              <?php
              if (isset($_POST['submitAddDivision'])) {
                //record Posted Values
                $county = $_POST['selectcounty'];
                $district_name = $_POST['selectdistrict'];
                $division_name = $_POST['division_name'];

                $county = addslashes(trim($county));
                $district_name = addslashes(trim($district_name));
                $division_name = addslashes(trim($division_name));

                //Check if division_name Exists
                $query1 = "SELECT * FROM divisions WHERE county = '{$_POST['selectcounty']}' AND district_name = '{$_POST['selectdistrict']}' AND division_name = '{$_POST['division_name']}' LIMIT 1";
                $check_division = mysql_query($query1);
                $avail_division = mysql_num_rows($check_division);

                if ($avail_division == 0) {//record not in DB
                  //Get District ID
                  $result = mysql_query("SELECT district_id,RIGHT(district_id,3)  FROM districts WHERE district_name='$district_name' ");
                  while ($row = mysql_fetch_array($result)) {
                    $district_id_code = $row['RIGHT(district_id,3)'];
                  }

                  //Get District ID
                  $r2 = mysql_query("SELECT id FROM divisions ORDER BY id DESC LIMIT 1");
                  while ($row = mysql_fetch_array($r2)) {
                    $last_division_id = $row['id'];
                    $next_division_id = $last_division_id + 1;
                  }
                  $new_division_id = 'DIV-' . $district_id_code . '-' . sprintf("%03d", $next_division_id);

                  //Insert to DB
                  $query = ( "INSERT INTO divisions (county,district_name,division_name,division_id) VALUES (
                        '$county',
                        '$district_name',
                        '$division_name',
                        '$new_division_id')" );
                  mysql_query($query) or die(mysql_error("Could not enter"));
                  $messageToUser = "$division_name Added Successfully!";
                  $action = "Added \"division\"";
                  $description = "Record ID: " . $new_division_id . "Added";
                } else if ($avail_division >= 1) {
                  $error_message.="Similar Division name (" . $division_name . ") exists in the System.";
                  $action = "Failed  'Add Division'";
                  $description = "Record ID: " . $new_division_id . " Failed To Add";
                }


                //log entry
                $staff_id = $_SESSION['staff_id'];
                $staff_email = $_SESSION['staff_email'];
                $staff_name = $_SESSION['staff_name'];
                // echo $staff_id;
                $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
                funclogAdminData($arrLogAdminData);
              }
              ?>
              <form action="" method="post">
                <?php include("includes/messageBox.php"); ?>
                <div >
                  <h1 class="form-title">Add Division</h1><br/>
                </div>
                <div style="padding: 5px;">
                  <center>
                    <div >
                      <table border="0">
                        <thead>
                          <tr>
                            <td>County </td>
                            <td>
                              <?php
                              $tablename = 'counties';
                              $fields = 'id, county';
                              $where = '1=1 order by county asc';
                              $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                              ?>
                              <select onchange="get_district(this.value);" id="selectcounty" name="selectcounty" class="input_select" required>
                                <option value="">Choose County</option>
                                <?php foreach ($insertformdata as $insertformdatacab) { ?>
                                  <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
                                <?php } ?>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>District </td>
                            <td>
                              <select onchange="get_division(this.value);" id="selectdistrict" name="selectdistrict" class="input_select" required>
                                <option value="">Choose Sub-County</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Ward Name </td>
                            <td><input type="text" name="division_name" class="input_textbox" placeholder="" value="" required/></td>
                          </tr>
                        </thead>
                      </table >
                    </div>
                  </center>
                </div>
                <br/><br/><br/>
                <center>
                  <div>
                    <input type="submit" class="btn-custom" name="submitAddDivision"  value="Add Division"/>
                    <a href="divisions.php" class="btn-custom">Refresh Division List</a>
                  </div>
                </center>
              </form>
            </div>
          </div>

          <!--==== Modal EDIT ======-->
          <div id="editDivision" class="modalDialog">
            <div>
              <a href="#close" title="Close" class="close">X</a>
              <?php
              if (isset($_POST['editDetails'])) {
                $id = $_POST['id'];
                $county = $_POST['county'];
                $district_name = $_POST['district_name'];
                $division_name = $_POST['division_name'];
                $division_id = $_POST['division_id'];
                //$wave = $_POST['wave'];
              }
              if (isset($_POST['submitEditSchool'])) {
                $id = $_POST['id'];
                $county = $_POST['county'];
                $district_name = $_POST['district_name'];
                $division_name = $_POST['division_name'];
                $division_id = $_POST['division_id'];

                $county = addslashes(trim($county));
                $district_name = addslashes(trim($district_name));
                $division_name = addslashes(trim($division_name));
                $division_id = addslashes(trim($division_id));

                //Check if division_name Exists
                $query1 = "SELECT * FROM divisions WHERE county = '$county'  AND district_name = '$district_name' AND division_name = '$division_name' LIMIT 1";
                $check_division = mysql_query($query1);
                $avail_division = mysql_num_rows($check_division);

                if ($avail_division == 0) {//record not in DB
                  $query = ( "UPDATE divisions SET
                    county ='$county',
                    district_name = '$district_name',
                    division_name = '$division_name',
                    division_id = '$division_id'  WHERE id='$id' " );
                  mysql_query($query) or die(mysql_error("Could not enter"));
                  $messageToUser = "Record Updated Successfully!";
                  $action = "Division Updated";
                  $description = "Record ID: " . $division_id . " updated";
                } else if ($avail_division >= 1) {
                  $error_message.="Similar Division name (" . $division_name . ") exists in the System.";
                  $action = "Failed \"Edit Division\"";
                  $description = "Record ID: " . $division_id . " Not Updated";
                }


                //log entry
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
                  <h1 class="form-title">Edit Division</h1><br/>
                </div>
                <center>
                  <div style="padding: 5px;">
                    <div>
                      <table border="0">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <tr>
                          <td>County </td>
                          <td>
                            <?php
                            $tablename = 'counties';
                            $fields = 'id, county';
                            $where = '1=1 order by county asc';
                            $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                            ?>
                            <select onchange="get_district2(this.value);" id="selectcounty2" name="county" class="input_select" required>
                              <option value="<?php echo $county; ?>"><?php echo $county; ?></option>
                              <?php foreach ($insertformdata as $insertformdatacab) { ?>
                                <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
                              <?php } ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Sub-Counties </td>
                          <td>
                            <select onchange="get_division2(this.value);" id="selectdistrict2" name="district_name" class="input_select" required>
                              <option value="<?php echo $district_name; ?>"><?php echo $district_name; ?></option>
                            </select>
                          </td>
                        </tr> 
                        <tr>
                          <td>Ward Name</td><td><input type="text" name="division_name" class="input_textbox" value="<?php echo $division_name; ?>" /></td>
                        </tr>
                        <tr>
                          <td>Ward ID</td><td><input type="text" name="division_id" class="input_textbox" value="<?php echo $division_id; ?>" readonly/></td>
                        </tr>
                      </table >
                    </div>
                  </div>
                  <br/>
                  <div>
                    <input type="submit" class="btn-custom" name="submitEditSchool"  value="Edit Division Details"/>
                    <a href="divisions.php" class="btn-custom">Refresh Ward List</a>
                  </div>
                </center>
              </form>
            </div>
          </div>

          <!--===== Modal View ===========================-->
          <div id="viewDivision" class="modalDialog">
            <div>
              <a href="#close" title="Close" class="close">X</a>
              <div >
                <h1 class="form-title">View Wards</h1><br/>
              </div>
              <?php
              if (isset($_POST['viewDetails'])) {
                $county = $_POST['county'];
                $district_name = $_POST['district_name'];
                $division_name = $_POST['division_name'];
                $division_id = $_POST['division_id'];
                //$wave = $_POST['wave'];
              }
              ?>
              <div style="padding: 5px;">
                <center>
                  <div >
                    <table border="0">
                      <tr>
                        <td>County</td><td><input type="text" class="input_textbox" value="<?php echo $county; ?>" readonly/></td>
                      </tr>
                      <tr>
                        <td>Sub-County</td><td><input type="text" class="input_textbox" value="<?php echo $district_name; ?>" readonly/></td>
                      </tr>
                      <tr>
                        <td>Ward</td><td><input type="text" class="input_textbox" value="<?php echo $division_name; ?>" readonly/></td>
                      </tr>
                      <tr>
                        <td>Ward ID</td><td><input type="text" class="input_textbox" value="<?php echo $division_id; ?>" readonly/></td>
                      </tr>
                    </table >
                  </div>
                  <br/><br/>
                  <div>
                    <a href="#close" class="btn-custom" > Close</a>
                  </div>
                </center>
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
  } );
</script>

