<?php
/**
 * The template for displaying Stories & Resources page.
 *
 * Template Name: Stories Page
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article class="hentry">

			<?php // while ( have_posts() ) : the_post(); 


				do_action( 'storefront_page_before' );

				
					// add_action( 'storefront_page', 'lwr_add_page_header_image', 15 );
					// remove_action( 'storefront_page', 'storefront_page_header', 10);
				

					// get_template_part( 'content', 'page' ); ?>
				<header class="entry-header">
					<h1 class="entry-title" itemprop="name" >Stories &amp; Resources</h1>
					<div id="enews-signup">
						<h2>SIGN UP FOR ENEWS</h2>
						<?php get_template_part( 'inc/custom', 'enews-signup' ); ?>
					</div>
				</header>

					<?php 
					get_template_part( 'inc/custom', 'blogs' );
					get_template_part( 'inc/custom', 'publications' );
					get_template_part( 'inc/custom', 'videos' );
					get_template_part( 'inc/custom', 'devotionals' );


				/**
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );


				// endwhile; // end of the loop. ?>
			</article>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>