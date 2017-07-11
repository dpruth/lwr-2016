<?php
/**
 * The template for displaying Resources pages such as Factsheets or Evaluations.
 *
 * Template Name: Resources Template
 *
 * @package storefront
 */

get_header(); 

function lwr_add_isotope_script() { 
		/* =============================================================================
			~~ CREATING A NEW INSTANCE
			~~ This is how you would call to the prototype for a new isotope grid.
			~~ IMPORTANT:
			~~   target - which timer this instance is created for. Refer to markup above
			~~          for setting up a proper timer.
			~~   complete - allows for a custom callback action once the timer has completed.
			==============================================================================*/

			?>
		<script src="<?php echo get_stylesheet_directory_uri() . '/js/isotope_min.js';?>" ></script>
		
		<script>
			jQuery(function() {
				var isotope_target = jQuery('[data-isotope]');
				jQuery.each(isotope_target, function() {
					var newIsotope = new IsotopeGrid({
						target : jQuery(this), // Wouldn't change
						filter_junction : 'AND',
					})// , transitionDuration: 0;
				});
			});
		</script>
	<?php }
	add_action( 'wp_footer', 'lwr_add_isotope_script' );

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article id="post-<?php the_ID(); ?>" class="hentry" itemscope="" itemtype="">

						<div data-isotope>
							<header class="entry-header">
								<h1 class="entry-title m-5 " itemprop="nme"><?php the_title(); ?></h1>
								<div class="resource-form-bar-wrapper">
									<div class="resource-form-bar container">
										<form data-isotope-filters>
											<div class="row">
												<div class="col-md-3 search-resources">
													<label class="control-label">Search</label>
													<input data-isotope-search class="form-control" placeholder="Enter a search term..."/><button data-isotope-submit class="btn btn-primary">Search</button>
												</div>
												<div class="col-md-3">
													<label class="control-label">Filter by Country</label>
													<select class="form-control" data-isotope-filter>
			                      <option value="">All</option>
														<option value="burkinafaso">Burkina Faso</option>
														<option value="colombia">Colombia</option>
														<option value="elsalvador">El Salvador</option>
														<option value="haiti">Haiti</option>
														<option value="honduras">Honduras</option>
														<option value="india">India</option>
														<option value="indonesia">Indonesia</option>
														<option value="iraq">Iraq</option>
			                      <option value="kenya">Kenya</option>
														<option value="mali">Mali</option>
														<option value="mauritania">Mauritania</option>
														<option value="nepal">Nepal</option>
														<option value="nicaragua">Nicaragua</option>
														<option value="niger">Niger</option>
														<option value="palestine">Palestine</option>
														<option value="peru">Peru</option>
														<option value="the-philippines">The Philippines</option>
														<option value="south-sudan">South Sudan</option>
			                      <option value="tanzania">Tanzania</option>
														<option value="uganda">Uganda</option>
			                    </select>
												</div>
												<div class="col-md-3">
													<label class="control-label">Filter by Topic</label>
													<select class="form-control" data-isotope-filter>
			                      <option value="">All</option>
			                      <option value="agriculture">Agriculture</option>
														<option value="cocoa">&nbsp;&nbsp;-Cocoa</option>
														<option value="coffee">&nbsp;&nbsp;-Coffee</option>
														<option value="climate">Climate</option>
														<option value="em-ops">Emergency Operations</option>
			                    </select>
												</div>
												<div class="col-md-3">
													<label class="control-label">Sort by Date</label>
													<select class="form-control" data-isotope-sort="date">
			                      <option value="DESC">Newest to Oldest</option>
			                      <option value="ASC">Oldest to Newest</option>
			                    </select>
												</div>
											</div>
											<div class="clearfix"></div>
										</form>
									</div>
								</div>
							</header>
							
							<div class="entry-content container">
								<p hidden data-isotope-search-result><span data-count></span> matches for "<span data-term></span>" <a data-isotope-search-clear href="#">Clear Search Term</a></p>
              	<p hidden data-isotope-placeholder>No items match your filters...</p>
								<div class="row" data-isotope-container>

			<?php						
					switch ( $post->post_name ) {
						case 'technical-profiles' :	
							$terms = 235; // term id (id of the media category)
							break;
						case 'manuals-toolkits' : 
							$terms = 339; // term id (id of the media category)
							break;
						case 'fact-sheets':
							$terms = 30; // term id (id of the media category)
							break;
						case 'country-profiles':
							$terms = 32; // term id (id of the media category)
							break;
						case 'evaluations':
							$terms = 338; // term id (id of the media category)							
							break;
						case 'situation-reports': 
							$terms = 29; // term id (id of the media category)
							break;
					}


				if ( $terms != 29 ) { // Not Situation Reports		
					$args = array(
							'posts_per_page' => -1,
							'post_type' => 'attachment',
							'post_status' => 'any',
							'tax_query' => array(
								array(
									'taxonomy' => 'media_category',
									'field' => 'id',
									'terms' => $terms, 
								)
							)
						);
					$the_query = new WP_Query($args);
					if ( $the_query->have_posts() ) { 

							while($the_query->have_posts() ) {
							$the_query->the_post();

								$sectors = get_the_terms( $post->ID , 'sector' );
								$sector_list = array();
								$countries = get_the_terms( $post->ID , 'country' );
								$country_list = array();
								if(!empty($sectors)){
									foreach ($sectors as $sector) {
										$sector_list[] = $sector->slug;
									}
								}
								if(!empty($countries)) {
									foreach ($countries as $country) {
										$country_list[] = $country->slug;
									}
								}
								
						?>

								<div class="col-sm-6 col-md-4 card" data-isotope-item data-item-filter="<?php echo implode(',',$sector_list); ?><?php if(!empty($sector_list)){ echo ','; } ?><?php echo implode(',',$country_list); ?>" data-date-sort="<?php echo date("m/d/y H:i:s", strtotime($post->post_date)); ?>">
									<a href="<?php the_permalink(); ?>"><?php
									if ( has_post_thumbnail() ) {
										echo get_the_post_thumbnail( $post->ID, 'medium', array('class'=>'card-img-top') );
									} else {
										$thumbnail = wp_get_attachment_image( get_the_id(), 'medium', false, array('class' => 'card-img-top' ) );
										if ( !empty($thumbnail) ) {
											echo $thumbnail;
										} else {		
											echo '<img src="' . get_stylesheet_directory_uri() . '/img/pdf_icon_960_720.png" class="card-img-top" />';
										}
									} ?></a>
									<div class="card-block">
										<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></h3></a>
										<p class="card-text"><?php echo wp_strip_all_tags( get_the_excerpt() ); ?></p>
										<a href="<?php echo $post->guid; ?>" target="_blank" class="btn btn-primary product_type_simple add_to_cart_button">Download</a>
									</div>
								</div><?php
							}
							wp_reset_postdata();
							?>
								<div class="clearfix"></div>
							</div><!-- END OF ROW -->
							<hr class="clearfix" /><?php
							
							
							//}
						} else {
							?><header class="entry-header"><h1 class="entry-title" itemprop="nme"><?php the_title(); ?></h1></header><div class="entry-content"><p>No resources found.</p><?php
							
						}
					} else { // Loop for Situation Reports
							$term_children = get_term_children( '29', 'media_category' );
							foreach( $term_children as $child) {
								
								$args = array(
									'posts_per_page' => 1,
									'post_type' => 'attachment',
									'orderby' => 'date',
									'order' => 'DESC',
									'post_status' => 'any',
									'tax_query' => array(
										array(	
										'taxonomy' => 'media_category',
										'field' => 'id',
										'terms' => $child, 
										)
									)
								);
					
								$the_query = new WP_Query($args);
								if ( $the_query->have_posts() ) :
									while($the_query->have_posts() ) :
											$the_query->the_post();

								$sectors = get_the_terms( $post->ID , 'sector' );
								$sector_list = array();
								$countries = get_the_terms( $post->ID , 'country' );
								$country_list = array();
								if(!empty($sectors)){
									foreach ($sectors as $sector) {
										$sector_list[] = $sector->slug;
									}
								}
								if(!empty($countries)) {
									foreach ($countries as $country) {
										$country_list[] = $country->slug;
									}
								}
								?><div class="col-xs-12 col-sm-6 col-md-4 card" data-isotope-item data-item-filter="<?php echo implode(',',$sector_list); ?><?php if(!empty($sector_list)){ echo ','; } ?><?php echo implode(',',$country_list); ?>" data-date-sort="<?php echo date("m/d/y H:i:s", strtotime($post->post_date)); ?>">
									<a href="<?php the_permalink(); ?>"><?php
									if ( has_post_thumbnail() ) {
										echo get_the_post_thumbnail( $post->ID, 'medium', array('class'=>'card-img-top') );
									} else {
										$thumbnail = wp_get_attachment_image( get_the_id(), 'medium', false, array('class' => 'card-img-top' ) );
										if ( !empty($thumbnail) ) {
											echo $thumbnail;
										} else {		
											echo '<img src="' . get_stylesheet_directory_uri() . '/img/pdf_icon_960_720.png" class="card-img-top" />';
										}
									} ?></a>
									<div class="card-block">
										<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></h3></a>
										<p class="card-text"><?php echo wp_strip_all_tags( get_the_excerpt() ); ?></p>
										<a href="<?php echo $post->guid; ?>" target="_blank" class="button product_type_simple add_to_cart_button">Download</a>
									</div>
								</div><?php
							endwhile;
							wp_reset_postdata();

							endif;
							}		?>
							<div class="clearfix"></div>
							</div><!-- END OF ROW -->
							<hr class="clearfix" /><?php

					}

						 ?>
						<div class="clearfix"></div>
					</div>
				</div><!-- /data-isotope -->

			</article>
			<?php		do_action( 'storefront_page_after' ); ?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
