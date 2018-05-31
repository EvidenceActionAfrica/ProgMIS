<?php include('config/include.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('config/head.php');?>
<title>Evidence Action :: Forgot Password</title>
</head>
<?php
if(isset($_POST['checklogin']) && !empty($_POST['checklogin']) && ($_POST['checklogin']=='checklogin')){
    $email = $_POST['email'];
 	$evidenceaction = new EvidenceAction();
	$tablename = 'user';
	$fields = 'id, firstname, lastname';
	$where = "email = '".$email."'";
	$rows = $evidenceaction->selectrow($tablename, $fields, $where);
	if (isset($rows['id']) && !empty($rows['id'])) {
		$msg = 'Dear '.$rows['firstname'].' '.$rows['lastname'].'<br /><br />Please click the below link to reset toy password<br /><a href="">change_password.php</a>';
	} else{
        $_SESSION['err_msg'] = 'Email Address is not found.';
    }
}
?>
<body>
<div class="wrapper">
	<!---------------- header start ------------------------>
    <?php include('config/header.php');?>
	<!---------------- header end ------------------------>
    
    <!---------------- body start ------------------------>
    
    <div class="bdyPrt">
        <form id="form-login" action=""  class="formular" method="post">
		<input type="hidden" name="checklogin" value="checklogin" />
                <div class="frmHldr">
                    <h1>Forgot Password</h1>
					<?php if(isset($_SESSION['err_msg'])): ?>
            	 <div style="color:#FF0000; margin:0 0 5px 0;"><?php echo $_SESSION['err_msg']; unset($_SESSION['err_msg']); ?></div>
                 <?php endif; ?>
                    <div class="frmPrt">
                        
                            <div class="frmRw">
                                Enter your Email Address below
                            </div>
                            <div class="frmRw">
                                <input type="email" name="email" id="email" class="inptBx" placeholder="Enter Email Address Here" />
                            </div>
                            <div class="frmRw tpGp">
                                <div class="rmbr">&nbsp;</div>
                                <div class="sbmt"><input name="go" type="submit" value="Get Password" class="sbBtn" /></div>
                                <div class="clearFix"></div>
                            </div>
                        
                    </div>
                </div>
        </form>	
    
    </div>
    <!---------------- body end ------------------------>
    
</div>
</body>
</html>
