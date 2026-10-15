<?php
/** Administration links, contextual help and local documentation. */
defined( 'ABSPATH' ) || exit;
require_once GWNF_PLUGIN_DIR . 'includes/gwnf-comfort.php';
add_action( 'admin_menu', 'ddw_gwnf_add_genesis_submenu' );
add_action( 'admin_init', 'ddw_gwnf_register_settings' );
add_filter( 'option_page_capability_gwnf_settings', 'ddw_gwnf_settings_capability' );
add_action( 'current_screen', 'ddw_gwnf_widgets_help_tab' );
add_action( 'admin_enqueue_scripts', 'ddw_gwnf_admin_assets' );
add_action( 'admin_notices', 'ddw_gwnf_dependency_notice' );
add_filter( 'plugin_action_links_' . plugin_basename( GWNF_PLUGIN_FILE ), 'ddw_gwnf_widgets_page_link' );
add_filter( 'plugin_row_meta', 'ddw_gwnf_plugin_links', 10, 2 );
add_action( 'admin_footer-widgets.php', 'ddw_gwnf_admin_footer' );

/**
 * Add site presentation settings under Genesis, or WordPress Settings without Genesis.
 * @since 1.6.0
 * @return void
 */
function ddw_gwnf_add_genesis_submenu() {
 if ( ddw_gwnf_has_genesis() ) {
  add_submenu_page( 'genesis', __( 'Not Found & 404 Page', 'genesis-widgetized-notfound' ), __( 'Not Found & 404 Page', 'genesis-widgetized-notfound' ), 'edit_theme_options', 'gwnf-settings', 'ddw_gwnf_settings_page' );
 } else {
  add_options_page( __( 'Not Found & 404 Page', 'genesis-widgetized-notfound' ), __( 'Not Found & 404 Page', 'genesis-widgetized-notfound' ), 'edit_theme_options', 'gwnf-settings', 'ddw_gwnf_settings_page' );
 }
}

/**
 * Explain safely paused theme features only on the site's Plugins screen.
 * @since 2.0.0
 * @return void
 */
function ddw_gwnf_dependency_notice() {
 $screen = get_current_screen();
 if ( ddw_gwnf_has_genesis() || is_network_admin() || ! current_user_can( 'edit_theme_options' ) || ! $screen || 'plugins' !== $screen->id ) { return; }
 echo '<div class="notice notice-info"><p>' . esc_html__( 'Genesis Widgetized Not Found & 404 is paused on this site because the Genesis parent theme is not active. Saved widgets are preserved.', 'genesis-widgetized-notfound' ) . '</p></div>';
}

/**
 * Prepend the representative settings link and existing Customizer shortcuts.
 * @since 1.0.0
 * @param array $links Existing plugin actions.
 * @return array Filtered plugin actions for the current site only.
 */
function ddw_gwnf_widgets_page_link( $links ) {
 if ( is_network_admin() || ! current_user_can( 'edit_theme_options' ) ) { return $links; }
 $settings = '<a href="' . esc_url( admin_url( ( ddw_gwnf_has_genesis() ? 'admin.php' : 'options-general.php' ) . '?page=gwnf-settings' ) ) . '">' . esc_html__( 'Settings', 'genesis-widgetized-notfound' ) . '</a>';
 $notfound = '<a href="' . esc_url( ddw_gwnf_get_customizer_preview_link( 'notfound' ) ) . '">' . esc_html__( 'Not found', 'genesis-widgetized-notfound' ) . '</a>';
 $error = '<a href="' . esc_url( ddw_gwnf_get_customizer_preview_link( '404' ) ) . '">404</a>';
 if ( ddw_gwnf_has_genesis() ) { array_unshift( $links, $settings, $notfound, $error ); }
 else { array_unshift( $links, $settings ); }
 /**
  * Filter plugin settings actions.
  * @since 1.6.0
  * @param array $links All action links to return.
  * @param string $settings Settings action markup.
  * @param string $notfound Empty-search preview markup.
  * @param string $error 404 preview markup.
  */
 return apply_filters( 'gwnf/filter/plugins_page/settings_link', $links, $settings, $notfound, $error );
}

/**
 * Add concise documentation and support links without promotional user-data URLs.
 * @since 1.0.0
 * @param array $links Existing row links.
 * @param string $file Plugin basename.
 * @return array Row links, unchanged for other plugins.
 */
