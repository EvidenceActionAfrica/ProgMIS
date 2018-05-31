<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
require_once('includes/db_functions.php');
require_once("includes/logTracker.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$evidenceaction = new EvidenceAction();
//Privileges settings


require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");

$image = new image;
$insertFile = new UploadFIle;


if (isset($_POST['uploadCSV'])) {
  $table = "health_contacts";
  if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
    $csvMessage = "Upload Failed";
  } else {
    $temp = $_FILES["file"]["tmp_name"];
    $csvMessage = "Upload Successful";
  }

  $filename = $image->upload_image($temp);
  $csvMessage = $insertFile->insertFile($filename, $table);
}

$priv_mail = $_SESSION['staff_email'];
$resPriv = mysql_query("select * from staff where staff_email='$priv_mail'");

while ($row = mysql_fetch_array($resPriv)) {
  $priv_health = $row["priv_moh"];
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
        //Delete
        if (isset($_GET['deleteid'])) {
          $deleteid = $_GET['deleteid'];
          $query = "DELETE FROM health_contacts WHERE id='$deleteid'";
          $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());

          //log entry
          $staff_id = $_SESSION['staff_id'];
          $staff_email = $_SESSION['staff_email'];
          $staff_name = $_SESSION['staff_name'];
          $action = "Delete \"Health Contact\" ";
          $description = "Record ID: " . $deleteid . " deleted";
          $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
          funclogAdminData($arrLogAdminData);
        }

        if (isset($_POST['search_table'])) {
          $county = $_POST['county'];
          $district_name = $_POST['district_name'];
          $dmoh_name = $_POST['dmoh_name'];
          $dmoh_phone = $_POST['dmoh_phone'];
          $dmoh_email = $_POST['dmoh_email'];
          $searchQuery = "SELECT * FROM health_contacts WHERE county LIKE '%$county%'
              AND district LIKE '%$district_name%'
              AND dmoh_name LIKE '%$dmoh_name%'
              AND dmoh_phone LIKE '%$dmoh_phone%'
              AND dmoh_email LIKE '%$dmoh_email%' order by county,district asc ";
          $result_set = mysql_query($searchQuery);
        } else {
          $result_set = mysql_query("SELECT * FROM health_contacts order by county,district  asc");
        }
        ?>

        <form action="#">
          <img src="images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
          <?php if ($priv_health >= 4) { ?>
            <a class="btn-custom-small" href="#importCSV">Import</a>
          <?php } ?><b style="margin-left:20%;width: 100px; font-size:1.5em;">Health Contacts</b>
          <?php if ($priv_health >= 1) { ?>
            <a class="btn-custom-small" href="PHPExcel/AdminData/MoH.php?county=<?php echo $county; ?>&district_name=<?php echo $district_name; ?>&dmoh_name=<?php echo $dmoh_name; ?>&dmoh_phone=<?php echo $dmoh_phone; ?>&dmoh_email=<?php echo $dmoh_email; ?>">Export to Excel</a>
          <?php } if ($priv_health >= 2) { ?>
            <a class="btn-custom-small" href="#addHealthContact">Add Health Contact</a>
          <?php } ?>
        </form>
        <br/>
        <style>
          table tbody tr td a{
            text-decoration:none;
            color:#000000;
          }
        </style>
        <div>
          <form method="post">
            <table  style="width: 100%">
              <thead>
                <tr style="">
                  <th align="center" width="11%">
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
                  <th align="center" width="11%">
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
                  <th align="center" width="15%"><input type="text" style="width: 98%" name="dmoh_name"  value="<?php echo $dmoh_name ?>"/></th>
                  <th align="center" width="10%"><input type="text" style="width: 98%" name="dmoh_phone"  value="<?php echo $dmoh_phone ?>"/></th>
                  <th align="center" width="25%"><input type="text" style="width: 98%" name="dmoh_email"  value="<?php echo $dmoh_email ?>"/></th>
                  <th align="center" width="8%" colspan="1"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                </tr>
              </thead>
            </table>
            <table id="data-table" class="table table-responsive table-hover table-stripped">
              <thead>
                <tr>
                  <th align="Left" width="12%">County</th>
                  <th align="Left" width="12%">Sub-County</th>
                  <th align="Left" width="20%">SCMOH Name</th>
                  <th align="Left" width="15%">SCMOH Mobile</th>
                  <th align="Left" width="30%">SCMOH Email</th>

                  <?php if ($priv_health >= 3) { ?>
          <!--<th align="center" width="4%">Edit</th>-->
                  <?php } ?>
                  <?php if ($priv_health >= 4) { ?>                 
                    <th align="center" width="4%">Del</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = mysql_fetch_array($result_set)) {
                  $id = $row['id'];
                  $county = $row['county'];
                  $district = $row['district'];
                  $dmoh_name = $row['dmoh_name'];
                  $dmoh_phone = $row['dmoh_phone'];
                  $dmoh_email = $row['dmoh_email'];
                  if ($priv_health >= 3) {
                    $link = "health_contacts.php?id=$id&editDetails=1#editHealth";
                  } else if ($priv_health >= 1) {
                    $link = "health_contacts.php?id=$id&viewDetails=1#viewMoH";
                  } else {
                    $link = "health_contacts.php#";
                  }
                  ?> 
                  <tr style="border-bottom: 1px solid #B4B5B0;">
                    <td align="left"> <?php echo "<a href=$link>" . $county . "</a>"; ?> </td> </td>
                    <td align="left"> <?php echo "<a href=$link>" . $district . "</a>"; ?> </td>
                    <td align="left"> <?php echo "<a href=$link>" . $dmoh_name . "</a>"; ?> </td>
                    <td align="left"><?php
                      echo "<a href=$link>" . substr($dmoh_phone, 0, 12);
                      if (strlen($dmoh_phone) > 12)
                        echo "..";
                      echo "</a>";
                      ?>
                    </td>
                    <td align="left"><?php
                      echo "<a href=$link>" . substr($dmoh_email, 0, 30);
                      if (strlen($dmoh_email) > 30)
                        echo "..";
                      echo "</a>";
                      ?>
                    </td> 
                    <?php if ($priv_health >= 3) { ?>
                      <!--edit button-->
          <form method="POST" action="#editHealth">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                       <!-- <td align="center" width="4%"><input type="submit" name="editDetails" value="" style="background: url(images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>-->
          </form>
                    <?php } ?>
                    <?php if ($priv_health >= 4) { ?>
          <td align="center" width="4%"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="images/icons/delete.png" height="20px"></a></td>
                      <p>
                        <?php } ?>
                        </tr>
                        </a>
                          <?php } ?>
                            </tbody>
                          </table>
                        </form>
                      </p>
        </div>
  <?php
