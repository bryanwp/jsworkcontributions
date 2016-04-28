<?php
function home_script() {
      wp_enqueue_script( 'mod-home-script', get_stylesheet_directory_uri() . '/wristband/assets/js/home-script.js', '', false);
}
add_action( 'wp_enqueue_scripts', 'home_script' );

function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-stylesheet', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'custom-css', get_stylesheet_directory_uri() . '/responsive.css' );

    //for the phase two tasks
   if ( is_page('login') or is_page('register') or is_page('supplier-dashboard') or is_page('employee-dashboard') or is_page('customer-dashboard') or is_page('forgot-password') or is_page('admin-dashboard') ) {
        wp_enqueue_style( 'shedz-css', get_stylesheet_directory_uri() . '/wristband/assets/css/sheldz.css' );
        wp_enqueue_style( 'kram-css', get_stylesheet_directory_uri() . '/wristband/assets/css/kram.css' );

        wp_enqueue_script('sheldz-js', get_stylesheet_directory_uri() . '/wristband/assets/js/sheldz.js', array( 'jquery' ), false, true);
        wp_enqueue_script('justin-js', get_stylesheet_directory_uri() . '/wristband/assets/js/justin.js', array( 'jquery' ), false, true);
        wp_enqueue_script('timeago-js', get_stylesheet_directory_uri() . '/wristband/assets/js/timeago.js', array( 'jquery' ), false, true);
        wp_enqueue_script('plugins-js', get_stylesheet_directory_uri() . '/wristband/assets/js/plugins.js', array( 'jquery' ), false, true);

        wp_enqueue_media();
        wp_enqueue_script('wp-media-js', get_stylesheet_directory_uri() . '/wristband/assets/js/wp-media.js', array( 'jquery' ), false, true);
        
        wp_localize_script('sheldz-js', 'sheldz_ajax', array( 
        'ajaxUrl' => admin_url('admin-ajax.php')
        ));
        wp_localize_script('justin-js', 'justin_ajax', array( 
        'ajaxUrl' => admin_url('admin-ajax.php')
        ));
        wp_localize_script('plugins-js', 'plugins_ajax', array( 
        'ajaxUrl' => admin_url('admin-ajax.php')
        ));
      }

    wp_register_style('list_of_icons', get_stylesheet_directory_uri() . '/wristband/assets/css/list-icons.css', array());
    wp_enqueue_style('list_of_icons');

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function admin_enqueue_styles() {
    wp_enqueue_style( 'admin-stylesheet', get_stylesheet_directory_uri() . '/admin-style.css' );

}
add_action( 'admin_init', 'admin_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );



// Add My Custom Functions File 
include_once( get_stylesheet_directory() . '/templates/inc/sheldz_function.php' );
include_once( get_stylesheet_directory() . '/templates/jus_functions.php' );

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
          <?php display_order_summary($_product, $meta); ?>
        </div>
    <?php
      }
    }
}



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
          foreach ( $totals as $total ) : if($total['label'] == 'Shipping:') continue;
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
                          display_order_summary($_product, $meta);
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


