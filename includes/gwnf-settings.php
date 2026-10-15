<?php
/** Per-site presentation settings. Copyright 2026 David Decker – DECKERWEB. */
defined( 'ABSPATH' ) || exit;

/**
 * Read this site's presentation options with conservative defaults.
 * @since 2.0.0
 * @return array Site presentation flags and plain-text fallback content.
 */
function ddw_gwnf_get_settings() {
 $saved = get_option( 'gwnf_settings', array() );
 $saved = is_array( $saved ) ? $saved : array();
 return array(
  'full_width_404' => ! empty( $saved['full_width_404'] ),
  'full_width_search' => ! empty( $saved['full_width_search'] ),
  'starter_404' => ! empty( $saved['starter_404'] ),
  'starter_404_title' => is_string( $saved['starter_404_title'] ?? null ) ? $saved['starter_404_title'] : '',
  'starter_404_text' => is_string( $saved['starter_404_text'] ?? null ) ? $saved['starter_404_text'] : '',
  'starter_404_search' => ! isset( $saved['starter_404_search'] ) || ! empty( $saved['starter_404_search'] ),
  'starter_404_home' => ! isset( $saved['starter_404_home'] ) || ! empty( $saved['starter_404_home'] ),
  'notfound_text' => is_string( $saved['notfound_text'] ?? null ) ? $saved['notfound_text'] : '',
 );
}

/**
 * Sanitize exactly the supported site options; unchecked boxes revert to false.
 * @since 2.0.0
 * @param mixed $input Submitted Settings API value.
 * @return array Sanitized flags and plain-text fallback message.
 */
function ddw_gwnf_sanitize_settings( $input ) {
 $input = is_array( $input ) ? $input : array();
 return array(
  'full_width_404' => in_array( $input['full_width_404'] ?? false, array( '1', 1, true ), true ),
  'full_width_search' => in_array( $input['full_width_search'] ?? false, array( '1', 1, true ), true ),
  'starter_404' => in_array( $input['starter_404'] ?? false, array( '1', 1, true ), true ),
  'starter_404_title' => is_string( $input['starter_404_title'] ?? null ) ? trim( sanitize_text_field( $input['starter_404_title'] ) ) : '',
  'starter_404_text' => is_string( $input['starter_404_text'] ?? null ) ? trim( sanitize_textarea_field( $input['starter_404_text'] ) ) : '',
  'starter_404_search' => in_array( $input['starter_404_search'] ?? false, array( '1', 1, true ), true ),
  'starter_404_home' => in_array( $input['starter_404_home'] ?? false, array( '1', 1, true ), true ),
  'notfound_text' => is_string( $input['notfound_text'] ?? null ) ? trim( sanitize_textarea_field( $input['notfound_text'] ) ) : '',
 );
}

/**
 * Register the site-level Settings API option and its save capability.
 * @since 2.0.0
 * @return void
 */
function ddw_gwnf_register_settings() {
 register_setting( 'gwnf_settings', 'gwnf_settings', array(
  'type' => 'array', 'sanitize_callback' => 'ddw_gwnf_sanitize_settings',
  'default' => array( 'full_width_404' => false, 'full_width_search' => false, 'notfound_text' => '', 'starter_404' => false, 'starter_404_title' => '', 'starter_404_text' => '', 'starter_404_search' => true, 'starter_404_home' => true ),
 ) );
}

/**
 * Use the same site capability as widget administration for native Settings API saves.
 * @since 2.0.0
 * @param string $capability WordPress's default option-group capability.
 * @return string Required capability for this option group only.
 */
function ddw_gwnf_settings_capability( $capability ) { return 'edit_theme_options'; }

/**
 * Select full-width Genesis layout only for the explicitly enabled page contexts.
 * @since 2.0.0
 * @param string|null $layout Earlier Genesis layout override, or null for its default logic.
 * @return string|null Full-width content or the unchanged earlier override.
 */
function ddw_gwnf_selected_layout( $layout ) {
 $settings = ddw_gwnf_get_settings();
 if ( ( is_404() && $settings['full_width_404'] )
  || ( ! is_404() && is_search() && empty( $GLOBALS['wp_query']->posts ) && $settings['full_width_search'] ) ) {
  return 'full-width-content';
 }
 return $layout;
}

/**
 * Render useful site settings, widget shortcuts and one native save confirmation.
 * WordPress options.php validates the nonce and option-group capability before writing.
 * @since 2.0.0
 * @return void
 */
