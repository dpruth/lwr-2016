<?php
/**
 * The template for displaying all Press Releases.
 *
 * @package storefront
 */

get_header(); 

		add_filter( 'body_class', 'staffmember_body_class' );
			function staffmember_body_class( $class ){
				$class[] = 'single-product';
				return $class;
			};

			do_action( 'storefront_single_post_before' );

					add_action( 'storefront_single_post', 'lwr_add_breadcrumb', 3 );

					remove_action( 'storefront_single_post', 'storefront_post_header', 10 );
					remove_action( 'storefront_single_post', 'storefront_post_meta', 20 );
					remove_action( 'storefront_single_post', 'storefront_post_content', 30 );

			do_action( 'storefront_single_post' );
		?>

	<div id="primary" class="content-area single-product">
		<main id="main" class="site-main" role="main">
			<div class="product">
		<?php while ( have_posts() ) : the_post(); 
			
			?>
			<script type="application/ld+json">
			{
				"@context":	"http://schema.org",
				"@type": 	"Person",
				"name": 	"<?php the_title(); ?>",
				"jobTitle":	"<?php echo staff_member_title(); ?>",
				"image":	"<?php 
					$thumb_id = get_post_thumbnail_id();
					$thumb_url = wp_get_attachment_image_src($thumb_id, 'full');
					echo $thumb_url[0]; ?>",
				"worksFor": "Lutheran World Relief",
				"url": 		"<?php the_permalink(); ?>",
				"email": "<?php echo staff_member_email(); ?>"
			}
			</script>
			<div class="images">
		<?php	
		if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'full' );

		} else {
			echo '<img src="/wp-content/plugins/woocommerce/assets/images/placeholder.png" alt="Placeholder">';
		} ?>
			</div>
			<div class="summary entry-summary">
				<h1 class="product_title entry-title"><?php the_title(); ?></h1>
				<h3><?php echo staff_member_title(); ?></h3>
				<p><?php 
				
				
				if ( staff_member_email() != false ) { ?>
				<a href="mailto:<?php echo staff_member_email(); ?>">Email <?php echo get_the_title() . ' at ' . staff_member_email(); ?></a><?php
				}
				if (staff_member_twitter() == false){
					?></p>
				<?php }
					else { ?><br />
				<a class="twitter-follow-button" data-size="large" href="http://twitter.com/<?php echo staff_member_twitter(); ?>" data-show-count="false" >Follow <?php echo staff_member_twitter(); ?> on Twitter</a></p><?php
					} ?>
				<?php the_content(); ?>
			</div>
			<?php

			/**
			 * @hooked storefront_post_nav - 10
			 */
			do_action( 'storefront_single_post_after' );
			?>

		<?php endwhile; // end of the loop. ?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>