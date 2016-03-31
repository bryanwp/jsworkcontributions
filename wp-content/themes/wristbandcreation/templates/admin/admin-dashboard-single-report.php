<?php
	$order_id = '';

	if ( isset( $_GET['ID'] ) ) {
		$order_id = $_GET['ID'];
	}
?>

	<div class="dash-title-holder col-md-12">
		<h2>Question <span class="time-ago"><time class="timeago" datetime="<?php echo get_post_meta( $order_id, '_report_time_added', true ); ?>" >asd</time></span></h2>
	</div>
	<hr class="divider-full" />
	<div class="dash-filter">
		<!-- <span>Filter:</span> -->
	</div>
	
	<div class="report-box">

		<p class="report-content">
			<?php echo get_post_meta( $order_id, '_report_content', true ); ?>
		</p>
	</div>
	<div class="reply-container">
		<h3>Replies</h3>
		<div class="comment-list">
			<ul id="reply-list">
				<?php get_comments_list( $order_id ); ?>
			</ul>
		</div>
		<div class="comment-editor" contenteditable>
			<form method="post">
				<?php 
					 $current_user = wp_get_current_user();
				?>
				<textarea class="reply" name="reply" style="margin: 0px; width: 90%; height: 40px;" placeholder="Add Reply..."></textarea>
				<input id="post_id" type="hidden" name="post-id" value="<?php echo $order_id; ?>">
				<input id="name" type="hidden" name="name" value="<?php echo $current_user->display_name  ?>">
				<input class="reply-btn" type="button" name="submit" value="Reply" >
			</form>
		</div>
	</div>



