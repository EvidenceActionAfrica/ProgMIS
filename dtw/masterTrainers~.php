<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
require_once("includes/logTracker.php");

//Privileges settings
$priv_mail = $_SESSION['staff_email'];
$resPriv = mysql_query("select * from staff where staff_email='$priv_mail'");

while ($row = mysql_fetch_array($resPriv)) {
  $priv_master_trainers = $row["priv_master_trainers"];
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
      <div class="contentBody" >
        <!--================================================-->
        <?php
        //Delete
        if (isset($_GET['deleteid'])) {
          $deleteid = $_GET['deleteid'];
          $query = "DELETE FROM master_trainers WHERE id='$deleteid'";
          $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
          //log entry
          $staff_id = $_SESSION['staff_id'];
          $staff_email = $_SESSION['staff_email'];
          $staff_name = $_SESSION['staff_name'];
          $action = "Delete \"Master Trainers\" ";
          $description = "Record ID: " . $deleteid . " deleted";
          $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
          funclogAdminData($arrLogAdminData);
        }

        if (isset($_POST['search_table'])) {
          $full_name = $_POST['full_name'];
          $ministry = $_POST['ministry'];
          $posting_station = $_POST['posting_station'];
          $job_class = $_POST['job_class'];
          $county = $_POST['county'];
          $national = $_POST['national'];
          $status = $_POST['status'];
          $phone_number = $_POST['phone_number'];
          $searchQuery = "SELECT * FROM master_trainers WHERE full_name LIKE '%$full_name%'
              AND ministry LIKE '%$ministry%'
              AND posting_station LIKE '%$posting_station%'
              AND job_class LIKE '%$job_class%'
              AND county LIKE '%$county%'
              AND national LIKE '%$national%'
              AND status LIKE '%$status%'
              AND phone_number LIKE '%$phone_number%' order by full_name asc ";
          $result_set = mysql_query($searchQuery);
        } else {
          $result_set = mysql_query("SELECT * FROM master_trainers order by full_name asc");
        }
        ?>
  <style>
        table tr td a{

          text-decoration: none;
          color:rgb(0,0,0);
        }
        </style>
        <form action="#">
          <img src="images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
          <b style="margin-left:20%;width: 100px; font-size:1.5em;">Master Trainers</b>
          <?php if ($priv_master_trainers >= 1) { ?>
          <a class="btn-custom-small" href="PHPExcel/AdminData/masterTrainers.php?full_name=<?php echo $full_name; ?>&ministry=<?php echo $ministry; ?>&posting_station=<?php echo $posting_station; ?>&job_class=<?php echo $job_class; ?>&county=<?php echo $county; ?>&national=<?php echo $national; ?>&status=<?php echo $status; ?>&phone_number=<?php echo $phone_number; ?>">Export to Excel</a>
          <?php } if ($priv_master_trainers >= 2) { ?>
          <a class="btn-custom-small" href="#addMasterTrainer">Add Master Trainer</a>
          <?php } ?>
        </form>
        <br/>
        <div style=" margin-right: 20px">
          <form method="post">
            <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
              <thead>
                <tr style="">
                  <th align="center" width="10%"><input type="text" style="width: 98%" name="full_name"  value="<?php echo $full_name ?>"/></th>
                  <th align="center" width="10%">
                    <select name="ministry"  style="width: 98%;" onchange="submitForm();">
                      <option value=''<?php if ($ministry == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT * FROM dropdown_ministry ORDER BY ministry ASC";
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
                  <th align="center" width="10%"><input type="text" style="width: 98%" name="posting_station"  value="<?php echo $posting_station ?>"/></th>
                  <th align="center" width="5%"><input type="text" style="width: 98%" name="job_class"  value="<?php echo $job_class ?>"/></th>
                  <th align="center" width="10%"><input type="text" style="width: 98%" name="county"  value="<?php echo $county ?>"/></th>
                  <th align="center" width="10%"><input type="text" style="width: 98%" name="phone_number"  value="<?php echo $phone_number ?>"/></th>
                  <th align="center" width="10%">
                    <select  name="status" style="width: 100%" onchange="submitForm();">
                      <option value=''<?php if ($status == '') echo 'selected'; ?> ></option>
                      <option value='Active'<?php if ($status == 'Active') echo 'selected'; ?>>Active</option>
                      <option value='Inactive'<?php if ($status == 'Inactive') echo 'selected'; ?>>Inactive</option>
                      <option value='Dropped'<?php if ($status == 'Dropped') echo 'selected'; ?>>Dropped</option>
                      <option value='Sabbatical'<?php if ($status == 'Sabbatical') echo 'selected'; ?>>Sabbatical</option>
                    </select>
                  </th>
                  <th align="center" width="10%">
                    <select  name="national" style="width: 100%" onchange="submitForm();">
                      <option value=''<?php if ($national == '') echo 'selected'; ?> ></option>
                      <option value='Regional'<?php if ($national == 'Regional') echo 'selected'; ?>>Regional</option>
                      <option value='National'<?php if ($national == 'National') echo 'selected'; ?>>National</option>
                      <option value='Regional/National'<?php if ($national == 'Regional/National') echo 'selected'; ?>>Regional/National</option>
                    </select>
                  </th>
                  <th align="center" width="10%" colspan="3"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                  </tr>
              </thead>
            </table>
              <table id="data-table" class="table table-responsive table-hover table-stripped">
                  <thead>
                  <tr>
                  <th align="Left" width="10%">Full Name</th>
                  <th align="Left" width="10%">Ministry</th>
                  <th align="Left" width="10%">Posting</th>
                  <th align="Left" width="5%">Job<br/>Class</th>
                  <th align="Left" width="10%">County</th>
                  <th align="Left" width="10%">Mobile</th>
                  <th align="Left" width="10%">Status</th>
                  <th align="Left" width="10%">National</th>
               
                  <?php if ($priv_master_trainers >= 3) { ?>
                    <th align="center" width="4%">Edit</th>
                  <?php } ?>
                  <?php if ($priv_master_trainers >= 4) { ?>
                    <th align="center" width="4%">Del</th>
                  <?php } ?>

                </tr>
              </thead>
          
            <tbody>
              <?php
              while ($row = mysql_fetch_array($result_set)) {
                $id = $row['id'];
                $mtid = $row['mtid'];
                $full_name = $row['full_name'];
                $ministry = $row['ministry'];
                $title = $row['title'];
                $job_class = $row['job_class'];
                $posting_station = $row['posting_station'];
                $province = $row['province'];
                $county = $row['county'];
                $national = $row['national'];
                $phone_number = $row['phone_number'];
                $phone_number2 = $row['phone_number2'];
                $recruitment = $row['recruitment'];
                $status = $row['status'];
                $email = $row['email'];
                $email2 = $row['email2'];
                if ($priv_master_trainers >= 1) {
                $link="masterTrainers.php?viewDetails=1&id=$id#viewMT";
                }else{
                    $link="#";
                }
                ?>
                <tr>
                  <td align="left" width="10%"> <?php echo "<a href=$link>".$full_name."</a>"; ?> </td>
                  <td align="left" width="10%"> <?php echo "<a href=$link>".$ministry."</a>"; ?> </td>
                  <td align="left" width="10%"> <?php echo "<a href=$link>".$posting_station."</a>"; ?> </td>
                  <td align="left" width="5%"> <?php echo "<a href=$link>".$job_class."</a>"; ?> </td>
                  <td align="left" width="10%"> <?php echo "<a href=$link>". $county."</a>"; ?>  </td>
                  <td align="left" width="10%"> <?php echo "<a href=$link>".$phone_number."</a>"; ?>  </td>
                  <td align="left" width="10%"> <?php echo "<a href=$link>".$status."</a>"; ?>  </td>
                  <td align="left" width="10%"> <?php echo "<a href=$link>".$national."</a>"; ?>  </td>
                  <?php /*if ($priv_master_trainers >= 1) { ?>
                    <!--view button-->
                    <form method="POST" action="#viewMT">
                      <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                      <td align="center" width="4%"><input type="submit" name="viewDetails" value="" style="background: url(images/icons/view2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                    </form>

                  <?php } */?>
                  <?php if ($priv_master_trainers >= 3) { ?>
                    <!--edit button-->
                    <form method="POST" action="#editMT">
                      <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                      <td><input type="submit" name="editDetails" value="" style="background: url(images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                    </form>
                  <?php } ?>
                  <?php if ($priv_master_trainers >= 4) { ?>
                    <td ><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="images/icons/delete.png" height="20px"></a></td>
                  <?php } ?>
                </tr>
          
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
<div id="addMasterTrainer" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <?php
    if (isset($_POST['submitAddMT'])) {
      //Generate County ID
      $r1 = mysql_query("SELECT id FROM master_trainers ORDER BY id DESC LIMIT 1");
      while ($row = mysql_fetch_array($r1)) {
        $last_MT_id = $row['id'];
        $new_MT_id = $last_MT_id + 1;
      }
      $mtid = 'MT' . '' . sprintf("%03d", $new_MT_id);

      //Post Values to DB
      $full_name = $_POST['full_name'];
      $ministry = $_POST['ministry'];
      $title = $_POST['title'];
      $job_class = $_POST['job_class'];
      $posting_station = $_POST['posting_station'];
      $province = $_POST['province'];
      $county = $_POST['county'];
      $national = $_POST['national'];
      $phone_number = $_POST['phone_number'];
      $phone_number2 = $_POST['phone_number2'];
      $recruitment = $_POST['recruitment'];
      $status = $_POST['status'];
      $email = $_POST['email'];
      $email2 = $_POST['email2'];

      $full_name = addslashes(trim($full_name));
      $ministry = addslashes(trim($ministry));
      $title = addslashes(trim($title));
      $job_class = addslashes(trim($job_class));
      $posting_station = addslashes(trim($posting_station));
      $province = addslashes(trim($province));
      $county = addslashes(trim($county));
      $national = addslashes(trim($national));
      $phone_number = addslashes(trim($phone_number));
      $phone_number2 = addslashes(trim($phone_number2));
      $recruitment = addslashes(trim($recruitment));
      $status = addslashes(trim($status));
      $email = addslashes(trim($email));
      $email2 = addslashes(trim($email2));

      $query = ( "INSERT INTO master_trainers
        ( mtid,
          full_name,
          ministry,
          title,
          job_class,
          posting_station,
          province,
          county,
          national,
          phone_number,
          phone_number2,
          recruitment,
          status,
          email,
          email2  )
        VALUES (
            '$mtid',
            '$full_name',
            '$ministry',
            '$title',
            '$job_class',
            '$posting_station',
            '$province',
            '$county',
            '$national',
            '$phone_number',
            '$phone_number2',
            '$recruitment',
            '$status',
            '$email',
            '$email2' )" );
      mysql_query($query) or die(mysql_error());
      $messageToUser = "$full_name Added Successfully!";
      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];
      $action = "Added \"Master Trainer\" ";
      $description = "Record ID: " . $mtid . "/" . $full_name . " Added";
      $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      funclogAdminData($arrLogAdminData);
    }
    ?>
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <div >
        <h1>Add Master Trainer</h1>
      </div>
      <div style="padding: 5px;">
        <!--left div-->
        <div style="float: left; width: 49%;">
          <!--<h3 >Geographic Details</h3>-->
          <table border="0">
            <thead>
              <tr>
                <td>Full Name </td><td><input type="text" name="full_name" class="input_textbox" placeholder="" value="" style="width:200px;" required /></td>
              </tr>
              <tr>
                <td>Ministry </td>
                <td valign="middle">
                  <select name="ministry"  class="input_select" style="width:210px;" required >
                    <option value=''<?php if ($ministry == '') echo 'selected'; ?> ></option>
                    <?php
                    $sql = "SELECT * FROM dropdown_ministry ORDER BY ministry ASC";
                    $result = mysql_query($sql);
                    while ($rows = mysql_fetch_array($result)) { //loop table rows
                      ?>
                      <option value="<?php echo $rows['ministry']; ?>"<?php
                      if ($ministry == $rows['ministry']) {
                        echo 'selected';
                      }
                      ?>><?php echo $rows['ministry']; ?></option>
                            <?php } ?>
                  </select> &nbsp; 
                  <?php if ($priv_master_trainers >= 3) { ?>
                  <a href="dropdown_settings.php"><img src="images/icons/mainEdit.png" style="vertical-align: middle" height="30px"/></a>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td>Title </td><td><input type="text" name="title" class="input_textbox" placeholder="" value="" style="width:200px;"  /></td>
              </tr>
              <tr>
                <td>Job Class </td>
                <td>
                  <select name="job_class"  class="input_select" style="width:210px;" required >
                    <option value=''<?php if ($job_class == '') echo 'selected'; ?> ></option>
                    <?php
                    $sql = "SELECT * FROM dropdown_jobclass ORDER BY job_class ASC";
                    $result = mysql_query($sql);
                    while ($rows = mysql_fetch_array($result)) { //loop table rows
                      ?>
                      <option value="<?php echo $rows['job_class']; ?>"<?php
                      if ($job_class == $rows['job_class']) {
                        echo 'selected';
                      }
                      ?>><?php echo $rows['job_class']; ?></option>
                            <?php } ?>
                  </select>
                </td>
              </tr>               
              <tr>
                <td>Posting Station </td><td><input type="text" name="posting_station" class="input_textbox" placeholder="" value="" style="width:200px;"  /></td>
              </tr>
              <tr>
                <td>County </td>
                <td>
                  <select name="county"  class="input_select" style="width:210px;"  >
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
              </tr>
            </thead>
          </table >
        </div>
        <!--Right div-->
        <div style="float: left; width: 49%">
          <!--<h3 >MT Information Details</h3>-->
          <table border="0">
            <thead>
              <tr>
                <td>Level</td>
                <td>
                  <select  name="national" class="input_select" style="width:210px;"  >
                    <option value='' ></option>
                    <option value='Regional'>Regional</option>
                    <option value='National'>National</option>
                    <option value='Regional/National'>Regional/National</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Phone Number </td><td><input type="text" name="phone_number" id="phone_number" class="input_textbox" maxlength="12" value="254" style="width:200px;" required placeholder="254" onKeyUp="isNumeric(this.id);"/><span id="phone_numberSpan"></span></td>
              </tr>
              <tr>
                <td>Phone Number 2 </td><td><input type="text" name="phone_number2" id="phone_number2" class="input_textbox" maxlength="12" value="254"style="width:200px;"  placeholder="254" onKeyUp="isNumeric(this.id);"/><span id="phone_number2Span"></span></td>
              </tr>
              <tr>
                <td>Year of Recruitment </td>
                <td>
                  <select name="recruitment" class="input_select" style="width:210px;" style="width:200px;" >
                    <option value=""></option>
                    <?php
                    for ($i = 1990; $i <= date('Y'); $i++) :
                      ?>
                      <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Status </td>
                <td>
                  <select  name="status" class="input_select" style="width:210px;"  >
                    <option value=''<?php if ($status == '') echo 'selected'; ?> ></option>
                    <option value='Active'<?php if ($status == 'Active') echo 'selected'; ?>>Active</option>
                    <option value='Inactive'<?php if ($status == 'Inactive') echo 'selected'; ?>>Inactive</option>
                    <option value='Dropped'<?php if ($status == 'Dropped') echo 'selected'; ?>>Dropped</option>
                    <option value='Sabbatical'<?php if ($status == 'Sabbatical') echo 'selected'; ?>>Sabbatical</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Primary Email </td><td><input type="email" name="email" class="input_textbox" placeholder="xyz@evidenceaction.org"  /></td>
              </tr>
              <tr>
                <td>Secondary Email</td><td><input type="email" name="email2" class="input_textbox" placeholder="xyz@evidenceaction.org"  /></td>
              </tr>
            </thead>
          </table >
        </div>
      </div>
      <div class="vclear"></div>
      <br/>
      <center>
        <div>
          <input type="submit" class="btn-custom" name="submitAddMT"  value="Add Master Trainer"/>
        </div>
      </center>
    </form>
  </div>
</div>


<!--==== Modal EDIT ======-->
<div id="editMT" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <?php
    if (isset($_POST['editDetails'])) {
      $id = $_POST['id'];

      $result_st = mysql_query("SELECT * FROM master_trainers WHERE id='$id'");
      while ($row = mysql_fetch_array($result_st)) {
        $id = $row['id'];
        $mtid = $row['mtid'];
        $full_name = $row['full_name'];
        $ministry = $row['ministry'];
        $title = $row['title'];
        $job_class = $row['job_class'];
        $posting_station = $row['posting_station'];
        $province = $row['province'];
        $county = $row['county'];
        $national = $row['national'];
        $phone_number = $row['phone_number'];
        $phone_number2 = $row['phone_number2'];
        $recruitment = $row['recruitment'];
        $status = $row['status'];
        $email = $row['email'];
        $email2 = $row['email2'];
      }
    }
    if (isset($_POST['submitEditMT'])) {
      $id = $_POST['id'];
      //$mtid = $_POST['mtid'];
      $full_name = $_POST['full_name'];
      $ministry = $_POST['ministry'];
      $title = $_POST['title'];
      $job_class = $_POST['job_class'];
      $posting_station = $_POST['posting_station'];
      $province = $_POST['province'];
      $county = $_POST['county'];
      $national = $_POST['national'];
      $phone_number = $_POST['phone_number'];
      $phone_number2 = $_POST['phone_number2'];
      $recruitment = $_POST['recruitment'];
      $status = $_POST['status'];
      $email = $_POST['email'];
      $email2 = $_POST['email2'];

      $id = addslashes(trim($id));
      //$mtid = addslashes(trim($mtid));
      $full_name = addslashes(trim($full_name));
      $ministry = addslashes(trim($ministry));
      $title = addslashes(trim($title));
      $job_class = addslashes(trim($job_class));
      $posting_station = addslashes(trim($posting_station));
      $province = addslashes(trim($province));
      $county = addslashes(trim($county));
      $national = addslashes(trim($national));
      $phone_number = addslashes(trim($phone_number));
      $phone_number2 = addslashes(trim($phone_number2));
      $recruitment = addslashes(trim($recruitment));
      $status = addslashes(trim($status));
      $email = addslashes(trim($email));
      $email2 = addslashes(trim($email2));

      //Update Values to DB
      $query = ( "UPDATE master_trainers SET
          full_name ='$full_name',
          ministry ='$ministry',
          title ='$title',
          job_class ='$job_class',
          posting_station ='$posting_station',
          province ='$province',
          county ='$county',
          national ='$national',
          phone_number ='$phone_number',
          phone_number2 ='$phone_number2',
          recruitment ='$recruitment',
          status ='$status',
          email ='$email',
          email2 ='$email2'  WHERE id='$id' " );
      mysql_query($query) or die(mysql_error("Could not enter"));
      $messageToUser = "Record Updated Successfully!";

      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];
      $action = "Edited \"Master Trainer\" ";
      $description = "Record ID: " . $mtid . "/" . $full_name . " Edited";
      $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      funclogAdminData($arrLogAdminData);
    }
    ?>
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <div >
        <h1>Edit Master Trainer Details</h1>
      </div>
      <div style="padding: 5px;">
        <!--left div-->
        <div style="float: left; width: 49%;">
          <!--<h3 >Geographic Details</h3>-->
          <table border="0">
            <thead><input type="hidden" name="id" value="<?php echo $id; ?>"/>
              <tr>
                <td>ID </td><td><input type="text" name="mtid" class="input_textbox"  value="<?php echo $mtid ?>" readonly/></td>
              </tr>
              <tr>
                <td>Full Name *</td><td><input type="text" name="full_name" class="input_textbox" value="<?php echo $full_name ?>" required/></td>
              </tr>
              <tr>
                <td>Ministry</td>
                <td>
                  <select name="ministry"  class="input_select" required>
                    <option value=''<?php if ($ministry == '') echo 'selected'; ?> ></option>
                    <?php
                    $sql = "SELECT * FROM dropdown_ministry ORDER BY ministry ASC";
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
                     <?php if ($priv_master_trainers >= 3) { ?>
                  <a href="dropdown_settings.php"><img src="images/icons/mainEdit.png" style="vertical-align: middle" height="30px"/></a>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td>Title</td><td><input type="text" name="title" class="input_textbox" placeholder="" value="<?php echo $title ?>" /></td>
              </tr>
              <tr>
                <td>Job Class</td>
                <td>
                  <select name="job_class"  class="input_select" required>
                    <option value=''<?php if ($job_class == '') echo 'selected'; ?> ></option>
                    <?php
                    $sql = "SELECT * FROM dropdown_jobclass ORDER BY job_class ASC";
                    $result = mysql_query($sql);
                    while ($rows = mysql_fetch_array($result)) { //loop table rows
                      ?>
                      <option value="<?php echo $rows['job_class']; ?>"<?php
                      if ($job_class == $rows['job_class']) {
                        echo 'selected';
                      }
                      ?>><?php echo $rows['job_class']; ?></option>
                            <?php } ?>
                  </select>
                </td>
              </tr> 
              <tr>
                <td>Posting Station</td><td><input type="text" name="posting_station" class="input_textbox" placeholder="" value="<?php echo $posting_station ?>" /></td>
              </tr>
              <tr>
                <td>County </td>
                <td>
                  <select name="county"  class="input_select" style="width:210px;" >
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
              </tr>
            </thead>
          </table >
        </div>
        <!--Right div-->
        <div style="float: left; width: 49%">
          <!--<h3 >MT Information Details</h3>-->
          <table border="0">
            <thead>
              <tr>
                <td>Level</td>
                <td>
                  <select  name="national" class="input_select" >
                    <option value=''<?php if ($national == '') echo 'selected'; ?>  ></option>
                    <option value='Regional'<?php if ($national == 'Regional') echo 'selected'; ?> >Regional</option>
                    <option value='National'<?php if ($national == 'National') echo 'selected'; ?> >National</option>
                    <option value='Regional/National'<?php if ($national == 'Regional/National') echo 'selected'; ?> >Regional/National</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Phone Number</td><td><input type="text" name="phone_number" class="input_textbox" value="<?php echo $phone_number ?>" required/></td>
              </tr>
              <tr>
                <td>Phone Number 2</td><td><input type="text" name="phone_number2" class="input_textbox" value="<?php echo $phone_number2 ?>"/></td>
              </tr>
              <tr>
                <td>Year of Recruitment</td>
                <td>
                  <select name="recruitment" class="input_select" style="width:210px;" style="width:200px;"  >
                    <option value=""></option>
                    <?php
                    for ($i = 1990; $i <= date('Y'); $i++) :
                      ?>
                      <option value="<?php echo $i; ?>" <?php if ($recruitment == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Status</td>
                <td>
                  <select  name="status" class="input_select" >
                    <option value=''<?php if ($status == '') echo 'selected'; ?> ></option>
                    <option value='Active'<?php if ($status == 'Active') echo 'selected'; ?>>Active</option>
                    <option value='Inactive'<?php if ($status == 'Inactive') echo 'selected'; ?>>Inactive</option>
                    <option value='Dropped'<?php if ($status == 'Dropped') echo 'selected'; ?>>Dropped</option>
                    <option value='Sabbatical'<?php if ($status == 'Sabbatical') echo 'selected'; ?>>Sabbatical</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Primary Email </td><td><input type="email" name="email" class="input_textbox" value="<?php echo $email; ?>"    /></td>
              </tr>
              <tr>
                <td>Secondary Email</td><td><input type="email" name="email2" class="input_textbox" value="<?php echo $email2; ?>"   /></td>
              </tr>
            </thead>
          </table >
        </div>
      </div>
      <br/><br/>
      <center>
        <div>
          <input type="submit" class="btn-custom" name="submitEditMT"  value="Edit MT Details"/>
        </div>
      </center>
    </form>
  </div>
</div>



<!--===== Modal View ===========================-->
<div id="viewMT" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <div >
      <h1>View MT Details</h1>
    </div>
    <?php
    if (isset($_GET['viewDetails'])) {
      $id = $_GET['id'];

      $result_st = mysql_query("SELECT * FROM master_trainers WHERE id='$id'");
      while ($row = mysql_fetch_array($result_st)) {
        $id = $row['id'];
        $mtid = $row['mtid'];
        $full_name = $row['full_name'];
        $ministry = $row['ministry'];
        $title = $row['title'];
        $job_class = $row['job_class'];
        $posting_station = $row['posting_station'];
        $province = $row['province'];
        $county = $row['county'];
        $national = $row['national'];
        $phone_number = $row['phone_number'];
        $phone_number2 = $row['phone_number2'];
        $recruitment = $row['recruitment'];
        $status = $row['status'];
        $email = $row['email'];
        $email2 = $row['email2'];
      }
    }
    ?>
    <div style="padding: 5px;">
      <!--left div-->
      <div style="float: left; width: 49%;">
        <!--<h3 >Geographic Details</h3>-->
        <table border="0">
          <thead>
            <tr>
              <td>ID </td><td><input type="text"class="input_textbox" value="<?php echo $mtid ?>" readonly/></td>
            </tr>
            <tr>
              <td>Full Name</td><td><input type="text"class="input_textbox" value="<?php echo $full_name ?>" readonly/></td>
            </tr>
            <tr>
              <td>Ministry</td><td><input type="text"class="input_textbox" value="<?php echo $ministry ?>" readonly/></td>
            </tr>
            <tr>
              <td>Title</td><td><input type="text" class="input_textbox" value="<?php echo $title ?>" readonly/></td>
            </tr>
            <tr>
              <td>Job Class</td><td><input type="text" class="input_textbox" value="<?php echo $job_class ?>" readonly/></td>
            </tr>
            <tr>
              <td>Posting Station</td><td><input type="text" class="input_textbox" value="<?php echo $posting_station ?>" readonly/></td>
            </tr>
            <tr>
              <td>County</td><td><input type="text"  class="input_textbox" value="<?php echo $county ?>" readonly/></td>
            </tr>
          </thead>
        </table >
      </div>
      <!--Right div-->
      <div style="float: left; width: 49%">
        <!--<h3 >MT Information Details</h3>-->
        <table border="0">
          <thead>
            <tr>
              <td>Level</td><td><input type="text"  class="input_textbox" value="<?php echo $national ?>" readonly/></td>
            </tr>
            <tr>
              <td>Phone Number</td><td><input type="text"  class="input_textbox" value="<?php echo $phone_number ?>" readonly/></td>
            </tr>
            <tr>
              <td>Phone Number 2</td><td><input type="text"  class="input_textbox" value="<?php echo $phone_number2 ?>" readonly/></td>
            </tr>
            <tr>
              <td>Year of Recruitment</td><td><input type="text" class="input_textbox" value="<?php echo $recruitment ?>" readonly/></td>
            </tr>
            <tr>
              <td>Status</td><td><input type="text"   class="input_textbox" value="<?php echo $status ?>" readonly/></td>
            </tr>
            <tr>
              <td>Primary Email </td><td><input type="email"  class="input_textbox" value="<?php echo $email; ?>" readonly /></td>
            </tr>
            <tr>
              <td>Secondary Email</td><td><input type="email" class="input_textbox" value="<?php echo $email2; ?>"   readonly /></td>
            </tr>
          </thead>
        </table >
      </div>
    </div>
    <center>
      <div>
        <a href="#close" class="btn-custom" > Close</a>
      </div>
    </center>
  </div>
</div>


<!-- datatables -->
<script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="css/dataTables.css">

<script type="text/javascript">
  $(document).ready(function() {
      $('#data-table').dataTable();
  } );
</script>
