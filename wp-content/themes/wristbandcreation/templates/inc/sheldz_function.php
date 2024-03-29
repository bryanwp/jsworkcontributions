<?php
/*
* Custom function
* Sheldz
*/

//include shortcodes/views for dynamic viewing 
include_once( get_stylesheet_directory() . '/templates/inc/shortcodes.php' );

//Register function for new user..
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

	if (isset($post['g-recaptcha-response']) && $post['g-recaptcha-response']) {
		 // echo "<pre>";
		// var_dump($post);
		$secret = "6Lef9SATAAAAAD6wUOqyCMNl7i42k1c4u0_ZdMHc";
		$ip = $_SERVER['REMOTE_ADDR'];
		$captcha = $post['g-recaptcha-response'];
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$rsp = file_get_contents( $url.'?secret='.$secret.'&response='.$captcha.'&remoteip='.$ip.'' );
		// var_dump($rsp);
		$arr = (json_decode($rsp,TRUE));


		if ( $arr['success'] ) {
			if ( isset( $post['add_user'] ) ) {
			   if ( $post['add_user'] === "Submit") {
			    $userdata = array(
			      'user_login'  =>  $email,
			      'user_pass'   =>  $cpass,
			      'first_name'  => $fname,
			      'last_name'   => $lname,
			      'role'        => $role,
			      'user_email'  => $email,
			      'user_nicename' => $fname
			    );

		        $user_id = wp_insert_user( $userdata );

		        if ( ! is_wp_error( $user_id ) ) {
			    	//adding user meta
			    	// add_user_meta( $user_id, 'user_company_name', $company_name  );
			    	// add_user_meta( $user_id, 'user_phone', $phone  );
			    	// add_user_meta( $user_id, 'user_credit_card_no', $card  );
			    	// add_user_meta( $user_id, 'user_country', $country  );
			    	// add_user_meta( $user_id, 'user_address', $address  );
			    	add_user_meta( $user_id, 'user_secret_question', $secret_question  );
			    	add_user_meta( $user_id, 'user_secret_answer', $sanswer  );

			    	add_user_meta( $user_id, 'billing_first_name', $fname );
					add_user_meta( $user_id, 'billing_last_name', $lname );
					add_user_meta( $user_id, 'billing_company', $company_name );
					add_user_meta( $user_id, 'billing_email', $email );
					add_user_meta( $user_id, 'billing_phone', $phone );
					add_user_meta( $user_id, 'billing_country', sanitize_text_field( $country ) );
					add_user_meta( $user_id, 'billing_address_1', $address );

			    	$redirect = home_url('login');
			      	exit (wp_redirect($redirect));
		        } else {
		        	echo 'error';
		       } 
	   		}
		}
		} else {
				$redirect = home_url('register');
		      	exit (wp_redirect($redirect));
		}


	}

	// echo "<pre>";
	// var_dump($post);
	// echo $country;


	

}


// add_action( 'init', 'check_if_login' );
// function check_if_login(){
// 	//initializing redirect url
// 	$current_user = wp_get_current_user();
// 	$redirect = home_url( 'login' );
// 	$role = get_user_meta ( $current_user->ID, 'custom_role', true );

// 	if ( ! is_user_logged_in () ) {
// 		if ( is_page( 'customer-dashboard' ) ) {
// 			exit( wp_redirect( $redirect ) );
// 		}
// 	}

// 	if ( is_page( 'admin-dashboard' ) ) {
// 		if ( ! current_user_can( 'manage_options' ) ) {
// 			$redirect = home_url( 'customer-dashboard' );
// 			exit( wp_redirect( $redirect ) );
// 		}
// 	}

// 	if ( is_page( 'supplier-dashboard' ) ) {
// 		if ( $role != 'Supplier' ) {
// 			$redirect = home_url( 'customer-dashboard' );
// 			exit( wp_redirect( $redirect ) );
// 		}
// 	}

// 	if ( is_page( 'employee-dashboard' ) ) {
// 		if ( $role != 'Employee' ) {
// 			$redirect = home_url( 'customer-dashboard' );
// 			exit( wp_redirect( $redirect ) );
// 		}
// 	}

// 		if ( is_page( 'customer-dashboard' ) ) {
// 		$role = get_user_meta ( $current_user->ID, 'custom_role', true );
// 		if ( $role == 'Employee' ) {
// 			$redirect = home_url( 'employee-dashboard' );
// 			exit( wp_redirect( $redirect ) );
// 		} elseif ($role == 'Supplier') {
// 			$redirect = home_url( 'supplier-dashboard' );
// 			exit( wp_redirect( $redirect ) );
// 		} elseif ($role == 'Admin') {
// 			$redirect = home_url( 'admin-dashboard' );
// 			exit( wp_redirect( $redirect ) );
// 		}
// 	}
// }

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

		$update = wp_update_user( $userdata );
		if ( ! is_wp_error( $update ) ) {
			//send report to log
			$msg = get_full_date( $req = 'full_date' ) . ' - Updated his/her profile Information - by -  ';
			action_log( $msg );
			//end send report
		}
	}
}

