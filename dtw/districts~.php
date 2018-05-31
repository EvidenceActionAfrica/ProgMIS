<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
include("includes/logTracker.php");

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
        ?>

        <form action="#">
          <!---
        <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
          -->
          <img src="images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
          <b style="margin-left:20%;width: 100px; font-size:1.5em;">Sub-Counties List</b>
  <!--<a class="btn-custom-small" href="PHPExcel/AdminData/districts.php?county=<?php echo $county; ?>&district_name=<?php echo $district_name; ?>&district_id=<?php echo $district_id; ?>">Export to Excel</a>-->
          <a id="export-button" class="btn-custom-small" href="#">Export to Excel</a>
          <a class="btn-custom-small" href="#addDistrict">Add Sub-Counties</a>
        </form>
        <div style="display:inline-block;width:100%;">
          <p id="advanced_open" class="pull-right btn btn-small" style="color:#333;cursor:pointer;margin-right: 20px;">Advanced Search</p>
        </div>
        <div style="margin-right: 20px" id="search_div">
          <form action="districts.php" method="post">
            <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
              <thead>
                <!--<input type="text" value="<?php //echo $searchQuery;                         ?>"/>-->
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
                        ?>><?php echo $rows['district_name']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                  <th align="center" width="15%"><input type="text" style="width: 98%" name="district_id" value="<?php echo $district_id ?>"placeholder="District ID"/></th>

                  <th align="center" width="15%">
                    <select name="donor"  style="width: 98%;" onchange="submitForm();">
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
        <div id="advanced_search_div" style="display:none;margin:0 auto 20px;height:0;opacity:0;">
          <p id="advanced_close" class="pull-right btn-small btn-warning" style="margin-right:20px;cursor:pointer;">X Close</p>
          <form action="districts.php" method="post">
            <ul style="display:inline-block;padding-left:0;list-style:none;margin-bottom:10px;">

              <?php
              $query = mysql_query("SELECT county FROM counties ORDER BY county ASC");
              $i = 0;
              while ($result = mysql_fetch_assoc($query)) {
                ?>
                <li style="width:15%;float:left;" >
                  <label class="checkbox inline">
                    <input type="checkbox" name="county_checkbox_<?php echo $i; ?>" value="<?php echo $result['county']; ?>"> <?php echo $result['county']; ?>
                  </label>
                </li>
                <?php
                $i++;
              }
              ?>
            </ul>
            <input type="submit" class="btn-filter btn-info" style="width: 170px;float:right; margin-top: -10px; font-size: 12px" value="Advanced Search" name="advanced_search_table"/>
          </form>

        </div>

        <div>
          <table id="data-table" class="table table-responsive table-hover table-stripped">
            <thead>
              <th align="Left" >County</th>
              <th align="Left" >Sub County</th>
              <th align="Left" >Sub County ID</th>
              <th align="Left" >Donor</th>
              <th align="Left">T.Type</th>
              <th align="Left">Number of wards</th>
              <th align="Left"  >Number of Schools</th>
              <th align="center">View</th>
              <th align="center">Edit</th>
              <th align="center">Del</th>

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

                if ($priv_counties >= 3) {
                  $link = "counties.php?county_id=$county_id&county=$county&numberOfDistricts=$numberOfDistricts";
                  $link.="&numberOfDivisions=$numberOfDivisions&numberOfSchools=$numberOfSchools&editDetails=1";
                  $link.="#editCounty";
                } else {
                  $link = "counties.php#";
                }
                ?>

                <tr>
                  <td> <?php echo $county; ?>  </td>
                  <td> <?php echo $district_name; ?> </td>
                  <td> <?php echo $district_id; ?> </td>
                  <td> <?php echo $donor; ?> </td>
                  <td> <?php echo $treatment_type; ?> </td>
                  <td> <?php echo $numberOfDivisions = numberOfDivisions($district_name); ?> </td>
                  <td> <?php echo $numberOfSchools = numberOfSchools($district_name); ?> </td>

                  <!--view button-->
                  <form method="POST" action="#viewDistrict">
                    <input type="hidden" name="county" value="<?php echo $county; ?>"/>
                    <input type="hidden" name="district_name" value="<?php echo $district_name; ?>"/>
                    <input type="hidden" name="district_id" value="<?php echo $district_id; ?>"/>
                    <input type="hidden" name="donor" value="<?php echo $donor; ?>"/>
                    <input type="hidden" name="treatment_type" value="<?php echo $treatment_type; ?>"/>
                    <input type="hidden" name="numberOfDivisions" value="<?php echo $numberOfDivisions; ?>"/>
                    <input type="hidden" name="numberOfSchools" value="<?php echo $numberOfSchools; ?>"/>

                    <td>
                      <?php if ($priv_districts >= 1) { ?>
                        <input type="submit" name="viewDetails" value="" style="background: url(images/icons/view2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/>
                      <?php } ?>
                    </td>
                    <!--<td align="center" width="4%"><a href="#viewDistrict"><img src="images/icons/view.png" height="20px"></a></td>-->
                  </form>
                  <!--edit button-->
                  <form method="POST" action="#editDistrict">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="hidden" name="county" value="<?php echo $county; ?>"/>
                    <input type="hidden" name="district_name" value="<?php echo $district_name; ?>"/>
                    <input type="hidden" name="district_id" value="<?php echo $district_id; ?>"/>
                    <input type="hidden" name="donor" value="<?php echo $donor; ?>"/>
                    <input type="hidden" name="treatment_type" value="<?php echo $treatment_type; ?>"/>

                    <td>
                      <?php if ($priv_districts >= 3) { ?>
                        <input type="submit" name="editDetails" value="" style="background: url(images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/>
                      </td>
                    <?php } ?>
              <!--<td align="center" width="4%"><a href="schoolsEdit.php?id=<?php echo $data['id']; ?>"><img src="images/icons/edit.png" height="20px"></a></td>-->
                  </form>
                  <td>
                    <?php if ($priv_districts >= 3) { ?>
                      <a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="images/icons/delete.png" height="20px"></a>
                    <?php } ?>
                  </td>
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


    <script type="text/javascript">

    function submitForm() {
      document.getElementById('imgLoading').style.visibility = "visible";
      var selectButton = document.getElementById('btnSearchSubmit');
      selectButton.click();
    }
    </script>
    <!--Delete dialog-->
    <script>
      function show_confirm(deleteid) {
        if (confirm("Are you Sure you want to delete?")) {
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
            'display': 'inline-block'}).animate({
            'height': '225px', 'opacity': 1
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
          gnoreColumn: [6, 7, 8]
        });
      });
    </script>

  </body>
