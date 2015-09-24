<?php
echo 'Hello World';
echo '<pre>';


if (is_array($arr_ids) && count($arr_ids) != 0) {

    foreach ($arr_ids as $product_id) {
        $product_id = trim($product_id);
        if (isset($GLOBALS['wbc_settings']->products->{$product_id})) {
            print_r($GLOBALS['wbc_settings']->products->{$product_id});

        } else {
            echo '<p>'.__("ID: {$id} not exists."). '</p>';
        }
    }

}

echo '</pre>';