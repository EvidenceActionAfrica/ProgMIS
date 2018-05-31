<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ('../includes/form_functions.php');
require_once('assumptions.func.php');
// require_once ('../includes/db_functions.php');
//$evidenceaction = new EvidenceAction();
$level = $_SESSION['level'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("../includes/meta-link-script.php");
    ?>
    <script src="../js/jquery.min.js"></script>
  </head>
  <body onload="document.getElementById('imgLoading').style.visibility = 'hidden';">
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain" style="overflow-x: hidden">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-Drugs.php");
        ?>
      </div>
      <div class="contentBody">
        <!--================================================-->
        <!--<h1 >School List</h1>-->
        <form action="#">
          <!-- <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /> -->
          <img src="../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
          <!-- <a class="btn-custom-small" href="PHPExcel/AdminData/schools.php?searchQuery=<?php echo $searchQuery; ?>">Export to Excel</a> -->
          <b style="text-align: center; margin-top: 0px; font-size: 22px; margin-left: 100px ">Drug Requisitioning School List</b>
        </form>
        <br/>
<!--        <div  >
          <table width="100%" frame="box" class="table-hover process-table">
            <thead>
              <tr>
                <th>County</th>
                <th>District Name</th>
                <th>District ID</th>
                <th>Division</th>
                <th>School Name</th>
                <th>School ID</th>
                <th>School Type</th>
                <th>Treat for Bilhazia</th>
                <th>Submitted S 2013</th>
                <th>On P 2013</th>
                <th>Enrollment on P</th>
                <th># Registered on S</th>
                <th>Highest Enrollment Estimate</th>
                <th class="green-header-background">Estimate incl. population growth</th>
                <th class="green-header-background">Estimate for non enrolled</th>
                <th class="green-header-background">Estimate for under 5s</th>
                <th class="green-header-background">Total Children to treat</th>
                <th class="green-header-background">Total adults</th>
                <th class="green-header-background">Total drugs to use</th>
                <th class="green-header-background"># tins</th>
                <th class="green-header-background">tin round up</th>
                <th class="green-header-background"># tabs in round up</th>
                <th class="green-header-background">spoilage calc</th>
                <th class="green-header-background">Spoilage gap</th>
                <th class="green-header-background">To add for spoilage</th> 

                <th class="yellow-header-background">2014 Albendazole Requisition</th>

                <th class="pink-header-background">Estimate for Schisto</th>
                <th class="pink-header-background">Estimate for Non Enrolled</th>
                <th class="pink-header-background">Total children to treat</th>
                <th class="pink-header-background">Total Tabs for children</th>
                <th class="pink-header-background">Total adults to treat</th>
                <th class="pink-header-background">Total Tabs for adults</th>
                <th class="pink-header-background">Total drugs to use</th>
                <th class="pink-header-background">Total PZQ required</th>
                <th class="pink-header-background"># Tins</th>
                <th class="pink-header-background">tin round up</th>
                <th class="pink-header-background">Tabs in tin round</th>
                <th class="pink-header-background">Spoilage calc</th>
                <th class="pink-header-background">Spoilage Gap</th>
                <th class="pink-header-background">To add for spoilage</th>
                <th class="yellow-header-background">2014 PZQ Requisition</th>
                <th class="green-header-background">Estimate incl. population growth</th>
                <th class="green-header-background">Estimate for non enrolled</th>
                <th class="green-header-background">Estimate for under 5s</th>
                <th class="green-header-background">Total Children to treat Total adults</th>
                <th class="green-header-background">Total drugs to use</th>
                <th class="green-header-background">Spoliage</th>
                <th class="green-header-background">Total Alb required</th>
                <th class="green-header-background"># tins</th>
                <th class="green-header-background">tin round up</th>
              </tr>
            </thead>
          </table>
        </div>-->
        <div style="  height:500px; overflow-y: scroll; ">
          <table width="100%" frame="box" class="table-hover process-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>County</th>
                <th>District Name</th>
                <th>District ID</th>
                <th>Division</th>
                <th>School Name</th>
                <th>School ID</th>
                <th>School Type</th>
                <th>Treat for Bilhazia</th>
                <th>Submitted S 2013</th>
                <th>On P 2013</th>
                <th>Enrollment on P</th>
                <th># Registered on S</th>
                <th>Highest Enrollment Estimate</th>
                <th class="green-header-background">Estimate incl. population growth</th>
                <th class="green-header-background">Estimate for non enrolled</th>
                <th class="green-header-background">Estimate for under 5s</th>
                <th class="green-header-background">Total Children to treat</th>
                <th class="green-header-background">Total adults</th>
                <th class="green-header-background">Total drugs to use</th>
                <th class="green-header-background"># tins</th>
                <th class="green-header-background">tin round up</th>
                <th class="green-header-background"># tabs in round up</th>
                <th class="green-header-background">spoilage calc</th>
                <th class="green-header-background">Spoilage gap</th>
                <th class="green-header-background">To add for spoilage</th> 

                <th class="yellow-header-background">2014 Albendazole Requisition</th>

                <th class="pink-header-background">Estimate for Schisto</th>
                <th class="pink-header-background">Estimate for Non Enrolled</th>
                <th class="pink-header-background">Total children to treat</th>
                <th class="pink-header-background">Total Tabs for children</th>
                <th class="pink-header-background">Total adults to treat</th>
                <th class="pink-header-background">Total Tabs for adults</th>
                <th class="pink-header-background">Total drugs to use</th>
                <th class="pink-header-background">Total PZQ required</th>
                <th class="pink-header-background"># Tins</th>
                <th class="pink-header-background">tin round up</th>
                <th class="pink-header-background">Tabs in tin round</th>
                <th class="pink-header-background">Spoilage calc</th>
                <th class="pink-header-background">Spoilage Gap</th>
                <th class="pink-header-background">To add for spoilage</th>
                <th class="yellow-header-background">2014 PZQ Requisition</th>
                <th class="green-header-background">Estimate incl. population growth</th>
                <th class="green-header-background">Estimate for non enrolled</th>
                <th class="green-header-background">Estimate for under 5s</th>
                <th class="green-header-background">Total Children to treat Total adults</th>
                <th class="green-header-background">Total drugs to use</th>
                <th class="green-header-background">Spoliage</th>
                <th class="green-header-background">Total Alb required</th>
                <th class="green-header-background"># tins</th>
                <th class="green-header-background">tin round up</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // truncate the table
              // commented out because its too long
              // truncateTable('assumptions_school_list');
              // select all from schools
              $i=0;
              $result_set = mysql_query("SELECT * FROM schools limit 0,5000");
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
                <tr>
                  <td><?php echo $i; ?></td>
                  <td> <?php echo $county; ?>  </td>
                  <td> <?php echo $district_name; ?> </td>
                  <td><?php echo $district_id ?></td>
                  <td> <?php echo $division_name; ?> </td>
                  <td> <?php echo $school_name; ?> </td>
                  <td> <?php echo $school_id; ?> </td>
                  <td> <?php echo $school_type; ?>  </td>
                  <!-- Treat for Bilharzia -->
                  <td> <?php echo $treat_for_bilharzia = isBilharzia($school_id); ?>  </td>

                  <!-- Submitted S 2013 -->
                  <td> <?php echo $returnedS = returnedS($school_id); ?>  </td>

                  <!-- On P 2013 -->
                  <td> <?php echo $onP = onP($school_id); ?>  </td>

                  <!-- Enrollment on P -->
                  <td> <?php echo $pEnroll = pEnroll($school_id); ?>  </td>

                  <!-- # Registered on S -->
                  <td> <?php echo $registeredS = registeredS($school_id); ?>  </td>

                  <!-- Highest Enrollment Estimate -->
                  <td> <?php echo $highestEnrollment = highestEnrollment($pEnroll, $registeredS); ?>  </td>

                  <!-- estimate population growth -->
                  <td> <?php echo number_format($estimatePopGrowth = assumptionProduct($highestEnrollment, 'aPopulationGrowthAnnual')); ?>  </td>

                  <!-- Estimate for non enrolled -->
                  <td class="kpidone"> <?php echo number_format($estimateNonenroll = getAssumptionVal('aNonEnrolledPerSchool')); ?>  </td>

                  <!-- Estimate for under 5s -->
                  <td class="kpidone"> <?php echo number_format($estimateU5 = assumptionProduct($highestEnrollment, 'aUnderFivesTreated')); ?>  </td>

                  <!-- total children to treat -->
                  <td class="kpidone"> <?php echo number_format($total_children_treated = $totalChildrenTreated = addValues($estimatePopGrowth, $estimateNonenroll, $estimateU5)); ?>  </td>

                  <!-- total adults -->
                  <td class="kpidone"> <?php echo number_format($total_adults = assumptionDivision($totalChildrenTreated, 'aChildrenTreatedPerAdult'), 2, '.', ''); ?>  </td>

                  <!-- total drug use -->
                  <td class="kpidone"> <?php echo number_format($total_drug_use = addValues($total_adults, $total_children_treated)); ?>  </td>

                  <!-- tins -->
                  <td class="kpidone"> <?php echo $tins = assumptionDivision($total_drug_use, 'aTinSize') ?>  </td>

                  <!-- round tins -->
                  <td class="kpidone"> <?php echo $tin_round_up = round($tins); ?>  </td>

                  <!-- tabs in roundup -->
                  <td class="kpidone"> <?php echo $tabs_round_up = plainSubtract(assumptionProduct($tins, 'aTinSize'), $total_drug_use); ?>  </td>

                  <!-- spoilage calc -->
                  <td class="kpidone"> <?php echo $spoilage = assumptionProduct($total_drug_use, 'pSpoilage'); ?>  </td>

                  <!-- spoilage gap -->
                  <td class="kpidone"> <?php echo $spoilage_gap = plainSubtract($spoilage, $tabs_round_up); ?>  </td>

                  <!-- to add for spoilage -->
                  <td class="kpidone"> <?php echo $add_for_spoilage = ifGreater($spoilage_gap, 'aAssumedSchoolSize') ?>  </td>

                  <!-- alb requisition -->
                  <td class="kpidone"> <?php echo $alb_requisition = addValues(assumptionProduct($tin_round_up, 'aTinSize'), $add_for_spoilage) ?>  </td>

                  <!-- estimate for shisto -->
                  <td class="kpidone"> <?php echo $estimate_shisto = isEqualTo1($treat_for_bilharzia, $estimatePopGrowth); ?>  </td>

                  <!-- estimate for non enrolled shisto -->
                  <td class="kpidone"> <?php echo $estimate_non_enrolled_shisto = isEqualTo0($estimate_shisto, 'pNonEnrolledPerSchool') ?>  </td>

                  <!-- total children to treat ....pink -->
                  <td class="kpidone"> <?php echo $total_children_treated_shisto = addValues($estimate_shisto, $estimate_non_enrolled_shisto) ?>  </td>

                  <!-- Total Tabs for children shisto -->
                  <td class="kpidone"> <?php echo $total_tabs_for_children_shisto = assumptionProduct($total_children_treated_shisto, 'pAverageChildDose') ?>  </td>

                  <!-- Total adults to treat shisto -->
                  <td class="kpidone"> <?php echo $total_adults_to_treat_shisto = assumptionDivision($total_children_treated_shisto, 'pNonEnrolledPerSchool') ?>  </td>

                  <!-- total Tabs for adults shisto -->
                  <td class="kpidone"> <?php echo $total_tabs_for_adults_shisto = assumptionProduct($total_adults_to_treat_shisto, 'pAdultDose') ?>  </td>

                  <!-- tottal drugs to use -->
                  <td> <?php echo $total_drugs_use_shisto = addValues($total_tabs_for_adults_shisto, $total_tabs_for_children_shisto); ?>  </td>

                  <!-- total Pqo required shisto -->
                  <td> <?php $total_pzq_required_shisto = "not yet"; ?>  </td>

                  <!-- tins shistp -->
                  <td> <?php echo $tins_shisto = assumptionProduct($total_drugs_use_shisto, 'pTinSize') ?>  </td>

                  <!-- tin round up shisto -->
                  <td> <?php echo $round_up_tins_shisto = round($tins_shisto) ?>  </td>

                  <!-- tabs in tin shisto -->
                  <td> <?php echo $tabs_in_tin_shisto = plainSubtract(assumptionProduct($round_up_tins_shisto, 'pTinSize'), $total_drugs_use_shisto) ?>  </td>

                  <!-- spoilage calc -->
                  <td> <?php echo $spoilage_calc_shisto = assumptionProduct($total_drugs_use_shisto, 'pSpoilage') ?>  </td>

                  <!-- spoilage gap -->
                  <td> <?php echo $spoilage_gap_shisto = plainSubtract($spoilage_calc_shisto, $tabs_in_tin_shisto) ?>  </td>

                  <!-- to add for spoilage gap -->
                  <td> <?php echo $to_add_spoilage_gap_shisto = ifGreater2($spoilage_gap_shisto, 'pMaxDrugShortagePermittedDrugs', 'pTinSize') ?>  </td>

                  <!-- pzq requsition -->
                  <td> <?php echo $pzq_requsition = addValues(assumptionProduct($round_up_tins_shisto, 'pTinSize'), $to_add_spoilage_gap_shisto) ?>  </td>

                  <!-- estimate populatipon growth part2 -->
                  <td> <?php echo number_format($estimate_population_growth_part2 = assumptionProduct($estimatePopGrowth, 'aPopulationGrowthAnnual')) ?>  </td>

                  <!-- estimate non enrolled part2 -->
                  <td> <?php echo number_format($estimate_non_enroll_part2 = getAssumptionVal('aNonEnrolledPerSchool')) ?>  </td>

                  <!-- estimater for under 5s part2 -->
                  <td> <?php echo number_format($estimate_for_under5_part2 = assumptionProduct($estimate_population_growth_part2, 'aUnderFivesTreated')) ?>  </td>

                  <!--total children to test part2 -->
                  <td> <?php echo number_format($total_children_to_treat_part2 = addValues($estimate_population_growth_part2, $estimate_non_enroll_part2, $estimate_for_under5_part2)) ?>  </td>

                  <!-- total adults part2 -->
                  <td> <?php echo number_format($total_adults_part2 = assumptionDivision($total_children_to_treat_part2, 'aChildrenTreatedPerAdult'), 2, '.', '') ?>  </td>

                  <!-- total_drugs_to_use_part2 -->
                  <td> <?php echo number_format($total_drugs_to_use_part2 = addValues($total_adults_part2, $total_children_to_treat_part2), 2, '.', '') ?>  </td>

                  <!-- spoilage part2 -->
                  <td> <?php echo number_format($spoilage_part2 = assumptionProduct($total_adults_part2, 'aSpoilage'), 2, '.', '') ?>  </td>

                  <!-- total_alb_required_part2 -->
                  <td> <?php echo number_format($total_alb_required_part2 = addValues($spoilage_part2, $total_drugs_to_use_part2), 2, '.', '') ?>  </td>

                  <!-- tins_part2 -->
                  <td> <?php echo number_format($tins_part2 = assumptionDivision($total_alb_required_part2, 'aTinSize'), 2, '.', '') ?>  </td>

                  <!-- tin_round_up -->
                  <td> <?php echo number_format($tin_round_up_part2 = round($tins_part2)) ?>  </td>

                </tr>
              </tbody>

              <?php 
                //create array and add data
               
                
                // for ($i=0; $i < 2; $i++) { 
                   // $mass[] = array(
                   //              $county_id ,
                   //              $district_id ,
                   //              $county,
                   //              $district_name,
                   //              $division_name,
                   //              $school_name,
                   //              $school_id,
                   //              $school_type,
                   //              $treat_for_bilharzia,
                   //              $returnedS,
                   //              $onP,
                   //              $pEnroll,
                   //              $registeredS,
                   //              $highestEnrollment,
                   //              $estimatePopGrowth,
                   //              $estimateNonenroll,
                   //              $estimateU5,
                   //              $total_children_treated,
                   //              $total_adults,
                   //              $total_drug_use,
                   //              $tins,
                   //              $tin_round_up,
                   //              $tabs_round_up,
                   //              $spoilage,
                   //              $spoilage_gap,
                   //              $add_for_spoilage,
                   //              $alb_requisition,
                   //              $estimate_shisto,
                   //              $estimate_non_enrolled_shisto,
                   //              $total_children_treated_shisto,
                   //              $total_tabs_for_children_shisto,
                   //              $total_adults_to_treat_shisto,
                   //              $total_tabs_for_adults_shisto,
                   //              $total_drugs_use_shisto,
                   //              $total_pzq_required_shisto,
                   //              $tins_shisto,
                   //              $round_up_tins_shisto,
                   //              $tabs_in_tin_shisto,
                   //              $spoilage_calc_shisto,
                   //              $spoilage_gap_shisto,
                   //              $to_add_spoilage_gap_shisto,
                   //              $pzq_requsition,
                   //              $estimate_population_growth_part2,
                   //              $estimate_non_enroll_part2,
                   //              $estimate_for_under5_part2,
                   //              $total_children_to_treat_part2,
                   //              $total_adults_part2,
                   //              $total_drugs_to_use_part2,
                   //              $spoilage_part2,
                   //              $total_alb_required_part2,
                   //              $tins_part2,
                   //              $tin_round_up_part
                   //          );

                            $mass[] = array(
                                'county_id '=>$county_id ,
                                'district_id '=>$district_id ,
                                'county'=>$county,
                                'district_name'=>$district_name,
                                'division_name'=>$division_name,
                                'school_name'=>$school_name,
                                'school_id'=>$school_id,
                                'school_type'=>$school_type,
                                'treat_for_bilharzia'=>$treat_for_bilharzia,
                                'returnedS'=>$returnedS,
                                'onP'=>$onP,
                                'pEnroll'=>$pEnroll,
                                'registeredS'=>$registeredS,
                                'highestEnrollment'=>$highestEnrollment,
                                'estimatePopGrowth'=>$estimatePopGrowth,
                                'estimateNonenroll'=>$estimateNonenroll,
                                'estimateU5'=>$estimateU5,
                                'total_children_treated'=>$total_children_treated,
                                'total_adults'=>$total_adults,
                                'total_drug_use'=>$total_drug_use,
                                'tins'=>$tins,
                                'tin_round_up'=>$tin_round_up,
                                'tabs_round_up'=>$tabs_round_up,
                                'spoilage'=>$spoilage,
                                'spoilage_gap'=>$spoilage_gap,
                                'add_for_spoilage'=>$add_for_spoilage,
                                'alb_requisition'=>$alb_requisition,
                                'estimate_shisto'=>$estimate_shisto,
                                'estimate_non_enrolled_shisto'=>$estimate_non_enrolled_shisto,
                                'total_children_treated_shisto'=>$total_children_treated_shisto,
                                'total_tabs_for_children_shisto'=>$total_tabs_for_children_shisto,
                                'total_adults_to_treat_shisto'=>$total_adults_to_treat_shisto,
                                'total_tabs_for_adults_shisto'=>$total_tabs_for_adults_shisto,
                                'total_drugs_use_shisto'=>$total_drugs_use_shisto,
                                'total_pzq_required_shisto'=>$total_pzq_required_shisto,
                                'tins_shisto'=>$tins_shisto,
                                'round_up_tins_shisto'=>$round_up_tins_shisto,
                                'tabs_in_tin_shisto'=>$tabs_in_tin_shisto,
                                'spoilage_calc_shisto'=>$spoilage_calc_shisto,
                                'spoilage_gap_shisto'=>$spoilage_gap_shisto,
                                'to_add_spoilage_gap_shisto'=>$to_add_spoilage_gap_shisto,
                                'pzq_requsition'=>$pzq_requsition,
                                'estimate_population_growth_part2'=>$estimate_population_growth_part2,
                                'estimate_non_enroll_part2'=>$estimate_non_enroll_part2,
                                'estimate_for_under5_part2'=>$estimate_for_under5_part2,
                                'total_children_to_treat_part2'=>$total_children_to_treat_part2,
                                'total_adults_part2'=>$total_adults_part2,
                                'total_drugs_to_use_part2'=>$total_drugs_to_use_part2,
                                'spoilage_part2'=>$spoilage_part2,
                                'total_alb_required_part2'=>$total_alb_required_part2,
                                'tins_part2'=>$tins_part2,
                                'tin_round_up_part'=>$tin_round_up_part
                            );
                // }

                if ($i==100) {
                  // echo "<pre>";var_dump($mass);echo "</pre>";
                  // echo $i;
                  // exit();

                  foreach ($mass as $key => $value) {
                    # code...
                    create_school_list(
                        $value['county_id '],
                        $value['district_id '],
                        $value['county'],
                        $value['district_name'],
                        $value['division_name'],
                        $value['school_name'],
                        $value['school_id'],
                        $value['school_type'],
                        $value['treat_for_bilharzia'],
                        $value['returnedS'],
                        $value['onP'],
                        $value['pEnroll'],
                        $value['registeredS'],
                        $value['highestEnrollment'],
                        $value['estimatePopGrowth'],
                        $value['estimateNonenroll'],
                        $value['estimateU5'],
                        $value['total_children_treated'],
                        $value['total_adults'],
                        $value['total_drug_use'],
                        $value['tins'],
                        $value['tin_round_up'],
                        $value['tabs_round_up'],
                        $value['spoilage'],
                        $value['spoilage_gap'],
                        $value['add_for_spoilage'],
                        $value['alb_requisition'],
                        $value['estimate_shisto'],
                        $value['estimate_non_enrolled_shisto'],
                        $value['total_children_treated_shisto'],
                        $value['total_tabs_for_children_shisto'],
                        $value['total_adults_to_treat_shisto'],
                        $value['total_tabs_for_adults_shisto'],
                        $value['total_drugs_use_shisto'],
                        $value['total_pzq_required_shisto'],
                        $value['tins_shisto'],
                        $value['round_up_tins_shisto'],
                        $value['tabs_in_tin_shisto'],
                        $value['spoilage_calc_shisto'],
                        $value['spoilage_gap_shisto'],
                        $value['to_add_spoilage_gap_shisto'],
                        $value['pzq_requsition'],
                        $value['estimate_population_growth_part2'],
                        $value['estimate_non_enroll_part2'],
                        $value['estimate_for_under5_part2'],
                        $value['total_children_to_treat_part2'],
                        $value['total_adults_part2'],
                        $value['total_drugs_to_use_part2'],
                        $value['spoilage_part2'],
                        $value['total_alb_required_part2'],
                        $value['tins_part2'],
                        $value['tin_round_up_part2']
                );
                  } // end forech

                  //clear array
                  unset($mass);

                  echo $i;
                  echo "<br/>";
                }
                $i++;

                //loop to insert



               ?>
              <!-- insert into table  -->

              <?php
              // commented out cuz i dont want to take too long

              // create_school_list(
              //           $county_id ,
              //           $district_id ,
              //           $county,
              //           $district_name,
              //           $division_name,
              //           $school_name,
              //           $school_id,
              //           $school_type,
              //           $treat_for_bilharzia,
              //           $returnedS,
              //           $onP,
              //           $pEnroll,
              //           $registeredS,
              //           $highestEnrollment,
              //           $estimatePopGrowth,
              //           $estimateNonenroll,
              //           $estimateU5,
              //           $total_children_treated,
              //           $total_adults,
              //           $total_drug_use,
              //           $tins,
              //           $tin_round_up,
              //           $tabs_round_up,
              //           $spoilage,
              //           $spoilage_gap,
              //           $add_for_spoilage,
              //           $alb_requisition,
              //           $estimate_shisto,
              //           $estimate_non_enrolled_shisto,
              //           $total_children_treated_shisto,
              //           $total_tabs_for_children_shisto,
              //           $total_adults_to_treat_shisto,
              //           $total_tabs_for_adults_shisto,
              //           $total_drugs_use_shisto,
              //           $total_pzq_required_shisto,
              //           $tins_shisto,
              //           $round_up_tins_shisto,
              //           $tabs_in_tin_shisto,
              //           $spoilage_calc_shisto,
              //           $spoilage_gap_shisto,
              //           $to_add_spoilage_gap_shisto,
              //           $pzq_requsition,
              //           $estimate_population_growth_part2,
              //           $estimate_non_enroll_part2,
              //           $estimate_for_under5_part2,
              //           $total_children_to_treat_part2,
              //           $total_adults_part2,
              //           $total_drugs_to_use_part2,
              //           $spoilage_part2,
              //           $total_alb_required_part2,
              //           $tins_part2,
              //           $tin_round_up_part2
              //   );

              ?>
            <?php } ?>
          </table>
        </div>
        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->


    <!--filter includes-->
    <script type="text/javascript" src="css/filter-as-you-type/jquery.min.js"></script>
    <script type="text/javascript" src="css/filter-as-you-type/jquery.quicksearch.js"></script>
    <script type="text/javascript">
    $(function() {
      $('input#id_search').quicksearch('table tbody tr');
    });

    function submitForm() {
      document.getElementById('imgLoading').style.visibility = "visible";
      var selectButton = document.getElementById('btnSearchSubmit');
      selectButton.click();
    }
    </script>
    <!--Delete dialog-->
    <script>
      function show_confirm(deleteid) {
        if (confirm("Are You Sure you want to delete?")) {
          location.replace('?deleteid=' + deleteid);
        } else {
          return false;
        }
      }
    </script>
  </body>
</html>


<script>
  //GET district
  function get_district(txt) {
    $.post('../ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
      $('#selectdistrict').html(data);//alert(data);
    });
  }
  //GET divisions
  function get_division(txt) {
    $.post('../ajax_dropdown.php', {checkval: 'division', district: txt}).done(function(data) {
      $('#selectdivision').html(data);//alert(data);
    });
  }
  //GET Schools
  function get_school(txt) {
    $.post('../ajax_dropdown.php', {checkval: 'school', division: txt}).done(function(data) {
      $('#selectschool').html(data);//alert(data);
    });
  }

</script>

