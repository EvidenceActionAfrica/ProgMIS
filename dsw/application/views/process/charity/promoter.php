<div class="col-md-12" style="margin-top:-2%;">
    <div id="data-table-manger">
        <!-- <div class="col-md-5 col-md-offset-3"><h3 ></h3></div> -->
        <h3 class="text-center"><?php echo $tableName;
        
        if(isset($flagged)){echo '-'.$flagged;}
        ?></h3>

        <div class="btn-group col-md-6">
           <?php
           if(isset($flagged)){
               
               echo ' <div class="btn-group pad-top-15">
                <a href="'.URL.'processdata/promoter/promoter_details" class="btn btn-default" data-toggle="modal"><-Go Back</a>
            </div>  ';
               
           }
?>
             <div class="btn-group pad-top-15">
                <a href="<?php echo URL ?>processdata/viewLogs/promoter_call_log" class="btn btn-default" data-toggle="modal">View All Call Logs</a>
            </div>
            &nbsp;
             <div class="btn-group pad-top-15">
               <a href="<?php echo URL ?>processdata/viewLogs/promoter_sms_log" class="btn btn-default" data-toggle="modal">View All Sms Logs</a>
              </div>
             &nbsp;
             <div class="btn-group pad-top-15">
               <a href="<?php echo URL ?>processdata/viewFlagged" style="text-decoration:none;color:#FFFFFF;" class="btn bg-custom-Pinker" data-toggle="modal">Water points Flagged:<?php echo $noWaterpoints[0]["waterpoints"]; ?></a>
              </div>
        </div>

        <div class="clearfix"></div>
        <hr>
    </div>
 
    <div class="table-responsive">
        <?php if (!empty($data)) { ?>

            <table id="data-table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                        }
                        $extra="";
                        if ($table == 'promoter_details') {
                            $extra='data-toggle="modal" data-target="#myModal"';
                            echo '<th class="buttons" ></th>';
                        
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($data as $key => $value) {

                        echo '<tr>';
                        foreach ($value as $key => $value) {
                            //echo $value."<br/>";

                            if ($i == 1) {
                                $promoterId = $value;
                            }
                            echo '<td>' . $value . '</a></td>';
                            $i = 0;
                        }
                        $i = 1;
                        if ($table == 'promoter_details') {
                            ?>
                        <td class="buttons"><a href="<?php echo URL ?>processdata/callupdate/<?php echo 'promoter_call_log'."/".$promoterId; ?>" class="btn btn-default btn-xs">Call Log</a>
                         <a href="<?php echo URL ?>processdata/smsupdate/<?php echo 'promoter_sms_log'."/".$promoterId; ?>" class="btn btn-default btn-xs">Sms Log</a></td>
                        <?php
                    }
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>

<?php } else { ?>

            <p><b>No Record Found</b></p>

<?php } 


?>

    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable({
            "scrollY": false,     
            "scrollX":false,
        });
    });
</script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo "Add Promoter"; ?></h4>
            </div>
            <?php 
                if (isset($single_record)) {
                    ?> 
                        <form  action="<?php echo URL; ?>processdata/update/" data-async data-target="myModal" method="post" role="form" id="modal-form">
                    <?php

                }else{
                     ?> 
                        <form  action="<?php echo URL; ?>processdata/add/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                    <?php

                }
             ?>
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $x=0;
                          //  echo "<pre>";var_dump($single_record);echo "</pre>";
                            foreach ($fields as $key => $value) {
                                
                                    if ($value['Key'] == 'PRI') {
                                        if (!isset($single_record)) {
                                            echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                        }else{
                                            echo '<input type="hidden" value="'.$single_record[$x].'" value="" name="' . $value['Field'] . '"readonly/>';

                                        }
                                    } else if ($value['Key'] == 'MUL') {
                                        echo '
    								         	<div class="form-group">
    								            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
    												<select name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                        foreach ($value['parents'] as $key => $value_) {
                                          /*  if (isset($single_record)) {
                                                if ($single_record[$x] == $value_['id']) {
                                                    $selected='selected';
                                                    echo'<option selected="'.$selected.'" value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                }else{*/
                                                   // $selected='';
                                                    echo'<option  value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                            
                                            

                                               // echo'<option selected="'.$selected.'" value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                            
                                        }
                                        echo '</select>
    											</div>';
                                    } else if ($value['Type'] == 'timestamp') {
                                        if (!isset($single_record)) {
                                        echo '
    								            <div class="form-group">
    								            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
    												<input type="text" name="" class="form-control input-sm" value="' . date('d-m-Y') . '" readonly/>
    											</div>
    										';
                                        }else{
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" value="'.$single_record[$x].'"  name="' . $value['Field'] . '" class="form-control input-sm" readonly/>
                                                </div>
                                            ';
                                        }
                                    } else if ($value['Field'] == 'issueid') {
                                        echo '
    								            <div class="form-group">
    								            	<input type="hidden" name="' . $value['Field'] . '" class="form-control input-sm" value="' . $dataId . '" readonly/>
    											</div>
    										';
                                    } else {
                                        if (!isset($single_record)) {
                                        echo '
    								            <div class="form-group">
    								            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
    												<input type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
    											</div>
    										';
                                            continue;
                                        }else{
                                            
                                              echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" value="'.$single_record[$x].'"   name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                </div>
                                            ';
                                        }
                                    }
                                $x++;
                            }
                            ?>	
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-process-data" id="add-issue-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>  



<!-- Modal -->
<div class="modal fade" id="mySmsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Send Messages via Sms</h4>
            </div>

            <form  action="<?php echo URL; ?>processdata/contacttype" data-async data-target="mySmsModal" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">           
                            <div class="form-group">
                                
                                <label>Sender</label><br/>
                                <input type="text" name="sender" class="form-control input-sm" value="<?php echo $_SESSION['full_name']; ?>" readonly />
                            </div>

                            <div class="form-group">
                                <label>Recipient Name</label><br/>
                                <input type="text" name="recipient_name" class="form-control input-sm" value="" />
                            </div>

                            <div class="form-group">
                                <label>Recipient Number</label><br/>
                                <input type="text" name="recipient_number" class="form-control input-sm" value="" placeholder="+254" required/>
                            </div>

                         
                            <div class="form-group">
                                <label>Current Date</label><br/>
                                <input type="text"  class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" readonly />
                            </div>

                            <div class="form-group">
                                <label>Subject</label><br/>
                                <input type="text" name="subject" class="form-control input-sm" value=""  />
                            </div>

                            <div class="form-group">
                                <label>SMS body</label><br/>
                                <textarea name="sms_body" class="input_textbox_p " rows="2" cols="3" required></textarea>
                            </div>   
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-sendSms-data" id="add-sendSms-data">Send Sms</button>
                                
                </div> 
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
 

    $('#mySmsModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#mySmsModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');

    });
    $('#myModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');

    });



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