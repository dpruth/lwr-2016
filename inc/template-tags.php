<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package lwr
 */

if ( ! function_exists( 'lwr_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function lwr_posted_on() {
	
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
	$posted_on = sprintf(	esc_html_x( '%s', 'post date', 'lwr' ), $time_string );
	

	if( 'pressrelease' == get_post_type() ) {
		 		$post_object = get_field('media_contact');
	
		if( $post_object ) {
		
			$post = $post_object;
			setup_postdata( $post );
			
			$custom = get_post_custom($post->ID);
			$_staff_member_link = get_the_permalink($post->ID);
			$_staff_member_name = get_the_title($post->ID);
			$_staff_member_title = $custom["_staff_member_title"][0];
			$_staff_member_email = $custom["_staff_member_email"][0];
			$_staff_member_phone = $custom["_staff_member_phone"][0];
			$_staff_member_meta = $_staff_member_email;
			
			$byline = sprintf( 
				esc_html_x( '%s', 'post author', 'lwr'),
				'<span class="author vcard">Media Contact: <a class="url fn n" href="' . esc_url( $_staff_member_link ) . '">' . esc_html( $_staff_member_name ) . '</a><br />' .
				esc_html( $_staff_member_title ) . '<br />' .
				'<a class="url fn n" href="mailto:' . antispambot( $_staff_member_email ) . '">' . antispambot( $_staff_member_email ) . '</a><br />' .
				esc_html( $_staff_member_phone ) . '</span>'
			);
		}
		wp_reset_postdata();
		
	} else {		
		$_staff_member_meta = get_the_author_meta( 'ID' );
		$_staff_member_name = get_the_author();
	$byline = sprintf(
		esc_html_x( '%s', 'post author', 'lwr' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( $_staff_member_name ) . '</a></span>'
	);
	}
	
	echo '<aside class="media">';
	if( is_singular() && !is_front_page() ) {
		echo get_avatar( $_staff_member_meta, 96, 'mm', $_staff_member_name, array( 'class'=>'rounded-circle') );
	} else {
		echo get_avatar( $_staff_member_meta, 36, 'mm', $_staff_member_name, array( 'class'=>'rounded-circle mr-3') );
	}
	echo '<div class="media-body">';
	echo '<span class="byline"> ' . $byline . '</span><br /><span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
	
	if( is_single() && in_category(183) ) {
		?>
		<div class="faith-in-action text-center">
			<a href="<?php echo get_category_link( 183 ); ?>"><span class="faith-in">Faith in</span> <span class="action">Action</span></a>
		</div>
		<?php
	}
	echo '</div></aside>';

}
endif;

if ( ! function_exists( 'lwr_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function lwr_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ' ', 'lwr' ) );
		if ( $categories_list && lwr_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'lwr' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ' ', 'lwr' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'lwr' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'lwr' ), esc_html__( '1 Comment', 'lwr' ), esc_html__( '% Comments', 'lwr' ) );
		echo '</span>';
	}
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'lwr' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function lwr_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'lwr_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );
		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );
		set_transient( 'lwr_categories', $all_the_cool_cats );
	}
	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so components_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so components_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in lwr_categorized_blog.
 */
function lwr_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'lwr_categories' );
}
add_action( 'edit_category', 'lwr_category_transient_flusher' );
add_action( 'save_post',     'lwr_category_transient_flusher' );



/*
 *	Test for Advanced Custom Fields Options Page
 */
	if( function_exists('acf_add_options_page') ) {
	
		acf_add_options_page(array(
			'page_title' 	=> 'Site Alert Settings',
			'menu_title'	=> 'Alert Settings',
			'menu_slug' 	=> 'alert-settings',
			'capability'	=> 'edit_others_posts',
			'redirect'		=> false,
			'icon_url' 		=> 'dashicons-megaphone'
		));
	
	}



/*
 *	Scrolling
*/
	function lwr_scrollTop() {
			if ( is_admin_bar_showing() ) { ?>
				<style> nav#main-nav.scrolled { top: 32px; } 
					@media screen and (max-width: 782px) {
						nav#main-nav.scrolled { top: 46px; }
					}
					@media screen and (max-width: 600px) {
						nav#main-nav.scrolled { top: 0; }
					}
				</style>
			<?php }
	}
	add_action ( 'wp_footer', 'lwr_scrollTop' );


