<?php $lastUrl = $fleetlist_model->getLastURL($_SERVER['REQUEST_URI']); ?>
<div class="col-md-10">
    <div id="data-table-manger">

        <div class="clearfix">
            <h3 class="pull-left"><?php echo $tableName; ?></h3>

            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">
                    <!-- <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add</button> -->
                   
                    <?php
                    if ($lastUrl == $table) {
                        ?>
                                          } else {
                        ?>
                        <div class="btn-group">
                            <a href="<?php echo URL ?>generalclass/export/<?php echo $table . "/" . $lastUrl ?>">
                                <button type="button" class="btn btn-default">Export CSV</button>
                            </a>
                        </div>

                        <?php
                    }
                    ?>
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
                                    } else {
                                        echo '<td>' . $value . '</td>';
                                    }
                                }
                                // $i = 0;	
                            }
                            // $i = 1;
                            ?>
                           
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
            "scrollY": "500px",
          
            "scrollCollapse": true
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
            <form  action="<?php echo URL; ?>fleetclass/add/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                         
                            foreach ($fields as $key => $value) {
                                if ($value['Key'] == 'PRI') {
                                    echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                } else if ($value['Key'] == 'MUL') {
                                    echo '
                                        <div class="form-group">
                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <select name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                foreach ($value['parents'] as $key => $value_) {
                                                    echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                }
                                                echo '</select>
                                        </div>';
                                } else if ($value['Field'] == 'email') {
                                    echo '
                                        <div class="form-group">
                                            <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="email" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
                                                    </div>
                                            ';
                                } else if (strpos($value['Field'], 'phone') !== false) {
                                    echo '
                                        <div class="form-group">
                                            <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                    </div>
                                            ';
                                } else if (strpos($value['Field'], 'contact') !== false) {
                                    echo '
                                        <div class="form-group">
                                            <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                    </div>
                                            ';
                                } else if (strpos($value['Field'], 'name') !== false && ($value['Field'] == 'full_name' || $value['Field'] == 'name')) {
                                    echo '
                                        <div class="form-group">
                                            <label>First Name</label><br>
                                                            <input type="text" id="first_name" name="first_name" class="form-control input-sm" />
                                                    </div>
                                            ';
                                    echo '
                                        <div class="form-group">
                                            <label>Middle Name</label><br>
                                                            <input type="text" id="middle_name" name="middle_name" class="form-control input-sm" />
                                                    </div>
                                            ';
                                    echo '
                                        <div class="form-group">
                                            <label>Last Name</label><br>
                                                            <input type="text" id="last_name" name="last_name" class="form-control input-sm"/>
                                                    </div>
                                            ';
                                    echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                } else if (strpos($value['Field'], 'date') !== false) {
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
												<input type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
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
                    <button  type="submit" class="btn btn-primary" name="add-fleet-data" id="add-fleet-data">Save</button>
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
            location.replace('<?php echo URL ?>fleetclass/delete/' + tables + '/' + deleteId);

        } else {
            console.log('<?php echo URL ?>fleetclass/delete/' + tables + '/' + deleteId);
            return false;
        }
    }

    $('form').validate();

    // $('#myModal').on('click','#add-admin-data', function(event) {

    //     var $form = $('#myModal form');
    //     var $target = $($form.attr('data-target'));

    //     $.ajax({
    //         type: $form.attr('method'),
    //         url: $form.attr('action'),
    //         data: $form.serialize(),

    //         success: function(data, status) {
    //         	if ( status == 'success') {
    //             	$('#message').html('<p class="bg-success"><span class="glyphicon glyphicon-ok-circle" ></span> Data Successfully Added</p>');
    //             	$('#myModal form').get(0).reset();
    //         	} else {
    //             	$('#message').html('<p class="bg-danger"><span class="glyphicon glyphicon-remove-circle" ></span> Error Adding Data</p>');
    //         	}
    //         }
    //     });

    //     event.preventDefault();
    // });


</script>