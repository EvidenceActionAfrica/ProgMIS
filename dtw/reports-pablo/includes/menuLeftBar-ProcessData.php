<?php
$email = $_SESSION['email'];
$level = $_SESSION['level'];
$staffid = $_SESSION['staffid'];
?>  
<h3>Treatment Forms</h3>
<h4>Entry</h4>
<ul>
  <a href="form_s.php?mstatus=tr"><li>Form_S</li></a>
  <a href="formA.php?mstatus=tr"><li>Form_A</li></a>
  <a href="formD.php?mstatus=tr"><li>Form_D</li></a>
  <a href="form_attnt.php?mstatus=tr"><li>ATTNT</li></a>
  <a href="form_mtp.php?mstatus=tr"><li>MTP</li></a>
</ul>
<h4>Upload</h4>
<ul>
  <a href="form_s_upload.php"><li>Form_S</li></a>
  <a href="form_s_uploadinterface.php"><li>Form_A</li></a>
  <a href="formD.php?mstatus=tr"><li>Form_D</li></a>
  <a href="form_attnt.php?mstatus=tr"><li>ATTNT</li></a>
  <a href="form_mtp.php?mstatus=tr"><li>MTP</li></a>
</ul>
