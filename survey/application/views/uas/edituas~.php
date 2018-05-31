<?php
$tabActive = "tab1";
$id=$dd[0]["id"];
$employeeId=$dd[0]["employee_id"];
$fullName=$dd[0]["full_name"];
$phone=$dd[0]["phone"];
$email=$dd[0]["email"];
$password=$dd[0]["password"];
$position=$dd[0]["position"];
$country=$dd[0]["country"];
$priv_kenya=$dd[0]["priv_kenya"];
$priv_malawi=$dd[0]["priv_malawi"];
$priv_uganda=$dd[0]["priv_uganda"];
$priv_asset_list_kenya=$dd[0]["priv_asset_list_kenya"];
$priv_asset_list_malawi=$dd[0]["priv_asset_list_malawi"];
$priv_asset_list_uganda=$dd[0]["priv_asset_list_uganda"];
$priv_fleet_list_kenya=$dd[0]["priv_fleet_list_kenya"];
$priv_fleet_list_malawi=$dd[0]["priv_fleet_list_malawi"];
$priv_fleet_list_uganda=$dd[0]["priv_fleet_list_uganda"];
$priv_staff_list_kenya=$dd[0]["priv_staff_list_kenya"];
$priv_staff_list_malawi=$dd[0]["priv_staff_list_malawi"];
$priv_staff_list_uganda=$dd[0]["priv_staff_list_uganda"];
$priv_waterpoint_list_kenya=$dd[0]["priv_waterpoint_list_kenya"];
$priv_waterpoint_list_malawi=$dd[0]["priv_waterpoint_list_malawi"];
$priv_waterpoint_list_uganda=$dd[0]["priv_waterpoint_list_uganda"];
$priv_chlorine_inventory_kenya=$dd[0]["priv_chlorine_inventory_kenya"];
$priv_chlorine_inventory_malawi=$dd[0]["priv_chlorine_inventory_malawi"];
$priv_chlorine_inventory_uganda=$dd[0]["priv_chlorine_inventory_uganda"];
$priv_chlorine_planning_kenya=$dd[0]["priv_chlorine_planning_kenya"];
$priv_chlorine_planning_malawi=$dd[0]["priv_chlorine_planning_malawi"];
$priv_chlorine_planning_uganda=$dd[0]["priv_chlorine_planning_uganda"];
$priv_chlorine_tracking_kenya=$dd[0]["priv_chlorine_tracking_kenya"];
$priv_chlorine_tracking_malawi=$dd[0]["priv_chlorine_tracking_malawi"];
$priv_chlorine_tracking_uganda=$dd[0]["priv_chlorine_tracking_uganda"];

$priv_fleet_manager_planning_kenya=$dd[0]["priv_fleet_manager_planning_kenya"];
$priv_fleet_manager_planning_malawi=$dd[0]["priv_fleet_manager_planning_malawi"];
$priv_fleet_manager_planning_uganda=$dd[0]["priv_fleet_manager_planning_uganda"];

$priv_fleet_manager_tracking_kenya=$dd[0]["priv_fleet_manager_tracking_kenya"];
$priv_fleet_manager_tracking_malawi=$dd[0]["priv_fleet_manager_tracking_malawi"];
$priv_fleet_manager_tracking_uganda=$dd[0]["priv_fleet_manager_tracking_uganda"];

$priv_promoter_engagement_kenya=$dd[0]["priv_promoter_engagement_kenya"];
$priv_promoter_engagement_malawi=$dd[0]["priv_promoter_engagement_malawi"];
$priv_promoter_engagement_uganda=$dd[0]["priv_promoter_engagement_uganda"];

$priv_dispenser_kenya=$dd[0]["priv_dispenser_kenya"];
$priv_dispenser_malawi=$dd[0]["priv_dispenser_malawi"];
$priv_dispenser_uganda=$dd[0]["priv_dispenser_uganda"];

$priv_issue_tracker_kenya=$dd[0]["priv_issue_tracker_kenya"];
$priv_issue_tracker_malawi=$dd[0]["priv_issue_tracker_malawi"];
$priv_issue_tracker_uganda=$dd[0]["priv_issue_tracker_uganda"];

$priv_evaluation_kenya=$dd[0]["priv_evaluation_kenya"];
$priv_evaluation_malawi=$dd[0]["priv_evaluation_malawi"];
$priv_evaluation_uganda=$dd[0]["priv_evaluation_uganda"];

