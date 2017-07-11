<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */
?>

<article <?php post_class('col-12 px-0'); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header jumbotron <?php 
			if(has_post_thumbnail() ) { 
				$thumbnail_url = get_the_post_thumbnail_url(null, 'full');
				echo 'has-full-width-image jumbotron-fluid"';
				echo ' id="hero_image"';
				?>
				style="background-image: url('<?php echo $thumbnail_url; ?>'); <?php
			} ?>">

		<?php the_title( '<h1 class="entry-title display-3">', '</h1>' ); ?>

	</header><!-- .entry-header -->

					<?php get_template_part( 'template-parts/ingathering', 'location' ); ?>
				<div class="clearfix"></div>			
					
				<?php
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
				
				<div class="entry-content container">
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
					<?php } ?>
				</div>
				
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
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'lwr' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->
		
				<?php lwr_social_media_links(); ?>

	
	<footer class="entry-footer">

		<?php lwr_entry_footer(); ?>

	</footer><!-- .entry-footer -->

	</div><!-- .container -->

</article><!-- #post-## -->
