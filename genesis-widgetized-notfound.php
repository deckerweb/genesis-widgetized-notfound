<?php # -*- coding: utf-8 -*-
/**
 * Main plugin file.
 * Finally, use widgets to maintain and customize your 404 Error and Search Not
 *   Found pages in Genesis Framework and Child Themes.
 *
 * @package      Genesis Widgetized Not Found & 404
 * @author       David Decker
 * @copyright    Copyright (c) 2012-2019, David Decker - DECKERWEB
 * @license      GPL-2.0-or-later
 * @link         https://deckerweb.de/twitter
 * @link         https://www.facebook.com/groups/deckerweb.wordpress.plugins/
 *
 * @wordpress-plugin
 * Plugin Name:  Genesis Widgetized Not Found & 404
 * Plugin URI:   https://github.com/deckerweb/genesis-widgetized-notfound/
 * Description:  Finally, use widgets to maintain and customize your 404 Error and Search Not Found pages in Genesis Framework and Child Themes.
 * Version:      1.6.4
 * Author:       David Decker - DECKERWEB
 * Author URI:   https://deckerweb.de/
 * License:      GPL-2.0-or-later
 * License URI:  https://opensource.org/licenses/GPL-2.0
 * Text Domain:  genesis-widgetized-notfound
 * Domain Path:  /languages/
 * Requires WP:  4.7
 * Requires PHP: 5.6
 *
 * Copyright (c) 2012-2019 David Decker - DECKERWEB
 *
 *     This file is part of Genesis Widgetized Not Found & 404,
 *     a plugin for WordPress.
 *
 *     Genesis Widgetized Not Found & 404 is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 2 of the License, or (at your option)
 *     any later version.
 *
 *     Genesis Widgetized Not Found & 404 is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting constants.
 *
 * @since 1.0.0
 */
/** Set plugin version */
define( 'GWNF_VERSION', '1.6.4' );

/** Plugin directory */
define( 'GWNF_PLUGIN_DIR', trailingslashit( dirname( __FILE__ ) ) );

