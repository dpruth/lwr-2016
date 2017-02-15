<?php 
/**
 * The template for displaying the SiteMap
 *
 * @package storefront
 */
 
 get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php

			do_action( 'storefront_single_post_before' ); 
			
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="http://schema.org/BlogPosting">

			<?php
			
				remove_action( 'storefront_single_post', 'storefront_post_header', 10 );
				remove_action( 'storefront_single_post', 'storefront_post_meta', 20 );
				remove_action( 'storefront_single_post', 'storefront_post_content', 30 );

				add_action( 'storefront_single_post', 'lwr_add_breadcrumb', 3 );
				add_action( 'storefront_single_post', 'lwr_add_page_header_image', 15 );
				
				do_action( 'storefront_single_post' );

			?>

		
			<h2>Pages</h2>
				<ul>
					<?php	wp_list_pages(); ?>
				</ul>
			
			<?php 
				foreach( get_post_types( array('public' => true) ) as $post_type) {
					if ( in_array( $post_type, array('post', 'page', 'attachment', 'product') ) ) continue;
					
					$pt = get_post_type_object( $post_type );
					
					echo '<h2>'. $pt->labels->name . '</h2>';
					echo '<ul>';
					
					$query = new WP_Query ( 
						array( 
							'post_type' => $post_type, 
							'posts_per_page' => -1 
						)
					);
					
					while( $query->have_posts() ) :
						$query->the_post();
						
						echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
						
					endwhile;
					wp_reset_postdata();
					
					echo '</ul>';
				}
			?>
			
			<h2>Posts</h2>
				<ul>
					<?php	
						$cats = get_categories();
						foreach( $cats as $cat) {
							echo '<li><h3>' . $cat->cat_name . '</h3>';
							echo '<ul>';
							
							$query = new WP_Query ( 
								array( 
									'cat' => $cat->cat_ID, 
									'posts_per_page' => -1 
								) 
							);
							
							while($query->have_posts() ) :
								$query->the_post();
								$category = get_the_category();
								
								if ($category[0]->cat_ID == $cat->cat_ID) {
									echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
								}
							endwhile;
							wp_reset_postdata();
							
							echo '</ul>';
							echo '</li>';		
								
						}					
					?>
				</ul>
				
			
				
</article><!-- #post-## -->
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