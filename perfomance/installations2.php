<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");
?>
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	width:438px;
	height:20px;
	z-index:1;
	left: 102px;
	top: 775px;
}

-->
</style>

<div class="row">
    <div class="col-md-2">
        <div class="sidebar">
          <?php require_once ('includes/left_bar.php'); ?>
        </div>
  </div>
    <div class="col-md-10">
      <ul class="list-unstyled list-inline" >
      <p>
        </p>
    </ul>
    <div class="btn-group pull-right"></div>
<form id="logform1"  method="$_POST" style='float: left' action="installations_district.php">  

  <input class="btn btn-primary" type="submit" name="submit_view" id="submit_view" value="CHANGE VIEW to PER DISTRICT">
</form>
    <p><br>
</p>
<div class="table-responsive" id="programdiv">
                <h4>&nbsp;</h4>
                <h4>Installations Table</h4>
  <p class="text_title"> This table displays the number of dispensers installed and recorded in the dispenser database. A dispenser is only added to the dispenser database once it has verified proram geography information, a valid waterpoint ID , a valid dispenser barcode and a verified installation and CEM date; and the database updated every 15th date of each new month.
  <p>

<table class="table table-bordered table-striped table-hover">
                    <tr>
                       
                    </tr>
  </table>
              <table width="100%" class="table table-bordered table-striped table-hover" id="programtable" style="width: 50%; float: left;">
                <tr>
                  <th width="25%">Program</th>
                  <th colspan ="10" align="center"> Number of dispenser installation records</th>
                </tr>
                <tr>
                  <th>&nbsp;</th>
                  <th>2010</th>
                  <th>2011</th>
                  <th>2012</th>
                  <th>2013</th>
                  <th>2014</th>
                  <th>2015-Q1</th>
                  <th>2015-Q2</th>
                  <th>2015-Q3</th>
                  <th>2015-Q4</th>
                  <th><strong>Total</strong></th>
                </tr>
                <?php
                    $prog_sum = 0;
                    $av_div_prog = 0;
                    $res = mysqli_query($mysqli, "SELECT distinct program_name FROM `dispenser_database` WHERE country='$country_val' ORDER BY program_name");
                    while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                <tr>
                  <?php $prog = $row["program_name"]; 						
				  ?>
                  <th><?php echo $prog; ?></th>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE program_name = '$prog' AND country='$country_val' and              							`installation_date` like '2010/%'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $prognum = mysqli_num_rows($result);
								if ($prognum>0){echo "$prognum";} else echo "";
                                ?>                  </td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE program_name = '$prog' AND country='$country_val' and              							`installation_date` like '2011/%'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $prognum1 = mysqli_num_rows($result);
								if ($prognum1>0){echo "$prognum1";} else echo "";
                                ?>                  </td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE program_name = '$prog' AND country='$country_val' and              							`installation_date` like '2012/%'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $prognum2 = mysqli_num_rows($result);
								if ($prognum2>0){echo "$prognum2";} else echo "";
                                ?>                  </td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE program_name like '$prog%' AND country='$country_val' and              							`installation_date` like '2013/%'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $prognum3 = mysqli_num_rows($result);
								if ($prognum3>0){echo "$prognum3";} else echo "";
                                
                                ?>&nbsp;</td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE program_name like '$prog%' AND country='$country_val' and              							`installation_date` like '2014/%'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $prognum4 = mysqli_num_rows($result);
								if ($prognum4>0){echo "$prognum4";} else echo "";
                                
                                ?>&nbsp;</td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE program_name like '$prog' AND country='$country_val' and              							( month > 0 AND month < 4 ) and `installation_date` like '2015/%'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $prognum5 = mysqli_num_rows($result);
								if ($prognum5>0){echo "$prognum5";} else echo "";
                                
                                ?>&nbsp;</td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE program_name like '$prog' AND country='$country_val' and              							( month > 3 AND month < 7 ) and `installation_date` like '2015/%'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $prognum6 = mysqli_num_rows($result);
								if ($prognum6>0){echo "$prognum6";} else echo "";
                                
                                ?></td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE program_name like '$prog' AND country='$country_val' and              							( month > 6 AND month < 10 ) and `installation_date` like '2015/%'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $prognum7 = mysqli_num_rows($result);
								if ($prognum7>0){echo "$prognum7";} else echo "";
                                
                                ?></td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE program_name like '$prog' AND country='$country_val' and              							( month > 9 AND month < 13 ) and `installation_date` like '2015/%'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $prognum8 = mysqli_num_rows($result);
								if ($prognum8>0){echo "$prognum8";} else echo "";
                                
                                ?></td>
                  <th><strong>
                  <?php 
				  $total2= array($prognum, $prognum1, $prognum2, $prognum3 ,$prognum4 ,$prognum5);
				  echo "".array_sum($total2);
				  ?>
                  </strong></th>
                </tr>
                <?php }
                    ?>
                <tr>
                  <th>Total per year</th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and installation_date like '2010/%'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and installation_date like '2011/%'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and installation_date like '2012/%'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and installation_date like '2013/%'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and installation_date like '2014/%'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and              											   										( month > 0 AND month < 4 ) and `installation_date` like '2015/%'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							echo "$total"
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and              											   										( month > 3 AND month < 7 ) and `installation_date` like '2015/%'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							echo "$total"
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and              											   										( month > 6 AND month < 10 ) and `installation_date` like '2015/%'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							echo "$total"
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and              											   										( month > 9 AND month < 13 ) and `installation_date` like '2015/%'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							echo "$total"
                            ?></th>
                  <th><strong>
                  <?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?>
                  </strong></th>
                </tr>
              </table>
<p>&nbsp;</p>
</div>
<p>&nbsp;</p>
  <p>&nbsp;</p>

