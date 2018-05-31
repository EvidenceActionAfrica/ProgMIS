 <?php
 $disSelection=$_SESSION["district_selection"];//Extremely important:Do Not Touch
 if($disSelection !=null){
   ?>
<h3 align="center">Teacher Training Boxes</h3>
<table class="table table-bordered table-condensed table-striped table-hover">
  <tr><th>No</th><th>County</th><th>District</th><th>Divisions</th><th>STH Schools</th><th>SCHISTO Schools</th><th>Total Schools</th>
      <th>TTS Sessions</th>
    <!--  
    <th>TTS</th><th>TTB</th>
    <th>FormE</th><th>FormN</th><th>FormS</th><th>FormEP</th><th>FormNP</th><th>FormSP</th><th>ATTNT</th><th>ATTNC</th><th>Poster1</th><th>Poster2</th></tr>
  -->
        <?php {
            $mat_category="Teacher Training boxes";
            $sql="SELECT materials_abbv from materials_desc WHERE material_category='".$mat_category."'";
           
            $resultA=mysql_query($sql)or die(mysql_error());
            while($row=mysql_fetch_array($resultA)){
                echo "<th>".$row["materials_abbv"]."</th>";
            }
          
            
      $sql="SELECT DiSTINCT a.county_name,a.district_name FROM a_bysch as a,rollout_activity as r  where ";
      $max=sizeof($disSelection);
      $count=0;
      while($count<$max){
        if($count==0){
            $sql.="a.district_name='".$disSelection[$count]."'";
            $sql2="district_name='".$disSelection[$count]."'";
      
        }else{
         $sql.=" OR a.district_name='".$disSelection[$count]."'";
       $sql2.=" OR district_name='".$disSelection[$count]."'";
       
         
        }
         ++$count;
        
       }
              $sql.=" ORDER BY a.county_name";
   //    echo $sql;
        $result = mysql_query($sql);
         
    
    
   
    $indexcounter = 1;
    while ($row = mysql_fetch_array($result)) {
      $county_name = $row['county_name'];
      $district_name = $row['district_name'];
      
       $sql="SELECT * from divisions where district_name='".$district_name."'";
    //  echo $sql;
  $resultX=mysql_query($sql);
  
  $no_of_divisions=mysql_num_rows($resultX);
   //echo $no_of_divisions. " Divisions Found<br/>";
  
   
      $result1 = mysql_query("SELECT * FROM a_bysch WHERE ap_attached='No' AND district_name='$district_name'");
      $sth_schools=  mysql_num_rows($result1);
      
   
      $result2 = mysql_query("SELECT * FROM a_bysch WHERE ap_attached='Yes' AND district_name='$district_name'");
      $schisto_schools=  mysql_num_rows($result2);
  
      $total_schools = $schisto_schools + $sth_schools;
       $tts_sessions =ceil($total_schools/20);
      

  //Distinguishing similar variables with their respective id in the table materials:subject to change
    $resultA=mysql_query("Select * from materials_desc");
    while($key=mysql_fetch_array($resultA)){


  if ($key["materials_abbv"] == "ttb") {
    
    $ttbooklet_persch =$key["var1"];
    $ttboxes_ttbooklets = ($ttbooklet_persch * $total_schools) + ($key["var2"] * $tts_sessions);
     $ttboxes_ttbooklets=MROUND($ttboxes_ttbooklets,5);
    }

  if ($key["materials_abbv"] == "form_e") {
    $formE_perpacket =$key["var1"];
   $formE_persch=$key["var2"];
    $percent=($key["var5"]+100)/100;
     $formE_perdist = ceil((($formE_persch * $total_schools) + ($key["var3"] )) * $percent);
    
   
        if ( strpos( $formE_perdist, '.' ) === false ) {$formE_perdist=$formE_perdist;
        }else{$formE_perdist=ceil($formE_perdist);}  
       
        $formE_perdist=  MROUND($formE_perdist,20);
    }

  if ($key["materials_abbv"] == "form_n") {
  $formN_perpacket = $key["var1"];
   $formN_persch =$key["var2"];
     $percent=($key["var5"]+100)/100;
  //   echo $percent;
     $formN_perdist =(($formN_persch * $sth_schools) + ($key["var3"]) * $percent);
    
    
        if ( strpos( $formN_perdist, '.' ) === false ) {$formN_perdist=$formN_perdist;
        }else{$formN_perdist=ceil($formN_perdist);}  
        
     
     
}

  if ($key["materials_abbv"] == "form_s") {
     $formS_perpacket =$key["var1"];
     $formS_persch=$key["var2"];
      $formS_perdist = ($formS_persch * $sth_schools) + $key["var3"];
    
    }

  if ($key["materials_abbv"] == "form_ep") {
    
  $formEP_perpacket =$key["var1"];
   $formEP_persch =$key["var2"];
 $percent=($key["var5"]+100)/100;
 if ($schisto_schools != '0') {
        $formEP_perdist =($formEP_persch * $total_schools) + ($key["var3"]);
        $formEP_perdist=$formEP_perdist* $percent;
        //To detect a decimal.you must understand that a float is not a number but a string representation of a number
        //so this if will detect the dot before the decimal values
        
        if ( strpos( $formEP_perdist, '.' ) === false ) {$formEP_perdist=$formEP_perdist;
        }else{$formEP_perdist=ceil($formEP_perdist);}  
        
        $formEP_perdist=MROUND($formEP_perdist,20);
 } else if ($schisto_schools == '0') {
        $formEP_perdist = 0;
      }

    }
  if ($key["materials_abbv"] == "form_np") {
     $formNP_perpacket =$key["var1"];
     $formNP_persch =$key["var2"];
 $percent=($key["var5"]+100)/100;
     if ($schisto_schools != '0') {
        $formNP_perdist =((($formNP_persch * $schisto_schools) + ($key["var3"])) * $percent);
     
         if ( strpos( $formNP_perdist, '.' ) === false ) {
    $formNP_perdist=$formNP_perdist;
        }else{
            $formNP_perdist=ceil($formNP_perdist);
        }   

        
        
     } else if ($schisto_schools == '0') {
        $formNP_perdist = 0;
      }
    }
  if ($key["materials_abbv"] == "form_sp") {

      $formSP_perpacket =$key["var1"];
      $formSP_persch =$key["var2"];


      if ($schisto_schools != '0') {
        $formSP_perdist = ($formSP_persch * $schisto_schools) + $key["var3"];
      } else if ($schisto_schools == '0') {
        $formSP_perdist = 0;
      }
    }
 if ($key["materials_abbv"] == "ttrb") {
        $ttrb_perpacket=$key["var1"];
      $ttrb=$key["var2"];


    }

 if ($key["materials_abbv"] == "Poster_1_Date") {
     $percent=($key["var5"]+100)/100;
  $teachertb_poster1d_persch = $key["var1"];
  $teachertb_poster1d_perdist =($teachertb_poster1d_persch * $total_schools) * $percent;
  
  if ( strpos( $teachertb_poster1d_perdist, '.' ) === false ) {
    $teachertb_poster1d_perdist=$teachertb_poster1d_perdist;
}else{
    $teachertb_poster1d_perdist=ceil($teachertb_poster1d_perdist);
}     
$teachertb_poster1d_perdist=MROUND($teachertb_poster1d_perdist,5);
    }
    
 if ($key["materials_abbv"] == "poster_2_Behavior") {
      $percent=($key["var5"]+100)/100;
 $teachertb_poster2b_persch = $key["var1"];
 $teachertb_poster2b_perdist = (($teachertb_poster2b_persch * $total_schools) * $percent);
   
  if ( strpos( $teachertb_poster2b_perdist, '.' ) === false ) {
    $teachertb_poster2b_perdist=$teachertb_poster2b_perdist;
}else{
    $teachertb_poster2b_perdist=ceil($teachertb_poster2b_perdist);
}   
$teachertb_poster2b_perdist=MROUND($teachertb_poster2b_perdist, 5);
 
}


}

      $total_ttboxes_ttbooklets+=$ttboxes_ttbooklets;
    
      $total_formE_perdist+=$formE_perdist;
      $total_formE_docs = $total_formE_perdist * $formE_perpacket;

      $total_formN_perdist+=$formN_perdist;
      $total_formN_docs = $total_formN_perdist * $formN_perpacket;

       $total_formS_perdist+=$formS_perdist;
      $total_formS_docs = $total_formS_perdist * $formS_perpacket;

     
      $total_formEP_perdist+=$formEP_perdist;
      $total_formEP_docs = $total_formEP_perdist * $formEP_perpacket;

      
      $total_formNP_perdist+=$formNP_perdist;
      $total_formNP_docs = $total_formNP_perdist * $formNP_perpacket;

      $total_formSP_perdist+=$formSP_perdist;
      $total_formSP_docs = $total_formSP_perdist * $formSP_perpacket;

      
      $total_ttrb+=$ttrb;
      $total_ttrb_docs=$total_ttrb*$ttrb_perpacket;
      
      $total_teachertb_attnt+=$teachertb_attnt_perdist;
      $total_attnt_docs = $total_teachertb_attnt * $attnt_perpacket;

      $total_teachertb_attnc+=$teachertb_attnc_perdist;
      $total_attnc_docs = $total_teachertb_attnc * $attnc_perpacket;

      $total_teachertb_poster1d+=$teachertb_poster1d_perdist;
   
  
      $total_teachertb_poster2b+=$teachertb_poster2b_perdist;
      ?>
      <tr><td><?php echo $indexcounter; ?></td><td><?php echo $county_name; ?></td><td><?php echo $district_name; ?></td><td><?php echo $no_of_divisions; ?></td>
        <td><?php echo $sth_schools; ?></td><td><?php echo $schisto_schools; ?></td><td><?php echo $total_schools; ?></td><td><?php echo $tts_sessions; ?></td>
        <td><?php echo $ttboxes_ttbooklets; ?></td><td><?php echo $formE_perdist; ?></td><td><?php echo $formN_perdist; ?></td><td><?php echo $formS_perdist; ?></td>
        <td><?php echo $formEP_perdist; ?></td><td><?php echo $formNP_perdist; ?></td><td><?php echo $formSP_perdist; ?></td><td><?php echo $ttrb; ?></td>
        <td><?php echo $teachertb_poster1d_perdist; ?></td><td><?php echo $teachertb_poster2b_perdist; ?></td></tr>
      <?php
      $indexcounter++;
    }
  }
  ?>
  <tr><th colspan="9">Documents to Print</th><th><?php echo $total_formE_docs; ?></th><th><?php echo $total_formN_docs; ?></th>
    <th><?php echo $total_formS_docs; ?></th><th><?php echo $total_formEP_docs; ?></th><th><?php echo $total_formNP_docs; ?></th>
    <th><?php echo $total_formSP_docs; ?></th><th><?php echo $total_ttrb_docs; ?></th><th></th>
    <th></th></tr>
  <tr><th colspan="8">Units to Package</th><th><?php echo $total_ttboxes_ttbooklets; ?></th><th><?php echo $total_formE_perdist; ?></th>
    <th><?php echo $total_formN_perdist; ?></th><th><?php echo $total_formS_perdist; ?></th><th><?php echo $total_formEP_perdist; ?></th>
    <th><?php echo $total_formNP_perdist; ?></th><th><?php echo $total_formSP_perdist; ?></th><th><?php echo $total_ttrb; ?></th>
    <th><?php echo $total_teachertb_poster1d; ?></th><th><?php echo $total_teachertb_poster2b; ?></th></tr>
</table>
<?php
$total_rtb_posterA+=$total_teachertb_poster1d;
$total_rtb_posterB+=$total_teachertb_poster2b;
}else{

  echo "<h1 style='font-weight:bolder;'>Please Select the districts to generate the data From in the districts Selection.</h1>";
}
?>