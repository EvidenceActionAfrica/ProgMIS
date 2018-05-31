<?php
$county=$_GET['county'];
$district=$_GET['district_name'];
$deo_name=$_GET['deo_name'];
$deo_mobile=$_GET['deo_phone'];
$deo_email=$_GET['deo_email'];

// connection with the database
require_once ('../../includes/auth.php');
require_once('../../includes/config.php');

// require the PHPExcel file
require '../Classes/PHPExcel.php';

$query = "SELECT * FROM education_contacts WHERE county LIKE '%$county%' AND district LIKE '%$district%' AND deo_name LIKE '%$deo_name%' AND deo_phone LIKE '%$deo_mobile%' AND deo_email LIKE '%$deo_email%'";
$headings = array('No.',
    'County',
    'District',
    'SCMOE Name',
    'SCMOE Phone1',
    'SCMOE Phone2',
    'SCMOE Email 1',
    'SCMOE Email 2',
    'SCMOE Bank Account',
    'SCMOE Bank AcctNo',
    'SCMOE Bank Name',
    'SCMOE BankBranch');

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
  header('Content-Disposition: attachment;filename="Education Contacts.xls"');
  header('Cache-Control: max-age=0');

  $objWriter->save('php://output');
  exit();
}
echo 'a problem has occurred... no data retrieved from the database';
?>