function ddw_gwnf_plugin_links( $links, $file ) {
 if ( plugin_basename( GWNF_PLUGIN_FILE ) !== $file ) { return $links; }
 $links[] = '<a href="https://github.com/deckerweb/genesis-widgetized-notfound#faq">' . esc_html__( 'Documentation', 'genesis-widgetized-notfound' ) . '</a>';
 $links[] = '<a href="https://github.com/deckerweb/genesis-widgetized-notfound/issues">' . esc_html__( 'Support', 'genesis-widgetized-notfound' ) . '</a>';
 /** Filter this plugin's support links. @since 1.6.0 @param array $links Row links to return. */
 return apply_filters( 'gwnf/filter/plugins_page/more_links', $links );
}

/**
 * Register contextual help on the Widgets screen and Genesis administration screens.
 * @since 1.2.0
 * @return void
 */
function ddw_gwnf_widgets_help_tab() {
 $screen = get_current_screen();
 if ( ! $screen || ! ddw_gwnf_has_genesis() || ! current_user_can( 'edit_theme_options' ) || ( 'widgets' !== $screen->id && false === strpos( $screen->id, 'genesis' ) ) ) { return; }
 /** Filter the help-tab callback. @since 1.6.0 @param callable $callback Accessible help renderer. */
 $callback = apply_filters( 'gwnf/filter/help_content/help_tab', 'ddw_gwnf_widgets_help_content' );
 $screen->add_help_tab( array( 'id' => 'gwnf-widgets-help', 'title' => __( 'Genesis Widgetized Not Found & 404', 'genesis-widgetized-notfound' ), 'callback' => is_callable( $callback ) ? $callback : 'ddw_gwnf_widgets_help_content' ) );
 if ( 'widgets' === $screen->id ) { $screen->set_help_sidebar( ddw_gwnf_help_sidebar_content() ); }
}

/**
 * Render setup guidance in the existing help tab.
 * @since 1.0.0
 * @return void
 */
function ddw_gwnf_widgets_help_content() {
 echo '<div class="gwnf-help-header"><img src="' . esc_url( plugins_url( 'assets/icon-128x128.png', GWNF_PLUGIN_FILE ) ) . '" alt="" width="48" height="48" /><div><h2>' . esc_html__( 'Genesis Widgetized Not Found & 404', 'genesis-widgetized-notfound' ) . '</h2><p>' . esc_html__( 'Helpful content when nothing is found.', 'genesis-widgetized-notfound' ) . '</p></div></div>';
 echo '<p>' . esc_html__( 'Add widgets to 404 Error Page or Search Not Found under Appearance → Widgets. Empty 404 areas use Genesis output or the enabled 404 starter; empty search areas show the message and search form.', 'genesis-widgetized-notfound' ) . '</p>';
 echo '<p>' . esc_html__( 'The Genesis – Search Form widget lets you set labels, placeholder, button text, title links and display rules.', 'genesis-widgetized-notfound' ) . '</p>';
 echo '<p><code>[gwnf-search]</code> · <code>[gwnf-widget-area area="404"]</code> · <code>[gwnf-widget-area area="notfound"]</code></p>';
 echo '<p>' . esc_html__( 'For forum searches, add widgets to bbPress: Forum Search No Results. The area is available when bbPress is active.', 'genesis-widgetized-notfound' ) . '</p>';
 echo '<p><a href="' . esc_url( ddw_gwnf_get_customizer_preview_link( '404' ) ) . '">' . esc_html__( 'Test 404 error page', 'genesis-widgetized-notfound' ) . '</a> · <a href="' . esc_url( ddw_gwnf_get_customizer_preview_link( 'notfound' ) ) . '">' . esc_html__( 'Test search not found results', 'genesis-widgetized-notfound' ) . '</a></p>';
}

/**
 * Return the host's contextual-help sidebar without changing other screens.
 * @since 1.5.0
 * @return string Escaped help links, customizable as trusted HTML.
 */
function ddw_gwnf_help_sidebar_content() {
 $html = '<p><a href="https://github.com/deckerweb/genesis-widgetized-notfound#faq">' . esc_html__( 'Documentation', 'genesis-widgetized-notfound' ) . '</a></p>';
 /** Filter help-sidebar markup. @since 1.5.0 @param string $html Trusted HTML to return. */
 return apply_filters( 'gwnf/filter/help_content/help_sidebar', $html );
}

/**
 * Enqueue scoped local admin assets; no raw style/script output is used.
 * @since 2.0.0
 * @param string $hook Current admin page hook suffix.
 * @return void
 */
