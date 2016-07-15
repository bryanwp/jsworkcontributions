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
	                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>" aria-expanded="<?php echo ($i == 1) ? 'true' : 'false' ?>" aria-controls="collapse1">
	                            <?php the_sub_field('question'); ?>
	                        </a>
	                    </h4>
	                </div>
	                <?php if( !have_rows('more_questions') ): ?>
		                <div id="collapse<?php echo $i;?>" class="panel-collapse collapse <?php echo ($i == 1) ? 'in' : '' ?>" role="tabpanel" aria-labelledby="heading<?php echo $i;?>">
		                    <div class="panel-body">
		                        <p><?php the_sub_field('answer'); ?></p>
		                    </div>
		                </div>
	            	<?php endif; ?>
	                <?php if( have_rows('more_questions') ): ?>
	                	<div id="collapse<?php echo $i;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $i;?>">
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
            <!-- <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading1">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            General
                        </a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                    <div class="panel-body">
                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                    </div>
                </div>
            </div> -->
            <!-- <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            Customizing Your Wristband
                        </a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                    <div class="panel-body"> -->
                        <!-- Here we insert another nested accordion -->
                        <!-- <div class="panel-group" id="accordionparent">
                            <div class="panel panel-default panel-child-accordion">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion2" href="#collapseInner2">
                                            Can I put my own logo on the wristbands?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseInner2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>
                                            Yes, we have a list of a thousand different colors you can choose from using our Pantone Chart, where we use exact PMS color matching.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-child-accordion">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion3" href="#collapseInner3">
                                            Can you make a specific color that I wanted?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseInner3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>Yes, we have a list of a thousand different colors you can choose from using our Pantone Chart, where we use exact PMS color matching.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-child-accordion">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion4" href="#collapseInner4">
                                            Can I use a specific font that is not specified on your font list?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseInner4" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>Yes, we have a list of a thousand different colors you can choose from using our Pantone Chart, where we use exact PMS color matching.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-child-accordion">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion5" href="#collapseInner5">
                                            What is the inside message?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseInner5" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>Yes, we have a list of a thousand different colors you can choose from using our Pantone Chart, where we use exact PMS color matching.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-child-accordion">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion6" href="#collapseInner6">
                                            What is the maximum number of characters I can place on the wristbands?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseInner6" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>Yes, we have a list of a thousand different colors you can choose from using our Pantone Chart, where we use exact PMS color matching.</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- Inner accordion ends here -->
                    <!-- </div>
                </div>
            </div> -->
            <!-- <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading3">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            Pricing
                        </a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                    <div class="panel-body">
                        <p>
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </p>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading4">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            Payment
                        </a>
                    </h4>
                </div>
                <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                    <div class="panel-body">
                        <p>
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </p>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading5">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            Production
                        </a>
                    </h4>
                </div>
                <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                    <div class="panel-body">
                        <p>
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </p>
                    </div>
                </div>
            </div> -->
            <!-- <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading6">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="false" aria-controls="collapse6">
                            Shipping </a>
                    </h4>
                </div>
                <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                    <div class="panel-body">
                        <p>
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </p>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <?php 
    endwhile;
    endif; ?>
</div>

<?php get_footer(); ?>