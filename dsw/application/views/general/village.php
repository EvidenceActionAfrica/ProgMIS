<div class="col-md-10">
<?php if (isset($_GET['message'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php echo $_GET['message']; ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>
	<div class="clearfix">
		<h3 class="pull-left"><?php echo $tableName;?></h3>
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" style='margin-right:10px;' class="btn btn-default pink-button" data-toggle="modal" data-target="#myImportModal">Import Details</button>
				<!-- <a href="<?php echo URL?>assetData/export/<?php echo $inventory_type_id ?>" class="btn btn-default">Export CSV</a> -->
				<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal2">New Village</button>
			</div>
		</div>
	</div>
	<hr>

	<div class="table-responsive">
		<?php  if (!empty($data)) {
			?>

			<table id="data-table" class="table table-bordered table-striped table-hover">
				<thead>
                    <tr>
                        <th class="index" >#</th>
                        <?php
                            foreach ($data[0] as $key => $value) {
                                if ($key == 'position' && $table != "staff_category" || $key == "village_name") {
                                    continue;
                                }
                                if (!in_array($key, $arrayName = array('id'))) {                                    
                                    if ($key == "country" || $key == "Country") {
                                        continue;
                                    } else {
                                        if ($_SESSION['country'] == 1 ) {
                                            if ($key == 'chw_name') {                        
                                                echo '<th class="export-visible">CHW Name</th>';
                                            } else if ($key == 'chw_contact') {                        
                                                echo '<th class="export-visible">CHW Contact</th>';
                                            } else {
                                                echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        } else if ($_SESSION['country'] == 2 ) {
                                            if ($key == 'chw_name') {                        
                                                echo '<th class="export-visible">VHT Name</th>';
                                            } else if ($key == 'chw_contact') {                        
                                                echo '<th class="export-visible">VHT Contact</th>';
                                            } else {
                                                echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        } else if ($_SESSION['country'] == 3 ) {
                                            if ($key == 'chw_name') {                        
                                                echo '<th class="export-visible">HSA Name</th>';
                                            } else if ($key == 'chw_contact') {                        
                                                echo '<th class="export-visible">HSA Contact</th>';
                                            } else {
                                                echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        }
                                    }
                                }
                            }
                        ?>                        
                        <th class="buttons"></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="index">#</th>
                        <?php
                            foreach ($data[0] as $key => $value) {
                                if ($key == 'position' && $table != "staff_category" || $key == "village_name") {
                                    continue;
                                }
                                if (!in_array($key, $arrayName = array('id'))) {                                    
                                    if ($key == "country" || $key == "Country") {
                                        continue;
                                    } else {
                                        if ($_SESSION['country'] == 1 ) {
                                            if ($key == 'chw_name') {                        
                                                echo '<th class="export-visible">CHW Name</th>';
                                            } else if ($key == 'chw_contact') {                        
                                                echo '<th class="export-visible">CHW Contact</th>';
                                            } else {
                                                echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        } else if ($_SESSION['country'] == 2 ) {
                                            if ($key == 'chw_name') {                        
                                                echo '<th class="export-visible">VHT Name</th>';
                                            } else if ($key == 'chw_contact') {                        
                                                echo '<th class="export-visible">VHT Contact</th>';
                                            } else {
                                                echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        } else if ($_SESSION['country'] == 3 ) {
                                            if ($key == 'chw_name') {                        
                                                echo '<th class="export-visible">HSA Name</th>';
                                            } else if ($key == 'chw_contact') {                        
                                                echo '<th class="export-visible">HSA Contact</th>';
                                            } else {
                                                echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        }
                                    }
                                }
                            }
                        ?>                        
                        <th class="buttons"></th>
                    </tr>
                </tfoot>

                <tbody>

                    <?php
                        $i = 0;
                        foreach ($data as $key => $value) { ?>
                            <tr>
                                <td class="index"></td>                            
                                <?php
                                    foreach ($value as $key => $value) {   
                                        if ($key == 'position' && $table != "staff_category") {
                                            continue;
                                        }
                                        if ($i == 1) {
                                            $generalId = $value;
                                        }
                                        if (!in_array($key, $arrayName = array('id'))) {

                                            if ($key == "country" || $key == "Country" || $key == "village_name") {
                                                continue;
                                            } else {
                                             echo '<td class="export-visible">'.ucfirst($value).'</td>';
                                            }
                                        }
                                    }
                                ?>                               
                                <td class="buttons">
                                    <a href="<?php echo URL ?>generalclass/updateVillage/<?php echo $table . "/" . $data[$i]['id']; ?>"  class="btn btn-default btn-xs">Edit</a>
                                    <a onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>);"  class="btn btn-default btn-xs">Delete</a>
                                </td> 
                                <!-- <td><a href="<?php echo URL ?>generalclass/delete/<?php echo $table . "/" . $data[$i]['id']; ?>" class="btn btn-default">Delete</a></td> -->
                                <!-- <td><a href="<?php echo URL ?>generalclass/delete/<?php echo $table . "/" . $data[$i]['id']; ?>" class="btn btn-default">Delete</a></td> -->					
                              
                            </tr>
                        <?php $i++; }
                    ?>					
                </tbody>
			</table>

		<?php } else { ?>

			<p><b>No Record Found</b></p>

		<?php } ?>
  <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="40px" style="position:absolute;top:50%;left:50%;margin:0 auto; visibility: visible"/>

	</div>

</div>
<script type="text/javascript">
<?php
    if($data !=null){
?>
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
            scrollY: "500px",
            scrollX: "300px",            
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
                        oSelectorOpts: {
                            page: 'current'
                        },
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
<?php
}
?>
</script>


<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Add <?php echo $tableName; ?> </h4>
			</div>
	
						<form action="<?php echo URL; ?>generalclass/add/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
		
			
				<div class="modal-body">
					<div id="message"></div>
					<div class="row">
				             <div class="col-md-12">
                            <?php
                                foreach ($fields as $key => $value) {
                                    if ($value['Key'] == 'PRI') {

                                        echo '<input type="hidden" value="" name="' . $value['Field'] . '"/>';
                                    } else if ($value['Field']=='country') {

                                        echo '<input type="hidden" name="'.$value['Field'].'" value="'.$_SESSION['country'].'" readonly/>';
                                    } else if ($value['Key'] == 'MUL' && $value['Field'] != 'country' && $value['Field'] != 'waterpoint_id') {
                                        echo '<div class="form-group">
                                                <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                    <option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                    foreach ($value['parents'] as $key => $value_) {
                                                        echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                    }
                                                echo '</select>
                                            </div>';
                                    }else if (strpos($value['Field'], 'village_name') !== false) {
                                     
                                       $i=0;
                                        foreach ($cauList as $key => $value) {   
                                               echo '
                                                <div class="form-group">
                                                    <label>' . ucwords(str_replace('_', ' ', $value['territory_name'])) . '</label><br>
                                                <select  name="' . $value['territory_name'] . '" id="'.$value['territory_name'].'ajax" class="form-control input-sm ' . $value['territory_name'].'ajax" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['territory_name'])) . '</option>'; 
                                                  foreach ($ListedCaus[$value['territory_name']] as $key => $value_) {
                                                    
                                                    echo'<option  value="' . $value_['id'] . '" >' . $value_['territory_name'] . '</option>';  
                                                        
                                                    }
                                                    echo '</select>
                                                                </div>';
                                        ++$i;
                                        }


                                } else if ($value['Field'] == 'waterpoint_id' ) {
                                        echo'   <div class="form-group">
                                                    <label>Waterpoint</label><br>
                                                    <select name="' . $value['Field'] . '" class="form-control input-sm" required>
                                                        <option value="">Select Waterpoint</option>';
                                                        foreach ($waterpoints as $key => $waterpoint) {
                                                            echo'<option value="' . $waterpoint['id'] . '" >' . $waterpoint['waterpoint_name'] . '</option>';
                                                        }                                                        
                                        echo'       </select>
                                                </div>';                                      
                                    } else if ($value['Field'] == 'email') {
                                        echo '
								            <div class="form-group">
								            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="email" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
											</div>
                                            ';
                                    } else if (strpos($value['Field'], 'contact') !== false  && strpos($value['Field'], 'chw') === false) {
                                        echo'<div class="form-group">
								            	<label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
										      </div>
                                			';
                                    } else if (strpos($value['Field'], 'date') !== false ) {
                                        echo '
								            <div class="form-group">
								            	<label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
												<input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
											</div>
										';
                                    } else if ($value['Field'] == 'chw_name') {

                                        if ($_SESSION['country']==1) {
                                            $label = 'CHW Name';
                                        } else if ($_SESSION['country']==2) {
                                            $label = 'VHT Name';
                                        } else if ($_SESSION['country']==3) {
                                            $label = 'HSA Name';
                                        }

                                        echo '
                                            <div class="form-group">
                                                    <label>' . $label . '</label><br>
                                                    <input type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                </div>
                                            ';
                                    } else if ($value['Field'] =='chw_contact') {

                                        if ($_SESSION['country']==1) {
                                            $label = 'CHW Contact';
                                        } else if ($_SESSION['country']==2) {
                                            $label = 'VHT Contact';
                                        } else if ($_SESSION['country']==3) {
                                            $label = 'HSA Contact';
                                        }
                                        echo '
                                                <div class="form-group">
                                                    <label>' . $label . '</label><br>
                                                    <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
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
					<button type="submit" class="btn btn-primary" name="add-village-data" id="add-village-data">Save</button>
				</div>
	        </form>
	    </div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myImportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Import  Details</h4>
            </div>
            <form  action="<?php echo URL; ?>importclass/importVillages/<?php echo $table.'/generalclass/general'; ?>" enctype="multipart/form-data" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            Select File to upload:
                            <input type="file" name="file" id="file" />
                            </div>
                            <div class="form-group">
                            <input type="submit" value="Upload" name="update-verification"/>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-general-data" id="add-general-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>  

<script type="text/javascript">
	
	// arranges the modal into columns
	$('#myModal2').on('show.bs.modal', function (e) {

		autoColumn(3, '#myModal2 .modal-body .row', 'div', 'col-md-4');
		$('#message').html('');

	});


    function show_confirm(tables, deleteId) {
        if (confirm("Are you sure you want to delete?")) {
            location.replace('<?php echo URL ?>generalclass/deleteVillage/' + tables + '/' + deleteId);
            console.log('<?php echo URL ?>generalclass/deleteVillage/' + tables + '/' + deleteId);
         } else {
            console.log('<?php echo URL ?>generalclass/deleteVillage/' + tables + '/' + deleteId);
            return false;
        }
    }

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
?>

</script>