/** Plugin base directory */
define( 'GWNF_PLUGIN_BASEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );

/** Dev scripts & styles on Debug, minified on production */
define(
	'GWNF_SCRIPT_SUFFIX',
	( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) ? '' : '.min'
);


register_activation_hook( __FILE__, 'ddw_gwnf_activation_check' );
/**
 * Checks for activated Genesis Framework before allowing plugin to activate.
 *
 * @since 1.0.0
 *
 * @uses  load_plugin_textdomain()
 * @uses  get_template_directory()
 * @uses  deactivate_plugins()
 * @uses  wp_die()
 */
function ddw_gwnf_activation_check() {

	/** Load translations to display for the activation message. */
	load_plugin_textdomain( 'genesis-widgetized-notfound', FALSE, GWNF_PLUGIN_BASEDIR . 'languages' );

	/** Check for activated Genesis Framework (= template/parent theme) */
	if ( 'genesis' !== basename( get_template_directory() ) ) {

		/** If no Genesis, deactivate ourself */
		deactivate_plugins( plugin_basename( __FILE__ ) );

		/** Message: no Genesis active */
		$gwnf_deactivation_message = sprintf(
			/* translators: 1 = Plugin name / 2 = anchor opening tag / 3 = anchor closing tag */
			__( 'Sorry, you cannot activate the %1$s plugin unless you have installed the latest version of the %2$sGenesis Framework%3$s.', 'genesis-widgetized-notfound' ),
			__( 'Genesis Widgetized Not Found & 404', 'genesis-widgetized-notfound' ),
			'<a href="https://deckerweb.de/go/genesis/" target="_blank" rel="nofollow noopener noreferrer"><strong><em>', '</em></strong></a>'
		);

		/** Deactivation message */
		wp_die(
			$gwnf_deactivation_message,
			__( 'Plugin', 'genesis-widgetized-notfound' ) . ': ' . __( 'Genesis Widgetized Not Found & 404', 'genesis-widgetized-notfound' ),
			array( 'back_link' => TRUE )
		);

	}  // end-if Genesis check

}  // end function


add_action( 'init', 'ddw_gwnf_init', 1 );
/**
 * Load the text domain for translation of the plugin.
 *   Note: We fire early at 'init' to catch translations for Widgets, too.
 * 
 * @since 1.0.0
 *
 * @uses  load_textdomain()	To load translations first from WP_LANG_DIR sub folder.
 * @uses  load_plugin_textdomain() To additionally load default translations from plugin folder (default).
 */
function ddw_gwnf_init() {

	/** Set unique textdomain string */
	$gwnf_textdomain = 'genesis-widgetized-notfound';

	/** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
	$locale = esc_attr(
		apply_filters(
			'plugin_locale',
			get_locale(),
			$gwnf_textdomain
		)
	);

	/**
	 * WordPress languages directory
	 *   Will default to: wp-content/languages/genesis-widgetized-notfound/genesis-widgetized-notfound-{locale}.mo
	 */
	$gwnf_wp_lang_dir = trailingslashit( WP_LANG_DIR ) . trailingslashit( $gwnf_textdomain ) . $gwnf_textdomain . '-' . $locale . '.mo';

	/** Translations: First, look in WordPress' "languages" folder = custom & update-secure! */
	load_textdomain(
		$gwnf_textdomain,
		$gwnf_wp_lang_dir
	);

	/** Translations: Secondly, look in plugin's "languages" folder = default */
	load_plugin_textdomain(
		$gwnf_textdomain,
		FALSE,
		GWNF_PLUGIN_BASEDIR . 'languages'
	);

}  // end function


add_action( 'init', 'ddw_gwnf_setup', 1 );
/**
 * Setup: Register Widget Areas (Note: Has to be early on the "init" hook in order to display translations!).
 *
 * @since 1.0.0
 */
function ddw_gwnf_setup() {

	/** Define constants and set defaults for removing all or certain sections */
	if ( ! defined( 'GWNF_NO_WIDGETS_SHORTCODE' ) ) {
		define( 'GWNF_NO_WIDGETS_SHORTCODE', FALSE );
	}

	if ( ! defined( 'GWNF_SHORTCODE_FEATURES' ) ) {
		define( 'GWNF_SHORTCODE_FEATURES', TRUE );
	}

	/** Load global functions */
	require_once( GWNF_PLUGIN_DIR . 'includes/gwnf-functions-global.php' );

	/** Include admin and frontend functions */
	if ( is_admin() ) {
		require_once( GWNF_PLUGIN_DIR . 'includes/gwnf-admin.php' );
		require_once( GWNF_PLUGIN_DIR . 'includes/gwnf-admin-extras.php' );
	} else {
		require_once( GWNF_PLUGIN_DIR . 'includes/gwnf-frontend.php' );
	}

	/** Add "Widgets Page" link to plugin page */
	if ( ( is_admin() || is_network_admin() )
		&& current_user_can( 'edit_theme_options' )
	) {

		add_filter(
			'plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_gwnf_widgets_page_link'
		);

		add_filter(
			'network_admin_plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_gwnf_widgets_page_link'
		);

	}  // end if

	/**
	 * Check for activated Genesis Framework (= template/parent theme)
	 * Register additional widget areas
	 */
	if ( basename( get_template_directory() ) == 'genesis'
		|| function_exists( 'genesis_register_widget_area' )
	) {
		require_once( GWNF_PLUGIN_DIR . 'includes/gwnf-widget-areas.php' );
	}

	/** Load our Shortcode function */
	if ( defined( 'GWNF_SHORTCODE_FEATURES' ) && GWNF_SHORTCODE_FEATURES ) {
		require_once( GWNF_PLUGIN_DIR . 'includes/gwnf-shortcodes.php' );
	}


	/**
	 * Filter for custom disabling of the widgetized no search results area.
	 *
	 * Usage: add_filter( 'gwnf_filter_bbpress_noresults_widgetized', '__return_false' );
	 */
	$gwnf_bbpress_noresults_widgetized = (bool) apply_filters(
		'gwnf_filter_bbpress_noresults_widgetized',
		'__return_true'
	);

	/** For bbPress 2.3+: Load optional widgetized not found area */
	if ( $gwnf_bbpress_noresults_widgetized && function_exists( 'bbp_is_search' ) ) {

		require_once( GWNF_PLUGIN_DIR . 'includes/gwnf-bbpress-widgetized-noresults.php' );

		add_action( 'init', 'ddw_gwnf_bbpress_search_actions', 5 );

	}  // end-if filter & bbPress 2.3+ check

}  // end function


add_action( 'widgets_init', 'ddw_gwnf_register_widgets' );
/**
 * Register the widget, include plugin file.
 *
 * @since 1.5.0
 */
function ddw_gwnf_register_widgets() {

	/** Load widget code part */
	require_once( GWNF_PLUGIN_DIR . 'includes/gwnf-widget-search.php' );

	/** Register the widget */
	register_widget( 'DDW_GWNF_Search_Widget' );

}  // end function
