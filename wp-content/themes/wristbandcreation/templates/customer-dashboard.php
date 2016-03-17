<?php
 //Template Name: Customer Dashboard
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
	<div class="col-md-2">
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
			<li>
				Notification
			</li>
		</ul>
	</div>
	<?php
	$action = '';
	if ( isset( $_GET['action'] ) ) {
		$action = $_GET['action'];
	}

	if ( $action === 'view') {
		include ('customer-dashboard-single.php');
	} elseif ( $action === 'profile' ) {
		include ('customer-dashboard-profile.php');
	}
	?>
	<div class="col-md-10" <?php echo ($action == '') ? 'style="display:block"' : 'style="display:none"';?>>
		<div class="gap-top"></div>
		<div>
			<h2>My Orders</h2>
		</div>
		<div class="dash-filter">
			<span>Filter:</span>
		</div>
		<div class="table-1">
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

if ( $customer_orders ) : ?>

	<table  width="100%">

		<thead>
			<tr>
				<th class="order-number"><span class="nobr"><?php _e( 'Order', 'woocommerce' ); ?></span></th>
				<th class="order-date"><span class="nobr"><?php _e( 'Date', 'woocommerce' ); ?></span></th>
				<th class="order-status"><span class="nobr"><?php _e( 'Status', 'woocommerce' ); ?></span></th>
				<th class="order-total"><span class="nobr"><?php _e( 'Total', 'woocommerce' ); ?></span></th>
				<th class="order-actions"> View </th>
			</tr>
		</thead>

		<tbody><?php
      foreach ( $customer_orders as $customer_order ) {
        $order = wc_get_order( $customer_order );
        $order->populate( $customer_order );
        $item_count = $order->get_item_count();

        ?><tr>
					<td data-title="<?php esc_attr_e( 'Order Number', 'woocommerce' ); ?>">
						<a href="<?php echo esc_url( home_url('customer-dashboard/?action=view&ID=' . $customer_order->ID ) ); ?>">
							<?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); ?>
						</a>
					</td>
					<td data-title="<?php esc_attr_e( 'Date', 'woocommerce' ); ?>">
						<time datetime="<?php echo date( 'Y-m-d', strtotime( $order->order_date ) ); ?>" title="<?php echo esc_attr( strtotime( $order->order_date ) ); ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></time>
					</td>
					<td data-title="<?php esc_attr_e( 'Status', 'woocommerce' ); ?>" style="text-align:left; white-space:nowrap;">
						<?php echo wc_get_order_status_name( $order->get_status() ); ?>
					</td>
					<td data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
						<?php echo sprintf( _n( '%s for %s item', '%s for %s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ); ?>
					</td>
					<td>
						<?php
              $actions = array();

              $actions['view'] = array(
                'url'  => home_url('customer-dashboard/?action=view&ID=' . $customer_order->ID ),
                'name' => __( 'View', 'woocommerce' )
              );

               if ( $order->needs_payment() ) {
                $actions['pay'] = array(
                  'url'  => $order->get_checkout_payment_url(),
                  'name' => __( 'Pay', 'woocommerce' )
                );
              }

              $actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order );

              if ( $actions ) {
                foreach ( $actions as $key => $action ) {
                  echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
                }
              }
            ?>
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