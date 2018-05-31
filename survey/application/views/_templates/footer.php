</div><!--end content-->
</html>
</body>
<!---
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
-->
<script>
$(function() {
	 //$( ".datepicker").datepicker({ dateFormat: "dd-mm-yy",showWeek: true,firstDay: 1, numberOfMonths: 3,showButtonPanel: true});
	 $( ".datepicker").datepicker({ dateFormat: "dd-mm-yy"});
	//  $('input.timepicker').timepicker();   
});	
$(document).ready(function() {
document.getElementById('imgLoading').style.visibility = 'hidden';
 });

</script>

<?php
ob_flush();
?>