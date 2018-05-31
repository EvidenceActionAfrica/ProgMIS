<?php
require_once ('../../includes/auth.php');
require_once ('../../includes/config.php');
require_once ("../../includes/functions.php");
require_once ("../../includes/form_functions.php");
//require_once ("../../processData/reverse-cascade/includes/meta-link-script.php"); 
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

    //Page header
    public function Header() {
        // Logo
        //  <img  src=\"../../images/logo.png\"/>
       // $image_file ="../../images/logo.png";
       // $this->Image($image_file, 80, 20, 35, '', 'PNG', '', 'T', false, 30, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 16);
        // Title
        $this->Cell(5, 25, "National Programmes Results:Sub County Breakdown", 0, false, 'L', 0, '', 0, false, 'M', 'M');
    }

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
$pdf->SetTitle('National Programme Results');
$pdf->SetSubject('District Break Down');
$pdf->SetKeywords('evidence-action, PDF, programme results, NSBD, district breakdown');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
$pdf->SetFont('times', '', 6, '', 'false');

// add a page
$pdf->AddPage();
// set JPEG quality
$pdf->setJPEGQuality(100);


// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// output some RTL HTML content


// test some inline CSS


// column titles
//$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
//$header=$_SESSION["headerInfo"];
// data loading
//$data = $pdf->LoadData($_SESSION["tableData"]);

// print colored table
//$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------
$data='
<style>
*{
  padding:0%;
  margin:0%;
}

table{
 
}
table,tr,th,td{

  border:1px solid #000000;
}
td,th{
    width:15%;
  border:1px solid rgb(0,0,0);
}
tr th{
  background-color:rgb(201,201,201);
  font-weight:bolder;
}
#tdNums{
  text-align:right;
}


</style>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action: National Programme Results</title>';
   
   
 $data.='</head>';
 $pdf->setXY(30,10);
$data.='
<body>
<center>
   
    <h3 style="text-align:center">National School-Based Deworming Programme</h3>
    <h3 style="text-align:center">2012-2013 Sub-County Breakdown of STH and Schistosomiasis Treatement</h3>
</center>
';

$data.=$_SESSION["tableData"];
$data.='


</body>
</html>
';
$documentName=isset($_GET['pdf'])?$_GET['pdf']:"Programmes_result.pdf";
$pdf->writeHTML($data, true, false, true, false, 'C');

// close and output PDF document
$pdf->Output($documentName, 'I');

//============================================================+
// END OF FILE
//============================================================+

?>



































