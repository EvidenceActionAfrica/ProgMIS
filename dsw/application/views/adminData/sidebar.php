<div class="col-md-2 sidebar clearfix" >

  <div class="geography">
      <ul>
        <li><a data-toggle="collapse" data-parent="#accordion" href="#collapsecau">Program Geography<span class="caret"></span></a> </li>
        <ul id="collapsecau" class="panel-collapse collapse">
          <?php
            foreach ($sidebarterritories as $key => $sidebarterritory) { ?>
              <li><a href="<?php echo URL; ?>caumanager/index/<?php echo $sidebarterritory['id']; ?>"><?php echo ucwords( str_replace("_", " ", $sidebarterritory['territory_name'] ) ); ?> List</a></li>
          <?php } ?>
        </ul>
      </ul>
  </div>
    <ul>
   
  <!--<li><a href="<?php echo URL.'generalclass/cauPrograms/'; ?>">Programs</a></li>--> 
  
  </ul>
  <div class="contactList">
    <ul>
        <li><a data-toggle="collapse" data-parent="#accordion" href="#collapsecontactList">Contact List<span class="caret"></span></a></li>
        <ul id="collapsecontactList" class="panel-collapse collapse">          
          <li><a data-toggle="collapse" data-parent="#accordion" href="#collapsestaffList">Staff Contacts<span class="caret"></a></li>
          <ul id="collapsestaffList" class="panel-collapse collapse">
            <?php foreach ($staffCategories as $key=>$value){
                if($value["id"]==4 || $value["id"]==9) {
                  echo '<li><a href="'.URL.'generalclass/general/staff_list/'.$value["id"].'">'.$value["position"].'</a></li>';
                } else {
                    continue;
                }                      
            } ?>
          </ul>          
          <li><a href="<?php echo URL.'generalclass/Officials/officials_contacts'; ?>">Officials Contacts</a></li>            
          <li><a href="<?php echo URL; ?>generalclass/villageContacts/village_details">Village Contacts</a></li>
          <li><a href="<?php echo URL; ?>generalclass/promoter/promoter_details">Promoter Contacts</a></li>
        </ul>
    </ul>
  </div>
     
  <div class="waterpoints">
    <ul>
      <li><a href="<?php echo URL; ?>generalclass/general/waterpoint_details">Waterpoints</a></li>
    </ul>
  </div>
     
  <!-- <div class="inventory"> -->
    <!-- <ul> -->
      <!-- <li><span style='font-size:1.2em;font-weight:bold;'><a data-toggle="collapse" data-parent="#accordion" href="#collapseinventory">Inventory<span class="caret"></span></a></span> </li> -->
      <!-- <ul id="collapseinventory" class="panel-collapse collapse"> -->
        <ul>
          <li><a data-toggle="collapse" data-parent="#accordion" href="#collapseAsset">Asset List<span class="caret"></span></a></li>           
            <ul id="collapseAsset" class="panel-collapse collapse">
              <li><a href="<?php echo URL;?>assetData/asset/3">Batteries</a></li>
              <li><a href="<?php echo URL;?>assetData/asset/2">Computers</a></li>
              <li><a href="<?php echo URL;?>assetData/asset/5">Equipment</a></li>
              <li><a href="<?php echo URL;?>assetData/asset/7">Furniture</a></li>
              <li><a href="<?php echo URL;?>assetData/asset/1">Phones</a></li>
              <li><a href="<?php echo URL;?>assetData/asset/4">Vehicles</a></li>
                </ul>
        </ul>

        <ul>
          <li><a data-toggle="collapse" data-parent="#accordion" href="#collapsefleet">Fleet Inventory<span class="caret"></span></a></li>
            <ul id="collapsefleet" class="panel-collapse collapse">           
              <?php foreach ($fleetCategories as $key => $value) {
                echo '<li><a href="' . URL . 'fleetclass/fleet/fleet_list/' . $value["id"] . '">' . $value["type"] . '</a></li>';           
              } ?>
            </ul>
        </ul>

        <ul>
          <li><a href="<?php echo URL; ?>fleetclass/fleetcombined/fleet_log_view/1">Fleet Records</a> </li>
        </ul>

        <ul>
        <li><a data-toggle="collapse" data-parent="#accordion" href="#collapsereports">Fleet Reports<span class="caret"></span></a> </li>
        <ul id="collapsereports" class="panel-collapse collapse">
            <li><a data-toggle="collapse" data-parent="#accordion" href="#collapseAggregate"> Aggregate Reports<span class="caret"></span></a></li>
            <ul id="collapseAggregate" class="panel-collapse collapse">
                <li><a href="<?php echo URL; ?>fleetclass/reports/Vehicle">Motor Vehicle</a></li>
                <li><a href="<?php echo URL; ?>fleetclass/reports/Cycle">Motor Cycle</a></li>

            </ul>

            <li><a href="<?php echo URL; ?>fleetclass/reports/Cumilative"> Office Cumilative Reports</a></li>
        
        </ul>
         <!--
          <ul id="collapsereports" class="panel-collapse collapse">
            <li><a data-toggle="collapse" data-parent="#accordion" href="#collapseAggregate"> Aggregate Reports<span class="caret"></span></a></li>
            <ul id="collapseAggregate" class="panel-collapse collapse">
              <?php foreach ($fleetCategories as $key => $value) {
                 // echo '<li><a href="' . URL . 'fleetclass/report/month/' . $value["id"].'/Aggregate' . '">' . $value["type"] . ' Monthly </a></li>';
               //   echo '<li><a href="' . URL . 'fleetclass/report/year/' . $value["id"] . '">' . $value["type"] . ' Yearly </a></li>';        
              } ?>
            </ul>
           
            <li><a data-toggle="collapse" data-parent="#accordion" href="#collapseCumilative"> Office <br/> Cumilative Reports<span class="caret"></span></a></li>
            <ul id="collapseCumilative" class="panel-collapse collapse">
              <?php foreach ($fleetCategories as $key => $value) {
                  echo '<li><a href="' . URL . 'fleetclass/report/month/' . $value["id"] . '/Cumilative">' . $value["type"] . ' Monthly </a></li>';
                  echo '<li><a href="' . URL . 'fleetclass/report/year/' . $value["id"] . '/Cumilative">' . $value["type"] . ' Yearly </a></li>';      
               } ?>
            </ul>
            <li><a data-toggle="collapse" data-parent="#accordion" href="#collapseother">Other Reports<span class="caret"></span></a></li>
            <ul id="collapseother" class="panel-collapse collapse">
                <li><a> Fuel Consumption Per Office Reports</a></li>
            </ul>
          </ul> 
          -->    
        </ul>
       
        <ul>     
          <li><a href="<?php echo URL; ?>chlorineclass/chlorine">Chlorine</a></li>
        </ul>
        <ul>
          <li><a href="<?php echo URL; ?>chlorineclass/chlorine/dispenser_spare_parts">Dispenser Parts</a></li>
        </ul>
      <!-- </ul> -->
    <!-- </ul> -->
  <!-- </div>    -->
   
  <div class="settings"> 
    <ul>
        <li><span style='font-size:1.2em;font-weight:bold;'><a data-toggle="collapse" data-parent="#accordion" href="#collapseSettings">Settings<span class="caret"></span></a></span></li>
        <ul id="collapseSettings" class="panel-collapse collapse">
          <li><a href="<?php echo URL; ?>generalclass/general/contact_category">Contacts Category</a></li>
          
          <li><a href="<?php echo URL; ?>generalclass/adminModuleManager/">Admin Module Manager</a></li>
          <li><a href="<?php echo URL; ?>generalclass/FieldOffice/">Field Office Manager</a></li>
         <!--
           <li><a href="<?php echo URL; ?>generalclass/FieldOffice/">Inventory Manager</a></li>
          -->
          <li><a href="<?php echo URL; ?>generalclass/general/staff_category">Staff Category</a></li>
          <li><a href="<?php echo URL; ?>generalclass/general/fleet_category">Fleet Category</a></li>
          <li><a href="<?php echo URL; ?>generalclass/general/issues_category">Issue Category & Codes</a></li>

        </ul>        
    </ul>
  </div>

</div>
