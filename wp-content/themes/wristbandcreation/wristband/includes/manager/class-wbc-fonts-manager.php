<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Fonts_Manager')) {
    class WBC_Fonts_Manager extends WBC_Manager
    {
        public function __construct() {
            add_action('init', array($this, 'register'));

            if (!is_admin()) {
                add_filter( 'wristband_settings_array', array( $this, 'get_settings' ), 20 );
            }
        }

        public function register() {
            $this->register_field_group(array (
                'id' => 'acf_fonts',
                'title' => 'Fonts',
                'fields' => array (
                    array (
                        'key' => 'field_55f657a67efa5',
                        'label' => 'Fonts',
                        'name' => 'fonts',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f657b07efa6',
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
                                'key' => 'field_55f687c88bb07',
                                'label' => 'Enable',
                                'name' => 'enable',
                                'type' => 'checkbox',
                                'column_width' => '',
                                'choices' => array (
                                    'Enable' => 'Enable',
                                ),
                                'default_value' => '',
                                'layout' => 'vertical',
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
                            'value' => 'wristband-configuration-fonts',
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

            $fonts = array();

            if (get_field('fonts', 'option')) {
                foreach (get_field('fonts', 'option') as $key => $value) {
                    if (isset($value['enable']) && $value['enable'] != '') {
                        $fonts[] = trim($value['name']);
                    }
                }
            }

            $settings['fonts'] = $fonts;


            return $settings;
        }
    }
}

return new WBC_Fonts_Manager();