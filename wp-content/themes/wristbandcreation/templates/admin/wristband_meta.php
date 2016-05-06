<?php 
$order_id = '';
if ( isset( $_GET['ID'] ) ) {

			$order_id = $_GET['ID'];  
}
$order = new WC_Order( $order_id );
$items = $order->get_items();

// foreach ( $items as $item ) {
//     $wristband_meta = maybe_unserialize( $item['wristband_meta']);
//     $color = $wristband_meta['colors'];

//     echo "<pre>";
//     print_r( $wristband_meta ); 
//     echo "<br />";
// }
//wp_send_email_after_order( $order_id );
// echo "<pre>";
    
    // foreach ($items as $value) {
    // 	print_r( $value['line_subtotal'] );
    // }
// print_r( $items );
// print_r( get_req_info_for_email( $order_id ) ) ;
echo $order_id;

//$args = get_req_info_for_email( $order_id );

// wp_send_email_after_order( $order_id );
if ( isset($_GET['what'])) {
	if ( $_GET['what'] == 'ship' ) {
		// wp_send_email_shipping_confirmation( $order_id );
		echo "shipping";
	} elseif ( $_GET['what'] == 'order' ) {
		// wp_send_email_after_order( $order_id );
		echo "order";
	}
}


die;