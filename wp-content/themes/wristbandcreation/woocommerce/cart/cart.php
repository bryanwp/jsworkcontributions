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
	<table class="shop_table cart" cellspacing="0" cellpadding="0">
	<thead>
	<tr>
		<!-- <th class="product-remove">&nbsp;</th>
		<th class="product-details"><?php //_e( 'Wristband Details', 'woocommerce' ); ?></th>
		<th class="product-summary"><?php //_e( 'Summary', 'woocommerce' ); ?></th> -->
		<th class="product-details"><?php _e( 'Item', 'woocommerce' ); ?></th>
		<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
		<th class="product-subtotal"><?php _e( 'Sub Total', 'woocommerce' ); ?></th>
		<th class="product-remove"><?php _e( 'Remove', 'woocommerce' ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php do_action( 'woocommerce_before_cart_contents' ); ?>

	<?php
	$carts = WC()->cart->get_cart();
	// echo "<pre>";
	// print_r($_SESSION['to_order_again']);
	// print_r($cart);
	// die;

	// if ( isset ( $_SESSION['to_order_again'] ) ) {
	//     $count = 1;
	//     foreach ( $carts as $cart_item_key => $cart_item ) {
	//       if ( $count == 1 ) {
	//         $carts[$cart_item_key]['wristband_meta'] = $_SESSION['to_order_again'];
	//         // echo $cart_item_key;
	//       }
	//     $count++;
	// 	}
 //    }

	foreach ( $carts as $cart_item_key => $cart_item ) {
		$meta = isset($cart_item['wristband_meta']) ? $cart_item['wristband_meta'] : array();
		$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			?>
			<tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
				
				<!-- <td class="product-remove"> -->

							<?php 
								// $CurrentLink = get_site_url(); 
								// $EditLink = $CurrentLink."/order-now/?id=".$cart_item_key."&Status=edit";
								// $CopyLink = $CurrentLink."/order-now/?id=".$cart_item_key."&Status=copy";
							?>
							<!-- <a class="EditCart" href="<?php// echo $EditLink; ?>"  data-product_id="%s" data-product_sku="%s">Edit</a> -->
							<!-- <a class="EditCart" href="<?php// echo $CopyLink; ?>"  data-product_id="%s" data-product_sku="%s">Copy</a> -->
							<?php
							// 	echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
							// 	'<a href="%s" class="remove RemoveCart" title="%s" data-product_id="%s" data-product_sku="%s">Remove</a>',
							// 	esc_url(WC()->cart->get_remove_url($cart_item_key)),
							// 	__('Remove this item', 'woocommerce'),
							// 	esc_attr($product_id),
							// 	esc_attr($_product->get_sku())
							// ), $cart_item_key);
							?>




				<!-- </td> -->

				<td class="product-details">
					<?php
					if (!$_product->is_visible()) {
						echo apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key) . '&nbsp;';
					} else {
						echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s" class="CssTitleBold CssTitleBlack">%s Wristbands </a>', esc_url($_product->get_permalink($cart_item)), $_product->get_title()), $cart_item, $cart_item_key);
						//echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s </a>', esc_url($_product->get_permalink($cart_item)), $_product->get_title()), $cart_item, $cart_item_key);
					}

					// Meta data
					WC()->cart->get_item_data($cart_item);

					// Backorder notification
					if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
						echo '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>';
					}
					?><br/>
					<?php
					 display_order_summary($_product, $meta); 
 
					$CurrentLink = get_site_url(); 
					$EditLink = $CurrentLink."/order-now/?id=".$cart_item_key."&Status=edit";
					$CopyLink = $CurrentLink."/order-now/?id=".$cart_item_key."&Status=copy";
					?>
					<a class="EditCart" href="<?php echo $EditLink; ?>"  data-product_id="%s" data-product_sku="%s">Edit Design&nbsp;<i class="fa fa-pencil-square-o"></i></a><span class="glyphicon glyphicon-edit">&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<a class="EditCart CopyCart" href="<?php echo $CopyLink; ?>"  data-product_id="%s" data-product_sku="%s">Copy Design&nbsp;<i class="fa fa-share-square-o"></i></a>
				
				</td>

				<!-- <td class="product-summary">
					<?php //display_order_summary($_product, $meta); ?>
				</td> -->

				<td class="product-quantity">
					<?php
					if (isset($meta['total_qty'])) {
						if ($meta['total_qty'] >= 100) {
							echo wbc_nf($meta['total_qty'], 0).' + 100';
						}else{
							echo wbc_nf($meta['total_qty'], 0);
						}


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
				<td class="product-remove">

					<?php
					echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
						'<a href="%s" class="remove RemoveCart" title="%s" data-product_id="%s" data-product_sku="%s"><i class="fa fa-trash fa-2x"></i></a>',
						esc_url(WC()->cart->get_remove_url($cart_item_key)),
						__('Remove this item', 'woocommerce'),
						esc_attr($product_id),
						esc_attr($_product->get_sku())
					), $cart_item_key);
					?>
				</td>
			</tr>
			<tr class="spacer">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
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

<!-- <div class="cart-collaterals">

	<?php // do_action( 'woocommerce_cart_collaterals' ); ?>

	<div class="cart-totals-buttons"> -->
		<?php // woocommerce_cart_totals(); ?>
		<!-- <input type="submit" class="fusion-button button-default button-medium button default medium" name="update_cart" value="<?php _e( 'Update Cart', 'woocommerce' ); ?>" /> -->
		<!-- <input type="submit" class="checkout-button fusion-button button-default button-medium button default medium alt wc-forward" name="proceed" value="<?php _e( 'Proceed to Checkout', 'woocommerce' ); ?> &rarr;" /> -->

		<?php // do_action( 'woocommerce_cart_actions' ); ?>
	<!-- </div>
</div>
 -->

<div class="row">
<div class="col-sm-8"><div style="margin:10px 0px">
<?php do_action( 'woocommerce_cart_collaterals' ); ?>
</div></div>
<div class="col-sm-4">
<!-- <table id="summary" class="table">
<tbody><tr>
<td>Order Subtotal</td>
<td>$<span id="subtotal">23.38</span></td>
</tr>
<tr>
<td>Production &amp; Shipping</td>
<td>$<span id="productionShipping">0.00</span></td>
</tr>
<tr>
<td>Order Total:</td>
<td>$<span id="total">23.38</span></td>
</tr>
</tbody></table> -->

<?php 
	woocommerce_cart_totals();
?>
<!-- <div class="text-center"><img src="http://imprint.com/templates/mobile/images/spinner-bar.gif" alt="Retrieving shipping rate...please wait" id="total_loading" class="loading"></div> -->
</div>
</div>
<div class="row">
<div class="col-sm-4" style="margin-bottom:10px">
<a href="/order-now/" class="custom-button-2" title="go back">GO BACK</a>
</div>
<div class="col-sm-4 col-sm-offset-4" style="margin-bottom:10px">
<!-- <a id="checkoutLink" class="btn btn-lg btn-block btn-danger" href="http://imprint.com/shop/ssl/go-through-checkout-process" title="Proceed to Checkout">PROCEED TO CHECKOUT</a> -->
<input type="submit" class="checkout-button fusion-button button-default button-medium button default medium alt wc-forward custom-button" name="proceed" value="<?php _e( 'Proceed to Checkout', 'woocommerce' ); ?>" />
</div>
</div>

<?php do_action( 'woocommerce_after_cart' );
// Omit closing PHP tag to avoid "Headers already sent" issues