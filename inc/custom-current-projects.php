<?php
/**
 * @package storefront
 */

function add_current_projects_start() { ?>

<div class="page-section animated-object" id="current-projects">
	<div class="page-section-header">
		<img src="<?php echo get_stylesheet_directory_uri() . '/img/projects-icon-sm.png'; ?>" alt="" />
		<h2><?php if ( is_page( 'what-we-do' ) ) {
								echo 'RECENTLY ADDED PROJECTS';
							} else {
								echo 'CURRENT PROJECTS';
							}
		?></h2>
	</div>

	<div class="horizontal-list">

		<?php
}
add_action('current_projects_start', 'add_current_projects_start' );

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
				do_action('current_projects_start');
				
				while ( $the_query->have_posts() ) {
					$the_query->the_post(); ?>

					<a href="<?php echo the_permalink(); ?>">
						<div class="img-limit"><?php 
							if ( has_post_thumbnail() ) {
								echo the_post_thumbnail( array(350, 200) ); 
							} 
							else { ?>
							<img src="<?php echo get_stylesheet_directory_uri() . '/img/blankproject.png';?>" alt="<?php echo the_title(); ?>" />
							<?php }
							
							?></div>
						<?php 
							if ( is_page('what-we-do') ) {
							$countries = get_the_terms( $post->ID, 'country' );	
			
							foreach ($countries as $country) {
								$name = $country->name;
							}
							
							$start_date = get_field('project_dates');
							$end_date = get_field('project_end_date');
							
								echo '<h3>' . esc_html( $name ) . ' | <small>' . esc_html($start_date) . ' to ' . esc_html($end_date) . '</small></h3>';
								the_title( '<h2>', '</h2>', true);
								
							} else { 
								the_title('<h2>', '</h2>'); 
							}
							?>
					</a>

					<?php
				} ?>
		</div>
</div> <?php 
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
		<div style="margin: 0 auto; padding-bottom: 64px; width: 79%;">
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
	