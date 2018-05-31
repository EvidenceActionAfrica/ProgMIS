<html>
<head>
	<title>Edit MOE MT</title>
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

			// Get MOE by ID

			$query = "SELECT * FROM moe_mt_list WHERE id='$id'";

			$result=mysql_query($query) or die("<h1>Did  not get MOE master Trainer</h1><br/>".mysql_error());
			
			while ($row=mysql_fetch_assoc($result)) {
				$data[]=array(
					'id'=>$row['id'],
					'first_name'=>$row['first_name'],
					'second_name'=>$row['second_name'],
					'ministry'=>$row['ministry'],
					'posting_station'=>$row['posting_station'],
					'county'=>$row['county'],
					'job_group'=>$row['job_group'],
					'phone_number'=>$row['phone_number'],
					'email'=>$row['email']
				);		    	
			}
      			
			
			if (isset($_POST['moe_update'])) {

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

			  $query="UPDATE moe_mt_list SET
				first_name			='$first_name',
				second_name			='$second_name',
				ministry			='$ministry',
				posting_station		='$posting_station',
				county 				='$county',
				job_group 			='$job_group',
				phone_number 		='$phone_number',
				email 				='$email'
				WHERE id ='$id' ";

			$result=mysql_query($query) or die("<h1>Did nit Update</h1><br/>".mysql_error());

			header("Location:moeMtListEdit.php?id=".$id."&status=updated");

			}
		?>
</head>
<body>

	<?php include 'sideMenu.php'; ?>
	<div class="contentBody">
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
	<form action="" method="post">
		<div class="form-title">
			<h1>Create MOE MT</h1>
		</div>

	<div class="vbox">
		<label>first_name</label><br>

			<div class="big_input">

				<input type="text" name="first_name" placeholder="first_name" id="first_name" value="<?php echo $data[0]['first_name']; ?>"><br>

			</div>

		<label>second_name</label><br>

			<div class="big_input">

				<input type="text" name="second_name" placeholder="second_name" id="second_name" value="<?php echo $data[0]['second_name']; ?>"><br>

			</div>

		<label>ministry</label><br>

			<div class="big_input">

				<input type="text" name="ministry" placeholder="ministry" id="ministry" value="<?php echo $data[0]['ministry']; ?>"><br>

			</div>

		<label>posting_station</label><br>

			<div class="big_input">

				<input type="text" name="posting_station" placeholder="posting_station" id="posting_station" value="<?php echo $data[0]['posting_station']; ?>"><br>

			</div>
	</div>
	<div class="vbox">

		<label>county</label><br>

			<div class="big_input">

				<input type="text" name="county" placeholder="county" id="county" value="<?php echo $data[0]['county']; ?>"><br>

			</div>

		<label>job_group</label><br>

			<div class="big_input">

				<input type="text" name="job_group" placeholder="job_group" id="job_group" value="<?php echo $data[0]['job_group']; ?>"><br>

			</div>

		<label>phone_number</label><br>

			<div class="big_input">

				<input type="text" name="phone_number" placeholder="phone_number" id="phone_number" value="<?php echo $data[0]['phone_number']; ?>"><br>

			</div>

		<label>email</label><br>

			<div class="big_input">

				<input type="text" name="email" placeholder="email" id="email" value="<?php echo $data[0]['email']; ?>"><br>

			</div>


		 <input type="submit" class="btn-custom" name="moe_update"  value="Update">
	</div>



	</form>

	</div>
</body>
</html>