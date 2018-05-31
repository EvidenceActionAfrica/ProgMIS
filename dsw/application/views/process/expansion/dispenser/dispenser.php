<?php
isset($tabActive)?$tabActive=$tabActive:$tabActive='tab1';
$GETprogram=isset($_GET['program'])?$_GET['program']:null;
//$tabActive='tab2';
?>
    <div class="col-md-10">
                    <?php if (isset($message)) { ?>
                <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
                    <?php 
                        echo $message;
                    ?>
                    <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </div>
                <?php } ?>
                <h3 class="text-center">Plan Installation-Cem Schedules</h3>
                    
                        <ul class="nav nav-pills">
                            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Create Schedules</a></li>
                            <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Setup Installations</a></li>
                        </ul>
                        <div class="tab-content">
                           
                            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1" >
                                <div  id="myModalStart" tabindex="-1" role="dialog" style="margin-top:5%;">
                                    <form  action="<?php echo URL; ?>expansion/dispenserInstallAdd/dispenser_installation_schedule/"  method="post" role="form" id="modal-form">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php
                                                 


                                                    foreach ($fields as $key => $value) {
                                                        if($value['Key'] == 'PRI'){
                                                            continue;
                                                        }elseif ($value['Key'] == 'MUL' && $value['Field'] =="country") {
                                                            echo '
                                                                <div class="form-group">
                                                             
                                                                    <input type="hidden" name="'.$value['Field'].'" value="'.$_SESSION['country'].'"  readonly />
                                                                </div>';
                                                        } else if ($value['Key'] == 'MUL' && $value['Field'] =="full_name") {
                                                            echo '
                                                                <div class="form-group">
                                                                <label>Field Officer\'s Name</label><br>
                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select Field Officer\'s Name</option>';
                                                                        foreach ($value['parents'] as $key => $value_) {
                                                                            echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                                        }
                                                                        echo '</select>
                                                                </div>';
                                                        }else if ($value['Key'] == 'MUL') {
                                                            echo '
                                                                <div class="form-group">
                                                                            <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                                        foreach ($value['parents'] as $key => $value_) {
                                                                          
                                                                             echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                                         
                                                                        }
                                                                        echo '</select>
                                                                </div>';
                                                        } else if ($value['Field'] == 'cem_start_date') {
                                                       echo ' <input id="' . $value['Field'] . '" type="hidden" name="' . $value['Field'] . '" class="form-control input-sm" readonly/>';
                                                         }  else if ($value['Field'] == 'email') {
                                                            echo '
                                                                <div class="form-group">
                                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                    <input type="email" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
                                                                            </div>
                                                                    ';
                                                        } else if (strpos($value['Field'], 'phone') !== false) {
                                                            echo '
                                                                <div class="form-group">
                                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                    <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                                            </div>
                                                                    ';
                                                        } else if (strpos($value['Field'], 'contact') !== false) {
                                                            echo '
                                                                <div class="form-group">
                                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                    <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                                            </div>
                                                                    ';
                                                        } else if (strpos($value['Field'], 'program') !== false  && $GETprogram!=null) {
                                                         echo '
                                                                <div class="form-group">
                                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                    <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" value="'.$GETprogram.'" readonly/>
                                                                            </div>
                                                                    ';
                                                        }else if (strpos($value['Field'], 'program') !== false  && $GETprogram==null) {
                                                                echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                                           '; 
                                                                                           foreach ($programDropDown as $key => $value) {
                                                                                               echo '<option value="'.$value['program'].'">'.$value['program'].'</option>';
                                                                                           }

                                                                                    echo '</select>
                                                                    </div>
                                                                        
                                                                        ';
                                                        }  else if (strpos($value['Field'], 'date') !== false) {
                                                            echo '
                                                                    <div class="form-group">
                                                                        <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                        <input type="text" name="' . $value['Field'] . '" class="datepicker form-control input-sm "  />
                                                                    </div>
                                                                ';
                                                        }else if(strpos($value['Field'], 'verified_status') !== false){
                                                            continue;
                                                        }else {
                                                            echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                        <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                                    </div>
                                                                ';
                                                        }
                                                    }
                                                    ?>  
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                 <button  type="submit" class="btn btn-primary" name="add-dInstall-data" id="add-verification-data">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>  
                            </div>
                            <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="40px" style="position:absolute;top:50%;left:50%;margin:0 auto; visibility: visible"/>
                      
                             <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2" >
                                
                                    <div class="table-responsive" style="margin-top:5%;">
                                        <?php if (!empty($data)) { ?>

                                            <table id="data-table" class=" table-bordered  table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="index">#</th>
                                                        <?php


                                                        foreach ($data[0] as $key => $value) {
                                                            
                                                            if (!in_array($key, $arrayName = array('id'))) {

                                                                if ($key == "country" || $key == "Country") {
                                                                    continue;
                                                                }else if ($key == "programId") {
                                                                  continue;
                                                                }else {
                                                                   
                                                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                                                }
                                                            }
                                                        }
                                                  ?>

                                                  <th class="buttons"></th>
                                                  <th class="buttons">Field Officer(s)</th>
                                                 
                                                  <th class="buttons"></th>
                                               
                                                  
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th class="index">#</th>
                                                        <?php


                                                        foreach ($data[0] as $key => $value) {
                                                            
                                                            if (!in_array($key, $arrayName = array('id'))) {

                                                                if ($key == "country" || $key == "Country") {
                                                                    continue;
                                                                }else if ($key == "programId") {
                                                                  continue;
                                                                }else {
                                                                   
                                                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                                                }
                                                            }
                                                        }
                                                  ?>

                                                  <th class="buttons"></th>
                                                  <th class="buttons"></th>
                                                 
                                                  <th class="buttons"></th>
                                               
                                                  
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                 
                                                    // echo "<pre>";var_dump($data);echo "</pre>";
                                                    foreach ($data as $key => $value) {
                                                        ?>
                                                        <tr>
                                                        <td class="index"></td>
                                                            <?php
                                                            foreach ($value as $key2 => $value2) {
                                                                // echo "<pre>";var_dump($key);echo "</pre>";         
                                                                
                                                                if (!in_array($key2, $arrayName = array('id'))) {

                                                                    if ($key2 == "country" || $key2 == "Country") {
                                                                        continue;
                                                                    }else if ($key2 == "programId") {
                                                                        $programId=$value2;
                                                                        continue;
                                                                    }  else if($key2=="vcs_status"){
                                                                         if($value2>=1){
                                                                               echo '<td class="export-visible" style="text-align:center"><span title="YES." data-toggle="tooltip" data-placement="left" style="color:#3B7A57;">VCS DONE</span></td>';
                                                                        }else{
                                                                               echo '<td class="export-visible" style="text-align:center"><span data-toggle="tooltip" data-placement="left" title="VCS NOT DONE" style="color:#E81919;">VCS NOT DONE</span></td>';
                                                                        }

                                                                    } else {
                                                                        echo '<td class="export-visible text-center">' . $value2 . '</td>';
                                                                    }
                                                                }
                                                               
                                                            }
                                                           
                                                            
                                                            ?>
                                                            <td class="buttons"><a href="<?php echo URL.'expansion/dispenserInstall/dispenser_material/'.rawurlencode($value['program']) .'/?tabActive=tab4';?>" class="btn btn-default btn-xs">Materials</a></td>
                                                            <td class="buttons" style='margin:1%;'><a href="<?php echo URL.'expansion/dispenserInstall/?addOfficersFor='.$programId; ?>"  class="btn btn-default btn-xs">Add</a>
                                                            <a href="<?php echo URL.'expansion/dispenserInstall/?viewOfficersFor='.$programId; ?>" class="btn btn-default btn-xs">View</a></td>

                                                            <td class="buttons"><a href="<?php echo URL.'expansion/dispenserInstallUpdate/dispenser_installation_schedule/'.$value['id'] ?>" class="btn btn-default btn-xs">Edit</a>
                                                            <a onclick="show_confirm('dispenser_installation_schedule','<?php echo $value['id']; ?>')" class="btn btn-default btn-xs">Delete</a></td>
                                                        
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

                            </div>
                              

                            <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
                             <button type="button" id='officialsModel' data-toggle="modal" data-target="#myofficialsModel" style='display:none;'>View Officials</button>
                               
                                 <?php
                                         if(isset($_GET['addOfficersFor'])){
                                    ?>
                                    <div class='col-md-12'>
                                        <span class="text-center" style="font-weight:bolder;">Click To Select Field Officers For Program <?php echo $_GET['addOfficersFor']; ?></span>
                                            <div class="table-responsive" style="margin-top:5%;">
                                            

                                                <table id="officialDataTable" class="table table-striped table-hover">
                                                    <thead>
                                                    <tr><td>Official</td></tr>
                                                    </thead>
                                                    <tbody>
                                                         <?php
                                                               if(!empty($fieldOfficers)){  
                                                                  foreach ($fieldOfficers as $key => $value) {
                                                                 
                                                                      $fieldOfficers=$value['full_name'];

                                                                     
                                                                      echo '<tr class="officials">';
                                                                      echo '<td class="officalName">'.$fieldOfficers.'</td>';
                                                                      echo "</tr>";
                                                                     

                                                                  }
                                                              }else{
                                                                echo '<tr>';
                                                                echo '<td>No Officials Selected</td>';
                                                                echo '</tr>';

                                                              }
                                                          ?>

                                                    </tbody>
                                                </table>
                                                <a id="buttonOfficials" class="btn btn-success">Save Officials</a>
                                  
                                            </div>
                                    </div>
                                      <?php
                                        }
                                        ?>
                                     
                       		</div>
		                   <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">
		                                    <div class="table-responsive" style="margin-top:5%;">
		                                         <div class="btn-group pull-right" style="margin-bottom:2%;">
		                                            <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal3">Add Material</button>
		                                    </div>
		                                
		                                              <h3>Materials</h3>
		                                    <?php if (!empty($Fodata)) { ?>

		                                        <table id="data-table1" class=" table table-striped table-hover">
		                                            <thead>
		                                                <tr>
		                                                    <?php
		                                                    foreach ($Fodata[0] as $key => $value) {
		                                                        
		                                                        if (!in_array($key, $arrayName = array('id'))) {

		                                                            if ($key == "country" || $key == "Country") {
		                                                                continue;
		                                                            }else {
		                                                               
		                                                                echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
		                                                            }
		                                                        }
		                                                    }
		                                              ?>
		                                              <th></th>
		                                               <th></th>
		                                                </tr>
		                                            </thead>
		                                            <tbody>
		                                                <?php
		                                                $i = 0;
		                                                // echo "<pre>";var_dump($data);echo "</pre>";
		                                                foreach ($Fodata as $key => $value) {
		                                                    ?>
		                                                    <tr>
		                                                        <?php
		                                                        foreach ($value as $key2 => $value2) {
		                                                            // echo "<pre>";var_dump($key);echo "</pre>";         
		                                                            
		                                                            if (!in_array($key2, $arrayName = array('id'))) {

		                                                                if ($key2 == "country" || $key2 == "Country") {
		                                                                    continue;
		                                                                } else {
		                                                                    echo '<td class="text-center">' . $value2 . '</td>';
		                                                                }
		                                                            }
		                                                            // $i = 0;  
		                                                        }
		                                                        // $i = 1;
		                                                        
		                                                        ?>
		                                                         <td><a href="<?php echo URL.'expansion/dispenserUtilitesUpdate/dispenser_material/'.$value['id'] ?>" class="btn btn-success btn-xs">Edit</a></td>
		                                                        <td><a onclick="show_confirm('dispenser_material','<?php echo $value['id']; ?>')"  class="btn btn-danger btn-xs">Delete</a></td>
		                                                
		                                                    </tr>
		                                                    <?php
		                                                    $i++;
		                                                }
		                                                ?>                  
		                                            </tbody>
		                                        </table>

		                                    <?php } else { ?>

		                                       
		                                          <p><b>No Materials Have Been Entered Yet..</b></p>

		                                    <?php } ?>
		                      			 </div>
		                   </div>
                        </div>
      
         
        <!-- Modal -->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo "Add F.O Details"; ?></h4>
                    </div>
                    <form  action="<?php echo URL; ?>expansion/dispenserInstallAdd/dispenser_installation_field_officers/" data-async data-target="myModal" method="post" role="form" id="modal-form">
                        <div class="modal-body">
                            <div id="message"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                 
                                    foreach ($FOfields as $key => $value) {
                                        if ($value['Key'] == 'PRI') {
                                            continue;
                                        }elseif ($value['Key'] == 'MUL' && $value['Field'] =="country") {
                                                                      echo '
                                                                            <div class="form-group">
                                                                            <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                    <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                                                    foreach ($value['parents'] as $key => $value_) {
                                                                                       
                                                                                        if($value_['id']==$_SESSION['country']){
                                                                                        echo'<option value="' . $value_['id'] . '" selected >' . $value_[$value['Field']] . '</option>';
                                                                                        }else{
                                                                                         echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                                                        
                                                                                        }

                                                                        }
                                                                        echo '</select>
                                                                </div>';
                                        } else if ($value['Key'] == 'MUL' && $value['Field']=='full_name') {
                                            echo '
                                                <div class="form-group">
                                                <label for="' . $value['Field'] . '" >Field Officer</label><br>
                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select Field Officer</option>';
                                                        foreach ($value['parents'] as $key => $value_) {
                                                            echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                        }
                                                        echo '</select>
                                                </div>';
                                        }else if ($value['Key'] == 'MUL'&& $value['Field']=='program') {
                                            echo '
                                                <div class="form-group">
                                                <label for="' . $value['Field'] . '" >' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                        foreach ($value['parents'] as $key => $value_) {
                                                            if($value_[$value['Field']]==$verificationId){
                                                            echo'<option value="' . $value_['id'] . '" selected>' . $value_[$value['Field']] . '</option>';
                                                                
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
                            <button  type="submit" class="btn btn-primary" name="add-FO-data" id="add-FO-data">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
          <!-- Modal -->
        <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Material</h4>
                    </div>

                    <form  action="<?php echo URL; ?>expansion/dispenserInstallAdd/dispenser_material/" data-async data-target="myModal3" method="post" role="form" id="modal-form">
                        <div class="modal-body">
                            <div id="message"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="repeater">
                                        <div class="r-group row">
                                            <?php                                 
                                                foreach ($FOfields as $key => $value) {
                                                    if ($value['Key'] == 'PRI') {
                                                        continue;
                                                    } else if ($value['Key'] == 'MUL' && $value['Field']=='full_name') {
                                                        echo '
                                                            <div class="form-group">
                                                            <label for="' . $value['Field'] . '" >Field Officer</label><br>
                                                                    <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select Field Officer</option>';
                                                                    foreach ($value['parents'] as $key => $value_) {
                                                                        echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                                    }
                                                                    echo '</select>
                                                            </div>';
                                                    }else if ($value['Key'] == 'MUL') {
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
                                                    }else if (strpos($value['Field'], 'program') !== false) {
                                                                            echo '
                                                                                <div class="form-group col-md-3">
                                                                                    <label  for="' . $value['Field'] . '" data-pattern-text="' . $value['Field'] . ' ++:">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                                    <select id="' . $value['Field'] . '" name="' . $value['Field'] . '[]" class="form-control input-sm">
                                                                                                       '; 
                                                                                                       foreach ($programDropDown as $key => $value) {
                                                                                                           echo '<option value="'.$value['program'].'">'.$value['program'].'</option>';
                                                                                                       }

                                                                                                echo '</select>
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
                                                                <div class="form-group col-md-3">
                                                                    <label for="' . $value['Field'] . '" data-pattern-text="' . $value['Field'] . ' ++:">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                    <input id="' . $value['Field'] . '" type="text" name="' . $value['Field'] . '[]" class="form-control input-sm"/>
                                                                </div>
                                                            ';
                                                    }
                                                }
                                            ?>  
                                            <div class="form-group col-md-1">
                                                <button type="button" class="r-btnRemove btn btn-danger btn-xs" style="margin-top:29px;"><span class="glyphicon glyphicon-minus" ></span></button>
                                            </div>
                                        </div> 
                                        <button type="button" class="r-btnAdd btn btn-primary btn-block">Add <span class="glyphicon glyphicon-plus"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button  type="submit" class="btn btn-primary" name="add-Material-data" id="add-Material-data">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
        <div class="modal fade" id="myofficialsModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h3>List Of Officials </h3>
                  </div>
              
                      <div class="modal-body">
                          <table  id='viewDataTable' class="table table-stripped table-hover">
                              <thead>
                              <tr>
                                  <td><b>Official</b></td>
                              
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                           if(!empty($fieldOfficersArray)){  
                              foreach ($fieldOfficersArray as $key => $value) {
                             
                                  $fieldOfficers=$value['field_officer'];
                                  
                                 
                                  echo "<tr>";
                                  echo '<td class="officalName">'.$fieldOfficers.'</td>';
                                  echo "</tr>";
                                 

                              }
                          }else{
                            echo '<tr>';
                            echo '<td>No Officials Selected</td>';
                            echo '</tr>';

                          }


                              ?>
                              </tbody>
                          </table>
                          <a id="removeButton" class="btn btn-success">Remove Selected</a>
                      </div>
              </div>
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
<script>
    $(function () {
        $('#myTab a:last').tab('show')
    });

    $('#myModal2').on('show.bs.modal', function(e) {
        autoColumn(3, '#myModal2 .modal-body .row', 'div', 'col-md-4');
    });

    // $('#myModal3').on('show.bs.modal', function(e) {
    //     autoColumn(3, '#myModal3 .modal-body .row', 'div', 'col-md-4');
    // });

   window.onload = function() {
        autoColumn(3, '#myModalStart .modal-body .row', 'div', 'col-md-4');
        <?php
            if(isset($_GET['viewOfficersFor'])){
                echo "
                    var btn=document.getElementById('officialsModel');"
            . "btn.click();"
            . "console.log('Button Called');";
            }
        ?>
    };

    $(document).ready(function() {
    
     $('#data-table1').dataTable({
        
    });
    });


    function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>expansion/dispenserInstallDelete/' + tables + '/' + deleteId);
        } else {
            return false;
        }
    }

    $(document).ready(function() {
        $('#officialDataTable').DataTable( {
            dom: 'T<"clear">lfrtip',
            tableTools: {
                "sRowSelect": "multi",
                "aButtons": [ "select_all", "select_none" ]
            }
        } );
    });

    $(document).ready(function() {
        $('#viewDataTable').DataTable( {
            dom: 'T<"clear">lfrtip',
            tableTools: {
                "sRowSelect": "multi",
                "aButtons": [ "select_all", "select_none" ]
            }
        } );
    });

    //JavaScript post request like a form submit
    function post_to_url(path, params, method) {
         method = method || "post";

         var form = document.createElement("form");
         form.setAttribute("method", method);
         form.setAttribute("action", path);

         for(var key in params) {
             if(params.hasOwnProperty(key)) {
                 var hiddenField = document.createElement("input");
                 hiddenField.setAttribute("type", "hidden");
                 hiddenField.setAttribute("name", key);
                 hiddenField.setAttribute("value", params[key]);

                 form.appendChild(hiddenField);
              }
         }

         document.body.appendChild(form);
         form.submit();
    }

    function fnGetSelected(oTableLocal) {

        var selected = $(oTableLocal + ' tr.DTTT_selected'),
            Officials = [];

        $(selected).each(function () {
            Officials.push($(this).find('.officalName').text());
        });

        console.log(Officials);

        <?php
            if(isset($_GET['addOfficersFor'])){
            $program=$_GET['addOfficersFor'];
            }else{
                $program='none';
            }
        ?>

        if (Officials.length > 0) {
            post_to_url("<?php echo URL.'expansion/dispenserOfficialsAdd/'.$program;?>", {officialsArray: Officials});
        };

    }

    function fnRemoveSelected(oTableLocal) {

        var selected = $(oTableLocal + ' tr.DTTT_selected'),
            Officials = [];

        $(selected).each(function () {
            Officials.push($(this).find('.officalName').text());
        });

        console.log(Officials);

        <?php
            if(isset($_GET['viewOfficersFor'])){
            $program=$_GET['viewOfficersFor'];
            }else{
                $program='none';
            }
        ?>

        if (Officials.length > 0) {
            post_to_url("<?php echo URL.'expansion/dispenserOfficialsDelete/'.$program;?>", {officialsArray: Officials});
        };

    }


    $('body').on('click','#buttonOfficials', function(){

        fnGetSelected('#officialDataTable');

    });

    $('body').on('click','#removeButton', function(){
        if (confirm("Are you sure you want to delete?")) {
            fnRemoveSelected('#viewDataTable');
        } else {
            return false;
        }
    });
</script>


<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.form-repeater.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.repeater').repeater({
          btnAddClass: 'r-btnAdd',
          btnRemoveClass: 'r-btnRemove',
          groupClass: 'r-group',
          minItems: 1,
          maxItems: 0,
          startingIndex: 0,
          reindexOnDelete: true,
          repeatMode: 'prepend',
          animation: null,
          animationSpeed: 400,
          animationEasing: 'swing',
          clearValues: true
        });
    });
</script>