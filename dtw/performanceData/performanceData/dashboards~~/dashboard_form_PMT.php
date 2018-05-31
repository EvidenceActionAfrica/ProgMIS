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
    <title>dashboard Form S</title>
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
              <a class="btn btn-primary" href="dashboard_attnt.php">ATTNT</a>
              <a class="btn btn-primary" href="dashboard_form_a.php">FORM A</a>
              <a class="btn btn-primary" href="dashboard_form_PMT.php">FORM PMT</a>
              <a class="btn btn-primary" href="dashboard_form_s_Dashboard.php">FORM S</a>
              <a class="btn btn-warning" href="dashboard_mtp.php">FORM MTP - old</a>

              <div class="">

                <h2>Form PMT Dash Board</h2>	

              </div>

              <div class="dashboard_export">

<!--                <a class="btn-custom-small" href="exportExcelMtpDashboard.php">Export To Excel</a>

                <a class="btn-custom-small" href="exportPdfMtp.php" target="_blank">Export To PDF</a>-->

              </div>

            </div>
            <div class="vclear"></div>
            <table id="hor-minimalist-b" >

              <th>Indicator</th>

              <th>Total</th>

              <!-- <h2>Coverage Indicators</h2> -->

              <tr>

                <td>

                  No. of districts planned for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of schools planned (baseline) for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of public schools for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of private schools for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'other' schools for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'no school type' schools for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary School' children for STH


                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  No. of 'Enrolled ECD' children for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Stand-alone ECD' children for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of ALB estimated for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of districts planned for SCHISTO

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of schools planned (baseline) for SCHISTO

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of public schools for SCHISTO

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of private schools for SCHISTO


                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  No. of 'other' schools for SCHISTO

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'no school type' schools for SCHISTO

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary School' children for SCHISTO

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled ECD' children for SCHISTO


                </td>

                <td></td>

              </tr>          
              <tr>

                <td>

                  No. of 'Stand-alone ECD' children for SCHISTO

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of PZQ estimated for SCHISTO

                </td>

                <td></td>

              </tr>
            </table>	

          </div>

        </div>

      </div>





      <!--End container class  -->

    </div>

  </body>

</html>