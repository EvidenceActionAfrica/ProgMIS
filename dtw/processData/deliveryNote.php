<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once("../includes/logTracker.php");
$M_module =5;
ob_start();
$level = $_SESSION['level'];
$testdata = 'testdata';
$tabActive = 'tab1';

if ($_GET["tabActive"]) {
  $tabActive = "tab" . $_GET["tabActive"];
}
$updateResult = "";
$rowCount = 5;
// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_dnote = $row['priv_dnote'];
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


  <body onkeyup="calculateTotalAmount();">
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?>
      </div>
    </div>

    <?php
    $cmdUpdate = isset($_POST["updateRecord"]) ? mysql_real_escape_string($_POST["updateRecord"]) : "";
    if ($cmdUpdate) {
      $tabActive = "tab3";
      header("Location:deliveryNote.php?tabActive=2"); //The Get Requests interfee with adding delivery notes
    }
    $customerNameAddress = isset($_POST["customerNameAddress"]) ? mysql_real_escape_string($_POST["customerNameAddress"]) : "";
    $customerRemarks = isset($_POST["customerRemarks"]) ? trim($_POST["customerRemarks"]) : "";
    $receivingOfficer = isset($_POST["receivingOfficer"]) ? mysql_real_escape_string($_POST["receivingOfficer"]) : "";
    $receivingdate = isset($_POST["receivingdate"]) ? mysql_real_escape_string($_POST["receivingdate"]) : "";
    $district = isset($_POST["district"]) ? mysql_real_escape_string($_POST["district"]) : "";
    $county = isset($_POST["county"]) ? mysql_real_escape_string($_POST["county"]) : "";
    
    $Customerordernumber = isset($_POST["Customerordernumber"]) ? mysql_real_escape_string($_POST["Customerordernumber"]) : "";
    
    $dateSaved = date("Y-m-d");
    $specialNotes = isset($_POST["specialNotes"]) ? trim($_POST["specialNotes"]) : "";
    $warehouse = isset($_POST["warehouse"]) ? mysql_real_escape_string($_POST["warehouse"]) : "";
    $deliveryNoteId = "";

    if (isset($_POST['submitSaveNew'])) {

      $sql = "INSERT INTO `drugs_delivery_note`(`customer_name_address`, `customer_remarks`, `receiving_officer`, `receiving_date`, `warehouse`, `county`, `district`, `date_saved`, `special_notes`, `customer_orderno`)";
      $sql.="	VALUES ('$customerNameAddress','$customerRemarks','$receivingOfficer','$receivingdate','$warehouse','$county','$district','$dateSaved','$specialNotes','$Customerordernumber')";

      $resultNote = mysql_query($sql) or die(mysql_error());
      $idFind = "Select * from drugs_delivery_note ORDER BY delivery_note_id DESC";
      $idResult = mysql_query($idFind) or die(mysql_error());
      //	echo $idFind;

      while ($key = mysql_fetch_assoc($idResult)) {

        $deliveryNoteId = $key["delivery_note_id"];
        break;
      }
      //	echo $;
      $append = 1;

      while ($_POST["itemCode" . $append] != null) {
        $itemCode = isset($_POST["itemCode" . $append]) ? mysql_real_escape_string($_POST["itemCode" . $append]) : "";
        $drugDescription = isset($_POST["drugDescription" . $append]) ? mysql_real_escape_string($_POST["drugDescription" . $append]) : "";
        $units = isset($_POST["units" . $append]) ? mysql_real_escape_string($_POST["units" . $append]) : "";
        $batchNo = isset($_POST["batchNo" . $append]) ? mysql_real_escape_string($_POST["batchNo" . $append]) : "";
        $expiryDate = isset($_POST["expiryDate" . $append]) ? mysql_real_escape_string($_POST["expiryDate" . $append]) : "";
        $qtyOrdered = isset($_POST["qtyOrdered" . $append]) ? mysql_real_escape_string($_POST["qtyOrdered" . $append]) : "";
        $qtyIssued = isset($_POST["qtyIssued" . $append]) ? mysql_real_escape_string($_POST["qtyIssued" . $append]) : "";
        $unitPrice = isset($_POST["unitPrice" . $append]) ? mysql_real_escape_string($_POST["unitPrice" . $append]) : "";
        $totalPrice = $unitPrice * $qtyIssued;


        $sql = "INSERT INTO `drugs_delivery_desc`(`item_code`, `description`, `units`, `batchNo`, `expiry_date`, `quantity_ordered`, `quantity_issued`,`unit_price`, `total_price`, `delivery_note_id`)";
        $sql.="VALUES('$itemCode','$drugDescription','$units','$batchNo','$expiryDate','$qtyOrdered','$qtyIssued','$unitPrice','$totalPrice','$deliveryNoteId')";
        // echo $sql . "<br/>";
        // exit();
        $DrugDelivery = mysql_query($sql) or die(mysql_error());
        $append+=1;
      }
      $tabActive = "tab2";
          $action="Delivery Note Added";
     $description=" A new Delivery note for the customer Name & address ".$customerNameAddress." was added";
     $ArrayData = array($M_module, $action, $description);
     quickFuncLog($ArrayData);
    }
    if (isset($_GET["deleteId"])) {
      $tabActive = "tab2";
      $deliveryNoteId = $_GET["deleteId"];
      $sql='SELECT * from drugs_delivery_note WHERE delivery_note_id='.$deliveryNoteId;
      $result=mysql_query($sql)or die("Error Deleting".mysql_error());
      while($row=mysql_fetch_array($result)){
        $customerNameAddress=$row['customer_name_address'];
      }
      $action="Delivery Note Deleted";
     $description=" A Delivery note for the customer Name & address ".$customerNameAddress." was deleted";
     $ArrayData = array($M_module, $action, $description);
     quickFuncLog($ArrayData);


      $sql = "Delete from drugs_delivery_note where delivery_note_id='$deliveryNoteId'";
      //echo $sql;
      $results = mysql_query($sql) or die("Error Deleting");
      $sql = "DELETE from drugs_delivery_desc where delivery_note_id='$deliveryNoteId'";
      //echo $sql;
      $resultsB = mysql_query($sql) or die("Error Deleting");
    }
    ?>

    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-Drugs.php");
        ?>
      </div>
      <div class="contentBody" >



        <div class="tabbable" >
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Add New Delivery Note</a></li>
            <li><a href="#tab2" data-toggle="tab">View Delivery Note</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
              <center> <h2>Add New Delivery Note</h2></center>
              <form method="POST">
                <center>
                  <table border="0"cellpadding="2px" cellspacing="0" width="100%">
                    <thead>
                      <tr><input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <td align="right" style="width:4%;">County</td>
                        <td>
                          <select name="county"  class="input_select_p compact" onchange="submitForm();">
                            <option value=''<?php if ($county == '') echo 'selected'; ?> >Select County</option>
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
                        <td align="right">Delivery Note No.</td><td><input type="text" disabled name="" class="input_select_p compact" value=""/></td>



                      </tr>
                      <tr>
                        <td align="right" style="width:20%;">Sub County</td>
                        <td>
                          <select name="district" class="input_select_p compact"  >
                            <option class="input_select_p compact"  value=''<?php if ($district_name == '') echo 'selected'; ?> ></option>
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
                        </td>
                        <td align="right">Receiving Date</td>
                        <td><input type="text" name="receivingdate" class="input_select_p compact datepicker" value="" /></td>
                        <input type="submit" class='btn-filter' style="width: 98%;display:none;" id="btnSearchSubmit" value="Search" name="search_table"  />
                      </tr>
                      <tr>

                        <td align="right">Customer Name & Address</td>
                        <td><textarea style=" width: 55%" style=""name="customerNameAddress" class="input_select_p compact" ></textarea></td>
                        <td align="right">Current Date</td><td><input type="text"  id="datepicker" name="dateSaved" class="input_textbox_p compact" value="<?php echo date('Y-m-d'); ?>" readonly/></td>


                      </tr>
                      <tr><td align="right">Receiving Officer</td><td><input style=" width: 55%"type="text" name="receivingOfficer" class="input_select_p compact" value=""/></td>
                        <td align="right">Customer order number</td><td><input type="text" name="Customerordernumber" class="input_select_p compact" value=""/></td>

                      </tr>

                      <tr>
                        <td align="right">Customer Remarks</td>
                        <td><textarea style=" width: 55%"name="customerRemarks" class="input_select_p compact" rows="1"></textarea></td>
                        <td align="right">Warehouse</td><td><input type="text" name="warehouse"  class="input_select_p compact" value=""/></td>
                      </tr>
                    </thead>
                  </table>

                  <table width="" border="2" align="center" cellpadding="0" >
                    <thead>
                      <tr style="background-color: silver;">
                        <td colspan="10" style="padding: 5px;"><b>Drug Planning Assumptions</b></td>
                      </tr>
                      <tr>
                        <td align="center"> <b></b> </td>
                        <td align="left"> <b>Item Code </b> </td>
                        <td align="center" style=""> <b>Drug Description </b> </td>
                        <td align="center"> <b>Units of issue </b> </td>
                        <td align="center"style=""> <b>Batch No.</b> </td>
                        <td align="center"style=""> <b>Expiry Date</b> </td>
                        <td align="center"style=""> <b>Qty<br/>Ordered</b> </td>
                        <td align="center"style=""> <b>Qty<br/>Issued</b> </td>
                        <td align="center"style=""> <b>Unit Price</b> </td>
                        <td align="center"style=""> <b>Total Price</b> </td>
                      </tr>
                      <tr>
                        <td align="center" width="">1</td>
                        <td align="center"><input type="text"  name="itemCode1" id="itemCode1" onKeyUp="isBlank(this.id);"  style="width: 75px" /></td>
                        <td align="center"><input type="text"  name="drugDescription1" id="drugDescription" onKeyUp="isBlank(this.id);"  style="width: 185px" value=""/></td>
                        <td align="center"><input type="text"  name="units1" id="units1" onKeyUp="isBlank(this.id);" class="txt-input-table-center" value=""style="width: 95px" /></td>
                        <td align="center"><input type="text"  name="batchNo1" id="batchNo1" onKeyUp="isBlank(this.id);" class="txt-input-table-center" value="" style="width: 75px"/></td>
                        <td align="center"><input type="text"  name="expiryDate1" class="datepicker" value="" style="width: 85px"/></td>
                        <td align="center"><input type="text"  name="qtyOrdered1" id="qtyOrdered1" onKeyUp="isBlank(this.id);" class="txt-input-table-center" value=""style="width: 85px" /></td>
                        <td align="center"><input type="text"  name="qtyIssued1" id="qtyIssued1" onKeyUp="isBlank(this.id);" class="txt-input-table-center" value="" style="width: 75px"/></td>
                        <td align="center"><input type="text"  name="unitPrice1" id="unitPrice1" onKeyUp="isBlank(this.id);" class="txt-input-table-center" value="" style="width: 105px"/></td>
                        <td align="center"><input type="text"  name="totalPrice1" id="totalPrice1" onKeyUp="isBlank(this.id);" class="txt-input-table-center" value=""style="width: 105px" /></td>
                      </tr>
                      <tr>
                        <td align="center">2</td>
                        <td align="center" ><input  type="text"  name="itemCode2"  style="width: 75px"  /></td>
                        <td align="center" ><input type="text"  name="drugDescription2" style="width: 185px" /></td>
                        <td align="center" ><input type="text"  name="units2"        style="width: 95px"    /></td>
                        <td align="center"  ><input type="text"  name="batchNo2"     style="width: 75px"   /></td>
                        <td align="center" ><input type="text"  name="expiryDate2"     style="width: 85px"  class="datepicker"/></td>
                        <td align="center" ><input type="text"  name="qtyOrdered2"     style="width: 85px"  /></td>
                        <td align="center" ><input type="text"  name="qtyIssued2"      style="width: 75px"  /></td>
                        <td align="center" ><input type="text"  name="unitPrice2"     style="width: 105px"   /></td>
                        <td align="center" ><input type="text"  name="totalPrice2"    style="width: 105px"    /></td>
                      </tr>
                      <tr>
                        <td align="center">3</td>
                        <td align="center" ><input type="text"  name="itemCode3"      style="width: 75px"  /></td>
                        <td align="center" ><input type="text"  name="drugDescription3" style="width: 185px"/></td>
                        <td align="center" ><input type="text"  name="units3"        style="width: 95px"   /></td>
                        <td align="center" ><input type="text"  name="batchNo3"      style="width: 75px"  /></td>
                        <td align="center" ><input type="text"  name="expiryDate3" class="datepicker"   style="width: 85px"   /></td>
                        <td align="center" ><input type="text"  name="qtyOrdered3"     style="width: 85px" /></td>
                        <td align="center" ><input type="text"  name="qtyIssued3"    style="width: 75px"    /></td>
                        <td align="center" ><input type="text"  name="unitPrice3"     style="width: 105px"  /></td>
                        <td align="center" ><input type="text"  name="totalPrice3"    style="width: 105px"   /></td>
                      </tr>
                      <tr>
                        <td align="center">4</td>
                        <td align="center" ><input type="text"  name="itemCode4"   style="width: 75px"     /></td>
                        <td align="center" ><input type="text"  name="drugDescription4" style="width: 185px"/></td>
                        <td align="center" ><input type="text"  name="units4"         style="width: 95px"   /></td>
                        <td align="center" ><input type="text"  name="batchNo4"     style="width: 75px"   /></td>
                        <td align="center" ><input type="text"  name="expiryDate4" class="datepicker"   style="width: 85px"   /></td>
                        <td align="center" ><input type="text"  name="qtyOrdered4"     style="width: 85px" /></td>
                        <td align="center" ><input type="text"  name="qtyIssued4"      style="width: 75px" /></td>
                        <td align="center" ><input type="text"  name="unitPrice4"     style="width: 105px"  /></td>
                        <td align="center" ><input type="text"  name="totalPrice4"    style="width: 105px"   /></td>
                      </tr>
                      <tr>
                        <td align="center">5</td>
                        <td align="center" ><input type="text"  name="itemCode5"     style="width: 75px"  /></td>
                        <td align="center" ><input type="text"  name="drugDescription5" style="width: 185px"/></td>
                        <td align="center" ><input type="text"  name="units5"          style="width: 95px" /></td>
                        <td align="center" ><input type="text"  name="batchNo5"      style="width: 75px" /></td>
                        <td align="center" ><input type="text"  name="expiryDate5" class="datepicker"  style="width: 85px"   /></td>
                        <td align="center" ><input type="text"  name="qtyOrdered5"     style="width: 85px" /></td>
                        <td align="center" ><input type="text"  name="qtyIssued5"      style="width: 75px " /></td>
                        <td align="center" ><input type="text"  name="unitPrice5"  style="width: 105px" /></td>
                        <td align="center" ><input type="text"  name="totalPrice5"   style="width: 105px"  /></td>
                      </tr>
                      <?php
                      if (isset($_POST["rowCount"])) {

                        $rows = $_POST["rowCount"];

                        $max = $rows + $rowCount;
                        $count = $max - $rowCount;
                        while ($count > 0) {
                          $rowCount+=1;
                          echo "<tr>";
                          echo "<td align=\"center\">$rowCount</td>";
                          echo "<td align=\"center\" ><input type=\"text\"   style=\"width: 75px\" name=\"itemCode$rowCount\"/></td>";
                          echo "<td align=\"center\" ><input type=\"text\"   style=\"width: 185px\"name=\"drugDescription$rowCount\" /></td>";
                          echo "<td align=\"center\" ><input type=\"text\"   style=\"width: 95px\"name=\"units$rowCount\" /></td>";
                          echo "<td align=\"center\" ><input type=\"text\"   style=\"width: 75px\"name=\"batchNo$rowCount\" /></td>";
                          echo "<td align=\"center\" ><input type=\"text\"   style=\"width: 85px\"name=\"expiryDate$rowCount\" class=\"datepicker\"/></td>";
                          echo "<td align=\"center\" ><input type=\"text\"  style=\"width: 85px\" name=\"qtyOrdered$rowCount\"/></td>";
                          echo "<td align=\"center\" ><input type=\"text\"   style=\"width: 75px\"name=\"qtyIssued$rowCount\" /></td>";
                          echo "<td align=\"center\" ><input type=\"text\"   style=\"width: 105px\"name=\"unitPrice$rowCount\" /></td>";
                          echo "<td align=\"center\" ><input type=\"text\"   style=\"width: 105px\"name=\"totalPrice$rowCount\"/></td>";
                          echo "</tr>";
                          --$count;
                        }
                      }
                      ?>
                    </thead>
                  </table>

                  <div class="vclear"></div>
                </center>

                <br/>

                <div style="margin-left: 10%">
                  Add
                  <select style="width:5%"id="rowCount" name="rowCount" class="input_select_p compact"  onchange="postRows();">
                    <option selected="selected" value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                  Rows <input style="display:none;width:20%" type="submit" name="addRow" id="addRow" value="ADD Row" />
                  <br/>
                  <br/>
                  <b>Special Notes </b><br/>
                  <textarea style="width:50%;max-width: 80%;" id="specialNotes" name="specialNotes" class="input_select_p compact"></textarea>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                  <?php if ($priv_dnote >= 2) { ?>
                    <input align="center"type="submit" name="submitSaveNew" value="Save Delivery Note" class="btn-custom"/>
                  <?php } ?>
                </div>

                <div class="vclear"></div>
                <br/>
              </form>
              <p></p>
            </div>
            <!--tab 2 - view delivery note-->
            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
              <style>
                table tbody tr td a{
                  text-decoration:none;
                  color:#000000;
                  width:100%;
                }
              </style><br/><br/>
              <!--filter box-->
              <form action="#">
                <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
                <b style="margin-left:20%;width: 100px; font-size:1.5em;">Previous Delivery Notes</b>
              </form>
              <br/><br/>

              <table style="width:100%; overflow-x: visible; overflow-y: scroll; float: left;" width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                <thead>
                  <tr style="border: 1px solid #B4B5B0;">
                    <th align="Left" width="10%">County</th>

                    <th align="center" width="15%">Sub County</th>
                    <th align="center" width="15%">Customer Name & Address</th>
                    <th align="center" width="15%">Receiving Officer</th>
                    <th align="center" width="15%">Receiving Date</th>
                    <?php if ($priv_dnote >= 2) { ?>
                    <?php } if ($priv_dnote >= 4) { ?>
                      <th align="center" width="10%">Del</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $sql = "SELECT * FROM drugs_delivery_note ";

                  if (isset($_POST["find"])) {
                    $search = filter_input(INPUT_POST, "search");

                    $sql.=" where customer_name_address like '%$search%' or receiving_officer like '%$search%'";
                    $sql.=" or delivery_vehicle like '%$search%' or date_saved like '%$search%' or delivery_note_id like '%$search%'";
                  }


                  $sql.=" ORDER by county,district ASC";
                  $result_set = mysql_query($sql);

                  while ($row = mysql_fetch_array($result_set)) {
                    $customerNameAddress = $row["customer_name_address"];
                    $customerRemarks = $row["customer_remarks"];
                    $receivingOfficer = $row["receiving_officer"];
                    $receivingdate = $row["receiving_date"];
                    $district = $row["district"];
                    $county = $row["county"];
                    $dateSaved = $row["date_saved"];
                    $specialNotes = trim($row["special_notes"]);
                    $id = $row['id'];

                    $warehouse = $row["warehouse"];
                    $deliveryNoteId = $row["delivery_note_id"];
                    $link = "deliveryNote.php?deliveryNoteId=$deliveryNoteId&tabActive=3";
                    ?>  <tr style="border-bottom: 1px solid #B4B5B0;">
                      <td align="left" width="10%"> <?php echo "<a href=$link>" . $county . "</a>"; ?>  </td>

                      <td align="center" width="15%"> <?php echo "<a href=$link>" . $district . "</a>"; ?> </td>
                      <td align="center" width="15%"> <?php echo "<a href=$link>" . $customerNameAddress . "</a>"; ?> </td>


                      <td align="center" width="15%"> <?php echo "<a href=$link>" . $receivingOfficer . "</a>"; ?> </td>
                      <td align="center" width="15%"> <?php echo "<a href=$link>" . $receivingdate . "</a>"; ?>  </td>
                      <?php if ($priv_dnote >= 2) { ?>

                      <?php } ?>
                      <!--
                      <td align="center" width="40px"><a href="javascript:void(0)" onclick="loadRecordN('load',<?php //echo $;                                   ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                      <td align="center" width="40px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $deliveryNoteId; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                      !-->
                      <?php if ($priv_dnote >= 4) { ?>
                        <td align="center" width="10%"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $deliveryNoteId; ?>)'><img src="../images/icons/delete.png" height="20px"/></a></td>
                      <?php } ?>
                    </tr>
                  </tbody>
                <?php } ?>
              </table>

            </div>

            <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
              <div>
                <?php
                if ($cmdUpdate) {

                  $deliveryNoteId = isset($_GET["deliveryNoteId"]) ? $_GET["deliveryNoteId"] : "";
                  $cmdUpdate = isset($_POST["updateRecord"]) ? mysql_real_escape_string($_POST["updateRecord"]) : "";
                  $customerNameAddress = isset($_POST["customerNameAddress"]) ? mysql_real_escape_string($_POST["customerNameAddress"]) : "";
                  $customerRemarks = isset($_POST["customerRemarks"]) ? trim($_POST["customerRemarks"]) : "";
                  $receivingOfficer = isset($_POST["receivingOfficer"]) ? mysql_real_escape_string($_POST["receivingOfficer"]) : "";
                  $receivingdate = isset($_POST["receivingdate"]) ? mysql_real_escape_string($_POST["receivingdate"]) : "";
                  $district = isset($_POST["district"]) ? mysql_real_escape_string($_POST["district"]) : "";
                  $county = isset($_POST["county"]) ? mysql_real_escape_string($_POST["county"]) : "";
                  $dateSaved = date("Y-m-d");
                  $specialNotes = isset($_POST["specialNotes"]) ? mysql_real_escape_string($_POST["specialNotes"]) : "";
                  $warehouse = isset($_POST["warehouse"]) ? mysql_real_escape_string($_POST["warehouse"]) : "";

                  $sql = "UPDATE `drugs_delivery_note` SET `customer_name_address`='$customerNameAddress',`customer_remarks`='$customerRemarks',";
                  $sql.="`receiving_officer`='$receivingOfficer',`receiving_date`='$receivingdate',`warehouse`='$warehouse',`county`='$county',"
                          . "`district`='$district',`date_saved`='$dateSaved',`special_notes`='$specialNotes' WHERE `delivery_note_id`='$deliveryNoteId'";
                  $updateResult = "<h2 style='text-align:center;background-color:#bada66;' >Record Updated</h2>";
                  //    echo $sql;
                  $resultSet = mysql_query($sql);

                  $append = 1;
                  $query = "select item_id from drugs_delivery_desc where delivery_note_id='$deliveryNoteId'";
                  //echo $query;

                  $itemIdResult = mysql_query($query);
                  //We now need to take the result set and extract the array of itemids for the drugs desc
                  $item_data = array();
                  //$itemIdArray=mysql_fetch_array();
                  $itemcount = 0;
                  while ($row = mysql_fetch_assoc($itemIdResult)) {
                    $item_data[$itemcount] = $row['item_id'];
                    ++$itemcount;
                  }
                  //    $updateResult=var_dump($item_data);
                  //  $updateResult.=$_POST["itemCode".$append];

                  while ($_POST["itemCode" . $append] != null) {
                    $count = $append - 1; //For the itemId array.WARNING:Do not touch
                    //There are two possiblities with this update
                    //1. It is simply an update where the item ids will just confirm the updates in the where portion.
                    //For the update the $append supports the update loop by changing the variables from e.g itemcode1 to itemcode2
                    //as the names of the tables were generated in that way.After getting the post variable with the append
                    //it is immediately assigned to another uiversal variable representing the variables of that type e.g.post variables itemcode1,itemcode2
                    //will be represented by $itemcode.Hope u get it
                    //2. if there is no item id to be updated meaning the current record is to be inserted not updated so..check the if statement below..


                    $itemCode = isset($_POST["itemCode" . $append]) ? mysql_real_escape_string($_POST["itemCode" . $append]) : "";
                    $drugDescription = isset($_POST["drugDescription" . $append]) ? mysql_real_escape_string($_POST["drugDescription" . $append]) : "";
                    $units = isset($_POST["units" . $append]) ? mysql_real_escape_string($_POST["units" . $append]) : "";
                    $batchNo = isset($_POST["batchNo" . $append]) ? mysql_real_escape_string($_POST["batchNo" . $append]) : "";
                    $expiryDate = isset($_POST["expiryDate" . $append]) ? mysql_real_escape_string($_POST["expiryDate" . $append]) : "";
                    $qtyOrdered = isset($_POST["qtyOrdered" . $append]) ? mysql_real_escape_string($_POST["qtyOrdered" . $append]) : "";
                    $qtyIssued = isset($_POST["qtyIssued" . $append]) ? mysql_real_escape_string($_POST["qtyIssued" . $append]) : "";
                    $unitPrice = isset($_POST["unitPrice" . $append]) ? mysql_real_escape_string($_POST["unitPrice" . $append]) : "";
                    $totalPrice = $unitPrice * $qtyIssued;
                    //echo "<h1>".$count."</h1>";


                    if ($item_data . length <= $item_data[$count]) {
                      $sql2 = "INSERT INTO `drugs_delivery_desc`(`item_code`, `description`, `units`, `batchNo`, `expiry_date`, `quantity_ordered`, `quantity_issued`,`unit_price`, `total_price`, `delivery_note_id`)";
                      $sql2.="VALUES('$itemCode','$drugDescription','$units','$batchNo','$expiryDate','$qtyOrdered','$qtyIssued','$unitPrice','$totalPrice','$')";
                      //   echo $sql."<br/>";
                    } else {
                      $sql2 = "UPDATE `drugs_delivery_desc` SET `item_code`='$itemCode',";
                      $sql2.="`description`='$drugDescription',`units`='$units',`batchNo`='$batchNo',`expiry_date`='$expiryDate',";
                      $sql2.="`quantity_ordered`='$qtyOrdered',`quantity_issued`='$qtyIssued',`unit_price`='$unitPrice',";
                      $sql2.="`total_price`='$totalPrice' WHERE `item_id`='{$item_data[$count]}'";
                    }


                    $DrugDelivery = mysql_query($sql2) or die(mysql_error());
                    $append+=1;
                  }

                  $_POST = "";
                  $tabActive = "tab2";
                   $action="Delivery Note UPDATED";
                   $description=" A new Delivery note for the customer Name & address ".$customerNameAddress." was updated";
                   $ArrayData = array($M_module, $action, $description);
                   quickFuncLog($ArrayData);
                  header("Location:deliveryNote.php"); //The Get Requests interfee with adding delivery notes
                }
                if ($deliveryNoteId) {
                  $deliveryNoteId = $_GET["deliveryNoteId"];
                  $_GET = "";
                  $sql = "SELECT * FROM drugs_delivery_note where delivery_note_id='$deliveryNoteId'";
                  //echo $sql;
                  $result_set = mysql_query($sql);
                  $append = 1;
                  while ($row = mysql_fetch_array($result_set)) {
                    $customerNameAddress = $row["customer_name_address"];
                    $customerRemarks = $row["customer_remarks"];
                    $receivingOfficer = $row["receiving_officer"];
                    $receivingdate = $row["receiving_date"];
                    $district = $row["district"];
                    $county = $row["county"];
                    $dateSaved = $row["date_saved"];
                    $specialNotes = $row["special_notes"];
                     $Customerordernumber=$row["customer_orderno"];
                    $warehouse = $row["warehouse"];
                    $deliveryNoteId = $row["delivery_note_id"];
                  }
                }
                ?>
                <form method="post">

                  <center>
                    <table>

                      <!--<b style="text-align: center; margin-top: 0px; font-size: 15px">Delivery Note</b>-->
                      <!--<h1 class="form-title">Delivery Note</h1>-->
                      <!-- table begin  =============-->
                      <tr><thead>
                          <td colspan='3'>


                            <?php echo $updateResult; ?>

                            <center>  <h2>Edit Delivery Note</h2></center>
                          </td></thead>
                      </tr>
                      <thead>
                        <tr>
                          <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                          <td align="right" style="width:4%;">County</td>
                          <td>
                            <select name="county"  style="width:58%;" class="input_select_p compact" >

                              <option value=''<?php if ($county == '') echo 'selected'; ?> >Select County</option>

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
                          <td align="right">Delivery Note No.</td><td><input type="text" disabled name="" class="input_select_p compact" value="<?php echo $deliveryNoteId; ?>"/></td>

                        </tr>
                        <tr>
                          <td align="right" style="width:20%;">Sub County</td>
                          <td>
                            <select style="width:58%;" name="district"  class="input_select_p compact"  >
                              <?php if ($district !== "") { ?>
                                <option value='<?php echo $district; ?>' selected> <?php echo $district; ?></option>
                              <?php } else { ?>
                                <option class="input_select_p compact"  value=''<?php if ($district_name == '') echo 'selected'; ?> ></option>
                              <?php } ?>
                              <?php
                              $sql = "SELECT * FROM districts ORDER BY district_name ASC";
                              $result = mysql_query($sql);
                              while ($rows = mysql_fetch_array($result)) { //loop table rows
                                ?>
                                <option value="<?php echo $rows['district_name']; ?>"<?php
                                ?>><?php echo $rows['district_name']; ?></option>
                                      <?php } ?>
                            </select>
                          </td>
                          <td align="right">Receiving Date</td>
                          <td><input type="text" name="receivingdate" class="input_select_p compact datepicker" value="<?php echo $receivingdate; ?>"/></td>
                          <input type="submit" class='btn-filter' style="width: 98%; display:none;" id="btnSearchSubmit" value="Search" name="search_table"  />
                        </tr>
                        <tr>
                          <td align="right">Customer Name & Address</td>
                          <td><textarea style=" width: 55%" style=""name="customerNameAddress" class="input_select_p compact" ><?php echo $customerNameAddress; ?></textarea></td>
                          <td align="right">Current Date</td><td><input type="text"  id="datepicker" name="dateSaved" class="input_textbox_p compact" value="<?php echo date('Y-m-d'); ?>" readonly/></td>
                        </tr>
                        <tr>
                          <td align="right">Receiving Officer</td><td><input style=" width: 55%"type="text" name="receivingOfficer" class="input_select_p compact" value="<?php echo $receivingOfficer; ?>"/></td>
                          <td align="right">Customer order number</td><td><input type="text" style=" width: 72%"name="Customerordernumber" class="input_select_p compact" value="<?php echo $Customerordernumber; ?>"/></td>
                        </tr>
                        <tr>
                          <td align="right">Customer Remarks</td>
                          <td><textarea style=" width: 55%"name="customerRemarks" class="input_select_p compact" rows="1"><?php echo $customerRemarks; ?></textarea></td>
                          <td align="right">Warehouse</td><td><input type="text" name="warehouse"  class="input_select_p compact" value="<?php echo $warehouse; ?>"/></td>
                        </tr>
                      </thead>
                    </table>
                    <table border="2" align="center" cellpadding="0" style="width:100%; ">
                      <tr style="background-color: silver;">
                        <td colspan="10" style="padding: 5px;"><b>Drug Planning Assumptions</b></td>
                      </tr>
                      <tr>
                        <td align="center"> <b></b> </td>
                        <td align="left"> <b>Item Code </b> </td>
                        <td align="center" style=""> <b>Drug Description </b> </td>
                        <td align="center" style=""> <b>Units of issue </b> </td>
                        <td align="center" style=""> <b>Batch No.</b> </td>
                        <td align="center" style=""> <b>Expiry Date</b> </td>
                        <td align="center" style=""> <b>Qty<br/>Ordered</b> </td>
                        <td align="center" style=""> <b>Qty<br/>Issued</b> </td>
                        <td align="center" style=""> <b>Unit Price</b> </td>
                        <td align="center" style=""> <b>Total Price</b> </td>
                      </tr>
                      <?php
                      $sql = "select * from drugs_delivery_desc where delivery_note_id='$deliveryNoteId'";
                      //echo $sql;
                      $result_set = mysql_query($sql) or die("Error Connecting");
                      //For The Table

                      $append = 1;
                      $totalValue = 0;
                      while ($row = mysql_fetch_array($result_set)) {

                        $itemCode = trim($row["item_code"]);

                        $drugDescription = trim($row["description"]);

                        $units = trim($row["units"]);
                        $batchNo = trim($row["batchNo"]);
                        $expiryDate = trim($row["expiry_date"]);
                        $qtyOrdered = trim($row["quantity_ordered"]);
                        $qtyIssued = trim($row["quantity_issued"]);
                        $unitPrice = trim($row["unit_price"]);
                        $totalPrice = $unitPrice * $qtyIssued;
                        $totalValue+=$totalPrice;
                        ?>
                        <tr>
                          <td><?php echo $append; ?></td>
                          <td align="center"><b><input type="text" name="itemCode<?php echo $append; ?>" value="<?php echo $itemCode; ?>"/></b></td>

                          <td><input type="text" name="drugDescription<?php echo $append; ?>" style="width: 99%" value="<?php echo $drugDescription; ?>"/></td>
                          <td><input type="text" name="units<?php echo $append; ?>"  class="txt-input-table-center" value="<?php echo$units; ?>"/></td>
                          <td><input type="text" name="batchNo<?php echo $append; ?>"  class="txt-input-table-center" value="<?php echo$batchNo; ?>"/></td>
                          <td><input type="text" name="expiryDate<?php echo $append; ?>" class="datepicker" class="txt-input-table-center" value="<?php echo $expiryDate; ?>"/></td>
                          <td><input type="text" name="qtyOrdered<?php echo $append; ?>" class="txt-input-table-center" value="<?php echo $qtyOrdered; ?>"/></td>
                          <td><input type="text" name="qtyIssued<?php echo $append; ?>" class="txt-input-table-center" value="<?php echo $qtyIssued; ?>"/></td>
                          <td><input type="text" name="unitPrice<?php echo $append; ?>" class="txt-input-table-center" value="<?php echo $unitPrice; ?>"/></td>

                          <td><input type="text"  name="totalPrice<?php echo $append; ?>" class="txt-input-table-center" value="<?php echo$totalPrice; ?>"/></td>
                        </tr>
                        <?php
                        ++$append;
                      }

                      if (isset($_POST["rowModalCount"])) {
                        $append-=1; //I do this because the loop above which determines the next number to attach to our variable
                        //increments once after the last row
                        $rows = $_POST["rowModalCount"];

                        $max = $rows + $append;
                        $count = $max - $append;
                        while ($count > 0) {
                          $append+=1;
                          echo "<tr>";

                          echo "<td align=\"center\"><input type=\"text\"  name=\"itemCode$append\" value=\"\" /></td>";
                          echo "<td><input type=\"text\"  name=\"drugDescription$append\" value=\"\"/></td>";
                          echo "<td><input type=\"text\"  name=\"units$append\" value=\"\"/></td>";
                          echo "<td><input type=\"text\"  name=\"batchNo$append\" /></td>";
                          echo "<td><input type=\"text\"  name=\"expiryDate$append\" class=\"datepicker\"/></td>";
                          echo "<td><input type=\"text\"  name=\"qtyOrdered$append\"/></td>";
                          echo "<td><input type=\"text\"  name=\"qtyIssued$append\" /></td>";
                          echo "<td><input type=\"text\"  name=\"unitPrice$append\" /></td>";
                          echo "<td><input type=\"text\"  name=\"totalPrice$append\"/></td>";
                          echo "</tr>";
                          --$count;
                        }
                      }
                      ?>
                    </table>
                    <table>
                      <tr><td colspan="7"><h2 style="text-align:right; margin-right:5%;"><?php echo "<b>Total Bill </b></td></h2><td> <h2 style='font-weight:bolder;'>" . number_format($totalValue) . "</h2>"; ?></td>
                      </tr>
                    </table>
               
                    <!--Right div-->

                    <table style="float: right; width: 49%; margin-top:-180px; margin-left:500px;" border="0" cellpadding="0" cellspacing="0">
                     
                        <thead>
                             

                     
                   
 <b>Special Notes </b>
                  <textarea class="input_select_p compact" style="width:50%" id="specialNotes" name="specialNotes"><?php echo $specialNotes; ?> </textarea>
              <br/>
              <br/>
              <?php if ($priv_dnote >= 3) { ?>
               <input align="center" type="submit" class="btn btn-success"  name="updateRecord" value="Update Form" />
              <?php } ?>
               <br/>
                      </thead>
                    </table >
                    <div class="vclear"></div>







                    <!---
                          Add  <select id="rowCount" name="rowModalCount" onchange="postModalRows();">
                          <option selected="selected" value="0">0</option>
                          <option value="1">1</option>
                         <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>

                          </select>Rows <input style="display:none" type="submit" name="addModalRow" id="addModalRow" value="ADD Row" /><br/>

                    -->

                  </center>
                </form>

              </div>

            </div>
          </div>
        </div>






      </div>
    </div>

  </body>
