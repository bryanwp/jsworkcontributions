<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Color_Style_Price_List_Manager')) {
    class WBC_Color_Style_Price_List_Manager extends WBC_Manager
    {
        public function __construct() {
            add_action('init', array($this, 'register'));

            if (!is_admin()) {
                add_filter('wristband_settings_array', array($this, 'get_settings'), 35);
            }
        }




        /**
         * register_color_style_price_list_field_group()
         *
         * Register color style price list acf group
         *
         * @param none
         * @return none
         */
        public function register() {
            $this->register_field_group( array(
                'id' => 'acf_color_style',
                'title' => 'Color Style',
                'fields' => $this->create_color_style_price_list( 'color_style' ),
                'location' => array(
                    array(
                        array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'wristband-pricing-color-styles',
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
         * create_color_style_price_list
         * Create color style price list
         *
         * @param $group
         * @return array
         */

        private function create_color_style_price_list( $group )
        {
            $color_style_price_tab_list = array();

            if( have_rows('color_style_list', 'option') )
            {
                while( have_rows('color_style_list', 'option') )
                {
                    the_row();
                    if( get_sub_field('add_price') )
                    {
                        //tab
                        $tab_label = get_sub_field('name');
                        $tab_name = sanitize_title_with_underscore( $tab_label );
                        array_push( $color_style_price_tab_list, array (
                            'key' => 'field_'.$group.'_'.$tab_name,
                            'label' => $tab_label,
                            'name' => $tab_name,
                            'type' => 'tab',
                        ) );

                        //repeater
                        $repeater_label = get_sub_field('name');
                        $repeater_name = sanitize_title_with_underscore( $repeater_label.' Price List' );
                        array_push( $color_style_price_tab_list, array (
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
            }

            return $color_style_price_tab_list;
        }





        public function get_settings($settings) {

            if (isset($settings['color_style']) && count($settings['color_style']) != 0) {
                foreach ($settings['color_style'] as $name => $style) {
                    $repeater_name = sanitize_title_with_underscore($name . '_price_list');
                    $opts = get_field($repeater_name, 'option');
                    if (is_array($opts) && count($opts) != 0) {
                        foreach (get_field($repeater_name, 'option') as $key => $value) {

                            if (!isset($value['quantity'])) continue;
                            $settings['color_style'][$name]['price_list'][$value['quantity']] = $value['price'];
                        }
                    }
                }
            }



            return $settings;
        }
    }
}

return new WBC_Color_Style_Price_List_Manager();