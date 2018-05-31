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

$path="../../";
$data ="NA";
include $path.'tcpdf/tcpdf.php';
require_once ($path.'includes/config.php');
include "queryFunctions.php";

// Include the main TCPDF library (search for installation path).
// require_once('tcpdf/examples/tcpdf_include.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {

	// Load table data from file
	public function LoadData($file) {
		// Read file lines
		$lines = file($file);
		$data = array();
		foreach($lines as $line) {
			$data[] = explode(';', chop($line));
		}
		return $data;
	}

	 //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'evidence-action.png';
        $this->Image($image_file, 15, 5, 28, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 15);
        // Title
        $this->Cell(110, 15, 'USAID REPORT KPI', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

	// Colored table
	public function ColoredTable($header,$datatext) {
		$data ="NA";

		$row1=number_format(num('school_id','a_bysch'));
		$row2=number_format(num('p_sch_id','p_bysch'));
		$row3=number_format(EstimatedTotalSTH());
		$row4=number_format(sumSTH());
		$row5=number_format(numDistinctPlain('school_id','attnt_bysch'));
		$row6=number_format(attntWithCriticalMaterials());
		$row7=number_format(numFlexible('school_id','attnt_bysch','attnt_total_poles','1'));
		$row8=number_format(numFlexible('attnt_id','attnt_bysch','attnt_total_drugs','1'));
		$row9=$data;
		$row10=$data;
		
		// Colors, line width and bold font
		// $this->SetFillColor(249, 113, 139);
		$this->SetFillColor(224, 103, 127);
		$this->SetTextColor(0);$this->SetTextColor(255);
		// $this->SetDrawColor(249, 113, 139);
		$this->SetDrawColor(211, 211, 211);
		$this->SetLineWidth(0.3);
		$this->SetFont('helvetica', 'B', 7);
		// Header
		$w = array(150, 35, 40, 45);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
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
		
		$this->SetFont('helvetica', '', 9);
		
		$this->cell($w[0], 6, 'No. of schools treated for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row1,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;
			
		$this->cell($w[0], 6, 'No. of schools targeted for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row2,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;
		$fill = 0;
			
		$this->cell($w[0], 6, 'Estimated target population of STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row3,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6, 'No. of  children dewormed for STH once','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row4,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;
		$fill = 0;

		$this->cell($w[0], 6, 'No. of schools attending teacher training','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row5,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6, 'No. of schools with critical materials present','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row6,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;
		$fill = 0;

		$this->cell($w[0], 6, 'No. of schools with poles','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row7,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6, 'No. of TTs with requiered drugs','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row8,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;
		$fill = 0;

		$this->cell($w[0], 6, 'No. of Gok district personnel at regional training','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row9,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6, 'No. of Gok divisional personnel at regional training','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row10,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;
		$fill = 0;



		$this->Cell(array_sum($w), 0, '', 'T');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 011');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 011', PDF_HEADER_STRING);

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
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

// column titles
$header = array('Indicato\n\ng', 'Total');

// data loading
$datatext = $pdf->LoadData($path.'tcpdf/examples/data/table_data_demo.txt');

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('USAID KPI REPORT.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
