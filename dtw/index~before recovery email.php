<?php
// Inialize session
session_start();
// Check, if user is already login, then jump to secured page
if (isset($_SESSION['staff_email'])) {
  header('Location: home.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once("includes/meta-link-script.php"); ?>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="images/logo.png" />  </div>
      <div class="menuLinks">
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div align="center" style="min-height:220px; width: 500px; padding: 30px; margin: 30px auto; font-family: TStar-Bol">
        <font style="font-size:30px">Sign In</font>
        <hr/>
        <form id="loginForm" name="loginForm" method="post" action="login-check.php">
          <br/>
          <table width="300" border="0" align="center" cellpadding="5" cellspacing="10">
            <tr>
              <!--<td width="112"><b style="font-size:18px; font-family: TStar-Bol">Email</b></td>-->
              <td colspan="2"><input name="email" type="text" style="padding: 15px; width: 100%" id="email" placeholder="Email"/></td>
            </tr>
            <tr>
              <!--<td><b style="font-size:18px; font-family: TStar-Bol">Password</b></td>-->
              <td colspan="2"><input name="password" type="password" style="padding: 15px; width: 100%"  id="password" placeholder="Password"/></td>
            </tr>
            <tr>
              <!--<td> </td>-->
              <td align="center">                
        <a href="../" class="btnCustomLogin" style="text-decoration: none;  width: 100px">MIS Select</a>       
              </td>   
              <td align="right">
                <input type="submit" name="Submit" value="Login" class="btnCustomLogin" style="margin: 0px" />							
              </td>
              	  
            </tr>
            <tr>
             <td colspan="2" align="center" height="50px" > <a href="otherIndex.php" style="text-decoration: none; color: black">Vendor/Teacher Trainer/Master Trainer Logon</a>  </td>
           
            </tr>
    
              <tr>
         
             <td colspan="2" align="center" height="50px" > <a href="" style="text-decoration: none; color: black">Forgot your password?</a>  </td>
            </tr>
          </table>
        </form>
		
      </div>
    </div>
  </body> 
</html>
