<?php
ob_start();
date_default_timezone_set("Africa/Nairobi");
//The Materials Module need this because the number of queries performed are many, which may need more time to process
//than assigned by default in the server's config
ini_set('max_execution_time', 300); 
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once("class.mathMaterials.php");

$tabActive="tab1";

/*
*
*******************************
*   Printlist Requirements    *
*                             * 
*******************************
*1. Provide a Means of Selecting a set of Sub-counties involved in the printlist.
*2. Display All The Desired Categories (e.g Trainingboxes,packets) in a tabular form.
* 
*
*
*****************************
*   Printlist Solution      *
*                           *
*****************************
*
*1. Using a table called materials_cat_organizer, one can activate/deactivate a category.
*2. Sub-county selection will have checkboxes to determine the desired set.
*3. For All The Activated Categories Default variables will have to be set i.e
*the values of the no.of schools that are schisto,sth,no.of division and district officials,no. of teacher training sessions,
*definition of numbers 1-9 & material variables. 
*(The Names have already been defined below. All Formulas created for a material must use these varible names to work.)
*4.Material Variables are named using their abbreviations.(All Materials MUST have an abbreviation that is unique.) 
*5.All Materials must be whole numbers because no documents can be supplied in fraction(There is a few lines of code handling this
* that searches for a dot in the obvious float and performs a ceil function on it to make it whole.)
*
*

*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link href="../css/tabs_css.css" rel="stylesheet" type="text/css"/>
    <?php require_once ("includes/meta-link-script.php"); ?>
    <script src="../js/tabs.js"></script>
         <link href="css/materials.css" rel="stylesheet" type="text/css"/>
   
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
                   <div style="position:absolute;margin-left:15%;margin-top:-4%;max-height:10%;" class="alert alert-block">
              				Warning! &nbsp; This Form will only display data from the active printlist assumptions & selected Sub-Counties.
             		   </div>
                      <a href="materials_officials_Assumptions.php"></a>
                      <div class="contentLeft">
                        <?php
                        require_once ("includes/menuLeftBar-Materials.php");
                        ?>
                      </div>
                      <div class="contentBody" >
                            <div class="tabbable" >
                              <ul class="nav nav-tabs">

                                <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Sub-County Selection</a></li>
                              
                                  <?php
                                  // 1
                                
                                            $sql='SELECT * from materials_cat_organizer WHERE tab_appearance=1 ORDER by category';
                                            $resultCat=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
                                            while($row=mysqli_fetch_assoc($resultCat)){
                                            echo '   <li';
                                            if ($tabActive == "tab".$row['category']) echo "class='active'";
                                            echo '><a href="#tab'.str_replace(' ','_',$row["category"]).'" data-toggle="tab">'.$row["category"].'</a></li>
                                            ';

                                            }
                                            mysqli_free_result($resultCat);
                                     
                                     ?>
                              </ul>
                              <div class="tab-content" style="max-height:650px; overflow:scroll;">
                                
                             
                          		    <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1" style='background-color:rgb(255,255,255);'>
                          			    <p><?php require_once("materials_printlist_districts.php"); ?></p>
                          			  </div>

                                    <?php
                                      $disSelection=$_SESSION["district_selection"];

                                     
                                    if(isset($disSelection)){
                                  $sql='SELECT * from materials_cat_organizer WHERE tab_appearance=1 ORDER by category';
                                  $resultCat=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));


                                  while($row=mysqli_fetch_assoc($resultCat)){
                                    ?>
                                    <div class='tab-pane <?php if ($tabActive == "tab".str_replace(' ','_',$row["category"])) echo "active"; ?>' id='<?php echo 'tab'.str_replace(' ','_',$row["category"]) ?>'>
                                               <p>
                                             <?php
                                              //To Retrive Materials Of Each Category We Will Check the packet and material_category in 
                                             //the materials table

                                             $sqlHeader='SELECT * from materials_desc WHERE packet="'.$row['category'].'" OR training_box_desc="'.$row['category'].'"';
                                             $resultHeader=mysqli_query($db_mysqli_connection,$sqlHeader) or die(mysqli_error($db_mysqli_connection));
                                            
                                             echo '<table class="table table-bordered table-condensed table-striped table-hover">';
                                               //This is where the classification of a material is defined.just above the rest of the other data
                                             echo '<tr>';
                                             echo '<th colspan="3"></th>';
                                             $oldMaterial='';
                                             $materialSpanCount=0;//used in the loop below
                                             while($rowHeader=mysqli_fetch_assoc($resultHeader)){
                                                $newMaterial=$rowHeader["packet"];
                                                
                                                if($oldMaterial==''){
                                                  $oldMaterial=$newMaterial;
                                                  $materialSpanCount=1;
                                                }else if($oldMaterial==$newMaterial){
                                                  $materialSpanCount+=1;
                                                }else if($oldMaterial !='' && $oldMaterial !=$newMaterial){
                                                  
                                                  
                                                  echo '<th colspan="'.$materialSpanCount.'">'.str_replace('_',' ',$oldMaterial).'</th>';
                                                  $oldMaterial=$newMaterial;
                                                  $materialSpanCount=1;//for the new material
                                                }
                                         
                                             }
                                              mysqli_free_result($resultHeader);
                                             echo '<th colspan="'.$materialSpanCount.'">'.str_replace('_',' ',$oldMaterial).'</th>';
                                             echo '</tr>';
                                             echo '<tr>';
                                             echo '<th>No</th>';
                                              echo '<th>County</th>';
                                              echo '<th>Sub-County</th>';
                                              $resultHeader=mysqli_query($db_mysqli_connection,$sqlHeader) or die(mysqli_error($db_mysqli_connection));
                                             while($rowHeader=mysqli_fetch_assoc($resultHeader)){
                                             echo '<th>'.str_replace('_',' ',$rowHeader["materials"]).'</th>';

                                             }
                                             mysqli_free_result($resultHeader);
                                             echo '</tr>';



                                            $sql="SELECT DISTINCT a.county,a.district_name FROM districts as a,rollout_activity as r  where ";
                                          
                                             foreach ($disSelection as $key => $value) {
                                                if($key==0){
                                                    $sql.="a.district_name='".$value."'";        
                                                }else{
                                                 $sql.=" OR a.district_name='".$value."'";
                                               }
                                             }
                                             $sql.=" ORDER BY a.county";
                                              
                                              $result = mysqli_query($db_mysqli_connection,$sql);
                                              $counter=1;
                                              $totalsData='';
                                               while ($rowPlace = mysqli_fetch_assoc($result)) {
                                                      $county_name = $rowPlace['county'];
                                                      $district_name = $rowPlace['district_name'];
                                                

                                                      //DEFAULT VARIABLES TO BE USED THROUGHTOUT

                                                      $sql = "SELECT * from divisions where district_name='" . $district_name . "'";

                                                      $resultX = mysqli_query($db_mysqli_connection,$sql);

                                                      $no_of_divisions = mysqli_affected_rows($db_mysqli_connection);

                                                      /* When Source of schools was a_bysch
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
                                                          $sth_schools = $row1['COUNT(school_name)'];
                                                      }
                                                      mysqli_free_result($result1);
                                                      $query="SELECT COUNT(school_name) FROM schools WHERE district_name='$district_name' AND (closed='No' OR closed='NO' OR closed='no') AND treatment_type!='STH'";
                                                      $result2 = mysqli_query($db_mysqli_connection,$query);
                                                      while ($row2 = mysqli_fetch_assoc($result2)) {
                                                          $schisto_schools = $row2['COUNT(school_name)'];
                                                      }
                                                      mysqli_free_result($result2);
                                                      $result3 = mysqli_query($db_mysqli_connection,"SELECT COUNT(school_id) FROM schools WHERE district_name='$district_name' AND (closed='No' OR closed='NO' OR closed='no')");
                                                      while ($row3 = mysqli_fetch_assoc($result3)) {
                                                          $total_schools = $row3['COUNT(school_id)'];
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
                                                    
                                                      //Body Definition
                                                      echo '<tr>';
                                                      echo '<td>'.$counter.'</td>';
                                                      echo '<td>'.$county_name.'</td>';
                                                      echo '<td>'.$district_name.'</td>';
                                                        $sqlHeader='SELECT * from materials_desc WHERE packet="'.$row['category'].'" OR training_box_desc="'.$row['category'].'"';
                                                        $resultHeader=mysqli_query($db_mysqli_connection,$sqlHeader);
                                                  
                                                      while($rowHeader=mysqli_fetch_assoc($resultHeader)){
                                                         $var1=$rowHeader['var1'];
                                                        $var2=$rowHeader['var2'];
                                                        $var3=$rowHeader['var3'];
                                                        $var4=$rowHeader['var4'];
                                                        $extra=$rowHeader['extra'];
                                                        $var5=$rowHeader['var5'];
                                                     
                                                        //For Performing MRound Function 
                                                        $perform_mround=$rowHeader['perform_mround'];
                                                  

                                                      //This Code is for extracting the variables and encapsulating them as needed.
                                                      ${$rowHeader['materials_abbv']}=str_replace('$','${',$rowHeader['formula']);
                                                      $var=${$rowHeader['materials_abbv']};
                                                      $var=str_replace('XE#','}',$var);
                                                      //End of extraction
                                                      //Turning the data into php code for processing

                                                      $var = @eval("return ${var};");
                                                    
                                                      //End of extracting php code from the db for processing


                                                       //If It Has Decimal Place
                                                      if (strpos( $var, '.' ) === false ) {
                                                        $var=$var;
                                                      }else{$var=ceil($var);} 

                                                      echo '<td>'.$var.'</td>';
                                                       ${'total_'.$rowHeader['materials_abbv']}+=$var;
                                                       }

                                                      echo '</tr>';
                                                      ++$counter;
                                                }       
                                                  $sqlHeader='SELECT * from materials_desc WHERE packet="'.$row['category'].'" OR material_category="'.$row['category'].'" OR training_box_desc="'.$row['category'].'"';
                                                        $resultHeader=mysqli_query($db_mysqli_connection,$sqlHeader);
                                                  
                                                   echo '<tr>';
                                                  echo '<td colspan="3"><b>Total in Package</b></td>';
                                                while($rowHeader=mysqli_fetch_assoc($resultHeader)){
                                                    
                                                echo '<td><b>'.${'total_'.$rowHeader['materials_abbv']}.'</b></td>';
                                                 // echo '<td>hi</td>';
                                                  }
                                                  echo '</tr>';
                                                  echo '<tr>';
                                                  echo '<td colspan="3"><b>Documents To Print</b></td>';
                                                   $sqlHeader='SELECT * from materials_desc WHERE packet="'.$row['category'].'" OR material_category="'.$row['category'].'" OR training_box_desc="'.$row['category'].'"';
                                                        $resultHeader=mysqli_query($db_mysqli_connection,$sqlHeader);
                                                  
                                                while($rowHeader=mysqli_fetch_assoc($resultHeader)){
                                                    if($rowHeader['packaged'] !=0){
                                                      $total=$rowHeader['packaged']*${'total_'.$rowHeader['materials_abbv']};

                                                  echo '<td><b>'.$total.'</b></td>';
                                                  }else{
                                                    echo '<td><b>'.${'total_'.$rowHeader['materials_abbv']}.'</b></td>';
                                                  }
                                                  }
                                                  echo '</tr>';
                                                  echo '<tr><td colspan="3"><b>TOTAL STH Schools</b></td><td>'.$sth_schools.'</td>';
                                                  while($rowHeader=mysqli_fetch_assoc($resultHeader)){
                                                    echo '<td></td>';
                                                  }
                                                  echo '</tr><tr><td colspan="3"><b>TOTAL Schisto Schools</b></td><td><b>'.$schisto_schools.'</b></td>';
                                                  while($rowHeader=mysqli_fetch_assoc($resultHeader)){
                                                    echo '<td></td>';
                                                  }
                                                  echo '</tr><tr><td colspan="3"><b>Total Schools</b></td><td><b>'.$total_schools.'</b></td>';
                                                   while($rowHeader=mysqli_fetch_assoc($resultHeader)){
                                                    echo '<td></td>';
                                                  }
                                                  echo '</tr></table>';
                                                    mysqli_free_result($resultHeader);
                                                ?>
                                                </p>
                                    </div> 
                                 

                                  <?php
                                    }
                                    }
                                  ?>

                                </div>
                           </div>
                      </div>
      		</div>
  </body>
</html> 


<script>

      $(document).find("input.num-only").keydown(function (e) {
          // Allow: backspace, delete, tab, escape, enter and .
          if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
               // Allow: Ctrl+A
              (e.keyCode == 65 && e.ctrlKey === true) || 
               // Allow: home, end, left, right
              (e.keyCode >= 35 && e.keyCode <= 39)) {
                   // let it happen, don't do anything
                   return;
          }
          // Ensure that it is a number and stop the keypress
          if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
              e.preventDefault();
          }
      });
</script>
<?php
ob_flush();
?>
