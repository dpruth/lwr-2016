<?php
/**
 * Single post partial template.
 *
 * @package lwr
 */

?>
<article <?php post_class('col-12 px-0'); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header jumbotron <?php 
			if(has_post_thumbnail() ) { 
				$thumbnail_url = get_the_post_thumbnail_url(null, 'full');
				echo 'has-full-width-image jumbotron-fluid"';
				echo ' id="hero_image"';
				?>
				style="background-image: url('<?php echo $thumbnail_url; ?>'); <?php
			} ?>">
		<?php // the_post_thumbnail( 'full' ); ?>

		<?php the_title( '<h1 class="entry-title display-3">', '</h1>' ); ?>

	</header><!-- .entry-header -->
	
		<?php	if(has_post_thumbnail() ) { ?>
				<div class="caption"><?php	the_post_thumbnail_caption(); ?></div>
		<?php } ?>

		<?php if( get_post_type() == 'project' ) { 
					$start_date = get_field('project_dates');
					$end_date = get_field('project_end_date'); ?>
			<div class="entry-meta text-center">
				<p>Project Dates: <?php echo esc_html( $start_date ); ?> to <?php echo esc_html( $end_date ); ?></p>
			</div> <?php
		} else {
			?>
			<div class="entry-meta author-info">
				<?php lwr_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php } ?>
		
	<div class="container">
	

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
		
				<?php lwr_social_media_links(); ?>

	
	<footer class="entry-footer">

		<?php lwr_entry_footer(); ?>

	</footer><!-- .entry-footer -->

	</div><!-- .container -->

</article><!-- #post-## -->

