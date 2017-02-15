<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package storefront
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * @hooked storefront_page_header - 10
	 * @hooked storefront_page_content - 20
	 */
	
		add_action( 'storefront_page', 'lwr_add_breadcrumb', 3 );
		add_action( 'storefront_page', 'lwr_add_page_header_image', 15 );
		
		remove_action( 'storefront_page', 'storefront_page_header', 10 );
		
	if ( is_page( array( 92, 93 ) ) ) {
		add_action('storefront_page', 'add_authorize_net_seal', 90 );
	}
	
		do_action( 'storefront_page' );
	
	if ( is_page( array(55, 386, 388) ) ) {
		get_template_part( 'inc/custom', 'project-locations' );
		get_template_part( 'inc/custom', 'resources' );
	}
		
	?>
</article><!-- #post-## -->
