<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package lwr
 */

get_header();

$container   = get_theme_mod( 'lwr_container_type' );
$sidebar_pos = get_theme_mod( 'lwr_sidebar_position' );

?>

<main class="site-main container-fluid" id="main">
	<div class="row">
				<?php while ( have_posts() ) : the_post(); ?>

		<div class="col-12">	
			<header class="entry-header jumbotron">
				<h1><?php the_title(); ?></h1>
			</header>

			<div class="container">			
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
					
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	</div>
</main><!-- #main -->

	<hr />


<?php get_footer(); ?>
