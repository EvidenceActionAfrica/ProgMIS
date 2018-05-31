<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
$testdata = 'testdata';
$tabActive = 'tab1';
if ($_GET["tabActive"] == 3) {
    $tabActive = "tab3";
}
if (isset($_POST["saveRecord"])) {

    $tabActive = 'tab1';
    $listed_km = isset($_POST["listed_km"]) ? mysql_real_escape_string($_POST["listed_km"]) : "";
    $km_rate = isset($_POST["km_rate"]) ? mysql_real_escape_string($_POST["km_rate"]) : "";

    $totalAmount = isset($_POST["totalAmount"]) ? mysql_real_escape_string($_POST["totalAmount"]) : 0;

    $fromDestination = isset($_POST["fromDestination"]) ? mysql_real_escape_string($_POST["fromDestination"]) : "";
    $toDestination = isset($_POST["toDestination"]) ? mysql_real_escape_string($_POST["toDestination"]) : "";
    $driverPerDiem = isset($_POST["driverPerDiem"]) ? mysql_real_escape_string($_POST["driverPerDiem"]) : "";
    $kemsaLoadersDestination = isset($_POST["kemsaLoadersDestination"]) ? mysql_real_escape_string($_POST["kemsaLoadersDestination"]) : "";
    $kemsaLoadersOrigin = isset($_POST["kemsaLoadersOrigin"]) ? mysql_real_escape_string($_POST["kemsaLoadersOrigin"]) : "";
    $airTime = isset($_POST["airTime"]) ? $_POST["airTime"] : "";
    $MOPHS = isset($_POST["MOPHS"]) ? mysql_real_escape_string($_POST["MOPHS"]) : "";
    $fuelNeed = isset($_POST["fuel"]) ? $_POST["fuel"] : 0;
    $service = isset($_POST["service"]) ? mysql_real_escape_string($_POST["service"]) : "";
    $incidentals = isset($_POST["incidentals"]) ? mysql_real_escape_string($_POST["incidentals"]) : "";

    $incidentalsCashCollection = isset($_POST["incidentalsCashCollection"]) ? mysql_real_escape_string($_POST["incidentalsCashCollection"]) : "";
    $airTimeMOCashCol = isset($_POST["airTimeMOCashCol"]) ? mysql_real_escape_string($_POST["airTimeMOCashCol"]) : "";

    $MOPHSCashCollection = isset($_POST["MOPHSCashCollection"]) ? mysql_real_escape_string($_POST["MOPHSCashCollection"]) : "";
    $serviceCashCollection = isset($_POST["serviceCashCollection"]) ? mysql_real_escape_string($_POST["serviceCashCollection"]) : "";
    $kemsaLoadersOriginCashCollection = isset($_POST["kemsaLoadersOriginCashCollection"]) ? mysql_real_escape_string($_POST["kemsaLoadersOriginCashCollection"]) : "";
    $kemsaLoadersDestinationCashCollection = isset($_POST["kemsaLoadersDestinationCashCollection"]) ? mysql_real_escape_string($_POST["kemsaLoadersDestinationCashCollection"]) : "";
    $driverPerDiemCashCollection = isset($_POST["driverPerDiemCashCollection"]) ? mysql_real_escape_string($_POST["driverPerDiemCashCollection"]) : "";

    $incidentalsDays = isset($_POST["incidentalsDays"]) ? mysql_real_escape_string($_POST["incidentalsDays"]) : "";
    $airTimeDays = isset($_POST["airTimeDays"]) ? mysql_real_escape_string($_POST["airTimeDays"]) : "";
    $MOPHSDays = isset($_POST["MOPHSDays"]) ? mysql_real_escape_string($_POST["MOPHSDays"]) : "";
    $serviceDays = isset($_POST["serviceDays"]) ? mysql_real_escape_string($_POST["serviceDays"]) : "";
    $kemsaLoadersOriginDays = isset($_POST["kemsaLoadersOriginDays"]) ? mysql_real_escape_string($_POST["kemsaLoadersOriginDays"]) : "";
    $kemsaLoadersDestinationDays = isset($_POST["kemsaLoadersDestinationDays"]) ? mysql_real_escape_string($_POST["kemsaLoadersDestinationDays"]) : "";
    $driverPerDiemDays = isset($_POST["driverPerDiemDays"]) ? mysql_real_escape_string($_POST["driverPerDiemDays"]) : "";

//echo "The value of fuel is ".$_POST["fuel"];
    /*
      $sql = "INSERT INTO `drugs_dispatch_transport`(`listed_km`, `km_rate`, `fuel_needed`, `mophs`, `mophs_cash_collection`, `service`, `service_cash_collection`, `incidentals`, `incidentals_cash_collection`, `airtime_mophs`, `airtime_mophs_cash_collection`, `kemsa_loaders_nairobi`, `kemsa_loaders_nairobi_cash_collection`, `kemsa_loaders_mombasa`, `kemsa_loaders_mombasa_cash_collection`, `driver_per_diem`, `driver_per_diem_cash_collection`, `total_amount`, `todestination`, `fromDestination`)";
      $sql.=" VALUES ('$listed_km','$km_rate','$fuelNeed','$MOPHS','$MOPHSCashCollection','$service','$serviceCashCollection','$incidentals','$incidentalsCashCollection'";
      $sql.=",'$airTime','$airTimeMOCashCol','$kemsaLoadersOrigin','$kemsaLoadersOriginCashCollection','$kemsaLoadersDestination','$kemsaLoadersDestinationCashCollection','$driverPerDiem','$driverPerDiemCashCollection','$totalAmount','$toDestination','$fromDestination')";

     */
    $sql = "INSERT INTO `drugs_dispatch_transport`(`listed_km`, `km_rate`, `fuel_needed`, `mophs`,";
    $sql.="`mophs_days`, `mophs_cash_collection`, `service`, `service_days`, `service_cash_collection`, `incidentals`,";
    $sql.="`incidentals_days`, `incidentals_cash_collection`, `airtime_mophs`, `air_time_days`, ";
    $sql.="`airtime_mophs_cash_collection`, `kemsa_loaders_origin`, `kemsa_loaders_origin_days`,";
    $sql.="`kemsa_loaders_origin_cash_collection`, `kemsa_loaders_destination`, `kemsa_loaders_destination_days`,";
    $sql.="`kemsa_loaders_destination_cash_collection`, `driver_per_diem`, `driver_per_diem_days`,";
    $sql.="`driver_per_diem_cash_collection`, `total_amount`, `todestination`, `fromDestination`) ";
    $sql.="VALUES ('$listed_km','$km_rate','$fuelNeed','$MOPHS','$MOPHSDays','$MOPHSCashCollection'";
    $sql.=",'$service','$serviceDays','$serviceCashCollection','$incidentals','$incidentalsDays',";
    $sql.="'$incidentalsCashCollection','$airTime','$airTimeDays','$airTimeMOCashCol','$kemsaLoadersOrigin'";
    $sql.=",'$kemsaLoadersOriginDays','$kemsaLoadersOriginCashCollection','$kemsaLoadersDestination',";
    $sql.="'$kemsaLoadersDestinationDays',";
    $sql.="'$kemsaLoadersDestinationCashCollection','$driverPerDiem','$driverPerDiemDays','$driverPerDiemCashCollection','$totalAmount','$toDestination','$fromDestination')";



    mysql_query($sql) or die("Cannot save This data" . mysql_error());
}

if (isset($_Post['']))