add_action('wp_ajax_change-user-password', 'change_user_password');
add_action('wp_ajax_nopriv_change-user-password', 'change_user_password');
function change_user_password(){
	include_once($_SERVER['DOCUMENT_ROOT'].'/wp-includes/class-phpass.php' );
	$post = $_REQUEST;
	$new_pass = $post['pass'];

	$wp_hasher = new PasswordHash(8, TRUE);

	$password_hashed = $post['hash'];
	$plain_password = $post['current'];

	if($wp_hasher->CheckPassword($plain_password, $password_hashed)) {
		   
		$userdata = array(
			'ID' 		=> get_current_user_id(), 
			'user_pass' => $new_pass 
		);
		
		$user = wp_update_user( $userdata );

		if ( $user ) {
			$result = 'success';
			exit( wp_send_json_success( $result ) );
		}

	} else {
	    $result = $password_hashed;
	 	exit( wp_send_json_success( $result ) );
	}	
}

add_action( 'init', 'update_user_billing_address' );
function update_user_billing_address() {
	$user_id = get_current_user_id();
	$post = $_POST;

	if ( isset( $post['form-action'] ) && $post['form-action'] === 'billing-address' ) {

		update_user_meta( $user_id, 'billing_first_name', $post['billing_first_name'] );
		update_user_meta( $user_id, 'billing_last_name', $post['billing_last_name'] );
		update_user_meta( $user_id, 'billing_company', $post['billing_company'] );
		update_user_meta( $user_id, 'billing_email', $post['billing_email'] );
		update_user_meta( $user_id, 'billing_phone', $post['billing_phone'] );
		update_user_meta( $user_id, 'billing_country', $post['billing_country'] );
		update_user_meta( $user_id, 'billing_address_1', $post['billing_address_1'] );
		update_user_meta( $user_id, 'billing_address_2', $post['billing_address_2'] );
		update_user_meta( $user_id, 'billing_city', $post['billing_city'] );
		update_user_meta( $user_id, 'billing_state', $post['billing_state'] );
		update_user_meta( $user_id, 'billing_postcode', $post['billing_postcode'] );

	}

}

add_action( 'init', 'update_user_shipping_address' );
function update_user_shipping_address() {
	$user_id = get_current_user_id();
	$post = $_POST;

	if ( isset( $post['form-action'] ) && $post['form-action'] === 'shipping-address' ) {

		update_user_meta( $user_id, 'shipping_first_name', $post['shipping_first_name'] );
		update_user_meta( $user_id, 'shipping_last_name', $post['shipping_last_name'] );
		update_user_meta( $user_id, 'shipping_company', $post['shipping_company'] );
		update_user_meta( $user_id, 'shipping_country', $post['shipping_country'] );
		update_user_meta( $user_id, 'shipping_address_1', $post['shipping_address_1'] );
		update_user_meta( $user_id, 'shipping_address_2', $post['shipping_address_2'] );
		update_user_meta( $user_id, 'shipping_city', $post['shipping_city'] );
		update_user_meta( $user_id, 'shipping_state', $post['shipping_state'] );
		update_user_meta( $user_id, 'shipping_postcode', $post['shipping_postcode'] );

	}

}

add_action( 'init', 'save_single_report' );
function save_single_report() {
	$user_id = get_current_user_id();
	$post = $_POST;

	if ( isset( $post['form-action'] ) && $post['form-action'] === 'send-report' ) {

		if ( add_post_meta( $post['order-id'], $post['user'].'_report_content', $post['report_content'], true ) ){
			update_user_meta( $post['order-id'], $post['user'].'_report_content', $post['report_content'] );
		}

		$time = date('Y-m-d') . 'T' . date('H:i:s') . 'Z';
		if ( add_post_meta( $post['order-id'], $post['user'].'_report_time_added', $time, true ) ) {
			update_user_meta( $post['order-id'], $post['user'].'_report_time_added', $time);
		}

		$order_link = home_url('supplier-dashboard/?action=view&ID='. $post['order-id'] );
		if ( add_post_meta( $post['order-id'], $post['user'].'_report_order_link', $order_link, true ) ) {
			update_user_meta( $post['order-id'], $post['user'].'_report_order_link', $order_link);
		}
	}

}

add_action('wp_ajax_add-reply', 'add_reply');
add_action('wp_ajax_nopriv_add-reply', 'add_reply');
function add_reply( $post = false ){
	
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
		/* Admin - User/supplier Notification
		*	1 = Seen or the Created by the user
		* 	0 = Not seen by the other user
		* 	1-0 = Created by admin, notified to the user
		*	0-1 = Created by user, notified to the admin
		*	1-1 = both seen by the user and admin
		*/

		$role = get_user_meta( get_current_user_id(),  'custom_role', true );
		
		if ( $role ) {
			if ( $role == 'Admin' || $role == 'Employee' ) {
				add_comment_meta( $insert_comment, $post['user'], '1-0' );
				exit( wp_send_json_success( $insert_comment ) );
			} else {
				add_comment_meta( $insert_comment, $post['user'], '0-1' );
				exit( wp_send_json_success( $insert_comment ) );
			}
		} else {
			if ( current_user_can( 'manage_options' ) ) {
				add_comment_meta( $insert_comment, $post['user'], '1-0' );
				exit( wp_send_json_success( $insert_comment ) );
			} else {
				add_comment_meta( $insert_comment, $post['user'], '0-1' );
				exit( wp_send_json_success( $insert_comment ) );
			} 
		}
		
	}
}

