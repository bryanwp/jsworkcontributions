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

include ('custom-header.php'); ?>

<div class="row">
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
		<div class="gap-top">
			<span class="welcome"><?php echo 'Welcome ' . $current_user->user_firstname; ?></span>
		</div>
		<div style="margin-top: 20px;">
			<h2>My Orders</h2>
		</div>

		<div class="table-1 no-overflow">
		<?php
$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
  'meta_key'    => '_customer_user',
  'meta_value'  => get_current_user_id(),
  'post_type'   => wc_get_order_types( 'view-orders' ),
  'post_status' => array_keys( wc_get_order_statuses() )
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
?>
	<div class="order-container">
		<a href="<?php echo esc_url( home_url('customer-dashboard/?action=view&ID=' . $customer_order->ID ) ); ?>"><h2><?php echo get_order_number_format( $order_id ); ?></h2></a>
		<?php foreach ( $items as $item ) {
		    $wristband_meta = maybe_unserialize( $item['wristband_meta']);
		    $color = $wristband_meta['colors'];
		?>
		<div class="details-container">
			<h3><?php echo $item['name']; ?> Wristband</h3>
			<div class="row">
					<div class="col-md-6">
						<table class="tbl-info" width="100%">
							<tr>
								<td>Width:</td>
								<td><?php echo $wristband_meta['size']; ?></td>
							</tr>
							<?php
								$color = $wristband_meta['colors'];
								foreach ($color as $colors) {
									$count = 1;
									$sizes = $colors['sizes'];
									foreach ( $sizes as $size ) {
										if ( $size >= 1 && $count === 1 ) {
											echo '<tr><td>Qty/Color/Size</td><td>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' Adult Size</td></tr>'; 
										} elseif ( $size >= 1 && $count === 2  ) {
											echo '<tr><td>Qty/Color/Size</td><td>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' Medium Size</td></tr>'; 
										} elseif ( $size >= 1 && $count === 3  ) {
											echo '<tr><td>Qty/Color/Size</td><td>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' Youth Size</td></tr>'; 
										} 
										$count++;
									}
								}
							?>
							<?php
								$options = $wristband_meta['messages'];
								foreach ( $options as $key => $msg ) {
									if ( empty( $msg ) ) {
										$msg = 'None';
									}
									echo '<tr><td>' . $key . ':</td><td>' . $msg . '</td></tr>'; 
								}

							?>
						</table>
					</div>

					<div class="col-md-6">
						<table class="tbl-info" width="100%">
							<?php
								$options = $wristband_meta['additional_options'];
								if ( $options ) {
									foreach ( $options as $option ) {
									echo '<tr><td>Addtional Options</td><td>' . $option . '</td></tr>'; 
									}
								} else {
									echo '<tr><td>Addtional Options</td><td>None</td></tr>'; 
								}
							?>
						</table>
						<table class="tbl-info" width="100%">
							<tr>
								<td>
									Date: 
								</td>
								<td>
									 <?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?>
								</td>
							</tr>
							<tr>
								<td>
									Payment Method: 
								</td>
								<td>
									<?php echo get_post_meta( $order_id, '_payment_method_title', true ); ?>
								</td>
							</tr>
							<tr>
								<td>
									Grand total: 
								</td>
								<td>
									<?php echo $order->get_formatted_order_total(); ?>
								</td>

							</tr>
						</table>
					</div>
				
			</div>
		</div>
		<?php } ?>
	</div>
<?php } ?>


<?php endif; ?>
		</div>
	</div>
</div>
<?php include ('custom-footer.php'); ?>