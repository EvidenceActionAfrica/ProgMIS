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
$placeholder = "N/A";
$path = "../../";
include $path . "includes/auth.php";
include $path . "includes/config.php";
include "queryFunctions.php";

$row1 = number_format(sumPlain('a_total_child', 'a_bysch'));
$row2 = number_format(numDistinctPlain('district_id', 'a_bysch'));
$row3 = number_format(numDistinctPlain('division_id', 'a_bysch'));
$row4 = number_format(sumPlain('a_trt_total', 'a_bysch'));
$row5 = number_format(sumPlain('a_trt_m', 'a_bysch'));
$row6 = number_format(sumPlain('a_trt_f', 'a_bysch'));
$row7 = number_format(sumPlain('a_6_18_total', 'a_bysch'));
$row8 = number_format(sumPlain('a_6_18_m', 'a_bysch'));
$row9 = number_format(sumPlain('a_6_18_f', 'a_bysch'));
$row10 = number_format(sumPlain('a_u5_total', 'a_bysch'));
$row11 = number_format(sumPlain('a_u5_m', 'a_bysch'));
$row12 = number_format(sumPlain('a_u5_f', 'a_bysch'));
$row13 = number_format(sumPlain('p_alb', 'p_bysch'));
$row14 = number_format(sumSHISTO());
$row15 = number_format(numFlexible3('district_id', 'a_bysch', 'ap_attached', 'Yes', 'ap_total_child', '0'));
$row16 = number_format(numFlexible3('division_id', 'a_bysch', 'ap_attached', 'Yes', 'ap_total_child', '0'));
$row17 = number_format(sumPlain('ap_trt_total', 'a_bysch'));
$row18 = number_format(sumPlain('ap_trt_m', 'a_bysch'));
$row19 = number_format(sumPlain('ap_trt_f', 'a_bysch'));
$row20 = number_format(sumPlain('ap_6_18_total', 'a_bysch'));
$row21 = number_format(sumPlain('ap_6_18_m', 'a_bysch'));
$row22 = number_format(sumPlain('ap_6_18_f', 'a_bysch'));
$row23 = percentage(sumPlain('a_trt_total', 'a_bysch'), sumPlain('a_total_child', 'a_bysch'));
$row24 = number_format(sumPlain('a_trt_total', 'a_bysch'));
$sum1 = sumPlain('p_pri_enroll', 'p_bysch');
$sum2 = sumPlain('p_ecd_enroll', 'p_bysch');
$sum3 = sumPlain('p_ecd_sa_enroll', 'p_bysch');
$row25 = number_format(($sum1 + $sum2 + $sum3) / 0.83);
$row26 = number_format(sumPlain('p_pri_enroll', 'p_bysch'));
$sum4 = sumPlain('p_ecd_enroll', 'p_bysch');
$sum5 = sumPlain('p_ecd_sa_enroll', 'p_bysch');
$row27 = number_format($sum4 + $sum5);
$row28 = number_format(num('s_prog_sch_id', 's_bysch'));
$row29 = number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'Public'));
$row30 = number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'Private'));
$row31 = number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'Other'));
$row32 = number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'None'));
$row33 = percentage(sumArgs('a_bysch', 'ap_trt_total', 'ap_ecd_total'), sumEstimated('p_pri_enroll/0.96', 'Y'));
$row34 = number_format(sumArgs('a_bysch', 'ap_trt_total', 'ap_ecd_total'));
$row35 = number_format(sumEstimated('p_pri_enroll/0.96', 'Y'));
$row36 = number_format(sumEstimated('p_pri_enroll', 'Y'));
$row37 = "** Removed **";
$row38 = number_format(numDistinctP('district_id', 'Y'));
$row39 = number_format(numJoin('ap_attached', 'Yes', 'p_sch_closed', 'No'));
$row40 = number_format(numFlexibleDonor1('p_sch_id', 'p_bysch', 'p_sch_bilharzia', 'Y', 'p_sch_closed', 'No'));
$row41 = number_format(numSchoolType('Public'));
$row42 = number_format(numSchoolType('Private'));
$row43 = number_format(numSchoolType('Other'));
$row44 = number_format(numSchoolType('Not specified'));
$row45 = number_format(sumPriRegistered('p_pri_enroll', 'p_bysch', 'p_sch_bilharzia', 'Y', 'p_sch_closed', 'No'));
$row46 = number_format(sumPlain('p_pzq', 'p_bysch'));
$row47 = number_format(sumPlain('a_6_18_total', 'a_bysch'));
$row48 = number_format(sumPlain('a_6_18_m', 'a_bysch'));
$row49 = number_format(sumPlain('a_6_18_f', 'a_bysch'));
$row50 = number_format(sumPlain('a_6_total', 'a_bysch'));
$row51 = number_format(sumPlain('a_11_total', 'a_bysch'));
$row52 = number_format(sumPlain('a_15_total', 'a_bysch'));
$row53 = number_format(divisionValues(sumPlain('a_6_18_total', 'a_bysch'), num('school_id', 'a_bysch')), 2, '.', '');
$row54 = number_format(minimum('a_6_18_total', 'a_bysch'));
$row55 = number_format(maximum('a_6_18_total', 'a_bysch'));
$row56 = number_format(numFlexible1('school_id', 'a_bysch', 'a_2_18_total', 0, 'ap_6_18_total'));
$row57 = number_format(sumPlain('ap_6_18_total', 'a_bysch'));
$row58 = number_format(sumPlain('ap_6_18_m', 'a_bysch'));
$row59 = number_format(sumPlain('ap_6_18_f', 'a_bysch'));
$row60 = number_format(sumPlain('ap_6_total', 'a_bysch'));
$row61 = number_format(sumPlain('a_11_total', 'a_bysch'));
$row62 = number_format(sumPlain('a_15_total', 'a_bysch'));
$row63 = number_format(sumPlain('a_u5_total', 'a_bysch'));
$row64 = number_format(sumPlain('a_u5_m', 'a_bysch'));
$row65 = number_format(sumPlain('a_u5_f', 'a_bysch'));
$row66 = number_format(sumPlain('a_2_total', 'a_bysch'));
$row67 = number_format(sumPlain('a_ecd_total', 'a_bysch'));
$row68 = number_format(numFlexible('a_u5_total', 'a_bysch', 'a_u5_total', 0));
$row69 = percentage(num('school_id', 'attnt_bysch'), numflexible('p_sch_id', 'p_bysch', 'p_sch_closed', 'No'));
$row70 = number_format(num('school_id', 'attnt_bysch'));
$row71 = number_format(numflexible('p_sch_id', 'p_bysch', 'p_sch_closed', 'No'));
$row72 = number_format(numDistinctPlain('attnt_district_name', 'attnt_bysch'));
$row73 = number_format(numDistinctPlain('attnt_division_name', 'attnt_bysch'));
$row74 = number_format(numDistinctPlain('division_id', 'p_bysch'));
$row75 = number_format(num('t1_name', 'attnt_bysch') + num('t2_name', 'attnt_bysch'));
$row76 = percentage(numFlexible('attnt_id', 'attnt_bysch', 'attnt_total_drugs', '1'), numDistinctPlain('p_sch_id', 'p_bysch'));
$row77 = number_format(numFlexible('attnt_id', 'attnt_bysch', 'attnt_total_drugs', '1'));
$row78 = number_format(sumPlain('mt_sessions', 'form_mt'));
$row79 = number_format(numDistinctPlain('attnt_no', 'attnt_bysch'));
$row80 = number_format(numDistinctFlexible('attnt_id', 'attnt_bysch', 'attnt_sth', '1'));
$row81 = number_format(numDistinctFlexible('attnt_id', 'attnt_bysch', 'attnt_schisto', '1'));
$row82 = number_format(numAttntFlex('attnt_id', 'attnt_alb_tt', '1', 'attnt_pzq_tt', '0', 'attnt_sth', '1'));
$row83 = number_format(numAttntFlex('attnt_id', 'attnt_alb_tt', '0', 'attnt_pzq_tt', '0', 'attnt_sth', '1'));
$row84 = number_format(numAttntFlex('attnt_id', 'attnt_alb_tt', '1', 'attnt_pzq_tt', '1', 'attnt_schisto', '1'));
$row85 = number_format(numAttntFlex('attnt_id', 'attnt_alb_tt', '0', 'attnt_pzq_tt', '1', 'attnt_schisto', '1'));
$row86 = number_format(numAttntFlex('attnt_id', 'attnt_alb_tt', '1', 'attnt_pzq_tt', '0', 'attnt_schisto', '1'));
$row87 = number_format(numAttntFlex('attnt_id', 'attnt_alb_tt', '0', 'attnt_pzq_tt', '0', 'attnt_schisto', '1'));
$row88a = numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', '1');
$row88b = numAttntFlex3('school_id', 'attnt_total_drugs', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', '0');
$row88c = $row88a + $row88b;
$row88 = percentage($row88c, numDistinctPlain('school_id', 'attnt_bysch'));
$row89 = number_format(numDistinctPlain('attnt_id', 'attnt_bysch'));
$row90 = number_format(numDistinctPlain('school_id', 'attnt_bysch'));
$row91 = number_format($row88c);
$row92 = number_format(numDistinctFlexible('school_id', 'attnt_bysch', 'attnt_sth', '0'));
$row93 = number_format(numDistinctFlexible('school_id', 'attnt_bysch', 'attnt_sth', '1'));
$row94 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '0', 'attnt_sch_treatment', '0'));
$row95 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '0'));
$row96 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '0'));
$row97 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '0', 'attnt_sch_treatment', '0'));
$row98 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '0', 'attnt_sch_treatment', '1'));
$row99 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '1'));
$row100 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '1'));
$row101 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '0', 'attnt_sch_treatment', '1'));
$row102 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '0', 'attnt_sch_treatment', '1'));
$row103 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '1', 'attnt_total_forms', '0', 'attnt_sch_treatment', '1'));
$row104 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', '1'));
$row105 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', '1'));
$row106a = number_format(numflexible2('attnt_id', 'attnt_bysch', 't1_received_transport', 'Yes', 't2_received_transport'));
$row106 = percentage(num('s_prog_sch_id', 's_bysch'), numDistinctPlain('s_prog_sch_id', 's_bysch'));
$row107 = number_format(numFlexible('s_prog_sch_id', 's_bysch', 's_deworming_day', ''));
$row108 = number_format(NotEmpty('s_deworming_day', 's_bysch'));
$row109 = number_format(num('s_prog_sch_id', 's_bysch'));
$row110 = number_format(numDistinctPlain('s_prog_sch_id', 's_bysch'));
$row111 = reporting_on_school_division();
$row112 = reporting_on_school_district();
$row113 = number_format(numDistinctPlain('s_district_id', 's_bysch') + numDistinctPlain('district_id', 'a_bysch') + numDistinctPlain('district_id', 'd_bysch'));
$row114 = number_format(numDistinctPlain('s_division_id', 's_bysch') + numDistinctPlain('division_id', 'a_bysch') + numDistinctPlain('division_id', 'd_bysch'));
$row115 = number_format(sumPlain('s_total_child', 's_bysch'));
$row116 = number_format(sumPlain('a_total_child', 'a_bysch'));
$row117 = number_format(sumPlain('d_total_child', 'd_bysch'));
$row118 = number_format(numDistinctPlain('s_prog_sch_id', 's_bysch'));
$row119 = number_format(numDistinctPlain('school_id', 'a_bysch'));
$row120 = $placeholder;
$row121 = number_format(NotEmpty('s_prog_sch_id', 's_bysch'));
$row122 = number_format(numDistinctPlain('district_name', 'a_bysch'));
$row123 = number_format(numDistinctPlain('district_name', 'd_bysch'));
$row124 = number_format(sumPlain('s_adult_total', 's_bysch'));
$row125 = number_format(sumPlain('s_adult_total', 's_bysch'));
$row126 = number_format(sumPlain('sp_adult_total', 's_bysch'));
$row127 = number_format(numFlexible('attnt_id', 'attnt_bysch', 'training_date_dd', '1'));
$row128 = $placeholder;
$row129 = $placeholder;



