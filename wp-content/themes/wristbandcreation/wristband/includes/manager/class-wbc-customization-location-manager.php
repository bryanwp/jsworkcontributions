<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Customization_Location_Manager')) {
    class WBC_Customization_Location_Manager extends WBC_Manager
    {

        public function __construct() {
            add_action('init', array($this, 'register'));

            if (!is_admin()) {
                add_filter('wristband_settings_array', array($this, 'get_settings'), 30);
            }
        }

        public function register() {
            $this->register_field_group(array (
                'id' => 'acf_customization-location',
                'title' => 'Customization Location',
                'fields' => array (
                    array (
                        'key' => 'field_55f41c4365efe',
                        'label' => 'Customization Location',
                        'name' => 'customization_location',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f41d5d65eff',
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
                                'key' => 'field_55f41d6d65f00',
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
                            array (
                                'key' => 'field_55f41f20946bf',
                                'label' => 'Tool Tip Text',
                                'name' => 'tool_tip_text',
                                'type' => 'text',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
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
                            'value' => 'wristband-configuration-customization-location',
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
            if (get_field('customization_location', 'option')) {
                foreach (get_field('customization_location', 'option') as $key => $value) {
                    $settings['customization']['location'][sanitize_title_with_underscore($value['name'])] = $value;
                }
            }
            return $settings;
        }
    }
}

return new WBC_Customization_Location_Manager();