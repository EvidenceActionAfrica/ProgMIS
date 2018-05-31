<?php $lastUrl = $generaldata_model->getLastURL($_SERVER['REQUEST_URI']); ?>
<div class="col-md-10">
    <h3 class=" text-center"><?php echo $tableName;
    if(isset($issueState)){echo ' - '.$issueState;} ?></h3>
        <?php if (isset($_GET['message'])) { ?>
                <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
                    <?php 
                        echo  $_GET['message'];
                    ?>
                    <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </div>
                <?php } ?>
    <div id="data-table-manger">

        <div class="clearfix">

            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">
                   
                        <button type="button" id="activateIssue" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add <?php echo $tableName; ?></button>
                    
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="table-responsive">
        <?php if (!empty($data)) { ?>
   
            <table id="data-table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                    <th class="index" >#</th>
                        <?php
                         if(!isset($status)){
                            $status=NULL;
                        }
                        if(!isset($approved)){
                            $approved=NULL;
                        }
                        
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' && $table != "staff_category") {
                                continue;
                            }
                            
                            if ($key == 'full_name' && $table == "issues") {
                                $key = "To be Handled_by";
                            }
                          

                                if ($key == "country" || $key == "Country" || $key == "raised_by" ) {
                                    continue;
                                } else if ($key == 'full_name' && $table == "issues") {
                                    $key = "Handled_by";
                                } else if ($key == 'id'){
                                    echo '<th>' . ucwords(str_replace('_', ' ', "Issue Id")) . '</th>';
                                } else {
                                    echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                          
                        }
                        
                        ?>
                        <?php 
                        /**
                         * The Nested If Above Determines How Many Headers Are Made As You navigate  Through
                         * To Simplify The Creation of these i have decided to use a switch to determine 
                         * the number of times the while loop below for creating the headers will run
                         * 
                         */
                       
                        if($status==NULL && $approved==NULL){
                            //This Situation is When All issues is Selected Or the default when accessing issueTracker
                            $counter=0;
                            
                        }else if($approved=="Yes"){
                            //This is when The Approved Issues Link Is Selected
                             $counter=2;
                        }else if($approved=="redo"){
                            //This is When you select the disapproved issues
                            $counter=2;
                        }else if($approved=="No" && $status==2){
                            //This Is When you select the resolved but unapproved issues
                            $counter=2;
                        }else if($approved=="No" && $status==1){
                            //For unapproved or when something unexpected happens
                            $counter=2;
                            
                        }else{
                            //For unapproved or e=when something unexpected happens
                            $counter=2;
                        }
                      if($approved=="No" && $status==1 || $approved=="redo"){
                       // echo '<th>View/Take</th>';
                        echo '<th class="buttons">Communication</th>';
                       
                      }
                     while($counter>0){ ?>
                            <th class="buttons"></th>
                        <?php 
                        --$counter;
                        }?>   
                    </tr>
                </thead>
                    <tfoot>
                    <tr>
                    <th class="index">#</th>
                        <?php
                         if(!isset($status)){
                            $status=NULL;
                        }
                        if(!isset($approved)){
                            $approved=NULL;
                        }
                        
                        foreach ($data[0] as $key => $value) {
                            if ($key == 'position' && $table != "staff_category") {
                                continue;
                            }
                            
                            if ($key == 'full_name' && $table == "issues") {
                                $key = "To be Handled_by";
                            }
                          

                                if ($key == "country" || $key == "Country" || $key == "raised_by" ) {
                                    continue;
                                } else if ($key == 'full_name' && $table == "issues") {
                                    $key = "Handled_by";
                                } else if ($key == 'id'){
                                    echo '<th>' . ucwords(str_replace('_', ' ', "Issue Id")) . '</th>';
                                } else {
                                    echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                          
                        }
                        
                        ?>
                        <?php 
                        /**
                         * The Nested If Above Determines How Many Headers Are Made As You navigate  Through
                         * To Simplify The Creation of these i have decided to use a switch to determine 
                         * the number of times the while loop below for creating the headers will run
                         * 
                         */
                       
                        if($status==NULL && $approved==NULL){
                            //This Situation is When All issues is Selected Or the default when accessing issueTracker
                            $counter=0;
                            
                        }else if($approved=="Yes"){
                            //This is when The Approved Issues Link Is Selected
                             $counter=2;
                        }else if($approved=="redo"){
                            //This is When you select the disapproved issues
                            $counter=2;
                        }else if($approved=="No" && $status==2){
                            //This Is When you select the resolved but unapproved issues
                            $counter=2;
                        }else if($approved=="No" && $status==1){
                            //For unapproved or when something unexpected happens
                            $counter=2;
                            
                        }else{
                            //For unapproved or e=when something unexpected happens
                            $counter=2;
                        }
                      if($approved=="No" && $status==1 || $approved=="redo"){
                       // echo '<th>View/Take</th>';
                        echo '<th class="buttons">Communication</th>';
                       
                      }
                     while($counter>0){ ?>
                            <th class="buttons"></th>
                        <?php 
                        --$counter;
                        }?>   
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $i = 1;
                    $requiredGet='';
                    // echo "<pre>";var_dump($data);echo "</pre>";
                    foreach ($data as $key => $value) {
                     // if(isset($value['date_created'])){
                         $timeSet=strtotime($value['date_created']);
                       //  echo $value['complete'];
                        $date=date("d-M-Y");
                         $time=strtotime($date);
                         $difference=$timeSet-$time;
                         $difference=abs($difference)/60/60/24;
                         $flag=(86400*3)/60/60/24;
                       
                         
                        ?>
                        <tr style="margin-bottom:10px;">
                        <td class="index"></td>
                            <?php
                            foreach ($value as $key => $value2) {
                              
                                // echo "<pre>";var_dump($key);echo "</pre>";         
                                if ($key == 'position' && $table != "staff_category" || $key == "raised_by") {
                                    continue;
                                }
                                if ($i == 1) {
                                    $issueId = $value2;
                                }
                                    
                                    if($key=='full_name'){
                                        $requiredGet.='handled_by='.urlencode($value2);
                                    }
                                
                                    if ($key == "country" || $key == "Country" || $key == "raised_by") {
                                        continue;
                                    } else {
                                        echo '<td style="';

                                        if($difference>=$flag &&  $status ==1  ){
                                         echo "color:#FC0000;";
                                       }
                                         echo' ">' . $value2 . '</td>';
                                    }
                                
                                 $i = 0;	
                            }
                             $i = 1;
                                
                             //The  Button That redirects to Actions Done to resolve an issue(Issue Action)
                             //Should only appear When Attempting To Resolve An issue  or in Disapproved Issues Therefore should only 
                             //display when  the unresolved issues or disapproved issues links have  been clicked
                             if($approved=="No" && $status==1 || $approved=="redo"){
                           ?> 
                           <!---
                             <td><a href="<?php echo URL?>issuetracker/issuesaction/<?php echo $issueId; ?>"><button class="btn btn-success btn-sm">Log</button></a></td>
                            -->
                             <td><a  class="btn btn-default btn-sm" href="<?php echo URL.'issuetracker/tracker/?id='.$value['id'].'&'.$requiredGet;?>" >Sms</a> 
                             <a  class="btn btn-default btn-sm" href="<?php echo URL.'issuetracker/tracker/?email='.$value['id'].'&'.$requiredGet;?>"  class="btn btn-default btn-sm" >Email</a></td> 
                               
                          <?php 
                          $requiredGet='';
                             }//End Of Issue Action Logic
                                 
                             //The Button Below Turns An issue from unapprved to Approved.
                             //It Should only Appear When An issue is resolved but not approved
                             //Display When the resolved but unapproved link is selected
                         if($approved=="redo" AND $status==Null Xor $approved=="No" AND $status==2){
                                  echo '<td><a href="'.URL.'issuetracker/complete/'.$issueId.'/1"><button class="btn btn-success btn-sm">Approve</button></a></td>
                          ';    
                                }
                             
                             //The Button Below Turns An issue from unapprved to disapproved or approved to disapproved.
                             //It Should only Appear When An issue is resolved but not approved or when approved
                             //Display When the resolved but unapproved or approved  links  are selected.
                             if($approved=="No"&& $status !=1 Xor $approved=="Yes" ){
                            echo '<td><a onclick="assignId('.$issueId.')" data-toggle="modal" class="btn btn-warning btn-sm" style="text-decoration:none;" data-target="#disapproval">Disapprove</a></td>';    
                             }//End of disapprove button logic
                             
                             
                             //The Button Below Turns An issue from Approved to Complete.
                             //It Should only Appear When An issue is  approved
                             //Displayed When the  approved  link is selected.
                             if($approved=="Yes"  && $status==null){

                                     echo '<td><a href="'.URL.'issuetracker/complete/'.$issueId.'/1"><button class="btn btn-info btn-sm">Complete</button></a></td>
                          '; 
                            }//End of Complete button logic
                             
                             
                             //The Buttons Below are for Edit And Delete.
                             //They Should only Appear When An Issue is Unresolved
                            if($approved=="No" && $status==1){
                            ?>
                                <td><a href="<?php echo URL?>issuetracker/edittracker/<?php echo $issueId; ?>"><button class="btn btn-default btn-sm">Edit</button></a></td> 
                                <td><a onclick='show_confirm(<?php echo '"'.$table.'"'.','.$issueId; ?>);'><button class="btn btn-default btn-sm">Delete</button></a></td>    							
                                <?php
                            }
                            ?>
                            
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
 <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="40px" style="position:absolute;top:50%;left:50%;margin:0 auto; visibility: visible"/>

</div>
<script type="text/javascript">
    $(document).ready(function() {
      


    <?php 
    if(isset($_GET['id'])){
        echo ' $("#openSms").click();';
    }
    
     if(isset($_GET['email'])){
        echo ' $("#openEmail").click();';
    }
    ?>
    });


</script>
<script type="text/javascript">
  <?php if (!empty($data)) { ?>
    $(document).ready(function() {

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
                        mColumns: [1,2,3,4,5,6,7,8,9,10,11]
                    },
                    {
                        sExtends: "xls",
                        sButtonText: "Export Filtered",
                        oSelectorOpts: { filter: 'applied', order: 'current' },
                        mColumns: [1,2,3,4,5,6,7,8,9,10,11]
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
<?php }?>
</script>

 <button id="openSms" data-toggle="modal" class="sms btn btn-default btn-sm" data-target="#mySmsModal" style='display:none;' >Sms</button> 
  <button id="openEmail" data-toggle="modal" class="sms btn btn-default btn-sm" data-target="#myEmailModal" style='display:none;' >Email</button> 
                           
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo "Add " . $tableName . ""; ?></h4>
            </div>
            <form  action="<?php echo URL; ?>issuetracker/add/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">

                        <div class="col-md-12">
                        <?php                        
                                foreach ($fields as $key => $value) {
                                    if($value['Key'] == 'PRI'){
                                        continue;
                                    }elseif ($value['Key'] == 'MUL' && $value['Field'] =="country") {
                                      echo '
                                            <div class="form-group">';
                                          
                                              echo'<input type="hidden" name="' . $value['Field'] . '" value="' . $_SESSION['country'] . '"  class="form-control input-sm" >';
                                      echo '
                                            </div>'; 

                                }elseif ($value['Key'] == 'MUL') {
                                        echo '
                                            <div class="form-group">
                                            <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                    foreach ($value['parents'] as $key => $value_) {
                                                        echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                    }
                                                    echo '</select>
                                            </div>';
                                    }else if ($value['Field'] == 'email') {
                                        echo '
                                            <div class="form-group">
                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                <input type="email" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
                                                        </div>
                                                ';
                                    } else if (strpos($value['Field'], 'waterpoint_id') !== false && isset($waterpoint)) {
                                        echo '
                                            <div class="form-group">
                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" value="'.$waterpoint.'"/>
                                                        </div>
                                                ';
                                    }else if (strpos($value['Field'], 'phone') !== false) {
                                        echo '
                                            <div class="form-group">
                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                        </div>
                                                ';
                                    } else if (strpos($value['Field'], 'category') !== false) {
                                        echo '

                                            <div class="form-group">
                                                <label> '. ucwords(str_replace('_', ' ', $value['Field'])) .'</label><br>
                                                                <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm">
                                                                   '; 
                                                                   foreach ($categoryDropDown as $key => $value) {
                                                                       echo '<option value="'.$value['id'].'">'.$value['category'].'</option>';
                                                                   }

                                                            echo '</select>
                                            </div>
                                        
                                                ';
                                    } else if (strpos($value['Field'], 'office_location') !== false) {
                                        echo '
                                            <div class="form-group">
                                                <label> '. ucwords(str_replace('_', ' ', $value['Field'])) .'</label><br>
                                                                <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                                   <option value="">Select Office Location</option>
                                                                   '; 
                                                                   foreach ($officeLocationDropDown as $key => $value) {
                                                                       echo '<option value="'.$value['id'].'">'.$value['office_location'].'</option>';
                                                                   }

                                                            echo '</select>
                                            </div>
                                                
                                                ';
                                    } else if (strpos($value['Field'], 'staff') !== false) {
                                        echo '
                                            <div class="form-group">
                                                <label>Staff Name</label><br>
                                                                <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                                 <option value="">Select F.O</option>
                                                                   '; 
                                                                   foreach ($staffDropDown as $key => $value) {
                                                                       echo '<option value="'.$value['id'].'">'.$value['full_name'].'</option>';
                                                                   }

                                                            echo '</select>
                                            </div>
                                                
                                                ';
                                    } else if (strpos($value['Field'], 'full_name') !== false) {
                                        echo '
                                            <div class="form-group">
                                                <label>To be Handled By</label><br>
                                                                <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                                  <option value="">Select F.O</option>
                                                                   '; 
                                                                   foreach ($staffDropDown as $key => $value) {
                                                                       echo '<option value="'.$value['id'].'">'.$value['full_name'].'</option>';
                                                                   }

                                                            echo '</select>
                                            </div>
                                                
                                                ';
                                    }else if (strpos($value['Field'], 'raised_by') !== false ) {
                                        echo '
                                            <div class="form-group">
                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                                  <option value="">Select F.O</option>
                                                                   '; 
                                                                   foreach ($staffDropDown as $key => $value) {
                                                                    if(isset($created_by)){
                                                                        if($value['full_name']==$created_by){
                                                                            echo '<option value="'.$value['full_name'].'" selected >'.$value['full_name'].'</option>';
                                                                        }
                                                                    }

                                                                       echo '<option value="'.$value['full_name'].'">'.$value['full_name'].'</option>';
                                                                    
                                                                   }

                                                            echo '</select>
                                            </div>
                                                
                                                ';
                                    }else if (strpos($value['Field'], 'contact') !== false) {
                                        echo '
                                            <div class="form-group">
                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                        </div>
                                                ';
                                    } else if (strpos($value['Field'], 'date') !== false && isset($activeDate)) {
                                        echo '
                                                <div class="form-group">
                                                    <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker" value="'.$activeDate.'" />
                                                </div>
                                            ';
                                    } else if (strpos($value['Field'], 'date') !== false) {
                                        echo '
                                                <div class="form-group">
                                                    <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
                                                </div>
                                            ';
                                    }else if(strpos($value['Field'], 'issue_remarks') !== false && isset($message)){
                                        echo '
                                                <div class="form-group">
                                                   <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br/>
                                                     <textarea id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" >'.$message.'</textarea>
                                                </div>
                                            ';
                                    }else if(strpos($value['Field'], 'action_taken') !== false || strpos($value['Field'], 'remarks') !== false ||strpos($value['Field'], 'response') !== false && !isset($message)){
                                        echo '
                                                <div class="form-group">
                                                   <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br/>
                                                     <textarea id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" ></textarea>
                                                </div>
                                            ';
                                    }else if(strpos($value['Field'], 'issue_id') !== false){
                                        echo '
                                                <div class="form-group">
                                                   
                                                    <input type="hidden" id="' . $value['Field'] . '" name="' . $value['Field'] . '"  value="'.$issueId.'"/>
                                                </div>
                                            ';
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-issues-data" id="add-issues-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>  

<!-- Modal -->
<div class="modal fade" id="mySmsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo "Send " . $tableName . " via Sms"; ?></h4>
            </div>

            <form  action="<?php echo URL; ?>issuetracker/contacttype/?id=<?php echo $_GET['id']; ?>" data-async data-target="mySmsModal" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">           
                            <div class="form-group">
                                <label>Sender</label><br/>
                                <input type="text" name="sender" class="form-control input-sm" value="<?php echo $_SESSION['full_name']; ?>" readonly />
                            </div>

                            <div class="form-group">
                                <label>Recipient Name</label><br/>
                                <select id="recipient_name" name="recipient_name" class="form-control input-sm" >
                                  <?php

                                  foreach ($staffDropDown as $key => $value) {
                                     if(isset($_GET['handled_by'])){

                                                    if($_GET['handled_by']==$value['full_name']){
                                                        echo '<option value="'.$value['id'].'" selected>'.$value['full_name'].'</option>';
                                                        continue;
                                                    }
                                      }
                                    echo '<option value="'.$value['full_name'].'">'.$value['full_name'].'</option>';                                
                                  }
                                  ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Recipient Number</label><br/>
                                <input type="text" id="sms_number" name="recipient_number" class="form-control input-sm" value="<?php echo $recepientNumber; ?>" placeholder="+254" required/>
                            </div>

                         
                            <div class="form-group">
                                <label>Current Date</label><br/>
                                <input type="text"  class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" readonly />
                            </div>

                            <div class="form-group">
                                <label>Subject</label><br/>
                                <!--<input type="text" name="subject" class="form-control input-sm" value=""  />-->
                                <select id="subject_sms" name="subject" class="form-control input-sm" required>
                                    <option value="">Select Message</option>
                                  <?php
                                  foreach ($smsDropDown as $key => $value) {                                     
                                    echo '<option value="'.$value['template_name'].'">'.$value['template_name'].'</option>';                                
                                  }
                                  ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>SMS body</label><br/>
                                <!--<input type="text" id="template_body_sms" name="sms_body" class="form-control input-sm" value="" placeholder="+254" required/>-->
                                <textarea name="sms_body" class="template_body_sms form-control input-sm" required/></textarea>
                            </div>  
                             <div class="form-group">
                                <label>Issue status</label><br/>
                                 <select id="issue_status" name="issue_status" class="form-control input-sm" >
                                  <?php

                                  foreach ($issueStatus as $key => $value) {

                                    echo '<option value="'.$value['id'].'">'.$value['issue_status'].'</option>';                                
                                  }
                                  ?>
                                </select> 
                            </div>  
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-sendSms-data" id="add-sendSms-data">Send Sms</button>
                                
                </div> 
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myEmailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo "Send " . $tableName . " via Email"; ?></h4>
            </div>

            <form  action="<?php echo URL; ?>issuetracker/contacttype/?email=<?php echo $_GET['email']; ?>" data-async data-target="myEmailModal" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">           
                            <div class="form-group">
                                <label>Sender</label><br/>
                                <input type="text" name="sender" class="form-control input-sm" value="<?php echo $_SESSION['full_name']; ?>" readonly />
                            </div>

                            <div class="form-group">
                                <label>Recipient Name</label><br/>
                             <select id="emailRecepient_name" name="recipient_name" class="form-control input-sm" >
                                  <?php

                                  foreach ($staffDropDown as $key => $value) {
                                     if(isset($_GET['handled_by'])){

                                                    if($_GET['handled_by']==$value['full_name']){
                                                        echo '<option value="'.$value['id'].'" selected>'.$value['full_name'].'</option>';
                                                        continue;
                                                    }
                                      }
                                    echo '<option value="'.$value['full_name'].'">'.$value['full_name'].'</option>';                                
                                  }
                                  ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Recipient Email</label><br/>
                                <input type="email" id="emailRecepient4" name="recipient_email" class="form-control input-sm" value="<?php echo $recepientEmail; ?>" placeholder="someone@someplace.com" required/>
                            </div>

                            <div class="form-group">
                                <label>Current Date</label><br/>
                                <input type="text"  class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" readonly />
                            </div>

                            <div class="form-group">
                                <label>Subject</label><br/>
                                <select id="subject_email" name="subject" class="form-control input-sm" required>
                                    <option value="">Select Message</option>
                                  <?php
                                  foreach ($smsDropDown as $key => $value) {                                     
                                    echo '<option value="'.$value['template_name'].'">'.$value['template_name'].'</option>';                                
                                  }
                                  ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Email body</label><br/>
                                <textarea name="email_body" class="template_body_sms form-control input-sm" required/></textarea>
                            </div> 
                            <div class="form-group">
                                <label>Issue status</label><br/>
                                 <select id="issue_status" name="issue_status" class="form-control input-sm" >
                                  <?php

                                  foreach ($issueStatus as $key => $value) {

                                    echo '<option value="'.$value['id'].'">'.$value['issue_status'].'</option>';                                
                                  }
                                  ?>
                                </select> 
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-sendMail-data" id="add-sendMail-data">Send Mail</button>                              
                                
                </div> 
            </form>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="disapproval" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Disapproval Form</h4>
            </div>

            <form  action="<?php echo URL; ?>issuetracker/disapproved/" data-async data-target="disapproval" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">           
                            <div class="form-group">
                                <label>Disapproved By</label><br/>
                                <input type="text" name="disapproved_by" class="form-control input-sm" value="<?php echo $_SESSION['full_name']; ?>" readonly />
                            </div>
                            <div class="form-group">
                                <label>Reassigned To</label><br/>
                                   <select id="' . $value['Field'] . '" name="reassigned_to" class="form-control input-sm">
                                        <?php
                                         foreach ($staffDropDown as $key => $value) {
                                             echo '<option value="'.$value['id'].'">'.$value['full_name'].'</option>';
                                         }
                                         ?>
                                </select>

                            </div>

                            <div class="form-group">
                                <label>Why Disapproved?</label><br/>
                                <textarea name="reason_disapproved"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Solution</label><br/>
                          <textarea name="solution"></textarea>
                         </div>
                               <?php
                               foreach ($fields as $key => $value) {
                                if ($value['Key'] == 'PRI') {
                                    echo '<input id="assignedIssue" type="hidden"  name="' . $value['Field'] . '"/>';
                                } 
                               }
                                 ?>
                         
  
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="disapprove-issue" id="disapprove-issue">Disapprove</button>
                                
                </div> 
            </form>
        </div>
    </div>
</div>




<script type="text/javascript">
    $('#myModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');

    });

    $('#mySmsModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#mySmsModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');

    });
    $('#myEmailModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#myEmailModal .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');
     
    });
     function assignId(issueId){
        var assignedIssue=document.getElementById('assignedIssue');
        assignedIssue.value=issueId;
        console.log("Issue Id is"+assignedIssue.value);
        }
   $('#disapproval').on('show.bs.modal', function(e) {

        autoColumn(3, '#disapproval .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');
     
    });
