<?php
ob_start();
require_once('includes/auth.php');
require_once('includes/config.php');
require_once("includes/functions.php");
require_once("includes/form_functions.php");
$tabActive = 'tab1';
$formsubmited == false;

$staff_id = $_GET['staff_id'];
$result_set = mysql_query("SELECT * FROM staff WHERE staff_id='$staff_id' LIMIT 1");
while ($row = mysql_fetch_array($result_set)) {
  $staff_id = $row['staff_id'];
  $image = $row['image'];
  $staff_name = $row['staff_name'];
  $staff_role = $row["staff_role"];
  $staff_gender = $row["staff_gender"];
  $staff_mobile = $row["staff_mobile"];
  $staff_email = $row["staff_email"];
  $staff_password = $row["staff_password"];

  $priv_counties = $row["priv_counties"];
  $priv_districts = $row["priv_districts"];
  $priv_divisions = $row["priv_divisions"];
  $priv_schools = $row["priv_schools"];
  $priv_moh = $row["priv_moh"];
  $priv_moest = $row["priv_moest"];
  $priv_master_trainers = $row["priv_master_trainers"];
  $priv_county_contacts = $row["priv_county_contacts"];
  $priv_steering=$row["priv_steering"];
  $priv_headteachers=$row["priv_headteachers"];
  
  $priv_dropdowns = $row["priv_dropdowns"];
    $priv_mgmt_team=$row["priv_mgmt_team"];
    $priv_dispatch = $row["priv_dispatch"];
  $priv_requisition = $row["priv_requisition"];
  $priv_dnote = $row["priv_dnote"];
  $priv_tab_pickup = $row["priv_tab_pickup"];
  $priv_shortfall = $row["priv_shortfall"];
  $priv_tab_return = $row["priv_tab_return"];
  $priv_forms_attnt_s = $row["priv_forms_attnt_s"];
  $priv_rap = $row["priv_rap"];
  $priv_mt = $row["priv_mt"];
  $priv_materials_edit = $row["priv_materials_edit"];
  $priv_materials_assumptions = $row["priv_materials_assumptions"];
  $priv_district_budget = $row["priv_district_budget"];
  $priv_imp_requests = $row["priv_imp_requests"];
  $priv_cheque_requests = $row["priv_cheque_requests"];
  $priv_reconciliation_return = $row["priv_reconciliation_return"];
  $priv_login_forms_reverse = $row["priv_login_forms_reverse"];
  $priv_log_forms = $row["priv_log_forms"];
  $priv_log_forms_analysed = $row["priv_log_forms_analysed"];
  $priv_login_forms_reverse = $row["priv_login_forms_reverse"];
  $priv_log_forms = $row["priv_log_forms"];
  $priv_log_forms_analysed = $row["priv_log_forms_analysed"];
  $priv_standard_reports = $row["priv_standard_reports"];
  $priv_ciff_kpi = $row["priv_ciff_kpi"];
  $priv_ciff_report = $row["priv_ciff_report"];
  $priv_end_fund = $row["priv_end_fund"];
  $priv_ntd = $row["priv_ntd"];
  $priv_usaid = $row["priv_usaid"];
  $priv_who = $row["priv_who"];
  $priv_demand = $row["priv_demand"];
  $priv_diagnostics = $row["priv_diagnostics"];
}

//Define the maximum size of the uploaded photo
define("MAX_SIZE", "1000");

