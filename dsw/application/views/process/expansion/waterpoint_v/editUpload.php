<!-- Modal -->
<div id="myModal" class="col-md-6 col-md-offset-3" >
    <div >
        <div >
            <div>
                <h4 class="text-center" ><?php echo "Edit " . $tableName . ""; ?></h4>
            </div>
             <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="40px" style="position:absolute;top:50%;left:50%;margin:0 auto; visibility: visible"/>

            <form  action="<?php echo URL; ?>expansion/sVerificationUploadUpdate/<?php echo $table.'/'.$edit ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">

                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $x = 0;
                            //  echo "<pre>";var_dump($single_record);echo "</pre>";
                            foreach ($fields as $key => $value) {
                                // echo "<pre>";var_dump($fields);echo "</pre>";
                               if($value['Field'] == 'lsm_id'){
                                if (!isset($single_record)) {
                                        echo '<input type="hidden" value="" name="' . $value['Field'] . '" readonly/>';
                                    } else {
                                        echo '<input type="hidden" value="' . $single_record[$x] . '" value="" name="' . $value['Field'] . '"readonly/>';
                                    }
                               }else  if ($value['Key'] == 'PRI' ) {
                                    if (!isset($single_record)) {
                                        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                    } else {
                                        echo '<input type="hidden" value="' . $single_record[$x] . '" value="" name="' . $value['Field'] . '"readonly/>';
                                    }
                                } else if ($value['Key'] == 'MUL' && $value['Field'] == 'country') {
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
                                }else if ($value['Field'] == 'all_cau') {
                                       $activeCau=unserialize($single_record[$x]);
                                       if($activeVillage !=null){
                                          array_push($activeCau,$activeVillage);
                                       }
                                     
                                       $i=0;
                                        foreach ($cauList as $key => $value) {   
                                               echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['territory_name'])) . '</label><br>
                                                <select  name="' . $value['territory_name'] . '" id="'.$value['territory_name'].'ajax" class="form-control input-sm ' . $value['territory_name'].'ajax" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['territory_name'])) . '</option>'; 
                                                  foreach ($ListedCaus[$value['territory_name']] as $key => $value_) {
                                                            if($activeCau[$i]==$value_['territory_name']){
                                                                echo'<option  value="' . $value_['territory_name'] . '" selected>' . $value_['territory_name'] . '</option>';
                                                            }else{
                                                              echo'<option  value="' . $value_['territory_name'] . '" >' . $value_['territory_name'] . '</option>';  
                                                            }
                                                            
                                                        
                                                    }
                                                    echo '</select>
                                                                </div>';
                                        ++$i;
                                        }


                                }else if ($value['Field'] == 'village') {
                                   $activeVillage=$single_record[$x];
                                } else if ($value['Type'] == 'timestamp') {
                                    if (!isset($single_record)) {
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="" class="form-control input-sm" value="' . date('d-m-Y') . '" readonly/>
                                                </div>
                                            ';
                                    } else {
                                        echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" value="' . $single_record[$x] . '"  name="' . $value['Field'] . '" class="form-control input-sm" readonly/>
                                                </div>
                                            ';
                                    }
                                }else if ($value['Field'] == 'officials'  ) {
                                    continue;
                                }  else if ($value['Field'] == 'issueid') {
                                    echo '
                                                <div class="form-group">
                                                     <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                               
                                                    <input type="hidden" name="' . $value['Field'] . '" class="form-control input-sm" value="' . $dataId . '" readonly/>
                                                </div>
                                            ';
                                }else if (strpos($value['Field'], 'directions') !== false || strpos($value['Field'], 'notes') !== false) {
                                    
                                    if (!isset($single_record)) {

                                            echo '
                                            <div class="form-group">
                                                <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <textarea name="' . $value['Field'] . '" class="form-control input-sm" ></textarea>
                                            </div>
                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <textarea name="' . $value['Field'] . '" class="form-control input-sm">'.$single_record[$x] . '</textarea>
                                                </div>
                                            ';
                                        }
                                        
                                    } else if (strpos($value['Field'], 'time') !== false) {
                                    
                                    if (!isset($single_record)) {

                                            echo '
                                            <div class="form-group">
                                                <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <input type="time" name="' . $value['Field'] . '" class="form-control input-sm "  />
                                            </div>
                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm" value="' . $single_record[$x] . '"/>
                                                </div>
                                            ';
                                        }
                                        
                                    }else if (strpos($value['Field'], 'message') !== false || strpos($value['Field'], 'duties') !== false) {
                                    
                                    if (!isset($single_record)) {

                                            echo '
                                            <div class="form-group">
                                                <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <textarea name="' . $value['Field'] . '" class="form-control input-sm "></textarea>
                                            </div>
                                        ';
                                        } else {
                                            echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <textarea name="' . $value['Field'] . '" class="form-control input-sm">'. $single_record[$x] . '</textarea>
                                                </div>
                                            ';
                                        }
                                        
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
                    <a href='<?php echo URL . "expansion/sVerificationUpload/"; ?>'>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </a>
                    <button  type="submit" class="btn btn-primary" name="update" id="add-issue-data">Update Details</button>
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
<?php
$territoryArray=array();
//echo '   var territoryArray=[]';
 foreach ($cauList as $key => $value) {   
  //  echo 'territoryArray.push("'.$value['territory_name'].'");';
array_push($territoryArray,$value['territory_name']);

 }
 array_pop($cauList);
 $i=0;
  foreach ($cauList as $key => $value) {   
   // echo 'territoryArray.push("'.$value['territory_name'].'"); ';
 
?>
       $("#<?php echo $value['territory_name']; ?>ajax").change(function() {
        document.getElementById('imgLoading').style.visibility = 'visible';
          $.ajax({
        url: "<?php echo URL ?>expansion/ajaxChildCau/<?php echo $territoryArray[$i+1]; ?>/<?php echo $value['territory_name'];?>/"+$("#<?php echo $value['territory_name'] ?>ajax").find(":selected").val(),
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
        
        $("#<?php echo $territoryArray[$i+1]; ?>ajax").empty();
        
            
            $(data).each(function(){
                
              //We Need To Loop Through the select tag searching for any value matching the json values
           $("#<?php echo $territoryArray[$i+1]; ?>ajax").append("<option value='"+data[counter-1]["admin_territory_name"]+"'>"+data[counter-1]["admin_territory_name"]+"</option>");    
            
            console.log("passed thru");
            console.log(data[counter-1]["admin_territory_name"]);
        if(counter<data.length){
        counter+=1;
    }
    })
             document.getElementById('imgLoading').style.visibility = 'hidden';
    })
    });
<?php
++$i;

}
?>

</script>