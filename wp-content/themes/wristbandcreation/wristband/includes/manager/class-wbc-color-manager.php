<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Color_Manager')) {
    class WBC_Color_Manager extends WBC_Manager
    {
        public function __construct() {
            add_action('init', array($this, 'register'));


            add_filter('acf_load_field-color_style', array($this, 'load_field_color_style_choices'));// v3.5.8.2 and below
            add_filter('acf/load_field/name=color_style', array($this, 'load_field_color_style_choices'));// v4.0.0 and above

            add_filter('acf_load_field-color_style_list_check', array($this, 'load_field_color_style_choices'));// v3.5.8.2 and below
            add_filter('acf/load_field/name=color_style_list_check', array($this, 'load_field_color_style_choices'));// v4.0.0 and above


            if (!is_admin()) {
                add_filter( 'wristband_settings_array', array( $this, 'get_settings' ), 40 );
            }

        }

        public function register() {

            $this->register_field_group(array (
                'id' => 'acf_color_pricing',
                'title' => 'Colors',
                'fields' => array (
                    array (
                        'key' => 'field_55f4f7354cf25',
                        'label' => 'Color Extra Size Cost',
                        'name' => '',
                        'type' => 'tab',
                    ),
                    array (
                        'key' => 'field_55f45c241ad92',
                        'label' => 'Color Extra Size Cost',
                        'name' => 'color_extra_size_cost_price_list',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f4f6ef4cf21',
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
                                'key' => 'field_55f4f7014cf22',
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
                    ),
                    array (
                        'key' => 'field_55f4f73f4cf26',
                        'label' => 'Color Split Cost',
                        'name' => '',
                        'type' => 'tab',
                    ),
                    array (
                        'key' => 'field_55f45c3f1ad93',
                        'label' => 'Color Split Cost',
                        'name' => 'color_split_cost_price_list',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f4f7184cf23',
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
                                'key' => 'field_55f4f7234cf24',
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
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'wristband-pricing-colors',
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
                'menu_order' => 1,
            ));



            $this->register_field_group(array (
                'id' => 'acf_colors',
                'title' => 'Colors',
                'fields' => array (
                    array (
                        'key' => 'field_55f45be11ad90',
                        'label' => 'Color Sizes',
                        'name' => 'color_size',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f45c191ad91',
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
                            'value' => 'wristband-configuration-colors',
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
                'menu_order' => 1,
            ));


            $this->register_field_group( array(
                    'id' => 'acf_color_list',
                    'title' => 'Color',
                    'fields' => $this->create_color_list( 'color_list' ),
                    'location' => array(
                        array(
                            array(
                                'param' => 'options_page',
                                'operator' => '==',
                                'value' => 'wristband-configuration-colors',
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
                'id' => 'acf_text-color',
                'title' => 'Text Color',
                'fields' => array (
                    array (
                        'key' => 'field_560b4d254736a',
                        'label' => 'Text Color',
                        'name' => 'text_color',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_560b517a4736b',
                                'label' => 'Name',
                                'name' => 'name',
                                'type' => 'text',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'formatting' => 'none',
                                'maxlength' => '',
                            ),
                            array (
                                'key' => 'field_560b518b4736c',
                                'label' => 'Color',
                                'name' => 'color',
                                'type' => 'color_picker',
                                'column_width' => '',
                                'default_value' => '#FFFFFF',
                            ),
                            array (
                                'key' => 'field_560cd01719fb7',
                                'label' => 'Product',
                                'name' => 'product',
                                'type' => 'post_object',
                                'column_width' => '',
                                'post_type' => array (
                                    0 => 'product',
                                ),
                                'taxonomy' => array (
                                    0 => 'all',
                                ),
                                'allow_null' => 0,
                                'multiple' => 1,
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
                            'value' => 'wristband-configuration-colors',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'no_box',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            ));

        }

        public function load_field_color_style_choices( $field )
        {
            // reset choices
            $field['choices'] = array();

            $acf_color_style_list = get_field('color_style_list', 'option');
            if($acf_color_style_list) {
                foreach($acf_color_style_list as $k => $value) {
                    $label = $value['name'];
                    $field['choices'][ str_replace(' ', '_', strtolower($label)) ] = $label;
                }
            }


            return $field; // Important: return the field
        }

        /**
        * create_color_list
        * Create color list
        *
        * @param $group
        * @return array
        */
        private function create_color_list ( $group )
        {
            $color_tab_list = array();
            $acf_color_style_list = get_field('color_style_list', 'option');
            if($acf_color_style_list)
            {
                foreach($acf_color_style_list as $k => $value)
                {
                    //tab
                    $tab_label = $value['name'];
                    $tab_name = sanitize_title_with_underscore( $tab_label );
                    array_push( $color_tab_list, array (
                        'key' => 'field_'.$group.'_'.$tab_name,
                        'label' => $tab_label,
                        'name' => $tab_name,
                        'type' => 'tab',
                    ) );

                    //repeater
                    $repeater_label = $value['name'];
                    $repeater_name = sanitize_title_with_underscore( $repeater_label.'_color_list' );

                    $sub_fields = array();

                    array_push( $sub_fields, array(
                        'key' => 'field_'.$group.'_'.$repeater_name.'_name',
                        'label' => 'Name',
                        'name' => 'name',
                        'type' => 'text',
                    ) );

                    for ( $i=1; $i <= intval($value['color_limit']); $i++ )
                    {
                        $color_limit_label = 'Color '.$i;
                        $color_limit_name = sanitize_title_with_underscore( $color_limit_label );
                        array_push( $sub_fields, array(
                            'key' => 'field_'.$group.'_'.$repeater_name.'_'.$color_limit_name,
                            'label' => $color_limit_label,
                            'name' => $color_limit_name,
                            'type' => 'color_picker',
                        ) );
                    }

                    array_push( $color_tab_list, array (
                        'key' => 'field_'.$group.'_'.$repeater_name,
                        'label' => $repeater_label,
                        'name' => $repeater_name,
                        'type' => 'repeater',
                        'sub_fields' => $sub_fields
                    ) );
                }
            }

            return $color_tab_list;
        }

        public function get_settings($settings) {


            if (isset($settings['color_style']) && count($settings['color_style']) != 0) {
                foreach ($settings['color_style'] as $name => $style) {

                    $repeater_name = sanitize_title_with_underscore($name . '_color_list');
                    $acf_repeater = get_field($repeater_name, 'option');
                    if ($acf_repeater) {
                        foreach ($acf_repeater as $key => $value) {
                            $settings['color_style'][$name]['color_list'][] = $value;
                        }
                    }


                }
            }

            $acf_text_color = get_field('text_color', 'option');
            if ($acf_text_color) {
                foreach ($acf_text_color as $key => $value) {
                    if (!isset($value['name']) && !empty($value['name'])  && !empty($value['product'])) continue;
                    foreach ($value['product'] as $product) {
                        $settings['products'][$product->ID]['text_color'][] = array('name' => $value['name'], 'color' => $value['color']);
                    }
                }
            }

            $acf_color_size = get_field('color_size', 'option');
            if ($acf_color_size) {
                foreach ($acf_color_size as $key => $value) {
                    if (!isset($value['name'])) continue;
                    $settings['color_size'][] = $value['name'];
                }
            }
            $acf_color_extra_size_cost_prices = get_field('color_extra_size_cost_price_list', 'option');
            if ($acf_color_extra_size_cost_prices) {
                foreach ($acf_color_extra_size_cost_prices as $key => $value) {
                    if (!isset($value['quantity'])) continue;
                    $settings['color_extra_size_cost_price_list'][$value['quantity']] = $value['price'];
                }
            }
            $acf_color_split_cost_prices = get_field('color_split_cost_price_list', 'option');
            if ($acf_color_split_cost_prices) {
                foreach ($acf_color_split_cost_prices as $key => $value) {
                    if (!isset($value['quantity'])) continue;
                    $settings['color_split_cost_price_list'][$value['quantity']] = $value['price'];
                }
            }

            return $settings;
        }
    }
}

return new WBC_Color_Manager();