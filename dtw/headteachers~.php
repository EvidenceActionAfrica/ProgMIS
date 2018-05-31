<?php
require_once ('includes/config.php');
require_once ('includes/auth.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
require_once("includes/logTracker.php");

//Privileges settings
$priv_mail = $_SESSION['staff_email'];
$resPriv = mysql_query("select * from staff where staff_email='$priv_mail'");

while ($row = mysql_fetch_array($resPriv)) {
  $priv_headteachers = $row["priv_headteachers"];
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
          $query = "DELETE FROM headteachers WHERE id='$deleteid'";
          $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
          //log entry
          $staff_id = $_SESSION['staff_id'];
          $staff_email = $_SESSION['staff_email'];
          $staff_name = $_SESSION['staff_name'];
          $action = "Delete \"Head Teachers\" ";
          $description = "Record ID: " . $deleteid . " deleted";
          $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
          funclogAdminData($arrLogAdminData);
        }

        if (isset($_POST['search_table'])) {
          $county = $_POST['county'];
          $district_name = $_POST['district_name'];
          $division_name = $_POST['division_name'];
          $school_name = $_POST['school_name'];
          $full_name = $_POST['full_name'];
          $treatment_type = $_POST['treatment_type'];
          $phone = $_POST['phone'];
          $searchQuery = "SELECT * FROM headteachers WHERE county LIKE '%$county%'
              AND district_name LIKE '%$district_name%'
              AND division_name LIKE '%$division_name%'
              AND school_name LIKE '%$school_name%'
              AND full_name LIKE '%$full_name%'
              AND treatment_type LIKE '%$treatment_type%' 
              AND phone LIKE '%$phone%' order by school_name asc ";
          $result_set = mysql_query($searchQuery);
        } else {
          $result_set = mysql_query("SELECT * FROM headteachers order by school_name asc");
        }
        ?>
        <style>
          table tr td a{

            text-decoration: none;
            color:rgb(0,0,0);
          }
        </style>
        <form action="#">
          <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
          <img src="images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
          <b style="margin-left:20%;width: 100px; font-size:1.5em;">Head Teachers</b>
          <?php if ($priv_headteachers >= 1) { ?>
            <a class="btn-custom-small" href="PHPExcel/AdminData/headTeachers.php?county=<?php echo $county; ?>&district_name=<?php echo $district_name; ?>&division_name=<?php echo $division_name; ?>&school_name=<?php echo $school_name; ?>&full_name=<?php echo $full_name; ?>&treatment_type=<?php echo $treatment_type; ?>&phone=<?php echo $phone; ?>">Export to Excel</a>
          <?php } if ($priv_headteachers >= 2) { ?>
            <a class="btn-custom-small" href="#addHeadTeacher">Add Head Teacher</a>
          <?php } ?>
        </form>
        <br/>
        <div style=" margin-right: 20px">
          <form method="post">
            <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
              <thead>
                <tr style="border: 1px solid #B4B5B0;">
                  <th align="center" width="15%">
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
                  <th align="center" width="15%">
                    <select name="division_name"  style="width: 98%;" onchange="submitForm();">
                      <option value=''<?php if ($district_name == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT * FROM divisions WHERE county='$county' AND district_name='$district_name' ORDER BY division_name ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['division_name']; ?>"<?php
                        if ($division_name == $rows['division_name']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['division_name']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                  <th align="center" width="20%"><input type="text" style="width: 98%" name="school_name"  value="<?php echo $school_name ?>"/></th>
                  <th align="center" width="20%"><input type="text" style="width: 98%" name="full_name"  value="<?php echo $full_name ?>"/></th>
                  <th align="center" width="5%"><input type="text" style="width: 98%" name="treatment_type"  value="<?php echo $treatment_type ?>"/></th>
                  <th align="center" width="5%"><input type="text" style="width: 98%" name="phone"  value="<?php echo $phone ?>"/></th>
                  <th align="center" width="5%" colspan="3"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                </tr>
                <tr style="border: 1px solid #B4B5B0;">
                  <th align="Left" width="15%">County</th>
                  <th align="Left" width="15%">District</th>
                  <th align="Left" width="15%">Division</th>
                  <th align="Left" width="20%">School<br/>Name</th>
                  <th align="Left" width="20%">Full Name</th>
                  <th align="Left" width="5%">Ttmt<br/>Type</th>
                  <th align="Left" width="5%">Phone</th>
                  <?php if ($priv_headteachers >= 1) { ?>
                    <th align="center" width="4%">View</th>
                  <?php } ?>
                  <?php if ($priv_headteachers >= 3) { ?>
                    <th align="center" width="4%">Edit</th>
                  <?php } ?>
                  <?php if ($priv_headteachers >= 4) { ?>
                    <th align="center" width="4%">Del</th>
                  <?php } ?>
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
                $district_name = $row['district_name'];
                $division_name = $row['division_name'];
                $school_name = $row['school_name'];
                $full_name = $row['full_name'];
                $treatment_type = $row['treatment_type'];
                $phone = $row['phone'];
                if ($priv_headteachers >= 1) {
                  $link = "headTeachers.php?viewDetails=1&id=$id#viewMT";
                } else {
                  $link = "#";
                }
                ?>
                <tr style="border-bottom: 1px solid #B4B5B0;">
                  <td align="left" width="10%"> <?php echo "<a href=$link>" . $county . "</a>"; ?> </td>
                  <td align="left" width="10%"> <?php echo "<a href=$link>" . $district_name . "</a>"; ?> </td>
                  <td align="left" width="10%"> <?php echo "<a href=$link>" . $division_name . "</a>"; ?> </td>
                  <td align="left" width="15%"> <?php echo "<a href=$link>" . $school_name . "</a>"; ?> </td>
                  <td align="left" width="15%"> <?php echo "<a href=$link>" . $full_name . "</a>"; ?>  </td>
                  <td align="left" width="5%"> <?php echo "<a href=$link>" . $treatment_type . "</a>"; ?>  </td>
                  <td align="left" width="5%"> <?php echo "<a href=$link>" . $phone . "</a>"; ?>  </td>
                  <?php /* if ($priv_headteachers >= 1) { ?>
                    <!--view button-->
                    <form method="POST" action="#viewMT">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <td align="center" width="4%"><input type="submit" name="viewDetails" value="" style="background: url(images/icons/view2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                    </form>

                    <?php } */ ?>
                  <?php if ($priv_headteachers >= 3) { ?>
                    <!--edit button-->
                    <form method="POST" action="#editMT">
                      <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                      <td align="center" width="4%"><input type="submit" name="editDetails" value="" style="background: url(images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                    </form>
                  <?php } ?>
                  <?php if ($priv_headteachers >= 4) { ?>
                    <td align="center" width="4%"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="images/icons/delete.png" height="20px"></a></td>
                  <?php } ?>
                </tr>
              </tbody>
            <?php } ?>
          </table>
        </div>

        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->


    <!--filter includes-->
    <script type="text/javascript" src="css/filter-as-you-type/jquery.min.js"></script>
    <script type="text/javascript" src="css/filter-as-you-type/jquery.quicksearch.js"></script>
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
<div id="addHeadTeacher" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <?php
    if (isset($_POST['submitAddMT'])) {
      //Generate County ID
      $r1 = mysql_query("SELECT id FROM headteachers ORDER BY id DESC LIMIT 1");
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

      $query = ( "INSERT INTO headteachers
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
        <h1>Add Head Teacher</h1>
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
                  <?php if ($priv_headteachers >= 3) { ?>
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
          <input type="submit" class="btn-custom" name="submitAddMT"  value="Add Head Teacher"/>
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

      $result_st = mysql_query("SELECT * FROM headteachers WHERE id='$id'");
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
      $query = ( "UPDATE headteachers SET
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
                  <?php if ($priv_headteachers >= 3) { ?>
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

      $result_st = mysql_query("SELECT * FROM headteachers WHERE id='$id'");
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
