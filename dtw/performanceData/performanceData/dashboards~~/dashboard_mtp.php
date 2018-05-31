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
              <a class="btn btn-warning" href="dashboard_mtp.php">FORM MTP - old</a>

              <div class="">

                <h2>MT-P Dash Board</h2>	

              </div>

              <div class="dashboard_export">
<!--
                <a class="btn-custom-small" href="exportExcelMtpDashboard.php">Export To Excel</a>

                <a class="btn-custom-small" href="exportPdfMtp.php" target="_blank">Export To PDF</a>-->

              </div>

            </div>
            <div class="vclear"></div>
            <table id="hor-minimalist-b">

              <th>Indicator</th>

              <th>Total</th>

              <!-- <h2>Coverage Indicators</h2> -->

              <tr>

                <td>

                  Planning Indicators

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of districts planned

                </td>

                <td><?php echo $row1 = numDistinctPlain('district_id', 'p_bysch'); ?></td>

              </tr>

              <tr>

                <td>

                  Teacher training related indicators

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of teacher trainings planned

                </td>

                <td><?php echo $row2 = number_format(sumPlain('mt_sessions', 'mt_district_summary_by_div')); ?></td>

              </tr>

              <tr>

                <td>

                  Average No. of schools planned per teacher training

                </td>

                <td><?php echo $row3 = number_format(averagePlain('p_sch_id', 'p_bysch', 'mt_sessions', 'mt_district_summary_by_div'), 2, '.', ''); ?></td>

              </tr>

              <tr>

                <td>

                  Minimum No. of schools planned per teacher training

                </td>

                <td><?php echo $row4 = minimum('mt_sessions', 'mt_district_summary_by_div'); ?></td>

              </tr>

              <tr>

                <td>

                  Maximum No. of schools planned per teacher training

                </td>

                <td><?php echo $row5 = maximum('mt_sessions', 'mt_district_summary_by_div'); ?></td>

              </tr>

            <!-- <tr>

              <td>

                Average days between Teacher Training and Deworming Day

              </td>

              <td><?php echo $row6 = $data; ?></td>

            </tr>

            <tr>

              <td>

                Minimum days between Teacher Training and Deworming Day

              </td>

              <td><?php echo $row7 = $data; ?></td>

            </tr>

            <tr>

              <td>

                Maximum days between Teacher Training and Deworming Day

              </td>

              <td><?php echo $row8 = $data; ?></td>

            </tr>

            <tr>

              <td>

                Proportion of Deworming Days taking place within 15 days of the Teacher Training

              </td>

              <td><?php echo $row9 = $data; ?></td>

            </tr>

            <tr>

              <td>

                Coverage planned

              </td>

              <td></td>

            </tr> -->

              <tr>

                <td>

                  No. of schools planned (baseline)

                </td>

                <td><?php echo $row10 = number_format(numDistinctPlain('p_sch_id', 'p_bysch')); ?></td>

              </tr>

              <tr>

                <td>

                  No. of public schools

                </td>

                <td><?php echo $row11 = number_format(numFlexible('p_sch_id', 'p_bysch', 'p_sch_type', 'Public')); ?></td>

              </tr>

              <tr>

                <td>

                  No. of private schools

                </td>

                <td><?php echo $row12 = number_format(numFlexible('p_sch_id', 'p_bysch', 'p_sch_type', 'Private')); ?></td>

              </tr>

              <tr>

                <td>

                  No. of 'other' schools

                </td>

                <td><?php echo $row13 = number_format(numFlexible('p_sch_id', 'p_bysch', 'p_sch_type', 'Other')); ?></td>

              </tr>

              <tr>

                <td>

                  No. of 'no school type' schools

                </td>

                <td><?php echo $row14 = number_format(numFlexible('p_sch_id', 'p_bysch', 'p_sch_type', 'None')); ?></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary School' children

                </td>

                <td><?php echo $row15 = number_format(sumPlain('p_pri_enroll', 'p_bysch')); ?></td>

              </tr>

              <tr>

                <td>

                  Average No. of 'Enrolled Primary School' children per school

                </td>

                <td><?php echo $row16 = number_format(averagePlain('p_pri_enroll', 'p_bysch', 'p_sch_id', 'p_bysch'), 2, '.', ''); ?></td>

              </tr>

              <tr>

                <td>

                  Minimum No. of 'Enrolled Primary School' children per school

                </td>

                <td><?php echo $row17 = minimum('p_pri_enroll', 'p_bysch'); ?></td>

              </tr>

              <tr>

                <td>

                  Maximum No. of 'Enrolled Primary School' children per school

                </td>

                <td><?php echo $row18 = number_format(maximum('p_pri_enroll', 'p_bysch')); ?></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled ECD' children

                </td>

                <td><?php echo $row19 = number_format(sumPlain('p_ecd_enroll', 'p_bysch')); ?></td>

              </tr>

              <tr>

                <td>

                  Average No. of 'Enrolled ECD' children per school

                </td>

                <td><?php echo $row20 = number_format(averagePlain('p_ecd_enroll', 'p_bysch', 'p_sch_id', 'p_bysch')); ?></td>

              </tr>

              <tr>

                <td>

                  Minimum No. of 'Enrolled ECD' children per school

                </td>

                <td><?php echo $row21 = minimum('p_ecd_enroll', 'p_bysch'); ?></td>

              </tr>

              <tr>

                <td>

                  Maximum No. of 'Enrolled ECD' children per school

                </td>

                <td><?php echo $row22 = maximum('p_ecd_enroll', 'p_bysch'); ?></td>

              </tr>

              <tr>

                <td>

                  No. of 'Stand-alone ECD' children

                </td>

                <td><?php echo $row23 = sumPlain('p_ecd_sa_enroll', 'p_bysch'); ?></td>

              </tr>

              <tr>

                <td>

                  Average No. of 'Stand-alone ECD' children per school

                </td>

                <td><?php echo $row24 = averagePlain('p_ecd_sa_enroll', 'p_bysch', 'p_sch_id', 'p_bysch'); ?></td>

              </tr>

              <tr>

                <td>

                  Minimum No. of 'Stand-alone ECD' children per school

                </td>

                <td><?php echo $row25 = minimum('p_ecd_sa_enroll', 'p_bysch'); ?></td>

              </tr>

              <tr>

                <td>

                  Maximum No. of 'Stand-alone ECD' children per school

                </td>

                <td><?php echo $row26 = maximum('p_ecd_sa_enroll', 'p_bysch'); ?></td>

              </tr>

            <!-- <tr>

              <td>

                No. of tablets estimated (total+20%)

              </td>

              <td><?php echo markup20(sum('no_of_tablets_needed_total', 'form_p_school_list')); ?></td>

            </tr> -->

            <!-- <tr>

              <td>

                Average No. of tablets estimated (total+20%) per school

              </td>

              <td><?php ?></td>

            </tr>

            <tr>

              <td>

                Minimum No. of tablets estimated (total+20%) per school

              </td>

              <td><?php echo $data; ?></td>

            </tr>

            <tr>

              <td>

                Maximum No. of tablets estimated (total+20%) per school

              </td>

              <td><?php echo $data; ?></td>

            </tr> -->



            </table>	

          </div>

        </div>

      </div>





      <!--End container class  -->

    </div>

  </body>

</html>