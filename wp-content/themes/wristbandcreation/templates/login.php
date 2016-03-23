<?php

//Template Name: Login

include ('custom-header.php');
// get_header();

?>
<?php if(!empty($errors)) {  //  to print errors,
	foreach($errors as $err )
	echo $err; 
}

ob_start(); ?>
<div style="height: 50px; background: #ffffff"></div>
<div class="container white">
   <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-login">
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-12">
              <form id="login-form" method="post" role="form" style="display: block;">
                <h2>LOGIN</h2>
                                <?php show_error_messages(); ?>
                  <div class="form-group">
                    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                  </div>
                  <div class="col-xs-6 form-group pull-left checkbox">
                    <input id="checkbox1" type="checkbox" name="remember">
                    <label for="checkbox1">Remember Me</label>   
                  </div>
                  <div class="form-group">     
                        <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                  </div>
              </form>
            </div>
          </div>
        </div>
        <div class="panel-heading">
          <!-- <div class="row"> -->
            <div class="col-xs-6 pull-left">
              <!-- <a href="#" class="active" id="login-form-link"><div class="login">LOGIN</div></a> -->
               <a href="/forgot-password" class="active" id="login-form-link">Forgot Password?</a>
            </div>
            <div class="col-xs-6 pull-left">
              <!-- <a href="#" id="register-form-link"><div class="register">REGISTER</div></a> -->
              <a href="/register" id="register-form-link">REGISTER</a>
            </div>
          <!-- </div> -->
        </div>
      </div>
    </div>
  </div>
</div>
<?php

include ('custom-footer.php');