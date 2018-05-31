<!-- Modal -->
<div id="myModal" class="col-md-8"  >
    <div >
        <div >
            <div>
                <h4 class="text-center" ><?php echo "Edit " . $tableName . ""; ?></h4>
                 
                    <?php if(isset($message)){ echo '<div  class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert">
  <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span class="text-center" >'.$message.'</span></div>';}?>
                    
            </div>
            <form  action="<?php echo URL; ?>uasettings/setPrivilege/<?php echo $staffId; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
 
                <div class="modal-body">
                   
                    <div class="row">
                 
                        <div class="col-md-12">
                            
                            <?php
                            $x = 0;
                            //  echo "<pre>";var_dump($single_record);echo "</pre>";
                            foreach ($fields as $key => $value) {
                                // echo "<pre>";var_dump($fields);echo "</pre>";
                                if ($value['Key'] == 'PRI') {
                                    if (!isset($single_record)) {
                                        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                    } else {
                                        echo '<input type="hidden" value="' . $single_record[$x] . '" value="" name="' . $value['Field'] . '"readonly/>';
                                    }
                                } else if ($value['Key'] == 'MUL') {
                                    // $disabled = 'style="display:none"';
                                    $disabled = 'enabled';
                                    if (isset($single_record)) {
                                       $selectedValue=$single_record[$x];
                                    }
                                    echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <select ' . $disabled . ' name="' . $value['Field'] . '" class="form-control input-sm" required>';
                                    foreach ($value['parents'] as $key => $value_) {
                                         if ($value_['id'] ==$selectedValue) {
                                            echo'<option  value="' . $value_['id'] . '" selected >' . $value_[$value['Field']] . '</option>';
                                        } else {
                                            echo'<option  value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                        }
                                    }
                                    echo '</select>
                                                </div>';
                                } else if (strpos($value['Field'], "priv_kenya") !== false  || strpos($value['Field'], "priv_malawi") !== false|| strpos($value['Field'], "priv_uganda") !== false) {
                                    if (!isset($single_record)) {
                                        echo '
                                                <div class="form-group">
                                                    <label>Found</label><br>
                                                    <input type="text" name="" class="form-control input-sm" value="' . date('d-m-Y') . '" readonly/>
                                                </div>
                                            ';
                                    } else {
                                        $label = $value['Field'];
                                        $label = str_replace("_", " ", $label);
                                        $label = ucwords($label);
                                        echo '
                                                <div class="form-group">
                                                    <label>' . $label . '</label><br/>
                                                    <select   name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                        echo '<option  value="0" ';
                                        if ($single_record[$x] == 0) {
                                            echo 'selected="selected"';
                                        }
                                        echo ' >0 - No Access</option>';

                                        echo '<option  value="1" ';
                                        if ($single_record[$x] == 1) {
                                            echo 'selected="selected"';
                                        }
                                        echo ' >1 - View</option>';
                                        echo '</select>';
                                    
                                    }
                                }else if (strpos($value['Field'], "priv") !== false) {
                                    if (!isset($single_record)) {
                                        echo '
                                                <div class="form-group">
                                                    <label>Found</label><br>
                                                    <input type="text" name="" class="form-control input-sm" value="' . date('d-m-Y') . '" readonly/>
                                                </div>
                                            ';
                                    } else {
                                        $label = str_replace("priv", " ", $value['Field']);
                                        $label = str_replace("_", " ", $label);
                                        $label = ucwords($label);
                                        echo '
                                                <div class="form-group">
                                                    <label>' . $label . '</label><br/>
                                                    <select   name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                        echo '<option  value="0" ';
                                        if ($single_record[$x] == 0) {
                                            echo 'selected="selected"';
                                        }
                                        echo ' >0 - No Access</option>';

                                        echo '<option  value="1" ';
                                        if ($single_record[$x] == 1) {
                                            echo 'selected="selected"';
                                        }
                                        echo ' >1 - View</option>';

                                        echo '<option  value="2" ';
                                        if ($single_record[$x] == 2) {
                                            echo 'selected="selected"';
                                        }
                                        echo ' >2 - View, Add</option>';

                                        echo '<option  value="3" ';
                                        if ($single_record[$x] == 3) {
                                            echo 'selected="selected"';
                                        }
                                        echo ' >3 - View, Add, Edit</option>';

                                        echo '<option  value="4" ';
                                        if ($single_record[$x] == 4) {
                                            echo 'selected="selected"';
                                        }
                                        echo ' >4 - View, Add, Edit, Delete</option>';

                                        echo '
                                                  </select>
                                                </div>
                                            ';
                                    }
                                } else if ($value['Field']== "password") {
                                    echo '
								            <div class="form-group">
								            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="password" id="' . $value['Field'] . '" name="' . $value['Field'] . '" value="' . $single_record[$x] . '" class="form-control input-sm" readonly/>
											</div>
                                    ';
                                } else {
                                    if (!isset($single_record)) {

                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                </div>
                                            ';
                                        continue;
                                    } else {

                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" value="' . $single_record[$x] . '"   name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                </div>
                                            ';
                                    }
                                }
                                $x++;
                            }
                            ?> 
                            
                        </div>
                  
                    </div>
                </div>
            <div class="col-md-offset-4 col-md-12">
                    <!-- this takes the user back to the previous page -->
                    <a href='<?php echo URL . "uasettings/index/" . $table ?>'>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </a>
                    <button  type="submit" class="btn btn-primary" name="update-uas-data" id="update-uas-data">Update Details</button>
                </div><br/>
            </form>
        </div>
    </div>
</div>  

<script type="text/javascript">
    window.onload = function() {
        $("#mymodal").show();
        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');

    };
</script>