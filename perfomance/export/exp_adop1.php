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
$i = 3;
$field = 'c803_tcr_reading';
$res = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates` ORDER BY program");
while ($row = mysql_fetch_array($res)) {
    $prog = $row["program"];
    $s = 'b';
    for ($value = 1; $value < 13; ++$value) {

        $query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '0' AND $field != ''";
        $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
        $nume = mysql_num_rows($result);

        $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != ''";
        $result1 = mysql_query($query1) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
        $deno = mysql_num_rows($result1);
        if ($deno == null) {
            $data = "";
        } else {
            $ans = round(($nume / $deno), 2);
            $percent = $ans * 100;
            $data = $percent . "%";
        }





        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'TCR Adoption (Total Chlorine Adoption')
                ->setCellValue('A2', '')
                ->setCellValue('B2', 'Jan')
                ->setCellValue('C2', 'Feb')
                ->setCellValue('D2', 'Mar')
                ->setCellValue('E2', 'Apr')
                ->setCellValue('F2', 'May')
                ->setCellValue('G2', 'Jun')
                ->setCellValue('H2', 'Jul')
                ->setCellValue('I2', 'Aug')
                ->setCellValue('J2', 'Sep')
                ->setCellValue('K2', 'Oct')
                ->setCellValue('L2', 'Nov')
                ->setCellValue('M2', 'Dec')
                ->setCellValue('A' . $i, $prog)
                ->setCellValue($s . $i, $data);

        ++$s . PHP_EOL;
    }
    $i++;
}

$j = 2 + $i++;
$k = 1 + $j;
$dj = $j - 1;

$field2 = 'c806_fcr_reading';
$res2 = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates`ORDER BY program");
while ($row = mysql_fetch_array($res2)) {
    $prog = $row["program"];
    $s = 'b';
    for ($value = 1; $value < 13; ++$value) {

        $query = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field2 != '0' AND $field2 != ''";
        $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
        $nume = mysql_num_rows($result);

        $query1 = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field2 != ''";
        $result1 = mysql_query($query1) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
        $deno = mysql_num_rows($result1);
        if ($deno == null) {
            $data = "";
        } else {
            $ans = round(($nume / $deno), 2);
            $percent = $ans * 100;
            $data = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $dj, 'FCR Adoption (Free Chlorine Adoption)')
                ->setCellValue('A' . $j, '')
                ->setCellValue('B' . $j, 'Jan')
                ->setCellValue('C' . $j, 'Feb')
                ->setCellValue('D' . $j, 'Mar')
                ->setCellValue('E' . $j, 'Apr')
                ->setCellValue('F' . $j, 'May')
                ->setCellValue('G' . $j, 'Jun')
                ->setCellValue('H' . $j, 'Jul')
                ->setCellValue('I' . $j, 'Aug')
                ->setCellValue('J' . $j, 'Sep')
                ->setCellValue('K' . $j, 'Oct')
                ->setCellValue('L' . $j, 'Nov')
                ->setCellValue('M' . $j, 'Dec')
                ->setCellValue('A' . $k, $prog)
                ->setCellValue($s . $k, $data);

        ++$s . PHP_EOL;
    }
    $k++;
}


// Rename worksheet
$today = date("F j-Y");
$objPHPExcel->getActiveSheet()->setTitle(' Adopton Rates');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=" Adopton Rates.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
