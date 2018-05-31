<?php
	
	if (isset($_POST['report_bar'])){
		$info_type = $_POST['info_type'];
		if ($info_type == 'adpt'){
			$avg = "10667";
			$tgt = "26050";
			echo $avg . "," . $tgt;
			return;
		} elseif ($info_type == 'instll'){
			$ins = "949";
			$tgt = "1000";
			echo $ins . "," . $tgt;
			return;
		} elseif ($info_type == 'PplSvd'){
			$pplsvd = "1604430";
			$tgt = "2000000";
			echo $pplsvd . "," . $tgt;
			return;
		}
	}
?>	