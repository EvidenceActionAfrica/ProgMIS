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
$i = 3;
$res2 = mysql_query("SELECT distinct program FROM `dsw_per_diarrhea_rates` ORDER BY program");
while ($row = mysql_fetch_array($res2)) {
    $prog = $row["program"];
    $s = 'b';
    for ($value = 1; $value < 13; ++$value) {
        $field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
            'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_diarrhea_rates WHERE  month = '$value' AND program = '$prog' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }

        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_diarrhea_rates WHERE month = '$value' AND program = '$prog'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];

        if ($deno == null) {
            $data = "";
        } else {
            $ans = round(($sum / $deno), 3);
            $percent = $ans * 100;
            $data = $percent . "%";
        }



        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Diarrhea Rates Today')
                ->setCellValue('A2', '')
                ->setCellValue('B2', 'Jan')
                ->setCellValue('C2', 'Feb')
                ->setCellValue('D2', 'Mar')
                ->setCellValue('E2', 'Apr')
                ->setCellValue('F2', 'May')
                ->setCellValue('G2', 'Jun')
                ->setCellValue('H2', 'Jul')
                ->setCellValue('I2', 'Aug')
                ->setCellValue('J2', 'Sep')
                ->setCellValue('K2', 'Oct')
                ->setCellValue('L2', 'Nov')
                ->setCellValue('M2', 'Dec')
                ->setCellValue('A' . $i, $prog)
                ->setCellValue($s . $i, $data);

        ++$s . PHP_EOL;
    }
    $i++;
}

$j = 2 + $i++;
$k = 1 + $j;
$dj = $j - 1;

$res3 = mysql_query("SELECT distinct program FROM `dsw_per_diarrhea_rates` ORDER BY program");
while ($row = mysql_fetch_array($res3)) {
    $s = 'b';
    $prog = $row["program"];
    for ($value = 1; $value < 13; ++$value) {
        $field_ar = array('c313a_chld1_drhea_ystrday', 'c313b_chld2_drhea_ystrday', 'c313c_chld3_drhea_ystrday', 'c313d_chld4_drhea_ystrday',
            'c313e_chld5_drhea_ystrday', 'c313f_chld6_drhea_ystrday', 'c313g_chld7_drhea_ystrday', 'c313h_chld8_drhea_ystrday');
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_diarrhea_rates WHERE  month = '$value' AND program = '$prog' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }

        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_diarrhea_rates WHERE month = '$value' AND program = '$prog'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];

        if ($deno == null) {
            $data = "";
        } else {
            $ans = round(($sum / $deno), 3);
            $percent = $ans * 100;
            $data = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $dj, 'Diarrhea Rates Yesterday')
                ->setCellValue('A' . $j, '')
                ->setCellValue('B' . $j, 'Jan')
                ->setCellValue('C' . $j, 'Feb')
                ->setCellValue('D' . $j, 'Mar')
                ->setCellValue('E' . $j, 'Apr')
                ->setCellValue('F' . $j, 'May')
                ->setCellValue('G' . $j, 'Jun')
                ->setCellValue('H' . $j, 'Jul')
                ->setCellValue('I' . $j, 'Aug')
                ->setCellValue('J' . $j, 'Sep')
                ->setCellValue('K' . $j, 'Oct')
                ->setCellValue('L' . $j, 'Nov')
                ->setCellValue('M' . $j, 'Dec')
                ->setCellValue('A' . $k, $prog)
                ->setCellValue($s . $k, $data);

        ++$s . PHP_EOL;
    }
    $k++;
}

$l = 2 + $k++;
$m = 1 + $l;
$dl = $l - 1;

$res4 = mysql_query("SELECT distinct program FROM `dsw_per_diarrhea_rates` ORDER BY program");
while ($row = mysql_fetch_array($res4)) {
    $s = 'b';
    $prog = $row["program"];
    for ($value = 1; $value < 13; ++$value) {
        $field_ar = array('c314a_chld1_drhea_bfoystrday', 'c314b_chld2_drhea_bfoystrday', 'c314c_chld3_drhea_bfoystrday', 'c314d_chld4_drhea_bfoystrday',
            'c314e_chld5_drhea_bfoystrday', 'c314f_chld6_drhea_bfoystrday', 'c314g_chld7_drhea_bfoystrday', 'c314h_chld8_drhea_bfoystrday');        
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_diarrhea_rates WHERE  month = '$value' AND program = '$prog' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }
        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_diarrhea_rates WHERE month = '$value' AND program = '$prog'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];

        if ($deno == null) {
            $data = "";
        } else {
            $ans = round(($sum / $deno), 3);
            $percent = $ans * 100;
            $data = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $dl, 'Diarrhea Rates Before Yesterday')
                ->setCellValue('A' . $l, '')
                ->setCellValue('B' . $l, 'Jan')
                ->setCellValue('C' . $l, 'Feb')
                ->setCellValue('D' . $l, 'Mar')
                ->setCellValue('E' . $l, 'Apr')
                ->setCellValue('F' . $l, 'May')
                ->setCellValue('G' . $l, 'Jun')
                ->setCellValue('H' . $l, 'Jul')
                ->setCellValue('I' . $l, 'Aug')
                ->setCellValue('J' . $l, 'Sep')
                ->setCellValue('K' . $l, 'Oct')
                ->setCellValue('L' . $l, 'Nov')
                ->setCellValue('M' . $l, 'Dec')
                ->setCellValue('A' . $m, $prog)
                ->setCellValue($s . $m, $data);

        ++$s . PHP_EOL;
    }
    $m++;
}

