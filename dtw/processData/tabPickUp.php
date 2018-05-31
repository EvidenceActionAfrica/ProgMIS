<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once("pdf/printTabpickup.php");
require_once("../includes/logTracker.php");
$M_module =5;

$tabActive = "tab1";
if(isset($_GET['tabActive'])){
    $tabActive=$_GET['tabActive'];
}
$district_name = isset($_POST["district_name"]) ? mysql_real_escape_string($_POST["district_name"]) : "";
$dmoh = isset($_POST["dmoh"]) ? mysql_real_escape_string($_POST["dmoh"]) : "";
$pickup = isset($_POST["pickup"]) ? mysql_real_escape_string($_POST["pickup"]) : "";
$quantity_dispatched = isset($_POST["quantity_dispatched"]) ? mysql_real_escape_string($_POST["quantity_dispatched"]) : "";
$batch = isset($_POST["batch"]) ? $_POST["batch"] : "";
$expiry_dates = isset($_POST["expiry_dates"]) ? trim($_POST["expiry_dates"]) : "";
$division_name = isset($_POST["division_name"]) ? mysql_real_escape_string($_POST["division_name"]) : "";
$currentDate = date("Y-m-d");
$receive_drugs = isset($_POST["receive_drugs"]) ? mysql_real_escape_string($_POST["receive_drugs"]) : "";
$drug_type=isset($_POST['drug_type'])?mysql_real_escape_string($_POST['drug_type']):"";
$format_expiry_dates = mysql_real_escape_string($expiry_dates);
$format_batch = mysql_real_escape_string($batch);
if (isset($_POST['saveRecord'])) {

    $sql = "INSERT INTO `drugs_tablet_pickup_form`(`drug_type`,`district_name`, `person_picking_drugs`, `expiry_dates`, `batch_numbers`, `dmoh`, `division_name`, `date`,`quantity_dispatched`)";
    $sql.=" VALUES ('$drug_type','$district_name','$pickup','$format_expiry_dates','$format_batch','$dmoh','$division_name','$currentDate','$quantity_dispatched')";

    mysql_query($sql) or die(mysql_error());
    $tabActive = "tab2";
    $action="Drugs tablet Pick up form Added";
     $description=" A new Drugs tablet Pick up form was created for the division ".$division." in the sub-county ".$district_name;
     $ArrayData = array($M_module, $action, $description);
     quickFuncLog($ArrayData);
}
if (isset($_GET["deleteId"])) {
    $tabActive = "tab2";
    $deleteId = $_GET["deleteId"];
     $sql = "SELECT * FROM drugs_tablet_pickup_form WHERE form_id=".$deleteId;

    $result_set = mysql_query($sql)or die(mysql_error());

    while ($row = mysql_fetch_array($result_set)) {

        $district_name = $row["district_name"];
        $division_name = $row["division_name"];
    }

    $sql = "DELETE from drugs_tablet_pickup_form where form_id=".$deleteId;
    mysql_query($sql);
    $action="Drugs tablet Pick up form Deleted";
     $description=" A Drugs tablet Pick up form was Deleted for the division ".$division_name." in the sub-county ".$district_name;
     $ArrayData = array($M_module, $action, $description);
     quickFuncLog($ArrayData);
}
if (isset($_POST["updateRecord"])) {
    $tabActive = "tab2";
    $Id = $_POST["form_id"];
    $currentDate = date("Y-m-d");
    $query = "UPDATE `drugs_tablet_pickup_form` SET `drug_type`='$drug_type',`district_name`='$district_name',`quantity_dispatched`='$quantity_dispatched',`expiry_dates`='$expiry_dates'
,`batch_numbers`='$batch',`dmoh`='$dmoh',`division_name`='$division_name',`date`='$currentDate' WHERE form_id='$Id'";
//echo $query;
    mysql_query($query);
       $action="Drugs tablet Pick up form updated";
     $description=" A Drugs tablet Pick up form was updated for the division ".$division_name." in the sub-county ".$district_name;
     $ArrayData = array($M_module, $action, $description);
     quickFuncLog($ArrayData);
//since the variables are the same ones as the ones in the add tab you should empty them

    $district_name = "";
    $dmoh = "";
    $pickup = "";
    $quantity_dispatched = "";
    $batch = "";
    $expiry_dates = "";
    $division_name = "";

    $receive_drugs = "";
}

