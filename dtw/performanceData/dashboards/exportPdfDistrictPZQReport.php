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
require_once("includes/class.ntd.php");

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
        $this->Cell(210, 25, 'DISTRICT PZQ REPORT', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
        $w = array(30, 32, 28, 28, 28, 28, 28, 28, 28);
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

        $ntd = new ntd;

$data = $ntd->getAll();
$dataPZQ = $ntd->getAllPZQ();

        foreach ($dataPZQ as $key => $value) {

            $row1 = $ntd->getDistrictCounty($value['district_id'],'name');
            $row2 = $ntd->getDistName($value['district_id']);
            $row3 = $ntd::notavailable($value['schools_treated']);
            $row4 = $ntd::notavailable($value['over_15_treated']);
            $row5 = $ntd::notavailable($value['over_15_male_treated']);
            $row6 = $ntd::notavailable($value['over_15_female_treated']);
            $row7 = $ntd::notavailable($value['adults_treated']); 
            $row8 = $ntd::notavailable($value['target_sac']); 
            $row9 = $ntd::notavailable($value['target_adult']);

            $this->cell($w[0], 6, $row1, 'LR', 0, 'L', $fill);
            $this->cell($w[1], 6, $row2, 'LR', 0, 'L', $fill);
            $this->cell($w[2], 6, $row3, 'LR', 0, 'L', $fill);
            $this->cell($w[3], 6, $row4, 'LR', 0, 'L', $fill);
            $this->cell($w[4], 6, $row5, 'LR', 0, 'L', $fill);
            $this->cell($w[5], 6, $row6, 'LR', 0, 'L', $fill);
            $this->cell($w[6], 6, $row7, 'LR', 0, 'L', $fill);
            $this->cell($w[7], 6, $row8, 'LR', 0, 'L', $fill);
            $this->cell($w[8], 6, $row9, 'LR', 0, 'L', $fill);
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
$pdf->SetTitle('TCPDF District PZQ');
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
$header = array('County', 'District Name', 'Schools Treated', '15+ Treated',
    '15+ Male trt', '15+ Female trt', 'Adults trt', 'Target SAC','Target Adult');

// data loading
$datatext = $pdf->LoadData($path . 'tcpdf/examples/data/table_data_demo.txt');

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------
// close and output PDF document
$pdf->Output('District ALB Report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
