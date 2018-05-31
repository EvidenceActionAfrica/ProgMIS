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
date_default_timezone_set('Europe/London');

include "../../includes/auth.php";
include "../../includes/config.php";
include "includes/class.return-status.php";
//instansiate class
$returnStatus = new returnStatus;


// get all county returns data
$dara= $returnStatus->getAll();


if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../PHPExcel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("excel-templates/status-return-template.xls");

// Set document properties
$objPHPExcel->getProperties()->setCreator("Eavidence Action")
							 ->setLastModifiedBy("Evidence Action")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


$B=3; 
//$baseRow = 4;
            foreach ($dara as $key => $value) {
            	//$B = $baseRow + $key;
	$objPHPExcel->setActiveSheetIndex(0)


			->setCellValue('A'.$B,$returnStatus->getDistName($value['district_id']))
			
			->setCellValue('B'.$B,$value['rt_moe_recieved'])
			->setCellValue('C'.$B,$value['rt_mophs_recieved'])
			->setCellValue('D'.$B,$value['tts_moe_recieved'])
			->setCellValue('E'.$B,$value['tts_mophs_recieved'])
			->setCellValue('F'.$B,$value['dd_moe_recieved'])
			->setCellValue('G'.$B,$value['dd_mophs_recieved']);	



			$B++;
}
//$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('RETURN STATUS');


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
