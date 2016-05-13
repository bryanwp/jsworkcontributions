
<div class="col-md-12 white" >
	<div class="gap-top"></div>
	<div style="margin-top: 20px;">
			<?php the_title( '<h1>', '</h1>' ); ?>
	</div>
	<div class="dash-title-holder">
		<h2>Profile</h2>
	</div>
	<hr class="divider-full" />
	<div style="height: 10px"></div>

	<div class="row row-fix">
		<!-- <div class="col-md-3 profile-left shadow-wrap">
			<p>Profile Details</p>
			<div>
				<img src="http://0.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?s=32&d=mm&r=g" class="img-thumbnail" alt="Cinque Terre" width="100%">
			</div>
			<?php 
				// $user = wp_get_current_user();
				$user = get_user_by( "id", get_current_user_id() );
			?>
			<p><?php echo $user->display_name; ?></p>
			<hr class="divider-full" />
			<p class="isEmail"><?php echo $user->user_email; ?></p>
		</div> -->
		<div class="col-md-12 profile-right">
<!-- 			<div class="my-profile-info shadow-wrap">
				<p>
					
				</p>
			</div> -->
			<div class="layer1 shadow-wrap">
				<a href="#Update" data-toggle="collapse"><p>Update Profile Information</p></a>
				<div id="Update" class="collapse">
					<hr class="divider-full" />
					<form method="post" role="form">
					    <p class="form-row form-row-first">
							<label for="account_first_name">First name</label>
							<input type="text" class="input-text profile" name="first_name" id="account_first_name" value="<?php echo $user->user_firstname; ?>">
						</p>
						<p class="form-row form-row-last">
							<label for="account_last_name">Last name</label>
							<input type="text" class="input-text profile" name="last_name" id="account_last_name" value="<?php echo $user->user_lastname; ?>">
						</p>
						<p class="form-row form-row-wide">
							<label for="email">Email address<span class="email-checker"></span></label>
							<input type="email" class="input-text profile" name="email" id="email" value="<?php echo $user->user_email; ?>">
							<input type="hidden" name="current-email" value="<?php echo $user->user_email; ?>">
						</p>
						<div class="clear"></div>
						<p class="form-button">
							<input type="hidden" name="form-action" value="profile">
							<input type="submit" id="profile" class="save-button" name="profile" value="Update Profile">
						</p>
						<p></p>
	             	</form>
			  	</div>
			</div>

			<div class="layer1 shadow-wrap">
				<a href="#Change" data-toggle="collapse"><p>Change Password</p></a>
				<div id="Change" class="collapse">
					<hr class="divider-full" />
					<p class="scp"></p>
					<p class="error"></p>
					<form class="pass-frame">
						<p class="form-row form-row-first">
							<label for="current">Current Password</label>
							<input type="password" class="input-text pass" name="current" id="current">
							<input type="hidden" id='hash' name="current-password" value="<?php echo $user->user_pass; ?>">
						</p> 
						<p class="form-row form-row-first">
							<label for="npass">New Password</label>
							<input type="password" class="input-text pass" name="pass" id="npass">
						</p>
						<p class="form-row form-row-first">
							<label for="cpass">Re-Type New Password</label>
							<input type="password" class="input-text pass" name="cpass" id="cpass">
						</p>
						<div class="clear"></div>
						<p class="form-button">
							<input type="button" id="cpass-btn" class="save-button" name="password" value="Update Profile">
							<!-- <input type="hidden" name="form-action" value="password"> -->
						</p>
						<p></p>

	             	</form>
			  	</div>
			</div>

		</div>
	</div>
	
</div>
