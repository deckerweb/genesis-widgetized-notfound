<?php

// includes/gwnf-admin-extras

/**
 * Prevent direct access to this file.
 *
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'debug_information', 'ddw_gwnf_site_health_add_debug_info', 12 );
/**
 * Add additional plugin related info to the Site Health Debug Info section.
 *   (Only relevant for WordPress 5.2 or higher)
 *
 * @link https://make.wordpress.org/core/2019/04/25/site-health-check-in-5-2/
 *
 * @since 1.6.4
 *
 * @param array $debug_info Array holding all Debug Info items.
 * @return array Modified array of Debug Info.
 */
function ddw_gwnf_site_health_add_debug_info( $debug_info ) {

	$string_has_widgets = esc_html__( 'Yes, has widgets', 'genesis-widgetized-notfound' );
	$string_no_widgets  = esc_html__( 'No, is empty', 'genesis-widgetized-notfound' );

	/** Add our Debug info */
	$debug_info[ 'genesis-widgetized-notfound' ] = array(
		'label'  => esc_html__( 'Genesis Widgetized Not Found & 404', 'genesis-widgetized-notfound' ) . ' (' . esc_html__( 'Plugin', 'genesis-widgetized-notfound' ) . ')',
		'fields' => array(
			'gwnf_plugin_version' => array(
				'label' => __( 'Plugin version', 'genesis-widgetized-notfound' ),
				'value' => GWNF_VERSION,
			),
			'PARENT_THEME_VERSION' => array(
				'label' => 'Genesis: PARENT_THEME_VERSION',
				'value' => ( ! defined( 'PARENT_THEME_VERSION' ) ? esc_html__( 'Undefined', 'genesis-widgetized-notfound' ) : PARENT_THEME_VERSION ),
			),
			'gwnf_area_notfound' => array(
				'label' => esc_html__( 'Widget Area for Not Found active', 'genesis-widgetized-notfound' ),
				'value' => ( ( is_active_sidebar( 'gwnf-notfound-widget' ) ) ? $string_has_widgets : $string_no_widgets ),
			),
			'gwnf_area_404' => array(
				'label' => esc_html__( 'Widget Area for 404 active', 'genesis-widgetized-notfound' ),
				'value' => ( ( is_active_sidebar( 'gwnf-404-widget' ) ) ? $string_has_widgets : $string_no_widgets ),
			),
		),
	);

	/** Return modified Debug Info array */
	return $debug_info;

}  // end function
