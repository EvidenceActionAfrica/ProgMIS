
<div class="col-md-10">

      <?php if (isset($message)) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php 
                echo $message;
            ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
      <?php } ?>
    <div id="data-table-manger">
    <h3>Tracking: <?php echo $tableName; ?></h3>
        <hr>
        <a href="<?php echo URL;?>/expansion/dispenserInstallTrack">Go Back</a>
    </div>

    <div class="table-responsive">
        <?php if (!empty($data)) { ?>

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
                               <td><a href="<?php echo URL ?>expansion/trackerDataUpdate/<?php echo $table; ?>/<?php echo  $data[$i]['id'].'/'.$data[$i]['program']; ?>"><button class="btn btn-success btn-xs">Edit</button></a></td> 
                                <td><a onclick="show_confirm('<?php echo $table; ?>', <?php echo $data[$i]['id'].',\''.$data[$i]['program'].'\''; ?>);"><button class="btn btn-danger btn-xs">Delete</button></a></td>    							
                          
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

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable({
            "scrollY": "100%",
            "scrollX": "100%",
            "scrollCollapse": false,
        });
    });
</script>


<script type="text/javascript">
    function show_confirm(tables, deleteId,program) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>expansion/trackerCemDelete/' + tables + '/' + deleteId +'/' +program);

        } else {
            console.log('<?php echo URL ?>expansion/trackerCemDelete/' + tables + '/' + deleteId + '/' +program);
            return false;
        }
    }
</script>