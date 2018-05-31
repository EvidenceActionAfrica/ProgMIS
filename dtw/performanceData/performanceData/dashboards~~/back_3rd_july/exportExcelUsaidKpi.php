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


$data ="N/A";
include "includes/config.php";
include "queryFunctions.php";

$row1=number_format(num('school_id','a_bysch'));
$row2=number_format(num('p_sch_id','p_bysch'));
$row3=number_format(EstimatedTotalSTH());
$row4=number_format(sumSTH());
$row5=number_format(numDistinctPlain('school_id','attnt_bysch'));
$row6=number_format(attntWithCriticalMaterials());
$row7=number_format(numFlexible('school_id','attnt_bysch','attnt_total_poles','1'));
$row8=number_format(numFlexible('attnt_id','attnt_bysch','attnt_total_drugs','1'));
$row9=$data;
$row10=$data;



/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';


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

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1','Indicator')
			->setCellValue('B1','Total')
			->setCellValue('A2', 'No. of schools treated for STH')
			->setCellValue('B2', $row1)
			->setCellValue('A3', 'No. of schools targeted for STH')
			->setCellValue('B3', $row2)
			->setCellValue('A4', 'Estimated target population of STH')
			->setCellValue('B4', $row3)
			->setCellValue('A5', 'No. of  children dewormed for STH once')
			->setCellValue('B5', $row4)
			->setCellValue('A6', 'No. of schools attending teacher training')
			->setCellValue('B6', $row5)
			->setCellValue('A7', 'No. of schools with critical materials present')
			->setCellValue('B7', $row6)
			->setCellValue('A8', 'No. of schools with poles')
			->setCellValue('B8', $row7)
			->setCellValue('A9', 'No. of TTs with requiered drugs')
			->setCellValue('B9', $row8)
			->setCellValue('A10', 'No. of Gok district personnel at regional training')
			->setCellValue('B10', $row9)
			->setCellValue('A11', 'No. of Gok divisional personnel at regional training')
			->setCellValue('B11', $row10);


           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('USAID KPI REPORT');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="USAID REPORT KPI.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
