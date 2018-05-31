<script type="text/javascript">
  function toggle(obj) {
    makeNotVisible();
    var obj = document.getElementById(obj);
    if (obj.style.display == "block")
      obj.style.display = "none";
    else
      obj.style.display = "block";
  }

  function makeNotVisible() {
    document.getElementById('Forms').style.display = "none";
    document.getElementById('Cube_Reports').style.display = "none";
  }
</script>
<?php
$email = $_SESSION['email'];
$level = $_SESSION['level'];
$staffid = $_SESSION['staffid'];
?>
<h3>ID DATA</h3>
<ul>
  <a href="districtView.php"><li>Districts</li></a>
  <a href="divisionView.php"><li>Divisions</li></a>
  <a href="schoolsView.php"><li>Schools</li></a>
</ul>
<h3>Health & Education</h3>
<ul>
  <a href="healthView.php"><li>Health</li></a>
  <a href="educationView.php"><li>Education</li></a>
</ul>
<h3>Master trainers</h3>
<ul>
  <a href="moeMtListView.php"><li>MOE Master Ts</li></a>
  <a href="mohMtView.php"><li>MOH Master Ts</li></a>
  <a href="kemriView.php"><li>Kemri Based MT</li></a>
  <a href="masterTrainerView.php"><li>Master Trainers</li></a>
</ul>
<h3>Treatment Forms</h3>
<ul>
  <a href="form_s.php"><li>Form_S</li></a>
  <a href="formA.php"><li>Form_A</li></a>
  <a href="formD.php"><li>Form_D</li></a>
  <a href="form_attnt.php"><li>ATTNT</li></a>
  <a href="form_mtp.php"><li>MTP</li></a>
</ul>