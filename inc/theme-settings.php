<?php
/**
 * Check and setup theme's default settings
 *
 * @package lwr
 *
 */
function setup_theme_default_settings() {

	// check if settings are set, if not set defaults.
	// Caution: DO NOT check existence using === always check with == .
	// Latest blog posts style.
	$lwr_posts_index_style = get_theme_mod( 'lwr_posts_index_style' );
	if ( '' == $lwr_posts_index_style ) {
		set_theme_mod( 'lwr_posts_index_style', 'default' );
	}

	// Sidebar position.
	$lwr_sidebar_position = get_theme_mod( 'lwr_sidebar_position' );
	if ( '' == $lwr_sidebar_position ) {
		set_theme_mod( 'lwr_sidebar_position', 'right' );
	}

	// Container width.
	$lwr_container_type = get_theme_mod( 'lwr_container_type' );
	if ( '' == $lwr_container_type ) {
		set_theme_mod( 'lwr_container_type', 'container' );
	}
}
