<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Customization_Option_Manager')) {
    class WBC_Customization_Option_Manager extends WBC_Manager
    {

        public function __construct() {
            add_action('init', array($this, 'register'));
            add_filter('acf_load_field-set_size_list', array($this, 'load_field_size_choices'));// v3.5.8.2 and below
            add_filter('acf/load_field/name=set_size_list', array($this, 'load_field_size_choices'));// v4.0.0 and above


            if (!is_admin()) {
                add_filter('wristband_settings_array', array($this, 'get_settings'), 30);
            }
        }

        public function register() {
            $this->register_field_group(array (
                'id' => 'acf_customization-options',
                'title' => 'Customization Options',
                'fields' => array (
                    array (
                        'key' => 'field_55f4323dac659',
                        'label' => 'Customization Options',
                        'name' => 'customization_options',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f43245ac65a',
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
                                'key' => 'field_55f43254ac65b',
                                'label' => 'Set Size List',
                                'name' => 'set_size_list',
                                'type' => 'checkbox',
                                'column_width' => '',
                                'choices' => array (),
                                'default_value' => '',
                                'allow_null' => 0,
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
                            'value' => 'wristband-configuration-customization-options',
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



        /**
         * load_field_size_choices()
         * Load field size choices
         *
         * @param $field
         * @return mixed
         */

        public function load_field_size_choices( $field )
        {
            // reset choices
            $field['choices'] = array();

            if( have_rows('size_list', 'option') ) {
                while( have_rows('size_list', 'option') ) {
                    the_row();
                    $label = get_sub_field('inch');
                    if (!$label) continue;

                    $field['choices'][$label] = $label;
                }
            }


            return $field; // Important: return the field
        }

        public function get_settings($settings) {

            if (get_field('customization_options', 'option')) {
                foreach (get_field('customization_options', 'option') as $key => $value) {
                    $settings['customization']['options'][sanitize_title_with_underscore($value['name'])] = $value;
                }
            }

            return $settings;
        }

    }
}

return new WBC_Customization_Option_Manager();