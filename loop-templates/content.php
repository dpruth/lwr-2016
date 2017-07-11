<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package lwr
 */


// STYLE FIRST POST DIFFERENTLY

 if( $wp_query->current_post == 0 && !is_paged() && !is_post_type_archive('pressrelease') ) :  ?>

<article <?php post_class('featured mb-3 row py-3'); ?> id="post-<?php the_ID(); ?>">
	
	<?php 	
	/*
	 * INCLUDE VIDEO OVERLAY IF VIDEO ARCHIVE
	 */
	
		if( is_post_type_archive('lwr_videos') ) { ?>
			<div class="video-thumbnail">
				<a href="<?php the_permalink(); ?>">
				<?php echo get_the_post_thumbnail( $post->ID, 'large', array( 'class' => 'rounded col-md-8 img-fluid' ) ); ?>

				<div class="video-overlay"><i class="fa fa-play-circle-o"></i></div>
				</a>
			</div>
		<?php
		} else { // ALL OTHER INDEXES & ARCHIVES
				echo get_the_post_thumbnail( $post->ID, 'large', array( 'class' => 'rounded col-md-8 img-fluid' ) ); 
		}
	?>
	<div class="col-md-4">
	<header class="entry-header">
	<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
		'</a></h2>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php
		the_excerpt();
		?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'lwr' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->
			<?php if ( 'post' == get_post_type() ) : ?>

			<div class="entry-meta">
				<?php lwr_posted_on(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

</article><!-- #post-## -->
<div class="col-md-12">
	<hr />
</div>

<?php 
// Layout for all other posts
else : 
if ( is_paged() || is_post_type_archive('pressrelease') ) {
	if( $wp_query->current_post % 2 == 0 ) { echo '<div class="card-deck justify-content-center mt-3">'; }
} else {
	if( $wp_query->current_post % 2 != 0 ) { echo '<div class="card-deck justify-content-center mt-3">'; } 
} ?>
<article <?php post_class('card'); ?> id="post-<?php the_ID(); ?>">

	<?php 	
	/*
	 * INCLUDE VIDEO OVERLAY IF VIDEO ARCHIVE
	 */
	
		if( is_post_type_archive('lwr_videos') ) { ?>
			<div class="video-thumbnail">
				<a href="<?php the_permalink(); ?>">
				<?php echo get_the_post_thumbnail( $post->ID, 'large', array( 'class' => 'card-img-top' ) ); ?>
				<div class="video-overlay"><i class="fa fa-play-circle-o"></i></div>
				</a>
			</div>
		<?php
		} else { // ALL OTHER INDEXES & ARCHIVES
				echo get_the_post_thumbnail( $post->ID, 'large', array( 'class' => 'card-img-top' ) ); 
		}?>

    <div class="card-block" >
		<?php the_title( sprintf( '<h2 class="card-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
		'</a></h2>' ); ?>

		<p class="card-text"><?php echo wp_strip_all_tags( get_the_excerpt(), true); ?></p>
					<a class="btn btn-primary" href="<?php the_permalink(); ?>">Read More</a>
		</div>
		<footer class="entry-meta card-footer">
				<?php lwr_posted_on(); ?>
		</footer><!-- .entry-meta -->

</article><!-- #post-## -->

<?php 

if ( is_paged() || is_post_type_archive('pressrelease') ) {
	if( $wp_query->current_post % 2 != 0 ) { echo '</div>'; }
} else {
	if( $wp_query->current_post % 2 == 0 ) { echo '</div>'; }
}
endif; ?>
