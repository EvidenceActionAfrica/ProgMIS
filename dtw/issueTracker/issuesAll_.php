<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once('../includes/db_functions.php');
$evidenceaction = new EvidenceAction();
$level = $_SESSION['level'];

$tabActive = 'tab1';

 if (isset($_POST['submitSaveIssue'])) {
 
 
$tabActive = 'tab2';
    
 }
require_once("includes/loginInfo.php");

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
    if (isset($_POST['submitSaveIssue'])) {
      //Post Values to DB
      $selectcounty = $_POST['selectcounty'];
      $selectdistrict = $_POST['selectdistrict'];
      $selectdivision = $_POST['selectdivision'];
      $issue_category = $_POST['issue_category'];
      $subject = $_POST['subject'];
      $description = $_POST['description'];
      $raisedby = $_POST['raisedby'];
      $handledby = $_POST['handledby'];
      $status = $_POST['status'];

      //Clean Data
      $county = addslashes(trim($selectcounty));
      $district = addslashes(trim($selectdistrict));
      $division = addslashes(trim($selectdivision));

      $issue_category = addslashes(trim($issue_category));
      $subject = addslashes(trim($subject));
      $description = addslashes(trim($description));
      $raisedby = addslashes(trim($raisedby));
      $handledby = addslashes(trim($handledby));
      $status = addslashes(trim($status));

      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];

      //insert data
      $query = ("INSERT INTO issues (county,district,division,issue_category,subject,description,raisedby,handledby,status)
              VALUES ('$county','$district','$division','$issue_category','$subject','$description','$raisedby','$handledby','$status')" );
      mysql_query($query) or die(mysql_error("Could not enter"));
      $messageToUser = "Issue Saved Successfully!";
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
     
      <div class="contentBody" >
          
        <div class="tabbable" style="margin-left:5%;" >
          <ul class="nav nav-tabs">
            <li <?php if($tabActive=="tab1"){echo "class='active'";} ?>><a href="#tab1" data-toggle="tab">View Issues</a></li>
        
              <li <?php if($tabActive=="tab2"){echo "class='active'";} ?>><a href="#tab2" data-toggle="tab">Raise New Issue</a></li>
          </ul>
          <div class="tab-content" style="width:110%;">
            
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                <?php
                require_once("issuesView.php");
                ?>
            </div>

              <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
              <h2 style="text-align: center">Raise New Issue</h2>
              <?php include("../includes/messageBox.php"); ?>
              <form method="POST">
                <table border="0" cellpadding="0" cellspacing="0" width="100%"  >
                  <thead>
                    <tr>
                      <td align="right">County </td>
                      <td>
                        <?php
                        $tablename = 'counties';
                        $fields = 'id, county';
                        $where = '1=1 order by county asc';
                        $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                        ?>
                        <select onchange="get_district(this.value);" id="selectcounty" name="selectcounty" class="input_select" required >
                          <option value="">Choose County</option>
                          <?php foreach ($insertformdata as $insertformdatacab) { ?>
                            <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                      <td align="right">Raised By : </td><td><input type="text" name="raisedby" class="input_textbox_p compact" value="<?php echo $_SESSION['staff_name']; ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td align="right">District </td>
                      <td>
                        <select onchange="get_division(this.value);" id="selectdistrict" name="selectdistrict" class="input_select" >
                          <option value="">Choose District</option>
                        </select>
                      </td>
                      <td align="right">Current Date : </td><td><input type="text"  class="input_textbox_p compact" value="<?php echo date('Y-m-d'); ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td align="right">Division </td>
                      <td>
                        <select onchange="get_school(this.value);" id="selectdivision" name="selectdivision" class="input_select" >
                          <option value="">Choose Division</option>
                        </select>
                      </td>
                      <td align="right">Status : </td><td><input type="text"  class="input_textbox_p compact" value="Raised" readonly/></td>
                    </tr>
                     <td align="right">To be handled by:</td>
                      <td>
                        <select name="handledby"  class="input_select_p ">
                          <option value=''<?php if ($handledby == '') echo 'selected'; ?> ></option>
                          <?php
                          $sql = "SELECT * FROM staff  ORDER BY staff_name ASC";
                          $result = mysql_query($sql);
                          while ($rows = mysql_fetch_array($result)) { //loop table rows
                            ?>
                            <option value="<?php echo $rows['staff_name']; ?>"<?php
                            if ($handledby == $rows['staff_name']) {
                              echo 'selected';
                            }
                            ?>><?php echo $rows['staff_name']; ?></option>
                                  <?php } ?>
                        </select>
                      </td>
                    <tr height="30px">
                    </tr>
                    <tr>
                        <td align="right">Issue Category :</td>
                      <td>
                        <select name="issue_category"  class="input_select_p ">
                          <option value=''<?php if ($issue_category == '') echo 'selected'; ?> ></option>
                          <?php
                          $sql = "SELECT * FROM issues_categories  ORDER BY category_name ASC";
                          $result = mysql_query($sql);
                          while ($rows = mysql_fetch_array($result)) { //loop table rows
                            ?>
                            <option value="<?php echo $rows['category_name']; ?>"<?php
                            if ($issue_category == $rows['category_name']) {
                              echo 'selected';
                            }
                            ?>><?php echo $rows['category_name']; ?></option>
                                  <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td align="right">Subject: </td><td colspan="2"><input type="text" name="subject" id="subject"  class="input_textbox_p " required /></td>
                    </tr>
                    <tr>
                      <td align="right">Description</td>
                      <td colspan="2"><textarea name="description" class="input_textbox_p " rows="3" cols="15" required>Description of the issue.</textarea></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td align="right"><input type="submit" name="submitSaveIssue" value="Save Issue" class="btn-custom-small"/></td>
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






      </div>
    </div>

  </body>
</html>

<div class="clearFix"></div>
<!---------------- Footer ------------------------>
<!--<div class="footer">  </div>-->


<div id="openModal" class="modalDialog">
  <div style="width:700px;">
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
      $sms->sendSMS($recipient_number, $sms_body);


      //insert data
      $query = ("INSERT INTO comm_sms (sender,recipient_name, recipient_number, subject, sms_body) VALUES ('$sender','$recipient_name','$recipient_number','$subject','$sms_body')" );
      mysql_query($query) or die(mysql_error("Could not enter"));
      $messageToUser = "SMS Sent Successfully!";
    

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


<!--- MODALS-->


<!--Add Action-->
<div id="openModalAddAction" class="modalDialog">
  <div style="width:700px;">
    <?php
    $idIssue = $_GET['id'];
    ?>

    <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-3%;" >X</a>

    <h2 style="text-align: center">Add Action</h2>
    <form method="POST">
      <table border="0" cellpadding="0" cellspacing="0" width="95%"  >
        <thead>
          <tr>
            <td align="right">Raised By : </td><td><input type="text" name="raisedby" class="input_textbox_p compact" value="<?php echo $_SESSION['staff_name']; ?>" readonly/></td>
            <td align="right">Current Date : </td><td><input type="text"  class="input_textbox_p compact" value="<?php echo date('Y-m-d'); ?>" readonly/></td>
          </tr> 
          <tr> 
            <td align="right">Handled by:</td>
            <td>
              <select name="handledby"  class="input_select_p ">
                <option value=''<?php if ($handledby == '') echo 'selected'; ?> ></option>
                <?php
                $sql = "SELECT * FROM staff  ORDER BY staff_name ASC";
                $result = mysql_query($sql);
                while ($rows = mysql_fetch_array($result)) { //loop table rows
                  ?>
                  <option value="<?php echo $rows['staff_name']; ?>"<?php
                  if ($handledby == $rows['staff_name']) {
                    echo 'selected';
                  }
                  ?>><?php echo $rows['staff_name']; ?></option>
                        <?php } ?>
              </select>
            </td>
            <td align="right">Action taken :</td>
            <td>
              <select name="actiontaken"  class="input_select_p ">
                <option value='SMS sent'>SMS sent</option>
                <option value='Call Made'>Call Made</option>
                <option value='Email sent'>Email sent</option>
              </select>
            </td>
          </tr> 
          <tr>
            <td align="right" >Response <br/>(e.g. from DEO,DMoH)</td>
            <td  colspan="3"><textarea name="response" class="input_textbox_p " rows="3" cols="15" required>Description of action from respondent</textarea></td>
          </tr>
            <tr>
                <td>Status</td><td>
                    
              <select name="status"  class="input_select_p ">
                <option value='Ongoing'>Ongoing</option>
                <option value='Unresolved'>Unresolved</option>
                <option value='Resolved'>Resolved</option>
              </select>
                    
                </td>
            </tr>
            <tr></tr>
          <tr>
            <td></td>
            <td align="right"><input type="submit" name="submitSaveAction" value="Save Action" class="btn-custom-small"/></td>
          </tr>
        </thead>
      </table>
      <div class="vclear"></div>
      <br/>
    </form>

    <div class="vclear"></div>




  </div>
</div>
<!--end view actions modal-->


<!-- -->

<!--View Actions-->
<div id="openModalActions" class="modalDialog">
  <div style="width:800px;">
    <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-3%;" >X</a>
    <?php
     $issueId = $_POST['id'];
    ?>




    <!--filter box-->
    <form action="#">
      <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
      <b style="margin-left:20%;width: 100px; font-size:1.5em;">Actions taken </b>
    </form>
    <br/><br/>
    <?php
        $sql = "SELECT * FROM issues_actions WHERE issueid='$issueId' ORDER BY id DESC";
        mysql_query($sql);
        $numRows=  mysql_affected_rows();
        if($numRows>=1){
     ?>
    <table style="width:95%; overflow-x: visible; overflow-y: scroll; float: left;" width="100%" border="1" frame="box" align="center" cellspacing="1" class="table-hover">
      <thead>
        <tr style="border: 1px solid #B4B5B0;">
          <th align="Left" width="2%">ID</th>
          <th align="Left" width="2%">Timestamp</th>
          <th align="Left" width="2%">IssueID</th>
          <th align="Left" width="4%">Action<br/>Taken</th>
          <th align="Left" width="12%">Staff</th>
          <th align="Left" width="12%">Timeframe</th>
          <th align="Left" width="12%">Response</th> 
        </tr>
      </thead>
      <tbody>

        <?php
              $sql = "SELECT * FROM issues_actions WHERE issueid='$issueId' ORDER BY id DESC";

              $result_set = mysql_query($sql);

              while ($row = mysql_fetch_array($result_set)) {
                $id = $row["id"];
                $timestamp = $row["timestamp"];
                $issueid = $row["issueid"];
                $actiontaken = $row["actiontaken"];
                $staff = $row["staff"];
                $timeframe = $row["timeframe"];
                $response = $row["response"];
        ?>
                <tr>
                  <td align="left" > <?php echo $id; ?>  </td>
                  <td align="left" > <?php echo $timestamp; ?> </td>
                  <td align="left" > <?php echo $issueid; ?> </td>
                  <td align="left" > <?php echo $actiontaken; ?> </td>
                  <td align="left" > <?php echo $staff; ?> </td>
                  <td align="left" > <?php echo $timeframe; ?> </td>
                  <td align="left" > <?php echo $response; ?>  </td>
                </tr>
              </tbody>
        <?php } ?>
    </table>
    <?php
        }else{
            $messageToUser="No Action Has Been Taken So Far.";
               include("../includes/messageBox.php");
        }
    ?>
    
    <div class="vclear"></div>




  </div>
</div>
<!--end view actions modal-->







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