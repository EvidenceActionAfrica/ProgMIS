<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$tabActive = "tab1";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("includes/meta-link-script.php");
    ?>
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
      <link href="css/default.css" type="text/css" rel="stylesheet">
        </head>
        <body>
          <!---------------- header start ------------------------>
          <div class="header">
            <div style="float: left">  <img src="../images/logo.png" />  </div>
            <div class="menuLinks">
              <?php
              require_once ("includes/menuNav.php");
              ?>
            </div>
          </div>
          <div class="clearFix"></div>
          <!---------------- content body ------------------------>
          <div class="contentMain">
            <div class="contentLeft">
              <?php require_once ("includes/menuLeftBar-Settings.php"); ?>
            </div>
            <div class="contentBody">

              <?php
              if (isset($_POST)) {

                $payeeName = isset($_POST["payeeName"]) ? mysql_real_escape_string($_POST["payeeName"]) : "";
                $memo = isset($_POST["memo"]) ? mysql_real_escape_string($_POST["memo"]) : "";
                $project = isset($_POST["project"]) ? mysql_real_escape_string($_POST["project"]) : "";
                $amountWords = isset($_POST["amountWords"]) ? mysql_real_escape_string($_POST["amountWords"]) : "";
                $preparedBy = isset($_POST["preparedBy"]) ? mysql_real_escape_string($_POST["preparedBy"]) : "";
                $approvedBy = isset($_POST["approvedBy"]) ? mysql_real_escape_string($_POST["approvedBy"]) : "";
                $donor = isset($_POST["donor"]) ? mysql_real_escape_string($_POST["donor"]) : "";

                $cmdSave = isset($_POST["saveRecord"]) ? $_POST["saveRecord"] : "";
                if ($cmdSave) {
                  $sql = "INSERT INTO `fin_budget_crrte`(`payee_name`, `amount_words`, `memo`, `project`, `donor`, `prepared_by`, `approved_by`)";
                  $sql.="VALUES ('$payeeName','$amountWords','$memo','$project','$donor','$preparedBy','$approvedBy')";

                  mysql_query($sql) or die(mysql_error());
                }
              }
              if (isset($_GET["deleteid"])) {
                $tabActive = 'tab2';
                $id = $_GET["deleteid"];
                $sql = "DELETE from fin_budget_crrte where id='$id'";
                mysql_query($sql);
              }
              if (isset($_GET["id"])) {
                $tabActive = 'tab2';
              }
              if (isset($_POST["updateAccounts"])) {

                $tabActive = 'tab2';
              }
              ?>

              <style>
                tr{
                  height:10px;
                }
              </style>


              <div class="tabbable" >
                <ul class="nav nav-tabs">
                  <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">IRRTE Form</a></li>
                  <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">IRRTH Form</a></li>
              
                </ul>

                <div class="tab-content" >
                  <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">

               
 <?php
                    if (isset($_POST['save'])) {
                      $firstname = 'firstname';
                      //$secondname = mysql_prep($_POST['secondname']);

                      //Generate booking order pdf =======================
                      date_default_timezone_set("Africa/Nairobi");
                      $currentDate = date('Y-m-d');
                      $printDetails = '
  <table width="100%" align="center" cellpadding="-5" cellspacing="0" border="">
    <tr>
      <td> 
        <u><b style="font-size: 22px; color: #002a80;">BOOKING ORDER</b></u>
      </td>
    </tr>
  </table>
<font style="font-size:13px">
  <h4 style="font-size:19px; color: #002a80;">CLIENT PERSONAL DETAILS </h4><br/><hr/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="">
    <tr>
      <td align="right" width="120px">First Name : </td><td width="200px" border="1"> ' . $firstname . '</td>
      <td align="right" width="120px">Second Name : </td><td width="200px" border="1"> ' . $secondname . '</td>
    </tr>
    <tr>
      <td align="right">Phone Number : </td><td border="1"> ' . $phonenumber . '</td>
      <td align="right">Client code : </td><td border="1"> ' . $clientcode . '</td>
    </tr>
    <tr>
      <td align="right">Address : </td><td border="1"> ' . $address . '</td>
      <td align="right">Job Type : </td><td border="1"> ' . $jobtype . '</td>
    </tr>
    <tr>
      <td align="right">Move date : </td><td border="1"> ' . $proposedmovedate . '</td>
      <td align="right">Move Rep : </td><td border="1"> ' . $moverep . '</td>
    </tr>
    <tr>
      <td align="right">Email address : </td><td border="1"> ' . $emailclient . '</td>
      <td align="right">Volume CBM : </td><td border="1"> ' . $volumecbm . '</td>
    </tr>
    <tr>
      <td align="right">Move date : </td><td border="1"> ' . $proposedmovedate . '</td>
      <td align="right">Start time : </td><td border="1"> ' . $starttime . '</td>
    </tr>
    <tr>
      <td align="right">Duration : </td><td border="1"> ' . $duration . '</td>
      <td align="right">Vehicles needed : </td><td border="1"> ' . $vehiclesneeded . '</td>
    </tr>
    <tr>
      <td align="right">Client Status : </td><td border="1"> ' . $clienttype . '</td>
      <td align="right"></td><td ></td>
    </tr>
  </table>
  <br/><br/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="">
    <tr>
      <td align="right" width="120px"><b>Important notes : </b></td>
      <td border="1" width="520px"> ' . str_replace('\r\n', "<br/>", $importantnotes) . '</td>
    </tr>
    <tr>
      <td align="right"><b>Origin : </b></td>
      <td border="1"> ' . $originArea . ',' . $originRoad . ',' . $originStreet1 . ',' . $originStreet2 . ',' . $originCompoundName . ',' . $originHouseNo . ',' . $originLandmarks . '</td>
    </tr>
    <tr>
      <td align="right"><b>Destination : </b></td>
      <td border="1"> ' . $destArea . ',' . $destRoad . ',' . $destStreet1 . ',' . $destStreet2 . ',' . $destCompoundName . ',' . $destHouseNo . ',' . $destLandmarks . '</td>
    </tr>
  </table>
  <br/>

  <h3 style="font-size:18px; color: #002a80">MATERIALS </h3><hr/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="">
    <tr>
      <td align="right" width="130px"><b>C/BOXES L  : </b> New :</td><td width="190px" border="1"> ' . $cboxeslnew . '</td>
      <td align="right" width="130px">Used : </td><td width="190px" border="1"> ' . $cboxeslused . '</td>
    </tr>
    <tr>
      <td align="right"><b>C/BOXES S : </b> New : </td><td border="1"> ' . $cboxessnew . '</td>
      <td align="right">Used : </td><td border="1"> ' . $cboxessused . '</td>
    </tr>
    <tr>
      <td align="right"><b>C/BOXES W  : </b> New : </td><td border="1"> ' . $cboxeswnew . '</td>
      <td align="right">Used : </td><td border="1"> ' . $cboxeswused . '</td>
    </tr>
    <tr>
      <td align="right">White Paper : </td><td border="1"> ' . $whitepaper . '</td>
      <td align="right">Corrugated : </td><td border="1"> ' . $corrugated . '</td>
    </tr>
    <tr>
      <td align="right">Packing Tapes : </td><td border="1"> ' . $packingtapes . '</td>
      <td align="right">Silica gel : </td><td border="1"> ' . $silicagel . '</td>
    </tr>
    <tr>
      <td align="right">Foam : </td><td border="1"> ' . $foam . '</td>
      <td align="right">Shredded Paper : </td><td border="1"> ' . $shreddedpaper . '</td>
    </tr>
    <tr>
      <td align="right">Plastic Boxes : </td><td border="1"> ' . $plasticboxes . '</td>
      <td align="right">Sisal Twine : </td><td border="1"> ' . $sisaltwine . '</td>
    </tr>
    <tr>
      <td align="right">Bubble Wrap : </td><td border="1"> ' . $bubblewrap . '</td>
      <td align="right">Gunny Bags : </td><td border="1"> ' . $gunnybags . '</td>
    </tr>
    <tr>
      <td align="right">Dish/Glass Carrier: </td><td border="1"> ' . $dishglasscarrier . '</td>
      <td align="right">OTHERS : </td><td border="1"> ' . $othermaterials . '</td>
    </tr>
  </table>
  <br/>

  <h3 style="font-size:18px; color: #002a80">LABOUR & COSTING </h3><hr/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="">
    <tr>
      <td align="right" width="120px">Movers :     </td><td width="93px" border="1"> ' . $movers . '</td>
      <td align="right" width="120px">Material Charges : </td><td width="93px" border="1"> ' . $totalMaterials . '</td>
      <td align="right" width="120px">Crating Charges : </td><td width="93px" border="1"> ' . $totalCrating . '</td>
    </tr>
    <tr>
      <td align="right">Carpenters : </td><td border="1"> ' . $carpenters . '</td>
      <td align="right">Large Safe No.  : </td><td border="1"> ' . $largesafeUnit . '</td>
      <td align="right">Instant Showers: </td><td border="1"> ' . $instantshowerUnit . '</td>
    </tr>
    <tr>
      <td align="right">Electricians : </td><td border="1"> ' . $electricians . '</td>
      <td align="right">Piano Upright No.: </td><td border="1"> ' . $uprightUnit . '</td>
      <td align="right">Storage : </td><td border="1"> ' . $storagetype . '</td>
    </tr>
    <tr>
      <td align="right">Total Labourers : </td><td border="1"> ' . $totallabourers . '</td>
      <td align="right">Piano (Grand) No. : </td><td border="1"> ' . $grandpianoUnit . '</td>
      <td align="right">DSTV type : </td><td border="1"> ' . $dstvtype . '</td> 
    </tr>
    <tr>
      <td align="right"><b> </b></td><td > </td>
      <td align="right">Pictures : </td><td border="1"> ' . $picturesUnit . '</td>
      <td align="right"><b>TOTAL COST : </b></td><td border="1"> <b>' . number_format($totalbill) . '</b></td>
    </tr>
  </table>
  <br/><br/><br/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="1">
    <tr>
      <td align="left" width="320px"><h4 style="color: #002a80"> HARD ISSUES</h4></td>
      <td align="left" width="320px"><h4 style="color: #002a80"> SOFT ISSUES</h4></td>
    </tr>
    <tr>
      <td height="80px"> ' . str_replace('\r\n', "<br/>", $hardissues) . '</td>
      <td height="100px"> ' . str_replace('\r\n', "<br/>", $softissues) . '</td>

    </tr>
  </table>
</font>
                  ';

                      $pdf_name = generatePDF_quotation($moveid, $firstname, $printDetails);
                      $pdf_name_relative_path = 'pdf/bookingOrders/' . $pdf_name;


                      echo "<div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;border-radius:10px; margin:5px;background-color:#a2ff7e;'>
                      <font align='justify' size='3px'><br/> Booking Order PDF generated</font><br/><br/>
                       <center><a href='pdf/bookingOrders/$pdf_name' target='_blank' class='btn btn-warning' style='color:black'> Download quotation PDF</a></center>
                      <br/><br/>
                    </div><br/>
                    <center><a href='bookingOrder2-print.php' class='art-button'> View other B.O.s</a></center>
                    <br/><br/><br/>
                    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                    ";

                      $formsubmited = true;
                    }
                    ?>
                    <div style="width: 80%; border: 1px solid black;">
                      <center>
                      <!-- logo image -->
                        <img src="../images/logo.png" height="60px" align="center"/>
                      </center>
                        <div style="clear: both"></div>

                      <div style="clear: both"></div>

                      <span style="margin-left:20%;">
                        
                        <!-- title -->
                        <b style="font-size: 22px; text-align: center">Imprest Request Form</b>
                        <b style="font-size: 20px; text-align: center">District Training   MOE BOMET</b>


                      </span>

                      <table frame="border" width="100%" style="border: 2px solid black">
                        <tr>
                        </tr>
                        <tr>
                          <td colspan="2"> Prepared By &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp;   &nbsp;  &nbsp; &nbsp; <b>..............................................</b></td>
                          <td colspan="2">Signature &nbsp;   &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp;  &nbsp; &nbsp;  <b>..............................................</b></td>
                        </tr>
                        <tr>
                          <td colspan="2"> Date Request Is Made &nbsp; <b>..............................................</b></td>
                          <td colspan="2">Date Request is Required: &nbsp; <b>..............................................</b></td>
                        </tr>
                        <tr>
                          <td colspan="3">Amount (Words) &nbsp; ____________________________________________________________________________________________</td></tr>
                        <tr></tr>
                        <tr><td colspan="3"> &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;____________________________________________________________________________________________</td></tr>
                         
                        </tr>
                        <tr rowspan="3">
                        </tr>
                      </table>
                    <table frame="border" border="1" width="100%" style="border: 2px solid black">
                      <tr style="background-color: #ccccff;font-weight:bolder;">
                        <td>NO</td>
                        <td colspan="2">Particulars</td>
                        <td>Project</td>
                        <td>Amount</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td colspan="2"><span style="text-align:right;">Balance B/D</span></td>
                        <td></td>
                        <td></td>
                      </tr>
                     
                        <?php
                        $count=13;
                        while($count>0){
                        ?>
                         <tr style="height:20px;">
                      <td></td>
                        <td colspan="2"></td>
                        <td></td>
                        <td></td>

                      </tr>
                      <?php
                       --$count;
                     }
                      ?>
                      <tr>
                        <td></td>
                        <td colspan="2" style="text-align:right;font-weight:bold;">Total Amount Requested</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td colspan="4"><b>Please Pay:</b></td>
                        

                      </tr>
                      <tr style="height:20px;">
                      <td></td>
                        <td colspan="2"></td>
                        <td></td>
                        <td></td>
                      </tr>



            </table>

                <table frame="border" border="1" width="100%" style="border: 2px solid black">
                  
              <tr style="height:20px;">
                <td colspan="6">Authorised By:</td>
                <td><b>Signature By:</b></td>
                
              </tr>
              <tr>
                <td colspan="7"><b>Date: ..................................................................</b></td>
             
            </table>



                    </div>




                  </div>

                <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
                  ddd
                  </div>





                </div>
              </div>
            </div>
          </div>
        </body>
        </html>

              
              
