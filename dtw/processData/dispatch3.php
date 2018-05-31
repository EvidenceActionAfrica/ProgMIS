    
          <table >
            <tr>
              <td style="width: 100%;">
                
                  <h1 style="text-align: center; margin-top: 0px; font-size: 20px">Previous Dispatch CHC data</h1>
                  
                    <form method="post" style=" margin-right: 20px">
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
                  

                 
                    <table  style="width:100%; height:300px; overflow-x: visible; overflow-y: scroll; float: left"width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
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