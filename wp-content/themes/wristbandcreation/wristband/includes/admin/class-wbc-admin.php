<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Admin')) {
    class WBC_Admin
    {
        public function __construct() {
            $this->includes();
        }


        public function includes() {
            if (!is_admin()) return;

            include_once ('settings/acf-options-page.php');
            include_once ('wbc-admin-functions.php');
            include_once ('class-wbc-admin-assets.php');





            $menus = array(

                array(
                    'title' => __('Wristband Configuration','acf'), // title / menu name ('Site Options')
                    'slug'  => 'wristband-configuration',
                    'icon'  => 'dashicons-marker',
                    'menu_order' => '59.1',
                    'capability' => 'edit_posts', // capability to view options page
                    'pages' => array(
                        'Sizes',
                        'Color Styles',
                        'Colors',
                        'Messages',
                        'Fonts',
                        'Logo',
                        'Additional Options',
                        'Customization Location',
                        'Dates For Customization',
                        'Customization Options',
                        'Calendar'
                    ), // an array of sub pages ('Header, Footer, Home, etc')


                ),

                array(
                    'title' => __('Wristband Pricing','acf'), // title / menu name ('Site Options')
                    'slug'  => 'wristband-pricing',
                    'icon'  => 'dashicons-chart-area',
                    'menu_order' => '59.6',
                    'capability' => 'edit_posts', // capability to view options page
                    'pages' => array('Colors', 'Color Styles', 'Messages', 'Logo', 'Additional Options', 'Production', 'Shipping')
                )
            );


            new acf_options_page_plugin($menus);

            include_once ('class-wbc-calendar.php');
        }



    }
}

new WBC_Admin();