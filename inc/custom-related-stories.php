<?php
/**
 * @package storefront
 */
?>

	<?php 
	
	function lwr_start_related_stories() {
		?><div class="horizontal-list three-item-list" id="related-stories">
		<h2><?php
					if( 'project' == get_post_type() || is_page_template('template-country.php') ) {
						echo esc_html('Related Stories');
					} else {
						echo esc_html('Other Stories You May be Interested in:');
					} ?></h2>
		<div>		<?php
	}
	add_action( 'lwr_related_stories_header', 'lwr_start_related_stories' );
	
	/***********************
		The Template for displaying stories
	***********************/
	function lwr_add_related_stories() {
		?>
					<a href="<?php echo the_permalink(); ?>">
						<div class="img-limit"><?php 
							if ( has_post_thumbnail() ) {
								echo the_post_thumbnail( 'medium' ); 
							} 
							else { ?>
							<img src="<?php echo get_stylesheet_directory_uri() . '/img/blankproject.png'; ?>" alt="<?php echo the_title(); ?>" />
							<?php }
							
							?></div>
						<h2><?php echo the_title(); ?></h2>
					</a><?php
	}
	add_action( 'lwr_related_stories_content', 'lwr_add_related_stories' );
	
	function lwr_end_related_stories() {
		?>
		</div>
</div><!-- #related-stories-## -->
		<?php
	}
	add_action( 'lwr_related_stories_end', 'lwr_end_related_stories' );
	
	
	
	/********************************
		Get Post Categories and Terms
	********************************/
	$current = get_the_id();	
	$tags = get_the_tags($post->ID);
	$categories = get_the_category($post->ID);
	$countries = get_the_terms($post->ID, 'country' );
	$sectors = get_the_terms( $post->ID, 'sector' );
	$themes = get_the_terms($post->ID, 'themes' );	
	
	if( $tags && !is_wp_error( $tags) ) :
		foreach($tags as $tag ) {
			$tag_slug[] = $tag->slug;
		}
	else : $tag_slug = array();
	endif;
	
	if( $categories && ! is_wp_error( $categories) ) :
		foreach($categories as $category){
			$category_slug[] = $category->slug;
		}
	else : $category_slug = array();
	endif;

	if( $countries && ! is_wp_error( $countries ) ) :
		foreach($countries as $country){
			$country_slug[] = $country->slug;
		}
	else : $country_slug = array();
	endif;
	
	if( $sectors && ! is_wp_error( $sectors ) ) :
		foreach($sectors as $sector){
			$sector_slug[] = $sector->slug;
		}
	else : $sector_slug = array();
	endif;
		
	if( $themes && ! is_wp_error( $themes ) ) :
		foreach($themes as $theme){
			$theme_slug[] = $theme->slug;
		}
	else : $theme_slug = array();
	endif;
	
	/**********************************
		Use the terms in Queries
	**********************************/

	$args = array(
		'orderby' => 'rand date',
		'order' => 'DESC',
		'posts_per_page' => 3,
		'post_type' => 'post',
		'post__not_in' => array($current),
		'tax_query' => array(
							'relation' => 'AND',
							array( 'taxonomy' => 'category', 'field' => 'slug', 'terms' => $category_slug ),
							array( 'taxonomy' => 'post_tag', 'field' => 'slug', 'terms' => $tag_slug ),
							array( 'taxonomy' => 'country', 'field' => 'slug', 'terms' => $country_slug ),
							array( 'taxonomy' => 'sector', 'field' => 'slug', 'terms' => $sector_slug ),
							array( 'taxonomy' => 'themes', 'field' => 'slug', 'terms' => $theme_slug ),
					)
	);
	
	$first_query = new WP_Query( $args );
	if ( $first_query->have_posts() ) {
				
				do_action( 'lwr_related_stories_header' );

				while ( $first_query->have_posts() ) {
					$first_query->the_post(); 
					do_action( 'lwr_related_stories_content' );
				}
				wp_reset_postdata(); 
				do_action( 'lwr_related_stories_end' );

	} else {
			
			$args = array(
				'orderby' => 'rand date',
				'order' => 'DESC',
				'posts_per_page' => 3,
				'post_type' => 'post',
				'post__not_in' => array($current),
				'tax_query' => array(
							'relation' => 'AND',
							array( 'taxonomy' => 'category', 'field' => 'slug', 'terms' => $category_slug ),
							array(
								'relation' => 'OR',
								array( 'taxonomy' => 'country', 'field' => 'slug', 'terms' => $country_slug ),
								array( 'taxonomy' => 'sector', 'field' => 'slug', 'terms' => $sector_slug ),
								array( 'taxonomy' => 'themes', 'field' => 'slug', 'terms' => $theme_slug ),
							)
					)
			);
			$second_query = new WP_Query( $args );

			if ( $second_query->have_posts() ) { 
			
				do_action( 'lwr_related_stories_header' );
				while ( $second_query->have_posts() ) {
					$second_query->the_post(); 
					do_action( 'lwr_related_stories_content' );
				}
				wp_reset_postdata(); 
				do_action( 'lwr_related_stories_end' );
			} else {
					$args = array(
							'orderby' => 'rand date',
							'order' => 'DESC',
							'posts_per_page' => 3,
							'post_type' => 'post',
							'post__not_in' => array($current),
							'tax_query' => array(
								'relation' => 'AND',
									array( 'taxonomy' => 'country', 'field' => 'slug', 'terms' => $country_slug ),
									array( 'taxonomy' => 'sector', 'field' => 'slug', 'terms' => $sector_slug ),
							)
						);
				$third_query = new WP_Query( $args );
				if ( $third_query->have_posts() ) {
						do_action( 'lwr_related_stories_header' );
						
						while ( $third_query->have_posts() ) {
							$third_query->the_post(); 
							do_action( 'lwr_related_stories_content' );
						}
						wp_reset_postdata(); 
						do_action( 'lwr_related_stories_end' );
				}	else{
							$args = array(
									'orderby' => 'rand date',
									'order' => 'DESC',
									'posts_per_page' => 3,
									'post_type' => 'post',
									'post__not_in' => array($current),
									'tax_query' => array(
										'relation' => 'OR',
										array( 'taxonomy' => 'country', 'field' => 'slug', 'terms' => $country_slug ),
										array( 'taxonomy' => 'sector', 'field' => 'slug', 'terms' => $sector_slug ),
									)
								);

					$fourth_query = new WP_Query( $args );
					if ( $fourth_query->have_posts() ) {
								do_action( 'lwr_related_stories_header' );
								
								while ( $fourth_query->have_posts() ) {
									$fourth_query->the_post(); 
									do_action( 'lwr_related_stories_content' );
								}
							wp_reset_postdata(); 
							do_action( 'lwr_related_stories_end' );
							
					}	else {						
								$args = array(
									'orderby' => 'rand date',
									'order' => 'DESC',
									'posts_per_page' => 3,
									'post_type' => 'post',
									'post__not_in' => array($current),
									'tax_query' => array(
											'relation' => 'OR',
											array( 'taxonomy' => 'category', 'field' => 'slug', 'terms' => $category_slug ),
											array( 'taxonomy' => 'post_tag', 'field' => 'slug', 'terms' => $tag_slug ),
											array( 'taxonomy' => 'country', 'field' => 'slug', 'terms' => $country_slug ),
											array( 'taxonomy' => 'sector', 'field' => 'slug', 'terms' => $sector_slug ),
											array( 'taxonomy' => 'themes', 'field' => 'slug', 'terms' => $theme_slug ),
										)
								);
							
							$fifth_query = new WP_Query( $args );
							
						if ( $fifth_query->have_posts() ) {
								do_action( 'lwr_related_stories_header' );
								
								while ( $fifth_query->have_posts() ) {
									$fifth_query->the_post(); 
									do_action( 'lwr_related_stories_content' );
								}
							wp_reset_postdata(); 
							do_action( 'lwr_related_stories_end' );
						}
					}					
				}
			}
	}
?>