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

?>

<main class="site-main container-fluid" id="main">
	<div class="row">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php	get_template_part( 'loop-templates/content', 'page' ); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // end of the loop. ?>
	</div>
</main><!-- #main -->

					<?php	// Get additional template parts for Agriculture, Climate & EOps pages
								if ( is_page( array(55, 386, 388) ) ) {
									get_template_part( 'template-parts/projects', 'location' );		get_template_part( 'template-parts/related', 'resources' );
								} ?>

	<hr />


<?php get_footer(); ?>
