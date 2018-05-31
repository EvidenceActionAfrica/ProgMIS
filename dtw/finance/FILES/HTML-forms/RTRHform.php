<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once("../includes/function_convert_number_to_words.php");
$tabActive="tab1";



$receiver_name=isset($_POST["receiver_name"])? mysql_real_escape_string($_POST["receiver_name"]):"";
$preparedBy=isset($_POST["preparedBy"])?$_POST["preparedBy"]:"";
//$amount=isset($_POST["amount"])?mysql_real_escape_string($_POST["amount"]):"";
$fuelAdvanced=isset($_POST["fuelAdvanced"])?mysql_real_escape_string($_POST["fuelAdvanced"]):"";
$fuelSpent=isset($_POST["fuelSpent"])?mysql_real_escape_string($_POST["fuelSpent"]):"";
$lunchDMOHAdvanced=isset($_POST["lunchDMOHAdvanced"])?mysql_real_escape_string($_POST["lunchDMOHAdvanced"]):"";
$lunchDMOHSpent=isset($_POST["lunchDMOHSpent"])?mysql_real_escape_string($_POST["lunchDMOHSpent"]):"";


$driverLunchAdvanced=isset($_POST["driverLunchAdvanced"])?mysql_real_escape_string($_POST["driverLunchAdvanced"]):"";
$driverLunchSpent=isset($_POST["driverLunchSpent"])?mysql_real_escape_string($_POST["driverLunchSpent"]):"";


$coordinationAllowanceDMOHAdvanced=isset($_POST["coordinationAllowanceDMOHAdvanced"])?mysql_real_escape_string($_POST["coordinationAllowanceDMOHAdvanced"]):"";
$coordinationAllowanceDMOHSpent=isset($_POST["coordinationAllowanceDMOHSpent"])?mysql_real_escape_string($_POST["coordinationAllowanceDMOHSpent"]):"";
$tAllowanceDMOHAdvanced=isset($_POST["tAllowanceDMOHAdvanced"])?mysql_real_escape_string($_POST["tAllowanceDMOHAdvanced"]):"";

$tAllowanceDMOHSpent=isset($_POST["tAllowanceDMOHSpent"])?mysql_real_escape_string($_POST["tAllowanceDMOHSpent"]):"";
$airTimeDMOHAdvanced=isset($_POST["airTimeDMOHAdvanced"])?mysql_real_escape_string($_POST["airTimeDMOHAdvanced"]):"";
$airTimeDMOHSpent=isset($_POST["airTimeDMOHSpent"])?mysql_real_escape_string($_POST["airTimeDMOHSpent"]):"";
$facilitationAllowanceAdvanced=isset($_POST["facilitationAllowanceAdvanced"])?mysql_real_escape_string($_POST["facilitationAllowanceAdvanced"]):"";
$facilitationAllowanceSpent=isset($_POST["facilitationAllowanceSpent"])?mysql_real_escape_string($_POST["facilitationAllowanceSpent"]):"";
$tAllowanceDistrictLevelAdvanced=isset($_POST["tAllowanceDistrictLevelAdvanced"])?mysql_real_escape_string($_POST["tAllowanceDistrictLevelAdvanced"]):"";
$tAllowanceDistrictLevelSpent=isset($_POST["tAllowanceDistrictLevelSpent"])?mysql_real_escape_string($_POST["tAllowanceDistrictLevelSpent"]):"";
$airAllowanceDistrictLevelAdvanced=isset($_POST["airAllowanceDistrictLevelAdvanced"])?mysql_real_escape_string($_POST["airAllowanceDistrictLevelAdvanced"]):"";
$airAllowanceDistrictLevelSpent=isset($_POST["airAllowanceDistrictLevelSpent"])?mysql_real_escape_string($_POST["airAllowanceDistrictLevelSpent"]):"";
$tAllowanceDivLevelAdvanced=isset($_POST["tAllowanceDivLevelAdvanced"])?mysql_real_escape_string($_POST["tAllowanceDivLevelAdvanced"]):"";
$tAllowanceDivLevelSpent=isset($_POST["tAllowanceDivLevelSpent"])?mysql_real_escape_string($_POST["tAllowanceDivLevelSpent"]):"";
$bankChargesAdvanced=isset($_POST["bankChargesAdvanced"])?mysql_real_escape_string($_POST["bankChargesAdvanced"]):"";
$bankChargesSpent=isset($_POST["bankChargesSpent"])?mysql_real_escape_string($_POST["bankChargesSpent"]):"";
$courierAdvanced=isset($_POST["courierAdvanced"])?mysql_real_escape_string($_POST["courierAdvanced"]):"";
$courierSpent=isset($_POST["courierSpent"])?mysql_real_escape_string($_POST["courierSpent"]):"";
$otherAllowancesAdvanced1=isset($_POST["otherAllowancesAdvanced1"])?mysql_real_escape_string($_POST["otherAllowancesAdvanced1"]):"";
$otherAllowancesSpent1=isset($_POST["otherAllowancesSpent1"])?mysql_real_escape_string($_POST["otherAllowancesSpent1"]):"";
$otherAllowancesAdvanced2=isset($_POST["otherAllowancesAdvanced2"])?mysql_real_escape_string($_POST["otherAllowancesAdvanced2"]):"";
$otherAllowancesSpent2=isset($_POST["otherAllowancesSpent2"])?mysql_real_escape_string($_POST["otherAllowancesSpent2"]):"";
$otherAllowancesAdvanced3=isset($_POST["otherAllowancesAdvanced3"])?mysql_real_escape_string($_POST["otherAllowancesAdvanced3"]):"";
$otherAllowancesSpent3=isset($_POST["otherAllowancesSpent3"])?mysql_real_escape_string($_POST["otherAllowancesSpent3"]):"";
$totalAmountAdvanced=isset($_POST["totalAmountAdvanced"])?mysql_real_escape_string($_POST["totalAmountAdvanced"]):"";
$totalAmountSpent=isset($_POST["totalAmountSpent"])?mysql_real_escape_string($_POST["totalAmountSpent"]):"";
$amount=isset($_POST["totalAmountSpent"])?strToUpper(convert_number_to_words($_POST["totalAmountSpent"].' Shillings')):"0";
$remarks=isset($_POST["remarks"])?mysql_real_escape_string($_POST["remarks"]):"";
$date=date("Y-m-d");

