<?php

echo '<pre>';

if (isset($GLOBALS['wbc_settings']->products->{$id})) {
    print_r($GLOBALS['wbc_settings']->products->{$id});

} else {
    echo __("ID: {$id} not exists.");
}



echo '</pre>';