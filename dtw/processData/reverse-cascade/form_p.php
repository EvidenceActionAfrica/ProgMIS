<?php
require_once ('../includes/auth.php');
require_once ('../../includes/config.php');
require_once ("../../includes/functions.php");
require_once ("../../includes/form_functions.php");

require_once('../../includes/db_functions.php');
$evidenceaction = new EvidenceAction();

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_login_forms_reverse = $row['priv_login_forms_reverse'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script-pablo.php"); ?>

    <style>
      .txtTableForm {
        background-color: #F2F2F2 /*#E7E3E0*/ !important;
        border: none !important;
        margin: 0px !important;
        padding: 0px !important;
        font-size: 12px !important;
        height: 100% !important;
        width: 99% !important;
      }
      .tdCompact{
        margin: 0px !important;
        padding: 0px !important;
      }
      .fc{
        background-color: #fcfcfc !important;
      }
    </style>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("../includes/menuNav.php"); ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-Reverse.php"); ?>
      </div>

      <div class="contentBody">
        <!--================================================-->
        <?php
        //ajax dropdown selector
        $tablename = 'counties';
        $fields = 'id, county';
        $where = '1=1';
        $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);

        if (isset($_POST['selectDistrictFormD'])) {
          $selectedcounty = $_POST['selectcounty'];
          $selecteddistrict = $_POST['selectdistrict'];
          $selecteddivision = $_POST['selectdivision'];

          //get division IDs
          $resD = mysql_query("SELECT * FROM divisions WHERE district_name='$selecteddistrict' AND  division_name='$selecteddivision' ");
          while ($row = mysql_fetch_array($resD)) {
            $district_id = $row["district_id"];
            $division_id = $row["division_id"];
          }
        }



        if (isset($_POST['generatePDF'])) {
          $district = $_POST['district'];
          $district_id = $_POST['district_id'];
          $division = $_POST['division'];
          $division_id = $_POST['division_id'];

          $school_name = 'sadf';
          $school_id = 'sdf';
          $school_type = 'sdfsd';
          $ap_attached = 'sdfsd';
          $quotationRaw = '


<div style="width: 100%;">
  <table style="width: 100%">
    <tr>
      <td width="10%"><img src="../../images/pill.png" height="60px"/></td>
      <td align="center" width="80%">
        <b style="font-size: 22px;">FORM P: DIVISION PLANNING </b> <br/>
        <b style="font-size: 15px; ">(School List)</b><br/>
      </td>
      <td align="left" valign="top" ><b style="font-size: 60px">P</b></td>
    </tr>
  </table>
  <br/>
  <table style="width: 100%; font-size: 11px" >
    <tr>
      <td><b>1. DISTRICT NAME: </b>' . $district . '</td>
      <td><b>DISTRICT ID: </b>' . $district_id . '</td>
      <td><b>DIVISION NAME: </b>' . $division_id . '</td>
      <td><b>DIVISION ID: </b>' . $division_id . '</td>
    </tr>
  </table>
  <br/>
</div>

<div style="width: 100%; padding-left: 3%; font-size: 11px; ">
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
  <font style="float: left">> Add new schools at the end of the form. Complete the programme assigned school ID using the first 2 letters of school name. Eg.:<br/> </font>
  <table border="1" width="200px" style="float: left">
    <tr height="20px">
      <td>BARACK P.S.</td>
      <td>001-001- <font style="font-size: 8px">BA</font> 50</td>
    </tr>
  </table>
<br/><br/>
<table border="1" align="center" cellpadding="5" style="width: 100%; border: 2px solid black; font-size: 11px">
  <tr>
    <td rowspan="2" align="center" valign="bottom" width="40px"><b>No.</b></td>
    <td rowspan="2" align="center" valign="bottom" style="width: 20%"><b>School Name</b></td>
    <td rowspan="2" align="center" valign="bottom" ><b>Programme Assigned School ID</b></td>
    <td rowspan="2" align="center">
      <b>School Type<br/><br/>
        (Public/ private/ other)
      </b>
    </td>
    <td colspan="2" align="center"><b>Enrolment in this school (children in register book) including attached ECD</b></td>
    <td rowspan="2" align="center"><b>No. of stand- alone ECD centres in School Catchment Area</b></td>
    <td rowspan="2" align="center"><b>Estimated enrolment in stand- alone ECD centres. <br/><br/>(C) </b></td>
    <td rowspan="2" align="center"><b>Calculate number of ALB tablets needed <br/><br/> (A+B+C)+20% </b></td>
    <td rowspan="2" align="center"><b>Bilharzia School? <br/><br/> (refer to provided list)<br/><br/> (Yes/No)<br/><br/></b></td>
    <td rowspan="2" align="center"><b>Calculate number of PZQ required for Bilharzia Schools <br/><br/>((Ax2.5)+40%)<br/><br/> </b></td>
  </tr>
  <tr>
    <td align="center">Primary school enrolment <br/><br/> (A) </td>
    <td align="center">ECD attached enrolment <br/><br/> (B)</td>
  </tr>
';

          $count = 1;
          $result_st = mysql_query("SELECT * FROM schools  WHERE county='$county' AND district_name ='$district' AND division_name ='$division' ORDER BY school_name ASC");
          //$result_st = mysql_query("SELECT * FROM schools   WHERE schools.county='$county' AND schools.district_name ='$district' AND schools.division_name ='$division' ORDER BY school_name ASC");
          while ($row = mysql_fetch_array($result_st)) {
            $school_name = $row["school_name"];
            $school_id = $row["school_id"];
            $school_type = $row["school_type"];
            //echo $ap_attached = $row["ap_attached"];


            $html.='
<tr>
  <td align="center">' . $count . '</td>
  <td style="padding-left: 2px">' . $school_name . '</td>
  <td style="padding-left: 2px">' . $school_id . '</td>
  <td style="padding-left: 2px">' . $school_type . '</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td style="padding-left: 2px">' . $ap_attached . '</td>
  <td align="center"></td>
</tr>';
            $count++;
          }

          $html.='
</table>
</div>
';

          //$quotation = str_replace('\r\n', "<br/>", $quotationRaw);

          $pdf_name = generatePDF_quotation($quotationRaw);
          echo "<div style='text-align:center;width:70%; padding:20px;border:1px solid #3eda00;border-radius:10px; margin:10px auto;background-color:#a2ff7e;'>
                  <center><a href='pdf/$pdf_name' class='btn btn-warning' style='color:black'> Download quotation PDF</a></center>
                </div><br/><br/>";
        }
        ?>

        <form method="post" action="form_p.php#selectDistrictFormD">
          <div id="divData" style="padding-left: 3%; padding-right: 5%; background-color: #FCFCFC">
            <!--header-->
            <div style="width: 100%;">
              <table style="width: 100%">
                <tr>
                  <td><img src="../../images/pill.png" height="50px"/></td>
                  <td align="center">
                    <b style="font-size: 19px; ">FORM P: DIVISION PLANNING </b> <br/>
                    <b style="font-size: 16px; ">(School List)</b><br/>
                  </td>
                  <td align="right"><b style="font-size: 60px">P</b></td>
                </tr>
              </table>
              <br/>
              <table style="width: 100%">
                <tr>
                  <td><b>1. DISTRICT NAME: </b><input type="text" name="district" value="<?php echo $selecteddistrict; ?>" style="border: none; border-bottom: 2px dotted #000; width: 50%;  background: #fcfcfc" readonly/></td>
                  <td><b>DISTRICT ID: </b><input type="text" name="district_id" value="<?php echo $district_id; ?>" style="border: none; border-bottom: 2px dotted #000; width: 40%;  background: #fcfcfc" readonly/></td>
                  <td><b>DIVISION NAME: </b><input type="text" name="division" value="<?php echo $selecteddivision; ?>" style="border: none; border-bottom: 2px dotted #000; width: 50%;  background: #fcfcfc" readonly/></td>
                  <td><b>DIVISION ID: </b><input type="text" name="division_id" value="<?php echo $division_id; ?>" style="border: none; border-bottom: 2px dotted #000;  width: 30%; background: #fcfcfc" readonly/></td>
                </tr>
              </table>
              <br/>
            </div>
            <!--top part - text-->
            <div style="width: 100%; padding-left: 3%; font-size: 11px; ">
              • Review the list of public and private primary schools below. Complete the enrolment data and tablet calculations carefully and neatly<br/><br/>
              • Indicate if any school has closed with a &radic; in the “closed” column<br/><br/>
              <font style="float: left">• Strike off any closed schools and do not complete the table for them. Example : </font>
              <table border="2" width="400px" style="float: left">
                <tr>
                  <td><strike>Hope Primary</strike></td>
                  <td><strike>001-001-HQ05</strike></td>
                  <td><strike>Public</strike></td>
                  <td>&radic;</td>
                </tr>
              </table>
              <br/><br/>
              <div style="clear: both"></div>
              <font style="float: left"> • Add new schools at the end of the form. Complete the programme assigned school ID using the first 2 letters of school name. Example:<br/> </font>
              <table border="2" width="200px" style="float: left">
                <tr>
                  <td>BARACK P.S.</td>
                  <td>001-001- <font style="font-size: 8px">BA</font> 50</td>
                </tr>
              </table>
            </div>
            <br/>
            <br/>


            <!-- Section 1 =============-->
            <table border="1" align="center" cellpadding="5" style="width: 100%; border: 2px solid black; font-size: 11px">
              <tr>
                <td rowspan="2" align="center" valign="bottom" ><b>No.</b></td>
                <td rowspan="2" align="center" valign="bottom" style="width: 20%"><b>School Name</b></td>
                <td rowspan="2" align="center" valign="bottom" ><b>Programme Assigned School ID</b></td>
                <td rowspan="2" align="center">
                  <b>School Type<br/><br/>
                    (Public/ private/ other)
                  </b>
                </td>
                <td colspan="2" align="center"><b>Enrolment in this school (children in register book) including attached ECD</b></td>
                <td rowspan="2" align="center"><b>No. of stand- alone ECD centres in School Catchment Area</b></td>
                <td rowspan="2" align="center"><b>Estimated enrolment in stand- alone ECD centres. <br/><br/>(C) </b></td>
                <td rowspan="2" align="center"><b>Calculate number of ALB tablets needed <br/><br/> (A+B+C)+20% </b></td>
                <td rowspan="2" align="center"><b>Bilharzia School? <br/><br/> (refer to provided list)<br/><br/> (Yes/No)<br/><br/></b></td>
                <td rowspan="2" align="center"><b>Calculate number of PZQ required for Bilharzia Schools <br/><br/>((Ax2.5)+40%)<br/><br/> </b></td>
              </tr>
              <tr>
                <td align="center">Primary school enrolment <br/><br/> (A) </td>
                <td align="center">ECD attached enrolment <br/><br/> (B)</td>
              </tr>


              <?php
              $count = 1;
              $result_st = mysql_query("SELECT * FROM schools inner join a_bysch ON schools.school_id=a_bysch.school_id WHERE schools.county='$selectedcounty' AND schools.district_name ='$selecteddistrict' AND schools.division_name ='$selecteddivision' ORDER BY school_name ASC");
              while ($row = mysql_fetch_array($result_st)) {
                ?>
                <tr>
                  <td align="center"><?php echo $count; ?></td>
                  <td style="padding-left: 2px"><?php echo $row['school_name'] ?></td>
                  <td style="padding-left: 2px"><?php echo $row['school_id'] ?></td>
                  <td style="padding-left: 2px"><?php echo $row['school_type'] ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="padding-left: 2px"><?php echo $row['ap_attached'] ?></td>
                  <td align="center"></td>
                </tr>
                <?php
                $count++;
              }
              ?>
            </table>
          </div>
          <br/>
          <!--<input type="submit" name="generatePDF" value="Generate PDF" class="btn-custom-pink"/>-->
          <a href="../../tcpdf/examples/form_p_schoollist.php?county=<?php echo $selectedcounty;?>&district=<?php echo $selecteddistrict;?>&district_id=<?php echo $district_id;?>&division=<?php echo $selecteddivision;?>&division_id=<?php echo $division_id;?>" class="btn-custom-pink" style="text-decoration: none;">Generate PDF</a>
        </form>
        <br/>
        <br/>

        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->


    <!--keydown event-->
    <script type="text/javascript" src="../../js/keydown_events.js"></script>
    <script type="text/javascript" src="../../js/block-return-key.js"></script>

    <!--Delete dialog-->
    <script>
      function show_confirm(deleteid) {
        if (confirm("Are you sure you want to delete?")) {
          location.replace('?deleteid=' + deleteid);
        } else {
          return false;
        }
      }
    </script>

    <script type="text/javascript">
      //myDatePicker javascript
      $(document).ready(function() {
        $(".myDatePicker").datepicker({
          dateFormat: 'dd-mm-yy',
          showOn: 'focus',
          buttonImageOnly: true,
          buttonImage: 'calendar/cal.gif',
          buttonText: 'Pick a date',
          onClose: function(dateText, inst) {
            //$("#EndDate").val($("#proposedmovedate").val());
          }
        });
      });
    </script>

  </body>
