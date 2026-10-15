<?php
/** Search and widget-area shortcodes. Copyright 2012–2026 David Decker – DECKERWEB. */
defined( 'ABSPATH' ) || exit;
add_shortcode( 'gwnf-search', 'ddw_gwnf_shortcode_search' );
add_shortcode( 'gwnf-widget-area', 'ddw_gwnf_shortcode_widget_area' );

/**
 * Render a configurable search shortcode, retaining its original attributes.
 * @since 1.5.0
 * @param array|string $atts Shortcode attributes.
 * @return string Search form wrapper after the existing output filter.
 */
function ddw_gwnf_shortcode_search( $atts ) {
 $atts = shortcode_atts( array(
  'search_text' => apply_filters( 'genesis_search_text', __( 'Search this website', 'genesis-widgetized-notfound' ) . '…' ),
  'button_text' => apply_filters( 'genesis_search_button_text', __( 'Search', 'genesis-widgetized-notfound' ) ),
  'form_label' => '', 'wrapper' => 'div', 'class' => '', 'post_type' => '',
 ), $atts, 'gwnf-search' );
 $wrapper = in_array( $atts['wrapper'], array( 'div', 'section', 'aside', 'nav', 'span' ), true ) ? $atts['wrapper'] : 'div';
 $classes = implode( ' ', array_filter( array_map( 'sanitize_html_class', preg_split( '/\s+/', (string) $atts['class'] ) ) ) );
 $output = '<' . $wrapper . ' class="gwnf-search-area' . ( $classes ? ' ' . esc_attr( $classes ) : '' ) . '">' . ddw_gwnf_search_form( $atts ) . '</' . $wrapper . '>';
 /**
  * Customize complete search shortcode markup.
  * @since 1.5.0
  * @param string $output Form wrapper HTML; return trusted HTML.
  * @param array $atts Resolved shortcode attributes.
  */
 return apply_filters( 'gwnf_filter_shortcode_search', $output, $atts );
}

/**
 * Capture an active plugin widget area; prevent recursive self-embedding.
 * @since 1.5.0
 * @param array|string $atts Attributes with area 404, notfound or bbpress-notfound.
 * @return string Buffered area output, passed through the existing filter.
 */
function ddw_gwnf_shortcode_widget_area( $atts ) {
 static $rendering = array();
 $atts = shortcode_atts( array( 'area' => '' ), $atts, 'gwnf-widget-area' );
 $areas = array( '404' => 'gwnf-404-widget', 'notfound' => 'gwnf-notfound-widget', 'bbpress-notfound' => 'gwnf-bbpress-notfound-area' );
 $area = $atts['area'];
 if ( ! isset( $areas[$area] ) || ! empty( $rendering[$area] ) || ! is_active_sidebar( $areas[$area] ) ) { return ''; }
 $rendering[$area] = true;
 ob_start();
 try {
  if ( '404' === $area ) { gwnf_display_404_widget(); }
  elseif ( 'notfound' === $area ) { gwnf_display_notfound_widget(); }
  else { echo '<div class="gwnf-bbpress-notfound-area entry-content">'; dynamic_sidebar( $areas[$area] ); echo '</div>'; }
  $output = ob_get_contents();
 } finally { ob_end_clean(); unset( $rendering[$area] ); }
 /**
  * Customize captured widget-area shortcode output.
  * @since 1.5.0
  * @param string $output Captured widget HTML; return trusted HTML.
  * @param array $atts Resolved area attribute.
  */
 return apply_filters( 'gwnf_filter_shortcode_widget_area', $output, $atts );
}
