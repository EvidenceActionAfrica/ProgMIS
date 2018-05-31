              
                <?php
                if(isset($_GET['editCategory'])){
                    $catId=$_GET['editCategory'];

                  ?>
                   <h2 style='background-color:#bada66;text-align:center;width:40%;margin-left:5%;'><?php echo $updateResult; ?></h2>
                 
                 <form action='materials_general_assumptions.php' method='POST' style='width:55%;padding:0;margin:0;'> 
                       <h2>Edit Printlist Category</h2>
                        <div style='width:20%;padding:0;margin:0;'>
                            <label for='category'>Category</label>
                            <select name='category'>
                                <?php
                                  $sql='SELECT * from materials_cat_organizer WHERE id='.$catId;
                                  $resultRow=mysqli_query($db_mysqli_connection,$sql);
                                  while($row=mysqli_fetch_assoc($resultRow)){
                                    echo '<option selected value="'.$row['category'].'">'.$row['category'].'</option>';

                                  }
                                  mysqli_free_result($resultRow);
                                
                                  $sql='SELECT * from training_box_categories';
                                  $resultRow=mysqli_query($db_mysqli_connection,$sql);
                                  while($row=mysqli_fetch_assoc($resultRow)){
                                    echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';

                                  }
                                  mysqli_free_result($resultRow);
                                  $sql='SELECT * from packet_category';
                                  $resultRow=mysqli_query($db_mysqli_connection,$sql);
                                  while($row=mysqli_fetch_assoc($resultRow)){
                                    echo '<option value="'.$row['packet'].'">'.$row['packet'].'</option>';

                                  }
                                  mysqli_free_result($resultRow);
                                ?>
                            </select>
                        </div>

                        <div style='width:20%;'>
                            <label for='tab'>Appearance On Tab</label>
                            <select name='tab'>
                              <?php
                                  $sql='SELECT tab_appearance from materials_cat_organizer WHERE id='.$catId;
                                  $resultRow=mysqli_query($db_mysqli_connection,$sql);
                                  while($row=mysqli_fetch_assoc($resultRow)){
                                     echo '<option selected value='.$row['tab_appearance'];
                                     echo '>';
                                     if($row['tab_appearance']==1){echo "Yes";}else{echo "No";}
                                     echo' </option>';

                                  }
                                  mysqli_free_result($resultRow);
                                ?>
                              <option value="1">Yes</option>
                              <option value="2">No</option> 
                            </select>
                        </div>
                        <div style='width:20%;'>
                            <label for='printlist'>Inclusion/Appearance in Print Order</label>
                            <select name='printlist'>
                              <?php
                                  $sql='SELECT printlist_appearance from materials_cat_organizer WHERE id='.$catId;
                                  $resultRow=mysqli_query($db_mysqli_connection,$sql);
                                  while($row=mysqli_fetch_assoc($resultRow)){
                                     echo '<option selected value='.$row['printlist_appearance'].'>';
                                     if($row['printlist_appearance']==1){echo "Yes";}else{echo "No";}
                                     echo' </option>';

                                  }
                                 mysqli_free_result($resultRow);
                                ?>
                              <option value="1">Yes</option>
                              <option value="2">No</option> 
                            </select>
                        </div>
                        <input type='hidden' readonly name='id' value='<?php echo $catId; ?>'/>
                        <br/>
                        <input type='submit' name='UpdateCat'  class='btn-custom' value='Update Printlist Category'/>
                    </form>
                <?php
                }else{
                ?>
                <div style='float:left;width:100%;'>
                  <table>
                    <tr>
                    <td>
                   <form method='POST' style='width:100%;'> 
                       <h2>Create New Printlist Category</h2>
                        <div style='width:20%;'>
                            <label for='category'>Category</label>
                            <select name='category'>
                                <?php
                                  $sql='SELECT * from training_box_categories';
                                  $resultRow=mysqli_query($db_mysqli_connection,$sql);
                                  while($row=mysqli_fetch_assoc($resultRow)){
                                    echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';

                                  }
                                    mysqli_free_result($resultRow);
                                    $sql='SELECT * from packet_category';
                                  $resultRow=mysqli_query($db_mysqli_connection,$sql);
                                  while($row=mysqli_fetch_assoc($resultRow)){
                                    echo '<option value="'.$row['packet'].'">'.$row['packet'].'</option>';

                                  }
                                    mysqli_free_result($resultRow);
                                ?>
                            </select>
                        </div>

                        <div style='width:20%;'>
                            <label for='tab'>Appearance On Tab</label>
                            <select name='tab'>
                              <option value="1">Yes</option>
                              <option selected value="2">No</option> 
                            </select>
                        </div>
                        <div style='width:20%;'>
                            <label for='printlist'>Inclusion/Appearance in Print Order</label>
                            <select name='printlist'>
                              <option value="1">Yes</option>
                              <option selected value="2">No</option> 
                            </select>
                        </div>

                        <br/>
                        <?php if($priv_materials_assumptions>=2){
                              echo " <input type='submit' name='printCat'  class='btn-custom' value='Create Printlist Category'/>";
                          }
                      ?>
                    </form>
                    </td>
                    <td>
                  <h2 style='background-color:#bada66;text-align:center;width:40%;margin-left:5%;'><?php echo $updateResult; ?></h2>
                    <table  class="table table-bordered table-condensed table-striped table-hover" style='margin-left:5%;width:100%;'>
                      <tr>
                        <th>Category</th>
                        <th>Appear<br/>On Printlist Tab</th>
                        <th>Appear<br/>On Print Order</th>
                         <?php if($priv_materials_assumptions>=3){?>
                        <th>Edit</th>
                        <?php }if($priv_materials_assumptions>=4){?>
                        <th>Delete</th>
                        <?php }?>
                      </tr>
                    
                        <?php
                        $sql='SELECT * from materials_cat_organizer';
                        $resultOrg=mysqli_query($db_mysqli_connection,$sql) or die(mysqli_error($db_mysqli_connection));
                        $acquiredCategories='';
                        while($row=mysqli_fetch_assoc($resultOrg)){
                          echo '<tr>';
                          echo '<td>'.$row['category'].'</td>';
                          if($row['tab_appearance']==1){
                          echo '<td>Yes</td>';
                        }else{
                            echo '<td>No</td>';
                        }
                         if($row['printlist_appearance']==1){
                          echo '<td>Yes</td>';
                        }else{
                            echo '<td>No</td>';
                        }
                         if($priv_materials_assumptions>=3){
                         echo '<td><a href="materials_general_assumptions.php?editCategory='.$row["id"].'"><img src="../images/icons/edit.png" width="40px"></a></td>'; 
                        }
                         if($priv_materials_assumptions>=4){
                         echo '<td><a href="materials_general_assumptions.php?deleteCategory='.$row["id"].'" onclick="deleteCategory('.$row["id"].')" ><img src="../images/icons/delete.png" width="40px"></a></td>'; 
                          }
                        echo '</tr>';
                          
                        }
                        mysqli_free_result($resultOrg);
                        ?>
                    </table>
                    </td>
                    </tr>
                    </table>
                </div>

                <?php

              }

              ?>
  <script>

  function deleteCategory(){

      if (confirm("Are you sure you want to Delete This Category?")) {
            return true;
          } else {
              this.setAttribute('href','');//It doesn't work
          }

  }


  </script>