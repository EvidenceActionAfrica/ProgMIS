<?php 
// Inialize session
session_start();
// Check, if user is already login, then jump to secured page
if (isset($_SESSION['email'])) {
  header('Location: home.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <link rel="stylesheet" href="files/style.css" type="text/css"/>
        <script type="text/javascript" src="files/jquery-1.js"></script>
        <title>Evidence Action</title>
        </head>
        <body>
          <div class="wrapperNwp">
            <!---------------- header start ------------------------>
            <div class="header">
              <div class="hdmnCnt">
                <div class="logo"><a href="#"><img src="files/logo.png" alt="Evidence Action" border="0"></a></div>
                <div class="clearFix"></div>
              </div>
            </div>

            <!---------------- body start ------------------------>
            <div class="rstBdy" style="background-color: #E7E3E0">
              <div class="inside">
                <form id="form-login" action="dashboard.html" class="formular" method="post">
                  <input name="checklogin" value="checklogin" type="hidden">
                    <div class="frmHldr">
                      <h1>Sign In</h1>
                      <div class="frmPrt">

                        <div class="frmRw">
                          <input name="username" id="req" class="inptBx" placeholder="Username" value="paul" type="text">
                        </div>
                        <div class="frmRw">
                          <input name="pass" id="pass" class="inptBx" placeholder="Password" value="123456" type="password">
                        </div>
                        <div class="frmRw tpGp">
                          <div class="rmbr"><input name="remember" value="1" checked="checked" type="checkbox"> Remember me</div>
                          <div class="sbmt"><input name="go" value="Sign In" class="sbBtn" type="submit"></div>
                          <div class="clearFix"></div>
                        </div>

                      </div>
                    </div>
                    <div class="frgtPas"><a href="">Forgot your password?</a></div>
                </form>	

              </div>
            </div>
            <!---------------- body end ------------------------>

          </div>


        </body></html>