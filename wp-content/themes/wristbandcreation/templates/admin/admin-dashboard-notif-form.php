<?php
	$order_id = '';

	if ( isset( $_GET['ID'] ) ) {
		$order_id = $_GET['ID'];
	}
?>
<div class="col-md-12">
	<div class="dash-title-holder">
		<h2>Ask Question</h2>
	</div>
	<hr class="divider-full" />
	<div class="dash-filter">
		<!-- <span>Filter:</span> -->
	</div>
	<div style="height: 10px"></div>
	<div class="form-group">
		<form method="post">
			<p class="form-row form-row form-row-first">
				<div class="text-area">
				<?php
					$editor_id = 'addpost';
					$content = '';
					$settings = array(
						'textarea_name' => 'report_content',
						'media_buttons' => false,
						'tinymce' 		=> false, 
						'quicktags'		=> false,
						'textarea_rows' => 5
					);
					wp_editor( $content, $editor_id, $settings );
				?>
				</div>
			</p>
			<p class="form-button">
				<input type="hidden" name="user" value="<?php echo $user; ?>">
				<input type="hidden" name="form-action" value="send-report">
				<input type="hidden" name="order-id" value="<?php echo $order_id ?>">
				<input type="submit" id="profile" class="save-button" name="profile" value="Send Report">
			</p>
		</form>
	</div>
</div>

