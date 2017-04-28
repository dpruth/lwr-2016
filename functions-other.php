<?php

	/************************************************
			Breadcrumb
	 ************************************************/
	function lwr_add_breadcrumb() { ?>
		<nav id="breadcrumb" vocab="http://schema.org/" typeof="BreadcrumbList">
				<?php if(function_exists('bcn_display')) {
					bcn_display();
				}?>
		</nav>
	<?php }


	/************************************************
			Header Title & Image & Video
	 ************************************************/
	function lwr_add_page_header_image() {
		if ( has_post_thumbnail() ) {
			?>
			<header class="entry-header header-with-image">
				<?php the_post_thumbnail( 'full' );
					the_title( '<h1 class="entry-title within-image" itemprop="name">', '</h1>' ); ?>
			</header>
			<div class="caption"><?php	the_post_thumbnail_caption(); ?></div>
			<?php
		} else {
			?>
			<header class="entry-header">
			<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
			</header>
			<?php
		}

	}
	
	function lwr_add_video_embed() {
		the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' );
		echo '<div class="entry-content" itemprop="video" >';
			$iframe = get_field('video_url');
			preg_match('/src="(.+?)"/', $iframe, $matches);
			$src = $matches[1];
		
			$params = array( 'rel' => 0 );
			$new_src = add_query_arg($params, $src);
			$iframe = str_replace($src, $new_src, $iframe);
		
		echo $iframe;
		
		echo '</header>';
	}


	/*************************************************
			Social Media Links
	 *************************************************/

	 function lwr_social_media_links() { ?>
	 	<div id="social-links">
			<a href="https://www.facebook.com/dialog/share?app_id=1424877374508042&amp;display=popup&amp;href=<?php the_permalink(); ?>&amp;redirect_uri=<?php the_permalink(); ?>" onClick="ga('send', 'social', 'Facebook', 'share', '<?php the_permalink(); ?>');" ><img src="<?php echo get_stylesheet_directory_uri() . '/img/fb-icon.png'; ?>" alt="Share on Facebook" /> Share on Facebook</a>
			<a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&amp;url=<?php the_permalink(); ?>&amp;via=LuthWorldRelief" onClick="ga('send', 'social', 'Twitter', 'tweet', '<?php the_permalink(); ?>');" ><img src="<?php echo get_stylesheet_directory_uri() . '/img/twitter-icon.png'; ?>" alt="Share on Twitter" /> Share on Twitter</a>
		</div><!-- #current-social-links-## -->
	 <?php }


	/*************************************************
			Author Information
	 *************************************************/
	 function lwr_get_author_information() { 
	 
	 if( 'pressrelease' == get_post_type() ) {
		 		$post_object = get_field('media_contact');
		
		if( $post_object ) :
		
			$post = $post_object;
			setup_postdata( $post );
			
			$custom = get_post_custom($post->ID);
			$_staff_member_link = get_the_permalink($post->ID);
			$_staff_member_name = get_the_title($post->ID);
			$_staff_member_title = $custom["_staff_member_title"][0];
			$_staff_member_email = $custom["_staff_member_email"][0];
			$_staff_member_phone = $custom["_staff_member_phone"][0];
			?>
		<div id="author" itemscope itemtype="http://schema.org/Person" >
			<a class="url fn n" rel="author" itemprop="url" href="<?php echo esc_url($_staff_member_link); ?>"><?php echo get_avatar( $_staff_member_email ); ?></a>
			
			<span class="byline">
				<span class="vcard author" >
					<span class="fn" >
						<strong>Media Contact:</strong> <span itemprop="name"><?php echo esc_attr($_staff_member_name ); ?></span><br />
						<span itemprop="jobTitle"><?php echo esc_html($_staff_member_title ); ?></span><br />
						<span itemprop="email"><a href="mailto:<?php echo antispambot($_staff_member_email); ?>" target="_blank" ><?php echo antispambot($_staff_member_email); ?></a></span><br />
						<span itemprop="telephone"><a href="tel:<?php echo esc_attr($_staff_member_phone); ?>"><?php echo esc_attr($_staff_member_phone); ?></a></span>
					</span>
				</span>
			</span>
		</div>
		<?php
		endif;
	 } else {
		 ?>
	 	<div id="author" rel="author" itemscope itemtype="http://schema.org/Person">
	 		<a class="url fn n" rel="author" itemprop="url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )?>"><?php echo get_avatar( get_the_author_meta( 'ID' ) ) ?></a>

			<span class="byline">
				<span class="vcard author">
					<span class="fn" itemprop="author">
						By <a class="url fn n" rel="author" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )?>"><span itemprop="name"><?php echo esc_html( get_the_author() ); ?></span></a><br />
						<span itemprop="jobTitle"><?php echo the_author_meta('description'); ?></span>
					</span>
				</span>
			</span>
	 	</div>

	 <?php }
		wp_reset_postdata();
	 }
	 
	 
	/*****************************************
			Scrolling
	 *****************************************/
	function lwr_scrollTop() {
			if ( is_admin_bar_showing() ) { ?>
				<style> div#top-colors { top: 22px; } nav#site-navigation.scrolled { top: 39px; } #menu-responsive-menu { top: 46px !important; }
					@media screen and (max-width: 782px) {
						div#top-colors { top: 36px; } nav#site-navigation.scrolled { top: 53px; }
					}
					@media screen and (max-width: 600px) {
						div#top-colors { position: absolute; top: -10px; } nav#site-navigation.scrolled { top: 0; }
					}
				</style>
			<?php }
	}
	add_action ( 'wp_footer', 'lwr_scrollTop' );
	
	/*****************************************
			Publications Links
	 *****************************************/
	function lwr_publications_list() {
		if ( in_category(array('181', '183') ) ) {
			if ( in_category( 181 ) ) {
				global $post;
				$current_id = $post->ID;
				
				$args = array(
					'posts_per_page' => 1,
					'tax_query' => array(
						array(
						'taxonomy' => 'product_cat',
						'field' => 'term_id',
						'terms' => 253,
						)
					)
				);
			} else {
				$args = array(
					'posts_per_page' => 1,
					'post_status' => 'any',
					'tax_query' => array(
						array(
							'taxonomy' => 'media_category',
							'field'	=> 'term_id',
							'terms' => 364,
						)
					)
				);
			}
			$query = new WP_Query( $args );
			if ($query->have_posts() ) : 
				?>
			<div class="newsletter">
			<h3>This story is featured in:</h3> <?php
				while($query->have_posts() ) :
					$query->the_post(); 
					
				$cats = get_the_terms( get_the_ID(), 'product_cat'); 
				$prod_cat = array();
				
				if ($cats) {
					foreach( $cats as $cat ) {
						$prod_cat[] = $cat->name;
					}
				} else {
					$cats = get_the_terms( get_the_ID(), 'media_category');
					foreach( $cats as $cat ) {
						$prod_cat[] = $cat->name;
					}
				}
				$pub_cats = join( ", ", $prod_cat );
				?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
					<h2><?php echo esc_html( $pub_cats ); ?></h2>
					<?php the_excerpt(); ?>
					<p><a href="<?php the_permalink(); ?>" class="button">Order a Copy&raquo;</a></p>
				<?php
			
			endwhile;
			wp_reset_postdata(); 
			global $post; 
				echo '<p>View more stories from: ' . get_the_category_list('&gt; ' ) . '</p>';
			?>
			</div><?php
			endif;
			
		}
	}
	
	/*****************************
		Add additional information about external sites on Login and My Account Pages
	*****************************/
	add_action('woocommerce_before_customer_login_form', 'monthly_giving_login' );
	add_action('woocommerce_account_dashboard', 'monthly_giving_login' );
	function monthly_giving_login() { ?>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<h3>Monthly Donors</h3>
			<a class="button" href="https://www.eservicepayments.com/cgi-bin/vanco_ver3.vps?appver3=x1a8uAgje-8dTfwGAicT4jfYGSQ2YUK1meeOWlRPxdl1YzobNDOqExusiAiLTuMt7aTq0JcfkIpPLRF0xHYge49OLO7Dg8yDfJe-osqoHKPelRMIUQO1ws0MDmjSxQn1QuRs3_AoPtmIentShH09tg==">Sign in to the Monthly Portal</a>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<h3>Track your Quilts or Kits</h3>
			<a class="button" href="https://portal.brethren.org/">Log into the Tracker</a>
			<p><small><strong>Username:</strong> Donor01<br />
			<strong>Password:</strong> 2012BSC</small></p>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<h3>Fair Trade Accounts</h3>
			<a class="button" href="https://shop.equalexchange.coop/lwrcoffee/customer/account/login/">Log into Equal Exchange</a>
		</div>

	<?php	}
	
	/*****************************
		Insert SUBSCRIBE TO BLOG form on blog posts
	*****************************/
	
	//Insert ads after fifth paragraph of single post content.
	add_filter( 'the_content', 'prefix_insert_blog_signup' );
		
	function prefix_insert_blog_signup( $content ) {
		
   if ( 'post' == get_post_type() && !is_feed() ) {
		ob_start();
			?>
			<div id="blog-signup"><h2>Get posts like this delivered straight to your inbox:</h2><?php get_template_part('inc/custom', 'enews-signup' ); ?>
			</div>
			<?php
    $blog_signup = ob_get_clean();
				
    return prefix_insert_signup_after_paragraph( $blog_signup, 5, $content );
   }
    return $content;
	}

  // Parent Function that makes the magic happen
	function prefix_insert_signup_after_paragraph( $insertion, $paragraph_id, $content ) {
    $closing_p = '</p>';

    $paragraphs = explode( $closing_p, $content );

    foreach ($paragraphs as $index => $paragraph) {
        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }
        if ( $paragraph_id == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
    }
    return implode( '', $paragraphs );
	}

	
	
	
?>