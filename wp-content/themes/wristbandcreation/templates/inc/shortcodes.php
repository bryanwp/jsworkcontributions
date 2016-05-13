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
			<th class="CssTitleBold item"><?php _e( 'Item', 'woocommerce' ); ?></th>
			<th class="CssTitleBold qty"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="CssTitleBold sub"><?php _e( 'Sub Total', 'woocommerce' ); ?></th>
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
								$icon = '';
								if (preg_match('/(\.jpg|\.png|\.bmp)$/', $clipart_value)){ 
					              $icon = '<img src="'.wp_upload_dir()['baseurl'] . '/clipart/' . $clipart_value.'" alt="" width="16px" height="16px">';
					            } else {
					              $icon = '<i class="fa ' . $clipart_value . '"></i>';
					            }

								echo '<span>' . str_replace( '_', ' ', ucwords( $clipart_key ) ) . ':'. $icon .' '. str_replace( 'aykun-', '', $clipart_value) .' </span><br />'; 
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
						echo '<span id="prod">' . $wristband_meta['customization_date_production'] . '</span><br />'; 
						echo '<span id="ship">' . $wristband_meta['customization_date_shipping'] . '</span><br />'; 

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
			<tr class="grandtotal">
				<td class="CssTitleBlack CssTitleBold" colspan="2">Grand Total</td>
				<td class="CssTitleBlack CssTitleBold" style="text-align: center;"><?php echo $order->get_formatted_order_total(); ?></td>
			</tr>
		</tfoot>
	</table>
<?php 
}

add_action( 'supplier_pricing','supplier_pricing_for_supper_admin' );
function supplier_pricing_for_supper_admin( $order_id ){ ?>
		<div id='appendedid'>
            <div></div>
    		<table style="width:100%;">
				<thead>
					<th>Proceess Name</th>
					<th>Quantity</th>
					<th>Unit Price</th>
					<th>Total</th>
				</thead>
		    <?php
		    $qty = get_post_meta($order_id, 'supplier_wpqty', TRUE);
		    $price = get_post_meta($order_id, 'supplier_wpprice', TRUE);
		    $total = get_post_meta($order_id, 'supplier_wptotal', TRUE);
		    $grand_total = 0;
		    $j = 0;
                foreach ( $total as $key => $value) {

                  $k = change_to_int($key);
                  for ($i=0; $i <sizeof($value) ; $i++) { 
                    ?>
						<tr>
							<td><?php echo change_label_name($key); ?></td>
							<td><?php echo $qty[change_qty_name($key)][$i]; ?></td>
							<td><?php echo $price[change_price_name($key)][$i]; ?></td>
							<td><?php echo $value[$i]; ?></td>
						</tr>
			
                    <?php
                    $grand_total = $grand_total + $value[$i];
                    $j++;
                  }
                }

    ?>
    	<tr>
    		<td colspan="3"><strong>Grand Total</strong></td>
    		<td colspan="3"><strong>$<?php echo $grand_total; ?></strong></td>
    	</tr>
    </table>
    </div>
    <?php 
}

add_action('post-order-notes', 'post_order_notes');
function post_order_notes( $order_id ){
	$notes = get_post_meta( $order_id, 'post_order_note', true );
		?>	
		<div class="artwork-title">
		<h3>Post Order Notes</h3>
		</div>
		<div class="post-order-notes col-md-12">
		<?php
		if ( $notes ) { 
			foreach( $notes as $note ) {?>
				<div class="notes">
					<span class="note-date"><?php echo $note['date']; ?></span>
					<p class="note-content"><?php echo nl2br( $note['content'] ); ?></p>
					<input type="hidden" id="n-title" name="n-title" value="<?php echo $note['title']; ?>">
					<input type="hidden" id="n-date" name="n-date" value="<?php echo $note['date']; ?>">
					<input type="hidden" id="n-content" name="n-content" value="<?php echo nl2br( $note['content'] ); ?>">
				</div>
		<?php } 
		} ?>
		</div>
		<?php
}

