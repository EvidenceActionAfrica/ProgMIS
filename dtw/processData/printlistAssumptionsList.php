	<form action="materials_general_assumptions.php" method="POST">
  

            <div id="data-table-container" style="max-height:650px; overflow:scroll;">
            <?php
             if(isset($materialResult)){
                echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>".$materialResult."</h3>";
                }
              ?>
             <?php if($priv_materials_assumptions>=2){ ?>
            <a href="materials_general_assumptions.php?tabActive=5" class="btn-custom-small" >Add Material</a>
            <br/> <br/>
           <?php }?>
  
        <div id="data-table-manger">
          <table class="data-table table table-bordered table-condensed table-striped table-hover" >
            <caption><h3><u>Materials & Their Assumptions</u></h3>
            </caption>
             <thead>
                  <tr>
                    <th>No</th>
                    <th>Assumptions</th>
                    <th>Formula Description</th>
                    <th>Assumption Description</th>
                    <th>Training Box</th>
                    <th>Packet</th>
                    <th>Packet Description</th>
                    
                    <?php if($priv_materials_assumptions>=3){ ?>
                    <th>Edit</th>
                     <?php } ?>

                     <?php if($priv_materials_assumptions>=4){ ?>
                    <th>Delete</th>
                     <?php } ?>
                  </tr>
            </thead>
          <tbody>
          <?php


            $counter=1;
            $sql="select * from materials_desc";
            $resultA=mysqli_query($db_mysqli_connection,$sql);
            while($key=mysqli_fetch_assoc($resultA)){
              $id=$key["id"];
              $materials=$key["materials"];
              $formula_desc=$key["formula_desc"];
              $material_description=$key["material_description"];
              $material_cat=$key["material_category"];
              $packet=$key["packet"];
              $packet_desc=$key["packet_desc"];
              
          ?>
          <tr><td><?php echo $counter; ?></td><td><?php echo $materials; ?></td><td><?php echo $formula_desc; ?></td>
            <td><?php echo $material_description; ?></td><td><?php echo $material_cat; ?></td>
            <td><?php echo $packet; ?></td>
            <td><?php echo $packet_desc; ?></td>
  <?php if($priv_materials_assumptions>=3){ ?>
            <td><a href="materials_general_assumptions.php?edit_material=<?php echo $id; ?>"><img src="../images/icons/edit2.png" height="20px"></a></td>
              <?php } ?>
        <?php if($priv_materials_assumptions>=4){ ?>
            <td><a onclick="deleteConfirm(<?php echo $id;?>)"><img src="../images/icons/delete.png" height="20px"></a></td>
              <?php } ?>
                    
            </tr>

          <?php  ++$counter; }

            mysqli_free_result($resultA);
           ?>
          </tbody>
      </table>
      </div>
            </div>
	  </form>
<script>
function deleteConfirm(deleteId){

 if (confirm("Are you sure you want to delete?")) {
          location.replace('?deleteMaterialId=' + deleteId);
      }else{
          return false;
      }
}
</script>  
