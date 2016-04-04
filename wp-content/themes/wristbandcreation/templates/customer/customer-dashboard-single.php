<?php
$order_id = '';
if ( isset( $_GET['ID'] ) ) {
			$order_id = $_GET['ID'];  
}

$key = get_post_meta( $order_id, '_order_key', true );
$pay_link = home_url('checkout/order-pay/' . $order_id . '?pay_for_order=true&key=' . $key);
//woocommerce_order_again_button( $order ); 
//$order = wc_get_order( $order_id );

$order = new WC_Order( $order_id );
$items = $order->get_items();

// foreach ( $items as $item ) {
//     $wristband_meta = maybe_unserialize( $item['wristband_meta']);
//     $color = $wristband_meta['colors'];

//     echo "<pre>";
//     print_r( $wristband_meta );
//     echo "<br />";
// }
// die;


?>
<div class="col-md-12 white">
	<div class="gap-top">
		<span class="welcome"><?php echo 'Welcome ' . $current_user->user_firstname; ?></span>
	</div>
	<div style="margin-top: 20px;">
			<h2><?php echo get_order_number_format( $order_id ); ?></h2>
	</div>

	<div class="table-1 no-overflow">
		<?php


// echo "<pre>";
// print_r($customer_orders);
// die;

if ( $order ) : 
       
?>
	<div class="order-container">
		<?php foreach ( $items as $item ) {
		    $wristband_meta = maybe_unserialize( $item['wristband_meta']);
		    $color = $wristband_meta['colors'];
		?>
		<div class="details-container">
			<h3><?php echo $item['name']; ?> Wristband</h3>
			<div class="row">
					<div class="col-md-6">
						<table class="tbl-info" width="100%">
							<tr>
								<td>Width:</td>
								<td><?php echo $wristband_meta['size']; ?></td>
							</tr>
							<?php
								$color = $wristband_meta['colors'];
								foreach ($color as $colors) {
									$count = 1;
									$sizes = $colors['sizes'];
									foreach ( $sizes as $size ) {
										if ( $size >= 1 && $count === 1 ) {
											echo '<tr><td>Qty/Color/Size</td><td>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' Adult Size</td></tr>'; 
										} elseif ( $size >= 1 && $count === 2  ) {
											echo '<tr><td>Qty/Color/Size</td><td>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' Medium Size</td></tr>'; 
										} elseif ( $size >= 1 && $count === 3  ) {
											echo '<tr><td>Qty/Color/Size</td><td>' . $size . ' ' . $colors['name'] . ' ' . $colors['type'] . ' Youth Size</td></tr>'; 
										} 
										$count++;
									}
								}
							?>
							<?php
								$options = $wristband_meta['messages'];
								foreach ( $options as $key => $msg ) {
									if ( empty( $msg ) ) {
										$msg = 'None';
									}
									echo '<tr><td>' . $key . ':</td><td>' . $msg . '</td></tr>'; 
								}

							?>
						</table>
					</div>

					<div class="col-md-6">
						<table class="tbl-info" width="100%">
							<?php
								$options = $wristband_meta['additional_options'];
								if ( $options ) {
									foreach ( $options as $option ) {
									echo '<tr><td>Addtional Options</td><td>' . $option . '</td></tr>'; 
									}
								} else {
									echo '<tr><td>Addtional Options</td><td>None</td></tr>'; 
								}
							?>
						</table>
						<table class="tbl-info" width="100%">
							<tr>
								<td>
									Date: 
								</td>
								<td>
									 <?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?>
								</td>
							</tr>
							<tr>
								<td>
									Payment Method: 
								</td>
								<td>
									<?php echo get_post_meta( $order_id, '_payment_method_title', true ); ?>
								</td>
							</tr>
							<tr>
								<td>
									Grand total: 
								</td>
								<td>
									<?php echo $order->get_formatted_order_total(); ?>
								</td>

							</tr>
						</table>
					</div>
				
			</div>
		</div>
		<?php } ?>
	</div>
	<!-- Start Post Order Notes -->
	<div class="artwork-title">
		<h3>Post Order Notes</h3>
		<!-- <a class="edit-notes">Add Note</a> -->
	</div>
	<div class="post-order-notes col-md-12">
		<?php
		 $notes = get_post_meta( $order_id, 'post_order_note', true );

		 if ( $notes ) { 

			foreach( $notes as $note ) {?>

		 <div class="notes">
		 	<h3 class="note-title"><?php echo $note['title']; ?></h3>
		 	<span class="note-date"><?php echo $note['date']; ?></span>
		 	<p class="note-content"><?php echo nl2br( $note['content'] ); ?></p>
		 	<input type="hidden" id="n-title" name="n-title" value="<?php echo $note['title']; ?>">
		 	<input type="hidden" id="n-date" name="n-date" value="<?php echo $note['date']; ?>">
		 	<input type="hidden" id="n-content" name="n-content" value="<?php echo nl2br( $note['content'] ); ?>">
		 </div>
			
		<?php } 
		} ?>
	</div>
	<!-- End Post Order Notes -->

	<?php 
	$approve = get_post_meta( $order_id, 'artwork_approve', true );
	if ( $approve == 'not_approved') {
		$out = '';
		
		$out .='<div class="order-edit col-md-12">';
			$out .='<p class="approval">';
				$out .='Your design is beign updated by the ADMIN and it needs your approval.';
				$out .='<a class="btn app-design">Approve</a>';
			$out .='</p>';
		$out .='</div>';
		$out .='<input type="hidden" id="postid" name="postid" value="'.$order_id.'" >';
		echo $out;
	}

		
	?>
	<div class="artwork col-md-12">
		
				<?php 
				$artwork = get_post_meta( $order_id, 'admin_artwork', true );

				if ( $artwork ) { ?>
					<div class="file" style="display: inline;">
						
					<?php
						foreach ($artwork as $key => $value) { ?>
							<div class="img-holder">
								<img class="img-artwork" src="<?php echo $value; ?>">
								<input type="hidden" class="attachment_id" name="img<?php echo $key; ?>" value="<?php echo $value; ?>">
							</div>
					<?php } ?>
					</div> <!--container for the upload files-->	
				<?php } ?>
			</div>


<?php endif; ?>
	</div>
	<?php 
		$question = get_post_meta( $order_id, '_report_content', true );

		if ( $question ) {
			include ('customer-dashboard-single-report.php'); 
		} else {
			include ('customer-dashboard-notif-form.php'); 
		}
		
	?>
</div>

