<?php
ob_start();
require_once('includes/auth.php');
require_once('includes/config.php');
require_once("includes/functions.php");
require_once("includes/form_functions.php");
$tabActive = 'tab1';
$formsubmited == false;

$staff_id = $_GET['staff_id'];
$result_set = mysql_query("SELECT * FROM other_users WHERE staff_id='$staff_id' LIMIT 1");
while ($row = mysql_fetch_array($result_set)) {
  $staff_id = $row['staff_id'];
  $image = $row['image'];
  $staff_name = $row['staff_name'];
  $staff_role = $row["staff_role"];
  $staff_gender = $row["staff_gender"];
  $staff_mobile = $row["staff_mobile"];
  $staff_email = $row["staff_email"];
  $staff_password = $row["staff_password"];


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
                $query = "UPDATE other_users SET image='$image',staff_name='$staff_name',staff_role='$staff_role',staff_gender='$staff_gender',
                    staff_mobile='$staff_mobile',email='$email',staff_password='$staff_password',staff_password='$staff_password' WHERE staff_id='$staff_id' ";
                $result = mysql_query($query);
                if (!$result) {
                  die(mysql_error());
                }
              } else {
                $query = "UPDATE other_users SET staff_name='$staff_name',staff_role='$staff_role',staff_gender='$staff_gender',
                   staff_mobile='$staff_mobile',staff_email='$staff_email',staff_password='$staff_password',staff_password='$staff_password'                   
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
                    <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Non-Staff Details</a></li>
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
                               
                                  <option selected="selected" value="<?php echo $staff_role; ?>"><?php echo $staff_role; ?></option>
                                  <option value="Vendor">Vendor</option>
                                    <option value="Teacher Trainer">Teacher Trainer</option>
                                    <option value="Master Trainer">Master Trainer</option>

                              </select> </td>
                          </tr>
                          <tr><td>staff_password :</td><td><input class="input_textbox_p compact" type="password" name="staff_password"  id="staff_password"  value="<?php echo $staff_password; ?>"size="27"  /></td></tr>
                          <tr><td>Confirm staff_password :</td><td><input class="input_textbox_p compact" type="password" name="staff_password2"  id="staff_password2"  value="<?php echo $staff_password; ?>"size="27"  /><span id='passSpan'></span></td></tr>
                        </table>
                        <br/>
                        <br/>
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