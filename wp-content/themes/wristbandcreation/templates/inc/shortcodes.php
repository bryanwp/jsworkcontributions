<?php
/*
* Custom function Shortcodes
* by: Sheldz
*/

add_shortcode('the-cart-meta', 'cart_meta');
function cart_meta( $atts ){
	$atts = shortcode_atts( array(
		'item_key' => '', 
		), $atts );
	extract( $atts );
?>
	<table class="shop_table cart" cellspacing="0" cellpadding="0">
		<thead>
		<tr >
			<th class="white CssTitleBold"><?php _e( 'Item', 'woocommerce' ); ?></th>
			<th class="white CssTitleBold"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="white CssTitleBold"><?php _e( 'Sub Total', 'woocommerce' ); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php

		$order = new WC_Order( $item_key );
		$cart_items = $order->get_items();

		foreach ( $cart_items as $cart_item ) {
			$wristband_meta = maybe_unserialize( $cart_item['wristband_meta']);
		    $color = $wristband_meta['colors'];

		 //    echo "<pre>";
			// print_r( $wristband_meta );
			// die;

			if ( $cart_item ) {
				?>
				<tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
					
					<td class="product-details">
						<?php
						$total_qty = 0;
						echo '<a class="CssTitleBold CssTitleBlack">'. $cart_item['name'] .' Wristbands </a><br />';
						echo '<label class="t-heading">Wristband Width: '.$wristband_meta['size'].' Inch</label><br />';
						
						// Meta data
						echo '<br /><label class="CssTitleBlack CssTitleBold">Quantity and Colors:</label>';
						$color = $wristband_meta['colors'];
						foreach ($color as $colors) {
							$count = 1;
							$sizes = $colors['sizes'];
							foreach ( $sizes as $size ) {
								if ( $size >= 1 && $count === 1 ) {
									echo '<div class="fusion-li-item-content"><span>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' | Adult Size</span></div>'; 
								} elseif ( $size >= 1 && $count === 2  ) {
									echo '<div class="fusion-li-item-content"><span>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' | Medium Size</span></div>'; 
								} elseif ( $size >= 1 && $count === 3  ) {
									echo '<div class="fusion-li-item-content"><span>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' | Youth Size</span></div>'; 
								} 
								$total_qty = $total_qty + $size;
								$count++;
							}
						}                  
						$options = $wristband_meta['messages'];
						echo '<br /><label class="CssTitleBlack CssTitleBold">Text on Wristbands:</label><br />';
						foreach ( $options as $key => $msg ) {
							if ( ! empty( $msg ) ) {
								echo '<span>' . $key . ': ' . $msg . '</span><br />'; 
							}
							
						}

						$clipart = $wristband_meta['clipart'];
						echo '<br /><label class="CssTitleBlack CssTitleBold">Clipart:</label><br />';
						foreach ($clipart as $clipart_key => $clipart_value) {
							
							if ( ! empty( $clipart_value ) ) {
								echo '<span>' . str_replace( '_', ' ', ucwords( $clipart_key ) ) . ': <i class="fa ' . $clipart_value . '"></i>'. str_replace( 'aykun-', '', $clipart_value) .' </span><br />'; 
							}
						}

						$options = $wristband_meta['additional_options'];
						echo '<br /><label class="CssTitleBlack CssTitleBold">Additional Options:</label><br />';
						if ( $options ) {
							foreach ( $options as $option ) {
								echo '<span>' . $option . '</span><br />'; 
							}
						} 

						echo '<br /><label class="CssTitleBlack CssTitleBold">Production and Shipping:</label><br />';
						echo '<span>' . $wristband_meta['customization_location'] . '</span><br />'; 
						echo '<span>' . $wristband_meta['customization_date_production'] . '</span><br />'; 
						echo '<span>' . $wristband_meta['customization_date_shipping'] . '</span><br />'; 

						?><br/>
					</td>

					<td class="product-quantity">
						<?php echo $total_qty; ?>
					</td>

					<td class="product-subtotal">
						<?php
						echo round($wristband_meta['total_price'], 2);
						?>
					</td>
				</tr>
				<?php
			}
		}
		?>
		
		</tbody>
		<tfoot>
			<tr>
				<td class="CssTitleBlack CssTitleBold" colspan="2">Grand Total</td>
				<td class="CssTitleBlack CssTitleBold" style="text-align: center;"><?php echo $order->get_formatted_order_total(); ?></td>
			</tr>
		</tfoot>
	</table>
<?php 
}