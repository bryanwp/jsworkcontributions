<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Admin_Assets')) {
    class WBC_Admin_Assets
    {
        public function __construct() {
            add_action('admin_enqueue_scripts', array($this, 'load_scripts'));
            add_action('admin_enqueue_scripts', array($this, 'load_styles'));
        }


        public function load_scripts() {
//            wp_register_script('wristband-admin-js', WBC_ASSETS_URL . '/js/wristband-admin.js', array('jquery'), WBC_VERSION, true);
//            wp_enqueue_script('wristband-admin-js');
        }


        public function load_styles() {
            wp_register_style('wristband-admin-style',  WBC_ASSETS_URL . '/css/wristband-admin.css', array(), WBC_VERSION);

            wp_enqueue_style('wristband-admin-style');
        }
    }
}


new WBC_Admin_Assets();