if (isset($_GET['deleteid'])) {
    $tabActive = 'tab2';
}if (isset($_POST["updateRecord"])) {
                               
       $tabActive = 'tab2';                       
        //echo "The amount is ".$_POST["total"];
        //  $tabActive = 'tab2';
        $moh_id=$_POST["moh_id"];
        $listed_km = isset($_POST["listed_km"]) ? mysql_real_escape_string($_POST["listed_km"]) : "";
        $km_rate = isset($_POST["km_rate"]) ? mysql_real_escape_string($_POST["km_rate"]) : "";

        $totalAmount = isset($_POST["totalAmount"]) ? mysql_real_escape_string($_POST["totalAmount"]) : 0;

        $driverPerDiem = isset($_POST["driverPerDiem"]) ? mysql_real_escape_string($_POST["driverPerDiem"]) : "";
        $kemsaLoadersDestination = isset($_POST["kemsaLoadersDestination"]) ? mysql_real_escape_string($_POST["kemsaLoadersDestination"]) : "";
        $kemsaLoadersOrigin = isset($_POST["kemsaLoadersOrigin"]) ? mysql_real_escape_string($_POST["kemsaLoadersOrigin"]) : "";
        $airTime = isset($_POST["airTime"]) ? $_POST["airTime"] : "";
        $MOPHS = isset($_POST["MOPHS"]) ? mysql_real_escape_string($_POST["MOPHS"]) : "";
        $fuel = isset($_POST["fuel"]) ? $_POST["fuel"] : "";
        $service = isset($_POST["service"]) ? mysql_real_escape_string($_POST["service"]) : "";
        $incidentals = isset($_POST["incidentals"]) ? mysql_real_escape_string($_POST["incidentals"]) : "";
        $incidentalsCashCollection = isset($_POST["incidentalsCashCollection"]) ? mysql_real_escape_string($_POST["incidentalsCashCollection"]) : "";
        $airTimeMoCashCol = isset($_POST["airTimeMOCashCol"]) ? mysql_real_escape_string($_POST["airTimeMOCashCol"]) : "";
        
       $MOPHSCashCollection = isset($_POST["MOPHSCashCollection"]) ? mysql_real_escape_string($_POST["MOPHSCashCollection"]) : "";
        $serviceCashCollection = isset($_POST["serviceCashCollection"]) ? mysql_real_escape_string($_POST["serviceCashCollection"]) : "";
        $kemsaLoadersOriginCashCollection = isset($_POST["kemsaLoadersOriginCashCollection"]) ? mysql_real_escape_string($_POST["kemsaLoadersOriginCashCollection"]) : "";
        $kemsaLoadersDestinationCashCollection = isset($_POST["kemsaLoadersDestinationCashCollection"]) ? mysql_real_escape_string($_POST["kemsaLoadersDestinationCashCollection"]) : "";
        $driverPerDiemCashCollection = isset($_POST["driverPerDiemCashCollection"]) ? mysql_real_escape_string($_POST["driverPerDiemCashCollection"]) : "";

        $kemsaLoadersOriginDays =isset($_POST["kemsaLoadersOriginDays"]) ?$_POST["kemsaLoadersOriginDays"]:"";
        $kemsaLoadersDestinationDays =isset($_POST["kemsaLoadersDestinationDays"])?$_POST["kemsaLoadersDestinationDays"]:"";
        $MOPHSDays =isset($_POST["MOPHSDays"])?$_POST["MOPHSDays"]:"";
        $serviceDays = isset($_POST["serviceDays"])?$_POST["serviceDays"]:"";
        $driverPerDiemDays =isset($_POST["driverPerDiemDays"])?$_POST["driverPerDiemDays"]:"";
        $airTimeDays =isset($_POST["airTimeDays"])?$_POST["airTimeDays"]:"";
        $incidentalsDays =isset($_POST["incidentalsDays"])?$_POST["incidentalsDays"]:"";

        $todestination =isset($_POST["toDestination"])?$_POST["toDestination"]:"";
        $fromDestination =isset($_POST["fromDestination"])?$_POST["fromDestination"]:"";

        
       // $query = "UPDATE `drugs_dispatch_transport` SET `listed_km`='$listed_km',`km_rate`='$km_rate',`fuel_needed`='$fuel',`mophs`='$MOPHS',`mophs_cash_collection`='$MOPHSCashCollection',`service`='$service',`service_cash_collection`='$serviceCashCollection',`incidentals`='$incidentals',`incidentals_cash_collection`='$incidentalsCashCollection',`airtime_mophs`='$airTime',`airtime_mophs_cash_collection`='$airTimeMoCashCol',`kemsa_loaders_nairobi`='$kemsaLoadersOrigin',`kemsa_loaders_nairobi_cash_collection`='$kemsaLoadersOriginCashCollection ',`kemsa_loaders_mombasa`='$kemsaLoadersDestination',`kemsa_loaders_mombasa_cash_collection`='$kemsaLoadersDestinationCashCollection',`driver_per_diem`='$driverPerDiem',`driver_per_diem_cash_collection`='$driverPerDiemCashCollection',`total_amount`='$total' WHERE moh_id='$viewId'";
        $query="UPDATE `drugs_dispatch_transport` SET `listed_km`='$listed_km',";
        $query.="`km_rate`='$km_rate',`fuel_needed`='$fuel',`mophs`='$MOPHS',";
        $query.="`mophs_days`='$MOPHSDays',`mophs_cash_collection`='$MOPHSCashCollection',";
        $query.="`service`='$service',`service_days`='$serviceDays',`service_cash_collection`='$serviceCashCollection',";
        $query.="`incidentals`='$incidentals',`incidentals_days`='$incidentalsDays',`incidentals_cash_collection`='$incidentalsCashCollection'";
        $query.=",`airtime_mophs`='$airTime',`air_time_days`='$airTimeDays',`airtime_mophs_cash_collection`='$airTimeMoCashCol'";
        $query.=",`kemsa_loaders_origin`='$kemsaLoadersOrigin',`kemsa_loaders_origin_days`='$kemsaLoadersOriginDays',";
        $query.="`kemsa_loaders_origin_cash_collection`='$kemsaLoadersOriginCashCollection',`kemsa_loaders_destination`='$kemsaLoadersDestination'";
        $query.=",`kemsa_loaders_destination_days`='$kemsaLoadersDestinationDays',`kemsa_loaders_destination_cash_collection`='$kemsaLoadersDestinationCashCollection',`driver_per_diem`='$driverPerDiem',";
        $query.="`driver_per_diem_days`='$driverPerDiemDays',`driver_per_diem_cash_collection`='$driverPerDiemCashCollection',`total_amount`='$totalAmount',`todestination`='$todestination',`fromDestination`='$fromDestination' WHERE moh_id='$moh_id'";
      
        $result = mysql_query($query) or die("<h1>Could not update</h1><br/>" . mysql_error());
        
    }

