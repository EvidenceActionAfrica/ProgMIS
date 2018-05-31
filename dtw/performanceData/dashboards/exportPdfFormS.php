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
$path="../../";
include $path.'tcpdf/tcpdf.php';
include $path.'includes/config.php';
// include "dashFormSFunctions.php";
include $path."queryFunctions.php";

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
        $this->Cell(110, 15, 'Form S dashboard', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

	// Colored table
	public function ColoredTable($header,$data) {
		$data ="NA";
$row1=numDistinctPlain('s_district_id','s_bysch');
$row2=numDistinctPlain('s_prog_sch_id','s_bysch');
$row3=sumDewormedPlusAudultsSbysch('STH');
$row4=sumChildrenSbysch('STH');
$row5=number_format(childAverage('s_bysch','s_district_id'),2, '.', '');
$row6=$data;
$row7=$data;
$row8=number_format(addValues(sumArgs('s_bysch','s_ecd_treated_male','s_ecd_treated_male'),sumPriEnrolledSbysch('STH'))) ;
$row9=number_format(sumArgs('s_bysch','s_ecd_treated_male','s_ecd_treated_male'));
$row10=number_format(sumPlain('s_ecd_treated_male','s_bysch'));
$row11=number_format(sumPlain('s_ecd_treated_female','s_bysch'));
$row12=number_format(sumPriChildrenSbysch('STH'));
$row13=number_format(sumMaleAbove6Sbysch('STH'));
$row14=number_format(sumFemaleAbove6Sbysch('STH'));
$row15=number_format(sumPriRegisteredSbysch('STH'));
$row16=number_format(sumPriGenderRegisteredSbysch('male'));
$row17=number_format(sumPriGenderRegisteredSbysch('female'));
$row18=number_format(sumNonEnrolledSbysch('STH'));
$row19=number_format(sumArgs('s_bysch','s_nonenroll_2_5yrs_m','s_nonenroll_2_5yrs_f'));
$row20=number_format(sumPlain('s_nonenroll_2_5yrs_m','s_bysch'));
$row21=number_format(sumPlain('s_nonenroll_2_5yrs_f','s_bysch'));
$row22=number_format(sumPriChildrenSbysch('STH'));
$row23=number_format(sumMaleAbove6Sbysch('STH'));
$row24=number_format(sumFemaleAbove6Sbysch('STH'));
$row25=number_format(sumAdultsFormS('STH'));
$row26=number_format(sumTabletsSpoilt('STH'));
$row27=number_format(sumPlain('s_alb_received','s_bysch'));
$row28=number_format(sumPlain('s_alb_use','s_bysch'));
$row29=number_format(sumPlain('s_alb_returned','s_bysch'));
$row30=number_format(divisionValues(sumPlain('s_alb_use','s_bysch'),sumPlain('s_alb_received','s_bysch')),2,'.','');
$row31=number_format(sumPLain('s_spoilt_total','s_bysch') / sumPLain('s_alb_received','s_bysch'),2,'.','');
$row32=numDistinctFlexible('s_district_id','s_bysch','sp_attached','Yes') ;
$row33=numDistinctFlexible('s_prog_sch_id','s_bysch','sp_attached','Yes') ;
$row34=sumDewormedPlusAudultsSbysch('SCHISTO');
$row35=sumChildrenSbysch('SHISTO');
$row36=number_format(addValues(sumPriEnrolledSbysch('SHISTO'),sumArgs('s_bysch','s_ecd_treated_male','s_ecd_treated_female')));
$row37=number_format(sumArgs('s_bysch','sp_ecd_m','sp_ecd_f'));
$row38=number_format(sumPriChildrenSbysch('SHISTO'));
$row39=number_format(sumMaleAbove6Sbysch('SHISTO'));
$row40=number_format(sumFemaleAbove6Sbysch('SHISTO'));
$row41=number_format(sumPriRegisteredSbysch('SHISTO'));
$row42=number_format(sumNonEnrolledSbysch('SHISTO'));
$row43=number_format(sumAdultsFormS('SHISTO'));
$row44=number_format(sumTabletsSpoilt('SHISTO'));
$row45=number_format(sumPlain('sp_pzq_received','s_bysch'));
$row46=number_format(sumplain('sp_pzq_use','s_bysch'));
$row47=number_format(sumPlain('sp_pzq_returned','s_bysch'));


		// Colors, line width and bold font
		// $this->SetFillColor(249, 113, 139);
		$this->SetFillColor(224, 103, 127);
		$this->SetTextColor(0);
		// $this->SetDrawColor(249, 113, 139);
		$this->SetDrawColor(211, 211, 211);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
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
	
			// set this b
		// $fill = 0;old
			$this->SetFont('helvetica', 'BI', 12);
			$this->cell($w[0], 6, 'Coverage Indicators', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6, '', 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->SetFont('helvetica', '', 9);
			$this->cell($w[0], 6, 'No. of districts covered', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row1, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of schools covered', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row2, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. dewormed (children + adults)', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row3, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row4, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'Average children dewormed per district', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row5, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'Range of district coverage (max district average)', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row6, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'Range of district coverage (min district average)', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row7, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of Enrolled Primary + Enrolled ECD children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row8, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of ECD children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row9, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of ECD Male children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row10, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of ECD Female children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row11, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of Primary children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row12, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of Primary Male children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row13, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of Primary Female children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row14, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of Primary children registered', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row15, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of Male Primary children registered', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row16, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of Female Primary children registered', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row17, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of Non Enrolled children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row18, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of children aged 2-5 years dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row19, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of male children aged 2-5 years dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row20, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of female children aged 2-5 years dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row21, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of children aged 6+ years dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row22, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of male children aged 6+ years dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row23, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of female children aged 6+ years dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row24, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of adults dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row25, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;


			$this->SetFont('helvetica', 'BI', 12);
			$this->cell($w[0], 6, 'Supply Estimation Indicators', 'LR', 0,'L',$fill);
			$this->cell($w[0], 6, '', 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->SetFont('helvetica','',10);
			$this->cell($w[0], 6, 'No. of tablets spoilt', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row26, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;



			$this->cell($w[0], 6, 'No. of tablets supplied', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row27, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of tablets used (includes tablets given to children and adults and tablets spoilt)', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row28, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of tablets returned', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row29, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'Ratio of tablets used to supplied', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row30, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'Ratio of tablets spolit to tablets supplied', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row31, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->SetFont('helvetica', 'BI', 12);
			$this->cell($w[0], 6, 'SCHISTO Indicators', 'LR', 0,'L',$fill);
			$this->cell($w[0], 6, ' ', 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;


			$this->SetFont('helvetica','', 10);
			$this->cell($w[0], 6, 'No. of districts covered', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row32, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of schools covered', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row33, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. dewormed (children + adults)', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row34, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row35, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of Enrolled Primary + Enrolled ECD children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row36, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of ECD children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row37, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of Primary children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row38, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of Primary Male children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row39, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of Primary Female children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row40, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of Primary children registered', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row41, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of Non Enrolled children dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row42, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of adults dewormed', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row43, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of tablets spoilt', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row44, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of tablets supplied', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row45, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;

			$this->cell($w[0], 6, 'No. of tablets used (includes tablets given to children and adults and tablets spoilt)', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row46, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill=!$fill;

			$this->cell($w[0], 6, 'No. of tablets returned', 'LR', 0,'L',$fill);
			$this->cell($w[1], 6,$row47, 'LR', 0,'L',$fill);
			$this->Ln();
			$fill = 0;


			



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
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 011', PDF_HEADER_STRING);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

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
$data = $pdf->LoadData('tcpdf/examples/data/table_data_demo.txt');

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('example_011.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
