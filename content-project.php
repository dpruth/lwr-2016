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
		function lwr_project_dates() {
			$start_date = get_field('project_dates');
			$end_date = get_field('project_end_date');
			
			echo '<p>Project Dates: ' . esc_html( $start_date ) . ' to ' . esc_html( $end_date ) . '</p>';
		}
		add_action( 'storefront_single_post', 'lwr_project_dates', 20 );
		
		remove_action( 'storefront_single_post', 'storefront_post_header', 10 );
		remove_action( 'storefront_single_post', 'storefront_post_meta', 20 );
		remove_action( 'storefront_single_post', 'storefront_post_content', 30 );

		add_action( 'storefront_single_post', 'lwr_add_breadcrumb', 3 );
		add_action( 'storefront_single_post', 'lwr_add_page_header_image', 15 );
		add_action( 'storefront_single_post', 'storefront_page_content', 28 );

		do_action( 'storefront_single_post' );
							
							
		get_template_part( 'inc/custom', 'project-locations' );
		get_template_part( 'inc/custom', 'videos' );
		get_template_part( 'inc/custom', 'related-stories' );
	?>

</article><!-- #post-## -->
