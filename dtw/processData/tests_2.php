<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ('../includes/form_functions.php');
require_once('assumptions.func.php');
ini_set('max_execution_time', 300);
// require_once ('../includes/db_functions.php');
//$evidenceaction = new EvidenceAction();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <?php require_once ("../includes/meta-link-script.php"); ?>
    <script src="../js/jquery.min.js"></script>
    <script type="text/javascript">
      function progressUpdate(n) {
        document.getElementById('progressBar').style.width = n + '%';
        var percRound = parseFloat(n).toFixed(2);
        document.getElementById('progressValue').value = percRound + '%';
      }
    </script>
  </head>
  <body onload="document.getElementById('imgLoading').style.visibility = 'hidden';">

    <?php
    $resTotal = mysql_query("SELECT * FROM schools");
    $totalRecords = mysql_num_rows($resTotal);
    ?>


    <img src="../images/loading.gif" id="imgLoading" height="30px" style="float: left; margin: 10px; visibility: visible"/>
    <b style="font-size: 20px; float: left; margin: 10px">Performing queries...</b>
    <!--<b style="font-size: 20px; float: left; margin: 10px">10% </b>-->
    <input id="progressValue" style="font-size: 20px; float: left; margin: 10px"/>
    <!--<span id="progressValue" style="font-size: 20px; float: left; margin: 10px; width: 300px">10% of <?php echo $totalRecords ?> Records</span>-->
    <div style="clear: both"></div>

    <div class="progress progress-striped active"  style="margin: 10px">
      <div class="bar" id="progressBar" style="width: 0%;"></div>
    </div>


    <?php
    // truncate the table
    // commented out because its too long
    truncateTable('assumptions_school_list');
    // select all from schools

    $i = 0;
    $result_set = mysql_query("SELECT * FROM schools");
    while ($row = mysql_fetch_array($result_set)) {
      $id = $row['id'];
      $county = $row['county'];
      $county_id = $row['county_id'];
      $district_name = $row['district_name'];
      $district_id = $row['district_id'];
      $division_name = $row['division_name'];
      $school_name = $row['school_name'];
      $school_id = $row['school_id'];
      $school_type = $row['school_type'];

    ?>

      <!-- //Treat for Bilharzia -->
      <?php $treat_for_bilharzia = isBilharzia($school_id); ?>
     

      <!-- Submitted S 2013 -->
       <?php $returnedS = returnedS($school_id);  ?>
      
      <!-- On P 2013 -->
      <?php $onP = onP($school_id);  ?>

      <!-- Enrollment on P -->
      <?php  $pEnroll = pEnroll($school_id); ?>

      <!-- # Registered on S -->
      <?php  $registeredS = registeredS($school_id); ?>

      <!-- Highest Enrollment Estimate -->
      <?php  $highestEnrollment = highestEnrollment($pEnroll, $registeredS); ?>

      <!-- estimate population growth -->
      <?php  number_format($estimatePopGrowth = assumptionProduct($highestEnrollment, 'aPopulationGrowthAnnual')); ?>

      <!-- Estimate for non enrolled -->
      <?php  number_format($estimateNonenroll = getAssumptionVal('aNonEnrolledPerSchool')); ?>

      <!-- Estimate for under 5s -->
      <?php  number_format($estimateU5 = assumptionProduct($highestEnrollment, 'aUnderFivesTreated')); ?>

      <!-- total children to treat -->
      <?php  number_format($total_children_treated = $totalChildrenTreated = addValues($estimatePopGrowth, $estimateNonenroll, $estimateU5)); ?> 

      <!-- total adults -->
      <?php  number_format($total_adults = assumptionDivision($totalChildrenTreated, 'aChildrenTreatedPerAdult'), 2, '.', ''); ?>

      <!-- total drug use -->
      <?php  number_format($total_drug_use = addValues($total_adults, $total_children_treated)); ?>

      <!-- tins -->
      <?php  $tins = assumptionDivision($total_drug_use, 'aTinSize') ?>

      <!-- round tins -->
      <?php  $tin_round_up = round($tins); ?>

      <!-- tabs in roundup -->
      <?php  $tabs_round_up = plainSubtract(assumptionProduct($tins, 'aTinSize'), $total_drug_use); ?>

      <!-- spoilage calc -->
      <?php  $spoilage = assumptionProduct($total_drug_use, 'pSpoilage'); ?>

      <!-- spoilage gap -->
      <?php  $spoilage_gap = plainSubtract($spoilage, $tabs_round_up); ?>

      <!-- to add for spoilage -->
      <?php  $add_for_spoilage = ifGreater($spoilage_gap, 'aAssumedSchoolSize') ?>

      <!-- alb requisition -->
      <?php  $alb_requisition = addValues(assumptionProduct($tin_round_up, 'aTinSize'), $add_for_spoilage) ?>

      <!-- estimate for shisto -->
      <?php  $estimate_shisto = isEqualTo1($treat_for_bilharzia, $estimatePopGrowth); ?>

      <!-- estimate for non enrolled shisto -->
      <?php  $estimate_non_enrolled_shisto = isEqualTo0($estimate_shisto, 'pNonEnrolledPerSchool') ?>

      <!-- total children to treat ....pink -->
      <?php  $total_children_treated_shisto = addValues($estimate_shisto, $estimate_non_enrolled_shisto) ?>

      <!-- Total Tabs for children shisto -->
      <?php  $total_tabs_for_children_shisto = assumptionProduct($total_children_treated_shisto, 'pAverageChildDose') ?>

      <!-- Total adults to treat shisto -->
      <?php  $total_adults_to_treat_shisto = assumptionDivision($total_children_treated_shisto, 'pNonEnrolledPerSchool') ?>

      <!-- total Tabs for adults shisto -->
      <?php  $total_tabs_for_adults_shisto = assumptionProduct($total_adults_to_treat_shisto, 'pAdultDose') ?>

      <!-- tottal drugs to use -->
      <?php  $total_drugs_use_shisto = addValues($total_tabs_for_adults_shisto, $total_tabs_for_children_shisto); ?>

      <!-- total Pqo required shisto -->
      <?php $total_pzq_required_shisto = "not yet"; ?>

      <!-- tins shistp -->
      <?php  $tins_shisto = assumptionProduct($total_drugs_use_shisto, 'pTinSize') ?>

      <!-- tin round up shisto -->
      <?php  $round_up_tins_shisto = round($tins_shisto) ?>

      <!-- tabs in tin shisto -->
      <?php  $tabs_in_tin_shisto = plainSubtract(assumptionProduct($round_up_tins_shisto, 'pTinSize'), $total_drugs_use_shisto) ?>

      <!-- spoilage calc -->
      <?php  $spoilage_calc_shisto = assumptionProduct($total_drugs_use_shisto, 'pSpoilage') ?>

      <!-- spoilage gap -->
      <?php  $spoilage_gap_shisto = plainSubtract($spoilage_calc_shisto, $tabs_in_tin_shisto) ?>

      <!-- to add for spoilage gap -->
      <?php  $to_add_spoilage_gap_shisto = ifGreater2($spoilage_gap_shisto, 'pMaxDrugShortagePermittedDrugs', 'pTinSize') ?>

      <!-- pzq requsition -->
      <?php  $pzq_requsition = addValues(assumptionProduct($round_up_tins_shisto, 'pTinSize'), $to_add_spoilage_gap_shisto) ?>

      <!-- estimate populatipon growth part2 -->
      <?php  number_format($estimate_population_growth_part2 = assumptionProduct($estimatePopGrowth, 'aPopulationGrowthAnnual')) ?>

      <!-- estimate non enrolled part2 -->
      <?php  number_format($estimate_non_enroll_part2 = getAssumptionVal('aNonEnrolledPerSchool')) ?>

      <!-- estimater for under 5s part2 -->
      <?php  number_format($estimate_for_under5_part2 = assumptionProduct($estimate_population_growth_part2, 'aUnderFivesTreated')) ?>  

      <!--total children to test part2 -->
      <?php  number_format($total_children_to_treat_part2 = addValues($estimate_population_growth_part2, $estimate_non_enroll_part2, $estimate_for_under5_part2)) ?>  

      <!-- total adults part2 -->
      <?php  number_format($total_adults_part2 = assumptionDivision($total_children_to_treat_part2, 'aChildrenTreatedPerAdult'), 2, '.', '') ?>  

      <!-- total_drugs_to_use_part2 -->
      <?php  number_format($total_drugs_to_use_part2 = addValues($total_adults_part2, $total_children_to_treat_part2), 2, '.', '') ?>  

      <!-- spoilage part2 -->
      <?php  number_format($spoilage_part2 = assumptionProduct($total_adults_part2, 'aSpoilage'), 2, '.', '') ?>  

      <!-- total_alb_required_part2 -->
      <?php  number_format($total_alb_required_part2 = addValues($spoilage_part2, $total_drugs_to_use_part2), 2, '.', '') ?>  </td>

      <!-- tins_part2 -->
      <?php  number_format($tins_part2 = assumptionDivision($total_alb_required_part2, 'aTinSize'), 2, '.', '') ?>  

      <!-- tin_round_up -->
      <?php  number_format($tin_round_up_part2 = round($tins_part2)) ?>  
      </tbody>

      <?php
      $i;
      // echo "<br>";
      $i++;
      ?>

      <script>
        progressUpdate(<?php echo ($i / $totalRecords * 100); ?>);
      </script>

      <?php
    }

    echo "Complete";
    ?>
    <!--================================================-->








  </body>
</html>



