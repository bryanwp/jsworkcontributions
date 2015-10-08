<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Date_For_Customization_Manager')) {
    class WBC_Date_For_Customization_Manager extends  WBC_Manager
    {

        public function __construct() {
            add_action('init', array($this, 'register'));


            if (!is_admin()) {
                add_filter('wristband_settings_array', array($this, 'get_settings'), 30);
            }
        }

        public function register() {
            $this->register_field_group(array (
                'id' => 'acf_dates-for-customization',
                'title' => 'Dates For Customization',
                'fields' => array (
                    array (
                        'key' => 'field_55f41e7fe0109',
                        'label' => 'Production',
                        'name' => '',
                        'type' => 'tab',
                    ),
                    array (
                        'key' => 'field_55f41e92e010b',
                        'label' => 'Production Dates',
                        'name' => 'production_dates',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f41ea2e010c',
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
                                'key' => 'field_55f41ea9e010d',
                                'label' => 'Days',
                                'name' => 'days',
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
                    ),
                    array (
                        'key' => 'field_55f41e87e010a',
                        'label' => 'Shipping',
                        'name' => '',
                        'type' => 'tab',
                    ),
                    array (
                        'key' => 'field_55f41eb4e010e',
                        'label' => 'Shipping Dates',
                        'name' => 'shipping_dates',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f41eb4e010f',
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
                                'key' => 'field_55f41eb4e0110',
                                'label' => 'Days',
                                'name' => 'days',
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
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'wristband-configuration-dates-for-customization',
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

            $types = array('production', 'shipping');

            foreach($types as $type) {
                if (get_field($type. '_dates', 'option')) {
                    foreach (get_field($type. '_dates', 'option') as $key => $value) {
                        $settings['customization']['dates'][$type][sanitize_title_with_underscore($value['name'])] = $value;
                    }
                }
            }

            return $settings;
        }

    }
}

return new WBC_Date_For_Customization_Manager();