<?php
$full_name = $_GET['full_name'];
$ministry = $_GET['ministry'];
$posting_station = $_GET['posting_station'];
$job_class = $_GET['job_class'];
$county = $_GET['county'];
$national = $_GET['national'];
$status = $_GET['status'];
$phone_number = $_GET['phone_number'];

// connection with the database
require_once ('../../includes/auth.php');
require_once('../../includes/config.php');

// require the PHPExcel file
require '../Classes/PHPExcel.php';

$query = "SELECT * FROM master_trainers WHERE full_name LIKE '%$full_name%' AND ministry LIKE '%$ministry%' AND posting_station LIKE '%$posting_station%' AND job_class LIKE '%$job_class%' AND county LIKE '%$county%' AND national LIKE '%$national%' AND status LIKE '%$status%' AND phone_number LIKE '%$phone_number%'";

$headings = array(
    'No.',
    'MT ID',
    'Full Name',
    'Ministry',
    'Title',
    'Job class',
    'Posting Station',
    'Province',
    'County',
    'Level',
    'Phone Number',
    'Phone Number2',
    'Recruitment Year',
    'Status',
    'Email',
    'Email 2');

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
  header('Content-Disposition: attachment;filename="Master_trainers.xls"');
  header('Cache-Control: max-age=0');

  $objWriter->save('php://output');
  exit();
}
echo 'a problem has occurred... no data retrieved from the database';
?>