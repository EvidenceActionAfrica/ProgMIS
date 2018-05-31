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

                <h2>Form A Dash Board</h2>	

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

                  No. of districts covered for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of divisions covered for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of schools covered for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of children dewormed for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of children dewormed for STH (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of children dewormed for STH (female)


                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary School Aged' children dewormed for STH

                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  No. of 'Enrolled Primary School Aged' children dewormed for STH (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary School Aged' children dewormed for STH (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-10)' children dewormed for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-10)' children dewormed for STH (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-10)' children dewormed for STH (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (11-14)' children dewormed for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (11-14)' children dewormed for STH (male)


                </td>

                <td></td>

              </tr>         
              <tr>

                <td>

                  No. of 'Non Enrolled (11-14)' children dewormed for STH (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (15-18)' children dewormed for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (15-18)' children dewormed for STH (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (15-18)' children dewormed for STH (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-18)' children dewormed for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-18)' children dewormed for STH (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-18)' children dewormed for STH (female)


                </td>

                <td></td>

              </tr>          

              <tr>

                <td>

                  No. of 'U5' children dewormed for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'U5' children dewormed for STH (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'U5' children dewormed for STH (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (2-5)' children dewormed for STH

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (2-5)' children dewormed for STH (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (2-5)' children dewormed for STH (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'ECD' children dewormed for STH


                </td>

                <td></td>

              </tr>          
              <tr>

                <td>

                  No. of 'ECD' children dewormed for STH (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'ECD' children dewormed for STH (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Average No. of 'Non Enrolled (6-18)' children dewormed for STH per school

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Minimum No. of 'Non Enrolled (6-18)' children dewormed for STH per school

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Maximum No. of 'Non Enrolled (6-18)' children dewormed for STH per school

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Average No. of 'U5' children dewormed for STH per school

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  Minimum No. of 'U5' children dewormed for STH per school


                </td>

                <td></td>

              </tr>          

              <tr>

                <td>

                  Maximum No. of 'U5' children dewormed for STH per school

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of districts covered for Schisto

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of divisions covered for Schisto

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of schools covered for Schisto

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of children dewormed for Schisto

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of children dewormed for Schisto (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of children dewormed for Schisto (female)


                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  No. of 'Enrolled Primary School Aged' children dewormed for Schisto

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary School Aged' children dewormed for Schisto (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary School Aged' children dewormed for Schisto (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-10)' children dewormed for Schisto

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-10)' children dewormed for Schisto (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-10)' children dewormed for Schisto (female)


                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  No. of 'Non Enrolled (11-14)' children dewormed for Schisto

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (11-14)' children dewormed for Schisto (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (11-14)' children dewormed for Schisto (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (15-18)' children dewormed for Schisto


                </td>

                <td></td>

              </tr>          
              <tr>

                <td>

                  No. of 'Non Enrolled (15-18)' children dewormed for Schisto (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (15-18)' children dewormed for Schisto (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-18)' children dewormed for Schisto

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-18)' children dewormed for Schisto (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-18)' children dewormed for Schisto (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'ECD' children dewormed for Schisto

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'ECD' children dewormed for Schisto (male)


                </td>

                <td></td>

              </tr>          

              <tr>

                <td>

                  No. of 'ECD' children dewormed for Schisto (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary School Aged' children dewormed for STH in Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary School Aged' children dewormed for STH in Schisto School (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary School Aged' children dewormed for STH in Schisto School (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-10)' children dewormed for STH in Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-10)' children dewormed for STH in Schisto School (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-10)' children dewormed for STH in Schisto School (female)


                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  No. of 'Non Enrolled (11-14)' children dewormed for STH in Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (11-14)' children dewormed for STH in Schisto School (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (11-14)' children dewormed for STH in Schisto School (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (15-18)' children dewormed for STH in Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (15-18)' children dewormed for STH in Schisto School (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (15-18)' children dewormed for STH in Schisto School (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-18)' children dewormed for STH in Schisto School


                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  No. of 'Non Enrolled (6-18)' children dewormed for STH in Schisto School (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-18)' children dewormed for STH in Schisto School (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'U5' children dewormed for STH in Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'U5' children dewormed for STH in Schisto School(male)


                </td>

                <td></td>

              </tr>          
              <tr>

                <td>

                  No. of 'U5' children dewormed for STH in Schisto School(female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (2-5)' children dewormed for STH in Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (2-5)' children dewormed for STH in Schisto School(male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (2-5)' children dewormed for STH in Schisto School(female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'ECD' children dewormed for STH in Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'ECD' children dewormed for STH in Schisto School (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'ECD' children dewormed for STH in Schisto School (female)


                </td>

                <td></td>

              </tr>          

              <tr>

                <td>

                  No. of 'Enrolled Primary School Aged' children dewormed for STH in non-Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary School Aged' children dewormed for STH in non-Schisto School (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Enrolled Primary School Aged' children dewormed for STH in non-Schisto School (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-10)' children dewormed for STH in non-Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-10)' children dewormed for STH in non-Schisto School (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-10)' children dewormed for STH in non-Schisto School (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (11-14)' children dewormed for STH in non-Schisto School


                </td>

                <td></td>

              </tr>
              <tr>

                <td>

                  No. of 'Non Enrolled (11-14)' children dewormed for STH in non-Schisto School (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (11-14)' children dewormed for STH in non-Schisto School (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (15-18)' children dewormed for STH in non-Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (15-18)' children dewormed for STH in non-Schisto School (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (15-18)' children dewormed for STH in non-Schisto School (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-18)' children dewormed for STH in non-Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (6-18)' children dewormed for STH in non-Schisto School (male)


                </td>

                <td></td>

              </tr>  
              <tr>

                <td>

                  No. of 'Non Enrolled (6-18)' children dewormed for STH in non-Schisto School (female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'U5' children dewormed for STH in non-Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'U5' children dewormed for STH in non-Schisto School(male)


                </td>

                <td></td>

              </tr>          
              <tr>

                <td>

                  No. of 'U5' children dewormed for STH in non-Schisto School(female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (2-5)' children dewormed for STH in non-Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (2-5)' children dewormed for STH in non-Schisto School(male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'Non Enrolled (2-5)' children dewormed for STH in non-Schisto School(female)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'ECD' children dewormed for STH in non-Schisto School

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'ECD' children dewormed for STH in non-Schisto School (male)

                </td>

                <td></td>

              </tr>

              <tr>

                <td>

                  No. of 'ECD' children dewormed for STH in non-Schisto School (female)


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