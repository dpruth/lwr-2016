<?php
/**
 * @package storefront
 */
?>

<div class="page-section animated-object" id="publications">
	<div class="page-section-header">
		<img src="<?php echo get_stylesheet_directory_uri() . '/img/publications-icon-sm.png'; ?>" alt="" />
		<h2>PUBLICATIONS</h2>
	</div>

	<div class="stories-list">

		<div>
			<h2>LWR SPECIAL REPORTS</h2>
			<p><em>LWR&rsquo;s newsletter featuring the people, families and projects you support</em></p>
			
			<div class="issue-info">
				<h3>Most Recent Issue:</h3>
			
			<?php
				$args = array(
					'posts_per_page' => 1,
					'orderby' => 'date',
					'order' => 'DESC',
					'tax_query' => array(
						array(
						'taxonomy' => 'product_cat',
						'field' => 'slug',
						'terms' => 'special-reports',
						)
					)
				);
				$sr_query = new WP_Query( $args );
				while ( $sr_query->have_posts() ) {
					$sr_query->the_post(); 
					echo '<a href="' . get_the_permalink() . '">';
					the_post_thumbnail('medium'); 
					echo '</a>';
					
				$issues = get_categories( array(
									'orderby' => 'term_id',
									'order' => 'DESC',
									'parent' => 181,
									'number' => 1
									)
								);
				foreach ( $issues as $issue ) {
					$category_id = $issue->term_id;
					$category_link = get_category_link( $category_id );
					
					echo '<h3>' . esc_attr($issue->name) . '</h3>';
				} ?>
					<p>&nbsp;</p>
					<p><a href="<?php the_permalink(); ?>" class="button">Order a Copy&raquo;</a></p>
					<p><a href="<?php echo esc_url( $category_link ) ?>">Read stories from this issue&raquo;</a></p>
				<?php
				}
				wp_reset_postdata();
			
				?>
				</div>
				
				<h3>Recent Stories:</h3>
				<?php
			

				$args = array( 
					'order' => 'DESC',
					'orderby' => 'date',
					'posts_per_page' 	=> 2,
					'category_name' => 'special-reports'
					);
				$blog_query = new WP_Query( $args );
				
					while ( $blog_query->have_posts() ){
						$blog_query->the_post(); ?>
					<a href="<?php the_permalink() ?>"><?php if( has_post_thumbnail() ){  the_post_thumbnail( array(350, 200) ); } else { echo '<img src="' . get_stylesheet_directory_uri() . '/img/blankproject.png" class="wp-post-image" />'; } ?>    
					<h2><?php the_title(); ?></h2>
					<p>by <?php the_author(); ?></p>
					</a>
										
					<?php 
					}								 
				wp_reset_postdata(); 
					
				?>
			<a href="<?php echo esc_url( $category_link ); ?>" class="text-only">View all stories from <?php echo esc_attr($issue->name); ?>&raquo;</a><br />
			<a href="<?php echo esc_url( get_category_link( '181' ) ); ?>">View all Special Reports stories&raquo;</a>
		</div>

		<div>
			<h2>FAITH IN ACTION</h2>
			<p><em>A newsletter especially for LWR Quilters &amp; Kit Makers</em></p>
			
			<div class="issue-info">
				<h3>Most Recent Issue:</h3>
			<?php
				$args = array(
					'posts_per_page' => 1,
					'post_type' => 'attachment',
					'post_status' => 'any',
					'orderby' => 'date',
					'order' => 'DESC',
					'tax_query' => array(
						array(
						'taxonomy' => 'media_category',
						'field' => 'slug',
						'terms' => 'faith-in-action',
						)
					)
				);
				$sr_query = new WP_Query( $args );
				while ( $sr_query->have_posts() ) {
					$sr_query->the_post(); 
					echo '<a href="' . get_the_permalink() . '">';
					the_post_thumbnail('medium'); 
					echo '</a>';
					
				$issues = get_categories( array(
									'orderby' => 'term_id',
									'order' => 'DESC',
									'parent' => 183,
									'number' => 1
									)
								);
				foreach ( $issues as $issue ) {
					$category_id = $issue->term_id;
					$category_link = get_category_link( $category_id );
					
					echo '<h3>' . esc_attr($issue->name) . '</h3>';
				} ?>
					<p>&nbsp;</p>
					<p><a href="<?php the_permalink(); ?>" class="button">Download a Copy&raquo;</a></p>
					<p><a href="<?php echo esc_url( $category_link ) ?>">Read stories from this issue&raquo;</a></p>
				<?php
				}
				wp_reset_postdata();
			
				?>
			</div>
			
				<h3>Recent Stories:</h3>
				<?php

			 $args = array( 
					'order' => 'DESC',
					'orderby' => 'date',
					'posts_per_page' 	=> 2,
					'category_name' => 'faith-in-action'
					);
				$fia_query = new WP_Query( $args );
				
					while ( $fia_query->have_posts() ){
						$fia_query->the_post(); ?>
					<a href="<?php the_permalink() ?>"><?php if( has_post_thumbnail() ){  the_post_thumbnail( array(350, 200) ); } else { echo '<img src="' . get_stylesheet_directory_uri() . '/img/blankproject.png" class="wp-post-image" />'; } ?>    
					<h2><?php the_title(); ?></h2>
					<p>by <?php the_author(); ?></p>
					</a>
										
					<?php 
					}								 
				wp_reset_postdata(); 
					
				?>
			<a href="<?php echo esc_url( $category_link ); ?>" class="text-only">View all stories from <?php echo esc_attr($issue->name); ?>&raquo;</a><br />
			<a href="<?php echo esc_url( get_category_link( '183' ) ); ?>">View all Faith in Action stories&raquo;</a>

		</div>

	</div>
</div><!-- #publications-## -->