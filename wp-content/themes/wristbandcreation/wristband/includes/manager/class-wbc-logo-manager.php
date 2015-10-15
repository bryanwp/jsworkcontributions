<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Logo_Manager')) {
    class WBC_Logo_Manager extends WBC_Manager
    {
        public function __construct() {
            add_action('init', array($this, 'register'));


            if (!is_admin()) {
                add_filter( 'wristband_settings_array', array( $this, 'get_settings' ), 20 );
            }
        }

        public function register() {

            $this->register_field_group(array (
                'id' => 'acf_logo_pricing',
                'title' => 'Logo',
                'fields' => array (
                    array (
                        'key' => 'field_55f305de89008',
                        'label' => 'Logo',
                        'name' => 'logo_price',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f305fc89009',
                                'label' => 'Quantity',
                                'name' => 'quantity',
                                'type' => 'number',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'min' => '',
                                'max' => '',
                                'step' => '',
                            ),
                            array (
                                'key' => 'field_55f306098900a',
                                'label' => 'Price',
                                'name' => 'price',
                                'type' => 'number',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'min' => '',
                                'max' => '',
                                'step' => '',
                            ),
                        ),
                        'row_min' => '',
                        'row_limit' => '',
                        'layout' => 'table',
                        'button_label' => 'Add Row',
                    )
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'wristband-pricing-logo',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'default  wbc_hide-toggle',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            ));


            $this->register_field_group(array (
                'id' => 'acf_logo',
                'title' => 'Logo',
                'fields' => array (
                    array (
                        'key' => 'field_55f306148900b',
                        'label' => 'Logo',
                        'name' => 'logo_list',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f3064d8900c',
                                'label' => 'Name',
                                'name' => 'name',
                                'type' => 'text',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'formatting' => 'html',
                                'maxlength' => '',
                            ),
                            array (
                                'key' => 'field_55f306578900d',
                                'label' => 'Glyphicon',
                                'name' => 'glyphicon',
                                'type' => 'text',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'formatting' => 'html',
                                'maxlength' => '',
                            ),
                        ),
                        'row_min' => '',
                        'row_limit' => '',
                        'layout' => 'table',
                        'button_label' => 'Add Row',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'wristband-configuration-logo',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'default  wbc_hide-toggle',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            ));
        }

        public function get_settings($settings) {
            $prices = array();
            $list = array();
            if (get_field('logo_price', 'option')) {
                foreach (get_field('logo_price', 'option') as $key => $value) {
                    $prices[$value['quantity']] = $value['price'];
                }
            }

            if (get_field('logo_list', 'option')) {
                foreach (get_field('logo_list', 'option') as $key => $value) {
                    $list[$value['name']] = $value['glyphicon'];
                }
            }
            $settings['logo']['prices'] = $prices;
            $settings['logo']['list'] = $list;


            return $settings;
        }
    }
}

return new WBC_Logo_Manager();