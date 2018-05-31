<?php $lastUrl = $expansionmodel->getLastURL($_SERVER['REQUEST_URI']);
?>
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
                <h3>Program:<?php echo $program; ?> Tracking</h3>
            </div>

            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">
                    <!-- <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add</button> -->
                    <!--
                    <button type="button" style='margin-right:10px;' class="btn btn-default pink-button" data-toggle="modal" data-target="#myImportModal">Import Details</button>
                    -->
                    <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myODKModal">Add/Replace ODK Link</button>

                    <a class="btn btn-default " href="<?php echo URL . 'importclass/index/' . $table . '/expansion/trackVerification/' . rawurlencode($program); ?>">Import Details</a>
                    <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add New Verification</button>


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

                        <th class='index'></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' && $table != "staff_category") {
                                continue;
                            }
                            if (in_array($key, $cauManage) || in_array($key, $fieldsArray) || strtolower($key) == 'duplicate' || strtolower($key) == 'verification_id_present_on_odk' || strtolower($key) == 'activity_tracker_and_odk_data_agree' || strtolower($key) == 'reverification') {
                                if (!in_array($key, $arrayName = array('id'))) {

                                    if ($key == "country" || $key == "Country" || $key == "village_name" || $key == "program") {
                                        continue;
                                    } else if ($key == "village") {

                                        echo '<th class="export-visible" >Village Name</th>';
                                    } else if ($key == "status") {

                                        echo '<th class="export-visible">PASS/FAIL</th>';
                                    } else if ($key == "field_officer") {

                                        echo '<th class="export-visible">F.A Name</th>';
                                    } else if ($key == "Match") {

                                        echo '<th class="export-visible" title="Verification Id\'s Match Of Tracking & ODK Data" data-toggle="tooltip" data-placement="top" >Verification Id Present?</th>';
                                    } else if ($key == "reverification") {

                                        echo '<th class="export-visible" title="Waterpoints Data in Tracking And In the Admin Module Match" data-toggle="tooltip" data-placement="top" >Reverification Neccessary?</th>';
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
                        <th class='index'></th>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' && $table != "staff_category") {
                                continue;
                            }
                            if (in_array($key, $cauManage) || in_array($key, $fieldsArray) || strtolower($key) == 'duplicate' || strtolower($key) == 'verification_id_present_on_odk' || strtolower($key) == 'activity_tracker_and_odk_data_agree' || strtolower($key) == 'reverification') {
                                if (!in_array($key, $arrayName = array('id'))) {

                                    if ($key == "country" || $key == "Country" || $key == "village_name" || $key == "program") {
                                        continue;
                                    } else if ($key == "village") {

                                        echo '<th class="export-visible" >Village Name</th>';
                                    } else if ($key == "status") {

                                        echo '<th class="export-visible">PASS/FAIL</th>';
                                    } else if ($key == "field_officer") {

                                        echo '<th class="export-visible">F.A Name</th>';
                                    } else if ($key == "activity_tracker_and_odk_data_agree") {

                                        echo '<th class="export-visible" title="Activity & Odk Trackers Agree; ?>" data-toggle="tooltip" data-placement="top" >Is Verification Id Present in System?</th>';
                                    } else if ($key == "reverification") {

                                        echo '<th class="export-visible" title="Waterpoints Data in Tracking And In the Admin Module Match" data-toggle="tooltip" data-placement="top" >Is Reverification Neccessary?</th>';
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
                                if (in_array($key, $cauManage) || in_array($key, $fieldsArray) || strtolower($key) == 'duplicate' || strtolower($key) == 'verification_id_present_on_odk' || strtolower($key) == 'activity_tracker_and_odk_data_agree' || strtolower($key) == 'reverification') {
                                    if (!in_array($key, $arrayName = array('id'))) {

                                        if ($key == "country" || $key == "Country" || $key == "village_name" || $key == "program") {
                                            continue;
                                        } else if ($key == 'duplicate' || $key == "Duplicate") {

                                            if ($value == 0) {
                                                echo '<td class="export-visible" style="text-align:center"><span title="NONE" data-toggle="tooltip" data-placement="left"  style="color:#3B7A57;">None</span></td>';
                                            } else if ($value < 0) {
                                                echo '<td class="export-visible"  style="text-align:center"><span data-toggle="tooltip" data-placement="left" title="The Verification Id Is  non-existent" style="color:#E81919;">Not Found in Waterpoint list</span></td>';
                                            } else {
                                                echo '<td class="export-visible" style="text-align:center"><span data-toggle="tooltip" data-placement="left" title="The Verification Id Is Not Unique" style="color:#E81919;">Yes</span></td>';
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

                            <td class="buttons"><a href="<?php echo URL ?>expansion/verificationTrackUpdate/<?php echo $table . "/" . $data[$i]['id']; ?>" class="btn btn-default btn-xs" >Edit</a> 
                                <a onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>, '<?php echo $program; ?>');" class="btn btn-default btn-xs">Delete</a></td>                 

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

    <span style='bold;'> Current ODK API LINK Is :</span>
<?php
if (isset($odkData[0]['api_key'])) {
    echo $odkData[0]['api_key'];
    echo '<br/>';
    echo '<span style="bold;">Selected Column: ' . $odkData[0]['column_name'];
} else {
    echo '<b>No ODK Link Found for this Program</b>';
}
?>
</div>
<script type="text/javascript">
                                    $(document).ready(function() {
<?php if (!empty($data)) { ?>
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
                                                            oSelectorOpts: {filter: 'applied', order: 'current'},
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
<?php } ?>
                                    });
</script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Verification</h4>
            </div>
            <form  action="<?php echo URL; ?>expansion/verificationTrackAdd/<?php echo $table . '/' . $program; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
 <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="30px" style="margin:0 auto; visibility: visible"/>

<?php
foreach ($fields as $key => $value) {
    if ($value['Key'] == 'PRI') {
        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
    } elseif ($value['Key'] == 'MUL' && $value['Field'] == "country") {
        echo '
                                                                    <div class="form-group">';

        echo'<input type="hidden" name="' . $value['Field'] . '" value="' . $_SESSION['country'] . '"  class="form-control input-sm"  readonly>';
        echo '
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
    } else if (strpos($value['Field'], 'reason') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                           <textarea class="form-control input-sm" style="max-width:300px;"></textarea>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'program') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br/>
                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" value="' . $program . '" readonly/>
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


    }  else if (strpos($value['Field'], 'field_officer') !== false) {
        echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           ';
        foreach ($staffDropDown as $key => $value) {
            echo '<option value="' . $value['full_name'] . '">' . $value['full_name'] . '</option>';
        }

        echo '</select>
                                                                    </div>
                                                                        
                                                                        ';
    } else if (strpos($value['Field'], 'reverification') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                           <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                             <option value="YES">YES</option>
                                                             <option value="NO" selected>NO</option>
                                                           </select>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'status') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                           <select name="status" class="form-control input-sm" required>
                                                             <option value="PASS">PASS</option>
                                                             <option value="FAIL" selected>FAIL</option>
                                                           </select>
                                                    </div>
                                            ';
    } else if (strpos($value['Field'], 'phone') !== false) {
        echo '
                                        <div class="form-group">
                                            <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
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
                    <button  type="submit" class="btn btn-primary" name="add-verification-data" id="add-verification-data">Save</button>
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
            <form  action="<?php echo URL; ?>expansion/verificationODKAdd/<?php echo 'odk_verification/' . $program; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">

                            <span>Example of a api key is highlighted: <font style="color:  blue">https://docs.google.com/spreadsheets/d/<font style="background-color: yellow">12ndptfZW_oHxkLJEHlkzG8ByJXwxU9f4ASB6OePCZ3k</font>/edit#gid=0</font></span>
                            <div class="form-group">
                                <label for="apiKey">Api Key</label><br>
                                <input  id="apiKey" type="text" name="apiKey" class="form-control input-sm" required  value="<?php
                            if (isset($odkData[0]['api_key'])) {
                                echo $odkData[0]['api_key'];
                            } else {
                                echo '<b>No ODK Link Found for this Program</b>';
                            } ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="Column">Column Verification ID</label><br>
                                <input id="column" type="text" name="column" class="form-control input-sm" required />
                                <input id="program" type="hidden" name="program" class="form-control input-sm" value="<?php echo $program; ?>" required/>

                            </div>
                            <div class="form-group">
                                <label for="Column">Column Verification Pass</label><br>
                                <input id="column" type="text" name="column2" class="form-control input-sm" required />


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
<!-- Modal -->
<div class="modal fade" id="myImportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Import  Details</h4>
            </div>
            <form  action="<?php echo URL; ?>importclass/import/<?php echo $table . '/generalclass/general'; ?>" enctype="multipart/form-data" data-async data-target="myModal" method="post" role="form" id="modal-form">
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

    function show_confirm(tables, deleteId, program) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>expansion/verificationTrackDelete/' + tables + '/' + deleteId + '/' + program);

        } else {
            console.log('<?php echo URL ?>expansion/verificationTrackDelete/' + tables + '/' + deleteId + '/' + program);
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