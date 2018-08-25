<?php

// includes/gwnf-widget-areas

/**
 * Prevent direct access to this file.
 *
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Create widget description strings and optional markup for WP-Admin and the
 *   Customizer context.
 *   Note: Markup based description will only display in WordPress version 4.9.7
 *         or higher.
 *
 * @since  1.6.0
 *
 * @global $GLOBALS[ 'wp_customize' ]
 *
 * @param  string $area Which widget area to use.
 * @return string String and HTML markup based upon context.
 */
function ddw_gwnf_get_widget_area_description( $area = '' ) {

	/** Sanitize given area string */
	$area = sanitize_key( $area );

	/** Divider string */
	$divider = esc_html(
		apply_filters(
			'gwnf/filter/widget_areas/divider',
			/* translators: This string is used as a divider between text blocks where HTML is not allowed */
			_x(
				'###',
				'Used as a divider between text blocks where HTML is not allowed',
				'genesis-widgetized-notfound'
			)
		)
	);

	/** Prepare preview link */
	$customizer_preview = sprintf(
		' %1$s &rarr; <a href="%2$s">%3$s</a>',
		$divider,
		esc_url( ddw_gwnf_get_customizer_preview_link( $area ) ),
		esc_html__( 'Customize with Live Preview', 'genesis-widgetized-notfound' )
	);

	/** Prepare note */
	$note = sprintf(
		' %1$s (%2$s)',
		$divider,
		esc_html__( 'Best to open these links in a new browser tab/ window.', 'genesis-widgetized-notfound' )
	);

	/** Prepare "Not Found" output */
	$test_notfound = sprintf(
		' %1$s &rarr; <a href="%2$s">%3$s</a>',
		$divider,
		esc_url( get_site_url() . '/?s=' . md5( rand() ) ),
		esc_html__( 'Test search not found results', 'genesis-widgetized-notfound' )
	);

	/** Prepare "404" output */
	$test_404 = sprintf(
		' %1$s &rarr; <a href="%2$s">%3$s</a>',
		$divider,
		esc_url( get_site_url() . '/404-testing-' . md5( rand() ) ),
		esc_html__( 'Test 404 error page', 'genesis-widgetized-notfound' )
	);

	/** Check Widget area the 2 possible values */
	switch ( $area ) {

		case 'notfound':
			$output_string = '*** ' . esc_html__( 'This is the widget area of the search not found content section.', 'genesis-widgetized-notfound' );
			$output_html   = sprintf(
				'%1$s%2$s%3$s%4$s',
				$output_string,
				( isset( $GLOBALS[ 'wp_customize' ] ) ) ? '' : $customizer_preview,
				$test_notfound,
				$note
			);
			break;
		case '404':
			$output_string = '*** ' . esc_html__( 'This is the widget area of the 404 Not Found Error Page.', 'genesis-widgetized-notfound' );
			$output_html   = sprintf(
				'%1$s%2$s%3$s%4$s',
				$output_string,
				( isset( $GLOBALS[ 'wp_customize' ] ) ) ? '' : $customizer_preview,
				$test_404,
				$note
			);
			break;

	}  // end switch

	/** Finally output the description */
	return apply_filters(
		'gwnf/filter/widget_areas/{$area}/description',
		version_compare( get_bloginfo( 'version' ), '4.9.7', '<=' ) ? $output_string : $output_html,
		$area
	);

}  // end function


add_action( 'init', 'ddw_gwnf_register_widget_areas' );
/**
 * Register additional widget areas.
 *
 *   NOTE: Has to be early on the "init" hook in order to display translations!
 *
 * @since 1.0.0
 * @since 1.6.0 Refactored to adhere to modern Genesis, plus, enhanced for our
 *              use case.
 *
 * @uses  genesis_register_widget_area()
 */
function ddw_gwnf_register_widget_areas() {

	/** Add shortcode support to widgets */
	if ( ! GWNF_NO_WIDGETS_SHORTCODE && ! is_admin() ) {
		add_filter( 'widget_text', 'do_shortcode' );
	}

	/** Set filter for "404 Error Page" widget title */
	$gwnf_404_widget_title = esc_html(
		apply_filters(
			'gwnf/filter/widget_areas/404/title',
			__( '404 Error Page', 'genesis-widgetized-notfound' )
		)
	);

	/** Register the "404 Error Page" widget area */
	genesis_register_widget_area(
		array(
			'id'          => 'gwnf-404-widget',
			'name'        => $gwnf_404_widget_title,
			'description' => ddw_gwnf_get_widget_area_description( '404' ),
		)
	);

	/** Set filter for "Search Not Found" widget title */
	$gwnf_notfound_widget_title = esc_html(
		apply_filters(
			'gwnf/filter/widget_areas/notfound/title',
			__( 'Search Not Found', 'genesis-widgetized-notfound' )
		)
	);

	/** Register the "Search Not Found" widget area */
	genesis_register_widget_area(
		array(
			'id'          => 'gwnf-notfound-widget',
			'name'        => $gwnf_notfound_widget_title,
			'description' => ddw_gwnf_get_widget_area_description( 'notfound' ),
		)
	);

}  // end function