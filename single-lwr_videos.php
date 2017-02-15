<?php
/**
 * The template for displaying all single posts.
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
			
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/VideoObject">

	<?php
		

		remove_action( 'storefront_single_post', 'storefront_post_header', 10 );
		remove_action( 'storefront_single_post', 'storefront_post_meta', 20 );
		remove_action( 'storefront_single_post', 'storefront_post_content', 30 );

		add_action( 'storefront_single_post', 'lwr_add_breadcrumb', 3 );
		// add_action( 'storefront_single_post', 'lwr_add_page_header_image', 15 );
		add_action( 'storefront_single_post', 'lwr_add_video_embed', 18);
		add_action( 'storefront_single_post', 'storefront_page_content', 28 );

		do_action( 'storefront_single_post' );
		
	?>

</article><!-- #post-## --> 

			<?php 
			/**
			 * @hooked storefront_post_nav - 10
			 */
			get_template_part( 'inc/custom', 'related-stories' );
			
			 do_action( 'storefront_single_post_after' );


			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>