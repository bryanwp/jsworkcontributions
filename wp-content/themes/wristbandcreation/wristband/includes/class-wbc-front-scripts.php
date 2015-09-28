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
            wp_register_script('jquery-iframe-transport_js', WBC_ASSETS_URL . '/js/vendor/jquery-fileupload/jquery.iframe-transport.js', array('jquery'), WBC_VERSION, true);
            wp_register_script('jquery-fileupload_js', WBC_ASSETS_URL . '/js/vendor/jquery-fileupload/jquery.fileupload.js', array('jquery'), WBC_VERSION, true);
            wp_register_script('mustache_js', WBC_ASSETS_URL . '/js/vendor/mustache.min.js', array('jquery'), WBC_VERSION, true);
            wp_register_script('wristband_js', WBC_ASSETS_URL . '/js/wristband.js', array('jquery'), WBC_VERSION, true);

            wp_enqueue_script('jquery-ui-widget_js');
            wp_enqueue_script('jquery-iframe-transport_js');
            wp_enqueue_script('jquery-fileupload_js');
            wp_enqueue_script('mustache_js');
            wp_enqueue_script('wristband_js');


            wp_localize_script('wristband_js', 'WBC', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'settings' => isset($GLOBALS['wbc_settings']) ? $GLOBALS['wbc_settings'] : array(),
            ));
        }


        public function load_styles() {
            wp_register_style('jquery-file-upload_style', WBC_ASSETS_URL . '/css/vendor/jquery-fileupload/jquery.fileupload.css', array(), WBC_VERSION);
            wp_register_style('wristband_style', WBC_ASSETS_URL . '/css/wristband.css', array(), WBC_VERSION);

            wp_enqueue_style('jquery-file-upload_style');
            wp_enqueue_style('wristband_style');

        }

    }
}

new WBC_Front_Scripts();