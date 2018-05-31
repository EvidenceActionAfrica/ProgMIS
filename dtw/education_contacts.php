<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
require_once('includes/db_functions.php');
require_once("includes/logTracker.php");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$evidenceaction = new EvidenceAction();

require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");

$image = new image;
$insertFile = new UploadFIle;


if (isset($_POST['uploadCSV'])) {
  $table = "education_contacts";
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


//Privileges settings
$priv_mail = $_SESSION['staff_email'];
$resPriv = mysql_query("select * from staff where staff_email='$priv_mail'");

while ($row = mysql_fetch_array($resPriv)) {
  $priv_moest = $row["priv_moest"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>
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
          $query = "DELETE FROM education_contacts WHERE id='$deleteid'";
          $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());

          //log entry
          $staff_id = $_SESSION['staff_id'];
          $staff_email = $_SESSION['staff_email'];
          $staff_name = $_SESSION['staff_name'];
          $action = "Delete \"Education Contacts\" ";
          $description = "Record ID: " . $deleteid . " deleted";
          $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
          funclogAdminData($arrLogAdminData);
        }

        if (isset($_POST['search_table'])) {
          $county = $_POST['county'];
          $district_name = $_POST['district_name'];
          $deo_name = $_POST['deo_name'];
          $deo_phone = $_POST['deo_phone'];
          $deo_email = $_POST['deo_email'];
          $searchQuery = "SELECT * FROM education_contacts WHERE county LIKE '%$county%'
              AND district LIKE '%$district_name%'
              AND deo_name LIKE '%$deo_name%'
              AND deo_phone LIKE '%$deo_phone%'
              AND deo_email LIKE '%$deo_email%' order by county,district asc ";
          $result_set = mysql_query($searchQuery);
        } else {
          $result_set = mysql_query("SELECT * FROM education_contacts order by county,district  asc");
        }
        ?>

        <form action="#">
          <img src="images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
          <?php if ($priv_moest >= 4) { ?>
            <a class="btn-custom-small" href="#importCSV">Import</a>
          <?php } ?>
          <b style="margin-left:20%;width: 100px; font-size:1.5em;">Education Contacts</b>
          <?php if ($priv_moest >= 1) { ?>
            <a class="btn-custom-small" href="PHPExcel/AdminData/MoEST.php?county=<?php echo $county; ?>&district_name=<?php echo $district_name; ?>&deo_name=<?php echo $deo_name; ?>&deo_phone=<?php echo $deo_phone; ?>&deo_email=<?php echo $deo_email; ?>">Export to Excel</a>
          <?php } if ($priv_moest >= 2) { ?>
            <a class="btn-custom-small" href="#addEducationContact">Add Education Contact</a>
          <?php } ?>
        </form>
        <br/>
        <style>
          table tr td a{

            text-decoration: none;
            color:rgb(0,0,0);
          }
        </style>

        <div >
          <form method="post">
            <table width="100%" border="0" align="center" cellspacing="1" >
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
                  <th align="center" width="20%"><input type="text" style="width: 98%" name="deo_name"  value="<?php echo $deo_name ?>"/></th>
                  <th align="center" width="15%"><input type="text" style="width: 98%" name="deo_phone"  value="<?php echo $deo_phone ?>"/></th>
                  <th align="center" width="30%"><input type="text" style="width: 98%" name="deo_email"  value="<?php echo $deo_email ?>"/></th>
                  <th align="center" width="15%" colspan="3"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                </tr>
              </thead>
            </table>
            <table id="data-table" class="table table-responsive table-hover table-stripped">
              <thead>
                <tr>
                  <th align="Left" width="10%">County</th>
                  <th align="Left" width="15%">Sub-County</th>
                  <th align="Left" width="20%">SCMOE Name</th>
                  <th align="Left" width="15%">SCMOE Phone</th>
                  <th align="Left" width="30%">SCMOE Email</th>

                  <?php if ($priv_moest >= 3) { ?>
     <!--<th align="center" width="4%">Edit</th>-->
                  <?php } ?>
                  <?php if ($priv_moest >= 4) { ?>
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
                  $deo_name = $row['deo_name'];
                  $deo_phone = $row['deo_phone'];
                  $deo_email = $row['deo_email'];
                  if ($priv_moest >= 3) {
                    $link = "education_contacts.php?id=" . $id . "&editDetails=1#editEducation";
                  } else {

                    $link = "#";
                  }
                  ?>
                  <tr>
                    <td> <?php echo "<a href=$link>" . $county . "</a>"; ?>  </td>
                    <td> <?php echo "<a href=$link>" . $district . "</a>"; ?> </td>
                    <td> <?php echo "<a href=$link>" . $deo_name . "</a>"; ?> </td>
                    <td><?php
                echo "<a href=$link>" . substr($deo_phone, 0, 12);
                if (strlen($deo_phone) > 12)
                  echo ".." . "</a>";
                ?>
                    </td>
                    <td><?php
                      echo "<a href=$link>" . substr($deo_email, 0, 30);
                      if (strlen($deo_email) > 30)
                        echo ".." . "</a>";
                      ?>
                    </td>
                      <?php /* if ($priv_moest >= 1) { ?>
                        <!--view button-->
                        <form method="POST" action="#viewMoH">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <td align="center" width="4%"><input type="submit" name="viewDetails" value="" style="background: url(images/icons/view2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                        </form>
                        <?php }

                       */
                      ?>
                    <?php if ($priv_moest >= 3) { ?>
                      <!--edit button-->
                      <form method="POST" action="#editEducation">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <!--<td align="center" width="4%"><input type="submit" name="editDetails" value="" style="background: url(images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>-->
                      </form>
  <?php } ?>
  <?php if ($priv_moest >= 4) { ?>
                      <td align="center" width="4%"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="images/icons/delete.png" height="20px"></a></td>
                      <p>
                        <?php } ?>
                        </tr>
                        
                        <?php } ?>
                            </tbody>
                          </table>
                        </form></p>
                      </div>
  <?php
$sql = "SELECT timestamp from `education_contacts` order by timestamp desc limit 1";
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
<div id="addEducationContact" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
<?php
$formSubmitted = false;
if (isset($_POST['submitAddEducation'])) {

  //Post Values to DB
  $county = $_POST['county'];
  $district = $_POST['district'];
  $title - $_POST['title'];
  $deo_name = $_POST['deo_name'];
  $deo_phone = $_POST['deo_phone'];
  $deo_phone2 = $_POST['deo_phone2'];
  $deo_email = $_POST['deo_email'];
  $deo_email2 = $_POST['deo_email2'];
  $deo_bank_account = $_POST['deo_bank_account'];
  $deo_account_number = $_POST['deo_account_number'];
  $deo_bank_name = $_POST['deo_bank_name'];
  $deo_bank_branch = $_POST['deo_bank_branch'];
  $deo_physical_address = $_POST['deo_physical_address'];
  $diece_officer_name = $_POST['diece_officer_name'];
  $dicece_officer_phone = $_POST['dicece_officer_phone'];
  $own_vehicle = $_POST['own_vehicle'];
  $vehicle_make_type = $_POST['vehicle_make_type'];
  $district_hq = $_POST['district_hq'];
  $distance_to_district_hq = $_POST['distance_to_district_hq'];
  $country_hq = $_POST['country_hq'];
  $distance_to_county_hq = $_POST['distance_to_county_hq'];
  $which_is_closer_g4s_or_post_office = $_POST['which_is_closer_g4s_or_post_office'];

  $county = addslashes(trim($county));
  $district = addslashes(trim($district));
  $deo_name = addslashes(trim($deo_name));
  $title = addslashes(trim($title));
  $deo_phone = addslashes(trim($deo_phone));
  $deo_phone2 = addslashes(trim($deo_phone2));
  $deo_email = addslashes(trim($deo_email));
  $deo_email2 = addslashes(trim($deo_email2));
  $deo_bank_account = addslashes(trim($deo_bank_account));
  $deo_account_number = addslashes(trim($deo_account_number));
  $deo_bank_name = addslashes(trim($deo_bank_name));
  $deo_bank_branch = addslashes(trim($deo_bank_branch));
  $deo_physical_address = addslashes(trim($deo_physical_address));
  $diece_officer_name = addslashes(trim($diece_officer_name));
  $dicece_officer_phone = addslashes(trim($dicece_officer_phone));
  $own_vehicle = addslashes(trim($own_vehicle));
  $vehicle_make_type = addslashes(trim($vehicle_make_type));
  $district_hq = addslashes(trim($district_hq));
  $distance_to_district_hq = addslashes(trim($distance_to_district_hq));
  $country_hq = addslashes(trim($country_hq));
  $distance_to_county_hq = addslashes(trim($distance_to_county_hq));
  $which_is_closer_g4s_or_post_office = addslashes(trim($which_is_closer_g4s_or_post_office));

  $query = ( "INSERT INTO education_contacts (
            county,
            district,
            deo_name,
            deo_phone,
            deo_phone2,
            deo_email,
            deo_email2,
            deo_bank_account,
            deo_account_number,
            deo_bank_name,
            deo_bank_branch )
			
        VALUES (
            '$county',
            '$district',
            '$deo_name',
            '$deo_phone',
            '$deo_phone2',
            '$deo_email',
            '$deo_email2',
            '$deo_bank_account',
            '$deo_account_number',
            '$deo_bank_name',
            '$deo_bank_branch')" );
	 
  mysql_query($query) or die(mysql_error("Could not enter"));
  $messageToUser = "Record Added Successfully!";


  //log entry
  $staff_id = $_SESSION['staff_id'];
  $staff_email = $_SESSION['staff_email'];
  $staff_name = $_SESSION['staff_name'];
  $action = "Added \"Education Contacts\" ";
  $description = "Record ID: " . $deo_name . " Added";
  $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
  funclogAdminData($arrLogAdminData);
}
?>
    <form action="" method="post">
    <?php include("includes/messageBox.php"); ?>
      <h1 class="form-title">Add Education Contact</h1>
      <div style="padding: 5px;">
        <!--left div-->
<div style="float: left; width: 49%;">
          <h3 class="compact">SCMOE Details</h3>
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
                  </select>
                </td>
              </tr>
              <tr>
                <td>Sub-County </td>
                <td>
                  <select  id="district" name="district" class="input_select_p compact" required>
                    <option value="">Choose Sub-County</option>
                  </select>
                </td>
              </tr>              
              <tr>
                <td>SCMOE Name</td>
                <td><input type="text" name="deo_name" class="input_textbox_p compact" value="" required/></td>
              </tr>
                <td>SCMOE Title</td>
                <td><select name="title"  class="input_select_p compact">
                    <option value=''<?php if ($title == '') echo 'selected'; ?> ></option>
                    <?php
                    $sql = "SELECT * FROM dropdown_education_titles ORDER BY title ASC";
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
                <td>SCMOE Phone</td>
                <td><input type="text" name="deo_phone" id="deo_phone" class="input_textbox_p compact" maxlength="12" placeholder="254" onKeyUp="isPhoneNumber(this.id);" required/><span id="deo_phoneSpan"/></span></td>
              </tr>
              <tr>
                <td>SCMOE Phone 2</td>
                <td><input type="text" name="deo_phone2" id="deo_phone2" class="input_textbox_p compact" maxlength="12" onKeyUp="isNumeric(this.id);"/><span id="deo_phone2Span"/></span></td>
              </tr>
              <tr>
                <td>SCMOE Email</td>
                <td><input type="text" name="deo_email" class="input_textbox_p compact" required /></td>
              </tr>
              <tr>
                <td>SCMOE Email 2</td>
                <td><input type="text" name="deo_email2" class="input_textbox_p compact" /></td>
              </tr>
              <tr>
                <td>SCMOE Bank Account</td>
                <td><input type="text" name="deo_bank_account" class="input_textbox_p compact" required/></td>
              </tr>
              <tr>
                <td>SCMOE Account Number</td>
                <td><input type="text" name="deo_account_number" class="input_textbox_p compact" value="" required/></td>
              </tr>
              <tr>
                <td>SCMOE Bank Name</td>
                <td><input type="text" name="deo_bank_name" class="input_textbox_p compact" value="" required/></td>
              </tr>
              <tr>
                <td>SCMOE Bank Branch</td>
                <td><input type="text" name="deo_bank_branch" class="input_textbox_p compact" value="" required/></td>
              </tr>
              <tr>
                <td>Physical Address</td>
                <td><textarea name="deo_physical_address" class="input_textbox_p compact" rows="1"> </textarea></td>
              </tr>
            </thead>
          </table >

          <br/>
          <br/>
          <center>
            <table> <tr>
                <td><input type="submit" class="btn-custom-small" name="submitAddEducation"  value="Add Education Contact"/></td>
               <!--- <td><a href="#close" class="btn-custom-small" >Close</a></td> -->
              </tr> </table>
          </center>

</div>
        <!--Right div-->
        <div style="float: right; width: 49%">
          <h3 class="compact">Other Details</h3>
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <td>Do you own a <br/>Sub-County GoK Vehicle?</td><td><input type="text" name="own_vehicle" class="input_textbox_p compact" /></td>
              </tr>
              <tr>
                <td>Vehicle make/type</td><td><input type="text" name="vehicle_make_type" class="input_textbox_p compact" /></td>
              </tr>
              <tr>
                <td>Sub-County HQ</td><td><input type="text" name="district_hq" class="input_textbox_p compact" /></td>
              </tr>
              <tr height="40px">
                <td>Distance to<br/>Sub-County HQ</td><td><input type="text" name="distance_to_district_hq" class="input_textbox_p compact" value="" /></td>
              </tr>
              <tr>
                <td>County HQ</td><td><input type="text" name="county_hq" class="input_textbox_p compact" /></td>
              </tr>
              <tr height="40px">
                <td>Distance to<br/>County HQ</td><td><input type="text" name="distance_to_county_hq" class="input_textbox_p compact" value="" /></td>
              </tr>
              <tr>
                <td>Which is closer<br/>G4S or Post-Office</td><td><input type="text" name="which_is_closer_g4s_or_post_office" class="input_textbox_p compact" value="" /></td>
              </tr>
            </thead>
          </table >
          <br/>
          <h3 class="compact">Dicece Officer Details</h3>
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <thead>
              <tr>
                <td> Dicece Officer Name </td><td><input type="text" name="diece_officer_name" class="input_textbox_p compact" /></td>
              </tr>
              <tr>
                <td> Dicece Officer Phone </td><td><input type="text" name="diece_officer_phone" id="contact" class="input_textbox_p compact" onKeyUp="isNumeric(this.id);"/><span id="diece_officer_phoneSpan"></td>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <div class="vclear"></div>
    </form>
  </div>
</div>


<!--==== Modal EDIT ======-->
<div id="editEducation" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
<?php
if (isset($_GET['editDetails'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM education_contacts WHERE id='$id'";
  $result_st = mysql_query($sql);
  while ($row = mysql_fetch_array($result_st)) {
    $county = $row['county'];
    $district = $row['district'];
    $deo_name = $row['deo_name'];
	$title = $row['title'];
    $deo_phone = $row['deo_phone'];
    $deo_phone2 = $row['deo_phone2'];
    $deo_email = $row['deo_email'];
    $deo_email2 = $row['deo_email2'];
    $deo_bank_account = $row['deo_bank_account'];
    $deo_account_number = $row['deo_account_number'];
    $deo_bank_name = $row['deo_bank_name'];
    $deo_bank_branch = $row['deo_bank_branch'];
    $deo_physical_address = $row['deo_physical_address'];
    $diece_officer_name = $row['diece_officer_name'];
    $dicece_officer_phone = $row['dicece_officer_phone'];
    $own_vehicle = $row['own_vehicle'];
    $vehicle_make_type = $row['vehicle_make_type'];
    $district_hq = $row['district_hq'];
    $distance_to_district_hq = $row['distance_to_district_hq'];
    $country_hq = $row['country_hq'];
    $distance_to_county_hq = $row['distance_to_county_hq'];
    $which_is_closer_g4s_or_post_office = $row['which_is_closer_g4s_or_post_office'];
  }
}
if (isset($_POST['submitEditMoH'])) {
  $id = $_POST['id'];
  $county = $_POST['county'];
  $district = $_POST['district'];
  $deo_name = $_POST['deo_name'];
  $title = $_POST['title'];
  $deo_phone = $_POST['deo_phone'];
  $deo_phone2 = $_POST['deo_phone2'];
  $deo_email = $_POST['deo_email'];
  $deo_email2 = $_POST['deo_email2'];
  $deo_bank_account = $_POST['deo_bank_account'];
  $deo_account_number = $_POST['deo_account_number'];
  $deo_bank_name = $_POST['deo_bank_name'];
  $deo_bank_branch = $_POST['deo_bank_branch'];
  $deo_physical_address = $_POST['deo_physical_address'];
  $diece_officer_name = $_POST['diece_officer_name'];
  $dicece_officer_phone = $_POST['dicece_officer_phone'];
  $own_vehicle = $_POST['own_vehicle'];
  $vehicle_make_type = $_POST['vehicle_make_type'];
  $district_hq = $_POST['district_hq'];
  $distance_to_district_hq = $_POST['distance_to_district_hq'];
  $country_hq = $_POST['country_hq'];
  $distance_to_county_hq = $_POST['distance_to_county_hq'];
  $which_is_closer_g4s_or_post_office = $_POST['which_is_closer_g4s_or_post_office'];

  $county = addslashes(trim($county));
  $district = addslashes(trim($district));
  $deo_name = addslashes(trim($deo_name));
  $title = addslashes(trim($title));
  $deo_phone = addslashes(trim($deo_phone));
  $deo_phone2 = addslashes(trim($deo_phone2));
  $deo_email = addslashes(trim($deo_email));
  $deo_email2 = addslashes(trim($deo_email2));
  $deo_bank_account = addslashes(trim($deo_bank_account));
  $deo_account_number = addslashes(trim($deo_account_number));
  $deo_bank_name = addslashes(trim($deo_bank_name));
  $deo_bank_branch = addslashes(trim($deo_bank_branch));
  $deo_physical_address = addslashes(trim($deo_physical_address));
  $diece_officer_name = addslashes(trim($diece_officer_name));
  $dicece_officer_phone = addslashes(trim($dicece_officer_phone));
  $own_vehicle = addslashes(trim($own_vehicle));
  $vehicle_make_type = addslashes(trim($vehicle_make_type));
  $district_hq = addslashes(trim($district_hq));
  $distance_to_district_hq = addslashes(trim($distance_to_district_hq));
  $country_hq = addslashes(trim($country_hq));
  $distance_to_county_hq = addslashes(trim($distance_to_county_hq));
  $which_is_closer_g4s_or_post_office = addslashes(trim($which_is_closer_g4s_or_post_office));

  $query = ( "UPDATE education_contacts SET
          county = '$county',
          district = '$district',
          deo_name = '$deo_name',
          deo_phone = '$deo_phone',
          deo_phone2 = '$deo_phone2',
          deo_email = '$deo_email',
          deo_email2 = '$deo_email2',
          deo_bank_account = '$deo_bank_account',
          deo_account_number = '$deo_account_number',
          deo_bank_name = '$deo_bank_name',
          deo_bank_branch = '$deo_bank_branch',
		  timestamp = CURRENT_TIMESTAMP  WHERE id='$id' " );
	  
  mysql_query($query) or die(mysql_error());
  $messageToUser = "Record Edited Successfully!";


  //log entry
  $staff_id = $_SESSION['staff_id'];
  $staff_email = $_SESSION['staff_email'];
  $staff_name = $_SESSION['staff_name'];
  $action = "Edited \"Education Contacts\" ";
  $description = "Record ID: " . $deo_name . " edited";
  $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
  funclogAdminData($arrLogAdminData);
}
?>
    <form action="" method="post">
    <?php include("includes/messageBox.php"); ?>
      <h1 class="form-title">Edit Education Contact</h1>
      <div style="padding: 5px;">
        <!--left div-->
        <div style="float: left; width: 49%;">
          <h3 class="compact">DEO Details</h3>
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
                  </select>
                </td>
              </tr>
              <tr>
                <td>Subcounty </td>
                <td>
                  <select  id="district2" name="district" class="input_select_p compact" required>
                    <option value='<?php echo $district; ?>' ><?php echo $district; ?></option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>SCMOE Name</td><td><input type="text" name="deo_name" class="input_textbox_p compact"value="<?php echo $deo_name; ?>" required/></td>
              </tr>
                <td>SCMOE title</td>
                <td><select name="title"  class="input_select_p compact" >
                    <option value=''<?php if ($title == '') echo 'selected'; ?> ></option>
                    <?php
                    $sql = "SELECT * FROM dropdown_education_titles ORDER BY title ASC";
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
                <td>SCMOE Phone</td><td><input type="text" name="deo_phone" id="deo_phone" class="input_textbox_p compact" maxlength="12" value="<?php echo $deo_phone; ?>" onKeyUp="isPhoneNumber(this.id);" required/><span id="deo_phoneSpan"/></span></td>
              </tr>
              <tr>
                <td>SCMOE Phone 2</td><td><input type="text" name="deo_phone2" id="deo_phone2" class="input_textbox_p compact" maxlength="12" value="<?php echo $deo_phone2; ?>" onKeyUp="isNumeric(this.id);"/><span id="deo_phone2Span"/></span></td>
              </tr>
              <tr>
                <td>SCMOE Email</td><td><input type="text" name="deo_email" class="input_textbox_p compact" value="<?php echo $deo_email; ?>"/></td>
              </tr>
              <tr>
                <td>SCMOE Email 2</td><td><input type="text" name="deo_email2" class="input_textbox_p compact" value="<?php echo $deo_email2; ?>"/></td>
              </tr>
              <tr>
                <td>SCMOE Bank Account</td><td><input type="text" name="deo_bank_account" class="input_textbox_p compact" value="<?php echo $deo_bank_account; ?>"/></td>
              </tr>
              <tr>
                <td>SCMOE Account Number</td><td><input type="text" name="deo_account_number" class="input_textbox_p compact" value="<?php echo $deo_account_number; ?>"/></td>
              </tr>
              <tr>
                <td>SCMOE Bank Name</td><td><input type="text" name="deo_bank_name" class="input_textbox_p compact" value="<?php echo $deo_bank_name; ?>"/></td>
              </tr>
              <tr>
                <td>SCMOE Bank Branch</td><td><input type="text" name="deo_bank_branch" class="input_textbox_p compact" value="<?php echo $deo_bank_branch; ?>"/></td>
              </tr> 
              <tr>
                <td>Physical Address</td>
                <td><textarea name="deo_physical_address" class="input_textbox_p compact" rows="1"><?php echo $deo_physical_address; ?></textarea></td>
              </tr>
            </thead>
          </table >

          <br/>
          <br/>
          <center>
            <div>
              <input type="submit" class="btn-custom" name="submitEditMoH"  value="Edit Education Details"/>
            </div>
          </center>
        </div>
        <!--Right div-->
        <div style="float: right; width: 49%">
          <h3 class="compact">Other Details</h3>
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <td>Do you own a <br/>Sub-County GoK Vehicle?</td><td><input type="text" name="own_vehicle" class="input_textbox_p compact" value="<?php echo $own_vehicle; ?>"/></td>
              </tr>
              <tr>
                <td>Vehicle make/type</td><td><input type="text" name="vehicle_make_type" class="input_textbox_p compact" value="<?php echo $vehicle_make_type; ?>"/></td>
              </tr>
              <tr>
                <td>Sub-County HQ</td><td><input type="text" name="district_hq" class="input_textbox_p compact" value="<?php echo $district_hq; ?>"/></td>
              </tr>
              <tr height="40px">
                <td>Distance to<br/>Sub-County HQ</td><td><input type="text" name="distance_to_district_hq" class="input_textbox_p compact" value="<?php echo $distance_to_district_hq; ?>"/></td>
              </tr>
              <tr>
                <td>County HQ</td><td><input type="text" name="county_hq" class="input_textbox_p compact" value="<?php echo $country_hq; ?>" /></td>
              </tr>
              <tr height="40px">
                <td>Distance to<br/>County HQ</td><td><input type="text" name="distance_to_county_hq" class="input_textbox_p compact" value="<?php echo $distance_to_county_hq; ?>"/></td>
              </tr>
              <tr>
                <td>Which is closer<br/>G4S or Post-Office</td><td><input type="text" name="which_is_closer_g4s_or_post_office" class="input_textbox_p compact" value="<?php echo $which_is_closer_g4s_or_post_office; ?>"/></td>
              </tr>
            </thead>
          </table >
          <br/>
          <h3 class="compact">Dicece Officer Details</h3>
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <thead>
              <tr>
                <td> Dicece Officer Name </td><td><input type="text" name="diece_officer_name" class="input_textbox_p compact" value="<?php echo $diece_officer_name; ?>"/></td>
              </tr>
              <tr>
                <td> Dicece Officer Phone </td><td><input type="text" name="diece_officer_phone" id="diece_officer_phone0" class="input_textbox_p compact" value="<?php echo $dicece_officer_phone; ?>" onKeyUp="isNumeric(this.id);"/><span id="diece_officer_phone0Span"/></td>
              </tr>
            </thead>
          </table>
          <br/>
        </div>
      </div>
      <div class="vclear"></div> 
    </form>
  </div>
</div>


<!--===== Modal Import ===========================-->
<div id="importCSV" class="modalDialog">
  <div style="width:380px">
    <a href="#close" title="Close" class="close">X</a>
    <div >
      <h1 class="form-title">Upload MOE</h1><br/>
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
<?php if ($priv_moest >= 4) { ?>
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
    <h1 class="form-title">View Education Contact Details</h1>
<?php
if (isset($_GET['viewDetails'])) {
  $id = $_GET['id'];

  $result_st = mysql_query("SELECT * FROM education_contacts WHERE id='$id'");
  while ($row = mysql_fetch_array($result_st)) {
    $county = $row['county'];
    $district = $row['district'];
    $deo_name = $row['deo_name'];
    $deo_phone = $row['deo_phone'];
    $deo_phone2 = $row['deo_phone2'];
    $deo_email = $row['deo_email'];
    $deo_email2 = $row['deo_email2'];
    $deo_bank_account = $row['deo_bank_account'];
    $deo_account_number = $row['deo_account_number'];
    $deo_bank_name = $row['deo_bank_name'];
    $deo_bank_branch = $row['deo_bank_branch'];
    $deo_physical_address = $row['deo_physical_address'];
    $diece_officer_name = $row['diece_officer_name'];
    $dicece_officer_phone = $row['dicece_officer_phone'];
    $own_vehicle = $row['own_vehicle'];
    $vehicle_make_type = $row['vehicle_make_type'];
    $district_hq = $row['district_hq'];
    $distance_to_district_hq = $row['distance_to_district_hq'];
    $country_hq = $row['country_hq'];
    $distance_to_county_hq = $row['distance_to_county_hq'];
    $which_is_closer_g4s_or_post_office = $row['which_is_closer_g4s_or_post_office'];
  }
}
?>
    <div style="padding: 5px;">
      <!--left div-->
      <div style="float: left; width: 49%;">
        <h3 class="compact">DEO Details</h3>
        <table border="0"  cellpadding="0" cellspacing="0" width="100%">
          <thead> 
            <tr>
              <td>County</td><td><input type="text" name="county" class="input_textbox_p compact"value="<?php echo $county; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Sub-County</td><td><input type="text" name="district" class="input_textbox_p compact"value="<?php echo $district; ?>"  readonly/></td>
            </tr>
            <tr>
              <td>SCMoE Name</td><td><input type="text" name="deo_name" class="input_textbox_p compact"value="<?php echo $deo_name; ?>"  readonly/></td>
            </tr>
            <tr>
              <td>SCMoE Phone</td><td><input type="text" name="deo_phone" id="deo_phone" class="input_textbox_p compact"  value="<?php echo $deo_phone; ?>"  readonly/></td>
            </tr>
            <tr>
              <td>SCMoE Phone 2</td><td><input type="text" name="deo_phone2" id="deo_phone2" class="input_textbox_p compact"   value="<?php echo $deo_phone2; ?>"  readonly/></td>
            </tr>
            <tr>
              <td>SCMoE Email</td><td><input type="text" name="deo_email" class="input_textbox_p compact" value="<?php echo $deo_email; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMoE Email 2</td><td><input type="text" name="deo_email2" class="input_textbox_p compact" value="<?php echo $deo_email2; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMoE Email 3</td><td><input type="text" name="deo_email3" class="input_textbox_p compact" value="<?php echo $deo_email3; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMoE Bank Account</td><td><input type="text" name="deo_bank_account" class="input_textbox_p compact" value="<?php echo $deo_bank_account; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMoE Account Number</td><td><input type="text" name="deo_account_number" class="input_textbox_p compact" value="<?php echo $deo_account_number; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMoE Bank Name</td><td><input type="text" name="deo_bank_name" class="input_textbox_p compact" value="<?php echo $deo_bank_name; ?>" readonly/></td>
            </tr>
            <tr>
              <td>SCMoE Bank Branch</td><td><input type="text" name="deo_bank_branch" class="input_textbox_p compact" value="<?php echo $deo_bank_branch; ?>" readonly/></td>
            </tr> 
            <tr>
              <td>Physical Address</td>
              <td><textarea name="deo_physical_address" class="input_textbox_p compact" rows="1" readonly><?php echo $deo_physical_address; ?></textarea></td>
            </tr>
          </thead>
        </table >

        <br/>
        <br/>
        <center>
          <div>
            <a href="#close" class="btn-custom" >Close</a>
          </div>
        </center>
      </div>
      <!--Right div-->
      <div style="float: right; width: 49%">
        <h3 class="compact">DQASO Details</h3>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <thead>
              <td>Do you own a <br/>Sub-County GoK Vehicle?</td><td><input type="text" name="own_vehicle" class="input_textbox_p compact" value="<?php echo $own_vehicle; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Vehicle make/type</td><td><input type="text" name="vehicle_make_type" class="input_textbox_p compact" value="<?php echo $vehicle_make_type; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Sub-County HQ</td><td><input type="text" name="district_hq" class="input_textbox_p compact" value="<?php echo $district_hq; ?>" readonly/></td>
            </tr>
            <tr height="40px">
              <td>Distance to<br/>Sub-County HQ</td><td><input type="text" name="distance_to_district_hq" class="input_textbox_p compact" value="<?php echo $distance_to_district_hq; ?>" readonly/></td>
            </tr>
            <tr>
              <td>County HQ</td><td><input type="text" name="county_hq" class="input_textbox_p compact" value="<?php echo $country_hq; ?>"  readonly/></td>
            </tr>
            <tr height="40px">
              <td>Distance to<br/>County HQ</td><td><input type="text" name="distance_to_county_hq" class="input_textbox_p compact" value="<?php echo $distance_to_county_hq; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Which is closer<br/>G4S or Post-Office</td><td><input type="text" name="which_is_closer_g4s_or_post_office" class="input_textbox_p compact" value="<?php echo $which_is_closer_g4s_or_post_office; ?>" readonly/></td>
            </tr>
          </thead>
        </table >
        <br/>
        <h3 class="compact">Dicece Officer Details</h3>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <thead>
            <tr>
              <td> Dicece Officer Name </td><td><input type="text" name="diece_officer_name" class="input_textbox_p compact" value="<?php echo $diece_officer_name; ?>" readonly/></td>
            </tr>
            <tr>
              <td> Dicece Officer Phone </td><td><input type="text" name="diece_officer_phone" id="diece_officer_phone0" class="input_textbox_p compact" value="<?php echo $dicece_officer_phone; ?>" readonly /> </td>
            </tr>
          </thead>
        </table>
        <br/>
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

