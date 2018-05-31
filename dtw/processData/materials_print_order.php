<?php
ob_start();
date_default_timezone_set("Africa/Nairobi");

require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once("class.mathMaterials.php");
require_once("../email/class.phpmailer.php");
require_once("../includes/logTracker.php");
require_once('pdf/quotations.php');
$M_module =2;
 if(isset($_GET['viewQuote'])){
  vendorQuotation();
    $action="quote downloaded";
      $description=" A Vendor Quote has been downloaded";
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData);
      vendorQuotationCreate();
 }
 if(isset($_GET['viewCompleteQuote'])){
    completeVendorQuote();
      $action="Complete print order downloaded";
      $description=" A Complete print order has been downloaded";
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData);
     // vendorQuotationCreate();
 }
$testdata = 'testdata';
if(!isset($_GET['tabActive'])){
  $tabActive = 'tab6';  
}else{
    $tabActive=$_GET['tabActive'];
}

$updateResult = "";
$rowCount = 5;
$mailActive=0;
if (isset($_GET["mailTheVendor"])) {
      $action="quote emailed";
      $description=" A Vendor Quote has been emailed";
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData);
      vendorQuotationCreate();


}
if (isset($_GET["mailTheVendorCompleteQuote"])) {


      $action="the Complete print order emailed";
      $description=" A Complete print order has been emailed";
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData);  
      completeVendorQuoteCreate();
}
if (isset($_POST["sendEmail"])) {
            $sender = $_SESSION['staff_name'];
            $recipient_name = $_POST['vendor'];
            $recipient_email = $_POST['emailAddress'];
            $subject = $_POST['subject'];
            $email_body = $_POST['content'];

            //Clean Data
            $sender = addslashes(trim($sender));
            $recipient_name = addslashes(trim($recipient_name));
            $recipient_email = addslashes(trim($recipient_email));
            $subject = addslashes(trim($subject));
            $email_body = addslashes(trim($email_body));

            //send Email to client ============================================

            try {
                    $mail = new PHPMailer(true); //New instance, with exceptions enabled
                    $mail->IsSendmail();  // tell the class to use Sendmail
                    $mail->AddReplyTo($_SESSION['staff_email'], $_SESSION['staff_name'] );
                    $mail->From = "mail@evidenceaction.com"; //$staff_email;   //$sess_email;
                    $mail->FromName = $_SESSION['staff_name'] ; //"Evidence Action";
                    $to = $recipient_email;
                    $mail->AddAddress($to);
                    $mail->Subject = $subject; //"Scheduled Pre-Survey";
                    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                    $mail->WordWrap = 80; // set word wrap
                    $mail->IsHTML(true);
                    $mail->Body = $email_body;
                    $mail->AddAttachment('pdf/vendor_quote.pdf');
                    $mail->Send();
            } catch (phpmailerException $e) {
                echo $e->errorMessage();
            }
            $action="print order emailed";
            $description=" A Vendor Quote has been emailed to ".$recipient_email;
            $ArrayData = array($M_module, $action, $description);
            quickFuncLog($ArrayData);
   
}
if (isset($_POST["sendCompleteQuoteEmail"])) {
            $sender = $_SESSION['staff_name'];
            $recipient_name = $_POST['vendor'];
            $recipient_email = $_POST['emailAddress'];
            $subject = $_POST['subject'];
            $email_body = $_POST['content'];

            //Clean Data
            $sender = addslashes(trim($sender));
            $recipient_name = addslashes(trim($recipient_name));
            $recipient_email = addslashes(trim($recipient_email));
            $subject = addslashes(trim($subject));
            $email_body = addslashes(trim($email_body));

            //send Email to client ============================================

            try {
                    $mail = new PHPMailer(true); //New instance, with exceptions enabled
                    $mail->IsSendmail();  // tell the class to use Sendmail
                    $mail->AddReplyTo($_SESSION['staff_email'], $_SESSION['staff_name'] );
                    $mail->From = "mail@evidenceaction.com"; //$staff_email;   //$sess_email;
                    $mail->FromName = $_SESSION['staff_name'] ; //"Evidence Action";
                    $to = $recipient_email;
                    $mail->AddAddress($to);
                    $mail->Subject = $subject; //"Scheduled Pre-Survey";
                    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                    $mail->WordWrap = 80; // set word wrap
                    $mail->IsHTML(true);
                    $mail->Body = $email_body;
                    $mail->AddAttachment('pdf/Confirmed_vendor_quote.pdf');
                    $mail->Send();
            } catch (phpmailerException $e) {
                echo $e->errorMessage();
            }

            $action="The Complete Print Order emailed";
            $description=" A Complete Quote has been emailed to ".$recipient_email;
            $ArrayData = array($M_module, $action, $description);
            quickFuncLog($ArrayData);
   
}
if (isset($_GET["activeId"])) {
    $tabActive = 'tab7';
}
if (isset($_POST["savePrintOrder"])) {
    $tabActive = 'tab6';
}
//We need the active printlist's id so that we could perform crud operations below

