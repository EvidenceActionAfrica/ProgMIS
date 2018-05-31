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

$result_set = mysql_query("SELECT * FROM assumptions_county_ALB_list");
$i=0;
while ($row = mysql_fetch_array($result_set)) {
$objPHPExcel->setActiveSheetIndex(0)
			
	  		->setCellValue('A1','County')
            ->setCellValue('B1','Number of districts')
            ->setCellValue('C1','Number of schools')
            ->setCellValue('D1','Number of Children')
            ->setCellValue('E1','Number of Adults')
            ->setCellValue('F1','Tabs for children')
            ->setCellValue('G1','Tabs for adults')
            ->setCellValue('H1','Tabs for Spoilage')
            ->setCellValue('I1','Tabs for Tin Round Up')
            ->setCellValue('J1','Extra for districts')
            ->setCellValue('K1','Total Tabs')

 			->setCellValue('A'.$i,$row['county_name'])
 			->setCellValue('B'.$i,$row['county_alb_number_of_districts'])
			->setCellValue('C'.$i,$row['county_alb_number_of_schools'])
			->setCellValue('D'.$i,$row['county_alb_total_children_to_treat'])
			->setCellValue('E'.$i,$row['county_alb_total_adults_to_treat'])
			->setCellValue('F'.$i,$row['county_tabs_for_children'])
			->setCellValue('G'.$i,$row['county_tabs_for_adults'])
			->setCellValue('H'.$i,$row['county_alb_tabs_for_spoilage'])
			->setCellValue('I'.$i,$row['county_alb_tabs_round_up'])
			->setCellValue('J'.$i,$row['county_district_extra_alb'])
			->setCellValue('K'.$i,$row['county_alb_total_tabs']);
			$i++;
	}


           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle(' County ALB Requirements');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=" County ALB Requirements.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
