<?php
$tabActive = "tab1";
?>


<!-- <script type="text/javascript" src="css/bootstrap/bootstrap.css"></script> -->
<!-- <link rel="stylesheet" href="css/bootstrap/bootstrap.css"  type="text/css" media="screen" />
<script type="text/javascript" src="css/bootstrap/bootstrap-tab.js"></script>
 -->
<?php 
  include "includes/meta-link-script.php";
 ?>
<a class="btn btn-success">fg</a>

<!--tab skeleton-->
<div class="tabbable" >
  
  <ul class="nav nav-pills">
    <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Tab 1</a></li>
    <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">Tab 2</a></li>
    <li class="<?php if ($tabActive == 'tab3') echo 'active'; ?>"><a href="#tab3" data-toggle="tab">Tab 3</a></li>
  </ul>
  <div class="tab-content">
    <!--tab 1-->
    <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
      tab 1 contents
    </div>
    <!--tab 2-->
    <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
      tab 2 contents
    </div>
    <!--tab 3-->
    <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
      tab 3 contents
    </div>
  </div>
</div>

