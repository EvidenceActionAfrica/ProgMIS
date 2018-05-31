<html>
<head>
	<title></title>
	<?php 

			include "header_links.php";



		 ?>
</head>
<body>

	<div class="container">
			<?php include "evidence_action_header.php" ?>
			Select Dirtrict to view formA
			<?php 

			$data=$GetFormData->getFormASchoolsByDistrict() ;
				//var_dump($data);
				//die();
				foreach ($data as $key => $value) {
					
					?>
						<select>
							<option> <?php echo $value['district'];?> </option>
						</select>
					<?
				}
			?>
			<select>
				<option></option>
			</select>
	</div>
</body>
</html>