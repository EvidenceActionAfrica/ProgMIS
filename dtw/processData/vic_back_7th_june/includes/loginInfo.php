<div style="float: right; width: 25%">
  <div align="center" style="margin: 0px auto; /*border: 1px solid grey;*/ padding: 10px; margin-top: -10px">
    <?php 
    if (!isset($display_db_year)) {
      $display_db_year="";
    }
    echo '
        <TABLE style="font-family: TStar-Reg; color: #EF637D">
        <thead>
            <th></th>
          <th align="left" style="padding-left:10px; font-size: 14px">
           <a class="no-decoration" href="choose-year.php">'.$display_db_year.'</a>
            ' . $_SESSION['staff_name'] . '<br/>
            ' . $_SESSION['staff_role'] . '<br/>
            <a href="logout.php" align="left" style="font-size: 14px">Log Out</a>
          </th>
        </thead>
        </TABLE>';
    ?>
  </div>
</div> 





<!--old login-check with user image-->
<!--<div style="float: right; width: 25%">
  <div align="center" style="margin: 0px auto; /*border: 1px solid grey;*/ padding: 10px; margin-top: -10px">
    <a href="logout.php"><h4>Log-in Info (log-out)</h4></a>
<?php
//$sess_email = $_SESSION['staff_email'];
//$query = mysql_query("SELECT * FROM staff WHERE staff_email='$staff_email' LIMIT 1");
//if ($query) {
//  while ($row = mysql_fetch_array($query)) {
//    echo '
//					<TABLE style="font-family: TStar-Reg; color: #EF637D">
//					<thead>
//						<th ROWSPAN=2><img height="60px" width="60px" src="images/staff/' . $row['image'] . '"></th> 
//              <th></th>
//						<th align="left" style="padding-left:10px; font-size: 14px">
//              ' . $_SESSION['staff_name'] . '<br/>
//              ' . $_SESSION['staff_role'] . '<br/>
//              <a href="logout.php" align="left" style="font-size: 14px">Log Out</a>
//            </th>
//					</thead>
//					</TABLE>';
//  }
//}
?>
  </div>
</div>-->