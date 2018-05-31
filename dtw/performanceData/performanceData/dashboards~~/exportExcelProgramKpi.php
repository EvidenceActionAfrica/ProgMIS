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
// include "kpiFunctionsCiff.php";
include "queryFunctions.php";

$row1=number_format(numDistinctPlain('district_id','a_bysch'));
$row2=number_format(numDistinctPlain('division_id','a_bysch'));
$row3=number_format(num('school_id','a_bysch'));
$row4=number_format(num('p_sch_id','p_bysch'));
$row5=number_format(numFlexible('s_prog_sch_id','s_bysch','s1_school_type','Public'));
$row6=number_format(numFlexible('s_prog_sch_id','s_bysch','s1_school_type','Private'));
$row7=number_format(numFlexible('s_prog_sch_id','s_bysch','s1_school_type','Other'));
$row8=number_format(numFlexible('s_prog_sch_id','s_bysch','s1_school_type','None'));
$row9=number_format(EstimatedTotalSTH());
$row10=number_format(sumPlain('p_pri_enroll','p_bysch'));
$row11=number_format(sumPlain('p_ecd_enroll','p_bysch'));
$row12=number_format(sumPlain('p_ecd_sa_enroll','p_bysch'));
$row13=number_format(sumPlain('p_alb','p_bysch'));
$row14=number_format(sumSTH());
$row15=number_format(sumUnder5());
$row16=number_format(sumPlain('a_treated_b','a_bysch'));
$row17=number_format(sumNonEnrolled6andover('STH'));
$row18=number_format(sumNonEnrolledGender('a_6','a_bysch'));
$row19=number_format(sumNonEnrolledGender('a_11','a_bysch'));
$row20=number_format(sumNonEnrolledGender('a_15','a_bysch'));
$row21=number_format(sumNonEnrolledGender('a_2','a_bysch'));
$row22=number_format(sumArgs('a_bysch','a_ecd_m','a_ecd_f'));
$row23=number_format(numDistinct('district_id','a_bysch','Yes'));
$row24=number_format(numDistinct('school_id','a_bysch','Yes'));
$row25=number_format(numSchoolTypeS('Public','Yes'));
$row26=number_format(numSchoolTypeS('Private','Yes'));
$row27=number_format(numSchoolTypeS('Other','Yes'));
$row28=number_format(numSchoolTypeS('Not specified','Yes'));
$row29=number_format(numDistinctP('district_id','Y'));
$row30=number_format(numDistinctP('p_sch_id','Y'));
$row31=number_format(EstimatedTotalSHISTO());
$row32=number_format(sumEstimated('p_pri_enroll','Y'));
$row33=number_format(sumEstimated('p_ecd_enroll','Y'));
$row34=number_format(sumEstimated('p_ecd_sa_enroll','Y'));
$row35=number_format(sumSHISTO());
$row36=number_format(sumMaleFormAP());
$row37=number_format(sumFemaleFormAP());
$row38=number_format(sumArgs('a_bysch','ap_trt_m','ap_trt_f','ap_ecd_f','ap_ecd_m'));
$row39=number_format(sumArgs('a_bysch','ap_ecd_f','ap_ecd_m'));
$row40=number_format(sumNonEnrolled6andover('SHISTO'));
$row41=number_format(sumNonEnrolledGender('ap_6','a_bysch'));
$row42=number_format(sumNonEnrolledGender('ap_11','a_bysch'));
$row43=number_format(sumNonEnrolledGender('ap_15','a_bysch'));
$row44=number_format(attntWithCriticalMaterials());
$row45=number_format(attntNoCriticalMaterials());
$row46=number_format(numFlexible('school_id','attnt_bysch','attnt_total_poles','1'));
$row47=number_format(numFlexible('school_id','attnt_bysch','attnt_total_drugs','1'));
$row48=$data;
$row49=$data;
$row50=$data;
$row51=$data;
$row52=$data;
$row53=$data;
$row54=$data;
$row55=$data;
$row56=$data;
$row57=$data;
$row58=$data;


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
			->setCellValue('A2','No. of districts covered for STH')
			->setCellValue('B2', $row1)
			->setCellValue('A3','No. of divisions covered for STH')
			->setCellValue('B3', $row2)
			->setCellValue('A4','No. of schools treated for STH')
			->setCellValue('B4', $row3)
			->setCellValue('A5','No. of schools targeted for STH')
			->setCellValue('B5', $row4)
			->setCellValue('A6','No. of public schools for STH')
			->setCellValue('B6', $row5)
			->setCellValue('A7','No. of private schools for STH')
			->setCellValue('B7', $row6)
			->setCellValue('A8','No. of other schools for STH')
			->setCellValue('B8', $row7)
			->setCellValue('A9','No. of no school type schools for STH')
			->setCellValue('B9', $row8)
			->setCellValue('A10','Estimated target population of STH')
			->setCellValue('B10', $row9)
			->setCellValue('A11','Estimated No. of Enrolled Primary School children for STH')
			->setCellValue('B11', $row10)
			->setCellValue('A12','Estimated No. of Enrolled ECD children for STH')
			->setCellValue('B12', $row11)
			->setCellValue('A13','Estimated No. of Stand-alone ECD children for STH')
			->setCellValue('B13', $row12)
			->setCellValue('A14','No. of ALB estimated for STH')
			->setCellValue('B14', $row13)
			->setCellValue('A15','No. of  children dewormed for STH once')
			->setCellValue('B15', $row14)
			->setCellValue('A16','No. of U5 children dewormed for STH')
			->setCellValue('B16', $row15)
			->setCellValue('A17','No. of Enrolled Primary School Aged children dewormed for STH')
			->setCellValue('B17', $row16)
			->setCellValue('A18','No. of Non-enrolled (age 6-18) children dewormed for STH')
			->setCellValue('B18', $row17)
			->setCellValue('A19','No. of Non-enrolled (age 6-10) children dewormed for STH')
			->setCellValue('B19', $row18)
			->setCellValue('A20','No. of Non-enrolled (age 11-14) children dewormed for STH')
			->setCellValue('B20', $row19)
			->setCellValue('A21','No. of Non-enrolled (age 15-18) children dewormed for STH')
			->setCellValue('B21', $row20)
			->setCellValue('A22','No. of Non Enrolled (age 2-5) children dewormed for STH')
			->setCellValue('B22', $row21)
			->setCellValue('A23','No. of ECD children dewormed for STH')
			->setCellValue('B23', $row22)
			->setCellValue('A24','No. of districts covered for Schisto')
			->setCellValue('B24', $row23)
			->setCellValue('A25','No. of schools covered for Schisto')
			->setCellValue('B25', $row24)
			->setCellValue('A26','No. of public schools for SCHISTO')
			->setCellValue('B26', $row25)
			->setCellValue('A27','No. of private schools for SCHISTO')
			->setCellValue('B27', $row26)
			->setCellValue('A28','No. of other schools for SCHISTO')
			->setCellValue('B28', $row27)
			->setCellValue('A29','No. of no school type schools for SCHISTO')
			->setCellValue('B29', $row28)
			->setCellValue('A30','No. of districts planned for SCHISTO')
			->setCellValue('B30', $row29)
			->setCellValue('A31','No. of schools planned (baseline) for SCHISTO')
			->setCellValue('B31', $row30)
			->setCellValue('A32','Estimated target population of Schisto')
			->setCellValue('B32', $row31)
			->setCellValue('A33','Estimated No. of Enrolled Primary School children for SCHISTO')
			->setCellValue('B33', $row32)
			->setCellValue('A34','Estimated No. of Enrolled ECD children for SCHISTO')
			->setCellValue('B34', $row33)
			->setCellValue('A35','Estimated No. of Stand-alone ECD children for SCHISTO')
			->setCellValue('B35', $row34)
			->setCellValue('A36','No. of children dewormed for Schisto once')
			->setCellValue('B36', $row35)
			->setCellValue('A37','No. of children dewormed for Schisto (Male)')
			->setCellValue('B37', $row36)
			->setCellValue('A38','No. of children dewormed for Schisto (Female)')
			->setCellValue('B38', $row37)
			->setCellValue('A39','No. of Enrolled Primary School Aged (including ECD) childrendewormed for Schisto')
			->setCellValue('B39', $row38)
			->setCellValue('A40','No. of ECD children dewormed for Schisto')
			->setCellValue('B40', $row39)
			->setCellValue('A41','No. of Non Enrolled (age 6-18) children dewormed for Schisto')
			->setCellValue('B41', $row40)
			->setCellValue('A42','No. of Non Enrolled (age 6-10) children dewormed for Schisto')
			->setCellValue('B42', $row41)
			->setCellValue('A43','No. of Non Enrolled (age 11-14) children dewormed for Schisto')
			->setCellValue('B43', $row42)
			->setCellValue('A44','No. of Non Enrolled (age 15-18) children dewormed for Schisto')
			->setCellValue('B44', $row43)
			->setCellValue('A45','No. of schools with critical materials present')
			->setCellValue('B45', $row44)
			->setCellValue('A46','No. of schools with no critical materials present')
			->setCellValue('B46', $row45)
			->setCellValue('A47','No. of schools with poles')
			->setCellValue('B47', $row46)
			->setCellValue('A48','No. of TTs with requiered drugs')
			->setCellValue('B48', $row47)
			->setCellValue('A49','No. TTs where funds are available')
			->setCellValue('B49', $row48)
			->setCellValue('A50','No. of Gok district personnel at regional training')
			->setCellValue('B50', $row49)
			->setCellValue('A51','No. of Gok divisional personnel at regional training')
			->setCellValue('B51', $row50)
			->setCellValue('A52','No. of tablets picked by DMHO - ALB')
			->setCellValue('B52', $row51)
			->setCellValue('A53','No. of tablets picked by DMHO - PZQ')
			->setCellValue('B53', $row52)
			->setCellValue('A54','No. of district returning form ATTNR')
			->setCellValue('B54', $row53)
			->setCellValue('A55','No. of district returning form ATTNT')
			->setCellValue('B55', $row54)
			->setCellValue('A56','No. of district returning form S')
			->setCellValue('B56', $row55)
			->setCellValue('A57','No. of district returning form A')
			->setCellValue('B57', $row56)
			->setCellValue('A58','No. of district returning form D')
			->setCellValue('B58', $row57)
			->setCellValue('A59','No. of district returning form Tabs')
			->setCellValue('B59', $row58);
 
 



           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('PROGRAM KPI');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="PROGRAM KPI.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
