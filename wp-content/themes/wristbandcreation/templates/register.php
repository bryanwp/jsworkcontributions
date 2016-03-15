<?php

//Template Name: Register

include ('custom-header.php'); ?>

<div class="container">
   <div class="row">
    <div class="col-md-6 col-md-offset-3">
    
      <div class="panel panel-login">
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-12">
              <form id="login-form" action="#" method="post" role="form" style="display: block;">
            	<div class="form-group">
            		<h2>Sign Up</h2>
            	</div>
              	<div class="form-group">
                	<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
             	</div>
             	<div class="form-group">
                	<input type="password" name="password" id="password" tabindex="1" class="form-control" placeholder="Password">
              	</div>
              	<div class="form-group">
                	<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
             	</div>
             	<div class="form-group">
                	<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
             	</div>
             	<div class="form-group">
                	<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
             	</div>

              </form>
       
            </div>
          </div>
        </div>
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-6 tabs">
              <a href="#" class="active" id="login-form-link"><div class="login">LOGIN</div></a>
            </div>
            <div class="col-xs-6 tabs">
              <a href="#" id="register-form-link"><div class="register">REGISTER</div></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include ('custom-footer.php'); ?>