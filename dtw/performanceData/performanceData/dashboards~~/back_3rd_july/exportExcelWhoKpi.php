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


$value ="N/A";
include "includes/config.php";
// include "kpiFunctionsCiff.php";
include "queryFunctions.php";

$row1=number_format(NotEmpty('t1_name','attnt_bysch')+NotEmpty('t2_name','attnt_bysch'));
$row2=number_format(numDistinctPlain('school_id','attnt_bysch'));
$row3=number_format(attntWithCriticalMaterials());
$row4=number_format(attntNoCriticalMaterials());
$row5=number_format(attntWithCriticalMaterials('attnt_id'));
$row6=$value;
$row7=$value;
$row8=number_format(returnedForms('s_district_id'));
$row9=number_format(returnedFormA('district_id'));
$row10=$value;
$row11=$value;



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
			->setCellValue('A2','No. of teachers trained')
			->setCellValue('B2',$row1)
			->setCellValue('A3','No. of schools attending teacher training')
			->setCellValue('B3',$row2)
			->setCellValue('A4','No. of schools with critical materials present')
			->setCellValue('B4',$row3)
			->setCellValue('A5','No. of schools with no critical materials present')
			->setCellValue('B5',$row4)
			->setCellValue('A6','No. of TTs with requiered drugs')
			->setCellValue('B6',$row5)
			->setCellValue('A7','No. of district returning form ATTNR')
			->setCellValue('B7',$row6)
			->setCellValue('A8','No. of district returning form ATTNT')
			->setCellValue('B8',$row7)
			->setCellValue('A9','No. of district returning form S')
			->setCellValue('B9',$row8)
			->setCellValue('A10','No. of district returning form A')
			->setCellValue('B10',$row9)
			->setCellValue('A11','No. of district returning form D')
			->setCellValue('B11',$row10)
			->setCellValue('A12','No. of district returning form Tabs')
			->setCellValue('B12',$row11);



           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('WHO REPORT KPI');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="WHO REPORT KPI.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
