<?php

require('../../includes/config.php');

?>

<!DOCTYPE html>
<html lang='en'>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
	Communication Tracker
	</title>

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
<section  id="title">
<header class="row">

<h2 class="text-center">Communication Tracker</h2>

</header>
</section>
<div class="col-md-8 col-md-offset-2">

<ul class="nav nav-tabs">
 		<li class="dropdown" id="issueMgmt"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Issue Management <span class="caret"></span>
			 <ul class="dropdown-menu">
				<li class="dropdown"><a href="issueDisplay.php">View Issues</a>	</li>
				<li class="dropdown"><a href="raiseIssue.php">Raise Issues</a></li>
				<li class="dropdown"><a href="resolveIssue.php">Resolve Issues</a></li>
			</ul>
		</li>
		<li class="dropdown" id="communicationMgmt"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Communication Management <span class="caret"></span>
			 <ul class="dropdown-menu">
				<li class="dropdown"><a href="communicationsDisplay.php">View Communications</a></li>
				<li class="dropdown"><a href="sendOut.php">Send Out Sms/Email</a></li>
			</ul>
		</li>
		
		
	
</ul>
</div>
</div>
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script src="../css/bootstrap/bootstrap.min.js"></script>



</body>
</html>
