<?php
session_start();

if ( is_page('customer-dashboard') ) {
	global $woocommerce; 
	do_action('wc_order_edit');
}
// $actual_link = $_SERVER[REQUEST_URI];
// echo define('requestURIWithoutParametr',parse_url( requestURIfromHome, PHP_URL_PATH ) );
// die;
if ( ! is_page( 'login' ) || ! is_page( 'register' ) ) {

	$role = "";
	if ( isset( $_SESSION['role'] ) ) {
		$role = $_SESSION['role'];
	} else {
		if ( current_user_can( 'manage_options' ) ) {
			$role = 'admin';
		} else {
			$role = 'customer';
		}
	}

	$role = strtolower( $role );

	if ( is_page( 'employee-dashboard' ) ) {
		if ( $role != 'employee' && ! current_user_can( 'manage_options' ) ) {
			wp_redirect( home_url( $role . '-dashboard' ) );
			// echo $role;
			// exit;
		}
	} elseif ( is_page( 'supplier-dashboard' ) ) {
		if ( $role != 'supplier' && ! current_user_can( 'manage_options' ) ) {
			wp_redirect( home_url( $role . '-dashboard' ) );
			// echo $role;
			// exit;
		}
	} elseif ( is_page( 'customer-dashboard' ) ) {
		if ( $role != 'customer' && ! current_user_can( 'manage_options' ) ) {
			// wp_redirect( home_url( $role . '-dashboard' ) );
			// echo $role;
			// exit;
		}
	} elseif ( is_page( 'admin-dashboard' ) ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_redirect( home_url( $role . '-dashboard' ) );
			// echo $role;
			// exit;
		}
	}
}
?>

<!DOCTYPE html>
<html class="<?php echo ( ! Avada()->settings->get( 'smooth_scrolling' ) ) ? 'no-overflow-y' : ''; ?>" <?php language_attributes(); ?>>
<head>
	<?php
	if ( ! function_exists( '_wp_render_title_tag' ) ) {
		function avada_render_title() {
		?>
			<title><?php wp_title( '' ); ?></title>
		<?php
		}
		add_action( 'wp_head', 'avada_render_title' );
	}
	?>

	<!--[if lte IE 8]>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
	<![endif]-->

	<?php $isiPad = (bool) strpos( $_SERVER['HTTP_USER_AGENT'],'iPad' ); ?>

	<?php
	$viewport = '';
	if ( Avada()->settings->get( 'responsive' ) && $isiPad ) {
		$viewport = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
	} else if( Avada()->settings->get( 'responsive' ) ) {
		if ( Avada()->settings->get( 'mobile_zoom' ) ) {
			$viewport .= '<meta name="viewport" content="width=device-width, initial-scale=1" />';
		} else {
			$viewport .= '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
		}
	}

	$viewport = apply_filters( 'avada_viewport_meta', $viewport );
	echo $viewport;
	?>
	
	<?php // if ( Avada()->settings->get( 'favicon' ) ) : ?>
		<!-- <link rel="shortcut icon" href="<?php // echo Avada()->settings->get( 'favicon' ); ?>" type="image/x-icon" /> -->
	<?php //endif; ?>

	<?php
		remove_scripts();
		wp_head();
	?>

	<?php

	// $object_id = get_queried_object_id();
	// $c_pageID  = Avada::c_pageID();
	?>

	<!--[if lte IE 8]>
	<script type="text/javascript">
	jQuery(document).ready(function() {
	var imgs, i, w;
	var imgs = document.getElementsByTagName( 'img' );
	for( i = 0; i < imgs.length; i++ ) {
		w = imgs[i].getAttribute( 'width' );
		imgs[i].removeAttribute( 'width' );
		imgs[i].removeAttribute( 'height' );
	}
	});
	</script>

	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/excanvas.js"></script>

	<![endif]-->

	<!--[if lte IE 9]>
	<script type="text/javascript">
	jQuery(document).ready(function() {

	// Combine inline styles for body tag
	jQuery('body').each( function() {
		var combined_styles = '<style type="text/css">';

		jQuery( this ).find( 'style' ).each( function() {
			combined_styles += jQuery(this).html();
			jQuery(this).remove();
		});

		combined_styles += '</style>';

		jQuery( this ).prepend( combined_styles );
	});
	});
	</script>

	<![endif]-->

	<script type="text/javascript">
		// var doc = document.documentElement;
		// doc.setAttribute('data-useragent', navigator.userAgent);
	</script>

	<?php echo Avada()->settings->get( 'google_analytics' ); ?>

	<?php // echo Avada()->settings->get( 'space_head' ); ?>

</head>
<?php
$wrapper_class = '';


if ( is_page_template( 'blank.php' ) ) {
	$wrapper_class  = 'wrapper_blank';
}

if ( 'modern' == Avada()->settings->get( 'mobile_menu_design' ) ) {
	$mobile_logo_pos = strtolower( Avada()->settings->get( 'logo_alignment' ) );
	if ( 'center' == strtolower( Avada()->settings->get( 'logo_alignment' ) ) ) {
		$mobile_logo_pos = 'left';
	}
}

