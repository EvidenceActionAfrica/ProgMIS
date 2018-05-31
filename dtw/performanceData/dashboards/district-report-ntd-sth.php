<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); // use root
$placeholder = "N/A";
$tabActive = "tab1"; //wierdness
$placeholder = "No Data";

include "includes/class.ntd.php";
$ntd = new ntd; //instatiate

$data = $ntd->getAll(); // get all the data from the table
// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {

  $priv_ciff_kpi = $row['priv_ciff_kpi'];
  $priv_ciff_report = $row['priv_ciff_report'];
  $priv_end_fund = $row['priv_end_fund'];
  $priv_ntd = $row['priv_ntd'];
  $priv_usaid = $row['priv_usaid'];
  $priv_who = $row['priv_who'];
}
if ($priv_ciff_kpi == 0 && $priv_ciff_report == 0 && $priv_end_fund == 0 && $priv_ntd == 0 && $priv_usaid == 0 && $priv_who == 0) {

  header("Location:../../home.php");
} else {
  ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
    <head>
      <title>Evidence Action</title>
      <?php require_once ("includes/meta-link-script.php"); ?>
      <script type="text/javascript">
        < script type = "text/javascript" src = "http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" ></script>

      <script type="text/javascript">
                jQuery(document).ready(function() {
          jQuery(".content00").hide();
          //toggle the componenet with class msg_body
          jQuery(".heading00").click(function()
          {
            jQuery(this).next(".content00").slideToggle(300);
          });
        });
      </script>
    </head>
    <body>
      <!---------------- header start ------------------------>
      <div class="header vnav_100px">
        <div style="float: left">  <img src="../../images/logo.png" />  </div>
        <div class="menuLinks">
          <?php require_once ("includes/menuNav.php"); ?> 
          <?php //require_once ("includes/loginInfo.php");   ?> 
        </div>
      </div>
      <div class="clearFix"></div>
      <!---------------- content body ------------------------>
      <div class="contentMain">
        <div class="contentLeft">
          <?php require_once ("includes/menuLeftBar-PerformanceData.php"); ?>
        </div>
        <div class="contentBody">
          <!--================================================-->
          <div id="loading">
            <img id="loading-image" src="../../images/loading.gif" alt="Loading..." />
          </div>

          <?php require_once "includes/reporting-menu-tabs.php"; ?>


          <div class="dashboard_menu">
            <?php require_once "includes/reporting-menu-tabs.php"; ?>
            <div class="dashboard_export col-md-4 col-md-offset-2">

              <?php if ($priv_ciff_report >= 1) { ?>
                <a id="btn-custom-small" class="btn-custom-small" href="">Export To Excel</a> 
                <!-- <a class="btn-custom-small" href="exportPdfDistrictALBReport.php" target="_blank">Export To PDF</a> -->
              <?php } ?>
            </div>
            <div class="vclear"></div>
            <div class="row col-md-offset-4">
              <h2>District STH Report</h2>
            </div>
            <u><b> NTD ALB Dashboard </b></u> provides sub-county level statistics from form A on STH treatment as is required for NTD reporting. The data included in this dashboard was collected at XX schools covering YY sub-counties between ZZ Month Year and ZZ Month Year
            <br/><br/>
          </div>

          <!-- start table -->

          <table id="data-tablePZQ" class="display">
            <thead>
              <th>County</th>
              <th>District Name</th>
              <!-- <th>Rounds</th> -->
              <!-- <th>Year</th> -->
              <!-- <th>Month</th> -->
              <th>Schools Treated</th>
              <th>SAC Treated</th>
              <th>15+ Treated</th>
              <th>SAC Male Treated</th>
              <th>SAC Female Treated</th>
              <th>of 15+ Male Treated</th>
              <th>of 15+ Female Treated</th>
              <!-- <th>Adults Treated</th> -->
              <!-- <th>Target U5</th> -->
              <!-- <th>Target SAC</th> -->
              <!-- <th>Target Adult</th> -->
            </thead>
            <tbody>
              <?php
              foreach ($data as $key => $value) {
                ?>
                <tr>
                  <td><?php echo $ntd->getDistrictCounty($value['district_id'], 'name'); ?></td>
                  <td><?php echo $ntd->getDistName($value['district_id']); ?></td>
                  <!-- <td>N/A</td> -->
                  <!-- <td>N/A</td> -->
                  <!-- <td>N/A</td> -->
                  <td><?php echo $ntd::notavailable($value['schools_treated']); ?></td>
                  <td><?php echo $ntd::notavailable($value['sac_treated']); ?></td>
                  <td><?php echo $ntd::notavailable($value['over_15_treated']); ?></td>
                  <td><?php echo $ntd::notavailable($value['sac_male_treated']); ?></td>
                  <td><?php echo $ntd::notavailable($value['sac_female_treated']); ?></td>
                  <td><?php echo $ntd::notavailable($value['over_15_male_treated']); ?></td>
                  <td><?php echo $ntd::notavailable($value['over_15_female_treated']); ?></td>
                  <!-- <td><?php //echo $ntd::notavailable($value['adults_treated']);      ?></td> -->
                  <!-- <td><?php //echo $ntd::notavailable($value['target_u5']);      ?></td> -->
                  <!-- <td><?php //echo $ntd::notavailable($value['target_sac']);      ?></td> -->
                  <!-- <td><?php //echo $ntd::notavailable($value['target_adult']);      ?></td> -->
                </tr>
                <?php
              }
              ?>

            </tbody>

          </table>


          <!-- end table -->

        </div>

      </div> <!-- end content body-->





      <!--================================================-->
      </div><!--end of content Main -->
      </div>
      <div class="clearFix"></div>
      <!---------------- Footer ------------------------>
      <!--<div class="footer">  </div>-->
    </body>
  </html>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">


    <?php
  }
  ob_flush();
  ?>



  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">

    <script type="text/javascript">
      $(document).ready(function() {

        $('#data-tablePZQ').dataTable({
          "scrollY": "300px",
          "scrollX": "100%",
          "scrollCollapse": true
        });

      });
    </script>

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
        $("#btn-custom-small").on('click', function(event) {
          // CSV
          exportTableToCSV.apply(this, [$('.dataTables_scrollBody>table'), 'export.csv']);

          // IF CSV, don't do event.preventDefault() or return false
          // We actually need this to be a typical hyperlink
        });
      });
    </script>




