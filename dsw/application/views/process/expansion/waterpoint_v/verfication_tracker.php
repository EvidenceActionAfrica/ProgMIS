
<div class="col-md-10">

<h3>Tracking Verification Schedules</h3><br/>
    <div class="table-responsive">
        <?php if (!empty($data)) { ?>

            <table id="data-table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>

                        <th></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            
                            if (!in_array($key, $arrayName = array('id'))) {

                                if ($key == "country" || $key == "Country") {
                                    continue;
                                }else {
                                     if($key=="full_name"){
                                    $key='Staff Name';
                                        }
                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                        }
                       
                        ?>
                        <th class="buttons">Expand</th>
                        
                    </tr>
                </thead>
                 <tfoot>
                    <tr>
                        <th></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            
                            if (!in_array($key, $arrayName = array('id'))) {

                                if ($key == "country" || $key == "Country") {
                                    continue;
                                }else {
                                     if($key=="full_name"){
                                    $key='Staff Name';
                                        }
                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                        }
                       
                        ?>
                        <th class="buttons">Expand</th>
                        
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($data as $key => $value) {
                        ?>
                        <tr>
                            <td></td>
                            <?php
                            foreach ($value as $key => $value) {                                
                                if (!in_array($key, $arrayName = array('id'))) {

                                    if ($key == "country" || $key == "Country") {
                                        continue;
                                    } else {
                                        echo '<td class="export-visible">' . $value . '</td>';
                                    }
                                }
                            }
                         
                 
                            ?>
                           
                             <td class="buttons"><a  href="<?php echo URL ?>expansion/trackVerification/<?php echo  rawurlencode($data[$i]['program']); ?>" class="btn btn-default btn-xs">View Data</a></td> 
                            
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
    location.replace('<?php echo URL ?>expansion/sVerificationCompleteDelete/' + tables + '/' + deleteId);

} else {
    return false;
}
}


</script>