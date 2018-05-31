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
                    <?php if ($table != "staff_list") { ?>
                     <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add</button> 
                    <?php } ?>
                     
                    <?php if ($table != "staff_list" && $table !="issues_category") { ?>
                     <button type="button" style='margin-right:10px;' class="btn btn-default pink-button" data-toggle="modal" data-target="#myImportModal">Import Details</button>
                    
                    <?php }  if ($table != "staff_list" || $table != "waterpoint_details") { ?>
                        <!--<button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add <?php //echo $tableName; ?>Details</button>-->
                    <?php } ?>
                   
                </div>
            </div>
        </div>

        <hr>
    </div>

    <div class="table-responsive">
        <div class="row">
          <form method="POST" action="<?php echo URL.'generalclass/promoter/'; ?> ">
            <div class="form-group col-md-6" >
                
                    <label> Select A Program</label>
                    <select name="program" class=" input-sm" required>
                        <option value='All'>All Programs</option>
                        <?php
                        foreach ($progDropDown as $key => $value) {
                            if(isset($_POST['program']) && $_POST['program'] ==$value['program']){
                                 echo '<option value="'.$value['program'].'" selected>'.$value['program'].'</option>';
                             }else{
                                 echo '<option value="'.$value['program'].'">'.$value['program'].'</option>';
                             }


                            
                         } 
                        ?>
                    </select>

                <input type="submit" class="btn btn-default" name="callProgramDetails" value="Generate"/>
            </div>
           </form>
        </div>
    
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
                                if (!in_array($key, $arrayName = array('id'))) {                                    
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
                                if (!in_array($key, $arrayName = array('id'))) {                                    
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
                                    if (!in_array($key, $arrayName = array('id'))) {

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
                                 <?php if ($table != "staff_list") { ?>
                                    <td class="buttons"><a href="<?php echo URL ?>generalclass/update/<?php echo $table . "/" . $data[$i]['id']; ?>" class="btn btn-default btn-xs">Edit</a>
                                    <a onclick="show_confirm('<?php echo $program?>', <?php echo $data[$i]['id']; ?>); " class="btn btn-default btn-xs">Delete</a></td>    							
                                <?php } ?>
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
            scrollY: "300px",              
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add </h4>
            </div>
            <form  action="<?php echo URL; ?>generalclass/addPromoter/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
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
                                    } else if ($value['Field'] == 'program') {
                                        echo '<div class="form-group">
                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                    <option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                    foreach ($progDropDown as $key => $value_) {
                                                        echo'<option value="' . $value_['program'] . '" >' . $value_['program'] . '</option>';
                                                    }
                                                echo '</select>
                                            </div>';
                                    } else if ($value['Field'] == 'waterpoint_id' ) {
                                        echo'   <div class="form-group">
                                                    <label>Waterpoint</label><br>
                                                    <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                        <option value="">Select Waterpoint</option>';
                                                        foreach ($waterpoints as $key => $waterpoint) {
                                                            echo'<option value="' . $waterpoint['id'] . '" >' . $waterpoint['waterpoint_name'] . '</option>';
                                                        }                                                        
                                        echo'       </select>
                                                </div>';                                      
                                    } else if ($value['Field'] == 'email') {
                                        echo '
								            <div class="form-group">
								            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="email" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
											</div>
                                            ';
                                    }else if (strpos($value['Field'], 'sms_code') !== false || strpos($value['Field'], 'population') !== false) {
                                        echo'<div class="form-group">
                                              
                                                <input type="hidden" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" readonly />
                                              </div>
                                            ';
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
                                    } else if ($value['Field'] == 'chw_name') {

                                        if ($_SESSION['country']==1) {
                                            $label = 'CHW Name';
                                        } else if ($_SESSION['country']==2) {
                                            $label = 'VTH Name';
                                        } else if ($_SESSION['country']==3) {
                                            $label = 'HSA Name';
                                        }

                                        echo '
                                            <div class="form-group">
                                                    <label>' . $label . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                </div>
                                            ';
                                    } else if ($value['Field'] == 'chw_contact') {

                                        if ($_SESSION['country']==1) {
                                            $label = 'CHW Contact';
                                        } else if ($_SESSION['country']==2) {
                                            $label = 'VTH Contact';
                                        } else if ($_SESSION['country']==3) {
                                            $label = 'HSA Contact';
                                        }
                                        echo '
                                                <div class="form-group">
                                                    <label>' . $label . '</label><br>
                                                    <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                </div>
                                            ';
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
                    <button  type="submit" class="btn btn-primary" name="add-promoter-data" id="add-promoter-data">Save</button>
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
            <form  action="<?php echo URL; ?>importclass/import/<?php echo $table.'/generalclass/promoter/'; ?>" enctype="multipart/form-data" data-async data-target="myModal" method="post" role="form" id="modal-form">
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

    function show_confirm(program, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>generalclass/deletePromoter/' + program + '/' + deleteId);
            console.log('<?php echo URL ?>generalclass/deletePromoter/' + program + '/' + deleteId);
         } else {
            console.log('<?php echo URL ?>generalclass/deletePromoter/' + program + '/' + deleteId);
            return false;
        }
    }

   

    // $('#myModal').on('click','#add-admin-data', function(event) {

    //     var $form = $('#myModal form');
    //     var $target = $($form.attr('data-target'));

    //     $.ajax({
    //         type: $form.attr('method'),
    //         url: $form.attr('action'),
    //         data: $form.serialize(),

    //         success: function(data, status) {
    //         	if ( status == 'success') {
    //             	$('#message').html('<p class="bg-success"><span class="glyphicon glyphicon-ok-circle" ></span> Data Successfully Added</p>');
    //             	$('#myModal form').get(0).reset();
    //         	} else {
    //             	$('#message').html('<p class="bg-danger"><span class="glyphicon glyphicon-remove-circle" ></span> Error Adding Data</p>');
    //         	}
    //         }
    //     });

    //     event.preventDefault();
    // });
</script>