/*	
*	variable required for the email template
*	$args = array(
*		'full_name' => '',
*		'order_name' => '',
*		'order_id' => '',
*		'arrival' => '',
*		'sub_total' => '',
*		'tax' => '',
*		'total' => ''
*		);
*/
function email_content_after_order( $args ){

	extract( $args );
	
	$content = '';
	//populating content
	$content.='<!DOCTYPE html>';
	$content.='<html lang="en">';
		$content.='<head>';
			$content.='<meta charset="UTF-8">';
			$content.='<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet" type="text/css">';
			// $content.='<style type="text/css">';
			// 	$content.='.title{ text-align: right;font-size: 18px;font-family: sans-serif;color: #585858; }';
			// $content.='</style>';
		$content.='</head>';
		$content.='<body style="font-family: sans-serif; font-weight: lighter;">';
			$content.='<div style="width: 650px; margin: 0px auto;">';
				$content.='<table width="100%" style="border-bottom: 2px solid #ECE9E9;">';
					$content.='<tr>';
						$content.='<td><img style="width: 250px;" src="https://gwplabs.com/wp-content/uploads/wclogo.png" alt="logo"></td>';
						$content.='<td><p style="text-align:right;font-size: 18px;font-family: sans-serif;color: #585858;">Order Confirmation</p></td>';
					$content.='</tr>';
				$content.='</table>';
				$content.='<p style="color: #1D429A;font-size: 18px;">Hello ' . $full_name . ',</p>';
				$content.='<p>';
					$content.='Thank you for shopping with us. You Ordered <span style="color: #3EBEEF;">"'. $order_name . ' Wristband".</span><br />';
					$content.='We\'ll send a confirmation when your item ships.';
				$content.='</p>';
				$content.='<p style="color: #1D429A;font-size: 18px; padding-bottom: 7px; border-bottom: 2px solid #ECE9E9; margin-bottom: -7px;">Details</p>';
				$content.='<p style="color: #9C9C9C;">Order <span style="color: #3EBEEF;">#' . get_order_number_format( $order_id ) . '</span></p>';

				$content.='<table border="1" bordercolor="grey" width="100%" cellspacing="0" cellpadding="0" style"border: #ccc solid 1px;">';
					$content.='<thead>';
					$content.='<tr style="background: #DCDCDC;">';
						$content.='<th style="padding: 5px;font-weight: bold;">Item</th>';
						$content.='<th style="padding: 5px;font-weight: bold;text-align: center;">Quantity</th>';
						$content.='<th style="padding: 5px;font-weight: bold;text-align: center;">Sub Total</th>';
					$content.='</tr>';
					$content.='</thead>';
					$content.='<tbody>';
					 	//do_action( 'woocommerce_before_cart_contents' );
					$order = new WC_Order( $order_id );
					$cart_items = $order->get_items();

					foreach ( $cart_items as $cart_item ) {
						$wristband_meta = maybe_unserialize( $cart_item['wristband_meta']);
					    $color = $wristband_meta['colors'];

						if ( $cart_item ) {
							
							$content.='<tr>';
								$content.='<td style="padding: 5px;">';
									$total_qty = 0;
									$content.= '<b>'. $cart_item['name'] .' Wristbands </b><br />';
									$content.= '<label>Wristband Width: '.$wristband_meta['size'].' Inch</label><br />';
									$content.= '<br /><b>Quantity and Colors:</b>';

									$color = $wristband_meta['colors'];
									foreach ($color as $colors) {
										$count = 1;
										$sizes = $colors['sizes'];
										foreach ( $sizes as $size ) {
											if ( $size >= 1 && $count === 1 ) {
												$content.= '<div><span>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' | Adult Size</span></div>'; 
											} elseif ( $size >= 1 && $count === 2  ) {
												$content.= '<div><span>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' | Medium Size</span></div>'; 
											} elseif ( $size >= 1 && $count === 3  ) {
												$content.= '<div><span>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' | Youth Size</span></div>'; 
											} 
											$total_qty = $total_qty + $size;
											$count++;
										}
									}                  
									$options = $wristband_meta['messages'];
									$content.= '<br /><b>Text on Wristbands:</b><br />';
									foreach ( $options as $key => $msg ) {
										if ( ! empty( $msg ) ) {
											$content.= '<span>' . $key . ': ' . $msg . '</span><br />'; 
										}
										
									}

									$clipart = $wristband_meta['clipart'];
									$content.= '<br /><b>Clipart:</b><br />';
									foreach ($clipart as $clipart_key => $clipart_value) {
										
										if ( ! empty( $clipart_value ) ) {
											$icon = '';
											if (preg_match('/(\.jpg|\.png|\.bmp)$/', $clipart_value)){ 
								              $icon = '<img src="'.wp_upload_dir()['baseurl'] . '/clipart/' . $clipart_value.'" alt="" width="16px" height="16px">';
								            } else {
								              $icon = '<i class="fa ' . $clipart_value . '"></i>';
								            }
											$content.= '<span>' . str_replace( '_', ' ', ucwords( $clipart_key ) ) . ':'. $icon .' '. str_replace( 'aykun-', '', $clipart_value) .' </span><br />'; 
										}
									}

									$options = $wristband_meta['additional_options'];
									if ( $options ) {
										$content.= '<br /><b>Additional Options:</b><br />';
										foreach ( $options as $option ) {
											$content.= '<span>' . $option . '</span><br />'; 
										}
									} 

									$content.= '<br /><b>Production and Shipping:</b><br />';
									$content.= '<span>' . $wristband_meta['customization_location'] . '</span><br />'; 
									$content.= '<span>' . $wristband_meta['customization_date_production'] . '</span><br />'; 
									$content.= '<span>' . $wristband_meta['customization_date_shipping'] . '</span><br />'; 
										$content.='<br/>';
								$content.='</td>';
								$content.='<td style="text-align: center; vertical-align: top;padding: 5px;">';
									$content.= $total_qty;
								$content.='</td>';
								$content.='<td style="text-align: center; vertical-align: top;padding: 5px;"> $';
									$content.= round($wristband_meta['total_price'], 2);
								$content.='</td>';
							$content.='</tr>';
						}
					}

					$content.='</tbody>';
					$content.='<tfoot>';
						$content.='<tr>';
							$content.='<td colspan="2" style="padding: 5px;"><b>Grand Total</b></td>';
							$content.='<td style="text-align: center;padding: 5px;"><b> '. $order->get_formatted_order_total() .' </b></td>';
						$content.='</tr>';
					$content.='</tfoot>';
				$content.='</table>';
				/* End Table - Order Summary - */

				$content.='<table width="100%" style="font-weight: lighter;    border-top: 3px solid #CAC4C4;background: #F3F3F3; padding: 20px 10px;">';
					$content.='<tr style="height: 130px;">';
						$content.='<td width="50%" style="vertical-align: top;">';
							$content.='<span style="color: #7B7B7B;">Arriving</span><br />';
							$content.='<span style="font-weight: normal;color: #2EB904;">' . $arrival . '</span> ';
							$content.='<p style="text-align: center;margin-top: 40px;">';
								$content.='<a style="font-size: 14px;font-weight: bold;padding: 16px 40px;color: #1D1D1D;text-decoration: none;border-radius: 5px;border: 1px solid #CCAF47;background: linear-gradient(to bottom, #fefcea 0%,#E4C553 52%);" href="' . home_url('customer-dashboard/?action=view&ID=' . $order_id ) . '">View or manage order</a>';
							$content.='</p>';
						$content.='</td>';
						$content.='<td width="50%" style="vertical-align: top;padding-left: 10px;">';
							$content.='<div style="margin: 0px auto;width: 220px;">';
								$content.='<span style="color: #7B7B7B;">Shipping Address:</span><br />';

								$user_id = get_current_user_id();

								$content.='<span>' . get_user_meta( $user_id, 'shipping_first_name', true ) . ' ' . get_user_meta( $user_id, 'shipping_last_name', true ) . '</span><br />';
								$content.='<span>' . get_user_meta( $user_id, 'shipping_address_1', true ) . '</span><br />';
								$content.='<span>' . get_user_meta( $user_id, 'shipping_address_2', true ) . '</span><br />';
								$content.='<span>' . get_user_meta( $user_id, 'shipping_state', true ) . '</span><br />';
								$content.='<span>' . get_user_meta( $user_id, 'billing_phone', true ) . '</span><br />';
								$content.='<p>';
									$content.='<span style="font-size: 13px;color: #5A5A5A;">Total Before Tax:&nbsp;&nbsp;$' . $sub_total . '</span> <br />';
									$content.='<span style="font-size: 13px;color: #5A5A5A;">Estimated Tax:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$' . $tax . '</span> <br />';
									$content.='<span style="font-size: 14px;color: #5A5A5A;font-weight: bold;">Order Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$' . $total . '</span>';
								$content.='</p>';
							$content.='</div>';
						$content.='</td>';
					$content.='</tr>';
				$content.='</table>';

				$content.='<p style="color: #737373;">We look forward to your continued business!</p>';
				$content.='<p style="margin-top: -10px; font-weight: bold;">WristbandCreation.com</p>';
				$content.='<hr style="border-top: 1px solid #ECE9E9;">';
				$content.='<img width="100%" src="https://gwplabs.com/wp-content/uploads/REFER-A-FRIEND.png" alt="">';
				$content.='<p style="color: #565656;font-size: 14px;">';
					$content.='This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.';
				$content.='</p>';
				// $content.='<p style="color: #565656;font-size: 14px;">';
				// 	$content.='By placing your order, you agree to WristbandCreation.com\'s <span style="color: #00A9D4;">Privacy Notice</span> and <span style="color: #00A9D4;">Condition of use</span>. Unless otherwise noted, items sold by WristbandCreation.com LLC are subject to sales tax in select states in accordance with the applicable laws of the state. If your order contains one or more items from a seller other than WristbandCreation.com LLC, it may be subject to state and local sales tax, depending upon the seller\'s business policies and the location of their operations. Learn more about <span style="color: #00A9D4;">tax and seller information</span>.';
				// $content.='</p>';
			$content.='</div>';
		$content.='</body>';
	$content.='</html>';

	return $content;
}

