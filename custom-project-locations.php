<?php
/**
 * @package storefront
 */
?>

<div class="page-section animated-object" id="project-locations">
	<div class="page-section-header">
		<img src="<?php echo get_stylesheet_directory_uri() . '/img/countries-icon-sm.png'; ?>" alt="" />
		<h2>PROJECT LOCATIONS</h2>
	</div>
	<link rel="stylesheet" href="https://js.arcgis.com/3.16/esri/css/esri.css">
        <script src="https://js.arcgis.com/3.16/"></script>
	<div id="mapDiv"></div>
	<script type="text/javascript">
		var data = {"type": "FeatureCollection",
			"features": [
				<?php
				$args = array(
					'orderby' => 'post_date',
					'order' => 'DESC',
					'post_type' => 'project',
					'country' => $post->post_name
				);
				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$terms = get_the_terms( $post->ID , 'sector' );
					$sector_list = array();
					$sector_names = "";
					?>{
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
							"symbol": "/wp-content/themes/lwr/img/map_leaf.png"
						<?php } elseif(in_array("Emergency Operations", $sector_list)){ ?>
							"symbol": "/wp-content/themes/lwr/img/map_shield.png"
						<?php } else { ?>
							"symbol": "/wp-content/themes/lwr/img/map_water.png"
						<?php } ?>
					},
					<?php }/*end while*/
				}/*end if*/ else {
					global $post;
					$custom = get_post_custom($post->ID);
					$terms = get_the_terms( $post->ID , 'sector' );
					$sector_list = array();
					$sector_names = "";
						?>{
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
								"symbol": "/wp-content/themes/lwr/img/map_leaf.png"
							<?php } elseif(in_array("Emergency Operations", $sector_list)){ ?>
								"symbol": "/wp-content/themes/lwr/img/map_shield.png"
							<?php } else { ?>
								"symbol": "/wp-content/themes/lwr/img/map_water.png"
							<?php } ?>
						},
				<?php }
				wp_reset_postdata();
				?>
			]
		};
		var map;
	</script>
</div><!-- #current-projects-## -->
