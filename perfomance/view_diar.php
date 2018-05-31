<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");
$glbField = "";
?>
<div class="row">

    <div class="col-md-2">

        <div class="sidebar">

            <?php require_once ('includes/left_bar.php'); ?>
        </div>
    </div>
    <div class="col-md-10">
	<div style="text-align:center">Last updated on: <b>30th April 2018</b></div>
        <?php
        $sql = "SELECT DISTINCT year FROM dsw_per_adoption_rates  WHERE country='$country_val' ORDER BY year DESC";
        $result = mysqli_query($mysqli, $sql);
        if (isset($_GET["submit_year"])) {
            $year = $_GET["year_select"];
        } else {

            $result_1 = mysqli_query($mysqli, $sql);
            $initial = mysqli_fetch_assoc($result_1);
            $year = $initial['year'];
        }
        ?>
        <form id="logform1"  method="$_GET" style='float: left'>  

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
            <form method="POST" action="export/exp_diar.php">            
                <input type="hidden" name="rec_year" value="<?php echo $year; ?>" />
                <input type="hidden" name="rec_country" value="<?php echo $country_val; ?>" />
                <input class="btn btn-primary" type="submit" name="" value="Export CSV">
            </form>        
        </div>
        <br>
        <br>
        <br>
        <div class="table-responsive">
            <?php
            if ($year == 'All years') {
                $query_adop_header = "SELECT MIN(year), MAX(year) FROM dsw_per_adoption_rates  WHERE country='$country_val'";
                $result_adop_header = mysqli_query($mysqli, $query_adop_header) or die(mysql_error());
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
            #################################################### first table  ###################################################       

            $query_adop_header1 = "SELECT MIN(month) FROM dsw_per_adoption_rates WHERE country='$country_val' $year_sub_min";
            $result_adop_header1 = mysqli_query($mysqli, $query_adop_header1) or die(mysql_error());
            $row_adop_header1 = mysqli_fetch_assoc($result_adop_header1);
            $min_adop_month = $row_adop_header1['MIN(month)'];
            $query_adop_header2 = "SELECT MAX(month) FROM dsw_per_adoption_rates WHERE country='$country_val' $year_sub_max";
            $result_adop_header2 = mysqli_query($mysqli, $query_adop_header2) or die(mysql_error());
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

            <p class="text_title">The tables below provide self-reported data from the parents of children under the age of 5 indicating what 
                percentage of children experienced a case of diarrhea in the last 24 hours and the last 2 weeks respectively.
                Data is collected as a part of the community survey which is done at 8 random households from a random 
                selection of 1 out of every 100 dispensers per month. The data below reflect the data collected during 
                the period from <?php echo $disp_min_adop_month . ' ' . $min_adop_year; ?> to <?php echo $disp_max_adop_month . ' ' . $max_adop_year; ?></p>
            <h3>Diarrhea Rates last 48hours</h3>
			<div id="divTwoDays"></div>
<!--            <p class="text_foot">* A 0% means that out of the evaluations done during a particular month a total percentage zero was observed, 
                a blank means that no evaluations were done for a program during a particular month.</p>-->
            <!--############################################ second table ####################################################-->
        </div><br>

        <div class="table-responsive">

            <h3>Diarrhea Rates Past 2 Weeks</h3>
			<div id="divFortNight"></div>
<!--            <p class="text_foot">* A 0% means that out of the evaluations done during a particular month a total percentage zero was observed, 
                a blank means that no evaluations were done for a program during a particular month.</p>-->
        </div>
		
    </div>

</body>
<script>
	/*
	28th October 2017
	Define functions that will be instanciated once DOM is ready for JavaScript to run
	1. Inform the user that the process is busy.
	2. Post processing arguments are parsed to the relevant associated page. Include global variables already defined in header.php and define any relevant arguments used to distinguish the tables.
	3. Relay the data as returned by the associated files.
	*/
	
	function tableTwoDays() {
		$(divTwoDays).html('<br><br><br><h id="divDataError"><b><center>Processing Table. Please wait.</center></b></h><br><br><br>');
		$.post("+diarData.php", {
			info_type: 'two_days',
			country: <?php echo $country_val; ?>,
			year: <?php if ($year == 'All years') {
							echo '0';
						} else {
							echo $year;
						}
					?>
			}).done(function(data) {
				$('#divTwoDays').html(data);
		});
	}
	function tableFortNight() {
		$(divFortNight).html('<br><br><br><h id="divDataError"><b><center>Processing Table. Please wait.</center></b></h><br><br><br>');
		$.post("+diarData.php", {
			info_type: 'fortnight',
			country: <?php echo $country_val; ?>,
			year: <?php if ($year == 'All years') {
							echo '0';
						} else {
							echo $year;
						}
					?>
			}).done(function(data) {
				$('#divFortNight').html(data);
		});		
	}
    $(document).ready(function() {
		tableTwoDays();
		tableFortNight();
	})
</script>
</html>
<?php
mysqli_close($mysqli);
?>
