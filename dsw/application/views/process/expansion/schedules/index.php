<?php $lastUrl = $scheduleModel->getLastURL($_SERVER['REQUEST_URI']); ?>

<div class="col-md-10">
    <div id="data-table-manger">
        <?php if (isset($_GET['message'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php 
                echo $_GET['message'];
            ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
      <?php } ?>
        <div class="clearfix">
            <h3 class="pull-left">Current Program:&nbsp; <?php echo $program; ?> &nbsp; Stage:<?php echo $stage; ?></h3>
            <p style="clear:both;"></p>
            <div class="btn-group pull-left">
             
                <a href="<?php echo URL.'scheduler/'.$category.'/'.$destinationTable.'/'.$program;?>" class="btn btn-default" >Populate Schedule</a>
                &nbsp;
                 <a href="<?php echo URL.'scheduler/emptySchedule/'.$destinationTable.'/'.$program;?>" class="btn btn-default" >Empty Schedule</a>
            </div>
            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">
                    <!-- <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add</button> -->
                    <?php if ($desiredCau !=null) { ?>
                        <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add <?php echo $stage; ?></button>
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
                            if(in_array($key, $cauManage) || in_array($key, $fieldsArray)){

                           
                            if (!in_array($key, $arrayName = array('id'))) {

                                if ($key == "country" || $key == "Country" || $key == "village_name") {
                                    continue;
                                } else if ($key == "chw_contact" && $_SESSION['country']==3){
                                    echo '<th class="export-visible" >HSA Contact</th>';
                                
                                } else if ($key == "chw_contact" && $_SESSION['country']==2){
                                    echo '<th class="export-visible" >VHT Contact</th>';
                                
                                } else if ($key == "chw_name" && $_SESSION['country']==3){
                                    echo '<th class="export-visible">HSA Name</th>';
                                
                                } else if ($key == "chw_name" && $_SESSION['country']==2){
                                    echo '<th class="export-visible">VHT Name</th>';
                                
                                } else if($key=="allowance") {
                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', 'funds_given_per_fo')) . '</th>';
                                } else {
                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                             }
                        }
                        ?>
                        
                            <th class="buttons"></th>
                 
                        
                    </tr>
                </thead>
                  <tfoot>
                    <tr>
                        <th class="index"></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' && $table != "staff_category") {
                                continue;
                            }
                            if(in_array($key, $cauManage) || in_array($key, $fieldsArray)){

                           
                            if (!in_array($key, $arrayName = array('id'))) {

                                if ($key == "country" || $key == "Country" || $key == "village_name") {
                                    continue;
                                } else if ($key == "chw_contact" && $_SESSION['country']==3){
                                    echo '<th class="export-visible">HSA Contact</th>';
                                
                                } else if ($key == "chw_contact" && $_SESSION['country']==2){
                                    echo '<th class="export-visible">VHT Contact</th>';
                                
                                } else if ($key == "chw_name" && $_SESSION['country']==3){
                                    echo '<th class="export-visible">HSA Name</th>';
                                
                                } else if ($key == "chw_name" && $_SESSION['country']==2){
                                    echo '<th class="export-visible">VHT Name</th>';
                                
                                } else if($key=="allowance") {
                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', 'funds_given_per_fo')) . '</th>';
                                } else {
                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                             }
                        }
                        ?>
                        
                            <th class="buttons"></th>
                 
                        
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                  
                    // echo "<pre>";var_dump($data);echo "</pre>";
                    foreach ($data as $key => $value2) {
                        ?>
                        <tr><td></td>
                            <?php
                            foreach ($value2 as $key => $value) {
                               if(in_array($key, $cauManage) || in_array($key, $fieldsArray)){
                                if (!in_array($key, $arrayName = array('id'))) {
                                        if($key == "country" || $key == "Country" || $key == "village_name"){
                                            continue;
                                        }else if( strpos($key,'allowance')!=false && ($value=='' || $value==0)){
                                        echo '<td class="export-visible" style="text-align:center"><i>Nil</i></td>';
                                        }else{
                                        echo '<td class="export-visible" style="text-align:center">' . $value . '</td>';
                                        }
                                }
                            }
                                // $i = 0;	
                            }
                            
                            ?>
                               <td class="buttons"><a href="<?php echo URL.'scheduler/updateSchedule/'.$table.'/'.$value2['id'].'/'.$program ?>" class="btn btn-default btn-xs">Edit</a>
                               <a onclick="show_confirm('<?php echo $table; ?>','<?php echo $value2['id']; ?>','<?php echo $program; ?>')" class="btn btn-default btn-xs">Delete</a></td>

                            </tr>
                        <?php
                       
                    }
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
 <?php if (!empty($data)) { ?>
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
<?php }?>
</script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo "Add " . $stage . ""; ?></h4>
            </div>
            <form  action="<?php echo URL; ?>scheduler/addSchedule/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                         
                            foreach ($fields as $key => $value) {
                                if ($value['Key'] == 'PRI') {
                                    echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                } else if ($value['Key'] == 'MUL') {
                                    echo '
                                        <div class="form-group">
                                        <label for="' . $value['Field'] . '" >' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                foreach ($value['parents'] as $key => $value_) {
                                                    echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                }
                                                echo '</select>
                                        </div>';
                                } else if ($value['Field'] == 'email') {
                                    echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="email" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
                                                    </div>
                                            ';
                                }else if (strpos($value['Field'], 'field_officer') !== false) {
                                                                echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           '; 
                                                                                           foreach ($staffDropDown as $key => $value) {
                                                                                               echo '<option value="'.$value['full_name'].'">'.$value['full_name'].'</option>';
                                                                                           }

                                                                                    echo '</select>
                                                                    </div>
                                                                        
                                                                        ';
                                }else if (strpos($value['Field'], 'village') !== false && $value['Field'] !="village_elder") {
                                        echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           '; 
                                                                                           foreach ($villageDropDown as $key => $value) {
                                                                                               echo '<option value="'.$value['id'].'">'.$value['admin_territory_name'].'</option>';
                                                                                           }

                                                                                    echo '</select>
                                                                    </div>
                                                                        
                                                                        ';
                                }else if (strpos($value['Field'], 'program') !== false) {
                                    echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm"  value="'.$program.'"  readonly/>
                                                    </div>
                                            ';
                                } else if (strpos($value['Field'], 'phone') !== false) {
                                    echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                    </div>
                                            ';
                                }else if (strpos($value['Field'], 'chw_contact') !== false) {

                                        if($_SESSION['country']==1){
                                            $title='chw_contact';
                                        }else if($_SESSION['country']==2){
                                            $title='vht_contact';
                                        }else{
                                              $title='hsa_contact';
                                        }

                                    echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $title)) . '</label><br>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                    </div>
                                            ';
                                } else if (strpos($value['Field'], 'contact') !== false) {
                                    echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                    </div>
                                            ';
                                } else if (strpos($value['Field'], 'allowance') !== false) {
                                    echo '
                                            <div class="form-group">
                                                <label for="' . $value['Field'] . '"> ' . ucwords(str_replace('_', ' ', 'funds_given_per_fo')) . '</label><br>
                                                <input id="' . $value['Field'] . '" type="text" name="' . $value['Field'] . '" class="form-control input-sm"  />
                                            </div>
                                        ';
                                }  else if (strpos($value['Field'], 'date') !== false) {
                                    echo '
								            <div class="form-group">
								            	<label for="' . $value['Field'] . '"> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input id="' . $value['Field'] . '" type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
											</div>
										';
                                } else if (strpos($value['Field'], 'chw_name') !== false){
                                    if($_SESSION['country']==1){
                                            $title='chw_name';
                                        }else if($_SESSION['country']==2){
                                            $title='vht_name';
                                        }else{
                                              $title='hsa_name';
                                        }
                                    echo '
                                            <div class="form-group">
                                                <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $title)) . '</label><br>
                                                <input id="' . $value['Field'] . '" type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
                                            </div>
                                        ';
                                } else {
                                    echo '
								            <div class="form-group">
								            	<label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input id="' . $value['Field'] . '" type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
											</div>
										';
                                }
                            }
                                 echo '
                                        <div class="form-group">
                                        <label for="' . $desiredCauName . '" >' . ucwords(str_replace('_', ' ', $desiredCauName)). '</label><br>
                                                <select id="' . $desiredCauName. '" name="territory" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $desiredCauName)) . '</option>';
                                                foreach ($cauDropDown as $key => $value_) {
                                                    echo'<option value="' . $value_['id'] . '" >' . $value_['admin_territory_name'] . '</option>';
                                                }
                                                echo '</select>
                                        </div>
                                <input type="hidden" name="desiredCau" value="'.$desiredCauName.'"/>
                                        ';

                            ?>	
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-schedule-data" id="add-schedule-data">Save</button>
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

 function show_confirm(tables, deleteId,program) {
    if (confirm("Are you sure you want to delete?")) {
        location.replace('<?php echo URL ?>scheduler/deleteSchedule/' + tables + '/' + deleteId+'/'+program);

    } else {
        return false;
    }
}


</script>