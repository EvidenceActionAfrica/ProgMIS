<style>
    #data-table_wrapper table {
        width: auto !important;
        border-radius: 3px;
        background-color: #e5e5e5;
        overflow: auto!important;
        table-layout: auto !important;
    }
    #data-table td {
        min-width: 59px;
    }
    table.dataTable th {
    box-sizing: content-box;
    min-width: 63px;
}
   table.dataTable tfoot th {
    box-sizing: content-box;
    min-width: 73px;
}
    
</style>
<?php $lastUrl = $expansionmodel->getLastURL($_SERVER['REQUEST_URI']);
?>
<div class="col-md-10">
    <?php if (isset($message)) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php
            echo $message;
            ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>
    <?php if (isset($_GET['message'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php
            echo $_GET['message'];
            ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>
    <div id="data-table-manger">

        <div class="clearfix">
            <div id="data-table-manger">
                <h3>Program:<?php echo $program; ?>  Installation-Cem Tracking</h3>
            </div>



            <div class="btn-group pull-right">
                <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myODKModal1">Add/Replace ODK Link Instalation</button>                
                <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myODKModal2">Add/Replace ODK Link CEM</button>                
                <a  href="<?php echo URL . 'expansion/trackingInstallUpload/' . $program; ?>" class="btn btn-default pink-button" >Import Installation Tracking</a>
                <a  href="<?php echo URL . 'expansion/trackingCemUpload/' . $program; ?>" class="btn btn-default pink-button" >Import Cem Tracking</a>
                <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add Installation</button>  
                <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal2">Add Cem</button>                
            </div>

        </div>
        <hr>
    </div>
    <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="40px" style="position:absolute;top:50%;left:50%;margin:0 auto; visibility: visible"/>

    <div class="table-responsive">
        <?php if (!empty($data)) { ?>

            <table id="data-table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <?php
                        $arrsyCheck = array ('installation_on_server' ,'cem_on_server','pass/fail','village_elder_name','village_elder_contact','chw_name','chw_contact','cem_schedule_date','cem_time','cem_field_officer','did_it_occur','why_not','attendance','date_completed','won_present','prize_quorum','quorum','Duplicate');
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' || $key == 'program') {
                                continue;
                            }
                            if (in_array($key, $cauManage) || in_array($key, $fieldsArray3) || in_array($key, $fieldsArray4) || in_array($key, $fieldsArray)|| in_array(strtolower($key), $arrsyCheck)) {

                                if (!in_array($key, $arrayName = array('id'))) {

                                    if ($key == "country" || $key == "Country") {
                                        continue;
                                    } else if ($key == "field_officer") {

                                        echo '<th class="export-visible">F.O Responsible</th>';
                                    } else if ($key == "Match") {

                                        echo '<th class="export-visible" title="Verification Id\'s Match Of Tracking & Uploaded Data" data-toggle="tooltip" data-placement="top" >' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                    } else if ($key == "Consistent") {

                                        echo '<th class="export-visible" title="Waterpoints Data in Tracking And In the Admin Module Match" data-toggle="tooltip" data-placement="top" >Is Reverification Neccessary?</th>';
                                    } else if ($key == "installation_date") {
                                        echo '<th class="export-visible" >Install Scheduled Date</th>';
                                    } else {
                                        echo '<th class="export-visible" >' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                    }
                                }
                            }
                        }
                        ?>
                        <th class="buttons"></th>


                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' || $key == 'program') {
                                continue;
                            }
                            if (in_array($key, $cauManage) || in_array($key, $fieldsArray3) || in_array($key, $fieldsArray4) || in_array($key, $fieldsArray) || in_array(strtolower($key), $arrsyCheck)) {

                                if (!in_array($key, $arrayName = array('id'))) {

                                    if ($key == "country" || $key == "Country") {
                                        continue;
                                    } else if ($key == "field_officer") {

                                        echo '<th class="export-visible">F.A Responsible</th>';
                                    } else if ($key == "Match") {

                                        echo '<th class="export-visible" title="Verification Id\'s Match Of Tracking & Uploaded Data" data-toggle="tooltip" data-placement="top" >' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                    } else if ($key == "Consistent") {

                                        echo '<th class="export-visible" title="Waterpoints Data in Tracking And In the Admin Module Match" data-toggle="tooltip" data-placement="top" >Is Reverification Neccessary?</th>';
                                    } else if ($key == "installation_date") {
                                        echo '<th class="export-visible" >Install Scheduled Date</th>';
                                    } else {
                                        echo '<th class="export-visible" >' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                    }
                                }
                            }
                        }
                        ?>

                        <th class="buttons"></th>


                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $i = 0;
                    // echo "<pre>";var_dump($data);echo "</pre>";
                    foreach ($data as $key => $value) {
                        ?>
                        <tr>
                            <td></td>
                            <?php
                            foreach ($value as $key => $value) {
                                // echo "<pre>";var_dump($key);echo "</pre>";         
                                if ($key == 'position' || $key == 'program') {
                                    continue;
                                }
                                if ($i == 1) {
                                    $generalId = $value;
                                }
                                if (in_array($key, $cauManage) || in_array($key, $fieldsArray3) || in_array($key, $fieldsArray4) || in_array($key, $fieldsArray) || in_array($key, $fieldsArray) || in_array(strtolower($key), $arrsyCheck)) {

                                    if (!in_array($key, $arrayName = array('id'))) {

                                        if ($key == "country" || $key == "Country") {
                                            continue;
                                        } else if ($key == 'duplicate' || $key == "Duplicate") {

                                            if ($value == 0) {
                                                echo '<td class="export-visible" ><span title="NONE" data-toggle="tooltip" data-placement="left"  style="color:#3B7A57;">None</span></td>';
                                            } else {
                                                echo '<td class="export-visible" ><span data-toggle="tooltip" data-placement="left" title="The Verification Id Is Not Unique or non-existent" style="color:#E81919;">Yes</span></td>';
                                            }
                                        } else if ($key == "Match") {

                                            if ($value == 1) {
                                                echo '<td class="export-visible"><span title="Match" data-toggle="tooltip" data-placement="left" style="color:#3B7A57;">Match</span></td>';
                                            } else {
                                                echo '<td class="export-visible" ><span data-toggle="tooltip" data-placement="left" title="The Verification Ids do not match or one is non-existent" style="color:#E81919;">Non-Match</span></td>';
                                            }
                                        } else if ($key == "Consistent") {

                                            if ($value == 3) {
                                                echo '<td class="export-visible" style="text-align:center"><span title="All the Details Are Consistent" data-toggle="tooltip" data-placement="left"  style="color:#3B7A57;">No</span></td>';
                                            } else {
                                                echo '<td class="export-visible" ><span data-toggle="tooltip" data-placement="left" title="The Waterpoint Details Are incosistent. Please Check Again"  style="color:#E81919;">Yes</span></td>';
                                            }
                                        } else if ($key == "quorum" || $key == "prize_quorum") {

                                            if ($value != null) {
                                                echo '<td class="export-visible"><span title="All the Details Are Consistent" data-toggle="tooltip" data-placement="left"  style="color:#3B7A57;">' . $value . '</span></td>';
                                            } else {
                                                echo '<td class="export-visible" ><span data-toggle="tooltip" data-placement="left" title="VCS Not Done"  style="color:#E81919;">VCS NOT DONE</span></td>';
                                            }
                                        } else if ($key == "won_present") {

                                            if ($value >= 0) {
                                                echo '<td class="export-visible"><span title="All the Details Are Consistent" data-toggle="tooltip" data-placement="left"  style="color:#3B7A57;">' . $value . '</span></td>';
                                            } else {
                                                echo '<td class="export-visible" ><span data-toggle="tooltip" data-placement="left" title="VCS Not Done"  style="color:#E81919;">VCS NOT DONE</span></td>';
                                            }
                                        } else if ($key == "cem_schedule_date" || $key == "cem_time" || $key == "Cem_field_officer" || $key == "did_it_occur" || $key == "date_completed") {

                                            if ($value != null) {
                                                echo '<td class="export-visible" ><span title="All the Details Are Consistent" data-toggle="tooltip" data-placement="left"  style="color:#3B7A57;">' . $value . '</span></td>';
                                            } else {
                                                echo '<td class="export-visible" ><span data-toggle="tooltip" data-placement="left" title="CEM Not Done"  style="color:#E81919;">CEM NOT DONE</span></td>';
                                            }
                                        } else {
                                            echo '<td class="export-visible" style="">' . $value . '</td>';
                                        }
                                    }
                                }
                                // $i = 0;  
                            }
                            // $i = 1;
                            ?>

                            <td class="buttons"><a href="<?php echo URL ?>expansion/trackerData/<?php echo $table . "/" . $data[$i]['id'] . "/" . rawurlencode($program); ?>" class="btn btn-default btn-xs">Installation</a>
                                <a href="<?php echo URL ?>expansion/trackerData/<?php echo $table3 . "/" . $data[$i]['id'] . "/" . rawurlencode($program); ?>" class="btn btn-default btn-xs">Cem</a></td> 

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
                scrollX: "100%",
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Installation Details</h4>
            </div>
            <form  action="<?php echo URL; ?>expansion/dispenserInstallTrackAdd/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
<?php
foreach ($fields as $key => $value) {
    if ($value['Key'] == 'PRI') {
        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
    } elseif ($value['Key'] == 'MUL' && $value['Field'] == "country") {
        echo '
                                                                <div class="form-group">
                                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
        foreach ($value['parents'] as $key => $value_) {

            if ($value_['id'] == $_SESSION['country']) {
                echo'<option value="' . $value_['id'] . '" selected ><b>' . $value_[$value['Field']] . '</b></option>';
            } else {
                echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
            }
        }
        echo '</select>
                                                                </div>';
    } else if ($value['Key'] == 'MUL' && $value['Field'] == "full_name") {
        echo '
                                                                <div class="form-group">
                                                                <label>Field Officer\'s Name</label><br>
                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select Field Officer\'s Name</option>';
        foreach ($value['parents'] as $key => $value_) {
            echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
        }
        echo '</select>
                                                                </div>';
        echo '
                                                                <div class="form-group">
                                                                <label>CSA Responsible</label><br>
                                                                        <select id="csa_responsible" name="csa_responsible" class="form-control input-sm" required><option value="">Select CSA Responsible</option>';
        foreach ($value['parents'] as $key => $value_) {
            echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
        }
        echo '</select>
                                                                </div>';
    } else if ($value['Key'] == 'MUL') {
        echo '
                                        <div class="form-group">
                                        <label for="' . $value['Field'] . '" >' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
        foreach ($value['parents'] as $key => $value_) {
            echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
        }
        echo '</select>
                                        </div>';
    } else if (strpos($value['Field'], 'program') !== false) {
        echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                        <input type"text" name="' . $value['Field'] . '" class="form-control input-sm" value="' . $program . '" readonly/>
                                                                    </div>
                                                                        
                                                                        ';
    } else if (strpos($value['Field'], 'field_officer') !== false) {
        echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           ';
        foreach ($staffDropDown as $key => $value) {
            echo '<option value="' . $value['full_name'] . '">' . $value['full_name'] . '</option>';
        }

        echo '</select>
                                                                    </div>
                                                                        
                                                                        ';
    } else if ($value['Field'] == 'email') {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="email" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'problems_with_installation') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">Problems With Installation ? </label><br>
                                                           <textarea ' . ' name="' . $value['Field'] . '" class="form-control input-sm" style="max-width:300px;" ></textarea>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'initial_status') !== false || strpos($value['Field'], 'final_status') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                           <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                             <option value="Scheduled">Scheduled</option>
                                                             <option value="ReScheduled" >ReScheduled</option>
                                                             <option value="Not Scheduled" selected>Not Scheduled</option>
                                                             <option value="Complete">Complete</option>
                                                           </select>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'was_it_installed') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">Was It Installed ?</label><br>
                                                           <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                             <option value="YES">YES</option>
                                                             <option value="NO" selected>NO</option>
                                                             
                                                           </select>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'materials_mobilized') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">Were The Materials Mobilized ?</label><br>
                                                           <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                             <option value="BOTH">BOTH</option>
                                                             <option value="SAND" >SAND</option>
                                                             <option value="BALLAST">BALLAST</option>
                                                             <option value="NONE" selected>NONE</option>
                                                           </select>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'phone') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'csa_responsible') !== false) {
        echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           ';
        foreach ($staffDropDown as $key => $value) {
            echo '<option value="' . $value['full_name'] . '">' . $value['full_name'] . '</option>';
        }

        echo '</select>
                                                                    </div>
                                                                        
                                                                        ';
    } else if (strpos($value['Field'], 'contact') !== false) {
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
                    <button  type="submit" class="btn btn-primary" name="add-dInstall-data" id="add-dInstall-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>  
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add CEM Details</h4>
            </div>
            <form  action="<?php echo URL; ?>expansion/dispenserInstallTrackAdd/<?php echo $table3; ?>" data-async data-target="myModal2" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
<?php
foreach ($fields2 as $key => $value) {
    if ($value['Key'] == 'PRI') {
        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
    } elseif ($value['Key'] == 'MUL' && $value['Field'] == "country") {
        echo '
                                                                <div class="form-group">
                                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
        foreach ($value['parents'] as $key => $value_) {

            if ($value_['id'] == $_SESSION['country']) {
                echo'<option value="' . $value_['id'] . '" selected ><b>' . $value_[$value['Field']] . '</b></option>';
            } else {
                echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
            }
        }
        echo '</select>
                                                                </div>';
    } else if ($value['Key'] == 'MUL') {
        echo '
                                        <div class="form-group">
                                        <label for="' . $value['Field'] . '" >' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
        foreach ($value['parents'] as $key => $value_) {
            echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
        }
        echo '</select>
                                        </div>';
    } else if (strpos($value['Field'], 'program') !== false) {
        echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                        <input type"text" name="' . $value['Field'] . '" class="form-control input-sm" value="' . $program . '" readonly/>
                                                                    </div>
                                                                        
                                                                        ';
    } else if (strpos($value['Field'], 'rescheduled_field_officer') !== false) {
        echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           ';
        echo '<option value="None">None</option>';
        foreach ($staffDropDown as $key => $value) {
            echo '<option value="' . $value['full_name'] . '">' . $value['full_name'] . '</option>';
        }

        echo '</select>
                                                                    </div>
                                                                        
                                                                        ';
    } else if (strpos($value['Field'], 'field_officer') !== false) {
        echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           ';
        foreach ($staffDropDown as $key => $value) {
            echo '<option value="' . $value['full_name'] . '">' . $value['full_name'] . '</option>';
        }

        echo '</select>
                                                                    </div>
                                                                        
                                                                        ';
    } else if ($value['Field'] == 'email') {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="email" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
                                                    </div>
                                            ';
    } else if ($value['Field'] == 'rescheduled_field_officer_responsible') {
        continue;
    } else if (strpos($value['Field'], 'problems_with_installation') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">Problems With Installation ? </label><br>
                                                           <textarea ' . ' name="' . $value['Field'] . '" class="form-control input-sm" style="max-width:300px;" ></textarea>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'comment') !== false || strpos($value['Field'], 'why_failed') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                           <textarea ' . ' name="' . $value['Field'] . '" class="form-control input-sm" style="max-width:300px;" ></textarea>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'status') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">Did It Occur ? </label><br>
                                                           <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                             <option value="YES">YES</option>
                                                             <option value="NO" selected>NO</option>
                                                            
                                                           </select>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'was_it_installed') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">Was It Installed ?</label><br>
                                                           <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                             <option value="YES">YES</option>
                                                             <option value="NO" selected>NO</option>
                                                             
                                                           </select>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'materials_mobilized') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">Were The Materials Mobilized ?</label><br>
                                                           <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                             <option value="BOTH">BOTH</option>
                                                             <option value="SAND" >SAND</option>
                                                             <option value="BALLAST">BALLAST</option>
                                                             <option value="NONE" selected>NONE</option>
                                                           </select>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'phone') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'csa_responsible') !== false) {
        continue;
    } else if (strpos($value['Field'], 'contact') !== false) {
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
                    <button  type="submit" class="btn btn-primary" name="add-dInstall-data" id="add-dInstall-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>  

<!-- Modal ODK 1-->
<div class="modal fade" id="myODKModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add ODK Link</h4>
            </div>
            <form  action="<?php echo URL; ?>expansion/verificationODKAdd/<?php echo 'odk_installation/'.$program;?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                          <span>Example of a api key is highlighted: <font style="color:  blue">https://docs.google.com/spreadsheets/d/<font style="background-color: yellow">12ndptfZW_oHxkLJEHlkzG8ByJXwxU9f4ASB6OePCZ3k</font>/edit#gid=0</font></span>
                           
                            <div class="form-group">
                                <label for="apiKey">Api Key</label><br>
                                 <input id="apiKey" type="text" name="apiKey" class="form-control input-sm" value="<?php
                            if (isset($odkData[0]['api_key'])) {
                                echo $odkData[0]['api_key'];
                            } else {
                                echo 'No ODK Link Found for this Program';
                            } ?>" required/>
                            </div>
                            <div class="form-group">
                                <label for="Column">Column</label><br>
                                 <input id="column" type="text" name="column" class="form-control input-sm" required/>
                                 <input id="program" type="hidden" name="program" class="form-control input-sm" value="<?php echo $program; ?>" />
                                 
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

<!-- Modal ODK 2 -->
<div class="modal fade" id="myODKModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add ODK Link</h4>
            </div>
            <form  action="<?php echo URL; ?>expansion/verificationODKAdd/<?php echo 'odk_cem/'.$program;?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                          <span>Example of a api key is highlighted: <font style="color:  blue">https://docs.google.com/spreadsheets/d/<font style="background-color: yellow">12ndptfZW_oHxkLJEHlkzG8ByJXwxU9f4ASB6OePCZ3k</font>/edit#gid=0</font></span>
                           
                            <div class="form-group">
                                <label for="apiKey">Api Key</label><br>
                                 <input id="apiKey" type="text" name="apiKey" class="form-control input-sm" value="<?php
                            if (isset($odkData[0]['api_key'])) {
                                echo $odkData[0]['api_key'];
                            } else {
                                echo 'No ODK Link Found for this Program';
                            } ?>" required/>
                            </div>
                            <div class="form-group">
                                <label for="Column">Column</label><br>
                                 <input id="column" type="text" name="column" class="form-control input-sm" required/>
                                 <input id="program" type="hidden" name="program" class="form-control input-sm" value="<?php echo $program; ?>" />
                                 
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

<script type="text/javascript">
    $('#myModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');
    });
    $('#myModal2').on('show.bs.modal', function(e) {

        autoColumn(3, '#myModal2 .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');
    });
    function show_confirm(tables, deleteId, program) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>expansion/vcsVerificationTrackingDelete/' + tables + '/' + deleteId + '/' + program);

        } else {
            console.log('<?php echo URL ?>expansion/vcsVerificationTrackingDelete/' + tables + '/' + deleteId + '/' + program);
            return false;
        }
    }



</script>