/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once $path . 'PHPExcel/Classes/PHPExcel.php';


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
        ->setCellValue('A1', 'Indicator')
        ->setCellValue('B1', 'Total')
        ->setCellValue('A2', "No. of children dewormed for STH once")
        ->setCellValue('B2', $row1)
        ->setCellValue('A3', "No. of districts covered for STH")
        ->setCellValue('B3', $row2)
        ->setCellValue('A4', "No. of divisions covered for STH")
        ->setCellValue('B4', $row3)
        ->setCellValue('A5', "No. of Enrolled Primary School Aged children dewormed for STH")
        ->setCellValue('B5', $row4)
        ->setCellValue('A6', "No. of Enrolled Primary School Aged children dewormed for STH (male)")
        ->setCellValue('B6', $row5)
        ->setCellValue('A7', "No. of Enrolled Primary School Aged children dewormed for STH (female)")
        ->setCellValue('B7', $row6)
        ->setCellValue('A8', "No. of Non-enrolled (age 6-18) children dewormed for STH")
        ->setCellValue('B8', $row7)
        ->setCellValue('A9', "No. of Non-enrolled (age 6-18) children dewormed for STH (male)")
        ->setCellValue('B9', $row8)
        ->setCellValue('A10', "No. of Non-enrolled (age 6-18) children dewormed for STH (female)")
        ->setCellValue('B10', $row9)
        ->setCellValue('A11', "No. of U5 children dewormed for STH")
        ->setCellValue('B11', $row10)
        ->setCellValue('A12', "No. of U5 children dewormed for STH (male)")
        ->setCellValue('B12', $row11)
        ->setCellValue('A13', "No. of U5 children dewormed for STH (female)")
        ->setCellValue('B13', $row12)
        ->setCellValue('A14', "No. of ALB estimated for STH")
        ->setCellValue('B14', $row13)
        ->setCellValue('A15', "No. of children dewormed for Schisto once")
        ->setCellValue('B15', $row14)
        ->setCellValue('A16', "No. of Sub-Counties covered for Schisto")
        ->setCellValue('B16', $row15)
        ->setCellValue('A17', "No. of divisions covered for Schisto")
        ->setCellValue('B17', $row16)
        ->setCellValue('A18', "No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto")
        ->setCellValue('B18', $row17)
        ->setCellValue('A19', "No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto (Male)")
        ->setCellValue('B19', $row18)
        ->setCellValue('A20', "No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto (Female)")
        ->setCellValue('B20', $row19)
        ->setCellValue('A21', "No. of Non Enrolled (age 6-18) children dewormed for Schisto")
        ->setCellValue('B21', $row20)
        ->setCellValue('A22', "No. of Non Enrolled (age 6-18) children dewormed for Schisto (Male)")
        ->setCellValue('B22', $row21)
        ->setCellValue('A23', "No. of Non Enrolled (age 6-18) children dewormed for Schisto (Female)")
        ->setCellValue('B23', $row22)
        ->setCellValue('A24', "Percentage of enrolled children aged 6+ receiving STH")
        ->setCellValue('B24', $row23)
        ->setCellValue('A25', "No. of Enrolled Primary School Aged children dewormed for STH")
        ->setCellValue('B25', $row24)
        ->setCellValue('A26', "Estimated target population of STH")
        ->setCellValue('B26', $row25)
        ->setCellValue('A27', "Estimated No. of 'Enrolled Primary School' children for STH")
        ->setCellValue('B27', $row26)
        ->setCellValue('A28', "Estimated No. of 'Enrolled ECD' children for STH")
        ->setCellValue('B28', $row27)
        ->setCellValue('A29', "No. of schools targeted for STH")
        ->setCellValue('B29', $row28)
        ->setCellValue('A30', "No. of public schools for STH")
        ->setCellValue('B30', $row29)
        ->setCellValue('A31', "No. of private schools for STH")
        ->setCellValue('B31', $row30)
        ->setCellValue('A32', "No. of 'other' schools for STH")
        ->setCellValue('B32', $row31)
        ->setCellValue('A33', "No. of 'no school type' schools for STH")
        ->setCellValue('B33', $row32)
        ->setCellValue('A34', "Percentage enrolled children aged 6+ receiving Schisto Treatment once")
        ->setCellValue('B34', $row33)
        ->setCellValue('A35', "No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto")
        ->setCellValue('B35', $row34)
        ->setCellValue('A36', "Estimated target population of Schisto")
        ->setCellValue('B36', $row35)
        ->setCellValue('A37', "Estimated No. of 'Enrolled Primary School' children for SCHISTO")
        ->setCellValue('B37', $row36)
        ->setCellValue('A38', "Estimated No. of 'Enrolled ECD' children for SCHISTO")
        ->setCellValue('B38', $row37)
        ->setCellValue('A39', "No. of districts planned for SCHISTO")
        ->setCellValue('B39', $row38)
        ->setCellValue('A40', "No. of schools covered for Schisto")
        ->setCellValue('B40', $row39)
        ->setCellValue('A41', "No. of schools targeted for Schisto")
        ->setCellValue('B41', $row40)
        ->setCellValue('A42', "No. of public schools for SCHISTO")
        ->setCellValue('B42', $row41)
        ->setCellValue('A43', "No. of private schools for SCHISTO")
        ->setCellValue('B43', $row42)
        ->setCellValue('A44', "No. of 'other' schools for SCHISTO")
        ->setCellValue('B44', $row43)
        ->setCellValue('A45', "No. of 'no school type' schools for SCHISTO")
        ->setCellValue('B45', $row44)
        ->setCellValue('A46', "No. of Enrolled Primary School Aged children registered for Schisto")
        ->setCellValue('B46', $row45)
        ->setCellValue('A47', "Estimated No. of PZQ tablets needed")
        ->setCellValue('B47', $row46)
        ->setCellValue('A48', "No. of Non-enrolled (age 6-18) children dewormed for STH")
        ->setCellValue('B48', $row47)
        ->setCellValue('A49', "No. of Non-enrolled (age 6-18) children dewormed for STH (male)")
        ->setCellValue('B49', $row48)
        ->setCellValue('A50', "No. of Non-enrolled (age 6-18) children dewormed for STH (female)")
        ->setCellValue('B50', $row49)
        ->setCellValue('A51', "No. of Non-enrolled (age 6-10) children dewormed for STH")
        ->setCellValue('B51', $row50)
        ->setCellValue('A52', "No. of Non-enrolled (age 11-14) children dewormed for STH")
        ->setCellValue('B52', $row51)
        ->setCellValue('A53', "No. of Non-enrolled (age 15-18) children dewormed for STH")
        ->setCellValue('B53', $row52)
        ->setCellValue('A54', "Average No of Non-enrolled Children Treated per school (6-18)")
        ->setCellValue('B54', $row53)
        ->setCellValue('A55', "Minimum No of Non-enrolled Children Treated per school (6-18)")
        ->setCellValue('B55', $row54)
        ->setCellValue('A56', "Maximum No of Non-enrolled Children Treated per school (6-18)")
        ->setCellValue('B56', $row55)
        ->setCellValue('A57', "No of Schools that Treated NO Non-Enrolled Children (6-18)")
        ->setCellValue('B57', $row56)
        ->setCellValue('A58', "No. of Non Enrolled (age 6-18) children dewormed for Schisto")
        ->setCellValue('B58', $row57)
        ->setCellValue('A59', "No. of Non Enrolled (age 6-18) children dewormed for Schisto (Male)")
        ->setCellValue('B59', $row58)
        ->setCellValue('A60', "No. of Non Enrolled (age 6-18) children dewormed for Schisto (Female)")
        ->setCellValue('B60', $row59)
        ->setCellValue('A61', "No. of Non Enrolled (age 6-10) children dewormed for Schisto")
        ->setCellValue('B61', $row60)
        ->setCellValue('A62', "No. of Non Enrolled (age 11-14) children dewormed for Schisto")
        ->setCellValue('B62', $row61)
        ->setCellValue('A63', "No. of Non Enrolled (age 15-18) children dewormed for Schisto")
        ->setCellValue('B63', $row62)
        ->setCellValue('A64', "No. of U5 children dewormed for STH")
        ->setCellValue('B64', $row63)
        ->setCellValue('A65', "No. of U5 children dewormed for STH (male)")
        ->setCellValue('B65', $row64)
        ->setCellValue('A66', "No. of U5 children dewormed for STH (female)")
        ->setCellValue('B66', $row65)
        ->setCellValue('A67', "No. of Non-enrolled (age 2-5) children dewormed for STH")
        ->setCellValue('B67', $row66)
        ->setCellValue('A68', "No. of ECD children dewormed for STH")
        ->setCellValue('B68', $row67)
        ->setCellValue('A69', "No of Schools Treating NO Under 5s")
        ->setCellValue('B69', $row68)
        ->setCellValue('A70', "Percentage No of target schools attending teacher training sessions")
        ->setCellValue('B70', $row69)
        ->setCellValue('A71', "No. target schools attending teacher training sessions")
        ->setCellValue('B71', $row70)
        ->setCellValue('A72', "No. of schools targeted for STH")
        ->setCellValue('B72', $row71)
        ->setCellValue('A73', "No. of District attending teacher training")
        ->setCellValue('B73', $row72)
        ->setCellValue('A74', "No. of divisions attending teacher training")
        ->setCellValue('B74', $row73)
        ->setCellValue('A75', "No of Divisions Planned")
        ->setCellValue('B75', $row74)
        ->setCellValue('A76', "No. of teachers trained")
        ->setCellValue('B76', $row75)
        ->setCellValue('A77', "Percentage of TTS where Albendazole (& Praziquantel if necessary) are available on the day of Training")
        ->setCellValue('B77', $row76)
        ->setCellValue('A78', "No. of TTs with requiered drugs")
        ->setCellValue('B78', $row77)
        ->setCellValue('A79', "No of TTS Planned")
        ->setCellValue('B79', $row78)
        ->setCellValue('A80', "No of TTS conducted")
        ->setCellValue('B80', $row79)
        ->setCellValue('A81', "No of TTS conducted for STH Only")
        ->setCellValue('B81', $row80)
        ->setCellValue('A82', "No of TTS conducted for STH & Schisto")
        ->setCellValue('B82', $row81)
        ->setCellValue('A83', "No of TTS (STH Only) where only Alb present")
        ->setCellValue('B83', $row82)
        ->setCellValue('A84', "No of TTS (STH Only) where no drugs present")
        ->setCellValue('B84', $row83)
        ->setCellValue('A85', "No of TTS (STH & Schisto) where Alb & Prazi present")
        ->setCellValue('B85', $row84)
        ->setCellValue('A86', "No of TTS (STH & Schisto) where only Alb & Prazi present")
        ->setCellValue('B86', $row85)
        ->setCellValue('A87', "No of TTS (STH & Schisto) where only Alb present")
        ->setCellValue('B87', $row86)
        ->setCellValue('A88', "No of TTS (STH & Schisto) where no drugs present")
        ->setCellValue('B88', $row87)
        ->setCellValue('A89', "Percentage of schools attending teacher trainings receiving all critical materials for deworming day at teacher trainings")
        ->setCellValue('B89', $row88)
        ->setCellValue('A90', "No of TTS conducted")
        ->setCellValue('B90', $row89)
        ->setCellValue('A91', "No. of schools attending teacher training")
        ->setCellValue('B91', $row90)
        ->setCellValue('A92', "No. of schools with critical materials present")
        ->setCellValue('B92', $row91)
        ->setCellValue('A93', "No. of schools attending teacher training (STH Only)")
        ->setCellValue('B93', $row92)
        ->setCellValue('A94', "No. of schools attending teacher training (STH & Schisto)")
        ->setCellValue('B94', $row93)
        ->setCellValue('A95', "No. of schools attending teacher training (STH Only) with Drugs only")
        ->setCellValue('B95', $row94)
        ->setCellValue('A96', "No. of schools attending teacher training (STH Only) with Forms only")
        ->setCellValue('B96', $row95)
        ->setCellValue('A97', "No. of schools attending teacher training (STH Only) with Drugs & Forms")
        ->setCellValue('B97', $row96)
        ->setCellValue('A98', "No. of schools attending teacher training (STH Only) with no critical Materials")
        ->setCellValue('B98', $row97)
        ->setCellValue('A99', "No. of schools attending teacher training (STH & Schisto) with Drugs only")
        ->setCellValue('B99', $row98)
        ->setCellValue('A100', "No. of schools attending teacher training (STH & Schisto) with Forms only")
        ->setCellValue('B100', $row99)
        ->setCellValue('A101', "No. of schools attending teacher training (STH & Schisto) with Drugs & Forms")
        ->setCellValue('B101', $row100)
        ->setCellValue('A102', "No. of schools attending teacher training (STH & Schisto) with no critical Materials")
        ->setCellValue('B102', $row101)
        ->setCellValue('A103', "No. of schools attending teacher training (STH & Schisto) with Drugs & Poles")
        ->setCellValue('B103', $row102)
        ->setCellValue('A104', "No. of schools attending teacher training (STH & Schisto) with Poles only")
        ->setCellValue('B104', $row103)
        ->setCellValue('A105', "No. of schools attending teacher training (STH & Schisto) with Poles & Forms")
        ->setCellValue('B105', $row104)
        ->setCellValue('A106', "No. of schools attending teacher training (STH & Schisto) with Drugs, Poles & Forms")
        ->setCellValue('B106', $row105)
        ->setCellValue('A107', "No. TTs where funds are available")
        ->setCellValue('B107', $row106a)        
        ->setCellValue('A108', "Percentage of schools performing deworming on designated County deworming day")
        ->setCellValue('B108', $row106)
        ->setCellValue('A109', "No of schools that did not provide deworming date on Form S")
        ->setCellValue('B109', $row107)
        ->setCellValue('A110', "No of schools that provided deworming date on Form S")
        ->setCellValue('B110', $row108)
        ->setCellValue('A111', "No of schools that performed Deworming Day on designated County deworming day")
        ->setCellValue('B111', $row109)
        ->setCellValue('A112', "Total no of schools on form S")
        ->setCellValue('B112', $row110)
        ->setCellValue('A113', "% divisions correctly (+/- 10%) reporting on school level coverage of total children dewormed")
        ->setCellValue('B113', $row111)
        ->setCellValue('A114', "% Sub-Counties correctly (+/- 10%) reporting on school-level coverage of total children dewormed")
        ->setCellValue('B114', $row112)
        ->setCellValue('A115', "No. of Sub-Counties returning form S, A & D in full")
        ->setCellValue('B115', $row113)
        ->setCellValue('A116', "No. of Divisions returning form S, A & D in full")
        ->setCellValue('B116', $row114)
        ->setCellValue('A117', "No. of children dewormed for STH form S")
        ->setCellValue('B117', $row115)
        ->setCellValue('A118', "No. of children dewormed for STH form A")
        ->setCellValue('B118', $row116)
        ->setCellValue('A119', "No. of children dewormed for STH form D")
        ->setCellValue('B119', $row117)
        ->setCellValue('A120', "No. of Schools dewormed for STH form S")
        ->setCellValue('B120', $row118)
        ->setCellValue('A121', "No. of Schools dewormed for STH form A")
        ->setCellValue('B121', $row119)
        ->setCellValue('A122', "% Sub-Counties submitting forms S,A,and D to National level within three months of deworming day")
        ->setCellValue('B122', $row120)
        ->setCellValue('A123', "No. of Schools returning form S")
        ->setCellValue('B123', $row121)
        ->setCellValue('A124', "No. of Sub-County returning form A")
        ->setCellValue('B124', $row122)
        ->setCellValue('A125', "No. of Sub-County returning form D")
        ->setCellValue('b125', $row123)
        ->setCellValue('A126', "No of Adults treated")
        ->setCellValue('B126', $row124)
        ->setCellValue('A127', "No. of Adult Treated for STH")
        ->setCellValue('B127', $row125)
        ->setCellValue('A128', "No. of Adult Treated for Schisto")
        ->setCellValue('B128', $row126)
        ->setCellValue('A129', "No. of Gok personnel at regional training")
        ->setCellValue('B129', $row127)
        ->setCellValue('A130', "No. of Gok Sub-County personnel at Sub-County training")
        ->setCellValue('B130', $row128)
        ->setCellValue('A131', "No. of Gok divisional personnel at Sub-County training")
        ->setCellValue('B131', $row129);

// Rename worksheet
$today = date("F j-Y");
$objPHPExcel->getActiveSheet()->setTitle('DashBoard Attnt');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="KPI REPORT.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
