<h3>Standard Reports</h3>
<ul>
	<?php  $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  ?>
  <a href="national_reports.php"><li <?php if (strpos($url,'national_reports.php') !== false) { echo 'class="linkActive"';} ?> >National</li></a>
  <a href="county_reports.php"><li <?php if (strpos($url,'county_reports.php') !== false) { echo 'class="linkActive"';} ?> >County</li></a>
  <a href="district_reports.php"><li <?php if (strpos($url,'district_reports.php') !== false) { echo 'class="linkActive"';} ?> >Sub-County</li></a>
</ul>
<br/>
<h3>Reporting</h3>
<ul>
<a href="../dashboards/reporting.php"><li>KPIs</li></a>
<a href="../dashboards/dashboard_attnt.php"><li>Forms</li></a>

<br/>
<br/>

<!-- <a href="performance_data.php" target="_blank" ><h3>On Demand</h3></a> -->
<a href="http://41.242.2.82:6161" target="_blank" ><li style="margin-left: -15px"><h3>On Demand</h3></li></a>
<a href="javascript:void(0)"      target="_blank" ><li style="margin-left: -15px"><h3>Diagnostic</h3></li></a>

</ul>