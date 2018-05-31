<?php
$type=isset($_POST['type'])?$_POST['type']:null;
$name=isset($_POST['name'])?$_POST['name']:'undefined';
$acronymn=isset($_POST['acronymn'])?$_POST['acronymn']:'undefined';
if(isset($_POST['type'])){
if($type==null){

}else if($type=='packet_category'){

  $sql='INSERT INTO `packet_category`(`packet`, `packet_desc`) VALUES ("'.$name.'","'.$acronymn.'")';
  mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
  $action='Packet '.$name.' has been Added.';
  $description='A Packet '.$name;
  $ArrayData = array($M_module, $action, $description);
  quickFuncLog($ArrayData);
}else if($type=='training_box_categories'){
  $sql='INSERT INTO `training_box_categories`(`name`, `acronymn`) VALUES ("'.$name.'","'.$acronymn.'")';
  mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
  $action='Training Box '.$name.' has been Added.';
  $description='A Training Box '.$name;
  $ArrayData = array($M_module, $action, $description);
  quickFuncLog($ArrayData);
}
$updateResult='Record Created';
}
?>
<div style='margin:0;padding:0;'>
  <h2 id="h2info"style="background:#bada66;text-align:center;"><?php if(isset($updateResult)){ echo $updateResult;$updateResult="";} ?></h2>
      <table style="">
       <tr>
       <td colspan="3" style="padding-left:10%;">
         <h3>ADD Training Box/Packet</h3>
        <form action="materials_general_assumptions.php" method="POST" style='width:100%;'>
            
        
            <div>
              <label for='name'>Name/Packet</label>
              <input type='text' name='name' value=''/> 
            </div> 
            
            <div>
              <label for='acronymn'>Acronmyn/Packet Description</label>
              <input type='text' name='acronymn' value=''/> 
            </div>
            <div>
                <label for='acronymn'>Type</label>
                <select name='type' required>
                    <option value='training_box_categories'>Training Box</option>
                    <option value='packet_category'>Packet</option>
                </select>
            </div>
            <?php  if($priv_materials_assumptions>=2){ ?>
            <div style='margin-top:5%;margin-left:-15%;'>
              <input  type='submit' name='submitCategory' class='btn-custom-small' value='Create'/>
            </div>
            <?php } ?>
        </form>
      </td>
      
       <td style="padding-left:10%;">
          <table  class="table table-bordered table-condensed table-striped table-hover" style='width:100%;'>
            <caption><b>Training Boxes Available</b></caption>
            <tr>
              <td>No</td>
              <td>Training Box</td>
              <td>Acronymn</td>
              <?php if($priv_materials_assumptions>=4){ ?>
              <td>Delete</td>
              <?php }?>
            </tr>
          <?php
           $counter=1;
            $sql='SELECT * from training_box_categories';
            $resultA=mysqli_query($db_mysqli_connection,$sql);
            while($tbRow=mysqli_fetch_assoc($resultA)){
              echo '<tr>';
              echo '<td>'.$counter.'</td>';
              echo '<td>'.$tbRow['name'].'</td>';
              echo '<td>'.$tbRow['acronymn'].'</td>';
             if($priv_materials_assumptions>=4){
              echo '<td><a href="materials_general_assumptions.php?deleteCategoryDef='.$tbRow["id"].'&table=training_box_categories" onclick="deleteCategory()" ><img src="../images/icons/delete.png" width="40px"></a></td>'; 
               }         
               echo '</tr>';
         ++$counter;
            }
            mysqli_free_result($resultA);
          ?>
          </table>
     </td>
     <td></td><td></td>
         <td style="padding-left:10%;">
            <table class="table table-bordered table-condensed table-striped table-hover" style='width:100%;'>
            <caption><b>Packets Available</b></caption>
              <tr>
                <td>No</td>
                <td>Packet Name</td>
                <td>Packet Description</td>
                <?php if($priv_materials_assumptions>=4){ ?>
                <td>Delete</td>
                <?php } ?>
              </tr>
            <?php
            $counter=1;
              $sql='SELECT * from packet_category';
              $resultA=mysqli_query($db_mysqli_connection,$sql);
              while($pkRow=mysqli_fetch_assoc($resultA)){
                echo '<tr>';
                echo '<td>'.$counter.'</td>';
                echo '<td>'.$pkRow['packet'].'</td>';
                echo '<td>'.$pkRow['packet_desc'].'</td>';
                if($priv_materials_assumptions>=4){
                     echo '<td><a href="materials_general_assumptions.php?deleteCategoryDef='.$pkRow["id"].'&table=packet_category" onclick="deleteCategory()" ><img src="../images/icons/delete.png" width="40px"></a></td>'; 
                 }      
                echo '</tr>';
                ++$counter;
              }
             mysqli_free_result($resultA);
            ?>
            </table>
        </td>
      </tr>
   </table>
</div>
