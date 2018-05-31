<?php $lastUrl = $verification_model->getLastURL($_SERVER['REQUEST_URI']); ?>
<div class="col-md-10">
    <div id="data-table-manger">

        <div class="clearfix">
            <h3 class="pull-left"><?php echo $tableName; ?></h3>

            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">
                    <!-- <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add</button> -->
                    <?php if ($table != "staff_list") { ?>
                        <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add <?php echo $tableName; ?></button>
                    <?php } ?>
                    <?php
                    if ($lastUrl == $table) {
                        ?>
                        <div class="btn-group">
                            <a href="<?php echo URL ?>generalclass/export/<?php echo $table ?>">
                                <button type="button" class="btn btn-default">Export CSV</button>
                            </a>
                        </div>

                        <?php
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
                        <?php if ($table == "vcs_schedule") { ?>
                            <th></th>
                            <th></th>
                        <?php } ?>
                        <th></th>
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
                                    } else {
                                        echo '<td>' . $value . '</td>';
                                    }
                                }
                                // $i = 0;	
                            }
                            // $i = 1;
                            if($table=='vcs_schedule'){
                            ?>
                                <td><a target="blank" href="<?php echo URL ?>processdata/pdfVcsFo/<?php echo  $data[$i]['id']; ?>"><button class="btn btn-success btn-xs">F.O Schedule</button></a></td> 
                                <td><a target="blank" href="<?php echo URL ?>processdata/pdfVcs/<?php echo  $data[$i]['id']; ?>"><button class="btn btn-success btn-xs">VCS Schedule</button></a></td> 
                            <?php
                            }

                            ?>
                                <td><a href="<?php echo URL ?>processdata/updateExpansion/<?php echo $category.'/'.$table . "/" . $data[$i]['id']; ?>"><button class="btn btn-success btn-xs">Edit</button></a></td> 
                                <!-- <td><a href="<?php echo URL ?>generalclass/delete/<?php echo $table . "/" . $data[$i]['id']; ?>" class="btn btn-default">Delete</a></td> -->
                                <!-- <td><a href="<?php echo URL ?>generalclass/delete/<?php echo $table . "/" . $data[$i]['id']; ?>" class="btn btn-default">Delete</a></td> -->
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
            "scrollY": "100%",
            "scrollX": "100%",
            "scrollCollapse": false,
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
            <form  action="<?php echo URL; ?>processdata/add/<?php echo $table.'/'.$category; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php

                            foreach ($fields as $key => $value) {
                                if ($value['Key'] == 'PRI') {
                                    echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                } else if ($value['Key'] == 'MUL' && $value['Field']=='full_name') {
                                    echo '
                                        <div class="form-group">
                                        <label for="' . $value['Field'] . '" >Field Officer</label><br>
                                                <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select Field Officer</option>';
                                                foreach ($value['parents'] as $key => $value_) {
                                                    echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                }
                                                echo '</select>
                                        </div>';
                                }else if ($value['Key'] == 'MUL') {
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
                                }else if (strpos($value['Field'], 'date') !== false) {
                                    echo '
								            <div class="form-group">
								            	<label for="' . $value['Field'] . '"> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input id="' . $value['Field'] . '" type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
											</div>
										';
                                }else {
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
                    <button  type="submit" class="btn btn-primary" name="add-vcs-data" id="add-vcs-data">Save</button>
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
            location.replace('<?php echo URL ?>processdata/deleteExpansion/VCS/' + tables + '/' + deleteId);

        } else {
            console.log('<?php echo URL ?>processdata/deleteExpansion/VCS/' + tables + '/' + deleteId);
            return false;
        }
    }

   // $('form').validate();

</script>