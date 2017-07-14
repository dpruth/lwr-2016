<?php
/**
 * Partial template for content in front-page.php
 *
 * @package lwr
 */

		
		add_action( 'homepage', 'lwr_hero_banner', 5);
		add_action( 'homepage', 'lwr_mission_section', 10);
		add_action( 'homepage', 'lwr_email_capture', 15);
		add_action( 'homepage', 'lwr_latest_posts_section', 20);
		add_action( 'homepage', 'lwr_impact_section', 25);
		add_action( 'homepage', 'lwr_get_involved_section', 30);
		add_action( 'homepage', 'lwr_what_we_do_section', 35);
		
		do_action( 'homepage' );

/*
 * SELECT DONATION OPTION OR VIDEO BANNER
 */
	function lwr_hero_banner() {
		$hero_banner = get_field('hero_banner');
			
		if($hero_banner == 'donate' ) {
			lwr_featured_donation_option();
		} else {
			lwr_full_screen_video_banner();
		}
	}
	
/*
 *	Section for Featured Donation
 */
	function lwr_featured_donation_option() {
			?>
			<section class="row">
				<div class="jumbotron jumbotron-fluid" id="hero_image" style="background-image: url('<?php echo esc_url( get_field('hero_image') ); ?>');" >
					<div class="overlay"></div>
					<div class="container">
							<h2 class="display-3"><?php	echo esc_attr( get_field('donate_heading') ); ?></h2>
							<p class="lead"><?php echo esc_attr( get_field( 'donate_description' ) ); ?></p>
							<form method="get">
									<input type="number" name="nyp" data-cip-id="nyp" placeholder="Donation Amount ($)" />
									<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( get_field( 'homepage_donate_product' ) ); ?>" />
									<button type="submit" class="btn btn-outline-secondary btn-lg">Quick Donate</button>
							</form>
							<p><a href="<?php 
								$permalink_id = get_field( 'homepage_donate_product' ); 
								the_permalink( $permalink_id ); 
								?>">Learn more&raquo;</a></p>
					</div>
				</div><!-- .jumbotron #hero_image -->
			</section>
						<?php
	}

/*
 *	Section for Full Screen Video
 */	
	function lwr_full_screen_video_banner() { 
	
		$iframe = get_field('home_video_url');
		// use preg_match to find iframe src
		preg_match('/src="(.+?)"/', $iframe, $matches);
		$src = $matches[1];		
		
		// add extra params to iframe src
		$params = array(
				'controls'    		=> 0,
				'enablejsapi' 		=> 1,
				'start' 		=> 25,
				'modestbranding' 	=> 1,
				'showinfo'       	=> 0,
				'rel'    		=> 0
		);
		$new_src = add_query_arg($params, $src);
		$iframe = str_replace($src, $new_src, $iframe);
		
		// add extra attributes to iframe html
		$attributes = 'frameborder="0" allowfullscreen id="yt-player"';
		$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe); ?>
		<section id="homepage-top-banner" class="has-full-width-image">
			<a href="#" target="_blank" onClick="ga('send', 'event', 'Video', 'play', 'Homepage');" >
			<?php echo $iframe; ?>

			<div class="banner" >
				<h2 class="tagline"><?php echo esc_attr(get_field('home_video_heading')); ?></h2>
				<div class="vidlink"><i class="fa fa-play-circle fa-lg" aria-hidden="true"></i><?php echo esc_attr(get_field('video_cta')); ?></div>
			</div>
		</a>
		</section>
	<?php
		add_action('wp_footer', 'video_banner_script');
	}
	
	function video_banner_script() {
		?>
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
		<?php
	}	
/*
 * Section for Mission Statement and Reach of Support
 */
	function lwr_mission_section() {
		?>
		<section class="row justify-content-center">
			<div id="mission" class="jumbotron jumbotron-fluid" >
			<div class="container animated-object" id="reach-of-support">
			<?php the_content(); // Set in the WYSIWYG Content of the homepage ?>
		
			<p class="lead">In <?php the_field('btn_year'); ?>, your support of Lutheran World Relief reached:</p>
			<div class="row">
				<div class="stat col-sm-4 h3"><a href="/what-we-do"><img src="<?php echo get_stylesheet_directory_uri() . '/img/people-icon.png'; ?>" alt="People" /></a><strong><?php $year = get_field('btn_people_helped');
						echo number_format( $year, 0, '',','); ?></strong> People</div>
				<div class="stat col-sm-4 h3"><a href="/what-we-do"><img src="<?php echo get_stylesheet_directory_uri() . '/img/countries-icon.png'; ?>" alt="Countries" /></a><strong><?php echo esc_attr(get_field('btn_countries')); ?></strong> Countries</div>
				<div class="stat col-sm-4 h3"><a href="/what-we-do"><img src="<?php echo get_stylesheet_directory_uri() . '/img/projects-icon.png'; ?>" alt="Projects" /></a><strong><?php echo esc_attr(get_field('btn_projects')); ?></strong> Projects</div>
			</div>
			</div>
			</div>
		</section>
	<?php }

