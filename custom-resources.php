<?php
/**
 * @package storefront
 */

			$countries = get_the_terms( $post->ID, 'country' );	
			if ( !empty($countries) ) {
				foreach ($countries as $country) {
					$c_slugs[] = $country->slug;
				}
				$c_taxQuery = array(
							'taxonomy' => 'country',
							'field' => 'slug',
							'terms' => $c_slugs
						);
			}
			$sectors = get_the_terms( $post->ID, 'sector' );
			if ( !empty($sectors) ) {
				foreach ($sectors as $sector) {
					$s_slugs[] = $sector->slug;
				}
				$s_taxQuery = array(
							'taxonomy' => 'sector',
							'field' => 'slug',
							'terms' => $s_slugs
							);

			}
			/*****************
				Master Query for IF Statement
			******************/
			$args = array(
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'attachment',
				'post_status' => 'all',
				'posts_per_page' => -1,
				'tax_query' => array(
					'relation' => 'AND',				
					array(
						'taxonomy' => 'media_category',
						'field' => 'term_id',
						'terms' => array( 29, 235, 31, 339, 30, 338, 32 )
						),
					array(
						'relation' => 'OR',
						$c_taxQuery,
						$s_taxQuery,
					)
				)
			);
			$the_query = new WP_Query( $args );

			if ( $the_query->have_posts() ) : ?>
<div class="page-section animated-object" id="resources" >
	<div class="page-section-header">
		<img src="<?php echo get_stylesheet_directory_uri() . '/img/resources-icon-sm.png'; ?>" alt="" />
		<h2>RELATED RESOURCES</h2>
	</div>

	<div class="horizontal-list">
	
		<?php 
		
		wp_reset_postdata(); 
		
		// COUNTRY PROFILE Query
			$args = array(
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'attachment',
				'post_status' => 'all',
				'tax_query' => array(
					'relation' => 'AND',				
					array(
						'taxonomy' => 'media_category',
						'field' => 'term_id',
						'terms' => 32 
						),
					array(
						'relation' => 'OR',
						$c_taxQuery,
						$s_taxQuery,
					)
				)
			);

		$cp_query = new WP_Query( $args ); 
		
		if ( $cp_query->have_posts() ) : 			
				while ( $cp_query->have_posts() ) :
					$cp_query->the_post(); ?>
					<a href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail() ) {
										the_post_thumbnail('thumbnail');
									}
									else {
										echo wp_get_attachment_image( get_the_id(), 'thumbnail');
									} ?>
						<h2><?php the_title(); ?></h2>
					</a>
					<?php
				endwhile; 
				wp_reset_postdata();
		endif;
		
		// TECHNICAL PROFILE Query
			$args = array(
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'attachment',
				'post_status' => 'all',
				'tax_query' => array(
					'relation' => 'AND',				
					array(
						'taxonomy' => 'media_category',
						'field' => 'term_id',
						'terms' => 235
						),
					array(
						'relation' => 'OR',
						$c_taxQuery,
						$s_taxQuery,
					)
				)
			);

		$tp_query = new WP_Query( $args ); 
		
		if ( $tp_query->have_posts() ) :
			
				while ( $tp_query->have_posts() ) :
					$tp_query->the_post(); ?>
					<a href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail() ) {
										the_post_thumbnail('thumbnail');
									}
									else {
										echo wp_get_attachment_image( get_the_id(), 'thumbnail');
									} ?>
						<h2><?php the_title(); ?></h2>
					</a>
					<?php
				endwhile; 
				wp_reset_postdata();
		endif;
	
		// SITREP Query
			$args = array(
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'attachment',
				'post_status' => 'all',
				'tax_query' => array(
					'relation' => 'AND',				
					array(
						'taxonomy' => 'media_category',
						'field' => 'term_id',
						'terms' => 29
						),
					array(
						'relation' => 'OR',
						$c_taxQuery,
						$s_taxQuery,
					)
				)
			);

		$sr_query = new WP_Query( $args ); 
		
		if ( $sr_query->have_posts() ) : 			
				while ( $sr_query->have_posts() ) :
					$sr_query->the_post(); ?>
					<a href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail() ) {
										the_post_thumbnail('thumbnail');
									}
									else {
										echo wp_get_attachment_image( get_the_id(), 'thumbnail');
									} ?>
						<h2><?php the_title(); ?></h2>
					</a>
					<?php
				endwhile; 
				wp_reset_postdata();		
		endif;
		
		// FACTSHEET Query
			$args = array(
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'attachment',
				'post_status' => 'all',
				'tax_query' => array(
					'relation' => 'AND',				
					array(
						'taxonomy' => 'media_category',
						'field' => 'term_id',
						'terms' => 30
						),
					array(
						'relation' => 'OR',
						$c_taxQuery,
						$s_taxQuery,
					)
				)
			);

		$fs_query = new WP_Query( $args ); 
		
		if ( $fs_query->have_posts() ) : 			
				while ( $fs_query->have_posts() ) :
					$fs_query->the_post(); ?>
					<a href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail() ) {
										the_post_thumbnail('thumbnail');
									}
									else {
										echo wp_get_attachment_image( get_the_id(), 'thumbnail');
									}?>
						<h2><?php the_title(); ?></h2>
					</a>

					<?php
				endwhile; 
				wp_reset_postdata();
		endif;

		// MANUALS AND TOOLKITS Query
			$args = array(
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'attachment',
				'post_status' => 'all',
				'tax_query' => array(
					'relation' => 'AND',				
					array(
						'taxonomy' => 'media_category',
						'field' => 'term_id',
						'terms' => 339
						),
					array(
						'relation' => 'OR',
						$c_taxQuery,
						$s_taxQuery,
					)
				)
			);

		$mt_query = new WP_Query( $args ); 
		
		if ( $mt_query->have_posts() ) : 			
				while ( $mt_query->have_posts() ) :
					$mt_query->the_post(); ?>
					<a href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail() ) {
										the_post_thumbnail('thumbnail');
									}
									else {
										echo wp_get_attachment_image( get_the_id(), 'thumbnail');
									} ?>
						<h2><?php the_title(); ?></h2>

					</a>

					<?php
				endwhile; 
				wp_reset_postdata();		
		endif;

		// EVALUATIONS Query
			$args = array(
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'attachment',
				'post_status' => 'all',
				'tax_query' => array(
					'relation' => 'AND',				
					array(
						'taxonomy' => 'media_category',
						'field' => 'term_id',
						'terms' => 338
						),
					array(
						'taxonomy' => 'country',
						'field' => 'slug',
						'terms' => $c_slugs
						),
				)
			);

		$ev_query = new WP_Query( $args ); 
		
		if ( $ev_query->have_posts() ) : 			
				while ( $ev_query->have_posts() ) :
					$ev_query->the_post(); ?>
					<a href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail() ) {
										the_post_thumbnail('thumbnail');
									}
									else {
										echo wp_get_attachment_image( get_the_id(), 'thumbnail');
									} ?>
						<h2><?php the_title(); ?></h2>
						
					</a>

					<?php
				endwhile; 
				wp_reset_postdata();
		endif;
				?>
		
	</div>
</div>	<?php
		endif;
	?><!-- #resources-## -->

