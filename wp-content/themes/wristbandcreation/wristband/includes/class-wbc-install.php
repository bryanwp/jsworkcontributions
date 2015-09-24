<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Install')) {
    class WBC_Install
    {
        public function __construct() {

            $this->includes();

        }


        /**
         * includes
         * Include the necessary functions and classes
         *
         * @params none
         * @return none
         */
        function includes() {
            include_once ('wbc-core-functions.php');
            include_once ('class-wbc-front-scripts.php');
            // Manager
            include_once ('class-wbc-manager.php');
            include_once ('manager/class-wbc-size-manager.php');
            include_once ('manager/class-wbc-color-style-manager.php');
            include_once ('manager/class-wbc-color-style-price-list-manager.php');
            include_once ('manager/class-wbc-color-manager.php');
            include_once ('manager/class-wbc-messages-manager.php');
            include_once ('manager/class-wbc-fonts-manager.php');
            include_once ('manager/class-wbc-logo-manager.php');
            include_once ('manager/class-wbc-additional-option-manager.php');
            include_once ('manager/class-wbc-additional-option-price-list-manager.php');
            include_once ('manager/class-wbc-customization-location-manager.php');
            include_once ('manager/class-wbc-date-for-customization-manager.php');
            include_once ('manager/class-wbc-customization-option-manager.php');
            include_once ('manager/class-wbc-production-price-list-manager.php');
            include_once ('manager/class-wbc-shipping-price-list-manager.php');








            // Check if in the admin
            if (is_admin()) {
                include_once ('admin/class-wbc-admin.php');
            }

            if (!is_admin()) {
                include_once ('class-wbc-shortcodes.php');
            }



        }
    }
}

new WBC_Install();