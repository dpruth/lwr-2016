<?php
/**
 * Understrap enqueue scripts
 *
 * @package lwr
 */

if ( ! function_exists( 'lwr_scripts' ) ) {
	/**
	 * Load theme's JavaScript sources.
	 */
	function lwr_scripts() {
		// Get the theme data.
		$the_theme = wp_get_theme();
		wp_enqueue_style( 'lwr-styles', get_stylesheet_directory_uri() . '/css/theme-min.css', array(), $the_theme->get( 'Version' ) );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'lwr-scripts', get_template_directory_uri() . '/js/theme.min.js', array(), $the_theme->get( 'Version' ), true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		wp_enqueue_script( 'lwr-custom', get_template_directory_uri() . '/js/lwr_custom_script.js', array('jquery','typekit'), $the_theme->get( 'Version' ), true );
	}
} // endif function_exists( 'lwr_scripts' ).

add_action( 'wp_enqueue_scripts', 'lwr_scripts' );

// Load Typekit Scripts
	function typekit_scripts() {
		wp_enqueue_script( 'typekit', '//use.typekit.net/kwb3xis.js' );
	}
	add_action( 'wp_enqueue_scripts', 'typekit_scripts');

	
// Load Twitter Scripts
	function twitter_scripts() {
		wp_enqueue_script( 'twitter', 'https://platform.twitter.com/widgets.js', array(), false, true );
	}
	add_action( 'wp_enqueue_scripts', 'twitter_scripts');


/**
 * Remove WooCommerce and other Plugin Styles & Javascript
 */
add_filter( 'woocommerce_enqueue_styles', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
add_filter( 'wpcf7_load_js', '__return_false' );
