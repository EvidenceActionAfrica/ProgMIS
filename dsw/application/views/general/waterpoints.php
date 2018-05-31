<html>
<head>
	<title>Waterpoints</title>
</head>
<body>
	<div class="col-md-10">
	<table id="example" class="display" cellspacing="0" width="50%">
        <thead>
            <tr>
				<th>waterpoint_id</th>
				<th>installation_date</th>
				<th>program_code</th>
				<th>district_name</th>
				<th>sublocation_parish</th>
				<th>village</th>
				<th>waterpoint_name</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
	          	<th>waterpoint_id</th>
				<th>installation_date</th>
				<th>program_code</th>
				<th>district_name</th>
				<th>sublocation_parish</th>
				<th>village</th>
				<th>waterpoint_name</th>
            </tr>
        </tfoot>
    </table>
</div>
</body>
</html>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->

<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<script type="text/javascript">
	
$(document).ready(function() {
	$('#example').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "play.php"
	} );
});
</script>