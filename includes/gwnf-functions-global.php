<?php

// includes/gwnf-functions-global

/**
 * Prevent direct access to this file.
 *
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting internal plugin helper values.
 *
 * @since 1.6.0
 * @since 1.6.1 Added FB Group.
 * @since 1.6.4 Added Newsletter.
 *
 * @return array Array of info values.
 */
function ddw_gwnf_info_values() {

	$gwnf_info = array(

		'url_translate'     => 'https://translate.wordpress.org/projects/wp-plugins/genesis-widgetized-notfound',
		'url_wporg_faq'     => 'https://wordpress.org/plugins/genesis-widgetized-notfound/#faq',
		'url_wporg_forum'   => 'https://wordpress.org/support/plugin/genesis-widgetized-notfound',
		'url_wporg_profile' => 'https://profiles.wordpress.org/daveshine/',
		'url_snippets'      => 'https://gist.github.com/deckerweb/2473125',
		'url_fb_group'      => 'https://www.facebook.com/groups/deckerweb.wordpress.plugins/',
		'license'           => 'GPL-2.0-or-later',
		'url_license'       => 'https://www.gnu.org/licenses/gpl-2.0.html',
		'url_donate'        => 'https://www.paypal.me/deckerweb',
		'url_newsletter'    => 'https://github.com/deckerweb',
		'url_plugin'        => 'https://github.com/deckerweb/genesis-widgetized-notfound',
		'first_code'        => '2012',
		'author'            => __( 'David Decker - DECKERWEB', 'genesis-widgetized-notfound' ),
		'author_uri'        => 'https://github.com/deckerweb',

	);  // end array

	return $gwnf_info;

}  // end function


/**
 * Get URL of specific GWNF info value.
 *
 * @since 1.6.0
 *
 * @uses ddw_gwnf_info_values()
 *
 * @param string $url_key String of value key from array of ddw_gwnf_info_values()
 * @param bool   $raw     If raw escaping or regular escaping of URL gets used
 * @return string URL for info value.
 */
function ddw_gwnf_get_info_url( $url_key = '', $raw = FALSE ) {

	$gwnf_info = (array) ddw_gwnf_info_values();

	$output = esc_url( $gwnf_info[ sanitize_key( $url_key ) ] ?? '' );

	if ( TRUE === $raw ) {
		$output = esc_url_raw( $gwnf_info[ sanitize_key( $url_key ) ] ?? '' );
	}

	return $output;

}  // end function


/**
 * Get link with complete markup for a specific BTC info value.
 *
 * @since 1.6.0
 *
 * @uses ddw_gwnf_get_info_url()
 *
 * @param string $url_key String of value key
 * @param string $text    String of text and link attribute
 * @param string $class   String of CSS class
 * @return string HTML markup for linked URL.
 */
function ddw_gwnf_get_info_link( $url_key = '', $text = '', $class = '' ) {

	$link = sprintf(
		'<a class="%1$s" href="%2$s" target="_blank" rel="nofollow noopener noreferrer" title="%3$s">%3$s</a>',
		strtolower( esc_attr( $class ) ),	//sanitize_html_class( $class ),
		ddw_gwnf_get_info_url( $url_key ),
		esc_html( $text )
	);

	return $link;

}  // end function


/**
 * Get timespan of coding years for this plugin.
 *
 * @since 1.6.0
 * @since 1.6.1 Improved first year logic.
 *
 * @uses ddw_gwnf_info_values()
 *
 * @param int $first_year Integer number of first year
 * @return string Timespan of years.
 */
function ddw_gwnf_coding_years( $first_year = '' ) {

	$gwnf_info = (array) ddw_gwnf_info_values();

	$first_year = ( empty( $first_year ) ) ? absint( $gwnf_info[ 'first_code' ] ) : absint( $first_year );

	/** Set year of first released code */
	$code_first_year = ( gmdate( 'Y' ) == $first_year || 0 === $first_year ) ? '' : $first_year . '&#x02013;';

	return $code_first_year . gmdate( 'Y' );

}  // end function


/**
 * Build Customizer live preview URL for certain section, based on Widget area.
 *
 * @since 1.6.0
 *
 * @param string $area Which widget area to use.
 * @return string Customizer live preview link URL based upon context.
 */
function ddw_gwnf_get_customizer_preview_link( $area = '' ) {

	/** Sanitize given area string */
	$area = in_array( $area, array( '404', 'notfound' ), true ) ? $area : '404';

	/** Check Widget area the 2 possible values */
	switch ( $area ) {

		case 'notfound':
			$url = home_url() . '/?s=' . md5( wp_rand() );
			break;
		case '404':
			$url = home_url() . '/404-testing-' . md5( wp_rand() );
			break;

	}  // end switch

	/** Build the Customizer URL and return it */
	return add_query_arg(
		array(
			'autofocus[section]' => 'sidebar-widgets-gwnf-' . $area . '-widget',
			'url'                => $url,
		),
		admin_url( 'customize.php' )
	);

}  // end function

/**
 * Build a normal frontend test URL without altering saved content or query behavior.
 * Random identifiers make a real missing-page/empty-search response very likely.
 * @since 2.0.0
 * @param string $area Test context: notfound or 404 (default).
 * @return string Local frontend URL; no preview bypass or forced status.
 */
function ddw_gwnf_get_frontend_test_link( $area = '404' ) {
 $token = 'gwnf-test-' . wp_generate_uuid4();
 return add_query_arg( 'notfound' === $area ? 's' : 'pagename', $token, home_url( '/' ) );
}