</html>







<!--==== Modal ADD ======-->
<div id="addDistrict" class="modalDialog">
  <div>
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
        <h1 class="form-title">Add District</h1><br/>
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
          <input type="submit" class="btn-custom" name="submitAddDistrict"  value="Add District"/>
          <a href="districts.php" class="btn-custom">Refresh District List</a>
        </div>
      </center>
    </form>
  </div>
</div>


<!--==== Modal EDIT ======-->
<div id="editDistrict" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <?php
    if (isset($_POST['editDetails'])) {
      $id = $_POST['id'];
      $county = $_POST['county'];
      $district_name = $_POST['district_name'];
      $district_id = $_POST['district_id'];
      $donor = $_POST['donor'];
      $treatment_type = $_POST['treatment_type'];
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
      $query1 = "SELECT * FROM districts WHERE district_name = '{$_POST['district_name']}' LIMIT 1";
      $check_district = mysql_query($query1);
      $avail_district = mysql_num_rows($check_district);
      if ($avail_district == 0) {

        $query = ( "UPDATE districts SET
            county ='$county',
            district_name = '$district_name',
            district_id = '$district_id',
            donor = '$donor',
            treatment_type = '$treatment_type'
              WHERE id='$id' " );
        mysql_query($query) or die(mysql_error("Could not enter"));
        $messageToUser = "$district_name Added Successfully!";
        $action = "Edited a district";
        $description = "Record ID: " . $new_district_id . " for " . $district_name . " district Edited";
      } else if ($avail_district >= 1) {
        $error_message.="Similar District name (" . $district_name . ") exists in the System.";
        $action = "Failed to Edit the district";
        $description = "Record ID: " . $district_id . " for " . $district_name . " district failed to edit";
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
        <h1 class="form-title">Edit District</h1><br/>
      </div>
      <center>
        <div style="padding: 5px; margin: 0px auto">
          <table border="0">
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <tr>
              <td>County </td>
              <td>
                <select name="county"  class="input_select">
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
                <select name="treatment_type"  class="input_select">
                  <option value=''<?php if ($treatment_type == '') echo 'selected'; ?> ></option>
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
          <input type="submit" class="btn-custom" name="submitEditDistrict"  value="Edit District Details"/>
          <a href="districts.php" class="btn-custom">Refresh District List</a>
        </div>
      </center>
    </form>
  </div>
</div>



<!--===== Modal View ===========================-->
<div id="viewDistrict" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <div >
      <h1 class="form-title">View District</h1><br/>
    </div>
    <?php
    if (isset($_POST['viewDetails'])) {
      $county = $_POST['county'];
      $district_name = $_POST['district_name'];
      $district_id = $_POST['district_id'];
      $donor = $_POST['donor'];
      $treatment_type = $_POST['treatment_type'];
      $numberOfSchools = $_POST['numberOfSchools'];
      $numberOfDivisions = $_POST['numberOfDivisions'];
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
            <td>Number Of Wards</td><td><input type="text" class="input_textbox" value="<?php echo $numberOfDivisions; ?>" style="width: 50px; text-align: center" readonly/></td>
          </tr>
          <tr>
            <td>Number Of Schools</td><td><input type="text" class="input_textbox" value="<?php echo $numberOfSchools; ?>" style="width: 50px; text-align: center"  readonly/></td>
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
  <script>

//==============================  block return key from submitting form ===============================
    document.onkeypress = function(e) {
      e = e || window.event;
      if (typeof e != 'undefined') {
        var tgt = e.target || e.srcElement;
        if (typeof tgt != 'undefined' && /input/i.test(tgt.nodeName))
          return (typeof e.keyCode != 'undefined') ? e.keyCode != 13 : true;
      }
      console.log("enter Block workin...");
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

