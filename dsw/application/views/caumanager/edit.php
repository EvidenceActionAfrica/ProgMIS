<div class="col-md-10">

    <div class="col-md-4">
        <form action="<?php echo URL; ?>caumanager/edit/<?php echo $admin_territory_id; ?>/<?php echo $id; ?>" method="post" role="form" >
            <div class="form-group">
                <input type="hidden" name="name_territory" value="<?php echo ucwords( str_replace("_", " ", $meta['territory_name'] ) ); ?>">
                <?php if(isset($meta['parent_territory_name'])) { ?>
                    <label><?php echo ucwords( $meta['parent_territory_name'] ) ?></label>
                    <select name="territory_parent" required class="form-control">
                        <?php foreach ($parents as $key => $parent) { ?>
                            <option value="<?php echo $parent['id']; ?>" <?php if (!empty($data)) { if ( $data[0]['parent_admin_territory_name'] == $parent['admin_territory_name'] ) { echo 'selected'; } } ?> > <?php echo $parent['admin_territory_name']; ?></option>
                        <?php } ?>
                    </select>
                <?php } else { ?>
                    <input type="hidden" name="territory_parent" value="0">
                <?php } ?>
            </div>
            <div class="form-group">
                <label><?php echo ucwords( $meta['territory_name'] ) ?></label>
                <input type="text" name="admin_territory_name" value="<?php echo $data[0]['admin_territory_name']; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <div class="btn-group">
                    <a  href="<?php echo URL; ?>caumanager/index/<?php echo $admin_territory_id; ?>" class="btn btn-default">Cancel</a>
                    <button type="submit" name="edit_admin_territorry" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>

</div>
