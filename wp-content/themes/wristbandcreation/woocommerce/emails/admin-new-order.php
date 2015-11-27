<?php
/**
 * Admin new order email
 *
 * @author WooThemes
 * @package WooCommerce/Templates/Emails/HTML
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


global $woocommerce;


?>

<?php do_action( 'woocommerce_email_header', $email_heading ); ?>

<p><?php printf( __( 'You have received an order from %s. The order is as follows:', 'woocommerce' ), $order->get_formatted_billing_full_name() ); ?></p>

<?php do_action( 'woocommerce_email_before_order_table', $order, true, false ); ?>

<h2><a class="link" href="<?php echo admin_url( 'post.php?post=' . $order->id . '&action=edit' ); ?>"><?php printf( __( 'Order #%s', 'woocommerce'), $order->get_order_number() ); ?></a> (<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', strtotime( $order->order_date ) ), date_i18n( wc_date_format(), strtotime( $order->order_date ) ) ); ?>)</h2>

<!--
<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
	<thead>
		<tr>
			<th class="td" scope="col" style="text-align:left;"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="td" scope="col" style="text-align:left;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="td" scope="col" style="text-align:left;"><?php _e( 'Price', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $order->email_order_items_table( false, true ); ?>
	</tbody>
	<tfoot>
		<?php
			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;
				foreach ( $totals as $total ) {
					$i++;
					?><tr>
						<th class="td" scope="col" colspan="2" style="font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; text-align:left; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['label']; ?></th>
						<td class="td" scope="col" style="text-align:left; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['value']; ?></td>
					</tr><?php
				}
			}
		?>
	</tfoot>
</table>
-->

	<table class="shop_table cart" cellspacing="0">
	<thead>
	<tr>
		<th class="product-remove">&nbsp;</th>
		<th class="product-details"><?php _e( 'Wristband Details', 'woocommerce' ); ?></th>
		<th class="product-summary"><?php _e( 'Summary', 'woocommerce' ); ?></th>
		<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
		<th class="product-subtotal"><?php _e( 'Sub Total', 'woocommerce' ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php do_action( 'woocommerce_before_cart_contents' ); ?>

	<?php
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$meta = isset($cart_item['wristband_meta']) ? $cart_item['wristband_meta'] : array();
		$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			?>
			<tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

				<td class="product-remove">
					<?php
					echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
						'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
						esc_url(WC()->cart->get_remove_url($cart_item_key)),
						__('Remove this item', 'woocommerce'),
						esc_attr($product_id),
						esc_attr($_product->get_sku())
					), $cart_item_key);
					?>
				</td>

				<td class="product-details">
					<?php
					if (!$_product->is_visible()) {
						echo apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key) . '&nbsp;';
					} else {
						echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s </a>', esc_url($_product->get_permalink($cart_item)), $_product->get_title()), $cart_item, $cart_item_key);
					}

					// Meta data
					echo WC()->cart->get_item_data($cart_item);

					// Backorder notification
					if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
						echo '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>';
					}
					?>
				</td>

				<td class="product-summary">
					<label
						class="t-heading"><?php echo $_product->get_title() . ' - ' . (isset($meta['size']) ? $meta['size'] : '') . ' Inch.'; ?></label>
					<label>Quantity & Colors</label>
					<?php if (isset($meta['colors'])): ?>
						<ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
							<?php foreach ($meta['colors'] as $color): if (!isset($color['name']) || empty($color['name'])) continue; ?>

								<li class="fusion-li-item">
										<span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
											<i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
										</span>

									<div class="fusion-li-item-content">
										<span><?php echo $color['name']; ?></span> – <?php echo $color['type']; ?>: <em>(<?php echo $color['color']; ?>
											)</em>
									</div>

									<?php if (isset($color['sizes']) && count($color['sizes']) != 0): ?>
										<ul class="fusion-checklist fusion-checklist-1"
											style="font-size:12px;line-height:22.1px;">
											<?php if (isset($color['text_color_name'])): ?>
												<li class="fusion-li-item">
													<div class="fusion-li-item-content">
														<span>Text Color: <?php echo $color['text_color_name'] . ' <em>(' . $color['text_color'] . ')</em>'; ?></span>
													</div>
												</li>
											<?php endif; ?>
											<?php foreach ($color['sizes'] as $k => $qty): if ($qty <= 0) continue; ?>
												<li class="fusion-li-item">
													<div class="fusion-li-item-content">
														<span><?php echo ucfirst($k) . ' <em>(' . $qty . ')</em>'; ?></span>
													</div>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<label>Text on Wristbands</label>
					<ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
						<?php if (!isset($meta['font']) || $meta['font'] != '-1'): ?>
							<li class="fusion-li-item">
								<span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
									<i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
								</span>
								<div class="fusion-li-item-content">
									<span>Font Style</span> – <?php echo $meta['font']; ?>
								</div>
							</li>
						<?php endif; ?>
						<?php if (isset($meta['messages'])): foreach ($meta['messages'] as $label => $val): if (empty($val)) continue; ?>
							<li class="fusion-li-item">
								<span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
									<i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
								</span>

								<div class="fusion-li-item-content">
									<span><?php echo $label; ?></span> – <?php echo $val; ?>
								</div>
							</li>
						<?php endforeach; endif; ?>
					</ul>

					<?php if (isset($meta['additional_options']) && count($meta['additional_options']) > 0): ?>
						<label>Additional Options</label>
						<ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
							<?php foreach ($meta['additional_options'] as $k => $option): ?>
								<li class="fusion-li-item">
									<span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
										<i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
									</span>

									<div class="fusion-li-item-content">
										<span><?php echo $option; ?></span>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php if (isset($meta['clipart'])): ?>
						<label>Clipart</label>
						<ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
							<?php foreach ($meta['clipart'] as $k => $clipart): if (empty($clipart)) continue;?>
								<li class="fusion-li-item">
									<span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
										<i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
									</span>

									<div class="fusion-li-item-content">
										<span><?php echo ucfirst(str_replace('_', ' ', $k)); ?></span> -
										<?php if (preg_match('/(\.jpg|\.png|\.bmp)$/', $clipart)): ?>
											<img
												src="<?php echo wp_upload_dir()['baseurl'] . '/clipart/' . $clipart; ?>"
												alt="" width="16px" height="16px">
										<?php else: ?>
											<i class="fa <?php echo $clipart; ?>"></i>
										<?php endif; ?>
										(<em><?php echo $clipart; ?></em>)
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<label>Production and Shipping</label>
					<ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
						<?php if (isset($meta['customization_location'])): ?>
							<li class="fusion-li-item">
								<span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
										<i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
									</span>

								<div class="fusion-li-item-content">
									<span><?php echo $meta['customization_location']; ?></span>
								</div>
							</li>
						<?php endif; ?>
						<?php if (isset($meta['customization_date_production'])): ?>
							<li class="fusion-li-item">
								<span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
										<i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
									</span>

								<div class="fusion-li-item-content">
									<span>Production Time</span> - <?php echo $meta['customization_date_production']; ?>
								</div>
							</li>
						<?php endif; ?>
						<?php if (isset($meta['customization_date_shipping'])): ?>
							<li class="fusion-li-item">
								<span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
										<i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
									</span>

								<div class="fusion-li-item-content">
									<span>Shipping Time</span> - <?php echo $meta['customization_date_shipping']; ?>
								</div>
							</li>
						<?php endif; ?>
						<?php if (isset($meta['guaranteed_delivery'])): ?>
							<li class="fusion-li-item">
								<span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
										<i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
									</span>

								<div class="fusion-li-item-content">
									<span>Guaranteed delivery</span> - <?php echo $meta['guaranteed_delivery']; ?>
								</div>
							</li>
						<?php endif; ?>
					</ul>
				</td>

				<td class="product-quantity">
					<?php
					if (isset($meta['total_qty'])) {
						echo wbc_nf($meta['total_qty'], 0);
					} else {
						if ($_product->is_sold_individually()) {
							$product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
						} else {
							$product_quantity = woocommerce_quantity_input(array(
								'input_name' => "cart[{$cart_item_key}][qty]",
								'input_value' => $cart_item['quantity'],
								'max_value' => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
								'min_value' => '0'
							), $_product, false);
						}

						echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
					}
					?>
				</td>

				<td class="product-subtotal">
					<?php
					echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					?>
				</td>
			</tr>
			<?php
		}
	}

	do_action( 'woocommerce_cart_contents' );
	?>
		<?php // Avada edit ?>
		<?php wp_nonce_field( 'woocommerce-cart' ); ?>
		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>




<?php do_action( 'woocommerce_email_after_order_table', $order, true, false ); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, true, false ); ?>

<?php do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text ); ?>

<?php do_action( 'woocommerce_email_footer' ); ?>
