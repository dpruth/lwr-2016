<?php 
/**
 * The template for displaying the What We Do page
 *
 * @package storefront
 */
 
 get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php

			do_action( 'storefront_single_post_before' ); 
			
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="http://schema.org/BlogPosting">

			<?php
				/**
				* @hooked storefront_post_header - 10
				* @hooked storefront_post_meta - 20
				* @hooked storefront_post_content - 30
				*/

				remove_action( 'storefront_single_post', 'storefront_post_header', 10 );
				remove_action( 'storefront_single_post', 'storefront_post_meta', 20 );
				remove_action( 'storefront_single_post', 'storefront_post_content', 30 );

				add_action( 'storefront_single_post', 'lwr_add_breadcrumb', 3 );
				add_action( 'storefront_single_post', 'lwr_add_page_header_image', 15 );
				add_action( 'storefront_single_post', 'storefront_page_content', 28 );
				
				do_action( 'storefront_single_post' );
				

				get_template_part( 'inc/custom', 'what-we-do' ); 
				get_template_part( 'inc/custom', 'project-locations' );
				get_template_part( 'inc/custom', 'current-projects' ); 
				
			?>

</article><!-- #post-## -->
		<?php 
			/**
			 * @hooked storefront_post_nav - 10
			 */
			do_action( 'storefront_single_post_after' );
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>