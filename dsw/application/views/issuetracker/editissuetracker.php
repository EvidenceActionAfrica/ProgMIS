<!-- Modal -->
<div id="myModal" class="col-md-6 col-md-offset-3" >
    <div >
        <div >
            <div>
                <h4 class="text-center" ><?php echo "Edit " . $tableName . ""; ?></h4>
            </div>
            <form  action="<?php echo URL; ?>issuetracker/update/<?php echo $table ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">

                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $x = 0;
                            //  echo "<pre>";var_dump($single_record);echo "</pre>";
                            foreach ($fields as $key => $value) {
                                // echo "<pre>";var_dump($fields);echo "</pre>";
                                if ($value['Key'] == 'PRI') {
                                    if (!isset($single_record)) {
                                        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                    } else {
                                        echo '<input type="hidden" value="' . $single_record[$x] . '" value="" name="' . $value['Field'] . '"readonly/>';
                                    }
                                
                                    }  else if ($value['Key'] == 'MUL' && $value['Field'] == 'country') {
                                    // $disabled = 'style="display:none"';
                                    $disabled = 'enabled';
                                    if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                    echo '
                                                <div class="form-group">
                                                  
                                                    <input type="hidden" name="' . $value['Field'] . '" class="form-control input-sm" value="'.$_SESSION["country"].'" readonly>';
                                    echo'
                                                </div>';
                                }  else if ($value['Key'] == 'MUL') {
                                    // $disabled = 'style="display:none"';
                                    $disabled = 'enabled';
                                    if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                    echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <select ' . $disabled . ' id="' . $value['Field'] . '"  name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                   $similarField="";//This is to remove Redundancy in the select field
                                    foreach ($value['parents'] as $key => $value_) {
                                        if($similarField==$value_[$value['Field']]){
                                            continue;
                                        }else{
                                        if ($value_['id'] == $selectedValue) {
                                            echo'<option  value="' . $value_['id'] . '" selected >' . $value_[$value['Field']] . '</option>';
                                        } else {
                                            echo'<option  value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                        }
                                        
                                        
                                        
                                        }
                                       $similarField=$value_[$value['Field']];
                                    }
                                    echo '</select>
                                                </div>';
                                }else if ($value['Field'] == 'office_location') {
                                       $disabled = 'enabled';
                                    if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                  
                                    echo '
                                                <div class="form-group">
                                                    <label>Office Location</label><br>
                                                   <select name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                    $similarField="";//This is to remove Redundancy in the select field
                                    foreach ($officeLocationDropDown as $key => $value_) {
                                        if($similarField==$value_["id"]){
                                            continue;
                                        }else{
                                         if ($value_['id'] == $selectedValue) {
                                            echo'<option  value="' . $value_['id'] . '" selected >' . $value_["office_location"] . '</option>';
                                        } else {
                                            echo'<option  value="' . $value_['id'] . '" >' . $value_["office_location"] . '</option>';
                                        }
                                        
                                      }  
                                      }  
                                          echo '</select>'; 
                                }else if ($value['Field'] == 'full_name') {
                                       $disabled = 'enabled';
                                    if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                  
                                    echo '
                                                <div class="form-group">
                                                    <label>Handled By</label><br>
                                                   <select name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                    $similarField="";//This is to remove Redundancy in the select field
                                    foreach ($staffDropDown as $key => $value_) {
                                        if($similarField==$value_["id"]){
                                            continue;
                                        }else{
                                         if ($value_['id'] == $selectedValue) {
                                            echo'<option  value="' . $value_['id'] . '" selected >' . $value_["full_name"] . '</option>';
                                        } else {
                                            echo'<option  value="' . $value_['id'] . '" >' . $value_["full_name"] . '</option>';
                                        }
                                        
                                      }  
                                      } 
                                         echo '</select>'; 
                                        
                                }else if ($value['Field'] == 'raised_by') {
                                       $disabled = 'enabled';
                                    if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                  
                                    echo '
                                                <div class="form-group">
                                                    <label>Raised By</label><br>
                                                   <select name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                    $similarField="";//This is to remove Redundancy in the select field
                                    foreach ($staffDropDown as $key => $value_) {
                                        if($similarField==$value_["full_name"]){
                                            continue;
                                        }else{
                                         if ($value_['full_name'] == $selectedValue) {
                                            echo'<option  value="' . $value_['full_name'] . '" selected >' . $value_["full_name"] . '</option>';
                                        } else {
                                            echo'<option  value="' . $value_['full_name'] . '" >' . $value_["full_name"] . '</option>';
                                        }
                                        
                                      }  
                                      } 
                                      echo '</select>'; 
                                        
                                }else if ($value['Field'] == 'category') {
                                       $disabled = 'enabled';
                                    if (isset($single_record)) {
                                        $selectedValue = $single_record[$x];
                                    }
                                  
                                    echo '
                                                <div class="form-group">
                                                    <label>Category</label><br>
                                                   <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                    $similarField="";//This is to remove Redundancy in the select field
                                    foreach ($categoryDropDown as $key => $value_) {
                                        if($similarField==$value_["category"]){
                                            continue;
                                        }else{
                                         if ($value_['id'] == $selectedValue) {
                                            echo'<option  value="' . $value_['id'] . '" selected >' . $value_["category"] . '</option>';
                                        } else {
                                            echo'<option  value="' . $value_['id'] . '" >' . $value_["category"] . '</option>';
                                        }
                                        
                                      }  
                                      } 
                                      echo '</select>'; 
                                        
                                }else if (strpos($value['Field'],'remarks') !=false) {
                                    if (!isset($single_record)) {
                                        echo '
                                                <div class="form-group">
						                        	<label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
							                       <textarea  name="' . $value['Field'] . '" class="form-control input-sm></textarea>
							                     </div>
								        		';
                                    } else {
                                        echo '
                                                <div class="form-group">
                                                    <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <textarea  name="' . $value['Field'] . '" class="form-control input-sm">'.$single_record[$x] .'</textarea>
						                        </div>	';
                                    }
                                } else if ($value['Field'] == 'issueid') {
                                    echo '
                                                <div class="form-group">
                                                     <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                               
                                                    <input type="hidden" name="' . $value['Field'] . '"  value="' . $dataId . '" readonly/>
                                                </div>
                                            ';
                                } else {
                                    if (!isset($single_record)) {

                                        if (strpos($value['Field'], 'date') !== false) {
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
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                </div>
                                            ';
                                        }
                                        
                                    } else {
                                        if (strpos($value['Field'], 'date') !== false) {
                                            echo '
								            <div class="form-group">
								            	<label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker" value="' . $single_record[$x] . '" />
											</div>
										';
                                        } else {

                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" value="' . $single_record[$x] . '"   name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                </div>
                                            ';
                                        }
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
                    <a href='<?php echo URL . "issuetracker/viewApproved/No/1" ?>'>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </a>
                    <button  type="submit" class="btn btn-primary" name="update-issue-data" id="update-issue-data">Update</button>
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
    //This function is used to update 
      $(document).ready(function() {
       var raisedby=$(".raiser_by").val();
    $("#raised_by option[value='"+raisedby+"']").attr("selected","selected");
    console.log(raisedby);
    });
    
        
$("#category").change(function() {
               // console.log($("#category").find(":selected").text());
                
          $.ajax({
        url: "<?php echo URL ?>issuetracker/ajax_call/issues_category/sub_category/category/?cat="+encodeURIComponent($("#category").find(":selected").text()).replace(/[!'()]/g, escape).replace(/\*/g, "%_A"),
        beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
        }
        })
        .done(function( data ) {
           data=jQuery.parseJSON(data);
        if ( console && console.log ) {
            
       // console.log( "Sample of data:", data.slice( 0, 100 ) );
        
        }
        var counter=1;
        
        $("#sub_category").empty();
        
            
            $(data).each(function(){
                
              //We Need To Loop Through the select tag searching for any value matching the json values
           $("#sub_category").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["sub_category"]+"</option>");    
            
            console.log("passed thru");
            console.log(data[counter-1]["sub_category"]);
            if(counter<data.length){
            counter+=1;
            }
            })
        });  
 
        });

       
 function fixedEncodeURIComponent (str) {
  return encodeURIComponent(str).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");
}
</script>