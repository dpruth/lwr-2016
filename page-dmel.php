<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package lwr
 */

get_header();

$container   = get_theme_mod( 'lwr_container_type' );
$sidebar_pos = get_theme_mod( 'lwr_sidebar_position' );

?>

<div class="wrapper" id="page-wrapper">

	<div class="container-fluid" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check', 'none' ); ?>

			<main class="site-main dmel" id="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						wp_enqueue_script( 'cool_find_script', get_stylesheet_directory_uri() . '/js/find6.js' );
						wp_enqueue_script( 'dmel-scripts', get_stylesheet_directory_uri() . '/js/dmel-scripts.js' );

		        get_template_part('page-templates/dmel', 'header');
						get_template_part('page-templates/dmel', 'diagram');
						get_template_part('page-templates/dmel', 'phase-1');
						get_template_part('page-templates/dmel', 'phase-2');
						get_template_part('page-templates/dmel', 'phase-3');
						get_template_part('page-templates/dmel', 'phase-4');
					
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>

			<?php get_sidebar( 'right' ); ?>

		<?php endif; ?>

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
