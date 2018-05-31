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
$res = mysql_query("SELECT distinct program FROM `dsw_per_cem_attendees` ORDER BY program");
while ($row = mysql_fetch_array($res)) {
    $prog = $row["program"];
    $s = 'b';
    $field_ar = array('cem301_attendees_total', 'cem302a_attendees_female', 'cem302b_attendees_male', 'cem303a_attendees_over16', 'cem303b_attendees_under17');
    foreach ($field_ar as $field) {
        $query = "SELECT $field FROM dsw_per_cem_attendees WHERE program = '$prog'";
        $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
        $deno = mysql_num_rows($result);
        $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_cem_attendees WHERE program = '$prog'";
        $result1 = mysql_query($query1) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());
        $row2 = mysql_fetch_assoc($result1);
        $nume = $row2['denominator'];
        if ($nume == 0) {
            $data = "";
        } else {
            $ans = round(($nume / $deno), 1);
            $data = $ans;
        }


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'CEM Attendees')
                ->setCellValue('A2', '')
                ->setCellValue('B2', 'cem301 Attendees Total')
                ->setCellValue('C2', 'cem302a Attendees Female')
                ->setCellValue('D2', 'cem302b Attendees Male')
                ->setCellValue('E2', 'cem303a Attendees Over-16')
                ->setCellValue('F2', 'cem303b Attendees Under-17')
                ->setCellValue('A' . $i, $prog)
                ->setCellValue($s . $i, $data);

        ++$s . PHP_EOL;
    }
    $i++;
}

$j = 2 + $i++;
$k = 1 + $j;
$dj = $j - 1;

$res1 = mysql_query("SELECT distinct program FROM `dsw_per_vcs_attendees` ORDER BY program");
                while ($row = mysql_fetch_array($res1)) {
                    $s = 'b';
                    $prog = $row["program"]; 
                        $field_ar = array('vcs201_attendees_total', 'vcs202a_attendees_female', 'vcs202b_attendees_male', 'vcs203a_attendees_over16', 'vcs203b_attendees_under17');
                        foreach ($field_ar as $field) {
                                $query = "SELECT $field FROM dsw_per_vcs_attendees WHERE program = '$prog'";
                                $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
                                $deno = mysql_num_rows($result);
                                $query1 = "SELECT SUM($field) AS denominator FROM dsw_per_vcs_attendees WHERE program = '$prog'";
                                $result1 = mysql_query($query1) or die("<h1>cannot get count of" . $field . "</h1>" . mysql_error());
                                $row2 = mysql_fetch_assoc($result1);
                                $nume = $row2['denominator'];
                                if ($nume == 0) {
                                    $data = "";
                                } else {
                                    $ans = round(($nume / $deno), 1);
                                    $data = $ans;
                                }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $dj, 'VCS Attendees')
                ->setCellValue('A' . $j, '')
                ->setCellValue('B' . $j, 'vcs201 Attendees Total')
                ->setCellValue('C' . $j, 'vcs202a Attendees Female')
                ->setCellValue('D' . $j, 'vcs202b Attendees Male')
                ->setCellValue('E' . $j, 'vcs203a Attendees Over-16')
                ->setCellValue('F' . $j, 'vcs203b Attendees Under-17')
                ->setCellValue('A' . $k, $prog)
                ->setCellValue($s . $k, $data);

        ++$s . PHP_EOL;
    }
    $k++;
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
