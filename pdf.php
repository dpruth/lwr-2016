<?php 
  // Pages for displaying PDF Attachments
	
	get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); 

			do_action( 'storefront_single_post_before' ); 
			
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

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="http://schema.org/DigitalDocument">

		<header class="entry-header">
			<h1 class="entry-title"><?php printf( '%s: ', esc_html( $term_name ) ); the_title(); ?></h1>
		</header>		
		<div class="entry-content" itemprop="mainContentOfPage">
			
			<div style="float:left; margin: 18px 2% 0 0;"><a href="<?php echo wp_get_attachment_url(); ?>" target="_blank" title="Download <?php the_title_attribute(); ?>"><?php 
			if ( has_post_thumbnail() ) {
				the_post_thumbnail('medium');
			} else {
				echo wp_get_attachment_image( get_the_id(), 'medium');
			}
				 ?></a></div>
			<?php if( $term_name == 'Situation Reports' ) { the_date('F d, Y', '<p>', '</p>' ); }
						the_content(); 
						
						$file_url = get_attached_file($post->ID);
						$file_size = filesize( $file_url );
			?>
			<a href="<?php echo wp_get_attachment_url(); ?>" target="_blank" class="button product_type_simple add_to_cart_button">Download PDF (<?php echo size_format( $file_size ); ?>)</a>

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
					if ( $the_query->have_posts() ) :
						echo '<p>Previous Versions:</p>';
						echo '<ul>';
						while ($the_query->have_posts() ) :
							$the_query->the_post(); ?>
								<li><a href="<?php echo wp_get_attachment_url(); ?>" target="_blank"><?php the_title(); echo ' | ' . get_the_date( 'M d, Y' ); ?></a></li>
							<?php
						endwhile;
						echo '</ul>';
						wp_reset_postdata();
					endif;

			}
			
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

			<?php
			do_action( 'storefront_single_post_after' );

			endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>