</html>

<div class="clearFix"></div>
<!---------------- Footer ------------------------>
<!--<div class="footer">  </div>-->


<script>


    function submitForm() {
      //  document.getElementById('imgLoading').style.visibility = "visible";
      var selectButton = document.getElementById('btnSearchSubmit');
      selectButton.click();
    }

    $(function() {
      $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});
    });

    function show_confirm(deleteid) {
      if (confirm("Are you sure you want to delete?")) {
        location.replace('?deleteId=' + deleteid);
      } else {
        return false;
      }
    }
    function postRows() {
      var rowCount = document.getElementById("rowCount");
      var addRow = document.getElementById("addRow");
      addRow.click();

    }
    function postModalRows() {

      var addModalRow = document.getElementById("addModalRow");
      addModalRow.click();

    }
    //show previous records
    function loadRecordN(req, val) {

      console.log("the request is " + req + " and the value is" + val);
      if (req == "") {
        document.getElementById("divShowContent").innerHTML = "";
        return;
      }
      if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      }
      else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          document.getElementById("divDisplayAssumption").innerHTML = xmlhttp.responseText;
        }
      }
      xmlhttp.open("GET", "req=" + req + "&val=" + val, true);
      xmlhttp.send();
    }



</script>


<script src="../js/keydown_event"></script>
<?php
ob_end_flush();
 ?>
