<?php
$email = $_SESSION['email'];
$level = $_SESSION['level'];
$staffid = $_SESSION['staffid'];
?>
<h3>Standard Reports</h3>
<ul>
  <a href="reports/national_reports.php">
    <li> National </li></a>
  <a href="reports/standardized_reports_districts.php">
    <li> Districts </li></a>
  <a href="../comprehensiveCiffReport.php">
    <li>KPI Reports </li></a>
</ul>
<br/>
<h3>On Demand Reports</h3>
<ul> <a href="#"> <li> Generate report </li></a>  </ul>
<br/>
<h3>Export</h3>
<ul> <a href="#">  <li>  Make export   </li></a>
</ul>