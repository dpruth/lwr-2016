<?php
/**
 * @package storefront
 */
 
 /*
  * Project Location Header
	*/
	
	function project_location_header() {
		wp_enqueue_style( 'esri', '//js.arcgis.com/3.16/esri/css/esri.css' );
		wp_enqueue_script( 'arcgis', '//js.arcgis.com/3.16/', array(), '3.16', true );
		wp_enqueue_script( 'lwr_map', get_stylesheet_directory_uri() . '/js/lwr_map_min.js', array('arcgis'), '1.0', true );
		?>
			<section class="container-fluid page-section animated-object" id="project-locations">
				<div class="row">
				<div class="page-section-header">
					<h2><i class="fa fa-globe" aria-hidden="true"></i> <?php if (is_page( array('328', '97') ) ) {
									echo 'WHERE WE WORK';
							} elseif ( is_page('344') ) {
									echo 'RECENT DISTRIBUTIONS';
							} elseif (is_single() ) {
									echo 'PROJECT LOCATION';
							} else {
									echo 'PROJECT LOCATIONS';
							}?></h2>
				</div>
				</div>
			<div class="row" id="mapDiv"></div>
					<script>
					var data = {"type": "FeatureCollection",
					"features": [
		<?php 
	}

	
	
	/*
	 * End of Project LOCATIONS
	 */
	 
	function project_location_end() { ?>
					] };
					</script>
			</div><?php
	}

	
	
	
/*
 * DEFINE MAP SYMBOLS
 */
 
	$theme_dir = get_stylesheet_directory_uri();
	$ag_symbol = $theme_dir . '/img/Ag_35.png';
	$er_symbol = $theme_dir . '/img/ER_35.png';
	$mr_symbol = $theme_dir . '/img/MR_35.png';
	$climate_symbol = $theme_dir . '/img/Climate_35.png';

	
/*
 * START THE LOOP FOR PROJECTS
 */
				if ( 'project' == get_post_type() ) :
									global $post;
					$custom = get_post_custom($post->ID);
					$terms = get_the_terms( $post->ID , 'sector' );
					$sector_list = array();
					$sector_names = "";
					
					project_location_header();

					?>	{
							"type": "feature",
							"geometry": {
								"type": "Point",
								"coordinates":	[<?php echo get_post_meta($post->ID, '_project_longitude', true) . ", " . get_post_meta($post->ID, '_project_latitude', true); ?>],
								"objectId": <?php the_ID(); ?>
							},
							"title": "<?php the_title(); ?>",
							"link": "<?php the_permalink(); ?>",
							"description": "Sector: <?php foreach ( $terms as $term ) { $sector_names .= $term->name.", "; $sector_list[] = $term->name; } echo substr_replace($sector_names,'', strrpos($sector_names, ', ')); ?><br /><a href=\"<?php the_permalink(); ?>\">View this project</a>",
							<?php if(in_array("Agriculture", $sector_list)){ ?>
								"symbol": "<?php echo esc_url($ag_symbol); ?>"
							<?php } elseif(in_array("Emergency Operations", $sector_list) ){ ?>
								"symbol": "<?php echo esc_url($er_symbol); ?>"
							<?php } elseif( in_array("Quilt &amp; Kit Distribution", $sector_list) ){ ?>
								"symbol": "<?php echo esc_url($mr_symbol); ?>"
							<?php } else { ?>
								"symbol": "<?php echo esc_url($climate_symbol); ?>"
							<?php } ?>
						}
					
				<?php 
					project_location_end();

/**
 * START THE LOOP FOR OTHER PAGES
**/

				else :
				$today = date('Ymd');
				$one_year_ago = date('Ymd', strtotime('-1 year'));;
				
				if ( is_page( array('328', '97') )  ) { // WHAT WE DO and HOME
					$args = array(
					'orderby' => 'post_date',
					'order' => 'DESC',
					'post_type' => 'project',
					'nopaging' => true,
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
				} elseif ( is_page( '344' ) ) { // Distribution Map
					$args = array(
						'post_type' => 'project',
						'tax_query' => array( array(
							'taxonomy' => 'sector',
							'field'	=>	'slug',
							'terms' => 'distribution'
						)),
						'nopaging' => true,
											'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => 'project_end_date',
							'compare' => 'NOT EXISTS'
						),
						array(
							'key' => 'project_end_date',
							'compare' => '>=',
							'value' => $one_year_ago
						)
					)
					); 
					
				} elseif ( is_page( array(55, 386, 388, 8531)) ) {
					$sectors = get_the_terms( $post->ID , 'sector' );
					foreach ( $sectors as $sector ) { 
						$sector_slug[] = $sector->slug;
					}

					$args = array(
						'post_type' => 'project',
						'tax_query' => array( array(
							'taxonomy' => 'sector',
							'field'	=>	'slug',
							'terms' => $sector_slug
						)),
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
						),
						'nopaging' => true
					); 
					
				} else {
				$countries = get_the_terms($post->ID, 'country');
				foreach($countries as $country){
					$country_slug[] = $country->slug;
				}
				$args = array(
					'orderby' => 'post_date',
					'order' => 'DESC',
					'post_type' => 'project',
					'tax_query' => array( array(
							'taxonomy' => 'country',
							'field' => 'slug',
							'terms' => $country_slug
							)),
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
					),
					'nopaging' => true
					); 
				}
			
				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) { 
					
					project_location_header();
					
					while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$terms = get_the_terms( $post->ID , 'sector' );
					$sector_list = array();
					$sector_names = "";
					?>
					{
					"type": "feature",
						"geometry": {
							"type": "Point",
							"coordinates":	[<?php echo get_post_meta($post->ID, '_project_longitude', true) . ", " . get_post_meta($post->ID, '_project_latitude', true); ?>],
							"objectId": <?php the_ID(); ?>
						},
						"title": "<?php the_title(); ?>",
						"link": "<?php the_permalink(); ?>",
						"description": "Sector: <?php foreach ( $terms as $term ) { $sector_names .= $term->name.", "; $sector_list[] = $term->name; } echo substr_replace($sector_names,'', strrpos($sector_names, ', ')); ?><br /><a href=\"<?php the_permalink(); ?>\">View this project</a>",
						<?php if(in_array("Agriculture", $sector_list)){ 
							echo '"symbol" : "' . esc_url($ag_symbol) . '"';
					} elseif(in_array("Emergency Operations", $sector_list) ){ 
							echo '"symbol" : "' . esc_url($er_symbol) . '"';
					} elseif( in_array("Quilt &amp; Kit Distribution", $sector_list) ){ 
							echo '"symbol" : "' . esc_url($mr_symbol) . '"';
					} else { 
							echo '"symbol" : "' . esc_url($climate_symbol) . '"';
						} ?>
					},
					<?php }/*end while*/ 
					
					wp_reset_postdata();
				
					project_location_end();
					
					/* ?>
					]
					};
					var map;
					</script><?php */
				}	 /*end if*/ 
							

				endif; ?>
			

