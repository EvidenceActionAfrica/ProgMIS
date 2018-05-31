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
$i = 0;
$field = 'program';
$res = mysql_query("SELECT distinct $field FROM `dsw_per_verification`  WHERE country='$country_val' ORDER BY program");
while ($row = mysql_fetch_array($res)) {
    $j=$i*2+3;
    $k=$i*2+4;
    $prog = $row["program"];

    $query = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' ";
    $result = mysql_query($query) or die(mysql_error());
    $num = mysql_num_rows($result);

    $query_fail = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND pass_fail = '0'";
    $result_fail = mysql_query($query_fail) or die(mysql_error());
    $num_fail = mysql_num_rows($result_fail);
    $num_fail_num = round(($num_fail / $num * 100), 0) . "%";

    $query_pass = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND pass_fail = '1'";
    $result_pass = mysql_query($query_pass) or die(mysql_error());
    $num_pass = mysql_num_rows($result_pass);
    $num_pass_num = round(($num_pass / $num * 100), 0) . "%";

    $query_flow_rate = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND t301b_wpt_flow_rate_slow= '0'";
    $result_flow_rate = mysql_query($query_flow_rate) or die(mysql_error());
    $num_flow_rate = mysql_num_rows($result_flow_rate);
    $num_flow_rate_num = round(($num_flow_rate / $num * 100), 0) . "%";

    $query_land_sup = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND (t302_landowner_personality= '0' OR 
                                (t302a_rep_WSB_talkedto='1' AND t302b_rep_WSB_accepted_disp='0'))AND t301b_wpt_flow_rate_slow!= '0'";
    $result_land_sup = mysql_query($query_land_sup) or die(mysql_error());
    $num_land_sup = mysql_num_rows($result_land_sup);
    $num_land_sup_num = round(($num_land_sup / $num * 100), 0) . "%";

    $query_drink_W = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND t310_wpt_drinking_water = '0' AND t302_landowner_personality!= '0'  AND t301b_wpt_flow_rate_slow!= '0'";
    $result_drink_W = mysql_query($query_drink_W) or die(mysql_error());
    $num_drink_W = mysql_num_rows($result_drink_W);
    $num_drink_W_num = round(($num_drink_W / $num * 100), 0) . "%";

    $query_turb = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND (t303b_turbitube_100ntu='0' OR t303_turbidity_wet='1' OR t304_turbidity_dry='1')
                                    AND t310_wpt_drinking_water != '0' AND t302_landowner_personality!= '0'  AND t301b_wpt_flow_rate_slow!= '0'";
    $result_turb = mysql_query($query_turb) or die(mysql_error());
    $num_turb = mysql_num_rows($result_turb);
    $num_turb_num = round(($num_turb / $num * 100), 0) . "%";

    $query_no_month = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND t305b_flow_how_many_months < 9 AND t305b_flow_how_many_months != ''
                                    AND t310_wpt_drinking_water != '0' AND t302_landowner_personality!= '0'  AND t301b_wpt_flow_rate_slow!= '0'
                                     AND (t303b_turbitube_100ntu!='0' AND t303_turbidity_wet!='1' AND t304_turbidity_dry!='1')";
    $result_no_month = mysql_query($query_no_month) or die(mysql_error());
    $num_no_month = mysql_num_rows($result_no_month);
    $num_no_month_num = round(($num_no_month / $num * 100), 0) . "%";

    $query_avg_user = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND avg_users < 10 AND avg_users !=''
                                    AND t310_wpt_drinking_water != '0' AND t302_landowner_personality!= '0'  AND t301b_wpt_flow_rate_slow!= '0'
                                    AND (t303b_turbitube_100ntu!='0' AND t303_turbidity_wet!='1' AND t304_turbidity_dry!='1')
                                     AND (t305b_flow_how_many_months >= 9  OR t305b_flow_how_many_months = '')";
    $result_avg_user = mysql_query($query_avg_user) or die(mysql_error());
    $num_avg_user = mysql_num_rows($result_avg_user);
    $num_avg_user_num = round(($num_avg_user / $num * 100), 0) . "%";

    $query_wpt_pass = "SELECT $field FROM dsw_per_verification WHERE program = '$prog' AND (t311_wpt_pass='0' OR t311_wpt_pass='-999' OR t311_wpt_pass='999')
                                AND t310_wpt_drinking_water != '0' AND t302_landowner_personality!= '0'  AND t301b_wpt_flow_rate_slow!= '0'
                                AND (t303b_turbitube_100ntu!='0' AND t303_turbidity_wet!='1' AND t304_turbidity_dry!='1')
                                AND (t305b_flow_how_many_months >= 9  OR t305b_flow_how_many_months = '')";
    $result_wpt_pass = mysql_query($query_wpt_pass) or die(mysql_error());
    $num_wpt_pass = mysql_num_rows($result_wpt_pass);
    $num_wpt_pass_num = round(($num_wpt_pass / $num * 100), 0) . "%";

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Verification Pass Rate')
            ->setCellValue('B2', 'Wpt visited')
            ->setCellValue('C2', 'Wpt failed/ %age')
            ->setCellValue('D2', 'Wpt passed/ %age')
            ->setCellValue('E2', 'Fail flow rate/ %age')
            ->setCellValue('F2', 'Fail lando. support/ %age')
            ->setCellValue('G2', 'Fail not drink water/ %age')
            ->setCellValue('H2', 'Fail turbidity/ %age')
            ->setCellValue('I2', 'Fail num months/ %age')
            ->setCellValue('J2', 'Fail num hholds/ %age')
            ->setCellValue('K2', 'Fail other/ %age')
            ->setCellValue('A' . $j, $prog)
            ->setCellValue('B' . $j, $num)
            ->setCellValue('C' . $j, $num_fail)
            ->setCellValue('C' . $k, $num_fail_num)
            ->setCellValue('D' . $j, $num_pass)
            ->setCellValue('D' . $k, $num_pass_num)
            ->setCellValue('E' . $j, $num_flow_rate)
            ->setCellValue('E' . $k, $num_flow_rate_num)
            ->setCellValue('F' . $j, $num_land_sup)
            ->setCellValue('F' . $k, $num_land_sup_num)
            ->setCellValue('G' . $j, $num_drink_W)
            ->setCellValue('G' . $k, $num_drink_W_num)
            ->setCellValue('H' . $j, $num_turb)
            ->setCellValue('H' . $k, $num_turb_num)
            ->setCellValue('I' . $j, $num_no_month)
            ->setCellValue('I' . $k, $num_no_month_num)
            ->setCellValue('J' . $j, $num_avg_user)
            ->setCellValue('J' . $k, $num_avg_user_num)
            ->setCellValue('K' . $j, $num_wpt_pass)
            ->setCellValue('K' . $k, $num_wpt_pass_num);
    PHP_EOL;
    $i++;
}




// Rename worksheet
$today = date("F j-Y");
$objPHPExcel->getActiveSheet()->setTitle('Verification Pass Rate');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Verification Pass Rate.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
