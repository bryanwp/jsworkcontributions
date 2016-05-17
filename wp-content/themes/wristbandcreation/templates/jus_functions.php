<?php
/*
* Custom function
* Justin
*/


add_filter("woocommerce_checkout_fields", "order_fields");

function order_fields($fields) {

	$order = array(
		"billing_first_name", 
		"billing_last_name", 
		"billing_company", 
		"billing_address_1", 
		"billing_address_2", 
		"billing_postcode", 
		"billing_country",
		"billing_phone", 
		"billing_email"

		);
	foreach($order as $field)
	{
		$ordered_fields[$field] = $fields["billing"][$field];
	}

	$fields["billing"] = $ordered_fields;
	return $fields;

}


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
    // var_dump($user);
			$role = get_user_meta ( $user->ID, 'custom_role', true );
			session_start();
			if ( $role ) {
				$_SESSION['role'] = $role;
			} else {
				// if ( !current_user_can( 'manage_options' ) ) {
				// 	$_SESSION['role'] = 'customer';
				// 	$role = 'customer';
				// } else {
				// 	$_SESSION['role'] = 'super-admin';
				// 	$role = 'super-admin';
				// }

				if (is_super_admin( $user->ID )) {
					# code...
					$_SESSION['role'] = 'super-admin';
				}else{
					$_SESSION['role'] = 'customer';
				}

			}
	
	// echo $_SESSION['role'];		
 //    echo $role;
 //    echo $user->ID;
 //    echo "</pre>";
 //    die();
			$msg = get_full_date( $req = 'full_date' ) . ' - '. $role . '' . $user->user_email . ' has logged in - ' . $user->display_name;
			action_log( $msg );

			if($role == 'Supplier') {
				wp_redirect( home_url('supplier-dashboard') );
				exit; 
			} elseif ($role == 'Admin') {
				wp_redirect( home_url('admin-dashboard') );
				exit;
			} elseif ($role == 'Employee') {
				wp_redirect( home_url('employee-dashboard') );
				exit;
			} else {
				$user_role = $user->roles;
				foreach ($user_role as $key => $value) {
					if ( $key == 0 && $value == 'administrator') {
						wp_redirect( home_url('admin-dashboard') ); 
						exit;
					} else {
						wp_redirect( home_url('customer-dashboard') );
						exit; 
					}
				}
			}

			wp_redirect( home_url() );
			exit;    
		} else {      
			if ( $user->errors ) {
      // $errors['invalid_user'] = __('<strong>ERROR</strong>: Invalid user or password.');  
      //echo "hello from the other side";
				$redirect = home_url() . '/login/?error=Invaliduser';
				exit(wp_redirect($redirect));
			} else {
      // $errors['invalid_user_credentials'] = __( 'Please enter your username and password to login.', 'kvcodes' );
      //echo "hello from the other side";
				$redirect = home_url() . '/login/?error=InvaliduserCredentials';
				exit(wp_redirect($redirect));
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

// function display_login_error($message) {
// 	echo $message;
// 	if ($message == 'hello') {
// 		return 'from the other side';
// 	}else
// 		return 'dragoon';
// }


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
		} elseif( $_REQUEST['error'] === 'Invaliduser' ) { 	
			forpass_errors()->add('Invalid_user', __('Invalid user or password'));
		} elseif ( $_REQUEST['error'] === 'InvaliduserCredentials' ) {
			forpass_errors()->add('Invalid_userCredentials', __('Please enter your username and password to login'));
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
		echo '<div class="this_errors errorstyle">';
		    // Loop error codes and display errors
		foreach($codes as $code){
			$message = forpass_errors()->get_error_message($code);
			echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
		}
		echo '</div>';
	}
}

