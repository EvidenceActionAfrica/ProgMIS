<?php
isset($tabActive)?$tabActive=$tabActive:$tabActive='tab1';

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
                <h3 class="text-center">Plan A Verification</h3>
                    
                        <ul class="nav nav-pills">
                            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Create Verification</a></li>
                            <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Setup Verification Details</a></li>
                        </ul>
                        <div class="tab-content">
                           
                            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1" >
                              


                                <div  id="myModal" tabindex="-1" role="dialog" style="margin-top:5%;">
                                       
                                            <div >
                                            
                                                <form  action="<?php echo URL; ?>expansion/sVerificationAdd/<?php echo $table; ?>"  method="post" role="form" id="modal-form">
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
                                                                }elseif ($value['Key'] == 'MUL' && $value['Field'] !="full_name") {
                                                                        echo '
                                                                            <div class="form-group">
                                                                            <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                    <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                                                    foreach ($value['parents'] as $key => $value_) {
                                                                                        echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                                                    }
                                                                                    echo '</select>
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
                                                                    } else if ($value['Field'] == 'email') {
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
                                                                    } else if (strpos($value['Field'], 'date') !== false) {
                                                                        echo '
                                                                                <div class="form-group">
                                                                                    <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
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
                                                             <button  type="submit" class="btn btn-primary" name="add-verification-data" id="add-verification-data">Save</button>
                                                        </div>
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                </div>  
                                       
                            </div>
                           
                             <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2" >
                                
                                    <div class="table-responsive" style="margin-top:5%;">
                                        <?php if (!empty($data)) { ?>

                                            <table id="" class="data-table table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <?php


                                                        foreach ($data[0] as $key => $value) {
                                                            
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
                                                  <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                 
                                                    // echo "<pre>";var_dump($data);echo "</pre>";
                                                    foreach ($data as $key => $value) {
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
                                                               
                                                            }
                                                           
                                                            
                                                            ?>
                                                            <td><a href="<?php echo URL.'expansion/siteVerification/FoDeploy/'.$value['program'] ?>" class="btn btn-success btn-xs">Field Officer(s)</a></td>
                                                            <td><a href="<?php echo URL.'expansion/sVerificationUpdate/site_verification/'.$value['id'] ?>" class="btn btn-success btn-xs">Edit</a></td>
                                                            <td><a onclick="show_confirm('site_verification','<?php echo $value['id']; ?>')" class="btn btn-danger btn-xs">Delete</a></td>
                                                        
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

                                         <div class="table-responsive" style="margin-top:5%;">
                                             <div class="btn-group pull-right" style="margin-bottom:2%;">
                                                <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal2">Add Field Officer</button>
                                            </div>
                                            <br/>
                                        <?php if (!empty($Fodata)) { ?>

                                            <table id="" class="data-table table table-striped table-hover">
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
                                                             <td><a href="<?php echo URL.'expansion/sVerificationUpdate/waterpoint_verification/'.$value['id'] ?>" class="btn btn-success btn-xs">Edit</a></td>
                                                            <td><a onclick="show_confirm('waterpoint_verification','<?php echo $value['id']; ?>')"  class="btn btn-danger btn-xs">Delete</a></td>
                                                    
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>                  
                                                </tbody>
                                            </table>

                                        <?php } else { ?>

                                            <p><b>No Field Officer Has Been Scheduled Yet..</b></p>

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
                    <form  action="<?php echo URL; ?>expansion/sVerificationAdd/waterpoint_verification" data-async data-target="myModal" method="post" role="form" id="modal-form">
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
                                        }else if ($value['Key'] == 'MUL' && $value['Field']=='full_name') {
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

<script>
  $(function () {
    $('#myTab a:last').tab('show')
  })
    $('#myModal2').on('show.bs.modal', function(e) {

        autoColumn(3, '#myModal2 .modal-body .row', 'div', 'col-md-4');
      

    });
   window.onload = function() {
           // $("#mymodal").show();
            autoColumn(2, '#myModal .modal-body .row', 'div', 'col-md-4');

        };
    $(document).ready(function() {
        $('.data-table').dataTable();
    });

  function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>expansion/sVerificationDelete/' + tables + '/' + deleteId);

        } else {
            return false;
        }
    }
</script>
