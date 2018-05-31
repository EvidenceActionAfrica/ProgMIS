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
    <?php
    if (isset($_POST['submitSendSMS'])) {
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
            <li class="active"><a href="#tab1" data-toggle="tab">Send SMS</a></li>
            <li><a href="#tab2" data-toggle="tab">View Sent SMSs</a></li>
           
          </ul>
          <div class="tab-content">
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
               <h2 style="text-align: center">Send SMS</h2>
              <?php include("../includes/messageBox.php"); ?>
               <a href="#openModalContactSelect" >Select contacts</a>
               
              <form method="POST">
                <table border="0" cellpadding="0" cellspacing="0" width="60%"  >
                  <thead>
                    <tr>
                      <td align="right">Sender : </td><td><input type="text" name="sender" class="input_textbox_p " value="<?php echo $_SESSION['staff_name']; ?>" readonly required/></td>
                    </tr>
                    <tr>
                      <td align="right">Recipient Name : </td><td><input type="text" name="recipient_name" id="recipient_name"  class="input_textbox_p "  required /></td>
                    </tr>
                    <tr>
                      <td align="right">Recipient Number : </td>
                      <td><input type="text" name="recipient_number" id="recipient_number"  class="input_textbox_p " value="254" onkeyup="isNumeric(this.id);" required/><span id="recipient_numberSpan"/>
                       
                        <select name="handledby"  class="input_select_p ">
                          <option value=''<?php if ($handledby == '') echo 'selected'; ?> ></option>
                          <?php
                          $sql = "SELECT * FROM health_contacts  ORDER BY dmoh_name ASC";
                          $result = mysql_query($sql);
                          while ($rows = mysql_fetch_array($result)) { //loop table rows
                            ?>
                            <option value="<?php echo $rows['dmoh_phone']; ?>"<?php
                            if ($handledby == $rows['dmoh_name']) {
                              echo 'selected';
                            }
                            ?>><?php echo $rows['dmoh_name'].'  -  '.$rows['dmoh_phone']; ?> </option>
                                  <?php } ?>
                        </select>
                      </td>
                       
                      
                      <div style="float: right; width:300px; height:400px;overflow-y:scroll">
                        <b>List of MoH Contacts</b><br/>
                        <?php
                          $sql = "SELECT * FROM health_contacts  ORDER BY dmoh_name ASC";
                          $result = mysql_query($sql);
                          while ($rows = mysql_fetch_array($result)) { //loop table rows
                            ?>
                            <input type="checkbox" name="vehicle" value="Bike">
                              <?php echo $rows['county']; ?> - <?php echo $rows['district']; ?> 
                               <?php // echo $rows['dmoh_name']; ?> 
                               <?php // echo $rows['dmoh_phone']; ?>
                               <br/>
                         <?php } ?>
                      </div>
                      
                      
                      
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
            <!--tab 2 - view delivery note-->
            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
              <br/><br/>
              <!--filter box-->
              <form action="#">
                <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
                <b style="margin-left:20%;width: 100px; font-size:1.5em;">Previously Sent SMSs</b>
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
                    <th align="center" width="40%">SMS Body</th>
<!--                    <th align="center" width="10%">View</th>
                    <th align="center" width="10%">Del</th>-->
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $sql = "SELECT * FROM comm_sms ORDER BY id DESC";

                  $result_set = mysql_query($sql);

                  while ($row = mysql_fetch_array($result_set)) {
                    $id = $row["id"];
                    $timestamp = $row["timestamp"];
                    $sender = $row["sender"];
                    $recipient_name = $row["recipient_name"];
                    $recipient_number = $row["recipient_number"];
                    $subject = $row["subject"];
                    $sms_body = $row["sms_body"];
                    ?>
                    <tr>
                      <td align="left" > <?php echo $id; ?>  </td>
                      <td align="left" > <?php echo $timestamp; ?> </td>
                      <td align="left" > <?php echo $sender; ?> </td>
                      <td align="left" > <?php echo $recipient_name; ?> </td>
                      <td align="left" > <?php echo $recipient_number; ?> </td>
                      <td align="left" > <?php echo $subject; ?> </td>
                      <td align="left" > <?php echo $sms_body; ?>  </td>
                      <!--<td align="center" ><a href="sms.php?id=<?php echo $id; ?>#openModal " ><img src="../images/icons/view2.png" height="20px"/></a></td>-->
                      <!--
                      <td align="center" ><a href="javascript:void(0)" onclick="loadRecordN('load',<?php //echo $deliveryNoteId;                    ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td>
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

<!--Start -->
<div id="openModalContactSelect" class="modalDialog">
  <div style="width:800px;">
    <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-3%;" >X</a>
    <?php
    $tabActive = "tab2";
    
      if (isset($_POST['search_table'])) {
        $county = $_POST['county'];
        $district_name = $_POST['district_name'];
        $dmoh_name = $_POST['dmoh_name'];
        $dmoh_phone = $_POST['dmoh_phone'];
        $dmoh_email = $_POST['dmoh_email'];
        $searchQuery = "SELECT * FROM health_contacts WHERE county LIKE '%$county%'
            AND district LIKE '%$district_name%'
            AND dmoh_name LIKE '%$dmoh_name%'
            AND dmoh_phone LIKE '%$dmoh_phone%'
            AND dmoh_email LIKE '%$dmoh_email%' order by county,district asc ";
        $result_set = mysql_query($searchQuery);
      } else {
        $result_set = mysql_query("SELECT * FROM health_contacts order by county,district  asc");
      }
    ?>
     <form action="#">
        <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
        <!--<img src="../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>-->
        <b style="margin-left:20%;width: 100px; font-size:1.5em;">Health Contacts</b>
      </form>
     <br/>
        <div style=" margin-right: 20px">
          <form method="post">
            <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
              <thead>
                <tr style="border: 1px solid #B4B5B0;">
                  <th align="center" width="1%"></td>
                  <th align="center" width="10%">
                    <select name="county"  style="width: 98%;" onchange="submitForm();">
                      <option value=''<?php if ($county == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT * FROM counties ORDER BY county ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['county']; ?>"<?php if ($county == $rows['county']) { echo 'selected'; }
                        ?>><?php echo $rows['county']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                  <th align="center" width="15%">
                    <select name="district_name"  style="width: 98%;" onchange="submitForm();">
                      <option value=''<?php if ($district_name == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT * FROM districts WHERE county='$county' ORDER BY district_name ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['district_name']; ?>"<?php
                        if ($district_name == $rows['district_name']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['district_name']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                  <th align="center" width="20%"><input type="text" style="width: 98%" name="dmoh_name"  value="<?php echo $dmoh_name ?>"/></th>
                  <th align="center" width="15%"><input type="text" style="width: 98%" name="dmoh_phone"  value="<?php echo $dmoh_phone ?>"/></th>
                  <th align="center" width="30%"><input type="text" style="width: 98%" name="dmoh_email"  value="<?php echo $dmoh_email ?>"/></th>
                  <th align="center" width="15%" colspan="3"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                </tr>
                <tr style="border: 1px solid #B4B5B0;">
                  <th align="Left" width="1%">Chk</th>
                  <th align="Left" width="10%">County</th>
                  <th align="Left" width="15%">District</th>
                  <th align="Left" width="20%">DMOH Name</th>
                  <th align="Left" width="15%">DMOH Mobile</th>
                  <th align="Left" width="30%">DMOH Email</th> 
				</tr>
              </thead>
            </table>
          </form>
        </div>
     
     
     <div style="width:100%; height:470px; overflow-x: visible; overflow-y: scroll; ">
          <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
            <tbody>
              <?php
              while ($row = mysql_fetch_array($result_set)) {
                $id = $row['id'];
                $county = $row['county'];
                $district = $row['district'];
                $dmoh_name = $row['dmoh_name'];
                $dmoh_phone = $row['dmoh_phone'];
                $dmoh_email = $row['dmoh_email'];
                ?>
                <tr style="border-bottom: 1px solid #B4B5B0;">
                  <td align="left" width="1%"><input type="checkbox" name="dmoh_contact"/></td>
                  <td align="left" width="10%"> <?php echo $county; ?>  </td>
                  <td align="left" width="15%"> <?php echo $district; ?> </td>
                  <td align="left" width="20%"> <?php echo $dmoh_name; ?> </td>
                  <td align="left" width="15%"><?php
                    echo substr($dmoh_phone, 0, 12);
                    if (strlen($dmoh_phone) > 12)
                      echo "..";
                    ?>
                  </td>
                  <td align="left" width="30%"><?php
                    echo substr($dmoh_email, 0, 30);
                    if (strlen($dmoh_email) > 30)
                      echo "..";
                    ?>
                  </td> 
                </tr>
              </tbody>
            <?php } ?>
          </table>
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
function submitForm() {
  document.getElementById('imgLoading').style.visibility = "visible";
  var selectButton = document.getElementById('btnSearchSubmit');
  selectButton.click();
}
</script>