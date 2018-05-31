<div class="col-md-2 sidebar">

	<div class="geography">
	    <ul class="list-unstyled ">
	      <?php
	        foreach ($sidebarterritories as $key => $sidebarterritory) { ?>
	          <li><a href="<?php echo URL; ?>caumanager/index/<?php echo $sidebarterritory['id']; ?>"><?php echo ucwords( str_replace("_", " ", $sidebarterritory['territory_name'] ) ); ?> List</a></li>
	      <?php } ?>
	    </ul>
	</div>

</div>