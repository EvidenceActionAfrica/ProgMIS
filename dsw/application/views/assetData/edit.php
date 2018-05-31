<!-- Modal -->
<div id="myModal" class="col-md-6 col-md-offset-3" >
    <h4 class="text-center" ><?php echo "Edit ".$inventory_type." Inventory" ?></h4>
    <form  action="<?php echo URL; ?>assetData/update/" data-async data-target="myModal" method="post" role="form" id="modal-form">
        <div class="modal-body">
            <div id="message"></div>
            <div class="row">
                <div class="col-md-12">
                    <?php $x=0; foreach ($fields as $key => $value) {

                        if ($value['Key'] == 'PRI') {

                            echo '<input type="hidden" value="'.$single_record['id'].'" value="" name="' . $value['Field'] . '"readonly/>';

                        } else if ($value['Key'] == 'MUL' ) {
                            
                            if ($value['Field'] == 'country') {

                                echo '<input type="hidden" value="'.$_SESSION['country'].'" name="'.$value['Field'].'"/>';  

                            } else if ($value['Field'] == 'inventory_type') {

                                echo '<input type="hidden" value="'.$inventory_type_id.'" name="'.$value['Field'].'"/>';    
                                                                
                            } else {
						         echo '
						         	<div class="form-group" >
						            	<label>'.ucwords( str_replace('_',' ',$value['Field']) ).'</label><br>
										<select name="'.$value['Field'].'" class="form-control input-sm" required>
											<option value="">Select '.ucwords( str_replace('_',' ',$value['Field']) ).'</option>';
											foreach ($value['parents'] as $key => $value_) {
                                                if ( $value_['id'] == $single_record['office_location']) {
                                                    echo'<option value="'.$value_['id'].'" selected>'.$value_[$value['Field']].'</option>';
                                                } else {
												    echo'<option value="'.$value_['id'].'">'.$value_[$value['Field']].'</option>';
                                                }
											}
										echo '</select>
									</div>';
                            }
                        
                        } else if (strpos($value['Field'], 'date') !== false) {
                            echo '
                                <div class="form-group">
                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                    <input type="text" value="'.$single_record[$value['Field']].'" name="'.$value['Field'] .'" class="form-control input-sm datepicker" />
                                </div>
                            ';
                        
                        } else {
                           
                            echo '
                                <div class="form-group">
                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                    <input type="text" value="'.$single_record[$value['Field']].'" name="' . $value['Field'] . '" class="form-control input-sm"/>
                                </div>
                            ';
                            
                        }                           
                       
                    $x++;} ?>  
                </div>
            </div>
        </div>
        <div class="col-md-offset-5">
           <a href='<?php echo URL."assetData/asset/".$inventory_type_id; ?>' class="btn btn-default">Cancel</a>
           <button type="submit" class="btn btn-primary" name="update">Save</button>
        </div>
    </form>
</div>  

<script type="text/javascript">
    window.onload=function() {
        $("#mymodal").show();
        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');    
    };
</script>

