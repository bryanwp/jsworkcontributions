<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Additional_Option_Price_List_Manager')) {
    class WBC_Additional_Option_Price_List_Manager extends WBC_Manager
    {
        public function __construct() {
            add_action('init', array($this, 'register'));

            if (!is_admin()) {
                add_filter( 'wristband_settings_array', array( $this, 'get_settings' ), 30 );
            }
        }

        public function register() {
            $this->register_field_group( array(
                'id' => 'acf_additional_option_price_list',
                'title' => 'Additional Options',
                'fields' => $this->create_additional_option_price_list( 'additional_option_price_list' ),
                'location' => array(
                    array(
                        array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'wristband-pricing-additional-options',
                        ),
                    ),
                ),
                'menu_order' => 0,
            ));

        }



        private function create_additional_option_price_list( $group )
        {


            $additional_option_price_list = array();

            if( have_rows('additional_options', 'option') )
            {
                while( have_rows('additional_options', 'option') )
                {
                    the_row();

                    //tab
                    $tab_label = get_sub_field('name');
                    $tab_name = sanitize_title_with_underscore( $tab_label );
                    array_push( $additional_option_price_list, array (
                        'key' => 'field_'.$group.'_'.$tab_name,
                        'label' => $tab_label,
                        'name' => $tab_name,
                        'type' => 'tab',
                    ) );

                    //repeater
                    $repeater_label = get_sub_field('name');
                    $repeater_name = sanitize_title_with_underscore( $repeater_label.' Price List' );

                    array_push( $additional_option_price_list, array (
                        'key' => 'field_'.$group.'_'.$repeater_name,
                        'label' => $repeater_label,
                        'name' => $repeater_name,
                        'type' => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_'.$group.'_'.$repeater_name.'_quantity',
                                'label' => 'Quantity',
                                'name' => 'quantity',
                                'type' => 'number',
                            ),
                            array(
                                'key' => 'field_'.$group.'_'.$repeater_name.'_price',
                                'label' => 'Price',
                                'name' => 'price',
                                'type' => 'number',
                            )
                        )
                    ) );
                }
            }

            return $additional_option_price_list;
        }


        public function get_settings($settings) {

            $additional_options = array();


            if (get_field('additional_options', 'option')) {
                foreach (get_field('additional_options', 'option') as $key => $value) {
                    $name = sanitize_title_with_underscore($value['name']);
                    $additional_options[$name] = $value;

                    $repeater_name = $name.'_price_list';

                    if (get_field($repeater_name, 'option')) {
                        foreach (get_field($repeater_name, 'option') as $key2 => $value2) {
                            $settings['additional_options'][$name]['price_list'][$value2['quantity']] = $value2['price'];
                        }
                    }


                }
            }


            return $settings;
        }
    }
}

return new WBC_Additional_Option_Price_List_Manager();