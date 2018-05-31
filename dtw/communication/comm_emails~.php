<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
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

      $d = 'upload/';
      $de = $d . basename($_FILES['file']['name']);
      move_uploaded_file($_FILES["file"]["tmp_name"], $de);
      $fileName = $_FILES['file']['name'];
      $filePath = $_FILES['file']['tmp_name'];
      //add only if the file is an upload



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

        //$mail->AddAttachment($file);
        //$mail->AddAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);

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

    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-Communication.php"); ?>
      </div>
      <div class="contentBody" >

        <div class="tabbable" >
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Send Email</a></li>
            <li><a href="#tab2" data-toggle="tab">View Sent Emails</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
              <h2 style="text-align: center">Send Email</h2>
              <?php include("../includes/messageBox.php"); ?>
              <form name="sendemailcomm" method="post" enctype="multipart/form-data" onSubmit='Test();
                  return false'>
                <!--<form method="POST">-->
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






                    <tr>
                      <td id="ta">
                        <label for="file">Or upload a file (only word, excel or pdf)</label>
                      </td>
                      <td  id="ta">
                        <input type="file" name="file">
                      </td>
                    </tr>





                  </thead>
                </table>
                <div class="vclear"></div>
                <br/>
              </form>
              <p></p>
            </div>
            <!--tab 2 - view delivery note-->
            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
              <br/><br/>
              <!--filter box-->
              <form action="#">
                <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
                <b style="margin-left:20%;width: 100px; font-size:1.5em;">Previously Sent Emails</b>
              </form>
              <br/><br/>

              <table style="width:100%; overflow-x: visible; overflow-y: scroll; float: left;" width="100%" border="1" frame="box" align="center" cellspacing="1" class="table-hover">
                <thead>
                  <tr style="border: 1px solid #B4B5B0;">
                    <th align="Left" width="2%">ID</th>
                    <th align="Left" width="12%">When Sent</th>
                    <th align="Left" width="12%">Sender</th>
                    <th align="Left" width="12%">Recipient<br/>Name</th>
                    <th align="Left" width="10%">Recipient<br/>Number</th>
                    <th align="Left" width="10%">Subject</th>
                    <th align="center" width="40%">Email Body</th>
<!--                    <th align="center" width="10%">View</th>
                    <th align="center" width="10%">Del</th>-->
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $sql = "SELECT * FROM comm_emails ORDER BY id DESC";

                  $result_set = mysql_query($sql);

                  while ($row = mysql_fetch_array($result_set)) {
                    $id = $row["id"];
                    $timestamp = $row["timestamp"];
                    $sender = $row["sender"];
                    $recipient_name = $row["recipient_name"];
                    $recipient_email = $row["recipient_email"];
                    $subject = $row["subject"];
                    $email_body = $row["email_body"];
                    ?>
                    <tr>
                      <td align="left" > <?php echo $id; ?>  </td>
                      <td align="left" > <?php echo $timestamp; ?> </td>
                      <td align="left" > <?php echo $sender; ?> </td>
                      <td align="left" > <?php echo $recipient_name; ?> </td>
                      <td align="left" > <?php echo $recipient_email; ?> </td>
                      <td align="left" > <?php echo $subject; ?> </td>
                      <td align="left" > <?php echo $email_body; ?>  </td>
                      <!--<td align="center" ><a href="sms.php?id=<?php echo $id; ?>#openModal " ><img src="../images/icons/view2.png" height="20px"/></a></td>-->
                      <!--
                      <td align="center" ><a href="javascript:void(0)" onclick="loadRecordN('load',<?php //echo $deliveryNoteId;                         ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td>
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
    ?>

    <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-3%;" >X</a>
    <table style="padding-left: 5px;width: 100%;">

      <!--<b style="text-align: center; margin-top: 0px; font-size: 15px">Delivery Note</b>-->
      <!--<h1 class="form-title">Delivery Note</h1>-->
      <!-- table begin  =============-->
      <tr>
        <td style="width: 90%; margin: 0 auto">

          <form method="post">
            <table border="0"  cellpadding="0" cellspacing="0">
              <thead>
                <h2>Edit Delivery Note</h2><br/>

                </tr>
                <tr>
                  <td align="right">Customer Name & Address</td>
                  <td align="right"><textarea name="customerNameAddress" class="input_textbox_p compact" rows="2" col="2" ><?php echo $customerNameAddress; ?></textarea></td>

                  <td align="right">Receiving Officer</td><td><input type="text" name="receivingOfficer" class="input_textbox_p compact" value="<?php echo $receivingOfficer; ?>"/></td>

                  <td align="right">Delivering Vehicle</td><td><input type="text" name="deliveryVehicle" class="input_textbox_p compact" value="<?php echo $deliveryVehicle; ?>"/></td>
                  <td align="right"> <b>Special Notes </b>
                    <textarea id="notes" name="specialNotes"><?php echo $specialNotes; ?></textarea>
                  </td>
                </tr>
                <tr>
                  <td align="right">Customer Remarks</td>
                  <td align="right"><textarea name="customerRemarks" class="input_textbox_p compact" rows="2" col="2" style="max-width:250px;"><?php echo $customerRemarks; ?></textarea></td>

                  <td align="right">Delivery Note No.</td><td><input type="text" disabled name="deliveryNoteId" class="input_textbox_p compact" value="<?php echo $deliveryNoteId; ?>"/></td>

                  <td align="right">Warehouse</td><td><input type="text" name="warehouse"  class="input_textbox_p compact" value="<?php echo $warehouse; ?>"/></td>
                  <td align="right">
                    <input type="submit" style="align:center" class="btn btn-success"  name="updateRecord" value="Update Form" /></td>
                </tr>
                <tr><input type="hidden" name="id" value="<?php echo $id; ?>"/>
                  <td align="right">County</td>
                  <td>
                    <select name="county"  class="input_select_p compact">
                      <option value=''<?php if ($county == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT * FROM counties ORDER BY county ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['county']; ?>"<?php
                        if ($county == $rows['county']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['county']; ?></option>
                              <?php } ?>
                    </select>
                  </td>

                  <td align="right">District</td>
                  <td>
                    <select name="district"  class="input_select_p compact">
                      <option value=''<?php if ($district == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT * FROM districts  ORDER BY district_name ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['district_name']; ?>"<?php
                        if ($district == $rows['district_name']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['district_name']; ?></option>
                              <?php } ?>
                    </select>
                  </td>

                  <td align="right">Date issued</td><td><input type="text"  disabled id="datepicker" name="dateSaved" class="input_textbox_p compact" value="<?php echo date('Y-m-d'); ?>"/></td>

                </tr>
              </thead>
            </table >
            <!--Right div-->

            <table style="float: right; width: 49%; margin-top:-180px; margin-left:500px;" border="0" cellpadding="0" cellspacing="0">
              <thead>

              </thead>
            </table >
            <div class="vclear"></div>
            </select>Rows <input style="display:none" type="submit" name="addModalRow" id="addModalRow" value="ADD Row" /><br/>
          </form>
        </td>

      </tr>
    </table>
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
<script type="text/javascript">
  document.onkeypress = function(e)  {
    e = e || window.event;
    if (typeof e != 'undefined') {
      var tgt = e.target || e.srcElement;
      if (typeof tgt != 'undefined' && /input/i.test(tgt.nodeName))
        return (typeof e.keyCode != 'undefined') ? e.keyCode != 13 : true;
    }
  }
</script>