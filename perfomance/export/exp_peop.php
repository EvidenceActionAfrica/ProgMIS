<?php

/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2013 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2013 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.9, 2013-06-02
 */
$data = "N/A";
include "../includes/config.php";

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../dtw/PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Rambo")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");

// Add some data
//$year = $_POST['rec_year'];
//$country_val_ = $_POST['rec_country'];
//$country_name_ = $_POST['rec_country_name'];
//if ($year == 'All years') {
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'People Served')
        ->setCellValue('C2', 'Num of Dispensers (Actual)')
        ->setCellValue('D2', 'Num of Households per Dispenser')
        ->setCellValue('E2', 'Num of People per household')
        ->setCellValue('F2', 'People Served per Dispenser')
        ->setCellValue('G2', 'Total Number of People Served');
PHP_EOL;
$i = 3;
foreach ($_POST['rec_country'] as $index => $country_val_) {
    $country_name = $_POST['rec_country_name'][$index];
    $query_tot_ken = "SELECT hh_per_wpt FROM dispenser_database WHERE hh_per_wpt !='' AND country=$country_val_";
    $result_tot_ken = mysql_query($query_tot_ken) or die(mysql_error());
    $deno_tot_ken = mysql_num_rows($result_tot_ken);
    $deno_tot_ken_e = number_format($deno_tot_ken);
    $query1_tot_ken = "SELECT SUM(hh_per_wpt) AS num FROM dispenser_database WHERE country=$country_val_";
    $result1_tot_ken = mysql_query($query1_tot_ken) or die(mysql_error());
    $row_num_tot_ken = mysql_fetch_assoc($result1_tot_ken);
    $nume_tot_ken = $row_num_tot_ken['num'];
    if ($deno_tot_ken == 0) {
        $ans_tot_ken_e = "";
    } else {
        $ans_tot_ken = round(($nume_tot_ken / $deno_tot_ken), 0);
        $ans_tot_ken_e = $ans_tot_ken;
    }
    $query2_tot_ken = "SELECT pple_per_hh FROM dispenser_database WHERE pple_per_hh !='' AND country=$country_val_";
    $result2_tot_ken = mysql_query($query2_tot_ken) or die(mysql_error());
    $deno2_tot_ken = mysql_num_rows($result2_tot_ken);
    $query12_tot_ken = "SELECT SUM(pple_per_hh) AS num FROM dispenser_database WHERE country=$country_val_";
    $result12_tot_ken = mysql_query($query12_tot_ken) or die(mysql_error());
    $row_num2_tot_ken = mysql_fetch_assoc($result12_tot_ken);
    $nume2_tot_ken = $row_num2_tot_ken['num'];
    if ($deno2_tot_ken == 0) {
        $ans_tot_ken_e2 = "";
    } else {
        $ans_tot_ken2 = round(($nume2_tot_ken / $deno2_tot_ken), 0);
        $ans_tot_ken_e2 = $ans_tot_ken2;
    }
    if ($deno_tot_ken == 0) {
        $people_serv = "0";
    } else if ($deno2_tot_ken == 0) {
        $people_serv = "0";
    } else {
        $people_serv = number_format(round(($nume_tot_ken / $deno_tot_ken) * ($nume2_tot_ken / $deno2_tot_ken)));
    }
    if ($deno_tot_ken == 0) {
        $total_serv = "0";
    } else if ($deno2_tot_ken == 0) {
        $total_serv = "0";
    } else {
        $total_serv = number_format(round(($nume_tot_ken / $deno_tot_ken) * ($nume2_tot_ken / $deno2_tot_ken) * $deno_tot_ken));
    }
    
    
     $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, $country_name)
            ->setCellValue('C' . $i, $deno_tot_ken_e)
            ->setCellValue('D' . $i, $ans_tot_ken_e)
            ->setCellValue('E' . $i, $ans_tot_ken_e2)
            ->setCellValue('F' . $i, $people_serv)
            ->setCellValue('G' . $i, $total_serv);
    PHP_EOL;   
$j=$i + 1;
$field = 'program_name';
$res1_ken = mysql_query("SELECT DISTINCT $field FROM `dispenser_database`  WHERE country=$country_val_ ORDER BY program_name ");
while ($row = mysql_fetch_array($res1_ken)) {
    $prog = $row["program_name"];
    $query_ken = "SELECT hh_per_wpt FROM dispenser_database WHERE program_name = '$prog' AND hh_per_wpt !=''";
    $result_ken = mysql_query($query_ken) or die(mysql_error());
    $deno_ken = mysql_num_rows($result_ken);
    $deno_ken_disp = number_format($deno_ken);
    $query1_ken = "SELECT SUM(hh_per_wpt) AS num FROM dispenser_database WHERE program_name = '$prog'";
    $result1_ken = mysql_query($query1_ken) or die(mysql_error());
    $row_num_ken = mysql_fetch_assoc($result1_ken);
    $nume_ken = $row_num_ken['num'];
    if ($deno_ken == 0) {
        $ans_ken = "";
    } else {
        $ans_ken = round(($nume_ken / $deno_ken), 0);        
    }
    
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B' . $j, $prog)
            ->setCellValue('C' . $j, $deno_ken_disp)
            ->setCellValue('D' . $j, $ans_ken);
    PHP_EOL;
  $j++;  
}
$k=$i + 1;
$res2_ken = mysql_query("SELECT DISTINCT $field FROM `dispenser_database`  WHERE country=$country_val_ ORDER BY program_name ");
while ($row = mysql_fetch_array($res2_ken)) {
    $prog = $row["program_name"];
    $query_ken = "SELECT pple_per_hh FROM dispenser_database WHERE program_name = '$prog' AND pple_per_hh !=''";
    $result_ken = mysql_query($query_ken) or die(mysql_error());
    $deno2_ken = mysql_num_rows($result_ken);
    $query1_ken = "SELECT SUM(pple_per_hh) AS num FROM dispenser_database WHERE program_name = '$prog'";
    $result1_ken = mysql_query($query1_ken) or die(mysql_error());
    $row_num_ken = mysql_fetch_assoc($result1_ken);
    $nume2_ken = $row_num_ken['num'];
    if ($deno2_ken == 0) {
        $ans_ken = "";
    } else {
        $ans_ken = round(($nume2_ken / $deno2_ken), 0);
    }
    if ($deno_ken == 0) {
        $people_served = "0";
    } else if ($deno2_ken == 0) {
        $people_served = "0";
    } else {
        $people_served = number_format(round(($nume_ken / $deno_ken) * ($nume2_ken / $deno2_ken)));
    }
    $objPHPExcel->setActiveSheetIndex(0)
            //->setCellValue('E' . $k, $prog)
            ->setCellValue('E' . $k, $ans_ken)
            ->setCellValue('F' . $k, $people_served);
    PHP_EOL; 
    $k++;
}
if($j > $k){
$i=$j;
}else{
 $i=$k;   
}
    $i++;
}
// Rename worksheet
$today = date("F j-Y");
$objPHPExcel->getActiveSheet()->setTitle('People Served');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="People Served.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