/*
 *	Section for MailChimp email capture form
 */	
	function lwr_email_capture() {
		?>
		<section class="row justify-content-center blue">
			<div id="MailChimp">
				<h2 class="text-center">Good News Delivered To Your Inbox</h2>
					<?php lwr_mailchimp_form('enews', 'homepage'); ?>
				<p class="text-center">Sign up to receive updates in your inbox every other Friday</p>
			</div>
		</section>
		<?php
	}

/*
 *	Section latest blog posts
 */
	function lwr_latest_posts_section() { ?>
		<section id="stay-informed" class="py-5 container justify-content-center">
			<h2 class="display-5 text-center" >Get the Latest from LWR&rsquo;s Blog</h2>
				<div class="card-deck mt-3">
			<?php
			$count = (int)0;
			$args = array( 
					'posts_per_page' 	=> 3,
					'cat' => 1,
					'post__not_in' => get_option( 'sticky_posts' ),
					);
			$blog_query = new WP_Query( $args );
				
			while ( $blog_query->have_posts() ) :
				$blog_query->the_post(); 			
			?> 
		<article class="card" id="post-<?php the_ID(); ?>">
			<a href="<?php the_permalink();?>" rel="bookmark"><?php the_post_thumbnail( 'large', array( 'class' => 'card-img-top img-fluid' ) ); ?></a>
			<div class="card-block">
				<a href="<?php the_permalink();?>" rel="bookmark">
				<h3 class="card-title"><?php the_title(); ?></h3>
				<p class="card-text"><?php echo wp_strip_all_tags( get_the_excerpt(), true); ?></p>
				</a>
			</div>
			<footer class="entry-meta card-footer">
				<?php lwr_posted_on(); ?>
			</footer><!-- .entry-meta -->
		</article><!-- #post-## -->
					<?php
				endwhile;
								 
				wp_reset_postdata(); ?>
			</div>
		<p class="text-center text-uppercase mt-3"><a href="<?php echo get_permalink( get_option('page_for_posts' ) ); ?>">Read More &raquo;</a></p>
		</section>
	<?php }
	
/*
 *	Section Showing impact statement and charity badges
 */
	function lwr_impact_section() { ?>
	<section id="impact" class="row justify-content-center blue">
		<div class="jumbotron blue">
			<h3 class="display-5 text-center">Lutheran World Relief employs the highest standards	of financial stewardship and accountability</h3>

			<?php lwr_charity_badges(); ?>
		
			<p class="lead text-center"><a href="<?php echo esc_url( get_permalink(356) ); ?>">Read more about the impact of your partnership&raquo;</a></p>
		</div>
	</section>
	<?php 
	}
	
	
/*
 *	Section for Quilts, Project Promise, and Farmers Market
 */
	function lwr_get_involved_section() { ?>
		<section id="get_involved" class="py-5 container">
			<h3 class="display-5 text-center">Get Involved</h3>
			
			<?php 	
			$query = new WP_Query( array( 'page_id' => 346 ) );
			while ( $query->have_posts() ) :
				$query->the_post(); ?>
			<div class="card"> <!-- Project Promise -->
				<div class="img-fluid">
					<?php the_post_thumbnail('full', array( 'class' => 'card-img-top' ) ); ?>
				</div>
				<div class="card-block">
					<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="card-text"><?php echo wp_strip_all_tags( get_the_excerpt() ); ?></p>
					<a class="btn btn-primary" href="<?php the_permalink(); ?>">Read more&hellip;</a>
				</div>
			</div>
		<?php
			endwhile;
			wp_reset_postdata();		
			// LWR Farmers Market Post ID = 24811
			// Mission Quilts Post ID = 65
			$query = new WP_Query( array( 'post_type' => 'page', 'post__in' => array(65, 24811) ) );
			if ( $query->have_posts() ) : ?>
			<div class="card-deck justify-content-center mt-3">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post(); ?>
			<div class="card">
				<div class="img-fluid">
					<?php the_post_thumbnail('large', array( 'class' => 'card-img-top' ) ); ?>
				</div>
				<div class="card-block">
					<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="card-text"><?php echo wp_strip_all_tags( get_the_excerpt() ); ?></p>
					<a class="btn btn-primary" href="<?php the_permalink(); ?>">Read more&hellip;</a>
				</div>
			</div>
			<?php 
				endwhile;
				wp_reset_postdata();
		?>
			</div>
		<?php endif; ?>
		</section>
		<?php
	}


	function lwr_what_we_do_section() { 
			get_template_part( 'inc/custom', 'what-we-do' ); 
	 }

		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'lwr' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->



