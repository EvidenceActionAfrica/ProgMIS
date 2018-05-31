<html>
<head>
	<title>Create Kemri MT</title>
	<?php
   		 include "includes/meta-link-script.php";
   		 include "includes/config.php";
    ?>
	<?php 

		if (isset($_POST['kemri_submit'])) {
				$first_name = $_POST['first_name'];
				$second_name = $_POST['second_name'];
				$ministry = $_POST['ministry'];
				$title = $_POST['title'];
				$job_class = $_POST['job_class'];
				$posting_station = $_POST['posting_station'];
				$province = $_POST['province'];
				$national = $_POST['national'];
				$phone = $_POST['phone'];
				$email = $_POST['email'];

			$first_name     	= addslashes(trim($first_name));
			$second_name 		= addslashes(trim($second_name));
			$ministry 			= addslashes(trim($ministry));
			$title 				= addslashes(trim($title));
			$job_class 			= addslashes(trim($job_class));
			$posting_station 	= addslashes(trim($posting_station));
			$province 			= addslashes(trim($province));
			$national 			= addslashes(trim($national));
			$phone 				= addslashes(trim($phone));
			$email 				= addslashes(trim($email));

			$query=	"INSERT INTO kemri_mt VALUES (
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
			$result=mysql_query($query) or die("did not insert<br/>".mysql_error());

			header("Location:KemriMt.php?status=created");
			

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
				<h1>Create Kemri Based Master Trainer</h1>
			</div>

			<div class="vbox">

				<label>First Name</label><br>

					<div class="big_input">

						<input type="text" name="first_name" id="first_name" value="first_name">

					</div>

				<label>Second Name</label><br>

					<div class="big_input">

						<input type="text" name="second_name" id="second_name" value="second_name">

					</div>

				<label>Ministry</label><br>

					<div class="big_input">

						<input type="text" name="ministry" id="ministry" value="ministry">

					</div>

				<label>Title</label><br>

					<div class="big_input">

						<input type="text" name="title" id="title" value="title">

					</div>

				<label>Job Class</label><br>

					<div class="big_input">

						<input type="text" name="job_class" id="job_class" value="job_class">

					</div>


			</div>
			<div class="vbox">
				<label>Posting Station</label><br>

					<div class="big_input">

						<input type="text" name="posting_station" id="posting_station" value="posting_station">

					</div>

				<label>Province</label><br>

					<div class="big_input">

						<input type="text" name="province" id="province" value="province">

					</div>

				<label>National</label><br>

					<div class="big_input">

						<input type="text" name="national" id="national" value="national">

					</div>

				<label>Phone</label><br>

					<div class="big_input">

						<input type="text" name="phone" id="phone" value="phone">

					</div>

				<label>Email</label><br>

					<div class="big_input">

						<input type="text" name="email" id="email" value="email">

					</div>


				<input type="submit" name="kemri_submit" class="btn-custom" value="create">
			</div>

		</form>
		<!-- end content body -->
		</div>


	<!--End container class  -->
	</div>
</body>
</html>