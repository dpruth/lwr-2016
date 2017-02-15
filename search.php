<?php
/**
 * The template for displaying search results pages.
 *
 * @package storefront
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<header class="entry-header">
				<h1 class="entry-title"><?php printf( esc_attr__( 'Search Results for: %s', 'storefront' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

					<div class="entry-content" itemprop="mainContentOfPage">
		<?php if ( have_posts() ) : 
					// get_template_part( 'loop' );
						while ( have_posts() ) : the_post();
						
						$title = get_the_title();	
						
						if ( 'product' == get_post_type() ) {
							$prod_cats = get_the_terms( $post->ID, 'product_cat');
							
										foreach ($prod_cats as $prod_cat) {
											$cat_parent = $prod_cat->parent;
										}
										if ($cat_parent != '0' ) {
											$parent_cat = get_term_by( 'id', $cat_parent, 'product_cat' ); 
											$cats = $parent_cat->name;
											} else {
												$cats = $prod_cat->name;
												}
							$the_title = $title . ' &mdash; ' . $cats;
						} elseif ('project' == get_post_type() ) {
								$countries = get_the_terms( $post->ID, 'country' );
								$the_title = $countries[0]->name . ': ' . $title;
						} elseif ('post' == get_post_type() ) {
								$categories = get_the_category($post->ID);
									foreach ($categories as $category){
										$cat_parent = $category->parent;
									}
									if ($cat_parent != '0' ) {
											$parent_cat = get_term_by( 'id', $cat_parent, 'product_cat' ); 
											$cat = $parent_cat->name;
											} else {
												$cat = $category->name;
												}
								$the_title = $cat . ': ' . $title;
						} else {
							$the_title = $title;
						}
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'medium' );
							} else {}
							?>
							<h2><a href="<?php the_permalink(); ?>"><?php echo esc_html($the_title); ?></a></h2>
							<?php the_excerpt(); ?>
							<p><small><a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></small></p>
							<hr />
						<?php endwhile; ?>
						<nav id="pagination"><?php echo paginate_links(); ?></nav>
					
					</div>
		<?php 
		else :

			get_template_part( 'content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
