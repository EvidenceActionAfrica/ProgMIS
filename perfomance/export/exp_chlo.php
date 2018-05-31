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
//$year = $_POST['rec_year'];
$country_val = $_POST['rec_country'];
//if ($year == 'All years') {
$i = 3;
$field = 'program';
$res = mysql_query("SELECT distinct $field FROM `dsw_per_chlorine`  WHERE country='$country_val'  ORDER BY program");
while ($row = mysql_fetch_array($res)) {
    $prog = $row["program"];
    $query_sum = "SELECT SUM(num_of_Deliveries)
                                AS _sum FROM dsw_per_chlorine WHERE program = '$prog'";
    $result_sum = mysql_query($query_sum) or die(mysql_error());
    $row_sum = mysql_fetch_assoc($result_sum);
    $_sum = $row_sum['_sum'];
    $total_del = number_format($_sum);

    $query_sum_num = "SELECT SUM(Jerrican_delivered)
                                AS _sum_num FROM dsw_per_chlorine WHERE program = '$prog'";
    $result_sum_num = mysql_query($query_sum_num) or die(mysql_error());
    $row_sum_num = mysql_fetch_assoc($result_sum_num);
    $_sum_num = $row_sum_num['_sum_num'];
    $total_num = number_format($_sum_num * 5);

    $query_aver = "SELECT AVG(avrg_30day_usage_litres)
                                AS _aver FROM dsw_per_chlorine WHERE program = '$prog' AND avrg_30day_usage_litres!=''";
    $result_aver = mysql_query($query_aver) or die(mysql_error());
    $row_aver = mysql_fetch_assoc($result_aver);
    $_aver = $row_aver['_aver'];
    $av_30 = round($_aver);
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Chlorine rates')
            ->setCellValue('A2', '')
            ->setCellValue('B2', 'Total Delivered (Litres)')
            ->setCellValue('C2', 'Total Number of deliveries')
            ->setCellValue('D2', 'Average 30days Chlorine Usage (Litres)')
            ->setCellValue('A' . $i, $prog)
            ->setCellValue('B' . $i, $total_del)
            ->setCellValue('C' . $i, $total_num)
            ->setCellValue('D' . $i, $av_30);
    PHP_EOL;
    $i++;
}
$query_sum = "SELECT SUM(num_of_Deliveries)
                                AS _sum FROM dsw_per_chlorine WHERE country='$country_val'";
$result_sum = mysql_query($query_sum) or die(mysql_error());
$row_sum = mysql_fetch_assoc($result_sum);
$_sum = $row_sum['_sum'];
$total_del = number_format($_sum);

$query_sum_num = "SELECT SUM(Jerrican_delivered)
                                AS _sum_num FROM dsw_per_chlorine WHERE country='$country_val'";
$result_sum_num = mysql_query($query_sum_num) or die(mysql_error());
$row_sum_num = mysql_fetch_assoc($result_sum_num);
$_sum_num = $row_sum_num['_sum_num'];
$total_num = number_format($_sum_num * 5);

$query_aver = "SELECT AVG(avrg_30day_usage_litres)
                                AS _aver FROM dsw_per_chlorine WHERE country='$country_val' AND avrg_30day_usage_litres!=''";
$result_aver = mysql_query($query_aver) or die(mysql_error());
$row_aver = mysql_fetch_assoc($result_aver);
$_aver = $row_aver['_aver'];
$av_30 = round($_aver);
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $i, 'Total')
        ->setCellValue('B' . $i, $total_del)
        ->setCellValue('C' . $i, $total_num)
        ->setCellValue('D' . $i, $av_30);
PHP_EOL;



// Rename worksheet
$today = date("F j-Y");
$objPHPExcel->getActiveSheet()->setTitle(' Chlorine rates');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=" Chlorine rates.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
