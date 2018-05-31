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


$data ="NA";
$path="../../";
include $path.'tcpdf/tcpdf.php';
include $path.'includes/config.php';
// include the functions file
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
        $this->Cell(110, 15, 'ATTNT dashboard', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }


	// Colored table
	public function ColoredTable($header,$datatext) {
		$data ="NA";

		$row1=numDistinctPlain('attnt_district_id','attnt_bysch');
		$row2=numDistinctPlain('attnt_id','attnt_bysch');
		$row3=numDistinctFlexible('attnt_id','attnt_bysch','attnt_sth','1');
		$row4=numDistinctFlexible('attnt_id','attnt_bysch','attnt_schisto','1');
		$row5=numAttntFlex('attnt_id','attnt_alb_tt','0','attnt_pzq_tt','0','attnt_sth','1');
		$row6=numAttntFlex('attnt_id','attnt_alb_tt','0','attnt_pzq_tt','0','attnt_schisto','1');
		$row7=numAttntFlex2('attnt_id','attnt_alb_tt','0','attnt_pzq_tt','0');
		$row8=numAttntFlex('attnt_id','attnt_alb_tt','0', 'attnt_pzq_tt','1', 'attnt_sth','1');
		$row9=numAttntFlex('attnt_id','attnt_alb_tt','0','attnt_pzq_tt','1','attnt_schisto','1');
		$row10=numAttntFlex2('attnt_id','attnt_alb_tt','0','attnt_pzq_tt','1');
		$row11=numAttntFlex('attnt_id','attnt_alb_tt','1','attnt_pzq_tt','0','attnt_sth','1');
		$row12=numAttntFlex('attnt_id','attnt_alb_tt','1','attnt_pzq_tt','0','attnt_schisto','1');
		$row13=numAttntFlex2('attnt_id','attnt_alb_tt','1','attnt_pzq_tt','0');
		$row14=numAttntFlex('attnt_id','attnt_alb_tt','1','attnt_pzq_tt','1','attnt_sth','1');
		$row15=numAttntFlex('attnt_id','attnt_alb_tt','1','attnt_pzq_tt','1','attnt_schisto','1');
		$row16=numAttntFlex2('attnt_id','attnt_alb_tt','1','attnt_pzq_tt','1');
		$row17=number_format($row17=remove_comma($row11)+remove_comma($row15));
		$row18=number_format($row18=remove_comma($row5)+remove_comma($row6)+remove_comma($row9)+remove_comma($row12));
		$row19=numDistinctPlain('school_id','attnt_bysch');
		$row20=numDistinctFlexible('school_id','attnt_bysch','attnt_sth','1');
		$row21=numDistinctFlexible('school_id','attnt_bysch','attnt_schisto','1');
		$row22=numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','0','attnt_total_forms','0','attnt_sch_treatment','0');
		$row23=numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','0','attnt_total_forms','0','attnt_sch_treatment','1');
		$row24=numAttntFlex('school_id','attnt_total_drugs','0','attnt_total_poles','0','attnt_total_forms','0');
		$row25=number_format(numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','0','attnt_total_forms','1','attnt_sch_treatment','0'));
		$row26=number_format(numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','0','attnt_total_forms','1','attnt_sch_treatment','1'));
		$row27=number_format(numAttntFlex('school_id','attnt_total_drugs','0','attnt_total_poles','0','attnt_total_forms','1'));
		$row28=number_format(numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','1','attnt_total_forms','0','attnt_sch_treatment','0'));
		$row29=number_format(numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','1','attnt_total_forms','0','attnt_sch_treatment','1'));
		$row30=number_format(numAttntFlex('school_id','attnt_total_drugs','0','attnt_total_poles','1','attnt_total_forms','0'));
		$row31=number_format(numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','1','attnt_total_forms','1','attnt_sch_treatment','0'));
		$row32=number_format(numAttntFlex4('school_id','attnt_total_drugs','0','attnt_total_poles','1','attnt_total_forms','1','attnt_sch_treatment','Treating for Bilharzia'));
		$row33=number_format(numAttntFlex('school_id','attnt_total_drugs','0','attnt_total_poles','1','attnt_total_forms','1'));
		$row34=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','0','attnt_total_forms','0','attnt_sch_treatment','0'));
		$row35=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','0','attnt_total_forms','0','attnt_sch_treatment','Treating for Bilharzia'));
		$row36=number_format(numAttntFlex('school_id','attnt_total_drugs','1','attnt_total_poles','0','attnt_total_forms','0'));
		$row37=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','0','attnt_total_forms','1','attnt_sch_treatment','0'));
		$row38=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','0','attnt_total_forms','1','attnt_sch_treatment','Treating for Bilharzia'));
		$row39=number_format(numAttntFlex('school_id','attnt_total_drugs','1','attnt_total_poles','0','attnt_total_forms','1'));
		$row40=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','0','attnt_sch_treatment','0'));
		$row41=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','0','attnt_sch_treatment','Treating for Bilharzia'));
		$row42=number_format(numAttntFlex('school_id','attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','0'));
		$row43=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','1','attnt_sch_treatment','0'));
		$row44=number_format(numAttntFlex4('school_id','attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','1','attnt_sch_treatment','Treating for Bilharzia'));
		$row45=number_format(numAttntFlex('school_id','attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','1'));
		$row46=number_format($row46=remove_comma($row37)+remove_comma($row44));
		$row47=number_format($row47=remove_comma($row24) +remove_comma($row27)+remove_comma($row30) +remove_comma($row33)+remove_comma($row36)+remove_comma($row38)+remove_comma($row42));


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
		
			

			
		$this->SetFont('helvetica', '', 9);
		$this->cell($w[0], 6,'No. of districts covered','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row1,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of TTs','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row2,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of TTs for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row3,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of TTs for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row4,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of TTs with no drugs - for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row5,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of TTs with no drugs - for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row6,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of TTs with no drugs - All','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row7,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of TTs with PZQ only - for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row8,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of TTs with PZQ only - for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row9,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of TTs with PZQ only - All','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row10,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of TTs with ALB only - for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row11,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of TTs with ALB only - for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row12,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of TTs with ALB only - All','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row13,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of TTs with both drugs - for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row14,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of TTs with both drugs - for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row15,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of TTs with both drugs - All','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row16,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of TTs with drugs present','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row17,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of TTs with drugs missing','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row18,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools covered','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row19,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools covered for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row20,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools covered for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row21,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with nothing distributed - for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row22,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with nothing distributed - for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row23,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with nothing distributed - All','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row24,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with forms only distributed - for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row25,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with forms only distributed - for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row26,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with forms only distributed - All','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row27,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with poles only distributed - for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row28,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with poles only distributed - for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row29,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with poles only distributed - All','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row30,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with poles and forms distributed - for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row31,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with poles and forms distributed - for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row32,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with poles and forms distributed - All','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row33,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with drugs only distributed - for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row34,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with drugs only distributed - for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row35,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with drugs only distributed - All','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row36,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with drugs and forms distributed - for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row37,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with drugs and forms distributed - for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row38,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with drugs and forms distributed - All','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row39,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with drugs and poles distributed - for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row40,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with drugs and poles distributed - for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row41,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with drugs and poles distributed - All','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row42,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with drugs, poles and forms distributed - for STH only','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row43,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with drugs, poles and forms distributed - for STH and Schisto','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row44,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with drugs, poles and forms distributed - All','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row45,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

		$this->cell($w[0], 6,'No. of schools with critical materials present','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row46,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill = 0;

		$this->cell($w[0], 6,'No. of schools with critical materials missing','LR', 0, 'L',$fill);
		$this->cell($w[1], 6, $row47,'LR', 0, 'L', $fill);
		$this->Ln();
		$fill=!$fill;

 

 


			



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
$datatext = $pdf->LoadData($path.'tcpdf/examples/data/table_data_demo.txt');

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('Attnt Dashboard.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
