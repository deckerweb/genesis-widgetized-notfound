<?php
/** Preserve widget settings/content; clean temporary shared data only for the final host. */
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;
require_once __DIR__ . '/includes/deckerweb-plugin-library/lifecycle.php';
deckerweb_library_uninstall_v3( __DIR__ . '/genesis-widgetized-notfound.php' );