add_action( 'init', 'change_status' );
function change_status() {
	$user_id = get_current_user_id();
	$post = $_POST;
	$status = ["pending_production","pending_artwork_approval","in_production","in_reproduction","produced_pending_shipment","shipped"];
	$key = '_new_status';
	
	if ( isset( $post['status-submit'] ) ) {
			// var_dump($post);
			// die();
			$x = $post['newstatus'];
			$tracking = '';
			if (isset( $post['trackingnum'] ) ) {
				$tracking = $post['trackingnum'];
			}
			
			// echo $x;
			//echo $tracking;

		//Shipp	
		if ($status[$x] == 'shipped') {

			if ( ! add_post_meta( $post['post-id'], $key, $status[$x], true ) ) { 
			update_post_meta ( $post['post-id'], $key, $status[$x]  );
			}
			if ( ! add_post_meta( $post['post-id'], 'supplier_trackingnumber', $tracking, true ) ) { 
				update_post_meta ( $post['post-id'], 'supplier_trackingnumber', $tracking  );
			}
			
			//initailizing and populating required data for the sending of email
			// $args = get_req_info_for_email( $post['post-id'] );
			wp_send_email_shipping_confirmation( $post['post-id'] );

		} else {
			if ( ! add_post_meta( $post['post-id'], $key, $status[$x], true ) ) { 
			update_post_meta ( $post['post-id'], $key, $status[$x]  );
			}
		}
		$redirect = home_url( 'supplier-dashboard/?action=view&ID='. $post['post-id'] );
		exit( wp_redirect( $redirect ) );	

	}
}

add_action( 'init', 'add_track' );
function add_track() {
	$user_id = get_current_user_id();
	$post = $_POST;
	
	if ( isset( $post['track-submit'] ) ) {
		$tracking = $post['trackingnum'];
			//echo $tracking;
		if ( ! add_post_meta( $post['post-id'], 'supplier_trackingnumber', $tracking, true ) ) { 
			update_post_meta ( $post['post-id'], 'supplier_trackingnumber', $tracking  );
		}
		$redirect = home_url( 'supplier-dashboard/?action=view&ID='. $post['post-id'] );
		exit( wp_redirect( $redirect ) );	

	}
}

add_action( 'init', 'save_price_changes' );

function save_price_changes() {
	$user_id = get_current_user_id();
	$post = $_POST;
	$key = '_new_status';
	if (!empty($_POST["maxrowval"])) {$row = $_POST["maxrowval"];} else { $row = ''; }
	$arrquantity = ["moldquantity_", "printingquantity_", "laserquantity_","colorfillquantity_","embossedquantity_","imprintingquantity_","swirlquantity_","segmentedquantity_","glowquantity_","duallayerquantity_","insideembossedquantity_","individualpkgquantity_","keychainsquantity_","shipdhlquantity_"];
	$arrprice = ["moldprice_", "printingprice_", "laserprice_","colorfillprice_","embossedprice_","imprintingprice_","swirlprice_","segmentedprice_","glowprice_","duallayerprice_","insideembossedprice_","individualpkgprice_","keychainsprice_","shipdhlprice_"];
	$arrtotal = ["mold_","printing_","laser_","colorfill_","embossedp_","imprintingp_","swirlp_","segmentedp_","glowp_","duallayerp_","insideembossed_","individualpkg_","keychains_","shipdhl_"];
    // /echo $row;

	if (isset( $post['save-price'] )) {
			# code...
		$totalkey = 'wtotalprice';
		for ($x=0; $x < sizeof($arrtotal); $x++) { 
					# code...
			for ($i=1; $i < $row + 2 ; $i++) {

				if(isset($post[$arrtotal[$x].$i]) && ($post[$arrtotal[$x].$i]!= 0)){
					if(isset($post[$arrquantity[$x].$i])){
						$newkey1 = $arrquantity[$x];
								// echo $newkesy1.'='.$post[$arrquantity[$x].$i]."</br>";
						$parrqty[$newkey1][] = $post[$arrquantity[$x].$i];
								//add_post_meta( $post['order_id'], 'supplier_'.$newkey1,$post[$arrquantity[$x].$i]);
					}
					if(isset($post[$arrprice[$x].$i])){
						$newkey2 = $arrprice[$x];
								// echo $nsewkey2.'='.$post[$arrprice[$x].$i]."</br>";
								//$parrprice[]
						$parrprice[$newkey2][] = $post[$arrprice[$x].$i];
								//add_post_meta( $post['order_id'], 'supplier_'.$newkey2,$post[$arrprice[$x].$i]);
					}
					$newkey3 = $arrtotal[$x];
							// echo s$newkey3.'='.$post[$arrtotal[$x].$i]."</br>";
					$parrtotal[$newkey3][] = $post[$arrtotal[$x].$i];
							//add_post_meta( $post['order_id'], 'supplier_'.$newkey3,$post[$arrtotal[$x].$i]);
				}
			}
		}

		if ( ! add_post_meta( $post['order_id'], 'supplier_wpqty',   $parrqty, true ) ) { 
			update_post_meta( $post['order_id'], 'supplier_wpqty',   $parrqty );
		}

		if ( ! add_post_meta( $post['order_id'], 'supplier_wpprice',   $parrprice, true ) ) { 
			update_post_meta( $post['order_id'], 'supplier_wpprice',   $parrprice );
		}

		if ( ! add_post_meta( $post['order_id'], 'supplier_wptotal',   $parrtotal, true ) ) { 
			update_post_meta( $post['order_id'], 'supplier_wptotal',   $parrtotal );
		}

		add_post_meta($post['order_id'],'supplier_'.$totalkey, $post['wtotalprice']);
		add_post_meta($post['order_id'],'supplier_maxrowval', $post['maxrowval']);
	}

}



