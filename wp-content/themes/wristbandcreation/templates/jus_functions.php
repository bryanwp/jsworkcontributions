<?php
/*
* Custom function
* Justin
*/


add_action('init', 'my_check_login');

function my_check_login(){
        // check input and
        // do my login stuff here 

  if(isset($_POST['login-submit'])) {
  $creds                  = array();
  $creds['user_login']    = stripslashes( trim( $_POST['username'] ) );
  $creds['user_password'] = stripslashes( trim( $_POST['password'] ) );
  $creds['remember']      = isset( $_POST['remember'] ) ? sanitize_text_field( $_POST['remember'] ) : '';
  //$redirect_to            = esc_url_raw( $_POST['redirect_to'] );
  $secure_cookie          = null;
  // if($redirect_to == '')
  //  $redirect_to= get_site_url(); 
    
  //  if ( ! force_ssl_admin() ) {
  //      $user = is_email( $creds['user_login'] ) ? get_user_by( 'email', $creds['user_login'] ) : get_user_by( 'login', sanitize_user( $creds['user_login'] ) );

  //    if ( $user && get_user_option( 'use_ssl', $user->ID ) ) {
  //      $secure_cookie = true;
  //      force_ssl_admin( true );
  //    }
  //  }

  // if ( force_ssl_admin() ) {
  //  $secure_cookie = true;
  // }

  // if ( is_null( $secure_cookie ) && force_ssl_admin() ) {
  //  $secure_cookie = false;
  // }

  // $user = wp_signon( $creds, $secure_cookie );
  $user = wp_signon( $creds, false );

  // if ( $secure_cookie && strstr( $redirect_to, 'wp-admin' ) ) {
  //  $redirect_to = str_replace( 'http:', 'https:', $redirect_to );
  // }

  if ( ! is_wp_error( $user ) ) {
    // echo home_url();
    // echo "<pre>";
    // var_dump($user->roles);
    // echo $user->roles[0];
    // echo "</pre>";
    // die();
    wp_redirect( home_url() );
    exit;    
  } else {      
    if ( $user->errors ) {
      // $errors['invalid_user'] = __('<strong>ERROR</strong>: Invalid user or password.');  
      //echo "hello from the other side";
    } else {
      // $errors['invalid_user_credentials'] = __( 'Please enter your username and password to login.', 'kvcodes' );
      //echo "hello from the other side";
    }
  }
  // $creds = array();
  // $creds['user_login'] = 'example';
  // $creds['user_password'] = 'plaintextpw';
  // $creds['remember'] = true;

  // $creds                  = array();
  // $creds['user_login']    = stripslashes( trim( $_POST['username'] ) );
  // $creds['user_password'] = stripslashes( trim( $_POST['password'] ) );
  // $redirect_to            = esc_url_raw( $_POST['redirect_to'] );
  // $secure_cookie          = null;
  // $user = wp_signon( $creds, false );
  // if ( is_wp_error($user) )
  //  echo $user->get_error_message();  

  }
}

function Display_error() {

}


add_action('init', 'my_forgot_pass');

function my_forgot_pass(){
			//Error Viewer
				if (isset( $_REQUEST['error'] ) ) {

					if( $_REQUEST['error'] === 'email' ) { 	
						forpass_errors()->add('empty_email', __('Please enter an email'));
					} elseif ( $_REQUEST['error'] === 'incorrect-email' ) {
						forpass_errors()->add('incorrect_email', __('Please enter a correct email'));
					} elseif ( $_REQUEST['error'] === 'wrong-email' ) {
						forpass_errors()->add('wrong_email', __('Email doesn&apos;t exist</strong>'));
					} elseif ( $_REQUEST['error'] === 'answer' ) {
						forpass_errors()->add('incorrect_answer', __('Please Enter the correct answer'));
					} elseif ( $_REQUEST['error'] === 'password' ) {
						forpass_errors()->add('match_password', __('Password doesn&apos;t match'));
					} elseif ( $_REQUEST['error'] === 'invalid-password' ) {
						forpass_errors()->add('invalid_password', __('Invalid Password'));
					} else {
						forpass_errors()->add('empty_password', __('string'));
					}
				}
				
				// check if email is right and existing
				if ( isset( $_POST['action'] ) && 'check-email' == $_POST['action'] ) {
					$email = trim( $_POST['user_login'] );
					//echo $email;
					//validation for email
					if( empty( $email ) ) {
		              $redirect = home_url() . '/forgot-password/?error=email';
		              exit ( wp_redirect( $redirect ) );
					} else if( ! is_email( $email )) {
						$redirect = home_url() . '/forgot-password/?error=incorrect-email';
		              	exit ( wp_redirect( $redirect ) );
					} else if( ! email_exists( $email ) ) {
						$redirect = home_url() . '/forgot-password/?error=wrong-email';
		              	exit ( wp_redirect( $redirect ) );
					} 

				}	

				if ( isset( $_POST['action'] ) == 'check-email'){
					//echo "dragoon";
					$forpass = forpass_errors();
					foreach ($forpass as $key => $value) {
			            unset($forpass->$key);
			        }
				}

				if ( isset( $_POST['action'] ) && 'reset' == $_POST['action'] ) {
					//initializing required information
					$answer = trim( $_POST['security-answer'] );
					$email = trim( $_POST['user_login'] );
					$user = get_user_by( 'email', $email );
					$id = $user->ID;
					$user_secret_answer = get_user_meta( $id, 'user_secret_answer', true );

					//validation for security answer
					if ( $answer != $user_secret_answer ) {
						$redirect = home_url() . '/forgot-password/?action=check-email&error=answer&user_login=' . $email;
		              	exit ( wp_redirect( $redirect ) );
					}
				}

				if ( isset($_POST['action'] ) && 'change-password' == $_POST['action'] ) {
					//initializing required information
					//echo "went here";
					//die();
					$email = trim( $_POST['user_login'] );
					$user = get_user_by( 'email', $email );
					$id = $user->ID;
					$pass1 = $_POST['password'];
					$pass2 = $_POST['password2'];

					//Validation for new password
					if ( trim($pass1) == '' ) {
						$redirect = home_url() . '/forgot-password/?action=reset&error=invalid-password&user_login=' . $email;
						exit ( wp_redirect($redirect) );
					} elseif(!preg_match('/^[a-zA-Z0-9]{4,16}$/', $pass1 ) ) {
			            $redirect = home_url() . '/forgot-password/?action=reset&error=invalid-password&user_login=' . $email;
						exit ( wp_redirect( $redirect ) );
				    }
					if ( trim( $pass2 ) == '' ) {
						$redirect = home_url() . '/forgot-password/?action=reset&error=invalid-password&user_login=' . $email;
						exit ( wp_redirect( $redirect ) );
					} elseif ( $pass1 != $pass2 ) {
						$redirect = home_url() . '/forgot-password/?action=reset&error=password&user_login=' . $email;
						exit ( wp_redirect( $redirect ) );
					} else {

						$update_user = wp_update_user( array (
								'ID' 		=> $id, 
								'user_pass' => $pass2
							)
						);

						if ( $update_user ) {
							$redirect = home_url() . '/login';
							exit ( wp_redirect( $redirect ) );
						}
					}
				}
	}
	// used for tracking error messages
function forpass_errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// displays error messages from form submissions
function show_error_messages() {
	if($codes = forpass_errors()->get_error_codes()) {
		echo '<div class="this_errors">';
		    // Loop error codes and display errors
		   foreach($codes as $code){
		        $message = forpass_errors()->get_error_message($code);
		        echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
		    }
		echo '</div>';
	}
}