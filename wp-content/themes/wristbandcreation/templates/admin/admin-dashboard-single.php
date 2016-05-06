	<?php
$order_id = '';
if ( isset( $_GET['ID'] ) ) {
			$order_id = $_GET['ID'];  
} 

	
	// $args = array(
	// 	'full_name' => 'Jon Snow Man',
	// 	'order_name' => 'wristband',
	// 	'order_id' => $order_id,
	// 	'arrival' => 'Friday, April 29',
	// 	'sub_total' => '10.00',
	// 	'tax' => '2.00',
	// 	'total' => '12.00',
	// 	'tack_link' => 'https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=' . get_post_meta( $order_id, 'supplier_trackingnumber', true ),
	// 	'email' => 'philwebservices.alag@gmail.com'
	// 	);
// echo send_email_shipped_confirmation( $args );
//wp_send_email_after_order( $args );
   // wp_send_email_shipping_confirmation( $args );
// die;

$key = get_post_meta( $order_id, '_order_key', true );
$pay_link = home_url('checkout/order-pay/' . $order_id . '?pay_for_order=true&key=' . $key);
//woocommerce_order_again_button( $order ); 
//$order = wc_get_order( $order_id );
$upimage = get_post_meta($order_id, 'Employee_artwork', TRUE);
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
			<h2><?php echo get_order_number_format( $order_id ) .' ('. get_status( get_post_meta( $order_id, '_new_status', true ) ) .')'; ?> <a class="edit-order" href="<?php echo home_url('admin-dashboard/?action=order-edit&ID='.$order_id); ?>">Edit</a></h2> 
	</div>

	<div class="table-1 no-overflow">
		<?php


// echo "<pre>";
// print_r($customer_orders);
// die;

if ( $order ) : 
     echo do_shortcode('[the-cart-meta item_key="'.$order_id.'"]');  
?>	
	
	<div class="box col-md-12">
		<?php
		$track = get_post_meta( $order_id, 'supplier_trackingnumber', true );
		if ( $track ) {
			echo '<p class="t-no">Tracking Number: '.$track.'</p>';
			echo '<a href="https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=' . $track .'" > here </a>';
		} else {
			echo '<p class="t-no">Tracking Number: Waiting for the supplier.</p>';
		}
		?>
		
		<!-- <span>Send e-mail confirmation for the customer</span> -->
		<?php
		$qty = get_post_meta($order_id, 'supplier_wpqty', TRUE); 
		if ( $qty ) {
			do_action('supplier_pricing', $order_id); 
		}
		?>
	</div>
	
	

	<div class="artwork-title">
		<h3>Post Order Notes <a class="add-note btn">Add Note</a></h3>
		<!-- <a class="edit-notes">Add Note</a> -->
	</div>
	<div class="post-order-notes col-md-12">
		<?php
		 $notes = get_post_meta( $order_id, 'post_order_note', true );
		 if ( $notes ) { 

			foreach( $notes as $note ) {?>

		 <div class="notes">
		 	<span class="note-date"><?php echo $note['date']; ?></span>
		 	<p class="note-content"><?php echo nl2br( $note['content'] ); ?></p>
		 	<input type="hidden" id="n-title" name="n-title" value="<?php echo $note['title']; ?>">
		 	<input type="hidden" id="n-date" name="n-date" value="<?php echo $note['date']; ?>">
		 	<input type="hidden" id="n-content" name="n-content" value="<?php echo nl2br( $note['content'] ); ?>">
		 </div>
			
		<?php } 
		} else {?>
		<div class="notes add-note-holder">
			<center class="no-file">
				<p>
					Add Notes
				</p>
				<p>
					<button class='add-note' type='submit' name='upload-image'>Add</button>
				</p>
			</center>
		</div>
		<?php } ?>
	</div>



	
