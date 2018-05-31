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


$datas ="NA";

include "../../dashFormSFunctions.php";

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

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

	// Colored table
	public function ColoredTable($header,$data) {
		$placeholder ="NA";
		// Colors, line width and bold font
		$this->SetFillColor(255, 0, 0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		// Header
		$w = array(130, 35, 40, 45);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = 0;
		// foreach($data as $row) {
		// 	$this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
		// 	$this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
		// 	$this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
		// 	$this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
		// 	$this->Ln();
		// 	$fill=!$fill;

			$this->Cell($w[0], 6, 'Indicator', 'LR', 0, 'L', $fill);
			$this->Cell($w[1], 6, numOfDistrictsCovered(), 'LR', 0, 'L', $fill);
			$this->Ln();
			$fill=!$fill;
			$this->Cell($w[0], 6, 'Indicator', 'LR', 0, 'L', $fill);
			$this->Cell($w[1], 6, 'Total', 'LR', 0, 'L', $fill);
			$this->Ln();
			$fill=!$fill;
$this->cell($w[0], 6, 'Indicator', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, 'Total', 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Coverage Indicators', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, '', 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of districts covered', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, numOfDistrictsCovered(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of schools covered', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, numOfSchoolsCovered(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number dewormed (children + adults)', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, numOfDewormed(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, numOfDewormedChildren(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Average children dewormed per district', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, averageChildrenDewormedPerDistrict(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Range of district coverage (max district average)', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Range of district coverage (min district average)', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of Enrolled Primary plus Enrolled ECD children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, numPrimaryAndEcdChildrenDewormed(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of ECD children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, ecdChildrenDewormed('ecd_treated_children_total'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of ECD Male children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, ecdChildrenDewormed('ecd_treated_male'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of ECD Female children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, ecdChildrenDewormed('ecd_treated_female'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of Primary children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, primaryChildrenDewormed('number_treated_total'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of Primary Male children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, primaryChildrenDewormed('number_treated_male'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of Primary Female children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, primaryChildrenDewormed('number_treated_female'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of Primary children registered', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, primaryChildrenDewormed('number_in_register_class_total'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of Male Primary children registered', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, primaryChildrenDewormed('number_in_register_male'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of Female Primary children registered', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, primaryChildrenDewormed('number_in_register_female'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of Non Enrolled children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, nonEnrolledChildrenDewormed('non_enrolled_total'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of children aged 2-5 years dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, allNonEnrolled2_5ChildrenDewormed(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of male children aged 2-5 years dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, nonEnrolledChildrenDewormed('years_6_10_male'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of female children aged 2-5 years dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, nonEnrolledChildrenDewormed('years_6_10_male'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of children aged 6+ years dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, nonEnrolledOver6(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of male children aged 6+ years dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, nonEnrolledOver6Male(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of female children aged 6+ years dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, nonEnrolledOver6Female(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of adults dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, adultsDewormed(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Supply Estimation Indicators', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, '', 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of tablets spoilt', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, numSpoiltTablets(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of tablets supplied', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, ecdChildrenDewormed('albendazole_recieved'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of tablets used (includes tablets given to children and adults and tablets spoilt', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, tabletsUsed(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of tablets returned', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, ecdChildrenDewormed('albendazole_returned'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Ratio of tablets used to supplied', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, ratioSuippliedToSpoiltTablets(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Ratio of tablets spolit to tablets supplied', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, ratioSpoiltToSuppliedTablets(), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'SCHISTO Indicators', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of districts covered', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, num('district','form_ap'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of schools covered', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, num('school_name','form_ap'), 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. dewormed (children + adults)', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of Enrolled Primary + Enrolled ECD children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of ECD children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of Primary children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of Primary Male children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of Primary Female children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of Primary children registered', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of Non Enrolled children dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of adults dewormed', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of tablets spoilt', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of tablets supplied', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'No. of tablets used (includes tablets given to children and adults and tablets spoilt', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

$this->cell($w[0], 6, 'Number of tablets returned', 'LR', 0,'L',$fill);
$this->cell($w[1], 6, $placeholder, 'LR', 0,'L',$fill);
$this->Ln();

			



		// }
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
$header = array('Indicator', 'Total');

// data loading
$data = $pdf->LoadData('data/table_data_demo.txt');

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('example_011.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
