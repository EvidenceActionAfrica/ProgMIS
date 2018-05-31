<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require_once ('../../includes/auth.php');

require_once ('../../includes/config.php');
// require_once ("includes/form_functions.php");
include "queryFunctions.php";

$data = "Data";
// include "dashFormSFunctions.php"; 
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



        <div id="content">

          <!-- <div id="form-title">
      
            <h1>Form S Dashboard</h1>
      
          </div> -->

          <div id="dashboard">

            <div id="indicator">

              <div class="dashboard_menu">

                <div class="dashboard_title_dash">

                  <h2>Form S Dash Board</h2>	

                </div>

                <div class="dashboard_export">

                  <a class="btn-custom-small" href="exportExcelFormSDashboard.php">Export To Excel</a>

                  <a class="btn-custom-small" href="exportPdfFormS.php" target="_blank">Export To PDF</a>

                </div>

              </div>
              <div class="vclear"></div>
              <table id="hor-minimalist-b">



                <th scope="col">Indicator</th>

                <th scope="col">Total</th>



                <tr>



                  <td>No. of districts covered</td>

                  <td><?php echo $row1 = numDistinctPlain('s_district_id', 's_bysch'); ?></td>

                </tr>

                <tr>



                  <td>No. of schools covered</td>

                  <td><?php echo $row2 = numDistinctPlain('s_prog_sch_id', 's_bysch'); ?></td>

                </tr>

                <tr>



                  <td>No. dewormed (children + adults)</td>

                  <td><?php echo $row3 = sumDewormedPlusAudultsSbysch('STH'); ?></td>

                </tr>

                <tr>



                  <td>No. of children dewormed</td>

                  <td><?php echo $row4 = sumChildrenSbysch('STH'); ?></td>

                </tr>

                <tr>



                  <td>Average children dewormed per district</td>

                  <td><?php echo $row5 = number_format(childAverage('s_bysch', 's_district_id'), 2, '.', ''); ?></td>

                </tr>

          <!-- <tr>



            <td>Range of district coverage (max district average)</td>

            <td><?php echo $row6 = $data ?> </td>

          </tr>

          <tr>



            <td>Range of district coverage (min district average)</td>

            <td><?php echo $row7 = $data ?> </td>

          </tr>

          <tr> -->



                <td>No. of 'Enrolled Primary + Enrolled ECD' children dewormed</td>

                <td><?php echo $row8 = number_format(addValues(sumArgs('s_bysch', 's_ecd_treated_male', 's_ecd_treated_male'), sumPriEnrolledSbysch('STH'))) ?></td>

                </tr>

                <tr>



                  <td>No. of 'ECD' children dewormed</td>

                  <td><?php echo $row9 = number_format(sumArgs('s_bysch', 's_ecd_treated_male', 's_ecd_treated_male')); ?></td>

                </tr>

                <tr>



                  <td>No. of ECD Male children dewormed</td>

                  <td><?php echo $row10 = number_format(sumPlain('s_ecd_treated_male', 's_bysch')); ?></td>


                </tr>

                <tr>



                  <td>No. of ECD Female children dewormed</td>

                  <td><?php echo $row11 = number_format(sumPlain('s_ecd_treated_female', 's_bysch')); ?></td>

                </tr>

                <tr>



                  <td>No. of 'Primary' children dewormed</td>

                  <td><?php echo $row12 = number_format(sumPriChildrenSbysch('STH')); ?></td>

                </tr>

                <tr>



                  <td>No. of Primary Male children dewormed</td>

                  <td><?php echo $row13 = number_format(sumMaleAbove6Sbysch('STH')); ?></td>

                </tr>

                <tr>



                  <td>No. of Primary Female children dewormed</td>

                  <td><?php echo $row14 = number_format(sumFemaleAbove6Sbysch('STH')); ?></td>

                </tr>

                <tr>



                  <td>No. of Primary children registered</td>

                  <td><?php echo $row15 = number_format(sumPriRegisteredSbysch('STH')); ?></td>

                </tr>

                <tr>



                  <td>No. of Male Primary children registered</td>

                  <td><?php echo $row16 = number_format(sumPriGenderRegisteredSbysch('male')); ?></td>

                </tr>

                <tr>



                  <td>No. of Female Primary children registered</td>

                  <td><?php echo $row17 = number_format(sumPriGenderRegisteredSbysch('female')); ?></td>

                </tr>

                <tr>


                  <td>No. of 'Non Enrolled' children dewormed</td>

                  <td><?php echo $row18 = number_format(sumNonEnrolledSbysch('STH')); ?></td>

                </tr>

                <tr>


                  <!-- #check -->
                  <td>No. of children aged 2-5 years dewormed</td>

                  <td><?php echo $row19 = number_format(sumArgs('s_bysch', 's_nonenroll_2_5yrs_m', 's_nonenroll_2_5yrs_f')); ?></td>

                </tr>

                <tr>



                  <td>No. of male children aged 2-5 years dewormed</td>

                  <td><?php echo $row20 = number_format(sumPlain('s_nonenroll_2_5yrs_m', 's_bysch')); ?></td>

                </tr>

                <tr>



                  <td>No. of female children aged 2-5 years dewormed</td>

                  <td><?php echo $row21 = number_format(sumPlain('s_nonenroll_2_5yrs_f', 's_bysch')); ?></td>

                </tr>

                <tr>



                  <td>No. of children aged 6+ years dewormed</td>

                  <td><?php echo $row22 = number_format(sumPriChildrenSbysch('STH')); ?></td>

                </tr>

                <tr>


                  <td>No. of male children aged 6+ years dewormed</td>

                  <td><?php echo $row23 = number_format(sumMaleAbove6Sbysch('STH')); ?></td>

                </tr>

                <tr>



                  <td>No. of female children aged 6+ years dewormed</td>

                  <td><?php echo $row24 = number_format(sumFemaleAbove6Sbysch('STH')); ?></td>

                </tr>

                <tr>


                  <!-- #stopped -->
                  <td>No. of adults dewormed</td>

                  <td><?php echo $row25 = number_format(sumAdultsFormS('STH')); ?></td>

                </tr>

                <tr></tr>

                <tr></tr>







                <tr>

                  <td><h2>Supply Estimation Indicators</h2></td>

                  <td></td>

                </tr>

                <tr>

                  <td>No. of tablets spoilt</td>

                  <td><?php echo $row26 = number_format(sumTabletsSpoilt('STH')); ?></td>

                </tr>

                <tr>

                  <td>No. of tablets supplied</td>

                  <td><?php echo $row27 = number_format(sumPlain('s_alb_received', 's_bysch')); ?></td>

                </tr>

                <tr>

                  <td>No. of tablets used (includes tablets given to children and adults and tablets spoilt)</td>

                  <td><?php echo $row28 = number_format(sumPlain('s_alb_use', 's_bysch')); ?></td>

                </tr>

                <tr>

                  <td>No. of tablets returned</td>

                  <td><?php echo $row29 = number_format(sumPlain('s_alb_returned', 's_bysch')); ?></td>

                </tr>

                <tr>

                  <td>Ratio of tablets used to supplied</td>

                  <td><?php echo $row30 = number_format(divisionValues(sumPlain('s_alb_use', 's_bysch'), sumPlain('s_alb_received', 's_bysch')), 2, '.', ''); ?></td>

                </tr>

                <tr>

                  <td>Ratio of tablets spolit to tablets supplied</td>

                  <td><?php echo $row31 = number_format(sumPLain('s_spoilt_total', 's_bysch') / sumPLain('s_alb_received', 's_bysch'), 2, '.', ''); ?></td>

                </tr>




                <!-- #stopped -->
                <tr></tr>

                <tr></tr>

                <tr>

                  <td><h2>SCHISTO Indicators</h2></td>

                  <td> </td>

                </tr>

                <tr>

                  <td>No. of districts covered</td>

                  <td><?php echo $row32 = numDistinctFlexible('s_district_id', 's_bysch', 'sp_attached', 'Yes') ?></td>

                </tr>

                <tr>

                  <td>No. of schools covered</td>

                  <td><?php echo $row33 = numDistinctFlexible('s_prog_sch_id', 's_bysch', 'sp_attached', 'Yes') ?> </td>

                </tr>

                <tr>

                  <td>No. dewormed (children + adults)</td>

                  <td><?php echo $row34 = sumDewormedPlusAudultsSbysch('SCHISTO') ?> </td>

                </tr>

                <tr>

                  <td>No. of children dewormed</td>

                  <td><?php echo $row35 = sumChildrenSbysch('SHISTO') ?> </td>

                </tr>

                <tr>
                  <td>No. of 'Enrolled Primary + Enrolled ECD' children dewormed</td>

                  <td><?php echo $row36 = number_format(addValues(sumPriEnrolledSbysch('SHISTO'), sumArgs('s_bysch', 's_ecd_treated_male', 's_ecd_treated_female'))) ?> </td>

                </tr>

                <tr>

                  <td>No. of 'ECD' children dewormed</td>
                  <td><?php echo $row37 = number_format(sumArgs('s_bysch', 'sp_ecd_m', 'sp_ecd_f')) ?> </td>

                </tr>

                <tr>

                  <td>No. of 'Primary' children dewormed</td>

                  <td><?php echo $row38 = number_format(sumPriChildrenSbysch('SHISTO')) ?> </td>

                </tr>

                <tr>

                  <td>No. of Primary Male children dewormed</td>

                  <td><?php echo $row39 = number_format(sumMaleAbove6Sbysch('SHISTO')) ?> </td>

                </tr>

                <tr>

                  <td>No. of Primary Female children dewormed</td>

                  <td><?php echo $row40 = number_format(sumFemaleAbove6Sbysch('SHISTO')) ?> </td>

                </tr>

                <tr>

                  <td>No. of Primary children registered</td>

                  <td><?php echo $row41 = number_format(sumPriRegisteredSbysch('SHISTO')) ?> </td>

                </tr>

                <tr>

                  <td>No. of 'Non Enrolled' children dewormed</td>

                  <td><?php echo $row42 = number_format(sumNonEnrolledSbysch('SHISTO')) ?> </td>

                </tr>

                <tr>

                  <td>No. of adults dewormed</td>

                  <td><?php echo $row43 = number_format(sumAdultsFormS('SHISTO')) ?> </td>

                </tr>

                <tr>

                  <td>No. of tablets spoilt</td>

                  <td><?php echo $row44 = number_format(sumTabletsSpoilt('SHISTO')) ?> </td>

                </tr>

                <tr>

                  <td>No. of tablets supplied</td>

                  <td><?php echo $row45 = number_format(sumPlain('sp_pzq_received', 's_bysch')) ?> </td>

                </tr>

                <tr>

                  <td>No. of tablets used (includes tablets given to children and adults and tablets spoilt)</td>

                  <td><?php echo $row46 = number_format(sumplain('sp_pzq_use', 's_bysch')) ?> </td>

                </tr>

                <td>No. of tablets returned</td>
                <td><?php echo $row47 = number_format(sumPlain('sp_pzq_returned', 's_bysch')) ?> </td>

              </table>





              </ul>

            </div>







          </div>



        </div>





        <!--End container class  -->

      </div>

  </body>

</html>