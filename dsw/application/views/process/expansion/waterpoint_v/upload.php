<?php $lastUrl = $expansionmodel->getLastURL($_SERVER['REQUEST_URI']); ?>

<div class="col-md-10">

    <?php if (isset($_GET['status'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php 
                $status=$_GET['status'];
                $villageStatus=isset($_GET['villageStatus'])?$_GET['villageStatus']:null;
                $duplicate=isset($_GET['duplicate'])?$_GET['duplicate']:null;
                	if($status=='F'){
                        echo 'Uploading Data Failed.Please Check Your Csv.';
                    }else if($status=='P' && $villageStatus !='Ok'){
                        echo 'Many waterpoints have been Saved.Unfortunately, Not all could be uploaded because their Villages were <br/> not found in the village list.Please Check Your C.A.U';
                    }else if($status=='P' && $villageStatus =='Ok' && $duplicate==null){
                        echo 'Waterpoints have been Saved.';
                    }else if($status=='P' && $villageStatus =='Ok' && $duplicate!=null){
                        echo 'Waterpoints have been Saved.'.$duplicate;
                    }else if($status=='S'){
                        echo  'The Status of some waterpoints is unknown.<br/>Set them Pass in order to move them to the waterpoint list';
                    }else if($status=='D'){
                        echo  'Upload Table Emptied';
                    }else{
                    	echo 'Upload Completed.You can re-check your data on the table below.';        
                    }
       

                   
                if(isset($_GET['duplicates'])){
                    echo '<br/>'.$_GET['duplicates'];
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
   <?php if (isset($_GET['message'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php echo $_GET['message']; ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>
    <h3 class="text-center">Upload Verified Waterpoints</h3>

    <div class="col-md-4">
    	<form action="<?php echo URL;?>expansion/uploadPasslist/verification_temp" method="post" enctype="multipart/form-data">
    		<div class="form-group">
             <label for="' . $value['Field'] . '">Upload...</label><br>
                <input type="file" name="file" id="file" />
            </div>
            <input type='submit' class="btn btn" name='upload-verification' value='Upload'/>
    	</form>
    </div>

    <div class="col-md-12">

        <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="30px" style="margin:0 auto; visibility: visible"/>

    	<div class="table-responsive">

            <?php if (!empty($data)) { ?>

                <table style='table-layout:auto' class="table table-striped table-hover table-bordered" id="data-table">
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
                                    } else if($key=="all_cau"){
                                        foreach ($cauList as $key3 => $value3) {
                                            echo '<th>'.ucwords(str_replace('_', ' ', $value3['territory_name'])).'</th>';
                                        }
                                        //echo '<th> Program Geography</th>';
                                    }else {
                                        echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                    }
                                }
                            }
                            ?>
                            <?php if ($table != "staff_list") { ?>
                                <th></th>
                                <th></th>
                            <?php } ?>
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
                                        } else if($key=='all_cau'){
                                               $allCaus=unserialize($value);
                                                foreach ($allCaus as $key => $value) {
                                                    echo '<td>' .$value. '</td>';
                                                }
                                       // } else if($key=='all_cau'){
                                            // $allCaus=unserialize($value);
                                            // $geographyCaus='';
                                            // $i=0;
                                            // foreach ($cauList as $key3 => $value3) {
                                            //     $geographyCaus.=ucwords(str_replace('_', ' ', $value3["territory_name"])).':'.$allCaus[$i].'<br/>';
                                            //     $i++;
                                            // }
                                            // echo '<td>' .$geographyCaus. '</td>';
                                        } else {
                                            echo '<td>' . $value . '</td>';
                                        }
                                    }
                                    // $i = 0;	
                                }
                                // $i = 1;
                                ?>
                               
                                    <td><a href="<?php echo URL ?>expansion/sVerificationUploadUpdate/<?php echo $table . "/" . $data[$i]['id']; ?>"><button class="btn btn-success btn-xs">Edit</button></a></td> 
                                    <td><a onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>);"><button class="btn btn-danger btn-xs">Delete</button></a></td>    							
                              
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>					
                    </tbody>
                </table>
                
                <form action="<?php echo URL;?>expansion/uploadPasslist/verification_temp" method="post" enctype="multipart/form-data">
                    <input type='submit' style="margin-bottom:5%;" data-toggle="tooltip" data-placement="top" title="This Moves the waterpoints from this staging area to the waterpoint details."  name='confirmWaterpoints' value='Confirm Waterpoints' class='submitWater btn btn-success' />
                    <input type='submit' style="margin-bottom:5%;margin-left:5%;" data-toggle="tooltip" data-placement="top" title="This Clears All The Uploaded Data."  name='clearWaterpoints' value='Empty Upload Table' class='clearWater btn btn-danger' />
                </form>

            <?php } else { ?>

                <p><b>No Verifications Uploaded So Far..</b><br/><br/>
                <b>Instructions</b><br/>
                <b>1.</b> To Upload Arrange Data in this format:(Include the column name(s))<br/>

                <br/>

                <table style='table-layout:auto' class="table table-striped table-hover table-bordered" id="data-table">
                    <thead>
                        <tr>
                            <th><b>id</b></th>
                            <th>country</th>
                            <th>Program</th>
                            <th>waterpoint Name</th>
                            <th>waterpoint Id</th>
                            <th>verification Id</th>
                            <th>Status</th>
                            <th>Dispenser Barcode</th>
                            <?php
                                foreach ($cauList as $key => $value) {
                                echo '<th>'.$value['territory_name'].'</th>';
                                }
                            ?>
                            <th>Village</th>
                            <th>number_of_hhs</th>
                            <th>water_source_type</th>
                            <th>nearest_type</th>
                            <th>nearest_market</th>
                            <th>market_days</th>
                            <th>directions</th>
                            <th>land_owner_name</th>
                            <th>land_owner_contact</th>
                            <th>nearest_boma</th>
                            <th>boma_contact</th>
                            <th>activities</th>
                            <th>activity_days</th>
                            <th>nearest_mama</th>
                            <th>mama_contact</th>
                            <th>neighbor_name</th>
                            <th>neighbor_contact</th>
                            <th>installation_date</th>
                            <th>notes</th>
                            <th>latitude</th>
                            <th>longitude</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-muted text-center"><small><em>Leave Empty</em></small></td>
                            <td class="text-muted text-center"><small><em>Country or Leave Empty</em></small></td>
                            <td class="text-muted text-center"><small><em>Program Name</em></small></td>
                            <td class="text-muted text-center"><small><em>Waterpoint Name</em></small></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"><small><em>Status (Pass or Fail)</em></small></td>
                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                            <?php
                                foreach ($cauList as $key => $value) {
                                echo '<td class="text-muted text-center"><small><em>('.$value['territory_name'].')</em></small></td>';
                                }
                            ?>
                       
                            <td class="text-muted text-center"><small><em>Village</em></small></td>
                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"><small><em>(dd-mm-yyyy)</em></small></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"></td>
                            <td class="text-muted text-center"></td>
                                                
                        </tr>                        
                    </tbody>

                </table>

            <?php } ?>

        </div>
        
    </div>

</div>
<style type="text/css">
    #data-table_wrapper .dataTables_scroll .dataTables_scrollBody {
        overflow-x: -moz-hidden-scrollable;
    }
</style>
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
            "scrollX": "100%"
            
        });
    });
</script>
