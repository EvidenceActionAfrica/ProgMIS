<?php $filename = basename($_SERVER['PHP_SELF']);?>
<div class="header">
      <div class="hdmnCnt">
	  <?php if(isset($_SESSION['admin_name']) && !empty($_SESSION['admin_name'])){$purl = 'dashboard.php';}else{$purl = 'index.php';}?>
    	<div class="logo"><a href="<?php echo $purl;?>"><img src="images/logo.jpg" alt="Evidence Action" border="0" /></a></div>
		<?php if(isset($_SESSION['admin_name']) && !empty($_SESSION['admin_name'])){?>
		<div class="hdrMnun">
			<ul class="mainmenu">
            <li><a href="<?php echo $purl;?>"  <?php if($filename=='dashboard.php'){?> class="active" <?php }?>>HOME</a></li>
        	<li><a href="administrative_data.php" <?php if($filename=='administrative_data.php'){?> class="active" <?php }?>>ADMINISTRATIVE DATA</a></li>
            <li><a href="javascript:void(0)">PROCESS DATA</a></li>
            <li><a href="performance_data_and_reporting.php" <?php if($filename=='performance_data_and_reporting.php'){?> class="active" <?php }?>>PERFORMANCE DATA</a>
			<ul class="submenu">
			  	<li><a href="standardized_reports.php">Standardized Reports</a></li>
				<li><a href="performance_data.php">On demand reports</a></li>
				<li class="noBor"><a href="#">Export data</a></li>
	  		</ul>
	  </li>
	  </ul>
        </div>
        <div class="usrNmSec"><?php echo $_SESSION['admin_name'];?> | <a href="logout.php">Logout</a></div>
		<div class="log"></div>
		<?php }?>
        <div class="clearFix"></div>
      </div>
    </div>