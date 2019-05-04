<?php

// includes/gwnf-admin

/**
 * Prevent direct access to this file.
 *
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_menu', 'ddw_gwnf_add_genesis_submenu' );
/**
 * Add admin submenu item for each supported integration's post type.
 *   Note: The post type is added as additional param to the admin URL.
 *
 * @since 1.6.0
 */
function ddw_gwnf_add_genesis_submenu() {

	add_submenu_page(
		'genesis',
		esc_html__( 'Not Found &amp; 404 Page', 'genesis-widgetized-notfound' ),
		esc_html__( 'Not Found &amp; 404 Page', 'genesis-widgetized-notfound' ),
		'edit_theme_options',
		esc_url( admin_url( 'widgets.php#gwnf-404-widget' ) )
	);

}  // end function


add_action( 'sidebar_admin_setup', 'ddw_gwnf_prepare_widgets_styles', 50 );
/**
 * Add subtle note in Widgets admin page for our Widget areas.
 *
 * @since 1.6.3
 */
function ddw_gwnf_prepare_widgets_styles() {

	add_action( 'admin_head', 'ddw_gwnf_widgets_styles', 100 );

}  // end function


/**
 * Add subtle note in Widgets admin page for our Widget areas.
 *
 * @since 1.6.0
 * @since 1.6.3 Changed hook.
 */
function ddw_gwnf_widgets_styles() {

	/* translators: NO HTML please, no masked/encoded entities, only letters, numbers, hyphens */
	$info = esc_html_x(
		'Via plugin: Genesis Widgetized Not Found and 404',
		'Note for Widget area title',
		'genesis-widgetized-notfound'
	);

	?>
		<style type='text/css'>
			.wp-admin #gwnf-404-widget .sidebar-name:before,
			.wp-admin #gwnf-notfound-widget .sidebar-name:before,
			.wp-admin #gwnf-bbpress-notfound-area .sidebar-name:before {
				color: #777;
				content: '<?php echo $info; // Our note here! ?>';
				display: inline-block;
				font-size: 13px;
				margin-left: 7px;
				margin-top: 10px;
				overflow: hidden;
			}
			.wp-admin #gwnf-404-widget .sidebar-description,
			.wp-admin #gwnf-notfound-widget .sidebar-description,
			.wp-admin #gwnf-bbpress-notfound-area .sidebar-description {
				background-color: #f7f7f7;
				margin-bottom: 10px;
			}
			.wp-admin #gwnf-404-widget .sidebar-description p,
			.wp-admin #gwnf-notfound-widget .sidebar-description p,
			.wp-admin #gwnf-bbpress-notfound-area .sidebar-description p {
				padding: 15px;
			}
		</style>
	<?php

}  // end function


/**
 * Add "Widgets Page" link to plugin page.
 *
 * @since  1.0.0
 * @since  1.6.0 Enhanced with additional links.
 *
 * @param  string $gwnf_links
 *
 * @return strings String of Widgets admin link.
 */
function ddw_gwnf_widgets_page_link( $gwnf_links ) {

	/** Widgets Admin link */
	$gwnf_widgets_link = sprintf(
		'<a href="%1$s" title="%2$s"><span class="dashicons-before dashicons-welcome-widgets-menus"></span> %3$s</a>',
		esc_url( admin_url( 'widgets.php#gwnf-404-widget' ) ),
		esc_html__( 'Go to the Widgets settings page', 'genesis-widgetized-notfound' ),
		esc_attr__( 'Widgets', 'genesis-widgetized-notfound' )
	);

	/** Customize Not Found link */
	$gwnf_notfound_link = sprintf(
		'<a href="%1$s" title="%2$s" target="_blank" rel="noopener noreferrer"><span class="dashicons-before dashicons-admin-customizer"></span> %3$s</a>',
		esc_url( ddw_gwnf_get_customizer_preview_link( 'notfound' ) ),
		esc_html__( 'Live preview search not found', 'genesis-widgetized-notfound' ),
		esc_attr__( 'Not found', 'genesis-widgetized-notfound' )
	);

	/** Customize 404 link */
	$gwnf_404_link = sprintf(
		'<a href="%1$s" title="%2$s" target="_blank" rel="noopener noreferrer"><span class="dashicons-before dashicons-admin-customizer"></span> %3$s</a>',
		esc_url( ddw_gwnf_get_customizer_preview_link( '404' ) ),
		esc_html__( 'Live preview 404 page', 'genesis-widgetized-notfound' ),
		esc_attr__( '404', 'genesis-widgetized-notfound' )
	);

	/** Set the order of the links */
	array_unshift( $gwnf_links, $gwnf_widgets_link, $gwnf_notfound_link, $gwnf_404_link );

	/** Display plugin settings links */
	return apply_filters(
		'gwnf/filter/plugins_page/settings_link',
		$gwnf_links,
		$gwnf_widgets_link,		// additional param
		$gwnf_notfound_link,	// additional param
		$gwnf_404_link			// additional param
	);

}  // end function


