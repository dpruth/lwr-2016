<?php
/**
 * Single post partial template.
 *
 * @package lwr
 */

?>
<article <?php post_class('container'); ?> id="post-<?php the_ID(); ?>">

	
	<header class="entry-header jumbotron">

		<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
		<div class="d-flex justify-content-center" itemprop="video">
			<?php 
			$iframe = get_field('video_url');
			preg_match('/src="(.+?)"/', $iframe, $matches);
			$src = $matches[1];
		
			$params = array( 'rel' => 0 );
			$new_src = add_query_arg($params, $src);
			$iframe = str_replace($src, $new_src, $iframe);
		
			echo $iframe; ?>
		</div>
		
	</header><!-- .entry-header -->
	
	

			<?php lwr_social_media_links(); ?>
			
	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'lwr' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->
	
	
	<footer class="entry-footer">

		<?php lwr_entry_footer(); ?>

	</footer><!-- .entry-footer -->


</article><!-- #post-## -->

