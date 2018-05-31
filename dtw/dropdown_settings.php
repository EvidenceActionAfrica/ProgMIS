<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
$tabActive = 'tab1';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>
  </head>
  <body >
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
        <?php require_once ("includes/menuLeftBar-AdminData.php"); ?>
      </div>
      <div class="contentBody">





        <?php
        //Delete +++++++++++++++++++++++++++++++
        //Ministries-------------
        if (isset($_GET['delete_id_ministries'])) {
          $deleteid = $_GET['delete_id_ministries'];
          $query = "DELETE FROM dropdown_ministry WHERE id='$deleteid'";
          $result = mysql_query($query) or die(mysql_error());
          //$error_message.="Record Deleted";
          $tabActive = 'tab1';
        }
        //County Titles Class------------
        if (isset($_GET['delete_id_county_titles'])) {
          $deleteid = $_GET['delete_id_county_titles'];
          $query = "DELETE FROM dropdown_county_titles WHERE id='$deleteid'";
          $result = mysql_query($query) or die(mysql_error());
          //$error_message.="Record Deleted";
          $tabActive = 'tab2';
        }
        //JobClass------------
        if (isset($_GET['delete_id_jobclass'])) {
          $deleteid = $_GET['delete_id_jobclass'];
          $query = "DELETE FROM dropdown_jobclass WHERE id='$deleteid'";
          $result = mysql_query($query) or die(mysql_error());
          //$error_message.="Record Deleted";
          $tabActive = 'tab3';
        }






        if (isset($_POST['AddMinistry'])) {
          $tabActive = 'tab1';
        } else if (isset($_POST['AddCountyTitle'])) {
          $tabActive = 'tab2';
        } else if (isset($_POST['AddJobClass'])) {
          $tabActive = 'tab3';
        }
        ?>





        <!--tabbable +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
        <div class="tabbable" >
          <ul class="nav nav-tabs">
            <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Ministries</a></li>
            <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">County Contact Titles</a></li>
            <li class="<?php if ($tabActive == 'tab3') echo 'active'; ?>"><a href="#tab3" data-toggle="tab">Job Class</a></li>

          </ul>
          <div class="tab-content">
            <!--tab 1 ==================================================================================================-->
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
              <?php
              //Page Form
              if (isset($_POST['AddMinistry'])) {
                $ministry = addslashes($_POST['ministry']);

                //Check if Ministry Exists
                $query = "SELECT * FROM dropdown_ministry WHERE ministry = '$ministry' LIMIT 1";
                $check_trip = mysql_query($query);
                $rows = mysql_num_rows($check_trip);

                if ($rows == 0) {
                  //If no Errors Submit Form
                  $query = "INSERT INTO dropdown_ministry (ministry)  VALUES ('{$ministry}')";
                  $ministry_name = get_result_set($query);
                  $messageToUser = "$ministry Added Successfully.";
                } else {
                  if ($rows == 1) {
                    $error_message.="Similar Ministry Name Exists";
                  }
                }
              }
              ?>
              <br/>
              <br/>
              <?php include("includes/messageBox.php"); ?>
              <table width="30%" align="center">
                <tr>
                  <th align="left">ID</th>
                  <th align="left">Ministry Name</th>
                  <th align="left">Edit</th>
                  <th align="left">Del</th>
                </tr>
                <?php {
                  $result_set = mysql_query("SELECT * FROM dropdown_ministry");
                  $indexcounter = 1;
                  while ($row = mysql_fetch_array($result_set)) {
                    $id = $row['id'];
                    $ministry = $row['ministry'];
                    ?>
                    <tr>
                      <td align="left"><?php echo $indexcounter ?></td>
                      <td><?php echo $ministry ?></td>
                      <td>
                        <a href="?id=<?php echo $id; ?>#modalMinistries"><img src='images/icons/edit.png' alt="edit" width="20" height="20" border="0" /></a>
                      </td>
                      <td>
                        <a href="javascript:void(0)" onclick='delete_confirm_ministries(<?php echo $id; ?>);'> <img src='images/icons/delete.png' alt="Delete" width="20" height="20" border="0" /></a>
                      </td> 
                    </tr>
                    <?php
                    $indexcounter++;
                  }
                }
                ?> 
                <form action="" method="POST">
                  <tr height="40px">
                    <td colspan="2" align="center"><input type="text" name="ministry" placeholder="New ministry name" required/> 
                    </td>
                    <td colspan="2">
                      <input type="submit" name="AddMinistry"  value="Add Ministry"/>
                    </td>
                  </tr>
                </form>
              </table>
              <br/>
              <br/>
            </div>
            <!--tab 2 ==================================================================================================-->
            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
              <?php
              //Page Form
              if (isset($_POST['AddCountyTitle'])) {
                $title = addslashes($_POST['title']);

                //Check if county title Exists
                $query = "SELECT * FROM dropdown_county_titles WHERE title = '$title' LIMIT 1";
                $check_trip = mysql_query($query);
                $rows = mysql_num_rows($check_trip);

                if ($rows == 0) {
                  //If no Errors Submit Form
                  $query = "INSERT INTO dropdown_county_titles (title)  VALUES ('{$title}')";
                  get_result_set($query);
                  $messageToUser = "$title Added Successfully.";
                } else {
                  if ($rows == 1) {
                    $error_message.="Similar Title Name Exists";
                  }
                }
              }
              ?>
              <br/>
              <br/>
              <?php include("includes/messageBox.php"); ?>
              <table width="30%" align="center">
                <tr>
                  <th align="left">ID</th>
                  <th align="left">Contact Title</th>
                  <th align="left">Edit</th>
                  <th align="left">Del</th>
                </tr>
                <?php {
                  $result_set = mysql_query("SELECT * FROM dropdown_county_titles");
                  $indexcounter = 1;
                  while ($row = mysql_fetch_array($result_set)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    ?>
                    <tr>
                      <td align="left"><?php echo $indexcounter ?></td>
                      <td><?php echo $title ?></td>
                      <td>
                        <a href="?id=<?php echo $id; ?>#modalCountyTitles"><img src='images/icons/edit.png' alt="edit" width="20" height="20" border="0" /></a>
                      </td>
                      <td>
                        <a href="javascript:void(0)" onclick='delete_confirm_county_titles(<?php echo $id; ?>);'> <img src='images/icons/delete.png' alt="Delete" width="20" height="20" border="0" /></a>
                      </td> 
                    </tr>
                    <?php
                    $indexcounter++;
                  }
                }
                ?> 
                <form action="" method="POST">
                  <tr height="40px">
                    <td colspan="2" align="center"><input type="text" name="title" placeholder="New title name" required/> 
                    </td>
                    <td colspan="2">
                      <input type="submit" name="AddCountyTitle"  value="Add County Title"/>
                    </td>
                  </tr>
                </form>
              </table>
              <br/>
              <br/>
            </div>
            <!--tab 3 ==================================================================================================-->
            <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
              <?php
              //Page Form
              if (isset($_POST['AddJobClass'])) {
                $job_class = addslashes($_POST['job_class']);

                //Check if job_class Exists
                $query = "SELECT * FROM dropdown_jobclass WHERE job_class = '$job_class' LIMIT 1";
                $check_trip = mysql_query($query);
                $rows = mysql_num_rows($check_trip);

                if ($rows == 0) {
                  //If no Errors Submit Form
                  $query = "INSERT INTO dropdown_jobclass (job_class)  VALUES ('{$job_class}')";
                  get_result_set($query);
                  $messageToUser = "$job_class Added Successfully.";
                } else {
                  if ($rows == 1) {
                    $error_message.="Similar Job Class Name Exists";
                  }
                }
              }
              ?>
              <br/>
              <br/>
              <?php include("includes/messageBox.php"); ?>
              <table width="30%" align="center">
                <tr>
                  <th align="left">ID</th>
                  <th align="left">Job Class </th>
                  <th align="left">Edit</th>
                  <th align="left">Del</th>
                </tr>
                <?php {
                  $result_set = mysql_query("SELECT * FROM dropdown_jobclass");
                  $indexcounter = 1;
                  while ($row = mysql_fetch_array($result_set)) {
                    $id = $row['id'];
                    $job_class = $row['job_class'];
                    ?>
                    <tr>
                      <td align="left"><?php echo $indexcounter ?></td>
                      <td><?php echo $job_class ?></td>
                      <td>
                        <a href="?id=<?php echo $id; ?>#modalJobClass"><img src='images/icons/edit.png' alt="edit" width="20" height="20" border="0" /></a>
                      </td>
                      <td>
                        <a href="javascript:void(0)" onclick='delete_confirm_jobclass(<?php echo $id; ?>);'> <img src='images/icons/delete.png' alt="Delete" width="20" height="20" border="0" /></a>
                      </td> 
                    </tr>
                    <?php
                    $indexcounter++;
                  }
                }
                ?> 
                <form action="" method="POST">
                  <tr height="40px">
                    <td colspan="2" align="center"><input type="text" name="job_class" placeholder="New job class" required/> 
                    </td>
                    <td colspan="2">
                      <input type="submit" name="AddJobClass"  value="Add Job Class"/>
                    </td>
                  </tr>
                </form>
              </table>
              <br/>
              <br/>
            </div>

          </div>
        </div>






        <!--Delete dialog-->
        <script>
                          //ministries
                          function delete_confirm_ministries(deleteid) {
                            if (confirm("Are you sure you want to delete?")) {
                              location.replace('?delete_id_ministries=' + deleteid);
                            } else {
                              return false;
                            }
                          }
                          //county titles
                          function delete_confirm_county_titles(deleteid) {
                            if (confirm("Are you sure you want to delete?")) {
                              location.replace('?delete_id_county_titles=' + deleteid);
                            } else {
                              return false;
                            }
                          }
                          //job class
                          function delete_confirm_jobclass(deleteid) {
                            if (confirm("Are you sure you want to delete?")) {
                              location.replace('?delete_id_jobclass=' + deleteid);
                            } else {
                              return false;
                            }
                          }
        </script>


      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>

  </body>
