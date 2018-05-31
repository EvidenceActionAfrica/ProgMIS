<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once("../includes/logTracker.php");
$staff_id = $_SESSION['staff_id'];
$staff_email = $_SESSION['staff_email'];
$staff_name = $_SESSION['staff_name'];

$level = $_SESSION['level'];
$tabActive = 'tab1';

$listed_km = isset($_POST["listed_km"]) ? $_POST["listed_km"] : "";
$fuel = isset($_POST["fuel"]) ? $_POST["fuel"] : "";
$fuel_amount = isset($_POST["fuel_amount"]) ? $_POST["fuel_amount"] : "";
$chc_name = isset($_POST["chc_name"]) ? $_POST["chc_name"] : "";
$chc_mpesa_phone = isset($_POST["chc_mpesa_phone"]) ? $_POST["chc_mpesa_phone"] : "";
$county_pharmacist = isset($_POST["county_pharmacist"]) ? $_POST["county_pharmacist"] : "";
$account_documents = isset($_POST["account_documents"]) ? $_POST["account_documents"] : "";
$allowance = isset($_POST["allowance"]) ? $_POST["allowance"] : "";
$total = isset($_POST["total"]) ? $_POST["total"] : "";
$driver_lunch = isset($_POST["driver_lunch"]) ? $_POST["driver_lunch"] : "";
$dateSaved = date("Y-m-d");
if (isset($_POST['submitSaveNew'])) {

    //  $chc_name = str_replace("-", "XXXXXX", $chc_name);
    $sql = "SELECT dmoh_phone FROM health_contacts WHERE dmoh_name='$chc_name'";
    $result = mysql_query($sql);
    while ($rowPhone = mysql_fetch_array($result)) { //loop table rows
        $chc_mpesa_phone = $rowPhone["dmoh_phone"];
    }
}
if (isset($_POST["updateRecord"])) {
    $tabActive = 'tab2';
    $form_id = $_GET["form_id"];
    $sql = "UPDATE `drugs_dispatch_chc` SET `listed_km`='$listed_km',`fuel`='$fuel',`fuel_amount`='$fuel_amount',";
    $sql.="`driver_lunch`='$driver_lunch',`pharmacist_lunch`='$county_pharmacist',`allowance`='$allowance',`total`='$total',`chc_name`='$chc_name',";
    $sql.="`chc_mpesa_phone`='$chc_mpesa_phone',`account_documents`='$account_documents',`date`='$dateSaved' WHERE `form_id`='$form_id'";
    $_GET = "";
//echo $sql;

    mysql_query($sql) or die("Cannot Update Record");

    $action = "Updated \"Dispatch CHC\" ";
    $description = "The Record with a Chc named " . $chc_name . " has been Updated";
    $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
    funclogAdminData($arrLogAdminData);
}
if (isset($_GET['deleteid'])) {
    $tabActive = 'tab2';
}
if (isset($_GET["form_id"])) {

    $tabActive = 'tab2';
}

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
    $priv_dispatch = $row['priv_dispatch'];
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
            <script type="text/javascript" src="../js/validation.js"></script>
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
            <div class="contentBody">
                <?php
                if (isset($_POST['submitSaveNew'])) {


                    $tabActive = 'tab2';
                    $query = "INSERT INTO `drugs_dispatch_chc`(`listed_km`, `fuel`, `fuel_amount`, `driver_lunch`, `pharmacist_lunch`,";
                    $query.="`allowance`, `total`, `chc_name`, `chc_mpesa_phone`, `account_documents`, `date`)";

                    $query.=" VALUES ('$listed_km','$fuel','$fuel_amount','$driver_lunch','$county_pharmacist','$allowance','$total'";
                    $query.=",'$chc_name','$chc_mpesa_phone','$account_documents','$dateSaved')";

                    mysql_query($query) or die(mysql_error());

                    $action = "New Record Saved in \"Dispatch CHC\" ";
                    $description = "Record  With a Chc named: " . $chc_name . " Added";
                    $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
                    funclogAdminData($arrLogAdminData);
                }
                ?>

                <!--tab skeleton-->
                <div class="tabbable" >
                    <ul class="nav nav-tabs">
                        <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Dispatch CHC</a></li>
                        <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">Previous Dispatch CHC data</a></li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>"  id="tab1">

                            <table id="divCurrentAssumptions" style="margin: 0 auto;">
                                <tr>
                                    <form method="post">
                                        <!--header-->
                                        <h1 style="text-align: center; margin-top: 0px; font-size: 20px">Dispatch CHC</h1>
                                        <!-- table begin  =============-->
                                        <td style="width: 59%">
                                            <table border="2" align="center" cellpadding="0" style="width: 100%;">
                                                <tr style="background-color: silver;">
                                                    <td colspan="6" style="padding: 5px;"><b>CHC CASH REQUISITION SUMMARY SHEET <br/>   Calculation Table  </b></td>
                                                </tr>
                                                <tr>
                                                    <td> <b>Description </b> </td>
                                                    <td> <b>Amount </b> </td>
                                                </tr>

                                                <tr>
                                                    <td>Listed KM's from Origin to Destination</td>
                                                    <td align="center" width="200px"><input type="text" style="width: 95%;border:0;" id="listed_km" name="listed_km" value=""  onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                                                </tr>
                                                <tr>
                                                    <td>Fuel is calculated using the 30KShs per Kilometre GoK provided rate (Ministry of Public Works Cirrcular)</td>
                                                    <td><input style="width: 98%;height:100%;border:0;" type="text" id="fuel" name="fuel" value="" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                                                </tr>
                                                <tr>
                                                    <td>Agreed upon Fuel Amount to be given to CHC</td>
                                                    <td><input type="text" style="width: 98%;border:0;" id="fuel_amount" name="fuel_amount" value=""  onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                                                </tr>
                                                <tr>
                                                    <td>Lunch for Driver to Drive to NBO to receive the drugs</td>
                                                    <td><input type="text" style="width: 98%;border:0;" id="driver_lunch" name="driver_lunch"  value="" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                                                </tr>
                                                <tr>
                                                    <td>Lunch for County Pharmacist escorting driver</td>
                                                    <td><input style="width: 98%;border:0;" type="text" id="county_pharmacist" name="county_pharmacist"  value="" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                                                </tr>
                                                <tr>
                                                    <td>Coordination Allowance for CHC</td>
                                                    <td><input style="width: 98%" type="text" id="allowance" name="allowance"  value="" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                                                </tr>
                                                <tr>
                                                    <td><b>TOTAL AMOUNT NEEDED BY CHC</b></td>
                                                    <td><input style="width: 98%" type="text" id="total" name="total"  value=""  onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);"class="txt-input-table-center"/></td>
                                                </tr>
                                                <tr height="20px">
                                                    <td><b></b></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><select style="width:100%" name="chc_name"   required>
                                                            <option value=''></option>
                                                            <?php
                                                            $sql = "SELECT * FROM health_contacts order by dmoh_name,county,district ASC";
                                                            $result = mysql_query($sql);
                                                            while ($rows = mysql_fetch_array($result)) { //loop table rows
                                                                ?>
                                                                <option value="<?php echo $rows['dmoh_name']; ?>" ><?php echo "County " . $rows['county'] . ' - District ' . $rows['district'] . ' -  Name ' . $rows['dmoh_name'] . ' -  ' . $rows['dmoh_phone']; ?></option>
                                                            <?php } ?>
                                                        </select></td>
                                                    <td align="right" style="">CHC's Name & Phone</td>
                                                </tr>

                                            </table><br/><br/>
                                        </td>
                                        <td style="float: left; width: 70%; padding-left: 20px">
                                            <b>Date Saved </b><input type="text"  value="<?php echo $dateSaved; ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);"class="txt-input-table-center" style="width: 100px" readonly />
                                            <br/> <br/>
                                            <b> Accountability Documents to be received  </b><br/>
                                            <textarea cols="50" rows="8" id="account_documents" name="account_documents" placeholder=""></textarea>
                                            <br/> <br/>
                                            <a href="javascript:void(0)" style="float: left; width: 43%" class="btn-custom-tiny" onclick="calculateAssumptions();"> Confirm calculations</a>
                                            <?php if ($priv_dispatch >= 2) { ?>
                                                <input style="float: left" type="submit" name="submitSaveNew" value="Save record" class="btn-custom-tiny"/>
                                            <?php } ?>
                                        </td>
                                        <div class="vclear"></div>
                                        <br/>
                                    </form>
                                </tr>
                            </table><br/>

                            <!--================================================-->
                            <!--   OTHER RECORDS           -->
                            <!--================================================-->
                            <?php
