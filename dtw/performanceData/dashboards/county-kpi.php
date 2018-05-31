<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); // use root
require_once("includes/class.CountyEpxand.php");

$CountyExpand = new CountyExpand();
$counties = $CountyExpand->getCounties();

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
  exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>

  </head>
  <body>
    <!--- header start-->
    <div class="header vnav_100px">
      <div style="float: left">  <img src="../../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?> 
        <?php //require_once ("includes/loginInfo.php");  ?> 
      </div>
    </div>
    <div class="clearFix"></div>
    <!-- content body -->
    <div class="contentMain">

      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-PerformanceData.php"); ?>
      </div>
      <div class="contentBody">

        <div id="loading">
          <img id="loading-image" src="../../images/loading.gif" alt="Loading..." />
        </div>

        <div class="dashboard_menu">
          <?php require_once "includes/reporting-menu-tabs.php"; ?>
          <div class="dashboard_export col-md-4 col-md-offset-2">


            <?php if ($priv_ciff_report >= 1) { ?>
              <a id="btn-custom-small" class="btn-custom-small" href="">Export To Excel</a> 
              <a class="btn-custom-small" href="exportPdfCountyReport.php" target="_blank">Export To PDF</a>                         
            <?php } ?>

          </div><br/><br/>
          <div class="vclear"></div>
          <div class="row col-md-offset-5">
            <h2>County KPIs</h2>
          </div>
          <u><b>County Dashboard</b></u> provides county-level summary data on planning, Training and Deworming activities as collected from the Forms P, ATTNT and Forms S, A, D collected at XX schools covering YY sub-counties. The data included was collected between ZZ Month Year and ZZ Month Year. 
          <br/><br/>
        </div>

        <!--================================================-->
        <style>
          td {
            text-align: center;
          }
        </style>
        <table id="data-table" >
          <thead>
            <tr>
              <th>County</th>
              <th>Total children dewormed</th>
              <th>% children treated who were enrolled</th>
              <th>% treated who were u5</th>
              <th>% treated who were non- enrolled</th>
              <th>COVERAGE  of enrolled children treated (of form p) ALB</th>
              <th>COVERAGE  of enrolled children treated (of form p) PZQ</th>
              <th>Schools planned</th>
              <th>Schools trained</th>
              <th>Schools receiving critical material at TT</th>
              <th>Schools treated of STH</th>
              <th>Schools treated for SCHISTO</th>
            </tr>
          </thead>

          <tbody>
            <?php
            foreach ($counties as $key => $county) {
              ?>
              <tr>
                <td><?php echo $county['county'] ?></td>
                <td><?php echo number_format($CountyExpand->sum_simple('a_total_child', 'a_bysch', 'county_id', $county['county_id'])) ?></td>
                <td><?php
                  echo CountyExpand::PERCENT(
                          $CountyExpand->percentageSimple(
                                  $CountyExpand->sumArgsByCounty(
                                          'a_bysch', $county['county_id'], 'county_id', 'a_ecd_total', 'a_trt_total'
                                  ), $CountyExpand->sumPlainByCounty(
                                          'a_total_child', 'a_bysch', 'county_id', $county['county_id']
                                  )
                          )
                  )
                  ?></td>
                <td><?php echo CountyExpand::PERCENT($CountyExpand->percentageSum('a_u5_total', 'a_total_child', $county['county_id'])) ?></td>
                <td><?php echo CountyExpand::PERCENT($CountyExpand->percentageSum('a_2_18_total', 'a_total_child', $county['county_id'])) ?></td>
                <td><?php
                  echo CountyExpand::PERCENT(
                          $CountyExpand->percentageSimple(
                                  $CountyExpand->sumArgsByCounty(
                                          'a_bysch', $county['county_id'], 'county_id', 'a_trt_total ', 'a_ecd_total'
                                  ), $CountyExpand->sumArgsByCountyP(
                                          'p_bysch', $county['county_id'], 'p_pri_enroll', 'p_ecd_enroll', 'p_ecd_sa_enroll'
                                  )
                          )
                  )
                  ?></td>
                <td><?php
                  echo CountyExpand::PERCENT(
                          $CountyExpand->percentageSimple(
                                  $CountyExpand->sumArgsByCounty(
                                          'a_bysch', $county['county_id'], 'county_id', 'ap_trt_total ', 'ap_ecd_total'
                                  ), $CountyExpand->sumArgsByCountyPShisto(
                                          'p_bysch', $county['county_id'], 'p_pri_enroll', 'p_ecd_enroll', 'p_ecd_sa_enroll'
                                  )
                          )
                  )
                  ?></td>
                <!-- <td><?php //echo number_format($CountyExpand->sumArgsByCountyP('p_bysch', $county['county_id'], 'p_pri_enroll', 'p_ecd_enroll', 'p_ecd_sa_enroll') )    ?></td> -->
                <td><?php echo number_format($CountyExpand->countPlainP('p_sch_id', 'p_bysch', $county['county_id'])) ?></td>
                <!-- Schools trained -->
                <td><?php echo number_format($CountyExpand->numPlainByCounty('school_id', 'attnt_bysch', 'countyid', $county['county_id'])) ?></td>
                <td><?php echo number_format(($CountyExpand->attntWithCriticalMaterials1('school_id', $county['county_id'])) + ($CountyExpand->attntWithCriticalMaterials2('school_id', $county['county_id']))) ?></td>
                <td><?php echo number_format($CountyExpand->numPlain('school_id', $county['county_id'])) ?></td>
                <td><?php echo number_format($CountyExpand->numPlainShisto('school_id', $county['county_id'])) ?></td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>


        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!-- Footer -->
  </body>
</html>


<script type="text/javascript">
  $(document).ready(function() {
    // $('#data-table').dataTable();

    $('#data-table').dataTable({
      "scrollY": "300px",
      "scrollX": "100%",
      "scrollCollapse": true
    });
  });
</script>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
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
