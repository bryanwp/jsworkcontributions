<?php 

 //Template Name: New About us Template
get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>


<div class="header-title text-center">
    <h1><?php the_title(); ?></h1>
</div>
<div class="section-content">
    <div class="container">
        <div class="col-md-6 about-wrist-img">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/about-wrist.jpg" alt="">
        </div>
        <div class="col-md-6">
            <div class="about-wrist">
                <p>
                    <?php the_content(); ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="section-content team-section">
    <div class="container">
        <h3>Our Valuable Team Members</h3>
        <ul class="team-holder">
            <?php if( have_rows('members_information') ): ?>
                <?php while( have_rows('members_information') ): the_row(); ?>
                    <li>
                        <div class="team-img">
                            <div class="team--img">
                                <img src="<?php the_sub_field('picture'); ?>" alt="">
                            </div>
                        </div>
                        <div class="team-desc text-center">
                            <h4><?php the_sub_field('name'); ?></h4>
                            <span><?php the_sub_field('position'); ?></span>
                        </div>
                    </li>
                <?php endwhile; ?>
            <?php endif; ?>
            <!-- <li>
                <div class="team-img">
                    <div class="team--img">
                        <img src="images/team-member/02.png" alt="">
                    </div>
                </div>
                <div class="team-desc text-center">
                    <h4>Tinnie Angeles</h4>
                    <span>CFO</span>
                </div>
            </li>
            <li>
                <div class="team-img">
                    <div class="team--img">
                        <img src="images/team-member/03.png" alt="">
                    </div>
                </div>
                <div class="team-desc text-center">
                    <h4>Macoy Bolos</h4>
                    <span>COO</span>
                </div>
            </li>
            <li>
                <div class="team-img">
                    <div class="team--img">
                        <img src="images/team-member/04.png" alt="">
                    </div>
                </div>
                <div class="team-desc text-center">
                    <h4>Julius Robles</h4>
                    <span>Artwork Designer</span>
                </div>
            </li>
            <li>
                <div class="team-img">
                    <div class="team--img">
                        <img src="images/team-member/05.png" alt="">
                    </div>
                </div>
                <div class="team-desc text-center">
                    <h4>Tina Medina</h4>
                    <span>Sales Executive</span>
                </div>
            </li>
            <li>
                <div class="team-img">
                    <div class="team--img">
                        <img src="images/team-member/06.png" alt="">
                    </div>
                </div>
                <div class="team-desc text-center">
                    <h4>Archie Santos</h4>
                    <span>Sales Executive</span>
                </div>
            </li>
            <li>
                <div class="team-img">
                    <div class="team--img">
                        <img src="images/team-member/07.png" alt="">
                    </div>
                </div>
                <div class="team-desc text-center">
                    <h4>Jef Jimenez</h4>
                    <span>Sales Executive</span>
                </div>
            </li>
            <li>
                <div class="team-img">
                    <div class="team--img">
                        <img src="images/team-member/08.png" alt="">
                    </div>
                </div>
                <div class="team-desc text-center">
                    <h4>Sam Moreno</h4>
                    <span>Cart Specialist</span>
                </div>
            </li>
            <li>
                <div class="team-img">
                    <div class="team--img">
                        <img src="images/team-member/09.png" alt="">
                    </div>
                </div>
                <div class="team-desc text-center">
                    <h4>Carla Garcia</h4>
                    <span>Cart Specialist</span>
                </div>
            </li>
            <li>
                <div class="team-img">
                    <div class="team--img">
                        <img src="images/team-member/10.png" alt="">
                    </div>
                </div>
                <div class="team-desc text-center">
                    <h4>Dimple Morales</h4>
                    <span>Cart Specialist</span>
                </div>
            </li> -->
        </ul>
    </div>
</div>
<div class="section-content bg-blue-about">
    <div class="container">
        <h4>Find out more about us and our products! Call us today at <span>(800) 403-8050</span> or send us a message</h4>
        <div class="btn-holder btn-about text-center">
            <a href="<?php echo get_site_url(); ?>/contact-us" class="btn-message">Message Us</a>
            <a href="<?php echo get_site_url(); ?>/new-order-now" class="btn-design">Design My Wristband <i class="fa fa-caret-right" aria-hidden="true"></i></a>
        </div>
    </div>
</div>

<?php 
    endwhile;
    endif; 
    get_footer();
?>