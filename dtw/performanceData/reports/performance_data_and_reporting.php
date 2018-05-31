<?php require_once('config/include.php');
	  $evidenceaction = new EvidenceAction();
	  $evidenceaction->checksession();
	  //print_r($_SESSION);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('config/head.php');?>
<title>Evidence Action :: Performance Data & Reporting</title>
</head>
<body>

<div class="wrapperNwp">
	<!---------------- header start ------------------------>
    
    <?php include('config/header.php');?>
    
    <!---------------- header end ------------------------>
    
    <!---------------- body start ------------------------>
    
    <div class="rstBdy performancedataandreporting">
	<h2>Performance Data & Reporting</h2>
      <ul>
	  	<li><a href="standardized_reports.php">Standardized Reports</a></li>
		<li><a href="performance_data.php">On demand reports</a></li>
		<li class="noBor">Export data</li>
	  </ul>
    </div>
    <!---------------- body end ------------------------>
</div>
</body>
</html>