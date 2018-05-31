
<?php
$staff_email = $_SESSION['staff_email'];
$staff_level = $_SESSION['staff_level'];
$staff_id = $_SESSION['staff_id'];

$resPriv = mysql_query("select * from staff where staff_email='$priv_mail'");

while ($row = mysql_fetch_array($resPriv)) {
  $priv_dropdowns = $row["priv_dropdowns"];
}
?>

<h3>Programme Geographies</h3>
<ul>
   <?php  $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  ?>
  <a href="counties.php"><li <?php if (strpos($url,'counties') !== false) { echo 'class="linkActive"';} ?> >Counties</li></a>
  <a href="districts.php"><li <?php if (strpos($url,'districts') !== false) { echo 'class="linkActive"';} ?> >Sub Counties</li></a>
  <a href="divisions.php" ><li <?php if (strpos($url,'divisions.php') !== false) { echo 'class="linkActive"';} ?>>Divisions</li></a>
  <a href="schools.php"  ><li <?php if (strpos($url,'schools') !== false) { echo 'class="linkActive"';} ?>  >Schools</li></a>
</ul>
<br/>
<h3>Contact Details</h3>
<ul>
   <a href="county_contacts.php"><li <?php if (strpos($url,'county_contacts') !== false) { echo 'class="linkActive"';} ?> >County Contacts</li></a>
   <a href="health_contacts.php"><li <?php if (strpos($url,'health_contacts') !== false) { echo 'class="linkActive"';} ?> >MoH Sub County</li></a>
   <a href="education_contacts.php"><li <?php if (strpos($url,'education_contacts') !== false) { echo 'class="linkActive"';} ?> >MoEST Sub County</li></a>
  <a href="masterTrainers.php"><li <?php if (strpos($url,'masterTrainers.php') !== false) { echo 'class="linkActive"';} ?> >MT National</li></a> 
 <a href="masterTrainersCounty.php"><li <?php if (strpos($url,'masterTrainersCounty') !== false) { echo 'class="linkActive"';} ?> >MT County</li></a>
  <a href="headteachers.php"><li <?php if (strpos($url,'headteachers') !== false) { echo 'class="linkActive"';} ?> >Head Teachers </li></a>
  <a href="pharmacist_contacts.php"><li <?php if (strpos($url,'pharmacist_contacts') !== false) { echo 'class="linkActive"';} ?> >MoH(Pharmacist)</li></a> 
    <a href="chrio_contacts.php">
    <li <?php if (strpos($url,'chrio_contacts') !== false) { echo 'class="linkActive"';} ?> >CHRIO</li>
    </a> 
</ul>
<br/>
<h3>Program Governance Contacts</h3>
<ul>

 <a href="steering.php"><li <?php if (strpos($url,'steering') !== false) { echo 'class="linkActive"';} ?> >Steering Committee</li></a>
 <a href="mgmt_team.php"><li <?php if (strpos($url,'mgmt_team') !== false) { echo 'class="linkActive"';} ?> >Management Team</li></a>
 
 
</ul>
<br/>
<hr/>
<br/>
<br/>
<?php

if($priv_dropdowns>=100){
?>
<a href="dropdown_settings.php"><li <?php if (strpos($url,'minstry_dd') !== false) { echo 'class="linkActive"';} ?> >
  <b style="font-size: 13px; text-decoration: none">Drop-down Settings</b>
</a>

<?php
}
?>
<br/>
