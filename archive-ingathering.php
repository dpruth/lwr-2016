<?php
/**
 * The template for displaying the Ingathering Map.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package storefront
 *
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

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php wp_enqueue_style( 'arcgis', 'http://js.arcgis.com/3.14/esri/css/esri.css' ); ?>

			<article id="post-<?php the_ID(); ?>" class="hentry" itemscope="" itemtype="">
				<?php
					add_action( 'storefront_page_before', 'lwr_add_breadcrumb', 3 );
					do_action( 'storefront_page_before' );
				?>
				<header class="entry-header">
					<h1>Local Drop-off Sites for LWR Quilt &amp; Kit Donations</h1>
					<?php the_archive_description(); ?>
				</header>
					<?php if ( have_posts() ) : 

					get_template_part( 'inc/custom', 'ingathering-location' ); ?>
						<br /><br />
							<div data-isotope>
								<div class="resource-form-bar-wrapper">
									<div class="resource-form-bar">
										<form data-isotope-filters>
											<div class="row">
												<div class="col-xs-12 col-sm-6 col-lg-3 search-resources">
													<label class="control-label">Search</label>
													<input data-isotope-search class="form-control" placeholder="Enter a search term..."/><button data-isotope-submit class="btn btn-primary">Search</button>
												</div>
												<div class="col-xs-12 col-sm-6 col-lg-3">
													<label class="control-label">Filter by State</label>
													<select class="form-control" data-isotope-filter>
			                      <option value="">All</option>
														<option value="AL">Alabama</option>
														<option value="AK">Alaska</option>
														<option value="AZ">Arizona</option>
														<option value="AR">Arkansas</option>
														<option value="CA">California</option>
														<option value="CO">Colorado</option>
														<option value="CT">Connecticut</option>
														<option value="DE">Delaware</option>
														<option value="DC">District Of Columbia</option>
														<option value="FL">Florida</option>
														<option value="GA">Georgia</option>
														<option value="HI">Hawaii</option>
														<option value="ID">Idaho</option>
														<option value="IL">Illinois</option>
														<option value="IN">Indiana</option>
														<option value="IA">Iowa</option>
														<option value="KS">Kansas</option>
														<option value="KY">Kentucky</option>
														<option value="LA">Louisiana</option>
														<option value="ME">Maine</option>
														<option value="MD">Maryland</option>
														<option value="MA">Massachusetts</option>
														<option value="MI">Michigan</option>
														<option value="MN">Minnesota</option>
														<option value="MS">Mississippi</option>
														<option value="MO">Missouri</option>
														<option value="MT">Montana</option>
														<option value="NE">Nebraska</option>
														<option value="NV">Nevada</option>
														<option value="NH">New Hampshire</option>
														<option value="NJ">New Jersey</option>
														<option value="NM">New Mexico</option>
														<option value="NY">New York</option>
														<option value="NC">North Carolina</option>
														<option value="ND">North Dakota</option>
														<option value="OH">Ohio</option>
														<option value="OK">Oklahoma</option>
														<option value="OR">Oregon</option>
														<option value="PA">Pennsylvania</option>
														<option value="RI">Rhode Island</option>
														<option value="SC">South Carolina</option>
														<option value="SD">South Dakota</option>
														<option value="TN">Tennessee</option>
														<option value="TX">Texas</option>
														<option value="UT">Utah</option>
														<option value="VT">Vermont</option>
														<option value="VA">Virginia</option>
														<option value="WA">Washington</option>
														<option value="WV">West Virginia</option>
														<option value="WI">Wisconsin</option>
														<option value="WY">Wyoming</option>
													</select>
												</div>
												<div class="col-xs-12 col-sm-6 col-lg-3">
													<label class="control-label">Filter by Season</label>
													<select class="form-control" data-isotope-filter>
			                      <option value="">All</option>
			                      <option value="year-round">Year Round</option>
														<option value="spring-and-fall">Spring and Fall</option>
														<option value="fall">Fall</option>
														<option value="spring">Spring</option>
														<option value="summer">Summer</option>
														<option value="winter">Winter</option>
			                    </select>
												</div>
											</div>
											<div class="clearfix"></div>
										</form>
									</div>
								</div>

						<div class="entry-content">
							<h2>Ingathering Locations</h2>
								<p><em>Listed alphabetically by state</em></p>
								<p hidden data-isotope-search-result><span data-count></span> matches for "<span data-term></span>" <a data-isotope-search-clear href="#">Clear Search Term</a></p>
              	<p hidden data-isotope-placeholder>No items match your filters...</p>

							<div class="row" data-isotope-container>
							<?php
							$args = array(
									'order' => 'ASC',
									'orderby' => 'meta_value',
									'post_type' => 'ingathering',
									'meta_key' => '_ingathering_state',
									'nopaging' => true,
									);
								$query = new WP_Query($args);

								while ( $query->have_posts() ) : $query->the_post(); 
															
											$address = get_post_meta($post->ID, "_ingathering_address", true);
											$city = get_post_meta($post->ID, "_ingathering_city", true);
											$state = get_post_meta($post->ID, "_ingathering_state", true);
											$zip = get_post_meta($post->ID, "_ingathering_zip", true);
											$seasons = get_the_terms($post->ID, "lwr_seasons" );
																						
											foreach( $seasons as $season) {
												$seasons_slugs = $season->slug;
												$seasons_name = $season->name;
											}
																						
								?>
								<div class="col-xs-12 col-sm-6 col-md-4" data-isotope-item data-item-filter="<?php echo $state; ?><?php if(!empty($state)){ echo ','; } ?><?php echo $seasons_slugs; ?>" ><a href="<?php the_permalink(); ?>">
									<h3><?php the_title(); ?></h3></a>
									<p><?php echo $address; ?><br />
										<?php echo $city . ', ' . $state . ' ' . $zip; ?></p>
									<p>Season: <?php echo esc_html($seasons_name); ?></p>
									<a href="<?php the_permalink(); ?>" class="button">Read More</a>
								</div>
							<?php
								
								endwhile;
								wp_reset_postdata();
								
							?>
							</div>
						</div><!-- /.entry-content -->
					</div>
					<?php else : ?>

						<?php get_template_part( 'content', 'none' ); ?>

					<?php endif; ?>


			</article><!-- /article -->

		</main><!-- #main -->
	</section><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>
