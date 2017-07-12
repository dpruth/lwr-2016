<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package lwr
 */


// STYLE FIRST POST DIFFERENTLY

 if( $wp_query->current_post == 0 && !is_paged() && !is_post_type_archive('pressrelease') ) :  ?>
<div class="col-12 mb-3">
<article <?php post_class('row'); ?> id="post-<?php the_ID(); ?>">
	
	<?php 	
	/*
	 * INCLUDE VIDEO OVERLAY IF VIDEO ARCHIVE
	 */
	
		if( is_post_type_archive('lwr_videos') ) { ?>
			<div class="video-thumbnail col-sm-6">
				<a href="<?php the_permalink(); ?>">
				<?php echo get_the_post_thumbnail( $post->ID, 'large', array( 'class' => 'rounded col-md-8 img-fluid' ) ); ?>

				<div class="video-overlay"><i class="fa fa-play-circle-o"></i></div>
				</a>
			</div>
		<?php
		} else { // ALL OTHER INDEXES & ARCHIVES
			?>
			<div class="col-sm-6">
				<?php echo get_the_post_thumbnail( $post->ID, 'large', array( 'class' => 'rounded img-fluid' ) ); ?>
			</div>
			<?php
		}
	?>
	<div class="col-sm-6">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
		'</a></h2>' ); ?>
	
		<?php
		the_excerpt();
		?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'lwr' ),
			'after'  => '</div>',
		) );
		?>
	
			<?php if ( 'post' == get_post_type() ) : ?>

			<div class="entry-meta">
				<?php lwr_posted_on(); ?>
			</div><!-- .entry-meta -->

			<?php endif; ?>
	</div>

</article><!-- #post-## -->
</div>
<div class="col-md-12">
	<hr />
</div>

<?php else : // Layout for all other posts ?>

<div class="col-sm-6 col-md-4 col-lg-3">
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
		} else { // ALL OTHER INDEXES & ARCHIVES ?>
			<div class="img-fluid">
				<?php echo get_the_post_thumbnail( $post->ID, 'large', array( 'class' => 'card-img-top' ) ); ?>
			</div>
			<?php
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
</div>
<?php endif; ?>