add_action( 'woocommerce_view_order', 'Customize_avada_woocommerce_view_order_My_Account', 11 );
function Customize_avada_woocommerce_view_order_My_Account( $order_id ) {
  global $woocommerce;

  $order = new WC_Order( $order_id );

  ?>
  <div class="avada-order-details woocommerce-content-box full-width">
    <h2><?php _e( 'Order Details', 'woocommerce' ); ?></h2>
    <table class="shop_table order_details">
      <thead>
      <tr>
        <th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
        <th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
        <th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
      </tr>
      </thead>
      <tfoot>
      <?php
        if ( $totals = $order->get_order_item_totals() ) {
          foreach ( $totals as $total ) : if($total['label'] == 'Shipping:') continue;
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
                <table>
                  <tr>
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

                      <div class="product-info">
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
                      </div>
                    </td>
                    <td style="width: 30px;">&nbsp;</td>
                    <td>
                      <?php 
                        foreach ($item_meta as $key => $value) {
                          if($key == 'meta'){
                            $meta = unserialize($value['wristband_meta'][0]);
                            display_order_summary($_product, $meta);
                          }
                        }
                      ?>
                    </td>
                  </tr>
                </table>
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

function init_actions()
{
  remove_action( 'woocommerce_thankyou', 'avada_woocommerce_view_order', 10 );
  remove_action( 'woocommerce_view_order', 'avada_woocommerce_view_order', 10 );
}
add_action('init','init_actions');


function display_order_summary($_product, $meta)
{
  ?>
  <!-- SOL : View Product Summary Details -->
    <!-- <label class="t-heading CssTitleBlack CssTitleBold"><?php echo $_product->get_title() . ' - ' . (isset($meta['size']) ? $meta['size'] : '') . ' Inch'; ?></label> -->
    <label class="t-heading"><?php echo 'Wristband Width: ' . (isset($meta['size']) ? $meta['size'] : '') . ' Inch'; ?></label>
    <?php if (isset($meta['colors'])): ?>
      <ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
      <label class="CssTitleBlack CssTitleBold">Quantity and Colors:</label>
        <?php 
          $free_colors = $meta['free_colors'];
          foreach ($meta['colors'] as $pk => $color): if (!isset($color['name']) || empty($color['name'])) continue; 
        ?>
<!-- Quantity and Colors:
500 Lime Green & White Segmented (+84 free) | Adult Size
100 Blue, Red & Pink Segmented (+16 free) | Medium Size
 -->
          <li class="fusion-li-item">
              <!-- <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
                <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
              </span> -->

            <div class="fusion-li-item-content">
              <!-- <span><?php //var_dump($color); echo $color['name']; ?></span> – <?php //echo $color['type']; ?> <em><?php// echo $color['color']; ?> -->
                </em>
            </div>

            <?php if (isset($color['sizes']) && count($color['sizes']) != 0): ?>
              <ul class="fusion-checklist-2 fusion-checklist-1"
                style="font-size:12px;line-height:22.1px;">
                <?php if (isset($color['text_color_name'])): ?>
                  <!-- <li class="fusion-li-item"> -->
                    <!-- <div class="fusion-li-item-content"> -->
                      <!-- <span>Text Color: <?php// echo $color['text_color_name'] . ' – <em>' . $color['text_color'] . '</em>'; ?></span> -->
                    <!-- </div> -->
                  <!-- </li> -->
                <?php
                 endif; ?>
                <?php foreach ($color['sizes'] as $k => $qty): if ($qty <= 0) continue; ?>
                  <li class="fusion-li-item nobullet">
                    <div class="fusion-li-item-content">
                      <span><?php //echo ucfirst($k) . ' – <em>' . $qty . ($free_colors[$pk]['free'][$k] ? (' + ' . $free_colors[$pk]['free'][$k]) : '') . '</em>'; ?>
                      <?php echo $qty.' '.$color['name'].' '.$color['type'].' '.($free_colors[$pk]['free'][$k] ? ('(+' . $free_colors[$pk]['free'][$k]).')' : '').' | '.ucfirst($k).' Size';?>
                      </span>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <?php if( (!empty($meta['font']) && $meta['font'] != '-1') || !empty($meta['messages']['Front Message']) || !empty($meta['messages']['Back Message']) || !empty($meta['messages']['Inside Message']) || !empty($meta['messages']['Continuous Message']) || !empty($meta['messages']['Additional Notes']) ): ?>
      <label class="CssTitleBlack CssTitleBold">Text on Wristbands: </label>
      <ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
        <?php if (!isset($meta['font']) || $meta['font'] != '-1'): ?>
          <li class="fusion-li-item">
            <!-- <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
              <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
            </span> -->
            <div class="fusion-li-item-content">
              <span>Font Style</span>: <?php echo $meta['font']; ?>
            </div>
          </li>
        <?php endif; ?>
        <?php if (isset($meta['messages'])): foreach ($meta['messages'] as $label => $val): if (empty($val)) continue; ?>
          <li class="fusion-li-item">
            <!-- <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
              <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
            </span> -->
            <div class="fusion-li-item-content">
              <span><?php echo $label; ?></span>: <?php echo $val; ?>
            </div>
          </li>
        <?php endforeach; endif; ?>
      </ul>
    <?php endif; ?>
    <?php if (!empty($meta['clipart']['back_end']) || !empty($meta['clipart']['back_end']) || !empty($meta['clipart']['back_start']) || !empty($meta['clipart']['front_end']) || !empty($meta['clipart']['front_start']) || !empty($meta['clipart']['wrap_end']) || !empty($meta['clipart']['wrap_start']) ): ?>
      <label class="CssTitleBlack CssTitleBold">Clipart: </label>
      <ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
        <?php foreach ($meta['clipart'] as $k => $clipart): if (empty($clipart) || $k == 'view_position' || $k == 'wristband_stat') continue;?>
          <li class="fusion-li-item">
            <!-- <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
              <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
            </span> -->
            <div class="fusion-li-item-content">
              <span><?php $position = ucfirst(str_replace('_', ' ', $k));
               echo $position; ?></span>:<?php if (preg_match('/(\.jpg|\.png|\.bmp)$/', $clipart)){ ?>
                <img
                  src="<?php echo wp_upload_dir()['baseurl'] . '/clipart/' . $clipart; ?>"
                  alt="" width="16px" height="16px">
              <?php } else {
                    $hasFa = strpos($clipart,'fa-');
                    if($hasFa === false){
                      //echo "11111111111111111111";
                      ?>

                      <i class="<?php echo $clipart; ?>"></i>
                      <em><?php echo $meta['clipartname'][$k.'_name']; ?></em>
                      <?php
                    }else{
                      //echo "2222222222222222222";
                  ?> 
                    <i class="fa <?php echo $clipart; ?>"></i>
                    <em><?php echo $meta['clipartname'][$k.'_name']; ?></em>
              <?php }} ?>
              <!-- (<em><?php echo $clipart; ?></em>) -->
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <?php if (isset($meta['additional_options']) && count($meta['additional_options']) > 0): ?>
      <label class="CssTitleBlack CssTitleBold">Additional Options: </label>
      <ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
        <?php foreach ($meta['additional_options'] as $k => $option): ?>
          <li class="fusion-li-item">
           <!--  <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
              <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
            </span> -->
            <div class="fusion-li-item-content">
              <span><?php echo $option; ?></span>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <label class="CssTitleBlack CssTitleBold">Production and Shipping: </label>
    <ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
      <?php if (isset($meta['customization_location'])): ?>
        <li class="fusion-li-item">
          <!-- <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
              <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
            </span> -->

          <div class="fusion-li-item-content">
            <span><?php echo $meta['customization_location']; ?></span>
          </div>
        </li>
      <?php endif; ?>
      <?php if (isset($meta['customization_date_production'])): ?>
        <li class="fusion-li-item">
<!--           <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
              <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
            </span> -->

          <div class="fusion-li-item-content">
            <span>Production Time</span>: <?php echo $meta['customization_date_production']; ?>
          </div>
        </li>
      <?php endif; ?>
      <?php if (isset($meta['customization_date_shipping'])): ?>
        <li class="fusion-li-item">
          <!-- <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
              <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
            </span> -->

          <div class="fusion-li-item-content">
            <span>Shipping Time</span>: <?php echo $meta['customization_date_shipping']; ?>
          </div>
        </li>
      <?php endif; ?>
      <?php if (isset($meta['guaranteed_delivery'])): ?>
        <li class="fusion-li-item">
          <!-- <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
              <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
            </span> -->

          <div class="fusion-li-item-content">
            <span>Guaranteed to arrive on </span><?php echo $meta['guaranteed_delivery']; ?>
          </div>
        </li>
      <?php endif; ?>
    </ul>
    <!-- EOL : View Product Summary Details -->
  <?php
}
/*
function display_order_production_summary($_product, $meta){ ?>
  <div class="production-details">
    <label class="CssTitleBlack CssTitleBold">Production and Shipping</label>
    <ul class="fusion-checklist fusion-checklist-1" style="font-size:12px;line-height:22.1px;">
      <?php if (isset($meta['customization_location'])): ?>
        <li class="fusion-li-item">
          <!-- <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
              <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
            </span> -->

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
          <!-- <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
              <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
            </span> -->

          <div class="fusion-li-item-content">
            <span>Shipping Time</span> - <?php echo $meta['customization_date_shipping']; ?>
          </div>
        </li>
      <?php endif; ?>
      <?php if (isset($meta['guaranteed_delivery'])): ?>
        <li class="fusion-li-item">
          <!-- <span style="height:22.1px;margin-right:5px;" class="icon-wrapper circle-no">
              <i class="fusion-li-icon fa fa-angle-right" style="color:#333333;"></i>
            </span> -->

          <div class="fusion-li-item-content">
            <span>Guaranteed delivery</span> - <?php echo $meta['guaranteed_delivery']; ?>
          </div>
        </li>
      <?php endif; ?>
    </ul>
 </div>
<?php
}
*/
function getMetaToAutoSet($TempID, $Status)
{
  $Infos = false;
  if(array_key_exists($TempID, WC()->cart->get_cart()) && $Status == 'edit')
  {
    $cart_item_key = $TempID;
    $cart_item = WC()->cart->get_cart()[$TempID];

    $meta = isset($cart_item['wristband_meta']) ? $cart_item['wristband_meta'] : array();
    $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
    $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

    $Wrist_Style = $_product->get_title();
    $Wrist_Size = (isset($meta['size']) ? $meta['size'] : '');
  }
  elseif($Status == 'design')
  {
    $meta = json_decode(custom_encrypt_decrypt('decrypt', $TempID), true);

    $Wrist_Style = (isset($meta['title']) ? $meta['title'] : '');
    $Wrist_Size = (isset($meta['size']) ? $meta['size'] : '');
  } elseif($Status == 'copy')
  {
    $cart_item_key = $TempID;
    $cart_item = WC()->cart->get_cart()[$TempID];

    $meta = isset($cart_item['wristband_meta']) ? $cart_item['wristband_meta'] : array();
    $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
    $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

    $Wrist_Style = $_product->get_title();
    $Wrist_Size = (isset($meta['size']) ? $meta['size'] : '');
  }

  if(isset($meta['colors']))
  {
    $free_colors = $meta['free_colors'];
    foreach ($meta['colors'] as $pk => $color): 
      if (!isset($color['name']) || empty($color['name'])) continue;

        $ColorName = $color['name'];
        $ColorType = $color['type'];
        $WristColor = $color['color']; 
        $TextColorName = $color['text_color_name'];
        $TextColor = $color['text_color'];

        $adult = 0;
        $medium = 0;
        $youth = 0;
        $adult_free = 0;
        $medium_free = 0;
        $youth_free = 0;

        foreach ($color['sizes'] as $k => $qty): if ($qty <= 0) continue; 
           if ($k == "adult"){ $adult = $qty; } 
           elseif ($k == "medium"){ $medium = $qty;} 
           else { $youth = $qty; }
        endforeach;

        if(isset($meta['free_colors']))
        {
          foreach ($free_colors[$pk]['free'] as $k => $qty): if ($qty <= 0) continue; 
             if ($k == "adult"){ $adult_free = $qty; } 
             elseif ($k == "medium"){ $medium_free = $qty;} 
             else { $youth_free = $qty; }
          endforeach;
        }


        if ($MultiAdd == ""){ $MultiAdd = $ColorName."^".$ColorType."^".$WristColor."^".$TextColorName."^".$TextColor."^".$adult."^".$medium."^".$youth."^".$adult_free."^".$medium_free."^".$youth_free;
        } else { $MultiAdd = $MultiAdd."~".$ColorName."^".$ColorType."^".$WristColor."^".$TextColorName."^".$TextColor."^".$adult."^".$medium."^".$youth."^".$adult_free."^".$medium_free."^".$youth_free; }
        $Infos['FontStyle'] =  $meta['font'];

        if(isset($meta['messages']))
        {
          foreach ($meta['messages'] as $label => $val): if (empty($val)) continue;
              if ($label == "Front Message"){ $Infos['Front_msg'] = $val; }
              elseif ($label == "Back Message"){ $Infos['Back_msg'] = $val; }
              elseif ($label == "Continuous Message"){ $Infos['Wrap_msg'] = $val; }
              elseif ($label == "Inside Message"){ $Infos['Inside_msg'] = $val; }
              elseif ($label == "Additional Notes"){ $Infos['AddNotes_msg'] = $val; }
          endforeach;
        }

        if(isset($meta['additional_options']))
        {
            foreach ($meta['additional_options'] as $k => $option):
                if ($k == "0"){ $InPackaging = $option; }
                elseif ($k == "1"){ $Eco = $option; }
                elseif ($k == "2"){ $Thick = $option; }
                else { $DigitalPro = $option; }
            endforeach;
        }

        if(isset($meta['clipart']))
        {
          foreach ($meta['clipart'] as $k => $clipart): if (empty($clipart)) continue;
              if ($k == "front_start"){ $front_start = $clipart; }
              elseif ($k == "front_end"){ $front_end = $clipart; }
              elseif ($k == "back_start"){ $back_start = $clipart; }
              elseif ($k == "back_end"){ $back_end = $clipart; }
              elseif ($k == "wrap_start"){ $wrap_start = $clipart; }
              elseif ($k == "wrap_end"){ $wrap_end = $clipart; }
              elseif ($k == "view_position"){ $view_position = $clipart; }
              else{ $wristband_stat = $clipart; }
          endforeach;
        }

        $C_location = $meta['customization_location']; 
        $C_date_prod = $meta['customization_date_production']; 
        $C_date_ship = $meta['customization_date_shipping']; 
        $guaranteed_delivery = $meta['guaranteed_delivery']; 

        $Info = $Wrist_Style."|".$Wrist_Size."|".$MultiAdd;
    endforeach;
  }
  $Infos['wristband_stat'] = $wristband_stat;
  $Infos['all'] = $Info."|".$C_location."|".$C_date_prod."|".$C_date_ship."|".$InPackaging.
            "|".$Eco."|".$Thick."|".$DigitalPro.
            "|".$front_start."|".$front_end."|".$back_start."|".$back_end."|".$view_position."|".$wristband_stat."|".$guaranteed_delivery."|".$wrap_start."|".$wrap_end;

  return $Infos;

  // old - edit cart only
  /*
  foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

        $meta = isset($cart_item['wristband_meta']) ? $cart_item['wristband_meta'] : array();
        $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

        if ($cart_item_key == $TempID)
        {
            $Edit = true;
            $Wrist_Style = $_product->get_title();
            $Wrist_Size = (isset($meta['size']) ? $meta['size'] : '');

            $free_colors = $meta['free_colors'];
            foreach ($meta['colors'] as $pk => $color): if (!isset($color['name']) || empty($color['name'])) continue;
                $ColorName = $color['name'];
                $ColorType = $color['type'];
                $WristColor = $color['color']; 
                $TextColorName = $color['text_color_name'];
                $TextColor = $color['text_color'];

                $adult = 0;
                $medium = 0;
                $youth = 0;
                $adult_free = 0;
                $medium_free = 0;
                $youth_free = 0;

                foreach ($color['sizes'] as $k => $qty): if ($qty <= 0) continue; 
                   if ($k == "adult"){ $adult = $qty; } 
                   elseif ($k == "medium"){ $medium = $qty;} 
                   else { $youth = $qty; }
                endforeach;

                foreach ($free_colors[$pk]['free'] as $k => $qty): if ($qty <= 0) continue; 
                   if ($k == "adult"){ $adult_free = $qty; } 
                   elseif ($k == "medium"){ $medium_free = $qty;} 
                   else { $youth_free = $qty; }
                endforeach;


                if ($MultiAdd == ""){ $MultiAdd = $ColorName."^".$ColorType."^".$WristColor."^".$TextColorName."^".$TextColor."^".$adult."^".$medium."^".$youth."^".$adult_free."^".$medium_free."^".$youth_free;
                } else { $MultiAdd = $MultiAdd."~".$ColorName."^".$ColorType."^".$WristColor."^".$TextColorName."^".$TextColor."^".$adult."^".$medium."^".$youth."^".$adult_free."^".$medium_free."^".$youth_free; }
                $FontStyle =  $meta['font'];

                foreach ($meta['messages'] as $label => $val): if (empty($val)) continue;
                    if ($label == "Front Message"){ $Front_msg = $val; }
                    elseif ($label == "Back Message"){ $Back_msg = $val; }
                    elseif ($label == "Continuous Message"){ $Wrap_msg = $val; }
                    elseif ($label == "Inside Message"){ $Inside_msg = $val; }
                    elseif ($label == "Additional Notes"){ $AddNotes_msg = $val; }
                endforeach;

                if(isset($meta['additional_options']))
                {
                    foreach ($meta['additional_options'] as $k => $option):
                        if ($k == "0"){ $InPackaging = $option; }
                        elseif ($k == "1"){ $Eco = $option; }
                        elseif ($k == "2"){ $Thick = $option; }
                        else { $DigitalPro = $option; }
                    endforeach;
                }

                foreach ($meta['clipart'] as $k => $clipart): if (empty($clipart)) continue;
                    if ($k == "front_start"){ $front_start = $clipart; }
                    elseif ($k == "front_end"){ $front_end = $clipart; }
                    elseif ($k == "back_start"){ $back_start = $clipart; }
                    elseif ($k == "back_end"){ $back_end = $clipart; }
                    elseif ($k == "wrap_start"){ $wrap_start = $clipart; }
                    elseif ($k == "wrap_end"){ $wrap_end = $clipart; }
                    elseif ($k == "view_position"){ $view_position = $clipart; }
                    else{ $wristband_stat = $clipart; }
                endforeach;

                $C_location = $meta['customization_location']; 
                $C_date_prod = $meta['customization_date_production']; 
                $C_date_ship = $meta['customization_date_shipping']; 
                $guaranteed_delivery = $meta['guaranteed_delivery']; 

            $Info = $Wrist_Style."|".$Wrist_Size."|".$MultiAdd;
            endforeach;
            break;
        }
    }
    $Info = $Info."|".$C_location."|".$C_date_prod."|".$C_date_ship."|".$InPackaging.
            "|".$Eco."|".$Thick."|".$DigitalPro.
            "|".$front_start."|".$front_end."|".$back_start."|".$back_end."|".$view_position."|".$wristband_stat."|".$guaranteed_delivery."|".$wrap_start."|".$wrap_end;
    if($Edit == false && $OrderStatus == 'edit')
    {
        echo '<script>window.location = "'.get_site_url().'/order-now/";</script>';
    }
    */
}

function custom_encrypt_decrypt($action, $string)
{
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'WristbandCreation V2 2015 - key';
    $secret_iv = 'WristbandCreation V2 2015 - iv';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

function set_html_content_type() {
    return 'text/html';
}


// removing action
// remove_action( 'woocommerce_cart_collaterals','woocommerce_cross_sell_display' );
// remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );﻿

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');

// rename the "Have a Coupon?" message on the checkout page
function woocommerce_rename_coupon_message_on_checkout() {
  return 'Have a Promo Code?' . ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a>';
}
add_filter( 'woocommerce_checkout_coupon_message', 'woocommerce_rename_coupon_message_on_checkout' );
// rename the coupon field on the checkout page
function woocommerce_rename_coupon_field_on_checkout( $translated_text, $text, $text_domain ) {
  // bail if not modifying frontend woocommerce text
  if ( is_admin() || 'woocommerce' !== $text_domain ) {
    return $translated_text;
  }
  if ( 'Coupon code' === $text ) {
    $translated_text = 'Promo Code';
  
  } elseif ( 'Apply Coupon' === $text ) {
    $translated_text = 'Apply Promo Code';
  }
  return $translated_text;
}
add_filter( 'gettext', 'woocommerce_rename_coupon_field_on_checkout', 10, 3 );

include_once ( get_stylesheet_directory() . '/fontstylelabel.php' );


function hide_coupon_field_on_checkout( $enabled ) {
  if ( is_checkout() ) {
    $enabled = false;
  }
  return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_checkout' );

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

add_action( 'woocommerce_after_order_notes', 'woocommerce_checkout_payment', 20 );

remove_action('woocommerce_before_checkout_form','woocommerce_checkout_login_form',1);

add_filter( 'woocommerce_checkout_fields' , 'alter_woocommerce_checkout_fields' );

function alter_woocommerce_checkout_fields( $fields ) {
     unset($fields['order']['order_comments']);
     return $fields;
}


add_action( 'woocommerce_thankyou', 'my_change_status_function' );

function my_change_status_function( $order_id ) {

    $order = new WC_Order( $order_id );
    $order->update_status( 'completed' );

}