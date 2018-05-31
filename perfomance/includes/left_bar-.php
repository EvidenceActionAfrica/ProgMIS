
<ul>
    <?php $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
    <li Style="margin-top: 8px" <?php if (strpos($url, 'view_adop') !== false) {
        echo 'class="active" ';
    } ?> ><a href="view_adop.php"> Adoption Rates</a></li>                
    <li Style="margin-top: 8px" <?php if (strpos($url, 'view_cem') !== false) {
        echo 'class="active" ';
    } ?> ><a href="view_cem.php">  CEM &amp; VCS Attendance</a></li>
    <li Style="margin-top: 8px" <?php if (strpos($url, 'view_chlo') !== false) {
        echo 'class="active" ';
    } ?> ><a href="view_chlo.php"> Chlorine Usage</a></li>
    <li Style="margin-top: 8px" <?php if (strpos($url, 'view_diar') !== false) {
        echo 'class="active" ';
    } ?> ><a href="view_diar.php"> Diarrhea Rates</a></li>
    <li Style="margin-top: 8px" <?php if (strpos($url, 'view_disp') !== false) {
        echo 'class="active" ';
    } ?> ><a href="view_disp.php"> Dispenser Functionality &amp; Empty Rates</a></li>
    <li Style = "margin-top: 8px" <?php if (strpos($url, 'installations') !== false) {
		echo 'class="active" ';
	} ?> ><a href ="installations.php">Installations</a></li>
    <li Style="margin-top: 8px" <?php if (strpos($url, 'view_mee') !== false) {
        echo 'class="active" ';
    } ?> ><a href="view_mee.php">  Operation's Meetings</a></li>
    <li Style="margin-top: 8px" <?php if (strpos($url, 'view_peop') !== false) {
        echo 'class="active" ';
    } ?> ><a href="view_peop.php"> People Served</a></li>
    <li Style="margin-top: 8px" <?php if (strpos($url, 'view_veri') !== false) {
        echo 'class="active" ';
    } ?> ><a href="view_veri.php"> Verification pass rate</a></li>        
    <li Style="margin-top: 8px" <?php if (strpos($url, 'waterpoints') !== false) {
        echo 'class="active" ';
    } ?> ><a href="waterpoints.php"> Waterpoints map</a></li>
    <?php 
    if ($priv > 3){?>
    <li Style="margin-top: 8px" <?php if (strpos($url, 'view_waterpoint') !== false) {
        echo 'class="active" ';
    } ?> ><a href="view_waterpoint.php"> Waterpoints table</a></li>
    <li Style="margin-top: 8px" <?php if (strpos($url, 'other_table') !== false) {
        echo 'class="active" ';
    } ?> ><a href="other_table.php"> Other tables</a></li>
    <?php } ?>
</ul>
