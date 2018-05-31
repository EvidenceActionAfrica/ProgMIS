
<div class="col-md-10">
	<div class="clearfix">
		<h3 class="pull-left"><?php echo $tableName; ?></h3>
		<div class="btn-group pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal2">New <?php echo $table; ?> Inventory</button>
			</div>
			<div class="btn-group">
				<a href="<?php echo URL?>chlorine/export/chlorine_inventory">
					<button type="button" class="btn btn-default">Export CSV</button>
				</a>
			</div>
		</div>
	</div>
	<hr>

	<div class="table-responsive">
		<?php  if (!empty($data)) { 

			?>

			<table id="data-table" class="table table-striped table-hover">
				<thead>
					<tr>
						<?php
							foreach ($data[0] as $key => $value) { 
								if ( !in_array($key, $arrayName = array('id') ) ) {
									echo '<th>'.ucwords(str_replace('_',' ',$key) ).'</th>';
								}
							}

						?>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$J=0;
						foreach ($data as $key => $value) { 
							echo '<tr>';
							foreach ($value as $key => $value_) {
								if ( !in_array($key, $arrayName = array('id') ) ) {
									echo '<td>'.$value_.'</td>';
								}
							}
							?>
								<td><a href="<?php echo URL?>chlorine/update/<?php echo $table."/".$data[$J]['id'] ?>" ><button class="btn btn-default">Edit</button></a></td>
								<td><a onclick="show_confirm(<?php echo '$table'.",".$data[$J]['id'] ?>);"><button class="btn btn-danger">Delete</button></a></td>
							<?php
							echo '</tr>';
							$J++;
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
          "scrollY": "300px",
          "scrollX": "100%",
          "scrollCollapse": true
  	});
  });
</script>

<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Add <?php echo $table; ?> Inventory</h4>
			</div>
			<form action="<?php echo URL; ?>chlorine/add" data-async data-target="myModal" method="post" role="form" id="modal-form">
			
				<div class="modal-body">
					<div id="message"></div>
					<div class="row">
				        <div class="col-md-12">
					      	<?php
					      	$x=0;
					      		foreach ($fields as $key => $value) {
									if ( $value['Key'] == 'PRI' ) {
										echo '<input type="hidden" value="" name="'.$value['Field'].'"/>';
									} else if ( $value['Key'] == 'MUL') {

										if ( $value['Field'] == 'country' ) {
											$disabled = '';
											// $disabled = 'disabled';
											// $disabled = 'style="display:none"';
										} else {
											$disabled = '';
										}

								         echo '
								         	<div class="form-group">
								            	<label '.$disabled.'>'.ucwords( str_replace('_',' ',$value['Field']) ).'</label><br>
												<select name="'.$value['Field'].'" class="form-control input-sm" required '.$disabled.'><option value="">Select '.ucwords( str_replace('_',' ',$value['Field']) ).'</option>';
													foreach ($value['parents'] as $key => $value_) {
															echo'<option value="'.$value_['id'].'" >'.$value_[$value['Field']].'</option>';
													}
												echo '</select>
											</div>';
									} else {
										echo '
								            <div class="form-group">
								            	<label>'.ucwords( str_replace('_',' ',$value['Field']) ).'</label><br>
												<input type="text" name="'.$value['Field'].'" value="" class="form-control input-sm"/>
											</div>
										';
									}
									$x++;
								}
							?>	
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary" name="add-chlorine-inventory" id="add-admin-data">Save</button>
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


	// shows a delete confrim message
	function show_confirm(table,deleteId) {

		if (confirm("Are you sure you want to delete?")) {
			location.replace('<?php echo URL?>chlorine/delete/' + table+'/'+deleteId);
		          
		} else {
			console.log('<?php echo URL?>chlorine/delete/' + table+'/'+deleteId);
		 return false;
		}
	}

</script>

