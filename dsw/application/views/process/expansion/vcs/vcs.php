<?php $lastUrl = $expansionmodel->getLastURL($_SERVER['REQUEST_URI']); ?>
<div class="col-md-10">
    <div id="data-table-manger">

       <h3>Planned VCS</h3><br/>
        <hr>
    </div>

    <div class="table-responsive">
        <?php if (!empty($data)) { ?>

            <table id="data-table" class="table table-bordered  table-striped table-hover">
                <thead>
                    <tr>
                        <th class='index'></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' && $table != "staff_category") {
                                continue;
                            }
                            if (!in_array($key, $arrayName = array('id'))) {

                                if ($key == "country" || $key == "Country") {
                                    continue;
                                }else if($key=='full_name') {
                                    echo '<th class="export-visible">Field Officer</th>';
                                } else {
                                    echo '<th class="export-visible" >' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                        }
                        ?>
                        
                            <th class="buttons">Schedule</th>
                            <th class="buttons"></th>
                            <th class="buttons"></th>
                        </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class='index'></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' && $table != "staff_category") {
                                continue;
                            }
                            if (!in_array($key, $arrayName = array('id'))) {

                                if ($key == "country" || $key == "Country") {
                                    continue;
                                }else if($key=='full_name') {
                                    echo '<th class="export-visible">Field Officer</th>';
                                } else {
                                    echo '<th class="export-visible" >' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                        }
                        ?>
                        
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
                            <td class='index'></td>
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
                                // $i = 0;	
                            }
                            // $i = 1;
                           
                            ?>
                                <td class="buttons"><a target="blank" href="<?php echo URL ?>expansion/pdfVcsFo/<?php echo  $data[$i]['program']; ?>" class="btn btn-default btn-xs" >Field Officer</a> 
                                <a target="blank" href="<?php echo URL ?>expansion/pdfVcs/<?php echo  $data[$i]['program']; ?>" class="btn btn-default btn-xs" >Budget </a></td> 
                                 <td class="buttons" ><a href="<?php echo URL ?>scheduler/planSchedule/vcs_gen_schedule/<?php echo  $data[$i]['program']; ?>" class="btn btn-default btn-xs" >Edit Schedule</a></td> 
                                <td class="buttons"><a href="<?php echo URL ?>expansion/vcsVerificationCompleteUpdate/<?php echo $table . "/" . $data[$i]['id']; ?>" class="btn btn-default btn-xs" >Edit</a> 
                                <a onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>);" class="btn btn-default btn-xs" >Delete</a></td>    							
                          
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
        //console.log(visiblecols.toString());
        var table = $('#data-table').DataTable( {
            scrollY: "500px",            
            scrollCollapse: true,           
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
    $('#myModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');

    });

    function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>expansion/vcsVerificationCompleteDelete/' + tables + '/' + deleteId);

        } else {
            console.log('<?php echo URL ?>expansion/vcsVerificationCompleteDelete/' + tables + '/' + deleteId);
            return false;
        }
    }

   // $('form').validate();

</script>