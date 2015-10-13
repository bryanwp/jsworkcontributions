<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Front_Scripts')) {
    class WBC_Front_Scripts
    {
        public function __construct() {

            if (!is_admin()) {
                add_action('wp_enqueue_scripts', array($this, 'load_scripts'));
                add_action('wp_enqueue_scripts', array($this, 'load_styles'));
            }
        }


        public function load_scripts() {

            wp_register_script('jquery-ui-widget_js', WBC_ASSETS_URL . '/js/vendor/jquery-fileupload/vendor/jquery.ui.widget.js', array('jquery'), WBC_VERSION, true);
            wp_register_script('jquery-xdr-transport_js', WBC_ASSETS_URL . '/js/vendor/jquery-fileupload/cors/jquery.xdr-transport.js', array('jquery'), WBC_VERSION, true);
            wp_register_script('jquery-iframe-transport_js', WBC_ASSETS_URL . '/js/vendor/jquery-fileupload/jquery.iframe-transport.js', array('jquery'), WBC_VERSION, true);
            wp_register_script('jquery-fileupload_js', WBC_ASSETS_URL . '/js/vendor/jquery-fileupload/jquery.fileupload.js', array('jquery'), WBC_VERSION, true);
            wp_register_script('select2_js', WBC_ASSETS_URL . '/js/vendor/select2.min.js', array('jquery'), WBC_VERSION, true);
            wp_register_script('material_js', WBC_ASSETS_URL . '/js/vendor/material.min.js', array('jquery'), WBC_VERSION, true);
            wp_register_script('pablo_js', WBC_ASSETS_URL . '/js/vendor/pablo.js', array('jquery'), WBC_VERSION, true);
//            wp_register_script('jquery_ui_js', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js', array('jquery'), WBC_VERSION, true);
//            wp_register_script('evol_colopicker_js', WBC_ASSETS_URL . '/js/vendor/colorpicker-master/evol.colorpicker.min.js', array('jquery'), WBC_VERSION, true);
            wp_register_script('mustache_js', WBC_ASSETS_URL . '/js/vendor/mustache.min.js', array('jquery'), WBC_VERSION, true);
            wp_register_script('wristband_js', WBC_ASSETS_URL . '/js/wristband.js', array('jquery'), WBC_VERSION, true);




            wp_enqueue_script('jquery-ui-widget_js');
            wp_enqueue_script('jquery-iframe-transport_js');
            wp_enqueue_script('jquery-fileupload_js');
            wp_enqueue_script('select2_js');
            wp_enqueue_script('material_js');
            wp_enqueue_script('pablo_js');

//            wp_enqueue_script('jquery_ui_js');
//            wp_enqueue_script('evol_colopicker_js');
            wp_enqueue_script('mustache_js');
            wp_enqueue_script('wristband_js');


            wp_localize_script('wristband_js', 'WBC', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'settings' => isset($GLOBALS['wbc_settings']) ? $GLOBALS['wbc_settings'] : array(),
            ));
        }


        public function load_styles() {
            wp_register_style('jquery-file-upload_style', WBC_ASSETS_URL . '/css/vendor/jquery-fileupload/jquery.fileupload.css', array(), WBC_VERSION);
            wp_register_style('select2_style', WBC_ASSETS_URL . '/css/vendor/select2.min.css', array(), WBC_VERSION);
            wp_register_style('material_style', WBC_ASSETS_URL . '/css/vendor/material.min.css', array(), WBC_VERSION);
//            wp_register_style('jquery_ui_style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-lightness/jquery-ui.css', array(), WBC_VERSION);
//            wp_register_style('evol_colorpicker_style', WBC_ASSETS_URL . '/css/vendor/colorpicker-master/evol.colorpicker.min.css', array(), WBC_VERSION);
            wp_register_style('wristband_style', WBC_ASSETS_URL . '/css/wristband.css', array(), WBC_VERSION);


            wp_enqueue_style('jquery-file-upload_style');
            wp_enqueue_style('select2_style');
            wp_enqueue_style('material_style');

//            wp_enqueue_style('jquery_ui_style');
//            wp_enqueue_style('evol_colorpicker_style');
            wp_enqueue_style('wristband_style');

        }

    }
}

new WBC_Front_Scripts();