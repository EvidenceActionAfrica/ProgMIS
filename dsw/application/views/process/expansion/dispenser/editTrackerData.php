<!-- Modal -->
<div id="myModal" class="col-md-6 col-md-offset-3" >
    <div >
        <div >
            <div>
                <h4 class="text-center" ><?php echo "Edit " . $tableName . ""; ?></h4>
            </div>
            <form  action="<?php echo URL; ?>expansion/trackerDataUpdate/<?php echo $table.'/'.$edit ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">

                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $x = 0;
                            //  echo "<pre>";var_dump($single_record);echo "</pre>";
                            foreach ($fields as $key => $value) {
                                // echo "<pre>";var_dump($fields);echo "</pre>";
                                if ($value['Key'] == 'PRI' ) {
                                    if (!isset($single_record)) {
                                        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                    } else {
                                        echo '<input type="hidden" value="' . $single_record[$x] . '" value="" name="' . $value['Field'] . '"readonly/>';
                                    }
                                }else if ($value['Key'] == 'MUL' && $value['Field']=='country') {
                                    // $disabled = 'style="display:none"';
                                    $disabled = 'enabled';
                                    if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                    echo '
                                                <div class="form-group">
                                                     <input type="text" name="'.$value['Field'].'" value="'.$_SESSION['country'].'" hidden/>
                                                </div>';
                                }else if ($value['Key'] == 'MUL') {
                                    // $disabled = 'style="display:none"';
                                    $disabled = 'enabled';
                                    if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                    echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <select ' . $disabled . ' name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                    foreach ($value['parents'] as $key => $value_) {
                                        if ($value_['id'] == $selectedValue) {
                                            echo'<option  value="' . $value_['id'] . '" selected >' . $value_[$value['Field']] . '</option>';
                                        } else {
                                            echo'<option  value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                        }
                                    }
                                    echo '</select>
                                                </div>';
                                }else if ($value['Field'] == 'program') {
                                    if (!isset($single_record)) {
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="" class="form-control input-sm"  readonly/>
                                                </div>
                                            ';
                                    } else {
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" value="' . $single_record[$x] . '"  name="' . $value['Field'] . '" class="form-control input-sm" readonly/>
                                                </div>
                                            ';
                                    }
                                } else if ($value['Type'] == 'timestamp') {
                                    if (!isset($single_record)) {
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="" class="form-control input-sm" value="' . date('d-m-Y') . '" readonly/>
                                                </div>
                                            ';
                                    } else {
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" value="' . $single_record[$x] . '"  name="' . $value['Field'] . '" class="form-control input-sm" readonly/>
                                                </div>
                                            ';
                                    }
                                }else if (strpos($value['Field'], 'status') !== false) {
                                    if (!isset($single_record)) {
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <select name="' . $value['Field'] .'>
                                                        <option="Yes">Yes</option>
                                                        <option="No" selected>No</option>
                                                    </select>
                                                </div>
                                            ';
                                    } else {
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                     <select name="' . $value['Field'] .'" class="form-control input-sm">';

                                                     if($single_record[$x]=='YES' || $single_record[$x]=='Yes'){

                                              echo'     <option value="Yes" selected>Yes</option>
                                                        <option value="No">No</option>';
                                                }else{
                                                  echo'  <option value="Yes" >Yes</option>
                                                        <option value="No" selected>No</option>';
                                                }


                                              echo '          
                                                    </select>
                                                </div>
                                            ';
                                    }
                                }else if (strpos($value['Field'], 'time') !== false) {
                                    
                                    if (!isset($single_record)) {

                                            echo '
                                            <div class="form-group">
                                                <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <input type="time" name="' . $value['Field'] . '" class="form-control input-sm "  />
                                            </div>
                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm" value="' . $single_record[$x] . '"/>
                                                </div>
                                            ';
                                        }
                                        
                                    }else if (strpos($value['Field'], 'why_failed') !== false || strpos($value['Field'], 'comment') !== false) {
                                    
                                    if (!isset($single_record)) {

                                            echo '
                                            <div class="form-group">
                                                <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <textarea name="' . $value['Field'] . '" class="form-control input-sm "></textarea>
                                            </div>
                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <textarea name="' . $value['Field'] . '" class="form-control input-sm">'. $single_record[$x] . '</textarea>
                                                </div>
                                            ';
                                        }
                                        
                                    }else if (strpos($value['Field'], 'program') !== false) {
                                    
                                    if (!isset($single_record)) {

                                             echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           '; 
                                                                                           foreach ($programDropDown as $key => $value) {
                                                                                               echo '<option value="'.$value['program'].'">'.$value['program'].'</option>';
                                                                                           }

                                                                                    echo '</select>
                                                                    </div>
                                                                        
                                                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                   
                                                            <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           '; 
                                                                                           foreach ($programDropDown as $key => $value) {
                                                                                                if($single_record[$x]==$value['program']){
                                                                                                 echo '<option value="'.$value['program'].'" selected>'.$value['program'].'</option>';
                                                                                                }else{
                                                                                                  echo '<option value="'.$value['program'].'">'.$value['program'].'</option>';  
                                                                                                }
                                                                                               
                                                                                           }

                                                                                    echo '</select>


                                                </div>
                                            ';
                                        }
                                        
                                    }else if (strpos($value['Field'], 'csa_responsible') !== false) {
                                    
                                    if (!isset($single_record)) {

                                             echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           '; 
                                                                                           foreach ($staffDropDown as $key => $value2) {
                                                                                               echo '<option value="'.$value2['full_name'].'">'.$value2['full_name'].'</option>';
                                                                                           }

                                                                                    echo '</select>
                                                                    </div>
                                                                        
                                                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                   
                                                            <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           '; 
                                                                                           foreach ($staffDropDown as $key => $value2) {
                                                                                                if($single_record[$x]==$value2['full_name']){
                                                                                                 echo '<option value="'.$value2['full_name'].'" selected>'.$value2['full_name'].'</option>';
                                                                                                }else{
                                                                                                  echo '<option value="'.$value2['full_name'].'">'.$value2['full_name'].'</option>';  
                                                                                                }
                                                                                               
                                                                                           }

                                                                                    echo '</select>


                                                </div>
                                            ';
                                        }
                                        
                                    }else if (strpos($value['Field'], 'problems_with_installation') !== false) {
                                    
                                    if (!isset($single_record)) {

                                             echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                        <textarea name="'.$value['Field'].'"></textarea>
                                                                    </div>
                                                                        
                                                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <textarea name="'.$value['Field'].'">'.$single_record[$x].'</textarea>


                                                </div>
                                            ';
                                        }
                                        
                                    }else if (strpos($value['Field'], 'rescheduled_field_officer') !== false) {
                                    
                                    if (!isset($single_record)) {

                                             echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           '; 
                                                                                           echo '<option value="None">None</option>';
                                                                                           foreach ($staffDropDown as $key => $value2) {
                                                                                               echo '<option value="'.$value2['full_name'].'">'.$value2['full_name'].'</option>';
                                                                                           }

                                                                                    echo '</select>
                                                                    </div>
                                                                        
                                                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                   
                                                
                                                            <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           '; 
                                                                                            echo '<option value="None">None</option>';
                                                                                           foreach ($staffDropDown as $key => $value2) {
                                                                                                if($single_record[$x]==$value2['full_name']){
                                                                                                 echo '<option value="'.$value2['full_name'].'" selected>'.$value2['full_name'].'</option>';
                                                                                                }else{
                                                                                                  echo '<option value="'.$value2['full_name'].'">'.$value2['full_name'].'</option>';  
                                                                                                }
                                                                                               
                                                                                           }

                                                                                    echo '</select>


                                                </div>
                                            ';
                                        }
                                        
                                    }else if (strpos($value['Field'], 'field_officer') !== false) {
                                    
                                    if (!isset($single_record)) {

                                             echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           '; 
                                                                                           foreach ($staffDropDown as $key => $value2) {
                                                                                               echo '<option value="'.$value2['full_name'].'">'.$value2['full_name'].'</option>';
                                                                                           }

                                                                                    echo '</select>
                                                                    </div>
                                                                        
                                                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                   
                                                
                                                            <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           '; 
                                                                                           foreach ($staffDropDown as $key => $value2) {
                                                                                                if($single_record[$x]==$value2['full_name']){
                                                                                                 echo '<option value="'.$value2['full_name'].'" selected>'.$value2['full_name'].'</option>';
                                                                                                }else{
                                                                                                  echo '<option value="'.$value2['full_name'].'">'.$value2['full_name'].'</option>';  
                                                                                                }
                                                                                               
                                                                                           }

                                                                                    echo '</select>


                                                </div>
                                            ';
                                        }
                                        
                                    }else if (strpos($value['Field'], 'date') !== false) {
                                    
                                    if (!isset($single_record)) {

                                            echo '
                                            <div class="form-group">
                                                <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
                                            </div>
                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker" value="' . $single_record[$x] . '"/>
                                                </div>
                                            ';
                                        }
                                        
                                    }else {

                                    if (isset($single_record)) {
                                            echo '
								            <div class="form-group">
								            	<label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="text" name="' . $value['Field'] . '" value="' . $single_record[$x] . '" class="form-control input-sm"  />
											</div>
										';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" value="' . $single_record[$x] . '" class="form-control input-sm"/>
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
                <div class="col-md-offset-4">
                    <!-- this takes the user back to the previous page -->
                    <a href='<?php echo URL . "expansion/trackerData/".$table."/".$edit."/".$programName; ?>'>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </a>
                    <button type="submit" class="btn btn-primary" name="update-dInstall" id="update-dInstall-data">Update Details</button>
                </div>
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