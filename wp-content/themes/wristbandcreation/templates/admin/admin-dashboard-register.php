
    <div class="col-md-12">
    
      <div class="panel panel-login admin-reg">
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-12">
              <form id="login-form" method="post" role="form" style="display: block;">
            	<div class="form-group row">
            	<h2 class="form-title">Create Account</h2>
            	<hr class="divider" />
            	<div class="err-container">
                	<p class="err-msg"></p>
             	</div>

                <?php if( isset($_GET['st'] ) ) : ?>
                    <div class="suc-container">
                        <p class="err-msg">New <?php echo $_GET['st']; ?> was added.</p>
                    </div>
                <?php endif; ?>
            	</div>
                <p class="reg-label">
                    Personal Information
                </p>
              	<div class="form-group col-md-12">
                	<input type="text" name="fname" id="user-fname" tabindex="1" class="form-control" placeholder="First Name" value="">
             	</div>
             	<div class="form-group col-md-12">
                	<input type="text" name="lname" id="user-lname" tabindex="1" class="form-control" placeholder="Last Name" value="">
             	</div>
             	
              	<p class="reg-label">
                    Account Information
                </p>
             	<div class="form-group">
                	<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" value="">
             	</div>
             	<div class="form-group col-md-12">
                	<input type="password" name="pass" id="user-pass" tabindex="1" class="form-control" placeholder="Password" value="">
             	</div>
             	<div class="form-group">
                	<select class="form-control select" name="custom_role" id="user-role">
                		<option value="" default> -- Role --</option>
						<option value="Admin">Admin</option>
						<option value="Employee">Employee</option>
						<option value="Supplier">Supplier</option>
                	</select>
             	</div>
             	<div class="form-group">
                    <input type="hidden" name="form-action" value="add_new_aes">
             		<input type="submit" id="create-user" name="add_sup_emp" value="Create User">
             	</div>

              </form>
       
            </div>
          </div>
        </div>

      </div>
    </div>