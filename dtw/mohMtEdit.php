<html>
<head>
	<title>Master Trainer Edit</title>
	<?php
   		 include "includes/meta-link-script.php";
   		 include "includes/config.php";
    ?>
		<?php 
			// remove spaces and type cast to int

			$id=trim((int)$_GET['id']);

			// get MOH by ID
			$query = "SELECT * FROM moh_master_trainer WHERE id='$id'";

			$result=mysql_query($query) or die("Cannot get MOH Trainer".mysql_error());

			while ($row=mysql_fetch_assoc($result)) {
				$data[]=array(
					'id'=>$row['id'],
					'first_name'=>$row['first_name'],
					'second_name'=>$row['second_name'],
					'ministry'=>$row['ministry'],
					'title'=>$row['title'],
					'job_class'=>$row['job_class'],
					'posting_station'=>$row['posting_station'],
					'province'=>$row['province'],
					'national'=>$row['national'],
					'phone'=>$row['phone'],
					'email'=>$row['email']	);		    	
			}
			 
			
			if (isset($_POST['moe_update'])) {

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
				

			
			    $query="UPDATE moh_master_trainer SET
					first_name 		= '$first_name',
					second_name 	= '$second_name',
					Ministry 		= '$ministry',
					title 			= '$title',
					job_class 		= '$job_class',
					posting_station = '$posting_station',
					province 		= '$province',
					national 		= '$national',
					phone 			= '$phone',
					email 			= '$email'
					WHERE id ='$id' ";

				$result=mysql_query($query) or die("Did not Update MOH<br/>".mysql_error());

				header("Location:mohMtEdit.php?id=".$id."&status=updated");
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
			<h1>Edit MOH MT</h1>
		</div>

		<div class="vbox">
		<label>First name</label><br>

			<div class="big_input">

				<input type="text" name="first_name" id="first_name" placeholder="first_name" value="<?php echo $data[0]['first_name'] ?>"><br>
			</div>

		<label>Second name</label><br>

			<div class="big_input">

				<input type="text" name="second_name" id="second_name" placeholder="second_name" value="<?php echo $data[0]['second_name'] ?>"><br>
			</div>

		<label>Ministry</label><br>

			<div class="big_input">

				<input type="text" name="ministry" id="ministry" placeholder="ministry" value="<?php echo $data[0]['ministry'] ?>"><br>
			</div>

		<label>Title</label><br>

			<div class="big_input">

				<input type="text" name="title" id="title" placeholder="title" value="<?php echo $data[0]['title'] ?>"><br>
			</div>

		<label>Job class</label><br>

			<div class="big_input">

				<input type="text" name="job_class" id="job_class" placeholder="job_class" value="<?php echo $data[0]['job_class'] ?>"><br>
			</div>

	</div>
	<div class="vbox">
		<label>Posting station</label><br>

			<div class="big_input">

				<input type="text" name="posting_station" id="posting_station" placeholder="posting_station" value="<?php echo $data[0]['posting_station'] ?>"><br>
			</div>

		<label>Province</label><br>

			<div class="big_input">

				<input type="text" name="province" id="province" placeholder="province" value="<?php echo $data[0]['province'] ?>"><br>
			</div>

		<label>National</label><br>

			<div class="big_input">

				<input type="text" name="national" id="national" placeholder="national" value="<?php echo $data[0]['national'] ?>"><br>
			</div>

		<label>Phone</label><br>

			<div class="big_input">

				<input type="text" name="phone" id="phone" placeholder="phone" value="<?php echo $data[0]['phone'] ?>"><br>
			</div>

		<label>Email</label><br>

			<div class="big_input">

				<input type="text" name="email" id="email" placeholder="email" value="<?php echo $data[0]['email'] ?>"><br>
			</div>


		 <input type="submit" class="btn-custom" name="moe_update"  value="Update">
	</div>



	</form>

	</div>
</body>
</html>