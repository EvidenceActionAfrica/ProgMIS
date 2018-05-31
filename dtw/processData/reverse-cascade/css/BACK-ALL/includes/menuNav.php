<nav>
  <ul>
    <li><a href="../../home.php">HOME</a></li>
    <li><a href="../../adminData.php">ADMIN DATA</a></li>
    <li><a href="../index.php">PROCESS DATA</a></li>
    <li> <a href="../../performaceData/performance-menu.php">PERFORMANCE DATA</a>  </li>
  </ul>
  <div style="float: right; width: 25%">
    <div align="center" style="margin: 0px auto; /*border: 1px solid grey;*/ padding: 10px; margin-top: -10px">
      <?php
      echo '
        <TABLE style="font-family: TStar-Reg; color: #EF637D">
        <thead>
            <th></th>
          <th align="left" style="padding-left:10px; font-size: 14px">
            ' . $_SESSION['staff_name'] . '<br/>
            ' . $_SESSION['staff_role'] . '<br/>
            <a href="logout.php" align="left" style="font-size: 14px">Log Out</a>
          </th>
        </thead>
        </TABLE>';
      ?>
    </div>
  </div>
</nav>