<h3>Standard Reports</h3>
<ul>
	<?php  $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  ?>
  <a href="national_reports.php"><li <?php if (strpos($url,'national_reports.php') !== false) { echo 'class="linkActive"';} ?> >National</li></a>
  <a href="county_reports.php"><li <?php if (strpos($url,'county_reports.php') !== false) { echo 'class="linkActive"';} ?> >County</li></a>
  <a href="district_reports.php"><li <?php if (strpos($url,'district_reports.php') !== false) { echo 'class="linkActive"';} ?> >Sub-County</li></a>
</ul>
<h3>Programme Results</h3>
<ul>
<a href="dewormingReport3.php"><li>National</li></a>
<a href="countyReport.php"><li>County</li></a>
</ul>
<h3>Reporting</h3>
<ul>
<a href="../dashboards/comprehensiveAll.php"><li>KPIs</li></a>
<a href="../dashboards/dashboard_attnt.php"><li>Forms</li></a>



<!-- <a href="performance_data.php" target="_blank" ><h3>On Demand</h3></a> -->
<a href="on_demande.php" target="_blank" ><li style="margin-left: -15px"><h3>On Demand</h3></li></a>
<a href="javascript:void(0)"      target="_blank" ><li style="margin-left: -15px"><h3>Diagnostic</h3></li></a>

</ul>