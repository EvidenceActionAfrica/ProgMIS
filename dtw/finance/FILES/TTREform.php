<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once("../includes/function_convert_number_to_words.php");
$tabActive = "tab1";
$updateResult = ""; //This variable is used to display update status.DO NOT Modify
$name = isset($_POST["receiver_name"]) ? $_POST["receiver_name"] : "";
$coordinationAllowanceDEOAdvanced = isset($_POST["coordinationAllowanceDEOAdvanced"]) ? mysql_real_escape_string($_POST["coordinationAllowanceDEOAdvanced"]) : "";
$coordinationAllowanceDEOSpent = isset($_POST["coordinationAllowanceDEOSpent"]) ? mysql_real_escape_string($_POST["coordinationAllowanceDEOSpent"]) : "";
$transportDEOAdvanced = isset($_POST["transportDEOAdvanced"]) ? mysql_real_escape_string($_POST["transportDEOAdvanced"]) : "";
$transportDEOSpent = isset($_POST["transportDEOSpent"]) ? mysql_real_escape_string($_POST["transportDEOSpent"]) : "";
$airTimeDEOAdvanced = isset($_POST["airTimeDEOAdvanced"]) ? mysql_real_escape_string($_POST["airTimeDEOAdvanced"]) : "";
$airTimeDEOSpent = isset($_POST["airTimeDEOSpent"]) ? mysql_real_escape_string($_POST["airTimeDEOSpent"]) : "";
$transportTrainingMaterialsAllowanceAdvanced = isset($_POST["transportTrainingMaterialsAllowanceAdvanced"]) ? mysql_real_escape_string($_POST["transportTrainingMaterialsAllowanceAdvanced"]) : "";
$transportTrainingMaterialsAllowanceSpent = isset($_POST["transportTrainingMaterialsAllowanceSpent"]) ? mysql_real_escape_string($_POST["transportTrainingMaterialsAllowanceSpent"]) : "";
$driverLunchAllowanceAdvanced = isset($_POST["driverLunchAllowanceAdvanced"]) ? mysql_real_escape_string($_POST["driverLunchAllowanceAdvanced"]) : "";
$driverLunchAllowanceSpent = isset($_POST["driverLunchAllowanceSpent"]) ? mysql_real_escape_string($_POST["driverLunchAllowanceSpent"]) : "";
$coordinationAllowance2DistrictLevelAdvanced = isset($_POST["coordinationAllowance2DistrictLevelAdvanced"]) ? mysql_real_escape_string($_POST["coordinationAllowance2DistrictLevelAdvanced"]) : "";
$coordinationAllowance2DistrictLevelSpent = isset($_POST["coordinationAllowance2DistrictLevelSpent"]) ? mysql_real_escape_string($_POST["coordinationAllowance2DistrictLevelSpent"]) : "";
$transport2DistrictLevelAllowanceAdvanced = isset($_POST["transport2DistrictLevelAllowanceAdvanced"]) ? mysql_real_escape_string($_POST["transport2DistrictLevelAllowanceAdvanced"]) : "";
$transport2DistrictLevelAllowanceSpent = isset($_POST["transport2DistrictLevelAllowanceSpent"]) ? mysql_real_escape_string($_POST["transport2DistrictLevelAllowanceSpent"]) : "";
$airTime2DistrictLevelAdvanced = isset($_POST["airTime2DistrictLevelAdvanced"]) ? mysql_real_escape_string($_POST["airTime2DistrictLevelAdvanced"]) : "";
$airTime2DistrictLevelSpent = isset($_POST["airTime2DistrictLevelSpent"]) ? mysql_real_escape_string($_POST["airTime2DistrictLevelSpent"]) : "";
$facilitationFeeAdvanced = isset($_POST["facilitationFeeAdvanced"]) ? mysql_real_escape_string($_POST["facilitationFeeAdvanced"]) : "";
$facilitationFeeSpent = isset($_POST["facilitationFeeSpent"]) ? mysql_real_escape_string($_POST["facilitationFeeSpent"]) : "";
$lunchTeacherTrainingDivLevelAdvanced = isset($_POST["lunchTeacherTrainingDivLevelAdvanced"]) ? mysql_real_escape_string($_POST["lunchTeacherTrainingDivLevelAdvanced"]) : "";
$lunchTeacherTrainingDivLevelSpent = isset($_POST["lunchTeacherTrainingDivLevelSpent"]) ? mysql_real_escape_string($_POST["lunchTeacherTrainingDivLevelSpent"]) : "";
$transportTeacherTrainingAdvanced = isset($_POST["transportTeacherTrainingAdvanced"]) ? mysql_real_escape_string($_POST["transportTeacherTrainingAdvanced"]) : "";
$transportTeacherTrainingSpent = isset($_POST["transportTeacherTrainingSpent"]) ? mysql_real_escape_string($_POST["transportTeacherTrainingSpent"]) : "";
$airTimeDivLevelAdvanced = isset($_POST["airTimeDivLevelAdvanced"]) ? mysql_real_escape_string($_POST["airTimeDivLevelAdvanced"]) : "";
$airTimeDivLevelSpent = isset($_POST["airTimeDivLevelSpent"]) ? mysql_real_escape_string($_POST["airTimeDivLevelSpent"]) : "";

$teacherTransportAdvanced = isset($_POST["teacherTransportAdvanced"]) ? mysql_real_escape_string($_POST["teacherTransportAdvanced"]) : "";
$teacherTransportSpent = isset($_POST["teacherTransportSpent"]) ? mysql_real_escape_string($_POST["teacherTransportSpent"]) : "";
$hallRentalAdvanced = isset($_POST["hallRentalAdvanced"]) ? mysql_real_escape_string($_POST["hallRentalAdvanced"]) : "";
$hallRentalSpent = isset($_POST["hallRentalSpent"]) ? mysql_real_escape_string($_POST["hallRentalSpent"]) : "";
$teaAdvanced = isset($_POST["teaAdvanced"]) ? mysql_real_escape_string($_POST["teaAdvanced"]) : "";
$teaSpent = isset($_POST["teaSpent"]) ? mysql_real_escape_string($_POST["teaSpent"]) : "";
$stationeryAdvanced = isset($_POST["stationeryAdvanced"]) ? mysql_real_escape_string($_POST["stationeryAdvanced"]) : "";
$stationerySpent = isset($_POST["stationerySpent"]) ? mysql_real_escape_string($_POST["stationerySpent"]) : "";
$airTimeHeadTeachersAdvanced = isset($_POST["airTimeHeadTeachersAdvanced"]) ? mysql_real_escape_string($_POST["airTimeHeadTeachersAdvanced"]) : "";
$airTimeHeadTeachersSpent = isset($_POST["airTimeHeadTeachersSpent"]) ? mysql_real_escape_string($_POST["airTimeHeadTeachersSpent"]) : "";
$bankChargesAdvanced = isset($_POST["bankChargesAdvanced"]) ? mysql_real_escape_string($_POST["bankChargesAdvanced"]) : "";
$bankChargesSpent = isset($_POST["bankChargesSpent"]) ? mysql_real_escape_string($_POST["bankChargesSpent"]) : "";
$courierAmountAdvanced = isset($_POST["courierAmountAdvanced"]) ? mysql_real_escape_string($_POST["courierAmountAdvanced"]) : "";
$courierAmountSpent = isset($_POST["courierAmountSpent"]) ? mysql_real_escape_string($_POST["courierAmountSpent"]) : "";
$otherAllowancesAmountAdvanced = isset($_POST["otherAllowancesAmountAdvanced"]) ? mysql_real_escape_string($_POST["otherAllowancesAmountAdvanced"]) : "";
$otherAllowancesAmountSpent = isset($_POST["otherAllowancesAmountSpent"]) ? mysql_real_escape_string($_POST["otherAllowancesAmountSpent"]) : "";
$totalAboveAmountAdvanced = isset($_POST["totalAboveAmountAdvanced"]) ? mysql_real_escape_string($_POST["totalAboveAmountAdvanced"]) : "";
$totalAboveAmountSpent = isset($_POST["totalAboveAmountSpent"]) ? mysql_real_escape_string($_POST["totalAboveAmountSpent"]) : "";
$totalAmountAdvanced = isset($_POST["totalAmountAdvanced"]) ? mysql_real_escape_string($_POST["totalAmountAdvanced"]) : "";
$totalAmountSpent = isset($_POST["totalAmountSpent"]) ? mysql_real_escape_string($_POST["totalAmountSpent"]) : "";
$preparedBy = isset($_POST["preparedBy"]) ? mysql_real_escape_string($_POST["preparedBy"]) : "";
$remarks = isset($_POST["remarks"]) ? mysql_real_escape_string($_POST["remarks"]) : "";
$amountWords = isset($_POST["totalAmountSpent"]) ? strToUpper(convert_number_to_words($_POST["totalAmountSpent"]) . ' Shillings') : "";

