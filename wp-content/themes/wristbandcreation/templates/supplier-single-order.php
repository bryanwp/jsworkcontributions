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
$tracknumbermeta = get_post_meta($order_id, 'supplier_trackingnumber', TRUE);
$supplier = 'supplier_';
$rowval = get_post_meta($order_id, $supplier.'maxrowval', TRUE);
$totalkey = get_post_meta($order_id, $supplier.'wtotalprice', TRUE);
$upimage = get_post_meta($order_id, 'Supplier_artwork', TRUE);

?>
<div class="col-md-12 white">
	<div class="gap-top">
    <span class="welcome"><?php echo 'Welcome ' . $current_user->user_firstname; ?></span>
  </div>
  <div style="margin-top: 20px;">
    <h2><?php echo get_order_number_format( $order_id ); ?></h2> 
  </div>

  <div class="table-1 no-overflow">
    <?php
    if ( $order ) : 
      echo '<div id="sup-table">';
      echo do_shortcode('[the-cart-meta item_key="'.$order_id.'"]');
      echo '</div>';
    endif; 
    ?>
    <div class="col-lg-12">

      <center><h2>Wristband Price</h2></center>

      <div class="form-group clearfix trackstyle">

          <div class="err-container1">
          </div>
          <div class="err-container2">
          </div>
          <div class="err-container3">
          </div>

      <?php if ( $tracknumbermeta ): ?>
            <form id="changing-tracknum" method="post">
              <label class="tracknum-label"> Tracking Number </label>
              <input type="text" name="trackingnum" id="trackingnum" class="form-control" placeholder="Input Here" value="<?php echo $tracknumbermeta; ?>">
              <input type="submit" id="track-submit" name="track-submit" class="save-button-design" value="Update Track Number" style="color : white!important">
              <input type="hidden" name="post-id" value="<?php echo $order_id; ?>">
            </form>
      <?php endif; ?>

      <?php if ($poststatusmeta == 'shipped'): ?>
        
        <h3>STATUS: SHIPPED</h3>

      <?php else: ?>
        <form id="changing-status" method="post">

        <?php if ( !$tracknumbermeta ): ?>
            <div class="tracknum-design" style="display: none;">
            <label class="tracknum-label"> Tracking Number </label>
            <input type="text" name="trackingnum" id="trackingnum" class="form-control" placeholder="Input Here" value="<?php echo $tracknumbermeta; ?>">
            <!-- <input type="submit" id="track-submit" name="track-submit" class="save-button-design" value="Send Track Number" style="color : white!important"> -->
            </div>
        <?php endif; ?>
          <input type="submit" id="status-submit" name="status-submit" class="save-button-design" value="Change Status" style="color : white!important">
          <input type="hidden" id="savedstatus" value="<?php echo $poststatusmeta;?>" >
          <select name="newstatus" id="newstatus">
            <option value="0"  <?php if($poststatusmeta == "pending_production") echo "selected"; ?>>pending production</option>
            <option value="1" <?php if($poststatusmeta == "pending_artwork_approval") echo "selected"; ?> >pending artwork approval</option>
            <option value="2" <?php if($poststatusmeta == "in_production") echo "selected"; ?>>in production</option>
            <option value="3" <?php if($poststatusmeta == "in_reproduction") echo "selected"; ?>>in re-production</option>
            <option value="4" <?php if($poststatusmeta == "produced_pending_shipment") echo "selected"; ?>>produced – pending shipment</option>
            <option value="5" <?php if($poststatusmeta == "shipped") echo "selected"; ?>>shipped</option>
          </select> 
          <input type="hidden" name="post-id" value="<?php echo $order_id; ?>">
        </form> 
      <?php endif; ?>          
      </div>

      <!-- Artwork Approval -->
         <div class="artwork col-md-12 ">
  <?php 
  if ( !$upimage) { 
    ?>

    <form method="post" enctype="multipart/form-data">
      <div class="file-supp" style="display: inline;">
          Select image to upload:
          <input type="file" accept="image/*" class="save-button-design" name="newupload_image[]" id="newupload_image" multiple="multiple">
          <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
        <input type="submit"  class="save-button-design"  value="Upload Image" name="up-image">
      </div> 
    </form>
    <?php       
  } else {
   ?>
   <form  method="post" enctype="multipart/form-data">
      <div class="artwork-title">
        <input type="submit" class="save-button-design" name="supp_update_artwork" value="Update">
      </div>
      <div class="file-supp" style="display: inline;">
        <div class="fpost-img">
          <?php 
          $i = 0;
          foreach ($upimage as $key => $value) {
            $i++;
            ?>

            <div class="img-holder">
              <span class="remove-file-img">x</span>

              <img class="img-artwork" name="image-url" src="<?php echo $value['url']; ?>">
              <input type="hidden" class="attachment_id" name="img-file_<?php echo $i;?>" value="<?php echo $value['file']; ?>">
              <input type="hidden" class="attachment_id" name="img-url_<?php echo $i;?>" value="<?php echo $value['url']; ?>">   
              <input type="hidden" class="attachment_id" name="img-type_<?php echo $i;?>" value="<?php echo $value['type']; ?>">
            </div>
            <?php } ?>
            <img id="imageprev" src="" alt=""  />
          </div>
          <input type="file" name="add_image" accept="image/*" id="add_image">
          <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
        </div>
      </form>
    <?php } ?>
    </div>

    <!-- End of Artwork Approval -->
    <?php   if ($totalkey == '' || $totalkey == 0) {?>
    <form id="save-price-field" method="post">
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
      <input type="hidden" name="maxrowval" id="maxrowval" value="">
      <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
      <input type="submit" id="save-price" class="save-button-design" name="save-price" value="Save" style="color : white!important">
      <div class = "priceinputstyle">
        TOTAL : <p id="wtotalprice"></p>
        <input type="hidden" name="wtotalprice" id="wtotalprice1" value="">
      </div>
    </form>

    <?php } else {

      $arrquantity = ["moldquantity_", "printingquantity_", "laserquantity_","colorfillquantity_","embossedquantity_","imprintingquantity_","swirlquantity_","segmentedquantity_","glowquantity_","duallayerquantity_","insideembossedquantity_","individualpkgquantity_","keychainsquantity_","shipdhlquantity_"];
      $arrprice = ["moldprice_", "printingprice_", "laserprice_","colorfillprice_","embossedprice_","imprintingprice_","swirlprice_","segmentedprice_","glowprice_","duallayerprice_","insideembossedprice_","individualpkgprice_","keychainsprice_","shipdhlprice_"];
      $arrtotal = ["mold_","printing_","laser_","colorfill_","embossedp_","imprintingp_","swirlp_","segmentedp_","glowp_","duallayerp_","insideembossed_","individualpkg","keychains","shipdhl_"];
      ?>
      <form id="change-list" method="post">
        <div id='appendedid'>
          <div></div>
          <?php
          $qty = get_post_meta($order_id, $supplier.'wpqty', TRUE);
          $price = get_post_meta($order_id, $supplier.'wpprice', TRUE);
          $total = get_post_meta($order_id, $supplier.'wptotal', TRUE);
          $j = 0;
          foreach ($total as $key => $value) {
                  # code...
            $k = change_to_int($key);
            for ($i=0; $i <sizeof($value) ; $i++) { 
              echo '<div><div class="form-group clearfix num_'.$j.'" id="divappend_'.$k.'" >
              <label class="pricestyle"> '.change_label_name($key).' </label>
              <input type="number" name="'.change_qty_name($key).$i.'" id="'.change_qty_name($key).$i.'" class="form-control priceinputstyle inputqty" placeholder="Quantity" value="'.$qty[change_qty_name($key)][$i].'">
              <input type="number" step="any" name="'.change_price_name($key).$i.'" class="form-control priceinputstyle inputprice" placeholder="Unit Price" value="'.$price[change_price_name($key)][$i].'">
              <input type="number" name="'.$key.$i.'" value="'.$value[$i].'" class="form-control priceinputstyle thetotal" readonly>
              <input type="hidden" value="'.$order_id.'" name="order_id">
              <a href="#" id="removestyle">Remove</a></div></div>';
              $j++;
            }
          }

          ?> 
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
        <input type="hidden" value="<?php echo $order_id; ?>" name="order_id">
        <input type="hidden" value="<?php echo $j; ?>" name="var">
        <input type="hidden" name="maxrowval" id="maxrowval" value="<?php echo $rowval; ?>">
        <div class = "priceinputstyle">
          TOTAL : <p id="wtotalprice"><?php echo $totalkey; ?></p>
          <input type="hidden" name="wtotalprice" id="wtotalprice1" value="<?php echo $totalkey; ?>">
        </div>
        <input class="edit-order save-button-design" type="submit" id="update-price-list" name="update-price-list" value="Update" style="color : white!important">
      </form>
      <?php } ?>
    </div>
  </div>
  <?php 
  $question = get_post_meta( $order_id, 'supplier_report_content', true );

  if ( $question ) { ?>
  <input id="hasComment" type="hidden" name="hasComment" value="true">
  <div class="dash-title-holder">
    <h2>Question <span class="time-ago"><time class="timeago" datetime="<?php echo get_post_meta( $order_id, 'supplier_report_time_added', true ); ?>" >asd</time></span></h2>
  </div>
  <hr class="divider-full" />
  <div class="dash-filter">
  </div>
  <div class="report-box">

    <p class="report-content">
      <?php echo get_post_meta( $order_id, 'supplier_report_content', true ); ?>
    </p>
  </div>
  <div id="creply" class="reply-container">
    <?php include ('supplier/supplier-page-reply.php'); ?>
  </div>
  <?php } else {
    ?>
    <input id="hasComment" type="hidden" name="hasComment" value="false">
    <?php
    $user = "supplier";
    include ('supplier/supplier-page-report.php'); 
  }
  ?>
 
  </div>
