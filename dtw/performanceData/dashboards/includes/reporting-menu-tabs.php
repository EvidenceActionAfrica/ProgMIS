<!-- this is for the nave tabs -->
<?php  $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  ?>


<div id="nav-reporting" class="col-md-5">
    <a class="btn btn-primary pink-color" href="comprehensiveAll.php" <?php if (strpos($url,'comprehensiveAll.php') !== false) { echo 'style="background-color: #4C9ED9"';} ?>>KPI'S</a>
    <a class="btn btn-primary pink-color" href="county-kpi.php" <?php if (strpos($url,'county-kpi.php') !== false) { echo 'style="background-color: #4C9ED9"';} ?> >County</a>
    <!-- <a class="btn btn-primary pink-color" href="comprehensiveEndfund.php">End Fund</a> -->
    <a class="btn btn-primary pink-color" href="district-report-ntd-sth.php"  <?php if (strpos($url,'district-report-ntd-sth.php') !== false) { echo 'style="background-color: #4C9ED9"';} ?> >NTD ALB</a>
    <a class="btn btn-primary pink-color" href="district-report-ntd-pzq.php" <?php if (strpos($url,'district-report-ntd-pzq.php') !== false) { echo 'style="background-color: #4C9ED9"';} ?>>NTD PZQ</a>
    <a class="btn btn-primary pink-color" href="comprehensiveUSAID.php" <?php if (strpos($url,'comprehensiveUSAID.php') !== false) { echo 'style="background-color: #4C9ED9"';} ?>>USAID</a>
</div>