$date = date("Y-m-d");

if ($_POST["saveRecord"]) {
  $tabActive = "tab2";
  $sql = "INSERT INTO `fin_budget_ttre`(`name`, `cord_allowance_deo_adv`, `cord_allowance_deo_spent`, `transport_deo_adv`,";
  $sql.=" `transport_deo_spent`,`airTime_deo_adv`, `airTime_deo_spent`, `transport_training_materials_adv`, `transport_training_materials_spent`, `driver_lunch_adv`,";
  $sql.=" `driver_lunch_spent`, `cord_allowance_2dlp_adv`, `cord_allowance_2dlp_spent`, `transport_2dlp_adv`, `transport_2dlp_spent`,";
  $sql.=" `airTime_2dlp_adv`, `airTime_2dlp_spent`, `facilitation_fee_adv`, `facilitation_fee_spent`, `lunch_teacher_training_div_adv`,";
  $sql.=" `lunch_teacher_training_div_spent`, `transport_teacher_training_adv`, `transport_teacher_training_spent`, `airTime_divlp_adv`,";
  $sql.=" `airTime_divlp_spent`, `teacher_transport_adv`, `teacher_transport_spent`, `hall_rental_adv`, `hall_rental_spent`, `tea_adv`, ";
  $sql.="`tea_spent`, `stationery_adv`, `stationery_spent`, `airTime_head_teacher_adv`, `airTime_head_teacher_spent`, `bank_charges_adv`,";
  $sql.=" `bank_charges_spent`, `courier_amount_adv`, `courier_amount_spent`, `other_allowance_amount_adv`, `other_allowance_amount_spent`,";
  $sql.=" `total_above_amount_adv`, `total_above_amount_spent`, `total_amount_adv`, `total_amount_spent`, `prepared_by`, `remarks`, `date`,";
  $sql.=" `amount_words`) VALUES ('$name','$coordinationAllowanceDEOAdvanced','$coordinationAllowanceDEOSpent','$transportDEOAdvanced',";
  $sql.="'$transportDEOSpent','$airTimeDEOAdvanced','$airTimeDEOSpent',$transportTeacherTrainingAdvanced','transportTeacherTrainingSpent','$driverLunchAllowanceAdvanced','$driverLunchAllowanceSpent',";
  $sql.="'$coordinationAllowance2DistrictLevelAdvanced','$coordinationAllowance2DistrictLevelSpent','$transport2DistrictLevelAllowanceAdvanced',";
  $sql.="'$transport2DistrictLevelAllowanceSpent','$airTime2DistrictLevelAdvanced','$airTime2DistrictLevelSpent','$facilitationFeeAdvanced','$facilitationFeeSpent',";
  $sql.="'$lunchTeacherTrainingDivLevelAdvanced','$lunchTeacherTrainingDivLevelSpent','$transportTeacherTrainingAdvanced',";
  $sql.="'$transportTeacherTrainingSpent','$airTimeDivLevelAdvanced','$airTimeDivLevelSpent','$teacherTransportAdvanced','$teacherTransportSpent',";
  $sql.="'$hallRentalAdvanced','$hallRentalSpent','$teaAdvanced','$teaSpent','$stationeryAdvanced','$stationerySpent',";
  $sql.="'$airTimeHeadTeachersAdvanced','$airTimeHeadTeachersSpent','$bankChargesAdvanced','$bankChargesSpent',";
  $sql.="'$courierAmountAdvanced','$courierAmountSpent','$otherAllowancesAmountAdvanced','$otherAllowancesAmountSpent','$totalAboveAmountAdvanced',";
  $sql.="'$totalAboveAmountSpent','$totalAmountAdvanced','$totalAmountSpent','$preparedBy','$remarks','$date','$amountWords')";


//echo $sql;
  mysql_query($sql);
}
if (isset($_GET["deleteid"])) {
  $tabActive = "tab2";
  $id = $_GET["deleteid"];
  $sql = "DELETE from fin_budget_ttre where form_id='$id'";

  mysql_query($sql);
}

