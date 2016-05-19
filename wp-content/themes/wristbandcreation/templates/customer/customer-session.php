<?php
//redirect to save session in every order
session_start();
// global $woocommerce; 
if ( isset( $_GET['set-ses'] ) )
	$order_id = $_GET['set-ses'];

$_SESSION['to_order_again'] = $order_id;
$url = '/customer-dashboard/?order_again='.$order_id .'&_wpnonce=' . wp_create_nonce( 'woocommerce-order_again' );
// $escape_url = wp_nonce_url( '/customer-dashboard/?order_again='.$order_id , 'woocommerce-order_again' );
// echo $url;
// die;
?>
<script type="text/javascript">
	window.location.href = "<?php echo $url; ?>";
</script>
<?php 
break;