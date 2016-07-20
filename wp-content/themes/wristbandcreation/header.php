<!DOCTYPE html>
<?php global $woocommerce; ?>
<html class="<?php echo ( Avada()->settings->get( 'smooth_scrolling' ) ) ? 'no-overflow-y' : ''; ?>" <?php language_attributes(); ?>>
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
    } else if ( Avada()->settings->get( 'responsive' ) ) {
        if ( Avada()->settings->get( 'mobile_zoom' ) ) {
            $viewport .= '<meta name="viewport" content="width=device-width, initial-scale=1" />';
        } else {
            $viewport .= '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
        }
    }

    $viewport = apply_filters( 'avada_viewport_meta', $viewport );
    echo $viewport;
    ?>

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
<body>
    <div class="navbar navbar-default navbar-home">
    <nav class="navbar-top">
        <div class="container">
            <div class="nav navbar-nav">
                <p>
                    <i class="fa fa-phone-square" aria-hidden="true"></i>Call (800) 403 - 8050 <span>6AM-8PM (PST), 7 days a week</span>
                </p>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="<?php echo get_site_url(); ?>/my-account">My Account</a>
                </li>
                <li>
                    <a href="#">Register</a>
                </li>
                <li class="active">
                    <a href="<?php echo get_site_url(); ?>/cart"><i class="fa fa-shopping-basket" aria-hidden="true"></i>8</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <nav class="navbar-main">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo get_site_url(); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logonew.png" alt="">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->

            <div class="collapse navbar-collapse navbar-menu-collapse" id="bs-example-navbar-collapse-1">
                <?php
                 // wp_nav_menu( array( 
                 //    'theme_location' => 'header-nav-menu',
                 //    'container_class'       => 'collapse navbar-collapse navbar-menu-collapse',
                 //    'menu_class' => 'nav navbar-nav navbar-right navbar-main-menu'
                 //        ) ); 
                ?>
                <ul class="nav navbar-nav navbar-right navbar-main-menu">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu dropdown-prod">
                            <!-- <li><a href="#">Debossed</a></li>
                            <li><a href="#">Imprinted</a></li>
                            <li><a href="#">Debossed-Fill</a></li>
                            <li><a href="#">Embossed</a></li>
                            <li><a href="#">Embossed-Printed</a></li>
                            <li><a href="#">Dual Layer</a></li>
                            <li><a href="#">Figured</a></li>
                            <li><a href="#">Blank</a></li>
                            <li><a href="#">New! Design your wristband</a></li> -->

                            <?php 
                                $type = 'product';
                                $args=array(
                                  'post_type' => $type);

                                $my_query = new WP_Query($args);
                                // echo '<pre>';
                                // var_dump($my_query);
                                if( $my_query->have_posts() ) {
                                  while ($my_query->have_posts()) : $my_query->the_post();
                                   ?>
                                    <li><a href="#"><?php the_title();?></a></li>
                                    <?php
                                  endwhile;
                                }
                            ?>


                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Customize <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu dropdown-menu">
                            <li><a href="#">Solid</a></li>
                            <li><a href="#">Segmented</a></li>
                            <li><a href="#">Swirl</a></li>
                            <li><a href="#">Glow</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo get_site_url(); ?>/faqs">Faq</a>
                    </li>
                    <li>
                        <a href="<?php echo get_site_url(); ?>/contact-us">Contact Us</a>
                    </li>
                    <li>
                        <a href="<?php echo get_site_url(); ?>/new-order-now" class="btn-orange">Order Now</a>
                    </li>
                </ul>
            </div> 
            <!-- /.navbar-collapse-->
        </nav>
    </div>
</div>
<div id="bodyform" style="overflow:hidden;">





