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

            add_action('wp_ajax_nopriv_send_save_design', array($this, 'send_save_design'));

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
                        wp_send_json_error(array( 'message' => 'Already added to cart.'));
                    }
               // }

            }

        }
        
        function wbc_ajax_edit_to_cart() {

            if ($_POST && isset($_POST['meta']) && isset($_POST['UpdateID'])) {
                global $woocommerce;

                $UpdateID = $_POST["UpdateID"];
                $meta = $_POST['meta'];

                $retVal = $woocommerce->cart->remove_cart_item( $UpdateID );
                if($retVal)
                {
                    $result = $woocommerce->cart->add_to_cart($meta['product']);
                    if ($result) {
                        wp_send_json_success(array('message' => 'Successfully updated cart.'));
                    } else {
                        wp_send_json_error(array( 'message' => 'Already added to cart.'));
                    }
                }
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

        function send_save_design()
        {
            if ( $_POST && isset($_POST['meta']) )
            {
                $link = get_site_url().'/order-now/?id='.custom_encrypt_decrypt( 'encrypt', json_encode($_POST['meta']) ).'&Status=design';
                $title = $_POST['meta']['title'].' - '.$_POST['meta']['size'];

                add_filter( 'wp_mail_content_type', 'set_html_content_type' );
                
                $result = wp_mail( $_POST['meta']['email'], 'Save Design at WristbandCreation.Com', '<h1>'.$title.'</h1><a href="'.$link.'" target="_blank">View Design</a>' );
                if ($result) {
                    wp_send_json_success(array('message' => 'Successfully saved design to your email.'));
                } else {
                    wp_send_json_error(array( 'message' => 'There was an error while sending your design.'));
                }
            }
        }

    }
}

new WBC_Cart();