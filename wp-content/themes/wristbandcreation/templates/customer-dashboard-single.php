<?php
$order_id = '';
if ( isset( $_GET['ID'] ) ) {
			$order_id = $_GET['ID'];
}

$key = get_post_meta( $order_id, '_order_key', true );
$pay_link = home_url('checkout/order-pay/' . $order_id . '?pay_for_order=true&key=' . $key);
?>
<div class="col-md-10">
	<div class="gap-top"></div>
	<div class="dash-title-holder">
		<h2>Order #<?php echo $order_id; ?></h2>
		<ul>
			<a href="<?php echo $pay_link; ?>"><li>Pay</li></a>
			<li>Reorder</li>
			<li>Reorder And Edit</li>
		</ul>
	</div>
	<div class="dash-filter">
		<span>Filter:</span>
	</div>
	<div class="table-1">
		<?php
		
		
		$order = wc_get_order( $order_id );
?>
		<table width="100%">
			<thead>
				<tr>
					<th><?php _e( 'Product', 'woocommerce' ); ?></th>
					<th><?php _e( 'Total', 'woocommerce' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
		      foreach( $order->get_items() as $item_id => $item ) {
		        wc_get_template( 'order/order-details-item.php', array(
		          'order'   => $order,
		          'item_id' => $item_id,
		          'item'    => $item,
		          'product' => apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item )
		        ) );
		      }
		    ?>
				<?php do_action( 'woocommerce_order_items_table', $order ); ?>
			</tbody>
			<tfoot>
				<?php
		      foreach ( $order->get_order_item_totals() as $key => $total ) {
		        ?>
						<tr>
							<th scope="row"><?php echo $total['label']; ?></th>
							<td><?php echo $total['value']; ?></td>
						</tr>
						<?php
		      }
		    ?>
			</tfoot>
		</table>

		<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

		<?php wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>
	</div>
</div>

