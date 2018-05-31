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
    <div class="btn-group pull-right"><br>
</div>
<div class="table-responsive" id="programdiv">
  <h4>&nbsp;</h4>
            <h3>People Served</h3>
  <p class="text_title">The People Served Table gives the average number of people served per dispenser across program geographies. 
                Information on the number of households using a waterpoint is collected during verification activities and the number of people 
  per household is estimated based on monthly evaluations of randomly selected households. The total number of dispensers is obtained from the verification data and is therefore the number of intended installation as opposed to the actual number of installation on ground.</p>

<table class="table table-bordered table-striped table-hover">
                    <tr>
                       
                    </tr>
  </table>
<table width="1000px" class="table table-bordered table-striped table-hover" id="programtable" style="width: 100%; float: left;">
                <tr>
                  <th width="22%">PROGRAM</th>
                  <th width="8%">MEDIAN</th>
                  <th width="8%">MEAN</th>
                </tr>
                <?php
                    $res = mysqli_query($mysqli, "SELECT distinct program FROM `dsw_per_verification` WHERE country='$country_val' ORDER BY 					                                        program");
                    while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                <tr>
                  <?php $prog = $row["program"];?>
                  <th><?php echo $prog; ?></th>
                  <td><?php 
				  $query= "SELECT avg_users FROM dsw_per_verification where country=$country_val and program like '$prog' and pass_fail=1 and avg_users >'' ORDER BY avg_users";
				  $result= mysqli_query($mysqli, $query) or die (mysqli_query($mysql));
				  $rows=array();
				  $i=0;
				  while($row_num= mysqli_fetch_array($result)){
				  $rows[$i++] = $row_num[0];
				  }
				  $count = mysqli_num_rows($result);
				  $mid= floor(($count-1)/2);
				  if ($count %2){
				  		$median = ceil($rows[$mid]);
				  				}else {
									  $low_value= $rows[$mid];
									  $high_value= $rows[$mid+1];
									  $median = ceil((($low_value + $high_value)/2));
									  }
				  echo "$median";
				  ?>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr><?php } ?>;
                <tr>
                  <th>Total per year</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                </tr>
              </table>
<p>&nbsp;</p>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>




