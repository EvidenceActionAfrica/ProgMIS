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
</div>
<div class="col-md-9 col-md-offset-2">
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















