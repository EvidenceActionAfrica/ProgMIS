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


$placeholder ="N/A";
$path="../../";
include $path."includes/auth.php";
include $path."includes/config.php";
include "queryFunctions.php";

$row1=$placeholder;
$row2=number_format(sumPlain('p_pri_enroll','p_bysch'));
$row3=number_format(sumSTH());
$row4=number_format(sumUnder5());
$row5=number_format(sumArgs('a_bysch','a_trt_m','a_trt_f'));
$row6=number_format(sumNonEnrolled6andover('STH'));
$row7=number_format(sumEstimated('p_pri_enroll','Y'));
$row8=number_format(sumSHISTO());
$row9=number_format(sumArgs('a_bysch','ap_trt_m','ap_trt_f','ap_ecd_f','ap_ecd_m'));
$row10=number_format(sumNonEnrolled6andover('SHISTO'));
$row11=$placeholder;
$row12=number_format(num('school_id','attnt_bysch'));
$row13=number_format(attntWithCriticalMaterials());
$row14=number_format(numFlexible('attnt_id','attnt_bysch','attnt_total_drugs','1'));
$row15=$placeholder;
$row16=$placeholder;
$row17=$placeholder;


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
			->setCellValue('A2',"No. of schools  reporting to deworming on designated county deworming day")
			->setCellValue('A3',"Estimated No. of 'Enrolled Primary School' children for STH")
			->setCellValue('B3',$row2)
			->setCellValue('A4',"No. of  children dewormed for STH once")
			->setCellValue('B4',$row3)
			->setCellValue('A5',"No. of U5 children dewormed for STH")
			->setCellValue('B5',$row4)
			->setCellValue('A6',"No. of Enrolled Primary School Aged children dewormed for STH")
			->setCellValue('B6',$row5)
			->setCellValue('A7',"No. of Non-enrolled (age 6-18) children dewormed for STH")
			->setCellValue('B7',$row6)
			->setCellValue('A8',"Estimated No. of 'Enrolled Primary School' children for SCHISTO")
			->setCellValue('B8',$row7)
			->setCellValue('A9',"No. of children dewormed for Schisto once")
			->setCellValue('B9',$row8)
			->setCellValue('A10',"No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto")
			->setCellValue('B10',$row9)
			->setCellValue('A11',"No. of Non Enrolled (age 6-18) children dewormed for Schisto")
			->setCellValue('B11',$row10)
			->setCellValue('A12',"No. target schools attending teacher training sessions")
			->setCellValue('B12',$row11)
			->setCellValue('A13',"No. of schools attending teacher training")
			->setCellValue('B13',$row12)
			->setCellValue('A14',"No. of schools with critical materials present")
			->setCellValue('B14',$row13)
			->setCellValue('A15',"No. of TTs with requiered drugs")
			->setCellValue('B15',$row14)
			->setCellValue('A16',"% Districts submitting forms S,A,and D to National level within three months of deworming day")
			->setCellValue('B16',$row15)
			->setCellValue('A17',"% divisions correctly (+/- 10%) reporting on school level coverage of total children dewormed.")
			->setCellValue('B17',$row16)
			->setCellValue('A18',"% districts correctly (+/- 10%) reporting on school-level coverage of total children dewormed.")
			->setCellValue('B18',$row17);


           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('DashBoard Attnt');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Ciff KPI.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
