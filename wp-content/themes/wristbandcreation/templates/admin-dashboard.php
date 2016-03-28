<?php
 //Template Name: Admin Dashboard
check_if_login();

// foreach ( $results as $result => $post_id ) {
// 	$order = new WC_Order($post_id);
// 	$status = wc_get_order_statuses( $post_id );
	
// }
// echo '<pre>';
// print_r( $results );
// die;

include ('custom-header.php'); ?>

<div class="row">
	<?php
	$action = '';
	if ( isset( $_GET['action'] ) ) {
		$action = $_GET['action'];
	}

	if ( $action === 'view') {
		include ('admin/admin-dashboard-single.php');
	} elseif ( $action === 'profile' ) {
		include ('admin/admin-dashboard-profile.php');
	} elseif ( $action === 'notification' ) {
		include ('admin/admin-dashboard-notification.php');
	} elseif ( $action === 'report' ) {
		include ('admin/admin-dashboard-notif-form.php');
	} elseif ( $action === 'view-report' ) {
		include ( 'admin/admin-dashboard-single-report.php' );
	}
	
	?>
	<div class="col-md-12 white" <?php echo ($action == '') ? 'style="display:block"' : 'style="display:none"';?>>
		<div class="gap-top">
			<span class="welcome"><?php echo 'Welcome ' . $current_user->user_firstname; ?></span>
		</div>
		<div style="margin-top: 20px;">
			<h2>All Orders</h2>
		</div>

		<div class="table-1">
		<?php
$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
  'meta_key'    => '_customer_user',
  'post_type'   => wc_get_order_types( 'view-orders' ),
  'post_status' => array_keys( wc_get_order_statuses() )
) ) );

if ( $customer_orders ) : ?>

	<table class="orders"  width="100%">

		<thead>
			<tr>
				<th>Order</th>
				<th>Date</th>
				<th>Front Message</th>
				<th>Name</th>
				<th>Payment Method</th>
				<th>Total</th>
			</tr>
		</thead>

		<tbody><?php
      foreach ( $customer_orders as $customer_order ) {
        $order = wc_get_order( $customer_order );
        $order->populate( $customer_order );
        $item_count = $order->get_item_count();
        $order_id = $order->get_order_number();

        $orders = new WC_Order( $order_id );
        $items = $orders->get_items();

        ?><tr>		
        			<td data-title="<?php esc_attr_e( 'Order Number', 'woocommerce' ); ?>">
						<a class="orders" href="<?php echo esc_url( home_url('admin-dashboard/?action=view&ID=' . $customer_order->ID ) ); ?>">
							<span class="badge" id="<?php echo  $order->get_order_number(); ?>">1</span>
							<?php echo get_order_number_format( $order->get_order_number() ); ?> 
						</a>
					</td>
        			<td class="dates">
						<p class="date"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></p>
						<span><?php echo date( 'H:i:s', strtotime( $order->order_date ) ); ?></span>
					</td>
					<td class="order-fmsg">
						<?php 
							$sub_total = '';
							$tax = '';

							foreach ( $items as $item ) {
							$wristband_meta = maybe_unserialize( $item['wristband_meta']);
							$options = $wristband_meta['messages'];
							$sub_total = $item['line_subtotal'];
							$tax = $item['line_tax'];
						    
						    echo ($options['Front Message']);
						           
							}
						?>
					</td>
					
					<td>
						<?php
							echo get_post_meta( $customer_order->ID, '_billing_first_name', true ) . ' ' . get_post_meta( $customer_order->ID, '_billing_last_name', true );

						?>	
					</td>
					<td>
						<?php echo get_post_meta( $order_id, '_payment_method_title', true ); ?>
						<?php //echo wc_get_order_status_name( $order->get_status() ); ?>
					</td>
					<td>
						<table class="total">
							<tr><td>Sub Total:</td><td><?php echo $sub_total; ?></td></tr>
							<tr><td>Tax:</td><td><?php echo $tax; ?></td></tr>
							<tr class="grand-total"><td>Grand Total:</td><td><?php echo $order->get_formatted_order_total(); ?></td></tr>
						</table>
					</td>
				</tr><?php
      }
    ?></tbody>

	</table>

<?php endif; ?>
		</div>
	</div>
</div>
<?php include ('custom-footer.php'); ?>