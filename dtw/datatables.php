<!DOCTYPE html>
<html>
<head>
	<title>Data tables</title>
	<!-- datatables -->
	<script src="js/jquery.min.js"  type="text/javascript" ></script>
<script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="css/dataTables.css">

</head>
<body>
<table id="data-table">
  <thead>
      <th>dd</th>
      <th>dd</th>
      <th>dd</th>

  </thead>
  <tbody>
      <tr>
        <td>dd</td>
      <td>dd</td>
      <td>dd</td>
      </tr>

  </tbody>

</table>
</body>
</html>


<script type="text/javascript">
  $(document).ready(function() {
      $('#data-table').dataTable();
  } );
</script>
