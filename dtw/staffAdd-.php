<?php
require_once('includes/auth.php');
require_once('includes/config.php');
require_once("includes/functions.php");
require_once("includes/form_functions.php");

$formsubmited == false;

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
            <h2 style="text-align: center"> Add New Staff</h2>
            <div style="float:right; width: 30%; margin-right:40px;">
              <p style="font-size:20px;line-height: 5px;">Staff image</p>
              <img style="float:left;border: black solid 2px;border-radius:10px;"height="200px" width="100%" src="images/staff/<?php echo$image ?>"/>
            </div>
            <div style="float:left; width: 60%;">
              <?php
              if (isset($_POST['Submit'])) {
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
                }
                $image = $image_name;
                $staff_name = mysql_prep($_POST['staff_name']);
                $staff_role = mysql_prep($_POST['staff_role']);
                $staff_gender = mysql_prep($_POST['staff_gender']);
                $staff_mobile = mysql_prep($_POST['staff_mobile']);
                $staff_email = mysql_prep($_POST['staff_email']);
                $staff_password = mysql_prep($_POST['password']); 

                $query = "INSERT INTO staff (image,staff_name,staff_role,staff_gender,staff_mobile,staff_email,staff_password) 
                        VALUES('{$image}','{$staff_name}','{$staff_role}','{$staff_gender}','{$staff_mobile}','{$staff_email}','{$staff_password}')";
                $result = mysql_query($query);
                if (!$result) {
                  die(mysql_error());
                } else {
                  echo "<div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;border-radius:10px; margin:5px;background-color:#a2ff7e;'>
                        <font align='justify' size='3px'><br/> New staff added successfully </font>
                        <br/><br/>
                      </div><br/>
                      <center><a href='staff.php' class='btn-custom'> Return to staff list</a></center>
                      <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                      ";
                  $formsubmited = true;
                }
              }
              if ($formsubmited == false) {
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="uploadImage" id="uploadImage">
                  <table cellspacing="5px" align="center">
                    <tr><td>Upload Image:</td><td><input type="file" name="image" id="image" size="27" /> </td></tr>
                    <tr><td>Name:</td><td><input type="text" name="staff_name" size="27" class="input_textbox" required/> </td></tr>
                    <tr>
                      <td align="left">Gender</td>
                      <td align="left">
                        <select  name="staff_gender" id="staff_gender"  class="input_select">
                          <option value='Male'>Male</option>
                          <option value='Female'>Female</option>
                        </select>
                      </td> 
                    </tr>
                    <tr><td>Phone Number</td><td align="left"><input class="input_textbox" type="text" name="staff_mobile" value="254" id="staff_mobile" maxlength="12"  onBlur="isPhoneNumber(this.id)" onKeyup="isPhoneNumber(this.id)"/><span id='staff_mobileSpan'></span></td></tr>
                    <tr><td>Email:</td><td><input type="text" name="staff_email" size="30"  class="input_textbox" required/> </td></tr>
                    <tr><td align="left">Role </td>
                      <td align="left">
                        <select name="staff_role" id="role"  class="input_select">
                          <?php
                          $sql = "SELECT * FROM role ORDER BY role ASC";
                          $result = mysql_query($sql);
                          while ($rows = mysql_fetch_array($result)) { //loop table rows 
                            ?>
                            <option value="<?php echo $rows['role']; ?>"><?php echo $rows['role']; ?></option>
                          <?php } ?>
                        </select> </td>
                    </tr>
                    <tr><td>Password :</td><td><input type="text" name="password" size="27"  class="input_textbox" required/></td></tr>
                    <!--<tr><td>Confirm Password :</td><td><input type="text" name="cpassword" size="27"  class="input_textbox"/></td></tr>-->
                    <tr><td></td><td><input class="btn-custom" type="submit" name="Submit" id="Upload" value="Save Record" /></td></tr>
                  </table>
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

    <!---------------- Footer ------------------------>
    <!--filter includes-->
    <script type="text/javascript" src="css/filter-as-you-type/jquery.min.js"></script>
    <script type="text/javascript" src="css/filter-as-you-type/jquery.quicksearch.js"></script>
    <script type="text/javascript">
                    $(function() {
                      $('input#id_search').quicksearch('table tbody tr');
                    });
    </script>
    <script>
      function show_confirm(staffid) {
        if (confirm("Are You Sure you want to delete?")) {
          location.replace('staff.php?staffid=' + staffid);
        } else {
          return false;
        }
      }
    </script>
  </body>
</html>
