<?php
/**
 * The template for displaying archive Staff Members.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package storefront
 *
 */

get_header();

// DEFINE ACTION FOR DISPLAYING STAFF
	function lwr_staff_loop() { ?>
				<div class="col-sm-6 col-md-4 col-lg-3">
					<div class="card" itemprop="employee" itemscope itemtype="http://schema.org/Person">
					<a href="<?php the_permalink(); ?>" itemprop="url" >
						<?php if (has_post_thumbnail() ) { 
											echo get_the_post_thumbnail( 'thumbnail', array('class'=>'card-img-top') ); 
										}
										else { 
											echo '<img src="' . get_stylesheet_directory_uri() . '/img/blankstaff.png" class="card-img-top" />';
											} ?></a>
						<div class="card-block">
							<h3 class="card-title" itemprop="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<span itemprop="jobTitle"><?php echo staff_member_title(); ?></span></a>
						</div>
					</div>
				</div>
		<?php
	}
 ?>

<div class="wrapper" id="archive-wrapper">

	<div class="container" id="content" tabindex="-1">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check', 'none' ); ?>

			<main class="site-main" id="main">

					<header class="page-header">
						<h1>Staff &amp; Board</h1>
					</header><!-- .page-header -->
				<?php

						
	// DISPLAY PRESIDENT
				$args = array(
					'post_type' => 'staffmember',
					'name'	=> 'president'
					);
				$query1 = new WP_Query( $args );

				while ( $query1->have_posts() ) :
					$query1->the_post(); ?>
				<div class="row" itemprop="employee" itemscope itemtype="http://schema.org/Person">
					<div class="col-3" itemprop="image">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
					</div>
					<div class="col-8 summary entry-summary">
					<h2 class="product_title entry-title"><a href="<?php the_permalink(); ?>" ><span itemprop="name"><?php the_title(); ?></span></a></h2>
					<h3 itemprop="jobTitle" ><?php echo staff_member_title(); ?></h3>
					<?php the_excerpt(); ?>
					</div>
				</div>
				<hr />
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
			<div class="clearfix"></div>
			
				<h2 class="mt-4" itemprop="department" itemscope itemtype="http://schema.org/Organization" itemprop="name">Board of Directors</h2>
				<div class="row">
			<?php 

				while ( $query->have_posts() ) :
					$query->the_post();
					lwr_staff_loop();
					
					endwhile; ?>
				</div>
					<?php
			endif;
				wp_reset_postdata(); 
				

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
				<div class="clearfix"></div>
				<h2 class="mt-4" itemprop="department" itemscope itemtype="http://schema.org/Organization" itemprop="name"><?php echo $department_name; ?></h2>
				<div class="row">
				<?php

				while ( $query->have_posts() ) :
					$query->the_post(); 
				
						lwr_staff_loop();				
						
				endwhile; 
				?>
				</div>
				<div class="clearfix"></div>

				<?php
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
						<h3 class="mt-4" itemprop="department" itemscope itemtype="http://schema.org/Organization" itemprop="name"><?php echo $child_name; ?></h3>
						<div class="row clearfix">
						<?php

						while ( $query->have_posts() ) :
							$query->the_post(); 
				
						lwr_staff_loop();
				
						endwhile; ?>
						</div>
						<div class="clearfix"></div>

						<?php
						endif;
						wp_reset_postdata(); 
						
				} // End children loop
				} // End parent loop
			} // End departments loop
	?>
		</div>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