<?php
//PDF PRINTING
error_reporting(0);

function generatePDF_quotation($moveid, $firstname, $bookingOrderDetails) {
// always load alternative config file for examples
  require_once('../tcpdf/examples/config/tcpdf_config_alt.php');
// Include the main TCPDF library (search the library on the following directories).
  $tcpdf_include_dirs = array(realpath('../tcpdf/tcpdf.php'), '/usr/share/php/tcpdf/tcpdf.php', '/usr/share/tcpdf/tcpdf.php', '/usr/share/php-tcpdf/tcpdf.php', '/var/www/tcpdf/tcpdf.php', '/var/www/html/tcpdf/tcpdf.php', '/usr/local/apache2/htdocs/tcpdf/tcpdf.php');
  foreach ($tcpdf_include_dirs as $tcpdf_include_path) {
    if (@file_exists($tcpdf_include_path)) {
      require_once($tcpdf_include_path);
      break;
    }
  }

//===================================
// Extend the TCPDF class to create custom Header and Footer
  class MYPDF extends TCPDF {

    //Page header
    public function Header() {
      // Logo
      $image_file = K_PATH_IMAGES . '../images/logo.jpg';
      // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
      $this->Image($image_file, 50, 10, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
      // Set font
      $this->SetFont('helvetica', 'B', 20);
      // Title
      // $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
      // Logo
      $image_file = K_PATH_IMAGES . 'letterhead-footer.jpg';
      // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
      $this->Image($image_file, 30, 280, 150, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
      // ... footer for the normal page ...
    }

  }

// create new PDF document
  $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Cube Movers');
  $pdf->SetTitle('Quotation');
  $pdf->SetSubject('Quotation');
  $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
  $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
// set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT); // left = 2.5 cm, top = 4 cm, right = 2.5cm
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetHeaderMargin(900);
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
//// set font
//  $pdf->SetFont('verdana', 'BI', 12);
// add a page
// $pdf->AddPage();
// set some text to print
  $txt = <<<EOD
TCPDF Example 003

Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
EOD;

// add a page
  $pdf->AddPage();


// create some HTML content
  $html = $bookingOrderDetails;

// get the first array. This will be make part of the name of pdf
  $pdf_name = '_BO.pdf';

// output the HTML content
  $pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
//Close and output PDF document
// anything between ob_start and ob_end_clean will not be returned to ajax success message
  ob_start();

//to save to a directory, just add the path before the name of the pdf.
  $pdf->Output('pdf/' . $pdf_name, 'FD');
//  $pdf->Output('example_006.pdf', 'I');
  ob_end_clean();
//  echo "pdf/" . $pdf_name . $moveid . '.pdf';

  return $pdf_name;
}
?>
