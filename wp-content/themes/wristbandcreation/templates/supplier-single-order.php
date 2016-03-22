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
$key = '_new_status';
$poststatusmeta = get_post_meta($order_id, $key, TRUE);
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
	</div>
	<hr class="divider-full" />
	<div class="dash-filter">
		<p class="approval">Your design is beign updated by the ADMIN and it needs your approval. Click <a href="#">HERE</a> to see the revision.</p>
		<!-- <span>Filter:</span> -->
	</div>
  <form id="changing-status" method="post">
  <select name="newstatus">
    <option value="pending_production"  <?php if($poststatusmeta == "pending_production") echo "selected"; ?>>pending production</option>
    <option value="pending_artwork_approval" <?php if($poststatusmeta == "pending_artwork_approval") echo "selected"; ?> >pending artwork approval</option>
    <option value="in_production" <?php if($poststatusmeta == "in_production") echo "selected"; ?>>in production</option>
    <option value="in_reproduction" <?php if($poststatusmeta == "in_reproduction") echo "selected"; ?>>in re-production</option>
    <option value="produced_pending_shipment" <?php if($poststatusmeta == "produced_pending_shipment") echo "selected"; ?>>produced – pending shipment</option>
    <option value="shipped" <?php if($poststatusmeta == "shipped") echo "selected"; ?>>shipped</option>
  </select>
    <input type="hidden" value="<?php echo $order_id; ?>" name="order_id">
    <input type="submit" name="status-submit" value="Change Status">
  </form>
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
                  <label class="pricestyle"> Tracking Number </label>
                  <input type="text" name="trackingnum" id="trackingnum" class="form-control priceinputstyle1" placeholder="Input Here" value="">
                </div>
                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Mold - Set Up </label>
                    <input type="number" name="moldquantity" id="moldquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="moldprice" id="moldprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="mold" id="mold" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Printing - Set Up </label>
                    <input type="number" name="printingquantity" id="printingquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="printingprice" id="printingprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="printing" id="printing" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Laser Engraving </label>
                    <input type="number" name="laserquantity" id="laserquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="laserprice" id="laserprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="laser" id="laser" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Color Fill </label>
                    <input type="number" name="colorfillquantity" id="colorfillquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="colorfillprice" id="colorfillprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="colorfill" id="colorfill" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Embossed-Color </label>
                    <input type="number" name="embossedquantity" id="embossedquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="embossedprice" id="embossedprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="embossedp" id="embossedp" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Imprinting Fee </label>
                    <input type="number" name="imprintingquantity" id="imprintingquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="imprintingprice" id="imprintingprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="imprintingp" id="imprintingp" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Swirl </label>
                    <input type="number" name="swirlquantity" id="swirlquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="swirlprice" id="swirlprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="swirlp" id="swirlp" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Segmented </label>
                    <input type="number" name="segmentedquantity" id="segmentedquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="segmentedprice" id="segmentedprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="segmentedp" id="segmentedp" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Glow </label>
                    <input type="number" name="glowquantity" id="glowquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="glowprice" id="glowprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="glowp" id="glowp" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Dual Layer </label>
                    <input type="number" name="duallayerquantity" id="duallayerquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="duallayerprice" id="duallayerprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="duallayerp" id="duallayerp" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Inside Embossed </label>
                    <input type="number" name="insideembossedquantity" id="insideembossedquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="insideembossedprice" id="insideembossedprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="insideembossed" id="insideembossed" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Individual Packaging </label>
                    <input type="number" name="individualpkgquantity" id="individualpkgquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="individualpkgprice" id="individualpkgprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="individualpkg" id="individualpkg" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Keychains </label>
                    <input type="number" name="keychainsquantity" id="keychainsquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="keychainsprice" id="keychainsprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="keychains" id="keychains" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                  	<label class="pricestyle"> Shipping (DHL) </label>
                    <input type="number" name="shipdhlquantity" id="shipdhlquantity" class="form-control priceinputstyle" placeholder="Quantity" value="">
                    <input type="number" name="shipdhlprice" id="shipdhlprice" class="form-control priceinputstyle" placeholder="Unit Price" value="">
                    <input type="number" name="shipdhl" id="shipdhl" value="" class="form-control priceinputstyle" placeholder="Total" readonly>
                  </div>

                  <div class="form-group clearfix">
                    <label class="pricestyle"> Select file to upload </label>
                    <input type="file" name="fileToUpload" id="fileToUpload" value="" class="form-control priceinputstyle">
                    <img id="imageprev" src="http://goo.gl/pB9rpQ" alt="your image" class="imagestyle"/>
                  </div>

                  <div class = "priceinputstyle">
                    TOTAL : <p id="wtotalprice"></p>
                    <input type="hidden" name="wtotalprice" id="wtotalprice1" value="">
                  </div>
                  <div class="form-group">     
                    <input type="submit" name="delivery-submit" id="delivery-submit" tabindex="4" class="form-control btn btn-login" value="SHIP NOW">
                  </div>
              </form>
            </div>
</div>