function wp_send_email_after_order( $order_id ){

	$args = get_req_info_for_email( $order_id );
	$content   =  email_content_after_order( $args );
	$headers[] = 'MIME-Version: 1.0' . "\r\n";
	$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers[] = "X-Mailer: PHP \r\n";
	$headers[] = 'From: Wristband Creation Team <no-reply@' . $_SERVER[HTTP_HOST] . '>' . "\r\n";
	$mail = wp_mail( $args['email'], 'Your Order of Customized Silicone Wristbands', $content, $headers );
}

/*	
*	variable required for the email template
*	$args = array(
*		'full_name' => '',
*		'order_name' => '',
*		'order_id' => '',
*		'arrival' => '',
*		'sub_total' => '',
*		'tax' => '',
*		'total' => ''
*		'track_link' => '',
*		);
*/
function send_email_shipped_confirmation( $args ){
	extract( $args );
	$content = '';

	//populating content
	$content.='<html>';
	$content.='<head>';
		$content.='<style type="text/css">';
			$content.='.title{  }';
		$content.='</style>';
	$content.='</head>';
	$content.='<body style="font-family: sans-serif; font-weight: lighter;">';
		$content.='<div style="width: 650px; margin: 0px auto;">';
			$content.='<table width="100%" style="border-bottom: 2px solid #ECE9E9;">';
				$content.='<tr>';
					$content.='<td><img style="width: 250px;" src="https://gwplabs.com/wp-content/uploads/wclogo.png" alt="logo"></td>';
					$content.='<td><p style="text-align: right;font-size: 18px;font-family: sans-serif;color: #585858;" >Shipping Confirmation</p></td>';
				$content.='</tr>';
			$content.='</table>';
			$content.='<p style="color: #213F99;font-size: 18px;">Hello ' . $full_name . ',</p>';
			$content.='<p>';
				$content.='<span style="color: #3EBEEF;">"'. $order_name . '".</span> have shipped.';
			$content.='</p>';
			$content.='<p style="color: #213F99;font-size: 18px; padding-bottom: 7px; border-bottom: 2px solid #ECE9E9; margin-bottom: -7px;">Details</p>';
			$content.='<p style="color: #9C9C9C;">Order <span style="color: #3EBEEF;">#WC000503</span></p>';
			$content.='<table width="100%" style="font-weight: lighter;    border-top: 3px solid #CAC4C4;background: #F3F3F3; padding: 20px 10px;">';
				$content.='<tr style="height: 135px;">';
					$content.='<td width="50%" style="vertical-align: top;">';
						$content.='<span style="color: #7B7B7B;">Arriving</span><br />';
						$content.='<span style="font-weight: normal;color: #2EB904;">' . $arrival . '</span>';
						$content.='<p style="text-align: center;margin-top: 40px;">';
							$content.='<a style="font-size: 14px;font-weight: bold;padding: 16px 40px;color: #1D1D1D;text-decoration: none;border-radius: 5px;border: 1px solid #90D0E8;background: linear-gradient(to bottom, #E6F8FF 0%,#96E1FF 52%);" href="' . $tack_link . '">Track your package</a>';
						$content.='</p>';
					$content.='</td>';
					$content.='<td width="50%" style="vertical-align: top;padding-left: 10px;">';
						$content.='<div style="margin: 0px auto;width: 160px;">';
							$content.='<span style="color: #7B7B7B;">Ship to:</span><br />';
							$content.='<span>Chris Angels</span>';
							$content.='<p>';
								$content.='<span style="font-size: 13px;color: #5A5A5A;">Total Before Tax:&nbsp;&nbsp;$' . $sub_total . '</span> <br />';
								$content.='<span style="font-size: 13px;color: #5A5A5A;">Estimated Tax:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$' . $tax . '</span> <br />';
								$content.='<span style="font-size: 14px;color: #5A5A5A;font-weight: bold;">Order Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$' . $total . '</span>';
							$content.='</p>';
						$content.='</div>';
					$content.='</td>';
				$content.='</tr>';
				$content.='<tr>';
					$content.='<td style="text-align: center;height: 60px;vertical-align: top;">';
						$content.='<a style="font-size: 14px;font-weight: bold;padding: 16px 63px;color: #1D1D1D;text-decoration: none;border-radius: 5px;border: 1px solid #B9B8B6;background: linear-gradient(to bottom, #F3F2F1 0%,#D4D2CA 52%);" href="' . home_url('customer-dashboard/?action=view&ID=' . $order_id ) . '">Order Details</a>';
					$content.='</td>';
					$content.='<td></td>';
				$content.='</tr>';
			$content.='</table>';
			$content.='<p style="color: #737373;">We hope to see you again soon.</p>';
			$content.='<p style="margin-top: -10px; font-weight: bold;">Wristband Creation</p>';
			$content.='<hr style="border-top: 1px solid #ECE9E9;">';
			$content.='<img width="100%" src="https://gwplabs.com/wp-content/uploads/REFER-A-FRIEND.png" alt="">';
			$content.='<hr style="border-top: 1px solid #ECE9E9;">';
			$content.='<p style="color: #565656;font-size: 14px;">';
				$content.='You invoice can be accessed here.';
			$content.='</p>';
			$content.='<p style="color: #565656;font-size: 14px;">';
				$content.='This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.';
			$content.='</p>';
		$content.='</div>';
	$content.='</body>';
$content.='</html>';

return $content;
}

