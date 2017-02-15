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

			<?php if ( have_posts() ) :

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
				endif;
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



	// DISPLAY PRESIDENT'S OFFICE
				?>

				<h2 itemprop="name">President's Office</h2>
				<ul class="products">
			<?php if ( have_posts() ) :
				$args2 = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => 'po'
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'post__not_in' => array(745),
					'nopaging' => true
					);
				$query2 = new WP_Query( $args2 );

				while ( $query2->have_posts() ) :
					$query2->the_post(); 
				
				do_action('lwr_staff_loop');
				
				endwhile; endif;
				wp_reset_postdata(); ?>
				</ul>
			<?php


	// DISPLAY EXTERNAL RELATIONS
				?><h2 itemprop="name">Strategic Partnerships &amp; External Relations</h2>
				<ul class="products">
			<?php if ( have_posts() ) :
				$args = array(
					'post_type'	=> 'staffmember',
					// 'posts_per_page' => 1,
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => 'er',
						'include_children' => false
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					);
				$query = new WP_Query( $args );

				while ( $query->have_posts() ) :
					$query->the_post(); 
					
					do_action('lwr_staff_loop');
					
					endwhile; endif;
				wp_reset_postdata();
			?>
				</ul><?php

	// DISPLAY STRATEGIC PARTNERSHIPS

				$args = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => 'sp'
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'nopaging' => true
					);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) : ?>
				
				<h3 itemprop="name">Strategic Partnerships</h3>
				<ul class="products"><?php

				while ( $query->have_posts() ) :
					$query->the_post(); 
					
					do_action('lwr_staff_loop');
					
					endwhile; endif;
				wp_reset_postdata();
			?>
				</ul><?php
	
		// DISPLAY PHILANTHROPIC ENGAGEMENT
			
				$args = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => 'pe'
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'nopaging' => true
					);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) : ?>
				
				<h3 itemprop="name">Philanthropic Engagement</h3>
				<ul class="products"><?php

				while ( $query->have_posts() ) :
					$query->the_post(); 
					
					do_action('lwr_staff_loop');
					
					endwhile; endif;
				wp_reset_postdata();
			?>
				</ul><?php

		// DISPLAY MCS
			
				$args = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => 'mcs'
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'nopaging' => true
					);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) : ?>
				
				<h3 itemprop="name">Marketing &amp; Creative Services</h3>
				<ul class="products"><?php

				while ( $query->have_posts() ) :
					$query->the_post(); 
					
					do_action('lwr_staff_loop');
					
					endwhile; endif;
				wp_reset_postdata();
			?>
				</ul><?php

			// DISPLAY CONSTITUENT ENGAGEMENT
			
				$args = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => 'ce'
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'nopaging' => true
					);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) : ?>
				
				<h3 itemprop="name">Constituent Engagement</h3>
				<ul class="products"><?php

				while ( $query->have_posts() ) :
					$query->the_post(); 
					
					do_action('lwr_staff_loop');
					
					endwhile; endif;
				wp_reset_postdata();
			?>
				</ul><?php

		// DISPLAY INTERNATIONAL PROGRAMS

				$args = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'departments',
							'field' => 'slug',
							'terms' => 'ipd',
							'include_children' => false
						),
						array(
							'taxonomy' => 'departments',
							'field' => 'slug',
							'terms' => array('ame','lac', 'waro', 'earo', 'eops', 'q-team'),
							'operator' => 'NOT IN',
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					);
				$query = new WP_Query( $args );
				
				if ( $query->have_posts() ) :
				?><h2 itemprop="name">International Programs</h2>
				<ul class="products">
			<?php 

				while ( $query->have_posts() ) :
					$query->the_post(); 

					do_action('lwr_staff_loop');
					
					endwhile; endif;
				wp_reset_postdata(); ?>
				</ul><?php

		// DISPLAY EOps
			
				$args = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => 'eops'
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'nopaging' => true
					);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) : ?>
				
				<h3 itemprop="name">Emergency Operations</h3>
				<ul class="products"><?php

				while ( $query->have_posts() ) :
					$query->the_post(); 
					
					do_action('lwr_staff_loop');
					
					endwhile; endif;
				wp_reset_postdata();
			?>
				</ul><?php
				
		// DISPLAY Q-TEAM
			
				$args = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => 'q-team'
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'nopaging' => true
					);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) : ?>
				
				<h3 itemprop="name">Program Quality &amp; Technical Support</h3>
				<ul class="products"><?php

				while ( $query->have_posts() ) :
					$query->the_post(); 
					
					do_action('lwr_staff_loop');
					
					endwhile; endif;
				wp_reset_postdata();
			?>
				</ul><?php
				
			// DISPLAY AFRICA
			
				$args = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => array('earo', 'waro')
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'nopaging' => true
					);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) : ?>
				
				<h3 itemprop="name">Africa</h3>
				<ul class="products"><?php

				while ( $query->have_posts() ) :
					$query->the_post(); 
					
					do_action('lwr_staff_loop');
					
					endwhile; endif;
				wp_reset_postdata();
			?>
				</ul><?php
				
			// DISPLAY ASIA
			
				$args = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => 'ame'
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'nopaging' => true
					);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) : ?>
				
				<h3 itemprop="name">Asia &amp; the Middle East</h3>
				<ul class="products"><?php

				while ( $query->have_posts() ) :
					$query->the_post(); 
					
					do_action('lwr_staff_loop');
					
					endwhile; endif;
				wp_reset_postdata();
			?>
				</ul><?php
				
			// DISPLAY LATIN AMERICA
			
				$args = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => 'lac'
						)),
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'nopaging' => true
					);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) : ?>
				
				<h3 itemprop="name">Latin America</h3>
				<ul class="products"><?php

				while ( $query->have_posts() ) :
					$query->the_post(); 
					
					do_action('lwr_staff_loop');
					
					endwhile; endif;
				wp_reset_postdata();
			?>
				</ul><?php
				
		// DISPLAY FINANCE AND ADMINISTRATION
				?><h2 itemprop="name">Finance &amp; Administration</h2>
				<ul class="products">
			<?php if ( have_posts() ) :
				$args2 = array(
					'post_type'	=> 'staffmember',
					'tax_query' => array(
						array(
						'taxonomy' => 'departments',
						'field' => 'slug',
						'terms' => 'f-a'
						)),
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'nopaging' => true
					);
				$query2 = new WP_Query( $args2 );

				while ( $query2->have_posts() ) :
					$query2->the_post(); 

					do_action('lwr_staff_loop');

					endwhile;  ?>
				</ul>


		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; wp_reset_postdata(); ?>
			</div>

		</article><!-- /article -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>