function ddw_gwnf_admin_assets( $hook ) {
 // Harden the embedded Library dialog without changing its pinned runtime.
 if ( str_contains( $hook, 'deckerweb-library' ) || ( 'plugin-install.php' === $hook && ( $_GET['tab'] ?? '' ) === 'deckerweb' ) ) {
  wp_enqueue_style( 'gwnf-library-dialog', plugins_url( 'css/gwnf-admin.css', GWNF_PLUGIN_FILE ), array(), GWNF_VERSION );
 }
 if ( str_contains( $hook, 'gwnf-settings' ) ) {
  wp_enqueue_script( 'gwnf-comfort', plugins_url( 'js/gwnf-comfort.js', GWNF_PLUGIN_FILE ), array(), GWNF_VERSION, true );
  wp_enqueue_style( 'gwnf-admin', plugins_url( 'css/gwnf-admin.css', GWNF_PLUGIN_FILE ), array(), GWNF_VERSION );
  wp_enqueue_style( 'gwnf-footer', plugins_url( 'css/deckerweb-footer.css', GWNF_PLUGIN_FILE ), array(), GWNF_VERSION );
  wp_enqueue_script( 'gwnf-footer', plugins_url( 'js/deckerweb-footer.js', GWNF_PLUGIN_FILE ), array(), GWNF_VERSION, true );
  return;
 }
 if ( ! ddw_gwnf_has_genesis() ) { return; }
 if ( 'widgets.php' !== $hook && false === strpos( $hook, 'genesis' ) ) { return; }
 wp_enqueue_style( 'gwnf-admin', plugins_url( 'css/gwnf-admin.css', GWNF_PLUGIN_FILE ), array(), GWNF_VERSION );
 if ( 'widgets.php' === $hook && current_user_can( 'edit_theme_options' ) ) {
  wp_enqueue_style( 'gwnf-footer', plugins_url( 'css/deckerweb-footer.css', GWNF_PLUGIN_FILE ), array(), GWNF_VERSION );
  wp_enqueue_script( 'gwnf-footer', plugins_url( 'js/deckerweb-footer.js', GWNF_PLUGIN_FILE ), array(), GWNF_VERSION, true );
 }
}

/**
 * Render local structured changelog and documentation through the shared footer.
 * @since 2.0.0
 * @return void
 */
function ddw_gwnf_admin_footer() {
 $screen = get_current_screen();
 if ( ! ddw_gwnf_has_genesis() && ( ! $screen || ! str_contains( $screen->id, 'gwnf-settings' ) ) ) { return; }
 if ( ! current_user_can( 'edit_theme_options' ) ) { return; }
 require_once GWNF_PLUGIN_DIR . 'includes/deckerweb-changelog-v1.php';
 require_once GWNF_PLUGIN_DIR . 'includes/deckerweb-admin-footer-v1.php';
 $de = str_starts_with( determine_locale(), 'de_' );
 $suffix = $de ? '-de' : '';
 \Deckerweb\AdminFooter\V1\StructuredFooter::render( array(
  'id' => 'gwnf', 'about' => __( 'About this plugin', 'genesis-widgetized-notfound' ), 'name' => __( 'Genesis Widgetized Not Found & 404', 'genesis-widgetized-notfound' ), 'version_label' => __( 'Version', 'genesis-widgetized-notfound' ), 'version' => GWNF_VERSION,
  'slogan' => __( 'Helpful content when nothing is found.', 'genesis-widgetized-notfound' ), 'copyright' => '© 2012–2026', 'repository' => 'https://github.com/deckerweb/genesis-widgetized-notfound', 'website' => 'GitHub', 'close' => __( 'Close', 'genesis-widgetized-notfound' ),
  'documents' => array(
   'documentation' => array( 'label' => __( 'Documentation', 'genesis-widgetized-notfound' ), 'url' => 'https://github.com/deckerweb/genesis-widgetized-notfound/blob/master/README' . $suffix . '.md', 'text' => file_get_contents( GWNF_PLUGIN_DIR . 'docs/help' . ( 'de_DE_formal' === determine_locale() ? '-de-formal' : $suffix ) . '.txt' ) ),
   'changelog' => array( 'label' => __( 'Changelog', 'genesis-widgetized-notfound' ), 'url' => 'https://github.com/deckerweb/genesis-widgetized-notfound/blob/master/CHANGES' . $suffix . '.md', 'text' => file_get_contents( GWNF_PLUGIN_DIR . 'docs/changelog' . $suffix . '.txt' ) ),
  ),
 ) );
}
