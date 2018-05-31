<?php

require_once ("../includes/config.php");
require_once ("../includes/auth.php");
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");

require_once ("includes/include.php");
$evidenceaction = new EvidenceAction();

$level = $_SESSION['level'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
	<head>
		<title>Evidence Action</title>
		<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="css/style-n.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" href="../css/vstyle.css"/>
		<!-- Victor -->
		<!-- <link rel="stylesheet" type="text/css" href="css/vstyle.css"> -->
		<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/custom.js"></script>
		<script src="js/highcharts.js"></script>
	</head>
	<body>
		<!---------------- header start ------------------------>
		<div class="header">
			<div style="float: left">
				<img src="../images/logo.png" />
			</div>
			<div class="menuLinks">

				<nav>
					<ul>
						<li>
							<a href="../home.php">HOME</a>
						</li>
						<li>
							<a href="../schools.php">ADMIN DATA</a>
						</li>
						<li>
							<a href="../form_s.php">PROCESS DATA</a>
						</li>
						<li>
							<a href="../performanceData.php">PERFORMANCE DATA</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="clearFix"></div>
		<!---------------- content body ------------------------>
		<div class="contentMain">
			<div class="contentLeft">
				<?php
				require_once ("includes/menuLeftBar-PerformanceData.php");
				?>
			</div>
			<div class="contentBody">

				<!--================================================-->
			</div><!--end of content Main -->
		</div>
		<div class="clearFix"></div>
		<!---------------- Footer ------------------------>
		<!--<div class="footer">  </div>-->
	</body>
</html>
<!-------------------------------------- js codez -------------------------------->
