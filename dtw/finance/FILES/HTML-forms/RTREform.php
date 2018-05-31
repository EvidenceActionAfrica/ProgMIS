<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once("../includes/function_convert_number_to_words.php");
$tabActive="tab1";

$name=isset($_POST["receiver_name"])?$_POST["receiver_name"]:"";

$coordinationAllowanceDEOAdvanced=isset($_POST["coordinationAllowanceDEOAdvanced"])?$_POST["coordinationAllowanceDEOAdvanced"]:"";
$coordinationAllowanceDEOSpent=isset($_POST["coordinationAllowanceDEOSpent"])?$_POST["coordinationAllowanceDEOSpent"]:"";

$transportDEOAdvanced=isset($_POST["transportDEOAdvanced"])?mysql_real_escape_string($_POST["transportDEOAdvanced"]):"";
$transportDEOSpent=isset($_POST["transportDEOSpent"])?mysql_real_escape_string($_POST["transportDEOSpent"]):"";

$airTimeDEOAdvanced=isset($_POST["airTimeDEOAdvanced"])?mysql_real_escape_string($_POST["airTimeDEOAdvanced"]):"";
$airTimeDEOSpent=isset($_POST["airTimeDEOSpent"])?mysql_real_escape_string($_POST["airTimeDEOSpent"]):"";

$facilitationAllowanceAdvanced=isset($_POST["facilitationAllowanceAdvanced"])?mysql_real_escape_string($_POST["facilitationAllowanceAdvanced"]):"";
$facilitationAllowanceSpent=isset($_POST["facilitationAllowanceSpent"])?mysql_real_escape_string($_POST["facilitationAllowanceSpent"]):"";

$secretaryAllowanceDEOAdvanced=isset($_POST["secretaryAllowanceDEOAdvanced"])?mysql_real_escape_string($_POST["secretaryAllowanceDEOAdvanced"]):"";
$secretaryAllowanceDEOSpent=isset($_POST["secretaryAllowanceDEOSpent"])?mysql_real_escape_string($_POST["secretaryAllowanceDEOSpent"]):"";

$transportDistrictlevelAdvanced=isset($_POST["transportDistrictlevelAdvanced"])?mysql_real_escape_string($_POST["transportDistrictlevelAdvanced"]):"";
$transportDistrictlevelSpent=isset($_POST["transportDistrictlevelSpent"])?mysql_real_escape_string($_POST["transportDistrictlevelSpent"]):"";

$airTimeDistrictLevelAllowanceAdvanced=isset($_POST["airTimeDistrictLevelAllowanceAdvanced"])?mysql_real_escape_string($_POST["airTimeDistrictLevelAllowanceAdvanced"]):"";
$airTimeDistrictLevelAllowanceSpent=isset($_POST["airTimeDistrictLevelAllowanceSpent"])?mysql_real_escape_string($_POST["airTimeDistrictLevelAllowanceSpent"]):"";

$transportDivLevelAdvanced=isset($_POST["transportDivLevelAdvanced"])?mysql_real_escape_string($_POST["transportDivLevelAdvanced"]):"";
$transportDivLevelSpent=isset($_POST["transportDivLevelSpent"])?mysql_real_escape_string($_POST["transportDivLevelSpent"]):"";

$hallRentalAdvanced=isset($_POST["hallRentalAdvanced"])?mysql_real_escape_string($_POST["hallRentalAdvanced"]):"";
$hallRentalSpent=isset($_POST["hallRentalSpent"])?mysql_real_escape_string($_POST["hallRentalSpent"]):"";

$projectorHireAdvanced=isset($_POST["projectorHireAdvanced"])?mysql_real_escape_string($_POST["projectorHireAdvanced"]):"";
$projectorHireSpent=isset($_POST["projectorHireSpent"])?mysql_real_escape_string($_POST["projectorHireSpent"]):"";
$mealsAdvanced=isset($_POST["mealsAdvanced"])?mysql_real_escape_string($_POST["mealsAdvanced"]):"";
$mealsSpent=isset($_POST["mealsSpent"])?mysql_real_escape_string($_POST["mealsSpent"]):"";
$writingMaterialsAdvanced=isset($_POST["writingMaterialsAdvanced"])?mysql_real_escape_string($_POST["writingMaterialsAdvanced"]):"";
$writingMaterialsSpent=isset($_POST["writingMaterialsSpent"])?mysql_real_escape_string($_POST["writingMaterialsSpent"]):"";
$flipChartAdvanced=isset($_POST["flipChartAdvanced"])?mysql_real_escape_string($_POST["flipChartAdvanced"]):"";
$flipChartSpent=isset($_POST["flipChartSpent"])?mysql_real_escape_string($_POST["flipChartSpent"]):"";
$bankChargesAdvanced=isset($_POST["bankChargesAdvanced"])?mysql_real_escape_string($_POST["bankChargesAdvanced"]):"";
$bankChargesSpent=isset($_POST["bankChargesSpent"])?mysql_real_escape_string($_POST["bankChargesSpent"]):"";
$courierAdvanced=isset($_POST["courierAdvanced"])?mysql_real_escape_string($_POST["courierAdvanced"]):"";
$courierSpent=isset($_POST["courierSpent"])?mysql_real_escape_string($_POST["courierSpent"]):"";
$otherAllowancesAdvanced=isset($_POST["otherAllowancesAdvanced"])?mysql_real_escape_string($_POST["otherAllowancesAdvanced"]):"";
$otherAllowancesSpent=isset($_POST["otherAllowancesSpent"])?mysql_real_escape_string($_POST["otherAllowancesSpent"]):"";
$remarks=isset($_POST["remarks"])?mysql_real_escape_string($_POST["remarks"]):"";
$preparedBy=isset($_POST["preparedBy"])?mysql_real_escape_string($_POST["preparedBy"]):"";
$totalAmountAdvanced=isset($_POST["totalAmountAdvanced"])?mysql_real_escape_string($_POST["totalAmountAdvanced"]):"";
$totalAmountSpent=isset($_POST["totalAmountSpent"])?mysql_real_escape_string($_POST["totalAmountSpent"]):"";

