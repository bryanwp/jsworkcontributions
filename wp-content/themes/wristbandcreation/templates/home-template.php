<?php 

 //Template Name: Home Template
get_header();
?>
<div>
<?php if ( have_posts() ) :
    while ( have_posts() ) : the_post();
    $cntr = 0;
    $x = 0;
    $i = 0;
     ?>

<div class="banner-section">
    <div class="banner-header text-center">
        <h2>Order 100 wristbands or more and get 100 free!</h2>
    </div>
    <div class="banner-holder">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <!-- <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol> -->
            <!-- Wrapper for slides -->
            <!-- <div class="carousel-inner" role="listbox"> -->
                <!-- <div class="item bg-inline active animatedParent animateOnce" style="background-image: url('images/banner-img.jpg');">
                    <div class="carousel-caption">
                        <p class="animated fadeInLeftShort">Fundraising Campaign</p>
                       <h1 class="animated fadeInRightShort">Lorem Ipsum Dolor Sit Amet</h1>
                    </div>
                </div>
                <div class="item bg-inline animatedParent" style="background-image: url('images/banner-img.jpg');">
                    <div class="carousel-caption">
                        <p class="animated fadeInLeftShort go">Fundraising Campaign</p>
                        <h1 class="animated fadeInRightShort go">Lorem Ipsum Dolor Sit Amet</h1>
                    </div>
                </div>
                <div class="item bg-inline animatedParent" style="background-image: url('images/banner-img.jpg');">
                    <div class="carousel-caption">
                        <p class="animated fadeInLeftShort go">Fundraising Campaign</p>
                        <h1 class="animated fadeInRightShort go">Lorem Ipsum Dolor Sit Amet</h1>
                    </div>
                </div> -->
                <?php if( have_rows('home_banner') ): ?>
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                    <?php while( have_rows('home_banner') ): the_row(); ?>
                       <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i ?>" class="<?php echo ($i == 0) ? 'active' : '' ?>"></li>
                    <?php $cntr++; $i++; endwhile; ?>
                    </ol>
                    <!-- end -->
                    <div class="carousel-inner" role="listbox">
                    <?php while( have_rows('home_banner') ): the_row(); ?>

                        <div class="item bg-inline <?php if($x == 0) { echo 'active'; } else { echo '';}?>" style="background-image: url('<?php the_sub_field('banner_images'); ?>');">
                            <div class="carousel-caption">
                                <p class=""><?php the_sub_field('banner_message'); ?></p>
                                <h1 class=""><?php the_sub_field('banner_header'); ?></h1>
                            </div>
                        </div>
                    <?php $x++; endwhile; ?>
                    </div>
                    
               
                <?php endif; ?>
            <!-- </div> -->

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
<div class="service-section">
    <div class="container">
        <div class="col-md-3 animatedParent animateOnce">
            <div class="service-icon bg-inline animated fadeInUpShort" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/truck.png');"></div>
            <div class="service-label animated fadeInDownShort">
                <p>Get your wristbands in 4 days!</p>
            </div>
        </div>
        <div class="col-md-3 animatedParent animateOnce">
            <div class="service-icon bg-inline animated fadeInUpShort" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/cart.png');"></div>
            <div class="service-label animated fadeInDownShort">
                <p>No minimum order!</p>
            </div>
        </div>
        <div class="col-md-3 animatedParent animateOnce">
            <div class="service-icon bg-inline animated fadeInUpShort" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/customer-service.png');"></div>
            <div class="service-label animated fadeInDownShort">
                <p>24/5 Customer Service</p>
            </div>
        </div>
        <div class="col-md-3 animatedParent animateOnce">
            <div class="service-icon bg-inline animated fadeInUpShort" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/design.png');"></div>
            <div class="service-label animated fadeInDownShort">
                <p>Design your own wristband!</p>
            </div>
        </div>
    </div>
