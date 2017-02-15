<?php

	/************************************************
			Custom Header
	*************************************************/
	function lwr_add_color_bars( ) { ?>
		<div id="top-colors">
			<div id="top-colors-green"></div><div id="top-colors-teal"></div><div id="top-colors-blue"></div><div id="top-colors-kelly"></div>
		</div>
	<?php }
	add_action( 'storefront_header', 'lwr_add_color_bars', 0 );

	function lwr_set_dynamic_title( ) { ?>
		<a href="/" id="logo"><object data="<?php echo get_stylesheet_directory_uri() . '/img/lwr_logo_icon.svg'; ?>" type="image/svg+xml"></object><img src="<?php echo get_stylesheet_directory_uri() . '/img/title2.png'; ?>" alt="Lutheran World Relief. Sustainable Development. Lasting Promise"></a>
	<?php }
	add_action( 'storefront_header', 'lwr_set_dynamic_title', 25 );

	function lwr_header_donate_button($amount) { ?>
		<div id="donate-button">
			<div>
				<a href="/donate/where-needed-most" class="orange-button">Donate Now</a>
				<form class="orange-button" method="get">
					<input type="text" name="nyp" value="<?php echo esc_attr($amount);?>" data-cip-id="nyp" /> Enter Amount
					<input type="hidden" name="add-to-cart" value="138" />
					<button type="submit">Donate Now!</button>
				</form>
			</div>
		</div>
		<?php }
	add_action( 'storefront_header', 'lwr_header_donate_button', 27 );

	function lwr_social_media_buttons( ) { ?>
		<div id="social-media">
			<a href="http://www.facebook.com/LuthWorldRelief" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/img/fb-icon.png'; ?>" alt="Follow on Facebook" /></a>
			<a href="http://www.twitter.com/LuthWorldRelief" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/img/twitter-icon.png'; ?>" alt="Follow on Twitter" /></a>
			<a href="//www.youtube.com/user/LutheranWorldRelief" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/img/youtube-icon.png'; ?>" alt="View YouTube Channel" /></a>
		</div>
	<?php }
	add_action( 'storefront_header', 'lwr_social_media_buttons', 45 );

	function lwr_set_emergency( ) {
		if (get_option('is_current_emergency') == 'on') { ?>
			<div id="current-emergency">
				<a href="<?php echo esc_url(get_option('emergency_url') ); ?>">
					<span>Alert!</span>
					<h2><?php echo esc_attr(get_option('emergency_name')); ?></h2>
					<p class="excerpt"><?php echo esc_attr(get_option('emergency_excerpt')); ?></p>
					<p class="call2action"><?php echo esc_attr(get_option('emergency_calltoaction' ) ); ?>&raquo;</p>
				</a>
			</div>
			<style>.site-content{ margin-top: 50px; }</style>
		<?php }
	}
	add_action( 'storefront_header', 'lwr_set_emergency', 70 );

	function lwr_manipulate_header_elements() {
		remove_action( 'storefront_content_top', 'woocommerce_breadcrumb', 10 );
	}
	add_action( 'init', 'lwr_manipulate_header_elements', 3 );


	/************************************************
			Custom Footer
	*************************************************/
	function lwr_manipulate_footer_elements() {
		remove_action( 'storefront_footer', 'storefront_footer_widgets', 10 );
		remove_action( 'storefront_footer', 'storefront_credit', 20 );
		add_action( 'storefront_footer', 'lwr_footer_badges', 10);
		add_action( 'storefront_footer', 'lwr_contact_signoff', 20);
		add_action( 'storefront_footer', 'lwr_footer_menu', 30);
	}
	add_action( 'init', 'lwr_manipulate_footer_elements', 3 );

	function lwr_footer_badges( ) { ?>
		<div id="footer-badges">
			<a href="http://www.charitynavigator.org/index.cfm?bay=search.summary&orgid=4031" target="_blank"></a>
			<a href="http://www.bbb.org/charity-reviews/national/relief-and-development/lutheran-world-relief-in-baltimore-md-494" target="_blank"></a>
			<a href="http://greatnonprofits.org/reviews/lutheran-world-relief" target="_blank"></a>
			<a href="https://www.charitywatch.org/ratings-and-metrics/lutheran-world-relief/416" target="_blank"></a>
			<?php	if ( did_action( 'storefront_footer' ) ) { ?>
			<a href="http://www.interaction.org/members/standards" target="_blank"></a>
			<a href="http://www.actalliance.org/" target="_blank"></a>
			<?php } ?>
		</div>
	<?php }

	function lwr_contact_signoff( ) { ?>
		<div id="contact-signoff">
			<div>
				<img src="<?php echo get_stylesheet_directory_uri() . '/img/lwr_logo.jpg'; ?>" alt="Lutheran World Relief" />
			</div><div>
				700 Light Street <span>|</span> Baltimore, Maryland 21230 USA<br />
				800.597.5972 <span>|</span> <a href="mailto:lwr@lwr.org">lwr@lwr.org</a>
			</div>
		</div>
	<?php }
	
	function lwr_footer_menu() {
		$args = array(
			'menu' => 'Footer Menu',
			'container' => 'nav'
		);
		wp_nav_menu( $args );
		
	}
	

?>