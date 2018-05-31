<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); // use root
$placeholder = "N/A";
$tabActive = "tab1"; //wierdness
$placeholder = "No Data";
// include "kpiFunctionsCiff.php";
include "queryFunctions.php";

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
        $(window).load(function() {
          $('#loading').hide();
        });

      </script>

      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

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


          <div id="dashboard">
            <div id="indicator">

              <div class="dashboard_menu">
                <?php require_once "includes/reporting-menu-tabs.php"; ?>
                <div class="dashboard_export col-md-4 col-md-offset-2">


                  <?php if ($priv_ciff_report >= 1) { ?>
                    <a id="btn-custom-small" class="btn-custom-small" href="exportExcelUsaidKpi.php">Export To Excel</a>
                    <a class="btn-custom-small" href="exportPdfUsaidKpi.php" target="_blank">Export To PDF</a>
                  <?php } ?>
                </div>
                <div class="vclear"></div>
                <div class="row col-md-offset-5">

                  <h2>USAID REPORT</h2>
                </div>
                <u><b> USAID Dashboard </b></u> provides Planning Training and Deworming indicators as required for USAID quarterly and annual reports. The data included was collected at XX schools covering YY sub-counties between ZZ Month Year and ZZ Month Year
                <br/><br/>
              </div>


              <table id="hor-minimalist-b">
                <th scope="col">Indicator</th>
                <th scope="col">Total</th>
                <tr>
                  <td>
                    No. of schools treated for STH
                  </td>
                  <td class="td-left"><?php echo $row1 = number_format(num('school_id', 'a_bysch')) ?></td>
                </tr>	
                <tr>
                  <td>
                    No. of schools targeted for STH
                  </td>
                  <td class="td-left"><?php echo $row2 = number_format(num('p_sch_id', 'p_bysch')) ?></td>
                </tr>	
                <tr>
                  <td>
                    Estimated target population of STH
                  </td>
                  <td class="td-left"><?php echo $row3 = number_format(EstimatedTotalSTH()) ?></td>
                </tr>
                <tr>
                  <td>
                    No. of  children dewormed for STH once
                  </td>
                  <td class="td-left"><?php echo $row4 = number_format(sumSTH()); ?></td>
                </tr>
                <tr>
                  <td>
                    No. of schools attending teacher training
                  </td>
                  <td class="td-left"><?php echo $row5 = numDistinctPlain('school_id', 'attnt_bysch') ?></td>
                </tr>
                <tr>
                  <td>
                    No. of schools with critical materials present
                  </td>
                  <td class="td-left"><?php echo $row6 = number_format(attntWithCriticalMaterials()) ?></td>
                </tr>
                <tr>
                  <td>
                    No. of schools with poles
                  </td>
                  <td class="td-left"><?php echo $row7 = number_format(numFlexible('school_id', 'attnt_bysch', 'attnt_total_poles', '1')) ?></td>
                </tr>
                <tr>
                  <td>
                    No. of TTs with requiered drugs
                  </td>
                  <td class="td-left"><?php echo $row8 = number_format(numFlexible('attnt_id', 'attnt_bysch', 'attnt_total_drugs', '1')) ?></td>
                </tr>
                <tr>
                  <td>
                    No. of Gok district personnel at regional training
                  </td>
                  <td class="td-left"><?php echo $row9 = number_format(gok_district()) ?></td>
                </tr>
                <tr>
                  <td>
                    No. of Gok divisional personnel at regional training
                  </td>
                  <td class="td-left"><?php echo $row10 = number_format(gok_division()) ?></td>
                </tr>
              </table>
            </div>
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

    <script type="text/javascript">
      $(document).ready(function() {
        $('#data-table').dataTable();

      });
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
        $('table.display').dataTable();
      })
    </script>

    <?php
  }
  ob_flush();
  ?>