</div>
<div class="wristband-section section-content">
    <div class="container">
        <div class="wristband-header text-center animatedParent animateOnce">
            <h1 class="animated fadeInUpShort"><?php the_title(); ?></h1>
            <p class="animated fadeInDownShort"><?php the_content(); ?></p>
        </div>
        <div class="wristband--holder afterclear animatedParent animateOnce" data-sequence="500">
            <?php 
                $type = 'product';
                $args=array(
                        'post_type' => $type);

                    $my_query = new WP_Query($args);
                        if( $my_query->have_posts() ) {
                            while ($my_query->have_posts()) : $my_query->the_post();
                ?>
                        <div class="col-md-4 animated fadeIn" data-id="1">
                            <a href="">
                                <div class="wristband-img-holder bg-inline" style="background-image: url('<?php echo the_post_thumbnail_url(); ?>'); ">
                                    <div class="wristband-overlay"><i class="fa fa-plus-circle" aria-hidden="true"></i></div>
                                </div>
                                <div class="wristband-desc-holder text-center">
                                    <h3><?php the_title(); ?></h3>
                                    <p>As low as $0.xx</p>
                                    <btn>Customize
                                        <i class="fa fa-caret-right" aria-hidden="true"></i></btn>
                                </div>
                            </a>
                        </div>
            <?php
                        endwhile; }
                        wp_reset_query();            ?>
        </div>
    </div>
</div>
<div class="section-content style-choose bg-blue">
    <div class="container animatedParent animateOnce">
        <div class="col-md-7 animated fadeInRightShort">
            <div class="style-content">
                <h2>Thousand of Styles to Choose From</h2>
                <p>Choose your own style of placing your message on the wristbands? debossed, imprinted, deboss-fill, or embossed. We can put your own logo or any of our 200 stock logos in the wristbands. Choose from a thousand different colors to get that perfect color you need. Choose from a list of over 80 different font styles, or provide us with the font you desire.</p>
                <p>Our wristbands are made out of 100% latex-free silicone rubber. We only use premium high quality rubber, so you are rest assured that these wristbands will last. We are proud to be manufacturers of silicone bracelets since 2005, producing tens of millions of wristbands worldwide!</p>
                <div class="gap-20"></div>
                <a href="<?php echo get_site_url(); ?>/new-order-now">Design my wristband <i class="fa fa-caret-right" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="col-md-5 animated fadeInLeftShort">
            <div class="style-bg bg-inline" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/style-bg.png'); "></div>
        </div>
    </div>
</div>
<div class="section-content section-promotion text-center">
    <div class="container animatedParent animateOnce">
        <h2 class="animated fadeInUpShort">Practical Ideas for Promotional Needs</h2>
        <div class="animated fadeInDownShort">
            <p>These wristbands are perfect for fundraising, events, support for causes, and business promotions. You can have these wristbands made for as low as $0.09 each. These rubber bracelets are one of the most practical ideas for promotional needs.</p>
            <p>Start today by calling <span>(800) 403-8050</span> by speaking to one of our friendly customer representatives to assist you.</p>
        </div>
    </div>
</div>
<div class="section-content client-section">
    <div class="container">
        <h2>Our Clients</h2>
        <div class="owl-carousel" id="owl-demo">
        <?php if( have_rows('clients_images') ): ?>
            <?php while( have_rows('clients_images') ): the_row(); ?>
                <div class="item">
                    <div class="owl-carousel-img bg-inline" style="background-image: url('<?php the_sub_field('images'); ?>');"></div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
            <!-- <div class="item">
                <div class="owl-carousel-img bg-inline" style="background-image: url('images/mercedes-benz.png'); "></div>
            </div>
            <div class="item">
                <div class="owl-carousel-img bg-inline" style="background-image: url('images/walt-disney.png'); "></div>
            </div>
            <div class="item">
                <div class="owl-carousel-img bg-inline" style="background-image: url('images/adobe.png'); "></div>
            </div>
            <div class="item">
                <div class="owl-carousel-img bg-inline" style="background-image: url('images/puma.png'); "></div>
            </div>
            <div class="item">
                <div class="owl-carousel-img bg-inline" style="background-image: url('images/peta.png'); "></div>
            </div>
            <div class="item">
                <div class="owl-carousel-img bg-inline" style="background-image: url('images/3m.png'); "></div>
            </div>
            <div class="item">
                <div class="owl-carousel-img bg-inline" style="background-image: url('images/mercedes-benz.png'); "></div>
            </div>
            <div class="item">
                <div class="owl-carousel-img bg-inline" style="background-image: url('images/walt-disney.png'); "></div>
            </div>
            <div class="item">
                <div class="owl-carousel-img bg-inline" style="background-image: url('images/adobe.png'); "></div>
            </div>
            <div class="item">
                <div class="owl-carousel-img bg-inline" style="background-image: url('images/puma.png'); "></div>
            </div>
            <div class="item">
                <div class="owl-carousel-img bg-inline" style="background-image: url('images/peta.png'); "></div>
            </div>
            <div class="item">
                <div class="owl-carousel-img bg-inline" style="background-image: url('images/3m.png'); "></div> -->
            <!-- </div> -->
        </div>
    </div>
