<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];


// LOAD PREVIOUS RECORD
$result_display = mysql_query("SELECT * FROM assumptions  ORDER BY id DESC LIMIT 1");
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("../includes/meta-link-script.php");
    ?>
    <script type="text/javascript" src="../js/validation.js"></script>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
       <?php   require_once ("includes/menuNav.php");  ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-Drugs.php");
        ?>
      </div>
      <div class="contentBody">
        <?php
        if (isset($_POST['submitSaveNew'])) {
          $id = $_POST['id'];
          $dateSaved = date('Y-m-d');
          $aChildrenTreatedPerAdult = $_POST['aChildrenTreatedPerAdult'];
          $pChildrenTreatedPerAdult = $_POST['pChildrenTreatedPerAdult'];
          $aNonEnrolledPerSchool = $_POST['aNonEnrolledPerSchool'];
          $pNonEnrolledPerSchool = $_POST['pNonEnrolledPerSchool'];
          $aUnderFivesTreated = $_POST['aUnderFivesTreated'];
          $pUnderFivesTreated = $_POST['pUnderFivesTreated'];
          $aPopulationGrowthAnnual = $_POST['aPopulationGrowthAnnual'];
          $pPopulationGrowthAnnual = $_POST['pPopulationGrowthAnnual'];
          $aSpoilage = $_POST['aSpoilage'];
          $pSpoilage = $_POST['pSpoilage'];
          $aTinSize = $_POST['aTinSize'];
          $pTinSize = $_POST['pTinSize'];
          $aAverageChildDose = $_POST['aAverageChildDose'];
          $pAverageChildDose = $_POST['pAverageChildDose'];
          $aAdultDose = $_POST['aAdultDose'];
          $pAdultDose = $_POST['pAdultDose'];
          $aMaxDrugShortagePermittedKids = $_POST['aMaxDrugShortagePermittedKids'];
          $pMaxDrugShortagePermittedKids = $_POST['pMaxDrugShortagePermittedKids'];
          $aExtraSchoolsPerDistrict = $_POST['aExtraSchoolsPerDistrict'];
          $pExtraSchoolsPerDistrict = $_POST['pExtraSchoolsPerDistrict'];
          $aAssumedSchoolSize = $_POST['aAssumedSchoolSize'];
          $pAssumedSchoolSize = $_POST['pAssumedSchoolSize'];
          $aMaxDrugShortagePermittedDrugs = $_POST['aMaxDrugShortagePermittedDrugs'];
          $pMaxDrugShortagePermittedDrugs = $_POST['pMaxDrugShortagePermittedDrugs'];
          $aAverageDrugNeed = $_POST['aAverageDrugNeed'];
          $pAverageDrugNeed = $_POST['pAverageDrugNeed'];
          $aAverageTinsNeededPerSchools = $_POST['aAverageTinsNeededPerSchools'];
          $pAverageTinsNeededPerSchools = $_POST['pAverageTinsNeededPerSchools'];
          $aCalcDrugsPerSchool = $_POST['aCalcDrugsPerSchool'];
          $pCalcDrugsPerSchool = $_POST['pCalcDrugsPerSchool'];
          $aTreatYear = $_POST['aTreatYear'];
          $pTreatYear = $_POST['pTreatYear'];
          $areaAssumptions = $_POST['areaAssumptions'];

          $query = ( "INSERT INTO assumptions
             (dateSaved,
              aChildrenTreatedPerAdult,
              pChildrenTreatedPerAdult,
              aNonEnrolledPerSchool,
              pNonEnrolledPerSchool,
              aUnderFivesTreated,
              pUnderFivesTreated,
              aPopulationGrowthAnnual,
              pPopulationGrowthAnnual,
              aSpoilage,
              pSpoilage,
              aTinSize,
              pTinSize,
              aAverageChildDose,
              pAverageChildDose,
              aAdultDose,
              pAdultDose,
              aMaxDrugShortagePermittedKids,
              pMaxDrugShortagePermittedKids,
              aExtraSchoolsPerDistrict,
              pExtraSchoolsPerDistrict,
              aAssumedSchoolSize,
              pAssumedSchoolSize,
              aMaxDrugShortagePermittedDrugs,
              pMaxDrugShortagePermittedDrugs,
              aAverageDrugNeed,
              pAverageDrugNeed,
              aAverageTinsNeededPerSchools,
              pAverageTinsNeededPerSchools,
              aCalcDrugsPerSchool,
              pCalcDrugsPerSchool,
              aTreatYear,
              pTreatYear,
              areaAssumptions)
						VALUES ('$dateSaved',
              '$aChildrenTreatedPerAdult',
              '$pChildrenTreatedPerAdult',
              '$aNonEnrolledPerSchool',
              '$pNonEnrolledPerSchool',
              '$aUnderFivesTreated',
              '$pUnderFivesTreated',
              '$aPopulationGrowthAnnual',
              '$pPopulationGrowthAnnual',
              '$aSpoilage',
              '$pSpoilage',
              '$aTinSize',
              '$pTinSize',
              '$aAverageChildDose',
              '$pAverageChildDose',
              '$aAdultDose',
              '$pAdultDose',
              '$aMaxDrugShortagePermittedKids',
              '$pMaxDrugShortagePermittedKids',
              '$aExtraSchoolsPerDistrict',
              '$pExtraSchoolsPerDistrict',
              '$aAssumedSchoolSize',
              '$pAssumedSchoolSize',
              '$aMaxDrugShortagePermittedDrugs',
              '$pMaxDrugShortagePermittedDrugs',
              '$aAverageDrugNeed',
              '$pAverageDrugNeed',
              '$aAverageTinsNeededPerSchools',
              '$pAverageTinsNeededPerSchools',
              '$aCalcDrugsPerSchool',
              '$pCalcDrugsPerSchool',
              '$aTreatYear',
              '$pTreatYear',
              '$areaAssumptions')" );
          mysql_query($query) or die(mysql_error());
        }
        ?>
        <div id="divCurrentAssumptions" style="margin: 0 auto">
          <table>
            <tr>
              <form method="post">
                <!--header-->
                <h1 style="text-align: center; margin-top: 0px; font-size: 20px">Dispatch CHC</h1>
                <!-- table begin  =============-->
                <td style="width: 60%">
                  <table border="2" align="center" cellpadding="0" style="width: 100%;">
                    <tr style="background-color: silver;">
                      <td colspan="6" style="padding: 5px;"><b>CHC CASH REQUISITION SUMMARY SHEET	<br/>   Calculation Table	 </b></td>
                    </tr>
                    <tr>
                      <td> <b>Description </b> </td>
                      <td> <b>Amount </b> </td>
                    </tr>

                    <tr>
                      <td>Listed KM's from Makueni to Nairobi</td>
                      <td align="center" width="200px"><input type="text" id="aChildrenTreatedPerAdult" name="aChildrenTreatedPerAdult" value="<?php echo $aChildrenTreatedPerAdult ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                    </tr>
                    <tr>
                      <td>Fuel is calculated using the 30KShs per Kilometre GoK provided rate (Ministry of Public Works Cirrcular)</td>
                      <td><input type="text" id="aNonEnrolledPerSchool" name="aNonEnrolledPerSchool" value="<?php echo $aNonEnrolledPerSchool ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                    </tr>
                    <tr>
                      <td>Agreed upon Fuel Amount to be given to CHC</td>
                      <td><input type="text" id="aUnderFivesTreated" name="aUnderFivesTreated" value="<?php echo $aUnderFivesTreated ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                    </tr>
                    <tr>
                      <td>Lunch for Driver to Drive to NBO to receive the drugs</td>
                      <td><input type="text" id="aPopulationGrowthAnnual" name="aPopulationGrowthAnnual"  value="<?php echo $aPopulationGrowthAnnual ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                    </tr>
                    <tr>
                      <td>Lunch for County Pharmacist escorting driver</td>
                      <td><input type="text" id="aSpoilage" name="aSpoilage"  value="<?php echo $aSpoilage ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                    </tr>
                    <tr>
                      <td>Coordination Allowance for CHC</td>
                      <td><input type="text" id="aTinSize" name="aTinSize"  value="<?php echo $aTinSize ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                    </tr>
                    <tr>
                      <td><b>TOTAL AMOUNT NEEDED BY CHC</b></td>
                      <td><input type="text" id="aTinSize" name="aTinSize"  value="<?php echo $aTinSize ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                    </tr>
                    <tr height="20px">
                      <td><b></b></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td align="right">CHC's Name</td>
                      <td><input type="text" id="aTinSize" name="aTinSize"  value="<?php echo $aTinSize ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                    </tr>
                    <tr>
                      <td align="right">CHC's Mpesa Phone No.</td>
                      <td><input type="text" id="aTinSize" name="aTinSize"  value="<?php echo $aTinSize ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                    </tr>
                  </table><br/><br/>
                </td>
                <td style="float: left; width: 100%; padding-left: 20px">
                  <b>Date Saved </b><input type="text"  value="<?php echo $dateSaved ?>" class="txt-input-table-center" style="width: 100px"readonly />
                  <br/> <br/>
                  <b> Accountability Documents to be received  </b><br/>
                  <textarea cols="50" rows="8" id="notes" name="areaAssumptions" placeholder="">
CHC to send copy of Work-Ticket and Fuel receipt to account for fuel Funds and movement of vehicle 
Driver to sign a Lunch Allowance Form 
County Pharmacist to sign a Lunch Allowance Form 
CHC to sign Coordination Allowance Form</textarea>
                  <br/> <br/>
                  <a href="javascript:void(0)" style="float: left" class="btn-custom-tiny" onclick="calculateAssumptions();"> Confirm calculations</a>
                  <input style="float: left" type="submit" name="submitSaveNew" value="Save record" class="btn-custom-tiny"/>
                </td>
                <div class="vclear"/>
                <br/>
              </form>
            </tr>
          </table>
          <div style="border: 1px solid black"></div><br/>

          <!--================================================-->
          <!--   OTHER RECORDS           -->
          <!--================================================-->
          <?php
          //Delete
          if (isset($_GET['deleteid'])) {
            $deleteid = $_GET['deleteid'];
            $query = "DELETE FROM assumptions WHERE id='$deleteid'";
            $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
          }
          ?>
          <table >
            <tr>
              <td>
                <div style="width: 100%;">
                  <h1 style="text-align: center; margin-top: 0px; font-size: 20px">Previous Dispatch CHC data</h1>
                  <div style=" margin-right: 20px">
                    <form method="post">
                      <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                        <thead>
                          <tr style="border: 1px solid #B4B5B0;">
                            <th align="Left" width="40px">ID</th>
                            <th align="Left" width="100px">Date Saved</th>

                            <th align="center" width="40px">View</th>
                            <th align="center" width="40px">Del</th>
                          </tr>
                        </thead>
                      </table>
                    </form>
                  </div>

                  <div style="width:100%; height:300px; overflow-x: visible; overflow-y: scroll; float: left">
                    <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                      <tbody>

                        <?php
                        $result_set = mysql_query("SELECT * FROM assumptions  ORDER BY id DESC");
                        while ($row = mysql_fetch_array($result_set)) {
                          $id = $row['id'];
                          $dateSaved = $row['dateSaved'];
                          $aTreatYear = $row['aTreatYear'];
                          $pTreatYear = $row['pTreatYear'];
                          $areaAssumptions = $row['areaAssumptions'];
                          ?>
                          <tr style="border-bottom: 1px solid #B4B5B0;">

                            <td align="left" width="40px"> <?php echo $id; ?>  </td>
                            <td align="left" width="100px"> <?php echo $dateSaved; ?>  </td>  
  <!--                            <td align="left" width="200px"><?php
                            echo substr($areaAssumptions, 0, 30);
                            if (strlen($areaAssumptions) > 30)
                              echo "..";
                            ?>
                            </td>-->

                            <td align="center" width="40px"><a href="javascript:void(0)" onclick="loadRecordN('load',<?php echo $id; ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                            <td align="center" width="40px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                          </tr>
                        </tbody>
                      <?php } ?>
                    </table>
                  </div>


                </div>
              </td>
              <td style="padding-left: 20px">
                <div id="divDisplayAssumption" style="width: 100%;">




                  <form method="post">
                    <!--header-->
                    <!--<h1 style="text-align: center; margin-top: 0px; font-size: 20px">Dispatch CHC</h1>-->
                    <!-- table begin  =============-->
                    <td style="width: 50%">
                      <table border="2" align="center" cellpadding="0" style="width: 550px;">
                        <tr style="background-color: silver;">
                          <td colspan="6" style="padding: 5px;"><b>CHC CASH REQUISITION SUMMARY SHEET	<br/>   Calculation Table	 </b></td>
                        </tr>
                        <tr>
                          <td> <b>Description </b> </td>
                          <td> <b>Amount </b> </td>
                        </tr>

                        <tr>
                          <td>Listed KM's from Makueni to Nairobi</td>
                          <td align="center" width="100px"><input type="text" id="aChildrenTreatedPerAdult" name="aChildrenTreatedPerAdult" value="<?php echo $aChildrenTreatedPerAdult ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                        </tr>
                        <tr>
                          <td>Fuel is calculated using the 30KShs per Kilometre GoK provided rate (Ministry of Public Works Cirrcular)</td>
                          <td><input type="text" id="aNonEnrolledPerSchool" name="aNonEnrolledPerSchool" value="<?php echo $aNonEnrolledPerSchool ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                        </tr>
                        <tr>
                          <td>Agreed upon Fuel Amount to be given to CHC</td>
                          <td><input type="text" id="aUnderFivesTreated" name="aUnderFivesTreated" value="<?php echo $aUnderFivesTreated ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                        </tr>
                        <tr>
                          <td>Lunch for Driver to Drive to NBO to receive the drugs</td>
                          <td><input type="text" id="aPopulationGrowthAnnual" name="aPopulationGrowthAnnual"  value="<?php echo $aPopulationGrowthAnnual ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                        </tr>
                        <tr>
                          <td>Lunch for County Pharmacist escorting driver</td>
                          <td><input type="text" id="aSpoilage" name="aSpoilage"  value="<?php echo $aSpoilage ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                        </tr>
                        <tr>
                          <td>Coordination Allowance for CHC</td>
                          <td><input type="text" id="aTinSize" name="aTinSize"  value="<?php echo $aTinSize ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                        </tr>
                        <tr>
                          <td><b>TOTAL AMOUNT NEEDED BY CHC</b></td>
                          <td><input type="text" id="aTinSize" name="aTinSize"  value="<?php echo $aTinSize ?>" onBlur="calculateAssumptions();" onKeyUp="isNumericErase(this.id);" class="txt-input-table-center"/></td>
                        </tr>
                      </table><br/><br/>
                    </td>
                  </form>









                </div>
              </td>
            </tr>
          </table>
        </div>
        <div class="clearFix"></div>
        <!---------------- Footer ------------------------>
        <!--<div class="footer">  </div>-->

        <script type="text/javascript">
                        function calculateAssumptions() {
                          var B2 = document.getElementById('aChildrenTreatedPerAdult').value * 1;
                          var C2 = document.getElementById('pChildrenTreatedPerAdult').value * 1;
                          var B3 = document.getElementById('aNonEnrolledPerSchool').value * 1;
                          var C3 = document.getElementById('pNonEnrolledPerSchool').value * 1;
                          var B4 = document.getElementById('aUnderFivesTreated').value * 1;
                          var C4 = document.getElementById('pUnderFivesTreated').value * 1;
                          var B5 = document.getElementById('aPopulationGrowthAnnual').value * 1;
                          var C5 = document.getElementById('pPopulationGrowthAnnual').value * 1;
                          var B6 = document.getElementById('aSpoilage').value * 1;
                          var C6 = document.getElementById('pSpoilage').value * 1;
                          var B7 = document.getElementById('aTinSize').value * 1;
                          var C7 = document.getElementById('pTinSize').value * 1;
                          var B8 = document.getElementById('aAverageChildDose').value * 1;
                          var C8 = document.getElementById('pAverageChildDose').value * 1;
                          var B9 = document.getElementById('aAdultDose').value * 1;
                          var C9 = document.getElementById('pAdultDose').value * 1;
                          var B10 = document.getElementById('aMaxDrugShortagePermittedKids').value * 1;
                          var C10 = document.getElementById('pMaxDrugShortagePermittedKids').value * 1;
                          var B11 = document.getElementById('aExtraSchoolsPerDistrict').value * 1;
                          var C11 = document.getElementById('pExtraSchoolsPerDistrict').value * 1;
                          var B12 = document.getElementById('aAssumedSchoolSize').value * 1;
                          var C12 = document.getElementById('pAssumedSchoolSize').value * 1;

                          var B13 = document.getElementById('aMaxDrugShortagePermittedDrugs').value;
                          var C13 = document.getElementById('pMaxDrugShortagePermittedDrugs').value;

                          //==============================================================================

                          document.getElementById('aMaxDrugShortagePermittedDrugs').value = B10 * B8;
                          document.getElementById('pMaxDrugShortagePermittedDrugs').value = C10 * C8;

                          var B14 = document.getElementById('aAverageDrugNeed').value = ((B12 + (B12 / B2) + B3 + (B4 * B12)) * (1 + B6)).toFixed(2);
                          var C14 = document.getElementById('pAverageDrugNeed').value = (((C12 * 2.5) + (C12 / B2) + B3) * (B6 + 1)).toFixed(2);

                          //var B14 = document.getElementById('aAverageDrugNeed').value;
                          //var C14 = document.getElementById('pAverageDrugNeed').value;

                          var B16 = document.getElementById('aCalcDrugsPerSchool').value = (B14 / B7).toFixed(3);
                          var C16 = document.getElementById('pCalcDrugsPerSchool').value = (C14 / 1).toFixed(-3);
                          //var B15 = document.getElementById('aAverageTinsNeededPerSchools').value;
                          //var C15 = document.getElementById('pAverageTinsNeededPerSchools').value;
                          //var B16 = document.getElementById('aCalcDrugsPerSchool').value;
                          //var C16 = document.getElementById('pCalcDrugsPerSchool').value;

                          document.getElementById('aAverageTinsNeededPerSchools').value = (B16 / 1).toFixed(0);
                          document.getElementById('pAverageTinsNeededPerSchools').value = (C16 / 1000).toFixed(0);
                        }
        </script>
        <!--Delete dialog-->
        <script>
          function show_confirm(deleteid) {
            if (confirm("Are you sure you want to delete?")) {
              location.replace('?deleteid=' + deleteid);
            } else {
              return false;
            }
          }


          //show previous records
          function loadRecord(req, val) {
            if (req == "") {
              document.getElementById("divShowContent").innerHTML = "";
              return;
            }
            if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
            }
            else {// code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
              if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("divDisplayAssumption").innerHTML = xmlhttp.responseText;
              }
            }
            xmlhttp.open("GET", "ajax_files/assumptions.php?req=" + req + "&val=" + val, true);
            xmlhttp.send();
          }
        </script>
        </body>
        </html>




