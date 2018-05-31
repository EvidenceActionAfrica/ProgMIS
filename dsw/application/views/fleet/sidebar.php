<style>
    *{
        padding:0%;
        margin:0%;
    }
</style>

<div class="col-md-2 sidebar">
    <ul>
        <li><h4><a href="<?php echo URL; ?>fleetclass/fleet">Fleet Inventory</a></h4></li>
        <ul>
            <?php
            foreach ($sidebarCategories as $key => $value) {

                echo '<li><a href="' . URL . 'fleetclass/fleet/fleet_list/' . $value["id"] . '">' . $value["type"] . '</a></li>';
         
                }
            ?>
        </ul>
        <li><a href="<?php echo URL; ?>fleetclass/fleet/log_record">Log Records</a></li>
        <li><a href="<?php echo URL; ?>fleetclass/fleet/fleet_maintenance">Maintenance<br/> Records</a></li>

    </ul>
    <ul>
        <li><h4 ><a data-toggle="collapse" data-parent="#accordion" href="#collapsereports"> Fleet Reports<span class="caret"></span></a></h4> </li>
        <ul id="collapsereports" class="panel-collapse collapse">
        <li><h5><a data-toggle="collapse" data-parent="#accordion" href="#collapseAggregate"> Aggregate Reports<span class="caret"></span</a></h5> </li>
        <ul id="collapseAggregate" class="panel-collapse collapse">
            <?php
            foreach ($sidebarCategories as $key => $value) {

                echo '<li><a href="' . URL . 'fleetclass/report/month/' . $value["id"].'/Aggregate' . '">' . $value["type"] . ' Monthly </a></li>';
                echo '<li><a href="' . URL . 'fleetclass/report/year/' . $value["id"] . '">' . $value["type"] . ' Yearly </a></li>';
          
            }
            ?>
        </ul>
        <li><h5><a data-toggle="collapse" data-parent="#accordion" href="#collapseCumilative"> Office <br/> Cumilative Reports<span class="caret"></span</a></h5></li>
        <ul id="collapseCumilative" class="panel-collapse collapse">
            <?php
            foreach ($sidebarCategories as $key => $value) {

                echo '<li><a href="' . URL . 'fleetclass/report/month/' . $value["id"] . '/Cumilative">' . $value["type"] . ' Monthly </a></li>';
                echo '<li><a href="' . URL . 'fleetclass/report/year/' . $value["id"] . '/Cumilative">' . $value["type"] . ' Yearly </a></li>';
    
             }
            ?>
        </ul>
        <li><h5><a data-toggle="collapse" data-parent="#accordion" href="#collapseother">Other Reports<span class="caret"></span</a></h5></li>
        <ul id="collapseother" class="panel-collapse collapse">
            <li><h5><a> Fuel Consumption Per Office Reports</a></h5></li>
        </ul>
        </ul>

    </ul>
    <ul>
        <h4>Settings</h4>

        <li><a href="<?php echo URL; ?>fleetclass/fleet/fleet_category">Fleet Category</a></li>


    </ul>
</div>
