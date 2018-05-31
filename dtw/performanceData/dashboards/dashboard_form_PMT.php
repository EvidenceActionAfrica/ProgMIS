<?php
require_once ('../../includes/auth.php');
require_once ('../../includes/config.php');
// require_once ("includes/functions.php");
// require_once ("includes/form_functions.php");
include "queryFunctions.php";
// $level = $_SESSION['level'];
$data = "N/A";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>dashboard Form PMT</title>
    <?php require_once ("includes/meta-link-script.php"); ?>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header" style="height: 100px">
      <div style="float: left">  <img src="../../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php
        require_once ("includes/menuNav.php");
        require_once ("includes/loginInfo.php");
        ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-PerformanceData.php");
        ?>
      </div>
      <div class="contentBody">
        <div id="dashboard">
          <div id="indicator">
            <div class="dashboard_menu">
              <?php require_once ("includes/dashboard_form_nav.php"); ?>

              <div class="dashboard_export col-md-4 col-md-offset-2">
                <a class="btn-custom-small" href="">Export To Excel</a>
              </div>
              <div class="vclear"></div>
              <div class="row col-md-offset-4"> <h2>Form PMT Dash Board</h2> </div>     
              <u><b>Form P Dashboard </b></u>Provides information used for planning of the deworming activity. A total of XX schools in ZZ divisions in YY sub-counties were planned to participate in the year’s deworming activity. Planning occurred between ZZ Month Year and ZZ Month Year
              <br/><br/>
            </div>

            <div id="dvData"style="width:100%; height:380px; overflow-x: visible; overflow-y: scroll; ">
              <table id="hor-minimalist-b" >

                <th>Indicator</th>
                <th>Total</th>
                <!-- <h2>Coverage Indicators</h2> -->
                <tr>
                  <td> No. of districts planned for STH </td> <td class="td-left"><?php echo numDistinctPlain('district_name ', 'a_bysch'); ?>
                </tr>                                
                <tr>
                  <td> No. of schools planned (baseline) for STH </td> <td class="td-left"><?php echo number_format(numFlexible('p_sch_id', 'p_bysch', 'p_sch_closed', 'No')); ?>
                </tr>
                <tr>
                  <td> No. of public schools for STH </td> <td class="td-left"><?php echo number_format(numFlexible_2('p_sch_id', 'p_bysch', 'p_sch_type', 'Public', 'p_sch_closed', 'No')); ?></td>
                </tr>	
                <tr>
                  <td> No. of Private schools for STH </td> <td class="td-left"><?php echo number_format(numFlexible_2('p_sch_id', 'p_bysch', 'p_sch_type', 'Private', 'p_sch_closed', 'No')); ?></td>
                </tr>	
                <tr>
                  <td> No. of 'other' schools for STH </td> <td class="td-left"><?php echo number_format(numFlexible_2('p_sch_id', 'p_bysch', 'p_sch_type', 'Other', 'p_sch_closed', 'No')); ?></td>
                </tr>	
                <tr>
                  <td> No. of 'Not specified' schools for STH </td> <td class="td-left"><?php echo number_format(numFlexible_2_Notsp()); ?></td>
                </tr>
                <tr>
                  <td> No. of 'Enrolled Primary School' children for STH </td></td><td class="td-left"><?php echo number_format(sumDonor('p_pri_enroll', 'p_bysch', 'p_sch_closed', 'No') + sumDonor('p_ecd_enroll', 'p_bysch', 'p_sch_closed', 'No')); ?></td>
                </tr>
                <tr>
                  <td> No. of 'Enrolled ECD' children for STH </td> <td class="td-left"><?php echo number_format(sumDonor('p_ecd_enroll', 'p_bysch', 'p_sch_closed', 'No')) ?></td>
                </tr>
                <tr>
                  <td> No. of 'Stand-alone ECD' children for STH </td> <td class="td-left"><?php echo number_format(sumDonor('p_ecd_sa_enroll', 'p_bysch', 'p_sch_closed', 'No')) ?></td>
                </tr>
                <tr>
                  <td> No. of ALB estimated for STH </td> <td class="td-left"><?php echo number_format(sumDonor('p_alb', 'p_bysch', 'p_sch_closed', 'No')) ?></td>
                </tr>
                <tr>
                  <td> No. of districts planned for SCHISTO </td> <td class="td-left"><?php echo number_format(numDistinctP('district_id', 'Y')) ?></td>

                </tr>
                <tr>
                  <td> No. of schools planned (baseline) for SCHISTO </td> <td class="td-left"><?php echo number_format(numFlexibleDonor1('p_sch_id', 'p_bysch', 'p_sch_bilharzia', 'Y', 'p_sch_closed', 'No')) ?></td>
                </tr>
                <tr>
                  <td> No. of public schools for SCHISTO </td> <td class="td-left"><?php echo number_format(numSchoolType('Public')) ?></td>
                </tr>
                <tr>
                  <td> No. of private schools for SCHISTO </td> <td class="td-left"><?php echo number_format(numSchoolType('Private')) ?></td>
                </tr>
                <tr>
                  <td> No. of 'other' schools for SCHISTO </td> <td class="td-left"><?php echo number_format(numSchoolType('Other')) ?></td>
                </tr>
                <tr>
                  <td> No. of 'no school type' schools for SCHISTO </td> <td class="td-left"><?php echo number_format(numSchoolTypeNotSpecified()) ?></td>
                </tr>
                <tr>
                  <td> No. of 'Enrolled Primary School' children for SCHISTO </td> <td class="td-left"><?php echo number_format(sumDonorOpenSch('p_pri_enroll', 'p_bysch', 'p_sch_bilharzia', 'Y', 'p_sch_closed', 'No') + sumDonorOpenSch('p_ecd_enroll', 'p_bysch', 'p_sch_bilharzia', 'Y', 'p_sch_closed', 'No')) ?></td>
                </tr>
                <tr>
                  <td> No. of 'Enrolled ECD' children for SCHISTO </td> <td class="td-left"><?php echo number_format(sumDonorOpenSch('p_ecd_enroll', 'p_bysch', 'p_sch_bilharzia', 'Y', 'p_sch_closed', 'No')) ?></td>
                </tr>          
                <tr>
                  <td> No. of 'Stand-alone ECD' children for SCHISTO </td> <td class="td-left"><?php echo number_format(sumEstimated('p_ecd_sa_enroll', 'Y')) ?></td>
                </tr>
                <tr>
                  <td> No. of PZQ estimated for SCHISTO </td> <td class="td-left"><?php echo number_format(sumDonorOpenSch('p_pzq', 'p_bysch', 'p_sch_bilharzia', 'Y', 'p_sch_closed', 'No')) ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div> 
      <!--End container class  -->
    </div>

    <script>
      $(document).ready(function() {

        function exportTableToCSV($table, filename) {

          var $rows = $table.find('tr:has(td)'),
                  // Temporary delimiter characters unlikely to be typed by keyboard
                  // This is to avoid accidentally splitting the actual contents
                  tmpColDelim = String.fromCharCode(11), // vertical tab character
                  tmpRowDelim = String.fromCharCode(0), // null character

                  // actual delimiter characters for CSV format
                  colDelim = '","',
                  rowDelim = '"\r\n"',
                  // Grab text from table into CSV formatted string
                  csv = '"' + $rows.map(function(i, row) {
            var $row = $(row),
                    $cols = $row.find('td');

            return $cols.map(function(j, col) {
              var $col = $(col),
                      text = $col.text();

              return text.replace('"', '""'); // escape double quotes

            }).get().join(tmpColDelim);

          }).get().join(tmpRowDelim)
                  .split(tmpRowDelim).join(rowDelim)
                  .split(tmpColDelim).join(colDelim) + '"',
                  // Data URI
                  csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

          $(this)
                  .attr({
            'download': filename,
            'href': csvData,
            'target': '_blank'
          });
        }

        // This must be a hyperlink
        $(".btn-custom-small").on('click', function(event) {
          // CSV
          exportTableToCSV.apply(this, [$('#dvData>table'), 'export.csv']);

          // IF CSV, don't do event.preventDefault() or return false
          // We actually need this to be a typical hyperlink
        });
      });
    </script>        
  </body>
</html>