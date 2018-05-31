<div class="col-md-10">
     <?php if (isset($_GET['message'])) { ?>
                <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
                    <?php 
                        echo $_GET['message'];
                    ?>
                    <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </div>
       <?php } ?>
 
       <?php if (isset($message)) { ?>
                <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
                    <?php 
                        echo $message;
                    ?>
                    <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </div>
                <?php } ?>
    <div id="data-table-manger">

        <div class="clearfix">
           <div id="data-table-manger">
             <h3>Program:<?php echo $program; ?>  Tracking</h3>
           </div>

            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">
                    <!-- <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add</button> -->
                 <a class="btn btn-default " href="<?php echo URL.'importclass/index/'.$table.'/expansion/vcsVerificationMeetingsTrack/'.$program; ?>">Import Details</a>
                  <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myODKModal">Add/Replace VCS Odk Link</button>
                  
                        <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add New VCS Meeting</button>
                  
                    
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
                        <th>#</th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' || $key=="program") {
                                continue;
                            }
                            if(in_array($key, $cauManage) || in_array($key, $fieldsArray) || strtolower($key)=='won_present' || strtolower($key)=='vcs_odk_on_server'){
                           
                            if (!in_array($key, $arrayName = array('id'))) {

                                if ($key == "country" || $key == "Country" || $key == "village_name") {
                                    continue;
                                }else if(strpos($key, 'elder') !== false ){
                                  echo '<th class="export-visible" > Village ' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }else if(strpos($key, 'mycyl_allocated') !== false ){
                                  echo '<th class="export-visible" > Vcl/ Mcyl Allocated</th>';
                                }else if($key=="field_officer_responsible"){
                                  echo '<th class="export-visible" >F.A Responsible</th>';
                                }else if($key=="Match"){
                                    echo '<th class="export-visible" title="Verification Id\'s Match Of Tracking & Uploaded Data" data-toggle="tooltip" data-placement="top" >' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }else if($key=="Consistent"){
                                    echo '<th class="export-visible" title="Waterpoints Data in Tracking And In the Admin Module Match" data-toggle="tooltip" data-placement="top" >Is Reverification Neccessary?</th>';
                                }else if($key=='chw_name' && $_SESSION['country']==2) {
                                     echo '<th class="export-visible" >VHT Name</th>';
                                }else if($key=='chw_name' && $_SESSION['country']==3){
                                     echo '<th class="export-visible" >HSA Name</th>'; 
                                }else if ($key=='chw_name'){
                                     echo '<th class="export-visible" >' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }else if($key=='chw_contacts' && $_SESSION['country']==2) {
                                     echo '<th class="export-visible" >VHT Contact</th>';
                                }else if($key=='chw_contacts' && $_SESSION['country']==3){
                                     echo '<th class="export-visible" >HSA Contact</th>'; 
                                }else if($key=='chw_contacts' && $_SESSION['country']==1){
                                     echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
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
             <tfoot>
                    <tr>
                        <th></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' || $key=="program") {
                                continue;
                            }
                            if(in_array($key, $cauManage) || in_array($key, $fieldsArray) || strtolower($key)=='won_present'|| strtolower($key)=='vcs_odk_on_server'){
                           
                            if (!in_array($key, $arrayName = array('id'))) {

                                if ($key == "country" || $key == "Country" || $key == "village_name") {
                                    continue;
                                }else if(strpos($key, 'elder') !== false ){
                                  echo '<th class="export-visible" > Village ' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }else if(strpos($key, 'mycyl_allocated') !== false ){
                                  echo '<th class="export-visible" > Vcl/ Mcyl Allocated</th>';
                                }else if($key=="field_officer_responsible"){
                                  echo '<th class="export-visible" >F.A Responsible</th>';
                                }else if($key=="Match"){
                                    echo '<th class="export-visible" title="Verification Id\'s Match Of Tracking & Uploaded Data" data-toggle="tooltip" data-placement="top" >' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }else if($key=="Consistent"){
                                    echo '<th class="export-visible" title="Waterpoints Data in Tracking And In the Admin Module Match" data-toggle="tooltip" data-placement="top" >Is Reverification Neccessary?</th>';
                                }else if($key=='chw_name' && $_SESSION['country']==2) {
                                     echo '<th class="export-visible" >VHT Name</th>';
                                }else if($key=='chw_name' && $_SESSION['country']==3){
                                     echo '<th class="export-visible" >HSA Name</th>'; 
                                }else if ($key=='chw_name'){
                                     echo '<th class="export-visible" >' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }else if($key=='chw_contacts' && $_SESSION['country']==2) {
                                     echo '<th class="export-visible" >VHT Contact</th>';
                                }else if($key=='chw_contacts' && $_SESSION['country']==3){
                                     echo '<th class="export-visible" >HSA Contact</th>'; 
                                }else if($key=='chw_contacts' && $_SESSION['country']==1){
                                     echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                } else {
                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                        }
                        }
                        ?>
                        
                            <th></th>
                       
                    
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
                                if ($key == 'position' && $table != "staff_category" || $key == "village_name" || $key=="program") {
                                    continue;
                                }
                                if ($i == 1) {
                                    $generalId = $value;
                                }
                                 if(in_array($key, $cauManage) || in_array($key, $fieldsArray) || strtolower($key)=='won_present'|| strtolower($key)=='vcs_odk_on_server'){
                                if (!in_array($key, $arrayName = array('id'))) {

                                    if ($key == "country" || $key == "Country") {
                                        continue;
                                    }else if($key=='duplicate' || $key=="Duplicate"){

                                        if($value==0){
                                               echo '<td class="export-visible" style="text-align:center"><span title="NONE" data-toggle="tooltip" data-placement="left"  style="color:#3B7A57;">None</span></td>';
                                        }else{
                                               echo '<td class="export-visible"  style="text-align:center"><span data-toggle="tooltip" data-placement="left" title="The Verification Id Is Not Unique or non-existent" style="color:#E81919;">Yes</span></td>';
                                        }

                                    }else if($key=="Match"){

                                         if($value==1){
                                               echo '<td class="export-visible"  style="text-align:center"><span title="Match" data-toggle="tooltip" data-placement="left" style="color:#3B7A57;">Match</span></td>';
                                        }else{
                                               echo '<td class="export-visible" style="text-align:center"><span data-toggle="tooltip" data-placement="left" title="The Verification Ids do not match or one is non-existent" style="color:#E81919;">Non-Match</span></td>';
                                        }

                                    }else if($key=="Consistent"){

                                         if($value==3){
                                               echo '<td class="export-visible" style="text-align:center"><span title="All the Details Are Consistent" data-toggle="tooltip" data-placement="left"  style="color:#3B7A57;">No</span></td>';
                                        }else{
                                               echo '<td class="export-visible" style="text-align:center"><span data-toggle="tooltip" data-placement="left" title="The Waterpoint Details Are incosistent. Please Check Again"  style="color:#E81919;">Yes</span></td>';
                                        }

                                    } else {
                                        echo '<td class="export-visible" style="text-align:center">' . $value . '</td>';
                                    }
                                }
                            }
                                // $i = 0;  
                            }
                            // $i = 1;
                            ?>
                           
                                <td class="buttons"><a href="<?php echo URL ?>expansion/vcsVerificationTrackingUpdate/<?php echo $table . "/" . $data[$i]['id']."/".$program; ?>" class="btn btn-default btn-xs" >Edit</a>
                                <a onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>,'<?php echo $program; ?>');"  class="btn btn-default btn-xs">Delete</a></td>                 
                          
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

    <span style='bold;'> Current ODK API LINK Is :</span>
    <?php
        if(isset($odkData[0]['api_key'])){
            echo $odkData[0]['api_key'];
            echo '<br/>';
            echo '<span style="bold;">Selected Column: '.$odkData[0]['column_name'];
        }else{
            echo '<b>No ODK Link Found for this Program</b>';
        }
    ?>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        <?php if (!empty($data)) { ?>
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
        <?php } ?>
    });
