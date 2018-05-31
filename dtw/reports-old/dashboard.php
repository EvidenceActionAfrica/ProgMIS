<?php require_once('config/include.php');
	  $evidenceaction = new EvidenceAction();
	  $evidenceaction->checksession();
	  //print_r($_SESSION);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('config/head.php');?>
<title>Evidence Action :: Dashboard</title>
</head>
<body>

<div class="wrapperNwp">
	<!---------------- header start ------------------------>
    
    <?php include('config/header.php');?>
    
    <!---------------- header end ------------------------>
    
    <!---------------- body start ------------------------>
    
    <div class="rstBdy">
      <div class="inside">
    	<div class="bdyPcs">
            <ul class="allPcs">
                <li><a href="administrative_data.php"><img src="images/pic1.jpg" alt="" border="0" /></a></li>
                <li><a href="performance_data_and_reporting.php"><img src="images/pic2.jpg" alt="" border="0" /></a></li>
                <li><a href="javascript:void(0)"><img src="images/pic3.jpg" alt="" border="0" /></a></li>
                <li><a href="javascript:void(0)"><img src="images/pic4.jpg" alt="" border="0" /></a></li>
                <li><a href="javascript:void(0)"><img src="images/pic5.jpg" alt="" border="0" /></a></li>
                <li><a href="javascript:void(0)"><img src="images/pic6.jpg" alt="" border="0" /></a></li>
                <li><a href="javascript:void(0)"><img src="images/pic7.jpg" alt="" border="0" /></a></li>
            </ul>
    	</div>
    </div>
	</div>
    <!---------------- body end ------------------------>
    
</div>
</body>
</html>
