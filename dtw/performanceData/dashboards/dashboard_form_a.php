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
    <title>dashboard Form A</title>
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
              <div class="row col-md-offset-4"> <h2>Form A Dash Board</h2> </div>      
              <u><b> Form A Dashboard </b></u> provides sub-county level treatment statistics as reported on Form A, filled out by the Divisional Educational Officer. This dashboard includes data from a total of XX schools from YY sub-counties who returned their forms between ZZ Month Year and ZZ Month Year 
              <br/><br/>
            </div>

            <div class="vclear"></div>
            <div id="dvData" style="width:100%; height:380px; overflow-x: visible; overflow-y: scroll; ">                         
              <table id="hor-minimalist-b" >
                <th>Indicator</th>
                <th>Total</th>
                <!-- <h2>Coverage Indicators</h2> -->

                <tr> <td> No. of districts covered for STH </td> <td class="td-left"><?php echo number_format(numDistinctPlain('district_name ', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of divisions covered for STH </td> <td class="td-left"><?php echo number_format(numDistinctPlain('division_name ', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of schools covered for STH </td> <td class="td-left"><?php echo number_format(numDistinctPlain('school_id ', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of children dewormed for STH </td> <td class="td-left"><?php echo number_format(sumPlain('a_total_child', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of children dewormed for STH (male) </td> <td class="td-left"><?php echo number_format(sumPlain('a_total_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of children dewormed for STH (female) </td> <td class="td-left"><?php echo number_format(sumPlain('a_total_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Enrolled Primary School Aged' children dewormed for STH </td> <td class="td-left"><?php echo number_format(sumPlain('a_trt_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Enrolled Primary School Aged' children dewormed for STH (male) </td> <td class="td-left"><?php echo number_format(sumPlain('a_trt_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Enrolled Primary School Aged' children dewormed for STH (female) </td> <td class="td-left"><?php echo number_format(sumPlain('a_trt_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (6-10)' children dewormed for STH </td> <td class="td-left"><?php echo number_format(sumPlain('a_6_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (6-10)' children dewormed for STH (male) </td> <td class="td-left"><?php echo number_format(sumPlain('a_6_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (6-10)' children dewormed for STH (female) </td> <td class="td-left"><?php echo number_format(sumPlain('a_6_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (11-14)' children dewormed for STH </td> <td class="td-left"><?php echo number_format(sumPlain('a_11_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (11-14)' children dewormed for STH (male) </td> <td class="td-left"><?php echo number_format(sumPlain('a_11_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (11-14)' children dewormed for STH (female) </td> <td class="td-left"><?php echo number_format(sumPlain('a_11_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (15-18)' children dewormed for STH </td> <td class="td-left"><?php echo number_format(sumPlain('a_15_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (15-18)' children dewormed for STH (male) </td> <td class="td-left"><?php echo number_format(sumPlain('a_15_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (15-18)' children dewormed for STH (female) </td> <td class="td-left"><?php echo number_format(sumPlain('a_15_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (6-18)' children dewormed for STH </td> <td class="td-left"><?php echo number_format(sumPlain('a_6_18_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (6-18)' children dewormed for STH (male) </td> <td class="td-left"><?php echo number_format(sumPlain('a_6_18_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (6-18)' children dewormed for STH (female) </td> <td class="td-left"><?php echo number_format(sumPlain('a_6_18_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'U5' children dewormed for STH </td> <td class="td-left"><?php echo number_format(sumPlain('a_u5_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'U5' children dewormed for STH (male) </td> <td class="td-left"><?php echo number_format(sumPlain('a_u5_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'U5' children dewormed for STH (female) </td> <td class="td-left"><?php echo number_format(sumPlain('a_u5_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (2-5)' children dewormed for STH </td> <td class="td-left"><?php echo number_format(sumPlain('a_2_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (2-5)' children dewormed for STH (male) </td> <td class="td-left"><?php echo number_format(sumPlain('A_2_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (2-5)' children dewormed for STH (female) </td> <td class="td-left"><?php echo number_format(sumPlain('a_2_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'ECD' children dewormed for STH </td> <td class="td-left"><?php echo number_format(sumPlain('a_ecd_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'ECD' children dewormed for STH (male) </td> <td class="td-left"><?php echo number_format(sumPlain('a_ecd_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'ECD' children dewormed for STH (female) </td> <td class="td-left"><?php echo number_format(sumPlain('a_ecd_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> Average No. of 'Non Enrolled (6-18)' children dewormed for STH per school </td> <td class="td-left"><?php echo number_format(averageSumCount('a_6_18_total', 'a_bysch', 'school_id', 'a_bysch')) ?></td> </tr>

                <tr> <td> Minimum No. of 'Non Enrolled (6-18)' children dewormed for STH per school </td> <td class="td-left"><?php echo number_format(minimum('a_6_18_total', 'a_bysch')) ?></td> </tr>

                <tr> <td> Maximum No. of 'Non Enrolled (6-18)' children dewormed for STH per school </td> <td class="td-left"><?php echo number_format(maximum('a_6_18_total', 'a_bysch')) ?></td> </tr>

                <tr> <td> Average No. of 'U5' children dewormed for STH per school </td> <td class="td-left"><?php echo number_format(averageSumCount('a_u5_total', 'a_bysch', 'school_id', 'a_bysch')) ?></td> </tr>

                <tr> <td> Minimum No. of 'U5' children dewormed for STH per school </td> <td class="td-left"><?php echo number_format(minimum('a_u5_total', 'a_bysch')) ?></td> </tr>

                <tr> <td> Maximum No. of 'U5' children dewormed for STH per school </td> <td class="td-left"><?php echo number_format(maximum('a_u5_total', 'a_bysch')) ?></td> </tr>

                <tr> <td> No. of districts covered for Schisto </td> <td class="td-left"><?php echo number_format(numDistinctFlexible('district_name', 'a_bysch', 'ap_attached', 'Yes')) ?></td> </tr>


                <tr> <td> No. of divisions covered for Schisto </td> <td class="td-left"><?php echo number_format(numDistinctFlexible('division_name', 'a_bysch', 'ap_attached', 'Yes')) ?></td> </tr>

                <tr> <td> No. of schools covered for Schisto </td> <td class="td-left"><?php echo number_format(numDistinctFlexible('school_id', 'a_bysch', 'ap_attached', 'Yes')) ?></td> </tr>

                <tr> <td> No. of children dewormed for Schisto </td> <td class="td-left"><?php echo number_format(sumPlain('ap_total_child', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of children dewormed for Schisto (male) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_total_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of children dewormed for Schisto (female) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_total_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Enrolled Primary School Aged' children dewormed for Schisto </td> <td class="td-left"><?php echo number_format(sumPlain('ap_trt_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Enrolled Primary School Aged' children dewormed for Schisto (male) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_trt_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Enrolled Primary School Aged' children dewormed for Schisto (female) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_trt_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (6-10)' children dewormed for Schisto </td> <td class="td-left"><?php echo number_format(sumPlain('ap_6_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (6-10)' children dewormed for Schisto (male) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_6_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (6-10)' children dewormed for Schisto (female) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_6_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (11-14)' children dewormed for Schisto </td> <td class="td-left"><?php echo number_format(sumPlain('ap_11_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (11-14)' children dewormed for Schisto (male) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_11_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (11-14)' children dewormed for Schisto (female) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_11_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (15-18)' children dewormed for Schisto </td> <td class="td-left"><?php echo number_format(sumPlain('ap_15_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (15-18)' children dewormed for Schisto (male) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_15_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (15-18)' children dewormed for Schisto (female) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_15_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (6-18)' children dewormed for Schisto </td> <td class="td-left"><?php echo number_format(sumPlain('ap_6_18_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (6-18)' children dewormed for Schisto (male) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_6_18_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'Non Enrolled (6-18)' children dewormed for Schisto (female) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_6_18_f', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'ECD' children dewormed for Schisto </td> <td class="td-left"><?php echo number_format(sumPlain('ap_ecd_total', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'ECD' children dewormed for Schisto (male) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_ecd_m', 'a_bysch')); ?></td> </tr>

                <tr> <td> No. of 'ECD' children dewormed for Schisto (female) </td> <td class="td-left"><?php echo number_format(sumPlain('ap_ecd_f', 'a_bysch', 'Yes')); ?></td> </tr>

                <tr> <td> No. of Enrolled Primary School Aged children dewormed for STH in Schisto School </td> <td class="td-left"><?php echo number_format(sum('a_trt_total', 'a_bysch', 'Yes')) ?></td> </tr>

                <tr> <td> No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Male) </td> <td class="td-left"><?php echo number_format(sum('a_trt_m', 'a_bysch', 'Yes')) ?></td> </tr>

                <tr> <td> No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Female) </td> <td class="td-left"><?php echo number_format(sum('a_trt_f', 'a_bysch', 'Yes')) ?></td> </tr>

                <tr> <td> No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School </td> <td class="td-left"><?php echo number_format(sum('a_6_total', 'a_bysch', 'Yes')) ?></td> </tr>

                <tr> <td> No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Male) </td> <td class="td-left"><?php echo number_format(sum('a_6_m', 'a_bysch', 'Yes')) ?></td> </tr>

                <tr> <td> No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Female) </td> <td class="td-left"><?php echo number_format(sum('a_6_f', 'a_bysch', 'Yes')) ?></td> </tr>

                <tr> <td> No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School </td> <td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_11_m', 'a_11_f')) ?></td> </tr>

                <tr> <td> No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Male) </td> <td class="td-left"><?php echo number_format(sum('a_11_m', 'a_bysch', 'Yes')) ?></td> </tr>

                <tr> <td> No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Female) </td> <td class="td-left"><?php echo number_format(sum('a_11_f', 'a_bysch', 'Yes')) ?></td> </tr>

                <tr> <td> No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School </td> <td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_15_m', 'a_15_f')) ?></td> </tr>

                <tr> <td> No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Male) </td> <td class="td-left"><?php echo number_format(sum('a_15_m', 'a_bysch', 'Yes')) ?></td> </tr>

                <tr> <td> No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Female) </td> <td class="td-left"><?php echo number_format(sum('a_15_f', 'a_bysch', 'Yes')) ?></td> </tr>

                <tr> <td> No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School </td> <td class="td-left"><?php echo number_format(sum('a_6_18_total', 'a_bysch', 'Yes')) ?></td> </tr>

                <tr>
                  <td> No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Male) </td> <td class="td-left"><?php echo number_format(sum('a_6_18_m', 'a_bysch', 'Yes')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Female) </td> <td class="td-left"><?php echo number_format(sum('a_6_18_f', 'a_bysch', 'Yes')) ?></td>
                </tr>


                <tr>
                  <td> No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School </td> <td class="td-left"><?php echo $row81 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_6_m', 'a_6_f')) ?></td>

                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Male) </td> <td class="td-left"><?php echo $row82 = number_format(sum('a_6_m', 'a_bysch', 'Yes')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Female) </td> <td class="td-left"><?php echo $row83 = number_format(sum('a_6_f', 'a_bysch', 'Yes')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School </td> <td class="td-left"><?php echo $row84 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_11_m', 'a_11_f')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Male) </td> <td class="td-left"><?php echo $row85 = number_format(sum('a_11_m', 'a_bysch', 'Yes')) ?></td>

                </tr>


                <tr>
                  <td> No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Female) </td> <td class="td-left"><?php echo $row86 = number_format(sum('a_11_f', 'a_bysch', 'Yes')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School </td> <td class="td-left"><?php echo $row87 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_15_m', 'a_15_f')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Male) </td> <td class="td-left"><?php echo $row88 = number_format(sum('a_15_m', 'a_bysch', 'Yes')) ?></td>
                </tr>


                <tr>
                  <td> No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Female) </td> <td class="td-left"><?php echo $row89 = number_format(sum('a_15_f', 'a_bysch', 'Yes')) ?></td>
                </tr> 


                <tr>
                  <td> No. of U5 children dewormed for STH in Schisto School </td> <td class="td-left"><?php echo $row90 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_2_m', 'a_2_f', 'a_ecd_m', 'a_ecd_f')) ?></td>
                </tr> 


                <tr>
                  <td> No. of U5 children dewormed for STH in Schisto School(Male) </td> <td class="td-left"><?php echo $row91 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_2_m', 'a_ecd_m')) ?></td>
                </tr> 


                <tr>
                  <td> No. of U5 children dewormed for STH in Schisto School(Female) </td> <td class="td-left"><?php echo $row92 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_2_f', 'a_ecd_f')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School </td> <td class="td-left"><?php echo $row93 = number_format(sum('a_2_total', 'a_bysch', 'Yes')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Male) </td> <td class="td-left"><?php echo $row94 = number_format(sum('a_2_m', 'a_bysch', 'Yes')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Female) </td> <td class="td-left"><?php echo $row95 = number_format(sum('a_2_f', 'a_bysch', 'Yes')) ?></td>
                </tr> 


                <tr>
                  <td> No. of ECD children dewormed for STH in Schisto School </td> <td class="td-left"><?php echo $row96 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_ecd_m', 'a_ecd_f')) ?></td>
                </tr>


                <tr>
                  <td> No. of ECD children dewormed for STH in Schisto School (Male) </td> <td class="td-left"><?php echo $row97 = number_format(sum('a_ecd_m', 'a_bysch', 'Yes')) ?></td>
                </tr> 


                <tr>
                  <td> No. of ECD children dewormed for STH in Schisto School (Female) </td> <td class="td-left"><?php echo $row98 = number_format(sum('a_ecd_f', 'a_bysch', 'Yes')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School </td> <td class="td-left"><?php echo $row99 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_trt_m', 'a_trt_f')) ?></td>
                </tr>


                <tr>
                  <td> No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Male) </td> <td class="td-left"><?php echo $row100 = number_format(sum('a_trt_m', 'a_bysch', 'No')) ?></td>

                </tr> 


                <tr>
                  <td> No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Female) </td> <td class="td-left"><?php echo $row101 = number_format(sum('a_trt_f', 'a_bysch', 'No')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School </td> <td class="td-left"><?php echo $row105 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_6_m', 'a_6_f')) ?></td>
                </tr>


                <tr>
                  <td> No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Male) </td> <td class="td-left"><?php echo $row106 = number_format(sum('a_6_m', 'a_bysch', 'No')) ?></td>

                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Female) </td> <td class="td-left"><?php echo $row107 = number_format(sum('a_6_f', 'a_bysch', 'No')) ?></td>
                </tr>


                <tr>
                  <td> No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School </td> <td class="td-left"><?php echo $row108 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_11_m', 'a_11_f')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Male) </td> <td class="td-left"><?php echo $row109 = number_format(sum('a_11_m', 'a_bysch', 'No')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Female) </td> <td class="td-left"><?php echo $row110 = number_format(sum('a_11_f', 'a_bysch', 'No')) ?></td>
                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School </td> <td class="td-left"><?php echo $row111 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_15_m', 'a_15_f')) ?></td>

                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Male) </td> <td class="td-left"><?php echo $row112 = number_format(sum('a_15_m', 'a_bysch', 'No')) ?></td>

                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Female) </td> <td class="td-left"><?php echo $row113 = number_format(sum('a_15_f', 'a_bysch', 'No')) ?></td>

                </tr>


                <tr>
                  <td> No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School </td> <td class="td-left"><?php echo $row102 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_6_f', 'a_6_m', 'a_11_f', 'a_11_m', 'a_15_f', 'a_15_m')) ?></td>

                </tr>


                <tr>
                  <td> No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Male) </td> <td class="td-left"><?php echo $row103 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_6_m', 'a_11_m', 'a_15_m')) ?></td>


                </tr> 


                <tr>
                  <td> No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Female) </td> <td class="td-left"><?php echo $row104 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_6_f', 'a_11_f', 'a_15_f')) ?></td>

                </tr>  


                <tr>
                  <td> No. of U5 children dewormed for STH in non-Schisto School </td> <td class="td-left"><?php echo $row114 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_ecd_m', 'a_ecd_f', 'a_2_f', 'a_2_m')) ?></td>

                </tr> 


                <tr>
                  <td> No. of U5 children dewormed for STH in non-Schisto School(Male) </td> <td class="td-left"><?php echo $row115 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_ecd_m', 'a_2_m')) ?></td>

                </tr> 
                <tr>
                  <td> No. of U5 children dewormed for STH in non-Schisto School(Female) </td> <td class="td-left"><?php echo $row116 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_ecd_f', 'a_2_f')) ?></td>

                </tr> 
                <tr>
                  <td> No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School </td> <td class="td-left"><?php echo $row117 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_2_m', 'a_2_f')) ?></td>

                </tr> 
                <tr>
                  <td> No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Male) </td> <td class="td-left"><?php echo $row118 = number_format(sum('a_2_m', 'a_bysch', 'No')) ?></td>


                </tr> 
                <tr>
                  <td> No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Female) </td> <td class="td-left"><?php echo $row119 = number_format(sum('a_2_f', 'a_bysch', 'No')) ?></td>

                </tr> 
                <tr>
                  <td> No. of ECD children dewormed for STH in non-Schisto School </td> <td class="td-left"><?php echo $row120 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_ecd_m', 'a_ecd_f')) ?></td>

                </tr> 
                <tr>
                  <td> No. of ECD children dewormed for STH in non-Schisto School (Male) </td> <td class="td-left"><?php echo $row121 = number_format(sum('a_ecd_m', 'a_bysch', 'No')) ?></td>

                </tr> 
                <tr>
                  <td> No. of ECD children dewormed for STH in non-Schisto School (Female) </td> <td class="td-left"><?php echo $row122 = number_format(sum('a_ecd_f', 'a_bysch', 'No')) ?></td>

                </tr>

              </table>                        
            </div>
          </div>
        </div>
      </div>

      <!--End container class  -->
    </div>
  </body>

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
</html>