add_action('wp_ajax_get-notification', 'get_notification');
add_action('wp_ajax_nopriv_get-notification', 'get_notification');
function get_notification( $user_id ){
	global $wpdb;

	$sql = "SELECT * FROM $wpdb->comments where comment_post_ID = '{$args['comment_post_ID']}'";
	$results = $wpdb->get_results( $sql );
}

function get_comments_list( $order_id , $meta_key ){

	$args = array(
		'comment_post_ID' => $order_id,
		'meta_key' => $meta_key
	);

	$comments =  fetch_comments( $args ); 
		
	foreach ( $comments as $comment ) { 
		$user = get_user_by( 'email', $comment->comment_author_email );
		$datetime = str_replace(" ", "T", $comment->comment_date) . 'Z';
		?> 
			<li>
				<div class="single-comment">
					<!-- <img src="http://0.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?s=32&d=mm&r=g" class="img-thumbnail" alt="Cinque Terre"> -->
					<p><?php echo $user->display_name; ?> <span class="time-ago"><time class="timeago" datetime="<?php echo $datetime; ?>">...</time></span></p>
					<span><?php echo $comment->comment_content; ?></span>
				</div>
			</li>
		<?php
		update_comment_meta( $comment->comment_ID, $meta_key, '1-1' );
	 } 	
}

add_action( 'wp_ajax_getComments-ajax', 'getComments_ajax' );
add_action( 'wp_ajax_nopriv_getComments-ajax', 'getComments_ajax' );
function getComments_ajax(){
	$post = $_REQUEST;
	$order_id = $post['id'];
	$user = $post['code'];
	$meta_key = $post['user'];
	global $wpdb;

	$sql = "SELECT 
		a.comment_ID,
		a.comment_post_ID,
		a.comment_content,
		a.comment_author_email,
		a.user_id,
		a.comment_date,
		b.meta_key,
		b.meta_value

		FROM $wpdb->comments as a
		INNER JOIN $wpdb->commentmeta as b
		ON a.comment_ID = b.comment_id
		where a.comment_post_ID = '$order_id'
		AND b.meta_key = '$meta_key'
		AND b.meta_value = '$user'";
	
	$results = $wpdb->get_results( $sql );
	$c = '';
	if ( $results ) {
		foreach ( $results as $comment ) { 
			$user = get_user_by( 'email', $comment->comment_author_email );
			$datetime = str_replace(" ", "T", $comment->comment_date) . 'Z';
	
			$c.='<li>';
				$c.='<div class="single-comment">';
					$c.='<p>'.$user->display_name .' <span class="time-ago"><time class="timeago" datetime="'.$datetime.'"> ...</time></span></p>';
					$c.='<span>'.$comment->comment_content.'</span>';
				$c.='</div>';
			$c.='</li>';

			if (update_comment_meta( $comment->comment_ID, $post['user'], '1-1' ) ) {
				exit(wp_send_json_success( $c ) );
			}
			
	 	} 
	}
}

function fetch_comments( $args ){
	global $wpdb;

	$sql = "SELECT 
		a.comment_ID,
		a.comment_post_ID,
		a.comment_content,
		a.comment_author_email,
		a.user_id,
		a.comment_date,
		b.meta_key,
		b.meta_value

		FROM $wpdb->comments as a
		INNER JOIN $wpdb->commentmeta as b
		ON a.comment_ID = b.comment_id
		where a.comment_post_ID = '{$args['comment_post_ID']}' AND b.meta_key = '{$args['meta_key']}'";
	
	$results = $wpdb->get_results( $sql );
	return $results;
}

function get_order_number_format( $order_id ){
	$id = (string)$order_id;
	$length = strlen( $id );
	$format = '';
	if ( $length == 3 ) {
		 $format = 'WC-000' . $order_id;
	} elseif ( $length == 4 ) {
		$format = 'WC-00' . $order_id;
	} elseif ( $length == 5 ) {
		$format = 'WC-0' . $order_id;
	} elseif ( $length == 6 ) {
		$format = 'WC-' . $order_id;
	} elseif ( $length == 2 ) {
		$format = 'WC-0000' . $order_id;
	} elseif ( $length == 1 ) {
		$format = 'WC-00000' . $order_id;
	}

	return $format;
}

add_action('wp_ajax_check-notif', 'check_notif');
add_action('wp_ajax_nopriv_check-notif', 'check_notif');
function check_notif( $post ) {
	global $wpdb;
	$post = $_REQUEST;
	$post_id = $post['post-id'];

	$sql = "SELECT a.comment_ID, b.meta_value
			FROM $wpdb->comments as a
			INNER JOIN $wpdb->commentmeta as b
			ON a.comment_ID = b.comment_id
			where a.comment_post_ID = '$post_id' AND b.meta_key = 'notification_admin_user' AND b.meta_value = '0-1'";
	
	$results = $wpdb->get_results( $sql );
	//$status = get_comment_meta( $post['post-id'], 'notification_admin_user', true );


	if ( current_user_can( 'manage_options' ) ) {
		if ( $results ) {
			$isFresh = true;
			exit( wp_send_json_success( $results ) );
		} else {
			$isFresh = false;
			exit( wp_send_json_success( $results ) );
		}
	}
}

