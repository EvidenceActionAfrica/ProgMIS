<div class="col-md-2 sidebar">
    <h3 class="">Geographical Data</h3>
    <ul>
        <li><a href="<?php echo URL; ?>generalclass/general/country_admin_units">C.A.U</a></li>
        <li> <a href="<?php echo URL; ?>generalclass/general/village_details">Village List</a></li>
  
        <li><a href="<?php echo URL; ?>fleetclass/fleet/fleet_list">Fleet List</a></li>
       <li><a href=<?php echo URL;?>generalclass/general/waterpoint_details_<?php echo strtolower($_SESSION['countryName']); ?>>Water Point Details</a></li>
      <!---  <li><a href="<?php echo URL; ?>generalclass/general/waterpoints">Dispenser</a></li>
      -->
    </ul>
    <ul>
        <h4>Contact List</h4>
        <li><a href="<?php echo URL; ?>generalclass/general/staff_list">Staff List</a></li>
        <li><a href="<?php echo URL; ?>generalclass/general/district_contacts">District Contacts</a></li>

        <li><a href="<?php echo URL; ?>generalclass/general/county_health_workers_contacts">CHW Contacts</a></li>
        <li><a href="<?php echo URL; ?>generalclass/general/promoter_details">Promoter Contacts</a></li>
        <li><a href="<?php echo URL; ?>generalclass/general/assistant_promoter_details">Ass. Promoter Contacts</a></li>
   
    </ul>
    
    <ul>
        <h4>Settings</h4>
        
        <li><a href="<?php echo URL; ?>generalclass/general/contact_category">District Contacts Category</a></li>
        <li><a href="<?php echo URL; ?>generalclass/general/staff_category">Staff Category</a></li>
      
        <li><a href="<?php echo URL; ?>generalclass/general/issues_category">issues Category</a></li>

        
    </ul>
</div>
