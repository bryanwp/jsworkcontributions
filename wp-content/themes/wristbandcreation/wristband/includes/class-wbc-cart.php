<?php


if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Cart')) {
    class WBC_Cart {

        public function __construct() {
            add_action('wp_ajax_wbc_add_to_cart', array($this, 'wbc_ajax_add_to_cart'));
            add_action('wp_ajax_nopriv_wbc_add_to_cart', array($this, 'wbc_ajax_add_to_cart'));

            add_action('wp_ajax_nopriv_wbc_ajax_edit_to_cart', array($this, 'wbc_ajax_edit_to_cart'));

            //Store the custom field
            add_filter( 'woocommerce_add_cart_item_data', array($this, 'add_cart_item_custom_data_vase'), 10, 2 );

            add_filter( 'woocommerce_get_cart_item_from_session', array($this, 'get_cart_items_from_session'), 1, 3 );
            add_action( 'woocommerce_before_calculate_totals', array($this, 'add_custom_total_price'));
        }



        function check_already_in_cart( $product_id ) {
            global $woocommerce;

            foreach ( $woocommerce->cart->get_cart() as $key => $value ) {
                if ( $product_id == $value['data']->id ) {
                    return true;
                }
            }
            return false;
        }




        function wbc_ajax_add_to_cart() {

            if ($_POST && isset($_POST['meta'])) {
                global $woocommerce;

                $meta = $_POST['meta']; // json_decode( str_replace("\\", "", $_POST['meta'] ), true);

                //if ( $this->check_already_in_cart( $meta['product'] ) ) {
                //    wp_send_json_error(array( 'message' => 'Already added to cart.'));
                //} else {
                    $result = $woocommerce->cart->add_to_cart($meta['product']);
                    if ($result) {
                        wp_send_json_success(array('message' => 'Successfully added to cart.'));
                    } else {
                        //wp_send_json_error(array( 'message' => $result));
                        wp_send_json_error(array( 'message' => 'Already added to cart.'));
                    }
               // }

            }

        }


        function wbc_ajax_edit_to_cart() {

            if ($_POST && isset($_POST['meta'])) {
                global $woocommerce;
               // $meta = json_decode( str_replace("\\", "", $_POST['meta'] ), true);
                $UpdateID = $_POST["UpdateID"];

                $updateStat = true;

               unset($woocommerce->cart->get_cart()[$UpdateID]);

      
    
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
       

                    if ($cart_item_key == $UpdateID){
                      ///  unset($cart_item['wristband_meta']);
       
                        //$sss = "<prev>".$cart_item['wristband_meta']."</prev><br><br><prev>".$meta['product']."</prev>";
                        break;
                    }
                }
        

        //        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {



      //  $meta = isset($cart_item['wristband_meta']) ? $cart_item['wristband_meta'] : array();
      //  $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
      //  $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

      //  if ($cart_item_key == $TempID){

wp_send_json_error(array( 'message' => $sss));



                //if ( $this->check_already_in_cart( $meta['product'] ) ) {
                //    wp_send_json_error(array( 'message' => 'Already added to cart.'));
                //} else {
                //    $result = $woocommerce->cart->add_to_cart($meta['product']);
                //    if ($result) {
                //        wp_send_json_success(array('message' => 'Successfully added to cart.'));
                //    } else {
                        //wp_send_json_error(array( 'message' => $result));
                //        wp_send_json_error(array( 'message' => 'Already added to cart.'));
                //    }
               // }

            }




        }





        function add_cart_item_custom_data_vase( $cart_item_meta, $product_id ) {
            global $woocommerce;

            if (isset($_POST['meta'])) {
                $cart_item_meta['wristband_meta'] = $_POST['meta']; // json_decode(str_replace("\\", "", $_POST['meta']), true);
            }
            return $cart_item_meta;
        }

        //Get it from the session and add it to the cart variable
        function get_cart_items_from_session( $item, $values, $key ) {
            if ( array_key_exists( 'wristband_meta', $values ) )
                $item[ 'wristband_meta' ] = $values['wristband_meta'];
            return $item;
        }

        function add_custom_total_price( $cart_object ) {
            global $woocommerce;

            foreach ( $cart_object->cart_contents as $key => $value ) {

                if (isset($value['wristband_meta']['total_price'])) {
                    $value['data']->price = $value['wristband_meta']['total_price'];
                }
            }
        }

    }
}

new WBC_Cart();