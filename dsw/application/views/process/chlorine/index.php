
<div class="col-md-10">
  <?php if (isset($_GET['message'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php echo $_GET['message']; ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>
    <div id="data-table-manger">

        <div class="clearfix">
            <h3 class="pull-left"><?php echo $tableName; ?></h3>

            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">
                        <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add</button>
                        <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#import">Import</button>
                   
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
                        <th class="index"></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' && $table != "staff_category") {
                                continue;
                            }

                            if (!in_array($key, $arrayName = array('id'))) {

                                if ($key == "country" || $key == "Country") {
                                    continue;
                                } else {
                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                        }
                        ?>
                        <?php if ($table != "staff_list") { ?>
                            <th></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="index"></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' && $table != "staff_category") {
                                continue;
                            }

                            if (!in_array($key, $arrayName = array('id'))) {

                                if ($key == "country" || $key == "Country") {
                                    continue;
                                } else {
                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                        }
                        if ($table != "staff_list") {
                            ?>
                            <th class="buttons"></th>
                        <?php }
                        ?>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($data as $key => $value) {
                        ?>
                        <tr>
                            <th class="index"></th>
                            <?php
                            foreach ($value as $key1 => $value1) {

                                if ($key1 == 'position' && $table != "staff_category") {
                                    continue;
                                }

                                if ($i == 1) {
                                    $generalId = $value1;
                                }

                                if (!in_array($key1, $arrayName = array('id'))) {

                                    if ($key1 == "country" || $key1 == "Country") {
                                        continue;
                                    } else {
                                        echo '<td>' . $value1 . '</td>';
                                    }
                                }
                            }
                            ?>                           
                            <td class="buttons">
                                <a class="btn btn-default btn-xs btn-block" href="<?php echo URL ?>chlorineclass/update/<?php echo $table . "/" . $data[$i]['id']; ?>">Edit</a>
                                <!--<a class="btn btn-default btn-xs btn-block" onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>);">Delete</a>-->
                                <?php
                                $data_id = $data[$i]['id'];
                                $delet_details = $data[$i]['batch_no'];
                                echo"<a onclick='show_confirm( \"$table\",\"$data_id\",\"$delet_details\");' class='btn btn-default btn-xs'>Delete</a> "
                                ?>
                            </td>
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

                                        // Setup - add a text input to each footer cell
                                        $('#data-table tfoot th').each(function() {
                                            var title = $('#data-table thead th').eq($(this).index()).text();
                                            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                                        });


                                        var visiblecols = [];
                                        $('#data-table thead th').each(function(e) {
                                            if ($(this).hasClass('export-visible')) {
                                                visiblecols.push($(this).index());
                                            }
                                        });

                                        var table = $('#data-table').DataTable({
                                            scrollY: false,
                                            scrollX: true,
                                            dom: 'T<"clear">lfrtip',
                                            tableTools: {
                                                sSwfPath: "<?php echo URL; ?>public/swf/copy_csv_xls_pdf.swf",
                                                aButtons: [
                                                    {
                                                        sExtends: "xls",
                                                        sButtonText: "Export All",
                                                        mColumns: visiblecols
                                                    },
                                                    {
                                                        sExtends: "xls",
                                                        sButtonText: "Export Filtered",
                                                        oSelectorOpts: {
                                                            page: 'current'
                                                        },
                                                        mColumns: visiblecols
                                                    }
                                                ]
                                            },
                                            columnDefs: [{
                                                    "searchable": false,
                                                    "orderable": false,
                                                    "targets": 0
                                                }],
                                            order: [[1, 'asc']]
                                        });

                                        // Apply the search
                                        table.columns().eq(0).each(function(colIdx) {
                                            $('input', table.column(colIdx).footer()).on('keyup change', function() {
                                                table
                                                        .column(colIdx)
                                                        .search(this.value)
                                                        .draw();
                                            });
                                        });

                                        table.on('order.dt search.dt', function() {
                                            table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
                                                cell.innerHTML = i + 1;
                                            });
                                        }).draw();

                                    });
</script>

<!-- Add Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo "Add " . $tableName . ""; ?></h4>
            </div>
            <form  action="<?php echo URL; ?>chlorineclass/add/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                                            
                            foreach ($fields as $key => $value) {
                                if ($value['Key'] == 'PRI') {
                                    echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                } else if ($value['Key'] == 'MUL' && $value['Field'] != 'country') {
                                    echo '
                                            <div class="form-group">
                                            <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <select name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                    foreach ($value['parents'] as $key => $value_) {
                                        echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                    }
                                    echo '</select>
                                            </div>';
                                } else if ($value['Field'] == 'country') {
                                    echo '
                                            <input type="hidden" value="' . $_SESSION['country'] . '" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
                                        ';
                                } else if (strpos($value['Field'], 'description') !== false) {
                                    echo '
                                            <div class="form-group">
                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                <textarea id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm"></textarea>
                                                        </div>
                                                ';
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
                                } else if ($value['Field'] == 'last_update') {
                                    echo ' <input type="hidden" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />';
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
                    <button  type="submit" class="btn btn-primary" name="add-chlorine-data" id="add-chlorine-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>  


<!-- Modal -->
<div class="modal fade" id="import"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Import  Details</h4>
            </div>
            <form  action="<?php echo URL; ?>importclass/import/<?php echo $table.'/chlorineclass/chlorine'; ?>" enctype="multipart/form-data" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            Select File to upload:
                            <input type="file" name="file" id="file" />
                            </div>
                            <div class="form-group">
                            <input type="submit" value="Upload" name="update-verification"/>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-general-data" id="add-general-data">Save</button>
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

    function show_confirm(tables, deleteId, deletDetail) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>chlorineclass/delete/' + tables + '/' + deleteId + '/' + deletDetail);

        } else {
            console.log('<?php echo URL ?>chlorineclass/delete/' + tables + '/' + deleteId);
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