<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");
$sql = "SELECT DISTINCT year FROM dsw_per_adoption_rates  WHERE country='$country_val' ORDER BY year DESC";
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

    $table = "dsw_per_adoption_rates";
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
    $csvMessage = $insertFile->insertFile($filename, $table, 'view_adop.php');

//Connect as normal above
}
if (isset($_POST['clearbtn'])) {

    $table = "dsw_per_adoption_rates";
    $query = "DELETE FROM $table WHERE country = '$country_val' AND YEAR = '$year' ";
    if (mysqli_query($mysqli, $query)) {
        $csvMessage = "Data for year " . $year . ", Deleted Browse File then Upload";
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
	<div style="text-align:center">Last updated on: <b>30th April 2018</b></div>
        <div class="clearfix"> 
            <a class="btn btn-primary" href="#importCSV"><span class="glyphicon glyphicon-download-alt" ></span> IMPORT CSV Adop&Diar</a>
        </div></br>        
        <form id="test_form"  method="$_GET" style='float: left'>  

            <select style="width:140px; height: 34px" name="year_select" id="year_select">
                <option value='All years'<?php if ($year == 'All years') echo 'selected'; ?> >All years</option>
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
            <form method="POST" action="export/exp_adop.php">            
                <input type="hidden" name="rec_year" value="<?php echo $year; ?>" />
                <input type="hidden" name="rec_country" value="<?php echo $country_val; ?>" />
                <input class="btn btn-primary" type="submit" name="" value="Export CSV">
            </form>
        </div>
        <br>
        <br>
        <!--################################################## First Table ######################################################################-->
        <div class="table-responsive">
            <?php
            $field = 'c803_tcr_reading';
            $field2 = 'c806_fcr_reading';
            if ($year == 'All years') {
                $query_adop_header = "SELECT MIN(year), MAX(year) FROM dsw_per_adoption_rates  WHERE country='$country_val'";
                $result_adop_header = mysqli_query($mysqli, $query_adop_header) or die(mysqli_query($mysqli));
                $row_adop_header = mysqli_fetch_assoc($result_adop_header);
                $min_adop_year = $row_adop_header['MIN(year)'];
                $max_adop_year = $row_adop_header['MAX(year)'];
                $year_sub_min = "AND year ='$min_adop_year'";
                $year_sub_max = "AND year ='$max_adop_year'";
                $year_sub = "";
            } else {
                $year_sub_min = $year_sub_max = $year_sub = "AND year ='$year'";
                $max_adop_year = $min_adop_year = $year;
            }
            ?>

            <h3>TCR Adoption (Total Chlorine Adoption)</h3>
            <?php
            $query_ob = "SELECT * FROM dsw_per_adoption_rates  WHERE country='$country_val' $year_sub";
            $result_ob = mysqli_query($mysqli, $query_ob) or die(mysqli_query($mysqli));
            $obser = mysqli_affected_rows($mysqli);
            $query_adop_header1 = "SELECT MIN(month) FROM dsw_per_adoption_rates WHERE country='$country_val' $year_sub_min";
            $result_adop_header1 = mysqli_query($mysqli, $query_adop_header1) or die(mysqli_query($mysqli));
            $row_adop_header1 = mysqli_fetch_assoc($result_adop_header1);
            $min_adop_month = $row_adop_header1['MIN(month)'];
            $query_adop_header2 = "SELECT MAX(month) FROM dsw_per_adoption_rates WHERE country='$country_val' $year_sub_max";
            $result_adop_header2 = mysqli_query($mysqli, $query_adop_header2) or die(mysqli_query($mysqli));
            $row_adop_header2 = mysqli_fetch_assoc($result_adop_header2);
            $max_adop_month = $row_adop_header2['MAX(month)'];
            if (0 < $min_adop_month && $min_adop_month < 13) {
                $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                $disp_min_adop_month = $month_names[$min_adop_month];
            } else {
                $disp_min_adop_month = 'no month';
            }

            if (0 < $max_adop_month && $max_adop_month < 13) {
                $month_names = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                $disp_max_adop_month = $month_names[$max_adop_month];
            } else {
                $disp_max_adop_month = 'no month';
            }
            ?>
            <p class="text_title"> The table below provides an overview of the percentage of randomly sampled households that tested positive for Total Chlorine
                Residual in their drinking water during an unannounced visit. 1.5% of all dispensers are evaluated every month. 
                For the first three months of evaluation in a new region, 2% of all dispensers are monitored. 
                A random selection of 8 households are interviewed at each dispenser. The table below includes
                a total of <?php echo $obser; ?> observations for the period from <?php echo $disp_min_adop_month . ' ' . $min_adop_year; ?> to 
                <?php echo $disp_max_adop_month . ' ' . $max_adop_year; ?></p>
			<div id="divTCR"></div>
            <p class="text_foot">* Hover your mouse over blank cells for more information on missing numbers</p>
 <!--            <p class="text_foot">* A 0% means that out of the evaluations done during a particular month a total percentage zero was observed, 
                 a blank means that no evaluations were done for a program during a particular month.</p>-->
            </br>
            <!--################################################## Second Table ######################################################################-->
            <h3>FCR Adoption (Free Chlorine Adoption)</h3>
            <p class="text_title"> This table provides an overview of the percentage of randomly sampled households that tested positive for 
                Free Chlorine Residual in their drinking water during an unannounced visit. 1.5% of all dispensers are evaluated every month.
                For the first three months of evaluation in a new region, 2% of all dispensers are monitored. 
                A random selection of 8 households are interviewed at each dispenser. 
                The table below includes a total of <?php echo $obser; ?> observations for the period from 
                <?php echo $disp_min_adop_month . ' ' . $year; ?> to <?php echo $disp_max_adop_month . ' ' . $year; ?></p>
			<div id="divFCR"></div>
            <p class="text_foot">* Hover your mouse over blank cells for more information on missing numbers</p>
<!--            <p class="text_foot">* A 0% means that out of the evaluations done during a particular month a total percentage zero was observed, 
                a blank means that no evaluations were done for a program during a particular month.</p>-->
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
                                <input type="hidden" name="table_name" value="adoption table">
                                <input type="submit" id='btnEmpty' name="clearbtn" value="Empty Table" class="btn-custom-small-normal"/>                                
                                <input type="submit" id='btnSubmit' name="uploadCSV" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>                                            
                            </div>
                            <div class="form-group">
                                <u>Note</u>: 
                                <li style="text-align: left;">Before Upload, Empty the table by clicking on the (Empty Table) button.
                                <li style="text-align: left;">The document to upload should be  a CSV only.
                                <li style="text-align: left;">The structure of the CSV should be followed as suggested.
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
<div id="divClickReady"></div>
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
	
	function tableTCR() {
		$(divTCR).html('<br><br><br><h id="divDataError"><b><center>Processing Table. Please wait.</center></b></h><br><br><br>');
		$.post("+adopData.php", {
			info_type: 'tcr',
			country: <?php echo $country_val; ?>,
			year: <?php if ($year == 'All years') {
							echo '0';
						} else {
							echo $year;
						}
					?>
			}).done(function(data) {
				$('#divTCR').html(data);
		});
	}

	function tableFCR() {
		$(divFCR).html('<br><br><br><h id="divDataError"><b><center>Processing Table. Please wait.</center></b></h><br><br><br>');
		$.post("+adopData.php", {
			info_type: 'fcr',
			country: <?php echo $country_val; ?>,
			year: <?php if ($year == 'All years') {
							echo '0';
						} else {
							echo $year;
						}
					?>
			}).done(function(data) {
				$('#divFCR').html(data);
		});
	}	
		
	$(document).ready(function() {
		
		tableTCR();
		tableFCR();
		
	})
</script>
<?php
mysqli_close($mysqli);
?>