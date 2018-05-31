<!-- Modal -->
<div id="myModal" class="col-md-6 col-md-offset-3" >
    <div >
        <div >
            <div>
                <h4 class="text-center" ><?php echo "Edit ".$table ?></h4>
            </div>
	           
                        <form  action="<?php echo URL; ?>chlorine/update/chlorine_inventory" data-async data-target="myModal" method="post" role="form" id="modal-form">
        
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $x=0;
                          //  echo "<pre>";var_dump($single_record);echo "</pre>";
                            foreach ($fields as $key => $value) {
                                    
                                    if ($value['Key'] == 'PRI') {
                                            echo '<input type="hidden" value="'.$single_record[$x].'" value="" name="' . $value['Field'] . '"readonly/>';

                                    } else if ($value['Key'] == 'MUL') {
                                        if ( $value['Field'] == 'country' ) {
											$disabled = 'disabled';
											// $disabled = 'style="display:none"';
										} else {
											// $disabled = '';
                                            // $disabled = 'style="display:none"';
										}

								         echo '
								         	<div class="form-group" '.$disabled.'>
								            	<label>'.ucwords( str_replace('_',' ',$value['Field']) ).'</label><br>
												<select name="'.$value['Field'].'" class="form-control input-sm" required>
													<option value="">Select '.ucwords( str_replace('_',' ',$value['Field']) ).'</option>';
													foreach ($value['parents'] as $key => $value_) {
														echo "<pre>";var_dump($value['parents'] );echo "</pre>";
														if ( $value_['country'] == $_SESSION["country"] ) {
															echo'<option value="'.$value_['id'].'" selected>'.$value_[$value['Field']].'</option>';
														}
														else {
															echo'<option value="'.$value_['id'].'">'.$value_[$value['Field']].'</option>';
														}
													}
												echo '</select>
											</div>';
                                    
                                    }  else {
                                       
                                              echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" value="'.$single_record[$x].'"   name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                </div>
                                            ';
                                        
                                    }
                                $x++;
                            }
                            ?>  
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-4">
                     <!-- this takes the user back to the previous page -->
                    <a href='<?php echo URL."chlorine/" ?>'>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </a>
                    <button  type="submit" class="btn btn-primary" name="update-chlorine-data" id="add-issue-data">Update Details</button>
                </div>
            </form>
        </div>
    </div>
</div>  

<script type="text/javascript">
    window.onload=function() {
        $("#mymodal").show();
        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');

    
    };
</script>

