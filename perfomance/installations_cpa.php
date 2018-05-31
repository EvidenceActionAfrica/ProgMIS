<?php
include ('header.php');
require_once("csv_upload/upload_csv/class.image.php");
require_once("csv_upload/upload_csv/class.insert.php");
?>
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
<form id="logform1"  method="$_POST" style='float: left'>  

  <input class="btn btn-primary" type="submit" name="submit_view" id="submit_view" value="PER INSTALLATION ROUND" formaction="installations.php">
  <input class="btn btn-primary" type="submit" name="submit_view" id="submit_view" value="PER DISTRICT" formaction= "installations_district.php">
  <input class="btn btn-primary" type="submit" name="submit_view" id="submit_view" value="PER CPA">
</form>
    <p><br>
</p>
<div class="table-responsive" id="programdiv">
                <h4>&nbsp;</h4>
                <h4>Installations Table</h4>
  <p class="text_title"> This table displays the number of dispensers installed and recorded in the dispenser database. A dispenser is only added to the dispenser database once it has verified proram geography information, a valid waterpoint ID , a valid dispenser barcode and a verified installation and CEM date. <strong>The table was last updated 31 August 2017</strong>.
  <p>
  <table class="table table-bordered table-striped table-hover">
                    <tr>
                       
                    </tr>
  </table>
              <table width="10%" class="table table-bordered table-striped table-hover" id="districttable" style="width: 100%; float: left;">
                <tr>
                  <th width="20%">Carbon Allocation</th>
                  <th colspan="10">Number of dispenser installation records</th>
                  </tr>
                  <tr>
                  <th></th>
                  <th width="8%">2010</th>
                  <th width="8%">2011</th>
                  <th width="8%">2012</th>
                  <th width="8%">2013</th>
                  <th width="8%">2014</th>
                  <th width="8%">2015</th>
                  <th width="8%">2016-Q1</th>
                  <th width="8%">2016-Q2</th>
                  <th width="8%">2016-Q3</th>
                  <th width="8%">2016-Q4</th>
                  <th width="10%"><strong>Total</strong></th>
                </tr>
                <?php
                    $prog_sum = 0;
                    $av_div_prog = 0;
                    $res = mysqli_query($mysqli, "SELECT distinct carbon_status FROM `dispenser_database` WHERE country='$country_val' ORDER BY carbon_status");
                    while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                <tr>
                  <?php $cpa = $row["carbon_status"]; 						
				  ?>
                  <th><?php echo $cpa; ?></th>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE carbon_status = '$cpa' AND country='$country_val' and              							`year` like '2010'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $disnum = mysqli_num_rows($result);
								if ($disnum>0){echo "$disnum";} else echo "";
                                ?>                  </td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE carbon_status = '$cpa' AND country='$country_val' and              							`year` like '2011'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $disnum1 = mysqli_num_rows($result);
								if ($disnum1>0){echo "$disnum1";} else echo "";
                                ?>                  </td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE carbon_status = '$cpa' AND country='$country_val' and              							`year` like '2012'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $disnum2 = mysqli_num_rows($result);
								if ($disnum2>0){echo "$disnum2";} else echo "";
                                ?>                  </td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE carbon_status = '$cpa' AND country='$country_val' and              							`year` like '2013'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $disnum3 = mysqli_num_rows($result);
								if ($disnum3>0){echo "$disnum3";} else echo "";
                                
                                ?>&nbsp;</td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE carbon_status = '$cpa' AND country='$country_val' and            							`year` like '2014'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $disnum4 = mysqli_num_rows($result);
								if ($disnum4>0){echo "$disnum4";} else echo "";
                                
                                ?>                    &nbsp;</td>
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE carbon_status = '$cpa' AND country='$country_val' and            							`year` like '2015'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $disnum5 = mysqli_num_rows($result);
								if ($disnum5>0){echo "$disnum5";} else echo "";
                                
                                ?>                    &nbsp;</td>                                
                  <td><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE carbon_status = '$cpa' AND country='$country_val' and              							( month > 0 AND month < 4) and `year` like '2016'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $disnum6 = mysqli_num_rows($result);
								if ($disnum6>0){echo "$disnum6";} else echo "";
                                
                                ?>                    &nbsp;</td>
                  <th><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE carbon_status = '$cpa' AND country='$country_val' and              							( month > 3 AND month < 7 ) and `year` like '2016'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $disnum7 = mysqli_num_rows($result);
								if ($disnum7>0){echo "$disnum7";} else echo "";
                                
                                ?></th>
                   <th><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE carbon_status = '$cpa' AND country='$country_val' and              							( month > 6 AND month < 10 ) and `year` like '2016'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $disnum8 = mysqli_num_rows($result);
								if ($disnum8>0){echo "$disnum8";} else echo "";
                                
                                ?></th>
                   <th><?php
                                $field = 'cem301_attendees_total';
                                $query = "SELECT * FROM dispenser_database WHERE carbon_status = '$cpa' AND country='$country_val' and              							( month > 9 AND month < 13 ) and `year` like '2016'";
                                $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                                $disnum9 = mysqli_num_rows($result);
								if ($disnum9>0){echo "$disnum9";} else echo "";
                                
                                ?></th>
                   <th><strong>
                     <?php 
				  $total2= array($disnum, $disnum1, $disnum2, $disnum3 ,$disnum4 ,$disnum5, $disnum6, $disnum7, $disnum8, $disnum9);
				  echo "".array_sum($total2);
				  ?>
                   </strong></th>

                </tr>
                <?php }
                    ?>
                <tr>
                  <th>Total per year</th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and year like '2010'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and year like '2011'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and year like '2012'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and year like '2013'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and year like '2014'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and year like '2015'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and ( month > 0 AND month < 4 ) and year like '2016'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                            
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and ( month > 3 AND month < 7 ) and year like '2016'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and ( month > 6 AND month < 10 )and year like '2016'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
                            ?></th>
                  <th><?php
                            $query = "SELECT * FROM dispenser_database WHERE country='$country_val' and ( month > 9 AND month < 13 )and year like '2016/'";
                            $result = mysqli_query($mysqli, $query) or die(mysqli_query($mysqli));
                            $total = mysqli_num_rows($result);
							//$total = array_sum($prognum);
							echo "$total";
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

  
  
