<?php require_once('config/include.php');
$evidenceaction = new EvidenceAction();
$evidenceaction->notchecksession();
if(isset($_POST['checklogin']) && !empty($_POST['checklogin']) && ($_POST['checklogin']=='checklogin')){
    $user_name = $_POST['username'];
 	$password  = md5($_POST['pass']);
	$tablename = 'user';
	$fields = 'id, firstname, lastname';
	$where = "username = '".$user_name."' AND password = '".$password."'";
	$rows = $evidenceaction->selectrow($tablename, $fields, $where);
	if (isset($rows['id']) && !empty($rows['id'])) {
        $_SESSION['admin_id']       =   $rows['id'];
        $_SESSION['admin_name']     =   $rows['firstname'].' '.$rows['lastname'];
		if($_POST['remember']) {
			$hour =  time() + 31536000;
			setcookie('admin_username', $user_name, $hour);
			setcookie('admin_password', $_POST['pass'], $hour);
		}
		elseif(!$_POST['remember']) {
			if(isset($_COOKIE['admin_username'])) {
				$past = time() - 100;
				setcookie('admin_username', gone, $past);
				setcookie('admin_password', gone, $past);
			}
		}
        header('Location:dashboard.php');
		exit();
    } else{
        $_SESSION['err_msg'] = 'Username or password is not correct.';
    }
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('config/head.php');?>
<title>Evidence Action :: Sign In</title>
</head>
<body>
<div class="wrapperNwp">
	<!---------------- header start ------------------------>
    <?php include('config/header.php');?>
	<!---------------- header end ------------------------>
    
    <!---------------- body start ------------------------>
    
    <div class="rstBdy">
      <div class="inside">
    
        <form id="form-login" action=""  class="formular" method="post">
		<input type="hidden" name="checklogin" value="checklogin" />
                <div class="frmHldr">
                    <h1>Sign In</h1>
					<?php if(isset($_SESSION['err_msg'])): ?>
            	 <div style="color:#FF0000; margin:0 0 5px 0;"><?php echo $_SESSION['err_msg']; unset($_SESSION['err_msg']); ?></div>
                 <?php endif; ?>
                    <div class="frmPrt">
                        
                            <div class="frmRw">
                                <input type="text" name="username" id="req" class="inptBx" placeholder="Username" value="<?php if(isset($_COOKIE['admin_username']) && !empty($_COOKIE['admin_username'])){echo $_COOKIE['admin_username'];} ?>" />
                            </div>
                            <div class="frmRw">
                                <input type="password" name="pass" id="pass" class="inptBx" placeholder="Password" value="<?php if(isset($_COOKIE['admin_password']) && !empty($_COOKIE['admin_password'])){echo $_COOKIE['admin_password'];} ?>" />
                            </div>
                            <div class="frmRw tpGp">
                                <div class="rmbr"><input name="remember" type="checkbox" value="1" <?php if(isset($_COOKIE['admin_username'])) { echo 'checked="checked"'; }else{echo '';}?>  /> Remember me</div>
                                <div class="sbmt"><input name="go" type="submit" value="Sign In" class="sbBtn" /></div>
                                <div class="clearFix"></div>
                            </div>
                        
                    </div>
                </div>
                <div class="frgtPas"><a href="forgot_password.php">Forgot your password?</a></div>
        </form>	
    
    </div>
	</div>
    <!---------------- body end ------------------------>
    
</div>
</body>
</html>
