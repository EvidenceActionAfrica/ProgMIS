<div class="col-md-12" style="margin-top:-2%;">
    <div id="data-table-manger">
        <!-- <div class="col-md-5 col-md-offset-3"><h3 ></h3></div> -->
        <h3 class="text-center"><?php echo $tableName; ?></h3>

          <div class="btn-group ">
            <div class="btn-group pad-top-15">
                <a href="<?php echo URL ?>processdata/promoter/ "><button class="btn"><- Go Back</button></a>
             </div> 
          
        </div>

        <div class="clearfix"></div>
        <hr>
    </div>

    <div class="table-responsive">
        <?php if (!empty($data)) { ?>

            <table id="data-table" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <?php
                        foreach ($data[0] as $key => $value) {
                            if($key=="id"){
                                continue;
                            }
                            echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                        }
                    
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($data as $key => $value) {

                        echo '<tr>';
                        foreach ($value as $key => $value) {
                            //echo $value."<br/>";
                              if($key=="id"){
                                continue;
                            }
                            if ($i == 1) {
                                $promoterId = $value;
                            }
                            echo '<td>' . $value . '</a></td>';
                            $i = 0;
                        }
                        $i = 1;
                        if ($table == 'promoter_details') {
                            ?>
                        <td><a href="<?php echo URL ?>processdata/promoter/update/<?php echo $table."/".$data[$i]['id']; ?>"><button class="btn btn-success">View Issues</button></a></td>
                          <?php
                    }
                    echo '</tr>';
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
            "scrollY": "500px",
            "scrollCollapse": true
        });
    });
</script>