add_action( 'init', 'change_label_name' );
function change_label_name($label) {
	$arrtotal = ["mold_","printing_","laser_","colorfill_","embossedp_","imprintingp_","swirlp_","segmentedp_","glowp_","duallayerp_","insideembossed_","individualpkg","keychains","shipdhl_"];
	$newlabel = ["Mold - Set Up ","Printing - Set Up ","Laser Engraving ","Color Fill ","Embossed-Color ","Imprinting Fee ","Swirl ","Segmented ","Glow ","Dual Layer ","Inside Embossed ","Individual Packaging ","Keychains ","Shipping (DHL) "];
	for ($x=0; $x < sizeof($arrtotal) ; $x++) { 
		# code...
		if (strpos($label, $arrtotal[$x]) !== false) {
			return $newlabel[$x];
		}
	}
}

function change_qty_name($label) {
	$arrtotal = ["mold_","printing_","laser_","colorfill_","embossedp_","imprintingp_","swirlp_","segmentedp_","glowp_","duallayerp_","insideembossed_","individualpkg","keychains","shipdhl_"];
	$newlabel =	["moldquantity_", "printingquantity_", "laserquantity_","colorfillquantity_","embossedquantity_","imprintingquantity_","swirlquantity_","segmentedquantity_","glowquantity_","duallayerquantity_","insideembossedquantity_","individualpkgquantity_","keychainsquantity_","shipdhlquantity_"];
	for ($x=0; $x < sizeof($arrtotal) ; $x++) { 
		# code...
		if (strpos($label, $arrtotal[$x]) !== false) {
			return $newlabel[$x];
		}
	}
}

function change_price_name($label) {
	$arrtotal = ["mold_","printing_","laser_","colorfill_","embossedp_","imprintingp_","swirlp_","segmentedp_","glowp_","duallayerp_","insideembossed_","individualpkg","keychains","shipdhl_"];
	$newlabel =	["moldprice_", "printingprice_", "laserprice_","colorfillprice_","embossedprice_","imprintingprice_","swirlprice_","segmentedprice_","glowprice_","duallayerprice_","insideembossedprice_","individualpkgprice_","keychainsprice_","shipdhlprice_"];
	for ($x=0; $x < sizeof($arrtotal) ; $x++) { 
		# code...
		if (strpos($label, $arrtotal[$x]) !== false) {
			return $newlabel[$x];
		}
	}
}


function change_to_int($key) {
	$arrtotal = ["mold_","printing_","laser_","colorfill_","embossedp_","imprintingp_","swirlp_","segmentedp_","glowp_","duallayerp_","insideembossed_","individualpkg","keychains","shipdhl_"];
	// $newlabel =	["1", "1", "2","3","4","5","6","7","8","9","10","11","12","13"];
	for ($x=0; $x < sizeof($arrtotal) ; $x++) { 
		# code...
		if (strpos($key, $arrtotal[$x]) !== false) {
			return $x;
		}
	}
}



