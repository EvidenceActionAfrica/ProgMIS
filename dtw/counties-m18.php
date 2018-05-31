<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
require_once ("includes/form_functions.php");


require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");

$image = new image;
$insertFile = new UploadFIle;


if (isset($_POST['uploadCSV'])) {
    $table = "counties";
    if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
        $csvMessage = "Upload Failed";
    } else {
        //  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        //  echo "Type: " . $_FILES["file"]["type"] . "<br>";
        //  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        //  echo "Stored in: " .
        $temp = $_FILES["file"]["tmp_name"];
        $csvMessage = "Upload Successful";
    }


    $filename = $image->upload_image($temp);

    $csvMessage=$insertFile->insertFile($filename, $table);
    //Connect as normal above
}


// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
    $priv_counties = $row['priv_counties'];
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
                include("includes/logTracker.php");

                if (isset($_GET['deleteid'])) {
                    $deleteid = $_GET['deleteid'];
                    $query = "DELETE FROM counties WHERE id='$deleteid'";
                    $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());

                    //log entry
                    $staff_id = $_SESSION['staff_id'];
                    $staff_email = $_SESSION['staff_email'];
                    $staff_name = $_SESSION['staff_name'];
                    $action = "Delete \"A County \"";
                    $description = "Record ID: " . $deleteid . " deleted";
                    $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
                    funclogAdminData($arrLogAdminData);
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

                //count all the row of the table
                function row_total() {
                    $query_row = "SELECT * FROM counties";
                    $result_row = mysql_query($query_row) or die(mysql_error());
                    $num_row = mysql_num_rows($result_row);
                    return $num_row;
                }
                ?>

                <form action="#">
        <!---          <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
                    -->
                    <?php if ($priv_counties >= 4) { ?>
                        <a class="btn-custom-small" href="#importCSV">Import</a>
                    <?php } ?>
                    <b style="margin-left:20%;width: 100px; font-size:1.5em;">Counties List</b>
                    <a class="btn-custom-small" href="PHPExcel/AdminData/counties.php">Export to Excel</a>
                    <!--<a id="export-button" class="btn-custom-small" href="#">Export to Excel</a>-->
                    <?php if ($priv_counties >= 2) { ?>
                        <a class="btn-custom-small" href="#addCounty">Add County</a>
                    <?php } ?>


                </form>

                <br/>
                <!---  <div style=" margin-right: 20px;">
                          <form method="post">
                            <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                              <thead>
                                <tr style="border-bottom: 1px solid #B4B5B0;">
                                  <th align="Left" width="15%">County</th>
                                  <th align="Left" width="15%">County ID</th>
                                  <th align="Left" width="15%">Number of <br/> Sub-Counties</th>
                                  <th align="Left" width="15%">Number of <br/> Wards</th>
                                  <th align="Left" width="15%">Number of <br/> Schools</th>
                <?php if ($priv_counties >= 1) { ?>
                                                    <th align="center" width="5%">View</th>
                <?php } ?>
                <?php if ($priv_counties >= 3) { ?>
                                                    <th align="center" width="5%">Edit</th>
                <?php } ?>
                <?php if ($priv_counties >= 4) { ?>
                                                    <th align="center" width="5%">Del</th>
                <?php } ?>
                                </tr>
                              </thead>
                            </table>
                          </form>
                        </div>  -->
                <style>
                    table tbody tr td a{
                        text-decoration:none;
                        color:#000000;
                        width:100%;
                    }
                </style>

                <div class="table-responsive">


                    <table id="data-table" class="table table-responsive table-hover table-stripped">

                        <thead>
                            <tr>
                                <th align="Left">County</th>
                                <th align="Left">County ID</th>
                                <th align="Left">Number of <br/> Sub-Counties</th>
                                <th align="Left" >Number of <br/> Divisions</th>
                                <th align="Left" >Number of <br/> Schools</th>
                                <?php if ($priv_counties >= 4) { ?>
                                    <th align="center">Del</th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $result_set = mysql_query("SELECT * FROM counties  ORDER BY county ASC ");
                            if (mysql_num_rows($result_set) >= 0) {
                                while ($row = mysql_fetch_array($result_set)) {
                                    $id = $row['id'];
                                    $county = $row['county'];
                                    $county_id = $row['county_id'];
                                    $numberOfDistricts = numberOfDistricts($county);
                                    $numberOfDivisions = numberOfDivisions($county);
                                    $numberOfSchools = numberOfSchools($county);
                                    if ($priv_counties >= 3) {
                                        $link = "counties.php?";
                                        $link.="county_id=$county_id&county=$county&numberOfDistricts=$numberOfDistricts";
                                        $link.="&numberOfDivisions=$numberOfDivisions&numberOfSchools=$numberOfSchools&id=$id&editDetails=1";
                                        $link.="#editCounty";
                                    } else if ($priv_counties >= 1) {
                                        $link = "counties.php?county_id=$county_id&county=$county&numberOfDistricts=$numberOfDistricts";
                                        $link.="&numberOfDivisions=$numberOfDivisions&numberOfSchools=$numberOfSchools&id=$id&editDetails=1";
                                        $link.="#viewCounty";
                                    } else {
                                        $link = "counties.php#";
                                    }
                                    ?>

                                    <tr style="border-bottom: 1px solid #B4B5B0;">

                                        <td align="left" width="15%"> <?php echo "<a href=$link>" . $county . "</a>"; ?>  </td>
                                        <td align="left" width="15%"> <?php echo "<a href=$link>" . $county_id . "</a>"; ?>  </td>
                                        <td align="left" width="15%"> <?php echo "<a href=$link>" . $numberOfDistricts . "</a>"; ?>  </td>
                                        <td align="left" width="15%"> <?php echo "<a href=$link>" . $numberOfDivisions . "</a>"; ?>  </td>
                                        <td align="left" width="15%"> <?php echo "<a href=$link>" . $numberOfSchools . "</a>"; ?>  </td>

                                        <?php if ($priv_counties >= 4) { ?>
                                            <td align="center" width="5%" class="exclude-from-export"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' class="exclude-from-export"><img src="images/icons/delete.png" height="20px"/></a></td>
                                        <?php } ?>

                                    </tr>

                                    <?php
                                }
                            } else {
                                ?>

                                <p><b>No Record Found</b></p>

                            <?php } ?>

                        </tbody>

                    </table>
                    <b style="padding-bottom: 2%; padding-left: 1%" > Total Number of records: <?php echo number_format(row_total()); ?> rows.</b> 

                </div>

                <!--================================================-->
            </div><!--end of content Main -->
        </div>
        <div class="clearFix"></div>
        <!---------------- Footer ------------------------>
        <!--<div class="footer">  </div>-->



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
                    escape: 'false',
                    consoleLog: 'true',
                    ignoreColumn: [6, 7, 8],
                    htmlContent: 'true'
                });
            });
        </script>


    </body>
