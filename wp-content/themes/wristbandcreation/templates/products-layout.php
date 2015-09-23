<?php

//Template Name: WC Products Layout

get_header();

echo '<pre>';
print_r($GLOBALS['wbc_settings']->products);
echo '</pre>';

get_footer();