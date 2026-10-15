<?php
/** Optional bbPress empty-search integration. */
defined( 'ABSPATH' ) || exit;

/**
 * Register a narrowly scoped template replacement without changing the_content.
 * @since 1.5.0
 * @return void
 */
function ddw_gwnf_bbpress_search_actions() {
 add_filter( 'bbp_get_template_part', 'ddw_gwnf_bbpress_noresults_template_logic', 10, 3 );
 bbp_register_template_stack( 'ddw_gwnf_bbpress_template_directory', 5 );
}

/**
 * Supply this plugin's private template location to the bbPress template stack.
 * @since 2.0.0
 * @return string Absolute local template directory.
 */
function ddw_gwnf_bbpress_template_directory() { return GWNF_PLUGIN_DIR . 'templates'; }

/**
 * Register the existing optional forum-search sidebar ID.
 * @since 1.5.0
 * @return void
 */
function ddw_gwnf_bbpress_widgetized_noresults_area() {
 /** Filter forum-search sidebar name. @since 1.5.0 @param string $name Plain sidebar title. */
 $name = apply_filters( 'gwnf/filter/widget_areas/bbpress-notfound/title', __( 'bbPress: Forum Search No Results', 'genesis-widgetized-notfound' ) );
 /** Filter forum-search sidebar description. @since 1.5.0 @param string $description Sidebar help text. */
 $description = apply_filters( 'gwnf/filter/widget_areas/bbpress-notfound/description', __( 'Widgetized content when the forum search returns no results.', 'genesis-widgetized-notfound' ) );
 register_sidebar( array( 'id' => 'gwnf-bbpress-notfound-area', 'name' => esc_html( $name ), 'description' => esc_html( $description ),
  'before_widget' => '<div id="%1$s" class="widget gwnf-bbpress-widgetized-noresults %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3 class="widgettitle">', 'after_title' => '</h3>' ) );
}

/**
 * Replace only the empty-search feedback when the forum widget area has content.
 * @since 1.5.0
 * @param array $templates Candidate template names.
 * @param string $slug Requested template slug.
 * @param string|null $name Requested template suffix.
 * @return array Replacement or original candidates; bbPress wrappers stay intact.
 */
function ddw_gwnf_bbpress_noresults_template_logic( $templates, $slug, $name ) {
 if ( 'feedback' === $slug && 'no-search' === $name && bbp_is_search() && is_active_sidebar( 'gwnf-bbpress-notfound-area' ) ) {
  return array( 'gwnf-feedback-no-search.php' );
 }
 return $templates;
}

/**
 * Output only the forum empty-search widgets inside bbPress's existing wrapper.
 * @since 1.5.0
 * @return void
 */
function ddw_gwnf_bbpress_widgetized_noresults_content() {
 echo '<div id="gwnf-bbpress-widgetized-content" class="gwnf-bbpress-notfound-area entry-content">';
 dynamic_sidebar( 'gwnf-bbpress-notfound-area' );
 echo '</div>';
}
