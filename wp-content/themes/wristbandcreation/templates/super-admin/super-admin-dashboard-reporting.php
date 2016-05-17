<?php
	$act = '';
	if ( isset( $_GET['do'] ) ) {
		$act = 'search';
	}
?>
<div class="col-md-12 logcon">
	<div style="margin-top: 20px;">
		<?php the_title( '<h1>', '</h1>' ); ?>
	</div>
	<div class="c-report">
		
		<div class="c-report-form">
			<div class="c-report-title">
				<p>Custrom Search</p>
			</div>
			<form method="get">
				<input type="hidden" name="action" value="Orderlogs">
				<input type="hidden" name="do" value="search">
				<p>
					From Date:
					<input id="search-from" type="date" name="from">
					To Date:
					<input id="search-to" type="date" name="to">
				</p>
				<p>
					<input class="reset-btn" type="button" value="reset">
					<input type="submit" value="Search" class="search-btn">
				</p>
			</form>
		</div>
		<div class="report-tbl table-1">
			<table width="100%" <?php echo ($act == '') ? 'style="display:table"' : 'style="display:none"';?> >
				<thead>
					<th>Reporting</th>
					<th><?php echo date( "F", strtotime("-4 Months") ); ?></th>
					<th><?php echo date( "F", strtotime("-3 Months") ); ?></th>
					<th><?php echo date( "F", strtotime("-2 Months") ); ?></th>
					<th><?php echo date( "F", strtotime("-1 Months") ); ?></th>
					<th><?php echo date( "F" ); ?></th>
				</thead>
				<tbody>
					<tr>
						<td>Customer Count</td>
						<td><?php echo get_reporting_info( 'customer_count', date( "F", strtotime( "-4 Months") ) ); ?></td>
						<td><?php echo get_reporting_info( 'customer_count', date( "F", strtotime( "-3 Months") ) ); ?></td>
						<td><?php echo get_reporting_info( 'customer_count', date( "F", strtotime( "-2 Months") ) ); ?></td>
						<td><?php echo get_reporting_info( 'customer_count', date( "F", strtotime( "-1 Months") ) ); ?></td>
						<td><?php echo get_reporting_info( 'customer_count', date( "F" ) ); ?></td>
					</tr>
					<tr>
						<td>Order Count</td>
						<td><?php echo get_reporting_info( 'order_count', date( "F", strtotime( "-4 Months") ) ); ?></td>
						<td><?php echo get_reporting_info( 'order_count', date( "F", strtotime( "-3 Months") ) ); ?></td>
						<td><?php echo get_reporting_info( 'order_count', date( "F", strtotime( "-2 Months") ) ); ?></td>
						<td><?php echo get_reporting_info( 'order_count', date( "F", strtotime( "-1 Months") ) ); ?></td>
						<td><?php echo get_reporting_info( 'order_count', date( "F" ) ); ?></td>
					</tr>
					<tr>
						<td>Sales Amount</td>
						<td>$<?php echo get_reporting_info( 'sales_amount', date( "F", strtotime( "-4 Months") ) ); ?></td>
						<td>$<?php echo get_reporting_info( 'sales_amount', date( "F", strtotime( "-3 Months") ) ); ?></td>
						<td>$<?php echo get_reporting_info( 'sales_amount', date( "F", strtotime( "-2 Months") ) ); ?></td>
						<td>$<?php echo get_reporting_info( 'sales_amount', date( "F", strtotime( "-1 Months") ) ); ?></td>
						<td>$<?php echo get_reporting_info( 'sales_amount', date( "F" ) ); ?></td>
					</tr>
				</tbody>
			</table>

			<table width="100%" id="search-result" <?php echo ($act == 'search') ? 'style="display:table"' : 'style="display:none"';?> >
				<thead>
					<th>Search Reasult</th>
					<th>From <?php echo ( !empty( $_GET['from'] ) ) ? $_GET['from'] : ''; ?> to <?php echo ( !empty( $_GET['to'] ) ) ? $_GET['to'] : ''; ?></th>
				</thead>
				<tbody>
					<tr>
						<td>Customer Count</td>
						<td><?php echo search_reporting_info( 'customer_count', $_GET['from'], $_GET['to'] ); ?></td>
					</tr>
					<tr>
						<td>Order Count</td>
						<td><?php echo search_reporting_info( 'order_count',  $_GET['from'], $_GET['to'] ); ?></td>
					</tr>
					<tr>
						<td>Sales Amount</td>
						<td>$<?php echo search_reporting_info( 'sales_amount',  $_GET['from'], $_GET['to'] ); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

