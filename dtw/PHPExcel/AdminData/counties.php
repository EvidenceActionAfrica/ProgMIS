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

// number of districts in county
function numberOfDistricts($county) {
    $query = "SELECT * FROM districts WHERE county='$county' ";
    $result = mysql_query($query) or die("<h1>Cant get districts</h1>" . mysql_error());

    $num = mysql_num_rows($result);

    return $num;
}

// number of divisions in county
function numberOfDivisions($county) {
    $query = "SELECT * FROM divisions WHERE county='$county'";
    $result = mysql_query($query) or die("<h1>Cant get divisions</h1>" . mysql_error());
    $num = mysql_num_rows($result);
    return $num;
}

// number of divisins in schools
function numberOfSchools($county) {
    $query = "SELECT * FROM schools WHERE county='$county'";
    $result = mysql_query($query) or die("<h1>Cant get county</h1>" . mysql_error());
    $num = mysql_num_rows($result);
    return $num;
}

//count all the row of the table
function row_total() {
    $query_row = "SELECT * FROM counties";
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

$result_set = mysql_query("SELECT * FROM counties  ORDER BY county ASC ");
$i = 0;
while ($row = mysql_fetch_array($result_set)) {
    $county = $row['county'];
    $county_id = $row['county_id'];
    $numberOfDistricts = numberOfDistricts($county);
    $numberOfDivisions = numberOfDivisions($county);
    $numberOfSchools = numberOfSchools($county);
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'County')
            ->setCellValue('B1', 'County ID')
            ->setCellValue('C1', 'Number of Sub-Counties')
            ->setCellValue('D1', 'Number of Divisions')
            ->setCellValue('E1', 'Number of Schools')
            ->setCellValue('A' . $i, $county)
            ->setCellValue('B' . $i, $county_id)
            ->setCellValue('C' . $i, $numberOfDistricts)
            ->setCellValue('D' . $i, $numberOfDivisions)
            ->setCellValue('E' . $i, $numberOfSchools);
    $i++;
}

// Rename worksheet
$today = date("F j-Y");
$objPHPExcel->getActiveSheet()->setTitle(' Counties');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=" Counties.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
