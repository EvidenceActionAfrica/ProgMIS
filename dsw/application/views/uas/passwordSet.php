
<!-- Modal -->
<div id="myModal" class="col-md-8"  >
    <form  action="<?php echo URL; ?>uasettings/setPassword/<?php echo $staffId; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">

        <div>
            <div>
                <?php if (isset($message)) { ?>
                <div class="alert alert-danger text-center" role="alert" data-dismiss="alert">
                    <?php 
                        echo $message;
                    ?>
                    <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </div>
                <?php } ?>
                <div>
                    <h4 class="text-center" ><?php echo "Edit " . $tableName . ""; ?></h4>
                </div>

                <div class="col-md-4 col-md-offset-4">
                    <?php
                    $x = 0;
                    foreach ($fields as $key => $value) {
                        if ($value['Field'] == "password") {
                            echo '
								            <div class="form-group">
								            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="password" id="' . $value['Field'] . '" name="currentPassword" value="' . $single_record[$x] . '" class="form-control input-sm" readonly/>
											</div>
                                    ';
                            echo '
								            <div class="form-group">
								            	<label>Old Password</label><br>
												<input type="password"  name="oldPassword" value="" class="form-control input-sm" />
											</div>
                                    ';
                            echo '
								            <div class="form-group">
								            	<label>New Password</label><br>
												<input type="password"  name="' . $value['Field'] . '" value="" class="form-control input-sm" />
											</div>
                                    ';
                            echo '
								            <div class="form-group">
								            	<label>Confirm Password</label><br>
												<input type="password"  name="confirmPassword" value="" class="form-control input-sm" />
											</div>
                                    ';
                        } else if ($value['Field'] == "full_name") {
                            echo '
								            <div class="form-group">
								            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" value="' . $single_record[$x] . '" class="form-control input-sm" readonly/>
											</div>
                                    ';
                        } else {
                            if (!isset($single_record)) {

                                echo '
                                                <div class="form-group">
                                                     <input type="hidden" name="' . $value['Field'] . '" class="form-control input-sm" readonly/>
                                                </div>
                                            ';
                                continue;
                            } else {

                                echo '
                                                <div class="form-group">
                                                    <input type="hidden" value="' . $single_record[$x] . '"   name="' . $value['Field'] . '" class="form-control input-sm" readonly/>
                                                </div>
                                            ';
                            }
                        }
                        $x++;
                    }
                    ?>  
                    <div >
                        <!-- this takes the user back to the previous page -->
                        <a href='<?php echo URL . "uasettings/"; ?>'>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </a>
                        <button  type="submit" class="btn btn-primary" name="update-password-data" id="update-uas-data">Update Details</button>
                    </div>
                </div>


            </div>
        </div>
    </form>
</div>