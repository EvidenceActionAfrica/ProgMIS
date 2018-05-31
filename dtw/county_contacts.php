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
   $table = "county_contacts";
   if ($_FILES["file"]["error"] > 0) {
  	echo "Error: " . $_FILES["file"]["error"] . "<br>";
    $csvMessage = "Upload Failed";
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
  $priv_county_contacts = $row["priv_county_contacts"];
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
          $query = "DELETE FROM county_contacts WHERE id='$deleteid'";
          $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
          //log entry
          $staff_id = $_SESSION['staff_id'];
          $staff_email = $_SESSION['staff_email'];
          $staff_name = $_SESSION['staff_name'];
          $action = "Delete \"County Contacts\" ";
          $description = "Record ID: " . $deleteid . " deleted";
          $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
          funclogAdminData($arrLogAdminData);
        }

        if (isset($_POST['search_table'])) {
          $county = $_POST['county'];
          $title = $_POST['title'];
          $full_name = $_POST['full_name'];
          $phoneSearch = $_POST['phoneSearch'];
          $emailSearch = $_POST['emailSearch'];
          $searchQuery = "SELECT * FROM county_contacts WHERE county LIKE '%$county%'
              AND title LIKE '%$title%'
              AND full_name LIKE '%$full_name%'
              AND phone LIKE '%$phoneSearch%'
              AND email  LIKE '%$emailSearch%' order by county asc ";
          $result_set = mysql_query($searchQuery);
        } else {
          $result_set = mysql_query("SELECT * FROM county_contacts order by county  asc");
        }
        ?>

        <form action="#">
          <img src="images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
           <?php if ($priv_county_contacts >= 4) { ?>
            <a class="btn-custom-small" href="#importCSV">Import</a>
          <?php } ?>
            <b style="margin-left:20%;width: 100px; font-size:1.5em;">County Contacts</b>
           <?php if ($priv_county_contacts >= 1) { ?>
          <a class="btn-custom-small" href="PHPExcel/AdminData/countyContacts.php?county=<?php echo $county; ?>&title=<?php echo $title; ?>&full_name=<?php echo $full_name; ?>&phoneSearch=<?php echo $phoneSearch; ?>&emailSearch=<?php echo $emailSearch; ?>">Export to Excel</a>
           <?php }if ($priv_county_contacts >= 2) { ?>
          <a class="btn-custom-small" href="#addCountyContact">Add County Contact</a>
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
                  <th align="center" width="10%">
                    <select name="title"  style="width: 98%;" onchange="submitForm();">
                      <option value=''<?php if ($title == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT * FROM dropdown_county_titles ORDER BY title ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['title']; ?>"<?php
                        if ($county == $rows['title']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['title']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                  <th align="center" width="20%"><input type="text" style="width: 98%" name="full_name"  value="<?php echo $full_name ?>"/></th>
                  <th align="center" width="15%"><input type="text" style="width: 98%" name="phoneSearch"  value="<?php echo $phoneSearch ?>"/></th>
                  <th align="center" width="30%"><input type="text" style="width: 98%" name="emailSearch"  value="<?php echo $emailSearch ?>"/></th>
                  <th align="center" width="12%" colspan="3"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                </tr>     
              </thead>
            </table>
          </form>
              <table id="data-table" class="table table-responsive table-hover table-stripped">
                  <thead>
                  <th align="Left" width="15%">County</th>
                  <th align="Left" width="10%">Title</th>
                  <th align="Left" width="20%">Name</th>
                  <th align="Left" width="15%">Mobile</th>
                  <th align="Left" width="30%">Email</th>
                  <?php if ($priv_county_contacts >= 4) { ?>
                    <th align="center" width="4%">Del</th>
                  <?php } ?>
                </tr>
               </thead>
          
            <tbody>
              <?php
              while ($row = mysql_fetch_array($result_set)) {
                $id = $row['id'];
                $county = $row['county'];
                $title = $row['title'];
                $full_name = $row['full_name'];
                $phoneSearch = $row['phone'];
                $emailSearch = $row['email'];
                if ($priv_county_contacts >= 3) { 
                   $link="county_contacts.php?id=$id&editDetails=1#editCCounty";
                }else{
                   $link="county_contacts.php?id=$id&viewDetails=1#viewCContact";
                }
                ?>
                <tr>
                  <td align="left" width="15%"> <?php echo "<a href=$link>".$county."</a>"; ?>  </td>
                  <td align="left" width="10%"> <?php echo "<a href=$link>".$title."</a>"; ?>  </td>
                  <td align="left" width="20%"> <?php echo "<a href=$link>".$full_name."</a>"; ?> </td>
                  <td align="left" width="15%"> <?php
                    echo "<a href=$link>".substr($phoneSearch, 0, 12);
                    if (strlen($phoneSearch) > 12)
                      echo ".."."</a>";
                    ?>
                  </td>
                  <td align="left" width="30%"><?php
                    echo "<a href=$link>".substr($emailSearch, 0, 30);
                    if (strlen($emailSearch) > 30)
                      echo ".."."</a>";
                    ?>
                  </td>
                  <?php if ($priv_county_contacts >= 4) { ?>
                    <td align="center" width="4%"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="images/icons/delete.png" height="20px"></a></td>
                  <?php } ?>
                </tr>
            
            <?php } ?>
                  </tbody>
                  
          </table>
        </div>
<?php
$sql = "SELECT timestamp from `county_contacts` order by timestamp desc limit 1";
$time = mysql_query($sql);
while($timestamp = mysql_fetch_array($time)){
echo " Data last updated: " .$timestamp['timestamp'];}
?>
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
<div id="addCountyContact" class="modalDialog">
  <div style="width:680px">
    <a href="#close" title="Close" class="close">X</a>
    <?php
    $formSubmitted = false;
    if (isset($_POST['submitAddCounty'])) {

      //Post Values
      $county = $_POST['county'];
      $full_name = $_POST['full_name'];
      $title = $_POST['title'];
      $p_number = $_POST['p_number'];
      $phone = $_POST['phone'];
      $phone2 = $_POST['phone2'];
      $email = $_POST['email'];
      $email2 = $_POST['email2'];
      $postal_address = $_POST['postal_address'];
      $home_county = $_POST['home_county'];
      $bank_account_name = $_POST['bank_account_name'];
      $bank_account_number = $_POST['bank_account_number'];
      $bank_name = $_POST['bank_name'];
      $bank_branch = $_POST['bank_branch'];

      $county = addslashes(trim($county));
      $full_name = addslashes(trim($full_name));
      $title = addslashes(trim($title));
      $p_number = addslashes(trim($p_number));
      $phone = addslashes(trim($phone));
      $phone2 = addslashes(trim($phone2));
      $email = addslashes(trim($email));
      $email2 = addslashes(trim($email2));
      $postal_address = addslashes(trim($postal_address));
      $home_county = addslashes(trim($home_county));
      $bank_account_name = addslashes(trim($bank_account_name));
      $bank_account_number = addslashes(trim($bank_account_number));
      $bank_name = addslashes(trim($bank_name));
      $bank_branch = addslashes(trim($bank_branch));

      $query = ( "INSERT INTO county_contacts (
            county,
            full_name,
            title,
            phone,
            phone2,
            email,
            email2,
            bank_account_name,
            bank_account_number,
            bank_name,
            bank_branch )
			
        VALUES (
            '$county',
            '$full_name',
            '$title',
            '$phone',
            '$phone2',
            '$email',
            '$email2',
            '$bank_account_name',
            '$bank_account_number',
            '$bank_name',
            '$bank_branch')" );
    
	  mysql_query($query) or die(mysql_error("Could not enter"));
      $messageToUser = "Record Added Successfully!";

      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];
      $action = "Added \"County Contacts\" ";
      $description = "Record ID: " . $county . " contact Added";
      $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      funclogAdminData($arrLogAdminData);
    }
    ?>
    
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <h1 class="form-title">Add County Contact</h1>
      <div style="padding: 5px;">
        <!--left div-->
        <div style="float: left; width: 49%;">
          <h3 class="compact">County Contact Details</h3>
          <table border="0"  cellpadding="0" cellspacing="0" width="100%">
            <thead>
              <tr  height='30px'>
                <td>County </td>
                <td>
                  <select name="county"  style="width: 98%;" required>
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
              <tr>
                <td>Full Name</td><td><input type="text" name="full_name" class="input_textbox_p compact" required/></td>
              </tr>
              <tr height='30px'>
                <td>Title </td>
                <td>
                  <select name="title"  style="width: 58%;" required>
                    <option value=''<?php if ($title == '') echo 'selected'; ?> ></option>
                    <?php
                    $sql = "SELECT * FROM dropdown_county_titles ORDER BY title ASC";
                    $result = mysql_query($sql);
                    while ($rows = mysql_fetch_array($result)) { //loop table rows
                      ?>
                      <option value="<?php echo $rows['title']; ?>"<?php
                      if ($title == $rows['title']) {
                        echo 'selected';
                      }
                      ?>><?php echo $rows['title']; ?></option>
                            <?php } ?>
                  </select>
                        <?php if ($priv_county_contacts >= 3) { ?>
                  <a  href="dropdown_settings.php"><img src="images/icons/mainEdit.png" style="vertical-align: middle" height="30px"/></a>
                  <?php } ?>
                </td>
              </tr> 
              <tr>
                <td>P - Number </td><td><input type="text" name="p_number" id="p_number" class="input_textbox_p compact" onKeyUp="isNumeric(this.id);" /><span id="p_numberSpan"></span></td>
              </tr>
              <tr>
                <td>Phone</td><td><input type="text" name="phone" id="phone" class="input_textbox_p compact" maxlength="12" placeholder="254" onKeyUp="isPhoneNumber(this.id);" required/><span id="phoneSpan"></span></td>
              </tr>
              <tr>
                <td>Phone 2</td><td><input type="text" name="phone2" id="phone2" placeholder="254" class="input_textbox_p compact" maxlength="12" onKeyUp="isNumeric(this.id);"/><span id="phone2Span"></span></td>
              </tr>
              <tr>
                <td>Email</td><td><input type="text" name="email" class="input_textbox_p compact" required/></td>
              </tr>
              <tr>
                <td>Email 2</td><td><input type="text" name="email2" class="input_textbox_p compact" /></td>
              </tr>
              
            </thead>
          </table >
          <br/>
        </div>
        <!--Right div-->
        <div style="float: right; width: 49%">
          <h3 class="compact">Bank Details</h3>
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <thead> 
              <tr>
                <td>Bank Account Name</td><td><input type="text" name="bank_account_name" class="input_textbox_p compact" required/></td>
              </tr>
              <tr>
                <td>Bank Account Number</td><td><input type="text" name="bank_account_number" class="input_textbox_p compact" required/></td>
              </tr>
              <tr>
                <td>Bank Name</td><td><input type="text" name="bank_name" class="input_textbox_p compact" required/></td>
              </tr>
              <tr>
                <td>Bank Branch</td><td><input type="text" name="bank_branch" class="input_textbox_p compact" required/></td>
              </tr> 
            </thead>
          </table >
          <br/>
          <br/>
          <center>
            <table> <tr>
                       <?php if ($priv_county_contacts >= 2) { ?>
                <td><input type="submit" class="btn-custom-small" name="submitAddCounty"  value="Add County Contact"/></td>
                       <?php } ?>
                <!-- <td><a href="#close" class="btn-custom-small" >Close</a></td> -->
              </tr> </table>
          </center>
        </div>
      </div>
      <div class="vclear"></div> 
    </form>
  </div>
</div>


<!--==== Modal EDIT ======-->
<div id="editCCounty" class="modalDialog">
  <div style="width:680px">
    <a href="#close" title="Close" class="close">X</a>
    <?php
    if (isset($_GET['editDetails'])) {
      $id = $_GET['id'];

      $result_st = mysql_query("SELECT * FROM county_contacts WHERE id='$id'");
      while ($row = mysql_fetch_array($result_st)) {
        $county = $row['county'];
        $full_name = $row['full_name'];
        $title = $row['title'];
        $p_number = $row['p_number'];
        $phone = $row['phone'];
        $phone2 = $row['phone2'];
        $email = $row['email'];
        $email2 = $row['email2'];
        $postal_address = $row['postal_address'];
        $home_county = $row['home_county'];
        $bank_account_name = $row['bank_account_name'];
        $bank_account_number = $row['bank_account_number'];
        $bank_name = $row['bank_name'];
        $bank_branch = $row['bank_branch'];
      }
    }
    if (isset($_POST['submitEditCC'])) {
      $id = $_POST['id'];
      $county = $_POST['county'];
      $full_name = $_POST['full_name'];
      $title = $_POST['title'];
      $p_number = $_POST['p_number'];
      $phone = $_POST['phone'];
      $phone2 = $_POST['phone2'];
      $email = $_POST['email'];
      $email2 = $_POST['email2'];
      $postal_address = $_POST['postal_address'];
      $home_county = $_POST['home_county'];
      $bank_account_name = $_POST['bank_account_name'];
      $bank_account_number = $_POST['bank_account_number'];
      $bank_name = $_POST['bank_name'];
      $bank_branch = $_POST['bank_branch'];

      $county = addslashes(trim($county));
      $full_name = addslashes(trim($full_name));
      $title = addslashes(trim($title));
      $p_number = addslashes(trim($p_number));
      $phone = addslashes(trim($phone));
      $phone2 = addslashes(trim($phone2));
      $email = addslashes(trim($email));
      $email2 = addslashes(trim($email2));
      $postal_address = addslashes(trim($postal_address));
      $home_county = addslashes(trim($home_county));
      $bank_account_name = addslashes(trim($bank_account_name));
      $bank_account_number = addslashes(trim($bank_account_number));
      $bank_name = addslashes(trim($bank_name));
      $bank_branch = addslashes(trim($bank_branch));

      $query = ( "UPDATE county_contacts SET
          county = '$county',
          full_name = '$full_name',
          title = '$title', 
          phone = '$phone',
          phone2 = '$phone2',
          email = '$email',
          email2 = '$email2',
          bank_account_name = '$bank_account_name',
          bank_account_number = '$bank_account_number',
          bank_name = '$bank_name',
          bank_branch = '$bank_branch',
		  timestamp = CURRENT_TIMESTAMP		 
		  WHERE id='$id' " );

      
      mysql_query($query) or die(mysql_error("Could not enter"));
      $messageToUser = "Record Edited Successfully!";

      //log entry
      $staff_id = $_SESSION['staff_id'];
      $staff_email = $_SESSION['staff_email'];
      $staff_name = $_SESSION['staff_name'];
      $action = "Updated \"County Contacts\" ";
      $description = "Record ID: " . $county . " contacts updated";
      $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      funclogAdminData($arrLogAdminData);
    }
    ?>
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <h1 class="form-title">Edit County Contact Details</h1>
      <div style="padding: 5px;">
        <!--left div-->
        <div style="float: left; width: 49%;">
          <h3 class="compact">County Contact Details</h3>
          <table border="0"  cellpadding="0" cellspacing="0" width="100%">
            <thead>
              <tr  height='30px'>
                <td>County </td>
                <td>
                  <select name="county"  style="width: 98%;" required>
                    <option value="<?php echo $county; ?>"><?php echo $county; ?></option>
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
              <tr>
                <td>Full Name</td><td><input type="text" name="full_name" class="input_textbox_p compact" value="<?php echo $full_name; ?>"required/></td>
              </tr>
              <tr height='30px'>
                <td>Title </td>
                <td>
                  <select name="title"  style="width: 58%;" required>
                    <option value="<?php echo $title; ?>"><?php echo $title; ?></option>
                    <option value=''<?php if ($title == '') echo 'selected'; ?> ></option>
                    <?php
                    $sql = "SELECT * FROM dropdown_county_titles ORDER BY title ASC";
                    $result = mysql_query($sql);
                    while ($rows = mysql_fetch_array($result)) { //loop table rows
                      ?>
                      <option value="<?php echo $rows['title']; ?>"<?php
                      if ($title == $rows['title']) {
                        echo 'selected';
                      }
                      ?>><?php echo $rows['title']; ?></option>
                            <?php } ?>
                  </select>
                       <?php if ($priv_county_contacts >= 3) { ?>
                  <a target='-blank' href="dropdown_settings.php"><img src="images/icons/mainEdit.png" style="vertical-align: middle" height="30px"/></a>
                  <?php } ?>
                </td>
              </tr> 
              <tr>
                <td>P - Number </td><td><input type="text" name="p_number" id="p_number0" class="input_textbox_p compact"  value="<?php echo $p_number; ?>" onKeyUp="isNumeric(this.id);" /><span id="p_number0Span"></span></td>
              </tr>
              <tr>
                <td>Phone</td><td><input type="text" name="phone" id="phone0" class="input_textbox_p compact" maxlength="12" value="<?php echo $phone; ?>" onKeyUp="isPhoneNumber(this.id);" required/><span id="phone0Span"></span></td>
              </tr>
              <tr>
                <td>Phone 2</td><td><input type="text" name="phone2" id="phone20" class="input_textbox_p compact" maxlength="12" value="<?php echo $phone2; ?>"onKeyUp="isNumeric(this.id);"/><span id="phone20Span"></span></td>
              </tr>
              <tr>
                <td>Email</td><td><input type="text" name="email" class="input_textbox_p compact" value="<?php echo $email; ?>" /></td>
              </tr>
              <tr>
                <td>Email 2</td><td><input type="text" name="email2" class="input_textbox_p compact"  value="<?php echo $email2; ?>"/></td>
              </tr>
              <tr>
                <td>Postal Address</td><td><input type="text" name="postal_address" class="input_textbox_p compact"  value="<?php echo $postal_address; ?>"/></td>
              </tr> 
              <tr>
                <td>Home County</td><td><input type="text" name="home_county" class="input_textbox_p compact"  value="<?php echo $home_county; ?>"/></td>
              </tr> 
            </thead>
          </table >
          <br/>
        </div>
        <!--Right div-->
        <div style="float: right; width: 49%">
          <h3 class="compact">Bank Details</h3>
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <thead> 
              <tr>
                <td>Bank Account Name</td><td><input type="text" name="bank_account_name"  value="<?php echo $bank_account_name; ?>" class="input_textbox_p compact" /></td>
              </tr>
              <tr>
                <td>Bank Account Number</td><td><input type="text" name="bank_account_number"  value="<?php echo $bank_account_number; ?>" class="input_textbox_p compact" /></td>
              </tr>
              <tr>
                <td>Bank Name</td><td><input type="text" name="bank_name" value="<?php echo $bank_name; ?>" class="input_textbox_p compact" /></td>
              </tr>
              <tr>
                <td>Bank Branch</td><td><input type="text" name="bank_branch" value="<?php echo $bank_branch; ?>" class="input_textbox_p compact" /></td>
              </tr> 
            </thead>
          </table >
          <br/>
          <input type="hidden" name="id" value="<?php echo $id; ?>" />
          <br/>
          <br/>
          <center>
            <div>
                   <?php if ($priv_county_contacts >= 3) { ?>
              <input type="submit" class="btn-custom" name="submitEditCC"  value="Edit County Details"/>
                   <?php } ?>
            </div>
          </center> 
        </div>
      </div>
      <div class="vclear"></div> 
    </form>
  </div>
</div>
<!--===== Modal Import ===========================-->
<div id="importCSV" class="modalDialog">
  <div style="width:380px">
    <a href="#close" title="Close" class="close">X</a>
    <div >
      <h1 class="form-title">Upload County Contacts </h1><br/>
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
                                        <?php if ($priv_county_contacts >= 4) { ?>
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
<div id="viewCContact" class="modalDialog">
  <div style="width:680px">
    <a href="#close" title="Close" class="close">X</a>
    <h1 class="form-title">View County Contact Details</h1>
    <?php
    if (isset($_GET['viewDetails'])) {
      $id = $_GET['id'];

      $result_st = mysql_query("SELECT * FROM county_contacts WHERE id='$id'");
      while ($row = mysql_fetch_array($result_st)) {
        $county = $row['county'];
        $full_name = $row['full_name'];
        $title = $row['title'];
        $p_number = $row['p_number'];
        $phone = $row['phone'];
        $phone2 = $row['phone2'];
        $email = $row['email'];
        $email2 = $row['email2'];
        $postal_address = $row['postal_address'];
        $home_county = $row['home_county'];
        $bank_account_name = $row['bank_account_name'];
        $bank_account_number = $row['bank_account_number'];
        $bank_name = $row['bank_name'];
        $bank_branch = $row['bank_branch'];
      }
    }
    ?>

    <div style="padding: 5px;">
      <!--left div-->
      <div style="float: left; width: 49%;">
        <h3 class="compact">County Contact Details</h3>
        <table border="0"  cellpadding="0" cellspacing="0" width="100%">
          <thead>
            <tr>
              <td>County</td><td><input type="text"  class="input_textbox_p compact" value="<?php echo $county; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Full Name</td><td><input type="text"  class="input_textbox_p compact" value="<?php echo $full_name; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Title</td><td><input type="text"  class="input_textbox_p compact" value="<?php echo $title; ?>" readonly/></td>
            </tr>
            <tr>
              <td>P - Number </td><td><input type="text"  class="input_textbox_p compact"  value="<?php echo $p_number; ?>"  readonly/></td>
            </tr>
            <tr>
              <td>Phone</td><td><input type="text" class="input_textbox_p compact"  value="<?php echo $phone; ?>"  readonly/></span></td>
            </tr>
            <tr>
              <td>Phone 2</td><td><input type="text" class="input_textbox_p compact"  value="<?php echo $phone2; ?>"    readonly/> </td>
            </tr>
            <tr>
              <td>Email</td><td><input type="text"  class="input_textbox_p compact" value="<?php echo $email; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Email 2</td><td><input type="text"  class="input_textbox_p compact"  value="<?php echo $email2; ?>" readonly/></td>
            </tr>
            <tr>
              <td>Postal Address</td><td><input type="text" class="input_textbox_p compact"  value="<?php echo $postal_address; ?>" readonly/></td>
            </tr> 
            <tr>
              <td>Home County</td><td><input type="text" class="input_textbox_p compact"  value="<?php echo $home_county; ?>" readonly /></td>
            </tr> 
          </thead>
        </table >
        <br/>
      </div>
      <!--Right div-->
      <div style="float: right; width: 49%">
        <h3 class="compact">Bank Details</h3>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <thead> 
            <tr>
              <td>Bank Account Name</td><td><input type="text"  value="<?php echo $bank_account_name; ?>" class="input_textbox_p compact"  readonly /></td>
            </tr>
            <tr>
              <td>Bank Account Number</td><td><input type="text"  value="<?php echo $bank_account_number; ?>" class="input_textbox_p compact"  readonly /></td>
            </tr>
            <tr>
              <td>Bank Name</td><td><input type="text" value="<?php echo $bank_name; ?>" class="input_textbox_p compact"  readonly /></td>
            </tr>
            <tr>
              <td>Bank Branch</td><td><input type="text"  value="<?php echo $bank_branch; ?>" class="input_textbox_p compact"  readonly /></td>
            </tr> 
          </thead>
        </table >
        <br/>
        <center>
          <table> <tr>
              <td><a href="#close" class="btn-custom-small" >Close</a></td>
            </tr> </table>
        </center> 
      </div>
    </div>
    <div class="vclear"></div> 
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
<?php
//echo filemtime("county_contacts.txt");
//echo "<br />";
//echo "Script Last modified: ".date("F d Y H:i:s.",filemtime("county_contacts.php"));
?>


