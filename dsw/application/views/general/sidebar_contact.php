<div class="col-md-2 sidebar">
    <h3 class="">Contact List</h3>
    <ul>
        <li><a href="<?php echo URL;?>generalclass/general/staff_list">Staff List</a></li>
        <li><a href="<?php echo URL;?>generalclass/general/district_contacts">District Contacts</a></li>
        <li> <a href="<?php echo URL; ?>generalclass/general/village_details">Village List</a></li>
        <li><a href="<?php echo URL; ?>generalclass/general/county_health_workers_contacts">CHW Contacts</a></li>
        <li><a href="<?php echo URL; ?>generalclass/general/promoter_details">Promoter Contacts</a></li>
        <li><a href="<?php echo URL; ?>generalclass/general/assistant_promoter_details">Ass. Promoter Contacts</a></li>
   
        <h4><?php echo $tableName; ?></h4>
            <ul>
                <?php
             
                foreach ($sidebarCategories as $key=>$value){
                    
                    echo '<li><a href="'.URL.'generalclass/general/'.$table.'/'.$value["id"].'">'.$value[$criteria].'</a></li>';
                }
                
                ?>
            </ul>
        
        <ul>
        <h4>Settings</h4>
        
        <li><a href="<?php echo URL; ?>generalclass/general/contact_category">District Contacts Category</a></li>
        <li><a href="<?php echo URL; ?>generalclass/general/staff_category">Staff Category</a></li>
     
        <li><a href="<?php echo URL; ?>generalclass/general/issues_category">issues Category</a></li>

        
    </ul>

    </ul>
</div>
