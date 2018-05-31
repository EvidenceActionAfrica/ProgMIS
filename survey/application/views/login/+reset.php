<?php
	require 'application/views/_templates/plain_header.php';
	require 'application/views/_templates/footer.php';
?>
<html>
	<div class="col-md-4 col-md-offset-4">
		<h2 style="text-align: center">Reset Password</h2>
		<br/>
		<form id="frmEmailReset" method="get">
			<input type="email" class="form-control" name="txtEmail" placeholder="Email Address" required autofocus/>
			<br/>
			<br/>
			<a href="../" class="btn btn-primary bg-pink" style="margin-left: 10px;">DSW Login</a>
			<input type="submit" class="btn btn-primary bg-pink" style="margin-left: 250px;" name="btnReset" id="btnReset" value="Reset"/>
		<form/>
	</div>
</html>