$sql = "SELECT timestamp from `health_contacts` order by timestamp desc limit 1";
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
        if (confirm("Are you sure you want to delete?")) {
          location.replace('?deleteid=' + deleteid);
        } else {
          return false;
        }
      }
    </script>
  </body>
</html>







<!--==== Modal ADD ======-->
<div id="addHealthContact" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <?php
    $formSubmitted = false;
    if (isset($_POST['submitAddHealth'])) {

      //Post Values to DB
      $county = $_POST['county'];
      $district = $_POST['district'];
      $dmoh_name = $_POST['dmoh_name'];
      $dmoh_phone = $_POST['dmoh_phone'];
      $dmoh_phone2 = $_POST['dmoh_phone2'];
      $dmoh_email = $_POST['dmoh_email'];
      $dmoh_email2 = $_POST['dmoh_email2'];
      $title = $_POST['title'];
      $dmoh_bank_account = $_POST['dmoh_bank_account'];
      $dmoh_account_number = $_POST['dmoh_account_number'];
      $dmoh_bank_name = $_POST['dmoh_bank_name'];
      $dmoh_bank_branch = $_POST['dmoh_bank_branch'];
      $dmoh_physical_address = $_POST['dmoh_physical_address'];
      $own_vehicle = $_POST['own_vehicle'];
      $vehicle_make_type = $_POST['vehicle_make_type'];
      $district_hq = $_POST['district_hq'];
      $distance_from_district_to_district_hq = $_POST['distance_from_district_to_district_hq'];
      $which_is_closer_g4s_or_postOffice = $_POST['which_is_closer_g4s_or_postOffice'];

      $county = addslashes(trim($county));
      $district = addslashes(trim($district));
      $dmoh_name = addslashes(trim($dmoh_name));
      $dmoh_phone = addslashes(trim($dmoh_phone));
      $dmoh_phone2 = addslashes(trim($dmoh_phone2));
      $dmoh_email = addslashes(trim($dmoh_email));
      $dmoh_email2 = addslashes(trim($dmoh_email2));
      $title = addslashes(trim($title));
      $dmoh_bank_account = addslashes(trim($dmoh_bank_account));
      $dmoh_account_number = addslashes(trim($dmoh_account_number));
      $dmoh_bank_name = addslashes(trim($dmoh_bank_name));
      $dmoh_bank_branch = addslashes(trim($dmoh_bank_branch));
      $dmoh_physical_address = addslashes(trim($dmoh_physical_address));
      $own_vehicle = addslashes(trim($own_vehicle));
      $vehicle_make_type = addslashes(trim($vehicle_make_type));
      $district_hq = addslashes(trim($district_hq));
      $distance_from_district_to_district_hq = addslashes(trim($distance_from_district_to_district_hq));
      $which_is_closer_g4s_or_postOffice = addslashes(trim($which_is_closer_g4s_or_postOffice));

      $query = ( "INSERT INTO health_contacts (
            county,
            district,
            dmoh_name,
            dmoh_phone,
            dmoh_phone2,
            dmoh_email,
            dmoh_email2,
            title,
            dmoh_bank_account,
            dmoh_account_number,
            dmoh_bank_name,
            dmoh_bank_branch,
            dmoh_physical_address,
            own_vehicle,
            vehicle_make_type,
            district_hq,
            distance_from_district_to_district_hq,
            which_is_closer_g4s_or_postOffice  )
        VALUES (
            '$county',
            '$district',
            '$dmoh_name',
            '$dmoh_phone',
            '$dmoh_phone2',
            '$dmoh_email',
            '$dmoh_email2',
            '$title',
            '$dmoh_bank_account',
            '$dmoh_account_number',
            '$dmoh_bank_name',
            '$dmoh_bank_branch',
            '$dmoh_physical_address',
            '$own_vehicle',
            '$vehicle_make_type',
            '$district_hq',
            '$distance_from_district_to_district_hq',
            '$which_is_closer_g4s_or_postOffice')" );
      
	  mysql_query($query) or die(mysql_error());
      $messageToUser = "Record Added Successfully!";


      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];
      $action = "Added \"Health Contact\" ";
      $description = "Record ID: " . $dmoh_name . " added";
      $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      funclogAdminData($arrLogAdminData);
    }
    ?>
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <h1 class="form-title">Add Health Contact</h1>
      <div style="padding: 5px; overflow-y: scroll">
        <!--left div-->
        <div style="float: left; width: 49%;">
          <h3 class="compact">SCMOH Details</h3>
          <table border="0"  cellpadding="0" cellspacing="0" width="100%">
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
                  <select onchange="get_district(this.value);" id="county" name="county" class="input_select_p compact" required >
                    <option value="">Choose County</option>
                    <?php foreach ($insertformdata as $insertformdatacab) { ?>
                      <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
                    <?php } ?>
                  </select>                </td>
              </tr>
              <tr>
                <td>Sub-County </td>
                <td>
                  <select  id="district" name="district" class="input_select_p compact" required>
                    <option value="">Choose Sub-County</option>
                  </select>                </td>
              </tr>
                            <tr>
                <td>SCMOH title</td>
                <td><select name="title"  class="input_select_p compact" >
                    <option value=''<?php if ($title == '') echo 'selected'; ?> ></option>
                    <?php
                    $sql = "SELECT * FROM dropdown_health_titles ORDER BY title ASC";
                    $result = mysql_query($sql);
                    while ($rows = mysql_fetch_array($result)) { //loop table rows
                      ?>
                      <option value="<?php echo $rows['title']; ?>"<?php
                      if ($title == $rows['title']) {
                        echo 'selected';
                      }
                      ?>><?php echo $rows['title']; ?></option>
                            <?php } ?>
                  </select>
                        <?php if ($priv_county_contacts >= 3) { ?>
                  <a  href="dropdown_settings.php"><img src="images/icons/mainEdit.png" style="vertical-align: middle" height="30px"/></a>
                  <?php } ?></td>
              </tr>
              <tr>
                <td>SCMOH Name</td>
                <td><input type="text" name="dmoh_name" class="input_textbox_p compact" value="" required/></td>
              </tr>
              <tr>
                <td>SCMOH Phone</td>
                <td><input type="text" name="dmoh_phone" id="dmoh_phone" class="input_textbox_p compact" maxlength="12" placeholder="254" onKeyUp="isPhoneNumber(this.id);" required/><span id="dmoh_phoneSpan"></span></td>
              </tr>
              <tr>
                <td>SCMOH Phone 2</td>
                <td><input type="text" name="dmoh_phone2" id="dmoh_phone2" class="input_textbox_p compact" maxlength="12" placeholder="254" onKeyUp="isNumeric(this.id);"/><span id="dmoh_phone2Span"></span></td>
              </tr>
              <tr>
                <td>SCMOH Email</td>
                <td><input type="text" name="dmoh_email" class="input_textbox_p compact" /></td>
              </tr>
              <tr>
                <td>SCMOH Email 2</td>
                <td><input type="text" name="dmoh_email2" class="input_textbox_p compact" /></td>
              </tr>
 
              <tr>
                <td>SCMOH Bank Account</td>
                <td><input type="text" name="dmoh_bank_account" class="input_textbox_p compact" /></td>
              </tr>
              <tr>
                <td>SCMOH Account Number</td><td><input type="text" name="dmoh_account_number" class="input_textbox_p compact" value=""/></td>
              </tr>
              <tr>
                <td>SCMOH Bank Name</td><td><input type="text" name="dmoh_bank_name" class="input_textbox_p compact" value=""/></td>
              </tr>
              <tr>
                <td>SCMOH Bank Branch</td><td><input type="text" name="dmoh_bank_branch" class="input_textbox_p compact" value=""/></td>
              </tr>
              
            </thead>
          </table >
          <br/>
          <center>
            <table> <tr>
                <td><input type="submit" class="btn-custom-small" name="submitAddHealth"  value="Add Health Contact"/></td>
              <!--- <td><a href="#close" class="btn-custom-small" >Close</a></td>-->
              </tr> </table>
          </center>
        </div>
        <!--Right div-->
        <div style="float: right; width: 49%">
          <h3 class="compact"><br/>
          </h3>
          <h3 class="compact">Other Details</h3>
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <thead> 
              <tr>
                <td>Do you own a <br/>Sub-County GoK Vehicle?</td><td><input type="text" name="own_vehicle" class="input_textbox_p compact"/></td>
              </tr>
              <tr>
                <td>Vehicle make/type</td><td><input type="text" name="vehicle_make_type" class="input_textbox_p compact" /></td>
              </tr>
              <tr>
                <td>Sub-County HQ</td><td><input type="text" name="district_hq" class="input_textbox_p compact" /></td>
              </tr>
              <tr height="50px">
                <td>Distance from<br/>Sub-County to Sub-County HQ</td><td><input type="text" name="distance_from_district_to_district_hq" class="input_textbox_p compact" value=""/></td>
              </tr>
              <tr>
                <td>Which is closer<br/>G4S or Post-Office</td><td><input type="text" name="which_is_closer_g4s_or_postOffice" class="input_textbox_p compact" value=""/></td>
              </tr>
            </thead>
          </table >
        </div>
      </div>
    </form>
  </div>
