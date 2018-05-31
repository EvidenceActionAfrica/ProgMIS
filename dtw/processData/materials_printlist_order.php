<?php
date_default_timezone_set("Africa/Nairobi");
 $disSelection=$_SESSION["district_selection"];//Extremely important:Do Not Touch
//    echo '<br/>opening file...';
if($_SESSION["district_selection"] !=null){
 
        /*
          Be careful when dealing with this post.It inserts into three tables. One to manage the print orders,
          anpther for the vendor quote

        */
        if(isset($_POST["savePrintOrder"])){
                $materialArray=Array();
                $quantityArray=Array();
                $quantity_desc_array=Array();
             //   echo '<br/>processing post...';
                $sql='SELECT * from materials_cat_organizer WHERE printlist_appearance=2 ORDER BY category';
                $catResult=mysqli_query($db_mysqli_connection,$sql);
                $category=array();
                while($catRow=mysqli_fetch_assoc($catResult)){
                  array_push($category,$catRow["category"]);
                }
                mysqli_free_result($catResult);
                $sql="SELECT materials_abbv,materials from materials_desc WHERE materials_abbv !=''";
                foreach ($category as $key => $value) {
                  $sql.=' AND packet!="'.$value.'" AND material_category!="'.$value.'"';
                }

                 $resultF=mysqli_query($db_mysqli_connection,$sql) or die("Error");
                while($row=mysqli_fetch_assoc($resultF)){
                   
                  $quantity_desc=str_replace(' ','_',$row["materials"]);
                  
                  ${$row["materials_abbv"]}=isset($_POST[$quantity_desc])?mysqli_real_escape_string($db_mysqli_connection,$_POST[$quantity_desc]):"";

                  $quantity=${$row["materials_abbv"]};
                  array_push($quantityArray,$quantity);
                  array_push($quantity_desc_array,$row["materials"]);
                  array_push($materialArray,$row["materials_abbv"]);
                
                }
            //        echo '<br/>collecting array...';
                 mysqli_free_result($resultF);
             
                
                
                $vendorName=isset($_POST["vendorName"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["vendorName"]):"unknown";
                $preparedBy=$_SESSION['staff_name'];
                $status=1;




                //Set all other Records To inactive

                $sql="SELECT * from materials_printlist_history where status=1";
                $resultU=mysqli_query($db_mysqli_connection,$sql);

                while($row=mysqli_fetch_assoc($resultU)){
                  $sql="Update materials_printlist_history set status=2 where id=".$row["id"];
                //echo $sql."<br/>";
                 mysqli_query($db_mysqli_connection,$sql);
                }
              //     echo '<br/>replace active printlist...';
                 //setting the data into printlist order history



                $sql="SELECT * from materials_desc";
                $resultA=mysqli_query($db_mysqli_connection,$sql);
                $materialDesc=array();
                while($key=mysqli_fetch_assoc($resultA)){
                 $materialDesc[]=[$key["materials"],$key["packet"],$key["var1"],$key["var2"],$key["var3"],$key["var4"],$key["var5"],$key["extra"],$key["extra_materials"]];

                }
                 mysqli_free_result($resultA);
                         
                $materialDescArray=serialize($materialDesc);
                //$status=1;
                $disSelection=serialize($disSelection);
                $time_set=time();
                $sql="INSERT INTO `materials_printlist_history`(`vendor_name`, `prepared_by`, `status`,`districts`,`time_set`,`assumptions`)";
                $sql.=" VALUES ('$vendorName','$preparedBy',1,'$disSelection','$time_set','$materialDescArray')";
                //   echo $sql."<br/>";
                 

                $result=mysqli_query($db_mysqli_connection,$sql);

                if($result){
                $updateResult.="<br/> &nbsp; This Printlist has been set as the Active Printlist.To Edit go to Printlist History";
                }else{
                  $updateResult.="<br/> &nbsp; This Printlist has not been set as the active Printlist. Contact Your System Administrator";
                }
                
                $sql="SELECT * from materials_printlist_history where status=1";
                $resultS=mysqli_query($db_mysqli_connection,$sql);
                 //  echo $sql."<br/>";
                while($row=mysqli_fetch_assoc($resultS)){
                  $printlistId=$row["id"];
                }
                 mysqli_free_result($resultS);
        //             echo '<br/>reading new printlist...';



                $append=0;
                //echo "Material Array has ".
                $count=sizeof($materialArray);

                $sql="DELETE from materials_printlist_history_data WHERE printlist_id='".$printlistId."'";
                mysqli_query($db_mysqli_connection,$sql);
                
                $sql="INSERT INTO `materials_printlist_history_data`(`material`, `print_order_quantity`, `printlist_id`) VALUES ";
                while($append<$count){

                  $quantity=isset($quantityArray[$append])?intval($quantityArray[$append]):0;
                  $material_desc=$quantity_desc_array[$append];

               
                $sql.="('$material_desc',$quantity,".$printlistId."),";
                //echo $append.''.$sql."<br/>";
               
                ++$append;
                }

              
                $sql = rtrim($sql, ",");
                mysqli_query($db_mysqli_connection,$sql);

              
                //Now that we have the printlist id we can update the quote table with the quantities and 
                //printlist id for the respective printlist

                //echo "Quantities Collected are"
                $count=sizeof($quantityArray)-1;
                $append=0;
                $sql="DELETE from materials_vendor_quote_history WHERE printlist_id='".$printlistId."'";
               // mysqli_query($db_mysqli_connection,$sql);

                $sql="INSERT INTO `materials_vendor_quote_history`(`materials`, `print_order_quantity`, `print_order_unit_price`,";
                $sql.="`print_order_price`, `updated_print_order_quantity`, `updated_print_order_unit_price`, ";
                $sql.="`updated_print_order_price`, `printlist_id`) VALUES ";
                  // echo '<br/>performing last insert...';
                while($append<=$count){
                     $quantity=isset($quantityArray[$append])?intval($quantityArray[$append]):0;
                     $material_desc=$quantity_desc_array[$append];
                     ++$append;
                     $sql.=" ('$material_desc','$quantity',0,0,0,0,0,'$printlistId'),";
                }
                $sql = rtrim($sql, ",");
                mysqli_query($db_mysqli_connection,$sql) or die(mysqli_error($db_mysqli_connection));
                $updateResult="Print Order Created";
                 //   echo '<br/>print order saved...';
                  $action='A new print order is created';
                $description=' A Print order under the vendor name '.$vendorName.' has been Created';
                $ArrayData = array($M_module, $action, $description);
                quickFuncLog($ArrayData);

               unset($_SESSION["district_selection"]);
               // echo 'current session '.$_SESSION["district_selection"];
                //print_r($_SESSION);
               $disSelection=null;
        }
}

//echo '<br/>after the post...';
     //just incase a post request was made
if(!isset($_POST["savePrintOrder"])){

?>
    <form method="post">
       <div style='background:#bada66;'>
           <span id="h2info" style="font-size:1.3em;text-align:center;"><?php echo $updateResult;
             $updateResult=""; ?></span>
        </div>
      
        <table align="center" class="table table-bordered table-condensed table-striped table-hover">
             <tr>
                <th>Vendor Name: &nbsp;</th>
                <th> <input type="text" id="vendorName" name="vendorName" value="" style='background-color:#FFF;height:100%;' placeholder='Enter Vendor Name Here' required/></th>
             </tr>
             <tr>
                <th>Materials</th>
                <th>Quantity</th>
             </tr>
                <?php
                $sql='SELECT * from materials_cat_organizer WHERE printlist_appearance=1 ORDER BY category';
                $catResult=mysqli_query($db_mysqli_connection,$sql);
                
                
                while($catRow=mysqli_fetch_assoc($catResult)){
                    $category=$catRow["category"];

                    
                    $sql='SELECT * from materials_desc WHERE training_box_desc="'.$category.'" order by packet';
                    $result=mysqli_query($db_mysqli_connection,$sql);
                    $numRows=mysqli_affected_rows($db_mysqli_connection);
                    if($numRows<1){
                      continue;
                    }else{
                      echo '<tr><th colspan="2"><h2>'.$category.'</h2></th></tr>';
                    }
                    $packageCounter=0;
                    $activePackage="";
                    while($matRow=mysqli_fetch_assoc($result)){
                          $material=$matRow['materials'];
                          $totalVar='';
                          $var1=$matRow['var1'];
                          $var2=$matRow['var2'];
                          $var3=$matRow['var3'];
                          $var4=$matRow['var4'];
                          $extra=$matRow['extra'];
                          $var5=$matRow['var5'];

                           $sql='SELECT * from materials_cat_organizer WHERE category="'.$matRow['packet'].'" AND printlist_appearance !=1';
                           $materialAppear=mysqli_query($db_mysqli_connection,$sql);

                           $appearRows=mysqli_affected_rows($db_mysqli_connection);
                           mysqli_free_result($materialAppear);
                           //If the Packet has been switched off in the printlist structure (General Assumptions page) then the material won't appear
                           if($appearRows>=1){
                            continue;
                           }
                            // $packageTocheck=strtolower($matRow['packet']);
                            // $packageTocheck=trim($packageTocheck);
                            if(strcmp($matRow['packet'],$activePackage)!=0){
                                $packageCounter=0;
                            }
                            if($packageCounter==0){
                            echo '<tr><th colspan="2"><h2>Packet : '.$matRow['packet'].'</h2></th></tr>';
                              ++$packageCounter;
                              $activePackage=$matRow['packet'];
                            }

                            $packagedMaterials=$matRow['packaged'];
                            //$percent = ($var5 + 100) / 100;

                            //For Performing MRound Function 
                            $perform_mround=$matRow['perform_mround'];
                        

                            $sql="SELECT DISTINCT a.county,a.district_name FROM districts as a,rollout_activity as r  where ";
                            // echo '<pre>';
                            // print_r($disSelection);
                            // echo '</pre>';
                            // exit();
                               foreach ($disSelection as $key => $value) {
                                  if($key==0){
                                      $sql.="a.district_name='".$value."'";        
                                  }else{
                                   $sql.=" OR a.district_name='".$value."'";
                                 }
                               }
                             $sql.=" ORDER BY a.county";
                                
                                $Placeresult = mysqli_query($db_mysqli_connection,$sql);
                                $counter=1;
                        
                                 while ($rowPlace = mysqli_fetch_assoc($Placeresult)) {
                                      $county_name = $rowPlace['county'];
                                      $district_name = $rowPlace['district_name'];
                                       //DEFAULT VARIABLES TO BE USED THROUGHTOUT

                                      $sql = "SELECT * from divisions where district_name='" . $district_name . "'";
                                 
                                      $resultX = mysqli_query($db_mysqli_connection,$sql);

                                      $no_of_divisions = mysqli_affected_rows($db_mysqli_connection);
                                      mysqli_free_result($resultX);

                                      /*
                                      $result1 = mysqli_query($db_mysqli_connection,"SELECT COUNT(a_school_name) FROM a_bysch WHERE district_name='$district_name' AND ap_attached='No'");
                                      while ($row1 = mysqli_fetch_assoc($result1)) {
                                          $sth_schools = $row1['COUNT(a_school_name)'];
                                      }
                                      $result2 = mysqli_query($db_mysqli_connection,"SELECT COUNT(ap_school_name) FROM a_bysch WHERE district_name='$district_name' AND ap_attached='Yes'");
                                      while ($row2 = mysqli_fetch_assoc($result2)) {
                                          $schisto_schools = $row2['COUNT(ap_school_name)'];
                                      }
                                      $result3 = mysqli_query($db_mysqli_connection,"SELECT COUNT(school_id) FROM a_bysch WHERE district_name='$district_name'");
                                      while ($row3 = mysqli_fetch_assoc($result3)) {
                                          $total_schools = $row3['COUNT(school_id)'];
                                      }
                                      */
                                      $result1 = mysqli_query($db_mysqli_connection,"SELECT COUNT(school_name) FROM schools WHERE district_name='$district_name' AND (closed='No' OR closed='NO' OR closed='no') AND treatment_type='STH' ");
                                      while ($row1 = mysqli_fetch_assoc($result1)) {
                                          //      echo  "STH IS ";
                                          $sth_schools = $row1['COUNT(school_name)'];
                                          // echo "<br/>";
                                      }
                                      mysqli_free_result($result1);
                                      $result2 = mysqli_query($db_mysqli_connection,"SELECT COUNT(school_name) FROM schools WHERE district_name='$district_name' AND (closed='No' OR closed='NO' OR closed='no') AND treatment_type!='STH'");
                                      while ($row2 = mysqli_fetch_assoc($result2)) {
                                          // echo "Shisto is";
                                          $schisto_schools = $row2['COUNT(school_name)'];
                                           // echo "<br/>";
                                      }
                                       mysqli_free_result($result2);
                                      $result3 = mysqli_query($db_mysqli_connection,"SELECT COUNT(school_id) FROM schools WHERE district_name='$district_name' AND (closed='No' OR closed='NO' OR closed='no')");
                                      while ($row3 = mysqli_fetch_assoc($result3)) {
                                           //   echo "Total Schools is";
                                           $total_schools = $row3['COUNT(school_id)'];
                                           //   echo "<br/>";
                                      }
                                       mysqli_free_result($result3);
                                      $tts_sessions =ceil($total_schools/20);

                                      $sql = "SELECT * FROM materials_officials_assumptions WHERE district_name='$district_name'";
                                      $result4 = mysqli_query($db_mysqli_connection,$sql) or die(mysqli_error($db_mysqli_connection));
                                      
                                      while ($row4 = mysqli_fetch_assoc($result4)) {
                                          $dist_moe_officials = $row4['district_education_contacts'];
                                          $div_moe_officials = $row4['division_education_contacts'];
                                         
                                      }
                                      mysqli_free_result($result4);
                                      $result5 = mysqli_query($db_mysqli_connection,"SELECT * FROM materials_officials_assumptions WHERE district_name='$district_name'");
                                      while ($row5 = mysqli_fetch_assoc($result5)) {
                                          $dist_moh_officials = $row5['district_health_contacts'];
                                          $div_moh_officials = $row5['division_health_contacts'];

                                          //   echo "district moh".$dist_moh_officials."<br/>";
                                          //  echo "div moh officials".$div_moh_officials."<br/>";
                                      }
                                      mysqli_free_result($result5);
                                      $result6 = mysqli_query($db_mysqli_connection,"SELECT * FROM materials_officials_assumptions WHERE district_name='$district_name'") or die(mysqli_error($db_mysqli_connection));
                                      while ($row6 = mysqli_fetch_assoc($result6)) {
                                          $mts = $row6["master_trainers"];
                                          //     echo "Master Trainers ".$mts."<br/>";
                                      }
                                      mysqli_free_result($result6);
                                      $result7 = mysqli_query($db_mysqli_connection,"SELECT COUNT(district_name) FROM a_bysch WHERE district_name='$district_name' AND ap_attached='Yes'");
                                      while ($row7 = mysqli_fetch_assoc($result7)) {

                                          $schisto_district = $row7['COUNT(district_name)'];
                                      }
                                      mysqli_free_result($result7);

                                      //END OF DEFAULT VARIABLES TO BE USED THROugHOUT NB:THere are other
                                      //variables below but change depending on the material being passed

                                                    
                                       //This Code is for extracting the variables and encapsulating them as needed.
                                      ${$matRow['materials_abbv']}=str_replace('$','${',$matRow['formula']);
                                      $var=${$matRow['materials_abbv']};
                                      $var=str_replace('XE#','}',$var);
                                      //End of extraction
                                      //Turning the data into php code for processing
                                      $var = @eval("return ${var};");
                                      //End of extracting php code from the db for processing
                                      //If It Has Decimal Place
                                      if (strpos( $var, '.' ) === false ) {
                                        $var=$var;
                                      }else{$var=ceil($var);} 
                                      //Incase the total Is Required
                                      $totalVar+=$var;
                                  }
                                     mysqli_free_result($Placeresult);


                                     if($packagedMaterials!=0){
                                      $totalVar=$totalVar*$packagedMaterials;
                                     }







                      echo '<tr>';
                      echo '<td>'.$material.'</td>';
                      echo '<td><input class="num-only" type="text" name="'.str_replace(' ','_',$material).'" value="'.$totalVar.'" /></td>';
                      echo '</tr>';
                     
                    }
                    mysqli_free_result($result);
                }
                mysqli_free_result($catResult);
               //   echo '<br/>the last php line...';
                ?>

        </table>
            <input type="submit" style="margin-left:40%;" id="savePrintOrder" name="savePrintOrder" class="btn-custom" value="Confirm Print Order" />
    </form>
    <script>
          function prepareEventHandler(){
          //var vendorId=document.getElementById("vendorId");
          var vendorName=document.getElementById("vendorName");
          var savePrintOrder=document.getElementById("savePrintOrder");
          var h3Error=document.createTextNode("Your Vendor Information is Incorrect.");
          var h2info=document.getElementById("h2info");

          //Prevents submit of page if validation does not pass
          savePrintOrder.onsubmit=function(){
              
              if(vendorName.value==="" ){
                  console.log("Validation Empty");
                      return false;
              }else{
                    if(isNaN(vendorName.value)){
                       console.log("Validation Pass");
                      return true;
                    }else{
                      console.log("Failed Validation");
                      h2info.appendChild(h3Error);
                      return false;
                    }
                 }
          };
          }
          window.onload=function(){
               prepareEventHandler();
               console.log("Validation script Works");
          };
    </script>
<?php
}else{
         echo   '  <div style="background:#bada66;">
                <span id="h2info" style="font-size:1.3em;text-align:center;">Please Select the Sub-county to generate the data From in the Sub-County Selection.</span>
                </div>';
     }
?>