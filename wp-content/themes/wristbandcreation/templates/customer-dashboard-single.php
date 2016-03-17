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
<div class="col-md-10">
	<div class="gap-top"></div>
	<div class="dash-title-holder">
		<h2>Order #<?php echo $order_id; ?></h2>
		<ul>
			<a href="<?php echo $pay_link; ?>"><li>Pay</li></a>
			<li>Order Again</li>
			<li>Reorder And Edit</li>
		</ul>
	</div>
	<div class="dash-filter">
		<p class="approval">Your Design is beign updated by the ADMIN and it needs your approval. Click <a href="#">HERE</a> to see the revision.</p>
		<!-- <span>Filter:</span> -->
	</div>
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
								foreach ( $options as $option ) {
									echo '<li>' . $option . ' Adult Size</li>'; 
								}
							?>
						</ul>
					</li>
				</ul>
			</div>
		</div>

	<?php } ?>


	<div class="table-1">
		<?php
		
?>
		<table width="100%">
			<thead>
				<tr>
					<th><?php _e( 'Product', 'woocommerce' ); ?></th>
					<th><?php _e( 'Total', 'woocommerce' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
		      foreach( $order->get_items() as $item_id => $item ) {
		        wc_get_template( 'order/order-details-item.php', array(
		          'order'   => $order,
		          'item_id' => $item_id,
		          'item'    => $item,
		          'product' => apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item )
		        ) );
		      }
		    ?>
				<?php do_action( 'woocommerce_order_items_table', $order ); ?>
			</tbody>
			<tfoot>
				<?php
		      foreach ( $order->get_order_item_totals() as $key => $total ) {
		        ?>
						<tr>
							<th scope="row"><?php echo $total['label']; ?></th>
							<td><?php echo $total['value']; ?></td>
						</tr>
						<?php
		      }
		    ?>
			</tfoot>
		</table>

		<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

		<?php wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>
	</div>
</div>