</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add VCS Meeting</h4>
            </div>
            <form  action="<?php echo URL; ?>expansion/vcsVerificationTrackingAdd/<?php echo $table;?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                         <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="40px" style="position:absolute;top:50%;left:50%;margin:0 auto; visibility: visible"/>

                            <?php
                         
                            foreach ($fields as $key => $value) {
                                if ($value['Key'] == 'PRI') {
                                    echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                }elseif ($value['Key'] == 'MUL' && $value['Field'] =="country") {
                                                            echo '
                                                                <div class="form-group">
                                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                                        foreach ($value['parents'] as $key => $value_) {
                                                                           
                                                                            if($value_['id']==$_SESSION['country']){
                                                                            echo'<option value="' . $value_['id'] . '" selected ><b>' . $value_[$value['Field']] . '</b></option>';
                                                                            }else{
                                                                             echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                                            
                                                                            }

                                                                        }
                                                                        echo '</select>
                                                                </div>';
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
                                }else if (strpos($value['Field'], 'direction') !== false || strpos($value['Field'], 'notes') !== false) {
                                    echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                           <textarea  name="' . $value['Field'] . '"class="form-control input-sm" style="max-width:300px;"></textarea>
                                                    </div>
                                            ';
                                }else if (strpos($value['Field'], 'village_name') !== false) {
                                     
                                       $i=0;
                                        foreach ($cauList as $key => $value) {   
                                               echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['territory_name'])) . '</label><br>
                                                <select  name="' . $value['territory_name'] . '" id="'.$value['territory_name'].'ajax" class="form-control input-sm ' . $value['territory_name'].'ajax" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['territory_name'])) . '</option>'; 
                                                  foreach ($ListedCaus[$value['territory_name']] as $key => $value_) {
                                                    
                                                    echo'<option  value="' . $value_['id'] . '" >' . $value_['territory_name'] . '</option>';  
                                                        
                                                    }
                                                    echo '</select>
                                                                </div>';
                                        ++$i;
                                        }


                                } else if (strpos($value['Field'], 'initial_status') !== false || strpos($value['Field'], 'final_status') !== false) {
                                    echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                           <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                             <option value="Scheduled">Scheduled</option>
                                                             <option value="ReScheduled" >ReScheduled</option>
                                                             <option value="Not Scheduled" selected>Not Scheduled</option>
                                                             <option value="Complete">Complete</option>
                                                           </select>
                                                    </div>
                                            ';
                                }else if (strpos($value['Field'], 'program') !== false) {
                                                                echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                      <input type="text" class="form-control input-sm" name="program" value="'.$program.'" readonly />
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
                                }else if (strpos($value['Field'], 'phone') !== false) {
                                    echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                    </div>
                                            ';
                                }else if (strpos($value['Field'], 'chw_name') !== false) {
                                    if($value['Field']=='chw_name'){

                                        if($_SESSION['country']==1 ){
                                            $title='chw_name';
                                        }else if($_SESSION['country']==2){
                                            $title='VHT_Name';
                                        }else{
                                            $title='HSA_Name';
                                        }
                                    }
                                    echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $title)) . '</label><br>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" />
                                                    </div>
                                            ';
                                }else if (strpos($value['Field'], 'chw_contacts') !== false) {
                                    if($value['Field']=='chw_contacts'){

                                        if($_SESSION['country']==1 ){
                                            $title='Chw_contacts';
                                        }else if($_SESSION['country']==2){
                                            $title='VHT_contacts';
                                        }else{
                                            $title='HSA_contacts';
                                        }
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
                                } else if (strpos($value['Field'], 'date') !== false) {
                                    echo '
                            <div class="form-group">
                              <label for="' . $value['Field'] . '"> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                        <input id="' . $value['Field'] . '" type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
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
                            ?>  
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-vcs-data" id="add-vcs-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>  
<!-- Modal -->
<div class="modal fade" id="myODKModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add ODK Link</h4>
            </div>
            <form  action="<?php echo URL; ?>expansion/verificationODKAdd/<?php echo 'odk_vcs/'.$program;?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                          <span>Example of a api key is highlighted: <font style="color:  blue">https://docs.google.com/spreadsheets/d/<font style="background-color: yellow">12ndptfZW_oHxkLJEHlkzG8ByJXwxU9f4ASB6OePCZ3k</font>/edit#gid=0</font></span>
                           
                            <div class="form-group">
                                <label for="apiKey">Api Key</label><br>
                                 <input id="apiKey" type="text" name="apiKey" class="form-control input-sm" value="<?php
                            if (isset($odkData[0]['api_key'])) {
                                echo $odkData[0]['api_key'];
                            } else {
                                echo 'No ODK Link Found for this Program';
                            } ?>" required/>
                            </div>
                            <div class="form-group">
                                <label for="Column">Column</label><br>
                                 <input id="column" type="text" name="column" class="form-control input-sm" required/>
                                 <input id="program" type="hidden" name="program" class="form-control input-sm" value="<?php echo $program; ?>" />
                                 
                            </div>
                           
                            
                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-verification-data" id="add-verification-data">Save</button>
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
            location.replace('<?php echo URL ?>expansion/vcsVerificationTrackingDelete/' + tables + '/' + deleteId+'/'+program);

        } else {
            console.log('<?php echo URL ?>expansion/vcsVerificationTrackingDelete/' + tables + '/' + deleteId+'/'+program);
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
        console.log("<?php echo URL ?>generalclass/ajaxChildCau/<?php echo $territoryArray[$i+1]; ?>/<?php echo $value['territory_name'];?>/"+$("#<?php echo $value['territory_name'] ?>ajax").find(":selected").val());
          $.ajax({
        url: "<?php echo URL ?>generalclass/ajaxChildCau/<?php echo $territoryArray[$i+1]; ?>/<?php echo $value['territory_name'];?>/"+$("#<?php echo $value['territory_name'] ?>ajax").find(":selected").val(),
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
        
        $("#<?php echo $territoryArray[$i+1]; ?>ajax").empty();
        
            $("#<?php echo $territoryArray[$i+1]; ?>ajax").append("<option value=''></option>");
            $(data).each(function(){
                
              //We Need To Loop Through the select tag searching for any value matching the json values
           $("#<?php echo $territoryArray[$i+1]; ?>ajax").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["admin_territory_name"]+"</option>");    
            
            console.log("passed thru");
            console.log(data[counter-1]["admin_territory_name"]);
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