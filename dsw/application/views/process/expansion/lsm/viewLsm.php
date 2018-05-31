<div class="col-md-10">
    <div id="data-table-manger">

        <div class="clearfix">
            <h3 class="pull-left"><?php echo $tableName; ?></h3>
    </div>
        <hr>
    </div>

    <div class="table-responsive">
        <?php if (!empty($data)) { ?>

            <table id="data-table" class="table table-bordered table-striped table-hover">
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
                        
                            <th class="buttons"></th>
                            <th class="buttons"></th>
                            <th class="buttons"></th>
                            <th class="buttons"></th>
                            <th class="buttons"></th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($data as $key => $value) {
                        ?>
                        <tr>
                            <?php
                            foreach ($value as $key => $value) {
                              
                               
                                if (!in_array($key, $arrayName = array('id'))) {

                                    if ($key == "country" || $key == "Country") {
                                        continue;
                                    } else {
                                        echo '<td>' . $value . '</td>';
                                    }
                                }
                            }
                           
                            ?>
                                <td class="buttons"><a href="<?php echo URL.'expansion/pdfLSMBudget/'.$data[$i]['id']; ?>" class="btn btn-default btn-xs">Export Budget</a></td> 
                                <td class="buttons"><a href="<?php echo URL .'expansion/pdfLSMDuty/'.$data[$i]['id']; ?>" class="btn btn-default btn-xs">Export Duties</a></td> 
                                <td class="buttons"><a href="<?php echo URL .'expansion/pdfLSM/'.$data[$i]['id']; ?>" class="btn btn-default btn-xs">Export LSM</a></td> 
                                <td class="buttons"><a href="<?php echo URL ?>expansion/updateLsm/<?php echo $table . "/" . $data[$i]['id'].'/complete'; ?>" class="btn btn-default btn-xs">Edit</a></td> 
                                <td class="buttons"><a onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>);" class="btn btn-default btn-xs">Delete</a></td>    							
                          
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

    $('#myModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');

    });

    function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
                location.replace('<?php echo URL ?>expansion/LsmDelete2/' + tables + '/' + deleteId);
                console.log('<?php echo URL ?>expansion/LsmDelete2/' + tables + '/' + deleteId);
             } else {
                return false;
            }
    }
</script>