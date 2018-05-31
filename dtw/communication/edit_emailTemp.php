<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once('../includes/db_functions.php');
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
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?>
      </div>
    </div>
    <?php
    if (isset($_POST['submitSendEMAIL'])) {
      //Post Values to DB
      $sender = $_POST['sender'];
      $recipient_name = $_POST['recipient_name'];
      $recipient_number = $_POST['recipient_number'];
      $subject = $_POST['subject'];
      $email_body = $_POST['email_body'];

      //Clean Data
      $sender = addslashes(trim($sender));
      $recipient_name = addslashes(trim($recipient_name));
      $recipient_number = addslashes(trim($recipient_number));
      $subject = addslashes(trim($subject));
      $email_body = addslashes(trim($email_body));

      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];

      require_once 'email.php'; 

      $email = new email();
      $email->sendEMAIL($recipient_number, $email_body);


      //insert data
      $query = ("INSERT INTO comm_email (sender,recipient_name, recipient_number, subject, email_body) VALUES ('$sender','$recipient_name','$recipient_number','$subject','$email_body')" );
      mysql_query($query) or die(mysql_error("Could not enter"));
      $messageToUser = "EMAIL Sent Successfully!";
      $action = "Added A CountY";
      $description = "County Name: " . $county . " Added";

      //Log Entry Data
      //$arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      //funclogAdminData($arrLogAdminData);
    }
    ?>

    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-Communication.php"); ?>
      </div>
      <div class="contentBody" >
        <div class="tabbable" >
          <ul class="nav nav-tabs">
            <li class="active"><a href="#" data-toggle="tab">EMAIL Editing</a></li>
          </ul>
            
            
         <?php
        //Delete +++++++++++++++++++++++++++++++
        if (isset($_GET['delete_id_titles'])) {
          $deleteid = $_GET['delete_id_titles'];
          $query = "DELETE FROM comm_email_template WHERE id='$deleteid'";
          $result = mysql_query($query) or die(mysql_error());
          //$error_message.="Record Deleted";
          $tabActive = 'tab1';
        }

        if (isset($_POST['Addtitle'])) {
          $tabActive = 'tab1';
        } 
        ?>           
            
            
            
            
            
            
                <!--tab 1 ==================================================================================================-->
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
              <?php
              //Page Form
              
              if (isset($_POST['Addtitle'])) {
                $title = addslashes($_POST['title']);
                $subject=addslashes($_POST['subject']);
                $body = addslashes($_POST['body']);                

                //Check if Title Exists
                $query = "SELECT * FROM comm_email_template WHERE title = '$title' LIMIT 1";
                $check_trip = mysql_query($query);
                $rows = mysql_num_rows($check_trip);

                if ($rows == 0) {
                  //If no Errors Submit Form
                  $query = "INSERT INTO comm_email_template (title, subject, body)  VALUES ('{$title}','{$subject}','{$body}')";
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
            
            
            
              <table width="70%" align="center">
                <tr>
                  <th align="left">ID</th>
                  <th align="left">Title</th>
                  <th align="left">Subject</th>
                  <th align="left">Body</th>
                  <th align="left">Edit</th>
                  <th align="left">Del</th>
                </tr>
                <?php {
                  $result_set = mysql_query("SELECT * FROM comm_email_template");
                  $indexcounter = 1;
                  while ($row = mysql_fetch_array($result_set)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $subject=$row['subject'];
                    $body = $row['body'];
                    ?>
                    <tr>
                      <td align="left"><?php echo $indexcounter ?></td>
                      <td><?php echo $title ?></td> 
                      <td><?php echo $subject ?></td>
                      <td><?php echo $body ?></td>
                      <td>
                        <a href="?id=<?php echo $id; ?>#modaltitles"><img src='../images/icons/edit.png' alt="edit" width="20" height="20" border="0" /></a>
                      </td>
                      <td>
                        <a href="javascript:void(0)" onclick='delete_confirm_titles(<?php echo $id; ?>);'> <img src='../images/icons/delete.png' alt="Delete" width="20" height="20" border="0" /></a>
                      </td> 
                    </tr>
                    <?php
                    $indexcounter++;
                  }
                }
                ?> 
                <form action="" method="POST">
                  <tr height="40px">
                    <td colspan="2" align="center"><input type="text" name="title" placeholder="New title" required/> 
                    </td>
                    <td align="center"><input style="width:100%" type="text" name="subject" placeholder="New subject" required/> 
                    </td>
                    <td align="center"><input style="width:100%" type="text" name="body" placeholder="New body" required/> 
                    </td>
                    <td>
                      <input type="submit" name="Addtitle"  value="Add"/>
                    </td>
                  </tr>
                </form>
              </table>


        <!--Delete dialog-->
        <script>                          
                          function delete_confirm_titles(deleteid) {
                            if (confirm("Are you sure you want to delete?")) {
                              location.replace('?delete_id_titles=' + deleteid);
                            } else {
                              return false;
                            }
                          }
        </script>

        <!--MODALS +++++++++++++++++++++++++++++++++++++++-->
<div id="modaltitles" class="modalDialog">
  <div  style="width: 300px">
   
    <!-- ================= -->
    <?php
    $id = $_GET[id];

    //Update Page Form
    if (isset($_POST['Submit'])) {
      //If no Errors Submit Form
      $title = mysql_prep($_POST['title']);
      $subject = mysql_prep($_POST['subject']);
      $body = mysql_prep($_POST['body']);
      $sql = "UPDATE comm_email_template SET title='$title', subject='$subject', body='$body' WHERE id='$id'";
      $result = mysql_query($sql) or die(mysql_error());
      $messageToUser = ".Updated Successfully.";
    }
    ?> 
    
    <table style="min-width:250px;">
      <?php
      $result_set = mysql_query("SELECT * FROM comm_email_template WHERE id='$id'");
      while ($row = mysql_fetch_array($result_set)) {
        $id = $row['id'];
        $title = $row['title'];
        $subject=$row['subject'];
        $body= $row['body'];
        ?>
        <tr>
          <td>
            <form action='' method='POST'>
              <?php include("../includes/messageBox.php"); ?>
              <h2 align="center">Edit Template</h2>
              <p>Title<br>
              <input type="text" name="title" style="width: 300px;" value="<?php echo $title ?>" required> </p>
              <p>Subject<br>
              <input type="text" name="subject" style="width: 300px;" value="<?php echo $subject ?>" required> </p>
              <p>body<br>
              <input type="text" name="body" style="width: 300px;" value="<?php echo $body ?>" required> </p>
              <p align="center">
                <input type="submit" name="Submit" id="Submit" value="Update Template" class="btn-custom-pink"/> 
                <a href="edit_emailTemp.php" class="btn-custom-pink" style="width: 200px;">Close</a>
              </p>
            </form>
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>
</div> 