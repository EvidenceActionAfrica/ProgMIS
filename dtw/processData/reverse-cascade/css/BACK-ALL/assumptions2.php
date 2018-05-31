<?php
require_once ('includes/auth.php');
require_once ('../../includes/config.php');

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
       <?php   require_once ("includes/menuNav.php");  ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-Drugs.php"); ?>
      </div>
      <div class="contentBody">
        <form class="form-horizontal">
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Form Name</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Text Input</label>
  <div class="controls">
    <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="input-xlarge">
    <p class="help-block">help</p>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="selectbasic">Select Basic</label>
  <div class="controls">
    <select id="selectbasic" name="selectbasic" class="input-xlarge">
      <option>Option one</option>
      <option>Option two</option>
    </select>
  </div>
</div>

<!-- Multiple Radios -->
<div class="control-group">
  <label class="control-label" for="radios">Multiple Radios</label>
  <div class="controls">
    <label class="radio" for="radios-0">
      <input type="radio" name="radios" id="radios-0" value="Option one" checked="checked">
      Option one
    </label>
    <label class="radio" for="radios-1">
      <input type="radio" name="radios" id="radios-1" value="Option two">
      Option two
    </label>
  </div>
</div>

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="passwordinput">Password Input</label>
  <div class="controls">
    <input id="passwordinput" name="passwordinput" type="password" placeholder="placeholder" class="input-xlarge">
    <p class="help-block">help</p>
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="singlebutton">Single Button</label>
  <div class="controls">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Button</button>
  </div>
</div>

</fieldset>
</form>







      </div> <!--end content body-->
        <div class="clearFix"></div>

    </div> <!--end content main-->
  </body>
</html>




