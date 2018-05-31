<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once('../includes/db_functions.php');
$evidenceaction = new EvidenceAction();

$tabActive = 'tab1';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link href="../css/tabs_css.css" rel="stylesheet" type="text/css"/>
    <?php require_once ("includes/meta-link-script.php"); ?>
    <script src="../js/tabs.js"></script>
  </head>

  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?>
      </div>
    </div> 
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-IssueTracker.php"); ?>
      </div>
      <div class="contentBody" >

        <div class="tabbable" >

          <br/><br/>
          <!--filter box-->
          <form action="#">
            <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
            <b style="margin-left:20%;width: 100px; font-size:1.5em;">Raised Issues </b>
          </form>
          <br/><br/>

          <table style="width:100%; overflow-x: visible; overflow-y: scroll; float: left;" width="100%" border="1" frame="box" align="center" cellspacing="1" class="table-hover">
            <thead>
              <tr style="border: 1px solid #B4B5B0;">
                <th align="Left" width="2%">ID</th>
                <th align="Left" width="4%">When Sent</th>
                <th align="Left" width="12%">County</th>
                <th align="Left" width="12%">District</th>
                <th align="Left" width="12%">IssueType</th>
                <th align="Left" width="12%">Subject</th>
                <th align="Left" width="12%">Description</th>
                <th align="Left" width="12%">Raised By</th>
                <th align="Left" width="12%">Handled By</th>
                <th align="Left" width="10%">Status</th>
<!--                    <th align="center" width="10%">View</th>
                <th align="center" width="10%">Del</th>-->
              </tr>
            </thead>
            <tbody>

              <?php
              $sql = "SELECT * FROM issues WHERE status='Raised' ORDER BY id DESC";

              $result_set = mysql_query($sql);

              while ($row = mysql_fetch_array($result_set)) {
                $id = $row["id"];
                $timestamp = $row["timestamp"];
                $county = $row["county"];
                $district = $row["district"];
                $issue_category = $row["issue_category"];
                $subject = $row["subject"];
                $description = $row["description"];
                $raisedby = $row["raisedby"];
                $handledby = $row["handledby"];
                $status = $row["status"];
                ?>
                <tr>
                  <td align="left" > <?php echo $id; ?>  </td>
                  <td align="left" > <?php echo $timestamp; ?> </td>
                  <td align="left" > <?php echo $county; ?> </td>
                  <td align="left" > <?php echo $district; ?> </td>
                  <td align="left" > <?php echo $issue_category; ?> </td>
                  <td align="left" > <?php echo $subject; ?> </td>
                  <td align="left" > <?php echo $description; ?>  </td>
                  <td align="left" > <?php echo $raisedby; ?>  </td>
                  <td align="left" > <?php echo $handledby; ?>  </td>
                  <td align="center"> <?php echo $status; ?> </td>
                  <td align="center"><a href="?id=<?php echo $id; ?>#openModal" >Send SMS</a></td>
                  <td align="center"><a href="?id=<?php echo $id; ?>#openModal2" >Send Email</a></td>
                  <!--
                  <td align="center" ><a href="javascript:void(0)" onclick="loadRecordN('load',<?php //echo $deliveryNoteId;                                  ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                  <td align="center" ><a href="javascript:void(0)" onclick='show_confirm(<?php echo $deliveryNoteId; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                  !-->
                  <!--<td align="center" ><a href="javascript:void(0)" onclick='show_confirm(<?php echo $deliveryNoteId; ?>)'><img src="../images/icons/delete.png" height="20px"/></a></td>-->
                </tr>
              </tbody>
            <?php } ?>
          </table>

        </div>
      </div>
    </div>

  </body>
</html>

<div class="clearFix"></div>
<!---------------- Footer ------------------------>
<!--<div class="footer">  </div>-->


