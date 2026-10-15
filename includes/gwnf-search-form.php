<?php
/** Shared accessible search markup. */
defined( 'ABSPATH' ) || exit;
/**
 * Build an accessible search form without inline JavaScript or placeholder values.
 * @since 2.0.0
 * @param array $args Placeholder, button, label, post type and optional form class.
 * @return string Escaped form markup with a unique associated label.
 */
function ddw_gwnf_search_form( $args = array() ) {
 $args = wp_parse_args( $args, array( 'search_text' => '', 'button_text' => '', 'form_label' => '', 'post_type' => '', 'form_class' => '' ) );
 $id = wp_unique_id( 'gwnf-search-' );
 $hidden = '';
 $types = is_array( $args['post_type'] ) ? $args['post_type'] : explode( ',', (string) $args['post_type'] );
 $types = array_values( array_unique( array_filter( array_map( 'sanitize_key', $types ), 'ddw_gwnf_public_search_type' ) ) );
 foreach ( $types as $type ) {
  $hidden .= '<input type="hidden" name="' . ( count( $types ) > 1 ? 'post_type[]' : 'post_type' ) . '" value="' . esc_attr( $type ) . '" />';
 }
 $label = '' !== (string) $args['form_label'] ? $args['form_label'] : __( 'Search this website', 'genesis-widgetized-notfound' );
 $button = '' !== (string) $args['button_text'] ? $args['button_text'] : __( 'Search', 'genesis-widgetized-notfound' );
 $html5 = function_exists( 'genesis_html5' ) && genesis_html5();
 return sprintf(
  '<form method="get" class="searchform search-form %1$s" action="%2$s" role="search"><label class="screen-reader-text gwnf-search-label" for="%3$s">%4$s</label><input type="%5$s" id="%3$s" class="s search-input" name="s" value="%6$s" placeholder="%7$s" />%8$s<input type="submit" class="searchsubmit search-submit" value="%9$s" /></form>',
  esc_attr( $args['form_class'] ), esc_url( home_url( '/' ) ), esc_attr( $id ), esc_html( $label ), $html5 ? 'search' : 'text', esc_attr( get_search_query( false ) ), esc_attr( $args['search_text'] ), $hidden, esc_attr( $button )
 );
}

/**
 * Accept only registered publicly searchable post types for form restrictions.
 * @since 2.0.0
 * @param string $type Post type key.
 * @return bool Whether this post type can be searched publicly.
 */
function ddw_gwnf_public_search_type( $type ) {
 $object = get_post_type_object( $type );
 return $object && $object->public && ! $object->exclude_from_search;
}
