<div class="col-md-9">
    <?php if (isset($_GET['message'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php echo $_GET['message']; ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>
    <h3>Tracking</h3> 

    <div class="table-responsive">
        <div class="btn-group pull-left">
            <?php if (!isset($editable) || $editable == false) { ?>
                <?php if (!empty($waterpoint_details)) { ?> 
                    <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myODKModal">Add/Replace ODK Link</button>
                    <a href="#" class="btn btn-default pink-button" data-toggle="modal" data-target="#import-modal">Import Tracking Data</a>
                    <a href="#" class="btn btn-default pink-button" data-toggle="modal" data-target="#archive">archive</a>
                <?php } ?>
            <?php } else { ?>

                <form method="POST" action="<?php echo $program; ?>">

                    <?php foreach ($array_select[0] as $key => $value) { ?>
                        <label> Select <?php echo $cau_dispaly = str_replace('_', ' ', $key); ?></label>
                    <?php } ?>
                    <select name="name" class=" input-sm"  required>
                        <option value=''>None Selected</option>
                        <?php
                        $array_select = array_unique(array_map('current', $array_select));
                        foreach ($array_select as $key => $value) {
                            if (isset($_POST['name']) && $_POST['name'] == $value) {
                                echo '<option value="' . $value . '" selected>' . str_replace('_', ' ', $value) . '</option>';
                                $table_title = $value['name'];
                            } else {
                                echo '<option value="' . $value . '">' . str_replace('_', ' ', $value) . '</option>';
                            }
                        }
                        ?>
                    </select>

                    <input type="submit" class="btn btn-default" name="select_cau" value="Confirm"/>

                </form>

            <?php } ?>
        </div>
        <?php if (!empty($waterpoint_details)) { ?> 


            <form action="<?php echo URL; ?>cdelivery/waterpoints/<?php echo $program; ?>" method="post">

                <div class="btn-group pull-right">

                    <button type="submit" class="btn btn-default" name="edit-waterpoints" <?php
                    if (isset($editable) && $editable == true) {
                        echo 'disabled';
                    }
                    ?> >Edit</button>
                    <button type="submit" class="btn btn-default" name="save-waterpoints" <?php
                    if (!isset($editable) || $editable == false) {
                        echo 'disabled';
                    }
                    ?> >Save</button>
                </div>

                <br>
                <br>

                <table class="table table-striped table-hover table-bordered" id="data-table">
                    <thead>
                        <tr>
                            <th class="index"></th>
                            <?php
                            foreach ($waterpoint_details[0] as $key => $value) {
                                if ($key != 'id' && $key != 'latitude' && $key != 'longitude' && $key != 'distance') {
                                    if ($key == 'start_date') {
                                        echo '<th class="export-visible">Delivery Date</th>';
                                    } else {
                                        echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                    }
                                }
                            }
                            ?>
                            <th class="export-visible">CSA</th>
                            <th class="export-visible">Number of Chlorine deliveries on server</th>
                            <th class="export-visible">Number of spot checks on server</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="index"></th>
                            <?php
                            foreach ($waterpoint_details[0] as $key => $value) {
                                if ($key != 'id' && $key != 'latitude' && $key != 'longitude' && $key != 'distance') {
                                    if ($key == 'start_date') {
                                        echo '<th class="export-visible">Delivery Date</th>';
                                    } else {
                                        echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                    }
                                }
                            }
                            ?>
                            <th class="export-visible">CSA</th>
                            <th class="export-visible">Number of Chlorine deliveries on server</th>
                            <th class="export-visible">Number of spot checks on server</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        foreach ($waterpoint_details as $key => $value) {

                            if (isset($assigned_csas_new[$value['id']])) {
                                $assigned_csa = $assigned_csas_new[$value['id']]['csa'];
                            } else {
                                $assigned_csa = '';
                            }
                            ?>
                            <tr>
                                <td></td>
                                <?php if (isset($editable) && $editable == true) { ?>
                            <input type="text" name="id[]" value="<?php echo $value['id']; ?>" style="display: none;">
                        <?php } ?>
                        <?php
                        foreach ($value as $key => $value_1) {

                            if ($key != 'id' && $key != 'latitude' && $key != 'longitude' && $key != 'distance') {
                                ?>

                                <td class="export-visible">
                                    <?php
                                    if (in_array($key, array('waterpoint_name', 'waterpoint_id', 'default_jerrycans_per_delivery'))) {

                                        echo $value_1;
                                    } else {

                                        if (isset($editable) && $editable == true) {
                                            if ($key == 'start_date') {
                                                echo '<input type="text" value="' . $value_1 . '" name="' . $key . '[]" class="datepicker"/>';
                                            } else if (($key == 'spot_check') || ($key == 'dispenser_problem') || ($key == 'problem_recorded')) {
                                                ?>
                                                <select name="<?php echo $key; ?>[]" >
                                                    <option value="" <?php if ($value_1 != 'Yes' || $value_1 != 'Yes') echo 'selected'; ?>></option>
                                                    <option value="Yes" <?php if ($value_1 == 'Yes') echo 'selected'; ?>>Yes</option>
                                                    <option value="No" <?php if ($value_1 == 'No') echo 'selected'; ?>>No</option>
                                                </select>
                                                <?php
                                            } else {
                                                echo '<input type="text" value="' . $value_1 . '" name="' . $key . '[]" />';
                                            }
                                        } else {
                                            echo $value_1;
                                        }
                                    }
                                    ?>
                                </td>

                                <?php
                            }
                        }
                        ?>
                        <td class="export-visible">
                            <?php if (isset($editable) && $editable == true) { ?>
                                <select name="csa[]" >
                                    <option value="" >Assign a CSA</option>
                                    <?php
                                    foreach ($csa as $key => $value_2) {
                                        if (isset($assigned_csa) && $assigned_csa != '') {
                                            if ($value_2['full_name'] == $assigned_csa) {
                                                echo '<option value="' . $value_2['full_name'] . '" selected >' . $value_2['full_name'] . '</option>';
                                            } else {
                                                echo '<option value="' . $value_2['full_name'] . '" >' . $value_2['full_name'] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="' . $value_2['full_name'] . '" >' . $value_2['full_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <?php
                            } else {
                                if (isset($assigned_csa) && $assigned_csa != '') {
                                    echo $assigned_csa;
                                } else {
                                    echo '<p class="text-muted" ><small><em>CSA Not Assigned</em></small></p>';
                                }
                            }
                            ?>
                        </td>

                        <?php
                        $j = 0;
                        for ($i = 0; $i < sizeof($getodkdata); $i++) {
                            if ($value['waterpoint_id'] == $getodkdata[$i]['waterpoint_id']) {
                                $j++;
                            }
                        }
                        ?> 
                        <td class="export-visible"><?php echo $j; ?></td>
                        <td class="export-visible"><?php echo $j; ?></td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </form>

            <span style='bold;'> Current ODK API LINK Is :</span>
            <?php
            if (isset($odkData[0]['api_key'])) {
                echo $odkData[0]['api_key'];
                echo '<br/>';
                echo '<span style="bold;">Selected Column: ' . $odkData[0]['column_name'];
            } else {
                echo '<b>No ODK Link Found for this Program</b>';
            }
            ?>
            <br>
            <br>

        <?php } else { ?>
            <br><br><br>
            <div class="alert alert-info" role="alert">
                <?php if (isset($editable) && $editable == true) { ?>
                select a <?php echo $cau_dispaly; ?> in order to edit.
                <?php } else { ?>
                No Delivery Details have been entered. <a href="<?php echo URL; ?>cdelivery/index/" class="alert-link">click Here</a> to enter Delivery Details
                <?php } ?>
            </div>

        <?php } ?>


    </div>

</div>
<!-- Modal -->
<div class="modal fade" id="myODKModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add ODK Link</h4>
            </div>
            <form  action="<?php echo URL; ?>cdelivery/verificationODKAdd/<?php echo 'odk_chlorine/' . $program; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">

                            <span>Example of a api key is highlighted: <font style="color:  blue">https://docs.google.com/spreadsheets/d/<font style="background-color: yellow">12ndptfZW_oHxkLJEHlkzG8ByJXwxU9f4ASB6OePCZ3k</font>/edit#gid=0</font></span>
                            <div class="form-group">
                                <label for="apiKey">Api Key</label><br>
                                <input  id="apiKey" type="text" name="apiKey" class="form-control input-sm" required  value="<?php
                                if (isset($odkData[0]['api_key'])) {
                                    echo $odkData[0]['api_key'];
                                } else {
                                    echo 'No ODK Link Found for this Program';
                                }
                                ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="Column">Column Waterpoint ID</label><br>
                                <input id="column" type="text" name="column" class="form-control input-sm" required />
                                <input id="program" type="hidden" name="program" class="form-control input-sm" value="<?php echo $program; ?>" required/>

                            </div>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-verification-data" id="add-verification-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="import-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Import Tracking Details</h4>
            </div>
            <form action="<?php echo URL; ?>cdelivery/importTrackingData/<?php echo $program; ?>" data-async data-target="myModal" method="post" role="form"  enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-control">
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $post_max_size; ?>" />
                        <input type="file" name="tracking-data-csv">
                        <span class="help-block">File Size Should Not exceed <?php echo $post_max_size_M; ?> | <a href="<?php echo URL; ?>application/views/cdelivery/tracking_import_template.csv" target="new">Download Import Template</a></span>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="import-tracking-data" id="import-tracking-data">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Archive Modal -->
<div class="modal fade" id="archive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs" style=" width:25%;">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Adding archive cycle number</h4>
            </div>
            <form action="<?php echo URL; ?>cdelivery/archivetracking/<?php echo $program; ?>" data-async data-target="myModal" method="post" role="form"  enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Column">Cycle Number</label><br>
                                <input id="column" type="text" name="column"  class="form-control input-sm" required />

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button  type="submit" class="btn btn-primary" name="archive" id="import-tracking-data">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
        //console.log(visiblecols.toString());
<?php if (isset($editable) && $editable == true) { ?>
            var table = $('#data-table').DataTable({
                scrollY: "350px",
                scrollCollapse: true,
                paginate: false,
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
                            oSelectorOpts: {filter: 'applied', order: 'current'},
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
<?php } else { ?>

            var table = $('#data-table').DataTable({
                scrollY: "100%",
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
                            oSelectorOpts: {filter: 'applied', order: 'current'},
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
<?php } ?>
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