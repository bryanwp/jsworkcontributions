<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Shortcodes')) {
    class WBC_Shortcodes
    {

        public function __construct()
        {
            add_shortcode('wc-product-price', array($this, 'render_wc_product_price'), 10, 1);
        }

        public function render_wc_product_price($atts)
        {
            extract(shortcode_atts(array(
                'id' => '',
            ), $atts, 'wc-product-price'));

            $arr_ids = explode(',', $id);

            ob_start();

            include_once('views/html-wc-product-price.php');

            return ob_get_clean();
        }

    }

}

new WBC_Shortcodes();
