<?php
$tabActive = "tab1";
?>
<!-- Modal -->
<div id="myModal" class="col-md-10" >
    <div >
        <div >
            <div>
                <h4 class="text-center" ><?php echo "Edit " . $tableName . " Privileges"; ?></h4>
            </div>
            <form  action="<?php echo URL; ?>generalclass/update/<?php echo $table ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">

                <div class="modal-body">
                    <div id="message"></div>
                    <div class="tabbable">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills">
                            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Administrative Module</a></li>
                            <li<?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Process Module</a></li>
                            <li<?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">Performance Module</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                                
                                <div class="form-group col-md-4">
                                    <h4>Country Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Asset list Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Fleet List Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                           
                                <div class="form-group col-md-4">
                                    <h4>Staff List Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Waterpoint List  Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                            
                            </div>
                            

                            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
                                  <div class="form-group col-md-4">
                                    <h4>Chlorine Manager Privileges</h4>
                                    <h5>Inventory</h5>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <h4>Chlorine Manager Privileges</h4>
                                    <h5>Planning</h5>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>    

                                <div class="form-group col-md-4">
                                    <h4>Chlorine Manager Privileges</h4>
                                    <h5>Tracking</h5>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>    

                                <div class="form-group col-md-4">
                                    <h4>Fleet Manager Privileges</h4>
                                    <h5>Planning</h5>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Fleet Manager Privileges</h4>
                                    <h5>Tracking</h5>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <h4>Promoter <br/>Engagement<br/> Privileges</h4>
                                    <label>Kenya</label><br/>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                   <br/>
                                    <label>Uganda</label><br/>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                          
                                <div class="form-group col-md-4">
                                    <h4>Issue Tracker Privileges</h4>
                                    <label>Kenya</label><br/>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br/>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br/>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Evaluation Privileges</h4>
                                    <label>Kenya</label><br/>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br/>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br/>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Expansion Privileges</h4>
                                    <label>Kenya</label><br/>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br/>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br/>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                            
                            
                            
                            
                            </div>

                            <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
                                <h3>DashBoard reports</h3> 
                                <div class="form-group col-md-4">
                                    <h4>On Demand</h4><br/>

                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Other Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <h4>Standard Reports Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <h4>Diagnostic Privileges</h4>
                                    <label>Kenya</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Malawi</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                    <br/>
                                    <label>Uganda</label><br>
                                    <select name="priv_counties" class="input_select_priv">
                                        <option value='0'>0 - No Access</option>
                                        <option value='1' selected="selected">1 - View</option>
                                        <option value='2'>2 - View, Add</option>
                                        <option value='3'>3 - View, Add, Edit</option>
                                        <option value='4'>4 - View, Add, Edit, Delete</option>
                                    </select>
                                </div>
                            
                            
                            
                            
                            </div>

                        </div>

                    </div>
                    <div class="col-md-offset-4">
                        <!-- this takes the user back to the previous page -->
                        <a href='<?php echo URL . "uasettings/uasgeneral/" ?>'>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </a>
                        <button  type="submit" class="btn btn-primary" name="update" id="add-uas-data">Update Details</button>
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