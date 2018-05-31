<?php
 $county=$_GET['county'];
 $district=$_GET['district_name'];
 $dmoh_name=$_GET['dmoh_name'];
 $dmoh_mobile=$_GET['dmoh_phone'];
 $dmoh_email=$_GET['dmoh_email'];

// connection with the database
require_once ('../../includes/auth.php');
require_once('../../includes/config.php');

// require the PHPExcel file
require '../Classes/PHPExcel.php';

$query = "SELECT * FROM health_contacts WHERE county LIKE '%$county%' AND district LIKE '%$district%' AND dmoh_name LIKE '%$dmoh_name%' AND dmoh_phone LIKE '%$dmoh_mobile%' AND dmoh_email LIKE '%$dmoh_email%'";
$headings = array('No.', 
    'County', 
    'District', 
    'DMoH Name',
    'DMoH Phone1', 
    'DMoH Phone2', 
    'DMoH Email',
    'DMoH Email2',
    'DMoH Email3',
    'Additional Contact Name',
    'Additional Contact Phone',
    'Additional Contact Email',
    'DMoH Bank Account',
    'DMoH Acct No',
    'DMoH Bank Name',
    'DMoH BankBranch',
    'DMoH update date',
    'DMoH Physical address',
    'DPHO Name',
    'DPHO Phone',
    'DPHO Email',
    'Do You Own a District GoK Vehicle (Yes/No)',
    'Vehicle make or type', 
    'District HQ',
    'Distance from district to HQ',
    'Which is closer ; g4s or Post office');

if ($result = mysql_query($query) or die(mysql_error())) {
  // Create a new PHPExcel object
  $objPHPExcel = new PHPExcel();
  $objPHPExcel->getActiveSheet()->setTitle('Health_contacts Excel');

  $rowNumber = 1;
  $col = 'A';
  foreach ($headings as $heading) {
    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $heading);
    $col++;
  }

  // Loop through the result set
  $rowNumber = 2;
  while ($row = mysql_fetch_row($result)) {
    $col = 'A';
    foreach ($row as $cell) {
      $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $cell);
      $col++;
    }
    $rowNumber++;
  }

  // Freeze pane so that the heading line will not scroll
  $objPHPExcel->getActiveSheet()->freezePane('A2');

  // Save as an Excel BIFF (xls) file
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="Health_contacts.xls"');
  header('Cache-Control: max-age=0');

  $objWriter->save('php://output');
  exit();
}
echo 'a problem has occurred... no data retrieved from the database';
?>