<?php
/**
 * Add WooCommerce support
 *
 * @package lwr
 */
add_action( 'after_setup_theme', 'woocommerce_support' );
if ( ! function_exists( 'woocommerce_support' ) ) {
	/**
	 * Declares WooCommerce theme support.
	 */
	function woocommerce_support() {
		add_theme_support( 'lwr' );
		
		// Add New Woocommerce 3.0.0 Product Gallery support
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-zoom' );

		// Gallery slider needs Flexslider - https://woocommerce.com/flexslider/
		//add_theme_support( 'wc-product-gallery-slider' );

		// hook in and customizer form fields.
		add_filter( 'woocommerce_form_field_args', 'wc_form_field_args', 10, 3 );
	}
}
/**
 * Filter hook function monkey patching form classes
 * Author: Adriano Monecchi http://stackoverflow.com/a/36724593/307826
 *
 * @param string $args Form attributes.
 * @param string $key Not in use.
 * @param null   $value Not in use.
 *
 * @return mixed
 */
function wc_form_field_args( $args, $key, $value = null ) {
	// Start field type switch case.
	switch ( $args['type'] ) {
		/* Targets all select input type elements, except the country and state select input types */
		case 'select' :
			// Add a class to the field's html element wrapper - woocommerce
			// input types (fields) are often wrapped within a <p></p> tag.
			$args['class'][] = 'form-group';
			// Add a class to the form input itself.
			$args['input_class']       = array( 'form-control', 'input-lg' );
			$args['label_class']       = array( 'control-label' );
			$args['custom_attributes'] = array(
				'data-plugin'      => 'select2',
				'data-allow-clear' => 'true',
				'aria-hidden'      => 'true',
				// Add custom data attributes to the form input itself.
			);
			break;
		// By default WooCommerce will populate a select with the country names - $args
		// defined for this specific input type targets only the country select element.
		case 'country' :
			$args['class'][]     = 'form-group single-country';
			$args['label_class'] = array( 'control-label' );
			break;
		// By default WooCommerce will populate a select with state names - $args defined
		// for this specific input type targets only the country select element.
		case 'state' :
			// Add class to the field's html element wrapper.
			$args['class'][] = 'form-group';
			// add class to the form input itself.
			$args['input_class']       = array( '', 'input-lg' );
			$args['label_class']       = array( 'control-label' );
			$args['custom_attributes'] = array(
				'data-plugin'      => 'select2',
				'data-allow-clear' => 'true',
				'aria-hidden'      => 'true',
			);
			break;
		case 'password' :
		case 'text' :
		case 'email' :
		case 'tel' :
		case 'number' :
			$args['class'][]     = 'form-group';
			$args['input_class'] = array( 'form-control', 'input-lg' );
			$args['label_class'] = array( 'control-label' );
			break;
		case 'textarea' :
			$args['input_class'] = array( 'form-control', 'input-lg' );
			$args['label_class'] = array( 'control-label' );
			break;
		case 'checkbox' :
			$args['label_class'] = array( 'custom-control custom-checkbox' );
			$args['input_class'] = array( 'custom-control-input', 'input-lg' );
			break;
		case 'radio' :
			$args['label_class'] = array( 'custom-control custom-radio' );
			$args['input_class'] = array( 'custom-control-input', 'input-lg' );
			break;
		default :
			$args['class'][]     = 'form-group';
			$args['input_class'] = array( 'form-control', 'input-lg' );
			$args['label_class'] = array( 'control-label' );
			break;
	} // end switch ($args).
	return $args;
}

/*
 *	Auto Complete all WooCommerce orders.
 */

	function custom_woocommerce_auto_complete_order( $order_id ) {
		if ( !$order_id ) { return; }

		$order = wc_get_order( $order_id );
		$order->update_status( 'completed' );
	}
	add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );

/*
 *	AUTHORIZE.NET VERIFIED SEAL
 */
	function add_authorize_net_seal() { ?>
		<!-- (c) 2005, 2016. Authorize.Net is a registered trademark of CyberSource Corporation --> <div class="AuthorizeNetSeal" style="margin-left: auto; margin-right:auto;"> <script type="text/javascript" language="javascript">var ANS_customer_id="dabc770c-754c-4824-91fa-8f817c47a85a";</script> <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script> <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Online Payment System</a> </div>
		<?php 
	}
	
/*
 *	CHANGE ADD TO CART BUTTON TEXT
 */
add_filter( 'woocommerce_product_single_add_to_cart_text' , 'custom_add_to_cart_text' );

function custom_add_to_cart_text() {
		global $product;
		$product_id = $product->get_id();
		$prod_cats = wc_get_product_terms( $product_id, 'product_cat' );
		
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


/*
 * Add Charity Badges to Donation Pages
 */
	function custom_add_charity_badges($product) {
		global $product;
		$product_id = $product->get_id();
		$prod_cats = wc_get_product_terms( $product_id, 'product_cat' );
		
		// Add charity badges if product category, or parent product category, is "Donate"
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
			lwr_charity_badges();
		} 
		
	}
	add_action('woocommerce_single_product_summary', 'custom_add_charity_badges', 35 );

