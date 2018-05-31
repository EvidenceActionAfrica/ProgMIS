
<!-- Modal -->
<div id="myModal" class="col-md-6 col-md-offset-3" >
    <div >
        <div >
            <div>
                <h4 class="text-center" ><?php echo "Edit " . $tableName . ""; ?></h4>
            </div>
            <?php 
                if (isset($single_record)) {
                    ?> 
                        <form  action="<?php echo URL; ?>issuetracker/update/" data-async data-target="myModal" method="post" role="form" id="modal-form">
                    <?php

                }else{
                     ?> 
                        <form  action="<?php echo URL; ?>issuetracker/add/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                    <?php

                }
             ?>
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $x=0;
                          //  echo "<pre>";var_dump($single_record);echo "</pre>";
                            foreach ($fields as $key => $value) {
                                
                                    if ($value['Key'] == 'PRI') {
                                        if (!isset($single_record)) {
                                            echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                        }else{
                                            echo '<input type="hidden" value="'.$single_record[$x].'" value="" name="' . $value['Field'] . '"readonly/>';

                                        }
                                    } else if ($value['Key'] == 'MUL') {
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <select name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                        foreach ($value['parents'] as $key => $value_) {
                                          /*  if (isset($single_record)) {
                                                if ($single_record[$x] == $value_['id']) {
                                                    $selected='selected';
                                                    echo'<option selected="'.$selected.'" value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                }else{*/
                                                   // $selected='';
                                                    echo'<option  value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                            
                                            

                                               // echo'<option selected="'.$selected.'" value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                            
                                        }
                                        echo '</select>
                                                </div>';
                                    } else if ($value['Type'] == 'timestamp') {
                                        if (!isset($single_record)) {
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="" class="form-control input-sm" value="' . date('d-m-Y') . '" readonly/>
                                                </div>
                                            ';
                                        }else{
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" value="'.$single_record[$x].'"  name="' . $value['Field'] . '" class="form-control input-sm" readonly/>
                                                </div>
                                            ';
                                        }
                                    } else if ($value['Field'] == 'issueid') {
                                        echo '
                                                <div class="form-group">
                                                    <input type="hidden" name="' . $value['Field'] . '" class="form-control input-sm" value="' . $dataId . '" readonly/>
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
                                        }else{
                                            
                                              echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" value="'.$single_record[$x].'"   name="' . $value['Field'] . '" class="form-control input-sm"/>
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="edit-issue-data" id="add-issue-data">Update Details</button>
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