$n = 2 + $m++;
$o = 1 + $n;
$dn = $n - 1;

$res5 = mysql_query("SELECT distinct program FROM `dsw_per_diarrhea_rates` ORDER BY program");
while ($row = mysql_fetch_array($res5)) {
    $s = 'b';
    $prog = $row["program"];
    for ($value = 1; $value < 13; ++$value) {
        $field_ar = array('c315a_chld1_drhea_pastwk', 'c315b_chld2_drhea_pastwk', 'c315c_chld3_drhea_pastwk', 'c315d_chld4_drhea_pastwk',
            'c315e_chld5_drhea_pastwk', 'c315f_chld6_drhea_pastwk', 'c315g_chld7_drhea_pastwk', 'c315h_chld8_drhea_pastwk');
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_diarrhea_rates WHERE  month = '$value' AND program = '$prog' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }

        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_diarrhea_rates WHERE month = '$value' AND program = '$prog'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];

        if ($deno == null) {
            $data = "";
        } else {
            $ans = round(($sum / $deno), 3);
            $percent = $ans * 100;
            $data = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $dn, 'Diarrhea Rates Past Week')
                ->setCellValue('A' . $n, '')
                ->setCellValue('B' . $n, 'Jan')
                ->setCellValue('C' . $n, 'Feb')
                ->setCellValue('D' . $n, 'Mar')
                ->setCellValue('E' . $n, 'Apr')
                ->setCellValue('F' . $n, 'May')
                ->setCellValue('G' . $n, 'Jun')
                ->setCellValue('H' . $n, 'Jul')
                ->setCellValue('I' . $n, 'Aug')
                ->setCellValue('J' . $n, 'Sep')
                ->setCellValue('K' . $n, 'Oct')
                ->setCellValue('L' . $n, 'Nov')
                ->setCellValue('M' . $n, 'Dec')
                ->setCellValue('A' . $o, $prog)
                ->setCellValue($s . $o, $data);

        ++$s . PHP_EOL;
    }
    $o++;
}

$p = 2 + $o++;
$q = 1 + $p;
$dp = $p - 1;

$res1 = mysql_query("SELECT distinct program FROM `dsw_per_diarrhea_rates` ORDER BY program");
while ($row = mysql_fetch_array($res1)) {
    $s = 'b';
    $prog = $row["program"];
    for ($value = 1; $value < 13; ++$value) {
        $field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
            'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_diarrhea_rates WHERE  month = '$value' AND program = '$prog' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }
        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_diarrhea_rates WHERE month = '$value' AND program = '$prog'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];

        if ($deno == null) {
            $data = "";
        } else {
            $ans = round(($sum / $deno), 3);
            $percent = $ans * 100;
            $data = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $dp, 'Diarrhea Rates Past 2 Weeks')
                ->setCellValue('A' . $p, '')
                ->setCellValue('B' . $p, 'Jan')
                ->setCellValue('C' . $p, 'Feb')
                ->setCellValue('D' . $p, 'Mar')
                ->setCellValue('E' . $p, 'Apr')
                ->setCellValue('F' . $p, 'May')
                ->setCellValue('G' . $p, 'Jun')
                ->setCellValue('H' . $p, 'Jul')
                ->setCellValue('I' . $p, 'Aug')
                ->setCellValue('J' . $p, 'Sep')
                ->setCellValue('K' . $p, 'Oct')
                ->setCellValue('L' . $p, 'Nov')
                ->setCellValue('M' . $p, 'Dec')
                ->setCellValue('A' . $p, $prog)
                ->setCellValue($s . $q, $data);

        ++$s . PHP_EOL;
    }
    $q++;
}

// Rename worksheet
$today = date("F j-Y");
$objPHPExcel->getActiveSheet()->setTitle('Diarrhea Rates');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Diarrhea Rates.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
