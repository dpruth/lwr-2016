<?php
/**
 * The template for displaying country pages.
 *
 * Template Name: Country Page
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); 
				
				
					do_action( 'storefront_page_before' );
				
					add_action( 'storefront_page', 'lwr_add_breadcrumb', 3 );
					add_action( 'storefront_page', 'lwr_add_page_header_image', 15 );
					remove_action( 'storefront_page', 'storefront_page_header', 10);
				

					get_template_part( 'content', 'page' ); 
					get_template_part( 'inc/custom', 'videos' );				
					get_template_part( 'inc/custom', 'project-locations' );
					get_template_part( 'inc/custom', 'current-projects' );
					get_template_part( 'inc/custom', 'resources' );
					get_template_part( 'inc/custom', 'contact-info' );
				
				
				/**
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );
				
			endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>