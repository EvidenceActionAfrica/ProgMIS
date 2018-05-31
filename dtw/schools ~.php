<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");
require_once('includes/db_functions.php');
require_once("includes/logTracker.php");
$evidenceaction = new EvidenceAction();
$level = $_SESSION['level'];


// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_divisions = $row['priv_divisions'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("includes/meta-link-script.php");
    ?>

    <link rel="stylesheet" type="text/css" href="css/textext.core.css">
      <link rel="stylesheet" type="text/css" href="css/textext.plugin.tags.css">
        <link rel="stylesheet" type="text/css" href="css/textext.plugin.autocomplete.css">
          <script src="js/jquery.min.js"></script>

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
                  $query = "DELETE FROM schools WHERE id='$deleteid'";
                  $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
                  //header("Location:masterTrainerView.php?status=deleted&mstatus=mt");
                  //log entry
                  $staff_id = $_SESSION['staff_id'];
                  $staff_email = $_SESSION['staff_email'];
                  $staff_name = $_SESSION['staff_name'];
                  $action = "Delete \"Counties\" ";
                  $description = "Record ID: " . $deleteid . " deleted";
                  $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
                  funclogAdminData($arrLogAdminData);
                }

                if (isset($_POST['search_table'])) {
                  $county = $_POST['county'];
                  $district_name = $_POST['district_name'];
                  $division_name = $_POST['division_name'];
                  $school_name = $_POST['school_name'];
                  $school_id = $_POST['school_id'];
                  $school_type = $_POST['school_type'];
                  $searchQuery = "SELECT * FROM schools WHERE county LIKE '%$county%'
                        AND district_name LIKE '%$district_name%'
                        AND division_name LIKE '%$division_name%'
                        AND school_name LIKE '%$school_name%'
                        AND school_id LIKE '%$school_id%'
                        AND school_type LIKE '%$school_type%' ORDER BY county,district_name,division_name,school_name ASC  ";
                  $result_set = mysql_query($searchQuery);
                } else if (isset($_POST['advanced_search_table'])) {

                  $myArray = json_decode($_POST['filters']);

                  $myArray = join("', '", $myArray);

                  $searchQuery = "SELECT * FROM schools WHERE division_name IN ('$myArray')";
                  $result_set = mysql_query($searchQuery);
                } else {
                  $resultSQL = "SELECT * FROM schools ORDER BY county,district_name,division_name,school_name ASC LIMIT 300";
                  if ($_GET["Page"]) {
                    $pageOffset = isset($_GET["Page"]) ? $_GET["Page"] : 1;
                    $offset = ($pageOffset - 1) * 300;
                    $resultSQL.=" OFFSET " . $offset;
                  }
                  $result_set = mysql_query($resultSQL);
                }
                $sqlMax = "Select * from schools";
                $resultMax = mysql_query($sqlMax);
                $max = mysql_num_rows($resultMax);

                $query_suggestions = mysql_query("SELECT DISTINCT division_name FROM schools");

                $suggestions = array();

                while ($var = mysql_fetch_assoc($query_suggestions)) {
                  array_push($suggestions, $var['division_name']);
                }

                $suggestions = join("', '", $suggestions);




                if (isset($_POST['btnSubmitPage'])) {
                  $resultSQL = "SELECT * FROM schools ORDER BY county,district_name,division_name,school_name ASC LIMIT 300";
                  if ($_POST["selectPageNumber"]) {
                    $pageOffset = isset($_POST["selectPageNumber"]) ? $_POST["selectPageNumber"] : 1;

                    $offset = ($pageOffset - 1) * 300;
                    $resultSQL.=" OFFSET " . $offset;
                  }
                  $result_set = mysql_query($resultSQL);
                }
                ?>
                <!--<h1 >School List</h1>-->
                <form action="#">
                    <!---
                  <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
                -->
                    <img src="images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
                  <b style="margin-left:20%;width: 100px; font-size:1.5em;">Schools List</b>
                  <a class="btn-custom-small" href="PHPExcel/AdminData/schools.php?county=<?php echo $county; ?>&district_name=<?php echo $district_name; ?>&division_name=<?php echo $division_name; ?>&school_id=<?php echo $school_id; ?>&school_type=<?php echo $school_type; ?>">Export to Excel</a>
                  <a class="btn-custom-small" href="#addSchool">Add School</a>
                </form>

                <div style="display:inline-block;width:100%;">

                  <?php
                  $pages = ceil($max / 300);

                  $count = isset($_GET["Page"]) ? $_GET["Page"] : 1;
                  if ($count > $pages) {
                    $count = 1;
                  }
                  if ($count > 1) {
                    $countMin = $count - 1;
                  } else {
                    $countMin = 1;
                  }$countPlus = $count + 1;
                  $countMax = $count + 5;
                  while ($countMax > $pages) {
                    --$countMax;
                  }

