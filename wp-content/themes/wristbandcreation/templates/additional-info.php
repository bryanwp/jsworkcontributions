<?php 

 //Template Name: New Additional Info Template
get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>

<div class="section-tabs terms section-content">
		<div class="container">
			<div class="col-md-3"> <!-- required for floating -->
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs tabs-left"><!-- 'tabs-right' for right tabs -->
			    <li class="active"><a href="#privacy" data-toggle="tab">Privacy Policy</a></li>
			    <li><a href="#terms-condition" data-toggle="tab">Terms & Conditions</a></li>
			    <li><a href="#sitemap" data-toggle="tab">Sitemap</a></li>
			  </ul>
			</div>
			<div class="col-md-9">
			    <!-- Tab panes -->
			    <div class="tab-content">
			      <div class="tab-pane active" id="privacy">
			      	<h1>Privacy & Policy</h1>
			      	<?php the_field('privacy_policy_field'); ?>
					<!-- <p>This Privacy Policy governs the manner in which Wristband Creation collects, uses, maintains and discloses information collected from users (each, a “User”) of the www.wristbandcreation.com website (“Site”). This privacy policy applies to the Site and all products and services offered by Writstband Creation.</p> <br>

					<p class="parag-title">Personal Identification Information</p>
					<p>We may collect personal identification information from Users in a variety of ways, including, but not limited to, when Users visit our site, register on the site, place an order, subscribe to the newsletter, fill out a form, and in connection with other activities, services, features or resources we make available on our Site. Users may be asked for, as appropriate, name, email address, mailing address, phone number, credit card information. Users may, however, visit our Site anonymously. We will collect personal identification information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personally identification information, except that it may prevent them from engaging in certain Site related activities.</p> <br>

					<p class="parag-title">Non-personal Identification Information</p>
					<p>We may collect non-personal identification information about Users whenever they interact with our Site. Non-personal identification information may include the browser name, the type of computer and technical information about Users means of connection to our Site, such as the operating system and the Internet service providers utilized and other similar information.</p> <br>

					<p class="parag-title">Web Browser Cookies</p>
					<p>Our Site may use “cookies” to enhance User experience. User’s web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them. User may choose to set their web browser to refuse cookies, or to alert you when cookies are being sent. If they do so, note that some parts of the Site may not function properly.</p> <br>

					<p class="parag-title">How We Use Collected Information</p>
					<p>Wristband Creation may collect and use Users personal information for the following purposes:</p>
					  <br>

					<ul class="lists">
						<li>To improve customer service 
							<span>Information you provide helps us respond to your customer service requests and support needs more efficiently.</span>
						</li>
						<li>To personalize user experience
							<span>We may use information in the aggregate to understand how our Users as a group use the services and resources provided on our Site.</span>
						</li>
						<li>To improve our Site
							<span> We may use feedback you provide to improve our products and services.</span>
						</li>
						<li>To process payments
							<span>We may use the information Users provide about themselves when placing an order only to provide service to that order. We do not share this information with outside parties except to the extent necessary to provide the service.</span>
						</li>
						<li>To run a promotion, contest, survey or other Site feature
							<span>To send Users information they agreed to receive about topics we think will be of interest to them.</span>
						</li>
						<li>To send periodic emails
							<span>We may use the email address to send User information and updates pertaining to their order. It may also be used to respond to their inquiries, questions, and/or other requests. If User decides to opt-in to our mailing list, they will receive emails that may include company news, updates, related product or service information, etc. If at any time the User would like to unsubscribe from receiving future emails, we include detailed unsubscribe instructions at the bottom of each email or User may contact us via our Site.</span>
						</li>
					</ul>

					<p class="parag-title">How we protect your information</p>
					<p>We adopt appropriate data collection, storage and processing practices and security measures to protect against unauthorized access, alteration, disclosure or destruction of your personal information, username, password, transaction information and data stored on our Site. Sensitive and private data exchange between the Site and its Users happens over a SSL secured communication channel and is encrypted and protected with digital signatures.
						<br>

					<p class="parag-title">Sharing Your Personal Information</p>
					<p>We do not sell, trade, or rent Users personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners, trusted affiliates and advertisers for the purposes outlined above.We may use third party service providers to help us operate our business and the Site or administer activities on our behalf, such as sending out newsletters or surveys. We may share your information with these third parties for those limited purposes provided that you have given us your permission.</p>
					  <br>

					<p class="parag-title">Changes to this Privacy Policy</p>
					<p>Wristband Creation has the discretion to update this privacy policy at any time. When we do, we will revise the updated date at the bottom of this page. We encourage Users to frequently check this page for any changes to stay informed about how we are helping to protect the personal information we collect. You acknowledge and agree that it is your responsibility to review this privacy policy periodically and become aware of modifications.</p>
					  <br>

					<p class="parag-title">Your Acceptance of these Terms</p>
					<p>By using this Site, you signify your acceptance of this policy and terms of service. If you do not agree to this policy, please do not use our Site. Your continued use of the Site following the posting of changes to this policy will be deemed your acceptance of those changes.</p>
					  <br>

					<p class="parag-title">Contacting Us</p>
					<p>If you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us at:</p>
					  <br>

					
					<ul class="contact">
						<li>Wristband Creation</li>
						<li>4416 W. Verdugo Ave.
						Burbank, CA 91505
						United States</li>
						<li>(800) 403-8050</li>
						<li>feedback@wristbandcreation.com</li>
					</ul>

					<p>This document was last updated on January 02, 2015</p> -->

			      </div>

			      <div class="tab-pane" id="terms-condition">
			      	<h1>Terms & Conditions</h1>

			      	<?php if( have_rows('terms_field') ): ?>
		            	<?php while( have_rows('terms_field') ): the_row(); ?>
		            		<p class="parag-title"><?php the_sub_field('title'); ?></p>
			      			<p><?php the_sub_field('content'); ?></p><br>
						<?php endwhile; ?>
		        	<?php endif; ?>

			      	<!-- <p class="parag-title">Payment Method and Policies</p>
			      	<p>We accept payments in the form of Major Credit Cards (Visa, MasterCard, Discover, and American Express), Money Orders, PayPal, Bank Wire Transfers, and Checks only. We will not accept any other forms of payment other than listed above. We do not ship orders COD. We are not responsible for delays in order processing due to declined credit cards or waiting for PayPal payments to clear. For all orders shipped to California, we will add a 9% sales tax on top of the total order amount.</p>
					  <br>

			      	<p class="parag-title">Shipping and Handling Policy</p>
			      	<p>We do not ship on Saturday, Sunday and holidays. Once payment for your order has been verified, your order will begin processing. Expected arrival assumes that processing or production is not delayed. Guaranteed delivery assurance assumes that there is no delay. Reasons for delays include waiting for payment to clear, artwork, or custom color bands. We will also not be liable with delays on shipments by 3rd party shipping couriers or customs, which invalidates our guaranteed shipping assurance. The turnaround count time of the bracelets starts on the same day if the order was placed before 11am PST, and may start on the next day if placed after 11am.</p>

			      	<p>We will not be responsible for any lost shipments or damaged goods due to shipping couriers, unless shipping insurance was availed. For any shipment that was returned to us due to an incorrect address or refused package, we will charge a fixed cost of $20 to ship the item again to another address.</p>

			      	<p>“Days” are referred to business days. If in a situation that we fail to deliver the bands in time, then we shall issue a credit based on the difference of the actual rush shipping method that was met.</p>

			      	<p>If you have any questions regarding the status of your order, you may email your inquiry at info@wristbandcreation.com.</p>
					  <br>

			      	<p class="parag-title">International Shipping Policy</p>
			      	<p>Shipping time does not include any time your order might be delayed going through customs. We are not responsible for delays in shipment due to customs or other international shipping delays.</p>
			      	<p>Orders that ship internationally to other countries besides Canada will usually incur additional taxes, duties, VAT, and other fees associated with customs. We are not responsible for these charges and they are the sole responsibility of the recipient. Please verify or get an estimate of what these charges might be before placing an international order. All shipping charges on our Web site include only the cost of shipping the order. All taxes, duties, and other fees charged are not included in the shipping charges on our Web site and are the sole responsibility of the recipient.</p>
					  <br>

			      	<p class="parag-title">Copyright and Infringements</p>
			      	<p>We will not be held liable of any copyrights or infringements issues. It is the duty of the customer to make sure that the bracelet will not infringe any other company’s rights.</p>
					  <br>

			      	<p class="parag-title">Production Quality</p>
			      	<p>Proofs/artworks only illustrate a digital mock-up of the actual bracelets produced for reference to the customer. The actual bracelets produced may not fully represent the proof, since this is only a representation. We shall base the actual produced bracelets on the wristband details on the invoice, agreed upon the customer. For any production flaws or mistakes on our side, we will be happy to reproduce the wristbands at no additional cost, as long as this will be claimed within 10 days of receiving the wristbands.</p>
			      	<p>For swirl and segmented patterns, there might be a slight hint of other colors that may appear on the bracelets. For example, in a yellow and red swirl bracelet, a hint of orange may appear. This is normal and there is no way to control this due to the production method of the bracelets. For any re-orders, we cannot guarantee that the re-ordered wristbands will completely match the exact color of the previous order.</p>
			      	<p>We use silk-screen process for our imprinted wristbands. The printed ink may fade in the long run, just like how printed t-shirts do also fade after washing several times. If there is a major sign of fading off on the wristbands within two months of delivery of the wristbands, then we will happy to reproduce the number of wristbands with fading ink. After two months, any hint of fading will not be entitled for reproduction.</p>
					  <br>

			      	<p class="parag-title">Ordering Policy</p>
			      	<p>Once an order is received, we may send a digital proof to confirm the details of the wristband design to the email address provided. The digital proof must be approved immediately. To avoid any delays, the digital proof will be auto-approved if no update was received within 24 hours, to ensure a timely delivery. The time of production will begin only when digital proof is approved. The order cannot be cancelled anymore once the wristbands are in production. There will be a processing fee of 15% of the total cost for any successfully placed orders to be cancelled prior to the production stage.</p>
					  <br>

			      	<p class="parag-title">Privacy Policy</p>
			      	<p>We do not sell our customer list to anyone. You can order with the assurance that you will not receive spam mail.If we have a customer who fails to make payment for an order, a customer who reverses payment on an order already received, or a customer we feel is making an attempt to defraud us, we reserve the right to provide information to credit agencies and other collections services.</p>
					  <br>

			      	<p class="parag-title">Return Policy</p>
			      	<p>Due to the customized nature of our product we do not accept returns unless there was a production error on our part. Ordering the wrong size, color, or phrase on a wristband does not warrant a return. We encourage customers to verify all order information before submitting the final order. If we make a mistake on color, size, quantity, or phrases on a wristband we will be happy to find a solution to remedy the problem.</p>
			      	<p>All returns must be approved through our office at info@wristbandcreation.com. If product defect is detected, our office must be notified within 10 days from time of arrival of your package.</p> <br>

			      	
			      	<p>This document was last updated on January 02, 2015</p> -->

			      </div>

			      <div class="tab-pane" id="sitemap">
					<h1>Sitemap</h1>

					<ul>
						<?php if( have_rows('sitemap_field') ): ?>
		            	<?php while( have_rows('sitemap_field') ): the_row(); ?>
		            		<li><a href="<?php the_sub_field('page_link'); ?>"><?php the_sub_field('page_title'); ?></a></li>
		            		<li><a href="kulayfulwp.local">Home</a></li>
						<?php endwhile; ?>
		        	<?php endif; ?>

						<!-- <li><a href="#">Home</a></li>
						<li><a href="#">Order Now</a></li>
						<li><a href="#">Debossed Wristbands</a></li>
						<li><a href="#">Imprinted Wristbands</a></li>
						<li><a href="#">Deboss-Fill Wristbands</a></li>
						<li><a href="#">Embossed Wristbands</a></li>
						<li><a href="#">Emboss-Printed Wristbands</a></li>
						<li><a href="#">Dual Layer Wristbands</a></li>
						<li><a href="#">Figured Wristbands</a></li>
						<li><a href="#">Blank Wristbands</a></li>
						<li><a href="#">Color Pantone Chart</a></li>
						<li><a href="#">Available Fonts</a></li>
						<li><a href="#">Available Logos</a></li>
						<li><a href="#">Available Sizes</a></li>
						<li><a href="#">FAQ</a></li>
						<li><a href="#">Contact Us</a></li>
						<li><a href="#">About Us</a></li>
						<li><a href="#">Terms & Conditions</a></li>
						<li><a href="#">Privacy Policy</a></li> -->
					</ul>
			      </div>
			    </div>
			</div>
		</div>
	</div>


<?php 
    endwhile;
    endif; ?>

<?php get_footer(); ?>