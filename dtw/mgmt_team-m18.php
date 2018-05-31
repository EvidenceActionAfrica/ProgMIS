<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
require_once('includes/db_functions.php');
require_once("includes/logTracker.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes


$evidenceaction = new EvidenceAction();

require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");

$image = new image;
$insertFile = new UploadFIle;


if (isset($_POST['uploadCSV'])) {
$table = "mgmt_team";
   if ($_FILES["file"]["error"] > 0) {
  	echo "Error: " . $_FILES["file"]["error"] . "<br>";
	} else { 
	  $temp=$_FILES["file"]["tmp_name"];
    $csvMessage="Upload Successful";
  }


    $filename = $image->upload_image($temp);
    $csvMessage = $insertFile->insertFile($filename, $table); 
}

//Privileges settings
$priv_mail = $_SESSION['staff_email'];
$resPriv = mysql_query("select * from staff where staff_email='$priv_mail'");

while ($row = mysql_fetch_array($resPriv)) {
  $priv_mgmt_team = $row["priv_mgmt_team"];
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
          $query = "DELETE FROM mgmt_team WHERE id='$deleteid'";
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
          $mobile1 = $_POST['mobile1'];
          $mobile2 = $_POST['mobile2'];
          $email1= $_POST['email1'];
          $email2 = $_POST['email2'];

          $searchQuery = "SELECT * FROM mgmt_team WHERE ministry LIKE '%$ministry%'
              AND name LIKE '%$fullname%'
              AND mobile1 LIKE '%$mobile1%'
              AND mobile2 LIKE '%$mobile2%'    
              AND email1 LIKE '%$email1%'
              AND email2 LIKE '%$email2%' order by ministry asc ";
         
          //echo $searchQuery;
          
          $result_set = mysql_query($searchQuery);
        } else {
          $result_set = mysql_query("SELECT * FROM mgmt_team order by job_group,ministry  asc");
        }
        ?>

        <form action="#">
<!--          <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />-->
          <img src="images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
          <?php if ($priv_mgmt_team >= 4) { ?>
            <a class="btn-custom-small" href="#importCSV">Import</a>
          <?php } ?>
            <b style="margin-left:10%;width: 100px; font-size:1.5em;">Management Team Contacts</b>
        <?php if($priv_mgmt_team>=1){?>
          <a class="btn-custom-small" href="PHPExcel/csv_export.php?table_name=mgmt_team&file_name=mgmt_team">Export to Excel</a>
        <?php } if($priv_mgmt_team>=2){?>
          <a class="btn-custom-small" href="#addmgmt_teamMember">Add Member</a>
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
                  <th align="center" width="15%"><input type="text" style="width: 98%" name="mobile1"  value="<?php echo $mobile1; ?>"/></th>        
                  <th align="center" width="30%"><input type="text" style="width: 98%" name="email1"  value="<?php echo $email1; ?>"/></th>

                  <th align="center" width="15%" colspan="3"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                </tr>    
              </thead>
            </table>
          </form>
              <table id="data-table" class="table table-responsive table-hover table-stripped">
                  <thead>
                  <th align="Left" width="15%">Ministry</th>
                  <th align="Left" width="20%">Full Name</th>
                  <th align="Left" width="15%">Mobile1</th>
                  <th align="Left" width="27%">Email1</th>
                  <th>Job Group</th>
                  <?php if ($priv_mgmt_team >= 4) { ?>                 
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
                $mobile1 = $row['mobile1'];
                $mobile2 = $row['mobile2'];
                $email1 = $row['email1'];
                $email2 = $row['email2'];
                if($priv_mgmt_team>=3){
                $link = "mgmt_team.php?id=$id&editDetails=1#editHealth";
                  }
		 
 else{
                $link = "mgmt_team.php#";
  
 }
                ?> 
                <tr style="border-bottom: 1px solid #B4B5B0;">

                  <td align="left" > <?php echo "<a href=$link>".$ministry."</a>"; ?> </td>
                  <td align="left"> <?php echo "<a href=$link>".$fullname."</a>"; ?> </td>
                  <td align="left"><?php

                    echo "<a href=$link>".substr($mobile1, 0, 12);
                    if (strlen($mobile1) > 12)
                      echo "..";
                      echo "</a>";
                    ?>
                  </td>
                  
                  <td align="left"><?php

                    echo "<a href=$link>".substr($email1, 0, 30);
                    if (strlen($email1) > 30)
                      echo "..";
                       echo "</a>";
                    ?>
                  </td>
                  <td align="left"> <?php echo "<a href=$link>".$job_group."</a>"; ?> </td> 

                  <?php if ($priv_mgmt_team >= 4) { ?>
                    <td align="center" ><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="images/icons/delete.png" height="20px"></a></td>
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
<div id="addmgmt_teamMember" class="modalDialog">
  <div style="width:650px">
    <a href="#close" title="Close" class="close">X</a>
    <?php
    $formSubmitted = false;
    if (isset($_POST['submitMember'])) {
        
     
      //Post Values to DB
      $job_group = $_POST['job_group'];
      $ministry = $_POST['ministry'];
      $full_name = $_POST['full_name'];
      $mobile1 = $_POST['mobile1'];
      $mobile2 = $_POST['mobile2'];
      
      $email1 = $_POST['email1'];
      $email2 = $_POST['email2'];
      
      $job_group = addslashes(trim($job_group));
      $ministry = addslashes(trim($ministry));
      $full_name = addslashes(trim($full_name));
      $mobile1 = addslashes(trim($mobile1));
      $mobile2 = addslashes(trim($mobile2));

      $email1 = addslashes(trim($email1));
      $email2 = addslashes(trim($email2));
    
      $query =("INSERT INTO mgmt_team (
            `job_group`,
            `ministry`,
            `name`,
            `mobile1`,
           `mobile2`, 
            `email1`,
            `email2`
            )
        VALUES (
            '$job_group',
            '$ministry',
            '$full_name',
            '$mobile1',
            '$mobile2',    
            '$email1',
             '$email2')");
    // echo $query;
      
      mysql_query($query) or die(mysql_error());
      $messageToUser = "Record Added Successfully!";


      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];
      $action = "Added \"Steering Committee Member\" ";
      $description = "Record ID: " . $mgmt_team_name . " added";
      $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      funclogAdminData($arrLogAdminData);
    }
    ?>
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <h1 class="form-title">Add Management Team Member</h1>
      <div style="padding: 5px; overflow-y: scroll">
        <!--left div-->
       <center> <div style="">
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
                <td>Full Name</td><td><input type="text" name="full_name" class="input_textbox" value="" required/></td>
              </tr>
             <tr>
                <td> Contact Phone1 </td><td><input type="text" name="mobile1" id="mobile2" class="input_textbox" placeholder="254" onKeyUp="isNumeric(this.id);"/><span id="mobile1Span"></span></td>
              </tr>
             <tr>
                <td> Contact Phone2 </td><td><input type="text" name="mobile2" id="mobile2" class="input_textbox" placeholder="254" onKeyUp="isNumeric(this.id);"/><span id="mobile2Span"></span></td>
              </tr>
             
                <tr>
                <td> Contact Email1 </td><td><input type="email" name="email1" class="input_textbox" /></td>
              </tr>
              <tr>
                <td> Contact Email2 </td><td><input type="email" name="email2" class="input_textbox" /></td>
              </tr>
 
                  <tr>
                <td>Job Group </td><td><input type="text" name="job_group" class="input_textbox" /></td>
              </tr>   
          </table >
          <br/>
          <center>
            <table> <tr>
                <td><input type="submit" class="btn-custom" name="submitMember"  value="Add Member"/></td>
                <td><a href="#close" class="btn-custom" >Close</a></td>
              </tr> </table>
          </center>
        </div></center>
      </div>
    </form>
  </div>
</div>


<!--==== Modal EDIT ======-->
<div id="editHealth" class="modalDialog">
  <div  style="width:480px">
    <a href="#close" title="Close" class="close">X</a>
    <?php
    if (isset($_GET['editDetails'])) {
      $id = $_GET['id'];

      $result_st = mysql_query("SELECT * FROM mgmt_team WHERE id='$id'");
      while ($row = mysql_fetch_array($result_st)) {
        $job_group = $row['job_group'];
        $ministry = $row['ministry'];
        $full_name = $row['name'];
        $mobile1 = $row['mobile1'];
        $mobile2 = $row['mobile2'];
 
        $email1 = $row['email1'];
        $email2 = $row['email2'];

        $id=$row['id'];
      }
    }
    if (isset($_POST['submitEditMember'])) {
      $id = $_POST['id'];
      $job_group = $_POST['job_group'];
      $ministry = $_POST['ministry'];
      $full_name = $_POST['full_name'];
      $mobile1 = $_POST['mobile1'];
      $mobile2 = $_POST['mobile2'];
   
      $email1 = $_POST['email1'];
      $email2 = $_POST['email2'];
    
      $job_group = addslashes(trim($job_group));
      $ministry = addslashes(trim($ministry));
      $full_name = addslashes(trim($full_name));
    
      $mobile1 = addslashes(trim($mobile1));
      $mobile2 = addslashes(trim($mobile2));
      
      $email1 = addslashes(trim($email1));
      $email2 = addslashes(trim($email2));
      
      $query = ( "UPDATE mgmt_team SET
          job_group ='$job_group',
          ministry ='$ministry',
          name ='$full_name',
          mobile1 ='$mobile1',
          mobile2 ='$mobile2',
          email1 ='$email1',
          email2 ='$email2'
    
           WHERE id='$id' " );
      //echo $query;
      mysql_query($query) or die(mysql_error("Could not enter"));
      $messageToUser = "Record Edited Successfully!";

      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];
      $action = "Edited \"Health Contact\" ";
      $description = "Record ID: " . $mgmt_team_name . " Edited";
      $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      funclogAdminData($arrLogAdminData);
    }
    ?>
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <h1 class="form-title">Edit Management Team Member Details</h1>
      <div style="padding: 5px;">
      <center>
        <div style="">
          <table border="0"  cellpadding="0" cellspacing="0" width="80%">
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
                <td width="115px">Full Name</td><td><input type="text" name="full_name" class="input_textbox" value="<?php echo $full_name; ?>" required/></td>
              </tr>
             <tr>
                <td> Contact Phone1 </td><td><input type="text" name="mobile1" id="mobile1" class="input_textbox" placeholder="254" value="<?php echo $mobile1; ?>" onKeyUp="isNumeric(this.id);"/><span id="mobile1Span"></span></td>
              </tr>
              <tr>
                <td> Contact Phone2 </td><td><input type="text" name="mobile2" id="mobile2" class="input_textbox" placeholder="254" value="<?php echo $mobile2; ?>" onKeyUp="isNumeric(this.id);"/><span id="mobile2Span"></span></td>
              </tr>
  
                <tr>
                <td> Contact Email1 </td><td><input type="email" name="email1" class="input_textbox" value="<?php echo $email1; ?>" /></td>
              </tr>
              <tr>
                <td> Contact Email2 </td><td><input type="email" name="email2" class="input_textbox" value="<?php echo $email2; ?>" /></td>
              </tr>
 
                  <tr>
                <td>Job Group </td><td><input type="text" name="job_group" class="input_textbox" value="<?php echo $job_group; ?>" /></td>
              </tr> 
                   <tr>
                <td><input type="hidden" name="id" class="input_textbox" value="<?php echo $id; ?>" /></td>
              </tr> 
          </table >
          <br/>
          
            <div> <tr>
                <input type="submit" class="btn-custom" name="submitEditMember"  value="update Member Details"/>
                <a href="#close" class="btn-custom" >Close</a>
              </tr> </div>
          </center>
        </div>
           <div class="vclear"></div>
      </div> 
    </form>
  </div>
</div>




<!--===== Modal Import ===========================-->
<div id="importCSV" class="modalDialog">
  <div style="width:380px">
    <a href="#close" title="Close" class="close">X</a>
    <div >
      <h1 class="form-title">Upload management team contacts </h1><br/>
    </div>
<?php
    if(isset($csvMessage)){echo '<h4 style="color:#050000;background-color:#A2FF7E;text-align:center;">'.$csvMessage.'</h4>'; }
    ?>
    <center>
      <div style="padding: 5px; margin: 0px auto">
   
        <form action="" method="post"
                                      enctype="multipart/form-data">
                                    <label for="file">Filename:</label>
                                    <input type="file" name="file" id="file"/>
                                        <?php if ($priv_mgmt_team >= 4) { ?>
                                            <input type="submit" id='btnSubmit' name="uploadCSV" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>
                                        <?php 
                                            }
                                             ?>

                                </form>
      </div>
    </center>
    <br/>
    <center>
      <div>
        <a href="#close" class="btn-custom" > Close</a>
      </div>
    </center>
  </div>
  </div>
<!--===== Modal View ===========================-->
<div id="viewMoH" class="modalDialog" >
  <div style="width:430px" >
    <a href="#close" title="Close" class="close">X</a>
    <h1 class="form-title">View Management Team Member Details</h1>
    <?php
    if (isset($_GET['viewDetails'])) {
      $id = $_GET['id'];

      $result_st = mysql_query("SELECT * FROM mgmt_team WHERE id='$id'");
      while ($row = mysql_fetch_array($result_st)) {
         $job_group = $row['job_group'];
        $ministry = $row['ministry'];
        $full_name = $row['name'];
        $mobile1 = $row['mobile1'];
        $mobile2 = $row['mobile2'];
        $email1 = $row['email1'];
        $email2 = $row['email2'];
 
        $id=$row['id'];
      }
    }
    ?>
    <div style="padding: 5px;">
        <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <div style="padding: 5px;">
      <!--left div-->
        <div style="">
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
                <td>Full Name</td><td><input type="text" name="full_name" class="input_textbox" value="<?php echo $full_name; ?>" required disabled/></td>
              </tr>
             <tr>
                <td> Contact Phone1 </td><td><input type="text" name="mobile1" id="mobile1" class="input_textbox" placeholder="254" value="<?php echo $mobile1; ?>" onKeyUp="isNumeric(this.id);" disabled/><span id="mobileSpan1"></span></td>
              </tr>
             <tr>
                <td> Contact Phone2 </td><td><input type="text" name="mobile2" id="mobile2" class="input_textbox" placeholder="254" value="<?php echo $mobile2; ?>" onKeyUp="isNumeric(this.id);" disabled/><span id="mobileSpan2"></span></td>
              </tr>

                <tr>
                <td> Contact Email1 </td><td><input type="email" name="email1" class="input_textbox" value="<?php echo $email1; ?>" disabled/></td>
              </tr>
                <tr>
                <td> Contact Email2 </td><td><input type="email" name="email2" class="input_textbox" value="<?php echo $email2; ?>" disabled/></td>
              </tr>

                <tr>
                <td>Job Group </td><td><input type="text" name="job_group" class="input_textbox" value="<?php echo $job_group; ?>" disabled/></td>
              </tr> 
                   <tr>
                <td><input type="hidden" name="id" class="input_textbox" value="<?php echo $id; ?>" disabled/></td>
              </tr> 
          </table >
          <br/>
          <center>
            <table> <tr>
                <td><a href="#close" class="btn-custom" >Close</a></td>
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


