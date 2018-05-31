<div class="col-md-10">
    <div id="data-table-manger">
        <?php if (isset($message)) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php 
                echo $message;
            ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
      <?php } ?>
        <div class="clearfix">
            <h3 class="pull-left"><?php echo $tableName; ?></h3>

            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">                    
                        <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add <?php echo $tableName; ?></button>                   
                    
                </div>
            </div>
        </div>
        <hr>
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
                                } else {
                                    echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                        }
                        ?>                       
                            <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($data as $key => $value) {
                        ?>
                        <tr>
                            <?php
                            foreach ($value as $key => $value) {
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
                                        echo '<td style="text-align:center">' . $value . '</td>';
                                    }
                                }
                            }
                            ?>
                                <td><a onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>);"><button class="btn btn-default btn-xs">Delete</button></a></td>    							
                          
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
  <?php if (!empty($data)) { ?>
    $(document).ready(function() {

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
                        mColumns: [0,1]
                    },
                    {
                        sExtends: "xls",
                        sButtonText: "Export Filtered",
                        oSelectorOpts: { filter: 'applied', order: 'current' },
                        mColumns: [0,1]
                    }
                ]
            }
        } );       
        
    });
<?php }?>
</script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo "Add " . $tableName . ""; ?></h4>
            </div>
            <form  action="<?php echo URL; ?>issuetracker/messageAdd/<?php echo $table.'/'; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                         
                            foreach ($fields as $key => $value) {
                                if ($value['Key'] == 'PRI') {
                                    echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                }else if($value['Field'] == 'message') {
                                        echo '
                                                <div class="form-group">
                                                   <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br/>
                                                     <textarea id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" ></textarea>
                                                </div>
                                            ';
                                 } else {
                                    echo '
					 <div class="form-group">
					 	<label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
								<input id="' . $value['Field'] . '" type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
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
                    <button  type="submit" class="btn btn-primary" name="add_issue" id="add-expansion-data">Save</button>
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

    function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>issuetracker/messageDelet/' + tables + '/' + deleteId);

        } else {
            console.log('<?php echo URL ?>issuetracker/messageDelet/' + tables + '/' + deleteId);
            return false;
        }
    }



</script>