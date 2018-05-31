<?php $lastUrl = $expansionmodel->getLastURL($_SERVER['REQUEST_URI']); ?>
<div class="col-md-10">

      <?php if (isset($message)) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php 
                echo $message;
            ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
      <?php } ?>
    <div id="data-table-manger">
    <h3>Planned Dispenser Installation Schedules</h3>
        <hr>
    </div>

    <div class="table-responsive">
        <?php if (!empty($data)) { ?>

            <table id="data-table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
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
                       
                        <th class="buttons"></th>
                        <th class="buttons"></th>
                        <th class="buttons"></th>
                        <th class="buttons"></th>
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
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
                       
                        <th class="buttons"></th>
                        <th class="buttons"></th>
                        <th class="buttons"></th>
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
                                        echo '<td class="export-visible">' . $value . '</td>';
                                    }
                                }
                             
                            }
                           
                           
                            ?>
                                <td class="buttons"><a target="blank" href="<?php echo URL ?>expansion/pdfDispenserFo/<?php echo  rawurlencode($data[$i]['program']); ?>" class="btn btn-default btn-xs" >F.O <br/>Schedule</a></td> 
                                <td class="buttons"><a target="blank" href="<?php echo URL ?>expansion/pdfDispenser/<?php echo  rawurlencode($data[$i]['program']); ?>" class="btn btn-default btn-xs">Installation<br/> Budget</a></td> 
                                <td class="buttons"><a href="<?php echo URL ?>scheduler/planSchedule/dispenser_gen_schedule/<?php echo  rawurlencode($data[$i]['program']); ?>" class="btn btn-default btn-xs">Edit<br/> Schedule</a></td> 
                                <td class="buttons"><a href="<?php echo URL ?>expansion/dispenserCompleteUpdate/dispenser_installation_schedule/<?php echo  $data[$i]['id']; ?>" class="btn btn-default btn-xs">Edit</a>
                                    <a onclick="show_confirm('dispenser_installation_schedule', <?php echo $data[$i]['id']; ?>);" class="btn btn-default btn-xs">Delete</a></td>    							
                          
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
        $('#data-table tfoot th').each( function () {
            var title = $('#data-table thead th').eq( $(this).index() ).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );

        
        var visiblecols = [];
        $( '#data-table thead th').each( function(e){
            if ($(this).hasClass('export-visible') ) {
                visiblecols.push($(this).index());
            }
        });

        var table = $('#data-table').DataTable( {
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
                        oSelectorOpts: { filter: 'applied', order: 'current' },
                        mColumns: visiblecols
                    }
                ]
            },
            columnDefs: [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            order: [[ 1, 'asc' ]]
        } );

        // Apply the search
        table.columns().eq( 0 ).each( function ( colIdx ) {
            $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
                table
                    .column( colIdx )
                    .search( this.value )
                    .draw();
            } );
        } );
     
        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

    });
</script>



<script type="text/javascript">


    function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>expansion/dispenserCompleteDelete/' + tables + '/' + deleteId);

        } else {
            console.log('<?php echo URL ?>expansion/dispenserCompleteDelete/' + tables + '/' + deleteId);
            return false;
        }
    }

   // $('form').validate();

</script>