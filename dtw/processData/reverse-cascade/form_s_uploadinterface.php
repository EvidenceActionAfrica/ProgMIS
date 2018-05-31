<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
$level = $_SESSION['level'];

if (isset($_POST['submit'])) {
  echo "<pre>";
  print_r($_FILES);
  echo "</pre>";

  $error = $_FILES["file"]["error"];
  $file_path = "upload/test.csv";

  if ($_FILES["file"]["error"] == 0) {
    //  upload and save the file to the server
    if (file_exists("upload/" . $_FILES["file"]["name"])) {
      echo "The file already exists";
    } else {
      move_uploaded_file($_FILES["file"]["tmp_name"], $file_path);
      echo "Stored in " . $file_path;
    }
    $upload = mysql_query("LOAD DATA LOCAL INFILE '$file_path' INTO TABLE form_s FIELDS TERMINATED BY ','") or die(mysql_error());
  }

  // if ($_FILES["file"]["error"] > 0) {
  // echo "Error: " . $_FILES["file"]["error"] . "<br>";
  // echo "Type: " . $_POST["file"]["type"] . "<br>";
  // echo "Size: " . $_FILES["file"]["size"] / 1024 . " KiB<br>";
  // echo "Stored in: " . $_FILES["file"]["tmp_name"];
  // $temp = explode(".", $_FILES["file"]["name"]);
  // $extension = end($temp);
  // if ($_FILES["file"]["size"] < 5000 && $extension == ".csv") {
// 				
  // } else {
  // echo "file uploded!";
  // }
} else {
  echo "not submitted";
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
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="images/logo.png" />  </div>
      <div class="menuLinks">
       <?php   require_once ("includes/menuNav.php");  ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBarProcess.php");
        ?>
      </div>
      <div class="contentBody">

        <form method="post" action="form_s_submit.php">
          <!--header-->
          <div style="width: 100%;">
            <table style="width: 100%">
              <tr>
                <td width="70px">
                  <div style="border: 1px solid black; padding: 10px">
                    Survey ID <br/>
                    <input type="text" size="9" name="survey_id" value="000174"/><br/>
                  </div>
                </td>
                <td><img src="images/pill.png"/></td>
                <td align="center">
                  <b style="font-size: 17px; ">FORM S : SCHOOL TREATMENT SUMMARY FORM<br/>(ALBENDAZOLE)</b>
                </td>
                <td><b style="font-size: 60px">S</b></td>
              </tr>
            </table>
          </div><br/>
          <form action="form_s_upload.php" method="post" enctype="multipart/form-data">
            <label for="file">Filename: </label>
            <input type="file" name="file" />
            <input type="submit" name="submit" value="upload" />
          </form> 
          <br/>
        </form>
        <h3>File upload</h3>
        <form action="upload/upload_form.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="section" value="1245" />
          <label for="file">Upload CSV file containing sections 1, 2, 4 and 5: </label>
          <input type="file" name="file" />
          <input type="submit" name="submit" value="Upload" />
        </form>
        <br /><br />
        <form action="upload/upload_form.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="section" value="3" />
          <label for="file">Upload CSV file containing section 3: </label>
          <input type="file" name="file" />
          <input type="submit" name="submit" value="Upload" />
        </form>
      </div>
    </div>
    <div class="clearFix"></div>
    </b>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->

    <script type="text/javascript">
      $(document).ready(function() {
        $("#deworming_date").datepicker({
          dateFormat: 'yy-mm-dd',
          showOn: 'focus',
          buttonImageOnly: true,
          buttonImage: 'calendar/cal.gif',
          buttonText: 'Pick a date',
          onClose: function(dateText, inst) {
            //$("#EndDate").val($("#proposedmovedate").val());
          }
        });
        $('#deworming_date').datepicker("option", 'minDate', new Date($("#deworming_date").datepicker('getDate')));
      });
    </script>
  </body>
</html>