add_action( 'init', 'check_notif_onload' );
function check_notif_onload( $post_id ) {
	global $wpdb;

	$sql = "SELECT COUNT(*)
			FROM $wpdb->comments as a
			INNER JOIN $wpdb->commentmeta as b
			ON a.comment_ID = b.comment_id
			WHERE a.comment_post_ID = '$post_id' AND b.meta_key ='notification_admin_user' AND b.meta_value = '0-1'";
	$results = $wpdb->get_var( $sql );

	if ( $results ) {
		$output = '<span class="badge" id=' . $post_id . ' style="display:inline">'. $results .'</span>';
		return $output;
	} else {
		$output = '<span class="badge" id=' . $post_id . '></span>';
		return $output;
	}
}

function get_status( $status ) {
 	if ($status == 'pending_artwork_approval') {
	    return 'Pending Artwork Approval';
	} elseif ($status == 'in_production') {
	    return 'In Production';
	} elseif ($status == 'in_reproduction') {
	    return 'In Reproduction';
	} elseif ($status == 'produced_pending_shipment') {
	    return 'Produced Pending Shipment';
	} elseif ($status == 'shipped') {
	    return 'Shipped';
	} else {
	    return 'Pending Production';
	}

}

// add_action( 'init', 'save_artwork' );
// function save_artwork() {
// 	$post = $_POST;
// 	$user_id = get_current_user_id();

// 	if ( isset( $post['form-action'] ) && $post['form-action'] === 'admin-artwork' ) {
// 		$count = $post['img-count'];
// 		$image_arr = '';
// 		for ( $x=1;$x<=$count;$x++ ) {
// 			$name = 'img'.$x;
// 			$image_arr[$x] = $post[$name];
// 		}

// 	   	if ( ! add_post_meta( $post['post-id'], 'admin_artwork',   $image_arr, true ) ) { 
// 	    	update_post_meta( $post['post-id'], 'admin_artwork',   $image_arr );
// 	    }

// 	    if ( ! add_post_meta( $post['post-id'], 'artwork_approve', 'not_approved', true ) ) {
// 	    	update_post_meta( $post['post-id'], 'artwork_approve', 'not_approved' );
// 	    }	
// 	}
// }

add_action( 'wp_ajax_accept-artwork-ajax', 'save_artwork_ajax' );
add_action( 'wp_ajax_nopriv_accept-artwork-ajax', 'save_artwork_ajax' );
function save_artwork_ajax(){
	$post = $_REQUEST;

	if ( ! add_post_meta( $post['post_id'], $post['meta_key'],   $post['img_arr'], true ) ) { 
	    	update_post_meta( $post['post_id'], $post['meta_key'],   $post['img_arr'] );
	}

	if ( $post['meta_key'] == 'admin_artwork' ) {
		if ( ! add_post_meta( $post['post_id'], 'artwork_approve', 'not_approved', true ) ) {
    		update_post_meta( $post['post_id'], 'artwork_approve', 'not_approved' );
    	}
	}
	exit( wp_send_json_success($post['img_arr']) );
}

add_action( 'wp_ajax_accept-artwork', 'accept_artwork' );
add_action( 'wp_ajax_nopriv_accept-artwork', 'accept_artwork' );
function accept_artwork() {
	$post = $_REQUEST;
	if ( update_post_meta( $post['postid'], 'artwork_approve', 'approved' ) ) {
		exit(wp_send_json_success( 'success' ));
	}

}

