<?php
$disSelection = $_SESSION["district_selection"]; //Extremely important:Do Not Touch
if ($disSelection != null) {
    ?>
    <h3 align="center">Sub-County Training Boxes</h3>
    <table class="table table-bordered table-condensed table-striped table-hover">
        <tr><th>No</th><th>County</th><th>Sub-County</th>
            
            
            <!---
            <th>DTB</th><th>DC Packet</th><th>CSS</th><th>Poster 1</th><th>Poster 2</th><th>GDLM</th><th>TTK</th><th>DPHO</th><th>CSS</th><th>Poster 1</th><th>Poster 2</th><th>STA</th>
            <th>HFD</th><th>TTB</th><th>FormA</th><th>FormAP</th><th>Poster1</th><th>Poster2</th></tr>
            -->
    <?php {
            $mat_category="Sub-County Training boxes";
            $sql="SELECT materials_abbv from materials_desc WHERE material_category='".$mat_category."'";
           
            $resultA=mysql_query($sql)or die(mysql_error());
            while($row=mysql_fetch_array($resultA)){
                echo "<th>".$row["materials_abbv"]."</th>";
            }
     
     

            $sql = "SELECT DiSTINCT a.county_name,a.district_name FROM a_bysch as a,rollout_activity as r  where ";
            /*
              $max=sizeof($disSelection);
              $count=0;
              while($count<$max){
              if($count==0){
              $sql.="a.district_name='".$disSelection[$count]."'";

              }else{
              $sql.=" OR a.district_name='".$disSelection[$count]."'";
              }
              ++$count;

              }
             */


            foreach ($disSelection as $key => $value) {
                if ($key == 0) {
                    $sql.="a.district_name='" . $value . "'";
                    $sql2 = "district_name='" . $value . "'"; //For Divisions 
                } else {
                    $sql.=" OR a.district_name='" . $value . "'";
                    $sql2.=" OR district_name='" . $value . "'"; //For Divisions
                }
            }


            $sql.=" ORDER BY a.county_name";


            // echo $sql;
            $result = mysql_query($sql);


            $no_of_districts = mysql_num_rows($result);


            $indexcounter = 1;
            while ($row = mysql_fetch_array($result)) {
                $county_name = $row['county_name'];
                $district_name = $row['district_name'];

                $sql = "SELECT * from divisions where district_name='" . $district_name . "'";

                $resultX = mysql_query($sql);

                $no_of_divisions = mysql_num_rows($resultX);



                $result1 = mysql_query("SELECT COUNT(a_school_name) FROM a_bysch WHERE district_name='$district_name' AND ap_attached='No'");
                while ($row1 = mysql_fetch_array($result1)) {
                    $sth_schools = $row1['COUNT(a_school_name)'];
                }
                $result2 = mysql_query("SELECT COUNT(ap_school_name) FROM a_bysch WHERE district_name='$district_name' AND ap_attached='Yes'");
                while ($row2 = mysql_fetch_array($result2)) {
                    $schisto_schools = $row2['COUNT(ap_school_name)'];
                }
                $result3 = mysql_query("SELECT COUNT(school_id) FROM a_bysch WHERE district_name='$district_name'");
                while ($row3 = mysql_fetch_array($result3)) {
                    $total_schools = $row3['COUNT(school_id)'];
                }
                $sql = "SELECT * FROM materials_officials_assumptions WHERE district_name='$district_name'";
                $result4 = mysql_query($sql) or die(mysql_error());
                //echo $sql;
                while ($row4 = mysql_fetch_array($result4)) {
                    $dist_moe_officials = $row4['district_education_contacts'];
                    $div_moe_officials = $row4['division_education_contacts'];
                    //    echo "district MOE officials". $dist_moe_officials."<br/>";
                    //  echo "div MOE officials". $div_moe_officials."<br/>";
                }
                $result5 = mysql_query("SELECT * FROM materials_officials_assumptions WHERE district_name='$district_name'");
                while ($row5 = mysql_fetch_array($result5)) {
                    $dist_moh_officials = $row5['district_health_contacts'];
                    $div_moh_officials = $row5['division_health_contacts'];

                    //   echo "district moh".$dist_moh_officials."<br/>";
                    //  echo "div moh officials".$div_moh_officials."<br/>";
                }
                $result6 = mysql_query("SELECT * FROM materials_officials_assumptions WHERE district_name='$district_name'") or die(mysql_error());
                while ($row6 = mysql_fetch_assoc($result6)) {
                    $mts = $row6["master_trainers"];
                    //     echo "Master Trainers ".$mts."<br/>";
                }

                $result7 = mysql_query("SELECT COUNT(district_name) FROM a_bysch WHERE district_name='$district_name' AND ap_attached='Yes'");
                while ($row7 = mysql_fetch_array($result7)) {
                    $schisto_district = $row7['COUNT(district_name)'];
                }


                //Distinguishing similar variables with basic unit of measurement in the table materials:subject to change
                $resultA = mysql_query("Select * from materials_desc");
                while ($key = mysql_fetch_array($resultA)) {

                 
                   
                    if ($key["materials_abbv"] == "css") {
                        $css_persub_county = $key["var1"];
                    }

                    if ($key["materials_abbv"] == "SCMOH_Poster_1") {
                        $poster1_sub_county = $key["var1"];
                    }


                    if ($key["materials_abbv"] == "SCMOH_Poster_1") {
                        $poster2_sub_county = $key["var1"];
                    }

                    if ($key["materials_abbv"] == "attnc") {
                        
                        $attnc=$key["var1"];
                    }
                    
                    if ($key["materials_abbv"] == "sae") {
                        
                        $sae=$key["var1"];
                    }
                     if ($key["materials_abbv"] == "flip_chart") {
                        
                        $flip_chart=$key["var1"];
                    }
                    if ($key["materials_abbv"] == "sctb") {
                        $percent = ($key["var5"] + 100) / 100;
                        $sctb_persub_county =((1 * ($dist_moe_officials + $div_moe_officials + $dist_moh_officials + $div_moh_officials + $mts)) * $percent);
                    
                        
                        if ( strpos( $sctb_persub_county, '.' ) === false ) {$sctb_persub_county=$sctb_persub_county;
                        }else{$sctb_persub_county=ceil($sctb_persub_county);}  

                    }
                      if ($key["materials_abbv"] == "ttb") {
                        $percent = ($key["var5"] + 100) / 100;

                        $ttb = ((1 * ($dist_moe_officials + $div_moe_officials + $dist_moh_officials + $div_moh_officials + $mts)) * $percent);
                    
                               if ( strpos( $ttb, '.' ) === false ) {$ttb=$ttb;
                        }else{$ttb=ceil($ttb);}  
                    }
                     if ($key["materials_abbv"] == "hfd") {
                        $hfd = ($key["var1"] * ($dist_moe_officials + $div_moe_officials + $dist_moh_officials + $div_moh_officials + $mts));
                  
                        }
                     if ($key["materials_abbv"] == "gsclm") {
                        $gsclm = $key["var1"];
                    }

                     if ($key["materials_abbv"] == "ttk") {
                        $ttk = $key["var1"];
                    }
                    
                     if ($key["materials_abbv"] == "form_a") {
                        
                        if ($schisto_district == '0') {
                         
                         $forma = $key["var1"] * $no_of_divisions + $key["extra"];
                        }else{
                            $forma=0;
                        }
                        
                     }
       
                  
                 
                     if ($key["materials_abbv"] == "form_ap") {
                 
                        if ($schisto_district != '0') {
                            $formAP = $key["var1"] * $no_of_divisions + $key["extra"];
                        } else if ($schisto_district == '0') {
                            $formAP = 0;
                        }
                    }
                      if ($key["materials_abbv"] == "Poster_1") {
                       $poster1 = $key["var1"];
                    }
                        if ($key["materials_abbv"] == "Poster_2") {
                 
                        $poster2 = $key["var1"];
                    }
                }

               
                $total_css_persub_county+=$css_persub_county;
                $total_poster1_sub_county+=$poster1_sub_county;
                $total_poster2_sub_county+=$poster2_sub_county;
                
                $total_attnc+=$attnc;
                $total_sae+=$sae;
                $total_flip_chart+=$flip_chart;
                $total_sctb_persub_county+=$sctb_persub_county;//sctb
                $total_ttb+=$ttb;
                $total_hfd+=$hfd;
                $total_gsclm+=$gsclm;
                $total_ttk+=$ttk;
                $total_forma+=$forma;
                $total_poster1+=$poster1;
                $total_poster2+=$poster2;
                $total_formAP+=$formAP;
                
                
                ?>



                <tr bgcolor="#FFFFFF">
                    <td><?php echo $indexcounter ?></td>
                    <td><?php echo $county_name; ?></td>
                    <td><?php echo $district_name; ?></td>
                  
                    <td><?php echo $css_persub_county; ?></td>
                    <td><?php echo $poster1_sub_county; ?></td>
                    <td><?php echo $poster2_sub_county; ?></td>
                    <td><?php echo $attnc; ?></td>
                    <td><?php echo $sae; ?></td>
                    <td><?php echo $flip_chart; ?></td>
                    <td><?php echo $sctb_persub_county; ?></td>
                    <td><?php echo $ttb; ?></td>
                    <td><?php echo $hfd; ?></td>
                    <td><?php echo $gsclm; ?></td>
                    <td><?php echo $ttk; ?></td>
                    
                    <td><?php echo $forma; ?></td>
                    <td><?php echo $formAP; ?></td>
                    <td><?php echo $poster1; ?></td>
                    <td><?php echo $poster2; ?></td>
                   </tr>
                <?php
                $indexcounter++;
            }
        }
        ?>
        <tr><th colspan="3">Units to Package</th>
            <th><?php echo $total_css_persub_county; ?></th><th><?php echo $total_poster1_sub_county; ?></th><th><?php echo $total_poster2_sub_county; ?></th>
            <th><?php echo $total_attnc; ?></th><th><?php echo $total_sae; ?></th><th><?php echo $total_flip_chart; ?></th><th><?php echo $total_sctb_persub_county; ?></th>
            <th><?php echo $total_ttb; ?></th><th><?php echo $total_hfd; ?></th><th><?php echo $total_gsclm; ?></th><th><?php echo $total_ttk ?></th><th><?php echo $total_forma ?></th>
            <th><?php echo $total_formAP ?></th>
            <th><?php echo $total_poster1 ?></th><th><?php echo $total_poster2 ?></th></tr>
    </table>
    <?php
             $total_posterA=$total_poster1+$total_poster1_sub_county+$total_poster1_div;
                $total_posterB=$total_poster2+$total_poster2_sub_county+$total_poster1_div;
                
} else {

    echo "<h1 style='font-weight:bolder;'>Please Select the districts to generate the data From in the districts Selection.</h1>";
}
?>