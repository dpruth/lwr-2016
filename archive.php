<?php
/**
 * The generic template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package storefront
 *
 */

get_header(); ?>

	<style type="text/css">
		.attachment-medium{float:left;}
	</style>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<article id="post-<?php the_ID(); ?>" class="hentry" itemscope="" itemtype="">
				<?php
					add_action( 'storefront_page_before', 'lwr_add_breadcrumb', 3 );
					do_action( 'storefront_page_before' );
				?>
				<header class="entry-header">
					<h1><?php the_archive_title(); ?></h1>
					<?php the_archive_description(); ?>
				</header>

				<?php if ( have_posts() ) : 

					if( is_post_type_archive('lwr_videos') ) { ?>
						<div class="horizontal-list three-item-list">
						<?php 
						
						while ( have_posts() ) : the_post(); ?>
						<a href="<?php the_permalink(); ?>">
							<div class="img-limit"><?php the_post_thumbnail( 'medium' ); ?>
								<div class="video-overlay"></div>
							</div>
							<h2><?php the_title(); ?></h2>
							<?php the_excerpt(); ?>
						</a> 
					<?php endwhile; ?>
						</div>
						
					<?php	
					} else { ?>
						<div class="stories-list" itemprop="mainContentOfPage"> <?php
					

		
						while ( have_posts() ) : the_post(); ?>
							<div>
								<a href="<?php the_permalink(); ?>">
						<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'medium' );
							} else {}
							?>
								<h2><?php the_title(); ?><br />
							<small><?php the_date('l, F j, Y '); ?></small></h2>
							<?php the_excerpt(); ?>
							<p>Continue reading&raquo;</a></p>
							</a>
							</div>
							<!-- <hr /> -->
						<?php endwhile; 
						
					} ?>
					
						</div>
					<nav id="pagination"><?php echo paginate_links(); ?></nav>

				<?php else : ?>

					<?php get_template_part( 'content', 'none' ); ?>

				<?php endif; ?>

			</article><!-- /article -->

		</main><!-- #main -->
	</section><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>
