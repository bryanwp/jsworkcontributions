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

<!--
Mold - Set Up
Printing - Set Up
Laser Engraving
Color Fill
Embossed-Color
Imprinting Fee
Swirl
Segmented
Glow
Dual Layer
Inside Embossed
Individual Packaging
Keychains
Shipping (DHL)
 -->
 			<div class="col-lg-12">
              <form id="wristband-price-form" method="post" role="form" style="display: block;">
                <center><h2>Wristband Price</h2></center>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Mold - Set Up </label>
                    <input type="text" name="moldquantity" id="moldquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="moldprice" id="moldprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="mold" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Printing - Set Up </label>
                    <input type="text" name="printingquantity" id="printingquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="printingprice" id="printingprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="printing" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Laser Engraving </label>
                    <input type="text" name="laserquantity" id="laserquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="laserprice" id="laserprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="laser" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Color Fill </label>
                    <input type="text" name="colorfillquantity" id="colorfillquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="colorfillprice" id="colorfillprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="colorfill" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Embossed-Color </label>
                    <input type="text" name="embossedquantity" id="embossedquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="embossedprice" id="embossedprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="embossedp" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Imprinting Fee </label>
                    <input type="text" name="imprintingquantity" id="imprintingquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="imprintingprice" id="imprintingprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="imprintingp" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Swirl </label>
                    <input type="text" name="swirlquantity" id="swirlquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="swirlprice" id="swirlprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="swirlp" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Segmented </label>
                    <input type="text" name="segementedquantity" id="segmentedquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="segmentedprice" id="segmentedprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="segmentedp" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Glow </label>
                    <input type="text" name="glowquantity" id="glowquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="glowprice" id="glowprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="glowp" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Dual Layer </label>
                    <input type="text" name="duallayerquantity" id="duallayerquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="duallayerprice" id="duallayerprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="duallayerp" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Inside Embossed </label>
                    <input type="text" name="insideembossedquantity" id="insideembossedquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="insideembossedprice" id="insideembossedprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="insideembossed" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Individual Packaging </label>
                    <input type="text" name="individualpkgquantity" id="individualpkgquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="individualpkgprice" id="individualpkgprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="individualpkg" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Keychains </label>
                    <input type="text" name="keychainsquantity" id="keychainsquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="keychainsprice" id="keychainsprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="keychains" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Shipping (DHL) </label>
                    <input type="text" name="shipdhlquantity" id="shipdhlquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="text" name="shipdhlprice" id="shipdhlprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="text" name="shipdhl" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>
                  <div class="form-group">     
                    <input type="submit" name="delivery-submit" id="delivery-submit" tabindex="4" class="form-control btn btn-login" value="Deliver Order Supply">
                  </div>
              </form>
            </div>
</div>

