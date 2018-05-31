<?php
date_default_timezone_set("Africa/Nairobi");
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$tabActive = "tab1";
$level = $_SESSION['level'];

// privileges check.DO NOT TOUCH
    $priv_materials_edit =4;


if (isset($_GET["tab"])) {
    $tabActive = $_GET["tab"];
}

if (isset($_POST["addQuantity"])) {
    $boxId = isset($_GET["boxId"]) ? $_GET["boxId"] : 0;
    $ttb = isset($_POST["ttb"]) ? $_POST["ttb"] : 0;
    $form_e = isset($_POST["form_e"]) ? $_POST["form_e"] : 0;
    $form_n = isset($_POST["form_n"]) ? $_POST["form_n"] : 0;
    $form_s = isset($_POST["form_s"]) ? $_POST["form_s"] : 0;
    $form_ep = isset($_POST["form_ep"]) ? $_POST["form_ep"] : 0;
    $form_np = isset($_POST["form_np"]) ? $_POST["form_np"] : 0;
    $form_sp = isset($_POST["form_sp"]) ? $_POST["form_sp"] : 0;
    $attnt = isset($_POST["attnt"]) ? $_POST["attnt"] : 0;
    $poster1 = isset($_POST["poster1"]) ? $_POST["poster1"] : 0;
    $poster2 = isset($_POST["poster2"]) ? $_POST["poster2"] : 0;
    $county = isset($_GET["county_name"]) ? $_GET["county_name"] : "unknown";
    $district = isset($_GET["district_name"]) ? $_GET["district_name"] : "unknown";
    $userName = $_SESSION["staff_name"];
    $responsible = isset($_POST["responsible"]) ? $_POST["responsible"] : "unknown";
    $dater = time();

    $sql = "INSERT INTO `materials_acc_ttb`(`ttb`, `form_e`, `form_n`, `form_s`,";
    $sql.="`form_ep`, `form_np`, `form_sp`, `attnt_packet`, `poster_1`, `poster_2`, `county_name`,";
    $sql.="`district_name`, `prepared_by`, `collected_by`, `date`,`box_id`) ";
    $sql.="VALUES ('$ttb','$form_e','$form_n','$form_s','$form_ep','$form_np','$form_sp'";
    $sql.=",'$attnt','$poster1','$poster2','$county','$district','$userName','$responsible','$dater','$boxId')";

// echo $sql."<br/>";
    mysql_query($sql)or die(mysql_error());
    $updateResult = "Record Has Been Saved";
}

