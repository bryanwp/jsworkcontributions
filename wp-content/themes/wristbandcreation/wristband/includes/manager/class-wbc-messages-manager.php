<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WBC_Messages_Manager')) {
    class WBC_Messages_Manager extends  WBC_Manager
    {
        public function __construct() {
            add_action('init', array($this, 'register'));

            if (!is_admin()) {
                add_filter( 'wristband_settings_array', array( $this, 'get_settings' ), 20 );
            }
        }

        public function register() {
            $this->register_field_group(array (
                'id' => 'acf_messages-price-list',
                'title' => 'Messages',
                'fields' => array (
                    array (
                        'key' => 'field_55f418e6d8053',
                        'label' => 'Back Message',
                        'name' => '',
                        'type' => 'tab',
                    ),
                    array (
                        'key' => 'field_55f4193fd8057',
                        'label' => 'Back Message',
                        'name' => 'back_message_price_list',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f41946d8058',
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
                                'key' => 'field_55f4195fd805a',
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
                        'key' => 'field_55f418f5d8054',
                        'label' => 'Inside Message',
                        'name' => '',
                        'type' => 'tab',
                    ),
                    array (
                        'key' => 'field_55f4196cd805b',
                        'label' => 'Inside Message',
                        'name' => 'inside_message_price_list',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f4196cd805c',
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
                                'key' => 'field_55f4196cd805d',
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
                        'key' => 'field_55f41900d8055',
                        'label' => 'More than 22 characters in each message',
                        'name' => '',
                        'type' => 'tab',
                    ),
                    array (
                        'key' => 'field_55f41986d805e',
                        'label' => 'More than 22 characters Price List',
                        'name' => 'more_than_22_characters_price_list',
                        'type' => 'repeater',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_55f41998d805f',
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
                                'key' => 'field_55f419a2d8060',
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
                    )
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'wristband-pricing-messages',
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



            $this->register_field_group(array (
                'id' => 'acf_messages',
                'title' => 'Messages',
                'fields' => array (
                    array (
                        'key' => 'field_55f4207337f06',
                        'label' => 'Front',
                        'name' => 'front',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_55f4208a37f07',
                        'label' => 'Wrap Around',
                        'name' => 'wrap_around',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_55f4209637f08',
                        'label' => 'Back',
                        'name' => 'back',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_55f420a337f09',
                        'label' => 'Inside',
                        'name' => 'inside',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'wristband-configuration-messages',
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
            $messages = array();
            $types = array('back_message', 'inside_message', 'more_than_22_characters');
            foreach ($types as $type) {
                $acf_prices = get_field($type. '_price_list', 'option');
                if ($acf_prices) {
                    foreach ($acf_prices as $key => $value) {
                        $messages[$type.'_price_list'][$value['quantity']] = $value['price'];
                    }
                }
            }

            $settings['messages'] = $messages;
            $settings['messages']['message_char_limit'] = WBC_MESSAGE_CHAR_LIMIT;
            $settings['tool_tip_text'] = array(
                'front' => get_field('front', 'option'),
                'wrap_around' => get_field('wrap_around', 'option'),
                'back' => get_field('back', 'option'),
                'inside' => get_field('inside', 'option'),
            );

            return $settings;
        }

    }
}

return new WBC_Messages_Manager();