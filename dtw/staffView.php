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
  $staff_emailstaff = $row["staff_email"];
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

function previlage_check($value) {
  switch ($value) {
    case 0:
      echo "0 - No Access";
      break;

    case 1:
      echo "1 - View";
      break;

    case 2:
      echo "2 - View, Add";
      break;

    case 3:
      echo "3 - View, Add, Edit";
      break;

    case 4:
      echo "4 - View, Add, Edit, Delete";
      break;
  }
}

//end
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

          <div style="float:right; width: 30%; margin-right:40px;">
            <p style="font-size:20px;line-height: 5px;">Contact image</p>
            <img style="border: black solid 2px;border-radius:10px;"height="200px" src="images/staff/<?php echo$image ?>"/>
          </div>
          <div style="float:left; width: 60%;">
            <h2 style="text-align: center">View Staff Details</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="uploadImage" id="uploadImage">
              <table cellspacing="5px" align="center">
                <tr><td>Staff ID:</td><td><input name="staff_id" value="<?php echo $staff_id ?>" size="10" readonly  /> </td></tr>
                <!--<tr><td>Upload Image:</td><td><input type="file" name="image" id="image" size="27" /> </td></tr>-->
                <tr><td>Name:</td><td><input type="text" name="name" size="27" value="<?php echo $staff_name; ?>"/> </td></tr>
                <tr>
                  <td align="left">Gender</td>
                  <td align="left">
                    <select  name="staff_gender" id="staff_gender" onChange="hideSaveButton();" style="width: 100px">
                      <option value='Male'<?php if ($staff_gender == 'Male') echo 'selected'; ?> >Male</option>
                      <option value='Female'<?php if ($staff_gender == 'Female') echo 'selected'; ?>>Female</option>
                    </select>
                  </td>
                </tr>
                <tr><td>Phone Number</td><td align="left"><input type="text" value="<?php echo $staff_mobile; ?>"name="staff_mobile"  id="staff_mobile" maxlength="12"  onBlur="isPhoneNumber(this.id)" onKeyup="isPhoneNumber(this.id)"/><span id="staff_mobileSpan"></span></td></tr>
                <tr><td>Staff Email:</td><td><input type="text" name="staff_email" value="<?php echo $staff_emailstaff; ?>" size="40"/> </td></tr>
                <tr><td align="left">Staff Role </td>
                  <td align="left">
                    <select name="staff_role" id="staff_role">
                      <?php
                      $sql = "SELECT * FROM role ORDER BY role ASC";
                      $rRole = mysql_query($sql);
                      while ($rows = mysql_fetch_array($rRole)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['role']; ?>"<?php
                        if ($staff_role == $rows['role']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['role']; ?></option>
                              <?php } ?>
                    </select> </td>
                </tr>


                <tr><td>Staff Password :</td><td><input type="password" name="staff_password"  id="staff_password"  value="<?php echo $staff_password; ?>"size="27"  /></td></tr>
                <tr><td>Confirm Staff Password :</td><td><input type="password" name="staff_password2"  id="staff_password2"  value="<?php echo $staff_password; ?>"size="27"  /><span id="passSpan"></span></td></tr>
              </table><br/>

              <table cellspacing="5px" align="center">
                <h3 style="text-align: center">Privileges</h3>
                <tr>
                  <td align="left">County List</td>
                  <td align="left"><input type="text" value="<?php echo previlage_check($priv_counties); ?>" readonly/></td>
                </tr>
                <tr>
                  <td align="left">Districts List</td>
                  <td align="left"><input type="text" value="<?php echo previlage_check($priv_districts); ?>" readonly/></td>
                </tr>
                <tr>
                  <td align="left">Division List</td>
                  <td align="left"><input type="text" value="<?php echo previlage_check($priv_divisions); ?>" readonly/></td>
                </tr>
                <tr>
                  <td align="left">School List</td>
                  <td align="left"><input type="text" value="<?php echo previlage_check($priv_schools); ?>" readonly/></td>
                </tr>
                <tr>
                  <td align="left">MOH List</td>
                  <td align="left"><input type="text" value="<?php echo previlage_check($priv_moh); ?>" readonly/></td>
                </tr>
                <tr>
                  <td align="left">MOEST List</td>
                  <td align="left"><input type="text" value="<?php echo previlage_check($priv_moest); ?>" readonly/></td>
                </tr>
                <tr>
                  <td align="left">Master Trainer List</td>
                  <td align="left"><input type="text" value="<?php echo previlage_check($priv_master_trainers); ?>" readonly/></td>
                </tr>
                <tr>
                  <td align="left">Contacts List</td>
                  <td align="left"><input type="text" value="<?php echo previlage_check($priv_county_contacts); ?>" readonly/></td>
                </tr>
                <tr>
                  <td align="left">Dropdowns List</td>
                  <td align="left"><input type="text" value="<?php echo previlage_check($priv_dropdowns); ?>" readonly/></td>
                </tr>
              </table>
              <br/>
              <br/>
              <a class="btn-custom"  href="staff.php">Back</a>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->
  </body>
</html>
