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