if ($_POST["updateRecord"]) {
  $tabActive = "tab2";
  $id = $_GET["id"];

  $sql = " UPDATE `fin_budget_ttre` SET `name`='$name',`cord_allowance_deo_adv`='$coordinationAllowanceDEOAdvanced',";
  $sql.="`cord_allowance_deo_spent`='$coordinationAllowanceDEOSpent',`transport_deo_adv`='$transportDEOAdvanced',";
  $sql.="`transport_deo_spent`='$transportDEOSpent',`transport_training_materials_adv`='$transportTrainingMaterialsAllowanceAdvanced',";
  $sql.="`transport_training_materials_spent`='$transportTrainingMaterialsAllowanceSpent',`driver_lunch_adv`='$driverLunchAllowanceAdvanced',";
  $sql.="`driver_lunch_spent`='$driverLunchAllowanceSpent',`cord_allowance_2dlp_adv`='$coordinationAllowance2DistrictLevelAdvanced',`cord_allowance_2dlp_spent`='$coordinationAllowance2DistrictLevelSpent',";
  $sql.="`transport_2dlp_adv`='$transport2DistrictLevelAllowanceAdvanced',`transport_2dlp_spent`='$transport2DistrictLevelAllowanceSpent',`airTime_2dlp_adv`='$airTime2DistrictLevelAdvanced',";
  $sql.="`airTime_2dlp_spent`='$airTime2DistrictLevelSpent',`facilitation_fee_adv`='$facilitationFeeAdvanced',`facilitation_fee_spent`='$facilitationFeeSpent',";
  $sql.="`lunch_teacher_training_div_adv`='$lunchTeacherTrainingDivLevelAdvanced',`lunch_teacher_training_div_spent`='$lunchTeacherTrainingDivLevelSpent',";
  $sql.="`transport_teacher_training_adv`='$transportTeacherTrainingAdvanced',`transport_teacher_training_spent`='$transportTeacherTrainingSpent',";
  $sql.="`airTime_divlp_adv`='$airTimeDivLevelAdvanced',`airTime_divlp_spent`='$airTimeDivLevelSpent',`teacher_transport_adv`='$teacherTransportAdvanced',";
  $sql.="`teacher_transport_spent`='$teacherTransportSpent',`hall_rental_adv`='$hallRentalAdvanced',`hall_rental_spent`='$hallRentalSpent',";
  $sql.="`tea_adv`='$teaAdvanced',`tea_spent`='$teaSpent',`stationery_adv`='$stationeryAdvanced',`stationery_spent`='$stationerySpent',";
  $sql.="`airTime_head_teacher_adv`='$airTimeHeadTeachersAdvanced',`airTime_head_teacher_spent`='$airTimeHeadTeachersSpent',`bank_charges_adv`='$bankChargesAdvanced',";
  $sql.="`bank_charges_spent`='$bankChargesSpent',`courier_amount_adv`='$courierAmountAdvanced',`courier_amount_spent`='$courierAmountSpent',";
  $sql.="`other_allowance_amount_adv`='$otherAllowancesAmountAdvanced',`other_allowance_amount_spent`='$otherAllowancesAmountSpent',`total_above_amount_adv`='$totalAboveAmountAdvanced',";
  $sql.="`total_above_amount_spent`='$totalAboveAmountSpent',`total_amount_adv`='$totalAmountAdvanced',`total_amount_spent`='$totalAmountSpent',";
  $sql.="`prepared_by`='$preparedBy',`remarks`='$remarks',`date`='$date',";
  $sql.="`amount_words`='$amountWords' WHERE `form_id`='$id'";

  mysql_query($sql);
  $updateResult = "Record Updated";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet"/>
    <link href="css/default.css" type="text/css" rel="stylesheet"/>
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
              </a>
            </li>
            <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">View Financial Reconciliation Return Form
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>"  id="tab1">

              <h2>Financial Reconciliation Return Form</h2>
              <form method="POST">
                <table border="0"cellpadding="0" cellspacing="0">
                  <thead>
                    <tr>
                      <td>Name</td><td><input type="text" id="receiver_name" name="receiver_name" value="<?php echo $name; ?>" /></td>
                      <td>Date</td><td><input type="text" id="amount" name="amount" value="<?php echo date('Y-m-d'); ?>" readonly/></td>
                    </tr>
                    <tr>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Amount(Words)</td><td><input type="text" name="amount" style="width:200%;font-weight:bolder;" value="<?php echo $amountWords; ?>" readonly/></td>
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
                      <td>1</td><td>Coordination Allowance for DEO</td><td><input type="text" id="coordinationAllowanceDEOAdvanced" name="coordinationAllowanceDEOAdvanced" value="<?php echo $coordinationAllowanceDEOAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDEOAdvancedSpan"/></span></td><td><input type="text" id="coordinationAllowanceDEOSpent" name="coordinationAllowanceDEOSpent" value="<?php echo $coordinationAllowanceDEOSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDEOSpentSpan"/></span></td><td><input type="text" id="coordinationAllowanceDEOVariance" name="coordinationAllowanceDEOVariance" value="<?php echo $coordinationAllowanceDEOVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowanceDEOVarianceSpan"/></span></td>
                    </tr>
                    <tr>
                      <td>2</td><td>Transport for DEO</td><td><input type="text" id="transportDEOAdvanced" name="transportDEOAdvanced" value="<?php echo $transportDEOAdvanced ?>" onKeyUp="isNumeric(this.id);"/><span id="transportDEOAdvancedSpan"/></span></td><td><input type="text" id="transportDEOSpent" name="transportDEOSpent" value="<?php echo $transportDEOSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportDEOSpentSpan"/></span></td><td><input type="text" id="transportDEOVariance" name="transportDEOVariance" value="<?php echo $transportDEOVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportDEOVarianceSpan"/></span></td>

                    </tr>
                    <tr>
                      <td>3</td><td>AirTime for DEO</td><td><input type="text" id="airTimeDEOAdvanced" name="airTimeDEOAdvanced" value="<?php echo $airTimeDEOAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDEOAdvancedSpan"/></span></td><td><input type="text" id="airTimeDEOSpent" name="airTimeDEOSpent" value="<?php echo $airTimeDEOSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDEOSpentSpan"/></span></td><td><input type="text" id="airTimeDEOVariance" name="airTimeDEOVariance" value="<?php echo $airTimeDEOVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDEOVarianceSpan"/></span></td>

                    </tr>
                    <tr>
                      <td>4</td><td>Transport for Distributing All Training Materials</td><td><input type="text" id="transportTrainingMaterialsAllowanceAdvanced" name="transportTrainingMaterialsAllowanceAdvanced" value="<?php echo $transportTrainingMaterialsAllowanceAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportTrainingMaterialsAllowanceAdvancedSpan"/></span></td><td><input type="text" id="transportTrainingMaterialsAllowanceSpent" name="transportTrainingMaterialsAllowanceSpent" value="<?php echo $transportTrainingMaterialsAllowanceSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportTrainingMaterialsAllowanceSpentSpan"/></span></td><td><input type="text" id="transportTrainingMaterialsAllowanceVariance" name="transportTrainingMaterialsAllowanceVariance" value="<?php echo $transportTrainingMaterialsAllowanceVariance ?>" onKeyUp="isNumeric(this.id);"/><span id="transportTrainingMaterialsAllowanceVarianceSpan"/></span></td>
                    </tr>
                    <tr>
                      <td>5</td><td>Driver's Lunch</td><td><input type="text" id="driverLunchAllowanceAdvanced" name="driverLunchAllowanceAdvanced" value="<?php echo $driverLunchAllowanceAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="driverLunchAllowanceAdvancedSpan"/></span></td><td><input type="text" id="driverLunchAllowanceSpent" name="driverLunchAllowanceSpent" value="<?php echo $driverLunchAllowanceSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="driverLunchAllowanceSpentSpan"/></span></td><td><input type="text" id="driverLunchAllowanceVariance" name="driverLunchAllowanceVariance" value="<?php echo $driverLunchAllowanceVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="driverLunchAllowanceVarianceSpan"/></span></td>

                    </tr>
                    <tr>
                      <td>6</td><td>Coordination Allowance to 2 District Level Personnel</td><td><input type="text" id="coordinationAllowance2DistrictLevelAdvanced" name="coordinationAllowance2DistrictLevelAdvanced" value="<?php echo $coordinationAllowance2DistrictLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowance2DistrictLevelAdvancedSpan"/></span></td><td><input type="text" id="coordinationAllowance2DistrictLevelSpent" name="coordinationAllowance2DistrictLevelSpent" value="<?php echo $coordinationAllowance2DistrictLevelSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowance2DistrictLevelSpentSpan"/></span></td><td><input type="text" id="coordinationAllowance2DistrictLevelVariance"  name="coordinationAllowance2DistrictLevelVariance" value="<?php echo $coordinationAllowance2DistrictLevelVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="coordinationAllowance2DistrictLevelVarianceSpan"/></span></td>

                    </tr>
                    <tr>
                      <td>7</td><td>Transport for 2 District Personnel</td><td><input type="text" id="transport2DistrictLevelAllowanceAdvanced" name="transport2DistrictLevelAllowanceAdvanced" value="<?php echo $transport2DistrictLevelAllowanceAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="transport2DistrictLevelAllowanceAdvancedSpan"/></span></td><td><input type="text" id="transport2DistrictLevelAllowanceSpent"  name="transport2DistrictLevelAllowanceSpent" value="<?php echo $transport2DistrictLevelAllowanceSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="transport2DistrictLevelAllowanceSpentSpan"/></span></td><td><input type="text" id="transport2DistrictLevelAllowanceVariance" name="transport2DistrictLevelAllowanceVariance" value="<?php echo $transport2DistrictLevelAllowanceVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="transport2DistrictLevelAllowanceVarianceSpan"/></span></td>

                    </tr>
                    <tr>
                      <td>8</td><td>Airtime for 2 District Personnel</td><td><input type="text" id="airTime2DistrictLevelAdvanced" name="airTime2DistrictLevelAdvanced" value="<?php echo $airTime2DistrictLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTime2DistrictLevelAdvancedSpan"/></span></td><td><input type="text" id="airTime2DistrictLevelSpent" name="airTime2DistrictLevelSpent" value="<?php echo $airTime2DistrictLevelSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTime2DistrictLevelSpentSpan"/></span></td><td><input type="text" id="airTime2DistrictLevelVariance" name="airTime2DistrictLevelVariance" value="<?php echo $airTime2DistrictLevelVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTime2DistrictLevelVarianceSpan"/></span></td>

                    </tr>
                    <tr>
                      <td>9</td><td>Facilitation Fee for Teacher Training Sessions</td><td><input type="text" id="facilitationFeeAdvanced" name="facilitationFeeAdvanced" value="<?php echo $facilitationFeeAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationFeeAdvancedSpan"/></span></td><td><input type="text" id="facilitationFeeSpent" name="facilitationFeeSpent" value="<?php echo $facilitationFeeSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationFeeSpentSpan"/></span></td><td><input type="text" id="facilitationFeeVariance" name="facilitationFeeVariance" value="<?php echo $facilitationFeeVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="facilitationFeeVarianceSpan"/></span></td>

                    </tr>

                    <tr>
                      <td>10</td><td>Lunch During Teacher Training Sessions</td><td><input type="text" id="lunchTeacherTrainingDivLevelAdvanced" name="lunchTeacherTrainingDivLevelAdvanced" value="<?php echo $lunchTeacherTrainingDivLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="lunchTeacherTrainingDivLevelAdvancedSpan"/></span></td><td><input type="text" id="lunchTeacherTrainingDivLevelSpent" name="lunchTeacherTrainingDivLevelSpent" value="<?php echo $lunchTeacherTrainingDivLevelSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="lunchTeacherTrainingDivLevelSpentSpan"/></span></td><td><input type="text" id="lunchTeacherTrainingDivLevelVariance" name="lunchTeacherTrainingDivLevelVariance" value="<?php echo $lunchTeacherTrainingDivLevelVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="lunchTeacherTrainingDivLevelVarianceSpan"/></span></td>

                    </tr>
                    <tr>
                      <td>11</td><td>Transport to Teacher Training Sessions</td><td><input type="text" id="transportTeacherTrainingAdvanced" name="transportTeacherTrainingAdvanced" value="<?php echo $transportTeacherTrainingAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportTeacherTrainingAdvancedSpan"/></span></td><td><input type="text" id="transportTeacherTrainingSpent" name="transportTeacherTrainingSpent" value="<?php echo $transportTeacherTrainingSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportTeacherTrainingSpentSpan"/></span></td><td><input type="text" id="transportTeacherTrainingVariance" name="transportTeacherTrainingVariance" value="<?php echo $transportTeacherTrainingVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="transportTeacherTrainingVarianceSpan"/></span></td>

                    </tr>
                    <tr><td>12</td>
                      <td>AirtTime for All Division Level Personnel</td><td><input type="text" id="airTimeDivLevelAdvanced" name="airTimeDivLevelAdvanced" value="<?php echo $airTimeDivLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDivLevelAdvancedSpan"/></span></td><td><input type="text" id="airTimeDivLevelSpent" name="airTimeDivLevelSpent" value="<?php echo $airTimeDivLevelSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDivLevelSpentSpan"/></span></td><td><input type="text" id="airTimeDivLevelVariance" name="airTimeDivLevelVariance" value="<?php echo $airTimeDivLevelVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeDivLevelVarianceSpan"/></span></td>

                    </tr>
                    <tr>
                      <td>13</td><td>Teachers' Transport And Lunch</td><td><input type="text" id="teacherTransportAdvanced" name="teacherTransportAdvanced" value="<?php echo $teacherTransportAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="teacherTransportAdvancedSpan"/></span></td><td><input type="text" id="teacherTransportSpent"  name="teacherTransportSpent" value="<?php echo $teacherTransportSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="teacherTransportSpentSpan"/></span></td><td><input type="text" id="teacherTransportVariance" name="teacherTransportVariance" value="<?php echo $teacherTransportVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="teacherTransportVarianceSpan"/></span></td>

                    </tr>
                    <tr>
                      <td>14</td><td>Hall Rental</td><td><input type="text" id="hallRentalAdvanced" name="hallRentalAdvanced" value="<?php echo $hallRentalAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="hallRentalAdvancedSpan"/></span></td><td><input type="text" id="hallRentalSpent" name="hallRentalSpent" value="<?php echo $hallRentalSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="hallRentalSpentSpan"/></span></td><td><input type="text" id="hallRentalVariance" name="hallRentalVariance" value="<?php echo $hallRentalVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="hallRentalVarianceSpan"/></span></td>

                    </tr>
                    <tr>
                      <td>15</td><td>Tea</td><td><input type="text" id="teaAdvanced" name="teaAdvanced" value="<?php echo $teaAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="teaAdvancedSpan"/></span></td><td><input type="text" id="teaSpent" name="teaSpent" value="<?php echo $teaSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="teaSpentSpan"/></span></td><td><input type="text" id="teaVariance" name="teaVariance" value="<?php echo $teaVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="teaVarianceSpan"/></span></td>

                    </tr>

                    <tr>
                      <td>16</td><td>Stationery</td><td><input type="text" id="stationeryAdvanced" name="stationeryAdvanced" value="<?php echo $stationeryAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="stationeryAdvancedSpan"/></span></td><td><input type="text" id="stationerySpent" name="stationerySpent" value="<?php echo $stationerySpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="stationerySpentSpan"/></span></td><td><input type="text" id="stationeryVariance" name="stationeryVariance" value="<?php echo $stationeryVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="stationeryVarianceSpan"/></span></td>

                    </tr>


                    <tr>
                      <td>17</td><td>Airtime for HeadTeachers Only</td><td><input type="text" id="airTimeHeadTeachersAdvanced" name="airTimeHeadTeachersAdvanced" value="<?php echo $airTimeHeadTeachersAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeHeadTeachersAdvancedSpan"/></span></td><td><input type="text" id="airTimeHeadTeachersSpent" name="airTimeHeadTeachersSpent" value="<?php echo $airTimeHeadTeachersSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeHeadTeachersSpentSpan"/></span></td><td><input type="text" id="airTimeHeadTeachersVariance" name="airTimeHeadTeachersVariance" value="<?php echo $airTimeHeadTeachersVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="airTimeHeadTeachersVarianceSpan"/></span></td>
                    </tr>
                    <tr>
                      <tr>
                        <td>18</td><td>Bank Charges</td><td><input type="text" id="bankChargesAdvanced" name="bankChargesAdvanced" value="<?php echo $bankChargesAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="bankChargesAdvancedSpan"/></span></td><td><input type="text" id="bankChargesSpent" name="bankChargesSpent" value="<?php echo $bankChargesSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="bankChargesSpentSpan"/></span></td><td><input type="text" id="bankChargesVariance" name="bankChargesVariance" value="<?php echo $bankChargesVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="bankChargesVarianceSpan"/></span></td>
                      </tr>
                      <tr>
                        <td>19</td><td>G4 Courier Services</td><td><input type="text" id="courierAmountAdvanced" name="courierAmountAdvanced" value="<?php echo $courierAmountAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="courierAmountAdvancedSpan"/></span></td><td><input type="text" id="courierAmountSpent" name="courierAmountSpent" value="<?php echo $courierAmountSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="courierAmountSpentSpan"/></span></td><td><input type="text" id="courierAmountVariance" name="courierAmountVariance" value="<?php echo $courierAmountVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="courierAmountVarianceSpan"/></span></td>
                      </tr>
                      <tr>
                        <td>20</td><td>Other Allowed Allowances</td><td><input type="text" id="otherAllowancesAmountAdvanced" name="otherAllowancesAmountAdvanced" value="<?php echo $otherAllowancesAmountAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesAmountAdvancedSpan"/></span></td><td><input type="text" id="otherAllowancesAmountSpent" name="otherAllowancesAmountSpent" value="<?php echo $otherAllowancesAmountSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesAmountSpentSpan"/></span></td><td><input type="text" id="otherAllowancesAmountVariance" name="otherAllowancesAmountVariance" value="<?php echo $otherAllowancesAmountVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="otherAllowancesAmountVarianceSpan"/></span></td>
                      </tr>
                      <tr>
                        <td>21</td><td><b>totalAbove Above</b></td><td><input type="text" id="totalAboveAmountAdvanced" name="totalAboveAmountAdvanced" value="<?php echo $totalAboveAmountAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="totalAboveAmountAdvancedSpan"/></span></td><td><input type="text" id="totalAboveAmountSpent" name="totalAboveAmountSpent" value="<?php echo $totalAboveAmountSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="totalAboveAmountSpentSpan"/></span></td><td><input type="text" id="totalAboveAmountVariance"  name="totalAboveAmountVariance" value="<?php echo $totalAboveAmountVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="totalAboveAmountVarianceSpan"/></span></td>
                      </tr>
                      <tr>
                        <td>22</td><td><b>Total Amount</b></td><td><input type="text" id="totalAmountAdvanced" name="totalAmountAdvanced" value="<?php echo $totalAmountAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="totalAmountAdvancedSpan"/></span></td><td><input type="text" id="totalAmountSpent" name="totalAmountSpent" value="<?php echo $totalAmountSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="totalAmountSpentSpan"/></span></td><td><input type="text" id="totalAmountVariance" name="totalAmountVariance" value="<?php echo $totalAmountVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="totalAmountVarianceSpan"/></span></td>
                      </tr>
                      <tr>
                        <td colspan="3">Remarks<textarea colspan="2" name="remarks"><?php echo $remarks; ?></textarea></td>

                      </tr>
                  </tbody>
                </table>
                <div style="margin-left:45%;">
                  <label for="preparedBy">Prepared By</label>
                  <select name="preparedBy">
                    <option selected="selected" value="<?php echo $preparedBy; ?>"><?php echo $preparedBy; ?></option>

                    <?php
                    $sql = "select staff_name from staff";
                    $results = mysql_query($sql);
                    while ($row = mysql_fetch_array($results)) {
                      echo "<option value=" . $row["staff_name"] . ">" . $row["staff_name"] . "</option>";
                    }
                    ?>
                  </select>
                  <br/>
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
                  $id = isset($_GET["id"]) ? $_GET["id"] : "";

                  $result_display = mysql_query("SELECT * FROM fin_budget_ttre where form_id like '%$id%'");

                  while ($row = mysql_fetch_array($result_display)) {

                    $id = isset($row["form_id"]) ? $row["form_id"] : "";
                    $name = isset($row["name"]) ? $row["name"] : "";
                    $coordinationAllowanceDEOAdvanced = isset($row["cord_allowance_deo_adv"]) ? $row["cord_allowance_deo_adv"] : "";
                    $coordinationAllowanceDEOSpent = isset($row["cord_allowance_deo_spent"]) ? $row["cord_allowance_deo_spent"] : "";
                    $transportDEOAdvanced = isset($row["transport_deo_adv"]) ? $row["transport_deo_adv"] : "";
                    $transportDEOSpent = isset($row["transport_deo_spent"]) ? $row["transport_deo_spent"] : "";
                    $airTimeDEOAdvanced = isset($row["airTime_deo_adv"]) ? $row["airTime_deo_adv"] : "";
                    $airTimeDEOSpent = isset($row["airTime_deo_spent"]) ? $row["airTime_deo_spent"] : "";
                    $transportTrainingMaterialsAllowanceAdvanced = isset($row["transport_training_materials_adv"]) ? $row["transport_training_materials_adv"] : "";
                    $transportTrainingMaterialsAllowanceSpent = isset($row["transport_training_materials_spent"]) ? $row["transport_training_materials_spent"] : "";
                    $driverLunchAllowanceAdvanced = isset($row["driver_lunch_adv"]) ? $row["driver_lunch_adv"] : "";
                    $driverLunchAllowanceSpent = isset($row["driver_lunch_spent"]) ? $row["driver_lunch_spent"] : "";
                    $coordinationAllowance2DistrictLevelAdvanced = isset($row["cord_allowance_2dlp_adv"]) ? $row["cord_allowance_2dlp_adv"] : "";
                    $coordinationAllowance2DistrictLevelSpent = isset($row["cord_allowance_2dlp_spent"]) ? $row["cord_allowance_2dlp_spent"] : "";
                    $transport2DistrictLevelAllowanceAdvanced = isset($row["transport_2dlp_adv"]) ? $row["transport_2dlp_adv"] : "";
                    $transport2DistrictLevelAllowanceSpent = isset($row["transport_2dlp_spent"]) ? $row["transport_2dlp_spent"] : "";
                    $airTime2DistrictLevelAdvanced = isset($row["airTime_2dlp_adv"]) ? $row["airTime_2dlp_adv"] : "";
                    $airTime2DistrictLevelSpent = isset($row["airTime_2dlp_spent"]) ? $row["airTime_2dlp_spent"] : "";
                    $facilitationFeeAdvanced = isset($row["facilitation_fee_adv"]) ? $row["facilitation_fee_adv"] : "";
                    $facilitationFeeSpent = isset($row["facilitation_fee_spent"]) ? $row["facilitation_fee_spent"] : "";
                    $lunchTeacherTrainingDivLevelAdvanced = isset($row["lunch_teacher_training_div_adv"]) ? $row["lunch_teacher_training_div_adv"] : "";
                    $lunchTeacherTrainingDivLevelSpent = isset($row["lunch_teacher_training_div_spent"]) ? $row["lunch_teacher_training_div_spent"] : "";
                    $transportTeacherTrainingAdvanced = isset($row["transport_teacher_training_adv"]) ? $row["transport_teacher_training_adv"] : "";
                    $transportTeacherTrainingSpent = isset($row["transport_teacher_training_spent"]) ? $row["transport_teacher_training_spent"] : "";
                    $airTimeDivLevelAdvanced = isset($row["airTime_divlp_adv"]) ? $row["airTime_divlp_adv"] : "";
                    $airTimeDivLevelSpent = isset($row["airTime_divlp_spent"]) ? $row["airTime_divlp_spent"] : "";

                    $teacherTransportAdvanced = isset($row["teacher_transport_adv"]) ? $row["teacher_transport_adv"] : "";
                    $teacherTransportSpent = isset($row["teacher_transport_spent"]) ? $row["teacher_transport_spent"] : "";
                    $hallRentalAdvanced = isset($row["hall_rental_adv"]) ? $row["hall_rental_adv"] : "";
                    $hallRentalSpent = isset($row["hall_rental_adv"]) ? $row["hall_rental_adv"] : "";
                    $teaAdvanced = isset($row["tea_adv"]) ? $row["tea_adv"] : "";
                    $teaSpent = isset($row["tea_spent"]) ? $row["tea_spent"] : "";
                    $stationeryAdvanced = isset($row["stationery_adv"]) ? $row["stationery_adv"] : "";
                    $stationerySpent = isset($row["stationery_spent"]) ? $row["stationery_spent"] : "";
                    $airTimeHeadTeachersAdvanced = isset($row["airTime_head_teacher_adv"]) ? $row["airTime_head_teacher_adv"] : "";
                    $airTimeHeadTeachersSpent = isset($row["airTime_head_teacher_spent"]) ? $row["airTime_head_teacher_spent"] : "";
                    $bankChargesAdvanced = isset($row["bank_charges_adv"]) ? $row["bank_charges_adv"] : "";
                    $bankChargesSpent = isset($row["bank_charges_spent"]) ? $row["bank_charges_spent"] : "";
                    $courierAmountAdvanced = isset($row["courier_amount_adv"]) ? $row["courier_amount_adv"] : "";
                    $courierAmountSpent = isset($row["courier_amount_spent"]) ? $row["courier_amount_spent"] : "";
                    $otherAllowancesAmountAdvanced = isset($row["other_allowance_amount_adv"]) ? $row["other_allowance_amount_adv"] : "";
                    $otherAllowancesAmountSpent = isset($row["other_allowance_amount_spent"]) ? $row["other_allowance_amount_spent"] : "";
                    $totalAboveAmountAdvanced = isset($row["total_above_amount_adv"]) ? $row["total_above_amount_adv"] : "";
                    $totalAboveAmountSpent = isset($row["total_above_amount_spent"]) ? $row["total_above_amount_spent"] : "";
                    $totalAmountAdvanced = isset($row["total_amount_adv"]) ? $row["total_amount_adv"] : "";
                    $totalAmountSpent = isset($row["total_amount_spent"]) ? $row["total_amount_spent"] : "";
                    $preparedBy = isset($row["prepared_by"]) ? $row["prepared_by"] : "";
                    $remarks = isset($row["remarks"]) ? $row["remarks"] : "";
                    $amountWords = isset($row["amount_words"]) ? $row["amount_words"] : "";


                    //Variance

                    $coordinationAllowanceDEOVariance = $coordinationAllowanceDEOAdvanced - $coordinationAllowanceDEOSpent;
                    $transportDEOVariance = $transportDEOAdvanced - $transportDEOSpent;
                    $airTimeDEOVariance = $airTimeDEOAdvanced - $airTimeDEOSpent;
                    $transportTrainingMaterialsAllowanceVariance = $transportTrainingMaterialsAllowanceAdvanced - $transportTrainingMaterialsAllowanceSpent;
                    $driverLunchAllowanceVariance = $driverLunchAllowanceAdvanced - $driverLunchAllowanceSpent;
                    $coordinationAllowance2DistrictLevelVariance = $coordinationAllowance2DistrictLevelAdvanced - $coordinationAllowance2DistrictLevelSpent;
                    $transport2DistrictLevelAllowanceVariance = $transport2DistrictLevelAllowanceAdvanced - $transport2DistrictLevelAllowanceSpent;
                    $airTime2DistrictLevelVariance = $airTime2DistrictLevelAdvanced - $airTime2DistrictLevelSpent;
                    $facilitationFeeVariance = $facilitationFeeAdvanced - $facilitationFeeSpent;
                    $lunchTeacherTrainingDivLevelVariance = $lunchTeacherTrainingDivLevelAdvanced - $lunchTeacherTrainingDivLevelSpent;
                    $transportTeacherTrainingVariance = $transportTeacherTrainingAdvanced - $transportTeacherTrainingSpent;
                    $airTimeDivLevelVariance = $airTimeDivLevelAdvanced - $airTimeDivLevelSpent;
                    $teacherTransportVariance = $teacherTransportAdvanced - $teacherTransportSpent;
                    $hallRentalVariance = $hallRentalAdvanced - $hallRentalSpent;
                    $teaVariance = $teaAdvanced - $teaSpent;
                    $stationeryVariance = $stationeryAdvanced - $stationerySpent;
                    $airTimeHeadTeachersVariance = $airTimeHeadTeachersAdvanced - $airTimeHeadTeachersSpent;
                    $bankChargesVariance = $bankChargesAdvanced - $bankChargesSpent;
                    $courierAmountVariance = $courierAmountAdvanced - $courierAmountSpent;
                    $otherAllowancesAmountVariance = $otherAllowancesAmountAdvanced - $otherAllowancesAmountSpent;
                    $totalAboveAmountVariance = $totalAboveAmountAdvanced - $totalAboveAmountSpent;
                    $totalAmountVariance = $totalAmountAdvanced - $totalAmountSpent;
 

                    $date = date("Y-m-d");

                    $_GET[] = "";
                    ?>
                    <tr style="border-bottom: 1px solid #B4B5B0;">

                      <td align="left" width="20px"> <?php echo $id; ?>  </td>
                      <td align="left" width="20px"> <?php echo $name; ?>  </td>
                      <td align="left" width="30px"> <?php echo $preparedBy; ?>  </td>
                      <td align="left" width="40px"> <?php echo $date; ?>  </td>
                      <td align="center" width="20px"><a href="TTREform.php?id=<?php echo $id ?>#openModal" ><img src="../images/icons/view2.png" height="20px"/></a></td>
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
    <h2 style="margin-left:35%">Edit Reconciliation Form</h2>


    <form method="POST">
      <a href="TTREform.php" title="Close" class="btn btn-danger" style="position:absolute; margin-left:90%;margin-top:0%;">X</a>
      <h2 style="background:#bada66; color:#FFF"><?php echo $updateResult; ?></h2>
      <table border="0"cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <td>Name</td><td><input type="text" id="receiver_name" name="receiver_name" value="<?php echo $name; ?>" /></td>
            <td>Date</td><td><input type="text" id="amount" name="amount" value="<?php echo date('Y-m-d'); ?>" readonly/></td>
            <td>Amount in (Words) </td><td><input type="text" style="border:0;width:400px;"name="amount" style="width:200%;font-weight:bolder;" value="<?php echo $amountWords; ?>" readonly/></td>
          </tr>
        </thead>
        <div style="position:absolute;margin-left:75%;margin-top:5%;">
          <label>Remarks</label><br/><textarea style="max-width:250px;min-width:150px;width:250px;max-height:350px;" name="remarks"><?php echo $remarks; ?></textarea></td>

          <label for="preparedBy">Prepared By</label>
          <select name="preparedBy">
            <option selected="selected" value="<?php echo $preparedBy; ?>"><?php echo $preparedBy; ?></option>

            <?php
            $sql = "select staff_name from staff";
            $results = mysql_query($sql);
            while ($row = mysql_fetch_array($results)) {
              echo "<option value=" . $row["staff_name"] . ">" . $row["staff_name"] . "</option>";
            }
            ?>
          </select>
          <br/><br/><br/>
          <input type="submit" class="btn btn-success" name="updateRecord" value="Update Details" />
        </div>

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
            <td>1</td><td>Coordination Allowance for DEO</td><td><input type="text" id="mdcoordinationAllowanceDEOAdvanced" name="coordinationAllowanceDEOAdvanced" value="<?php echo $coordinationAllowanceDEOAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdcoordinationAllowanceDEOAdvanced2Span"/></span></td><td><input type="text" id="mdcoordinationAllowanceDEOSpent" name="coordinationAllowanceDEOSpent" value="<?php echo $coordinationAllowanceDEOSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdcoordinationAllowanceDEOSpentSpan"/></span></td><td><input type="text" id="mdcoordinationAllowanceDEOVariance" name="coordinationAllowanceDEOVariance" value="<?php echo $coordinationAllowanceDEOVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdcoordinationAllowanceDEOVarianceSpan"/></span></td>
          </tr>
          <tr>
            <td>2</td><td>Transport for DEO</td><td><input type="text" id="mdtransportDEOAdvanced" name="transportDEOAdvanced" value="<?php echo $transportDEOAdvanced ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtransportDEOAdvancedSpan"/></span></td><td><input type="text" id="mdtransportDEOSpent" name="transportDEOSpent" value="<?php echo $transportDEOSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtransportDEOSpentSpan"/></span></td><td><input type="text" id="mdtransportDEOVariance" name="transportDEOVariance" value="<?php echo $transportDEOVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtransportDEOVarianceSpan"/></span></td>

          </tr>
          <tr>
            <td>3</td><td>AirTime for DEO</td><td><input type="text" id="mdairTimeDEOAdvanced" name="airTimeDEOAdvanced" value="<?php echo $airTimeDEOAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdairTimeDEOAdvancedSpan"/></span></td><td><input type="text" id="mdairTimeDEOSpent" name="airTimeDEOSpent" value="<?php echo $airTimeDEOSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdairTimeDEOSpentSpan"/></span></td><td><input type="text" id="mdairTimeDEOVariance" name="airTimeDEOVariance" value="<?php echo $airTimeDEOVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdairTimeDEOVarianceSpan"/></span></td>

          </tr>
          <tr>
            <td>4</td><td>Transport for Distributing All Training Materials</td><td><input type="text" id="mdtransportTrainingMaterialsAllowanceAdvanced" name="transportTrainingMaterialsAllowanceAdvanced" value="<?php echo $transportTrainingMaterialsAllowanceAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtransportTrainingMaterialsAllowanceAdvancedSpan"/></span></td><td><input type="text" id="mdtransportTrainingMaterialsAllowanceSpent" name="transportTrainingMaterialsAllowanceSpent" value="<?php echo $transportTrainingMaterialsAllowanceSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtransportTrainingMaterialsAllowanceSpentSpan"/></span></td><td><input type="text" id="mdtransportTrainingMaterialsAllowanceVariance" name="transportTrainingMaterialsAllowanceVariance" value="<?php echo $transportTrainingMaterialsAllowanceVariance ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtransportTrainingMaterialsAllowanceVarianceSpan"/></span></td>
          </tr>
          <tr>
            <td>5</td><td>Driver's Lunch</td><td><input type="text" id="mddriverLunchAllowanceAdvanced" name="driverLunchAllowanceAdvanced" value="<?php echo $driverLunchAllowanceAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mddriverLunchAllowanceAdvancedSpan"/></span></td><td><input type="text" id="mddriverLunchAllowanceSpent" name="driverLunchAllowanceSpent" value="<?php echo $driverLunchAllowanceSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mddriverLunchAllowanceSpentSpan"/></span></td><td><input type="text" id="mddriverLunchAllowanceVariance" name="driverLunchAllowanceVariance" value="<?php echo $driverLunchAllowanceVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mddriverLunchAllowanceVarianceSpan"/></span></td>

          </tr>
          <tr>
            <td>6</td><td>Coordination Allowance to 2 District Level Personnel</td><td><input type="text" id="mdcoordinationAllowance2DistrictLevelAdvanced" name="coordinationAllowance2DistrictLevelAdvanced" value="<?php echo $coordinationAllowance2DistrictLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdcoordinationAllowance2DistrictLevelAdvancedSpan"/></span></td><td><input type="text" id="mdcoordinationAllowance2DistrictLevelSpent" name="coordinationAllowance2DistrictLevelSpent" value="<?php echo $coordinationAllowance2DistrictLevelSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdcoordinationAllowance2DistrictLevelSpentSpan"/></span></td><td><input type="text" id="mdcoordinationAllowance2DistrictLevelVariance"  name="coordinationAllowance2DistrictLevelVariance" value="<?php echo $coordinationAllowance2DistrictLevelVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdcoordinationAllowance2DistrictLevelVarianceSpan"/></span></td>

          </tr>
          <tr>
            <td>7</td><td>Transport for 2 District Personnel</td><td><input type="text" id="mdtransport2DistrictLevelAllowanceAdvanced" name="transport2DistrictLevelAllowanceAdvanced" value="<?php echo $transport2DistrictLevelAllowanceAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtransport2DistrictLevelAllowanceAdvancedSpan"/></span></td><td><input type="text" id="mdtransport2DistrictLevelAllowanceSpent"  name="transport2DistrictLevelAllowanceSpent" value="<?php echo $transport2DistrictLevelAllowanceSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtransport2DistrictLevelAllowanceSpentSpan"/></span></td><td><input type="text" id="mdtransport2DistrictLevelAllowanceVariance" name="transport2DistrictLevelAllowanceVariance" value="<?php echo $transport2DistrictLevelAllowanceVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtransport2DistrictLevelAllowanceVarianceSpan"/></span></td>

          </tr>
          <tr>
            <td>8</td><td>Airtime for 2 District Personnel</td><td><input type="text" id="mdairTime2DistrictLevelAdvanced" name="airTime2DistrictLevelAdvanced" value="<?php echo $airTime2DistrictLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdairTime2DistrictLevelAdvancedSpan"/></span></td><td><input type="text" id="mdairTime2DistrictLevelSpent" name="airTime2DistrictLevelSpent" value="<?php echo $airTime2DistrictLevelSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdairTime2DistrictLevelSpentSpan"/></span></td><td><input type="text" id="mdairTime2DistrictLevelVariance" name="airTime2DistrictLevelVariance" value="<?php echo $airTime2DistrictLevelVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdairTime2DistrictLevelVarianceSpan"/></span></td>

          </tr>
          <tr>
            <td>9</td><td>Facilitation Fee for Teacher Training Sessions</td><td><input type="text" id="mdfacilitationFeeAdvanced" name="facilitationFeeAdvanced" value="<?php echo $facilitationFeeAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdfacilitationFeeAdvancedSpan"/></span></td><td><input type="text" id="mdfacilitationFeeSpent" name="facilitationFeeSpent" value="<?php echo $facilitationFeeSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdfacilitationFeeSpentSpan"/></span></td><td><input type="text" id="mdfacilitationFeeVariance" name="facilitationFeeVariance" value="<?php echo $facilitationFeeVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdfacilitationFeeVarianceSpan"/></span></td>
          </tr>
          <tr>
            <td>10</td><td>Lunch During Teacher Training Sessions</td><td><input type="text" id="mdlunchTeacherTrainingDivLevelAdvanced" name="lunchTeacherTrainingDivLevelAdvanced" value="<?php echo $lunchTeacherTrainingDivLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdlunchTeacherTrainingDivLevelAdvancedSpan"/></span></td><td><input type="text" id="mdlunchTeacherTrainingDivLevelSpent" name="lunchTeacherTrainingDivLevelSpent" value="<?php echo $lunchTeacherTrainingDivLevelSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdlunchTeacherTrainingDivLevelSpentSpan"/></span></td><td><input type="text" id="mdlunchTeacherTrainingDivLevelVariance" name="lunchTeacherTrainingDivLevelVariance" value="<?php echo $lunchTeacherTrainingDivLevelVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdlunchTeacherTrainingDivLevelVarianceSpan"/></span></td>
          </tr>
          <tr>
            <td>11</td><td>Transport to Teacher Training Sessions</td><td><input type="text" id="mdtransportTeacherTrainingAdvanced" name="transportTeacherTrainingAdvanced" value="<?php echo $transportTeacherTrainingAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtransportTeacherTrainingAdvancedSpan"/></span></td><td><input type="text" id="mdtransportTeacherTrainingSpent" name="transportTeacherTrainingSpent" value="<?php echo $transportTeacherTrainingSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtransportTeacherTrainingSpentSpan"/></span></td><td><input type="text" id="mdtransportTeacherTrainingVariance" name="transportTeacherTrainingVariance" value="<?php echo $transportTeacherTrainingVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtransportTeacherTrainingVarianceSpan"/></span></td>
          </tr>
          <tr><td>12</td>
            <td>AirTime for All Division Level Personnel</td><td><input type="text" id="mdairTimeDivLevelAdvanced" name="airTimeDivLevelAdvanced" value="<?php echo $airTimeDivLevelAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdairTimeDivLevelAdvancedSpan"/></span></td><td><input type="text" id="mdairTimeDivLevelSpent" name="airTimeDivLevelSpent" value="<?php echo $airTimeDivLevelSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdairTimeDivLevelSpentSpan"/></span></td><td><input type="text" id="mdairTimeDivLevelVariance" name="airTimeDivLevelVariance" value="<?php echo $airTimeDivLevelVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdairTimeDivLevelVarianceSpan"/></span></td>
          </tr>
          <tr>
            <td>13</td><td>Teachers' Transport And Lunch</td><td><input type="text" id="mdteacherTransportAdvanced" name="teacherTransportAdvanced" value="<?php echo $teacherTransportAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdteacherTransportAdvancedSpan"/></span></td><td><input type="text" id="mdteacherTransportSpent"  name="teacherTransportSpent" value="<?php echo $teacherTransportSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdteacherTransportSpentSpan"/></span></td><td><input type="text" id="mdteacherTransportVariance" name="teacherTransportVariance" value="<?php echo $teacherTransportVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdteacherTransportVarianceSpan"/></span></td>

          </tr>
          <tr>
            <td>14</td><td>Hall Rental</td><td><input type="text" id="mdhallRentalAdvanced" name="hallRentalAdvanced" value="<?php echo $hallRentalAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdhallRentalAdvancedSpan"/></span></td><td><input type="text" id="mdhallRentalSpent" name="hallRentalSpent" value="<?php echo $hallRentalSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdhallRentalSpentSpan"/></span></td><td><input type="text" id="mdhallRentalVariance" name="hallRentalVariance" value="<?php echo $hallRentalVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdhallRentalVarianceSpan"/></span></td>

          </tr>
          <tr>
            <td>15</td><td>Tea</td><td><input type="text" id="mdteaAdvanced" name="teaAdvanced" value="<?php echo $teaAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdteaAdvancedSpan"/></span></td><td><input type="text" id="mdteaSpent" name="teaSpent" value="<?php echo $teaSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdteaSpentSpan"/></span></td><td><input type="text" id="mdteaVariance" name="teaVariance" value="<?php echo $teaVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdteaVarianceSpan"/></span></td>

          </tr>

          <tr>
            <td>16</td><td>Stationery</td><td><input type="text" id="mdstationeryAdvanced" name="stationeryAdvanced" value="<?php echo $stationeryAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdstationeryAdvancedSpan"/></span></td><td><input type="text" id="mdstationerySpent" name="stationerySpent" value="<?php echo $stationerySpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdstationerySpentSpan"/></span></td><td><input type="text" id="mdstationeryVariance" name="stationeryVariance" value="<?php echo $stationeryVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdstationeryVarianceSpan"/></span></td>

          </tr>


          <tr>
            <td>17</td><td>Airtime for HeadTeachers Only</td><td><input type="text" id="mdairTimeHeadTeachersAdvanced" name="airTimeHeadTeachersAdvanced" value="<?php echo $airTimeHeadTeachersAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdairTimeHeadTeachersAdvancedSpan"/></span></td><td><input type="text" id="mdairTimeHeadTeachersSpent" name="airTimeHeadTeachersSpent" value="<?php echo $airTimeHeadTeachersSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdairTimeHeadTeachersSpentSpan"/></span></td><td><input type="text" id="mdairTimeHeadTeachersVariance" name="airTimeHeadTeachersVariance" value="<?php echo $airTimeHeadTeachersVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdairTimeHeadTeachersVarianceSpan"/></span></td>
          </tr>
          <tr>
            <tr>
              <td>18</td><td>Bank Charges</td><td><input type="text" id="mdbankChargesAdvanced" name="bankChargesAdvanced" value="<?php echo $bankChargesAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdbankChargesAdvancedSpan"/></span></td><td><input type="text" id="mdbankChargesSpent" name="bankChargesSpent" value="<?php echo $bankChargesSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdbankChargesSpentSpan"/></span></td><td><input type="text" id="mdbankChargesVariance" name="bankChargesVariance" value="<?php echo $bankChargesVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdbankChargesVarianceSpan"/></span></td>
            </tr>
            <tr>
              <td>19</td><td>G4 Courier Services</td><td><input type="text" id="mdcourierAmountAdvanced" name="courierAmountAdvanced" value="<?php echo $courierAmountAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdcourierAmountAdvancedSpan"/></span></td><td><input type="text" id="mdcourierAmountSpent" name="courierAmountSpent" value="<?php echo $courierAmountSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdcourierAmountSpentSpan"/></span></td><td><input type="text" id="mdcourierAmountVariance" name="courierAmountVariance" value="<?php echo $courierAmountVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdcourierAmountVarianceSpan"/></span></td>
            </tr>
            <tr>
              <td>20</td><td>Other Allowed Allowances</td><td><input type="text" id="mdotherAllowancesAmountAdvanced" name="otherAllowancesAmountAdvanced" value="<?php echo $otherAllowancesAmountAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdotherAllowancesAmountAdvancedSpan"/></span></td><td><input type="text" id="mdotherAllowancesAmountSpent" name="otherAllowancesAmountSpent" value="<?php echo $otherAllowancesAmountSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdotherAllowancesAmountSpentSpan"/></span></td><td><input type="text" id="mdotherAllowancesAmountVariance" name="otherAllowancesAmountVariance" value="<?php echo $otherAllowancesAmountVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdotherAllowancesAmountVarianceSpan"/></span></td>
            </tr>
            <tr>
              <td>21</td><td><b>Total Above</b></td><td><input type="text" id="mdtotalAboveAmountAdvanced" name="totalAboveAmountAdvanced" value="<?php echo $totalAboveAmountAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtotalAboveAmountAdvancedSpan"/></span></td><td><input type="text" id="mdtotalAboveAmountSpent" name="totalAboveAmountSpent" value="<?php echo $totalAboveAmountSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtotalAboveAmountSpentSpan"/></span></td><td><input type="text" id="mdtotalAboveAmountVariance"  name="totalAboveAmountVariance" value="<?php echo $totalAboveAmountVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtotalAboveAmountVarianceSpan"/></span></td>
            </tr>
            <tr>
              <td>22</td><td><b>Total Amount</b></td><td><input type="text" id="mdtotalAmountAdvanced" name="totalAmountAdvanced" value="<?php echo $totalAmountAdvanced; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtotalAmountAdvancedSpan"/></span></td><td><input type="text" id="mdtotalAmountSpent" name="totalAmountSpent" value="<?php echo $totalAmountSpent; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtotalAmountSpentSpan"/></span></td><td><input type="text" id="mdtotalAmountVariance" name="totalAmountVariance" value="<?php echo $totalAmountVariance; ?>" onKeyUp="isNumeric(this.id);"/><span id="mdtotalAmountVarianceSpan"/></span></td>
            </tr>
            <tr>
            </tr>
        </tbody>
      </table>


      </tbody>
      </table>
    </form>





  </div>
</div>
<script src="js/ttreform.js"></script>