add_action( 'init', 'supp_artwork' );
function supp_artwork() {
	$post = $_POST;
	$user_id = get_current_user_id();

	if (isset($post['supp_artwork'])) {
		# code...
		//var_dump($post);
		$count = $post['img-count'];
		$image_arr = '';
		for ( $x=1;$x<=$count;$x++ ) {
			$name = 'img'.$x;
			$image_arr[$x] = $post[$name];
		}
		//	var_dump($image_arr);
		if ( ! add_post_meta( $post['post-id'], 'supplier_artwork',   $image_arr, true ) ) { 
			update_post_meta( $post['post-id'], 'supplier_artwork',   $image_arr );
		}
	}

}


add_action( 'init', 'change_list' );
function change_list() {
	$user_id = get_current_user_id();
	$post = $_POST;
	$key = '_new_status';
	if (!empty($_POST["maxrowval"])) {$row = $_POST["maxrowval"];} else { $row = ''; }
	$arrquantity = ["moldquantity_", "printingquantity_", "laserquantity_","colorfillquantity_","embossedquantity_","imprintingquantity_","swirlquantity_","segmentedquantity_","glowquantity_","duallayerquantity_","insideembossedquantity_","individualpkgquantity_","keychainsquantity_","shipdhlquantity_"];
	$arrprice = ["moldprice_", "printingprice_", "laserprice_","colorfillprice_","embossedprice_","imprintingprice_","swirlprice_","segmentedprice_","glowprice_","duallayerprice_","insideembossedprice_","individualpkgprice_","keychainsprice_","shipdhlprice_"];
	$arrtotal = ["mold_","printing_","laser_","colorfill_","embossedp_","imprintingp_","swirlp_","segmentedp_","glowp_","duallayerp_","insideembossed_","individualpkg_","keychains_","shipdhl_"];
    //echo $row;

	if ( isset( $post['update-price-list'] ) ) {
			# code...

			// echo $post['wtotalprice'].'</br>';
		$totalkey = 'wtotalprice';
			// echo '<pre>';
			// var_dump($image_arr);
			//  print_r($post);
			// echo $count.'</br>';

		 //echo $row;
		for ($x=0; $x < sizeof($arrtotal); $x++) { 
				# code...
			for ($i=0; $i < $row*10 ; $i++) {

				if(isset($post[$arrtotal[$x].$i]) && ($post[$arrtotal[$x].$i]!= 0)){
					if(isset($post[$arrquantity[$x].$i])){
						$newkey1 = $arrquantity[$x];
							//echo $newkey1.'='.$post[$arrquantity[$x].$i]."</br>";
						$parrqty[$newkey1][] = $post[$arrquantity[$x].$i];
							//add_post_meta( $post['order_id'], 'supplier_'.$newkey1,$post[$arrquantity[$x].$i]);
					}
					if(isset($post[$arrprice[$x].$i])){
						$newkey2 = $arrprice[$x];
							//echo $newkey2.'='.$post[$arrprice[$x].$i]."</br>";
							//$parrprice[]
						$parrprice[$newkey2][] = $post[$arrprice[$x].$i];
							//add_post_meta( $post['order_id'], 'supplier_'.$newkey2,$post[$arrprice[$x].$i]);
					}
					$newkey3 = $arrtotal[$x];
						//echo $newkey3.'='.$post[$arrtotal[$x].$i]."</br>";
					$parrtotal[$newkey3][] = $post[$arrtotal[$x].$i];
						//add_post_meta( $post['order_id'], 'supplier_'.$newkey3,$post[$arrtotal[$x].$i]);
				}
			}
		}

		if ( ! add_post_meta( $post['order_id'], 'supplier_wpqty',   $parrqty, true ) ) { 
			update_post_meta( $post['order_id'], 'supplier_wpqty',   $parrqty );
		}

		if ( ! add_post_meta( $post['order_id'], 'supplier_wpprice',   $parrprice, true ) ) { 
			update_post_meta( $post['order_id'], 'supplier_wpprice',   $parrprice );
		}

		if ( ! add_post_meta( $post['order_id'], 'supplier_wptotal',   $parrtotal, true ) ) { 
			update_post_meta( $post['order_id'], 'supplier_wptotal',   $parrtotal );
		}


		if ( ! add_post_meta( $post['order_id'], 'supplier_'.$totalkey, $post['wtotalprice'], true ) ) { 
			update_post_meta( $post['order_id'], 'supplier_'.$totalkey, $post['wtotalprice'] );
		}

		if ( ! add_post_meta( $post['order_id'], 'supplier_maxrowval', $post['maxrowval'], true ) ) { 
			update_post_meta( $post['order_id'], 'supplier_maxrowval', $post['maxrowval'] );
		}

		$redirect = home_url( 'supplier-dashboard/?action=view&ID='. $post['order_id'] );
		exit( wp_redirect( $redirect ) );
	}

}
add_action( 'init', 'supplier_report' );
function supplier_report(){
	$post = $_POST;

	if (isset($post['send-report-supp'])) {
		// var_dump($post);
		// die();
		//add report content
		add_post_meta( $post['order-id'], $post['user'].'_report_content', $post['report_content'] );
		//add report time
		$time = date('Y-m-d') . 'T' . date('H:i:s') . 'Z';
		add_post_meta( $post['order-id'], $post['user'].'_report_time_added', $time );
	}
}

