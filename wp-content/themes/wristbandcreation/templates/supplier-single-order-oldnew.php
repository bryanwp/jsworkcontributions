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


// echo "<pre>";
// print_r($customer_orders);
// die;

    if ( $order ) : 

      ?>
    <div class="order-container">
      <?php foreach ( $items as $item ) {
        $wristband_meta = maybe_unserialize( $item['wristband_meta']);
        $color = $wristband_meta['colors'];
        ?>
        <div class="details-container">
          <h3><?php echo $item['name']; ?> Wristband</h3>
          <div class="row">
            <div class="col-md-6">
              <table class="tbl-info" width="100%">
                <tr>
                  <td>Width:</td>
                  <td><?php echo $wristband_meta['size']; ?></td>
                </tr>
                <?php
                $color = $wristband_meta['colors'];
                foreach ($color as $colors) {
                  $count = 1;
                  $sizes = $colors['sizes'];
                  foreach ( $sizes as $size ) {
                    if ( $size >= 1 && $count === 1 ) {
                      echo '<tr><td>Qty/Color/Size</td><td>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' Adult Size</td></tr>'; 
                    } elseif ( $size >= 1 && $count === 2  ) {
                      echo '<tr><td>Qty/Color/Size</td><td>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' Medium Size</td></tr>'; 
                    } elseif ( $size >= 1 && $count === 3  ) {
                      echo '<tr><td>Qty/Color/Size</td><td>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' Youth Size</td></tr>'; 
                    } 
                    $count++;
                  }
                }
                ?>
                <?php
                $options = $wristband_meta['messages'];
                foreach ( $options as $key => $msg ) {
                  if ( empty( $msg ) ) {
                    $msg = 'None';
                  }
                  echo '<tr><td>' . $key . ':</td><td>' . $msg . '</td></tr>'; 
                }

                ?>
              </table>
            </div>

            <div class="col-md-6">
              <table class="tbl-info" width="100%">
                <?php
                $options = $wristband_meta['additional_options'];
                if ( $options ) {
                  foreach ( $options as $option ) {
                    echo '<tr><td>Addtional Options</td><td>' . $option . '</td></tr>'; 
                  }
                } else {
                  echo '<tr><td>Addtional Options</td><td>None</td></tr>'; 
                }
                ?>
              </table>
            </div>

          </div>
        </div>
        <?php } ?>
      </div>
      <?php endif; ?>
      <div class="col-lg-12">

          <center><h2>Wristband Price</h2></center>

          <div class="form-group clearfix trackstyle">
          <form id="changing-tracknum" method="post">
            <div class="err-container1">
            </div>
            <div class="err-container2">
            </div>
            <div class="err-container3">
            </div>
          <label class="tracknum-label"> Tracking Number </label>
            <input type="text" name="trackingnum" id="trackingnum" class="form-control" placeholder="Input Here" value="<?php echo $tracknumbermeta; ?>">
            <input type="submit" id="track-submit" name="track-submit" class="save-button-design" value="Send Track Number" style="color : white!important">
            <input type="hidden" name="post-id" value="<?php echo $order_id; ?>">
          </form>
          <form id="changing-status" method="post">
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
          </form>           
          </div>

          <!-- Artwork Approval -->
          <div class="artwork col-md-12">
          <!-- <div class="artwork-title"> -->
        
          <!-- </div> -->
          <form id="supplier-artwork" method="post">
          <input type="hidden" name="post-id" value="<?php echo $order_id; ?>">
          <div class="artwork-title">
          For supplier Artwork<input type="submit" class="save-button-design" name="supp_artwork" value="Save">
          </div>
            <?php 
            $artwork = get_post_meta( $order_id, 'supplier_artwork', true );

            if ( $artwork ) { ?>
              <div class="file-supp" style="display: inline;">
                <div class="fpost-img">
                  <?php
                    foreach ($artwork as $key => $value) { ?>
                    
                      <div class="img-holder">
                        <span class="remove-file">x</span>
                        <img class="img-artwork" src="<?php echo $value; ?>">
                        <input type="hidden" class="attachment_id" name="img<?php echo $key; ?>" value="<?php echo $value; ?>">
                      </div>

                    <?php } ?>
                  <input id="art-work-count-supp" type="hidden" name="img-count" value="0">
                  <!-- <input type="hidden" name="form-action" value="admin-artwork"> -->
                  <input type="hidden" name="post-id" value="<?php echo $order_id; ?>">
                </div>
                <button class="media-button-supp add-btn">Add Artwork</button>
              </div> <!--container for the upload files-->  
            <?php } else { ?>
              <div class="file-supp">
                <div class="fpost-img">
                  <input id="art-work-count-supp" type="hidden" name="img-count" value="0">
                  <!-- <input type="hidden" name="form-action" value="admin-artwork"> -->
                  <input type="hidden" name="post-id" value="<?php echo $order_id; ?>">
                </div>
                <button class="media-button-supp add-btn">Add Artwork</button>
              </div> <!--container for the upload files-->  
              <center class="no-file">
                <p>
                  Add an artwork of the wristband.
                </p>
                <p>
                  <button class="media-button-supp" type="button" name="upload-image">Upload</button>
                </p>
              </center>
            <?php } ?>
            </form>
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
  <div>
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
    <?php 
    // $meta = get_post_meta($order_id,"supplier_artwork");
    //       for ($i=0; $i < sizeof($meta); $i++) { 
    //         for ($k=0; $k < sizeof($meta[$i]) + 1 ; $k++) { 
    //           echo '<img src="'.$meta[$i][$k].'">';
    //         }

    //       } ?>
        </form>
      </div>

<?php } ?>
 </div>
</div>
<?php 
    $question = get_post_meta( $order_id, 'supplier_report_content', true );

    if ( $question ) { ?>
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
      $user = "supplier";
      include ('supplier/supplier-page-report.php'); 
      }
    ?>
</div>

<?php 
    // $question = get_post_meta( $order_id, 'customer_report_content', true );

    // if ( $question ) { ?>
   <!--    <div class="dash-title-holder">
        <h2>Question <span class="time-ago"><time class="timeago" datetime="<?php // echo get_post_meta( $order_id, 'customer_report_time_added', true ); ?>" >asd</time></span></h2>
      </div>
      <hr class="divider-full" />
      <div class="dash-filter">
      </div>
      
      <div class="report-box">

        <p class="report-content">
          <?php // echo get_post_meta( $order_id, 'customer_report_content', true ); ?>
        </p>
      </div>
      <div id="creply" class="reply-container"> -->
        <?php //include ('customer-dashboard-single-report.php'); ?>
      <!-- </div> -->
    <?php
    // } else {
    //   $user = "customer";
    //   include ('customer-dashboard-notif-form.php'); 
    // }
    
  ?>


