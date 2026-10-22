<?php
/** GitHub update integration. Copyright 2026 David Decker – DECKERWEB. */
defined( 'ABSPATH' ) || exit;

/**
 * Register the pinned shared updater and host-specific package checks.
 * @since 2.0.0
 * @return void
 */
function ddw_gwnf_register_updater() {
 $class = require GWNF_PLUGIN_DIR . 'includes/deckerweb-github-release-updater-v2.php';
 if ( ! is_string( $class ) || ! class_exists( $class, false ) || ! defined( $class . '::SUPPORTS_HOST_TRANSLATIONS' ) || ! constant( $class . '::SUPPORTS_HOST_TRANSLATIONS' ) ) {
  add_action( 'admin_notices', 'ddw_gwnf_updater_notice' );
  add_action( 'network_admin_notices', 'ddw_gwnf_updater_notice' );
  return;
 }
 try {
  $updater = new $class(
   GWNF_PLUGIN_FILE, 'https://github.com/deckerweb/genesis-widgetized-notfound',
   __( 'Genesis Widgetized Not Found & 404', 'genesis-widgetized-notfound' ),
   __( 'Customize Genesis 404 pages and empty search results with widgets.', 'genesis-widgetized-notfound' ),
   array( 'icons' => array( '1x' => plugins_url( 'assets/icon-128x128.png', GWNF_PLUGIN_FILE ), '2x' => plugins_url( 'assets/icon-256x256.png', GWNF_PLUGIN_FILE ) ), 'banners' => array( 'low' => plugins_url( 'assets/banner-772x250.png', GWNF_PLUGIN_FILE ), 'high' => plugins_url( 'assets/banner-1544x500.png', GWNF_PLUGIN_FILE ) ) ),
   array( 'translate' => require GWNF_PLUGIN_DIR . 'includes/updater-translations.php' )
  );
  $updater->register();
  $GLOBALS['gwnf_updater'] = $updater;
  add_filter( 'upgrader_source_selection', 'ddw_gwnf_validate_update_source', 30, 4 );
 } catch ( Throwable $error ) { add_action( 'admin_notices', 'ddw_gwnf_updater_notice' ); }
}

/**
 * Report a shared updater configuration conflict only to update administrators.
 * @since 2.0.0
 * @return void
 */
function ddw_gwnf_updater_notice() {
 if ( ! current_user_can( 'update_plugins' ) ) { return; }
 echo '<div class="notice notice-warning"><p>' . esc_html__( 'This plugin requires a newer deckerweb Updater integration.', 'genesis-widgetized-notfound' ) . '</p></div>';
}

/**
 * Validate the exact extracted host package before WordPress replaces installed files.
 * @since 2.0.0
 * @param string|WP_Error $source Selected source directory or preceding failure.
 * @param string $remote_source Extraction root.
 * @param WP_Upgrader $upgrader Native upgrader instance.
 * @param array $context Exact plugin/action context, including native bulk context.
 * @return string|WP_Error Verified source, unchanged unrelated source, or safe failure.
 */
function ddw_gwnf_validate_update_source( $source, $remote_source, $upgrader, $context = array() ) {
 if ( is_wp_error( $source ) || ! is_array( $context ) || ( $context['plugin'] ?? '' ) !== plugin_basename( GWNF_PLUGIN_FILE )
  || ( isset( $context['type'] ) && 'plugin' !== $context['type'] ) || ( isset( $context['action'] ) && 'update' !== $context['action'] )
  || ( ! isset( $context['type'], $context['action'] ) && ! ( $upgrader instanceof Plugin_Upgrader && true === $upgrader->bulk ) ) ) { return $source; }
 $error = new WP_Error( 'gwnf_invalid_update', __( 'The update package identity, version or requirements could not be verified. The installed plugin was preserved.', 'genesis-widgetized-notfound' ) );
 global $wp_filesystem, $wp_version;
 $main = trailingslashit( $source ) . 'genesis-widgetized-notfound.php';
 if ( ! $wp_filesystem || ! $wp_filesystem->is_file( $main ) || $wp_filesystem->size( $main ) > 262144 ) { return $error; }
 $text = $wp_filesystem->get_contents( $main );
 if ( ! is_string( $text ) || '' === $text ) { return $error; }
 $headers = array();
 foreach ( array( 'name' => 'Plugin Name', 'version' => 'Version', 'uri' => 'Update URI', 'php' => 'Requires PHP', 'wp' => 'Requires at least', 'domain' => 'Text Domain' ) as $key => $label ) {
  if ( ! preg_match( '/^[ \t\/*#@]*' . preg_quote( $label, '/' ) . ':[ \t]*(.+)$/mi', substr( $text, 0, 8192 ), $match ) ) { return $error; }
  $headers[$key] = trim( preg_replace( '/\s*(?:\*\/|\?>).*$/', '', $match[1] ) );
 }
 $updates = get_site_transient( 'update_plugins' );
 $offer = is_object( $updates ) ? ( $updates->response[plugin_basename( GWNF_PLUGIN_FILE )] ?? null ) : null;
 $expected = is_object( $offer ) ? ( $offer->new_version ?? '' ) : '';
 if ( 'Genesis Widgetized Not Found & 404' !== $headers['name'] || 'genesis-widgetized-notfound' !== $headers['domain']
  || 'https://github.com/deckerweb/genesis-widgetized-notfound' !== $headers['uri'] || ! $expected || $expected !== $headers['version']
  || ! version_compare( $headers['version'], GWNF_VERSION, '>' )
  || ! preg_match( '/^\d+\.\d+(?:\.\d+)?$/D', $headers['wp'] ) || ! preg_match( '/^\d+\.\d+(?:\.\d+)?$/D', $headers['php'] )
  || version_compare( $wp_version, $headers['wp'], '<' ) || version_compare( PHP_VERSION, $headers['php'], '<' ) ) { return $error; }
 return $source;
}
