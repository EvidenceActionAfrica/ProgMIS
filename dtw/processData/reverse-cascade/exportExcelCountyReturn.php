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
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

date_default_timezone_set('Europe/London');

include "../../includes/auth.php";
include "../../includes/config.php";
include "includes/class.CountyReturn.php";

//instansiate class
$countyReturn = new countyReturn;

// get all county returns data
$dara= $countyReturn->getAll();

// echo "<pre>";var_dump($dara);echo "</pre>";

// exit();


if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../PHPExcel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();


// echo date('H:i:s') , " Load from Excel5 template" , EOL;
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("excel-templates/county-return-template.xls");



// Set document properties
$objPHPExcel->getProperties()->setCreator("Evidence Action")
							 ->setLastModifiedBy("Evidence Action")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("County Returns.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");



$B=5; 
//$baseRow = 2;
            foreach ($dara as $key => $value) {
            	//$B = $baseRow + $key;
	$objPHPExcel->setActiveSheetIndex(0)

			->setCellValue('A'.$B,$countyReturn->getCountyName($value['county_id']))
			->setCellValue('B'.$B,$value['moe_financial_returns_received'])
			->setCellValue('C'.$B,$value['moe_attnc_received'])
			->setCellValue('D'.$B,$value['moe_attnc_couriered'])
			->setCellValue('E'.$B,$value['moh_financial_returns_received'])
			->setCellValue('F'.$B,$value['moh_attnc_received'])
			->setCellValue('G'.$B,$value['moh_attnc_couriered'])
			->setCellValue('H'.$B,$value['moh_cd_recording_received'])
			->setCellValue('I'.$B,$value['moh_cd_recording_couriered']);

			$B++;
}

//$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('COUNTY RETURN STATUS');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

ob_clean();

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="RETURN STATUS".xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

