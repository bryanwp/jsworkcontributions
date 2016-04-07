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
			<h2><?php echo get_order_number_format( $order_id ) .' ('. get_status( get_post_meta( $order_id, '_new_status', true ) ) .')'; ?> <a class="edit-order" href="<?php echo home_url('admin-dashboard/?action=order-edit&ID='.$order_id); ?>">Edit</a></h2> 
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
	
	<div class="box col-md-12">
		<span>Send e-mail confirmation for the customer</span>
		<button type="button" class="btn">Send</button>
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
		 	<h3 class="note-title"><?php echo $note['title']; ?></h3>
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

	<div class="admin-tab row">
		<div class="ctab col-md-6 active-tab">customer</div>
		<div class="stab col-md-6">supplier</div>
	</div>
	<div class="admin-tab-content row">
		<!-- Customer Tab Start -->
		<div class="ctab-content col-md-12">
			<div class="artwork-title">
				<h3>For Customer Artwork <a class="save-artwork">Save</a></h3>
			</div>
			<div class="artwork col-md-12">
				<?php 
				$artwork = get_post_meta( $order_id, 'admin_artwork', true );

				if ( $artwork ) { ?>
					<div class="file" style="display: inline;">
						<form id="admin-artwork-form" method="post">
							<?php
								foreach ($artwork as $key => $value) { ?>
								
									<div class="img-holder">
										<span class="remove-file">x</span>
										<img class="img-artwork artw" src="<?php echo $value; ?>">
										<input type="hidden" class="attachment_id" name="img<?php echo $key; ?>" value="<?php echo $value; ?>">
									</div>
								<?php } ?>
							<input id="art-work-count" type="hidden" name="img-count" value="0">
							<input type="hidden" name="form-action" value="admin-artwork">
							<input type="hidden" name="post-id" value="<?php echo $order_id; ?>">
						</form>
						<button class="media-button add-btn">Add Artwork</button>
					</div> <!--container for the upload files-->	
				<?php } else { ?>
					<div class="file">
						<form id="admin-artwork-form" method="post">
							<input id="art-work-count" type="hidden" name="img-count" value="0">
							<input type="hidden" name="form-action" value="admin-artwork">
							<input type="hidden" name="post-id" value="<?php echo $order_id; ?>">
						</form>
						<button class="media-button add-btn">Add Artwork</button>
					</div> <!--container for the upload files-->	
					<center class="no-file">
						<p>
							Add an artwork of the wristband.
						</p>
						<p>
							<button class="media-button" type="submit" name="upload-image">Upload</button>
						</p>
					</center>
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
		<div class="stab-content col-md-12" style="display: none;">
			<div class="artwork-title">
				<h3>Images from Supplier</h3>
			</div>
			<div class="artwork col-md-12">
				<?php 
				$artwork = get_post_meta( $order_id, 'supplier_artwork', true );

				if ( $artwork ) { ?>
					<div class="file" style="display: inline;">
						
							<?php
								foreach ($artwork as $key => $value) { ?>
								
									<div class="img-holder">
										<span class="remove-file">x</span>
										<img class="img-artwork" src="<?php echo $value; ?>">
										<input type="hidden" class="attachment_id" name="img<?php echo $key; ?>" value="<?php echo $value; ?>">
									</div>
								<?php } ?>
							
						<button class="media-button add-btn">Add Artwork</button>
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
