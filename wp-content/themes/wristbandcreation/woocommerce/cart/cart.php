<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version	 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>
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
								$CurrentLink = get_site_url(); 
								$EditLink = $CurrentLink."/order-now/?id=".$cart_item_key."&Status=edit";
							?>
							<a class="EditCart" href="<?php echo $EditLink; ?>"  data-product_id="%s" data-product_sku="%s">Edit</a>

							<?php
							echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove RemoveCart" title="%s" data-product_id="%s" data-product_sku="%s">Remove</a>',
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
					WC()->cart->get_item_data($cart_item);

					// Backorder notification
					if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
						echo '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>';
					}
					?>
				</td>

				<td class="product-summary">
					<?php display_order_summary($_product, $meta); ?>
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

<?php do_action( 'woocommerce_after_cart_table' ); ?>

<div class="cart-collaterals">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

	<div class="cart-totals-buttons">
		<?php woocommerce_cart_totals(); ?>
		<input type="submit" class="fusion-button button-default button-medium button default medium" name="update_cart" value="<?php _e( 'Update Cart', 'woocommerce' ); ?>" />
		<input type="submit" class="checkout-button fusion-button button-default button-medium button default medium alt wc-forward" name="proceed" value="<?php _e( 'Proceed to Checkout', 'woocommerce' ); ?> &rarr;" />

		<?php do_action( 'woocommerce_cart_actions' ); ?>
	</div>
</div>

<?php do_action( 'woocommerce_after_cart' );

// Omit closing PHP tag to avoid "Headers already sent" issues.