/*
 * RED EMERGENCY BANNER 
 */
function lwr_emergency_banner() { 
		
		if ( get_field('red_bar_alert', 'option') ) { 
			$donate_item = get_field('red_alert_product', 'option');
		?>
			<div id="current-emergency">

				<h2><?php the_field('red_alert_headline', 'option'); ?></h2>
				<p><?php the_field('red_alert_description', 'option'); ?></p>
				<div class="d-flex flex-row">
				<form method="get" class="form">
					<input type="hidden" name="add-to-cart" value="<?php echo $donate_item->ID; ?>" />
					<input type="hidden" name="nyp" value="100" />
					<button class="btn btn-outline-secondary btn-lg" type="submit">$100</button>
				</form>
				<form method="get" class="form">
					<input type="hidden" name="add-to-cart" value="<?php echo $donate_item->ID; ?>" />
					<input type="hidden" name="nyp" value="500" />
					<button class="btn btn-outline-secondary btn-lg" type="submit">$500</button>
				</form>
				<form method="get" class="form-inline">
					<div class="input-group">
						<div class="input-group-addon">$</div>
						<input type="text" name="nyp" data-cip-id="nyp" class="form-control" placeholder="Other Amount">
					</div>
					<input type="hidden" name="add-to-cart" value="<?php echo $donate_item->ID; ?>">
					<button type="submit" class="btn btn-outline-secondary btn-lg">Donate Now</button>
				</form>
				</div>
			</div>
		<?php } 
}

/*
 *	MAILCHIMP EMAIL FORM
 */
	function lwr_mailchimp_form($group, $source) {
				
		switch( $group ) {
			case 'blog' :
				$value = '4';
				$group_id = 'group[5197][4]';
				$name = 'LWR&rsquo;s Blog';
				$mce_group = 'mce-group[5197]-5197-1';
				break;
			case 'faith-in-action' :
				$value = '8192';
				$group_id = 'group[5197][8192]';
				$name = 'Faith in Action';
				$mce_group = 'mce-group[5197]-5197-2';
				break;
			default :
				$value = '1';
				$group_id = 'group[5197][1]';
				$name = 'eNews (every other Friday)';
				$mce_group = 'mce-group[5197]-5197-0';
		}
		?>
		<form action="//lwr.us11.list-manage.com/subscribe/post?u=9ede5b497f32f90e55971b4c3&amp;id=a7efd06af7&SIGNUP=<?php echo esc_attr( $source );	?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
		<div class="form-group row justify-content-center">
			<label class="sr-only" for="mce-EMAIL">Email Address</label>
			<input type="email" placeholder="Enter your email address&hellip;" value="" name="EMAIL" class="required email form-control col-8" id="mce-EMAIL">
			<div class="mc-field-group input-group" style="display:none">
        <ul><li><input type="checkbox" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $group_id ); ?>" id="<?php echo esc_attr( $mce_group ); ?>" checked><label for="<?php echo esc_attr( $group_id ); ?>">Subscribe to <?php echo esc_attr( $name ); ?></label></li></ul>
			</div>

			<button type="submit" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary col-4" onClick="ga('send', 'event', 'MailChimp', 'Sign-Up', '<?php echo esc_attr( $name); ?>' );" ><i class="fa fa-paper-plane-o"></i> Sign Up</button>

			<div id="mce-responses" class="w-100">
        <div class="response alert alert-warning alert-dismissible fade show" id="mce-error-response" style="display:none"></div>
        <div class="response alert alert-success alert-dismissible fade show" id="mce-success-response" style="display:none"></div>
			</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->

			<div style="position: absolute; left: -5000px;" aria-hidden="true">
        <input type="text" name="b_9ede5b497f32f90e55971b4c3_a7efd06af7" tabindex="-1" value="">
			</div>
		</div>
		</form>

		<?php wp_enqueue_script('MC Validation', '//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'); ?>
	<script type='text/javascript'>
    window.setTimeout(function () {
        window.fnames = new Array(); window.ftypes = new Array();
        fnames[1] = 'FNAME';ftypes[1] = 'text';fnames[2] = 'LNAME';ftypes[2] = 'text';fnames[0] = 'EMAIL';ftypes[0] = 'email';fnames[3] = 'ADDRESS';ftypes[3] = 'address';fnames[4] = 'MMERGE4';ftypes[4] = 'text';
        var $mcj = jQuery.noConflict(true);}, 500);
	</script>
	<!--End mc_embed_signup-->
 <?php
	}
 
