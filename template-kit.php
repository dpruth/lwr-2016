<?php
/**
 * Template Name: Kits of Care Template
 * Template Description: The template for displaying Kits of Care pages.
 *
 *  *
 * @package lwr
 */

get_header();

$container   = get_theme_mod( 'lwr_container_type' );
$sidebar_pos = get_theme_mod( 'lwr_sidebar_position' );

?>

<main class="site-main" id="main">
	<div class="row">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php	get_template_part( 'page-templates/content', 'kits' ); ?>

					
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // end of the loop. ?>
	</div>
</main><!-- #main -->

	<hr />


<?php get_footer(); ?>
