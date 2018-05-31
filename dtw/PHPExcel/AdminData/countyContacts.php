<?php

$county = $_GET['county'];
$title = $_GET['title'];
$full_name = $_GET['full_name'];
$phoneSearch = $_GET['phoneSearch'];
$emailSearch = $_GET['emailSearch'];

// connection with the database
require_once ('../../includes/auth.php');
require_once('../../includes/config.php');

// require the PHPExcel file
require '../Classes/PHPExcel.php';

$query = "SELECT * FROM county_contacts WHERE county LIKE '%$county%' AND title LIKE '%$title%' AND full_name LIKE '%$full_name%' AND phone LIKE '%$phoneSearch%' AND email LIKE '%$emailSearch%' ";
$headings = array(
    'No.',
    'County',
    'Full Name',
    'Title',
    'Phone Number 1',
    'Phone Number 2',
    'Email 1',
    'Email 2',
    'Bank Account Name',
    'Bank Acct No',
    'Bank Name',
    'Bank Branch' );
if ($result = mysql_query($query) or die(mysql_error())) {
  // Create a new PHPExcel object
  $objPHPExcel = new PHPExcel();
  $objPHPExcel->getActiveSheet()->setTitle('Master_trainers Excel');

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
  header('Content-Disposition: attachment;filename="County Contacts.xls"');
  header('Cache-Control: max-age=0');

  $objWriter->save('php://output');
  exit();
}
echo 'a problem has occurred... no data retrieved from the database';
?>