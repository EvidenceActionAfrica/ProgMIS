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
// include "dashMtpFunctions.php";
include "queryFunctions.php";

$row1=numDistinctPlain('district_id','p_bysch'); 
$row2=number_format(sumPlain('mt_sessions','mt_district_summary_by_div')); 
$row3=number_format(averagePlain('p_sch_id','p_bysch','mt_sessions','mt_district_summary_by_div'),2,'.',''); 
$row4=minimum('mt_sessions','mt_district_summary_by_div'); 
$row5=maximum('mt_sessions','mt_district_summary_by_div'); 
$row6=$data; 
$row7=$data; 
$row8=$data; 
$row9=$data; 
$row10=number_format(numDistinctPlain('p_sch_id','p_bysch')); 
$row11=number_format(numFlexible('p_sch_id','p_bysch','p_sch_type','Public')); 
$row12=number_format(numFlexible('p_sch_id','p_bysch','p_sch_type','Private'));
$row13=number_format(numFlexible('p_sch_id','p_bysch','p_sch_type','Other')); 
$row14=number_format(numFlexible('p_sch_id','p_bysch','p_sch_type','None')); 
$row15=number_format(sumPlain('p_pri_enroll','p_bysch')); 
$row16=number_format(averagePlain('p_pri_enroll','p_bysch','p_sch_id','p_bysch'),2,'.',''); 
$row17=minimum('p_pri_enroll','p_bysch'); 
$row18=number_format(maximum('p_pri_enroll','p_bysch')); 
$row19=number_format(sumPlain('p_ecd_enroll','p_bysch')); 
$row20=number_format(averagePlain('p_ecd_enroll','p_bysch','p_sch_id','p_bysch')); 
$row21=minimum('p_ecd_enroll','p_bysch'); 
$row22=maximum('p_ecd_enroll','p_bysch'); 
$row23=sumPlain('p_ecd_sa_enroll','p_bysch'); 
$row24=averagePlain('p_ecd_sa_enroll','p_bysch','p_sch_id','p_bysch'); 
$row25=minimum('p_ecd_sa_enroll','p_bysch'); 
$row26=maximum('p_ecd_sa_enroll','p_bysch'); 


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
			->setCellValue('A2','No. of districts planned')
			->setCellValue('B2', $row1)
			->setCellValue('A3','Teacher training related indicators')
			->setCellValue('B3', $row2)
			->setCellValue('A4','No. of teacher trainings planned')
			->setCellValue('B4', $row2)
			->setCellValue('A5','Average No. of schools planned per teacher training')
			->setCellValue('B5', $row3)
			->setCellValue('A6','Minimum No. of schools planned per teacher training')
			->setCellValue('B6', $row4)
			->setCellValue('A7','Maximum No. of schools planned per teacher training')
			->setCellValue('B7', $row5)
			->setCellValue('A8','No. of schools planned (baseline)')
			->setCellValue('B8', $row10)
			->setCellValue('A9','No. of public schools')
			->setCellValue('B9', $row11)
			->setCellValue('A10','No. of private schools')
			->setCellValue('B10', $row12)
			->setCellValue('A11','No. of other schools')
			->setCellValue('B11', $row13)
			->setCellValue('A12','No. of no school type schools')
			->setCellValue('B12', $row14)
			->setCellValue('A13','No. of Enrolled Primary School children')
			->setCellValue('B13', $row15)
			->setCellValue('A14','Average No. of Enrolled Primary School children per school')
			->setCellValue('B14', $row16)
			->setCellValue('A15','Minimum No. of Enrolled Primary School children per school')
			->setCellValue('B15', $row17)
			->setCellValue('A16','Maximum No. of Enrolled Primary School children per school')
			->setCellValue('B16', $row18)
			->setCellValue('A17','No. of Enrolled ECD children')
			->setCellValue('B17', $row19)
			->setCellValue('A18','Average No. of Enrolled ECD children per school')
			->setCellValue('B18', $row20)
			->setCellValue('A19','Minimum No. of Enrolled ECD children per school')
			->setCellValue('B19', $row21)
			->setCellValue('A20','Maximum No. of Enrolled ECD children per school')
			->setCellValue('B20', $row22)
			->setCellValue('A21','No. of Stand-alone ECD children')
			->setCellValue('B21', $row23)
			->setCellValue('A22','Average No. of Stand-alone ECD children per school')
			->setCellValue('B22', $row24)
			->setCellValue('A23','Minimum No. of Stand-alone ECD children per school')
			->setCellValue('B23', $row25)
			->setCellValue('A24','Maximum No. of Stand-alone ECD children per school')
			->setCellValue('B24', $row26);


           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('MTP DASHBOARD');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="MTP DASHBOARD.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