</div>


<!--==== Modal EDIT ======-->
<div id="editHealth" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <?php
    if (isset($_GET['editDetails'])) {
      $id = $_GET['id'];

      $result_st = mysql_query("SELECT * FROM health_contacts WHERE id='$id'");
      while ($row = mysql_fetch_array($result_st)) {
        $county = $row['county'];
        $district = $row['district'];
        $dmoh_name = $row['dmoh_name'];
        $dmoh_phone = $row['dmoh_phone'];
        $dmoh_phone2 = $row['dmoh_phone2'];
        $dmoh_email = $row['dmoh_email'];
        $dmoh_email2 = $row['dmoh_email2'];
        $title = $row['title'];
        $dmoh_bank_account = $row['dmoh_bank_account'];
        $dmoh_account_number = $row['dmoh_account_number'];
        $dmoh_bank_name = $row['dmoh_bank_name'];
        $dmoh_bank_branch = $row['dmoh_bank_branch'];
        $dmoh_physical_address = $row['dmoh_physical_address'];
        $own_vehicle = $row['own_vehicle'];
        $vehicle_make_type = $row['vehicle_make_type'];
        $district_hq = $row['district_hq'];
        $distance_from_district_to_district_hq = $row['distance_from_district_to_district_hq'];
        $which_is_closer_g4s_or_postOffice = $row['which_is_closer_g4s_or_postOffice'];
      }
    }
    if (isset($_POST['submitEditMoH'])) {
      $id = $_POST['id'];
      $county = $_POST['county'];
      $district = $_POST['district'];
      $dmoh_name = $_POST['dmoh_name'];
      $dmoh_phone = $_POST['dmoh_phone'];
      $dmoh_phone2 = $_POST['dmoh_phone2'];
      $dmoh_email = $_POST['dmoh_email'];
      $dmoh_email2 = $_POST['dmoh_email2'];
      $title = $_POST['title'];
      $dmoh_bank_account = $_POST['dmoh_bank_account'];
      $dmoh_account_number = $_POST['dmoh_account_number'];
      $dmoh_bank_name = $_POST['dmoh_bank_name'];
      $dmoh_bank_branch = $_POST['dmoh_bank_branch'];
      $dmoh_physical_address = $_POST['dmoh_physical_address'];
      $own_vehicle = $_POST['own_vehicle'];
      $vehicle_make_type = $_POST['vehicle_make_type'];
      $district_hq = $_POST['district_hq'];
      $distance_from_district_to_district_hq = $_POST['distance_from_district_to_district_hq'];
      $which_is_closer_g4s_or_postOffice = $_POST['which_is_closer_g4s_or_postOffice'];

      $county = addslashes(trim($county));
      $district = addslashes(trim($district));
      $dmoh_name = addslashes(trim($dmoh_name));
      $dmoh_phone = addslashes(trim($dmoh_phone));
      $dmoh_phone2 = addslashes(trim($dmoh_phone2));
      $dmoh_email = addslashes(trim($dmoh_email));
      $dmoh_email2 = addslashes(trim($dmoh_email2));
      $title = addslashes(trim($title));
      $dmoh_bank_account = addslashes(trim($dmoh_bank_account));
      $dmoh_account_number = addslashes(trim($dmoh_account_number));
      $dmoh_bank_name = addslashes(trim($dmoh_bank_name));
      $dmoh_bank_branch = addslashes(trim($dmoh_bank_branch));
      $dmoh_physical_address = addslashes(trim($dmoh_physical_address));
      $own_vehicle = addslashes(trim($own_vehicle));
      $vehicle_make_type = addslashes(trim($vehicle_make_type));
      $district_hq = addslashes(trim($district_hq));
      $distance_from_district_to_district_hq = addslashes(trim($distance_from_district_to_district_hq));
      $which_is_closer_g4s_or_postOffice = addslashes(trim($which_is_closer_g4s_or_postOffice));

      $query = ( "UPDATE health_contacts SET
          county ='$county',
          district ='$district',
          dmoh_name ='$dmoh_name',
          dmoh_phone ='$dmoh_phone',
          dmoh_phone2 ='$dmoh_phone2',
          dmoh_email ='$dmoh_email',
          dmoh_email2 ='$dmoh_email2',
          dmoh_bank_account ='$dmoh_bank_account',
          dmoh_account_number ='$dmoh_account_number',
          dmoh_bank_name ='$dmoh_bank_name',
          dmoh_bank_branch ='$dmoh_bank_branch',
          dmoh_physical_address ='$dmoh_physical_address',
          own_vehicle ='$own_vehicle',
          vehicle_make_type ='$vehicle_make_type',
          district_hq ='$district_hq',
          distance_from_district_to_district_hq ='$distance_from_district_to_district_hq',
          which_is_closer_g4s_or_postOffice ='$which_is_closer_g4s_or_postOffice',
		  timestamp = CURRENT_TIMESTAMP  WHERE id='$id' " );
      
	  mysql_query($query) or die(mysql_error());
      $messageToUser = "Record Edited Successfully!";

      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];
      $action = "Edited \"Health Contact\" ";
      $description = "Record ID: " . $dmoh_name . " Edited";
      $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      funclogAdminData($arrLogAdminData);
    }
    ?>
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <h1 class="form-title">Edit Health Contact Details</h1>
      <div style="padding: 5px;">
        <!--left div-->
        <div style="float: left; width: 49%;">
          <h3 class="compact">SCMOH Details</h3>
          <table border="0"  cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <input type="hidden" name="id"  value="<?php echo $id; ?>"/>
              <tr>
                <td>County </td>
                <td>
                  <?php
                  $tablename = 'counties';
                  $fields = 'id, county';
                  $where = '1=1 order by county asc';
                  $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                  ?>
                  <select onchange="get_district2(this.value);" id="county2" name="county" class="input_select_p compact" required >
                    <option value='<?php echo $county; ?>' ><?php echo $county; ?></option>
                    <?php foreach ($insertformdata as $insertformdatacab) { ?>
                      <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
                    <?php } ?>
                  </select>                </td>
              </tr>
              <tr>
                <td>Sub-County </td>
                <td>
                  <select  id="district2" name="district" class="input_select_p compact" required>
                    <option value='<?php echo $district; ?>' ><?php echo $district; ?></option>
                  </select>                </td>
              </tr>
                            <tr>
                <td>SCMOH title</td>
                <td> <select name="title"  class="input_select_p compact">
                    <option value=''<?php if ($title == '') echo 'selected'; ?> ></option>
                    <?php
                    $sql = "SELECT * FROM dropdown_health_titles ORDER BY title ASC";
                    $result = mysql_query($sql);
                    while ($rows = mysql_fetch_array($result)) { //loop table rows
                      ?>
                      <option value="<?php echo $rows['title']; ?>"<?php
                      if ($title == $rows['title']) {
                        echo 'selected';
                      }
                      ?>><?php echo $rows['title']; ?></option>
                            <?php } ?>
                  </select>
                        <?php if ($priv_county_contacts >= 3) { ?>
                  <a  href="dropdown_settings.php"><img src="images/icons/mainEdit.png" style="vertical-align: middle" height="30px"/></a>
                  <?php } ?></td>
              </tr> 
              <tr>
                <td>SCMOH Name</td>
                <td><input type="text" name="dmoh_name" class="input_textbox_p compact"value="<?php echo $dmoh_name; ?>" required/></td>
              </tr>
              <tr>
                <td>SCMOH Phone</td>
                <td><input type="text" name="dmoh_phone" class="input_textbox_p compact" maxlength="12"value="<?php echo $dmoh_phone; ?>" required/></td>
              </tr>
              <tr>
                <td>SCMOH Phone 2</td>
                <td><input type="text" name="dmoh_phone2" class="input_textbox_p compact" maxlength="12" value="<?php echo $dmoh_phone2; ?>"  /></td>
              </tr>
              <tr>
                <td>SCMOH Email</td>
                <td><input type="text" name="dmoh_email" class="input_textbox_p compact" value="<?php echo $dmoh_email; ?>" required/></td>
              </tr>
              <tr>
                <td>SCMOH Email 2</td>
                <td><input type="text" name="dmoh_email2" class="input_textbox_p compact" value="<?php echo $dmoh_email2; ?>"/></td>
              </tr>

              <tr>
                <td>SCMOH Bank Account</td>
                <td><input type="text" name="dmoh_bank_account" class="input_textbox_p compact" value="<?php echo $dmoh_bank_account; ?>" required/></td>
              </tr>
              <tr>
                <td>SCMOH Account Number</td>
                <td><input type="text" name="dmoh_account_number" class="input_textbox_p compact" value="<?php echo $dmoh_account_number; ?>" required/></td>
              </tr>
              <tr>
                <td>SCMOH Bank Name</td>
                <td><input type="text" name="dmoh_bank_name" class="input_textbox_p compact" value="<?php echo $dmoh_bank_name; ?>" required/></td>
              </tr>
              <tr>
                <td>SCMOH Bank Branch</td>
                <td><input type="text" name="dmoh_bank_branch" class="input_textbox_p compact" value="<?php echo $dmoh_bank_branch; ?>" required/></td>
              </tr>
              <tr>
                <td>Physical Address</td>
                <td><textarea name="dmoh_physical_address" class="input_textbox_p compact" rows="1"><?php echo $dmoh_physical_address; ?></textarea></td>
              </tr>
            </thead>
          </table >
          <br/>
          <center>
            <div>
              <input type="submit" class="btn-custom" name="submitEditMoH"  value="Edit Health Details"/>
            </div>
          </center>
        </div>
        <!--Right div-->
        <div style="float: right; width: 49%">
          <h3 class="compact">Other  Details</h3>
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <thead> 
              <tr>
                <td>Do you own a <br/>Sub-County GoK Vehicle?</td><td><input type="text" name="own_vehicle" class="input_textbox_p compact" value="<?php echo $own_vehicle; ?>" /></td>
              </tr>
              <tr>
                <td>Vehicle make/type</td><td><input type="text" name="vehicle_make_type" class="input_textbox_p compact" value="<?php echo $vehicle_make_type; ?>" /></td>
              </tr>
              <tr>
                <td>Sub-County HQ</td><td><input type="text" name="district_hq" class="input_textbox_p compact" value="<?php echo $district_hq; ?>"/></td>
              </tr>
              <tr height="50px">
                <td>Distance from<br/>Sub-County to Sub-County HQ</td><td><input type="text" name="distance_from_district_to_district_hq" class="input_textbox_p compact"value="<?php echo $distance_from_district_to_district_hq; ?>" /></td>
              </tr>
              <tr>
                <td>Which is closer<br/>G4S or Post-Office</td><td><input type="text" name="which_is_closer_g4s_or_postOffice" class="input_textbox_p compact" value="<?php echo $which_is_closer_g4s_or_postOffice; ?>" /></td>
              </tr>
            </thead>
          </table >
        </div>
        <div class="vclear"></div>
      </div> 
    </form>
  </div>