if (isset($_POST['exportExcel'])) {

    $data = array(
        array (
          'item_title'  => 'MoPHS Rep Per diem number of days-Job Group N',
          'days'        => $_POST['MOPHSDays'],
          'unit'        => $_POST['MOPHSUnitCost'],
          'responsible' => $_POST['MOPHS'],
          'cost'        => $_POST['MOPHSCashCollection']
        ),
        array(
          'item_title'  => 'Driver\'s Per diem number of days-Job Group G',
          'days'        => $_POST['driverPerDiemDays'],
          'unit'        => $_POST['driverPerDiemUnitCost'],
          'responsible' => $_POST['driverPerDiem'],
          'cost'        => $_POST['driverPerDiemCashCollection']
        ),
        array(
          'item_title'  => 'Service/Maintenance Amount',
          'days'        => $_POST['serviceDays'],
          'unit'        => $_POST['serviceUnitCost'],
          'responsible' => $_POST['service'],
          'cost'        => $_POST['serviceCashCollection']
        ),
        array(
          'item_title'  => 'Incidentals (Refundable if vehicle does not breakdown)',
          'days'        => $_POST['incidentalsDays'],
          'unit'        => $_POST['incidentalsUnitCost'],
          'responsible' => $_POST['incidentals'],
          'cost'        => $_POST['incidentalsCashCollection']
        ),
        array(
          'item_title'  => 'Airtime for MoPHS Rep',
          'days'        => $_POST['airTimeDays'],
          'unit'        => $_POST['airTimeUnitCost'],
          'responsible' => $_POST['airTime'],
          'cost'        => $_POST['airTimeMOCashCol']
        ),
        array(
          'item_title'  => 'KEMSA Loaders (Origin)',
          'days'        => $_POST['kemsaLoadersOriginDays'],
          'unit'        => $_POST['kemsaLoadersOriginUnitCost'],
          'responsible' => $_POST['kemsaLoadersOrigin'],
          'cost'        => $_POST['kemsaLoadersOriginCashCollection']
        ),
        array(
          'item_title'  => 'KEMSA Loaders (Destination)',
          'days'        => $_POST['kemsaLoadersDestinationDays'],
          'unit'        => $_POST['kemsaLoadersDestinationUnitCost'],
          'responsible' => $_POST['kemsaLoadersDestination'],
          'cost'        => $_POST['kemsaLoadersDestinationCashCollection']
        )
    );

    /** Include PHPExcel */
    require_once '../PHPExcel/Classes/PHPExcel.php';

    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                 ->setLastModifiedBy("Maarten Balliauw")
                                 ->setTitle("Office 2007 XLSX Test Document")
                                 ->setSubject("Office 2007 XLSX Test Document")
                                 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                 ->setKeywords("office 2007 openxml php")
                                 ->setCategory("Test result file");

    $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
    $objPHPExcel->getActiveSheet()->getStyle('A1:E1')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
    $objPHPExcel->getActiveSheet()->getStyle('A2:E2')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
    $objPHPExcel->getActiveSheet()->getStyle('A3:E3')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->mergeCells('A4:E4');
    $objPHPExcel->getActiveSheet()->getStyle('A4:E4')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Add header data
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Moh calculation Table Description')
                ->setCellValue('A2', 'From '.$_POST['fromDestination'].' To '.$_POST['toDestination'].'')
                ->setCellValue('A3', 'Distance x Kilometer Rate (KES) = Fuel Cost')
                ->setCellValue('A4', $_POST['listed_km'].' x '.$_POST['km_rate'].' = '.$_POST['listed_km']*$_POST['km_rate'].'')
                ->setCellValue('A5', 'Factors')
                ->setCellValue('B5', 'No Of Days')
                ->setCellValue('C5', 'Unit Cost')
                ->setCellValue('D5', 'Person Responsible')
                ->setCellValue('E5', 'Cost')
                ;

    // Add body data
    $row = 6;
    foreach ($data as $key => $value) {
        $col = A;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col.$row, $value['item_title']);$col++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col.$row, $value['days']);$col++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col.$row, $value['unit']);$col++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col.$row, $value['responsible']);$col++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col.$row, $value['cost']);$col++;
        $row++;
    }

    $objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
    $objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':D'.$row.'');

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row, 'TOTAL IMPREST AMOUNT TO BE PAID ON DEPARTURE')
            ->setCellValue('E'.$row, $_POST['totalAmount'])
    ;



    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Dispatch Transport calculation');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Excel5)
    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Moh_calculation_Table_Description.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');    
    exit;   

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

        <?php require_once ("includes/meta-link-script.php"); ?>
        <script src="../js/tabs.js"></script>
    </head>
    <body >
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
                    // require_once ("includes/menuLeftBar-Drugs.php");
                    $dispatchtranport = true; require_once ("../finance/includes/menuLeftBar-Settings.php");
                ?>
            </div>
            <div class="contentBody" >


                <div class="tabbable" style="width:100%">
                    <ul class="nav nav-tabs">
                        <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Moh calculation Table</a></li>
                        <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">View Moh calculation Table History</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1" style="width:90%; height: 150%">

                            <div margin-top="-5%"> 

                                <center>
                                    <br/><br/><b><h2 size="5px">Moh calculation Table Description</h2></b>
                                </center>

                            </div></br>
                            <form action="dispatchTransport.php" method="post">
                                <center>
                                    <b>  From Depot </b>
                                    <select style="width:12%" name="fromDestination" required>
                                        <option value=''></option>
                                        <option value='Eldoret'> Eldoret</option>
                                        <option value='Kakamega'>  Kakamega</option>
                                        <option value='Kisumu'> Kisumu</option>
                                        <option value='Mombasa'>Mombasa</option>
                                        <option value='Nairobi'> Nairobi</option>
                                        <option value='Nakuru'> Nakuru</option>
                                    </select>

                                    <b> To </b> 
                                    <select style="width:12%" name="toDestination" required>
                                        <option value=''></option>
                                        <option value='Eldoret'>Eldoret</option>
                                        <option value='Kakamega'>Kakamega</option>
                                        <option value='Kisumu'>Kisumu</option>
                                        <option value='Mombasa'>Mombasa</option>
                                        <option value='Nairobi'> Nairobi</option>
                                        <option value='Nakuru'> Nakuru</option>
                                    </select>
                                </center>

                                <br/>

                                <table align="center" style="margin-left:30%;">
                                    <tr>
                                        <td>Distance</td>
                                        <td>x Kilometer Rate (KES)</td>
                                        <td> = Fuel Cost</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" id="listed_km" name="listed_km" placeholder=""  value="" style="width: 80px"/><span id="spanListedKm" style="color:rgb(240,20,30);font-weight:bold;"></span></td>
                                        <td> x <input type="text" name="km_rate" id="km_rate" placeholder="" value=""  style="width: 120px"/> <span id="spankmRate"  style="color:rgb(240,20,30);font-weight:bold;"></span></td>
                                        <td> = <input type="text"  name="fuel" id="fuel" onkeyup='isNumeric(this.id)' readonly/><span id='fuelSpan'></span></td>
                                    </tr>
                                </table>

                                <br/>

                                <!--<b>Factors</b> <br/><b>Cost</b> -->
                                <!--===--> 

                                <center>
                                    <table style="margin-left:6%;">
                                        <tr>
                                            <td><b>Factors</b></td><td><b>No Of Days</b></td><td><b>Unit Cost</b></td><td><b>Person<br/> Responsible</b></td><td><b>Cost</b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                MoPHS Rep Per diem number of days-Job Group N</label>
                                            </td>
                                            <td>
                                                <input type="text" name="MOPHSDays" id="MOPHSDays" placeholder="Days" value="" style="width: 50px"/>
                                            </td>
                                            <td>
                                                <input type="text" name="MOPHSUnitCost" id="MOPHSUnitCost" placeholder="Unit Cost" value=""/>
                                            </td>
                                            <td>
                                                <input type="text" name="MOPHS" id="MOPHS" placeholder="" value=""/>
                                            </td>
                                            <td>
                                                <label>Cash owed</label>
                                            </td>
                                            <td>
                                                <input style="" type="text" name="MOPHSCashCollection" id="MOPHSCashCollection" placeholder="" value=""onkeyup='isNumeric(this.id)' readonly/><span id='MOPHSCashCollectionSpan'></span>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td><label> Driver's Per diem number of days-Job Group G</label>
                                            </td>
                                            <td>
                                                <input type="text" name="driverPerDiemDays" id="driverPerDiemDays" placeholder="Days" value=""style="width: 50px"/>
                                            </td>
                                            <td>
                                                <input type="text" name="driverPerDiemUnitCost" id="driverPerDiemUnitCost" placeholder="Unit cost" value=""/>
                                            </td>
                                            <td>
                                                <input type="text" name="driverPerDiem" id="driverPerDiem" placeholder="" value=""/>
                                            </td>

                                            <td>
                                                <label>Cash owed </label>
                                            </td>
                                            <td>
                                                <input style=""type="text"  id="driverPerDiemCashCollection" name="driverPerDiemCashCollection" placeholder="" value="" onkeyup='isNumeric(this.id)' readonly/><span id='driverPerDiemCashCollectionSpan'></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Service/Maintenance Amount</label>
                                            </td>
                                            <td>
                                                <input type="text" name="serviceDays" id="serviceDays" placeholder="Days" value=""style="width: 50px"/>
                                            </td>

                                            <td>
                                                <input type="text" name="serviceUnitCost" id="serviceUnitCost" placeholder="Unit Cost" value=""/>
                                            </td>
                                            <td>

                                                <input type="text" name="service" id="service" placeholder="" value="">
                                            </td>
                                            <td>
                                                <label>Cash owed </label>
                                            </td><td>
                                                <input style="" type="text" name="serviceCashCollection" id="serviceCashCollection" placeholder="" value=""onkeyup='isNumeric(this.id)' readonly/><span id='serviceCashCollectionSpan'></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Incidentals (Refundable if vehicle does not breakdown)</label>
                                            </td>
                                            <td>
                                                <input type="text" name="incidentalsDays" id="incidentalsDays" placeholder="Days" value="" style="width: 50px"/>
                                            </td>
                                            <td>
                                                <input type="text" name="incidentalsUnitCost" id="incidentalsUnitCost" placeholder="Unit Cost" value="" />
                                            </td>
                                            <td>
                                                <input type="text" name="incidentals" id="incidentals" placeholder="" value="">
                                            </td>
                                            <td>
                                                <label>Cash owed</label>
                                            </td>
                                            <td>
                                                <input style="" type="text" name="incidentalsCashCollection" id="incidentalsCashCollection" placeholder="" value="" onkeyup='isNumeric(this.id)'/><span id='incidentalsCashCollectionSpan'></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Airtime for MoPHS Rep</b></label>
                                            </td>
                                            <td>
                                                <input type="text" name="airTimeDays" id="airTimeDays" placeholder="Days" value=""style="width: 50px"/>
                                            </td>

                                            <td>
                                                <input type="text" name="airTimeUnitCost" id="airTimeUnitCost" placeholder="Unit Cost" value=""/>
                                            </td>
                                            <td>
                                                <input type="text" name="airTime" id="airTime" placeholder="" value=""/>
                                            </td>
                                            <td>
                                                <label>Cash owed</label>
                                            </td>
                                            <td>
                                                <input style="" type="text" name="airTimeMOCashCol" id="airTimeMOCashCol" placeholder="" value=""onkeyup='isNumeric(this.id)'/><span id='airTimeMOCashColSpan'></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                KEMSA Loaders (Origin)</label>
                                            </td>
                                            <td>
                                                <input type="text" name="kemsaLoadersOriginDays" id="kemsaLoadersOriginDays" placeholder="Days" value=""style="width: 50px"/>
                                            </td>
                                            <td>
                                                <input type="text" name="kemsaLoadersOriginUnitCost" id="kemsaLoadersOriginUnitCost" placeholder="Unit Cost" value=""/>
                                            </td>

                                            <td>
                                                <input type="text" name="kemsaLoadersOrigin" id="kemsaLoadersOrigin" placeholder="" value=""/>
                                            </td>
                                            <td>
                                                <label>Cash owed</label>
                                            </td>
                                            <td>
                                                <input style="" type="text"  id="kemsaLoadersOriginCashCollection" name="kemsaLoadersOriginCashCollection" placeholder="" value=""  onkeyup='isNumeric(this.id)'/><span id='kemsaLoadersOriginCashCollectionSpan'></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                KEMSA Loaders (Destination)</b></label>
                                            </td>
                                            <td>
                                                <input type="text" name="kemsaLoadersDestinationDays" id="kemsaLoadersDestinationDays" placeholder="Days" value=""style="width: 50px"/>
                                            </td>
                                            <td>
                                                <input type="text" name="kemsaLoadersDestinationUnitCost" id="kemsaLoadersDestinationUnitCost" placeholder="Unit Cost" value=""/>
                                            </td>
                                            <td>
                                                <input type="text" name="kemsaLoadersDestination" id="kemsaLoadersDestination" placeholder="" value=""/>
                                            </td>

                                            <td>
                                                <label>Cash owed</label>
                                            </td>
                                            <td>
                                                <input style="" type="text" id="kemsaLoadersDestinationCashCollection" name="kemsaLoadersDestinationCashCollection" placeholder="" value="" onkeyup='isNumeric(this.id)'/><span id='kemsaLoadersDestinationCashCollectionSpan'></span>
                                            </td>
                                        </tr>


                                        <tr>

                                            <td colspan='6' align='right'> <b>TOTAL IMPREST AMOUNT TO BE PAID ON DEPARTURE</b>
                                                <input type="text" align="right" name="totalAmount" id="totalAmount" placeholder="" value="" readonly/>
                                            </td>
                                        </tr>
                                        </thead>
                                    </table>
                                    <br/>

                                    <br/>
                                    <br/>
                                    <?php if ($priv_dispatch >= 2) { ?>
                                        <td colspan='3' rowspan='6' style="margin-top:10%;" >
                                            <input type="submit" name="saveRecord"   class="btn-custom" value="Save Details" />
                                        </td>
                                    <?php } ?>
                                    </tr>

                                </center>
                            </form>

                        </div>
                        <!--tab 2 - view delivery note-->

                        <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2" style="width:100%">
                            <br/><br/>
                            <!--filter box-->
                            <form action="#">
                                <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
                                <b style="margin-left:20%;width: 100px; font-size:1.5em;">View Moh calculation Table History</b>
                            </form>
                            <br/><br/>


                            <!--================================================-->
                            <!--   OTHER RECORDS           -->
                            <!--================================================-->
                            <?php
                            //Delete
                            if (isset($_GET['deleteid'])) {
                                $tabActive = 'tab2';
                                $deleteid = $_GET['deleteid'];
                                $query = "DELETE FROM drugs_dispatch_transport WHERE moh_id='$deleteid'";
                                $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
                            }
                            ?>
                            <table style="width:100%; overflow-x: visible; overflow-y: scroll; float: left"  border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                                <thead>
                                    <th align="left" width="3px">ID</th>
                                    <th align="left" width="3px">Listed Km</th>
                                    <th align="left" width="3px">Km Rate</th>
                                    <th align="left" width="10px"  >Fuel Cost</th>
                                    <th align="left" width="10px">Incidentals</th>
                                    <th align="left" width="10px">Service</th>
                                    <th align="left" width="10px">From Origin</th>
                                    <th align="left" width="10px">To Destination</th>
                                    <th align="left" width="10px">Total Amount</th>
                                    <?php if ($priv_dispatch >= 1) { ?>
                                        <th align="" width="5px">View</th>
                                    <?php }if ($priv_dispatch >= 2) { ?>
                                        <th align="" width="10px">Del</th>
                                    <?php } ?>
                                </thead>
                                <tbody>

                                    <?php
                                    $result_set = mysql_query("SELECT * FROM drugs_dispatch_transport  ORDER BY moh_id");
                                    while ($row = mysql_fetch_array($result_set)) {
                                        $moh_id = $row["moh_id"];
                                        $listed_km = $row["listed_km"];
                                        $km_rate = $row["km_rate"];
                                        $fuelNeed = $row["fuel_needed"];
                                        $totalAmount = $row["total_amount"];
                                        $todestination = $row["todestination"];
                                        $fromDestination = $row["fromDestination"];
                                        $driverPerDiem = $row["driver_per_diem"];
                                        $kemsaLoadersDestination = $row["kemsa_loaders_destination"];
                                        $kemsaLoadersOrigin = $row["kemsa_loaders_origin"];
                                        $airTime = $row["airtime_mophs"];
                                        $MOPHS = $row["mophs"];

                                        $service = $row["service"];
                                        $incidentals = $row["incidentals"];
                                        $incidentalsCashCollection = $row["incidentals_cash_collection"];
                                        $airTimeMOCashCol = $row["airtime_mophs_cash_collection"];
                                        $MOPHSCashCollection = $row["mophs_cash_collection"];
                                        $serviceCashCollection = $row["service_cash_collection"];
                                        $kemsaLoadersOriginCashCollection = $row["kemsa_loaders_nairobi_cash_collection"];
                                        $kemsaLoadersDestinationCashCollection = $row["kemsa_loaders_mombasa_cash_collection"];
                                        $driverPerDiemCashCollection = $row["driver_per_diem_cash_collection"];
                                        ?>
                                        <tr style="border-bottom: 1px solid #B4B5B0;">
                                            <td align="left" width="5px"> <?php echo $moh_id; ?>  </td>
                                            <td align="left" width="10px"> <?php echo $listed_km; ?>  </td>
                                            <td align="left" width="5px"> <?php echo $km_rate; ?>  </td>
                                            <td align="left" width="10px"> <?php echo $fuelNeed; ?>  </td>
                                            <td align="left" width="10px"> <?php echo $incidentals; ?>  </td>
                                            <td align="left" width="10px"> <?php echo $service; ?>  </td>
                                            <td align="left" width="10px"> <?php echo $fromDestination; ?>  </td>
                                            <td align="left" width="10px"> <?php echo $todestination; ?>  </td>
                                            <td align="left" width="10px"> <?php echo $totalAmount; ?>  </td>

                                            <?php if ($priv_dispatch >= 1) { ?>
                                                <td align="center" width="10px"><a href="dispatchTransport.php?viewId=<?php echo $moh_id; ?> &tabActive=3" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                                            <?php }if ($priv_dispatch >= 2) { ?>
                                                <td align="center" width="10px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $moh_id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                <?php } ?>
                            </table>

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


                        </div>
                        <div 
                            class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3" style="width:100%">

                            <?php
                            
                            if (isset($_GET["viewId"])) {

                                $viewId = $_GET["viewId"];
                                $query = "select * from drugs_dispatch_transport where moh_id='$viewId'";

                                $result = mysql_query($query) or die("<h1>Could not find</h1><br/>" . mysql_error());
                                while ($row = mysql_fetch_array($result)) {

                                    $moh_id = $row["moh_id"];
                                    $listed_km = $row["listed_km"];
                                    $km_rate = $row["km_rate"];
                                    $fuel = $row["fuel_needed"];
                                    $totalAmount = $row["total_amount"];
                                    $driverPerDiem = $row["driver_per_diem"];
                                    $kemsaLoadersDestination = $row["kemsa_loaders_destination"];

                                    $kemsaLoadersOrigin = $row["kemsa_loaders_origin"];

                                    $airTime = $row["airtime_mophs"];
                                    $incidentals = $row["incidentals"];
                                    $MOPHS = $row["mophs"];
                                    $service = $row["service"];

                                   $kemsaLoadersOriginDays = $row["kemsa_loaders_origin_days"]>0? $row["kemsa_loaders_origin_days"]:1;
                                    $kemsaLoadersDestinationDays = $row["kemsa_loaders_destination_days"]>0?$row["kemsa_loaders_destination_days"]:1;
                                  
                                   $MOPHSDays = $row["mophs_days"]>0?$row["mophs_days"]:1;
                                    $serviceDays = $row["service_days"]>0?$row["service_days"]:1;
                                    $driverPerDiemDays = $row["driver_per_diem_days"]>0?$row["driver_per_diem_days"]:1;
                                    $airTimeDays = $row["air_time_days"]>0?$row["air_time_days"]:1;
                                    $incidentalsDays = $row["incidentals_days"]>0?$row["incidentals_days"]:1;

                                    $incidentalsCashCollection = $row["incidentals_cash_collection"]>0?$row["incidentals_cash_collection"]:0;
                                    $airTimeMoCashCol = $row["airtime_mophs_cash_collection"]>0?$row["airtime_mophs_cash_collection"]:0; 
                                    $MOPHSCashCollection = $row["mophs_cash_collection"]>0?$row["mophs_cash_collection"]:0;
                                    $serviceCashCollection = $row["service_cash_collection"]>0?$row["service_cash_collection"]:0;
                                    $kemsaLoadersOriginCashCollection = $row["kemsa_loaders_origin_cash_collection"]>0?$row["kemsa_loaders_origin_cash_collection"]:0;
                                    $kemsaLoadersDestinationCashCollection = $row["kemsa_loaders_destination_cash_collection"]>0?$row["kemsa_loaders_destination_cash_collection"]:0;
                                    $todestination = $row["todestination"];
                                    $fromDestination = $row["fromDestination"];
                                    
                                    $mophsUnitCost=$MOPHSCashCollection/$MOPHSDays;
                                    $mophsUnitCostDays=$driverPerDiemCashCollection/$driverPerDiemDays;
                                    $mophsUnitCostservice=$serviceCashCollection/$serviceDays;
                                    $mophsUnitCostIncident=$incidentalsCashCollection/$incidentalsDays;
                                    $mophsUnitCostAirTime=$airTimeMOCashCol/$airTimeDays;
                                    $mophsUnitCostOriginDays=$kemsaLoadersOriginCashCollection/$kemsaLoadersOriginDays;
                                    $mophsUnitCostDestination=$kemsaLoadersDestinationCashCollection/$kemsaLoadersDestinationDays;
                                    
                                }
                                ?> 


                                <div margin-top="-5%"> 
                                    <center>
                                        <br/><br/><b><h2 size="5px">Moh calculation Table Description</h2></b>
                                    </center>
                                </div></br>
                                <form action="dispatchTransport.php" method="post">
                                    <center>
                                        <b>  From Depot </b>
                                        <select style="width:12%" name="fromDestination"   required>
                                            <option value='<?php echo $fromDestination; ?>'><?php echo $fromDestination; ?></option>
                                            <option value='Eldoret'> Eldoret</option>
                                            <option value='Kakamega'> Kakamega</option>
                                            <option value='Kisumu'> Kisumu</option>
                                            <option value='Mombasa'>Mombasa</option>
                                            <option value='Nairobi'> Nairobi</option>
                                            <option value='Nakuru'> Nakuru</option>
                                        </select>

                                        <b> To </b> 
                                        <select style="width:12%" name="toDestination"   required>
                                            <option value='<?php echo $todestination; ?>'><?php echo $todestination; ?></option>
                                            <option value='Eldoret'>Eldoret</option>
                                            <option value='Kakamega'>Kakamega</option>
                                            <option value='Kisumu'>Kisumu</option>
                                            <option value='Mombasa'>Mombasa</option>
                                            <option value='Nairobi'> Nairobi</option>
                                            <option value='Nakuru'> Nakuru</option>
                                        </select>
                                    </center>
                                    <br/>
                                    <table align="center" style="margin-left:30%;">
                                        <tr>
                                            <td>Distance</td>
                                            <td>x Kilometer Rate (KES)</td>
                                            <td> = Fuel Cost</td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" id="listed_km2" name="listed_km" placeholder=""  value="<?php echo $listed_km; ?>" style="width: 80px"/><span id="spanListedKm2" style="color:rgb(240,20,30);font-weight:bold;"></span></td>
                                            <td> x <input type="text" name="km_rate" id="km_rate2" placeholder="" value="<?php echo $km_rate; ?>"  style="width: 120px"/> <span id="spankmRate2"  style="color:rgb(240,20,30);font-weight:bold;"></span></td>
                                            <td> = <input type="text"  name="fuel" id="fuel2" value="<?php echo $fuel; ?>" onkeyup='isNumeric(this.id)' readonly/><span id='fuel2Span'></span></td>
                                        </tr>
                                    </table>
                                    <br/>






                                    <!--                                <b>Factors</b>
                                                                    <br/><b>Cost</b>
                                                                    
                                    -->

                                    <!--===-->  
                                    <center><table style="margin-left:6%;">
                                            <tr>
                                                <td><b>Factors</b></td><td><b>No Of Days</b></td><td><b>Unit Cost</b></td><td><b>Person<br/> Responsible</b></td><td><b>Cost</b></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    MoPHS Rep Per diem number of days-Job Group N</label>
                                                </td>
                                                <td>
                                                    <input type="text" name="MOPHSDays" id="MOPHSDays2" placeholder="Days" value="<?php echo $MOPHSDays; ?>" style="width: 50px"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="MOPHSUnitCost" id="MOPHSUnitCost2" placeholder="Unit Cost" value="<?php echo $mophsUnitCost; ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="MOPHS" id="MOPHS2" placeholder="" value="<?php echo $MOPHS; ?>"/>
                                                </td>
                                                <td>
                                                    <label>Cash owed</label>
                                                </td>
                                                <td>
                                                    <input style="" type="text" name="MOPHSCashCollection" id="MOPHSCashCollection2" placeholder="" value="<?php echo $MOPHSCashCollection; ?>" onkeyup='isNumeric(this.id)' /><span id='MOPHSCashCollection2Span'></span>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td><label> Driver's Per diem number of days-Job Group G</label>
                                                </td>
                                                <td>
                                                    <input type="text" name="driverPerDiemDays" id="driverPerDiemDays2" placeholder="Days" value="<?php echo $driverPerDiemDays; ?>" style="width: 50px"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="driverPerDiemUnitCost" id="driverPerDiemUnitCost2" placeholder="Unit cost" value="<?php echo $mophsUnitCostDays; ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="driverPerDiem" id="driverPerDiem2" placeholder="" value="<?php echo $driverPerDiem; ?>"/>
                                                </td>

                                                <td>
                                                    <label>Cash owed </label>
                                                </td>
                                                <td>
                                                    <input style=""type="text"  id="driverPerDiemCashCollection2" name="driverPerDiemCashCollection" placeholder="" value="<?php echo $driverPerDiemCashCollection; ?>" onkeyup='isNumeric(this.id)' /><span id='driverPerDiemCashCollection2Span'></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Service/Maintenance Amount</label>
                                                </td>
                                                <td>
                                                    <input type="text" name="serviceDays" id="serviceDays2" placeholder="Days" value="<?php echo $serviceDays; ?>" style="width: 50px"/>
                                                </td>

                                                <td>
                                                    <input type="text" name="serviceUnitCost" id="serviceUnitCost2" placeholder="Unit Cost" value="<?php echo $mophsUnitCostservice; ?>"/>
                                                </td>
                                                <td>

                                                    <input type="text" name="service" id="service2" placeholder="" value="<?php echo $service; ?>"/>
                                                </td>
                                                <td>
                                                    <label>Cash owed </label>
                                                </td><td>
                                                    <input style="" type="text" name="serviceCashCollection" id="serviceCashCollection2" placeholder="" value="<?php echo $serviceCashCollection; ?>" onkeyup='isNumeric(this.id)' /><span id='serviceCashCollection2Span'></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>    Incidentals (Refundable if vehicle does not breakdown)</label>
                                                </td>
                                                <td>
                                                    <input type="text" name="incidentalsDays" id="incidentalsDays2" placeholder="Days" value="<?php echo $incidentalsDays; ?>" style="width: 50px"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="incidentalsUnitCost" id="incidentalsUnitCost2" placeholder="Unit Cost" value="<?php echo $mophsUnitCostIncident; ?>" />
                                                </td>
                                                <td>
                                                    <input type="text" name="incidentals" id="incidentals2" placeholder="" value="<?php echo $incidentals; ?>" />
                                                </td>
                                                <td>
                                                    <label>Cash owed</label>
                                                </td>
                                                <td>
                                                    <input style="" type="text" name="incidentalsCashCollection" id="incidentalsCashCollection2" placeholder="" value="<?php echo $incidentalsCashCollection; ?>" onkeyup='isNumeric(this.id)'/><span id='incidentalsCashCollectionSpan'></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>  Airtime for MoPHS Rep</b></label>
                                                </td>
                                                <td>
                                                    <input type="text" name="airTimeDays" id="airTimeDays2" placeholder="Days" value="<?php echo $airTimeDays; ?>"style="width: 50px"/>
                                                </td>

                                                <td>
                                                    <input type="text" name="airTimeUnitCost" id="airTimeUnitCost2" placeholder="Unit Cost" value="<?php echo $mophsUnitCostAirTime; ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="airTime" id="airTime2" placeholder="" value="<?php echo $airTime; ?>"/>
                                                </td>
                                                <td>
                                                    <label>Cash owed</label>
                                                </td>
                                                <td>
                                                    <input style="" type="text" name="airTimeMOCashCol" id="airTimeMOCashCol2" placeholder="" value="<?php echo $airTimeMOCashCol; ?>" onkeyup='isNumeric(this.id)'/><span id='airTimeMOCashColSpan'></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label> KEMSA Loaders (Origin)</label>
                                                </td>
                                                <td>
                                                    <input type="text" name="kemsaLoadersOriginDays" id="kemsaLoadersOriginDays2" placeholder="Days" value="<?php echo $kemsaLoadersOriginDays; ?>"style="width: 50px"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="kemsaLoadersOriginUnitCost" id="kemsaLoadersOriginUnitCost2" placeholder="Unit Cost" value="<?php echo $mophsUnitCostOriginDays; ?>"/>
                                                </td>

                                                <td>
                                                    <input type="text" name="kemsaLoadersOrigin" id="kemsaLoadersOrigin2" placeholder="" value="<?php echo $kemsaLoadersOrigin; ?>"/>
                                                </td>
                                                <td>
                                                    <label>Cash owed</label>
                                                </td>
                                                <td>
                                                    <input style="" type="text"  id="kemsaLoadersOriginCashCollection2" name="kemsaLoadersOriginCashCollection" placeholder="" value="<?php echo $kemsaLoadersOriginCashCollection; ?>"  onkeyup='isNumeric(this.id)'/><span id='kemsaLoadersOriginCashCollectionSpan'></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    KEMSA Loaders (Destination)</b></label>
                                                </td>
                                                <td>
                                                    <input type="text" name="kemsaLoadersDestinationDays" id="kemsaLoadersDestinationDays2" placeholder="Days" value="<?php echo $kemsaLoadersDestinationDays; ?>"style="width: 50px"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="kemsaLoadersDestinationUnitCost" id="kemsaLoadersDestinationUnitCost2" placeholder="Unit Cost" value="<?php echo $mophsUnitCostDestination; ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="kemsaLoadersDestination" id="kemsaLoadersDestination2" placeholder="" value="<?php echo $kemsaLoadersDestination; ?>"/>
                                                </td>

                                                <td>
                                                    <label>Cash owed</label>
                                                </td>
                                                <td>
                                                    <input style="" type="text" id="kemsaLoadersDestinationCashCollection2" name="kemsaLoadersDestinationCashCollection" placeholder="" value="<?php echo $kemsaLoadersDestinationCashCollection; ?>" onkeyup='isNumeric(this.id)'/><span id='kemsaLoadersDestinationCashCollectionSpan'></span>
                                                </td>
                                            </tr>


                                            <tr>

                                                <td colspan='6' align='right'> <b>TOTAL IMPREST AMOUNT TO BE PAID ON DEPARTURE</b>
                                                    <input type="text" align="right" name="totalAmount" id="totalAmount2" placeholder="" value="<?php echo $totalAmount; ?>" readonly/>
                                                </td>
                                            </tr>
                                            </thead>
                                        </table>
                                        <br/>

                                        <br/>
                                        <br/>
                                        <?php if ($priv_dispatch >= 2) { ?>
                                            <td colspan='3' rowspan='6' style="margin-top:10%;" >
                                                <input type="submit" name="updateRecord" class="btn-custom" value="Update Details" />
                                                <input type="submit" name="exportExcel" class="btn-custom" value="Export Excel" />
                                                <input type="hidden" name="moh_id"  value="<?php echo $moh_id; ?>" />
                                            </td>
                                        <?php } ?>
                                        </tr>

                                    </center>
                                </form>







                                <?php
                            }
                            ?>
                        </div>   



                    </div>
                </div>


            </div>
        </div>

    </body>
</html>

<script>

    function prepareEventHandler() {
        var listed_km = document.getElementById("listed_km");
        var km_rate = document.getElementById("km_rate");
        var fuel = document.getElementById("fuel");
        var totalAmount = document.getElementById("totalAmount");
        var driverPerDiem = document.getElementById("driverPerDiem");
        var kemsaLoadersDestination = document.getElementById("kemsaLoadersDestination");
        var kemsaLoadersOrigin = document.getElementById("kemsaLoadersOrigin");
        var airTime = document.getElementById("airTime");
        var MOPHS = document.getElementById("MOPHS");
        var service = document.getElementById("service");
        var incidentals = document.getElementById("incidentals");
        var airTimeMOPHS = document.getElementById("airTimeMOPHS");

        // No of Days

        var driverPerDiemDays = document.getElementById("driverPerDiemDays");
        var kemsaLoadersDestinationDays = document.getElementById("kemsaLoadersDestinationDays");
        var kemsaLoadersOriginDays = document.getElementById("kemsaLoadersOriginDays");
        var airTimeDays = document.getElementById("airTimeDays");
        var MOPHSDays = document.getElementById("MOPHSDays");
        var serviceDays = document.getElementById("serviceDays");
        var incidentalsDays = document.getElementById("incidentalsDays");
        var airTimeMOPHSDays = document.getElementById("airTimeMOPHSDays");



        //cASH cOLLECTIONS
        var incidentalsCashCollection = document.getElementById("incidentalsCashCollection");
        var airTimeMOCashCol = document.getElementById("airTimeMOCashCol");
        var MOPHSCashCollection = document.getElementById("MOPHSCashCollection");
        var serviceCashCollection = document.getElementById("serviceCashCollection");
        var kemsaLoadersOriginCashCollection = document.getElementById("kemsaLoadersOriginCashCollection");
        var kemsaLoadersDestinationCashCollection = document.getElementById("kemsaLoadersDestinationCashCollection");
        var driverPerDiemCashCollection = document.getElementById("driverPerDiemCashCollection");

        var openModalTabReturn = document.getElementById("openModalTabReturn");



        listed_km.onkeyup = function() {
            console.log(listed_km.value);
            document.getElementById("spanListedKm").innerHTML = "";
            if (isNaN(listed_km.value)) {
                var sperror = document.createTextNode("Enter Numerical Value");
                document.getElementById("spanListedKm").appendChild(sperror);
                listed_km.value = "";
            } else {
                calculateFuel();
            }
        };
        km_rate.onkeyup = function() {
            console.log(km_rate.value);
            document.getElementById("spankmRate").innerHTML = "";
            if (isNaN(km_rate.value)) {
                var sperror = document.createTextNode("Enter Numerical Value");
                document.getElementById("spankmRate").appendChild(sperror);
                km_rate.value = "";
            } else {
                calculateFuel();
            }
        }
        function calculateFuel() {

            if (!isNaN(listed_km.value) && !isNaN(km_rate.value)) {
                fuel.value = km_rate.value * listed_km.value;

            }
        }
        window.addEventListener('keyup', function calculateTotalAmount() {
            //  if (!isNaN(driverPerDiemCashCollection.value) && !isNaN(kemsaLoadersDestinationCashCollection.value) && !isNaN(kemsaLoadersOriginCashCollection.value) && !isNaN(serviceCashCollection.value) && !isNaN(MOPHSCashCollection.value) && !isNaN(airTimeMOCashCol.value) && !isNaN(incidentalsCashCollection.value)) {
            totalAmount.value = (serviceCashCollection.value * 1) + (driverPerDiemCashCollection.value * 1) + (kemsaLoadersDestinationCashCollection.value * 1) + (kemsaLoadersOriginCashCollection.value * 1) + (MOPHSCashCollection.value * 1) + (airTimeMOCashCol.value * 1) + (incidentalsCashCollection.value * 1) + (fuel.value * 1);

            if (!isNaN(totalAmount.value)) {

                console.log("Math Ok...");
            } else {
                console.log("Enter Numerical data");
            }


        }, false);


        // Unit Costs

        var driverPerDiemUnitCost = document.getElementById("driverPerDiemUnitCost");
        var kemsaLoadersDestinationUnitCost = document.getElementById("kemsaLoadersDestinationUnitCost");
        var kemsaLoadersOriginUnitCost = document.getElementById("kemsaLoadersOriginUnitCost");
        var airTimeUnitCost = document.getElementById("airTimeUnitCost");
        var MOPHSUnitCost = document.getElementById("MOPHSUnitCost");
        var serviceUnitCost = document.getElementById("serviceUnitCost");
        var incidentalsUnitCost = document.getElementById("incidentalsUnitCost");
        var airTimeMOPHSUnitCost = document.getElementById("airTimeMOPHSUnitCost");

        driverPerDiem.onkeyup = function() {
            cashCollection(driverPerDiemUnitCost, driverPerDiemDays, driverPerDiemCashCollection);
            console.log("Passed Through");
        }

        function cashCollection(mainunitCost, Days, mainCollection) {

            mainCollection.value = (mainunitCost.value * 1) * (Days.value * 1);
            console.log("Cash Collected");
        }



        window.addEventListener('input', function calculateCash() {
            cashCollection(driverPerDiemUnitCost, driverPerDiemDays, driverPerDiemCashCollection);
            cashCollection(kemsaLoadersDestinationUnitCost, kemsaLoadersDestinationDays, kemsaLoadersDestinationCashCollection);
            cashCollection(kemsaLoadersOriginUnitCost, kemsaLoadersOriginDays, kemsaLoadersOriginCashCollection);
            cashCollection(airTimeUnitCost, airTimeDays, airTimeMOCashCol);
            cashCollection(serviceUnitCost, serviceDays, serviceCashCollection);
            cashCollection(incidentalsUnitCost, incidentalsDays, incidentalsCashCollection);
            //  cashCollection(airTimeMOPHSUnitCost,airTimeMOPHSDays,airTimeMOPHSCashCollection);
            cashCollection(MOPHSUnitCost, MOPHSDays, MOPHSCashCollection);

        }, false);

    }


    function prepareEventHandler3() {
        var listed_km2 = document.getElementById("listed_km2");
        var km_rate2 = document.getElementById("km_rate2");
        var fuel2 = document.getElementById("fuel2");
        var totalAmount2 = document.getElementById("totalAmount2");
        var driverPerDiem2 = document.getElementById("driverPerDiem2");
        var kemsaLoadersDestination2 = document.getElementById("kemsaLoadersDestination2");
        var kemsaLoadersOrigin2 = document.getElementById("kemsaLoadersOrigin2");
        var airTime2 = document.getElementById("airTime2");
        var MOPHS2 = document.getElementById("MOPHS2");
        var service2 = document.getElementById("service2");
        var incidentals2 = document.getElementById("incidentals2");
        var airTimeMOPHS2 = document.getElementById("airTimeMOPHS2");

        // No of Days

        var driverPerDiemDays2 = document.getElementById("driverPerDiemDays2");
        var kemsaLoadersDestinationDays2 = document.getElementById("kemsaLoadersDestinationDays2");
        var kemsaLoadersOriginDays2 = document.getElementById("kemsaLoadersOriginDays2");
        var airTimeDays2 = document.getElementById("airTimeDays2");
        var MOPHSDays2 = document.getElementById("MOPHSDays2");
        var serviceDays2 = document.getElementById("serviceDays2");
        var incidentalsDays2 = document.getElementById("incidentalsDays2");
        var airTimeMOPHSDays2 = document.getElementById("airTimeMOPHSDays2");



        //cASH cOLLECTIONS
        var incidentalsCashCollection2 = document.getElementById("incidentalsCashCollection2");
        var airTimeMOCashCol2 = document.getElementById("airTimeMOCashCol2");
        var MOPHSCashCollection2 = document.getElementById("MOPHSCashCollection2");
        var serviceCashCollection2 = document.getElementById("serviceCashCollection2");
        var kemsaLoadersOriginCashCollection2 = document.getElementById("kemsaLoadersOriginCashCollection2");
        var kemsaLoadersDestinationCashCollection2 = document.getElementById("kemsaLoadersDestinationCashCollection2");
        var driverPerDiemCashCollection2 = document.getElementById("driverPerDiemCashCollection2");

        var openModalTabReturn = document.getElementById("openModalTabReturn");



        listed_km2.onkeyup = function() {
            console.log(listed_km2.value);
            document.getElementById("spanListedKm2").innerHTML = "";
            if (isNaN(listed_km2.value)) {
                var sperror = document.createTextNode("Enter Numerical Value");
                document.getElementById("spanListedKm2").appendChild(sperror);
                listed_km2.value = "";
            } else {
                calculateFuel2();
            }
        };
        km_rate2.onkeyup = function() {
            console.log(km_rate2.value);
            document.getElementById("spankmRate2").innerHTML = "";
            if (isNaN(km_rate2.value)) {
                var sperror = document.createTextNode("Enter Numerical Value");
                document.getElementById("spankmRate2").appendChild(sperror);
                km_rate2.value = "";
            } else {
                calculateFuel2();
            }
        }
        function calculateFuel2() {

            if (!isNaN(listed_km2.value) && !isNaN(km_rate2.value)) {
                fuel2.value = km_rate2.value * listed_km2.value;

            }
        }
        window.addEventListener('keyup', function calculateTotalAmount2() {
            //  if (!isNaN(driverPerDiemCashCollection.value) && !isNaN(kemsaLoadersDestinationCashCollection.value) && !isNaN(kemsaLoadersOriginCashCollection.value) && !isNaN(serviceCashCollection.value) && !isNaN(MOPHSCashCollection.value) && !isNaN(airTimeMOCashCol.value) && !isNaN(incidentalsCashCollection.value)) {
            totalAmount2.value = (serviceCashCollection2.value * 1) + (driverPerDiemCashCollection2.value * 1) + (kemsaLoadersDestinationCashCollection2.value * 1) + (kemsaLoadersOriginCashCollection2.value * 1) + (MOPHSCashCollection2.value * 1) + (airTimeMOCashCol2.value * 1) + (incidentalsCashCollection2.value * 1) + (fuel2.value * 1);

            if (!isNaN(totalAmount2.value)) {

                console.log("Math Ok...");
            } else {
                console.log("Enter Numerical data");
            }


        }, false);


        // Unit Costs

        var driverPerDiemUnitCost2 = document.getElementById("driverPerDiemUnitCost2");
        var kemsaLoadersDestinationUnitCost2 = document.getElementById("kemsaLoadersDestinationUnitCost2");
        var kemsaLoadersOriginUnitCost2 = document.getElementById("kemsaLoadersOriginUnitCost2");
        var airTimeUnitCost2 = document.getElementById("airTimeUnitCost2");
        var MOPHSUnitCost2 = document.getElementById("MOPHSUnitCost2");
        var serviceUnitCost2 = document.getElementById("serviceUnitCost2");
        var incidentalsUnitCost2 = document.getElementById("incidentalsUnitCost2");
        var airTimeMOPHSUnitCost2 = document.getElementById("airTimeMOPHSUnitCost2");

        driverPerDiem2.onkeyup = function() {
            cashCollection(driverPerDiemUnitCost2, driverPerDiemDays2, driverPerDiemCashCollection2);
            console.log("Passed Through");
        }

        function cashCollection2(mainunitCost2, Days2, mainCollection2) {

            mainCollection2.value = (mainunitCost2.value * 1) * (Days2.value * 1);
            console.log("Cash Collected");
        }



        window.addEventListener('input', function calculateCash2() {
            cashCollection2(driverPerDiemUnitCost2, driverPerDiemDays2, driverPerDiemCashCollection2);
            cashCollection2(kemsaLoadersDestinationUnitCost2, kemsaLoadersDestinationDays2, kemsaLoadersDestinationCashCollection2);
            cashCollection2(kemsaLoadersOriginUnitCost2, kemsaLoadersOriginDays2, kemsaLoadersOriginCashCollection2);
            cashCollection2(airTimeUnitCost2, airTimeDays2, airTimeMOCashCol2);
            cashCollection2(serviceUnitCost2, serviceDays2, serviceCashCollection2);
            cashCollection2(incidentalsUnitCost2, incidentalsDays2, incidentalsCashCollection2);
            //  cashCollection(airTimeMOPHSUnitCost,airTimeMOPHSDays,airTimeMOPHSCashCollection);
            cashCollection2(MOPHSUnitCost2, MOPHSDays2, MOPHSCashCollection2);

        }, false);

    }



    window.onload = function() {
        prepareEventHandler();
        prepareEventHandler3();
    };



</script>

<!--filter includes-->
<script type="text/javascript" src="../css/filter-as-you-type/jquery.min.js"></script>
<script type="text/javascript" src="../css/filter-as-you-type/jquery.quicksearch.js"></script>
<script type="text/javascript">
    $(function() {
        $('input#id_search').quicksearch('table tbody tr');
    });
</script> 

<script src="../js/keydown_event"></script>