//newMax
                  $newMax = 1;
                  /*
                    echo "<a href='schools_2.php?Page=1'><<|</a> &nbsp;&nbsp;";
                    echo "<a href='schools_2.php?Page=$countMin'><|</a> &nbsp;&nbsp;";
                    while ($count < $countMax) {
                    echo "<a  href='schools_2.php?Page=$count'>$count</a> &nbsp;&nbsp;";
                    $count++;
                    }
                    echo "<a  href='schools_2.php?Page=$countPlus'>>></a> &nbsp;&nbsp;";
                    echo "<a href='schools_2.php?Page=$pages'>|>></a> &nbsp;&nbsp;";
                   */
                  if ($pageOffset <= 1) {
                    $pageOffset = 1;
                  }
                  ?>
                  <form method="post" >
                    <b> Page </b>
                    <select name='selectPageNumber' onchange='submitPage();' style='width:70px'>
                      <?php
                      if ($newMax == $pageOffset) {
                        $newMax = 2;
                      }
                      ?>
                      <option value="<?php echo $pageOffset ?>"><?php echo $pageOffset ?></option>
                        <?php
                        while ($newMax <= $pages) {
                          echo "<option value=$newMax> $newMax</option>";
                          ++$newMax;
                        }
                        ?>
                    </select> 
                    <b>of</b>  <?php echo $pages; ?> <b>Schools list Pages</b>
                    <input  type="submit" value="submitPage" name='btnSubmitPage' id='btnSubmitPage' style="visibility: hidden"/>
                  </form>
                  <p id="advanced_open" class="pull-right btn btn-small" style="color:#333;cursor:pointer;margin-right: 20px;">Advanced Search</p>
                </div>

                <div style="margin-right: 20px" id="search_div" >
                  <form method="post">
                    <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                      <thead>
                        <tr style="border-bottom:0px;">
                          <th align="center" width="10%">
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
                          <th align="center" width="10%">
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
                          <th align="center" width="15%"><input type="text" style="width: 98%" name="school_id"    value="<?php echo $school_id ?>"/></th>
                          <th align="center" width="10%">
                            <select  name="school_type" style="width: 100%" onchange="submitForm();">
                              <option value=''<?php if ($school_type == '') echo 'selected'; ?> ></option>
                              <option value='Public'<?php if ($school_type == 'Public') echo 'selected'; ?>>Public</option>
                              <option value='Private'<?php if ($school_type == 'Private') echo 'selected'; ?>>Private</option>
                              <option value='Other'<?php if ($school_type == 'Other') echo 'selected'; ?>>Other</option>
                            </select>
                          </th>
                          <th align="center" width="12%" colspan="3"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                        </tr>
                      </thead>
                    </table>
                  </form>

                </div>


                <!--Advanced Search Container-->
                <div id="advanced_search_div" style="display:none;margin:0 auto 20px;opacity:0;margin-left:45%;"> 
                  <p id="advanced_close" class="pull-right btn-small btn-warning"  style="margin:-25px 20px 0 0;cursor:pointer;float:right;">X Close</p>
                  <style type="text/css">
                    .text-wrap {
                      height:50px!important;
                    }
                  </style>
                  <form action="schools_2.php" method="post">
                    <label for="textarea">Enter multiple Division names in the text-area below:</label>
                    <textarea id="textarea" class="example" rows="1" style="width:400px;height:50px;" name="filters"></textarea>
                    <input type="submit" class="btn-filter btn-info" value="Search" name="advanced_search_table"/>
                  </form>
                  <script type="text/javascript" src="js/textext.core.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.autocomplete.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.tags.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.suggestions.js"></script>
                  <script type="text/javascript" src="js/textext.plugin.filter.js"></script>
                  <script type="text/javascript">
            var suggestion = ['<?php echo $suggestions ?>'];
            $('#textarea')
                    .textext({
              plugins: 'autocomplete suggestions tags filter',
              suggestions: suggestion
            });
                  </script>
                </div>

                <div>
                  <table id="data-table" class="table table-responsive table-hover table-stripped">
                    <thead>
                      <tr style="border-bottom: 1px solid #B4B5B0;">
                        <th>County</th>
                        <th>Sub-Counties</th>
                        <th>Ward</th>
                        <th>School Name</th>
                        <th>School ID</th>
                        <th>School Type</th>
                     <?php if ($priv_divisions >= 1) { ?>
                        <th>View</th>
                          <?php } ?>
                        <?php if ($priv_divisions >= 3) { ?>
                        <th>Edit</th>
                         <?php } ?>
                        <?php if ($priv_divisions >= 4) { ?>
                        <th>Del</th>
                        <?php } ?>
                      </tr>
                    </thead>
                  <tbody>
                      <?php
                      $count = 0;
                      while ($row = mysql_fetch_array($result_set)) {
                        $id = $row['id'];
                        $county = $row['county'];
                        $district_name = $row['district_name'];
                        $division_name = $row['division_name'];
                        $school_name = $row['school_name'];
                        $school_id = $row['school_id'];
                        $school_type = $row['school_type'];
                        ?>
                        <tr>

                          <td> <?php echo $county; ?>  </td>
                          <td> <?php echo $district_name; ?> </td>
                          <td> <?php echo $division_name; ?> </td>
                          <td> <?php echo $school_name; ?> </td>
                          <td> <?php echo $school_id; ?> </td>
                          <td> <?php echo $school_type; ?>  </td>
                    <?php if ($priv_divisions >= 1) { ?>
                          <!--view button-->
                          <form method="POST" action="#viewSchool">
                            <input type="hidden" name="county" value="<?php echo $county; ?>"/>
                            <input type="hidden" name="district_name" value="<?php echo $district_name; ?>"/>
                            <input type="hidden" name="division_name" value="<?php echo $division_name; ?>"/>
                            <input type="hidden" name="school_name" value="<?php echo $school_name; ?>"/>
                            <input type="hidden" name="school_id" value="<?php echo $school_id; ?>"/>
                            <input type="hidden" name="school_type" value="<?php echo $school_type; ?>"/>

                            <td align="center" width="4%"><input type="submit" name="viewDetails" value="" style="background: url(images/icons/view2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                            <!--<td align="center" width="4%"><a href="#viewSchool"><img src="images/icons/view.png" height="20px"></a></td>-->
                          </form>
                              <?php } ?>
                        <?php if ($priv_divisions >= 3) { ?>
                          <!--edit button-->
                          <form method="POST" action="#editSchool">
                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <input type="hidden" name="county" value="<?php echo $county; ?>"/>
                            <input type="hidden" name="district_name" value="<?php echo $district_name; ?>"/>
                            <input type="hidden" name="division_name" value="<?php echo $division_name; ?>"/>
                            <input type="hidden" name="school_name" value="<?php echo $school_name; ?>"/>
                            <input type="hidden" name="school_id" value="<?php echo $school_id; ?>"/>
                            <input type="hidden" name="school_type" value="<?php echo $school_type; ?>"/>
                            <td align="center" width="4%"><input type="submit" name="editDetails" value="" style="background: url(images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                            <!--<td align="center" width="4%"><a href="schoolsEdit.php?id=<?php echo $data['id']; ?>"><img src="images/icons/edit.png" height="20px"></a></td>-->
                          </form>
                            <?php } ?>
                        <?php if ($priv_divisions >= 4) { ?>
                          <td align="center" width="4%"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="images/icons/delete.png" height="20px"></a></td>
                        <?php } ?>
                        </tr>
                     
                    <?php } ?>
                       </tbody>
                  </table>
                </div>
                <br/>


                <!--================================================-->
              </div><!--end of content Main -->
            </div>
            <div class="clearFix"></div>
            <!---------------- Footer ------------------------>
            <!--<div class="footer">  </div>-->


            <script>
            function submitForm() {
              document.getElementById('imgLoading').style.visibility = "visible";
              var selectButton = document.getElementById('btnSearchSubmit');
              selectButton.click();
            }
            function submitPage() {
              var selectButton = document.getElementById('btnSubmitPage');
              selectButton.click();
            }
            </script>
            <!--Delete dialog-->
            <script>
              function show_confirm(deleteid) {
                if (confirm("Are You Sure you want to delete?")) {
                  location.replace('?deleteid=' + deleteid);
                } else {
                  return false;
                }
              }
            </script>
            <!--Toggle Advanced Search-->
            <script type="text/javascript">
              var searchHeight = $('#search_div').innerHeight() + $('#advanced_open').outerHeight();
              $("#advanced_open").click(function() {
                $('#search_div').animate({
                  'height': 0, 'opacity': 0
                }, 100, function() {
                  $(this).css('display', 'none');
                  $('#advanced_search_div').css({
                    'display': 'inline-block', 'height': 'auto', }).animate({
                    'opacity': 1
                  }, 200);
                });
              });
              $('#advanced_close').click(function() {
                $('#advanced_search_div').animate({
                  'height': 0, 'opacity': 0
                }, 200, function() {
                  $(this).css('display', 'none');
                  $('#search_div').css({'display': 'block'}).animate({
                    'height': '26px', 'opacity': '1'
                  }, 100);
                });
              });
            </script>
          </body>
          </html>




          <!--==== Modal ADD ======-->
          <div id="addSchool" class="modalDialog">
            <div>
              <a href="#close" title="Close" class="close">X</a>


              <?php
              if (isset($_POST['submitAddSchool'])) {
                //Posted Values
                $county = $_POST['selectcounty'];
                $district_name = $_POST['selectdistrict'];
                $division_name = $_POST['selectdivision'];
                $school_name = $_POST['school_name'];
                $school_type = $_POST['school_type'];

                $county = addslashes(trim($county));
                $district_name = addslashes(trim($district_name));
                $division_name = addslashes(trim($division_name));
                $school_name = addslashes(trim($school_name));
                $school_type = addslashes(trim($school_type));
                
                
                //Get COunty ID Code
                $rCounty = mysql_query("SELECT county_id FROM counties WHERE county = '$county'");
                while ($row = mysql_fetch_array($rCounty)) {
                  $county_id = $row['county_id'];
                }
               // ============================
                //Get district ID Code
                $rCounty = mysql_query("SELECT district_id FROM districts WHERE district_name = '$district_name'");
                while ($row = mysql_fetch_array($rCounty)) {
                 $district_id = $row['district_id'];
                }
               // ============================
                
                // ============================
                //Get division ID Code
                $rCounty = mysql_query("SELECT division_id FROM divisions WHERE division_name = '$division_name'");
                while ($row = mysql_fetch_array($rCounty)) {
                 $division_id = $row['division_id'];
                }
               // ============================
                

                //Get District Code
                $result = mysql_query("SELECT RIGHT(district_id,3)  FROM districts  WHERE district_name = '$district_name'");
                while ($row = mysql_fetch_array($result)) {
                  $district_code = $row['RIGHT(district_id,3)'];
                }
                //Get Division Code
                $result = mysql_query("SELECT RIGHT(division_id,3)  FROM divisions  WHERE division_name = '$division_name' ");
                while ($row = mysql_fetch_array($result)) {
                  $division_code = $row['RIGHT(division_id,3)'];
                }
                $first_2_letters = strtoupper(substr("{$_POST['school_name']}", 0, 2));
                //Count No of Schools with Similar first TWO Letters
                $result = mysql_query("SELECT COUNT(LEFT(school_name,2))  FROM schools  WHERE district_name = '$district_name' AND division_name = '$division_name' AND LEFT(school_name,2) = '$first_2_letters'");
                while ($row = mysql_fetch_array($result)) {
                  $total_schools = $row['COUNT(LEFT(school_name,2))'];
                  $new_school_id = $district_code . '-' . $division_code . '-' . $first_2_letters . '' . str_pad(($total_schools + 1), 2, "0", STR_PAD_LEFT);
                }


                //Check if school_name Exists
                $query1 = "SELECT * FROM schools WHERE county = '$county' AND district_name = '$district_name' AND division_name = '$division_name' AND school_name = '$school_name' AND school_type = '$school_type' LIMIT 1";
                $check_school = mysql_query($query1);
                $avail_school = mysql_num_rows($check_school);
                if ($avail_school == 0) {

                  $query = ( "INSERT INTO schools (county,county_id,district_id,district_name,division_id,division_name,school_name,school_id,school_type) VALUES (
                        '$county',
                        '$county_id',
						'$district_id',
                        '$district_name',
						'$division_id',
                        '$division_name',
                        '$school_name',
                        '$new_school_id',
                        '$school_type')" );
					//	echo $query;
                  mysql_query($query) or die(mysql_error("Could not enter"));
                  $messageToUser = "$school_name Added Successfully!";
                  //log entry
                  $action = "Added \"School\"";
                  $description = "Record ID: " . $new_school_id . "/" . $school_name . " Added";
                } else if ($avail_school >= 1) {
                  $error_message.="Similar School Name (" . $school_name . ")  exists in the System.";
                  //log entry
                  $action = "Failed to \"Add A School\"";
                  $description = "Record ID: " . $new_school_id . "/" . $school_name . " failed to Add";
                }


                //log entry

                $staff_id = $_SESSION['staff_id'];
                $staff_email = $_SESSION['staff_email'];
                $staff_name = $_SESSION['staff_name'];

                $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
                funclogAdminData($arrLogAdminData);
              }
              ?>
              <form action="" method="post">
                <?php include("includes/messageBox.php"); ?>
                <div >
                  <h1 class="form-title">Add School</h1><br/>
                </div>
                <div style="padding: 5px;">
                  <!--left div-->
                  <div style="float: left; width: 49%;">
                    <h3 >Geographic Details</h3>
                    <table border="0">
                      <thead>
                        <tr>
                          <td>County </td>
                          <td>
                            <?php
                            $tablename = 'counties';
                            $fields = 'id, county';
                            $where = '1=1 order by county asc';
                            $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                            ?>
                            <select onchange="get_district(this.value);" id="selectcounty" name="selectcounty" class="input_select" required >
                              <option value="">Choose County</option>
                              <?php foreach ($insertformdata as $insertformdatacab) { ?>
                                <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
                              <?php } ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Sub-Counties </td>
                          <td>
                            <select onchange="get_division(this.value);" id="selectdistrict" name="selectdistrict" class="input_select" required>
                              <option value="">Choose Sub-County</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Ward </td>
                          <td>
                            <select onchange="get_school(this.value);" id="selectdivision" name="selectdivision" class="input_select" required>
                              <option value="">Choose Ward</option>
                            </select>
                          </td>
                        </tr>
                      </thead>
                    </table >
                  </div>
                  <!--Right div-->
                  <div style="float: left; width: 49%">
                    <h3 >School Information Details</h3>
                    <table border="0">
                      <thead>
                        <tr>
                          <td>School Name </td><td><input type="text" name="school_name" class="input_textbox" placeholder="" value="" required /></td>
                        </tr>
                        <tr>
                          <td> </td><td> </td>
                        </tr>
                        <tr>
                          <td>School Type </td>
                          <td>
                            <select  name="school_type" class="input_select" required>
                              <option value='' ></option>
                              <option value='Public'>Public</option>
                              <option value='Private'>Private</option>
                              <option value='Private'>Other</option>
                            </select>
                          </td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div><div class="vclear"></div>
                <br/><br/>
                <center>
                  <div>
                    <input type="submit" class="btn-custom" name="submitAddSchool"  value="Add School"/>
                  </div>
                </center>
              </form>
            </div>
          </div>


          <!--==== Modal EDIT ======-->
          <div id="editSchool" class="modalDialog">
            <div>
              <a href="#close" title="Close" class="close">X</a>
              <?php
              if (isset($_POST['editDetails'])) {
                $id = $_POST['id'];
                $county = $_POST['county'];
                $district_name = $_POST['district_name'];
                $division_name = $_POST['division_name'];
                $school_name = $_POST['school_name'];
                $school_id = $_POST['school_id'];
                $school_type = $_POST['school_type'];
              }
              if (isset($_POST['submitEditSchool'])) {
                $id = $_POST['id'];
                $county = $_POST['county'];
                $district_name = $_POST['district_name'];
                $division_name = $_POST['division_name'];
                $school_name = $_POST['school_name'];
                $school_id = $_POST['school_id'];
                $school_type = $_POST['school_type'];

                $county = addslashes(trim($county));
                $district_name = addslashes(trim($district_name));
                $division_name = addslashes(trim($division_name));
                $school_name = addslashes(trim($school_name));
                $school_id = addslashes(trim($school_id));
                $school_type = addslashes(trim($school_type));

                //Check if school_name Exists
                $query1 = "SELECT * FROM schools WHERE county = '$county' AND district_name = '$district_name' AND division_name = '$division_name' AND school_name = '$school_name' AND school_type = '$school_type' LIMIT 1";
                $check_school = mysql_query($query1);
                $avail_school = mysql_num_rows($check_school);
                if ($avail_school == 0) {
                  $query = ( "UPDATE schools SET
                      county ='$county',
                      district_name = '$district_name',
                      division_name = '$division_name',
                      school_name = '$school_name',
                      school_id = '$school_id',
                      school_type = '$school_type' WHERE id='$id' " );
                  mysql_query($query) or die(mysql_error("Could not enter"));
                  $messageToUser = "Record Updated Successfully!";
                  $action = "Updated \"School\"";
                  $description = "Record ID: " . $school_id . "/" . $school_name . " edited";
                } else if ($avail_school >= 1) {
                  $error_message.="Similar School Name (" . $school_name . ") Exists in the System.";
                  $action = "Failed \"edit School\"";
                  $description = "Record ID: " . $school_id . "/" . $school_name . " failed to edit";
                }


                //log entry
                $staff_id = $_SESSION['staff_id'];
                $staff_email = $_SESSION['staff_email'];
                $staff_name = $_SESSION['staff_name'];

                $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
                funclogAdminData($arrLogAdminData);
              }
              ?>
              <form action="" method="post">
                <?php include("includes/messageBox.php"); ?>
                <div >
                  <h1 class="form-title">Edit School</h1><br/>
                </div>
                <div style="padding: 5px;">
                  <!--left div-->
                  <div style="float: left; width: 49%;">
                    <h3 >Geographic Details</h3>
                    <table border="0">
                      <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                      <tr>
                        <td>County </td>
                        <td>
                          <?php
                          $tablename = 'counties';
                          $fields = 'id, county';
                          $where = '1=1 order by county asc';
                          $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                          ?>
                          <select onchange="get_district2(this.value);" id="selectcounty2" name="county" class="input_select" required >
                            <option value="<?php echo $county; ?>"><?php echo $county; ?></option>
                            <?php foreach ($insertformdata as $insertformdatacab) { ?>
                              <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Sub-County </td>
                        <td>
                          <select onchange="get_division2(this.value);" id="selectdistrict2" name="district_name" class="input_select" required>
                            <option value="<?php echo $district_name; ?>"><?php echo $district_name; ?></option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Ward </td>
                        <td>
                          <select onchange="get_school2(this.value);" id="selectdivision2" name="division_name" class="input_select" required>
                            <option value="<?php echo $division_name; ?>"><?php echo $division_name; ?></option>
                          </select>
                        </td>
                      </tr>
                    </table >
                  </div>
                  <!--Right div-->
                  <div style="float: left; width: 49%">
                    <h3 >School Information Details</h3>
                    <table border="0">
                      <tr>
                        <td>School Name</td><td><input type="text" name="school_name" class="input_textbox" value="<?php echo $school_name; ?>" required/></td>
                      </tr>
                      <tr>
                        <td>School ID</td><td><input type="text" name="school_id" class="input_textbox" value="<?php echo $school_id; ?>" readonly/></td>
                      </tr>
                      <tr>
                        <td>School Type</td>
                        <td>
                          <select  name="school_type" class="input_select" required>
                            <option value=''<?php if ($school_type == '') echo 'selected'; ?> ></option>
                            <option value='Public'<?php if ($school_type == 'Public') echo 'selected'; ?>>Public</option>
                            <option value='Private'<?php if ($school_type == 'Private') echo 'selected'; ?>>Private</option>
                            <option value='Other'<?php if ($school_type == 'Other') echo 'selected'; ?>>Other</option>
                          </select>
                        </td>
                      </tr>
                    </table >
                  </div>
                </div><div class="vclear"></div>
                <br/><br/>
                <center>
                  <div>
                    <input type="submit" class="btn-custom" name="submitEditSchool"  value="Edit School Details"/>
                  </div>
                </center>
              </form>
            </div>
          </div>



          <!--===== Modal View ===========================-->
          <div id="viewSchool" class="modalDialog">
            <div>
              <a href="#close" title="Close" class="close">X</a>
              <div >
                <h1 class="form-title">View School</h1><br/>
              </div>
              <?php
              if (isset($_POST['viewDetails'])) {
                $county = $_POST['county'];
                $district_name = $_POST['district_name'];
                $division_name = $_POST['division_name'];
                $school_name = $_POST['school_name'];
                $school_id = $_POST['school_id'];
                $school_type = $_POST['school_type'];
              }
              ?>
              <div style="padding: 5px;">
                <!--left div-->
                <div style="float: left; width: 49%;">
                  <h3 >Geographic Details</h3>
                  <table border="0">
                    <tr>
                      <td>County</td><td><input type="text" class="input_textbox" value="<?php echo $county; ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td>Sub-County</td><td><input type="text" class="input_textbox" value="<?php echo $district_name; ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td>Ward</td><td><input type="text" class="input_textbox" value="<?php echo $division_name; ?>" readonly/></td>
                    </tr>
                  </table >
                </div>
                <!--Right div-->
                <div style="float: left; width: 49%">
                  <h3 >School Information Details</h3>
                  <table border="0">
                    <tr>
                      <td>School Name</td><td><input type="text" class="input_textbox" value="<?php echo $school_name; ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td>School ID</td><td><input type="text" class="input_textbox" value="<?php echo $school_id; ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td>School Type</td><td><input type="text" class="input_textbox" value="<?php echo $school_type; ?>" readonly/></td>
                    </tr>
                  </table >
                </div><div class="vclear"></div>
                <br/><br/>
                <center>
                  <div>
                    <a href="#close" class="btn-custom" > Close</a>
                  </div>
                </center>
              </div>



              <script>
              // ADD ====================================================================
              //GET district
              function get_district(txt) {
                $.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
                  $('#selectdistrict').html(data);//alert(data);
                });
              }
              //GET divisions
              function get_division(txt) {
                $.post('ajax_dropdown.php', {checkval: 'division', district: txt}).done(function(data) {
                  $('#selectdivision').html(data);//alert(data);
                });
              }
              //GET Schools
              function get_school(txt) {
                $.post('ajax_dropdown.php', {checkval: 'school', division: txt}).done(function(data) {
                  $('#selectschool').html(data);//alert(data);
                });
              }
              // EDIT =================================================================================
              //GET district
              function get_district2(txt) {
                $.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
                  $('#selectdistrict2').html(data);//alert(data);
                });
              }
              //GET divisions
              function get_division2(txt) {
                $.post('ajax_dropdown.php', {checkval: 'division', district: txt}).done(function(data) {
                  $('#selectdivision2').html(data);//alert(data);
                });
              }
              //GET Schools
              function get_school2(txt) {
                $.post('ajax_dropdown.php', {checkval: 'school', division: txt}).done(function(data) {
                  $('#selectschool2').html(data);//alert(data);
                });
              }
              </script>
              <script>
  
//==============================  block return key from submitting form ===============================
 document.onkeypress = function(e)  {
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

