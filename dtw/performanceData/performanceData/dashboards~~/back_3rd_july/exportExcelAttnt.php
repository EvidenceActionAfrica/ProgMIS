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

$row1=numDistinctPlain('attnt_district_id','attnt_bysch');
		$row2=numDistinctPlain('attnt_id','attnt_bysch');
		$row3=numDistinctFlexible('attnt_id','attnt_bysch','attnt_sth','1');
		$row4=numDistinctFlexible('attnt_id','attnt_bysch','attnt_schisto','1');
		$row5=numAttntFlex('attnt_id','attnt_alb_tt','0','attnt_pzq_tt','0','attnt_sth','1');
		$row6=numAttntFlex('attnt_id','attnt_alb_tt','0','attnt_pzq_tt','0','attnt_schisto','1');
		$row7=numAttntFlex2('attnt_id','attnt_alb_tt','0','attnt_pzq_tt','0');
		$row8=numAttntFlex('attnt_id','attnt_alb_tt','0', 'attnt_pzq_tt','1', 'attnt_sth','1');
		$row9=numAttntFlex('attnt_id','attnt_alb_tt','0','attnt_pzq_tt','1','attnt_schisto','1');
		$row10=numAttntFlex2('attnt_id','attnt_alb_tt','0','attnt_pzq_tt','1');
		$row11=numAttntFlex('attnt_id','attnt_alb_tt','1','attnt_pzq_tt','0','attnt_sth','1');
		$row12=numAttntFlex('attnt_id','attnt_alb_tt','1','attnt_pzq_tt','0','attnt_schisto','1');
		$row13=numAttntFlex2('attnt_id','attnt_alb_tt','1','attnt_pzq_tt','0');
		$row14=numAttntFlex('attnt_id','attnt_alb_tt','1','attnt_pzq_tt','1','attnt_sth','1');
		$row15=numAttntFlex('attnt_id','attnt_alb_tt','1','attnt_pzq_tt','1','attnt_schisto','1');
		$row16=numAttntFlex2('attnt_id','attnt_alb_tt','1','attnt_pzq_tt','1');
		$row17=number_format($row17=remove_comma($row11)+remove_comma($row15));
		$row18=number_format($row18=remove_comma($row5)+remove_comma($row6)+remove_comma($row9)+remove_comma($row12));
		$row19=numDistinctPlain('school_id','attnt_bysch');
		$row20=numDistinctFlexible('school_id','attnt_bysch','attnt_sth','1');
		$row21=numDistinctFlexible('school_id','attnt_bysch','attnt_schisto','1');
		$row22=numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','0','attnt_total_forms','0','attnt_sch_treatment','0');
		$row23=numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','0','attnt_total_forms','0','attnt_sch_treatment','1');
		$row24=numAttntFlex('school_id','attnt_total_drugs','0','attnt_total_poles','0','attnt_total_forms','0');
		$row25=number_format(numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','0','attnt_total_forms','1','attnt_sch_treatment','0'));
		$row26=number_format(numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','0','attnt_total_forms','1','attnt_sch_treatment','1'));
		$row27=number_format(numAttntFlex('school_id','attnt_total_drugs','0','attnt_total_poles','0','attnt_total_forms','1'));
		$row28=number_format(numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','1','attnt_total_forms','0','attnt_sch_treatment','0'));
		$row29=number_format(numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','1','attnt_total_forms','0','attnt_sch_treatment','1'));
		$row30=number_format(numAttntFlex('school_id','attnt_total_drugs','0','attnt_total_poles','1','attnt_total_forms','0'));
		$row31=number_format(numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','1','attnt_total_forms','1','attnt_sch_treatment','0'));
		$row32=number_format(numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','1','attnt_total_forms','1','attnt_sch_treatment','Treating for Bilharzia'));
		$row33=number_format(numAttntFlex('school_id','attnt_total_drugs','0','attnt_total_poles','1','attnt_total_forms','1'));
		$row34=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','0','attnt_total_forms','0','attnt_sch_treatment','0'));
		$row35=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','0','attnt_total_forms','0','attnt_sch_treatment','Treating for Bilharzia'));
		$row36=number_format(numAttntFlex('school_id','attnt_total_drugs','1','attnt_total_poles','0','attnt_total_forms','0'));
		$row37=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','0','attnt_total_forms','1','attnt_sch_treatment','0'));
		$row38=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','0','attnt_total_forms','1','attnt_sch_treatment','Treating for Bilharzia'));
		$row39=number_format(numAttntFlex('school_id','attnt_total_drugs','1','attnt_total_poles','0','attnt_total_forms','1'));
		$row40=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','0','attnt_sch_treatment','0'));
		$row41=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','0','attnt_sch_treatment','Treating for Bilharzia'));
		$row42=number_format(numAttntFlex('school_id','attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','0'));
		$row43=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','1','attnt_sch_treatment','0'));
		$row44=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','1','attnt_sch_treatment','Treating for Bilharzia'));
		$row45=number_format(numAttntFlex('school_id','attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','1'));
		$row46=number_format($row46=remove_comma($row37)+remove_comma($row44));
		$row47=number_format($row47=remove_comma($row24) +remove_comma($row27)+remove_comma($row30) +remove_comma($row33)+remove_comma($row36)+remove_comma($row38)+remove_comma($row42));


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
			->setCellValue('A2','No. of districts covered')
			->setCellValue('B2', $row1)
			->setCellValue('A3','No. of TTs')
			->setCellValue('B3', $row2)
			->setCellValue('A4','No. of TTs for STH only')
			->setCellValue('B4', $row3)
			->setCellValue('A5','No. of TTs for STH and Schisto')
			->setCellValue('B5', $row4)
			->setCellValue('A6','No. of TTs with no drugs - for STH only')
			->setCellValue('B6', $row5)
			->setCellValue('A7','No. of TTs with no drugs - for STH and Schisto')
			->setCellValue('B7', $row6)
			->setCellValue('A8','No. of TTs with no drugs - All')
			->setCellValue('B8', $row7)
			->setCellValue('A9','No. of TTs with PZQ only - for STH only')
			->setCellValue('B9', $row8)
			->setCellValue('A10','No. of TTs with PZQ only - for STH and Schisto')
			->setCellValue('B10', $row9)
			->setCellValue('A11','No. of TTs with PZQ only - All')
			->setCellValue('B11', $row10)
			->setCellValue('A12','No. of TTs with ALB only - for STH only')
			->setCellValue('B12', $row11)
			->setCellValue('A13','No. of TTs with ALB only - for STH and Schisto')
			->setCellValue('B13', $row12)
			->setCellValue('A14','No. of TTs with ALB only - All')
			->setCellValue('B14', $row13)
			->setCellValue('A15','No. of TTs with both drugs - for STH only')
			->setCellValue('B15', $row14)
			->setCellValue('A16','No. of TTs with both drugs - for STH and Schisto')
			->setCellValue('B16', $row15)
			->setCellValue('A17','No. of TTs with both drugs - All')
			->setCellValue('B17', $row16)
			->setCellValue('A18','No. of TTs with drugs present')
			->setCellValue('B18', $row17)
			->setCellValue('A19','No. of TTs with drugs missing')
			->setCellValue('B19', $row18)
			->setCellValue('A20','No. of schools covered')
			->setCellValue('B20', $row19)
			->setCellValue('A21','No. of schools covered for STH only')
			->setCellValue('B21', $row20)
			->setCellValue('A22','No. of schools covered for STH and Schisto')
			->setCellValue('B22', $row21)
			->setCellValue('A23','No. of schools with nothing distributed - for STH only')
			->setCellValue('B23', $row22)
			->setCellValue('A24','No. of schools with nothing distributed - for STH and Schisto')
			->setCellValue('B24', $row23)
			->setCellValue('A25','No. of schools with nothing distributed - All')
			->setCellValue('B25', $row24)
			->setCellValue('A26','No. of schools with forms only distributed - for STH only')
			->setCellValue('B26', $row25)
			->setCellValue('A27','No. of schools with forms only distributed - for STH and Schisto')
			->setCellValue('B27', $row26)
			->setCellValue('A28','No. of schools with forms only distributed - All')
			->setCellValue('B28', $row27)
			->setCellValue('A29','No. of schools with poles only distributed - for STH only')
			->setCellValue('B29', $row28)
			->setCellValue('A30','No. of schools with poles only distributed - for STH and Schisto')
			->setCellValue('B30', $row29)
			->setCellValue('A31','No. of schools with poles only distributed - All')
			->setCellValue('B31', $row30)
			->setCellValue('A32','No. of schools with poles and forms distributed - for STH only')
			->setCellValue('B32', $row31)
			->setCellValue('A33','No. of schools with poles and forms distributed - for STH and Schisto')
			->setCellValue('B33', $row32)
			->setCellValue('A34','No. of schools with poles and forms distributed - All')
			->setCellValue('B34', $row33)
			->setCellValue('A35','No. of schools with drugs only distributed - for STH only')
			->setCellValue('B35', $row34)
			->setCellValue('A36','No. of schools with drugs only distributed - for STH and Schisto')
			->setCellValue('B36', $row35)
			->setCellValue('A37','No. of schools with drugs only distributed - All')
			->setCellValue('B37', $row36)
			->setCellValue('A38','No. of schools with drugs and forms distributed - for STH only')
			->setCellValue('B38', $row37)
			->setCellValue('A39','No. of schools with drugs and forms distributed - for STH and Schisto')
			->setCellValue('B39', $row38)
			->setCellValue('A40','No. of schools with drugs and forms distributed - All')
			->setCellValue('B40', $row39)
			->setCellValue('A41','No. of schools with drugs and poles distributed - for STH only')
			->setCellValue('B41', $row40)
			->setCellValue('A42','No. of schools with drugs and poles distributed - for STH and Schisto')
			->setCellValue('B42', $row41)
			->setCellValue('A43','No. of schools with drugs and poles distributed - All')
			->setCellValue('B43', $row42)
			->setCellValue('A44','No. of schools with drugs, poles and forms distributed - for STH only')
			->setCellValue('B44', $row43)
			->setCellValue('A45','No. of schools with drugs, poles and forms distributed - for STH and Schisto')
			->setCellValue('B45', $row44)
			->setCellValue('A46','No. of schools with drugs, poles and forms distributed - All')
			->setCellValue('B46', $row45)
			->setCellValue('A47','No. of schools with critical materials present')
			->setCellValue('B47', $row46)
			->setCellValue('A48','No. of schools with critical materials missing')
			->setCellValue('B48', $row47);




           



// Rename worksheet
$today = date("F j-Y"); 
$objPHPExcel->getActiveSheet()->setTitle('ATTNT Dashboard');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ATTNT Dashboard.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