//Delete
                            if (isset($_GET['deleteid'])) {

                                $deleteid = $_GET['deleteid'];
                                $query = "DELETE FROM drugs_dispatch_chc WHERE form_id='$deleteid'";
                                $_GET = "";
                                $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());

                                $action = "Deleted A record in \"Dispatch CHC\" ";
                                $description = "Record ID: " . $deleteid . " Deleted";
                                $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
                                funclogAdminData($arrLogAdminData);
                            }
                            ?>





                        </div>
                        <div style="float:left;width:100%;" class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>"  id="tab2">

                            <center>  <h2 style="text-align:center; margin-top: 0px; font-size: 20px">Previous Dispatch CHC data</h2>
                            </center>




                            <!--
                            <table >
                                <tr>
                                    <td style="width: 100%;">

                                        <form method="post" style=" ">
                                               
                                        <table  style="width:100%; overflow-x: visible; overflow-y: scroll; float: left"width="%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                                            <tbody>
                                                <thead>
                                                    <tr style="border: 1px solid #B4B5B0;">
                                                        <th align="Left" width="20px">ID</th>
                                                        <th align="Left" width="30px">Date Saved</th>
                            <?php if ($priv_dispatch >= 1) { ?>
                                                                                <th align="center" width="25px">View</th>
                            <?php }if ($priv_dispatch >= 4) { ?>
                                                                                <th align="center" width="25px">Del</th>
                            <?php } ?>
                                                    </tr>
                                                </thead>

                            <?php
                            $form_id = isset($_GET["form_id"]) ? $_GET["form_id"] : "";

                            $result_display = mysql_query("SELECT * FROM drugs_dispatch_chc where form_id like '%$form_id%'");

                            while ($row = mysql_fetch_array($result_display)) {
                                $listed_km = $row["listed_km"];
                                $fuel = $row["fuel"];
                                ;
                                $fuel_amount = $row["fuel_amount"];
                                $chc_name = $row["chc_name"];
                                $chc_mpesa_phone = $row["chc_mpesa_phone"];
                                $county_pharmacist = $row["pharmacist_lunch"];
                                $account_documents = $row["account_documents"];
                                $allowance = $row["allowance"];
                                $total = $row["total"];
                                $driver_lunch = $row["driver_lunch"];
                                $dateSaved = $row["date"];
                                $form_id = $row["form_id"];
                                ?>
                                                                        <tr style="border-bottom: 1px solid #B4B5B0;">
        
                                                                            <td align="left" width="40px"> <?php echo $form_id; ?>  </td>
                                                                            <td align="left" width="100px"> <?php echo $dateSaved; ?>  </td>  
        
                                <?php if ($priv_dispatch >= 1) { ?>
                                                                                                    <td align="center" width="40px"><a href="dispatchCHC.php?form_id=<?php echo $form_id ?>" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                                <?php }if ($priv_dispatch >= 4) { ?>
                                                                                                    <td align="center" width="40px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $form_id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                                <?php } ?>
                                                                        </tr>
                                                                    </tbody>
                            <?php } ?>
                                       
                                            </table>
                                        </form>







                                    </td>
                                    <div style="width: 100%;float:left;margin-left:; margin-top>

                                        <form method="post">
                            <!--header-->
                            <!--<h1 style="text-align: center; margin-top: 0px; font-size: 20px">Dispatch CHC</h1>-->
                            <!-- table begin  =============-->

                            <table border="2" align="" cellpadding="0" style="float:right; " >
                                <form method="post" style=" ">



                                    <tr style="background-color: silver;">
                                        <td colspan="6" style="padding: 5px;"><b>CHC CASH REQUISITION SUMMARY SHEET <br/>   Calculation Table  </b></td>
                                    </tr>
                                    <tr>
                                        <td> <b>Description </b> </td>
                                        <td> <b>Amount </b> </td>
                                    </tr>

                                    <tr>
                                        <td>Listed KM's from Origin to Destination</td>
                                        <td align="center" width="100px"><input type="text" id="listed_km2" name="listed_km" value="<?php echo $listed_km; ?>" onBlur="calculateAssumptions2();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                                    </tr>
                                    <tr>
                                        <td>Fuel is calculated using the 30KShs per Kilometre GoK provided rate (Ministry of Public Works Cirrcular)</td>
                                        <td><input type="text" id="fuel2" name="fuel" value="<?php echo $fuel; ?>" onBlur="calculateAssumptions2();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                                    </tr>
                                    <tr>
                                        <td>Agreed upon Fuel Amount to be given to CHC</td>
                                        <td><input type="text" id="fuel_amount2" name="fuel_amount" value="<?php echo $fuel_amount ?>" onBlur="calculateAssumptions2();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td>Lunch for Driver to Drive to NBO to receive the drugs</td>
                                        <td><input type="text" id="driver_lunch2" name="driver_lunch"  value="<?php echo $driver_lunch ?>" onBlur="calculateAssumptions2();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                                    </tr>
                                    <tr>
                                        <td>Lunch for County Pharmacist escorting driver</td>
                                        <td><input type="text" id="county_pharmacist2" name="county_pharmacist"  value="<?php echo $county_pharmacist; ?>" onBlur="calculateAssumptions2();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                                    </tr>
                                    <tr>
                                        <td>Coordination Allowance for CHC</td>
                                        <td><input type="text" id="allowance2" name="allowance"  value="<?php echo $allowance; ?>" onBlur="calculateAssumptions2();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                                    </tr>
                                    <tr>
                                        <td><b>TOTAL AMOUNT NEEDED BY CHC</b></td>
                                        <td><input type="text" id="total2" name="total"  value="<?php echo $total; ?>" onBlur="calculateAssumptions2();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td align="right">CHC's Name</td>
                                        <td><input type="text" id="chc_name2" name="chc_name"  value="<?php echo $chc_name ?>" class="txt-input-table-center"/></td>
                                    </tr>
                                    <tr>
                                        <td align="right">CHC's Mpesa Phone No.</td>
                                        <td><input type="text" id="chc_mpesa_phone2" name="chc_mpesa_phone"  value="<?php echo $chc_mpesa_phone ?>" class="txt-input-table-center"/></td>
                                    </tr>



                                    <tr>
                                        <td >
                                            <b>Date Saved </b><input type="text"  value="<?php echo $dateSaved; ?>" class="txt-input-table-center" style="width: 100px" readonly />
                                            <br/> <br/>
                                            <b> Accountability Documents to be received  </b><br/>
                                            <textarea cols="50" rows="5" id="account_documents2" name="account_documents" placeholder=""><?php echo $account_documents; ?></textarea>
                                            <br/> <br/>

                                            <?php if ($priv_dispatch >= 1) { ?>

                                            <?php }if ($priv_dispatch >= 2) { ?>
                                                <input style="float: left" type="submit" name="updateRecord" value="Update record" class="btn-custom-tiny"/>

                                            <?php } ?>
                                        </td>
                                    </tr>
                                </form>
                            </table>



                            <table  style="width:25%; overflow-x: visible; overflow-y: scroll;float:left;"  border="0" frame="box" align="center" cellspacing="1" class="table-hover">

                                <form method="post" style=" ">

                                    <thead>
                                        <tr style="border: 1px solid #B4B5B0;">
                                            <th align="Left" width="20px">ID</th>
                                            <th align="Left" width="30px">Date Saved</th>
                                            <?php if ($priv_dispatch >= 1) { ?>
                                                <th align="center" width="25px">View</th>
                                            <?php }if ($priv_dispatch >= 4) { ?>
                                                <th align="center" width="25px">Del</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $form_id = isset($_GET["form_id"]) ? $_GET["form_id"] : "";

                                        $result_display = mysql_query("SELECT * FROM drugs_dispatch_chc where form_id like '%$form_id%'");

                                        while ($row = mysql_fetch_array($result_display)) {
                                            $listed_km = $row["listed_km"];
                                            $fuel = $row["fuel"];
                                            ;
                                            $fuel_amount = $row["fuel_amount"];
                                            $chc_name = $row["chc_name"];
                                            $chc_mpesa_phone = $row["chc_mpesa_phone"];
                                            $county_pharmacist = $row["pharmacist_lunch"];
                                            $account_documents = $row["account_documents"];
                                            $allowance = $row["allowance"];
                                            $total = $row["total"];
                                            $driver_lunch = $row["driver_lunch"];
                                            $dateSaved = $row["date"];
                                            $form_id = $row["form_id"];
                                            ?>
                                            <tr style="border-bottom: 1px solid #B4B5B0;">

                                                <td align="left" width="40px"> <?php echo $form_id; ?>  </td>
                                                <td align="left" width="100px"> <?php echo $dateSaved; ?>  </td>  

                                                <?php if ($priv_dispatch >= 1) { ?>
                                                    <td align="center" width="40px"><a href="dispatchCHC.php?form_id=<?php echo $form_id ?>" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                                                <?php }if ($priv_dispatch >= 4) { ?>
                                                    <td align="center" width="40px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $form_id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                                                <?php } ?>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </form>
                            </table>
                          


                        </div>




                    </div>

                </div>
            </div>

        </div>

        </div>  
        <!---------------- Footer ------------------------>
        <!--<div class="footer">  </div>-->

        <script type="text/javascript">
            function calculateAssumptions() {

                var listed_km = document.getElementById("listed_km");
                var fuel = document.getElementById("fuel");
                var fuel_amount = document.getElementById("fuel_amount");
                var chc_name = document.getElementById("chc_name");
                var chc_mpesa_phone = document.getElementById("chc_mpesa_phone");
                var county_pharmacist = document.getElementById("county_pharmacist")

                var allowance = document.getElementById("allowance");
                var total = document.getElementById("total");
                var driver_lunch = document.getElementById("driver_lunch");

                fuel_amount.value = (listed_km.value * 1) * (fuel.value * 1);
                console.log(fuel_amount.value);
                total.value = (fuel_amount.value * 1) + (county_pharmacist.value * 1) + (allowance.value * 1) + (driver_lunch.value * 1);
                console.log(total.value);
            }

            function calculateAssumptions2() {

                var listed_km2 = document.getElementById("listed_km2");
                var fuel2 = document.getElementById("fuel2");
                var fuel_amount2 = document.getElementById("fuel_amount2");
                var chc_name2 = document.getElementById("chc_name2");
                var chc_mpesa_phone2 = document.getElementById("chc_mpesa_phone2");
                var county_pharmacist2 = document.getElementById("county_pharmacist2")

                var allowance2 = document.getElementById("allowance2");
                var total2 = document.getElementById("total2");
                var driver_lunch2 = document.getElementById("driver_lunch2");

                fuel_amount2.value = (listed_km2.value * 1) * (fuel2.value * 1);
                console.log(fuel_amount2.value);
                total2.value = (fuel_amount2.value * 1) + (county_pharmacist2.value * 1) + (allowance2.value * 1) + (driver_lunch2.value * 1);
                console.log(total2.value);
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

<script src="../js/keydown_event"></script>



