<?php
/**
 * The template for displaying all single posts.
 *
 * @package lwr
 */

get_header();
$container   = get_theme_mod( 'lwr_container_type' );
$sidebar_pos = get_theme_mod( 'lwr_sidebar_position' );
?>

<main class="site-main container-fluid" id="main">
	<div class="row">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php 
					switch( get_post_type() ) {
						case 'lwr_videos': 
							get_template_part( 'loop-templates/content', 'video');
							break;
						case 'staffmember':
							get_template_part( 'loop-templates/content', 'staff');
							break;
						case 'ingathering':
							get_template_part( 'loop-templates/content', 'ingathering');
							break;
						default:
							get_template_part( 'loop-templates/content', 'single' ); 
					}?>
	</div>
	
	<div class="row">
		<?php lwr_post_nav(); ?>
	</div>
</main><!-- #main -->

			<?php if( get_post_type() == 'project' ) { 
							get_template_part('template-parts/projects', 'location' );
							get_template_part('template-parts/custom', 'videos' );
						} ?>
	<hr />
	
			<?php get_template_part('inc/related', 'stories' ); ?>

	<hr />
	
	<section class="comments container">
	<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
	</section>
				<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>
