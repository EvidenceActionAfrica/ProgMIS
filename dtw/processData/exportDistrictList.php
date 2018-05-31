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
include "../includes/config.php";
// include "kpiFunctionsCiff.php";
require_once('assumptions.func.php');

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../PHPExcel/Classes/PHPExcel.php';


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

$result_set = mysql_query("SELECT * FROM assumptions_district_list");
$i=2;
while ($row = mysql_fetch_array($result_set)) {
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1','County')
            ->setCellValue('B1','District')
            ->setCellValue('C1','Distirct  ID')
            ->setCellValue('D1','Number of schools')
            ->setCellValue('E1','Number of schisto schools')
            ->setCellValue('F1','ALB')
            ->setCellValue('G1','PZQ')
            ->setCellValue('H1','District Extra ALB')
            ->setCellValue('I1','District Extra PZQ')
            ->setCellValue('J1','Total Albendazole')
            ->setCellValue('K1','Total PZQ')
            ->setCellValue('L1','Next Treatment')
            ->setCellValue('M1','Schisto district')

			->setCellValue('A'.$i,$row['county_name'])
			->setCellValue('B'.$i,$row['district_name'])
			->setCellValue('C'.$i,$row['district_id'])
			->setCellValue('D'.$i,$row['numberOfSChools'])
			->setCellValue('E'.$i,$row['numberOfShistoSchools'])
			->setCellValue('F'.$i,$row['pzqAmount'])
			->setCellValue('G'.$i,$row['alb_amount'])
			->setCellValue('H'.$i,$row['district_extra_alb'])
			->setCellValue('I'.$i,$row['extra_pzq'])
			->setCellValue('J'.$i,$row['total_alb'])
			->setCellValue('K'.$i,$row['total_pzq'])
			->setCellValue('L'.$i,$row['next_treatment'])
			->setCellValue('M'.$i,$row['shistoDistrict']);
			$i++;
	}


           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('DISTRICT list export');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="DISTRICT lisr requisition.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
