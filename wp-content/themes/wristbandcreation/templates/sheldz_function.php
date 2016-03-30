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

add_action( 'init', 'check_if_login' );
function check_if_login(){
	//initializing redirect url
	$redirect = home_url( 'login' );

	if ( ! is_user_logged_in () ) {
		if ( is_page( 'customer-dashboard' ) ) {
			exit( wp_redirect( $redirect ) );
		}
	}

	if ( is_page( 'admin-dashboard' ) ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			$redirect = home_url( 'customer-dashboard' );
			exit( wp_redirect( $redirect ) );
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
	$post = $_REQUEST;
	$new_pass = $post['pass'];

	$userdata = array(
		'ID' 		=> get_current_user_id(), 
		'user_pass' => $new_pass 
	);
	
	$user = wp_update_user( $userdata );

	if ( $user ) {
		$result = 'success';
		exit( wp_send_json_success( $result ) );
	} else {
		$result = 'wala ma change';
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

		// add_post_meta( $post['order-id'], '_report_title', $post['report_title'] );
		add_post_meta( $post['order-id'], '_report_content', $post['report_content'] );

		//$time = current_time('mysql');
		$time = date('Y-m-d') . 'T' . date('H:i:s') . 'Z';
		add_post_meta( $post['order-id'], '_report_time_added', $time );

		// add_post_meta( $post['order-id'], '_report_content', $post['report_content'] );

		$order_link = home_url('customer-dashboard/?action=view&ID='. $post['order-id'] );
		add_post_meta( $post['order-id'], '_report_order_link', $order_link);

		// $redirect = home_url( 'customer-dashboard/?action=view-report&post-id='. $post['order-id'] );
		// exit( wp_redirect( $redirect ) );	

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
		/* Admin - User Notification
		*	1 = Seen or the Created by the user
		* 	0 = Not seen by the other user
		* 	1-0 = Created by admin, notified to the user
		*	0-1 = Created by user, notified to the admin
		*	1-1 = both seen by the user and admin
		*/
		if ( current_user_can( 'manage_options' ) ) {
			add_comment_meta( $insert_comment, 'notification_admin_user', '1-0' );
			exit( wp_send_json_success( $insert_comment ) );
		} else {
			add_comment_meta( $insert_comment, 'notification_admin_user', '0-1' );
			exit( wp_send_json_success( $insert_comment ) );
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

function get_comments_list( $order_id ){

	$args = array(
		'comment_post_ID' => $order_id,
	);

	$comments =  fetch_comments( $args ); 

	// echo "<pre>";
	// print_r($comments);
	// die;
		
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
		where a.comment_post_ID = '{$args['comment_post_ID']}' AND b.meta_key = 'notification_admin_user'";
	
	$results = $wpdb->get_results( $sql );
	return $results;
}

function get_order_number_format( $order_id ){
	$length = strlen( $order_id );
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
 	if ($status == 'pending_production') {
	    return 'Pending Production';
	} elseif ($status == 'pending_artwork_approval') {
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
	    return 'No Status Yet';
	}

}

add_action( 'init', 'save_artwork' );
function save_artwork() {
	$post = $_POST;
	$user_id = get_current_user_id();

	if ( isset( $post['form-action'] ) && $post['form-action'] === 'admin-artwork' ) {
		$count = $post['img-count'];
		$image_arr = '';
		for ( $x=1;$x<=$count;$x++ ) {
			$name = 'img'.$x;
			$image_arr[$x] = $post[$name];
		}

	   	if ( ! add_post_meta( $post['post-id'], 'admin_artwork',   $image_arr, true ) ) { 
	    	update_post_meta( $post['post-id'], 'admin_artwork',   $image_arr );
	    }
	}

}
