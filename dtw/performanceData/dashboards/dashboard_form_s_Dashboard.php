<?php
require_once ('../../includes/auth.php');
require_once ('../../includes/config.php');
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
              <?php require_once ("includes/dashboard_form_nav.php"); ?>

              <div class="dashboard_export col-md-4 col-md-offset-2">
                <a class="btn-custom-small" href="">Export To Excel</a>
              </div>
              <div class="vclear"></div>
              <div class="row col-md-offset-4"> <h2>FORM S Dash Board</h2> </div>
              <u><b>Form S Dashboard </b></u>provides treatment statistics as reported on Form S  filled out by Head teachers. A total of XX schools returned their forms between ZZ Month Year and ZZ Month Year from YY sub-counties
              <br/><br/>
            </div>

            <div id="dvData" style="width:100%; height:380px; overflow-x: visible; overflow-y: scroll; ">
              <table id="hor-minimalist-b">
                <th>Indicator</th>
                <th>Total</th>
                <!-- <h2>Coverage Indicators</h2> -->
                <tr>
                  <td> No. of districts covered </td> <td class="td-left"><?php echo numDistinctPlain('s_district_id', 's_bysch'); ?></td>
                </tr>
                <tr>
                  <td> No. of schools covered </td> <td class="td-left"><?php echo numDistinctPlain('s_prog_sch_id', 's_bysch'); ?></td>
                </tr>
                <tr>
                  <td> Proportion of schools covered (no. of schools covered/total schools) </td> <td class="td-left"><?php echo round(divisionValues(num('s_prog_sch_id', 's_bysch'), num('school_id', 'schools')) * 100, 2) ?></td>
                </tr>
                <tr>
                  <td> No. of public schools covered </td> <td class="td-left"><?php echo number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'public')); ?></td>
                </tr>
                <tr>
                  <td> No. of private schools covered </td> <td class="td-left"><?php echo number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'private')); ?></td>
                </tr>
                <tr>
                  <td> No. of 'other' schools covered </td> <td class="td-left"><?php echo number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'other')); ?></td>
                </tr>
                <tr>
                  <td> No. of 'Not specified' schools </td> <td class="td-left"><?php echo number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'Not specified')); ?></td>
                </tr>
                <tr>
                  <td> No. dewormed (children + adults) </td> <td class="td-left"><?php echo number_format(sumPlain('S_total_all', 's_bysch')); ?></td>   
                </tr>
                <tr>
                  <td> No. of children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('S_total_child', 's_bysch')); ?></td> 
                </tr>
                <tr>
                  <td> Average children dewormed per district </td> <td class="td-left"><?php echo round(divisionValues(sumPlain('S_total_child', 's_bysch'), numDistinctPlain('s_district_id', 's_bysch')), 2) ?></td>  
                </tr>
                <tr>
                  <td> Range of district coverage (max district average) </td> <td class="td-left"><?php echo number_format(districtMaxAverage('s_total_child', 's_bysch', 's_district_id')); ?> </td>  
                </tr>
                <tr>
                  <td> Range of district coverage (min district average) </td> <td class="td-left"><?php echo number_format(districtMinAverage('s_total_child', 's_bysch', 's_district_id')); ?></td>  
                </tr>
                <tr>
                  <td> No. of 'Enrolled Primary + Enrolled ECD' children dewormed </td> <td class="td-left"> <?php echo number_format(sumPlain('s_total_treated', 's_bysch') + sumPlain('s_ecd_total', 's_bysch')) ?></td> 
                </tr>
                <tr>
                  <td> No. of 'ECD' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_ecd_total', 's_bysch')); ?></td> 
                </tr>
                <tr>
                  <td> No. of ECD Male children dewormed </td><td class="td-left"><?php echo number_format(sumPlain('s_ecd_treated_male', 's_bysch')); ?></td> 
                </tr>
                <tr>
                  <td> No. of ECD Female children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_ecd_treated_female', 's_bysch')); ?></td>   
                </tr>
                <tr>
                  <td> No. of 'Primary' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_total_treated', 's_bysch')); ?></td>
                </tr>          
                <tr>
                  <td> No. of 'Class 1' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_total_treated1', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of 'Class 2' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_total_treated2', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of 'Class 3' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_total_treated3', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of 'Class 4' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_total_treated4', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of 'Class 5' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_total_treated5', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of 'Class 6' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_total_treated6', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of 'Class 7' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_total_treated7', 's_bysch')); ?></td>
                </tr>          
                <tr>
                  <td> No. of 'Class 8' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_total_treated8', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of Primary Male children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_treated_m', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of Primary Female children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_treated_f', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of Primary children registered </td> <td class="td-left"><?php echo number_format(sumPlain('s_total_registered', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of Male Primary children registered </td> <td class="td-left"><?php echo number_format(sumPlain('s_registered_m', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of Female Primary children registered </td> <td class="td-left"><?php echo number_format(sumPlain('s_registered_f', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> Proportion of registered primary school children dewormed (no. of children dewormed/no. of children registered) </td> <td class="td-left"> <?php echo round(divisionValues(sumPlain('s_total_treated', 's_bysch'), sumPlain('s_total_registered', 's_bysch')) * 100, 2); ?></td>
                </tr>
                <tr>
                  <td> Proportion of schools with atleast 100% coverage (no. of schools with 100% of registered children dewormed/no. of scools covered) </td> <td class="td-left"><?php echo round(divisionValues(hunderdPercentProp(), numDistinctPlain('s_prog_sch_id', 's_bysch')) * 100, 2); ?></td>
                </tr>
                <tr>
                  <td> Proportion of schools with atleast 100% coverage (no. of schools with 100% of registered children dewormed/no. of scools covered) </td> <td class="td-left"><?php echo round(divisionValues(ninetyfivePercentProp(), numDistinctPlain('s_prog_sch_id', 's_bysch')) * 100, 2); ?></td>
                </tr>
                <tr>
                  <td>
                    Proportion of schools with atleast 75% coverage (no. of schools with atleast 75% of registered children dewormed/no. of scools covered)
                  </td>
                  <td class="td-left"><?php echo round(divisionValues(seventyfivePercentProp(), numDistinctPlain('s_prog_sch_id', 's_bysch')) * 100, 2); ?></td>
                </tr>
                <tr>
                  <td> Proportion of schools with atleast 50% coverage (no. of schools with atleast 50% of registered children dewormed/no. of scools covered) </td> <td class="td-left"><?php echo round(divisionValues(fiftyPercentProp(), numDistinctPlain('s_prog_sch_id', 's_bysch')) * 100, 2); ?></td>
                </tr>
                <tr>
                  <td> No. of 'Non Enrolled' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_2_18_total', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of children aged 2-5 years dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_2_5yrs_total', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of male children aged 2-5 years dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_nonenroll_2_5yrs_m', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of female children aged 2-5 years dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_nonenroll_2_5yrs_f', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of children aged 6+ years dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_6_18_total', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of male children aged 6+ years dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_6_18_m', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of female children aged 6+ years dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_6_18_f', 's_bysch')); ?></td>
                </tr>          
                <tr>
                  <td> No. of adults dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('s_adult_total', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> Proportion of adults covered (no. of adults covered/no. dewormed) </td> <td class="td-left"> <?php echo round(divisionValues(sumPlain('s_adult_total', 's_bysch'), sumPlain('s_total_all', 's_bysch')), 4); ?></td>
                </tr>
                <tr>
                  <td> No. of tablets spoilt </td> <td class="td-left"><?php echo number_format(sumPlain('s_spoilt_total', 's_bysch')); ?></td>
                </tr>
                <tr class="highlighter_tr">
                  <td> Supply Estimation Indicators </td> <td></td>
                </tr>
                <tr>
                  <td> No. of tablets supplied </td> <td class="td-left"><?php echo number_format(sumPlain('s_alb_received', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of tablets used (includes tablets given to children and adults and tablets spoilt) </td> <td class="td-left"><?php echo number_format(sumPlain('s_alb_use', 's_bysch')); ?></td>
                </tr>          
                <tr>
                  <td> No. of tablets returned </td> <td class="td-left"><?php echo number_format(sumPlain('s_alb_returned', 's_bysch')); ?></td>
                </tr>          
                </tr>
                <tr>
                  <td> Ratio of tablets used to supplied </td> <td class="td-left"><?php echo number_format(divisionValues(sumPlain('s_alb_use', 's_bysch'), sumPlain('s_alb_received', 's_bysch')), 2, '.', '') ?></td>
                </tr>
                <tr>
                  <td> Ratio of tablets spolit to tablets supplied </td> <td class="td-left"><?php echo number_format(divisionValues(sumPlain('s_spoilt_total', 's_bysch'), sumPlain('s_alb_received', 's_bysch')), 2, '.', '') ?></td>
                </tr>
                <tr>
                  <td> Ratio of children registered to tablets supplied </td> <td class="td-left"><?php echo number_format(divisionValues(sumPriRegisteredSbysch('STH'), sumPlain('s_alb_received', 's_bysch')), 2, '.', '') ?></td>
                </tr>

                <tr class="highlighter_tr">
                  <td> SCHISTO Indicators </td> <td></td>
                </tr>
                <tr>
                  <td> No. of districts covered </td> <td class="td-left"><?php echo $row43 = number_format(numDistinctS('s_district_id', 's_bysch', 'Yes')); ?></td>
                </tr>
                <tr>
                  <td> No. of schools covered </td> <td class="td-left"><?php echo $row43 = number_format(numDistinctS('s_prog_sch_id', 's_bysch', 'Yes')); ?></td>
                </tr>
                <tr>
                  <td> No. dewormed (children + adults) </td> <td class="td-left"><?php echo number_format(sumPlain('sp_total_all', 's_bysch')); ?></td>
                </tr>          
                </tr>
                <tr>
                  <td> No. of children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('sp_total_child', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of 'Enrolled Primary + Enrolled ECD' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('sp_total_treated', 's_bysch') + sumPlain('sp_ecd_total', 's_bysch')) ?></td>
                </tr>
                <tr>
                  <td> No. of 'ECD' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('sp_ecd_total', 's_bysch')); ?></td>
                </tr>
                <tr>
                  <td> No. of 'Primary' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('sp_total_treated', 's_bysch')); ?></td>
                </tr> 
                <tr>
                  <td> No. of Primary Male children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('sp_treated_m', 's_bysch')); ?></td>
                </tr> 
                <tr>
                  <td> No. of Primary Female children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('sp_treated_f', 's_bysch')); ?></td>
                </tr> 
                <tr>
                  <td> No. of Primary children registered </td> <td class="td-left"><?php echo number_format(sumPlain('sp_total_registered', 's_bysch')); ?></td>
                </tr> 
                <tr>
                  <td> No. of 'Non Enrolled' children dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('sp_6_18_total', 's_bysch')); ?></td>
                </tr> 
                <tr>
                  <td> No. of adults dewormed </td> <td class="td-left"><?php echo number_format(sumPlain('sp_adult_total', 's_bysch')); ?></td>
                </tr> 
                <tr>
                  <td> No. of tablets spoilt </td> <td class="td-left"><?php echo number_format(sumPlain('sp_spoilt_total', 's_bysch')); ?></td> </tr>
                <tr>
                  <td> No. of tablets supplied </td> <td class="td-left"><?php echo number_format(sumPlain('sp_pzq_received', 's_bysch')); ?></td>
                </tr> 
                <tr>
                  <td> No. of tablets used (includes tablets given to children and adults and tablets spoilt) </td> <td class="td-left"><?php echo number_format(sumPlain('sp_pzq_use', 's_bysch')); ?></td>
                </tr> 

                <tr>
                  <td> No. of tablets returned </td> <td class="td-left"><?php echo number_format(sumPlain('sp_pzq_returned', 's_bysch')); ?></td>
                </tr> 

              </table>
            </div>
          </div>
        </div>
      </div> 
      <!--End container class  -->
    </div>

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
  </body>
</html>