?>
<body <?php body_class(); ?>>
	<?php do_action( 'avada_before_body_content' ); ?>
	<?php $boxed_side_header_right = false; ?>
	
	<div id="wrapper" class="<?php echo $wrapper_class; ?>">
		<div id="home" style="position:relative;top:1px;"></div>
		
		<div class="min-height fusion-secondary-header">
			<div class="log-in-logo">
				<a class="fusion-logo-link" href="<?php echo home_url(); ?>">
					<?php $logo_url = Avada_Sanitize::get_url_with_correct_scheme( Avada()->settings->get( 'logo' ) );?>
					<img src="<?php echo $logo_url['url']; ?>" width="<?php echo $logo_size['width']; ?>" height="<?php echo $logo_size['height']; ?>" alt="<?php bloginfo( 'name' ); ?>" class="fusion-logo-1x fusion-standard-logo" />
				</a>
			</div>
			<div class="welcome">
			<?php
				if ( is_page( 'login' ) ) {
				?>
					<div class="nav-wrap">
						<ul class="dash-custom-nav">
							<li><a class="nav-a <?php echo $orders; ?>" href="<?php echo home_url('register'); ?>">Register</a></li>
						</ul>
					</div>
				<?php
				} elseif ( is_page( 'register' ) ) { 
					?>
						<div class="nav-wrap">
							<ul class="dash-custom-nav">
								<li><a class="nav-a <?php echo $orders; ?>" href="<?php echo home_url('login'); ?>">Login</a></li>
							</ul>
						</div>
					<?php
				} else {
					$current_user = wp_get_current_user();
					$role = get_user_meta( $current_user->ID, 'custom_role', true );

					$orders  = "dash-active"; $profile = "";
					$profile = ""; $Orderlogs ="";

					if ( isset( $_GET['action'] ) ) {
						if ( $_GET['action'] == 'profile' ) {
							$create = "";
							$orders  = "";
							$profile = "dash-active";
							$Orderlogs = "";
						} elseif ( $_GET['action'] == 'create' ) {
							$create = "dash-active";
							$orders  = "";
							$profile = "";
							$Orderlogs = "";
						} elseif ( $_GET['action'] == 'Orderlogs' ) {
							$create = "";
							$orders  = "";
							$profile = "";
							$Orderlogs = "dash-active";
						} else {
							$create = "";
							$orders  = "dash-active";
							$profile = "";
							$Orderlogs = "";
						}
					}

					if ( current_user_can( 'manage_options' ) ) { ?>

						<div class="nav-wrap">
							<ul class="dash-custom-nav">
								<li><a class="nav-a <?php echo $orders; ?>" href="<?php echo home_url('admin-dashboard'); ?>">All Orders</a></li>
								<li><a class="nav-a <?php echo $profile; ?>" href="<?php echo home_url('admin-dashboard/?action=profile'); ?>">Profile</a></li>
								<li><a class="nav-a <?php echo $create; ?>" href="<?php echo home_url('admin-dashboard/?action=create'); ?>">Create Account</a></li>
								<li><a class="nav-a <?php echo $Orderlogs; ?>" href="<?php echo home_url('admin-dashboard/?action=Orderlogs'); ?>">Order Logs</a></li>
								<li><a class="nav-a <?php echo $log; ?>" href="<?php echo home_url('admin-dashboard/?action=log'); ?>">View Logs</a></li>
								<li><a id="logout" class="nav-a" href="#"><?php echo logout_user(); ?>Log out</a></li>
								<!-- <li>Log out</li> -->
							</ul>
						</div>

					<?php } else {

						if ( ! $role ) { ?>

						<div class="nav-wrap">
							<ul class="dash-custom-nav">
								<li><a class="nav-a <?php echo $orders; ?>" href="<?php echo home_url('customer-dashboard'); ?>">My Orders</a></li>
								<li><a class="nav-a <?php echo $profile; ?>" href="<?php echo home_url('customer-dashboard/?action=profile'); ?>">Profile</a></li>
								<li><a id="logout" class="nav-a" href="#"><?php echo logout_user(); ?>Log out</a></li>
							</ul>
						</div>
						<?php }	elseif ( $role == 'Supplier' ) { ?>
							<div class="nav-wrap">
								<ul class="dash-custom-nav">
									<li><a class="nav-a <?php echo $orders; ?>" href="<?php echo home_url('supplier-dashboard'); ?>">All Orders</a></li>
									<li><a class="nav-a <?php echo $profile; ?>" href="<?php echo home_url('supplier-dashboard/?action=profile'); ?>">Profile</a></li>
									<li><a id="logout" class="nav-a" href="#"><?php echo logout_user(); ?>Log out</a></li>
								</ul>
							</div>
						<?php } elseif ($role == 'Employee') { ?>
							<div class="nav-wrap">
								<ul class="dash-custom-nav">
									<li><a class="nav-a <?php echo $orders; ?>" href="<?php echo home_url('employee-dashboard'); ?>">All Orders</a></li>
									<li><a class="nav-a <?php echo $profile; ?>" href="<?php echo home_url('employee-dashboard/?action=profile'); ?>">Profile</a></li>
									<li><a id="logout" class="nav-a" href="#"><?php echo logout_user(); ?>Log out</a></li>
								</ul>
							</div>
						<?php }
					}
					// echo '<p>WELCOME ' . $current_user->user_firstname . ' | <a href=' . wp_logout_url( $redirect ) . '>Log out</a></p>' ;
				}
				
			?>
			</div>
		</div>

		
		<div id="main" class="clearfix <?php echo $main_class; ?>" style="<?php echo $main_css; ?>">
			<div class="fusion-row" style="<?php echo $row_css; ?>">
		<div class="gap"></div>
		<div class="sub-container">