</html>









<!--===== Modal Select District ===========================-->
<div id="selectDivisionFormP" class="modalDialog">
  <div style="width: 500px">
    <a href="#close" title="Close" class="close">X</a>
    <div >
      <h1 class="form-title">Select District </h1><br/>
    </div>
    <?php
    $cmdAdd = filter_input(INPUT_POST, "addNewForm");
    if ($cmdAdd) {
      $count = 1;
      $sql = "INSERT INTO `form_d`(`deo_name`, `county`, `district`, `phone_number`)";
      $sql.=" VALUES ('$deoName','$county','$district','$phoneNumber')";

      $resultA = mysql_query($sql) or die(mysql_error());

      //Code for getting the last entry in formd's Id to use as a reference in form_d_data

      $sql = "select id from form_d ORDER by id DESC LIMIT 1";
      $resultB = mysql_query($sql);

      while ($row = mysql_fetch_array($resultB)) {
        $formD_Id = $row["id"];
      }

      //Form D Data for Form D itself.It Will require a while Loop for the table
      //The Table Should loop such that the fields go like
      //divion1,division2,division3---NAME of the fieldsshould go like this.
      //If it does this insert willl work

      echo "<div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;background-color:#a2ff7e;'>
               Record Added Successfully <br/> Select district below to add another record
            </div>";
    }
    ?>
    <!--======================-->
    <form method="POST" action="form_p.php">
      <center>
        <div style="padding: 5px; margin: 0px auto">
          <table border="0">
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <tr>
              <td>County </td>
              <td>
                <select onchange="get_district(this.value);" id="selectcounty" name="selectcounty" class="input_select">
                  <option value="">Choose County</option>
                  <?php foreach ($insertformdata as $insertformdatacab) { ?>
                    <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>District</td>
              <td>
                <select onchange="get_division(this.value);" id="selectdistrict" name="selectdistrict" class="input_select">
                  <option value="">Choose District</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Division</td>
              <td>
                <select  id="selectdivision" name="selectdivision" class="input_select">
                  <option value="">Choose Division</option>
                </select>
              </td>
            </tr>
          </table>
        </div>
      </center>
      <br/>
      <center>
        <div>
          <input type="submit" name="selectDistrictFormD" value="Select" class="btn-custom-pink"/>
          <a href="../../processData" class="btn-custom-pink" > Cancel</a>
        </div>
      </center>
    </form>
    <div class="vclear"></div>
  </div>


  <script>
      //== dropdown select ===============================================================
      //GET district
      function get_district(txt) {
        $.post('../../ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
          $('#selectdistrict').html(data);//alert(data);
        });
      }
      //GET divisions
      function get_division(txt) {
        $.post('../../ajax_dropdown.php', {checkval: 'division', district: txt}).done(function(data) {
          $('#selectdivision').html(data);//alert(data);
        });
      }
  </script>






  <?php
  error_reporting(0);

  function generatePDF_quotation($quotation) {


// always load alternative config file for examples
    require_once('tcpdf/examples/config/tcpdf_config_alt.php');

// Include the main TCPDF library (search the library on the following directories).
    $tcpdf_include_dirs = array(realpath('tcpdf/tcpdf.php'), '/usr/share/php/tcpdf/tcpdf.php', '/usr/share/tcpdf/tcpdf.php', '/usr/share/php-tcpdf/tcpdf.php', '/var/www/tcpdf/tcpdf.php', '/var/www/html/tcpdf/tcpdf.php', '/usr/local/apache2/htdocs/tcpdf/tcpdf.php');
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
        if ($this->getPage() == 1) {
          // Logo
          $image_file = K_PATH_IMAGES . 'evidence-action.jpg';
          // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
          $this->Image($image_file, 50, 10, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
          // Set font
          $this->SetFont('helvetica', 'B', 20);
          // Title
          // $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        }
      }

      // Page footer
      public function Footer() {
        if ($this->getPage() == 2) {
          // Logo
          $image_file = K_PATH_IMAGES . 'letterhead-footer.jpg';
          // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
          $this->Image($image_file, 30, 280, 150, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
          // ... footer for the normal page ...
        }
      }

    }

// create new PDF document
    $pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Cube Movers');
    $pdf->SetTitle('Quotation');
    $pdf->SetSubject('Quotation');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
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
    $html = $quotation;
//    $html = $quotation
//            . '<center><img src="' . $signatureurl . '"  width="140" border="0" /></center>'
//            . $signature;
// get the first array. This will be make part of the name of pdf
    $pdf_name = 'Quotation_.pdf';

// output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
//Close and output PDF document
// anything between ob_start and ob_end_clean will not be returned to ajax success message
    //ob_start();
//to save to a directory, just add the path before the name of the pdf.
    $pdf->Output('pdf/' . $pdf_name, 'FD');
//  $pdf->Output('Form_P_SchoolList.pdf', 'I');
//    ob_end_clean();

    return $pdf_name;
  }
  ?>