$("#recipient_name").change(function() {
   

    var getRecepient=encodeURIComponent($("#recipient_name").find(":selected").text()).replace(/[!'()]/g, escape).replace(/\*/g, "%_A");
    console.log(getRecepient);
           $.ajax({
        url: "<?php echo URL ?>issuetracker/ajax_staff_details/phone/?info="+encodeURIComponent($("#recipient_name").find(":selected").text()).replace(/[!'()]/g, escape).replace(/\*/g, "%_A"),
        beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
        }
        })
        .done(function( data ) {
           data=jQuery.parseJSON(data);
        if ( console && console.log ) {
            
        console.log( "Sample of data:", data.slice( 0, 100 ) );
        }
       
        $("#sms_number").attr('value',data[0]["phone"]);
        });

   }
   );
   
 $("#subject_sms").change(function() {
   

    var getRecepient=encodeURIComponent($("#subject_sms").find(":selected").text()).replace(/[!'()]/g, escape).replace(/\*/g, "%_A");
    console.log(getRecepient);
           $.ajax({
        url: "<?php echo URL ?>issuetracker/ajax_sms_details/phone/?info="+encodeURIComponent($("#subject_sms").find(":selected").text()).replace(/[!'()]/g, escape).replace(/\*/g, "%_A"),
        beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
        }
        })
        .done(function( data ) {
           data=jQuery.parseJSON(data);
        if ( console && console.log ) {
            
        console.log( "Sample of data:", data.slice( 0, 100 ) );
        }
       
        $(".template_body_sms").val(data[0]["message"]);
        });

   }
   );
   
   $("#subject_email").change(function() {
   

    var getRecepient=encodeURIComponent($("#subject_email").find(":selected").text()).replace(/[!'()]/g, escape).replace(/\*/g, "%_A");
    console.log(getRecepient);
           $.ajax({
        url: "<?php echo URL ?>issuetracker/ajax_sms_details/phone/?info="+encodeURIComponent($("#subject_email").find(":selected").text()).replace(/[!'()]/g, escape).replace(/\*/g, "%_A"),
        beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
        }
        })
        .done(function( data ) {
           data=jQuery.parseJSON(data);
        if ( console && console.log ) {
            
        console.log( "Sample of data:", data.slice( 0, 100 ) );
        }
       
        $(".template_body_sms").val(data[0]["message"]);
        });

   }
   );
$("#emailRecepient_name").change(function() {
   

    var getRecepient=encodeURIComponent($("#emailRecepient_name").find(":selected").text()).replace(/[!'()]/g, escape).replace(/\*/g, "%_A");
    console.log(getRecepient);
           $.ajax({
        url: "<?php echo URL ?>issuetracker/ajax_staff_details/phone/?info="+encodeURIComponent($("#emailRecepient_name").find(":selected").text()).replace(/[!'()]/g, escape).replace(/\*/g, "%_A"),
        beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
        }
        })
        .done(function( data ) {
           data=jQuery.parseJSON(data);
        if ( console && console.log ) {
            
        //console.log( "Sample of data:", data.slice( 0, 100 ) );
        console.log(data[0]["email"]);
        }
       
        //$("#emailRecepient").empty();
        $("#emailRecepient4").attr('value',data[0]["email"]);
        // document.getElementById("emailRecepient4").innerHTML=data[0]["email"];
        });

   }
   );
    <?php
    if(isset($created_by)){
        echo "window.onload=function(){ var btn=document.getElementById('activateIssue');"
        . "btn.click();"
        . "console.log('Button Called');};";
    }  
    
    
    ?>
  
       function show_confirm(table,deleteId) {
           console.log("Delete Operation activated");
             if (confirm("Are you sure you want to delete?")) {
                    location.replace('<?php echo URL?>issuetracker/delete/'+ table+'/' + deleteId);
                          
              } else {
                 return false;
              }
        }
       

          $("#country").change(function() {
          $.ajax({
        url: "<?php echo URL ?>issuetracker/ajax_call/field_office/office_location/country/"+$("#country").find(":selected").val(),
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
        
        $("#office_location").empty();
        
            
            $(data).each(function(){
                
              //We Need To Loop Through the select tag searching for any value matching the json values
           $("#office_location").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["office_location"]+"</option>");    
            
            console.log("passed thru");
            console.log(data[counter-1]["office_location"]);
        if(counter<data.length){
        counter+=1;
    }
    })
         
 
        /*
        $(data).each(function(){
        console.log(data[counter-1]["office_location"]);
        counter+=1;
        });
        */
        });
        
           $.ajax({
        url: "<?php echo URL ?>issuetracker/ajax_call/staff_list/full_name/country/"+$("#country").find(":selected").val(),
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
        
        $("#full_name").empty();
        $("#raised_by").empty();
        
            
            $(data).each(function(){
                
              //We Need To Loop Through the select tag searching for any value matching the json values
           $("#full_name").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["full_name"]+"</option>");    
           $("#raised_by").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["full_name"]+"</option>");    
            
            console.log("passed thru");
            console.log(data[counter-1]["full_name"]);
        if(counter<data.length){
        counter+=1;
    }
    })
         
 
        /*
        $(data).each(function(){
        console.log(data[counter-1]["office_location"]);
        counter+=1;
        });
        */
        });     
        
        
        
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
 
        /*
        $(data).each(function(){
        console.log(data[counter-1]["office_location"]);
        counter+=1;
        });
        */
        });
        
         
// $("#office_location").change(function() {
//         // console.log($("#category").find(":selected").text());

//           $.ajax({
//         url: "<?php echo URL ?>issuetracker/ajax_call/staff_list/full_name/office_location/"+$("#office_location").find(":selected").val(),
//         beforeSend: function( xhr ) {
//         xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
//         }
//         })
//         .done(function( data ) {
//            data=jQuery.parseJSON(data);
//         if ( console && console.log ) {
            
//        // console.log( "Sample of data:", data.slice( 0, 100 ) );
        
//         }
//         var counter=1;
        
//         $(".handled_by").empty();
        
            
//             $(data).each(function(){
                
//               //We Need To Loop Through the select tag searching for any value matching the json values
//            $(".handled_by").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["full_name"]+"</option>");    
            
//             console.log("passed thru");
//             console.log(data[counter-1]["full_name"]);
//         if(counter<data.length){
//         counter+=1;
//     }
//     });
//         });  
 
//         /*
//         $(data).each(function(){
//         console.log(data[counter-1]["office_location"]);
//         counter+=1;
//         });
//         */
// });      
        
        
       
 function fixedEncodeURIComponent (str) {
  return encodeURIComponent(str).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");
}
        // $('#myModal').on('click','#add-admin-data', function(event) {

    //     var $form = $('#myModal form');
    //     var $target = $($form.attr('data-target'));

    //     $.ajax({
    //         type: $form.attr('method'),
    //         url: $form.attr('action'),
    //         data: $form.serialize(),

    //         success: function(data, status) {
    //         	if ( status == 'success') {
    //             	$('#message').html('<p class="bg-success"><span class="glyphicon glyphicon-ok-circle" ></span> Data Successfully Added</p>');
    //             	$('#myModal form').get(0).reset();
    //         	} else {
    //             	$('#message').html('<p class="bg-danger"><span class="glyphicon glyphicon-remove-circle" ></span> Error Adding Data</p>');
    //         	}
    //         }
    //     });

    //     event.preventDefault();
    // });


</script>