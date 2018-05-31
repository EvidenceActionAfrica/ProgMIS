<?php $lastUrl = $expansionmodel->getLastURL($_SERVER['REQUEST_URI']); ?>
<div class="col-md-10">
    <div id="data-table-manger">

        <div class="clearfix">
            <h3 class="pull-left"><?php echo $tableName; ?></h3>
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
                            if ($key == 'lsm_id') {
                                continue;
                            }
                             
                            if (!in_array($key, $arrayName = array('id'))) {

                                if ($key == "full_name") {
                                    echo '<th>Staff Name</th>';
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
                    $totalCost=0;
                    // echo "<pre>";var_dump($data);echo "</pre>";
                    foreach ($data as $key => $value) {
                        ?>
                        <tr>
                            <?php
                            foreach ($value as $key => $value) {
                                if($key=='cost'){
                                    $totalCost+=$value;
                                }
                                if ($key == 'lsm_id') {
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
                            }
                           
                            ?>
                              
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>	
                    <tfoot style='font-weight:bolder;'>
                        <?php
                        if($table=='lsm_budget_details'){
                            echo '<td>Total Cost</td>';
                            echo '<td>'.$totalCost.'</td>';
                        }
                        ?>
                    </tfoot>				
                </tbody>
            </table>

        <?php } else { ?>

            <p><b>No Record Found</b></p>

        <?php } ?>

    </div>

</div>
<script type="text/javascript">
$.fn.dataTable.TableTools.defaults.aButtons = [ "copy", "csv", "xls","pdf" ]; 

    $(document).ready(function() {
        $('#data-table').dataTable({
            "scrollY": "100%",
            "scrollX": "100%",
            "scrollCollapse": false,
            "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "<?php echo URL; ?>public/swf/copy_csv_xls_pdf.swf"
        }

        });
    });

    $('#myModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');

    });

 

   // $('form').validate();
</script>