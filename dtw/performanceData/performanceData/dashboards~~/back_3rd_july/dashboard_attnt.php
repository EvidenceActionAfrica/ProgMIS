<?php
require_once ('includes/config.php');

require_once ('includes/auth.php');

require_once ("includes/functions.php");

require_once ("includes/form_functions.php");

include "queryFunctions.php";

$level = $_SESSION['level'];
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

    <div class="header">

      <div style="float: left">  <img src="images/logo.png" />  </div>

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

              <div class="dashboard_title_dash">

                <h2>ATTNT Dash Board</h2>

              </div>

              <div class="dashboard_export">

                <a class="btn-custom-small" href="exportExcelAttnt.php">Export To Excel</a>

                <a class="btn-custom-small" href="exportPdfAttnt.php" target="_blank">Export To PDF</a>

              </div>

            </div>
            <div class="vclear"></div>
            <!-- <form id="attnt_form" action="" method="post">  -->
            <table id="hor-minimalist-b">

              <th scope="col">Indicator</th>

              <th scope="col">Total</th>

              <tr>

                <td class="">

                  No. of districts covered

                </td>
                <td class="td-left"><?php echo $row1 = numDistinctPlain('attnt_district_id', 'attnt_bysch'); ?></td>
              </tr>



              <tr>



                <td class="">

                  No. of TTs

                </td>
                <td class="td-left"><?php echo $row2 = numDistinctPlain('attnt_id', 'attnt_bysch') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs for STH only

                </td>
                <td class="td-left"><?php echo $row3 = numDistinctFlexible('attnt_id', 'attnt_bysch', 'attnt_sth', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row4 = numDistinctFlexible('attnt_id', 'attnt_bysch', 'attnt_schisto', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with no drugs - for STH only

                </td>
                <td class="td-left"><?php echo $row5 = numAttntFlex('attnt_id', 'attnt_alb_tt', '0', 'attnt_pzq_tt', '0', 'attnt_sth', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with no drugs - for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row6 = numAttntFlex('attnt_id', 'attnt_alb_tt', '0', 'attnt_pzq_tt', '0', 'attnt_schisto', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with no drugs - All

                </td>
                <td class="td-left"><?php echo $row7 = numAttntFlex2('attnt_id', 'attnt_alb_tt', '0', 'attnt_pzq_tt', '0') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with PZQ only - for STH only

                </td>
                <td class="td-left"><?php echo $row8 = numAttntFlex('attnt_id', 'attnt_alb_tt', '0', 'attnt_pzq_tt', '1', 'attnt_sth', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with PZQ only - for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row9 = numAttntFlex('attnt_id', 'attnt_alb_tt', '0', 'attnt_pzq_tt', '1', 'attnt_schisto', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with PZQ only - All

                </td>
                <td class="td-left"><?php echo $row10 = numAttntFlex2('attnt_id', 'attnt_alb_tt', '0', 'attnt_pzq_tt', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with ALB only - for STH only

                </td>
                <td class="td-left"><?php echo $row11 = numAttntFlex('attnt_id', 'attnt_alb_tt', '1', 'attnt_pzq_tt', '0', 'attnt_sth', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with ALB only - for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row12 = numAttntFlex('attnt_id', 'attnt_alb_tt', '1', 'attnt_pzq_tt', '0', 'attnt_schisto', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with ALB only - All

                </td>
                <td class="td-left"><?php echo $row13 = numAttntFlex2('attnt_id', 'attnt_alb_tt', '1', 'attnt_pzq_tt', '0') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with both drugs - for STH only

                </td>
                <td class="td-left"><?php echo $row14 = numAttntFlex('attnt_id', 'attnt_alb_tt', '1', 'attnt_pzq_tt', '1', 'attnt_sth', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with both drugs - for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row15 = numAttntFlex('attnt_id', 'attnt_alb_tt', '1', 'attnt_pzq_tt', '1', 'attnt_schisto', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with both drugs - All

                </td>
                <td class="td-left"><?php echo $row16 = numAttntFlex2('attnt_id', 'attnt_alb_tt', '1', 'attnt_pzq_tt', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with drugs present

                </td>
                <td class="td-left"><?php echo $row17 = number_format($row17 = remove_comma($row11) + remove_comma($row15)) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of TTs with drugs missing

                </td>
                <td class="td-left"><?php echo $row18 = number_format($row18 = remove_comma($row5) + remove_comma($row6) + remove_comma($row9) + remove_comma($row12)) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools covered

                </td>
                <td class="td-left"><?php echo $row19 = numDistinctPlain('school_id', 'attnt_bysch'); ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools covered for STH only

                </td>
                <td class="td-left"><?php echo $row20 = numDistinctFlexible('school_id', 'attnt_bysch', 'attnt_sth', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools covered for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row21 = numDistinctFlexible('school_id', 'attnt_bysch', 'attnt_schisto', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with nothing distributed - for STH only

                </td>
                <td class="td-left"><?php echo $row22 = numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '0', 'attnt_sch_treatment', '0') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with nothing distributed - for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row23 = numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '0', 'attnt_sch_treatment', '1') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with nothing distributed - All

                </td>
                <td class="td-left"><?php echo $row24 = numAttntFlex('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '0') ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with forms only distributed - for STH only

                </td>
                <td class="td-left"><?php echo $row25 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '0')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with forms only distributed - for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row26 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '1')) ?></td>


              </tr>

              <tr>



                <td  class="">

                  No. of schools with forms only distributed - All

                </td>
                <td class="td-left"><?php echo $row27 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '1')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with poles only distributed - for STH only

                </td>
                <td class="td-left"><?php echo $row28 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '1', 'attnt_total_forms', '0', 'attnt_sch_treatment', '0')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with poles only distributed - for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row29 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '1', 'attnt_total_forms', '0', 'attnt_sch_treatment', '1')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with poles only distributed - All

                </td>
                <td class="td-left"><?php echo $row30 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '1', 'attnt_total_forms', '0')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with poles and forms distributed - for STH only

                </td>
                <td class="td-left"><?php echo $row31 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', '0')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with poles and forms distributed - for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row32 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', 'Treating for Bilharzia')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with poles and forms distributed - All

                </td>
                <td class="td-left"><?php echo $row33 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '1', 'attnt_total_forms', '1')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with drugs only distributed - for STH only

                </td>
                <td class="td-left"><?php echo $row34 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '0', 'attnt_sch_treatment', '0')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with drugs only distributed - for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row35 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '0', 'attnt_sch_treatment', 'Treating for Bilharzia')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with drugs only distributed - All

                </td>
                <td class="td-left"><?php echo $row36 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '0')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with drugs and forms distributed - for STH only

                </td>
                <td class="td-left"><?php echo $row37 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '0')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with drugs and forms distributed - for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row38 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', 'Treating for Bilharzia')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with drugs and forms distributed - All

                </td>
                <td class="td-left"><?php echo $row39 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '1')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with drugs and poles distributed - for STH only

                </td>
                <td class="td-left"><?php echo $row40 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '0', 'attnt_sch_treatment', '0')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with drugs and poles distributed - for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row41 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '0', 'attnt_sch_treatment', 'Treating for Bilharzia')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with drugs and poles distributed - All

                </td>
                <td class="td-left"><?php echo $row42 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '0')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with drugs, poles and forms distributed - for STH only

                </td>
                <td class="td-left"><?php echo $row43 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', '0')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with drugs, poles and forms distributed - for STH and Schisto

                </td>
                <td class="td-left"><?php echo $row44 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', 'Treating for Bilharzia')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with drugs, poles and forms distributed - All

                </td>
                <td class="td-left"><?php echo $row45 = number_format(numAttntFlex('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '1')) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with critical materials present

                </td>
                <td class="td-left"><?php echo $row46 = number_format($row46 = remove_comma($row37) + remove_comma($row44)) ?></td>


              </tr>

              <tr>



                <td class="">

                  No. of schools with critical materials missing

                </td class="">
                <td><?php echo $row47 = number_format($row47 = remove_comma($row24) + remove_comma($row27) + remove_comma($row30) + remove_comma($row33) + remove_comma($row36) + remove_comma($row38) + remove_comma($row42)) ?></td>
              </tr>

            </table>
            </form>

          </div>

        </div>

      </div>





      <!--End container class  -->

    </div>

  </body>

</html>