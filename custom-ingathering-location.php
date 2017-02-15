<?php
/**
 * @package storefront
 */
?>

<div class="page-section animated-object" id="project-locations">
	<div class="page-section-header">
		<img src="<?php echo get_stylesheet_directory_uri() . '/img/countries-icon-sm.png'; ?>" alt="" />
		<h2>INGATHERING LOCATION</h2>
	</div>
	<link rel="stylesheet" href="http://js.arcgis.com/3.14/esri/css/esri.css" />
	<div id="mapDiv"></div>
	<script>
		var data = {"type": "FeatureCollection",
			"features": [
				<?php
				$args = array(
					'orderby' => 'post_date',
					'order' => 'DESC',
					'post_type' => 'ingathering',
					'country' => $post->post_name
				);
				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$address = get_post_meta(get_the_ID(), "_ingathering_address", true);
					$city = get_post_meta(get_the_ID(), "_ingathering_city", true);
					$state = get_post_meta(get_the_ID(), "_ingathering_state", true);
					$zip = get_post_meta(get_the_ID(), "_ingathering_zip", true);
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
						"description": "Address:<br /><?php echo $address; ?><br /><?php echo $city; ?>, <?php echo $state; ?> <?php echo $zip; ?>",
						"symbol": "/wp-content/themes/lwr/img/map_leaf.png"
					},
					<?php }/*end while*/
				}/*end if*/ else {
					global $post;
					$custom = get_post_custom($post->ID);
					$address = get_post_meta(get_the_ID(), "_ingathering_address", true);
					$city = get_post_meta(get_the_ID(), "_ingathering_city", true);
					$state = get_post_meta(get_the_ID(), "_ingathering_state", true);
					$zip = get_post_meta(get_the_ID(), "_ingathering_zip", true);
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
						"description": "Address:<br /><?php echo $address; ?><br /><?php echo $city; ?>, <?php echo $state; ?> <?php echo $zip; ?>",
						"symbol": "/wp-content/themes/lwr/img/map_leaf.png"
					}
				<?php }
				wp_reset_postdata();
				?>
			]
		};
	var map;
	</script>
</div><!-- #current-projects-## -->
