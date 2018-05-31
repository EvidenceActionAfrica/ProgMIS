<?php
  $updateResult="";
  if(isset($_GET["materialsContentDelete"])){

    $deleteId=$_GET["materialsContentDelete"];
    $sql="DELETE FROM materials_packaging_history where id=".$deleteId;
    mysql_query($sql);
    $updateResult="County & Sub-County Box Details Deleted";
      $action="Packaging Details  of a Sub-County Deleted";
      $description=" Packaging Details of a particular Sub-County Deleted";
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData);
    }

    // privileges check.DO NOT TOUCH
    $priv_email = $_SESSION['staff_email'];
    $resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
    while ($row = mysql_fetch_array($resPriv)) {
      $priv_materials_edit= $row['priv_materials_edit'];
    }
?>
	<form action="" method="POST">
  <h2 id="h2info" class='text-center'style="background:#bada66;"><?php echo $updateResult; ?></h2>
    <?php
          
              $sql="select * from materials_printlist_history where status=1";

              $resultA=mysql_query($sql);
              while($row=mysql_fetch_array($resultA)){

                $printlistId=$row["id"];
               }

              $sql="select * from materials_packaging_history where printlist_id='$printlistId'";
              $resultA=mysql_query($sql);
              $numRows=mysql_affected_rows();
               $id=1;
               if($numRows>=1){
    ?>
         <a href="materials_packing.php?unpackVendor=1&tab=1" class="btn-custom" style="margin-left:40%;"/>Add/Remove Sub-County</a>
         <br/>
         <a href='materials_packing.php?printPdf=summary'><img src="../images/print.png" height="20px"> Print Packaging Summary</a><br/>
          <table  class="table table-bordered table-condensed table-striped table-hover">
            <caption><h3><u>Package Details</u></h3>
            </caption>
                <th>Id</th>
                <th>County</th>
                <th>Sub-County</th>
                <th>Total Boxes</th>
                <?php
                //Dynamic generation of columns depending on the types of training boxes available
                $sql='SELECT * from training_box_categories ORDER BY name ASC';
                $resultTB=mysql_query($sql);

                //The Array below will take the training box names to the tbody for the correct filter of box types to take place.
                $trainingBoxArray=array();
                while($rowTB=mysql_fetch_array($resultTB)){
                  echo '<th>'.$rowTB['name'].'</th>';
                  array_push($trainingBoxArray,$rowTB['acronymn']);
                }
                
                ?>
                <th>Status</th>
                
                <?php if($priv_materials_edit>=2){ ?>
                <th></th>
                <?php } ?>  
                <th>Box Ids</th>
                <?php if($priv_materials_edit>=4){ ?>
                <th>Delete</th>
               <?php } ?>     
          <?php
    
            while($row=mysql_fetch_array($resultA)){
                $packageId=$row["id"];
                $countyName=$row["countyName"];
                $districtName=$row["districtName"];
                $noBox=$row["noBox"];
                //This variable represents the total no.of boxes found to have been created for respective county & district.
               $totaltb=0;
               $boxType='';
               //This empties the variable that will take the results from searching individual. 
               //Counts of boxes types per county & district. All Box types will be represent by this variable.Check Below
                
                $allBoxIds='';
                //This is used to carry all the box ids to the table

                $link="materials_packing.php?printlistId=".urlencode($printlistId)."&countyName=".urlencode($countyName)."&districtName=".urlencode($districtName);
               //The Link Variable must be defined here so that the training box types can be redirected correctly
               //For Each Training Box type Found in the training_boxes_desc table we look for the boxes created REF:Columns above
                foreach ($trainingBoxArray as $key => $value) {
                  $sql='SELECT count(box_type) as '.$value.' from materials_packaging_history_data WHERE county_name="'.$countyName.'" AND district_name="'.$districtName.'" AND box_type="'.$value.'" AND printlist_id='.$printlistId;
                 // echo $sql;
                   $resultQ=mysql_query($sql);
                    while($row2=mysql_fetch_array($resultQ)){
                          $tb=isset($row2[$value])?$row2[$value]:0;
                          $totaltb+=$tb;
                     
                  }
                  $sqlBoxIds='Select box_id from materials_packaging_history_data WHERE county_name="'.$countyName.'" AND district_name="'.$districtName.'" AND box_type="'.$value.'" AND printlist_id='.$printlistId;
                    
                  $BoxIdResults=mysql_query($sqlBoxIds)or die(mysql_error().' Unable to Retrieve box Ids');
                  
                  while($boxIdRow=mysql_fetch_array($BoxIdResults)){
                        if($allBoxIds==''){
                            $allBoxIds.=$boxIdRow['box_id'];
                        }else{
                          $allBoxIds.=','.$boxIdRow['box_id'];
                        }
                      }


                  $boxType.='<td><a href="'.$link.'&tab=3&boxType='.$value.'">'.$tb.'</td>';
                }
                
                $deleteId=$row["id"];
                $diff=$noBox-$totaltb;
                if($diff==0){
                    $status="OK";
                }else if($diff>0){
                    $status="Missing Boxes";
                }else if($diff<0){
                    $status="Extra Boxes Found";
                }
                  ?>
                <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $countyName; ?></td>
                <td><?php echo $districtName; ?></td>
                <td><a href="<?php echo $link; ?>#editTotal"><?php echo $noBox; ?></a></td>
                <?php 
                  // This Will output all the box type values available.They will correspond to the no.of columns on top automatically.
                  echo $boxType;
                ?>
                  <td><?php echo $status; ?></td>
                   <?php if ($priv_materials_edit >= 2) { ?>
             <td> <a class="" style="text-decoration:none;"  href="<?php echo $link; ?>&tab=4">New Box</a></td>
                 <?php } ?>
                 <td><?php echo $allBoxIds; ?> </td>
                  <?php if($priv_materials_edit>=2){ ?>
               <td><a href="javascript:void(0)" onclick="show_confirm(<?php echo $deleteId; ?>)"><img src="../images/icons/delete.png" height="20px"/></a></td>
               <?php } ?>
                </tr>
                <?php
                 ++$id;
             } 
      }else{
        echo "<h2 style=\"background-color:#bada66;margin-left:20%;\" >No Packaging History Found for the Active Printorder & Vendor</h2>";
      }
        ?>
      </table>

       

	  </form>
  
<script>

 function show_confirm(deleteid) {
      if (confirm("Are you sure you want to delete?")) {
        location.replace('?materialsContentDelete=' + deleteid);
      } else {
        return false;
      }
    }
</script>
