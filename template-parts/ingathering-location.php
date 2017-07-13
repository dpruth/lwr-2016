<?php
/**
 * @package storefront
 */
 
		wp_enqueue_style( 'esri', '//js.arcgis.com/3.16/esri/css/esri.css' );
		wp_enqueue_script( 'arcgis', '//js.arcgis.com/3.16/', array(), '3.16', true );
		wp_enqueue_script( 'lwr_map', get_stylesheet_directory_uri() . '/js/lwr_map_min.js', array('arcgis'), '1.0', true );
		
					$yearround_marker = get_stylesheet_directory_uri() . '/img/LWRmarker.png';
					$springfall_marker = get_stylesheet_directory_uri() . '/img/LWRmarker_springfall.png';
					$fall_marker = get_stylesheet_directory_uri() . '/img/LWRmarker_fall.png';
					$spring_marker = get_stylesheet_directory_uri() . '/img/LWRmarker_spring.png';
					$summer_marker = get_stylesheet_directory_uri() . '/img/LWRmarker_summer.png';
					$winter_marker = get_stylesheet_directory_uri() . '/img/LWRmarker_winter.png';

?>

<div class="page-section animated-object" id="project-locations">
	<div class="page-section-header">
		<h2><i class="fa fa-map-marker"></i> INGATHERING <?php if (is_single() ) {
						echo 'LOCATION'; } else {
						echo 'LOCATIONS'; } ?></h2>
	</div>
	<style> #searchMap { display: block; position:relative; z-index: 2; top:20px; left:74px } </style>
	<div id="searchMap"></div>
	<div id="mapDiv"></div>
	<script>
		var data = {"type": "FeatureCollection",
			"features": [				<?php
			if (is_post_type_archive('ingathering') ) {
								
				$args = array(
					'post_type' => 'ingathering',
					'nopaging' => 'true'
				);
				
				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
					$the_query->the_post(); 
					$location = str_replace( " ", "+", get_the_title() );
					$address = get_post_meta(get_the_ID(), "_ingathering_address", true);
					$city = get_post_meta(get_the_ID(), "_ingathering_city", true);
					$state = get_post_meta(get_the_ID(), "_ingathering_state", true);
					$zip = get_post_meta(get_the_ID(), "_ingathering_zip", true);
					$dir_address = str_replace( " ", "+", $address);
					$terms = get_the_terms(get_the_ID(), "lwr_seasons" );
					$seasons = array();
						foreach($terms as $term) {
							$seasons[] = $term->name;
						}
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
						"description": "Address:<br /><?php echo $address; ?><br /><?php echo $city; ?>, <?php echo $state; ?> <?php echo $zip; ?><br /><a href=\"http://www.google.com/maps/dir//<?php echo $location; ?>+<?php echo $dir_address; ?>+<?php echo $city; ?>+<?php echo $state; ?>+<?php echo $zip; ?>\" target=\"_blank\">Get directions</a><br /><br /><a href=\"<?php the_permalink(); ?>\">More info&raquo;</a>",	
						<?php if(in_array("Year Round", $seasons)){ 
						?>"symbol": "<?php echo $yearround_marker; ?>"
						<?php } elseif(in_array("Spring and Fall", $seasons)){ 
						?>"symbol": "<?php echo $springfall_marker; ?>"
						<?php } elseif(in_array("Fall", $seasons)){ 
						?>"symbol": "<?php echo $fall_marker; ?>"
						<?php } elseif(in_array("Spring", $seasons)){ 
						?>"symbol": "<?php echo $spring_marker; ?>"
						<?php } elseif(in_array("Summer", $seasons)){ 
						?>"symbol": "<?php echo $summer_marker; ?>"
						<?php } else { 
						?>"symbol": "<?php echo $winter_marker; ?>"
						<?php } ?>
					},
					<?php } /*end while*/
					wp_reset_postdata();
				}/*end if*/ 
			} /*end if */ 
			else {
					global $post;
					$location = str_replace( " ", "+", get_the_title() );
					$custom = get_post_custom($post->ID);
					$address = get_post_meta(get_the_ID(), "_ingathering_address", true);
					$city = get_post_meta(get_the_ID(), "_ingathering_city", true);
					$state = get_post_meta(get_the_ID(), "_ingathering_state", true);
					$zip = get_post_meta(get_the_ID(), "_ingathering_zip", true);
					$dir_address = str_replace( " ", "+", $address);
					$terms = get_the_terms(get_the_ID(), "lwr_seasons" );
					$seasons = array();
						foreach($terms as $term) {
							$seasons[] = $term->name;
						}

					?>
					{	"type": "feature",
						"geometry": {
							"type": "Point",
							"coordinates":	[<?php echo get_post_meta($post->ID, '_project_longitude', true) . ", " . get_post_meta($post->ID, '_project_latitude', true); ?>],
							"objectId": <?php the_ID(); ?>
							},
						"title": "<?php the_title(); ?>",
						"link": "<?php the_permalink(); ?>",
						"description": "Address:<br /><?php echo $address; ?><br /><?php echo $city; ?>, <?php echo $state; ?> <?php echo $zip; ?><br /><a href=\"http://www.google.com/maps/dir//<?php echo $location; ?>+<?php echo $dir_address; ?>+<?php echo $city; ?>+<?php echo $state; ?>+<?php echo $zip; ?>\">Get directions</a>",
						
						<?php if(in_array("Year Round", $seasons)){ 
						?>"symbol": "<?php echo $yearround_marker; ?>"
						<?php } elseif(in_array("Spring and Fall", $seasons)){ 
						?>"symbol": "<?php echo $springfall_marker; ?>"
						<?php } elseif(in_array("Fall", $seasons)){ 
						?>"symbol": "<?php echo $fall_marker; ?>"
						<?php } elseif(in_array("Spring", $seasons)){ 
						?>"symbol": "<?php echo $spring_marker; ?>"
						<?php } elseif(in_array("Summer", $seasons)){ 
						?>"symbol": "<?php echo $summer_marker; ?>"
						<?php } else { 
						?>"symbol": "<?php echo $winter_marker; ?>"
						<?php } ?>
					}
			<?php }				?>
			]
		};
	var map;
	</script>
</div>
<ul class="ingathering-seasons">
	<li id="year-round">Year Round</li>
	<li id="spring-fall">Spring and Fall</li>
	<li id="fall">Fall</li>
	<li id="spring">Spring</li>
	<li id="summer">Summer</li>
	<li id="winter">Winter</li>
</ul>
	<!-- #current-projects-## -->
