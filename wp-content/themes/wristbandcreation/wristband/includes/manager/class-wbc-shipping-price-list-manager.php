<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Shipping_Price_List_Manager')) {
    class WBC_Shipping_Price_List_Manager extends  WBC_Manager
    {

        public function __construct() {
            add_action('init', array($this, 'register'));

            if (!is_admin()) {
                add_filter( 'wristband_settings_array', array( $this, 'get_settings' ), 30 );
            }
        }

        public function register() {
            $cust = 'Shipping';
            $cust_label = $cust;
            $cust_name = sanitize_title_with_underscore($cust);



            if( have_rows('customization_options', 'option') ) {
                foreach (get_field('customization_options', 'option') as $key => $field) {
                    $group_label = $field['name'];
                    $group_name = sanitize_title_with_underscore($group_label);

                    $group = $cust_name . '_price_list_' . $group_name;


                    $args = array(
                        'id' => 'acf_' . $group,
                        'title' => $cust_label . ' Price List - ' . $group_label,
                        'fields' => $this->create_shipping_price_list($group, $cust_name),
                        'location' => array(
                            array(
                                array(
                                    'param' => 'options_page',
                                    'operator' => '==',
                                    'value' => 'wristband-pricing-shipping',
                                ),
                            ),
                        ),
                        'menu_order' => $key,
                        'options' => array(
                            'position' => 'normal',
                            'layout' => 'default  wbc_hide-toggle',
                            'hide_on_screen' => array(),
                        ),
                    );


                    // Price List - Option Page > Wristband Manager
                    register_field_group($args);
                }
            }
        }


        private function create_shipping_price_list( $group, $name )
        {
            $shipping_price_list = array();

            if( have_rows( $name.'_dates', 'option') )
            {
                while( have_rows( $name.'_dates', 'option') )
                {
                    the_row();

                    //tab
                    $tab_label = get_sub_field('name');
                    $tab_name = sanitize_title_with_underscore( $tab_label );
                    array_push( $shipping_price_list, array (
                        'key' => 'field_'. generate_uniqid($group.'_'.$tab_name),
                        'label' => $tab_label,
                        'name' => $tab_name,
                        'type' => 'tab',
                    ) );

                    //repeater
                    $repeater_label = get_sub_field('name');
                    $repeater_name = sanitize_title_with_underscore( $group.'_'.$repeater_label.'_price_list' );

                    array_push( $shipping_price_list, array (
                        'key' => 'field_'. generate_uniqid($group.'_'.$repeater_name),
                        'label' => $repeater_label,
                        'name' => generate_uniqid($repeater_name),
                        'type' => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_'. generate_uniqid($group.'_'.$repeater_name.'_quantity'),
                                'label' => 'Quantity',
                                'name' => 'quantity',
                                'type' => 'number',
                            ),
                            array(
                                'key' => 'field_'. generate_uniqid($group.'_'.$repeater_name.'_price'),
                                'label' => 'Price',
                                'name' => 'price',
                                'type' => 'number',
                            )
                        )
                    ) );
                }
            }

            return $shipping_price_list;
        }


        public function get_settings($settings) {




            if (get_field('customization_options', 'option')) {
                foreach (get_field('customization_options', 'option') as $key => $value) {
                    $cus = sanitize_title_with_underscore($value['name']);
                    $repeater_field_name = 'shipping_price_list_'. $cus;

                    if (get_field('shipping_dates', 'option')) {
                        foreach (get_field('shipping_dates', 'option') as $key2 => $value2) {
                            $dates = sanitize_title_with_underscore($value2['name']);

                            $rn = $repeater_field_name.'_'. $dates .'_price_list';
                            $gu = generate_uniqid($rn);

                            if (get_field($gu, 'option')) {
                                foreach(get_field($gu, 'option') as $key3 => $value3) {
                                    $settings['shipping_price_list'][$cus][$dates][$value3['quantity']] = $value3['price'];
                                }
                            }

                        }
                    }

                }
            }


            return $settings;
        }

    }
}

return new WBC_Shipping_Price_List_Manager();