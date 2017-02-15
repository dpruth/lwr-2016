<?php
/**
 * The template for displaying mission quilt pages.
 *
 * Template Name: Quilts Page
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				do_action( 'storefront_page_before' );
				?>

				<?php

					add_action( 'storefront_page', 'lwr_add_page_header_image', 15 );
					remove_action( 'storefront_page', 'storefront_page_header', 10);
				?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					get_template_part( 'custom', 'current-projects' );
					get_template_part( 'custom', 'resources' );
				?>


				<?php
				/**
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>