</html>






<!--MODALS +++++++++++++++++++++++++++++++++++++++-->
<!--==== Ministries ======-->
<div id="modalMinistries" class="modalDialog">
  <div  style="width: 350px">
    <!--<a href="#close" title="Close" class="close">X</a>-->
    <!-- ================= -->
    <?php
    $id = $_GET[id];

    //Update Page Form
    if (isset($_POST['Submit'])) {
      //If no Errors Submit Form
      $ministry = mysql_prep($_POST['ministry']);
      $content = mysql_real_escape_string($_POST['content']);

      $sql = "UPDATE dropdown_ministry SET ministry='$ministry' WHERE id='$id'";
      $result = mysql_query($sql) or die(mysql_error());
      $messageToUser = "Ministry Updated Successfully.";
    }
    ?> 
    <table style="min-width:250px;" align="center">
      <?php
      $result_set = mysql_query("SELECT * FROM dropdown_ministry WHERE id='$id'");
      while ($row = mysql_fetch_array($result_set)) {
        $id = $row['id'];
        $ministry = $row['ministry'];
        ?>
        <tr>
          <td>
            <form action='' method='POST'>
              <?php include("includes/messageBox.php"); ?>
              <h2 align="center">Edit Ministry</h2>
              <p><input type="text" name="ministry" style="width: 250px;" value="<?php echo $ministry ?>" required> </p>
              <p align="center">
                <input type="submit" name="Submit" id="Submit" value="Update Ministry" class="btn-custom-pink"/> 
                <a href="dropdown_settings.php" class="btn-custom-pink">Close</a>
              </p>
            </form>
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>
</div> 



<!--==== county titles ======-->
<div id="modalCountyTitles" class="modalDialog">
  <div  style="width: 350px">
    <!--<a href="#close" title="Close" class="close">X</a>-->
    <!-- ================= -->
    <?php
    $id = $_GET[id];

    //Update Page Form
    if (isset($_POST['Submit'])) {
      //If no Errors Submit Form
      $title = mysql_prep($_POST['title']);

      $sql = "UPDATE dropdown_county_titles SET title='$title' WHERE id='$id'";
      $result = mysql_query($sql) or die(mysql_error());
      $messageToUser = "Title Updated Successfully.";
    }
    ?> 
    <table style="min-width:250px;" align="center">
      <?php
      $result_set = mysql_query("SELECT * FROM dropdown_county_titles WHERE id='$id'");
      while ($row = mysql_fetch_array($result_set)) {
        $id = $row['id'];
        $title = $row['title'];
        ?>
        <tr>
          <td>
            <form action='' method='POST'>
              <?php include("includes/messageBox.php"); ?>
              <h2 align="center">Edit County Title</h2>
              <p><input type="text" name="title" style="width: 250px;" value="<?php echo $title ?>" required> </p>
              <p align="center">
                <input type="submit" name="Submit" id="Submit" value="Update Title" class="btn-custom-pink"/> 
                <a href="dropdown_settings.php" class="btn-custom-pink">Close</a>
              </p>
            </form>
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>
</div> 



<!--==== Job class ======-->
<div id="modalJobClass" class="modalDialog">
  <div  style="width: 350px">
    <!--<a href="#close" title="Close" class="close">X</a>-->
    <!-- ================= -->
    <?php
    $id = $_GET[id];

    //Update Page Form
    if (isset($_POST['Submit'])) {
      //If no Errors Submit Form
      $job_class = mysql_prep($_POST['job_class']);

      $sql = "UPDATE dropdown_jobclass SET job_class='$job_class' WHERE id='$id'";
      $result = mysql_query($sql) or die(mysql_error());
      $messageToUser = "Ministry Updated Successfully.";
    }
    ?> 
    <table style="min-width:250px;" align="center">
      <?php
      $result_set = mysql_query("SELECT * FROM dropdown_jobclass WHERE id='$id'");
      while ($row = mysql_fetch_array($result_set)) {
        $id = $row['id'];
        $job_class = $row['job_class'];
        ?>
        <tr>
          <td>
            <form action='' method='POST'>
              <?php include("includes/messageBox.php"); ?>
              <h2 align="center">Edit Job Class</h2>
              <p><input type="text" name="job_class" style="width: 250px;" value="<?php echo $job_class ?>" required> </p>
              <p align="center">
                <input type="submit" name="Submit" id="Submit" value="Update Job class" class="btn-custom-pink"/> 
                <a href="dropdown_settings.php" class="btn-custom-pink">Close</a>
              </p>
            </form>
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>
</div> 
