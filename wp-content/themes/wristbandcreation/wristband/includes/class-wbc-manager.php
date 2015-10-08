<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Manager')) {
    class WBC_Manager
    {
        public function __construct() {
            add_action('init', array($this, 'load_product_data_fields'), 10);
            add_action('wp_loaded', array($this, 'wp_loaded'));

            add_action('save_post', array($this, 'delete_wbc_settings'), 10, 3);
            add_action('admin_head', array($this, 'delete_wbc_settings'));

            if (!is_admin()) {
                add_filter( 'wristband_settings_array', array( $this, 'get_settings' ));
            }

        }


        public function delete_wbc_settings($post_id = null, $post = null, $update = null) {

            if (($post != null && $post->post_type == 'product') ||
                (isset($_POST['acf_nonce']) && wp_verify_nonce($_POST['acf_nonce'], 'input'))) {
                update_option('wbc_settings', null);
            }
        }

        public function wp_loaded() {

            if (is_admin()) return;

            //strong the settings to option table will make data fetch more faster
            $GLOBALS['wbc_settings'] = json_decode (get_option('wbc_settings'));
            if ( null == $GLOBALS['wbc_settings'] ) {
                $result = json_encode (apply_filters('wristband_settings_array', array()));

                $GLOBALS['wbc_settings'] = json_decode($result);
                update_option( 'wbc_settings', $result );
            }
        }


        public function load_product_data_fields() {
            $field_groups = array(

                'id' => 'acf_wristband_data',
                'title' => 'Wristband Configuration',
                'fields' => apply_filters('wristband_product_data_fields', array()),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'product',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'side',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            );

            $this->register_field_group($field_groups);

        }


        public function append_to_acf_field_group($group_id, $fields) {
            global $acf_register_field_group;

            foreach ($acf_register_field_group as $index => $group) {
                if ($group['id'] != $group_id) {
                    continue;
                }

                $acf_register_field_group[$index]['fields'][] = $fields;

            }
        }

        /**
         * register_field_group()
         *
         * Register field group for custom field
         *
         * @param $args
         */
        public function register_field_group($args) {

            if( function_exists('register_field_group') ) {
                register_field_group($args);
            }

        }

        public function get_settings($settings) {

            $settings['max_qty'] = WBC_QTY_MAX;
            $settings['currency_symbol'] = html_entity_decode( get_woocommerce_currency_symbol() );


            return $settings;
        }


    }
}

new WBC_Manager();
