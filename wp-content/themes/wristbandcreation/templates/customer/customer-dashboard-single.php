<?php
$order_id = '';
if ( isset( $_GET['ID'] ) ) {
			$order_id = $_GET['ID'];  
}

$key = get_post_meta( $order_id, '_order_key', true );
$pay_link = home_url('checkout/order-pay/' . $order_id . '?pay_for_order=true&key=' . $key);
//woocommerce_order_again_button( $order ); 
//$order = wc_get_order( $order_id );

$order = new WC_Order( $order_id );
$items = $order->get_items();

// $_SESSION['to_order_again'] = 
// echo "<pre>";
// print_r( $items['wristband_meta'] );
// die;
foreach ( $items as $item ) {
    $wristband_meta = maybe_unserialize( $item['wristband_meta']);
    // $color = $wristband_meta['colors'];
    $_SESSION['to_order_again'] = $wristband_meta;
    // echo "<pre>";
    // print_r( $wristband_meta );
    // echo "<br />";
}
// die;

// woocommerce_order_again_button( $order_id );
// wc_get_template( 'order/order-again.php', array( 'order' => $order ) );

?>

<div class="col-md-12 white">
	<div style="margin-top: 20px;">
		<?php the_title( '<h1>', '</h1>' ); ?>
			<h1><?php echo get_order_number_format( $order_id ); ?>  (<?php echo get_status( get_post_meta( $order_id, '_new_status', true ) ); ?>)</h1>
	</div>

	<div class="table-1 no-overflow">
		<?php

if ( $order ) : 
    echo do_shortcode('[the-cart-meta item_key="'.$order_id.'"]');
?>
	<!-- Start Reorder/Order and Edit -->

	<div class="reorder col-md-12">
			<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'order_again', $order_id ) , 'woocommerce-order_again' ) ); ?>" class="order-again btn-order"><?php _e( 'Order Again', 'woocommerce' ); ?></a>
			<!-- <a class="order-again btn-order">Order Again</a> -->
			<a class="order-edit btn-order order_edit_form">Order & Edit</a>
			<form method="post" id="order-edit" style="display: none;">
				<input type="hidden" name="form-action" value="order_edit">
				<input type="hidden" name="url" value="<?php echo esc_url( wp_nonce_url( add_query_arg( 'order_again', $order_id ) , 'woocommerce-order_again' ) ); ?>">
				<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
			</form>
	</div>

	<!-- Start Post Order Notes -->
	<?php 
		$note = get_post_meta( $order_id, 'post_order_note', true );
		if ( $note ) {
			do_action( 'post-order-notes', $order_id ); 
		}
	?>
	<!-- End Post Order Notes -->

	<?php 
	$approve = get_post_meta( $order_id, 'artwork_approve', true );
	if ( $approve == 'not_approved') {
		$out = '';
		
		$out .='<div class="order-edit col-md-12">';
			$out .='<p class="approval">';
				$out .='Your design is beign updated by the ADMIN and it needs your approval.';
				$out .='<a class="btn app-design">Approve</a>';
			$out .='</p>';
		$out .='</div>';
		$out .='<input type="hidden" id="postid" name="postid" value="'.$order_id.'" >';
		echo $out;
	}

		
	?>
	<div class="box col-md-12">	
		<?php
		$track = get_post_meta( $order_id, 'supplier_trackingnumber', true );
		if ( $track ) {
			echo '<p class="t-no">Tracking Number: '.$track;
			echo ' <a class="package_btn" href="https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=' . $track .'"  target="_blank"> Track your package </a>';
			echo '</p>';
		} else {
			echo '<p class="t-no">Tracking Number: Waiting for the supplier.</p>';
		}
		?>
		
		<!-- <span>Send e-mail confirmation for the customer</span> -->
		<?php
		$qty = get_post_meta($order_id, 'supplier_wpqty', TRUE); 
		if ( $qty ) {
			do_action('supplier_pricing', $order_id); 
		}
		?>
	</div>
	<?php 
	$artwork = get_post_meta( $order_id, 'Employee_artwork', true );

	if ( $artwork ) { ?>
		<div class="artwork col-md-12">
			
			<div class="file" style="display: inline;">
				
			<?php
				foreach ($artwork as $key => $value) { ?>
					<div class="img-holder">
						<img class="img-artwork" src="<?php echo $value['url']; ?>">
						<!-- <input type="hidden" class="attachment_id" name="img<?php echo $key; ?>" value="<?php echo $value; ?>"> -->
					</div>
			<?php } ?>
			</div> <!--container for the upload files-->	
		</div>
	<?php } ?>


<?php endif; ?>
	</div>
	<?php 
		$question = get_post_meta( $order_id, 'customer_report_content', true );

		if ( $question ) { ?>
			<input id="hasComment" type="hidden" name="hasComment" value="true">
			<div class="dash-title-holder">
				<h2>Question <span class="time-ago"><time class="timeago" datetime="<?php echo get_post_meta( $order_id, 'customer_report_time_added', true ); ?>" >asd</time></span></h2>
			</div>
			<hr class="divider-full" />
			<div class="dash-filter">
				<!-- <span>Filter:</span> -->
			</div>
			
			<div class="report-box">

				<p class="report-content">
					<?php echo get_post_meta( $order_id, 'customer_report_content', true ); ?>
				</p>
			</div>
			<div id="creply" class="reply-container">
				<?php include ('customer-dashboard-single-report.php'); ?>
			</div>
		<?php
		} else {
			?> <input id="hasComment" type="hidden" name="hasComment" value="false"> <?php
			$user = "customer";
			include ('customer-dashboard-notif-form.php'); 
		}
		
	?>
</div>