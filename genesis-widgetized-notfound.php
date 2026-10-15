<?php
/**
 * Plugin Name: Genesis Widgetized Not Found & 404
 * Plugin URI: https://github.com/deckerweb/genesis-widgetized-notfound
 * Description: Customize Genesis 404 pages and empty search results with widgets, an accessible search form and shortcodes.
 * Version: 2.0.0
 * Requires at least: 6.4
 * Requires PHP: 8.0
 * Author: David Decker – DECKERWEB
 * Author URI: https://github.com/deckerweb
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: genesis-widgetized-notfound
 * Domain Path: /languages/
 * Update URI: https://github.com/deckerweb/genesis-widgetized-notfound
 * GitHub Plugin URI: https://github.com/deckerweb/genesis-widgetized-notfound
 *
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
defined( 'ABSPATH' ) || exit;

define( 'GWNF_VERSION', '2.0.0' );
define( 'GWNF_PLUGIN_FILE', __FILE__ );
define( 'GWNF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'GWNF_PLUGIN_BASEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );
define( 'GWNF_SCRIPT_SUFFIX', defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );

require_once GWNF_PLUGIN_DIR . 'includes/deckerweb-plugin-library/bootstrap.php';
deckerweb_library_register_v2( __FILE__, array(), GWNF_PLUGIN_DIR . 'includes/deckerweb-plugin-library' );
add_action( 'init', 'ddw_gwnf_init', 0 );
add_action( 'init', 'ddw_gwnf_setup', 1 );
add_action( 'widgets_init', 'ddw_gwnf_register_widgets' );

/**
 * Load translations after WordPress initializes, preserving custom overrides.
 * @since 1.0.0
 * @return void
 */
function ddw_gwnf_init() {
 $domain = 'genesis-widgetized-notfound';
 $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
 if ( is_string( $locale ) && preg_match( '/^[a-zA-Z0-9_@-]+$/D', $locale ) ) {
  $custom = WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo';
  if ( is_readable( $custom ) ) { load_textdomain( $domain, $custom ); }
 }
 load_plugin_textdomain( $domain, false, GWNF_PLUGIN_BASEDIR . 'languages' );
}

/**
 * Check the active parent theme and Genesis API on the current site.
 * @since 2.0.0
 * @return bool Whether Genesis features can run.
 */
function ddw_gwnf_has_genesis() {
 return 'genesis' === get_template() && function_exists( 'genesis_register_widget_area' );
}

/**
 * Load components and pause theme features safely without Genesis.
 * Network activation evaluates each site's theme at request time.
 * @since 1.0.0
 * @return void
 */
function ddw_gwnf_setup() {
 if ( ! defined( 'GWNF_NO_WIDGETS_SHORTCODE' ) ) { define( 'GWNF_NO_WIDGETS_SHORTCODE', false ); }
 if ( ! defined( 'GWNF_SHORTCODE_FEATURES' ) ) { define( 'GWNF_SHORTCODE_FEATURES', true ); }
 require_once GWNF_PLUGIN_DIR . 'includes/gwnf-functions-global.php';
 require_once GWNF_PLUGIN_DIR . 'includes/gwnf-settings.php';
 require_once GWNF_PLUGIN_DIR . 'includes/gwnf-updater.php';
 ddw_gwnf_register_updater();
 if ( is_admin() ) {
  require_once GWNF_PLUGIN_DIR . 'includes/gwnf-admin.php';
  require_once GWNF_PLUGIN_DIR . 'includes/gwnf-admin-extras.php';
 }
 if ( ! ddw_gwnf_has_genesis() ) { return; }
 add_filter( 'genesis_site_layout', 'ddw_gwnf_selected_layout' );
 require_once GWNF_PLUGIN_DIR . 'includes/gwnf-frontend.php';
 require_once GWNF_PLUGIN_DIR . 'includes/gwnf-search-form.php';
 require_once GWNF_PLUGIN_DIR . 'includes/gwnf-widget-areas.php';
 ddw_gwnf_register_widget_areas();
 if ( GWNF_SHORTCODE_FEATURES ) { require_once GWNF_PLUGIN_DIR . 'includes/gwnf-shortcodes.php'; }
 /**
  * Enable the optional bbPress empty-search widget area.
  * @since 1.5.0
  * @param bool $enabled Whether to register this integration.
  */
 if ( function_exists( 'bbp_is_search' ) && apply_filters( 'gwnf_filter_bbpress_noresults_widgetized', true ) ) {
  require_once GWNF_PLUGIN_DIR . 'includes/gwnf-bbpress-widgetized-noresults.php';
  ddw_gwnf_bbpress_search_actions();
  ddw_gwnf_bbpress_widgetized_noresults_area();
 }
}

/**
 * Register the existing widget identity, preserving saved instances.
 * @since 1.5.0
 * @return void
 */
function ddw_gwnf_register_widgets() {
 if ( ! ddw_gwnf_has_genesis() ) { return; }
 require_once GWNF_PLUGIN_DIR . 'includes/gwnf-widget-search.php';
 register_widget( 'DDW_GWNF_Search_Widget' );
}
