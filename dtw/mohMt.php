<html>
<head>
	<title>Create Master Trainer</title>
	<?php
   		 include "includes/meta-link-script.php";
   		 include "includes/config.php";
    ?>
	<?php 

		if (isset($_POST['moh_submit'])) {

				$first_name =$_POST['first_name'];
				$second_name =$_POST['second_name'];
				$ministry =$_POST['ministry'];
				$title =$_POST['title'];
				$job_class =$_POST['job_class'];
				$posting_station =$_POST['posting_station'];
				$province =$_POST['province'];
				$national =$_POST['national'];
				$phone =$_POST['phone'];
				$email =$_POST['email'];

				


				$first_name   		= addslashes(trim($first_name));
				$second_name   		= addslashes(trim($second_name));
				$ministry   		= addslashes(trim($ministry));
				$title   			= addslashes(trim($title));
				$job_class   		= addslashes(trim($job_class));
				$posting_station   	= addslashes(trim($posting_station));
				$province 			= addslashes(trim($province));
				$national 			= addslashes(trim($national));
				$phone  			= addslashes(trim($phone));
				$email 				= addslashes(trim($email));
				// blank
				$id="";


				$query="INSERT INTO moh_master_trainer VALUES (
							'$id',
							'$first_name',
							'$second_name',
							'$ministry',
							'$title',
							'$job_class',
							'$posting_station',
							'$province',
							'$national',
							'$phone',
							'$email' )";

				$result=mysql_query($query) or die("<h1>Did not insert into MOT MT</h1><br/>".mysql_error());

				header("Location:mohMt.php?status=created");
				
		}

	 ?>
</head>
<body>
	<?php include 'sideMenu.php'; ?>
	<div class="contentBody">
		<form action="" method="post">
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
			<div class="form-title">
				
				<h1>Create MOH MT</h1>
			</div>
		<div class="vbox">
			<label>First name</label><br>

				<div class="big_input">

					<input type="text" name="first_name" id="first_name" placeholder="first_name" value="first_name"><br>

				</div>

			<label>Second name</label><br>

				<div class="big_input">

					<input type="text" name="second_name" id="second_name" placeholder="second_name" value="second_name"><br>

				</div>

			<label>Ministry</label><br>

				<div class="big_input">

					<input type="text" name="ministry" id="ministry" placeholder="ministry" value="ministry"><br>

				</div>

			<label>Title</label><br>

				<div class="big_input">

					<input type="text" name="title" id="title" placeholder="title" value="title"><br>

				</div>

			<label>Job class</label><br>

				<div class="big_input">

					<input type="text" name="job_class" id="job_class" placeholder="job_class" value="job_class"><br>

				</div>
		</div>
		<div class="vbox">

			<label>Posting station</label><br>

				<div class="big_input">

					<input type="text" name="posting_station" id="posting_station" placeholder="posting_station" value="posting_station"><br>

				</div>

			<label>Province</label><br>

				<div class="big_input">

					<input type="text" name="province" id="province" placeholder="province" value="province"><br>

				</div>

			<label>National</label><br>

				<div class="big_input">

					<input type="text" name="national" id="national" placeholder="national" value="national"><br>

				</div>

			<label>Phone</label><br>

				<div class="big_input">

					<input type="text" name="phone" id="phone" placeholder="phone" value="phone"><br>

				</div>

			<label>Email</label><br>

				<div class="big_input">

					<input type="text" name="email" id="email" placeholder="email" value="email"><br>

				</div>


			<input type="submit" class="btn-custom" name="moh_submit" value="create">
		</div>

		</form>


	<!--End container class  -->
	</div>
</body>
</html>