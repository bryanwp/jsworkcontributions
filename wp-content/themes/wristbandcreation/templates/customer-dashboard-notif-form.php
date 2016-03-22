<?php
	$order_id = '';

	if ( isset( $_GET['ID'] ) ) {
		$order_id = $_GET['ID'];
	}
?>
<div class="col-md-10 white">
	<div class="gap-top"></div>
	<div class="dash-title-holder">
		<h2>Send Report for Order# <?php echo $order_id; ?></h2>
	</div>
	<hr class="divider-full" />
	<div class="dash-filter">
		<!-- <span>Filter:</span> -->
	</div>
	<div style="height: 10px"></div>
	<div class="form-group">
		<form method="post">
			<p class="form-row form-row form-row-first">
				<label for="form-title" >Title</label>
				<input id="form-title" type="text" class="input-text title-text" name="report_title">
			</p>
			<p class="form-row form-row form-row-first">
				<div class="text-area">
				<?php
					$editor_id = 'addpost';
					$content = '';
					$settings = array(
						'textarea_name' => 'report_content',
						'media_buttons' => true
					);
					wp_editor( $content, $editor_id, $settings );
				?>
				</div>
			</p>
			<p class="form-button">
				<input type="hidden" name="form-action" value="send-report">
				<input type="hidden" name="order-id" value="<?php echo $order_id ?>">
				<input type="submit" id="profile" class="save-button" name="profile" value="Send Report">
			</p>
		</form>
	</div>
</div>

