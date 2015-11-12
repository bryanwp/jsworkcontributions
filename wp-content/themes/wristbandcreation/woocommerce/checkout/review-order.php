<?php
	/**
	 * Review order table
	 *
	 * @author 		WooThemes
	 * @package 	WooCommerce/Templates
	 * @version     2.3.0
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}
?>
<table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
	<tr>
		<th class="product-details"><?php _e( 'Wristband Details', 'woocommerce' ); ?></th>
		<th class="product-summary">Product Summary</th>
		<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$meta = isset($cart_item['wristband_meta']) ? $cart_item['wristband_meta'] : array();
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<td class="product-details">

						<?php // Avada edit ?>
						<span class="product-thumbnail">
									<?php
										$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

										if ( ! $_product->is_visible() )
											echo $thumbnail;
										else
											printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );
									?>
								</span>
						<div class="product-info">
							<?php // Avada edit ?>
							<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ); ?>
							<?php //echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
							<?php echo WC()->cart->get_item_data( $cart_item ); ?>

						</div>
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
							<?php if (isset($meta['font']) && $meta['font'] == '-1'): ?>
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
					<td class="product-total">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
					</td>
				</tr>
			<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
	?>
	</tbody>
	<tfoot>

	<tr class="cart-subtotal">
		<th><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
		<td><?php wc_cart_totals_subtotal_html(); ?></td>
	</tr>

	<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
			<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
			<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
		</tr>
	<?php endforeach; ?>

	<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

		<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

		<?php wc_cart_totals_shipping_html(); ?>

		<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

	<?php endif; ?>

	<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
		<tr class="fee">
			<th><?php echo esc_html( $fee->name ); ?></th>
			<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
		</tr>
	<?php endforeach; ?>

	<?php if ( WC()->cart->tax_display_cart === 'excl' ) : ?>
		<?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
			<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
				<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
					<th><?php echo esc_html( $tax->label ); ?></th>
					<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php else : ?>
			<tr class="tax-total">
				<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
				<td><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></td>
			</tr>
		<?php endif; ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

	<tr class="order-total">
		<th><?php _e( 'Total', 'woocommerce' ); ?></th>
		<td><?php wc_cart_totals_order_total_html(); ?></td>
	</tr>

	<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>
