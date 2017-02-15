<?php


	/*****************************************************
			Disable Product Reviews
	 *****************************************************/

	add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
	function wcs_woo_remove_reviews_tab($tabs) {
		unset( $tabs['reviews'] );
		return $tabs;
	}


	/*****************************************************
			Auto Complete all WooCommerce orders.
	 *****************************************************/

	function custom_woocommerce_auto_complete_order( $order_id ) {
		if ( !$order_id ) { return; }

		$order = wc_get_order( $order_id );
		$order->update_status( 'completed' );
	}
	add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );




	/*****************************************************
			Custom Javascript
 	 *****************************************************/
add_action('wp_enqueue_scripts', 'add_scripts_lwr_custom');
	function add_scripts_lwr_custom() {
	wp_enqueue_script( 'lwr_custom_script', get_stylesheet_directory_uri() . '/js/lwr_custom_script_min.js', array( 'jquery' ), '2.0.2', true );
	wp_enqueue_script( 'twitter', 'https://platform.twitter.com/widgets.js', array(), false, true );
	wp_enqueue_script( 'typekit', '//use.typekit.net/kwb3xis.js' );
	
	if (is_page('dmel-framework')) { 
		wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
		wp_enqueue_style('dmel-stylesheet', get_stylesheet_directory_uri() . '/css/dmel-style.css' );
		wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array('bootstrap'), '4.6.3' );
		wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js' );

	}
	
	/* if( is_page( array(65,68,70,72,75,438 )) ) { // QUILT & KIT PAGES
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-widget' );
		wp_enqueue_script( 'jquery-ui-tabs' );
	} */
	// Remove WooCommerce if not needed
    if (function_exists( 'is_woocommerce' )) {
     if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() ) {
    	wp_dequeue_script('wc-add-to-cart');
    	wp_dequeue_script('jquery-blockui');
    	wp_dequeue_script('jquery-placeholder');
    	wp_dequeue_script('woocommerce');
    	wp_dequeue_script('jquery-cookie');
    	wp_dequeue_script('wc-cart-fragments');
		
		wp_dequeue_style('woocommerce-layout');
		wp_dequeue_style('woocommerce-smallscreen');
		wp_dequeue_style('woocommerce-general');
      }
    }
		wp_dequeue_style('source-sans-pro');
}


	function lwr_add_typekit_script() {  ?>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>
	<?php }
	add_action( 'wp_head', 'lwr_add_typekit_script' );

	function add_facebook_sdk() { ?>
			<div id="fb-root"></div>
			<script>
                        window.fbAsyncInit = function() {
                          FB.init({
                            appId      : '163989920344226',
                            xfbml      : true,
                            version    : 'v2.6'
                          });
                        };

                        (function(d, s, id){
                           var js, fjs = d.getElementsByTagName(s)[0];
                           if (d.getElementById(id)) {return;}
                           js = d.createElement(s); js.id = id;
                           js.src = "//connect.facebook.net/en_US/sdk.js";
                           fjs.parentNode.insertBefore(js, fjs);
                         }(document, 'script', 'facebook-jssdk'));
                      </script>
	<?php }
	add_action( 'storefront_before_header' , 'add_facebook_sdk' );
	



	/******************************************************
			LWR Custom Theme Functions
	 ******************************************************/

	get_template_part('functions', 'homepage');
	get_template_part('functions', 'header-footer');
	get_template_part('functions', 'other');
	get_template_part('inc/custom', 'shortcodes');


	/******************************************************
			Override Mobile Navigation Display
	 ******************************************************/

	function storefront_primary_navigation() {
		?>

		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
		<button class="menu-toggle" aria-controls="primary-navigation" aria-expanded="false"><?php echo esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Navigation', 'storefront' ) ) ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location'	=> 'primary',
					'container_class'	=> 'primary-navigation',
					)
			);

			?>
		</nav><!-- #site-navigation -->
		<?php
	}

	
	/***************************************************
			AUTHORIZE.NET VERIFIED SEAL
	***************************************************/
	function add_authorize_net_seal() { ?>
		<!-- (c) 2005, 2016. Authorize.Net is a registered trademark of CyberSource Corporation --> <div class="AuthorizeNetSeal" style="margin-left: auto; margin-right:auto;"> <script type="text/javascript" language="javascript">var ANS_customer_id="dabc770c-754c-4824-91fa-8f817c47a85a";</script> <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script> <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Online Payment System</a> </div>
		<?php 
	}
	
	/*************************************************
			CHANGE ADD TO CART BUTTON TEXT
	**************************************************/
add_filter( 'woocommerce_product_single_add_to_cart_text' , 'custom_add_to_cart_text' );

function custom_add_to_cart_text() {
		global $product;
		$prod_cats = wc_get_product_terms( $product->id, 'product_cat' );
		
			foreach ($prod_cats as $prod_cat) {
				$cat_parent = $prod_cat->parent;
			}
			if ($cat_parent != '0' ) {
				$parent_cat = get_term_by( 'id', $cat_parent, 'product_cat' ); 
				$cats = $parent_cat->name;
			} else {
				$cats = $prod_cat->name;
			}
		
	if ( $cats == 'Donate' ) {
			return __( 'Give Now', 'woocommerce' );
	} else {
			return __( 'Add to cart', 'woocommerce' );
	}
	
}

	
/**********************************************
		DIALOG FOR THRIVENT MATCH DAY
	**********************************************/
	function enqueue_jquery_dialog() {
		if (get_option('modal_toggle') == 'on') {
			wp_enqueue_script('jquery-ui-dialog','', array('jquery','jquery-ui-core'), false, true );
			wp_enqueue_script('jquery-cookie', '', array('jquery'), false, true );
			wp_enqueue_script('lwr_dialog', get_stylesheet_directory_uri() . '/js/lwr_jquery_dialog.js', array('jquery','jquery-ui-core','jquery-ui-dialog','jquery-cookie') );
		}
	}
	add_action( 'wp_enqueue_scripts', 'enqueue_jquery_dialog' );
	
	function add_jquery_dialog() {
		
		if (get_option('modal_toggle') == 'on') { ?>
		<div id="dialog" title="<?php echo esc_attr( get_option('modal_title') ); ?>">
				<img src="<?php echo esc_url(get_option('modal_background') ); ?>" />
				<div id="dialog-text">
				<?php echo get_option('modal_text'); ?>
				<a class="button" href="<?php echo esc_url( get_option('modal_url') ); ?>" target="_blank"><?php echo esc_attr( get_option('modal_calltoaction') ); ?></a>
				</div>
		</div>
	<?php
		} 
	}
	add_action('wp_footer', 'add_jquery_dialog');
	
	
/************************************************
	Add Charity Badges to Donation Pages
	**********************************************/
	function custom_add_charity_badges() {
		global $product;
		$prod_cats = wc_get_product_terms( $product->id, 'product_cat' );
		
			foreach ($prod_cats as $prod_cat) {
				$cat_parent = $prod_cat->parent;
			}
			if ($cat_parent != '0' ) {
				$parent_cat = get_term_by( 'id', $cat_parent, 'product_cat' ); 
				$cats = $parent_cat->name;
			} else {
				$cats = $prod_cat->name;
			}
		
		if ( $cats == 'Donate' ) {
			add_action('woocommerce_single_product_summary', 'lwr_footer_badges', 35 );
		} 
		
	}
	add_action('woocommerce_single_product_summary', 'custom_add_charity_badges', 1 );
	
?>
