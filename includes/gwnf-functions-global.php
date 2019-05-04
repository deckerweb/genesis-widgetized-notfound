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

	/** Get current user */
	$user = wp_get_current_user();

	/** Build Newsletter URL */
	$url_nl = sprintf(
		'https://deckerweb.us2.list-manage.com/subscribe?u=e09bef034abf80704e5ff9809&amp;id=380976af88&amp;MERGE0=%1$s&amp;MERGE1=%2$s',
		esc_attr( $user->user_email ),
		esc_attr( $user->user_firstname )
	);

	$gwnf_info = array(

		'url_translate'     => 'https://translate.wordpress.org/projects/wp-plugins/genesis-widgetized-notfound',
		'url_wporg_faq'     => 'https://wordpress.org/plugins/genesis-widgetized-notfound/#faq',
		'url_wporg_forum'   => 'https://wordpress.org/support/plugin/genesis-widgetized-notfound',
		'url_wporg_profile' => 'https://profiles.wordpress.org/daveshine/',
		'url_snippets'      => 'https://gist.github.com/deckerweb/2473125',
		'url_fb_group'      => 'https://www.facebook.com/groups/deckerweb.wordpress.plugins/',
		'license'           => 'GPL-2.0-or-later',
		'url_license'       => 'https://opensource.org/licenses/GPL-2.0',
		'url_donate'        => 'https://www.paypal.me/deckerweb',
		'url_newsletter'    => $url_nl,
		'url_plugin'        => 'https://github.com/deckerweb/genesis-widgetized-notfound',
		'first_code'        => '2012',
		'author'            => __( 'David Decker - DECKERWEB', 'genesis-widgetized-notfound' ),
		'author_uri'        => 'https://deckerweb.de/',

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

	$output = esc_url( $gwnf_info[ sanitize_key( $url_key ) ] );

	if ( TRUE === $raw ) {
		$output = esc_url_raw( $gwnf_info[ esc_attr( $url_key ) ] );
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
	$code_first_year = ( date( 'Y' ) == $first_year || 0 === $first_year ) ? '' : $first_year . '&#x02013;';

	return $code_first_year . date( 'Y' );

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
	$area = sanitize_key( $area );

	/** Check Widget area the 2 possible values */
	switch ( $area ) {

		case 'notfound':
			$url = get_site_url() . '/?s=' . md5( rand() );
			break;
		case '404':
			$url = get_site_url() . '/404-testing-' . md5( rand() );
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
