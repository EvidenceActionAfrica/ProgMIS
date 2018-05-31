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
                   
                     
                    <?php
                     if($table !='field_office'){
                        echo '<button type="button" style="margin-right:10px;" 
                        class="btn btn-default pink-button" data-toggle="modal" data-target="#myImportModal">Import Details</button>';
                     }
                    ?>                    
                    <?php  if ($table != "staff_list" ) { ?>
                        <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add <?php //echo $tableName; ?>Details</button>
                    <?php } ?>
                   
                </div>
            </div>
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
                            }
                        ?>
                      
                            <th></th>
                       
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($data)) { ?>
                    <?php
                        $i = 0;
                        foreach ($data as $key => $value) { ?>
                            <tr>
                           
                            
                                <?php
                                foreach ($value as $key2=> $value3) {
                                  
                                    if (!in_array($key2, $arrayName = array('id'))) {

                                        if ($key2 == "country" || $key2 == "Country") {
                                            continue;
                                        }else if ($key2 == "territory_id") {
                                           
                                            foreach ($cauManage as $key3 => $value4) {
                                                if($value3==$value4['id']){
                                                    echo '<td style="text-align:center">' .ucwords(str_replace('_', ' ', $value4['territory_name'] )) . '</td>';
                                                }
                                            }

                                        }else{
                                            echo '<td style="text-align:center">' .ucwords(str_replace('_', ' ', $value3)). '</td>';
                                        }


                                    }
                                  
                                }
                            
                                ?>
                                        <td><a onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>);"><button class="btn btn-default btn-xs">Delete</button></a></td>    							
                              
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

      
        $('#data-table').DataTable( {
            scrollX: "100%",              
            scrollCollapse: false,           
         
        } );

        

    });
</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add A Territory</h4>
            </div>
            <form  action="<?php echo URL; ?>generalclass/addAdminModuleManager/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
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
                                    } else if ($value['Key'] == 'MUL' && $value['Field'] != 'country') {
                                        echo '<div class="form-group">
                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                    <option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                    foreach ($value['parents'] as $key => $value_) {
                                                        echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                    }
                                                echo '</select>
                                            </div>';
                                    }else if (strpos($value['Field'], 'date') !== false ) {
                                        echo '
								            <div class="form-group">
								            	<label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
											</div>
										';
                                    }else if(strpos($value['Field'], 'table_name') !== false ){
                                        echo '
                                            <div class="form-group">
                                                <label>' . ucwords(str_replace('_', ' ', 'Admin Lists')) . '</label><br>
                                                 <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                    <option value="">Select List</option>
                                                  <option value="waterpoint_details">Waterpoint List</option>
                                                  <option value="promoter_details">Promoter Contacts</option>
                                                    </select>  
                                                ';
                                    }else if(strpos($value['Field'], 'territory_id') !== false ){
                                        echo '
                                            <div class="form-group">
                                                <label>' . ucwords(str_replace('_', ' ', 'Territory Name')) . '</label><br>
                                                 <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                    <option value="">Select Territory Name</option>';
                                                    foreach ($cauManage as $key => $value_) {
                                                        echo'<option value="' . $value_['id'] . '" >' . ucwords(str_replace('_', ' ', $value_['territory_name'])) . '</option>';
                                                    }
                                                echo '</select>';
                                    }else {
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
            <form  action="<?php echo URL; ?>importclass/import/<?php echo $table.'/generalclass/general'; ?>" enctype="multipart/form-data" data-async data-target="myModal" method="post" role="form" id="modal-form">
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

        autoColumn(2, '#myModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');

    });

    function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>generalclass/deleteAdminModuleManager/' + tables + '/' + deleteId);
            console.log('<?php echo URL ?>generalclass/deleteAdminModuleManager/' + tables + '/' + deleteId);
         } else {
            console.log('<?php echo URL ?>generalclass/deleteAdminModuleManager/' + tables + '/' + deleteId);
            return false;
        }
    }

   

  
</script>