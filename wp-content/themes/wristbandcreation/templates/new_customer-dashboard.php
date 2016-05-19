<?php
 //Template Name: Customer Dashboard 
// check_if_login();

// foreach ( $results as $result => $post_id ) {
// 	$order = new WC_Order($post_id);
// 	$status = wc_get_order_statuses( $post_id );
	
// }
// echo '<pre>';
// print_r( $results );
// die;
if ( isset( $_GET['set-ses'] ) )
	include('customer/customer-session.php');


include ('custom-header.php'); ?>

<div class="row">
	<div class="gap-top">
		<span class="welcome"><?php echo 'Welcome ' . $current_user->user_firstname; ?></span>
	</div>
<!-- 	<div class="col-md-2">
		<ul class="dash-nav">
			<a href="<?php echo home_url('customer-dashboard'); ?>">
				<li>
					My Orders
				</li>
			</a>
			<a href="<?php echo home_url('customer-dashboard/?action=profile'); ?>">
				<li>
					My Profile
				</li>
			</a>
			<a href="<?php echo home_url('customer-dashboard/?action=notification'); ?>">
				<li>
					Notification 
				</li>
			</a>
		</ul> 
	</div>-->
	<?php
	$action = '';
	if ( isset( $_GET['action'] ) ) {
		$action = $_GET['action'];
	}

	if ( $action === 'view') {
		include ('customer/customer-dashboard-single.php');
	} elseif ( $action === 'profile' ) {
		include ('customer/customer-dashboard-profile.php');
	} elseif ( $action === 'notification' ) {
		include ('customer/customer-dashboard-notification.php');
	} elseif ( $action === 'report' ) {
		include ('customer/customer-dashboard-notif-form.php');
	} elseif ( $action === 'view-report' ) {
		include ( 'customer/customer-dashboard-single-report.php' );
	}
	
	?>
	<div class="col-md-12 white" <?php echo ($action == '') ? 'style="display:block"' : 'style="display:none"';?>>
		<div style="margin-top: 20px;">
			<?php the_title( '<h1>', '</h1>' ); ?>
			<h2>My Orders</h2>
		</div>

		<div class="table-1 no-overflow">
		<?php
$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
  'meta_key'    => '_customer_user',
  'meta_value'  => get_current_user_id(),
  'post_type'   => wc_get_order_types( 'view-orders' ),
  'post_status' => 'wc-completed'
) ) );

// echo "<pre>";
// print_r($customer_orders);
// die;

if ( $customer_orders ) : 
	 foreach ( $customer_orders as $customer_order ) {
	 	$orders = wc_get_order( $customer_order );
        $orders->populate( $customer_order );
        $order_id = $orders->get_order_number();

       	$order = new WC_Order( $order_id );
		$items = $order->get_items();

		foreach ( $items as $item ) {
		    $wristband_meta = maybe_unserialize( $item['wristband_meta']);
		    // $color = $wristband_meta['colors'];
		    $_SESSION['to_order_again'] = $wristband_meta;
		    // echo "<pre>";
		    // print_r( $wristband_meta );
		    // echo "<br />";
		}
?>
	<div class="order-container">
		<a href="<?php echo esc_url( home_url('customer-dashboard/?action=view&ID=' . $customer_order->ID ) ); ?>">
			<h2>
				<?php echo get_order_number_format( $order_id ); ?> (<?php echo get_status( get_post_meta( $order_id, '_new_status', true ) ); ?>)
			</h2>
		</a>
		<div class="reorder col-md-12">
			<a href="<?php echo home_url( 'customer-dashboard/?set-ses='. $order_id ); ?>" class="order-again btn-order"><?php _e( 'Order Again', 'woocommerce' ); ?></a>
			<!-- <a class="order-again btn-order">Order Again</a> -->
			<a class="order-edit btn-order order_edit_form">Order & Edit</a>
			<form method="post" id="order-edit" style="display: none;">
				<input type="hidden" name="form-action" value="order_edit">
				<input type="hidden" name="url" value="<?php echo esc_url( wp_nonce_url( add_query_arg( 'order_again', $order_id ) , 'woocommerce-order_again' ) ); ?>">
				<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
			</form>
		</div>
		<?php echo do_shortcode('[the-cart-meta item_key="'.$order_id.'"]'); ?>
	</div>
<?php } ?>


<?php endif; ?>
		</div>
	</div>
</div>
<?php include ('custom-footer.php'); ?>