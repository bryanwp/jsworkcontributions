				</div>  <!-- fusion-row -->
			</div>  <!-- #main -->

			<?php
			global $social_icons;

			if ( strpos( Avada()->settings->get( 'footer_special_effects' ), 'footer_sticky' ) !== FALSE ) {
				echo '</div>';
			}

			// Get the correct page ID
			$c_pageID = Avada::c_pageID();

			// Only include the footer
			if ( ! is_page_template( 'blank.php' ) ) {

				$footer_parallax_class = '';
				if ( Avada()->settings->get( 'footer_special_effects' ) == 'footer_parallax_effect' ) {
					$footer_parallax_class = ' fusion-footer-parallax';
				}

				printf( '<div class="fusion-footer%s">', $footer_parallax_class );

					// Check if the footer widget area should be displayed
					if ( ( Avada()->settings->get( 'footer_widgets' ) && get_post_meta( $c_pageID, 'pyre_display_footer', true ) != 'no' ) ||
						 ( ! Avada()->settings->get( 'footer_widgets' ) && get_post_meta( $c_pageID, 'pyre_display_footer', true ) == 'yes' )
					) {
						$footer_widget_area_center_class = '';
						if ( Avada()->settings->get( 'footer_widgets_center_content' ) ) {
							$footer_widget_area_center_class = ' fusion-footer-widget-area-center';
						}

					?>
						<footer class="fusion-footer-widget-area fusion-widget-area<?php echo $footer_widget_area_center_class; ?>">
                    <div class="fusion-row">
                      <div id="mod-footer0">  


                      <div class="fusion-column-wrapper div--mobile-hide"><div class="accordian fusion-accordian">
                      <div class="panel-group" id="accordion-footer">
                          <div class="fusion-panel panel-default">
                              <div class="panel-heading">
                                  <h4 data-lineheight="30" data-fontsize="14" class="panel-title toggle">
                                      <a class="" data-toggle="collapse" data-parent="#accordion-footer" data-target="#customerhelp" href="#customerhelp">
                                          <div class="fusion-toggle-icon-wrapper">
                                              <i class="fa-fusion-box"></i>
                                          </div>
                                          <div class="fusion-toggle-heading">CUSTOMER HELP</div>
                                      </a>
                                  </h4>
                              </div>
                              <div id="customerhelp" class="panel-collapse collapse" style="height: 0px;">
                                  <div class="panel-body toggle-content">
                                      <div class="textwidget">
                                          <?php //dynamic_sidebar( 'avada-footer-widget-' . 1 );?>
                                          <div class="mod-footer-1">
                                          <dl>
                                          <dt><a href="#">Order Status</a></dt>
                                          <dt><a href="faqs">FAQs</a></dt>
                                          <dt><a href="terms-and-conditions">Terms and Conditions</a></dt>
                                          <dt><a href="contact-us">Contact Us</a></dt>
                                          </dl>
                                          </div>
                                      </div>                
                                  </div>    
                              </div> 
                          </div>
                          <div class="fusion-panel panel-default">
                              <div class="panel-heading">
                                  <h4 data-lineheight="30" data-fontsize="14" class="panel-title toggle">
                                      <a class="" data-toggle="collapse" data-parent="#accordion-footer" data-target="#companyinfo" href="#companyinfo">
                                          <div class="fusion-toggle-icon-wrapper">
                                              <i class="fa-fusion-box"></i>
                                          </div>
                                          <div class="fusion-toggle-heading">COMPANY INFO</div>
                                      </a>
                                  </h4>
                              </div>
                              <div id="companyinfo" class="panel-collapse collapse" style="height: 0px;">
                                  <div class="panel-body toggle-content">
                                      <div class="textwidget">
                                      <div  class="mod-footer-2">
                                      <dl>
                                      <dt><a href="about-us">About Us</a></dt>
                                      <dt><a href="privacy-policy">Privacy Policy</a></dt>
                                      <dt><a href="blog">Blog</a></dt>
                                      <dt><a href="sitemap">Sitemap</a></dt>
                                      </dl>
                                      </div>
                                      </div>                
                                  </div>    
                              </div> 
                          </div>
                          <div class="fusion-panel panel-default">
                              <div class="panel-heading">
                                  <h4 data-lineheight="30" data-fontsize="14" class="panel-title toggle">
                                      <a class="" data-toggle="collapse" data-parent="#accordion-footer" data-target="#sociallinks" href="#sociallinks">
                                          <div class="fusion-toggle-icon-wrapper">
                                              <i class="fa-fusion-box"></i>
                                          </div>
                                          <div class="fusion-toggle-heading">SOCIAL LINKS</div>
                                      </a>
                                  </h4>
                              </div>
                              <div id="sociallinks" class="panel-collapse collapse" style="height: 0px;">
                                  <div class="panel-body toggle-content">
                                      <div class="textwidget">
                      <div class="mod-footer-3">
                      <div class="fusion-social-links social-icons"><div class="fusion-social-networks"><div class="fusion-social-networks-wrapper"><a aria-describedby="tooltip358735" data-original-title="Facebook" class="fusion-social-network-icon fusion-tooltip fusion-facebook fusion-icon-facebook" target="_blank" href="#" style="color:#bebdbd;" data-placement="top" data-title="" data-toggle="tooltip" title=""></a><a aria-describedby="tooltip615409" data-original-title="Twitter" class="fusion-social-network-icon fusion-tooltip fusion-twitter fusion-icon-twitter" target="_blank" href="#" style="color:#bebdbd;" data-placement="top" data-title="" data-toggle="tooltip" title=""></a><a aria-describedby="tooltip101397" data-original-title="Google+" class="fusion-social-network-icon fusion-tooltip fusion-googleplus fusion-icon-googleplus" target="_blank" href="#" style="color:#bebdbd;" data-placement="top" data-title="" data-toggle="tooltip" title=""></a><a aria-describedby="tooltip150128" data-original-title="Linkedin" class="fusion-social-network-icon fusion-tooltip fusion-linkedin fusion-icon-linkedin" target="_blank" href="#" style="color:#bebdbd;" data-placement="top" data-title="" data-toggle="tooltip" title=""></a><a aria-describedby="tooltip7450" data-original-title="Skype" class="fusion-social-network-icon fusion-tooltip fusion-skype fusion-icon-skype" target="_blank" href="#" style="color:#bebdbd;" data-placement="top" data-title="" data-toggle="tooltip" title=""></a></div></div></div>
                      </div>
                                      </div>                
                                  </div>    
                              </div> 
                          </div>
                          <div class="fusion-panel panel-default">
                              <div class="panel-heading">
                                  <h4 data-lineheight="30" data-fontsize="14" class="panel-title toggle">
                                      <a class="" data-toggle="collapse" data-parent="#accordion-footer" data-target="#callus" href="#callus">
                                          <div class="fusion-toggle-icon-wrapper">
                                              <i class="fa-fusion-box"></i>
                                          </div>
                                          <div class="fusion-toggle-heading">CALL US</div>
                                      </a>
                                  </h4>
                              </div>
                              <div id="callus" class="panel-collapse collapse" style="height: 0px;">
                                  <div class="panel-body toggle-content">
                                      <div class="textwidget">
                                          <div  class="mod-footer-4">
                                          <dl>
                                          <dt>Sales</dt>
                                          <dd>Toll Free: 800 400 400</dd>
                                          <dt>Customer Service</dt>
                                          <dd>Toll Free: (626) 771 2182</dd>
                                          <dt>Operation Hours</dt>
                                          <dd>Mon - Fri (24 Hours)</dd>
                                          <dd>Sat - Sun (8am - 5pm)</dd>
                                          </dl>
                                          </div>
                                      </div>                
                                  </div>    
                              </div> 
                          </div>    
                      </div>
                      </div></div>



                      </div>
                      </div>  
							<div class="fusion-row">
								<div id="mod-footer1" class="fusion-columns fusion-columns-<?php echo Avada()->settings->get( 'footer_widgets_columns' ); ?> fusion-widget-area">

									<?php
									// Check the column width based on the amount of columns chosen in Theme Options
									$column_width = 12 / Avada()->settings->get( 'footer_widgets_columns' );
									if( Avada()->settings->get( 'footer_widgets_columns' ) == '5' ) {
										$column_width = 2;
									}

									// Render as many widget columns as have been chosen in Theme Options
									for ( $i = 1; $i < 7; $i++ ) {
										if ( Avada()->settings->get( 'footer_widgets_columns' ) >= $i ) {
											if ( Avada()->settings->get( 'footer_widgets_columns' ) == $i ) {
												echo sprintf( '<div class="fusion-column fusion-column-last col-lg-%s col-md-%s col-sm-%s">', $column_width, $column_width, $column_width );
											} else {
												echo sprintf( '<div class="fusion-column col-lg-%s col-md-%s col-sm-%s">', $column_width, $column_width, $column_width );
											}

												if ( function_exists( 'dynamic_sidebar' ) &&
													 dynamic_sidebar( 'avada-footer-widget-' . $i )
												) {
													// All is good, dynamic_sidebar() already called the rendering
												}
											echo '</div>';
										}
									}								
									?>
									<div class="fusion-clearfix"></div>
								</div> <!-- fusion-columns -->
							<div id="mod-footer2">

                                <div class="fusion-row">

                                  <div class="fusion-columns fusion-column-half fusion-columns-4 fusion-widget-area">
                                    <div class= "fusion-column col-lg-3 col-md-3 col-sm-3 fusion-height-100">
                                      <div class="fusion-column-content">
                                        <script type="text/javascript" language="javascript">var ANS_customer_id="743b0a5c-c1fc-4eb5-a258-61aeca3264e6";</script> <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script>
                                        <img src="https://wristbandcreation.com/wp-content/themes/kulayful/images/PositiveSSL_tl_trans.gif" width="72" height="72">
                                      </div>
                                      
                                      <div style="clear:both;"></div>
                                    </div>

                                     <div class= "fusion-column fusion-column-half col-lg-3 col-md-3 col-sm-3 fusion-height-100">
                                      <div class="fusion-column-content">
                                        <a href="http://www.shopperapproved.com/reviews/wristbandcreation.com/" onclick="var nonwin=navigator.appName!='Microsoft Internet Explorer'?'yes':'no'; var certheight=screen.availHeight-90; window.open(this.href,'shopperapproved','location='+nonwin+',scrollbars=yes,width=620,height='+certheight+',menubar=no,toolbar=no'); return false;" class="mb-10-img"><img src="https://c683207.ssl.cf2.rackcdn.com/13400-r.gif" style="border: 0" alt="" oncontextmenu="var d = new Date(); alert('Copying Prohibited by Law - This image and all included logos are copyrighted by Shopper Approved \251 '+d.getFullYear()+'.'); return false;" /></a>
                                        <a href="https://www.resellerratings.com" onclick="window.open('https://seals.resellerratings.com/landing.php?seller=100333','name','height=760,width=780,scrollbars=1'); 
                                        return false;">
                                        <img style='border:none;' src='//seals.resellerratings.com/seal.php?seller=100333' 
                                        oncontextmenu="alert('Copying Prohibited by Law - ResellerRatings seal is a Trademark of All Enthusiast, Inc.'); return false;" /></a> 
                                      </div>
                                    </div>

                                    <div class="fusion-column fusion-column-half col-lg-3 col-md-3 col-sm-3 fusion-height-100">
                                      <div class="fusion-column-content">
                                        <ul class="center-content">
                                        <li style="float:left;margin-right:10px;"><fb:like href="http://www.facebook.com/WristbandCreation" send="false" layout="button_count" width="50" show_faces="true" stream="true"  font="arial"></fb:like></li>
                                        <li style="float:left;"><div class="g-plusone" data-size="medium" data-annotation="inline" data-width="120"></div></li>
                                      </ul>
                                      </div>
                                    </div>

                                    <div class="fusion-column fusion-column-half col-lg-3 col-md-3 col-sm-3 fusion-height-100">
                                      <div class="fusion-column-content">
                                        <img border="0" src="/wp-content/uploads/instapay.png" style="height: 60px;width: auto;">
                                      </div>
                                    </div>

                                  </div>

                                </div>
								</div>
							</div> <!-- fusion-row -->
						</footer> <!-- fusion-footer-widget-area -->
					<?php
					} // end footer wigets check

					// Check if the footer copyright area should be displayed
					if ( ( Avada()->settings->get( 'footer_copyright' ) && get_post_meta( $c_pageID, 'pyre_display_copyright', true ) != 'no' ) ||
						  ( ! Avada()->settings->get( 'footer_copyright' ) && get_post_meta( $c_pageID, 'pyre_display_copyright', true ) == 'yes' )
					) {

						$footer_copyright_center_class = '';
						if ( Avada()->settings->get( 'footer_copyright_center_content' ) ) {
							$footer_copyright_center_class = ' fusion-footer-copyright-center';
						}
					?>
						<footer id="footer" class="fusion-footer-copyright-area<?php echo $footer_copyright_center_class; ?>">
							<div class="fusion-row">
								<div class="fusion-copyright-content">

									<?php
									/**
									 * avada_footer_copyright_content hook
									 *
									 * @hooked avada_render_footer_copyright_notice - 10 (outputs the HTML for the Theme Options footer copyright text)
									 * @hooked avada_render_footer_social_icons - 15 (outputs the HTML for the footer social icons)
									 */
									do_action( 'avada_footer_copyright_content' );
									?>

								</div> <!-- fusion-fusion-copyright-content -->
							</div> <!-- fusion-row -->
						</footer> <!-- #footer -->
				<?php
				} // end footer copyright area check
				?>
				</div> <!-- fusion-footer -->
				<?php
			} // end is not blank page check
			?>
		</div> <!-- wrapper -->

		<?php
		// Check if boxed side header layout is used; if so close the #boxed-wrapper container
		if ( ( ( Avada()->settings->get( 'layout' ) == 'Boxed' && get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'default' ) || get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'boxed' ) &&
			 Avada()->settings->get( 'header_position' ) != 'Top'

		) {
		?>
			</div> <!-- #boxed-wrapper -->
		<?php
		}

		?>

		<a class="fusion-one-page-text-link fusion-page-load-link"></a>

		<!-- W3TC-include-js-head -->

		<?php
		wp_footer();

		// Echo the scripts added to the "before </body>" field in Theme Options
		echo Avada()->settings->get( 'space_body' );
		?>

		<!--[if lte IE 8]>
			<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/respond.js"></script>
		<![endif]-->
   
	    <script language="JavaScript">  
	        
	        (function(d, s, id) {
	          var js, fjs = d.getElementsByTagName(s)[0];
	          if (d.getElementById(id)) return;
	          js = d.createElement(s); js.id = id;
	          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	          fjs.parentNode.insertBefore(js, fjs);
	        }(document, 'script', 'facebook-jssdk'));
	        
	        (function() {
	            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	            po.src = 'https://apis.google.com/js/plusone.js';
	            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	          })();
	    </script>

	</body>
</html>