if(isset($_GET['printPdf'])){

    printTabPickup();
    $action="Drugs tablet Pick up form downloaded";
    $description=" A Drugs tablet Pick up form was downloaded";
    $ArrayData = array($M_module, $action, $description);
    quickFuncLog($ArrayData);
}

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
    $priv_tab_pickup = $row['priv_tab_pickup'];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
    <head>
        <title>Evidence Action</title>
        <link href="../css/tabs_css.css" rel="stylesheet" type="text/css">
            <?php
            require_once ("includes/meta-link-script.php");
            ?>
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
                require_once ("includes/menuLeftBar-Drugs.php");
                ?>
            </div>
            <div class="contentBody" >  


                <!--tab skeleton-->
                <div class="tabbable" >
                    <ul class="nav nav-tabs">
                        <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Add Tablet Pickup Form</a></li>
                        <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">View Tablet Pickup Form</a></li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">


                            <div>
                                <center><h2>Tablet Pickup Form</h2></center>
                            </div>

                            <form action="" method="post">
                                <center>
                                    <table>
                                        <thead>
                                            <tr>
                                                <td  align="right">Sub County</td>
                                                <td>
                                                    <select style="width:250px;" name="district_name"  class="input_select_p compact"  onchange="submitForm();">
                                                        <?php if ($district_name !== "") { ?>
                                                            <option value='<?php echo $district_name; ?>' selected> <?php echo $district_name; ?></option>
                                                        <?php } else { ?>
                                                            <option class="input_select_p compact"  value=''<?php if ($district_name == '') echo 'selected'; ?> ></option>
                                                        <?php } ?>     <?php
                                                        $sql = "SELECT * FROM districts ORDER BY district_name ASC";
                                                        $result = mysql_query($sql);

                                                        while ($rows = mysql_fetch_array($result)) { //loop table rows
                                                            ?>
                                                            <option value="<?php echo $rows['district_name']; ?>"<?php
                                                            ?>><?php echo $rows['district_name']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right">Division</td>

                                                <td >
                                                    <select style="width:250px;" name="division_name"  class="input_select_p compact">

                                                        <option value=''<?php if ($division_name == '') echo 'selected'; ?> ></option>
                                                        <?php
                                                        $sql = "SELECT * FROM divisions WHERE district_name='$district_name' ORDER BY division_name ASC";
                                                        $result = mysql_query($sql);
                                                        while ($rows = mysql_fetch_array($result)) { //loop table rows
                                                            ?>
                                                            <option value="<?php echo $rows['division_name']; ?>"<?php ?>><?php echo $rows['division_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right">Drug Type</td>
                                                <td >
                                                    <select style="width:250px;" name="drug_type"  class="input_select_p compact">
                                                        <option value="alb">ALB</option>
                                                        <option value="pzq">PZQ</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <input type="submit" class='btn-filter' style="width: 98%; display:none;" id="btnSearchSubmit" value="Search" name="search_table"  />

                                            <tr>
                                                <?php
                                                $sql = "SELECT dmoh_name FROM health_contacts WHERE district='$district_name' LIMIT 1";
                                                $result = mysql_query($sql);

                                                while ($row = mysql_fetch_array($result)) { //loop table rows
                                                    ?>
                                                    <td align="right">DMOH</td><td><input  style="width:250px;"class="input_select_p compact" type="text" name="dmoh"  value="<?php echo $row['dmoh_name']; ?>"/></td>
                                                <?php } ?>   
                                            </tr>
                                            <tr>
                                                <td align="right">Person Picking Drugs</td><td><input style="width:250px;" class="input_select_p compact" type="text" name="pickup"  value=""/></td>
                                            </tr>
                                            <!---
                                      <tr>
                                         <td align="right">Person Receiving Drugs</td><td><input style="width:250px;" class="input_select_p compact" type="text" name="receive_drugs" value=""/></td>
                                         
                                        </tr>
                                            -->
                                            <tr>
                                                <td align="right">
                                                    <label>Quantity Of drugs dispached</label>
                                                </td>
                                                <td>
                                                    <input style="width:250px;" class="input_select_p compact" type="text" name="quantity_dispatched"  value=""/>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="right" >
                                                    <label>Drug batch Numbers</label>
                                                </td>
                                                <td>
                                                    <textarea class="input_select_p compact"  style="width:250px;height:70px" name="batch"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right">Drug Expiry Dates</td><td><textarea style="width:250px;height:70px"  class="input_select_p compact" type="text" name="expiry_dates"/></textarea></td>
                                                <td></td>
                                            </tr> 
                                            <tr>
                                                <td></td>

                                                <?php if ($priv_tab_pickup >= 2) { ?>
                                                    <td> <input align="left" class="btn-custom-small"type="submit" name="saveRecord" value="Save Record" />     </td>
                                                <?php } ?>      
                                            </tr>
                                        </thead>


                                    </table > 

                                </center>
                                       <!-- <input class="btn-custom-small"type="submit" name="name" value="value" > -->
                            </form>
                        </div>
                        <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
                            <br/><br/>
                            <!--filter box-->
                            <form action="#">
                                
                                <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
                              <a href='tabPickUp.php?view=Yes&tabActive=tab3' style='margin-left:30%;'><img src="../images/icons/view2.png" height="20px"/>View Summary</a><br/>
                                <b style="margin-left:20%;width: 100px; font-size:1.5em;">View Tablet Pickup Form</b>
                            </form>
                            <br/><br/>



                            <table style="width:80%;margin-left:10%;">
                                <thead>
                                    <tr style="border: 1px solid #B4B5B0;">
                                    <th align="Left" >Sub County  </th>
                                    <th align="Left" >Division  </th>
                                    <th align="Left" >Person Picking Drugs  </th>
                                    <!---
                                    <th align="left" >Person Receiving Drugs  </th>
                                    -->
                                    <th align="Left" >Quantity</th>
                                    <th align="Left" >Drug Type</th>
                                    <th align="Left" >Date Saved</th>
                                    <?php if ($priv_tab_pickup >= 1) { ?>
                                        <th align="center" >View</th>
                                    <?php }if ($priv_tab_pickup >= 4) { ?>
                                        <th align="center" >Del</th>
                                    <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $sql = "SELECT * FROM drugs_tablet_pickup_form ORDER BY date DESC";

                                    $result_set = mysql_query($sql)or die(mysql_error());

                                    while ($row = mysql_fetch_array($result_set)) {

                                        $drug_type = $row["drug_type"];
                                        $district_name = $row["district_name"];
                                        $dmoh = $row["dmoh"];
                                        $pickup = $row["person_picking_drugs"];
                                        $quantity_dispatched = $row["quantity_dispatched"];
                                        $batch = $row["batch"];
                                        $expiry_dates = $row["expiry_dates"];
                                        $division_name = $row["division_name"];
                                        $currentDate = $row["date"];
                                        //  $receive_drugs=$row["person_receving_drugs"];
                                        $form_id = $row["form_id"];
                                        ?>

                                        <tr style="border-bottom: 1px solid #B4B5B0;">
                                            <td align="left" > <?php echo $district_name; ?> </td>
                                            <td align="left"  style="width:15%"> <?php echo $division_name; ?> </td>

                                            <td align="left" > <?php echo $pickup; ?> </td>
                                            <td align="left" > <?php echo $quantity_dispatched; ?> </td>
                                            <td align="left" > <?php echo $drug_type; ?> </td>
                                            <td align="left" > <?php echo $currentDate; ?> </td>
                                            <?php if ($priv_tab_pickup >= 1) { ?>
                                                <td align="center" ><a href="tabPickUp.php?ViewId=<?php echo $form_id; ?>#openModal" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                                            <?php } if ($priv_tab_pickup >= 4) { ?>
                                                <td align="center" ><a href="javascript:void(0)" onclick='show_confirm(<?php echo $form_id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                                            <?php } ?>
                                        </tr>
                                </tbody>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
                                <h2 style='text-align:center;'>Summary of Tab pickup form</h2>
                            <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&printPdf=SummaryTabpickup'; ?>"><img src="../images/print.png" height="20px">Print Pdf</a>
                            <table class="table table-bordered table-condensed table-striped table-hover">
                              <tr>
                                 <td>County</td>
                                  <td>Sub-County</td>
                                  <td>Status</td>
                              </tr>
                              <?php
                                 $sql='SELECT distinct(activity_venu),actyvity_county from rollout_activity';   
                                 $rolloutResult=mysql_query($sql);
                                 while($row=mysql_fetch_array($rolloutResult)){

                                    echo '<tr>';
                                    echo '<td>'.$row['actyvity_county'].'</td>';
                                    echo '<td>'.$row['activity_venu'].'</td>';
                                    
                                   $sql2='SELECT district_name from drugs_tablet_pickup_form WHERE district_name="'.$row['activity_venu'].'"';
                                    $result=mysql_query($sql2);
                                    $numRows=mysql_num_rows($result);

                                    
                                    if($numRows>=1){
                                    echo '<td><i>'.$numRows.' Picked Up</i></td>';
                                    }else{
                                        echo '<td><i style="color:rgb(255,0,0);">Not Picked up</i></td>';
                                    }

                                    echo '</tr>';

                                 }


                              ?> 
                          </table> 
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </body>
</html>
<?php
if ($_GET["ViewId"]) {

    $search = $_GET["ViewId"];

    $sql = "SELECT * FROM drugs_tablet_pickup_form where form_id ='$search'";
//echo $sql;                


    $result_set = mysql_query($sql);


    while ($row = mysql_fetch_array($result_set)) {

        $drug_type = $row["drug_type"];
        $district_name = $row["district_name"];
        $dmoh = $row["dmoh"];
        $pickup = $row["person_picking_drugs"];
        $quantity_dispatched = $row["quantity_dispatched"];
        $batch = $row["batch_numbers"];
        $expiry_dates = $row["expiry_dates"];
        $division_name = $row["division_name"];
        $currentDate = date("Y-m-d");
//$receive_drugs=$row["person_receving_drugs"];

        $form_id = $row["form_id"];
        ?>

        <div id="openModal" class="modalDialog">

            <div style="width:500px;margin-bottom:5%;">
                <a href="#close" class="btn btn-danger" style="margin-left:100%;margin-top:-5%;" title="Close" class="close">X</a>
                <center>
                    <h2>Tablet Pickup Form</h2>

                </center>
                <center>
                    <form action="tabPickUp.php" method="post">
                        <table style="">
                            <tr>
                                <td align="right">Sub County</td>  
                                <td>
                                    <select style="width:250px;" class="input_select_p compact" name="district_name" >
                                        <?php
                                        if ($district_name != "") {
                                            echo "<option value='$district_name' >$district_name</option>";
                                        }
                                        ?>
                                        <option value=''<?php if ($district_name == '') echo 'selected'; ?> ></option>
                                        <?php
                                        $sql = "SELECT * FROM districts ORDER BY district_name ASC";
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

                                </td>
                            </tr>
                            <tr>
                                <td align="right">division</td>

                                <td>
                                    <select name="division_name"  style="width:250px;"class="input_select_p compact" >
                                        <option value=''<?php if ($division_name == '') echo 'selected'; ?> ></option>
                                        <?php
                                        $sql = "SELECT * FROM divisions ORDER BY division_name ASC";
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
                                </td>
                            </tr>
                            <tr>
                                <td align="right">DMOH</td><td><input style="width:250px;" class="input_select_p compact" type="text" name="dmoh"  value="<?php echo $dmoh; ?>"/></td>
                            </tr>
                            <tr>
                                <td align="right">Person Picking Drugs</td><td><input style="width:250px;"class="input_select_p compact" type="text" name="pickup"  value="<?php echo $pickup; ?>"/></td>
                            </tr>
                            <!---
                        <tr>
                         <td>Person Receiving Drugs</td><td><input style="width:250px;" class="input_select_p compact" type="text" name="receive_drugs" value="<?php echo $receive_drugs; ?>"/></td>
                         
                    </tr>
                            -->

                            <tr>
                                <td align="right">
                                    <label>Quantity Of drugs dispached</label><td><input style="width:250px;" class="input_select_p compact" type="text" name="quantity_dispatched" value="<?php echo $quantity_dispatched; ?>"/></td>
                                </td>
                                <td align="right" >
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    <label>Drug batch Numbers</label>
                                </td>
                                <td>
                                    <textarea style="width:250px;max-width:250px;max-height:40px;" class="input_select_p compact" name="batch"><?php echo $batch; ?></textarea>
                                </td>
                            </tr>
                            
                            <tr>
                                <td align="right">
                                    <label>Drug Type</label>
                                </td>
                                <td>
                                    <textarea style="width:250px;max-width:250px;max-height:40px;" class="input_select_p compact" name="batch"><?php echo $drug_type; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Drug Expiry Dates</td><td><textarea style="width:250px;max-width:250px;max-height:40px;" class="input_select_p compact" class="input_select_p compact" type="text" name="expiry_dates"><?php echo $expiry_dates; ?> </textarea></td>
                            </tr>
                            <tr>
                                <td colspan='2'>
                                    <?php if ($priv_tab_pickup >= 3) { ?>
                                        <input class="btn-custom-small"type="submit" name="updateRecord" value="Update Record" />
                                    <?php } ?>

                                    <center>
                                        <input class="input_textbox" type="hidden" name="form_id"  value="<?php echo $form_id; ?>"/>
                                    </center>
                                </td>
                            </tr>


                                <!-- <input class="btn-custom-small"type="submit" name="name" value="value" > -->
                        </table>
                    </form>
                </center>
            </div> 

        </div>
        <?php
    }
}
?>

<!--filter includes-->
<script type="text/javascript" src="../css/filter-as-you-type/jquery.min.js"></script>
<script type="text/javascript" src="../css/filter-as-you-type/jquery.quicksearch.js"></script>
<script type="text/javascript">
$(function() {
    $('input#id_search').quicksearch('table tbody tr');
});
function show_confirm(deleteid) {
    if (confirm("Are you sure you want to delete?")) {
        location.replace('?deleteId=' + deleteid);
    } else {
        return false;
    }
}

function submitForm() {
    //  document.getElementById('imgLoading').style.visibility = "visible";
    var selectButton = document.getElementById('btnSearchSubmit');
    selectButton.click();
}

</script>