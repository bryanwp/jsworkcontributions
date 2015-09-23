<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Color_Style_Manager')) {
    class WBC_Color_Style_Manager extends WBC_Manager
    {


        public function __construct() {
            add_action('init', array($this, 'register_color_style_field_group'));


            add_filter( 'wristband_settings_array', array( $this, 'get_color_style_list' ), 20 );

            add_filter('wristband_product_data_fields', array($this, 'register_product_data_fields'), 20);



        }

        public function register_product_data_fields($fields) {

            $fields = array_merge($fields, array (

                array(
                    'key' => 'field_enable-color-style',
                    'label' => 'Color',
                    'name' => 'enable-color-style',
                    'type' => 'tab',
                ),
                array (
                    'key' => 'field_55f30738b6af6',
                    'label' => 'Color Style List',
                    'name' => 'color_style_list_check',
                    'type' => 'checkbox',
                    'instructions' => 'Data is dynamically added from Wristband Manager > Color Styles',
                    'choices' => array (),
                    'default_value' => '',
                    'layout' => 'horizontal',
                ),
            ));

            return $fields;
        }

        public function register_color_style_field_group() {
            $this->register_field_group(array (
                'id' => 'acf_color-styles',
                'title' => 'Color Styles',
                'fields' => array (
                    array (
                        'key' => 'field_55f30388a97c9',
                        'label' => 'Color Style',
                        'name' => 'color_style_list',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f30399a97ca',
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
                                'key' => 'field_55f3040a64bcb',
                                'label' => 'Add Price',
                                'name' => 'add_price',
                                'type' => 'checkbox',
                                'column_width' => '',
                                'choices' => array (
                                    'Add Price' => 'Add Price',
                                ),
                                'default_value' => '',
                                'layout' => 'vertical',
                            ),
                            array (
                                'key' => 'field_55f390f7cf273',
                                'label' => 'Color Limit',
                                'name' => 'color_limit',
                                'type' => 'select',
                                'column_width' => '',
                                'choices' => array (
                                    1 => 1,
                                    2 => 2,
                                    3 => 3,
                                ),
                                'default_value' => '',
                                'allow_null' => 0,
                                'multiple' => 0,
                            ),
                            array (
                                'key' => 'field_55f303a5a97cb',
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
                        'row_limit' => 5,
                        'layout' => 'table',
                        'button_label' => 'Add Row',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'wristband-configuration-color-styles',
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


        public function get_color_style_list($settings) {



            $color_style = array();
            if (get_field('color_style_list', 'option')) {
                foreach (get_field('color_style_list', 'option') as $key => $value) {

                    if (!isset($value['name'])) continue;

                    $color_style[$value['name']] = array(

                        'color_limit' => $value['color_limit'],
                        'image' => array(
                            'id' => $value['image']['id'],
                            'url' => $value['image']['url']
                        )
                    );
                }
            }

            $settings['color_style'] = $color_style;

            return $settings;
        }
    }
}

return new WBC_Color_Style_Manager();