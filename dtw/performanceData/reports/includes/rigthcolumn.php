<?php
require_once('includes/config.php');
$date = date('Y-m-d');
$sess_email = $_SESSION['email'];
$sess_name = $_SESSION['name'];
$level = $_SESSION['level'];
$sess_role = $_SESSION['role'];
$sess_title = $_SESSION['title'];
$sess_staffid = $_SESSION['staffid'];
?>
<div id="right_sidebar">
  <a href="logout.php"><h4>Log-in Info (log-out)</h4></a>
  <?php
  $query = mysql_query("SELECT * FROM staff WHERE email='$email' LIMIT 1");
  if ($query) {
    while ($row = mysql_fetch_array($query)) {
      echo '
					<TABLE>
					<thead>
						<th ROWSPAN=2><img height="60px" width="60px" src="images/staff/' . $row['image'] . '"></th>
              <th><t/h>
						<th>
              ' . $row['name'] . '<br/>
              ' . $row['role'] . '<br/>
              <a href="logout.php" align="right"><span class="l"></span><span class="r"></span><span class="t">Log Out</span></a>
            </th>
					</thead>
					</TABLE>';
    }
  }
  ?><hr>

  <h4>Events Calendar</h4>

  <div class="art-block">
    <div class="art-block-body">
      <div class="art-blockheader">
        <?php
        include("classes/CalenderShowc.php");
        $obj = new CalenderShowc();
        echo $obj->showCalender();
        ?>
      </div>
      <div class="schedule"></div>
    </div>
  </div>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>

  <center>
    <u><b style="font-size: 18px">Status ID key</b></u>
    <font style="font-size: 15px;font-weight: normal;">
    <table>
      <thead><th align='left'>0</th><th align='left'>- Enquiry done</th></thead>
      <thead><th align='left'>1 </th><th align='left'>- Scheduled for pre-survey</th></thead>
      <thead><th align='left'>2</th><th align='left'>- Post-survey done</th></thead>
      <thead><th align='left'>3</th><th align='left'>- Costing1 done</th></thead>
      <thead><th align='left'>4</th><th align='left'>- Quotation1 sent</th></thead>
      <thead><th align='left'>5</th><th align='left'>- Costing2 done</th></thead>
      <thead><th align='left'>6</th><th align='left'>- Quotation2 sent</th></thead>
      <thead><th align='left'>7</th><th align='left'>- Booking Order1 done</th></thead>
      <thead><th align='left'>8</th><th align='left'>- Booking Order2 done</th></thead>
      <thead><th align='left'>9</th><th align='left'>- Removal report done</th></thead>
      <thead><th align='left'>10</th><th align='left'>- Delight score filled</th></thead>
      <thead><th align='left'>11</th><th align='left'>- Complaints</th></thead>
      <thead><th align='left'>12</th><th align='left'>- Move complete</th></thead>
      <thead><th align='left'>00</th><th align='left'>- Pre-survey canceled</th></thead>
    </table>
    </font>
    <img src="images/boxes.png" style="padding:10px" height="120px" width="auto"/>
    <img src="images/boxes.png" style="padding:10px" height="120px" width="auto"/>
  </center>
</div> <!--end right_sidebar-->