if (isset($_POST["addDTBQuantity"])) {
    $boxId = isset($_GET["boxId"]) ? $_GET["boxId"] : 0;
    $mtp = isset($_POST["mtp"]) ? mysql_real_escape_string($_POST["mtp"]) : "";
    $dc_packet = isset($_POST["dcPacket"]) ? mysql_real_escape_string($_POST["dcPacket"]) : "";
    $dpho_packet = isset($_POST["dphoPacket"]) ? mysql_real_escape_string($_POST["dphoPacket"]) : "";
    $dtb = isset($_POST["dtb"]) ? mysql_real_escape_string($_POST["dtb"]) : "";
    $ttb = isset($_POST["ttb"]) ? mysql_real_escape_string($_POST["ttb"]) : "";
    $hfd = isset($_POST["hfd"]) ? mysql_real_escape_string($_POST["hfd"]) : "";
    $gdlm = isset($_POST["gdlm"]) ? mysql_real_escape_string($_POST["gdlm"]) : "";
    $ttk = isset($_POST["ttk"]) ? mysql_real_escape_string($_POST["ttk"]) : "";
    $formA = isset($_POST["formA"]) ? mysql_real_escape_string($_POST["formA"]) : "";
    $formAp = isset($_POST["formAp"]) ? mysql_real_escape_string($_POST["formAp"]) : "";
    $poster1 = isset($_POST["poster1"]) ? $_POST["poster1"] : 0;
    $poster2 = isset($_POST["poster2"]) ? $_POST["poster2"] : 0;
    $county = isset($_GET["county_name"]) ? $_GET["county_name"] : "unknown";
    $district = isset($_GET["district_name"]) ? $_GET["district_name"] : "unknown";
    $userName = $_SESSION["staff_name"];
    $responsible = isset($_POST["responsible"]) ? $_POST["responsible"] : "unknown";
    $dater = time();

    $sql = "INSERT INTO `materials_acc_dtb`(`box_id`,`mtp`, `dc_packet`,";
    $sql.="`dpho_packet`, `dtb`, `ttb`, `hfd`, `gdlm`, `ttk`, `form_a`, `form_ap`, `poster_1`, `poster_2`,";
    $sql.="`county_name`, `district_name`, `prepared_by`, `collected_by`, `date`)";
    $sql.="VALUES ('$boxId','$mtp','$dc_packet','$dpho_packet','$dtb','$ttb','$hfd','$gdlm',";
    $sql.="'$ttk','$formA','$formAp','$poster1','$poster2','$county','$district','$userName',";
    $sql.="'$responsible','$dater')";
    // echo $sql . "<br/>";
    mysql_query($sql)or die(mysql_error());
}
if (isset($_POST["updateQuantity"])) {
    $entryId = isset($_GET["entryId"]) ? $_GET["entryId"] : 0;
    $ttb = isset($_POST["ttb"]) ? $_POST["ttb"] : 0;
    $form_e = isset($_POST["form_e"]) ? $_POST["form_e"] : 0;
    $form_n = isset($_POST["form_n"]) ? $_POST["form_n"] : 0;
    $form_s = isset($_POST["form_s"]) ? $_POST["form_s"] : 0;
    $form_ep = isset($_POST["form_ep"]) ? $_POST["form_ep"] : 0;
    $form_np = isset($_POST["form_np"]) ? $_POST["form_np"] : 0;
    $form_sp = isset($_POST["form_sp"]) ? $_POST["form_sp"] : 0;
    $attnt = isset($_POST["attnt"]) ? $_POST["attnt"] : 0;
    $poster1 = isset($_POST["poster1"]) ? $_POST["poster1"] : 0;
    $poster2 = isset($_POST["poster2"]) ? $_POST["poster2"] : 0;
    $userName = $_SESSION["staff_name"];
    $responsible = isset($_POST["responsible"]) ? $_POST["responsible"] : "unknown";
    $dater = time();

    $sql = "UPDATE `materials_acc_ttb` SET `ttb`='$ttb',";
    $sql.="`form_e`='$form_e',`form_n`='$form_n',`form_s`='$form_s',`form_ep`='$form_ep',`form_np`='$form_np',";
    $sql.="`form_sp`='$form_sp',`attnt_packet`='$attnt',`poster_1`='$poster1',`poster_2`='$poster2',";
    $sql.="`prepared_by`='$userName',";
    $sql.="`collected_by`='$responsible',`date`='$dater' WHERE `entry_id`='$entryId'";
    //echo $sql."<br/>";
    mysql_query($sql)or die(mysql_error());
}


