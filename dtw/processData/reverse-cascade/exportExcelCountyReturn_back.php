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

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

include "includes/class.CountyReturn.php";
//instansiate class
$countyReturn = new countyReturn;


// get all county returns data
$dara= $countyReturn->getAll();


if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../PHPExcel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Evidence Action")
							 ->setLastModifiedBy("Evidence Action")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("County Returns.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


$B=2;
            foreach ($dara as $key => $value) {
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1','County Name')
			->setCellValue('B1','moe_monitoring')
			->setCellValue('C1','moe_meeting')
			->setCellValue('D1','mophs_community')
			->setCellValue('E1','mophs_monitoring')
			->setCellValue('F1','mophs_meeting')

			->setCellValue('A'.$B,$countyReturn->getCountyName($value['county_id']))
			->setCellValue('B'.$B,$value['moe_monitoring'])
			->setCellValue('C'.$B,$value['moe_meeting'])
			->setCellValue('D'.$B,$value['mophs_community'])
			->setCellValue('E'.$B,$value['mophs_monitoring'])
			->setCellValue('F'.$B,$value['mophs_meeting']);



			$B++;
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('COUNTY RETURN STATUS');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

ob_clean();

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="COUNTY RETURN STATUS".xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
