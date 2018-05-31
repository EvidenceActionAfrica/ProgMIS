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

// include "dashFormSFunctions.php";
include "queryFunctions.php";

$row1=numDistinctPlain('s_district_id','s_bysch');
$row2=numDistinctPlain('s_prog_sch_id','s_bysch');
$row3=sumDewormedPlusAudultsSbysch('STH');
$row4=sumChildrenSbysch('STH');
$row5=number_format(childAverage('s_bysch','s_district_id'),2, '.', '');
$row6=$data;
$row7=$data;
$row8=number_format(addValues(sumArgs('s_bysch','s_ecd_treated_male','s_ecd_treated_male'),sumPriEnrolledSbysch('STH'))) ;
$row9=number_format(sumArgs('s_bysch','s_ecd_treated_male','s_ecd_treated_male'));
$row10=number_format(sumPlain('s_ecd_treated_male','s_bysch'));
$row11=number_format(sumPlain('s_ecd_treated_female','s_bysch'));
$row12=number_format(sumPriChildrenSbysch('STH'));
$row13=number_format(sumMaleAbove6Sbysch('STH'));
$row14=number_format(sumFemaleAbove6Sbysch('STH'));
$row15=number_format(sumPriRegisteredSbysch('STH'));
$row16=number_format(sumPriGenderRegisteredSbysch('male'));
$row17=number_format(sumPriGenderRegisteredSbysch('female'));
$row18=number_format(sumNonEnrolledSbysch('STH'));
$row19=number_format(sumArgs('s_bysch','s_nonenroll_2_5yrs_m','s_nonenroll_2_5yrs_f'));
$row20=number_format(sumPlain('s_nonenroll_2_5yrs_m','s_bysch'));
$row21=number_format(sumPlain('s_nonenroll_2_5yrs_f','s_bysch'));
$row22=number_format(sumPriChildrenSbysch('STH'));
$row23=number_format(sumMaleAbove6Sbysch('STH'));
$row24=number_format(sumFemaleAbove6Sbysch('STH'));
$row25=number_format(sumAdultsFormS('STH'));
$row26=number_format(sumTabletsSpoilt('STH'));
$row27=number_format(sumPlain('s_alb_received','s_bysch'));
$row28=number_format(sumPlain('s_alb_use','s_bysch'));
$row29=number_format(sumPlain('s_alb_returned','s_bysch'));
$row30=number_format(divisionValues(sumPlain('s_alb_use','s_bysch'),sumPlain('s_alb_received','s_bysch')),2,'.','');
$row31=number_format(sumPLain('s_spoilt_total','s_bysch') / sumPLain('s_alb_received','s_bysch'),2,'.','');
$row32=numDistinctFlexible('s_district_id','s_bysch','sp_attached','Yes') ;
$row33=numDistinctFlexible('s_prog_sch_id','s_bysch','sp_attached','Yes') ;
$row34=sumDewormedPlusAudultsSbysch('SCHISTO');
$row35=sumChildrenSbysch('SHISTO');
$row36=number_format(addValues(sumPriEnrolledSbysch('SHISTO'),sumArgs('s_bysch','s_ecd_treated_male','s_ecd_treated_female')));
$row37=number_format(sumArgs('s_bysch','sp_ecd_m','sp_ecd_f'));
$row38=number_format(sumPriChildrenSbysch('SHISTO'));
$row39=number_format(sumMaleAbove6Sbysch('SHISTO'));
$row40=number_format(sumFemaleAbove6Sbysch('SHISTO'));
$row41=number_format(sumPriRegisteredSbysch('SHISTO'));
$row42=number_format(sumNonEnrolledSbysch('SHISTO'));
$row43=number_format(sumAdultsFormS('SHISTO'));
$row44=number_format(sumTabletsSpoilt('SHISTO'));
$row45=number_format(sumPlain('sp_pzq_received','s_bysch'));
$row46=number_format(sumplain('sp_pzq_use','s_bysch'));
$row47=number_format(sumPlain('sp_pzq_returned','s_bysch'));





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
			->setCellValue('A2', 'No. of districts covered')
			->setCellValue('B2',$row1)
			->setCellValue('A3', 'No. of schools covered')
			->setCellValue('B3',$row2)
			->setCellValue('A4', 'No. dewormed (children + adults)')
			->setCellValue('B4',$row3)
			->setCellValue('A5', 'No. of children dewormed')
			->setCellValue('B5',$row4)
			->setCellValue('A6', 'Average children dewormed per district')
			->setCellValue('B6',$row5)
			->setCellValue('A7', 'Range of district coverage (max district average)')
			->setCellValue('B7',$row6)
			->setCellValue('A8', 'Range of district coverage (min district average)')
			->setCellValue('B8',$row7)
			->setCellValue('A9', 'No. of Enrolled Primary + Enrolled ECD children dewormed')
			->setCellValue('B9',$row8)
			->setCellValue('A10', 'No. of ECD children dewormed')
			->setCellValue('B10',$row9)
			->setCellValue('A11', 'No. of ECD Male children dewormed')
			->setCellValue('B11',$row10)
			->setCellValue('A12', 'No. of ECD Female children dewormed')
			->setCellValue('B12',$row11)
			->setCellValue('A13', 'No. of Primary children dewormed')
			->setCellValue('B13',$row12)
			->setCellValue('A14', 'No. of Primary Male children dewormed')
			->setCellValue('B14',$row13)
			->setCellValue('A15', 'No. of Primary Female children dewormed')
			->setCellValue('B15',$row14)
			->setCellValue('A16', 'No. of Primary children registered')
			->setCellValue('B16',$row15)
			->setCellValue('A17', 'No. of Male Primary children registered')
			->setCellValue('B17',$row16)
			->setCellValue('A18', 'No. of Female Primary children registered')
			->setCellValue('B18',$row17)
			->setCellValue('A19', 'No. of Non Enrolled children dewormed')
			->setCellValue('B19',$row18)
			->setCellValue('A20', 'No. of children aged 2-5 years dewormed')
			->setCellValue('B20',$row19)
			->setCellValue('A21', 'No. of male children aged 2-5 years dewormed')
			->setCellValue('B21',$row20)
			->setCellValue('A22', 'No. of female children aged 2-5 years dewormed')
			->setCellValue('B22',$row21)
			->setCellValue('A23', 'No. of children aged 6+ years dewormed')
			->setCellValue('B23',$row22)
			->setCellValue('A24', 'No. of male children aged 6+ years dewormed')
			->setCellValue('B24',$row23)
			->setCellValue('A25', 'No. of female children aged 6+ years dewormed')
			->setCellValue('B25',$row24)
			->setCellValue('A26', 'No. of adults dewormed')
			->setCellValue('B26',$row25)
			->setCellValue('A27', 'Supply Estimation Indicators')
			->setCellValue('A27', '')
			->setCellValue('A28', 'No. of tablets spoilt')
			->setCellValue('B28',$row26)
			->setCellValue('A29', 'No. of tablets supplied')
			->setCellValue('B29',$row27)
			->setCellValue('A30', 'No. of tablets used (includes tablets given to children and adults and tablets spoilt)')
			->setCellValue('B30',$row28)
			->setCellValue('A31', 'No. of tablets returned')
			->setCellValue('B31',$row29)
			->setCellValue('A32', 'Ratio of tablets used to supplied')
			->setCellValue('B32',$row30)
			->setCellValue('A33', 'Ratio of tablets spolit to tablets supplied')
			->setCellValue('B33',$row31)
			->setCellValue('A34', 'SCHISTO Indicators')
			->setCellValue('A34', ' ')
			->setCellValue('A35', 'No. of districts covered')
			->setCellValue('B35',$row32)
			->setCellValue('A36', 'No. of schools covered')
			->setCellValue('B36',$row33)
			->setCellValue('A37', 'No. dewormed (children + adults)')
			->setCellValue('B37',$row34)
			->setCellValue('A38', 'No. of children dewormed')
			->setCellValue('B38',$row35)
			->setCellValue('A39', 'No. of Enrolled Primary + Enrolled ECD children dewormed')
			->setCellValue('B39',$row36)
			->setCellValue('A40', 'No. of ECD children dewormed')
			->setCellValue('B40',$row37)
			->setCellValue('A41', 'No. of Primary children dewormed')
			->setCellValue('B41',$row38)
			->setCellValue('A42', 'No. of Primary Male children dewormed')
			->setCellValue('B42',$row39)
			->setCellValue('A43', 'No. of Primary Female children dewormed')
			->setCellValue('B43',$row40)
			->setCellValue('A44', 'No. of Primary children registered')
			->setCellValue('B44',$row41)
			->setCellValue('A45', 'No. of Non Enrolled children dewormed')
			->setCellValue('B45',$row42)
			->setCellValue('A46', 'No. of adults dewormed')
			->setCellValue('B46',$row43)
			->setCellValue('A47', 'No. of tablets spoilt')
			->setCellValue('B47',$row44)
			->setCellValue('A48', 'No. of tablets supplied')
			->setCellValue('B48',$row45)
			->setCellValue('A49', 'No. of tablets used (includes tablets given to children and adults and tablets spoilt)')
			->setCellValue('B49',$row46)
			->setCellValue('A50', 'No. of tablets returned')
			->setCellValue('B50',$row47);


           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('Form S DashBoard');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Form S DashBoard.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
