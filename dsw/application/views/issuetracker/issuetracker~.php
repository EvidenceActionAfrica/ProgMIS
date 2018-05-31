<?php $lastUrl=$generaldata_model->getLastURL($_SERVER['REQUEST_URI']); ?>
<?php $table; ?>
<div class="col-md-12" style="margin-top:-2%;">
    <div id="data-table-manger">
        <!-- <div class="col-md-5 col-md-offset-3"><h3 ></h3></div> -->
        <h3 class="text-center"><?php echo $tableName; ?></h3>

        <div class="btn-group pull-right">
            <div class="btn-group pad-top-15">
                <div class="btn-group">
                    <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add <?php echo $tableName; ?></button>
                </div>
                <?php 
                        if ($table=='issues') {
                        ?>
                            <div class="btn-group">
                               <a href="<?php echo URL?>issuetracker/export/<?php echo $table ?>">
                                    <button type="button" class="btn btn-default pink-button">Export CSV</button>
                                </a>
                            </div>

                        <?php
                        }else{

                        ?>
                            <!-- <div class="btn-group">
                               <a href="<?php echo URL?>issuetracker/export/<?php echo $table."/".$lastUrl ?>">
                                    <button type="button" class="btn btn-default pink-button">Export CSV</button>
                                </a>
                            </div> -->

                        <?php
                        }

                     ?>

            </div>
        </div>

        <div class="clearfix"></div>
        <hr>
    </div>

    <div class="table-responsive">
        <?php if (!empty($data)) { ?>

            <table id="data-table" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                        }
                        $extra="";
                        if ($table == 'issues') {
                            $extra='data-toggle="modal" data-target="#myModal"';
                            echo "<th>View/Take<br/>Actions</th>";
                            echo "<th colspan='2'>Communication</th>";
                          echo "<th>Edit</th>";
                          echo "<th>Delete</th>";
                         
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
                                $issueId = $value;
                            }
                            echo '<td>' . $value . '</a></td>';
                            $i = 0;
                        }
                        $i = 1;
                        if ($table == 'issues') {
                            ?>
                        <td><a href="../issuetracker/issuesaction/<?php echo $issueId; ?>"><button class="btn btn-success btn-sm">Action</button></a></td>
                        <td><button  data-toggle="modal" data-target="#mySmsModal"class="btn btn-info btn-sm">Send Sms</button></td>
                        <td><button  data-toggle="modal" data-target="#myEmailModal" class="btn btn-warning btn-sm">Send Email</button></td>
                       <td><a href="../issuetracker/edittracker/<?php echo $issueId; ?>"><button class="btn btn-success btn-sm">Edit</button></a></td> 
                       <td><a onclick="show_confirm(<?php echo $issueId; ?>);"><button class="btn btn-danger btn-sm">Delete</button></a></td>    							
                    <?php
                    }
                    echo '</tr>';
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
        $('#data-table').dataTable({
            "scrollY": "500px",
            "scrollX": "100%",
            "scrollCollapse": true
        });
    });
</script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo "Add " . $tableName . ""; ?></h4>
            </div>
            <?php 
                if (isset($single_record)) {
                    ?> 
                        <form  action="<?php echo URL; ?>issuetracker/update/" data-async data-target="myModal" method="post" role="form" id="modal-form">
                    <?php

                }else{
                     ?> 
                        <form  action="<?php echo URL; ?>issuetracker/add/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
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
                                        if ($value['Field'] == 'full_name'){
                                          echo '   <div class="form-group">
                                                    <label>Handled By</label><br>';
                                                
                                        }else{
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>';
                                                 }
                                                 echo '			<select name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
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
                                    } else if ($value['Field'] == 'issueid' ||$value['Field'] == 'full_name' ) {
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
                    <button  type="submit" class="btn btn-primary" name="add-issue-data" id="add-issue-data">Save</button>
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
                <h4 class="modal-title" id="myModalLabel"><?php echo "Send " . $tableName . " via Sms"; ?></h4>
            </div>

            <form  action="<?php echo URL; ?>issuetracker/contacttype" data-async data-target="mySmsModal" method="post">
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

<!-- Modal -->
<div class="modal fade" id="myEmailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo "Send " . $tableName . " via Email"; ?></h4>
            </div>

            <form  action="<?php echo URL; ?>issuetracker/contacttype" data-async data-target="myEmailModal" method="post">
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
                                <label>Recipient Email</label><br/>
                                <input type="email" name="recipient_email" class="form-control input-sm" value="" placeholder="someone@someplace.com" required/>
                            </div>

                            <div class="form-group">
                                <label>Current Date</label><br/>
                                <input type="text"  class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" readonly />
                            </div>

                            <div class="form-group">
                                <label>Subject</label><br/>
                                <input type="text" name="subject" class="form-control input-sm" value=""  required/>
                            </div>

                            <div class="form-group">
                                <label>Email body</label><br/>
                                <textarea name="email_body" class="input_textbox_p " rows="2" cols="3" required></textarea>
                            </div>   
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-success" name="add-sendMail-data" id="add-sendMail-data">Send Mail</button>                              
                                
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

    $('#mySmsModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#mySmsModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');

    });
    $('#myEmailModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#myEmailModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');

    });



    // $('form').validate();
       function show_confirm(deleteId) {
             if (confirm("Are you sure you want to delete?")) {
                    location.replace('../issuetracker/delete/issues/' + deleteId);
                          
              } else {
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