function ddw_gwnf_settings_page() {
 if ( ! current_user_can( 'edit_theme_options' ) ) { return; }
 $settings = ddw_gwnf_get_settings();
 echo '<div class="wrap gwnf-settings"><div class="gwnf-help-header"><img src="' . esc_url( plugins_url( 'assets/icon-128x128.png', GWNF_PLUGIN_FILE ) ) . '" alt="" width="48" height="48" /><div><h1>' . esc_html__( 'Genesis Widgetized Not Found & 404', 'genesis-widgetized-notfound' ) . '</h1><p>' . esc_html__( 'Helpful content when nothing is found.', 'genesis-widgetized-notfound' ) . '</p></div></div><hr class="wp-header-end" />';
 // Core's success message is emitted once, outside the contiguous title and slogan.
 settings_errors();
 if ( ! ddw_gwnf_has_genesis() ) {
  echo '<div class="notice notice-info inline"><p>' . esc_html__( 'Genesis Widgetized Not Found & 404 is paused on this site because the Genesis parent theme is not active. Saved widgets are preserved.', 'genesis-widgetized-notfound' ) . '</p></div>';
 }
 echo '<p>' . esc_html__( 'These settings apply only to this website. Unchecked layout options keep the theme layout.', 'genesis-widgetized-notfound' ) . '</p>';
 if ( ddw_gwnf_has_genesis() ) { ddw_gwnf_render_setup_status(); }
 echo '<form method="post" action="' . esc_url( admin_url( 'options.php' ) ) . '">';
 settings_fields( 'gwnf_settings' );
 echo '<table class="form-table" role="presentation"><tbody><tr><th id="gwnf-404-heading" scope="row">' . esc_html__( '404 page', 'genesis-widgetized-notfound' ) . '</th><td><label for="gwnf-full-width-404"><input id="gwnf-full-width-404" aria-describedby="gwnf-404-heading" type="checkbox" name="gwnf_settings[full_width_404]" value="1" ' . checked( $settings['full_width_404'], true, false ) . ' /> ' . esc_html__( 'Use full content width without sidebars', 'genesis-widgetized-notfound' ) . '</label></td></tr>';
 echo '<tr><th id="gwnf-search-heading" scope="row">' . esc_html__( 'Search with no results', 'genesis-widgetized-notfound' ) . '</th><td><label for="gwnf-full-width-search"><input id="gwnf-full-width-search" aria-describedby="gwnf-search-heading" type="checkbox" name="gwnf_settings[full_width_search]" value="1" ' . checked( $settings['full_width_search'], true, false ) . ' /> ' . esc_html__( 'Use full content width without sidebars', 'genesis-widgetized-notfound' ) . '</label><p class="description">' . esc_html__( 'Searches with results keep their usual layout.', 'genesis-widgetized-notfound' ) . '</p></td></tr>';
 echo '<tr><th scope="row"><label for="gwnf-notfound-text">' . esc_html__( 'Default no-results message', 'genesis-widgetized-notfound' ) . '</label></th><td><textarea id="gwnf-notfound-text" name="gwnf_settings[notfound_text]" class="large-text" rows="4" aria-describedby="gwnf-notfound-help">' . esc_textarea( $settings['notfound_text'] ) . '</textarea><p id="gwnf-notfound-help" class="description">' . esc_html__( 'Plain text. Leave empty to use the translated default. This message appears only when the Search Not Found widget area is empty. The search form stays visible.', 'genesis-widgetized-notfound' ) . '</p></td></tr></tbody></table>';
 ddw_gwnf_render_starter_fields( $settings );
 submit_button();
 echo '</form>';
 if ( ddw_gwnf_has_genesis() ) { echo '<p><a class="button" href="' . esc_url( admin_url( 'widgets.php#gwnf-404-widget' ) ) . '">' . esc_html__( 'Manage widgets', 'genesis-widgetized-notfound' ) . '</a> <a class="button" href="' . esc_url( ddw_gwnf_get_customizer_preview_link( '404' ) ) . '">' . esc_html__( 'Test 404 error page', 'genesis-widgetized-notfound' ) . '</a> <a class="button" href="' . esc_url( ddw_gwnf_get_customizer_preview_link( 'notfound' ) ) . '">' . esc_html__( 'Test search not found results', 'genesis-widgetized-notfound' ) . '</a></p>'; }
 if ( ddw_gwnf_has_genesis() ) { ddw_gwnf_render_comfort_tools(); }
 ddw_gwnf_admin_footer();
 echo '</div>';
}