if($_POST["saveRecord"]){
$tabActive="tab2";
$sql="INSERT INTO `fin_budget_rtrh`(`fuel_advanced`, `fuel_spent`, `lunch_dmoh_advanced`, `lunch_dmoh_spent`, `coordination_dmoh_advanced`, `coordination_dmoh_spent`, `transport_dmoh_advanced`, `transport_dmoh_spent`, `airtime_dmoh_advanced`, `airtime_dmoh_spent`, `facilitation_allowance_dmoh_advanced`, `facilitation_dmoh_spent`, `transport_dlp_advanced`, `transport_dlp_spent`, `airtime_dlp_advanced`, `airtime_dlp_spent`, `transport_divlp_advanced`, `transport_divlp_spent`, `bankcharges_advanced`, `bankcharges_spent`, `courier_advanced`, `courier_spent`, `other_allowance_advanced`, `other_allowance_spent`, `other_allowance1_advanced`, `other_allowance1_spent`, `other_allowance2_advanced`, `other_allowance2_spent`, `name`, `amount`, `date`, `remarks`, `prepared_by`,`total_amount_advanced`,`total_amount_spent`,`lunch_driver_advanced`,`lunch_driver_spent`)";


$sql.=" VALUES ('$fuelAdvanced','$fuelSpent','$lunchDMOHAdvanced','$lunchDMOHSpent','$coordinationAllowanceDMOHAdvanced','$coordinationAllowanceDMOHSpent'";
$sql.=",'$tAllowanceDMOHAdvanced','$tAllowanceDMOHSpent','$airTimeDMOHAdvanced','$airTimeDMOHSpent',";

$sql.="'$facilitationAllowanceAdvanced','$facilitationAllowanceSpent','$tAllowanceDistrictLevelAdvanced','$tAllowanceDistrictLevelSpent',";
$sql.="'$airAllowanceDistrictLevelAdvanced','$airAllowanceDistrictLevelSpent','$tAllowanceDivLevelAdvanced','$tAllowanceDivLevelSpent','$bankChargesAdvanced','$bankChargesSpent',";
$sql.="'$courierAdvanced','$courierSpent','$otherAllowancesAdvanced1','$otherAllowancesSpent1','$otherAllowancesAdvanced2','$otherAllowancesSpent2','$otherAllowancesAdvanced3','$otherAllowancesSpent3',";
$sql.="'$receiver_name','$amount','$date','$remarks','$preparedBy','$totalAmountAdvanced','$totalAmountSpent','$driverLunchAdvanced','$driverLunchSpent')";
echo $sql;
mysql_query($sql) or die(mysql_error());
}
if(isset($_GET["deleteid"])){
	$tabActive="tab2";
$id=$_GET["deleteid"];
$sql="DELETE from fin_budget_rtrh where id='$id'";

mysql_query($sql);
}

