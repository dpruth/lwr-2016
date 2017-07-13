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

<main class="site-main" id="main">
	<div class="row">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php	get_template_part( 'loop-templates/content', 'page' ); ?>


				<?php endwhile; // end of the loop. ?>
	</div>
</main><!-- #main -->

					<?php
						get_template_part( 'template-parts/custom', 'videos' );
						get_template_part( 'template-parts/projects', 'location' );
						get_template_part( 'template-parts/projects', 'current' );
						get_template_part( 'template-parts/related', 'resources' );
						get_template_part( 'template-parts/contact', 'info' );
					?>


<?php get_footer(); ?>
