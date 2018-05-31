<?php


                      // privileges check.DO NOT TOUCH
            $priv_email = $_SESSION['staff_email'];
            $resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
            while ($row = mysql_fetch_array($resPriv)) {
              $priv_materials_assumptions= $row['priv_materials_assumptions'];
            }
?>
	<form action="" method="POST">
          
          <table  class="table table-bordered table-condensed table-striped table-hover">
            <caption><h3><u>Materials & Assumptions</u></h3>
            </caption>
                <th>Id</th>
                <th>Assumptions</th>
                <th>Formula Description</th>
                <th>Assumption Description</th>
                <th>Training Box</th>
                <th>Packet</th>
               
          <?php



            $sql="select * from materials_desc";
            $resultA=mysql_query($sql);
            while($key=mysql_fetch_array($resultA)){
              $id=$key["id"];
              $materials=$key["materials"];
              $formula_desc=$key["formula_desc"];
              $material_description=$key["material_description"];
              $material_cat=$key["material_category"];
              $packet=$key["packet"];
          ?>
          <tr><td><?php echo $id; ?></td><td><?php echo $materials; ?></td><td><?php echo $formula_desc; ?></td>
            <td><?php echo $material_description; ?></td><td><?php echo $material_cat; ?></td>
            <td><?php echo $packet; ?></td>
  <?php if($priv_materials_assumptions>=3){ ?>
            <td><a href="materials_printlist.php?id=<?php echo $id; ?>#openModal"><img src="../images/icons/edit2.png" height="20px"></a></td>
              <?php } ?>
            </tr>

          <?php } ?>
      </table>
	  </form>
  
