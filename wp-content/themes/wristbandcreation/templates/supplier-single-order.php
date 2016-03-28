<?php
$order_id = '';
if ( isset( $_GET['ID'] ) ) {
 $order_id = $_GET['ID'];
}

$key = get_post_meta( $order_id, '_order_key', true );
$pay_link = home_url('checkout/order-pay/' . $order_id . '?pay_for_order=true&key=' . $key);
$order = new WC_Order( $order_id );
$items = $order->get_items();
$key = '_new_status';
$poststatusmeta = get_post_meta($order_id, $key, TRUE);
?>
<div class="col-md-12 white">
	<div class="gap-top"></div>
	<div class="dash-title-holder">
		<h2>Order #<?php echo $order_id; ?></h2>
	</div>
	<hr class="divider-full" />
	<div class="dash-filter">
		<p class="approval">Your design is beign updated by the ADMIN and it needs your approval. Click <a href="#">HERE</a> to see the revision.</p>
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
<div class="col-lg-12">
  <form id="changing-status" method="post">
    <center><h2>Wristband Price</h2></center>
    <div class="form-group clearfix">
      <label class="pricestyle"> Tracking Number </label>
      <input type="text" name="trackingnum" id="trackingnum" class="form-control priceinputstyle1" placeholder="Input Here" value="">
    </div>
    <div id='appendedid'>
      <div></div>
    </div>
    <select id="selectedfield">
      <option value="0">Mold - Set Up</option>
      <option value="1">Printing - Set Up</option>
      <option value="2">Laser Engraving</option>
      <option value="3">Color Fill</option>
      <option value="4">Embossed-Color</option>
      <option value="5">Imprinting Fee</option>
      <option value="6">Swirl</option>
      <option value="7">Segmented</option>
      <option value="8">Glow</option>
      <option value="9">Dual Layer</option>
      <option value="10">Inside Embossed</option>
      <option value="11">Individual Packaging</option>
      <option value="12">Keychains</option>
      <option value="13">Shipping (DHL)</option>

    </select>
    <button id="addfield" type="button" >Add Field</button>
    <div class="form-group clearfix">
      <label class="pricestyle"> Select file to upload </label>
      <input type="file" name="fileToUpload" id="fileToUpload" value="" class="form-control ">
      <img id="imageprev" src="http://goo.gl/pB9rpQ" alt="your image" class="imagestyle"/>
    </div>

    <div class = "priceinputstyle">
      TOTAL : <p id="wtotalprice"></p>
      <input type="hidden" name="wtotalprice" id="wtotalprice1" value="">
    </div>
    <select name="newstatus">
      <option value="pending_production"  <?php if($poststatusmeta == "pending_production") echo "selected"; ?>>pending production</option>
      <option value="pending_artwork_approval" <?php if($poststatusmeta == "pending_artwork_approval") echo "selected"; ?> >pending artwork approval</option>
      <option value="in_production" <?php if($poststatusmeta == "in_production") echo "selected"; ?>>in production</option>
      <option value="in_reproduction" <?php if($poststatusmeta == "in_reproduction") echo "selected"; ?>>in re-production</option>
      <option value="produced_pending_shipment" <?php if($poststatusmeta == "produced_pending_shipment") echo "selected"; ?>>produced – pending shipment</option>
      <option value="shipped" <?php if($poststatusmeta == "shipped") echo "selected"; ?>>shipped</option>
    </select> 
    <input type="hidden" value="<?php echo $order_id; ?>" name="order_id">
    <?php if($poststatusmeta == "shipped") {?>
     <input type="submit" id="status-submit" name="status-submit" value="Change Status" disabled>
      <?php } else { ?>
    <input type="submit" id="status-submit" name="status-submit" value="Change Status">
    <?php } ?>
  </form>

</div>
</div>