if($_POST["updateRecord"]){
$tabActive="tab2";
$id=$_GET["id"];
$sql="UPDATE `fin_budget_rtrh` SET `fuel_advanced`='$fuelAdvanced',`fuel_spent`='$fuelSpent',`lunch_driver_advanced`='$driverLunchAdvanced',";
$sql.="`lunch_driver_spent`='$driverLunchSpent',`lunch_dmoh_advanced`='$lunchDMOHAdvanced',`lunch_dmoh_spent`='$lunchDMOHSpent',`coordination_dmoh_advanced`='$coordinationAllowanceDMOHAdvanced',";
$sql.="`coordination_dmoh_spent`='$coordinationAllowanceDMOHSpent',`transport_dmoh_advanced`='$tAllowanceDMOHAdvanced',`transport_dmoh_spent`='$tAllowanceDMOHSpent',`airtime_dmoh_advanced`='$airTimeDMOHAdvanced',";
$sql.="`airtime_dmoh_spent`='$airTimeDMOHSpent',`facilitation_allowance_dmoh_advanced`='$facilitationAllowanceAdvanced',`facilitation_dmoh_spent`='$facilitationAllowanceSpent',";
$sql.="`transport_dlp_advanced`='$tAllowanceDistrictLevelAdvanced',`transport_dlp_spent`='$tAllowanceDistrictLevelSpent',`airtime_dlp_advanced`='$airAllowanceDistrictLevelAdvanced',`airtime_dlp_spent`='$airAllowanceDistrictLevelSpent',";
$sql.="`transport_divlp_advanced`='$tAllowanceDivLevelAdvanced',`transport_divlp_spent`='$tAllowanceDivLevelSpent',`bankcharges_advanced`='$bankChargesAdvanced',`bankcharges_spent`='$bankChargesSpent',";
$sql.="`courier_advanced`='$courierAdvanced',`courier_spent`='$courierSpent',`other_allowance_advanced`='$otherAllowancesAdvanced1',`other_allowance_spent`='$otherAllowancesSpent1',";
$sql.="`other_allowance1_advanced`='$otherAllowancesAdvanced2',`other_allowance1_spent`='$otherAllowancesSpent1',`other_allowance2_advanced`='$otherAllowancesAdvanced3',";
$sql.="`other_allowance2_spent`='$otherAllowancesSpent3',`total_amount_advanced`='$totalAmountAdvanced',`total_amount_spent`='$totalAmountSpent',`name`='$receiver_name',";
$sql.="`amount`='$amount',`date`='$date',`remarks`='$remarks',`prepared_by`='$preparedBy' WHERE `id`='$id'";

echo $sql;

mysql_query($sql);
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("includes/meta-link-script.php");
    ?>  
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">   
    <link href="css/default.css" type="text/css" rel="stylesheet">   
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php
        require_once ("includes/menuNav.php");
        ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-Settings.php"); ?>
      </div>
      <div class="contentBody">

      

      
       <div class="tabbable" >
                  <ul class="nav nav-tabs">
                    <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Add Financial Reconciliation Return Form
</a></li>
                    <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">View Financial Reconciliation Return Form
</a></li>
                   
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>"  id="tab1">
                         
		
              <h2>Financial Reconciliation Return Form</h2>
              <form method="POST">
                <table border="0"cellpadding="0" cellspacing="0">
                  <thead>
                    <tr>
						<td>Name</td><td><input type="text" id="receiver_name" name="receiver_name" value="" /></td>
						<td>Date</td><td><input type="text" id="date" name="date" value="<?php echo date("Y-m-d") ?>" readonly/></td>
                     </tr>
					 <tr>
					 <td></td>
					 </tr>
					 <tr style="height:10px"></tr>
					 <tr style="margin:5px;">
					 <td>Amount(Words)</td><td><input type="text" disable style="width:300px;" name="amount" value="<?php echo strToUpper(convert_number_to_words($totalAmountAdvanced)); ?>" /></td>
					 
				</tr>
					 </thead>
				</table>
				<br/><br/>
				<table border="2" >
				<thead style="font-weight:bold;">
				<tr>
				<th>No.</th>
				<th>Unit Description</th>
				<th>Amount Advanced</th>
				<th>Amount Spent</th>
				<th>Variance</th>
				
				
				</tr>
				</thead>
					<tbody>
				<tr>
				<td></td><td><b>Amount forwarded to your district</b></td>
				</tr>
				<tr>
					<td>1</td><td>Fuel(30/= Per kilometer)</td><td><input type="text" id="fuelAdvanced" name="fuelAdvanced" value="<?php echo $fuelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="fuelAdvancedSpan"/></span></td></td><td><input type="text" id="fuelSpent"  name="fuelSpent" value="<?php echo $fuelSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="fuelSpentSpan"/></span></td><td><input type="text" id="fuelVariance" name="fuelVariance" value="<?php echo $fuelVariance=abs($fuelAdvanced-$fuelSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="fuelVarianceSpan"/></span> </td>
				</tr>
				<tr>
				<td>2</td><td>Lunch For DMOH</td><td><input type="text" name="lunchDMOHAdvanced" id="lunchDMOHAdvanced" value="<?php echo $lunchDMOHAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="lunchDMOHAdvancedSpan"/></span></td><td><input type="text" id="lunchDMOHSpent" name="lunchDMOHSpent" value="<?php echo $lunchDMOHSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="lunchDMOHSpentSpan"/></span></td><td><input type="text" id="lunchDMOHVariance" name="lunchDMOHVariance" value="<?php echo $lunchDMOHVariance=abs($lunchDMOHAdvanced-$lunch_dmoh_spent); ?>" onKeyUp="isNumeric(this.id);"/><span id="lunchDMOHVarianceSpan"/></span></td>
				
				</tr>
				<tr>
				<td>3</td><td>Lunch for Driver</td><td><input type="text" id="driverLunchAdvanced" name="driverLunchAdvanced" value="<?php echo $driverLunchAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="driverLunchAdvancedSpan"/></span></td><td><input type="text" name="driverLunchSpent" id="driverLunchSpent" value="<?php echo $driverLunchSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="driverLunchSpentSpan"/></span></td><td><input type="text" id="driverLunchVariance" name="driverLunchVariance" value="<?php echo $driverLunchVariance=abs($driverLunchAdvanced-$driverLunchSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="driverLunchVarianceSpan"/></span></td>
				
				</tr>
				<tr>
				<td>4</td><td>Coordination Allowance for DMOH</td><td><input type="text" id="coordinationAllowanceDMOHAdvanced" name="coordinationAllowanceDMOHAdvanced" value="<?php echo $coordinationAllowanceDMOHAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDMOHAdvancedSpan"/></span></td><td><input type="text" name="coordinationAllowanceDMOHSpent" id="coordinationAllowanceDMOHSpent" value="<?php echo $coordinationAllowanceDMOHSpent; ?>"onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDMOHSpentSpan"/></span></td><td><input type="text" name="coordinationAllowanceDMOHVariance" id="coordinationAllowanceDMOHVariance" value="<?php echo $coordinationAllowanceDMOHVariance=abs($coordinationAllowanceDMOHAdvanced-$coordinationAllowanceDMOHSpent) ; ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDMOHVarianceSpan"/></span></td>
			</tr>
				<tr>
				<td>5</td><td>Transport Allowance for DMOH</td><td><input type="text" id="tAllowanceDMOHAdvanced" name="tAllowanceDMOHAdvanced" value="<?php echo $tAllowanceDMOHAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDMOHAdvancedSpan"/></span></td><td><input type="text" name="tAllowanceDMOHSpent" id="tAllowanceDMOHSpent" value="<?php echo $tAllowanceDMOHSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDMOHSpentSpan"/></span></td><td><input type="text" id="tAllowanceDMOHVariance" name="tAllowanceDMOHVariance" value="<?php echo $tAllowanceDMOHVariance=abs($tAllowanceDMOHAdvanced-$tAllowanceDMOHSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDMOHVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>6</td><td>Airtime for DMOH</td><td><input type="text" name="airTimeDMOHAdvanced" id="airTimeDMOHAdvanced" value="<?php echo $airTimeDMOHAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDMOHAdvancedSpan"/></span></td><td><input type="text" id="airTimeDMOHSpent" name="airTimeDMOHSpent" value="<?php echo $airTimeDMOHSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDMOHSpentSpan"/></span></td><td><input type="text" id="airTimeDMOHVariance" name="airTimeDMOHVariance" value="<?php echo $airTimeDMOHVariance=abs($airTimeDMOHAdvanced-$airTimeDMOHSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDMOHVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>7</td><td>Facilitation Allowance for DMOH</td><td><input type="text" id="facilitationAllowanceAdvanced" name="facilitationAllowanceAdvanced" value="<?php echo $facilitationAllowanceAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationAllowanceAdvancedSpan"/></span></td><td><input type="text" name="facilitationAllowanceSpent" id="facilitationAllowanceSpent" value="<?php echo $facilitationAllowanceSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationAllowanceSpentSpan"/></span></td><td><input type="text" name="facilitationAllowanceVariance" id="facilitationAllowanceVariance" value="<?php echo $facilitationAllowanceVariance=abs($facilitationAllowanceAdvanced-$facilitationAllowanceSpent);?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationAllowanceVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>8</td><td>Transport Allowance for District Level Personnel</td><td><input type="text" id="tAllowanceDistrictLevelAdvanced" name="tAllowanceDistrictLevelAdvanced" value="<?php echo $tAllowanceDistrictLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDistrictLevelAdvancedSpan"/></span></td><td><input type="text" id="tAllowanceDistrictLevelSpent" name="tAllowanceDistrictLevelSpent" value="<?php echo $tAllowanceDistrictLevelSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDistrictLevelSpentSpan"/></span></td><td><input type="text" id="tAllowanceDistrictLevelVariance" name="tAllowanceDistrictLevelVariance" value="<?php echo $tAllowanceDistrictLevelVariance=abs($tAllowanceDistrictLevelAdvanced-$tAllowanceDistrictLevelSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDistrictLevelVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>9</td><td>Airtime Allowance for District Level Personnel</td><td><input type="text" id="airAllowanceDistrictLevelAdvanced" name="airAllowanceDistrictLevelAdvanced" value="<?php echo $airAllowanceDistrictLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="airAllowanceDistrictLevelAdvancedSpan"/></span></td><td><input type="text" id="airAllowanceDistrictLevelSpent" name="airAllowanceDistrictLevelSpent" value="<?php echo $airAllowanceDistrictLevelSpent;?>" onKeyUp="isNumeric(this.id);"/><span id="airAllowanceDistrictLevelSpentSpan"/></span></td><td><input type="text" id="airAllowanceDistrictLevelVariance" name="airAllowanceDistrictLevelVariance" value="<?php echo $airAllowanceDistrictLevelVariance=abs($airAllowanceDistrictLevelAdvanced-$airAllowanceDistrictLevelSpent); ?>"  onKeyUp="isNumeric(this.id);"/><span id="airAllowanceDistrictLevelVarianceSpan"/></span></td>
				
				</tr>
					
					<tr>
				<td>10</td><td>Transport Allowance for Division Level Personnel</td><td><input type="text" id="tAllowanceDivLevelAdvanced" name="tAllowanceDivLevelAdvanced" value="<?php echo $tAllowanceDivLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDivLevelAdvancedSpan"/></span></td><td><input type="text" id="tAllowanceDivLevelSpent" name="tAllowanceDivLevelSpent" value="<?php echo $tAllowanceDivLevelSpent ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDivLevelSpentSpan"/></span></td><td><input type="text" name="tAllowanceDivLevelVariance" id="tAllowanceDivLevelVariance" value="<?php echo $tAllowanceDivLevelVariance=abs($tAllowanceDivLevelAdvanced-$tAllowanceDivLevelSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDivLevelVarianceSpan"/></span></td>
				
				</tr>
				<tr>
				<td>11</td><td>Bank Charges</td><td><input type="text" id="bankChargesAdvanced" name="bankChargesAdvanced" value="<?php echo $bankChargesAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="bankChargesAdvancedSpan"/></span></td><td><input type="text" id="bankChargesSpent" name="bankChargesSpent" value="<?php echo $bankChargesSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="bankChargesSpentSpan"/></span></td><td><input type="text" name="bankChargesVariance" id="bankChargesVariance" value="<?php echo $bankChargesVariance=abs($bankChargesAdvanced-$bankChargesSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="bankChargesVarianceSpan"/></span></td>
				
				</tr>
				<tr>
				<td>12</td><td>G4s Courier</td><td><input type="text" id="courierAdvanced" name="courierAdvanced" value="<?php echo $courierAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="courierAdvancedSpan"/></span></td><td><input type="text" id="courierSpent" name="courierSpent" value="<?php echo $courierSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="courierSpentSpan"/></span></td><td><input type="text" id="courierVariance" name="courierVariance" value="<?php echo $courierVariance=abs($courierAdvanced-$courierSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="courierVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>13</td><td>Other Allowances</td><td><input type="text" id="otherAllowancesAdvanced1" name="otherAllowancesAdvanced1" value="<?php echo $otherAllowancesAdvanced1; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesAdvanced1Span"/></span></td><td><input type="text" id="otherAllowancesSpent1" name="otherAllowancesSpent1" value="<?php echo $otherAllowancesSpent1; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesSpent1Span"/></span></td><td><input type="text" id="otherAllowancesVariance1" name="otherAllowancesVariance" value="<?php echo $otherAllowancesVariance=abs($otherAllowancesAdvanced1-$otherAllowancesSpent1); ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesVariance1Span"/></span></td>
				
				</tr>
					<tr>
				<td>14</td><td>Other Allowances</td><td><input type="text" id="otherAllowancesAdvanced2" name="otherAllowancesAdvanced2" value="<?php echo $otherAllowancesAdvanced2; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesAdvanced2Span"/></span></td><td><input type="text" id="otherAllowancesSpent2" name="otherAllowancesSpent2" value="<?php echo $otherAllowancesSpent2; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesSpent2Span"/></span></td><td><input type="text" id="otherAllowancesVariance2" name="otherAllowancesVariance" value="<?php echo $otherAllowancesVariance=abs($otherAllowancesAdvanced2-$otherAllowancesSpent2); ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesVariance2Span"/></span></td>
				
				</tr>
					<tr>
				<td>15</td><td>Other Allowances</td><td><input type="text" id="otherAllowancesAdvanced3" name="otherAllowancesAdvanced3" value="<?php echo $otherAllowancesAdvanced3; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesAdvanced3Span"/></span></td><td><input type="text" id="otherAllowancesSpent3" name="otherAllowancesSpent3" value="<?php echo $otherAllowancesSpent3; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesSpent3Span"/></span></td><td><input type="text" id="otherAllowancesVariance3" name="otherAllowancesVariance3" value=" <?php echo $otherAllowancesVariance3=abs($otherAllowancesAdvanced3-$otherAllowancesSpent3); ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesVariance3Span"/></span></td>
				
				</tr>
				
				<tr>
				<td>16</td><td><b>Total Amount</b></td><td><input type="text" id="totalAmountAdvanced" name="totalAmountAdvanced" value="<?php echo $totalAmountAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="totalAmountAdvancedSpan"/></span></td><td><input type="text" id="totalAmountSpent" name="totalAmountSpent" value="<?php echo $totalAmountSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="totalAmountSpentSpan"/></span></td><td><input type="text" id="totalAmountVariance" name="totalAmountVariance" value="<?php echo $totalAmountVariance=abs($totalAmountAdvanced-$totalAmountSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="totalAmountVarianceSpan"/></span></td>
				</tr>
				<tr>
				
				<td>Remarks</td>
				<td colspan="2"><textarea colspan="2" name="remarks"><?php echo $remarks; ?></textarea></td>
				
				</tr>
				</tbody>
				</table>
				<div style="margin-left:45%;">
				<label for="preparedBy">Prepared By</label>
				<select name="preparedBy">
				<option selected="selected" value=""></option>
			   
			  <?php 
				$sql="select staff_name from staff";
				$results=mysql_query($sql);
				while($row=mysql_fetch_array($results)){
			  echo "<option value=".$row["staff_name"].">".$row["staff_name"]."</option>";
			  }
			  ?>
				</select>
				</br><br/><br/>
				<input type="submit" class="btn btn-info" name="saveRecord" value="Save Details" />
				</div>
				
				
				
            </div>
            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>"  id="tab2">

            	 <h1 style="text-align: center; margin-top: 0px; font-size: 20px">View Reconciliation Forms</h1>
                  
                    <form method="post" style=" ">
                      <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                        <thead>
                          <tr style="border: 1px solid #B4B5B0;">
                            <th align="Left" width="10px">ID</th>
                            <th align="Left" width="20px">Name</th>
                            <th align="Left" width="20px">Prepared By</th>
                            
                            <th align="Left" width="10px">Date Saved</th>

                            <th align="center" width="25px">View</th>
                            <th align="center" width="15px">Del</th>
                          </tr>
                        </thead>
                      </table>
                    </form>
                  

                 
                    <table  style="width:100%; overflow-x: visible; overflow-y: scroll; float: left"width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                      <tbody>

                        <?php
                       $id=isset($_GET["id"])?$_GET["id"]:"";

                                $result_display = mysql_query("SELECT * FROM fin_budget_rtrh where id like '%$form_id%'");

                                while ($row = mysql_fetch_array($result_display)) {
                                
						$receiver_name=$row["name"];
						$preparedBy=$row["prepared_by"];
						$id=$row["id"];
						$dateSaved=$row["date"];

							$amount=isset($row["amount"])?$row["amount"]:"";
							$fuelAdvanced=isset($row["fuel_advanced"])?$row["fuel_advanced"]:"";
							$fuelSpent=isset($row["fuel_spent"])?$row["fuel_spent"]:"";
							$lunchDMOHAdvanced=isset($row["lunch_dmoh_advanced"])?$row["lunch_dmoh_advanced"]:"";
							$lunchDMOHSpent=isset($row["lunch_dmoh_spent"])?$row["lunch_dmoh_spent"]:"";
							
							$driverLunchAdvanced=isset($row["lunch_driver_advanced"])?$row["lunch_driver_advanced"]:"";
							$driverLunchSpent=isset($row["lunch_driver_spent"])?$row["lunch_driver_spent"]:"7878787";
							



							$coordinationAllowanceDMOHAdvanced=isset($row["coordination_dmoh_advanced"])?$row["coordination_dmoh_advanced"]:"";
							$coordinationAllowanceDMOHSpent=isset($row["coordination_dmoh_spent"])?$row["coordination_dmoh_spent"]:"";
							$tAllowanceDMOHAdvanced=isset($row["transport_dmoh_advanced"])?$row["transport_dmoh_advanced"]:"";

							$tAllowanceDMOHSpent=isset($row["transport_dmoh_spent"])?$row["transport_dmoh_spent"]:"";
							$airTimeDMOHAdvanced=isset($row["airtime_dmoh_advanced"])?$row["airtime_dmoh_advanced"]:"";
							$airTimeDMOHSpent=isset($row["airtime_dmoh_spent"])?$row["airtime_dmoh_spent"]:"";
							$facilitationAllowanceAdvanced=isset($row["facilitation_allowance_dmoh_advanced"])?$row["facilitation_allowance_dmoh_advanced"]:"";
							$facilitationAllowanceSpent=isset($row["facilitation_dmoh_spent"])?$row["facilitation_dmoh_spent"]:"";
							$tAllowanceDistrictLevelAdvanced=isset($row["transport_dlp_advanced"])?$row["transport_dlp_advanced"]:"";
							$tAllowanceDistrictLevelSpent=isset($row["transport_dlp_spent"])?$row["transport_dlp_spent"]:"";
							$airAllowanceDistrictLevelAdvanced=isset($row["airtime_dlp_advanced"])?$row["airtime_dlp_advanced"]:"";
							$airAllowanceDistrictLevelSpent=isset($row["airtime_dlp_spent"])?$row["airtime_dlp_spent"]:"";

							$tAllowanceDivLevelAdvanced=isset($row["transport_divlp_advanced"])?$row["transport_divlp_advanced"]:"";
							$tAllowanceDivLevelSpent=isset($row["transport_divlp_spent"])?$row["transport_divlp_spent"]:"";
							$bankChargesAdvanced=isset($row["bankcharges_advanced"])?$row["bankcharges_advanced"]:"";
							$bankChargesSpent=isset($row["bankcharges_spent"])?$row["bankcharges_spent"]:"";
							$courierAdvanced=isset($row["courier_advanced"])?$row["courier_advanced"]:"";
							$courierSpent=isset($row["courier_spent"])?$row["courier_spent"]:"";
							$otherAllowancesAdvanced1=isset($row["other_allowance_advanced"])?$row["other_allowance_advanced"]:"";
							$otherAllowancesSpent1=isset($row["other_allowance_spent"])?$row["other_allowance_spent"]:"";

							$otherAllowancesAdvanced2=isset($row["other_allowance1_advanced"])?$row["other_allowance1_advanced"]:"";
							$otherAllowancesSpent2=isset($row["other_allowance1_spent"])?$row["other_allowance1_spent"]:"";

							$otherAllowancesAdvanced3=isset($row["other_allowance2_advanced"])?$row["other_allowance2_advanced"]:"";
							$otherAllowancesSpent3=isset($row["other_allowance2_spent"])?$row["other_allowance2_spent"]:"";

							$totalAmountAdvanced=isset($row["total_amount_advanced"])?$row["total_amount_advanced"]:"";
							$totalAmountSpent=isset($row["total_amount_spent"])?$row["total_amount_spent"]:"";

							$remarks=isset($row["remarks"])?$row["remarks"]:"";
                              
                          ?>
                          <tr style="border-bottom: 1px solid #B4B5B0;">

                            <td align="left" width="20px"> <?php echo $id; ?>  </td>
                            <td align="left" width="20px"> <?php echo $receiver_name; ?>  </td>
                            <td align="left" width="30px"> <?php echo $preparedBy; ?>  </td>
                            
                            <td align="left" width="40px"> <?php echo $dateSaved; ?>  </td>  


                            <td align="center" width="20px"><a href="RTRHform.php?id=<?php echo $id ?>#openModal" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                            <td align="center" width="20px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                          </tr>
                        </tbody>
                      <?php } ?>
                    </table>
                




            </div>
         
          </div>
        </div>
    </div>
</div>
</div>





      </div>
    </div>

  </body>
</html>


<!--filter includes-->
<script type="text/javascript" src="../css/filter-as-you-type/jquery.min.js"></script>
<script type="text/javascript" src="../css/filter-as-you-type/jquery.quicksearch.js"></script>
<script type="text/javascript">
  $(function() {
    $('input#id_search').quicksearch('table tbody tr');
  });
</script>
 <script>
          function show_confirm(deleteid) {
            if (confirm("Are you sure you want to delete?")) {
              location.replace('?deleteid=' + deleteid);
            } else {
              return false;
            }
          }

        </script>
  <div id="openModal" class="modalDialog">
  <div style="width:80%;margin-top:1%;">
    

              <h2>Financial Reconciliation Return Form</h2>
             <a href="#close" class="btn btn-danger"style="position:absolute;margin-left:96%;margin-top:-7%;" title="Close" class="close">X</a>
              <form method="POST">
              	 <div style="position:absolute;margin-top:3%;margin-left:45%;">
                    	<label for="preparedBy">Prepared By</label><select name="preparedBy">
				<option selected="selected" value="<?php echo $preparedBy; ?>"><?php echo $preparedBy; ?></option>
			   
			  <?php 
				$sql="select staff_name from staff";
				$results=mysql_query($sql);
				while($row=mysql_fetch_array($results)){
			  
			  echo "<option value='".$row["staff_name"]."''>".$row["staff_name"]."</option>";


			  }
			  ?>
				</select>
				
				<input type="submit" class="btn btn-info" name="updateRecord" value="Update Details" />
				</div>
                <table border="0"cellpadding="0" cellspacing="0">
                  <thead>
                   
				<tr style="margin-top:5px;">
						<td>Name</td><td><input type="text" id="receiver_name" name="receiver_name" value="<?php echo $receiver_name; ?>" /></td>
						<td>Date</td><td><input type="text" id="date" name="date" value="<?php echo date("Y-m-d") ?>" readonly/></td>
                     </tr>
					 <tr>
					 <td></td>
					 </tr>
					 <tr style="height:10px"></tr>
					 <tr style="margin:5px;">
					 <td>Amount(Words)</td><td><input type="text" disable style="width:300px;" name="amount" value="<?php echo strToUpper(convert_number_to_words($totalAmountAdvanced).' Shillings'); ?>" /></td>
					 
				</tr>
					 </thead>
				</table>
				<br/><br/>
				<table border="2" >
				<thead style="font-weight:bold;">
				<tr>
				<th>No.</th>
				<th>Unit Description</th>
				<th>Amount Advanced</th>
				<th>Amount Spent</th>
				<th>Variance</th>
				
				
				</tr>
				</thead>
				<tbody>
				<tr>
				<td></td><td><b>Amount forwarded to your district</b></td>
				</tr>
				<tr>
					<td>1</td><td>Fuel(30/= Per kilometer)</td><td><input type="text" id="fuelAdvanced2" name="fuelAdvanced" value="<?php echo $fuelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="fuelAdvanced2Span"/></span></td></td><td><input type="text" id="fuelSpent2"  name="fuelSpent" value="<?php echo $fuelSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="fuelSpent2Span"/></span></td><td><input type="text" id="fuelVariance2" name="fuelVariance" value="<?php echo $fuelVariance=abs($fuelAdvanced-$fuelSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="fuelVariance2Span"/></span> </td>
				</tr>
				<tr>
				<td>2</td><td>Lunch For DMOH</td><td><input type="text" name="lunchDMOHAdvanced" id="lunchDMOHAdvanced2" value="<?php echo $lunchDMOHAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="lunchDMOHAdvanced2Span"/></span></td><td><input type="text" id="lunchDMOHSpent2" name="lunchDMOHSpent" value="<?php echo $lunchDMOHSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="lunchDMOHSpent2Span"/></span></td><td><input type="text" id="lunchDMOHVariance2" name="lunchDMOHVariance" value="<?php echo $lunchDMOHVariance=abs($lunchDMOHAdvanced-$lunch_dmoh_spent); ?>" onKeyUp="isNumeric(this.id);"/><span id="lunchDMOHVariance2Span"/></span></td>
				
				</tr>
				<tr>
				<td>2</td><td>Lunch For Driver</td><td><input type="text" name="driverLunchAdvanced" id="driverLunchAdvanced2" value="<?php echo $driverLunchAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="driverLunchAdvanced2Span"/></span></td><td><input type="text" id="driverLunchSpent2" name="driverLunchSpent" value="<?php echo $driverLunchSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="driverLunchSpent2Span"/></span></td><td><input type="text" id="driverLunchVariance2" name="driverLunchVariance" value="<?php echo $driverLunchVariance=abs($driverLunchAdvanced-$driverLunchSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="driverLunchVariance2Span"/></span></td>
				
				</tr>
				
				<tr>
				<td>4</td><td>Coordination Allowance for DMOH</td><td><input type="text" id="coordinationAllowanceDMOHAdvanced2" name="coordinationAllowanceDMOHAdvanced" value="<?php echo $coordinationAllowanceDMOHAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDMOHAdvanced2Span"/></span></td><td><input type="text" name="coordinationAllowanceDMOHSpent" id="coordinationAllowanceDMOHSpent2" value="<?php echo $coordinationAllowanceDMOHSpent; ?>"onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDMOHSpent2Span"/></span></td><td><input type="text" name="coordinationAllowanceDMOHVariance" id="coordinationAllowanceDMOHVariance2" value="<?php echo $coordinationAllowanceDMOHVariance=abs($coordinationAllowanceDMOHAdvanced-$coordinationAllowanceDMOHSpent) ; ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDMOHVariance2Span"/></span></td>
			</tr>
				<tr>
				<td>5</td><td>Transport Allowance for DMOH</td><td><input type="text" id="tAllowanceDMOHAdvanced2" name="tAllowanceDMOHAdvanced" value="<?php echo $tAllowanceDMOHAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDMOHAdvanced2Span"/></span></td><td><input type="text" name="tAllowanceDMOHSpent" id="tAllowanceDMOHSpent2" value="<?php echo $tAllowanceDMOHSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDMOHSpent2Span"/></span></td><td><input type="text" id="tAllowanceDMOHVariance2" name="tAllowanceDMOHVariance" value="<?php echo $tAllowanceDMOHVariance=abs($tAllowanceDMOHAdvanced-$tAllowanceDMOHSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDMOHVariance2Span"/></span></td>
				
				</tr>
					<tr>
				<td>6</td><td>Airtime for DMOH</td><td><input type="text" name="airTimeDMOHAdvanced" id="airTimeDMOHAdvanced2" value="<?php echo $airTimeDMOHAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDMOHAdvanced2Span"/></span></td><td><input type="text" id="airTimeDMOHSpent2" name="airTimeDMOHSpent" value="<?php echo $airTimeDMOHSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDMOHSpent2Span"/></span></td><td><input type="text" id="airTimeDMOHVariance2" name="airTimeDMOHVariance" value="<?php echo $airTimeDMOHVariance=abs($airTimeDMOHAdvanced-$airTimeDMOHSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDMOHVariance2Span"/></span></td>
				
				</tr>
					<tr>
				<td>7</td><td>Facilitation Allowance for DMOH</td><td><input type="text" id="facilitationAllowanceAdvanced2" name="facilitationAllowanceAdvanced" value="<?php echo $facilitationAllowanceAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationAllowanceAdvanced2Span"/></span></td><td><input type="text" name="facilitationAllowanceSpent" id="facilitationAllowanceSpent2" value="<?php echo $facilitationAllowanceSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationAllowanceSpent2Span"/></span></td><td><input type="text" name="facilitationAllowanceVariance" id="facilitationAllowanceVariance2" value="<?php echo $facilitationAllowanceVariance=abs($facilitationAllowanceAdvanced-$facilitationAllowanceSpent);?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationAllowanceVariance2Span"/></span></td>
				
				</tr>
					<tr>
				<td>8</td><td>Transport Allowance for District Level Personnel</td><td><input type="text" id="tAllowanceDistrictLevelAdvanced2" name="tAllowanceDistrictLevelAdvanced" value="<?php echo $tAllowanceDistrictLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDistrictLevelAdvanced2Span"/></span></td><td><input type="text" id="tAllowanceDistrictLevelSpent2" name="tAllowanceDistrictLevelSpent" value="<?php echo $tAllowanceDistrictLevelSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDistrictLevelSpent2Span"/></span></td><td><input type="text" id="tAllowanceDistrictLevelVariance2" name="tAllowanceDistrictLevelVariance" value="<?php echo $tAllowanceDistrictLevelVariance=abs($tAllowanceDistrictLevelAdvanced-$tAllowanceDistrictLevelSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDistrictLevelVariance2Span"/></span></td>
				
				</tr>
					<tr>
				<td>9</td><td>Airtime Allowance for District Level Personnel</td><td><input type="text" id="airAllowanceDistrictLevelAdvanced2" name="airAllowanceDistrictLevelAdvanced" value="<?php echo $airAllowanceDistrictLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="airAllowanceDistrictLevelAdvanced2Span"/></span></td><td><input type="text" id="airAllowanceDistrictLevelSpent2" name="airAllowanceDistrictLevelSpent" value="<?php echo $airAllowanceDistrictLevelSpent;?>" onKeyUp="isNumeric(this.id);"/><span id="airAllowanceDistrictLevelSpent2Span"/></span></td><td><input type="text" id="airAllowanceDistrictLevelVariance2" name="airAllowanceDistrictLevelVariance" value="<?php echo $airAllowanceDistrictLevelVariance=abs($airAllowanceDistrictLevelAdvanced-$airAllowanceDistrictLevelSpent); ?>"  onKeyUp="isNumeric(this.id);"/><span id="airAllowanceDistrictLevelVariance2Span"/></span></td>
				
				</tr>
					
					<tr>
				<td>10</td><td>Transport Allowance for Division Level Personnel</td><td><input type="text" id="tAllowanceDivLevelAdvanced2" name="tAllowanceDivLevelAdvanced" value="<?php echo $tAllowanceDivLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDivLevelAdvanced2Span"/></span></td><td><input type="text" id="tAllowanceDivLevelSpent2" name="tAllowanceDivLevelSpent" value="<?php echo $tAllowanceDivLevelSpent ?>" /></td><td><input type="text" name="tAllowanceDivLevelVariance" id="tAllowanceDivLevelVariance2" value="<?php echo $tAllowanceDivLevelVariance=abs($tAllowanceDivLevelAdvanced-$tAllowanceDivLevelSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="tAllowanceDivLevelVariance2Span"/></span></td>
				
				</tr>
				<tr>
				<td>11</td><td>Bank Charges</td><td><input type="text" id="bankChargesAdvanced2" name="bankChargesAdvanced" value="<?php echo $bankChargesAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="bankChargesAdvanced2Span"/></span></td><td><input type="text" id="bankChargesSpent2" name="bankChargesSpent" value="<?php echo $bankChargesSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="bankChargesSpent2Span"/></span></td><td><input type="text" name="bankChargesVariance" id="bankChargesVariance2" value="<?php echo $bankChargesVariance=abs($bankChargesAdvanced-$bankChargesSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="bankChargesVariance2Span"/></span></td>
				
				</tr>
				<tr>
				<td>12</td><td>G4s Courier</td><td><input type="text" id="courierAdvanced2" name="courierAdvanced" value="<?php echo $courierAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="courierAdvanced2Span"/></span></td><td><input type="text" id="courierSpent2" name="courierSpent" value="<?php echo $courierSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="courierSpent2Span"/></span></td><td><input type="text" id="courierVariance2" name="courierVariance" value="<?php echo $courierVariance=abs($courierAdvanced-$courierSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="courierVariance2Span"/></span></td>
				
				</tr>
					<tr>
				<td>13</td><td>Other Allowances</td><td><input type="text" id="otherAllowancesAdvanced11" name="otherAllowancesAdvanced1" value="<?php echo $otherAllowancesAdvanced1; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesAdvanced11Span"/></span></td><td><input type="text" id="otherAllowancesSpent11" name="otherAllowancesSpent1" value="<?php echo $otherAllowancesSpent1; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesSpent11Span"/></span></td><td><input type="text" id="otherAllowancesVariance11" name="otherAllowancesVariance1" value="<?php echo $otherAllowancesVariance1=abs($otherAllowancesAdvanced1-$otherAllowancesSpent1); ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesVariance11Span"/></span></td>
				
				</tr>
					<tr>
				<td>14</td><td>Other Allowances</td><td><input type="text" id="otherAllowancesAdvanced22" name="otherAllowancesAdvanced2" value="<?php echo $otherAllowancesAdvanced2; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesAdvanced22Span"/></span></td><td><input type="text" id="otherAllowancesSpent22" name="otherAllowancesSpent2" value="<?php echo $otherAllowancesSpent2; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesSpent22Span"/></span></td><td><input type="text" id="otherAllowancesVariance22" name="otherAllowancesVariance2" value="<?php echo $otherAllowancesVariance2=abs($otherAllowancesAdvanced2-$otherAllowancesSpent2); ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesVariance22Span"/></span></td>
				
				</tr>
					<tr>
				<td>15</td><td>Other Allowances</td><td><input type="text" id="otherAllowancesAdvanced33" name="otherAllowancesAdvanced3" value="<?php echo $otherAllowancesAdvanced3; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesAdvanced33Span"/></span></td><td><input type="text" id="otherAllowancesSpent33" name="otherAllowancesSpent3" value="<?php echo $otherAllowancesSpent3; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesSpent33Span"/></span></td><td><input type="text" id="otherAllowancesVariance33" name="otherAllowancesVariance3" value=" <?php echo $otherAllowancesVariance3=abs($otherAllowancesAdvanced3-$otherAllowancesSpent3); ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesVariance33Span"/></span></td>
				
				</tr>
				
				<tr>
				<td>16</td><td><b>Total Amount</b></td><td><input type="text" id="totalAmountAdvanced" name="totalAmountAdvanced" value="<?php echo $totalAmountAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="totalAmountAdvancedSpan"/></span></td><td><input type="text" id="totalAmountSpent" name="totalAmountSpent" value="<?php echo $totalAmountSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="totalAmountSpentSpan"/></span></td><td><input type="text" id="totalAmountVariance" name="totalAmountVariance" value="<?php echo $totalAmountVariance=abs($totalAmountAdvanced-$totalAmountSpent); ?>" onKeyUp="isNumeric(this.id);"/><span id="totalAmountVarianceSpan"/></span></td>
				</tr>
				<tr>
				
				<td>Remarks</td>
				<td colspan="2"><textarea colspan="2" name="remarks"><?php echo $remarks; ?></textarea></td>
				
				</tr>
				</tbody>
				</table>
				
				
				
				
</div>
