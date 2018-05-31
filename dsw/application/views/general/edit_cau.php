<!-- Modal -->
<div id="myModal" class="col-md-6 col-md-offset-3" >
    <div >
        <div >
            <div>
                <h4 class="text-center" ><?php echo "Edit " . $tableName . ""; ?></h4>
            </div>
            <form  action="<?php echo URL; ?>generalclass/updateOfficials/<?php echo $table.'/'.$edit ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">

                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $x = 0;
                            //  echo "<pre>";var_dump($single_record);echo "</pre>";
                            foreach ($fields as $key => $value) {
                                // echo "<pre>";var_dump($fields);echo "</pre>";
                                 if ($value['Key'] == 'PRI' ) {
                                    if (!isset($single_record)) {
                                        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                    } else {
                                        echo '<input type="hidden" value="' . $single_record[$x] . '" value="" name="' . $value['Field'] . '"readonly/>';
                                    }
                                }else if ($value['Key'] == 'MUL' && $value['Field']=='country') {
                                    // $disabled = 'style="display:none"';
                                    $disabled = 'enabled';
                                    if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                    echo '
                                                <div class="form-group">
                                                     <input type="text" name="'.$value['Field'].'" value="'.$_SESSION['country'].'" hidden/>
                                                </div>';
                                } else if ($value['Key'] == 'MUL') {
                                    // $disabled = 'style="display:none"';
                                    $disabled = 'enabled';
                                    if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                    echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <select ' . $disabled . ' name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                    foreach ($value['parents'] as $key => $value_) {
                                        if ($value_['id'] == $selectedValue) {
                                            echo'<option  value="' . $value_['id'] . '" selected >' . $value_[$value['Field']] . '</option>';
                                        } else {
                                            echo'<option  value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                        }
                                    }
                                    echo '</select>
                                                </div>';
                                } else if ($value['Field'] == 'territory_id') {
                                      if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                          echo '<div class="form-group">
                                                <label>Choose C.A.U</label><br>
                                                <select id="territory_id" name="territory_unknown" class="form-control input-sm">
                                                    <option value="">Select C.A.U</option>';
                                                    foreach ($cauDropDown as $key => $values) {
                                                    
                                                          echo'<option value="' . $values['id'] . '" >' .ucwords(str_replace('_', ' ', $values['territory_name']))  . '</option>';
                                                    

                                                    }
                                                echo '</select>
                                            </div>';
                                          
                                  
                                    echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', "Territory Name")) . '</label><br>
                                                    <select id="territory_name" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', "Territory Name")) . '</option>';
                                    foreach ($defaultterritories as $key => $value_) {
                                        if ($value_['id'] == $selectedValue) {
                                            echo'<option  value="' . $value_['id'] . '" selected >' . $value_['admin_territory_name'] . '</option>';
                                        } else {
                                            echo'<option  value="' . $value_['id']. '" >' . $value_['admin_territory_name']. '</option>';
                                        }
                                    }
                                    echo '</select>
                                                </div>';
                                }else if (strpos($value['Field'], 'date') !== false) {
                                    
                                    if (!isset($single_record)) {

                                            echo '
                                            <div class="form-group">
                                                <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
                                            </div>
                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker" value="' . $single_record[$x] . '"/>
                                                </div>
                                            ';
                                        }
                                        
                                    }else {

                                    if (isset($single_record)) {
                                            echo '
                                            <div class="form-group">
                                                <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <input type="text" name="' . $value['Field'] . '" value="' . $single_record[$x] . '" class="form-control input-sm"  />
                                            </div>
                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" value="' . $single_record[$x] . '" class="form-control input-sm"/>
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
                <div class="col-md-offset-4">
                    <!-- this takes the user back to the previous page -->
                    <a href='<?php echo URL . "generalclass/Officials/".$table."/"; ?>'>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </a>
                    <button  type="submit" class="btn btn-primary" name="update" id="update-general-data">Update Details</button>
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
       $("#territory_id").change(function() {
   

    var getTerritories=encodeURIComponent($("#territory_id").find(":selected").text()).replace(/[!'()]/g, escape).replace(/\*/g, "%_A");
    console.log(getTerritories);
           $.ajax({
        url: "<?php echo URL ?>generalclass/territoryCall/?info="+encodeURIComponent($("#territory_id").find(":selected").text()).replace(/[!'()]/g, escape).replace(/\*/g, "%_A"),
        beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
        }
        })
        .done(function( data ) {
           data=jQuery.parseJSON(data);
        if ( console && console.log ) {
            
        console.log( "Sample of data:", data.slice( 0, 100 ) );
        }
          var counter=1;
        
        $("#territory_name").empty();
        
            
            $(data).each(function(){
                
              //We Need To Loop Through the select tag searching for any value matching the json values
           $("#territory_name").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["admin_territory_name"]+"</option>");    
            
            console.log("passed thru");
            console.log(data[counter-1]["office_location"]);
        if(counter<data.length){
        counter+=1;
    }
    })
        
        });

   }
   );
</script>