function enqueue_wristband_css_js(){
	wp_register_script('jquery-ui-widget_js', WBC_ASSETS_URL . '/js/vendor/jquery-fileupload/vendor/jquery.ui.widget.js', array('jquery'), WBC_VERSION, true);
    wp_register_script('jquery-xdr-transport_js', WBC_ASSETS_URL . '/js/vendor/jquery-fileupload/cors/jquery.xdr-transport.js', array('jquery'), WBC_VERSION, true);
    wp_register_script('jquery-iframe-transport_js', WBC_ASSETS_URL . '/js/vendor/jquery-fileupload/jquery.iframe-transport.js', array('jquery'), WBC_VERSION, true);
    wp_register_script('jquery-fileupload_js', WBC_ASSETS_URL . '/js/vendor/jquery-fileupload/jquery.fileupload.js', array('jquery'), WBC_VERSION, true);
    wp_register_script('ddslick_js', WBC_ASSETS_URL . '/js/vendor/jquery.ddslick.min.js', array('jquery'), WBC_VERSION, true);
    wp_register_script('pablo_js', WBC_ASSETS_URL . '/js/vendor/pablo.js', array('jquery'), WBC_VERSION, true);
    wp_register_script('mustache_js', WBC_ASSETS_URL . '/js/vendor/mustache.min.js', array('jquery'), WBC_VERSION, true);
    wp_register_script('wristbandData_js', WBC_ASSETS_URL . '/js/wristbandData.js', array('jquery'), WBC_VERSION, true);

    // wp_register_script('rgbcolor_js', WBC_ASSETS_URL . '/js/rgbcolor.js', array('jquery'), WBC_VERSION, true);
    // wp_register_script('canvg_js', WBC_ASSETS_URL . '/js/canvg.js', array('jquery'), WBC_VERSION, true);

    wp_register_script('wristband_js', WBC_ASSETS_URL . '/js/wristband.js', array('jquery'), WBC_VERSION, true);
    wp_enqueue_script('jquery-ui-widget_js');
    wp_enqueue_script('jquery-iframe-transport_js');
    wp_enqueue_script('jquery-fileupload_js');
    wp_enqueue_script('ddslick_js');
    wp_enqueue_script('pablo_js');
    wp_enqueue_script('mustache_js');
    wp_enqueue_script('wristbandData_js');

    // wp_enqueue_script('rgbcolor_js');
    //  wp_enqueue_script('canvg_js');

    wp_enqueue_script('wristband_js');


    wp_localize_script('wristband_js', 'WBC', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'settings' => isset($GLOBALS['wbc_settings']) ? $GLOBALS['wbc_settings'] : array(),
    ));
    wp_register_style('google_font_style', 'https://fonts.googleapis.com/css?family=Asset|Press+Start+2P|Diplomata|Diplomata+SC|Ultra|Syncopate|Corben|Shojumaru|Gravitas+One|Holtwood+One+SC|Delius+Unicase|Sonsie+One|Nosifer|Krona+One|Plaster|Chango|Geostar+Fill|Goblin+One|Revalia|Ewert|Geostar|Arbutus', array(), WBC_VERSION);
    wp_register_style('jquery-file-upload_style', WBC_ASSETS_URL . '/css/vendor/jquery-fileupload/jquery.fileupload.css', array(), WBC_VERSION);
    wp_register_style('wristband_style', WBC_ASSETS_URL . '/css/wristband.css', array(), WBC_VERSION);
    wp_register_style('list_of_fonts', WBC_ASSETS_URL . '/css/font.css', array(), WBC_VERSION);

    wp_enqueue_style('google_font_style');
    wp_enqueue_style('jquery-file-upload_style');
    wp_enqueue_style('wristband_style');
    wp_enqueue_style('list_of_fonts');
}

// Post order notes ajax function...
add_action('wp_ajax_save-post-order-notes', 'save_post_order_notes');
add_action('wp_ajax_nopriv_save-post-order-notes', 'save_post_order_notes');
function save_post_order_notes() {
	$post = $_REQUEST;
	$check = '';
	if ( ! add_post_meta( $post['postid'], 'post_order_note', $post['notes'], true ) ) {
		
		if ( update_post_meta( $post['postid'], 'post_order_note', $post['notes'] ) ) {
			$check = 'working';
		} else {
			$check = 'wala';
		}

	}
	exit( wp_send_json_success( $post['postid'] ) ); 
}

// add_action('init', 'save_user_made_by_admin');
add_action( 'wp_ajax_save-user-made-by-admin', 'save_user_made_by_admin');
add_action( 'wp_ajax_nopriv_save-user-made-by-admin', 'save_user_made_by_admin');
function save_user_made_by_admin() {
	$post = $_REQUEST;

	$userdata = array(
      'user_login'  =>  $post['email'],
      'user_pass'   =>  $post['pass'],
      'first_name'  => $post['fname'],
      'last_name'   => $post['lname'],
      'user_email'  => $post['email'],
      'user_nicename' => $post['fname'] . ' ' . $post['lname']
    );

    if ( $post['role'] == 'Admin' ) {
    	$userdata['role'] = 'Administrator';
    }

    $user_id = wp_insert_user( $userdata );

        if ( ! is_wp_error( $user_id ) ) {
	    	//adding user meta
	    	add_user_meta( $user_id, 'custom_role', $post['role']  ); 
			exit ( wp_send_json_success( $user_id ) );
        } else {
        	exit (wp_send_json_error( false ) );
       } 
}

add_action('init', 'bulk_action');
function bulk_action(){
	$post = $_POST;
	if ( isset( $post['form-action'] ) && $post['form-action'] === 'bulk' ) {

		$ids = json_decode( stripslashes($post['selected-ids']), true ); 
		require_once(ABSPATH.'wp-admin/includes/user.php' );
		foreach ( $ids as $id ) {
			$user = get_userdata( $id );
			
			//delete user
			if ( wp_delete_user( $id ) ) {
				//send report to log
				$msg = get_full_date( $req = 'full_date' ) . ' - User '. $user->user_email . ' was Delete - by -  ';
				action_log( $msg );
				//end send report
			}
		}
	}
}

function action_log( $msg ) {
	$current_user = wp_get_current_user();
	// $path = "/wp-content/themes/wristbandcreation/templates/inc/log.txt";
	$path =  get_stylesheet_directory() . "/templates/logs/". date('Y-m-d') .".txt";
	// ini_set("allow_url_fopen", true);
	$myfile = (file_exists($path)) ? fopen($path, "a+") : fopen($path, "w+");
	$txt = $msg.$current_user->display_name."\n";
	
	if ( $myfile ) {
	 	fwrite( $myfile, $txt );
		fclose( $myfile );
		chmod($path, 0777);
		$result = $path;
		return $result;
	} else {
		$result = $path;
		return $result;
	}
}

