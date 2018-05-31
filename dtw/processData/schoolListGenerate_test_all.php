<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ('../includes/form_functions.php');
require_once('assumptions.func.php');
ini_set('max_execution_time', 900000);
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
    //<b style="font-size: 20px; float: left; margin: 10px">10% </b>#
    <input id="progressValue" style="font-size: 20px; float: left; margin: 10px"/>
    //<span id="progressValue" style="font-size: 20px; float: left; margin: 10px; width: 300px">10% of <?php echo $totalRecords ?> Records</span>#
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
      echo $id = $row['id'];
      $county = $row['county'];
      $county_id = $row['county_id'];
      $district_name = $row['district_name'];
      $district_id = $row['district_id'];
      $division_name = $row['division_name'];
      $school_name = $row['school_name'];
      $school_id = $row['school_id'];
      $school_type = $row['school_type'];

   
    SELECT s.school_id, a.school_id,  
    IF(ps.s_received_form_s IS NULL, 0,1) AS returnedS, 
    IF(a.ap_attached="yes",1,0) as Bilhaz


    FROM a_bysch AS a, schools AS s , p_bysch AS ps

    WHERE s.school_id = a.school_id = ps.p_sch_id



     //Treat for Bilharzia #
     $treat_for_bilharzia = isBilharzia($school_id);
     

      // Submitted S 2013 #
       //$returnedS = returnedS($school_id);  
      
      // O// P 2013 #
       //onP = onP($school_id);  

      // E//rollment on P #
       //$pEnroll = pEnroll($school_id); 

      // #//Registered on S #
       //$registeredS = registeredS($school_id); 

      // H//ghest Enrollment Estimate #
       //$highestEnrollment = highestEnrollment($pEnroll, $registeredS); 

      // e//timate population growth #
       //number_format($estimatePopGrowth = assumptionProduct($highestEnrollment, 'aPopulationGrowthAnnual')); 

      // E//timate for non enrolled #
       //number_format($estimateNonenroll = getAssumptionVal('aNonEnrolledPerSchool')); 

      // E//timate for under 5s #
       //number_format($estimateU5 = assumptionProduct($highestEnrollment, 'aUnderFivesTreated')); 

      // t//tal children to treat #
       //number_format($total_children_treated = $totalChildrenTreated = addValues($estimatePopGrowth, $estimateNonenroll, $estimateU5));  

      // t//tal adults #
       //number_format($total_adults = assumptionDivision($totalChildrenTreated, 'aChildrenTreatedPerAdult'), 2, '.', ''); 

      // t//tal drug use #
       //number_format($total_drug_use = addValues($total_adults, $total_children_treated)); 

      // t//ns #
       //$tins = assumptionDivision($total_drug_use, 'aTinSize') 

      // r//und tins #
       //$tin_round_up = round($tins); 

      // t//bs in roundup #
       //$tabs_round_up = plainSubtract(assumptionProduct($tins, 'aTinSize'), $total_drug_use); 

      // s//oilage calc #
       //$spoilage = assumptionProduct($total_drug_use, 'pSpoilage'); 

      // s//oilage gap #
       //$spoilage_gap = plainSubtract($spoilage, $tabs_round_up); 

      // t// add for spoilage #
       //$add_for_spoilage = ifGreater($spoilage_gap, 'aAssumedSchoolSize') 

      // a//b requisition #
       //$alb_requisition = addValues(assumptionProduct($tin_round_up, 'aTinSize'), $add_for_spoilage) 

      // e//timate for shisto #
       //$estimate_shisto = isEqualTo1($treat_for_bilharzia, $estimatePopGrowth); 

      // e//timate for non enrolled shisto #
       //$estimate_non_enrolled_shisto = isEqualTo0($estimate_shisto, 'pNonEnrolledPerSchool') 

      // t//tal children to treat ....pink #
       //$total_children_treated_shisto = addValues($estimate_shisto, $estimate_non_enrolled_shisto) 

      // T//tal Tabs for children shisto #
       //$total_tabs_for_children_shisto = assumptionProduct($total_children_treated_shisto, 'pAverageChildDose') 

      // T//tal adults to treat shisto #
       //$total_adults_to_treat_shisto = assumptionDivision($total_children_treated_shisto, 'pNonEnrolledPerSchool') 

      // t//tal Tabs for adults shisto #
       //$total_tabs_for_adults_shisto = assumptionProduct($total_adults_to_treat_shisto, 'pAdultDose') 

      // t//ttal drugs to use #
       //$total_drugs_use_shisto = addValues($total_tabs_for_adults_shisto, $total_tabs_for_children_shisto); 

      // t//tal Pqo required shisto #
       //total_pzq_required_shisto = "not yet"; 

      // t//ns shistp #
       //$tins_shisto = assumptionProduct($total_drugs_use_shisto, 'pTinSize') 

      // t//n round up shisto #
       //$round_up_tins_shisto = round($tins_shisto) 

      // t//bs in tin shisto #
       //$tabs_in_tin_shisto = plainSubtract(assumptionProduct($round_up_tins_shisto, 'pTinSize'), $total_drugs_use_shisto) 

      // s//oilage calc #
       //$spoilage_calc_shisto = assumptionProduct($total_drugs_use_shisto, 'pSpoilage') 

      // s//oilage gap #
       //$spoilage_gap_shisto = plainSubtract($spoilage_calc_shisto, $tabs_in_tin_shisto) 

      // t// add for spoilage gap #
       //$to_add_spoilage_gap_shisto = ifGreater2($spoilage_gap_shisto, 'pMaxDrugShortagePermittedDrugs', 'pTinSize') 

      // p//q requsition #
       //$pzq_requsition = addValues(assumptionProduct($round_up_tins_shisto, 'pTinSize'), $to_add_spoilage_gap_shisto) 

      // e//timate populatipon growth part2 #
       //number_format($estimate_population_growth_part2 = assumptionProduct($estimatePopGrowth, 'aPopulationGrowthAnnual')) 

      // e//timate non enrolled part2 #
       //number_format($estimate_non_enroll_part2 = getAssumptionVal('aNonEnrolledPerSchool')) 

      // e//timater for under 5s part2 #
       //number_format($estimate_for_under5_part2 = assumptionProduct($estimate_population_growth_part2, 'aUnderFivesTreated'))   

      //to//al children to test part2 #
       //number_format($total_children_to_treat_part2 = addValues($estimate_population_growth_part2, $estimate_non_enroll_part2, $estimate_for_under5_part2))   

      // t//tal adults part2 #
       //number_format($total_adults_part2 = assumptionDivision($total_children_to_treat_part2, 'aChildrenTreatedPerAdult'), 2, '.', '')   

      // t//tal_drugs_to_use_part2 #
       //number_format($total_drugs_to_use_part2 = addValues($total_adults_part2, $total_children_to_treat_part2), 2, '.', '')   

      // s//oilage part2 #
       //number_format($spoilage_part2 = assumptionProduct($total_adults_part2, 'aSpoilage'), 2, '.', '')   

      // t//tal_alb_required_part2 #
       //number_format($total_alb_required_part2 = addValues($spoilage_part2, $total_drugs_to_use_part2), 2, '.', '')  

      // t//ns_part2 #
       //number_format($tins_part2 = assumptionDivision($total_alb_required_part2, 'aTinSize'), 2, '.', '')   

      // t//n_round_up #
       //number_format($tin_round_up_part2 = round($tins_part2))   
      
  
      
      echo "<br/>";
      ?>

      <script>
        // progressUpdate(<?php echo ($i / $totalRecords * 100); ?>);
      </script>

      <?php
    }

    echo "Complete";
    ?>
    //================================================#








  </body>
</html>



