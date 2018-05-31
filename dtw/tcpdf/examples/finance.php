<?php

require_once ('../../includes/auth.php');
require_once ('../../includes/config.php');

$wave = $_GET['wave'];
$type = $_GET['type'];
$cat = $_GET['cat'];
$loc = $_GET['loc']; 

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

  //Page header
  public function Header() {
    // Logo
    $image_file = K_PATH_IMAGES . 'logo_example.jpg';
    $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    // Set font
    $this->SetFont('helvetica', 'B', 20);
    // Title
    $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
  }

  // Page footer
  public function Footer() {
    // Position at 15 mm from bottom
    $this->SetY(-15);
    // Set font
    $this->SetFont('helvetica', 'I', 8);
    // Page number
    $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
  }

}

// create new PDF document
$pdf = new TCPDF('l', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); //PDF_PAGE_ORIENTATION---> 'l' or 'p'
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 006');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);

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
// set page
$pdf->SetFont('dejavusans', '', 10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$pdf->setPrintHeader(false);
$pdf->SetFooterMargin(0);
$pdf->setPrintFooter(false);
// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
// create some HTML content




$html = ' 
  <table style="width: 100%">
    <tr>
      <td width="10%"><img src="../../images/pill.png" height="60px"/></td>
      <td align="center" width="80%">
        <b style="font-size: 22px;">FORM P: WARD PLANNING </b> <br/>
        <b style="font-size: 15px; ">(School List)</b><br/>
      </td>
      <td align="left" valign="top"><b style="font-size: 60px">P</b></td>
    </tr>
  </table>
  <br/>
  <br/>
</div>

<div style="width: 100%; padding-left: 1%; font-size: 10px; ">
> Review the list of public and private primary schools below. Complete the enrolment data and tablet calculations carefully and neatly<br/><br/>
> Indicate if any school has closed with a &radic; in the "closed" column<br/><br/>
<font style="float: left">> Strike off any closed schools and do not complete the table for them. Example : </font>
  <table border="1" width="400px" style="float: left">
    <tr height="20px">
      <td><strike>Hope Primary</strike></td>
      <td><strike>001-001-HQ05</strike></td>
      <td><strike>Public</strike></td>
      <td>&radic;</td>
    </tr>
  </table><br/><br/>
  <font style="float: left">> Add new schools at the end of the form. Complete the programme assigned school ID using the first 2 letters of school name. Example:</font>
  <table border="1" width="200px" style="float: left">
    <tr height="20px">
      <td>BARACK P.S.</td>
      <td>001-001- <font style="font-size: 8px">BA</font> 50</td>
    </tr>
  </table>
<br/><br/>
<table border="1"  cellpadding="5" style="width: 100%; border: 2px solid black; font-size: 11px">
  <tr style="font-size: 9px">
    <td rowspan="2" align="center" style="width: 4%;"><br/><br/><br/><br/><b>No</b></td>
    <td rowspan="2" align="left" style="width: 18%;"><br/><br/><br/><br/><b>School Name</b></td>
    <td rowspan="2" align="center" style="width: 9%"><br/><br/><br/><b>Programme Assigned School ID</b></td>
    <td rowspan="2" align="center" style="width: 9%"><br/><br/><br/><b>School MOEST Code</b></td>
    <td rowspan="2" align="center" style="width: 5%; font-size: 8px">
      <b>School Type<br/><br/>
        (Public/ private/ other)
      </b>
    </td>
    <td rowspan="2" align="center" style="width: 05%"><br/><br/><br/><b>School Closed?</b></td>
    <td colspan="2" align="center" style="width: 17%"><br/><br/><br/><b>Enrolment in this school (children in register book) including attached ECD</b></td>
    <td rowspan="2" align="center" style="width: 8%"><br/><br/><br/><b>No. of stand- alone ECD centres in School Catchment Area</b></td>
    <td rowspan="2" align="center" style="width: 8%"><b>Estimated enrolment in stand- alone ECD centres. <br/><br/>(C) </b></td>
    <td rowspan="2" align="center" style="width: 6%"><b>Calculate number of ALB tablets needed <br/><br/> (A+B+C)+20% </b></td>
    <td rowspan="2" align="center" style="width: 5%; font-size: 7px"><b>Bilharzia School? <br/><br/> (refer to provided list)<br/><br/> (Yes/No)</b></td>
    <td rowspan="2" align="center" style="width: 6%"><b>Calculate number of PZQ required for Bilharzia Schools <br/><br/>((Ax2.5)+40%)</b></td>
  </tr>
  <tr style="font-size: 9px">
    <td align="center"><br/><br/>Primary school enrolment (A) </td>
    <td align="center"><br/><br/>ECD attached enrolment (B)</td>
  </tr>
';
  
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
//=====================================================================================
$pdf->SetLeftMargin(15);
$pdf->SetTopMargin(3);
$pdf->setPrintHeader(false);
$pdf->SetFooterMargin(0);
$pdf->setPrintFooter(false);

// protrait
$pdf->addPage('P', 'LETTER');

$html = '
<table style="width: 100%">
  <tr>
    <td align="left" style="width: 100px">
      <div style="border: 1px solid grey; height: 100px"><font style="vertical-align: top; color: grey; font-size: 7px">Do not write on this space</font><br/><br/></div>
    </td>
    <td align="left" style="width: 10%"><br/><br/><img src="../../images/pill.png" height="80px"/></td>
    <td align="center" style="width: 67%"><br/><br/>
      <b style="font-size: 22px;">FORM P: Ward Planning</b><br/>
      <b style="font-size: 13px;">(Programme Activities)</b><br/>
    </td>
    <td align="left"><b style="font-size: 60px; width: 5%">P</b></td>
  </tr>
</table>
<center>
  <font style="font-size: 10px; text-align: center">Using Form P (school list) please complete the planning exercise below for your Ward.</font>
</center><br/>
<table align="center" style="border: 2px solid black; font-size:9px">
<tr><td colspan="9" align="left" style="border: 1px solid black"><b style="font-size: 11px;">1. Ward Summary: Please add up all Form P sheet totals to give a summary for this Ward</b></td></tr>
  <tr style="font-size: 9px">
    <th rowspan="2" style="width: 20%; border: 1px solid black"><br/><br/>Ward Name:</th>
    <th rowspan="2" style="width: 10%; border: 1px solid black;"><br/>Total Number Primary Schools</th>
    <th colspan="2" style="width: 20%; border: 1px solid black;"><br/>Enrolment in schools</th>
    <th rowspan="2" style="width: 10%; border: 1px solid black;"><br/><br/>Total No. of Stand-alone centres</th>
    <th rowspan="2" style="width: 10%; border: 1px solid black;">Total Enrolment in stand-alone ECD centres</th>
    <th rowspan="2" style="width: 10%; border: 1px solid black;"><br/><br/>No. of ALB tablets needed</th>
    <th rowspan="2" style="width: 10%; border: 1px solid black;"><br/><br/>No. Bilharzia Schools</th>
    <th rowspan="2" style="width: 10%; border: 1px solid black;"><br/><br/>No. of PZQ tablets needed</th>
  </tr>
  <tr style="font-size: 9px">
    <th style="border: 1px solid black"><br/><br/>Primary</th>
    <th style="border: 1px solid black"><br/><br/>ECD</th>
  </tr>
  <tr align="left" style="font-size: 12px; font-weight: normal">
    <th align="center" style="border: 1px solid black; font-size: 12px"><br/><br/> </th>
    <th style="border: 1px solid black"></th>
    <th style="border: 1px solid black"></th>
    <th style="border: 1px solid black"></th>
    <th style="border: 1px solid black"></th>
    <th style="border: 1px solid black"></th>
    <th style="border: 1px solid black"></th>
    <th style="border: 1px solid black"></th>
  </tr>
</table>
<br/>
<br/>
<!--22222222222222222222222222222222222222222-->
<table  style="border: 2px solid black; width: 100%">
  <tr><td style="border-bottom: 1px solid black"><b style="font-size: 11px">2. Number of Training Sessions:</b></td></tr>
  <tr><td><b style="font-size: 9px">Based on the programme in your Ward last year the total number of teacher training sessions allocated to your Ward this year is: <u> </u></b><br/><br/>
  <font style="font-size: 9px">This should allow 2 teachers from every school to be trained with a maximum of 20 schools per teacher training session. Please speak with a Master Trainer if you think the number of teacher training sessions should be revised.</font>
  </td></tr>
</table>
<br/>
<br/>
<!--333333333333333333333333333333333333333333-->
<table style="border: 2px solid black; font-weight: normal; width: 100%;">
  <tr><td colspan="8" style="border: 1px solid black"><b style="font-size: 11px;">3. Plan scheduling and select venues for teacher training:</b></td></tr>
  <tr><td colspan="8" style="border: 1px solid black"><i style="font-size: 9px;">As a Ward plan the teacher training sessions according to the number needed<br/>Discuss which schools may attend each training and provide an approximate number of schools expected at each TT session.</i></td></tr>
  <tr height="60px" style="font-size: 9px; text-align: center">
    <th rowspan="2" style="width: 03%; border: 1px solid black"></th>
    <th rowspan="2" style="width: 20%; border: 1px solid black"><br/><br/><br/>Training Venue</th>
    <th rowspan="2" style="width: 10%; border: 1px solid black">Estimated Training date<br/><br/>(DD/MM/YY)</th>
    <th colspan="2" style="width: 46%; border: 1px solid black"><br/><br/><b>Assigned Responsible Officer MoE or MoH</b></th>
    <th colspan="3" style="width: 21%; border: 1px solid black"><br/><br/><b>No. of Schools Attending</b></th>
  </tr>
  <tr style="font-size: 9px; text-align: center">
    <th style="width: 30%; border: 1px solid black"><br/><br/>Name</th>
    <th style="width: 16%; border: 1px solid black"><br/><br/>Phone Number</th>
    <th style="width: 7%; border: 1px solid black">Non-<br/>Bilharzia<br/>(A)</th>
    <th style="width: 7%; border: 1px solid black"><br/>Bilharzia<br/>(B)</th>
    <th style="width: 7%; border: 1px solid black"><br/>Total<br/>(A+B)</th>
  </tr>
';


// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');











// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('FormP SL-- .pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

