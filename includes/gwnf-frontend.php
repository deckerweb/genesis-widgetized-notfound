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
 * Select assigned 404 widgets or the explicitly enabled empty-area starter.
 *
 * @since 1.0.0
 * @return void
 */
function gwnf_404_content() {

	$settings = ddw_gwnf_get_settings();
	if ( is_404() && ( is_active_sidebar( 'gwnf-404-widget' ) || $settings['starter_404'] ) ) {

		remove_action( 'genesis_loop', 'genesis_404' );		// Genesis Core
		add_action( 'genesis_loop', is_active_sidebar( 'gwnf-404-widget' ) ? 'gwnf_display_404_widget' : 'ddw_gwnf_display_404_starter' );

	}  // end if

}  // end function


/**
 * Display the "404 Error Page" widget area.
 *
 * @since 1.0.0
 * @return void
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
 * @return void
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
 * @return void
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
 * @return void
 */
function gwnf_nocontent_status() {

	$settings = ddw_gwnf_get_settings();
	$message = '' !== $settings['notfound_text'] ? nl2br( esc_html( $settings['notfound_text'] ) ) : __( 'Sorry, no content matched your criteria. Try a different search?', 'genesis-widgetized-notfound' );
	/** Filter empty-search fallback HTML, sanitized on output. @since 1.0.0 @param string $message Message HTML. */
	$gwnf_notfound_default = apply_filters(
		'gwnf_filter_notfound_default',
		$message
	);

	printf(
		'<div class="gwnf-notfound-default gwnf-area">%1$s</div>
		<br />
		<div class="gwnf-search-area gwnf-area">%2$s</div>',
		wp_kses_post( $gwnf_notfound_default ),
		get_search_form( false )
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
 * @return void
 */
function ddw_gwnf_styles() {

	/** Check for the active widget areas */
	if ( ( is_404() && is_active_sidebar( 'gwnf-404-widget' ) )
		|| ( is_search() && empty( $GLOBALS['wp_query']->posts ) && is_active_sidebar( 'gwnf-notfound-widget' ) )
		|| ( function_exists( 'bbp_is_search' ) && bbp_is_search() && is_active_sidebar( 'gwnf-bbpress-notfound-area' ) )
	) {

		/** Check for Genesis HTML5 */
		$gwnf_genesis_html = ( function_exists( 'genesis_html5' ) && genesis_html5() ) ? 'html5-' : '';

		/** Register our XHTML or HTML5 styles */
		wp_register_style(
			'genesis-widgetized-notfound',
			plugins_url( 'css/gwnf-' . $gwnf_genesis_html . 'styles' . ddw_gwnf_script_suffix() . '.css', dirname( __FILE__ ) ),
			array(),
			ddw_gwnf_script_version(),
			'all'
		);

		/** Enqueue our XHTML or HTML5 styles */
		wp_enqueue_style( 'genesis-widgetized-notfound' );

		/** Enqueue additional styles for a displayed plugin widget area. @since 1.2.0 */
		do_action( 'gwnf_load_styles' );

	}  // end if active widget check

}  // end function


/**
 * Helper function for setting a Genesis layout option for the '404' case.
 *
 * Usage: add_action( 'genesis_meta', '__gwnf_layout_404_full_width' );
 *
 * @since 1.1.0
 * @return void
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
 * @return void
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

	return GWNF_VERSION;

}  // end function

/**
 * Render the opt-in 404 starter only when the normal 404 area is unassigned.
 * Saved widget areas take precedence; all custom text is escaped as plain text.
 * @since 2.0.0
 * @return void
 */
function ddw_gwnf_display_404_starter() {
 $settings = ddw_gwnf_get_settings();
 if ( ! is_404() || ! $settings['starter_404'] || is_active_sidebar( 'gwnf-404-widget' ) ) { return; }
 $title = '' !== $settings['starter_404_title'] ? $settings['starter_404_title'] : __( 'Page not found', 'genesis-widgetized-notfound' );
 $text = '' !== $settings['starter_404_text'] ? $settings['starter_404_text'] : __( 'The page you are looking for could not be found. Please check the address.', 'genesis-widgetized-notfound' );
 echo '<article class="gwnf-404-starter entry"><header class="entry-header"><h1 class="entry-title">' . esc_html( $title ) . '</h1></header><div class="entry-content"><p>' . nl2br( esc_html( $text ) ) . '</p>';
 if ( $settings['starter_404_search'] ) { echo get_search_form( array( 'echo' => false ) ); }
 if ( $settings['starter_404_home'] ) { echo '<p><a class="gwnf-home-link" href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Back to the homepage', 'genesis-widgetized-notfound' ) . '</a></p>'; }
 echo '</div></article>';
}
