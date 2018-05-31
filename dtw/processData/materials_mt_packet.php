 <?php
 $disSelection=$_SESSION["district_selection"];//Extremely important:Do Not Touch
 //print_r($disSelection);
 if($disSelection !=null){
   ?>
<h3 align="center">Master Trainers Packet (inside Sub-County Training Boxes)</h3>
<table  class="table table-bordered table-condensed table-striped table-hover">
<tr>
   <th>No</th><th>County</th><th>District</th>
   
  <?php
    $mat_category="Master Trainers Packet (inside Sub-County Training boxes)";
    $sql="Select * from materials_desc WHERE material_category='".$mat_category."'";
  //  echo $sql;
     $resultA=mysql_query($sql)or die(mysql_error());
    while($row=mysql_fetch_array($resultA)){
    echo "<th>".$row["materials_abbv"]."</th>";    
    }   
    ?>
</tr>
  <?php 

     $resultA=mysql_query($sql)or die(mysql_error());
    while($key=mysql_fetch_array($resultA)){
  /*converting data into variables work--investigate
        $materialNo="material".$counter;
        $materialNo=eval('return $'. $key["materials_abbv"] . ';');
        ++$counter;
        
         $materialNo=$key["var1"]."<br/>";
        
        */
if($key["materials_abbv"]=="AttscmoeDay1"){
      $attnr_moed1_perdist = $key["var1"];
    }

if($key["materials_abbv"]=="AttscmoeDay2"){
      $attnr_moed2_perdist = $key["var1"];
    }

if($key["materials_abbv"]=="AttscmohDay1"){
      $attnr_mohd1_perdist = $key["var1"];
    }
     
     
if($key["materials_abbv"]=="AttscmohDay2"){
      $attnr_mohd2_perdist = $key["var1"];
    }

if($key["materials_abbv"]=="form_mt"){
      $formMT_perdist = $key["var1"];
    }


    }


      $sql="SELECT DiSTINCT a.county_name,a.district_name FROM a_bysch as a,rollout_activity as r  where ";
      // $max=sizeof($disSelection);
      // $count=0;
      // while($count<$max){
      //   if($count==0){
      //       $sql.="a.district_name='".$disSelection[$count]."'";
      
      //   }else{
      //    $sql.=" OR a.district_name='".$disSelection[$count]."'";
      //  }
      //    ++$count;
        
      //  }

       foreach ($disSelection as $key => $value) {
          if($key==0){
              $sql.="a.district_name='".$value."'";        
          }else{
           $sql.=" OR a.district_name='".$value."'";
         }
       }
       $sql.="ORDER BY a.county_name";
  //     echo $sql;
        $result = mysql_query($sql);
      
   

//   $result = mysql_query("SELECT DiSTINCT a.county_name,a.district_name FROM a_bysch as a,rollout_activity as r  where a.district_name=r.activity_venu GROUP BY a.district_name ORDER BY a.county_name,a.district_name ASC");
  

  //  $result = mysql_query("SELECT county_name,district_name FROM a_bysch GROUP BY district_name ORDER BY county_name,district_name ASC");
    $no_of_districts = mysql_num_rows($result);
    $indexcounter = 1;
    while ($row = mysql_fetch_array($result)) {
      $county_name = $row['county_name'];
      $district_name = $row['district_name'];
      
      $attnrmoeday1 = $attnr_moed1_perdist;
      $total_attnrmoeday1+=$attnrmoeday1;
      $attnrmoeday2 = $attnr_moed2_perdist;
      $total_attnrmoeday2+=$attnrmoeday2;
      $attnrmohday1 = $attnr_mohd1_perdist;
      $total_attnrmohday1+=$attnrmohday1;
    
      $attnrmohday2 = $attnr_mohd2_perdist;
      $total_attnrmohday2+=$attnrmohday2;
      $formMT = $formMT_perdist;
      $total_formMT+=$formMT;
    
      ?>

      <tr bgcolor="#FFFFFF">
        <td><?php echo $indexcounter ?></td>
        <td><?php echo $county_name; ?></td>
        <td><?php echo $district_name; ?></td>
        <td><?php echo $attnrmoeday1; ?></td>
        <td><?php echo $attnrmoeday2; ?></td>
        <td><?php echo $attnrmohday1; ?></td>
        <td><?php echo $attnrmohday2; ?></td>
        <td><?php echo $formMT; ?></td>

      </tr>
    <?php
    $indexcounter++;
  }

?>
  <tr><th colspan="3">Units to Package</th><th><?php echo $total_attnrmoeday1 ?></th><th><?php echo $total_attnrmoeday2 ?></th><th><?php echo $total_attnrmohday1 ?></th><th><?php echo $total_attnrmohday2 ?></th><th><?php echo $total_formMT ?></th></tr>
</table>
<?php
}else{

  echo "<h1 style='font-weight:bolder;'>Please Select the Sub-County to generate the data From in the Sub-county Selection.</h1>";
}
?>