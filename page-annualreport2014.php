<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<link href="<?php echo get_stylesheet_directory_uri() . "/inc/ar14_style.css"; ?>" rel="stylesheet" type="text/css" />
					<script src="<?php echo get_stylesheet_directory_uri() . "/js/ar14_script.js"; ?>" type="text/javascript"></script><!--[if lte IE 9]>
					<script>
						jQuery(function() {	ie9 = true;	for(var i = 0; i < elemArr.length; i++) { $("div#" + elemArr[i]).removeClass("shift"); }	$(window).on("scroll", function() { $("div#ar14").removeClass("json"); });	});
					</script><!--[endif]-->

				<header class="entry-header">
					<?php
					storefront_post_thumbnail( 'full' );
					the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' );
					?>
				</header><!-- .entry-header -->

				<div class="entry-content" itemprop="mainContentOfPage">
					<?php the_content(); ?>
					<?php	
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
							'after'  => '</div>',
						) );
					?>
				</div><!-- .entry-content -->
					
				</article><!-- #post-## -->

				<?php
				/**
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>
