<?php 
include "includes/class.ntd.pzq.php";
$ntdPZQ=new ntdPZQ;

	if (isset($_GET['set'])) {
		$ntdPZQ->runQuery();
	}
 ?>
 <form action="" method="get">

 	<input type="submit" name="set" value="press me">
 </form>

 <a href="test_ntd.php">REset</a>

<!--  <html>
 <head>
 	<title></title>
 	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
 	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
 </head>
 <body>
<ul class="nav nav-pills">
  <li class="active"><a href="#">Home</a></li>
  <li><a href="#">Profile</a></li>
  <li><a href="#">Messages</a></li>
</ul>
 </body>
 </html> -->