<?php
/** Translate updater messages through this plugin domain. @param string $message English message. @return string Translated message. */
defined( 'ABSPATH' ) || exit;
return static function ( string $message ): string {
    // Literal calls let the host's normal translation extractor collect every source string.
    switch ( $message ) {
        case 'Private mode must be boolean.':
            return __( 'Private mode must be boolean.', 'genesis-widgetized-notfound' );
        case 'Invalid authentication provider.':
            return __( 'Invalid authentication provider.', 'genesis-widgetized-notfound' );
        case 'The plugin must be installed in a stable slug directory.':
            return __( 'The plugin must be installed in a stable slug directory.', 'genesis-widgetized-notfound' );
        case 'Invalid GitHub repository URL.':
            return __( 'Invalid GitHub repository URL.', 'genesis-widgetized-notfound' );
        case 'The private update could not be authorized. Check the repository credentials and refresh updates.':
            return __( 'The private update could not be authorized. Check the repository credentials and refresh updates.', 'genesis-widgetized-notfound' );
        case 'Could not create the update download file.':
            return __( 'Could not create the update download file.', 'genesis-widgetized-notfound' );
        case 'The private update download failed. Check credentials and try again.':
            return __( 'The private update download failed. Check credentials and try again.', 'genesis-widgetized-notfound' );
        case 'Could not access the update filesystem.':
            return __( 'Could not access the update filesystem.', 'genesis-widgetized-notfound' );
        case 'GitHub release does not contain the plugin main file.':
            return __( 'GitHub release does not contain the plugin main file.', 'genesis-widgetized-notfound' );
        case 'Could not prepare the GitHub release package.':
            return __( 'Could not prepare the GitHub release package.', 'genesis-widgetized-notfound' );
        case 'See the release on GitHub.':
            return __( 'See the release on GitHub.', 'genesis-widgetized-notfound' );
        default:
            return $message;
    }
};
