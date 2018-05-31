<div class="col-md-10">

	<div class="col-md-5">

		<form action="<?php echo URL; ?>importclass/importcau" method="post" role="form" class="form" enctype="multipart/form-data">
			<div class="form-group">
				<label>Import Country Admin Units</label>
   				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $post_max_size; ?>" />
				<input type="file" name="import-cau-csv" class="form-control" required>
				<span class="help-block">File Size Should Not exceed <?php echo $post_max_size_M; ?></span>
			</div>
			<div class="form-group">
				<button type="submit" name="import-cau" class="btn btn-primary">Import</button>				
			</div>
		</form>

    </div>

</div>