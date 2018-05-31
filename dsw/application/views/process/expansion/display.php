<div class="col-md-10">
    <div id="data-table-manger">
        <?php if (isset($_GET['message'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php 
                echo $_GET['message'];
            ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
      <?php } ?>
        <div class="clearfix">
            <h3 class="pull-left"><?php echo $tableName; ?></h3>

            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">
                  <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add C.A.U</button>
                  
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="table-responsive">
        <?php if (!empty($data)) { ?>

            <table id="data-table" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' && $table != "staff_category") {
                                continue;
                            }
                            if (!in_array($key, $arrayName = array('id'))) {

                                if ($key == "country" || $key == "Country") {
                                    continue;
                                } else {
                                    echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                        }
                        ?>
                            <th></th>
                   </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    // echo "<pre>";var_dump($data);echo "</pre>";
                    foreach ($data as $key => $value) {
                        ?>
                        <tr>
                            <?php
                            foreach ($value as $key => $value) {
                                // echo "<pre>";var_dump($key);echo "</pre>";         
                                if ($key == 'position' && $table != "staff_category") {
                                    continue;
                                }
                                if ($i == 1) {
                                    $generalId = $value;
                                }
                                if (!in_array($key, $arrayName = array('id'))) {

                                    if ($key == "country" || $key == "Country") {
                                        continue;
                                    }
                                    if($key=="stage"){
                                    if($value=="site_v_schedule"){
                                        echo '<td style="text-align:center">Waterpoint Verification</td>';
                                    }else if($value=="vcs_gen_schedule"){
                                        echo '<td style="text-align:center">Vcs</td>';
                                    }else if($value=="dispenser_gen_schedule"){
                                        echo '<td style="text-align:center">Dispenser Installation & Cem</td>';
                                    }else if($value=="cem_gen_schedule"){
                                        echo '<td style="text-align:center">Cem</td>';
                                    }
                                    }else if($key=='territory_name' ||$key=='assign_field_officers_per' ||$key=='cau_to_inspect'){
                                        foreach ($territory as $key => $value_) {
                                            if($value==$value_["id"]){
                                              echo '<td style="text-align:center" >'.ucwords(str_replace('_', ' ',$value_["territory_name"])).'</td>';
                                            }
                                        
                                        }


                                    }else {
                                        echo '<td style="text-align:center">' . $value . '</td>';
                                    }
                                }
                        
                            }
                           
                            ?>
                           
                                <td><a onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>);"><button class="btn btn-danger btn-xs">Delete</button></a></td>    							
                          
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>					
                </tbody>
            </table>

        <?php } else { ?>

            <p><b>No Record Found</b></p>

        <?php } ?>

    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable({
        
        });
    });
</script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo "Add " . $tableName . ""; ?></h4>
            </div>
            <form  action="<?php echo URL; ?>expansion/displayAdd/<?php echo $table.'/'; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                         
                            foreach ($fields as $key => $value) {
                                if ($value['Key'] == 'PRI') {
                                    echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                }else if ($value['Key'] == 'MUL' && $value['Field'] == 'country') {
                                    echo '
                                        <input type="hidden" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm"  value="'.$_SESSION['country'].'" readonly/>
                                        ';
                                }  else if ($value['Key'] == 'MUL') {
                                    echo '
                                        <div class="form-group">
                                        <label for="' . $value['Field'] . '" >' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                foreach ($value['parents'] as $key => $value_) {
                                                    echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                }
                                                echo '</select>
                                        </div>';
                                } else if ($value['Field'] == 'email') {
                                    echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="email" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
                                                    </div>
                                            ';
                                } else if (strpos($value['Field'], 'phone') !== false) {
                                    echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                    </div>
                                            ';
                                } else if ($value['Field'] == 'stage') {
                                    echo '
                                        <div class="form-group">
                                        <label for="' . $value['Field'] . '" >' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                
                                                echo'<option value="site_v_schedule" >Verification</option>';
                                                echo'<option value="vcs_gen_schedule" >VCS</option>';
                                                echo'<option value="dispenser_gen_schedule" >Installation-CEM</option>';
                                              //  echo'<option value="cem_gen_schedule" >Cem</option>';
                                                echo '</select>
                                        </div>';
                                } else if ($value['Field'] == 'territory_name' || $value['Field'] == 'assign_field_officers_per' || $value['Field'] == 'cau_to_inspect') {
                                    echo '
                                        <div class="form-group">
                                        <label for="' . $value['Field'] . '" >' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                foreach ($territory as $key => $value_) {
                                                    echo'<option value="' . $value_['id'] . '" >' . ucwords(str_replace('_', ' ',$value_["territory_name"])) . '</option>';
                                                }
                                                echo '</select>
                                        </div>';
                                }  else if (strpos($value['Field'], 'contact') !== false) {
                                    echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                    </div>
                                            ';
                                } else if (strpos($value['Field'], 'date') !== false) {
                                    echo '
								            <div class="form-group">
								            	<label for="' . $value['Field'] . '"> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input id="' . $value['Field'] . '" type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
											</div>
										';
                                } else {
                                    echo '
								            <div class="form-group">
								            	<label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input id="' . $value['Field'] . '" type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
											</div>
										';
                                }
                            }
                            ?>	
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-program-data" id="add-expansion-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>  

<script type="text/javascript">
    $('#myModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');

    });

    function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>expansion/displayDelete/' + tables + '/' + deleteId);

        } else {
            console.log('<?php echo URL ?>expansion/displayDelete/' + tables + '/' + deleteId);
            return false;
        }
    }



</script>