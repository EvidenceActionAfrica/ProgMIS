<div style="float: right; width: 25%">
  <div align="center" style="margin: 0px auto; border: 1px solid grey; padding: 10px; margin-top: -10px">
    <!--<a href="logout.php"><h4>Log-in Info (log-out)</h4></a>-->
    <?php
    $query = mysql_query("SELECT * FROM staff WHERE email='$email' LIMIT 1");
    if ($query) {
      while ($row = mysql_fetch_array($query)) {
        echo '
					<TABLE style="font-family: TStar-Bol">
					<thead>
						<th ROWSPAN=2><img height="60px" width="60px" src="images/staff/' . $row['image'] . '"></th>
              <th><t/h>
						<th align="left" style="padding-left:10px">
              ' . $row['name'] . '<br/>
              ' . $row['role'] . '<br/>
              <a href="logout.php" align="right"><span class="l"></span><span class="r"></span><span class="t">Log Out</span></a>
            </th>
					</thead>
					</TABLE>';
      }
    }
    ?>
  </div>
</div>