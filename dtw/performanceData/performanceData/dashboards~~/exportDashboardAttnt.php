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
include "dashAttntFunctions.php";


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
			->setCellValue('A2','No. of districts covered')
			->setCellValue('B2', getDistrict())
			->setCellValue('A3','No. of TTs')
			->setCellValue('B3', $data)				
			->setCellValue('A4','No. of TTs for STH only')
			->setCellValue('B4', $data)				
			->setCellValue('A5','No. of TTs for STH and Schisto')
			->setCellValue('B5', $data)				
			->setCellValue('A6','No. of TTs with no drugs - for STH only')
			->setCellValue('B6', $data)				
			->setCellValue('A7','No. of TTs with no drugs - for STH and Schisto')
			->setCellValue('B7', $data)				
			->setCellValue('A8','No. of TTs with no drugs - All')
			->setCellValue('B8', $data)				
			->setCellValue('A9','No. of TTs with PZQ only - for STH only')
			->setCellValue('B9', $data)				
			->setCellValue('A10','No. of TTs with PZQ only - for STH and Schisto')
			->setCellValue('B10', $data)				
			->setCellValue('A11','No. of TTs with PZQ only - All')
			->setCellValue('B11', $data)				
			->setCellValue('A12','No. of TTs with ALB only - for STH only')
			->setCellValue('B12', $data)				
			->setCellValue('A13','No. of TTs with ALB only - for STH and Schisto')
			->setCellValue('B13', $data)				
			->setCellValue('A14','No. of TTs with ALB only - All')
			->setCellValue('B14', $data)				
			->setCellValue('A15','No. of TTs with both drugs - for STH only')
			->setCellValue('B15', $data)				
			->setCellValue('A16','No. of TTs with both drugs - for STH and Schisto')
			->setCellValue('B16', $data)				
			->setCellValue('A17','No. of TTs with both drugs - All')
			->setCellValue('B17', $data)				
			->setCellValue('A18','No. of TTs with drugs present')
			->setCellValue('B18', $data)				
			->setCellValue('A19','No. of TTs with drugs missing')
			->setCellValue('B19', $data)				
			->setCellValue('A20','No. of schools covered')
			->setCellValue('B20', numAttnt('school'))				
			->setCellValue('A21','No. of schools covered for STH only')
			->setCellValue('B21', numAttntSth('school'))				
			->setCellValue('A22','No. of schools covered for STH and Schisto')
			->setCellValue('B22', numAttntShistoAndSth('school'))				
			->setCellValue('A23','No. of schools with nothing distributed - for STH only')
			->setCellValue('B23', numAttntNothingDistributedSth())				
			->setCellValue('A24','No. of schools with nothing distributed - for STH and Schisto')
			->setCellValue('B24', numAttntNothingDistributedSthAndSshisto())				
			->setCellValue('A25','No. of schools with nothing distributed - All')
			->setCellValue('B25', $data)				
			->setCellValue('A26','No. of schools with forms only distributed - for STH only')
			->setCellValue('B26', numAttntOnylFormsDistributedSth())				
			->setCellValue('A27','No. of schools with forms only distributed - for STH and Schisto')
			->setCellValue('B27', numAttntOnylFormsDistributedSthAndShisto())				
			->setCellValue('A28','No. of schools with forms only distributed - All')
			->setCellValue('B28', $data)				
			->setCellValue('A29','No. of schools with poles only distributed - for STH only')
			->setCellValue('B29', numAttntOnyPolesSth())				
			->setCellValue('A30','No. of schools with poles only distributed - for STH and Schisto')
			->setCellValue('B30', numAttntOnyPolesSthAndShisto())				
			->setCellValue('A32','No. of schools with poles only distributed - All')
			->setCellValue('B32', $data)				
			->setCellValue('A32','No. of schools with poles and forms distributed - for STH only')
			->setCellValue('B32', numAttntOnlyPolesSAndFormsSth())				
			->setCellValue('A33','No. of schools with poles and forms distributed - for STH and Schisto')
			->setCellValue('B33', numAttntOnlyPolesSAndFormsSthAndShisto())				
			->setCellValue('A34','No. of schools with poles and forms distributed - All')
			->setCellValue('B34', $data)				
			->setCellValue('A35','No. of schools with drugs only distributed - for STH only')
			->setCellValue('B35', numAttntOnlyDrugsSth())				
			->setCellValue('A36','No. of schools with drugs only distributed - for STH and Schisto')
			->setCellValue('B36', numAttntOnlyDrugsSthAndShisto())				
			->setCellValue('A37','No. of schools with drugs only distributed - All')
			->setCellValue('B37', $data)				
			->setCellValue('A38','No. of schools with drugs and forms distributed - for STH only')
			->setCellValue('B38', OnlyDrugsAndFormsSth())				
			->setCellValue('A39','No. of schools with drugs and forms distributed - for STH and Schisto')
			->setCellValue('B39', OnlyDrugsAndFormsSthAndShisto())				
			->setCellValue('A40','No. of schools with drugs and forms distributed - All')
			->setCellValue('B40', $data)				
			->setCellValue('A41','No. of schools with drugs and poles distributed - for STH only')
			->setCellValue('B41', OnlyDrugsAndPolesSth())				
			->setCellValue('A42','No. of schools with drugs and poles distributed - for STH and Schisto')
			->setCellValue('B42', OnlyDrugsAndPolesSthAndShisto())				
			->setCellValue('A43','No of schools with drugs and poles distributed - All')
			->setCellValue('B43', $data)				
			->setCellValue('A44','No. of schools with drugs, poles and forms distributed - for STH only')
			->setCellValue('B44', OnlyDrugsAndPolesAndFormsSth())				
			->setCellValue('A45','No. of schools with drugs, poles and forms distributed - for STH and Schisto')
			->setCellValue('B45', OnlyDrugsAndPolesAndFormsSthAndShisto())				
			->setCellValue('A46','No. of schools with drugs, poles and forms distributed - All')
			->setCellValue('B46', $data)				
			->setCellValue('A47','No. of schools with critical materials present')
			->setCellValue('B47', $data)				
			->setCellValue('A48','No. of schools with critical materials missing')
			->setCellValue('B48', $data);

           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('DashBoard Attnt');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="DashBoard Attnt.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
