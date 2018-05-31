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
// include "includes/config.php";
require_once "../includes/class.ntd.php";

// get all the data from table
$ntd=new ntd;
$data=$ntd->getAll();

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../../PHPExcel/Classes/PHPExcel.php';


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
$B=2;
// $objPHPExcel->setActiveSheetIndex(0)
			// ->setCellValue('A1','County')
			// ->setCellValue('B1','District Name')
			// ->setCellValue('C1','Rounds')
			// ->setCellValue('D1','Year')
			// ->setCellValue('E1','Month')
			// ->setCellValue('F1','Total No. of Schools Treated')
			// ->setCellValue('G1','Total No. U5 Treated')
			// ->setCellValue('H1','Total No. SAC Treated')
			// ->setCellValue('I1','Total No. of 15+ Treated')
			// ->setCellValue('J1','Total No. U5 Male Treated')
			// ->setCellValue('K1','Total No. U5 Female Treated')
			// ->setCellValue('L1','Total No. SAC Male Treated')
			// ->setCellValue('M1','Total No. SAC Female Treated')
			// ->setCellValue('N1','Total No. of 15+ Male Treated')
			// ->setCellValue('O1','Total No. of 15+ Female Treated')
			// ->setCellValue('P1','Total Adults Treated')
			// ->setCellValue('Q1','Target U5')
			// ->setCellValue('R1','Target SAC')
			// ->setCellValue('S1','Target Adult')

foreach ($data as $key => $value) {
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1','County')
			->setCellValue('B1','District Name')
			->setCellValue('C1','Rounds')
			->setCellValue('D1','Year')
			->setCellValue('E1','Month')
			->setCellValue('F1','Total No. of Schools Treated')
			->setCellValue('G1','Total No. U5 Treated')
			->setCellValue('H1','Total No. SAC Treated')
			->setCellValue('I1','Total No. of 15+ Treated')
			->setCellValue('J1','Total No. U5 Male Treated')
			->setCellValue('K1','Total No. U5 Female Treated')
			->setCellValue('L1','Total No. SAC Male Treated')
			->setCellValue('M1','Total No. SAC Female Treated')
			->setCellValue('N1','Total No. of 15+ Male Treated')
			->setCellValue('O1','Total No. of 15+ Female Treated')
			->setCellValue('P1','Total Adults Treated')
			->setCellValue('Q1','Target U5')
			->setCellValue('R1','Target SAC')
			->setCellValue('S1','Target Adult')

			->setCellValue('A'.$B,$ntd->getDistrictCounty($value['district_id'],'name'))
			->setCellValue('B'.$B,$ntd->getDistName($value['district_id']))
			->setCellValue('C'.$B,'Rounds')
			->setCellValue('D'.$B,'Year')
			->setCellValue('E'.$B,'Month')
			->setCellValue('F'.$B,$value['schools_treated'])
			->setCellValue('G'.$B,$value['u5_treated'])
			->setCellValue('H'.$B,$value['sac_treated'])
			->setCellValue('I'.$B,$value['over_15_treated'])
			->setCellValue('J'.$B,$value['u5_male_treated'])
			->setCellValue('K'.$B,$value['u5_female_treated'])
			->setCellValue('L'.$B,$value['sac_male_treated'])
			->setCellValue('M'.$B,$value['sac_female_treated'])
			->setCellValue('N'.$B,$value['over_15_male_treated'])
			->setCellValue('O'.$B,$value['over_15_female_treated'])
			->setCellValue('P'.$B,$value['adults_treated'])
			->setCellValue('Q'.$B,$value['target_u5'])
			->setCellValue('R'.$B,$value['target_sac'])
			->setCellValue('S'.$B,$value['target_adult']);

			$B++;
}
			




           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('District STH');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="District STH.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
