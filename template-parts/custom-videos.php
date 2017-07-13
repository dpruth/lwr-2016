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
<section class="container-fluid" id="videos">
	<div class="row">
	
	<div class="page-section-header">
		<h2><i class="fa fa-play-circle-o"></i> VIDEOS</h2>
	</div>

	<div class="container">
	<div class="card-deck">

				<?php 
					while ( $video_query->have_posts() ) :
						$video_query->the_post(); ?>
						<div class="card">
							<div class="video-thumbnail">
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?>
								<div class="video-overlay"><i class="fa fa-play-circle-o"></i></div>
								</a>
							</div>
							<div class="card-block">
							<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							</div>
						</div>
						<?php 
					endwhile;								 
				wp_reset_postdata(); 
					
				?>

	</div><!-- .card-deck -->
	<a href="<?php echo esc_url( get_post_type_archive_link('lwr_videos') ); ?>" class="text-only">View All Videos&raquo;</a>
	</div><!-- .container -->
	
	</div><!-- .row -->
</section><!-- #videos -->

<?php endif; ?>