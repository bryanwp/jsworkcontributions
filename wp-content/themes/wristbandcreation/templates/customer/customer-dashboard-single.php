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

// foreach ( $items as $item ) {
//     $wristband_meta = maybe_unserialize( $item['wristband_meta']);
//     $color = $wristband_meta['colors'];

//     echo "<pre>";
//     print_r( $wristband_meta );
//     echo "<br />";
// }
// die;


?>
<div class="col-md-12 white">
	<div class="gap-top">
		<span class="welcome"><?php echo 'Welcome ' . $current_user->user_firstname; ?></span>
	</div>
	<div style="margin-top: 20px;">
			<h2><?php echo get_order_number_format( $order_id ); ?></h2>
	</div>

	<div class="table-1 no-overflow">
		<?php


// echo "<pre>";
// print_r($customer_orders);
// die;

if ( $order ) : 
       
?>
	<div class="order-container">
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

	<div class="order-edit">
		<p class="approval">
			Your design is beign updated by the ADMIN and it needs your approval.
		</p>
	
	</div>


<?php endif; ?>
	</div>
	<?php 
		$question = get_post_meta( $order_id, '_report_content', true );

		if ( $question ) {
			include ('customer-dashboard-single-report.php'); 
		} else {
			include ('customer-dashboard-notif-form.php'); 
		}
		
	?>
</div>

