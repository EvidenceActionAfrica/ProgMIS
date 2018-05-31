
<div class="col-md-10">

    <?php if (isset($_GET['message'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php echo $_GET['message']; ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>

    <h3 class="text-center">Upload Installation Tracking Data</h3>


    <div class="col-md-4">
     <a href="<?php echo URL.'/expansion/dispenserInstallTrackAll/'.$program; ?>" class="btn btn-default" style='margin-bottom:10px;'> &lt;- Go Back</a>
    	<form action="<?php echo URL.'expansion/uploadInstallationTracking/tracking_installed_dispensers/'.$program ;?>" method="post" enctype="multipart/form-data">
    		<div class="form-group">
             <label for="' . $value['Field'] . '">Upload...</label><br>
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
                
                <form action="<?php echo URL;?>expansion/uploadInstallationTracking/tracking_installed_dispensers" method="post" enctype="multipart/form-data">
                    <input type='submit' style="margin-bottom:5%;" data-toggle="tooltip" data-placement="top" title="This Moves the waterpoints from this staging area to the waterpoint details."  name='confirmWaterpoints' value='Confirm Waterpoints' class='submitWater btn btn-success' />
                    <input type='submit' style="margin-bottom:5%;margin-left:5%;" data-toggle="tooltip" data-placement="top" title="This Clears All The Uploaded Data."  name='clearWaterpoints' value='Empty Upload Table' class='clearWater btn btn-danger' />
                </form>

            <?php } else { ?>

                <b>Instructions</b><br/>
                <b>1.</b> To Upload Arrange Data in this format:(Include the column name(s))<br/>

                <br/>

                <table class="table table-striped table-hover table-bordered" id="data-table">
                    <thead>
                        <tr>
                            <th><b>id</b></th>
                            <th>Program</th>
                            <th>waterpoint Id</th>
                            <th>verification Id</th>
                            <th>Installation Date</th>
                            <th>CSA Responsible</th>
                            <th>Field Officer</th>
                            <th>Was It Installed</th>
                            <th>Were Materials Mobilized</th>
                            <th>Problems With Installation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-muted text-center"><small><em>Leave Empty</em></small></td>
                            <td class="text-muted text-center"><small><em>(Optional)</em></small></td>
                            <td class="text-muted text-center"><small><em>Waterpoint Id</em></small></td>
                            <td class="text-muted text-center"><em>Verification Id</em></td>
                            <td class="text-muted text-center"><em><?php echo date('d-m-Y'); ?></em></td>
                            <td class="text-muted text-center"><small><em>CSA Responsible</em></small></td>
                            <td class="text-muted text-center"><small><em>Field Officer</em></small></td>
                            <td class="text-muted text-center"><small><em>YES/NO</em></small></td>
                            <td class="text-muted text-center"><small><em>YES/NO</em></small></td>
                            <td class="text-muted text-center"><small><em>YES/NO</em></small></td>
    
                                            
                        </tr>                        
                    </tbody>

                </table>

            <?php } ?>

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
            "scrollY": false,
            "scrollX": false
            
        });
    });
</script>
