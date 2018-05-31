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
include "dashMtpFunctions.php";


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
			->setCellValue('A2','Planning Indicators')
			->setCellValue('B2', $data)
			->setCellValue('A3','No. of districts planned')
			->setCellValue('B3', districtsPlanned())
			->setCellValue('A4','Teacher training related indicators')
			->setCellValue('B4', $data)
			->setCellValue('A5','No. of teacher trainings planned')
			->setCellValue('B5', sum('training_sessions','form_mt_district_summary'))
			->setCellValue('A6','Average No. of schools planned per teacher training')
			->setCellValue('B6', averageSchoolsPerTT())
			->setCellValue('A7','Minimum No. of schools planned per teacher training')
			->setCellValue('B7', $data)
			->setCellValue('A8','Maximum No. of schools planned per teacher training')
			->setCellValue('B8', $data)
			->setCellValue('A9','Average days between Teacher Training and Deworming Day')
			->setCellValue('B9', $data)
			->setCellValue('A10','Minimum days between Teacher Training and Deworming Day')
			->setCellValue('B10', $data)
			->setCellValue('A11','Maximum days between Teacher Training and Deworming Day')
			->setCellValue('B11', $data)
			->setCellValue('A12','Proportion of Deworming Days taking place within 15 days of the Teacher Training')
			->setCellValue('B12', $data)
			->setCellValue('A13','Coverage planned')
			->setCellValue('B13', $data)
			->setCellValue('A14','No. of schools planned (baseline)')
			->setCellValue('B14', $data)
			->setCellValue('A15','No. of public schools')
			->setCellValue('B15', schoolType('Public'))
			->setCellValue('A16','No. of private schools')
			->setCellValue('B16', schoolType('Private'))
			->setCellValue('A17','No. of other schools')
			->setCellValue('B17', schoolType('Other'))
			->setCellValue('A18','No. of no school type schools')
			->setCellValue('B18', schoolType('none'))
			->setCellValue('A19','No. of Enrolled Primary School children')
			->setCellValue('B19', sum('ecd_pri_school_enrollment','form_p_school_list'))
			->setCellValue('A20','Average No. of Enrolled Primary School children per school')
			->setCellValue('B20', averagePerSchool('ecd_pri_school_enrollment','form_p_school_list'))
			->setCellValue('A21','Minimum No. of Enrolled Primary School children per school')
			->setCellValue('B21', $data)
			->setCellValue('A22','Maximum No. of Enrolled Primary School children per school')
			->setCellValue('B22', $data)
			->setCellValue('A23','No. of Enrolled ECD children')
			->setCellValue('B23', sum('ecd_attached_enrollment','form_p_school_list'))
			->setCellValue('A24','Average No. of Enrolled ECD children per school')
			->setCellValue('B24', averagePerSchool('ecd_attached_enrollment','form_p_school_list'))
			->setCellValue('A25','Minimum No. of Enrolled ECD children per school')
			->setCellValue('B25', $data)
			->setCellValue('A26','Maximum No. of Enrolled ECD children per school')
			->setCellValue('B26', $data)
			->setCellValue('A27','No. of Stand-alone ECD children')
			->setCellValue('B27', sum('estimated_enrollmet','form_p_school_list'))
			->setCellValue('A28','Average No. of Stand-alone ECD children per school')
			->setCellValue('B28', averagePerSchool('estimated_enrollmet','form_p_school_list'))
			->setCellValue('A29','Minimum No. of Stand-alone ECD children per school')
			->setCellValue('B29', $data)
			->setCellValue('A30','Maximum No. of Stand-alone ECD children per school')
			->setCellValue('B30', $data)
			->setCellValue('A31','No. of tablets estimated (total+20%)')
			->setCellValue('B31', markup20(sum('no_of_tablets_needed_total','form_p_school_list')))
			->setCellValue('A32','Average No. of tablets estimated (total+20%) per school')
			->setCellValue('B32', markup20(averagePerSchool('no_of_tablets_needed_total','form_p_school_list')))
			->setCellValue('A33','Minimum No. of tablets estimated (total+20%) per school')
			->setCellValue('B33', $data)	
			->setCellValue('A34','Maximum No. of tablets estimated (total+20%) per school')
			->setCellValue('B34', $data);

           



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