$priv_expansion_kenya=$dd[0]["priv_expansion_kenya"];
$priv_expansion_malawi=$dd[0]["priv_expansion_malawi"];
$priv_expansion_uganda=$dd[0]["priv_expansion_uganda"];

$priv_on_demand_kenya=$dd[0]["priv_on_demand_uganda"];
$priv_on_demand_malawi=$dd[0]["priv_on_demand_uganda"];
$priv_on_demand_uganda=$dd[0]["priv_on_demand_uganda"];

$priv_other_kenya=$dd[0]["priv_other_kenya"];
$priv_other_malawi=$dd[0]["priv_other_malawi"];
$priv_other_uganda=$dd[0]["priv_other_uganda"];

$priv_standard_reports_kenya=$dd[0]["priv_standard_reports_kenya"];
$priv_standard_reports_malawi=$dd[0]["priv_standard_reports_malawi"];
$priv_standard_reports_uganda=$dd[0]["priv_standard_reports_uganda"];

$priv_diagnostic_kenya=$dd[0]["priv_diagnostic_kenya"];
$priv_diagnostic_malawi=$dd[0]["priv_diagnostic_malawi"];
$priv_diagnostic_uganda=$dd[0]["priv_diagnostic_uganda"];


?>
<!-- Modal -->
<div id="myModal" class="col-md-10" >
    <div >
        <div >
            <div>
                <h4 class="text-center" ><?php echo "Edit " . $tableName . " Privileges"; ?></h4>
            </div>
            <form  action="<?php echo URL; ?>uasettings/update/<?php echo $table ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">

                <div class="modal-body">
                    <div id="message"></div>
                    <div class="tabbable">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills">
                            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Basic Staff Details</a></li>
                            <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Administrative Module</a></li>
                            <li<?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">Process Module</a></li>
                            <li<?php if ($tabActive == 'tab4') echo "class='active'" ?>><a href="#tab4" data-toggle="tab">Performance Module</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                                
                                 <div class="form-group col-md-4">
                                         <input type="hidden" name="id" class="form-control input-sm" value="<?php echo $id; ?>" />
                                      
                                      <div class="form-group">
                                          <label>Employee Id</label><br>
                                          <input type="text" name="employeeId" class="form-control input-sm" value="<?php echo $employeeId; ?>" />
                                      </div>
                                         
                                         <div class="form-group">
                                          <label>Full Name</label><br>
                                          <input type="text" name="fullName" class="form-control input-sm" value="<?php echo $fullName; ?>" />
                                      </div>
                                         <div class="form-group">
                                          <label>Email</label><br>
                                          <input type="text" name="email" class="form-control input-sm" value="<?php echo $email; ?>" />
                                      </div>
                                   <div class="form-group">
                                          <label>Phone</label><br>
                                          <input type="text" name="phone" class="form-control input-sm" value="<?php echo $phone; ?>" />
                                      </div>
                                      <div class="form-group">
                                          <label>Position</label><br>
                                          <input type="text" name="position" class="form-control input-sm" value="<?php echo $position; ?>" />
                                      </div>
                                      <div class="form-group">
                                          <label>Country</label><br>
                                          <input type="text" name="country" class="form-control input-sm" value="<?php echo $country; ?>" />
                                      </div>
                                         
                                         
                                 </div>
                                <div class="col-md-4">
                                   <div class="form-group">
                                          <label>Password</label><br>
                                          <input type="text" name="password" class="form-control input-sm" value="<?php echo $password; ?>" />
                                      </div>
                                   <div class="form-group">
                                          <label>Old Password</label><br>
                                          <input type="text" name="oldPassword" class="form-control input-sm" value="" />
                                      </div>
                                   <div class="form-group">
                                          <label>New Password</label><br>
                                          <input type="text" name="newPassword" class="form-control input-sm" value="" />
                                      </div>
                                   <div class="form-group">
                                          <label>Confirm New Password</label><br>
                                          <input type="text" name="confirmPassword" class="form-control input-sm" value="" />
                                      </div>
                                 
                                 </div>
                                
                                
                                
                            </div>
                            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
                            
                                <div class="form-group col-md-4">
                                    <h4>Country Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_kenya==0){ ?>selected="selected"<?php }?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_kenya==1){ ?>selected="selected"<?php }?> >1 - View</option>
                                        <option value='2' <?php if($priv_kenya==2){ ?>selected="selected"<?php }?> >2 - View, Add</option>
                                        <option value='3' <?php if($priv_kenya==3){ ?>selected="selected"<?php }?> >3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_kenya==4){ ?>selected="selected"<?php }?> >4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_malawi" class="input_select_priv">
                                        <option value='0'  <?php if($priv_malawi==0){ ?>selected="selected"<?php }?>>0 - No Access</option>
                                        <option value='1'   <?php if($priv_malawi==1){ ?>selected="selected"<?php }?>>1 - View</option>
                                        <option value='2'  <?php if($priv_malawi==2){ ?>selected="selected"<?php }?> >2 - View, Add</option>
                                        <option value='3'  <?php if($priv_malawi==3){ ?>selected="selected"<?php }?> >3 - View, Add, Edit</option>
                                        <option value='4'  <?php if($priv_malawi==4){ ?>selected="selected"<?php }?> >4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_uganda" class="input_select_priv">
                                        <option value='0'  <?php if($priv_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1'  <?php if($priv_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2'  <?php if($priv_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3'  <?php if($priv_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4'  <?php if($priv_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Asset list Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_asset_list_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_asset_list_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_asset_list_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_asset_list_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_asset_list_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_asset_list_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_asset_list_malawi" class="input_select_priv">
                                        <option value='0'  <?php if($priv_asset_list_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1'  <?php if($priv_asset_list_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2'  <?php if($priv_asset_list_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3'  <?php if($priv_asset_list_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4'  <?php if($priv_asset_list_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_asset_list_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_asset_list_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_asset_list_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_asset_list_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_asset_list_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_asset_list_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Fleet List Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_fleet_list_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_fleet_list_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_fleet_list_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_fleet_list_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_fleet_list_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_fleet_list_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_fleet_list_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_fleet_list_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_fleet_list_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_fleet_list_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_fleet_list_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_fleet_list_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_fleet_list_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_fleet_list_uganda==0){ echo "selected=selected";}?> >0 - No Access</option>
                                        <option value='1' <?php if($priv_fleet_list_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_fleet_list_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_fleet_list_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_fleet_list_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                           
                                <div class="form-group col-md-4">
                                    <h4>Staff List Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_staff_list_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_staff_list_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_staff_list_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_staff_list_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_staff_list_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_staff_list_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_staff_list_malawi" class="input_select_priv">
                                        <option value='0'  <?php if($priv_staff_list_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1'  <?php if($priv_staff_list_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2'  <?php if($priv_staff_list_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3'  <?php if($priv_staff_list_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4'  <?php if($priv_staff_list_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_staff_list_uganda" class="input_select_priv">
                                        <option value='0'  <?php if($priv_staff_list_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1'  <?php if($priv_staff_list_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2'  <?php if($priv_staff_list_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3'  <?php if($priv_staff_list_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4'  <?php if($priv_staff_list_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Waterpoint List  Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_waterpoint_list_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_waterpoint_list_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_waterpoint_list_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_waterpoint_list_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_waterpoint_list_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_waterpoint_list_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_waterpoint_list_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_waterpoint_list_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_waterpoint_list_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_waterpoint_list_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_waterpoint_list_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_waterpoint_list_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_waterpoint_list_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_waterpoint_list_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_waterpoint_list_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_waterpoint_list_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_waterpoint_list_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_waterpoint_list_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                            
                            </div>
                            

                            <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
                                  <div class="form-group col-md-4">
                                    <h4>Chlorine Manager Privileges</h4>
                                    <h5>Inventory</h5>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0' <?php if($priv_chlorine_inventory_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_chlorine_inventory_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_chlorine_inventory_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_chlorine_inventory_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_chlorine_inventory_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_chlorine_inventory_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_chlorine_inventory_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_chlorine_inventory_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_chlorine_inventory_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_chlorine_inventory_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_chlorine_inventory_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_chlorine_inventory_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_chlorine_inventory_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_chlorine_inventory_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_chlorine_inventory_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_chlorine_inventory_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_chlorine_inventory_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <h4>Chlorine Manager Privileges</h4>
                                    <h5>Planning</h5>
                                    <label>Kenya</label><br>
                                    <select name="priv_chlorine_planning_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_chlorine_planning_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_chlorine_planning_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_chlorine_planning_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_chlorine_planning_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_chlorine_planning_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_chlorine_planning_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_chlorine_planning_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_chlorine_planning_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_chlorine_planning_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_chlorine_planning_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_chlorine_planning_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_chlorine_planning_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_chlorine_planning_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_chlorine_planning_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_chlorine_planning_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_chlorine_planning_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_chlorine_planning_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>    

                                <div class="form-group col-md-4">
                                    <h4>Chlorine Manager Privileges</h4>
                                    <h5>Tracking</h5>
                                    <label>Kenya</label><br>
                                    <select name="priv_chlorine_tracking_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_chlorine_tracking_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_chlorine_tracking_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_chlorine_tracking_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_chlorine_tracking_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_chlorine_tracking_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_chlorine_tracking_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_chlorine_tracking_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_chlorine_tracking_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_chlorine_tracking_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_chlorine_tracking_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_chlorine_tracking_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_chlorine_tracking_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_chlorine_tracking_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_chlorine_tracking_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_chlorine_tracking_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_chlorine_tracking_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4'<?php  if($priv_chlorine_tracking_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>    

                                <div class="form-group col-md-4">
                                    <h4>Fleet Manager Privileges</h4>
                                    <h5>Planning</h5>
                                    <label>Kenya</label><br>
                                    <select name="priv_fleet_manager_planning_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_fleet_manager_planning_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_fleet_manager_planning_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_fleet_manager_planning_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_fleet_manager_planning_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_fleet_manager_planning_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_fleet_manager_planning_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_fleet_manager_planning_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_fleet_manager_planning_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_fleet_manager_planning_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_fleet_manager_planning_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_fleet_manager_planning_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_fleet_manager_planning_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_fleet_manager_planning_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_fleet_manager_planning_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_fleet_manager_planning_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_fleet_manager_planning_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_fleet_manager_planning_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Fleet Manager Privileges</h4>
                                    <h5>Tracking</h5>
                                    <label>Kenya</label><br>
                                    <select name="priv_fleet_manager_tracking_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_fleet_manager_tracking_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_fleet_manager_tracking_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_fleet_manager_tracking_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_fleet_manager_tracking_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_fleet_manager_tracking_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_fleet_manager_tracking_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_fleet_manager_tracking_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_fleet_manager_tracking_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_fleet_manager_tracking_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_fleet_manager_tracking_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_fleet_manager_tracking_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_fleet_manager_tracking_uganda" class="input_select_priv">
                                        <option value='0'  <?php if($priv_fleet_manager_tracking_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1'  <?php if($priv_fleet_manager_tracking_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2'  <?php if($priv_fleet_manager_tracking_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3'  <?php if($priv_fleet_manager_tracking_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4'  <?php if($priv_fleet_manager_tracking_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <h4>Promoter <br/>Engagement<br/> Privileges</h4>
                                    <label>Kenya</label><br/>
                                    <select name="priv_promoter_engagement_kenya" class="input_select_priv">
                                        <option value='0'  <?php if($priv_promoter_engagement_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1'  <?php if($priv_promoter_engagement_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2'  <?php if($priv_promoter_engagement_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3'  <?php if($priv_promoter_engagement_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4'  <?php if($priv_promoter_engagement_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_promoter_engagement_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_promoter_engagement_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_promoter_engagement_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_promoter_engagement_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_promoter_engagement_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_promoter_engagement_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                   <br/>
                                    <label>Uganda</label><br/>
                                    <select name="priv_promoter_engagement_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_promoter_engagement_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_promoter_engagement_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_promoter_engagement_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_promoter_engagement_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_promoter_engagement_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                          
                                <div class="form-group col-md-4">
                                    <h4>Issue Tracker Privileges</h4>
                                    <label>Kenya</label><br/>
                                    <select name="priv_issue_tracker_kenya" class="input_select_priv">
                                        <option value='0'  <?php if($priv_issue_tracker_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1'  <?php if($priv_issue_tracker_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2'  <?php if($priv_issue_tracker_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3'  <?php if($priv_issue_tracker_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4'  <?php if($priv_issue_tracker_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br/>
                                    <select name="priv_issue_tracker_malawi" class="input_select_priv">
                                        <option value='0'  <?php if($priv_issue_tracker_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php  if($priv_issue_tracker_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2'  <?php if($priv_issue_tracker_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3'  <?php if($priv_issue_tracker_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4'  <?php if($priv_issue_tracker_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br/>
                                    <select name="priv_issue_tracker_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_issue_tracker_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_issue_tracker_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_issue_tracker_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_issue_tracker_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_issue_tracker_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Evaluation Privileges</h4>
                                    <label>Kenya</label><br/>
                                    <select name="priv_evaluation_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_evaluation_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_evaluation_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_evaluation_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_evaluation_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_evaluation_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br/>
                                    <select name="priv_evaluation_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_evaluation_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_evaluation_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_evaluation_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_evaluation_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_evaluation_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br/>
                                    <select name="priv_evaluation_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_evaluation_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_evaluation_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_evaluation_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_evaluation_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_evaluation_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Expansion Privileges</h4>
                                    <label>Kenya</label><br/>
                                    <select name="priv_expansion_kenya" class="input_select_priv">
                                        <option value='0'  <?php if($priv_expansion_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1'  <?php if($priv_expansion_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2'  <?php if($priv_expansion_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3'  <?php if($priv_expansion_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4'  <?php if($priv_expansion_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br/>
                                    <select name="priv_expansion_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_expansion_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_expansion_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_expansion_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_expansion_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_expansion_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br/>
                                    <select name="priv_expansion_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_expansion_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_expansion_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_expansion_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_expansion_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_expansion_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                            
                            
                            
                            
                            </div>

                            <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">
                                <h3>DashBoard reports</h3> 
                                <div class="form-group col-md-4">
                                    <h4>On Demand</h4><br/>

                                    <label>Kenya</label><br>
                                    <select name="priv_on_demand_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_on_demand_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_on_demand_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_on_demand_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_on_demand_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_on_demand_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_on_demand_malawi" class="input_select_priv">
                                        <option value='0'  <?php if($priv_on_demand_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1'  <?php if($priv_on_demand_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2'  <?php if($priv_on_demand_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3'  <?php if($priv_on_demand_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4'  <?php if($priv_on_demand_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_on_demand_uganda" class="input_select_priv">
                                        <option value='0'  <?php if($priv_on_demand_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1'  <?php if($priv_on_demand_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2'  <?php if($priv_on_demand_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3'  <?php if($priv_on_demand_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4'  <?php if($priv_on_demand_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Other Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_other_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_other_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_other_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_other_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_other_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_other_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_other_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_other_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_other_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_other_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_other_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_other_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_other_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_other_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_other_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_other_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_other_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_other_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Standard Reports Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_standard_reports_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_standard_reports_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_standard_reports_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_standard_reports_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_standard_reports_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_standard_reports_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_standard_reports_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_standard_reports_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_standard_reports_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_standard_reports_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_standard_reports_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_standard_reports_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_standard_reports_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_standard_reports_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_standard_reports_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_standard_reports_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_standard_reports_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_standard_reports_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <h4>Diagnostic Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_diagnostic_kenya" class="input_select_priv">
                                        <option value='0' <?php if($priv_diagnostic_kenya==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_diagnostic_kenya==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_diagnostic_kenya==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_diagnostic_kenya==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_diagnostic_kenya==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_diagnostic_malawi" class="input_select_priv">
                                        <option value='0' <?php if($priv_diagnostic_malawi==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_diagnostic_malawi==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_diagnostic_malawi==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_diagnostic_malawi==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_diagnostic_malawi==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_diagnostic_uganda" class="input_select_priv">
                                        <option value='0' <?php if($priv_diagnostic_uganda==0){ echo "selected=selected";}?>>0 - No Access</option>
                                        <option value='1' <?php if($priv_diagnostic_uganda==1){ echo "selected=selected";}?>>1 - View</option>
                                        <option value='2' <?php if($priv_diagnostic_uganda==2){ echo "selected=selected";}?>>2 - View, Add</option>
                                        <option value='3' <?php if($priv_diagnostic_uganda==3){ echo "selected=selected";}?>>3 - View, Add, Edit</option>
                                        <option value='4' <?php if($priv_diagnostic_uganda==4){ echo "selected=selected";}?>>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                            
                            
                            
                            
                            </div>

                        </div>

                    </div>
                    <div class="col-md-offset-4">
                        <!-- this takes the user back to the previous page -->
                        <a href='<?php echo URL . "uasettings/index/" ?>'>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </a>
                        <button  type="submit" class="btn btn-primary" name="update-uas-data" id="add-uas-data">Update Details</button>
                    </div>
                </div>
            </form>

        </div>
    </div>  

    <script type="text/javascript">
        window.onload = function() {
            $("#mymodal").show();
            autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');

        };
  


    </script>