</html>




<!--==== Modal ADD ======-->
<div id="addCounty" class="modalDialog">
    <div style="width:400px">
        <a href="#close" title="Close" class="close">X</a>
        <?php
        if (isset($_POST['submitAddCounty'])) {
            //Post Values to DB
            $county = $_POST['county'];
            $county = addslashes(trim($county));

            //log entry
            $staff_id = $_SESSION['staff_id'];
            $staff_email = $_SESSION['staff_email'];
            $staff_name = $_SESSION['staff_name'];

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
                $action = "Added A CountY";
                $description = "County Name: " . $county . " Added";
            } else if ($avail_county >= 1) {
                $error_message.="Similar County name (" . $county . ") exists in the System.";

                //Log Entry Data
                $action = "County Addition Failed";
                $description = "County Name: " . $county . "Failed to Add";
            }
            //Log Entry Data
            $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
            funclogAdminData($arrLogAdminData);
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
    <div style="width:450px">
        <a href="#close" title="Close" class="close">X</a>
        <?php
        if (isset($_GET['editDetails'])) {
            $id = $_GET['id'];
            $county = $_GET['county'];
            $county_id = $_GET['county_id'];
        }
        if (isset($_POST['submitEditCounty'])) {
            //Log Entry Data
            $staff_id = $_SESSION['staff_id'];
            $staff_email = $_SESSION['staff_email'];
            $staff_name = $_SESSION['staff_name'];
            //

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
                $action = "Edited A County";
                $description = "County Name: " . $county . " Edited";
                mysql_query($query) or die(mysql_error("Could not enter"));
                $messageToUser = "$county Edited Successfully!";
            } else if ($avail_county >= 1) {
                $error_message.="Similar County name (" . $county . ") exists in the System.";
                $action = "Failed To Edit A CountY";
                $description = "County Name: " . $county . " Not Edited";
            }


            //Log Entry Data
            $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
            funclogAdminData($arrLogAdminData);
        }
        ?>
        <form action="" method="post">
            <?php include("includes/messageBox.php"); ?>
            <div style="width">
                <h1 class="form-title">Edit County</h1><br/>
            </div>
            <center>
                <div style="padding: 5px; margin: 0px auto; width:400px">
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
<!--===== Modal Import ===========================-->
<div id="importCSV" class="modalDialog">
    <div style="width:380px">
        <a href="#close" title="Close" class="close">X</a>
        <div >
            <h1 class="form-title">Upload Counties</h1><br/>
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
                    <?php if ($priv_counties >= 4) { ?>
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
<div id="viewCounty" class="modalDialog">
    <div style="width:380px">
        <a href="#close" title="Close" class="close">X</a>
        <div >
            <h1 class="form-title">View County</h1><br/>
        </div>
        <?php
        if (isset($_GET['viewDetails'])) {
            $county = $_GET['county'];
            $county_id = $_GET['county_id'];
            $numberOfDistricts = $_GET['numberOfDistricts'];
            $numberOfDivisions = $_GET['numberOfDivisions'];
            $numberOfSchools = $_GET['numberOfSchools'];
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
                        <td>Number Of Sub-Counties</td><td><input type="text" class="input_textbox" value="<?php echo $numberOfDistricts; ?>" readonly style="width: 50px; text-align: center"/></td>
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
</div>

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

