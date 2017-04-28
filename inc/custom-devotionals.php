<?php
/**
 * @package storefront
 */
?>

<div class="page-section animated-object" id="devotionals">
	<div class="page-section-header">
		<img src="<?php echo get_stylesheet_directory_uri() . '/img/publications-icon-sm.png'; ?>" alt="" />
		<h2>DEVOTIONALS</h2>
	</div>

	<div class="stories-list">
		<div>
				<?php $args = array( 
					'order' => 'DESC',
					'orderby' => 'date',
					'posts_per_page' 	=> 2,
					'cat' => 227
					);
				$blog_query = new WP_Query( $args );
				
					while ( $blog_query->have_posts() ){
						$blog_query->the_post(); ?>
					<a href="<?php the_permalink() ?>"><?php if( has_post_thumbnail() ){  the_post_thumbnail( array(350, 200) ); } else { echo '<img src="' . get_stylesheet_directory_uri() . '/img/blankproject.png" class="wp-post-image" />'; } ?>    
					<h2><?php the_title(); ?></h2>
					<?php the_excerpt(); ?>
					</a>
										
					<?php 
					}								 
				wp_reset_postdata(); 
					
				?>


		</div>

		<div>
			<?php $args = array( 
					'order' => 'DESC',
					'orderby' => 'date',
					'posts_per_page' 	=> 2,
					'offset' => 2,
					'cat' => 227
					);
				$sr_query = new WP_Query( $args );
				
					while ( $sr_query->have_posts() ){
						$sr_query->the_post(); ?>
					<a href="<?php the_permalink() ?>"><?php if( has_post_thumbnail() ){  the_post_thumbnail( array(350, 200) ); } else { echo '<img src="' . get_stylesheet_directory_uri() . '/img/blankproject.png" class="wp-post-image" />'; } ?> 
					<h2><?php the_title(); ?></h2>
					<?php the_excerpt(); ?>
					</a>
					
					<?php 
					}								 
				wp_reset_postdata(); 
					
				?>
			<a href="<?php echo esc_url( get_category_link('227') ); ?>" class="text-only">View all Devotionals &raquo;</a>
		</div>

	</div>
</div><!-- #publications-## -->