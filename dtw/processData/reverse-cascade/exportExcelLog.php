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

date_default_timezone_set('Europe/London');


$data ="N/A";

include "../../includes/auth.php";
include "../../includes/config.php";
require_once("includes/class.log-export.php");

//instaciate class
$logExport = new logExport;

//get districts
$districts = $logExport->getDistricts();


$dara = $logExport->getByFormType($_GET['log']);



if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../PHPExcel/Classes/PHPExcel.php';


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


$B=2;
            foreach ($dara as $key => $value) {
                $check_val =$value['district_id'];
                $query = "SELECT * FROM districts WHERE district_id='$check_val' ";
    $result = mysql_query($query) or die(mysql_error());
    $row = mysql_fetch_array($result);
    $district = $row['district_name'];
    echo $district;
	if (isset($_GET['log'])) {
        $expected_value = $logExport->calculateExpecetd($_GET['log'], $value['district_id']);
    }
    $variance = $logExport->variance($expected_value, $value['received']);
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Distirct Name')
            ->setCellValue('B1', 'Expeceted')
            ->setCellValue('C1', 'Recieved')
            ->setCellValue('D1', 'Variance')
            ->setCellValue('E1', 'Date Recieved')
            ->setCellValue('F1', 'Stamp Range')
            ->setCellValue('H1', 'Scrutiny')
            ->setCellValue('G1', 'Scanned')
            ->setCellValue('I1', 'Couriered')
            ->setCellValue('A' . $B, $logExport->getDistName($value['district_id']))
            ->setCellValue('B' . $B, $expected_value)
            ->setCellValue('C' . $B, $value['received'])
            ->setCellValue('D' . $B, $variance)
            ->setCellValue('E' . $B, $value['date_recieved'])
            ->setCellValue('F' . $B, $value['stamp_range'])
            ->setCellValue('G' . $B, $value['scrutiny'])
            ->setCellValue('H' . $B, $value['scanning'])
            ->setCellValue('I' . $B, $value['courier']);

			$B++;
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('form');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

ob_clean();

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="log form.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
