<?php
/**
 * The template for displaying archive Press Releases.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package storefront
 *
 */

get_header();

// DEFINE ACTION FOR DISPLAYING STAFF
	add_action('lwr_staff_loop', 'add_lwr_staff_loop' );
	function add_lwr_staff_loop() { ?>
					<li class="product" itemprop="employee" itemscope itemtype="http://schema.org/Person"><a href="<?php the_permalink(); ?>" itemprop="url" >
						<?php if (has_post_thumbnail() ) { 
											the_post_thumbnail( 'thumbnail' ); 
										}
										else { 
											echo '<img src="' . get_stylesheet_directory_uri() . '/img/blankstaff.png" />';
											} ?>
					<h3 itemprop="name"><?php the_title(); ?></h3>
					<span itemprop="jobTitle"><?php echo staff_member_title(); ?></span></a>
					</li>
		<?php
	}
 ?>

	<div id="primary" class="content-area single-product">
		<main id="main" class="site-main" role="main">

			<article id="post-<?php the_ID(); ?>" class="hentry" itemscope itemtype="http://schema.org/NGO">
				<?php
					add_action( 'storefront_page_before', 'lwr_add_breadcrumb', 3 );
					do_action( 'storefront_page_before' );
				?>
				<header class="entry-header">
					<h1>Staff and Board</h1>
				</header>
				<?php

						
	// DISPLAY PRESIDENT
				$args = array(
					'post_type' => 'staffmember',
					'name'	=> 'president'
					);
				$query1 = new WP_Query( $args );

				while ( $query1->have_posts() ) :
					$query1->the_post(); ?>
				<div class="product" itemprop="employee" itemscope itemtype="http://schema.org/Person">
					<div class="images" itemprop="image">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
					</div>
					<div class="summary entry-summary">
					<h2 class="product_title entry-title"><a href="<?php the_permalink(); ?>" ><span itemprop="name"><?php the_title(); ?></span></a></h2>
					<h3 itemprop="jobTitle" ><?php echo staff_member_title(); ?></h3>
					<?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>" rel="nofollow">Continue reading&raquo;</a>
					</div>
				</div>
				<?php endwhile;
				
				wp_reset_postdata();

	// DISPLAY BOARD OF DIRECTORS
			$args = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => 'board'
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'nopaging' => true
					);		
				
				$query = new WP_Query( $args );			
				if ( $query->have_posts() ) :
			?>
		<div class="related" >
				<h2 itemprop="department" itemscope itemtype="http://schema.org/Organization" itemprop="name">Board of Directors</h2>
				<ul class="products">
			<?php 

				while ( $query->have_posts() ) :
					$query->the_post();
					do_action('lwr_staff_loop');
					
					endwhile; endif;
				wp_reset_postdata(); ?>
				</ul>
			<?php

	// LOOP THROUGH DEPARTMENTS
	$departments = get_terms( array(
		'taxonomy' => 'departments',
		'exclude' => 116,
		'order' => 'DESC'
	));
			// List parent departments first		
			foreach( $departments as $department ) {						
				$department_name = $department->name;
				$department_slug = $department->slug;
				$department_parent = $department->parent;
				$department_id = $department->term_id;
				
				if( $department_parent == 0 ) {
				$args = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => $department_slug,
						'include_children' => false
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'post__not_in' => array(745),
					'nopaging' => true
					);
				$query = new WP_Query( $args );
				
				if ( $query->have_posts() ) : ?>
				<h2 itemprop="department" itemscope itemtype="http://schema.org/Organization" itemprop="name"><?php echo $department_name; ?></h2>
				<ul class="products"><?php

				while ( $query->have_posts() ) :
					$query->the_post(); 
				
				do_action('lwr_staff_loop');
				
				endwhile; 
				?></ul><?php
				endif;
				wp_reset_postdata(); 
				
				
				// Then list children of parents
				$children = get_terms( array(
					'taxonomy' => 'departments',
					'child_of' => $department_id
				));
								
				foreach( $children as $child_department ) {
					$child_name = $child_department->name;
					$child_slug = $child_department->slug;
				
					$args = array(
							'post_type'	=> 'staffmember',
							'tax_query' => array(
								array(
								'taxonomy' => 'departments',
								'field' => 'slug',
								'terms' => $child_slug,
								)),
							'order' => 'ASC',
							'orderby' => 'menu_order',
							'nopaging' => true
					);
					$query = new WP_Query( $args );
				
						if ( $query->have_posts() ) : ?>
						<h3 itemprop="department" itemscope itemtype="http://schema.org/Organization" itemprop="name"><?php echo $child_name; ?></h3>
						<ul class="products"><?php

						while ( $query->have_posts() ) :
							$query->the_post(); 
				
						do_action('lwr_staff_loop');
				
						endwhile; 
						?></ul><?php
						endif;
						wp_reset_postdata(); 
						
				} // End children loop
				} // End parent loop
			} // End departments loop
	?>
			</div>

		</article><!-- /article -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>
