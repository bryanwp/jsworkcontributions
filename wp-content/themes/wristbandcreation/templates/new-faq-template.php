<?php 

 //Template Name: New FAQ Template
get_header();

?>
<div class="header-title text-center">
    <h1>Frequently Asked Questions</h1>
</div>
<?php if ( have_posts() ) :
    while ( have_posts() ) : the_post();
    $i = 1;
     ?>
<div class="section-content faq-section">
    <div class="container faq-container">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

        	<?php if( have_rows('frequently_asked_questions') ): ?>
        		<?php while( have_rows('frequently_asked_questions') ): the_row(); $x = 1; ?>
	        		<div class="panel panel-default">
	                <div class="panel-heading" role="tab" id="heading<?php echo $i;?>">
	                    <h4 class="panel-title">
	                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>" aria-expanded="true" aria-controls="collapse1">
	                            <?php the_sub_field('question'); ?>
	                        </a>
	                    </h4>
	                </div>
	                <?php if( !have_rows('more_questions') ): ?>
		                <div id="collapse<?php echo $i;?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $i;?>">
		                    <div class="panel-body">
		                        <p><?php the_sub_field('answer'); ?></p>
		                    </div>
		                </div>
	            	<?php endif; ?>
	                <?php if( have_rows('more_questions') ): ?>
	                	<div id="collapse<?php echo $i;?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $i;?>">
                    		<div class="panel-body">
                    			<div class="panel-group" id="accordionparent">
			        				<?php while( have_rows('more_questions') ): the_row(); ?>
			        					<div class="panel panel-default panel-child-accordion">
			                                <div class="panel-heading">
			                                    <h4 class="panel-title">
			                                        <a data-toggle="collapse" data-parent="#accordion<?php echo $x;?>" href="#collapseInner<?php echo $x;?>">
			                                            <?php the_sub_field('question'); ?>
			                                        </a>
			                                    </h4>
			                                </div>
			                                <div id="collapseInner<?php echo $x;?>" class="panel-collapse collapse">
			                                    <div class="panel-body">
			                                        <p>
			                                            <?php the_sub_field('answer'); ?>
			                                        </p>
			                                    </div>
			                                </div>
			                            </div>
					        		<?php $x++;endwhile; ?>
					        	</div>
		        			</div>
		        		</div>
		        	<?php endif; ?>
		        	</div>
            	<?php $i++; endwhile; ?>
        	<?php endif; ?>
            
        </div>
    </div>
    <?php 
    endwhile;
    endif; ?>
</div>

<?php get_footer(); ?>