<div id="openModal" class="modalDialog">
  <div style="width:1200px;">
    <?php
    $tabActive = "tab2";
    $id = $_GET['id'];
    ?>

    <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-3%;" >X</a>


    <?php
    if (isset($_POST['submitSendSMS'])) {
      echo $id = $_POST['id'];

      //Post Values to DB
      $sender = $_POST['sender'];
      $recipient_name = $_POST['recipient_name'];
      $recipient_number = $_POST['recipient_number'];
      $subject = $_POST['subject'];
      $sms_body = $_POST['sms_body'];

      //Clean Data
      $sender = addslashes(trim($sender));
      $recipient_name = addslashes(trim($recipient_name));
      $recipient_number = addslashes(trim($recipient_number));
      $subject = addslashes(trim($subject));
      $sms_body = addslashes(trim($sms_body));

      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];

      require_once 'sms.php';

      $sms = new sms();
      sendSMS($recipient_number, $sms_body);


      //insert data
      $query = ("INSERT INTO comm_sms (sender,recipient_name, recipient_number, subject, sms_body) VALUES ('$sender','$recipient_name','$recipient_number','$subject','$sms_body')" );
      mysql_query($query) or die(mysql_error("Could not enter"));
      $messageToUser = "SMS Sent Successfully!";
      $action = "Added A CountY";
      $description = "County Name: " . $county . " Added";

      //Log Entry Data
      //$arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      //funclogAdminData($arrLogAdminData);
      //update actionsTaken
      $query = ( "UPDATE issues SET actionstaken ='2', status='Ongoing'  WHERE id='$id' " );
      mysql_query($query) or die(mysql_error("Could not enter"));
    }
    ?>


    <h2 style="text-align: center">Send SMS</h2>
    <?php include("../includes/messageBox.php"); ?>
    <form method="POST">
      <table border="0" cellpadding="0" cellspacing="0" width="60%"  >
        <thead><input type="hidden" value="<?php echo $id; ?>"/>
          <tr>
            <td align="right">Sender : </td><td><input type="text" name="sender" class="input_textbox_p " value="<?php echo $_SESSION['staff_name']; ?>" readonly required/></td>
          </tr>
          <tr>
            <td align="right">Recipient Name : </td><td><input type="text" name="recipient_name" id="recipient_name"  class="input_textbox_p "  required /></td>
          </tr>
          <tr>
            <td align="right">Recipient Number : </td><td><input type="text" name="recipient_number" id="recipient_number"  class="input_textbox_p " value="254" onkeyup="isNumeric(this.id);" required/><span id="recipient_numberSpan"/></td>
          </tr>
          <tr>
            <td align="right">Current Date</td><td><input type="text"  class="input_textbox_p " value="<?php echo date('Y-m-d'); ?>" readonly/></td>
          </tr>
          <tr>
            <td align="right">Subject : </td><td><input type="text" name="subject" id="subject"  class="input_textbox_p " /><span id="subjectSpan"/></td>
          </tr>
          <tr>
            <td align="right">Select SMS template:</td>
            <td>
              <select name="sms_template"  class="input_select_p ">
                <option value=''<?php if ($district == '') echo 'selected'; ?> >>None: User will write<</option>
                <?php
                $sql = "SELECT * FROM comm_sms_template  ORDER BY title ASC";
                $result = mysql_query($sql);
                while ($rows = mysql_fetch_array($result)) { //loop table rows
                  ?>
                  <option value="<?php echo $rows['title']; ?>"<?php
                  if ($sms_template_title == $rows['title']) {
                    echo 'selected';
                  }
                  ?>><?php echo $rows['title']; ?></option>
                        <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td align="right">SMS body</td>
            <td><textarea name="sms_body" class="input_textbox_p " rows="2" cols="3"  required>This is to remind you that we will have a teacher training session on Saturday 13th June starting from 10am.</textarea></td>
          </tr>
          <tr>
            <td></td>
            <td align="right"><input type="submit" name="submitSendSMS" value="Send SMS" class="btn-custom-small"/></td>
          </tr>
        </thead>
      </table>
      <div class="vclear"></div>
      <br/>
    </form>
    <p></p>

  </div>
</div>


<!--send email-->
<div id="openModal2" class="modalDialog">
  <div style="width:1200px;">
    <?php
    $tabActive = "tab2";
    $id = $_GET['id'];
    ?>

    <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-3%;" >X</a>


    <?php
    if (isset($_POST['submitSendEmail'])) {
      //Post Values to DB
      $sender = $_POST['sender'];
      $recipient_name = $_POST['recipient_name'];
      $recipient_email = $_POST['recipient_email'];
      $subject = $_POST['subject'];
      $email_body = $_POST['email_body'];

      //Clean Data
      $sender = addslashes(trim($sender));
      $recipient_name = addslashes(trim($recipient_name));
      $recipient_email = addslashes(trim($recipient_email));
      $subject = addslashes(trim($subject));
      $email_body = addslashes(trim($email_body));

      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];

      require '../email/class.phpmailer.php';
      //send Email to client ============================================
      try {
        $mail = new PHPMailer(true); //New instance, with exceptions enabled
        $mail->IsSendmail();  // tell the class to use Sendmail
        $mail->AddReplyTo($staff_email, $staff_name);
        $mail->From = "mail@evidenceaction.com"; //$staff_email;   //$sess_email;
        $mail->FromName = $staff_name; //"Evidence Action";
        $to = $recipient_email;
        $mail->AddAddress($to);
        $mail->Subject = $subject; //"Scheduled Pre-Survey";
        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        $mail->WordWrap = 80; // set word wrap
        $mail->IsHTML(true);
        $mail->Body = $email_body;
        $mail->AddAttachment('../images/logo.jpg');
        $mail->Send();
      } catch (phpmailerException $e) {
        echo $e->errorMessage();
      }
      // end of send email ============================
      //insert data
      $query = ("INSERT INTO comm_emails (sender,recipient_name, recipient_email, subject, email_body) VALUES ('$sender','$recipient_name','$recipient_email','$subject','$email_body')" );
      mysql_query($query) or die(mysql_error("Could not enter"));
      $messageToUser = "Email Sent Successfully!";
      $action = "Added A CountY";
      $description = "County Name: " . $county . " Added";

      //Log Entry Data
      //$arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      //funclogAdminData($arrLogAdminData);
    }
    ?>

    <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
      <h2 style="text-align: center">Send Email</h2>
      <?php include("../includes/messageBox.php"); ?>
      <form method="POST">
        <table border="0" cellpadding="0" cellspacing="0" width="80%"  >
          <thead>
            <tr>
              <td align="right">Sender : </td><td><input type="text" name="sender" class="input_textbox_p compact" value="<?php echo $_SESSION['staff_name']; ?>" readonly required/></td>
            </tr>
            <tr>
              <td align="right">Recipient Name : </td><td><input type="text" name="recipient_name" id="recipient_name"  class="input_textbox_p compact" required /></td>
            </tr>
            <tr>
              <td align="right">Recipient Email address : </td><td><input type="text" name="recipient_email" id="recipient_email"  class="input_textbox_p compact"  onkeyup="isEmail(this.id);" required/><span id="recipient_emailSpan"/></td>
            </tr>
            <tr>
              <td align="right">Current Date</td><td><input type="text"  class="input_textbox_p compact" value="<?php echo date('Y-m-d'); ?>" readonly/></td>
            </tr>
            <tr>
              <td align="right">Subject : </td><td><input type="text" name="subject" id="subject"  class="input_textbox_p compact" /><span id="subjectSpan"/></td>
            </tr>
            <tr>
              <td align="right">Select Email template:</td>
              <td>
                <select name="sms_template"  class="input_select_p ">
                  <option value=''<?php if ($district == '') echo 'selected'; ?> >>None: User will write<</option>
                  <?php
                  $sql = "SELECT * FROM comm_sms_template  ORDER BY title ASC";
                  $result = mysql_query($sql);
                  while ($rows = mysql_fetch_array($result)) { //loop table rows
                    ?>
                    <option value="<?php echo $rows['title']; ?>"<?php
                    if ($sms_template_title == $rows['title']) {
                      echo 'selected';
                    }
                    ?>><?php echo $rows['title']; ?></option>
                          <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td align="right">Email body</td>
              <td><textarea name="email_body" class="input_textbox_p compact" rows="7" cols="15" required>This is to remind you that we will have a teacher training session on Saturday 13th June starting from 10am.</textarea></td>
            </tr>
            <tr>
              <td></td>
              <td align="right"><input type="submit" name="submitSendEmail" value="Send Email" class="btn-custom-small"/></td>
            </tr>
          </thead>
        </table>
        <div class="vclear"></div>
        <br/>
      </form>
      <p></p>
    </div>


  </div>
</div>



<script>
    $(function() {
      $(".datepicker").datepicker();
    });

    function show_confirm(deleteid) {
      if (confirm("Are you sure you want to delete?")) {
        location.replace('?deleteId=' + deleteid);
      } else {
        return false;
      }
    }
</script>



<!--filter includes-->
<script type="text/javascript" src="../css/filter-as-you-type/jquery.min.js"></script>
<script type="text/javascript" src="../css/filter-as-you-type/jquery.quicksearch.js"></script>
<script type="text/javascript">
  $(function() {
    $('input#id_search').quicksearch('table tbody tr');
  });
</script>

<script>
  // ADD ====================================================================
  //GET district
  function get_district(txt) {
    $.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
      $('#selectdistrict').html(data);//alert(data);
    });
  }
  //GET divisions
  function get_division(txt) {
    $.post('ajax_dropdown.php', {checkval: 'division', district: txt}).done(function(data) {
      $('#selectdivision').html(data);//alert(data);
    });
  }
  //GET Schools
  function get_school(txt) {
    $.post('ajax_dropdown.php', {checkval: 'school', division: txt}).done(function(data) {
      $('#selectschool').html(data);//alert(data);
    });
  }
</script>