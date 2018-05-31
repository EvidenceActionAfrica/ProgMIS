<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
require_once('includes/db_functions.php');
require_once("includes/logTracker.php");
$evidenceaction = new EvidenceAction();
//Privileges settings
$priv_mail = $_SESSION['staff_email'];
$resPriv = mysql_query("select * from staff where staff_email='$priv_mail'");

while ($row = mysql_fetch_array($resPriv)) {
  $priv_steering = $row["priv_steering"];
}
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
        //Delete
        if (isset($_GET['deleteid'])) {
          $deleteid = $_GET['deleteid'];
          $query = "DELETE FROM steering_committee WHERE id='$deleteid'";
          $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());

          //log entry
          $staff_id = $_SESSION['staff_id'];
          $staff_email = $_SESSION['staff_email'];
          $staff_name = $_SESSION['staff_name'];
          $action = "Delete \"Steering Committee Contact\" ";
          $description = "Record ID: " . $deleteid . " deleted";
          $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
          funclogAdminData($arrLogAdminData);
        }

        if (isset($_POST['search_table'])) {
          $job_group = $_POST['job_group'];
          $ministry = $_POST['ministry'];
          $fullname = $_POST['fullname'];
          $mobile = $_POST['mobile'];
          $email = $_POST['email'];
          $searchQuery = "SELECT * FROM steering_committee WHERE ministry LIKE '%$ministry%'
              AND name LIKE '%$fullname%'
              AND mobile LIKE '%$mobile%'
              AND email LIKE '%$email%' order by ministry asc ";
          //echo $searchQuery;
          
          $result_set = mysql_query($searchQuery);
        } else {
          $result_set = mysql_query("SELECT * FROM steering_committee order by job_group,ministry  asc");
        }
        ?>

        <form action="#">
          <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
          <img src="images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
          <b style="margin-left:10%;width: 100px; font-size:1.5em;">Steering Committee Contacts</b>
        <?php if($priv_steering>=1){?>
          <a class="btn-custom-small" href="PHPExcel/csv_export.php?table_name=steering_committee&file_name=steering_committee">Export to Excel</a>
        <?php } if($priv_steering>=2){?>
          <a class="btn-custom-small" href="#addsteeringMember">Add Member</a>
        <?php } ?>
        </form>
        <br/>
                <style>
            table tbody tr td a{
                text-decoration:none;
                color:#000000;
            }
        </style>
        <div style=" margin-right: 20px">
          <form method="post">
            <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
              <thead>
                <tr style="">
        
                  <th align="center" width="15%">
                    <select name="ministry"  style="width: 98%;" onchange="submitForm();">
                      <option value=''<?php if ($ministry == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT * FROM dropdown_ministry  ORDER BY id ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['ministry']; ?>"<?php
                        if ($ministry == $rows['ministry']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['ministry']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                  <th align="center" width="20%"><input type="text" style="width: 98%" name="fullname"  value="<?php echo $fullname; ?>"/></th>
                  <th align="center" width="15%"><input type="text" style="width: 98%" name="mobile"  value="<?php echo $mobile; ?>"/></th>
                  <th align="center" width="30%"><input type="text" style="width: 98%" name="email"  value="<?php echo $email; ?>"/></th>
                  <th align="center" width="15%" colspan="3"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                </tr>     
              </thead>
            </table>
              <table id="data-table" class="table table-responsive table-hover table-stripped">
                  <thead>
                  <tr>
                  <th align="Left" width="15%">Ministry</th>
                  <th align="Left" width="20%">Full Name</th>
                  <th align="Left" width="15%">Mobile</th>
                  <th align="Left" width="30%">Email</th>
                  <th>Job Group</th>
                
                  <?php if ($priv_steering >= 3) { ?>
                    <th align="center" width="4%">Edit</th>
                  <?php } ?>
                  <?php if ($priv_steering >= 4) { ?>                 
                    <th align="center" width="4%">Del</th>
                  <?php } ?>
                </tr>
              </thead>
     
            <tbody>
              <?php
              while ($row = mysql_fetch_array($result_set)) {
                $id = $row['id'];
                $job_group = $row['job_group'];
                $ministry = $row['ministry'];
                $fullname = $row['name'];
                $mobile = $row['mobile'];
                $steering_email = $row['email'];
                if($priv_steering>=1){
                $link = "steering.php?id=$id&viewDetails=1#viewMoH";
 }else{
                $link = "steering.php#";
  
 }
                ?> 
                <tr style="border-bottom: 1px solid #B4B5B0;">

                  <td align="left" width="15%"> <?php echo "<a href=$link>".$ministry."</a>"; ?> </td>
                  <td align="left" width="20%"> <?php echo "<a href=$link>".$fullname."</a>"; ?> </td>
                  <td align="left" width="15%"><?php

                    echo "<a href=$link>".substr($mobile, 0, 12);
                    if (strlen($mobile) > 12)
                      echo "..";
                      echo "</a>";
                    ?>
                  </td>
                  <td align="left" width="30%"><?php

                    echo "<a href=$link>".substr($steering_email, 0, 30);
                    if (strlen($steering_email) > 30)
                      echo "..";
                       echo "</a>";
                    ?>
                  </td>
                  <td align="left" width="10%"> <?php echo "<a href=$link>".$job_group."</a>"; ?> </td> 

                  <?php if ($priv_steering >= 3) { ?>
                    <!--edit button-->
                    <form method="POST" action="#editHealth">
                      <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                      <td align="center" width="4%"><input type="submit" name="editDetails" value="" style="background: url(images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                    </form>
                  <?php } ?>
                  <?php if ($priv_steering >= 4) { ?>
                    <td align="center" width="4%"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="images/icons/delete.png" height="20px"></a></td>
                  <?php }
                  ?>
                </tr>
                </a>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->

 <script type="text/javascript">

    function submitForm() {
      document.getElementById('imgLoading').style.visibility = "visible";
      var selectButton = document.getElementById('btnSearchSubmit');
      selectButton.click();
    }
    </script>
    <!--Delete dialog-->
    <script>
      function show_confirm(deleteid) {
        if (confirm("Are you sure you want to delete?")) {
          location.replace('?deleteid=' + deleteid);
        } else {
          return false;
        }
      }
    </script>
  </body>
</html>







<!--==== Modal ADD ======-->
<div id="addsteeringMember" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <?php
    $formSubmitted = false;
    if (isset($_POST['submitMember'])) {
        
     
      //Post Values to DB
      $job_group = $_POST['job_group'];
      $ministry = $_POST['ministry'];
      $full_name = $_POST['full_name'];
      $mobile = $_POST['mobile'];
      $email = $_POST['email'];
      
      $job_group = addslashes(trim($job_group));
      $ministry = addslashes(trim($ministry));
      $full_name = addslashes(trim($full_name));
      $mobile = addslashes(trim($mobile));
      $email = addslashes(trim($email));
    
      $query =("INSERT INTO steering_committee (
            `job_group`,
            `ministry`,
            `name`,
            `mobile`,
            `email`)
        VALUES (
            '$job_group',
            '$ministry',
            '$full_name',
            '$mobile',
            '$email')");
     // echo $query;
      
      mysql_query($query) or die(mysql_error());
      $messageToUser = "Record Added Successfully!";


      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];
      $action = "Added \"Steering Committee Member\" ";
      $description = "Record ID: " . $steering_name . " added";
      $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      funclogAdminData($arrLogAdminData);
    }
    ?>
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <h1 class="form-title">Add Steering Committee Member</h1>
      <div style="padding: 5px; overflow-y: scroll">
        <!--left div-->
        <div style="width:49%;margin-left:35%;">
          <h3 class="compact">Steering Committee Member Details</h3>
          <table border="0"  cellpadding="0" cellspacing="0" width="100%">
            <thead>
              <tr>
                <td>Ministry </td>
                <td>
                  <?php
                  $tablename = 'dropdown_ministry';
                  $fields = 'id, ministry';
                  $where = '1=1 order by ministry asc';
                  $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                  ?>
                  <select id="ministry" name="ministry" class="input_select_p compact" required >
                    <option value="">Choose Ministry</option>
                    <?php foreach ($insertformdata as $insertformdatacab) { ?>
                      <option value="<?php echo $insertformdatacab['ministry']; ?>"><?php echo $insertformdatacab['ministry']; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Full Name</td><td><input type="text" name="full_name" class="input_textbox_p compact" value="" required/></td>
              </tr>
             <tr>
                <td> Contact Phone </td><td><input type="text" name="mobile" id="mobile" class="input_textbox_p compact" placeholder="254" onKeyUp="isNumeric(this.id);"/><span id="mobileSpan"></span></td>
              </tr>
                <tr>
                <td> Contact Email </td><td><input type="email" name="email" class="input_textbox_p compact" /></td>
              </tr>
                  <tr>
                <td>Job Group </td><td><input type="text" name="job_group" class="input_textbox_p compact" /></td>
              </tr>   
          </table >
          <br/>
          <center>
            <table> <tr>
                <td><input type="submit" class="btn-custom-small" name="submitMember"  value="Add Member"/></td>
                <td><a href="#close" class="btn-custom-small" >Close</a></td>
              </tr> </table>
          </center>
        </div>
      </div>
    </form>
  </div>
</div>


<!--==== Modal EDIT ======-->
<div id="editHealth" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <?php
    if (isset($_POST['editDetails'])) {
      $id = $_POST['id'];

      $result_st = mysql_query("SELECT * FROM steering_committee WHERE id='$id'");
      while ($row = mysql_fetch_array($result_st)) {
        $job_group = $row['job_group'];
        $ministry = $row['ministry'];
        $full_name = $row['name'];
        $mobile = $row['mobile'];
        $email = $row['email'];
        $id=$row['id'];
      }
    }
    if (isset($_POST['submitEditMember'])) {
      $id = $_POST['id'];
      $job_group = $_POST['job_group'];
      $ministry = $_POST['ministry'];
      $full_name = $_POST['full_name'];
      $mobile = $_POST['mobile'];
      $email = $_POST['email'];
    
      $job_group = addslashes(trim($job_group));
      $ministry = addslashes(trim($ministry));
      $full_name = addslashes(trim($full_name));
      $mobile = addslashes(trim($mobile));
      $email = addslashes(trim($email));
      
      $query = ( "UPDATE steering_committee SET
          job_group ='$job_group',
          ministry ='$ministry',
          name ='$full_name',
          mobile ='$mobile',
          email ='$email'
           WHERE id='$id' " );
      mysql_query($query) or die(mysql_error("Could not enter"));
      $messageToUser = "Record Edited Successfully!";

      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];
      $action = "Edited \"Health Contact\" ";
      $description = "Record ID: " . $steering_name . " Edited";
      $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      funclogAdminData($arrLogAdminData);
    }
    ?>
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <h1 class="form-title">Edit Steering Committee Member Details</h1>
      <div style="padding: 5px;">
      <!--left div-->
        <div style="width:49%;margin-left:35%;">
          <table border="0"  cellpadding="0" cellspacing="0" width="100%">
            <thead>
              <tr>
                <td>Ministry </td>
                <td>
                  <?php
                  $tablename = 'dropdown_ministry';
                  $fields = 'id, ministry';
                  $where = '1=1 order by ministry asc';
                  $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                  ?>
                  <select id="ministry" name="ministry" class="input_select_p compact" required >
                    <option value="">Choose Ministry</option>
                    <option value="<?php echo $ministry; ?>" selected="selected"><?php echo $ministry; ?></option>
                    
                    <?php foreach ($insertformdata as $insertformdatacab) { ?>
                      <option value="<?php echo $insertformdatacab['ministry']; ?>"><?php echo $insertformdatacab['ministry']; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Full Name</td><td><input type="text" name="full_name" class="input_textbox_p compact" value="<?php echo $full_name; ?>" required/></td>
              </tr>
             <tr>
                <td> Contact Phone </td><td><input type="text" name="mobile" id="mobile" class="input_textbox_p compact" placeholder="254" value="<?php echo $mobile; ?>" onKeyUp="isNumeric(this.id);"/><span id="mobileSpan"></span></td>
              </tr>
                <tr>
                <td> Contact Email </td><td><input type="email" name="email" class="input_textbox_p compact" value="<?php echo $email; ?>" /></td>
              </tr>
                  <tr>
                <td>Job Group </td><td><input type="text" name="job_group" class="input_textbox_p compact" value="<?php echo $job_group; ?>" /></td>
              </tr> 
                   <tr>
                <td><input type="hidden" name="id" class="input_textbox_p compact" value="<?php echo $id; ?>" /></td>
              </tr> 
          </table >
          <br/>
          <center>
            <table> <tr>
                <td><input type="submit" class="btn-custom-small" name="submitEditMember"  value="update Member Details"/></td>
                <td><a href="#close" class="btn-custom-small" >Close</a></td>
              </tr> </table>
          </center>
        </div>
           <div class="vclear"></div>
      </div> 
    </form>
  </div>
</div>



<!--===== Modal View ===========================-->
<div id="viewMoH" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <h1 class="form-title">View Health Contact Details</h1>
    <?php
    if (isset($_GET['viewDetails'])) {
      $id = $_GET['id'];

      $result_st = mysql_query("SELECT * FROM steering_committee WHERE id='$id'");
      while ($row = mysql_fetch_array($result_st)) {
         $job_group = $row['job_group'];
        $ministry = $row['ministry'];
        $full_name = $row['name'];
        $mobile = $row['mobile'];
        $email = $row['email'];
        $id=$row['id'];
      }
    }
    ?>
    <div style="padding: 5px;">
        <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <div style="padding: 5px;">
      <!--left div-->
        <div style="width:49%;margin-left:35%;">
          <table border="0"  cellpadding="0" cellspacing="0" width="100%">
            <thead>
              <tr>
                <td>Ministry </td>
                <td>
                  <?php
                  $tablename = 'dropdown_ministry';
                  $fields = 'id, ministry';
                  $where = '1=1 order by ministry asc';
                  $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                  ?>
                  <select id="ministry" name="ministry" class="input_select_p compact" required  disabled>
                    <option value="">Choose Ministry</option>
                    <option value="<?php echo $ministry; ?>" selected="selected"><?php echo $ministry; ?></option>
                    
                    <?php foreach ($insertformdata as $insertformdatacab) { ?>
                      <option value="<?php echo $insertformdatacab['ministry']; ?>"><?php echo $insertformdatacab['ministry']; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Full Name</td><td><input type="text" name="full_name" class="input_textbox_p compact" value="<?php echo $full_name; ?>" required disabled/></td>
              </tr>
             <tr>
                <td> Contact Phone </td><td><input type="text" name="mobile" id="mobile" class="input_textbox_p compact" placeholder="254" value="<?php echo $mobile; ?>" onKeyUp="isNumeric(this.id);" disabled/><span id="mobileSpan"></span></td>
              </tr>
                <tr>
                <td> Contact Email </td><td><input type="email" name="email" class="input_textbox_p compact" value="<?php echo $email; ?>" disabled/></td>
              </tr>
                  <tr>
                <td>Job Group </td><td><input type="text" name="job_group" class="input_textbox_p compact" value="<?php echo $job_group; ?>" disabled/></td>
              </tr> 
                   <tr>
                <td><input type="hidden" name="id" class="input_textbox_p compact" value="<?php echo $id; ?>" disabled/></td>
              </tr> 
          </table >
          <br/>
          <center>
            <table> <tr>
                <td><a href="#close" class="btn-custom-small" >Close</a></td>
              </tr> </table>
          </center>
        </div>
           <div class="vclear"></div>
      </div> 
    </form>
    </div>
    <div class="vclear"></div> 
  </div>
</div>

<script>
      //GET ministry
      function get_ministry(txt) {
        $.post('ajax_dropdown.php', {checkval: 'ministry', job_group: txt}).done(function(data) {
          $('#ministry').html(data);//alert(data);
        });
      }
      //GET ministry
      function get_ministry2(txt) {
        $.post('ajax_dropdown.php', {checkval: 'ministry', job_group: txt}).done(function(data) {
          $('#ministry2').html(data);//alert(data);
        });
      }
</script>
<script>

//==============================  block return key from submitting form ===============================
  document.onkeypress = function(e) {
    e = e || window.event;
    if (typeof e != 'undefined') {
      var tgt = e.target || e.srcElement;
      if (typeof tgt != 'undefined' && /input/i.test(tgt.nodeName))
        return (typeof e.keyCode != 'undefined') ? e.keyCode != 13 : true;
    }
    console.log("enter Block workin...");
  }



</script>



<!-- datatables -->
<script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="css/dataTables.css">

<script type="text/javascript">
  $(document).ready(function() {
      $('#data-table').dataTable();
  } );
</script>

