<?php
/**
 * Understrap Theme Customizer
 *
 * @package lwr
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists( 'lwr_customize_register' ) ) {
	/**
	 * Register basic customizer support.
	 *
	 * @param object $wp_customize Customizer reference.
	 */
	function lwr_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'lwr_customize_register' );

if ( ! function_exists( 'lwr_theme_customize_register' ) ) {
	/**
	 * Register individual settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function lwr_theme_customize_register( $wp_customize ) {

		// Theme layout settings.
		$wp_customize->add_section( 'lwr_theme_layout_options', array(
			'title'       => __( 'Theme Layout Settings', 'lwr' ),
			'capability'  => 'edit_theme_options',
			'description' => __( 'Container width and sidebar defaults', 'lwr' ),
			'priority'    => 160,
		) );

		$wp_customize->add_setting( 'lwr_container_type', array(
			'default'           => 'container',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_textarea',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'container_type', array(
					'label'       => __( 'Container Width', 'lwr' ),
					'description' => __( "Choose between Bootstrap's container and container-fluid", 'lwr' ),
					'section'     => 'lwr_theme_layout_options',
					'settings'    => 'lwr_container_type',
					'type'        => 'select',
					'choices'     => array(
						'container'       => __( 'Fixed width container', 'lwr' ),
						'container-fluid' => __( 'Full width container', 'lwr' ),
					),
					'priority'    => '10',
				)
			) );

		$wp_customize->add_setting( 'lwr_sidebar_position', array(
			'default'           => 'right',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_textarea',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'lwr_sidebar_position', array(
					'label'       => __( 'Sidebar Positioning', 'lwr' ),
					'description' => __( "Set sidebar's default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.",
					'lwr' ),
					'section'     => 'lwr_theme_layout_options',
					'settings'    => 'lwr_sidebar_position',
					'type'        => 'select',
					'choices'     => array(
						'right' => __( 'Right sidebar', 'lwr' ),
						'left'  => __( 'Left sidebar', 'lwr' ),
						'both'  => __( 'Left & Right sidebars', 'lwr' ),
						'none'  => __( 'No sidebar', 'lwr' ),
					),
					'priority'    => '20',
				)
			) );
	}
} // endif function_exists( 'lwr_theme_customize_register' ).
add_action( 'customize_register', 'lwr_theme_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if ( ! function_exists( 'lwr_customize_preview_js' ) ) {
	/**
	 * Setup JS integration for live previewing.
	 */
	function lwr_customize_preview_js() {
		wp_enqueue_script( 'lwr_customizer', get_template_directory_uri() . '/js/customizer.js',
			array( 'customize-preview' ), '20130508', true );
	}
}
add_action( 'customize_preview_init', 'lwr_customize_preview_js' );
