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
$data = "N/A";
include "../includes/config.php";

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../dtw/PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Rambo")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");

// Add some data
$year = $_POST['rec_year'];
$year_m = $_POST['rec_year_m'];
$month_q = $_POST['rec_month_q'];
$year_q = $_POST['rec_year_q'];
$year_q_ = $_POST['rec_year_q_'];
$month = $_POST['rec_month'];
$country_val = $_POST['rec_country'];
if ($month == '1')
    $displ_month_year = 'January ' . $year_m;
if ($month == '2')
    $displ_month_year = 'February ' . $year_m;
if ($month == '3')
    $displ_month_year = 'March ' . $year_m;
if ($month == '4')
    $displ_month_year = 'April ' . $year_m;
if ($month == '5')
    $displ_month_year = 'May ' . $year_m;
if ($month == '6')
    $displ_month_year = 'June ' . $year_m;
if ($month == '7')
    $displ_month_year = 'July ' . $year_m;
if ($month == '8')
    $displ_month_year = 'August ' . $year_m;
if ($month == '9')
    $displ_month_year = 'September ' . $year_m;
if ($month == '10')
    $displ_month_year = 'October ' . $year_m;
if ($month == '11')
    $displ_month_year = 'Nvember ' . $year_m;
if ($month == '12')
    $displ_month_year = 'December ' . $year_m;

if ($month_q == '1')
    $displ_month_year_q = 'Oct ' . $year_q_ . ' - Dec ' . $year_q_;
if ($month_q == '2')
    $displ_month_year_q = 'Nov ' . $year_q_ . ' - Jan ' . $year_q;
if ($month_q == '3')
    $displ_month_year_q = 'Dec ' . $year_q_ . ' - Feb ' . $year_q;
if ($month_q == '4')
    $displ_month_year_q = 'Jan ' . $year_q . ' - Mar ' . $year_q;
if ($month_q == '5')
    $displ_month_year_q = 'Feb ' . $year_q . ' - Apr ' . $year_q;
if ($month_q == '6')
    $displ_month_year_q = 'Mar ' . $year_q . ' - May ' . $year_q;
if ($month_q == '7')
    $displ_month_year_q = 'Apr ' . $year_q . ' - Jun ' . $year_q;
if ($month_q == '8')
    $displ_month_year_q = 'May ' . $year_q . ' - Jul ' . $year_q;
if ($month_q == '9')
    $displ_month_year_q = 'jun ' . $year_q . ' - Aug ' . $year_q;
if ($month_q == '10')
    $displ_month_year_q = 'Jul ' . $year_q . ' - Sep ' . $year_q;
if ($month_q == '11')
    $displ_month_year_q = 'Aug ' . $year_q . ' - Oct ' . $year_q;
if ($month_q == '12')
    $displ_month_year_q = 'Sep ' . $year_q . ' - Nov ' . $year_q;
