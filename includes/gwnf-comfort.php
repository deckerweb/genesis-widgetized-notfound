<?php
/** Setup status, targeted widget hints and optional presentation controls. */
defined( 'ABSPATH' ) || exit;

/**
 * Read assigned, registered widgets without changing their configuration.
 * @since 2.0.0
 * @param string $sidebar Widget area identity.
 * @return array Registered widget IDs assigned to this area.
 */
function ddw_gwnf_assigned_widgets( $sidebar ) {
 $areas = get_option( 'sidebars_widgets', array() );
 $ids = is_array( $areas ) && is_array( $areas[ $sidebar ] ?? null ) ? $areas[ $sidebar ] : array();
 return array_values( array_filter( $ids, static function ( $id ) {
  return is_string( $id ) && isset( $GLOBALS['wp_registered_widgets'][ $id ] );
 } ) );
}

/**
 * Explain a conflicting search-widget display rule in a plugin-owned area.
 * @since 2.0.0
 * @param string $sidebar Target widget area identity.
 * @param array  $instance Saved widget display rules.
 * @return string Translated explanation, or empty when there is no conflict.
 */
function ddw_gwnf_rule_warning( $sidebar, $instance ) {
 $rule = $instance['widget_display'] ?? 'global';
 $singular = in_array( $rule, array( 'single_posts', 'single_pages', 'single_posts_pages' ), true );
 if ( $singular || ( 'gwnf-404-widget' === $sidebar && 'only_notfound' === $rule ) || ( 'gwnf-notfound-widget' === $sidebar && 'only_404' === $rule ) || ( 'gwnf-bbpress-notfound-area' === $sidebar && in_array( $rule, array( 'only_404', 'only_notfound' ), true ) ) ) {
  return __( 'This search widget has a display rule that does not match this area. Choose Global or a matching rule in its widget settings.', 'genesis-widgetized-notfound' );
 }
 if ( ! empty( $instance['not_in_public'] ) ) {
  return __( 'This search widget is visible only to logged-in users. Visitors will not see it.', 'genesis-widgetized-notfound' );
 }
 return '';
}

/**
 * Show contextual guidance when editing an already assigned search widget.
 * @since 2.0.0
 * @param string $widget_id Current widget instance ID.
 * @param array  $instance Current saved display rules.
 * @return void
 */
function ddw_gwnf_widget_rule_hint( $widget_id, $instance ) {
 foreach ( array( 'gwnf-404-widget', 'gwnf-notfound-widget', 'gwnf-bbpress-notfound-area' ) as $sidebar ) {
  if ( in_array( $widget_id, ddw_gwnf_assigned_widgets( $sidebar ), true ) ) {
   $warning = ddw_gwnf_rule_warning( $sidebar, $instance );
   if ( $warning ) { echo '<p class="gwnf-rule-hint">' . esc_html( $warning ) . '</p>'; }
  }
 }
}

/**
 * Render the site setup overview with distinct editing links and fallback descriptions.
 * Counts describe assignment, not guaranteed visible output from conditional widgets.
 * @since 2.0.0
 * @return void
 */
function ddw_gwnf_render_setup_status() {
 $settings = ddw_gwnf_get_settings();
 $areas = array(
  'gwnf-404-widget' => array( __( '404 page', 'genesis-widgetized-notfound' ), $settings['starter_404'] ? __( 'Optional 404 starter content', 'genesis-widgetized-notfound' ) : __( 'Default Genesis output', 'genesis-widgetized-notfound' ) ),
  'gwnf-notfound-widget' => array( __( 'Search with no results', 'genesis-widgetized-notfound' ), __( 'No-results message and search form', 'genesis-widgetized-notfound' ) ),
 );
 if ( isset( $GLOBALS['wp_registered_sidebars']['gwnf-bbpress-notfound-area'] ) ) { $areas['gwnf-bbpress-notfound-area'] = array( __( 'bbPress search with no results', 'genesis-widgetized-notfound' ), __( 'Default bbPress output', 'genesis-widgetized-notfound' ) ); }
 echo '<section class="gwnf-comfort" aria-labelledby="gwnf-setup-title"><h2 id="gwnf-setup-title">' . esc_html__( 'Setup overview', 'genesis-widgetized-notfound' ) . '</h2><ul class="gwnf-setup-list">';
 $instances = get_option( 'widget_gwnf-search-widget', array() );
 foreach ( $areas as $sidebar => $area ) {
  $ids = ddw_gwnf_assigned_widgets( $sidebar );
  // A neutral count label avoids locale-specific plural grammar.
  $status = $ids ? __( 'Assigned widgets:', 'genesis-widgetized-notfound' ) . ' ' . count( $ids ) : __( 'Empty area:', 'genesis-widgetized-notfound' ) . ' ' . $area[1];
  $url = admin_url( 'widgets.php#' . $sidebar );
  echo '<li><h3>' . esc_html( $area[0] ) . '</h3><p>' . esc_html( $status ) . '</p><a href="' . esc_url( $url ) . '">' . esc_html__( 'Edit this widget area', 'genesis-widgetized-notfound' ) . '<span class="screen-reader-text">: ' . esc_html( $area[0] ) . '</span></a>';
  foreach ( $ids as $id ) {
   if ( preg_match( '/^gwnf-search-widget-([0-9]+)$/', $id, $matches ) ) {
    $instance = is_array( $instances[ $matches[1] ] ?? null ) ? $instances[ $matches[1] ] : array();
    $warning = ddw_gwnf_rule_warning( $sidebar, $instance );
    if ( $warning ) { echo '<p class="gwnf-rule-hint">' . esc_html( $warning ) . '</p>'; }
   }
  }
  echo '</li>';
 }
 echo '</ul><p class="description">' . esc_html__( 'Assigned widgets can have their own visibility rules. An assigned widget that hides itself does not activate the empty-area fallback.', 'genesis-widgetized-notfound' ) . '</p></section>';
}

