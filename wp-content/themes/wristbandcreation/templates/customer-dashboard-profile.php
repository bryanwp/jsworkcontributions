
<div class="col-md-10" >
	<div class="gap-top"></div>
	<div class="dash-title-holder">
		<h2>Profile</h2>
	</div>
	<hr class="divider-full" />
	<div style="height: 10px"></div>

	<div class="row row-fix">
		<div class="col-md-3 profile-left shadow-wrap">
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
		</div>
		<div class="col-md-9 profile-right">
<!-- 			<div class="my-profile-info shadow-wrap">
				<p>
					
				</p>
			</div> -->
			<div class="layer1 shadow-wrap">
				<a href="#Update" data-toggle="collapse"><p>Update Profile Information</p></a>
				<div id="Update" class="collapse">
					<hr class="divider-full" />
					<form action="#" method="post" role="form">
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
							<input type="submit" id="profile" class="save-button" name="profile" value="Update Profile">
							<input type="hidden" name="form-action" value="profile">
						</p>
						<p></p>
	             	</form>
			  	</div>
			</div>

			<div class="layer1 shadow-wrap">
				<a href="#Change" data-toggle="collapse"><p>Change Password</p></a>
				<div id="Change" class="collapse">
					<hr class="divider-full" />
					<p class="error"></p>
					<form action="#" method="post" role="form">
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
							<input type="button" id="pass" class="save-button" name="password" value="Update Profile">
							<input type="hidden" name="form-action" value="password">
						</p>
						<p></p>

	             	</form>
			  	</div>
			</div>

			<div class="layer1 shadow-wrap">
				<a href="#Billing" data-toggle="collapse"><p>Billing Address</p></a>
				<div id="Billing" class="collapse">
					<hr class="divider-full" />
					<form method="post">

			
			
				<p class="form-row form-row form-row-first validate-required" id="billing_first_name_field"><label for="billing_first_name" class="">First Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing_first_name" id="billing_first_name" placeholder="" value="Sheldon"></p>
			
				<p class="form-row form-row form-row-last validate-required" id="billing_last_name_field"><label for="billing_last_name" class="">Last Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing_last_name" id="billing_last_name" placeholder="" value="Alag"></p><div class="clear"></div>
			
				<p class="form-row form-row form-row-wide" id="billing_company_field"><label for="billing_company" class="">Company Name</label><input type="text" class="input-text " name="billing_company" id="billing_company" placeholder="" value=""></p>
			
				<p class="form-row form-row form-row-first validate-required validate-email" id="billing_email_field"><label for="billing_email" class="">Email Address <abbr class="required" title="required">*</abbr></label><input type="email" class="input-text " name="billing_email" id="billing_email" placeholder="" value="admin@admin.com"></p>
			
				<p class="form-row form-row form-row-last validate-required validate-phone" id="billing_phone_field"><label for="billing_phone" class="">Phone <abbr class="required" title="required">*</abbr></label><input type="tel" class="input-text " name="billing_phone" id="billing_phone" placeholder="" value="2312"></p><div class="clear"></div>
			
				
			
				<p class="form-row form-row form-row-wide address-field validate-required" id="billing_address_1_field"><label for="billing_address_1" class="">Address <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing_address_1" id="billing_address_1" placeholder="Street address" value="adfad"></p>
			
				<p class="form-row form-row form-row-wide address-field" id="billing_address_2_field"><input type="text" class="input-text " name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit etc. (optional)" value="adgag"></p>
			
				<p class="form-row form-row form-row-wide address-field validate-required" id="billing_city_field" data-o_class="form-row form-row form-row-wide address-field validate-required"><label for="billing_city" class="">Town / City <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing_city" id="billing_city" placeholder="" value="adfad"></p>
			
				<div class="clear"></div>
			
			
			<p>
				<input type="submit" class="fusion-button button-default button-small button small default alignright" name="save_address" value="Save Address">
				<input type="hidden" id="_wpnonce" name="_wpnonce" value="fcc48dabbc"><input type="hidden" name="_wp_http_referer" value="/my-account/edit-address/billing/">				<input type="hidden" name="action" value="edit_address">
			</p><div class="clearboth"></div>
			<p></p>

		</form>
			  	</div>
			</div>

			<div class="layer1 shadow-wrap">
				<a href="#Shipping" data-toggle="collapse"><p>Shipping Address</p></a>
				<div id="Shipping" class="collapse">
					<hr class="divider-full" />
					<form method="post">

			
			
				<p class="form-row form-row form-row-first validate-required" id="shipping_first_name_field"><label for="shipping_first_name" class="">First Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping_first_name" id="shipping_first_name" placeholder="" value="Sheldon"></p>
			
				<p class="form-row form-row form-row-last validate-required" id="shipping_last_name_field"><label for="shipping_last_name" class="">Last Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping_last_name" id="shipping_last_name" placeholder="" value="Alag"></p><div class="clear"></div>
			
				<p class="form-row form-row form-row-wide" id="shipping_company_field"><label for="shipping_company" class="">Company Name</label><input type="text" class="input-text " name="shipping_company" id="shipping_company" placeholder="" value=""></p>
			
				
			
				<p class="form-row form-row form-row-wide address-field validate-required" id="shipping_address_1_field"><label for="shipping_address_1" class="">Address <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping_address_1" id="shipping_address_1" placeholder="Street address" value="adfad"></p>
			
				<p class="form-row form-row form-row-wide address-field" id="shipping_address_2_field"><input type="text" class="input-text " name="shipping_address_2" id="shipping_address_2" placeholder="Apartment, suite, unit etc. (optional)" value="adgag"></p>
			
				<p class="form-row form-row form-row-wide address-field validate-required" id="shipping_city_field" data-o_class="form-row form-row form-row-wide address-field validate-required"><label for="shipping_city" class="">Town / City <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping_city" id="shipping_city" placeholder="" value="adfad"></p>
			
				<p class="form-row form-row form-row-first address-field validate-state validate-required" id="shipping_state_field" data-o_class="form-row form-row form-row-first address-field validate-required validate-state"><label for="shipping_state" class="">State / County <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text" name="shipping_state" id="shipping_state" placeholder=""></p><p class="form-row form-row form-row-last address-field validate-postcode validate-required" id="shipping_postcode_field" data-o_class="form-row form-row form-row-last address-field validate-required validate-postcode"><label for="shipping_postcode" class="">Postcode / ZIP <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping_postcode" id="shipping_postcode" placeholder="" value="12324"></p>
			
				<div class="clear"></div>
			
			
			<p>
				<input type="submit" class="fusion-button button-default button-small button small default alignright" name="save_address" value="Save Address">
				<input type="hidden" id="_wpnonce" name="_wpnonce" value="fcc48dabbc"><input type="hidden" name="_wp_http_referer" value="/my-account/edit-address/shipping/">				<input type="hidden" name="action" value="edit_address">
				</p><div class="clearboth"></div>
			<p></p>

		</form>
			  	</div>
			</div>
		</div>
	</div>
	
</div>
