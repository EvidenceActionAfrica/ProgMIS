<?php
$email = $_SESSION['staff_email'];
$level = $_SESSION['staff_level'];
$staffid = $_SESSION['staff_id'];

if ($isReverse == true) {
    $finLink = '../../finance/index.php';
    $loglink = '../';
    $revLink = '';
} else if (isset($islog) && $islog == true) {
    $finLink = '../finance/index.php';
    $loglink = '';
    $revLink = 'reverse-cascade/';
} else {
    $finLink = '';
    $loglink = '../processData/';
    $revLink = '../processData/reverse-cascade/';
}
?>  
<h3>Budget Types</h3>
<ul>
    <li><a href="<?php echo $finLink; ?>?view=budget&amp;cat=county">County Budgets</a></li>
    <li><a href="<?php echo $finLink; ?>?view=budget&amp;cat=district">Sub-County Training</a></li>
    <li><a href="<?php echo $finLink; ?>?view=budget&amp;cat=teacher">Teacher Training</a></li>
    <li><a href="<?php echo $finLink; ?>?view=budget&amp;cat=chew">CHEW</a></li>
    <li><a href="<?php echo $finLink; ?>?view=budget&amp;cat=dday">Deworming Day</a></li>
    <li><a href="<?php echo $finLink; ?>?view=budget&amp;cat=mt">MT Training</a></li>
</ul>
<br/>
<h3>Budget Requests</h3>
<ul>
    <li><a href="<?php echo $finLink; ?>?view=budget-form&amp;form-type=imprest">Imprest Requests</a></li>
    <li><a href="<?php echo $finLink; ?>?view=budget-form&amp;form-type=cheque">Cheque Requests</a></li>
    <li><a href="<?php echo $finLink; ?>?view=cheque-tracking&amp;form-type=cheque">Request Tracking</a></li>
</ul>
<br/>
<h3>Budget Returns</h3>
<ul>
    <li><a href="<?php echo $finLink; ?>?view=budget-form&amp;form-type=recon">Reconcilliation Returns</a></li>
    <li><a href="<?php echo $finLink; ?>?view=recon-tracking&amp;form-type=recon">Returns Tracking</a></li>
    <li><a href="<?php echo $finLink; ?>?view=recon-report">Returns Report</a></li>
    <li><a href="<?php echo $finLink; ?>?view=refund-tracking">Refunds Tracking</a></li>
</ul>
<h3>Forms Returns</h3>
<ul>
    <li><a href="../processData/dispatchTransport.php">Dispatch Transport</a></li>
    <li><a href="../processData/dispatchCHC.php">Dispatch CHC</a></li>    
    <li><a href="../processData/document_intake_log.php">Document Intake Log</a></li>
   <!---
    <li><a href="<?php echo $revLink; ?>return-county.php">County Returns</a></li>
    <li><a href="<?php echo $revLink; ?>return-status.php">Sub County Returns</a></li>
    -->
</ul>