/**
 * Render opt-in 404 content fields within the existing Settings API form.
 * @since 2.0.0
 * @param array $settings Current sanitized site settings.
 * @return void
 */
function ddw_gwnf_render_starter_fields( $settings ) {
 echo '<h2>' . esc_html__( 'Optional 404 starter content', 'genesis-widgetized-notfound' ) . '</h2><p>' . esc_html__( 'Used only when enabled and no widgets are assigned to the 404 area. Assigned widgets take precedence. Leave the text fields empty to use translated defaults.', 'genesis-widgetized-notfound' ) . '</p><table class="form-table" role="presentation"><tbody>';
 $checks = array( 'starter_404' => __( 'Enable 404 starter content', 'genesis-widgetized-notfound' ), 'starter_404_search' => __( 'Show a search form', 'genesis-widgetized-notfound' ), 'starter_404_home' => __( 'Show a homepage link', 'genesis-widgetized-notfound' ) );
 foreach ( $checks as $key => $label ) {
  echo '<tr><th scope="row">' . esc_html( $label ) . '</th><td><label for="gwnf-' . esc_attr( $key ) . '"><input id="gwnf-' . esc_attr( $key ) . '" type="checkbox" name="gwnf_settings[' . esc_attr( $key ) . ']" value="1" ' . checked( $settings[ $key ], true, false ) . ' /> ' . esc_html( $label ) . '</label></td></tr>';
 }
 echo '<tr><th scope="row"><label for="gwnf-starter-title">' . esc_html__( '404 heading', 'genesis-widgetized-notfound' ) . '</label></th><td><input id="gwnf-starter-title" class="large-text" type="text" name="gwnf_settings[starter_404_title]" value="' . esc_attr( $settings['starter_404_title'] ) . '" placeholder="' . esc_attr__( 'Page not found', 'genesis-widgetized-notfound' ) . '" /></td></tr>';
 echo '<tr><th scope="row"><label for="gwnf-starter-text">' . esc_html__( '404 explanation', 'genesis-widgetized-notfound' ) . '</label></th><td><textarea id="gwnf-starter-text" class="large-text" rows="3" name="gwnf_settings[starter_404_text]" placeholder="' . esc_attr__( 'The page you are looking for could not be found. Please check the address.', 'genesis-widgetized-notfound' ) . '">' . esc_textarea( $settings['starter_404_text'] ) . '</textarea></td></tr></tbody></table>';
}

/**
 * Render direct frontend tests and copyable enabled shortcodes with manual fallback.
 * @since 2.0.0
 * @return void
 */
function ddw_gwnf_render_comfort_tools() {
 echo '<section class="gwnf-comfort" aria-labelledby="gwnf-test-title"><h2 id="gwnf-test-title">' . esc_html__( 'Test in the frontend', 'genesis-widgetized-notfound' ) . '</h2><p>';
 foreach ( array( '404' => __( 'Open 404 test in a new tab', 'genesis-widgetized-notfound' ), 'notfound' => __( 'Open empty-search test in a new tab', 'genesis-widgetized-notfound' ) ) as $context => $label ) {
  echo '<a class="button" target="_blank" rel="noopener noreferrer" href="' . esc_url( ddw_gwnf_get_frontend_test_link( $context ) ) . '">' . esc_html( $label ) . '</a> ';
 }
 echo '</p><p>' . esc_html__( 'These links open normal frontend requests. Also test while logged out, for example in a private browser window. Search plugins or redirects can change the result.', 'genesis-widgetized-notfound' ) . '</p></section>';
 if ( ! shortcode_exists( 'gwnf-search' ) && ! shortcode_exists( 'gwnf-widget-area' ) ) { return; }
 echo '<section class="gwnf-comfort" aria-labelledby="gwnf-shortcodes-title"><h2 id="gwnf-shortcodes-title">' . esc_html__( 'Copy shortcodes', 'genesis-widgetized-notfound' ) . '</h2>';
 $codes = array();
 if ( shortcode_exists( 'gwnf-search' ) ) { $codes['[gwnf-search]'] = __( 'Search form', 'genesis-widgetized-notfound' ); }
 if ( shortcode_exists( 'gwnf-widget-area' ) ) {
  $codes['[gwnf-widget-area area="404"]'] = __( '404 widget area', 'genesis-widgetized-notfound' );
  $codes['[gwnf-widget-area area="notfound"]'] = __( 'Empty-search widget area', 'genesis-widgetized-notfound' );
 }
 foreach ( $codes as $code => $label ) {
  $id = wp_unique_id( 'gwnf-shortcode-' );
  echo '<div class="gwnf-shortcode-row"><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label><input class="code" id="' . esc_attr( $id ) . '" type="text" readonly value="' . esc_attr( $code ) . '" /><button type="button" class="button gwnf-copy" data-copy-target="' . esc_attr( $id ) . '" data-copy-success="' . esc_attr__( 'Copied.', 'genesis-widgetized-notfound' ) . '" data-copy-failure="' . esc_attr__( 'Select and copy the shortcode manually.', 'genesis-widgetized-notfound' ) . '" hidden>' . esc_html__( 'Copy shortcode', 'genesis-widgetized-notfound' ) . '<span class="screen-reader-text">: ' . esc_html( $label ) . '</span></button></div>';
 }
 echo '<p class="description">' . esc_html__( 'Widget-area shortcodes display assigned widgets. They do not insert the optional 404 starter content.', 'genesis-widgetized-notfound' ) . '</p><p id="gwnf-copy-status" role="status" aria-live="polite"></p></section>';
}
