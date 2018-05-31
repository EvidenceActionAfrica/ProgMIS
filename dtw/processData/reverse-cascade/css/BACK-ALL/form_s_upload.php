<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
	require_once ("includes/functions.php");
	require_once ("includes/form_functions.php");
	$level = $_SESSION['level'];

	if (isset($_POST['submit'])) {
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";
		
		$error = $_FILES["file"]["error"];
		$file_path = "upload/test.csv";
		
		if ($_FILES["file"]["error"] == 0) {
				//  upload and save the file to the server
				if (file_exists("upload/" . $_FILES["file"]["name"])) {
					echo "The file already exists";
				} else {
					move_uploaded_file($_FILES["file"]["tmp_name"], $file_path);
					echo "Stored in " . $file_path;
				}
				$upload = mysql_query("LOAD DATA LOCAL INFILE '$file_path' INTO TABLE form_s FIELDS TERMINATED BY ','") or die(mysql_error());
		}
		
		// if ($_FILES["file"]["error"] > 0) {
			// echo "Error: " . $_FILES["file"]["error"] . "<br>";
			// echo "Type: " . $_POST["file"]["type"] . "<br>";
			// echo "Size: " . $_FILES["file"]["size"] / 1024 . " KiB<br>";
			// echo "Stored in: " . $_FILES["file"]["tmp_name"];
			// $temp = explode(".", $_FILES["file"]["name"]);
			// $extension = end($temp);
			// if ($_FILES["file"]["size"] < 5000 && $extension == ".csv") {
// 				
			// } else {
				// echo "file uploded!";
			// }
	} else {
		echo "not submitted";
	}
?>
<!DOCTYPE >
<html lang="en">
	<form action="form_s_upload.php" method="post" enctype="multipart/form-data">
		<label for="file">Filename: </label>
		<input type="file" name="file" />
		<input type="submit" name="submit" value="upload" />
	</form> 
</html>




































