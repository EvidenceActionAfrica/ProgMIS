<div class="col-md-2 sidebar">
<!-- 	<h4 class="">Inventory</h4>
		<ul> -->

			<h4>Chlorine Inventory</h4>
	        <ul>
	            <?php
	            foreach ($sidebarCategories as $key => $value) {

	                echo '<li><a href="' . URL . 'chlorineclass/chlorine/chlorine_inventory/' . $value["id"] . '">' . $value["inventory_type"] . '</a></li>';
	         
	                }
	            ?>

	        </ul>
              <h4><ul><li><a href="<?php echo URL;?>chlorineclass/chlorine/dispenser_spare_parts">Dispenser Spare Parts</a></li></ul></h4>
	      <h4><ul><li><a href="<?php echo URL;?>assetData/asset">Other Inventory</a></li></ul></h4>
	      <!--   <ul>
	        	<li><a href="<?php echo URL;?>assetData/asset">Other Inventory</a></li>
	        </ul>
 -->

			<!-- <li><a href="<?php echo URL;?>chlorine/inventory/chlorine">Chlorine</a></li>
			<li><a href="<?php echo URL;?>chlorine/inventory/items">Other Items</a></li> -->
		<!-- </ul> -->
</div>
