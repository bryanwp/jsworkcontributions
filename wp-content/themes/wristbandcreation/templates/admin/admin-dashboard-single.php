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
<div class="col-md-10 white">
	<div class="gap-top"></div>
	<div class="dash-title-holder">
		<h2>Order #<?php echo $order_id; ?></h2>
		<ul>
			<?php 
				$checkReport = get_post_meta( $order_id, '_report_title', true );
				if ( $checkReport ) { ?>
				<a href="<?php echo home_url('admin-dashboard/?action=view-report&post-id='. $order_id  ); ?>"><li>View Report</li></a>
			<?php } else { ?>
				<a href="<?php echo home_url('admin-dashboard/?action=report&ID='. $order_id  ); ?>"><li>Send Report</li></a>
			<?php } ?>
		</ul>
	</div>
	<hr class="divider-full" />
	<div class="dash-filter">
		<p class="approval">Your design is beign updated by the ADMIN and it needs your approval. Click <a href="#">HERE</a> to see the revision.</p>
		<!-- <span>Filter:</span> -->
	</div>
	<div style="height: 10px"></div>
	<?php foreach ( $items as $item ) {
	    $wristband_meta = maybe_unserialize( $item['wristband_meta']);
	    $color = $wristband_meta['colors'];
	 ?>
	   	<div class="item-holder row">
			<div class="col-md-3">
				<div class="item-picture">
					<?php
					$image = str_replace( 'emboss', 'embossed', strtolower( $item['name'] ) );

					?>
					<img src="<?php echo home_url('wp-content/uploads/main-' . $image . '.png'); ?>" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
				</div>
			</div>
			<div class="col-md-9 item-info">
				<ul class="item-info-row">
					<li class="item-info-col">
						<strong><?php echo $item['name']; ?> Wristband</strong>
						<ul>
							<li>Width <?php echo $wristband_meta['size']; ?></li>
							<?php
								$color = $wristband_meta['colors'];
								foreach ($color as $colors) {
									$count = 1;
									$sizes = $colors['sizes'];
									foreach ( $sizes as $size ) {
										if ( $size >= 1 && $count === 1 ) {
											echo '<li>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' Adult Size</li>'; 
										} elseif ( $size >= 1 && $count === 2  ) {
											echo '<li>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' Medium Size</li>'; 
										} elseif ( $size >= 1 && $count === 3  ) {
											echo '<li>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' Youth Size</li>'; 
										} 
										$count++;
									}
								}
							?>
						</ul>
					</li>
					<li class="item-info-col">
						<strong>Wristband Text and Design</strong>
						<ul>
							<?php
								$options = $wristband_meta['messages'];
								foreach ( $options as $key => $msg ) {
									echo '<li>' . $key . ':<br /> ' . $msg . '</li>'; 
								}
							?>
						</ul>
					</li>
					<li class="item-info-col">
						<strong>Additional Options</strong>
						<ul>
							<?php
								$options = $wristband_meta['additional_options'];
								if ( $options ) {
									foreach ( $options as $option ) {
									echo '<li>' . $option . ' Adult Size</li>'; 
									}
								} else {
									echo '<li>No addtional options</li>'; 
								}
							?>
						</ul>
					</li>
				</ul>
			</div>
		</div>

	<?php } ?>
</div>

