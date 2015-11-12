<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Product_Price_List_Manager')) {
    class WBC_Product_Price_List_Manager extends  WBC_Manager
    {

        public function __construct() {
            add_action('init', array($this, 'register'));

            if (!is_admin()) {
                add_filter( 'wristband_settings_array', array( $this, 'get_settings' ), 30 );
            }
        }

        public function register() {

            $cust = 'Production';
            $cust_label = $cust;
            $cust_name = sanitize_title_with_underscore($cust);
            $acf_customizations = get_field('customization_options', 'option');
            if($acf_customizations) {
                foreach ($acf_customizations as $key => $field) {
                    $group_label = $field['name'];
                    $group_name = sanitize_title_with_underscore($group_label);
                    $group = $cust_name . '_price_list_' . $group_name;
                    $args = array(
                        'id' => 'acf_' . $group,
                        'title' => $cust_label . ' Price List - ' . $group_label,
                        'fields' => $this->create_production_price_list($group, $cust_name),
                        'location' => array(
                            array(
                                array(
                                    'param' => 'options_page',
                                    'operator' => '==',
                                    'value' => 'wristband-pricing-production',
                                ),
                            ),
                        ),
                        'menu_order' => $key,
                        'options' => array(
                            'position' => 'normal',
                            'layout' => 'default  wbc_hide-toggle',
                            'hide_on_screen' => array(),
                        ),
                    );
                    // Price List - Option Page > Wristband Manager
                    register_field_group($args);
                }
            }
        }



        private function create_production_price_list( $group, $name )
        {
            $production_list = array();
            $acf_dates = get_field($name.'_dates', 'option');
            if($acf_dates)
            {
                foreach($acf_dates as $key => $value)
                {
                    //tab
                    $tab_label = $value['name'];
                    $tab_name = sanitize_title_with_underscore( $tab_label );
                    array_push( $production_list, array (
                        'key' => 'field_'. generate_uniqid($group.'_'.$tab_name),
                        'label' => $tab_label,
                        'name' => $tab_name,
                        'type' => 'tab',
                    ) );

                    //repeater
                    $repeater_label = $value['name'];
                    $repeater_name = sanitize_title_with_underscore( $group.'_'.$repeater_label.'_price_list' );

                    array_push( $production_list, array (
                        'key' => 'field_'. generate_uniqid($group.'_'.$repeater_name),
                        'label' => $repeater_label,
                        'name' => generate_uniqid($repeater_name),
                        'type' => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_'. generate_uniqid($group.'_'.$repeater_name.'_quantity'),
                                'label' => 'Quantity',
                                'name' => 'quantity',
                                'type' => 'number',
                            ),
                            array(
                                'key' => 'field_'. generate_uniqid($group.'_'.$repeater_name.'_price'),
                                'label' => 'Price',
                                'name' => 'price',
                                'type' => 'number',
                            )
                        )
                    ) );
                }
            }

            return $production_list;
        }


        public function get_settings($settings) {
            $acf_customizations = get_field('customization_options', 'option');
            if ($acf_customizations) {
                foreach ($acf_customizations as $key => $value) {
                    $cus = sanitize_title_with_underscore($value['name']);
                    $repeater_field_name = 'production_price_list_'. $cus;
                    $acf_dates = get_field('production_dates', 'option');
                    if ($acf_dates) {
                        foreach ($acf_dates as $key2 => $value2) {

                            $dates = sanitize_title_with_underscore($value2['name']);

                            $rn = $repeater_field_name.'_'. $dates .'_price_list';
                            $gu = generate_uniqid($rn);
                            $acf_gu = get_field($gu, 'option');
                            if ($acf_gu) {
                                foreach($acf_gu as $key3 => $value3) {
                                    $settings['production_price_list'][$cus][$dates][$value3['quantity']] = $value3['price'];
                                }
                            }
                        }
                    }
                }
            }

            return $settings;
        }

    }




}

return new WBC_Product_Price_List_Manager();