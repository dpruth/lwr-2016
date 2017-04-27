<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			$id = get_the_ID();
			do_action( 'storefront_single_post_before' );

			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

				<?php
					/**
					 * @hooked storefront_post_header - 10
					 * @hooked storefront_post_meta - 20
					 * @hooked storefront_post_content - 30
					 */
			
					remove_action( 'storefront_single_post', 'storefront_post_header', 10 );
					remove_action( 'storefront_single_post', 'storefront_post_meta', 20 );
					remove_action( 'storefront_single_post', 'storefront_post_content', 30 );
			
					add_action( 'storefront_single_post', 'lwr_add_breadcrumb', 3 );
					add_action( 'storefront_single_post', 'lwr_add_page_header_image', 15 );
					add_action( 'storefront_single_post', 'storefront_page_content', 28 );
			
					do_action( 'storefront_single_post' );
					
					get_template_part( 'inc/custom', 'ingathering-location' );
							
					wp_reset_query();

					$fields=get_fields($id);
					//print_r($fields);

					$notes = $fields["notes"];
					$upload = $fields["pdf_upload"];
					$address = get_post_meta($id, "_ingathering_address", true);					
					$city = get_post_meta($id, "_ingathering_city", true);
					$state = get_post_meta($id, "_ingathering_state", true);
					$zip = get_post_meta($id, "_ingathering_zip", true);
					$location = str_replace( " ", "+", get_the_title() );
					$dir_address = str_replace( " ", "+", $address);
				?>

				<div class="entry-content">
					<h2>Address</h2>
					<p><?php echo "{$address}</br>{$city}, {$state} {$zip}"; ?><br />
					<a href="http://www.google.com/maps/dir//<?php echo "{$location}+{$dir_address}+{$city}+{$state}+{$zip}"; ?>" target="_blank"><svg fill="#74c3e4" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
						<path d="M21.71 11.29l-9-9c-.39-.39-1.02-.39-1.41 0l-9 9c-.39.39-.39 1.02 0 1.41l9 9c.39.39 1.02.39 1.41 0l9-9c.39-.38.39-1.01 0-1.41zM14 14.5V12h-4v3H8v-4c0-.55.45-1 1-1h5V7.5l3.5 3.5-3.5 3.5z"/>
						<path d="M0 0h24v24H0z" fill="none"/>
						</svg> Get directions</a></p>
					
					<?php if ( have_rows('ingathering_date') ) : ?>
					<h3>Dates &amp; Time</h3>
					<?php
						while (have_rows('ingathering_date') ) : the_row();
								$start_time = get_sub_field('ingathering_start_time');
								$end_time = get_sub_field('ingathering_end_time');
								
								if ( !empty($start_time) && !empty($end_time) ) {
									
											if ( date('Y-m-d', $start_time) == date('Y-m-d', $end_time) ) {
													echo '<p>' . date('F d, Y g:i A', $start_time ) . ' to ' . date( 'g:i A', $end_time ) . '</p>';
											} else { 
												echo '<p>' . date('F d, Y g:i A', $start_time ) . ' to ' . date( 'F d, Y g:i A', $end_time ) . '</p>';
											}

								} else {
									echo '<p>No specific dates or times were found. Please contact one of the people listed below about when you can drop off your Quilts or Kits.</p>';
								}
						endwhile;
						endif;
						?>
					
					<h2>Seasons</h2>
					<?php echo get_the_term_list( $post->ID, 'lwr_seasons', '<p>',', ','</p>' ); ?>					
					
					<?php
					if ( have_rows('contacts') ) : ?>
					<h2>Contacts</h2>
					<ul>
						<?php 
						while (have_rows('contacts') ) : the_row(); 
							$contact_name = get_sub_field('name');
							$phone_1 = get_sub_field('phone_1');
							$phone_2 = get_sub_field('phone_2');
							$email = get_sub_field('email');
						?>
							<li>
							<?php if ($contact_name != ""){ ?>
								<strong><?php	echo $contact_name; ?></strong><br />
							<?php }
							if ($phone_1 != ""){
								echo "Phone: <a href=\"tel:". $phone_1 . "\" >" . $phone_1 . "</a><br />"; 
							}
							if ($phone_2 != ""){
								echo "Alternate: <a href=\"tel:". $phone_2 . "\" >" . $phone_2 . "</a><br />";
							}
							if ($email !=""){	
								echo "Email: <a href=\"mailto:". $email . "\" >" . $email . "</a>";
							} ?>
							</li>
						<?php endwhile; ?>
					</ul>
					<?php endif; ?>
					<h2>Notes</h2>
					<?php echo $notes; 
					
					if ( !empty($upload) ) { ?>
					<p><a href="<?php echo $upload['url']; ?>" class="button">Download More Information (PDF)</a></p>
					<? } ?>
				</div>
				
			</article><!-- #post-## -->
			<script type="application/ld+json">
			{
				"@context": "http://schema.org/",
				"@type": "Event",
				"name": "<?php the_title(); ?> Ingathering",
				"startDate" : "<?php echo date('c', $start_time); ?>",
				"endDate" : "<?php echo date('c', $end_time); ?>",
				"location": {
					"@type": "Place",
					"name": "<?php the_title(); ?>",
					"address": {
							"@type": "PostalAddress",
							"streetAddress": "<?php echo esc_attr( $address ); ?>",
							"addressLocality": "<?php echo esc_attr( $city ); ?>",							
							"addressRegion": "<?php echo esc_attr( $state ); ?>",
							"postalCode": "<?php echo esc_attr( $zip ); ?>"
					}
				},
				"description": "<?php echo esc_attr($notes); ?>",
				"url": "<?php the_permalink(); ?>"
			}
			</script>
		<?php
			/**
			 * @hooked storefront_post_nav - 10
			 */
			do_action( 'storefront_single_post_after' );
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>