<?php

//For All 
if(isset($_GET["setAdminData"]) && $_GET["setAdminData"]==1){
    
    $sql="TRUNCATE table materials_officials_assumptions";
    mysqli_query($db_mysqli_connection,$sql);
    
    $sql="Select county,district_name from districts";
    $resultA= mysqli_query($db_mysqli_connection,$sql);
    
    while($row=mysqli_fetch_assoc($resultA)){
        $district=$row["district_name"];
        $county=$row["county"];
        $districtId=$row["district_id"];
        $countyId=$row["county_id"];
      
       $sql="select * from health_contacts where county='".$county."' AND district='".$district."' ";
                     // echo $sql;
                       $resultC=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
                        $actualHealthContacts=mysqli_affected_rows($db_mysqli_connection);
                        $actualDiv=$actualHealthContacts*2;   
      
          $sql="select * from education_contacts where county='".$county."' AND district='".$district."' ";
                     // echo $sql;
                       $resultC=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
                        $actualEducationContacts=mysqli_affected_rows($db_mysqli_connection);
                        $actualEducationDiv=$actualEducationContacts*2;                
                            
        $sql="select * from rollout_master_trainers where district='".$district."'";
                     // echo $sql;
                       $resultD=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
                        $masterContacts=mysqli_affected_rows($db_mysqli_connection);
                        
               
        
        $sql="INSERT INTO `materials_officials_assumptions`( `district_name`, `district_id`, `county`, `county_id`,";
        $sql.="`district_health_contacts`, `district_education_contacts`, `master_trainers`, `division_health_contacts`,";
        $sql.="`division_education_contacts`) ";
        $sql.="VALUES ('$district','$districtId','$county','$countyId','$actualHealthContacts','$actualEducationContacts','$masterContacts','$actualDiv','$actualEducationDiv')";
    
        mysqli_query($db_mysqli_connection,$sql) or die("Error entering admin/rollout data ".mysqli_error($db_mysqli_connection));
    }
    mysqli_free_result($resultA);
    
    $_GET["setAdminData"]="";
    $action="Set Admin Module Officials count";
    $description="All The sum(s) of Officials of each sub-county from the admin module have been saved into the assumptions";
    $ArrayData = array($M_module, $action, $description);
    quickFuncLog($ArrayData);
}

