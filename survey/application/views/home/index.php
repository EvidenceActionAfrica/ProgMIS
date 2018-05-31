<div class="col-md-9 col-md-offset-2" style=" margin-top: 3%;">
    <div class="row">
        <?php
        if (isset($_GET['message'])) {
            echo '<div  class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert">
  <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span class="text-center" >' . $_GET['message'] . '</span></div>';
        }
        ?>

        <!-- <div class="clearfix"></div> -->
    </div>
    <!--<div class="menu-box menu-box-wide2 bg-lighterGreen">wisteria-->
    <div class="menu-box menu-box-wide2 bg-pink">
        <h4>Admin Data</h4>
        <a href="<?php echo URL; ?>adminData/"><img class="img img-responsive" src="<?php echo URL ?>public/img/assets.png"></a>
    </div>
    <div class="menu-box menu-box-wide2 bg-navy-blue">
        <h4>Process Data</h4>
        <a href="<?php echo URL; ?>processdata/"><img class="img img-responsive" src="<?php echo URL ?>public/img/processData.png"></a>
    </div>
    <div class="menu-box menu-box-wide2 bg-lighterGreen">
        <h4>Performance Data</h4>
        <a href="<?php echo URL; ?>/../../perfomance/view_adop.php"><img class="img img-responsive" src="<?php echo URL ?>public/img/reports.png"></a>
    </div>





</div>
<div class="col-md-9 col-md-offset-2">
    <div class="menu-box menu-box-wide2 bg-blue">
        <h4>Issue Tracking</h4>
        <a href="<?php echo URL; ?>issuetracker/viewApproved/No/1"><img class="img img-responsive" src="<?php echo URL ?>public/img/tracking.png"></a>
    </div>
    <div class="menu-box menu-box-wide2 bg-brown">
        <h4>System Settings</h4>
        <a href="<?php echo URL; ?>systemsetting/index/admin_log_record"><img class="img img-responsive" src="<?php echo URL ?>public/img/settings.png"></a>
    </div>    
    <div class="menu-box menu-box-wide2 bg-black">
        <h4>User Account Settings</h4>
        <a href="<?php echo URL; ?>uasettings"><img  class="img img-responsive" src="<?php echo URL ?>public/img/users.png"></a>
    </div>

<!--    <a href="<?php echo URL; ?>"><div class="menu-box menu-box-short bg-brown">
            <h4>Planning & Scheduling</h4>
            <img class="img img-responsive" src="<?php echo URL ?>public/img/planning.png">
        </div></a>-->

<!--    <a href="<?php echo URL; ?>"><div class="menu-box menu-box-short bg-blue">
            <h4>Communication</h4>
            <img  class="img img-responsive" src="<?php echo URL ?>public/img/communication.png">
        </div></a>-->



</div>
<div class="col-md-9 col-md-offset-2">
    <div class="menu-box menu-box-wide2 bg-lighterGreen">
        <h4>Survey Inventory & Tracker</h4>
        <a href="<?php echo URL; ?>surveytracker/viewApproved/No/1"><img class="img img-responsive" src="<?php echo URL ?>public/img/planning.png"></a>
    </div>
 
</div>















