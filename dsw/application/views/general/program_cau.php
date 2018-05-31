<?php $lastUrl = $generaldata_model->getLastURL($_SERVER['REQUEST_URI']); ?>
<div class="col-md-10 ">
  <?php if (isset($_GET['message'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php echo $_GET['message']; ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>

    <div id="data-table-manger">

        <div class="clearfix">
            <h3 class="pull-left"><?php 
            echo $tableName; ?></h3>

            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">
                    <!-- <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add</button> -->
                   
                     
                    <?php if ($table != "staff_list" && $table !="issues_category") { ?>
                     <button type="button" style='margin-right:10px;' class="btn btn-default pink-button" data-toggle="modal" data-target="#myImportModal">Import Details</button>
                    
                    <?php }  if ($table != "staff_list" || $table != "waterpoint_details") { ?>
                        <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add <?php //echo $tableName; ?>Details</button>
                    <?php } ?>
                   
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="table-responsive">

    
        <?php if (!empty($data)) { ?>

            <table id="data-table" class="table table-bordered table-striped table-hover">
                
                <thead>
                    <tr>
                    <th class="index">#</th>
                        <?php
                            foreach ($data[0] as $key => $value) {
                                if ($key == 'position' && $table != "staff_category") {
                                    continue;
                                }
                                if (!in_array($key, $arrayName = array('id','territory_id'))) {                                    
                                    if ($key == "country" || $key == "Country") {
                                        continue;
                                    } else {
                                        if ($_SESSION['country'] == 1 ) {
                                            if ($key == 'chw_name') {                        
                                                echo '<th class="export-visible">CHW Name</th>';
                                            } else if ($key == 'chw_contact') {                        
                                                echo '<th class="export-visible">CHW Contact</th>';
                                            } else {
                                                echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        } else if ($_SESSION['country'] == 2 ) {
                                            if ($key == 'chw_name') {                        
                                                echo '<th class="export-visible">VHT Name</th>';
                                            } else if ($key == 'chw_contact') {                        
                                                echo '<th class="export-visible">VHT Contact</th>';
                                            } else {
                                                echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        } else if ($_SESSION['country'] == 3 ) {
                                            if ($key == 'chw_name') {                        
                                                echo '<th class="export-visible">HSA Name</th>';
                                            } else if ($key == 'chw_contact') {                        
                                                echo '<th class="export-visible">HSA Contact</th>';
                                            } else {
                                                echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        }
                                    }
                                }
                            }
                        ?>
                        <?php if ($table != "staff_list") { ?>
                            <th class="buttons"></th>
                   
                        <?php } ?>
                    </tr>
                </thead>                

                <tfoot>
                    <tr>
                    <th class="index">#</th>
                        <?php
                            foreach ($data[0] as $key => $value) {
                                if ($key == 'position' && $table != "staff_category") {
                                    continue;
                                }
                                if (!in_array($key, $arrayName = array('id','territory_id'))) {                                    
                                    if ($key == "country" || $key == "Country") {
                                        continue;
                                    } else {
                                        if ($_SESSION['country'] == 1 ) {
                                            if ($key == 'chw_name') {                        
                                                echo '<th class="export-visible">CHW Name</th>';
                                            } else if ($key == 'chw_contact') {                        
                                                echo '<th class="export-visible">CHW Contact</th>';
                                            } else {
                                                echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        } else if ($_SESSION['country'] == 2 ) {
                                            if ($key == 'chw_name') {                        
                                                echo '<th class="export-visible">VHT Name</th>';
                                            } else if ($key == 'chw_contact') {                        
                                                echo '<th class="export-visible">VHT Contact</th>';
                                            } else {
                                                echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        } else if ($_SESSION['country'] == 3 ) {
                                            if ($key == 'chw_name') {                        
                                                echo '<th class="export-visible">HSA Name</th>';
                                            } else if ($key == 'chw_contact') {                        
                                                echo '<th class="export-visible">HSA Contact</th>';
                                            } else {
                                                echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        }
                                    }
                                }
                            }
                        ?>
                        <?php if ($table != "staff_list") { ?>
                            <th class="buttons"></th>
                        <?php } ?>
                    </tr>
                </tfoot>
                
                <tbody>

                    <?php
                        $i = 0;
                        foreach ($data as $key => $value) { ?>
                            <tr>
                            <td class="index"></td>
                            
                                <?php
                                foreach ($value as $key => $value) {
                                    // echo "<pre>";var_dump($key);echo "</pre>";         
                                    if ($key == 'position' && $table != "staff_category") {
                                        continue;
                                    }
                                    if ($i == 1) {
                                        $generalId = $value;
                                    }
                                    if (!in_array($key, $arrayName = array('id','territory_id'))) {

                                        if ($key == "country" || $key == "Country") {
                                            continue;
                                        } else {
                                         echo '<td class="export-visible">'.ucfirst($value).'</td>';
                                        }
                                    }
                                    // $i = 0;	
                                }
                                // $i = 1;
                                ?>
                                 
                                    <td class="buttons"><a onclick="show_confirm('cau_programs', <?php echo $data[$i]['id']; ?>); " class="btn btn-default btn-xs">Delete</a></td>    							
                               
                            </tr>
                        <?php $i++; }
                    ?>					
                </tbody>
            </table>

        <?php } else { ?>

            <p><b>No Record Found</b></p>

        <?php } ?>

    </div>
    <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="40px" style="position:absolute;top:50%;left:50%;margin:0 auto; visibility: visible"/>

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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add </h4>
            </div>
            <form  action="<?php echo URL; ?>generalclass/addCauProgram/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                                foreach ($fields as $key => $value) {

                                  

                                    if ($value['Key'] == 'PRI') {

                                        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                    } else if ($value['Field']=='country') {

                                        echo '<input type="hidden" name="'.$value['Field'].'" value="'.$_SESSION['country'].'" readonly/>';
                                    } else if ($value['Key'] == 'MUL' && $value['Field'] != 'country' && $value['Field'] != 'waterpoint_id') {
                                        echo '<div class="form-group">
                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                    <option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                    foreach ($value['parents'] as $key => $value_) {
                                                        echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                    }
                                                echo '</select>
                                            </div>';
                                    }  else if ($value['Field'] == 'program') {
                                        echo '
								            <div class="form-group">
								            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm"/>
											</div>
                                            ';

                                                 if(isset($cauDropDown)){
                                             echo '<div class="form-group">
                                                <label>Choose C.A.U</label><br>
                                                <select id="territory_id" name="territory_unknown" class="form-control input-sm">
                                                    <option value="">Select C.A.U</option>';
                                                    foreach ($cauDropDown as $key => $value) {
                                                        if($value['territory_name']=='village'){
                                                             echo'<option value="' . $value['id'] . '" >' .ucwords(str_replace('_', ' ', $value['territory_name']))  . '</option>';
                                                        }else{

                                                        }
                                                       
                                                    }
                                                echo '</select>
                                            </div>';
                                              echo '<div class="form-group">
                                                <label>Territory Name</label><br>
                                                <select id="territory_name" name="territory_id" class="form-control input-sm" required>
                                                 </select>
                                            </div>';

                                        }
                                    } else if (strpos($value['Field'], 'phone') !== false || strpos($value['Field'], 'population') !== false) {
                                        echo'<div class="form-group">
								            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
										      </div>
                                			';
                                    } else if (strpos($value['Field'], 'gender') !== false ) {
                                        echo'   <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Unknown">Unknown</option>
                                                        
                                                     </select>
                                                </div>
                                            ';
                                    } else if (strpos($value['Field'], 'name') !== false && ($value['Field'] == 'full_name' || $value['Field'] == 'name')) {
                                        echo '
								            <div class="form-group">
								            	<label>First Name</label><br>
												<input type="text" id="first_name" name="first_name" class="form-control input-sm" />
											</div>
                                		';
                                        echo '
								            <div class="form-group">
								            	<label>Middle Name</label><br>
												<input type="text" id="middle_name" name="middle_name" class="form-control input-sm" />
											</div>
										';
                                        echo '
        						            <div class="form-group">
        						            	<label>Last Name</label><br>
        										<input type="text" id="last_name" name="last_name" class="form-control input-sm"/>
        									</div>
        								';
                                        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                    } else if (strpos($value['Field'], 'date') !== false ) {
                                        echo '
								            <div class="form-group">
								            	<label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
											</div>
										';
                                    } else if ($value['Field'] == 'territory_id') {
                                        continue;
                                     } else {
                                        echo '
								            <div class="form-group">
								            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
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
                    <button  type="submit" class="btn btn-primary" name="add-general-data" id="add-general-data">Save</button>
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
            <form  action="<?php echo URL; ?>importclass/importCauPrograms/<?php echo $table.'/generalclass/cauPrograms'; ?>" enctype="multipart/form-data" data-async data-target="myModal" method="post" role="form" id="modal-form">
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
    $('#myModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');

    });

    function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>generalclass/deleteCau/' + tables + '/' + deleteId);
            console.log('<?php echo URL ?>generalclass/deleteCau/' + tables + '/' + deleteId);
         } else {
            console.log('<?php echo URL ?>generalclass/deleteCau/' + tables + '/' + deleteId);
            return false;
        }
    }

   
   $("#territory_id").change(function() {
   

    var getTerritories=encodeURIComponent($("#territory_id").find(":selected").text()).replace(/[!'()]/g, escape).replace(/\*/g, "%_A");
    var setTerritories=$("#territory_id").find(":selected").val();
   
    console.log(getTerritories);
           $.ajax({
        url: "<?php echo URL ?>generalclass/territoryCall/?info="+setTerritories,
        beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
        }
        })
        .done(function( data ) {
           data=jQuery.parseJSON(data);
        if ( console && console.log ) {
            
        console.log( "Sample of data:", data.slice( 0, 100 ) );
        }
          var counter=1;
        
        $("#territory_name").empty();
        
            
            $(data).each(function(){
                
              //We Need To Loop Through the select tag searching for any value matching the json values
           $("#territory_name").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["admin_territory_name"]+"</option>");    
            
            console.log("passed thru");
            console.log(data[counter-1]["office_location"]);
        if(counter<data.length){
        counter+=1;
    }
    })
        
        });

   }
   );
</script>