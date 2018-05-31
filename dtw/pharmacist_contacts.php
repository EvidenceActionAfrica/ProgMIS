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



  $table = "pharmacist_contacts";
  if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
  } else {
    $temp = $_FILES["file"]["tmp_name"];
    $csvMessage = "Upload Successful";
  }

  $filename = $image->upload_image($temp);
  $csvMessage = $insertFile->insertFile($filename, $table); 
}

$priv_mail = $_SESSION['staff_email'];
$resPriv = mysql_query("select * from staff where staff_email='$priv_mail'");

while ($row = mysql_fetch_array($resPriv)) {
  $priv_pharmacist = $row["priv_moh"];
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
          $query = "DELETE FROM pharmacist_contacts WHERE id='$deleteid'";
          $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());

          //log entry
          $staff_id = $_SESSION['staff_id'];
          $staff_email = $_SESSION['staff_email'];
          $staff_name = $_SESSION['staff_name'];
          $action = "Delete \"Pharmacist Contact\" ";
          $description = "Record ID: " . $deleteid . " deleted";
          $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
          funclogAdminData($arrLogAdminData);
        }

        if (isset($_POST['search_table'])) {
          $county = $_POST['county'];
          $dmoh_name = $_POST['dmoh_name'];
          $dmoh_phone = $_POST['dmoh_phone'];
          $dmoh_email = $_POST['dmoh_email'];
          $searchQuery = "SELECT * FROM pharmacist_contacts WHERE county LIKE '%$county%'
              AND names LIKE '%$dmoh_name%'
              AND telephone_no LIKE '%$dmoh_phone%'
              AND email LIKE '%$dmoh_email%' order by county ASC ";
          $result_set = mysql_query($searchQuery);
        } else {
          $result_set = mysql_query("SELECT * FROM pharmacist_contacts order by county ASC");
        }
        ?>

        <form action="#">
          <img src="images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
          <?php if ($priv_pharmacist >= 4) { ?>
            <a class="btn-custom-small" href="#importCSV">Import</a>
          <?php } ?><b style="margin-left:20%;width: 100px; font-size:1.5em;">Pharmacist Contacts</b>
          <?php if ($priv_pharmacist >= 1) { ?>
            <a class="btn-custom-small" href="PHPExcel/AdminData/MoH(pharmacist).php?county=<?php echo $county; ?>&dmoh_name=<?php echo $dmoh_name; ?>&dmoh_phone=<?php echo $dmoh_phone; ?>&dmoh_email=<?php echo $dmoh_email; ?>">Export to Excel</a>
          <?php } if ($priv_pharmacist >= 2) { ?>
            <a class="btn-custom-small" href="#addPharmacistContact">Add Pharmacist Contact</a>
          <?php } ?>
        </form>
        <br/>
        <style>
          table tbody tr td a{
            text-decoration:none;
            color:#000000;
          }
        </style>
        <div>
          <form method="post">
            <table  width="99.3%">
              <thead >
                <tr style="">
                  <th align="center" width="17%">
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
                  <th align="center" width="23%"><input type="text" style="width: 98%" name="dmoh_name"  value="<?php echo $dmoh_name ?>"/></th>
                  <th align="center" width="17%"><input type="text" style="width: 98%" name="dmoh_phone"  value="<?php echo $dmoh_phone ?>"/></th>
                  <th align="center" width="28%"><input type="text" style="width: 98%" name="dmoh_email"  value="<?php echo $dmoh_email ?>"/></th>
                  <th align="center" width="15%"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                </tr>
              </thead>
            </table>
            <table id="data-table" class="table table-responsive table-hover table-stripped">
              <thead>
                <tr>
                  <th align="Left" width="17%">County</th>
                  <th align="Left" width="23%">Name</th>
                  <th align="Left" width="17%">Mobile</th>
                  <th align="Left" width="36%">Email</th>

                  <?php if ($priv_pharmacist >= 4) { ?>                 
                    <th align="center" width="7%">Del</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = mysql_fetch_array($result_set)) {
                  $id = $row['id'];
                  $county = $row['county'];
                  $dmoh_name = $row['names'];
                  $dmoh_phone = $row['telephone_no'];
                  $dmoh_email = $row['email'];
                  if ($priv_pharmacist >= 3) {
                    $link = "pharmacist_contacts.php?id=$id&editDetails=1#editPharmacist";
                  } else if ($priv_pharmacist >= 1) {
                    $link = "pharmacist_contacts.php?id=$id&viewDetails=1#viewMoH";
                  } else {
                    $link = "pharmacist_contacts.php#";
                  }
                  ?> 
                  <tr style="border-bottom: 1px solid #B4B5B0;">
                    <td align="left" width="17%"> <?php echo "<a href=$link>" . $county . "</a>"; ?> </td> 
                    <td align="left" width="23%"> <?php echo "<a href=$link>" . $dmoh_name . "</a>"; ?> </td>
                    <td align="left" width="17%"><?php
                      echo "<a href=$link>" . substr($dmoh_phone, 0, 12);
                      if (strlen($dmoh_phone) > 12)
                        echo "..";
                      echo "</a>";
                      ?>
                    </td>
                    <td align="left" width="36%"><?php
                      echo "<a href=$link>" . substr($dmoh_email, 0, 30);
                      if (strlen($dmoh_email) > 30)
                        echo "..";
                      echo "</a>";
                      ?>
                    </td> 
                    <?php if ($priv_pharmacist >= 3) { ?>
                      <!--edit button-->
                      <form method="POST" action="#editPharmacist">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                       <!-- <td align="center" width="4%"><input type="submit" name="editDetails" value="" style="background: url(images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>-->
                      </form>
                    <?php } ?>
                    <?php if ($priv_pharmacist >= 4) { ?>
                      <td align="center" width="7%"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="images/icons/delete.png" height="20px"></a></td>
                    <?php } ?>
                  </tr>
                  </a>
                <?php } ?>
              </tbody>
            </table>
          </form>
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
<div id="addPharmacistContact" class="modalDialog">
  <div style="width:30%">
    <a href="#close" title="Close" class="close">X</a>
    <?php
    $formSubmitted = false;
    if (isset($_POST['submitAddPharmacist'])) {

      //Post Values to DB
      $county = $_POST['county'];
      $dmoh_name = $_POST['dmoh_name'];
      $dmoh_phone = $_POST['dmoh_phone'];
      $dmoh_email = $_POST['dmoh_email'];


      $county = addslashes(trim($county));
      $dmoh_name = addslashes(trim($dmoh_name));
      $dmoh_phone = addslashes(trim($dmoh_phone));
      $dmoh_email = addslashes(trim($dmoh_email));



      $query = ( "INSERT INTO pharmacist_contacts (county,names,telephone_no,email)
        VALUES (
            '$county','$dmoh_name','$dmoh_phone','$dmoh_email')" );
      mysql_query($query) or die(mysql_error("Could not enter"));
      $messageToUser = "Record Added Successfully!";


      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];
      $action = "Added \"Pharmacist Contact\" ";
      $description = "Record ID: " . $dmoh_name . " added";
      $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      funclogAdminData($arrLogAdminData);
    }
    ?>
    <form action="" method="post" >
      <?php include("includes/messageBox.php"); ?>
      <h1 class="form-title">Add Pharmacist Contact</h1>
      <div style="padding: 20px; ">
        <!--left div-->
        <div style="">
          <h3 class="compact">Details</h3>
          <table border="0"  cellpadding="0" cellspacing="0" style="width:100%">
            <thead>
              <tr>
                <td style="width:30%">County </td>
                <td >
                  <?php
                  $tablename = 'counties';
                  $fields = 'id, county';
                  $where = '1=1 order by county asc';
                  $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                  ?>
                  <select onchange="get_district(this.value);" id="county" style="width:90%" name="county" class="input_select_p compact" required >
                    <option value="">Choose County</option>
                    <?php foreach ($insertformdata as $insertformdatacab) { ?>
                      <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Names</td><td><input style="width:90%" type="text" name="dmoh_name" class="input_textbox_p compact" value="" required/></td>
              </tr>
              <tr>
                <td>Phone</td><td><input style="width:90%" type="text" name="dmoh_phone" id="dmoh_phone" class="input_textbox_p compact" maxlength="12" placeholder="254" onKeyUp="isPhoneNumber(this.id);" required/><span id="dmoh_phoneSpan"></span></td>
              </tr>
              <tr>
                <td>Email</td><td><input style="width:90%" type="text" name="dmoh_email" class="input_textbox_p compact" /></td>
              </tr>
            </thead>
          </table >
          <br/>
          <center>
            <table> <tr>
                <td><input type="submit" class="btn-custom-small" name="submitAddPharmacist"  value="Add Pharmacist Contact"/></td>
              </tr> </table>
          </center>
        </div>    
      </div>
    </form>
  </div>
</div>


<!--==== Modal EDIT ======-->
<div id="editPharmacist" class="modalDialog">
  <div style="width:30%">
    <a href="#close" title="Close" class="close">X</a>
    <?php
    if (isset($_GET['editDetails'])) {
      $id = $_GET['id'];
      $result_st = mysql_query("SELECT * FROM pharmacist_contacts WHERE id='$id'");
      while ($row = mysql_fetch_array($result_st)) {
        $county = $row['county'];
        $dmoh_name = $row['names'];
        $dmoh_phone = $row['telephone_no'];
        $dmoh_email = $row['email'];
      }
    }
    if (isset($_POST['submitEditMoH'])) {
      $id = $_POST['id'];
      $county = $_POST['county'];
      $dmoh_name = $_POST['dmoh_name'];
      $dmoh_phone = $_POST['dmoh_phone'];
      $dmoh_email = $_POST['dmoh_email'];

      $county = addslashes(trim($county));
      $dmoh_name = addslashes(trim($dmoh_name));
      $dmoh_phone = addslashes(trim($dmoh_phone));
      $dmoh_email = addslashes(trim($dmoh_email));


      $query = ( "UPDATE pharmacist_contacts SET
          county ='$county',
          names ='$dmoh_name',
          telephone_no ='$dmoh_phone',
          email ='$dmoh_email' WHERE id='$id' " );
      mysql_query($query) or die(mysql_error("Could not enter"));
      $messageToUser = "Record Edited Successfully!";

      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];
      $action = "Edited \"Pharmacist Contact\" ";
      $description = "Record ID: " . $dmoh_name . " Edited";
      $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      funclogAdminData($arrLogAdminData);
    }
    ?>
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <h1 class="form-title">Edit Pharmacist Contact Details</h1>
      <div style="padding: 5px;">
        <!--left div-->
        <div >
          <h3 class="compact">Details</h3>
          <table border="0"  cellpadding="0" cellspacing="0" style="width:100%">
            <thead>
              <input type="hidden" name="id"  value="<?php echo $id; ?>"/>
              <tr>
                <td style="width:30%">County </td>
                <td>
                  <?php
                  $tablename = 'counties';
                  $fields = 'id, county';
                  $where = '1=1 order by county asc';
                  $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                  ?>
                  <select onchange="get_district2(this.value);" id="county2" style="width:90%" name="county" class="input_select_p compact" required >
                    <option value='<?php echo $county; ?>' ><?php echo $county; ?></option>
                    <?php foreach ($insertformdata as $insertformdatacab) { ?>
                      <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>             
              <tr>
                <td>Name</td><td><input type="text" style="width:90%" name="dmoh_name" class="input_textbox_p compact"value="<?php echo $dmoh_name; ?>" required/></td>
              </tr>
              <tr>
                <td>Phone</td><td><input type="text" style="width:90%" name="dmoh_phone" class="input_textbox_p compact" maxlength="12"value="<?php echo $dmoh_phone; ?>" required/></td>
              </tr>              
              <tr>
                <td>Email</td><td><input type="text" style="width:90%" name="dmoh_email" class="input_textbox_p compact" value="<?php echo $dmoh_email; ?>"/></td>
              </tr>              
            </thead>
          </table >
          <br/>
          <center>
            <div>
              <input type="submit" class="btn-custom" name="submitEditMoH"  value="Edit Pharmacist Details"/>
            </div>
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
      <h1 class="form-title">Upload Pharmacist contacts </h1><br/>
    </div>
    <?php
    if (isset($csvMessage)) {
      echo '<h4 style="color:#050000;background-color:#A2FF7E;text-align:center;">' . $csvMessage . '</h4>';
    }
    ?>
    <center>
      <div style="padding: 5px; margin: 0px auto">

        <form action="" method="post"
              enctype="multipart/form-data">
          <label for="file">Filename:</label>
          <input type="file" name="file" id="file"/>
          <?php if ($priv_pharmacist >= 4) { ?>
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
<div id="viewMoH" class="modalDialog">
  <div style="width:30%">
    <a href="#close" title="Close" class="close">X</a>
    <h1 class="form-title">View Pharmacist Contact Details</h1>
    <?php
    if (isset($_GET['viewDetails'])) {
      $id = $_GET['id'];

      $result_st = mysql_query("SELECT * FROM pharmacist_contacts WHERE id='$id'");
      while ($row = mysql_fetch_array($result_st)) {
        $county = $row['county'];
        $district = $row['district'];
        $dmoh_name = $row['names'];
        $dmoh_phone = $row['telephone_no'];
        $dmoh_email = $row['email'];
      }
    }
    ?>
    <div style="padding: 5px;">
      <div style="float: left; width: 49%;">
        <h3 class="compact">Details</h3>
        <table border="0"  cellpadding="0" cellspacing="0" style="width:100%">
          <thead>
            <tr>
              <td>County</td><td><input type="text" style="width:90%" class="input_textbox_p compact" value="<?php echo $county; ?>" readonly/></td>
            </tr>            
            <tr>
              <td>Name</td><td><input type="text" style="width:90%" name="dmoh_name" class="input_textbox_p compact" value="<?php echo $dmoh_name; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Phone</td><td><input type="text" style="width:90%" name="dmoh_phone" class="input_textbox_p compact"  value="<?php echo $dmoh_phone; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Email</td><td><input type="email" style="width:90%" name="dmoh_email" class="input_textbox_p compact" value="<?php echo $dmoh_email; ?>" readonly/></td>
            </tr>
          </thead>
        </table >
      </div>      
    </div>
    <div class="vclear"></div> 
  </div>
</div>

<script>
          //GET district
          function get_district(txt) {
            $.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
              $('#district').html(data);//alert(data);
            });
          }
          //GET district
          function get_district2(txt) {
            $.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
              $('#district2').html(data);//alert(data);
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
    });
  </script>