add_action('wp_ajax_action-log-ajax', 'action_log_ajax');
add_action('wp_ajax_nopriv_action-log-ajax', 'action_log_ajax');
function action_log_ajax(){
	
	$post = $_REQUEST;
	$msg = $post['msg'];
	$write = action_log( $msg );

	exit( wp_send_json_success( $write ) );
}

function get_full_date( $req ){

	date_default_timezone_set('Singapore');
    // $months = ['January','Febuary','March','April','May','June','July','August','September','October','November','December'];
    $year = date("Y");
    $month = date("F");
    $day = date("d");
    $hour = date("H");
	$min =  date("i");
	$sec = 	date("s");
	$date = $month . ' ' . $day . ', ' . $year;
	$date_time =  $month . ' ' . $day . ', ' . $year . ' ' . $hour .':' . $min . ':' . $sec;

	if ( $req == '' ) {
	   return $date;
	} else {
	   return $date_time;
	}
}

function logout_user(){
	$redirect = home_url('login');
	$output = '';
		$output.='<form method="post" class="logout">';
			$output.='<input type="hidden" name="form-action" value="logout">';
			$output.='<input type="hidden" name="logout-url" value="'. wp_logout_url( $redirect ) .'">';
		$output.='</form>';
	return $output;
	 
}

add_action('init', 'logout_user_handler');
function logout_user_handler(){
	$post = $_POST;

	if ( isset( $post['form-action'] ) && $post['form-action'] === 'logout' ) {
		//send report to log
		$user = wp_get_current_user();

		$msg = get_full_date( $req = 'full_date' ) . ' - '. $user->user_email .' has logged out - ';
		action_log( $msg );
		//end send report

		exit( wp_redirect( $post['logout-url'] ) );
	}
}

/* additional action
 * Date: Apri 19, 2016
 * Purposr: Setting Session for order again cart
 * Author: Sheldon A.
*/
add_action('wc_order_again', 'set_cart_session_for_order_again');
function set_cart_session_for_order_again(){
  if ( isset ( $_SESSION['to_order_again'] ) ) {

  	//setting the session in a variable
   	$session = $_SESSION['to_order_again'];

    //checking the session if an array or not
    //if not array - the session is from dashboard
    //if array - the session is fron single order/ dashboard-single
    if ( ! is_array( $_SESSION['to_order_again'] ) ) {
    	$order_id = $_SESSION['to_order_again'];
    	$order = new WC_Order( $order_id );
		$items = $order->get_items();
		
		foreach ( $items as $item ) {
		    $wristband_meta = maybe_unserialize( $item['wristband_meta']);

		    //setting new value of the session
			$session = $wristband_meta;
		}
    }

    $cart = WC()->cart->get_cart();
    $count = 1;
    foreach ( $cart as $cart_item_key => $cart_item ) {
      if ( $count == 1 ) {
        $cart[$cart_item_key]['wristband_meta'] = $session;
        // echo $cart_item_key;
      }
      $count++;
    }
    unset($_SESSION['to_order_again']);
    WC()->session->set( 'cart', $cart );
	//wp_redirect( home_url('checkout') );
	// echo "<pre>";
	// print_r($_SESSION['to_order_again']);
	// print_r($cart);
	?>
		please wait we are setting the cart...
		<script type="text/javascript">
			   window.location.reload(1);
		</script>
	<?php
	die;
  } else if ( isset ( $_SESSION['order_and_edit'] ) ) {
    $cart = WC()->cart->get_cart();
    $count = 1;
    $ses_id ='';
    foreach ( $cart as $cart_item_key => $cart_item ) {
      if ( $count == 1 ) {
      	$ses_id = $cart_item_key;
        $cart[$cart_item_key]['wristband_meta'] = $_SESSION['order_and_edit'];
        // echo $cart_item_key;
      }
      $count++;
    }
    unset($_SESSION['order_and_edit']);
    WC()->session->set( 'cart', $cart );
	?>
		please wait we are setting the editor...
		<script type="text/javascript">
			    window.location.href = "<?php echo home_url('order-now/?id='.$ses_id.'&Status=copy'); ?>";
		</script>
	<?php
	die;
  }
}

add_action( 'wc_order_edit', 'order_and_edit' );
function order_and_edit(){
	$post = $_POST;
	if ( isset( $post['form-action'] ) && $post['form-action'] === 'order_edit' ) {
		//checking the session if an array or not
	    //if not array - the session is from dashboard
	    //if array - the session is fron single order/ dashboard-single
	    if ( ! is_array( $_SESSION['to_order_again'] ) ) {
	    	$order_id = $post['order_id'];
	    	$order = new WC_Order( $order_id );
			$items = $order->get_items();
			
			foreach ( $items as $item ) {
			    $wristband_meta = maybe_unserialize( $item['wristband_meta']);

			    //setting new value of the session
				$session = $wristband_meta;
			}
	    } else {
	    	//setting the session in a variable
	   		$session = $_SESSION['to_order_again'];
	    }

		$_SESSION['order_and_edit'] = $session;
		unset( $_SESSION['to_order_again'] );
		?>
			<script type="text/javascript">
				window.location.href = "<?php echo $post['url']; ?>";
			</script>
		<?php
		break;
	}
}