$amount_words=isset($_POST["totalAmountSpent"])?strToUpper(convert_number_to_words($_POST["totalAmountSpent"]).' Shillings'):"";

$date=date("Y-m-d");

if($_POST["saveRecord"]){
$tabActive="tab2";
$sql="INSERT INTO `fin_budget_rtre`(`name`, `date`, `amount_words`, `cord_allowance_adv`, `cord_allowance_spent`,";
$sql.=" `transport_deo_advanced`, `transport_deo_spent`, `airTime_deo_allowance`, `airTime_deo_spent`, `facilitation_allowance_deo_adv`,";
$sql.=" `facilitation_allowance_spent`, `secretary_allowance_deo_adv`, `secretary_allowance_deo_spent`, `transport_dlp_adv`,";
$sql.=" `transport_dlp_spent`, `airTime_dlp_adv`, `airTime_dlp_spent`, `transport_divlp_adv`, `transport_divlp_spent`, `hall_rental_adv`,";
$sql.=" `hall_rental_spent`, `project_hire_adv`, `project_hire_spent`, `meals_adv`, `meals_spent`, `writing_materials_adv`,";
$sql.=" `writing_materials_spent`, `flip_adv`, `flip_spent`, `bank_charges_adv`, `bank_charges_spent`, `courier_adv`, `courier_spent`,";
$sql.=" `other_allowances_adv`, `other_allowances_spent`, `total_amount_adv`, `total_amount_spent`, `remarks`, `preparedBy`)";

$sql.=" VALUES ('$name','$date','$amount_words','$coordinationAllowanceDEOAdvanced','$coordinationAllowanceDEOSpent','$transportDEOAdvanced'";
$sql.=",'$transportDEOSpent','airTimeDEOAdvanced','$airTimeDEOSpent','$facilitationAllowanceAdvanced',";

$sql.="'$facilitationAllowanceSpent','$secretaryAllowanceDEOAdvanced','$secretaryAllowanceDEOSpent','$transportDistrictlevelAdvanced','$transportDistrictlevelSpent',";
$sql.="'$airTimeDistrictLevelAllowanceAdvanced','$airTimeDistrictLevelAllowanceSpent','$transportDivLevelAdvanced','$transportDivLevelSpent','$hallRentalAdvanced','$hallRentalSpent',";

$sql.="'$projectorHireAdvanced','$projectorHireSpent','$mealsAdvanced','$mealsSpent','$writingMaterialsAdvanced','$writingMaterialsSpent',";
$sql.="'$flipChartAdvanced','$flipChartSpent','$bankChargesAdvanced','$bankChargesSpent','$courierAdvanced',";

$sql.="'$courierSpent','$otherAllowancesAdvanced','$otherAllowancesSpent','$totalAmountAdvanced','$totalAmountSpent','$remarks','$preparedBy')";

//echo $sql;
mysql_query($sql) or die(mysql_error());
}
if(isset($_GET["deleteid"])){
	$tabActive="tab2";
$id=$_GET["deleteid"];
$sql="DELETE from fin_budget_rtre where form_id='$id'";

mysql_query($sql);
}

