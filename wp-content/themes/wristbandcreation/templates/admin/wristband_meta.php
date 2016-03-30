<?php 
$order_id = '';
if ( isset( $_GET['ID'] ) ) {
			$order_id = $_GET['ID'];  
}
$order = new WC_Order( $order_id );
$items = $order->get_items();

foreach ( $items as $item ) {
    $wristband_meta = maybe_unserialize( $item['wristband_meta']);
    $color = $wristband_meta['colors'];

    echo "<pre>";
    print_r( $wristband_meta );
    echo "<br />";
}
die;