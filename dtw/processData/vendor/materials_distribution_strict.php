<?php
$updateResult="";
  if(isset($_GET["materialsContentDelete"])){

    $deleteId=$_GET["materialsContentDelete"];
    $sql="DELETE FROM materials_packaging_history where id=".$deleteId;
    mysql_query($sql);
    $updateResult="District Deleted";

  }
$priv_materials_edit=4;



?>
	<form action="" method="POST">
  <h2 id="h2info"style="background:#bada66;"><?php echo $updateResult;  ?></h2>
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
          <table  class="table table-bordered table-condensed table-striped table-hover">
            <caption><h3><u>Materials Distribution</u></h3>
            </caption>
                <th>Id</th>
                <th>County</th>
                <th>District</th>
                <th>Total Boxes</th>
                <th>District <br/>Training Boxes</th>
                <th>Teacher <br/>Training Boxes</th>
                <th>Status</th>
                    <?php if($priv_materials_edit>=1){ ?>
                <th>Summary<br/>Print Preview</th>
                <?php }if($priv_materials_edit>=4){ ?>
                <th>Delete</th>
               <?php } ?>     
          <?php
    
            while($row=mysql_fetch_array($resultA)){
                $packageId=$row["id"];
                $countyName=$row["countyName"];
                $districtName=$row["districtName"];
                $noBox=$row["noBox"];
                $dtb=$row["dtb"];
                $ttb=$row["ttb"];
                $deleteId=$row["id"];
                $diff=$noBox-($dtb+$ttb);
                if($diff==0){
                    $status="OK";
                }else if($diff>0){
                    $status="Missing Boxes";
                }else if($diff<0){
                    $status="Extra Boxes Found";
                }

$link="materials_packing_strict.php?printlistId=".$printlistId." &countyName=".$countyName." &districtName=".$districtName;
          ?>
              
           <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $countyName; ?></td>
            <td><?php echo $districtName; ?></td>
            <td><a href="<?php echo $link; ?>#editTotal"><?php echo $noBox; ?></a></td>
            <td><a href="<?php echo $link; ?>&tab=3"><?php echo $dtb; ?></a></td>
            <td><a href="<?php echo $link; ?>&tab=4"><?php echo $ttb; ?></a></td>
            <td><?php echo $status; ?></td>
            <?php if($priv_materials_edit>=1){ ?>
            <td><a target="blank" href="<?php echo $link."&pdfView=".$packageId; ?>"><img src="../images/icons/view.png" height="20px"></a></td>
          <?php }if($priv_materials_edit>=2){ ?>
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
