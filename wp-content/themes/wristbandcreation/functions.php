<?php
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-stylesheet', get_template_directory_uri() . '/style.css' );
//	wp_enqueue_script( 'avada' );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );


/* To work with TypeKit
function theme_typekit() {
      wp_enqueue_script( 'theme_typekit', '//use.typekit.net/eoe0gac.js', '', false);
  }
  add_action( 'wp_enqueue_scripts', 'theme_typekit' );

  function theme_typekit_inline() {
    if ( wp_script_is( 'theme_typekit', 'done' ) ) { ?>
      <script>try{Typekit.load();}catch(e){}</script>
    <?php }
  }
  add_action( 'wp_head', 'theme_typekit_inline' );*/


include_once (get_stylesheet_directory() . '/wristband/class-wristband.php');

function wdm_add_values_to_order_item_meta($item_id, $values) {
  global $woocommerce,$wpdb;
  $product_custom_values = $values['wristband_meta'];
  if(!empty($product_custom_values)) {
    wc_add_order_item_meta($item_id,'wristband_meta',$product_custom_values);
  }
}
add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);


add_action( 'woocommerce_before_order_itemmeta', 'GetOrderDetail', 10, 3 );
function GetOrderDetail( $item_id, $item, $_product ){
    global $woocommerce;
    $order = new WC_Order( $item_id );
    $_product  = apply_filters( 'woocommerce_order_item_product', $_product, $item );
    $item_meta = new WC_Order_Item_Meta( $item['item_meta'] );

    foreach ($item_meta as $key => $value) {
      if($key == 'meta'){
        $meta = unserialize($value['wristband_meta'][0]);
    ?>
        <br>
        <div>
        <label class="t-heading"><?php echo $_product->get_title() . ' - ' . (isset($meta['size']) ? $meta['size'] : '') . ' Inch.'; ?></label>
        <label>Quantity & Colors</label>
        <?php if (isset($meta['colors'])): ?>
          <ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
            <?php foreach ($meta['colors'] as $color): if (!isset($color['name']) || empty($color['name'])) continue; ?>
              <li class="fusion-li-item">
                <div class="fusion-li-item-content">
                  <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
                    <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
                  </span>
                  <span><?php echo $color['name']; ?></span> – <?php echo $color['type']; ?>: <em>(<?php echo $color['color']; ?>
                    )</em>
                </div>
                <?php if (isset($color['sizes']) && count($color['sizes']) != 0): ?>
                  <ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
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
              <div class="fusion-li-item-content">
                <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
                  <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
                </span>

                <span>Font Style</span> – <?php echo $meta['font']; ?>
              </div>
            </li>
          <?php endif; ?>
          <?php if (isset($meta['messages'])): foreach ($meta['messages'] as $label => $val): if (empty($val)) continue; ?>
            <li class="fusion-li-item">
              <div class="fusion-li-item-content">
                <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
                  <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
                </span>

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
                <div class="fusion-li-item-content">
                  <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
                    <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
                  </span>

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
                <div class="fusion-li-item-content">
                  <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
                    <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
                  </span>


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
              <div class="fusion-li-item-content">
                <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
                  <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
                </span>
                <span><?php echo $meta['customization_location']; ?></span>
              </div>
            </li>
          <?php endif; ?>
          <?php if (isset($meta['customization_date_production'])): ?>
            <li class="fusion-li-item">
              <div class="fusion-li-item-content">
                <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
                  <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
                </span>

                <span>Production Time</span> - <?php echo $meta['customization_date_production']; ?>
              </div>
            </li>
          <?php endif; ?>
          <?php if (isset($meta['customization_date_shipping'])): ?>
            <li class="fusion-li-item">
              <div class="fusion-li-item-content">
                <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
                  <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
                </span>
                <span>Shipping Time</span> - <?php echo $meta['customization_date_shipping']; ?>
              </div>
            </li>
          <?php endif; ?>
          <?php if (isset($meta['guaranteed_delivery'])): ?>
            <li class="fusion-li-item">
              <div class="fusion-li-item-content">
                <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
                  <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
                </span>

                <span>Guaranteed delivery</span> - <?php echo $meta['guaranteed_delivery']; ?>
              </div>
            </li>
          <?php endif; ?>
        </ul>
        </div>
    <?php
      }
    }
}





  //remove_action( 'woocommerce_view_order', 'avada_woocommerce_view_order', 10 );

  //remove_action( 'woocommerce_view_order', 'avada_woocommerce_view_order', 10 );
 // add_action( 'woocommerce_view_order', 'Customize_avada_woocommerce_view_order', 10 );

  remove_action( 'woocommerce_thankyou', 'avada_woocommerce_view_order', 10 );
  add_action( 'woocommerce_thankyou', 'Customize_avada_woocommerce_view_order', 10 );
  function Customize_avada_woocommerce_view_order( $order_id ) {
    global $woocommerce;

    $order = new WC_Order( $order_id );

    ?>
    <div class="avada-order-details woocommerce-content-box full-width">
      <h2><?php _e( 'Order Details', 'woocommerce' ); ?></h2>
      <table class="shop_table order_details">
        <thead>
        <tr>
          <th class="product-details"><?php _e( 'Wristband Details', 'woocommerce' ); ?></th>
          <th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
          <th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
        </tr>
        </thead>
        <tfoot>
        <?php
          if ( $totals = $order->get_order_item_totals() ) {
            foreach ( $totals as $total ) :
              ?>
              <tr>
                <td class="filler-td">&nbsp;</td>
                <th scope="row"><?php echo $total['label']; ?></th>
                <td class="product-total"><?php echo $total['value']; ?></td>
              </tr>
            <?php
            endforeach;
          }
        ?>
        </tfoot>
        <tbody>
        <?php
          if ( sizeof( $order->get_items() ) > 0 ) {

            foreach ( $order->get_items() as $item ) {
              $_product  = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
              $item_meta = new WC_Order_Item_Meta( $item['item_meta'] );
              ?>
              <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
                <td class="product-name">
                  <table><tr>
                    <td>
                      <div class="product-details">
                        <table><tr>
                            <td>
                              <span class="product-thumbnail">
                                <?php
                                  $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image() );

                                  if ( ! $_product->is_visible() ) {
                                    echo $thumbnail;
                                  } else {
                                    printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );
                                  }
                                ?>
                              </span>
                            </td><td>
                                <?php
                                  if ( $_product && ! $_product->is_visible() ) {
                                    echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item );
                                  } else {
                                    echo apply_filters( 'woocommerce_order_item_name', sprintf( '<a href="%s">%s</a>', get_permalink( $item['product_id'] ), $item['name'] ), $item );
                                  }

                                  // Meta data
                                  do_action( 'woocommerce_order_item_meta_start', $item['product_id'], $item, $order );
                                  $order->display_item_meta( $item );
                                  $order->display_item_downloads( $item );
                                  do_action( 'woocommerce_order_item_meta_end', $item['product_id'], $item, $order );
                                ?>
                          </td>
                        </tr></table>
                      </div>
                    </td>
                    <td style="width: 30px;">&nbsp;</td>
                    <td>

                      <div>
                      <?php 
                        foreach ($item_meta as $key => $value) {
                          if($key == 'meta'){
                            $meta = unserialize($value['wristband_meta'][0]);
                      ?>
                            <label class="t-heading"><?php echo $_product->get_title() . ' - ' . (isset($meta['size']) ? $meta['size'] : '') . ' Inch.'; ?></label>
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
                      <?php
                          }
                        }
                      ?>
                      </div>  
                  </td>
                  </tr></table>
                </td>
                <td class="product-quantity">
                  <?php echo apply_filters( 'woocommerce_order_item_quantity_html', $item['qty'], $item ); ?>
                </td>
                <td class="product-total">
                  <?php echo $order->get_formatted_line_subtotal( $item ); ?>
                </td>
              </tr>
              <?php

              if ( in_array( $order->status, array(
                    'processing',
                    'completed'
                  ) ) && ( $purchase_note = get_post_meta( $_product->id, '_purchase_note', true ) )
              ) {
                ?>
                <tr class="product-purchase-note">
                  <td colspan="3"><?php echo apply_filters( 'the_content', $purchase_note ); ?></td>
                </tr>
              <?php
              }
            }
          }

          do_action( 'woocommerce_order_items_table', $order );
        ?>
        </tbody>
      </table>
      <?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
    </div>

    <div class="avada-customer-details woocommerce-content-box full-width">
      <header>
        <h2><?php _e( 'Customer details', 'woocommerce' ); ?></h2>
      </header>
      <dl class="customer_details">
        <?php
          if ( $order->billing_email ) {
            echo '<dt>' . __( 'Email:', 'woocommerce' ) . '</dt> <dd>' . $order->billing_email . '</dd><br />';
          }
          if ( $order->billing_phone ) {
            echo '<dt>' . __( 'Telephone:', 'woocommerce' ) . '</dt> <dd>' . $order->billing_phone . '</dd>';
          }

          // Additional customer details hook
          do_action( 'woocommerce_order_details_after_customer_details', $order );
        ?>
      </dl>

      <?php if (get_option( 'woocommerce_ship_to_billing_address_only' ) === 'no' && get_option( 'woocommerce_calc_shipping' ) !== 'no') : ?>

      <div class="col2-set addresses">

        <div class="col-1">

          <?php endif; ?>

          <header class="title">
            <h3><?php _e( 'Billing Address', 'woocommerce' ); ?></h3>
          </header>
          <address><p>
              <?php
                if ( ! $order->get_formatted_billing_address() ) {
                  _e( 'N/A', 'woocommerce' );
                } else {
                  echo $order->get_formatted_billing_address();
                }
              ?>
            </p></address>

          <?php if (get_option( 'woocommerce_ship_to_billing_address_only' ) === 'no' && get_option( 'woocommerce_calc_shipping' ) !== 'no') : ?>

        </div>
        <!-- /.col-1 -->

        <div class="col-2">

          <header class="title">
            <h3><?php _e( 'Shipping Address', 'woocommerce' ); ?></h3>
          </header>
          <address><p>
              <?php
                if ( ! $order->get_formatted_shipping_address() ) {
                  _e( 'N/A', 'woocommerce' );
                } else {
                  echo $order->get_formatted_shipping_address();
                }
              ?>
            </p></address>
        </div>
        <!-- /.col-2 -->
      </div>
      <!-- /.col2-set -->
    <?php endif; ?>

      <div class="clear"></div>

    </div>

  <?php
  }










/*

function order_completed( $order_id ) {
    $order = new WC_Order( $order_id );
    $to_email = $order["billing_address"];
    $headers = 'From: Your Name <your@email.com>' . "\r\n";
    wp_mail($to_email, 'subject', 'message', $headers );
}
add_action( 'woocommerce_payment_complete', 'order_completed' );

*/



