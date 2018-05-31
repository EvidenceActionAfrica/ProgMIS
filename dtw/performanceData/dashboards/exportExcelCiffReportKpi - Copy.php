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


$placeholder ="N/A";
$path="../../";
include $path."includes/config.php";
include "queryFunctions.php";

$row1=number_format(numDistinctPlain('district_id','a_bysch'));
$row2=number_format(numDistinctPlain('division_id','a_bysch'));
$row3=number_format(num('school_id','a_bysch'));
$row4=number_format(num('p_sch_id','p_bysch'));
$row5=number_format(numFlexible('s_prog_sch_id','s_bysch','s1_school_type','Public'));
$row6=number_format(numFlexible('s_prog_sch_id','s_bysch','s1_school_type','Private'));
$row7=number_format(numFlexible('s_prog_sch_id','s_bysch','s1_school_type','Other'));
$row8=number_format(numFlexible('s_prog_sch_id','s_bysch','s1_school_type','None'));
$row9=$placeholder;
$row10=number_format(EstimatedTotalSTH());
$row11=number_format(sumPlain('p_pri_enroll','p_bysch'));
$row12=number_format(sumPlain('p_ecd_enroll','p_bysch'));
$row13=number_format(sumPlain('p_ecd_sa_enroll','p_bysch'));
$row14=number_format(sumPlain('p_alb','p_bysch'));
$row15=number_format(sumSTH());
$row16=number_format(sumMaleFormA());
$row17=number_format(sumFemaleFormA());
$row18=number_format(sum6andOverFormA());
$row19=number_format(sumUnder5());
$row20=number_format(sumUnder5Male());
$row21=number_format(sumUnder5Female());
$row22=number_format(sumArgs('a_bysch','a_trt_m','a_trt_f'));
$row23=number_format(sumPlain('a_trt_m','a_bysch'));
$row24=number_format(sumPlain('a_trt_f','a_bysch'));
$row25=number_format(sumNonEnrolled6andover('STH'));
$row26=number_format(sumNonEnrolled6andoverMale('STH'));
$row27=number_format(sumNonEnrolled6andoverFemale('STH'));
$row28=number_format(sumNonEnrolledGender('a_6','a_bysch'));
$row29=number_format(sumPlain('a_6_m','a_bysch'));
$row30=number_format(sumPlain('a_6_f','a_bysch'));
$row31=number_format(sumNonEnrolledGender('a_11','a_bysch'));
$row32=number_format(sumPlain('a_11_m','a_bysch'));
$row33=number_format(sumPlain('a_11_f','a_bysch'));
$row34=number_format(sumNonEnrolledGender('a_15','a_bysch'));
$row35=number_format(sumPlain('a_15_m','a_bysch'));
$row36=number_format(sumPlain('a_15_f','a_bysch'));
$row37=number_format(sumNonEnrolledGender('a_2','a_bysch'));
$row38=number_format(sumPlain('a_2_m','a_bysch'));
$row39=number_format(sumPlain('a_2_f','a_bysch'));
$row40=number_format(sumArgs('a_bysch','a_ecd_m','a_ecd_f'));
$row41=number_format(sumPlain('a_ecd_m','a_bysch'));
$row42=number_format(sumPlain('a_ecd_f','a_bysch'));
$row43=number_format(numDistinct('district_id','a_bysch','Yes'));
$row44=number_format(numDistinct('division_id','a_bysch','Yes'));
$row45=number_format(numDistinct('school_id','a_bysch','Yes'));
$row46=number_format(numSchoolTypeS('Public','Yes'));
$row47=number_format(numSchoolTypeS('Private','Yes'));
$row48=number_format(numSchoolTypeS('Other','Yes'));
$row49=number_format(numSchoolTypeS('Not specified','Yes'));
$row50=number_format(numDistinctP('district_id','Y'));
$row51=number_format(numDistinctP('p_sch_id','Y'));
$row52=number_format(EstimatedTotalSHISTO());
$row53=number_format(sumEstimated('p_pri_enroll','Y'));
$row54=number_format(sumEstimated('p_ecd_enroll','Y'));
$row55=number_format(sumEstimated('p_ecd_sa_enroll','Y'));
$row56=number_format(sumSHISTO());
$row57=number_format(sumMaleFormAP());
$row58=number_format(sumFemaleFormAP());
$row59=number_format(sumArgs('a_bysch','ap_trt_m','ap_trt_f','ap_ecd_f','ap_ecd_m'));
$row60=number_format(sumArgs('a_bysch','ap_trt_m','ap_ecd_m'));
$row61=number_format(sumArgs('a_bysch','ap_trt_f','ap_ecd_f'));
$row62=number_format(sumArgs('a_bysch','ap_ecd_f','ap_ecd_m'));
$row63=number_format(sumNonEnrolled6andover('SHISTO'));
$row64=number_format(sumNonEnrolled6andoverMale('SHISTO'));
$row65=number_format(sumNonEnrolled6andoverFemale('SHISTO'));
$row66=number_format(sumNonEnrolledGender('ap_6','a_bysch'));
$row67=number_format(sumPlain('ap_6_m','a_bysch'));
$row68=number_format(sumPlain('ap_6_f','a_bysch'));
$row69=number_format(sumNonEnrolledGender('ap_11','a_bysch'));
$row70=number_format(sumPlain('ap_11_m','a_bysch'));
$row71=number_format(sumPlain('ap_11_f','a_bysch'));
$row72=number_format(sumNonEnrolledGender('ap_15','a_bysch'));
$row73=number_format(sumPlain('ap_15_m','a_bysch'));
$row74=number_format(sumPlain('ap_15_f','a_bysch'));
$row75=number_format(sumArgsByTreatment('a_bysch','Yes','a_trt_m','a_trt_f'));
$row76=number_format(sumArgsByTreatment('a_bysch','Yes','a_trt_f','a_trt_m'));
$row77=number_format(sum('a_trt_f','a_bysch','Yes'));
$row78=number_format(sumNonEnrolled6andoverByTreatment('STH'));
$row79=number_format(sumNonEnrolled6andoverMaleByTreatment('shisto'));
$row80=number_format(sumNonEnrolled6andoverFemaleShistoSchool('SHISTO','Yes'));
$row81=number_format(sumArgsByTreatment('a_bysch','Yes','a_6_m','a_6_f'));
$row82=number_format(sum('a_6_m','a_bysch','Yes'));
$row83=number_format(sum('a_6_f','a_bysch','Yes'));
$row84=number_format(sumArgsByTreatment('a_bysch','Yes','a_11_m','a_11_f'));
$row85=number_format(sum('a_11_m','a_bysch','Yes'));
$row86=number_format(sum('a_11_f','a_bysch','Yes'));
$row87=number_format(sumArgsByTreatment('a_bysch','Yes','a_15_m','a_15_f'));
$row88=number_format(sum('a_15_m','a_bysch','Yes'));
$row89=number_format(sum('a_15_f','a_bysch','Yes'));
$row90=number_format(sumArgsByTreatment('a_bysch','Yes','a_2_m','a_2_f','a_ecd_m','a_ecd_f'));
$row91=number_format(sumArgsByTreatment('a_bysch','Yes','a_2_m','a_ecd_m'));
$row92=number_format(sumArgsByTreatment('a_bysch','Yes','a_2_f','a_ecd_f'));
$row93=number_format(sumArgsByTreatment('a_bysch','Yes','a_2_m','a_2_m'));
$row94=number_format(sum('a_2_m','a_bysch','Yes'));
$row95=number_format(sum('a_2_f','a_bysch','Yes'));
$row96=number_format(sumArgsByTreatment('a_bysch','Yes','a_ecd_m','a_ecd_f'));
$row97=number_format(sum('a_ecd_m','a_bysch','Yes'));
$row98=number_format(sum('a_ecd_f','a_bysch','Yes'));
$row99=number_format(sumArgsByTreatment('a_bysch','No','a_trt_m','a_trt_f'));
$row100=number_format(sum('a_trt_m','a_bysch','No'));
$row101=number_format(sum('a_trt_f','a_bysch','No'));
$row102=number_format(sumArgsByTreatment('a_bysch','No','a_6_f','a_6_m','a_11_f','a_11_m','a_15_f','a_15_m'));
$row103=number_format(sumArgsByTreatment('a_bysch','No','a_6_m','a_11_m','a_15_m'));
$row104=number_format(sumArgsByTreatment('a_bysch','No','a_6_f','a_11_f','a_15_f'));
$row105=number_format(sumArgsByTreatment('a_bysch','No','a_6_m','a_6_f'));
$row106=number_format(sum('a_6_m','a_bysch','No'));
$row107=number_format(sum('a_6_f','a_bysch','No'));
$row108=number_format(sumArgsByTreatment('a_bysch','No','a_11_m','a_11_f'));
$row109=number_format(sum('a_11_m','a_bysch','No'));
$row110=number_format(sum('a_11_f','a_bysch','No'));
$row111=number_format(sumArgsByTreatment('a_bysch','No','a_15_m','a_15_f'));
$row112=number_format(sum('a_15_m','a_bysch','No'));
$row113=number_format(sum('a_15_f','a_bysch','No'));
$row114=number_format(sumArgsByTreatment('a_bysch','No','a_ecd_m','a_ecd_f','a_2_f','a_2_m'));
$row115=number_format(sumArgsByTreatment('a_bysch','No','a_ecd_m','a_2_m'));
$row116=number_format(sumArgsByTreatment('a_bysch','No','a_ecd_f','a_2_f'));
$row117=number_format(sumArgsByTreatment('a_bysch','No','a_2_m','a_2_f'));
$row118=number_format(sum('a_2_m','a_bysch','No'));
$row119=number_format(sum('a_2_f','a_bysch','No'));
$row120=number_format(sumArgsByTreatment('a_bysch','No','a_ecd_m','a_ecd_f'));
$row121=number_format(sum('a_ecd_m','a_bysch','No'));
$row122=number_format(sum('a_ecd_f','a_bysch','No'));
$row123=$placeholder;
$row124=number_format(num('school_id','attnt_bysch'));
$row125=number_format(attntWithCriticalMaterials());
$row126=number_format(attntNoCriticalMaterials());
$row127=number_format(numFlexible('attnt_id','attnt_bysch','attnt_total_drugs','1'));
$row128=$placeholder;
$row129=$placeholder;
$row130=$placeholder;



