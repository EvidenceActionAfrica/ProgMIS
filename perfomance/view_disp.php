<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");
$sql = "SELECT DISTINCT year FROM dsw_per_dispensed_rates  WHERE country='$country_val' ORDER BY year DESC";
$result = mysqli_query($mysqli, $sql);
if (isset($_GET["submit_year"])) {
    $year = $_GET["year_select"];
} else {
    $result_1 = mysqli_query($mysqli, $sql);
    $initial = mysqli_fetch_assoc($result_1);
    $year = $initial['year'];
}
$image = new image;
$insertFile = new UploadFIle;

if (isset($_POST['uploadCSV'])) {

    $table = "dsw_per_dispensed_rates";
    if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
        $csvMessage = "Upload Failed";
    } else {

        $temp = $_FILES["file"]["tmp_name"];
        $csvMessage = "Upload Successful";
        $table_name = $_POST['table_name'];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = $table_name . ' imported';
        $description = 'No description';
        $sql_add = "INSERT INTO performance_log_record (country, user_name, email, action, description) 
                        VALUES ( '$country_val', '$user_name', '$email', '$action', '$description')";
        mysqli_query($mysqli, $sql_add) or die(mysqli_query($mysqli));
    }

    $filename = $image->upload_image($temp);
    $insertFile->insertFile($filename, $table);
    //Connect as normal above
}
if (isset($_POST['clearbtn'])) {

    $table = "dsw_per_dispensed_rates";
    $query = "DELETE FROM $table WHERE country = '$country_val' AND YEAR = '$year' ";
    if (mysqli_query($mysqli, $query)) {
        $csvMessage = "Table Emptied, Browse File then Upload";
        $table_name = $_POST['table_name'];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = $table_name . ' emptied';
        $description = 'year ' . $year . ' records deleted';
        $sql_add = "INSERT INTO performance_log_record (country, user_name, email, action, description) 
                        VALUES ( '$country_val', '$user_name', '$email', '$action', '$description')";
        mysqli_query($mysqli, $sql_add) or die(mysqli_query($mysqli));
    } else {
        $csvMessage = "fail";
    }
}
?>