if(isset($_POST["setOfficials"])){
    
     $district_health_contacts = isset($_POST["district_health_contacts"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["district_health_contacts"]):0;
     $district_education_contacts =isset($_POST["district_education_contacts"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["district_education_contacts"]):0;
     $division_health_contacts = isset($_POST["division_health_contacts"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["division_health_contacts"]):0;
     $division_education_contacts =isset($_POST["division_education_contacts"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["division_education_contacts"]):0;
     $master_trainers = isset($_POST["master_trainers"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["master_trainers"]):0;
      
         
    $sql="TRUNCATE table materials_officials_assumptions";
    mysqli_query($db_mysqli_connection,$sql);
    
    $sql="Select county,district_name from districts";
    $resultA= mysqli_query($db_mysqli_connection,$sql);
    
    while($row=mysqli_fetch_assoc($resultA)){
        $district=$row["district_name"];
        $county=$row["county"];
        $districtId=$row["district_id"];
        $countyId=$row["county_id"];
    
        
           
        $sql="INSERT INTO `materials_officials_assumptions`( `district_name`, `district_id`, `county`, `county_id`,";
        $sql.="`district_health_contacts`, `district_education_contacts`, `master_trainers`, `division_health_contacts`,";
        $sql.="`division_education_contacts`) ";
        $sql.="VALUES ('$district','$districtId','$county','$countyId','$district_health_contacts','$district_education_contacts','$master_trainers','$division_health_contacts','$division_education_contacts')";
    
        mysqli_query($db_mysqli_connection,$sql) or die(mysqli_error($db_mysqli_connection));
     
        
        
        
    } 
        
      $action="User Set Default values for Officials count";
    $description="All The Defaults have been saved into the assumptions";
    $ArrayData = array($M_module, $action, $description);
    quickFuncLog($ArrayData);  
    
}

 if(isset($_GET["updateDefaults"])){

        $updateId=$_GET["updateDefaults"];
                       $sql="SELECT * from materials_officials_assumptions WHERE id='".$updateId."'";
                   $resultA=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
                   while($row=mysqli_fetch_assoc($resultA)){
                       $county=$row["county"];
                       $district=$row["district_name"];
                     }
                     mysqli_free_result($resultA);
                  $sql="select * from health_contacts where county='".$county."' AND district='".$district."' ";
                     // echo $sql;
                       $resultC=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
                        $actualHealthContacts=mysqli_affected_rows($db_mysqli_connection);
                        mysqli_free_result($resultC);
                        $actualDiv=$actualHealthContacts*2;
                       $sql="select * from education_contacts where county='".$county."' AND district='".$district."' ";
                     // echo $sql;
                       $resultC=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
                        $actualEducationContacts=mysqli_affected_rows($db_mysqli_connection);
                        $actualEducationDiv=$actualEducationContacts*2;
                        mysqli_free_result($resultC);
                  $sql="select * from rollout_master_trainers where district='".$district."'";
                     // echo $sql;
                       $resultD=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
                        $masterContacts=mysqli_affected_rows($db_mysqli_connection);
                        mysqli_free_result($resultD);


                    $sql="UPDATE `materials_officials_assumptions` SET `district_health_contacts`='$actualHealthContacts',`district_education_contacts`='$actualDiv',";
                    $sql.="`master_trainers`='$masterContacts',`division_health_contacts`='$actualDiv',`division_education_contacts`='$actualEducationContacts' WHERE id='".$updateId."'";
                    //echo $sql;
                    mysqli_query($db_mysqli_connection,$sql) or die(mysqli_error($db_mysqli_connection));

                    $action="User Set Default values for A specific subcounty";
                    $description="The Default values for the sub-county ".$district." have been saved into the assumptions";
                    $ArrayData = array($M_module, $action, $description);
                    quickFuncLog($ArrayData);  

 }
 
?>
 
            <div>
                <?php if($priv_materials_assumptions>=3){?>
                <a href="materials_general_assumptions.php?setAdminData=1" class="btn-custom-small" >Set All from Admin Data</a> &nbsp;  &nbsp; <a href="materials_general_assumptions.php?Identity=1#openDefaults" class="btn-custom-small" >Set Default For All</a><br/>
                <?php } ?>
                <table class="data-table table table-bordered table-condensed table-striped table-hover"> 
                <thead>
                       <tr>
                           <th>Id</th>
                           <th>County</th>
                           <th>Sub-County</th>
                           <th colspan="2">Health Officials</th>
                           <th colspan="2">Education Officials</th>
                           <th>Master Trainers</th>
                            <?php if($priv_materials_assumptions>=3){ ?>
                           <th>Edit</th>
                            <?php } ?> 
                           <th>Set <br/> From Admin</th>
                       </tr>
                       <tr>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th>Sub-County</th>
                           <th>Division</th>
                           <th>Sub-County</th>
                           <th>Division</th>
                            <th></th>
                           <th></th>
                           <th></th>
                       </tr>
                </thead>  
                       <?php
                   $sql="SELECT * from materials_officials_assumptions ORDER BY id";
                   $resultA=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
                   while($row=mysqli_fetch_assoc($resultA)){
                       $county=$row["county"];
                       $district=$row["district_name"];
                       $district_health_contacts=$row["district_health_contacts"];
                       $district_education_contacts=$row["district_education_contacts"];
                       $division_health_contacts=$row["division_health_contacts"];
                       $division_education_contacts=$row["division_education_contacts"];
                       $master_trainers=$row["master_trainers"];

                  $sql="select * from health_contacts where county='".$county."' AND district='".$district."' ";
                     // echo $sql;
                       $resultC=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
                        $actualHealthContacts=mysqli_affected_rows($db_mysqli_connection);
                        $actualDiv=$actualHealthContacts*2;
                       mysqli_free_result($resultC);
                       $sql="select * from education_contacts where county='".$county."' AND district='".$district."' ";
                     // echo $sql;
                       $resultC=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
                        $actualEducationContacts=mysqli_affected_rows($db_mysqli_connection);
                        $actualEducationDiv=$actualEducationContacts*2;
                        mysqli_free_result($resultC);    
                        $sql="select * from rollout_master_trainers where district='".$district."'";
                        // echo $sql;
                       $resultD=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
                        $masterContacts=mysqli_affected_rows($db_mysqli_connection);
                        
                         mysqli_free_result($resultD);


                   ?>
                       <tr>
                           <td><?php echo $row["id"]; ?></td>
                           <td><?php echo $county; ?></td>
                           <td><?php echo $district; ?></td>
                           <td><?php echo $district_health_contacts."  <span style='color:rgb(255,0,0)'>Admin: ".$actualHealthContacts." </span>"; ?></td>
                           <td><?php echo $division_health_contacts." <span style='color:rgb(255,0,0)'> Admin: ".$actualDiv."</span> " ?></td>
                           <td><?php echo $district_education_contacts."  <span style='color:rgb(255,0,0)'>Admin: ".$actualEducationContacts." </span>"; ?></td>
                           <td><?php echo $division_education_contacts."  <span style='color:rgb(255,0,0)'>Admin: ".$actualEducationDiv." </span>"; ?></td>
                    
                           <td><?php echo $master_trainers."  <span style='color:rgb(255,0,0)'>Admin: ".$masterContacts." </span>"; ?></td>
                           
                            <?php if($priv_materials_assumptions>=3){ ?>
                           <td><a href=<?php echo "materials_general_assumptions.php?Identity=".$row["id"]."#openModal" ?>><img src="../images/icons/edit2.png" height="20px"/></a></td>
                       
                            <?php } ?>
                       
                       <td><a onclick="updateDefaults(<?php echo $row['id'] ?>)"><img src="../images/icons/Admin.png" height="20px"/></a></td>
                       
                       </tr>
                       
                       
                       
                       
                   <?php } 
                         mysqli_free_result($resultA);
                   ?>
                    
                   </table>
            </div>
    <script>
      function updateDefaults(deleteid) {
        if (confirm("Are you Sure you want to Set The Actual Officials count?")) {
          location.replace('?updateDefaults=' + deleteid);
        } else {
          return false;
        }
      }
    </script>
