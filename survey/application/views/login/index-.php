<div class="col-md-4 col-md-offset-4">
  <form class="form-signin" role="form" action="<?php echo URL; ?>LoginForm/login" method="post">
    <h2 class="form-signin-heading">DSW<br/> Sign in</h2>
    <hr>
    <div id="ea-login">
      <select name="country" required class="form-control" >
        <option value="kenya" selected="selected">Kenya</option>
        <option value="uganda">Uganda</option>
        <option value="malawi">Malawi</option>
      </select>
      <br/>
      <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
      <input type="password" name="password" class="form-control" placeholder="Password" required>
      <!-- <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
      </label> -->
      <br/>
      <a href="../" class="btn btn-primary bg-pink" >MIS Select</a>
      <button class="btn btn-primary bg-pink" type="submit">Sign in</button>
 

    </div>
  </form>


</div>


