
<?php
$email = $_SESSION['email'];
$level = $_SESSION['level'];
$staffid = $_SESSION['staffid'];
?>

<nav>
  <ul>
    <li><a href="home.php">HOME</a></li>
    <li>
      <a href="forms.php">ADMINISTRATIVE DATA</a>
      <ul>
        <li><a href=""><img src="images/menu-line.png"></a></li>
        <li><a href="forms.php">ID data</a></li>
        <li><a href="forms.php">Educational & Health Data</a></li>
        <li><a href="forms.php">Master Trainer Data</a></li>
      </ul>
    </li>
    <li>
      <a href="#">PROCESS DATA</a>
      <ul>
        <li><a href=""><img src="images/menu-line.png"/></a></li>
        <li><a href="#">Planning</a></li>
        <li><a href="#">Scheduling </a></li>
        <li><a href="#">Tracking</a></li>
      </ul>
    </li>
    <li>
      <a href="#">PERFORMANCE DATA</a>
      <ul>
        <li><a href=""><img src="images/menu-line.png"/></a></li>
        <li><a href="#">Standardized Reports</a></li>
        <li><a href="reports/performance_data.php">On Demand Reports</a></li>
        <li><a href="#">Export Data</a></li>
      </ul>
    </li>
  </ul>
</nav>