add_action('wp_ajax_add-reply-supp', 'add_reply_supp');
add_action('wp_ajax_nopriv_add-reply-supp', 'add_reply_supp');
function add_reply_supp( $post = false ){
	
	$time = date('Y-m-d') . 'T' . date('H:i:s') . 'Z';
	$user_id = get_current_user_id();
	$user = wp_get_current_user();
	$post = $_REQUEST;

	$data = array(
		'comment_post_ID' 		=> $post['post-id'],
		'comment_author' 		=> $user->display_name,
		'comment_author_email'  => $user->user_email,
		'comment_content' 		=> $post['reply'],
		'user_id' 				=> $user_id,
		'comment_date' 			=> $time,
		'comment_approved' 		=> 1,
		);

	$insert_comment = wp_insert_comment( $data );

	if ( $insert_comment ) {
		/* Admin - User Notification
		*	1 = Seen or the Created by the user
		* 	0 = Not seen by the other user
		* 	1-0 = Created by admin, notified to the user
		*	0-1 = Created by user, notified to the admin
		*	1-1 = both seen by the user and admin
		*/
		if ( current_user_can( 'manage_options' ) ) {
			add_comment_meta( $insert_comment, 'notification_admin_supplier', '1-0' );
			exit( wp_send_json_success( $insert_comment ) );
		} else {
			add_comment_meta( $insert_comment, 'notification_admin_supplier', '0-1' );
			exit( wp_send_json_success( $insert_comment ) );
		}
	}
}

add_action( 'init', 'newuploadimage' );
function newuploadimage(){
	$post = $_POST;
	$user_id = get_current_user_id();

	if (isset($_FILES['newupload_image']))
	{

		$ufiles = array();
		$role = get_user_meta ( $user_id, 'custom_role', true );



		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		$upload_overrides = array( 'test_form' => false );

		$files = $_FILES['newupload_image'];
		foreach ($files['name'] as $key => $value) {
			if ($files['name'][$key]) {
				$uploadedfile = array(
					'name'     => $files['name'][$key],
					'type'     => $files['type'][$key],
					'tmp_name' => $files['tmp_name'][$key],
					'error'    => $files['error'][$key],
					'size'     => $files['size'][$key]
					);
				$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

				if ( $movefile && !isset( $movefile['error'] ) ) {
					$ufiles[] = $movefile;
				}
			}

		}

		if ($role == 'Supplier' ) {
			
			if ( ! add_post_meta( $post['order_id'],  $role . '_artwork',   $ufiles, true ) ) { 
				update_post_meta( $post['order_id'],  $role . '_artwork',   $ufiles );
			}
			$redirect = home_url( 'supplier-dashboard/?action=view&ID='. $post['order_id'] );
			exit( wp_redirect( $redirect ) );

		} elseif ($role == 'Employee') {

			if ( ! add_post_meta( $post['order_id'],  $role . '_artwork',   $ufiles, true ) ) { 
				update_post_meta( $post['order_id'],  $role . '_artwork',   $ufiles );
			}

			if ( ! add_post_meta( $post['order_id'],  'artwork_approve',   'not_approved', true ) ) { 
				update_post_meta( $post['order_id'],  'artwork_approve',   'not_approved' );
			}

			$redirect = home_url( 'employee-dashboard/?action=view&ID='. $post['order_id'] );
			exit( wp_redirect( $redirect ) );
		} elseif ($role == 'Admin') {
			if ( ! add_post_meta( $post['order_id'],  'Employee_artwork',   $ufiles, true ) ) { 
				update_post_meta( $post['order_id'],  'Employee_artwork',   $ufiles );
			}

			if ( ! add_post_meta( $post['order_id'],  'artwork_approve',   'not_approved', true ) ) { 
				update_post_meta( $post['order_id'],  'artwork_approve',   'not_approved' );
			}

			$redirect = home_url( 'admin-dashboard/?action=view&ID='. $post['order_id'] );
			exit( wp_redirect( $redirect ) );
		} elseif ($role == '') {
			if ( ! add_post_meta( $post['order_id'],  'Employee_artwork',   $ufiles, true ) ) { 
				update_post_meta( $post['order_id'],  'Employee_artwork',   $ufiles );
			}

			if ( ! add_post_meta( $post['order_id'],  'artwork_approve',   'not_approved', true ) ) { 
				update_post_meta( $post['order_id'],  'artwork_approve',   'not_approved' );
			}

			$redirect = home_url( 'admin-dashboard/?action=view&ID='. $post['order_id'] );
			exit( wp_redirect( $redirect ) );
		}
	}
}

