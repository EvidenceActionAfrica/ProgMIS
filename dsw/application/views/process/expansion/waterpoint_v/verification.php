
<div class="col-md-10">

<h3>Planned Verifications</h3><br/>
    <div class="table-responsive">
        <?php if (!empty($data)) { ?>

            <table id="data-table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="index">#</th>
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
                        <th>Schedules</th>
                        <th class="buttons"></th>
                        <th class="buttons"></th>
                      
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="index"></th>
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
                        <th>Schedules</th>
                        <th class="buttons"></th>
                        <th class="buttons"></th>
                      
                     
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($data as $key => $value) {
                        ?>
                        <tr>
                            <td class="index"></td>
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
                           
                            <td class="buttons"><a target="blank" href="<?php echo URL ?>expansion/pdfSiteVerification/<?php echo  urlencode($data[$i]['program']); ?>" class="btn btn-default btn-xs btn-block">F.O <br/>Schedule</a>
                                 <a target="blank" href="<?php echo URL ?>expansion/pdfVillageVerification/<?php echo  urlencode($data[$i]['program']); ?>" class="btn btn-default btn-xs btn-block">Daily <br/>Budget</a>
                           </td> 
                            <td class="buttons">
                                <a href="<?php echo URL ?>scheduler/planSchedule/site_v_schedule/<?php echo urlencode($data[$i]['program']); ?>" class="btn btn-default btn-xs btn-block">Edit<br/> Schedule</a>
                            </td> 
                            <td class="buttons">
                                <a onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>);" class="btn btn-default btn-xs btn-block">Delete</a>
                                <a href="<?php echo URL ?>expansion/sVerificationCompleteUpdate/<?php echo $table . "/" . $data[$i]['id']; ?>" class="btn btn-default btn-xs btn-block">Edit</a>
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
   // $('form').validate();
       /*      
                $("#village").change(function() {
               // console.log($("#category").find(":selected").text());
                
          $.ajax({
        url: "<?php echo URL ?>processdata/expansion/AJAX_LOAD/waterpoint_details_kenya/"+$("#village").find(":selected").val()+'/waterpoint_id/id',
        beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
        }
        })
        .done(function( data ) {
           data=jQuery.parseJSON(data);
        if ( console && console.log ) {
            
       // console.log( "Sample of data:", data.slice( 0, 100 ) );
        
        }
        var counter=1;
        
         
        $("#waterpoint_id").val("");
        
        $("#waterpoint_id").val(data[0]['waterpoint_id']);    
        
    });
        });  
 
      
*/

</script>