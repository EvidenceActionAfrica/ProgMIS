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






    //Page header
    public function Header() {
        // Logo
    //  <img  src=\"../../images/logo.png\"/>
        $image_file ="../../images/logo.png";
        $this->Image($image_file, 80, 20, 35, '', 'PNG', '', 'T', false, 30, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(25, 5, "", 0, false, 'C', 0, '', 0, false, 'M', 'M');
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

    // Load table data from file
    
    public function LoadData($file) {
        // Read file lines
      
       // $lines = file($file);
        $data = array(7);
         foreach ($file as $value) {
          
          if($value){
          
           $newData.=$value.";";
          }
      }
    //Code that will turn the array into a text file that will be manipulated into a table
	$fp = fopen(basename($_SERVER['PATH_INFO']) . "/materials_quote.txt","wb");
	fwrite($fp,$newData);
	fclose($fp);
	$path=$_SERVER['PATH_INFO']."/materials_quote.txt";
          $lines = file($path);

        foreach($lines as $line) {
           $data[] = explode(';', chop($line));
            $data[].= explode(';', chop($line));
          $data[].= explode(';', chop($line));
            $data[].= explode(';', chop($line));
              $data[].= explode(';', chop($line));
                $data[].= explode(';', chop($line));
                  $data[].= explode(';', chop($line));
        }
        return $data;
    }
    

    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(59,89,152);
        $this->SetTextColor(255);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
       // $w = array(40, 35, 40, 45);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
          if($i==1){
              $this->Cell(40, 7, $header[$i], 1, 0, 'C', 1);
          }else{
            $this->Cell(25, 7, $header[$i], 1, 0, 'C', 1);
          }
            
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            $this->Cell(35, 7, $row[0], 'LR', 0, 'R', $fill);
            $this->Cell(25, 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell(25, 6, $row[2], 'LR', 0, 'R', $fill);
            $this->Cell(25, 6, $row[2], 'LR', 0, 'R', $fill);
            $this->Cell(25, 6, $row[2], 'LR', 0, 'R', $fill);
            $this->Cell(25, 6, $row[2], 'LR', 0, 'R', $fill);
            $this->Cell(25, 6, $row[2], 'LR', 0, 'R', $fill);
            
            $this->Ln();
            $fill=!$fill;
        }
       
    }
}

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Evidence Action');
$pdf->SetTitle('Materials Packing');
$pdf->SetSubject('Vendor Packing');
$pdf->SetKeywords('evidence-action, PDF, packing, Vendor, pricing');

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
$html="<br/><br/><br/><br/> &nbsp; &nbsp; &nbsp; &nbsp; <h2>Vendor Packing Information</h2><br/>
<br/><br/><br/><br/> <br/><br/><br/><br/>
        <h4 style=\"margin-left:20%;\">Content In each Box and their unique BOX ID per District in each county</h4>";
$pdf->writeHTML($html, true, false, true, false, 'C');


$pdf->SetXY(15, 20);
$pdf->Image('../../images/gklogo.png', '', '', 30, 30, '', '', '', false, 300, '', false, false, 1, false, false, false);
$pdf->SetXY(165, 20);
$pdf->Image('../../images/kwaAfya.png', '', '', 30, 30, '', '', '', false, 150, '', false, false, 1, false, false, false);


$data.=" <br/><br/><br/><br/> <br/><br/><br/><br/> <br/><br/><br/><br/> ";
$data.=$_SESSION["tableData"];
$documentName=isset($_GET['pdf'])?$_GET['pdf']:"materials_quote.pdf";
$pdf->writeHTML($data, true, false, true, false, 'L');

// close and output PDF document
$pdf->Output($documentName, 'I');

//============================================================+
// END OF FILE
//============================================================+

?>










































