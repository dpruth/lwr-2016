<?php
/**
 * The template for displaying all single posts.
 *
 * Template Name: Donation Page
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area single-product">
		<main id="main" class="site-main container mt-5" role="main">
		<div itemscope itemtype="http://schema.org/Product" class="product type-product row">

		<?php while ( have_posts() ) : the_post(); ?>

			<div class="col-md-4">
				<?php the_post_thumbnail('medium'); ?>
			</div>
			<div class="summary entry-summary col-md-8">
				<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</div>
			
			<?php
			/**
			 * @hooked storefront_post_nav - 10
			 */
			do_action( 'storefront_single_post_after' );
			?>

		<?php endwhile; // end of the loop. ?>
		</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>