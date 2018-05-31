<?php
// Inialize session
session_start();
// Check, if user is already login, then jump to secured page
if (isset($_SESSION['staff_email'])) {
  header('Location: home.php');
}

require_once ('includes/config.php');

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

              <td colspan="2" align="center" height="50px" > <a href="#password_rec" style="text-decoration: none; color: black">Forgot your password?</a>  </td>
            </tr>
          </table>
        </form>

      </div>
    </div>


    <!--===== Modal Password ===========================-->
    <div id="password_rec" class="modalDialog">
      <div style="width:400px">
        <a href="#close" title="Close" class="close">X</a>
        <?php
        if (isset($_POST['submitAddemail'])) {
          //Post Values to DB
           $email = $_POST['email'];
           $email = addslashes(trim($email));

          //Check if email_name Exists
          $query1 = "SELECT * FROM staff WHERE staff_email = '$email' LIMIT 1";
          $check_email = mysql_query($query1);
          $avail_email = mysql_num_rows($check_email);
          if ($avail_email > 0) {
            //email found
            $resultFetch = mysql_query($query1);
			$member = mysql_fetch_assoc($resultFetch);
			
			/* <ramadhan's added code> */
			$staff_id = $member['staff_id'];
			$stffPass = rand(9999,99999);
			$staff_password = MD5($stffPass);
			/* </ramadhan's added code> */
			
            $query = "UPDATE staff SET staff_password='$staff_password' WHERE staff_id='$staff_id' ";
            $result = mysql_query($query) or die(mysql_error());
            

            $email_body = 'Your password is : <b>' . $stffPass . '</b> <br/> ';

            //send Email to client ============================================
            require 'email/class.phpmailer.php';

            try {
              $mail = new PHPMailer(true); //New instance, with exceptions enabled
              $mail->IsSendmail();  // tell the class to use Sendmail
              //$mail->AddReplyTo('paul@xemplar.biz', 'Paul Nyaga');
              $mail->From = "mail@evidenceaction.com"; //$staff_email;   //$sess_email;
              $mail->FromName = "Evidence Action";
              $mail->AddAddress($email);
              $mail->Subject = "DtW Password Reset";
              $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
              $mail->WordWrap = 80; // set word wrap
              $mail->IsHTML(true);
              $mail->Body = $email_body;
              //$mail->AddAttachment($filePath);
              //$mail->AddAttachment($file);
              //$mail->AddAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);
              $mail->Send();
            } catch (phpmailerException $e) {
              echo $e->errorMessage();
            }
            // end of send email ============================
            $messageToUser = "Your password has been reset and sent to your email address! ";


          } else if ($avail_email == 0) {
            //email not found
            $error_message="The Email you entered : " . $email . "<br/> does not exists in the System.";
           
          }
        }
        ?>
        <form action="" method="post">
        <?php include("includes/messageBox.php"); ?>
          <div >
            <h1 class="form-title">Password Reset</h1><br/>
          </div>
          <center>
            <div style="padding: 5px; margin: 0px auto">
              <table border="0">
                <thead>
                  <tr>
                    <td>Enter your email address</td><td><input type="text" name="email" class="input_textbox" required/></td>
                  </tr>
                </thead>
              </table>
            </div>
          </center>
          <br/><br/>
          <center>
            <div>
              <input type="submit" class="btn-custom" name="submitAddemail"  value="Reset Password"/>                    
            </div>
          </center>
        </form>
      </div>
    </div>
  </body> 
</html>