add_filter( 'plugin_row_meta', 'ddw_gwnf_plugin_links', 10, 2 );
/**
 * Add various support links to plugin page.
 *
 * @since  1.0.0
 * @since  1.6.0 Refactoring.
 *
 * @uses   ddw_gwnf_get_info_link()
 *
 * @param  $gwnf_links
 * @param  $gwnf_file
 *
 * @return strings String of plugin links.
 */
function ddw_gwnf_plugin_links( $gwnf_links, $gwnf_file ) {

	/** Capability check */
	if ( ! current_user_can( 'install_plugins' ) ) {
		return $gwnf_links;
	}

	/** List additional links only for this plugin */
	if ( $gwnf_file == GWNF_PLUGIN_BASEDIR . 'genesis-widgetized-notfound.php' ) {

		?>
			<style type="text/css">
				tr[data-plugin="<?php echo $gwnf_file; ?>"] .plugin-version-author-uri a.dashicons-before:before {
					font-size: 17px;
					margin-right: 2px;
					opacity: .85;
					vertical-align: sub;
				}
			</style>
		<?php

		/* translators: Plugins page listing */
		$gwnf_links[] = ddw_gwnf_get_info_link( 'url_wporg_faq', esc_html_x( 'FAQ', 'Plugins page listing', 'genesis-widgetized-notfound' ), 'dashicons-before dashicons-editor-help' );

		/* translators: Plugins page listing */
		$gwnf_links[] = ddw_gwnf_get_info_link( 'url_wporg_forum', esc_html_x( 'Support', 'Plugins page listing', 'genesis-widgetized-notfound' ), 'dashicons-before dashicons-sos' );

		/* translators: Plugins page listing */
		$gwnf_links[] = ddw_gwnf_get_info_link( 'url_fb_group', esc_html_x( 'Facebook Group', 'Plugins page listing', 'genesis-widgetized-notfound' ), 'dashicons-before dashicons-facebook' );

		/* translators: Plugins page listing */
		$gwnf_links[] = ddw_gwnf_get_info_link( 'url_snippets', esc_html_x( 'Code Snippets', 'Plugins page listing', 'genesis-widgetized-notfound' ), 'dashicons-before dashicons-editor-code' );

		/* translators: Plugins page listing */
		$gwnf_links[] = ddw_gwnf_get_info_link( 'url_translate', esc_html_x( 'Translations', 'Plugins page listing', 'genesis-widgetized-notfound' ), 'dashicons-before dashicons-translation' );

		/* translators: Plugins page listing */
		$gwnf_links[] = ddw_gwnf_get_info_link( 'url_donate', esc_html_x( 'Donate', 'Plugins page listing', 'genesis-widgetized-notfound' ), 'button dashicons-before dashicons-thumbs-up' );

		/* translators: Plugins page listing */
		$gwnf_links[] = ddw_gwnf_get_info_link( 'url_newsletter', esc_html_x( 'Join our Newsletter', 'Plugins page listing', 'genesis-widgetized-notfound' ), 'button-primary dashicons-before dashicons-awards' );

	}  // end if

	/** Output the links */
	return apply_filters(
		'gwnf/filter/plugins_page/more_links',
		$gwnf_links
	);

}  // end function


add_action( 'sidebar_admin_setup', 'ddw_gwnf_widgets_help' );
/**
 * Load plugin help tab after core help tabs on Widget admin page.
 *
 * @since 1.2.0
 *
 * @global mixed $GLOBALS[ 'pagenow' ]
 */
function ddw_gwnf_widgets_help() {

	add_action( 'admin_head-' . $GLOBALS[ 'pagenow' ], 'ddw_gwnf_widgets_help_tab' );

}  // end function


