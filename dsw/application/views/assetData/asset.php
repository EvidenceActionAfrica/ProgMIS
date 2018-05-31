<div class="col-md-10">
    <div class="clearfix">
        <?php if (isset($_GET['message'])) { ?>
            <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
                <?php echo $_GET['message']; ?>
                <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </div>
        <?php } ?>

        <h3 class="pull-left"><?php echo $inventory_type; ?> Inventory</h3>
        <div class="pull-right">
            <div class="btn-group">
                <button type="button" style='margin-right:10px;' class="btn btn-default pink-button" data-toggle="modal" data-target="#myImportModal">Import</button>
                <!-- <a href="<?php echo URL ?>assetData/export/<?php echo $inventory_type_id ?>" class="btn btn-default">Export CSV</a> -->
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal2">Add New</button>
            </div>
        </div>
    </div>
    <hr>

    <div class="table-responsive">
        <?php
        if (!empty($data)) {

            $hiddenFields = array('id', 'inventory_type', 'quantity,', 'quantity', 'total_usd', 'item_desc', 'purchase_price_usd', 'project', 'phone_imei', 'battery_serial', 'simcard_number', 'deprecation_period',);
            ?>

            <table id="data-table" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="index"></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if (!in_array($key, $hiddenFields)) {
                                if ($key == "country" || $key == "Country") {
                                    continue;
                                } else {
                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                        }
                        ?>
                        <th class="buttons"></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="index"></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if (!in_array($key, $hiddenFields)) {
                                if ($key == "country" || $key == "Country") {
                                    continue;
                                } else {
                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                        }
                        ?>
                        <th class="buttons"></th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $J = 0;
                    foreach ($data as $key => $value) {
                        echo '<tr><td class="index"></td>';
                        foreach ($value as $key => $value_) {
                            if (!in_array($key, $hiddenFields)) {
                                if ($key == "country" || $key == "Country") {
                                    continue;
                                } else {
                                    echo '<td class="export-visible">' . $value_ . '</td>';
                                }
                            }
                        }
                        if (!empty ($data[$J]['serial_no'])) {
                        $serial_no = 'serialNo: ' . $data[$J]['serial_no'];
                        }else{
                           $serial_no = 'invoiceNo: ' . $data[$J]['invoice_number']; 
                        }
                        $data_id = $data[$J]['id'];
                        ?>						 
                    <td class="buttons">
                        <a href="<?php echo URL; ?>assetData/update/<?php echo $inventory_type_id . '/' . $data[$J]['id'] ?>" class="btn btn-default">Edit</a>
        <?php echo"<a onclick='show_confirm( $inventory_type_id,\"$data_id\",\"$serial_no\",\"$inventory_type\");' class='btn btn-default'>Delete</a> " ?>
                    </td>

                    <?php
                    echo '</tr>';
                    $J++;
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
<?php if (!empty($data)) { ?>
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
                scrollCollapse: false,
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
<?php } ?>
    });
</script>

<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add</h4>
            </div>
            <form action="<?php echo URL; ?>assetData/add" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $x = 0;
                            foreach ($fields as $key => $value) {

                                if ($value['Key'] == 'PRI') {

                                    echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                } else if ($value['Key'] == 'MUL' && $value['Field'] != 'country' && $value['Field'] != 'inventory_type') {
                                    echo '
							         	<div class="form-group">
							            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
											<select name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                    foreach ($value['parents'] as $key => $value_) {
                                        if ($value_[$value['Field']] == $inventory_type) {
                                            echo'<option value="' . $value_['id'] . '" selected>' . $value_[$value['Field']] . '</option>';
                                        } else {
                                            echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                        }
                                    }
                                    echo '</select>
										</div>';
                                } else if ($value['Field'] == 'country') {

                                    echo '<input type="hidden" value="' . $_SESSION['country'] . '" name="' . $value['Field'] . '"/>';
                                } else if ($value['Field'] == 'inventory_type') {

                                    echo '<input type="hidden" value="' . $inventory_type_id . '" name="' . $value['Field'] . '"/>';
                                } else if (strpos($value['Field'], 'date') !== false) {
                                    echo '
							            <div class="form-group">
							            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
											<input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker" />
										</div>
									';
                                } else {
                                    echo '
							            <div class="form-group">
							            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
											<input type="text" name="' . $value['Field'] . '" value="" class="form-control input-sm"/>
										</div>
									';
                                }
                                $x++;
                            }
                            ?>	
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="add-admin-data" id="add-admin-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myImportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Import  Details</h4>
            </div>
            <form  action="<?php echo URL; ?>importclass/importAssets/<?php echo 'admin_assets/assetData/asset'; ?>" enctype="multipart/form-data" data-async data-target="myModal" method="post" role="form" id="modal-form">
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

    // arranges the modal into columns
    $('#myModal2').on('show.bs.modal', function(e) {
        autoColumn(3, '#myModal2 .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');
    });

    // shows a delete confrim message
    function show_confirm(inventory_type_id, deleteId, serial_no, inventory_type) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>assetData/delete/' + inventory_type_id + '/' + deleteId + '/' + serial_no + '/' + inventory_type);
        } else {
            return false;
        }
    }

</script>

