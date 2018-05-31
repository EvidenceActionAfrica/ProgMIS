<!-- Modal -->
<div id="myModal" class="col-md-6 col-md-offset-3" >
    <div >
        <div >
            <div>
                <h4 class="text-center" >Create Call Log</h4>
            </div>
            <form  action="<?php echo URL; ?>processdata/callupdate/promoter_call_log/<?php echo $promoterId; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">

                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Date</label><br>
                                <input type="text" name="date" class="form-control input-sm datepicker" value="<?php echo date('d-m-Y'); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="promoterName">Promoter Name</label>
                                <input type="text" name="promoter_name" class="form-control input-sm" value="<?php echo $promoter_name; ?>" readonly/>
                            </div>
                            
                            <div class="form-group">
                                <label for="promoterName">Promoter Contact</label>
                                <input type="text" name="promoter_contact" class="form-control input-sm" value="<?php echo $promoter_contact; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="createdBy">Created By</label>
                                <input type="text" name="created_by" class="form-control input-sm" value="<?php echo $_SESSION["full_name"]; ?>" readonly/>
                            </div>
                            
                            <div class="form-group">
                                <label for="Message">Message</label>
                                <textarea name="message" class="form-control" /></textarea>
                            </div>
                                <div class="form-group">
                                <label for="createdBy">Issue Type</label>
                                
                                <select name="issue_type">
                                    <option>Communication</option>
                                    <option>Check-In</option>
                                    <option>Delivery</option>
                                    <option>Maintenance</option>
                                </select>
                                
                                </div>
                            
                            
                            
                            <div class="form-group">
                                <input type="hidden" name="promoter_id" class="form-control input-sm" value="<?php echo $promoterId; ?>" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-4">
                    <!-- this takes the user back to the previous page -->
                    <a href='<?php echo URL . "processdata/promoter/" ?>'>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </a>
                    <button  type="submit" class="btn btn-primary" name="add-callLog-data" id="add-callLog-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>  

<script type="text/javascript">
    window.onload = function() {
        $("#mymodal").show();
        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');

    };
</script>