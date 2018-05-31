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

include "dashFormSFunctions.php";





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
			->setCellValue('A2','Coverage Indicators')
			->setCellValue('B2','')
			->setCellValue('A3', 'Number of districts covered')
			->setCellValue('B3', numOfDistrictsCovered())
			->setCellValue('A4', 'Number of schools covered')
			->setCellValue('B4', numOfSchoolsCovered())
			->setCellValue('A5', 'Number dewormed (children + adults)')
			->setCellValue('B5', numOfDewormed())
			->setCellValue('A6', 'Number of children dewormed')
			->setCellValue('B6', numOfDewormedChildren())
			->setCellValue('A7', 'Average children dewormed per district')
			->setCellValue('B7', averageChildrenDewormedPerDistrict())
			->setCellValue('A8', 'Range of district coverage (max district average)')
			->setCellValue('B8', $data)
			->setCellValue('A9', 'Range of district coverage (min district average)')
			->setCellValue('B9', $data)
			->setCellValue('A10', 'Number of Enrolled Primary plus Enrolled ECD children dewormed')
			->setCellValue('B10', numPrimaryAndEcdChildrenDewormed())
			->setCellValue('A11', 'Number of ECD children dewormed')
			->setCellValue('B11', ecdChildrenDewormed('ecd_treated_children_total'))
			->setCellValue('A12', 'Number of ECD Male children dewormed')
			->setCellValue('B12', ecdChildrenDewormed('ecd_treated_male'))
			->setCellValue('A13', 'Number of ECD Female children dewormed')
			->setCellValue('B13', ecdChildrenDewormed('ecd_treated_female'))
			->setCellValue('A14', 'Number of Primary children dewormed')
			->setCellValue('B14', primaryChildrenDewormed('number_treated_total'))
			->setCellValue('A15', 'Number of Primary Male children dewormed')
			->setCellValue('B15', primaryChildrenDewormed('number_treated_male'))
			->setCellValue('A16', 'Number of Primary Female children dewormed')
			->setCellValue('B16', primaryChildrenDewormed('number_treated_female'))
			->setCellValue('A17', 'Number of Primary children registered')
			->setCellValue('B17', primaryChildrenDewormed('number_in_register_class_total'))
			->setCellValue('A18', 'Number of Male Primary children registered')
			->setCellValue('B18', primaryChildrenDewormed('number_in_register_male'))
			->setCellValue('A19', 'Number of Female Primary children registered')
			->setCellValue('B19', primaryChildrenDewormed('number_in_register_female'))
			->setCellValue('A20', 'Number of Non Enrolled children dewormed')
			->setCellValue('B20', nonEnrolledChildrenDewormed('non_enrolled_total'))
			->setCellValue('A21', 'Number of children aged 2-5 years dewormed')
			->setCellValue('B21', allNonEnrolled2_5ChildrenDewormed())
			->setCellValue('A22', 'Number of male children aged 2-5 years dewormed')
			->setCellValue('B22', nonEnrolledChildrenDewormed('years_6_10_male'))
			->setCellValue('A23', 'Number of female children aged 2-5 years dewormed')
			->setCellValue('B23', nonEnrolledChildrenDewormed('years_6_10_male'))
			->setCellValue('A24', 'Number of children aged 6+ years dewormed')
			->setCellValue('B24', nonEnrolledOver6())
			->setCellValue('A25', 'Number of male children aged 6+ years dewormed')
			->setCellValue('B25', nonEnrolledOver6Male())
			->setCellValue('A26', 'Number of female children aged 6+ years dewormed')
			->setCellValue('B26', nonEnrolledOver6Female())
			->setCellValue('A27', 'Number of adults dewormed')
			->setCellValue('B27', adultsDewormed())
			->setCellValue('A28', 'Supply Estimation Indicators')
			->setCellValue('B28', '')
			->setCellValue('A29', 'No. of tablets spoilt')
			->setCellValue('B29', numSpoiltTablets())
			->setCellValue('A30', 'No. of tablets supplied')
			->setCellValue('B30', ecdChildrenDewormed('albendazole_recieved'))
			->setCellValue('A31', 'No. of tablets used (includes tablets given to children and adults and tablets spoilt')
			->setCellValue('B31', tabletsUsed())
			->setCellValue('A32', 'No. of tablets returned')
			->setCellValue('B32', ecdChildrenDewormed('albendazole_returned'))
			->setCellValue('A33', 'Ratio of tablets used to supplied')
			->setCellValue('B33', ratioSuippliedToSpoiltTablets())
			->setCellValue('A34', 'Ratio of tablets spolit to tablets supplied')
			->setCellValue('B34', ratioSpoiltToSuppliedTablets())
			->setCellValue('A35', 'SCHISTO Indicators')
			->setCellValue('B35', $data)
			->setCellValue('A36', 'No. of districts covered')
			->setCellValue('B36', num('district','form_ap'))
			->setCellValue('A37', 'No. of schools covered')
			->setCellValue('B37', num('school_name','form_ap'))
			->setCellValue('A38', 'No. dewormed (children + adults)')
			->setCellValue('B38', $data)
			->setCellValue('A39', 'No. of children dewormed')
			->setCellValue('B39', $data)
			->setCellValue('A40', 'No. of Enrolled Primary + Enrolled ECD children dewormed')
			->setCellValue('B40', $data)
			->setCellValue('A41', 'No. of ECD children dewormed')
			->setCellValue('B41', $data)
			->setCellValue('A42', 'No. of Primary children dewormed')
			->setCellValue('B42', $data)
			->setCellValue('A43', 'No. of Primary Male children dewormed')
			->setCellValue('B43', $data)
			->setCellValue('A44', 'No. of Primary Female children dewormed')
			->setCellValue('B44', $data)
			->setCellValue('A45', 'No. of Primary children registered')
			->setCellValue('B45', $data)
			->setCellValue('A46', 'No. of Non Enrolled children dewormed')
			->setCellValue('B46', $data)
			->setCellValue('A47', 'No. of adults dewormed')
			->setCellValue('B47', $data)
			->setCellValue('A48', 'No. of tablets spoilt')
			->setCellValue('B48', $data)
			->setCellValue('A49', 'No. of tablets supplied')
			->setCellValue('B49', $data)
			->setCellValue('A50', 'No. of tablets used (includes tablets given to children and adults and tablets spoilt')
			->setCellValue('B50', $data)
			->setCellValue('A51', 'Number of tablets returned')
			->setCellValue('B51', $data);

           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('Form S DashBoard');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Form S DashBoard.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
