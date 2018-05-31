<?php
require('trackerData.php');
?>
<div class="container">
	<div class="col-md-8 col-md-offset-4">
		<form action="sendOut.php" method="POST">
		<label for="sendDate">Send Date</label><input type="text" class="datepicker form-control" id="sendDate" name="sendDate" value=""/>
		<label for="fromWhom">From</label><input type="text" class="form-control" name="fromWhom" value="" />
		<label for="subject">Subject</label><input type="text" class="form-control" name="subject" value="" />
		<label for="content"></label><textarea style="width:80%;min-height:200px;" class="form-control" name="content" />
		</textarea>
		<br/>
		<input type="submit" class="btn btn-info" name="send" value="Send As Mail" />
		<input type="submit" class="btn btn-info" name="send" value="Send As Sms" />
		<input type="submit" class="btn btn-info" name="send" value="Send Both" />
		<input type="submit" class="btn btn-warning" name="send" value="cancel" />

		</form>
	</div>
</div>