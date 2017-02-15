<?php
/**
 * @package storefront
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="http://schema.org/BlogPosting">

	<?php
	/**
	 * @hooked storefront_post_header - 10
	 * @hooked storefront_post_meta - 20
	 * @hooked storefront_post_content - 30
	 */

	add_action( 'storefront_single_post', 'lwr_add_breadcrumb', 3 );
	add_action( 'storefront_single_post', 'lwr_add_page_header_image', 15 );
	add_action( 'storefront_single_post', 'lwr_social_media_links', 25 );
	add_action( 'storefront_single_post', 'lwr_get_author_information', 27 );
	add_action( 'storefront_single_post', 'storefront_page_content', 28 );
	add_action( 'storefront_single_post', 'lwr_social_media_links', 29 );
	add_action( 'storefront_single_post', 'lwr_publications_list', 30 );

	remove_action( 'storefront_single_post', 'storefront_post_header', 10 );
	remove_action( 'storefront_single_post', 'storefront_post_meta', 20 );
	remove_action( 'storefront_single_post', 'storefront_post_content', 30 );

	do_action( 'storefront_single_post' );
	
	get_template_part( 'inc/custom', 'related-stories' );
	
	do_action( 'storefront_single_post_bottom' );

	?>

</article><!-- #post-## -->
