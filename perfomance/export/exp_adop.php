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

    $year_sub = "";
} else {
    $year_sub = "AND year ='$year'";
}
$i = 3;
$field = 'c803_tcr_reading';
$res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' $year_sub ORDER BY program");
while ($row = mysqli_fetch_assoc($res)) {
    $prog = $row["program"];
    $s = 'b';
    for ($value = 1; $value < 13; ++$value) {

        $query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '0' AND $field != '' $year_sub";
        $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
        $nume = mysqli_affected_rows($mysqli);

        $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '' $year_sub";
        $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
        $deno = mysqli_affected_rows($mysqli);
        if ($deno == null) {
            $data = "";
        } else {
            $ans = round(($nume / $deno), 2);
            $percent = $ans * 100;
            $data = $percent . "%";
        }


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'TCR Adoption (Total Chlorine Adoption')
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
    $query = "SELECT $field FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field != '0' AND $field != '' $year_sub";
    $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
    $nume = mysqli_affected_rows($mysqli);

    $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field != '' $year_sub";
    $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
    $deno = mysqli_affected_rows($mysqli);

    if ($deno == null) {
        $total_pro = "";
    } else {
        $ans = round(($nume / $deno), 2);
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
    $sumprod_a_n = 0;
    $nume_weit_sum = 0;
    $res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' $year_sub ORDER BY program");
    while ($row = mysqli_fetch_assoc($res)) {
        $prog = $row["program"];

        $query = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '0' AND $field != '' $year_sub";
        $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
        $nume = mysqli_affected_rows($mysqli);

        $query1 = "SELECT $field FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '' $year_sub";
        $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
        $deno = mysqli_affected_rows($mysqli);

        $query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '$prog' $year_sub ";
        $result_weit = mysqli_query($mysqli, $query_weit) or die(mysqli_query($mysqli));
        $row_weit = mysqli_fetch_assoc($result_weit);
        $nume_weit = $row_weit["sum_total"];
        $nume_weit_sum += $nume_weit;
        if ($deno == null) {
            $total_month = "";
        } else {
            $ans = $nume * 100 / $deno;
            $sumprod_a_n += $ans * $nume_weit;
        }
    }
    if ($nume_weit_sum == null) {
        $total_month = "";
    } else {
        $total_month = round(($sumprod_a_n / $nume_weit_sum), 0) . "%";
    }
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, 'Av./Month')
            ->setCellValue($ma1 . $i, $total_month);
    $ma1++;
}

$j = 3 + $i++;
$k = 1 + $j;
$dj = $j - 1;

$field2 = 'c806_fcr_reading';
$res2 = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' $year_sub ORDER BY program");
while ($row = mysqli_fetch_assoc($res2)) {
    $prog = $row["program"];
    $s = 'b';
    for ($value = 1; $value < 13; ++$value) {
        $query = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field2 != '0' AND $field2 != '' $year_sub";
        $result = mysqli_query($mysqli, $query) or die("<h1>Cannot get num of " . $field2 . "</h1>" . mysqli_query($mysqli));
        $nume = mysqli_affected_rows($mysqli);

        $query1 = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '' $year_sub";
        $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
        $deno = mysqli_affected_rows($mysqli);
        if ($deno == null) {
            $data = "";
        } else {
            $ans = round(($nume / $deno), 2);
            $percent = $ans * 100;
            $data = $percent . "%";
        }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $dj, 'FCR Adoption (Free Chlorine Adoption)')
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
    $query = "SELECT $field2 FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field2 != '0' AND $field2 != '' $year_sub";
    $result = mysqli_query($mysqli, $query) or die("<h1>Cannot get num of " . $field2 . "</h1>" . mysqli_query($mysqli));
    $nume = mysqli_affected_rows($mysqli);

    $query1 = "SELECT $field2 FROM dsw_per_adoption_rates WHERE program = '$prog' AND $field != '' $year_sub";
    $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
    $deno = mysqli_affected_rows($mysqli);

    if ($deno == null) {
        $total_pro2 = "";
    } else {
        $ans = round(($nume / $deno), 2);
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
    $sumprod_a_n = 0;
    $nume_weit_sum = 0;
    $res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_adoption_rates`  WHERE country='$country_val' $year_sub ORDER BY program");
    while ($row = mysqli_fetch_assoc($res)) {
        $prog = $row["program"];

        $query = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field2 != '0' AND $field2 != '' $year_sub";
        $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
        $nume = mysqli_affected_rows($mysqli);

        $query1 = "SELECT $field2 FROM dsw_per_adoption_rates WHERE month = '$value' AND program = '$prog' AND $field != '' $year_sub";
        $result1 = mysqli_query($mysqli, $query1) or die(mysqli_query($mysqli));
        $deno = mysqli_affected_rows($mysqli);

        $query_weit = "SELECT SUM(total_number) AS sum_total FROM dsw_per_waterpoint WHERE month = '$value' AND program = '$prog' $year_sub ";
        $result_weit = mysqli_query($mysqli, $query_weit) or die(mysqli_query($mysqli));
        $row_weit = mysqli_fetch_assoc($result_weit);
        $nume_weit = $row_weit["sum_total"];
        $nume_weit_sum += $nume_weit;

        if ($deno == null) {
            $total_month = "";
        } else {
            $ans = $nume * 100 / $deno;
            $sumprod_a_n += $ans * $nume_weit;
        }
    }
    if ($nume_weit_sum == null) {
        $total_month = "";
    } else {
        $total_month = round(($sumprod_a_n / $nume_weit_sum), 0) . "%";
    }
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $k, 'Av./Month')
            ->setCellValue($ma2 . $k, $total_month);
    $ma2++;
}


// Rename worksheet
$today = date("F j-Y");
$objPHPExcel->getActiveSheet()->setTitle(' Adopton Rates');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=" Adopton Rates.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;



