<?php
/**
 * @package storefront
 */
?>

				<?php 
				$countries = get_the_terms( $post->ID, 'country' );	
				
				if ( $countries == false ) {
					$args = array(
					'order' => 'DESC',
					'orderby' => 'date',
					'posts_per_page' 	=> 3,
					'post_type' => 'lwr_videos'
					);
				}
				else {	foreach ($countries as $country) {
						$slugs[] = $country->slug;
					}
				$args = array( 
					'order' => 'DESC',
					'orderby' => 'date',
					'posts_per_page' 	=> 3,
					'post_type' => 'lwr_videos',
					'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'country',
						'field' => 'slug',
						'terms' => $slugs
						)
					)
					);
				}
				$video_query = new WP_Query( $args );
				if ( $video_query->have_posts() ) : ?>
<div class="page-section animated-object" id="videos">
	<div class="page-section-header">
		<img src="<?php echo get_stylesheet_directory_uri() . '/img/videos-icon-sm.png'; ?>" alt="" />
		<h2>VIDEOS</h2>
	</div>

	<div class="horizontal-list three-item-list">

				<?php 
					while ( $video_query->have_posts() ) :
						$video_query->the_post(); ?>
						<a href="<?php the_permalink(); ?>">
							<div class="img-limit"><?php the_post_thumbnail('medium'); ?><div class="video-overlay"></div></div>							
							<h2><?php the_title(); ?></h2>
						</a>
						<?php 
					endwhile;								 
				wp_reset_postdata(); 
					
				?>
	<a href="/videos" class="text-only">View All Videos&raquo;</a>

	</div>
	
</div><!-- #current-videos-## -->

<?php endif; ?>