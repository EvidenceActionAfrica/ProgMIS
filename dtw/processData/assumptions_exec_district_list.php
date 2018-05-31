<?php

require_once "includes/class.districtList.php";
$ClassDistrictList = new districtList;

// all counties
$counties=$ClassDistrictList->getCounties();

// get schools
$getSchools=$ClassDistrictList->getSchools();


         
            
                $my_array=array();
                // $ClassDistrictList->truncateTable();

                // get table name
                $tablename=$ClassDistrictList->createSqlTable();
                // createDistrictList

                if ($tablename != "exists") {
                  foreach ($getSchools as $key => $row) {

                  // while ($row = mysql_fetch_array($result_set)) {
                    // $id = $row['id'];
                    $county_name = $row['county'];
                    $county_id = $row['county_id'];
                    $district_name = $row['district_name'];
                    $district_id = $row['district_id'];
                 
                      $county_name; 
                      $district_name;
                      $district_id;

                      // <!-- Number of schools -->
                      $numberOfSChools = $ClassDistrictList->numberOfSChools($district_id); 

                      // <!-- Number of schisto schools -->
                      $numberOfShistoSchools = $ClassDistrictList->numberOfShistoSchools($district_id); 

                      // <!-- ALB -->
                      $alb_amount = $ClassDistrictList->albAmount($district_id); 

                      // <!-- PZQ -->
                      $pzqAmount = $ClassDistrictList->pzqAmount($district_id); 

                      // <!-- District Extra ALB -->
                      number_format($district_extra_alb = $ClassDistrictList->districtAssumptionProduct('aExtraSchoolsPerDistrict', 'aAverageTinsNeededPerSchools', 'aTinSize'));

                      // <!-- District Extra PZQ -->
                      $extra_pzq = $ClassDistrictList->ifElseMultiply($pzqAmount, 'pExtraSchoolsPerDistrict', 'pAverageTinsNeededPerSchools', 'pCalcDrugsPerSchool');

                      // <!-- Total Albendazole -->
                      number_format($total_alb = $ClassDistrictList->addValues($district_extra_alb, $alb_amount));

                      // <!-- Total PZQ -->
                      number_format($total_pzq = $ClassDistrictList->addValues($extra_pzq, $pzqAmount));

                      // <!-- Next Treatment -->
                      $next_treatment = "N/A";

                      // <!-- Schisto district -->
                      $shistoDistrict = $ClassDistrictList->shistoDistrict($district_id);

                      // insert result into database
                      
                      $ClassDistrictList->create( $tablename,
                                                  $county_name, 
                                                  $county_id, 
                                                  $district_name, 
                                                  $district_id, 
                                                  $numberOfSChools, 
                                                  $numberOfShistoSchools, 
                                                  $pzqAmount, 
                                                  $alb_amount, 
                                                  $district_extra_alb, 
                                                  $extra_pzq, 
                                                  $total_alb, 
                                                  $total_pzq, 
                                                  $next_treatment, 
                                                  $shistoDistrict
                                        );

                      






                 } 

                 ?>
                    <!-- shoe the loding image and finnised alert if district list was generated -->
                    <img id="loading-image" src="../../images/loading.gif" alt="Loading..." />
                     <script type="text/javascript">

                        window.onload=function(){
                          alert("finished");
                          window.close()
                        };
                     </script>


                 <?php
               }else{
                ?>
                      <!-- only show the alert saying the district list is up to date -->
                     <script type="text/javascript">

                        window.onload=function(){
                          alert("District List is up to date");
                          window.close()
                        };
                     </script>
                <?php
               }



               ?>
            
