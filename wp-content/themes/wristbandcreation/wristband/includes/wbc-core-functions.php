<?php
if (!defined('ABSPATH')) {
    exit;
}


if (!function_exists('generate_uniqid')) {
    /**
     * generate_uniqid
     * Generate md5 but limit to specific length
     *
     * @param $string
     * @param int $length
     * @return string
     */
    function generate_uniqid($string, $length = 13) {
        return substr(md5($string), 0, $length);
    }
}


if (!function_exists('sanitize_title_with_underscore')) {

    /**
     * acf_name_endcode()
     * convert string to lower cause and replace space to underscore
     *
     * @param $string
     * @return mixed
     */
    function sanitize_title_with_underscore($string)
    {
        return str_replace('-', '_', sanitize_title_with_dashes(str_replace('/', '_', $string)));
    }
}


if (!function_exists('wbc_nf')) {
    function wbc_nf($number, $dec = 2, $dp = '.', $ts = ', ', $echo = true) {
        $new_number =  number_format($number, $dec, $dp, $ts);

        if (!$echo)
            return $new_number;

        echo $new_number;
    }
}

if (!function_exists('wbc_post_image')) {

    function wbc_post_image ($post_id = null, $size = 'medium', $attr = array(), $echo = true)
    {
        $html = '';
        if (has_post_thumbnail($post_id)) {
            $html = wp_get_attachment_image(get_post_thumbnail_id($post_id), $size);
        } else {

            $html .= '<img src"' . WBC_ASSETS_URL . '/images/hero.jpg"';
            if (is_array($attr) && count($attr) != 0) {
                foreach ($attr as $name => $value) {
                    $html .= " $name=" . '"' . $value . '"';
                }
            }

            $html .= '/>';
        }

        if (!$echo) {
            return $html;
        }

        echo $html;

    }
}


//add_action('wp_ajax_priv_blueimp-fileupload', 'wbc_blueimp_uploadhandler');
//add_action('wp_ajax_nopriv_blueimp-fileupload', 'wbc_blueimp_uploadhandler');



add_action('init', 'wbc_clipart_uploadhandler');

if (!function_exists('wbc_clipart_uploadhandler')) {
    function wbc_clipart_uploadhandler() {

        if (isset($_POST['action']) && $_POST['action'] == 'clipart-fileupload') {

            include_once('lib/UploadHandler.php');
            include_once('class-wbc-uploadhandler.php');



            $wbc_uploadhandler = new WBC_UploadHandler();
            die;
        }
    }
}

add_action('init', 'wbc_clipart_delete_file');

if (!function_exists('wbc_clipart_delete_file')) {
    function wbc_clipart_delete_file() {
        if (isset($_GET['action']) && $_GET['action'] == 'delete_clipart') {

            include_once('lib/UploadHandler.php');
            include_once('class-wbc-uploadhandler.php');

            $wbc_uploadhandler = new WBC_UploadHandler();
        }
    }
}





/**
 * Woocommerce hooks
 */
add_action('init', 'wc_custom_remove_action');
add_action('init', 'wc_custom_add_action');
if (!function_exists('wc_custom_remove_action')) {
    function wc_custom_remove_action()
    {
        //woocommerce_single_product_summary
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        //woocommerce_after_single_product_summary
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
//        remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 10);
//        remove_action( 'woocommerce_after_single_product_summary', 'avada_woocommerce_upsell_display', 10 );
//        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
//        remove_action('woocommerce_after_single_product_summary', 'avada_woocommerce_output_related_products', 15);
    }
}


if (!function_exists('wc_custom_add_action')) {
    function wc_custom_add_action() {
        add_action('woocommerce_single_product_summary', 'wc_template_single_content', 20);
        add_action('woocommerce_single_product_summary', 'wc_template_single_pricing_chart', 21);
        add_action('woocommerce_single_product_summary', 'wc_template_single_customize_now', 30);
        add_action('woocommerce_single_product_summary', 'wc_template_single_content_boxes', 30);
    }
}


if (!function_exists('wc_template_single_content')) {
    function wc_template_single_content()
    {
        the_content();
    }
}

if (!function_exists('wc_template_single_customize_now')) {
    function wc_template_single_customize_now() {
        echo '<div style="display:block;margin-top:3em;"><a href="'. site_url('/') .'order-now" class="fusion-button button-flat button-round button-medium button-default alt">Customize Now</a></div>';
    }
}

