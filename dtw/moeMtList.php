<html>
<head>
	<title>Create Master Trainer</title>
	<?php
   		 include "includes/meta-link-script.php";
   		 include "includes/config.php";
    ?>
	<?php 

		if (isset($_POST['health_submit'])) {
				$first_name=$_POST['first_name'];
				$second_name=$_POST['second_name'];
				$ministry=$_POST['ministry'];
				$posting_station=$_POST['posting_station'];
				$county=$_POST['county'];
				$job_group=$_POST['job_group'];
				$phone_number=$_POST['phone_number'];
				$email=$_POST['email'];


			$first_name 		= addslashes(trim($first_name));
			$second_name 		= addslashes(trim($second_name));
			$ministry 			= addslashes(trim($ministry));
			$posting_station 	= addslashes(trim($posting_station));
			$county 			= addslashes(trim($county));
			$job_group 			= addslashes(trim($job_group));
			$phone_number 		= addslashes(trim($phone_number));
			$email 				= addslashes(trim($email));
			// blank
			$id='';

			
			$query="INSERT INTO moe_mt_list VALUES (
				    '$id',
					'$first_name',
					'$second_name',
					'$ministry',
					'$posting_station',
					'$county',
					'$job_group',
					'$phone_number',
					'$email' )";
			$result=mysql_query($query) or die("<h1>Didn not Insert into MOE MT</h1><br/>".mysql_error());

			header("Location:moeMtList.php?status=created");
				

		}

	 ?>
</head>
<body>
	<?php include 'sideMenu.php'; ?>
	<div class="contentBody">
		<?php 
			if (isset($_GET['status'])) {
				$status=$_GET['status'];
				if ($status=='created') {
					?>
						<div class="updated">
							record created 
						</div>
					<?php
				}
			}
		
		 ?>
		<form action="" method="post">
			<div class="form-title">
				<h1>Create MOE MT</h1>
			</div>

		<div class="vbox">
			<label>first_name</label><br>

				<div class="big_input">

					<input type="text" name="first_name" id="first_name" placeholder="first_name" value="first_name"><br>

				</div>
			<label>second_name</label><br>

				<div class="big_input">

					<input type="text" name="second_name" id="second_name" placeholder="second_name" value="second_name"><br>

				</div>
			<label>ministry</label><br>

				<div class="big_input">

					<input type="text" name="ministry" id="ministry" placeholder="ministry" value="ministry"><br>

				</div>
			<label>posting_station</label><br>

				<div class="big_input">

					<input type="text" name="posting_station" id="posting_station" placeholder="posting_station" value="posting_station"><br>

				</div>
		</div>
		<div class="vbox">
			<label>county</label><br>

				<div class="big_input">

					<input type="text" name="county" id="county" placeholder="county" value="county"><br>

				</div>
			<label>job_group</label><br>

				<div class="big_input">

					<input type="text" name="job_group" id="job_group" placeholder="job_group" value="job_group"><br>

				</div>
			<label>phone_number</label><br>

				<div class="big_input">

					<input type="text" name="phone_number" id="phone_number" placeholder="phone_number" value="phone_number"><br>

				</div>
			<label>email</label><br>

				<div class="big_input">

					<input type="text" name="email" id="email" placeholder="email" value="email"><br>

				</div>


			<input type="submit" class="btn-custom" name="health_submit" value="create">
		</div>

		</form>


	<!--End container class  -->
	</div>
</body>
</html>