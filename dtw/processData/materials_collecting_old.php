<?php
date_default_timezone_set("Africa/Nairobi");
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");

$tabActive = "tab1";
$level = $_SESSION['level'];
//$no_of_records = $_POST['no_of_records'];
$updateResult = "";
if (isset($no_of_records)) {
    $tabActive = "tab2";
}
if (isset($_GET["UndoBoxIdDT"])) {
    $tabActive = "tab3";
    $sql = "UPDATE materials_packaging_history_data set collected=0 WHERE box_id=" . $_GET["UndoBoxIdDT"];
    mysql_query($sql);
}
if (isset($_GET["UndoBoxIdTT"])) {
    $tabActive = "tab3";
    $sql = "UPDATE materials_packaging_history_ttb set collected=0 WHERE box_id=" . $_GET["UndoBoxIdTT"];
    mysql_query($sql);
}
if (isset($_POST["Get_Records"])) {
    $numRowsDT = $_POST["DTTOTAL"];
    $numRowsTT = $_POST["TTTOTAL"];


    $tabActive = "tab2";
    $count = 0;
    $boxDT = array();
    while ($count <= $numRowsDT) {
        if (isset($_POST["boxDT" . $count]) != NULL) {
            //  $boxDT[$count]=$_POST["boxDT".$count];
            array_push($boxDT, $_POST["boxDT" . $count]);
            //   echo $_POST["boxDT".$count]."<br/>";
        }
        ++$count;
    }
    $count = 0;
    $boxTT = array();
    while ($count <= $numRowsTT) {
        if (isset($_POST["boxTT" . $count]) != NULL) {
            //  $boxDT[$count]=$_POST["boxDT".$count];
            array_push($boxTT, $_POST["boxTT" . $count]);
            //     echo $_POST["boxTT".$count]."<br/>";
        }
        ++$count;
    }
    $_SESSION["boxDT"] = $boxDT;
    $_SESSION["boxTT"] = $boxTT;

    if (sizeof($boxDT) <= 0 && sizeof($boxTT) <= 0) {
        $no_of_records = 0;
    } else {
        $no_of_records = 1;
    }
//echo $no_of_records;
}
if (isset($_GET["DeleteId"])) {
    $id = $_GET["DeleteId"];
// sending query
    mysql_query("DELETE FROM collect_training_materials WHERE id = '$id'")or die(mysql_error());
    $tabActive = "tab2";
    $updateResult = "Record Deleted.";
}
//Submit Collect Training Materials Form
if (isset($_POST['Submit'])) {
    $tabActive = "tab2";
//Sel All Fields Populated
    $size = $no_of_records;
    $size = 1;
//echo "Total is".$no_of_records;
    $records = 0;
    while ($records < $size) {
        $date = $_POST['date'];
        $ministry = $_POST['ministry'];
        $purpose = $_POST['purpose'];
        $name = $_POST['name'][$records];
        $personal_no = $_POST['personal_no'][$records];
        $title = $_POST['title'][$records];
        $phone_no = $_POST['phone_no'][$records];
        $no_of_boxes = $_POST['no_of_boxes'][$records];
        $no_of_poles = $_POST['no_of_poles'][$records];
        $pby_name = $_POST['pby_name'];
        $pby_position = $_POST['pby_position'];
        $pby_contact = $_POST['pby_contact'];
        $pby_date = $_POST['pby_date'];

        $query = "INSERT INTO collect_training_materials (date,ministry,purpose,name,personal_no,title,phone_no,no_of_boxes,no_of_poles,pby_name,pby_position,pby_contact,pby_date) 
	VALUES('{$date}','{$ministry}','{$purpose}','{$name}','{$personal_no}','{$title}','{$phone_no}','{$no_of_boxes}','{$no_of_poles}','{$pby_name}','{$pby_position}','{$pby_contact}','{$pby_date}')";
        //echo $sql;
        mysql_query($query) or die("Error in query: $query");
        ++$records;
        $updateResult = "Record Saved.";
    }
    $boxDTCount = sizeof($_SESSION["boxDT"]);
    $boxTTCount = sizeof($_SESSION["boxTT"]);
    $numberM = $boxDTCount + $boxTTCount;
    $boxDT = $_SESSION["boxDT"];
    $boxTT = $_SESSION["boxTT"];
    $count = 0;

    while ($count <= $boxDTCount) {
        //Extract District & County

        if ($boxDT[$count] != NULL || $boxDT[$count] != "") {
            $sql = "UPDATE materials_packaging_history_data set collected=1,name='$name',phone='$phone_no',date='$date' WHERE package_id=" . $boxDT[$count];
            //   echo $sql;
            mysql_query($sql);
        }
        ++$count;
    }
    $count = 0;

    while ($count <= $boxTTCount) {
        //Extract District & County
        //   echo $boxDT[$count];
        if ($boxTT[$count] != NULL || $boxTT[$count] != "") {
            $sql = "UPDATE materials_packaging_history_ttb set collected=1,name='$name',phone='$phone_no',date='$date' WHERE package_id=" . $boxTT[$count];
            //  echo $sql;
            mysql_query($sql);
        }
        ++$count;
    }
}

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
    $priv_materials_edit = $row['priv_materials_edit'];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
    <head>
        <title>Evidence Action</title>
        <link href="../css/tabs_css.css" rel="stylesheet" type="text/css"/>
        <?php require_once ("includes/meta-link-script.php"); ?>
        <script src="../js/tabs.js"></script>
    </head>


    <body>
        <!---------------- header start ------------------------>
        <div class="header">
            <div style="float: left">  <img src="../images/logo.png" />  </div>
            <div class="menuLinks">
                <?php require_once ("includes/menuNav.php"); ?>
            </div>
        </div>
        <div class="clearFix"></div>
        <!---------------- content body ------------------------>
        <div class="contentMain">
            <div class="contentLeft">
                <?php
                require_once ("includes/menuLeftBar-Materials.php");
                ?>
            </div>

            <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
                <script src="//code.jquery.com/jquery-1.10.2.js"></script>
                <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
                <div class="contentBody" >
                    <h2 style="margin-left:20%;">Training Materials Collection</h2>
                    <div style="margin-left:0%;margin-top:0%;" class="alert alert-block">

                        Warning! &nbsp; This Form will only display data from the active Print Order And Packing Information.
                    </div>

                    <div class="tabbable" >
                        <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
                    </br><br/>

                <ul class="nav nav-tabs">

                    <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Inventory</a></li>
                    <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Materials Collection</a></li>
                    <li <?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">Materials Dispatched</a></li>
                    <li <?php if ($tabActive == 'tab4') echo "class='active'" ?>><a href="#tab4" data-toggle="tab">View Unconfirmed Sms History</a></li>


                </ul>
                <div class="tab-content" style="max-height:650px; overflow:scroll;">

                    <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                        <form action="materials_collecting.php" method="POST">
                            <?php
                            $sql = "select id from materials_printlist_history where status=1";
                            $resultQ = mysql_query($sql);
                            while ($row = mysql_fetch_array($resultQ)) {
                                $printlistId = $row["id"];
                            }


                            $sql = "SELECT * from materials_packaging_history_data where printlist_id='$printlistId' and collected=0";
                            $resultB = mysql_query($sql);
                            $count = 0;
                            $numRows = mysql_affected_rows();
                            if ($numRows >= 1) {
                                ?>
                                <table  class="table table-bordered table-condensed table-striped table-hover" >
                                    <caption><h2>District Training Boxes</h2></caption>
                                    <tr>

                                        <th>Collect</th>
                                        <th>Box Id</th>
                                        <th>County</th>
                                        <th>District</th>

                                    </tr>
                                    <?php
                                    while ($row = mysql_fetch_array($resultB)) {
                                        ?>

                                        <tr>
                                            <th><input type="checkbox"  name=<?php echo "boxDT" . $count . " value='" . $row["package_id"] . "'/></th><th>" . $row["box_id"] ?></th> <th><?php echo $row["county_name"] ?></th> <th><?php echo $row["district_name"] ?></th>
                                        </tr>



                                        <?php
                                        ++$count;
                                        $DTTOTAL = $count;
                                    }
                                    ?>
                                </table>
                                <input type="hidden" name="DTTOTAL" value="<?php echo $DTTOTAL; ?>" readonly/>
                                <?php
                            } else {
                                echo"<h2>Either there are no District Training Box Packaged By the Active Vendor/Print Order or the materials have been Collected.</h2><br/>";
                            }

                            $sql = "select id from materials_printlist_history where status=1";
                            $resultQ = mysql_query($sql);
                            while ($row = mysql_fetch_array($resultQ)) {
                                $printlistId = $row["id"];
                            }


                            $sql = "SELECT * from materials_packaging_history_ttb where printlist_id='$printlistId' and collected=0";
                            $resultB = mysql_query($sql);
                            $count = 0;
                            $numRows = mysql_affected_rows();
                            if ($numRows >= 1) {
                                ?>

                                <table  class="table table-bordered table-condensed table-striped table-hover" >
                                    <caption><h2>Teacher Training Boxes</h2></caption>
                                    <tr>

                                        <th>Collect</th>
                                        <th>Box Id</th>
                                        <th>County</th>
                                        <th>District</th>

                                    </tr>
                                    <?php
                                    while ($row = mysql_fetch_array($resultB)) {
                                        ?>

                                        <tr>
                                            <th><input type="checkbox"  name=<?php echo "boxTT" . $count . " value='" . $row["package_id"] . "' /></th><th>" . $row["box_id"] ?></th> <th><?php echo $row["county_name"] ?></th> <th><?php echo $row["district_name"] ?></th>
                                        </tr>



                                        <?php
                                        ++$count;
                                        $TTTOTAL = $count;
                                    }
                                    ?>
                                </table>
                                <input type="hidden" name="TTTOTAL" value="<?php echo $TTTOTAL; ?>" readonly/>


                                <?php
                            } else {
                                echo"<h2>Either there are no Teacher Training Box Packaged By the Active Vendor/Print Order Or All Materials have been Collected</h2><br/>";
                            }
                            ?>
                            <?php if ($priv_materials_edit >= 2) { ?>
                                <input type="submit" name="Get_Records" style="margin-left:30%;" class="btn-custom" value="Collect These Materials" />
                            </form>
                        <?php } ?>
                    </div>

                    <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
                        <h2 id="h2info"style="background:#bada66;" align="center"><?php echo $updateResult; ?></h2>		  
                        <table align="center">
                            <tr>
                                <th colspan="7">Collecting Training Material Form</th>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>

                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                            <form action="" method="POST">
                                <?php
                                if ($no_of_records > 0) {
                                    $boxDTCount = sizeof($_SESSION["boxDT"]);
                                    $boxTTCount = sizeof($_SESSION["boxTT"]);
                                    $numberM = $boxDTCount + $boxTTCount;
                                    $boxDT = $_SESSION["boxDT"];
                                    $boxTT = $_SESSION["boxTT"];
                                    $count = 0;
                                    $noPoles = 0;
                                    while ($count <= $boxDTCount) {
                                        //Extract District & County
                                        //  echo $boxDT[$count];
                                        if ($boxDT[$count] != NULL || $boxDT[$count] != "") {
                                            $sql = "SELECT * from materials_packaging_history_data where package_id=" . $boxDT[$count];

                                            // echo $sql."<br/>";
                                            $resultS = mysql_query($sql);
                                            while ($key = mysql_fetch_array($resultS)) {
                                                $county = $key["county_name"];
                                                $district = $key["district_name"];
                                            }

                                            //Check the no.of schools with schisto or schisto/sth

                                            $sql = "Select COUNT(school_name) AS Number from schools as s,districts as d where s.county='$county' AND d.district_name=s.district_name='$district' AND( d.treatment_type='STH/Schisto' OR d.treatment_type='Schisto')";
                                            $results = mysql_query($sql);
                                            while ($row = mysql_fetch_array($results)) {
                                                $noSchisto = $row["Number"];
                                            }
                                            $noPoles = $noPoles + $noSchisto;
                                        }
                                        ++$count;
                                    }
                                    $count = 0;
                                    while ($count <= $boxTTCount) {
                                        //Extract District & County
                                        if ($boxTT[$count] != NULL || $boxTT[$count] != "") {
                                            $sql = "SELECT * from materials_packaging_history_ttb where package_id=" . $boxTT[$count];

                                            $resultS = mysql_query($sql);
                                            while ($key = mysql_fetch_array($resultS)) {
                                                $county = $key["county_name"];
                                                $district = $key["district_name"];
                                            }

                                            //Check the no.of schools with schisto or schisto/sth

                                            $sql = "Select COUNT(school_name) AS Number from schools as s,districts as d where s.county='$county' AND d.district_name='$district' AND s.district_name='$district' AND( d.treatment_type='STH/Schisto' OR d.treatment_type='Schisto')";
                                            //    echo $sql."<br/>";
                                            $results = mysql_query($sql);
                                            while ($row = mysql_fetch_array($results)) {
                                                $noSchisto = $row["Number"];
                                            }
                                            $noPoles = $noPoles + $noSchisto;
                                        }
                                        // echo "Poles Are".$noPoles;
                                        ++$count;
                                    }
                                    $noPoles = $noPoles * 3;
                                    ?>
                                    <tr>
                                        <th><b><input name="no_of_records" type="hidden" value="<?php echo $no_of_records; ?>">Date:</b></th>
                                        <td colspan="2"><input name="date" type="text" class="datepicker" required/></th>
                                            <th>&nbsp;</th>
                                            <td colspan="3"><b>Tick One: </b><input type="radio" name="ministry" value="MoE" required>MoE <input type="radio" name="ministry" value="MoPHS" required>MoPHS</th>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" align="center"><b>Purpose (tick one): </b>
                                                                <input type="radio" name="purpose" value="Collecting Training Materials" required>
                                                                    Collecting Training Materials
                                                                    <input type="radio" name="purpose" value="Picking Master trainers">
                                                                        Picking Master trainers
                                                                        <input type="radio" name="purpose" value="Other">
                                                                            Other
                                                                            </th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Name</th>
                                                                                <th>Personal Number (P/No)</th>
                                                                                <th>Position/Title</th>
                                                                                <th>Mobile Phone Number</th>
                                                                                <th>Number of Boxes</th>
                                                                                <th>Number of Poles</th>
                                                                            </tr>
                                                                            <?php
                                                                            for ($i = 1; $i <= $no_of_records; $i++) {
                                                                                ?>
                                                                                <tr>
                                                                                    <th><?php echo $i ?></th>
                                                                                    <th><input name="name[]" type="text" id="name"></th>
                                                                                    <th><input name="personal_no[]" type="text" id="personal_no"></th>
                                                                                    <th><select name="title[]" id="title">
                                                                                            <option value="">Position/Title</option>
                                                                                            <option value="DEO">DEO</option>
                                                                                            <option value="AEO">AEO</option>
                                                                                            <option value="DMOH">DMOH</option>
                                                                                            <option value="DPHO">DPHO</option>
                                                                                        </select>    </th>
                                                                                    <th><input name="phone_no[]" type="text" id="phone_no"></th>
                                                                                    <th>   &nbsp;   &nbsp;    <input name="no_of_boxes[]" class="input-mini" type="text" id="no_of_boxes" style="text-align:center;" value="<?php echo $numberM; ?>" readonly/></th>
                                                                                    <th>  &nbsp;   &nbsp;    <input name="no_of_poles[]" class="input-mini" type="text" id="no_of_poles"value="<?php echo $noPoles; ?>"/></th>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </tr> 
                                                                            <tr>
                                                                                <th>&nbsp;</th>
                                                                                <th>&nbsp;</th>
                                                                                <th>&nbsp;</th>
                                                                                <th>&nbsp;</th>
                                                                                <th>&nbsp;</th>
                                                                                <th>&nbsp;</th>
                                                                                <th>&nbsp;</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>&nbsp;</th>
                                                                                <th><b>Prepared By:</b></th>
                                                                                <th>  <select name="pby_name"  id="pby_name">


                                                                                        <?php
                                                                                        echo "<option selected='selected' value=" . $_SESSION["staff_name"] . ">" . $_SESSION["staff_name"] . "</option>";

                                                                                        $sql = "SELECT * from staff";
                                                                                        $result = mysql_query($sql);
                                                                                        while ($row = mysql_fetch_array($result)) {


                                                                                            echo "<option value=" . $row["staff_name"] . ">" . $row["staff_name"] . "</option>";
                                                                                        }
                                                                                        ?>

                                                                                    </select>
                                                                                </th>
                                                                                <th>
                                                                                    <select name="pby_position" id="pby_position" required>
                                                                                        <option value="">Position/Title</option>
                                                                                        <option value="DEO">DEO</option>
                                                                                        <option value="AEO">AEO</option>
                                                                                        <option value="DMOH">DMOH</option>
                                                                                        <option value="DPHO">DPHO</option>
                                                                                    </select>
                                                                                </th>
                                                                                <th><input name="pby_contact" type="text" id="pby_contact" placeholder="Contact" required/></th>

                                                                                <th><input name="pby_date" type="date" id="pby_date" class="datepicker" placeholder="Date" required/></th>
                                                                            </tr><tr><th>&nbsp;</th></tr>
                                                                            <?php if ($priv_materials_edit >= 2) { ?>
                                                                                <tr><td colspan="4" align="center"><input class="btn-custom-small" type="submit" name="Submit" value="Submit Details" /></th></tr>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        </form>
                                                                        </table>
                                                                        <p>
                                                                            <div >

                                                                                <?php
                                                                                $count = 0;
                                                                                $sql = "SELECT * FROM collect_training_materials ORDER BY date DESC";
                                                                                $result = mysql_query($sql);
                                                                                $numRow = mysql_affected_rows();
                                                                                if ($numRow >= 1) {
                                                                                    ?>

                                                                                    <table class="table table-bordered table-condensed table-striped table-hover"  border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                                                                                        <thead>
                                                                                            <tr style="border: 1px solid #B4B5B0;">

                                                                                                <th align="Left" width="10%">Date</th>
                                                                                                <th align="Left" width="10%">Ministry</th>
                                                                                                <th align="Left" width="10%">Purpose</th>
                                                                                                <th align="Left" width="20%">Name</th>
                                                                                                <th align="Left" width="15%">Personal No</th>
                                                                                                <th align="Left" width="10%">Title</th>
                                                                                                <th align="Left" width="10%">Phone No</th>
                                                                                                <th align="Left" width="10%">No of Boxes</th>
                                                                                                <th align="Left" width="10%">No of Poles</th>
                                                                                                <?php if ($priv_materials_edit >= 2) { ?>
                                                                                                    <th align="center" width="4%">Edit</th>
                                                                                                <?php }if ($priv_materials_edit >= 4) { ?> 
                                                                                                    <th align="center" width="4%">Del</th>
                                                                                                <?php } ?> 
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>

                                                                                            <?php
                                                                                            while ($row = mysql_fetch_array($result)) {

                                                                                                $id = $row['id'];
                                                                                                $date = $row['date'];
                                                                                                $ministry = $row['ministry'];
                                                                                                $purpose = $row['purpose'];
                                                                                                $name = $row['name'];
                                                                                                $personal_no = $row['personal_no'];
                                                                                                $title = $row['title'];
                                                                                                $phone_no = $row['phone_no'];
                                                                                                $no_of_boxes = $row['no_of_boxes'];
                                                                                                $no_of_poles = $row['no_of_poles'];
                                                                                                ?>
                                                                                                <tr style="border-bottom: 1px solid #B4B5B0;">

                                                                                                    <td align="left" width="10%"> <?php echo $date; ?>  </th>
                                                                                                        <td align="left" width="10%"> <?php echo $ministry; ?> </th>
                                                                                                            <td align="left" width="10%"> <?php echo $purpose; ?> </th>
                                                                                                                <td align="left" width="20%"> <?php echo $name; ?> </th>
                                                                                                                    <td align="left" width="15%"> <?php echo $personal_no; ?> </th>
                                                                                                                        <td align="left" width="10%"> <?php echo $title; ?>  </th>
                                                                                                                            <td align="left" width="10%"> <?php echo $phone_no; ?>  </th>
                                                                                                                                <td align="left" width="10%"> <?php echo $no_of_boxes; ?> </th>
                                                                                                                                    <td align="left" width="10%"> <?php echo $no_of_poles; ?> </th>
                                                                                                                                        <?php if ($priv_materials_edit >= 2) { ?>
                                                                                                                                            <td align="center" width="4%"><a href="edit_collect_training_materials.php?id=<?php echo $id; ?>" onclick="javascript:void window.open('edit_collect_training_materials.php?id=<?php echo $id; ?>', '1397210634467', 'width=1050,height=500,status=1,scrollbars=1,resizable=1,left=150,top=0');
                                                                                                                                return false;"><img src="../images/icons/edit2.png" height="20px"></a></th>
                                                                                                                                                                         <?php }if ($priv_materials_edit >= 4) { ?>
                                                                                                                                                <td align="center" width="4%"><a href="materials_collecting.php?DeleteId=<?php echo $id; ?>" onclick="show_confirm()"><img src="../images/icons/delete.png" height="20px"></a></th>
                                                                                                                                                <?php } ?>
                                                                                                                                                </tr>
                                                                                                                                                </tbody>
                                                                                                                                            <?php } ?>
                                                                                                                                            </table>
                                                                                                                                            <?php
                                                                                                                                        } else {
                                                                                                                                            echo "<h2 id=\"h2info\"style=\"background:#bada66;\">No Materials Have Ever Been Collected</h2>";
                                                                                                                                        }
                                                                                                                                        ?>
                                                                                                                                        </div>
                                                                                                                                        </p>
                                                                                                                                        </div>

                                                                                                                                        <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
                                                                                                                                            <?php
                                                                                                                                            if (isset($_GET["UndoBoxIdDT"])) {
                                                                                                                                                $updateResult = "The Box Has Been Returned";
                                                                                                                                            }
                                                                                                                                            ?>

                                                                                                                                            <h2 id="h2info"style="background:#bada66;"><?php
                                                                                                                                                echo $updateResult;
                                                                                                                                                $updateResult = "";
                                                                                                                                                ?></h2>
                                                                                                                                            <form action="materials_collecting.php" method="POST">
                                                                                                                                                <?php
                                                                                                                                                $sql = "select id from materials_printlist_history where status=1";
                                                                                                                                                $resultQ = mysql_query($sql);
                                                                                                                                                while ($row = mysql_fetch_array($resultQ)) {
                                                                                                                                                    $printlistId = $row["id"];
                                                                                                                                                }


                                                                                                                                                $sql = "SELECT * from materials_packaging_history_data where printlist_id='$printlistId' AND collected=1";
                                                                                                                                                $resultB = mysql_query($sql);
                                                                                                                                                $count = 0;
                                                                                                                                                $numRows = mysql_affected_rows();
                                                                                                                                                if ($numRows >= 1) {
                                                                                                                                                    ?>
                                                                                                                                                    <table  class="table table-bordered table-condensed table-striped table-hover" >
                                                                                                                                                        <caption><h2>District Training Boxes</h2></caption>
                                                                                                                                                        <tr>

                                                                                                                                                            <th>Box Id</th>
                                                                                                                                                            <th>County</th>
                                                                                                                                                            <th>District</th>
                                                                                                                                                            <th>Collector</th>
                                                                                                                                                            <th>Date Set</th>
                                                                                                                                                            <?php if ($priv_materials_edit >= 3) { ?>
                                                                                                                                                                <th>Sms Sent to<br/>County Representatives</th>
                                                                                                                                                            <?php } ?>
                                                                                                                                                            <?php if ($priv_materials_edit >= 3) { ?>
                                                                                                                                                                <th>Sms Sent to<br/> District Education Officer</th>
                                                                                                                                                            <?php } ?>
                                                                                                                                                            <?php if ($priv_materials_edit >= 3) { ?>
                                                                                                                                                                <th>Edit</th>
                                                                                                                                                            <?php } ?>

                                                                                                                                                        </tr>
                                                                                                                                                        <?php
                                                                                                                                                        while ($row = mysql_fetch_array($resultB)) {
                                                                                                                                                            ?>

                                                                                                                                                            <tr>
                                                                                                                                                                <th><?php echo $row["box_id"]; ?></th> <th><?php echo $row["county_name"] ?></th> <th><?php echo $row["district_name"] ?></th><th><?php echo $row["name"]; ?></th> <th><?php echo $row["date"]; ?></th>
                                                                                                                                                                <?php
                                                                                                                                                                if ($priv_materials_edit >= 3) {

                                                                                                                                                                    $sql = "SELECT * from materials_collection_sms WHERE county='" . $row["county_name"] . "' AND district='" . $row["district_name"] . "' AND box_id='" . $row["box_id"] . "' AND box_type='DTB'";
                                                                                                                                                                    //echo $sql;
                                                                                                                                                                    $result = mysql_query($sql);
                                                                                                                                                                    $numSms = mysql_affected_rows() >= 1 ? "YES" : "NO";
                                                                                                                                                                    ?>

                                                                                                                                                                    <th><a href=<?php echo "materials_collecting.php?boxId=" . $row["box_id"] . "&district=" . $row["district_name"] . "&type=DTB" . "&county=" . trim($row['county_name']) . "&sendType=CR" . "#addSms"; ?>><?php echo $numSms; ?></a></th>


                                                                                                                                                                <?php } ?>
                                                                                                                                                                <?php
                                                                                                                                                                if ($priv_materials_edit >= 3) {
                                                                                                                                                                    $sql = "SELECT * from materials_collection_sms WHERE county='" . $row["county_name"] . "' AND district='" . $row["county_name"] . "' AND box_id='" . $row["box_id"] . "' AND box_type='DTB' AND confirmed=1";
                                                                                                                                                                    //echo $sql;
                                                                                                                                                                    $result = mysql_query($sql);
                                                                                                                                                                    $numSms2 = mysql_affected_rows() >= 1 ? "YES" : "NO";
                                                                                                                                                                    ?>

                                                                                                                                                                    <th><a href=<?php echo "materials_collecting.php?boxId=" . $row["box_id"] . "&district=" . $row["district_name"] . "&type=DTB" . "&county=" . trim($row['county_name']) . "&sendType=DEO" . "#addSms"; ?>><?php echo $numSms; ?></a></th>
                                                                                                                                                                <?php } ?>                        

                                                                                                                                                                <?php if ($priv_materials_edit >= 3) { ?>
                                                                                                                                                                    <th><a href="javascript:void(0)" onclick="show_confirm(<?php echo $row["box_id"]; ?>)"><img src="../images/icons/edit.png" height="20px"/></a></th>
                                                                                                                                                                <?php } ?>
                                                                                                                                                            </tr>



                                                                                                                                                            <?php
                                                                                                                                                            ++$count;
                                                                                                                                                        }
                                                                                                                                                        ?>
                                                                                                                                                    </table>
                                                                                                                                                    <?php
                                                                                                                                                } else {
                                                                                                                                                    echo"<h2>No District Training Box Has Been Dispatched</h2><br/>";
                                                                                                                                                }

                                                                                                                                                if (isset($_GET["UndoBoxIdTT"])) {
                                                                                                                                                    $updateResult = "The Box Has Been Returned";
                                                                                                                                                }
                                                                                                                                                ?>

                                                                                                                                                <h2 id="h2info"style="background:#bada66;"><?php
                                                                                                                                                    echo $updateResult;
                                                                                                                                                    $updateResult = "";
                                                                                                                                                    ?></h2>
                                                                                                                                                <form action="materials_collecting.php" method="POST">
                                                                                                                                                    <?php
                                                                                                                                                    if (isset($_GET["Smsid"])) {

                                                                                                                                                        $sms = $_GET["Smsid"];

                                                                                                                                                        $sql = "UPDATE materials_collection_sms set confirmed='1' WHERE sms_id=" . $sms;
                                                                                                                                                        mysql_query($sql);
                                                                                                                                                    }



                                                                                                                                                    $sql = "select id from materials_printlist_history where status=1";
                                                                                                                                                    $resultQ = mysql_query($sql);
                                                                                                                                                    while ($row = mysql_fetch_array($resultQ)) {
                                                                                                                                                        $printlistId = $row["id"];
                                                                                                                                                    }


                                                                                                                                                    $sql = "SELECT * from materials_packaging_history_ttb where printlist_id='$printlistId' AND collected=1";
                                                                                                                                                    $resultB = mysql_query($sql);
                                                                                                                                                    $count = 0;
                                                                                                                                                    $numRows = mysql_affected_rows();
                                                                                                                                                    if ($numRows >= 1) {
                                                                                                                                                        ?>
                                                                                                                                                        <table  class="table table-bordered table-condensed table-striped table-hover" >
                                                                                                                                                            <caption><h2>Teacher Training Boxes</h2></caption>
                                                                                                                                                            <tr>

                                                                                                                                                                <th>Box Id</th>
                                                                                                                                                                <th>County</th>
                                                                                                                                                                <th>District</th>
                                                                                                                                                                <th>Collector</th>
                                                                                                                                                                <th>Date Set</th>
                                                                                                                                                                <?php if ($priv_materials_edit >= 3) { ?>
                                                                                                                                                                    <th>Sms Sent to<br/>County Representatives</th>
                                                                                                                                                                <?php } ?>
                                                                                                                                                                <?php if ($priv_materials_edit >= 3) { ?>
                                                                                                                                                                    <th>Sms Sent to<br/> District Education Officer</th>
                                                                                                                                                                <?php } ?>
                                                                                                                                                                <?php if ($priv_materials_edit >= 3) { ?>
                                                                                                                                                                    <th>Edit</th>
                                                                                                                                                                <?php } ?>

                                                                                                                                                            </tr>
                                                                                                                                                            <?php
                                                                                                                                                            while ($row = mysql_fetch_array($resultB)) {
                                                                                                                                                                ?>

                                                                                                                                                                <tr>
                                                                                                                                                                    <th><?php echo $row["box_id"]; ?></th> <th><?php echo $row["county_name"]; ?></th> <th><?php echo $row["district_name"] ?></th><th><?php echo $row["name"]; ?></th> <th><?php echo $row["date"]; ?></th> 
                                                                                                                                                                    <?php
                                                                                                                                                                    if ($priv_materials_edit >= 3) {

                                                                                                                                                                        $sql = "SELECT * from materials_collection_sms WHERE county='" . $row["county_name"] . "' AND district='" . $row["district_name"] . "' AND box_id='" . $row["box_id"] . "' AND box_type='TTB'";
                                                                                                                                                                        //   echo $sql;
                                                                                                                                                                        $result = mysql_query($sql);
                                                                                                                                                                        $numSms = mysql_affected_rows() >= 1 ? "YES" : "NO";
                                                                                                                                                                        ?>

                                                                                                                                                                        <th><a href=<?php echo "materials_collecting.php?boxId=" . $row["box_id"] . "&district=" . $row["district_name"] . "&type=TTB" . "&county=" . trim($row['county_name']) . "&sendType=CR" . "#addSms"; ?>><?php echo $numSms; ?></a></th>

                                                                                                                                                                    <?php } ?>
                                                                                                                                                                    <?php
                                                                                                                                                                    if ($priv_materials_edit >= 3) {
                                                                                                                                                                        $sql = "SELECT * from materials_collection_sms WHERE county='" . $row["county_name"] . "' AND district='" . $row["county_name"] . "' AND box_id='" . $row["box_id"] . "' AND box_type='TTB' AND confirmed=1";
                                                                                                                                                                        //echo $sql;
                                                                                                                                                                        $result = mysql_query($sql);
                                                                                                                                                                        mysql_affected_rows() >= 1 ? $numSms2 = "YES" : $numSms2 = "NO";
                                                                                                                                                                        ?>
                                                                                                                                                                        <th><a href=<?php echo "materials_collecting.php?boxId=" . $row["box_id"] . "&district=" . $row["district_name"] . "&type=TTB" . "&county=" . trim($row['county_name']) . "&sendType=DEO" . "#addSms"; ?>><?php echo $numSms; ?></a></th>
                                                                                                                                                                    <?php } ?><?php if ($priv_materials_edit >= 3) { ?>

                                                                                                                                                                        <th><a href="javascript:void(0)" onclick="show_confirm2(<?php echo $row["box_id"]; ?>)"><img src="../images/icons/edit.png" height="20px"/></a></th>
                                                                                                                                                                    <?php } ?>
                                                                                                                                                                </tr>



                                                                                                                                                                <?php
                                                                                                                                                                ++$count;
                                                                                                                                                            }
                                                                                                                                                            ?>
                                                                                                                                                        </table>
                                                                                                                                                        <?php
                                                                                                                                                    } else {
                                                                                                                                                        echo"<h2>No Teacher Training Box Has Been Dispatched</h2><br/>";
                                                                                                                                                    }
                                                                                                                                                    ?>	
                                                                                                                                                </form>


                                                                                                                                        </div>
                                                                                                                                        <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">
                                                                                                                                            <table  class="table table-bordered table-condensed table-striped table-hover" >
                                                                                                                                                <thead>
                                                                                                                                                    <tr>
                                                                                                                                                        <th>Sender</th>
                                                                                                                                                        <th>Receiver</th>
                                                                                                                                                        <th>Subject</th>
                                                                                                                                                        <th>Body</th>
                                                                                                                                                        <th>Confirmed</th>
                                                                                                                                                    </tr>
                                                                                                                                                </thead>
                                                                                                                                                <?php
                                                                                                                                                $sql = "SELECT * from materials_collection_sms WHERE confirmed !=1 ORDER BY sms_id DESC";
                                                                                                                                                $resultR = mysql_query($sql);
                                                                                                                                                while ($row = mysql_fetch_array($resultR)) {
                                                                                                                                                    echo "<tr>";
                                                                                                                                                    echo "<td>" . $row["sender"] . "</td>";
                                                                                                                                                    echo "<td>" . $row["recepient"] . "</td>";
                                                                                                                                                    echo "<td>" . $row["subject"] . "</td>";
                                                                                                                                                    echo "<td>" . $row["sms_body"] . "</td>";
                                                                                                                                                    echo "<td><a href=materials_collecting.php?Smsid=" . $row["sms_id"] . ">Confirm</a></td>";
                                                                                                                                                    echo "</tr>";
                                                                                                                                                }
                                                                                                                                                ?>
                                                                                                                                            </table>
                                                                                                                                        </div>




                                                                                                                                        </div>
                                                                                                                                        </div>
                                                                                                                                        </div>


                                                                                                                                        <script>

                                                                                                                                            $(document).find("input.num-only").keydown(function(e) {
                                                                                                                                                // Allow: backspace, delete, tab, escape, enter and .
                                                                                                                                                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                                                                                                                                        // Allow: Ctrl+A
                                                                                                                                                                (e.keyCode == 65 && e.ctrlKey === true) ||
                                                                                                                                                                // Allow: home, end, left, right
                                                                                                                                                                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                                                                                                                                                            // let it happen, don't do anything
                                                                                                                                                            return;
                                                                                                                                                        }
                                                                                                                                                        // Ensure that it is a number and stop the keypress
                                                                                                                                                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                                                                                                            e.preventDefault();
                                                                                                                                                        }
                                                                                                                                                    });

                                                                                                                                            $(function() {
                                                                                                                                                $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});
                                                                                                                                            });


                                                                                                                                            function show_confirm() {
                                                                                                                                                if (confirm("Are you sure you want to delete?")) {
                                                                                                                                                    return true;
                                                                                                                                                } else {
                                                                                                                                                    return false;
                                                                                                                                                }
                                                                                                                                            }


                                                                                                                                            function show_confirm(BoxId) {
                                                                                                                                                if (confirm("Are you sure you want to Undo its Collecting Process?")) {
                                                                                                                                                    location.replace('?UndoBoxIdDT=' + BoxId);
                                                                                                                                                } else {
                                                                                                                                                    return false;
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            function show_confirm2(BoxId) {
                                                                                                                                                if (confirm("Are you sure you want to Undo its Collecting Process?")) {
                                                                                                                                                    location.replace('?UndoBoxIdTT=' + BoxId);
                                                                                                                                                } else {
                                                                                                                                                    return false;
                                                                                                                                                }
                                                                                                                                            }


                                                                                                                                        </script>

                                                                                                                                        <!--filter includes-->
                                                                                                                                        <!--filter includes-->
                                                                                                                                        <!---
                                                                                                                                                                                                      <script type="text/javascript" src="../css/filter-as-you-type/jquery.min.js"></script>
                                                                                                                                        <script type="text/javascript" src="../css/filter-as-you-type/jquery.quicksearch.js"></script>
                                                                                                                                        <script type="text/javascript">
                                                                                                                                          $(function() {
                                                                                                                                            $('input#id_search').quicksearch('table tbody tr');
                                                                                                                                          });
                                                                                                                                              </script>
                                                                                                                                        -->


                                                                                                                                        <?php
                                                                                                                                        if (isset($_POST["sendSms"])) {

                                                                                                                                            $sender = isset($_POST["sender"]) ? mysql_real_escape_string($_POST["sender"]) : "";
                                                                                                                                            $recepient = isset($_POST["recepient"]) ? mysql_real_escape_string($_POST["recepient"]) : "";
                                                                                                                                            $recepient_number = isset($_POST["recepient_number"]) ? mysql_real_escape_string($_POST["recepient_number"]) : "";
                                                                                                                                            $subject = isset($_POST["subject"]) ? mysql_real_escape_string($_POST["subject"]) : "";
                                                                                                                                            $sms_body = isset($_POST["content"]) ? mysql_real_escape_string($_POST["content"]) : "";
                                                                                                                                            $boxId = isset($_POST["boxId"]) ? mysql_real_escape_string($_POST["boxId"]) : "";
                                                                                                                                            $arrivalDate = isset($_POST["arrivalDate"]) ? mysql_real_escape_string($_POST["arrivalDate"]) : "";
                                                                                                                                            $county = isset($_POST["county"]) ? mysql_real_escape_string($_POST["county"]) : "";
                                                                                                                                            $district = isset($_POST["district"]) ? mysql_real_escape_string($_POST["district"]) : "";
                                                                                                                                            $recepient_type = isset($_POST["recepient_type"]) ? mysql_real_escape_string($_POST["recepient_type"]) : "";
                                                                                                                                            $arrivalNotes = ". The Box will arrive on " . $arrivalDate;
                                                                                                                                            $send_type = isset($_GET["sendType"]) ? mysql_real_escape_string($_GET["sendType"]) : "";


                                                                                                                                            $sql = "INSERT INTO `materials_collection_sms`( `sender`, `recepient`,  `recepient_number`, `subject`, `sms_body`, `box_id`,";
                                                                                                                                            $sql.="`send_date`, `county`, `district`, `box_type`,`recepient_type`)";
                                                                                                                                            $sql.=" VALUES ('$sender','$recepient','$recepient_number','$subject','$sms_body','$boxId','$arrivalDate','$county','$district','$recepient_type','$send_type')";

                                                                                                                                            mysql_query($sql);
                                                                                                                                            //$sms_body.=$arrivalNotes;

                                                                                                                                            require_once 'sms.php';

                                                                                                                                            $sms = new sms();
                                                                                                                                            $sms->sendSMS($recipient_number, $sms_body)or die("Error Sending Sms");



                                                                                                                                         //   $sms = new sms();
                                                                                                                                           // $sms->sendSMS($recipient_number, $sms_body)or die("Error Sending Sms");
                                                                                                                                        }
                                                                                                                                        ?>


                                                                                                                                        <div id="addSms" class="modalDialog" style="margin-left:0%; ">
                                                                                                                                            <div style="width: 500px">
                                                                                                                                                <form method="POST" >
                                                                                                                                                    <a href="materials_collecting.php" title="Close" class="close">X</a>
                                                                                                                                                    <!-- ================= -->
                                                                                                                                                    <?php
                                                                                                                                                    $boxId = $_GET["boxId"];
                                                                                                                                                    $county = $_GET["county"];
                                                                                                                                                    $district = $_GET["district"];
                                                                                                                                                    $recepient_type = $_GET["type"];
                                                                                                                                                    $send_type = $_GET["sendType"];
                                                                                                                                                    ?>

                                                                                                                                                    <h3 style="margin-left:40%;">
                                                                                                                                                        Compose SMS
                                                                                                                                                    </h3>

                                                                                                                                                    <?php
                                                                                                                                                    if (isset($_POST["sendSms"])) {
                                                                                                                                                        echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>Message Sent</h3>";
                                                                                                                                                    }
                                                                                                                                                    ?>
                                                                                                                                                    <table >
                                                                                                                                                        <tr>
                                                                                                                                                            <th>Sender</th><th><input type="text" name="sender" value="<?php echo $_SESSION["staff_name"]; ?>" readonly/></th>
                                                                                                                                                            <th>Recipient</th><th><input type="text" name="recepient" value="" required/></th>
                                                                                                                                                        </tr>
                                                                                                                                                        <th>Date Expected</th><th><input type="text" name="arrivalDate" class="datepicker" value="" required/></th>
                                                                                                                                                        <th>Recipient Number</th><th><input type="text" name="recepient_number" value="" required/></th>
                                                                                                                                                        </tr>
                                                                                                                                                        <th></th><th><input type="hidden" name="boxId" value="<?php echo $boxId; ?>" readonly/></th>
                                                                                                                                                        <th>Subject</th><th><input type="text" name="subject" value="" required/></th>
                                                                                                                                                        </tr>
                                                                                                                                                    </table>
                                                                                                                                                    <h3 style="margin-left:40%"> Sms Content</h3><br/>
                                                                                                                                                    <textarea style="width:70%;"name="content"><?php
                                                                                                                                                        if ($recepient_type == "TTB") {
                                                                                                                                                            $sql = "SELECT * from materials_packaging_history_ttb WHERE box_id=" . $boxId;

                                                                                                                                                            $resultA = mysql_query($sql);
                                                                                                                                                            while ($row = mysql_fetch_array($resultA)) {
                                                                                                                                                                echo "Box Id=" . $row["box_id"];
                                                                                                                                                                echo ",Teacher Training Booklet " . $row["ttb"];
                                                                                                                                                                echo ",Form E Packet =" . $row["form_e"];
                                                                                                                                                                echo ",Form N Packet =" . $row["form_n"];
                                                                                                                                                                echo ",Form S Packet = " . $row["form_s"];
                                                                                                                                                                echo ",Form E-P Packet = " . $row["form_ep"];
                                                                                                                                                                echo ",Form N-P Packet =" . $row["form_np"];
                                                                                                                                                                echo ",Form S-P Packet = " . $row["form_sp"];
                                                                                                                                                                echo ",ATTNT Packet =" . $row["$attnt_packet"];
                                                                                                                                                                echo ",Poster 1- Date " . $row["poster_1"];
                                                                                                                                                                echo ",Poster 2- Behavior Change " . $row["poster_2"];
                                                                                                                                                            }
                                                                                                                                                        } else {
                                                                                                                                                            $sql = "SELECT * from materials_packaging_history_data WHERE box_id=" . $boxId;

                                                                                                                                                            $resultA = mysql_query($sql);

                                                                                                                                                            while ($row = mysql_fetch_array($resultA)) {

                                                                                                                                                                echo "Box Id=" . $row["box_id"];
                                                                                                                                                                echo ",Master Trainers=" . $row["mtp"];
                                                                                                                                                                echo ",Dc Packet=" . $row["dc_packet"];
                                                                                                                                                                echo ",Dpho Packets=" . $row["dpho_packet"];
                                                                                                                                                                echo ",District Training Booklet=" . $row["dtb"];
                                                                                                                                                                echo ",Teacher Training Booklet=" . $row["ttb"];
                                                                                                                                                                echo ",Handout on Financial Disbursements=" . $row["hfd"];
                                                                                                                                                                echo ",Guide for District Level Managers= " . $row["gdlm"];
                                                                                                                                                                echo ",Teacher Training Kit=" . $row["ttk"];
                                                                                                                                                                echo ",Form A=" . $row["form_a"];
                                                                                                                                                                echo ",Form Ap=" . $row["form_ap"];
                                                                                                                                                                echo ",Poster 1=" . $row["poster_1"];
                                                                                                                                                                echo ",Poster 2=" . $row["poster_2"];
                                                                                                                                                            }
                                                                                                                                                        }
                                                                                                                                                        ?></textarea>
                                                                                                                                                    <br/><br/>
                                                                                                                                                    <input type="submit" name="sendSms" class="btn-custom" value="Send Sms" style="margin-left:35%;"/>
                                                                                                                                                    <input type="hidden" name="county"  value="<?php echo $county; ?>"/>
                                                                                                                                                    <input type="hidden" name="district"  value="<?php echo $district; ?>"/>
                                                                                                                                                    <input type="hidden" name="recepient_type" value="<?php echo $recepient_type; ?>"/>
                                                                                                                                                </form>
                                                                                                                                            </div>
                                                                                                                                        </div>