<?php
isset($tabActive)?$tabActive=$tabActive:$tabActive='tab1';

?>
<div class="col-md-10 col-md-offset-2">

    <?php if (isset($_GET['status'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php 
                $status=$_GET['status'];
            	if($status=='F'){
                    echo 'Uploading Data Failed.Please Check Your Csv.';
                }else if($status=='P'){
                    echo 'All The Waterpoints have been Saved.';
                }else if($status=='D'){
                    echo  'Upload Table Emptied';
                }else{
                	echo 'Upload Completed.You can re-check your data on the table below.';        
                }
            ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>

    <?php if (isset($message)) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php echo $message; ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>
  
    <h3 class="text-center">Continuous Evaluation</h3>
        
            <ul class="nav nav-pills">
                <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">New Survey</a></li>
                <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Data Check</a></li>
            </ul>
            <div class="tab-content">
               
                <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1" >
                <div class="col-md-4">
                	<form action="<?php echo URL;?>expansion/uploadPasslist/verification_temp" method="post" enctype="multipart/form-data">
                		<div class="form-group" style='margin-top:5%;'>
                         <label for="' . $value['Field'] . '">Upload New Survey...</label><br>
                            <input type="file" name="file" id="file" />
                        </div>
                        <input type='submit' class="btn btn" name='upload-verification' value='Upload'/>
                	</form>
                </div>

                <div class="col-md-10">

                    <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="30px" style="margin:0 auto; visibility: visible"/>

                	<div class="table-responsive">

                        <?php if (!empty($data)) { ?>

                            <table class="table table-striped table-hover table-bordered" id="data-table">
                                <thead>
                                    <tr>
                                        <?php
                                        foreach ($data[0] as $key => $value) {
                                            if ($key == 'position' && $table != "staff_category") {
                                                continue;
                                            }
                                            if (!in_array($key, $arrayName = array('id'))) {

                                                if ($key == "country" || $key == "Country") {
                                                    continue;
                                                } else {
                                                    echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                                }
                                            }
                                        }
                                        ?>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    // echo "<pre>";var_dump($data);echo "</pre>";
                                    foreach ($data as $key => $value) {
                                        ?>
                                        <tr>
                                            <?php
                                            foreach ($value as $key => $value) {
                                                // echo "<pre>";var_dump($key);echo "</pre>";         
                                                if ($key == 'position' && $table != "staff_category") {
                                                    continue;
                                                }
                                                if ($i == 1) {
                                                    $generalId = $value;
                                                }
                                                if (!in_array($key, $arrayName = array('id'))) {

                                                    if ($key == "country" || $key == "Country") {
                                                        continue;
                                                    } else {
                                                        echo '<td>' . $value . '</td>';
                                                    }
                                                }
                                                // $i = 0;	
                                            }
                                            // $i = 1;
                                            ?>
                                           
                                            
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>					
                                </tbody>
                            </table>
                            
                            <form action="<?php echo URL;?>expansion/uploadSurveyorlist/surveyor_temp" method="post" enctype="multipart/form-data">
                                <input type='submit' style="margin-bottom:5%;" data-toggle="tooltip" data-placement="top" title="This Moves the waterpoints from this staging area to the waterpoint details."  name='confirmWaterpoints' value='Confirm Waterpoints' class='submitWater btn btn-success' />
                                <input type='submit' style="margin-bottom:5%;margin-left:5%;" data-toggle="tooltip" data-placement="top" title="This Clears All The Uploaded Data."  name='clearWaterpoints' value='Empty Upload Table' class='clearWater btn btn-danger' />
                            </form>

                        <?php } else { ?>
                            <table class="table table-striped table-hover table-bordered" id="data-table">
                                <thead>
                                    <tr>
                                        <th><b>start</b></th>
                                        <th>Device Id</th>
                                        <th>End</th>
                                        <th>Surveyor Name</th>
                                        <th>Country</th>
                                        <th>Program</th>
                                        <th>County</th>
                                        <th>District</th>
                                        <th>Division</th>
                                        <th>location</th>
                                        <th>sublocation</th>
                                        <th>Village</th>
                                        <th>Waterpoint Name</th>
                                        
                                    </tr>
                                </thead>
                                  <tbody>
                                        <tr>
                                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                                            <td class="text-muted text-center"><em>Country or Leave Empty</em></td>
                                            <td class="text-muted text-center"><em>Program Name</em></td>
                                           <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                                            <td class="text-muted text-center"><small><em>(IMPORTANT!)</em></small></td>
                                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                                        </tr>
                                  </tbody>
                            </table>
                        <?php } ?>

                    </div>
                    
                </div>

            </div>
            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2" >
                <form method='POST' action='<?php echo URL."continuous/checkProgram"; ?>'>

                    <div style='margin-top:5%;' class="form-group">
                        <label for="program">Select A Program To Check</label>
                        <select id="program" name="program" class="form-control input-sm" style='width:350px;'>
                            <?php
                             foreach ($programDropDown as $key => $value_) {
                              echo'<option value="' . $value_['program'] . '" >' . $value_['program'] . '</option>';
                            }
                            ?>
                        </select>
                        <p style='clear:left;'></p>
                        <input type="submit" name="checkProgram" value="Check Program" class="btn btn-default"/>
                    </div>

                    <?php

                    if(isset($_POST['checkProgram'])){
                        ?>
                    <div class="table-responsive">
                        <?php if (!empty($surveryData)) { ?>

                            <table id="data-table" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <?php
                                        foreach ($data[0] as $key => $value) {
                                            if ($key == 'position' && $table != "staff_category") {
                                                continue;
                                            }
                                           
                                            if (!in_array($key, $arrayName = array('id'))) {

                                                if ($key == "country" || $key == "Country") {
                                                    continue;
                                                }else  if($key=="cem_cost"){
                                                    echo '<th>Costs associated with each CEM</th>';
                                             }else {
                                                    echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                                }
                                            }
                                        }
                                        ?>
                                       
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    // echo "<pre>";var_dump($data);echo "</pre>";
                                    foreach ($data as $key => $value) {
                                        ?>
                                        <tr>
                                            <?php
                                            foreach ($value as $key => $value) {
                                                // echo "<pre>";var_dump($key);echo "</pre>";         
                                                if ($key == 'position' && $table != "staff_category") {
                                                    continue;
                                                }
                                                if ($i == 1) {
                                                    $generalId = $value;
                                                }
                                                if (!in_array($key, $arrayName = array('id'))) {

                                                    if ($key == "country" || $key == "Country") {
                                                        continue;
                                                    } else {
                                                        echo '<td style="text-align:center;">' .$value . '</td>';
                                                    }
                                                }
                                             
                                            }
                                           
                                           
                                            ?>
                                                
                                                <td><a target="blank" href="<?php echo URL ?>expansion/pdfCEMFo/<?php echo  $data[$i]['program']; ?>"><button class="btn btn-success btn-xs">F.O Schedule</button></a></td> 
                                                <td><a target="blank" href="<?php echo URL ?>expansion/pdfCEM/<?php echo  $data[$i]['program']; ?>"><button class="btn btn-success btn-xs">CEM Budget</button></a></td> 
                                                <td><a href="<?php echo URL ?>scheduler/planSchedule/cem_gen_schedule/<?php echo  $data[$i]['program']; ?>"><button class="btn btn-info btn-xs">Edit Schedule</button></a></td> 
                                                <td><a href="<?php echo URL ?>expansion/CEMCompleteUpdate/community_education/<?php echo  $data[$i]['id']; ?>"><button class="btn btn-success btn-xs">Edit</button></a></td> 
                                                <td><a onclick="show_confirm('community_education', <?php echo $data[$i]['id']; ?>);"><button class="btn btn-danger btn-xs">Delete</button></a></td>                                
                                          
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>                  
                                </tbody>
                            </table>

                        <?php } else { ?>

                            <p><b>No Record Found</b></p>

                        <?php } ?>
                    </div>
                    <?php } ?>
                </form>
            </div>
      </div>
 </div>

<script type="text/javascript">
   function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>expansion/sVerificationUploadDelete/' + tables + '/' + deleteId);
            console.log('<?php echo URL ?>expansion/sVerificationUploadDelete/' + tables + '/' + deleteId);
     
         } else {
            //console.log('<?php echo URL ?>processdata/LsmDelete/' + tables + '/' + deleteId);
            return false;
        }
    }

   $('.submitWater').hover(function(){
	  $('.submitWater').tooltip('show');
	
	});
 	 $('.clearWater').hover(function(){
      $('.clearWater').tooltip('show');
    
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable({
            "scrollY": "100%",
            "scrollX": "500px"
            
        });
    });
</script>
