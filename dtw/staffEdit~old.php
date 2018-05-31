<?php
require_once('includes/auth.php');
require_once('includes/config.php');
require_once("includes/functions.php");
require_once("includes/form_functions.php");

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
  $priv_dropdowns = $row["priv_dropdowns"];
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once("includes/meta-link-script.php"); ?>
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
            <h2 style="text-align: center"> Staff Edit</h2>
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
              $priv_dropdowns = mysql_prep($_POST['priv_dropdowns']);
              
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
                    priv_dropdowns='$priv_dropdowns',
                    staff_mobile='$staff_mobile' WHERE staff_id='$staff_id' ";
                $result = mysql_query($query) or die(mysql_error());
              }
              echo "<div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;border-radius:10px; margin:5px;background-color:#a2ff7e;'>
                        <font align='justify' size='3px'><br/> Staff record updated successfully </font>
                        <br/><br/>
                      </div><br/>
                      <center><a href='staff.php' class='btn-custom'> Return to staff list</a></center>
                      <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                      ";
              $formsubmited = true;
            }
            if ($formsubmited == false) {
              ?> 
              <div style="float:right; width: 30%; margin-right:40px;">
                <p style="font-size:20px;line-height: 5px;">Contact image</p>
                <img style="border: black solid 2px;border-radius:10px;"height="200px" src="images/staff/<?php echo$image ?>"/>
              </div>
              <div style="float:left; width: 60%;">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="uploadImage" id="uploadImage">
                  <table cellspacing="5px" align="center">
                    <tr><td>Staff ID:</td><td><input name="staff_id" value="<?php echo $staff_id ?>" size="10" readonly  /> </td></tr>
                    <tr><td>Upload Image:</td><td><input type="file" name="image" id="image" size="27" /> </td></tr>
                    <tr><td>Name:</td><td><input type="text" name="staff_name" size="27" value="<?php echo $staff_name; ?>"/> </td></tr>
                    <tr>
                      <td align="left">Gender</td>
                      <td align="left">
                        <select  name="staff_gender" id="staff_gender" onChange="hideSaveButton();">
                          <option value='Male'<?php if ($staff_gender == 'Male') echo 'selected'; ?> >Male</option>
                          <option value='Female'<?php if ($staff_gender == 'Female') echo 'selected'; ?>>Female</option>
                        </select>
                      </td>
                    </tr>
                    <tr><td>Email:</td><td><input type="text" name="staff_email" value="<?php echo $staff_email; ?>" size="30"/> </td></tr>
                    <tr><td align="left">Role </td>
                      <td align="left">
                        <select name="staff_role" id="staff_role">
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
                    <tr><td>staff_password :</td><td><input type="password" name="staff_password"  id="staff_password"  value="<?php echo $staff_password; ?>"size="27"  /></td></tr>
                    <tr><td>Confirm staff_password :</td><td><input type="password" name="staff_password2"  id="staff_password2"  value="<?php echo $staff_password; ?>"size="27"  /><span id='passSpan'></span></td></tr>
                  </table>
                  <br/>
                  <br/>
                  <table cellspacing="5px" align="center">
                    <h3 style="text-align: center">Privileges</h3>
                    <tr>
                      <td align="left">County List</td>
                      <td align="left">
                        <select  name="priv_counties">
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
                        <select  name="priv_districts">
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
                        <select  name="priv_divisions">
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
                        <select  name="priv_schools">
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
                        <select  name="priv_moh">
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
                        <select  name="priv_moest">
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
                        <select  name="priv_master_trainers">
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
                        <select  name="priv_county_contacts">
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
                        <select  name="priv_dropdowns‏">
                          <option value='0'<?php if ($priv_dropdowns == '0') echo 'selected'; ?>>0 - No Access</option>
                          <option value='1'<?php if ($priv_dropdowns == '1') echo 'selected'; ?>>1 - View</option>
                          <option value='2'<?php if ($priv_dropdowns == '2') echo 'selected'; ?>>2 - View, Add</option>
                          <option value='3'<?php if ($priv_dropdowns == '3') echo 'selected'; ?>>3 - View, Add, Edit</option>
                          <option value='4'<?php if ($priv_dropdowns == '4') echo 'selected'; ?>>4 - View, Add, Edit, Delete</option>
                        </select>
                      </td> 
                    </tr>
                  </table>
                  <br/>
                  <br/>
                  <input class="btn-custom-small" type="button" name="validate" id="validate" size="7" class='btn-custom-small' value="Validate" onclick="passConfirm()"/>
                  <input class="btn-custom-small" type="submit" name="Submit"  class='btn-custom-small' id="Submit" value="Save Record" />
                  <a class="btn-custom-small"  href="staff.php">Cancel</a>
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