/*
 *	DIALOG FOR EMAIL CAPTURE
 */
	function enqueue_modal_window() {
		if ( get_field('show_modal_window', 'option' ) ) :
			$pages = get_field('what_pages', 'option');
			if( !empty($pages) ) {
				foreach ($pages as $page) {
					$page_id = $page->ID;
				}
				$page_ids = explode(',', $page_id);
			}
			// If no page selected show on all pages, otherwise show on selected
			if( empty($pages) || is_page($page_ids) ) {
			
				// Sets cookie so modal only displays once
				wp_enqueue_script('jquery-cookie', '', array('jquery'), false, true ); 
			
				// Include modal javascript after jQuery
				wp_enqueue_script('lwr_dialog', get_stylesheet_directory_uri() . '/js/lwr_jquery_dialog.js', array('jquery','jquery-cookie'), false, true );
	
				// Include 'add_modal_dialog' function in footer
				add_action('wp_footer', 'add_modal_dialog');
			}
		endif;
	}
	add_action( 'wp_enqueue_scripts', 'enqueue_modal_window' );
	
	function add_modal_dialog() {
		
		if ( get_field('modal_type', 'option') == 'email' ) {
			$heading = get_field('modal_email_heading', 'option');
			$text = get_field('modal_email_text', 'option');
			$image = get_field('modal_email_background', 'option');
			ob_start();
				lwr_mailchimp_form('enews', 'dialog');
			$footer_content = ob_get_clean();
		} else {
			$heading = get_field('modal_donation_heading', 'option');
			$text = get_field('modal_donation_text', 'option');
			$image = get_field('modal_donation_background', 'option');
			$donation_item = get_field('modal_donation_product', 'option');
			ob_start(); ?>
				<form method="get" class="form-inline">
					<div class="input-group">
						<div class="input-group-addon">$</div>
						<input type="text" name="nyp" data-cip-id="nyp" class="form-control" placeholder="Amount">
					</div>
					<input type="hidden" name="add-to-cart" value="<?php echo $donation_item->ID; ?>">
					<button type="submit" class="btn btn-primary">Donate Now</button>
				</form>
			<?php
			$footer_content = ob_get_clean();

		}
		?>
		<div id="dialog" class="modal fade">
			<div class="modal-dialog modal-lg" >
				<div class="modal-content" 	style="background: #fff url('<?php echo esc_url($image); ?>') no-repeat;" >
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle"></i></button>
						<div id="dialog-text" >
							<h2><?php echo esc_attr( $heading ); ?></h2>
							<?php echo $text; ?>
						</div>
					</div>
					<div class="modal-footer justify-content-center">
						<?php echo $footer_content; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
/*
 *	CHARITY BADGES
 */
	function lwr_charity_badges() { ?>
		<div id="charity-badges" class="container">
		<div class="row justify-content-center">
			<div class="col-6 col-md-2">
				<a href="http://www.charitynavigator.org/index.cfm?bay=search.summary&orgid=4031" target="_blank">Charity Navigator</a></div>
			<div class="col-6 col-md-2">
				<a href="http://www.bbb.org/charity-reviews/national/relief-and-development/lutheran-world-relief-in-baltimore-md-494" target="_blank">Better Business Bureau</a>
			</div>
			<div class="col-6 col-md-2">
				<a href="http://greatnonprofits.org/reviews/lutheran-world-relief" target="_blank">Great NonProfits</a>
			</div>
			<div class="col-6 col-md-2">
				<a href="https://www.charitywatch.org/ratings-and-metrics/lutheran-world-relief/416" target="_blank">CharityWatch</a>
			</div>
			<?php	if ( did_action( 'get_footer' ) ) { ?>
			<div class="col-6 col-md-2">
				<a href="http://www.interaction.org/members/standards" target="_blank">InterAction Member Standards</a>
			</div>
			<div class="col-6 col-md-2">
				<a href="http://www.actalliance.org/" target="_blank">ACT Alliance</a>
			</div>
			<?php } ?>
		</div>
		</div> <?php 
	} 
	
/*
 *	Social Media Links
 */

	function lwr_social_media_links() { 
		if ( !is_page( array( 'my-account', 'cart', 'checkout' ) ) ) {	?>
	 	<div id="social-links">
			<a href="https://www.facebook.com/dialog/share?app_id=1424877374508042&amp;display=popup&amp;href=<?php the_permalink(); ?>&amp;redirect_uri=<?php the_permalink(); ?>" onClick="ga('send', 'social', 'Facebook', 'share', '<?php the_permalink(); ?>');" ><i class="fa fa-facebook"></i> Share on Facebook</a>
			<a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&amp;url=<?php the_permalink(); ?>&amp;via=LuthWorldRelief" onClick="ga('send', 'social', 'Twitter', 'tweet', '<?php the_permalink(); ?>');" ><i class="fa fa-twitter"></i> Share on Twitter</a>
		</div><!-- #current-social-links-## -->
	 <?php 
	 }
	}

	
/*
 *	Add Faith in Action or Special Reports logo to posts
 */
	function faith_in_action_logo($content) {
		if ( is_single() && is_main_query() ) {
			
			if (in_category(183) ) { // Faith in Action
				ob_start();	?>
				<div class="row justify-content-center">
					<div class="col text-center faith-in-action">
					<h3>This article appears in: <a href="<?php echo get_category_link( 183 ); ?>"><span class="faith-in">Faith in</span> <span class="action">Action</span> <span class="fia-descriptor">A newsletter especially for LWR Quilters &amp; Kit Makers</span></a></h3>
					</div>
				</div>
			<?php
			$fia_logo = ob_get_clean();
			$content = $content . $fia_logo;
			} elseif ( in_category(181) ) { // Special Reports
				ob_start(); ?>
				<div class="row justify-content-center">
					<div class="col text-center special-reports">
					<h3>This article appears in: <a href="<?php echo get_category_link( 181 ); ?>"><span class="lwr">LWR</span> <span class="special-reports">Special Reports</span></a></h3>
					</div>
				</div>
				<?php
			$sr_logo = ob_get_clean();
			$content = $content . $sr_logo;
			}
		}
		return $content;
	}
	add_filter( 'the_content', 'faith_in_action_logo' );


/*
 *	Insert SUBSCRIBE TO BLOG form on blog posts
 */
	
	//Insert ads after fifth paragraph of single post content.
	add_filter( 'the_content', 'prefix_insert_blog_signup' );
		
	function prefix_insert_blog_signup( $content ) {
		
   if ( 'post' == get_post_type() && !is_feed() ) {
		ob_start();
			?>
			<div id="blog-signup" class="row justify-content-center">
				<div class="col text-center">
					<h3>Get posts like this delivered straight to your inbox:</h3>
					<?php lwr_mailchimp_form('blog', 'blog-post') ?>
				</div>
			</div>
			<?php
    $blog_signup = ob_get_clean();
				
    return prefix_insert_signup_after_paragraph( $blog_signup, 5, $content );
   }
    return $content;
	}

  // Parent Function that makes the magic happen
	function prefix_insert_signup_after_paragraph( $insertion, $paragraph_id, $content ) {
    $closing_p = '</p>';

    $paragraphs = explode( $closing_p, $content );

    foreach ($paragraphs as $index => $paragraph) {
        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }
        if ( $paragraph_id == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
    }
    return implode( '', $paragraphs );
	}

/*
 * Shopping Cart Handheld Footer Bar
 */
	function lwr_handheld_footer_bar() {
		global $woocommerce;
		?>
			<div class="handheld-footer-bar container-fluid fixed-bottom">
				<nav class="row align-items-center">
					<div class="col py-3">
						<h3 class="text-center"><a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="My Account"><i class="fa fa-user"></i><span class="sr-only">My Account</span></a></h3>
					</div>
					<div class="col py-3">
						<h3 class="text-center"><a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" title="View My Cart"><i class="fa fa-shopping-basket"></i><span class="sr-only">View My Cart</span></a></h3>
					</div>
				</nav>
			</div>
		<?php
	}
	add_action('wp_footer', 'lwr_handheld_footer_bar' );
