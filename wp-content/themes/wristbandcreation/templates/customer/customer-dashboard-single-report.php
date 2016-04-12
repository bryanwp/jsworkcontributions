<?php
	$order_id = '';

	if ( isset( $_GET['ID'] ) ) {
		$order_id = $_GET['ID'];
	}
?>

	
		<h3>Replies</h3>
		<div class="comment-list">
			<ul class="reply-list">
				<?php get_comments_list( $order_id, 'notification_admin_user' ); ?>
			</ul>
		</div>
		<div class="comment-editor" contenteditable>
			<form method="post">
				<?php 
					 $current_user = wp_get_current_user();
				?>
				<textarea class="reply" name="reply" style="margin: 0px; width: 90%; height: 40px;" placeholder="Add Reply..."></textarea>
				<input id="user" type="hidden" name="user" value="notification_admin_user">
				<input id="post_id" type="hidden" name="post-id" value="<?php echo $order_id; ?>">
				<input id="name" type="hidden" name="name" value="<?php echo $current_user->display_name  ?>">
				<input class="reply-btn" type="button" name="submit" value="Reply" >
			</form>
		</div>
	



