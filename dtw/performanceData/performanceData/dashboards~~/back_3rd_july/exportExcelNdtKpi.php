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
include "queryFunctions.php";

$row1=number_format(numDistinctPlain('division_id','a_bysch'));
		$row2=number_format(num('school_id','a_bysch'));
		$row3=number_format(EstimatedTotalSTH());
		$row4=number_format(sumSTH());
		$row5=number_format(sumMaleFormA());
		$row6=number_format(sumFemaleFormA());
		$row7=number_format(sum6andOverFormA());
		$row8=number_format(sumUnder5());
		$row9=number_format(sumUnder5Male());
		$row10=number_format(sumUnder5Female());
		$row11=number_format(sumArgs('a_bysch','a_trt_m','a_trt_f'));
		$row12=number_format(sumPlain('a_trt_m','a_bysch')) ;
		$row13=number_format(sumPlain('a_trt_f','a_bysch')) ;
		$row14=number_format(sumNonEnrolled6andover('STH'));
		$row15=number_format(sumNonEnrolled6andoverMale('a_bysch'));
		$row16=number_format(sumNonEnrolled6andoverFemale('a_bysch'));
		$row17=number_format(sumNonEnrolledGender('a_6','a_bysch'));
		$row18=number_format(sumPlain('a_6_m','a_bysch'));
		$row19=number_format(sumPlain('a_6_f','a_bysch'));
		$row20=number_format(sumNonEnrolledGender('a_11','a_bysch')) ;
		$row21=number_format(sumPlain('a_11_m','a_bysch'));
		$row22=number_format(sumPlain('a_11_f','a_bysch'));
		$row23=number_format(sumNonEnrolledGender('a_15','a_bysch'));
		$row24=number_format(sumPlain('a_15_m','a_bysch'));
		$row25=number_format(sumPlain('a_15_f','a_bysch'));
		$row26=number_format(sumNonEnrolledGender('a_2','a_bysch'));
		$row27=number_format(sumPlain('a_2_m','a_bysch'));
		$row28=number_format(sumPlain('a_2_f','a_bysch'));
		$row29=number_format(sumArgs('a_bysch','a_ecd_m','a_ecd_f'));
		$row30=number_format(sumPlain('a_ecd_m','a_bysch'));
		$row31=number_format(sumPlain('a_ecd_f','a_bysch'));
		$row32=number_format(numDistinct('district_id','a_bysch','Yes'));
		$row33=number_format(numDistinct('division_id','a_bysch','Yes'));
		$row34=number_format(numDistinct('school_id','a_bysch','Yes'));
		$row35=number_format(EstimatedTotalSHISTO());
		$row36=number_format(sumSHISTO());
		$row37=number_format(sumMaleFormAP());
		$row38=number_format(sumFemaleFormAP());
		$row39=sumEnrolled('form_ap') ;
		$row40=sumEnrolledGenderSHISTO('male');
		$row41=sumEnrolledGenderSHISTO('male');
		$row42=number_format(sumPlain('ap_ecd_a','a_bysch'));
		$row43=number_format(sumPlain('ap_ecd_f','a_bysch'));
		$row44=number_format(sumNonEnrolled6andover('SHISTO'));
		$row45=number_format(sumNonEnrolled6andoverMale('SHISTO'));
		$row46=number_format(sumNonEnrolled6andoverFemale('SHISTO'));
		$row47=number_format(sumNonEnrolledGender('ap_6','a_bysch'));
		$row48=number_format(sumPlain('ap_6_m','a_bysch'));
		$row49=number_format(sumPlain('ap_6_f','a_bysch'));
		$row50=number_format(sumNonEnrolledGender('ap_11','a_bysch'));
		$row51=number_format(sumPlain('ap_11_m','a_bysch'));
		$row52=number_format(sumPlain('ap_11_f','a_bysch'));
		$row53=number_format(sumNonEnrolledGender('ap_15','a_bysch'));
		$row54=number_format(sumPlain('ap_15_m','a_bysch'));
		$row55=number_format(sumPlain('ap_15_f','a_bysch'));
		$row56=number_format(sumArgsByTreatment('a_bysch','Yes','a_trt_m','a_trt_f'));
		$row57=number_format(sumArgsByTreatment('a_bysch','Yes','a_trt_f','a_trt_m'));
		$row58=number_format(sum('a_trt_f','a_bysch','Yes'));
		$row59=number_format(sum('a_6_18_total','a_bysch','Yes'));
		$row60=number_format(sumNonEnrolled6andoverMaleByTreatment('shisto'));
		$row61=number_format(sum('a_6_18_f','a_bysch','Yes'));
		$row62=number_format(sumArgsByTreatment('a_bysch','Yes','a_6_m','a_6_f'));
		$row63=number_format(sum('a_6_m','a_bysch','Yes'));
		$row64=number_format(sum('a_6_f','a_bysch','Yes'));
		$row65=number_format(sumArgsByTreatment('a_bysch','Yes','a_11_m','a_11_f'));
		$row66=number_format(sum('a_11_m','a_bysch','Yes'));
		$row67=number_format(sum('a_11_f','a_bysch','Yes'));
		$row68=number_format(sumArgsByTreatment('a_bysch','Yes','a_15_m','a_15_f'));
		$row69=number_format(sum('a_15_m','a_bysch','Yes'));
		$row70=number_format(sum('a_15_f','a_bysch','Yes'));
		$row71=number_format(sumArgsByTreatment('a_bysch','Yes','a_2_m','a_2_f','a_ecd_m','a_ecd_f'));
		$row72=number_format(sum('a_u5_m','a_bysch','Yes'));
		$row73=number_format(sum('a_u5_f','a_bysch','Yes'));
		$row74=number_format(sumArgsByTreatment('a_bysch','Yes','a_2_m','a_2_m'));
		$row75=number_format(sum('a_2_m','a_bysch','Yes'));
		$row76=number_format(sum('a_2_f','a_bysch','Yes'));
		$row77=number_format(sumArgsByTreatment('a_bysch','Yes','a_ecd_m','a_ecd_f'));
		$row78=number_format(sum('a_ecd_m','a_bysch','Yes'));
		$row79=number_format(sum('a_ecd_f','a_bysch','Yes'));
		$row80=number_format(sumArgsByTreatment('a_bysch','No','a_trt_m','a_trt_f'));
		$row81=number_format(sum('a_trt_m','a_bysch','No'));
		$row82=number_format(sum('a_trt_f','a_bysch','No'));
		$row83=number_format(sumArgsByTreatment('a_bysch','No','a_6_f','a_6_m','a_11_f','a_11_m','a_15_f','a_15_m'));
		$row84=number_format(sumArgsByTreatment('a_bysch','No','a_6_m','a_11_m','a_15_m'));
		$row85=number_format(sumArgsByTreatment('a_bysch','No','a_6_f','a_11_f','a_15_f'));
		$row86=number_format(sumArgsByTreatment('a_bysch','No','a_6_m','a_6_f'));
		$row87=number_format(sum('a_6_m','a_bysch','No'));
		$row88=number_format(sum('a_6_f','a_bysch','No'));
		$row89=number_format(sumArgsByTreatment('a_bysch','No','a_11_m','a_11_f'));
		$row90=number_format(sum('a_11_m','a_bysch','No'));
		$row91=number_format(sum('a_11_f','a_bysch','No'));
		$row92=number_format(sumArgsByTreatment('a_bysch','No','a_15_m','a_15_f'));
		$row93=number_format(sum('a_15_m','a_bysch','No'));
		$row94=number_format(sum('a_15_f','a_bysch','No'));
		$row95=number_format(sumArgsByTreatment('a_bysch','No','a_ecd_m','a_2_m'));
		$row96=number_format(sumArgsByTreatment('a_bysch','No','a_ecd_f','a_2_f'));
		$row97=number_format(sumArgsByTreatment('a_bysch','No','a_2_f','a_2_m'));
		$row98=number_format(sum('a_2_m','a_bysch','No'));
		$row99=number_format(sum('a_2_f','a_bysch','No'));
		$row100=number_format(sumArgs('s_bysch','s_adult_treated1','s_adult_treated2','s_adult_treated3','s_adult_treated4','s_adult_treated5','s_adult_treated6','s_adult_treated7','s_adult_treated8','s_adult_treated9'));
		$row101=number_format(sumArgs('s_bysch','sp_adult_treated1','sp_adult_treated2','sp_adult_treated3','sp_adult_treated4','sp_adult_treated5','sp_adult_treated6','sp_adult_treated7','sp_adult_treated8','sp_adult_treated9'));


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
			->setCellValue('A2','No. of divisions covered for STH')
			->setCellValue('B2', $row1)
			->setCellValue('A3','No. of schools treated for STH')
			->setCellValue('B3', $row2)
			->setCellValue('A4','Estimated target population of STH')
			->setCellValue('B4', $row3)
			->setCellValue('A5','No. of  children dewormed for STH once')
			->setCellValue('B5', $row4)
			->setCellValue('A6','No. of children dewormed for STH (male)')
			->setCellValue('B6', $row5)
			->setCellValue('A7','No. of children dewormed for STH (female)')
			->setCellValue('B7', $row6)
			->setCellValue('A8','No. of children 6 and over receiving STH treatment')
			->setCellValue('B8', $row7)
			->setCellValue('A9','No. of U5 children dewormed for STH')
			->setCellValue('B9', $row8)
			->setCellValue('A10','No. of U5 children dewormed for STH (male)')
			->setCellValue('B10', $row9)
			->setCellValue('A11','No. of U5 children dewormed for STH (female)')
			->setCellValue('B11', $row10)
			->setCellValue('A12','No. of Enrolled Primary School Aged children dewormed for STH')
			->setCellValue('B12', $row11)
			->setCellValue('A13','No. of Enrolled Primary School Aged children dewormed for STH (male)')
			->setCellValue('B13', $row12)
			->setCellValue('A14','No. of Enrolled Primary School Aged children dewormed for STH (female)')
			->setCellValue('B14', $row13)
			->setCellValue('A15','No. of Non-enrolled (age 6-18) children dewormed for STH')
			->setCellValue('B15', $row14)
			->setCellValue('A16','No. of Non-enrolled (age 6-18) children dewormed for STH (male)')
			->setCellValue('B16', $row15)
			->setCellValue('A17','No. of Non-enrolled (age 6-18) children dewormed for STH (female)')
			->setCellValue('B17', $row16)
			->setCellValue('A18','No. of Non-enrolled (age 6-10) children dewormed for STH')
			->setCellValue('B18', $row17)
			->setCellValue('A19','No. of Non-enrolled (age 6-10) children dewormed for STH (male)')
			->setCellValue('B19', $row18)
			->setCellValue('A20','No. of Non-enrolled (age 6-10) children dewormed for STH (female)')
			->setCellValue('B20', $row19)
			->setCellValue('A21','No. of Non-enrolled (age 11-14) children dewormed for STH')
			->setCellValue('B21', $row20)
			->setCellValue('A22','No. of Non-enrolled (age 11-14) children dewormed for STH (male)')
			->setCellValue('B22', $row21)
			->setCellValue('A23','No. of Non-enrolled (age 11-14) children dewormed for STH (female)')
			->setCellValue('B23', $row22)
			->setCellValue('A24','No. of Non-enrolled (age 15-18) children dewormed for STH')
			->setCellValue('B24', $row23)
			->setCellValue('A25','No. of Non-enrolled (age 15-18) children dewormed for STH (male)')
			->setCellValue('B25', $row24)
			->setCellValue('A26','No. of Non-enrolled (age 15-18) children dewormed for STH (female)')
			->setCellValue('B26', $row25)
			->setCellValue('A27','No. of Non Enrolled (age 2-5) children dewormed for STH')
			->setCellValue('B27', $row26)
			->setCellValue('A28','No. of Non Enrolled (age 2-5) children dewormed for STH (male)')
			->setCellValue('B28', $row27)
			->setCellValue('A29','No. of Non Enrolled (age 2-5) children dewormed for STH (female)')
			->setCellValue('B29', $row28)
			->setCellValue('A30','No. of ECD children dewormed for STH')
			->setCellValue('B30', $row29)
			->setCellValue('A31','No. of ECD children dewormed for STH (male)')
			->setCellValue('B31', $row30)
			->setCellValue('A32','No. of ECD children dewormed for STH (female)')
			->setCellValue('B32', $row31)
			->setCellValue('A33','No. of districts covered for Schisto')
			->setCellValue('B33', $row32)
			->setCellValue('A34','No. of divisions covered for Schisto')
			->setCellValue('B34', $row33)
			->setCellValue('A35','No. of schools covered for Schisto')
			->setCellValue('B35', $row34)
			->setCellValue('A36','Estimated target population of Schisto')
			->setCellValue('B36', $row35)
			->setCellValue('A37','No. of children dewormed for Schisto once')
			->setCellValue('B37', $row36)
			->setCellValue('A38','No. of children dewormed for Schisto (Male)')
			->setCellValue('B38', $row37)
			->setCellValue('A39','No. of children dewormed for Schisto (Female)')
			->setCellValue('B39', $row38)
			->setCellValue('A40','No. of Enrolled Primary School Aged (including EC) children dewormed for Schisto')
			->setCellValue('B40', $row39)
			->setCellValue('A41','No. of Enrolled Primary School Aged (including EC) children dewormed for Schisto (Male)')
			->setCellValue('B41', $row40)
			->setCellValue('A42','No. of Enrolled Primary School Aged (including EC) children dewormed for Schisto (Female)')
			->setCellValue('B42', $row41)
			->setCellValue('A43','No. of ECD children dewormed for Schisto')
			->setCellValue('B43', $row42)
			->setCellValue('A44','No. of ECD children dewormed for Schisto (Female)')
			->setCellValue('B44', $row43)
			->setCellValue('A45','No. of Non Enrolled (age 6-18) children dewormed for Schisto')
			->setCellValue('B45', $row44)
			->setCellValue('A46','No. of Non Enrolled (age 6-18) children dewormed for Schisto (Male)')
			->setCellValue('B46', $row45)
			->setCellValue('A47','No. of Non Enrolled (age 6-18) children dewormed for Schisto (Female)')
			->setCellValue('B47', $row46)
			->setCellValue('A48','No. of Non Enrolled (age 6-10) children dewormed for Schisto')
			->setCellValue('B48', $row47)
			->setCellValue('A49','No. of Non Enrolled (age 6-10) children dewormed for Schisto (Male)')
			->setCellValue('B49', $row48)
			->setCellValue('A50','No. of Non Enrolled (age 6-10) children dewormed for Schisto (Female)')
			->setCellValue('B50', $row49)
			->setCellValue('A51','No. of Non Enrolled (age 11-14) children dewormed for Schisto')
			->setCellValue('B51', $row50)
			->setCellValue('A52','No. of Non Enrolled (age 11-14) children dewormed for Schisto (Male)')
			->setCellValue('B52', $row51)
			->setCellValue('A53','No. of Non Enrolled (age 11-14) children dewormed for Schisto (Female)')
			->setCellValue('B53', $row52)
			->setCellValue('A54','No. of Non Enrolled (age 15-18) children dewormed for Schisto')
			->setCellValue('B54', $row53)
			->setCellValue('A55','No. of Non Enrolled (age 15-18) children dewormed for Schisto (Male)')
			->setCellValue('B55', $row54)
			->setCellValue('A56','No. of Non Enrolled (age 15-18) children dewormed for Schisto (Female)')
			->setCellValue('B56', $row55)
			->setCellValue('A57','No. of Enrolled Primary School Aged children dewormed for STH in Schisto School')
			->setCellValue('B57', $row56)
			->setCellValue('A58','No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Male)')
			->setCellValue('B58', $row57)
			->setCellValue('A59','No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Female)')
			->setCellValue('B59', $row58)
			->setCellValue('A60','No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School')
			->setCellValue('B60', $row59)
			->setCellValue('A61','No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Male)')
			->setCellValue('B61',  $row60)
			->setCellValue('A62','No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Female)')
			->setCellValue('B62', $row61)
			->setCellValue('A63','No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School')
			->setCellValue('B63', $row62)
			->setCellValue('A64','No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Male)')
			->setCellValue('B64', $row63)
			->setCellValue('A65','No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Female)')
			->setCellValue('B65', $row64)
			->setCellValue('A66','No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School')
			->setCellValue('B66', $row65)
			->setCellValue('A67','No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Male)')
			->setCellValue('B67', $row66)
			->setCellValue('A68','No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Female)')
			->setCellValue('B68', $row67)
			->setCellValue('A69','No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School')
			->setCellValue('B69', $row68)
			->setCellValue('A70','No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Male)')
			->setCellValue('B70', $row69)
			->setCellValue('A71','No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Female)')
			->setCellValue('B71', $row70)
			->setCellValue('A72','No. of U5 children dewormed for STH in Schisto School')
			->setCellValue('B72', $row71)
			->setCellValue('A73','No. of U5 children dewormed for STH in Schisto School(Male)')
			->setCellValue('B73', $row72)
			->setCellValue('A74','No. of U5 children dewormed for STH in Schisto School(Female)')
			->setCellValue('B74', $row73)
			->setCellValue('A75','No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School')
			->setCellValue('B75', $row74)
			->setCellValue('A76','No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Male)')
			->setCellValue('B76', $row75)
			->setCellValue('A77','No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Female)')
			->setCellValue('B77', $row76)
			->setCellValue('A78','No. of ECD children dewormed for STH in Schisto School')
			->setCellValue('B78', $row77)
			->setCellValue('A79','No. of ECD children dewormed for STH in Schisto School (Male)')
			->setCellValue('B79', $row78)
			->setCellValue('A80','No. of ECD children dewormed for STH in Schisto School (Female)')
			->setCellValue('B80', $row79)
			->setCellValue('A81','No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School')
			->setCellValue('B81', $row80)
			->setCellValue('A82','No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Male)')
			->setCellValue('B82', $row81)
			->setCellValue('A83','No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Female)')
			->setCellValue('B83', $row82)
			->setCellValue('A84','No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School')
			->setCellValue('B84', $row83)
			->setCellValue('A85','No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Male)')
			->setCellValue('B85', $row84)
			->setCellValue('A86','No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Female)')
			->setCellValue('B86', $row85)
			->setCellValue('A87','No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School')
			->setCellValue('B87', $row86)
			->setCellValue('A88','No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Male)')
			->setCellValue('B88', $row87)
			->setCellValue('A89','No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Female)')
			->setCellValue('B89', $row88)
			->setCellValue('A90','No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School')
			->setCellValue('B90', $row89)
			->setCellValue('A91','No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Male)')
			->setCellValue('B91', $row90)
			->setCellValue('A92','No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Female)')
			->setCellValue('B92', $row91)
			->setCellValue('A93','No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School')
			->setCellValue('B93', $row92)
			->setCellValue('A94','No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Male)')
			->setCellValue('B94', $row93)
			->setCellValue('A95','No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Female)')
			->setCellValue('B95', $row94)
			->setCellValue('A96','No. of U5 children dewormed for STH in non-Schisto School(Male)')
			->setCellValue('B96', $row95)
			->setCellValue('A97','No. of U5 children dewormed for STH in non-Schisto School(Female)')
			->setCellValue('B97', $row96)
			->setCellValue('A98','No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School')
			->setCellValue('B98', $row97)
			->setCellValue('A99','No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Male)')
			->setCellValue('B99', $row98)
			->setCellValue('A100','No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Female)')
			->setCellValue('B100', $row99)
			->setCellValue('A101','No. of Adult Treated for STH')
			->setCellValue('B101', $row100)
			->setCellValue('A102','No. of Adult Treated for Schisto')
			->setCellValue('B102', $row101);









           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('NDT KPI');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="NDT KPI.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
