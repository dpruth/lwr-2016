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
			} else { $c_taxQuery = array(); }
			
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

			} else { $s_taxQuery = array(); }
			
			
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
<section class="container-fluid animated-object" id="resources" >
	<div class="row">
	<div class="page-section-header">
		<h2><i class="fa fa-file-pdf-o"></i> RELATED RESOURCES</h2>
	</div>
	<div class="container">
		<div class="row justify-content-center">
		<?php 
		
		wp_reset_postdata(); 
		
		$media_categories = array(
			'country profile' => 32,
			'technical profile' => 235,
			'situation report' => 29,
			'fact sheet' => 30,
			'manuals and toolkits' => 339,
			'evaluations' => 338
		);
		
		foreach ( $media_categories as $media_category=>$term_id ) {
			
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
						'terms' => $term_id 
						),
					array(
						'relation' => 'OR',
						$c_taxQuery,
						$s_taxQuery,
					)
				)
			);

			$query = new WP_Query( $args ); 
		
			if ( $query->have_posts() ) : 			
				while ( $query->have_posts() ) :
					$query->the_post(); ?>
					<a href="<?php the_permalink(); ?>" class="col-sm-4 col-md-3">
						<?php if (has_post_thumbnail() ) {
										the_post_thumbnail('thumbnail');
									}
									else {
										echo wp_get_attachment_image( get_the_id(), 'thumbnail');
									} ?>
						<h3 class="h4"><?php the_title(); ?></h3>
					</a>
					<?php
				endwhile; 
				wp_reset_postdata();
			endif;

		}
		?>
		</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .row -->
</section><!-- .container-fluid -->	<?php
		endif;
	?>