<!-- Modal -->
<div id="myModal" class="col-md-6 col-md-offset-3" >
    <div >
        <div >
            <div>
                <h4 class="text-center" ><?php echo "Add " . $tableName . ""; ?></h4>
            </div>
            <form  action="<?php echo URL; ?>processdata/callupdate/promoter_call_log/<?php echo $promoterId; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
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
                                } else if ($value['Key'] == 'MUL' && $value['Field']=="position" ) {
                                    // $disabled = 'style="display:none"';
                                    //$disabled = 'enabled';
                                    
                                    echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <select name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                    foreach ($value['parents'] as $key => $value_) {
                                        if ($value_['id'] == $_SESSION["position"]) {
                                            echo'<option  value="' . $value_['id'] . '" selected >' . $value_[$value['Field']] . '</option>';
                                        } else if ($value_['id'] == $_SESSION['position'] && $value_[$value['Field']]==$_SESSION['positionName']){
                                            echo'<option  value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                        }else {
                                            echo'<option  value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                        }
                                    }
                                    echo '</select>
                                                </div>';
                                }else if ($value['Key'] == 'MUL'  && $value['Field']=='country') {
                                    // $disabled = 'style="display:none"';
                                    //$disabled = 'enabled';
                                    if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                    echo '       <input type="hidden" name="' . $value['Field'] . '"  class="form-control input-sm" value="' . $_SESSION['country']. '" readonly/>
                                             ';
                                }else if ($value['Key'] == 'MUL') {
                                    // $disabled = 'style="display:none"';
                                    //$disabled = 'enabled';
                                    if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                    echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <select name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                    foreach ($value['parents'] as $key => $value_) {
                                        if ($value_['id'] == $selectedValue) {
                                            echo'<option  value="' . $value_['id'] . '" selected >' . $value_[$value['Field']] . '</option>';
                                        } else {
                                            echo'<option  value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                        }
                                    }
                                    echo '</select>
                                                </div>';
                                } else if ($value['Type'] == 'timestamp') {
                                    if (!isset($single_record)) {
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm" value="' . date('d-m-Y') . '" readonly/>
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
                                } else if ($value['Field'] == 'call_to_or_from') {
                                   
                                        echo '
                                                <div class="form-group">
                                                    <label> ' . ucwords(str_replace('_', ' ', 'Call_to/from')) . '</label><br>
                                                
                                                    
                                                            <input name="' . $value['Field'] . '" type="radio" value="Main Promoter">Main Promoter</input><br/>
                                                            <input name="' . $value['Field'] . '" type="radio" value="Assistant Promoter">Assistant Promoter</input>
                                                            
                                                        
                                                
                                                </div>
                                            ';
                                     
                                }else if ($value['Field'] == 'last_call') {
                                   
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                
                                                        <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                            <option value="Outgoing">Outgoing</option>
                                                            <option value="Incoming">Incoming</option>
                                                            
                                                        </select>
                                                
                                                </div>
                                            ';
                                     
                                }else if ($value['Field'] == 'promoter_name') {
                                   
                                        echo '
                                              
                                                    <input type="hidden" name="' . $value['Field'] . '" class="form-control input-sm" value="" readonly/>
                                              
                                            ';
                                     
                                } else if ($value['Field'] == 'promoter_contact') {
                                   
                                        echo '
                                                
                                                    <input type="hidden" name="' . $value['Field'] . '" class="form-control input-sm" value=""  required/>
                                               
                                            ';
                                     
                                } else if ($value['Field'] == 'promoter_id') {
                                   
                                        echo '
                                                <div class="form-group">
                                                 
                                                    <input type="hidden" name="' . $value['Field'] . '" class="form-control input-sm" value="' . $promoterId. '" readonly/>
                                                </div>
                                            ';
                                     
                                }else if ($value['Field'] == 'caller') {
                                   
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm" value="' . $_SESSION["full_name"]. '" readonly/>
                                                </div>
                                            ';
                                     
                                }else if ($value['Field'] == 'waterpoint_id') {
                                   
                                        echo '
                                                <div class="form-group">
                                                   
                                                    <input type="hidden" name="' . $value['Field'] . '" class="form-control input-sm" value="' . $waterpointId. '" readonly/>
                                                </div>
                                            ';
                                     
                                }else if ($value['Field'] == 'message') {
                                   
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <textarea name="' . $value['Field'] . '" class="form-control input-sm" required></textarea>
                                                </div>
                                            ';
                                     
                                }else {
                                    if (!isset($single_record)) {

                                        if (strpos($value['Field'], 'date') !== false) {
                                            echo '
								            <div class="form-group">
								            	<label> Call Date</label><br>
												<input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  required/>
											</div>
										';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                </div>
                                            ';
                                        }
                                        continue;
                                    } else {
                                        if (strpos($value['Field'], 'date') !== false) {
                                            echo '
								            <div class="form-group">
								            	<label> Call Date</label><br>
												<input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker" value="' . $single_record[$x] . '" required/>
											</div>
										';
                                        } else {

                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" value="' . $single_record[$x] . '"   name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                </div>
                                            ';
                                        }
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
                    <a href='<?php echo URL . "processdata/promoter/" ?>'>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </a>
                    <button  type="submit" class="btn btn-primary" name="add-callLog-data" id="add-callLog-data">Save Details</button>
                </div>
            </form>
        </div>
    </div>
</div>  


<script type="text/javascript">
    window.onload = function() {
      //  $("#mymodal").show();
        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');
     
    };
</script>