add_action( 'load-toplevel_page_genesis', 'ddw_gwnf_widgets_help_tab', 16 );				// Genesis Core
add_action( 'load-genesis_page_seo-settings', 'ddw_gwnf_widgets_help_tab', 16 );			// Genesis SEO
add_action( 'load-genesis_page_genesis-import-export', 'ddw_gwnf_widgets_help_tab', 16 );	// Genesis Import/Export
add_action( 'load-genesis_page_design-settings', 'ddw_gwnf_widgets_help_tab', 16 );			// Prose Child Theme
add_action( 'load-genesis_page_prose-custom', 'ddw_gwnf_widgets_help_tab', 16 );			// Prose Custom Section
add_action( 'load-toplevel_page_dynamik-dashboard', 'ddw_gwnf_widgets_help_tab', 16 );				// Dynamik Child Theme
add_action( 'load-dynamik-dashboard_page_dynamik-design', 'ddw_gwnf_widgets_help_tab', 16 );		// Dynamik Child Design
add_action( 'load-dynamik-dashboard_page_dynamik-custom', 'ddw_gwnf_widgets_help_tab', 16 );		// Dynamik Custom Section
add_action( 'load-dynamik-dashboard_page_dynamik-image-manager', 'ddw_gwnf_widgets_help_tab', 16 );	// Dynamik Image Manager
/**
 * Create and display plugin help tab.
 *
 * @since 1.2.0
 * @since 1.6.0 Code tweaks.
 *
 * @uses ddw_gwnf_help_sidebar_content()
 *
 * @global mixed $gwnf_widgets_screen
 * @global mixed $GLOBALS[ 'pagenow' ]
 */
function ddw_gwnf_widgets_help_tab() {

	global $gwnf_widgets_screen;

	$gwnf_widgets_screen = get_current_screen();

	/** Bail early if conditions not met */
	if ( ! $gwnf_widgets_screen
		|| 'genesis' !== basename( get_template_directory() )
	) {
		return;
	}

	/** Add the new help tab */
	$gwnf_widgets_screen->add_help_tab(
		array(
			'id'       => 'gwnf-widgets-help',
			'title'    => __( 'Genesis Widgetized Not Found & 404', 'genesis-widgetized-notfound' ),
			'callback' => apply_filters(
				'gwnf/filter/help_content/help_tab',
				'ddw_gwnf_widgets_help_content'
			),
		)
	);

	/** Add help sidebar */
	if ( 'widgets.php' === $GLOBALS[ 'pagenow' ] ) {
		$gwnf_widgets_screen->set_help_sidebar( ddw_gwnf_help_sidebar_content() );
	}

	/** Some subtle CSS styling additions ... ;-) */
	?>
		<style type='text/css'>
			/** Dashicons commons */
			#tab-link-gwnf-widgets-help a:before {
				display: inline-block;
				-webkit-font-smoothing: antialiased;
				font-family: 'dashicons';
				font-weight: 400;
				vertical-align: top;
			}

			/** Our help tab */
			#tab-link-gwnf-widgets-help a:before {
				clear: left;
				content: "\f106";
				float: left;
				margin: 1px 5px 25px -3px;
			}
			#tab-panel-gwnf-widgets-help .dashicons-before:before {
				vertical-align: bottom;
			}
			.gwnf-help-version {
				margin-left: 7px;
				opacity: .6;
			}
		</style>
	<?php

}  // end function


/**
 * Create and display plugin help tab content.
 *
 * @since 1.0.0
 * @since 1.6.0 Tweaked markup/code and some content.
 *
 * @uses ddw_gwnf_info_values() Array of all info values.
 * @uses ddw_gwnf_get_info_link()
 * @uses ddw_gwnf_get_info_url()
 * @uses ddw_gwnf_coding_years()
 *
 * @return string HTML content for help tab.
 */
