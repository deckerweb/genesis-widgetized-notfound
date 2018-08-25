<?php

// includes/gwnf-frontend

/**
 * Prevent direct access to this file.
 *
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'genesis_meta', 'gwnf_404_content' );
/**
 * Add the new widgetized 404 Error Page content.
 *
 * @since 1.0.0
 */
function gwnf_404_content() {

	if ( is_404() && is_active_sidebar( 'gwnf-404-widget' ) ) {

		remove_action( 'genesis_loop', 'genesis_404' );		// Genesis Core
		add_action( 'genesis_loop', 'gwnf_display_404_widget' );

	}  // end if

}  // end function


/**
 * Display the "404 Error Page" widget area.
 *
 * @since 1.0.0
 */
function gwnf_display_404_widget() {

	echo '<div id="gwnf-404-area" class="gwnf-area gwnf-404-area">';
		dynamic_sidebar( 'gwnf-404-widget' );
	echo '</div><!-- end #gwnf-404-area -->';

}  // end function


add_action( 'genesis_meta', 'gwnf_notfound_content' );
/**
 * Logic for "Search Not Found" status.
 *
 * @since 1.5.0
 */
function gwnf_notfound_content() {

	/** Display active widget area "Search Not Found" */
	if ( ! is_404() && is_search() ) {

		/** First, remove default Genesis behaviour */
		remove_action( 'genesis_loop_else', 'genesis_do_noposts' );

		if ( is_active_sidebar( 'gwnf-notfound-widget' ) ) {

			/** Add widgetized area, if active */
			add_action( 'genesis_loop_else', 'gwnf_display_notfound_widget' );

		} else {

			/** Otherwise, add our modified no posts/ nocontent status */
			add_action( 'genesis_loop_else', 'gwnf_nocontent_status' );

		}  // end if sidebar check

	}  // end if status check

}  // end function


/**
 * Display the "Search Not Found" widget area.
 *
 * @since 1.5.0
 *
 * @uses  dynamic_sidebar()
 */
function gwnf_display_notfound_widget() {

	echo '<div id="gwnf-notfound-area" class="gwnf-area gwnf-notfound-area">';
		dynamic_sidebar( 'gwnf-notfound-widget' );
	echo '</div><!-- end #gwnf-notfound-area -->';

}  // end function


/**
 * Modify the no content text, adding search form.
 *
 * @since 1.0.0
 */
function gwnf_nocontent_status() {

	/** Set filter for default "Search Not Found" message */
	$gwnf_notfound_default = apply_filters(
		'gwnf_filter_notfound_default',
		__( 'Sorry, no content matched your criteria. Try a different search?', 'genesis-widgetized-notfound' )
	);

	printf(
		'<div class="gwnf-notfound-default gwnf-area">%1$s</div>
		<br />
		<div class="gwnf-search-area gwnf-area">%2$s</div>',
		$gwnf_notfound_default,
		get_search_form( $echo = FALSE )
	);

}  // end function


add_action( 'wp_enqueue_scripts', 'ddw_gwnf_styles' );
/**
 * Enqueue a few additional CSS rules for enhanced compatibility with Genesis
 *    Child Themes.
 * 
 * @since  1.0.0
 *
 * @uses   ddw_gwnf_script_suffix()
 * @uses   ddw_gwnf_script_version()
 *
 * @global mixed $GLOBALS[ 'wp_query' ]
 */
function ddw_gwnf_styles() {

	/** Check for the active widget areas */
	if ( ( is_404() || empty( $GLOBALS[ 'wp_query' ]->posts ) )
		&& ( is_active_sidebar( 'gwnf-404-widget' ) || is_active_sidebar( 'gwnf-notfound-widget' ) )
	) {

		/** Check for Genesis HTML5 */
		$gwnf_genesis_html = ( function_exists( 'genesis_html5' ) && genesis_html5() ) ? 'html5-' : '';

		/** Register our XHTML or HTML5 styles */
		wp_register_style(
			'genesis-widgetized-notfound',
			plugins_url( 'css/gwnf-' . $gwnf_genesis_html . 'styles' . ddw_gwnf_script_suffix() . '.css', dirname( __FILE__ ) ),
			false,
			ddw_gwnf_script_version(),
			'all'
		);

		/** Enqueue our XHTML or HTML5 styles */
		wp_enqueue_style( 'genesis-widgetized-notfound' );

		/** Action hook: 'gwnf_load_styles' - allows for enqueueing additional custom styles */
		do_action( 'gwnf_load_styles' );

	}  // end if active widget check

}  // end function


/**
 * Helper function for setting a Genesis layout option for the '404' case.
 *
 * Usage: add_action( 'genesis_meta', '__gwnf_layout_404_full_width' );
 *
 * @since 1.1.0
 */
function __gwnf_layout_404_full_width() {

	/** Apply the full-width layout in case of "404 Error Page" */
	if ( is_404() ) {
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
	}

}  // end function


/**
 * Helper function for setting a Genesis layout option for the 'search not found' case.
 *
 * Usage: add_action( 'genesis_meta', '__gwnf_layout_searchnotfound_full_width' );
 *
 * @since  1.1.0
 *
 * @global mixed $GLOBALS[ 'wp_query' ]
 */
function __gwnf_layout_searchnotfound_full_width() {

	/** Apply the full-width layout in case of search not found page */
	if ( is_search() && empty( $GLOBALS[ 'wp_query' ]->posts ) ) {
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
	}

}  // end function


/**
 * Helper function for returning string for minifying scripts/ stylesheets.
 *
 * @since  1.6.0
 *
 * @return string String for minifying scripts/ stylesheets.
 */
function ddw_gwnf_script_suffix() {
	
	return ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) ? '' : '.min';

}  // end function


/**
 * Helper function for returning string for versioning scripts/ stylesheets.
 *
 * @since  1.6.0
 *
 * @return string Version string for versioning scripts/ stylesheets.
 */
function ddw_gwnf_script_version() {

	return ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) ? time() : filemtime( plugin_dir_path( __FILE__ ) );

}  // end function