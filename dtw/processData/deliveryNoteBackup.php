<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
$testdata = 'testdata';
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
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php   require_once ("includes/menuNav.php");  ?>
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
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<link rel="stylesheet" href="/resources/demos/style.css">
		<script>
		$(function() {
		$( "#tabs" ).tabs();
		});
		 $(function() {
		$( "#datepicker" ).datepicker();
		});
		</script>
      <div class="contentBody">
		<div id="tabs">
				<ul>
				<li><a href=".tabs-1">Add New Delivery Note</a></li>
				<li><a href=".tabs-2">View Delivery Note</a></li>
	
				</ul>
        <?php
		
		$customerNameAddress=isset($_POST["customerNameAddress"])?$_POST["customerNameAddress"]:"";
		$customerNameRemarks=isset($_POST["customerNameRemarks"])?$_POST["customerNameRemarks"]:"";
		$receivingOfficer=isset($_POST["receivingOfficer"])?$_POST["receivingOfficer"]:"";
		$deliveryVehicle=isset($_POST["deliveryVehicle"])?$_POST["deliveryVehicle"]:"";
		$district=isset($_POST["district"])?$_POST["district"]:"";
		$county=isset($_POST["county"])?$_POST["county"]:"";
		$dateSaved=isset($_POST["dateSaved"])?$_POST["dateSaved"]:"";
		$specialNotes=isset($_POST["specialNotes"])?$_POST["specialNotes"]:"";
		$itemCode=isset($_POST["itemCode1"])?$_POST["itemCode1"]:""; 
		$warehouse=isset($_POST["warehouse"])?$_POST["warehouse"]:"";
		$deliveryNoteId="";

		
        if (isset($_POST['submitSaveNew'])) {
        
		$sql="INSERT INTO `drugs_delivery_note`(`customer_name_address`, `customer_remarks`, `receiving_officer`, `delivery_vehicle`, `warehouse`, `county`, `district`, `date_saved`, `special_notes`)";
		$sql.="	VALUES ('$customerNameAddress','$customernameRemarks','$receivingOfficer','$deliveryVehicle','$warehouse','$county','$district','$dateSaved','$specialNotes')";
		//echo $sql;
		$resultNote=mysql_query($sql) or die(mysql_error());
		$idFind="Select * from drugs_delivery_note ORDER BY delivery_note_id DESC";
		$idResult=mysql_query($idFind) or die(mysql_error());
	//	echo $idFind;
		
		while($key=mysql_fetch_assoc($idResult)){
			
			$deliveryNoteId=$key["delivery_note_id"];
		break;
		}
		echo $deliveryNoteId;
		$append=1;
		
			echo $item;
		
			
			while($_POST["itemCode".$append] !=null){
			
		$itemCode=isset($_POST["itemCode".$append])?$_POST["itemCode".$append]:"";       
        $drugDescription=isset($_POST["customerNameAddress".$append])?$_POST["customerNameAddress".$append]:"";
        $units=isset($_POST["units".$append])?$_POST["units".$append]:"";     
		$batchNo=isset($_POST["batchNo".$append])?$_POST["batchNo".$append]:"";    
        $expiryDate=isset($_POST["expiryDate".$append])?$_POST["expiryDate".$append]:"";     
        $qtyOrdered=isset($_POST["qtyOrdered".$append])?$_POST["qtyOrdered".$append]:"";      
        $qtyIssued=isset($_POST["qtyIssued".$append])?$_POST["qtyIssued".$append]:"";      
		$unitPrice=isset($_POST["unitPrice".$append])?$_POST["unitPrice".$append]:"";    
		$totalPrice=isset($_POST["totalPrice".$append])?$_POST["totalPrice".$append]:"";  

		
		$sql="INSERT INTO `drugs_delivery_desc`(`item_code`, `description`, `units`, `batchNo`, `expiry_date`, `quantity_ordered`, `quantity_issued`,`unit_price`, `total_price`, `delivery_note_id`)";
		$sql.="VALUES('$itemCode','$drugDescription','$units','$batchNo','$expiryDate','$qtyOrdered','$qtyIssued',
		,'$unitPrice','$totalPrice','$deliveryNote')";
		echo $sql."<br/>";
		$DrugDelivery=mysql_query($sql) or die(mysql_error()+"Really!");
		++$append;
		}
		
		}
		
		
        
        ?>
        <div class="tab-1" id="canvas" style="margin: 0 auto background:rgb(255,255,255);">

          <h1 style="text-align: center; margin-top: 0px; font-size: 22px">Delivery Note</h1>
          <!--<h1 class="form-title">Delivery Note</h1>-->
          <!-- table begin  =============-->
          <td style="width: 70%">
		  
            <div id="addNewDeliveryNote" style="width: 80%; margin: 0 auto">
              <form method="post">
				
			
                <div style="padding: 5px;">
                  <!--left div-->
                  <div style="float: left; width: 49%;">
                    <table border="0"  cellpadding="0" cellspacing="0">
                      <thead>
                        <tr>
                          <td>Customer Name & Address</td>
                          <td><textarea name="customerNameAddress" class="input_textbox_p compact" rows="1">
						  <?php echo $customerNameAddress; ?>
						  </textarea></td>
                        </tr>
                        <tr>
                          <td>Customer Remarks</td>
                          <td><textarea name="customerNameRemarks" class="input_textbox_p compact" rows="1"><?php echo $customerRemarks; ?></textarea></td>
                        </tr>
                        <tr>
                          <td>Receiving Officer</td><td><input type="text" name="receivingOfficer" class="input_textbox_p compact" value="<?php echo $receivingOfficer; ?>"/></td>
                        </tr>
                        <tr>
                          <td>Delivering Vehicle</td><td><input type="text" name="deliveryVehicle" class="input_textbox_p compact" value="<?php echo $deliveryVehicle; ?>"/></td>
                        </tr>
                      </thead>
                    </table >
                  </div>
                  <!--Right div-->
                  <div style="float: right; width: 49%">
                    <table border="0" cellpadding="0" cellspacing="0">
                      <thead>
                        <tr>
                          <td>Delivery Note No.</td><td><input type="text" name="deliveryNoteNo" class="input_textbox_p compact" value="<?php echo $deliveryNoteNo; ?>"/></td>
                        </tr>
                        <tr>
                          <td>Warehouse</td><td><input type="text" name="warehouse" class="input_textbox_p compact" value="<?php echo $warehouse; ?>"/></td>
                        </tr>
                        <tr><input type="hidden" name="id" value="<?php echo $id; ?>"/>
                          <td>County</td>
                          <td>
                            <select name="county"  class="input_select_p compact">
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
                          </td>
                        </tr>
                        <tr>
                          <td>District</td>
                          <td>
                            <select name="district"  class="input_select_p compact">
                              <option value=''<?php if ($district == '') echo 'selected'; ?> ></option>
                              <?php
                              $sql = "SELECT * FROM districts  ORDER BY district_name ASC";
                              $result = mysql_query($sql);
                              while ($rows = mysql_fetch_array($result)) { //loop table rows
                                ?>
                                <option value="<?php echo $rows['district_name']; ?>"<?php
                                if ($district == $rows['district_name']) {
                                  echo 'selected';
                                }
                                ?>><?php echo $rows['district_name']; ?></option>
                                      <?php } ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Date Saved</td><td><input type="text" disabled id="datepicker" name="dateSaved" class="input_textbox_p compact" value="<?php echo date('Y-m-d'); ?>"/></td>
						  <input type="text"  name="expiryDate1"  id="datepicker"  class="datepicker"/>
                        </tr>
                      </thead>
                    </table >
                  </div>
                </div>
                <div class="vclear"></div>
                <br/>





                <table border="2" align="center" cellpadding="0" style="width: 100%;">
                  <tr style="background-color: silver;">
                    <td colspan="6" style="padding: 5px;"><b>Drug Planning Assumptions</b></td>
                  </tr>
                  <tr>
                    <td align="center"> <b></b> </td>
					<td align="left"> <b>Item Code </b> </td>
                    <td align="left"> <b>Drug Description </b> </td>
                    <td align="center"> <b>Units </b> </td>
				    <td align="center"> <b>Batch No.</b> </td>
			        <td align="center"> <b>Expiry Date</b> </td>
                    <td align="center"> <b>Qty<br/>Ordered</b> </td>
                    <td align="center"> <b>Qty<br/>Issued</b> </td>
					<td align="center"> <b>Unit Price</b> </td>
					<td align="center"> <b>Total Price</b> </td>
					
                  </tr>
                  <tr>
				  
                    <td align="center" width="2%">1</td>
					<td align="left" width="30%"><input type="text"  name="itemCode1" id="itemCode1" onKeyUp="isBlank(this.id);"  style="width: 99%"/></td>                  
				   <td align="left" width="30%"><input type="text"  name="drugDescription1" id="drugDescription" onKeyUp="isBlank(this.id);"  style="width: 99%"/></td>
                    <td align="center" width="10%"><input type="text"  name="units1" id="units1" onKeyUp="isBlank(this.id);" class="txt-input-table-center"/></td>
					<td align="center" width="10%"><input type="text"  name="batchNo1" id="batchNo1" onKeyUp="isBlank(this.id);" class="txt-input-table-center"/></td>
                    <td align="center" width="10%"><input type="text"  name="expiryDate1"  id="datepicker"  class="datepicker"/></td>
                    <td align="center" width="10%"><input type="text"  name="qtyOrdered1" id="qtyOrdered1" onKeyUp="isBlank(this.id);" class="txt-input-table-center"/></td>
                    <td align="center" width="10%"><input type="text"  name="qtyIssued1" id="qtyIssued1" onKeyUp="isBlank(this.id);" class="txt-input-table-center"/></td>
					<td align="center" width="10%"><input type="text"  name="unitPrice1" id="unitPrice1" onKeyUp="isBlank(this.id);" class="txt-input-table-center"/></td>
					<td align="center" width="10%"><input type="text"  name="totalPrice1" id="totalPrice1" onKeyUp="isBlank(this.id);" class="txt-input-table-center"/></td>
                  </tr>
                  <tr>
                    <td align="center">2</td>
					<td><input type="text"  name="itemCode2"       class="txt-input-table-center"/></td>
                    <td><input type="text"  name="drugDescription2" style="width: 99%"/></td>
                    <td><input type="text"  name="units2"           class="txt-input-table-center"/></td>
					<td><input type="text"  name="batchNo2"       class="txt-input-table-center"/></td>
                    <td><input type="text"  name="expiryDate2" id="datepicker"     class="datepicker"/></td>
                    <td><input type="text"  name="qtyOrdered2"      class="txt-input-table-center"/></td>
                    <td><input type="text"  name="qtyIssued2"       class="txt-input-table-center"/></td>
					<td><input type="text"  name="unitPrice2"       class="txt-input-table-center"/></td>
					<td><input type="text"  name="totalPrice2"       class="txt-input-table-center"/></td>
                  </tr>
                  <tr>
                    <td align="center">3</td>
                  <td><input type="text"  name="itemCode3"       class="txt-input-table-center"/></td>
                    <td><input type="text"  name="drugDescription3" style="width: 99%"/></td>
                    <td><input type="text"  name="units3"           class="txt-input-table-center"/></td>
					<td><input type="text"  name="batchNo3"       class="txt-input-table-center"/></td>
                    <td><input type="text"  name="expiryDate3" id="datepicker"      class="txt-input-table-center"/></td>
                    <td><input type="text"  name="qtyOrdered3"      class="txt-input-table-center"/></td>
                    <td><input type="text"  name="qtyIssued3"       class="txt-input-table-center"/></td>
					<td><input type="text"  name="unitPrice3"       class="txt-input-table-center"/></td>
					<td><input type="text"  name="totalPrice3"       class="txt-input-table-center"/></td>
                  </tr>
                  <tr>
                    <td align="center">4</td>
                  <td><input type="text"  name="itemCode4"       class="txt-input-table-center"/></td>
                    <td><input type="text"  name="drugDescription4" style="width: 99%"/></td>
                    <td><input type="text"  name="units4"           class="txt-input-table-center"/></td>
					<td><input type="text"  name="batchNo4"       class="txt-input-table-center"/></td>
                    <td><input type="text"  name="expiryDate4" id="datepicker"      class="txt-input-table-center"/></td>
                    <td><input type="text"  name="qtyOrdered4"      class="txt-input-table-center"/></td>
                    <td><input type="text"  name="qtyIssued4"       class="txt-input-table-center"/></td>
					<td><input type="text"  name="unitPrice4"       class="txt-input-table-center"/></td>
					<td><input type="text"  name="totalPrice4"       class="txt-input-table-center"/></td>
                  </tr>
                  <tr>
                    <td align="center">5</td>
                <td><input type="text"  name="itemCode5"       class="txt-input-table-center"/></td>
                    <td><input type="text"  name="drugDescription5" style="width: 99%"/></td>
                    <td><input type="text"  name="units5"           class="txt-input-table-center"/></td>
					<td><input type="text"  name="batchNo5"       class="txt-input-table-center"/></td>
                    <td><input type="text"  name="expiryDate5" id="datepicker"     class="txt-input-table-center"/></td>
                    <td><input type="text"  name="qtyOrdered5"      class="txt-input-table-center"/></td>
                    <td><input type="text"  name="qtyIssued5"       class="txt-input-table-center"/></td>
					<td><input type="text"  name="unitPrice5"       class="txt-input-table-center"/></td>
					<td><input type="text"  name="totalPrice5"       class="txt-input-table-center"/></td>
                  </tr>

                </table><br/>
                <b>Special Notes </b><br/>
                <textarea style="width: 70%"cols="50" rows="2" id="specialNotes" name="specialNotes" placeholder="Enter special notes here"></textarea>

                <input type="submit" name="submitSaveNew" value="Save Delivery Note" class="btn-custom"/>
                <div class="vclear"/>
                <br/>
			</div>
			 </form>
			
        </div>
		

        <div style="border: 1px solid black; width: 100%"></div><br/>

        <div  id="tab-2"> 
        <table >
          <tr>
            <td width="30%">
              <div style="width: 100%;">
                <h1 style="text-align: center; margin-top: 0px; font-size: 20px">Previous Delivery Notes</h1>
                <div style=" margin-right: 20px">
                  <form method="post">
                    <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                      <thead>
                        <tr style="border: 1px solid #B4B5B0;">
                          <th align="Left" width="40px">ID</th>
                          <th align="Left" width="100px">Date Saved</th>

                          <th align="center" width="40px">View</th>
                          <th align="center" width="40px">Del</th>
                        </tr>
                      </thead>
                    </table>
                  </form>
                </div>

                <div style="width:100%; height:500px; overflow-x: visible; overflow-y: scroll; float: left">
                  <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                    <tbody>

                      <?php
                      $result_set = mysql_query("SELECT * FROM assumptions  ORDER BY id DESC");
                      while ($row = mysql_fetch_array($result_set)) {
                        $id = $row['id'];
                        $dateSaved = $row['dateSaved'];
                        $aTreatYear = $row['aTreatYear'];
                        $pTreatYear = $row['pTreatYear'];
                        $areaAssumptions = $row['areaAssumptions'];
                        ?>
                        <tr style="border-bottom: 1px solid #B4B5B0;">
                          <td align="left" width="40px"> <?php echo $id; ?>  </td>
                          <td align="left" width="100px"> <?php echo $dateSaved; ?>  </td>
  <!--                            <td align="left" width="200px"><?php
                          echo substr($areaAssumptions, 0, 30);
                          if (strlen($areaAssumptions) > 30)
                            echo "..";
                          ?>
                          </td>-->

                          <td align="center" width="40px"><a href="javascript:void(0)" onclick="loadRecordN('load',<?php echo $id; ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                          <td align="center" width="40px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                        </tr>
                      </tbody>
                    <?php } ?>
                  </table>
                </div>


              </div>
            </td>
            <td style="padding-left: 5px">
              <div id="divDisplayAssumption" style="width: 100%;">






                <!--<b style="text-align: center; margin-top: 0px; font-size: 15px">Delivery Note</b>-->
                <!--<h1 class="form-title">Delivery Note</h1>-->
                <!-- table begin  =============-->
                <td style="width: 100%">
                  <div  id="addNewDeliveryNote" style="width: 90%; margin: 0 auto">
                    <form method="post">
                      <div style="padding: 5px;">
                        <!--left div-->
                        <div style="float: left; width: 49%;">
                          <table border="0"  cellpadding="0" cellspacing="0">
                            <thead>
                              <tr>
                                <td>Customer Name & Address</td>
                                <td><label class="lbl-display">test data<br/>khuiohpi</label></td>
                              </tr>
                              <tr>
                                <td>Customer Remarks</td>
                                <td><label class="lbl-display"><?php echo $testdata; ?></label></td>
                              </tr>
                              <tr>
                                <td>Receiving Officer</td><td><label class="lbl-display"><?php echo $testdata; ?></label></td>
                              </tr>
                              <tr>
                                <td>Delivering Vehicle</td><td><label class="lbl-display"><?php echo $testdata; ?></label></td>
                              </tr>
                            </thead>
                          </table >
                        </div>
                        <!--Right div-->
                        <div style="float: right; width: 49%">
                          <table border="0" cellpadding="0" cellspacing="0">
                            <thead>
                              <tr>
                                <td>Delivery Note No.</td><td><label class="lbl-display"><?php echo $testdata; ?></label></td>
                              </tr>
                              <tr>
                                <td>Warehouse</td><td><label class="lbl-display"><?php echo $testdata; ?></label></td>
                              </tr>
                              <tr>
                                <td>County</td><td><label class="lbl-display"><?php echo $testdata; ?></label></td>
                              </tr>
                              <tr>
                                <td>District</td><td><label class="lbl-display"><?php echo $testdata; ?></label></td>
                              </tr>
                              <tr>
                                <td>Date Saved</td><td><input type="text" name="dpho_mobile" class="input_textbox_p compact" value="<?php echo date('Y-m-d'); ?>"/></td>
                              </tr>
                            </thead>
                          </table >
                        </div>
                      </div>
                      <div class="vclear"></div>
                      <br/>





                      <table border="2" align="center" cellpadding="0" style="width: 100%;">
                        <tr style="background-color: silver;">
                          <td colspan="6" style="padding: 5px;"><b>Drug Planning Assumptions</b></td>
                        </tr>
                        <tr>
                          <td align="center"> <b></b> </td>
                          <td align="left"> <b>Drug Description </b> </td>
                          <td align="center"> <b>Units </b> </td>
                          <td align="center"> <b>Expiry Date</b> </td>
                          <td align="center"> <b>Qty<br/>Ordered</b> </td>
                          <td align="center"> <b>Qty<br/>Issued</b> </td>
                        </tr>
                        <tr>
                          <td align="center" width="2%">1</td>
                          <td align="left" width="30%"><input type="text"  name="drugDescription1" id="drugDescription" onKeyUp="isBlank(this.id);"  style="width: 99%"/></td>
                          <td align="center" width="10%"><input type="text"  name="units1" id="units1" onKeyUp="isBlank(this.id);" class="txt-input-table-center"/></td>
                          <td align="center" width="10%"><input type="text"  name="expiryDate1" id="expiryDate1" onKeyUp="isBlank(this.id);" class="txt-input-table-center"/></td>
                          <td align="center" width="10%"><input type="text"  name="qtyOrdered1" id="qtyOrdered1" onKeyUp="isBlank(this.id);" class="txt-input-table-center"/></td>
                          <td align="center" width="10%"><input type="text"  name="qtyIssued1" id="qtyIssued1" onKeyUp="isBlank(this.id);" class="txt-input-table-center"/></td>
                        </tr>
                        <tr>
                          <td align="center">2</td>
                          <td><input type="text"  name="drugDescription2" style="width: 99%"/></td>
                          <td><input type="text"  name="units2"           class="txt-input-table-center"/></td>
                          <td><input type="text"  name="expiryDate2"      class="txt-input-table-center"/></td>
                          <td><input type="text"  name="qtyOrdered2"      class="txt-input-table-center"/></td>
                          <td><input type="text"  name="qtyIssued2"       class="txt-input-table-center"/></td>
                        </tr>
                        <tr>
                          <td align="center">3</td>
                          <td><input type="text"  name="drugDescription3" style="width: 99%"/></td>
                          <td><input type="text"  name="units3"           class="txt-input-table-center"/></td>
                          <td><input type="text"  name="expiryDate3"      class="txt-input-table-center"/></td>
                          <td><input type="text"  name="qtyOrdered3"      class="txt-input-table-center"/></td>
                          <td><input type="text"  name="qtyIssued3"       class="txt-input-table-center"/></td>
                        </tr>
                        <tr>
                          <td align="center">4</td>
                          <td><input type="text"  name="drugDescription4" style="width: 99%"/></td>
                          <td><input type="text"  name="units4"           class="txt-input-table-center"/></td>
                          <td><input type="text"  name="expiryDate4"      class="txt-input-table-center"/></td>
                          <td><input type="text"  name="qtyOrdered4"      class="txt-input-table-center"/></td>
                          <td><input type="text"  name="qtyIssued4"       class="txt-input-table-center"/></td>
                        </tr>
                        <tr>
                          <td align="center">5</td>
                          <td><input type="text"  name="drugDescription5" style="width: 99%"/></td>
                          <td><input type="text"  name="units5"           class="txt-input-table-center"/></td>
                          <td><input type="text"  name="expiryDate5"      class="txt-input-table-center"/></td>
                          <td><input type="text"  name="qtyOrdered5"      class="txt-input-table-center"/></td>
                          <td><input type="text"  name="qtyIssued5"       class="txt-input-table-center"/></td>
                        </tr>

                      </table><br/>
                      <b>Special Notes </b><br/>
                      <textarea style="width: 70%"cols="50" rows="2" id="notes" name="areaAssumptions" placeholder="Enter special notes here"></textarea>
                      <div class="vclear"/>
                      <br/>
                    </form>
                  </div>




				
              </div>
            </td>
          </tr>
        </table>
	</div>
</div>
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


                      //show previous records
                      function loadRecord(req, val) {
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
                        xmlhttp.open("GET", "ajax_files/assumptions.php?req=" + req + "&val=" + val, true);
                        xmlhttp.send();
                      }
      </script>
  </body>
</html>