</div>
<div class="section-content review-bg">
    <div class="container">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <!-- <div class="item active">
                    <div class="review-content">
                        <div class="star-rate">
                            <img src="images/stars.png" alt="">
                        </div>
                        <div class="review-desc">
                            <p>Moises R</p>
                            <p>IL, US</p>
                            <p>13 May 2016</p>
                        </div>
                        <h4>“It was easy to do and at a very good price.”</h4>
                    </div>
                </div>
                <div class="item">
                    <div class="review-content">
                        <div class="star-rate">
                            <img src="images/stars.png" alt="">
                        </div>
                        <div class="review-desc">
                            <p>Moises R</p>
                            <p>IL, US</p>
                            <p>13 May 2016</p>
                        </div>
                        <h4>“It was easy to do and at a very good price.”</h4>
                    </div>
                </div> -->
                <div id="rr_ratings_wrapper" style="float:left;"></div>
                  <!--<script>var rr_rating_widget_setup = {'div':"rr_ratings_wrapper"};</script>
                  <script src="https://widget.resellerratings.com/widget/javascript/review/Wristbandcreation_com.js"></script> -->
                  <!-- <div style="min-height: 100px; overflow: hidden;" class="shopperapproved_widget sa_rotate sa_vertical sa_count1 sa_showdate sa_narrow sa_colorBlack sa_borderBlack sa_bgInherit sa_rounded sa_fixed"></div><script type="text/javascript">var sa_interval = 5000;function saLoadScript(src) { var js = window.document.createElement('script'); js.src = src; js.type = 'text/javascript'; document.getElementsByTagName("head")[0].appendChild(js); } if (typeof(shopper_first) == 'undefined') saLoadScript('//www.shopperapproved.com/widgets/testimonial/13400.js'); shopper_first = true; </script> --><!-- <div style="text-align:right;"><a href="http://www.shopperapproved.com/reviews/wristbandcreation.com/" target="_blank" rel="nofollow" onclick="return sa_openurl(this.href);"><img class="sa_widget_footer" alt="" src="https://www.shopperapproved.com/widgets/widgetfooter-darknarrow.png" style="border: 0;"></a></div>
                        </div> -->
                <div class="item active">
                    <div class="review-content">
                        <!-- <div class="star-rate">
                            <img src="images/stars.png" alt="">
                        </div>
                        <div class="review-desc">
                            <p>Moises R</p>
                            <p>IL, US</p>
                            <p>13 May 2016</p>
                        </div>
                        <h4>“It was easy to do and at a very good price.”</h4> -->
                        <div style="min-height: 100px; overflow: hidden;" class="shopperapproved_widget sa_rotate sa_vertical sa_count1 sa_showdate sa_narrow sa_colorBlack sa_borderBlack sa_bgInherit sa_rounded sa_fixed"></div><script type="text/javascript">var sa_interval = 5000;function saLoadScript(src) { var js = window.document.createElement('script'); js.src = src; js.type = 'text/javascript'; document.getElementsByTagName("head")[0].appendChild(js); } if (typeof(shopper_first) == 'undefined') saLoadScript('//www.shopperapproved.com/widgets/testimonial/13400.js'); shopper_first = true; </script>
                    </div>
                </div>

                </div>

        <div class="bg-review-holder afterclear">
            <div class="col-md-4 text-left">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bighand1.png" alt="">
            </div>
            <div class="col-md-4 text-center approve-img">
                <!-- <img src="<?php //echo get_stylesheet_directory_uri(); ?>/images/shop-approve.png" alt=""> -->
                <a href="http://www.shopperapproved.com/reviews/wristbandcreation.com/" target="_blank" rel="nofollow" onclick="return sa_openurl(this.href);"><img class="sa_widget_footer" alt="" src="https://www.shopperapproved.com/widgets/widgetfooter-darknarrow.png" style="border: 0;"></a>
            </div>
            <div class="col-md-4 text-right">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bighand2.png" alt="">
            </div>
        </div>
    </div>
</div>
<?php 
    endwhile;
    endif; ?>
</div>
<?php get_footer(); ?>