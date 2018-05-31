<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once('../includes/db_functions.php');
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
        //Page Form
        if (isset($_POST['Submit'])) {
          //Check if Ministry Exists
          $query = "SELECT * FROM dropdown_ministry WHERE ministry = '{$_POST['ministry']}' LIMIT 1";
          $check_trip = mysql_query($query);
          $rows = mysql_num_rows($check_trip);

          if ($rows == 0) {
            //If no Errors Submit Form
            $ministry = mysql_prep($_POST['ministry']);
            $content = mysql_prep($_POST['content']);

            $query = "INSERT INTO dropdown_ministry (ministry) 
		VALUES ('{$ministry}')";
            $ministry_name = get_result_set($query);
            $messageToUser = "$ministry Created Successfully.";
          } else {
            if ($rows == 1) {
              $error_message.="Similar Ministry Name Exists";
            }
          }
        }
        ?>
        <table width="30%" align="center">
          <form action="" method="POST">
            <?php include("includes/messageBox.php"); ?>
            <tr>
              <td colspan="4" align="center"><input type="text" name="ministry" placeholder="Type name here" required/> <input type="submit" name="Submit"  value="Add Ministry"/></td>
            </tr>
          </form>
          <tr><th>ID</th><th>Ministry Name</th><th></th><th></th></tr>
          <?php {
            $result_set = mysql_query("SELECT * FROM dropdown_ministry");
            $indexcounter = 1;
            while ($row = mysql_fetch_array($result_set)) {
              $id = $row['id'];
              $ministry = $row['ministry'];
              ?>
              <tr>
                <td><?php echo $indexcounter ?></td>
                <td><?php echo $ministry ?></td>
                <td><a href="edit_ministry.php?id=<?php echo $id; ?>" onclick="javascript:void window.open('edit_ministry.php?id=<?php echo $id; ?>', '1397210634467', 'width=700,height=500,status=1,scrollbars=1,resizable=1,left=350,top=0');
          return false;"><img src='images/icons/edit.jpg' alt="edit" width="20" height="20" border="0" /></a></td>
                <td><a href="delete_ministry.php?id=<?php echo $id; ?>" onclick="return confirm('Are you Sure you want to Delete Record?');"> <img src='images/icons/delete.png' alt="Delete" width="20" height="20" border="0" /></a></td>
              </tr>
              <?php
              $indexcounter++;
            }
          }
          ?>
        </table>
        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
  </body>
</html>

