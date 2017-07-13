<?php
/**
 * The template for displaying all woocommerce pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package lwr
 */

get_header();

$toggle_image = get_field('background_image');
if ( isset($toggle_image) && $toggle_image == true ) {
	$container = 'container-fluid background-image';
} else {
	$container = 'container';
}
?>

<main class="site-main <?php echo esc_html( $container ); ?>" id="main">
	<div class="row">

				<?php woocommerce_content(); ?>

	</div>
</main><!-- #main -->


<?php get_footer(); ?>
