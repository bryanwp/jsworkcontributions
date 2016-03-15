<!DOCTYPE html>
<?php global $woocommerce; ?>
<html class="<?php echo ( ! Avada()->settings->get( 'smooth_scrolling' ) ) ? 'no-overflow-y' : ''; ?>" <?php language_attributes(); ?>>
<head>
	<?php if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( false !== strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) ) ) : ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<?php endif; ?>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

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

	<?php if ( Avada()->settings->get( 'favicon' ) ) : ?>
		<link rel="shortcut icon" href="<?php echo Avada()->settings->get( 'favicon' ); ?>" type="image/x-icon" />
	<?php endif; ?>

	<?php if ( Avada()->settings->get( 'iphone_icon' ) ) : ?>
		<!-- For iPhone -->
		<link rel="apple-touch-icon-precomposed" href="<?php echo Avada()->settings->get( 'iphone_icon' ); ?>">
	<?php endif; ?>

	<?php if ( Avada()->settings->get( 'iphone_icon_retina' ) ) : ?>
		<!-- For iPhone 4 Retina display -->
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Avada()->settings->get( 'iphone_icon_retina' ); ?>">
	<?php endif; ?>

	<?php if ( Avada()->settings->get( 'ipad_icon' ) ) : ?>
		<!-- For iPad -->
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Avada()->settings->get( 'ipad_icon' ); ?>">
	<?php endif; ?>

	<?php if ( Avada()->settings->get( 'ipad_icon_retina' ) ) : ?>
		<!-- For iPad Retina display -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Avada()->settings->get( 'ipad_icon_retina' ); ?>">
	<?php endif; ?>

	<?php wp_head(); ?>

	<?php

	$object_id = get_queried_object_id();
	$c_pageID  = Avada::c_pageID();
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
		var doc = document.documentElement;
		doc.setAttribute('data-useragent', navigator.userAgent);
	</script>

	<?php echo Avada()->settings->get( 'google_analytics' ); ?>

	<?php echo Avada()->settings->get( 'space_head' ); ?>
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
		
		<div class="fusion-secondary-header">
		</div>

		
		<div id="main" class="clearfix <?php echo $main_class; ?>" style="<?php echo $main_css; ?>">
			<div class="fusion-row" style="<?php echo $row_css; ?>">
		<div class="log-in-logo">
			<a class="fusion-logo-link" href="<?php echo home_url(); ?>">
				<?php $logo_url = Avada_Sanitize::get_url_with_correct_scheme( Avada()->settings->get( 'logo' ) ); ?>
				<img src="<?php echo $logo_url; ?>" width="<?php echo $logo_size['width']; ?>" height="<?php echo $logo_size['height']; ?>" alt="<?php bloginfo( 'name' ); ?>" class="fusion-logo-1x fusion-standard-logo" />
			</a>
		</div>