</div>



<!--===== Modal Import ===========================-->
<div id="importCSV" class="modalDialog">
  <div style="width:380px">
    <a href="#close" title="Close" class="close">X</a>
    <div >
      <h1 class="form-title">Upload health contacts </h1><br/>
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
          <?php if ($priv_health >= 4) { ?>
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
<div id="viewMoH" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <h1 class="form-title">View Health Contact Details</h1>
    <?php
    if (isset($_GET['viewDetails'])) {
      $id = $_GET['id'];

      $result_st = mysql_query("SELECT * FROM health_contacts WHERE id='$id'");
      while ($row = mysql_fetch_array($result_st)) {
        $county = $row['county'];
        $district = $row['district'];
        $dmoh_name = $row['dmoh_name'];
        $dmoh_phone = $row['dmoh_phone'];
        $dmoh_phone2 = $row['dmoh_phone2'];
        $dmoh_email = $row['dmoh_email'];
        $dmoh_email2 = $row['dmoh_email2'];
        $title = $row['title'];
        $dmoh_bank_account = $row['dmoh_bank_account'];
        $dmoh_account_number = $row['dmoh_account_number'];
        $dmoh_bank_name = $row['dmoh_bank_name'];
        $dmoh_bank_branch = $row['dmoh_bank_branch'];
        $dmoh_physical_address = $row['dmoh_physical_address'];
        $own_vehicle = $row['own_vehicle'];
        $vehicle_make_type = $row['vehicle_make_type'];
        $district_hq = $row['district_hq'];
        $distance_from_district_to_district_hq = $row['distance_from_district_to_district_hq'];
        $which_is_closer_g4s_or_postOffice = $row['which_is_closer_g4s_or_postOffice'];
      }
    }
    ?>
    <div style="padding: 5px;">
      <!--left div-->
      <div style="float: left; width: 49%;">
        <h3 class="compact">SCMOH Details</h3>
        <table border="0"  cellpadding="0" cellspacing="0" width="100%">
          <thead>
            <tr>
              <td>County</td><td><input type="text" class="input_textbox_p compact" value="<?php echo $county; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Sub-County</td><td><input type="text" class="input_textbox_p compact" value="<?php echo $district; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMOH Name</td>
              <td><input type="text" name="dmoh_name" class="input_textbox_p compact" value="<?php echo $dmoh_name; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMOH Phone</td>
              <td><input type="text" name="dmoh_phone" class="input_textbox_p compact"  value="<?php echo $dmoh_phone; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMOH Phone 2</td>
              <td><input type="text" name="dmoh_phone2" class="input_textbox_p compact" value="<?php echo $dmoh_phone2; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMOH Email</td>
              <td><input type="email" name="dmoh_email" class="input_textbox_p compact" value="<?php echo $dmoh_email; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMOH Email 2</td>
              <td><input type="email" name="dmoh_email2" class="input_textbox_p compact" value="<?php echo $dmoh_email2; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMOH Title</td>
              <td>  <select name="title"  style="width: 58%;" readonly>
                    <option value=''<?php if ($title == '') echo 'selected'; ?> ></option>
                    <?php
                    $sql = "SELECT * FROM dropdown_health_titles ORDER BY title ASC";
                    $result = mysql_query($sql);
                    while ($rows = mysql_fetch_array($result)) { //loop table rows
                      ?>
                      <option value="<?php echo $rows['title']; ?>"<?php
                      if ($title == $rows['title']) {
                        echo 'selected';
                      }
                      ?>><?php echo $rows['title']; ?></option>
                            <?php } ?>
                  </select>
                        <?php if ($priv_county_contacts >= 3) { ?>
                  <a  href="dropdown_settings.php"><img src="images/icons/mainEdit.png" style="vertical-align: middle" height="30px"/></a>
                  <?php } ?></td>
            </tr> 
            <tr>
              <td>SCMOH Bank Account</td>
              <td><input type="text" name="dmoh_bank_account" class="input_textbox_p compact" value="<?php echo $dmoh_bank_account; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMOH Account Number</td>
              <td><input type="text" name="dmoh_account_number" class="input_textbox_p compact" value="<?php echo $dmoh_account_number; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMOH Bank Name</td>
              <td><input type="text" name="dmoh_bank_name" class="input_textbox_p compact" value="<?php echo $dmoh_bank_name; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMOH Bank Branch</td>
              <td><input type="text" name="dmoh_bank_branch" class="input_textbox_p compact" value="<?php echo $dmoh_bank_branch; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Physical Address</td>
              <td><textarea name="dmoh_physical_address" class="input_textbox_p compact" rows="3" readonly><?php echo $dmoh_physical_address; ?></textarea></td>
            </tr>
          </thead>
        </table >
      </div>
      <!--Right div-->
      <div style="float: right; width: 49%">
        <h3 class="compact">Other  Details</h3>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <thead> 
            <tr>
              <td>Do you own a<br/>Sub-County GoK Vehicle?</td><td><input type="text" name="own_vehicle" class="input_textbox_p compact" value="<?php echo $own_vehicle; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Vehicle make/type</td><td><input type="text" name="vehicle_make_type" class="input_textbox_p compact" value="<?php echo $vehicle_make_type; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Sub-County HQ</td><td><input type="text" name="district_hq" class="input_textbox_p compact" value="<?php echo $district; ?>" readonly/></td>
            </tr>
            <tr height="40px">
              <td>Distance from<br/>Sub-County to Sub-County HQ</td><td><input type="text" name="distance_from_district_to_district_hq" class="input_textbox_p compact" value="<?php echo $district; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Which is closer<br/>G4S or Post-Office</td><td><input type="text" name="which_is_closer_g4s_or_postOffice" class="input_textbox_p compact" value="<?php echo $district; ?>" readonly/></td>
            </tr>
          </thead>
        </table >
      </div>
    </div>
    <div class="vclear"></div> 
  </div>
</div>


<script>
      //GET district
      function get_district(txt) {
        $.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
          $('#district').html(data);//alert(data);
        });
      }
      //GET district
      function get_district2(txt) {
        $.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
          $('#district2').html(data);//alert(data);
        });
      }
</script>
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

