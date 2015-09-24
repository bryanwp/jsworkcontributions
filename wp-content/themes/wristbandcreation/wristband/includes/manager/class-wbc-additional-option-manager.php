<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Additional_Option_Manager')) {
    class WBC_Additional_Option_Manager extends WBC_Manager
    {
        public function __construct() {
            add_action('init', array($this, 'register'));

            if (!is_admin()) {
                add_filter( 'wristband_settings_array', array( $this, 'get_settings' ), 20 );
            }
        }

        public function register() {
            $this->register_field_group(array (
                'id' => 'acf_additional-options',
                'title' => 'Additional Options',
                'fields' => array (
                    array (
                        'key' => 'field_55f451acf773e',
                        'label' => 'Additional Options',
                        'name' => 'additional_options',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f451cef7740',
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
                                'key' => 'field_55f45252f7743',
                                'label' => 'Cost Type',
                                'name' => 'cost_type',
                                'type' => 'select',
                                'column_width' => '',
                                'choices' => array (
                                    'Each Quantity' => 'Each Quantity',
                                    'Per Order' => 'Per Order',
                                ),
                                'default_value' => '',
                                'allow_null' => 0,
                                'multiple' => 0,
                            ),
                            array (
                                'key' => 'field_55f456349f176',
                                'label' => 'Convert',
                                'name' => 'convert',
                                'type' => 'radio',
                                'column_width' => '',
                                'choices' => array (
                                    'no' => 'No',
                                    'convert' => 'Convert to this Option',
                                ),
                                'other_choice' => 0,
                                'save_other_choice' => 0,
                                'default_value' => '',
                                'layout' => 'vertical',
                            ),
                            array (
                                'key' => 'field_55f455ad9f175',
                                'label' => 'Choose Size',
                                'name' => 'choose_size',
                                'type' => 'checkbox',
                                'column_width' => '',
                                'choices' => array(),
                                'default_value' => '',
                                'allow_null' => 0,
                                //'multiple' => 1,
                            ),
                            array (
                                'key' => 'field_55f4523ef7742',
                                'label' => 'Tool Tip Text',
                                'name' => 'tool_tip_text',
                                'type' => 'textarea',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'maxlength' => '',
                                'rows' => '',
                                'formatting' => 'br',
                            ),
                            array (
                                'key' => 'field_55f4522af7741',
                                'label' => 'Image',
                                'name' => 'image',
                                'type' => 'image',
                                'column_width' => '',
                                'save_format' => 'object',
                                'preview_size' => 'thumbnail',
                                'library' => 'all',
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
                            'value' => 'wristband-configuration-additional-options',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'default wbc_hide-toggle',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            ));
        }


        public function get_settings($settings) {

            $additional_options = array();

            if (get_field('additional_options', 'option')) {
                foreach (get_field('additional_options', 'option') as $key => $value) {

                    $additional_options[sanitize_title_with_underscore($value['name'])] = array(
                        'name' => $value['name'],
                        'cost_type' => $value['cost_type'],
                        'convert' => $value['convert'],
                        'choose_size' => $value['choose_size'],
                        'tool_tip_text' => $value['tool_tip_text'],
                        'image' => array(
                            'id' => $value['image']['id'],
                            'url' => $value['image']['url'],
                        )
                    );
                }
            }

            $settings['additional_options'] = $additional_options;
            return $settings;
        }
    }
}

return new WBC_Additional_Option_Manager();