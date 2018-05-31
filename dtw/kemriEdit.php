<html>
<head>
	<title>Master Trainer Edit</title>
	<?php
   		 include "includes/meta-link-script.php";
   		 include "includes/config.php";
    ?>
		<?php 

			// if (!isset($_GET['id'])) {
			// 	# rediret
			// 	$moe->checkId('moeView.php');
			// }
			
			// remove spaces and type cast to int
			$id=trim((int)$_GET['id']);
			
			// get kemri by ID
			$query = "SELECT * FROM kemri_mt WHERE id='$id'";
			
			$result=mysql_query($query) or die("Could not get Kemri MT".mysql_error());
			$data=array();
			while ($row=mysql_fetch_assoc($result)) {
				$data[]=array(
					'first_name' => $row['first_name'],
					'second_name' => $row['second_name'],
					'ministry' => $row['ministry'],
					'title' => $row['title'],
					'job_class' => $row['job_class'],
					'posting_station' => $row['posting_station'],
					'province' => $row['province'],
					'national' => $row['national'],
					'phone' => $row['phone'],
					'email' => $row['email']

				);		    	
			}

			
			if (isset($_POST['kemri_update'])) {
				
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
				
			    $query="UPDATE kemri_mt SET
						first_name 		= '$first_name',
						second_name 	= '$second_name',
						ministry 		= '$ministry',
						title 			= '$title',
						job_class 		= '$job_class',
						posting_station = '$posting_station',
						province 		= '$province',
						national 		= '$national',
						phone 			= '$phone',
						email 			= '$email'
						WHERE id ='$id' ";

				$result=mysql_query($query) or die("did not update<br/>".mysql_error());

				header("Location:kemriEdit.php?id=".$id."&status=updated");

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
				if ($status=='updated') {
					?>
						<div class="updated">
							record updated 
						</div>
					<?php
				}
			}
		
		 ?>
		<div class="form-title">
				<h1>Edit Kemri Based MT's</h1>
		</div>
		<div class="vbox">
			<label>First Name</label><br>

					<div class="big_input">

						<input type="text" name="first_name" id="first_name" value="<?php echo $data[0]['first_name']; ?>"><br>

					</div>

				<label>Second Name</label><br>

					<div class="big_input">

						<input type="text" name="second_name" id="second_name" value="<?php echo $data[0]['second_name']; ?>"><br>

					</div>

				<label>Ministry</label><br>

					<div class="big_input">

						<input type="text" name="ministry" id="ministry" value="<?php echo $data[0]['ministry']; ?>"><br>

					</div>

				<label>Title</label><br>

					<div class="big_input">

						<input type="text" name="title" id="title" value="<?php echo $data[0]['title']; ?>"><br>

					</div>

				<label>Job Class</label><br>

					<div class="big_input">

						<input type="text" name="job_class" id="job_class" value="<?php echo $data[0]['job_class']; ?>"><br>

					</div>


			</div>
			<div class="vbox">
				<label>Posting Station</label><br>

					<div class="big_input">

						<input type="text" name="posting_station" id="posting_station" value="<?php echo $data[0]['posting_station'] ?>"><br>

					</div>

				<label>Province</label><br>

					<div class="big_input">

						<input type="text" name="province" id="province" value="<?php echo $data[0]['province'] ?>"><br>

					</div>

				<label>National</label><br>

					<div class="big_input">

						<input type="text" name="national" id="national" value="<?php echo $data[0]['national']; ?>"><br>

					</div>

				<label>Phone</label><br>

					<div class="big_input">

						<input type="text" name="phone" id="phone" value="<?php echo $data[0]['phone']; ?>"><br>

					</div>

				<label>Email</label><br>

					<div class="big_input">

						<input type="text" name="email" id="email" value="<?php echo $data[0]['email']; ?>"><br>

					</div>


		 <input type="submit" class="btn-custom" name="kemri_update"  value="Update">

		</div>



	</form>

	</div>
</body>
</html>