if (!function_exists('wc_template_single_pricing_chart')) {
    function wc_template_single_pricing_chart() {
        global $post;


        $sizes = isset($GLOBALS['wbc_settings']->products->{$post->ID}->sizes) ? $GLOBALS['wbc_settings']->products->{$post->ID}->sizes : array();


        if (count($sizes) > 0) {

            echo '<div class="woocommerce-tabs wc-tabs-wrapper">';

            echo '<div class="tabs wc-tabs">';
            $flag = false;
            foreach ($sizes as $k => $size) {
                $target = sanitize_title_with_underscore($k);
                echo '<li class="'.(!$flag ? 'active': '').'"><a href="#tab-'. $target .'" data-toggle="tab">'. $k .'</a></li>';
                $flag = true;
            }
            echo '</div><!-- /.nav-tabs -->';

            $flag = false;
            foreach ($sizes as $k => $size) {
                $target = sanitize_title_with_underscore($k);
                echo '<div class="panel entry-content wc-tab"  style="width: 100%;display:'.(!$flag ? 'block': 'none').'" id="tab-'. $target .'">';

                if (isset($size->price_chart) && count($size->price_chart) > 0) {
                    echo '<table class="table">';
                    echo '<tr><th>Quantity</th><th>Free</th><th>Regular Price</th><th>Sale Price</th></tr>';
                    foreach ($size->price_chart as $qty => $price) {
                        echo '<tr><td>'. wbc_nf($qty, 0,'.', ', ', false) .'</td><td></td><td>'. get_woocommerce_currency_symbol().wbc_nf($price, 2,'.', ', ', false) .'</td><td></td></tr>';
                    }

                    echo '</table>';
                }

                echo '</div><!-- /.tab-pane -->';
                $flag = true;
            }



            echo '</div><!-- /.fusion-tabs -->';
        }

    }
}


if (!function_exists('wc_template_single_content_boxes')) {
    function wc_template_single_content_boxes() {
        echo '<div class="fusion-content-boxes content-boxes columns fusion-columns-4 fusion-content-boxes-2 content-boxes-icon-on-top row content-" style="margin-top: 5em;">';

        echo '<div class="fusion-column content-box-column content-box-column-1 col-lg-4 col-md-4 col-sm-4 fusion-content-box-hover content-box-column-first-in-row">';

        echo '<div class="col content-wrapper link-area-link-icon link-type-text icon-hover-animation-fade">';

        echo '<div class="heading heading-with-icon">';

        echo '<div class="icon">';

        echo '<i style="border-color:#333333;border-width:1px;background-color:#fff;height:70px;width:70px;line-height:70px;border-radius:100%;color:#333333;font-size:35px;" class="fa fontawesome-icon fa-circle-o circle-yes"></i>';

        echo '</div>';

        echo '<h2 class="content-box-heading" style="font-size: 18px; line-height: 20px;" data-inline-fontsize="true" data-inline-lineheight="true" data-fontsize="18" data-lineheight="20">100 Free Wristbands</h2>';

        echo '</div><!-- /.heading -->';

        echo '</div><!-- /.content-wrapper -->';

        echo '</div><!--/.fusion-column -->';


        echo '<div class="fusion-column content-box-column content-box-column-1 col-lg-4 col-md-4 col-sm-4 fusion-content-box-hover">';

        echo '<div class="col content-wrapper link-area-link-icon link-type-text icon-hover-animation-fade">';

        echo '<div class="heading heading-with-icon">';

        echo '<div class="icon">';

        echo '<i style="border-color:#333333;border-width:1px;background-color:#fff;height:70px;width:70px;line-height:70px;border-radius:100%;color:#333333;font-size:35px;" class="fa fontawesome-icon fa-money circle-yes"></i>';

        echo '</div>';

        echo '<h2 class="content-box-heading" style="font-size: 18px; line-height: 20px;" data-inline-fontsize="true" data-inline-lineheight="true" data-fontsize="18" data-lineheight="20">Pricematch Guarantee</h2>';

        echo '</div><!-- /.heading -->';

        echo '</div><!-- /.content-wrapper -->';

        echo '</div><!--/.fusion-column -->';



        echo '<div class="fusion-column content-box-column content-box-column-1 col-lg-4 col-md-4 col-sm-4 fusion-content-box-hover">';

        echo '<div class="col content-wrapper link-area-link-icon link-type-text icon-hover-animation-fade">';

        echo '<div class="heading heading-with-icon">';

        echo '<div class="icon">';

        echo '<i style="border-color:#333333;border-width:1px;background-color:#fff;height:70px;width:70px;line-height:70px;border-radius:100%;color:#333333;font-size:35px;" class="fa fontawesome-icon fa-calendar circle-yes"></i>';

        echo '</div>';

        echo '<h2 class="content-box-heading" style="font-size: 18px; line-height: 20px;" data-inline-fontsize="true" data-inline-lineheight="true" data-fontsize="18" data-lineheight="20">Get Your Wristbands in 3 Days</h2>';

        echo '</div><!-- /.heading -->';

        echo '</div><!-- /.content-wrapper -->';

        echo '</div><!--/.fusion-column -->';

        echo '</div><!-- /.fusion-content-boxes -->';
    }
}