add_action( 'init', 'updateuploadimage' );

function updateuploadimage(){
	$post = $_POST;
	$user_id = get_current_user_id();
	
	if (isset($post['supp_update_artwork'])) {
		// echo '<pre>';
		// var_dump($post);
		// var_dump($_FILES['add_image']);
		$role = get_user_meta ( $user_id, 'custom_role', true );
		$ufiles = array();
		for ($i=0; $i < sizeof($post) ; $i++) { 
			if(isset($post['img-file_'.$i])){

				$movefile = array(
					'file'     => $post['img-file_'.$i],
					'url'     => $post['img-url_'.$i],
					'type' => $post['img-type_'.$i]
					);
				// var_dump($movefile);

				if ( $movefile ) {
					$ufiles[] = $movefile;
				}

			}
		}

		
		if (($_FILES['add_image']['type'] == "")){
			
		}else{
			if ( ! function_exists( 'wp_handle_upload' ) ) 
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
			$uploadedfile = $_FILES['add_image'];
			$upload_overrides = array( 'test_form' => false );
			$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
			if ( $movefile && !isset( $movefile['error'] ) ) {
				$ufiles[] = $movefile;
			}
		}

		if ($role == 'Supplier' ) {
			update_post_meta( $post['order_id'], $role . '_artwork', $ufiles );
			$redirect = home_url( 'supplier-dashboard/?action=view&ID='. $post['order_id'] );
			exit( wp_redirect( $redirect ) );

		} elseif ($role == 'Employee') {

			update_post_meta( $post['order_id'], $role . '_artwork', $ufiles );

			if ( ! add_post_meta( $post['order_id'],  'artwork_approve',   'not_approved', true ) ) { 
				update_post_meta( $post['order_id'],  'artwork_approve',   'not_approved' );
			}

			$redirect = home_url( 'employee-dashboard/?action=view&ID='. $post['order_id'] );
			exit( wp_redirect( $redirect ) );
		} elseif ($role == 'Admin') {
			
			update_post_meta( $post['order_id'], 'Employee_artwork', $ufiles );

			if ( ! add_post_meta( $post['order_id'],  'artwork_approve',   'not_approved', true ) ) { 
				update_post_meta( $post['order_id'],  'artwork_approve',   'not_approved' );
			}

			$redirect = home_url( 'admin-dashboard/?action=view&ID='. $post['order_id'] );
			exit( wp_redirect( $redirect ) );
		} elseif ($role == '') {
			
			update_post_meta( $post['order_id'], 'Employee_artwork', $ufiles );

			if ( ! add_post_meta( $post['order_id'],  'artwork_approve',   'not_approved', true ) ) { 
				update_post_meta( $post['order_id'],  'artwork_approve',   'not_approved' );
			}
			
			$redirect = home_url( 'admin-dashboard/?action=view&ID='. $post['order_id'] );
			exit( wp_redirect( $redirect ) );
		}
	}
}