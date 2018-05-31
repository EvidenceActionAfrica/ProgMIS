
<div class="col-md-10">

       <?php if (isset($_GET['message'])) { ?>
                <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
                    <?php 
                        echo $_GET['message'];
                    ?>
                    <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </div>
       <?php } ?>
 
    <h3 class="text-center">Upload <?php echo ucwords(str_replace('_', ' ', $tableName)); ?> </h3>

    <div class="col-md-4">
    	<?php
        if(isset($program)){
         ?>
    <a href="<?php echo URL.''.$returnClass.'/'.$control.'/'.$program; ?>" class="btn btn-default"> &lt - Go Back</a>
    
         <form action="<?php echo URL.'importclass/import/'.$table.'/'.$returnClass.'/'.$control.'/'.rawurlencode($program) ;?>" method="post" enctype="multipart/form-data">
        <?php   
        }else{

        ?>
        <a href="<?php echo URL.''.$returnClass.'/'.$control.'/'; ?>" class="btn btn-default"> &lt - Go Back</a>
    
        <form action="<?php echo URL.'importclass/import/'.$table.'/'.$returnClass.'/'.$control ;?>" method="post" enctype="multipart/form-data">
    	<?php } ?>	
            <div class="form-group">
             <label for="' . $value['Field'] . '">Upload...</label><br>
                <input type="file" name="file" id="file" />
            </div>
            <input type='submit' class="btn btn" name='upload-verification' value='Upload'/>
    	</form>
    </div>

    <div class="col-md-12">

      <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="40px" style="position:absolute;top:50%;left:50%;margin:0 auto; visibility: visible"/>

                <p><b>No Details Uploaded So Far..</b><br/><br/>
                <b>Instructions</b><br/>
                <b>1.</b> To Upload Arrange Data in this format:(Include the column name(s))<br/>

                <br/>

    	<div class="table-responsive">

            <?php if (!empty($fieldsArray)) { ?>

                <table class="table table-striped table-hover table-bordered" id="data-table">
                    <thead>
                        <tr>
                            <?php
                            foreach ($fieldsArray as $key => $value) {

                               echo '<th class="text-center">' . ucwords(str_replace('_', ' ', $value)) . '</th>';
                                    
                            }
                            ?>
                   
                        </tr>
                    </thead>
                    <tbody>
                         <tr>
                        <?php
                            
                        foreach ($fieldsArray as $key => $value) {
                            ?>
                           
                                <?php
                                if(strpos($value,"date") !==false){
                                 echo '<td class="text-muted text-center"><em>(dd--mm-YYYY)</em></td>';
                                }else if(strpos($value,"status") !==false && $table=="verification_track"){
                                 echo '<td class="text-muted text-center"><em>PASS/FAIL</em></td>';
                                }else if(strpos($value,"status") !==false && $table!="verification_track" && $table!="vcs_meetings_tracker"){
                                 echo '<td class="text-muted text-center"><em>YES/NO</em></td>';
                                }else if($value=="id"){
                                 echo '<td class="text-muted text-center"><em>LEAVE BLANK</em></td>';
                                }else{
                                  echo '<td class="text-muted text-center"><em>' .ucfirst(str_replace('_',' ',$value)) . '</em></td>';
                                    
                                }

                                        
                                 
                                ?>
                            
                       
                            <?php
                          
                        }
                        ?>	
                             </tr>				
                    </tbody>
                </table>
                
           
            <?php }  ?>

     
        </div>
        
    </div>

</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable({
            "scrollY": false,
            "scrollX": true
            
        });
    });
</script>
