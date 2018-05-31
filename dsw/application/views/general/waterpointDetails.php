<?php $editable=isset($_POST['editable'])?$_POST['editable']:null;
    if($editable !=null){
        $cauManage=array();
        foreach ($cauList as $key => $value) {
            array_push($cauManage,$value['territory_name']);
        }
?>
<style>


#data-table1 th {
    min-width: 100px;
}
</style>
<div class="col-md-12"> 
<?php
    }else{
 ?>
<div class="col-md-10">
<?php }?>
  

        <div class="clearfix">
        <?php 
            if($editable !=null){
                echo ' <form method="POST" style="float:right;">
                    <input type="submit" class="btn btn-default" name="goBack" value="<- &nbsp; Go Back"/>

                      <input type="submit" id="done" class="btn btn-info " name="update" value="Finish"/> 
                      <input type="hidden" name="program" value="'.$_POST['program'].'"/>
                </form>';
            }
            ?>
           
            <div class="col-md-6">
        <h3 class="pull-left"><?php echo $tableName; ?></h3>

            </div>
        </div>
        <hr>
    

    <div class="table-responsive">

        <div class="row">
          <form method="POST" action="<?php echo URL.'generalclass/general/waterpoint_details'; ?> ">
          <?php if($editable==null){ ?>
            <div class="form-group col-md-6" >
                
                    <label> Select A Program</label>
                    <select name="program" class=" input-sm" required>
                        <option value='All'>All Programs</option>
                        <?php
                        foreach ($progDropDown as $key => $value) {
                            if(isset($_POST['program']) && $_POST['program'] ==$value['program']){
                                 echo '<option value="'.$value['program'].'" selected>'.$value['program'].'</option>';
                             }else{
                                 echo '<option value="'.$value['program'].'">'.$value['program'].'</option>';
                             }


                            
                         } 
                        ?>
                    </select>

                <input type="submit" class="btn btn-default" name="callProgramDetails" value="Generate"/>

                 <input type="submit" class="btn btn-default" name="editable" value="Edit"/>
                 
                <?php } ?>

                
            </div>
           </form>
      
        </div>

        <?php if (!empty($data)) { ?>
          <div class="tableDiv col-md-12" style="">
            <table id="data-table1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="index">#</th>
                        <?php
                        
                            foreach ($data[0] as $key => $value) {
                                if ($key == 'position' && $table != "staff_category") {
                                    continue;
                                }
                                if (in_array($key, $cauManage) || in_array($key, $fieldsArray) || in_array($key,$allFields))  {                                
                                     if ($key == "country" || $key == "Country" || $key == "id") {
                                        continue;
                                    }else if(in_array($key,$allFields) && !in_array($key,$fieldsArray) && $editable==null){
                                         echo '<th class="export-visible" style="display:none">' . ucwords(str_replace('_', ' ', $key)) . '</th>'; 
                                    } else {
                                        echo '<th style="" class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';        
                                    }
                                }
                            } 
                            if ($table != "staff_list" && $editable==null) { ?>
                            <th class="buttons" >Set Status AS</th>
                            <th class="buttons" >Edit/Delete</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="index"></th>
                        <?php
                            foreach ($data[0] as $key => $value) {
                                if ($key == 'position' && $table != "staff_category") {
                                    continue;
                                }
                                if (in_array($key, $cauManage) || in_array($key, $fieldsArray) || in_array($key,$allFields)) {                                
                                    if ($key == "country" || $key == "Country" || $key == "id") {
                                        continue;
                                    }else if(in_array($key,$allFields) && !in_array($key,$fieldsArray) && $editable==null){
                                        echo '<th class="export-visible" style="display:none">' . ucwords(str_replace('_', ' ', $key)) . '</th>'; 
                                    }else if($key=='active' && $editable !=null){
                                        echo '<td class="index"></td>';
                                    }else if(in_array($key, $cauManage) && $editable !=null){
                                        echo '<td class="index"></td>';
                                    } else {
                                        echo '<th  class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';        
                                    }

                                   
                                }
                            }
                          if($editable==null){   
                          ?>
                            <td class="buttons" ></td>
                     <td class="buttons" ></td>
                     <?php } ?>
                    </tr>
                </tfoot>
                <tbody>
                   <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="40px" style="position:absolute;top:50%;left:50%;margin:0 auto; visibility: visible"/>

                    <?php 
                      
                    $activeStatus=null; $activeCode=''; $i = 0; foreach ($data as $key => $value) { ?>
                        <tr <?php echo 'data-id="form_'.$value['id'].'"' ?> >
                            <td class="index"></td>
                            <?php
                              if($editable!=null){
                                    echo '<form action="'.URL.'generalclass/update/'.$table.'" method="POST" id="form_'.$value['id'].'">';
                                    echo '<input type="hidden" name="update-ajax" read-only/>';
                                    echo '<input type="hidden" name="id" value="'.$value['id'].'" read-only/>';
                                }

                             foreach ($value as $key => $value) {
                                // echo "<pre>";var_dump($key);echo "</pre>";         
                                if ($key == 'position' && $table != "staff_category") {
                                    continue;
                                }
                                if ($i == 1) {
                                    $generalId = $value;
                                }
                                if (in_array($key, $cauManage) || in_array($key, $fieldsArray) || in_array($key,$allFields)) {

                                    if ($key == "country" || $key == "Country" || $key == "id") {
                                        continue;
                                    }else if($key=="active" && $value==1){

                                        $activeStatus='Inactive';
                                        $class='class="glyphicon glyphicon-ok-circle" title="Waterpoint is Active" data-toggle="tooltip" data-placement="top"';
                                        $activeCode=1;
                                         
                                        echo '<td  >';
                                        if($editable==null){
                                        echo '<span '.$class.' style="color:#2EA0E8;"  >Active</span>';
                                        }else{
                                            echo '<select class="form-control input-sm" name="active"><option value="1"';
                                            if($value==1){
                                                echo 'selected';
                                            }
                                            echo '>Active</option>';
                                            echo '<option value="0"';
                                            if($value!=1){
                                                echo 'selected';
                                            }
                                            echo '>Inactive</option></select>';

                                        }
                                     echo '</td>';

                                    }else if($key=="active" && $value==0){
                                         $activeStatus='Active';
                                         $activeCode=0;
                                          $class='class="glyphicon glyphicon-ban-circle" title="Waterpoint is Inactive" data-toggle="tooltip" data-placement="top"';
                                      
                                          echo '<td  >';
                                        if($editable==null){
                                        echo '<span '.$class.'  >Inactive</span>';
                                        }else{
                                            echo '<select class="form-control input-sm" name="active"><option value="1"';
                                            if($value==1){
                                                echo 'selected';
                                            }
                                            echo '>Active</option>';
                                            echo '<option value="0"';
                                            if($value!=1){
                                                echo 'selected';
                                            }
                                            echo '>Inactive</option></select>';

                                        }
                                     echo '</td>';
                                    }else if(in_array($key,$allFields) && !in_array($key,$fieldsArray) && $editable==null){
                                        echo '<td style="display:none">'. $value.'</td>'; 
                                    } else {
                                            if($editable!=null){
                                                $cauExists=false;
                                                foreach ($cauList as $caukey => $cauvalue) {
                                                  
                                                   if($key==$cauvalue['territory_name']){
                                                    $cauExists=true;
                                                  
                                                   }
                                                }
                                                if($cauExists){
                                                      
                                                     if($key=='village'){
                                                        $require='required';
                                                    }else{
                                                        $require='';
                                                    }
                                                       echo '<td class="export-visible">
                                                        
                                                        
                                                        <select  ';
                                                        if($key=='village'){
                                                          echo ' name="' . $key . '"';
                                                        }

                                                        echo ' id="'.$key.'ajax" class="form-control input-sm ' . $key.'ajax" '.$require.'><option value="">Select ' . ucwords(str_replace('_', ' ', $key)) . '</option>'; 
                                                         if($key !='village'){
                                                          echo '<option value="" selected>'.$value.'</option>';
                                                         }
                                                          if(isset($ListedCaus[$key])){
                                                              foreach ($ListedCaus[$key] as $listedkey2 => $listedvalue_) {
                                                                    if($key=='village' && $value==$listedvalue_['id']){
                                                                          echo'<option  value="' . $listedvalue_['id'] . '"selected >' . $listedvalue_['territory_name'] . '</option>';  
                                                                    }else if($key=='village'){
                                                                    }else{
                                                                          echo'<option  value="' . $listedvalue_['id'] . '" >' . $listedvalue_['territory_name'] . '</option>';  
                                                                    }          
                                                                        
                                                                }
                                                            }
                                                            echo '</select></td>
                                                                      ';
                                                        
                                                }else if(strpos($key,"date") !==false){
                                                       echo '<td class="export-visible"><input type="text" class="form-control input-sm datepicker" value="'.$value.'"></td>';
    
                                                }else{
                                                   echo '<td  class="export-visible"><input type="text" name="'.$key.'" class="form-control input-sm" value="'.ucfirst($value).'"></td>';

                                                }
                                           

                                            }else{
                                             echo '<td class="export-visible">'.ucfirst($value).'</td>';   
                                            }
                                         
                                        }

                                     
                                }
                            } if ($table != "staff_list" && $editable==null) { ?>
                            <td class="buttons" >
                                  <a href="<?php echo URL ?>generalclass/changeStatus/<?php echo $table . "/" . $data[$i]['id'].'/'.$activeCode.'/'.$data[$i]['waterpoint_name']; ?>" class="btn btn-default btn-xs"><?php echo $activeStatus; ?></a>
                                   
                                  
                            </td>
                                <td class="buttons" >
                                    <a href="<?php echo URL ?>generalclass/update/<?php echo $table . "/" . $data[$i]['id']; ?>" class="btn btn-default btn-xs">Edit</a>
                                    <a onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>);" class="btn btn-default btn-xs">Delete</a>
                                </td> 
                            <?php }
                                echo '</form>';
                             ?>
                        </tr>
                    <?php $i++; }
                        ?>					
                </tbody>
            </table>
         
          </div>
        <?php } else { ?>
            <p><b>No Record Found</b></p>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        // Setup - add a text input to each footer cell
        $('#data-table1 tfoot th').each( function () {
            var title = $('#data-table1 thead th').eq( $(this).index() ).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );

        
        var visiblecols = [];
        $( '#data-table1 thead th').each( function(e){
            if ($(this).hasClass('export-visible') ) {
                visiblecols.push($(this).index());
            }
        });

        var table = $('#data-table1').DataTable( {
            scrollY: "500px",
            scrollX:"100%",
            scrollCollapse: true,           
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

    });
</script>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo "Add " . $tableName . ""; ?></h4>
            </div>
            <form  action="<?php echo URL; ?>generalclass/add/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                                foreach ($fields as $key => $value) {
                                    if ($value['Key'] == 'PRI') {

                                        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                    } else if ($value['Key'] == 'MUL' && $value['Field']!='country') {
                                        echo '
                                         	<div class="form-group">
                                            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                				<select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                    <option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                    foreach ($value['parents'] as $key => $value_) {
                                                        echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                    }
                                                echo '</select>
                                			</div>';
                                    } else if ($value['Field']=='country') {

                                        echo '<input type="hidden" name="'.$value['Field'].'" value="'.$_SESSION['country'].'" readonly/>';
                                    } else if ($value['Field'] == 'village' ) {
                                        echo'   <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                        <option value="">Select '. ucwords(str_replace('_', ' ', $value['Field'])) .'</option>';
                                                        foreach ($villages as $key => $village) {
                                                            echo'<option value="' . $village['id'] . '" >' . $village['village'] . '</option>';
                                                        }                                                        
                                        echo'       </select>
                                                </div>';                                      
                                    } else if (strpos($value['Field'], 'code') !== false && $value['Field'] !="dispenser_barcode") {
                                        echo '
                                            <div class="form-group">
                                            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                				<input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
                                			</div>
                                		';    
                                    } else if (strpos($value['Field'], 'notes') !== false) {
                                        echo '
                                	            <div class="form-group">
                                	                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                			        <textarea id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm"></textarea>
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
                                    } else if (strpos($value['Field'], 'name') !== false && ($value['Field'] == 'full_name' || $value['Field'] == 'name')) {
                                        echo '
                                            <div class="form-group">
                                            	<label>First Name</label><br>
                                				<input type="text" id="first_name" name="first_name" class="form-control input-sm" />
                                			</div>
                                		';
                                        echo '
                                            <div class="form-group">
                                            	<label>Middle Name</label><br>
                                    			<input type="text" id="middle_name" name="middle_name" class="form-control input-sm" />
                                    		</div>
                                    	';
                                        echo '
                                            <div class="form-group">
                                            	<label>Last Name</label><br>
                                				<input type="text" id="last_name" name="last_name" class="form-control input-sm"/>
                                			</div>
                                		';
                                        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                    } else if (strpos($value['Field'], 'date') !== false ) {
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
                                }
                            ?>	
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-waterpoint-data" id="add-waterpoint-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>  

<script type="text/javascript">
    $('#myModal').on('show.bs.modal', function(e) {

        autoColumn(4, '#myModal .modal-body .row', 'div', 'col-md-3');
        $('#message').html('');

    });

    function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>generalclass/delete/' + tables + '/' + deleteId);
         } else {
            console.log('<?php echo URL ?>generalclass/delete/' + tables + '/' + deleteId);
            return false;
        }
    }

    //$('form').validate();
    //we needto find the form parent of the input entered through the td then tr which contains the id of the form
  $("#data-table1 input").focusout(function() {
    //console.log($(this).attr('value'));
    var tdParent=$(this).parent();
    var trParent=tdParent.parent();
   // console.log(trParent.get());

    var formParent=trParent.attr('data-id');
    var allKids=$("#"+formParent).children(" form input");
   // console.log(allKids);

   
   $.post( "<?php echo URL.'generalclass/update/'.$table; ?>",  $("#"+formParent).serialize() );    
  //$("#"+formParent).submit();   
  });
  $("#data-table1 select").change(function() {
    //console.log($(this).attr('value'));
    if($(this).attr('name') !=null){

    var tdParent=$(this).parent();
    var trParent=tdParent.parent();
   // console.log(trParent.get());

    var formParent=trParent.attr('data-id');
    var allKids=$("#"+formParent).children(" form input");
    //console.log(allKids);
  
      $.post( "<?php echo URL.'generalclass/update/'.$table; ?>",  $("#"+formParent).serialize() );  
     //$("#"+formParent).submit();     
    }
 
  });
    

<?php
if(isset($_POST['editable'])){
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
        console.log("<?php echo URL ?>generalclass/ajaxChildCau/<?php echo $territoryArray[$i+1]; ?>/<?php echo $value['territory_name'];?>/"+$("#<?php echo $value['territory_name'] ?>ajax").find(":selected").val());
          $.ajax({
        url: "<?php echo URL ?>generalclass/ajaxChildCau/<?php echo $territoryArray[$i+1]; ?>/<?php echo $value['territory_name'];?>/"+$("#<?php echo $value['territory_name'] ?>ajax").find(":selected").val(),
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
         $("#<?php echo $territoryArray[$i+1]; ?>ajax").append("<option value=''></option>");
            
            $(data).each(function(){
                
              //We Need To Loop Through the select tag searching for any value matching the json values
           $("#<?php echo $territoryArray[$i+1]; ?>ajax").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["admin_territory_name"]+"</option>");    
            
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
}
?>

</script>