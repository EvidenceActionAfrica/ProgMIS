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
// connection with the database
require_once ('../../includes/auth.php');
require_once('../../includes/config.php');

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../Classes/PHPExcel.php';

// number of divisions in district
function numberOfDivisions($district_name) {
    $query = "SELECT * FROM divisions WHERE district_name='$district_name'";
    $result = mysql_query($query) or die("<h1>Cant get divisions</h1>" . mysql_error());
    $num = mysql_num_rows($result);
    return $num;
}

// number of schools in district
function numberOfSchools($district_name) {
    $query = "SELECT * FROM schools WHERE district_name='$district_name'";
    $result = mysql_query($query) or die("<h1>Cant get divisions</h1>" . mysql_error());
    $num = mysql_num_rows($result);
    return $num;
}

//count all the row of the table
function row_total() {
    $query_row = "SELECT * FROM districts";
    $result_row = mysql_query($query_row) or die(mysql_error());
    $num_row = mysql_num_rows($result_row);
    return $num_row;
}

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


// Add some data

$result_set = mysql_query("SELECT * FROM districts ORDER BY county,district_name ASC");
$i = 0;
while ($row = mysql_fetch_array($result_set)) {
    $county = $row['county'];
    $district_name = $row['district_name'];
    $district_id = $row['district_id'];
    $donor = $row['donor'];
    $treatment_type = $row['treatment_type'];
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'County')
            ->setCellValue('B1', 'Sub County')
            ->setCellValue('C1', 'Sub County ID')
            ->setCellValue('D1', 'Donor')
            ->setCellValue('E1', 'T.Type')
            ->setCellValue('F1', 'No of Divisions')
            ->setCellValue('G1', 'No of Schools')
            ->setCellValue('A' . $i, $county)
            ->setCellValue('B' . $i, $district_name)
            ->setCellValue('C' . $i, $district_id)
            ->setCellValue('D' . $i, $donor)
            ->setCellValue('E' . $i, $treatment_type)
            ->setCellValue('F' . $i, $numberOfDivisions = numberOfDivisions($district_name))
            ->setCellValue('G' . $i, $numberOfSchools = numberOfSchools($district_name));
    $i++;
}

// Rename worksheet
$today = date("F j-Y");
$objPHPExcel->getActiveSheet()->setTitle('Districts');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=" Districts.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
