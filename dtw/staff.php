<?php
ob_start();
require_once('includes/auth.php');
require_once('includes/config.php');
require_once("includes/functions.php");
require_once("includes/form_functions.php");
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
        <form action="#">
          <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
          <b style="margin-left:20%;width: 100px; font-size:1.5em;">Staff Members</b>
          <a class="btn-custom-small" href="staffAdd.php">Add new staff</a>
        </form>
        <br/>
        <div style="width:100%; height:450px; overflow-y: scroll;">
          <?php
          if (isset($_GET['staff_id'])) {
            $query = "DELETE FROM staff WHERE staff_id= '$_GET[staff_id]'";
            mysql_query($query) or die(mysql_error());
          }
          ?>
          <table width="100%" border="1" align="center" cellspacing="1" class="table-hover">
            <thead>
              <th><b>ID</b></th>
              <th><b>Name</b></th>
              <th><b>Gender</b></th>
              <th><b>Phone</b></th>
              <th><b>Email</b></th>
              <th><b>Role</b></th>
              <th><b></b></th>
              <th><b></b></th>
            </thead>
            <?php
            $result_set = mysql_query("SELECT * FROM staff ORDER BY staff_id DESC");
            while ($row = mysql_fetch_array($result_set)) {
              $staff_id = $row['staff_id'];
              $staff_name = $row['staff_name'];
              $staff_gender = $row['staff_gender'];
              $staff_mobile = $row['staff_mobile'];
              $staff_role = $row['staff_role'];
              $staff_email = $row['staff_email'];
              ?>
              <tr bgcolor="#FFFFFF" style="border-bottom: 1px solid #B4B5B0;">
                <td><?php echo $staff_id ?></td>
                <td><?php
                  echo substr($staff_name, 0, 20);
                  if (strlen($staff_name) > 20)
                    echo "..";
                  ?>
                </td>
                <td><?php echo $staff_gender ?></td>
                <td><?php echo $staff_mobile ?></td>
                <td><?php echo $staff_email ?></td>
                <td><?php echo $staff_role ?></td>

                <td align="center"><a href='staffView.php?staff_id=<?php echo $staff_id; ?>'><img src="images/icons/view2.png" height="20px"/></a></td>
                <td align="center"><a href='staffEdit.php?staff_id=<?php echo $staff_id; ?>'><img src="images/icons/edit2.png" height="20px"/></a></td>
                <td align="center"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $staff_id; ?>);'><img src="images/icons/delete.png" height="20px"/></a></td>
              </tr>

              <!--
                <form method="POST" action="#viewMT">
                  <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                  <td align="center" width="4%"><input type="submit" name="viewDetails" value="" style="background: url(images/icons/view2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                </form>

                <form method="POST" action="#editMT">
                  <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                  <td align="center" width="4%"><input type="submit" name="editDetails" value="" style="background: url(images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                </form>-->

            <?php } ?>
          </table>
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
      function show_confirm(staff_id) {
        if (confirm("Are you Sure you want to delete?")) {
          location.replace('staff.php?staff_id=' + staff_id);
        } else {
          return false;
        }
      }
    </script>
  </body>
</html>

<?php

}else{
  header("Location:home.php");
}
ob_flush();
?>