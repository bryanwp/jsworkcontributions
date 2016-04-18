	
	<div class="col-md-12 logcon">
	<!-- <div id="log-con"></div> -->
	<input class="log-date" type="date" name="calendar">
	<button id="set-date" type="button">get</button>
	<textarea class="lined" id="log-con" name="log-text">
		
	</textarea>
	<?php 
		$date = date('Y-m-d');
		if (isset($_GET['log-date'])) {
			$date = $_GET['log-date'];
		}
	?>
	<input type="hidden" id="log-link" name="log" value="/wp-content/themes/wristbandcreation/templates/logs/<?php echo $date; ?>.txt">
	</div>

