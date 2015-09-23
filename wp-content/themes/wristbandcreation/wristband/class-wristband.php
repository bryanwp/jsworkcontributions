<?php
/**
 * Text Domain: wristband
 * Version: 1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Wristband')) {
    class Wristband
    {


        public function __construct() {
            $this->constants();
            $this->includes();
        }


        /**
         * constants
         * Initialize constant variables
         *
         * @params none
         * @return none
         */

        private function constants() {
            $path = ltrim( end( @explode( get_stylesheet(), str_replace( '\\', '/', dirname( __FILE__ ) ) ) ), '/' );

            $this->define('WBC_TEXT_DOMAIN', 'wristband');
            $this->define('WBC_VERSION', '1.0');
            $this->define('WBC_URL', untrailingslashit(get_stylesheet_directory_uri()) . '/'. $path);

            $this->define('WBC_ASSETS_URL', WBC_URL . '/assets');
        }

        /**
         * define
         * Check if constant variable is already defined
         * if not then define the constant variable
         *
         *
         * @param $name
         * @param $val
         */
        private function define($name, $val) {
            if (!defined($name)) {
                define($name, $val);
            }
        }




        public function includes() {
            include_once ('includes/class-wbc-install.php');
        }
    }
}

$GLOBALS['wristband'] = new Wristband();