$sql = "select id from materials_printlist_history where status=1";
$resultQ = mysqli_query($db_mysqli_connection,$sql);
while ($row = mysqli_fetch_assoc($resultQ)) {
    $printlistId = $row["id"];
}
mysqli_free_result($resultQ);
if (isset($_POST["unlockRecord"])) {
    $sql = "update materials_printlist_history set locked=0 where status=1";
    // echo $sql;
    mysqli_query($db_mysqli_connection,$sql);
        $action="The Complete Print Order has been updated";
    $description=" A Complete Quote has been updated";
    $ArrayData = array($M_module, $action, $description);
    quickFuncLog($ArrayData);
}
if (isset($_GET["deleteQuoteId"])) {
    $id = $_GET["deleteQuoteId"];
    $sql = "update materials_printlist_history set confirmed_quote=0 where id=" . $id;
    mysqli_query($db_mysqli_connection,$sql);
    
}
if (isset($_POST["saveRecord"])) {

    $id = 1;
    $tabActive = 'tab9';
//echo "<pre>";
// echo print_r($_POST);
// echo "</pre>";
    while ($_POST["materials" . $id] != null) {

        $print_order_unit_price = isset($_POST["materialsUnitPrice" . $id]) ? $_POST["materialsUnitPrice" . $id] : 0;
        $print_order_price = isset($_POST["materialsPrice" . $id]) ? $_POST["materialsPrice" . $id] : 0;
        $updatedQuantity = isset($_POST["materialsUpdatedQuantity" . $id]) ? $_POST["materialsUpdatedQuantity" . $id] : 0;

        $updatedUnitPrice = isset($_POST["materialsUpdatedUnitPrice" . $id]) ? $_POST["materialsUpdatedUnitPrice" . $id] : 0;
        $updatedPrice = isset($_POST["materialsUpdatedPrice" . $id]) ? $_POST["materialsUpdatedPrice" . $id] : 0;
        $updatedQuantity = isset($_POST["materialsUpdatedQuantity" . $id]) ? $_POST["materialsUpdatedQuantity" . $id] : 0;



        $sql = "UPDATE `materials_vendor_quote` SET `print_order_unit_price`='$print_order_unit_price',`print_order_price`='$print_order_price',";
        $sql.="`updated_print_order_quantity`='$updatedQuantity',`updated_print_order_unit_price`='$updatedUnitPrice',";
        $sql.="`updated_print_order_price`='$updatedPrice' WHERE `id`='$id'";

        $resultU = mysqli_query($db_mysqli_connection,$sql);
        //  echo $sql."<br/>";
        ++$id;
    }


//After updating the current vendor quote. we need to ensure that as we insert the data
    //into vendor quote history table that no other records sharing the same printlist id exist

    $sql = "DELETE FROM `materials_vendor_quote_history` WHERE printlist_id=" . $printlistId;
    $resultN = mysqli_query($db_mysqli_connection,$sql);


    //Now we perform an insert loop for the new records
    $id = 1;
      $sql = "INSERT INTO `materials_vendor_quote_history`(`materials`, `print_order_quantity`, `print_order_unit_price`,";
      $sql.=" `print_order_price`, `updated_print_order_quantity`, `updated_print_order_unit_price`, `updated_print_order_price`, `printlist_id`) VALUES";
       
    while ($_POST["materials" . $id] != null) {

        $materials = isset($_POST["materials" . $id]) ? $_POST["materials" . $id] : "";
        $quantity = isset($_POST["quantity" . $id]) ? $_POST["quantity" . $id] : 0;
        $print_order_unit_price = isset($_POST["materialsUnitPrice" . $id]) ? $_POST["materialsUnitPrice" . $id] : 0;
        $print_order_price = isset($_POST["materialsPrice" . $id]) ? $_POST["materialsPrice" . $id] : 0;
        $updatedQuantity = isset($_POST["materialsUpdatedQuantity" . $id]) ? $_POST["materialsUpdatedQuantity" . $id] : 0;
        $updatedUnitPrice = isset($_POST["materialsUpdatedUnitPrice" . $id]) ? $_POST["materialsUpdatedUnitPrice" . $id] : 0;
        $updatedPrice = isset($_POST["materialsUpdatedPrice" . $id]) ? $_POST["materialsUpdatedPrice" . $id] : 0;
        $updatedQuantity = isset($_POST["materialsUpdatedQuantity" . $id]) ? $_POST["materialsUpdatedQuantity" . $id] : 0;


       $sql.="  ('$materials','$quantity','$print_order_unit_price','$print_order_price','$updatedQuantity','$updatedUnitPrice','$updatedPrice','$printlistId'),";

        
        //  echo $sql."<br/>";
        ++$id;
    }
       $sql = rtrim($sql, ",");
       $resultU = mysqli_query($db_mysqli_connection,$sql);
     
//AFTER THE INSERT LOOP WE NEED TO UPDATE THE ACTIVE PRINTLIST AS HAVING A CONFIRMED QOUTE SO IT MAY APPEAR
    //ON THE CONFIRMED QUOTE HISTORY TAB FOR DOWNLOADING PURPOSES
    $sql = "update materials_printlist_history set confirmed_quote=1,locked=1 where status=1";
    mysqli_query($db_mysqli_connection,$sql);
    $action="The Complete Print Order has been updated";
    $description=" A Complete Quote has been updated";
    $ArrayData = array($M_module, $action, $description);
    quickFuncLog($ArrayData);
}
// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysqli_query($db_mysqli_connection,"SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysqli_fetch_assoc($resPriv)) {
    $priv_materials_edit = $row['priv_materials_edit'];
}
mysqli_free_result($resPriv);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
    <head>
        <title>Evidence Action</title>
        <link href="../css/tabs_css.css" rel="stylesheet" type="text/css"/>
        <?php require_once ("includes/meta-link-script.php"); ?>
        <script src="../js/tabs.js"></script>
        <link href="css/materials.css" rel="stylesheet" type="text/css"/>
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
            <div class="contentBody" >


                <div style="margin-left:0%;margin-top:0%;" class="alert alert-block">

                    Warning! &nbsp; This Form will only work with data from the active printlist/print order.
                </div>


                <div class="tabbable" >
                    <ul class="nav nav-tabs">

                        <li <?php if ($tabActive == 'tab6') echo "class='active'" ?>><a href="materials_print_order.php?tabActive=tab6" >Print Order</a></li>
                        <li <?php if ($tabActive == 'tab7') echo "class='active'" ?>><a href="materials_print_order.php?tabActive=tab7" >Print Order History</a></li>
                        <li <?php if ($tabActive == 'tab8') echo "class='active'" ?>><a href="materials_print_order.php?tabActive=tab8" >View Quote</a></li>
                        <li <?php if ($tabActive == 'tab9') echo "class='active'" ?>><a href="materials_print_order.php?tabActive=tab9" >Confirm Quote</a></li>
                        <li <?php if ($tabActive == 'tab10') echo "class='active'" ?>><a href="materials_print_order.php?tabActive=tab10" >Confirmed Vendor Quotes History</a></li>

                    </ul>
                    <div class="tab-content">

                     


                        <div class="tab-pane <?php if ($tabActive == 'tab6') echo 'active'; ?>" id="tab6">
                            <h2 style="text-align:center">Print Order</h2>
                            <p><?php 

                              if ($tabActive == 'tab6' && isset($_SESSION["district_selection"]) !=null){
                                 
                                  //  echo 'reading file...';
                                       require_once("materials_printlist_order.php");

                              }

                             ?></p>
                        </div>

                        <div class="tab-pane <?php if ($tabActive == 'tab7') echo 'active'; ?>" id="tab7">
                            <p><?php 

                              if($tabActive == 'tab7'){
                                 require_once("materials_printlist_order_history.php"); 
                              }
                            

                             ?></p>

                        </div>
                        <div class="tab-pane <?php if ($tabActive == 'tab8') echo 'active'; ?>" id="tab8">
                           <?php 
                            if ($tabActive == 'tab8'){  ?>
                                <div id="budget-form-header" >
                                    <?php
                                     //We check if the active printlist has a confirmed quote and that it is locked.
                                    //   If it does have a confirmed quote and lock the data below will not be displayed
                                    $sql = "Select * from materials_printlist_history where status=1 AND confirmed_quote=1 AND locked=1";
                                    $results = mysqli_query($db_mysqli_connection,$sql);
                                    while ($row = mysqli_fetch_assoc($results)) {
                                        $printlistId = $row["printlist_id"];
                                    }
                                    mysqli_free_result($results);
                                    $check = mysqli_affected_rows($db_mysqli_connection);
                                    if ($check < 1) {
                                        ?>
                                        <br/>
                                        <?php if ($priv_materials_edit >= 1) { ?>
                                            <a  class="btn btn-info" style="text-decoration:none;margin-top:5%;margin-left:10%;"  href="materials_print_order.php?viewQuote='activePreview'"><img src="../images/icons/view2.png" height="20px"/> &nbsp; View Pdf</a>
                                             <a  class="btn btn-info" style="text-decoration:none;margin-top:5%;"  href="materials_print_order.php?mailTheVendor=YES#sendQuote"><img src="../images/email.png" height="20px"/> &nbsp; Email To Vendor</a>

                                        <?php } ?>   
                                        <div style="margin-left:40%;">
                                            <img  src="../images/logo.png"/>
                                            <h2>Vendor Request Quotation</h2>
                                        </div>
                                        <table  class="table table-bordered table-condensed table-striped table-hover">
                                            <tr>
                                                <th>Material</th>
                                                <th>Print Order Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Print Order Price</th>
                                            </tr>
                                            <?php
                                            $sql = "select * from materials_printlist_history_data where printlist_id='" . $printlistId . "'";
                                            $resultA = mysqli_query($db_mysqli_connection,$sql);
                                            while ($row = mysqli_fetch_assoc($resultA)) {
                                                $materials = $row["material"];
                                                $quantity = $row["print_order_quantity"];
                                                ?>
                                                <tr><td><?php echo $materials; ?></td><td><?php echo $quantity; ?></td><td></td><td></td></tr>
                                                <?php
                                            }
                                            mysqli_free_result($resultA);
                                            ?> 


                                            <tr style="font-weight:bold;"><td>Total</td><td></td><td></td><td></td></tr>
                                            <tr style="font-weight:bold;"><td>Total+16% VAT</td><td></td><td></td><td></td></tr>
                                            <tr style="font-weight:bold;"><td>Plus County Meeting Prints</td><td></td><td></td><td></td></tr>
                                            <tr style="font-weight:bold;"><td>Plus VAT</td><td></td><td></td><td></td></tr>






                                        </table>   
                                        <?php
                                    } else {
                                        ?>
                                            <div style="background:#bada66;">
                                                <span id="h2info" style="font-size:1.3em;text-align:center;"> &nbsp;The Active Print list has a Confirmed Quote.<br/>Select Edit in the confirmed quote history to make changes to it.</span>
                                            </div>
                                       
                                        <?php
                                    }
                                    ?>
                                </div>
                            <?php } ?>


                        </div>

                        <div class="tab-pane <?php if ($tabActive == 'tab9') echo 'active'; ?>" id="tab9">
                            <?php
                            if ($tabActive == 'tab9'){
                            //We check if the active printlist has a confirmed quote and that it is locked.
                            //   If it does have a confirmed quote and lock the data below will not be displayed
                            $sql = "Select * from materials_printlist_history where status=1 AND confirmed_quote=1 AND locked=1";
                            $results = mysqli_query($db_mysqli_connection,$sql);
                            $check = mysqli_affected_rows($db_mysqli_connection);
                            mysqli_free_result($results);
                            if ($check < 1) {
                                ?>
                                <form method="post" >

                                    <div style="margin-left:40%;">
                                        <img  src="../images/logo.png"/>

                                        <h2>Vendor Request Quotation</h2>
                                    </div>
                                    <table  class="table-hover" style="border: none">
                                        <tr>
                                            <th align='center' width="3%">Id</th>
                                            <th align="left" width="20%">Material</th>
                                            <th align='center' width="10%">Print Order Quantity</th>
                                            <th align='center' width="10%">Unit Price</th>
                                            <th align='center' width="10%">Print Order Price</th>
                                            <th align='center' width="10%">Updated Print Order Quantity</th>
                                            <th align='center' width="10%">Updated Unit Price</th>
                                            <th align='center' width="10%">Updated Print Order Price</th>
                                            <th align='center' width="10%">Price Difference</th>
                                        </tr>
                                        <?php
                                        $sql = "select * from materials_vendor_quote_history where printlist_id='" . $printlistId . "'";
                                        $resultA = mysqli_query($db_mysqli_connection,$sql);
                                        $totalPrintOrderPrice = 0;
                                        $totalPrintOrderUpdatedPrice = 0;
                                        $append = 1;

                                        while ($row = mysqli_fetch_assoc($resultA)) {
                                            $materials = $row["materials"];
                                            $quantity = $row["print_order_quantity"];
                                            $unitPrice = $row["print_order_unit_price"];
                                            $price = $row["print_order_price"];
                                            $updatedQuantity = $row["updated_print_order_quantity"];
                                            $updatedUnitPrice = $row["updated_print_order_unit_price"];
                                            $updatedPrice = $row["updated_print_order_price"];
                                            $id = $append;
                                          
                                            ?>
                                            <tr>
                                                <td align='center' ><?php echo $id; ?></td>
                                                <td align='center' ><input type="text" class="num-only " style="text-align: left; border: none" name="materials<?php echo $id; ?>" value="<?php echo $materials; ?>" readonly/></td>
                                                <td align='center' ><input type="text" class="num-only txtCenter" name="quantity<?php echo $id; ?>" value="<?php echo $quantity; ?>" readonly/></td>
                                                <td align='center' ><input type="text" class="num-only txtCenter" name="<?php echo "materialsUnitPrice$id"; ?>" value="<?php echo $unitPrice; ?>" /></td>
                                                <td align='center' ><input type="text" class="num-only txtCenter" name="<?php echo "materialsPrice$id"; ?>" value="<?php echo $price; ?>" /></td>
                                                <td align='center' ><input type="text" class="num-only txtCenter" name="<?php echo "materialsUpdatedQuantity$id"; ?>" value="<?php echo $updatedQuantity; ?>" /></td>
                                                <td align='center' ><input type="text" class="num-only txtCenter" name="<?php echo "materialsUpdatedUnitPrice$id"; ?>" value="<?php echo $updatedUnitPrice; ?>" /></td>
                                                <td align='center' ><input type="text" class="num-only txtCenter" name="<?php echo "materialsUpdatedPrice$id"; ?>" value="<?php echo $updatedPrice; ?>" /></td>
                                                <td align='center' ><?php echo abs($price - $updatedPrice); ?></td>
                                            </tr>
                                            <?php
                                            $totalPrintOrderPrice+=$price;
                                            $totalPrintOrderUpdatedPrice+=$updatedPrice;
                                              ++$append;
                                        }
                                        mysqli_free_result($resultA);
                                        ?> 

                                        <tr style="font-weight:bold;"><td></td><td>Total</td><td></td><td></td><td style='text-align:center;'><?php echo $totalPrintOrderPrice ?></td><td></td><td></td><td style='text-align:center;'><?php echo $totalPrintOrderUpdatedPrice; ?></td><td></td></tr>
                                        <tr style="font-weight:bold;"><td></td><td>Total+16% VAT</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr style="font-weight:bold;"><td></td><td>Plus County Meeting Prints</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr style="font-weight:bold;"><td></td><td>Plus Coast</td><td><td></td></td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr style="font-weight:bold;"><td></td><td>Plus VAT</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>






                                    </table>     
                                    <?php if ($priv_materials_edit >= 2) { ?>
                                        <input type="submit" style="margin-left:40%;" class="btn-custom" name="saveRecord" value="Approve Quote" />    
                                    <?php } ?>
                                </form>

                                <?php
                            } else {
                                ?>
                                <div style="background:#bada66;">
                                    <span id="h2info" style="font-size:1.3em;"> &nbsp; The Active Printlist has a Confirmed Quote.<br/>Select Edit in the confirmed quote history to make changes to it.</span>
                                </div>
                        <?php
                            }
                        }
                            ?>

                        </div>
                        <div class="tab-pane <?php if ($tabActive == 'tab10') echo 'active'; ?>" id="tab10">
                        <?php 
                            if ($tabActive == 'tab10'){ ?>

                            <form method="post">
                                <?php
                                $sql = "select * from materials_printlist_history where confirmed_quote=1 ORDER BY id DESC";
                                $result = mysqli_query($db_mysqli_connection,$sql);
                                $num = mysqli_affected_rows($db_mysqli_connection);

                                if ($num >= 1) {
                                    ?>
                                     <div style="background:#bada66;">
                                            <span id="h2info" style="font-size:1.3em;text-align:center;"> &nbsp; <?php echo $updateResult; ?></span>
                                        </div>
                                    
                                    <table align="center" class="table table-bordered table-condensed  table-hover">
                                        <tr>
                                            <th>Print list Id</th>
                                            <th>Vendor Name</th>
                                            <th>Prepared By</th>
                                            <th>Time Stamp</th>
                                            <th>Active</th>
                                            <?php if ($priv_materials_edit >= 1) { ?>
                                                <th>View Qoute</th>
                                                <th>Email Quote</th>
                                            <?php }if ($priv_materials_edit >= 3) { ?>
                                                <th>Edit Quote</th>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {

                                            if ($row["status"] == 1) {
                                                $active = "YES";
                                                echo "<tr style='background:#bada66;'>";
                                            } else {
                                                $active = "NO";
                                                echo " <tr>";
                                            }
                                            $unixDate = $row["time_set"];
                                            $year = date('Y', $unixDate);
                                            $month = date('M', $unixDate);
                                            $day = date('d', $unixDate);
                                            $suffix = date('S', $unixDate);
                                            $hour = date('g', $unixDate);
                                            //   $min=date('i',$unixDate);
                                            $setTime = date('A', $unixDate);
                                            $dayWeek = date('l', $unixDate);
                                            $currentId = $row["status"];

                                            $date = $day . "<sup>" . $suffix . "</sup> " . $month . " " . $year . " -" . $hour . " " . $setTime . " " . $dayWeek;
                                            //   $date=$row["date"];
                                            ?>

                                            <td><?php echo $row["id"]; ?></td>

                                            <td><?php echo $row["vendor_name"]; ?></td>
                                            <td><?php echo $row["prepared_by"]; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $active; ?></td>
                                            <?php if ($priv_materials_edit >= 1) { ?>
                                                <td><a href="materials_print_order.php?viewCompleteQuote=<?php echo $row['id']; ?>"><img src="../images/icons/view2.png" height="20px"/></a></td>
                                                 <td><a href="materials_print_order.php?mailTheVendorCompleteQuote=YES#sendCompleteQuote"><img src="../images/email.png" height="20px"/></a></td>
                                            <?php }if ($priv_materials_edit >= 3) { ?>
                                                <td><?php if ($currentId == 1) { ?><a href="javascript:void(0)" onclick="show_details(<?php echo $row['id']; ?>)"><img src="../images/icons/edit2.png" height="20px"></a> <?php } ?></td>
                                            <?php } ?>
                                            </tr>
                                            <?php
                                        }
                                        mysqli_free_result($result);
                                    } else {
                                        ?>
                                         <div style="background:#bada66;">
                                            <span id="h2info" style="font-size:1.3em;text-align:center;"> &nbsp; Sorry! None of the Vendors have a Confirmed Quote..</span>
                                        </div>
                                          <?php
                                    }
                                    ?>

                                </table>
                                <input type="submit" id="unlockRecord" name="unlockRecord" value="unlock" style="display:none;" />
                            </form>
                        <?php } ?>
                        </div>
                    </div>

                </div>
                <div id="sendQuote" class="modalDialog">
                    <div  style="width:350px" >
                        <a href="materials_print_order.php" title="Close" class="close">X</a>
                        <!-- ================= -->
                        <?php 
                          if(isset($_POST["sendEmail"])){
                            echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>Quote Sent Successfully</h3>";
                           }
                        ?>
                        <h2 style="margin-left:35%;">Email Quote to Vendor</h2>
                        <form class="form" method="post"  >
                            <table>
                                <tr><td>Email Address</td><td><input type="text" name="emailAddress" required/></td></tr>
                                 <tr><td>Vendor Name</td><td><input type="text" name="vendor" required /></td></tr>
                                <tr><td>Subject</td><td><input type="text" name="subject" value="" required/></td></tr>
                                <tr><td>Content</td><td><textarea name="content"></textarea></td></tr>
                                <tr rowspan="2"></tr>
                                <tr><td></td><td> <input type="submit" class="btn-custom" name="sendEmail" value="Send" /></td>
                                    
                                </tr>
                            </table>
                        </form>


                    </div>

                    </div>
                   <div id="sendCompleteQuote" class="modalDialog">
                    <div  style="width:350px" >
                        <a href="materials_print_order.php" title="Close" class="close">X</a>
                        <!-- ================= -->
                        <?php 
                          if(isset($_POST["sendCompleteQuoteEmail"])){
                            echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>Quote Sent Successfully</h3>";
                           }
                        ?>
                        <h2 style="margin-left:35%;">Email Quote to Vendor</h2>
                        <form class="form" method="post"  >
                            <table>
                                <tr><td>Email Address</td><td><input type="text" name="emailAddress" required/></td></tr>
                                 <tr><td>Vendor Name</td><td><input type="text" name="vendor" required /></td></tr>
                                <tr><td>Subject</td><td><input type="text" name="subject" value="" required/></td></tr>
                                <tr><td>Content</td><td><textarea name="content"></textarea></td></tr>
                                <tr rowspan="2"></tr>
                                <tr><td></td><td> <input type="submit" class="btn-custom" name="sendCompleteQuoteEmail" value="Send" /></td>
                                    
                                </tr>
                            </table>
                        </form>


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


                    function openQuote(id) {

                        location.replace('?openQuote=' + id);

                    }
                    function show_confirm(deleteid) {
                        if (confirm("Are you sure you want to delete?")) {
                            location.replace('?tabActive=tab7&deleteId=' + deleteid);
                        } else {
                            return false;
                        }
                    }
                    function show_details(id) {
                        if (confirm("Are you sure you want to Edit the Active Quotation?")) {

                            var selectedButton = document.getElementById("unlockRecord");
                            selectedButton.click();

                        } else {
                            return false;
                        }
                    }
                    function setActive(id) {
                        if (confirm("Are you sure you want to Set This Vendor's Printlist As Active?")) {
                            location.replace('?activeId=' + id);
                        } else {
                            return false;
                        }
                    }
                </script>
<?php

mysqli_close($db_mysqli_connection);
ob_end_flush();
?>