function ddw_gwnf_widgets_help_content() {

	$gwnf_info = (array) ddw_gwnf_info_values();

	/** Helper strings */
	/* translators: 1, 2 = Open and close anchor tags */
	$gwnf_filter_help = ' &ndash; ' . sprintf( __( 'optional, could be deactivated %svia filter%s', 'genesis-widgetized-notfound' ), '<a href="' . esc_url( $gwnf_info[ 'url_snippets' ] ) . '" target="_blank" rel="nofollow noopener noreferrer" title="' . __( 'Code Snippets for Customization', 'genesis-widgetized-notfound' ) . '">', '</a>' );

	$gwnf_bbpress_noresults_widgetized = (bool) apply_filters(
		'gwnf_filter_bbpress_noresults_widgetized',
		'__return_true'
	);

	/** Helper style */
	$gwnf_space_helper = '<div style="height: 10px;"></div>';

	/** Headline */
	echo '<h2><span class="dashicons-before dashicons-welcome-widgets-menus"></span> ' . __( 'Plugin', 'genesis-widgetized-notfound' ) . ': ' . __( 'Genesis Widgetized Not Found & 404', 'genesis-widgetized-notfound' ) . ' <small class="gwnf-help-version">v' . GWNF_VERSION . '</small></h2>';

	/** Widget areas info */
	echo '<p><strong>' . __( 'Added Widget areas by the plugin - only displayed if having active widgets placed in:', 'genesis-widgetized-notfound' ) . '</strong>' .
	'<ul>' . 
		'<li>' . apply_filters( 'gwnf_filter_404_widget_title', __( '404 Error Page', 'genesis-widgetized-notfound' ) ) . ' &mdash; ' . sprintf( __( 'ID: %s', 'genesis-widgetized-notfound' ), '<code>gwnf-404-widget</code>' ) . '</li>' .
		'<li>' . apply_filters( 'gwnf_filter_notfound_widget_title', __( 'Search Not Found', 'genesis-widgetized-notfound' ) ) . ' &mdash; ' . sprintf( __( 'ID: %s', 'genesis-widgetized-notfound' ), '<code>gwnf-notfound-widget</code>' ) . '</li>';
		if ( $gwnf_bbpress_noresults_widgetized ) {

			echo '<li>' . apply_filters( 'gwnf_filter_bbpress_noresults_widget_title', __( 'bbPress: Forum Search No Results', 'genesis-widgetized-notfound' ) ) . ' &mdash; ' . sprintf( __( 'ID: %s', 'genesis-widgetized-notfound' ), '<code>gwnf-bbpress-notfound-area</code>' ) . $gwnf_filter_help . '</li>';

		}  // end if
	echo '</ul>';

	/** Widgets shortcode support */
	if ( defined( 'GWNF_NO_WIDGETS_SHORTCODE' ) && ! GWNF_NO_WIDGETS_SHORTCODE ) {
		echo '<p>' . __( 'Shortcodes are supported in all these widget areas.', 'genesis-widgetized-notfound' ) . '</p>';
	}

	/** Search widget info */
	echo $gwnf_space_helper . '<p><strong>' . sprintf( __( 'Added Widget by the plugin: %s', 'genesis-widgetized-notfound' ), '<em>' . __( 'Genesis - Search Form', 'genesis-widgetized-notfound' ) . '</em>' ) . '</strong></p>' .
		'<ul>' .
			'<li>' . __( 'A search form for your site. With a more options than the default one.', 'genesis-widgetized-notfound' ) . '</li>' .
			'<li>' . __( 'For example, set placeholder and submit button texts via options, plus more stuff, like a few display options.', 'genesis-widgetized-notfound' ) . '</li>' .
		'</ul>';

	/** Shortcode info, plus parameters */
	echo $gwnf_space_helper . '<p><strong>' . __( 'Provided Shortcodes by the plugin:', 'genesis-widgetized-notfound' ) . '</strong></p>' .
		'<p><code>[gwnf-widget-area]</code></p>' .
		'<blockquote><ul>' .
			'<li><em>' . __( 'Supporting the following parameters', 'genesis-widgetized-notfound' ) . ':</em></li>' .
			'<li><code>area</code> &mdash; ' . __( 'ID of the Widget area (Sidebar; see above)', 'genesis-widgetized-notfound' ) . ' &mdash; ' . sprintf( __( 'Default: %s', 'genesis-widgetized-notfound' ), '<em>' . __( 'none, empty', 'genesis-widgetized-notfound' ) . '</em>' ) . '</li>' .
		'</ul></blockquote>' .
		'<p><code>[gwnf-search]</code></p>' .
		'<blockquote><ul>' .
			'<li><em>' . __( 'Supporting the following parameters', 'genesis-widgetized-notfound' ) . ':</em></li>' .
			'<li><code>search_text</code> &mdash; ' . __( 'Search placeholder text', 'genesis-widgetized-notfound' ) . ' &mdash; ' . sprintf( __( 'Default: %s', 'genesis-widgetized-notfound' ), __( 'Search this website', 'genesis-widgetized-notfound' ) ) . '</li>' .
			'<li><code>button_text</code> &mdash; ' . __( 'HTML wrapper tag', 'genesis-widgetized-notfound' ) . ' &mdash; ' . sprintf( __( 'Default: %s', 'genesis-widgetized-notfound' ), __( 'Search', 'genesis-widgetized-notfound' ) ) . '</li>' .
			'<li><code>form_label</code> &mdash; ' . __( 'Additional label before the search form', 'genesis-widgetized-notfound' ) . ' &mdash; ' . sprintf( __( 'Default: %s', 'genesis-widgetized-notfound' ), '<em>' . __( 'none, empty', 'genesis-widgetized-notfound' ) . '</em>' ) . '</li>' .
			'<li><code>wrapper</code> &mdash; ' . __( 'HTML wrapper tag', 'genesis-widgetized-notfound' ) . ' &mdash; ' . sprintf( __( 'Default: %s', 'genesis-widgetized-notfound' ), '<code>div</code>' ) . '</li>' .
			'<li><code>class</code> &mdash; ' . __( 'Can be a custom class, added to the wrapper tag', 'genesis-widgetized-notfound' ) . ' &mdash; ' . sprintf( __( 'Default: %s', 'genesis-widgetized-notfound' ), '<em>' . __( 'none, empty', 'genesis-widgetized-notfound' ) . '</em>' ) . '</li>' .
			'<li><code>post_type</code> &mdash; ' . __( 'Optional setup post type(s) for search', 'genesis-widgetized-notfound' ) . ' &mdash; ' . sprintf( __( 'Default: %s', 'genesis-widgetized-notfound' ), '<em>' . __( 'none, empty', 'genesis-widgetized-notfound' ) . '</em>' . ' &ndash; ' . __( 'i.e., WordPress default search behavior', 'genesis-widgetized-notfound' ) ) . '</li>' .
		'</ul></blockquote>';

	/** Further help content */
	echo $gwnf_space_helper . '<p><h4 style="font-size: 1.1em;">' . __( 'Important plugin links:', 'genesis-widgetized-notfound' ) . '</h4>' .

		ddw_gwnf_get_info_link( 'url_plugin', esc_html__( 'Plugin website', 'genesis-widgetized-notfound' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_gwnf_get_info_link( 'url_wporg_faq', esc_html_x( 'FAQ', 'Help tab info', 'genesis-widgetized-notfound' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_gwnf_get_info_link( 'url_wporg_forum', esc_html_x( 'Support', 'Help tab info', 'genesis-widgetized-notfound' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_gwnf_get_info_link( 'url_snippets', esc_html_x( 'Code Snippets', 'Help tab info', 'genesis-widgetized-notfound' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_gwnf_get_info_link( 'url_translate', esc_html_x( 'Translations', 'Help tab info', 'genesis-widgetized-notfound' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_gwnf_get_info_link( 'url_donate', esc_html_x( 'Donate', 'Help tab info', 'genesis-widgetized-notfound' ), 'button button-primary' ) .

		sprintf(
			'<p><a href="%1$s" target="_blank" rel="nofollow noopener noreferrer" title="%2$s">%2$s</a> &#x000A9; %3$s <a href="%4$s" target="_blank" rel="noopener noreferrer" title="%5$s">%5$s</a></p>',
			ddw_gwnf_get_info_url( 'url_license' ),	//esc_url( $gwnf_info[ 'url_license' ] ),
			esc_attr( $gwnf_info[ 'license' ] ),
			ddw_gwnf_coding_years(),
			ddw_gwnf_get_info_url( 'author_uri' ),	//esc_url( $gwnf_info[ 'author_uri' ] ),
			esc_html( $gwnf_info[ 'author' ] )
		);

}  // end function


/**
 * Helper function for returning the Help Sidebar content.
 *
 * @since 1.5.0
 * @since 1.6.0 Changed some URLs, tweaked code/markup.
 *
 * @uses ddw_gwnf_get_info_url()
 *
 * @return string HTML content for help sidebar.
 */
function ddw_gwnf_help_sidebar_content() {

	$gwnf_help_sidebar_content = '<p><strong>' . __( 'More about the plugin author', 'genesis-widgetized-notfound' ) . '</strong></p>' .
			'<p>' . __( 'Social:', 'genesis-widgetized-notfound' ) . '<br /><a href="https://twitter.com/deckerweb" target="_blank" rel="nofollow noopener noreferrer" title="@ Twitter">Twitter</a> | <a href="https://github.com/deckerweb" target="_blank" rel="nofollow noopener noreferrer" title="@ GitHub">GitHub</a> | <a href="' . ddw_gwnf_get_info_url( 'author_uri' ) . '" target="_blank" rel="noopener noreferrer" title="@ deckerweb.de">deckerweb</a></p>' .
			'<p><a href="' . ddw_gwnf_get_info_url( 'url_wporg_profile' ) . '" target="_blank" rel="noopener noreferrer" title="@ WordPress.org">@ WordPress.org</a></p>';

	return apply_filters(
		'gwnf/filter/help_content/help_sidebar',
		$gwnf_help_sidebar_content
	);

}  // end function
