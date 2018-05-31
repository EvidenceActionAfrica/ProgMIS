<?php

require_once('../../includes/config.php');

$req = $_GET['req'];
$val = $_GET['val'];

if ($req == 'load') {
//  echo "<table border='1'>
//          <tr>
//          <th>Firstname</th>
//          <th>Lastname</th>
//          <th>Age</th>
//          <th>Hometown</th>
//          <th>Job</th>
//        </tr>";
//
//  $result_set = mysql_query("SELECT * FROM staff WHERE staffid = '" . $val . "' ");
//  while ($row = mysql_fetch_array($result_set)) {
//    echo "<tr>";
//    echo "<td>" . $row['name'] . "</td>";
//    echo "<td>" . $row['role'] . "</td>";
//    echo "<td>" . $row['gender'] . "</td>";
//    echo "<td>" . $row['town'] . "</td>";
//    echo "<td>" . $row['team'] . "</td>";
//    echo "</tr>";
//  }
//  echo "</table>";

  // load requested record
  $result_display = mysql_query("SELECT * FROM assumptions WHERE id = '" . $val . "' LIMIT 1"); 
  while ($row = mysql_fetch_array($result_display)) {
    $id = $row['id'];
    $dateSaved = $row['dateSaved'];
    $aChildrenTreatedPerAdult = $row['aChildrenTreatedPerAdult'];
    $pChildrenTreatedPerAdult = $row['pChildrenTreatedPerAdult'];
    $aNonEnrolledPerSchool = $row['aNonEnrolledPerSchool'];
    $pNonEnrolledPerSchool = $row['pNonEnrolledPerSchool'];
    $aUnderFivesTreated = $row['aUnderFivesTreated'];
    $pUnderFivesTreated = $row['pUnderFivesTreated'];
    $aPopulationGrowthAnnual = $row['aPopulationGrowthAnnual'];
    $pPopulationGrowthAnnual = $row['pPopulationGrowthAnnual'];
    $aSpoilage = $row['aSpoilage'];
    $pSpoilage = $row['pSpoilage'];
    $aTinSize = $row['aTinSize'];
    $pTinSize = $row['pTinSize'];
    $aAverageChildDose = $row['aAverageChildDose'];
    $pAverageChildDose = $row['pAverageChildDose'];
    $aAdultDose = $row['aAdultDose'];
    $pAdultDose = $row['pAdultDose'];
    $aMaxDrugShortagePermittedKids = $row['aMaxDrugShortagePermittedKids'];
    $pMaxDrugShortagePermittedKids = $row['pMaxDrugShortagePermittedKids'];
    $aExtraSchoolsPerDistrict = $row['aExtraSchoolsPerDistrict'];
    $pExtraSchoolsPerDistrict = $row['pExtraSchoolsPerDistrict'];
    $aAssumedSchoolSize = $row['aAssumedSchoolSize'];
    $pAssumedSchoolSize = $row['pAssumedSchoolSize'];
    $aMaxDrugShortagePermittedDrugs = $row['aMaxDrugShortagePermittedDrugs'];
    $pMaxDrugShortagePermittedDrugs = $row['pMaxDrugShortagePermittedDrugs'];
    $aAverageDrugNeed = $row['aAverageDrugNeed'];
    $pAverageDrugNeed = $row['pAverageDrugNeed'];
    $aAverageTinsNeededPerSchools = $row['aAverageTinsNeededPerSchools'];
    $pAverageTinsNeededPerSchools = $row['pAverageTinsNeededPerSchools'];
    $aCalcDrugsPerSchool = $row['aCalcDrugsPerSchool'];
    $pCalcDrugsPerSchool = $row['pCalcDrugsPerSchool'];
    $aTreatYear = $row['aTreatYear'];
    $pTreatYear = $row['pTreatYear'];
    $areaAssumptions = $row['areaAssumptions'];
  }


  echo '<table border="2" align="center" cellpadding="0" style="width: 540px; float:left">
          <tr style="background-color: silver;">
            <td colspan="6" style="padding: 5px;">
              <b>ID('.$id.')  Drug Planning Previous Assumptions</b> 
              <b style="width: 100px; float: right; background: #F2F2F2">&nbsp;'. $dateSaved .'</b>
              <b style="float: right">Date Saved &nbsp; </b>
            </td>
          </tr>
          <tr>
            <td> <b> </b> </td>
            <td> <b>Albendazole </b> </td>
            <td> <b>Praziquantel</b> </td>
          </tr>
          <tr>
            <td>Children treated per adult</td>
            <td align="center" width="100px"> '.$aChildrenTreatedPerAdult .'</td>
            <td align="center" width="100px"> '.$pChildrenTreatedPerAdult .'</td>
          </tr>
          <tr>
            <td>Number of Non Enrolled Per School</td>
             <td align="center"> '.$aNonEnrolledPerSchool .'</td>
             <td align="center"> '.$pNonEnrolledPerSchool .'</td>
          </tr>
          <tr>
            <td>% Under Fives Treated (cf enrolled SAC)</td>
             <td align="center">  '.$aUnderFivesTreated .'</td>
             <td align="center">  '.$pUnderFivesTreated .'</td>
          </tr>
          <tr>
            <td>Population Growth Annual</td>
             <td align="center">  '.$aPopulationGrowthAnnual .'</td>
             <td align="center">  '.$pPopulationGrowthAnnual .'</td>
          </tr>
          <tr>
            <td>Spoilage</td>
             <td align="center">  '.$aSpoilage .'</td>
             <td align="center">  '.$pSpoilage .'</td>
          </tr>
          <tr>
            <td>Tin size</td>
             <td align="center">  '.$aTinSize .'</td>
             <td align="center">  '.$pTinSize .'</td>
          </tr>
          <tr>
            <td>Average Child dose</td>
             <td align="center">  '.$aAverageChildDose .'</td>
             <td align="center">  '.$pAverageChildDose .'</td>
          </tr>
          <tr>
            <td>Adult dose</td>
             <td align="center">  '.$aAdultDose .'</td>
             <td align="center">  '.$pAdultDose .'</td>
          </tr>
          <tr>
            <td>Maximum drug shortage permitted (kids)</td>
             <td align="center">  '.$aMaxDrugShortagePermittedKids .'</td>
             <td align="center">  '.$pMaxDrugShortagePermittedKids .'</td>
          </tr>
          <tr>
            <td>Extra Schools Per District</td>
             <td align="center">  '.$aExtraSchoolsPerDistrict .'</td>
             <td align="center">  '.$pExtraSchoolsPerDistrict .'</td>
          </tr>
          <tr>
            <td>Assumed School size (for extra schools)</td>
             <td align="center">  '.$aAssumedSchoolSize .'</td>
             <td align="center">  '.$pAssumedSchoolSize .'</td>
          </tr>
          <tr>
            <td><b>Maximum drug shortage permitted (drugs)<b/></td>
             <td align="center">  '.$aMaxDrugShortagePermittedDrugs .'</td>
             <td align="center">  '.$pMaxDrugShortagePermittedDrugs .'</td>
          </tr>
          <tr>
            <td><b>Average drug need<b/></td>
             <td align="center">  '.$aAverageDrugNeed .'</td>
             <td align="center">  '.$pAverageDrugNeed .'</td>
          </tr>
          <tr>
            <td><b>Average Tins Needed Per Schools<b/></td>
             <td align="center">  '.$aAverageTinsNeededPerSchools .'</td>
             <td align="center">  '.$pAverageTinsNeededPerSchools .'</td>
          </tr>
          <tr>
            <td><b>Calc for drugs per school<b/></td>
             <td align="center">  '.$aCalcDrugsPerSchool .'</td>
             <td align="center">  '.$pCalcDrugsPerSchool .'</td>
          </tr>
          <tr>
            <td><b>Treat year<b/></td>
            <td align="center">  '.$aTreatYear .'</td>
            <td align="center">  '.$pTreatYear .'</td>
          </tr>
        </table>
        <div style="float: left; padding-left: 20px">
          <b>Area assumptions /<br/> Important Notes </b><br/>
          <textarea cols="25" rows="16" id="notes" name="areaAssumptions" readonly>'. $areaAssumptions .'</textarea>
          <br/> <br/>
        </div>';
}
?> 