add_action('wp_head', 'set_order_session');
function set_order_session(){
	if ( is_page('cart') || is_page('order-now') ) {
	session_start();
	global $woocommerce;
		session_start();
		do_action('wc_order_again');
	}
}
// function wpdocs_dequeue_script() {
   
// }
// add_action( 'wp_print_scripts', 'wpdocs_dequeue_script', 100 );

function remove_scripts(){
	add_action( 'wp_head', 'deregister_scripts' );
}
function deregister_scripts(){

	wp_deregister_script( 'webfontloader' );
	wp_deregister_script('admin-bar');
	wp_deregister_script('greensock');
	wp_deregister_script('layerslider');
	wp_deregister_script('layerslider-transitions');
	wp_deregister_script('bbpress-editor');
	wp_deregister_script('contact-form-7');
	wp_deregister_script('tp-tools');
	wp_deregister_script('revmin');
	wp_deregister_script('wc-add-to-cart');
	wp_deregister_script('woocommerce');
	wp_deregister_script('wc-cart-fragments');
	wp_deregister_script('mod-home-script');
	wp_deregister_script('media-editor');
	wp_deregister_script('media-audiovideo');
	wp_deregister_script('comment-reply');
	wp_deregister_script('cssua');
	wp_deregister_script('Froogaloop');
	wp_deregister_script('jquery.easyPieChart');
	wp_deregister_script('jquery.infinitescroll');
	wp_deregister_script('imagesLoaded');
	wp_deregister_script('excanvas');
	wp_deregister_script('isotope');
	wp_deregister_script('jquery.appear');
	wp_deregister_script('jquery.touchSwipe');
	wp_deregister_script('jquery.carouFredSel');
	wp_deregister_script('jquery.countTo');
	wp_deregister_script('jquery.countdown');
	wp_deregister_script('jquery.cycle');
	wp_deregister_script('jquery.easing');
	wp_deregister_script('jquery.elasticslider');
	wp_deregister_script('jquery.fitvids');
	wp_deregister_script('jquery.flexslider');
	wp_deregister_script('jquery.fusion_maps');
	wp_deregister_script('jquery.hoverflow');
	wp_deregister_script('jquery.hoverIntent');
	wp_deregister_script('jquery.placeholder');
	wp_deregister_script('jquery.toTop');
	wp_deregister_script('jquery.waypoints');
	wp_deregister_script('modernizr');
	wp_deregister_script('jquery.requestAnimationFrame');
	wp_deregister_script('jquery.mousewheel');
	wp_deregister_script('ilightbox.packed');
	wp_deregister_script('avada-lightbox');
	wp_deregister_script('avada-header');
	wp_deregister_script('avada-select');
	wp_deregister_script('avada-parallax');
	wp_deregister_script('avada-video-bg');
	wp_deregister_script('avada-woocommerce');
	wp_deregister_script('sendpress-signup-form-js');
	wp_deregister_script('wp-embed');
	wp_deregister_script('avada');

	wp_deregister_style('admin-bar');
	wp_deregister_style('layerslider');
	wp_deregister_style('ls-google-fonts');
	wp_deregister_style('bbp-default');
	wp_deregister_style('contact-form-7');
	wp_deregister_style('rs-plugin-settings');
	wp_deregister_style('woocommerce-layout');
	wp_deregister_style('woocommerce-smallscreen');
	wp_deregister_style('woocommerce-general');
	wp_deregister_style('yoast-seo-adminbar');
	wp_deregister_style('media-views');
	wp_deregister_style('imgareaselect');
	wp_deregister_style('list_of_icons');
	wp_deregister_style('avada-iLightbox');
	wp_deregister_style('avada-animations');
	wp_deregister_style('avada-woocommerce');
	wp_deregister_style('avada-bbpress');
	wp_deregister_style('sendpress-fe-css');
	wp_deregister_style('avada-shortcodes');

}

add_action('wp_head', 'debug_scripts_queued');
function debug_scripts_queued() {
    global $wp_styles;
    echo '<!--- SCRIPTS QUEUED'."\r\n";
    foreach ( $wp_styles->queue as $script ) {
        echo "\r\nSCRIPT: ".$script."\r\n";
        $deps = $wp_styles->registered[$script]->deps;
        if ($deps) {
            echo "DEPENDENCIES: ";
            print_r($deps);
        }
    }
    echo "\r\n--->";
}

// add_action( 'phpmailer_init', 'wpse8170_phpmailer_init' );
// function wpse8170_phpmailer_init( PHPMailer $phpmailer ) {
//     $phpmailer->Host = 'bluehost.com';
//     $phpmailer->Port = 25; // could be different
//     $phpmailer->Username = 'gwplabsc@box978.bluehost.com'; // if required
//     $phpmailer->Password = '3VlvUopv-4'; // if required
//     $phpmailer->SMTPAuth = true; // if required
//     $phpmailer->SMTPSecure = 'ssl'; // enable if required, 'tls' is another possible value

//     $phpmailer->IsSMTP();
// }