function wp_send_email_shipping_confirmation( $order_id ){
	
	$args      =  get_req_info_for_email( $order_id );

	ini_set("SMTP", "aspmx.l.google.com");
    ini_set("sendmail_from", "sheldongwapo@gmail.com");

	$content   =  send_email_shipped_confirmation( $args );
	$headers[] = 'MIME-Version: 1.0' . "\r\n";
	$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers[] = "X-Mailer: PHP \r\n";
	$headers[] = 'From: Wristband Creation Team <no-reply@' . $_SERVER[HTTP_HOST] . '>' . "\r\n";

	$to = $args['email'];
	$subject = "Your Wristbands Has Shipped Out";

	$mail = wp_mail( $to, $subject, $content, $headers );
	if ( ! $mail ) {
		echo "not sent";
	}

}

function get_req_info_for_email( $order_id ) {
	//initailizing and populating required data for the sending of email
	$user_id = get_post_meta( $order_id, '_customer_user', true );
	$user = get_userdata( $user_id );

	$order = new WC_Order( $order_id );
	$items = $order->get_items();
	$order_name = '';
	$arrival = '';
	$sub = 0;
	foreach ($items as $value) {
    	$order_name = $value['name'];
    	$meta = maybe_unserialize( $value['wristband_meta'] );

    	if ( ! empty( $meta['guaranteed_delivery'] ) ) {
    		$arrival = $meta['guaranteed_delivery'];
    	} else {
    		$date_production = substr( $meta['customization_date_production'], 0, 1);
    		$date_shipping   = substr( $meta['customization_date_shipping'], 0, 1);
    		$date_shipped    = get_post_meta( $order_id, '_completed_date' , true );
    		$arrival = calculate_guaranteed_delivery( $date_production, $date_shipping, $date_shipped );
    	}
    	
    	$sub = $value['line_subtotal'];
    }

	$args = array(
		'full_name' => $user->display_name,
		'order_name' => $order_name,
		'order_id' => $order_id,
		'arrival' => $arrival,
		'sub_total' => $sub,
		'tax' => get_post_meta( $order_id, '_order_tax', true ),
		'total' => get_post_meta( $order_id, '_order_total', true ),
		'user_id' => $user_id,
		'tack_link' => 'https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=' . get_post_meta( $order_id, 'supplier_trackingnumber', true ),
		'email' => 'chris@kulayful.com' //get_user_meta( $user_id, 'billing_email', true )
	);
	return $args;
}

