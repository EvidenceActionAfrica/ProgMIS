<div class="col-md-10">

    <div class="col-md-6">
        
        <div class="alert alert-warning" role="alert">
            
            <p>Are you sure you want to delete this <?php echo $meta['territory_name']; ?>? </p><br>

            <div class="btn-group">
                
                <a href="<?php echo URL; ?>caumanager/index/<?php echo $admin_territory_id; ?>" class="btn btn-xs btn-default">Cancel</a>
                <a href="<?php echo URL; ?>caumanager/delete/<?php echo $admin_territory_id; ?>/<?php echo $id; ?>/1" class="btn btn-xs btn-danger">Delete</a>

            </div>

        </div>

    </div>

</div>
