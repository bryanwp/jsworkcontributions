<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Size_Manager')) {
    class WBC_Size_Manager extends WBC_Manager
    {


        /**
         * $post_type
         * @var string
         */
        protected $post_type = 'product';

        public function __construct() {



            if (!is_admin()) {
                add_filter('wristband_settings_array', array($this, 'get_settings'), 20);
            }


            add_action('init', array($this, 'register'), 20);



            add_filter('acf_load_field-size_list_check', array($this, 'load_field_size_choices'));// v3.5.8.2 and below
            add_filter('acf/load_field/name=size_list_check', array($this, 'load_field_size_choices'));// v4.0.0 and above

            add_filter('acf_load_field-choose_size', array($this, 'load_field_size_choices'));// v3.5.8.2 and below
            add_filter('acf/load_field/name=choose_size', array($this, 'load_field_size_choices'));// v4.0.0 and above


            add_filter('acf_load_field-default_size', array($this, 'load_field_size_choices'));// v3.5.8.2 and below
            add_filter('acf/load_field/name=default_size', array($this, 'load_field_size_choices'));// v4.0.0 and above



            add_filter('wristband_product_data_fields', array($this, 'register_product_data_fields'), 10);


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


        public function register_product_data_fields($fields = array()) {

            $fields = array_merge($fields, array (
                array(
                    'key' => 'field_enable-size',
                    'label' => 'Size',
                    'name' => 'enable-size-tab',
                    'type' => 'tab',
                ),
                array (
                    'key' => 'field_55f306f3c723b',
                    'label' => 'Size List',
                    'name' => 'size_list_check',
                    'type' => 'checkbox',
                    'instructions' => 'Data is dynamically added from Wristband Manager > Sizes',
                    'choices' => array (),
                    'default_value' => '',
                    'layout' => 'horizontal',
                ),
                array(
                    'key' => 'field_default-size',
                    'label' => 'Default Size',
                    'name' => 'default-size-tab',
                    'type' => 'tab',
                ),
                array (
                    'key' => 'field_55f306f3c723c',
                    'label' => 'Default Size',
                    'name' => 'default_size',
                    'type' => 'radio',
                    'instructions' => 'Data is dynamically added from Wristband Manager > Sizes',
                    'choices' => array (),
                    'default_value' => '',
                    'layout' => 'horizontal',
                ),
            ));


            return $fields;
        }
        /**
         * init_size_group()
         * Initialize wristband-configuration-sizes page custom field
         */
        public function register() {



            $this->register_field_group(array (
                'id' => 'acf_sizes',
                'title' => 'Sizes',
                'fields' => array (
                    array (
                        'key' => 'field_55f302dc6b650',
                        'label' => 'Sizes',
                        'name' => 'size_list',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f302e76b651',
                                'label' => 'Inch',
                                'name' => 'inch',
                                'type' => 'text',
                                'column_width' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => 'inch',
                                'formatting' => 'html',
                                'maxlength' => '',
                            ),
                            array (
                                'key' => 'field_55f302fb6b652',
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
                            'value' => 'wristband-configuration-sizes',
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



            $product_posts = get_posts(array( 'posts_per_page' => -1, 'post_status' => 'any', 'post_type' => 'product' ));




            foreach ($product_posts as $post)
            {
                $group = 'size_price_list_'.$post->ID;
                // Size Price List - Post Type > product
                register_field_group( array(
                    'id' => 'acf_'.$group,
                    'title' => 'Size Price List',
                    'fields' => $this->create_size_price_list( $group, $post->ID ),
                    'location' => array(
                        array(
                            array(
                                'param' => 'post',
                                'operator' => '==',
                                'value' => $post->ID,
                            ),
                        ),
                    ),
                    'menu_order' => 2,
                    'options' => array(
                        'position' => 'normal',
                        'layout' => 'default',
                        'hide_on_screen' => array(
                        ),
                    ),
                ));
            }
        }

         /**
         * create_size_price_list
         * Create size price list
         *
         * @param $group
         * @param $post_id
         * @return array
         */
        private function create_size_price_list( $group, $post_id )
        {
            $price_chart = array();

            $fields = get_field( 'size_list_check', $post_id );




            if($fields)
            {
                for ($i=0; $i < count($fields); $i++)
                {
                    $field = $fields[$i];
                    //tab
                    $tab_label = $field;
                    $tab_name = sanitize_title_with_underscore( $tab_label );
                    array_push( $price_chart, array (
                        'key' => 'field_'.$group.'_'.$tab_name,
                        'label' => $tab_label,
                        'name' => $tab_name,
                        'type' => 'tab',
                    ) );

                    // repeater
                    $repeater_label = $field.' Inch Price List';
                    $repeater_name = sanitize_title_with_underscore( $repeater_label );
                    array_push( $price_chart, array (
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

            return $price_chart;
        }

        /**
         * get_product_price_chart()
         *
         * Get product price chart on specific size
         *
         * @param $product_id
         * @param $size
         * @return $price_chart
         */
        public function get_product_price_chart($size, $product_id) {
            $price_chart = array();

            $repeater_name = sanitize_title_with_underscore($size . '_inch_price_list');
            $acf_repeater = get_field($repeater_name, $product_id);
            if($acf_repeater) {
                foreach ($acf_repeater as $k => $value) {
                    $price_chart[$value['quantity']] = $value['price'];
                }
            }

            // Sort price chart by key
            ksort($price_chart);
            return $price_chart;
        }

        /**
         * get_all_price_chart_by_product_id()
         * Get all price chart by product id
         *
         * @param $product_id
         * @return $price_charts
         */
        public function get_all_price_chart_by_product($product_id) {
            $price_charts = array();
            $sizes = $this->get_enabled_product_sizes($product_id);
            if( is_array($sizes) && count($sizes) != 0 ) {
                foreach ($sizes as $size) {
                    $price_charts[$size] = $this->get_product_price_chart($size, $product_id);
                }
            }

            return $price_charts;
        }

        /**
         * Get all enabled product size
         *
         * @param $product_id
         * @return bool - false if not exists
         * @return array - array of sizes
         */
        public function get_enabled_product_sizes($product_id) {
            return get_field( 'size_list_check', $product_id );
        }

        /**
         * get_sizes_option_data()
         * Get sizes information
         *
         * @return array
         */
        public function get_sizes_option_data() {
            $size_list = array();
            $acf_size_list = get_field('size_list', 'option');
            if ($acf_size_list) {
                foreach ($acf_size_list as $key => $value) {

                    if (!isset($value['inch'])) continue;
                    $size_list[$value['inch']] = array(
                        'size' => $value['inch'],
                        'image' => array(
                            'id' => $value['image']['id'],
                            'url' => $value['image']['url']
                        )
                    );
                }
            }

            return $size_list;
        }


        public function get_settings($settings) {
            $product_sizes = array();
            $products = get_posts(array( 'posts_per_page' => -1, 'post_status' => 'any', 'post_type' => 'product' ));
            if ($products) {
                foreach ($products as $product) {
                    $product_id = $product->ID;
                    $sizes_data = $this->get_sizes_option_data();
                    $sizes = $this->get_enabled_product_sizes($product_id);
                    if (is_array($sizes) && count($sizes) != 0) {
                        $product_sizes[$product_id]['product_ID'] = $product_id;
                        $product_sizes[$product_id]['product_title'] = $product->post_title;
                        $product_sizes[$product_id]['default_size'] = get_field('default_size', $product_id);
                        foreach ($sizes as $size) {
                            $data = isset($sizes_data[$size]) ? $sizes_data[$size] : array();
                            $data['price_chart'] = $this->get_product_price_chart($size, $product_id);
                            ksort($data['price_chart']);
                            $product_sizes[$product_id]['sizes'][$size] = $data;
                        }
                    }

                }
            }
            $settings['products'] = $product_sizes;
            return $settings;
        }

    }
}

return new WBC_Size_Manager();