/*
* Description: get_reporting_info() for reporting page
* by: Sheldon A.
*/
function get_reporting_info( $method, $date ) {
	// echo $method . ' ' . $date ;
	global $wpdb;
	$year = date(Y);
	// echo $date;
	$ret = '';
	switch ( $method ) {
		case 'customer_count':
			$sql = "SELECT b.meta_value as id
			FROM $wpdb->posts as a
			INNER JOIN $wpdb->postmeta as b
			ON a.ID = b.post_id
			INNER JOIN $wpdb->postmeta as c
			ON a.ID = c.post_id
			AND c.meta_key = '_completed_date'
			WHERE a.post_status = 'wc-completed'
			AND b.meta_key = '_customer_user'
			AND DATE_FORMAT( c.meta_value, '%M' ) = '$date'
			AND DATE_FORMAT( c.meta_value, '%Y' ) = '$year'
			GROUP BY b.meta_value";

			$result = $wpdb->get_results( $sql );
			$ret = count( $result );
			break;
		case 'order_count':
			$sql = "SELECT a.ID
			FROM $wpdb->posts as a
			INNER JOIN $wpdb->postmeta as c
			ON a.ID = c.post_id
			AND c.meta_key = '_completed_date'
			WHERE a.post_status = 'wc-completed'
			AND DATE_FORMAT( c.meta_value, '%M' ) = '$date'
			AND DATE_FORMAT( c.meta_value, '%Y' ) = '$year'";

			$result = $wpdb->get_results( $sql );
			$ret = count( $result );
			break;
		case 'sales_amount':
			$sql = "SELECT woo.meta_value
			FROM $wpdb->posts as a
				INNER JOIN $wpdb->postmeta as c
					ON a.ID = c.post_id
					AND c.meta_key = '_completed_date'
				INNER JOIN wcv2_woocommerce_order_items as wo
					ON a.ID = wo.order_id
					AND wo.order_item_type = 'line_item'
				INNER JOIN wcv2_woocommerce_order_itemmeta as woo
					ON wo.order_item_id = woo.order_item_id
					AND woo.meta_key = '_line_total'
			WHERE a.post_status = 'wc-completed'
			AND DATE_FORMAT( c.meta_value, '%M' ) = '$date'
			AND DATE_FORMAT( c.meta_value, '%Y' ) = '$year'";

			$result = $wpdb->get_results( $sql );
			// $ret = $result;
			$sum = 0;

			foreach ( $result as $v ) {
				$sales = $v->meta_value;
				$sum = $sum + (float)$sales;
			}
			// echo "<pre>";
			// print_r( $result );
			$ret = round( $sum, 2 );
			break;
	}

	wp_reset_query();
	return $ret;
}
function search_reporting_info( $method, $date_from, $date_to ) {
	global $wpdb;
	$ret = "";
	switch ( $method ) {
		case 'customer_count':
			$sql = "SELECT b.meta_value as id
			FROM $wpdb->posts as a
			INNER JOIN $wpdb->postmeta as b
			ON a.ID = b.post_id
			INNER JOIN $wpdb->postmeta as c
			ON a.ID = c.post_id
			AND c.meta_key = '_completed_date'
			WHERE a.post_status = 'wc-completed'
			AND b.meta_key = '_customer_user'
			AND STR_TO_DATE( c.meta_value, '%Y-%m-%d' ) >= '$date_from'
			AND STR_TO_DATE( c.meta_value, '%Y-%m-%d' ) <= '$date_to'
			GROUP BY b.meta_value";

			$result = $wpdb->get_results( $sql );
			$ret = count( $result );
			break;
		case 'order_count':
			$sql = "SELECT a.ID
			FROM $wpdb->posts as a
			INNER JOIN $wpdb->postmeta as c
			ON a.ID = c.post_id
			AND c.meta_key = '_completed_date'
			WHERE a.post_status = 'wc-completed'
			AND STR_TO_DATE( c.meta_value, '%Y-%m-%d' ) >= '$date_from'
			AND STR_TO_DATE( c.meta_value, '%Y-%m-%d' ) <= '$date_to'";

			$result = $wpdb->get_results( $sql );
			$ret = count( $result );
			break;
		case 'sales_amount':
			$sql = "SELECT woo.meta_value
			FROM $wpdb->posts as a
				INNER JOIN $wpdb->postmeta as c
					ON a.ID = c.post_id
					AND c.meta_key = '_completed_date'
				INNER JOIN wcv2_woocommerce_order_items as wo
					ON a.ID = wo.order_id
					AND wo.order_item_type = 'line_item'
				INNER JOIN wcv2_woocommerce_order_itemmeta as woo
					ON wo.order_item_id = woo.order_item_id
					AND woo.meta_key = '_line_total'
			WHERE a.post_status = 'wc-completed'
			AND STR_TO_DATE( c.meta_value, '%Y-%m-%d' ) >= '$date_from'
			AND STR_TO_DATE( c.meta_value, '%Y-%m-%d' ) <= '$date_to'";

			$result = $wpdb->get_results( $sql );
			// $ret = $result;
			$sum = 0;

			foreach ( $result as $v ) {
				$sales = $v->meta_value;
				$sum = $sum + (float)$sales;
			}
			// echo "<pre>";
			// print_r( $result );
			$ret = round( $sum, 2 );
			break;
	}

	wp_reset_query();
	return $ret;
} 