if (isset($_POST["updateDTBQuantity"])) {
    $entryId = isset($_GET["entryId"]) ? $_GET["entryId"] : 0;
    $mtp = isset($_POST["mtp"]) ? mysql_real_escape_string($_POST["mtp"]) : "";
    $dcPacket = isset($_POST["dcPacket"]) ? mysql_real_escape_string($_POST["dcPacket"]) : "";
    $dphoPacket = isset($_POST["dphoPacket"]) ? mysql_real_escape_string($_POST["dphoPacket"]) : "";
    $dtb = isset($_POST["dtb"]) ? mysql_real_escape_string($_POST["dtb"]) : "";
    $ttb = isset($_POST["ttb"]) ? mysql_real_escape_string($_POST["ttb"]) : "";
    $hfd = isset($_POST["hfd"]) ? mysql_real_escape_string($_POST["hfd"]) : "";
    $gdlm = isset($_POST["gdlm"]) ? mysql_real_escape_string($_POST["gdlm"]) : "";
    $ttk = isset($_POST["ttk"]) ? mysql_real_escape_string($_POST["ttk"]) : "";
    $formA = isset($_POST["formA"]) ? mysql_real_escape_string($_POST["formA"]) : "";
    $formAp = isset($_POST["formAp"]) ? mysql_real_escape_string($_POST["formAp"]) : "";
    $poster1 = isset($_POST["poster1"]) ? $_POST["poster1"] : 0;
    $poster2 = isset($_POST["poster2"]) ? $_POST["poster2"] : 0;
    $county = isset($_GET["county_name"]) ? $_GET["county_name"] : "unknown";
    $district = isset($_GET["district_name"]) ? $_GET["district_name"] : "unknown";
    $userName = $_SESSION["staff_name"];
    $responsible = isset($_POST["responsible"]) ? $_POST["responsible"] : "unknown";
    $dater = time();

    $sql = "UPDATE `materials_acc_dtb` SET `mtp`='$mtp',`dc_packet`='$dcPacket',";
    $sql.="`dpho_packet`='$dphoPacket',`dtb`='$dtb',`ttb`='$ttb',`hfd`='$hfd',`gdlm`='$gdlm',";
    $sql.="`ttk`='$ttk',`form_a`='$formA',`form_ap`='$formAp',`poster_1`='$poster1',`poster_2`='$poster2',";
    $sql.="`prepared_by`='$userName',`collected_by`='$responsible',";
    $sql.="`date`='$dater' WHERE `entry_id`='$entryId'";
  //   echo $sql . "<br/>";
    mysql_query($sql)or die(mysql_error());
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

  <!-- Modal includes -->
  <link rel="stylesheet" type="text/css" href="css/modal.css"/>


    <body>
        <!---------------- header start ------------------------>
        <div class="header">
            <div style="float: left">  <img src="../images/logo.png" />  </div>
            <div class="menuLinks">
                <?php require_once ("includes/menuNav_strict.php"); ?>
            </div>
        </div>
        <div class="clearFix"></div>
        <!---------------- content body ------------------------>
        <div class="contentMain">
            
            
            <div class="contentBody" >
                <div class="tabbable" style="width:120%;" >
                    <ul class="nav nav-tabs">

                        <li style="margin-left:40%;"<?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Delivered Teacher<br/> Training Boxes</a></li>
                        <li <?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">Teacher Training<br/> Entry History</a></li>
                      
                    </ul>
                    <div class="tab-content" style="max-height:650px; overflow:scroll;">

                        <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                            <p><?php require_once("materials_acc_ttb_strict.php"); ?></p>
                        </div>

                        <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
                            <p><?php  require_once("materials_acc_ttb_entry_strict.php"); ?></p>

                        </div> 
                        <div class="tab-pane <?php if ($tabActive == 'tab5') echo 'active'; ?>" id="tab5">
                            <p><?php require_once("materials_acc_ttb_entry_data_strict.php"); ?></p>
                        </div> 

                    </div>
                </div>
                <?php
                if ($_GET["tab"] == "tab5") {
                    ?>
                    <h2 style="margin-left:25%;">Teacher Training Box Totals</h2>
                    <table class="table table-bordered table-condensed " style="font-weight:bolder;margin-left:10%;">
                        <tr>
                            <th>Reference</th>
                            <th>Teacher Training Booklet </th>
                            <th>Form E Packet (20 forms each)</th>
                            <th>Form N Packet (15 forms each)</th>
                            <th>Form S Packet (5 forms each) </th>
                            <th>Form E-P Packet (20 forms each)</th>
                            <th>Form N-P Packet (5 forms each)</th>
                            <th>Form S-P Packet (5 forms each)</th>
                            <th>ATTNT Packet (20 forms each)</th>
                            <th>Poster 1- Date</th>
                            <th>Poster 2- Behavior Change</th>
                        </tr>
                        <?php
                        $sql = "select * from materials_packaging_history_ttb  WHERE county_name='$county' AND district_name='$district'";
                        $resultB = mysql_query($sql)or die(mysql_error());
                        while ($row = mysql_fetch_array($resultB)) {
                            $old_ttb+=$row["ttb"];
                            $old_formE+=$row["form_e"];
                            $old_formN+=$row["form_n"];
                            $old_formS+=$row["form_s"];
                            $old_formEp+=$row["form_ep"];
                            $old_formNp+=$row["form_np"];
                            $old_formSp+=$row["form_sp"];
                            $old_attntPacket+= $row["attnt_packet"];
                            $old_poster1+= $row["poster_1"];
                            $old_poster2+= $row["poster_2"];
                        }
                        ?>


                        <tr style="background-color:#F4FA58;">
                            <td><i>ACTUAL CONTENT DELIVERED</td></i></td>
                            <td><?php echo $old_ttb; ?></td>
                            <td><?php echo $old_formE; ?></td>
                            <td><?php echo $old_formN; ?></td>
                            <td><?php echo $old_formS; ?></td>
                            <td><?php echo $old_formEp; ?></td>
                            <td><?php echo $old_formNp; ?></td>
                            <td><?php echo $old_formSp; ?></td>
                            <td><?php echo $old_attntPacket; ?></td>
                            <td><?php echo $old_poster1; ?></td>
                            <td><?php echo $old_poster2; ?></td>

                        </tr>
                        <tr style="background-color:#bada66;">
                            <td><i>Total Collected</i></td>
                            <td><?php echo $total_ttb; ?></td>
                            <td><?php echo $total_formE; ?></td>
                            <td><?php echo $total_formN; ?></td>
                            <td><?php echo $total_formS; ?></td>
                            <td><?php echo $total_formEp; ?></td>
                            <td><?php echo $total_formNp; ?></td>
                            <td><?php echo $total_formSp; ?></td>
                            <td><?php echo $total_attntPacket; ?></td>
                            <td><?php echo $total_poster1; ?></td>
                            <td><?php echo $total_poster2; ?></td>
                        </tr>

                        <tr style="background-color:#FF8D8D">
                            <td>Total Remaining</td>
                            <td><?php echo $old_ttb - $total_ttb; ?></td>
                            <td><?php echo $old_formE - $total_formE; ?></td>
                            <td><?php echo $old_formN - $total_formN; ?></td>
                            <td><?php echo $old_formS - $total_formS; ?></td>
                            <td><?php echo $old_formEp - $total_formEp; ?></td>
                            <td><?php echo $old_formNp - $total_formNp; ?></td>
                            <td><?php echo $old_formSp - $total_formSp; ?></td>
                            <td><?php echo $old_attntPacket - $total_attntPacket; ?></td>
                            <td><?php echo $old_poster1 - $total_poster1; ?> </td>
                            <td><?php echo $old_poster2 - $total_poster2; ?></td>
                        </tr>   




                    </table>
                    <?php
                }
                ?>
            </div>

        </div> 

        <?php
        if (isset($_POST["addQuantity"])) {

            $updateResult = "Record Has Been Saved";
        }
        ?>
        <!-- Modal For Adding Teacher Training Boxes-->

        <div id="addQuantity" class="modalDialog" style="width:100%; ">
            <div >
                <div>
                    <a href="materials_tts_strict.php" title="Close" class="close">X</a>

                    <form method="POST" style="margin-left:2%;">

                        <?php
                        echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;text-align:center;'>" . $updateResult . "</h3>";
                        $updateResult = "";
                        ?>

                        <div style="margin-left:10%;">

                            <img style="width:10%;" src="../images/gklogo.png"/>
                            <b>Kenya National School-Based Deworming Programme</b>
                            <img style="width:10%;" src="../images/kwaAfya.png"/>
                            <hr style="font-weight:bolder;color:#EEEE;"/>
                        </div>   
                        <br/>

                        <h4 style="margin-left:20%;">Quantities Used</h4>

                        <table class="table table-bordered table-condensed table-striped table-hover">

                            <tr>

                                <th>Teacher Training Booklet </th>
                                <th>Form E Packet (20 forms each)</th>
                                <th>Form N Packet (15 forms each)</th>
                                <th>Form S Packet (5 forms each) </th>
                                <th>Form E-P Packet (20 forms each)</th>
                                <th>Form N-P Packet (5 forms each)</th>
                            </tr>
                            <tr>
                                <td><input class="num-only" type="text" name="ttb" value=""/></td>
                                <td><input class="num-only" type="text" name="form_e" value=""/></td>
                                <td><input class="num-only" type="text" name="form_n" value=""/></td>
                                <td><input class="num-only" type="text" name="form_s" value=""/></td>
                                <td><input class="num-only" type="text" name="form_ep" value=""/></td>
                                <td><input class="num-only" type="text" name="form_np" value=""/></td>
                            </tr>
                            <tr>

                                <th>Form S-P Packet (5 forms each)</th>
                                <th>ATTNT Packet (20 forms each)</th>
                                <th>Poster 1- Date</th>
                                <th>Poster 2- Behavior Change</th>
                                <th>Person Responsible</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="form_sp" value=""/></td>

                                <td><input class="num-only" type="text" name="attnt" value=""/></td>
                                <td><input class="num-only" type="text" name="poster1" value=""/></td>
                                <td><input class="num-only" type="text" name="poster2" value=""/></td>
                                <td><input type="text" name="responsible" value=""/></td>
                            </tr>




                        </table>
                        <input type="submit" style="margin-left:25%;" class="btn-custom" name="addQuantity" value="Save" />
                    </form>

                </div>
            </div>
        </div>
        <!-- Modal For Adding District Training Boxes-->


        <div id="addDTBQuantity" class="modalDialog" style="width:100%; ">
            <div >
                <div>
                    <a href="materials_tts_strict.php" title="Close" class="close">X</a>

                    <form method="POST" style="margin-left:2%;">

                        <?php
                        echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;text-align:center;'>Record Saved</h3>";
                        ?>

                        <div style="margin-left:10%;">

                            <img style="width:10%;" src="../images/gklogo.png"/>
                            <b>Kenya National School-Based Deworming Programme</b>
                            <img style="width:10%;" src="../images/kwaAfya.png"/>
                            <hr style="font-weight:bolder;color:#EEEE;"/>
                        </div>   
                        <br/>

                        <h2 style="margin-left:30%;">Quantities Used</h2>
                        <table class="table table-bordered table-condensed table-striped table-hover">

                            <tr>
                                <th>Master Trainers Packet</th>
                                <th>DC Packet</th>
                                <th>DPHO Packet</th>

                                <th>District Training Booklet</th>
                                <th>Teacher Training Booklet </th>

                                <th>Handout on Financial Disbursements</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="mtp" value="" /></td>
                                <td><input type="text" name="dcPacket" value="" /></td>
                                <td><input type="text" name="dphoPacket" value="" /></td>

                                <td><input type="text" name="dtb" value="" /></td>
                                <td><input type="text" name="ttb" value="" /></td>
                                <td><input type="text" name="hfd" value="" /></td>
                            </tr>

                            <tr>

                                <th>Guide for District Level Managers (old)</th>

                                <th>Teacher Training Kit (old)</th>

                                <th>Form A</th>


                            </tr>
                            <tr>
                                <td><input type="text" name="gdlm" value="" /></td>
                                <td><input type="text" name="ttk" value="" /></td>
                                <td><input type="text" name="formA" value="" /></td>

                            </tr>   
                            <tr>
                                <th>Form AP</th>

                                <th>Poster 1 - Deworming Date</th>
                                <th>Poster 2 – Behavior change</th>
                                <th>Person Responsible</th>

                            </tr>
                            <tr>
                                <td><input type="text" name="formAp" value="" /></td>
                                <td><input type="text" name="poster1" value="" /></td>
                                <td><input type="text" name="poster2" value="" /></td>
                                <td><input type="text" name="responsible" value="" /></td>

                            </tr>

                        </table>
                        <input type="submit" style="margin-left:25%;" class="btn-custom" name="addDTBQuantity" value="Save" />
                    </form>

                </div>
            </div>
        </div>




        <!-- Modal For Edit Teacher Training Boxes-->

        <div id="editQuantity" class="modalDialog" style="width:100%; ">
            <div >
                <div>
                    <a href="materials_tts_strict.php" title="Close" class="close">X</a>

                    <form method="POST" style="margin-left:2%;">

<?php
if (isset($_POST["updateQuantity"])) {
    echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;text-align:center;'>Record Has Been Updated</h3>";
}
?>

                        <div style="margin-left:10%;">

                            <img style="width:10%;" src="../images/gklogo.png"/>
                            <b>Kenya National School-Based Deworming Programme</b>
                            <img style="width:10%;" src="../images/kwaAfya.png"/>
                            <hr style="font-weight:bolder;color:#EEEE;"/>
                        </div>   
                        <br/>

                        <h4 style="margin-left:20%;">Quantities Used</h4>

                        <table class="table table-bordered table-condensed table-striped table-hover">

                            <tr>

                                <th>Teacher Training Booklet </th>
                                <th>Form E Packet (20 forms each)</th>
                                <th>Form N Packet (15 forms each)</th>
                                <th>Form S Packet (5 forms each) </th>
                                <th>Form E-P Packet (20 forms each)</th>
                                <th>Form N-P Packet (5 forms each)</th>
                            </tr>

<?php
$entryId = $_GET["entryId"];
$sql = "select * from materials_acc_ttb where entry_id='" . $entryId . "'";
// echo $sql;
$resultE = mysql_query($sql);
while ($row2 = mysql_fetch_array($resultE)) {
    $ttb = $row2["ttb"];
    $form_e = $row2["form_e"];
    $form_n = $row2["form_n"];
    $form_s = $row2["form_s"];
    $form_ep = $row2["form_ep"];
    $form_np = $row2["form_np"];
    $attnt = $row2["attnt_packet"];
    $form_sp = $row2["form_sp"];
    $poster1 = $row2["poster_1"];
    $poster2 = $row2["poster_2"];
    $responsible = $row2["collected_by"];
}
?>
                            <tr>
                                <td><input class="num-only" type="text" name="ttb" value="<?php echo $ttb; ?>"/></td>
                                <td><input class="num-only" type="text" name="form_e" value="<?php echo $form_e; ?>"/></td>
                                <td><input class="num-only" type="text" name="form_n" value="<?php echo $form_n; ?>"/></td>
                                <td><input class="num-only" type="text" name="form_s" value="<?php echo $form_s; ?>"/></td>
                                <td><input class="num-only" type="text" name="form_ep" value="<?php echo $form_ep; ?>"/></td>
                                <td><input class="num-only" type="text" name="form_np" value="<?php echo $form_np; ?>"/></td>
                            </tr>
                            <tr>

                                <th>Form S-P Packet (5 forms each)</th>
                                <th>ATTNT Packet (20 forms each)</th>
                                <th>Poster 1- Date</th>
                                <th>Poster 2- Behavior Change</th>
                                <th>Person Responsible</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="form_sp" value="<?php echo $form_sp; ?>"/></td>
                                <td><input class="num-only" type="text" name="attnt" value="<?php echo $attnt; ?>"/></td>
                                <td><input class="num-only" type="text" name="poster1" value="<?php echo $poster1; ?>"/></td>
                                <td><input class="num-only" type="text" name="poster2" value="<?php echo $poster2; ?>"/></td>
                                <td><input type="text" name="responsible" value="<?php echo $responsible; ?>"/></td>
                            </tr>




                        </table>
                        <input type="submit" style="margin-left:25%;" class="btn-custom" name="updateQuantity" value="Update" />
                    </form>

                </div>
            </div>
        </div>   



<!--- Modal For Editing District Training Entries-->


        <div id="editDTBQuantity" class="modalDialog" style="width:100%; ">
            <div >
                <div>
                    <a href="materials_tts_strict.php" title="Close" class="close">X</a>

                    <form method="POST" style="margin-left:2%;">

           <?php
if (isset($_POST["updateDTBQuantity"])) {
    echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;text-align:center;'>Record Has Been Updated</h3>";
}
?>

                        <div style="margin-left:10%;">

                            <img style="width:10%;" src="../images/gklogo.png"/>
                            <b>Kenya National School-Based Deworming Programme</b>
                            <img style="width:10%;" src="../images/kwaAfya.png"/>
                            <hr style="font-weight:bolder;color:#EEEE;"/>
                        </div>   
                        <br/>

                        <h2 style="margin-left:30%;">Quantities Used</h2>
                        <table class="table table-bordered table-condensed table-striped table-hover">
<?php
$entryId = $_GET["entryId"];
$sql = "select * from materials_acc_dtb where entry_id='" . $entryId . "'";
// echo $sql;
$resultE = mysql_query($sql);
while ($row = mysql_fetch_array($resultE)) {
                   $mtp = $row["mtp"];
                $dcPacket= $row["dc_packet"];
                $dphoPacket = $row["dpho_packet"];
                $dtb = $row["dtb"];
                $ttb = $row["ttb"];
                $hfd = $row["hfd"];
                $gdlm = $row["gdlm"];
                $ttk = $row["ttk"];
                $formA = $row["form_a"];
                $formAp = $row["form_ap"];
                $poster1 = $row["poster_1"];
                $poster2 = $row["poster_2"];

    $responsible = $row["collected_by"];
}
?>
                            <tr>
                                <th>Master Trainers Packet</th>
                                <th>DC Packet</th>
                                <th>DPHO Packet</th>

                                <th>District Training Booklet</th>
                                <th>Teacher Training Booklet </th>

                                <th>Handout on Financial Disbursements</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="mtp" value="<?php echo $mtp; ?>" /></td>
                                <td><input type="text" name="dcPacket" value="<?php echo $dcPacket; ?>" /></td>
                                <td><input type="text" name="dphoPacket" value="<?php echo $dphoPacket; ?>" /></td>
                                 <td><input type="text" name="dtb" value="<?php echo $dtb; ?>" /></td>
                                <td><input type="text" name="ttb" value="<?php echo $ttb; ?>" /></td>
                                <td><input type="text" name="hfd" value="<?php echo $hfd; ?>" /></td>
                            </tr>

                            <tr>

                                <th>Guide for District Level Managers (old)</th>

                                <th>Teacher Training Kit (old)</th>

                                <th>Form A</th>


                            </tr>
                            <tr>
                                <td><input type="text" name="gdlm" value="<?php echo $gdlm; ?>" /></td>
                                <td><input type="text" name="ttk" value="<?php echo $ttk; ?>" /></td>
                                <td><input type="text" name="formA" value="<?php echo $formA; ?>" /></td>

                            </tr>   
                            <tr>
                                <th>Form AP</th>

                                <th>Poster 1 - Deworming Date</th>
                                <th>Poster 2 – Behavior change</th>
                                <th>Person Responsible</th>

                            </tr>
                            <tr>
                                <td><input type="text" name="formAp" value="<?php echo $formAp; ?>" /></td>
                                <td><input type="text" name="poster1" value="<?php echo $poster1; ?>" /></td>
                                <td><input type="text" name="poster2" value="<?php echo $poster2; ?>" /></td>
                                <td><input type="text" name="responsible" value="<?php echo $responsible; ?>" /></td>

                            </tr>

                        </table>
                        <input type="submit" style="margin-left:25%;" class="btn-custom" name="updateDTBQuantity" value="Update" />
                    </form>

                </div>
            </div>
        </div>






        <script>

            $(document).find("input.num-only").keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                        // Allow: Ctrl+A
                                (e.keyCode === 65 && e.ctrlKey === true) ||
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

            //==============================  block return key from submitting form ===============================
            document.onkeypress = function(e) {
                e = e || window.event;
                if (typeof e !== 'undefined') {
                    var tgt = e.target || e.srcElement;
                    if (typeof tgt !== 'undefined' && /input/i.test(tgt.nodeName))
                        return (typeof e.keyCode !== 'undefined') ? e.keyCode !== 13 : true;
                }
                console.log("enter Block workin...");
            };



        </script>