<div class="row">

    <div class="col-md-2">

        <div class="sidebar">

            <?php require_once ('includes/left_bar.php'); ?>
        </div>

    </div>

    <div class="col-md-10">

        <div class="clearfix"> 
            <a class="btn btn-primary" href="#importCSV"><span class="glyphicon glyphicon-download-alt" ></span> IMPORT CSV</a> Last updated 22 December 2017
        </div></br>
        <form id="logform1"  method="$_GET" style='float: left'>  

            <select style="width:140px; height: 34px" name="year_select" id="year_select">
                <option value='All years'<?php if ($year == 'All years') echo 'selected'; ?> >All Year</option>
                <?php
                while ($rows = mysqli_fetch_assoc($result)) { //loop table rows
                    ?>
                    <option value="<?php echo $rows['year']; ?>"<?php if ($year == $rows['year']) echo 'selected'; ?>>
                        <?php echo $rows['year']; ?></option>
                <?php } ?>
            </select>
            <input class="btn btn-primary" type="submit" name="submit_year" id="submit_year" value="CHOOSE YEAR">
        </form>
        <div class="btn-group pull-right">       
            <form method="POST" action="export/exp_disp.php">            
                <input type="hidden" name="rec_year" value="<?php echo $year; ?>" />
                <input type="hidden" name="rec_country" value="<?php echo $country_val; ?>" />
                <input class="btn btn-primary" type="submit" name="" value="Export CSV">
            </form>       
        </div>
        <br>
        <br>

        <div class="table-responsive">
            <?php
            isset($_GET["submit_year"]);

            if ($year == 'All years') {
                $query_disp_header = "SELECT MIN(year), MAX(year) FROM dsw_per_dispensed_rates  WHERE country='$country_val'";
                $result_disp_header = mysqli_query($mysqli, $query_disp_header) or die(mysqli_query($mysqli));
                $row_disp_header = mysqli_fetch_assoc($result_disp_header);
                $min_disp_year = $row_disp_header['MIN(year)'];
                $max_disp_year = $row_disp_header['MAX(year)'];
                $year_sub_min = "AND year ='$min_disp_year'";
                $year_sub_max = "AND year ='$max_disp_year'";
                $year_sub = "";
            } else {
                $year_sub_min = $year_sub_max = $year_sub = "AND year ='$year'";
                $max_disp_year = $min_disp_year = $year;
            }
            ?>  

            <h3>Dispenser Functionality Rate</h3>
            <?php
            $query_disp_header1 = "SELECT MIN(month) FROM dsw_per_dispensed_rates WHERE country='$country_val' $year_sub_min";
            $result_disp_header1 = mysqli_query($mysqli, $query_disp_header1) or die(mysqli_query($mysqli));
            $row_disp_header1 = mysqli_fetch_assoc($result_disp_header1);
            $min_disp_month = $row_disp_header1['MIN(month)'];
            $query_disp_header2 = "SELECT MAX(month) FROM dsw_per_dispensed_rates WHERE country='$country_val' $year_sub_max";
            $result_disp_header2 = mysqli_query($mysqli, $query_disp_header2) or die(mysqli_query($mysqli));
            $row_disp_header2 = mysqli_fetch_assoc($result_disp_header2);
            $max_disp_month = $row_disp_header2['MAX(month)'];

            if (0 < $min_disp_month && $min_disp_month < 13) {
                $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                $disp_min_disp_month = $month_names[$min_disp_month];
            } else {
                $disp_min_disp_month = 'no month';
            }

            if (0 < $max_disp_month && $max_disp_month < 13) {
                $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                $disp_max_disp_month = $month_names[$max_disp_month];
            } else {
                $disp_max_disp_month = 'no month';
            }
            ?>
            <p class="text_title">Functionality is defined as a dispenser that will release a proper dose of chlorine (3ml) if the dispenser has chlorine in it. 
                Non-functional dispensers may experience valve problems, a missing or cracked tank, or a missing or vandalized dispensers.
                Dispensers that do not have chlorine but that do release chlorine after chlorine is added are considered “Functional”. 
                The table below provides the percentage of dispensers that were considered functional. Statistics are gathered from 
                regular Spot Check Forms that are completed by circuit riders on each trip that chlorine is delivered to the dispenser.
                The data below reflect the data collected during the period from <?php echo $disp_min_disp_month . ' ' . $min_disp_year; ?>
                to <?php echo $disp_max_disp_month . ' ' . $max_disp_year; ?></p>
				<div id="divDFR"></div>
            <!--<p class="text_foot">*Absence of data means that no functionality or hardware problem data exists for a program from 2014 - present year.</p>-->
            </br> 

            <!--########################################### Second Table ###############################################################--> 

            <h3>Hardware Problem</h3>
            <p class="text_title">Hardware problems include casing, tank, lid, and valve issues. 
                The table below provides the percentage of dispensers that were considered to have hardware problems. 
                The statistics do not include problems related to stickers and barcodes. Statistics are gathered from 
                regular Spot Check Forms that are completed by circuit riders on each trip that chlorine is delivered to the dispenser. 
                The data below reflect the data collected during the period from <?php echo $disp_min_disp_month . ' ' . $min_disp_year; ?>
                to <?php echo $disp_max_disp_month . ' ' . $max_disp_year; ?></p>
				<div id="divHP"></div>
            <!--<p class="text_foot">*Absence of data means that no functionality or hardware problem data exists for a program from 2014 - present year.</p>-->

        </div>

        <!--#####################################################################-->

        <div id="importCSV" class="modalDialog">
            <div style="width:380px">
                <?php
                if (isset($csvMessage)) {
                    echo '<h4 style="color:#050000;background-color:#A2FF7E;text-align:center;">' . $csvMessage . '</h4>';
                }
                ?>
                <center>
                    <h4 class="">Upload Document</h4>
                    <div style="padding: 5px; margin: 0px auto">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="file">Filename:</label>
                                <input type="file" name="file" id="file" class="form-control"/>                                     
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="table_name" value="dispenser table">
                                <input type="submit" id='btnEmpty' name="clearbtn" value="Empty Table" class="btn-custom-small-normal"/>
                                <input type="submit" id='btnSubmit' name="uploadCSV" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>                                            
                            </div>
                            <div class="form-group">
                                <p><u>Note</u>: Before Upload, Empty the table by clicking on the above button</p>                                                           
                            </div>
                        </form>
                    </div>
                </center>
                <br/>
                <center>
                    <div>
                        <a href="#close" class="" > Close</a>
                    </div>
                </center>
            </div>
        </div> 

    </div>

</div>
</body>
</html>
<script>
	/*
	28th October 2017
	Define functions that will be instanciated once DOM is ready for JavaScript to run
	1. Inform the user that the process is busy.
	2. Post processing arguments are parsed to the relevant associated page. Include global variables already defined in header.php and define any relevant arguments used to distinguish the tables.
	3. Relay the data as returned by the associated files.
	*/
	
	function tableDFR() {
		$(divDFR).html('<br><br><br><h id="divDataError"><b><center>Processing Table. Please wait.</center></b></h><br><br><br>');
		$.post("+dispData.php", {
			info_type: 'dfr',
			country: <?php echo $country_val; ?>,
			year: <?php if ($year == 'All years') {
							echo '0';
						} else {
							echo $year;
						}
					?>
			}).done(function(data) {
				$('#divDFR').html(data);
		});
	}

	function tableHP() {
		$(divHP).html('<br><br><br><h id="divDataError"><b><center>Processing Table. Please wait.</center></b></h><br><br><br>');
		$.post("+dispData.php", {
			info_type: 'hw_prob',
			country: <?php echo $country_val; ?>,
			year: <?php if ($year == 'All years') {
							echo '0';
						} else {
							echo $year;
						}
					?>
			}).done(function(data) {
				$('#divHP').html(data);
		});
	}	
	$(document).ready(function() {
		tableDFR();
		tableHP();
	})
</script>
<?php
mysqli_close($mysqli);
?>