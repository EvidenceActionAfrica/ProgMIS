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
$country_val = $_POST['rec_country'];
$quarter = $_POST['rec_quarter'];

if ($year == 'All years') {
    $i = 3;
    $res = mysql_query("SELECT distinct program FROM `dsw_per_cem_attendees` WHERE country='$country_val' ORDER BY program");
    while ($row = mysql_fetch_array($res)) {
        $prog = $row["program"];
        $field = 'cem301_attendees_total';
        $query = "SELECT $field FROM dsw_per_cem_attendees WHERE program = '$prog'";
        $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
        $deno = mysql_num_rows($result);
        $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE program = '$prog'";
        $result1 = mysql_query($query1) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());
        $row2 = mysql_fetch_assoc($result1);
        $nume = $row2['denominator'];
        if ($deno == 0) {
            $data = "";
        } else {
            $ans = round(($nume / $deno), 0);
            $data = $ans;
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Attendees Table')
                ->setCellValue('A2', 'Program')
                ->setCellValue('B2', 'cem301 Attendees')
                ->setCellValue('A' . $i, $prog)
                ->setCellValue('B' . $i, $data);
        PHP_EOL;

        $i++;
    }

    $field = 'cem301_attendees_total';
    $query = "SELECT $field FROM dsw_per_cem_attendees WHERE country='$country_val'";
    $result = mysql_query($query) or die(mysql_error());
    $deno = mysql_num_rows($result);
    $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE country='$country_val'";
    $result1 = mysql_query($query1) or die(mysql_error());
    $row2 = mysql_fetch_assoc($result1);
    $nume = $row2['denominator'];
    if ($deno == 0) {
        $prog_av = "";
    } else {
        $ans = round(($nume / $deno), 0);
        $prog_av = $ans;
    }
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, 'Average')
            ->setCellValue('B' . $i, $prog_av);


    $prog_sum2 = 0;
    $av_div_prog2 = 0;
    $j = 3;
    $res1 = mysql_query("SELECT distinct program FROM `dsw_per_vcs_attendees` WHERE country='$country_val' ORDER BY program");
    while ($row = mysql_fetch_array($res1)) {
        $prog = $row["program"];
        $field = 'vcs201_attendees_total';
        $query = "SELECT $field FROM dsw_per_vcs_attendees WHERE program = '$prog'";
        $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
        $deno = mysql_num_rows($result);
        $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_vcs_attendees WHERE program = '$prog'";
        $result1 = mysql_query($query1) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());
        $row2 = mysql_fetch_assoc($result1);
        $nume = $row2['denominator'];
        if ($deno == 0) {
            $vdata = "";
        } else {
            $ans = round(($nume / $deno), 0);
            $vdata = $ans;
            $prog_sum2 += $ans;
            $av_div_prog2++;
        }

        $field2 = 'vcs201_attendees_total';
        $query2 = "SELECT $field2 FROM dsw_per_vcs_attendees WHERE country='$country_val'";
        $result2 = mysql_query($query2) or die(mysql_error());
        $deno2 = mysql_num_rows($result2);
        $query3 = "SELECT SUM($field2) AS denominator FROM dsw_per_vcs_attendees WHERE country='$country_val'";
        $result3 = mysql_query($query3) or die(mysql_error());
        $row3 = mysql_fetch_assoc($result3);
        $nume3 = $row3['denominator'];
        if ($deno2 == 0) {
            $vprog_av = "";
        } else {
            $ans2 = round(($nume3 / $deno2), 0);
            $vprog_av = $ans2;
        }

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D2', 'Program')
                ->setCellValue('E2', 'vcs201 Attendees')
                ->setCellValue('D' . $j, $prog)
                ->setCellValue('E' . $j, $vdata);
        PHP_EOL;

        $j++;
    }
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D' . $j, 'Average')
            ->setCellValue('E' . $j, $vprog_av);
}



