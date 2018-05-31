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
                <h2>Form S Dash Board</h2>	

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

                  Coverage Indicators

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of districts covered

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of schools covered

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Proportion of schools covered (no. of schools covered/total schools)(Form P:16855) 

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of public schools covered

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of private schools covered

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'other' schools covered


                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  No. of 'no school type' schools

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. dewormed (children + adults)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Average children dewormed per district

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Range of district coverage (max district average)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Range of district coverage (min district average)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary + Enrolled ECD' children dewormed


                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  No. of 'ECD' children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of ECD Male children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of ECD Female children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Primary' children dewormed


                </td>

                <td></td>

              </tr>          
              <tr>

                <td>

                  No. of 'Class 1' children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Class 2' children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Class 3' children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Class 4' children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Class 5' children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Class 6' children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Class 7' children dewormed


                </td>

                <td></td>

              </tr>          

              <tr>

                <td>

                  No. of 'Class 8' children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of Primary Male children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of Primary Female children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of Primary children registered

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of Male Primary children registered

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of Female Primary children registered

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Proportion of registered primary school children dewormed (no. of children dewormed/no. of children registered)


                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  Proportion of schools with atleast 100% coverage (no. of schools with 100% of registered children dewormed/no. of scools covered)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Proportion of schools with atleast 95% coverage (no. of schools with atleast 95% of registered children dewormed/no. of scools covered)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Proportion of schools with atleast 75% coverage (no. of schools with atleast 75% of registered children dewormed/no. of scools covered)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Proportion of schools with atleast 50% coverage (no. of schools with atleast 50% of registered children dewormed/no. of scools covered)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled' children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of children aged 2-5 years dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of male children aged 2-5 years dewormed


                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  No. of female children aged 2-5 years dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of children aged 6+ years dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of male children aged 6+ years dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of female children aged 6+ years dewormed


                </td>

                <td></td>

              </tr>          
              <tr>

                <td>

                  No. of adults dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Proportion of adults covered (no. of adults covered/no. dewormed)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of tablets spoilt

                </td>

                <td></td>

              </tr>

              <tr>

                <td>


                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Supply Estimation Indicators

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of tablets supplied

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of tablets used (includes tablets given to children and adults and tablets spoilt)


                </td>

                <td></td>

              </tr>          

              <tr>

                <td>

                  No. of tablets returned

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Ratio of tablets used to supplied

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Ratio of tablets spolit to tablets supplied

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Ratio of children registered to tablets supplied

                </td>

                <td></td>

              </tr>

              <tr>

                <td>


                </td>

                <td></td>

              </tr>

              <tr>

                <td>


                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  SCHISTO Indicators


                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  No. of districts covered

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of schools covered

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. dewormed (children + adults)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary + Enrolled ECD' children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'ECD' children dewormed

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Primary' children dewormed


                </td>

                <td></td>

              </tr> 

              <tr>

                <td>

                  No. of Primary Male children dewormed


                </td>

                <td></td>

              </tr> 

              <tr>

                <td>

                  No. of Primary Female children dewormed



                </td>

                <td></td>

              </tr> 

              <tr>

                <td>

                  No. of Primary children registered



                </td>

                <td></td>

              </tr> 

              <tr>

                <td>

                  No. of 'Non Enrolled' children dewormed



                </td>

                <td></td>

              </tr> 

              <tr>

                <td>

                  No. of adults dewormed



                </td>

                <td></td>

              </tr> 

              <tr>

                <td>

                  No. of tablets spoilt



                </td>

                <td></td>

              </tr> 

              <tr>

                <td>

                  No. of tablets supplied



                </td>

                <td></td>

              </tr> 

              <tr>

                <td>

                  No. of tablets used (includes tablets given to children and adults and tablets spoilt)




                </td>

                <td></td>

              </tr> 


              <tr>

                <td>

                  No. of tablets returned




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