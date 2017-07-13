<?php
/**
 * Partial template for content in page.php
 *
 * @package lwr
 */

?>
<article <?php post_class('col-12 px-0'); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header jumbotron <?php 
			if(has_post_thumbnail() ) { 
				$thumbnail_url = get_the_post_thumbnail_url(null, 'full');
				echo 'has-full-width-image"';
				echo ' id="hero_image"';
				?>
				style="background-image: url('<?php echo $thumbnail_url; ?>'); <?php
			} ?>">

		<?php the_title( '<h1 class="entry-title display-3">', '</h1>' ); ?>

	</header><!-- .entry-header -->

		<?php	if(has_post_thumbnail() ) { ?>
				<div class="caption"><?php	the_post_thumbnail_caption(); ?></div>
		<?php } ?>

	<div class="container">

			<?php lwr_social_media_links(); ?>

	<div class="entry-content">

		<?php the_content(); ?>

		<?php	if ( is_page( array( 92, 93 ) ) ) {
						add_authorize_net_seal();
					}	?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'lwr' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->
	
			<?php lwr_social_media_links(); ?>

	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'lwr' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->
	
	</div><!-- .container -->

</article><!-- #post-## -->