$i = 5;
$res = mysql_query("(SELECT distinct program FROM `dsw_per_cem_attendees` WHERE country='$country_val')
                    UNION (SELECT distinct program FROM `dsw_per_vcs_attendees` WHERE country='$country_val')
                    UNION (SELECT distinct program FROM `dsw_per_lsm` WHERE country='$country_val')
                    UNION (SELECT distinct program FROM `dsw_per_instalation` WHERE country='$country_val')
                    UNION (SELECT distinct program FROM `dsw_per_verification` WHERE country='$country_val')
                    UNION (SELECT distinct program FROM `dsw_per_chlorine` WHERE country='$country_val') ORDER BY program");
while ($row = mysql_fetch_array($res)) {
    $prog = $row["program"];
    $query_m_lsm = "SELECT month FROM dsw_per_lsm WHERE program = '$prog' AND month = '$month' AND year = '$year_m'";
    $result_m_lsm = mysql_query($query_m_lsm) or die(mysql_error());
    $value_m_lsm = mysql_num_rows($result_m_lsm);
    if ($value_m_lsm == 0) {
        $disp_value_m_lsm = "";
    } else {
        $disp_value_m_lsm = $value_m_lsm;
    }

    $query_m_ver = "SELECT month FROM dsw_per_verification WHERE program = '$prog' AND month = '$month' AND year = '$year_m'";
    $result_m_ver = mysql_query($query_m_ver) or die(mysql_error());
    $value_m_ver = mysql_num_rows($result_m_ver);
    if ($value_m_ver == 0) {
        $disp_value_m_ver = "";
    } else {
        $disp_value_m_ver = $value_m_ver;
    }

    $query_m_vcs = "SELECT month FROM dsw_per_vcs_attendees WHERE program = '$prog' AND month = '$month' AND year = '$year_m'";
    $result_m_vcs = mysql_query($query_m_vcs) or die(mysql_error());
    $value_m_vcs = mysql_num_rows($result_m_vcs);
    if ($value_m_vcs == 0) {
        $disp_value_m_vcs = "";
    } else {
        $disp_value_m_vcs = $value_m_vcs;
    }

    $query_m_instaslation = "SELECT month FROM dsw_per_instalation WHERE program = '$prog' AND month = '$month' AND year = '$year_m'";
    $result_m_instaslation = mysql_query($query_m_instaslation) or die(mysql_error());
    $value_m_instaslation = mysql_num_rows($result_m_instaslation);
    if ($value_m_instaslation == 0) {
        $disp_value_m_instaslation = "";
    } else {
        $disp_value_m_instaslation = $value_m_instaslation;
    }

    $query_m_cem = "SELECT month FROM dsw_per_cem_attendees WHERE program = '$prog' AND month = '$month' AND year = '$year_m'";
    $result_m_cem = mysql_query($query_m_cem) or die(mysql_error());
    $value_m_cem = mysql_num_rows($result_m_cem);
    if ($value_m_cem == 0) {
        $disp_value_m_cem = "";
    } else {
        $disp_value_m_cem = $value_m_cem;
    }

    $query_m_chlorine1 = "SELECT month FROM dsw_per_chlorine WHERE program = '$prog' AND month = '$month' AND year = '$year_m'";
    $result_m_chlorine1 = mysql_query($query_m_chlorine1) or die(mysql_error());
    $value_m_chlorine = mysql_num_rows($result_m_chlorine1);
    if ($value_m_chlorine == 0) {
        $disp_value_m_chlorine = "";
    } else {
        $disp_value_m_chlorine = $value_m_chlorine;
    }

    //<!--===============================================quarter reporting=======================================-->                            
    if ($month_q == '1') {
        $month_q1 = '10';
        $month_q2 = '11';
        $month_q3 = '12';
        $year_q1 = $year_q2 = $year_q3 = $year_q_;
    } else if ($month_q == '2') {
        $month_q1 = '11';
        $month_q2 = '12';
        $month_q3 = $month_q - 1;
        $year_q1 = $year_q2 = $year_q_;
        $year_q3 = $year_q;
    } else if ($month_q == '3') {
        $month_q1 = '12';
        $month_q2 = $month_q - 2;
        $month_q3 = $month_q - 1;
        $year_q1 = $year_q_;
        $year_q2 = $year_q3 = $year_q;
    } else {
        $month_q1 = $month_q - 3;
        $month_q2 = $month_q - 2;
        $month_q3 = $month_q - 1;
        $year_q1 = $year_q2 = $year_q3 = $year_q;
    }

    $query_q_lsm1 = "SELECT month FROM dsw_per_lsm WHERE program = '$prog' AND month = '$month_q1'  AND year = '$year_q1'";
    $result_q_lsm1 = mysql_query($query_q_lsm1) or die(mysql_error());
    $query_q_lsm2 = "SELECT month FROM dsw_per_lsm WHERE program = '$prog' AND month = '$month_q2'  AND year = '$year_q2'";
    $result_q_lsm2 = mysql_query($query_q_lsm2) or die(mysql_error());
    $query_q_lsm3 = "SELECT month FROM dsw_per_lsm WHERE program = '$prog' AND month = '$month_q3'  AND year = '$year_q3'";
    $result_q_lsm3 = mysql_query($query_q_lsm3) or die(mysql_error());
    $value_q_lsm = mysql_num_rows($result_q_lsm1) + mysql_num_rows($result_q_lsm2) + mysql_num_rows($result_q_lsm3);
    if ($value_q_lsm == 0) {
        $disp_value_q_lsm = "";
    } else {
        $disp_value_q_lsm = $value_q_lsm;
    }

    $query_q_ver1 = "SELECT month FROM dsw_per_verification WHERE program = '$prog' AND month = '$month_q1'  AND year = '$year_q1'";
    $result_q_ver1 = mysql_query($query_q_ver1) or die(mysql_error());
    $query_q_ver2 = "SELECT month FROM dsw_per_verification WHERE program = '$prog' AND month = '$month_q2'  AND year = '$year_q2'";
    $result_q_ver2 = mysql_query($query_q_ver2) or die(mysql_error());
    $query_q_ver3 = "SELECT month FROM dsw_per_verification WHERE program = '$prog' AND month = '$month_q3'  AND year = '$year_q3'";
    $result_q_ver3 = mysql_query($query_q_ver3) or die(mysql_error());
    $value_q_ver = mysql_num_rows($result_q_ver1) + mysql_num_rows($result_q_ver2) + mysql_num_rows($result_q_ver3);
    if ($value_q_ver == 0) {
        $disp_value_q_ver = "";
    } else {
        $disp_value_q_ver = $value_q_ver;
    }

    $query_q_vcs1 = "SELECT month FROM dsw_per_vcs_attendees WHERE program = '$prog' AND month = '$month_q1'  AND year = '$year_q1'";
    $result_q_vcs1 = mysql_query($query_q_vcs1) or die(mysql_error());
    $query_q_vcs2 = "SELECT month FROM dsw_per_vcs_attendees WHERE program = '$prog' AND month = '$month_q2'  AND year = '$year_q2'";
    $result_q_vcs2 = mysql_query($query_q_vcs2) or die(mysql_error());
    $query_q_vcs3 = "SELECT month FROM dsw_per_vcs_attendees WHERE program = '$prog' AND month = '$month_q3'  AND year = '$year_q3'";
    $result_q_vcs3 = mysql_query($query_q_vcs3) or die(mysql_error());
    $value_q_vcs = mysql_num_rows($result_q_vcs1) + mysql_num_rows($result_q_vcs2) + mysql_num_rows($result_q_vcs3);
    if ($value_q_vcs == 0) {
        $disp_value_q_vcs = "";
    } else {
        $disp_value_q_vcs = $value_q_vcs;
    }

    $query_q_instal1 = "SELECT month FROM dsw_per_instalation WHERE program = '$prog' AND month = '$month_q1'  AND year = '$year_q1'";
    $result_q_instal1 = mysql_query($query_q_instal1) or die(mysql_error());
    $query_q_instal2 = "SELECT month FROM dsw_per_instalation WHERE program = '$prog' AND month = '$month_q2'  AND year = '$year_q2'";
    $result_q_instal2 = mysql_query($query_q_instal2) or die(mysql_error());
    $query_q_instal3 = "SELECT month FROM dsw_per_instalation WHERE program = '$prog' AND month = '$month_q3'  AND year = '$year_q3'";
    $result_q_instal3 = mysql_query($query_q_instal3) or die(mysql_error());
    $value_q_instal = mysql_num_rows($result_q_instal1) + mysql_num_rows($result_q_instal2) + mysql_num_rows($result_q_instal3);
    if ($value_q_instal == 0) {
        $disp_value_q_instal = "";
    } else {
        $disp_value_q_instal = $value_q_instal;
    }

    $query_q_cem1 = "SELECT month FROM dsw_per_cem_attendees WHERE program = '$prog' AND month = '$month_q1'  AND year = '$year_q1'";
    $result_q_cem1 = mysql_query($query_q_cem1) or die(mysql_error());
    $query_q_cem2 = "SELECT month FROM dsw_per_cem_attendees WHERE program = '$prog' AND month = '$month_q2'  AND year = '$year_q2'";
    $result_q_cem2 = mysql_query($query_q_cem2) or die(mysql_error());
    $query_q_cem3 = "SELECT month FROM dsw_per_cem_attendees WHERE program = '$prog' AND month = '$month_q3'  AND year = '$year_q3'";
    $result_q_cem3 = mysql_query($query_q_cem3) or die(mysql_error());
    $value_q_cem = mysql_num_rows($result_q_cem1) + mysql_num_rows($result_q_cem2) + mysql_num_rows($result_q_cem3);
    if ($value_q_cem == 0) {
        $disp_value_q_cem = "";
    } else {
        $disp_value_q_cem = $value_q_cem;
    }

    $query_q_chlorine11 = "SELECT month FROM dsw_per_chlorine WHERE program = '$prog' AND month = '$month_q1'  AND year = '$year_q1'";
    $result_q_chlorine11 = mysql_query($query_q_chlorine11) or die(mysql_error());
    $query_q_chlorine12 = "SELECT month FROM dsw_per_chlorine WHERE program = '$prog' AND month = '$month_q2'  AND year = '$year_q2'";
    $result_q_chlorine12 = mysql_query($query_q_chlorine12) or die(mysql_error());
    $query_q_chlorine13 = "SELECT month FROM dsw_per_chlorine WHERE program = '$prog' AND month = '$month_q3'  AND year = '$year_q3'";
    $result_q_chlorine13 = mysql_query($query_q_chlorine13) or die(mysql_error());    
    $value_q_chlorine = mysql_num_rows($result_q_chlorine11) + mysql_num_rows($result_q_chlorine12) + mysql_num_rows($result_q_chlorine13);
    if ($value_q_chlorine == 0) {
        $disp_value_q_chlorine = "";
    } else {
        $disp_value_q_chlorine = $value_q_chlorine;
    }

    //<!--================================ year reporting ==========================================-->                            
    $query_y_lsm = "SELECT month FROM dsw_per_lsm WHERE program = '$prog' AND year = '$year'";
    $result_y_lsm = mysql_query($query_y_lsm) or die(mysql_error());
    $value_y_lsm = mysql_num_rows($result_y_lsm);
    if ($value_y_lsm == 0) {
        $disp_value_y_lsm = "";
    } else {
        $disp_value_y_lsm = $value_y_lsm;
    }

    $query_y_ver = "SELECT month FROM dsw_per_verification WHERE program = '$prog' AND year = '$year'";
    $result_y_ver = mysql_query($query_y_ver) or die(mysql_error());
    $value_y_ver = mysql_num_rows($result_y_ver);
    if ($value_y_ver == 0) {
        $disp_value_y_ver = "";
    } else {
        $disp_value_y_ver = $value_y_ver;
    }

    $query_y_vcs = "SELECT month FROM dsw_per_vcs_attendees WHERE program = '$prog' AND year = '$year'";
    $result_y_vcs = mysql_query($query_y_vcs) or die(mysql_error());
    $value_y_vcs = mysql_num_rows($result_y_vcs);
    if ($value_y_vcs == 0) {
        $disp_value_y_vcs = "";
    } else {
        $disp_value_y_vcs = $value_y_vcs;
    }

    $query_y_instaslation = "SELECT month FROM dsw_per_instalation WHERE program = '$prog' AND year = '$year'";
    $result_y_instaslation = mysql_query($query_y_instaslation) or die(mysql_error());
    $value_y_instaslation = mysql_num_rows($result_y_instaslation);
    if ($value_y_instaslation == 0) {
        $disp_value_y_instaslation = "";
    } else {
        $disp_value_y_instaslation = $value_y_instaslation;
    }

    $query_y_cem = "SELECT month FROM dsw_per_cem_attendees WHERE program = '$prog' AND year = '$year'";
    $result_y_cem = mysql_query($query_y_cem) or die(mysql_error());
    $value_y_cem = mysql_num_rows($result_y_cem);
    if ($value_y_cem == 0) {
        $disp_value_y_cem = "";
    } else {
        $disp_value_y_cem = $value_y_cem;
    }

    $query_y_chlorine1 = "SELECT month FROM dsw_per_chlorine WHERE program = '$prog' AND year = '$year'";
    $result_y_chlorine1 = mysql_query($query_y_chlorine1) or die(mysql_error());
    $value_y_chlorine = mysql_num_rows($result_y_chlorine1);
    if ($value_y_chlorine == 0) {
        $disp_value_y_chlorine = "";
    } else {
        $disp_value_y_chlorine = $value_y_chlorine;
    }

    //<!--=====================================Cumulative========================================================-->

    $query_lsm = "SELECT month FROM dsw_per_lsm WHERE program = '$prog'";
    $result_lsm = mysql_query($query_lsm) or die(mysql_error());
    $value_lsm = mysql_num_rows($result_lsm);
    if ($value_lsm == 0) {
        $disp_value_lsm = "";
    } else {
        $disp_value_lsm = $value_lsm;
    }

    $query_ver = "SELECT month FROM dsw_per_verification WHERE program = '$prog'";
    $result_ver = mysql_query($query_ver) or die(mysql_error());
    $value_ver = mysql_num_rows($result_ver);
    if ($value_ver == 0) {
        $disp_value_ver = "";
    } else {
        $disp_value_ver = $value_ver;
    }

    $query_vcs = "SELECT month FROM dsw_per_vcs_attendees WHERE program = '$prog'";
    $result_vcs = mysql_query($query_vcs) or die(mysql_error());
    $value_vcs = mysql_num_rows($result_vcs);
    if ($value_vcs == 0) {
        $disp_value_vcs = "";
    } else {
        $disp_value_vcs = $value_vcs;
    }

    $query_instaslation = "SELECT month FROM dsw_per_instalation WHERE program = '$prog'";
    $result_instaslation = mysql_query($query_instaslation) or die(mysql_error());
    $value_instaslation = mysql_num_rows($result_instaslation);
    if ($value_instaslation == 0) {
        $disp_value_instaslation = "";
    } else {
        $disp_value_instaslation = $value_instaslation;
    }

    $query_cem = "SELECT month FROM dsw_per_cem_attendees WHERE program = '$prog'";
    $result_cem = mysql_query($query_cem) or die(mysql_error());
    $value_cem = mysql_num_rows($result_cem);
    if ($value_cem == 0) {
        $disp_value_cem = "";
    } else {
        $disp_value_cem = $value_cem;
    }

    $query_chlorine1 = "SELECT month FROM dsw_per_chlorine WHERE program = '$prog'";
    $result_chlorine1 = mysql_query($query_chlorine1) or die(mysql_error());
    $value_chlorine = mysql_num_rows($result_chlorine1);
    if ($value_chlorine == 0) {
        $disp_value_chlorine = "";
    } else {
        $disp_value_chlorine = $value_chlorine;
    }
    
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Meetings Table')
            ->setCellValue('A3', 'DSW Kenya monthly MLIS report')
            ->setCellValue('B3', 'Monthly reporting period: ' . $displ_month_year)
            ->setCellValue('H3', 'Quarterly reporting period: ' . $displ_month_year_q)
            ->setCellValue('N3', 'Year: ' . $year)
            ->setCellValue('T3', 'Cumulative')
            ->setCellValue('B4', 'LSMs held(#)')
            ->setCellValue('C4', 'WPs verified (#)')
            ->setCellValue('D4', 'VCSs held (#)')
            ->setCellValue('E4', 'CDSs installed (#)')
            ->setCellValue('F4', 'CEMs held (#)')
            ->setCellValue('G4', 'Deliveries (# visits)')
            ->setCellValue('H4', 'LSMs held(#)')
            ->setCellValue('I4', 'WPs verified (#)')
            ->setCellValue('J4', 'VCSs held (#)')
            ->setCellValue('K4', 'CDSs installed (#)')
            ->setCellValue('L4', 'CEMs held (#)')
            ->setCellValue('M4', 'Deliveries (# visits)')
            ->setCellValue('N4', 'LSMs held(#)')
            ->setCellValue('O4', 'WPs verified (#)')
            ->setCellValue('P4', 'VCSs held (#)')
            ->setCellValue('Q4', 'CDSs installed (#)')
            ->setCellValue('R4', 'CEMs held (#)')
            ->setCellValue('S4', 'Deliveries (# visits)')
            ->setCellValue('T4', 'LSMs held(#)')
            ->setCellValue('U4', 'WPs verified (#)')
            ->setCellValue('V4', 'VCSs held (#)')
            ->setCellValue('W4', 'CDSs installed (#)')
            ->setCellValue('X4', 'CEMs held (#)')
            ->setCellValue('Y4', 'Deliveries (# visits)')
            ->setCellValue('A' . $i, $prog)
            ->setCellValue('B' . $i, $disp_value_m_lsm)
            ->setCellValue('C' . $i, $disp_value_m_ver)
            ->setCellValue('D' . $i, $disp_value_m_vcs)
            ->setCellValue('E' . $i, $disp_value_m_instaslation)
            ->setCellValue('F' . $i, $disp_value_m_cem)
            ->setCellValue('G' . $i, $disp_value_m_chlorine)
            ->setCellValue('H' . $i, $disp_value_q_lsm)
            ->setCellValue('I' . $i, $disp_value_q_ver)
            ->setCellValue('J' . $i, $disp_value_q_vcs)
            ->setCellValue('K' . $i, $disp_value_q_instal)
            ->setCellValue('L' . $i, $disp_value_q_cem)
            ->setCellValue('M' . $i, $disp_value_q_chlorine)
            ->setCellValue('N' . $i, $disp_value_y_lsm)
            ->setCellValue('O' . $i, $disp_value_y_ver)
            ->setCellValue('P' . $i, $disp_value_y_vcs)
            ->setCellValue('Q' . $i, $disp_value_y_instaslation)
            ->setCellValue('R' . $i, $disp_value_y_cem)
            ->setCellValue('S' . $i, $disp_value_y_chlorine)
            ->setCellValue('T' . $i, $disp_value_lsm)
            ->setCellValue('U' . $i, $disp_value_ver)
            ->setCellValue('V' . $i, $disp_value_vcs)
            ->setCellValue('W' . $i, $disp_value_instaslation)
            ->setCellValue('X' . $i, $disp_value_cem)
            ->setCellValue('Y' . $i, $disp_value_chlorine);
    PHP_EOL;
    $i++;
}




// Rename worksheet
$today = date("F j-Y");
$objPHPExcel->getActiveSheet()->setTitle(' Meetings');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=" Meetings.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
