<?php  
/* 
Template Name: Forgot Password Page
*/

include ('custom-header.php');
?>

<div class="section login-content">
	<div class="container">
		<div class="col-xs-12 col-sm-8 col-sm-offset-2">
			<div class="wrapper">

				<!--html code-->

			<?php
					// show any error messages after form submission
							show_error_messages(); ?></p>
		

					<!-- Email Form -->
					<form method="post" <?php echo ( !isset( $_REQUEST['action'] ) ) ? 'style="display:block"' : 'style="display:none"';?>>
						<!-- <p>Please enter your username or email address. You will receive a link to create a new password via email.</p> -->
		
						<div class="form-group">
					      	<label class="form-label">Email Address</label>
					        <input type="text" class="form-control" id="email" name="user_login" >
				        </div>

				        <div class="gap gap-10"></div>

				        <input type="hidden" name="action" value="check-email" />
						<input type="submit" class="btn btn-block btn-login" class="button" id="submit" value="Submit"/>
					</form>
					
					<!-- Security Answer Form -->
					<form method="post" <?php if ( $_REQUEST['action'] === 'check-email' ) { echo 'style="display:block"'; } else { echo 'style="display:none"'; } ?> >
						<?php 
						$user_login = isset( $_REQUEST['user_login'] ) ? $_REQUEST['user_login'] : ''; 
						$user = get_user_by( 'email', $user_login );
						$id = $user->ID;
						$sercurity_question = get_user_meta( $id, 'user_secret_question', true );
						?>
		
						<div class="form-group" >
							<h3>Reset Password</h3>
							<strong>Email Address: <?php echo $user_login; ?></strong><br />
							<strong>Security Question: <?php echo $sercurity_question; ?></strong><br />
					        <input type="text" class="form-control" name="security-answer" placeholder="Security Answer">
				        </div>

				        <div class="gap gap-10"></div>

				        <input type="hidden" name="action" value="reset" />
				        <input type="hidden" name="user_login" value="<?php echo $user_login; ?>" />
						<input type="submit" class="btn btn-block btn-login" value="Submit" class="button" id="submit" />
					</form>
					
					<!-- Password Form -->
					<form method="post" <?php if ( $_REQUEST['action'] === 'reset' ) { echo 'style="display:block"'; } else { echo 'style="display:none"'; } ?> >
						<?php 
						$user_login = isset( $_REQUEST['user_login'] ) ? $_REQUEST['user_login'] : ''; 
						?>
		
						<div class="form-group" >
							<h3>Reset Password</h3>
							<label>New Password</label>
					        <input type="password" class="form-control" name="password">
					        <label>Confirm New Password</label>
					        <input type="password" class="form-control" name="password2">
				        </div>

				        <div class="gap gap-10"></div>

				        <input type="hidden" name="action" value="change-password" />
				        <input type="hidden" name="user_login" value="<?php echo $user_login; ?>" />
						<input type="submit" class="btn btn-block btn-login" value="Reset Password" class="button" id="submit" />
					</form>
			</div>
		</div>
	</div>
</div>

<?php

include ('custom-footer.php');