<?php endif; ?>
	</div>
	<div class="admin-tab-content row">
		<!-- Customer Tab Start -->
		<div class="ctab-content tc-box col-md-6">
			<div class="artwork-title">
				<h3>For Customer Artwork</h3>
			</div>
			<div class="artwork col-md-12">
				<?php 
					if ( !$upimage) { 
						?>

						<form method="post" enctype="multipart/form-data">
							<div class="file-supp" style="display: inline;">
								Select image to upload:
								<input type="file" accept="image/*" class="save-button-design" name="newupload_image[]" id="newupload_image" multiple="multiple">
								<input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
								<input type="submit"  class="save-button-design"  value="Upload Image" name="up-image">
							</div> 
						</form>
						<?php       
					} else {
						?>
						<form  method="post" enctype="multipart/form-data">
							<div class="artwork-title">
								<input type="submit" class="save-button-design" name="supp_update_artwork" value="Update">
							</div>
							<div class="file-supp" style="display: inline;">
								<div class="fpost-img">
									<?php 
									$i = 0;
									foreach ($upimage as $key => $value) {
										$i++;
										?>

										<div class="img-holder">
											<span class="remove-file-img">x</span>

											<img class="img-artwork" name="image-url" src="<?php echo $value['url']; ?>">
											<input type="hidden" class="attachment_id" name="img-file_<?php echo $i;?>" value="<?php echo $value['file']; ?>">
											<input type="hidden" class="attachment_id" name="img-url_<?php echo $i;?>" value="<?php echo $value['url']; ?>">   
											<input type="hidden" class="attachment_id" name="img-type_<?php echo $i;?>" value="<?php echo $value['type']; ?>">
										</div>
										<?php } ?>
										<img id="imageprev" src="" alt=""  />
									</div>
									<input type="file" name="add_image" accept="image/*" id="add_image">
									<input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
								</div>
							</form>
							<?php } ?>
			</div>
			<?php 
				$question = get_post_meta( $order_id, 'customer_report_content', true );

				if ( $question ) { ?>
					<div class="dash-title-holder col-md-12">
						<h2>Customer Question <span class="time-ago"><time class="timeago" datetime="<?php echo get_post_meta( $order_id, 'customer_report_time_added', true ); ?>" >asd</time></span></h2>
					</div>
				<?php
					$user = "notification_admin_user"; 
					include ('admin-dashboard-single-report.php'); 
				}
			?>
		</div> 
		<!-- Customer Tab end -->
		
		<!-- Supplier Tab Start -->
		<div class="stab-content tc-box col-md-6">
			<div class="artwork-title">
				<h3>Images from Supplier</h3>
			</div>
			<div class="artwork col-md-12">
				<?php 
				$artwork = get_post_meta( $order_id, 'Supplier_artwork', true );
				// var_dump($artwork);
				if ( $artwork ) { ?>
					<div class="file" style="display: inline;">
						
							<?php
								foreach ($artwork as $key => $value) { ?>
								
									<div class="img-holder">
										<img class="img-artwork" src="<?php echo $value['url']; ?>">
										<!-- <input type="hidden" class="attachment_id" name="img<?php echo $key; ?>" value="<?php echo $value; ?>"> -->
									</div>

								<?php } ?>
					</div> <!--container for the upload files-->	
				<?php } else { ?>
					<center class="no-file">
						<p>
							Pending Supplier Artwork Upload.
						</p>
						<span>(Waiting for the supplier)</span>
					</center>
				<?php } ?>
			</div>
			<?php 
				$question = get_post_meta( $order_id, 'supplier_report_content', true );

				if ( $question ) { ?>
					<div class="dash-title-holder col-md-12">
						<h2>Supplier Question <span class="time-ago"><time class="timeago" datetime="<?php echo get_post_meta( $order_id, 'supplier_report_time_added', true ); ?>" >asd</time></span></h2>
					</div>
				<?php
					$user = "notification_admin_supplier";
					include ('admin-dashboard-single-report.php'); 
				}
			?>
		</div>
		<!-- Supplier Tab End -->
	
	</div>

</div>
<div class="col-md-12" style="height: 20px;"></div>