//==================================first if =================================
else {
    if ($quarter == 'All quarter') {
        $i = 3;
        $res = mysql_query("SELECT distinct program FROM `dsw_per_cem_attendees` WHERE country='$country_val' ORDER BY program");
        while ($row = mysql_fetch_array($res)) {
            $prog = $row["program"];
            $field = 'cem301_attendees_total';
            $query = "SELECT $field FROM dsw_per_cem_attendees WHERE program = '$prog' AND year = '$year'";
            $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
            $deno = mysql_num_rows($result);
            $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE program = '$prog' AND year = '$year'";
            $result1 = mysql_query($query1) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());
            $row2 = mysql_fetch_assoc($result1);
            $nume = $row2['denominator'];
            if ($deno == 0) {
                $data = "";
            } else {
                $ans = round(($nume / $deno), 0);
                $data = $ans;
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Attendees Table')
                    ->setCellValue('A2', 'Program')
                    ->setCellValue('B2', 'cem301 Attendees')
                    ->setCellValue('A' . $i, $prog)
                    ->setCellValue('B' . $i, $data);
            PHP_EOL;

            $i++;
        }

        $field = 'cem301_attendees_total';
        $query = "SELECT $field FROM dsw_per_cem_attendees WHERE country='$country_val' AND year = '$year'";
        $result = mysql_query($query) or die(mysql_error());
        $deno = mysql_num_rows($result);
        $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE country='$country_val' AND year = '$year'";
        $result1 = mysql_query($query1) or die(mysql_error());
        $row2 = mysql_fetch_assoc($result1);
        $nume = $row2['denominator'];
        if ($deno == 0) {
            $prog_av = "";
        } else {
            $ans = round(($nume / $deno), 0);
            $prog_av = $ans;
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, 'Average')
                ->setCellValue('B' . $i, $prog_av);


        $prog_sum2 = 0;
        $av_div_prog2 = 0;
        $j = 3;
        $res1 = mysql_query("SELECT distinct program FROM `dsw_per_vcs_attendees` WHERE country='$country_val' ORDER BY program");
        while ($row = mysql_fetch_array($res1)) {
            $prog = $row["program"];
            $field = 'vcs201_attendees_total';
            $query = "SELECT $field FROM dsw_per_vcs_attendees WHERE program = '$prog' AND year = '$year'";
            $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
            $deno = mysql_num_rows($result);
            $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_vcs_attendees WHERE program = '$prog' AND year = '$year'";
            $result1 = mysql_query($query1) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());
            $row2 = mysql_fetch_assoc($result1);
            $nume = $row2['denominator'];
            if ($deno == 0) {
                $vdata = "";
            } else {
                $ans = round(($nume / $deno), 0);
                $vdata = $ans;
                $prog_sum2 += $ans;
                $av_div_prog2++;
            }

            $field2 = 'vcs201_attendees_total';
            $query2 = "SELECT $field2 FROM dsw_per_vcs_attendees WHERE country='$country_val' AND year = '$year'";
            $result2 = mysql_query($query2) or die(mysql_error());
            $deno2 = mysql_num_rows($result2);
            $query3 = "SELECT SUM($field2) AS denominator FROM dsw_per_vcs_attendees WHERE country='$country_val' AND year = '$year'";
            $result3 = mysql_query($query3) or die(mysql_error());
            $row3 = mysql_fetch_assoc($result3);
            $nume3 = $row3['denominator'];
            if ($deno2 == 0) {
                $vprog_av = "";
            } else {
                $ans2 = round(($nume3 / $deno2), 0);
                $vprog_av = $ans2;
            }

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D2', 'Program')
                    ->setCellValue('E2', 'vcs201 Attendees')
                    ->setCellValue('D' . $j, $prog)
                    ->setCellValue('E' . $j, $vdata);
            PHP_EOL;

            $j++;
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D' . $j, 'Average')
                ->setCellValue('E' . $j, $vprog_av);
    }


    //==================================Second if ================================= 
    else {
        $i = 3;
        if ($quarter == '1st_quarter') {
            $quarter_val = array(1, 2, 3);
        } elseif ($quarter == '2nd_quarter') {
            $quarter_val = array(4, 5, 6);
        } elseif ($quarter == '3rd_quarter') {
            $quarter_val = array(7, 8, 9);
        } elseif ($quarter == '4th_quarter') {
            $quarter_val = array(10, 11, 12);
        }
        $res = mysql_query("SELECT distinct program FROM `dsw_per_cem_attendees` WHERE country='$country_val' ORDER BY program");
        while ($row = mysql_fetch_array($res)) {
            $prog = $row["program"];
            $sum_nume = 0;
            $sum_deno = 0;
            for ($x = 0; $x < 3; $x++) {

                $field = 'cem301_attendees_total';
                $query = "SELECT $field FROM dsw_per_cem_attendees WHERE program = '$prog' AND year = '$year' AND month = '$quarter_val[$x]'";
                $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
                $deno = mysql_num_rows($result);
                $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE program = '$prog' AND year = '$year' AND month = '$quarter_val[$x]'";
                $result1 = mysql_query($query1) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());
                $row2 = mysql_fetch_assoc($result1);
                $nume = $row2['denominator'];
                $sum_nume += $nume;
                $sum_deno += $deno;
            }
            if ($sum_deno == 0) {
                $data = "";
            } else {
                $ans = round(($sum_nume / $sum_deno), 0);
                $data = $ans;
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Attendees Table')
                    ->setCellValue('A2', 'Program')
                    ->setCellValue('B2', 'cem301 Attendees')
                    ->setCellValue('A' . $i, $prog)
                    ->setCellValue('B' . $i, $data);
            PHP_EOL;

            $i++;
        }

        $sum_nume = 0;
        $sum_deno = 0;
        for ($x = 0; $x < 3; $x++) {
            $field = 'cem301_attendees_total';
            $query = "SELECT $field FROM dsw_per_cem_attendees WHERE country='$country_val' AND year = '$year' AND month = '$quarter_val[$x]'";
            $result = mysql_query($query) or die(mysql_error());
            $deno = mysql_num_rows($result);
            $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE country='$country_val' AND year = '$year' AND month = '$quarter_val[$x]'";
            $result1 = mysql_query($query1) or die(mysql_error());
            $row2 = mysql_fetch_assoc($result1);
            $nume = $row2['denominator'];
            $sum_nume += $nume;
            $sum_deno += $deno;
        }
        if ($sum_deno == 0) {
            $prog_av = "";
        } else {
            $ans = round(($sum_nume / $sum_deno), 0);
            $prog_av = $ans;
        }

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, 'Average')
                ->setCellValue('B' . $i, $prog_av);


        $prog_sum2 = 0;
        $av_div_prog2 = 0;
        $j = 3;
        $res1 = mysql_query("SELECT distinct program FROM `dsw_per_vcs_attendees` WHERE country='$country_val' ORDER BY program");
        while ($row = mysql_fetch_array($res1)) {
            $prog = $row["program"];
            $field = 'vcs201_attendees_total';
            $sum_nume = 0;
            $sum_deno = 0;
            for ($x = 0; $x < 3; $x++) {
                $field = 'vcs201_attendees_total';
                $query = "SELECT $field FROM dsw_per_vcs_attendees WHERE program = '$prog' AND year = '$year' AND month = '$quarter_val[$x]'";
                $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
                $deno = mysql_num_rows($result);
                $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_vcs_attendees WHERE program = '$prog' AND year = '$year' AND month = '$quarter_val[$x]'";
                $result1 = mysql_query($query1) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());
                $row2 = mysql_fetch_assoc($result1);
                $nume = $row2['denominator'];
                $sum_nume += $nume;
                $sum_deno += $deno;
            }
            if ($sum_deno == 0) {
                $vdata = "";
            } else {
                $ans = round(($sum_nume / $sum_deno), 0);
                $vdata = $ans;
            }

            $sum_nume2 = 0;
            $sum_deno2 = 0;
            for ($x = 0; $x < 3; $x++) {
                $field2 = 'vcs201_attendees_total';
                $query2 = "SELECT $field2 FROM dsw_per_vcs_attendees WHERE country='$country_val' AND year = '$year' AND month = '$quarter_val[$x]'";
                $result2 = mysql_query($query2) or die(mysql_error());
                $deno2 = mysql_num_rows($result2);
                $query3 = "SELECT SUM($field2) AS denominator FROM dsw_per_vcs_attendees WHERE country='$country_val' AND year = '$year' AND month = '$quarter_val[$x]'";
                $result3 = mysql_query($query3) or die(mysql_error());
                $row3 = mysql_fetch_assoc($result3);
                $nume3 = $row3['denominator'];
                $sum_nume2 += $nume3;
                $sum_deno2 += $deno2;
            }
            if ($sum_deno2 == 0) {
                $vprog_av = "";
            } else {
                $ans = round(($sum_nume2 / $sum_deno2), 0);
                $vprog_av = $ans;
            }

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D2', 'Program')
                    ->setCellValue('E2', 'vcs201 Attendees')
                    ->setCellValue('D' . $j, $prog)
                    ->setCellValue('E' . $j, $vdata);
            PHP_EOL;

            $j++;
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D' . $j, 'Average')
                ->setCellValue('E' . $j, $vprog_av);
    }
}

// Rename worksheet
$today = date("F j-Y");
$objPHPExcel->getActiveSheet()->setTitle('Cem & Vcs Attendees');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=" Cem Vcs Attendees.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;



