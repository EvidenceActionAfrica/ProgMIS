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
if ($year == 'All years') {
    $i = 3;
    $res = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' ORDER BY program");
    while ($row = mysql_fetch_array($res)) {
        $prog = $row["program"];
        $s = 'b';
        for ($value = 1; $value < 13; ++$value) {

            $field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
                'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
            $sum = 0;
            foreach ($field_ar as $field) {
                $query = "SELECT $field FROM dsw_per_adoption_rates WHERE  month = '$value' AND program = '$prog' AND $field = '1'";
                $result = mysql_query($query) or die(mysql_error());
                $sum_row = mysql_num_rows($result);

                $sum += $sum_row;
            }

            $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog'";
            $result_deno = mysql_query($query_deno) or die(mysql_error());
            $row_deno = mysql_fetch_assoc($result_deno);
            $deno = $row_deno['denominator'];
            if ($deno == null) {
                $data = "";
            } else {
                $ans = round(($sum / $deno), 2);
                $percent = $ans * 100;
                $data = $percent . "%";
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Diarrhea Rates last 48hours')
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
                    ->setCellValue('N2', 'Av./Off.')
                    ->setCellValue('A' . $i, $prog)
                    ->setCellValue($s . $i, $data);

            ++$s . PHP_EOL;
        }
        $field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
            'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }

        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE program = '$prog'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];

        if ($deno == null) {
            $total_pro = "";
        } else {
            $ans = round(($sum / $deno), 2);
            $percent = $ans * 100;
            $total_pro = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('N' . $i, $total_pro);
        PHP_EOL;
        $i++;
    }
    $ma1 = 'b';
    for ($value = 1; $value < 13; ++$value) {
        $field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
            'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }

        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE month = '$value'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];
        if ($deno == null) {
            $total_month = "";
        } else {
            $ans = round(($sum / $deno), 2);
            $percent = $ans * 100;
            $total_month = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, 'Av./Month')
                ->setCellValue($ma1 . $i, $total_month);
        $ma1++;
    }


    $j = 3 + $i++;
    $k = 1 + $j;
    $dj = $j - 1;

    $res2 = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' ORDER BY program");
    while ($row = mysql_fetch_array($res2)) {
        $prog = $row["program"];
        $s = 'b';
        for ($value = 1; $value < 13; ++$value) {
            $field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
                'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
            $sum = 0;
            foreach ($field_ar as $field) {
                $query = "SELECT $field FROM dsw_per_adoption_rates WHERE  month = '$value' AND program = '$prog' AND $field = '1'";
                $result = mysql_query($query) or die(mysql_error());
                $sum_row = mysql_num_rows($result);

                $sum += $sum_row;
            }
            $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog'";
            $result_deno = mysql_query($query_deno) or die(mysql_error());
            $row_deno = mysql_fetch_assoc($result_deno);
            $deno = $row_deno['denominator'];
            if ($deno == null) {
                $data = "";
            } else {
                $ans = round(($sum / $deno), 2);
                $percent = $ans * 100;
                $data = $percent . "%";
            }

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $dj, 'Diarrhea Rates Past 2 Weeks')
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
                    ->setCellValue('N' . $j, 'Av./Off.')
                    ->setCellValue('A' . $k, $prog)
                    ->setCellValue($s . $k, $data);

            ++$s . PHP_EOL;
        }

        $field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
            'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }
        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE  program = '$prog'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];

        if ($deno == null) {
            $total_pro2 = "";
        } else {
            $ans = round(($sum / $deno), 2);
            $percent = $ans * 100;
            $total_pro2 = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('N' . $k, $total_pro2);
        PHP_EOL;
        $k++;
    }
    $ma2 = 'b';
    for ($value = 1; $value < 13; ++$value) {
        $field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
            'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }

        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE month = '$value'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];

        if ($deno == null) {
            echo "";
        } else {
            $ans = round(($sum / $deno), 2);
            $percent = $ans * 100;
            $total_month = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $k, 'Av./Month')
                ->setCellValue($ma2 . $k, $total_month);
        $ma2++;
    }
} else {
    $i = 3;
    $res = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' ORDER BY program");
    while ($row = mysql_fetch_array($res)) {
        $prog = $row["program"];
        $s = 'b';
        for ($value = 1; $value < 13; ++$value) {

            $field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
                'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
            $sum = 0;
            foreach ($field_ar as $field) {
                $query = "SELECT $field FROM dsw_per_adoption_rates WHERE year ='$year' AND  month = '$value' AND program = '$prog' AND $field = '1'";
                $result = mysql_query($query) or die(mysql_error());
                $sum_row = mysql_num_rows($result);

                $sum += $sum_row;
            }

            $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE year ='$year' AND month = '$value' AND program = '$prog'";
            $result_deno = mysql_query($query_deno) or die(mysql_error());
            $row_deno = mysql_fetch_assoc($result_deno);
            $deno = $row_deno['denominator'];
            if ($deno == null) {
                $data = "";
            } else {
                $ans = round(($sum / $deno), 2);
                $percent = $ans * 100;
                $data = $percent . "%";
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Diarrhea Rates last 48hours')
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
                    ->setCellValue('N2', 'Av./Off.')
                    ->setCellValue('A' . $i, $prog)
                    ->setCellValue($s . $i, $data);

            ++$s . PHP_EOL;
        }
        $field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
            'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_adoption_rates WHERE year ='$year' AND program = '$prog' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }

        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE year ='$year' AND program = '$prog'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];

        if ($deno == null) {
            $total_pro = "";
        } else {
            $ans = round(($sum / $deno), 2);
            $percent = $ans * 100;
            $total_pro = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('N' . $i, $total_pro);
        PHP_EOL;
        $i++;
    }
    $ma1 = 'b';
    for ($value = 1; $value < 13; ++$value) {
        $field_ar = array('c312a_chld1_drhea_today', 'c312b_chld2_drhea_today', 'c312c_chld3_drhea_today', 'c312d_chld4_drhea_today',
            'c312e_chld5_drhea_today', 'c312f_chld6_drhea_today', 'c312g_chld7_drhea_today', 'c312h_chld8_drhea_today');
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_adoption_rates WHERE year ='$year' AND month = '$value' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }

        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE year ='$year' AND month = '$value'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];
        if ($deno == null) {
            $total_month = "";
        } else {
            $ans = round(($sum / $deno), 2);
            $percent = $ans * 100;
            $total_month = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, 'Av./Month')
                ->setCellValue($ma1 . $i, $total_month);
        $ma1++;
    }


    $j = 3 + $i++;
    $k = 1 + $j;
    $dj = $j - 1;

    $res2 = mysql_query("SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' ORDER BY program");
    while ($row = mysql_fetch_array($res2)) {
        $prog = $row["program"];
        $s = 'b';
        for ($value = 1; $value < 13; ++$value) {
            $field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
                'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
            $sum = 0;
            foreach ($field_ar as $field) {
                $query = "SELECT $field FROM dsw_per_adoption_rates WHERE year ='$year' AND  month = '$value' AND program = '$prog' AND $field = '1'";
                $result = mysql_query($query) or die(mysql_error());
                $sum_row = mysql_num_rows($result);

                $sum += $sum_row;
            }
            $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE year ='$year' AND month = '$value' AND program = '$prog'";
            $result_deno = mysql_query($query_deno) or die(mysql_error());
            $row_deno = mysql_fetch_assoc($result_deno);
            $deno = $row_deno['denominator'];
            if ($deno == null) {
                $data = "";
            } else {
                $ans = round(($sum / $deno), 2);
                $percent = $ans * 100;
                $data = $percent . "%";
            }

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $dj, 'Diarrhea Rates Past 2 Weeks')
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
                    ->setCellValue('N' . $j, 'Av./Off.')
                    ->setCellValue('A' . $k, $prog)
                    ->setCellValue($s . $k, $data);

            ++$s . PHP_EOL;
        }

        $field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
            'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_adoption_rates WHERE year ='$year' AND program = '$prog' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }
        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE year ='$year' AND  program = '$prog'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];

        if ($deno == null) {
            $total_pro2 = "";
        } else {
            $ans = round(($sum / $deno), 2);
            $percent = $ans * 100;
            $total_pro2 = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('N' . $k, $total_pro2);
        PHP_EOL;
        $k++;
    }
    $ma2 = 'b';
    for ($value = 1; $value < 13; ++$value) {
        $field_ar = array('c311a_chld1_drhea_past2wks', 'c311b_chld2_drhea_past2wks', 'c311c_chld3_drhea_past2wks', 'c311d_chld4_drhea_past2wks',
            'c311e_chld5_drhea_past2wks', 'c311f_chld6_drhea_past2wks', 'c311g_chld7_drhea_past2wks', 'c311h_chld8_drhea_past2wks');
        $sum = 0;
        foreach ($field_ar as $field) {
            $query = "SELECT $field FROM dsw_per_adoption_rates WHERE year ='$year' AND month = '$value' AND $field = '1'";
            $result = mysql_query($query) or die(mysql_error());
            $sum_row = mysql_num_rows($result);

            $sum += $sum_row;
        }

        $query_deno = "SELECT SUM(c305b_hhold_child) AS denominator FROM dsw_per_adoption_rates WHERE year ='$year' AND month = '$value'";
        $result_deno = mysql_query($query_deno) or die(mysql_error());
        $row_deno = mysql_fetch_assoc($result_deno);
        $deno = $row_deno['denominator'];

        if ($deno == null) {
            echo "";
        } else {
            $ans = round(($sum / $deno), 2);
            $percent = $ans * 100;
            $total_month = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $k, 'Av./Month')
                ->setCellValue($ma2 . $k, $total_month);
        $ma2++;
    }
}


// Rename worksheet
$today = date("F j-Y");
$objPHPExcel->getActiveSheet()->setTitle(' Diarrhea Rates');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=" Diarrhea Rates.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
