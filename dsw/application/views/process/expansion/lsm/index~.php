
    <div class="col-md-10">
                    <?php if (isset($message)) { ?>
                <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
                    <?php 
                        echo $message;
                    ?>
                    <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </div>
                <?php } ?>
                
                    
                        <ul class="nav nav-pills">
                            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Create LSM:Filter Contacts For LSM</a></li>
                            <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Create LSM:Setup Meeting Details</a></li>
                        </ul>
                        <div class="tab-content">
                           
                            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                              <form action="<?php echo URL; ?>processdata/LSMAdd/lsm_details"  method="post">
                                  <?php
                                   // $officials=isset($_POST['officials'])?filter_input(INPUT_POST, 'officials'):null;

                                    if(!isset($officials)){
                                   ?>  
                                     <div class="table-responsive" style='margin-top:10px;'>

                                         
                                        <table  class="table table-striped table-hover" >
                                            <thead>
                                                <tr>
                                                    <td>County</td>
                                                    <td>District</td>
                                                    <td>Name</td>
                                                    <td>Contact</td>
                                                    <td>Email</td>
                                                </tr>
                                            </thead>
                                           <tbody style='background:#FFF;'>
                                                <?php 
                                                $counter=1;
                                                foreach ($districtData as $key => $value) {
                                                    echo '<tr>';
                                                    echo '<td><input type="checkbox"  name="county'.$counter.'" value="'.$value["county"].'" />'.$value["county"].'</td>';
                                                    echo '<td><input style="border:0;width:100%;margin:0;padding:0;" type="text" name="district'.$counter.'" value="'.$value["district"].'" readonly/></td>';
                                                    echo '<td><input style="border:0;width:100%;margin:0;padding:0;" type="text" name="official'.$counter.'" value="'.$value["name"].' "/></td>';
                                                    echo '<td><input style="border:0;width:100%;margin:0;padding:0;" type="text" name="phone'.$counter.'" value="'.$value["phone"].' "/></td>';
                                                    echo '<td><input style="border:0;width:100%;margin:0;padding:0;" type="text" name="email'.$counter.'" value="'.$value["email"].' "/></td>';
                                                    echo '</tr>';

                                                    ++$counter;
                                                }

                                                ?>
                                          </tbody>

                                            </table>
                                            <div class="form-group">
                                               <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                              <button  type="submit" class="btn btn-primary" name="create-selected-officials" id="create-lsm-meeting">Save Officials</button>
                                            </div>
                                      </div>
                                        <?php
                                      }else{
                                        ?>
                                 
                                   <div class="form-group col-md-4 col-md-offset-3">
                                      <div class="form-group">
                                             <input type="hidden" id="country" readonly name="country" class="form-control input-sm" value="<?php echo $_SESSION['country']; ?>"/>
                                      </div>
                                      <div class="form-group">
                                             <label for="lsm_title">Title</label><br/>
                                             <input type="text" id="lsm_title" name="lsm_title" class="form-control input-sm"/>
                                      </div>

                                      <div class="form-group">
                                             <label for="meeting_date">Date Of Meeting</label><br/>
                                             <input type="text" id="meeting_date" name="meeting_date" class="form-control input-sm datepicker"/>
                                             <label for="meeting_time">Time Of Meeting</label><br/>
                                             <input type="time" id="meeting_time"  name="meeting_time" class="form-control input-sm timepicker"/>
                                     
                                      </div>
                                      
                                      <div class="form-group">
                                             <label for="location">Location</label><br/>
                                             <input type="text" id="location" name="location" class="form-control input-sm"/>
                                      </div>
                                       <div class="form-group">
                                             <textarea name='officials' readonly style='display:none;'><?php echo $officials; ?></textarea>
                                      </div>
                                      
                                       <div class="form-group">
                                             <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                             <button  type="submit" class="btn btn-primary" name="create-lsm-meeting" id="create-lsm-meeting">Save</button>
                                      </div>
                                    </div>
                                 <?php }  ?>
                              </form>
                            </div>
                           
                             <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
                                 <br/><br/><br/>
                               <button type="button" id='official' data-toggle="modal" data-target="#myofficialsModal" style='display:none;'>View Officials</button>
                                                     
                                <div class="table-responsive">
                                        <?php if (!empty($lsmData)) { ?>

                                            <table  class="table table-striped table-hover data-table">
                                                <thead>
                                                    <tr>
                                                <?php
                                                foreach ($lsmData[0] as $key => $value) {
                                                   
                                                    if (!in_array($key, $arrayName = array('id'))) {
                                                        
                                                         if ($key == "country" || $key == "Country") {
                                                                                    continue;
                                                            }else if ($key == "officials") {
                                                              continue;
                                                            }else{
                                                        echo '<td>' . ucwords(str_replace('_', ' ', $key)) . '</td>';
                                                        
                                                                                }
                                                    }
                                                }
                                                ?>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                            <?php
                                            
                                            // echo "<pre>";var_dump($data);echo "</pre>";
                                            foreach ($lsmData as $key => $value) {
                                                ?>
                                                                <tr>
                                                                    <?php
                                                                        foreach ($value as $key => $value) {
                                                                           
                                                                            if($key=="id"){
                                                                                $lsm_id=$value;
                                                                            }
                                                                            if (!in_array($key, $arrayName = array('id'))) {

                                                                                if ($key == "country" || $key == "Country") {
                                                                                    continue;
                                                                                } else if ($key == "officials") {
                                                                                    continue;
                                                                                } else {
                                                                                 echo '<td>'.$value.'</td>';
                                                                                }
                                                                            }
                                                                           
                                                                        }
                                                        ?>
                                                          <td><a href='?meetingId=<?php echo urlencode($lsm_id); ?>' class="btn btn-default btn-xs" data-toggle="modal" value="<?php echo $lsm_id; ?>">View Officials</a></td> 
                                                          <td><a href="<?php echo URL.'processdata/expansion/LSM/lsm_details/?tabActive=tab3& activeLsm='.$lsm_id; ?>"><button class="btn btn-success btn-xs">Budget</button></a></td> 
                                                          <td><a href="<?php echo URL.'processdata/expansion/LSM/lsm_details/?tabActive=tab4& activeLsm='.$lsm_id; ?>"><button class="btn btn-info btn-xs">Duties</button></a></td> 
                                                          <td><a href="<?php echo URL ?>processdata/updateExpansion/LSM/<?php echo $table . "/" . $lsm_id; ?>"><button class="btn btn-success btn-xs">Edit</button></a></td> 
                                                          <td><a onclick='show_confirm("lsm_details",<?php echo $lsm_id; ?>)' class='btn btn-danger'>Delete</a></td>
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
                               <?php
                               if(isset($_GET['activeLsm'])){
                                ?>
                               <div class="form-group col-md-10">
                                  <h4 class='text-center'>Budget Set For Meeting</h4> <br/><br/>
                                    <form method="post" action="<?php echo URL.'processdata/LSMAdd/lsm_budget_details/?tabActive=tab3&activeLsm='.$_GET['activeLsm'] ?>">
                                             <div class="form-group col-md-4">

                                                <label for="item">Item</label><br/>
                                                <input type='text' name='item' value=''/>
                                            </div>
                                             <div class="form-group col-md-4">
                                                <label for="cost">Cost</label><br/>
                                                <input type='text' name='cost' value=''/>
                                            </div>
                                            <div>
                                               <input type='hidden' name='lsm_id' value='<?php echo $_GET["activeLsm"]?>' readonly/>
                                               <br/>
                                              <button  type="submit" class="btn btn-primary" name="save-item-expense" id="save-item-expense">Save</button>
                                             </div>

                                    </form>
                                     <br/><br/>
                                           <table class='budget-table' class="display compact" cellspacing="0" width="100%">
                                              <thead>
                                              <tr>
                                                  <td>Item</td>
                                                  <td>Cost</td>
                                                  <td>Edit</td>
                                                  <td>Delete</td>
                                               </tr>
                                              </thead>
                                                <tbody>
                                                <?php
                                               if(isset($lsmBudgetData)){
                                                $totalCost=0;
                                                foreach ($lsmBudgetData as $key => $value) {
                                               
                                                   
                                                    echo "<tr>";
                                                    echo '<td>'.$value['item'].'</td>';
                                                    echo '<td>'.number_format($value['cost']).'</td>';
                                                    echo '<td><a class="btn btn-success btn-xs" href="'.URL.'processdata/updateExpansion/LSM/lsm_budget_details/'.$value['id'].'">Edit</a></td>';
                                                    echo '<td><a onclick="show_confirm(\'lsm_budget_details\',\''.$value['id'].'\')" class="btn btn-danger btn-xs">Delete</a></td>';
                                                    
                                                    echo "</tr>";
                                                   $totalCost+=$value['cost'];

                                                }
                                            

                                                ?>
                                                </tbody>
                                                 <tfoot>
                                                 <td>Total Expenditure</td>
                                                <?php
                                                echo "<td>".number_format($totalCost)."</td>";
                                                    ?>
                                                </tfoot>
                                                <?php
                                                }else{
                                                echo '<p>Records Not Found</p>';
                                                }
                                                ?>
                                            </table>
                                </div>
                                    
                            
                            <?php 

                        }else{
                            echo '<h3 class="text-center;">No Meeting Has Been Selected.Select A Meeting to view its Budget</h3>';
                        } 
                        ?>
                        </div>
                        <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">
                            <?php
                           if(isset($_GET['activeLsm'])){
                            ?>
                            <div class="form-group col-md-10">
                              <h4 class='text-center'>Duties Set For Meeting</h4> <br/><br/>
                                 <form method="post" action="<?php echo URL.'processdata/LSMAdd/lsm_duties_details/?tabActive=tab4&activeLsm='.$_GET['activeLsm'] ?>">
                                     <div class="form-group col-md-4">
                                        <label for="full_name">Staff Name</label><br/>
                                        <select name="full_name" required>
                                          <?php
                                            foreach ($staffData as $key => $value) {
                                              echo '<option value="'.$value['id'].'">'.$value['full_name'].'</option>';
                                            }
                                          ?>
                                        </select>
                                    </div>
                                     <div class="form-group col-md-4">
                                        <label for="cost">Duties</label><br/>
                                        <textarea name='duties'></textarea>
                                    </div>
                                    <div>
                                       <input type='hidden' name='lsm_id' value='<?php echo $_GET["activeLsm"]?>' readonly/>
                                       <br/>
                                      <button  type="submit" class="btn btn-primary" name="save-staff-duties" id="save-staff-duties">Save</button>
                                     </div>

                                     </form>
                                     <br/><br/>
                                      <table class='budget-table' class="display compact" cellspacing="0" width="100%">
                                                <thead>
                                                <tr>
                                                    <td>Staff</td>
                                                    <td>Duties</td>
                                                    <td>Edit</td>
                                                    <td>Delete</td>
                                                 </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                               if(isset($lsmDutyData)){
                                                foreach ($lsmDutyData as $key => $value) {
                                               
                                                   
                                                    echo "<tr>";
                                                   
                                                    foreach ($staffData as $key2 => $value2) {
                                                      if($value['full_name']==$key2){
                                                         echo '<td>'.$value2['full_name'].'</td>';
                                                      }
                                                    }

                                                    echo '<td>'.$value['duties'].'</td>';
                                                    echo '<td><a class="btn btn-success btn-xs" href="'.URL.'processdata/updateExpansion/LSM/lsm_duties_details/'.$value['id'].'">Edit</a></td>';
                                                    echo '<td><a onclick="show_confirm(\'lsm_duties_details\',\''.$value['id'].'\')" class="btn btn-danger btn-xs">Delete</a></td>';
                                                    
                                                    echo "</tr>";
                                                  
                                                }
                                           

                                                ?>
                                                </tbody>
                                                <?php
                                                        }else{
                                                    echo '<td colspan=2>Records Not Found</td>';
                                                    echo '<td></td>';
                                                       
                                                }
                                                ?>
                                      </table>
 

                                 </div>
                                    
                            
                            <?php 

                        }else{
                            echo '<h3 class="text-center;">No Meeting Has Been Selected.Select A Meeting to view the Duties</h3>';
                        } 
                        ?>
                            </div>
                        </div>

<!-- Modal -->
<div class="modal fade" id="myofficialsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h3>List Of Officials Attending The Meeting</h3>
            </div>
            <div>
            <br/><br/>
            <ul style='padding:10px;'>
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSms" class="btn btn-info">Send Sms</a>
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseEmail" class="btn btn-info">Send Email</a>
                <ul id="collapseSms" class="panel-collapse collapse" >
                       <form  action="<?php echo URL.'processdata/messageDelivery/Sms/'.$_GET['meetingId']; ?>" data-async data-target="myofficialsModal" method="post" role="form" id="modal-form">
        
                    <div class="form-group col-md-4">

                        <label for="staff">From</label><br/>
                        <input type='email' name='staff' value='' class='form-control input-sm' required/>
                    </div>
                     <div class="form-group col-md-4">
                   
                        <label for="template_name">Message Template</label><br/>
                        <select name='template_name' class='form-control input-sm template_name'>
                            <?php
                            foreach ($lsmMessageData as $key => $value) {
                                echo '<option value='.$value["id"].'>'.$value["template_name"].'</option>';
                            }
                            ?>
                        </select>

                    </div>
                    <div class="form-group col-md-4">

                        <label for="staff">Message</label><br/>
                        <textarea class='message' name='message' class='form-control input-sm'></textarea>
                                            
                    </div>
                    <button  type="submit" class="btn btn-primary" name="send-sms-message" id="save-sms-message">Send SMS</button>
                        
                   </form> 
                </ul>
                    <ul id="collapseEmail" class="panel-collapse collapse">
                       <form  action="<?php echo URL.'processdata/messageDelivery/email/'.$_GET['meetingId']; ?>" data-async data-target="myofficialsModal" method="post" role="form" id="modal-form">
        
                    <div class="form-group col-md-4">

                        <label for="staff">From</label><br/>
                        <input type='email' name='staff' value='' class='form-control input-sm' required/>
                    </div>
                     <div class="form-group col-md-4">
                   
                        <label for="template_name">Message Template</label><br/>
                        <select name='template_name' class='form-control input-sm' id="template_name">
                            <?php
                            foreach ($lsmMessageData as $key => $value) {
                                echo '<option value='.$value["id"].'>'.$value["template_name"].'</option>';
                            }
                            ?>
                        </select>

                    </div>
                    <div class="form-group col-md-4">

                        <label for="staff">Message</label><br/>
                        <textarea class='message' name='message' class='form-control input-sm'></textarea>
                                            
                    </div>
                    <button  type="submit" class="btn btn-primary" name="send-email-message" id="save-sms-message">Send Email</button>
                        
                   </form> 
                </ul>
            </ul>
            </div>
                <div class="modal-body">
                    <table  class="table table-stripped table-hover data-table">
                        <thead>
                        <tr>
                            <td>County</td>
                            <td>District</td>
                            <td>official</td>
                            <td>Phone</td>
                            <td>Email</td>
                            
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                       
                        foreach ($lsmDistrictData as $key => $value) {
                       
                            $officialsArray=unserialize($value['officials']);

                           foreach ($officialsArray as $key => $value) {
                            echo "<tr>";
                            echo '<td>'.$value['county'].'</td>';
                            echo '<td>'.$value['district'].'</td>';
                            echo '<td>'.$value['official'].'</td>';
                            echo '<td>'.$value['phone'].'</td>';
                            echo '<td>'.$value['email'].'</td>';
                           echo "</tr>";
                           }

                        }


                        ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>  










<script>
  $(function () {
    $('#myTab a:last').tab('show')
  })

   window.onload = function() {
           // $("#mymodal").show();
            autoColumn(2, '#myModal .modal-body .row', 'div', 'col-md-4');

        };
    $(document).ready(function() {
        $('#data-table').dataTable({
            
            "scrollCollapse": true,
            
        });
    });

        $('.budget-table').dataTable();

        <?php
        if(isset($_GET['meetingId'])){
            echo "window.onload=function(){ var btn=document.getElementById('official');"
        . "btn.click();"
        . "console.log('Button Called');};";
        }
        ?>

    

    function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>processdata/LsmDelete/' + tables + '/' + deleteId+'/?tabActive=tab2');
            console.log('<?php echo URL ?>processdata/LsmDelete/' + tables + '/' + deleteId);
         } else {
            //console.log('<?php echo URL ?>processdata/LsmDelete/' + tables + '/' + deleteId);
            return false;
        }
    }

    //As you may have noticed there are two functions below doing the same thing 
    //WHY? if you put the same function for both select tags, the first tag's value takes precedence
    //over the other.i.e. The Send Email will never display what you want in the message textarea

    $(".template_name").change(function() {
          $.ajax({
            url: "<?php echo URL ?>processdata/expansion/AJAX_LOAD/message_templates/"+$(".template_name").find(":selected").val()+'/message/id',
            beforeSend: function( xhr ) {
            xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            }
            })
            .done(function( data ) {
               data=jQuery.parseJSON(data);
           
            var counter=1;
            
            $(".message").val("");
            
            $(".message").val(data[0]['message']);    
            
         });
  });  
    $("#template_name").change(function() {
          $.ajax({
            url: "<?php echo URL ?>processdata/expansion/AJAX_LOAD/message_templates/"+$("#template_name").find(":selected").val()+'/message/id',
            beforeSend: function( xhr ) {
            xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            }
            })
            .done(function( data ) {
               data=jQuery.parseJSON(data);
           
            var counter=1;
            
            $(".message").val("");
            
            $(".message").val(data[0]['message']);    
            
         });
  });  
</script>
