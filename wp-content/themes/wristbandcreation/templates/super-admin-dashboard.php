<?php
 //Template Name: Super Admin Dashboard
// check_if_login();

// foreach ( $results as $result => $post_id ) {
// 	$order = new WC_Order($post_id);
// 	$status = wc_get_order_statuses( $post_id );
	
// }
// echo '<pre>';
// print_r( $results );
// die;
global $post;
$post_slug = $post->post_name;
include ('custom-header.php'); ?>

<div class="row">
		<div class="gap-top">
			<span class="welcome"><?php echo 'Welcome ' . $current_user->user_firstname; ?></span>
		</div>
	<?php
	$action = '';
	if ( isset( $_GET['action'] ) ) {
		$action = $_GET['action'];
	}

	if ( $action === 'view') {
		include ('super-admin/super-admin-dashboard-single.php');
	} elseif ( $action === 'profile' ) {
		include ('super-admin/super-admin-dashboard-profile.php');
	} elseif ( $action === 'notification' ) {
		include ('super-admin/super-admin-dashboard-notification.php');
	} elseif ( $action === 'report' ) {
		include ('super-admin/super-admin-dashboard-notif-form.php');
	} elseif ( $action === 'view-report' ) {
		include ( 'super-admin/super-admin-dashboard-single-report.php' );
	} elseif ( $action === 'order-edit' ) {
		include ( 'super-admin/super-admin-dashboard-single-edit.php' );
	} elseif ( $action === 'wristband_meta' ) {
		include ( 'admin/wristband_meta.php' );
	} elseif ( $action === 'create' ) {
		include ( 'super-admin/super-admin-dashboard-register.php' );
	} elseif ( $action === 'log' ) {
		include ( 'super-admin/super-admin-dashboard-log.php' );
	} elseif ( $action === 'search' ) {
		include ( 'super-admin/super-admin-dashboard-search.php' );
	} elseif ( $action === 'Orderlogs' ) {
		include ( 'super-admin/super-admin-dashboard-reporting.php' );
	}
	?>
	<div class="col-md-12 white" <?php echo ($action == '') ? 'style="display:block"' : 'style="display:none"';?>>
		<div style="margin-top: 20px;">
			<?php the_title( '<h1>', '</h1>' ); ?>
			<h2>All Orders</h2>
		</div>
		<div class="search-con">
			<form id="search" method="get">
				<input type="hidden" name="action" value="search">
				<select name="f" id="filter-search">
					<option value="post_id">Order Number</option>
					<option value="date">Date</option>
					<option value="name">Customer Name</option>
					<option value="method">Payment Method</option>
					<option value="msg">Front Message</option>
					<option value="status">Status</option>
				</select>
				<div class="keyword-con">
					<input id="keyword" type="text" name="k" placeholder="Search">
				</div>
				<input type="submit">
			</form>
		</div>

		<div class="table-1">
		<?php
$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
	'meta_key'    => '_customer_user',
	'numberposts' => 9999999,
    'post_type'   => wc_get_order_types( 'view-orders' ),
    // 'post_type'   => 'shop_order',
    'post_status' => 'wc-completed'
    // 'post_status' => array_keys( wc_get_order_statuses() )
) ) );

$page = get_query_var( 'page', 1 );
if ( $page == 0 ) {
	$page = 1;
}
$total_order = count( $customer_orders );
$paginate_by = 5;
$total_page  = $total_order / $paginate_by;
$total_page  = ceil( $total_page );
$post_start  = ( $page * $paginate_by ) - $paginate_by;
$post_end    = $page * $paginate_by;
// echo "<pre>";
// var_dump($customer_orders);
// die();
if ( $customer_orders ) : ?>

	<table class="orders"  width="100%">

		<thead>
			<tr>
				<th>Order</th>
				<th>Date</th>
				<!-- <th>Quantity</th> -->
				<th>Front Message</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Payment Method</th>
				<th>Sub Total</th>
				<th>Tax</th>
				<th>Grand Total</th>
			</tr>
		</thead>

		<tbody><?php
		$post_counter = 1;
      foreach ( $customer_orders as $customer_order ) {
      	if ( $post_start < $post_counter && $post_end >= $post_counter  ) {
        $order = wc_get_order( $customer_order );
        $order->populate( $customer_order );
        $item_count = $order->get_item_count();
        $order_id = $order->get_order_number();

        $orders = new WC_Order( $order_id ); 
        $items = $orders->get_items();

        ?><tr data-href="<?php echo esc_url( home_url('super-admin-dashboard/?action=view&ID=' . $customer_order->ID ) ); ?>">		
        			<td data-title="<?php esc_attr_e( 'Order Number', 'woocommerce' ); ?>">
						<a class="orders" href="<?php echo esc_url( home_url('super-admin-dashboard/?action=view&ID=' . $customer_order->ID ) ); ?>">
							<?php echo check_notif_onload( $order_id ); ?>
							<?php echo get_order_number_format( $order->get_order_number() ); ?> 
						</a>
						<p class="status">
							<?php 
								$status = get_post_meta( $order_id, '_new_status', true );
								echo get_status( $status );
								
							?>
						</p>
					</td>
        			<td class="dates">
						<?php $cdate = get_post_meta( $customer_order->ID, '_completed_date', true ) ?>
						<p class="date"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $cdate ) ); ?></p>
						<span><?php echo date( 'H:i:s', strtotime( $cdate ) ); ?></span>
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
							echo get_post_meta( $customer_order->ID, '_billing_first_name', true );
						?>	
					</td>
					<td>
						<?php
							echo get_post_meta( $customer_order->ID, '_billing_last_name', true );
						?>	
					</td>
					<td>
						<?php echo get_post_meta( $order_id, '_payment_method_title', true ); ?>
						<?php //echo wc_get_order_status_name( $order->get_status() ); ?>
					</td>
					<td>
					
						<?php // echo "$".$sub_total; ?>
						<?php echo "$".number_format((float)$sub_total, 2, '.', ','); ?>
					</td>
					<td>
						<?php// echo $tax; ?>
						<?php echo "$".number_format((float)$tax, 2, '.', ','); ?>
					</td>
					<td>
						<?php echo $order->get_formatted_order_total(); ?>
					</td>
				</tr><?php
      }//if else pagination
		 $post_counter++;
     } // foreach
    ?></tbody>

	</table>
<?php 
endif; ?>
		<div class="pagination">
				<ul>
				<?php 
				for ($i=1; $i <= $total_page; $i++) {?>

					<li><a href="<?php echo home_url( $post_slug . '/?page='.$i ); ?>"><?php echo $i; ?></a></li>
				<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php include ('custom-footer.php'); ?>