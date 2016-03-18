<?php
/*
* Custom function
* Sheldz
*/

add_action('init', 'register_new_user_phase_two');
function register_new_user_phase_two(){

	//initializing variables
	$fname = ''; $lname = ''; $company_name = ''; $phone = '';
	$card =''; $country = ''; $address = ''; $email = '';
	$cpass = ''; $secret_question = ''; $sanswer = ''; $role = '';


	//populating variables
	$post = $_POST;
	if ( isset($post['fname']) ) {
		$fname = $post['fname'];
	}
	if ( isset($post['lname']) ) {
		$lname = $post['lname'];
	}
	if ( isset($post['company_name']) ) {
		$company_name = $post['company_name'];
	}
	if ( isset($post['phone']) ) {
		$phone = $post['phone'];
	}
	if ( isset($post['card']) ) {
		$card = $post['card'];
	}
	if ( isset($post['country']) ) {
		$country = $post['country'];
	}
	if ( isset($post['address']) ) {
		$address = $post['address'];
	}
	if ( isset($post['email']) ) {
		$email = $post['email'];
	}
	if ( isset($post['cpass']) ) {
		$cpass = $post['cpass'];
	}
	if ( isset($post['secret_question']) ) {
		$secret_question = $post['secret_question'];
	}
	if ( isset($post['sanswer']) ) {
		$sanswer = $post['sanswer'];
	}
	if ( isset($post['role']) ) {
		$role = $post['role'];
	}

	if ( isset( $post['add_user'] ) ) {

	    if ( $post['add_user'] === "Submit") {
		    $userdata = array(
		      'user_login'  =>  $email,
		      'user_pass'   =>  $cpass,
		      'first-name'  => $fname,
		      'last-name'   => $lname,
		      'role'        => $role,
		      'user_email'  => $email,
		      'user_nicename' => $fname
		    );

	        $user_id = wp_insert_user( $userdata );

	        if ( ! is_wp_error( $user_id ) ) {
		    	//adding user meta
		    	add_user_meta( $user_id, 'user_company_name', $company_name  );
		    	add_user_meta( $user_id, 'user_phone', $phone  );
		    	add_user_meta( $user_id, 'user_credit_card_no', $card  );
		    	add_user_meta( $user_id, 'user_country', $country  );
		    	add_user_meta( $user_id, 'user_address', $address  );
		    	add_user_meta( $user_id, 'user_secret_question', $secret_question  );
		    	add_user_meta( $user_id, 'user_secret_answer', $sanswer  );

		    	$redirect = home_url('login');
		      	exit (wp_redirect($redirect));
	        } else {
	        	echo 'error';
	       } 
	   }
	}

}

add_action('init', 'check_if_login');
function check_if_login(){
	//initializing redirect url
	$redirect = home_url('login');

	if ( ! is_user_logged_in () ) {
		if ( is_page('customer-dashboard') ) {
			exit(wp_redirect( $redirect ) );
		}
	}
}

add_action('wp_ajax_check-email', 'check_email');
add_action('wp_ajax_nopriv_check-email', 'check_email');
function check_email($email = false) {
  global $wpdb;
 
  $t = $_REQUEST['email'];
  $isExists[0] = true;
  $sql = "SELECT * FROM $wpdb->users WHERE user_login = '$t'";
  $results = $wpdb->get_row($sql);

    if($results) {
      $isExists[0] = true;
    } else {
      $isExists[0] = false;
    }

  exit(wp_send_json_success($isExists));
}

add_action('init', 'update_profile');
function update_profile(){
	$post = $_POST;

	if ( isset( $post['form-action'] ) && $post['form-action'] === 'profile' ) {
		//$fname = ''; $lname = ''; $email = '';
		//init variables
		$userdata = array (
			'ID' 			=> get_current_user_id(),
			'user_login' 	=> $post['email'],
			'user_email' 	=> $post['email'],
			'first_name' 	=> $post['first_name'],
			'last_name'  	=> $post['last_name'],
			'display_name' 	=> $post['first_name'] . ' ' . $post['last_name'],
		);	

		wp_update_user( $userdata );
	}
}

add_action('wp_ajax_change-user-password', 'change_user_password');
add_action('wp_ajax_nopriv_change-user-password', 'change_user_password');
function change_user_password(){
	$post = $_POST;

	$wp_hasher = new PasswordHash(16, FALSE);
	$hash = wp_hash_password( $post['cpass'] );

	if ( $hash != $post['hash'] ) {
		$result = 'wpw';
		exit( wp_send_json_success( $hash ) );
	} else {
		if ( wp_set_password( $post['pass'], get_current_user_id() ) ) {
			$result = 'asdaf';
			exit( wp_send_json_success( $result ) );
		}
	}
}

