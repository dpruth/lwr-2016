<?php

	/************************************************
			Homepage Content
	 ************************************************/
	function lwr_manipulate_homepage_elements() {
		remove_action( 'homepage', 'storefront_homepage_content', 10 );
		remove_action( 'homepage', 'storefront_product_categories',	20 );
		remove_action( 'homepage', 'storefront_recent_products', 30 );
		remove_action( 'homepage', 'storefront_featured_products', 40 );
		remove_action( 'homepage', 'storefront_popular_products', 50 );
		remove_action( 'homepage', 'storefront_on_sale_products', 60 );
		remove_action( 'homepage', 'storefront_best_selling_products', 70 );

		add_action( 'homepage', 'lwr_full_screen_video_banner', 5);
		add_action( 'homepage', 'lwr_reach_of_support_section', 10);
		add_action( 'homepage', 'lwr_featured_blog_post', 15);
		add_action( 'homepage', 'lwr_stay_informed_section', 20);
		add_action( 'homepage', 'lwr_what_we_do_section', 25);
		add_action( 'homepage', 'lwr_where_we_work_section', 30);
	}
	add_action( 'init', 'lwr_manipulate_homepage_elements', 3 );

	function lwr_full_screen_video_banner() { ?>
				
		<a href="<?php echo 'http://www.youtube.com/watch?v=' . esc_attr(get_option('homepage_video_link')); ?>" target="_blank" class="has-full-width-image" id="homepage-top-banner" onClick="ga('send', 'event', 'Video', 'play', 'Homepage');" >
			<iframe id="yt-player" src="https://www.youtube.com/embed/<?php echo esc_attr(get_option('homepage_video_link')); ?>?enablejsapi=1&origin=<?php echo get_site_url(); ?>&start=25&modestbranding=1&showinfo=0&rel=0" width="100%" height="548" frameborder="0" allowfullscreen></iframe>
			<script type="text/javascript">
			var tag = document.createElement('script');
				tag.src = 'https://www.youtube.com/iframe_api';
				
				var firstScriptTag = document.getElementsByTagName('script')[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

				var player;
				function onYouTubeIframeAPIReady() {					
					player = new YT.Player('yt-player', {
						events: {
							'onReady': onPlayerReady
							}
					});
				}

				function onPlayerReady(event) {
					var w = jQuery(window).width();
					var h = w*.5625;
					event.target.setSize(w, h);
					event.target.setPlaybackRate(0.5);
					event.target.mute();
					event.target.playVideo();
				}

			</script>
	
			<!-- <img src="<?php // echo esc_attr(get_option('homepage_video_image')); ?>" alt="" /> -->
			<h2><span class="tagline"><?php echo esc_attr(get_option('homepage_video_excerpt')); ?></span><div class="vidlink"><?php echo esc_attr(get_option('homepage_video_instruction')); ?></div></h2>
		</a> 
	<?php }

	function lwr_reach_of_support_section() { ?>
		<div class="animated-object" id="reach-of-support">
			<h2>In <?php echo esc_attr(get_option('homepage_support_year')); ?>, your support of Lutheran World Relief reached:</h2>
			<div><a href="/what-we-do"><img src="<?php echo get_stylesheet_directory_uri() . '/img/people-icon.png'; ?>" alt="People" /></a><strong><?php $year = esc_attr(get_option('homepage_support_people'));
						echo number_format( $year, 0, '',','); ?></strong> People</div>
			<div><a href="/what-we-do"><img src="<?php echo get_stylesheet_directory_uri() . '/img/countries-icon.png'; ?>" alt="Countries" /></a><strong><?php echo esc_attr(get_option('homepage_support_countries')); ?></strong> Countries</div>
			<div><a href="/what-we-do"><img src="<?php echo get_stylesheet_directory_uri() . '/img/projects-icon.png'; ?>" alt="Projects" /></a><strong><?php echo esc_attr(get_option('homepage_support_projects')); ?></strong> Projects</div>
		</div>
	<?php }

	function lwr_featured_blog_post() {
		$meta_query   = WC()->query->get_meta_query();
		$meta_query[] = array(
			'key'   => '_featured',
			'value' => 'yes'
		);
		
		$args = array(
			'posts_per_page' => 1,
			'post_type' => 'product',
			'meta_query' => $meta_query
		);
		
		$featured_post = new WP_Query( $args );
		
		if( $featured_post->have_posts() ) {
			while( $featured_post->have_posts() ):
				$featured_post->the_post(); ?>
				<a href="<?php the_permalink(); ?>" class="has-full-width-image" id="featured-blog-post"> 	
					<?php the_post_thumbnail('full');
				 the_title('<h2>', '<span>&raquo;</span></h2>' );
				 the_excerpt(); ?>
				</a> <?php
			endwhile;
			wp_reset_postdata();		
		} else {
			
			$args = array(
				'posts_per_page' => 1,
				'post__in' => get_option( 'sticky_posts' ),
				'ignore_sticky_posts' => 1
			);
			
			$featured_post = new WP_Query( $args );
		
			while( $featured_post->have_posts() ):
				$featured_post->the_post(); ?>
				<a href="<?php the_permalink(); ?>" class="has-full-width-image" id="featured-blog-post"> 	
					<?php the_post_thumbnail('full');
				 the_title('<h2>', '<span>&raquo;</span></h2>' );
				 the_excerpt(); ?>
				</a> <?php
			endwhile;
			wp_reset_postdata();		
		}
			
	}

	function lwr_stay_informed_section() { ?>
		<div class="horizontal-list" id="stay-informed">
			<h2>STAY INFORMED</h2>
			<div id="signup">
				<?php get_template_part('inc/custom', 'enews-signup' ); ?>
				<h3>eNews</h3>
				<h2>Sign up to receive updates in your inbox every other Friday</h2>
			</div>
			<?php
			 $args = array( 
					'posts_per_page' 	=> 1,
					'cat' => 1,
					'post__not_in' => get_option( 'sticky_posts' ),
					);
				$blog_query = new WP_Query( $args );
				
					while ( $blog_query->have_posts() ){
						$blog_query->the_post(); ?> 
					<a href="<?php the_permalink(); ?>"><div class="img-limit"><?php if(has_post_thumbnail() ) {  echo the_post_thumbnail( array(350, 200) ); } else { echo '<img src="' . get_stylesheet_directory_uri() . '/img/blankproject.png" />'; } ?></div>
					<h3>Blog</h3>
					<h2><?php the_title(); ?></h2>
					</a>
					<?php
					}
								 
				wp_reset_postdata(); 
				
				$args = array( 
					'posts_per_page' 	=> 1,
					'post_type'		=> 'pressrelease'
					);
				$press_query = new WP_Query( $args );
				
				while ( $press_query->have_posts() ){ $press_query->the_post(); ?>
					<a href="<?php the_permalink(); ?>"><div class="img-limit"><?php if(has_post_thumbnail() ){  echo the_post_thumbnail( array(350, 200) ); } else { echo  '<img src="' . get_stylesheet_directory_uri() . '/img/blankproject.png" />'; } ?></div>
					<h3>Press</h3>
					<h2><?php the_title(); ?></h2>
					</a>
					<?php 
					}
								 
				wp_reset_postdata(); 
			
			?>

			<a href="/giving-category/gifts">
				<div class="img-limit"><img src="<?php echo get_site_url() . '/wp-content/uploads/LWR-Gifts-Category-Image.jpg'; ?>" alt="LWR Gifts" /></div>
				<h3>LWR Gifts</h3>
				<h2>Shop our online catalog!</h2>
			</a>
		</div>
		<h2 style="text-align:center;">Lutheran World Relief employs the highest standards <br />
		of financial stewardship and accountability</h2>

		<div id="footer-badges">
			<a href="http://www.charitynavigator.org/index.cfm?bay=search.summary&orgid=4031" target="_blank"></a>
			<a href="http://www.bbb.org/charity-reviews/national/relief-and-development/lutheran-world-relief-in-baltimore-md-494" target="_blank"></a>
			<a href="http://greatnonprofits.org/reviews/lutheran-world-relief" target="_blank"></a>
			<a href="https://www.charitywatch.org/ratings-and-metrics/lutheran-world-relief/416" target="_blank"></a>
			<a href="http://www.interaction.org/members/standards" target="_blank"></a>
		</div>
		<h3 style="text-align:center;"><a href="<?php echo esc_url( get_permalink(356) ); ?>">Read more about the impact of your partnership&raquo;</a></h3>

	<?php }

	function lwr_what_we_do_section() { 
			get_template_part( 'inc/custom', 'what-we-do' ); 
	 }
	 
	function lwr_where_we_work_section() {
			get_template_part( 'inc/custom', 'project-locations' );
	}

?>