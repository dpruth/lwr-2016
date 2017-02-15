<?php
/**
 * The template for displaying archive Press Releases.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package storefront
 *
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<article id="post-<?php the_ID(); ?>" class="hentry" itemscope="" itemtype="">
				<?php
					add_action( 'storefront_page_before', 'lwr_add_breadcrumb', 3 );
					do_action( 'storefront_page_before' );
				?>
				<header class="entry-header">
					<h1>Press Releases</h1>
					<?php the_archive_description(); ?>
				</header>

				<?php if ( have_posts() ) : ?>

					<div class="entry-content" itemprop="mainContentOfPage">
					<?php // get_template_part( 'loop' );
						while ( have_posts() ) : the_post(); ?>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br />
							<small><?php the_date('l, F j, Y '); ?></small></h2>
							<?php the_excerpt(); ?>
							<p><a href="<?php the_permalink(); ?>">Continue reading&raquo;</a></p>
							<hr />
						<?php endwhile;	?>
						<nav id="pagination"><?php echo paginate_links(); ?></nav>

					</div>
				<?php else : ?>

					<?php get_template_part( 'content', 'none' ); ?>

				<?php endif; ?>

			</article><!-- /article -->

		</main><!-- #main -->
	</section><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>
