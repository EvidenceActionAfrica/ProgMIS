<?php

//============================================================+
// File name   : example_011.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 011 for TCPDF class
//               Colored Table (very simple table)
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 */
$path = "../../";
$data = "NA";
include $path . 'tcpdf/tcpdf.php';
require_once ($path . 'includes/auth.php');
require_once ($path . 'includes/config.php');
require_once("includes/class.CountyEpxand.php");

// Include the main TCPDF library (search for installation path).
// require_once('tcpdf/examples/tcpdf_include.php');
// extend TCPF with custom functions
class MYPDF extends TCPDF {

    // Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach ($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES . 'evidence-action.png';
        $this->Image($image_file, 15, 5, 28, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 15);
        // Title
        $this->Cell(210, 25, 'COUNTY REPORT', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Colored table
    public function ColoredTable($header, $datatext) {
        // Colors, line width and bold font
        // $this->SetFillColor(249, 113, 139);
        $this->SetFillColor(224, 103, 127);
        $this->SetTextColor(0);
        // $this->SetDrawColor(249, 113, 139);
        $this->SetDrawColor(211, 211, 211);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B',7);
        // Header
        $w = array(25, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22);
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'L', 1);
        }
        $this->Ln();
        // Color and font restoration
        // $this->SetFillColor(224, 235, 255);
        $this->SetFillColor(247, 217, 223);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;

        $this->SetFont('helvetica', '', 7);

        $CountyExpand = new CountyExpand();
        $counties = $CountyExpand->getCounties();

        foreach ($counties as $key => $county) {

            $row1 = $county['county'];
            $row2 = number_format($CountyExpand->sum_simple('a_total_child', 'a_bysch', 'county_id', $county['county_id']));
            $row3 = CountyExpand::PERCENT(
                            $CountyExpand->percentageSimple(
                                    $CountyExpand->sumArgsByCounty(
                                            'a_bysch', $county['county_id'], 'county_id', 'a_ecd_total', 'a_trt_total'
                                    ), $CountyExpand->sumPlainByCounty(
                                            'a_total_child', 'a_bysch', 'county_id', $county['county_id']
                                    )
                            )
            );
            $row4 = CountyExpand::PERCENT($CountyExpand->percentageSum('a_u5_total', 'a_total_child', $county['county_id']));
            $row5 = CountyExpand::PERCENT($CountyExpand->percentageSum('a_2_18_total', 'a_total_child', $county['county_id']));
            $row6 = CountyExpand::PERCENT(
                            $CountyExpand->percentageSimple(
                                    $CountyExpand->sumArgsByCounty(
                                            'a_bysch', $county['county_id'], 'county_id', 'a_trt_total ', 'a_ecd_total'
                                    ), $CountyExpand->sumArgsByCountyP(
                                            'p_bysch', $county['county_id'], 'p_pri_enroll', 'p_ecd_enroll', 'p_ecd_sa_enroll'
                                    )
                            )
            );
            $row7 = CountyExpand::PERCENT(
                            $CountyExpand->percentageSimple(
                                    $CountyExpand->sumArgsByCounty(
                                            'a_bysch', $county['county_id'], 'county_id', 'ap_trt_total ', 'ap_ecd_total'
                                    ), $CountyExpand->sumArgsByCountyPShisto(
                                            'p_bysch', $county['county_id'], 'p_pri_enroll', 'p_ecd_enroll', 'p_ecd_sa_enroll'
                                    )
                            )
            );
            $row8 = number_format($CountyExpand->countPlainP('p_sch_id', 'p_bysch', $county['county_id']));
            $row9 = number_format($CountyExpand->numPlainByCounty('school_id', 'attnt_bysch', 'countyid', $county['county_id']));
            $row10 = number_format(($CountyExpand->attntWithCriticalMaterials1('school_id', $county['county_id']))+($CountyExpand->attntWithCriticalMaterials2('school_id', $county['county_id'])));
            $row11 = number_format($CountyExpand->numPlain('school_id', $county['county_id']));
            $row12 = number_format($CountyExpand->numPlainShisto('school_id', $county['county_id']));

            $this->cell($w[0], 6, $row1, 'LR', 0, 'L', $fill);
            $this->cell($w[1], 6, $row2, 'LR', 0, 'L', $fill);
            $this->cell($w[2], 6, $row3, 'LR', 0, 'L', $fill);
            $this->cell($w[3], 6, $row4, 'LR', 0, 'L', $fill);
            $this->cell($w[4], 6, $row5, 'LR', 0, 'L', $fill);
            $this->cell($w[5], 6, $row6, 'LR', 0, 'L', $fill);
            $this->cell($w[6], 6, $row7, 'LR', 0, 'L', $fill);
            $this->cell($w[7], 6, $row8, 'LR', 0, 'L', $fill);
            $this->cell($w[8], 6, $row9, 'LR', 0, 'L', $fill);
            $this->cell($w[9], 6, $row10, 'LR', 0, 'L', $fill);
            $this->cell($w[10], 6, $row11, 'LR', 0, 'L', $fill);
            $this->cell($w[11], 6, $row12, 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill;
        }

        // }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF County report');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 011', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage('L', 'A4');

// column titles
$header = array('County', '# children dewormed', '% Enrolled Trt', '% trt u5', '% trt non-enrolled',
    'trt Enrolled Alb', 'trt Enrolled PZQ',
    'Sch. planned', 'Sch. trained', 'Sch.critical material', 'Sch. trt ALB', 'Sch. trt PZQ');

// data loading
$datatext = $pdf->LoadData($path . 'tcpdf/examples/data/table_data_demo.txt');

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------
// close and output PDF document
$pdf->Output('County Report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
