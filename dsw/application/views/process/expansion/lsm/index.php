 <style>
.custom-combobox {
position: relative;
display: inline-block;
}
.custom-combobox-toggle {
position: absolute;
top: 0;
bottom: 0;
margin-left: -1px;
padding: 0;
}
.custom-combobox-input {
margin: 0;
padding: 5px 10px;
}
</style>
    <div class="col-md-10">
        <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="40px" style="position:absolute;top:50%;left:50%;margin:0 auto; visibility: visible"/>

                    <?php if (isset($message)) { ?>
                <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
                    <?php 
                        echo $message;
                    ?>
                    <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </div>
                <?php } ?>
                
                    
                        <ul class="nav nav-pills">
                            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Create LSM</a></li>
                            <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Setup Meeting Details</a></li>
                        </ul>
                        <div class="tab-content">
                           
                            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                                <?php

                                if(isset($_GET['territory'])){
                                  ?>

                                 <form action="<?php echo URL."expansion/lsmAdd/?territory=".$_GET['territory']; ?> "  method="post">
                                  <?php
                                   // $officials=isset($_POST['officials'])?filter_input(INPUT_POST, 'officials'):null;

                                    if(!isset($officials)){
                                       if(sizeof($territoryData)>0){
                                   ?>  
                                     <div class="table-responsive" style='margin-top:10px;'>

                                         
                                        <table  class="table table-striped table-bordered table-hover" >
                                            <thead>
                                                <tr>
                                                    
                                                    <td><b>Territory Name</b></td>
                                                    <td><b>Name</b></td>
                                                    <td><b>Contact</b></td>
                                                    <td><b>Email</b></td>
                                                </tr>
                                            </thead>
                                           <tbody style='background:#FFF;'>
                                                <?php 
                                                $counter=1;
                                               
                                                foreach ($territoryData as $key => $value) {
                                                    echo '<tr>';
                                                    echo '<td class="text-center"><input type="checkbox"  style="border:0;margin:0;padding:0;"  name="territory'.$counter.'" value="'.$value["admin_territory_name"].'" readonly/> &nbsp;  &nbsp;'.$value["admin_territory_name"].'</td>';
                                                    echo '<td  class="text-center"><input readonly style="border:0;width:100%;margin:0;padding:0;" type="text" name="official'.$counter.'" value="'.$value["name"].' "/></td>';
                                                    echo '<td  class="text-center"><input readonly style="border:0;width:100%;margin:0;padding:0;" type="text" name="phone'.$counter.'" value="'.$value["phone"].' "/></td>';
                                                    echo '<td  class="text-center"><input readonly style="border:0;width:100%;margin:0;padding:0;" type="text" name="email'.$counter.'" value="'.$value["email"].' "/></td>';
                                                    echo '</tr>';

                                                    ++$counter;
                                                }
                                              

                                                ?>
                                          </tbody>

                                            </table>
                                            <div class="form-group">
                                               <a href="<?php echo URL.'expansion/viewLSM/';?>" class="btn btn-default" data-dismiss="modal">Cancel</a>
                                              <button  type="submit" class="btn btn-primary" name="create-selected-officials" id="create-lsm-meeting">Save Officials</button>
                                             
                                            </div>
                                      </div>
                                        <?php
                                        }else{
                                                echo '<div class="text-center"><h3 >No Contacts Found.</h3>';
                                                echo '<br/><a href="'.URL.'expansion/viewLSM">Go Back</a>';
                                                echo '</div>';
                                              }


                                      }else{
                                        ?>
                                 
                                   <div class="form-group col-md-4 col-md-offset-3">
                                      <div class="form-group">
                                             <input type="hidden" id="country" readonly name="country" class="form-control input-sm" value="<?php echo $_SESSION['country']; ?>"/>
                                      </div>
                                      <div class="form-group">
                                             <label for="lsm_title">Title</label><br/>
                                             <select id="lsm_title" name="lsm_title" class="form-control input-sm" >
                                                  <?php

                                                  foreach ($meetingTitles as $key => $value) {
                                                    echo '<option value="'.ucwords(str_replace('_',' ',$value)).'">'.ucwords(str_replace('_',' ',$value)).'</option>';
                                                  }


                                                  ?>
                                             </select>
                                      </div>

                                      <div class="form-group">
                                             <label for="meeting_date">Date Of Meeting</label><br/>
                                             <input type="text" id="meeting_date" name="meeting_date" class="form-control input-sm datepicker"/>
                                             <label for="meeting_time">Time Of Meeting</label><br/>
                                             <input type="time" id="meeting_time"  name="meeting_time" class="form-control input-sm timepicker"/>
                                              <input type='hidden' name='territory_id' value="<?php echo $_GET['territory']; ?>"/>
                                     
                                      </div>
                                      
                                      <div class="form-group">
                                             <label for="location">Location</label><br/>
                                             <input type="text" id="location" name="location" class="form-control input-sm"/>
                                      </div>
                                       <div class="form-group">
                                             <textarea name='officials' readonly style='display:none;'><?php echo $officials; ?></textarea>
                                      </div>
                                      
                                       <div class="form-group">
                                             <a href="<?php echo URL.'expansion/viewLSM/';?>" class="btn btn-default" data-dismiss="modal">Cancel</a>
                                             <button  type="submit" class="btn btn-primary" name="create-lsm-meeting" id="create-lsm-meeting">Save</button>
                                      </div>
                                    </div>
                                 <?php }  ?>
                              </form>




                                  <?php
                                  }else{

                                ?>

                                      <form class="form-group col-md-offset-2" method="GET">
                                  
                                         <div class="form-group col-md-8">
                                               <div class="ui-widget"> 
                                                  <label for="territoryId">Select/Type C.A.U</label>
                                                  <select name="territory" id="combobox" class='form-control input-sm ' required>
                                                    <option value=''></option>
                                                        <?php
                                                         foreach ($cauSelect as $key => $value) {
                                                          echo '<option value="'.$value['id'].'">'.$value['admin_territory_name']
                                                          .' -- '.$value['territory'].'</option>';
                                                        }
                                                       ?>
                                                   </select>

                                                   <br/>
                                                   <input type="submit" class='btn btn-info' name='territoryPost' value='Create'/>
                                               </div>
                                         </div> 
                                       </form>
                                <?php } ?>
                            </div>
                           
                             <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
                                 <br/><br/><br/>
                               <button type="button" id='official' data-toggle="modal" data-target="#myofficialsModal" style='display:none;'>View Officials</button>
                                                     
                                <div class="table-responsive">
                                     <?php if (!empty($lsmData)) { ?>

                                            <table  class="table table-striped table-bordered table-hover data-table">
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
                                                        echo '<td><b>' . ucwords(str_replace('_', ' ', $key)) . '</b></td>';
                                                        
                                                                                }
                                                    }
                                                }
                                                ?>
                                                          <td class="buttons"></td>
                                                          
                                                          <td class="buttons"></td>
                                                          <td class="buttons"></td>
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
                                                                                 echo '<td  class="text-center" >'.$value.'</td>';
                                                                                }
                                                                            }
                                                                           
                                                                        }
                                                        ?>
                                                          <td class="buttons"><a href='?tabActive=tab2&meetingId=<?php echo urlencode($lsm_id); ?>' class="btn btn-default btn-xs" data-toggle="modal" value="<?php echo $lsm_id; ?>">View Officials</a></td> 
                                                          <td class="buttons" ><a href="<?php echo URL.'expansion/viewLSM/lsm_details/?tabActive=tab3& activeLsm='.$lsm_id; ?>" class="btn btn-default btn-xs" >Budget</a>
                                                          <a style="margin-top:3%;" href="<?php echo URL.'expansion/viewLSM/lsm_details/?tabActive=tab4& activeLsm='.$lsm_id; ?>" class="btn btn-default btn-xs">Duties</a></td> 
                                                          <td class="buttons"><a href="<?php echo URL ?>expansion/updateLsm/<?php echo 'lsm_details' . "/" . $lsm_id; ?>" class="btn btn-default btn-xs">Edit</a>
                                                          <a onclick='show_confirm("lsm_details","<?php echo $lsm_id; ?>")' class='btn btn-default btn-xs'>Delete</a></td>
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
                                    <form method="post" action="<?php echo URL.'expansion/LSMAdd/lsm_budget_details/?tabActive=tab3&activeLsm='.$_GET['activeLsm'] ?>">
                                             <div class="form-group col-md-4">

                                                <label for="item">Item</label><br/>
                                                <input type='text' name='item' value=''/>
                                            </div>
                                             <div class="form-group col-md-4">
                                                <label for="cost">Estimated Cost</label><br/>
                                                <input type='text' name='cost' value=''/>
                                            </div>
                                            <div>
                                               <input type='hidden' name='lsm_id' value='<?php echo $_GET["activeLsm"]?>' readonly/>
                                               <br/>
                                              <button  type="submit" class="btn btn-primary" name="save-item-expense" id="save-item-expense">Save</button>
                                             </div>

                                    </form>
                                     <br/><br/>
                                           <table class='table-bordered budget-table' class="display compact" cellspacing="0" width="100%">
                                              <thead>
                                              <tr>
                                                  <td>Item</td>
                                                  <td>Estimated Cost</td>
                                                  <td class="buttons" >Edit/Delete</td>
                                               </tr>
                                              </thead>
                                                <tbody>
                                                <?php
                                               if(isset($lsmBudgetData)){
                                                $totalCost=0;
                                                foreach ($lsmBudgetData as $key => $value) {
                                               
                                                   
                                                    echo "<tr>";
                                                    echo '<td>'.$value['item'].'</td>';
                                                    echo '<td>'.$value['cost'].'</td>';
                                                    echo '<td class="buttons"><a class="btn btn-default btn-xs" href="'.URL.'expansion/updateBudgetDuties/lsm_budget_details/'.$_GET['activeLsm'].'/'.$value['id'].'">Edit</a>';
                                                    echo '<a onclick="show_confirm(\'lsm_budget_details\',\''.$value['id'].'\')" class="btn btn-default btn-xs">Delete</a></td>';
                                                    
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
                                   <form method="post" action="<?php echo URL.'expansion/LSMAdd/lsm_duties_details/?tabActive=tab4&activeLsm='.$_GET['activeLsm'] ?>">
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
                                        <table class='table-bordered budget-table' class="display compact" cellspacing="0" width="100%">
                                                  <thead>
                                                  <tr>
                                                      <td>Staff</td>
                                                      <td>Duties</td>
                                                      <td class="buttons">Edit/Delete</td>
                                                   </tr>
                                                  </thead>
                                                  <tbody>
                                                  <?php
                                                 if(isset($lsmDutyData)){
                                                  foreach ($lsmDutyData as $key => $value) {
                                                 
                                                     
                                                     echo "<tr>";
                                                     echo '<td>'.$value['full_name'].'</td>';
                                                     echo '<td>'.$value['duties'].'</td>';
                                                     echo '<td class="buttons"><a class="btn btn-default btn-xs" href="'.URL.'expansion/updateBudgetDuties/lsm_duties_details/'.$_GET['activeLsm'].'/'.$value['id'].'">Edit</a>';
                                                     echo '<a onclick="show_confirm(\'lsm_duties_details\',\''.$value['id'].'\')" class="btn btn-default btn-xs">Delete</a></td>';
                                                      
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
                                 <form  action="<?php echo URL.'expansion/messageDelivery/Sms/'.$_GET['meetingId']; ?>" data-async data-target="myofficialsModal" method="post" role="form" id="modal-form">
                  
                              <div class="form-group col-md-4">

                                  <label for="staff">From</label><br/>
                                  <input type='email' name='staff' value='' class='form-control input-sm' required/>
                              </div>
                               <div class="form-group col-md-4">
                             
                                  <label for="template_name">Message Template</label><br/>
                                  <select name='template_name' id='template_name2' class='form-control input-sm '>
                                  <option selected></option>
                                      <?php
                                      foreach ($lsmMessageData as $key => $value) {
                                          echo '<option value='.$value["id"].'>'.$value["template_name"].'</option>';
                                      }
                                      ?>
                                  </select>

                              </div>
                              <div class="form-group col-md-4">

                                  <label for="staff">Message</label><br/>
                                  <textarea class='message2' name='message' class='form-control input-sm'></textarea>
                                                      
                              </div>
                              <button  type="submit" class="btn btn-primary" name="send-sms-message" id="save-sms-message">Send SMS</button>
                                  
                             </form> 
                          </ul>
                              <ul id="collapseEmail" class="panel-collapse collapse">
                                 <form  action="<?php echo URL.'expansion/messageDelivery/email/'.$_GET['meetingId']; ?>" data-async data-target="myofficialsModal" method="post" role="form" id="modal-form">
                  
                              <div class="form-group col-md-4">

                                  <label for="staff">From</label><br/>
                                  <input type='email' name='staff' value='' class='form-control input-sm' required/>
                              </div>
                               <div class="form-group col-md-4">
                             
                                  <label for="template_name">Message Template</label><br/>
                                  <select name='template_name' class='form-control input-sm' id="template_name">
                                  <option selected></option>
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
                              <table  class="table table-stripped table-bordered table-hover data-table">
                                  <thead>
                                  <tr>
                                      <td><b>Territory</b></td>
                                      <td><b>Official</b></td>
                                      <td><b>Phone</b></td>
                                      <td><b>Email</b></td>
                                      
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                 
                                  foreach ($lsmofficialsData as $key => $value) {
                                 
                                      $officialsArray=unserialize($value['officials']);

                                     foreach ($officialsArray as $key => $value) {
                                      $territory=isset($value['territory'])?$value['territory']:"";
                                      echo "<tr>";
                                      echo '<td>'.$territory.'</td>';
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


    $(document).ready(function() {
   
        (function( $ ) {
        $.widget( "custom.combobox", {
        _create: function() {
        this.wrapper = $( "<span>" )
        .addClass( "custom-combobox" )
        .insertAfter( this.element );
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
        },
        _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
        value = selected.val() ? selected.text() : "";
        this.input = $( "<input>" )
        .appendTo( this.wrapper )
        .val( value )
        .attr( "title", "" )
        .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
        .autocomplete({
        delay: 0,
        minLength: 0,
        source: $.proxy( this, "_source" )
        })
        .tooltip({
        tooltipClass: "ui-state-highlight"
        });
        this._on( this.input, {
        autocompleteselect: function( event, ui ) {
        ui.item.option.selected = true;
        this._trigger( "select", event, {
        item: ui.item.option
        });
        },
        autocompletechange: "_removeIfInvalid"
        });
        },
        _createShowAllButton: function() {
        var input = this.input,
        wasOpen = false;
        $( "<a>" )
        .attr( "tabIndex", -1 )
        .attr( "title", "Show All Items" )
        .tooltip()
        .appendTo( this.wrapper )
        .button({
        icons: {
        primary: "ui-icon-triangle-1-s"
        },
        text: false
        })
        .removeClass( "ui-corner-all" )
        .addClass( "custom-combobox-toggle ui-corner-right" )
        .mousedown(function() {
        wasOpen = input.autocomplete( "widget" ).is( ":visible" );
        })
        .click(function() {
        input.focus();
        // Close if already visible
        if ( wasOpen ) {
        return;
        }
        // Pass empty string as value to search for, displaying all results
        input.autocomplete( "search", "" );
        });
        },
        _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
        var text = $( this ).text();
        if ( this.value && ( !request.term || matcher.test(text) ) )
        return {
        label: text,
        value: text,
        option: this
        };
        }) );
        },
        _removeIfInvalid: function( event, ui ) {
        // Selected an item, nothing to do
        if ( ui.item ) {
        return;
        }
        // Search for a match (case-insensitive)
        var value = this.input.val(),
        valueLowerCase = value.toLowerCase(),
        valid = false;
        this.element.children( "option" ).each(function() {
        if ( $( this ).text().toLowerCase() === valueLowerCase ) {
        this.selected = valid = true;
        return false;
        }
        });
        // Found a match, nothing to do
        if ( valid ) {
        return;
        }
        // Remove invalid value
        this.input
        .val( "" )
        .attr( "title", value + " didn't match any item" )
        .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
        this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
        },
        _destroy: function() {
        this.wrapper.remove();
        this.element.show();
        }
        });
        })( jQuery );
        $(function() {
        $( "#combobox" ).combobox();
        // $( "#toggle" ).click(function() {
        // $( "#combobox" ).toggle();
        // });
        });

        $(function () {
          $('#myTab a:last').tab('show')
        });


        autoColumn(2, '#myModal .modal-body .row', 'div', 'col-md-4');
        $('.data-table').dataTable();
         $('.budget-table').dataTable();

        <?php
        if(isset($_GET['meetingId'])){
            echo "window.onload=function(){ var btn=document.getElementById('official');"
        . "btn.click();"
        . "console.log('Button Called');};";
        echo "document.getElementById('imgLoading').style.visibility = 'hidden';";
        }
        ?>


    });

    
        function show_confirm(tables, deleteId) {
            if (confirm("Are you sure you want to delete?")) {
                location.replace('<?php echo URL ?>expansion/LsmDelete/' + tables + '/' + deleteId+'/?tabActive=tab2');
                console.log('<?php echo URL ?>expansion/LsmDelete/' + tables + '/' + deleteId);
             } else {
                //console.log('<?php echo URL ?>processdata/LsmDelete/' + tables + '/' + deleteId);
                return false;
            }
        }   

    

   

    //As you may have noticed there are two functions below doing the same thing 
    //WHY? if you put the same function for both select tags, the first tag's value takes precedence
    //over the other.i.e. The Send Email will never display what you want in the message textarea

    $("#template_name").change(function() {
          $.ajax({
            url: "<?php echo URL ?>expansion/lsmAjaxCall/message_templates/"+$(".template_name").find(":selected").val()+'/message/id',
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
            url: "<?php echo URL ?>expansion/lsmAjaxCall/message_templates/"+$("#template_name").find(":selected").val()+'/message/id',
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
      $("#template_name2").change(function() {
          $.ajax({
            url: "<?php echo URL ?>expansion/lsmAjaxCall/message_templates/"+$("#template_name2").find(":selected").val()+'/message/id',
            beforeSend: function( xhr ) {
            xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            }
            })
            .done(function( data ) {
               data=jQuery.parseJSON(data);
           
            var counter=1;
            
            $(".message2").val("");
            
            $(".message2").val(data[0]['message']);    
            
         });
  });   
</script>
