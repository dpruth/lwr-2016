<?php
/**
 * The template for displaying all single posts.
 *
 * @package lwr
 */

get_header();
$container   = get_theme_mod( 'lwr_container_type' );
$sidebar_pos = get_theme_mod( 'lwr_sidebar_position' );
?>

<main class="site-main container" id="main">

				<?php while ( have_posts() ) : the_post(); 
				
				
			$post_id = $post->ID;
			$terms = get_the_terms( $post_id, 'media_category' );

			if (!empty($terms) ) {
				foreach($terms as $term){
					
					if( $term->parent != '0' ) { // IF HAS PARENT, GET PARENT
						$parent = get_term_by( 'id', $term->parent, 'media_category' );
						$term_name = $parent->name;
						$child_id = $term->term_id;

					} else { // OTHERWISE, JUST GET THE NAME
						$term_name = $term->name;
						$child_id = NULL;
					}
				
				}
			} else { $term_name = 'File'; $child_id = NULL; }
?>

		<header class="entry-header my-4">
			<h1 class="entry-title"><?php printf( '%s: ', esc_html( $term_name ) ); the_title(); ?></h1>
		</header>		

		<div class="entry-content justify-content-center" itemprop="mainContentOfPage">
			
			<div class="media">
			
				<a href="<?php echo wp_get_attachment_url(); ?>" target="_blank" title="Download <?php the_title_attribute(); ?>"><?php 
						if ( has_post_thumbnail() ) {
							echo get_the_post_thumbnail( $post_id, 'medium', array('class'=>'d-flex mr-3' ) );
						} else {
							echo wp_get_attachment_image( $post_id, 'large', true, array('class'=>'d-flex mr-3' ));
						}
				 ?></a>
				<div class="media-body">
				<?php 
						if( $term_name == 'Situation Reports' ) { 
								the_date('F d, Y', '<p>', '</p>' ); 
						}
						the_content(); 
						
						$file_url = get_attached_file($post->ID);
						$file_size = filesize( $file_url );
					?>
					<a href="<?php echo wp_get_attachment_url(); ?>" target="_blank" class="btn btn-primary product_type_simple add_to_cart_button">Download PDF (<?php echo size_format( $file_size ); ?>)</a>
				</div>
			</div>
			
			<?php 
			
			/*
			 * List Previous Situation Reports
			 */ 
			if ( !is_null($child_id) ) {
						$args = array(
							'posts_per_page' => -1,
							'post__not_in' => array( $post_id ),
							'post_type' => 'attachment',
							'post_status' => 'any',
							'order' => 'DESC',
							'orderby' => 'date',
							'tax_query' => array(
								array(
									'taxonomy' => 'media_category', // your taxonomy
									'field' => 'id',
									'terms' => $child_id, 
								)
							)
						);

					$the_query = new WP_Query($args);
					if ( $the_query->have_posts() ) : ?>
					<p>Previous Versions:</p>
						<ul> 
					<?php	while ($the_query->have_posts() ) :
							$the_query->the_post(); ?>
								<li><a href="<?php echo wp_get_attachment_url(); ?>" target="_blank"><?php the_title(); echo ' | ' . get_the_date( 'M d, Y' ); ?></a></li>
							<?php
						endwhile;
						?>
						</ul>
						<?php
						wp_reset_postdata();
					endif;

			} ?>


	</div>
</main><!-- #main -->

	<hr />
	
	<section class="comments container">
	<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
	</section>
				<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>
