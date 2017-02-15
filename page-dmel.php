<?php
/**
 * Template Name: DMEL Diagram Page
 *
 * @package storefront
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main dmel" role="main">
      <?php do_action( 'storefront_single_post_before' ); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="http://schema.org/BlogPosting">
			  <?php
				/**
				* @hooked storefront_post_header - 10
				* @hooked storefront_post_meta - 20
				* @hooked storefront_post_content - 30
				*/

				remove_action( 'storefront_single_post', 'storefront_post_header', 10 );
				remove_action( 'storefront_single_post', 'storefront_post_meta', 20 );
				remove_action( 'storefront_single_post', 'storefront_post_content', 30 );

				add_action( 'storefront_single_post', 'lwr_add_breadcrumb', 3 );
				//add_action( 'storefront_single_post', 'lwr_add_page_header_image', 15 );
				add_action( 'storefront_single_post', 'storefront_page_content', 28 );

				do_action( 'storefront_single_post' );

        include('inc/dmel-header.php');
        include('inc/dmel-diagram.php');
        include('inc/dmel-phase-1.php');
        include('inc/dmel-phase-2.php');
        include('inc/dmel-phase-3.php');
        include('inc/dmel-phase-4.php');
        ?>
      </article><!-- #post-## -->
      <?php do_action( 'storefront_single_post_after' ); ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>
<script type="text/javascript" id="cool_find_script" src="<?php bloginfo('stylesheet_directory'); ?>/js/find6.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/dmel-scripts.js"></script>