//function reads the extension of the file to determine if this is an image
function getExtension($str) {
  $i = strrpos($str, ".");
  if (!$i) {
    return "";
  }
  $l = strlen($str) - $i;
  $ext = substr($str, $i + 1, $l);
  return $ext;
}
// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_level= $row['staff_role'];
}
if($priv_level=="Administrator" || $priv_level=="administrator" || $priv_level=="Admin"){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once("includes/meta-link-script.php"); ?>
    <script src="../js/tabs.js"></script>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once("includes/menuNav.php"); ?>
        <?php require_once("includes/loginInfo.php"); ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once("includes/menuLeftBar-Settings.php"); ?>
      </div>
      <div class="contentBody">

        <div id="middle_section">
          <center>
            <!--<h1 class="form-title">Add District</h1><br/>-->
            <b style="text-align: center; font-size: 22px"> Staff Edit</b><br/><br/>
            <?php
            if (isset($_POST['Submit'])) {
              $staff_id = mysql_prep($_POST['staff_id']);
              $staff_name = mysql_prep($_POST['staff_name']);
              $staff_role = mysql_prep($_POST['staff_role']);
              $staff_gender = mysql_prep($_POST['staff_gender']);
              $staff_mobile = mysql_prep($_POST['staff_mobile']);
              $staff_email = mysql_prep($_POST['staff_email']);
              $staff_password = mysql_prep($_POST['staff_password']);

              $priv_counties = mysql_prep($_POST['priv_counties']);
              $priv_districts = mysql_prep($_POST['priv_districts']);
              $priv_divisions = mysql_prep($_POST['priv_divisions']);
              $priv_schools = mysql_prep($_POST['priv_schools']);
              $priv_moh = mysql_prep($_POST['priv_moh']);
              $priv_moest = mysql_prep($_POST['priv_moest']);
              $priv_master_trainers = mysql_prep($_POST['priv_master_trainers']);
              $priv_county_contacts = mysql_prep($_POST['priv_county_contacts']);
              $priv_steering= mysql_prep($_POST['priv_steering']);
              $priv_mgmt_team= mysql_prep($_POST['priv_mgmt_team']);
             $priv_headteachers=mysql_prep($_POST['priv_headteachers']);
              $priv_dropdowns = mysql_prep($_POST['priv_dropdowns']);

              $priv_requisition = mysql_prep($_POST['priv_requisition']);
              $priv_dispatch = mysql_prep($_POST['priv_dispatch']);
               $priv_dnote = mysql_prep($_POST['priv_dnote']);
              $priv_tab_pickup = mysql_prep($_POST['priv_tab_pickup']);
              $priv_shortfall = mysql_prep($_POST['priv_shortfall']);
              $priv_tab_return = mysql_prep($_POST['priv_tab_return']);
              $priv_forms_attnt_s = mysql_prep($_POST['priv_forms_attnt_s']);
              $priv_rap = mysql_prep($_POST['priv_rap']);
              $priv_mt = mysql_prep($_POST['priv_mt']);
              $priv_materials_edit = mysql_prep($_POST['priv_materials_edit']);
              $priv_materials_assumptions = mysql_prep($_POST['priv_materials_assumptions']);
              $priv_district_budget = mysql_prep($_POST['priv_district_budget']);
              $priv_imp_requests = mysql_prep($_POST['priv_imp_requests']);
              $priv_cheque_requests = mysql_prep($_POST['priv_cheque_requests']);
              $priv_reconciliation_return = mysql_prep($_POST['priv_reconciliation_return']);
              $priv_login_forms_reverse = mysql_prep($_POST['priv_login_forms_reverse']);
              $priv_log_forms = mysql_prep($_POST['priv_log_forms']);
              $priv_logforms_analysed = mysql_prep($_POST['priv_logforms_analysed']);
              $priv_login_forms_reverse = mysql_prep($_POST['priv_login_forms_reverse']);
              $priv_log_forms = mysql_prep($_POST['priv_log_forms']);
              $priv_log_forms_analysed = mysql_prep($_POST['priv_log_forms_analysed']);
              $priv_standard_reports = mysql_prep($_POST['priv_standard_reports']);
              $priv_ciff_kpi = mysql_prep($_POST['priv_ciff_kpi']);
              $priv_ciff_report = mysql_prep($_POST['priv_ciff_report']);
              $priv_end_fund = mysql_prep($_POST['priv_end_fund']);
              $priv_ntd = mysql_prep($_POST['priv_ntd']);
              $priv_usaid = mysql_prep($_POST['priv_usaid']);
              $priv_who = mysql_prep($_POST['priv_who']);
              $priv_demand = mysql_prep($_POST['priv_demand']);
              $priv_diagnostics = mysql_prep($_POST['priv_diagnostics']);




              //reads the image uploaded by the client computer
              $image = $_FILES['image']['name'];
              if ($image) {
                //get the original name of the file from the client machine
                $filename = stripslashes($_FILES['image']['name']);
                //get the extension of the image in lower case
                $extension = getExtension($filename);
                $extension = strtolower($extension);
                //if the extension is not known an error will occur and it will not be uploaded
                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
                  echo "unknown image extension";
                  $error = 1;
                } else {
                  //get the size of the image in bytes
                  //$_FILES['image']['tmp_name'] is a temporaly filename if the file
                  //in which the uploaded file is stored on the server
                  $size = filesize($_FILES['image']['tmp_name']);
                  //compare the size of the uploaded with the our defined size
                  if ($size > MAX_SIZE * 1024) {
                    echo "you have exceeded the maximum image size";
                    $error = 1;
                  }
                  //we give a unique name to the image
                  $image_name = time() . '.' . $extension;
                }
                //the new name will be containing the path if the image
                $newname = "images/staff/" . $image_name;
                $copy = move_uploaded_file($_FILES['image']['tmp_name'], $newname);

                $image = $image_name;
                $query = "UPDATE staff SET image='$image',staff_name='$staff_name',staff_role='$staff_role',staff_gender='$staff_gender',
                    staff_mobile='$staff_mobile',email='$email',staff_password='$staff_password',staff_password='$staff_password' WHERE staff_id='$staff_id' ";
                $result = mysql_query($query);
                if (!$result) {
                  die(mysql_error());
                }
              } else {
                $query = "UPDATE staff SET staff_name='$staff_name',staff_role='$staff_role',staff_gender='$staff_gender',
                   staff_mobile='$staff_mobile',staff_email='$staff_email',staff_password='$staff_password',staff_password='$staff_password',
                    priv_counties='$priv_counties',
                    priv_districts='$priv_districts',
                    priv_divisions='$priv_divisions',
                    priv_schools='$priv_schools',
                    priv_moh='$priv_moh',
                    priv_moest='$priv_moest',
                    priv_master_trainers='$priv_master_trainers',
                    priv_county_contacts='$priv_county_contacts',
                    priv_headteachers='$priv_headteachers',
                    priv_steering='$priv_steering',
                    priv_mgmt_team='$priv_mgmt_team',
                    priv_dropdowns='$priv_dropdowns',
                    staff_mobile='$staff_mobile',
                    priv_requisition='$priv_requisition',
                    priv_dispatch='$priv_dispatch',
                    priv_dnote='$priv_dnote',
                    priv_tab_pickup='$priv_tab_pickup',
                    priv_shortfall='$priv_shortfall',
                    priv_tab_return='$priv_tab_return',
                    priv_forms_attnt_s='$priv_forms_attnt_s',
                    priv_rap='$priv_rap',
                    priv_mt='$priv_mt',
                    priv_materials_edit='$priv_materials_edit',
                    priv_materials_assumptions='$priv_materials_assumptions',
                    priv_district_budget='$priv_district_budget',
                    priv_imp_requests='$priv_imp_requests',
                    priv_cheque_requests='$priv_cheque_requests',
                    priv_reconciliation_return = '$priv_reconciliation_return',
                    priv_login_forms_reverse = '$priv_login_forms_reverse',
                    priv_log_forms = '$priv_log_forms',
                    priv_log_forms_analysed = '$priv_logforms_analysed',
                    priv_login_forms_reverse = '$priv_login_forms_reverse',
                    priv_log_forms = '$priv_log_forms',
                    priv_log_forms_analysed= '$priv_log_forms_analysed',
                    priv_standard_reports = '$priv_standard_reports',
                    priv_ciff_kpi= '$priv_ciff_kpi',
                    priv_ciff_report= '$priv_ciff_report',
                    priv_end_fund='$priv_end_fund',
                    priv_ntd= '$priv_ntd',
                    priv_usaid= '$priv_usaid',
                    priv_who= '$priv_who',
                    priv_demand ='$priv_demand',
                    priv_diagnostics = '$priv_diagnostics'
                 WHERE staff_id='$staff_id' ";

                $result = mysql_query($query) or die(mysql_error() . "</h1>");
              }
              /*     echo "<div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;border-radius:10px; margin:5px;background-color:#a2ff7e;'>
                <font align='justify' size='3px'><br/> Staff record updated successfully </font>
                <br/><br/>
                </div><br/>
                <center><a href='staff.php' class='btn-custom'> Return to staff list</a></center>
                <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                ";
                $formsubmited = true; */
            }
            if ($formsubmited == false) {
              ?>

              <div >
                <div class="tabbable" >
                  <ul class="nav nav-tabs">
                    <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Staff Details</a></li>
                    <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Admin Module Privileges</a></li>
                    <li <?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">Process Module Privileges</a></li>
                    <li <?php if ($tabActive == 'tab4') echo "class='active'" ?>><a href="#tab4" data-toggle="tab">Performance Module Privileges</a></li>
                  </ul>
                  <div class="tab-content" style="min-height: 350px ">
                    <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                      <br/><b style="font-size: 18px;">Staff Details Edit</b><br/><br/>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="uploadImage" id="uploadImage">
                        <div style="float:right; width: 30%; margin-right:40px; margin-top: 0px">
                          <p style="font-size:20px;line-height: 5px;">Contact image</p>
                          <img style="border: black solid 2px;border-radius:10px;"height="200px" src="images/staff/<?php echo$image ?>"/>
                        </div>
                        <table cellspacing="5px" align="center">
                          <tr><td>Staff ID:</td><td><input name="staff_id" value="<?php echo $staff_id ?>" size="5" readonly  /> </td></tr>
                          <tr><td>Upload Image:</td><td><input type="file" name="image" id="image" size="27" /> </td></tr>
                          <tr>
                            <td align="left">Gender</td>
                            <td align="left">
                              <select class="input_select_p compact"  name="staff_gender" id="staff_gender" onChange="hideSaveButton();" style="width: 100px">
                                <option value='Male'<?php if ($staff_gender == 'Male') echo 'selected'; ?> >Male</option>
                                <option value='Female'<?php if ($staff_gender == 'Female') echo 'selected'; ?>>Female</option>
                              </select>
                            </td>
                          </tr>
                          <tr><td>Name:</td><td><input class="input_textbox_p compact" type="text" name="staff_name" size="27" value="<?php echo $staff_name; ?>"/> </td></tr>
                          <tr><td>Email:</td><td><input class="input_textbox_p compact" type="text" name="staff_email" value="<?php echo $staff_email; ?>" size="30"/> </td></tr>
                          <tr><td align="left">Role </td>
                            <td align="left">
                              <select class="input_select_p compact" name="staff_role" id="staff_role">
                                <?php
                                $sql = "SELECT * FROM role ORDER BY role ASC";
                                $result = mysql_query($sql);
                                while ($rows = mysql_fetch_array($result)) { //loop table rows
                                  ?>
                                  <option value="<?php echo $rows['role']; ?>"<?php
                                  if ($staff_role == $rows['role']) {
                                    echo 'selected';
                                  }
                                  ?>><?php echo $rows['role']; ?></option>
                                        <?php } ?>
                              </select> </td>
                          </tr>
                          <tr><td>staff_password :</td><td><input class="input_textbox_p compact" type="password" name="staff_password"  id="staff_password"  value="<?php echo $staff_password; ?>"size="27"  /></td></tr>
                          <tr><td>Confirm staff_password :</td><td><input class="input_textbox_p compact" type="password" name="staff_password2"  id="staff_password2"  value="<?php echo $staff_password; ?>"size="27"  /><span id='passSpan'></span></td></tr>
                        </table>
                        <br/>
                        <br/>
                    </div>
                    <!--tab 2 ==============================================================================================-->
                    <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
                      <br/><b style="font-size: 18px;">Admin Data Privileges</b><br/><br/>
                      <table>
                        <tr>
                          <td align="left">County List</td>
                          <td align="left">
                            <select name="priv_counties" class="input_select_priv">
                              <option value='0'<?php if ($priv_counties == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_counties == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_counties == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_counties == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_counties == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="left">District List</td>
                          <td align="left">
                            <select  name="priv_districts" class="input_select_priv">
                              <option value='0'<?php if ($priv_districts == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_districts == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_districts == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_districts == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_districts == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="left">Division List</td>
                          <td align="left">
                            <select  name="priv_divisions" class="input_select_priv">
                              <option value='0'<?php if ($priv_divisions == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_divisions == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_divisions == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_divisions == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_divisions == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="left">School List</td>
                          <td align="left">
                            <select  name="priv_schools" class="input_select_priv">
                              <option value='0'<?php if ($priv_schools == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_schools == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_schools == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_schools == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_schools == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="left">MOH List</td>
                          <td align="left">
                            <select  name="priv_moh" class="input_select_priv">
                              <option value='0'<?php if ($priv_moh == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_moh == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_moh == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_moh == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_moh == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="left">MOEST List</td>
                          <td align="left">
                            <select  name="priv_moest" class="input_select_priv">
                              <option value='0'<?php if ($priv_moest == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_moest == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_moest == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_moest == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_moest == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="left">Master Trainer List</td>
                          <td align="left">
                            <select  name="priv_master_trainers" class="input_select_priv">
                              <option value='0'<?php if ($priv_master_trainers == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_master_trainers == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_master_trainers == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_master_trainers == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_master_trainers == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="left">Contacts List</td>
                          <td align="left">
                            <select  name="priv_county_contacts" class="input_select_priv">
                              <option value='0'<?php if ($priv_county_contacts == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_county_contacts == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_county_contacts == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_county_contacts == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_county_contacts == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="left">Dropdowns List</td>
                          <td align="left">
                            <select  name="priv_dropdowns" class="input_select_priv">
                              <option value='0'<?php if ($priv_dropdowns == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_dropdowns == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_dropdowns == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_dropdowns == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_dropdowns == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                        </tr>
                       <tr>
                          <td align="left">Head Teacher</td>
                          <td align="left">
                            <select  name="priv_headteachers" class="input_select_priv">
                              <option value='0'<?php if ($priv_headteachers == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_headteachers == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_headteachers == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_headteachers == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_headteachers == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                        </tr>
                     <tr>
                          <td align="left">Steering Committee</td>
                          <td align="left">
                            <select  name="priv_steering" class="input_select_priv">
                              <option value='0'<?php if ($priv_steering == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_steering == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_steering == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_steering == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_steering == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                        </tr>
                           <tr>
                          <td align="left">Management Team</td>
                          <td align="left">
                            <select  name="priv_mgmt_team" class="input_select_priv">
                              <option value='0'<?php if ($priv_mgmt_team == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_mgmt_team == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_mgmt_team == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_mgmt_team == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_mgmt_team == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                        </tr>
                      </table>
                    </div>

                    <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
                      <br/><b style="font-size: 18px;">Process Module Privileges</b><br/><br/>
                      <!--left div-->
                      <div style="float: left; width: 48%">
                        <table>
                                 <tr><td colspan="2"><b style="font-size: 17px">Drugs(Requisition)</b></td></tr>
                     <tr>
                            <td align="left">Requisition</td>
                            <td align="left">
                              <select  name="priv_requisition" class="input_select_priv">
                                <option value='0'<?php if ($priv_requisition == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_requisition == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_requisition == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_requisition == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_requisition == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr><td colspan="2"><b style="font-size: 17px">Drugs(Tracking)</b></td></tr>
                          <tr>
                            <td align="left">Delivery Note</td>
                            <td align="left">
                              <select  name="priv_dnote" class="input_select_priv">
                                <option value='0'<?php if ($priv_dnote == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_dnote == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_dnote == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_dnote == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_dnote == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                               <tr>
                            <td align="left">Dispatch</td>
                            <td align="left">
                              <select  name="priv_dispatch" class="input_select_priv">
                                <option value='0'<?php if ($priv_dispatch == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_dispatch == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_dispatch == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_dispatch == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_dispatch == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Tab Pickup</td>
                            <td align="left">
                              <select  name="priv_tab_pickup" class="input_select_priv">
                                <option value='0'<?php if ($priv_tab_pickup == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_tab_pickup == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_tab_pickup == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_tab_pickup == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_tab_pickup == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Shortfall</td>
                            <td align="left">
                              <select  name="priv_shortfall" class="input_select_priv">
                                <option value='0'<?php if ($priv_shortfall == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_shortfall == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_shortfall == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_shortfall == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_shortfall == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Tab Return</td>
                            <td align="left">
                              <select  name="priv_tab_return" class="input_select_priv">
                                <option value='0'<?php if ($priv_tab_return == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_tab_return == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_tab_return == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_tab_return == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_tab_return == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Forms ATTNT & S</td>
                            <td align="left">
                              <select  name="priv_forms_attnt_s" class="input_select_priv">
                                <option value='0'<?php if ($priv_forms_attnt_s == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_forms_attnt_s == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_forms_attnt_s == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_forms_attnt_s == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_forms_attnt_s == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                         
                          <tr height="30px"><td colspan="2"><b style="font-size: 17px">Roll out Module</b></td></tr>
                          <tr>
                           <td align="left">Rollout Activities Planning</td>
                            <td align="left">
                              <select  name="priv_rap" class="input_select_priv">
                                <option value='0'<?php if ($priv_rap == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_rap == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_rap == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_rap == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_rap == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Master Trainers</td>
                            <td align="left">
                              <select  name="priv_mt" class="input_select_priv">
                                <option value='0'<?php if ($priv_mt == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_mt == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_mt == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_mt == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_mt == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr height="30px"><td colspan="2"><b style="font-size: 17px">Materials</b></td></tr>
                          <tr>
                            <td align="left">All Materials Module Access</td>
                            <td align="left">
                              <select  name="priv_materials_edit" class="input_select_priv">
                                <option value='0'<?php if ($priv_materials_edit == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_materials_edit == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_materials_edit == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_materials_edit == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_materials_edit == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Constant Assumptions Edit</td>
                            <td align="left">
                              <select  name="priv_materials_assumptions" class="input_select_priv">
                                <option value='0'<?php if ($priv_materials_assumptions == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_materials_assumptions == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_materials_assumptions == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_materials_assumptions == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_materials_assumptions == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <!--right div-->
                      <div style="float: right; width: 48%">
                        <table>
                          <tr height="30px"><td colspan="2"><b style="font-size: 17px">Finance</b></td></tr>
                          <tr>
                            <td align="left">District Budgets</td>
                            <td align="left">
                              <select  name="priv_district_budget" class="input_select_priv">
                                <option value='0'<?php if ($priv_district_budget == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_district_budget == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_district_budget == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_district_budget == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_district_budget == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Imprest Requests</td>
                            <td align="left">
                              <select  name="priv_imp_requests" class="input_select_priv">
                                <option value='0'<?php if ($priv_imp_requests == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_imp_requests == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_imp_requests == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_imp_requests == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_imp_requests == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Cheque Requests</td>
                            <td align="left">
                              <select  name="priv_cheque_requests" class="input_select_priv">
                                <option value='0'<?php if ($priv_cheque_requests == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_cheque_requests == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_cheque_requests == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_cheque_requests == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_cheque_requests == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Reconciliation Returns</td>
                            <td align="left">
                              <select  name="priv_reconciliation_return" class="input_select_priv">
                                <option value='0'<?php if ($priv_reconciliation_return == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_reconciliation_return == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_reconciliation_return == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_reconciliation_return == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_reconciliation_return == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr height="30px"><td colspan="2"><b style="font-size: 17px">Reverse Cascade</b></td></tr>
                          <td align="left">Log in Forms SADs, ATTNs, etc</td>
                          <td align="left">
                            <select  name="priv_login_forms_reverse" class="input_select_priv">
                              <option value='0'<?php if ($priv_login_forms_reverse == '0') echo 'selected'; ?>>0 - No Access</option>
                              <option value='1'<?php if ($priv_login_forms_reverse == '1') echo 'selected'; ?>>1 - View</option>
                              <option value='2'<?php if ($priv_login_forms_reverse == '2') echo 'selected'; ?>>2 - View, Add</option>
                              <option value='3'<?php if ($priv_login_forms_reverse == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                              <option value='4'<?php if ($priv_login_forms_reverse == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                            </select>
                          </td>
                          </tr>
                          <tr>
                            <td align="left">Log Forms Sent</td>
                            <td align="left">
                              <select  name="priv_log_forms" class="input_select_priv">
                                <option value='0'<?php if ($priv_log_forms == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_log_forms == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_log_forms == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_log_forms == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_log_forms == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Log Forms Analysed </td>
                            <td align="left">
                              <select  name="priv_log_forms_analysed" class="input_select_priv">
                                <option value='0'<?php if ($priv_log_forms_analysed == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_log_forms_analysed == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_log_forms_analysed == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_log_forms_analysed == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_log_forms_analysed == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          
                        </table>
                      </div>
                    </div>

                    <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">
                      <br/><b style="font-size: 18px;">Performance Module Privileges</b><br/><br/>
                      <!--left div-->
                      <div style="float: left; width: 48%">
                        <table>
                          <tr height="30px"><td colspan="2"><b style="font-size: 17px">KPI Reports</b></td></tr>
                          <tr>
                            <td align="left">CIFF KPIs</td>
                            <td align="left">
                              <select  name="priv_ciff_kpi" class="input_select_priv">
                                <option value='0'<?php if ($priv_ciff_kpi == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_ciff_kpi == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_ciff_kpi == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if (priv_ciff_kpi == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_ciff_kpi == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr> 
                          <tr>
                            <td align="left">CIFF Report</td>
                            <td align="left">
                              <select  name="priv_ciff_report" class="input_select_priv">
                                <option value='0'<?php if ($priv_ciff_report == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_ciff_report == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_ciff_report == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_ciff_report == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_ciff_report == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">END Fund</td>
                            <td align="left">
                              <select  name="priv_end_fund" class="input_select_priv">
                                <option value='0'<?php if ($priv_end_fund == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_end_fund == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_end_fund == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_end_fund == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_end_fund == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>

                          <tr>
                            <td align="left">NTD</td>
                            <td align="left">
                              <select  name="priv_ntd" class="input_select_priv">
                                <option value='0'<?php if ($priv_ntd == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_ntd == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_ntd == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_ntd == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_ntd == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>

                          <tr>
                            <td align="left">US AID</td>
                            <td align="left">
                              <select  name="priv_usaid" class="input_select_priv">
                                <option value='0'<?php if ($priv_usaid == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_usaid == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_usaid == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_usaid == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_usaid == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">WHO</td>
                            <td align="left">
                              <select  name="priv_who" class="input_select_priv">
                                <option value='0'<?php if ($priv_who == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_who == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_who == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_who == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_who == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <!--right div-->
                      <div style="float: right; width: 48%">
                        <table>
                          <tr>
                            <td align="left">On Demand</td>
                            <td align="left">
                              <select  name="priv_demand" class="input_select_priv">
                                <option value='0'<?php if ($priv_demand == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_demand == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_demand == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_demand == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_demand == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Diagnostics</td>
                            <td align="left">
                              <select  name="priv_diagnostics" class="input_select_priv">
                                <option value='0'<?php if ($priv_diagnostics == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_diagnostics == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_diagnostics == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_diagnostics == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_diagnostics == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">Standard Reports </td>
                            <td align="left">
                              <select  name="priv_standard_reports" class="input_select_priv">
                                <option value='0'<?php if ($priv_standard_reports == '0') echo 'selected'; ?>>0 - No Access</option>
                                <option value='1'<?php if ($priv_standard_reports == '1') echo 'selected'; ?>>1 - View</option>
                                <option value='2'<?php if ($priv_standard_reports == '2') echo 'selected'; ?>>2 - View, Add</option>
                                <option value='3'<?php if ($priv_standard_reports == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                                <option value='4'<?php if ($priv_standard_reports == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                              </select>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>


                  </div>
                </div>
                <br/>
                <input class="btn-custom-pink" type="button" name="validate" id="validate" size="7" class='btn-custom-small' value="Validate" onclick="passConfirm()"/>
                <input class="btn-custom-pink" type="submit" name="Submit"  class='btn-custom-small' id="Submit" value="Save Record" />
                <a class="btn-custom-pink"  href="staff.php">Cancel</a>
                </form>
              <?php } ?>
            </div>
          </center>
        </div>

      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->

  </body>
</html>

<?php

}else{
  header("Location:home.php");
}
ob_flush();
?>