/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once $path.'PHPExcel/Classes/PHPExcel.php';


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
			->setCellValue('A2', "No. of districts covered for STH")
		->setCellValue('B2', $row1)
		->setCellValue('A3', "No. of divisions covered for STH")
		->setCellValue('B3', $row2)
		->setCellValue('A4', "No. of schools treated for STH")
		->setCellValue('B4', $row3)
		->setCellValue('A5', "No. of schools targeted for STH")
		->setCellValue('B5', $row4)
		->setCellValue('A6', "No. of public schools for STH")
		->setCellValue('B6', $row5)
		->setCellValue('A7', "No. of private schools for STH")
		->setCellValue('B7', $row6)
		->setCellValue('A8', "No. of 'other' schools for STH")
		->setCellValue('B8', $row7)
		->setCellValue('A9', "No. of 'no school type' schools for STH")
		->setCellValue('B9', $row8)
		->setCellValue('A10', "No. of schools  reporting to deworming on designated county deworming day")
		->setCellValue('B10', $row9)
		->setCellValue('A11', "Estimated target population of STH")
		->setCellValue('B11', $row10)
		->setCellValue('A12', "Estimated No. of 'Enrolled Primary School' children for STH")
		->setCellValue('B12', $row11)
		->setCellValue('A13', "Estimated No. of 'Enrolled ECD' children for STH")
		->setCellValue('B13', $row12)
		->setCellValue('A14', "Estimated No. of 'Stand-alone ECD' children for STH")
		->setCellValue('B14', $row13)
		->setCellValue('A15', "No. of ALB estimated for STH")
		->setCellValue('B15', $row14)
		->setCellValue('A16', "No. of  children dewormed for STH once")
		->setCellValue('B16', $row15)
		->setCellValue('A17', "No. of children dewormed for STH (male)")
		->setCellValue('B17', $row16)
		->setCellValue('A18', "No. of children dewormed for STH (female)")
		->setCellValue('B18', $row17)
		->setCellValue('A19', "No. of children 6 and over receiving STH treatment")
		->setCellValue('B19', $row18)
		->setCellValue('A20', "No. of U5 children dewormed for STH")
		->setCellValue('B20', $row19)
		->setCellValue('A21', "No. of U5 children dewormed for STH (male)")
		->setCellValue('B21', $row20)
		->setCellValue('A22', "No. of U5 children dewormed for STH (female)")
		->setCellValue('B22', $row21)
		->setCellValue('A23', "No. of Enrolled Primary School Aged children dewormed for STH")
		->setCellValue('B23', $row22)
		->setCellValue('A24', "No. of Enrolled Primary School Aged children dewormed for STH (male)")
		->setCellValue('B24', $row23)
		->setCellValue('A25', "No. of Enrolled Primary School Aged children dewormed for STH (female)")
		->setCellValue('B25', $row24)
		->setCellValue('A26', "No. of Non-enrolled (age 6-18) children dewormed for STH")
		->setCellValue('B26', $row25)
		->setCellValue('A27', "No. of Non-enrolled (age 6-18) children dewormed for STH (male)")
		->setCellValue('B27', $row26)
		->setCellValue('A28', "No. of Non-enrolled (age 6-18) children dewormed for STH (female)")
		->setCellValue('B28', $row27)
		->setCellValue('A29', "No. of Non-enrolled (age 6-10) children dewormed for STH")
		->setCellValue('B29', $row28)
		->setCellValue('A30', "No. of Non-enrolled (age 6-10) children dewormed for STH (male)")
		->setCellValue('B30', $row29)
		->setCellValue('A31', "No. of Non-enrolled (age 6-10) children dewormed for STH (female)")
		->setCellValue('B31', $row30)
		->setCellValue('A32', "No. of Non-enrolled (age 11-14) children dewormed for STH")
		->setCellValue('B32', $row31)
		->setCellValue('A33', "No. of Non-enrolled (age 11-14) children dewormed for STH (male)")
		->setCellValue('B33', $row32)
		->setCellValue('A34', "No. of Non-enrolled (age 11-14) children dewormed for STH (female)")
		->setCellValue('B34', $row33)
		->setCellValue('A35', "No. of Non-enrolled (age 15-18) children dewormed for STH")
		->setCellValue('B35', $row34)
		->setCellValue('A36', "No. of Non-enrolled (age 15-18) children dewormed for STH (male)")
		->setCellValue('B36', $row35)
		->setCellValue('A37', "No. of Non-enrolled (age 15-18) children dewormed for STH (female)")
		->setCellValue('B37', $row36)
		->setCellValue('A38', "No. of Non Enrolled (age 2-5) children dewormed for STH")
		->setCellValue('B38', $row37)
		->setCellValue('A39', "No. of Non Enrolled (age 2-5) children dewormed for STH (male)")
		->setCellValue('B39', $row38)
		->setCellValue('A40', "No. of Non Enrolled (age 2-5) children dewormed for STH (female)")
		->setCellValue('B40', $row39)
		->setCellValue('A41', "No. of ECD children dewormed for STH")
		->setCellValue('B41', $row40)
		->setCellValue('A42', "No. of ECD children dewormed for STH (male)")
		->setCellValue('B42', $row41)
		->setCellValue('A43', "No. of ECD children dewormed for STH (female)")
		->setCellValue('B43', $row42)
		->setCellValue('A44', "No. of districts covered for Schisto")
		->setCellValue('B44', $row43)
		->setCellValue('A45', "No. of divisions covered for Schisto")
		->setCellValue('B45', $row44)
		->setCellValue('A46', "No. of schools covered for Schisto")
		->setCellValue('B46', $row45)
		->setCellValue('A47', "No. of public schools for SCHISTO")
		->setCellValue('B47', $row46)
		->setCellValue('A48', "No. of private schools for SCHISTO")
		->setCellValue('B48', $row47)
		->setCellValue('A49', "No. of 'other' schools for SCHISTO")
		->setCellValue('B49', $row48)
		->setCellValue('A50', "No. of 'no school type' schools for SCHISTO")
		->setCellValue('B50', $row49)
		->setCellValue('A51', "No. of districts planned for SCHISTO")
		->setCellValue('B51', $row50)
		->setCellValue('A52', "No. of schools planned (baseline) for SCHISTO")
		->setCellValue('B52', $row51)
		->setCellValue('A53', "Estimated target population of Schisto")
		->setCellValue('B53', $row52)
		->setCellValue('A54', "Estimated No. of 'Enrolled Primary School' children for SCHISTO")
		->setCellValue('B54', $row53)
		->setCellValue('A55', "Estimated No. of 'Enrolled ECD' children for SCHISTO")
		->setCellValue('B55', $row54)
		->setCellValue('A56', "Estimated No. of 'Stand-alone ECD' children for SCHISTO")
		->setCellValue('B56', $row55)
		->setCellValue('A57', "No. of children dewormed for Schisto once")
		->setCellValue('B57', $row56)
		->setCellValue('A58', "No. of children dewormed for Schisto (Male)")
		->setCellValue('B58', $row57)
		->setCellValue('A59', "No. of children dewormed for Schisto (Female)")
		->setCellValue('B59', $row58)
		->setCellValue('A60', "No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto")
		->setCellValue('B60', $row59)
		->setCellValue('A61', "No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto (Male)")
		->setCellValue('B61', $row60)
		->setCellValue('A62', "No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto (Female)")
		->setCellValue('B62', $row61)
		->setCellValue('A63', "No. of ECD children dewormed for Schisto")
		->setCellValue('B63', $row62)
		->setCellValue('A64', "No. of Non Enrolled (age 6-18) children dewormed for Schisto")
		->setCellValue('B64', $row63)
		->setCellValue('A65', "No. of Non Enrolled (age 6-18) children dewormed for Schisto (Male)")
		->setCellValue('B65', $row64)
		->setCellValue('A66', "No. of Non Enrolled (age 6-18) children dewormed for Schisto (Female)")
		->setCellValue('B66', $row65)
		->setCellValue('A67', "No. of Non Enrolled (age 6-10) children dewormed for Schisto")
		->setCellValue('B67', $row66)
		->setCellValue('A68', "No. of Non Enrolled (age 6-10) children dewormed for Schisto (Male)")
		->setCellValue('B68', $row67)
		->setCellValue('A69', "No. of Non Enrolled (age 6-10) children dewormed for Schisto (Female)")
		->setCellValue('B69', $row68)
		->setCellValue('A70', "No. of Non Enrolled (age 11-14) children dewormed for Schisto")
		->setCellValue('B70', $row69)
		->setCellValue('A71', "No. of Non Enrolled (age 11-14) children dewormed for Schisto (Male)")
		->setCellValue('B71', $row70)
		->setCellValue('A72', "No. of Non Enrolled (age 11-14) children dewormed for Schisto (Female)")
		->setCellValue('B72', $row71)
		->setCellValue('A73', "No. of Non Enrolled (age 15-18) children dewormed for Schisto")
		->setCellValue('B73', $row72)
		->setCellValue('A74', "No. of Non Enrolled (age 15-18) children dewormed for Schisto (Male)")
		->setCellValue('B74', $row73)
		->setCellValue('A75', "No. of Non Enrolled (age 15-18) children dewormed for Schisto (Female)")
		->setCellValue('B75', $row74)
		->setCellValue('A76', "No. of Enrolled Primary School Aged children dewormed for STH in Schisto School")
		->setCellValue('B76', $row75)
		->setCellValue('A77', "No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Male)")
		->setCellValue('B77', $row76)
		->setCellValue('A78', "No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Female)")
		->setCellValue('B78', $row77)
		->setCellValue('A79', "No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School")
		->setCellValue('B79', $row78)
		->setCellValue('A80', "No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Male)")
		->setCellValue('B80', $row79)
		->setCellValue('A81', "No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Female)")
		->setCellValue('B81', $row80)
		->setCellValue('A82', "No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School")
		->setCellValue('B82', $row81)
		->setCellValue('A83', "No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Male)")
		->setCellValue('B83', $row82)
		->setCellValue('A84', "No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Female)")
		->setCellValue('B84', $row83)
		->setCellValue('A85', "No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School")
		->setCellValue('B85', $row84)
		->setCellValue('A86', "No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Male)")
		->setCellValue('B86', $row85)
		->setCellValue('A87', "No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Female)")
		->setCellValue('B87', $row86)
		->setCellValue('A88', "No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School")
		->setCellValue('B88', $row87)
		->setCellValue('A89', "No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Male)")
		->setCellValue('B89', $row88)
		->setCellValue('A90', "No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Female)")
		->setCellValue('B90', $row89)
		->setCellValue('A91', "No. of U5 children dewormed for STH in Schisto School")
		->setCellValue('B91', $row90)
		->setCellValue('A92', "No. of U5 children dewormed for STH in Schisto School(Male)")
		->setCellValue('B92', $row91)
		->setCellValue('A93', "No. of U5 children dewormed for STH in Schisto School(Female)")
		->setCellValue('B93', $row92)
		->setCellValue('A94', "No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School")
		->setCellValue('B94', $row93)
		->setCellValue('A95', "No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Male)")
		->setCellValue('B95', $row94)
		->setCellValue('A96', "No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Female)")
		->setCellValue('B96', $row95)
		->setCellValue('A97', "No. of ECD children dewormed for STH in Schisto School")
		->setCellValue('B97', $row96)
		->setCellValue('A98', "No. of ECD children dewormed for STH in Schisto School (Male)")
		->setCellValue('B98', $row97)
		->setCellValue('A99', "No. of ECD children dewormed for STH in Schisto School (Female)")
		->setCellValue('B99', $row98)
		->setCellValue('A100', "No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School")
		->setCellValue('B100', $row99)
		->setCellValue('A101', "No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Male)")
		->setCellValue('B101', $row100)
		->setCellValue('A102', "No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Female)")
		->setCellValue('B102', $row101)
		->setCellValue('A103', "No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School")
		->setCellValue('B103', $row102)
		->setCellValue('A104', "No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Male)")
		->setCellValue('B104', $row103)
		->setCellValue('A105', "No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Female)")
		->setCellValue('B105', $row104)
		->setCellValue('A106', "No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School")
		->setCellValue('B106', $row105)
		->setCellValue('A107', "No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Male)")
		->setCellValue('B107', $row106)
		->setCellValue('A108', "No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Female)")
		->setCellValue('B108', $row107)
		->setCellValue('A109', "No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School")
		->setCellValue('B109', $row108)
		->setCellValue('A110', "No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Male)")
		->setCellValue('B110', $row109)
		->setCellValue('A111', "No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Female)")
		->setCellValue('B111', $row110)
		->setCellValue('A112', "No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School")
		->setCellValue('B112', $row111)
		->setCellValue('A113', "No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Male)")
		->setCellValue('B113', $row112)
		->setCellValue('A114', "No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Female)")
		->setCellValue('B114', $row113)
		->setCellValue('A115', "No. of U5 children dewormed for STH in non-Schisto School")
		->setCellValue('B115', $row114)
		->setCellValue('A116', "No. of U5 children dewormed for STH in non-Schisto School(Male)")
		->setCellValue('B116', $row115)
		->setCellValue('A117', "No. of U5 children dewormed for STH in non-Schisto School(Female)")
		->setCellValue('B117', $row116)
		->setCellValue('A118', "No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School")
		->setCellValue('B118', $row117)
		->setCellValue('A119', "No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Male)")
		->setCellValue('B119', $row118)
		->setCellValue('A120', "No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Female)")
		->setCellValue('B120', $row119)
		->setCellValue('A121', "No. of ECD children dewormed for STH in non-Schisto School")
		->setCellValue('B121', $row120)
		->setCellValue('A122', "No. of ECD children dewormed for STH in non-Schisto School (Male)")
		->setCellValue('B122', $row121)
		->setCellValue('A123', "No. of ECD children dewormed for STH in non-Schisto School (Female)")
		->setCellValue('B123', $row122)
		->setCellValue('A124', "No. target schools attending teacher training sessions")
		->setCellValue('b124', $row123)
		->setCellValue('A125', "No. of schools attending teacher training")
		->setCellValue('B125', $row124)
		->setCellValue('A126', "No. of schools with critical materials present")
		->setCellValue('B126', $row125)
		->setCellValue('A127', "No. of schools with no critical materials present")
		->setCellValue('B127', $row126)
		->setCellValue('A128', "No. of TTs with requiered drugs")
		->setCellValue('B128', $row127)
		->setCellValue('A129', "% Districts submitting forms S,A,and D to National level within three months of deworming day")
		->setCellValue('B129', $row128)
		->setCellValue('A130', "% divisions correctly (+/- 10%) reporting on school level coverage of total children dewormed.")
		->setCellValue('B130', $row129)
		->setCellValue('A131', "% districts correctly (+/- 10%) reporting on school-level coverage of total children dewormed.")
		->setCellValue('B131', $row130);


           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('DashBoard Attnt');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Ciff REPORT KPI.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