if($_POST["updateRecord"]){
$tabActive="tab2";
$id=$_GET["id"];
$sql="UPDATE `fin_budget_rtre` SET `name`='$name',`date`='$date',`amount_words`='$amountWords',`cord_allowance_adv`='$coordinationAllowanceDEOAdvanced',";
$sql.="`cord_allowance_spent`='$coordinationAllowanceDEOSpent',`transport_deo_advanced`='$transportDEOAdvanced',`transport_deo_spent`='$transportDEOSpent',`airTime_deo_allowance`='$airTimeDEOAdvanced',";
$sql.="`airTime_deo_spent`='$airTimeDEOSpent',`facilitation_allowance_deo_adv`='$facilitationAllowanceAdvanced',`facilitation_allowance_spent`='$facilitationAllowanceSpent',";
$sql.="`secretary_allowance_deo_adv`='$secretaryAllowanceDEOAdvanced',`secretary_allowance_deo_spent`='$secretaryAllowanceDEOSpent',`transport_dlp_adv`='$transportDistrictlevelAdvanced',";
$sql.="`transport_dlp_spent`='$transportDistrictlevelSpent',`airTime_dlp_adv`='$airTimeDistrictLevelAllowanceAdvanced',`airTime_dlp_spent`='$airTimeDistrictLevelAllowanceSpent',`transport_divlp_adv`='$transportDivLevelAdvanced',";
$sql.="`transport_divlp_spent`='$transportDivLevelSpent',`hall_rental_adv`='$hallRentalAdvanced',`hall_rental_spent`='$hallRentalSpent',`project_hire_adv`='$projectorHireAdvanced',";
$sql.="`project_hire_spent`='$projectorHireSpent',`meals_adv`='$mealsAdvanced',`meals_spent`='$mealsSpent',`writing_materials_adv`='$writingMaterialsAdvanced',";
$sql.="`writing_materials_spent`='$writingMaterialsSpent',`flip_adv`='$flipChartAdvanced',`flip_spent`='$flipChartSpent',`bank_charges_adv`='$bankChargesAdvanced',";
$sql.="`bank_charges_spent`='$bankChargesSpent',`courier_adv`='$courierAdvanced',`courier_spent`='$courierSpent',`other_allowances_adv`='$otherAllowancesAdvanced',";
$sql.="`other_allowances_spent`='$otherAllowancesSpent',`total_amount_adv`='$totalAmountAdvanced',`total_amount_spent`='$totalAmountSpent',`remarks`='$remarks',";
$sql.="`preparedBy`='$preparedBy' WHERE `form_id`='$id'";




//echo $sql;

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
						<td>Name</td><td><input type="text" id="receiver_name" name="receiver_name" value="<?php echo $name; ?>" /></td>
						<td>Date</td><td><input type="text" id="date" name="date" value="<?php echo $date; ?>"  readonly/></td>
                     </tr>
					 <tr>
					 <td></td>
					 </tr>
					 <tr>
					 <td>Amount(Words)</td><td><input type="text" name="amount" value=""  readonly/></td>
					 </tr>
					 </thead>
				</table>
				
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
				<td></td><td>Amount forwarded to your district</td>
				</tr>
				<tr>
<td>1</td><td>Coordination Allowance for DEO</td><td><input type="text" id="coordinationAllowanceDEOAdvanced" name="coordinationAllowanceDEOAdvanced" value="<?php echo $coordinationAllowanceDEOAdvanced ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDEOAdvancedSpan"/></span></td><td><input type="text" id="coordinationAllowanceDEOSpent" name="coordinationAllowanceDEOSpent" value="<?php echo $coordinationAllowanceDEOSpent ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDEOSpentSpan"/></span></td><td><input type="text" id="coordinationAllowanceDEOVariance" name="coordinationAllowanceDEOVariance" value="<?php echo $coordinationAllowanceDEOVariance; ?>"onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDEOVarianceSpan"/></span></td>
				</tr>
				<tr>
				<td>2</td><td>Transport for DEO</td><td><input type="text" id="transportDEOAdvanced" name="transportDEOAdvanced" value="<?php echo $transportDEOAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportDEOAdvancedSpan"/></span></td><td><input type="text" id="transportDEOSpent" name="transportDEOSpent" value="<?php echo $transportDEOSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportDEOSpentSpan"/></span></td><td><input type="text" id="transportDEOVariance" name="transportDEOVariance" value="<?php echo $transportDEOVariance; ?>"  onKeyUp="isNumeric(this.id);"/><span id="transportDEOVarianceSpan"/></span></td>
				
				</tr>
				<tr>
				<td>3</td><td>AirTime for DEO</td><td><input type="text" id="airTimeDEOAdvanced" name="airTimeDEOAdvanced" value="<?php echo $airTimeDEOAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDEOAdvancedSpan"/></span></td><td><input type="text" id="airTimeDEOSpent" name="airTimeDEOSpent" value="<?php echo $airTimeDEOSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDEOSpentSpan"/></span></td><td><input type="text" id="airTimeDEOVariance" name="airTimeDEOVariance" value="<?php echo $airTimeDEOVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDEOVarianceSpan"/></span></td>
				
				</tr>
				<tr>
				<td>4</td><td>Facilitation Allowance for DEO</td><td><input type="text" id="facilitationAllowanceAdvanced" name="facilitationAllowanceAdvanced" value="<?php echo $facilitationAllowanceAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationAllowanceAdvancedSpan"/></span></td><td><input type="text" id="facilitationAllowanceSpent" name="facilitationAllowanceSpent" value="<?php echo $facilitationAllowanceSpent;?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationAllowanceSpentSpan"/></span></td><td><input type="text" id="facilitationAllowanceVariance" name="facilitationAllowanceVariance" value="<?php echo $facilitationAllowanceVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationAllowanceVarianceSpan"/></span></td>
			</tr>
				<tr>
				<td>5</td><td>Secretary Allowance for DEO</td><td><input type="text" id="secretaryAllowanceDEOAdvanced" name="secretaryAllowanceDEOAdvanced" value="<?php echo $secretaryAllowanceDEOAdvanced;?>" onKeyUp="isNumeric(this.id);"/><span id="secretaryAllowanceDEOAdvancedSpan"/></span></td><td><input type="text" id="secretaryAllowanceDEOSpent" name="secretaryAllowanceDEOSpent" value="<?php echo $secretaryAllowanceDEOSpent;?>" onKeyUp="isNumeric(this.id);"/><span id="secretaryAllowanceDEOSpentSpan"/></span></td><td><input type="text" id="secretaryAllowanceDEOVariance"  name="secretaryAllowanceDEOVariance" value="<?php echo $secretaryAllowanceDEOVariance;?>" onKeyUp="isNumeric(this.id);"/><span id="secretaryAllowanceDEOVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>6</td><td>Transport for District Level Personnel</td><td><input type="text" id="transportDistrictlevelAdvanced"  name="transportDistrictlevelAdvanced" value="<?php echo $transportDistrictlevelAdvanced ?>" onKeyUp="isNumeric(this.id);"/><span id="transportDistrictlevelAdvancedSpan"/></span></td><td><input type="text" id="transportDistrictlevelSpent" name="transportDistrictlevelSpent" value="<?php echo $transportDistrictlevelSpent;?>" onKeyUp="isNumeric(this.id);"/><span id="transportDistrictlevelSpentSpan"/></span></td><td><input type="text" id="transportDistrictlevelVariance" name="transportDistrictlevelVariance" value="<?php echo $transportDistrictlevelVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportDistrictlevelVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>7</td><td>Airtime for District Level Personnel</td><td><input type="text" id="airTimeDistrictLevelAllowanceAdvanced" name="airTimeDistrictLevelAllowanceAdvanced" value="<?php echo $airTimeDistrictLevelAllowanceAdvanced;?> " onKeyUp="isNumeric(this.id);"/><span id="airTimeDistrictLevelAllowanceAdvancedSpan"/></span></td><td><input type="text" id="airTimeDistrictLevelAllowanceSpent" name="airTimeDistrictLevelAllowanceSpent" value="<?php echo $airTimeDistrictLevelAllowanceSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDistrictLevelAllowanceSpentSpan"/></span></td><td><input type="text" id="airTimeDistrictLevelAllowanceVariance"  name="airTimeDistrictLevelAllowanceVariance" value="<?php echo $airTimeDistrictLevelAllowanceVariance;?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDistrictLevelAllowanceVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>8</td><td>Transport for Division Level Personnel</td><td><input type="text" id="transportDivLevelAdvanced" name="transportDivLevelAdvanced" value="<?php echo $transportDivLevelAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="transportDivLevelAdvancedSpan"/></span></td><td><input type="text" id="transportDivLevelSpent" name="transportDivLevelSpent" value="<?php echo $transportDivLevelSpent;?>"  onKeyUp="isNumeric(this.id);"/><span id="transportDivLevelSpentSpan"/></span></td><td><input type="text" id="transportDivLevelVariance" name="transportDivLevelVariance" value="<?php echo $transportDivLevelVariance;?>"  onKeyUp="isNumeric(this.id);"/><span id="transportDivLevelVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>9</td><td>Hall Rental</td><td><input type="text" id="hallRentalAdvanced" name="hallRentalAdvanced" value="<?php echo $hallRentalAdvanced;?>"  onKeyUp="isNumeric(this.id);"/><span id="hallRentalAdvancedSpan"/></span></td><td><input type="text" id="hallRentalSpent" name="hallRentalSpent" value="<?php echo $hallRentalSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="hallRentalSpentSpan"/></span></td><td><input type="text" id="hallRentalVariance" name="hallRentalVariance" value="<?php echo $hallRentalVariance; ?>"  onKeyUp="isNumeric(this.id);"/><span id="hallRentalVarianceSpan"/></span></td>
				
				</tr>
					
					<tr>
				<td>10</td><td>Projector Hire</td><td><input type="text" id="projectorHireAdvanced" name="projectorHireAdvanced" value="<?php echo $projectorHireAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="projectorHireAdvancedSpan"/></span></td><td><input type="text" id="projectorHireSpent" name="projectorHireSpent" value="<?php echo $projectorHireSpent;?>"  onKeyUp="isNumeric(this.id);"/><span id="projectorHireSpentSpan"/></span></td><td><input type="text" id="projectorHireVariance" name="projectorHireVariance" value="<?php echo $projectorHireVariance;?>"  onKeyUp="isNumeric(this.id);"/><span id="projectorHireVarianceSpan"/></span></td>
				
				</tr>
				<tr>
				<td>11</td><td>Meals(Tea,Snacks,Lunch)</td><td><input type="text" id="mealsAdvanced" name="mealsAdvanced" value="<?php echo $mealsAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="mealsAdvancedSpan"/></span></td><td><input type="text" id="mealsSpent" name="mealsSpent" value="<?php echo $mealsSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="mealsSpentSpan"/></span></td><td><input type="text" id="mealsVariance" name="mealsVariance" value="<?php echo $mealsVariance; ?>"  onKeyUp="isNumeric(this.id);"/><span id="mealsVarianceSpan"/></span></td>
				
				</tr>
				<tr><td>12</td>
				<td>Writing Materials</td><td><input type="text" id="writingMaterialsAdvanced" name="writingMaterialsAdvanced" value="<?php echo $writingMaterialsAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="writingMaterialsAdvancedSpan"/></span></td><td><input type="text" id="writingMaterialsSpent" name="writingMaterialsSpent" value="<?php echo $writingMaterialsSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="writingMaterialsSpentSpan"/></span></td><td><input type="text" id="writingMaterialsVariance"  name="writingMaterialsVariance" value="<?php echo $writingMaterialsVariance; ?>"  onKeyUp="isNumeric(this.id);"/><span id="writingMaterialsVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>13</td><td>Flip chart Paper & Markers</td><td><input type="text" id="flipChartAdvanced" name="flipChartAdvanced" value="<?php echo $flipChartAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="flipChartAdvancedSpan"/></span></td><td><input type="text" id="flipChartSpent" name="flipChartSpent" value="<?php echo $flipChartSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="flipChartSpentSpan"/></span></td><td><input type="text" id="flipChartVariance" name="flipChartVariance" value="<?php echo $flipChartVariance;?>"  onKeyUp="isNumeric(this.id);"/><span id="flipChartVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>14</td><td>Bank Charges</td><td><input type="text" id="bankChargesAdvanced" name="bankChargesAdvanced" value="<?php echo $bankChargesAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="bankChargesAdvancedSpan"/></span></td><td><input type="text" id="bankChargesSpent"  name="bankChargesSpent" value="<?php echo $bankChargesSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="bankChargesSpentSpan"/></span></td><td><input type="text" name="bankChargesVariance" value="<?php echo $bankChargesVariance;?>"  onKeyUp="isNumeric(this.id);"/><span id="bankChargesVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>15</td><td>G4s Courier</td><td><input type="text" id="courierAdvanced" name="courierAdvanced" value="<?php echo $courierAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="courierAdvancedSpan"/></span></td><td><input type="text" id="courierSpent" name="courierSpent" value="<?php echo $courierSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="courierSpentSpan"/></span></td><td><input type="text" id="courierVariance" name="courierVariance" value="<?php echo $courierVariance;?>"  onKeyUp="isNumeric(this.id);"/><span id="courierVarianceSpan"/></span></td>
				
				</tr>
				
					<tr>
				<td>16</td><td>Other Allowances</td><td><input type="text" id="otherAllowancesAdvanced" name="otherAllowancesAdvanced" value="<?php echo $otherAllowancesAdvanced;?>"  onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesAdvancedSpan"/></span></td><td><input type="text" id="otherAllowancesSpent" name="otherAllowancesSpent" value="<?php echo $otherAllowancesSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesSpentSpan"/></span></td><td><input type="text" id="otherAllowancesVariance" name="otherAllowancesVariance" value="<?php echo $otherAllowancesVariance;?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesVarianceSpan"/></span></td>
				
				</tr>
				
				
				<tr>
				<td>17</td><td><b>Total Amount</b></td><td><input type="text" id="totalAmountAdvanced" name="totalAmountAdvanced" value="<?php echo $totalAmountAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="totalAmountAdvancedSpan"/></span></td><td><input type="text" id="totalAmountSpent"  name="totalAmountSpent" value="<?php echo $totalAmountSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="totalAmountSpentSpan"/></span></td><td><input type="text"  id="totalAmountVariance"  name="totalAmountVariance" value="<?php echo $totalAmountVariance;?>"  onKeyUp="isNumeric(this.id);"/><span id="totalAmountVarianceSpan"/></span></td>
				</tr>
				<tr>
				
				
				<td colspan="4">Remarks<textarea colspan="4" name="remarks"><?php echo $remarks; ?></textarea></td>
				
				</tr>
				</tbody>
				</table>
				<div style="margin-left:45%; margin-top:3%;">
				<label for="preparedBy">Prepared By</label>
				<select name="preparedBy">
			<option selected="selected" value="<?php echo $preparedBy; ?>"><?php echo $preparedBy; ?></option>
			   
			  <?php 
				$sql="select staff_name from staff";
				$results=mysql_query($sql);
				while($row=mysql_fetch_array($results)){
			  echo "<option>".$row["staff_name"]."</option>";
			  }
			  ?>
			  	</select>
				</br></br></br></br>
				<input type="submit" class="btn btn-success" name="saveRecord" value="Save Details" />
				</div>
				</form>
				
				
				
              
				
           			 </div>
            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>"  id="tab2">

      	 <h1 style="text-align: center; margin-top: 0px; font-size: 20px">View Reconciliation Forms</h1>
                  
                    <form method="post" style=" ">
                      <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                        <thead>
                          <tr style="border: 1px solid #B4B5B0;">
                            <th align="Left" width="10px">ID</th>
                            <th align="Left" width="20px">Name</th>
                            <th align="Left" width="20px">Amount</th>
                            
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

                                $result_display = mysql_query("SELECT * FROM fin_budget_rtre where form_id like '%$id%'");

                                while ($row = mysql_fetch_array($result_display)) {
                                
$name=$row["name"];

$id=$row["form_id"];
 $date=$row["date"];
$coordinationAllowanceDEOAdvanced=isset($row["cord_allowance_adv"])?$row["cord_allowance_adv"]:"";
$coordinationAllowanceDEOSpent=isset($row["cord_allowance_spent"])?$row["cord_allowance_spent"]:"";

$transportDEOAdvanced=isset($row["transport_deo_advanced"])?$row["transport_deo_advanced"]:"";
$transportDEOSpent=isset($row["transport_deo_spent"])?$row["transport_deo_spent"]:"";

$airTimeDEOAdvanced=isset($row["airTime_deo_allowance"])?$row["airTime_deo_allowance"]:"";
$airTimeDEOSpent=isset($row["airTime_deo_spent"])?$row["airTime_deo_spent"]:"";

$facilitationAllowanceAdvanced=isset($row["facilitation_allowance_deo_adv"])?$row["facilitation_allowance_deo_adv"]:"";
$facilitationAllowanceSpent=isset($row["facilitation_allowance_spent"])?$row["facilitation_allowance_spent"]:"";

$secretaryAllowanceDEOAdvanced=isset($row["secretary_allowance_deo_adv"])?$row["secretary_allowance_deo_adv"]:"";
$secretaryAllowanceDEOSpent=isset($row["secretary_allowance_deo_spent"])?$row["secretary_allowance_deo_spent"]:"";

$transportDistrictlevelAdvanced=isset($row["transport_dlp_adv"])?$row["transport_dlp_adv"]:"";
$transportDistrictlevelSpent=isset($row["transport_dlp_spent"])?$row["transport_dlp_spent"]:"";

$airTimeDistrictLevelAllowanceAdvanced=isset($row["airTime_dlp_adv"])?$row["airTime_dlp_adv"]:"";
$airTimeDistrictLevelAllowanceSpent=isset($row["airTime_dlp_spent"])?$row["airTime_dlp_spent"]:"";

$transportDivLevelAdvanced=isset($row["transport_divlp_adv"])?$row["transport_divlp_adv"]:"";
$transportDivLevelSpent=isset($row["transport_divlp_spent"])?$row["transport_divlp_spent"]:"";

$hallRentalAdvanced=isset($row["hall_rental_adv"])?$row["hall_rental_adv"]:"";
$hallRentalSpent=isset($row["hall_rental_spent"])?$row["hall_rental_spent"]:"";

$projectorHireAdvanced=isset($row["project_hire_adv"])?$row["project_hire_adv"]:"";
$projectorHireSpent=isset($row["project_hire_spent"])?$row["project_hire_spent"]:"";
$mealsAdvanced=isset($row["meals_adv"])?$row["meals_adv"]:"";
$mealsSpent=isset($row["meals_spent"])?$row["meals_spent"]:"";
$writingMaterialsAdvanced=isset($row["writing_materials_adv"])?$row["writing_materials_spent"]:"";
$writingMaterialsSpent=isset($row["writing_materials_spent"])?$row["writing_materials_spent"]:"";
$flipChartAdvanced=isset($row["flip_adv"])?$row["flip_adv"]:"";
$flipChartSpent=isset($row["flip_spent"])?$row["flip_spent"]:"";
$bankChargesAdvanced=isset($row["bank_charges_adv"])?$row["bank_charges_adv"]:"";
$bankChargesSpent=isset($row["bank_charges_spent"])?$row["bank_charges_spent"]:"";
$courierAdvanced=isset($row["courier_adv"])?$row["courier_adv"]:"";
$courierSpent=isset($row["courier_spent"])?$row["courier_spent"]:"";
$otherAllowancesAdvanced=isset($row["other_allowances_adv"])?$row["other_allowances_adv"]:"";
$otherAllowancesSpent=isset($row["other_allowances_spent"])?$row["other_allowances_spent"]:"";
$remarks=isset($row["remarks"])?$row["remarks"]:"";
$preparedBy=isset($row["preparedBy"])?$row["preparedBy"]:"";
$totalAmountAdvanced=isset($row["total_amount_adv"])?$row["total_amount_adv"]:"";
$totalAmountSpent=isset($row["total_amount_spent"])?$row["total_amount_spent"]:"";
$amountWords==isset($row["amount_words"])?$row["amount_words"]:"";
                             
//Variance


$otherAllowancesVariance=abs($otherAllowancesAdvanced-$otherAllowancesSpent);
$courierVariance=abs($courierAdvanced-$courierSpent);
$bankChargesVariance=abs($bankChargesAdvanced-$bankChargesSpent);
$transportDivLevelVariance=abs($transportDivLevelAdvanced-$transportDivLevelSpent);
$projectorHireVariance=abs($projectorHireAdvanced-$projectorHireSpent);
$mealsVariance=abs($mealsAdvanced-$mealsSpent);
$writingMaterialsVariance=abs($writingMaterialsAdvanced-$writingMaterialsSpent);
$flipChartVariance=abs($flipChartAdvanced-$flipChartSpent);
$hallRentalVariance=abs($hallRentalAdvanced-$hallRentalSpent);
$transportDistrictlevelVariance=abs($transportDistrictlevelAdvanced-$transportDistrictlevelSpent);
$airTimeDEOVariance=abs($airTimeDEOAdvanced-$airTimeDEOSpent);
$airTimeDistrictLevelAllowanceVariance=abs($airTimeDistrictLevelAllowanceAdvanced-$airTimeDistrictLevelAllowanceSpent);
$secretaryAllowanceDEOVariance=abs($secretaryAllowanceDEOAdvanced-$secretaryAllowanceDEOSpent);
$facilitationAllowanceVariance=abs($facilitationAllowanceAdvanced-$facilitationAllowanceSpent);
$transportDEOVariance=abs($transportDEOAdvanced-$transportDEOSpent);
$coordinationAllowanceDEOVariance=abs($coordinationAllowanceDEOAdvanced-$coordinationAllowanceDEOSpent);

//Totals
$totalAmountAdvanced=$otherAllowancesAdvanced+$courierAdvanced+$bankChargesAdvanced+$transportDEOAdvanced+$transportDivLevelAdvanced+$projectorHireAdvanced
+$mealsAdvanced+$writingMaterialsAdvanced+$flipChartAdvanced+$hallRentalAdvanced+$airTimeDistrictLevelAllowanceAdvanced+$secretaryAllowanceDEOAdvanced+
$facilitationAllowanceAdvanced+$coordinationAllowanceDEOAdvanced;


$totalAmountSpent=$otherAllowancesSpent+$courierSpent+$bankChargesSpent+$transportDEOSpent+$transportDivLevelSpent+$projectorHireSpent
+$mealsSpent+$writingMaterialsSpent+$flipChartSpent+$hallRentalSpent+$airTimeDistrictLevelAllowanceSpent+$secretaryAllowanceDEOSpent+
$facilitationAllowanceSpent+$coordinationAllowanceDEOSpent;


$totalAmountVariance=$otherAllowancesVariance+$courierVariance+$bankChargesVariance+$transportDEOVariance+$transportDivLevelVariance+$projectorHireVariance
+$mealsVariance+$writingMaterialsVariance+$flipChartVariance+$hallRentalVariance+$airTimeDistrictLevelAllowanceVariance+$secretaryAllowanceDEOVariance+
$facilitationAllowanceVariance+$coordinationAllowanceDEOVariance;



?>
                          <tr style="border-bottom: 1px solid #B4B5B0;">

                            <td align="left" width="20px"> <?php echo $id; ?>  </td>
                            <td align="left" width="20px"> <?php echo $name; ?>  </td>
                            <td align="left" width="20px"> <?php echo $amountWords; ?>  </td>
                            
                            <td align="left" width="30px"> <?php echo $preparedBy; ?>  </td>
                            
                            <td align="left" width="40px"> <?php echo $date; ?>  </td>  


                            <td align="center" width="20px"><a href="RTREform.php?id=<?php echo $id ?>#openModal" ><img src="../images/icons/view2.png" height="20px"/></a></td>
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
		     <a href="RTREform.php?#close" class="btn btn-danger"style="position:absolute;margin-left:96%;margin-top:-7%;" title="Close" class="close">X</a>
         
              <form method="POST">
              		<div style="position:absolute;margin-left:45%; margin-top:-1%;">
				<label for="preparedBy">Prepared By</label>
				<select name="preparedBy">
			<option selected="selected" value="<?php echo $preparedBy; ?>"><?php echo $preparedBy; ?></option>
			   
			  <?php 
				$sql="select staff_name from staff";
				$results=mysql_query($sql);
				while($row=mysql_fetch_array($results)){
			  echo "<option>".$row["staff_name"]."</option>";
			  }
			  ?>
			  	</select>
				
				<input type="submit" class="btn btn-success" name="updateRecord" value="Update Details" />
				</div>
                <table border="0"cellpadding="0" cellspacing="0">
                  <thead>
                    <tr>
						<td>Name</td><td><input type="text" id="receiver_name" name="receiver_name" value="<?php echo $name; ?>" /></td>
						<td></td><td>Date</td><td><input type="text" id="date" name="date" value="<?php echo $date; ?>"  readonly/></td>
                     </tr>
					 <tr>
					 <td>hhh</td>
					 </tr>
					 <tr>
					 <td>
					 </td>
					 </tr>
					 <tr>
					 						 <td>Amount(Words)</td><td><input type="text" name="amount" value=""  readonly/></td>

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
				<td></td><td>Amount forwarded to your district</td>
				</tr>
				<tr>
<td>1</td><td>Coordination Allowance for DEO</td><td><input type="text" id="coordinationAllowanceDEOAdvanced" name="coordinationAllowanceDEOAdvanced" value="<?php echo $coordinationAllowanceDEOAdvanced ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDEOAdvancedSpan"/></span></td><td><input type="text" id="coordinationAllowanceDEOSpent" name="coordinationAllowanceDEOSpent" value="<?php echo $coordinationAllowanceDEOSpent ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDEOSpentSpan"/></span></td><td><input type="text" id="coordinationAllowanceDEOVariance" name="coordinationAllowanceDEOVariance" value="<?php echo $coordinationAllowanceDEOVariance; ?>"onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDEOVarianceSpan"/></span></td>
				</tr>
				<tr>
				<td>2</td><td>Transport for DEO</td><td><input type="text" id="transportDEOAdvanced" name="transportDEOAdvanced" value="<?php echo $transportDEOAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportDEOAdvancedSpan"/></span></td><td><input type="text" id="transportDEOSpent" name="transportDEOSpent" value="<?php echo $transportDEOSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportDEOSpentSpan"/></span></td><td><input type="text" id="transportDEOVariance" name="transportDEOVariance" value="<?php echo $transportDEOVariance; ?>"  onKeyUp="isNumeric(this.id);"/><span id="transportDEOVarianceSpan"/></span></td>
				
				</tr>
				<tr>
				<td>3</td><td>AirTime for DEO</td><td><input type="text" id="airTimeDEOAdvanced" name="airTimeDEOAdvanced" value="<?php echo $airTimeDEOAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDEOAdvancedSpan"/></span></td><td><input type="text" id="airTimeDEOSpent" name="airTimeDEOSpent" value="<?php echo $airTimeDEOSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDEOSpentSpan"/></span></td><td><input type="text" id="airTimeDEOVariance" name="airTimeDEOVariance" value="<?php echo $airTimeDEOVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDEOVarianceSpan"/></span></td>
				
				</tr>
				<tr>
				<td>4</td><td>Facilitation Allowance for DEO</td><td><input type="text" id="facilitationAllowanceAdvanced" name="facilitationAllowanceAdvanced" value="<?php echo $facilitationAllowanceAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationAllowanceAdvancedSpan"/></span></td><td><input type="text" id="facilitationAllowanceSpent" name="facilitationAllowanceSpent" value="<?php echo $facilitationAllowanceSpent;?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationAllowanceSpentSpan"/></span></td><td><input type="text" id="facilitationAllowanceVariance" name="facilitationAllowanceVariance" value="<?php echo $facilitationAllowanceVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationAllowanceVarianceSpan"/></span></td>
			</tr>
				<tr>
				<td>5</td><td>Secretary Allowance for DEO</td><td><input type="text" id="secretaryAllowanceDEOAdvanced" name="secretaryAllowanceDEOAdvanced" value="<?php echo $secretaryAllowanceDEOAdvanced;?>" onKeyUp="isNumeric(this.id);"/><span id="secretaryAllowanceDEOAdvancedSpan"/></span></td><td><input type="text" id="secretaryAllowanceDEOSpent" name="secretaryAllowanceDEOSpent" value="<?php echo $secretaryAllowanceDEOSpent;?>" onKeyUp="isNumeric(this.id);"/><span id="secretaryAllowanceDEOSpentSpan"/></span></td><td><input type="text" id="secretaryAllowanceDEOVariance"  name="secretaryAllowanceDEOVariance" value="<?php echo $secretaryAllowanceDEOVariance;?>" onKeyUp="isNumeric(this.id);"/><span id="secretaryAllowanceDEOVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>6</td><td>Transport for District Level Personnel</td><td><input type="text" id="transportDistrictlevelAdvanced"  name="transportDistrictlevelAdvanced" value="<?php echo $transportDistrictlevelAdvanced ?>" onKeyUp="isNumeric(this.id);"/><span id="transportDistrictlevelAdvancedSpan"/></span></td><td><input type="text" id="transportDistrictlevelSpent" name="transportDistrictlevelSpent" value="<?php echo $transportDistrictlevelSpent;?>" onKeyUp="isNumeric(this.id);"/><span id="transportDistrictlevelSpentSpan"/></span></td><td><input type="text" id="transportDistrictlevelVariance" name="transportDistrictlevelVariance" value="<?php echo $transportDistrictlevelVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportDistrictlevelVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>7</td><td>Airtime for District Level Personnel</td><td><input type="text" id="airTimeDistrictLevelAllowanceAdvanced" name="airTimeDistrictLevelAllowanceAdvanced" value="<?php echo $airTimeDistrictLevelAllowanceAdvanced;?> " onKeyUp="isNumeric(this.id);"/><span id="airTimeDistrictLevelAllowanceAdvancedSpan"/></span></td><td><input type="text" id="airTimeDistrictLevelAllowanceSpent" name="airTimeDistrictLevelAllowanceSpent" value="<?php echo $airTimeDistrictLevelAllowanceSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDistrictLevelAllowanceSpentSpan"/></span></td><td><input type="text" id="airTimeDistrictLevelAllowanceVariance"  name="airTimeDistrictLevelAllowanceVariance" value="<?php echo $airTimeDistrictLevelAllowanceVariance;?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDistrictLevelAllowanceVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>8</td><td>Transport for Division Level Personnel</td><td><input type="text" id="transportDivLevelAdvanced" name="transportDivLevelAdvanced" value="<?php echo $transportDivLevelAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="transportDivLevelAdvancedSpan"/></span></td><td><input type="text" id="transportDivLevelSpent" name="transportDivLevelSpent" value="<?php echo $transportDivLevelSpent;?>"  onKeyUp="isNumeric(this.id);"/><span id="transportDivLevelSpentSpan"/></span></td><td><input type="text" id="transportDivLevelVariance" name="transportDivLevelVariance" value="<?php echo $transportDivLevelVariance;?>"  onKeyUp="isNumeric(this.id);"/><span id="transportDivLevelVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>9</td><td>Hall Rental</td><td><input type="text" id="hallRentalAdvanced" name="hallRentalAdvanced" value="<?php echo $hallRentalAdvanced;?>"  onKeyUp="isNumeric(this.id);"/><span id="hallRentalAdvancedSpan"/></span></td><td><input type="text" id="hallRentalSpent" name="hallRentalSpent" value="<?php echo $hallRentalSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="hallRentalSpentSpan"/></span></td><td><input type="text" id="hallRentalVariance" name="hallRentalVariance" value="<?php echo $hallRentalVariance; ?>"  onKeyUp="isNumeric(this.id);"/><span id="hallRentalVarianceSpan"/></span></td>
				
				</tr>
					
					<tr>
				<td>10</td><td>Projector Hire</td><td><input type="text" id="projectorHireAdvanced" name="projectorHireAdvanced" value="<?php echo $projectorHireAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="projectorHireAdvancedSpan"/></span></td><td><input type="text" id="projectorHireSpent" name="projectorHireSpent" value="<?php echo $projectorHireSpent;?>"  onKeyUp="isNumeric(this.id);"/><span id="projectorHireSpentSpan"/></span></td><td><input type="text" id="projectorHireVariance" name="projectorHireVariance" value="<?php echo $projectorHireVariance;?>"  onKeyUp="isNumeric(this.id);"/><span id="projectorHireVarianceSpan"/></span></td>
				
				</tr>
				<tr>
				<td>11</td><td>Meals(Tea,Snacks,Lunch)</td><td><input type="text" id="mealsAdvanced" name="mealsAdvanced" value="<?php echo $mealsAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="mealsAdvancedSpan"/></span></td><td><input type="text" id="mealsSpent" name="mealsSpent" value="<?php echo $mealsSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="mealsSpentSpan"/></span></td><td><input type="text" id="mealsVariance" name="mealsVariance" value="<?php echo $mealsVariance; ?>"  onKeyUp="isNumeric(this.id);"/><span id="mealsVarianceSpan"/></span></td>
				
				</tr>
				<tr><td>12</td>
				<td>Writing Materials</td><td><input type="text" id="writingMaterialsAdvanced" name="writingMaterialsAdvanced" value="<?php echo $writingMaterialsAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="writingMaterialsAdvancedSpan"/></span></td><td><input type="text" id="writingMaterialsSpent" name="writingMaterialsSpent" value="<?php echo $writingMaterialsSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="writingMaterialsSpentSpan"/></span></td><td><input type="text" id="writingMaterialsVariance"  name="writingMaterialsVariance" value="<?php echo $writingMaterialsVariance; ?>"  onKeyUp="isNumeric(this.id);"/><span id="writingMaterialsVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>13</td><td>Flip chart Paper & Markers</td><td><input type="text" id="flipChartAdvanced" name="flipChartAdvanced" value="<?php echo $flipChartAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="flipChartAdvancedSpan"/></span></td><td><input type="text" id="flipChartSpent" name="flipChartSpent" value="<?php echo $flipChartSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="flipChartSpentSpan"/></span></td><td><input type="text" id="flipChartVariance" name="flipChartVariance" value="<?php echo $flipChartVariance;?>"  onKeyUp="isNumeric(this.id);"/><span id="flipChartVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>14</td><td>Bank Charges</td><td><input type="text" id="bankChargesAdvanced" name="bankChargesAdvanced" value="<?php echo $bankChargesAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="bankChargesAdvancedSpan"/></span></td><td><input type="text" id="bankChargesSpent"  name="bankChargesSpent" value="<?php echo $bankChargesSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="bankChargesSpentSpan"/></span></td><td><input type="text" name="bankChargesVariance" value="<?php echo $bankChargesVariance;?>"  onKeyUp="isNumeric(this.id);"/><span id="bankChargesVarianceSpan"/></span></td>
				
				</tr>
					<tr>
				<td>15</td><td>G4s Courier</td><td><input type="text" id="courierAdvanced" name="courierAdvanced" value="<?php echo $courierAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="courierAdvancedSpan"/></span></td><td><input type="text" id="courierSpent" name="courierSpent" value="<?php echo $courierSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="courierSpentSpan"/></span></td><td><input type="text" id="courierVariance" name="courierVariance" value="<?php echo $courierVariance;?>"  onKeyUp="isNumeric(this.id);"/><span id="courierVarianceSpan"/></span></td>
				
				</tr>
				
					<tr>
				<td>16</td><td>Other Allowances</td><td><input type="text" id="otherAllowancesAdvanced" name="otherAllowancesAdvanced" value="<?php echo $otherAllowancesAdvanced;?>"  onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesAdvancedSpan"/></span></td><td><input type="text" id="otherAllowancesSpent" name="otherAllowancesSpent" value="<?php echo $otherAllowancesSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesSpentSpan"/></span></td><td><input type="text" id="otherAllowancesVariance" name="otherAllowancesVariance" value="<?php echo $otherAllowancesVariance;?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesVarianceSpan"/></span></td>
				
				</tr>
				
				
				<tr>
				<td>17</td><td><b>Total Amount</b></td><td><input type="text" id="totalAmountAdvanced" name="totalAmountAdvanced" value="<?php echo $totalAmountAdvanced; ?>"  onKeyUp="isNumeric(this.id);"/><span id="totalAmountAdvancedSpan"/></span></td><td><input type="text" id="totalAmountSpent"  name="totalAmountSpent" value="<?php echo $totalAmountSpent; ?>"  onKeyUp="isNumeric(this.id);"/><span id="totalAmountSpentSpan"/></span></td><td><input type="text"  id="totalAmountVariance"  name="totalAmountVariance" value="<?php echo $totalAmountVariance;?>"  onKeyUp="isNumeric(this.id);"/><span id="totalAmountVarianceSpan"/></span></td>
				</tr>
				<tr>
				
				
				<td colspan="4">Remarks<textarea colspan="4" name="remarks"><?php echo $remarks; ?></textarea></td>
				
				</tr>
				</tbody>
				</table>
			
				</form>
				
				
				
				
</div>
</div>