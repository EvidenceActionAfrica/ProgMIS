<div class="col-md-10">

    <div id="data-table-manger">

        <div class="clearfix">

            <h3 class="pull-left"><?php echo ucwords(str_replace("_", " ", $meta['territory_name'])) . ' List'; ?></h3>

            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">
                    <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add</button>
                    <a href="<?php echo URL; ?>caumanager/import" class="btn btn-default pink-button" >Import</a>
                </div>
            </div>

        </div>

        <hr>

    </div>

    <div class="table-responsive">
        <?php if (!empty($data)) { ?>

            <div id="imgLoading"></div>

            <table id="data-table" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="index"></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key != 'id' && $key != 'admin_territory_id' && $key != 'territory_parent_id' && $key != 'territory_name') {
                                ?>                            
                                <th class="export-visible"><?php echo ucwords(str_replace("_", " ", $key)); ?></th>
                            <?php
                            }
                        }
                        ?>
                        <th class="buttons" ></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="export-visible index"></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key != 'id' && $key != 'admin_territory_id' && $key != 'territory_parent_id' && $key != 'territory_name') {
                                ?>                            
                                <th class="export-visible"><?php echo ucwords(str_replace("_", " ", $key)); ?></th>
        <?php
        }
    }
    ?>
                        <th class="buttons" ></th>
                    </tr>
                </tfoot>
                <tbody>
                        <?php foreach ($data as $key => $value) { ?>
                        <tr>
                            <td class="index"></td>
                            <?php
                            foreach ($data[0] as $key_2 => $value_2) {
                                if ($key_2 != 'id' && $key_2 != 'admin_territory_id' && $key_2 != 'territory_parent_id') {
                                    ?>
                                    <td><?php echo $value[$key_2]; ?></td>
            <?php
            }
        }
        ?>
                            <td class="buttons" >
                                <div class="btn-group">
                                    <a href="<?php echo URL; ?>caumanager/edit/<?php echo $admin_territory_id; ?>/<?php echo $value['id']; ?>" class="btn btn-xs btn-default">Edit</a>
                                    <a href="<?php echo URL; ?>caumanager/delete/<?php echo $admin_territory_id; ?>/<?php echo $value['id']; ?>" class="btn btn-xs btn-default">Delete</a>
                                </div>
                            </td>
                        </tr>
    <?php } ?>					
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
        //console.log(visiblecols.toString());
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
                        oSelectorOpts: {
                            
                            filter: 'applied'
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


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <form action="<?php echo URL; ?>caumanager/add" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="name_territory" value="<?php echo ucwords(str_replace("_", " ", $meta['territory_name'])); ?>">
                            <input type="hidden" name="admin_territory_id" value="<?php echo $admin_territory_id; ?>">                            
                                    <?php if ($cauList == null && $admin_territory_id == $highestlevel) { ?> 
                                <input type="hidden" name="territory_parent" value="0">
                                    <?php } else { ?>
                                <div class="form-group">
                                                 <?php
                                    
                                        foreach ($cauList as $key => $value) {
                                        
                                      
                                          echo '<label>Select '. ucwords(str_replace("_", " ", $value['territory_name'])).'</label>';
                                           echo '<select ';
                                           echo 'id="'.$value['territory_name'].'ajax"';
                                           if($value['territory_name']==$meta['parent_territory_name']){
                                            echo 'name="territory_parent" required';
                                           }
                                           echo ' class="form-control">';
                                           echo ' <option value="" >Select '.ucwords(str_replace("_", " ", $value['territory_name'])).'</option>';
                                           if(isset($ListedCaus[$value['territory_name']])){
                                               foreach ($ListedCaus[$value['territory_name']] as $key2 => $value2) {
                                                    echo '<option value="'.$value2['id'].'">'.$value2['territory_name'].'</option>';

                                                  
                                                
                                               }
                                            }
                                           echo '</select>';
                                           
                                    
                                        }
                                    ?>
                                </div>
<?php } ?>
                            <div class="form-group">
                                <label><?php echo ucwords(str_replace("_", " ", $meta['territory_name'])); ?> Name</label>
                                <input type="text" name="admin_territory_name" value="" class="form-control" required>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-territory" id="add-territory">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>  

<script type="text/javascript">
    function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>adminData/delete/' + tables + '/' + deleteId);

        } else {
            console.log('<?php echo URL ?>adminData/delete/' + tables + '/' + deleteId);
            return false;
        }
    }
<?php
$territoryArray=array();
//echo '   var territoryArray=[]';
 foreach ($cauList as $key => $value) {   
  //  echo 'territoryArray.push("'.$value['territory_name'].'");';
array_push($territoryArray,$value['territory_name']);

 }
 array_pop($cauList);
 $i=0;
  foreach ($cauList as $key => $value) {   
   // echo 'territoryArray.push("'.$value['territory_name'].'"); ';
 
?>
       $("#<?php echo $value['territory_name']; ?>ajax").change(function() {
        document.getElementById('imgLoading').style.visibility = 'visible';
  //      console.log("<?php echo URL ?>generalclass/ajaxChildCau/<?php echo $territoryArray[$i+1]; ?>/<?php echo $value['territory_name'];?>/"+$("#<?php echo $value['territory_name'] ?>ajax").find(":selected").val());
          $.ajax({
        url: "<?php echo URL ?>generalclass/ajaxChildCau/<?php echo $territoryArray[$i+1]; ?>/<?php echo $value['territory_name'];?>/"+$("#<?php echo $value['territory_name'] ?>ajax").find(":selected").val(),
        beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
        }
        })
        .done(function( data ) {
           data=jQuery.parseJSON(data);
     // if ( console && console.log ) {
            
     //    console.log( "Sample of data:", data.slice( 0, 100 ) );
        
     //    }
        var counter=1;
        
        $("#<?php echo $territoryArray[$i+1]; ?>ajax").empty();
        
            $("#<?php echo $territoryArray[$i+1]; ?>ajax").append("<option value=''></option>");
            $(data).each(function(){
                
              //We Need To Loop Through the select tag searching for any value matching the json values
           $("#<?php echo $territoryArray[$i+1]; ?>ajax").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["admin_territory_name"]+"</option>");    
            
           // console.log("passed thru");
          //  console.log(data[counter-1]["admin_territory_name"]);
        if(counter<data.length){
        counter+=1;
    }
    })
             document.getElementById('imgLoading').style.visibility = 'hidden';
    })
    });
<?php
++$i;

}
?>
</script>