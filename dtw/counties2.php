<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
$level = $_SESSION['level'];
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
          $query = "DELETE FROM counties WHERE id='$deleteid'";
          $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
        }

        // number of districts in county
        function numberOfDistricts($county) {
          $query = "SELECT * FROM districts WHERE county='$county' ";
          $result = mysql_query($query) or die("<h1>Cant get districts</h1>" . mysql_error());
          $num = mysql_num_rows($result);
          return $num;
        }

        // number of divisions in county
        function numberOfDivisions($county) {
          $query = "SELECT * FROM divisions WHERE county='$county'";
          $result = mysql_query($query) or die("<h1>Cant get divisions</h1>" . mysql_error());
          $num = mysql_num_rows($result);
          return $num;
        }

        // number of divisins in schools
        function numberOfSchools($county) {
          $query = "SELECT * FROM schools WHERE county='$county'";
          $result = mysql_query($query) or die("<h1>Cant get county</h1>" . mysql_error());
          $num = mysql_num_rows($result);
          return $num;
        }
        ?>

        <form action="#">
          <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
          <a id="export-button" class="btn-custom-small" href="#">Export to Excel</a>
          <a class="btn-custom-small" href="#addCounty">Add County</a>
        </form>
        <br/>
        <div style=" margin-right: 20px">
          <form method="post">
            <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
              <thead>
                <tr style="border: 1px solid #B4B5B0;">
                  <th align="Left" width="15%">County</th>
                  <th align="Left" width="15%">County ID</th>
                  <th align="Left" width="15%">Number of <br/> Districts</th>
                  <th align="Left" width="15%">Number of <br/> Divisions</th>
                  <th align="Left" width="15%">Number of <br/> Schools</th>

                  <th align="center" width="5%">View</th>
                  <th align="center" width="5%">Edit</th>
                  <th align="center" width="5%">Del</th>
                </tr>
              </thead>
            </table>
          </form>
        </div>

        <div style="width:100%; height:470px; overflow-x: visible; overflow-y: scroll; ">
          <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover" id="data-table">
            <tbody>
              <?php
              $result_set = mysql_query("SELECT * FROM counties  ORDER BY county ASC ");
              while ($row = mysql_fetch_array($result_set)) {
                $id = $row['id'];
                $county = $row['county'];
                $county_id = $row['county_id'];
                ?>
                <tr style="border-bottom: 1px solid #B4B5B0;">

                  <td align="left" width="15%"> <?php echo $county; ?>  </td>
                  <td align="left" width="15%"> <?php echo $county_id; ?>  </td>
                  <td align="left" width="15%"> <?php echo $numberOfDistricts = numberOfDistricts($county); ?>  </td>
                  <td align="left" width="15%"> <?php echo $numberOfDivisions = numberOfDivisions($county); ?>  </td>
                  <td align="left" width="15%"> <?php echo $numberOfSchools = numberOfSchools($county); ?>  </td>

                  <td align="center" width="5%" class="exclude-from-export">
                    <!--view button-->
                    <form method="POST" action="#viewCounty">
                      <input type="hidden" name="county" value="<?php echo $county; ?>"/>
                      <input type="hidden" name="county_id" value="<?php echo $county_id; ?>"/>
                      <input type="hidden" name="numberOfDistricts" value="<?php echo $numberOfDistricts; ?>"/>
                      <input type="hidden" name="numberOfDivisions" value="<?php echo $numberOfDivisions; ?>"/>
                      <input type="hidden" name="numberOfSchools" value="<?php echo $numberOfSchools; ?>"/>

                      <input type="submit" name="viewDetails" value="" style="background: url(images/icons/view2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/>
                    </form>
                  </td>

                  <td align="center" width="5%" class="exclude-from-export">
                    <!--edit button-->
                    <form method="POST" action="#editCounty">
                      <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                      <input type="hidden" name="county" value="<?php echo $county; ?>"/>
                      <input type="hidden" name="county_id" value="<?php echo $county_id; ?>"/>
                      <input type="submit" name="editDetails" value="" style="background: url(images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/>
                    </form>
                  </td>

                  <td align="center" width="5%" class="exclude-from-export"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' class="exclude-from-export"><img src="images/icons/delete.png" height="20px"/></a></td>
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


    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.min.js"></script>

    <!--filter includes
    <script type="text/javascript" src="css/filter-as-you-type/jquery.min.js"></script>-->
    <script type="text/javascript" src="css/filter-as-you-type/jquery.quicksearch.js"></script>
    <script type="text/javascript">
                  $(function() {
                    $('input#id_search').quicksearch('table tbody tr');
                  });
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

    <script type="text/javascript" src="js/tableExport.js"></script>
    <script type="text/javascript" src="js/jquery.base64.js"></script>
    <script type="text/javascript">
      $('#export-button').click(function() {
        $('#data-table').tableExport({
          type: 'excel',
          escape: 'flse',
          consoleLog: 'true',
          gnoreColumn: [6, 7, 8]
        });
      });
    </script>

  </body>
</html>




<!--==== Modal ADD ======-->
<div id="addCounty" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <?php
    if (isset($_POST['submitAddCounty'])) {
      //Post Values to DB
      $county = $_POST['county'];
      $county = addslashes(trim($county));

      //Generate County ID
      $r1 = mysql_query("SELECT id FROM counties ORDER BY id DESC LIMIT 1");
      while ($row = mysql_fetch_array($r1)) {
        $last_county_id = $row['id'];
        $next_county_id = $last_county_id + 1;
      }
      $new_county_id = 'COUN' . '' . sprintf("%02d", $next_county_id);

      //Check if county_name Exists
      $query1 = "SELECT * FROM counties WHERE county = '{$_POST['county']}' LIMIT 1";
      $check_county = mysql_query($query1);
      $avail_county = mysql_num_rows($check_county);
      if ($avail_county == 0) {
        //insert data
        $query = ( "INSERT INTO counties (county, county_id) VALUES ('$county','$new_county_id')" );
        mysql_query($query) or die(mysql_error("Could not enter"));
        $messageToUser = "$county Added Successfully!";
      } else if ($avail_county >= 1) {
        $error_message.="Similar County name (" . $county . ") exists in the System.";
      }
    }
    ?>
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <div >
        <h1 class="form-title">Add County</h1><br/>
      </div>
      <center>
        <div style="padding: 5px; margin: 0px auto">
          <table border="0">
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <thead>
              <tr>
                <td>County Name </td><td><input type="text" name="county" class="input_textbox" required/></td>
              </tr>
            </thead>
          </table>
        </div>
      </center>
      <br/><br/>
      <center>
        <div>
          <input type="submit" class="btn-custom" name="submitAddCounty"  value="Add County"/>
          <a href="counties.php" class="btn-custom">Return to County List</a>
        </div>
      </center>
    </form>
  </div>
</div>


<!--==== Modal EDIT ======-->
<div id="editCounty" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <?php
    if (isset($_POST['editDetails'])) {
      $id = $_POST['id'];
      $county = $_POST['county'];
      $county_id = $_POST['county_id'];
    }
    if (isset($_POST['submitEditCounty'])) {
      $id = $_POST['id'];
      $county = $_POST['county'];
      $county_id = $_POST['county_id'];

      $county = addslashes(trim($county));
      $county_id = addslashes(trim($county_id));

      //Check if county_name Exists
      $query1 = "SELECT * FROM counties WHERE county = '{$_POST['county']}' LIMIT 1";
      $check_county = mysql_query($query1);
      $avail_county = mysql_num_rows($check_county);
      if ($avail_county == 0) {
        $query = ( "UPDATE counties SET
						county ='$county',
				    county_id = '$county_id' WHERE id='$id' " );
        mysql_query($query) or die(mysql_error("Could not enter"));
        $messageToUser = "$county Edited Successfully!";
      } else if ($avail_county >= 1) {
        $error_message.="Similar County name (" . $county . ") exists in the System.";
      }
    }
    ?>
    <form action="" method="post">
      <?php include("includes/messageBox.php"); ?>
      <div >
        <h1 class="form-title">Edit County</h1><br/>
      </div>
      <center>
        <div style="padding: 5px; margin: 0px auto">
          <table border="0">
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <tr>
              <td>County </td><td><input type="text" name="county" class="input_textbox" value="<?php echo $county; ?>"/></td>
            </tr>
            <tr>
              <td>County ID</td><td><input type="text" name="county_id" class="input_textbox" value="<?php echo $county_id; ?>" readonly/></td>
            </tr>
          </table>
        </div>
      </center>
      <br/><br/>
      <center>
        <div>
          <input type="submit" class="btn-custom" name="submitEditCounty"  value="Edit County Details"/>
          <a href="counties.php" class="btn-custom">Return to County List</a>
        </div>
      </center>
    </form>
  </div>
</div>



<!--===== Modal View ===========================-->
<div id="viewCounty" class="modalDialog">
  <div>
    <a href="#close" title="Close" class="close">X</a>
    <div >
      <h1 class="form-title">View County</h1><br/>
    </div>
    <?php
    if (isset($_POST['viewDetails'])) {
      $county = $_POST['county'];
      $county_id = $_POST['county_id'];
      $numberOfDistricts = $_POST['numberOfDistricts'];
      $numberOfDivisions = $_POST['numberOfDivisions'];
      $numberOfSchools = $_POST['numberOfSchools'];
    }
    ?>
    <center>
      <div style="padding: 5px; margin: 0px auto">
        <table border="0">
          <input type="hidden" name="id" value="<?php echo $id; ?>"/>
          <tr>
            <td>County </td><td><input type="text"  class="input_textbox" value="<?php echo $county; ?>" readonly/></td>
          </tr>
          <tr>
            <td>County ID</td><td><input type="text" class="input_textbox" value="<?php echo $county_id; ?>" readonly /></td>
          </tr>
          <tr>
            <td>Number Of Districts</td><td><input type="text" class="input_textbox" value="<?php echo $numberOfDistricts; ?>" readonly style="width: 50px; text-align: center"/></td>
          </tr>
          <tr>
            <td>Number Of Divisions</td><td><input type="text" class="input_textbox" value="<?php echo $numberOfDivisions; ?>" readonly style="width: 50px; text-align: center"/></td>
          </tr>
          <tr>
            <td>Number Of Schools</td><td><input type="text" class="input_textbox" value="<?php echo $numberOfSchools; ?>" readonly style="width: 50px; text-align: center"/></td>
          </tr>
        </table>
      </div>
    </center>
    <br/>
    <center>
      <div>
        <a href="#close" class="btn-custom" > Close</a>
      </div>
    </center>
  </div>