/*
 * Add Custom Ask Amount Buttons to Product Pages
 */
	function lwr_custom_ask_amounts($product) {
		global $product;
		$product_id = $product->get_id();
		if( have_rows('custom_ask_amounts') ) :  // Defined in Advanced Custom Fields 
		?>
			<div class="custom_ask_amounts">
				<?php
			while( have_rows('custom_ask_amounts') ) : the_row();
				
				$ask_amount = get_sub_field('ask_amount');
				?>
				<a href="?add-to-cart=<?php echo esc_attr($product_id); ?>&amp;nyp=<?php echo esc_attr($ask_amount); ?>" class="btn btn-primary alt" onClick="ga('send', 'event', 'UX', 'click', 'Quick Donate', '<?php echo esc_attr( $ask_amount ); ?>')" >$<?php echo esc_attr( $ask_amount ); ?></a> <?php
			
			endwhile; ?>
			</div><?php
		endif;
	}
	add_action('woocommerce_before_add_to_cart_form', 'lwr_custom_ask_amounts' );
	
/*
 * Replace WooCommerce Images with Custom Giving Page Images
 */

	add_action( 'woocommerce_before_single_product_summary', 'lwr_show_product_images', 10 );
	function lwr_show_product_images() {
		
		$toggle_image = get_field('background_image');

		if ( isset($toggle_image) && $toggle_image == true ) {
			
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
			$image_url = get_the_post_thumbnail_url( $post->ID, 'full');
			?>
			<section class="jumbotron jumbotron-fluid" id="hero_image" style="background-image: url('<?php the_post_thumbnail_url(); ?>');" >
			<div class="overlay"></div>
			<?php 
		}
	}

	add_action( 'woocommerce_after_single_product_summary', 'lwr_after_product_images', 5 );
	function lwr_after_product_images() {
		
		$toggle_image = get_field('background_image');

		if ( isset($toggle_image) && $toggle_image == true ) {

		?></section> <!-- End Full-Width Product -->
		<div class="caption"><?php the_post_thumbnail_caption(); ?></div>
		<?php
		}
	}

	
/*
 *	Share Buttons on Thank-You page
 */
	function lwr_custom_thank_you_share( $order_id ) {
			$order = wc_get_order( $order_id );
			$total = $order->get_total();
			$order_status = $order->get_status();
			$line_items = $order->get_items();
					
			if ( $order_status == 'completed' || $order_status == 'processing' ) {
					?>
				<div class="share">	
					<h2><i class="fa fa-heart"></i> Share the love</h2>
					<p>Your friends and family are more likely to give to a charity if it has been recommended by you! Help make an even bigger difference by sharing why <em>you</em> support Lutheran World Relief.</p>
					<div id="social-links" class="row"><?php
							foreach ($line_items as $item ) {
								$product_name = $item['name'];
								$product_id = $item['product_id'];
							?>
						<div class="col">
							<h3><?php echo esc_attr( $product_name ); ?></h3>
							<a href="https://www.facebook.com/dialog/share?app_id=1424877374508042&amp;display=popup&amp;href=<?php echo get_permalink( $product_id ); ?>&amp;quote=I just donated to Lutheran World Relief and you should, too!" onClick="ga('send', 'social', 'Facebook', 'share', '<?php the_permalink(); ?>');" ><i class="fa fa-facebook"></i> Share on Facebook</a>
							<a href="https://twitter.com/intent/tweet?text=I just donated to Lutheran World Relief&amp;url=<?php echo get_permalink( $product_id ); ?>&amp;via=LuthWorldRelief" onClick="ga('send', 'social', 'Twitter', 'tweet', '<?php the_permalink(); ?>');" ><i class="fa fa-twitter"></i> Share on Twitter</a>
						</div>
							<?php
							} ?>
					</div><!-- #current-social-links-## -->
				</div>

					<?php
			}
	}
	add_action( 'woocommerce_thankyou', 'lwr_custom_thank_you_share', 1);

/*
 *	Add additional information about external sites on Login and My Account Pages
 */
	add_action('woocommerce_before_customer_login_form', 'monthly_giving_login' );
	add_action('woocommerce_account_dashboard', 'monthly_giving_login' );
	function monthly_giving_login() { ?>
	<div class="row">
		<div class="col">
			<h3>Monthly Donors</h3>
			<a class="button" href="https://www.eservicepayments.com/cgi-bin/vanco_ver3.vps?appver3=x1a8uAgje-8dTfwGAicT4jfYGSQ2YUK1meeOWlRPxdl1YzobNDOqExusiAiLTuMt7aTq0JcfkIpPLRF0xHYge49OLO7Dg8yDfJe-osqoHKPelRMIUQO1ws0MDmjSxQn1QuRs3_AoPtmIentShH09tg==">Sign in to the Monthly Portal</a>
		</div>
		<div class="col">
			<h3>Track your Quilts or Kits</h3>
			<a class="button" href="https://portal.brethren.org/">Log into the Tracker</a>
			<p><small><strong>Username:</strong> Donor01<br />
			<strong>Password:</strong> 2012BSC</small></p>
		</div>
		<div class="col">
			<h3>LWR Farmers Market Accounts</h3>
			<a class="button" href="https://www.lwrfarmersmarket.org/customer-login">Log into the LWR Farmers Market</a>
		</div>
	</div>
	<?php	}