function calculate_guaranteed_delivery( $date_production, $date_shipping, $date_shipped ) {
	//initializing...
	$date1 = substr($date_shipped, 0, 10);
	$add_days = $date_shipping + $date_production;
	$date = date( 'F j Y', strtotime( $date1 . ' + ' . $add_days . ' days' ) ); // ' . $add_days . '

	$check_day = date( 'l', strtotime( $date1 . ' + ' . $add_days . ' days' ) );
	if ( $check_day == 'Saturday' || $check_day == 'Sunday') {
		$add_days = $add_days + 2;
		$date = date( 'F j Y', strtotime( $date1 . ' + ' . $add_days . ' days' ) );
	}
	return $date;
}

function custom_get_order( $keyword, $filter ){

	global $wpdb;

	$sql = "SELECT ID FROM $wpdb->posts WHERE post_status = 'wc-completed'";

	$posts = $wpdb->get_results( $sql );
	$results ="";

	foreach ( $posts as $post ) { 

		foreach ($post as $id ) {
			$metas = "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id = '$id'";
			$pmeta = $wpdb->get_results( $metas );

			foreach ( $pmeta as $m ) {
				$results[$id]['post_meta'][$m->meta_key] = $m->meta_value;
			}
		}
		// $post['pmeta'] = $pmeta;
	}
	$oit = 'line_item';
	foreach ( $results as $id => $metas ) {
		
		$sql_line = "SELECT
					order_item_id,
					order_item_name
					FROM wcv2_woocommerce_order_items
					WHERE order_id = '$id'
					AND order_item_type = '$oit'";

		$order = $wpdb->get_results( $sql_line );

		foreach ($order as $k => $v) {
			$results[$id]['order_item'][$v->order_item_name]['woo_id'] = $v->order_item_id;
			$woo = $results[$id]['order_item'];
			foreach ( $woo as $woo_id ) {

				$metas = "SELECT meta_key, meta_value FROM wcv2_woocommerce_order_itemmeta WHERE order_item_id = '{$woo_id['woo_id']}'";
				$woo_meta = $wpdb->get_results( $metas );

				foreach ( $woo_meta as $m ) {
					$results[$id]['order_item'][$v->order_item_name][$m->meta_key] = $m->meta_value;
				}
			}	
		}
		
	}

	$post_ids = '';
	switch ( $filter ) {
		case 'post_id':
			foreach ( $results as $key => $value ) {
				if ( $keyword == $key ) {
					$post_ids[] = $key;
				}
			}
			break;
		
		default:
			# code...
			break;
	}

	return $post_ids;
}

