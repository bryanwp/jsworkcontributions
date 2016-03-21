<?php
	$order_id = '';

	if ( isset( $_GET['post-id'] ) ) {
		$order_id = $_GET['post-id'];
	}
?>
<div class="col-md-10">
	<div class="gap-top"></div>
	<div class="dash-title-holder">
		<h2>Report for Order# <?php echo $order_id; ?></h2>
	</div>
	<hr class="divider-full" />
	<div class="dash-filter">
		<!-- <span>Filter:</span> -->
	</div>
	<div style="height: 10px"></div>
	<div class="report-box">
		<h3><?php echo get_post_meta( $order_id, '_report_title', true ); ?> <span class="time-ago">1 hour ago</span></h3>
		<p class="report-content">
			<?php echo get_post_meta( $order_id, '_report_content', true ); ?>
		</p>
	</div>
	<h3>Replies</h3>
	<div class="comment-list">
		<ul>
			<li>
				<div class="single-comment">
					Lorem ipsum dolor sit amet, nam an platonem euripidis, ad mei autem fuisset. Nemore facete ornatus eu mei, an mutat gloriatur quaerendum cum, ne quis voluptaria pri. Id etiam nonumes accommodare per, ne ubique percipit phaedrum vim. Mea tempor numquam in. Eum graecis sadipscing in, ius enim semper iudicabit an. Alia porro mei ei.
				</div>
			</li>
			<li>
				<div class="single-comment">
					Lorem ipsum dolor sit amet, nam an platonem euripidis, ad mei autem fuisset. Nemore facete ornatus eu mei, an mutat gloriatur quaerendum cum, ne quis voluptaria pri. Id etiam nonumes accommodare per, ne ubique percipit phaedrum vim. Mea tempor numquam in. Eum graecis sadipscing in, ius enim semper iudicabit an. Alia porro mei ei.
				</div>
			</li>
		</ul>
	</div>
	<div class="comment-editor">
		<form method="post">
			<textarea name="reply"></textarea>
			<input type="submit" name="reply" value="Reply" >
		</form>
	</div>
</div>

