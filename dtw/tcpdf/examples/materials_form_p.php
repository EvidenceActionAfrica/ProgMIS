<?php
require_once ('../../includes/auth.php');
require_once ('../../includes/config.php');
require_once ("../../includes/functions.php");
require_once ("../../includes/form_functions.php");

//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

require_once('tcpdf_include.php');


// extend TCPF with custom functions
class MYPDF extends TCPDF {





/*
    //Page header
    public function Header() {
        // Logo
    //  <img  src=\"../../images/logo.png\"/>
        $image_file ="";
        $this->Image($image_file, 80, 20, 35, '', 'PNG', '', 'T', false, 30, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(25, 5, "", 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
*/
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

  
   
}

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Evidence Action');
$pdf->SetTitle('Form P');
$pdf->SetSubject('Form P');
$pdf->SetKeywords('evidence-action, PDF, Form P');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

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

$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
  require_once(dirname(__FILE__).'/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 10, '', 'false');

// add a page
$pdf->AddPage();
// set JPEG quality
$pdf->setJPEGQuality(75);

$html="<br/><br/><h1>FORM P:District</h1>
          ";
$pdf->writeHTML($html, true, false, true, false, 'R');

$pdf->SetXY(80, 20);
$pdf->Image('../../images/kwaAfya.png', '', '', 30, 30, '', '', '', false, 300, '', false, false, 1, false, false, false);

$pdf->SetXY(25, 40);
$html="<br/><br/><h2>Planning</h2><br/><h3>(Program Activities)</h3>";
$pdf->writeHTML($html, true, false, true, false, 'C');


$data.="

<style>

table,tr,td,th{

  border:1px solid #000000;

 
}
table tr th{

 background-color:rgb(201,201,201);
}


h1{
  color:red;
}
h2{
  margin-left:200px;
}

</style>
";
$data.=$_SESSION["tableData"];

$pdf->writeHTML($data, true, false, true, false, 'L');
$documentName="FORM P.pdf";
// close and output PDF document
$pdf->Output($documentName, 'I');

//============================================================+
// END OF FILE
//============================================================+

?>










































