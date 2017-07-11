<?php
/**
 * @package storefront
 */

function current_projects_start() { ?>

<section class="container-fluid animated-object" id="current-projects">
	<div class="row">
	<div class="page-section-header">
		<h2><i class="fa fa-cogs" aria-hidden="true"></i> <?php
				if ( is_page( 'what-we-do' ) ) {
					echo 'RECENTLY ADDED PROJECTS';
				} else {
					echo 'CURRENT PROJECTS';
				}
		?></h2>
	</div>

	<div class="container">
	<div class="card-deck">
		<?php
}


			$today = date('Ymd');
			
			if( is_page_template( 'template-country.php' ) ) {
					$countries = get_the_terms( $post->ID, 'country' );	
			
					foreach ($countries as $country) {
						$slugs[] = $country->slug;
					}
					$tax_query[] = array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'country',
							'field' => 'slug',
							'terms' => $slugs
						),
						array(
							'taxonomy' => 'sector',
							'field' => 'slug',
							'terms' => 'distribution', // Filter out Q&K Distributions
							'operator' => 'NOT IN'
						)
					);
			} else { 
					$tax_query[] = array(
						'taxonomy' => 'sector',
						'field' => 'slug',
						'terms' => 'distribution', // Filter out Q&K Distributions
						'operator' => 'NOT IN'
						);
			}
			
			$args = array(
				'orderby' => 'meta_value_num',
				'meta_key' => 'project_dates',
				'order' => 'DESC',
				'posts_per_page' => 12,
				'post_type' => 'project',
				'tax_query' => $tax_query,					
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key' => 'project_end_date',
						'compare' => 'NOT EXISTS'
					),
					array(
						'key' => 'project_end_date',
						'compare' => '>=',
						'value' => $today
					)
				)
			);
			$the_query = new WP_Query( $args );

			if ( $the_query->have_posts() ) {
				
				current_projects_start();
				
				while ( $the_query->have_posts() ) {
					$the_query->the_post(); ?>
					<div class="card">
						<a href="<?php echo the_permalink(); ?>"><?php 
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'medium' ); 
							} 
							else { ?>
							<img src="<?php echo get_stylesheet_directory_uri() . '/img/blankproject.png';?>" alt="<?php echo the_title(); ?>" />
							<?php }
							
							?></a>
						<div class="card-block">
						
						<?php 
							if ( is_page('what-we-do') ) {
							$countries = get_the_terms( $post->ID, 'country' );	
			
							foreach ($countries as $country) {
								$name = $country->name;
							}
							
							$start_date = get_field('project_dates');
							$end_date = get_field('project_end_date');
								?>
								<p class="card-text"><?php echo esc_html( $name ); ?> | <small><?php echo esc_html($start_date) . ' to ' . esc_html($end_date); ?></small></p>
								<h2 class="card-title"><a href="<?php the_permalink(); ?>"><?php			the_title(); ?></h2>
								<?php
							} else { ?>
								<h2 class="card-title"><a href="<?php the_permalink(); ?>"><?php			the_title(); ?></h2>
								<?php
							}
							?>
						</div><!-- .card-block -->
					</div><!-- .card -->

					<?php
				} ?>
		</div><!-- .card-deck -->
	<?php 
			} 
			
			wp_reset_postdata();
	
	
	// PAST PROJECTS
	if( is_page_template( 'template-country.php' ) ) {

			$countries = get_the_terms( $post->ID, 'country' );	
			foreach ($countries as $country) {
				$slugs[] = $country->slug;
			}
			$today = date('Ymd');
			
			$args = array(
				'meta_key' => 'project_end_date',
				'orderby' => 'meta_value_datetime',
				'order' => 'DESC',
				'post_type' => 'project',
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'country',
						'field' => 'slug',
						'terms' => $slugs
						)
					),
				'meta_query' => array(
					array(
						'key' => 'project_end_date',
						'compare' => '<',
						'value' => $today
					)
				)
			);
			$the_query = new WP_Query( $args );

			if ( $the_query->have_posts() ) { ?>
			<h3>PAST PROJECTS</h3>
				<ul> <?php
				while ( $the_query->have_posts() ) {
					$the_query->the_post(); ?>
					<li><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a> | Ended: <?php the_field('project_end_date'); ?></li>

					<?php
				} ?>
				</ul>
		</div> 
<?php
			} 

			wp_reset_postdata();
		
	} ?>
	</div><!-- .row -->
</section>