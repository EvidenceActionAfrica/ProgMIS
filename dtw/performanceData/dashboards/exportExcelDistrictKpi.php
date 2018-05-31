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
// include "kpiFunctionsCiff.php";
include "queryFunctions.php";

$row1=number_format(numDistinctPlain('district_id','a_bysch'));
$row2=number_format(num('school_id','a_bysch'));
$row3=number_format(num('p_sch_id','p_bysch'));
$row4=number_format(EstimatedTotalSTH());
$row5=number_format(sumSTH());
$row6=number_format(sumMaleFormA());
$row7=number_format(sumFemaleFormA());
$row8=number_format(sum6andOverFormA());
$row9=number_format(sumUnder5());
$row10=number_format(sumArgs('a_bysch','a_trt_m','a_trt_f'));
$row11=number_format(sumNonEnrolled6andover('STH'));
$row12=number_format(sumNonEnrolledGender('a_2','a_bysch'));
$row13=number_format(sumArgs('a_bysch','a_ecd_m','a_ecd_f'));
$row14=number_format(EstimatedTotalSHISTO());
$row15=number_format(sumSHISTO());
$row16=number_format(sumMaleFormAP());
$row17=number_format(sumFemaleFormAP());



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
			->setCellValue('A2','No. of districts covered for STH')
			->setCellValue('B2',$row1)
			->setCellValue('A3','No. of schools treated for STH')
			->setCellValue('B3',$row2)
			->setCellValue('A4','No. of schools targeted for STH')
			->setCellValue('B4',$row3)
			->setCellValue('A5','Estimated target population of STH')
			->setCellValue('B5',$row4)
			->setCellValue('A6','No. of  children dewormed for STH once')
			->setCellValue('B6',$row5)
			->setCellValue('A7','No. of children dewormed for STH (male)')
			->setCellValue('B7',$row6)
			->setCellValue('A8','No. of children dewormed for STH (female)')
			->setCellValue('B8',$row7)
			->setCellValue('A9','No. of children 6 and over receiving STH treatment')
			->setCellValue('B9',$row8)
			->setCellValue('A10','No. of U5 children dewormed for STH')
			->setCellValue('B10',$row9)
			->setCellValue('A11','No. of Enrolled Primary School Aged children dewormed for STH')
			->setCellValue('B11',$row10)
			->setCellValue('A12','No. of Non-enrolled (age 6-18) children dewormed for STH')
			->setCellValue('B12',$row11)
			->setCellValue('A13','No. of Non Enrolled (age 2-5) children dewormed for STH')
			->setCellValue('B13',$row12)
			->setCellValue('A14','No. of ECD children dewormed for STH')
			->setCellValue('B14',$row13)
			->setCellValue('A15','Estimated target population of Schisto')
			->setCellValue('B15',$row14)
			->setCellValue('A16','No. of children dewormed for Schisto once')
			->setCellValue('B16',$row15)
			->setCellValue('A17','No. of children dewormed for Schisto (Male)')
			->setCellValue('B17',$row16)
			->setCellValue('A18','No. of children dewormed for Schisto (Female)')
			->setCellValue('B18',$row17);


           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('DISTRICT REPORT KPI');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="DISTRICT REPORT KPI.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
