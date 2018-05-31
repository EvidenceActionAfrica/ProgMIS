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
            $subject = $_POST['subject'];
            $recipient_email = $_POST['recipient_email'];
            $email_body = $_POST['email_body'];

            //Clean Data
            $sender = addslashes(trim($sender));
            //$recipient_email = addslashes(trim($recipient_emai));
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
                // $mail->AddAddress($email);
                //$mail->Subject = $subject; //"Scheduled Pre-Survey";
                // $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                // $mail->WordWrap = 80; // set word wrap
                // $mail->IsHTML(true);
                //$mail->Body = $email_body;
                //$mail->AddAttachment($filePath);
                //$mail->AddAttachment($file);
                //$mail->AddAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);
                //$mail->Send();
                //} catch (phpmailerException $e) {
                // echo $e->errorMessage();
                //}
                $to = $recipient_email;
                if (strpos($to, ',') !== false) {
                    $to = explode(',', $to);
                    foreach ($to as $key => $value) {
                        $mail->AddAddress($value);
                    }
                } else {
                    $mail->AddAddress($to);
                }
                $mail->Subject = $subject;
                //$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->IsHTML(true);
                $mail->Body = $email_body;
                // $mail->AddAttachment('../images/logo.jpg');
                $mail->Send();
            } catch (phpmailerException $e) {
                echo $e->errorMessage();
            }
            // end of send email ============================
            //insert data
            $query = ("INSERT INTO comm_emails (sender,recipient_name, recipient_email, subject, email_body) VALUES ('$sender','$recipient_name','$email','$subject','$email_body')" );
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
                                            <td  align="right">Sender : </td><td><input style="width:344px" type="text" name="sender" class="input_textbox_p compact" value="<?php echo $_SESSION['staff_name']; ?>" readonly required/></td>
                                        </tr>  
                                        <tr>
                                            <?php if (!isset($_POST['make_selection'])) {
                                                ?>
                                                <td align="right">Recipient Email address test <br>
                                                        (Please, separate Email addresses <br>with a coma if more than one) : </td>
                                                            <td><textarea style="width:344px" name="recipient_email" id="recipient_email" class="input_textbox_p compact" rows="3" cols="50" required/></textarea></td>
                                                        <?php } ?>
                                                        <tr>
                                                            <td align="right"><a href="#openModalContactSelect" >Or Select Recipient Email</a></td>
                                                            <td class="" style="">
                                                                    <?php
                                                                    if (isset($_POST['make_selection']) && $_POST['check_num'] != 0) {

                                                                        $i = 1;
                                                                        $c = count($_POST['check_num']);
                                                                        $multi_numbers = '';
                                                                        foreach ($_POST['check_num'] as $value) {
                                                                            if ($i == $c) {
                                                                                $multi_numbers .= $value;
                                                                            } else {
                                                                                $multi_numbers .= $value . ',';
                                                                            }
                                                                            $i++;
                                                                        }
//                                                                        
                                                                        echo '<textarea style="width:344px" name="recipient_email" id="recipient_email" class="input_textbox_p compact" rows="3" cols="50" required/>' . $multi_numbers . '</textarea>';
                                                                        echo "</br>";
                                                                        echo "<b> Email Selected = $c </b>";
                                                                    }
                                                                    ?>
                                                            </td>
                                                        </tr>
                                                        </tr>
                                                        <tr>
                                                            <td align="right">Current Date</td><td><input style="width:100px"  type="text"  class="input_textbox_p compact" value="<?php echo date('Y-m-d'); ?>" readonly/></td>
                                                        </tr>                    
                                                        <tr>
                                                            <td align="right">Select Email template:</td>
                                                            <td>


                                                                <select style="width:306px" name="email_template" id="email_template" class="input_select_p " onchange="loadSubject(), loadBody();">
                                                                    <option value=''<?php if ($district == '') echo 'selected'; ?> >>None: User will write<</option>
                                                                    <?php
                                                                    $sql = "SELECT * FROM comm_email_template  ORDER BY title ASC";
                                                                    $result = mysql_query($sql);
                                                                    while ($rows = mysql_fetch_array($result)) { //loop table rows
                                                                        ?>
                                                                        <option value="<?php echo $rows['id']; ?>"<?php
                                                                        if ($edit_template_title == $rows['title']) {
                                                                            echo 'selected';
                                                                        }
                                                                        ?>><?php echo $rows['title']; ?></option>
                                                                            <?php } ?>
                                                                </select>
                                                                <a style=" display:inline;text-decoration: none" target = 'blank' href="edit_emailTemp.php">
                                                                    <img src="../images/icons/mainEdit.png" style="vertical-align: middle" height="30px"/></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right">Subject : </td><td><input style="width:344px" type="text" name="subject" id="subject"  class="input_textbox_p compact" value="<?php echo $subject ?>" required></td>
                                                        </tr>




                                                        <tr>
                                                            <td align="right">Email body</td>
                                                            <td><textarea style="width:344px" name="email_body" id="email_body" class="input_textbox_p compact" rows="5" cols="50" value="<?php echo $subject ?>" required>This is to remind you that we will have a teacher training session on Saturday 13th June starting from 10am.</textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>

                                                            <td ><input type="submit" name="submitSendEmail" value="Send Email" class="btn-custom"/>
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
                                                                        <th align="Left" width="12%">Recipient<br/>Email</th>
                                                                        <!-- <th align="Left" width="10%">Recipient<br/>Number</th> -->
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
                                                                        $recipient_email = $row["recipient_email"];
                                                                        $subject = $row["subject"];
                                                                        $email_body = $row["email_body"];
                                                                        ?>
                                                                        <tr>
                                                                            <td align="left" > <?php echo $id; ?>  </td>
                                                                            <td align="left" > <?php echo $timestamp; ?> </td>
                                                                            <td align="left" > <?php echo $sender; ?> </td>
                                                                            <td align="left" > <?php echo $recipient_email; ?> </td>
                                                                            <td align="left" > <?php echo $subject; ?> </td>
                                                                            <td align="left" > <?php echo $email_body; ?>  </td>
                                                                            <!--<td align="center" ><a href="emails.php?id=<?php echo $id; ?>#openModal " ><img src="../images/icons/view2.png" height="20px"/></a></td>-->
                                                                            <!--
                                                                            <td align="center" ><a href="javascript:void(0)" onclick="loadRecordN('load',<?php //echo $deliveryNoteId;                                          ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td>
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
                                                        <!--==========================Health Contact Modal=====================-->
                                                        <div id="openModalContactSelect" class="modalDialog">
                                                            <div style="width:800px;">
                                                                <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-3%;" >X</a>
                                                                <div class="dashboard_menu" >
                                                                    <a class="btn btn-primary"  href="comm_emails.php#openModalContactSelect" style="text-decoration: none;">Health Contacts</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect1" style="text-decoration: none;">Education Contacts</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect2" style="text-decoration: none;">Master Trainers</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect3" style="text-decoration: none;">County Contacts</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect4" style="text-decoration: none;">Head Teachers</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect5" style="text-decoration: none;">Staff</a>
                                                                </div></br>

                                                                <?php
                                                                if (isset($_POST['search_table'])) {
                                                                    $county = $_POST['county'];
                                                                    $district_name = $_POST['district_name'];
                                                                    $dmoh_name = $_POST['dmoh_name'];
                                                                    $dmoh_phone = $_POST['dmoh_phone'];
                                                                    $dmoh_email = $_POST['dmoh_email'];
                                                                    $searchQuery = "SELECT * FROM health_contacts WHERE dmoh_email != '' AND county LIKE '%$county%'
            AND district LIKE '%$district_name%'
            AND dmoh_name LIKE '%$dmoh_name%'
            AND dmoh_phone LIKE '%$dmoh_phone%'
            AND dmoh_email LIKE '%$dmoh_email%' order by county,district asc ";
                                                                    $result_set = mysql_query($searchQuery);
                                                                } else {
                                                                    $result_set = mysql_query("SELECT * FROM health_contacts WHERE dmoh_email != '' order by county  asc");
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
                                                                            <caption><b>Make your selection by checking respective contacts</b></caption>
                                                                            <thead>
                                                                                <tr style="border: 1px solid #B4B5B0;">
                                                                                    <th align="center" width="3%"></td>
                                                                                        <th align="center" width="13%">
                                                                                            <select name="county"  style="width: 98%;" onchange="submitForm();">
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
                                                                                        </th>
                                                                                        <th align="center" width="16%">
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
                                                                                        <th align="center" width="24%"><input type="text" style="width: 98%" name="dmoh_name"  value="<?php echo $dmoh_name ?>"/></th>
                                                                                        <th align="center" width="14%"><input type="text" style="width: 98%" name="dmoh_phone"  value="<?php echo $dmoh_phone ?>"/></th>
                                                                                        <th align="center" width="19%"><input type="text" style="width: 98%" name="dmoh_email"  value="<?php echo $dmoh_email ?>"/></th>
                                                                                        <th align="center" width="8%"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                                                                                </tr>
                                                                        </table>
                                                                        <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                                                                            <thead>
                                                                                <tr style="border: 1px solid #B4B5B0;">
                                                                                    <th align="Left" width="4%">Chk</th>
                                                                                    <th align="Left" width="12%">County</th>
                                                                                    <th align="Left" width="16%">District</th>
                                                                                    <th align="Left" width="26%">DMOH Name</th>
                                                                                    <th align="Left" width="14%">DMOH Mobile</th>
                                                                                    <th align="Left" width="28%">DMOH Email</th> 
                                                                                </tr>

                                                                            </thead>
                                                                        </table>
                                                                    </form>
                                                                </div>

                                                                <form method="post" action='comm_emails.php#close'>
                                                                    <div style="width:100%; max-height:300px;  overflow-y: scroll; ">
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
                                                                                        <td align="left" width="4%"><input class="first" type="checkbox" name="check_num[]" 
                                                                                                                           value=" <?php echo $dmoh_email; ?>"/></td>
                                                                                        <td align="left" width="12%"> <?php echo $county; ?>  </td>
                                                                                        <td align="left" width="16%"> <?php echo $district; ?> </td>
                                                                                        <td align="left" width="26%"> <?php echo $dmoh_name; ?> </td>
                                                                                        <td align="left" width="14%"><?php
                                                                                            echo substr($dmoh_phone, 0, 12);
                                                                                            if (strlen($dmoh_phone) > 12)
                                                                                                echo "..";
                                                                                            ?>
                                                                                        </td>
                                                                                        <td align="left" width="28%"><?php
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
                                                                    <p align="center">
                                                                        <input id="checkAll" type="button" value="Check/Uncheck All" class="btn-custom-pink">
                                                                            <input type="submit" name="make_selection" id="make_selection" value="Confirm Selection" class="btn-custom-pink"/> 
                                                                    </p>

                                                                </form>

                                                            </div>  

                                                        </div>


                                                        <!--==========================Education Contact Modal=====================-->
                                                        <div id="openModalContactSelect1" class="modalDialog">
                                                            <div style="width:800px;">
                                                                <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-3%;" >X</a>
                                                                <div class="dashboard_menu" >
                                                                    <a class="btn btn-primary"  href="comm_emails.php#openModalContactSelect" style="text-decoration: none;">Health Contacts</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect1" style="text-decoration: none;">Education Contacts</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect2" style="text-decoration: none;">Master Trainers</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect3" style="text-decoration: none;">County Contacts</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect4" style="text-decoration: none;">Head Teachers</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect5" style="text-decoration: none;">Staff</a>
                                                                </div></br>
                                                                <?php
                                                                if (isset($_POST['search_table'])) {
                                                                    $county1 = $_POST['county'];
                                                                    $district_name = $_POST['district_name'];
                                                                    $deo_name = $_POST['deo_name'];
                                                                    $deo_phone = $_POST['deo_phone'];
                                                                    $deo_email = $_POST['deo_email'];
                                                                    $searchQuery = "SELECT * FROM education_contacts WHERE deo_email != '' AND county LIKE '%$county1%'
            AND district LIKE '%$district_name%'
            AND deo_name LIKE '%$deo_name%'
            AND deo_phone LIKE '%$deo_phone%'
            AND deo_email LIKE '%$deo_email%' order by county,district asc ";
                                                                    $result_set = mysql_query($searchQuery);
                                                                } else {
                                                                    $result_set = mysql_query("SELECT * FROM education_contacts WHERE deo_email != '' order by county  asc");
                                                                }
                                                                ?>
                                                                <form action="#">
                                                                    <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
                                                                    <!--<img src="../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>-->
                                                                    <b style="margin-left:20%;width: 100px; font-size:1.5em;">Education Contacts</b>
                                                                </form>
                                                                <br/>
                                                                <div style=" margin-right: 20px">
                                                                    <form method="post">
                                                                        <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                                                                            <caption><b>Make your selection by checking respective contacts</b></caption>
                                                                            <thead>
                                                                                <tr style="border: 1px solid #B4B5B0;">
                                                                                    <th align="center" width="3%"></td>
                                                                                        <th align="center" width="13%">

                                                                                            <select name="county"  style="width: 98%;" onchange="submitForm();">
                                                                                                <option value=''<?php if ($county1 == '') echo 'selected'; ?> ></option>
                                                                                                <?php
                                                                                                $sql = "SELECT * FROM counties ORDER BY county ASC";
                                                                                                $result = mysql_query($sql);
                                                                                                while ($rows = mysql_fetch_array($result)) { //loop table rows
                                                                                                    ?>
                                                                                                    <option value="<?php echo $rows['county']; ?>"<?php
                                                                                                    if ($county1 == $rows['county']) {
                                                                                                        echo 'selected';
                                                                                                    }
                                                                                                    ?>><?php echo $rows['county']; ?></option>
                                                                                                        <?php } ?>
                                                                                            </select>
                                                                                        </th>
                                                                                        <th align="center" width="16%">
                                                                                            <select name="district_name"  style="width: 98%;" onchange="submitForm();">
                                                                                                <option value=''<?php if ($district_name == '') echo 'selected'; ?> ></option>
                                                                                                <?php
                                                                                                $sql = "SELECT * FROM districts WHERE county='$county1' ORDER BY district_name ASC";
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
                                                                                        <th align="center" width="25%"><input type="text" style="width: 98%" name="deo_name"  value="<?php echo $deo_name ?>"/></th>
                                                                                        <th align="center" width="13%"><input type="text" style="width: 98%" name="deo_phone"  value="<?php echo $deo_phone ?>"/></th>
                                                                                        <th align="center" width="20%"><input type="text" style="width: 98%" name="deo_email"  value="<?php echo $deo_email ?>"/></th>
                                                                                        <th align="center" width="8%"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                                                                                </tr>            
                                                                        </table>
                                                                        <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                                                                            <thead>
                                                                                <tr style="border: 1px solid #B4B5B0;">
                                                                                    <th align="Left" width="4%">Chk</th>
                                                                                    <th align="Left" width="12%">County</th>
                                                                                    <th align="Left" width="16%">District</th>
                                                                                    <th align="Left" width="26%">DEO Name</th>
                                                                                    <th align="Left" width="14%">DEO Mobile</th>
                                                                                    <th align="Left" width="28%">DEO Email</th> 
                                                                                </tr>

                                                                            </thead>
                                                                        </table>
                                                                    </form>
                                                                </div>

                                                                <form method="post" action='comm_emails.php#close'>
                                                                    <div style="width:100%; max-height:300px; overflow-y: scroll; ">
                                                                        <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                                                                            <tbody>
                                                                                <?php
                                                                                while ($row = mysql_fetch_array($result_set)) {
                                                                                    $id = $row['id'];
                                                                                    $county1 = $row['county'];
                                                                                    $district = $row['district'];
                                                                                    $deo_name = $row['deo_name'];
                                                                                    $deo_phone = $row['deo_phone'];
                                                                                    $deo_email = $row['deo_email'];
                                                                                    ?>
                                                                                    <tr style="border-bottom: 1px solid #B4B5B0;">
                                                                                        <td align="left" width="4%"><input class="first" type="checkbox" name="check_num[]" 
                                                                                                                           value=" <?php echo $deo_email; ?>"/></td>
                                                                                        <td align="left" width="12%"> <?php echo $county1; ?>  </td>
                                                                                        <td align="left" width="16%"> <?php echo $district; ?> </td>
                                                                                        <td align="left" width="26%"> <?php echo $deo_name; ?> </td>
                                                                                        <td align="left" width="14%"><?php
                                                                                            echo substr($deo_phone, 0, 12);
                                                                                            if (strlen($deo_phone) > 12)
                                                                                                echo "..";
                                                                                            ?>
                                                                                        </td>
                                                                                        <td align="left" width="28%"><?php
                                                                                            echo substr($deo_email, 0, 30);
                                                                                            if (strlen($deo_email) > 30)
                                                                                                echo "..";
                                                                                            ?>
                                                                                        </td> 
                                                                                    </tr>
                                                                                </tbody>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </div>
                                                                    <p align="center">
                                                                        <input id="checkAll1" type="button" value="Check/Uncheck All" class="btn-custom-pink">
                                                                            <input type="submit" name="make_selection" id="make_selection" value="Confirm Selection" class="btn-custom-pink"/> 
                                                                    </p>

                                                                </form>

                                                            </div>  

                                                        </div>


                                                        <!--==========================Master Trainers=====================-->
                                                        <div id="openModalContactSelect2" class="modalDialog">
                                                            <div style="width:800px;">
                                                                <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-3%;" >X</a>
                                                                <div class="dashboard_menu" >
                                                                    <a class="btn btn-primary"  href="comm_emails.php#openModalContactSelect" style="text-decoration: none;">Health Contacts</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect1" style="text-decoration: none;">Education Contacts</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect2" style="text-decoration: none;">Master Trainers</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect3" style="text-decoration: none;">County Contacts</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect4" style="text-decoration: none;">Head Teachers</a>
                                                                    <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect5" style="text-decoration: none;">Staff</a>
                                                                </div></br>
                                                                <?php
                                                                if (isset($_POST['search_table'])) {
                                                                    $full_name = $_POST['full_name'];
                                                                    $ministry = $_POST['ministry'];
                                                                    $posting_station = $_POST['posting_station'];
                                                                    $phone_number = $_POST['phone_number'];
                                                                    $email = $_POST['email'];
                                                                    $searchQuery = "SELECT * FROM master_trainers WHERE email != '' AND full_name LIKE '%$full_name%'
              AND ministry LIKE '%$ministry%'
              AND posting_station LIKE '%$posting_station%'
              AND email LIKE '%$email%'
              AND phone_number LIKE '%$phone_number%' order by full_name asc ";
                                                                    $result_set = mysql_query($searchQuery);
                                                                } else {
                                                                    $result_set = mysql_query("SELECT * FROM master_trainers WHERE email != '' order by full_name asc");
                                                                }
                                                                ?>
                                                                <form action="#">
                                                                    <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
                                                                    <!--<img src="../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>-->
                                                                    <b style="margin-left:20%;width: 100px; font-size:1.5em;">Master Trainers</b>
                                                                </form>
                                                                <br/>
                                                                <div style=" margin-right: 20px">
                                                                    <form method="post">
                                                                        <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                                                                            <caption><b>Make your selection by checking respective contacts</b></caption>
                                                                            <thead>
                                                                                <tr style="border: 1px solid #B4B5B0;">
                                                                                    <th align="center" width="3%">
                                                                                        <th align="center" width="13%">
                                                                                            <select name="ministry"  style="width: 98%;" onchange="submitForm();">
                                                                                                <option value=''<?php if ($ministry == '') echo 'selected'; ?> ></option>
                                                                                                <?php
                                                                                                $sql = "SELECT * FROM master_trainers ORDER BY ministry ASC";
                                                                                                $result = mysql_query($sql);
                                                                                                while ($rows = mysql_fetch_array($result)) { //loop table rows
                                                                                                    ?>
                                                                                                    <option value="<?php echo $rows['posting_']; ?>"<?php
                                                                                                    if ($ministry == $rows['ministry']) {
                                                                                                        echo 'selected';
                                                                                                    }
                                                                                                    ?>><?php echo $rows['ministry']; ?></option>
                                                                                                        <?php } ?>
                                                                                            </select>
                                                                                        </th>
                                                                                        <th align="center" width="19%"><input type="text" style="width: 98%" name="posting_station"  value="<?php echo $posting_station ?>"/></th>
                                                                                        <th align="center" width="22%"><input type="text" style="width: 98%" name="full_name"  value="<?php echo $full_name ?>"/></th>
                                                                                        <th align="center" width="13%"><input type="text" style="width: 98%" name="phone_number"  value="<?php echo $phone_number ?>"/></th>
                                                                                        <th align="center" width="20%"><input type="text" style="width: 98%" name="email"  value="<?php echo $email ?>"/></th>
                                                                                        <th align="center" width="8%"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                                                                                </tr> 
                                                                                <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                                                                                    <thead>
                                                                                        <tr style="border: 1px solid #B4B5B0;">
                                                                                            <th align="Left" width="4%">Chk</th>
                                                                                            <th align="Left" width="12%">Ministry</th>
                                                                                            <th align="Left" width="19%">Posting Station</th>
                                                                                            <th align="Left" width="23%">Full Name</th>
                                                                                            <th align="Left" width="14%">Mobile</th>
                                                                                            <th align="Left" width="28%">Email</th> 
                                                                                        </tr>

                                                                                    </thead>
                                                                                </table>
                                                                                </form>
                                                                                </div>

                                                                                <form method="post" action='comm_emails.php#close'>
                                                                                    <div style="width:100%; max-height:300px; overflow-y: scroll; ">
                                                                                        <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">

                                                                                            <tbody>
                                                                                                <?php
                                                                                                while ($row = mysql_fetch_array($result_set)) {
                                                                                                    $id = $row['id'];
                                                                                                    $ministry = $row['ministry'];
                                                                                                    $posting_station = $row['posting_station'];
                                                                                                    $full_name = $row['full_name'];
                                                                                                    $phone_number = $row['phone_number'];
                                                                                                    $email = $row['email'];
                                                                                                    ?>
                                                                                                    <tr style="border-bottom: 1px solid #B4B5B0;">
                                                                                                        <td align="left" width="4%"><input class="first" type="checkbox" name="check_num[]" 
                                                                                                                                           value=" <?php echo $email; ?>"/></td>
                                                                                                        <td align="left" width="12%"> <?php echo $ministry; ?>  </td>
                                                                                                        <td align="left" width="19%"> <?php echo $posting_station; ?> </td>
                                                                                                        <td align="left" width="23%"> <?php echo $full_name; ?> </td>
                                                                                                        <td align="left" width="14%"><?php
                                                                                                            echo substr($phone_number, 0, 12);
                                                                                                            if (strlen($phone_number) > 12)
                                                                                                                echo "..";
                                                                                                            ?>
                                                                                                        </td>
                                                                                                        <td align="left" width="28%"><?php
                                                                                                            echo substr($email, 0, 30);
                                                                                                            if (strlen($email) > 30)
                                                                                                                echo "..";
                                                                                                            ?>
                                                                                                        </td> 
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            <?php } ?>
                                                                                        </table>
                                                                                    </div>
                                                                                    <p align="center">
                                                                                        <input id="checkAll2" type="button" value="Check/Uncheck All" class="btn-custom-pink">
                                                                                            <input type="submit" name="make_selection" id="make_selection" value="Confirm Selection" class="btn-custom-pink"/> 
                                                                                    </p>

                                                                                </form>

                                                                                </div>  

                                                                                </div>

                                                                                <!--==========================County Contact Modal=====================-->
                                                                                <div id="openModalContactSelect3" class="modalDialog">
                                                                                    <div style="width:800px;">
                                                                                        <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-3%;" >X</a>
                                                                                        <div class="dashboard_menu" >
                                                                                            <a class="btn btn-primary"  href="comm_emails.php#openModalContactSelect" style="text-decoration: none;">Health Contacts</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect1" style="text-decoration: none;">Education Contacts</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect2" style="text-decoration: none;">Master Trainers</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect3" style="text-decoration: none;">County Contacts</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect4" style="text-decoration: none;">Head Teachers</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect5" style="text-decoration: none;">Staff</a>
                                                                                        </div></br>
                                                                                        <?php
                                                                                        if (isset($_POST['search_table'])) {
                                                                                            $county2 = $_POST['county'];
                                                                                            $title = $_POST['title'];
                                                                                            $full_name1 = $_POST['full_name'];
                                                                                            $phoneSearch = $_POST['phoneSearch'];
                                                                                            $emailSearch = $_POST['emailSearch'];
                                                                                            $searchQuery = "SELECT * FROM county_contacts WHERE email != '' AND county LIKE '%$county2%'
              AND title LIKE '%$title%'
              AND full_name LIKE '%$full_name1%'
              AND phone LIKE '%$phoneSearch%'
              AND email  LIKE '%$emailSearch%' order by county asc ";
                                                                                            $result_set = mysql_query($searchQuery);
                                                                                        } else {
                                                                                            $result_set = mysql_query("SELECT * FROM county_contacts WHERE email != '' order by county  asc");
                                                                                        }
                                                                                        ?>
                                                                                        <form action="#">
                                                                                            <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
                                                                                            <!--<img src="../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>-->
                                                                                            <b style="margin-left:20%;width: 100px; font-size:1.5em;">County Contacts</b>
                                                                                        </form>
                                                                                        <br/>
                                                                                        <div style=" margin-right: 20px">
                                                                                            <form method="post">
                                                                                                <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                                                                                                    <caption><b>Make your selection by checking respective contacts</b></caption>
                                                                                                    <thead>
                                                                                                        <tr style="border: 1px solid #B4B5B0;">
                                                                                                            <th align="center" width="3%"></td>
                                                                                                                <th align="center" width="13%">

                                                                                                                    <select name="county"  style="width: 98%;" onchange="submitForm();">
                                                                                                                        <option value=''<?php if ($county2 == '') echo 'selected'; ?> ></option>
                                                                                                                        <?php
                                                                                                                        $sql = "SELECT * FROM counties ORDER BY county ASC";
                                                                                                                        $result = mysql_query($sql);
                                                                                                                        while ($rows = mysql_fetch_array($result)) { //loop table rows
                                                                                                                            ?>
                                                                                                                            <option value="<?php echo $rows['county']; ?>"<?php
                                                                                                                            if ($county2 == $rows['county']) {
                                                                                                                                echo 'selected';
                                                                                                                            }
                                                                                                                            ?>><?php echo $rows['county']; ?></option>
                                                                                                                                <?php } ?>
                                                                                                                    </select>  

                                                                                                                </th>
                                                                                                                <th align="center" width="14%">
                                                                                                                    <select name="title"  style="width: 98%;" onchange="submitForm();">
                                                                                                                        <option value=''<?php if ($title == '') echo 'selected'; ?> ></option>
                                                                                                                        <?php
                                                                                                                        $sql = "SELECT * FROM dropdown_county_titles ORDER BY title ASC";
                                                                                                                        $result = mysql_query($sql);
                                                                                                                        while ($rows = mysql_fetch_array($result)) { //loop table rows
                                                                                                                            ?>
                                                                                                                            <option value="<?php echo $rows['title']; ?>"<?php
                                                                                                                            if ($county2 == $rows['title']) {
                                                                                                                                echo 'selected';
                                                                                                                            }
                                                                                                                            ?>><?php echo $rows['title']; ?></option>
                                                                                                                                <?php } ?>
                                                                                                                    </select>
                                                                                                                </th>
                                                                                                                <th align="center" width="25%"><input type="text" style="width: 98%" name="full_name"  value="<?php echo $full_name1 ?>"/></th>
                                                                                                                <th align="center" width="13%"><input type="text" style="width: 98%" name="phone_search"  value="<?php echo $phoneSearch ?>"/></th>
                                                                                                                <th align="center" width="20%"><input type="text" style="width: 98%" name="email_search"  value="<?php echo $emailSearch ?>"/></th>
                                                                                                                <th align="center" width="8%"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                                                                                                        </tr>            
                                                                                                </table>
                                                                                                <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                                                                                                    <thead>
                                                                                                        <tr style="border: 1px solid #B4B5B0;">
                                                                                                            <th align="Left" width="4%">Chk</th>
                                                                                                            <th align="Left" width="12%">County</th>
                                                                                                            <th align="Left" width="16%">Title</th>
                                                                                                            <th align="Left" width="26%">Full Name</th>
                                                                                                            <th align="Left" width="14%">Mobile</th>
                                                                                                            <th align="Left" width="28%">Email</th> 
                                                                                                        </tr>

                                                                                                    </thead>
                                                                                                </table>
                                                                                            </form>
                                                                                        </div>

                                                                                        <form method="post" action='comm_emails.php#close'>
                                                                                            <div style="width:100%; max-height:300px; overflow-y: scroll; ">
                                                                                                <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                                                                                                    <tbody>
                                                                                                        <?php
                                                                                                        while ($row = mysql_fetch_array($result_set)) {
                                                                                                            $id = $row['id'];
                                                                                                            $county2 = $row['county'];
                                                                                                            $title = $row['title'];
                                                                                                            $full_name1 = $row['full_name'];
                                                                                                            $phoneSearch = $row['phone'];
                                                                                                            $emailSearch = $row['email'];
                                                                                                            ?>
                                                                                                            <tr style="border-bottom: 1px solid #B4B5B0;">
                                                                                                                <td align="left" width="4%"><input class="first" type="checkbox" name="check_num[]" 
                                                                                                                                                   value=" <?php echo $emailSearch; ?>"/></td>
                                                                                                                <td align="left" width="12%"> <?php echo $county2; ?>  </td>
                                                                                                                <td align="left" width="16%"> <?php echo $title; ?> </td>
                                                                                                                <td align="left" width="26%"> <?php echo $full_name1; ?> </td>
                                                                                                                <td align="left" width="14%"><?php
                                                                                                                    echo substr($phoneSearch, 0, 12);
                                                                                                                    if (strlen($phoneSearch) > 12)
                                                                                                                        echo "..";
                                                                                                                    ?>
                                                                                                                </td>
                                                                                                                <td align="left" width="28%"><?php
                                                                                                                    echo substr($emailSearch, 0, 30);
                                                                                                                    if (strlen($emailSearch) > 30)
                                                                                                                        echo "..";
                                                                                                                    ?>
                                                                                                                </td> 
                                                                                                            </tr>

                                                                                                        <?php } ?>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                            <p align="center">
                                                                                                <input id="checkAll3" type="button" value="Check/Uncheck All" class="btn-custom-pink">
                                                                                                    <input type="submit" name="make_selection" id="make_selection" value="Confirm Selection" class="btn-custom-pink"/> 
                                                                                            </p>

                                                                                        </form>

                                                                                    </div>  

                                                                                </div>
                                                                                <!--==========================Head Teachers Contact Modal=====================-->
                                                                                <div id="openModalContactSelect4" class="modalDialog">
                                                                                    <div style="width:800px;">
                                                                                        <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-3%;" >X</a>
                                                                                        <div class="dashboard_menu" >
                                                                                            <a class="btn btn-primary"  href="comm_emails.php#openModalContactSelect" style="text-decoration: none;">Health Contacts</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect1" style="text-decoration: none;">Education Contacts</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect2" style="text-decoration: none;">Master Trainers</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect3" style="text-decoration: none;">County Contacts</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect4" style="text-decoration: none;">Head Teachers</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect5" style="text-decoration: none;">Staff</a>
                                                                                        </div></br>

                                                                                        <?php
                                                                                        if (isset($_POST['search_table'])) {
                                                                                            $county = $_POST['county'];
                                                                                            $district = $_POST['district'];
                                                                                            $name = $_POST['name'];
                                                                                            $phone = $_POST['phone'];
                                                                                            $email1 = $_POST['email'];
                                                                                            $searchQuery = "SELECT * FROM headteachers WHERE email != '' AND county LIKE '%$county%'
            AND district LIKE '%$district%'
            AND name LIKE '%$name%'
            AND phone LIKE '%$phone%'
            AND email LIKE '%$email1%' order by county,district asc ";
                                                                                            $result_set = mysql_query($searchQuery);
                                                                                        } else {
                                                                                            $result_set = mysql_query("SELECT * FROM headteachers WHERE email != '' order by county  asc LIMIT 200");
                                                                                        }
                                                                                        ?>
                                                                                        <form action="#">
                                                                                            <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
                                                                                            <!--<img src="../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>-->
                                                                                            <b style="margin-left:20%;width: 100px; font-size:1.5em;">Head teachers Contacts</b>
                                                                                        </form>
                                                                                        <br/>
                                                                                        <div style=" margin-right: 20px">
                                                                                            <form method="post">
                                                                                                <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                                                                                                    <caption><b>Make your selection by checking respective contacts</b></caption>
                                                                                                    <thead>
                                                                                                        <tr style="border: 1px solid #B4B5B0;">
                                                                                                            <th align="center" width="3%"></td>
                                                                                                                <th align="center" width="13%">
                                                                                                                    <select name="county"  style="width: 98%;" onchange="submitForm();">
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
                                                                                                                </th>
                                                                                                                <th align="center" width="16%">
                                                                                                                    <select name="district"  style="width: 98%;" onchange="submitForm();">
                                                                                                                        <option value=''<?php if ($district == '') echo 'selected'; ?> ></option>
                                                                                                                        <?php
                                                                                                                        $sql = "SELECT * FROM districts WHERE county='$county' ORDER BY district_name ASC";
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
                                                                                                                </th>
                                                                                                                <th align="center" width="24%"><input type="text" style="width: 98%" name="name"  value="<?php echo $name ?>"/></th>
                                                                                                                <th align="center" width="14%"><input type="text" style="width: 98%" name="phone"  value="<?php echo $phone ?>"/></th>
                                                                                                                <th align="center" width="19%"><input type="text" style="width: 98%" name="email"  value="<?php echo $email1 ?>"/></th>
                                                                                                                <th align="center" width="8%"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                                                                                                        </tr>
                                                                                                </table>
                                                                                                <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                                                                                                    <thead>
                                                                                                        <tr style="border: 1px solid #B4B5B0;">
                                                                                                            <th align="Left" width="4%">Chk</th>
                                                                                                            <th align="Left" width="12%">County</th>
                                                                                                            <th align="Left" width="16%">District</th>
                                                                                                            <th align="Left" width="26%">Full Name</th>
                                                                                                            <th align="Left" width="14%">Mobile No</th>
                                                                                                            <th align="Left" width="28%">Email</th> 
                                                                                                        </tr>

                                                                                                    </thead>
                                                                                                </table>
                                                                                            </form>
                                                                                        </div>

                                                                                        <form method="post" action='comm_emails.php#close'>
                                                                                            <div style="width:100%; max-height:300px;  overflow-y: scroll; ">
                                                                                                <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">

                                                                                                    <tbody>
                                                                                                        <?php
                                                                                                        while ($row = mysql_fetch_array($result_set)) {
                                                                                                            $id = $row['id'];
                                                                                                            $county = $row['county'];
                                                                                                            $district = $row['district'];
                                                                                                            $name = $row['name'];
                                                                                                            $phone = $row['phone'];
                                                                                                            $email1 = $row['email'];
                                                                                                            ?>
                                                                                                            <tr style="border-bottom: 1px solid #B4B5B0;">
                                                                                                                <td align="left" width="4%"><input class="first" type="checkbox" name="check_num[]" 
                                                                                                                                                   value=" <?php echo $email1; ?>"/></td>
                                                                                                                <td align="left" width="12%"> <?php echo $county; ?>  </td>
                                                                                                                <td align="left" width="16%"> <?php echo $district; ?> </td>
                                                                                                                <td align="left" width="26%"> <?php echo $name; ?> </td>
                                                                                                                <td align="left" width="14%"><?php
                                                                                                                    echo substr($phone, 0, 12);
                                                                                                                    if (strlen($phone) > 12)
                                                                                                                        echo "..";
                                                                                                                    ?>
                                                                                                                </td>
                                                                                                                <td align="left" width="28%"><?php
                                                                                                                    echo substr($email1, 0, 30);
                                                                                                                    if (strlen($email1) > 30)
                                                                                                                        echo "..";
                                                                                                                    ?>
                                                                                                                </td> 
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    <?php } ?>
                                                                                                </table>
                                                                                            </div>
                                                                                            <p align="center">
                                                                                                <input id="checkAll4" type="button" value="Check/Uncheck All" class="btn-custom-pink">
                                                                                                    <input type="submit" name="make_selection" id="make_selection" value="Confirm Selection" class="btn-custom-pink"/> 
                                                                                            </p>

                                                                                        </form>

                                                                                    </div>  

                                                                                </div>
                                                                                <!--==========================Staff Contact Modal=====================-->
                                                                                <div id="openModalContactSelect5" class="modalDialog">
                                                                                    <div style="width:800px;">
                                                                                        <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-3%;" >X</a>
                                                                                        <div class="dashboard_menu" >
                                                                                            <a class="btn btn-primary"  href="comm_emails.php#openModalContactSelect" style="text-decoration: none;">Health Contacts</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect1" style="text-decoration: none;">Education Contacts</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect2" style="text-decoration: none;">Master Trainers</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect3" style="text-decoration: none;">County Contacts</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect4" style="text-decoration: none;">Head Teachers</a>
                                                                                            <a class="btn btn-primary" href="comm_emails.php#openModalContactSelect5" style="text-decoration: none;">Staff</a>
                                                                                        </div></br>

                                                                                        <?php
                                                                                        if (isset($_POST['search_table'])) {
                                                                                            $staff_name = $row['staff_name'];
                                                                                            $staff_role = $row['staff_role'];
                                                                                            $staff_town = $row['staff_town'];
                                                                                            $staff_phone = $row['staff_mobile'];
                                                                                            $staff_email = $row['staff_email'];
                                                                                            $searchQuery = "SELECT * FROM staff WHERE staff_email != '' AND staff_town LIKE '%$staff_town%'
            AND staff_role LIKE '%$staff_role%'
            AND staff_name LIKE '%$staff_name%'
            AND staff_mobile LIKE '%$staff_phone%'
            AND staff_email LIKE '%$staff_email%' order by staff_town asc ";
                                                                                            $result_set = mysql_query($searchQuery);
                                                                                        } else {
                                                                                            $result_set = mysql_query("SELECT * FROM staff WHERE staff_email != '' order by staff_town  asc");
                                                                                        }
                                                                                        ?>
                                                                                        <form action="#">
                                                                                            <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
                                                                                            <!--<img src="../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>-->
                                                                                            <b style="margin-left:20%;width: 100px; font-size:1.5em;">Staff Contacts</b>
                                                                                        </form>
                                                                                        <br/>
                                                                                        <div style=" margin-right: 20px">
                                                                                            <form method="post">
                                                                                                <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                                                                                                    <caption><b>Make your selection by checking respective contacts</b></caption>
                                                                                                    <thead>
                                                                                                        <tr style="border: 1px solid #B4B5B0;">
                                                                                                            <th align="center" width="3%"></td>
                                                                                                                <th align="center" width="13%">
                                                                                                                    <select name="staff_town"  style="width: 98%;" onchange="submitForm();">
                                                                                                                        <option value=''<?php if ($staff_town == '') echo 'selected'; ?> ></option>
                                                                                                                        <?php
                                                                                                                        $sql = "SELECT * FROM staff ORDER BY staff_town ASC";
                                                                                                                        $result = mysql_query($sql);
                                                                                                                        while ($rows = mysql_fetch_array($result)) { //loop table rows
                                                                                                                            ?>
                                                                                                                            <option value="<?php echo $rows['staff_town']; ?>"<?php
                                                                                                                            if ($staff_town == $rows['staff_town']) {
                                                                                                                                echo 'selected';
                                                                                                                            }
                                                                                                                            ?>><?php echo $rows['staff_town']; ?></option>
                                                                                                                                <?php } ?>
                                                                                                                    </select>
                                                                                                                </th>
                                                                                                                <th align="center" width="16%">
                                                                                                                    <input type="text" style="width: 98%" name="staff_role"  value="<?php echo $staff_role ?>"/>   
                                                                                                                </th>
                                                                                                                <th align="center" width="24%"><input type="text" style="width: 98%" name="staff_name"  value="<?php echo $staff_name ?>"/></th>
                                                                                                                <th align="center" width="14%"><input type="text" style="width: 98%" name="staff_phone"  value="<?php echo $staff_phone ?>"/></th>
                                                                                                                <th align="center" width="19%"><input type="text" style="width: 98%" name="staff_email"  value="<?php echo $staff_email ?>"/></th>
                                                                                                                <th align="center" width="8%"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                                                                                                        </tr>
                                                                                                </table>
                                                                                                <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                                                                                                    <thead>
                                                                                                        <tr style="border: 1px solid #B4B5B0;">
                                                                                                            <th align="Left" width="4%">Chk</th>
                                                                                                            <th align="Left" width="12%">Staff Town</th>
                                                                                                            <th align="Left" width="16%">Staff Role</th>
                                                                                                            <th align="Left" width="26%">staff Name</th>
                                                                                                            <th align="Left" width="14%">staff Mobile</th>
                                                                                                            <th align="Left" width="28%">staff Email</th> 
                                                                                                        </tr>

                                                                                                    </thead>
                                                                                                </table>
                                                                                            </form>
                                                                                        </div>

                                                                                        <form method="post" action='comm_emails.php#close'>
                                                                                            <div style="width:100%; max-height:300px;  overflow-y: scroll; ">
                                                                                                <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">

                                                                                                    <tbody>
                                                                                                        <?php
                                                                                                        while ($row = mysql_fetch_array($result_set)) {
                                                                                                            $id = $row['staff_id'];
                                                                                                            $staff_name = $row['staff_name'];
                                                                                                            $staff_role = $row['staff_role'];
                                                                                                            $staff_town = $row['staff_town'];
                                                                                                            $staff_phone = $row['staff_mobile'];
                                                                                                            $staff_email = $row['staff_email'];
                                                                                                            ?>
                                                                                                            <tr style="border-bottom: 1px solid #B4B5B0;">
                                                                                                                <td align="left" width="4%"><input class="first" type="checkbox" name="check_num[]" 
                                                                                                                                                   value=" <?php echo $staff_email; ?>"/></td>
                                                                                                                <td align="left" width="12%"> <?php echo $staff_town; ?>  </td>
                                                                                                                <td align="left" width="16%"> <?php echo $staff_role; ?> </td>
                                                                                                                <td align="left" width="26%"> <?php echo $staff_name; ?> </td>
                                                                                                                <td align="left" width="14%"><?php
                                                                                                                    echo substr($staff_phone, 0, 12);
                                                                                                                    if (strlen($staff_phone) > 12)
                                                                                                                        echo "..";
                                                                                                                    ?>
                                                                                                                </td>
                                                                                                                <td align="left" width="28%"><?php
                                                                                                                    echo substr($staff_email, 0, 30);
                                                                                                                    if (strlen($staff_email) > 30)
                                                                                                                        echo "..";
                                                                                                                    ?>
                                                                                                                </td> 
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    <?php } ?>
                                                                                                </table>
                                                                                            </div>
                                                                                            <p align="center">
                                                                                                <input id="checkAll5" type="button" value="Check/Uncheck All" class="btn-custom-pink">
                                                                                                    <input type="submit" name="make_selection" id="make_selection" value="Confirm Selection" class="btn-custom-pink"/> 
                                                                                            </p>

                                                                                        </form>

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
                                //load subject template============================================================================
                                function loadSubject() {
                                    var id = document.getElementById("email_template").value;

                                    if (id === "") {
                                        alert("Please select one template first");
                                    }

                                    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                                        xmlhttp = new XMLHttpRequest();
                                    }
                                    else {// code for IE6, IE5
                                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                    }
                                    xmlhttp.onreadystatechange = function() {
                                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                            document.getElementById("subject").value = xmlhttp.responseText;
                                        }
                                    }
                                    // load the assumption to be used
                                    xmlhttp.open("GET", "ajax_files/load_comm_template.php?commType=email&req=subject&id=" + id, true);
                                    xmlhttp.send();
                                }

                                //load body template============================================================================
                                function loadBody() {
                                    var id = document.getElementById("email_template").value;

                                    if (id === "") {
                                        alert("Please select one template first");
                                    }

                                    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                                        xmlhttp1 = new XMLHttpRequest();
                                    }
                                    else {// code for IE6, IE5
                                        xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
                                    }
                                    xmlhttp1.onreadystatechange = function() {
                                        if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
                                            document.getElementById("email_body").value = xmlhttp1.responseText;
                                        }
                                    }
                                    // load the assumption to be used
                                    xmlhttp1.open("GET", "ajax_files/load_comm_template.php?commType=email&req=body&id=" + id, true);
                                    xmlhttp1.send();

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
                                                                                    document.onkeypress = function(e) {
                                                                                        e = e || window.event;
                                                                                        if (typeof e != 'undefined') {
                                                                                            var tgt = e.target || e.srcElement;
                                                                                            if (typeof tgt != 'undefined' && /input/i.test(tgt.nodeName))
                                                                                                return (typeof e.keyCode != 'undefined') ? e.keyCode != 13 : true;
                                                                                        }
                                                                                    }
                                                                                </script>

                                                                                <script type="text/javascript">
                                                                                    $(document).ready(function() {
                                                                                        // JS for Check/Uncheck all CheckBoxes by Button //
                                                                                        $("#checkAll").attr("data-type", "check");
                                                                                        $("#checkAll").click(function() {
                                                                                            if ($("#checkAll").attr("data-type") === "check") {
                                                                                                $(".first").prop("checked", true);
                                                                                                $("#checkAll").attr("data-type", "uncheck");
                                                                                            } else {
                                                                                                $(".first").prop("checked", false);
                                                                                                $("#checkAll").attr("data-type", "check");
                                                                                            }
                                                                                        });
                                                                                        $("#checkAll1").attr("data-type", "check");
                                                                                        $("#checkAll1").click(function() {
                                                                                            if ($("#checkAll1").attr("data-type") === "check") {
                                                                                                $(".first").prop("checked", true);
                                                                                                $("#checkAll1").attr("data-type", "uncheck");
                                                                                            } else {
                                                                                                $(".first").prop("checked", false);
                                                                                                $("#checkAll1").attr("data-type", "check");
                                                                                            }
                                                                                        });
                                                                                        $("#checkAll2").attr("data-type", "check");
                                                                                        $("#checkAll2").click(function() {
                                                                                            if ($("#checkAll2").attr("data-type") === "check") {
                                                                                                $(".first").prop("checked", true);
                                                                                                $("#checkAll2").attr("data-type", "uncheck");
                                                                                            } else {
                                                                                                $(".first").prop("checked", false);
                                                                                                $("#checkAll2").attr("data-type", "check");
                                                                                            }
                                                                                        });
                                                                                        $("#checkAll3").attr("data-type", "check");
                                                                                        $("#checkAll3").click(function() {
                                                                                            if ($("#checkAll3").attr("data-type") === "check") {
                                                                                                $(".first").prop("checked", true);
                                                                                                $("#checkAll3").attr("data-type", "uncheck");
                                                                                            } else {
                                                                                                $(".first").prop("checked", false);
                                                                                                $("#checkAll3").attr("data-type", "check");
                                                                                            }
                                                                                        });
                                                                                        $("#checkAll4").attr("data-type", "check");
                                                                                        $("#checkAll4").click(function() {
                                                                                            if ($("#checkAll4").attr("data-type") === "check") {
                                                                                                $(".first").prop("checked", true);
                                                                                                $("#checkAll4").attr("data-type", "uncheck");
                                                                                            } else {
                                                                                                $(".first").prop("checked", false);
                                                                                                $("#checkAll4").attr("data-type", "check");
                                                                                            }
                                                                                        });
                                                                                        $("#checkAll5").attr("data-type", "check");
                                                                                        $("#checkAll5").click(function() {
                                                                                            if ($("#checkAll5").attr("data-type") === "check") {
                                                                                                $(".first").prop("checked", true);
                                                                                                $("#checkAll5").attr("data-type", "uncheck");
                                                                                            } else {
                                                                                                $(".first").prop("checked", false);
                                                                                                $("#checkAll5").attr("data-type", "check");
                                                                                            }
                                                                                        });
                                                                                    });
                                                                                </script>

