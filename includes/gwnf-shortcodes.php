<?php

// includes/gwnf-shortcodes

/**
 * Prevent direct access to this file.
 *
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_shortcode( 'gwnf-search', 'ddw_gwnf_shortcode_search' );
/**
 * Search Shortcode.
 *
 * @since  1.5.0
 *
 * @param  array $atts Array of Shortcode attributes.
 * @return string HTML String of search form.
 */
function ddw_gwnf_shortcode_search( $atts ) {

	/** Set default shortcode attributes */
	$defaults = array(
		'search_text' => apply_filters(
			'genesis_search_text',
			esc_attr__( 'Search this website', 'genesis-widgetized-notfound' ) . '&#x02026;'
		),
		'button_text' => apply_filters(
			'genesis_search_button_text',
			esc_attr__( 'Search', 'genesis-widgetized-notfound' )
		),
		'form_label'  => '',
		'wrapper'     => 'div',
		'class'       => '',
		'post_type'   => '',
	);

	/** Default shortcode attributes */
	$atts = shortcode_atts( $defaults, $atts, 'gwnf-search' );

	/** Search text parameter */
	$search_text = get_search_query() ? esc_attr( apply_filters( 'the_search_query', get_search_query() ) ) : $atts[ 'search_text' ] . '&#x02026;';

	/** Search text parameter */
	$button_text = $atts[ 'button_text' ];

	/** Placeholder logic */
	$onfocus = " onfocus=\"if (this.value == '$search_text') {this.value = '';}\"";
	$onblur  = " onblur=\"if (this.value == '') {this.value = '$search_text';}\"";

	/** Don't apply JS events to user input */
	if ( is_search() ) {
		$onfocus = $onblur = '';
	}

	/** Empty label, by default. Filterable. */
	$label = ! empty( $atts[ 'form_label' ] ) ? '<label class="screen-reader-text gwnf-search-label" for="s">' . esc_attr( $atts[ 'form_label' ] ) . '</label>' : '';

	/**
	 * Default post type search behavior ('post' + 'page'),
	 *    setup as Shortcode parameter, to make custom post type support possible :).
	 */
	if ( ! empty( $atts[ 'post_type' ] ) ) {
		$post_type = '<input type="hidden" name="post_type" value="' . esc_attr( $atts[ 'post_type' ] ) . '" />';
	} else {
		$post_type = '';
	}

	/** Build the XHTML search form */
	$xhtml_search_form = sprintf(
		'<form method="get" class="searchform search-form" action="%1$s" role="search" >%2$s<input type="text" value="%3$s" name="s" class="s search-input" %4$s %5$s />%6$s<input type="submit" class="searchsubmit search-submit" value="%7$s" /></form>',
		esc_url( home_url( '/' ) ),
		$label,
		esc_attr( $search_text ),
		$onfocus,
		$onblur,
		$post_type,
		esc_attr( $button_text )
	);

	/** Build the HTML5 search form */
	$html5_search_form = sprintf(
		'<form method="get" class="search-form" action="%1$s" role="search">%2$s<input type="search" name="s" placeholder="%3$s" />%4$s<input type="submit" value="%5$s" /></form>',
		esc_url( home_url( '/' ) ),
		$label,
		esc_attr( $search_text ),
		$post_type,
		esc_attr( $button_text )
	);

	/** Build the Shortcode's frontend output */
	$output = sprintf(
		'<%1$s class="gwnf-search-area%2$s">%3$s</%1$s>',
		esc_attr( $atts[ 'wrapper' ] ),
		! empty( $atts[ 'class' ] ) ? esc_attr( $atts[ 'class' ] ) : '',
		( function_exists( 'genesis_html5' ) && genesis_html5() ) ? $html5_search_form : $xhtml_search_form
	);

	/** Return the output - filterable */
	return apply_filters( 'gwnf_filter_shortcode_search', $output, $atts );

}  // end function


add_shortcode( 'gwnf-widget-area', 'ddw_gwnf_shortcode_widget_area' );
/**
 * Display one of our 3 widget areas (only if active) via Shortcode.
 *
 * @since  1.5.0
 *
 * @uses   gwnf_display_404_widget()
 * @uses   gwnf_display_notfound_widget()
 *
 * @param  array $atts Array of Shortcode attributes.
 * @return string HTML String of Widget area.
 */
function ddw_gwnf_shortcode_widget_area( $atts ) {

	/** Set default shortcode attributes */
	$defaults = array(
		'area' => '',
	);

	/** Default shortcode attributes */
	$atts = shortcode_atts( $defaults, $atts, 'gwnf-widget-area' );

	/**
	 * Start Output Buffering - we have no other chance, otherwise widget areas
	 *   would glue at the top of content...
	 */
	ob_start();

	/** If our parameter is not empty: */
	if ( ! empty( $atts[ 'area' ] ) ) {

		/** Check for one of the 3 areas: */
		if ( '404' == $atts[ 'area' ] && is_active_sidebar( 'gwnf-404-widget' ) ) {

			$area_output = gwnf_display_404_widget();

		} elseif ( 'notfound' == $atts[ 'area' ] && is_active_sidebar( 'gwnf-notfound-widget' ) ) {

			$area_output = gwnf_display_notfound_widget();

		} elseif ( 'bbpress-notfound' == $atts[ 'area' ] && is_active_sidebar( 'gwnf-bbpress-notfound-area' ) ) {

			$area_output = sprintf(
				'%1$s%2$s%3$s',
				'<div id="gwnf-bbpress-widgetized-content" class="gwnf-bbpress-notfound-area entry-content">',
				dynamic_sidebar( 'gwnf-bbpress-notfound-area' ),
				'</div><!-- end #content .gwnf-bbpress-notfound-area .entry-content -->'
			);

		} else {

			$area_output = '';

		}  // end-if area check

	}  // end-if parameter check

	/** Get content from the output buffer, without deleting */
	$output = ob_get_contents();

	/** End output buffer */
	return ob_get_clean();

	/** Return the output - filterable */
	return apply_filters( 'gwnf_filter_shortcode_widget_area', $output, $atts );

}  // end function